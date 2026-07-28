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
summary: Defines acceptance-to-proof mapping, result states, preimplementation proof, protected evidence, revision authority, and verification records.
-->

# Verification Contract And Evidence Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Verification Contract](#2-verification-contract)
- [3. Acceptance Criterion Identity](#3-acceptance-criterion-identity)
- [4. Proof Mapping](#4-proof-mapping)
- [5. Result States](#5-result-states)
  - [5.1. `PASS`](#51-pass)
  - [5.2. `EXPECTED_NONPASS`](#52-expected_nonpass)
  - [5.3. `FAIL`](#53-fail)
  - [5.4. `NOT_APPLICABLE`](#54-not_applicable)
- [6. Preimplementation Proof](#6-preimplementation-proof)
- [7. Protected Evidence](#7-protected-evidence)
- [8. Verification Contract Revision](#8-verification-contract-revision)
- [9. Evidence Record](#9-evidence-record)
- [10. Failed Mandatory Gates](#10-failed-mandatory-gates)
- [11. Manual And Specialist Evidence](#11-manual-and-specialist-evidence)
- [12. Related](#12-related)

## 1. Purpose
s
Define what must be declared before a proof is authoritative and what evidence is required before implementation, merge, release, or closure can be claimed.

## 2. Verification Contract

A verification contract binds:

```text
accepted requirement
        ↓
observable criterion
        ↓
declared proof
        ↓
expected initial result
        ↓
required final result
        ↓
protected evidence
        ↓
review authority
```

The verification contract belongs in the implementation issue or another explicitly accepted work packet. Canonical standards define the rules; the issue supplies the work-specific values.

Each contract must identify, where applicable:

- acceptance criterion identifier;
- requirement owner;
- target behavior;
- rejection behavior;
- proof type and level;
- exact command or manual procedure;
- environment and runtime;
- working directory;
- fixtures, actors, and data;
- expected initial result;
- required final result;
- protected tests and fixtures;
- allowed test edits;
- prohibited test edits;
- manual or specialist reviewer;
- stop conditions;
- evidence location.

## 3. Acceptance Criterion Identity

Use stable criterion identifiers for executable work:

```text
AC-01
AC-02
AC-03
```

An acceptance criterion must be observable and independently reviewable.

Avoid criteria such as:

- improve quality;
- handle edge cases;
- make secure;
- finish tests;
- production-ready.

These phrases are valid only when decomposed into explicit observable criteria.

A criterion may map to multiple proofs. One proof may cover multiple criteria only when the mapping is explicit.

## 4. Proof Mapping

Use a table or equivalent issue structure:

| Criterion | Success behavior          | Rejection behavior           | Proof                 | Environment                 | Initial result                                | Final result     | Review          |
| --------- | ------------------------- | ---------------------------- | --------------------- | --------------------------- | --------------------------------------------- | ---------------- | --------------- |
| AC-01     | Authorized actor succeeds | Unauthorized actor is denied | Targeted feature test | PostgreSQL test environment | `EXPECTED_NONPASS` for missing allow behavior | `PASS` unchanged | Security review |

Proof selection must identify the actual risk. “Run tests” is not a verification contract.

## 5. Result States

### 5.1. `PASS`

Use `PASS` when the declared proof executes in the required environment and proves the required condition for the declared target state.

A zero exit code alone is insufficient when the command did not execute the intended assertions.

### 5.2. `EXPECTED_NONPASS`

Use `EXPECTED_NONPASS` only when:

- the verification contract predeclares the exact missing or corrected behavior;
- the proof executes correctly;
- fixtures and environment are valid;
- the observed nonpass is the exact expected behavioral result;
- the result demonstrates that production implementation is still missing.

Examples:

- an assertion fails because the new operation is not yet implemented;
- a route returns the current incorrect status that the issue explicitly corrects;
- a contract validator rejects the exact missing registration.

Do not use `EXPECTED_NONPASS` for:

- syntax errors;
- parse errors;
- application boot failures;
- missing dependencies;
- invalid fixtures;
- missing database schema not owned by the criterion;
- environment failures;
- test discovery failures;
- tooling failures;
- timeouts unrelated to the intended behavior;
- deferred work;
- pending review;
- unrelated regressions.

### 5.3. `FAIL`

Use `FAIL` for every unexpected result or invalid proof execution.

A `FAIL` does not authorize remediation outside the accepted issue scope.

### 5.4. `NOT_APPLICABLE`

Declare `NOT_APPLICABLE` before execution when a conditional gate is intentionally excluded and the issue explains why.

Do not use `NOT_APPLICABLE` after a required proof fails.

## 6. Preimplementation Proof

For new or corrected behavior, create and run the smallest executable proof before production implementation when:

- requirements are accepted;
- environment capability is available;
- fixtures can represent the behavior;
- the proof can distinguish missing behavior from invalid setup.

For preservation work, establish a passing characterization baseline instead.

The preimplementation proof must not require speculative production architecture merely to make the test executable.

If a valid preimplementation proof cannot yet be created, the issue remains planning or blocked work until the missing requirement, schema, environment, or capability is resolved.

## 7. Protected Evidence

After acceptance, protect:

- targeted tests;
- fixtures and factories;
- contract definitions;
- expected outputs;
- approved snapshots where snapshots are justified;
- UI Contract declarations;
- schema fixtures;
- security assertions;
- manual review procedures;
- baseline reports used by the criterion.

Protected evidence must not be:

- weakened;
- skipped;
- deleted;
- replaced with unconditional assertions;
- changed to assert implementation details instead of behavior;
- materially rewritten to fit incorrect production code;
- moved out of discovery;
- made environment-dependent without accepted reason.

The same targeted proof must pass unchanged after implementation unless a verification-contract revision is accepted first.

## 8. Verification Contract Revision

A revision is required when changing:

- acceptance meaning;
- expected behavior;
- rejection behavior;
- protected tests or fixtures;
- proof environment;
- test level;
- required reviewer;
- expected result classification;
- compatibility expectation.

A revision must:

1. identify the original contract;
2. explain why it is incorrect or incomplete;
3. describe the exact proposed change;
4. assess whether accepted behavior is changing;
5. identify the authority that may approve the revision;
6. be accepted before protected evidence is modified.

Implementation convenience is not sufficient reason.

## 9. Evidence Record

Record successful validation with:

- exact command or procedure;
- operating system;
- runtime and material tool versions;
- working directory;
- target revision or commit;
- exit code;
- result state;
- test count or report identity when relevant;
- output or report hash when required;
- manual reviewer and date when applicable;
- unresolved limitations.

Do not claim a test, suite, environment, platform workflow, or validation passed unless the exact declared proof succeeded.

## 10. Failed Mandatory Gates

When a mandatory gate fails:

1. stop dependent implementation, integration, release, or closure work;
2. preserve the command, output, environment, and repository state;
3. classify the failure;
4. determine whether it is in scope;
5. report the failure and allowed next action;
6. perform only preauthorized bounded recovery.

A failed gate is not automatic authorization to:

- repair unrelated tooling;
- update dependencies;
- rewrite fixtures;
- weaken tests;
- change architecture;
- alter production behavior outside scope.

## 11. Manual And Specialist Evidence

Manual evidence must identify:

- environment;
- actor or role;
- route, Page, command, workflow, or operational surface;
- procedure;
- expected result;
- actual result;
- screenshots or recordings when appropriate;
- reviewer;
- date;
- limitations;
- result state.

Specialist review must record the reviewer’s authority and any conditions on acceptance.

## 12. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
