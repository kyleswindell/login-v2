<!--
DOC-META
title: How To Write Docs
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/How To Write Docs.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines universal documentation writing quality, metadata, lifecycle, author workflow, linking, scope, and synchronization expectations.
-->

# How To Write Docs

Parent: [Documentation Standards Index](index.md)

Use this standard before creating, materially rewriting, splitting, moving, or retiring repository documentation.

- [1. Authority And Scope](#1-authority-and-scope)
- [2. Core Rule](#2-core-rule)
- [3. Author Workflow](#3-author-workflow)
- [4. Required `DOC-META`](#4-required-doc-meta)
- [5. Controlled Lifecycle Status](#5-controlled-lifecycle-status)
- [6. Controlled Owners](#6-controlled-owners)
- [7. Document Type Versus Writing Mode](#7-document-type-versus-writing-mode)
- [8. Documentation Principles](#8-documentation-principles)
- [9. Templates](#9-templates)
- [10. Portable Links](#10-portable-links)
- [11. Current Vocabulary](#11-current-vocabulary)
- [12. Docs Travel With Code](#12-docs-travel-with-code)
- [13. File Scope And Split Rules](#13-file-scope-and-split-rules)
- [14. Writing Expectations By Authority](#14-writing-expectations-by-authority)
  - [Canonical Documents](#canonical-documents)
  - [Planning Documents](#planning-documents)
  - [Reference Documents](#reference-documents)
  - [Agent Working Documents](#agent-working-documents)
  - [Runbooks](#runbooks)
- [15. Release Notes And Changelog](#15-release-notes-and-changelog)
- [16. Completion Criteria](#16-completion-criteria)
- [17. Related](#17-related)

## 1. Authority And Scope

This standard applies to documentation under `docs/`.

It governs:

- universal writing quality
- required document metadata
- lifecycle status
- canonical versus non-canonical identification
- author workflow
- portable links
- file scope and split rules
- documentation updates that travel with code

Use related standards for specialized questions:

- document-type contract: [Document Type Standards](Document%20Type%20Standards.md)
- canonical branch ownership: [Doc Governance](Doc%20Governance.md)
- folder and graph structure: [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- runbook requirements: [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- review: [Documentation Review Standards](Documentation%20Review%20Standards.md)
- implementation synchronization: [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)

## 2. Core Rule

Every durable concept must have exactly one canonical owner.

Related documents may summarize the concept briefly, but they must link to the canonical owner instead of duplicating the full explanation.

## 3. Author Workflow

Before writing:

1. identify the concept
2. identify whether the content is canonical, planning, reference, working, or historical
3. select the controlled `doc_type`
4. identify the canonical branch
5. identify the parent index
6. select the template
7. identify related canonical documents
8. confirm whether an existing document already owns the concept

During writing:

1. add a valid `DOC-META` block
2. state purpose and scope early
3. write current truth unless the document type explicitly permits proposed or historical content
4. link to related owners instead of duplicating them
5. keep the document focused on one primary responsibility
6. distinguish confirmed facts from plans, assumptions, and open questions
7. preserve terminology used by current architecture and standards

Before completion:

1. verify metadata
2. verify parent and lateral links
3. update indexes
4. update related planning or canonical docs
5. run documentation guardrails when available
6. review the final diff for unrelated changes

## 4. Required `DOC-META`

Every new or materially rewritten documentation file must start with an HTML comment block before the H1 heading.

Use:

    <!--
    DOC-META
    title: Document Title
    doc_type: standard
    status: active
    owner: docs
    canonical: true
    canonical_path: docs/path/to/file.md
    parent: docs/path/to/index.md
    template: docs/09-reference/templates/docs/_doc.md
    summary: One sentence describing what this document owns.
    -->

Required fields:

| Field            | Requirement                                                                                |
| ---------------- | ------------------------------------------------------------------------------------------ |
| `title`          | Must match the visible document title.                                                     |
| `doc_type`       | Must use a controlled type from [Document Type Standards](Document%20Type%20Standards.md). |
| `status`         | Must reflect the document's current lifecycle.                                             |
| `owner`          | Must identify the smallest accurate ownership area.                                        |
| `canonical`      | Must accurately state whether the file owns durable source-of-truth content.               |
| `canonical_path` | Must match the repository-relative path.                                                   |
| `parent`         | Must point to the correct index or hub.                                                    |
| `template`       | Must identify the template used.                                                           |
| `summary`        | Must describe the document's primary ownership in one sentence.                            |

Metadata does not replace visible navigation links.

## 5. Controlled Lifecycle Status

Use one of:

| Status        | Meaning                                                    |
| ------------- | ---------------------------------------------------------- |
| `draft`       | Proposed, incomplete, or awaiting acceptance.              |
| `active`      | Current accepted document or current working owner.        |
| `planned`     | Accepted planning direction not yet implemented.           |
| `implemented` | Reflected in code or established operational practice.     |
| `superseded`  | Replaced by another document, decision, or implementation. |
| `archived`    | Historical only and not an active authority.               |

A document may be `active` while describing partially implemented behavior. In that case, its implementation-status section must state what exists and what remains incomplete.

## 6. Controlled Owners

Use the smallest accurate owner:

- `docs`
- `architecture`
- `core`
- `platform`
- `module`
- `ui`
- `security`
- `data`
- `ops`
- `ai`

The owner identifies responsibility, not the audience.

## 7. Document Type Versus Writing Mode

`doc_type` identifies the artifact's role and ownership contract.

Writing mode identifies how the content is presented.

Useful modes include:

| Mode        | Purpose                                                    |
| ----------- | ---------------------------------------------------------- |
| Tutorial    | Teaches a learning path from zero to a working result.     |
| How-to      | Gives task-oriented steps for a known goal.                |
| Reference   | Presents exact interfaces, values, commands, or contracts. |
| Explanation | Describes rationale, relationships, or tradeoffs.          |

A document may use more than one mode when its `doc_type` allows it, but it must still have one primary artifact responsibility.

A runbook is not merely any how-to. It must satisfy [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md).

## 8. Documentation Principles

- Write for the next developer or operator.
- Prefer accurate focused documents over long mixed-purpose documents.
- Explain why a rule or boundary exists when that context affects correct use.
- Describe current truth unless the document is explicitly planning, draft, decision, release, working, or historical material.
- Use direct language and stable terminology.
- Keep general rules in `docs/02-standards/`.
- Keep canonical behavior with its feature owner.
- Keep structure with architecture.
- Keep schema and data contracts with database documentation.
- Keep sequencing and open questions in planning.
- Keep operational procedures in runbooks.
- Keep non-canonical support and templates in reference.
- Keep agent working documents in `docs/11-ai/`.
- Prefer links over duplicated explanation.
- Treat documentation as reviewed repository content.

## 9. Templates

Copyable templates live under:

- [Documentation Templates](../../09-reference/templates/docs/_index.md)

Template selection is governed by:

- [Document Type Standards](Document%20Type%20Standards.md)

Templates define reusable shape. They do not define policy.

New canonical Markdown prose filenames and folders use lowercase kebab-case. Reserved filenames retain their exact form: `index.md`, `README.md`, and `AGENTS.md`. Controlled Definition packages retain `Definitions/<Term>/Definition.md`. Existing legacy paths remain compatibility concerns until an authorized migration updates inbound links and canonical paths.

When no dedicated template exists:

- use `_doc.md`
- set the correct controlled `doc_type`
- follow the type contract
- do not invent a template solely for one document

## 10. Portable Links

Use Markdown links for important cross-references.

Required link patterns:

- detailed documents link upward to a parent or index
- indexes link downward to children
- directly dependent documents link laterally
- planning documents link to affected canonical owners
- canonical documents link back to active planning while it remains relevant
- standards link to related templates
- runbooks link to governing standards and related operational procedures

Obsidian links may be used as optional graph aids. They must not be the only path to important content.

## 11. Current Vocabulary

Use current project vocabulary:

- Core capability
- Module
- UI
- Laravel integration
- Surface
- Delivery Adapter
- Registry
- Planning Document
- canonical owner
- implementation slice
- GitHub issue
- GitHub Project

Avoid older terminology when it conflicts with the current model.

## 12. Docs Travel With Code

Update documentation in the same work cycle when a change affects:

- setup, build, tests, deployment, release, cron, queues, services, or recovery
- user, admin, tenant, workspace, or public behavior
- Core capability behavior
- Module behavior
- UI contracts
- Laravel integration
- owner-specific Surface presentation, Delivery Adapter behavior, or Host-owned Registry behavior
- architecture or ownership
- schema or data contracts
- authentication, authorization, audit, security, monitoring, secrets, or data movement
- agent instructions, skills, or documentation governance

Use [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md) for the required synchronization path.

## 13. File Scope And Split Rules

Split a document when it:

- owns multiple independently changing responsibilities
- mixes standards, planning, research, review, and implementation status
- routinely requires only one section during real work
- grows beyond roughly 2,000 words or 300–400 lines and contains multiple ownership areas
- becomes difficult to retrieve or review reliably
- duplicates content owned by focused child documents

When splitting:

- preserve a heavily linked old path as a concise hub when practical
- create or update the parent index
- move coherent ownership slices only
- update metadata and links
- avoid copying the same explanation into every child file
- supersede or archive replaced files accurately

Length alone does not require a split when one focused document genuinely needs the full procedure or contract.

## 14. Writing Expectations By Authority

### Canonical Documents

Canonical documents must:

- describe current accepted truth
- identify current limitations explicitly
- avoid unresolved plans unless clearly separated
- avoid relying on issue comments as durable authority

### Planning Documents

Planning documents may contain:

- target state
- sequencing
- open questions
- implementation slices
- migration or refactor intent
- decisions awaiting promotion

They must not become the final owner of implemented architecture, behavior, schema, standards, or runbooks.

### Reference Documents

Reference documents are non-canonical by default.

They must preserve source or provenance when relevant and must not silently own durable Login 2.0 rules.

### Agent Working Documents

Documents under `docs/11-ai/` are non-canonical working material unless promoted.

They must identify their intended canonical owner and review or closure path.

### Runbooks

Runbooks must contain executable operational steps, verification, failure handling, and completion criteria.

Use [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md).

## 15. Release Notes And Changelog

Release notes summarize rollout context, migration requirements, cautions, and notable impact. They do not replace canonical docs.

Use the release-note template when needed:

- [Release Note Template](../../09-reference/templates/docs/_release-note.md)

Create a separate release-note standard only when release governance becomes complex enough to require one.

## 16. Completion Criteria

A documentation change is complete when:

- the correct canonical owner contains the durable truth
- the controlled `doc_type` is correct
- metadata is valid
- the selected template is appropriate
- the parent index is updated
- important links are portable and current
- related documents are linked rather than duplicated
- planning and implementation status are synchronized
- working or superseded material has a clear disposition
- no unrelated documentation cleanup is included
- required review and guardrails are complete

## 17. Related

- [Documentation Standards Index](index.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Repository Naming Standards](../coding/repository-naming-standards.md)
- [Documentation Templates](../../09-reference/templates/docs/_index.md)
