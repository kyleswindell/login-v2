<!--
DOC-META
title: Phase 5.12 Documentation Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-12-documentation-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records target documentation filename, folder, title, metadata, ADR, Module, index, and compatibility naming rules.
-->

# Phase 5.12 Documentation Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define predictable documentation paths and titles aligned with document authority while preserving current legacy paths until an authorized migration.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Doc Governance, Planning Documentation Standards, and Decision Record Standards

## 3. Naming Matrix

| Artifact                | Pattern                            | Example                                                     |
| ----------------------- | ---------------------------------- | ----------------------------------------------------------- |
| Standard document       | Lowercase kebab-case               | `testing-standards.md`                                      |
| Architecture document   | Lowercase kebab-case               | `repository-architecture.md`                                |
| Planning document       | Lowercase kebab-case               | `target-repository-architecture.md`                         |
| Numbered Phase decision | `<phase>-<decision>-<subject>.md`  | `5-12-documentation-naming.md`                              |
| ADR                     | `adr-<four digits>-<subject>.md`   | `adr-0007-owner-registry-and-identifier-key-conventions.md` |
| Folder index            | Exact `index.md`                   | `phase-5/index.md`                                          |
| Package introduction    | Exact `README.md`                  | `Modules/Projects/README.md`                                |
| Agent guidance          | Exact `AGENTS.md`                  | `Modules/Projects/AGENTS.md`                                |
| Template                | Leading underscore plus kebab-case | `_planning.md`                                              |
| Module document         | Lowercase kebab-case               | `project-imports.md`                                        |

Documentation remains organized by canonical authority rather than filename alone.

## 4. Folder And Reserved Filename Rules

Documentation folders use lowercase kebab-case by default:

```text
milestone-0/
goal-3/
phase-5/
feature-contracts/
active-doc-reviews/
```

The exact reserved filenames retain established repository meanings:

```text
index.md
README.md
AGENTS.md
```

Templates use a leading underscore followed by lowercase kebab-case.

Controlled documentation packages may use a governed technical-name directory and fixed artifact filename where their package contract requires it:

```text
Definitions/
└── Application-Registration/
    └── Definition.md
```

This is a documented exception rather than a competing general convention.

The current `docs/07-planning/Milestones/` root and canonical filenames containing spaces remain compatibility paths. This Phase 5 package follows the existing Goal 3 location but does not make `Milestones` the target general folder convention.

## 5. Titles And Metadata

- Visible H1 titles use human-readable title case.
- `DOC-META.title` exactly matches the visible H1.
- `canonical_path` exactly matches the repository-relative path.
- `parent` identifies the applicable index or hub.
- Filenames do not encode lifecycle labels such as `draft`, `active`, `approved`, or `final`.
- Dates appear in filenames only when the document type or governed artifact requires them.

Example:

```text
Filename: repository-architecture.md
Title:    Repository Architecture
```

## 6. ADR And Index Rules

Elevated decision records use one repository-wide sequence:

```text
adr-0008-decision-title.md
# ADR-0008: Decision Title
```

ADR identifiers:

- use four digits;
- are assigned from the next unused repository-wide number;
- are never reused or renumbered;
- do not encode lifecycle status in the filename.

Every major documentation branch has `index.md`. A subfolder containing multiple related canonical children normally has an index.

Indexes route readers to children without duplicating their durable content. Children link upward to their parent. Adding, moving, superseding, archiving, or deleting a child requires updating the affected index.

## 7. Module Documentation

Module packages use:

```text
Modules/<Module>/README.md
Modules/<Module>/docs/index.md
```

`README.md` introduces the package. `docs/index.md` routes the Module’s detailed documentation. Additional Module documents use lowercase kebab-case filenames and human-readable titles.

## 8. Existing Compatibility Paths

Current canonical paths such as:

```text
How To Write Docs.md
Decision Record Standards.md
```

remain valid until an authorized documentation migration.

New canonical prose documents follow lowercase kebab-case immediately where the governing parent path permits it. Phase 5 does not authorize opportunistic mass renaming or duplicate replacement documents.

## 9. Accepted Decision

> Canonical Markdown prose filenames use lowercase kebab-case. Filenames should describe the document’s owned subject without redundant lifecycle labels, dates, audience names, or generic terms such as `notes`, `misc`, `document`, or `final`.
>
> The exact reserved filenames `index.md`, `README.md`, and `AGENTS.md` retain their established repository meanings. Documentation templates use a leading underscore followed by lowercase kebab-case.
>
> Documentation folders use lowercase kebab-case by default. Controlled documentation package structures may use an explicitly governed technical-name folder and fixed artifact filename where the package contract requires it, including the accepted `Definitions/<Term>/Definition.md` structure. Such exceptions must be documented and must not create competing general conventions.
>
> Visible document titles use human-readable title case. `DOC-META.title` must exactly match the visible H1. `canonical_path` must exactly match the repository-relative path, and `parent` must identify the applicable index or hub.
>
> Planning hierarchy folders use numbered lowercase forms such as `milestone-0`, `goal-3`, and `phase-5`. Numbered Phase decision documents use `<phase>-<decision>-<subject>.md`.
>
> Elevated decision records use the repository-wide `ADR-0001` sequence, filename pattern `adr-0001-decision-title.md`, and H1 pattern `ADR-0001: Decision Title`. ADR identifiers are never reused or renumbered.
>
> Every major documentation branch has an `index.md`. Subfolders containing multiple related canonical children normally have an index. Indexes route readers to children without duplicating their durable content; children link upward to their parent.
>
> Module packages use `README.md` for package introduction and `docs/index.md` for Module documentation navigation. Additional Module documentation uses lowercase kebab-case filenames and human-readable titles.
>
> Current canonical paths that use spaces or older conventions may remain as compatibility paths until an authorized migration. New documents follow the accepted target convention immediately. Phase 5 does not authorize repository-wide documentation renaming.

## 10. Boundaries And Handoff

- Document authority, metadata, lifecycle, templates, and promotion remain governed by canonical documentation standards.
- The existing Goal 3 path is not renamed by this package.
- A documentation path migration must update inbound links, indexes, metadata, compatibility hubs, and applicable tooling through a separate bounded issue.

## 11. Related

- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Doc Governance](../../../../../02-standards/documentation/Doc%20Governance.md)
- [How To Write Docs](../../../../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Planning Documentation Standards](../../../../../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../../../../../02-standards/documentation/Decision%20Record%20Standards.md)
- [Phase 4 Documentation Placement](../phase-4/4-9-documentation-placement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
