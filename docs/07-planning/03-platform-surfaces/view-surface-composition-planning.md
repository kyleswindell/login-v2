# View Surface Composition Planning

Status: Planning draft

## Purpose

Plan the Blade view architecture for core admin/account pages, platform surfaces, and business module pages so the app can reuse components and patterns heavily without turning every page into an opaque dynamic renderer.

This document owns implementation sequencing and intent only. Final UI standards, component contracts, pattern contracts, route contracts, and code conventions must be promoted to their owning docs before implementation.

## Direction

Use reusable patterns and components heavily, keep URL views thin, and use ViewModels/PageData objects for display data.

Important constraint:

```text
Use renderers only for registry-driven or highly repeatable contribution surfaces.
Do not create one universal dynamic renderer for every app page.
```

Recommended view stack:

```text
1. UI primitives
2. Shell/layout components
3. Purpose-built patterns
4. Thin URL views
5. Renderers for registry-driven surfaces only
```

Recommended normal page flow:

```text
Route
  -> Controller
  -> Query/Service
  -> ViewModel/PageData
  -> URL Blade view
  -> Pattern Blade component
  -> UI primitives
```

Recommended registry-driven page flow:

```text
Route
  -> Controller
  -> Registry service
  -> Surface/Page definition
  -> Renderer
  -> Pattern Blade component
  -> UI primitives
```

## Layer Responsibilities

| Layer | Location | Owns | Does Not Own |
| --- | --- | --- | --- |
| UI primitives | `resources/views/components/ui` | atomic Carbon-aligned app components | business workflows, model assumptions, route assumptions, authorization, database access |
| Shell/layout components | `resources/views/components/layouts`, `resources/views/components/shell` | app frame, header, side nav, page header, tabs, breadcrumbs, content shell | domain behavior, direct role/permission queries, database access |
| Purpose-built patterns | `resources/views/components/patterns` | reusable page/workflow compositions made from UI primitives | database queries, authorization decisions, domain mutation behavior |
| URL views | `resources/views/account`, `resources/views/admin/*`, `Modules/*/resources/views` | thin page composition and pattern selection | duplicated layout logic, raw table rendering, repeated action markup, business rules |
| ViewModels/PageData | `app/Core/*/ViewModels`, `Modules/*/ViewModels` | normalized display data for Blade | Blade markup, querying everything from views |
| Renderers | `app/Platform/Surfaces/Renderers` | registry-driven page aggregation and contribution rendering | universal page generation, arbitrary form/table DSLs, domain behavior |

## UI Primitives

UI primitives are the app-owned Blade components that represent atomic Carbon-aligned UI roles.

Examples:

```text
x-ui.button
x-ui.data-table
x-ui.modal
x-ui.notification
x-ui.tabs
x-ui.tag
x-ui.text-input
x-ui.dropdown
x-ui.pagination
```

Rules:

- no business logic
- no route assumptions
- no model assumptions
- no authorization checks
- no database access
- no feature naming

## Shell And Layout Components

Shell/layout components own the app frame and page chrome.

Examples:

```text
x-layouts.app
x-shell.header
x-shell.side-nav
x-shell.page-header
x-shell.page-tabs
x-shell.content
x-shell.breadcrumb
```

Rules:

- render the app frame
- consume already-filtered shell/navigation data
- do not know domain behavior
- do not query roles or permissions directly
- do not duplicate navigation filtering that belongs to Platform/Navigation and Access

## Purpose-Built Patterns

Patterns are the primary reuse layer. They compose UI primitives into reusable product workflows and page anatomy.

Recommended pattern groups:

```text
resources/views/components/patterns/admin/
resources/views/components/patterns/account/
resources/views/components/patterns/access/
resources/views/components/patterns/auth/
resources/views/components/patterns/common-actions/
resources/views/components/patterns/data-governance/
resources/views/components/patterns/data-protection/
resources/views/components/patterns/forms/
resources/views/components/patterns/notifications/
resources/views/components/patterns/security/
resources/views/components/patterns/status-indicator/
```

Pattern examples:

```text
x-patterns.admin.index-page
x-patterns.admin.detail-page
x-patterns.admin.form-page
x-patterns.admin.settings-page
x-patterns.admin.audit-page
x-patterns.access.effective-access-table
x-patterns.access.role-composition
x-patterns.security.evidence-table
x-patterns.security.release-gate-summary
x-patterns.data-protection.export-risk-summary
x-patterns.data-governance.privacy-request-table
x-patterns.common-actions.form-actions
x-patterns.common-actions.destructive-actions
```

Rules:

- reusable across multiple URL views
- own layout/anatomy for a workflow
- accept typed arrays, DTOs, or ViewModels
- do not query the database
- do not perform authorization
- may render empty/loading/error states
- may compose multiple `x-ui.*` components

## Thin URL Views

URL views should stay thin and readable.

Core/admin/account view direction:

```text
resources/views/account/
resources/views/admin/users/
resources/views/admin/access/
resources/views/admin/security/
resources/views/admin/data-governance/
resources/views/admin/data-protection/
resources/views/admin/audit/
resources/views/admin/monitoring/
resources/views/admin/notifications/
resources/views/admin/settings/
```

Business module view direction:

```text
Modules/Customers/resources/views/
Modules/Inventory/resources/views/
Modules/Orders/resources/views/
Modules/Shipments/resources/views/
```

A URL view should own:

- page title wiring
- selected layout
- which page pattern is used
- named slots for page-specific sections
- small composition decisions

A URL view should not own:

- raw table rendering
- repeated form action markup
- business rules
- authorization decisions
- registry lookups
- database queries
- conditional security behavior
- route filtering

Example shape:

```blade
{{-- ==========================================================================
    File: resources/views/admin/access/roles/index.blade.php
    Purpose: Role index page.
========================================================================== --}}

<x-layouts.app :title="$page->title">
    <x-patterns.admin.index-page
        :heading="$page->heading"
        :description="$page->description"
        :breadcrumbs="$page->breadcrumbs"
        :primary-action="$page->primaryAction"
        :filters="$page->filters"
        :table="$page->table"
    />
</x-layouts.app>
```

## ViewModels And PageData

ViewModels should normalize display data before Blade.

Candidate convention:

```text
app/Core/Access/ViewModels/
app/Core/Identity/ViewModels/
app/Core/Security/ViewModels/
app/Core/DataGovernance/ViewModels/
app/Core/DataProtection/ViewModels/
app/Core/Audit/ViewModels/
app/Core/Monitoring/ViewModels/

Modules/Customers/ViewModels/
Modules/Inventory/ViewModels/
Modules/Orders/ViewModels/
Modules/Shipments/ViewModels/
```

ViewModels should own:

- page title
- heading and description
- breadcrumbs
- tabs
- primary/secondary actions after controller/policy filtering
- filters
- tables/lists/cards already shaped for patterns
- empty/error state data

ViewModels should not own:

- Blade markup
- authorization checks that belong in policies/services
- database querying that belongs in queries/services
- mutation behavior

## Renderers

Renderers should be selective presentation orchestration for contributed/registered surfaces.

Good renderer use cases:

```text
Settings pages
Preferences tabs
Setup screens
Dashboard widgets
Admin overview cards
Security evidence/check results
Registry-driven package navigation
Data asset registry summaries
Vulnerability/security check summaries
```

Bad renderer use cases:

```text
Every CRUD page
Every detail page
Every form
Every table
Every business workflow
Every one-off feature page
```

Renderer direction:

```text
app/Platform/Surfaces/
  Contracts/
  Data/
  Renderers/
    SettingsPageRenderer.php
    PreferencePageRenderer.php
    SetupScreenRenderer.php
    DashboardRenderer.php
    RegistryTableRenderer.php
    EvidenceSummaryRenderer.php
```

Renderers should:

- accept typed page/surface definitions
- filter or receive already-filtered visible entries according to Access rules
- sort consistently
- select known patterns
- pass normalized data to Blade
- keep registry-driven pages consistent

Renderers should not:

- know every possible field type
- decide domain authorization by themselves
- query domain data directly
- render business workflows from arbitrary arrays
- replace Blade composition
- become a general UI DSL

## Surface Definitions

Registry-driven pages should use explicit typed definitions rather than arbitrary arrays.

Example direction:

```text
SettingsPageDefinition
  key
  label
  description
  permission
  view
  sort
```

The manifest/registry provides page definitions. The renderer aggregates them, applies consistent ordering/visibility, selects known patterns, and passes normalized data to a thin URL view or pattern.

## Page Type Handling

| Page Type | Recommended Handling |
| --- | --- |
| Auth pages | purpose-built views plus auth patterns; no renderer |
| Account pages | normal URL views plus account patterns; preference tabs may use renderer if registry-driven |
| Users admin | normal URL views plus admin/identity/access patterns; no generic renderer |
| Access admin | mostly normal URL views; renderer only for permission registry, overview metrics, or definition-driven preview components |
| Settings | renderer recommended because settings pages are registry-driven |
| Setup | renderer recommended because setup screens are registry-driven |
| Dashboard | renderer recommended for widgets |
| Security evidence/checks | renderer recommended later after evidence/check registries exist |
| Business modules | normal module views plus shared patterns; no universal renderer |

## Test Planning

URL views:

- render for authorized users
- deny unauthorized users at route/policy layer
- include expected page heading
- omit unauthorized actions
- compose approved patterns instead of local duplicated layout/table/action markup

Patterns:

- render required props/slots
- support empty/loading/error states where expected
- use approved `x-ui.*` components
- expose accessibility markers and labels required by the owning UI standards

Renderers:

- aggregate registry entries
- filter unauthorized entries or consume prefiltered entries
- sort consistently
- reject invalid or missing definitions
- pass normalized data to views/patterns
- do not query domain records directly

## Implementation Sequence

### 1. Planning And Matrix Alignment

- Add view surface composition to the core build matrix.
- Add open decisions for central versus package-local core views, renderer-driven surfaces, and standard ViewModel/PageData shape.
- Link this plan from module layout and module UI surface planning.

### 2. Pattern Baseline

- Confirm page-level admin patterns: index, detail, form, settings, overview, audit.
- Confirm section patterns: summary tiles, table section, filter bar, entity header, detail tabs, empty state, status banner.
- Keep pattern standards in `docs/02-standards/ui/patterns/` when promoted.

### 3. ViewModel/PageData Baseline

- Define common page data shape for index/detail/form pages.
- Apply it to one existing admin page before broad migration.
- Keep controllers thin and queries/services responsible for data preparation.

### 4. Renderer Baseline

- Limit first renderers to Settings, Preferences, Setup, Dashboard widgets, or registry evidence surfaces.
- Use typed definitions.
- Do not build a field-level generic form/page renderer.

### 5. Business Module Template Update

- Update `_Template` to include thin URL views, ViewModels, and approved pattern usage.
- Keep business module views in `Modules/{Module}/resources/views`.
- Keep shared UI primitives/patterns in `resources/views/components`.

## Transition Rules

- Do not create a universal renderer for all pages.
- Do not move every feature page into Platform renderers.
- Do not put business logic, authorization, or queries in Blade components.
- Do not copy shell layout, navigation, or shared UI primitives into business modules.
- Do not build arbitrary Blade path overrides as the extension mechanism.
- Do not use renderers to bypass normal policies or route authorization.
- Do not promote retired reference viewer as a core capability or business module.
- Do not edit `/docs/08-active/`.

## Open Decisions

- Should core admin/account Blade views live centrally under `resources/views/admin/*` and `resources/views/account/*`, or package-local under `app/Core/*/resources/views`?
- Which surfaces are renderer-driven versus normal ViewModel-driven?
- What is the standard PageData/ViewModel shape for index, detail, form, settings, setup, and dashboard pages?
- Should renderer classes live under `app/Platform/Surfaces/Renderers`, or should narrowly scoped renderers live with the owning platform surface?
- What is the first proof page for the thin URL view plus admin pattern plus ViewModel flow?

Recommendation:

```text
Core/admin/account views live centrally under resources/views.
Business module views live under Modules/{Module}/resources/views.
Shared components/patterns live under resources/views/components.
Renderers live under Platform only for registry-driven surfaces.
```

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
- [Module UI Surface Implementation Planning](module-ui-surface-implementation-planning.md)
- [Application Structure Baseline Planning](application-structure-baseline-planning.md)
- [UI Standards Index](../02-standards/ui/index.md)
- [Pattern Standards Index](../02-standards/ui/patterns/index.md)
