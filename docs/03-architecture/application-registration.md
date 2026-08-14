<!--
DOC-META
title: Application Registration
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/application-registration.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines the accepted target architecture for owner registration descriptors, deterministic registration compilation, generated manifests, root application composition, typed registrars, and native Laravel and Vite integration boundaries.
-->

# Application Registration

Parent: [Architecture Index](index.md)

## 1. Purpose

This document is the canonical architecture owner for the Login 2.0 Application Registration System.

It defines how Core capabilities, Modules, and UI responsibilities declare registrable artifacts and how those declarations are validated, dependency-ordered, compiled, and connected to Laravel, Livewire, Blade, Vite, and other approved runtime or build integrations.

It defines accepted terminology and conditional custom-artifact names. Descriptor schema, serialization, generated paths, cache policy, bootstrap integration, performance, and implementation sequence remain deferred.

## 2. Status And Scope

- Target architecture: accepted through Goal 3 Phase 5
- Current implementation: transitional and not yet proven to implement this architecture
- Terminology and conditional artifact naming: accepted through Goal 3 Phase 5
- Representative validation: accepted through Goal 3 Phase 6; implementation remains unproven
- Migration and compatibility direction: pending Goal 3 Phase 7
- Runtime tooling and automated enforcement: later bounded implementation work

This document owns:

- the application registration pipeline;
- the responsibility of each registration concept;
- canonical versus generated registration inputs;
- dependency ordering and deterministic composition;
- native framework and build boundaries;
- registration failure expectations;
- the distinction between application registration and Host Registries.

## 3. Architectural Role

The Application Registration System is restricted application-wide composition infrastructure.

It is not:

- a Core capability;
- a Module;
- UI;
- a Frame Surface;
- a Delivery Adapter;
- a Host;
- a Registry;
- a Contribution;
- a feature-behavior owner;
- a generic service locator.

Registration connects an owner-controlled artifact to an approved runtime or build integration. Registration does not transfer ownership of the artifact, its Contract, or its behavior.

## 4. Registration Pipeline

The accepted target pipeline is:

```text
Owner Registration Descriptors
        ↓
Registration Compiler
        ↓
Compiled Registration Manifest
        ↓
Root Application Registrar
        ↓
Typed Registrars, owner-local Providers, and native framework or build APIs
```

The pipeline separates:

- canonical owner declarations;
- validation and dependency ordering;
- generated deterministic output;
- root application composition;
- final native framework or build execution.

Filesystem presence alone does not register a canonical artifact.

The pipeline terms describe responsibilities and artifact categories. They do not mandate classes named `ApplicationRegistrationSystem`, `OwnerRegistrationDescriptor`, or `TypedRegistrar`, and they do not require a custom wrapper around sufficient native Laravel or Vite behavior.

## 5. Owner Registration Descriptor

Each registrable Core capability, Module, or UI responsibility exposes one explicit Owner Registration Descriptor.

A descriptor may declare applicable:

- Providers;
- routes and route metadata;
- commands and schedules;
- views, Blade namespaces, and components;
- Livewire aliases;
- migrations, factories, and seeders;
- configuration and required environment inputs;
- translations;
- Events and Listeners;
- CSS and JavaScript bundles;
- Host Contributions;
- explicit owner or package dependencies.

The descriptor responsibility may be fulfilled by a formal Module Definition, owner-local Provider, immutable Data Object, dedicated descriptor, or another accepted owner-controlled mechanism.

When a dedicated class is justified, it uses `<Owner>RegistrationDescriptor`. A shared `RegistrationDescriptorInterface` is introduced only when a stable reusable contract materially requires it.

The descriptor is the canonical registration input owned by the same owner as the declared artifacts.

A descriptor declares registration intent. It does not execute feature behavior, become a Registry, or replace the declared artifact’s own Contract.

### Registration Dependency Semantics

Owner Registration Descriptor dependencies express application-composition ordering requirements.

They do not enumerate every public runtime Contract relationship between owners.

A runtime Contract relationship does not require a registration dependency merely because one owner injects or invokes another owner's public Contract after application composition has completed.

Declare an owner registration dependency only when correct registration/composition requires the provider owner's applicable registration to occur first.

Therefore:

```text
runtime Contract graph
    ≠
registration dependency graph
```

Bidirectional runtime public Contract relationships are permitted when architecture otherwise allows them.

They must not be converted automatically into cyclic Owner Registration Descriptor dependencies.

Registration-time behavior must not eagerly resolve runtime collaborators merely to manufacture an ordering requirement.

If a real composition dependency exists, declare that actual dependency explicitly and preserve an acyclic registration graph.

## 6. Registration Compiler

The Registration Compiler consumes Owner Registration Descriptors and:

1. validates required paths, classes, identifiers, aliases, and dependency declarations;
2. detects missing, duplicate, conflicting, cyclic, unknown, and stale declarations;
3. resolves accepted dependency order;
4. produces deterministic registration output;
5. generates the Compiled Registration Manifest.

When represented by a dedicated PHP class, the compiler uses `RegistrationCompiler`. Compile and validation command classes, when implemented, use `CompileRegistrationManifestCommand` and `ValidateRegistrationDescriptorsCommand`.

The compiler is build, cache-preparation, deployment, or other bounded application-composition tooling. It is not unrestricted request-time feature discovery.

The compiler must preserve Core independence from optional Modules and reject unknown or cyclic Module dependencies.

## 7. Compiled Registration Manifest

The Compiled Registration Manifest is generated deterministic output containing validated and ordered registration instructions.

Owner Registration Descriptors remain canonical inputs. The manifest is reproducible derived output.

When represented by a dedicated type, use `CompiledRegistrationManifest`. A materialized file uses `compiled-registration-manifest.<format>`.

The final source-control, cache, and invalidation policy remains deferred, but the target architecture requires:

- deterministic generation;
- stale-output detection;
- no hand-authored feature ownership in generated output;
- traceability from every instruction to an owner declaration;
- validation before the manifest is treated as usable.

Owner behavior must not depend on the generated manifest.

## 8. Root Application Registrar

The Root Application Registrar is restricted application-wide Laravel integration. When a dedicated class is justified, use `RootApplicationRegistrar`; a native Provider or bootstrap integration may fulfill the responsibility without an additional wrapper.

It consumes the Compiled Registration Manifest and delegates registration to:

- Typed Registrars;
- owner-local Providers;
- Laravel, Livewire, and Blade APIs;
- Vite or asset-composition integration;
- other explicitly approved native integrations.

The Root Application Registrar owns root composition only. It must not absorb owner-specific behavior or reach into owner internals beyond the accepted registration Contract.

## 9. Typed Registrars

A Typed Registrar performs one bounded registration family. Custom classes use `<ArtifactFamily>Registrar` and remain sparse. `TypedRegistrar`, `GenericRegistrar`, and `DefaultRegistrar` are not valid concrete class names.

Potential families include:

| Registration family        | Native or owner-controlled destination                   |
| -------------------------- | -------------------------------------------------------- |
| Routes                     | Laravel route registration and route cache               |
| Providers and bindings     | Laravel service-container and Provider integration       |
| Commands and schedules     | Laravel console and scheduler integration                |
| Views and Blade components | Laravel view and Blade registration                      |
| Livewire aliases           | Livewire component registration                          |
| Configuration              | Laravel configuration repository and configuration cache |
| Migrations and seeders     | Laravel database execution                               |
| Events and Listeners       | Laravel event integration                                |
| Assets                     | Deterministic owner declaration and Vite composition     |
| Host Contributions         | Host-owned Registry submission and validation            |

A Typed Registrar does not become the owner of registered artifacts.

## 10. Host Registry Distinction

The Application Registration System and a Host Registry are separate mechanisms.

```text
Contributor-owned declaration
        ↓
Application Registration System validation and routing
        ↓
Host Registry validation, acceptance, ordering, and resolution
        ↓
Host-owned resolved output
```

The Application Registration System may verify that a Contribution targets a known Host and Extension Point and may route the declaration to the applicable Registry.

The Host remains authoritative for:

- the Extension Point Contract;
- Contribution acceptance and rejection;
- ordering;
- availability;
- filtering;
- resolved Registry output.

A Host Registry does not become the application-wide registrar, and the Registration Compiler does not become the Host Registry.

### Navigation Contributions

Settings, Projects, and other Product owners may declare Contributions targeting Core Navigation Extension Points. Application Registration validates the structural declaration and routes it to `App\Core\Navigation`; it does not determine active Workspace inclusion, permission, Module availability, route availability, ordering, current state, or fallback. Those remain Core Navigation and provider-owned public Contract responsibilities.

## 11. Native Framework And Build Boundaries

Laravel remains responsible for its native runtime and cache behavior, including applicable:

- routes;
- configuration;
- views;
- events;
- Providers and service-container bindings;
- console commands;
- migrations and seeders;
- package integration.

Vite remains responsible for:

- CSS and JavaScript compilation;
- module bundling;
- development asset serving;
- production asset generation.

The Application Registration System validates and deterministically composes their owner-controlled inputs. It does not replace Laravel caches or Vite builds.

Blade components that use accepted conventions may remain conventionally resolved. Nonconventional or package-owned component paths and namespaces require explicit registration.

Livewire classes outside its conventional root require explicit alias-to-class registration.

## 12. Ownership And Dependency Direction

The Application Registration System may depend on:

- Owner Registration Descriptors;
- public registration metadata;
- accepted owner and package dependency declarations;
- native framework or build APIs.

It must not require Core, Module, UI, or Surface behavior to depend on:

- the Registration Compiler;
- the Compiled Registration Manifest;
- the Root Application Registrar;
- a Typed Registrar.

Root application composition may register owner artifacts through accepted public boundaries, but registration does not make Laravel integration the owner of those artifacts.

## 13. Failure And Validation Model

Required registration failures are failures rather than silent omissions.

Later implementation must reject applicable:

- missing declared files or classes;
- duplicate route names;
- duplicate view namespaces;
- duplicate Livewire aliases;
- duplicate configuration keys;
- duplicate asset declarations;
- unknown owner or package dependencies;
- dependency cycles;
- unknown Hosts or Extension Points;
- missing declared assets;
- stale generated output;
- required resources silently skipped by a registrar.

A failed mandatory registration gate does not authorize weakening the declaration or bypassing validation.

## 14. Current Implementation And Migration

The accepted target does not prove that the current repository registration mechanisms implement this architecture.

Until migration and validation are complete:

- existing bootstrap and package-registration code remains current implementation evidence;
- existing silent-skip or filesystem-discovery behavior does not become target policy;
- new canonical registration work must not expand transitional mechanisms without an accepted bounded reason;
- physical migration remains Goal 3 Phase 7 and later implementation authority.

## 15. Deferred Authority

Goal 3 Phase 5 accepted the Application Registration terminology and conditional names for dedicated descriptors, compilers, manifests, registrars, commands, and generated files.

Descriptor schema, serialization format, generated path, source-control and cache policy, bootstrap integration, compiler implementation, performance model, and migration sequence remain later bounded authority.

Goal 3 Phase 6 accepted representative validation and confirmed Product navigation as a Host Contribution family.

Goal 3 Phase 7 owns migration and compatibility direction.

Later bounded implementation work owns architecture, smallest vertical slice, native-environment validation, compiler construction, cache integration, CI enforcement, and runtime proof.

## 16. Related

- [Architecture Index](index.md)
- [Repository Architecture](repository-architecture.md)
- [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md)
- [System Overview](system-overview.md)
- [Stack Overview](stack-overview.md)
- [Application Registration System Definition](../07-planning/Definitions/Application-Registration/Definition.md)
- [Goal 3 Target Repository Architecture](../07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 4 Placement And Dependency Rules Index](../07-planning/Milestones/milestone-0/goal-3/phase-4/index.md)
- [Phase 4 Dependency And Communication Matrix](../07-planning/Milestones/milestone-0/goal-3/phase-4/dependency-and-communication-matrix.md)
- [Phase 5 Application Registration Terminology And Naming Boundaries](../07-planning/Milestones/milestone-0/goal-3/phase-5/5-14-application-registration-terminology-and-naming-boundaries.md)
- [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md)
