<!--
DOC-META
title: M0 Repository Convergence Planning
doc_type: planning
status: implemented
owner: architecture
canonical: true
canonical_path: docs/07-planning/00-overview/m0-repository-convergence-planning.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted M0 repository-convergence milestone, final scope variances, completed issue dispositions, and the post-M0 implementation-readiness contract.
-->

# M0 Repository Convergence Planning

Parent: [Planning Index](../index.md)

## 1. Purpose

Record the accepted M0 repository-convergence result and the authority that M1 implementation work inherits.

M0 established the repository-wide decisions needed for bounded implementation work without requiring M1 issues to rediscover ownership, topology, naming, public Contract boundaries, persistent-data architecture, verification policy, or agent execution rules.

This document is now a completed milestone record. GitHub Issues and GitHub Projects remain the authority for current delivery state and M1 sequencing.

## 2. Final Status

- Planning lifecycle: implemented
- Acceptance state: accepted and complete
- GitHub Project: Login 2.0 Core Build Plan
- GitHub milestone: M0 Planning Consolidation
- M0 parent-goal issues: #17 through #26
- Final M0 acceptance authority: GitHub issue #26
- Accepted pre-M0 baseline commit: `f906e0520e12b5f9eb93b9d35934407c2bbba366`
- Accepted pre-M0 baseline date: 2026-07-10
- Accepted M0 readiness baseline commit: `61a1da391062b99fc5119b119240f9723f51be6c`
- Accepted M0 readiness baseline date: 2026-08-10

All M0 issue work is closed as completed or not planned under accepted scope reductions. Remaining capability-level behavior, schema, exact file-scope, and implementation-sequencing decisions are M1-owned when they were intentionally deferred by M0.

## 3. Accepted Repository-Wide Authority

M0 accepted the following repository-wide direction:

- Core, Modules, and UI are the application source-of-truth ownership areas.
- `app/Platform` is transitional placement, not a fourth application owner.
- Core capabilities are explicit owner branches under `app/Core/<Capability>`.
- Modules are optional package-like owners under `Modules/<Module>`.
- reusable UI is owned by UI responsibility rather than by physical placement alone.
- Laravel integration is a restricted integration boundary, not a competing owner.
- owner-first placement and dependency direction are canonical.
- target repository naming and namespace rules are accepted.
- public Contract, registration, Registry, Contribution, interaction, and runtime boundaries are accepted.
- persistent-data architecture and ownership direction are accepted.
- cross-owner dependencies must use accepted public Contracts.
- capability-specific implementation details remain bounded M1 work rather than repository-wide M0 design.

Canonical structural authority remains in the applicable architecture, standards, database, feature, flow, and decision documents.

## 4. Accepted Verification And Implementation-Readiness Model

Goal 10 accepted the verification-first implementation model used by M1.

The accepted model requires a bounded M1 work packet to define:

- one bounded outcome;
- exact scope and non-goals;
- owner and dependency boundaries;
- allowed and forbidden paths;
- applicable canonical sources;
- stable `AC-*` acceptance criteria;
- `PF-*` proof mapping;
- preimplementation applicability as `REQUIRED`, `CONDITIONAL`, or `NOT_APPLICABLE`;
- exact allowed `EXPECTED_NONPASS` when applicable;
- all unexpected syntax, fixture, dependency, infrastructure, tooling, environment, discovery, or boot failures as `FAIL`;
- protected proof semantics and baseline identity when initial proof is applicable;
- unchanged final targeted proof unless a preauthorized nonsemantic path-only change applies;
- required broader verification, review, documentation synchronization, and stop conditions.

Issue creation alone is not implementation authorization. Project `Ready` requires a complete executable verification contract. Applicable required initial proof and accepted baseline must be established before the first production implementation write.

## 5. Accepted Goal 10 Artifacts

The final Goal 10 scope was intentionally narrow.

Accepted artifacts are:

- canonical verification/readiness rules under `docs/02-standards/testing/` and the Agent Implementation Checklist;
- `.github/ISSUE_TEMPLATE/implementation-slice.yml` as the bounded M1 work-packet form;
- repository `AGENTS.md` and `.agents/skills/` routing to the same verification-first model;
- the final M0 acceptance record in GitHub issue #26.

The accepted Goal 10 result does not require a separate readiness matrix, global test inventory, reconciliation report, handoff document, baseline document, acceptance document, or broad GitHub workflow documentation project.

## 6. Representative Readiness Validation

Goal 10 validated the M1 contract without selecting real implementation order.

Accepted conclusions:

- broad Auth planning is not implementation-ready and must not authorize an agent to invent the first Auth slice;
- a simulation-only behavior-preserving Auth ownership migration can be expressed as a bounded M1 packet with explicit owner, scope, non-goals, paths, `AC-*` to `PF-*` mapping, proof applicability, protected-baseline planning, final proof, review, and stop conditions;
- the representative fixture does not establish M1 priority, sequencing, or implementation authorization;
- the GitHub-native M1 issue form renders the accepted verification lifecycle correctly.

## 7. Final Disposition Of Legacy Issues #1 Through #13

| Issue | Final disposition | Closeout note                                                                                                |
| ----- | ----------------- | ------------------------------------------------------------------------------------------------------------ |
| #1    | Completed         | Core, Modules, and UI ownership taxonomy accepted through ADR-0005 and canonical planning.                   |
| #2    | Completed         | DataGovernance ownership and matrix coverage are represented in current planning.                            |
| #3    | Completed         | View Surface and Renderer planning is reconciled to owner-first Core/Module/UI ownership.                    |
| #4    | Not planned       | Superseded by the narrower accepted Goal 10 readiness model and M1 issue form.                               |
| #5    | Not planned       | Exact future admin URL canonicalization is an implementation/migration decision, not an M0 prerequisite.     |
| #6    | Completed         | Initial Audit foundation is compatibility-first on `platform_audit_logs`; successor schema remains M1-owned. |
| #7    | Not planned       | Exact Service Account/NHI storage design is deferred to bounded M1 capability/schema planning.               |
| #8    | Completed         | Root agent guidance is reconciled to the accepted issue/Project model.                                       |
| #9    | Completed         | Coding and file-building standards are reconciled to accepted ownership and verification direction.          |
| #10   | Completed         | File archetype standard accepted.                                                                            |
| #11   | Completed         | Agent Implementation Checklist accepted.                                                                     |
| #12   | Completed         | Required folder-level `AGENTS.md` routing exists and is reconciled.                                          |
| #13   | Completed         | `login2-file-implementation` skill accepted and reconciled with the implementation workflow.                 |

## 8. Accepted Scope Variance

The original M0 charter proposed several broader artifacts and workstreams. Later accepted parent-goal decisions intentionally narrowed M0.

The following are not M0 blockers:

- a standalone UI-readiness program or manual pattern queue;
- a standalone migration, compatibility, deprecation, rollback, or cleanup planning program;
- a global test-suite inventory or global green-gate definition that bypasses issue-level verification contracts;
- a separate GitHub Project workflow document;
- a separate readiness matrix, handoff document, baseline document, or acceptance document;
- exact capability-level schemas and file scopes not needed to accept repository-wide architecture.

These reductions were accepted through the applicable parent-goal dispositions and final Goal 10 acceptance.

## 9. Explicitly Deferred M1 Decisions

The following do not reopen M0 and are resolved only when a bounded M1 issue requires them:

- actual M1 capability implementation order;
- exact first production slice for any capability;
- exact feature and cross-capability behavior contracts not yet required by an implementation slice;
- exact table, field, relationship, index, retention, migration, and backfill contracts intentionally deferred to M1;
- exact Service Account/NHI storage design;
- eventual Audit successor schema beyond the accepted compatibility-first foundation;
- renderer-driven versus normal ViewModel/PageData-driven implementation choices for specific surfaces;
- future route canonicalization where current compatibility remains acceptable;
- optional UI contract export or local review tooling without a concrete implementation need.

## 10. Completion And Exit Criteria

M0 is accepted and complete because:

- [x] canonical vocabulary and application ownership are accepted;
- [x] target repository topology and naming are accepted;
- [x] public Contract and interaction architecture is accepted;
- [x] persistent-data architecture and ownership direction are accepted;
- [x] reusable UI authority and manual-review limits are explicit;
- [x] durable repository-wide requirements are promoted to canonical owners;
- [x] transitional `Platform` ownership is rejected as a target owner;
- [x] verification-first readiness requirements are concise and canonical;
- [x] the M1 issue template produces bounded executable work packets;
- [x] protected tests, fixtures, Contracts, procedures, and evidence cannot be silently weakened;
- [x] all ten M0 parent goals completed acceptance review or were explicitly closed as not planned under accepted scope reduction;
- [x] all residual M0 issues are closed with completed or not-planned dispositions;
- [x] remaining implementation-level decisions are explicit and M1-owned;
- [x] the accepted M0 readiness baseline is versioned and recorded.

## 11. Post-M0 Readiness Contract

A bounded M1 implementation issue must identify, as applicable:

- accepted target behavior;
- primary ownership area and specific owner;
- target paths and namespaces;
- governing canonical Contracts and standards;
- affected database objects;
- dependencies and cross-owner boundaries;
- migration and compatibility requirements;
- stable acceptance criteria;
- verification-first proof mapping and preimplementation applicability;
- protected proof and baseline semantics when applicable;
- required final targeted proof and broader validation;
- security, data, transaction, reliability, UI, accessibility, browser, and specialist review requirements;
- documentation synchronization;
- explicit non-goals;
- stop conditions and integration/closure authority.

M1 must not reopen accepted M0 repository-wide architecture through ordinary implementation issues.

A material exception discovered after M0 must be handled through the appropriate accepted authority:

- a decision record when architecture or durable policy changes;
- a planning variance when sequence or migration direction changes;
- a standards update when durable policy changes;
- a bounded implementation issue when the accepted target remains unchanged.

## 12. Related

- [Planning Index](../index.md)
- [Core Service Build Plan Matrix](../core-service-build-plan-matrix.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Testing Standards](../../02-standards/testing/index.md)
- [Agent Implementation Checklist](../../02-standards/coding/Agent%20Implementation%20Checklist.md)
- GitHub issue #26 — final M0 implementation-readiness acceptance
