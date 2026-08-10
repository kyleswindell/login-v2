<!--
DOC-META
title: Integration And System Testing Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/integration-and-system/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes integration, system, end-to-end, application smoke, acceptance, and exploratory testing standards.
-->

# Integration And System Testing Standards Index

Parent: [Testing Standards Index](../index.md)

## 1. Purpose

Route proof involving assembled components, owners, processes, services, systems, representative workflows, or acceptance review.

## 2. Scope

This family owns integration categories and ownership, cross-owner Contract integration, protocol/worker/Registry/database integration, system/E2E boundaries, application-level smoke, acceptance proof, and exploratory testing.

It does not define public Contracts, feature/flow behavior, schema, reliability policy, operational procedures, or acceptance authority.

## 3. Standards

| Standard                                                                                        | Owns                                                                                                                       |
| ----------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| [Integration Testing Standards](integration-testing-standards.md)                               | Integration categories, ownership, cross-owner Contracts, APIs/protocols, async/worker, Registry, and database integration |
| [System And End-To-End Testing Standards](system-and-end-to-end-testing-standards.md)           | System-boundary declaration, assembled system proof, end-to-end selection/construction, and application-level smoke        |
| [Acceptance And Exploratory Testing Standards](acceptance-and-exploratory-testing-standards.md) | Acceptance proof versus authority, manual/business acceptance, exploratory charters, findings, and scope control           |

## 4. Authority Boundaries

- Public Contracts and behavior remain with canonical architecture, feature, flow, API, and integration owners.
- Reliability proof: [Reliability Testing Standards](../quality-and-operational-testing/reliability-testing-standards.md).
- Proof-state semantics: [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).
- Regression selection: [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md).
- Evidence artifacts: [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 5. Related

- [Testing Standards Index](../index.md)
- [Automated And Static Testing Standards](../automated-and-static-testing-standards.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Quality And Operational Testing Standards Index](../quality-and-operational-testing/index.md)
- [Public Contract And Interaction Model](../../../03-architecture/public-contract-and-interaction-model.md)
- [Flow Documentation Index](../../../05-flows/index.md)
