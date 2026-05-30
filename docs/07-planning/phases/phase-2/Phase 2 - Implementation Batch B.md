# Phase 2 - Implementation Batch B

This document defines the canonical scope and intent for Phase 2 - Implementation Batch B.

## Purpose

Implement Tier 2 patterns and adopt the locked UI system across converging platform surfaces.

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

Deliver Tier 2 pattern adoption and platform surface convergence for current platform-owned dashboard and shared shell surfaces using existing UI standards and locked Tier 1 foundations.

## Batch Scope Boundary

This batch is a shared-surface convergence batch, not a feature-behavior batch and not a panel-architecture decision batch.

Batch B may:

* adopt reusable Tier 2 patterns on current platform-owned surfaces
* normalize current dashboard and shell layout behavior to the locked UI baseline
* perform limited route/navigation cleanup that stays inside already-selected Phase 2 ownership direction

Batch B must not:

* redefine UI standards
* redesign feature behavior
* decide final Filament panel topology
* retire `/console` proof paths as a Phase 2 architecture decision
* expand into future-phase feature modules

## Primary Surfaces

Primary implementation surfaces for this batch:

* dashboard (`/dashboard`)
* app shell (`resources/views/components/layouts/app.blade.php`)
* setup shell (`/platform/setup/*`)
* settings shell (`/platform/settings/*`)
* header notification preview as shell-owned behavior

Secondary or conditional surfaces:

* platform-owned operator-table views only when needed to align shared table and filter patterns already locked in standards

Explicit non-targets for this batch:

* account pages
* notifications inbox feature behavior
* messaging
* docs vault
* platform-users migration strategy
* tenant-facing or customer-facing UI

## In Scope

* shared layout convergence across dashboard and shell-owned surfaces
* shared navigation convergence for the current platform-owned shell
* Tier 2 pattern adoption using existing Tier 1 primitives only
* operator table and filter pattern adoption where those surfaces are already in current platform-owned scope
* responsive behavior convergence for dashboard, setup, settings, and shell surfaces
* limited route and navigation cleanup required for the converged shell without reopening final panel-architecture decisions
* UI reference and documentation updates required to show the applied Tier 2 patterns

## Out Of Scope

* creation of new UI standards
* creation of new Tier 1 primitives
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

1. Tier 2 pattern implementation scope is explicit.
2. Exact surface touch scope is explicit for dashboard, shell, setup, settings, and any conditional table surfaces.
3. Dashboard and shell adoption scope is bounded to existing UI standards and current Tier 1 outputs.
4. Table and responsive adoption scope is explicitly limited to dashboard and shell-owned surfaces.
5. Route and navigation cleanup scope is linked to current ownership notes and explicitly narrowed away from unresolved panel-topology decisions.
6. Verification scope is defined for desktop, mobile, navigation, responsive layout, and touched Tier 2 pattern behavior.
7. Clear statement that feature-specific UI behavior is deferred to future phase.

## Entry Gates

* Batch A is complete.
* Batch A outputs clearly identify which Tier 1 components and UI reference examples are available for reuse.
* dashboard and shell owner references are current.
* current Phase 2 route and panel ownership notes are current enough to define the allowed cleanup boundary for this batch.
* the Batch B prep note is current.

## Exit Criteria

This batch is complete when:

* dashboard and shell convergence scope is implementable without feature ambiguity
* touched surfaces and excluded surfaces are explicitly documented
* standards references are explicit
* allowed route and navigation cleanup stays within the documented boundary
* non-UI and feature-specific work remain excluded from this batch
* Batch E can start from a clear visual-QA and close-out target

## Validation Surface

Validation for this batch should cover:

* desktop and mobile shell behavior on touched surfaces
* page-title, action-row, section, and card consistency where adopted
* operator table/search/filter parity where touched
* dashboard layout and widget-shell consistency
* settings and setup responsive layout consistency
* shell-owned notification preview parity after any shell framing updates
* confirmation that no feature behavior or panel-architecture decisions were introduced implicitly

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Batch B Implementation Prep](Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [Tier 2 Pattern Library Checklist](../../../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)
* [UI UX Contract Rollout Tracker](../../../09-reference/ui/UI%20UX%20Contract%20Rollout%20Tracker.md)
