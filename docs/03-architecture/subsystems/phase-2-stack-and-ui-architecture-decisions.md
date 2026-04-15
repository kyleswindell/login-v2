# Phase 2 Stack And UI Architecture Decisions

This document defines the canonical scope and intent for Phase 2 Stack And UI Architecture Decisions.

## Purpose

Capture durable architecture decisions extracted from Phase 2 planning.

## Canonical Decisions

- the product experience is one coherent app across shared-core and platform-management surfaces
- `/console` proof paths are transitional and not long-term product boundaries
- UI ownership is declared per surface (custom Blade, Filament, or hybrid)
- app shell and route ownership remain explicit between app-owned and panel-owned surfaces
- realtime notification transport remains Reverb/Echo for this generation
- platform and tenant instances share base UX conventions while preserving explicit boundary controls

## Route And Panel Boundary Direction

- route and panel boundaries are explicit before broad surface expansion
- transitional routes may exist for migration but do not replace canonical ownership
- platform-to-tenant access remains explicit and auditable

## Related

- [Final Stack And UI Boundary](final-stack-and-ui-boundary.md)
- [Platform Boundary](../platform-boundary.md)
- [Phase 2 - Final Stack And UI System Planning](../../07-planning/phases/phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
