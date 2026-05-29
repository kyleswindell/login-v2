# Decisions Index

Use this branch for canonical architecture and product decision records.

## Purpose

Canonical hub for ADRs and elevated decision records that need durable rationale, explicit status, and stable linking across the docs system.

## Scope

This branch owns:

- architecture decision records
- product decision records that materially affect system behavior, ownership, or delivery direction
- supersession history for prior accepted decisions

This branch does not own:

- current implementation details that belong in canonical architecture, feature, database, or flow docs
- phase sequencing or batch intent that belongs in `07-planning/`
- operational procedures that belong in `10-runbooks/`
- support notes or research that belong in `09-reference/`

## Usage Rules

- Use this branch when a decision needs explicit status, rationale, consequences, and durable cross-linking.
- Keep decisions in canonical owner notes by default; elevate them here only when they are cross-cutting, durable, superseding, or need explicit ADR lifecycle state.
- Keep the current-state description in the canonical owner doc, and link to the ADR for the decision rationale.
- Do not create duplicate decision summaries in multiple branches; link to the decision record instead.
- Use the standard ADR template for new records:
  - [ADR Template](../02-standards/documentation/Templates/ADR%20Template.md)

## Current Records

- No active decision records published yet.

## Related

- [00-start-here](../00-start-here.md)
- [How To Write Docs](../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../02-standards/documentation/Doc%20Governance.md)
