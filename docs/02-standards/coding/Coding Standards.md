<!--
DOC-META
title: Coding Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Coding Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines baseline coding rules for Login 2.0 application source, ownership, delivery boundaries, validation, authorization, data safety, verification routing, and documentation synchronization.
-->

# Coding Standards

Parent: [Coding Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Core Coding Rules](#2-core-coding-rules)
- [3. Ownership And Dependency Boundaries](#3-ownership-and-dependency-boundaries)
- [4. Delivery And Application Objects](#4-delivery-and-application-objects)
- [5. Validation And Authorization](#5-validation-and-authorization)
- [6. Naming And Public Boundaries](#6-naming-and-public-boundaries)
- [7. Events, Logging, Data, And Security](#7-events-logging-data-and-security)
- [8. Templates And Generated Source](#8-templates-and-generated-source)
- [9. Testing And Verification](#9-testing-and-verification)
- [10. Documentation Sync](#10-documentation-sync)
- [11. Prohibited Patterns](#11-prohibited-patterns)
- [12. Related](#12-related)

## 1. Purpose And Scope

Define baseline coding expectations shared across Login 2.0 application source.

This standard applies after the correct owner, behavior, public Contract, and file archetype have been identified.

It does not replace Repository Architecture, feature or flow behavior, database Contracts, security controls, UI Contracts, Testing Standards, Repository Naming Standards, or operational runbooks.

Use focused specialist standards for details rather than extending this baseline into a second owner of those topics.

## 2. Core Coding Rules

- Prefer small files and focused classes with one primary responsibility.
- Put behavior with the owner that defines and maintains it.
- Use explicit native types and repository PHP/Laravel style.
- Use constructor injection or another accepted explicit dependency boundary rather than hidden service location.
- Keep reads bounded and mutations explicit.
- Keep transaction ownership and failure behavior visible.
- Preserve public Contracts and compatibility unless the work packet authorizes a change.
- Use PostgreSQL behavior where PostgreSQL semantics are material.
- Remove temporary debugging, unused imports, dead scaffold code, and unresolved placeholders before review.
- Do not introduce dependencies, frameworks, architecture patterns, or generic abstractions without accepted authority.
- Do not combine unrelated cleanup with a bounded implementation slice.

## 3. Ownership And Dependency Boundaries

Login 2.0 uses owner-first organization.

Application behavior belongs to one of:

1. a Core capability;
2. an optional Module;
3. UI for reusable interface-system responsibilities.

Application-wide Laravel integration is a restricted integration boundary, not a competing application owner.

Target owner locations are governed by [Repository Architecture](../../03-architecture/repository-architecture.md).

Technical Roles remain beneath the owner that owns the responsibility. Applicable roles include Contract, Action, Query, Service, Resolver, Coordinator, Registry, Contribution, Model, Data Object, Policy, Event, Listener, Job, Notification, Delivery Adapter, Presenter, Renderer, ViewModel, and PageData.

A **Frame Surface** is a named persistent-Frame composition region. It is not a generic owner, Product, Page, flow, or catch-all `Surface/` folder.

Existing `app/Platform/`, `app/Surfaces/`, and generic owner-local `Surface/` paths are transitional where they remain. They do not establish target ownership.

Cross-owner dependencies must use accepted public Contracts. Do not import another owner's private Model, repository, table, Action, Query implementation, Service implementation, or Registry internals.

Core must not depend on optional Module implementation. Reusable UI must not depend on Core or Module domain implementation.

## 4. Delivery And Application Objects

Delivery Adapters translate an invocation channel into owner-controlled application behavior.

Controllers, API handlers, commands, webhooks, queue or scheduler entry points, and similar adapters should remain thin. They may validate or receive accepted input, invoke authorization, call owner-controlled application boundaries, and translate results into channel-specific output.

They must not become the only owner of business rules, persistence invariants, Audit behavior, Notifications, or state transitions.

Use the most precise accepted application role:

- Action for one focused operation;
- Query for bounded read behavior;
- Resolver for deterministic resolution;
- Coordinator for explicit multi-step coordination when that role is accepted;
- Service only for cohesive reusable behavior without a more precise role;
- Data Object for explicit boundary data;
- Presenter, Renderer, ViewModel, or PageData for presentation preparation.

Detailed role rules belong to [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md) and related specialist standards.

Do not create an abstraction merely because a stub or nearby legacy folder exists.

## 5. Validation And Authorization

Validate untrusted input at the boundary where it enters owner-controlled behavior.

Use Laravel Form Requests for non-trivial HTTP validation when appropriate. Keep owner invariants outside delivery-only validation when the same behavior can be invoked through other channels.

Validation and authorization are separate responsibilities. Valid input is not automatically authorized input.

Protected behavior must use the accepted Access boundary and consider applicable actor or Principal, Action, target, object-level boundary, canonical scope, lifecycle state, and assurance or elevation requirement.

Do not:

- rely on UI visibility as authorization;
- treat Workspace selection or navigation visibility as an authorization grant;
- hard-code broad role checks throughout controllers or views;
- trust an identifier merely because it passed input validation;
- allow Modules to redefine Core Access infrastructure.

## 6. Naming And Public Boundaries

Use [Repository Naming Standards](repository-naming-standards.md) and [Identifier And Key Standards](Identifier%20And%20Key%20Standards.md).

Names should make applicable owner, responsibility, artifact type, subject, Action, target, and lifecycle state clear.

Keep PHP class names, machine identifiers, display names, folders, route paths, configuration roots, and documentation titles as separate representations.

Do not preserve `Platform`, generic `Surface`, `Shared`, `Common`, `Helper`, `Utility`, `Manager`, or `Service` names merely because they exist today. Use them only when the applicable standard defines a precise responsibility.

A public Contract belongs to the owner that makes and maintains the promise. Consumers must not turn provider-private implementation into a de facto public API.

## 7. Events, Logging, Data, And Security

Events describe completed facts and must not hide a synchronous dependency that requires an immediate result.

Use the applicable Event, Job, queue, transaction, and idempotency standards for detailed behavior.

Audit-worthy behavior must use the Audit owner. Operational failures, health, telemetry, and alerts must use the applicable Logging or Monitoring owner. Application logs do not replace required Audit evidence.

Protect restricted and confidential data in source, runtime behavior, logs, tests, evidence, and documentation.

Do not expose passwords, raw tokens, API keys, MFA material, recovery codes, authorization headers, cookies, private keys, or unrestricted sensitive personal data.

Do not expose protected files through public storage or use state-changing GET routes.

Database behavior remains governed by the applicable database standard and exact database Contract.

## 8. Templates And Generated Source

Repository-owned source templates live under `stubs/`.

Use an approved stub only when it matches the accepted file archetype and target destination. A stub provides mechanical structure, not requirements, architecture, authorization, schema, expected behavior, or proof meaning.

Generated output must be completed, typed, reviewed, formatted, verified, and free of unresolved placeholders.

Use [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md) and [Stub Templates](../../../stubs/README.md).

## 9. Testing And Verification

Testing and verification policy belongs to the [Testing Standards Index](../testing/index.md).

That suite owns proof design, `AC-*` and `PF-*`, test levels, environments, initial proof, result classification, protected baselines, evidence, and testing gates.

When required proof uses test source, use the [Test Implementation Standards Index](test-implementation/index.md).

Do not default new owner-specific tests to root `tests/` merely because the test is conventionally described as unit or feature. Test placement follows the smallest clear owner and configured deterministic discovery.

Do not weaken, skip, delete, undiscover, or materially redirect protected verification source without the authority defined by the verification contract.

## 10. Documentation Sync

Update the applicable canonical documentation in the same work cycle when implementation changes durable behavior or repository truth.

Potential owners include architecture, feature behavior, flows, database Contracts, security standards, UI Contracts, runbooks, standards, agent instructions, and source-template documentation.

Use [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md).

Do not update unrelated documentation merely to make the repository appear globally current. When implementation and canonical documentation conflict, resolve authority rather than silently changing the lower-authority source.

## 11. Prohibited Patterns

Do not:

- create generic ownerless application buckets;
- place new canonical work under transitional `Platform` or generic `Surface` ownership;
- reach across owner boundaries through private implementation;
- let framework folders become competing capability owners;
- let Delivery Adapters own durable application behavior;
- bypass authorization, validation, Audit, or data-protection boundaries for convenience;
- introduce speculative abstractions or dependencies;
- treat generated source as accepted behavior;
- duplicate specialist standards here;
- weaken accepted tests to match implementation;
- hide unrelated cleanup in a scoped change.

## 12. Related

- [Coding Standards Index](index.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [File Archetypes](File%20Archetypes.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Test Implementation Standards Index](test-implementation/index.md)
- [Testing Standards Index](../testing/index.md)
- [Database Standards Index](../database/index.md)
- [Security Standards Index](../security/index.md)
- [UI Standards Index](../ui/index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
