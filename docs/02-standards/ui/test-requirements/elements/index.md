# Foundation Element Test Requirement Files

## Folder Purpose

This folder contains implementation-facing test requirement checklists for individual Foundation Elements. These files translate the canonical Element standards into executable-test criteria, source scan boundaries, manual proof expectations, known blockers, and exception rules.

Executable tests do not live here. Future tests belong beside the owning implementation or in the app test tree as defined by the UI testing policy.

## Status Vocabulary

Use only these requirement statuses:

- `planned`: criteria are defined, but executable coverage has not started.
- `partial`: some executable coverage exists or is known, but the Element requirement is not complete.
- `implemented`: required automated, governance, and manual proof checks are covered.
- `blocked`: tests cannot be completed until a standard, source, or ownership decision is made.
- `deferred`: the public API or test target is intentionally not active yet.
- `needs-confirmation`: the source, route, owner, or expected behavior must be confirmed before implementation.

## Implementation Enforcement Modes

Initial executable tests should support these enforcement modes:

- `fail`: violations that are already approved as hard failures.
- `report-only`: known migration debt or broad scans that need baseline review.
- `deferred`: checks blocked by missing standards, browser strategy, or component ownership.

Do not fail broad consumer scans until existing legacy usage has either been migrated or baselined.

Report-only findings must be written to a stable baseline artifact before being promoted to hard failures. Tests should fail only when new unbaselined report-only findings are introduced or when a requirement explicitly marks the check as `fail`.

Tests must read the canonical standard and runtime contract before asserting hard-coded role names. If the standard and contract disagree, fail with a contract drift message instead of guessing.

## Inventory

| Element | Requirement file | Requirement status | Priority | Source standard | Runtime contract | Rendered evidence route | Known blockers / notes |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Color | [color.md](color.md) | `partial` | `high` | `docs/02-standards/ui/elements/color.md`; `docs/02-standards/ui/elements/tokens.md` | `resources/views/elements/color/contract.php` | `not installed`; `not installed` | Component color token ownership must classify Status/UI shell token files instead of silently approving them. |
| Themes | [themes.md](themes.md) | `partial` | `high` | `docs/02-standards/ui/elements/themes.md`; `docs/02-standards/ui/elements/color.md` | `resources/views/elements/themes/contract.php` | `not installed` | Product/app theme switching remains separate from rendered evidence proof controls. |
| Spacing | [spacing.md](spacing.md) | `planned` | `high` | `docs/02-standards/ui/elements/spacing.md`; `docs/02-standards/ui/elements/2x-grid.md` | `resources/views/elements/spacing/contract.php` | `not installed` | Geometry values require classification before becoming failures or tokens. |
| Typography | [typography.md](typography.md) | `partial` | `high` | `docs/02-standards/ui/elements/typography.md` | `resources/views/elements/typography/contract.php` | `not installed`; `not installed` | Both `resources/css/type/**` and `resources/css/tokens/type/**` currently exist and must stay in scope. |
| Motion | [motion.md](motion.md) | `partial` | `medium` | `docs/02-standards/ui/elements/motion.md` | `resources/views/elements/motion/contract.php` | `not installed` | `resources/js/ui-controls/**` exists, but controller timing governance still needs requirement confirmation. |
| Icons | [icons.md](icons.md) | `partial` | `medium` | `docs/02-standards/ui/elements/icons.md` | `resources/views/elements/icons/contract.php` | `not installed` | Consumer API cleanup is separate from preserving internal icon source files. |
| Pictograms | [pictograms.md](pictograms.md) | `deferred` | `low` | `docs/02-standards/ui/elements/pictograms.md` | `resources/views/elements/pictograms/contract.php` | `not installed` | Production API remains blocked until asset source, naming, sizing, and accessibility are approved. |
| 2x Grid | [2x-grid.md](2x-grid.md) | `planned` | `medium` | `docs/02-standards/ui/elements/2x-grid.md`; `docs/02-standards/ui/elements/spacing.md` | `resources/views/elements/2x-grid/contract.php` | `not installed` | Pattern-owned layout composition is not owned by 2x Grid. |
