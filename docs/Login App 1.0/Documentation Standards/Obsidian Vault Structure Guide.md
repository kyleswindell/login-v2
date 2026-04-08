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
- Every note should be reachable from `[[00 - Start Here]]`.
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

The current vault uses a two-layer split:

- base documentation-system material stays at the vault root
- V1 application/codebase documentation lives under `V1 App/`

The base/root layer includes:

- `Documentation Standards/`
- `Standards/`
- `Codex/`
- `Decisions/`
- `00 - Start Here.md`

The V1 application layer includes:

- `V1 App/Architecture/`
- `V1 App/Features/`
- `V1 App/Modules/`
- `V1 App/Reference/`
- `V1 App/Folder Reference/`
- `V1 App/Runbooks/`
- `V1 App/Releases/`
- `V1 App/Folder Reference/Application Tree Map.md`
- `V1 App/Folder Reference/* Folder.md`
- `V1 App/Folder Reference/* File.md`
- `V1 App/V1 App Documentation Map.md`

Folders are for storage and broad grouping. The real hierarchy must be expressed in links between notes.

## Parent And Child Node Rules

Use this pattern consistently:

- top-level entry note
- section index note
- concept/detail note

Examples in this vault:

- `[[00 - Start Here]]` is the vault entry point
- `[[V1 App/Features/Feature Index]]` is the parent for feature notes
- `[[V1 App/Modules/Module Index]]` is the parent for module notes
- `[[V1 App/Reference Index]]` is the parent for reference notes
- `[[V1 App/Folder Reference/Folder Reference Index]]` is the parent for file/folder reference notes

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

- V1 feature behavior belongs in `V1 App/Features/`
- V1 module behavior belongs in `V1 App/Modules/`
- V1 file/folder/config/table references belong in `V1 App/Reference/` or `V1 App/Folder Reference/`
- V1 app rationale belongs in `V1 App/Architecture/`
- V1 operating steps belong in `V1 App/Runbooks/`
- reusable standards and guidance belong in `Standards/`, `Documentation Standards/`, `Codex/`, or `Decisions/`
- rules and conventions belong in `Standards/` or `Documentation Standards/`

If a note needs to mention a concept owned elsewhere:

- summarize briefly
- link to the canonical note
- do not restate the full concept unless that restatement is necessary and clearly scoped

## Structure Review Checklist

Before adding or moving a note, check:

- does this concept already have a canonical note?
- which index note owns it?
- will it be reachable from `[[00 - Start Here]]`?
- does it link upward, downward where needed, and laterally where helpful?
- does it create duplication with an existing note?

## Related

- [[Documentation Standards/How To Write Docs]] | [How To Write Docs](How%20To%20Write%20Docs.md)
- [[Documentation Standards/Documentation Template]] | [Documentation Template](Documentation%20Template.md)
- [[00 - Start Here]] | [00 - Start Here](../00%20-%20Start%20Here.md)
