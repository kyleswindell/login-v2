<!--
DOC-META
title: Testing Gate Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/reporting-and-gates/testing-gate-standards.md
parent: docs/02-standards/testing/reporting-and-gates/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines stage-specific testing-evidence completeness for preimplementation, development, pull request, merge candidacy, release, deployment, post-deployment, and final testing acceptance.
-->

# Testing Gate Standards

Parent: [Reporting And Testing Gates Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Testing Gate Model](#2-testing-gate-model)
- [3. Gate Evaluation](#3-gate-evaluation)
- [4. Implementation-Readiness Testing Evidence](#4-implementation-readiness-testing-evidence)
- [5. Preimplementation Testing Gate](#5-preimplementation-testing-gate)
- [6. Development Testing Evidence](#6-development-testing-evidence)
- [7. Pull Request Testing Evidence](#7-pull-request-testing-evidence)
- [8. Merge-Candidacy Testing Gate](#8-merge-candidacy-testing-gate)
- [9. Release And Deployment Testing Gates](#9-release-and-deployment-testing-gates)
- [10. Post-Deployment Testing Gate](#10-post-deployment-testing-gate)
- [11. Proof And Regression Selection](#11-proof-and-regression-selection)
- [12. Failure, Flaky, Skipped, And Incomplete Proof](#12-failure-flaky-skipped-and-incomplete-proof)
  - [Failed or blocked proof](#failed-or-blocked-proof)
  - [Flaky proof](#flaky-proof)
  - [Skipped or incomplete proof](#skipped-or-incomplete-proof)
- [13. Testing Acceptance Completeness](#13-testing-acceptance-completeness)
- [14. Prohibited Gate Shortcuts](#14-prohibited-gate-shortcuts)
- [15. Related](#15-related)

## 1. Purpose And Authority

Define the testing-evidence conditions required before testing can support workflow-stage decisions.

This standard owns testing completeness for:

- implementation readiness;
- preimplementation;
- development;
- pull request;
- merge candidacy;
- release;
- deployment;
- post-deployment;
- final testing acceptance.

It does not own:

- proof-state vocabulary;
- initial-proof semantics;
- evidence artifact formats;
- GitHub Project state;
- PR readiness or merge authorization;
- release authorization;
- deployment authorization;
- issue or milestone closure;
- repository-owner acceptance.

Those remain with their focused testing owners, repository workflow, runbooks, accepted work packet, and human authority.

## 2. Testing Gate Model

Each testing gate evaluates declared `PF-*` proofs at one workflow stage.

Proof state uses the canonical model defined by [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).

Testing gates do not create alternate meanings for:

- `REQUIRED`;
- `CONDITIONAL`;
- `NOT_APPLICABLE`;
- `NOT_RUN`;
- `BLOCKED`;
- `EXECUTED`;
- `PASS`;
- `EXPECTED_NONPASS`;
- `FAIL`.

A proof-stage state does not independently change repository workflow state.

## 3. Gate Evaluation

A proof stage satisfies testing evidence only when:

```text
Applicability: NOT_APPLICABLE
Reason: accepted before evaluation
```

or when:

```text
Applicability: REQUIRED
Execution status: EXECUTED
Verification result: exact result accepted for the stage
```

Final, PR, merge-candidacy, release, deployment, post-deployment, and completion stages normally require `PASS`.

The following do not satisfy a required stage:

```text
REQUIRED + NOT_RUN
REQUIRED + BLOCKED
REQUIRED + EXECUTED + FAIL
REQUIRED + EXECUTED + unexpected PASS
REQUIRED + EXECUTED + unexpected nonpass
CONDITIONAL unresolved when due
```

A gate evaluates accepted contract state; it does not repair or revise the contract.

## 4. Implementation-Readiness Testing Evidence

Before testing evidence can support implementation readiness, confirm that the accepted work packet has:

- observable acceptance criteria;
- canonical requirement sources and owners;
- stable `AC-*` and `PF-*` identifiers;
- complete criterion-to-proof mapping;
- proof modes;
- required stages;
- stage-specific applicability;
- initial and final expected results;
- required environments;
- responsible executors;
- required actors and fixtures;
- production implementation boundary;
- allowed proof-only work;
- baseline identity strategy;
- proof-specific stop conditions;
- manual or specialist review authority;
- revision authority where protected proof applies.

Detailed declaration requirements belong to the [Verification Contract Standards Index](../verification-contract/index.md).

Implementation authorization itself remains with the Agent Implementation Checklist and accepted work packet.

## 5. Preimplementation Testing Gate

When initial proof is `REQUIRED`, testing evidence supports production implementation only when:

- required environment preflight is valid;
- proof and fixtures execute validly;
- the exact declared initial result is observed;
- the result is attributable to the intended target behavior;
- unrelated failures are absent;
- material execution evidence is retained;
- the protected baseline is identified;
- protected semantics and edit authority are known;
- production implementation did not precede the accepted proof.

For preservation work, initial proof normally requires `PASS`.

For new or corrected behavior, initial proof normally requires the exact declared `EXPECTED_NONPASS`.

An unexpected pass where `EXPECTED_NONPASS` was required is `FAIL`.

A different nonpass is `FAIL`.

When preimplementation applicability is `NOT_APPLICABLE`, record the accepted reason and the final proof that remains required.

Initial-proof and baseline rules are owned by [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md).

## 6. Development Testing Evidence

During implementation, testing evidence should demonstrate that:

- work began after every required preimplementation testing condition was satisfied;
- targeted proof runs at useful intervals;
- changed artifact types receive applicable static checks;
- the protected baseline remains identifiable;
- material proof changes are either preauthorized mechanical edits or accepted contract revisions;
- new failures are investigated rather than concealed;
- broad suites are not used to hide targeted failure;
- required tests do not remain incomplete;
- documentation and generator changes receive their applicable verification.

Routine development runs may remain console-only when they are not used for formal acceptance.

A passing materially modified proof does not count without the required revision authority.

## 7. Pull Request Testing Evidence

Testing evidence supplied for a pull request should report applicable:

- criteria and proofs covered;
- stage applicability;
- execution status and result for each required proof;
- initial-proof decision;
- protected-baseline identity;
- targeted commands or procedures;
- final targeted results;
- protected-proof changes and accepted revisions;
- broader affected suites;
- static and build checks;
- database or migration proof;
- browser, visual, accessibility, security, performance, compatibility, native-platform, or operational proof;
- manual and specialist review state;
- proofs not run and why;
- blockers and known evidence failures;
- artifact references;
- limitations and remaining testing risk.

Detailed report fields and artifacts are owned by [Verification Reporting And Artifact Standards](verification-reporting-and-artifact-standards.md).

Repository workflow may require additional non-testing PR information.

## 8. Merge-Candidacy Testing Gate

Testing evidence is complete for merge candidacy only when applicable:

- every required final targeted proof is `EXECUTED + PASS`;
- final targeted proof preserves accepted baseline semantics;
- the accepted command is rerun, except for a preauthorized path-only update;
- protected-file changes are reconciled;
- required broader suites pass;
- mandatory static and documentation checks pass;
- required browser, visual, accessibility, security, database, performance, compatibility, native-platform, operational, manual, and specialist proof is accepted;
- no required proof is `NOT_RUN` or `BLOCKED`;
- no unexplained in-scope verification failure remains;
- required material artifacts are retained and referenced;
- known limitations are explicit.

Synchronization with `origin/main`, conflict resolution, shared-file reconciliation, PR state, and merge authorization remain repository-workflow responsibilities.

Passing testing gates does not authorize merge.

## 9. Release And Deployment Testing Gates

Release or deployment testing evidence may require applicable:

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
- retained material artifacts.

Every proof declared required for the release or deployment stage must satisfy its stage requirement, normally `EXECUTED + PASS`.

Exact deployment and rollback procedures belong to runbooks.

Testing acceptance does not authorize release or deployment.

## 10. Post-Deployment Testing Gate

Post-deployment proof may verify applicable:

- deployed revision;
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

Every required post-deployment proof normally requires `EXECUTED + PASS` unless an accepted runbook defines another exact safe condition.

## 11. Proof And Regression Selection

At each stage, select the proof necessary to establish changed risk rather than running every suite indiscriminately.

Consider:

1. targeted proof for each changed criterion;
2. owner-local regression;
3. direct provider or consumer integration;
4. shared infrastructure affected by the change;
5. system, browser, performance, security, compatibility, or operational proof required by risk.

Do not:

- omit targeted proof because a broad suite passes;
- run every suite as a substitute for proof selection;
- narrow the accepted target command merely to avoid failure.

Risk-based selection principles are owned by [Testing And Verification Standards](../testing-and-verification-standards.md).

## 12. Failure, Flaky, Skipped, And Incomplete Proof

### Failed or blocked proof

A mandatory `BLOCKED` or `FAIL` proof prevents testing acceptance for the affected stage.

Preserve evidence and apply only authorized recovery.

Out-of-scope failures are reported and preserved; they are not automatically repaired.

### Flaky proof

A flaky proof produces inconsistent results without an accepted behavior or environment change.

Flakiness is a failure of evidence reliability.

When observed:

1. preserve passing and failing evidence;
2. identify the nondeterministic boundary;
3. stop relying on the proof as a mandatory passing gate until reliability is restored or an accepted replacement exists;
4. create or identify bounded remediation.

Do not hide flakiness with automatic retries alone.

Temporary quarantine requires:

- explicit owner;
- reason;
- repair or replacement plan;
- review or expiration condition;
- no silent loss of required coverage.

A quarantined proof does not satisfy a criterion unless an accepted replacement proof exists.

### Skipped or incomplete proof

Required behavior is not accepted when its only proof is:

- skipped;
- incomplete;
- placeholder;
- unconditional;
- excluded from discovery;
- dependent on undeclared unavailable infrastructure.

A required proof not executed remains `NOT_RUN` until execution begins.

## 13. Testing Acceptance Completeness

Testing acceptance is complete only when applicable:

- every criterion maps to accepted proof;
- every required initial proof has the accepted result;
- every protected baseline is identifiable;
- production implementation did not precede a mandatory initial proof;
- every required final proof satisfies its stage result;
- every due conditional proof is resolved;
- required manual and specialist testing review is complete;
- final targeted proof preserves accepted baseline semantics;
- protected changes are reconciled;
- material artifacts are retained and referenced;
- testing limitations are explicit;
- no protected proof was weakened without accepted revision.

For work with no separate preimplementation execution, completeness still requires final proof and the accepted reason for initial `NOT_APPLICABLE`.

Testing acceptance completeness does not authorize:

- issue closure;
- pull-request merge;
- milestone closure;
- release;
- deployment.

## 14. Prohibited Gate Shortcuts

Do not:

- treat a testing gate as repository-workflow authorization;
- reclassify failed required proof as `NOT_APPLICABLE`;
- accept `BLOCKED` or `NOT_RUN` proof as complete;
- use an unexpected `PASS` as valid initial proof when `EXPECTED_NONPASS` was declared;
- count quarantined proof without an accepted replacement;
- omit required specialist review because automation passes;
- use a broad suite to replace missing targeted proof;
- silently ignore protected-baseline drift;
- alter proof semantics during gate evaluation.

## 15. Related

- [Reporting And Testing Gates Standards Index](index.md)
- [Verification Reporting And Artifact Standards](verification-reporting-and-artifact-standards.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Agent Implementation Checklist](../../coding/Agent%20Implementation%20Checklist.md)
