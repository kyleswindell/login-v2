<!--
DOC-META
title: Decisions Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/01-decisions/index.md
parent: docs/00-start-here.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes proposed, accepted, deprecated, superseded, and rejected elevated decision records and reserves repository-wide ADR identifiers.
-->

# Decisions Index

Parent: [Start Here](../00-start-here.md)

## 1. Purpose

This branch owns elevated decision records that need:

- durable rationale
- explicit proposal and acceptance status
- stable identifiers
- consequences
- affected-owner links
- deprecation or supersession history

Decision records explain why.

Canonical standards, architecture, features, flows, database documents, and runbooks explain what is true now.

## 2. Scope

Use this branch for decisions that are materially:

- cross-cutting
- long-lived
- difficult to reverse
- superseding
- security, privacy, or data-governance significant
- operationally significant
- important enough to require explicit acceptance history

Do not use this branch for:

- normal local implementation choices
- current implementation details
- planning sequence
- issue acceptance criteria
- operator procedures
- research notes
- active delivery status

## 3. Governing Standard And Template

- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../02-standards/documentation/Document%20Type%20Standards.md)
- [Decision Template](../09-reference/templates/docs/_decision.md)

The decision template replaces the legacy ADR template formerly stored under `docs/02-standards/documentation/Templates/`.

## 4. Identifier Registry

Use repository-wide four-digit identifiers.

Historical archived records already reserve:

| Identifier | Historical Record                                 |
| ---------- | ------------------------------------------------- |
| `ADR-0001` | Documentation System                              |
| `ADR-0002` | Block Based Website Builder Direction             |
| `ADR-0003` | App 2.0 Platform Foundation                       |
| `ADR-0004` | Shared Core Instance And Panel Boundary Direction |

Next available identifier:

- `ADR-0010`

Before assigning it, search active and archived decision paths again to confirm no newer record exists.

Never reuse or renumber a decision identifier.

## 5. Proposed Decisions

No active proposed decision records are currently published.

Add proposed records here while they await authorized review.

## 6. Accepted Decisions

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](adr-0005-core-modules-ui-ownership-taxonomy.md) — Establishes Core, Modules, and UI as the three canonical source-of-truth ownership areas.
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md) — Establishes Tenant and Instance isolation, User Account and identity vocabulary, Principal and assurance identity, Actor attribution, and Invocation Channel vocabulary. Its User Identity record model is partially superseded by ADR-0009; its original Workspace cardinality and Global Administration classification are partially superseded by ADR-0008.
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](adr-0007-owner-registry-and-identifier-key-conventions.md) — Establishes canonical key grammar, ownership fields, key-family formats, collision rules, and compatibility aliases. Its `identity` owner-key provision for human User Accounts is partially superseded by ADR-0009.
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](adr-0008-workspace-navigation-and-frame-surface-model.md) — Establishes multiple available Workspaces, exactly one active Workspace, the persistent Frame, narrow Frame Surfaces, A–E+ navigation, and Global Administration as a Workspace.
- [ADR-0009: Core Users Ownership And Permanent Human Account Model](adr-0009-core-users-ownership-and-permanent-human-account-model.md) — Establishes Core Users as the human-account owner, defines User Identity as a conceptual attribute subset, makes User Accounts permanently retained, and partially supersedes ADR-0006 and ADR-0007 for prior broad Identity ownership.

Historical archived records must be reviewed before any are promoted back into the active branch.

## 7. Deprecated Decisions

No active deprecated decision records are currently published.

## 8. Superseded Decisions

No active decision is superseded in full.

ADR-0008 partially supersedes only the Workspace-cardinality and Global Administration provisions identified in ADR-0006. ADR-0006 otherwise remains accepted.

## 9. Rejected Decisions

No retained rejected decision records are currently published.

Retain rejected records only when their rationale prevents repeated reconsideration or clarifies the accepted direction.

## 10. Decision Workflow

1. Confirm the elevation gate.
2. Reserve the next unused identifier.
3. Create the record as Proposed.
4. Link the owning issue, planning document, and affected canonical owners.
5. Obtain required human and specialist review.
6. Record acceptance or rejection authority.
7. Update canonical current-state documents.
8. Update planning and implementation issues.
9. Update this index.
10. Maintain deprecation and supersession links over time.

Agents may draft Proposed records.

Agents must not mark a record Accepted without explicit authorized approval.

## 11. Historical Decision Review

Archived pre-migration decisions are historical and not automatically active.

Before promoting one:

- review its current relevance
- review terminology
- verify the decision still applies
- update affected canonical owners
- preserve its identifier
- record whether it remains accepted, is deprecated, or is superseded

Do not copy an archived decision into the active branch without lifecycle review.

## 12. Related

- [Start Here](../00-start-here.md)
- [Planning Index](../07-planning/index.md)
- [Architecture Index](../03-architecture/index.md)
- [Documentation Standards Index](../02-standards/documentation/index.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
