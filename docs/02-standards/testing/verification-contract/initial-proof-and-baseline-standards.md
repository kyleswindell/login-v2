<!--
DOC-META
title: Initial Proof And Baseline Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/verification-contract/initial-proof-and-baseline-standards.md
parent: docs/02-standards/testing/verification-contract/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines preimplementation proof applicability, production-implementation boundaries, accepted initial proof, protected verification baselines, permitted mechanical edits, and material verification-contract revision.
-->

# Initial Proof And Baseline Standards

Parent: [Verification Contract Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Preimplementation Applicability](#2-preimplementation-applicability)
- [3. Work-Type Guidance](#3-work-type-guidance)
- [4. Conditional Initial Proof](#4-conditional-initial-proof)
- [5. No Separate Preimplementation Execution](#5-no-separate-preimplementation-execution)
- [6. Production Implementation Boundary](#6-production-implementation-boundary)
- [7. Allowed Proof-Only Work](#7-allowed-proof-only-work)
- [8. Baseline Declaration And Identity](#8-baseline-declaration-and-identity)
  - [Before execution](#before-execution)
  - [Accepted baseline record](#accepted-baseline-record)
  - [Preferred baseline commit](#preferred-baseline-commit)
  - [Fallback baseline identity](#fallback-baseline-identity)
- [9. Protected Proof Semantics](#9-protected-proof-semantics)
- [10. Permitted Mechanical Edits](#10-permitted-mechanical-edits)
- [11. Material Revision](#11-material-revision)
  - [Revision authority](#revision-authority)
  - [Revision procedure](#revision-procedure)
- [12. Final Targeted Proof](#12-final-targeted-proof)
- [13. Failure And Stop Conditions](#13-failure-and-stop-conditions)
- [14. Related](#14-related)

## 1. Purpose

Define the verification boundary that must be established before production implementation when initial proof is required.

This standard owns:

- preimplementation applicability rules;
- initial-proof expectations;
- production implementation boundary;
- proof-only work permitted before initial execution;
- protected-baseline identity;
- protected proof semantics;
- permitted nonsemantic edits;
- material verification-contract revision.

State and result meanings are defined by [Verification State And Result Standards](verification-state-and-result-standards.md).

Execution artifact storage and reporting are defined by [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 2. Preimplementation Applicability

Every material proof declares its preimplementation-stage applicability before execution:

| Applicability    | Initial-proof meaning                                                        |
| ---------------- | ---------------------------------------------------------------------------- |
| `REQUIRED`       | A valid initial proof is mandatory before production implementation          |
| `CONDITIONAL`    | A declared prerequisite determines whether initial proof becomes required    |
| `NOT_APPLICABLE` | No separate preimplementation execution is required for this proof and stage |

The decision should consider:

- work type;
- requirement state;
- whether current behavior must be preserved or changed;
- environment capability;
- whether the proof can execute without silently choosing unresolved target behavior.

Do not:

- leave a due proof unresolved as `CONDITIONAL`;
- declare `NOT_APPLICABLE` after a required proof fails;
- force speculative proof that chooses unresolved architecture, schema, UI, security, compatibility, or operational behavior;
- treat preimplementation `NOT_APPLICABLE` as permission to omit final proof.

## 3. Work-Type Guidance

Require a valid initial proof when behavior and environment are ready for applicable:

| Work type                                                   | Normal initial result                                                         |
| ----------------------------------------------------------- | ----------------------------------------------------------------------------- |
| New executable behavior                                     | Exact `EXPECTED_NONPASS`                                                      |
| Bug correction                                              | Exact `EXPECTED_NONPASS` demonstrating the accepted defect                    |
| Refactor or movement preserving behavior                    | `PASS` characterization                                                       |
| Public Contract change                                      | Existing accepted behavior `PASS`; changed behavior exact `EXPECTED_NONPASS`  |
| Security or authorization change                            | Exact applicable allowed/denied proof when safely executable                  |
| Schema or migration behavior                                | Exact nonpass only when missing schema behavior is itself the declared target |
| Validator, generator, test tooling, or verification command | Self-test demonstrating the exact missing or incorrect tooling behavior       |
| Compatibility-preserving change                             | `PASS` against the accepted compatibility boundary                            |

A missing artifact qualifies as `EXPECTED_NONPASS` only when:

- it is the exact declared missing behavior;
- the proof reaches the intended assertion or observation;
- the runner, environment, fixtures, and unrelated prerequisites are valid.

Boot failure, invalid fixture state, broken discovery, missing unrelated infrastructure, or a different failure remains `FAIL`.

## 4. Conditional Initial Proof

Use `CONDITIONAL` when valid initial proof depends on an accepted prerequisite not yet available.

Examples include:

- UI behavior requiring an accepted UI Contract and browser environment;
- external integration requiring an authoritative sandbox or protocol fixture;
- native-platform behavior requiring the target operating system or service;
- performance behavior requiring accepted thresholds and representative environment;
- operational behavior requiring an accepted runbook and safe verification environment.

Declare the exact condition.

Before the stage becomes due, resolve to:

- `REQUIRED`; or
- `NOT_APPLICABLE` with accepted reason.

If the prerequisite is required but unavailable, execution is `BLOCKED`.

Do not substitute weaker proof that cannot establish the criterion.

## 5. No Separate Preimplementation Execution

Separate preimplementation execution is normally unnecessary for work that cannot change executable behavior, such as:

- prose-only documentation;
- index and link updates;
- mechanical formatting;
- metadata corrections;
- planning documents;
- non-executable source changes with no effect on validation or generation.

Applicable final static, documentation, rendering, or manual proof still runs.

If the work changes a validator, guardrail, generator, documentation build, or other executable verification behavior, use the tooling initial-proof rule instead.

## 6. Production Implementation Boundary

Production implementation is any change capable of making a criterion pass through real system behavior.

Applicable examples include:

- application source;
- runtime configuration;
- migrations and production seeders;
- UI implementation;
- routes and middleware;
- Actions, Queries, Services, Policies, Events, Jobs, Listeners, Notifications, and adapters;
- owner registration, bindings, manifests, and package integration;
- deployment or operational scripts;
- behavior-changing configuration;
- production dependency or architecture changes.

The work packet identifies the exact production paths or artifact classes for the issue.

When initial proof is required, do not implement the criterion in those artifacts before:

1. valid initial proof produces the declared result;
2. material execution evidence is recorded;
3. the protected baseline is identified.

Do not add production dependencies or speculative architecture merely to make an initial proof executable.

## 7. Allowed Proof-Only Work

Before required initial execution, the accepted work packet may allow:

- targeted tests;
- fixtures, factories, and scenario builders;
- test-only helpers;
- runner configuration strictly required for proof execution;
- proof-specific scripts or static validators;
- verification-contract records;
- safe evidence-capture configuration.

Allowed proof support must:

- be necessary for the declared proof;
- remain outside production behavior;
- not make the criterion pass through real implementation;
- preserve accepted architecture and ownership;
- remain within declared paths.

If proof support itself requires unresolved production behavior, the proof remains `NOT_RUN` or `BLOCKED` until the prerequisite is resolved.

Test-source construction follows the [Test Implementation Standards Index](../../coding/test-implementation/index.md).

## 8. Baseline Declaration And Identity

### Before execution

Declare applicable:

- expected protected paths;
- intended protected behavior;
- expected assertions;
- fixture and actor semantics;
- command and selection scope;
- required environment;
- anticipated permitted mechanical edits;
- prohibited edits;
- preferred baseline identity;
- fallback baseline identity;
- revision authority.

### Accepted baseline record

After accepted initial execution, record:

- proof and criterion IDs;
- protected test, fixture, Contract, script, or review-procedure paths;
- baseline commit or file hashes;
- exact command or procedure;
- working directory;
- environment;
- initial state/result;
- evidence location and material report hash;
- protected assertions and behavior;
- permitted edits;
- revision authority.

### Preferred baseline commit

For writable implementation work, prefer a dedicated issue-branch commit containing only accepted proof-related material before production implementation.

A dedicated commit is preferred because it provides a clear review point. It does not replace exact execution and evidence records.

### Fallback baseline identity

When a dedicated commit is impractical, record enough information to reproduce the baseline, including applicable:

- branch revision;
- file hashes;
- exact working-tree or staged patch containing proof-only work;
- protected paths;
- command;
- environment;
- evidence identity.

A description such as “the tests added earlier” is insufficient.

## 9. Protected Proof Semantics

Protect proof meaning, not only filenames.

Applicable protected semantics include:

- criterion-to-proof mapping;
- proof mode;
- verification method and level;
- success and rejection behavior;
- assertions;
- expected values;
- actor, permission, authentication, and scope state;
- fixture meaning;
- dataset cases;
- command and selection scope;
- required environment class;
- manual or specialist procedure;
- expected stage result.

The final targeted proof must preserve accepted scope and semantics.

The exact command remains unchanged unless the contract preauthorizes a nonsemantic path-only update caused by an accepted move and records both commands.

## 10. Permitted Mechanical Edits

The strongest default is no protected-proof source edit after baseline acceptance.

A contract may preauthorize narrowly nonsemantic edits such as:

- formatting;
- comments;
- import or namespace adjustment;
- path update caused by an accepted file move;
- nonsemantic proof-name correction;
- runner-compatibility syntax that does not change execution, fixtures, assertions, or selected cases.

For every permitted edit, record:

- reason;
- affected path;
- before hash;
- after hash;
- confirmation that proof meaning and coverage remain unchanged.

Any ambiguity is a stop condition.

## 11. Material Revision

A material verification-contract revision is required before changing applicable:

- acceptance meaning;
- expected behavior or rejection behavior;
- criterion-to-proof mapping;
- proof mode, method, or level;
- assertions or expected values;
- dataset cases;
- actor, authentication, permission, or scope;
- fixture semantics;
- skip, exclusion, quarantine, or discovery;
- command selection scope;
- real versus fake boundary;
- required environment class;
- stage applicability;
- required reviewer;
- expected result;
- compatibility expectation;
- protected edit policy.

Implementation convenience is not sufficient reason.

### Revision authority

Material revision requires acceptance from:

- the repository owner; or
- an explicitly delegated issue-acceptance authority.

Also require applicable specialist acceptance when the revision affects security, database/migration behavior, accessibility, design, privacy/data governance, operations/recovery, or another named specialist domain.

The implementing agent may propose a revision. It may not approve its own material revision.

### Revision procedure

A revision must:

1. identify the original contract and affected `AC-*` / `PF-*`;
2. explain why the contract is incorrect or incomplete;
3. describe the exact proposed change;
4. identify whether accepted behavior changes;
5. preserve prior baseline and execution evidence;
6. identify implementation that relied on the old baseline;
7. obtain required acceptance before protected evidence changes;
8. define whether revised initial proof is required;
9. execute required revised initial proof;
10. establish a new protected baseline.

Retain the superseded baseline for traceability.

## 12. Final Targeted Proof

After production implementation:

- rerun the accepted targeted proof;
- preserve protected semantics;
- use the same command unless a preauthorized path-only update applies;
- require the final result declared by the contract, normally `PASS`;
- record any permitted mechanical edit or accepted material revision;
- retain material execution evidence.

A passing materially changed proof does not establish the original criterion unless the change was accepted through contract revision.

## 13. Failure And Stop Conditions

Stop dependent implementation or testing acceptance when:

- required initial proof is `BLOCKED`;
- executed initial proof is `FAIL`;
- observed initial result does not match the contract;
- protected evidence changed materially without accepted revision;
- baseline identity is ambiguous;
- required evidence cannot be captured;
- implementation began before a mandatory initial proof;
- proof support would require unauthorized production behavior.

A failed or blocked proof does not authorize:

- unrelated tooling repair;
- dependency updates;
- fixture rewrites;
- assertion weakening;
- architecture changes;
- out-of-scope production changes.

Preserve the baseline and relevant diff before any authorized recovery.

## 14. Related

- [Verification Contract Standards Index](index.md)
- [Verification Contract Standards](verification-contract-standards.md)
- [Verification State And Result Standards](verification-state-and-result-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md)
- [Test Implementation Standards Index](../../coding/test-implementation/index.md)
