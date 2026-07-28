<!--
DOC-META
title: Test Reporting And Delivery Gates Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-reporting-and-delivery-gates-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines testing-evidence gates, execution-state evaluation, result artifacts, failure and flaky-test handling, reporting, and proof completeness across implementation, pull request, merge-candidacy, release, deployment, and post-deployment stages.
-->

# Test Reporting And Delivery Gates Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Testing Gate Model](#2-testing-gate-model)
- [3. Gate Evaluation](#3-gate-evaluation)
- [4. Testing Evidence Required For Implementation Readiness](#4-testing-evidence-required-for-implementation-readiness)
- [5. Preimplementation Testing Gate](#5-preimplementation-testing-gate)
- [6. Development Testing Evidence](#6-development-testing-evidence)
- [7. Pull Request Testing Evidence](#7-pull-request-testing-evidence)
- [8. Testing Evidence Required For Merge Candidacy](#8-testing-evidence-required-for-merge-candidacy)
- [9. Release And Deployment Testing Evidence](#9-release-and-deployment-testing-evidence)
- [10. Post-Deployment Testing Evidence](#10-post-deployment-testing-evidence)
- [11. Test Selection](#11-test-selection)
- [12. Failure Handling](#12-failure-handling)
- [13. Flaky Tests](#13-flaky-tests)
- [14. Skipped And Incomplete Tests](#14-skipped-and-incomplete-tests)
- [15. Test Result Artifacts And Retention](#15-test-result-artifacts-and-retention)
  - [15.1. Routine development runs](#151-routine-development-runs)
  - [15.2. Material verification runs](#152-material-verification-runs)
  - [15.3. Artifact structure](#153-artifact-structure)
  - [15.4. Storage and retention](#154-storage-and-retention)
  - [15.5. Prohibited shared test log](#155-prohibited-shared-test-log)
- [16. Reporting](#16-reporting)
- [17. Testing Acceptance Completeness](#17-testing-acceptance-completeness)
- [18. Related](#18-related)

## 1. Purpose

Define when testing proof is required, how proof state affects testing gates, and what testing evidence must be reported across implementation, pull request, merge-candidacy, release, deployment, and operational-review stages.

This standard does not own GitHub issue readiness, Project status, pull-request workflow, merge authorization, release authorization, deployment authorization, issue closure, milestone closure, or repository-owner acceptance.

Those remain with the Agent Implementation Checklist, repository workflow, applicable runbooks, accepted work packet, and repository owner.

This standard owns only the testing-evidence conditions that those workflow stages may require.

## 2. Testing Gate Model

Each gate evaluates declared `PF-*` proofs.

Each proof records three separate state axes:

```text
Applicability:
REQUIRED | CONDITIONAL | NOT_APPLICABLE

Execution status:
NOT_RUN | BLOCKED | EXECUTED

Verification result when executed:
PASS | EXPECTED_NONPASS | FAIL
```

`NOT_APPLICABLE` is not a result.

`NOT_RUN` and `BLOCKED` are not results.

`EXPECTED_NONPASS` is valid only for an exact preimplementation missing-behavior proof.

A proof-level state does not independently change GitHub issue or Project status.

## 3. Gate Evaluation

A proof stage satisfies a testing gate only when either:

```text
Applicability: NOT_APPLICABLE
Reason: accepted before the stage is evaluated
```

or:

```text
Applicability: REQUIRED
Execution status: EXECUTED
Verification result: exact result accepted for the stage
```

For final, pull-request, merge-candidacy, release, deployment, post-deployment, and completion stages, the accepted result is normally `PASS`.

These conditions do not satisfy a required testing gate:

```text
REQUIRED + NOT_RUN
REQUIRED + BLOCKED
REQUIRED + EXECUTED + FAIL
REQUIRED + EXECUTED + unexpected PASS
REQUIRED + EXECUTED + unexpected nonpass
CONDITIONAL unresolved when the stage becomes due
```

`NOT_RUN` is neutral only before the proof becomes due.

A `BLOCKED` proof prevents testing acceptance for the affected stage until the named prerequisite is resolved or the contract is revised by the proper authority.

## 4. Testing Evidence Required For Implementation Readiness

Before testing evidence can support an implementation-readiness decision, the verification contract must establish:

- accepted requirements;
- explicit ownership;
- stable `AC-*` identifiers;
- stable `PF-*` identifiers;
- canonical requirement sources;
- complete criterion-to-proof mapping;
- proof modes;
- required stages;
- applicability rules;
- expected initial and final results;
- declared environment capability;
- responsible executors;
- defined fixtures and actors;
- anticipated protected evidence;
- proof-specific stop conditions;
- required manual or specialist review authority.

Implementation readiness and authorization remain governed by the Agent Implementation Checklist and accepted work packet.

## 5. Preimplementation Testing Gate

When required, the preimplementation gate is satisfied only when:

- required environment preflight passes;
- every conditional proof due at the stage is resolved;
- characterization proof produces `PASS` for preservation work; or
- new-behavior proof produces the exact declared `EXPECTED_NONPASS`;
- unrelated failures are absent from the targeted proof;
- execution evidence is recorded;
- the initial protected baseline is recorded;
- no production implementation preceded the required proof.

An unexpected pass where `EXPECTED_NONPASS` was declared is `FAIL`.

A different nonpass is `FAIL`.

A `BLOCKED`, `NOT_RUN`, or `FAIL` required proof blocks testing acceptance for production implementation unless the accepted work packet defines bounded recovery.

## 6. Development Testing Evidence

During implementation, testing evidence should demonstrate that:

- targeted proofs run at useful intervals;
- static checks run for changed artifact types;
- protected proofs and fixtures remain unchanged unless revision is accepted;
- new failures are investigated immediately;
- unrelated suites are not used to hide targeted failure;
- no required proof remains incomplete;
- documentation changes are verified when applicable;
- routine iterations do not overwrite accepted material evidence.

Routine development executions may remain console-only unless relied upon for acceptance.

## 7. Pull Request Testing Evidence

A pull request’s testing evidence must report:

- issue or task;
- `AC-*` criteria covered;
- `PF-*` proofs executed;
- applicability, execution status, and result for each required proof;
- targeted commands or procedures;
- broader affected tests and results;
- static checks;
- build checks;
- database verification when applicable;
- browser or manual review when applicable;
- specialist testing review when applicable;
- proofs not run and why;
- blockers;
- known test or evidence failures;
- artifact references for material runs;
- testing limitations and remaining risks.

Repository workflow and PR templates may require additional non-testing information such as files changed, behavior summaries, documentation synchronization, review state, and integration status.

Do not report “all tests pass” when only a targeted subset ran.

## 8. Testing Evidence Required For Merge Candidacy

Testing evidence is complete for merge candidacy only when:

- every required final targeted proof is `EXECUTED + PASS`;
- required broader suites pass;
- mandatory static and documentation checks pass;
- required manual and specialist testing review is accepted;
- no required proof is `NOT_RUN` or `BLOCKED`;
- no unexplained in-scope test or evidence failure remains;
- protected evidence is intact;
- required material artifacts are retained and referenced.

Synchronization with `origin/main`, conflict resolution, shared-file reconciliation, documentation synchronization, PR state, and merge authorization remain repository-workflow responsibilities.

Passing checks do not authorize merge without repository-owner acceptance where that authority is required.

## 9. Release And Deployment Testing Evidence

Testing evidence for release or deployment candidacy may require:

- production build;
- dependency and security checks;
- migration validation;
- configuration preflight;
- backup or rollback readiness;
- staging acceptance;
- browser smoke;
- external integration smoke;
- queue and scheduler health;
- monitoring and alert readiness;
- operational reviewer;
- retained result artifacts.

Every required release or deployment proof must be `EXECUTED + PASS`.

Exact procedures belong to runbooks.

## 10. Post-Deployment Testing Evidence

Post-deployment testing evidence may verify applicable:

- deployed version or revision;
- application health;
- critical route smoke;
- database state;
- migration completion;
- queue and scheduler health;
- asset availability;
- error rate;
- monitoring;
- external integration health;
- rollback decision window.

Post-deployment proof must be safe and non-destructive.

Every required post-deployment proof must be `EXECUTED + PASS` unless a separately accepted runbook defines another exact safe result.

## 11. Test Selection

Select:

1. the targeted proof for each changed criterion;
2. owner-local regression;
3. direct consumer or provider integration proof;
4. shared-infrastructure suites affected by the change;
5. system, browser, performance, security, or operational proof when risk requires it.

Do not run every suite as a substitute for selecting the correct targeted proof.

Do not omit a required targeted proof merely because a broad suite passes.

## 12. Failure Handling

For each blocked or failed proof, record:

- proof ID;
- criterion IDs;
- stage;
- applicability;
- execution status;
- result when executed;
- command or procedure;
- environment;
- blocking prerequisite or failure classification;
- whether it is in scope;
- whether it blocks testing acceptance;
- allowed next action;
- evidence location.

In-scope failures must be resolved or the work remains blocked.

Out-of-scope failures are reported and preserved. They are not automatically repaired.

A proof that began execution and encountered an environment, fixture, dependency, boot, tooling, or discovery problem is `EXECUTED + FAIL`, not `BLOCKED`.

## 13. Flaky Tests

A flaky test produces inconsistent results without an accepted behavior or environment change.

Flaky tests are failures of evidence reliability.

When flakiness is observed:

1. preserve failing and passing evidence;
2. identify the nondeterministic boundary;
3. stop using the proof as a mandatory passing gate until reliability is restored or an accepted alternative proof exists;
4. create or identify bounded remediation;
5. do not hide flakiness with automatic retries alone.

Temporary quarantine requires:

- explicit owner;
- reason;
- replacement or repair plan;
- expiration or review condition;
- no silent exclusion from required coverage.

A quarantined proof does not count as accepted proof for a criterion unless an accepted replacement proof exists.

## 14. Skipped And Incomplete Tests

Required behavior must not be accepted while its only proof is:

- skipped;
- incomplete;
- placeholder;
- unconditional;
- excluded from discovery;
- dependent on unavailable undeclared infrastructure.

A skipped or incomplete required proof is `NOT_RUN` until attempted and blocks testing acceptance when due.

Scaffolded tests may exist before an issue is ready, but they are not implementation evidence.

## 15. Test Result Artifacts And Retention

### 15.1. Routine development runs

Routine test-driven iterations may use console output only when they are not relied upon for:

- initial accepted baseline;
- final acceptance;
- failed mandatory gate evidence;
- specialist review;
- release or deployment;
- another formal decision.

Routine output does not need to be committed or retained.

### 15.2. Material verification runs

Retain structured evidence for:

- preimplementation `EXPECTED_NONPASS`;
- accepted characterization baseline;
- final targeted proof;
- mandatory security proof;
- mandatory database or migration proof;
- mandatory browser proof;
- mandatory performance proof;
- mandatory native-platform or operational proof;
- failed mandatory proof;
- release and deployment proof;
- any execution explicitly relied upon in an acceptance decision.

A material run should produce:

- runner-native structured report where supported;
- per-run evidence manifest;
- supplementary console log, screenshot, coverage, trace, or report only when applicable.

### 15.3. Artifact structure

A material execution should be represented conceptually as:

```text
<run-id>/
├── manifest.json
├── runner-report.xml
├── console.log
├── screenshots/
└── supplementary-reports/
```

Only applicable artifacts are required.

The manifest should identify:

- run ID;
- `PF-*` IDs;
- `AC-*` IDs;
- revision;
- command or procedure;
- working directory;
- environment;
- stage;
- applicability;
- execution status;
- verification result;
- exit code;
- report identity;
- report hash when required;
- limitations;
- reviewer when applicable.

The exact directory, schema, naming convention, and automation remain separate implementation decisions.

### 15.4. Storage and retention

Generated result artifacts should normally be:

- written to a gitignored local result directory;
- uploaded by CI as retained workflow artifacts;
- referenced from the issue or pull request;
- retained for the period required by the work packet, release policy, or evidence sensitivity;
- deleted automatically after retention expires.

Generated result artifacts are not canonical source.

Do not commit ordinary runner output, screenshots, coverage trees, or per-run manifests unless an accepted issue explicitly requires durable repository evidence.

Protect artifact integrity with revision identity and report hashes when risk or acceptance requires it.

Evidence output must redact secrets, tokens, session material, credentials, connection strings, private keys, sensitive personal data, and restricted operational details.

### 15.5. Prohibited shared test log

Do not append test history to one shared source-controlled `test_log`, `test_log.txt`, Markdown ledger, or similar flat file.

A shared append-only log is prohibited because it:

- creates merge conflicts and repository churn;
- mixes unrelated local and CI executions;
- weakens revision and environment traceability;
- cannot reliably represent structured reports, screenshots, or coverage;
- grows without bounded retention;
- increases sensitive-data exposure;
- becomes difficult to query and validate.

Issues and pull requests retain the authoritative concise proof summary. Structured artifacts retain detailed execution evidence.

## 16. Reporting

A material validation claim should include:

```text
Proof ID:
Criterion IDs:
Stage:
Applicability:
Execution status:
Verification result:
Command or procedure:
Operating system:
Runtime:
Working directory:
Revision:
Exit code:
Artifact reference:
Report hash:
Limitations:
Reviewer:
```

Concise summaries may omit fields that are genuinely not applicable, but must preserve enough information for review and reproduction.

The issue or pull request should not reproduce thousands of lines of runner output.

## 17. Testing Acceptance Completeness

Testing acceptance is complete only when:

- every acceptance criterion maps to accepted proof;
- every required proof is `EXECUTED + PASS` at the final applicable stage;
- every conditional proof due at that stage is resolved;
- every required manual or specialist testing review is complete;
- required material artifacts are retained and referenced;
- known testing limitations are explicit;
- no protected evidence was weakened without revision.

Testing acceptance completeness does not authorize issue closure, pull-request merge, milestone closure, release, or deployment.

Those decisions require the applicable workflow and repository-owner authority.

A pull request, issue, milestone, release, or deployment is not complete merely because implementation code exists or testing acceptance is complete.

## 18. Related

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Runbook Index](../../10-runbooks/index.md)
