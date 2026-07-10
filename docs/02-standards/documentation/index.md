<!--
DOC-META
title: Documentation Standards Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Indexes standards for documentation authoring, document types, planning, decisions, runbooks, governance, structure, review, and implementation synchronization.
-->

# Documentation Standards Index

Parent: [Standards Index](../index.md)

This folder contains the canonical standards governing documentation quality, document types, ownership, structure, planning, decisions, runbooks, review, and implementation-status synchronization.

Copyable templates live under:

- [Documentation Templates](../../09-reference/templates/docs/_index.md)

## 1. Purpose

Use this folder to determine:

- where a document belongs
- which controlled `doc_type` applies
- whether a document is canonical
- what metadata and lifecycle status it requires
- how planning documents relate to GitHub issues and Projects
- when a durable decision requires a decision record
- what qualifies as an operational runbook
- how parent, child, and related links are maintained
- when documentation is promoted, split, superseded, archived, or deleted
- how documentation stays synchronized with implementation
- how documentation changes are reviewed

## 2. Folder Scope

This folder owns documentation-system standards.

It may contain:

- universal authoring rules
- controlled document-type contracts
- planning-document standards
- decision-record standards
- runbook-document standards
- branch and canonical-ownership rules
- vault structure and navigation rules
- documentation review standards
- implementation-status synchronization rules

It must not contain:

- copyable templates
- project planning documents
- decision records
- executable runbooks
- architecture or feature truth
- database contracts
- source research
- agent working-document drafts
- executable agent skills
- current delivery state

## 3. Active Standards

| Document | Purpose |
| --- | --- |
| [How To Write Docs](How%20To%20Write%20Docs.md) | Defines universal writing quality, metadata, lifecycle, author workflow, linking, scope, and documentation-with-code expectations. |
| [Document Type Standards](Document%20Type%20Standards.md) | Defines the controlled `doc_type` registry and baseline contract for each type. |
| [Planning Documentation Standards](Planning%20Documentation%20Standards.md) | Defines planning ownership, current/target state, lifecycle, issue and Project boundaries, implementation slices, variance, promotion, and close-out. |
| [Decision Record Standards](Decision%20Record%20Standards.md) | Defines decision elevation, numbering, status, acceptance, amendment, rejection, deprecation, supersession, and canonical synchronization. |
| [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md) | Defines runbook qualification, safety, procedure, verification, recovery, evidence, exercise, and maintenance requirements. |
| [Doc Governance](Doc%20Governance.md) | Defines branch ownership, canonical classification, promotion, link, index, template, and lifecycle guardrails. |
| [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md) | Defines folder placement, naming, parent/index structure, graph navigation, and Markdown-first portability. |
| [Documentation Review Standards](Documentation%20Review%20Standards.md) | Defines review outcomes, ownership, type, metadata, links, synchronization, and completion checks. |
| [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md) | Defines synchronization among GitHub issues, Projects, planning, implementation, canonical docs, and operational procedures. |

## 4. Responsibility Routing

| Question | Canonical Owner |
| --- | --- |
| How should all documents be written and identified? | [How To Write Docs](How%20To%20Write%20Docs.md) |
| What does each `doc_type` mean? | [Document Type Standards](Document%20Type%20Standards.md) |
| How should planning be written and maintained? | [Planning Documentation Standards](Planning%20Documentation%20Standards.md) |
| When is an ADR required and how is it maintained? | [Decision Record Standards](Decision%20Record%20Standards.md) |
| What makes a valid runbook? | [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md) |
| Which branch owns the content? | [Doc Governance](Doc%20Governance.md) |
| Where should the file live and how should it link? | [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md) |
| How should a documentation change be reviewed? | [Documentation Review Standards](Documentation%20Review%20Standards.md) |
| How do planning, implementation, and canonical docs remain aligned? | [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md) |
| What copyable shape should be used? | [Documentation Templates](../../09-reference/templates/docs/_index.md) |

## 5. Templates

Templates define reusable document shape.

Standards define when a template is valid and what completion requires.

Relevant templates include:

- [Planning Template](../../09-reference/templates/docs/_planning.md)
- [Decision Template](../../09-reference/templates/docs/_decision.md)
- [Runbook Template](../../09-reference/templates/docs/_runbook.md)
- [Documentation Templates Index](../../09-reference/templates/docs/_index.md)

The decision template replaces the legacy ADR template formerly stored under `docs/02-standards/documentation/Templates/`.

## 6. Reading Order

For general documentation work:

1. [How To Write Docs](How%20To%20Write%20Docs.md)
2. [Document Type Standards](Document%20Type%20Standards.md)
3. [Doc Governance](Doc%20Governance.md)
4. [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
5. [Documentation Review Standards](Documentation%20Review%20Standards.md)

For planning, also read:

- [Planning Documentation Standards](Planning%20Documentation%20Standards.md)

For decisions, also read:

- [Decision Record Standards](Decision%20Record%20Standards.md)

For runbooks, also read:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

For implementation synchronization, also read:

- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)

## 7. Branch Ownership

| Branch | Owns |
| --- | --- |
| `docs/01-decisions/` | ADRs and elevated decision records |
| `docs/02-standards/` | Enforceable rules, conventions, and requirements |
| `docs/03-architecture/` | System structure, boundaries, and ownership models |
| `docs/04-features/` | Canonical behavior and contracts |
| `docs/05-flows/` | System execution paths |
| `docs/06-database/` | Schema, tables, constraints, and data contracts |
| `docs/07-planning/` | Accepted planning intent, sequencing, decomposition, and planning matrices |
| `docs/09-reference/` | Non-canonical references, research, examples, and templates |
| `docs/10-runbooks/` | Repeatable operator-executable procedures |
| `docs/11-ai/` | Non-canonical agent-authored drafts, reviews, research, and promotion candidates |

GitHub issues own bounded work packets.

GitHub Projects own active delivery state.

Root and scoped `AGENTS.md` files own persistent agent rules.

`.agents/skills/` owns repeatable agent procedures.

## 8. Maintenance

When adding or changing a documentation standard:

- update this index
- update `docs/02-standards/index.md` when appropriate
- add or update `DOC-META`
- update the affected template when reusable shape changes
- update affected branch indexes and `AGENTS.md`
- remove or supersede competing authorities
- update inbound links when paths change
- run documentation guardrails when available

## 9. Related

- [Standards Index](../index.md)
- [Planning Index](../../07-planning/index.md)
- [Decisions Index](../../01-decisions/index.md)
- [Runbook Index](../../10-runbooks/index.md)
- [Coding Agent Standards](../coding-agents/index.md)
- [Reference Index](../../09-reference/index.md)
- [Start Here](../../00-start-here.md)
