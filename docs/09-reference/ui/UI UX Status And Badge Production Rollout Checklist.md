# UI UX Status And Badge Production Rollout Checklist

This document defines the canonical scope and intent for UI UX Status And Badge Production Rollout Checklist.

## Purpose

Define the production rollout checklist for migrating non-reference surfaces to the locked status/badge baseline.

This note is non-canonical support documentation for execution/rollout tracking.

Canonical UI standards references:

- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
- [Tier 1 - Badges And Status Contract](../../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)

## Implementation Status

Current status:

- UI reference status/badge baseline is locked
- shared Blade components exist: `<x-ui.badge>`, `<x-ui.status>`, `<x-ui.status-icon>`
- one-line status pill rendering fix is shipped
- production rollout is pending across remaining app-owned surfaces

## Rollout Scope

In scope:

1. replace ad-hoc badge/status markup with shared status components
2. normalize status labels to canonical taxonomy before rendering
3. enforce one-line status pill behavior in table/card/filter contexts
4. preserve light/dark and WCAG 2.2 AA behavior

Out of scope:

1. introducing new semantic roles
2. changing Filament-native badge internals outside configured mapping rules

## Target Surfaces

Priority order:

1. `resources/views/platform/notifications/index.blade.php`
2. `resources/views/platform/*` operational list/detail surfaces with status/severity chips
3. Livewire/Filament views that currently render custom ad-hoc badge classes

## Execution Checklist

### Mapping and contracts

- [ ] confirm canonical label mapping for each surface (`pending review`, `under review`, `needs action`, `non-compliant`, `out of sync`)
- [ ] verify semantic mapping is consistent with status taxonomy
- [ ] verify icon policy per semantic role and contextual override rules

### Rendering migration

- [ ] replace ad-hoc status spans with `<x-ui.badge>` for pill/tag contexts
- [ ] replace ad-hoc inline status text with `<x-ui.status>` where lower emphasis is needed
- [ ] remove duplicated one-off status color classes after migration

### QA gates

- [ ] light/dark visual parity check on each migrated surface
- [ ] keyboard + screen reader check (text-first meaning, no color-only signaling)
- [ ] table/card responsive check confirms one-line pill behavior
- [ ] regression check on log-table drawers and filter-chip contexts

### Close-out

- [ ] update matrix row production status for Badge / Status Pill from `In Progress` to `Ready For Review`
- [ ] stage or apply canonical doc updates for any behavior changes discovered during rollout
- [ ] lock production status only after final visual QA sign-off

## Related

- [Tier 1 - Badges And Status Contract](../../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)
- [UI UX Component Taxonomy And Coverage Matrix](../../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
