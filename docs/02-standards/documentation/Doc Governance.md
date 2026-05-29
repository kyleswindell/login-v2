# Doc Governance

This document defines the canonical scope and intent for Doc Governance.

## Purpose

Define lightweight content-classification guardrails for the active `docs/` tree.

## Scope

Applies to all active documentation in `docs/` and excludes `docs/_archive/`.

## Branch Ownership Rules

- `01-decisions/` owns ADRs and elevated decision records only.
- `02-standards/` owns rules and conventions only.
- `03-architecture/` owns system structure and boundaries only.
- `04-features/` owns feature behavior and contracts only.
- `05-flows/` owns execution sequences and step-by-step flows only.
- `06-database/` owns schema and data contracts only.
- `07-planning/` owns sequencing, roadmap intent, and phase/batch planning only.
- `09-reference/` owns non-canonical supporting and research notes only.
- `10-runbooks/` owns operational procedures only.

## Path And Link Guardrails

- Do not reference legacy pre-migration docs-root paths.
- Do not reference legacy pre-migration app-docs paths from the old hierarchy.
- Do not keep legacy wiki links from prior vault roots.
- Route all active links through `docs/` canonical paths.

## Index And Navigation Guardrails

- `docs/00-start-here.md` is the canonical root hub.
- Each branch `index.md` must define scope.
- Each branch `index.md` must link to all canonical child docs for that branch.
- Child notes should link back to their parent branch index when applicable.

## Enforcement

Use `scripts/check-docs-guardrails.sh` (or `npm run lint:docs:guardrails`) to fail changes that introduce forbidden legacy path patterns.

## Related

- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [00-start-here](../../00-start-here.md)
