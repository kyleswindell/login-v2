<!--
DOC-META
title: Phase 4 Artifact Placement Matrix
doc_type: matrix
status: draft
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/artifact-placement-matrix.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Consolidates the accepted Phase 4 owner, target placement, registration, prohibited-destination, test, documentation, and Phase 5 naming handoff rules for repository artifacts.
-->

# Phase 4 Artifact Placement Matrix

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Matrix For](#3-use-this-matrix-for)
- [4. Do Not Use This Matrix For](#4-do-not-use-this-matrix-for)
- [5. Authoritative Source Inputs](#5-authoritative-source-inputs)
- [6. Controlled Values And Interpretation](#6-controlled-values-and-interpretation)
  - [6.1. Ownership Values](#61-ownership-values)
  - [6.2. Registration And Discovery Values](#62-registration-and-discovery-values)
  - [6.3. Prohibition Keys](#63-prohibition-keys)
  - [6.4. Path Interpretation](#64-path-interpretation)
- [7. Artifact Placement Matrix](#7-artifact-placement-matrix)
  - [7.1. Contracts And Owner Behavior](#71-contracts-and-owner-behavior)
  - [7.2. Delivery Adapters And Surfaces](#72-delivery-adapters-and-surfaces)
  - [7.3. Hosts, Contributions, Routes, And Application Registration](#73-hosts-contributions-routes-and-application-registration)
  - [7.4. Configuration And Database Lifecycle](#74-configuration-and-database-lifecycle)
  - [7.5. Presentation And Assets](#75-presentation-and-assets)
  - [7.6. Tests And Documentation](#76-tests-and-documentation)
- [8. Consolidation Review Result](#8-consolidation-review-result)
- [9. Phase 5 Handoffs](#9-phase-5-handoffs)
- [10. Update Triggers And Maintenance](#10-update-triggers-and-maintenance)
- [11. Related](#11-related)

## 1. Purpose

This matrix provides the Phase 4 lookup surface for deciding:

- who owns an artifact;
- its accepted default target placement;
- how it is registered or discovered;
- which alternate placement is permitted;
- which destinations or dependency shortcuts are prohibited;
- which naming details remain Phase 5 authority;
- which accepted decision and reusable definition govern the row.

The matrix is canonical for this structured placement relationship after repository-owner acceptance. It does not replace the source decisions, reusable Definitions, or later durable architecture and standards.

## 2. Status

- Document status: draft
- Review state: agent-proposed consolidation; repository-owner acceptance pending
- Source-decision state: Decisions 4.1 through 4.12 accepted
- Implementation state: target direction only
- Owning GitHub issue: #51
- Parent GitHub issue: #19
- Downstream naming issue: #52
- Consolidation blocker: none found
- Phase 6 correction: broad owner-specific Surface rows are superseded by ADR-0008 and the Phase 6 correction below

### Phase 6 correction

Where this matrix uses Surface for ordinary Product Pages, destinations, areas, flows, PageData, ViewModels, Presenters, Renderers, or a generic `Surface/` role, interpret the row as owner-specific Product presentation using the narrowest precise role. Frame Surface is reserved for named persistent-Frame regions. Core Navigation is the Host at `app/Core/Navigation/`, and Product owners contribute through owner-local `Contrib/Navigation/` paths. No other placement, registration, persistence, test, documentation, prohibition, or significant-folder rule in this matrix is changed.

## 3. Use This Matrix For

Use this matrix to:

- classify a proposed artifact before choosing a target path;
- confirm the owner-first and capability-first placement rule;
- distinguish owner-local, package-local, artifact-colocated, generated, restricted-root, and documentation placement;
- identify the required registration or discovery method;
- reject generic, transitional, concrete cross-owner, or filesystem-discovered placement;
- route unresolved naming details to Phase 5;
- seed later architecture tests, registration validation, code-generation templates, and migration mapping.

## 4. Do Not Use This Matrix For

Do not use this matrix to:

- infer current physical implementation state;
- authorize a file move;
- define final names, namespaces, aliases, route names, descriptor schemas, or manifest formats;
- replace the dependency-and-communication matrix;
- define detailed database schemas;
- define complete verification strategy;
- make an exception without the accepted Decision 4.12 exception record;
- treat an omitted artifact as permission to use a generic root.

When an artifact is not listed, classify its owner and narrowest Technical Role using the accepted Definitions and Decisions 4.1 through 4.12.

## 5. Authoritative Source Inputs

The rows below are normalized from these accepted sources.

| Key             | Source                                                                                                       |
| --------------- | ------------------------------------------------------------------------------------------------------------ |
| P3              | [Accepted Phase 3 target repository architecture](../target-repository-architecture.md)                      |
| P4.1            | [Decision 4.1 — Contract Placement](4-1-contract-placement.md)                                               |
| P4.2            | [Decision 4.2 — Implementation Placement](4-2-implementation-placement.md)                                   |
| P4.3            | [Decision 4.3 — Delivery Adapter Placement](4-3-delivery-adapter-placement.md)                               |
| P4.4            | [Decision 4.4 — Route Placement And Registration](4-4-route-placement-and-registration.md)                   |
| P4.5            | [Decision 4.5 — Configuration Placement](4-5-configuration-placement.md)                                     |
| P4.6            | [Decision 4.6 — Database And Migration Placement](4-6-database-and-migration-placement.md)                   |
| P4.7            | [Decision 4.7 — View And Asset Placement](4-7-view-and-asset-placement.md)                                   |
| P4.8            | [Decision 4.8 — Test Placement](4-8-test-placement.md)                                                       |
| P4.9            | [Decision 4.9 — Documentation Placement](4-9-documentation-placement.md)                                     |
| P4.10           | [Decision 4.10 — Dependency Direction](4-10-dependency-direction.md)                                         |
| P4.11           | [Decision 4.11 — Cross-Owner Communication](4-11-cross-owner-communication.md)                               |
| P4.12           | [Decision 4.12 — Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)               |
| DEF-ACT         | [Action Definition](../../../../Definitions/Actions/Definition.md)                                           |
| DEF-QUERY       | [Query Definition](../../../../Definitions/Queries/Definition.md)                                            |
| DEF-CONTRACT    | [Contract Definition](../../../../Definitions/Contracts/Definition.md)                                       |
| DEF-DATA        | [Data Object Definition](../../../../Definitions/Data-Objects/Definition.md)                                 |
| DEF-MODEL       | [Model Definition](../../../../Definitions/Models/Definition.md)                                             |
| DEF-POLICY      | [Policy Definition](../../../../Definitions/Policies/Definition.md)                                          |
| DEF-EVENT       | [Event Definition](../../../../Definitions/Events/Definition.md)                                             |
| DEF-LISTENER    | [Listener Definition](../../../../Definitions/Listeners/Definition.md)                                       |
| DEF-JOB         | [Job Definition](../../../../Definitions/Jobs/Definition.md)                                                 |
| DEF-NOTIFY      | [Notification Definition](../../../../Definitions/Notifications/Definition.md)                               |
| DEF-PROVIDER    | [Provider Definition](../../../../Definitions/Providers/Definition.md)                                       |
| DEF-DELIVERY    | [Delivery Adapter Definition](../../../../Definitions/Delivery-Adapters/Definition.md)                       |
| DEF-HTTP        | [HTTP Delivery Adapter Definition](../../../../Definitions/HTTP-Delivery-Adapters/Definition.md)             |
| DEF-CONSOLE     | [Console Delivery Adapter Definition](../../../../Definitions/Console-Delivery-Adapters/Definition.md)       |
| DEF-WEBHOOK     | [Webhook Delivery Adapter Definition](../../../../Definitions/Webhook-Delivery-Adapters/Definition.md)       |
| DEF-SURFACE     | [Surface Definition](../../../../Definitions/Surfaces/Definition.md)                                         |
| DEF-HOST        | [Host Definition](../../../../Definitions/Hosts/Definition.md)                                               |
| DEF-REGISTRY    | [Registry Definition](../../../../Definitions/Registries/Definition.md)                                      |
| DEF-EXT         | [Extension Point Definition](../../../../Definitions/Extension-Points/Definition.md)                         |
| DEF-CONTRIB     | [Contribution Definition](../../../../Definitions/Contributions/Definition.md)                               |
| DEF-CONTRIBUTOR | [Contributor Definition](../../../../Definitions/Contributors/Definition.md)                                 |
| DEF-REGISTER    | [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md) |

The matrix-document contract is governed by `docs/02-standards/documentation/Document Type Standards.md` and `docs/09-reference/templates/docs/_matrix.md`.

## 6. Controlled Values And Interpretation

### 6.1. Ownership Values

| Value                          | Meaning                                                                       |
| ------------------------------ | ----------------------------------------------------------------------------- |
| Core capability                | Required base-application behavior that must operate without optional Modules |
| Module                         | Optional package-owned feature behavior                                       |
| UI responsibility              | Reusable presentation infrastructure                                          |
| Surface owner                  | Core capability or Module whose behavior the interaction presents             |
| Host                           | Owner of an extensible feature, Registry, and Extension Point Contracts       |
| Contributor                    | Owner supplying a Contribution to a Host                                      |
| Restricted Laravel integration | Application-wide framework composition without feature ownership              |
| Repository verification owner  | Cross-owner or repository-wide tests and support                              |
| Documentation branch owner     | Canonical document-type owner                                                 |

### 6.2. Registration And Discovery Values

| Value                           | Meaning                                                                                                              |
| ------------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Normal autoloading              | The artifact is located through accepted PHP or package autoloading and needs no separate application registration   |
| Owner descriptor                | The owner explicitly declares the artifact and applicable metadata                                                   |
| Native plus descriptor          | Laravel, Blade, Livewire, Composer, Vite, or test tooling performs its native role from validated owner declarations |
| Host Registry                   | The Host validates and resolves a declared Contribution                                                              |
| Deterministic asset composition | Declared CSS and JavaScript are ordered and included exactly once                                                    |
| Deterministic test discovery    | Local and CI runners discover every accepted test location                                                           |
| Documentation routing           | Metadata, parent indexes, README routing, and scoped AGENTS inheritance make the artifact discoverable               |
| Generated output                | The artifact is derived from canonical declarations and must be reproducible and stale-checkable                     |

### 6.3. Prohibition Keys

| Key | Prohibited condition                                                                                                                                            |
| --- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| G   | Generic ownership or implementation roots such as `Shared`, `Common`, `Helpers`, `Utilities`, generic `Services`, generic `Support`, `Platform`, or `Surfaces`. |
| R   | Restricted root Laravel or repository branches used as feature-owner destinations.                                                                              |
| M   | Module PHP implementation placed directly beneath `Modules/<Module>/` instead of `src/`.                                                                        |
| C   | Cross-owner dependency on concrete or internal implementation.                                                                                                  |
| F   | Filesystem presence, uncontrolled globbing, or request-time scanning treated as registration.                                                                   |
| X   | `Contrib/<Host>/` used for ordinary routes, views, assets, commands, or framework registration.                                                                 |
| P   | `public/` used as the normal editable source owner for presentation assets.                                                                                     |
| S   | Cross-owner Model, repository, table, configuration-state, or other undocumented shared-state access.                                                           |
| T   | New canonical work placed in a path classified as transitional by the accepted architecture.                                                                    |

A prohibition key abbreviates an accepted rule; it does not replace the complete source decision.

### 6.4. Path Interpretation

- `<Capability>`, `<Module>`, `<Responsibility>`, `<Host>`, and similar tokens are conceptual target placeholders.
- Phase 5 owns final casing, singular or plural form, exact filenames, namespaces, aliases, and internal subdivisions.
- A listed root path is permitted only for the exact restricted responsibility stated in its row.
- Existing transitional files do not establish target placement precedent.
- “Owner-local” means beneath the owner and narrowest cohesive capability, Module, Surface, or UI responsibility.
- “Colocated” means inside the owner-visible artifact bundle rather than a parallel global technical tree.
- An accepted exception must satisfy Decision 4.12 and does not amend this matrix outside its exact recorded scope.

## 7. Artifact Placement Matrix

### 7.1. Contracts And Owner Behavior

| Artifact                              | Owner                                                            | Default target placement                                                                     | Registration or discovery                                                                                         | Placement constraints                                                                                            | Phase 5 naming handoff                                                  | Source                                     |
| ------------------------------------- | ---------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------- | ------------------------------------------ |
| Core public or cross-owner Contract   | Provider Core capability                                         | `app/Core/<Capability>/Contracts/`                                                           | Referenced directly through the public type; implementation binding through accepted owner or Laravel composition | No consumer-owned copy; no concrete cross-owner import; prohibit G, C, T                                         | Contract-family, public/internal subdivision, class and interface names | P4.1; P4.10; P4.11; DEF-CONTRACT           |
| Module public Contract                | Provider Module                                                  | `Modules/<Module>/src/Contracts/`                                                            | Package autoloading; implementation binding through accepted Module or Laravel composition                        | Module dependency must be declared; prohibit M, C, T                                                             | Contract-family, namespace, versioning and compatibility names          | P4.1; P4.10; P4.11; DEF-CONTRACT           |
| Reusable UI runtime Contract          | UI responsibility                                                | `app/UI/<Responsibility>/Contracts/`                                                         | Application autoloading; explicit binding only when required                                                      | Must not expose Core or Module domain implementation; prohibit G, C, T                                           | Responsibility and Contract-family names                                | P4.1; P4.10; DEF-CONTRACT                  |
| Machine-readable UI artifact Contract | Owning UI Element, Component, Pattern, or Layout                 | Colocated `contract.php` in the owner-visible artifact bundle                                | Artifact-local loading or validated UI tooling; not a global Contract root                                        | Must not replace application-service Contracts; prohibit G, R, T                                                 | Artifact bundle and contract-schema naming                              | P4.1; P4.7                                 |
| Internal implementation abstraction   | Owner of the implementation role                                 | Adjacent to the implementation role it supports                                              | Normal autoloading; no public registration solely because it is an interface                                      | Promote to `Contracts/` only through a deliberate public-boundary decision; prohibit G, C                        | Final local interface naming                                            | P4.1; DEF-CONTRACT                         |
| Action                                | Core capability or Module performing the state-changing behavior | `app/Core/<Capability>/Actions/` or `Modules/<Module>/src/Actions/`                          | Normal autoloading; cross-owner use only behind a provider-owned public Contract                                  | Delivery and Surface code may invoke it; another owner may not import it concretely; prohibit G, M, C, T         | Action class, verb, input and result naming                             | P4.2; P4.10; P4.11; DEF-ACT                |
| Query                                 | Core capability or Module owning the read meaning and policy     | `app/Core/<Capability>/Queries/` or `Modules/<Module>/src/Queries/`                          | Normal autoloading; cross-owner reads through a provider-owned public Query Contract                              | Must not expose Models, repositories, tables, or internal query implementation; prohibit G, M, C, S, T           | Query, criteria, result, pagination and filtering names                 | P4.2; P4.10; P4.11; DEF-QUERY              |
| Data Object                           | Owner of the data meaning; provider when crossing owners         | `app/Core/<Capability>/Data/`, `Modules/<Module>/src/Data/`, or applicable UI responsibility | Normal autoloading; boundary use only as part of an accepted public Contract                                      | Not a neutral shared object; must not expose persistence internals; prohibit G, M, C, S, T                       | DTO/Data naming, immutability, serialization and validation conventions | P4.2; P4.10; P4.11; DEF-DATA               |
| Model                                 | Owner of the persisted state and invariants                      | `app/Core/<Capability>/Models/` or `Modules/<Module>/src/Models/`                            | Normal autoloading; framework model discovery only where explicitly required                                      | Consumers use public Queries or Contracts; prohibit root `app/Models/`, G, M, C, S, T                            | Model, aggregate and persistence namespace names                        | P4.2; P4.6; P4.10; DEF-MODEL               |
| Policy                                | Owner of the protected behavior or resource                      | `app/Core/<Capability>/Policies/` or `Modules/<Module>/src/Policies/`                        | Owner descriptor or owner-local Provider where Laravel policy mapping is required                                 | Delivery invokes authorization but does not own policy; prohibit G, M, C, T                                      | Policy and ability names; registration convention                       | P4.2; P4.4; P4.10; DEF-POLICY              |
| Event                                 | Owner of the completed occurrence and its meaning                | `app/Core/<Capability>/Events/` or `Modules/<Module>/src/Events/`                            | Declared Event/Listener registration through the owner descriptor when explicit mapping is required               | Completed fact only; not a substitute for a required synchronous result; prohibit G, M, C, T                     | Event tense, payload, version and dispatch names                        | P4.2; P4.4; P4.11; DEF-EVENT               |
| Listener                              | Owner of the reaction behavior                                   | `app/Core/<Capability>/Listeners/` or `Modules/<Module>/src/Listeners/`                      | Owner descriptor or accepted framework discovery                                                                  | Depends only on the public Event Contract; must not become a hidden required publisher step; prohibit G, M, C, T | Listener, queueing, ordering and retry names                            | P4.2; P4.4; P4.11; DEF-LISTENER            |
| Job                                   | Owner of the deliberately deferred work                          | `app/Core/<Capability>/Jobs/` or `Modules/<Module>/src/Jobs/`                                | Owner descriptor for queue, uniqueness, schedule, or middleware metadata where required                           | Not a substitute for a required immediate result; prohibit G, M, C, T                                            | Job, queue, retry, timeout, uniqueness and batching names               | P4.2; P4.3; P4.11; DEF-JOB                 |
| Notification                          | Owner of notification policy and meaning                         | `app/Core/<Capability>/Notifications/` or `Modules/<Module>/src/Notifications/`              | Owner descriptor or owner-local Provider for channel registration when required                                   | Delivery channel infrastructure does not become notification-policy owner; prohibit G, M, C, T                   | Notification type, channel and template names                           | P4.2; P4.4; DEF-NOTIFY                     |
| Owner-local Provider                  | Core capability or Module whose artifacts it registers           | `app/Core/<Capability>/Providers/` or `Modules/<Module>/src/Providers/`                      | Declared by the owner descriptor and invoked through application composition                                      | Registers and composes; does not own behavior or bypass descriptor validation; prohibit G, M, F, T               | Provider class and registration-family names                            | P4.2; P4.4; DEF-PROVIDER; DEF-REGISTER     |
| Root application Provider             | Restricted Laravel integration                                   | `app/Providers/`                                                                             | Laravel bootstrap; may host or invoke the bounded Root Application Registrar                                      | Application-wide composition, base integration, or compatibility only; prohibit feature ownership, R, F          | Root Provider and registrar boundary names                              | P3; P4.2; P4.4; DEF-PROVIDER; DEF-REGISTER |

### 7.2. Delivery Adapters And Surfaces

| Artifact                                       | Owner                                                                                                                        | Default target placement                                                  | Registration or discovery                                                                    | Placement constraints                                                                                                                              | Phase 5 naming handoff                                 | Source                                      |
| ---------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------ | ------------------------------------------- |
| Core HTTP controller or handler                | Owning Core capability                                                                                                       | `app/Core/<Capability>/Http/`                                             | Owner-local route declaration through the owner descriptor                                   | Transport concerns only; delegate behavior inward; prohibit R, C, T                                                                                | Controller/handler and internal HTTP subdivision names | P4.3; P4.4; DEF-DELIVERY; DEF-HTTP          |
| Module HTTP controller or handler              | Owning Module                                                                                                                | `Modules/<Module>/src/Http/`                                              | Module route declaration through the Module descriptor                                       | Transport concerns only; prohibit M, C, T                                                                                                          | Controller/handler and internal HTTP subdivision names | P4.3; P4.4; DEF-DELIVERY; DEF-HTTP          |
| Transport request validator                    | Owner of the HTTP behavior being exposed                                                                                     | Within the owner’s `Http/` role                                           | Loaded with the owning adapter; no separate global discovery                                 | Transport validation only; channel-independent rules remain owner behavior; prohibit R, C, T                                                       | Request/FormRequest naming and subdivision             | P4.3; DEF-HTTP                              |
| Owner-specific middleware                      | Owner of the behavior or channel policy                                                                                      | Within the owner’s `Http/` role                                           | Explicit route or middleware registration through the owner descriptor when required         | Global middleware belongs at the restricted root only when genuinely application-wide; prohibit R, C, T                                            | Middleware alias and grouping names                    | P4.3; P4.4; DEF-HTTP                        |
| API transformer or protocol resource           | Owner of the exposed behavior                                                                                                | Within the owner’s `Http/` role                                           | Invoked by the owning HTTP adapter                                                           | Protocol-specific representation only; channel-independent data belongs in Data or Contracts; prohibit R, C, T                                     | Resource/transformer naming                            | P4.3; DEF-HTTP                              |
| Webhook Delivery Adapter                       | Core capability or Module owning the invoked behavior                                                                        | Owner-local delivery role; exact target subfolder deferred                | Owner route and handler declaration through the owner descriptor                             | External protocol translation only; prohibit root feature ownership, C, T                                                                          | Final `Webhooks/` versus HTTP-subrole naming           | P4.3; P4.4; DEF-DELIVERY; DEF-WEBHOOK       |
| Core Console command                           | Owning Core capability                                                                                                       | `app/Core/<Capability>/Console/`                                          | Command declaration through the owner descriptor                                             | Input, output, acknowledgement and invocation only; prohibit R, C, T                                                                               | Command class, signature and subfolder names           | P4.3; P4.4; DEF-CONSOLE                     |
| Module Console command                         | Owning Module                                                                                                                | `Modules/<Module>/src/Console/`                                           | Command declaration through the Module descriptor                                            | Input, output, acknowledgement and invocation only; prohibit M, C, T                                                                               | Command class, signature and subfolder names           | P4.3; P4.4; DEF-CONSOLE                     |
| Schedule entry or scheduled invocation adapter | Owner of the scheduled behavior                                                                                              | Owner-local `Console/`, `Jobs/`, or accepted schedule-registration role   | Schedule declaration through the owner descriptor; root composition consumes compiled output | Root scheduler composes only; scheduled behavior remains owner-local; prohibit R, C, F, T                                                          | Schedule declaration and role naming                   | P4.3; P4.4; DEF-CONSOLE; DEF-REGISTER       |
| Presenter, Renderer, ViewModel, or PageData    | Owner-specific Surface when presentation-specific; `Http/` when protocol-specific; `Data/Contracts` when channel-independent | Applicable owner-local `Surface/`, `Http/`, `Data/`, or `Contracts/` role | Normal autoloading; invoked through the owning Surface or adapter                            | Classification follows responsibility, not class suffix; prohibit G, R, C, T                                                                       | Exact role and class naming                            | P4.3; P4.7; DEF-SURFACE                     |
| Core Livewire class                            | Owning Core capability Surface                                                                                               | `app/Core/<Capability>/Surface/`                                          | Explicit Livewire alias-to-class registration through the owner descriptor                   | Not root `app/Livewire/`; not automatically an HTTP owner; prohibit R, F, T                                                                        | Surface subdivision and alias naming                   | P4.3; P4.4; P4.7; DEF-SURFACE; DEF-REGISTER |
| Module Livewire class                          | Owning Module Surface                                                                                                        | `Modules/<Module>/src/Surface/`                                           | Explicit Livewire alias-to-class registration through the Module descriptor                  | Not direct Module-root PHP; prohibit M, F, T                                                                                                       | Surface subdivision and alias naming                   | P4.3; P4.4; P4.7; DEF-SURFACE; DEF-REGISTER |
| Root HTTP or Console integration artifact      | Restricted Laravel integration                                                                                               | `app/Http/` or `app/Console/`                                             | Laravel bootstrap or compiled application registration                                       | Base classes, global middleware, global registration, compatibility, or genuinely application-wide integration only; prohibit feature ownership, R | Final root integration subdivisions                    | P3; P4.3; P4.4                              |

### 7.3. Hosts, Contributions, Routes, And Application Registration

| Artifact                          | Owner                                                               | Default target placement                                                                                  | Registration or discovery                                                                                                                  | Placement constraints                                                                                                               | Phase 5 naming handoff                                     | Source                                           |
| --------------------------------- | ------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------- | ------------------------------------------------ |
| Host behavior                     | Host Core capability, Module, or UI responsibility                  | Normal owner-local roles beneath the Host owner                                                           | Normal owner registration plus Host-owned Registry where extensible                                                                        | Host owns feature policy and Extension Point Contracts; prohibit absorption of Contributor behavior, C                              | Host-specific role and API names                           | P4.1; P4.2; P4.10; P4.11; DEF-HOST               |
| Registry Contract                 | Host                                                                | Host owner’s `Contracts/` role                                                                            | Public Contract consumed by Contributors and application composition                                                                       | Application Registration System and service container are not the Registry; prohibit G, C                                           | Registry Contract and key names                            | P4.1; P4.11; DEF-REGISTRY; DEF-CONTRACT          |
| Registry implementation           | Host                                                                | Host owner’s `Registry/` role                                                                             | Bound through owner registration; may receive validated Contribution declarations                                                          | Must not depend on Contributor implementations; prohibit G, C, F                                                                    | Registry class, cache and resolution names                 | P4.2; P4.4; P4.11; DEF-REGISTRY; DEF-REGISTER    |
| Extension Point Contract          | Host                                                                | Host owner’s `Contracts/` role                                                                            | Referenced by declared Contributors and validated during registration                                                                      | Must not expose Host internals; prohibit consumer-owned copies and C                                                                | Extension Point and version names                          | P4.1; P4.11; DEF-EXT; DEF-CONTRACT               |
| Contribution declaration or value | Contributor                                                         | `app/Core/<Contributor>/Contrib/<Host>/` or `Modules/<Contributor>/src/Contrib/<Host>/`                   | Declared through the Contributor descriptor and routed to the Host Registry                                                                | Only for an explicit Host Extension Point; prohibit X, M, C, F                                                                      | Contribution type, key and declaration naming              | P4.2; P4.4; P4.11; DEF-CONTRIB; DEF-REGISTER     |
| Contributor implementation        | Contributor Core capability or Module                               | Contributor’s normal owner-local roles; Contribution-specific bridge may remain beneath `Contrib/<Host>/` | Registered through the accepted Contribution Contract                                                                                      | Host must not absorb it; Contributor must not access Host internals; prohibit C, X, M                                               | Bridge and implementation naming                           | P4.2; P4.10; P4.11; DEF-CONTRIBUTOR; DEF-CONTRIB |
| Owner Registration Descriptor     | Registrable Core capability, Module, or UI responsibility           | Owner root at a Phase 5-defined path                                                                      | Canonical declarative input to the Registration Compiler                                                                                   | Must not execute behavior; filesystem presence alone is insufficient; prohibit F, G                                                 | Descriptor filename, schema and physical placement         | P4.4; DEF-REGISTER                               |
| Registration Compiler             | Application-wide composition infrastructure                         | Phase 5-defined restricted tooling or application-integration location                                    | Consumes all accepted owner descriptors and generates deterministic output                                                                 | Must not replace Laravel or Vite caches/build responsibilities; prohibit feature ownership, F, G                                    | Compiler class, command, package and path names            | P4.4; P4.12; DEF-REGISTER                        |
| Compiled Registration Manifest    | Generated application composition output                            | Phase 5-defined generated or cache location                                                               | Generated by the Registration Compiler; consumed by the Root Application Registrar                                                         | Derived output, not canonical owner input; must be stale-checkable; prohibit manual feature ownership                               | Manifest format, filename, source-control and cache policy | P4.4; P4.12; DEF-REGISTER                        |
| Root Application Registrar        | Restricted Laravel integration                                      | `app/Providers/` or another Phase 5-defined restricted integration path                                   | Consumes the compiled manifest and delegates to Typed Registrars or owner-local Providers                                                  | Composition only; must not own registered behavior; prohibit R, F, G                                                                | Registrar class and bootstrap name                         | P4.4; DEF-REGISTER; DEF-PROVIDER                 |
| Typed Registrar                   | Application registration infrastructure for one registration family | Phase 5-defined restricted integration path                                                               | Consumes validated manifest instructions for routes, views, commands, config, migrations, assets, Contributions, or another bounded family | Must not become a generic service locator or behavior owner; prohibit G, F                                                          | Registrar family and class names                           | P4.4; DEF-REGISTER                               |
| Core route file                   | Owning Core capability                                              | `app/Core/<Capability>/routes/`                                                                           | Declared by the Core owner descriptor; loaded through application registration                                                             | Route and adapter ownership must agree; prohibit root feature routes, R, F, T                                                       | Channel filenames, grouping and prefix naming              | P4.4; DEF-REGISTER                               |
| Module route file                 | Owning Module                                                       | `Modules/<Module>/routes/`                                                                                | Declared by the Module descriptor; loaded through application registration                                                                 | Must not be moved into root routes for convenience; prohibit F, T                                                                   | Channel filenames, grouping and prefix naming              | P4.4; DEF-REGISTER                               |
| Root route file                   | Restricted Laravel integration                                      | `routes/`                                                                                                 | Laravel bootstrap and application registration composition                                                                                 | Only application-wide entrypoints, global infrastructure, compatibility, or owner-route registration; prohibit feature ownership, R | Root route filename and bootstrap naming                   | P3; P4.4                                         |

### 7.4. Configuration And Database Lifecycle

| Artifact                                       | Owner                                                                  | Default target placement                                                                      | Registration or discovery                                                                    | Placement constraints                                                                                                                      | Phase 5 naming handoff                            | Source             |
| ---------------------------------------------- | ---------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------- | ------------------ |
| Core capability configuration                  | Owning Core capability                                                 | Owner-local configuration branch beneath `app/Core/<Capability>/`                             | Declared with namespace, defaults, environment inputs and validation in the owner descriptor | Deployment defaults only; not Tenant/User runtime state; prohibit root feature config, R, F, T                                             | Exact folder, file, key and namespace names       | P4.5; DEF-REGISTER |
| Module configuration                           | Owning Module                                                          | `Modules/<Module>/config/`                                                                    | Declared by the Module descriptor and merged through typed registration                      | Package-local; not runtime Tenant state; prohibit F, T                                                                                     | File, key, publication and namespace names        | P4.5; DEF-REGISTER |
| Reusable UI runtime configuration              | Owning UI responsibility                                               | Owner-local configuration branch beneath `app/UI/<Responsibility>/`                           | Declared by the UI owner descriptor when runtime registration is required                    | Sparse; must not become domain configuration; prohibit G, R, F, T                                                                          | Exact folder, file and key names                  | P4.5; DEF-REGISTER |
| Root Laravel or application-wide configuration | Restricted Laravel or shared application infrastructure                | `config/`                                                                                     | Laravel configuration loading and `config:cache`                                             | Framework, application-wide composition, shared infrastructure, bootstrap, or compatibility only; prohibit feature-owner dumping ground, R | Root config filenames and namespaces              | P3; P4.5           |
| Environment input declaration                  | Owner of the consuming configuration                                   | Declared in the owning configuration and registration metadata; secret value remains external | Validated through configuration registration and deployment/runtime environment              | Application code uses `config()` rather than direct `env()`; secrets are not committed                                                     | Environment variable and configuration-key names  | P4.5; P4.12        |
| Core migration                                 | Core capability owning the schema change                               | `database/core/<Capability>/migrations/`                                                      | Declared by the owner descriptor with ordering dependencies; executed by Laravel             | Generic root migrations only for exact app-wide cases; prohibit T, F                                                                       | Migration filename, identifier and ordering names | P4.6; DEF-REGISTER |
| Core factory or seeder                         | Core capability owning the data lifecycle                              | `database/core/<Capability>/factories/` or `database/core/<Capability>/seeders/`              | Declared by owner descriptor; root seeder may compose                                        | Must not hide owner-specific fixtures in generic roots; prohibit T, F                                                                      | Factory, seeder and composition names             | P4.6; DEF-REGISTER |
| Module migration                               | Owning Module                                                          | `Modules/<Module>/database/migrations/`                                                       | Declared by the Module descriptor; executed by Laravel                                       | Package-local; prohibit root migration relocation and F                                                                                    | Migration filename, identifier and ordering names | P4.6; DEF-REGISTER |
| Module factory or seeder                       | Owning Module                                                          | `Modules/<Module>/database/factories/` or `Modules/<Module>/database/seeders/`                | Declared by the Module descriptor; executed by Laravel                                       | Package-local; prohibit F                                                                                                                  | Factory, seeder and package composition names     | P4.6; DEF-REGISTER |
| Application-wide database lifecycle artifact   | Application bootstrap or genuinely cross-owner database infrastructure | Generic `database/migrations/`, `database/factories/`, or `database/seeders/`                 | Laravel-native execution; root composition where required                                    | Exact exception only; not the default for owner-specific work; prohibit R                                                                  | Application-wide artifact naming                  | P4.6; P4.12        |
| Human-readable schema or table Contract        | Database documentation owner for the applicable state owner            | `docs/06-database/`                                                                           | Explicit documentation metadata and indexes                                                  | Does not replace migrations; Phase 4 does not define detailed schema                                                                       | Goal 6 document and section names                 | P4.6; P4.9         |

### 7.5. Presentation And Assets

| Artifact                                              | Owner                                                              | Default target placement                                                      | Registration or discovery                                                                        | Placement constraints                                                                              | Phase 5 naming handoff                                  | Source                          |
| ----------------------------------------------------- | ------------------------------------------------------------------ | ----------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------- | ------------------------------------------------------- | ------------------------------- |
| Reusable Foundation Element                           | UI                                                                 | `resources/views/elements/<Element>/`                                         | Artifact contract plus deterministic asset composition where applicable                          | Reusable presentation only; prohibit domain behavior, G, T                                         | Element and bundle names                                | P4.7                            |
| Reusable UI Component                                 | UI                                                                 | `resources/views/components/ui/<Component>/`                                  | Blade convention or explicit namespace plus deterministic asset composition                      | Reusable presentation only; prohibit domain behavior, G, T                                         | Component and bundle names                              | P4.7                            |
| Reusable UI Pattern                                   | UI                                                                 | `resources/views/components/patterns/<Pattern>/`                              | Blade convention or explicit namespace plus deterministic asset composition                      | Composes accepted UI artifacts; does not own capability behavior; prohibit G, T                    | Pattern and bundle names                                | P4.7                            |
| Reusable UI Layout primitive                          | UI                                                                 | `resources/views/components/layouts/<Layout>/`                                | Blade convention or explicit namespace plus deterministic asset composition                      | Reusable layout primitive only; prohibit owner-specific application behavior, G, T                 | Layout and bundle names                                 | P4.7                            |
| Owner-specific application shell or capability layout | Owning Core capability or Module Surface                           | Owning `Surface/` role plus owner-specific presentation resources             | Registered with the owning Surface and accepted view namespace                                   | Does not become reusable UI merely because it composes UI primitives; prohibit G, R, T             | Shell, layout, namespace and alias names                | P4.2; P4.7; DEF-SURFACE         |
| Core Surface view                                     | Owning Core capability                                             | `resources/views/core/<Capability>/`                                          | Explicit owner view registration when required; Blade convention only where path is conventional | Presentation of Core behavior; prohibit generic platform views and T                               | Capability view namespace, folder and view names        | P4.7; DEF-SURFACE; DEF-REGISTER |
| Module Surface view                                   | Owning Module                                                      | `Modules/<Module>/resources/views/`                                           | Module view namespace declared through the Module descriptor                                     | Package-local; prohibit root relocation for convenience and F                                      | Module view namespace, folder and view names            | P4.7; DEF-SURFACE; DEF-REGISTER |
| Artifact partial or internal presentation support     | Owning presentation artifact or Surface                            | Colocated within the owning bundle or owner presentation branch               | Loaded only through the owning artifact or view namespace                                        | Must not become an unowned global partial collection; prohibit G, T                                | Partial and internal-folder names                       | P4.7                            |
| Reusable UI CSS or JavaScript source                  | Owning UI artifact or UI runtime responsibility                    | Colocated artifact bundle or accepted UI runtime source                       | Declared in deterministic ordered asset composition                                              | No uncontrolled globs; no parallel unowned CSS/JS tree; prohibit G, F, T                           | Bundle, aggregator and import names                     | P4.7; DEF-REGISTER              |
| Core Surface CSS or JavaScript source                 | Owning Core capability Surface                                     | Colocated with the Core presentation bundle or accepted owner asset branch    | Declared by the owner descriptor and included through deterministic composition                  | Owner-specific; must not be moved into reusable UI without deliberate promotion; prohibit F, T     | Owner asset bundle and import names                     | P4.7; DEF-REGISTER              |
| Module CSS or JavaScript source                       | Owning Module                                                      | `Modules/<Module>/resources/` in package-local presentation or asset branches | Declared by the Module descriptor and included through deterministic composition                 | Package-local; Tenant enablement must not require a separate build; prohibit F                     | Package asset folder, bundle and import names           | P4.7; DEF-REGISTER              |
| Primary Vite entrypoint                               | Application-wide build composition                                 | `resources/css/app.css` or `resources/js/app.js`                              | Vite input; consumes deterministic ordered owner/category composition                            | Composition only; not feature ownership; prohibit duplicate or uncontrolled imports                | Generated import strategy and category aggregator names | P3; P4.7; DEF-REGISTER          |
| Reusable icon and icon-resolution infrastructure      | UI                                                                 | Accepted UI icon artifact and runtime locations                               | Unified icon component and deterministic asset registration                                      | Owner-specific use does not transfer icon ownership; prohibit legacy direct icon duplication, G, T | Icon key, artifact and resolver names                   | P4.7                            |
| Feature-specific image or media source                | Owning Core capability or Module                                   | Owning presentation resources                                                 | Declared in owner asset composition or referenced by owner views                                 | `public/` only when direct access is required; prohibit P, G, T                                    | Asset folder and key names                              | P4.7                            |
| Directly public asset                                 | Owner of the public resource; served by application infrastructure | `public/`                                                                     | Direct web serving or build output                                                               | Only when direct public access is required; not the normal editable source owner; prohibit P       | Published path and build-output names                   | P4.7                            |

### 7.6. Tests And Documentation

| Artifact                                                                                            | Owner                                                   | Default target placement                                                                        | Registration or discovery                                                              | Placement constraints                                                                                                        | Phase 5 naming handoff                               | Source           |
| --------------------------------------------------------------------------------------------------- | ------------------------------------------------------- | ----------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------- | ---------------- |
| Core capability test                                                                                | Owning Core capability                                  | `app/Core/<Capability>/__tests__/`                                                              | Deterministic local and CI test discovery                                              | Smallest cohesive owner; must not silently disappear or load in production; prohibit T                                       | Suite and subdivision names                          | P4.8             |
| Reusable UI runtime test                                                                            | Owning UI responsibility                                | `app/UI/<Responsibility>/__tests__/`                                                            | Deterministic local and CI test discovery                                              | Tests UI runtime responsibility, not owner-specific feature behavior; prohibit T                                             | Suite and subdivision names                          | P4.8             |
| UI artifact test                                                                                    | Owning Element, Component, Pattern, or Layout           | Artifact-local `__tests__/`                                                                     | Artifact test discovery configured for local and CI execution                          | Colocated with smallest presentation artifact; prohibit silent omission                                                      | Test, fixture and evidence names                     | P4.8             |
| Module test                                                                                         | Owning Module                                           | `Modules/<Module>/tests/`                                                                       | Package-aware deterministic local and CI discovery                                     | Package-local; must not be moved without unchanged proof; prohibit T                                                         | Suite and subdivision names                          | P4.8             |
| Application-wide Laravel integration test                                                           | Restricted HTTP, Console, or Provider integration owner | `app/Http/__tests__/`, `app/Console/__tests__/`, or `app/Providers/__tests__/`                  | Deterministic local and CI discovery                                                   | Only tests genuinely application-wide integration; prohibit feature ownership                                                | Suite and subdivision names                          | P4.8             |
| Cross-owner, system, browser, or architecture test                                                  | Repository verification owner                           | `tests/`                                                                                        | Root test-runner and CI configuration                                                  | No single owner or intentionally cross-owner; root is not the default for owner-local tests                                  | Suite, browser, architecture and support names       | P4.8; P4.12      |
| Test fixture or support artifact                                                                    | Smallest test owner; root only when genuinely shared    | Owner-local `Fixtures/` or `Support/`, Module `tests/`, artifact `__tests__/`, or root `tests/` | Discovered only through the applicable test suite                                      | Must not become production dependency or generic application support; prohibit G                                             | Fixture, factory and support naming                  | P4.8             |
| Canonical architecture, standard, feature, flow, database, planning, reference, or runbook document | Applicable documentation branch owner                   | Applicable canonical branch beneath `docs/`                                                     | DOC-META, explicit index routing and controlled links                                  | Document type and authority determine placement; source-code adjacency does not replace canonical docs                       | Document and section names under governing standards | P4.9             |
| Module package documentation                                                                        | Owning Module                                           | `Modules/<Module>/README.md` and `Modules/<Module>/docs/`                                       | Package README and explicit package documentation index                                | Package-local understanding; must not compete with canonical repository architecture or standards                            | Package docs organization and filenames              | P4.9             |
| Folder `README.md`                                                                                  | Meaningful folder owner                                 | Folder root                                                                                     | Direct human and agent retrieval; linked from parent or sibling index where applicable | Default, not mandatory in standardized, generated, redundant, or deeply obvious folders                                      | README heading and local section names               | P4.9             |
| Folder `index.md`                                                                                   | Meaningful folder or documentation-package owner        | Folder root                                                                                     | Canonical navigation and child inventory                                               | May be omitted when navigation is intentionally unnecessary or redundant                                                     | Index title and routing names                        | P4.9             |
| Folder `AGENTS.md`                                                                                  | Scoped repository execution-guidance owner              | Folder root                                                                                     | Inherited by repository agents according to nearest applicable scope                   | May be omitted when no scoped rule adds value or agent guidance is deliberately excluded; must not duplicate canonical truth | Scoped guidance headings and routing links           | P4.9; P4.12      |
| Owner-local machine-readable reference or contract file                                             | Owning source artifact                                  | Colocated with the artifact it describes                                                        | Loaded by explicit owner tooling or implementation                                     | Does not replace canonical Markdown architecture, standards, behavior, schema, or runbooks                                   | File and schema names                                | P4.1; P4.7; P4.9 |

## 8. Consolidation Review Result

The first-draft consolidation found no new architecture decision or unresolved ownership conflict that prevents use of this matrix.

The following are intentional distinctions rather than conflicts:

- the Application Registration System composes owner declarations but is not a Host Registry;
- a Provider executes framework registration but is not the canonical owner descriptor or Registration Compiler;
- a Livewire class is normally Surface implementation rather than an HTTP owner;
- reusable UI presentation and owner-specific Surface presentation use different owners even when they share Blade, CSS, or JavaScript technologies;
- root Laravel, route, configuration, database, test, and public branches remain valid only for their restricted responsibilities;
- the default folder documentation package may be omitted at deep, standardized, generated, redundant, or deliberately unguided levels.

Repository-owner review should therefore confirm traceability and row completeness rather than repeat Decisions 4.1 through 4.12.

## 9. Phase 5 Handoffs

Phase 5 must finalize naming without reopening the accepted placement model.

Required naming handoffs include:

- Technical Role casing and singular or plural conventions;
- final Contract families and public/internal subdivisions;
- final route filenames and channel group names;
- final configuration folder and key naming;
- final migration, factory, and seeder naming;
- final Surface and Livewire subdivisions and aliases;
- final webhook and schedule-role names;
- final owner descriptor, compiler, manifest, registrar, and generated-output names;
- final asset bundle, category aggregator, and import names;
- final test-suite, fixture, and support names;
- final folder documentation titles and routing conventions where not already standardized.

No Phase 5 naming choice may create a new generic owner, move owner-specific work into a restricted root, permit concrete cross-owner dependencies, or replace explicit registration with filesystem discovery.

## 10. Update Triggers And Maintenance

Update this matrix when:

- a Phase 4 decision is amended or superseded;
- a reusable Definition changes artifact ownership or classification;
- Phase 5 accepts final names that should replace placeholders;
- an accepted exception creates a bounded alternate placement;
- durable architecture or standards promotion changes the governing source link;
- a representative Phase 6 validation discovers a missing artifact family or contradiction.

Maintenance rules:

- keep rows concise and traceable;
- add a row only when ownership, placement, registration, or prohibition differs materially;
- do not copy full source-decision explanations into cells;
- do not convert a current-state migration exception into a target default;
- keep dependency legality in the dependency-and-communication matrix;
- preserve owner acceptance authority when changing accepted-source classifications.

## 11. Related

- [Phase 4 Index](index.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Definitions Index](../../../../Definitions/Index.md)
- [Dependency And Communication Matrix](dependency-and-communication-matrix.md)
- [Durable Promotion Register](durable-promotion-register.md)
- Related GitHub issue: #51
