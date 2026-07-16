<!--
DOC-META
title: Technical Role Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Technical-Roles/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Technical Role as the secondary organizational classification applied beneath an explicit owner and cohesive capability or Module.
-->

# Technical Role Definition

Parent: [Definitions Index](../Index.md)

- [1. Definition](#1-definition)
- [2. Classification Rule](#2-classification-rule)
- [3. Owns](#3-owns)
- [4. Must Not Own](#4-must-not-own)
- [5. Dependency Rules](#5-dependency-rules)
- [6. Target Status](#6-target-status)
- [7. Accepted Decision](#7-accepted-decision)
- [8. Open Questions](#8-open-questions)
- [9. Related](#9-related)

## 1. Definition

A Technical Role is the secondary organizational classification that describes what an artifact does within an explicit owner and cohesive capability, Module, UI area, or Laravel integration concern.

The classification sequence is:

```text
Owner
└── Capability, Module, UI area, or Laravel integration concern
    └── Technical Role
```

Examples include Action, Query, Contract, Data Object, Model, Policy, Event, Listener, Job, Provider, Registry, Surface, and Delivery Adapter roles.

A Technical Role describes responsibility and placement semantics. It is not an application owner.

## 2. Classification Rule

An artifact belongs to a Technical Role when:

- its application owner is already known;
- its cohesive capability, Module, UI area, or Laravel integration concern is already known;
- one accepted role accurately describes the artifact’s responsibility;
- the role’s ownership, dependency, and prohibited-content rules apply.

Technical Role classification must occur after owner and capability classification.

Physical folder names are working representations of accepted roles. Final folder casing, namespaces, and exact placement remain subject to Goal 3 tree, placement, and naming decisions.

## 3. Owns

A Technical Role definition may own:

- the role’s repository-wide meaning;
- the responsibilities that belong within the role;
- responsibilities prohibited from the role;
- permitted dependency directions;
- applicable structural and naming constraints;
- relationships to adjacent roles;
- role-specific verification expectations.

A role definition may identify a working physical label, such as:

```text
Actions/
Queries/
Contracts/
Registry/
Surface/
Http/
Console/
```

## 4. Must Not Own

A Technical Role definition must not own:

- application behavior;
- capability- or Module-specific required structure;
- universal folder-presence requirements;
- the decision that every owner must implement the role;
- another Technical Role’s responsibilities;
- final physical root placement before the applicable Goal 3 decision;
- owner-specific files, contracts, tests, or implementation details.

A Technical Role must not become a generic ownership area.

## 5. Dependency Rules

A Technical Role:

- remains subordinate to its explicit application or framework owner;
- may depend only in directions permitted by its owner and role definition;
- must not create a dependency that violates Core, Module, UI, or Laravel boundaries;
- must not use physical proximity as dependency authority;
- must expose public contracts only when its owner authorizes cross-owner use;
- must preserve separation between owner behavior, presentation, delivery, and framework integration.

Capability- and Module-specific dependencies remain controlled by their applicable contracts.

## 6. Target Status

Status: permanent

Technical Role is a permanent organizational concept.

The shared role vocabulary applies to Core capabilities and Modules without requiring identical folder trees.

A role is represented physically only when the owner contains artifacts of that responsibility.

Namespace-bearing Technical Role folders use accepted PascalCase role labels and exact PSR-4 case. Roles remain sparse and appear only when the owner contains that responsibility.

## 7. Accepted Decision

Status: accepted

Login 2.0 uses owner-first, capability-first organization. Technical Role is the third classification question, after owner and cohesive responsibility.

Core capabilities and Modules use the same sparse Technical Role vocabulary. Role definitions govern meaning and boundaries but never require universal folder presence.

Each capability or Module contract declares the roles, folders, and files required for its own implementation.

## 8. Open Questions

The following details remain deferred:

- final physical folder labels;
- final namespace mappings;
- whether additional shared roles are accepted;
- exact static enforcement of role placement;
- exact role-specific proof requirements.

These questions belong to Goal 3 Phases 3 through 6 and later verification work.

## 9. Related

- [Definitions Index](../Index.md)
- [Goal 3 Target Repository Architecture](../../Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 2 Repository Organization Index](../../Milestones/milestone-0/goal-3/phase-2/index.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- Related GitHub issue: #49
