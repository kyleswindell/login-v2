<!--
DOC-META
title: Obsidian Vault Structure Guide
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Obsidian Vault Structure Guide.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines Markdown-first vault structure, folder placement, naming, parent/index relationships, navigation, and Obsidian graph rules.
-->

# Obsidian Vault Structure Guide

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Authority](#2-authority)
- [3. Core Rule](#3-core-rule)
- [4. Portability](#4-portability)
- [5. Canonical Branches](#5-canonical-branches)
- [6. Folder Rules](#6-folder-rules)
- [7. Parent And Child Structure](#7-parent-and-child-structure)
- [8. Index Rules](#8-index-rules)
- [9. Naming](#9-naming)
- [10. Link Rules](#10-link-rules)
  - [10.1. Upward](#101-upward)
  - [10.2. Downward](#102-downward)
  - [10.3. Lateral](#103-lateral)
  - [10.4. Planning And Canonical](#104-planning-and-canonical)
- [11. Metadata And Graph Consistency](#11-metadata-and-graph-consistency)
- [12. Orphan Prevention](#12-orphan-prevention)
- [13. Hub Preservation](#13-hub-preservation)
- [14. Split Rules](#14-split-rules)
- [15. Planning Structure](#15-planning-structure)
- [16. Reference And Template Structure](#16-reference-and-template-structure)
- [17. Agent Working Documentation Structure](#17-agent-working-documentation-structure)
- [18. Archive Rules](#18-archive-rules)
- [19. Review Checklist](#19-review-checklist)
- [20. Related](#20-related)

## 1. Purpose

Define the repository documentation vault structure so it remains usable in:

- GitHub
- IDE previews
- Obsidian
- search
- Codex and other coding-agent retrieval

Obsidian graph support is useful, but portable Markdown remains the primary contract.

## 2. Authority

This guide governs:

- folder placement
- filenames
- parent and child organization
- index placement
- navigation graph
- link portability
- orphan prevention
- hub preservation during reorganization

Use related standards for:

- writing quality and metadata: [How To Write Docs](How%20To%20Write%20Docs.md)
- document types: [Document Type Standards](Document%20Type%20Standards.md)
- branch ownership: [Doc Governance](Doc%20Governance.md)
- review: [Documentation Review Standards](Documentation%20Review%20Standards.md)

## 3. Core Rule

The documentation hierarchy must be explicit through indexes and links.

Folder placement alone does not create a usable documentation graph.

Every important document must be reachable from:

- [Start Here](../../00-start-here.md)

## 4. Portability

Use Markdown links for important navigation.

Use Obsidian links only as optional graph aids.

Do not require Obsidian syntax to:

- find a canonical owner
- navigate to a parent
- discover child documents
- follow a dependency
- locate a replacement

## 5. Canonical Branches

| Path                    | Owns                                  |
| ----------------------- | ------------------------------------- |
| `docs/00-start-here.md` | Vault entry point                     |
| `docs/01-decisions/`    | ADRs and elevated decisions           |
| `docs/02-standards/`    | Enforceable standards                 |
| `docs/03-architecture/` | Structure and boundaries              |
| `docs/04-features/`     | Canonical behavior                    |
| `docs/05-flows/`        | System execution paths                |
| `docs/06-database/`     | Schema and data contracts             |
| `docs/07-planning/`     | Planning and sequencing               |
| `docs/09-reference/`    | Non-canonical support and templates   |
| `docs/10-runbooks/`     | Operator-executable procedures        |
| `docs/11-ai/`           | Non-canonical agent working documents |

Use [Doc Governance](Doc%20Governance.md) for full ownership rules.

## 6. Folder Rules

Use folders for stable ownership and grouping.

Rules:

- every major branch has an `index.md`
- major subfolders have an index when they contain multiple related children
- root-level branch files are limited to branch navigation and control documents
- stable subfolder owners should contain their detailed documents
- archive folders must be clearly separated from active navigation
- generated output must not be mixed into active documentation
- working documents must not be placed in canonical branches merely for visibility

Do not create unnecessary folder depth.

Create a subfolder when it has:

- a stable owner
- multiple related documents
- a clear index
- a recurring maintenance reason

## 7. Parent And Child Structure

Use this pattern:

    docs/00-start-here.md
      → branch index
        → subfolder index
          → detail document

Every detailed document should include:

- `DOC-META.parent`
- a visible upward link
- lateral links to direct dependencies
- links to canonical owners rather than copied content

Every index should link downward to active children.

## 8. Index Rules

An index must:

- use `doc_type: index`
- state folder purpose
- state scope
- list active children
- identify related indexes
- identify deprecated or historical areas when needed
- remain concise

Use a table for larger sections:

| Document | Purpose             | Status |
| -------- | ------------------- | ------ |
| Example  | What the child owns | active |

Do not turn an index into a mixed standards, planning, history, and backlog document.

## 9. Naming

For new or materially reorganized documents:

- prefer lowercase kebab-case filenames
- use names that describe the owned concept
- use `index.md` for folder hubs
- reserve an underscore prefix for templates and special base files
- avoid duplicate or near-duplicate names
- avoid vague names such as `notes.md`, `misc.md`, `new-plan.md`, or `updates.md`

Existing filenames with spaces do not need renaming unless the file is already being moved or normalized as part of approved cleanup.

Stable path value may outweigh cosmetic naming consistency.

## 10. Link Rules

### 10.1. Upward

Every detailed document links to its parent index.

### 10.2. Downward

Every index links to its children.

### 10.3. Lateral

Direct dependencies link to each other when the relationship helps implementation or review.

Examples:

- feature to architecture
- feature to database
- planning to canonical owners
- runbook to governing standards
- standard to template
- decision to affected owners

### 10.4. Planning And Canonical

Active planning links to affected canonical owners.

Canonical owners may link back to active planning while that context remains useful.

When planning is complete, update status and remove stale active-planning routing.

## 11. Metadata And Graph Consistency

The `parent` metadata must agree with the visible parent link.

The `canonical_path` must match the actual path.

The document title should match metadata.

A move or rename requires review of:

- parent metadata
- parent links
- index entries
- lateral links
- template references
- agent routing
- GitHub issue references when practical

## 12. Orphan Prevention

Before adding a document:

1. identify its branch
2. identify its type
3. identify its parent
4. add it to the parent index
5. add an upward link
6. add direct dependency links
7. use the correct template

Before moving or deleting:

1. inspect inbound links
2. decide whether a compatibility hub is needed
3. update affected indexes
4. update strong dependencies
5. verify no active orphan remains

## 13. Hub Preservation

Preserve an old path as a concise hub when:

- many active documents link to it
- an external issue or workflow relies on it
- the original file was intentionally a routing document
- immediate broad link replacement would be unsafe

A preserved hub must:

- state that content moved
- link to the replacement
- avoid duplicating the replacement
- have accurate lifecycle status
- be removed later when no longer useful

Do not preserve obsolete compatibility files without a real inbound-link need.

## 14. Split Rules

Split a document when:

- it has multiple independently changing owners
- it mixes several document types
- users repeatedly need only one section
- it exceeds roughly 2,000 words or 300–400 lines and contains multiple responsibilities
- targeted retrieval is unreliable
- updates create recurring merge conflicts

Do not split a focused document solely because it is long.

When splitting:

- create coherent children
- update or create an index
- update metadata
- preserve a hub where useful
- remove duplicated explanations
- update lifecycle status

## 15. Planning Structure

Keep planning organized by stable ownership rather than a flat collection of documents.

Root planning should normally contain:

- `index.md`
- roadmap or sequencing controls
- dependency maps
- top-level matrices
- branch `AGENTS.md`

Detailed capability, platform, module, migration, and security planning should live in ownership-based subfolders.

## 16. Reference And Template Structure

`docs/09-reference/` owns non-canonical support.

Templates live under:

- `docs/09-reference/templates/docs/`
- `docs/09-reference/templates/agents/`

Template files should:

- retain predictable names
- remain non-canonical
- be indexed
- link to governing standards
- avoid embedding project status

## 17. Agent Working Documentation Structure

`docs/11-ai/` owns non-canonical agent working documents.

Its active structure should distinguish:

- drafts
- reviews
- research
- handoffs or promotion candidates
- archives

It must not mix active standards into the working-document workspace.

Coding-agent standards belong under:

- `docs/02-standards/coding-agents/`

## 18. Archive Rules

Archived documents:

- are historical
- are not active authorities
- should not appear in active navigation except through a clearly labeled archive link
- must not be preferred by agent routing
- should retain enough metadata or surrounding context to explain their historical role

Do not archive secrets or sensitive evidence into the documentation vault.

## 19. Review Checklist

Verify:

- the branch is correct
- the type is correct
- the parent is correct
- metadata and visible links agree
- the document is reachable from Start Here
- indexes are current
- no orphan was introduced
- no duplicate owner was introduced
- filename is stable and descriptive
- split or hub decisions are justified
- reference and working material remain non-canonical
- archived material is excluded from active routing

## 20. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Documentation Templates](../../09-reference/templates/docs/_index.md)
- [Start Here](../../00-start-here.md)
