# Notes

## Findings
- Promoted Tier 1 entry points are now implemented as canonical Blade components for buttons, icon buttons, inline alerts, toasts, drawers, and modals.
- Batch B pass `2-B-0001` is deployed to staging on `main` and ready for manual review.
- Manual visual review of the existing Tier 1 UI Reference component surfaces passed for Batch B pass `2-B-0001`.
- Combined Batch B manual review found that `Default Timezone` and `Default Locale` are currently modeled incorrectly as free-text validated inputs on the form-pattern and localization proof surfaces; those fields should use searchable option-backed selectors, while validator-driven examples should stay on true free-entry fields like email and phone.
- Combined Batch B manual review found that the `Key Value Display` read-only detail proof on the data/content pattern page currently leaks broken inline markup instead of rendering the linked support-runbook value correctly.
- Combined Batch B manual review found a broader proof-clarity issue on the Tier 2 library pages: examples like `Search And Filter Bar` currently read more like static mockups than explicit library proofs, so the next pass should add clearer on-page descriptors about intended behavior, data shape, and usage boundaries.
- Combined Batch B manual review found that the shared grouped-actions dropdown action menu currently stays open after outside interaction; outside-click dismissal should be part of the shared pattern contract rather than something left to individual proof pages to handle.
- Combined Batch B manual review also found that the shared grouped-actions dropdown action menu is currently clipped by surrounding card/content-section borders; open panels need to layer above nearby UI instead of being visually cut off by their container.
- Combined Batch B manual review found that the current dashboard widget sizing direction is under-defined and too narrow; Batch B still needs an intentional reusable span model for dashboard widgets instead of implying only small fixed card sizes.
- Combined Batch B manual review found that the dashboard widget shell is still only implied through sparse stat-card and proof examples; Batch B still needs an explicit widget-shell contract covering allowed regions, density limits, and content composition rules.
- Batch B planning review also identified additional missing UI-system building blocks worth standardizing now:
  - a Tier 1 date/date-time selection baseline
  - a Tier 2 date-filter/date-range pattern
  - a Tier 2 profile/identity summary card pattern
- Combined Batch B manual review found that the shared sub-navigation bar active state is too weak in both dark and light mode; the current item needs a clearer soft neutral emphasis so section navigation reads intentionally.
- Chart widgets and calendar-specific widget/content patterns were considered in the same review, but remain intentionally out of the current Batch B queue because they are still more tightly coupled to later data and feature contracts.
- Batch B pass `2-B-0011` is now deployed to staging on `main` and resolves the first combined review findings by:
  - replacing locale/timezone free-text demos with option-backed searchable selectors on the touched proof and live localization surfaces
  - repairing the `Key Value Display` proof so trusted link content renders intentionally instead of leaking malformed markup
  - adding clearer proof-intent notes on the Tier 2 forms, data/content, and navigation pattern pages
- Batch B pass `2-B-0012` is now deployed to staging on `main` and resolves the remaining currently registered review queue by:
  - adding shared outside-click / focus-loss dismissal and unclipped overlay layering to the grouped-actions dropdown pattern
  - defining and proving the widget span model plus the reusable widget shell anatomy on the layout, archetype, and live dashboard surfaces
  - establishing the Tier 1 date/date-time baseline and the Tier 2 date-range filter pattern
  - establishing the Tier 2 identity summary card and adopting it on the account/profile proof surface
  - strengthening the shared sub-navigation active state in both dark and light mode
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
- Batch B review-fix pass `2-B-0012` uses shared pattern entry points for widgets, date ranges, and identity summaries rather than extending existing proof pages with more one-off markup.

## Risks / Questions
- Realtime notification toast rendering remains a feature-level JS path and is intentionally outside this Tier 1 hardening pass.
- `resources/views/platform/ui-reference/index.blade.php` remains an unused legacy workspace view because the canonical `/platform/ui-reference` route renders `overview.blade.php`; this pass left it untouched to avoid mixing unrelated cleanup into the Batch B implementation lane.
- Combined Batch B manual review is still required to confirm the newly implemented widget, date-range, identity-summary, dropdown, and sub-navigation changes before the batch can move toward close-out.
