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
* current support tracking:
  * [UI UX Contract Rollout Tracker](../../../09-reference/ui/UI%20UX%20Contract%20Rollout%20Tracker.md)

## Surface Touch Matrix

| Surface | In Batch | Planned touch type | Constraints |
| --- | --- | --- | --- |
| Dashboard (`/dashboard`) | Yes | page-title/action-row parity, section/card/layout parity, dashboard-grid consistency | keep dashboard feature behavior unchanged |
| App shell (`resources/views/components/layouts/app.blade.php`) | Yes | navigation/layout parity, spacing, shared shell framing, responsive consistency | do not redesign account or notifications feature behavior |
| Setup shell (`/platform/setup/*`) | Yes | shared section/card/layout convergence and navigation parity | no module manifest redesign |
| Settings shell (`/platform/settings/*`) | Yes | form-section, action-row, and sub-navigation parity | no settings behavior rewrite |
| Header notification preview | Yes | shell framing and action affordance parity only | preserve current realtime behavior |
| Platform-owned operator-table views | Conditional | shared search/filter/table chrome only where needed for parity | do not reopen operational proof ownership decisions |
| Platform users migration surface | No | excluded from Batch B execution scope | future migration work only |
| Notifications inbox | No | excluded except incidental shell framing that does not change feature behavior | preserve feature ownership boundary |
| Account pages | No | excluded | future phase or separate batch only |
| Docs vault | No | excluded | locked custom exception remains |

## Tier 2 Pattern Targets

Patterns that Batch B should be ready to apply:

| Tier 2 pattern | Batch B target | Primary surfaces |
| --- | --- | --- |
| Page Title And Actions Row | required | dashboard, settings, setup |
| Sub-navigation Bar | required where section navigation already exists | settings, setup |
| Dashboard Grid | required | dashboard |
| Stat Card | required where dashboard or summary cards already exist | dashboard, setup |
| Content Section Block | required | dashboard, settings, setup |
| Form Section | required where grouped forms already exist | settings |
| Form Actions Bar | required where page-level save/cancel actions already exist | settings |
| Search And Filter Bar | required when a touched surface contains operator tables | platform-owned table surfaces touched in batch |
| Enhanced Data Table | conditional | touched table surfaces only |
| Empty State | conditional | touched dashboard or table surfaces that currently need shared no-data treatment |
| Dropdown Action Menu | conditional | shell/header or touched table actions where grouped actions already exist |

Patterns explicitly not required unless a touched surface already depends on them:

* breadcrumbs
* segmented control
* bulk action bar
* confirm dialog
* form modal
* drawer form
* context menu
* split view
* success and error state blocks outside already-touched shared surfaces

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
2. normalize shared shell and page-title/action-row parity
3. normalize dashboard card/section/grid parity
4. normalize setup and settings shell surfaces
5. apply shared table/search/filter parity only where the batch actually touches operator-table surfaces
6. complete limited route/navigation cleanup
7. sync UI reference and planning notes for touched Tier 2 patterns

## Verification Checklist

Before Batch B is review-ready, verify:

* desktop and mobile behavior for dashboard, shell, setup, and settings
* page-title and action-row consistency across touched surfaces
* section, card, and grid spacing parity across touched surfaces
* operator table control-row and filter behavior parity where touched
* shared-shell navigation behavior and active-state behavior
* header notification preview behavior remains functionally unchanged
* no touched change quietly introduced account, notifications-inbox, or platform-users feature work
* no touched change quietly chose a final panel-topology answer

## Batch-Start Checklist

Before opening implementation:

* confirm which Tier 2 patterns are actually needed by the current surfaces
* confirm which operator-table surfaces, if any, are in the first Batch B pass
* confirm whether any route cleanup is purely shell-visible or would cross into blocked panel-architecture territory
* confirm the UI reference examples needed for each touched Tier 2 pattern
* confirm Batch E visual-QA expectations that Batch B should leave behind

## Related

* [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
