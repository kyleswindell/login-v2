<!--
DOC-META
title: Test Environment Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-environments/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes testing standards for environment validity, data and fixtures, external services, resource isolation, parallel execution, and cleanup.
-->

# Test Environment Standards Index

Parent: [Testing Standards Index](../index.md)

## 1. Purpose

Route proof authors and reviewers to the environment, data, fixture, and resource-isolation rules required for reproducible and safe verification.

## 2. Scope

This family owns required/actual environments, equivalence, PostgreSQL and database-test environment validity, test data and fixtures, external-service modes, shared-resource isolation, parallel execution, and cleanup.

It does not own application schema, production data policy, operational procedures, test-double selection, or test-source construction.

## 3. Standards

| Standard                                                                                                  | Owns                                                                                                                                             |
| --------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| [Test Environment And Equivalence Standards](test-environment-and-equivalence-standards.md)               | Required/actual environments, capability preflight, environment classes, equivalence, PostgreSQL, SQLite boundary, and database isolation        |
| [Test Data And Fixture Standards](test-data-and-fixture-standards.md)                                     | Test-data principles, factories/scenario builders/seeders as proof data, fixtures, provenance, invalid-state fixtures, and sensitive-data policy |
| [External Service And Resource Isolation Standards](external-service-and-resource-isolation-standards.md) | External-service modes, time/randomness, filesystem/queue/cache/mail/scheduler/realtime resources, parallel ownership, and cleanup               |

## 4. Reading Order

1. Read environment/equivalence rules for any proof with material runtime or platform requirements.
2. Add test-data/fixture rules when proof data, scenarios, or reusable fixtures are material.
3. Add external/resource-isolation rules when shared resources, external systems, parallel execution, or cleanup are material.
4. Read the [Test Implementation Standards Index](../../coding/test-implementation/index.md) when implementing corresponding test source.

## 5. Authority Boundaries

- Proof-state semantics: [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).
- Test-double selection: [Automated And Static Testing Standards](../automated-and-static-testing-standards.md).
- Exact schema: Database standards and `docs/06-database/`.
- Evidence artifacts/retention: [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 6. Related

- [Testing Standards Index](../index.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Automated And Static Testing Standards](../automated-and-static-testing-standards.md)
- [Test Implementation Standards Index](../../coding/test-implementation/index.md)
- [Database Standards Index](../../database/index.md)
- [Persistent Data Architecture](../../../03-architecture/persistent-data-architecture.md)
