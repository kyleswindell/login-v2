# Phase 2 - Batch B Implementation Prep

This document defines the canonical scope and intent for Phase 2 - Batch B Implementation Prep.

## Purpose

Break [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md) into an implementation-start checklist so the batch can begin with explicit surface boundaries, pattern targets, cleanup limits, and verification rules.

This note owns batch-start readiness and execution order only. It does not replace canonical standards, architecture, or feature owner docs.

## Use At Batch Start

When Batch B becomes active:

1. confirm Batch A is actually complete enough for Tier 2 reuse
2. move this checklist into `/docs/08-active/` with the active batch workspace
3. keep changes inside the documented primary surfaces unless a newly discovered dependency is recorded and approved in the active batch state

## Canonical Inputs

Use these canonical sources when Batch B starts:

* planning scope:
  * [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
  * [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* surface and route ownership:
  * [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
  * [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* UI standards and pattern checklists:
  * [UI Design System Standards](../../../02-standards/ui/UI%20Design%20System%20Standards.md)
  * [UI UX Component Library Standards](../../../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
  * [Tier 2 Pattern Library Checklist](../../../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)
  * [Tier 1 - Consumption And Composition Contract](../../../02-standards/ui/contracts/Tier%201%20-%20Consumption%20And%20Composition%20Contract.md)
* current support tracking:
  * [UI UX Contract Rollout Tracker](../../../09-reference/ui/UI%20UX%20Contract%20Rollout%20Tracker.md)
  * [UI UX Tier 1 Implementation Form Inventory](../../../09-reference/ui/UI%20UX%20Tier%201%20Implementation%20Form%20Inventory.md)

## Surface Touch Matrix

| Surface | In Batch | Planned touch type | Constraints |
| --- | --- | --- | --- |
| Dashboard (`/dashboard`) | Yes | page-title/action-row parity, section/card/layout parity, dashboard-grid consistency | keep dashboard feature behavior unchanged |
| App shell (`resources/views/components/layouts/app.blade.php`) | Yes | navigation/layout parity, spacing, shared shell framing, responsive consistency | do not redesign account or notifications feature behavior |
| Setup shell (`/platform/setup/*`) | Yes | shared section/card/layout convergence and navigation parity | no module manifest redesign |
| Settings shell (`/platform/settings/*`) | Yes | form-section, action-row, and sub-navigation parity | no settings behavior rewrite |
| Account/profile shell (`/account*`) | Yes | internal shell parity, profile-form scaffolding parity, section/action consistency | do not redesign account feature behavior beyond shared internal shell/scaffolding rules |
| Header notification preview | Yes | shell framing and action affordance parity only | preserve current realtime behavior |
| Platform-owned operator-table views | Conditional | shared search/filter/table chrome only where needed for parity | do not reopen operational proof ownership decisions |
| Platform users migration surface | No | excluded from Batch B execution scope | future migration work only |
| Notifications inbox | No | excluded except incidental shell framing that does not change feature behavior | preserve feature ownership boundary |
| Account pages | No | excluded | future phase or separate batch only |
| Docs vault | No | excluded | locked custom exception remains |

## Tier 1 Library Hardening Prerequisite

Batch B should not start by assuming the current Tier 1 layer is already in its final consumable form. Before the batch leans on broader Tier 2 composition, it should normalize these Tier 1 items as first-pass deliverables:

| Tier 1 item | Batch B role | Expected output |
| --- | --- | --- |
| Button | required first-pass promotion | canonical Blade entry point with existing semantic/variant/size/loading behavior |
| Icon Button | required first-pass promotion | canonical Blade entry point with existing label/focus behavior |
| Toast baseline | required first-pass promotion | canonical Blade entry point with role/severity/dismissibility contract |
| Inline alert baseline | required first-pass promotion | canonical Blade entry point with role/severity/content contract |
| Modal baseline | required first-pass promotion | canonical Blade entry point with title/body/action-region contract |
| Drawer baseline | required first-pass promotion | canonical Blade entry point with title/body/action-region contract |

These promotions should be treated as Batch B’s first implementation lane, not as optional cleanup after Tier 2 work has already started depending on them.

## Tier 2 Pattern Targets

Patterns that Batch B should implement as the reusable internal app layer:

| Tier 2 pattern | Batch B target | Primary surfaces |
| --- | --- | --- |
| Form Group | required | settings, setup, account/profile |
| Form Section | required | settings, setup, account/profile |
| Inline Form Row | required where horizontal form layout is part of the reusable shell/scaffolding direction | settings, account/profile |
| Form Actions Bar | required | settings, setup, account/profile |
| Validation Summary | required | settings, account/profile, setup where applicable |
| Enhanced Data Table | required when Batch B touches an operator-table proof surface | touched table surfaces only |
| Data List Item | required | dashboard supporting lists, settings/read-only summaries where reused |
| Stat Card | required | dashboard, setup summary surfaces |
| Key Value Display | required | account/profile, setup, settings read-only summaries |
| Page Title And Actions Row | required | dashboard, settings, setup |
| Tab Panel System | conditional | only if a touched proof surface already uses tabbed peer content |
| Sub-navigation Bar | required where section navigation already exists | settings, setup |
| Breadcrumbs | conditional | only if a touched internal proof surface needs hierarchy context beyond the page title row |
| Empty State | required where a touched proof surface already needs shared no-data or no-results treatment | dashboard, touched table surfaces |
| Error State Block | conditional | only if a touched proof surface already has recoverable in-page error handling |
| Success State Block | conditional | only if a touched proof surface already has reusable in-page success confirmation treatment |
| Skeleton Loader Pattern | conditional | dashboard, table, and form proofs only where layout-matching loading treatment is already needed |
| Confirm Dialog | conditional | only if a touched proof surface already has short confirm flows that should be standardized now |
| Form Modal | conditional | only if a touched proof surface already uses a short reusable modal-edit pattern |
| Drawer Form | conditional | only if a touched proof surface already uses contextual drawer editing |
| Popover | conditional | only if a touched proof surface already needs anchored contextual content richer than a tooltip |
| Dropdown Action Menu | required where grouped actions already exist on touched proof surfaces | shell/header or touched table actions |
| Search And Filter Bar | required when a touched surface contains operator tables | platform-owned table surfaces touched in batch |
| Bulk Action Bar | conditional | only if a touched proof surface already uses reusable selection-state actions |
| Segmented Control | conditional | only if a touched proof surface already uses compact peer-option switching |
| Split View | conditional | only if a touched proof surface already needs reusable list-and-detail layout proof |
| Dashboard Grid | required | dashboard |
| Content Section Block | required | dashboard, settings, setup |
| Context Menu | deferred | not part of the Batch B contract |

Patterns that remain conditional or deferred should not be promoted into required scope during execution unless the active planning note is updated first. Batch B should not quietly broaden itself by treating conditional patterns as automatically in scope.

## Internal Shell And Scaffolding Outputs

Batch B should also leave behind explicit reusable internal app-surface rules for:

* dashboard shell
* app shell
* setup shell
* settings shell
* account/profile shell

And the following page/module scaffolding archetypes:

* dashboard/overview surface
* list/index surface
* detail/read-only surface
* create/edit form surface
* setup/configuration surface
* settings surface

These outputs should define:

* title/action placement
* section and card usage
* widget-shell and stat-card rules
* empty/loading/error treatment expectations
* where sub-navigation belongs
* where settings/setup registration hooks appear for future modules

## Required Handoff Artifacts

Batch B should leave behind reviewable artifacts, not only implemented proof surfaces. At minimum, the batch should produce:

* a shell-family rule matrix covering dashboard, app shell, setup, settings, and account/profile surfaces
* a page/module archetype matrix covering dashboard/overview, list/index, detail/read-only, create/edit form, setup/configuration, and settings surfaces
* a setup/settings registration field contract that later modules must follow
* a future-module UI ownership declaration field contract that later Phase 3 and Phase 4 plans must complete before coding
* UI reference examples for every required Tier 2 pattern implemented in the batch
* proof coverage for the Tier 1 Blade-component promotions that Batch B normalizes first

Current Batch B support-artifact targets:

* [Phase 2 Batch B - Internal Shell Family Rule Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Internal%20Shell%20Family%20Rule%20Matrix.md)
* [Phase 2 Batch B - Page And Module Archetype Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)
* [Phase 2 Batch B - Setup And Settings Registration Field Contract](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Setup%20And%20Settings%20Registration%20Field%20Contract.md)
* [Phase 2 Batch B - Future Module UI Ownership Declaration Field Contract](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Future%20Module%20UI%20Ownership%20Declaration%20Field%20Contract.md)

## Proof-Page Matrix

Batch B should leave behind an explicit proof-page map so manual review can find each required pattern and archetype intentionally.

| Proof artifact | Type | Required coverage | Minimum states / variants |
| --- | --- | --- | --- |
| Actions baseline proof page | UI Reference proof page | Button, Icon Button through the promoted Blade entry points | default, hover/focus snapshots where review requires them, disabled, loading, icon-only, responsive action-row composition |
| Feedback baseline proof page | UI Reference proof page | Toast baseline and Inline alert baseline through the promoted Blade entry points | neutral/success/warning/danger/info/notice, dismissible vs non-dismissible where applicable, reduced-motion-safe behavior |
| Overlay baseline proof page | UI Reference proof page | Modal baseline and Drawer baseline through the promoted Blade entry points | default, destructive confirm, loading/disabled primary action, mobile/desktop readability |
| Forms pattern page | UI Reference pattern page | Form Group, Form Section, Inline Form Row, Form Actions Bar, Validation Summary | default, focus/error where applicable, disabled/loading where applicable, responsive form layout |
| Data and content pattern page | UI Reference pattern page | Data List Item, Stat Card, Key Value Display, Empty State, Content Section Block | default, empty, loading where applicable, responsive card/list layout |
| Navigation and action pattern page | UI Reference pattern page | Page Title And Actions Row, Sub-navigation Bar, Dropdown Action Menu, Search And Filter Bar | default, hover/focus/active where applicable, overflow-safe navigation, active-filter state where applicable |
| Tables and advanced data pattern page | UI Reference pattern page | Enhanced Data Table plus Search And Filter Bar when table-oriented proof is needed | default, loading, empty, selection-active where applicable, filter/reset behavior |
| Layout and dashboard pattern page | UI Reference pattern page or dedicated proof page | Dashboard Grid plus Stat Card composition rules | default, loading where applicable, single-row and multi-row layout |
| Dashboard/overview archetype proof | proof surface page | shell-family, widget-shell, title/action, section, summary-card composition | desktop/mobile layout, empty/loading states where applicable |
| List/index archetype proof | proof surface page | page-title, search/filter, table/list, grouped actions, empty-state composition | desktop/mobile layout, empty/loading/filter-active states where applicable |
| Detail/read-only archetype proof | proof surface page | key-value display, section/block structure, action placement | default and responsive read-only layout |
| Create/edit form archetype proof | proof surface page | form group/section/row/actions/validation composition | default, error, disabled/loading, responsive form layout |
| Setup/configuration archetype proof | proof surface page | setup shell, sectioning, sub-navigation where applicable, registration-hook placement | desktop/mobile shell behavior, empty/loading states where applicable |
| Settings archetype proof | proof surface page | settings shell, sub-navigation, form scaffolding, action placement, registration-hook placement | desktop/mobile shell behavior, error/loading states where applicable |
| Account/profile archetype proof | proof surface page | shared internal form/read-only scaffolding proof only | desktop/mobile shell behavior, edit/read-only parity where applicable |

The exact file layout may reuse or expand existing UI Reference pages, but the batch should not close without a clear final page map covering each row above.

## Allowed Route And Navigation Cleanup

Allowed in Batch B:

* shell-visible navigation cleanup for already-owned platform routes
* cleanup of shared-shell links and labels that support the converged Phase 2 surface model
* alignment of existing administration and operations aliases with the current shell/navigation direction
* route ownership cleanup that does not choose a new long-term panel architecture

Blocked in Batch B:

* selecting between long-term panel options
* final panel path rewrite
* auth guard or session-boundary redesign
* retirement of direct `/console` proof paths as an architecture decision
* broad route renaming for future tenant/shared-core unification

## Recommended Execution Order

1. confirm the Tier 1 components and UI reference examples Batch B will consume
2. implement the promoted Tier 1 Blade-component candidates and their proof coverage first
3. implement the required Tier 2 internal patterns and UI reference examples
4. normalize shared shell and page-title/action-row parity
5. normalize dashboard card/section/grid/widget-shell parity
6. normalize setup, settings, and account/profile shell scaffolding
7. define the shell-family matrix and page/module archetype matrix the batch will leave behind
8. define setup/settings registration expectations and future-module UI ownership handoff rules
9. apply shared table/search/filter parity only where the batch actually touches operator-table surfaces
10. complete limited route/navigation cleanup
11. build or expand the required proof pages and archetype proofs so every required pattern is reviewable intentionally
12. sync UI reference and planning notes for touched Tier 1 promotions, Tier 2 patterns, and internal scaffolding outputs

## Verification Checklist

Before Batch B is review-ready, verify:

* the promoted Tier 1 action, feedback, and overlay components render through their canonical entry points rather than fallback demo-only markup
* desktop and mobile behavior for dashboard, shell, setup, and settings
* page-title and action-row consistency across touched surfaces
* section, card, and grid spacing parity across touched surfaces
* dashboard widget-shell and stat-card consistency where adopted
* account/profile shell parity where that surface is used as proof coverage for internal form scaffolding
* operator table control-row and filter behavior parity where touched
* shared-shell navigation behavior and active-state behavior
* header notification preview behavior remains functionally unchanged
* required handoff artifacts exist and are explicit enough for later phases to inherit without reopening Batch B design questions
* the final proof-page map covers every required Tier 2 pattern and every required archetype proof
* setup/settings registration expectations are explicit enough for later module work
* future-module UI ownership declaration requirements are explicit enough for later phases
* no touched change quietly introduced account, notifications-inbox, or platform-users feature work
* no touched change quietly chose a final panel-topology answer

## Batch-Start Checklist

Before opening implementation:

* confirm the implementation plan for the promoted Tier 1 Blade-component candidates and the proof pages that will verify them
* confirm the required Tier 2 pattern contract remains accurate for the batch and record any approved changes before implementation starts
* confirm which internal shell families and page/module scaffolding archetypes Batch B is responsible for locking
* confirm which operator-table surfaces, if any, are in the first Batch B pass
* confirm whether any route cleanup is purely shell-visible or would cross into blocked panel-architecture territory
* confirm the UI reference examples needed for each touched Tier 2 pattern
* confirm the final proof-page map for required Tier 2 patterns and archetype proofs before implementation starts
* confirm where each required handoff artifact will be captured and linked at close-out
* confirm the setup/settings registration expectations and future-module UI ownership declaration fields later phases will inherit
* confirm Batch E visual-QA expectations that Batch B should leave behind

## Related

* [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
