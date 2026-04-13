# Phase 2 - Implementation Batch 10

## Purpose

Establish a universal CalendarEntry base object and module extension contract as the shared cross-cutting calendar engine, so future modules integrate by attaching rather than creating parallel calendar systems.

## Implementation Status

Current status:

* contract-complete
* implementation-ready for future-phase sequencing
* code delivery remains out of scope for this Phase 2 contract batch

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Features/Calendar And CalendarEntry Contract]] | [Calendar And CalendarEntry Contract](../../Features/Calendar%20And%20CalendarEntry%20Contract.md)

## Batch Goal

Deliver a locked CalendarEntry data contract and module extension pattern so the calendar foundation is implementation-ready and Phase 4 modules can integrate by type registration rather than building parallel calendar engines.

## Locked Architecture Direction

Batch 10 uses one shared calendar engine:

* `CalendarEntry` as the universal base calendar object
* `calendar_entry_types` as the module-driven type registry (color, visibility, owning module)
* `source_type` / `source_id` as the polymorphic bridge from module-owned records to calendar entries

Module-specific calendar presences must not create separate parallel calendar engines. They attach to the same core CalendarEntry model using source linkage and module-specific type registration.

This keeps the calendar engine comparable to the messaging engine from Batch 9: foundational, cross-module, and owned by the core platform.

## Core Data Contract (Planned)

Planned baseline entities:

* `calendar_entries`
  * id
  * title
  * source_type (nullable string; e.g. `invoice`, `task`, `project`, `reminder`, `standalone`)
  * source_id (nullable; matches the originating module record id)
  * status (`active`, `draft`, `cancelled`)
  * start_at
  * end_at (nullable)
  * all_day (boolean)
  * owner_user_id (nullable)
  * tenant_id
  * metadata (json, nullable)
  * timestamps
* `calendar_entry_types`
  * id
  * key (unique string; e.g. `invoice`, `task`, `lead_reminder`)
  * label
  * color (hex string)
  * visible_by_default (boolean)
  * owning_module (nullable string; null = core platform)
  * timestamps

## In Scope

* `CalendarEntry` base object naming, field contract, and state model
* `calendar_entry_types` type registration contract (key, label, color, visibility, owning module)
* module extension pattern: how a module registers a calendar entry type and contributes entries via source linkage
* settings ownership contract:
  * general tab: default view, first day of week, entry limit per view, per-type visibility toggles
  * styling tab: per-type color picker
  * module settings mirror: each module owning a type also exposes the same toggle and color in its own module settings section
* UI and view behavior contract: month view, week view, day view, events table (all past and present entries), counters (total, active, draft)
* V1 filterable entry type parity reference list (as migration target, not implementation)
* naming contract lock: `CalendarEntry` / `calendar_entries` active; `event` retired as calendar base-object label; `CalendarItem` not used
* canonical calendar feature doc creation and index sync

## Out Of Scope

* database migrations, model classes, Filament or Livewire view implementations
* individual module type implementations (invoices, tasks, projects, reminders)
* V1 calendar code port
* module settings implementation for specific Phase 4 modules
* customer-facing calendar surfaces
* Events-module (separate module feature; shares no base object with CalendarEntry)

## Required Deliverables

1. `CalendarEntry` data model and field contract documented and locked.
2. `calendar_entry_types` registration contract documented and locked.
3. Module extension pattern documented: source linkage, type registration, settings mirror rule.
4. Settings ownership contract documented: general tab, styling tab, and module settings parity.
5. UI behavior contract documented: view types, events table, counter definitions, filter dimensions.
6. V1 entry type parity reference list for Phase 4 module integration.
7. Canonical calendar feature doc created and linked bidirectionally with this planning note.
8. Phase 2 Index, Feature Index, Phase 2 Final Stack Planning, and Development Log updated.

## Verification

Verification focus:

* `CalendarEntry` / `calendar_entries` terminology consistent across all updated docs; no `event` base-term usage in new docs
* bidirectional links confirmed between this planning note and the canonical calendar feature note
* module extension rule matches the Batch 9 context-linkage pattern for architectural consistency
* settings ownership contract is explicit about platform general versus module-mirrored ownership
* type registration table schema is unambiguous and sufficient for Phase 4 module onboarding

## Exit Criteria

This batch is complete when:

* `CalendarEntry` and `calendar_entry_types` contracts are locked and documented in the canonical feature note
* module extension and type registration pattern is documented without ambiguity
* settings and UI behavior contracts are documented and consistent with V1 parity targets
* bidirectional links between planning note and canonical owner are confirmed
* Phase 2 Index, Feature Index, Phase 2 Final Stack Planning, and Development Log are updated and synchronized

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 9]] | [Phase 2 - Implementation Batch 9](Phase%202%20-%20Implementation%20Batch%209.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Features/Calendar And CalendarEntry Contract]] | [Calendar And CalendarEntry Contract](../../Features/Calendar%20And%20CalendarEntry%20Contract.md)
