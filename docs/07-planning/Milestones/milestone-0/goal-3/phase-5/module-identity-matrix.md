<!--
DOC-META
title: Phase 5 Module Identity Matrix
doc_type: matrix
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/module-identity-matrix.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Defines the explicit Module identity record, representation rules, accepted examples, invalid forms, compatibility fields, and later package authority.
-->

# Phase 5 Module Identity Matrix

Parent: [Phase 5 Naming Conventions Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Matrix For](#3-use-this-matrix-for)
- [4. Do Not Use This Matrix For](#4-do-not-use-this-matrix-for)
- [5. Source Documents](#5-source-documents)
- [6. Module Identity Record](#6-module-identity-record)
- [7. Accepted Representation Rules](#7-accepted-representation-rules)
- [8. Representative Identities](#8-representative-identities)
  - [8.1. Side-By-Side Matrix](#81-side-by-side-matrix)
  - [8.2. Package Mapping Examples](#82-package-mapping-examples)
- [9. Invalid And Rejected Forms](#9-invalid-and-rejected-forms)
- [10. Compatibility And Lifecycle Fields](#10-compatibility-and-lifecycle-fields)
- [11. Open Decisions And Later Authority](#11-open-decisions-and-later-authority)
- [12. Maintenance Notes](#12-maintenance-notes)
- [13. Related](#13-related)

## 1. Purpose

Define one explicit Module identity record and the relationship among human-readable, machine, repository, PHP, Composer, route, configuration, and documentation representations.

## 2. Status

- Matrix lifecycle: planned
- Decision source: Decision 5.3 accepted through repository-owner Phase 5 review
- Implementation state: target direction only; no package, namespace, or autoload migration
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

## 3. Use This Matrix For

Use this matrix to:

- define a new Module identity after Module ownership is accepted;
- review whether all required identity fields are explicit;
- distinguish `module_key`, folder, namespace, Composer package, route, and configuration identities;
- preserve branded capitalization and exceptional forms;
- prepare later package or compatibility work.

## 4. Do Not Use This Matrix For

Do not use this matrix to:

- decide whether a feature is Core or Module owned;
- classify every current `Modules/` directory as a target Module;
- infer identity fields solely through string conversion;
- implement Composer package extraction, autoloading, versioning, or dependency migration;
- create aliases for rejected design alternatives;
- replace the formal Module Definition or package `composer.json`.

## 5. Source Documents

- [Module Naming](5-3-module-naming.md)
- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Route And URL Naming](5-7-route-and-url-naming.md)
- [Configuration Naming](5-8-configuration-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0005](../../../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)

## 6. Module Identity Record

Every accepted Module records these fields explicitly:

| Field                  | Required value or relationship                                                   | Authority and purpose                                        |
| ---------------------- | -------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| Display name           | Natural accepted title                                                           | Human-facing Module identity                                 |
| `module_key`           | Globally unique lowercase snake-case segment                                     | Stable application machine identity governed by ADR-0007     |
| Package-folder segment | Accepted PascalCase Module segment                                               | Physical package directory beneath `Modules/`                |
| Package root           | `Modules/<Module>/`                                                              | Repository package location                                  |
| PHP namespace prefix   | `Parasolutions\Modules\<Module>\`                                                | Package-owned PSR-4 identity                                 |
| PSR-4 base directory   | `src/`                                                                           | Package-local PHP source base; not a namespace segment       |
| Composer package name  | `parasolutions/module-<module-slug>`                                             | Independently versioned Composer identity                    |
| Route-name root        | Normally `<module_key>.*`                                                        | Canonical route-name family                                  |
| Configuration root     | Normally `<module_key>.*`                                                        | Canonical configuration family                               |
| Documentation title    | `<Display Name> Module`                                                          | Human-readable package documentation identity                |
| Formal definition      | `<Module>ModuleDefinition`                                                       | Declarative Module registration and lifecycle identity       |
| Compatibility names    | Verified legacy identities only                                                  | Migration and removal input governed by Decision 5.13        |
| Status                 | Accepted, transitional, reserved, retired, or another controlled lifecycle value | Prevents proposals and legacy names from appearing canonical |
| Governing decision     | Exact acceptance source                                                          | Prevents automatic or undocumented identity creation         |

No one field silently becomes authority for another.

## 7. Accepted Representation Rules

| Representation      | Pattern                                               | May be mechanically derived?               | Notes                                                                             |
| ------------------- | ----------------------------------------------------- | ------------------------------------------ | --------------------------------------------------------------------------------- |
| Display name        | Natural title case                                    | No                                         | Brand and product wording require explicit acceptance                             |
| `module_key`        | Lowercase snake case                                  | No                                         | Stable machine identity; no `module_`, `business_`, or `platform_` prefix         |
| Package folder      | PascalCase Module segment                             | Not safely in every case                   | Brand capitalization and initialisms may require explicit spelling                |
| PHP namespace       | `Parasolutions\Modules\<Module>\`                     | Only from the accepted namespace field     | The vendor spelling is exactly `Parasolutions`; `src/` is not a namespace segment |
| Composer package    | `parasolutions/module-<module-slug>`                  | Only from the accepted package field       | Composer identity is separate from `module_key`                                   |
| Route root          | Normally `<module_key>.*`                             | Default relationship, not silent authority | Exceptions require explicit product or compatibility reason                       |
| Configuration root  | Normally `<module_key>.*`                             | Default relationship, not silent authority | Runtime settings remain separate from Laravel configuration                       |
| Documentation title | `<Display Name> Module`                               | Presentation relationship only             | Does not redefine machine or package identities                                   |
| URL prefix          | Product-specific lowercase kebab-case when applicable | No                                         | URL identity remains separate and migratable                                      |

## 8. Representative Identities

### 8.1. Side-By-Side Matrix

| Identity            | Projects                          | QuickBooks Sync                                    |
| ------------------- | --------------------------------- | -------------------------------------------------- |
| Display name        | `Projects`                        | `QuickBooks Sync`                                  |
| `module_key`        | `projects`                        | `quickbooks_sync`                                  |
| Package folder      | `Modules/Projects/`               | `Modules/QuickBooksSync/`                          |
| PHP namespace       | `Parasolutions\Modules\Projects\` | `Parasolutions\Modules\QuickBooksSync\`            |
| Composer package    | `parasolutions/module-projects`   | `parasolutions/module-quickbooks-sync`             |
| Route-name root     | `projects.*`                      | `quickbooks_sync.*`                                |
| Configuration root  | `projects.*`                      | `quickbooks_sync.*`                                |
| Default URL example | `/projects`                       | `/quickbooks-sync` when product routing accepts it |
| Documentation title | `Projects Module`                 | `QuickBooks Sync Module`                           |
| Formal definition   | `ProjectsModuleDefinition`        | `QuickBooksSyncModuleDefinition`                   |
| Status              | Representative accepted identity  | Representative accepted identity                   |

### 8.2. Package Mapping Examples

```json
{
  "name": "parasolutions/module-projects",
  "autoload": {
    "psr-4": {
      "Parasolutions\\Modules\\Projects\\": "src/"
    }
  }
}
```

```php
namespace Parasolutions\Modules\Projects\Actions;
```

The namespace-family segment `Modules` is an explicit accepted package-family segment. It is not automatically inferred merely because the package is physically stored beneath `Modules/`.

## 9. Invalid And Rejected Forms

| Form                                    | Treatment                                                               | Reason                                                                                       |
| --------------------------------------- | ----------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| `Modules/ProjectsModule/`               | Invalid new identity                                                    | Adds an unnecessary artifact suffix to the package folder                                    |
| `module_projects`                       | Invalid `module_key`                                                    | Embeds the artifact family in the machine identity                                           |
| `business_projects`                     | Invalid `module_key`                                                    | Embeds an ownership category in the machine identity                                         |
| `platform_projects`                     | Invalid `module_key`                                                    | Uses retired `Platform` ownership terminology                                                |
| `App\Modules\Projects\`                 | Transitional or legacy implementation pattern, not target authority     | Makes an independent package appear as ordinary application source                           |
| `ParaSolutions\Login\Projects\`         | Rejected target proposal, not automatically a compatibility requirement | Uses incorrect business spelling and embeds a product namespace not accepted by Decision 5.3 |
| `parasolutions/login-projects`          | Rejected target proposal, not automatically a compatibility requirement | Accepted package family is `parasolutions/module-<slug>`                                     |
| `Parasolutions\Modules\ProjectsModule\` | Invalid target namespace                                                | Adds an unnecessary `Module` suffix                                                          |
| `parasolutions/projects-module`         | Invalid target package                                                  | Reverses the accepted package-family syntax                                                  |
| `module.projects.*`                     | Invalid route or configuration root                                     | Uses a generic artifact prefix instead of `module_key`                                       |

A rejected alternative becomes a compatibility subject only when repository evidence proves that code, data, packages, consumers, or external systems actually depend on it.

## 10. Compatibility And Lifecycle Fields

For every verified legacy Module identity, record:

| Field                 | Requirement                                                                                                                               |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Identifier family     | Namespace, Composer package, `module_key`, route root, config root, URL, documentation name, or another exact family                      |
| Legacy value          | Exact verified value                                                                                                                      |
| Canonical value       | Exact accepted target value                                                                                                               |
| Module owner          | Responsible Module or migration owner                                                                                                     |
| Compatibility surface | Autoloading, dependency constraints, route resolution, configuration lookup, persisted data, documentation link, or another exact surface |
| Status                | Transitional by default; permanent only through accepted external constraint                                                              |
| Required verification | Consumer inventory and targeted unchanged proof                                                                                           |
| Removal condition     | Objective condition proving the legacy identity is no longer required                                                                     |
| Tracking issue        | Bounded migration or compatibility-removal work packet                                                                                    |

Aliases map directly from one legacy identity to one canonical identity. Module aliases do not chain and do not authorize new code to use the legacy representation.

## 11. Open Decisions And Later Authority

| Item                                                            | Owner                                                    | Phase 5 treatment                                                                                |
| --------------------------------------------------------------- | -------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| Which current feature packages are accepted target Modules      | Repository-owner architecture and later feature planning | Not decided by this matrix                                                                       |
| Package versioning and release policy                           | Later Module packaging and release work                  | Deferred                                                                                         |
| Root versus package Composer repository configuration           | Later package implementation                             | Deferred                                                                                         |
| Exact current `App\Modules\...` consumer and autoload migration | Phase 7 and per-Module migration issues                  | Requires verified inventory                                                                      |
| Module-to-Module package dependency constraints                 | Module contracts and package implementation              | Must be explicit, versioned, declared, and acyclic                                               |
| Machine-readable canonical Module identity registry             | Later registration or tooling decision                   | Markdown remains canonical for Phase 5 planning; no duplicate CSV or YAML source is created here |

## 12. Maintenance Notes

- Add an identity only after the Module owner and Module status are accepted.
- Preserve exact brand spelling rather than relying on automatic case conversion.
- Keep proposed, representative, transitional, and accepted identities visibly distinct.
- Do not record rejected design alternatives as legacy aliases without implementation evidence.
- Update this matrix when Decision 5.3 changes or a representative Phase 6 example proves a bounded correction is necessary.
- If a machine-readable Module registry is later accepted, define one source of truth and generate or summarize the Markdown view rather than maintaining competing canonical copies.

## 13. Related

- [Phase 5 Naming Conventions Index](index.md)
- [Naming Convention Matrix](naming-convention-matrix.md)
- [Role Terminology Matrix](role-terminology-matrix.md)
- [Compatibility And Rename Register](compatibility-and-rename-register.md)
- [Durable Promotion Register](durable-promotion-register.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
