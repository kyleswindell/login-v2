<!--
DOC-META
title: Phase 5.3 Module Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-3-module-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the deterministic Module identity model across display, key, folder, namespace, package, route, configuration, and documentation forms.
-->

# Phase 5.3 Module Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define one explicit identity record for every optional Module while keeping its machine, package, namespace, route, configuration, and documentation names separate.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decision 5.1, ADR-0005, and ADR-0007

## 3. Module Identity Record

Every Module records:

```text
display name
module_key
package-folder segment
PHP namespace prefix
Composer package name
route-name root
configuration root
documentation title
compatibility names
status
governing decision
```

A Module remains an optional, independently versioned, installable, and distributable Composer package with its own implementation, dependencies, tests, documentation, and formal definition.

## 4. Canonical Identity Pattern

| Identity            | Pattern                              | Projects example                  |
| ------------------- | ------------------------------------ | --------------------------------- |
| Display name        | Natural title case                   | `Projects`                        |
| `module_key`        | Lowercase snake case                 | `projects`                        |
| Package folder      | PascalCase                           | `Modules/Projects/`               |
| PHP namespace       | `Parasolutions\Modules\<Module>\`    | `Parasolutions\Modules\Projects\` |
| Composer package    | `parasolutions/module-<module-slug>` | `parasolutions/module-projects`   |
| Route-name root     | `<module_key>.*`                     | `projects.*`                      |
| Configuration root  | `<module_key>.*`                     | `projects.*`                      |
| Documentation title | `<Display Name> Module`              | `Projects Module`                 |

Package autoloading:

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

Example class:

```php
namespace Parasolutions\Modules\Projects\Actions;
```

The namespace segment `Modules` is an explicit package-family segment. It is not inferred automatically from the physical repository collection folder.

## 5. Multiword And Branded Identity

| Identity            | QuickBooks Sync example                 |
| ------------------- | --------------------------------------- |
| Display name        | `QuickBooks Sync`                       |
| `module_key`        | `quickbooks_sync`                       |
| Folder              | `Modules/QuickBooksSync/`               |
| Namespace           | `Parasolutions\Modules\QuickBooksSync\` |
| Composer package    | `parasolutions/module-quickbooks-sync`  |
| Route root          | `quickbooks_sync.*`                     |
| Configuration root  | `quickbooks_sync.*`                     |
| Documentation title | `QuickBooks Sync Module`                |

Brand capitalization and initialisms cannot always be inferred safely from `module_key`. Every representation is stored explicitly rather than reconstructed through automatic case conversion.

The PHP vendor spelling is exactly `Parasolutions`. It must not be rewritten as `ParaSolutions`. Composer’s vendor segment remains lowercase `parasolutions`.

## 6. Core Rules

1. The `module_key` is the stable application machine identity and follows ADR-0007 grammar.
2. The `module_key` must not use `module_`, `business_`, or `platform_` prefixes.
3. The package folder and Module namespace segment use the accepted PascalCase identity.
4. The package-local `src/` directory is the PSR-4 base and is not a namespace segment.
5. Composer package identity remains separate from `module_key`.
6. Route and configuration roots normally use `module_key`.
7. Display names and documentation titles use the accepted human-readable identity.
8. Singular, plural, collective, and branded forms follow the Module’s natural stable name rather than mechanical grammar.
9. Cosmetic display-name changes do not automatically rename `module_key`, namespace, package, route, or configuration identities.
10. Legacy identities map directly to one canonical Module identity and remain subject to Decision 5.13.

## 7. Prohibited Forms

Avoid unnecessary ownership or artifact labels:

```text
Modules/ProjectsModule/
module_projects
business_projects
Parasolutions\Modules\ProjectsModule
parasolutions/projects-module
module.projects.*
modules.projects.*
```

Preferred:

```text
Modules/Projects/
projects
Parasolutions\Modules\Projects\
parasolutions/module-projects
projects.*
```

A Module name must not add generic `Module`, `Package`, `Feature`, `Service`, `Manager`, `Platform`, or `Business` affixes unless that word is part of an independently accepted product identity.

## 8. Accepted Decision

> Every Module maintains one explicit Module identity record containing its display name, `module_key`, package-folder segment, PHP namespace prefix, Composer package name, route-name root, configuration root, documentation title, compatibility names, status, and governing decision.
> The `module_key` is the stable application machine identity and follows ADR-0007 lowercase snake-case grammar. It must not include `module`, `business`, `platform`, a repository path, or a Composer vendor prefix.
> The repository package folder uses the Module’s canonical PascalCase segment beneath `Modules/<Module>/`. Each Module owns a package-specific PSR-4 prefix using `Parasolutions\Modules\<Module>\` mapped to its package-local `src/` directory. The repository `Modules/` collection and `src/` base directory are not automatically namespace segments.
> Composer package names use `parasolutions/module-<module-slug>`, where the module slug is the lowercase hyphenated package representation. Composer package identity remains separate from `module_key`.
> The default route-name root and configuration root use the Module’s `module_key`. Display names and documentation titles use the accepted human-readable Module name, with documentation referring to `<Display Name> Module` where the artifact type must be explicit.
> A Module name must describe its cohesive optional responsibility. It must not include generic `Module`, `Package`, `Feature`, `Service`, `Manager`, `Platform`, or `Business` prefixes or suffixes unless that word is part of an independently accepted product identity.
> Singular, plural, collective, and branded forms are selected according to the natural stable identity rather than mechanical grammar. Brand capitalization, acronyms, and exceptional namespace forms must be recorded explicitly in the Module identity record.
> The identity families remain related but distinct. No folder, namespace, package name, route root, configuration root, URL, or display label silently becomes authority for another family.
> Legacy Module names and aliases must map directly to one canonical identity, must not chain, and remain subject to Decision 5.13.
> The namespace vendor segment uses the canonical business spelling `Parasolutions`. It must not be rewritten as `ParaSolutions` through automatic PascalCase conversion. Composer’s vendor segment remains lowercase `parasolutions`.

## 9. Boundaries And Handoff

- This decision replaces the transitional target assumption of `App\Modules\<Module>`.
- Phase 5 does not change root or package Composer autoloading.
- Phase 6 validates the identity model against one representative Module.
- Later migration work owns package creation, namespace migration, dependency constraints, release/versioning, and legacy package compatibility.

## 10. Related

- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Route And URL Naming](5-7-route-and-url-naming.md)
- [Configuration Naming](5-8-configuration-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Implementation Placement](../phase-4/4-2-implementation-placement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
