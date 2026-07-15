<!--
DOC-META
title: Goal 3 Target Repository Architecture
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Consolidates the accepted high-level Goal 3 repository architecture and routes readers to the detailed Phase planning that owns each decision.
-->

# Goal 3 Target Repository Architecture

Parent: [Goal 3 Target Repository Architecture Index](index.md)

## 1. Purpose

Goal 3 defines the target repository architecture that later refactor and implementation work must follow.

This document is the concise Goal 3 synthesis artifact. It records only the accepted high-level result of each Phase and links to the detailed Phase planning that owns the supporting decisions, context, examples, and closeout evidence.

Goal 3 defines the destination. It does not perform the physical repository migration.

## 2. Status

- Planning lifecycle: active
- Acceptance state: Phase 1 accepted; Phase 2 decisions resolved with formal closeout pending; Phases 3 through 7 pending
- Current implementation state: target planning only
- Owning GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current active Phase issue: [#49](https://github.com/kyleswindell/login-v2/issues/49)
- Final Goal 3 acceptance: pending

## 3. Scope

Goal 3 establishes:

- responsibility ownership;
- primary repository organization;
- target repository branches and namespaces;
- artifact placement;
- dependency direction;
- naming conventions;
- representative architecture validation;
- current-to-target migration direction;
- compatibility requirements and structural exceptions.

Goal 3 does not:

- move or rename every current file;
- perform the physical repository refactor;
- implement compatibility adapters;
- define detailed database schemas;
- implement contract-discovery tooling;
- define the complete verification architecture;
- rebuild Core capabilities, Modules, or UI.

## 4. Authority And Reading Model

This document summarizes accepted Goal 3 direction.

Detailed authority remains with:

- the applicable Phase index;
- the detailed Phase planning documents;
- accepted ADRs and definitions;
- the governing GitHub issue and repository-owner acceptance record.

Use the [Goal 3 Index](index.md) to locate the current Phase package.

## 5. Phase Register

| Phase | Subject                                  | State                      | Detailed Planning                 |
| ----- | ---------------------------------------- | -------------------------- | --------------------------------- |
| 1     | Architecture boundaries                  | accepted                   | [Phase 1 Index](phase-1/index.md) |
| 2     | Repository organization                  | resolved; closeout pending | [Phase 2 Index](phase-2/index.md) |
| 3     | Target repository tree                   | pending                    | Future Phase 3 package            |
| 4     | Placement and dependency rules           | pending                    | Future Phase 4 package            |
| 5     | Naming conventions                       | pending                    | Future Phase 5 package            |
| 6     | Representative validation                | pending                    | Future Phase 6 package            |
| 7     | Migration direction and final acceptance | pending                    | Future Phase 7 package            |

## 6. Accepted High-Level Architecture

### 6.1. Architecture Boundaries

Core, Modules, and UI are the source-of-truth application ownership areas.

- Core owns required base-application responsibilities.
- Modules own optional, cohesive, independently understandable feature packages.
- UI owns reusable presentation infrastructure.
- Laravel is the framework, runtime, and application-composition system rather than a competing application owner.
- Current `app/Platform` placement and `Platform`-prefixed identifiers are transitional and have no permanent ownership role.

Phase 2 corrected the earlier Surface terminology:

- a Surface is an owner-specific UI presentation and interaction layer;
- a Host owns an extensible feature;
- a Host-owned Registry defines and resolves extension points;
- Contributions remain owned by their Contributors.

Detailed boundary planning:

- [Phase 1 Index](phase-1/index.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](phase-2/2-90-surface-host-registry-reclassification.md)

### 6.2. Repository Organization

Login 2.0 uses owner-first, capability-first organization.

Classification proceeds in this order:

1. identify the owner;
2. identify the cohesive capability, Module, UI area, or Laravel integration concern;
3. identify the technical role.

Core capabilities and Modules use the same sparse technical-role vocabulary. Role definitions establish meaning and boundaries but do not require universal folder presence.

Cross-cutting use does not create cross-cutting ownership. Delivery adapters remain with the owner of the behavior they expose.

Structural variation is valid when ownership and accepted role meanings remain intact. Actual exceptions require bounded repository-owner acceptance.

Detailed organization planning:

- [Phase 2 Repository Organization Index](phase-2/index.md)

### 6.3. Target Repository Tree

Pending Phase 3.

Phase 3 will define:

- permanent repository-root branches;
- target `app/` branches;
- Core capability structure;
- Module package structure;
- UI and resource structure;
- Laravel integration folders;
- supporting, transitional, and prohibited locations.

### 6.4. Placement And Dependency Rules

Pending Phase 4.

Phase 4 will define:

- artifact placement;
- contract and implementation locations;
- route and configuration placement;
- data, view, asset, test, and documentation placement;
- permitted dependencies;
- accepted cross-owner communication methods.

### 6.5. Naming Conventions

Pending Phase 5.

Phase 5 will define names for:

- folders and namespaces;
- capabilities and Modules;
- classes and delivery artifacts;
- routes and configuration;
- events, jobs, tests, fixtures, and documentation;
- compatibility and rename behavior.

### 6.6. Representative Validation

Pending Phase 6.

Phase 6 will apply the accepted model to representative Core, Module, UI, Surface, Registry, delivery, test, and documentation examples and identify required future architecture proofs.

### 6.7. Migration And Compatibility Direction

Pending Phase 7.

Phase 7 will document:

- coarse current-to-target mappings;
- compatibility requirements;
- intentional structural exceptions;
- later-Goal decision handoffs;
- durable documentation-promotion targets;
- final Goal 3 repository-owner acceptance.

## 7. Required Final Outcome

Goal 3 is complete when future work can determine, without reopening repository architecture:

- who owns a responsibility;
- where its contracts and implementation belong;
- which dependencies are allowed;
- how its repository artifacts are named;
- what compatibility or migration treatment applies;
- what automated, manual, or specialist proof later implementation must provide.

## 8. Documentation Promotion

Accepted Goal 3 planning must eventually be promoted to the applicable durable owners, including:

- architecture documentation;
- repository standards;
- capability and Module contracts;
- definitions;
- `AGENTS.md` files and repository-agent skills where persistent execution rules are required;
- later verification and migration planning.

This planning document should remain a concise historical and routing synthesis rather than the sole permanent owner of every durable rule.

## 9. Verification And Exit Criteria

Goal 3 acceptance requires:

- [ ] all seven Phases are accepted;
- [ ] Phase results agree and use the accepted vocabulary;
- [ ] the target tree, placement, dependency, and naming models are complete;
- [ ] representative examples fit without unresolved structural ambiguity;
- [ ] migration direction, compatibility requirements, and exceptions are documented;
- [ ] later-Goal decisions are explicitly handed off;
- [ ] required durable documentation is created or assigned;
- [ ] documentation guardrails pass;
- [ ] final repository-owner acceptance is recorded in Issue #19.

## 10. Related

- [Goal 3 Index](index.md)
- [Phase 1 Index](phase-1/index.md)
- [Phase 2 Index](phase-2/index.md)
- [Milestone 0 Planning Index](../index.md)
- GitHub parent issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
