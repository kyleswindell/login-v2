<!--
DOC-META
title: Verification Contract And Evidence Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/verification-contract-and-evidence-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines acceptance criteria, proof declarations, result semantics, initial-proof applicability, production-implementation boundaries, protected baselines, contract revision, and verification evidence.
-->

# Verification Contract And Evidence Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Verification Contract Model](#2-verification-contract-model)
- [3. Acceptance Criteria](#3-acceptance-criteria)
- [4. Verification Proofs](#4-verification-proofs)
- [5. Verification Contract Fields](#5-verification-contract-fields)
  - [5.1. Required criterion fields](#51-required-criterion-fields)
  - [5.2. Required proof fields](#52-required-proof-fields)
  - [5.3. Conditional proof fields](#53-conditional-proof-fields)
  - [5.4. Initial-proof and production-boundary fields](#54-initial-proof-and-production-boundary-fields)
  - [5.5. Proof-specific stop conditions](#55-proof-specific-stop-conditions)
- [6. Criterion And Proof Mapping](#6-criterion-and-proof-mapping)
- [7. Proof Modes](#7-proof-modes)
  - [7.1. New or corrected behavior](#71-new-or-corrected-behavior)
  - [7.2. Characterization or preservation](#72-characterization-or-preservation)
  - [7.3. Manual review](#73-manual-review)
  - [7.4. Specialist review](#74-specialist-review)
  - [7.5. Conditional proof](#75-conditional-proof)
- [8. Applicability](#8-applicability)
- [9. Execution Status](#9-execution-status)
- [10. Verification Results](#10-verification-results)
  - [10.1. `PASS`](#101-pass)
  - [10.2. `EXPECTED_NONPASS`](#102-expected_nonpass)
  - [10.3. `FAIL`](#103-fail)
- [11. Initial Proof](#11-initial-proof)
  - [11.1. Preimplementation applicability](#111-preimplementation-applicability)
  - [11.2. Mandatory initial proof](#112-mandatory-initial-proof)
  - [11.3. Conditional initial proof](#113-conditional-initial-proof)
  - [11.4. No separate preimplementation execution](#114-no-separate-preimplementation-execution)
  - [11.5. Production implementation boundary](#115-production-implementation-boundary)
  - [11.6. Allowed preimplementation proof work](#116-allowed-preimplementation-proof-work)
- [12. Protected Verification Baseline](#12-protected-verification-baseline)
  - [12.1. Pre-execution declaration](#121-pre-execution-declaration)
  - [12.2. Accepted baseline record](#122-accepted-baseline-record)
  - [12.3. Preferred baseline commit](#123-preferred-baseline-commit)
  - [12.4. Fallback baseline identity](#124-fallback-baseline-identity)
  - [12.5. Protected proof semantics](#125-protected-proof-semantics)
  - [12.6. Permitted mechanical edits](#126-permitted-mechanical-edits)
  - [12.7. Changes requiring revision](#127-changes-requiring-revision)
- [13. Verification Contract Revision](#13-verification-contract-revision)
  - [13.1. Revision triggers](#131-revision-triggers)
  - [13.2. Revision authority](#132-revision-authority)
  - [13.3. Revision procedure](#133-revision-procedure)
- [14. Execution Evidence And Result Artifacts](#14-execution-evidence-and-result-artifacts)
- [15. Failed Mandatory Proofs](#15-failed-mandatory-proofs)
- [16. Manual And Specialist Evidence](#16-manual-and-specialist-evidence)
- [17. Related](#17-related)

## 1. Purpose

Define what must be declared before proof is authoritative and what evidence is required before testing acceptance can support implementation, review, merge candidacy, release, deployment, or closure decisions.

This standard owns proof design, result semantics, baseline protection, and verification evidence. It does not independently authorize repository work or workflow progression.

## 2. Verification Contract Model

A verification contract binds:

```text
accepted requirement
        ↓
acceptance criterion (AC-*)
        ↓
verification proof (PF-*)
        ↓
declared stages and expected results
        ↓
proof execution
        ↓
protected baseline and evidence
        ↓
testing gate evaluation
```

The verification contract belongs in the implementation issue or another explicitly accepted work packet.

Canonical standards define the contract rules. The work packet supplies the criterion- and proof-specific values.

Do not combine acceptance criteria and all proof details into one overloaded matrix. Criteria, proof mapping, proof declarations, protected baselines, and execution evidence are separate records.

## 3. Acceptance Criteria

Use stable criterion identifiers:

```text
AC-01
AC-02
AC-03
```

Each acceptance criterion must identify:

- criterion ID;
- canonical requirement source;
- requirement owner;
- observable success behavior;
- required rejection or failure behavior;
- protected non-goal or compatibility rule when applicable.

An acceptance criterion must be independently reviewable.

Avoid criteria such as:

- improve quality;
- handle edge cases;
- make secure;
- finish tests;
- production-ready.

These phrases are valid only when decomposed into explicit observable criteria.

When no meaningful rejection path exists, state that explicitly and record why. Do not use `NOT_APPLICABLE` as the criterion’s result.

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

- every mapped criterion is listed;
- the proof genuinely establishes each mapped condition;
- failure can be interpreted without ambiguity;
- shared proof does not hide criterion-specific gaps.

Manual and specialist review are proofs and receive `PF-*` identifiers when they are required for acceptance.

## 5. Verification Contract Fields

### 5.1. Required criterion fields

Every executable criterion declares:

| Field                                    | Requirement                                                                                                  |
| ---------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| Criterion ID                             | Stable `AC-*` identifier                                                                                     |
| Canonical requirement source             | Exact issue section, feature, flow, schema, security, UI, architecture, runbook, or accepted decision source |
| Requirement owner                        | Authority that defines expected behavior                                                                     |
| Observable success                       | Exact behavior or state that must be established                                                             |
| Rejection or failure behavior            | Exact denied, invalid, unchanged, failed, or explicitly absent rejection path                                |
| Protected non-goal or compatibility rule | Required when adjacent behavior must remain unchanged                                                        |

### 5.2. Required proof fields

Every proof declares:

| Field                      | Requirement                                                                                                      |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Proof ID                   | Stable `PF-*` identifier                                                                                         |
| Criterion IDs              | Every criterion established by the proof                                                                         |
| Proof mode                 | New behavior, characterization, manual, specialist, conditional, or another accepted mode                        |
| Verification method        | Static, automated dynamic, browser, manual, native-platform, or specialist                                       |
| Test level                 | Unit, component, capability, integration, system, end-to-end, acceptance, or operational                         |
| Exact command or procedure | Reproducible proof                                                                                               |
| Required environment       | Material runtime, services, database, browser, operating system, or platform                                     |
| Responsible executor       | Session or reviewer responsible for execution                                                                    |
| Required execution stages  | Preimplementation, final targeted, pull request, release, deployment, post-deployment, or another declared stage |
| Stage applicability        | `REQUIRED`, `CONDITIONAL`, or `NOT_APPLICABLE` for each declared stage                                           |
| Initial expected result    | Exact expected result when a preimplementation execution is required                                             |
| Final required result      | Normally `PASS`                                                                                                  |
| Evidence destination       | Where the execution summary and material artifacts will be recorded                                              |

### 5.3. Conditional proof fields

Declare these when materially relevant:

- actor, role, authentication state, or service identity;
- fixture and test data;
- database and migration state;
- working directory;
- external-service mode;
- browser or native-platform version;
- compatibility requirement;
- design technique;
- manual or specialist reviewer;
- conditional applicability rule;
- permitted mechanical proof edits;
- prohibited proof edits;
- expected report or artifact format;
- evidence-retention requirement.

A normally expected field must not silently disappear under “where applicable.” Record an explicit reason when it is not relevant.

### 5.4. Initial-proof and production-boundary fields

Before executable production implementation, the work packet also declares:

- preimplementation applicability for every material `PF-*` proof;
- work type and reason for the applicability decision;
- exact production artifacts or artifact classes that may make the criterion pass through real system behavior;
- proof-only files and support work allowed before initial execution;
- preferred protected-baseline identity;
- fallback baseline identity when a dedicated commit is impractical;
- anticipated permitted mechanical edits;
- changes that require verification-contract revision;
- repository-owner or delegated acceptance authority;
- required specialist revision authority.

Use the existing stage-applicability values:

```text
REQUIRED
Mandatory initial proof.

CONDITIONAL
Initial proof becomes required when the declared prerequisite exists.

NOT_APPLICABLE
No separate preimplementation execution is required for the declared stage.
```

`NOT_APPLICABLE` at the preimplementation stage does not remove final verification requirements.

### 5.5. Proof-specific stop conditions

Proof-specific stop conditions may include:

- execution does not reach the target assertion;
- fixture or actor state is invalid;
- required environment is unavailable;
- observed result differs from the declared expected result;
- an initial proof unexpectedly passes;
- a different nonpass occurs;
- proof would require speculative architecture or behavior;
- protected baseline would require material revision;
- evidence cannot be captured safely.

General implementation stop conditions remain with the Agent Implementation Checklist and accepted work packet.

## 6. Criterion And Proof Mapping

Use a dedicated acceptance-criteria record:

| Criterion | Canonical source and owner  | Observable success                                       | Rejection or failure behavior                               | Protected non-goal                              |
| --------- | --------------------------- | -------------------------------------------------------- | ----------------------------------------------------------- | ----------------------------------------------- |
| `AC-01`   | Core Users feature Contract | Authorized administrator suspends an active User Account | Unauthorized actor is denied and durable state is unchanged | Existing User Account identifier remains stable |

Use a separate proof map:

| Proof   | Criteria | Mode              | Method and level                     | Stage                                | Applicability | Initial expected result | Final required result |
| ------- | -------- | ----------------- | ------------------------------------ | ------------------------------------ | ------------- | ----------------------- | --------------------- |
| `PF-01` | `AC-01`  | New behavior      | Automated capability and integration | Preimplementation and final targeted | `REQUIRED`    | `EXPECTED_NONPASS`      | `PASS`                |
| `PF-02` | `AC-01`  | Specialist review | Manual security review               | Final review                         | `REQUIRED`    | No initial execution    | `PASS`                |

Detailed commands, environments, actors, fixtures, stop conditions, and evidence destinations belong in each proof declaration rather than in the proof map.

These are separate records, not one combined acceptance-and-proof matrix.

## 7. Proof Modes

### 7.1. New or corrected behavior

Use when the issue introduces behavior or corrects known incorrect behavior.

The initial proof normally requires:

```text
Applicability: REQUIRED
Execution status after run: EXECUTED
Expected result: EXPECTED_NONPASS
```

The final targeted proof requires `PASS`.

### 7.2. Characterization or preservation

Use when accepted current behavior must remain stable during refactoring, movement, or internal replacement.

The initial and final targeted proofs require `PASS`.

The contract must identify:

- behavior being preserved;
- accepted compatibility boundary;
- separately introduced new behavior;
- assertions that may not change.

Do not characterize behavior already classified as incorrect, deprecated, or disposable.

### 7.3. Manual review

Use when human judgment is required.

A manual proof declares:

- exact review surface;
- reviewer authority;
- environment;
- procedure;
- expected observable conditions;
- evidence to retain;
- stage applicability.

A manual proof may be `NOT_APPLICABLE` at an initial stage when no reviewable implementation exists and `REQUIRED` at the final stage.

### 7.4. Specialist review

Use when acceptance depends on security, database, accessibility, operational, legal, privacy, design, or other named expertise.

Specialist review does not replace applicable automated proof.

The reviewer’s authority and acceptance conditions must be recorded.

### 7.5. Conditional proof

A conditional proof declares the exact condition that determines applicability.

Example:

```text
Condition:
Required when interactive JavaScript behavior changes.
```

Before the relevant stage gate is evaluated, resolve the condition to:

- `REQUIRED`; or
- `NOT_APPLICABLE` with reason.

Do not leave a proof unresolved as `CONDITIONAL` when it becomes due.

## 8. Applicability

Applicability is stage-specific.

Use:

| Applicability    | Meaning                                                                            |
| ---------------- | ---------------------------------------------------------------------------------- |
| `REQUIRED`       | The proof must execute at the declared stage                                       |
| `CONDITIONAL`    | A declared condition will determine whether execution is required                  |
| `NOT_APPLICABLE` | The proof is intentionally excluded at the declared stage, with an accepted reason |

`NOT_APPLICABLE` is not a verification result.

A proof may have different applicability at different stages.

Example:

```text
Preimplementation:
NOT_APPLICABLE — no implemented visual surface exists.

Final review:
REQUIRED
```

Do not declare `NOT_APPLICABLE` after a required proof fails.

## 9. Execution Status

Execution status records whether an applicable proof has run.

Use:

| Execution status | Meaning                                                |
| ---------------- | ------------------------------------------------------ |
| `NOT_RUN`        | Execution has not occurred                             |
| `BLOCKED`        | A named prerequisite prevents execution from beginning |
| `EXECUTED`       | The proof or procedure ran                             |

`NOT_RUN` is neutral only before the proof becomes due. Once a required stage is reached, `NOT_RUN` means testing evidence is incomplete.

`BLOCKED` requires:

- blocking prerequisite;
- prerequisite owner;
- reason execution cannot begin;
- affected stage;
- condition required to resume.

Examples:

```text
Browser environment has not been provisioned:
BLOCKED

Browser driver launched and failed:
EXECUTED + FAIL
```

A proof-level `BLOCKED` status does not independently change GitHub issue or Project status.

## 10. Verification Results

A verification result exists only when execution status is `EXECUTED`.

Use only:

```text
PASS
EXPECTED_NONPASS
FAIL
```

### 10.1. `PASS`

Use `PASS` when the declared proof:

- executes in the required environment;
- reaches the intended assertions or review conditions;
- establishes the required condition for the declared stage;
- produces the declared acceptable result.

A zero exit code alone is insufficient when the intended assertions did not execute.

### 10.2. `EXPECTED_NONPASS`

Use `EXPECTED_NONPASS` only:

- at a preimplementation stage;
- for new or corrected behavior;
- when the proof executes validly;
- when fixtures and environment are valid;
- when the exact predeclared missing or incorrect behavior is observed;
- when the result demonstrates that production implementation is still missing.

The contract must state:

- exact expected failing assertion or observable outcome;
- exact permitted nonpass;
- results that must be classified `FAIL`.

Do not use `EXPECTED_NONPASS` for:

- final targeted proof;
- pull-request testing acceptance;
- merge candidacy;
- release;
- deployment;
- issue completion;
- syntax or parse errors;
- application boot failure;
- missing dependencies;
- invalid fixtures;
- environment or tooling failure;
- test discovery failure;
- unrelated timeout;
- deferred work;
- pending review;
- unrelated regression.

A different nonpass is `FAIL`.

An unexpected pass is also `FAIL` for the declared initial stage because the baseline assumption or proof contract requires review.

Example:

```text
Observed runner result:
Exit 0; assertion passed.

Verification result:
FAIL

Reason:
The declared initial result was EXPECTED_NONPASS.
```

### 10.3. `FAIL`

Use `FAIL` for:

- every unexpected result;
- invalid proof execution;
- expected-result mismatch;
- insufficient manual or specialist evidence;
- environment or fixture failure after execution begins;
- proof that does not reach the target behavior;
- unexpected pass where `EXPECTED_NONPASS` was required.

A `FAIL` does not authorize remediation outside the accepted issue scope.

Do not add competing verification results such as:

- `ERROR`;
- `SKIPPED`;
- `INCOMPLETE`;
- `INCONCLUSIVE`;
- `WARNING`;
- `PARTIAL_PASS`;
- `DEFERRED`;
- `XFAIL`.

Map those conditions to applicability, execution status, `FAIL`, or recorded limitations as appropriate.

## 11. Initial Proof

### 11.1. Preimplementation applicability

Every material proof declares its preimplementation-stage applicability before execution:

| Applicability    | Initial-proof meaning                                                         |
| ---------------- | ----------------------------------------------------------------------------- |
| `REQUIRED`       | A valid initial proof is mandatory before production implementation           |
| `CONDITIONAL`    | A declared prerequisite determines whether the initial proof becomes required |
| `NOT_APPLICABLE` | No separate preimplementation execution is required for this proof and stage  |

The decision must cite the work type, requirement state, environment capability, and proof limitations.

Do not:

- leave a due proof unresolved as `CONDITIONAL`;
- declare `NOT_APPLICABLE` after a required proof fails;
- force a speculative proof that would choose unresolved architecture, schema, UI, security, or operational behavior;
- treat `NOT_APPLICABLE` as permission to omit final proof.

### 11.2. Mandatory initial proof

Require an initial proof when the behavior and environment are ready for applicable:

| Work type                                                       | Required initial result                                                                      |
| --------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| New executable behavior                                         | Exact `EXPECTED_NONPASS`                                                                     |
| Bug correction                                                  | Exact `EXPECTED_NONPASS` demonstrating the accepted defect                                   |
| Refactor, movement, or internal replacement preserving behavior | `PASS` characterization baseline                                                             |
| Public Contract change                                          | Existing accepted Contract behavior `PASS`; new or changed behavior exact `EXPECTED_NONPASS` |
| Security or authorization behavior                              | Exact allowed and denied proof when safely executable                                        |
| Schema or migration behavior                                    | Exact nonpass when the missing schema or migration behavior is itself the criterion          |
| Test tooling, validator, generator, or verification command     | Self-test establishing the exact missing or incorrect tooling behavior                       |
| Compatibility-preserving change                                 | `PASS` against the accepted compatibility boundary                                           |

A missing table, route, binding, registration, dependency, or other artifact qualifies as `EXPECTED_NONPASS` only when:

- it is the exact declared missing behavior;
- the proof reaches the intended assertion or observation;
- the application, fixtures, environment, and runner are otherwise valid.

Application boot failure, invalid fixture state, broken discovery, missing unrelated infrastructure, or a different failure remains `FAIL`.

### 11.3. Conditional initial proof

Use `CONDITIONAL` when valid initial proof depends on an accepted prerequisite that is not yet available.

Examples include:

- UI behavior requiring an accepted Component or Pattern Contract and a real browser environment;
- external integration behavior requiring an authoritative sandbox, protocol fixture, or staged provider;
- native-platform behavior requiring the applicable operating system or platform service;
- performance behavior requiring accepted thresholds and a representative environment;
- operational behavior requiring an accepted runbook and safe preproduction environment.

The contract states the exact condition.

Before the stage becomes due, resolve the proof to:

- `REQUIRED`; or
- `NOT_APPLICABLE` with accepted reason.

When the prerequisite is required but unavailable, execution is `BLOCKED`. Do not substitute a weaker or simulated proof that cannot establish the criterion.

### 11.4. No separate preimplementation execution

A separate initial execution is normally not required for:

- prose-only documentation changes;
- index and link updates;
- mechanical formatting;
- metadata corrections;
- planning documents;
- non-executable source changes that cannot alter runtime or validator behavior.

Applicable final static, documentation, rendering, or manual proof still runs.

Existing checks may run before and after the change when useful, but a separately protected initial result is not mandatory unless the work changes:

- a validator;
- a guardrail;
- a generator;
- a documentation build;
- another executable behavior.

When executable verification tooling changes, use the mandatory tooling self-test rule.

### 11.5. Production implementation boundary

Production implementation is any change capable of making an acceptance criterion pass through real system behavior.

It includes applicable:

- application source;
- runtime configuration;
- migrations and production seeders;
- UI implementation;
- routes and middleware;
- Actions, Queries, services, policies, Events, Jobs, Listeners, Notifications, and adapters;
- owner registration, bindings, manifests, and package integration;
- deployment or operational scripts;
- behavior-changing feature configuration;
- production dependency or architecture changes.

The accepted work packet identifies the exact production paths or artifact classes for the issue.

When initial proof is required, do not create or modify those artifacts to implement the criterion before:

1. the initial proof executes with the declared result;
2. the execution evidence is recorded;
3. the protected baseline is identified.

Do not add production dependencies or speculative architecture merely to make an initial proof executable.

### 11.6. Allowed preimplementation proof work

Before required initial execution, the work packet may allow:

- targeted tests;
- test fixtures, factories, and scenario builders;
- test-only helpers;
- runner configuration strictly required to execute the proof;
- proof-specific scripts or static validators;
- verification-contract documentation;
- evidence directories and safe capture configuration.

Allowed proof support must:

- be necessary for the declared proof;
- remain outside production behavior;
- not make the criterion pass through real system implementation;
- preserve accepted architecture and owner boundaries;
- remain inside declared paths.

If proof support itself requires unresolved production behavior or architecture, the proof remains `NOT_RUN` or `BLOCKED` until the proper owner resolves the prerequisite.

## 12. Protected Verification Baseline

### 12.1. Pre-execution declaration

Before initial execution, declare:

- expected proof paths;
- intended protected behavior;
- expected assertions;
- expected fixtures and actor states;
- expected command and selection scope;
- required environment class;
- anticipated permitted mechanical edits;
- anticipated prohibited edits;
- preferred baseline identity;
- fallback baseline identity;
- required revision authority.

### 12.2. Accepted baseline record

After the accepted initial proof executes, record:

- proof ID;
- criterion IDs;
- exact test, fixture, Contract, script, or review-procedure paths;
- accepted commit or file hashes;
- exact command or procedure;
- working directory;
- environment;
- initial applicability, execution status, and result;
- evidence location and report hash when required;
- exact assertions and behavior protected;
- permitted mechanical edits;
- prohibited changes;
- required authority for revision.

Protected evidence may include:

- targeted tests;
- fixtures, factories, and scenario builders;
- Contract definitions;
- expected outputs;
- approved visual baselines where justified;
- UI Contract declarations;
- schema fixtures;
- security assertions;
- manual or specialist review procedures;
- baseline reports.

### 12.3. Preferred baseline commit

For writable implementation work, prefer a dedicated initial-proof commit on the issue branch before production implementation.

The commit should contain only accepted applicable:

- verification-contract records;
- targeted proof;
- proof fixtures and test-only support;
- material initial evidence references;
- non-production runner configuration required by the proof.

Record:

```text
Baseline commit:
AC-* identifiers:
PF-* identifiers:
Protected paths:
File hashes:
Exact command:
Working directory:
Environment and material versions:
Initial applicability:
Execution status:
Verification result:
Structured report hash:
Permitted edits:
Revision authority:
```

The dedicated baseline commit is preferred because it provides one reviewable point before production behavior changes. It is not a substitute for exact proof and evidence records.

### 12.4. Fallback baseline identity

When a dedicated commit is impractical, record:

- issue-branch revision;
- exact file hashes;
- exact working-tree patch or staged diff containing the proof;
- protected paths;
- exact command;
- environment;
- execution evidence and hash.

A vague reference such as “the test added earlier” is insufficient.

The fallback must still distinguish:

- proof-only work;
- production implementation;
- later authorized proof edits.

### 12.5. Protected proof semantics

Protect more than filenames.

The accepted baseline protects applicable:

- criterion-to-proof mapping;
- proof mode;
- verification method and test level;
- target success behavior;
- rejection behavior;
- assertions;
- expected values;
- actor, role, permission, and authentication state;
- fixture meaning;
- dataset cases;
- command and test-selection scope;
- required environment class;
- manual or specialist review procedure;
- expected stage result;
- material artifact or report format.

The final targeted proof must preserve the accepted proof scope and semantics.

The exact command remains unchanged unless the contract expressly preauthorizes a path-only command update caused by an accepted file move and records both commands.

### 12.6. Permitted mechanical edits

The strongest default is no protected-proof source edit after the accepted baseline.

The contract may preauthorize narrowly nonsemantic edits such as:

- formatting;
- comments;
- import or namespace adjustment;
- path update caused by an accepted file move;
- nonsemantic proof-name correction;
- runner-compatibility syntax that does not change execution, fixtures, assertions, or selected cases.

For every permitted edit, record:

- reason;
- before hash;
- after hash;
- affected path;
- confirmation that proof meaning and coverage are unchanged.

The executor may record a strictly preauthorized mechanical edit without new material approval.

Any ambiguity is a stop condition.

### 12.7. Changes requiring revision

A verification-contract revision is required before applicable:

- assertion change;
- expected-value change;
- dataset-case removal or narrowing;
- actor, permission, authentication, or scope change;
- fixture-semantic change;
- skip, exclusion, quarantine, or discovery change;
- command narrowing;
- database-engine substitution;
- replacement of a real boundary with a mock or fake;
- proof-mode, method, or level change;
- required-environment-class change;
- expected-result change;
- criterion-to-proof mapping change;
- change that makes a previously failing proof pass without production implementation.

Protected evidence must not be:

- weakened;
- skipped;
- deleted;
- replaced with unconditional assertions;
- changed to assert private implementation instead of accepted behavior;
- materially rewritten to fit incorrect production code;
- moved out of discovery;
- made environment-dependent without accepted reason.

## 13. Verification Contract Revision

### 13.1. Revision triggers

A material revision is required when changing:

- acceptance meaning;
- expected behavior;
- rejection behavior;
- criterion-to-proof mapping;
- proof mode, method, or level;
- protected tests, fixtures, or review procedures;
- proof environment;
- stage applicability;
- required reviewer;
- expected result;
- compatibility expectation;
- permitted or prohibited proof edits.

Implementation convenience is not sufficient reason.

### 13.2. Revision authority

A material revision requires acceptance from:

- the repository owner; or
- an explicitly delegated issue-acceptance authority.

Also require applicable specialist acceptance when the revision affects:

- security;
- database or migration behavior;
- accessibility;
- visual design;
- privacy or data governance;
- operations or recovery;
- another named specialist domain.

The implementing Codex or agent session may propose a revision. It may not approve its own material revision.

A strictly preauthorized mechanical edit may be recorded by the executor only when it remains fully inside the accepted permitted-edit list.

### 13.3. Revision procedure

A revision must:

1. identify the original contract and revision;
2. identify affected `AC-*` and `PF-*` IDs;
3. explain why the contract is incorrect or incomplete;
4. describe the exact proposed change;
5. assess whether accepted behavior changes;
6. preserve the prior baseline and execution evidence;
7. identify production work relying on the old baseline;
8. identify and obtain the required acceptance authority;
9. be accepted before protected evidence is modified;
10. define any required revised initial proof;
11. execute and record the revised initial proof when required;
12. establish a new protected baseline.

The revised record must retain the superseded baseline for traceability.

## 14. Execution Evidence And Result Artifacts

Each execution record must identify:

- proof ID;
- criterion IDs;
- declared stage;
- applicability;
- execution status;
- result when executed;
- exact command or procedure;
- operating system;
- runtime and material tool versions;
- working directory;
- target revision or commit;
- protected-baseline commit or fallback identity when applicable;
- protected path and file hashes when applicable;
- authorized mechanical edits or contract revision when applicable;
- start and end time when required;
- exit code when applicable;
- observed result;
- limitations;
- reviewer when applicable;
- evidence location.

Material verification runs should also produce:

1. a runner-native structured report where supported;
2. a small per-run evidence manifest;
3. supplementary logs, screenshots, coverage, or reports only when applicable.

The manifest should identify at least:

- run ID;
- `PF-*` IDs;
- `AC-*` IDs;
- revision;
- protected-baseline identity when applicable;
- command or procedure;
- environment;
- applicability;
- execution status;
- result;
- exit code;
- report identity;
- report hash when required;
- protected-proof edit record when applicable;
- contract revision when applicable;
- limitations.

Do not append material test history to one shared source-controlled flat file.

Generated result artifacts are evidence, not canonical source. Store them in a gitignored local location or retained CI artifact system according to [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md).

Do not claim a test, suite, environment, platform workflow, or validation passed unless the exact declared proof succeeded.

## 15. Failed Mandatory Proofs

When a mandatory proof is `BLOCKED`, produces `FAIL`, or has an unauthorized protected-baseline change:

1. stop dependent testing acceptance;
2. preserve the command, output, environment, and repository state;
3. record applicability, execution status, and result;
4. classify the failure;
5. determine whether it is in scope;
6. report the blocker, failure, or baseline violation and allowed next action;
7. preserve the accepted baseline and unauthorized diff when applicable;
8. perform only preauthorized bounded recovery.

A blocked or failed proof is not automatic authorization to:

- repair unrelated tooling;
- update dependencies;
- rewrite fixtures;
- weaken tests;
- change architecture;
- alter production behavior outside scope.

## 16. Manual And Specialist Evidence

Manual or specialist evidence must identify:

- proof ID;
- criterion IDs;
- stage and applicability;
- environment;
- actor or role;
- route, Page, command, workflow, or operational surface;
- procedure;
- expected result;
- actual result;
- screenshots or recordings when appropriate;
- reviewer and authority;
- date;
- limitations;
- execution status;
- verification result.

Reviewer unavailability is `BLOCKED`, not `FAIL`, when review has not begun.

Completed review with insufficient evidence is `EXECUTED + FAIL`.

Specialist review must record any conditions on acceptance.

## 17. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
