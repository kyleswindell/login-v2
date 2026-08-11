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
summary: Routes accepted planning intent, completed M0 convergence, target-state decomposition, migration direction, implementation sequencing, and bounded M1 planning without owning active delivery status.
-->

# Planning Index

Parent: [Start Here](../00-start-here.md)

## 1. Purpose

This branch owns accepted planning intent for Login 2.0.

Use it for:

- target-state planning;
- Core capability, Module, UI, and Laravel-integration decomposition;
- dependency and sequence rationale;
- migration and compatibility direction;
- bounded implementation-slice preparation;
- unresolved planning questions;
- planning matrices;
- documentation promotion targets.

Planning must not become a parallel task board or substitute for canonical architecture, behavior, schema, standards, runbooks, GitHub issues, or GitHub Project state.

## 2. Source Roles

| Source | Responsibility |
| --- | --- |
| Planning documents | Accepted planning intent, target state, sequence rationale, decomposition, migration direction, and variance |
| GitHub issues | Bounded work packets, acceptance criteria, dependencies, implementation discussion, and acceptance evidence |
| GitHub Projects | Current delivery status, priority, sequencing, milestone phase, risk, and dependency fields |
| Canonical documents | Current accepted architecture, behavior, schema, standards, feature Contracts, flows, and runbooks |
| Decision records | Durable accepted choices, rationale, alternatives, and supersession history |
| Pull requests and commits | Reviewable implementation evidence and repository history |
| Tests and review artifacts | Automated and manual verification evidence |

## 3. Governing Standards

- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../02-standards/documentation/Document%20Type%20Standards.md)
- [Implementation Status And Development Sync Standard](../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Agent Implementation Checklist](../02-standards/coding/Agent%20Implementation%20Checklist.md)

## 4. Planning Control Documents

### 4.1 Completed M0 Repository Convergence

[M0 Repository Convergence Planning](00-overview/m0-repository-convergence-planning.md) is the implemented milestone record for accepted M0 repository convergence and implementation readiness.

It retains:

- M0 scope and accepted authority;
- final parent-goal and legacy-issue dispositions;
- accepted scope variance;
- explicit M1 deferrals;
- final completion criteria;
- the post-M0 readiness contract inherited by M1.

Final M0 acceptance is recorded in GitHub issue #26. The M0 planning record is historical/authoritative planning context, not an active M1 work queue.

### 4.2 Core Planning Matrix

[Core Service Build Plan Matrix](core-service-build-plan-matrix.md) is the current cross-capability planning/routing index for:

- target ownership snapshots;
- physical folder direction;
- configuration direction;
- data and migration planning;
- testing direction;
- implementation sequence rationale;
- owner keys;
- explicit open decisions.

M0 reconciliation of the matrix is complete. M1 may refine exact capability behavior, schema, and implementation sequencing only through bounded work that preserves accepted repository-wide authority.

### 4.3 Current-State Evidence

The M0 inventory documents remain useful evidence for the accepted pre-M0/current-state baselines. They do not replace current `main`, current canonical documentation, or accepted M1 issue scope.

Relevant evidence includes:

- [M0 Repository Current-State Inventory](00-overview/m0-repository-current-state-inventory.md)
- [M0 UI Current-State Inventory](00-overview/m0-ui-current-state-inventory.md)
- [M0 Persistent Data Current Implementation Snapshot](00-overview/m0-persistent-data-current-state-inventory.md)

### 4.4 Cybersecurity Promotion Backlog

[Cybersecurity Review Backlog Planning](00-overview/cybersecurity-review-backlog-planning.md) routes remaining cybersecurity promotion work into standards, runbooks, architecture, schema, feature Contracts, implementation planning, and deferred future topics.

It does not create security requirements by itself.

## 5. Planning Organization

| Path | Responsibility |
| --- | --- |
| `00-overview/` | milestone records, planning control documents, review backlogs, and cross-cutting planning overviews |
| `01-architecture-boundaries/` | application structure, capability boundaries, context models, vocabulary, and structural migration planning |
| `02-core-capabilities/` | Core capability target state, dependencies, data, security, implementation direction, and capability matrices |
| `03-platform-surfaces/` | transitional planning from the previous Platform Surface model; folder name does not establish target ownership |
| `04-business-modules/` | Module package, layout, Contribution, and owner-specific Surface planning |
| planning root | cross-cutting matrices and control documents whose scope spans multiple planning groups |

Do not create folders or planning documents merely to mirror a proposed target tree.

## 6. Post-M0 Delivery Model

M0 is complete.

New implementation delivery proceeds through bounded M1 issues using `.github/ISSUE_TEMPLATE/implementation-slice.yml` and the repository's accepted verification-first workflow.

Planning may prepare or refine a bounded slice, but GitHub issues own executable work packets and GitHub Projects own current delivery state and sequencing.

Before production implementation, follow:

1. the applicable `AGENTS.md` files;
2. [Agent Implementation Checklist](../02-standards/coding/Agent%20Implementation%20Checklist.md);
3. [Testing Standards](../02-standards/testing/index.md);
4. applicable canonical architecture, feature, flow, database, security, UI, and runbook sources;
5. the accepted M1 issue's exact scope and verification contract.

## 7. Planning Lifecycle And Promotion

Planning documents may use lifecycle states such as:

- `draft`;
- `planned`;
- `active`;
- `implemented`;
- `superseded`;
- `archived`.

Promote durable accepted content to its canonical owner:

| Planning content | Canonical destination |
| --- | --- |
| mandatory durable rule | standard |
| accepted structural boundary | architecture |
| table, field, relationship, or migration Contract | database documentation |
| user-observable behavior | feature or flow |
| operational procedure | runbook |
| durable decision and rationale | decision record |
| bounded execution work | GitHub issue |

## 8. Planning Completion

Planning is complete for a scope when:

- current and target states are clear;
- scope and non-goals are explicit;
- ownership is identified;
- dependencies are classified;
- durable decisions are accepted or explicitly deferred/blocked;
- implementation slices are bounded where execution is ready;
- migration and compatibility direction are defined where material;
- verification and review requirements are defined;
- canonical promotion targets are identified;
- lifecycle status is accurate;
- no implementation work must infer policy from obsolete or contradictory planning.

## 9. Related

- [Start Here](../00-start-here.md)
- [M0 Repository Convergence Planning](00-overview/m0-repository-convergence-planning.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Testing Standards](../02-standards/testing/index.md)
