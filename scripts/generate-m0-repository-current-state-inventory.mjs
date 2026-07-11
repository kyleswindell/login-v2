/**
 * ============================================================================
 * File: scripts/generate-m0-repository-current-state-inventory.mjs
 * Purpose: Generate deterministic raw evidence, seed/preserve reviewed
 * classifications, and render the canonical issue #29 inventory document.
 * ============================================================================
 */

import {
  existsSync,
  mkdirSync,
  readFileSync,
  statSync,
  writeFileSync,
} from 'node:fs';
import { execFileSync, spawnSync } from 'node:child_process';
import {
  basename,
  dirname,
  extname,
  join,
  relative,
  resolve,
} from 'node:path';
import process from 'node:process';

const DEFAULT_BASELINE =
  '1d103f5fa47aab8c8adfba8ea134dd29540426fe';
const CHARTER_BASELINE =
  'f906e0520e12b5f9eb93b9d35934407c2bbba366';

const INVENTORY_DOCUMENT =
  'docs/07-planning/00-overview/m0-repository-current-state-inventory.md';
const EVIDENCE_DIRECTORY =
  'docs/07-planning/00-overview/evidence';
const RAW_EVIDENCE_FILE = `${EVIDENCE_DIRECTORY}/m0-repository-current-state-raw.json`;
const CLASSIFICATIONS_FILE = `${EVIDENCE_DIRECTORY}/m0-repository-current-state-classifications.json`;

const ALLOWED_WORKTREE_PATHS = new Set([
  INVENTORY_DOCUMENT,
  RAW_EVIDENCE_FILE,
  CLASSIFICATIONS_FILE,
  'scripts/generate-m0-repository-current-state-inventory.mjs',
  'scripts/check-m0-repository-current-state-inventory.mjs',
  'docs/07-planning/index.md',
  'package.json',
]);

const REQUIRED_FIELDS = [
  'path_or_identifier',
  'surface_type',
  'ownership_area',
  'owner_key',
  'capability_key',
  'module_key',
  'ownership_status',
  'current_responsibility',
  'authority_state',
  'registration_state',
  'related_contracts',
  'related_tests',
  'evidence_source',
  'known_contradictions',
  'disposition',
  'target_question',
];

const OWNERSHIP_STATUSES = new Set([
  'owned',
  'shared',
  'unowned',
  'duplicate',
  'ambiguous',
  'investigate',
]);

const AUTHORITY_STATES = new Set([
  'canonical',
  'active',
  'compatibility',
  'planning',
  'historical',
  'superseded',
  'generated',
  'vendor',
  'temporary',
  'unknown',
]);

const REGISTRATION_STATES = new Set([
  'present',
  'registered',
  'reachable',
  'invoked',
  'unknown',
  'not_applicable',
]);

const DISPOSITIONS = new Set([
  'retain',
  'investigate',
  'compatibility',
  'duplicate',
]);

const APPLICATION_OWNERSHIP_AREAS = new Set([
  'core',
  'module',
  'ui',
  'not_applicable',
]);

const TEXT_EXTENSIONS = new Set([
  '.blade.php',
  '.css',
  '.env.example',
  '.html',
  '.js',
  '.json',
  '.jsx',
  '.md',
  '.mjs',
  '.php',
  '.ps1',
  '.scss',
  '.sh',
  '.sql',
  '.svg',
  '.ts',
  '.tsx',
  '.txt',
  '.xml',
  '.yaml',
  '.yml',
]);

const BUILD_TOOL_FILES = new Set([
  '.editorconfig',
  '.env.example',
  '.gitattributes',
  '.gitignore',
  'Dockerfile',
  'artisan',
  'composer.json',
  'composer.lock',
  'docker-compose.yml',
  'docker-compose.yaml',
  'package.json',
  'package-lock.json',
  'phpunit.xml',
  'playwright.config.js',
  'playwright.config.ts',
  'postcss.config.js',
  'tailwind.config.js',
  'vite.config.js',
  'vite.config.ts',
]);

const RUNTIME_DIRECTORY_PATTERNS = [
  ['/Middleware/', 'middleware'],
  ['/Console/Commands/', 'command'],
  ['/Commands/', 'command'],
  ['/Jobs/', 'job'],
  ['/Events/', 'event'],
  ['/Listeners/', 'listener'],
  ['/Notifications/', 'notification'],
  ['/Policies/', 'policy'],
  ['/Providers/', 'provider'],
];

const args = parseArguments(process.argv.slice(2));
let repositoryRoot = process.cwd();
repositoryRoot = resolve(
  runRequired('git', ['rev-parse', '--show-toplevel']).stdout.trim(),
);
process.chdir(repositoryRoot);

const baseline = args.baseline ?? DEFAULT_BASELINE;
assertCommitExists(baseline);
assertCommitExists(CHARTER_BASELINE);
assertInventoryScope(baseline, args.allowExtraChanges);

const baselineCommitDate = runRequired('git', [
  'show',
  '-s',
  '--format=%cI',
  baseline,
]).stdout.trim();

const currentHead = runRequired('git', ['rev-parse', 'HEAD']).stdout.trim();
const baselineFiles = readBaselineTree(baseline);
const baselinePathSet = new Set(baselineFiles.map((file) => file.path));
const materialItems = new Map();
const termFlags = [];
const documentMetadata = new Map();
const namespaceMap = new Map();
const purposeMap = new Map();

for (const file of baselineFiles) {
  if (!isTextFile(file.path, file.size)) {
    continue;
  }

  const content = readBaselineText(baseline, file.path);

  if (content === null) {
    continue;
  }

  const metadata = parseDocumentMetadata(content);
  const namespace = parsePhpNamespace(content);
  const purpose = parsePurpose(content, metadata);

  if (metadata !== null) {
    documentMetadata.set(file.path, metadata);
  }

  if (namespace !== null) {
    namespaceMap.set(file.path, namespace);
  }

  if (purpose !== null) {
    purposeMap.set(file.path, purpose);
  }

  termFlags.push(...findTermFlags(file.path, content));

  if (isMaterialFile(file.path, metadata)) {
    addMaterialItem(
      materialItems,
      createPathMaterialItem({
        file,
        metadata,
        namespace,
        purpose,
        content,
      }),
    );
  }
}

for (const item of createDirectoryMaterialItems(baselineFiles)) {
  addMaterialItem(materialItems, item);
}

for (const item of createGeneratedBoundaryItems(
  baseline,
  baselinePathSet.has('.gitignore')
    ? readBaselineText(baseline, '.gitignore')
    : null,
)) {
  addMaterialItem(materialItems, item);
}

const staticRuntimeEvidence = collectStaticRuntimeEvidence(
  baseline,
  baselinePathSet,
);

for (const item of staticRuntimeEvidence.items) {
  addMaterialItem(materialItems, item);
}

const dynamicEvidence = args.staticOnly
  ? createPreservedDynamicEvidence(baseline)
  : collectDynamicRuntimeEvidence();

for (const item of dynamicEvidence.items) {
  addMaterialItem(materialItems, item);
}

const moduleSummaryByKey = new Map(
  dynamicEvidence.modules.map((module) => [
    String(module.key ?? ''),
    module,
  ]),
);

const rawEvidence = {
  schema_version: 1,
  baseline: {
    sha: baseline,
    committed_at: baselineCommitDate,
    ref: 'main',
    charter_baseline_sha: CHARTER_BASELINE,
    current_head_at_generation: currentHead,
    runtime_equivalence:
      'Repository changes between the charter baseline and inventory baseline are governance/documentation changes; runtime source is unchanged.',
  },
  generator: {
    path: 'scripts/generate-m0-repository-current-state-inventory.mjs',
    command: `node scripts/generate-m0-repository-current-state-inventory.mjs --baseline ${baseline}`,
    generated_at: new Date().toISOString(),
    static_only: Boolean(args.staticOnly),
  },
  repository: {
    tracked_file_count: baselineFiles.length,
    top_level_counts: countBy(baselineFiles, (file) =>
      file.path.includes('/') ? file.path.split('/')[0] : '[root]',
    ),
    extension_counts: countBy(baselineFiles, (file) =>
      extensionFor(file.path),
    ),
    namespace_counts: countBy(
      [...namespaceMap.values()].map((namespace) => ({ namespace })),
      (entry) => namespaceRoot(entry.namespace),
    ),
  },
  baseline_files: baselineFiles,
  document_metadata: Object.fromEntries(
    [...documentMetadata.entries()].sort(([left], [right]) =>
      left.localeCompare(right),
    ),
  ),
  namespaces: Object.fromEntries(
    [...namespaceMap.entries()].sort(([left], [right]) =>
      left.localeCompare(right),
    ),
  ),
  safe_purposes: Object.fromEntries(
    [...purposeMap.entries()].sort(([left], [right]) =>
      left.localeCompare(right),
    ),
  ),
  term_flags: termFlags.sort(compareTermFlags),
  static_runtime_evidence: staticRuntimeEvidence.summary,
  dynamic_runtime_evidence: dynamicEvidence.summary,
  material_items: [...materialItems.values()].sort(compareMaterialItems),
};

mkdirSync(resolve(EVIDENCE_DIRECTORY), { recursive: true });
writeJson(resolve(RAW_EVIDENCE_FILE), rawEvidence);

const classifications = mergeClassifications({
  baseline,
  rawItems: rawEvidence.material_items,
  existingPath: resolve(CLASSIFICATIONS_FILE),
  moduleSummaryByKey,
  reset: Boolean(args.resetClassifications),
});

writeJson(resolve(CLASSIFICATIONS_FILE), classifications);

if (!args.noRender) {
  renderInventoryDocument({
    documentPath: resolve(INVENTORY_DOCUMENT),
    rawEvidence,
    classifications,
  });
}

console.log(
  [
    `Generated raw evidence for ${baselineFiles.length} tracked file(s).`,
    `Material inventory item(s): ${rawEvidence.material_items.length}.`,
    `Reviewed classification(s): ${
      classifications.items.filter((item) => item._reviewed === true).length
    }/${classifications.items.length}.`,
    `Raw evidence: ${RAW_EVIDENCE_FILE}`,
    `Classifications: ${CLASSIFICATIONS_FILE}`,
    `Document: ${INVENTORY_DOCUMENT}`,
  ].join('\n'),
);

function parseArguments(values) {
  const parsed = {
    baseline: null,
    allowExtraChanges: false,
    staticOnly: false,
    noRender: false,
    resetClassifications: false,
  };

  for (let index = 0; index < values.length; index += 1) {
    const value = values[index];

    if (value === '--baseline') {
      parsed.baseline = values[index + 1] ?? null;
      index += 1;
      continue;
    }

    if (value === '--allow-extra-changes') {
      parsed.allowExtraChanges = true;
      continue;
    }

    if (value === '--static-only') {
      parsed.staticOnly = true;
      continue;
    }

    if (value === '--no-render') {
      parsed.noRender = true;
      continue;
    }

    if (value === '--render-only') {
      parsed.staticOnly = true;
      continue;
    }

    if (value === '--reset-classifications') {
      parsed.resetClassifications = true;
      continue;
    }

    throw new Error(`Unknown argument: ${value}`);
  }

  return parsed;
}

function runRequired(command, commandArgs, options = {}) {
  const result = spawnSync(command, commandArgs, {
    cwd: repositoryRoot ?? process.cwd(),
    encoding: 'utf8',
    maxBuffer: 64 * 1024 * 1024,
    windowsHide: true,
    ...options,
  });

  if (result.error) {
    throw result.error;
  }

  if (result.status !== 0) {
    throw new Error(
      [
        `Command failed: ${command} ${commandArgs.join(' ')}`,
        sanitizeCommandOutput(result.stderr || result.stdout),
      ].join('\n'),
    );
  }

  return {
    status: result.status,
    stdout: result.stdout ?? '',
    stderr: result.stderr ?? '',
  };
}

function runOptional(command, commandArgs) {
  const result = spawnSync(command, commandArgs, {
    cwd: repositoryRoot,
    encoding: 'utf8',
    maxBuffer: 64 * 1024 * 1024,
    windowsHide: true,
    timeout: 120_000,
  });

  if (result.error) {
    return {
      status: 'unavailable',
      exit_code: null,
      command: `${command} ${commandArgs.join(' ')}`,
      stdout: '',
      stderr: sanitizeCommandOutput(result.error.message),
    };
  }

  return {
    status: result.status === 0 ? 'passed' : 'failed',
    exit_code: result.status,
    command: `${command} ${commandArgs.join(' ')}`,
    stdout: result.stdout ?? '',
    stderr: sanitizeCommandOutput(result.stderr ?? ''),
  };
}

function sanitizeCommandOutput(value) {
  return String(value)
    .replace(/(APP_KEY|PASSWORD|TOKEN|SECRET|PRIVATE_KEY)\s*=\s*[^\s]+/gi, '$1=[REDACTED]')
    .slice(0, 4_000);
}

function assertCommitExists(commit) {
  runRequired('git', ['cat-file', '-e', `${commit}^{commit}`]);
}

function assertInventoryScope(commit, allowExtraChanges) {
  if (allowExtraChanges) {
    return;
  }

  const changed = new Set(
    runRequired('git', ['diff', '--name-only', commit, '--'])
      .stdout.split(/\r?\n/)
      .map(normalizePath)
      .filter(Boolean),
  );

  const untracked = new Set(
    runRequired('git', ['ls-files', '--others', '--exclude-standard'])
      .stdout.split(/\r?\n/)
      .map(normalizePath)
      .filter(Boolean),
  );

  const unexpected = [...new Set([...changed, ...untracked])]
    .filter((path) => !ALLOWED_WORKTREE_PATHS.has(path))
    .sort();

  if (unexpected.length > 0) {
    throw new Error(
      [
        'Issue #29 generator found changes outside the accepted inventory scope:',
        ...unexpected.map((path) => `- ${path}`),
        'Use a clean branch or pass --allow-extra-changes only after explicit review.',
      ].join('\n'),
    );
  }
}

function readBaselineTree(commit) {
  const output = execFileSync(
    'git',
    ['ls-tree', '-r', '-z', '-l', commit],
    {
      cwd: repositoryRoot,
      encoding: 'buffer',
      maxBuffer: 128 * 1024 * 1024,
      windowsHide: true,
    },
  );

  return output
    .toString('utf8')
    .split('\0')
    .filter(Boolean)
    .map((entry) => {
      const match = entry.match(
        /^(\d+)\s+(\w+)\s+([0-9a-f]+)\s+(-|\d+)\t(.+)$/,
      );

      if (match === null) {
        throw new Error(`Unable to parse git tree entry: ${entry}`);
      }

      return {
        mode: match[1],
        type: match[2],
        object_sha: match[3],
        size: match[4] === '-' ? null : Number(match[4]),
        path: normalizePath(match[5]),
      };
    })
    .sort((left, right) => left.path.localeCompare(right.path));
}

function readBaselineText(commit, path) {
  try {
    return execFileSync('git', ['show', `${commit}:${path}`], {
      cwd: repositoryRoot,
      encoding: 'utf8',
      maxBuffer: 8 * 1024 * 1024,
      windowsHide: true,
    });
  } catch {
    return null;
  }
}

function isTextFile(path, size) {
  if (size !== null && size > 2 * 1024 * 1024) {
    return false;
  }

  if (BUILD_TOOL_FILES.has(path)) {
    return true;
  }

  const lower = path.toLowerCase();

  if (
    lower.endsWith('.blade.php') ||
    lower.endsWith('.env.example')
  ) {
    return true;
  }

  return TEXT_EXTENSIONS.has(extname(lower));
}

function extensionFor(path) {
  const lower = path.toLowerCase();

  if (lower.endsWith('.blade.php')) {
    return '.blade.php';
  }

  if (lower.endsWith('.env.example')) {
    return '.env.example';
  }

  return extname(lower) || '[none]';
}

function parseDocumentMetadata(content) {
  const match = content.match(/<!--\s*\nDOC-META\s*\n([\s\S]*?)-->/);

  if (match === null) {
    return null;
  }

  const metadata = {};

  for (const line of match[1].split(/\r?\n/)) {
    const separator = line.indexOf(':');

    if (separator < 1) {
      continue;
    }

    const key = line.slice(0, separator).trim();
    const value = line.slice(separator + 1).trim();

    if (key !== '') {
      metadata[key] = value;
    }
  }

  return metadata;
}

function parsePhpNamespace(content) {
  const match = content.match(/^\s*namespace\s+([^;]+);/m);

  return match?.[1]?.trim() ?? null;
}

function parsePurpose(content, metadata) {
  if (metadata?.summary) {
    return metadata.summary;
  }

  const purpose = content.match(/Purpose:\s*(.+)/i);

  if (purpose?.[1]) {
    return purpose[1].trim().replace(/\s*\*\/\s*$/, '');
  }

  const headingIndex = content.search(/^#\s+/m);

  if (headingIndex >= 0) {
    const afterHeading = content
      .slice(headingIndex)
      .split(/\r?\n/)
      .slice(1)
      .join('\n')
      .trim();

    const paragraph = afterHeading
      .split(/\r?\n\s*\r?\n/)
      .map((value) => value.trim())
      .find(
        (value) =>
          value !== '' &&
          !value.startsWith('Parent:') &&
          !value.startsWith('- ['),
      );

    if (paragraph) {
      return paragraph.replace(/\s+/g, ' ').slice(0, 500);
    }
  }

  return null;
}

function findTermFlags(path, content) {
  const patterns = [
    {
      key: 'platform_key',
      pattern: /\bplatform\.[a-z0-9_.-]+/gi,
      note: 'Transitional platform.* key or route namespace.',
    },
    {
      key: 'app_platform_namespace',
      pattern: /App\\Platform\\/g,
      note: 'Transitional App\\Platform namespace.',
    },
    {
      key: 'platform_management_category',
      pattern: /Category::PlatformManagement/g,
      note: 'Retired PlatformManagement ownership category remains in current code.',
    },
    {
      key: 'service_identity_term',
      pattern: /\bservice identity\b/gi,
      note: 'Superseded Service Identity umbrella terminology.',
    },
    {
      key: 'owner_layer_term',
      pattern: /\bowner layer\b/gi,
      note: 'Superseded owner-layer terminology.',
    },
    {
      key: 'active_batch_surface',
      pattern: /active-batch|docs\/08-active/gi,
      note: 'Historical active-batch workflow surface.',
    },
  ];

  const flags = [];
  const lines = content.split(/\r?\n/);

  for (const definition of patterns) {
    for (let index = 0; index < lines.length; index += 1) {
      const matches = lines[index].match(definition.pattern);

      if (!matches) {
        continue;
      }

      flags.push({
        path,
        line: index + 1,
        key: definition.key,
        note: definition.note,
        matches: [...new Set(matches)].sort(),
      });
    }
  }

  return flags;
}

function isMaterialFile(path, metadata) {
  if (!path.includes('/')) {
    return true;
  }

  if (
    path === 'AGENTS.md' ||
    path.endsWith('/AGENTS.md') ||
    path.startsWith('.agents/')
  ) {
    return true;
  }

  if (
    path.startsWith('routes/') ||
    path.startsWith('config/') ||
    path.startsWith('scripts/') ||
    path.startsWith('ops/')
  ) {
    return true;
  }

  if (
    path.startsWith('stubs/') &&
    (path.endsWith('README.md') ||
      path.endsWith('AGENTS.md') ||
      basename(path).startsWith('_'))
  ) {
    return true;
  }

  if (
    path.startsWith('bootstrap/') ||
    path === 'app/Providers/AppServiceProvider.php' ||
    path.startsWith('app/Core/Modules/')
  ) {
    return true;
  }

  if (
    path.startsWith('Modules/') &&
    (path.endsWith('/Definition.php') ||
      path.endsWith('/composer.json') ||
      path.includes('/routes/') ||
      path.includes('/Providers/'))
  ) {
    return true;
  }

  if (RUNTIME_DIRECTORY_PATTERNS.some(([needle]) => path.includes(needle))) {
    return true;
  }

  if (path.startsWith('docs/')) {
    return (
      path.endsWith('/index.md') ||
      path.endsWith('/AGENTS.md') ||
      metadata?.canonical === 'true' ||
      metadata?.doc_type === 'index'
    );
  }

  return false;
}

function createPathMaterialItem({
  file,
  metadata,
  namespace,
  purpose,
  content,
}) {
  const surfaceType = surfaceTypeForPath(file.path);
  const termContradictions = contradictionsForPath(file.path, content);
  const authorityState = authorityStateForPath(file.path, metadata);
  const responsibility =
    purpose ??
    defaultResponsibilityForPath(file.path, surfaceType);

  return {
    path_or_identifier: file.path,
    source_kind: 'path',
    surface_type: surfaceType,
    namespace,
    safe_purpose: responsibility,
    authority_state: authorityState,
    registration_state: registrationStateForPath(file.path),
    evidence_source: [
      `git:${file.object_sha}`,
      `path:${file.path}`,
    ],
    known_contradictions: termContradictions,
    suggested_target_question: targetQuestionFor(
      file.path,
      termContradictions,
    ),
  };
}

function createDirectoryMaterialItems(files) {
  const directories = new Set();

  for (const file of files) {
    const parts = file.path.split('/');

    if (parts.length > 1) {
      directories.add(parts[0]);
    }

    if (
      ['app', 'Modules', 'docs', '.agents', 'resources'].includes(
        parts[0],
      ) &&
      parts.length > 2
    ) {
      directories.add(parts.slice(0, 2).join('/'));
    }

    if (
      parts[0] === 'app' &&
      ['Core', 'Platform', 'Surfaces', 'Http'].includes(parts[1]) &&
      parts.length > 3
    ) {
      directories.add(parts.slice(0, 3).join('/'));
    }

    if (
      parts[0] === 'resources' &&
      ['views', 'css', 'js'].includes(parts[1]) &&
      parts.length > 3
    ) {
      directories.add(parts.slice(0, 3).join('/'));
    }

    if (
      parts[0] === '.agents' &&
      ['skills', 'memory', 'baselines'].includes(parts[1]) &&
      parts.length > 3
    ) {
      directories.add(parts.slice(0, 3).join('/'));
    }
  }

  return [...directories]
    .sort()
    .map((directory) => {
      const count = files.filter(
        (file) =>
          file.path === directory ||
          file.path.startsWith(`${directory}/`),
      ).length;
      const contradictions = contradictionsForPath(directory, '');

      return {
        path_or_identifier: `dir:${directory}`,
        source_kind: 'directory',
        surface_type: surfaceTypeForDirectory(directory),
        namespace: null,
        safe_purpose: `Baseline subtree containing ${count} tracked file(s).`,
        authority_state: authorityStateForDirectory(directory),
        registration_state: 'not_applicable',
        evidence_source: [
          `git-tree:${directory}`,
          `tracked-file-count:${count}`,
        ],
        known_contradictions: contradictions,
        suggested_target_question: targetQuestionFor(
          directory,
          contradictions,
        ),
      };
    });
}

function createGeneratedBoundaryItems(commit, gitignoreContent) {
  if (!gitignoreContent) {
    return [];
  }

  return gitignoreContent
    .split(/\r?\n/)
    .map((line) => line.trim())
    .filter(
      (line) =>
        line !== '' &&
        !line.startsWith('#') &&
        !line.startsWith('!'),
    )
    .map((pattern) => ({
      path_or_identifier: `boundary:${pattern}`,
      source_kind: 'generated_boundary',
      surface_type: 'generated_output',
      namespace: null,
      safe_purpose:
        'Ignored dependency, secret, local state, runtime, test artifact, generated output, editor state, or operating-system boundary.',
      authority_state: 'generated',
      registration_state: 'not_applicable',
      evidence_source: [
        `git:${commit}:.gitignore`,
        `ignore-pattern:${pattern}`,
      ],
      known_contradictions: [],
      suggested_target_question: null,
    }));
}

function collectStaticRuntimeEvidence(commit, pathSet) {
  const items = [];
  const summary = {
    route_files: [],
    provider_classes: [],
    global_middleware: [],
    artisan_closure_commands: [],
  };

  for (const routeFile of [
    'routes/web.php',
    'routes/console.php',
    'routes/channels.php',
  ]) {
    if (pathSet.has(routeFile)) {
      summary.route_files.push(routeFile);
    }
  }

  const providersContent = pathSet.has('bootstrap/providers.php')
    ? readBaselineText(commit, 'bootstrap/providers.php')
    : null;

  if (providersContent) {
    const providerMatches = [
      ...providersContent.matchAll(
        /([A-Za-z_][A-Za-z0-9_\\]+)::class/g,
      ),
    ];

    for (const match of providerMatches) {
      const className = match[1];
      summary.provider_classes.push(className);
      items.push({
        path_or_identifier: `provider:${className}`,
        source_kind: 'runtime_provider',
        surface_type: 'provider',
        namespace: className.includes('\\')
          ? className.split('\\').slice(0, -1).join('\\')
          : null,
        safe_purpose: `Application provider registered by bootstrap/providers.php: ${className}.`,
        authority_state: 'active',
        registration_state: 'registered',
        evidence_source: [
          'path:bootstrap/providers.php',
          `provider-class:${className}`,
        ],
        known_contradictions: contradictionsForPath(className, className),
        suggested_target_question: null,
      });
    }
  }

  const bootstrapContent = pathSet.has('bootstrap/app.php')
    ? readBaselineText(commit, 'bootstrap/app.php')
    : null;

  if (bootstrapContent) {
    const middlewareMatches = [
      ...bootstrapContent.matchAll(
        /\$middleware->(?:prepend|append)\(([^:]+)::class\)/g,
      ),
    ];

    for (const match of middlewareMatches) {
      const shortClass = match[1].trim();
      const useMatch = bootstrapContent.match(
        new RegExp(
          `use\\s+([^;\\\\]+(?:\\\\\\\\[^;]+)*\\\\\\\\${escapeRegex(shortClass)});`,
        ),
      );
      const className = useMatch?.[1] ?? shortClass;

      summary.global_middleware.push(className);
      items.push({
        path_or_identifier: `middleware:${className}`,
        source_kind: 'runtime_middleware',
        surface_type: 'middleware',
        namespace: className.includes('\\')
          ? className.split('\\').slice(0, -1).join('\\')
          : null,
        safe_purpose: `Global middleware registered by bootstrap/app.php: ${className}.`,
        authority_state: 'active',
        registration_state: 'registered',
        evidence_source: [
          'path:bootstrap/app.php',
          `middleware-class:${className}`,
        ],
        known_contradictions: contradictionsForPath(className, className),
        suggested_target_question: null,
      });
    }
  }

  const consoleContent = pathSet.has('routes/console.php')
    ? readBaselineText(commit, 'routes/console.php')
    : null;

  if (consoleContent) {
    const commandMatches = [
      ...consoleContent.matchAll(/Artisan::command\(\s*'([^'\r\n]+)/g),
    ];

    for (const match of commandMatches) {
      const signature = match[1].trim();
      summary.artisan_closure_commands.push(signature);
      const contradictions = contradictionsForPath(
        `command:${signature}`,
        signature,
      );

      items.push({
        path_or_identifier: `command:${signature}`,
        source_kind: 'runtime_command_static',
        surface_type: 'command',
        namespace: null,
        safe_purpose: `Artisan closure command declared in routes/console.php: ${signature}.`,
        authority_state:
          signature.startsWith('active-batch-review:')
            ? 'compatibility'
            : 'active',
        registration_state: 'present',
        evidence_source: [
          'path:routes/console.php',
          `command-signature:${signature}`,
        ],
        known_contradictions: contradictions,
        suggested_target_question: targetQuestionFor(
          signature,
          contradictions,
        ),
      });
    }
  }

  summary.route_files.sort();
  summary.provider_classes.sort();
  summary.global_middleware.sort();
  summary.artisan_closure_commands.sort();

  return { items, summary };
}

function createPreservedDynamicEvidence(baseline) {
  if (existsSync(resolve(RAW_EVIDENCE_FILE))) {
    const existing = JSON.parse(
      readFileSync(resolve(RAW_EVIDENCE_FILE), 'utf8'),
    );

    if (existing.baseline?.sha === baseline) {
      const items = (existing.material_items ?? []).filter((item) =>
        String(item.source_kind).endsWith('_dynamic'),
      );

      return {
        items,
        modules: items
          .filter((item) => item.source_kind === 'runtime_module_dynamic')
          .map((item) => item.runtime_metadata)
          .filter(Boolean),
        summary: existing.dynamic_runtime_evidence,
      };
    }
  }

  return {
    items: [],
    modules: [],
    summary: {
      route_list: {
        status: 'skipped',
        command: 'php artisan route:list --json',
      },
      artisan_list: {
        status: 'skipped',
        command: 'php artisan list --format=json',
      },
      module_list: {
        status: 'skipped',
        command: 'php artisan platform:modules:list --json',
      },
    },
  };
}

function collectDynamicRuntimeEvidence() {
  const items = [];
  const modules = [];

  const routeResult = runOptional('php', [
    'artisan',
    'route:list',
    '--json',
  ]);
  const artisanResult = runOptional('php', [
    'artisan',
    'list',
    '--format=json',
  ]);
  const moduleResult = runOptional('php', [
    'artisan',
    'platform:modules:list',
    '--json',
  ]);

  if (routeResult.status === 'passed') {
    const routes = parseJsonSafely(routeResult.stdout);

    if (Array.isArray(routes)) {
      for (const route of routes) {
        const methods = normalizeRouteMethods(route.method);
        const name =
          typeof route.name === 'string' && route.name !== ''
            ? route.name
            : `${methods.join('|')} ${route.uri ?? '[unknown]'}`;
        const contradictions = contradictionsForPath(
          `route:${name}`,
          `${name} ${route.uri ?? ''} ${route.action ?? ''}`,
        );

        items.push({
          path_or_identifier: `route:${name}`,
          source_kind: 'runtime_route_dynamic',
          surface_type: 'route',
          namespace: namespaceFromAction(route.action),
          safe_purpose: `${methods.join('|')} ${route.uri ?? '[unknown]'} -> ${route.action ?? '[closure]'}.`,
          authority_state: 'active',
          registration_state: 'registered',
          evidence_source: [
            'command:php artisan route:list --json',
            `route-name:${route.name ?? '[unnamed]'}`,
            `route-uri:${route.uri ?? '[unknown]'}`,
          ],
          known_contradictions: contradictions,
          suggested_target_question: targetQuestionFor(
            name,
            contradictions,
          ),
          runtime_metadata: {
            methods,
            uri: route.uri ?? null,
            name: route.name ?? null,
            action: route.action ?? null,
            middleware: normalizeStringList(route.middleware),
          },
        });
      }
    }
  }

  if (artisanResult.status === 'passed') {
    const payload = parseJsonSafely(artisanResult.stdout);
    const commands = Array.isArray(payload?.commands)
      ? payload.commands
      : [];

    for (const command of commands) {
      const name = String(command.name ?? '').trim();

      if (
        name === '' ||
        !isApplicationCommandName(name)
      ) {
        continue;
      }

      const identifier = `command:${name}`;
      const contradictions = contradictionsForPath(identifier, name);

      items.push({
        path_or_identifier: identifier,
        source_kind: 'runtime_command_dynamic',
        surface_type: 'command',
        namespace: null,
        safe_purpose:
          String(command.description ?? '').trim() ||
          `Registered Artisan command: ${name}.`,
        authority_state: name.startsWith('active-batch-review:')
          ? 'compatibility'
          : 'active',
        registration_state: 'registered',
        evidence_source: [
          'command:php artisan list --format=json',
          `command-signature:${name}`,
        ],
        known_contradictions: contradictions,
        suggested_target_question: targetQuestionFor(
          name,
          contradictions,
        ),
      });
    }
  }

  if (moduleResult.status === 'passed') {
    const payload = parseJsonSafely(moduleResult.stdout);
    const foundModules = Array.isArray(payload?.modules)
      ? payload.modules
      : [];

    for (const module of foundModules) {
      const key = String(module.key ?? '').trim();

      if (key === '') {
        continue;
      }

      modules.push(module);
      const type = String(module.type ?? 'unknown');
      const contradictions = [];

      if (type === 'platform_management') {
        contradictions.push(
          'Current module registry uses the retired platform_management category.',
        );
      }

      items.push({
        path_or_identifier: `module:${key}`,
        source_kind: 'runtime_module_dynamic',
        surface_type: 'module',
        namespace: null,
        safe_purpose: `Registered module manifest ${key} (${type}).`,
        authority_state: 'active',
        registration_state: 'registered',
        evidence_source: [
          'command:php artisan platform:modules:list --json',
          `module-key:${key}`,
        ],
        known_contradictions: contradictions,
        suggested_target_question:
          contradictions.length > 0
            ? 'Which accepted Core or Module classification replaces the current platform_management category?'
            : null,
        runtime_metadata: module,
      });
    }
  }

  return {
    items,
    modules,
    summary: {
      route_list: commandEvidenceSummary(routeResult),
      artisan_list: commandEvidenceSummary(artisanResult),
      module_list: commandEvidenceSummary(moduleResult),
    },
  };
}

function commandEvidenceSummary(result) {
  return {
    status: result.status,
    exit_code: result.exit_code,
    command: result.command,
    stderr: result.stderr,
  };
}

function parseJsonSafely(value) {
  try {
    return JSON.parse(value);
  } catch {
    return null;
  }
}

function normalizeRouteMethods(value) {
  if (Array.isArray(value)) {
    return value.map(String).sort();
  }

  if (typeof value === 'string') {
    return value
      .split('|')
      .map((method) => method.trim())
      .filter(Boolean)
      .sort();
  }

  return ['UNKNOWN'];
}

function normalizeStringList(value) {
  if (Array.isArray(value)) {
    return value.map(String).sort();
  }

  if (typeof value === 'string' && value !== '') {
    return [value];
  }

  return [];
}

function namespaceFromAction(value) {
  if (typeof value !== 'string' || !value.includes('\\')) {
    return null;
  }

  const className = value.split('@')[0];

  return className.split('\\').slice(0, -1).join('\\') || null;
}

function isApplicationCommandName(name) {
  return (
    name === 'inspire' ||
    name.startsWith('active-batch-review:') ||
    name.startsWith('platform:') ||
    name.startsWith('modules:') ||
    name.startsWith('local:')
  );
}

function mergeClassifications({
  baseline,
  rawItems,
  existingPath,
  moduleSummaryByKey,
  reset,
}) {
  const existing =
    !reset && existsSync(existingPath)
      ? JSON.parse(readFileSync(existingPath, 'utf8'))
      : null;

  if (
    existing !== null &&
    existing.baseline_sha !== baseline
  ) {
    throw new Error(
      `Existing classifications target ${existing.baseline_sha}; expected ${baseline}.`,
    );
  }

  const existingByIdentifier = new Map(
    Array.isArray(existing?.items)
      ? existing.items.map((item) => [
          item.path_or_identifier,
          item,
        ])
      : [],
  );

  const items = rawItems.map((rawItem) => {
    const current = existingByIdentifier.get(
      rawItem.path_or_identifier,
    );

    if (current) {
      return {
        ...seedClassification(rawItem, moduleSummaryByKey),
        ...current,
        path_or_identifier: rawItem.path_or_identifier,
      };
    }

    return seedClassification(rawItem, moduleSummaryByKey);
  });

  return {
    schema_version: 1,
    baseline_sha: baseline,
    required_fields: REQUIRED_FIELDS,
    reviewed_at: existing?.reviewed_at ?? null,
    reviewer: existing?.reviewer ?? null,
    items: items.sort(compareMaterialItems),
  };
}

function seedClassification(rawItem, moduleSummaryByKey) {
  const inference = inferOwnership(rawItem, moduleSummaryByKey);
  const contradictions = [
    ...new Set([
      ...(rawItem.known_contradictions ?? []),
      ...inference.contradictions,
    ]),
  ].sort();

  const disposition =
    contradictions.length > 0
      ? 'compatibility'
      : inference.ownershipStatus === 'investigate' ||
          inference.ownershipStatus === 'ambiguous'
        ? 'investigate'
        : 'retain';

  return {
    path_or_identifier: rawItem.path_or_identifier,
    surface_type: rawItem.surface_type,
    ownership_area: inference.ownershipArea,
    owner_key: inference.ownerKey,
    capability_key: inference.capabilityKey,
    module_key: inference.moduleKey,
    ownership_status: inference.ownershipStatus,
    current_responsibility: rawItem.safe_purpose,
    authority_state: rawItem.authority_state,
    registration_state: rawItem.registration_state,
    related_contracts: [],
    related_tests: [],
    evidence_source: rawItem.evidence_source,
    known_contradictions: contradictions,
    disposition,
    target_question:
      rawItem.suggested_target_question ??
      inference.targetQuestion,
    _reviewed: false,
    _review_note:
      'Generated seed. Confirm ownership, responsibility, evidence, contradictions, disposition, and target routing against the pinned baseline.',
  };
}

function inferOwnership(rawItem, moduleSummaryByKey) {
  const identifier = rawItem.path_or_identifier;
  const path = identifier.startsWith('dir:')
    ? identifier.slice(4)
    : identifier;

  if (
    path === 'AGENTS.md' ||
    path.startsWith('docs/') ||
    path.startsWith('.agents/') ||
    path.startsWith('scripts/') ||
    path.startsWith('stubs/') ||
    path.startsWith('ops/') ||
    path.startsWith('tests/') ||
    path.startsWith('boundary:')
  ) {
    return {
      ownershipArea: 'not_applicable',
      ownerKey: 'not_applicable',
      capabilityKey: 'not_applicable',
      moduleKey: 'not_applicable',
      ownershipStatus: 'owned',
      contradictions: [],
      targetQuestion: null,
    };
  }

  const coreMatch = path.match(/^app\/Core\/([^/]+)/);

  if (coreMatch) {
    const owner = snakeCase(coreMatch[1]);

    return {
      ownershipArea: 'core',
      ownerKey: owner,
      capabilityKey: owner,
      moduleKey: 'not_applicable',
      ownershipStatus: 'owned',
      contradictions: [],
      targetQuestion: null,
    };
  }

  if (
    path.startsWith('resources/views/components/') ||
    path.startsWith('resources/css/components/') ||
    path.startsWith('resources/js/components/') ||
    path === 'resources/views/components' ||
    path === 'resources/css/components' ||
    path === 'resources/js/components'
  ) {
    return {
      ownershipArea: 'ui',
      ownerKey: 'ui',
      capabilityKey: 'not_applicable',
      moduleKey: 'not_applicable',
      ownershipStatus: 'owned',
      contradictions: [],
      targetQuestion: null,
    };
  }

  const modulePathMatch = path.match(/^Modules\/([^/]+)/);

  if (modulePathMatch) {
    const moduleKey = snakeCase(modulePathMatch[1]);
    const runtime = moduleSummaryByKey.get(moduleKey);
    const runtimeType = String(runtime?.type ?? '');

    if (runtimeType === 'core') {
      return {
        ownershipArea: 'core',
        ownerKey: moduleKey,
        capabilityKey: moduleKey,
        moduleKey,
        ownershipStatus: 'ambiguous',
        contradictions: [
          'Physical Modules path contains a runtime manifest categorized as Core.',
        ],
        targetQuestion:
          'Which Goal 03 Core path and namespace should replace or formally retain this physical Modules location?',
      };
    }

    if (runtimeType === 'platform_management') {
      return {
        ownershipArea: 'not_applicable',
        ownerKey: moduleKey,
        capabilityKey: moduleKey,
        moduleKey,
        ownershipStatus: 'ambiguous',
        contradictions: [
          'Physical Modules path uses the retired platform_management category.',
        ],
        targetQuestion:
          'Which accepted Core or optional Module classification and target path replaces platform_management?',
      };
    }

    if (runtimeType !== '') {
      return {
        ownershipArea: 'module',
        ownerKey: moduleKey,
        capabilityKey: moduleKey,
        moduleKey,
        ownershipStatus: 'owned',
        contradictions: [],
        targetQuestion: null,
      };
    }

    return {
      ownershipArea: 'not_applicable',
      ownerKey: moduleKey,
      capabilityKey: moduleKey,
      moduleKey,
      ownershipStatus: 'investigate',
      contradictions: [
        'Physical Modules path requires manifest and runtime-category review before application ownership can be confirmed.',
      ],
      targetQuestion:
        'Is this physical package an optional Module or transitional Core capability?',
    };
  }

  if (
    path.startsWith('app/Platform') ||
    path.includes('App\\Platform\\')
  ) {
    return {
      ownershipArea: 'not_applicable',
      ownerKey: 'not_applicable',
      capabilityKey: 'not_applicable',
      moduleKey: 'not_applicable',
      ownershipStatus: 'ambiguous',
      contradictions: [
        'App\\Platform is a transitional physical namespace; Platform is not a canonical owner.',
      ],
      targetQuestion:
        'Which Goal 03 Core or UI owner and target path replaces this App\\Platform location?',
    };
  }

  if (
    identifier.startsWith('route:platform.') ||
    identifier.startsWith('command:platform:')
  ) {
    return {
      ownershipArea: 'not_applicable',
      ownerKey: 'not_applicable',
      capabilityKey: 'not_applicable',
      moduleKey: 'not_applicable',
      ownershipStatus: 'ambiguous',
      contradictions: [
        'Identifier uses transitional Platform naming and requires capability-owner review.',
      ],
      targetQuestion:
        'Which capability-first key and compatibility mapping owns this runtime identifier?',
    };
  }

  if (identifier.startsWith('module:')) {
    const moduleKey = identifier.slice('module:'.length);
    const runtime = moduleSummaryByKey.get(moduleKey);
    const runtimeType = String(runtime?.type ?? '');

    if (runtimeType === 'core') {
      return {
        ownershipArea: 'core',
        ownerKey: moduleKey,
        capabilityKey: moduleKey,
        moduleKey,
        ownershipStatus: 'owned',
        contradictions: [],
        targetQuestion: null,
      };
    }

    if (runtimeType === 'platform_management') {
      return {
        ownershipArea: 'not_applicable',
        ownerKey: moduleKey,
        capabilityKey: moduleKey,
        moduleKey,
        ownershipStatus: 'ambiguous',
        contradictions: [
          'Registered module uses the retired platform_management category.',
        ],
        targetQuestion:
          'Which accepted Core or optional Module classification replaces platform_management?',
      };
    }

    return {
      ownershipArea: runtimeType ? 'module' : 'not_applicable',
      ownerKey: moduleKey,
      capabilityKey: moduleKey,
      moduleKey,
      ownershipStatus: runtimeType ? 'owned' : 'investigate',
      contradictions: [],
      targetQuestion: runtimeType
        ? null
        : 'Confirm the application ownership area for this registered module.',
    };
  }

  if (
    path.startsWith('app/') ||
    path.startsWith('routes/') ||
    path.startsWith('config/') ||
    path.startsWith('bootstrap/')
  ) {
    return {
      ownershipArea: 'not_applicable',
      ownerKey: 'not_applicable',
      capabilityKey: 'not_applicable',
      moduleKey: 'not_applicable',
      ownershipStatus: 'investigate',
      contradictions: [],
      targetQuestion:
        'Confirm the precise Core, Module, or UI owner from direct registration and responsibility evidence.',
    };
  }

  return {
    ownershipArea: 'not_applicable',
    ownerKey: 'not_applicable',
    capabilityKey: 'not_applicable',
    moduleKey: 'not_applicable',
    ownershipStatus: 'owned',
    contradictions: [],
    targetQuestion: null,
  };
}

function renderInventoryDocument({
  documentPath,
  rawEvidence,
  classifications,
}) {
  if (!existsSync(documentPath)) {
    throw new Error(
      `Inventory document was not found: ${relative(repositoryRoot, documentPath)}`,
    );
  }

  let document = readFileSync(documentPath, 'utf8');
  const reviewed = classifications.items.filter(
    (item) => item._reviewed === true,
  ).length;
  const pending = classifications.items.length - reviewed;

  const baselineBlock = [
    '- Planning lifecycle: active',
    `- Acceptance state: ${pending === 0 ? 'reviewed inventory' : 'inventory in progress'}`,
    `- Inventory baseline commit: \`${rawEvidence.baseline.sha}\``,
    `- Inventory baseline date: ${rawEvidence.baseline.committed_at.slice(0, 10)}`,
    `- M0 charter pre-M0 baseline: \`${rawEvidence.baseline.charter_baseline_sha}\``,
    `- Runtime-equivalence note: ${rawEvidence.baseline.runtime_equivalence}`,
    '- Owning GitHub issue: #29',
    '- Parent goal: #18',
    '- Generated evidence:',
    `  - \`${RAW_EVIDENCE_FILE}\``,
    `  - \`${CLASSIFICATIONS_FILE}\``,
  ].join('\n');

  const summaryBlock = renderSummary(rawEvidence, classifications);
  const detailsBlock = renderDetailTables(classifications.items);
  const contradictionsBlock = renderContradictions(
    classifications.items,
  );
  const targetQuestionsBlock = renderTargetQuestions(
    classifications.items,
  );
  const runtimeEvidenceBlock = renderRuntimeEvidence(
    rawEvidence.dynamic_runtime_evidence,
  );

  document = replaceMarkerBlock(
    document,
    'INVENTORY:BASELINE',
    baselineBlock,
  );
  document = replaceMarkerBlock(
    document,
    'INVENTORY:SUMMARY',
    summaryBlock,
  );
  document = replaceMarkerBlock(
    document,
    'INVENTORY:DETAILS',
    detailsBlock,
  );
  document = replaceMarkerBlock(
    document,
    'INVENTORY:CONTRADICTIONS',
    contradictionsBlock,
  );
  document = replaceMarkerBlock(
    document,
    'INVENTORY:TARGET-QUESTIONS',
    targetQuestionsBlock,
  );
  document = replaceMarkerBlock(
    document,
    'INVENTORY:RUNTIME-EVIDENCE',
    runtimeEvidenceBlock,
  );

  writeFileSync(documentPath, normalizeNewlines(document), 'utf8');
}

function renderSummary(rawEvidence, classifications) {
  const rows = [
    ['Baseline tracked files', rawEvidence.repository.tracked_file_count],
    ['Material inventory items', classifications.items.length],
    [
      'Reviewed classifications',
      classifications.items.filter((item) => item._reviewed === true)
        .length,
    ],
    [
      'Pending classifications',
      classifications.items.filter((item) => item._reviewed !== true)
        .length,
    ],
    [
      'Contradiction-bearing items',
      classifications.items.filter(
        (item) => item.known_contradictions.length > 0,
      ).length,
    ],
    [
      'Investigate items',
      classifications.items.filter(
        (item) =>
          item.ownership_status === 'investigate' ||
          item.disposition === 'investigate',
      ).length,
    ],
  ];

  const surfaceCounts = countBy(
    classifications.items,
    (item) => item.surface_type,
  );
  const ownershipCounts = countBy(
    classifications.items,
    (item) => item.ownership_status,
  );
  const registrationCounts = countBy(
    classifications.items,
    (item) => item.registration_state,
  );

  return [
    '| Metric | Count |',
    '| --- | ---: |',
    ...rows.map(
      ([label, count]) =>
        `| ${escapeMarkdown(label)} | ${count} |`,
    ),
    '',
    '### Surface-Type Counts',
    '',
    renderCountTable(surfaceCounts),
    '',
    '### Ownership-Status Counts',
    '',
    renderCountTable(ownershipCounts),
    '',
    '### Registration-State Counts',
    '',
    renderCountTable(registrationCounts),
  ].join('\n');
}

function renderCountTable(values) {
  return [
    '| Value | Count |',
    '| --- | ---: |',
    ...Object.entries(values).map(
      ([value, count]) =>
        `| \`${escapeMarkdown(value)}\` | ${count} |`,
    ),
  ].join('\n');
}

function renderDetailTables(items) {
  const groups = groupBy(items, (item) => item.surface_type);
  const sections = [];

  for (const [surfaceType, groupItems] of Object.entries(groups)) {
    sections.push(`### \`${surfaceType}\``);
    sections.push('');
    sections.push(
      '| Path Or Identifier | Ownership | Status | Authority | Registration | Current Responsibility | Evidence | Contradiction | Disposition | Target Question |',
    );
    sections.push(
      '| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |',
    );

    for (const item of groupItems) {
      const ownership = [
        item.ownership_area,
        item.owner_key,
        item.capability_key,
        item.module_key,
      ]
        .map((value) => String(value))
        .join(' / ');

      sections.push(
        [
          `\`${escapeMarkdown(item.path_or_identifier)}\``,
          escapeMarkdown(ownership),
          `\`${escapeMarkdown(item.ownership_status)}\``,
          `\`${escapeMarkdown(item.authority_state)}\``,
          `\`${escapeMarkdown(item.registration_state)}\``,
          escapeMarkdown(item.current_responsibility),
          escapeMarkdown(item.evidence_source.join('; ')),
          escapeMarkdown(item.known_contradictions.join('; ') || 'None'),
          `\`${escapeMarkdown(item.disposition)}\``,
          escapeMarkdown(item.target_question || 'None'),
        ].join(' | ').replace(/^/, '| ').replace(/$/, ' |'),
      );
    }

    sections.push('');
  }

  return sections.join('\n').trim();
}

function renderContradictions(items) {
  const rows = items.filter(
    (item) =>
      item.known_contradictions.length > 0 ||
      ['duplicate', 'ambiguous', 'investigate'].includes(
        item.ownership_status,
      ),
  );

  if (rows.length === 0) {
    return 'No contradiction, duplicate, ambiguous, or investigate items remain.';
  }

  return [
    '| Path Or Identifier | Ownership Status | Contradiction Or Uncertainty | Evidence |',
    '| --- | --- | --- | --- |',
    ...rows.map((item) =>
      [
        `\`${escapeMarkdown(item.path_or_identifier)}\``,
        `\`${escapeMarkdown(item.ownership_status)}\``,
        escapeMarkdown(
          item.known_contradictions.join('; ') ||
            item._review_note ||
            'Ownership remains under investigation.',
        ),
        escapeMarkdown(item.evidence_source.join('; ')),
      ]
        .join(' | ')
        .replace(/^/, '| ')
        .replace(/$/, ' |'),
    ),
  ].join('\n');
}

function renderTargetQuestions(items) {
  const rows = items.filter(
    (item) =>
      typeof item.target_question === 'string' &&
      item.target_question.trim() !== '',
  );

  if (rows.length === 0) {
    return 'No target questions are recorded.';
  }

  return [
    '| Path Or Identifier | Target Question | Suggested Owner |',
    '| --- | --- | --- |',
    ...rows.map((item) =>
      [
        `\`${escapeMarkdown(item.path_or_identifier)}\``,
        escapeMarkdown(item.target_question),
        inferQuestionOwner(item),
      ]
        .join(' | ')
        .replace(/^/, '| ')
        .replace(/$/, ' |'),
    ),
  ].join('\n');
}

function inferQuestionOwner(item) {
  if (
    item.target_question.includes('path') ||
    item.target_question.includes('namespace') ||
    item.target_question.includes('classification')
  ) {
    return 'Issue #33 / Goal 03';
  }

  if (
    item.target_question.includes('compatibility') ||
    item.target_question.includes('key')
  ) {
    return 'Goal 09';
  }

  return 'Investigate';
}

function renderRuntimeEvidence(runtimeEvidence) {
  return [
    '| Discovery | Status | Command | Exit Code | Failure Evidence |',
    '| --- | --- | --- | ---: | --- |',
    ...Object.entries(runtimeEvidence).map(([key, evidence]) =>
      [
        `\`${escapeMarkdown(key)}\``,
        `\`${escapeMarkdown(evidence.status)}\``,
        `\`${escapeMarkdown(evidence.command)}\``,
        evidence.exit_code ?? '—',
        escapeMarkdown(evidence.stderr || 'None'),
      ]
        .join(' | ')
        .replace(/^/, '| ')
        .replace(/$/, ' |'),
    ),
  ].join('\n');
}

function replaceMarkerBlock(document, marker, replacement) {
  const start = `<!-- ${marker}:START -->`;
  const end = `<!-- ${marker}:END -->`;
  const pattern = new RegExp(
    `${escapeRegex(start)}[\\s\\S]*?${escapeRegex(end)}`,
  );

  if (!pattern.test(document)) {
    throw new Error(`Inventory document is missing marker block: ${marker}`);
  }

  return document.replace(
    pattern,
    `${start}\n${replacement.trim()}\n${end}`,
  );
}

function surfaceTypeForPath(path) {
  if (
    path === 'AGENTS.md' ||
    path.endsWith('/AGENTS.md') ||
    path.startsWith('.agents/')
  ) {
    return 'agent_instruction';
  }

  if (path.startsWith('routes/')) {
    return 'route';
  }

  for (const [needle, type] of RUNTIME_DIRECTORY_PATTERNS) {
    if (path.includes(needle)) {
      return type;
    }
  }

  if (
    path.includes('Registry') ||
    path.includes('/Registries/') ||
    path.endsWith('/Definitions.php') ||
    path.endsWith('/Manifest.php')
  ) {
    return 'registry';
  }

  if (
    path.startsWith('Modules/') &&
    path.endsWith('/Definition.php')
  ) {
    return 'registry_contribution';
  }

  if (path.startsWith('config/')) {
    return 'configuration';
  }

  if (path.startsWith('docs/')) {
    return 'documentation';
  }

  if (path.startsWith('scripts/')) {
    return 'script';
  }

  if (path.startsWith('stubs/')) {
    return 'stub';
  }

  if (path.startsWith('ops/')) {
    return 'operations';
  }

  if (path.startsWith('Modules/')) {
    return 'module';
  }

  if (path.startsWith('tests/')) {
    return 'test_boundary';
  }

  if (
    BUILD_TOOL_FILES.has(path) ||
    path.startsWith('.github/') ||
    path.startsWith('bootstrap/')
  ) {
    return 'build_tooling';
  }

  return 'application_code';
}

function surfaceTypeForDirectory(directory) {
  if (directory.startsWith('.agents')) {
    return 'agent_instruction';
  }

  if (directory.startsWith('docs')) {
    return 'documentation';
  }

  if (directory.startsWith('scripts')) {
    return 'script';
  }

  if (directory.startsWith('stubs')) {
    return 'stub';
  }

  if (directory.startsWith('ops')) {
    return 'operations';
  }

  if (directory.startsWith('Modules')) {
    return 'module';
  }

  if (directory.startsWith('config')) {
    return 'configuration';
  }

  if (directory.startsWith('routes')) {
    return 'route';
  }

  if (directory.startsWith('tests')) {
    return 'test_boundary';
  }

  if (directory.startsWith('resources/views/components')) {
    return 'application_code';
  }

  return 'application_code';
}

function authorityStateForPath(path, metadata) {
  if (path.startsWith('docs/_archive/')) {
    return 'historical';
  }

  if (path.startsWith('docs/')) {
    if (metadata?.status === 'superseded') {
      return 'superseded';
    }

    if (metadata?.canonical === 'true') {
      return 'canonical';
    }

    if (
      metadata?.doc_type === 'planning' ||
      path.startsWith('docs/07-planning/')
    ) {
      return 'planning';
    }

    return 'active';
  }

  if (
    path.includes('08-active') ||
    path.includes('active-batch')
  ) {
    return 'compatibility';
  }

  return 'active';
}

function authorityStateForDirectory(directory) {
  if (directory.startsWith('docs/_archive')) {
    return 'historical';
  }

  if (directory.startsWith('docs/07-planning')) {
    return 'planning';
  }

  if (directory.startsWith('docs')) {
    return 'active';
  }

  if (
    directory.startsWith('vendor') ||
    directory.startsWith('node_modules')
  ) {
    return 'vendor';
  }

  return 'active';
}

function registrationStateForPath(path) {
  if (
    path.startsWith('routes/') ||
    path.includes('/Middleware/') ||
    path.includes('/Providers/') ||
    path.includes('/Console/Commands/')
  ) {
    return 'present';
  }

  return 'not_applicable';
}

function defaultResponsibilityForPath(path, surfaceType) {
  if (!path.includes('/')) {
    return `Root repository ${surfaceType.replaceAll('_', ' ')} file.`;
  }

  return `Baseline ${surfaceType.replaceAll('_', ' ')} surface at ${path}.`;
}

function contradictionsForPath(path, content) {
  const values = [];

  if (
    path.startsWith('app/Platform') ||
    content.includes('App\\Platform\\')
  ) {
    values.push(
      'App\\Platform is a transitional physical namespace; Platform is not a canonical owner.',
    );
  }

  if (
    path.includes('03-platform-surfaces') ||
    path.includes('platform-surface')
  ) {
    values.push(
      'Path retains transitional Platform-surface planning terminology.',
    );
  }

  if (
    path.startsWith('Modules/') &&
    /Category::Core/.test(content)
  ) {
    values.push(
      'Physical Modules path contains a manifest currently categorized as Core.',
    );
  }

  if (/Category::PlatformManagement/.test(content)) {
    values.push(
      'Current code uses the retired PlatformManagement category.',
    );
  }

  if (/\bplatform\.[a-z0-9_.-]+/i.test(content)) {
    values.push(
      'Current runtime or planning key uses transitional platform.* naming.',
    );
  }

  if (
    path.includes('active-batch') ||
    /active-batch|docs\/08-active/i.test(content)
  ) {
    values.push(
      'Historical active-batch workflow surface remains present.',
    );
  }

  if (/\bservice identity\b/i.test(content)) {
    values.push(
      'Superseded Service Identity umbrella terminology remains present.',
    );
  }

  if (/\bowner layer\b/i.test(content)) {
    values.push(
      'Superseded owner-layer terminology remains present.',
    );
  }

  return [...new Set(values)].sort();
}

function targetQuestionFor(path, contradictions) {
  if (
    contradictions.some((value) =>
      value.includes('App\\Platform'),
    )
  ) {
    return 'Which Goal 03 Core or UI owner and target path replaces this transitional App\\Platform location?';
  }

  if (
    contradictions.some((value) =>
      value.includes('physical Modules path'),
    )
  ) {
    return 'Which Goal 03 Core or optional Module path and namespace owns this current package?';
  }

  if (
    contradictions.some((value) =>
      value.includes('platform.*'),
    )
  ) {
    return 'Which capability-first key and Goal 09 compatibility mapping replaces this transitional platform.* identifier?';
  }

  if (
    contradictions.some((value) =>
      value.includes('active-batch'),
    )
  ) {
    return 'Which Goal 09 cleanup issue retires or preserves this historical active-batch compatibility surface?';
  }

  if (contradictions.length > 0) {
    return `Which accepted later owner resolves the contradiction recorded for ${path}?`;
  }

  return null;
}

function addMaterialItem(map, item) {
  const existing = map.get(item.path_or_identifier);

  if (!existing) {
    map.set(item.path_or_identifier, item);
    return;
  }

  const registrationPriority = [
    'not_applicable',
    'unknown',
    'present',
    'registered',
    'reachable',
    'invoked',
  ];

  map.set(item.path_or_identifier, {
    ...existing,
    ...item,
    evidence_source: [
      ...new Set([
        ...(existing.evidence_source ?? []),
        ...(item.evidence_source ?? []),
      ]),
    ].sort(),
    known_contradictions: [
      ...new Set([
        ...(existing.known_contradictions ?? []),
        ...(item.known_contradictions ?? []),
      ]),
    ].sort(),
    registration_state:
      registrationPriority.indexOf(item.registration_state) >
      registrationPriority.indexOf(existing.registration_state)
        ? item.registration_state
        : existing.registration_state,
  });
}

function countBy(values, selector) {
  const counts = {};

  for (const value of values) {
    const key = String(selector(value));
    counts[key] = (counts[key] ?? 0) + 1;
  }

  return Object.fromEntries(
    Object.entries(counts).sort(([left], [right]) =>
      left.localeCompare(right),
    ),
  );
}

function groupBy(values, selector) {
  const groups = {};

  for (const value of values) {
    const key = String(selector(value));
    groups[key] ??= [];
    groups[key].push(value);
  }

  for (const group of Object.values(groups)) {
    group.sort(compareMaterialItems);
  }

  return Object.fromEntries(
    Object.entries(groups).sort(([left], [right]) =>
      left.localeCompare(right),
    ),
  );
}

function compareMaterialItems(left, right) {
  return left.path_or_identifier.localeCompare(
    right.path_or_identifier,
  );
}

function compareTermFlags(left, right) {
  return (
    left.path.localeCompare(right.path) ||
    left.line - right.line ||
    left.key.localeCompare(right.key)
  );
}

function namespaceRoot(namespace) {
  return namespace.split('\\').slice(0, 3).join('\\');
}

function snakeCase(value) {
  return value
    .replace(/([a-z0-9])([A-Z])/g, '$1_$2')
    .replace(/[^A-Za-z0-9]+/g, '_')
    .replace(/^_+|_+$/g, '')
    .toLowerCase();
}

function normalizePath(value) {
  return String(value).replaceAll('\\', '/').trim();
}

function normalizeNewlines(value) {
  return value.replaceAll('\r\n', '\n');
}

function escapeRegex(value) {
  return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function escapeMarkdown(value) {
  return String(value)
    .replaceAll('|', '\\|')
    .replace(/\r?\n/g, ' ')
    .trim();
}

function writeJson(path, value) {
  mkdirSync(dirname(path), { recursive: true });
  writeFileSync(
    path,
    `${JSON.stringify(value, null, 2)}\n`,
    'utf8',
  );
}
