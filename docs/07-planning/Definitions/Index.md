<!--
DOC-META
title: Definitions Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Index.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes canonical reusable architecture, organization, extension, application-registration, technical-role, and delivery-adapter definitions for Login 2.0.
-->

# Definitions Index

Parent: [Planning Index](../index.md)

Use this index to locate canonical reusable architecture definitions.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
  - [3.1. Architecture Ownership And Presentation](#31-architecture-ownership-and-presentation)
  - [3.2. Organization, Extension, And Application Registration Concepts](#32-organization-extension-and-application-registration-concepts)
  - [3.3. Shared Technical Roles](#33-shared-technical-roles)
  - [3.4. Delivery Adapter Specializations](#34-delivery-adapter-specializations)
- [4. Subfolders](#4-subfolders)
- [5. Maintenance Notes](#5-maintenance-notes)
- [6. Related](#6-related)

## 1. Purpose

This folder owns canonical reusable architecture definitions for Login 2.0.

Each concept has one authoritative `Definition.md` that establishes:

- what the concept means;
- how responsibilities are classified;
- what the concept owns;
- what it must not own;
- permitted and prohibited dependencies;
- permanent, transitional, compatibility-only, deprecated, or proposed target status;
- accepted boundaries and deferred implementation details.

Definitions remain independent of current physical implementation placement unless the definition explicitly identifies a working Technical Role label.

## 2. Scope

### 2.1. Belongs Here

This folder contains definitions for concepts that:

- are used across multiple repository or documentation areas;
- require one stable meaning;
- establish an ownership, classification, responsibility, extension, technical-role, presentation, delivery, or dependency boundary;
- must be consumed by planning, architecture, standards, implementation, or agent guidance.

### 2.2. Does Not Belong Here

This folder does not contain:

- implementation plans;
- migration plans;
- file inventories;
- capability- or Module-specific required folder lists;
- feature behavior;
- execution flows;
- schema or database contracts;
- operational procedures;
- active issue or Project status;
- glossary entries that do not require a formal architecture boundary.

Capability- and Module-specific required files and folders belong in the applicable owner contract, such as a `Feature-Spec.md`, rather than in a shared definition.

## 3. Documents

### 3.1. Architecture Ownership And Presentation

| Document                                     | Purpose                                                                             | Status |
| -------------------------------------------- | ----------------------------------------------------------------------------------- | ------ |
| [Core Definition](Core/Definition.md)        | Defines required and authoritative base-application ownership.                      | active |
| [Module Definition](Modules/Definition.md)   | Defines optional Module ownership, lifecycle, packaging, and dependency boundaries. | active |
| [UI Definition](UI/Definition.md)            | Defines reusable presentation infrastructure and UI dependency boundaries.          | active |
| [Laravel Definition](Laravel/Definition.md)  | Defines Laravel as the application framework, runtime, and composition system.      | active |
| [Frame Surface Definition](Surfaces/Definition.md) | Defines a named persistent-Frame composition region; the existing folder path is retained for compatibility. | active |

### 3.2. Organization, Extension, And Application Registration Concepts

| Document                                                                             | Purpose                                                                                                                                | Status |
| ------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------- | ------ |
| [Technical Role Definition](Technical-Roles/Definition.md)                           | Defines the secondary responsibility classification used beneath an explicit owner and capability or Module.                           | active |
| [Delivery Adapter Definition](Delivery-Adapters/Definition.md)                       | Defines owner-local invocation-channel integration around owner-controlled behavior.                                                   | active |
| [Host Definition](Hosts/Definition.md)                                               | Defines a Core capability or Module that owns a bounded extensible feature.                                                            | active |
| [Registry Definition](Registries/Definition.md)                                      | Defines an owner-controlled mechanism for validating, collecting, resolving, and exposing registered entries.                          | active |
| [Extension Point Definition](Extension-Points/Definition.md)                         | Defines a named Host-owned contract for one bounded kind of Contribution.                                                              | active |
| [Contribution Definition](Contributions/Definition.md)                               | Defines Contributor-owned integration targeting one explicit Extension Point.                                                          | active |
| [Contributor Definition](Contributors/Definition.md)                                 | Defines the Core capability or Module that owns and supplies a Contribution.                                                           | active |
| [Application Registration System Definition](Application-Registration/Definition.md) | Defines deterministic descriptor validation, dependency ordering, compilation, manifest generation, and root application registration. | active |

### 3.3. Shared Technical Roles

| Document                                               | Purpose                                                                                         | Status |
| ------------------------------------------------------ | ----------------------------------------------------------------------------------------------- | ------ |
| [Action Definition](Actions/Definition.md)             | Defines an owner-controlled application operation or state-changing use case.                   | active |
| [Query Definition](Queries/Definition.md)              | Defines an owner-controlled read-oriented operation.                                            | active |
| [Contract Definition](Contracts/Definition.md)         | Defines a stable owner-controlled interface, protocol, or data agreement.                       | active |
| [Data Object Definition](Data-Objects/Definition.md)   | Defines an explicit structured value used to transfer command, Query, result, or boundary data. | active |
| [Model Definition](Models/Definition.md)               | Defines an owner-controlled representation of domain or persistent state.                       | active |
| [Policy Definition](Policies/Definition.md)            | Defines owner-controlled authorization logic.                                                   | active |
| [Event Definition](Events/Definition.md)               | Defines an owner-defined fact communicating that a meaningful occurrence happened.              | active |
| [Listener Definition](Listeners/Definition.md)         | Defines owner-controlled behavior that reacts to an accepted Event.                             | active |
| [Job Definition](Jobs/Definition.md)                   | Defines owner-controlled deferred or queueable work.                                            | active |
| [Notification Definition](Notifications/Definition.md) | Defines owner-specific communication content and channel intent.                                | active |
| [Provider Definition](Providers/Definition.md)         | Defines owner-local Laravel registration and composition code.                                  | active |

Registry and Contribution are also working Technical Roles where applicable. Frame Surface is a composition concept and does not authorize a generic owner-local `Surface/` Technical Role.

### 3.4. Delivery Adapter Specializations

| Document                                                                       | Purpose                                                                | Status |
| ------------------------------------------------------------------------------ | ---------------------------------------------------------------------- | ------ |
| [HTTP Delivery Adapter Definition](HTTP-Delivery-Adapters/Definition.md)       | Defines owner-local web and API transport integration.                 | active |
| [Console Delivery Adapter Definition](Console-Delivery-Adapters/Definition.md) | Defines owner-local command-line transport integration.                | active |
| [Webhook Delivery Adapter Definition](Webhook-Delivery-Adapters/Definition.md) | Defines owner-local inbound or outbound webhook transport integration. | active |

## 4. Subfolders

Each concept subfolder contains one canonical `Definition.md`.

| Folder                       | Purpose                                                                                   |
| ---------------------------- | ----------------------------------------------------------------------------------------- |
| `Actions/`                   | Action responsibility and working `Actions/` role.                                        |
| `Application-Registration/`  | Deterministic owner registration, compilation, manifest, and registrar concepts.          |
| `Console-Delivery-Adapters/` | Console delivery specialization and working `Console/` role.                              |
| `Contracts/`                 | Contract responsibility and working `Contracts/` role.                                    |
| `Contributions/`             | Contribution ownership and working `Contrib/` role.                                       |
| `Contributors/`              | Contributor relationship boundary.                                                        |
| `Core/`                      | Core ownership and classification.                                                        |
| `Data-Objects/`              | Data Object responsibility and working `Data/` role.                                      |
| `Delivery-Adapters/`         | General Delivery Adapter boundary.                                                        |
| `Events/`                    | Event responsibility and working `Events/` role.                                          |
| `Extension-Points/`          | Host-owned Extension Point boundary.                                                      |
| `Hosts/`                     | Host role and extensible-feature ownership.                                               |
| `HTTP-Delivery-Adapters/`    | HTTP and API delivery specialization and working `Http/` role.                            |
| `Jobs/`                      | Job responsibility and working `Jobs/` role.                                              |
| `Laravel/`                   | Laravel framework and integration boundary.                                               |
| `Listeners/`                 | Listener responsibility and working `Listeners/` role.                                    |
| `Models/`                    | Model responsibility and working `Models/` role.                                          |
| `Modules/`                   | Module ownership, lifecycle, and packaging boundary.                                      |
| `Notifications/`             | Owner-specific Notification responsibility and working `Notifications/` role.             |
| `Policies/`                  | Policy responsibility and working `Policies/` role.                                       |
| `Providers/`                 | Provider responsibility and working `Providers/` role.                                    |
| `Queries/`                   | Query responsibility and working `Queries/` role.                                         |
| `Registries/`                | Registry mechanism and working `Registry/` role.                                          |
| `Surfaces/`                  | Compatibility documentation path for the Frame Surface definition; it does not authorize a working `Surface/` production role. |
| `Technical-Roles/`           | Shared Technical Role classification model.                                               |
| `UI/`                        | Reusable UI ownership and presentation boundary.                                          |
| `Webhook-Delivery-Adapters/` | Webhook delivery specialization; final physical application folder name remains deferred. |

Concept subfolders do not require their own README, index, Standard, or AGENTS file unless later documentation growth establishes a stable package that requires additional routing or governance.

## 5. Maintenance Notes

- Keep this index current when definitions are added, moved, renamed, accepted, superseded, or removed.
- Every definition must use `docs/09-reference/templates/docs/_definition.md`.
- Every definition must identify this file as its metadata parent.
- Every definition must link visibly to this index using `../Index.md`.
- Do not duplicate definition content in this index.
- Do not create competing definitions for the same concept.
- Shared definitions establish meaning and boundaries; they do not require universal folder presence.
- The Application Registration System is composition infrastructure and is not automatically a Host Registry.
- Frame Surface is restricted to named persistent-Frame regions and is not a Product, Page, flow, owner, or generic folder.
- Capability- and Module-specific required structure belongs in the applicable owner contract.
- Update consuming planning packages when a definition path, meaning, or status changes.
- Accepted folder labels, casing, namespace mapping, and class-role naming follow Goal 3 Phase 5 and Repository Naming Standards; implementation placement and migration remain governed by their applicable owners.

## 6. Related

- [Planning Index](../index.md)
- [Goal 3 Target Repository Architecture](../Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 2 Repository Organization Index](../Milestones/milestone-0/goal-3/phase-2/index.md)
- [Phase 4 Placement And Dependency Rules Index](../Milestones/milestone-0/goal-3/phase-4/index.md)
- [Definition Document Type](../../02-standards/documentation/doc-types/definition/Definition.md)
- [Definition Template](../../09-reference/templates/docs/_definition.md)
