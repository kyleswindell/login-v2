# Docs V2 Planning Notes

## Purpose

Define the approved Docs V2 migration governance and execution plan.

This note is planning-only and non-canonical.

## Scope

- Reorganize active docs into the new Docs V2 structure.
- Preserve all content (no loss).
- Keep V1 as archive/reference and mine selectively into V2 canonical docs.
- Remove migration bloat, duplicate guidance, and non-essential narrative.

## Non-Goals

- No V1 structural rewrite.
- No broad content rewriting during structural migration.
- No dual canonical paths.

## Core Governance

1. Migration mode: phased waves.
2. Canonical flips per wave for moved branches.
3. Final step is a cleanup lock, not a second canonical flip.
4. At all times: one canonical writable path per document.
5. Old paths are temporary read-only bridges.
6. AGENTS must always point to current canonical paths.

## Final Target Structure

```text
/docs
├── 00-drafts/            # non-canonical notes, staging, scratch work
├── 01-decisions/         # ADRs and major decisions
├── 02-standards/         # global rules and conventions
├── 03-architecture/      # system structure and boundaries
├── 04-features/          # feature behavior and contracts
├── 05-flows/             # system and user flows
├── 06-database/          # schema, tables, data contracts
├── 07-planning/          # roadmap, phases, batches, dependency planning
├── 08-active/            # current batch execution only, temporary
├── 09-reference/         # passive supporting/reference material
├── 10-runbooks/          # operational procedures
├── 11-ai/                # AGENTS, Codex rules, doc lifecycle
└── 99-changelog/         # release history and change log
```

`08-active` scope only:

```text
/docs/08-active
├── current-batch.md
├── worklog.md
├── variance-log.md
└── review-notes.md
```

`09-reference` scope only:

```text
/docs/09-reference
├── external-research/
├── tool-notes/
├── comparative-analysis/
└── archived-supporting-material/
```

## Canonical Truth Layers

- `02-standards` through `06-database`: canonical system truth.
- `07-planning`: planning intent.
- `08-active`: temporary execution notes, non-canonical.
- `09-reference`: secondary support only, non-authoritative.

## UI Ownership (Final)

- UI rules/tokens/contracts: `02-standards/ui/`
- UI implementation behavior: `04-features/`
- UI research/comparative notes: `09-reference/ui/`

UI standards baseline:

```text
/02-standards/ui/
├── color-system.md
├── typography.md
├── status-system.md
├── components/
├── contracts/
└── tokens/
```

## AI and Instruction Paths (Final)

Canonical staging path:

- `docs/11-ai/staging/`

Legacy bridge-only path during migration:

- `docs/Codex/Agent Doc Staging/`

Root contract target:

- `AGENTS.md`
- `docs/11-ai/rules.md`
- `docs/11-ai/source-of-truth.md`
- `docs/11-ai/doc-lifecycle.md`
- `docs/11-ai/staging/`

Rules:

- Never create new staging artifacts in legacy path after AI wave cutover.
- `AGENTS.md` points only to canonical paths.

## Bridge Policy (Mandatory)

Bridges are required for:

- leaf documents
- folder/index hub notes

No exceptions during migration.

Bridge template:

```markdown
# Moved Document

This document has moved:

-> [[new/path/to/doc]]

This file is a temporary migration bridge and will be removed after cleanup validation.
```

## Bridge Removal Gates (All Required)

1. No inbound references to old path (`rg "old/path/to/file"` returns zero).
2. Parent/related indexes updated to new path.
3. Obsidian backlink/graph check shows no active dependency.
4. At least one full phase iteration completed since move.
5. Manual spot check passes (open 3 to 5 related docs).

Only after all checks pass may bridge notes be removed.

## V1 Rule (Final)

V1 is mined, not migrated.

- Keep `docs/V1 App/` intact.
- Repair V1 links only for integrity.
- Do not perform V1 structural rewrites.

## Wave Sign-Off Authority

Wave sign-off owner:

- Docs audit agent

A wave cannot proceed until sign-off confirms:

- canonical paths correct
- bridges present and valid
- indexes/governance docs updated
- link validation passed

## Per-Wave Execution Contract

For each wave:

1. Move canonical docs for that branch.
2. Leave bridge notes in old locations.
3. Update `AGENTS.md`.
4. Update `docs/00 - Start Here.md`.
5. Update affected indexes/maps/standards.
6. Validate links and navigation.
7. Keep bridges temporarily.
8. Request docs audit sign-off.

Governance updates are incremental per wave. Update only affected sections.

## Wave Plan

### Wave 1: Standards

- Move `docs/Standards/` to `docs/02-standards/`.
- Move UI rules from `docs/V2 App/Reference/UI UX System/` to `docs/02-standards/ui/`.
- If included, move documentation standards into `docs/02-standards/documentation/`.

### Wave 2: Architecture

- Move `docs/V2 App/Architecture/` to `docs/03-architecture/`.

### Wave 3: Features

- Move `docs/V2 App/Features/` to `docs/04-features/`.

### Wave 4: Flows + Planning

- Create `docs/05-flows/` and extract flow docs.
- Move planning branch into `docs/07-planning/` with clear substructure for roadmap/phases/batches/dependencies.

### Wave 5: Database

- Create and populate `docs/06-database/` for schema/table/data contracts.

### Wave 6: Reference

- Create and populate secondary `docs/09-reference/` with non-authoritative support material.

### Wave 7: Runbooks

- Move `docs/V2 App/Runbooks/` to `docs/10-runbooks/`.

### Wave 8: AI

- Move `docs/Codex/` to `docs/11-ai/`.
- Cut over staging path to `docs/11-ai/staging/`.
- Legacy Codex staging path remains bridge-only until final cleanup.

### Wave 9: Drafts

- Move `docs/Personal Notes/` to `docs/00-drafts/`.
- Add `README.md` enforcing non-canonical draft lifecycle.

### Wave 10: Decisions + Changelog

- Move `docs/Decisions/` to `docs/01-decisions/`.
- Normalize `docs/99-changelog/`.

## Validation Commands

Run after each wave:

```bash
# markdown count
rg --files docs -g '*.md' | wc -l

# identify remaining bridge notes
rg -n "Moved Document|temporary migration bridge" docs -g '*.md'
```

Optional relative-link checker:

```bash
bash -lc '
set -euo pipefail
missing=0
while IFS= read -r file; do
  dir=$(dirname "$file")
  while IFS= read -r target; do
    case "$target" in ""|"#"*|http:*|https:*|mailto:*|obsidian:* ) continue;; esac
    clean=${target%%#*}
    decoded=$(printf "%s" "$clean" | perl -pe "s/%([0-9A-Fa-f]{2})/chr(hex(\$1))/eg")
    path=$(realpath -m "$dir/$decoded")
    [ -e "$path" ] || { echo "$file -> $target"; missing=$((missing+1)); }
  done < <(rg -o --no-filename "\\[[^\\]]*\\]\\(([^)]+)\\)" "$file" | sed -E "s/^.*\\(([^)]+)\\)$/\\1/")
done < <(rg --files docs -g "*.md")
echo "MISSING_COUNT=$missing"
'
```

## Final Cleanup Lock

This is not a canonical flip.

Exit criteria:

1. all waves completed and signed off
2. bridge removal gates passed
3. bridge notes removed
4. link and navigation validation passed
5. root governance docs reflect final structure only

## V1-to-V2 Mining Rules (Condensed)

- Behavior -> `04-features`
- System structure/boundaries -> `03-architecture`
- Rules/tokens/conventions -> `02-standards`
- User/system flows -> `05-flows`
- Data contracts/schema/tables -> `06-database`
- Operations/procedures -> `10-runbooks`
- Support research -> `09-reference`

## Current Status

- Governance model ratified.
- Folder model ratified.
- Bridge and validation gates ratified.
- Ready to execute Wave 1 after visual review approval.
