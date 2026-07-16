<!--
DOC-META
title: Phase 5.7 Route And URL Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-7-route-and-url-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records capability-first route-name grammar, independently migratable URL paths, Module route roots, and separate compatibility mechanisms.
-->

# Phase 5.7 Route And URL Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define canonical route names and URL paths without deriving either from physical folders, controller namespaces, delivery channels, or ownership labels.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Deferred authority: exact administrative URL prefix remains with Issue #5

## 3. Naming Matrix

| Concern            | Pattern                            | Example                              |
| ------------------ | ---------------------------------- | ------------------------------------ |
| Route name         | Capability-first dotted key        | `users.index`                        |
| Nested resource    | `<capability>.<resource>.<action>` | `users.roles.update`                 |
| Module route root  | `module_key`                       | `projects.show`                      |
| URL segment        | Lowercase kebab-case               | `/data-governance`                   |
| Resource URL       | Usually plural collection noun     | `/users/{user}`                      |
| Domain-action URL  | Resource path plus precise verb    | `/users/{user}/suspend`              |
| Administrative URL | `<admin-prefix>/<resource>`        | `/admin/users`                       |
| Compatibility URL  | Redirect to canonical URL          | `/user-management` to `/admin/users` |

## 4. Route-Name Rules

Use capability-first lowercase dotted keys. Each segment follows ADR-0007 snake-case grammar.

```text
users.index
users.show
users.update
users.roles.update
projects.archive
global_administration.tenants.update
```

Use conventional terminal actions such as `index`, `show`, `create`, `store`, `edit`, `update`, and `destroy` when accurate. Use domain verbs such as `archive`, `suspend`, `restore`, and `approve` only when normal resource operations are insufficient.

Do not derive route names from:

- PHP namespaces;
- controllers;
- folders;
- URL paths;
- administrative URL prefixes;
- ownership areas;
- delivery channels.

Generic prefixes such as `admin`, `web`, `api`, `core`, and `module` are prohibited unless the term is part of the actual capability identity.

## 5. URL Rules

URLs use:

- lowercase characters;
- kebab-case for multiword segments;
- plural nouns for resource collections;
- singular stable parameter names;
- precise domain verbs only when required.

Examples:

```text
/users
/users/{user}
/users/{user}/roles
/users/{user}/suspend
/data-governance/retention-policies
/projects/{project}/archive
```

Avoid:

```text
/UserManagement
/user_management
/core/identity/users
/Modules/Projects
/users/suspendUser
```

URL paths remain independently migratable from canonical route names.

## 6. Administrative And Module Routes

Administrative URL grouping remains separate from route naming:

```text
Route name: users.index
URL:        /admin/users
```

The exact administrative prefix remains owned by Issue #5.

Module route-name roots normally use the canonical `module_key`:

```text
module_key: projects
route names: projects.index, projects.show, projects.archive
default URL: /projects
```

Multiword example:

```text
module_key: quickbooks_sync
route name: quickbooks_sync.imports.index
URL: /quickbooks-sync/imports
```

A product or compatibility requirement may justify a different URL prefix, but the mapping must be explicit.

## 7. Compatibility

Route-name aliases and URL redirects are separate mechanisms:

```text
Legacy route name -> canonical route name
Legacy URL        -> canonical URL redirect
```

Each compatibility mapping is one-way, non-chainable, noncanonical, and assigned a removal condition and migration owner under Decision 5.13.

## 8. Accepted Decision

> Route names use capability-first lowercase dotted keys. Each segment follows ADR-0007 snake-case grammar.
> Resource operations use conventional terminal actions such as `index`, `show`, `create`, `store`, `edit`, `update`, and `destroy` when those terms accurately describe the route. Domain verbs such as `archive`, `suspend`, `restore`, or `approve` are used only when normal resource operations are insufficient.
> Route names must not be derived from PHP namespaces, controllers, folders, URL paths, administrative URL prefixes, ownership areas, or delivery channels. Generic prefixes such as `admin`, `web`, `api`, `core`, and `module` are prohibited unless the term is part of the actual capability identity.
> Module route-name roots normally use the Module’s canonical `module_key`.
> URL paths use lowercase kebab-case. Resource collection segments normally use plural nouns, while route parameters use singular resource names. Domain-action URLs append a precise lowercase kebab-case verb to the applicable resource path.
> Administrative URL grouping remains separate from canonical route naming. A route may use an administrative URL prefix while retaining a capability-first route name. The exact administrative prefix remains owned by Issue #5.
> Routes, URLs, controllers, folders, and capability identities remain related but separate naming families. URLs may migrate without renaming canonical routes.
> Compatibility route aliases and URL redirects are recorded separately. Each legacy route name or URL maps directly to one canonical target, must not chain, must not remain equally canonical, and must define its removal condition and migration owner.

## 9. Boundaries And Handoff

- This decision does not choose the exact administrative URL prefix.
- It does not migrate current routes or URLs.
- Permission-key grammar remains governed by ADR-0007 and applicable Access standards.
- Phase 6 validates route and URL naming in the representative delivery Surface and Module.

## 10. Related

- [Module Naming](5-3-module-naming.md)
- [Delivery Artifact Naming](5-6-delivery-artifact-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Route Placement And Registration](../phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
