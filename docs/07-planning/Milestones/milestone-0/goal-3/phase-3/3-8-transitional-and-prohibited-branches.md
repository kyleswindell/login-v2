<!--
DOC-META
title: Phase 3.8 Transitional And Prohibited Branches
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-8-transitional-and-prohibited-branches.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records transitional, compatibility-only, deprecated, generated, and prohibited branches and the gate for later removal or reclassification.
-->

# Phase 3.8 Transitional And Prohibited Branches

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document classifies known non-target locations without mapping individual files or performing migration.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: classification and target direction only
- Owning GitHub issue: #50
- Later migration owner: Goal 3 Phase 7 and Goal 9 implementation planning

## 3. Classification Vocabulary

| Status             | Meaning                                                                 |
| ------------------ | ----------------------------------------------------------------------- |
| Transitional       | Current placement remains temporarily while content is reclassified     |
| Compatibility-only | Retained solely because verified compatibility requires it              |
| Deprecated         | The concept or name is no longer valid for target architecture          |
| Prohibited         | The branch must not be introduced or used as a target location          |
| Generated/runtime  | May exist locally or during builds but is not canonical source topology |

A path may be transitional in placement and deprecated in terminology.

## 4. Transitional `app/` Branches

| Current branch  | Status                                          | Target direction                                                                       |
| --------------- | ----------------------------------------------- | -------------------------------------------------------------------------------------- |
| `app/Platform/` | Transitional; Platform ownership deprecated     | Reclassify into explicit Core, Module, UI, or restricted Laravel integration           |
| `app/Surfaces/` | Transitional; peer Surface ownership prohibited | Move UI infrastructure to UI, Registries to Hosts, and Surface code to behavior owners |
| `app/Support/`  | Transitional generic branch                     | Assign each artifact to an explicit owner or retire it                                 |
| `app/Models/`   | Transitional or compatibility-only              | Move Models beneath the owner of their state                                           |
| `app/Rules/`    | Transitional                                    | Move Rules beneath the owner of validation policy                                      |
| `app/Livewire/` | Transitional                                    | Move Livewire implementation beneath the owning Surface                                |

No new canonical owner-specific work may be added.

## 5. Transitional Content Inside Permanent Integration Branches

The following owner-specific subtrees are transitional even though their root integration branch remains permanent:

```text
app/Http/Controllers/Platform/
app/Http/Requests/Platform/
app/Console/Commands/
```

Owner-specific artifacts must later follow their Core, Module, or UI owner.

## 6. Transitional Module Structures

### 6.1. `Modules/_Template/`

Status: transitional and prohibited as a future Module entry.

Target direction:

```text
stubs/modules/
```

Removal requires an accepted Module generator template and no remaining repository dependency.

### 6.2. Direct-Root Module PHP

These patterns are transitional:

```text
Modules/<Module>/Actions/
Modules/<Module>/Http/
Modules/<Module>/Models/
Modules/<Module>/Providers/
Modules/<Module>/Services/
Modules/<Module>/Support/
Modules/<Module>/Header/
Modules/<Module>/Navigation/
```

Target direction:

```text
Modules/<Module>/src/<TechnicalRole>/
```

Package integration and support branches remain at Module root.

### 6.3. `module.php`

Status: transitional or compatibility-only.

The target uses Composer metadata, one canonical Module definition, and owner-local Providers.

### 6.4. Current Module Catalog

The current Account, Auth, Dashboard, Notifications, Preferences, Roles, Settings, and Setup packages remain evidence.

Their eventual Core, Module, split, compatibility, or retirement disposition is not decided here.

## 7. Transitional Resource Branches

The following parallel source trees are transitional under Decision 3.6:

```text
resources/css/components/
resources/css/patterns/
resources/css/tokens/
resources/css/type/
resources/css/ui/
resources/js/ui-controls/
resources/js/internal/
```

Their contents must later move into artifact bundles, category internals, owner-specific presentation, base integration, or retirement.

## 8. Transitional Presentation Paths

```text
resources/views/platform/
resources/views/livewire/platform/
```

These must become owner-specific Core or Module presentation.

Current mixed paths such as:

```text
resources/views/components/shell/
resources/views/components/layouts/
```

must be divided between reusable UI infrastructure, Core Shell composition, and owner-specific layouts.

## 9. Compatibility Styles

Files such as:

```text
resources/css/legacy.css
```

may remain compatibility-only when verified rendering depends on them.

Each retained compatibility file requires:

- explicit compatibility scope;
- prohibited new usage;
- verification;
- removal condition;
- migration owner.

## 10. Transitional Tests

Owner-specific tests currently centralized under root `tests/` are transitional under Decision 3.9.

Target locations include:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
```

No test may move until deterministic local and CI discovery is proven.

## 11. Transitional Documentation Paths

### 11.1. `docs/07-planning/03-platform-surfaces/`

Status: transitional; terminology deprecated.

Content must be reclassified into applicable Core, UI, Registry, Surface, Delivery Adapter, historical, or archived planning.

### 11.2. `docs/07-planning/temp/Laravel/`

Status: transitional planning package.

Remove after durable definitions and accepted decisions are routed to their correct owners.

### 11.3. `docs/07-planning/temp/Surfaces/`

Status: transitional planning package.

Content must use Decision 2.90 terminology and move to the applicable definition, architecture, or owner-specific planning package.

### 11.4. Historical Evidence

Generated Goal 2 evidence remains unchanged. Historical paths and terminology do not establish target topology.

## 12. Prohibited Root Branches

Do not introduce generic root application or support owners such as:

```text
Platform/
Surfaces/
Shared/
Common/
Helpers/
Utilities/
Services/
Support/
Features/
Infrastructure/
Tools/
Templates/
```

A separately accepted root requires a distinct permanent repository responsibility.

## 13. Prohibited Direct `app/` Branches

The permanent direct children of `app/` are:

```text
Core/
UI/
Http/
Console/
Providers/
```

Do not introduce peer technical-layer or generic branches such as:

```text
app/Actions/
app/Models/
app/Rules/
app/Jobs/
app/Events/
app/Listeners/
app/Policies/
app/Notifications/
app/Livewire/
app/Services/
app/Support/
app/Shared/
app/Common/
app/Infrastructure/
app/Platform/
app/Surfaces/
```

## 14. Prohibited Core And Module Structures

Do not introduce generic Core layers such as:

```text
app/Core/Shared/
app/Core/Common/
app/Core/Helpers/
app/Core/Utilities/
app/Core/Services/
app/Core/Infrastructure/
app/Core/Models/
```

Do not create universal Module skeletons or preserve empty directories merely to imitate consistency.

## 15. Compatibility-Only Retention Rule

A non-target location may remain compatibility-only when removal would break a verified contract such as:

- serialized or queued class names;
- authentication model configuration;
- Composer or package integration;
- framework discovery;
- routes;
- factories, seeders, migrations, or policies;
- deployment integration;
- external integrations;
- persisted identifiers.

Every exception must record:

- exact path and owner;
- reason and dependency;
- permitted deviation;
- prohibited expansion;
- verification;
- removal condition;
- migration owner.

## 16. Removal And Reclassification Gate

A transitional branch may be removed only after:

1. every material responsibility has an accepted owner;
2. target branch and role are accepted;
3. namespace, registration, route, configuration, asset, and test changes are implemented;
4. compatibility dependencies are resolved or explicitly retained;
5. targeted verification passes unchanged;
6. documentation and agent guidance route to the target;
7. repository-owner acceptance authorizes removal.

Phase 3 authorizes no physical migration.

## 17. Accepted Decision

> Login 2.0 treats `app/Platform/`, `app/Surfaces/`, `app/Support/`, root owner-specific `app/Models/`, `app/Rules/`, and `app/Livewire/`, the current direct-root Module PHP layout, `Modules/_Template/`, parallel CSS and JavaScript component trees, platform-owned presentation paths, and legacy Platform planning packages as transitional or compatibility-only. They are prohibited destinations for new canonical work and must be reclassified into the accepted Core, Module, UI, Laravel integration, resource-bundle, test, documentation, script, stub, or operations structure. Generic ownership branches such as `Platform`, `Surfaces`, `Shared`, `Common`, `Helpers`, `Utilities`, `Services`, and `Support` are prohibited at repository, application-owner, Core, and Module levels. Historical evidence remains unchanged, and no transitional branch may be removed until ownership, target placement, compatibility, verification, documentation, and repository-owner acceptance requirements are satisfied.

## 18. Related

- [Phase 3 Index](index.md)
- [Target `app/` Branches](3-2-target-app-branches.md)
- [UI And Resource Structure](3-6-ui-and-resource-structure.md)
- [Supporting Repository Branches](3-7-supporting-repository-branches.md)
- Related GitHub issue: #50
