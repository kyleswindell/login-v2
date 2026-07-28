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
summary: Defines testing gates, CI selection, failure and flaky-test handling, evidence reporting, merge, release, deployment, and post-deployment acceptance.
-->

# Test Reporting And Delivery Gates Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Gate Model](#2-gate-model)
- [3. Design And Readiness Gate](#3-design-and-readiness-gate)
- [4. Preimplementation Gate](#4-preimplementation-gate)
- [5. Development Gate](#5-development-gate)
- [6. Pull Request Gate](#6-pull-request-gate)
- [7. Merge Gate](#7-merge-gate)
- [8. Release And Deployment Gates](#8-release-and-deployment-gates)
- [9. Post-Deployment Gate](#9-post-deployment-gate)
- [10. Test Selection](#10-test-selection)
- [11. Failure Handling](#11-failure-handling)
- [12. Flaky Tests](#12-flaky-tests)
- [13. Skipped And Incomplete Tests](#13-skipped-and-incomplete-tests)
- [14. Reporting](#14-reporting)
- [15. Acceptance And Closure](#15-acceptance-and-closure)
- [16. Related](#16-related)

## 1. Purpose

Define when proof is required, what blocks progression, and what evidence must be reported for issue, pull request, merge, release, deployment, and operational acceptance.

## 2. Gate Model

A gate is a declared condition that must produce:

- `PASS`;
- `NOT_APPLICABLE` declared before execution;
- or a blocking result.

`EXPECTED_NONPASS` is valid only for an explicitly declared preimplementation missing-behavior proof. It is not a passing release or closure result.

## 3. Design And Readiness Gate

Before implementation:

- requirements are accepted;
- ownership is explicit;
- scope and non-goals are explicit;
- acceptance criteria have stable identifiers;
- canonical sources are identified;
- proof mapping is complete;
- environment capability is declared;
- fixtures and actors are defined;
- protected evidence is identified;
- stop conditions and review authority are known.

Implementation readiness remains governed by the Agent Implementation Checklist.

## 4. Preimplementation Gate

When required:

- environment preflight passes;
- characterization baseline passes for preservation work;
- the smallest new-behavior proof produces the exact declared `EXPECTED_NONPASS`;
- unrelated failures are not present in the targeted proof;
- no production implementation has been written before the proof.

A failed preimplementation gate blocks production implementation unless the issue defines an accepted bounded recovery.

## 5. Development Gate

During implementation:

- targeted tests run frequently;
- static checks run for changed artifact types;
- protected tests and fixtures remain unchanged unless revision is accepted;
- new failures are investigated immediately;
- unrelated suites are not used to hide targeted failure;
- no required test remains incomplete;
- documentation changes are verified when applicable.

## 6. Pull Request Gate

A pull request must report:

- issue or task;
- files changed;
- behavior changed;
- acceptance criteria;
- targeted tests and results;
- broader tests and results;
- static checks;
- build checks;
- database verification;
- browser or manual review;
- specialist review;
- tests not run and why;
- known failures;
- documentation synchronization;
- remaining risks.

The pull request gate should include only suites affected by the change plus repository-required baseline checks.

## 7. Merge Gate

Before merge candidacy:

- targeted final proof passes unchanged;
- required broader suites pass;
- mandatory static and documentation checks pass;
- current `origin/main` is synchronized where required;
- conflicts and concurrent shared-file additions are resolved;
- required manual and specialist review is accepted;
- no unexplained in-scope failure remains;
- protected evidence is intact;
- canonical documentation is synchronized.

Passing checks do not authorize merge without repository-owner acceptance where that authority is required.

## 8. Release And Deployment Gates

Release or deployment proof may require:

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
- release notes;
- operational reviewer.

Exact procedures belong to runbooks.

## 9. Post-Deployment Gate

After deployment, verify applicable:

- version or revision;
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

Post-deployment smoke must be safe and non-destructive.

## 10. Test Selection

Select:

1. the targeted proof for each changed criterion;
2. owner-local regression;
3. direct consumer or provider integration proof;
4. shared-infrastructure suites affected by the change;
5. system, browser, performance, security, or operational proof when risk requires it.

Do not run every suite as a substitute for selecting the correct targeted proof.

Do not omit a required targeted proof merely because a broad suite passes.

## 11. Failure Handling

For each failure, record:

- command;
- environment;
- result;
- failure classification;
- whether it is in scope;
- whether it blocks;
- allowed next action;
- evidence location.

In-scope failures must be resolved or the work remains blocked.

Out-of-scope failures are reported and preserved. They are not automatically repaired.

## 12. Flaky Tests

A flaky test is a test that produces inconsistent results without an accepted behavior or environment change.

Flaky tests are failures of evidence reliability.

When flakiness is observed:

1. preserve failing and passing evidence;
2. identify the nondeterministic boundary;
3. stop using the test as a mandatory passing gate until reliability is restored or an accepted alternative proof exists;
4. create or identify bounded remediation;
5. do not hide flakiness with automatic retries alone.

Temporary quarantine requires:

- explicit owner;
- reason;
- replacement or repair plan;
- expiration or review condition;
- no silent exclusion from required coverage.

## 13. Skipped And Incomplete Tests

Required behavior must not be accepted while its only proof is:

- skipped;
- incomplete;
- placeholder;
- unconditional;
- excluded from discovery;
- dependent on unavailable undeclared infrastructure.

Scaffolded tests may exist before an issue is ready, but they are not implementation evidence.

## 14. Reporting

A validation claim should include:

```text
Command:
Operating system:
Runtime:
Working directory:
Revision:
Exit code:
Result:
Scope:
Output or report:
Limitations:
Reviewer:
```

Concise summaries may omit fields that are genuinely not applicable, but must preserve enough information for review and reproduction.

Do not report “all tests pass” when only a targeted subset ran.

## 15. Acceptance And Closure

An issue may be accepted only when:

- all criteria have accepted proof;
- all mandatory gates pass;
- all required review is complete;
- documentation is synchronized;
- known limitations are explicit;
- deferred work is outside the accepted scope;
- no protected evidence was weakened without revision;
- closure authority accepts the result.

A pull request, issue, milestone, or deployment is not complete merely because implementation code exists.

## 16. Related

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Runbook Index](../../10-runbooks/index.md)
