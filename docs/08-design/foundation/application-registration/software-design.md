<!--
DOC-META
title: Application Registration Software Design
doc_type: design
status: draft
owner: architecture
canonical: false
canonical_path: docs/08-design/foundation/application-registration/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the implementation-ready technical design for deterministic owner registration, compilation, validation, manifest generation, and Laravel/Vite integration.
-->

# Application Registration Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Application Registration connects explicit owner-controlled registration declarations to Laravel, Vite, and Host integration without taking ownership of registered behavior.

Canonical pipeline:

```text
Owner Registration Descriptors
        ↓
Registration Compiler
        ↓
Compiled Registration Manifest
        ↓
Root Application Registrar
        ↓
Laravel / Livewire / Blade / Host integration
```

Application Registration is restricted application-wide infrastructure.

It is not:

* a Core capability;
* a Module;
* UI;
* a feature owner;
* a Host Registry;
* a service locator;
* runtime feature discovery.

### Core Rules

* Filesystem presence alone never registers an artifact.
* Every declaration has one explicit owner.
* Owners declare only their own artifacts.
* Compilation is deterministic and occurs before normal application execution.
* Generated output is derived, non-canonical state.
* Module availability and authorization remain separate from registration.
* Host Registries retain semantic authority over Contributions.

---

## 2. Governing Requirements

Primary authority:

* `docs/03-architecture/application-registration.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/repository-architecture.md`
* `docs/02-standards/coding/repository-naming-standards.md`
* `docs/02-standards/coding/Identifier And Key Standards.md`
* `docs/02-standards/coding/File Archetypes.md`
* accepted Goal 3 registration, placement, dependency, and naming planning.

Current manual Providers, route registration, module definitions, and Vite inputs are transitional implementation evidence only.

---

## 3. Component Design

Application Registration implementation lives beneath the restricted Laravel integration boundary:

```text
app/Providers/ApplicationRegistration/
```

Primary components:

| Component                                | Responsibility                                           |
| ---------------------------------------- | -------------------------------------------------------- |
| `RegistrationDescriptorInterface`        | Contract implemented by owner descriptors                |
| `OwnerRegistrationDescriptor`            | Immutable complete declaration for one owner             |
| `RegistrationDeclarationInterface`       | Common structural contract for registration declarations |
| `RegistrationFamily`                     | Controlled declaration-family enum                       |
| `RegistrationCompiler`                   | Validate, order, normalize, and compile descriptors      |
| `CompiledRegistrationManifest`           | Typed representation of generated manifest               |
| `RegistrationManifestLoader`             | Load and validate generated manifest                     |
| `RootApplicationRegistrar`               | Execute compiled Laravel registration in lifecycle order |
| family Registrars                        | Perform one bounded native registration family           |
| `HostContributionSourceInterface`        | Narrow read boundary for Host-targeted Contributions     |
| `ApplicationRegistrationServiceProvider` | Laravel bootstrap adapter                                |

### Registration Families

Support these families:

```text
provider
binding
route
command
schedule
view
livewire
database
configuration
translation
event
asset
host_registry
host_contribution
```

Each family uses a dedicated immutable registration Data Object rather than an untyped payload array.

Examples:

```text
ProviderRegistration
BindingRegistration
RouteRegistration
DatabaseRegistration
EventRegistration
HostContributionRegistration
```

Do not create a generic extensible metadata bag for ordinary registration families.

---

## 4. Descriptor And Compilation Contract

### Owner Descriptor

Every registrable owner exposes one descriptor.

Default paths:

```text
app/Core/<Capability>/Registration/<Capability>RegistrationDescriptor.php

app/UI/<Responsibility>/Registration/<Responsibility>RegistrationDescriptor.php

Modules/<Module>/src/Registration/<Module>RegistrationDescriptor.php
```

Each implements:

```php
interface RegistrationDescriptorInterface
{
    public static function describe(): OwnerRegistrationDescriptor;
}
```

Descriptors are declarative.

They must not:

* query the database;
* read runtime request state;
* resolve container services;
* execute owner behavior;
* register Laravel artifacts directly;
* read secret values.

### Descriptor Registry

Participating descriptors are listed explicitly in:

```text
bootstrap/registration.php
```

The file returns the descriptor class list.

This is the root registration-discovery input.

Application Registration does not scan `app/`, `Modules/`, or `resources/` looking for registrable artifacts.

### Descriptor Content

`OwnerRegistrationDescriptor` defines:

```text
ownership_area
owner_key
optional module_key
owner dependencies
registration declarations
```

Dependencies reference canonical owner keys.

### Compilation

`RegistrationCompiler`:

1. loads the explicit descriptor registry;
2. verifies every descriptor class;
3. materializes each descriptor;
4. validates owner identity and ownership boundaries;
5. validates declared paths, classes, keys, aliases, and targets;
6. validates dependencies;
7. rejects unknown dependencies;
8. rejects dependency cycles;
9. rejects conflicting or duplicate registration identities;
10. orders owners topologically;
11. uses lexical owner-key ordering as the deterministic tie-breaker;
12. normalizes declarations;
13. generates the compiled manifest.

Descriptors with the same effective input must always produce byte-identical compiled output.

---

## 5. Compiled Manifest

Generated output:

```text
bootstrap/cache/compiled-registration-manifest.json
```

The manifest is:

* generated;
* deterministic;
* disposable;
* not canonical source;
* not manually edited;
* not committed unless repository policy later explicitly changes.

### Manifest Content

Top-level content:

```text
schema_version
source_hash
owners
host_registries
host_contributions
assets
```

Each compiled declaration preserves:

```text
owner_key
family
registration_key
normalized registration data
source descriptor class
source repository path
```

Absolute workstation paths must never appear.

### Determinism

Do not include volatile values such as:

```text
compiled_at
hostname
worktree path
process ID
random identifiers
```

`source_hash` is SHA-256 over the normalized descriptor registry and normalized descriptor output.

### Stale Detection

Validation recompiles descriptors in memory and compares their normalized result and source hash with the generated manifest.

A stale manifest is invalid.

Manifest writes are atomic:

```text
compile
→ validate complete result
→ write temporary file
→ atomic replacement
```

Compilation failure preserves the previous valid manifest.

---

## 6. Laravel, Vite, And Host Integration

### Laravel Bootstrap

Register:

```text
app/Providers/ApplicationRegistrationServiceProvider.php
```

from:

```text
bootstrap/providers.php
```

The Provider is a thin adapter around `RootApplicationRegistrar`.

Normal application boot requires a valid compiled manifest.

Application boot must fail explicitly when the manifest is:

* missing;
* malformed;
* unsupported schema;
* internally invalid.

Application boot does not recompile descriptors.

### Root Application Registrar

Registration is split according to Laravel lifecycle.

`register()` handles applicable:

```text
Providers
container bindings
configuration
```

`boot()` handles applicable:

```text
routes
commands
schedules
views / Blade
Livewire
migrations / seeders
translations
Events / Listeners
```

Family-specific behavior belongs in `<ArtifactFamily>Registrar` classes.

Do not place owner behavior in `RootApplicationRegistrar`.

### Assets / Vite

Asset declarations compile into the same JSON manifest.

`vite.config.js` reads compiled asset inputs and combines them with required application entrypoints.

Vite does not discover owner asset directories independently.

A missing or invalid registration manifest fails the asset build.

### Host Registries

Hosts declare their registry identities through `HostRegistryRegistration`.

Contributors declare:

```text
registry_key
contribution_key
contributor owner
implementation reference
declared dependencies
Host-defined metadata
```

The Compiler performs structural validation and groups Contributions by `registry_key`.

Application Registration exposes compiled Contributions through:

```php
interface HostContributionSourceInterface
{
    public function forRegistry(string $registryKey): array;
}
```

The Host consumes that structural output and performs its own:

* Contract validation;
* semantic duplicate/conflict handling;
* ordering;
* availability;
* filtering;
* acceptance/rejection.

Application Registration does not perform those Host decisions.

---

## 7. Security And Reliability

Registration metadata may contain:

* class names;
* repository-relative paths;
* canonical keys;
* dependency identities;
* configuration keys;
* environment-variable names.

It must never contain:

* environment values;
* credentials;
* tokens;
* private keys;
* runtime customer data.

Compiler validation rejects:

* paths outside permitted owner roots;
* traversal paths;
* unknown classes;
* unknown owners;
* duplicate owner identities;
* duplicate unqualified bindings;
* unknown dependencies;
* dependency cycles;
* unknown registration families;
* invalid canonical keys;
* Contributions targeting unknown registered Host identities.

Owner descriptors must not execute arbitrary runtime behavior during compilation.

Compilation and validation are build/deployment operations, not request-time operations.

---

## 8. Operational Effects

Application Registration owns no database, UI, Audit events, user Notifications, or business Events.

Registration failures are configuration/build failures.

They must:

* fail explicitly;
* identify owner and declaration source;
* identify the rejected registration;
* avoid leaking secret values;
* prevent an invalid manifest from replacing a valid one.

Runtime Monitoring integration may later report manifest/bootstrap failures, but Monitoring does not own registration validity.

---

## 9. Implementation Manifest

### Registration Infrastructure

```text
CREATE app/Providers/ApplicationRegistrationServiceProvider.php

CREATE app/Providers/ApplicationRegistration/
    Contracts/RegistrationDescriptorInterface.php
    Contracts/RegistrationDeclarationInterface.php
    Contracts/HostContributionSourceInterface.php

    Data/OwnerRegistrationDescriptor.php
    Data/CompiledRegistrationManifest.php
    Data/CompiledHostContribution.php

    Enums/RegistrationFamily.php

    Registrations/ProviderRegistration.php
    Registrations/BindingRegistration.php
    Registrations/RouteRegistration.php
    Registrations/CommandRegistration.php
    Registrations/ScheduleRegistration.php
    Registrations/ViewRegistration.php
    Registrations/LivewireRegistration.php
    Registrations/DatabaseRegistration.php
    Registrations/ConfigurationRegistration.php
    Registrations/TranslationRegistration.php
    Registrations/EventRegistration.php
    Registrations/AssetRegistration.php
    Registrations/HostRegistryRegistration.php
    Registrations/HostContributionRegistration.php

    Compilers/RegistrationCompiler.php

    Manifests/RegistrationManifestLoader.php

    Registrars/RootApplicationRegistrar.php
    Registrars/ProviderRegistrar.php
    Registrars/BindingRegistrar.php
    Registrars/ConfigurationRegistrar.php
    Registrars/RouteRegistrar.php
    Registrars/CommandRegistrar.php
    Registrars/ScheduleRegistrar.php
    Registrars/ViewRegistrar.php
    Registrars/LivewireRegistrar.php
    Registrars/DatabaseRegistrar.php
    Registrars/TranslationRegistrar.php
    Registrars/EventRegistrar.php

    Exceptions/RegistrationValidationException.php
    Exceptions/RegistrationManifestException.php
```

### Root Composition

```text
CREATE bootstrap/registration.php

GENERATE bootstrap/cache/compiled-registration-manifest.json

MODIFY bootstrap/providers.php
MODIFY vite.config.js
MODIFY composer.json
```

### Build / Validation Tooling

Use bootstrap-safe scripts so the manifest can be generated before Laravel application boot:

```text
CREATE scripts/application-registration/compile.php
CREATE scripts/application-registration/validate.php
```

Both scripts use the same `RegistrationCompiler`.

`composer post-autoload-dump` runs compilation before Laravel commands that require normal application boot.

### Tests

```text
CREATE tests/Architecture/ApplicationRegistration/
    RegistrationDescriptorArchitectureTest.php
    RegistrationOwnershipTest.php

CREATE tests/Feature/ApplicationRegistration/
    RegistrationCompilerTest.php
    RegistrationManifestTest.php
    RegistrationBootstrapTest.php
    HostContributionRoutingTest.php
    AssetRegistrationTest.php
```

---

## 10. Verification And Completion

Required proof must establish:

* only explicitly listed descriptors participate;
* filesystem presence alone does not register an artifact;
* duplicate owner keys fail;
* unknown dependencies fail;
* dependency cycles fail;
* owner dependency order is deterministic;
* repeated compilation is byte-identical;
* stale manifests are detected;
* failed compilation preserves the previous manifest;
* invalid paths/classes/keys fail;
* owner declarations cannot register artifacts outside permitted ownership;
* duplicate bindings/aliases fail where applicable;
* Host Contributions route only to known Host identities;
* Host semantic acceptance remains outside Application Registration;
* Laravel registrations resolve from the compiled manifest;
* Vite inputs resolve from the compiled manifest;
* missing/invalid manifests fail normal bootstrap;
* generated output contains no absolute workstation paths or secret values;
* Application Registration owns no persistence or UI.

### Current Non-Goals

The initial implementation does not define:

* Module installation/enabling lifecycle;
* Host-specific Contribution semantics;
* runtime authorization or availability;
* request-time discovery;
* remote package discovery;
* external plugin marketplaces;
* production deployment orchestration.

### Remaining Blockers

None for the core Application Registration pipeline.

Future Hosts will define their semantic Contribution Contracts, but the structural registration and routing boundary is defined here.

### Implementation Ready

* [x] Ownership and system boundary are defined.
* [x] Descriptor discovery is explicit.
* [x] Descriptor Contract is defined.
* [x] registration families are defined.
* [x] dependency ordering and rejection behavior are defined.
* [x] deterministic manifest format and path are defined.
* [x] stale-output behavior is defined.
* [x] Laravel bootstrap integration is defined.
* [x] Vite integration is defined.
* [x] Host Contribution routing boundary is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [x] no material design blocker remains.

**Design state: ready for repository-owner review and acceptance.**
