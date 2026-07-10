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
summary: Routes accepted planning intent, sequencing, decomposition, migration, implementation-slice, and planning-matrix documentation without owning active delivery status.
-->

# Planning Index

Parent: [Start Here](../00-start-here.md)

## 1. Purpose

This branch owns accepted planning intent for Login 2.0.

Use it for:

- target-state planning
- implementation sequencing rationale
- capability and subsystem decomposition
- dependency planning
- migration and refactor planning
- implementation-slice preparation
- open planning questions
- planning matrices
- documentation promotion targets

## 2. Source Roles

| Source | Responsibility |
| --- | --- |
| Planning documents | Accepted planning intent, target state, sequence rationale, decomposition, and variance |
| GitHub issues | Bounded work packets, acceptance criteria, dependencies, and implementation discussion |
| GitHub Projects | Current delivery status, priority, sequencing, phase, risk, and dependency fields |
| Canonical documents | Current implemented architecture, behavior, schema, standards, and runbooks |
| Decision records | Durable accepted decision rationale and supersession history |
| Pull requests and commits | Reviewable implementation evidence and repository history |

Planning documents do not replace issues, Projects, or canonical owners.

## 3. Governing Standards

- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../02-standards/documentation/Document%20Type%20Standards.md)
- [Implementation Status And Development Sync Standard](../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Planning Template](../09-reference/templates/docs/_planning.md)

## 4. Active Planning Control Documents

The branch may contain high-level control documents such as:

- roadmap
- dependency map
- Core Service Build Plan Matrix
- architecture-boundary planning
- capability, platform, module, and Shared UI planning indexes

Only list a document here as active after it has been reviewed against Planning Documentation Standards.

Existing committed control files requiring current-state review include:

- [Roadmap](roadmap.md)
- [Dependency Map](dependency-map.md)
- [App 2.0 Blueprint Planning](app-2-0-blueprint-planning.md)
- [App 2.0 Blueprint Initial Build Order](app-2-0-blueprint-initial-build-order.md)

These links preserve navigation during cleanup. Their presence does not certify that their content is fully current.

## 5. Existing Phase And Batch Inventory

Existing phase and batch folders are transitional planning inventory pending classification.

- [Phases](phases/index.md)
- [Batches](batches/index.md)

Do not treat these folders as active delivery-state owners.

During cleanup, classify each document as:

- retain as current planning
- normalize and retain
- mark implemented
- supersede
- archive
- delete

GitHub Projects now own active workflow state.

## 6. Planning Organization

Planning should move toward stable ownership-based groupings:

- overview and control
- architecture boundaries
- Core Capabilities
- Platform Surfaces
- Business Modules
- Shared UI
- migration and legacy transition

Do not create empty folders solely to match a target tree.

Add a subfolder when it has:

- a stable owner
- multiple related documents
- a clear index
- an active maintenance reason

## 7. Planning Completion

Planning is complete for a scope when:

- current and target states are clear
- scope and non-goals are explicit
- ownership is identified
- dependencies are classified
- durable decisions are accepted or explicitly blocking
- implementation slices are bounded
- verification and review requirements are defined
- canonical promotion targets are identified
- related issues exist when implementation is ready
- lifecycle status is accurate

## 8. Related

- [Start Here](../00-start-here.md)
- [Decisions Index](../01-decisions/index.md)
- [Architecture Index](../03-architecture/index.md)
- [Features Index](../04-features/index.md)
- [Flows Index](../05-flows/index.md)
- [Database Index](../06-database/index.md)
- [Runbook Index](../10-runbooks/index.md)
- [Documentation Standards Index](../02-standards/documentation/index.md)
