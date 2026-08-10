<!--
DOC-META
title: Integration Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/integration-and-system/integration-testing-standards.md
parent: docs/02-standards/testing/integration-and-system/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines integration categories, ownership, cross-owner Contract proof, protocol, asynchronous, Registry, and database integration standards.
-->

# Integration Testing Standards

Parent: [Integration And System Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Integration Categories](#2-integration-categories)
- [3. Integration Proof Declaration](#3-integration-proof-declaration)
- [4. Integration-Test Ownership](#4-integration-test-ownership)
- [5. Cross-Owner Contract Integration](#5-cross-owner-contract-integration)
- [6. API And Protocol Integration](#6-api-and-protocol-integration)
- [7. Events, Jobs, Queues, And Schedulers](#7-events-jobs-queues-and-schedulers)
- [8. Registry, Contribution, And Application Registration](#8-registry-contribution-and-application-registration)
- [9. Database Integration](#9-database-integration)
- [10. Scope Control And Prohibited Patterns](#10-scope-control-and-prohibited-patterns)
- [11. Related](#11-related)

## 1. Purpose And Authority

Define how independently tested responsibilities are verified when assembled across components, owners, processes, services, infrastructure, or protocols.

Integration proof enforces accepted boundaries; it does not define them. Canonical architecture, feature, flow, schema, security, API, and provider sources remain authoritative.

## 2. Integration Categories

| Category       | Proves                                                                                     |
| -------------- | ------------------------------------------------------------------------------------------ |
| In-process     | Multiple framework/application responsibilities inside one runtime process                 |
| Cross-owner    | One application owner consuming another owner's public Contract                            |
| Process        | Behavior across separate runtime processes, such as web + worker                           |
| Service        | Communication with another service or separately deployed system                           |
| Infrastructure | Behavior dependent on PostgreSQL, queue/cache/storage/network or similar infrastructure    |
| Protocol       | Accepted HTTP, webhook, message, file, Event, Job, command, email, or interchange Contract |

Do not use `integration test` as the entire proof description.

Same-process Handler invocation does not prove process integration; local fake does not prove real provider integration; queue fake does not prove worker execution; server-rendered HTML does not prove browser integration.

## 3. Integration Proof Declaration

In addition to common contract fields, declare applicable category, provider/consumer, public Contract/protocol, real/replaced participants, public entry point, actor/system identity, transaction/consistency owner, provider success/rejection, consumer handling, final observable result, cleanup, and limitations.

When categories are combined, identify the material boundary each proves. A replaced boundary cannot be reported as a successfully tested real integration.

## 4. Integration-Test Ownership

There is no generic shared `integration` application owner.

| Proof                                  | Primary owner                            |
| -------------------------------------- | ---------------------------------------- |
| Provider public Contract               | Provider                                 |
| Provider implementation                | Provider                                 |
| Consumer use of provider Contract      | Consumer                                 |
| Cross-owner workflow                   | Owner of accepted workflow/flow Contract |
| Host Registry acceptance               | Host                                     |
| Contributor declaration/implementation | Contributor                              |
| Delivery Adapter transport translation | Delivery Adapter owner                   |
| External service adapter               | Adapter owner                            |

Test placement follows Repository Architecture and the [Test Implementation Standards Index](../../coding/test-implementation/index.md). Cross-owner proof must not create shared behavior ownership.

## 5. Cross-Owner Contract Integration

Cross-owner behavior uses provider-owned public Contracts.

```text
Consumer
    ↓ provider-owned public Contract
Provider
    ↓ provider-owned result or rejection
Consumer handles the public result
```

Provider proof verifies applicable binding/availability, accepted input/rejection, provider validation/authorization/invariants, transaction/consistency boundary, public result/failure, Boundary Data Contract, provider Events/Jobs, redaction, and compatibility.

Consumer proof verifies accepted request construction, use of public Contract rather than concrete implementation, result/rejection handling, provider-unavailable handling, compatibility, consumer follow-up, no private access, and no takeover of provider policy.

Cross-owner workflow proof identifies workflow owner, participants, Contracts, invocation order, authoritative success/rejection points, transaction ownership, Events/Jobs, observable result, and accepted rollback/compensation behavior.

Do not prove cross-owner behavior through another owner's private Model, repository, table, Action, Query Builder, concrete Job, or Registry internals.

## 6. API And Protocol Integration

Verify accepted protocol/Delivery Adapter requirements including applicable translation, content type, validation, authentication/authorization integration, provider delegation, status/error mapping, serialization, headers, pagination/filter/sort, compatibility, timeout/unavailable-provider handling, correlation/causation, safe logging, and protocol security.

Exact signatures, replay windows, rate/payload limits, schemas, versioning, retry, or redirect policy remain with canonical owners.

A controller/route test does not prove external provider integration. A provider sandbox does not automatically prove production configuration. Consumer-driven Contracts may supplement but cannot redefine provider authority.

## 7. Events, Jobs, Queues, And Schedulers

Asynchronous integration is layered.

Declaration/dispatch proof may verify Event/Job identity, payload, registration, Handler/Listener registration, dispatch, queue/scheduler selection, serialization, correlation/causation, after-commit declaration, and sensitive-data exclusions. A fake dispatcher proves intent only.

Worker/consumer proof uses the real required process/service when worker semantics are material and verifies consumption, execution, committed-state visibility, durable result, required follow-up, failure visibility, and cleanup. Direct Handler invocation does not prove queue/process integration.

Retry, timeout, backoff, duplicate delivery, idempotency, exhaustion, and recovery follow [Reliability Testing Standards](../quality-and-operational-testing/reliability-testing-standards.md).

## 8. Registry, Contribution, And Application Registration

Preserve accepted authority boundaries.

Contributor proof may verify declaration shape, owner/Host identity, Registry/Contribution key, implementation reference, dependencies, metadata, trace, and Contributor lifecycle.

Application Registration proof may verify structural/identity/path/dependency validation, cycle detection, deterministic compilation, Host routing, traceability, and structural rejection.

Host Registry proof may verify Extension Point Contract compliance, semantic validation, Host compatibility, duplicates/conflicts, ordering, availability/filtering, acceptance/rejection, and resolved output.

Proof must not imply that Application Registration decides Host policy, Contributors mutate Registry internals, Hosts own Contributor behavior, Core imports optional Module implementation, or generated registration output becomes reviewed authority.

## 9. Database Integration

Use PostgreSQL for Login 2.0 application-persistence integration claims.

Verify applicable application boot, schema prerequisites, owner-local persistence, constraints through application operations, relationships/uniqueness, transactions/rollback, cross-connection visibility, locks/concurrency, Query/projection behavior, bounded cross-owner references, retention/deletion guards, and Module persistence lifecycle.

Exact schema/migration behavior remains with Database standards and `docs/06-database/`. Database integration proof identifies its isolation strategy and must not affect shared data.

## 10. Scope Control And Prohibited Patterns

Do not use `integration test` without naming the boundary, create generic shared integration ownership, bypass provider Contracts, access another owner's private state, dispatch another owner's concrete Job as cross-owner API, use direct Handler invocation as worker proof, use fakes as proof of real boundaries, use SQLite as PostgreSQL application proof, or let integration tests invent target architecture/schema/reliability/protocol requirements.

## 11. Related

- [Integration And System Testing Standards Index](index.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Reliability Testing Standards](../quality-and-operational-testing/reliability-testing-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Public Contract And Interaction Model](../../../03-architecture/public-contract-and-interaction-model.md)
- [Persistent Data Architecture](../../../03-architecture/persistent-data-architecture.md)
