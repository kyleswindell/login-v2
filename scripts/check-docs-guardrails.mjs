import { readdirSync, readFileSync, statSync } from 'node:fs';
import { join, relative } from 'node:path';

const root = process.cwd();

const checks = [
  {
    label: 'Legacy /docs-v2/ markdown link target found',
    pattern: /\[[^\]]+\]\([^\)]*\/docs-v2\/[^\)]*\)/g,
  },
  {
    label: 'Legacy docs/V2 App/ markdown link target found',
    pattern: /\[[^\]]+\]\([^\)]*docs\/V2(?: |%20)App\/[^\)]*\)/g,
  },
  {
    label: 'Legacy wiki link found',
    pattern: /(?<!`)\[\[V1 App\/[^\]]*\]\](?!`)/g,
  },
];

function listFiles(directory) {
  const entries = readdirSync(directory);
  const files = [];

  for (const entry of entries) {
    const path = join(directory, entry);
    const relativePath = relative(root, path).replaceAll('\\', '/');

    if (relativePath === 'docs/_archive' || relativePath.startsWith('docs/_archive/')) {
      continue;
    }

    if (statSync(path).isDirectory()) {
      files.push(...listFiles(path));
      continue;
    }

    files.push(path);
  }

  return files;
}

function lineNumberFor(content, index) {
  return content.slice(0, index).split(/\r?\n/).length;
}

const files = [...listFiles(join(root, 'docs')), join(root, 'AGENTS.md')];
let failures = 0;

for (const check of checks) {
  const matches = [];

  for (const file of files) {
    const content = readFileSync(file, 'utf8');
    const pattern = new RegExp(check.pattern.source, check.pattern.flags);
    let match;

    while ((match = pattern.exec(content)) !== null) {
      const relativePath = relative(root, file).replaceAll('\\', '/');
      matches.push(`${relativePath}:${lineNumberFor(content, match.index)}:${match[0]}`);
    }
  }

  if (matches.length > 0) {
    failures = 1;
    console.log(`[FAIL] ${check.label}`);
    console.log(matches.join('\n'));
  }
}

if (failures !== 0) {
  console.log('Docs guardrail check failed.');
  process.exit(1);
}

console.log('Docs guardrail check passed.');
