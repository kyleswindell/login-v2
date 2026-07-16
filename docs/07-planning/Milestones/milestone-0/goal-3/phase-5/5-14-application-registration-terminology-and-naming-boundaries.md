<!--
DOC-META
title: Phase 5.14 Application Registration Terminology And Naming Boundaries
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-14-application-registration-terminology-and-naming-boundaries.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records canonical Application Registration terminology, conditional custom-artifact naming, native-framework fulfillment, identifier boundaries, and deferred implementation authority.
-->

# Phase 5.14 Application Registration Terminology And Naming Boundaries

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define the canonical terminology and conditional naming rules for the Application Registration System without requiring every architecture responsibility to become a separate PHP class, interface, command, file, or inheritance hierarchy.

This decision closes the naming authority that Phase 4 assigned to Phase 5 while preserving later implementation authority over descriptor format, generated output, bootstrap integration, caching, performance, and migration.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: terminology and naming boundaries only; no registration tooling implemented
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: accepted Phase 4 Application Registration architecture and Decisions 5.1, 5.4, 5.5, 5.8, and 5.13
- Downstream validation: Goal 3 Phase 6
- Migration and compatibility owner: Goal 3 Phase 7 and later bounded implementation issues

## 3. Architecture Terms And Concrete Artifacts

The accepted Application Registration terms identify required responsibilities and artifact categories. They do not automatically require one custom repository artifact per term.

| Architecture term               | Required responsibility                                                                                 | Mandatory custom artifact                                        |
| ------------------------------- | ------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------- |
| Application Registration System | Deterministic application-wide declaration, validation, ordering, and composition                       | No umbrella class or folder is required                          |
| Owner Registration Descriptor   | One explicit owner-controlled declaration of registrable artifacts and dependencies                     | A separate descriptor class is not required                      |
| Registration Compiler           | Deterministic validation, dependency ordering, and production of a compiled registration representation | A separate compiler class is conditional                         |
| Compiled Registration Manifest  | Deterministic derived registration representation consumed by root composition                          | A persisted file or dedicated class is conditional               |
| Root Application Registrar      | Restricted application-wide composition into Laravel and approved build or runtime integrations         | A separate registrar class is conditional                        |
| Typed Registrar                 | One bounded registration-family responsibility                                                          | A separate class for every family is prohibited unless justified |

The implementation must preserve the responsibility even when a native Laravel artifact, formal Module Definition, owner-local Provider, immutable Data Object, function, or other accepted mechanism fulfills it.

## 4. Canonical Architecture Terminology

Retain these canonical terms in architecture and planning:

```text
Application Registration System
Owner Registration Descriptor
Registration Compiler
Compiled Registration Manifest
Root Application Registrar
Typed Registrar
```

These terms describe responsibilities and relationships. They are not instructions to create classes named:

```text
ApplicationRegistrationSystem
OwnerRegistrationDescriptor
TypedRegistrar
```

A concrete artifact receives the applicable conditional name only when its independent behavior, contract, lifecycle, validation, or reuse justifies its existence.

Generic alternatives are prohibited:

```text
RegistrationManager
RegistrationService
RegistrationHandler
GenericRegistrar
DefaultRegistrar
RegistrationUtility
```

## 5. Owner Registration Descriptor Naming

Every registrable owner must expose one explicit registration declaration through an accepted owner-controlled artifact.

The declaration may be embodied by:

- a formal Module Definition;
- an owner-local Provider;
- a dedicated descriptor;
- an immutable registration Data Object;
- another accepted owner-controlled mechanism that satisfies the descriptor contract.

A separate descriptor class is not required merely to mirror the architecture term.

When a dedicated owner descriptor class exists, use:

```text
<Owner>RegistrationDescriptor
```

Examples:

```text
IdentityRegistrationDescriptor
NotificationsRegistrationDescriptor
NavigationRegistrationDescriptor
ProjectsRegistrationDescriptor
QuickBooksSyncRegistrationDescriptor
```

The owner segment uses the accepted canonical Core capability, Module, UI responsibility, or restricted Laravel integration name.

When a shared PHP contract is materially required, use:

```text
RegistrationDescriptorInterface
```

Do not introduce the interface before multiple implementations or a stable cross-owner boundary require it.

Avoid:

```text
OwnerRegistrationDescriptor
ModuleRegistrationDescriptor
GenericRegistrationDescriptor
DefaultRegistrationDescriptor
RegistrationConfig
```

A generic abstract descriptor base is permitted only when it enforces meaningful shared state, validation, lifecycle, or behavior. It must not exist solely to create a common parent type.

## 6. Compiler, Manifest, And Command Naming

The deterministic compilation responsibility remains part of the accepted target architecture.

When implemented as a dedicated PHP class, use:

```text
RegistrationCompiler
```

When a dedicated compiled-result type exists, use:

```text
CompiledRegistrationManifest
```

When a materialized generated file exists, use the lowercase kebab-case base name:

```text
compiled-registration-manifest.<format>
```

Examples:

```text
compiled-registration-manifest.php
compiled-registration-manifest.json
```

The extension follows the accepted native serialization format.

When executable console entry points are implemented, use:

| Purpose                                                  | PHP class                                | Artisan signature       |
| -------------------------------------------------------- | ---------------------------------------- | ----------------------- |
| Compile the accepted registration representation         | `CompileRegistrationManifestCommand`     | `registration:compile`  |
| Validate owner declarations without materializing output | `ValidateRegistrationDescriptorsCommand` | `registration:validate` |

A separate validation command is optional. Compilation must still perform every validation required by its accepted contract.

The exact schema, serialization format, generated path, source-control policy, cache lifecycle, invalidation rules, and command implementation remain later authority.

## 7. Root Composition And Typed Registrar Naming

The restricted root composition responsibility remains the **Root Application Registrar** in architecture terminology.

When implemented as a dedicated class, use:

```text
RootApplicationRegistrar
```

A native Laravel Provider or bootstrap integration may fulfill this responsibility without a separate class when it preserves the accepted ownership, dependency, validation, and composition boundaries.

Typed Registrar classes use:

```text
<ArtifactFamily>Registrar
```

Potential examples include:

```text
RouteRegistrar
ProviderRegistrar
CommandRegistrar
ScheduleRegistrar
ViewRegistrar
BladeComponentRegistrar
LivewireRegistrar
ConfigurationRegistrar
MigrationRegistrar
SeederRegistrar
EventListenerRegistrar
AssetRegistrar
```

Registrar families remain sparse. Create a custom registrar only when the family requires meaningful custom validation, normalization, ordering, adaptation, or integration beyond a direct native-framework call.

`Typed Registrar` is a category name. Do not create a concrete class named:

```text
TypedRegistrar
```

A Host Contribution should normally be routed directly into the applicable Host-owned Registry boundary. Introduce `HostContributionRegistrar` only if a distinct registration adapter is proven necessary; it must not replace Host Registry validation, acceptance, ordering, or resolution.

## 8. Native Framework Fulfillment

Use the narrowest accepted native or repository-defined artifact that fulfills the responsibility.

Examples of valid fulfillment include:

```text
ProjectsModuleDefinition
IdentityServiceProvider
ApplicationServiceProvider
Laravel route registration
Laravel command registration
Laravel event integration
Blade component registration
Livewire alias registration
Vite composition
```

Do not introduce a custom descriptor, compiler wrapper, registrar, service, or inheritance hierarchy solely because the architecture diagram contains a named responsibility.

Native fulfillment is acceptable only when it preserves:

- explicit owner declarations;
- deterministic discovery and ordering;
- required validation and failure behavior;
- Core independence from optional Modules;
- owner-local behavior and Contracts;
- traceability from registration output to its owner-controlled source;
- the distinction between application registration and Host Registry behavior.

Framework convention alone does not authorize silent registration, unrestricted filesystem discovery, skipped declarations, or hidden dependency edges.

## 9. Identifier And Key Boundaries

Application Registration metadata references the existing canonical identity for each registered artifact.

Example:

```text
owner_key: identity
artifact_family: route
artifact_key: users.index
```

Do not manufacture competing identifiers such as:

```text
registration.identity.routes.users.index
```

unless a later accepted identifier-family decision establishes a distinct registration identifier with an independently justified lifecycle.

Owner identity, artifact family, canonical artifact identity, dependency identity, and compatibility aliases remain separate fields.

Internal manifest record identifiers are implementation details unless explicitly promoted into a stable identifier family.

Registration aliases follow Decision 5.13. They are one-way, non-chainable, noncanonical, verified, and removal-owned.

## 10. Generated Output Boundaries

Owner Registration Descriptors remain canonical inputs.

The Compiled Registration Manifest remains deterministic derived output, whether represented in memory, cached, serialized, or materialized as a generated file.

Generated output must:

- be reproducible from accepted canonical inputs;
- identify itself as generated;
- preserve traceability to each source owner declaration;
- fail validation when stale, missing, conflicting, or incomplete;
- remain non-authoritative for owner behavior;
- not be hand-maintained as a competing source of truth.

The exact generated-file header, metadata, hashing, storage, cache, and source-control rules remain later implementation authority.

## 11. Abstraction Boundaries

Generic registration abstractions are permitted only when they define one exact reusable contract, invariant, lifecycle, or mechanism.

Concrete owner descriptors and custom registrars remain specifically named.

Prefer composition and interfaces over inheritance unless a base class genuinely enforces shared state, validation, lifecycle, or behavior.

Do not create:

```text
AbstractRegistrationDescriptor
BaseRegistrar
RegistrationService
RegistrationManager
```

without an independently demonstrated need and an exact bounded responsibility.

An existing Module Definition, Provider, or native integration may satisfy the required architecture role without an additional wrapper.

## 12. Accepted Decision

> The accepted Application Registration terms identify architecture responsibilities and artifact categories. They do not mandate one PHP class, interface, command, generated file, or inheritance hierarchy for every term.
> Every registrable owner exposes one explicit owner-controlled registration declaration. A formal Module Definition, owner-local Provider, dedicated descriptor, immutable Data Object, or another accepted mechanism may satisfy the Owner Registration Descriptor responsibility.
> When a dedicated descriptor class exists, it uses `<Owner>RegistrationDescriptor`. A shared `RegistrationDescriptorInterface` is introduced only when a stable reusable contract is materially required.
> The deterministic compilation responsibility retains the architecture name `Registration Compiler`. A dedicated compiler class uses `RegistrationCompiler`; a dedicated compiled-result type uses `CompiledRegistrationManifest`; and a materialized generated file uses `compiled-registration-manifest.<format>`.
> Compile and validation command classes, when implemented, use `CompileRegistrationManifestCommand` and `ValidateRegistrationDescriptorsCommand` with the signatures `registration:compile` and `registration:validate`.
> The root composition responsibility retains the architecture name `Root Application Registrar`. A dedicated class uses `RootApplicationRegistrar`, but a native Laravel Provider or bootstrap integration may fulfill the responsibility when it preserves the accepted boundaries.
> Custom Typed Registrar classes use `<ArtifactFamily>Registrar` and remain sparse. `Typed Registrar` is a category name rather than a required `TypedRegistrar` class.
> Application Registration references existing canonical owner and artifact identifiers. It must not manufacture competing `registration.*` aliases for routes, configuration, Events, Jobs, Contributions, assets, or other registered artifacts.
> Owner declarations remain canonical inputs. The compiled registration representation remains deterministic derived output and does not become the owner of registered behavior.
> Native framework and existing repository artifacts are preferred when they satisfy the accepted responsibility. Custom abstractions are introduced only when distinct behavior, validation, lifecycle, integration, or reuse justifies them.
> This decision defines terminology and conditional naming only. It does not select the descriptor schema, serialization format, generated-output directory, source-control policy, cache lifecycle, bootstrap implementation, compiler architecture, performance model, or migration sequence.

## 13. Boundaries And Handoff

- Phase 6 must validate the terminology and conditional artifact model against representative Core, Module, UI, and delivery examples.
- Phase 7 owns coarse current-to-target registration migration and compatibility direction.
- Later bounded implementation work owns the architecture and smallest vertical slice for any compiler, manifest, command, registrar, cache, or generated-output tooling.
- New or materially expanded registration tooling requires an accepted design and validation plan before full implementation.
- Current registration files and classes are implementation evidence only and do not automatically receive compatibility status.
- This decision does not authorize runtime code changes, file movement, namespace migration, generated output, or compatibility removal.

## 14. Related

- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Class And Interface Naming](5-4-class-and-interface-naming.md)
- [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md)
- [Configuration Naming](5-8-configuration-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Application Registration](../../../../../03-architecture/application-registration.md)
- [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md)
- [Phase 4 Route Placement And Registration](../phase-4/4-4-route-placement-and-registration.md)
- [Phase 4 Exceptions And Future Enforcement](../phase-4/4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
