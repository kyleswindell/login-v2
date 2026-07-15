<!--
DOC-META
title: Phase 3.2 Target app Branches
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-2-target-app-branches.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted permanent owner and restricted Laravel integration branches directly beneath app.
-->

# Phase 3.2 Target `app/` Branches

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the permanent direct children of `app/` and classifies current peer branches that do not belong in the target model.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: Decisions 3.1 and accepted Phase 2 organization

## 3. Current Evidence

Current direct children include:

```text
app/
├── Console/
├── Core/
├── Http/
├── Livewire/
├── Models/
├── Platform/
├── Providers/
├── Rules/
├── Support/
└── Surfaces/
```

Current presence does not establish target permanence.

## 4. Permanent Target Branches

```text
app/
├── Core/
├── UI/
├── Http/
├── Console/
└── Providers/
```

| Branch           | Target role                                                               |
| ---------------- | ------------------------------------------------------------------------- |
| `app/Core/`      | Permanent owner root for required base-application capabilities           |
| `app/UI/`        | Permanent owner root for reusable UI-owned PHP and runtime infrastructure |
| `app/Http/`      | Restricted application-wide Laravel HTTP integration                      |
| `app/Console/`   | Restricted application-wide Laravel console integration                   |
| `app/Providers/` | Restricted application-wide Laravel bootstrapping and composition         |

Optional Modules remain independently packaged beneath repository-root `Modules/`.

## 5. Why `app/UI/` Is Required

Current `app/Surfaces/Contracts/` classes provide evidence of reusable PHP infrastructure for UI contracts, normalization, validation, and registry behavior.

Those responsibilities are not owner-specific Surfaces.

The target distinction is:

```text
app/UI/
→ UI-owned PHP and runtime infrastructure

resources/
→ Blade, CSS, JavaScript, localization, and other presentation source
```

Detailed placement within `app/UI/` remains Phase 4 authority.

## 6. Transitional Current Branches

| Current branch  | Target direction                                                                             |
| --------------- | -------------------------------------------------------------------------------------------- |
| `app/Livewire/` | Livewire presentation follows the owning Core capability or Module Surface                   |
| `app/Models/`   | Models follow the capability or Module that owns their state                                 |
| `app/Platform/` | Responsibilities reclassify into Core, Module, UI, or restricted Laravel integration         |
| `app/Rules/`    | Validation rules follow the owner of the validation policy                                   |
| `app/Support/`  | Generic responsibilities receive an explicit owner or are retired                            |
| `app/Surfaces/` | UI infrastructure moves to UI; Registry and Surface code moves to its Host or behavior owner |

These branches are prohibited destinations for new canonical work.

## 7. Current Evidence Examples

The current tree illustrates the required reclassification:

- `app/Models/PlatformAuditLog.php` is Audit-owned;
- `app/Models/Setting.php` is Settings-owned;
- `app/Models/UserDashboardLayout.php` belongs to the accepted Dashboard state owner;
- `app/Livewire/Platform/Dashboard/DashboardPage.php` belongs to the Dashboard Surface;
- `app/Rules/SafeEvidenceLinkUrl.php` belongs to the owner of evidence-link validation;
- `app/Support/UiOptionCatalog.php` appears UI-owned;
- `app/Platform/Security/*` belongs to Core Security;
- `app/Platform/Dashboard/WidgetRegistry.php` belongs to the Dashboard Host Registry.

These examples do not decide exact Phase 4 destinations.

## 8. No Peer Technical-Role Branches

Surface, Registry, Delivery Adapter, Model, Rule, Livewire, Job, Event, Listener, Policy, Notification, and similar concepts are Technical Roles beneath an explicit owner.

They do not create peer `app/` ownership branches.

## 9. Accepted Decision

> Login 2.0 organizes permanent PHP application source beneath two owner roots: `app/Core/` for required Core capabilities and `app/UI/` for reusable UI-owned PHP and runtime infrastructure. Optional Modules remain independently packaged beneath the repository-root `Modules/` branch. Conventional root Laravel folders may remain directly beneath `app/` only as restricted application-wide framework integration boundaries accepted through Decision 3.3. Surface, Registry, Delivery Adapter, Model, Rule, Livewire, and similar technical responsibilities remain beneath their explicit owner and do not create peer `app/` ownership branches. `app/Platform/`, `app/Surfaces/`, and `app/Support/` are transitional and prohibited for new canonical work.

## 10. Boundaries And Handoff

Decision 3.2 does not decide:

- detailed contents of restricted Laravel integration folders;
- exact owner-local artifact placement;
- final capability or responsibility naming;
- namespace migration;
- compatibility implementation;
- physical moves.

Those decisions remain with Decisions 3.3–3.8, Phase 4, Phase 5, and migration work.

## 11. Related

- [Phase 3 Index](index.md)
- [Conventional Laravel Folder Roles](3-3-conventional-laravel-folder-roles.md)
- [Core Physical Structure](3-4-core-physical-structure.md)
- [Transitional And Prohibited Branches](3-8-transitional-and-prohibited-branches.md)
- Related GitHub issue: #50