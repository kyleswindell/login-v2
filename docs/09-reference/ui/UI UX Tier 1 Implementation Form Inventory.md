# UI UX Tier 1 Implementation Form Inventory

This document defines the canonical scope and intent for UI UX Tier 1 Implementation Form Inventory.

## Purpose

Provide a support-level snapshot of how the current Tier 1 layer is actually exposed to downstream work.

This inventory is not the source of truth for UI rules. It exists to make the current implementation form explicit so Tier 2 and feature work can consume Tier 1 intentionally and so future audits can identify abstraction gaps without guessing.

Canonical standards references:

* [Tier 1 Component Implementation Checklist](../../02-standards/ui/components/Tier%201%20Component%20Implementation%20Checklist.md)
* [Tier 1 - Consumption And Composition Contract](../../02-standards/ui/contracts/Tier%201%20-%20Consumption%20And%20Composition%20Contract.md)

## Implementation Form Definitions

Use these labels:

* `Blade component`
* `Class/markup contract`
* `Hybrid`
* `Missing abstraction`

## Current Inventory

| Tier 1 item | Current implementation form | Recommended direction | Primary entry point | Notes |
| --- | --- | --- | --- | --- |
| Button | Class/markup contract | Promote to Blade component | `ui-action`, semantic/variant/size classes in `resources/css/app.css` | Reusable visually, but consumed through class vocabulary rather than a Blade component |
| Icon Button | Class/markup contract | Promote to Blade component | `ui-icon-button` in `resources/css/app.css` | Commonly consumed directly in markup |
| Text Input | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | `ui-input` in `resources/css/app.css` | Expected wrapper structure is still demonstrated mostly through UI Reference markup |
| Textarea | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | `ui-textarea` in `resources/css/app.css` | Same wrapper/usage issue as text input |
| Select | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | `ui-select` in `resources/css/app.css` | Includes compact variant via class extension |
| Checkbox | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | documented native input + wrapper markup pattern | Styling and wrapper conventions are reference-driven |
| Radio Group | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | documented native input + wrapper markup pattern | Group usage exists, but reusable structure is still markup-driven |
| Switch / Toggle | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | `ui-switch*` classes in `resources/css/app.css` | Behavior is represented as a markup pattern |
| Badge baseline | Blade component | Keep current Blade component direction | `resources/views/components/ui/badge.blade.php` | Strongest current Tier 1 reusable entry point |
| Status pill baseline | Blade component | Keep current Blade component direction | `resources/views/components/ui/status.blade.php` | Inline status treatment is componentized |
| Divider | Class/markup contract | Keep as class/markup contract | `ui-divider` in `resources/css/app.css` | Simple markup contract |
| Tooltip | Class/markup contract | Keep as class/markup contract with clearer wrapper contract | documented markup pattern in UI Reference | Non-interactive tooltip proof exists, but no standalone component surface |
| Spinner | Class/markup contract | Keep as class/markup contract | `ui-spinner` in `resources/css/app.css` | Simple primitive class contract |
| Icon baseline | Hybrid | Keep as hybrid with clearer wrapper contract | `x-ui.status-icon` plus Heroicon usage patterns | Custom icon component exists for status semantics, broader icon usage remains mixed |
| Label baseline | Class/markup contract | Keep as class/markup contract | `ui-control-label` in `resources/css/app.css` | Simple markup contract |
| Link baseline | Class/markup contract | Keep as class/markup contract | `ui-link` in `resources/css/app.css` | Simple markup contract |
| Table baseline | Hybrid | Revalidate Tier 1 boundary | table-related classes plus reference/proof markup | Primitive table structure is Tier 1; richer grid controls should be treated as Tier 2 |
| Modal baseline | Class/markup contract | Promote to Blade component | overlay markup and JS hooks on proof surfaces | Behavior is real, but entry point is not a standalone reusable component yet |
| Drawer baseline | Class/markup contract | Promote to Blade component | overlay markup and JS hooks on proof surfaces | Same as modal baseline |
| Toast baseline | Class/markup contract | Promote to Blade component | toast markup, JS behavior, and classes on proof/runtime surfaces | Reusable behavior exists, but contract is markup-driven |
| Inline alert baseline | Class/markup contract | Promote to Blade component | `ui-inline-alert*` classes in `resources/css/app.css` | Stable class vocabulary, not componentized |
| Sidebar baseline | Hybrid | Keep as hybrid with clearer wrapper contract | shell layout templates plus navigation classes | Real reusable shell exists, but consumption is not reduced to a single primitive component |
| Header baseline | Hybrid | Keep as hybrid with clearer wrapper contract | `resources/views/components/layouts/app.blade.php` and supporting classes/JS | Reusable at shell level, not at primitive component level |
| Account Menu baseline | Hybrid | Keep as hybrid with clearer wrapper contract | shell layout template plus JS state hooks | Reusable in the shell, but not exposed as a smaller component contract |
| Mobile Nav Dock baseline | Hybrid | Keep as hybrid with clearer wrapper contract | shell layout templates plus navigation classes/JS | Same shell-level reuse model |
| Container baseline | Class/markup contract | Keep as class/markup contract | layout classes in `resources/css/app.css` and shell/page markup | Consumed through layout conventions |
| Grid baseline | Class/markup contract | Keep as class/markup contract | layout classes and page markup | Consumed through markup conventions |
| Stack / Flex baseline | Class/markup contract | Keep as class/markup contract | layout classes and page markup | Consumed through markup conventions |
| Section / Panel baseline | Class/markup contract | Revalidate Tier 1 boundary | `ui-card` and related classes in `resources/css/app.css` | Passive grouping belongs in Tier 1; richer card/content-section choreography should be treated as Tier 2 |

## Current Interpretation

The present Tier 1 system is usable, but it is not uniformly componentized.

The practical current model is:

* a few strong reusable Blade component entry points
* many stable class/markup contracts
* several shell and baseline items that behave as hybrids

That is acceptable only if later work treats those implementation forms explicitly instead of assuming everything is either a Blade component or an ad hoc styling surface.

The practical target model is:

* keep clearly structural primitives low-level
* promote higher-semantic action, overlay, and feedback objects toward Blade component APIs
* tighten wrapper contracts where native controls or shell hybrids remain the right implementation form
* treat table and section/panel with extra caution so Tier 2 pattern work does not silently build on fuzzy Tier 1 boundaries

## Current Risk Areas

Most drift risk currently comes from:

* treating UI Reference snapshot markup as the production contract
* assuming class-based Tier 1 items are self-explanatory without documented wrapper structure
* mixing Heroicon usage, custom icon components, and shell-local patterns without naming which path is canonical for the specific primitive
* building Tier 2 patterns from copied page markup instead of from declared Tier 1 entry points

## Related

* [UI UX Contract Rollout Tracker](UI%20UX%20Contract%20Rollout%20Tracker.md)
* [UI UX Tier 1 UI Reference Implementation Checklist](UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
