<!--
DOC-META
title: Feature Development Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Feature Development Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines bounded development rules for Core capabilities, Modules, Product and Page presentation, reusable UI, Frame composition, settings, access, observability, verification routing, and closeout.
-->

# Feature Development Standards

Parent: [Coding Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Current Vocabulary](#2-current-vocabulary)
- [3. Ownership Before Implementation](#3-ownership-before-implementation)
- [4. Layer And Responsibility Boundaries](#4-layer-and-responsibility-boundaries)
  - [Core capability](#core-capability)
  - [Module](#module)
  - [UI](#ui)
  - [Laravel integration](#laravel-integration)
  - [Technical responsibilities](#technical-responsibilities)
- [5. Canonical Feature Documentation](#5-canonical-feature-documentation)
- [6. UI And Presentation Ownership](#6-ui-and-presentation-ownership)
- [7. Setup, Settings, And Preferences](#7-setup-settings-and-preferences)
- [8. Access, Audit, Monitoring, And Failure](#8-access-audit-monitoring-and-failure)
- [9. Data Table UX](#9-data-table-ux)
- [10. Testing And Verification](#10-testing-and-verification)
- [11. Planning And Closeout](#11-planning-and-closeout)
- [12. Prohibited Patterns](#12-prohibited-patterns)
- [13. Related](#13-related)

## 1. Purpose And Scope

Ensure new and changed functionality is assigned to the correct owner, implemented within accepted architecture, documented by the correct canonical source, protected by applicable Access and data boundaries, and verified before acceptance.

This standard coordinates feature development. It does not replace Repository Architecture, feature or flow Contracts, database Contracts, Security standards, UI Contracts, Testing Standards, or runbooks.

Use the applicable canonical owner for detailed truth and this standard for the cross-cutting development expectations that tie those owners together.

## 2. Current Vocabulary

Use current project vocabulary.

| Term                | Meaning                                                                                                                        |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| Core capability     | Cohesive required base-application capability beneath the Core owner.                                                          |
| Module              | Optional cohesive feature package beneath `Modules/<Module>/`.                                                                 |
| UI                  | Reusable Elements, Components, Patterns, Layouts, Frame rendering, UI Contracts, CSS, JavaScript, and accessibility rendering. |
| Laravel integration | Restricted application-wide framework bootstrap or thin adaptation that does not own application behavior.                     |
| Workspace           | Named top-level rendered application experience available to a User Account within its resolved Tenant Instance.               |
| Product             | Major Core- or Module-owned capability available within a Workspace.                                                           |
| Product Area        | Coherent area of one Product containing related Pages and workflows.                                                           |
| Page                | Routed Product destination or deeper focused context rendered in Main.                                                         |
| Frame               | Persistent authenticated application structure that renders the active Workspace.                                              |
| Frame Surface       | Named compositional region of the persistent Frame.                                                                            |
| Delivery Adapter    | Owner-local HTTP, API, console, webhook, queue, scheduler, or other invocation integration.                                    |
| Registry            | Host-owned mechanism that validates, collects, orders, resolves, and exposes Contributions.                                    |
| Contribution        | Contributor-owned implementation supplied to a Host Extension Point.                                                           |

The word `feature` may describe user or system behavior but must not erase the implementation owner.

Do not use Module as a generic synonym for any capability.

Do not use Surface as a generic owner, Product, Page, flow, or repository folder. Use Frame Surface only for a named persistent-Frame composition region.

Existing `app/Platform/`, `app/Surfaces/`, and generic owner-local `Surface/` paths are transitional where they remain and do not establish target ownership.

## 3. Ownership Before Implementation

Before broad production implementation, identify applicable:

1. the bounded outcome and non-goals;
2. the primary application owner;
3. the specific Core capability, Module, or UI responsibility;
4. any restricted Laravel integration boundary;
5. the Product, Product Area, Page, Frame Surface, Delivery Adapter, Registry, Action, Query, Contract, or other Technical Role involved;
6. the canonical behavior owner;
7. the persistence owner and database Contracts;
8. Access, security, data-protection, Audit, and Monitoring boundaries;
9. transaction, retry, concurrency, or idempotency behavior when material;
10. the verification contract and required review;
11. the issue or planning source that owns the implementation slice;
12. canonical documentation that must stay synchronized.

Do not begin implementation while a material owner, behavior, schema, security, transaction, compatibility, or design decision remains unresolved.

Do not create a new owner or Technical Role merely because the current implementation contains a similarly named folder.

## 4. Layer And Responsibility Boundaries

### Core capability

Use Core for required base-application capabilities defined by accepted architecture.

A permanent direct child of `app/Core/` must represent one cohesive required capability. Do not create generic Core ownership buckets such as `Support`, `Shared`, `Common`, `Helpers`, `Utilities`, `Infrastructure`, `Platform`, or `Surfaces` as default destinations.

Core must operate without optional Modules and must not import optional Module implementation.

### Module

Use `Modules/<Module>/` for optional cohesive feature packages.

A Module owns its feature behavior and applicable package-local routes, configuration, persistence, presentation, tests, documentation, and Contributions.

Modules consume Core public Contracts rather than redefining required Auth, Access, Audit, Monitoring, Notifications, Settings, Security, DataGovernance, or DataProtection infrastructure.

### UI

UI owns reusable interface-system responsibilities: Elements, Components, Patterns, Layouts, Frame rendering, reusable CSS and JavaScript, UI Contracts, and reusable accessibility behavior.

UI must not own route behavior, application authorization, domain persistence, Core or Module mutations, Module discovery, or Registry policy.

A file beneath `resources/` is not automatically UI-owned. Product and Page presentation remains owned by the Core capability or Module whose behavior it exposes.

### Laravel integration

Application-wide Laravel integration is limited to framework behavior that cannot remain owner-local. It delegates durable behavior to the applicable Core capability or Module and must not become a competing feature owner.

### Technical responsibilities

Classify Technical Role separately beneath the owner.

Product and Page presentation remains owner-local. Main is a route-owned content outlet, not a Frame Surface.

A Frame Surface owns persistent-Frame composition only. It does not own Product behavior, Registry resolution, permission evaluation, or domain state.

A Delivery Adapter translates an invocation channel and delegates inward to owner-controlled behavior.

A Host owns its Extension Point Contracts and Registry; Contributions remain owned by Contributors.

Use [Repository Architecture](../../03-architecture/repository-architecture.md) and [Coding Standards](Coding%20Standards.md) for detailed placement and dependency rules.

## 5. Canonical Feature Documentation

When durable user, administrator, or system behavior changes, create or update the applicable canonical feature document under `docs/04-features/`.

A feature document should identify applicable:

- purpose and current implementation status;
- actors and supported behavior;
- Product, Product Area, Page, and Workspace context;
- success, rejection, and failure behavior;
- data behavior and database Contracts;
- Access and security requirements;
- validation;
- Events, Jobs, Notifications, Audit, and Monitoring;
- Setup, Settings, and Preferences;
- verification requirements;
- known current limitations.

Use the [Feature Spec Template](../../09-reference/templates/docs/_feature-spec.md).

Feature docs own behavior, not repository topology or implementation sequencing. Planning may link to the feature owner while work is active but must not replace it.

## 6. UI And Presentation Ownership

Before implementing presentation work, identify whether the change belongs to reusable UI, Core-owned Product or Page presentation, Module-owned presentation, or a named Frame Surface contribution.

Do not assume Filament owns all administrative UI. Use it where its accepted strengths match the required interface and keep durable business behavior in owner-controlled application objects.

Presentation code must not become the only owner of:

- business rules;
- authorization policy;
- state transitions;
- persistence invariants;
- Audit or Monitoring behavior;
- Notifications.

For design-sensitive work, identify applicable:

- Product or Page owner;
- Workspace and Frame relationship;
- named Frame Surface when the persistent Frame changes;
- UI Contract;
- Blade, CSS, and JavaScript owner;
- browser verification;
- manual visual and accessibility review.

Do not create generic `Surface/` folders for Product or Page presentation.

Codex or another implementation agent must not independently invent spacing, hierarchy, interaction, responsive behavior, or Component APIs when visual authority is unresolved.

## 7. Setup, Settings, And Preferences

Every configurable capability must identify whether behavior belongs to Setup, Settings, Preferences, Module configuration, Laravel configuration, environment configuration, Registry-backed definition, or durable database state.

Keep these concepts separate.

Visible Setup or Settings navigation must represent a real editable setting, meaningful status, configuration action, or review surface rather than an empty placeholder.

Settings must be owned, validated, permission-gated, documented, audited where material, and verified.

Do not store editable application state in Laravel configuration merely for convenience.

## 8. Access, Audit, Monitoring, And Failure

Protected behavior must define the applicable actor or Principal, Action, target, object-level boundary, canonical scope, authorization mechanism, and assurance or elevation requirement.

Do not rely on UI visibility, Workspace selection, or navigation availability as authorization.

Audit-worthy behavior must use the Audit owner. Operational failures, health, telemetry, and alerts must use the applicable Logging or Monitoring owner.

For mutations and asynchronous behavior, define applicable transaction owner, rollback behavior, retry, duplicate handling, idempotency, after-commit effects, and public failure behavior before implementation.

Do not implement required Access, Audit, Monitoring, Notification, or failure behavior only in presentation source.

## 9. Data Table UX

For operator-facing tabular views that can grow materially, provide an appropriate interaction baseline such as search or filtering, pagination, result summary, accessible controls, and permission-aware row Actions.

Use client-side behavior only for bounded in-memory datasets and server-side filtering or pagination for larger or expensive datasets.

Do not add fake controls to tiny static tables or let table presentation own authorization or query policy.

Detailed reusable table APIs and visual rules remain with the applicable UI Contract and UI standards.

## 10. Testing And Verification

Every feature or capability change must have verification appropriate to its accepted behavior and risk.

Canonical verification policy belongs to the [Testing Standards Index](../testing/index.md). That suite owns acceptance-to-proof mapping, `AC-*` and `PF-*`, proof methods and levels, initial proof, result classification, protected baselines, environments, evidence, specialist testing, and testing gates.

This standard does not restate those semantics.

When required proof uses test source, use the [Test Implementation Standards Index](test-implementation/index.md).

Test source follows the smallest clear owner and configured deterministic discovery. Do not default owner-specific tests to root `tests/` merely because they are conventionally called unit or feature tests.

Design-sensitive UI retains required browser, accessibility, and manual visual review. Automated proof does not replace specialist or repository-owner acceptance when those are required.

## 11. Planning And Closeout

Before production implementation, confirm the bounded issue is ready under [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md).

Before closeout, confirm applicable:

- implementation is complete for the accepted slice;
- canonical documentation reflects current behavior;
- required verification has run and evidence is recorded;
- manual and specialist review remains visible until complete;
- compatibility changes are explicit;
- known gaps are reported;
- unrelated follow-up work was not silently implemented.

Do not mark an entire capability, Product, Module, milestone, or planning row complete merely because one bounded implementation slice succeeded.

## 12. Prohibited Patterns

Do not:

- implement without a clear owner or canonical behavior source;
- restore `Platform` or generic `Surface` as target ownership;
- let reusable UI own Product behavior;
- let Delivery Adapters own domain logic;
- let Modules redefine Core infrastructure;
- let UI visibility replace authorization;
- let planning replace canonical behavior;
- duplicate Testing Standards in this file;
- use root test type as application ownership;
- ship visible placeholder Setup or Settings entries;
- silently expand a bounded issue into adjacent work.

## 13. Related

- [Coding Standards Index](index.md)
- [Coding Standards](Coding%20Standards.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [Test Implementation Standards Index](test-implementation/index.md)
- [Testing Standards Index](../testing/index.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Workspace Navigation And Frame Composition](../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Feature Index](../../04-features/index.md)
- [Feature Spec Template](../../09-reference/templates/docs/_feature-spec.md)
