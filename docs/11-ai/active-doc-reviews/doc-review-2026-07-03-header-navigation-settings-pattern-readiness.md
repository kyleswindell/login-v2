# Header Navigation And Settings Pattern Readiness Review

Review ID: `doc-review-2026-07-03-header-navigation-settings-pattern-readiness`  
Date: 2026-07-03  
Type: Review-only governance audit  
Status: READY_FOR_IMPLEMENTATION  
Implementation status: not started

## Scope

Review the current platform navigation and settings/setup layout direction before more module UI entry metadata is consumed by rendered views.

This review uses rendered UI entry names: header menu, notification bell, app sidebar, settings sidebar, setup navigation, account menu, account settings, dashboard widgets, and content views. Internal enum names such as `UiPlacement` remain code metadata only and should not drive human-facing UI planning language.

This review does not implement UI changes, route changes, component changes, module definition changes, or settings-page redesigns.

## Current Navigation Ownership

- Header menu currently renders primary navigation items from app navigation data, including Dashboard, Notifications, Documentation Vault, UI Reference, and Security Checklist.
- Notification access is already available through the header notification bell and notification popover.
- The app sidebar already supports primary navigation, admin navigation, logs navigation, and setup navigation groups.
- The settings sidebar currently renders a transitional two-column layout: setup/admin links in the first column and settings-page links in the second column.
- Account settings currently owns profile/security fields and should become the owner for user-level notification preferences.
- Platform settings should only own platform-wide defaults and policies.

## Findings

### HNSP-F1: Notifications should not be a primary header menu item

Classification: `navigation_ownership_gap`  
Priority: P1

Risk:

Keeping Notifications in the header menu duplicates the header notification bell and makes runtime notification access look like a primary app area.

Expected contract:

Runtime notification access belongs to the notification bell. The bell can link to the full notification inbox when needed. Notification settings should be split between account-level preferences and platform-wide defaults.

Recommended correction:

Remove Notifications from primary header navigation in a later UI implementation pass. Keep the notification bell and inbox route intact. Move user notification preferences into account settings; keep only platform-wide notification defaults in platform settings if that distinction remains necessary.

### HNSP-F2: Internal platform tools need a clearer navigation grouping

Classification: `navigation_ownership_gap`  
Priority: P1

Risk:

Documentation Vault, UI Reference, and Security Checklist currently compete as top-level header items even though they are internal platform-management tools.

Expected contract:

The header menu should stay concise. Internal platform-management tools should be grouped under a clear Platform menu or moved into the app sidebar, using the existing rendered header/sidebar components.

Recommended correction:

In a later implementation pass, either shorten Documentation Vault to Docs if it remains top-level, or group Docs, UI Reference, Security Checklist, setup/admin tools, and other internal platform utilities under a Platform navigation grouping. Do not invent a new rendered navigation container when the existing header menu and app sidebar can be reused.

### HNSP-F3: Setup and settings must remain separate navigation areas

Classification: `settings_setup_boundary_gap`  
Priority: P1

Risk:

The current settings sidebar mixes setup/admin links and settings-page links. This makes settings a dumping ground for setup workflows and obscures whether a page is for configuration, setup, or operational administration.

Expected contract:

Settings pages and setup pages remain separate areas. The settings sidebar should list settings pages only. Setup navigation should have its own route area and navigation presentation.

Recommended correction:

Treat the current two-column settings sidebar as transitional. Remove the setup/admin column only after a replacement setup navigation path exists. Do not consume setup metadata inside the settings sidebar.

### HNSP-F4: Settings page pattern work blocks broader settings rendering

Classification: `component_contract_dependency`  
Priority: P1

Risk:

Building more settings views before the settings page pattern is stable will multiply inconsistent page structures, form layouts, validation behavior, and save-action placement.

Expected contract:

A standard settings page pattern must define title/description placement, section layout, form rows, validation display, save actions, destructive actions, status feedback, and responsive behavior before broad settings-page rendering work continues.

Recommended correction:

Pause new settings-page rendering and redesign work until the component contract work is complete enough to test a reusable settings page pattern. Future settings pages should consume that pattern instead of creating one-off layouts.

### HNSP-F5: Human-facing docs should stop using "shell" as UI planning language

Classification: `docs_mismatch`  
Priority: P2

Risk:

Using "shell" in planning language conflates internal metadata placement with the actual rendered UI. The app already has rendered header, sidebar, and layout components; future work should target those by name.

Expected contract:

Human-facing docs use concrete rendered surface names: header menu, notification bell, app sidebar, settings sidebar, setup navigation, account menu, dashboard widgets, and content views.

Implementation note:

The internal metadata now uses `UiPlacement` for render placement. Human-facing planning should continue to use concrete names such as header menu, notification bell, app sidebar, settings sidebar, setup navigation, account menu, dashboard widgets, and main views.

## Settings/Setup Navigation Decision

Two implementation directions remain valid after the settings page pattern is ready:

- Full content-area switch: Settings and setup routes each render their own index/landing page, navigation, and content area.
- Nav-items-only switch: The same layout frame remains in place while the sidebar items change between settings and setup routes.

Recommended sequencing:

Do not implement either option yet. First complete the settings page pattern and component contracts. Then choose the smallest route/navigation change that removes setup links from settings pages while preserving the existing app header and app sidebar components.

## Settings Page Pattern Readiness

The settings page pattern should be considered ready only when it has a tested contract for:

- page title and description
- section grouping
- form row layout
- validation summary and field errors
- save/cancel action placement
- destructive or sensitive actions
- saved/failed status feedback
- responsive behavior

Until that pattern exists, new settings pages should be avoided unless they are required for an unrelated security or operations fix.

## Recommended Follow-Up Order

1. Complete the settings page pattern and required component contracts.
2. Update navigation ownership so Notifications is removed from the header menu and runtime notification access remains bell-owned.
3. Decide whether platform-management tools belong in a Platform header grouping or app sidebar grouping.
4. Separate setup navigation from settings pages and remove the transitional setup/admin column from the settings sidebar.
5. Optionally rename internal module placement metadata after rendered navigation ownership is stable.

## Validation Performed

Reviewed current Blade/config surfaces for header navigation, notification bell actions, app sidebar setup support, settings sidebar composition, and account settings.

No code, routes, Blade views, module definition entries, or active batch files were changed by this review.

## Out Of Scope

- UI implementation
- Component contract implementation
- Settings page redesign
- Route renaming
- Module enum renaming
- Dashboard widget rendering changes
- `/docs/08-active/` changes
