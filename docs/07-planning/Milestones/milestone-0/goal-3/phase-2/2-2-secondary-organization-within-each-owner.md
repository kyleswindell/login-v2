<!--
DOC-META
title: Phase 2.2 Secondary Organization Within Each Owner
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted sparse technical-role vocabulary shared by Core capabilities and Modules.
-->

# Phase 2.2 Secondary Organization Within Each Owner

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records how code is organized after its owner and cohesive capability or Module have been identified.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: target direction only
- Owning GitHub issue: #49
- Parent decision: Phase 2.1

## 3. Accepted Decision

> Core capabilities and Modules use the same sparse technical-role vocabulary. Role definitions govern meaning and boundaries but never require universal folder presence. Each capability or Module contract declares the folders and files required for its own implementation, along with their responsibilities and verification requirements.

The default organization is:

```text
Owner
└── Capability or Module
    └── Technical role
```

## 4. Shared Technical-Role Vocabulary

| Role | Responsibility |
| --- | --- |
| `Actions/` | Application operations or use cases that change state or coordinate behavior |
| `Queries/` | Read-oriented operations and resolved data retrieval |
| `Contracts/` | Interfaces and stable data or behavior contracts |
| `Data/` | DTOs, command data, query results, and transfer objects |
| `Models/` | Owner-controlled domain or persistence models |
| `Policies/` | Authorization policy implementation |
| `Events/` | Owner-defined events |
| `Listeners/` | Event consumers |
| `Jobs/` | Queueable or deferred work |
| `Notifications/` | Owner-specific notification implementations |
| `Providers/` | Owner-local Laravel registration and composition |
| `Http/` | Owner-local web or API delivery |
| `Console/` | Owner-local Artisan delivery |
| `Registry/` | Host-owned extension Registry and extension points |
| `Surface/` | Owner-specific UI presentation and interaction layer |
| `Contrib/` | Contributions to another Host’s Registry |

Core capabilities and Modules use the same meanings.

Module package-level requirements do not change the shared internal vocabulary.

## 5. Sparse Structure

Technical-role folders are created only when needed.

Valid examples:

```text
Core/Settings/
├── Actions/
├── Registry/
├── Surface/
└── Policies/
```

```text
Core/Preferences/
├── Actions/
├── Models/
├── Queries/
└── Contrib/
```

Neither owner creates unused folders to match a universal skeleton.

## 6. Role Definitions Versus Required Structure

A shared role definition explains:

- what the role means;
- what belongs there;
- what must not belong there;
- allowed dependency boundaries;
- applicable naming and structural rules.

It must not require that every capability or Module use the role.

The capability or Module contract defines:

- required folders and files;
- why each required role exists;
- public contracts;
- permitted dependencies;
- required tests and documentation;
- conditions that make an optional role required.

Example:

```text
Actions/Definition.md
→ defines Action repository-wide

Settings/Feature-Spec.md
→ defines the Actions, Registry, Surface, policies,
  providers, and files required by Settings
```

A `Feature-Spec.md`, or another accepted owner-specific contract, is the expected owner of requiredness.

## 7. Conditional Roles

These roles exist only when applicable:

- `Registry/` — the owner acts as a Host;
- `Surface/` — the owner has a UI presentation layer;
- `Contrib/` — the owner contributes to another Host;
- `Http/` — the owner exposes web or API delivery;
- `Console/` — the owner exposes Artisan delivery.

Registry, Surface, and Contribution responsibilities remain independent.

## 8. Services

`Services/` is not a standard default folder.

A service-like class is acceptable only when it represents one cohesive named responsibility, has an explicit owner, and cannot be classified more clearly under another accepted role.

`Services/` must not replace:

```text
Helpers/
Utilities/
Common/
Shared/
```

The exact placement of valid service-like classes belongs to later placement decisions.

## 9. Required Effects

This decision requires:

- one shared role vocabulary for Core and Modules;
- sparse folder creation;
- owner-specific requiredness;
- explicit role definitions;
- no universal empty skeleton;
- no silent role redefinition;
- no default catch-all `Services/` folder.

## 10. Documentation Impact

Create or update:

- shared role definitions;
- Host, Registry, Extension Point, Contribution, and Contributor definitions;
- the Surface definition;
- capability and Module Feature Specs;
- the Goal 3 target-architecture artifact;
- later placement and naming standards.

`Contrib/` remains a working folder label until later naming review.

## 11. Verification

Confirm that:

- Core and Modules use the same role meanings;
- role definitions do not mandate universal folder presence;
- owner contracts define requiredness;
- unused folders are not required;
- Registry, Surface, and Contribution remain distinct;
- `Services/` cannot become a generic fallback.

## 12. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.1 Primary Organizing Principle](2-1-primary-organizing-principle.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](2-90-surface-host-registry-reclassification.md)
- GitHub issue: #49
