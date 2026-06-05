# docs/02-standards/ui/contracts AGENTS.md

## Purpose

Tier 1 and component acceptance contracts. These files define primitive behavior and consumption rules.

## Read Order

1. Read `Component Contracts Index.md`.
2. Open the exact contract for the component being changed.
3. Use `Tier 1 - Consumption And Composition Contract.md` when deciding whether a higher-level pattern may consume or extend a primitive.

## Avoid

- Do not read every Tier 1 contract for one primitive.
- Do not add Tier 2 behavior to Tier 1 contracts.
- Do not use implementation examples as replacement for contract rules.

## Split Guidance

Keep one contract per component family. If a contract grows to cover unrelated variants, split the unrelated variant into its own contract and update the index.
