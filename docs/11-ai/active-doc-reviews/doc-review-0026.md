# Document Review 0026

## Review Pass
3

## Target
The current Tier 1 implementation-form inventory and its suitability as the building-block layer for Tier 2 and future feature work

## Review Type
Document Review

## Status
CLOSED

## Purpose
Classify the current Tier 1 inventory by recommended implementation direction so the project can tell which items are intentionally low-level class/markup contracts, which should probably graduate into Blade components, which still need a clearer wrapper contract, and which are most likely carrying implementation drift from Batch A.

## Scope
- `docs/09-reference/ui/UI UX Tier 1 Implementation Form Inventory.md`
- `docs/02-standards/ui/contracts/Tier 1 - Buttons And Icon Buttons Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Consumption And Composition Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Drawer And Modal Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Input Controls Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Shell Navigation Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Utility Primitives Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Layout And Scaffolding Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Table Baseline Contract.md`
- `docs/02-standards/ui/contracts/Tier 1 - Toast And Inline Alert Contract.md`
- `resources/views/components/ui/badge.blade.php`
- `resources/views/components/ui/status.blade.php`
- `resources/views/platform/ui-reference/components/actions.blade.php`
- `resources/views/platform/ui-reference/components/forms.blade.php`
- `resources/css/app.css`

## Findings

### Finding 1
- type: keep-as-class-markup-contract
- location: `docs/09-reference/ui/UI UX Tier 1 Implementation Form Inventory.md`, utility and layout baselines
- issue: Several Tier 1 items are currently class/markup contracts, and that is a legitimate long-term form for them. They are native HTML primitives or structural utilities where the reusable value comes from a stable markup shape and tokenized classes, not from a Blade wrapper.
- recommended classification:
  - keep as class/markup contract:
    - Divider
    - Spinner
    - Label baseline
    - Link baseline
    - Container baseline
    - Grid baseline
    - Stack / Flex baseline
- rationale:
  - these items stay close to native semantics
  - callers benefit from attribute-level flexibility
  - a Blade wrapper would add ceremony faster than it would reduce drift
- required action: Preserve these as explicit class/markup contracts, but keep their usage examples canonical and minimal so authors do not improvise wrapper variations.
- decision state: resolved

### Finding 2
- type: candidate-for-blade-component
- location: `docs/09-reference/ui/UI UX Tier 1 Implementation Form Inventory.md`, `resources/views/platform/ui-reference/components/actions.blade.php`, `resources/views/platform/ui-reference/components/forms.blade.php`, `resources/css/app.css`
- issue: Some Tier 1 items now carry enough semantic branching, accessibility expectations, or repeated wrapper structure that they would likely be easier to consume and harder to misuse if they exposed a first-class Blade component entry point.
- recommended classification:
  - candidate for Blade component:
    - Button
    - Icon Button
    - Toast baseline
    - Inline alert baseline
    - Modal baseline
    - Drawer baseline
- rationale:
  - buttons already have a descriptor-like API in practice: semantic, variant, size, disabled, loading, icon
  - toast and inline alert already behave more like semantic UI objects than loose HTML fragments
  - modal and drawer carry repeated shell structure, focus behavior expectations, and dismissal affordances that are easy to drift if left only as copied markup
- required action: Decide whether these should graduate into canonical Blade components, or at minimum receive a tighter wrapper contract with near-component ergonomics.
- constraints: This is a recommendation for future refinement, not proof that the current class-based implementation is broken.
- decision state: resolved

### Finding 3
- type: needs-clearer-wrapper-contract
- location: `docs/09-reference/ui/UI UX Tier 1 Implementation Form Inventory.md`, `resources/views/platform/ui-reference/components/forms.blade.php`, hybrid shell baselines
- issue: A large part of the current Tier 1 layer is usable, but its consumption contract is still too wrapper-heavy or too implicit. The visual result is documented, but the exact required markup shape is not yet crisp enough to prevent authors from rebuilding slightly different versions.
- recommended classification:
  - needs clearer wrapper contract:
    - Text Input
    - Textarea
    - Select
    - Checkbox
    - Radio Group
    - Switch / Toggle
    - Tooltip
    - Icon baseline
    - Sidebar baseline
    - Header baseline
    - Account Menu baseline
    - Mobile Nav Dock baseline
- rationale:
  - form controls are not just single elements; they often need label, helper, error, required, disabled, and readonly structure
  - the current reference pages demonstrate the states, but they still rely on hand-authored wrapping patterns
  - the shell baselines are intentionally hybrid, but they need an explicit statement of which parts are immutable scaffold, which parts are slot regions, and which pieces must reuse lower-level Tier 1 items
- required action: Tighten the canonical wrapper contract for each item so a developer can tell exactly what the supported shape is without copying a whole reference block.
- decision state: resolved

### Finding 4
- type: likely-drift-or-tier-boundary-blur
- location: `docs/09-reference/ui/UI UX Tier 1 Implementation Form Inventory.md`, `resources/views/platform/ui-reference/components/actions.blade.php`, `resources/css/app.css`
- issue: A few current Tier 1 items appear to blur the boundary between primitive baseline and pattern-level composition. They may still be visually correct, but their current form is the most likely place for Batch A to have carried forward design drift instead of a clean reusable primitive.
- recommended classification:
  - likely drift:
    - Table baseline
    - Section / Panel baseline
- rationale:
  - the table baseline already bundles sort controls, filter panel framing, pagination affordances, and richer row behaviors that read closer to Tier 2 pattern territory than pure Tier 1 baseline
  - the section/panel baseline currently leans on `ui-card` conventions that feel closer to a reusable content pattern than a pure primitive container
  - both items are plausible and useful, but they should be revalidated deliberately rather than assumed to be the ideal long-term primitive shape
- required action: Re-review these two items against the Tier 1/Tier 2 boundary before Batch B depends on them heavily for new composition work.
- decision state: resolved

## Summary
- Batch A did not appear to fail visually, but it also did not fully prove that every Tier 1 item landed in the right implementation form for long-term reuse.
- The current T1 layer is strongest where it is either clearly structural or already normalized into a Blade component.
- The biggest remaining risk is not that the system is unusable; it is that future Tier 2 and feature work could start copying large reference blocks or pattern-like wrappers where the Tier 1 boundary is still fuzzy.
- The most valuable next correction is not a blanket refactor. It is a focused standards pass that:
  - preserves the clearly legitimate class/markup contracts
  - decides which semantic objects should become Blade components
  - tightens wrapper contracts for controls and shell hybrids
  - revalidates the table/panel boundary

## Unresolved Decisions
- whether a later ADR should formally split enhanced data-table and richer content-section patterns into named Tier 2 contracts once Batch B starts composing them

## Implementation Status
implemented

## Exit Criteria
- the project has an explicit decision for each current Tier 1 item category:
  - keep as class/markup contract
  - candidate for Blade component
  - needs clearer wrapper contract
  - likely drift / tier-boundary revalidation
- any follow-up standards correction is routed through canonical Tier 1 contracts and the implementation-form inventory
- Batch B planning can rely on the resulting Tier 1 building-block expectations without guessing

## Resolution Notes
- Updated the Tier 1 consumption contract so standards now distinguish current implementation form from intended long-term direction.
- Locked the candidate decisions in canonical contracts:
  - Buttons and Icon Buttons -> promote to Blade component
  - Toast, Inline Alert, Drawer, and Modal -> promote to Blade component
  - native input controls -> remain class/markup contracts, but with clearer wrapper requirements
  - shell navigation surfaces -> remain hybrid, but with explicit region contracts
- Revalidated the fuzzy Tier 1 boundaries:
  - table baseline now explicitly excludes richer filter/sort/grid orchestration, which belongs to Tier 2
  - section/panel baseline now explicitly excludes richer card/content-section choreography, which belongs to Tier 2
- Updated the implementation-form inventory so it now records both current form and recommended direction for each Tier 1 item.
- Re-review confirmed the standards correction is internally consistent, and the immediate sequencing question was resolved: the promoted Blade-component candidates should be the first implementation lane inside Batch B rather than a post-Batch-B follow-up.
