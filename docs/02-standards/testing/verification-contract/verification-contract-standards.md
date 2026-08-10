<!--
DOC-META
title: Verification Contract Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/verification-contract/verification-contract-standards.md
parent: docs/02-standards/testing/verification-contract/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines acceptance criteria, verification proof declarations, proof modes, criterion-to-proof mapping, required contract fields, and proof-specific declaration stop conditions.
-->

# Verification Contract Standards

Parent: [Verification Contract Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Verification Contract Model](#2-verification-contract-model)
- [3. Acceptance Criteria](#3-acceptance-criteria)
- [4. Verification Proofs](#4-verification-proofs)
- [5. Required Contract Fields](#5-required-contract-fields)
  - [5.1. Criterion fields](#51-criterion-fields)
  - [5.2. Proof fields](#52-proof-fields)
  - [5.3. Conditional fields](#53-conditional-fields)
- [6. Proof Modes](#6-proof-modes)
  - [New or corrected behavior](#new-or-corrected-behavior)
  - [Characterization or preservation](#characterization-or-preservation)
  - [Manual review](#manual-review)
  - [Specialist review](#specialist-review)
  - [Conditional proof](#conditional-proof)
- [7. Criterion And Proof Mapping](#7-criterion-and-proof-mapping)
- [8. Conditional Requirements](#8-conditional-requirements)
- [9. Declaration Completeness](#9-declaration-completeness)
- [10. Proof-Specific Stop Conditions](#10-proof-specific-stop-conditions)
- [11. Prohibited Patterns](#11-prohibited-patterns)
- [12. Related](#12-related)

## 1. Purpose And Authority

Define what must be declared before a verification proof can be executed, reviewed, or relied upon as authoritative evidence.

A verification contract binds an accepted requirement to one or more explicit proofs.

The contract belongs in the implementation issue or another explicitly accepted work packet.

Canonical requirement owners define the expected behavior. This standard defines the structure used to prove it.

This standard does not define:

- applicability, execution status, or result meanings;
- initial-proof requirements;
- protected-baseline rules;
- evidence artifact storage;
- testing-gate acceptance;
- repository implementation authorization.

Those responsibilities are routed to their focused owners.

## 2. Verification Contract Model

Use this model:

```text
canonical requirement
        ↓
acceptance criterion (AC-*)
        ↓
verification proof (PF-*)
        ↓
declared stages, environment, and expected results
        ↓
proof execution
```

Criteria and proofs are separate records.

Do not combine requirement text, proof declarations, baseline records, and execution history into one overloaded matrix.

A compact map may summarize relationships, but the detailed proof declaration remains independently reviewable.

## 3. Acceptance Criteria

Use stable criterion identifiers:

```text
AC-01
AC-02
AC-03
```

Each criterion must identify:

- criterion ID;
- canonical requirement source;
- requirement owner;
- observable success behavior;
- required rejection, failure, or explicitly absent behavior;
- protected non-goal or compatibility requirement when applicable.

A criterion must be reviewable without interpreting vague quality language.

Avoid criteria such as:

- improve quality;
- handle edge cases;
- make secure;
- finish tests;
- production-ready.

Those phrases are acceptable only when decomposed into observable requirements.

When no meaningful rejection path exists, state that explicitly and explain why.

Do not use proof-state vocabulary such as `NOT_APPLICABLE` as the criterion's behavioral result.

## 4. Verification Proofs

Use stable proof identifiers:

```text
PF-01
PF-02
PF-03
```

A proof declares how one or more criteria will be demonstrated.

A criterion may map to multiple proofs.

A proof may support multiple criteria only when:

- every mapped criterion is explicit;
- the proof genuinely establishes each mapped condition;
- failure remains interpretable;
- shared proof does not conceal criterion-specific gaps.

Manual and specialist review receive `PF-*` identifiers when they are required for testing acceptance.

A proof must identify the canonical behavior it enforces. It must not become an independent source of product, schema, security, UI, or operational requirements.

## 5. Required Contract Fields

### 5.1. Criterion fields

Every material criterion declares:

| Field                         | Requirement                                              |
| ----------------------------- | -------------------------------------------------------- |
| Criterion ID                  | Stable `AC-*` identifier                                 |
| Requirement source            | Exact canonical or accepted issue source                 |
| Requirement owner             | Authority that defines expected behavior                 |
| Observable success            | Exact behavior or state that must be established         |
| Rejection or failure behavior | Exact denied, invalid, unchanged, failed, or absent path |
| Protected non-goal            | Required when adjacent behavior must remain unchanged    |

### 5.2. Proof fields

Every material proof declares:

| Field                      | Requirement                                                                                       |
| -------------------------- | ------------------------------------------------------------------------------------------------- |
| Proof ID                   | Stable `PF-*` identifier                                                                          |
| Criterion IDs              | Every criterion established by the proof                                                          |
| Proof mode                 | New/corrected behavior, characterization, manual, specialist, conditional, or other accepted mode |
| Verification method        | Static, automated dynamic, browser, manual, native-platform, or specialist                        |
| Test level                 | Unit, component, capability, integration, system, end-to-end, acceptance, or operational          |
| Exact command or procedure | Reproducible proof                                                                                |
| Required environment       | Material runtime, services, database, browser, OS, or platform                                    |
| Responsible executor       | Session or reviewer responsible for execution                                                     |
| Execution stages           | Stages at which the proof is evaluated                                                            |
| Stage applicability        | Declared using the canonical state model                                                          |
| Initial expected result    | Required when preimplementation execution applies                                                 |
| Final required result      | Normally `PASS`                                                                                   |
| Evidence destination       | Where material execution evidence is recorded                                                     |

### 5.3. Conditional fields

Declare when materially relevant:

- actor or system identity;
- fixture or scenario;
- provider and consumer;
- public Contract or protocol;
- real and replaced participants;
- transaction or consistency owner;
- cleanup;
- threshold or compatibility matrix;
- known limitations;
- specialist reviewer;
- evidence sensitivity;
- proof-specific stop conditions.

Do not add fields merely to make every proof look identical.

## 6. Proof Modes

### New or corrected behavior

Use when the work introduces behavior or corrects accepted incorrect behavior.

The initial proof normally expects the exact declared `EXPECTED_NONPASS`; final targeted proof requires `PASS`.

Detailed result meaning is owned by [Verification State And Result Standards](verification-state-and-result-standards.md).

### Characterization or preservation

Use when accepted current behavior must remain stable through refactoring, movement, or internal replacement.

The contract must identify:

- behavior being preserved;
- compatibility boundary;
- assertions that must remain stable;
- any separately introduced new behavior.

Do not characterize behavior already accepted as incorrect, deprecated, or disposable.

### Manual review

Use when human judgment is required.

Declare:

- exact review surface;
- reviewer authority;
- environment;
- procedure;
- expected observable conditions;
- evidence to retain;
- stage applicability.

### Specialist review

Use when acceptance depends on security, database, accessibility, operations, privacy, design, legal, or another named expertise.

Specialist review does not replace applicable automated proof.

### Conditional proof

Use when a named condition determines whether execution is required at a stage.

Declare the exact condition before the stage becomes due.

## 7. Criterion And Proof Mapping

Maintain a concise criterion record and a separate proof map.

Example criterion record:

| Criterion | Canonical source          | Observable success                               | Rejection behavior                                  | Protected non-goal                 |
| --------- | ------------------------- | ------------------------------------------------ | --------------------------------------------------- | ---------------------------------- |
| `AC-01`   | Accepted feature Contract | Authorized actor suspends an active User Account | Unauthorized actor is denied and state is unchanged | Existing identifier remains stable |

Example proof map:

| Proof   | Criteria | Mode         | Method / level                   | Stages                            | Initial expected   | Final required |
| ------- | -------- | ------------ | -------------------------------- | --------------------------------- | ------------------ | -------------- |
| `PF-01` | `AC-01`  | New behavior | Automated capability/integration | Preimplementation, final targeted | `EXPECTED_NONPASS` | `PASS`         |
| `PF-02` | `AC-01`  | Specialist   | Manual security review           | Final review                      | —                  | `PASS`         |

Detailed command, environment, fixtures, stop conditions, and evidence destination belong in each proof declaration.

## 8. Conditional Requirements

A proof may have different applicability at different stages.

Example:

```text
Preimplementation:
NOT_APPLICABLE — no reviewable visual surface exists.

Final review:
REQUIRED
```

The meaning and valid use of `REQUIRED`, `CONDITIONAL`, and `NOT_APPLICABLE` are defined by [Verification State And Result Standards](verification-state-and-result-standards.md).

Conditional proof must resolve before the affected testing gate becomes due.

Do not use conditionality to postpone a proof whose prerequisite is already known to be required.

## 9. Declaration Completeness

Before a proof is considered ready for execution, confirm that:

- mapped criteria are explicit;
- canonical requirement sources resolve;
- expected success and rejection behavior are known;
- proof method and level are appropriate;
- exact command or procedure is reproducible;
- required environment is identified;
- actor and fixture requirements are sufficient;
- stage applicability is declared;
- expected result is declared where required;
- reviewer authority is named when applicable;
- evidence destination is known;
- proof-specific stop conditions are known.

Do not execute a proof whose missing declaration would require the executor to invent target behavior.

## 10. Proof-Specific Stop Conditions

A proof declaration should identify conditions that prevent valid execution.

Examples include:

- requirement or rejection behavior is unresolved;
- public Contract is not accepted;
- required environment is unavailable;
- fixture state cannot be created without bypassing the behavior being proven;
- reviewer authority is unavailable;
- proof would require an unauthorized production change;
- proof would require unresolved architecture, schema, security, UI, compatibility, or operational behavior;
- protected baseline would require material revision;
- evidence cannot be captured safely.

General implementation stop conditions remain with the Agent Implementation Checklist and accepted work packet.

## 11. Prohibited Patterns

Do not:

- merge criteria and proofs into one ambiguous record;
- use one proof for unrelated criteria merely to reduce proof count;
- write criteria that depend on private implementation structure;
- invent behavior from an existing test;
- infer canonical requirements from current physical placement;
- leave a due conditional proof unresolved;
- use manual review without a declared procedure and authority;
- use proof declarations to authorize repository work;
- treat a proof map as a substitute for detailed proof declarations.

## 12. Related

- [Verification Contract Standards Index](index.md)
- [Verification State And Result Standards](verification-state-and-result-standards.md)
- [Initial Proof And Baseline Standards](initial-proof-and-baseline-standards.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Reporting And Testing Gates Standards Index](../reporting-and-gates/index.md)
