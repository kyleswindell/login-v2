# Frame Contribution Readiness Review

Review ID: `doc-review-2026-07-06-frame-contribution-readiness`  
Date: 2026-07-06  
Type: Review-only governance audit  
Status: `PARTIAL`  
Implementation status: `implemented with follow-up needed`

## Scope

This review maps how modules should contribute to the existing authenticated app Frame before runtime changes are made to header navigation, global actions, sidebar navigation, settings, setup, notifications, account/preferences, area views, or dashboard widgets.

This review started as a review-only artifact. Implementation notes below now track the approved follow-up slices that added Header Global Action metadata, rendered consumption for Settings, Notifications, and Account, module-owned Header Global Action rendering, Notifications module panel data preparation, Account module menu data preparation, and the stable Notifications module package migration.

## Current Frame State

The current authenticated Frame is rendered through `x-layouts.app` and private `x-layouts.app.frame.*` composition. The lower-level `x-shell.*` components remain implementation primitives and legacy alias vocabulary.

Current source references:

- `resources/views/components/layouts/app.blade.php` resolves `App\Platform\Shell\AppShellData` and passes header/sidebar data to Frame partials.
- `resources/views/components/layouts/app/partials/header.blade.php` renders Header Area Navigation from `$headerNavigation` and passes Header Global Action metadata into `x-layouts.app.frame.header.actions`.
- `resources/views/components/layouts/app/frame/header/index.blade.php` supports an `actions` slot, so the rendered header can accept arbitrary action markup.
- `resources/views/components/layouts/app/frame/header/actions.blade.php` keeps Search and Switcher as Frame-owned composition while rendering Settings, Notifications, and Account from Header Global Action metadata.
- `resources/views/components/layouts/app/frame/sidebar.blade.php` renders side navigation from the current sidebar data and has a custom slot fallback for caller-provided sidebar content.
- `app/Platform/Shell/AppShellData.php` prepares shared Frame data, uses module metadata for the current Header Area Navigation entries, and no longer exposes notification-specific or account-menu-specific Frame props.
- `App\Platform\Shell\AreaNavigationBuilder` resolves first-pass Header Area Navigation entries from `UiEntryType::NavigationItem` at `UiPlacement::AreaNavigation`, publishing only the Dashboard area entry for now.
- `App\Platform\Shell\SidebarAreaResolver` keeps Dashboard as the default area, switches Setup routes to Setup sidebar navigation, and switches Settings routes to Settings sidebar navigation even though Settings remains opened from the header global action.
- `App\Platform\Shell\HeaderGlobalActionsBuilder` resolves module-owned Header Global Action data providers and passes their data into module-provided component views.
- `Modules/Notifications` owns canonical notification routes, compatibility platform notification routes, controller behavior, service behavior, events, model, inbox view, header action view, unread badge, dropdown panel, realtime boot data, and header panel data.
- `Modules/Account` owns account overview/settings routes, account views, account header action view, account menu data preparation, and account-menu navigation aggregation from `UiPlacement::AccountMenu` metadata.
- `app/Platform/Navigation/PlatformNavigation.php` filters `config/navigation.php` entries by role/ability and is not module metadata driven.
- `Modules/Settings/Navigation/SidebarBuilder.php` consumes `UiEntryType::SettingsPage` entries at `UiPlacement::SettingsSidebar`.
- `app/Core/Modules/UiEntry.php`, `UiEntryType.php`, and `UiPlacement.php` provide metadata coverage for several contribution targets, but not every required Frame region.

## Contribution Region Classification

| Region | Current owner/render path | Readiness | Notes |
| --- | --- | --- | --- |
| Header Area Navigation | `resources/views/components/layouts/app/partials/header.blade.php`, `AppShellData`, `AreaNavigationBuilder`, module `UiEntry` metadata | `existing_metadata_ready` | The rendered header receives Dashboard and Setup area entries from module metadata. Other area entries remain catalog evidence until their area/sidebar replacement contracts are approved. |
| Header Global Actions | `resources/views/components/layouts/app/frame/header/actions.blade.php`, `App\Platform\Shell\HeaderGlobalActionsBuilder` | `existing_metadata_ready` | Settings renders as a generic route/icon action. Notifications renders a module-owned action/panel view from `Modules/Notifications/resources/views/header/action.blade.php`. Account renders a module-owned account menu action/panel view from `Modules/Account/resources/views/header/action.blade.php`. Search and Switcher remain Frame-owned hardcoded entries. |
| Sidebar Navigation | `resources/views/components/layouts/app/frame/sidebar.blade.php`, `PlatformNavigation`, `config/navigation.php`, Setup/Settings route-aware builders | `hardcoded_currently`, `existing_metadata_ready`, `metadata_gap` | Dashboard, Setup, and Settings now use the shared Frame sidebar. Setup and Settings consume module metadata for their own surface navigation. Broader module sidebar contribution and area replacement remain future work. |
| Area Sidebar Replacement | `resources/views/components/layouts/app/authenticated-main.blade.php` custom sidebar slot | `metadata_gap`, `renderer_gap` | A page can provide a custom sidebar slot, but there is no module-owned area/sidebar replacement contract. |
| Main Area Landing View | `UiEntryType::MainView`, `UiPlacement::Main`, Dashboard package proof | `existing_metadata_ready`, `renderer_gap` | Metadata exists and Dashboard proves a module-owned route/view, but the Frame does not yet choose area landing views from module metadata. |
| Settings Pages | `Modules/Settings/Navigation/SidebarBuilder`, `UiEntryType::SettingsPage`, `UiPlacement::SettingsSidebar` | `existing_metadata_ready` | Settings route pages use the shared Frame sidebar and landing grid from discovered SettingsPage metadata. Deprecated General settings pages are no longer active sidebar/landing entries. |
| Setup Pages | `UiEntryType::SetupScreen`, `UiPlacement::SetupNavigation`, current setup views | `existing_metadata_ready` | Setup sidebar and landing page consume discovered SetupScreen metadata. |
| Account/Preferences Entries | `UiPlacement::AccountMenu`, `Modules/Account/Header/MenuDataProvider.php`, Account header action view | `existing_metadata_ready` | The account menu now receives filtered `AccountMenu` metadata through the Account module. Preference pages remain a separate Preferences surface. |
| Dashboard Widgets | `UiEntryType::DashboardWidget`, legacy widget code inactive | `future_widget_rebuild` | Dashboard widgets are intentionally deferred until a from-scratch widget contribution/storage plan exists. |
| Panels/Flyouts | Notification panel, account menu, search, future tools | `hardcoded_currently`, `existing_metadata_ready` | Notification panel view/data come from Notifications through the Header Global Action contribution. Account menu view/data come from Account through the same contribution path. Search remains a concrete Frame-owned composition; no generic panel/flyout system exists. |

## Findings

### F1 - Header global actions are the first contribution-driven Frame proof

Classification: `existing_metadata_ready`  
Priority: `P1`

Risk: Moving Notifications, Settings, Search, or account-related entries into modules without a global-action contract would create another one-off hardcoded migration.

Expected future contract: Frame renders allowed global action entries from a neutral contribution source. Modules own labels, icons, routes/panels, access metadata, and feature behavior.

Current behavior: `x-layouts.app.frame.header` receives an `actions` slot. `resources/views/components/layouts/app/frame/header/actions.blade.php` renders Settings from generic Header Global Action metadata, renders Notifications through a module-provided action view, renders Account through a module-provided account menu action view, and keeps Search plus Switcher Frame-owned.

Implementation status: implemented with follow-up needed. `UiEntryType::HeaderGlobalAction`, `UiPlacement::HeaderGlobalActions`, `componentView`, `panelView`, `dataProvider`, and `panelTarget` let modules declare header global action metadata and module-owned rendering. `HeaderGlobalActionsBuilder` filters those entries by access metadata, resolves data providers through the container, and the rendered header consumes Settings, Notifications, and Account entries.

Recommended correction: Keep this proof narrow and continue with the remaining Frame regions separately: sidebar contribution, area replacement, preference page rendering, and dashboard widgets.

### F2 - Notifications trigger and panel data needed module ownership

Classification: `module_boundary_gap`  
Priority: `P1`

Risk: Notifications remain coupled to the Frame, making it harder to move notification preferences, notification routes, notification panel copy, and notification records into `Modules/Notifications`.

Expected future contract: Notifications module owns notification trigger metadata, unread state loading, panel data, panel actions, realtime route ownership, and the "view all notifications" link. Frame only renders the global action region and hosted panel surface.

Current behavior: `HeaderGlobalActionsBuilder` calls `Modules/Notifications/Header/PanelDataProvider.php` for unread count, recent items, canonical route hrefs, and realtime eligibility. `Modules/Notifications` owns notification routes, controller behavior, service behavior, events, model, inbox view, header action view, unread badge, dropdown panel, and realtime boot data. `/notifications` is canonical; `/platform/notifications*`, `/platform/realtime/auth`, and `/platform/administration/notifications` remain compatibility routes. Permission names and table name are unchanged.

Implementation status: implemented with follow-up needed. Notification settings/preferences remain separate future Settings/Preferences contribution work.

Recommended correction: Keep the current panel visual contract stable. Move notification settings/preferences only after Settings and Preferences contribution contracts are approved.

### F3 - Area navigation metadata exists and Dashboard is the runtime header source

Classification: `existing_metadata_ready`  
Priority: `P2`

Risk: Publishing every current `AreaNavigation` entry at once would expose deferred/internal tools as workspace area toggles before their sidebar replacement contracts are approved.

Expected future contract: Header Area Navigation is built from module entries filtered by active app instance, user permissions, and area availability.

Current behavior: `AreaNavigationBuilder` reads module `AreaNavigation` entries and publishes only `dashboard.nav.primary` to the rendered header. `SidebarAreaResolver` limits the Dashboard sidebar to the Dashboard title and Dashboard main link. `Notifications` has been removed from `primaryBase`; Docs Viewer, UI Reference, Security Checklist, and Logging area metadata remain non-rendered catalog evidence for now.

Recommended correction: Keep the Dashboard-only allowlist until Sidebar Navigation and Area Sidebar Replacement contracts are approved.

### F4 - Sidebar navigation and area sidebar replacement need separate contracts

Classification: `metadata_gap`, `renderer_gap`  
Priority: `P1`

Risk: Treating sidebar navigation as the same as header area navigation would blur two different behaviors: ordinary navigation within an area versus modules that replace the active sidebar and area home.

Expected future contract: Sidebar Navigation handles normal side-nav items/groups. Area Sidebar Replacement handles modules such as Docs Viewer or UI Reference that provide a distinct sidebar and area landing experience.

Current behavior: `resources/views/components/layouts/app/frame/sidebar.blade.php` renders the current sidebar data, while `authenticated-main.blade.php` allows a custom sidebar slot. No module metadata declares a full area-sidebar replacement.

Recommended correction: Review and name separate placement contracts for `SidebarNavigation` and `AreaSidebar` before moving Docs Viewer, UI Reference, or similar area modules.

### F5 - Settings and Setup have useful consumption proofs; Preferences does not yet

Classification: `existing_metadata_ready`, `renderer_gap`  
Priority: `P2`

Risk: Building module settings, setup, or preference screens before their renderer contracts are stable will require backfill and repeated route/view rewiring.

Expected future contract: Settings, Setup, and Preferences are shared Workspace surfaces that aggregate module contributions without owning every module's values or behavior.

Current behavior: Settings and Setup both use the shared Frame sidebar and landing grid style. Settings sidebar and landing items consume `SettingsPage` metadata and currently expose Settings plus module-contributed Notification Defaults. Setup sidebar and landing page consume `SetupScreen` metadata. Account menu rendering consumes `AccountMenu` metadata through the Account module. Preference page rendering remains separate from the account menu.

Recommended correction: Keep Settings and Setup as proven surface patterns, keep Account Menu as the proven header account-entry pattern, and plan remaining Preferences page consumption separately.

### F6 - Dashboard widgets remain intentionally deferred

Classification: `future_widget_rebuild`  
Priority: `P2`

Risk: Reintroducing widget behavior into the Frame contribution work would mix a known deferred rebuild with navigation and action contribution fundamentals.

Expected future contract: Dashboard module owns the dashboard surface and widget contribution/storage contracts after a dedicated widget design pass.

Current behavior: Dashboard route/view package proof is active, but legacy widget/grid/customization behavior is inactive by design.

Recommended correction: Keep Dashboard widgets out of the first Frame contribution implementation sequence.

## Review Questions Answered

Which frame regions are layout-owned versus module-owned?

- Frame owns: layout containers, Header, Global Actions region, Sidebar region, Main region, responsive behavior, slot composition, and generic current-state rendering.
- Modules own: contribution metadata, labels, icons, routes, views, panels, access requirements, feature data loading, and feature behavior.

Which current hardcoded entries should become module contributions?

- Notifications trigger/panel and core inbox behavior are Notifications module contributions.
- Settings trigger is a Settings module global-action contribution.
- Account trigger/panel and account-menu entry aggregation are Account module contributions.
- Preference pages remain Preferences module contributions and should stay separate from the account menu entry-point.
- Header Area Navigation entries should eventually come from module metadata rather than `config/navigation.php`.

Which existing `UiEntryType` and `UiPlacement` values are sufficient?

- Sufficient for current evidence: `NavigationItem`, `SettingsPage`, `SetupScreen`, `DashboardWidget`, `MainView`, `ExtensionPoint`, `ExtensionContribution`.
- Sufficient placements: `AreaNavigation`, `AccountMenu`, `SettingsSidebar`, `SetupNavigation`, `Dashboard`, `Main`, `Extension`.

Which new placements or entry types are needed before implementation?

- Header Global Actions has a first-class placement and entry type.
- Sidebar Navigation needs a first-class placement if it is not folded into current `NavigationItem` with a new placement.
- Area Sidebar Replacement needs a first-class placement and likely area-level metadata.
- Panels/Flyouts may need either a panel target on global-action entries or a separate panel contribution type.

What is the safest first runtime consumption point?

Header Global Actions was the safest first new region and is now implemented narrowly for Settings, Notifications, and Account. The next safe regions should be planned separately rather than folding the entire header/sidebar into one pass.

Which modules are blocked until Settings, Setup, Preferences, or Dashboard contribution contracts exist?

- Notifications settings/defaults are blocked on Settings contribution maturity.
- Notification user preferences are blocked on Preferences page contribution maturity.
- Setup steps are blocked on Setup consumption.
- Dashboard widgets are blocked on the Dashboard widget rebuild.
- Docs Viewer and UI Reference area experiences are blocked on Area Sidebar Replacement and area landing contracts.

## Recommended Implementation Order

1. Add missing metadata targets for Sidebar Navigation and Area Sidebar Replacement.
2. Implement Sidebar Navigation consumption separately from Area Sidebar Replacement.
3. Implement Area Sidebar Replacement only for modules that need full area sidebar/home swaps.
4. Keep Setup navigation consumption on the current discovered metadata path.
5. Plan Preferences page contribution consumption separately from the Account Menu entry-point.
6. Plan notification settings/preferences migration after Settings and Preferences contribution contracts are stable.
7. Defer Dashboard widgets until the widget rebuild contract is approved.

## Implementation Notes

2026-07-06:

- Added `UiEntryType::HeaderGlobalAction`.
- Added `UiPlacement::HeaderGlobalActions`.
- Added `UiEntry::$panelTarget` for panel-backed header actions.
- Added validation requiring header global actions to declare explicit access metadata, label, icon, and either `routeName` or `panelTarget`.
- Added metadata-only Settings and Notifications header global action entries.
- Added registry/catalog tests for the header global action contract.
- Did not change rendered header behavior, notification panel behavior, sidebar behavior, setup behavior, account/preferences behavior, or dashboard widget behavior.

2026-07-06 follow-up:

- Added `App\Platform\Shell\HeaderGlobalActionsBuilder`.
- Updated `AppShellData` to expose filtered `headerGlobalActions`.
- Updated `resources/views/components/layouts/app/frame/header/actions.blade.php` to render Settings and Notifications from Header Global Action metadata. At that stage Search, Switcher, and Account Menu still remained Frame-owned; Account Menu moved in the 2026-07-07 follow-up below.
- Added `Modules/Notifications/Header/PanelDataProvider.php` so notification unread count, recent items, realtime eligibility, and notification routes are prepared behind the Notifications module boundary.
- Kept current notification model, table, routes, and panel component unchanged.
- Did not change sidebar behavior, setup behavior, account/preferences behavior, dashboard widget behavior, or UI Reference behavior.

2026-07-07 Account header menu ownership:

- Added an Account-owned `account.header.global-action` Header Global Action entry.
- Added `Modules/Account/Header/MenuDataProvider.php` so account identity, theme mode, sign-out route, and account-menu navigation are prepared behind the Account module boundary.
- Added `Modules/Account/Header/ActionViewData.php` and `Modules/Account/resources/views/header/action.blade.php` with module-local partials for the Account header action popover.
- Updated `resources/views/components/layouts/app/frame/header/actions.blade.php` to render Account through the same generic Header Global Action contribution path used by Settings and Notifications.
- Removed account-menu-specific props from `AppShellData`; Account menu entries now come from `UiPlacement::AccountMenu` metadata.
- Kept Search and Switcher Frame-owned, and did not change Account routes, logout route behavior, theme switcher behavior, sidebar behavior, preference page behavior, or dashboard widget behavior.

2026-07-06 Notifications package migration:

- Added `Modules/Notifications/Definition.php`, `module.php`, and `Routes/web.php`.
- Moved notification inbox controller behavior, realtime auth controller behavior, service behavior, broadcast events, model, and inbox view into `Modules/Notifications`.
- Kept `/platform/notifications/*`, `/platform/realtime/auth`, `platform.notifications.*`, `platform.administration.notifications.index`, `platform.realtime.auth`, `platform.notifications.view`, the `notifications` table, and notification panel markup stable.
- Removed notification route/controller ownership from `routes/web.php` and `app/Http/Controllers/Platform`.
- Kept notification settings/preferences migration deferred.

2026-07-06 Header Area Navigation proof:

- Added `App\Platform\Shell\AreaNavigationBuilder` to build Header Area Navigation from module `NavigationItem` entries at `UiPlacement::AreaNavigation`.
- Published only `dashboard.nav.primary` in the rendered header for the first pass.
- Added `App\Platform\Shell\SidebarAreaResolver` to keep Dashboard as the active area and limit the Dashboard sidebar to the Dashboard title and Dashboard main link.
- Removed Notifications from `config/navigation.php` `primaryBase`; notification navigation remains owned by the module header global action and inbox route.
- Did not implement Sidebar Navigation consumption or Area Sidebar Replacement.

## Validation Performed

- Reviewed current Frame and header composition files.
- Reviewed current module UI entry metadata and repository validation.
- Reviewed current navigation and settings navigation builders.
- Reviewed existing module-system and application-structure planning notes.
- Follow-up implementation changed app-shell data preparation, header action rendering, Notifications module data preparation, Account module menu data preparation, Notifications package ownership, and focused frame/notification/account tests.

## Out Of Scope

- Remaining Frame contribution regions beyond Header Global Actions.
- Header/sidebar redesign.
- Route aliases or route moves.
- Notification settings/preferences migration.
- Settings, setup, account, or preferences page redesign.
- Dashboard widget rebuild.
- UI Reference rebuild.
- Tenant/app-instance module-state persistence.
