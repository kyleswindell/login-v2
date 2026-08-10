# tests AGENTS.md

## Purpose

Cross-owner and repository-wide verification.

Root `tests/` is **not** the default destination for owner-specific behavior tests.

Target test placement follows the smallest clear owner:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
tests/
```

Root `tests/` remains appropriate for cross-owner integration, system/browser verification, architecture rules, compatibility, repository rules, and shared test infrastructure.

Existing root `tests/Unit/` and `tests/Feature/` may remain during migration. Do not bulk-move tests without accepted migration and discovery scope.

## Read Order

1. Read the issue or authorized task and its declared `AC-*` / `PF-*` mapping.
2. Read the [Testing Standards Index](../docs/02-standards/testing/index.md) for proof semantics, applicability, environments, initial proof, protected baselines, evidence, and gates.
3. Read the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md) when creating or modifying test source.
4. Identify the smallest clear owner of the behavior under proof.
5. Read the existing owner-local or root test nearest to that behavior.
6. Read only the applicable test-implementation child standard and specialist testing standard.
7. Expand to broader suites only when required by the verification contract.

Do not read the full test suite for one bounded behavior.

## Root Test Ownership

Use root `tests/` when the proof is genuinely:

- cross-owner integration;
- application-wide system or end-to-end behavior;
- browser/system smoke;
- repository architecture or dependency rules;
- compatibility behavior;
- repository-wide configuration or standards enforcement;
- shared test infrastructure.

Do not put an owner-specific behavior test in root `tests/` merely because it is a feature test.

## Verification-First Rules

Acceptance criteria define required observable behavior.

Proof declarations define how that behavior is proven.

Before production implementation, follow the issue's declared initial proof and the canonical verification lifecycle.

When an initial proof establishes a protected baseline:

- do not weaken assertions;
- do not skip or delete required cases;
- do not change expected behavior to match the implementation;
- do not redirect discovery to avoid the proof;
- do not replace a required real boundary with a fake;
- do not materially rewrite fixtures, datasets, Contracts, or review procedures without accepted revision authority.

`EXPECTED_NONPASS` is allowed only for the exact predeclared missing behavior or other explicitly permitted evidence result.

Syntax, fixture, dependency, boot, discovery, tooling, environment, and unexpected execution failures are `FAIL`.

The same accepted targeted proof must pass unchanged after implementation.

## Test Source Rules

When test source changes:

- follow deterministic discovery;
- place tests with the smallest clear owner;
- use stable behavior-oriented assertions;
- verify successful and required rejection/failure behavior;
- keep fixtures minimal and representative;
- use PostgreSQL when the proof depends on PostgreSQL semantics;
- use real required boundaries unless an approved double/isolation strategy applies;
- keep browser selectors and UI assertions aligned with public UI Contracts;
- avoid implementation-detail assertions when observable behavior is the actual Contract.

Do not create production seams solely for test convenience unless they have a real application responsibility.

## Broader Verification

After the targeted proof passes, run only the broader checks required by the issue or applicable testing gate.

Broader checks do not replace the unchanged targeted proof.

Automated success does not replace declared manual visual, accessibility, security, database, privacy, operational, native-platform, or repository-owner review.

## Avoid

- Do not treat root `tests/` as the universal test owner.
- Do not add broad snapshot assertions when focused behavioral assertions are clearer.
- Do not update tests to match broken or unaccepted behavior.
- Do not preserve obsolete tests solely to maintain test count.
- Do not fix unrelated failures unless the current scope explicitly authorizes that remediation.
- Do not classify an unexpected test failure as expected missing behavior.
- Do not weaken protected proof after the initial baseline.
- Do not claim a suite passed unless the exact command actually ran successfully.

## Stop Conditions

Stop and report when:

- the behavior owner is unclear;
- the test target path is ambiguous;
- acceptance criteria or required rejection behavior are incomplete;
- initial expected proof state is not declared;
- the required environment or fixture is unavailable;
- the observed initial result differs from the declared result;
- a protected baseline appears defective and would require material revision;
- required proof fails unexpectedly;
- completing the task would require broad unrelated test cleanup.

## Related

- [Testing Standards Index](../docs/02-standards/testing/index.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [Agent Implementation Checklist](../docs/02-standards/coding/Agent%20Implementation%20Checklist.md)
