<!--
DOC-META
title: Phase 5.1 Folder And Namespace Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-1-folder-and-namespace-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the native-convention-first folder model, PSR-4 namespace mapping, controlled role labels, and prohibited generic production paths.
-->

# Phase 5.1 Folder And Namespace Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define folder-family casing, singular and plural treatment, folder-to-namespace mapping, and prohibited generic production destinations without deciding the specialized names owned by Decisions 5.2 through 5.12.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: accepted Goal 3 Phases 1 through 4 and ADR-0007

## 3. Native-Convention-First Model

Login 2.0 does not impose one casing style on every repository folder.

| Folder family                                   | Convention                            | Example                                     |
| ----------------------------------------------- | ------------------------------------- | ------------------------------------------- |
| Reserved repository or Laravel branch           | Exact accepted spelling               | `app/`, `config/`, `Modules/`, `resources/` |
| Namespace-bearing PHP directory                 | PascalCase with exact namespace match | `app/Core/DataGovernance/Actions/`          |
| Fixed package-support directory                 | Exact lowercase conventional name     | `src/`, `routes/`, `database/`, `tests/`    |
| Human-maintained non-PHP owner or artifact path | Lowercase kebab-case                  | `resources/views/core/data-governance/`     |
| Composer package                                | Composer-native lowercase syntax      | `parasolutions/module-projects`             |
| Machine key                                     | ADR-0007 lowercase snake case         | `data_governance`                           |
| Generated, vendor, or tool-owned path           | Native tool convention                | Tool-defined                                |

Reserved direct `app/` branches remain:

```text
Core/
UI/
Http/
Console/
Providers/
```

## 4. PHP Folder And Namespace Mapping

Namespace-bearing PHP directories use PascalCase and map case-sensitively one-to-one beneath their declared PSR-4 prefix.

```text
app/Core/<Capability>/<TechnicalRole>/
App\Core\<Capability>\<TechnicalRole>

app/UI/<Responsibility>/<TechnicalRole>/
App\UI\<Responsibility>\<TechnicalRole>
```

Example:

```text
app/Core/Identity/Actions/SuspendUserAction.php
App\Core\Identity\Actions\SuspendUserAction
```

Restricted root Laravel integration retains:

```text
App\Http
App\Console
App\Providers
```

Each Module owns a package-specific PSR-4 prefix mapped to `Modules/<Module>/src/`. The physical `Modules/` collection, package directory, and `src/` base directory do not automatically become namespace segments. Decision 5.3 defines the exact Module namespace prefix.

A path becomes namespace-bearing only through an explicit PSR-4 or accepted test-autoload mapping. `resources/`, `views/`, `config/`, `routes/`, `database/`, `docs/`, `tests/`, and `__tests__/` do not automatically produce PHP namespace segments.

## 5. Singular And Plural Forms

Technical Role names use one controlled repository-wide form. The form does not change with file count.

```text
Actions/
Queries/
Contracts/
Models/
Policies/
Events/
Listeners/
Jobs/
Notifications/
Providers/
Rules/
Registry/
Data/
Http/
Console/
```

A folder containing one Action remains `Actions/`. A Registry remains `Registry/` when that is the accepted bounded role.

Core capability and Module identities use their natural accepted grammatical form. They are not mechanically singularized or pluralized.

## 6. Separate Naming Families

These forms may correspond but remain independently governed:

```text
Canonical technical name: DataGovernance
PHP segment:              DataGovernance
Machine key:              data_governance
Non-PHP path slug:        data-governance
Documentation title:      Data Governance
```

Paths and namespaces must not be inferred silently from machine keys, URLs, display labels, or Composer package names.

## 7. Prohibited Generic Production Folders

New canonical production ownership or Technical Role destinations must not use:

```text
Common/
Shared/
Misc/
General/
Generic/
Helpers/
Utils/
Utilities/
Services/
Managers/
Support/
Infrastructure/
Platform/
Surfaces/
Features/
Base/
Other/
```

An exact bounded test, tooling, generated, vendor, framework, or compatibility use may retain a native term when explicitly scoped. For example, `tests/Support/` may contain test-harness support. Such use must not become production ownership.

`Platform` is additionally reserved as a potential transitional placeholder for the unresolved global-administration tooling namespace. It is not a peer owner, accepted Core capability, owner key, or generic production destination.

## 8. Valid And Invalid Examples

| Invalid                                 | Problem                                                         | Preferred direction            |
| --------------------------------------- | --------------------------------------------------------------- | ------------------------------ |
| `app/Core/common/`                      | Lowercase namespace folder and generic owner                    | Explicit PascalCase capability |
| `app/Core/Identity/Action/`             | Local singular role variant                                     | `Actions/`                     |
| `app/Core/data-governance/`             | Kebab-case namespace folder                                     | `DataGovernance/`              |
| `Modules/projects/src/`                 | Noncanonical package folder case                                | `Modules/Projects/src/`        |
| `Modules/Projects/src/actions/`         | Namespace-role case mismatch                                    | `Actions/`                     |
| `App\Modules\Projects`                  | Transitional application namespace treated as package authority | Decision 5.3 package prefix    |
| `resources/views/core/DataGovernance/`  | PHP casing used for a non-PHP slug                              | `data-governance/`             |
| `resources/views/core/data_governance/` | Machine-key syntax used for a path slug                         | `data-governance/`             |

## 9. Accepted Decision

> Login 2.0 uses controlled folder naming by folder family rather than one casing convention for every repository path. Reserved repository, framework, owner-root, and package-support folders retain their accepted exact names.
> PHP source directories that correspond to namespace segments use PascalCase and map case-sensitively one-to-one to namespace segments beneath their declared PSR-4 prefix. Core PHP uses `app/Core/<Capability>/<TechnicalRole>/` mapped to `App\Core\<Capability>\<TechnicalRole>`. Reusable UI PHP uses `app/UI/<Responsibility>/<TechnicalRole>/` mapped to `App\UI\<Responsibility>\<TechnicalRole>`. Restricted root Laravel integration uses the accepted `App\Http`, `App\Console`, and `App\Providers` namespaces.
> Every Module is an independently distributable Composer package and owns a package-specific PSR-4 prefix mapped to `Modules/<Module>/src/`. The repository `Modules/` collection, Module package directory, and `src/` base directory are not automatically namespace segments. The current root `App\Modules\` mapping is transitional and does not establish the target Module namespace. Decision 5.3 owns the exact Module namespace and Composer-package relationship.
> Fixed framework and package-support directories use their accepted lowercase names, including `src`, `config`, `routes`, `database`, `resources`, `tests`, and `docs`. Human-maintained non-PHP owner and artifact paths use lowercase kebab-case slugs unless a framework, tool, generated artifact, or later specialized naming decision requires another exact form.
> Technical Role folder names use one controlled repository-wide label. Singular or plural form is defined by the accepted role vocabulary and does not change according to the number of files present. Capability and Module identities are not mechanically singularized or pluralized.
> Physical paths, PHP namespaces, internal keys, Composer package names, URLs, Blade aliases, and display labels remain separate identifier families. Their relationships must be explicit and deterministic, but one family must not silently become canonical authority for another.
> Generic production folders such as `Common`, `Shared`, `Misc`, `Helpers`, `Utils`, `Utilities`, generic `Services`, generic `Managers`, `Support`, `Infrastructure`, and `Surfaces` are prohibited as owner, capability, Module, or Technical Role destinations unless a separate accepted definition grants one exact bounded meaning. Narrow test, tooling, generated, vendor, or compatibility uses may retain native conventions when explicitly scoped and must not create production ownership.
> `Platform` is additionally reserved as a special potential placeholder for the global-administration tooling namespace that is currently unresolved.

## 10. Boundaries And Handoff

- Decisions 5.2 and 5.3 own exact Core and Module identity forms.
- Decision 5.8 owns configuration filenames.
- Decision 5.11 owns test and fixture naming.
- Decision 5.12 owns documentation-specific path naming.
- Adding a class beneath an existing PSR-4 mapping does not by itself change Composer mapping. Composer metadata or mapping changes require the applicable autoload regeneration and verification during implementation.
- Phase 5 does not authorize physical path or namespace migration.

## 11. Related

- [Core Capability Naming](5-2-core-capability-naming.md)
- [Module Naming](5-3-module-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Phase 4 Implementation Placement](../phase-4/4-2-implementation-placement.md)
- [PHP And Laravel Style Standards](../../../../../02-standards/coding/PHP%20And%20Laravel%20Style%20Standards.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
