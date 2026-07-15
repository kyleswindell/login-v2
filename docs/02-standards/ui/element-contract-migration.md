---
title: Element Contract Migration Control
slug: element-contract-migration
status: active-control
relative_path: docs/02-standards/ui/element-contract-migration.md
purpose: Controls the Elements-first UI contract stabilization sequence.
---

# Element Contract Migration Control

## Topology Status

All physical source paths in this migration document describe current implementation inventory. Parallel CSS and JavaScript paths remain transitional under Repository Architecture. An Element or Component owner classification may remain valid even when its physical source moves into an artifact-owned bundle.

## 1. Purpose

This document controls the Elements-first API contract stabilization pass for Login App UI standards.

The goal is to make Foundation Elements the first stable `contract.php` category before broad Component contract rollout continues. Elements define foundational API rules for tokens, visual roles, source ownership, rendered evidence evidence, and manual review. Component contracts must consume these Element rules instead of becoming the primary source for them.

This is a documentation/control standard. It does not create contracts, edit Component Blade/CSS/JS, rewrite Rendered evidence routes, or fill `docs/02-standards/ui/tokens/`.

## 2. Why Elements Come First

Components consume Elements for:

- color
- themes
- spacing
- typography
- icons
- motion
- layout and grid
- pictogram and media treatment

Components must not become the primary source for these foundational rules. A Button contract may declare that it consumes Color, Spacing, Typography, Icons, Motion, and Themes, but it must not redefine color token roles, theme behavior, spacing scale, type roles, icon source policy, or motion policy locally.

Elements therefore need stable ownership, contract fields, token/source maps, and rendered evidence proof before Component contracts can be normalized safely.

## 3. Element Source-Of-Truth Order

Use this order when Element docs, contracts, source files, and rendered evidence pages disagree:

1. Installed token/source files.
2. Runtime Element `contract.php` files.
3. Owner-local `reference.php` files when present.
4. Existing Element rendered evidence pages.
5. `docs/02-standards/ui/elements/*.md`.
6. `docs/02-standards/ui/elements/tokens.md` for Token Governance when token ownership is in scope.
7. `docs/02-standards/ui/tokens/` only after token standards are created there.
8. Archived docs only when explicitly requested.

`docs/02-standards/ui/elements/tokens.md` exists in this working tree and is the current Token Governance Element standard for this pass. The separate `docs/02-standards/ui/tokens/` directory remains unfilled in this pass.

## 4. Element Contract Matrix

| Element    | Standards doc path                            | Runtime contract path                              | Reference definition path                       | Token/source files                                                                                                             | Rendered evidence route                                                      | Contract status                                | Reference page status                            | Examples/manual review status                                                                                            | Token ownership impact                                                                                                                             | Component dependency impact                                                                                      | Required launch action                                                                            | Risk level | Notes / unknowns                                                                                    |
| ---------- | --------------------------------------------- | -------------------------------------------------- | ----------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------- | ---------------------------------------------- | ------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------- | ---------- | --------------------------------------------------------------------------------------------------- |
| 2x Grid    | `docs/02-standards/ui/elements/2x-grid.md`    | `resources/views/elements/2x-grid/contract.php`    | None found                                      | `resources/css/tokens/layout.css`                                                                                              | `not installed`                                                              | lifecycle `approved`; review `approved`        | Generic Element show page through catalog        | Contract declares examples; folder missing; no example views found; generic Element show page only; Needs confirmation   | Proposed owner for layout/grid token usage; verify in contract and Layout Pattern                                                                  | Layout, Navigation, Data and content, page shell, dashboard grid consumers                                       | Preserve contract and confirm layout token ownership before Component layout claims               | Medium     | Layout ownership may overlap Layout Pattern; do not move Pattern composition into Element contract. |
| Color      | `docs/02-standards/ui/elements/color.md`      | `resources/views/elements/color/contract.php`      | `resources/views/elements/color/reference.php`  | `resources/css/tokens/index.css`, `resources/css/tokens/semantic/**`, `resources/css/tokens/palette/**`, theme token consumers | `not installed`; nested `/usage`, `/tokens`, `/layering`, `/examples` routes | lifecycle `approved`; review `needs-review`    | Advanced owner-local reference definition exists | Contract declares examples; folder exists; example views exist; nested rendered evidence examples route exists           | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify semantic/palette ownership in contract | All Components and Patterns consume Color; Button, Notification, and Tag are named contract consumers            | Review stale wording and examples registration consistency; do not rewrite pages                  | High       | Advanced surface; preserve carefully because many Component tokens depend on Color.                 |
| Icons      | `docs/02-standards/ui/elements/icons.md`      | `resources/views/elements/icons/contract.php`      | None found                                      | `resources/views/components/icons/icon-list.txt`; internal icon renderer/source files                                          | `not installed`                                                              | lifecycle `approved`; review `approved`        | Generic Element show page through catalog        | Contract declares examples; folder missing; no example views found; generic Element show page only; Needs confirmation   | Confirmed by source library; no token file ownership declared                                                                                      | Buttons, links, menus, status, notification, navigation, and icon-only controls depend on Icons                  | Normalize simple contract/source references after Color/Themes preservation pass                  | Medium     | Contract has no token files because icon ownership is source-library based, not token-file based.   |
| Motion     | `docs/02-standards/ui/elements/motion.md`     | `resources/views/elements/motion/contract.php`     | None found                                      | `resources/css/tokens/motion.css`                                                                                              | `not installed`                                                              | lifecycle `provisional`; review `needs-review` | Generic Element show page through catalog        | Contract declares examples; folder missing; no example views found; generic Element show page only; Needs confirmation   | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contract                            | Accordion, menu, modal, loading, tooltip, notification, shell, and overlay behavior consume Motion               | Normalize simple contract and manual-review examples before broad interactive Component contracts | High       | Motion affects JS/CSS behavior contracts; do not alter behavior in this pass.                       |
| Pictograms | `docs/02-standards/ui/elements/pictograms.md` | `resources/views/elements/pictograms/contract.php` | None found                                      | No token file declared; asset source remains gated                                                                             | `not installed`                                                              | lifecycle `planned`; review `blocked`          | Generic Element show page through catalog        | Contract declares examples; folder missing; no example views found; public asset proof blocked; Needs confirmation       | Proposed future owner for pictogram/media treatment after asset decision                                                                           | Empty states, onboarding, help, and illustrative content may depend later                                        | Preserve planned/blocked state; do not import assets or create new examples without decision      | Low        | Deferred until pictogram asset source decision exists.                                              |
| Spacing    | `docs/02-standards/ui/elements/spacing.md`    | `resources/views/elements/spacing/contract.php`    | None found                                      | `resources/css/tokens/spacing.css`                                                                                             | `not installed`                                                              | lifecycle `approved`; review `approved`        | Generic Element show page through catalog        | Contract declares examples; folder missing; no example views found; generic Element show page only; Needs confirmation   | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contract                            | All Components and Patterns consume Spacing; stack/h-stack/v-stack are named consumers                           | Normalize first with Motion, Typography, and Icons because it is foundational and simple          | High       | Component CSS token cleanup depends on a stable spacing contract.                                   |
| Themes     | `docs/02-standards/ui/elements/themes.md`     | `resources/views/elements/themes/contract.php`     | `resources/views/elements/themes/reference.php` | `resources/css/tokens/themes/index.css`, `resources/css/tokens/themes/**`, Color token consumers                               | `not installed`; nested `/usage`, `/values`, `/contexts`, `/examples` routes | lifecycle `approved`; review `needs-review`    | Advanced owner-local reference definition exists | Contract declares examples; folder exists; example views exist; nested rendered evidence examples route exists           | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify theme/color boundary in contracts      | All tokenized Components and Patterns depend on Themes; Button, Text input, and Notification are named consumers | Review stale wording and examples registration consistency; do not rewrite pages                  | High       | Preserve carefully with Color because theme values and color roles are tightly coupled.             |
| Typography | `docs/02-standards/ui/elements/typography.md` | `resources/views/elements/typography/contract.php` | None found                                      | `resources/css/tokens/type/index.css`                                                                                          | `not installed`; nested `/type-sets` route                                   | lifecycle `provisional`; review `needs-review` | Generic Element show page plus type-sets page    | Contract declares examples; folder missing; no example views found; type-set route exists separately; Needs confirmation | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contract                            | All text-bearing Components and Patterns depend on Typography; Button, Text input, and Tag are named consumers   | Normalize simple contract fields and examples before text-heavy Component contracts               | High       | Type-set route is already separate; avoid rewriting it during contract normalization.               |

### 4.1 Element Examples Coverage

Do not create missing folders or examples in this pass. Use this table to avoid overstating manual-review coverage.

| Element    | Contract declares examples                          | Example folder exists | Example views exist      | rendered evidence currently renders examples                              | Current status                  |
| ---------- | --------------------------------------------------- | --------------------- | ------------------------ | ------------------------------------------------------------------------- | ------------------------------- |
| 2x Grid    | Yes: `resources/views/elements/2x-grid/examples`    | No                    | No                       | Generic Element show page only                                            | Needs confirmation              |
| Color      | Yes: `resources/views/elements/color/examples`      | Yes                   | Yes, 6 Blade views found | Yes, nested `not installed` route exists                                  | Review registration consistency |
| Icons      | Yes: `resources/views/elements/icons/examples`      | No                    | No                       | Generic Element show page only                                            | Needs confirmation              |
| Motion     | Yes: `resources/views/elements/motion/examples`     | No                    | No                       | Generic Element show page only                                            | Needs confirmation              |
| Pictograms | Yes: `resources/views/elements/pictograms/examples` | No                    | No                       | Generic Element show page only                                            | Blocked / Needs confirmation    |
| Spacing    | Yes: `resources/views/elements/spacing/examples`    | No                    | No                       | Generic Element show page only                                            | Needs confirmation              |
| Themes     | Yes: `resources/views/elements/themes/examples`     | Yes                   | Yes, 4 Blade views found | Yes, nested `not installed` route exists                                  | Review registration consistency |
| Typography | Yes: `resources/views/elements/typography/examples` | No                    | No                       | Type Sets page exists separately; declared examples path is not confirmed | Needs confirmation              |

## 5. Token Ownership Map

Do not create token docs in this pass. Use this planning map to decide owner standards before writing additional token documentation.

| Token source                              | Element owner                                     | Ownership status                                                                                                         | Notes                                                                                                       |
| ----------------------------------------- | ------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------- |
| `docs/02-standards/ui/elements/tokens.md` | Token Governance Element standard                 | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Existing standards file for token governance; not a token source file.                                      |
| `resources/css/tokens/themes/**`          | Themes / Color                                    | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Themes owns theme value sets and contexts; Color owns semantic color roles those values satisfy.            |
| `resources/css/tokens/semantic/**`        | Color                                             | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Semantic token aliases map palette/theme values into app color roles.                                       |
| `resources/css/tokens/palette/**`         | Color / Themes                                    | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Palette files provide primitive source values; usage must remain role-driven through Color and Themes.      |
| `resources/css/tokens/spacing.css`        | Spacing                                           | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Spacing owns the scale and relationship model.                                                              |
| `resources/css/tokens/motion.css`         | Motion                                            | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Motion owns duration/easing roles and reduced-motion behavior.                                              |
| `resources/css/tokens/type/index.css`     | Typography                                        | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Typography owns font, scale, role, and weight tokens.                                                       |
| `resources/css/tokens/layout.css`         | 2x Grid / Layout                                  | Needs confirmation                                                                                                       | 2x Grid owns grid/layout primitives; Layout Pattern may own composition-level usage.                        |
| `resources/css/tokens/shadow.css`         | Color / Overlay Pattern                           | Needs confirmation                                                                                                       | Shadows may be Color layering roles or Overlay Pattern roles; owner must be decided before contract claims. |
| `resources/css/tokens/z-index.css`        | UI Shell / Overlay Pattern / Color layering       | Needs confirmation                                                                                                       | Z-index ownership may cross Color layering, UI shell, Modal, Popover, and Overlay Pattern contracts.        |
| `resources/css/tokens/components/**`      | Component-owned tokens, dependent on Color/Themes | Confirmed current owner classification; physical path is transitional under Repository Architecture. verify in contracts | Component token files depend on Color and Themes but remain private to approved Component token families.   |

## 6. Element Launch Priority

### Batch 0 - Already Advanced / Preserve Carefully

- Color
- Themes

Color and Themes have owner-local `reference.php` files and nested Rendered evidence routes. Treat them as advanced surfaces. Review them for stale wording and examples registration consistency without rewriting their pages.

### Batch 1 - Foundational / Normalize Before Components

- Spacing
- Typography
- Icons
- Motion

These Elements are broad Component dependencies and should be normalized before broad Component contracts. Spacing and Icons are already approved in the observed contracts; Motion and Typography are provisional or needs-review and need careful normalization without behavior edits.

### Batch 2 - Important / Lower Immediate Component Risk

- 2x Grid
- Pictograms

2x Grid is approved, but its ownership can overlap Layout Pattern composition. Pictograms are planned/blocked and should remain gated until an asset-source decision exists.

### Batch 3 - Token Standards Gap

Decide whether `docs/02-standards/ui/tokens/` should contain:

- a standalone `index.md` token ownership map that points back to Element and Component owners, or
- token owner docs that point back to Element and Component standards.

Do not fill that directory until this ownership decision is explicit.

## 7. Contract Normalization Checklist

Use this checklist for each Element contract. Do not invent missing content; mark missing or unclear fields as `Needs confirmation`.

| Contract field or topic            | Required review question                                                                               | Current observed state                                                                                                                                        |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| ID / slug / name                   | Does `identity` define stable slug, label, component/API name, group, and type?                        | Present in all eight observed Element contracts.                                                                                                              |
| API layer                          | Does the contract identify that the surface is a Foundation Element API?                               | Present through `identity.type=element`; exact `api_layer` wording is not a top-level contract field and should be documented only if the template adopts it. |
| Status / maturity                  | Does `lifecycle.status` describe current maturity without overstating readiness?                       | Present in all eight contracts; Motion and Typography are provisional, Pictograms is planned.                                                                 |
| Canonical docs path                | Does `source.docs` point to the owning `docs/02-standards/ui/elements/{element}.md` file?              | Present in all eight observed Element contracts.                                                                                                              |
| Rendered evidence route            | Does `catalog.route` or the registry route identify the rendered evidence proof route?                 | Present as route name in all contracts; URL mapping remains in registry/routes.                                                                               |
| Source files                       | Does `source` identify relevant source files without claiming nonexistent files?                       | Present, but source completeness needs confirmation per Element during normalization.                                                                         |
| Token/source references            | Does `source.tokens` or equivalent source metadata identify token ownership?                           | Present for 2x Grid, Color, Motion, Spacing, Themes, and Typography; Icons and Pictograms do not declare token files.                                         |
| Examples/manual review entries     | Does `examples` define enough required examples for manual review?                                     | Present in all contracts, but example folder/view completeness needs confirmation.                                                                            |
| Accessibility expectations         | Does `accessibility` define keyboard, ARIA, focus, or screen reader expectations where relevant?       | Present structurally in all contracts; content depth needs Element-by-Element review.                                                                         |
| Related Elements                   | Are dependencies on Color, Themes, Spacing, Typography, Icons, Motion, Grid, or Pictograms identified? | Needs confirmation; do not infer relationships silently.                                                                                                      |
| Related Components                 | Are consuming Components listed where the Element contract already knows them?                         | Present for some contracts; incomplete for broad consumers by design.                                                                                         |
| Related Patterns                   | Are consuming Patterns listed where the Element contract already knows them?                           | Mostly empty in observed contracts; needs confirmation before adding.                                                                                         |
| Known gaps / deferred capabilities | Are blocked, planned, or deferred capabilities explicit?                                               | Present through lifecycle/review fields for Pictograms, Motion, Typography, Color, and Themes; detail needs confirmation.                                     |

## 8. Examples-First Element Review Model

Elements must have enough examples or visual proof to manually review the foundation API. Full educational pages can remain manually authored for now.

Launch expectations:

- Existing Color and Themes detail pages can remain as-is.
- Future Element work should prefer contract-declared examples over scattered example files.
- Contract examples must point to real source or explicitly state `Needs confirmation`.
- Manual review should be able to verify the foundation API without opening Component source first.
- Components should not begin broad contract rollout until their Element dependencies are stable.
- Component contracts may reference Element contracts as dependencies, but they must not redefine Element-owned rules.

## 9. Pass B Guidance - Spacing, Motion, Typography, Icons

Section 9 prepares future Pass B work and does not replace Pass A; Pass A remains the contract-file and template normalization prerequisite.

This pass is review and normalization guidance only. Do not rewrite runtime contracts, create missing examples, change Element standards, change Rendered evidence routes, or alter Blade/CSS/JS as part of this pass.

The four contracts confirm a useful split:

- Spacing and Icons are marked approved at both lifecycle and overall review levels, but their contract-declared example folders are not present in the working tree.
- Motion and Typography are approved APIs in the UI standards registry, but their runtime contracts remain `provisional` and `needs-review`.
- All four declare required examples, but none of their declared Element example folders currently exists.
- Typography has a separate Type Sets Rendered evidence route; that route is evidence of rendered Typography proof, not evidence that the contract-declared `resources/views/elements/typography/examples` folder exists.

### 9.1 Shared Normalization Rules

Use these rules before any future contract edit:

- Preserve the observed contract source paths unless the installed file proves a better path.
- Do not change lifecycle or review status just to match the registry; first decide whether registry status or runtime contract status is the intended durable truth.
- Document registry/runtime mismatch decisions before patching runtime contracts; deciding the source of truth and editing contracts must not happen in the same pass.
- Do not mark `examples` as approved or fully registered until the declared example folder, example views, and rendered evidence rendering path are all verified.
- Do not treat generic Element show pages as live examples unless the launch decision explicitly allows them as sufficient manual-review proof.
- Do not add new token ownership claims beyond installed token files and explicit Element standards.
- Do not use Component cleanup work as evidence that an Element contract is complete.
- Do not convert Heroicons or other external icons into approved icon sources; external icons remain placeholders only when the internal icon library lacks a suitable icon.

### 9.2 Element Guidance Matrix

| Element    | Observed contract posture                                                                                                                       | Confirmed source evidence                                                                                                                                                                                                    | Examples evidence                                                                                                                         | Normalization guidance                                                                                                                                                                                                                                                                                                                      | Do not change yet                                                                                                                        |
| ---------- | ----------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| Spacing    | `lifecycle.status=approved`; `review.overall_state=approved`; `review.scopes.examples=needs-review`                                             | `resources/css/tokens/spacing.css`; standard at `docs/02-standards/ui/elements/spacing.md`; route `not installed`                                                                                                            | Contract declares `overview` and `spacing-scale`; `resources/views/elements/spacing/examples` is missing; generic Element show page only  | Keep Spacing as the first simple contract candidate, but reconcile the examples mismatch before calling the contract fully reviewable. Confirm that spacing scale, stack/gap rules, density review, and internal/external ownership are reflected consistently between the standard, token file, and rendered evidence page.                | Do not add spacing values, density modes, utility families, or example folders in this guidance pass.                                    |
| Motion     | `lifecycle.status=provisional`; `review.overall_state=needs-review`; token, visual parity, and examples scopes still need review                | `resources/css/tokens/motion.css`; standard at `docs/02-standards/ui/elements/motion.md`; route `not installed`                                                                                                              | Contract declares `overview` and `reduced-motion`; `resources/views/elements/motion/examples` is missing; generic Element show page only  | Keep Motion conservative. Normalize source/token references, reduced-motion expectations, productive versus expressive gates, and component-owned motion boundaries before changing lifecycle status. Treat registry `Approved API` and contract `provisional` as a conflict to resolve explicitly.                                         | Do not alter animation behavior, JS controllers, CSS transitions, shell motion tokens, or expressive-motion gates in this guidance pass. |
| Typography | `lifecycle.status=provisional`; `review.overall_state=needs-review`; token, visual parity, accessibility, and examples scopes still need review | `resources/css/tokens/type/index.css`; standard at `docs/02-standards/ui/elements/typography.md`; route `not installed`; separate `not installed` route                                                                      | Contract declares `overview` and `type-sets`; `resources/views/elements/typography/examples` is missing; Type Sets page exists separately | Separate type-set page evidence from contract-declared examples. Normalize font stack, type roles, type-set ownership, weight names, code roles, and text-color dependencies against the installed token CSS before changing contract status. Treat registry `Approved API` and contract `provisional` as a conflict to resolve explicitly. | Do not add new type roles, rename compatibility classes, move Type Sets route ownership, or create token docs in this guidance pass.     |
| Icons      | `lifecycle.status=approved`; `review.overall_state=approved`; `review.scopes.examples=needs-review`; token scope is not applicable              | Internal icon renderer at `resources/views/components/ui/icon/index.blade.php`; internal icon library under `resources/views/components/icons/`; standard at `docs/02-standards/ui/elements/icons.md`; route `not installed` | Contract declares `overview` and `icon-sizes`; `resources/views/elements/icons/examples` is missing; generic Element show page only       | Keep Icons source-library based, not token-file based. Normalize internal icon source paths, manifest/library wording, placeholder external icon policy, icon-only accessibility, size model, and component consumer boundaries before adding or approving examples.                                                                        | Do not rename icons, add aliases, approve Heroicons-first usage, or create an alternate icon library in this guidance pass.              |

### 9.3 Recommended Pass B Sequence

1. Confirm the intended truth when registry disposition and runtime contract lifecycle disagree for Motion and Typography.
2. Reconcile examples evidence for all four Elements without creating example folders: declared examples, folder existence, view existence, and rendered evidence rendering path.
3. Normalize source path and token ownership wording in the contracts only after the evidence table is complete.
4. Update review scopes only where evidence proves the new state.
5. Defer any Blade/CSS/JS, route, or example implementation work to a separate implementation pass.

## 10. Recommended Next Implementation Passes

### Pass A

Normalize `docs/02-standards/ui/contract-file.md` and `docs/09-reference/ui/ui-contract-template.php` against the observed Element contracts.

### Pass B

Use the guidance in Section 9 before editing the simple foundation Element contracts:

- spacing
- motion
- typography
- icons

### Pass C

Review Color and Themes contracts and `reference.php` files only for stale wording and Examples registration consistency. Do not rewrite their pages.

### Pass D

Resolve the token standards gap by creating either:

- `docs/02-standards/ui/tokens/index.md` as a token ownership map, or
- token owner docs that point back to Element and Component owners.

### Pass E

Only after Elements are stable, return to Component contract migration.

## 11. Known Unresolved Decisions

- Decide whether token docs live under `docs/02-standards/ui/tokens/` or remain represented through Element standards.
- Decide whether token ownership is documented through Elements only or through a dedicated token index that points back to Element and Component owners.
- Decide whether `resources/css/tokens/shadow.css` and `resources/css/tokens/z-index.css` belong to Elements, Patterns, UI Shell, UI-internal infrastructure, or a documented split.
- Decide whether generic Element show pages are enough for launch manual review when contract-declared examples folders or views are missing.
- Decide whether registry `Approved API` disposition should override runtime contract `provisional` lifecycle for Motion and Typography, or whether the registry should distinguish approved API existence from contract maturity.

## 12. Validation

For this pass:

- Changed file path: `docs/02-standards/ui/element-contract-migration.md`.
- Added guidance-only Pass B review notes for Spacing, Motion, Typography, and Icons.
- This pass created no Component contracts.
- This pass edited no Component Blade/CSS/JS files.
- This pass edited no Element runtime contracts.
- This pass changed no Rendered evidence routes.
- This pass is documentation/control only.
- `docs/02-standards/ui/tokens/` was not filled.
- Any untracked Element contract files must be resolved before contract normalization proceeds.

Validation commands:

```text
Get-ChildItem resources/views/elements -Recurse -Include contract.php,reference.php
php -r '<Element contract shape/status read>'
Get-ChildItem resources/css/tokens -Recurse -File
```
