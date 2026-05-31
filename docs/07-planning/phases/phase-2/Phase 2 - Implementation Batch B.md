# Phase 2 - Implementation Batch B

This document defines the canonical scope and intent for Phase 2 - Implementation Batch B.

## Purpose

Implement the remaining Tier 1 library hardening required for safe reuse, then deliver the reusable Tier 2 internal UI library and the internal app-surface scaffolding standards that later phases will consume.

## Planning Owner

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

## Planning Companion

* [Phase 2 - Batch B Implementation Prep](Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)

## Canonical Owners

* [UI Design System Standards](../../../02-standards/ui/UI%20Design%20System%20Standards.md)
* [UI UX System Index](../../../02-standards/ui/UI%20UX%20System%20Index.md)
* [UI UX Component Library Standards](../../../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
* [Tier 2 Pattern Library Checklist](../../../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)
* [Dashboard](../../../04-features/dashboard/dashboard.md)

## Batch Goal

Deliver the promoted Tier 1 library hardening pass plus the reusable Tier 2 pattern layer and the internal shell/scaffolding contracts needed so future phases can add modules and customer/public work without inventing internal UI structure ad hoc.

## Batch Scope Boundary

This batch is an internal UI-system implementation and proof batch, not a feature-behavior batch and not a panel-architecture decision batch.

Batch B may:

* implement the promoted Tier 1 Blade-component candidates that Batch A left directionally defined but not yet normalized
* implement reusable Tier 2 patterns for current internal app surfaces
* define and prove internal shell-family standards and page/module scaffolding archetypes
* normalize current dashboard and shell layout behavior only where needed to validate those shared internal patterns
* perform limited route/navigation cleanup that stays inside already-selected Phase 2 ownership direction and only where needed to support the internal shell/scaffolding direction

Batch B must not:

* redefine UI standards
* redesign feature behavior
* decide final Filament panel topology
* retire `/console` proof paths as a Phase 2 architecture decision
* expand into future-phase feature modules

## Tier 1 Library Hardening Prerequisite

Batch B begins with a narrow Tier 1 library hardening pass before broader Tier 2 implementation continues.

Required first-pass Tier 1 promotions:

* Button
* Icon Button
* Toast baseline
* Inline alert baseline
* Drawer baseline
* Modal baseline

This prerequisite exists because Batch A closed with these items directionally validated but still exposed primarily through class/markup contracts. Batch B should normalize them into canonical Blade-component entry points before the new Tier 2 library starts depending on them more deeply.

## Primary Surfaces

Primary proof and implementation surfaces for this batch:

* dashboard (`/dashboard`)
* app shell (`resources/views/components/layouts/app.blade.php`)
* setup shell (`/platform/setup/*`)
* settings shell (`/platform/settings/*`)
* account/profile shell where shared internal shell or form-scaffolding rules need proof coverage
* header notification preview as shell-owned behavior

Secondary or conditional surfaces:

* platform-owned operator-table views only when needed to align shared table and filter patterns already locked in standards

Explicit non-targets for this batch:

* account feature behavior beyond shared shell/scaffolding proof coverage
* notifications inbox feature behavior
* messaging
* docs vault
* platform-users migration strategy
* tenant-facing or customer-facing UI

## Tier 2 Disposition Contract

Batch B must not rediscover its core Tier 2 library scope at execution time. The pattern-disposition contract for this batch is:

### Required Tier 2 patterns

These patterns are part of the stable internal library Batch B is expected to leave behind and should be implemented plus represented in the UI reference during this batch:

* Form Group
* Form Section
* Inline Form Row
* Form Actions Bar
* Validation Summary
* Enhanced Data Table
* Data List Item
* Stat Card
* Key Value Display
* Page Title And Actions Row
* Sub-navigation Bar
* Empty State
* Dropdown Action Menu
* Search And Filter Bar
* Dashboard Grid
* Content Section Block

### Conditional Tier 2 patterns

These patterns may be implemented in Batch B only if an already-selected internal proof surface requires them to complete the reusable internal shell/scaffolding direction cleanly:

* Tab Panel System
* Breadcrumbs
* Error State Block
* Success State Block
* Skeleton Loader Pattern
* Confirm Dialog
* Form Modal
* Drawer Form
* Popover
* Bulk Action Bar
* Segmented Control
* Split View

### Deferred Tier 2 patterns

These patterns stay out of the Batch B contract unless a later planning pass explicitly reassigns them:

* Context Menu

## In Scope

* implementation of the promoted Tier 1 Blade-component candidates listed in the Tier 1 library hardening prerequisite
* Tier 2 pattern implementation using existing Tier 1 primitives only
* internal shell family standards for dashboard, app shell, setup, settings, and account/profile surfaces
* reusable page/module scaffolding archetypes for dashboard, list/detail, form, setup, and settings surfaces
* dashboard widget-shell and summary/stat-card conventions
* setup/settings registration conventions for future modules
* future-module UI ownership declaration requirements for later phases
* shared layout convergence across dashboard and shell-owned proof surfaces where needed to validate the internal library/scaffolding direction
* operator table and filter pattern implementation where those surfaces are already in current platform-owned scope
* responsive behavior convergence for dashboard, setup, settings, and shell proof surfaces
* limited route and navigation cleanup required for the converged internal shell direction without reopening final panel-architecture decisions
* UI reference and documentation updates required to show the implemented Tier 2 patterns and internal scaffolding direction

## Out Of Scope

* creation of new UI standards
* creation of new Tier 1 primitives beyond the explicitly promoted Tier 1 Blade-component candidates already directionally approved
* account feature behavior
* notifications feature behavior
* notification persistence or realtime redesign
* messaging
* platform-users Filament migration strategy
* final panel option selection
* auth guard/session redesign
* final `/console` proof-route retirement decision
* staging deploy and visual QA

## Required Deliverables

1. The promoted Tier 1 Blade-component candidates are implemented and represented through reviewable proof coverage before broader Tier 2 implementation closes.
2. The Batch B Tier 2 disposition contract is explicit, and the required Tier 2 patterns are implemented and represented in the UI reference.
3. Internal shell family standards are explicit for dashboard, app shell, setup, settings, and account/profile surfaces.
4. Reusable page/module scaffolding archetypes are explicit for dashboard/overview, list/detail, form, setup, and settings surfaces.
5. Dashboard widget-shell and summary/stat-card conventions are explicit enough for later modules to reuse.
6. Setup/settings registration conventions and future-module UI ownership declaration requirements are explicit for Phase 4 planning.
7. Exact proof-touch scope is explicit for dashboard, shell, setup, settings, account/profile, and any conditional table surfaces used to validate the shared internal direction.
8. Route and navigation cleanup scope is linked to current ownership notes and explicitly narrowed away from unresolved panel-topology decisions.
9. Verification scope is defined for desktop, mobile, navigation, responsive layout, touched Tier 2 pattern behavior, the promoted Tier 1 candidates, and the internal shell/scaffolding contracts Batch B leaves behind.
10. Clear statement that feature-specific UI behavior, customer/public shells, and module-specific business workflows are deferred to later phases.
11. Concrete handoff artifacts are produced for later phases:
    * shell-family rule matrix
    * page/module archetype matrix
    * setup/settings registration field contract
    * future-module UI ownership declaration field contract
12. Reviewable proof-page coverage is explicit for both:
    * promoted Tier 1 proof pages or proof surfaces
    * required Tier 2 pattern pages in UI Reference
    * archetype proof pages or proof surfaces used to validate the internal shell/scaffolding contract

## Entry Gates

* Batch A is complete.
* Batch A outputs clearly identify which Tier 1 components and UI reference examples are available for reuse.
* the Tier 1 promotion decisions for buttons, feedback, and overlays are explicit enough to implement as the first Batch B deliverable.
* dashboard and shell owner references are current.
* current Phase 2 route and panel ownership notes are current enough to define the allowed cleanup boundary for this batch.
* the Batch B prep note is current.

## Exit Criteria

This batch is complete when:

* the required internal Tier 2 patterns are implemented and visible in the UI reference
* the promoted Tier 1 Blade-component candidates are implemented and reviewable before the dependent Tier 2 compositions close
* internal shell family standards and page/module scaffolding archetypes are explicit enough for future module work to consume
* the required handoff artifacts for shell families, page/module archetypes, setup/settings registration, and UI ownership declarations are explicit and reviewable
* touched proof surfaces and excluded surfaces are explicitly documented
* standards references are explicit
* allowed route and navigation cleanup stays within the documented boundary
* non-UI, customer/public, and feature-specific work remain excluded from this batch
* Batch E can start from a clear internal-surface visual-QA and close-out target

## Validation Surface

Validation for this batch should cover:

* the promoted Tier 1 action, feedback, and overlay entry points that Batch B is expected to normalize first
* desktop and mobile shell behavior on touched surfaces
* shell-family consistency across dashboard, setup, settings, and account/profile proof surfaces
* page/module scaffolding consistency across dashboard, list/detail, form, setup, and settings proof surfaces
* dashboard widget-shell and summary/stat-card consistency where adopted
* page-title, action-row, section, and card consistency where adopted
* operator table/search/filter parity where touched
* dashboard layout and widget-shell consistency
* settings and setup responsive layout consistency
* shell-owned notification preview parity after any shell framing updates
* confirmation that setup/settings registration and future-module UI ownership requirements are documented clearly enough for later phases
* confirmation that no feature behavior or panel-architecture decisions were introduced implicitly

## Proof-Page Coverage Contract

Batch B should leave behind explicit reviewable proof-page coverage, not only component implementations. The minimum proof-page contract is:

### Required Tier 1 proof coverage

Batch B should provide reviewable proof coverage for the Tier 1 candidates it promotes before the broader Tier 2 library depends on them:

* action baseline proof
  * Button
  * Icon Button
* feedback baseline proof
  * Toast baseline
  * Inline alert baseline
* overlay baseline proof
  * Modal baseline
  * Drawer baseline

### Required UI Reference pattern-page coverage

Batch B should provide reviewable pattern coverage for:

* form patterns
  * Form Group
  * Form Section
  * Inline Form Row
  * Form Actions Bar
  * Validation Summary
* data and content patterns
  * Enhanced Data Table
  * Data List Item
  * Stat Card
  * Key Value Display
  * Empty State
  * Content Section Block
* navigation and action patterns
  * Page Title And Actions Row
  * Sub-navigation Bar
  * Dropdown Action Menu
  * Search And Filter Bar
* layout patterns
  * Dashboard Grid

These may expand existing UI Reference pattern pages or introduce new ones, but the final page map must make each required Tier 2 pattern easy to locate and review intentionally.

### Required archetype proof coverage

In addition to raw pattern pages, Batch B should leave behind reviewable proof coverage for these internal archetypes:

* dashboard/overview proof
* list/index proof
* detail/read-only proof
* create/edit form proof
* setup/configuration proof
* settings proof
* account/profile proof where that surface is used to validate shared internal shell/scaffolding rules

### Minimum page-level coverage expectations

Across the required UI Reference pages and archetype proofs, Batch B review should be able to inspect:

* default presentation
* applicable interaction states required by the Tier 2 checklist
* responsive behavior where the pattern or archetype changes materially across breakpoints
* empty, loading, and error/success variants where the pattern contract requires them
* composition usage on at least one real internal proof surface where the pattern is meant to be reused in context

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Batch B Implementation Prep](Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [Tier 2 Pattern Library Checklist](../../../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)
* [UI UX Contract Rollout Tracker](../../../09-reference/ui/UI%20UX%20Contract%20Rollout%20Tracker.md)
* [Phase 2 Batch B - Internal Shell Family Rule Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Internal%20Shell%20Family%20Rule%20Matrix.md)
* [Phase 2 Batch B - Page And Module Archetype Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)
