---
description: "Use when updating V2 planning, feature, reference, or runbook documentation. Ensures canonical-owner sync, implementation-status updates, and index cross-linking."
name: "Docs Planning Sync Rules"
applyTo: "docs/V2 App/Planning/**,docs/V2 App/Features/**,docs/V2 App/Reference/**,docs/V2 App/Runbooks/**"
---
# Docs Planning Sync Rules

## Scope

Apply these rules when editing V2 documentation notes.

## Required Workflow

1. Start from `docs/00 - Start Here.md` and the relevant index note before making edits.
2. Treat planning notes as sequencing and intent owners.
3. Treat feature/reference/runbook notes as implementation/system owners.
4. When behavior changes, update both the canonical system note and linked planning note in the same work cycle.
5. Keep an "Implementation Status" section current in planning notes.
6. Ensure bidirectional links exist between permanent system docs and their source planning notes.
7. Update phase/index notes when adding or renaming planning artifacts.

## Editing Standards

- Preserve Obsidian wiki links plus markdown links where already used.
- Keep names and terminology consistent across Phase, Feature, Reference, and Runbook notes.
- Prefer concise, contract-style bullets over narrative prose.
- Do not create new docs unless the task explicitly requests a new owner note.

## Completion Checklist

- Canonical owner updated when required
- Planning source updated when required
- Phase or planning index updated when required
- Implementation status lines updated
- Related links include the new or changed note
