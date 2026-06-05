# docs/02-standards/ui AGENTS.md

## Purpose

UI rules only. This folder owns design-system standards, Tier 1/Tier 2 boundaries, UI contracts, tokens, and component-library rules.

## Read Order

1. Read `UI UX System Index.md` for UI standards navigation.
2. For primitives, read `contracts/AGENTS.md` and the specific Tier 1 contract.
3. For reusable patterns, read `components/AGENTS.md`, the Tier 2 hub, and only the relevant `components/tier-2-patterns/` family file.
4. For color/theme work, read `tokens/AGENTS.md` before opening token files.

## Avoid

- Do not read every UI standards file before a narrow UI change.
- Do not redefine Tier 1 primitives from Tier 2 or feature code.
- Do not treat reference/audit material as rules unless this standards folder adopts it.

## Split Guidance

Large UI standards should stay index-driven. If one file starts owning multiple component types or tiers, split by tier and component family rather than adding more sections to one long file.
