# Obsidian Vault Structure Guide

Use this guide as the mandatory source of truth for vault structure, file naming, folder naming, Obsidian linking, and documentation graph organization.

This note adapts the repo-root guide at `Obsidian Docs Structure Guide.md` into the vault so the rule set lives inside the Obsidian graph as well as the repository root.

## Purpose

Treat the documentation vault as a controlled documentation system, not as a loose collection of notes.

The vault must support:

- AI-assisted development
- human readability and maintainability
- strong graph navigation through links
- clear single sources of truth

## Core Rule

Every concept must exist in exactly one place, and everything else links to it.

That means:

- do not create duplicate notes for the same concept
- do not split one concept across several competing notes
- decide which note is the canonical home for that concept
- add links from related notes instead of re-documenting the same concept

## Precedence

This guide is the primary and only instruction set for:

- file naming
- folder naming
- vault structure
- parent/child note organization
- Obsidian note linking and graph design

Other documentation standards still apply for:

- note content quality
- Diataxis/document type choices
- standard sections inside notes
- release note and ADR usage

## Vault Design Principles

- Build parent nodes intentionally. Folder placement alone does not create hierarchy in Obsidian.
- Every note should be reachable from [00-start-here](../../00-start-here.md).
- Every detailed note should link upward to a parent/index note.
- Parent/index notes must link downward to their children.
- Related notes should link laterally where dependencies or close relationships exist.
- Avoid orphan notes and duplicate concept owners.

## Naming Rules

- Use stable, explicit names that describe the concept directly.
- Prefer one canonical note per concept.
- Do not create near-duplicate note names for the same concept.
- Keep index/hub notes obvious, for example `Feature Index`, `Module Index`, `Reference Index`.
- Keep names readable for humans first, but predictable for agents.

## Folder Rules

The current docs structure is organized by canonical branch ownership:

- `00-start-here.md`
- `02-standards/`
- `03-architecture/`
- `04-features/`
- `05-flows/`
- `06-database/`
- `07-planning/`
- `09-reference/`
- `10-runbooks/`

Folders are for storage and broad grouping. The real hierarchy must be expressed in links between notes.

## Parent And Child Node Rules

Use this pattern consistently:

- top-level entry note
- section index note
- concept/detail note

Examples in this vault:

- [00-start-here](../../00-start-here.md) is the vault entry point
- [Features Index](../../04-features/index.md) is the parent for feature notes
- [Architecture Index](../../03-architecture/index.md) is the parent for architecture notes
- [Reference Index](../../09-reference/index.md) is the parent for reference notes
- [Runbook Index](../../10-runbooks/index.md) is the parent for runbook notes

Each child note should include:

- an upward parent/index link
- relevant lateral links
- links to canonical related concepts instead of copied content

## Mandatory Linking Rules

### Upward Links

Each note should link to its parent/index note in `Related` and, when useful, explicitly name its parent in the body.

### Downward Links

Each index note must enumerate and link to its children.

### Lateral Links

When notes depend on each other, link them directly. Examples:

- feature to architecture
- feature to module
- feature to reference/data model
- runbook to feature/reference
- standards to templates and checklists

## Canonical Ownership Rules

Use one canonical owner for each concept type:

- rules and conventions belong in `02-standards/`
- system structure and boundaries belong in `03-architecture/`
- behavior contracts belong in `04-features/`
- execution paths belong in `05-flows/`
- schema/table/contracts belong in `06-database/`
- sequencing and delivery intent belong in `07-planning/`
- supporting research and notes belong in `09-reference/`
- operational procedures belong in `10-runbooks/`

If a note needs to mention a concept owned elsewhere:

- summarize briefly
- link to the canonical note
- do not restate the full concept unless that restatement is necessary and clearly scoped

## Related

- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Documentation Template](Documentation%20Template.md)
- [00-start-here](../../00-start-here.md)
- [Vault Structure Review Checklist](../../09-reference/documentation/Vault%20Structure%20Review%20Checklist.md)
