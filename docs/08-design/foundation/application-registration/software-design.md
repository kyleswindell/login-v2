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
Laravel / Livewire / Blade / Vite / Host integration
```

Application Registration is restricted application-wide composition infrastructure.

It is not:

* a Core capability;
* a Module;
* UI;
* a feature owner;
* a Host Registry;
* a service locator;
* request-time feature discovery.

### Core Rules

* Filesystem presence alone never registers an artifact.
* Every declaration has one explicit owner.
* Owners declare only their own artifacts and dependencies.
* Owner declarations remain canonical inputs.
* Compilation is deterministic and occurs before normal application execution.
* Generated output is derived, non-canonical state.
* Core remains independent from optional Modules.
* Module installation and runtime enablement remain separate concerns.
* Host Registries retain semantic authority over Contributions.

---

## 2. Governing Requirements

Primary authority:

* `docs/03-architecture/application-registration.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/repository-architecture.md`
* `docs/07-planning/Definitions/Application-Registration/Definition.md`
* `docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-14-application-registration-terminology-and-naming-boundaries.md`
* `docs/02-standards/coding/repository-naming-standards.md`
* `docs/02-standards/coding/Identifier And Key Standards.md`
* `docs/02-standards/coding/File Archetypes.md`

Current implementation may be reviewed for useful behavioral evidence, but it imposes no compatibility, preservation, migration, discovery, or target-placement requirement on this design.

Obsolete proof-of-concept registration or composition artifacts may be explicitly removed during implementation where the accepted target design replaces them.

---

## 3. Component Design

Application Registration has three implementation surfaces:

```text
app/ApplicationRegistration/
    framework-independent registration Contracts,
    data, compilation, manifest handling, and composition logic

app/Providers/ApplicationRegistrationServiceProvider.php
    thin Laravel bootstrap adapter

scripts/application-registration/
    bootstrap-safe executable compile/validation entry points
```

### Core Components

| Component                                | Responsibility                                      | Target Path                                                                 |
| ---------------------------------------- | --------------------------------------------------- | --------------------------------------------------------------------------- |
| `RegistrationDescriptorInterface`        | Stable owner-declaration Contract                   | `app/ApplicationRegistration/Contracts/RegistrationDescriptorInterface.php` |
| `HostContributionSourceInterface`        | Typed Host Contribution read boundary               | `app/ApplicationRegistration/Contracts/HostContributionSourceInterface.php` |
| `RegistrationDescriptorData`             | Immutable complete declaration for one owner        | `app/ApplicationRegistration/Data/RegistrationDescriptorData.php`           |
| `CompiledRegistrationManifest`           | Typed compiled representation                       | `app/ApplicationRegistration/Data/CompiledRegistrationManifest.php`         |
| `CompiledHostContribution`               | One structurally compiled Contribution              | `app/ApplicationRegistration/Data/CompiledHostContribution.php`             |
| `HostContributionSet`                    | Typed immutable Contribution result                 | `app/ApplicationRegistration/Data/HostContributionSet.php`                  |
| `RegistrationFamily`                     | Controlled registration-family enum                 | `app/ApplicationRegistration/Enums/RegistrationFamily.php`                  |
| `RegistrationCompiler`                   | Validate, normalize, order, and compile descriptors | `app/ApplicationRegistration/Compiler/RegistrationCompiler.php`             |
| `RegistrationManifestLoader`             | Load and structurally validate generated manifest   | `app/ApplicationRegistration/Manifest/RegistrationManifestLoader.php`       |
| `RootApplicationRegistrar`               | Execute validated application composition           | `app/ApplicationRegistration/Registrars/RootApplicationRegistrar.php`       |
| `ApplicationRegistrationServiceProvider` | Laravel bootstrap adapter                           | `app/Providers/ApplicationRegistrationServiceProvider.php`                  |

Custom Typed Registrar classes are introduced only when a registration family requires independently meaningful normalization, validation, ordering, or adaptation beyond a direct native-framework operation.

### Registration Families

Supported families:

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

Each materially different family uses an immutable typed registration Data Object.

The initial design defines:

```text
ProviderRegistration
BindingRegistration
RouteRegistration
CommandRegistration
ScheduleRegistration
ViewRegistration
LivewireRegistration
DatabaseRegistration
ConfigurationRegistration
TranslationRegistration
EventRegistration
AssetRegistration
HostRegistryRegistration
HostContributionRegistration
```

These types exist because the registration families have different structural data Contracts, not merely because the architecture diagram names them.

Do not create:

* a generic metadata payload for ordinary registration;
* one Registrar class automatically for every family;
* a generic registration inheritance hierarchy;
* `RegistrationManager`;
* `RegistrationService`;
* `GenericRegistrar`;
* `DefaultRegistrar`.

---

## 4. Owner Registration Contract

### Owner Registration Descriptor

Every registrable owner exposes exactly one explicit owner-controlled registration declaration.

The architecture responsibility may be fulfilled by:

* an owner-local Provider;
* a formal Module Definition;
* a dedicated `<Owner>RegistrationDescriptor`;
* another accepted owner-controlled artifact implementing the descriptor Contract.

A separate descriptor class is not required merely to mirror the architecture term.

### Shared Contract

```php
interface RegistrationDescriptorInterface
{
    public static function registration(): RegistrationDescriptorData;
}
```

`RegistrationDescriptorData` contains:

```text
ownership_area
owner_key
optional module_key
owner dependencies
registration declarations
```

Dependencies reference accepted canonical owner identities.

### Descriptor Restrictions

Registration declarations must not:

* query application persistence;
* read request or session state;
* resolve arbitrary application services;
* execute feature behavior;
* register Laravel artifacts directly during compilation;
* read secret values;
* depend on the generated manifest;
* infer registration from filesystem presence.

---

## 5. Descriptor Discovery

Application Registration uses explicit declaration sources rather than recursive application filesystem discovery.

### Base Application Owners

Permanent base-application registration sources are listed in:

```text
bootstrap/registration.php
```

This registry may reference applicable:

* Foundation owners;
* Core owners;
* reusable UI owners;
* restricted application-integration owners.

It contains declaration sources, not feature configuration or behavior.

### Optional Modules

Installed Modules are discovered through Composer package metadata.

Each Login 2.0 Module package declares its registration source in its package `composer.json`.

Canonical metadata shape:

```json
{
  "extra": {
    "login-v2": {
      "registration_descriptor": "Parasolutions\\Modules\\Projects\\ProjectsModuleDefinition"
    }
  }
}
```

The compiler reads installed Composer package metadata and includes only installed packages that declare this supported key.

A formal Module Definition should normally fulfill the Module's registration-descriptor responsibility when it already owns the required declarations.

Application Registration must not:

* recursively scan `Modules/`;
* infer registration from package directories;
* require Core code changes when a properly declared optional Module is installed;
* treat Composer installation as runtime Module enablement;
* treat installation as authorization or entitlement.

### Discovery Boundary

```text
explicit base registration registry
        +
installed Composer package metadata
        ↓
accepted descriptor sources
```

No other implicit discovery source participates in the initial design.

---

## 6. Compilation

`RegistrationCompiler`:

1. loads explicit base-application descriptor sources;
2. loads installed Module descriptor sources from Composer metadata;
3. verifies each descriptor source;
4. materializes each `RegistrationDescriptorData`;
5. validates owner identity and ownership boundaries;
6. validates declared classes, paths, aliases, artifact keys, and targets;
7. validates declared dependencies;
8. rejects unknown dependencies;
9. rejects dependency cycles;
10. rejects duplicate or conflicting registration identities;
11. validates Host/Registry structural references;
12. determines deterministic owner ordering;
13. normalizes registration declarations;
14. generates the Compiled Registration Manifest.

### Deterministic Ordering

Owner order is determined by:

```text
declared dependency graph
    ↓
topological order
    ↓
canonical owner-key lexical ordering for otherwise independent peers
```

Equivalent canonical inputs must produce byte-identical compiled output.

### Compiler Failure

Compilation fails explicitly for applicable:

* missing descriptor;
* invalid descriptor class;
* duplicate owner;
* invalid owner identity;
* missing class;
* missing declared file;
* invalid canonical artifact key;
* duplicate registration identity;
* unknown dependency;
* dependency cycle;
* unknown Host/Registry;
* structurally invalid Contribution;
* unsupported registration family.

Compilation must not silently ignore required declarations.

---

## 7. Artifact Identity

Application Registration references existing canonical artifact identities.

It does not create a generic `registration_key` family.

Compiled instructions contain applicable:

```text
owner_key
artifact_family
artifact_key or native family-specific identity
normalized registration data
source declaration class
source repository path
```

Example:

```text
owner_key: users
artifact_family: route
artifact_key: users.index
```

Provider example:

```text
owner_key: auth
artifact_family: provider
class: App\Core\Auth\Providers\AuthServiceProvider
```

Host Contribution identity remains:

```text
registry_key
contribution_key
```

Do not manufacture competing identities such as:

```text
registration.users.routes.users.index
```

unless a later accepted identifier-family decision establishes a genuinely distinct registration identity.

---

## 8. Compiled Registration Manifest

Generated output:

```text
bootstrap/cache/compiled-registration-manifest.json
```

The manifest is:

* generated;
* deterministic;
* disposable;
* non-canonical;
* not manually edited;
* not source-controlled unless repository policy explicitly changes.

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

Compiled instructions preserve enough data to identify:

* declaring owner;
* registration family;
* existing canonical artifact identity;
* normalized registration instruction;
* descriptor source;
* repository-relative source location.

Absolute workstation paths must never appear.

### Source Hash

`source_hash` is SHA-256 over normalized canonical registration inputs.

Do not include volatile values such as:

```text
compiled_at
hostname
worktree path
process ID
random IDs
```

### Stale Detection

The compile/validation tooling can re-materialize canonical descriptors and compare their normalized source hash with the generated manifest.

Stale generated output fails validation.

Normal request-time boot does not recompile owner descriptors merely to prove staleness.

### Atomic Materialization

Manifest generation:

```text
compile
    ↓
validate complete result
    ↓
write temporary file
    ↓
atomic replacement
```

A failed compile must not replace the previous valid manifest.

---

## 9. Laravel Bootstrap And Composition

### Root Bootstrap

Laravel directly registers only the infrastructure necessary to establish Application Registration.

```text
bootstrap/providers.php
    ↓
ApplicationRegistrationServiceProvider
```

Normal owner Providers are composed through Application Registration rather than permanently accumulated in `bootstrap/providers.php`.

### ApplicationRegistrationServiceProvider

The Provider is a thin framework adapter.

It:

1. loads the compiled manifest;
2. rejects missing, malformed, unsupported, or internally invalid manifest data;
3. delegates validated instructions to `RootApplicationRegistrar`.

It does not own feature behavior.

### Root Application Registrar

`RootApplicationRegistrar` performs or delegates accepted native registration.

Use direct Laravel/framework APIs where sufficient.

Create an `<ArtifactFamily>Registrar` only when a family requires meaningful independent:

* normalization;
* validation;
* ordering;
* adaptation;
* lifecycle integration.

The initial design does not pre-create a Registrar class for every registration family.

---

## 10. Composer And Build Lifecycle

Compilation must be possible after Composer autoload generation without requiring a normally bootable Laravel application.

Required lifecycle:

```text
Composer autoload generated
        ↓
Application Registration compiler executes
        ↓
compiled manifest exists
        ↓
Laravel package discovery / normal Laravel boot
```

`composer.json` therefore invokes the bootstrap-safe compiler before Artisan operations that require the normal application Provider graph.

Compile entry point:

```text
scripts/application-registration/compile.php
```

Validation entry point:

```text
scripts/application-registration/validate.php
```

Both execute the same `RegistrationCompiler` implementation.

The scripts do not contain a second registration implementation.

---

## 11. Native Registration Families

Application Registration prepares, validates, and deterministically composes native integration inputs.

Laravel, Livewire, Blade, Composer, and Vite retain their native responsibilities.

### Providers And Bindings

Register explicitly declared Providers and container bindings.

Application Registration does not become a service locator.

### Routes

Owner-local route files are explicitly declared and loaded deterministically.

Application Registration does not own route behavior, authorization, or canonical route names.

### Commands And Schedules

Explicit owner declarations identify command and schedule integration.

Laravel owns execution.

### Views / Blade / Livewire

Register explicit:

* view namespaces;
* Blade integration;
* Livewire aliases;

only where required by owner packaging or accepted application structure.

Native convention remains valid where explicit custom registration is unnecessary.

### Database Lifecycle

Owner declarations may identify:

* migration paths;
* factory integration;
* seeders.

Application Registration connects those declarations to Laravel's database lifecycle.

It does not own schema semantics.

### Configuration

Application Registration may load or merge declared configuration sources.

The contributing owner retains the semantic meaning of each configuration value.

Secrets are never stored in registration metadata.

### Translations

Owner translation locations/namespaces may be explicitly composed where required.

### Events And Listeners

Owner declarations identify Laravel Event/Listener registration.

Application Registration does not own Event meaning or Listener behavior.

---

## 12. Assets And Vite

Owner asset declarations compile into the same manifest.

`vite.config.js` consumes compiled asset inputs and combines them with required application entrypoints.

Vite remains responsible for:

* development serving;
* dependency processing;
* bundling;
* asset compilation;
* production output.

Application Registration owns only deterministic declaration and composition of accepted inputs.

Vite must not independently discover canonical owner assets through unrestricted owner-directory scanning.

A build requiring registered assets fails if the compiled registration manifest is missing or structurally invalid.

Staleness is enforced through compile/validation tooling before accepted build/deployment execution.

---

## 13. Host Registries And Contributions

Hosts declare Registry or Extension Point identities through their owner registration declarations.

Contributors declare applicable:

```text
registry_key
contribution_key
contributor owner
implementation reference
declared dependencies
Host-permitted structural metadata
```

Application Registration validates:

* structural shape;
* contributor ownership;
* known Host/Registry target;
* canonical Contribution identity;
* declared dependency structure;
* required implementation/source existence.

It groups structurally valid Contributions by `registry_key`.

### Public Host Boundary

```php
interface HostContributionSourceInterface
{
    public function forRegistry(string $registryKey): HostContributionSet;
}
```

`HostContributionSet` is immutable and contains typed `CompiledHostContribution` values.

### Host Authority

The Host owns:

* Extension Point Contract validation;
* semantic compatibility;
* semantic duplicate/conflict policy;
* ordering;
* availability;
* filtering;
* acceptance/rejection;
* resolved output.

Application Registration must not absorb these responsibilities.

---

## 14. Security And Reliability

Registration metadata may contain:

* class names;
* repository-relative paths;
* canonical identifiers;
* dependency identities;
* configuration keys;
* environment-variable names.

It must never contain:

* environment values;
* credentials;
* tokens;
* private keys;
* secret-manager values;
* runtime customer data.

Compiler validation rejects:

* path traversal;
* paths outside accepted owner roots;
* unknown classes;
* unknown owners;
* duplicate owner identities;
* invalid artifact keys;
* conflicting declarations;
* unknown dependencies;
* dependency cycles;
* unsupported families;
* Contributions targeting unknown Hosts or Registries.

Descriptor evaluation is build/cache/deployment behavior, not request-time application behavior.

Application Registration owns no database and no UI.

---

## 15. Operational Effects

Registration failures are configuration/build failures.

They must:

* fail explicitly;
* identify the declaring owner;
* identify the declaration source;
* identify the rejected artifact or dependency;
* avoid leaking secrets;
* preserve the prior valid manifest when compilation fails.

Monitoring may later record compilation/bootstrap failures as operational evidence.

Application Registration remains authoritative for registration validity.

It owns no business Audit Events and no user Notifications.

---

## 16. Implementation Manifest

### Application Registration Core

```text
CREATE app/ApplicationRegistration/
    Contracts/RegistrationDescriptorInterface.php
    Contracts/HostContributionSourceInterface.php

    Data/RegistrationDescriptorData.php
    Data/CompiledRegistrationManifest.php
    Data/CompiledHostContribution.php
    Data/HostContributionSet.php

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

    Compiler/RegistrationCompiler.php

    Manifest/RegistrationManifestLoader.php

    Registrars/RootApplicationRegistrar.php

    Exceptions/RegistrationValidationException.php
    Exceptions/RegistrationManifestException.php
```

Do not create additional Typed Registrar classes unless implementation design for that family proves a distinct adapter is necessary.

### Laravel Bootstrap

```text
CREATE app/Providers/ApplicationRegistrationServiceProvider.php

CREATE bootstrap/registration.php

MODIFY bootstrap/providers.php
```

`bootstrap/providers.php` directly registers the Application Registration bootstrap Provider.

Owner Providers are thereafter composed through Application Registration.

### Generated Output

```text
GENERATE bootstrap/cache/compiled-registration-manifest.json
```

### Build Tooling

```text
CREATE scripts/application-registration/compile.php
CREATE scripts/application-registration/validate.php

MODIFY composer.json
MODIFY vite.config.js
```

### Obsolete Composition Cleanup

Implementation must remove obsolete proof-of-concept registration/composition mechanisms that conflict with the accepted target system.

Use explicit `DELETE` or bounded modification instructions in the implementation issue for each identified obsolete artifact.

Do not preserve an obsolete registration mechanism merely because existing proof-of-concept code currently depends on it.

### Tests

```text
CREATE tests/Architecture/ApplicationRegistration/
    RegistrationDescriptorArchitectureTest.php
    RegistrationOwnershipTest.php

CREATE tests/Feature/ApplicationRegistration/
    RegistrationCompilerTest.php
    RegistrationManifestTest.php
    RegistrationBootstrapTest.php
    ModuleRegistrationDiscoveryTest.php
    HostContributionRoutingTest.php
    AssetRegistrationTest.php
```

---

## 17. Verification And Completion

Required proof must establish:

* only explicitly declared registration sources participate;
* filesystem presence alone does not register artifacts;
* base application registration uses `bootstrap/registration.php`;
* installed optional Modules are discovered only through supported Composer metadata;
* absence of optional Modules does not invalidate Core;
* duplicate owner identities fail;
* unknown dependencies fail;
* dependency cycles fail;
* deterministic owner ordering;
* repeated compilation is byte-identical;
* stale manifests fail validation;
* failed compilation preserves the previous valid manifest;
* invalid paths, classes, aliases, and canonical keys fail;
* owner declarations cannot register artifacts outside permitted ownership;
* existing artifact identities are preserved rather than replaced by `registration.*` keys;
* Host Contributions route only to known Host/Registry identities;
* Host Contribution output is typed;
* Host semantic acceptance remains outside Application Registration;
* Laravel registrations resolve from the compiled manifest;
* Vite inputs resolve from the compiled manifest;
* manifest compilation works before normal Laravel application boot;
* missing or malformed manifests fail normal bootstrap;
* generated output contains no absolute workstation paths or secret values;
* no unnecessary Registrar hierarchy exists;
* Application Registration owns no persistence or UI;
* obsolete conflicting proof-of-concept registration mechanisms are removed rather than preserved through compatibility behavior.

### Non-Goals

The initial implementation does not define:

* Module installation lifecycle;
* runtime Module enablement;
* Module entitlement or assignment;
* Host-specific Contribution semantics;
* runtime authorization or availability;
* request-time discovery;
* remote plugin marketplaces;
* production deployment orchestration.

### Remaining Blockers

None for the initial Application Registration implementation.

Later owner designs may introduce additional registration declarations or justify a bounded Typed Registrar without changing the core registration model.

### Implementation Ready

* [x] ownership and system boundary are defined.
* [x] owner declaration Contract is defined.
* [x] base application discovery is defined.
* [x] optional Module discovery is defined.
* [x] registration families are defined.
* [x] dependency ordering and rejection behavior are defined.
* [x] artifact identity handling is defined.
* [x] deterministic manifest format and lifecycle are defined.
* [x] stale-output validation is defined.
* [x] bootstrap/compiler ordering is defined.
* [x] Laravel integration is defined.
* [x] Vite integration is defined.
* [x] Host Contribution routing and typed output are defined.
* [x] custom abstraction creation is bounded.
* [x] proof-of-concept cleanup policy is explicit.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [x] no material implementation-design blocker remains.

**Design state: ready for repository-owner review and acceptance.**
