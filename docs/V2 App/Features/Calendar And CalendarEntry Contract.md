# Calendar And CalendarEntry Contract

## Purpose

Define the universal CalendarEntry base object, module extension pattern, type registration contract, settings contract, and UI behavior contract for the platform calendar system.

This note is the canonical system owner for all calendar domain behavior. The planning source for the initial delivery is Phase 2 Batch 10.

## Implementation Status

Current status:

* contract drafted, not yet implemented

Planning source:

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 10]] | [Phase 2 - Implementation Batch 10](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%2010.md)

## Naming Reference

| Term | Status | Notes |
|------|--------|-------|
| `CalendarEntry` | Active — use this | Universal base calendar object; table `calendar_entries` |
| `event` | Retired as base term | Reserved for Events-module domain only; not used as a calendar base-object label |
| `CalendarItem` / `calendar-item` | Not used | Ruled out due to UI component vocabulary ambiguity |

## Base Object

### Fields — `calendar_entries`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | Primary key |
| `title` | string | Display label for the calendar entry |
| `source_type` | string (nullable) | Module source type; e.g. `invoice`, `task`, `reminder`, `standalone` |
| `source_id` | string/bigint (nullable) | ID of the originating module record |
| `status` | enum | `active`, `draft`, `cancelled` |
| `start_at` | datetime | Start of the calendar entry |
| `end_at` | datetime (nullable) | End; null implies single-point or all-day |
| `all_day` | boolean | When true, time values are ignored in display |
| `owner_user_id` | bigint (nullable) | User responsible for the entry, if applicable |
| `tenant_id` | bigint | Tenant owner; required |
| `metadata` | json (nullable) | Optional module-supplied supplementary data |
| `timestamps` | — | `created_at`, `updated_at` |

### State Model

* `active` — visible on calendar and in the events table; counts toward active counter
* `draft` — not yet confirmed or published; counts toward draft counter; hidden from calendar by default
* `cancelled` — entry is cancelled; excluded from active counter; visible in events table with cancelled indicator

## Module Extension Pattern

Modules integrate with the calendar by:

1. Registering one or more `calendar_entry_types` keys during module installation.
2. Creating or syncing `calendar_entries` records with `source_type` set to their registered key and `source_id` pointing to the originating record.
3. Exposing visibility toggle and color settings in the module's own settings section, mirroring the platform calendar settings.

Modules must not create a parallel calendar engine, a separate calendar table, or a separate calendar settings group. All calendar behavior is owned by the core calendar system.

This pattern mirrors the Batch 9 Thread/Message context linkage model: modules attach workflow context to a core foundational object rather than replacing it.

## Type Registration Contract

### Fields — `calendar_entry_types`

| Column | Type | Notes |
|--------|------|-------|
| `id` | bigint | Primary key |
| `key` | string (unique) | Slug; e.g. `invoice`, `task`, `lead_reminder` |
| `label` | string | Display label; e.g. `Invoices`, `Tasks` |
| `color` | string | Hex color string; e.g. `#FF6F00` |
| `visible_by_default` | boolean | Whether calendar shows this type before tenant configures it |
| `owning_module` | string (nullable) | Module key that owns this type; null = core platform |
| `timestamps` | — | `created_at`, `updated_at` |

### Registration Rules

* Core platform seeds the built-in type set on initial provisioning.
* Modules add their own types during module installation via a seeder or migration step.
* A module may not overwrite or delete types it does not own.
* Uninstalling a module should mark its owned types as hidden, not delete existing entries.

## V1 Entry Type Parity Reference

The following types existed in V1 as filterable calendar item categories. These are migration targets for Phase 4 module integration, not current implementation requirements.

Core/standalone:

* Events (standalone CalendarEntry with no source module)

Module-backed:

* Tasks
* Projects
* Invoices
* Estimates
* Proposals
* Contracts
* Customer Reminders
* Expense Reminders
* Lead Reminders
* Estimate Reminders
* Invoice Reminders
* Credit Note Reminders
* Proposal Reminders
* Ticket Reminders

## Calendar Settings Contract

### General Tab

* Calendar Entry Limit — maximum entries shown per day cell in month and week views
* Default View — month / week / day / agenda week / agenda day
* First Day of Week — Monday through Sunday
* Per-type visibility toggles — one toggle per registered `calendar_entry_type`; controls whether the type appears on the calendar by default
* Hide notified reminders — suppresses reminder-type entries that have already fired

### Styling Tab

* Per-type color picker — one hex color field per registered `calendar_entry_type`; displayed as a color swatch alongside a text input

### Module Settings Mirror Rule

Each module that owns one or more `calendar_entry_types` must expose equivalent visibility and color settings in its own module settings section. Changes in either location (platform calendar settings or module settings) resolve to the same stored value. The canonical store is the `calendar_entry_types` row.

## Calendar UI Behavior Contract

### Views

* Month view — grid by month; entries shown up to the configured limit per day cell with overflow indicator
* Week view — column-per-day grid for the current week; entries shown up to the configured limit per day column
* Day view — hour-by-hour column for the selected day; all-day entries shown in a dedicated row at top
* Events table — tabular list of all calendar entries past and present; sortable by date; filterable by type, status, and date range

### Counters

* Total entries — all non-cancelled entries in scope
* Active entries — count of entries with status `active`
* Draft entries — count of entries with status `draft`

### Filter Dimensions

* Entry type (one or more registered keys)
* Status (active / draft / cancelled)
* Date range
* Owner user (where applicable)

## Related

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 10]] | [Phase 2 - Implementation Batch 10](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%2010.md)
* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../Planning/V2%20Feature%20Roadmap.md)
