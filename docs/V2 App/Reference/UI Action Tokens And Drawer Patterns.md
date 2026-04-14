# UI Action Tokens And Drawer Patterns

## Purpose

Define the canonical Batch 7 UI reference for shared action-button tokens, table filter affordances, and app-owned right-side drawer behavior.

This note is a scoped implementation reference. The canonical UI design system owner is:

* [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](UI%20Design%20System%20Standards.md)

## Planning Source

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 7]] | [Phase 2 - Implementation Batch 7](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%207.md)

## Current Status

* introduced during Phase 2 Batch 7 remediation
* active owner for app-owned action tokens and operational log drawer behavior
* staging visual verification still required before Batch 7 sign-off

## Current Implementation

The shared UI action baseline currently lives in `resources/css/app.css` and is applied to current Batch 7 surfaces that need consistent action affordances across light and dark mode.

Current shared classes:

* `ui-action` - neutral action baseline for secondary actions
* `ui-action-primary` - primary emphasis actions such as log-detail open and dashboard development actions
* `ui-action-success` - success-oriented actions when an affirmative semantic is needed
* `ui-action-warning` - setup and cautionary actions
* `ui-action-danger` - destructive or failure-oriented actions
* `ui-action-notice` - informational or notification-linked actions
* `ui-action-ghost` - low-emphasis border actions such as close/reset
* `ui-icon-button` - icon-only button affordance used for compact table tools such as filter toggles
* `ui-log-drawer-panel` - shared right-side drawer shell for log detail views

## Design System Source Of Truth

For consolidated UI standards, use:

* [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](UI%20Design%20System%20Standards.md)

## Filter Toggle Pattern

Current Batch 7 table filter toggles should follow these rules:

* use the shared `ui-icon-button` affordance
* include an accessible label via `aria-label` or visually hidden text
* toggle a nearby `data-filter-panel` region rather than navigating away
* prefer icon-first affordance over plain text-only "Filters" buttons on dense operator tables

## Drawer Pattern

App-owned operational detail drawers should follow these rules:

* use a fixed right-side panel instead of a centered modal when reviewing row detail from a dense operator table
* keep a direct page fallback route for non-JavaScript access and deep links
* load detail payloads as JSON from the same controller route when JavaScript opens the drawer
* support backdrop close, explicit close action, and `Escape` close
* lock body scroll while the drawer is open

Current Batch 7 app-owned drawer use:

* audit logs
* error logs

## Important Files

* `resources/css/app.css` - shared action-token and drawer-shell classes, including light-mode overrides
* `resources/js/app.js` - filter toggle wiring and reusable drawer initialization logic
* `resources/views/platform/audit-logs/index.blade.php` - icon-based filter toggle, row actions, and audit drawer markup
* `resources/views/platform/error-logs/index.blade.php` - icon-based filter toggle, row actions, and error drawer markup
* `resources/views/livewire/platform/dashboard/widgets/development-tools.blade.php` - dashboard development action token usage
* `resources/views/livewire/platform/dashboard/widgets/system-notifications.blade.php` - dashboard notification action token usage
* `resources/views/filament/widgets/system-notifications-widget.blade.php` - Filament-owned notification widget action token usage

## Related

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](Stack%20-%20Frontend%20Build.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](Stack%20-%20Filament%20And%20Livewire.md)