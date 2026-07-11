/**
 * ============================================================================
 * File: scripts/check-m0-repository-current-state-inventory.mjs
 * Purpose: Validate the pinned issue #29 raw evidence, reviewed
 * classifications, generated inventory document, and security boundaries.
 * ============================================================================
 */

import {
  existsSync,
  readFileSync,
} from 'node:fs';
import { spawnSync } from 'node:child_process';
import { resolve } from 'node:path';
import process from 'node:process';

const INVENTORY_DOCUMENT =
  'docs/07-planning/00-overview/m0-repository-current-state-inventory.md';
const RAW_EVIDENCE_FILE =
  'docs/07-planning/00-overview/evidence/m0-repository-current-state-raw.json';
const CLASSIFICATIONS_FILE =
  'docs/07-planning/00-overview/evidence/m0-repository-current-state-classifications.json';

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

const OWNERSHIP_AREAS = new Set([
  'core',
  'module',
  'ui',
  'not_applicable',
]);

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

const FORBIDDEN_SECRET_PATTERNS = [
  /-----BEGIN (?:RSA |EC |OPENSSH )?PRIVATE KEY-----/i,
  /\bAPP_KEY\s*=\s*base64:/i,
  /\b(?:PASSWORD|TOKEN|SECRET|PRIVATE_KEY)\s*=\s*(?!\[REDACTED\])\S+/i,
  /\bgh[pousr]_[A-Za-z0-9_]{20,}\b/,
];

const REQUIRED_DOCUMENT_TEXT = [
  'M0 Repository Current-State Inventory',
  'Inventory baseline commit:',
  'm0-repository-current-state-raw.json',
  'm0-repository-current-state-classifications.json',
  'ADR-0005',
  'ADR-0006',
  'ADR-0007',
  'Related GitHub issue: [#29]',
];

const FORBIDDEN_PLACEHOLDERS = [
  'Run `npm run inventory:m0:repository',
  'Run the generator, review every seeded classification',
  'Generated after classification review.',
  'Failed commands remain visible as evidence gaps.',
];

const repositoryRoot = resolve(
  runRequired('git', ['rev-parse', '--show-toplevel']).trim(),
);
process.chdir(repositoryRoot);

const failures = [];

for (const path of [
  INVENTORY_DOCUMENT,
  RAW_EVIDENCE_FILE,
  CLASSIFICATIONS_FILE,
]) {
  if (!existsSync(path)) {
    failures.push(`Required inventory file is missing: ${path}`);
  }
}

if (failures.length > 0) {
  finish();
}

const document = readFileSync(INVENTORY_DOCUMENT, 'utf8');
const raw = JSON.parse(readFileSync(RAW_EVIDENCE_FILE, 'utf8'));
const classifications = JSON.parse(
  readFileSync(CLASSIFICATIONS_FILE, 'utf8'),
);

const currentHead = runRequired('git', ['rev-parse', 'HEAD']).trim();

if (raw.baseline?.sha !== classifications.baseline_sha) {
  failures.push(
    `Baseline mismatch: raw=${raw.baseline?.sha}, classifications=${classifications.baseline_sha}.`,
  );
}

if (
  !runRequired('git', [
    'merge-base',
    '--is-ancestor',
    raw.baseline.sha,
    currentHead,
  ], true).passed
) {
  failures.push(
    `Inventory baseline ${raw.baseline.sha} is not an ancestor of current HEAD ${currentHead}.`,
  );
}

for (const text of REQUIRED_DOCUMENT_TEXT) {
  if (!document.includes(text)) {
    failures.push(`Inventory document is missing required text: ${text}`);
  }
}

for (const placeholder of FORBIDDEN_PLACEHOLDERS) {
  if (document.includes(placeholder)) {
    failures.push(
      `Inventory document still contains generated placeholder text: ${placeholder}`,
    );
  }
}

for (const marker of [
  'INVENTORY:BASELINE',
  'INVENTORY:SUMMARY',
  'INVENTORY:DETAILS',
  'INVENTORY:CONTRADICTIONS',
  'INVENTORY:TARGET-QUESTIONS',
  'INVENTORY:RUNTIME-EVIDENCE',
]) {
  const start = `<!-- ${marker}:START -->`;
  const end = `<!-- ${marker}:END -->`;

  if (!document.includes(start) || !document.includes(end)) {
    failures.push(`Inventory document is missing marker pair: ${marker}`);
  }
}

if (!Array.isArray(raw.material_items)) {
  failures.push('Raw evidence material_items must be an array.');
}

if (!Array.isArray(classifications.items)) {
  failures.push('Classifications items must be an array.');
}

const rawIdentifiers = new Set(
  (raw.material_items ?? []).map(
    (item) => item.path_or_identifier,
  ),
);
const classificationIdentifiers = new Set(
  (classifications.items ?? []).map(
    (item) => item.path_or_identifier,
  ),
);

for (const identifier of rawIdentifiers) {
  if (!classificationIdentifiers.has(identifier)) {
    failures.push(
      `Raw material item is missing a classification: ${identifier}`,
    );
  }
}

for (const identifier of classificationIdentifiers) {
  if (!rawIdentifiers.has(identifier)) {
    failures.push(
      `Classification has no matching raw material item: ${identifier}`,
    );
  }
}

const duplicates = findDuplicates(
  (classifications.items ?? []).map(
    (item) => item.path_or_identifier,
  ),
);

for (const duplicate of duplicates) {
  failures.push(`Duplicate classification identifier: ${duplicate}`);
}

for (const item of classifications.items ?? []) {
  validateClassification(item);
}

for (const path of [
  INVENTORY_DOCUMENT,
  RAW_EVIDENCE_FILE,
  CLASSIFICATIONS_FILE,
]) {
  const content = readFileSync(path, 'utf8');

  for (const pattern of FORBIDDEN_SECRET_PATTERNS) {
    if (pattern.test(content)) {
      failures.push(
        `Potential secret-bearing content matched in ${path}: ${pattern}`,
      );
    }
  }
}

if (
  (classifications.items ?? []).some(
    (item) => item._reviewed !== true,
  )
) {
  failures.push(
    'Every classification must set _reviewed to true before issue #29 can complete.',
  );
}

if (
  typeof classifications.reviewer !== 'string' ||
  classifications.reviewer.trim() === ''
) {
  failures.push('Classifications reviewer must be recorded.');
}

if (
  typeof classifications.reviewed_at !== 'string' ||
  Number.isNaN(Date.parse(classifications.reviewed_at))
) {
  failures.push(
    'Classifications reviewed_at must be an ISO-8601 timestamp.',
  );
}

finish();

function validateClassification(item) {
  for (const field of REQUIRED_FIELDS) {
    if (!(field in item)) {
      failures.push(
        `${item.path_or_identifier ?? '[unknown]'} is missing required field ${field}.`,
      );
    }
  }

  if (
    typeof item.path_or_identifier !== 'string' ||
    item.path_or_identifier.trim() === ''
  ) {
    failures.push('Classification path_or_identifier must be non-empty.');
  }

  if (
    typeof item.surface_type !== 'string' ||
    item.surface_type.trim() === ''
  ) {
    failures.push(
      `${item.path_or_identifier} has an empty surface_type.`,
    );
  }

  if (!OWNERSHIP_AREAS.has(item.ownership_area)) {
    failures.push(
      `${item.path_or_identifier} has invalid ownership_area: ${item.ownership_area}`,
    );
  }

  if (!OWNERSHIP_STATUSES.has(item.ownership_status)) {
    failures.push(
      `${item.path_or_identifier} has invalid ownership_status: ${item.ownership_status}`,
    );
  }

  if (!AUTHORITY_STATES.has(item.authority_state)) {
    failures.push(
      `${item.path_or_identifier} has invalid authority_state: ${item.authority_state}`,
    );
  }

  if (!REGISTRATION_STATES.has(item.registration_state)) {
    failures.push(
      `${item.path_or_identifier} has invalid registration_state: ${item.registration_state}`,
    );
  }

  if (!DISPOSITIONS.has(item.disposition)) {
    failures.push(
      `${item.path_or_identifier} has invalid disposition: ${item.disposition}`,
    );
  }

  for (const field of [
    'related_contracts',
    'related_tests',
    'evidence_source',
    'known_contradictions',
  ]) {
    if (!Array.isArray(item[field])) {
      failures.push(
        `${item.path_or_identifier} field ${field} must be an array.`,
      );
    }
  }

  if (
    typeof item.current_responsibility !== 'string' ||
    item.current_responsibility.trim() === ''
  ) {
    failures.push(
      `${item.path_or_identifier} has an empty current_responsibility.`,
    );
  }

  if (
    !Array.isArray(item.evidence_source) ||
    item.evidence_source.length === 0
  ) {
    failures.push(
      `${item.path_or_identifier} must record at least one evidence source.`,
    );
  }

  if (
    item.target_question !== null &&
    typeof item.target_question !== 'string'
  ) {
    failures.push(
      `${item.path_or_identifier} target_question must be a string or null.`,
    );
  }

  if (
    ['ambiguous', 'duplicate', 'investigate'].includes(
      item.ownership_status,
    ) &&
    (!Array.isArray(item.known_contradictions) ||
      item.known_contradictions.length === 0)
  ) {
    failures.push(
      `${item.path_or_identifier} requires contradiction or uncertainty evidence for ownership_status ${item.ownership_status}.`,
    );
  }

  if (
    item.disposition === 'investigate' &&
    (typeof item.target_question !== 'string' ||
      item.target_question.trim() === '')
  ) {
    failures.push(
      `${item.path_or_identifier} requires a target_question when disposition is investigate.`,
    );
  }
}

function runRequired(command, args, returnResult = false) {
  const result = spawnSync(command, args, {
    cwd: process.cwd(),
    encoding: 'utf8',
    maxBuffer: 64 * 1024 * 1024,
    windowsHide: true,
  });

  if (returnResult) {
    return {
      passed: !result.error && result.status === 0,
      stdout: result.stdout ?? '',
      stderr: result.stderr ?? '',
    };
  }

  if (result.error) {
    throw result.error;
  }

  if (result.status !== 0) {
    throw new Error(
      `Command failed: ${command} ${args.join(' ')}\n${result.stderr ?? result.stdout}`,
    );
  }

  return result.stdout ?? '';
}

function findDuplicates(values) {
  const seen = new Set();
  const duplicates = new Set();

  for (const value of values) {
    if (seen.has(value)) {
      duplicates.add(value);
    }

    seen.add(value);
  }

  return [...duplicates].sort();
}

function finish() {
  if (failures.length > 0) {
    console.error('[FAIL] M0 repository inventory validation failed.');
    console.error(failures.map((failure) => `- ${failure}`).join('\n'));
    process.exit(1);
  }

  console.log('M0 repository inventory validation passed.');
}
