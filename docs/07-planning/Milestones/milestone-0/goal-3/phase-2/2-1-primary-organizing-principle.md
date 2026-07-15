<!--
DOC-META
title: Phase 2.1 Primary Organizing Principle
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-1-primary-organizing-principle.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted owner-first, capability-first primary organization rule for Login 2.0.
-->

# Phase 2.1 Primary Organizing Principle

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records the resolved Phase 2.1 decision for the primary organization of Login 2.0 application code.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: target direction only
- Owning GitHub issue: #49
- Parent GitHub issue: #19
- Downstream consumer: Phase 3, Issue #50

## 3. Decision Question

Should application code be organized primarily by:

- technical layer;
- owner and capability;
- or a defined hybrid?

The model must:

- make ownership visible;
- provide one default classification sequence;
- preserve Core, Module, and UI boundaries;
- work naturally with Laravel;
- avoid generic dumping-ground folders;
- support independently packageable Modules;
- translate cleanly into a target repository tree.

## 4. Options Reviewed

### 4.1. Technical-Layer-First

```text
app/
├── Actions/
├── Contracts/
├── Models/
├── Policies/
├── Queries/
└── Services/
```

Rejected because it groups unrelated capabilities by implementation role, obscures ownership, encourages generic service folders, and makes capability migration and Module packaging harder.

Technical roles remain useful only as secondary organization.

### 4.2. Owner-First Only

```text
Core/
Modules/
UI/
Laravel/
```

This exposes major ownership boundaries but does not provide enough organization within each owner.

Without capability-level organization, an owner can still become a broad collection of unrelated technical roles.

### 4.3. Owner-First, Capability-First

```text
Core/
└── Settings/
    ├── Actions/
    ├── Contracts/
    └── Policies/

Modules/
└── Notifications/
    ├── Actions/
    ├── Contracts/
    └── Jobs/
```

Selected because it combines explicit ownership, cohesive capability grouping, and Laravel-native technical roles.

## 5. Accepted Decision

> Login 2.0 uses owner-first, capability-first organization. Every application responsibility is first assigned to Core, a Module, UI, or Laravel framework integration and then organized beneath the cohesive capability or responsibility that owns it. Laravel-native technical roles are grouped within that owner and capability boundary. Repository-wide technical-layer folders and generic shared ownership areas are not the default organizational model. Exact physical paths, namespaces, and repository branches remain later Goal 03 decisions.

## 6. Classification Sequence

Classify new or migrated code in this order:

1. **Owner** — Core, a Module, UI, or Laravel framework integration.
2. **Capability or cohesive responsibility** — the owner whose policy, state, behavior, or contract the artifact supports.
3. **Technical role** — Action, Contract, Model, Policy, Query, Job, Provider, delivery adapter, or another accepted role.

Ownership is determined by responsibility, not current path, route, namespace, file type, framework default, or number of consumers.

## 7. Laravel Relationship

The model retains Laravel-native concepts, including:

- controllers;
- requests;
- models;
- policies;
- events;
- listeners;
- jobs;
- commands;
- providers.

Owner-specific Laravel artifacts remain with their capability or Module whenever practical.

Application-wide bootstrap and composition remain Laravel integration concerns.

## 8. Required Effects

The target repository model must:

- make owner and capability visible before technical role;
- group Core code by cohesive capability;
- keep each Module cohesive and independently understandable;
- keep reusable UI infrastructure distinct from product behavior;
- keep Laravel composition distinct from application behavior;
- prevent repository-wide technical buckets from becoming the default;
- reject generic ownership areas such as `Common`, `Shared`, `Helpers`, `Utilities`, and `Platform`.

## 9. Boundaries

Decision 2.1 does not decide:

- exact root folders;
- exact namespaces;
- exact Module package structure;
- detailed Laravel integration paths;
- artifact-level placement;
- naming conventions;
- migration sequencing.

Those decisions belong to later Goal 3 phases.

## 10. Examples

Valid:

```text
Core/
└── Audit/
    ├── Actions/
    ├── Contracts/
    └── Models/
```

Invalid:

```text
app/
├── Actions/
├── Models/
└── Services/
```

The invalid structure makes technical role more visible than ownership and capability.

## 11. Documentation Impact

Reflect this decision in:

- the Phase 2 index;
- the Goal 3 target-architecture artifact;
- the Phase 3 target tree;
- later placement and naming rules;
- applicable capability and Module documentation;
- future repository instructions after the model becomes durable policy.

## 12. Verification

Confirm that the model:

- provides one default classification sequence;
- preserves Core, Module, UI, and Laravel boundaries;
- does not recreate a generic owner;
- supports packageable Modules;
- can be translated into a practical target tree.

## 13. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.2 Secondary Organization Within Each Owner](2-2-secondary-organization-within-each-owner.md)
- GitHub issue: #49
- Downstream GitHub issue: #50
