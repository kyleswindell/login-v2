<!--
DOC-META
title: Phase 3.4 Core Physical Structure
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-4-core-physical-structure.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the sparse owner-first physical pattern for Core capabilities, Technical Roles, owner-local tests, Hosts, and Contributions.
-->

# Phase 3.4 Core Physical Structure

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the physical pattern for required Core capabilities beneath `app/Core/`.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: accepted Phase 2 organization and Decisions 3.2–3.3

## 3. Default Pattern

```text
app/
└── Core/
    └── <Capability>/
        ├── Actions/
        ├── Queries/
        ├── Contracts/
        ├── Data/
        ├── Models/
        ├── Policies/
        ├── Events/
        ├── Listeners/
        ├── Jobs/
        ├── Notifications/
        ├── Providers/
        ├── Http/
        ├── Console/
        ├── Registry/
        ├── Surface/
        ├── Contrib/
        │   └── <Host>/
        └── __tests__/
```

This is a vocabulary of permitted roles, not a required skeleton.

## 4. Standard Capability Depth

Every permanent directory directly beneath `app/Core/` represents one cohesive required base-application capability:

```text
app/Core/<Capability>/
```

The normal source pattern is:

```text
app/Core/<Capability>/<TechnicalRole>/
```

Examples:

```text
app/Core/Audit/Actions/RecordAuditEntry.php
app/Core/Audit/Models/AuditEntry.php
app/Core/Dashboard/Registry/WidgetRegistry.php
app/Core/Dashboard/Surface/PageData/DashboardPageData.php
app/Core/Audit/Contrib/Dashboard/RecentAuditActivity.php
```

## 5. Sparse Structure

A capability contains only the roles it actually needs.

Valid:

```text
app/Core/Audit/
├── Actions/
├── Models/
├── Policies/
├── Events/
└── __tests__/
```

Also valid:

```text
app/Core/Runtime/
├── Contracts/
├── Context.php
└── __tests__/
```

Empty folders and speculative architecture are prohibited.

## 6. Capability-Root Files

Files may appear directly at a capability root only when they represent the capability itself or a capability-wide artifact that cannot be classified more precisely.

Possible examples include:

```text
app/Core/<Capability>/Definition.php
app/Core/<Capability>/Capability.php
```

Such files must be explicitly required by the capability contract.

## 7. Prohibited Shared Core Layers

Do not create repository-wide Core technical-layer or generic branches such as:

```text
app/Core/Models/
app/Core/Services/
app/Core/Helpers/
app/Core/Utilities/
app/Core/Shared/
app/Core/Common/
app/Core/Infrastructure/
app/Core/Repositories/
```

Invalid:

```text
app/Core/Models/AuditEntry.php
```

Target direction:

```text
app/Core/Audit/Models/AuditEntry.php
```

## 8. Broadly Used Core Responsibilities

Broad use does not justify generic shared placement.

| Responsibility                 | Core capability direction                         |
| ------------------------------ | ------------------------------------------------- |
| Request and execution context  | Runtime or another explicitly accepted capability |
| Module discovery and lifecycle | A dedicated Module lifecycle capability           |
| Audit recording                | Audit                                             |
| Application settings           | Settings                                          |
| Notification infrastructure    | Notifications                                     |
| Security checks                | Security                                          |
| Dashboard composition          | Dashboard                                         |
| Navigation Registry            | Navigation or the applicable Host                 |

Exact capability names remain Phase 5 authority.

## 9. Nested Capability Layers

A Core capability should normally be directly visible beneath `app/Core/`.

Additional subdirectories are permitted only when they are:

- Technical Roles;
- bounded role-local groupings;
- implementation subdivisions required by the capability contract;
- not ambiguous additional ownership layers.

A generic category owner such as `System/` or `Administration/` requires an explicit accepted definition or structural exception.

## 10. Current Core Evidence

### 10.1. `app/Core/Modules/`

This branch is evidence of a required Core responsibility for Module lifecycle, package definitions, discovery, registration, and Contributions.

It should become one cohesive Core capability. Decision 3.4 does not settle:

- final capability naming;
- exact placement of current classes;
- whether `Definitions/` remains a subordinate concept;
- Contract, Data, Registry, Action, or Query classification.

### 10.2. `app/Core/Runtime/`

This may remain a permanent Core capability when its responsibility is cohesive, such as current invocation context and resolution.

Its broad name must not become a generic infrastructure dumping ground.

## 11. Delivery, Surface, Host, And Contribution Roles

Core capabilities may contain owner-local:

```text
Http/
Console/
Surface/
Registry/
Contrib/
```

A Host owns its Registry locally:

```text
app/Core/Dashboard/Registry/
```

A Contributor owns its Contribution locally:

```text
app/Core/Audit/Contrib/Dashboard/
```

The Host does not absorb Contributor behavior.

## 12. Owner-Local Tests

A Core capability may contain one capability-root test package:

```text
app/Core/<Capability>/__tests__/
├── Unit/
├── Feature/
├── Contracts/
├── Architecture/
├── Fixtures/
└── Support/
```

Tests may mirror Technical Roles beneath that package. Arbitrary `__tests__/` folders beside every class or role are not the default.

## 13. Accepted Decision

> Each permanent directory directly beneath `app/Core/` represents one cohesive required base-application capability. Core capability code is organized sparsely beneath that capability using the accepted shared Technical Role vocabulary. The default structure is `app/Core/<Capability>/<TechnicalRole>/`, with additional role-local grouping only when required by the capability contract. Login 2.0 does not use repository-wide Core technical-layer folders or generic `Shared`, `Common`, `Helpers`, `Utilities`, `Services`, or `Infrastructure` branches. Broadly used required responsibilities must belong to an explicitly named Core capability, reusable UI runtime infrastructure belongs to `app/UI/`, and global Laravel integration remains in the restricted root integration folders. Current `app/Core/Modules/` and `app/Core/Runtime/` content must be evaluated as cohesive Core capabilities, while exact artifact placement and final capability naming remain Phase 4 and Phase 5 authority.

## 14. Related

- [Phase 3 Index](index.md)
- [Target `app/` Branches](3-2-target-app-branches.md)
- [Module Physical Structure](3-5-module-physical-structure.md)
- [Test Folder Locations](3-9-test-folder-locations.md)
- Related GitHub issue: #50