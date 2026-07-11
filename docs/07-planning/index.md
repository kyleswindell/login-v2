<!--
DOC-META
title: Planning Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/07-planning/index.md
parent: docs/00-start-here.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes accepted planning intent, M0 repository convergence, target-state decomposition, migration direction, implementation sequencing, and planning matrices without owning active delivery status.
-->

# Planning Index

Parent: [Start Here](../00-start-here.md)

- [1. Purpose](#1-purpose)
- [2. Source Roles](#2-source-roles)
- [3. Governing Standards](#3-governing-standards)
- [4. Active Planning Control Documents](#4-active-planning-control-documents)
  - [4.1 M0 Repository Convergence](#41-m0-repository-convergence)
  - [4.2 Core Planning Matrix](#42-core-planning-matrix)
  - [4.3 Cybersecurity Promotion Backlog](#43-cybersecurity-promotion-backlog)
- [5. Planning Organization](#5-planning-organization)
- [6. M0 Delivery Model](#6-m0-delivery-model)
- [7. Planning Lifecycle And Promotion](#7-planning-lifecycle-and-promotion)
- [8. Planning Completion](#8-planning-completion)
- [9. Related](#9-related)

## 1. Purpose

This branch owns accepted planning intent for Login 2.0.

Use it for:

- target-state planning
- architecture and ownership convergence
- capability, platform, module, and Shared UI decomposition
- dependency and decision planning
- migration, compatibility, and refactor direction
- implementation sequencing rationale
- bounded implementation-slice preparation
- open planning questions
- planning matrices
- documentation promotion targets

Planning must describe accepted intent without becoming a parallel task board or a substitute for canonical implemented documentation.

## 2. Source Roles

| Source                     | Responsibility                                                                                                             |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Planning documents         | Accepted planning intent, target state, sequence rationale, decomposition, migration direction, and variance               |
| GitHub issues              | Bounded work packets, parent and sub-issue relationships, acceptance criteria, dependencies, and implementation discussion |
| GitHub Projects            | Current delivery status, priority, sequencing, milestone phase, risk, and dependency fields                                |
| Canonical documents        | Current implemented architecture, behavior, schema, standards, feature contracts, flows, and runbooks                      |
| Decision records           | Durable accepted choices, rationale, alternatives, and supersession history                                                |
| Pull requests and commits  | Reviewable implementation evidence and repository history                                                                  |
| Tests and review artifacts | Automated and manual verification evidence                                                                                 |

Planning documents do not replace issues, Projects, decision records, or canonical owners.

## 3. Governing Standards

- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../02-standards/documentation/Document%20Type%20Standards.md)
- [Implementation Status And Development Sync Standard](../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Planning Template](../09-reference/templates/docs/_planning.md)

## 4. Active Planning Control Documents

### 4.1 M0 Repository Convergence

[M0 Repository Convergence Planning](00-overview/m0-repository-convergence-planning.md) is the milestone charter for converting the accepted pre-M0 repository baseline into one coherent implementation authority.

It owns:

- the ten M0 goal workstreams
- milestone scope and non-goals
- current-to-target convergence requirements
- dependency order and execution waves
- required artifacts
- issue hierarchy expectations
- milestone-wide acceptance criteria
- M1 readiness requirements

The charter remains `draft` until its parent-goal issue structure and initial existing-issue disposition are accepted. GitHub Projects and issues own active delivery state.

[M0 Repository Current-State Inventory](00-overview/m0-repository-current-state-inventory.md) is the canonical issue #29 inventory of repository structure, non-UI runtime surfaces, current ownership evidence, authority state, registration state, compatibility, contradictions, and unresolved target questions for the pinned Goal 02 baseline.

### 4.2 Core Planning Matrix

[Core Service Build Plan Matrix](core-service-build-plan-matrix.md) owns the cross-capability build matrix, target ownership snapshots, physical folder direction, configuration, data and migration planning, testing direction, implementation sequence, owner keys, and open decisions.

M0 must reconcile the matrix against accepted vocabulary, ownership, database, integration, and migration decisions.

[Identifier Key Convention Propagation Planning](01-architecture-boundaries/identifier-key-convention-propagation-planning.md) inventories documentation alignment completed by issue #28 and routes deferred runtime, schema, route, package, and compatibility migrations to their future owners.

### 4.3 Cybersecurity Promotion Backlog

[Cybersecurity Review Backlog Planning](00-overview/cybersecurity-review-backlog-planning.md) routes remaining cybersecurity promotion work into standards, runbooks, architecture, schema, feature contracts, implementation planning, and deferred future topics.

It does not create security requirements by itself.

## 5. Planning Organization

Planning is organized by stable ownership and planning purpose:

| Path                          | Responsibility                                                                                                |
| ----------------------------- | ------------------------------------------------------------------------------------------------------------- |
| `00-overview/`                | Milestone charters, planning control documents, review backlogs, and cross-cutting planning overviews         |
| `01-architecture-boundaries/` | Application structure, capability boundaries, context models, vocabulary, and structural migration planning   |
| `02-core-capabilities/`       | Core capability target state, dependencies, data, security, implementation direction, and capability matrices |
| `03-platform-surfaces/`       | Platform-owned surfaces, renderers, composition, control-plane behavior, and platform migration planning      |
| `04-business-modules/`        | Business Module package, layout, contribution, and surface planning                                           |
| planning root                 | Cross-cutting matrices and control documents whose scope spans multiple planning groups                       |

Do not create empty folders solely to match a proposed tree.

Add a planning subfolder only when it has:

- a stable owner
- multiple related documents
- a clear routing need
- an active maintenance reason

Shared UI planning may remain within the owning architecture, platform-surface, or standards planning until a dedicated planning group has enough stable material to require its own index.

## 6. M0 Delivery Model

M0 uses the following hierarchy:

```text
M0 milestone
  -> M0 Repository Convergence Planning
  -> ten M0 parent goal issues
  -> bounded decision, audit, documentation, tooling, and reconciliation sub-issues
  -> pull requests and commits
```

The ten parent goal issues are acceptance and tracking surfaces. They do not replace the charter and should not duplicate its full content.

Each child issue must have one primary parent goal. Cross-workstream effects must be represented through dependencies, related issues, or Project fields rather than duplicate parent ownership.

Parent goals close only after:

- required child work is complete or explicitly deferred
- resulting artifacts agree with one another
- accepted terminology and ownership are used
- canonical targets are updated
- hidden decisions and contradictions are removed
- downstream implementation can rely on the result

## 7. Planning Lifecycle And Promotion

Planning documents may use these lifecycle states:

- `draft`
- `planned`
- `active`
- `implemented`
- `superseded`
- `archived`

Planning should retain:

- accepted target state
- implementation sequence
- migration direction
- dependencies
- unresolved alternatives
- implementation slices
- accepted variance

Promote durable accepted content to its canonical owner:

| Planning Content                                  | Canonical Destination  |
| ------------------------------------------------- | ---------------------- |
| mandatory durable rule                            | standard               |
| accepted structural boundary                      | architecture           |
| table, field, relationship, or migration contract | database documentation |
| user-observable behavior                          | feature or flow        |
| operational procedure                             | runbook                |
| durable decision and rationale                    | decision record        |
| bounded execution work                            | GitHub issue           |

After promotion, planning should link to the canonical owner and remove duplicated authority where practical.

## 8. Planning Completion

Planning is complete for a scope when:

- current and target states are clear
- scope and non-goals are explicit
- ownership is identified
- dependencies are classified
- durable decisions are accepted or explicitly blocking
- implementation slices are bounded
- migration and compatibility direction are defined
- verification and review requirements are defined
- canonical promotion targets are identified
- related issues exist when execution is ready
- lifecycle status is accurate
- no implementation milestone must infer policy from obsolete or contradictory planning

M0 has additional milestone-wide completion criteria defined in [M0 Repository Convergence Planning](00-overview/m0-repository-convergence-planning.md#27-completion-and-exit-criteria).

## 9. Related

- [Start Here](../00-start-here.md)
- [M0 Repository Convergence Planning](00-overview/m0-repository-convergence-planning.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Decisions Index](../01-decisions/index.md)
- [Architecture Index](../03-architecture/index.md)
- [Features Index](../04-features/index.md)
- [Flows Index](../05-flows/index.md)
- [Database Index](../06-database/index.md)
- [Runbook Index](../10-runbooks/index.md)
- [Documentation Standards Index](../02-standards/documentation/index.md)
