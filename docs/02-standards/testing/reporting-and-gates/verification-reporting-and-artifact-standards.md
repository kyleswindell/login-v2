<!--
DOC-META
title: Verification Reporting And Artifact Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/reporting-and-gates/verification-reporting-and-artifact-standards.md
parent: docs/02-standards/testing/reporting-and-gates/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines execution records, material verification artifacts, evidence manifests, hashes, manual and specialist evidence, storage, retention, redaction, and concise testing reports.
-->

# Verification Reporting And Artifact Standards

Parent: [Reporting And Testing Gates Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Routine Versus Material Runs](#2-routine-versus-material-runs)
  - [Routine development runs](#routine-development-runs)
  - [Material verification runs](#material-verification-runs)
- [3. Execution Record](#3-execution-record)
- [4. Material Verification Artifacts](#4-material-verification-artifacts)
- [5. Evidence Manifest](#5-evidence-manifest)
- [6. Baseline And Protected-Proof Reporting](#6-baseline-and-protected-proof-reporting)
- [7. Manual And Specialist Evidence](#7-manual-and-specialist-evidence)
- [8. Failed And Blocked Proof Reporting](#8-failed-and-blocked-proof-reporting)
- [9. Storage And Retention](#9-storage-and-retention)
- [10. Evidence Safety](#10-evidence-safety)
- [11. Concise Work-Packet And PR Reporting](#11-concise-work-packet-and-pr-reporting)
- [12. Prohibited Shared Test Log](#12-prohibited-shared-test-log)
- [13. Related](#13-related)

## 1. Purpose And Authority

Define the reproducible record required after verification execution and the material artifacts retained when an execution supports a formal testing decision.

This standard owns:

- execution-record fields;
- material evidence manifests;
- runner report and artifact references;
- report and protected-file hashes;
- manual and specialist evidence records;
- storage and retention guidance;
- evidence redaction;
- concise testing summaries.

It does not define:

- `AC-*` or `PF-*` declaration requirements;
- proof-state or result meanings;
- initial-proof applicability;
- protected-baseline edit authority;
- testing-gate completeness.

Those are owned by the Verification Contract and Testing Gate standards.

## 2. Routine Versus Material Runs

### Routine development runs

Routine iterations may use console output only when the execution is not relied upon for:

- accepted initial baseline;
- final targeted acceptance;
- failed mandatory proof evidence;
- specialist review;
- merge-candidacy evidence;
- release or deployment;
- another formal decision.

Routine output does not need to be committed or retained.

### Material verification runs

Retain structured evidence for applicable:

- preimplementation `EXPECTED_NONPASS`;
- accepted characterization baseline;
- protected-baseline identity;
- final targeted proof;
- material proof revision;
- mandatory security, database, migration, browser, performance, compatibility, native-platform, or operational proof;
- failed mandatory proof;
- release or deployment proof;
- execution explicitly relied upon by an acceptance decision.

Only evidence material to the claim needs long-form retention.

## 3. Execution Record

Every material execution record must identify applicable:

- proof ID;
- criterion IDs;
- declared stage;
- applicability;
- execution status;
- verification result when executed;
- exact command or procedure;
- operating system;
- runtime and material tool versions;
- working directory;
- target revision or commit;
- required and actual environment identity;
- protected-baseline identity when applicable;
- protected paths and hashes when applicable;
- accepted mechanical edits or contract revision when applicable;
- exit code;
- observed result;
- limitations;
- reviewer when applicable;
- evidence location.

Record start/end time when timing or operational traceability is material.

Do not claim a proof passed unless the exact declared command or procedure succeeded under a valid execution.

## 4. Material Verification Artifacts

A material run should retain:

1. runner-native structured report where supported;
2. one small per-run evidence manifest;
3. supplementary logs, traces, screenshots, coverage, benchmark, or specialist reports only when applicable.

A conceptual artifact set may be:

```text
<run-id>/
├── manifest.json
├── runner-report.xml
├── console.log
├── screenshots/
└── supplementary-reports/
```

This is a conceptual evidence shape, not a mandated repository directory.

Only applicable artifacts are required.

Generated verification artifacts are evidence, not canonical source.

## 5. Evidence Manifest

A material evidence manifest should identify applicable:

- run ID;
- proof IDs;
- criterion IDs;
- revision;
- baseline identity;
- command or procedure;
- working directory;
- environment;
- stage;
- applicability;
- execution status;
- verification result;
- exit code;
- runner report identity;
- report hash when required;
- protected-path hashes when applicable;
- accepted mechanical edits;
- verification-contract revision;
- reviewer;
- limitations.

The exact manifest schema, filename, storage backend, and automation are implementation decisions unless another accepted standard or work packet fixes them.

Do not make a generated manifest a competing source of requirement or review authority.

## 6. Baseline And Protected-Proof Reporting

When a material execution depends on protected proof, report one of:

```text
UNCHANGED
Protected semantics and protected paths match the accepted baseline.
```

```text
AUTHORIZED_MECHANICAL_EDIT
Only predeclared nonsemantic edits occurred; before-and-after hashes are recorded.
```

```text
ACCEPTED_CONTRACT_REVISION
A material revision was accepted before protected evidence changed.
```

These are reporting descriptions, not verification results.

Include enough information to reconcile:

- baseline identity;
- final protected paths;
- file hashes;
- command selection;
- accepted edit or revision;
- final proof result.

Baseline semantics and revision authority are owned by [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md).

## 7. Manual And Specialist Evidence

A required manual or specialist proof record must identify:

- proof and criterion IDs;
- stage and applicability;
- environment;
- actor or reviewer role;
- route, Page, command, workflow, operational surface, or other review target;
- exact procedure;
- expected conditions;
- observed conditions;
- execution status;
- verification result;
- reviewer and authority;
- date when material;
- screenshots, recordings, or reports when appropriate;
- limitations;
- conditions on acceptance.

Reviewer unavailability before review begins is `BLOCKED`.

A completed review with insufficient evidence is `EXECUTED + FAIL`.

Do not attribute human or specialist acceptance to an automated agent identity.

## 8. Failed And Blocked Proof Reporting

For each mandatory blocked or failed proof, record applicable:

- proof and criterion IDs;
- stage;
- applicability;
- execution status;
- result when executed;
- exact command or procedure;
- environment;
- baseline identity;
- blocking prerequisite or failure classification;
- protected-proof violation when applicable;
- whether the condition is in scope;
- whether it blocks the current testing gate;
- allowed next action;
- evidence location.

Preserve exact failure evidence before authorized recovery.

A failed proof is not authorization to:

- weaken assertions;
- rewrite fixtures;
- narrow selection;
- add skips;
- replace a real boundary with a fake;
- update unrelated dependencies;
- remediate outside accepted scope.

## 9. Storage And Retention

Generated result artifacts should normally be:

- written to a gitignored local result location;
- uploaded by CI as retained workflow artifacts where applicable;
- referenced from the issue or pull request;
- retained for the period required by the work packet, release policy, or evidence sensitivity;
- removed after retention expires.

Do not commit ordinary runner output, screenshots, coverage trees, or per-run manifests unless an accepted issue explicitly requires durable repository evidence.

Use hashes when artifact integrity is material.

Retention requirements must consider evidence sensitivity as well as reproducibility.

## 10. Evidence Safety

Evidence must not expose:

- passwords;
- authentication tokens;
- API keys;
- MFA secrets;
- recovery codes;
- cookies;
- authorization headers;
- connection strings;
- private keys;
- unrestricted personal data;
- restricted operational details.

Use synthetic data where practical.

Redact or omit sensitive data at capture time rather than relying solely on later cleanup.

Evidence safety requirements from Security, Data Governance, UI, and operational standards remain authoritative.

## 11. Concise Work-Packet And PR Reporting

A concise testing summary should state applicable:

```text
Proof IDs:
Criterion IDs:
Stage:
Applicability:
Execution status:
Verification result:
Baseline identity:
Command or procedure:
Environment:
Revision:
Exit code:
Artifact reference:
Report hash:
Protected-proof status:
Limitations:
Reviewer:
```

Do not copy thousands of lines of runner output into an issue or pull request.

The concise summary should reference the material artifacts it relies upon.

Do not report “all tests pass” when only a targeted subset ran.

Do not report protected proof as unchanged when it received unrecorded edits.

## 12. Prohibited Shared Test Log

Do not append verification history to one shared source-controlled:

```text
test_log
test_log.txt
test-log.md
validation-ledger.md
```

or equivalent flat file.

A shared append-only log:

- creates merge conflicts and repository churn;
- mixes unrelated executions;
- weakens revision and environment traceability;
- cannot represent structured artifacts well;
- grows without bounded retention;
- increases sensitive-data exposure;
- becomes difficult to query or validate.

Issues and pull requests retain concise proof summaries. Structured artifacts retain detailed execution evidence.

## 13. Related

- [Reporting And Testing Gates Standards Index](index.md)
- [Testing Gate Standards](testing-gate-standards.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md)
