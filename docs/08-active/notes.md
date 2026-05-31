# Notes

## Findings
- Promoted Tier 1 entry points are now implemented as canonical Blade components for buttons, icon buttons, inline alerts, toasts, drawers, and modals.
- Batch B pass `2-B-0001` is deployed to staging on `main` and ready for manual review.
- Manual visual review of the existing Tier 1 UI Reference component surfaces passed for Batch B pass `2-B-0001`.
- Combined Batch B manual review found that `Default Timezone` and `Default Locale` are currently modeled incorrectly as free-text validated inputs on the form-pattern and localization proof surfaces; those fields should use searchable option-backed selectors, while validator-driven examples should stay on true free-entry fields like email and phone.
- Combined Batch B manual review found that the `Key Value Display` read-only detail proof on the data/content pattern page currently leaks broken inline markup instead of rendering the linked support-runbook value correctly.
- Combined Batch B manual review found a broader proof-clarity issue on the Tier 2 library pages: examples like `Search And Filter Bar` currently read more like static mockups than explicit library proofs, so the next pass should add clearer on-page descriptors about intended behavior, data shape, and usage boundaries.
- Batch B pass `2-B-0011` is now deployed to staging on `main` and resolves the first combined review findings by:
  - replacing locale/timezone free-text demos with option-backed searchable selectors on the touched proof and live localization surfaces
  - repairing the `Key Value Display` proof so trusted link content renders intentionally instead of leaking malformed markup
  - adding clearer proof-intent notes on the Tier 2 forms, data/content, and navigation pattern pages
- Batch B passes `2-B-0002` through `2-B-0010` now leave behind a full first-pass Tier 2 proof map in UI Reference:
  - form patterns
  - data/content patterns
  - navigation/action patterns
  - table/advanced data patterns
  - layout/dashboard patterns
  - archetype proofs
- Batch B passes `2-B-0002` through `2-B-0010` are now deployed to staging on `main` and ready for one combined manual review pass.
- First live consumption proofs now use the new Tier 2 building blocks on:
  - `/dashboard`
  - `/platform/settings/general`
  - `/account`
  - `/account/settings`
  - `/account/preferences`
- Batch B handoff artifacts now exist in `docs/09-reference/ui/` for:
  - internal shell family rules
  - page/module archetypes
  - setup/settings registration fields
  - future-module UI ownership declaration fields

## Decisions
- Batch B starts with Tier 1 library hardening for the promoted Blade-component candidates before broader Tier 2 implementation continues.
- Batch B pass `2-B-0001` uses the existing Tier 1 class contracts as the styling baseline and wraps them in canonical Blade entry points rather than redefining visual rules.
- Batch B first-pass implementation closes the remaining planned slices in one review-ready pass so manual visual QA can happen against the full internal library/proof surface set instead of piecemeal.
- Batch B review-fix pass `2-B-0011` uses a shared option catalog and a small searchable-selector entry point rather than continuing the free-text localization demo pattern.

## Risks / Questions
- Realtime notification toast rendering remains a feature-level JS path and is intentionally outside this Tier 1 hardening pass.
- `resources/views/platform/ui-reference/index.blade.php` remains an unused legacy workspace view because the canonical `/platform/ui-reference` route renders `overview.blade.php`; this pass left it untouched to avoid mixing unrelated cleanup into the Batch B implementation lane.
