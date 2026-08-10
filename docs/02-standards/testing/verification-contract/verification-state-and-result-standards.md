<!--
DOC-META
title: Verification State And Result Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/verification-contract/verification-state-and-result-standards.md
parent: docs/02-standards/testing/verification-contract/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the canonical applicability, execution-status, and verification-result state axes used by Login 2.0 testing and verification.
-->

# Verification State And Result Standards

Parent: [Verification Contract Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Independent State Axes](#2-independent-state-axes)
- [3. Applicability](#3-applicability)
- [4. Execution Status](#4-execution-status)
- [5. Verification Results](#5-verification-results)
  - [`PASS`](#pass)
  - [`EXPECTED_NONPASS`](#expected_nonpass)
  - [`FAIL`](#fail)
- [6. `BLOCKED` Versus `FAIL`](#6-blocked-versus-fail)
- [7. Expected-Result Mismatch](#7-expected-result-mismatch)
- [8. Runner And Review Status Mapping](#8-runner-and-review-status-mapping)
- [9. Valid Stage Records](#9-valid-stage-records)
- [10. Prohibited State Conflation](#10-prohibited-state-conflation)
- [11. Related](#11-related)

## 1. Purpose

Define one canonical state model for every material Login 2.0 verification proof.

This standard owns:

- proof applicability;
- proof execution status;
- verification results;
- the distinction between blocked execution and failed execution.

Specialist standards and testing gates must use these meanings rather than redefining them.

## 2. Independent State Axes

Every proof stage uses three independent axes:

```text
Applicability:
REQUIRED | CONDITIONAL | NOT_APPLICABLE

Execution status:
NOT_RUN | BLOCKED | EXECUTED

Verification result when EXECUTED:
PASS | EXPECTED_NONPASS | FAIL
```

Do not collapse these values into a single status.

Examples:

```text
REQUIRED + NOT_RUN
```

means execution is still pending.

```text
REQUIRED + BLOCKED
```

means a named prerequisite prevents execution from beginning.

```text
REQUIRED + EXECUTED + FAIL
```

means the proof ran and did not establish the declared acceptable result.

`NOT_APPLICABLE` is not a result.

`BLOCKED` is not a result.

## 3. Applicability

Applicability is stage-specific.

| Applicability    | Meaning                                                                          |
| ---------------- | -------------------------------------------------------------------------------- |
| `REQUIRED`       | The proof must execute at the declared stage                                     |
| `CONDITIONAL`    | A declared condition determines whether execution is required                    |
| `NOT_APPLICABLE` | The proof is intentionally excluded at the declared stage for an accepted reason |

A proof may have different applicability at different stages.

Use `NOT_APPLICABLE` only when the proof is intentionally unnecessary for that stage.

Do not use it:

- after a required proof fails;
- because execution is inconvenient;
- because the required environment is unavailable;
- to remove final proof after skipping preimplementation execution.

A `CONDITIONAL` proof must resolve before the affected stage becomes due.

## 4. Execution Status

Execution status records whether proof execution occurred.

| Execution status | Meaning                                                |
| ---------------- | ------------------------------------------------------ |
| `NOT_RUN`        | Execution has not occurred                             |
| `BLOCKED`        | A known prerequisite prevents execution from beginning |
| `EXECUTED`       | The proof or review procedure began execution          |

`NOT_RUN` is neutral only before a proof becomes due.

When a required stage is due, `NOT_RUN` means testing evidence is incomplete.

A `BLOCKED` record must identify:

- blocking prerequisite;
- prerequisite owner;
- reason execution cannot begin;
- affected stage;
- condition required to resume.

A proof-level `BLOCKED` status does not independently change GitHub issue or Project state.

## 5. Verification Results

A verification result exists only for `EXECUTED` proof.

Use only:

```text
PASS
EXPECTED_NONPASS
FAIL
```

### `PASS`

Use `PASS` when the proof:

- executes in the required environment;
- reaches the intended target path, assertions, or review conditions;
- establishes the result required for the declared stage.

A zero exit code alone is insufficient if the intended assertions did not execute.

### `EXPECTED_NONPASS`

Use `EXPECTED_NONPASS` only when all of the following are true:

- execution is preimplementation;
- the proof covers new or corrected behavior;
- the environment and fixtures are valid;
- the proof reaches the intended assertion or observation;
- the exact predeclared missing or incorrect behavior is observed.

The contract must identify the exact acceptable nonpass.

Do not use `EXPECTED_NONPASS` for:

- final targeted proof;
- pull-request or merge-candidacy acceptance;
- release or deployment;
- issue completion;
- syntax or parse errors;
- application boot failure;
- invalid fixtures;
- missing unrelated dependencies;
- environment or tooling failure;
- discovery failure;
- unrelated timeout;
- deferred work;
- pending review;
- unrelated regression.

`EXPECTED_NONPASS` is evidence that the declared target behavior is not yet implemented. It is not a general failure waiver.

### `FAIL`

Use `FAIL` for every executed proof that does not produce the exact acceptable result for its stage.

Examples include:

- unexpected assertion result;
- invalid proof execution;
- expected-result mismatch;
- proof that never reaches the target behavior;
- environment or fixture failure after execution begins;
- insufficient completed manual or specialist review;
- unexpected `PASS` where `EXPECTED_NONPASS` was required.

A `FAIL` does not authorize remediation outside accepted scope.

## 6. `BLOCKED` Versus `FAIL`

Use `BLOCKED` only when execution cannot begin because a known prerequisite is unavailable.

Examples:

```text
Required browser environment has not been provisioned.
BLOCKED
```

```text
Required specialist reviewer is unavailable and review has not started.
BLOCKED
```

Use `EXECUTED + FAIL` when execution begins and encounters a problem.

Examples:

```text
Browser driver launched and then failed.
EXECUTED + FAIL
```

```text
Application boot began and dependency resolution failed.
EXECUTED + FAIL
```

```text
Manual review began but evidence was insufficient.
EXECUTED + FAIL
```

Do not reclassify an execution failure as `BLOCKED` after the fact.

## 7. Expected-Result Mismatch

The observed runner state and the verification result are not always identical.

Example:

```text
Declared initial result:
EXPECTED_NONPASS

Observed:
Target assertion unexpectedly passes

Verification result:
FAIL
```

The proof failed its declared initial expectation even though the assertion itself passed.

Similarly, a different nonpass from the one declared for initial proof is `FAIL`.

Result classification always compares the valid execution against the result required by the contract for that stage.

## 8. Runner And Review Status Mapping

Do not add competing verification results such as:

- `ERROR`;
- `SKIPPED`;
- `INCOMPLETE`;
- `INCONCLUSIVE`;
- `WARNING`;
- `PARTIAL_PASS`;
- `DEFERRED`;
- `XFAIL`.

Map tool-specific states to the canonical axes.

Examples:

| Observed condition                                                    | Canonical interpretation      |
| --------------------------------------------------------------------- | ----------------------------- |
| Required test skipped before execution                                | `REQUIRED + NOT_RUN`          |
| Runner started and reports infrastructure error                       | `EXECUTED + FAIL`             |
| Known missing browser prerequisite before launch                      | `BLOCKED`                     |
| Optional stage accepted as unnecessary                                | `NOT_APPLICABLE`              |
| Required manual review completed successfully                         | `EXECUTED + PASS`             |
| Required initial missing-behavior assertion fails exactly as declared | `EXECUTED + EXPECTED_NONPASS` |

Warnings and limitations may be recorded as evidence metadata without becoming verification results.

## 9. Valid Stage Records

A material execution record should be interpretable without inference.

Examples:

```text
Stage: Preimplementation
Applicability: REQUIRED
Execution status: EXECUTED
Verification result: EXPECTED_NONPASS
```

```text
Stage: Final targeted
Applicability: REQUIRED
Execution status: EXECUTED
Verification result: PASS
```

```text
Stage: Final visual review
Applicability: REQUIRED
Execution status: BLOCKED
Verification result: —
Reason: Required reviewer unavailable
```

```text
Stage: Preimplementation visual review
Applicability: NOT_APPLICABLE
Execution status: NOT_RUN
Verification result: —
Reason: No implemented visual surface exists
```

Testing gates determine whether a given stage record satisfies testing completeness.

## 10. Prohibited State Conflation

Do not:

- treat `NOT_APPLICABLE` as `PASS`;
- treat `BLOCKED` as `FAIL` when execution never began;
- treat execution failure as `BLOCKED`;
- use `EXPECTED_NONPASS` outside exact initial missing-behavior proof;
- mark a required skipped or incomplete proof as accepted;
- invent local result vocabularies in specialist standards;
- infer GitHub issue or Project state from proof state;
- change applicability after observing an unfavorable required result.

## 11. Related

- [Verification Contract Standards Index](index.md)
- [Verification Contract Standards](verification-contract-standards.md)
- [Initial Proof And Baseline Standards](initial-proof-and-baseline-standards.md)
- [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
