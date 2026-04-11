# Filament And Livewire

## Role In App 2.0

Filament is the planned admin panel framework. Livewire is the reactive layer underneath many Filament interactions.

In V1 terms, Filament fills the same general need as repeatable admin tables, Bootstrap/template forms, controller-backed record screens, and DataTables-style management interfaces. In V2 it is more structured because it is Laravel-native and built around panels, resources, pages, tables, forms, actions, widgets, policies, and Livewire components.

## Planned Usage

* Filament will power CRUD-heavy and data-management admin experiences
* platform and tenant experiences should share the same visual language
* separate internal panels may be used where they keep platform-management and tenant/shared-core boundaries safer
* custom Blade remains appropriate for specialized experiences, bootstrap pages, and views that do not map cleanly to panel resources
* Livewire should support reactive admin behavior where Filament or a selected app-shell pattern needs it

## Best Practices For This Repo

* introduce Filament only after route, panel, auth, and database-context ownership are documented
* keep panel boundaries explicit: shared core, platform-management, and tenant contexts should not share implicit assumptions
* consider Filament first for CRUD-heavy admin experiences, table/filter/detail views, admin forms, and operational record management
* keep complex business rules in Laravel services, actions, jobs, events, policies, and model methods, not buried in panel resources
* keep tenancy resolution, tenant provisioning, optional module installation, and platform-to-tenant handoff logic outside Filament resources
* use Filament resources/pages as UI adapters over existing services and policies
* use Livewire for reactive admin behavior, not as a replacement for clear backend boundaries
* treat custom Blade, Livewire, Filament, templates, and custom UI as compatible tools, but require each feature batch to declare which UI owner it uses before implementation

## Batch-Level Fit Review

Every implementation batch that includes UI work should stop and ask:

* does utilizing Filament apply here?

If yes, document why and use Filament as the UI owner for that surface.

If no, document why not and evaluate the next fitting tool:

1. Livewire/custom Blade for reactive or specialized app UI.
2. Existing Tailwind/Blade component patterns for standard server-rendered pages.
3. A reviewed template or component library if the batch needs broader visual design support.
4. Fully custom UI only when the available framework patterns do not fit the use case.

This is a batch-by-batch decision process, not a hard rule that all admin UI must use Filament.

## Filament Usually Fits

Filament usually fits:

* data tables with search, filters, sorting, pagination, row actions, or bulk actions
* create/edit/view workflows around Eloquent models
* read-only operational viewers such as audit logs and error logs
* settings/admin forms where schema, validation, and authorization can be standardized
* tenant registry, domain registry, module registry, provisioning records, and other platform-management records
* future CRUD-heavy shared core features such as users, customers, projects, finance records, and support records

## Filament May Not Fit

Filament may not fit:

* specialized repository/documentation viewers
* highly custom dashboards before the design system is selected
* public-facing website or customer-portal pages that need product-specific UX
* realtime surfaces where the Echo behavior is the central interaction until the Filament integration is proven
* tenant module installation or provisioning logic itself

These surfaces may still use Filament components later if a later batch proves the fit. The decision should be documented rather than assumed.

## Resource Design Rules

Filament resources and pages should:

* call Laravel services for mutations that have business meaning
* rely on policies/gates for access decisions
* use resource queries only for UI-scoped filtering and table behavior
* avoid duplicating validation rules already owned by form requests or services unless Filament is the canonical UI for that form
* emit or trigger the same audit logs, notifications, and events as non-Filament workflows
* avoid direct tenant database switching inside resource methods unless a documented context resolver owns it

## Panel Design Rules

Each panel must document:

* panel ID
* panel path
* domain/context where it is available
* auth guard and middleware
* database context
* resource/page ownership
* navigation groups
* relationship to shared core, platform-management, or tenant context

Panels should be visually consistent even when they are separated internally for safety.

## Version Direction

Current local install resolved:

* `filament/filament` v5.5.0
* `livewire/livewire` v4.2.4

PHP `intl` is required for the current Filament dependency stack. Keep it installed locally, in Docker images, and on staging before running Composer installs.

Official Filament docs currently point to 5.x as the stable direction. Prefer the current stable version unless a dependency or compatibility constraint is documented in an ADR.

## Official References

* Filament docs index: https://filamentphp.com/docs
* Filament installation: https://filamentphp.com/docs/5.x/introduction/installation/
* Filament panel configuration: https://filamentphp.com/docs/5.x/panel-configuration
* Livewire installation: https://livewire.laravel.com/docs/installation
* Livewire docs index: https://livewire.laravel.com/docs

## Practical Notes

Before installing Filament:

* define the route and panel ownership map
* define shared core, platform-management, and tenant panel boundaries
* document the auth model for each panel
* choose one low-risk proof-of-concept surface
* confirm the proof surface can use existing services, policies, logs, and permissions

After installation:

* register panel providers cleanly
* verify panel paths do not conflict with app routes
* publish Filament assets during deployment with `php artisan filament:assets`
* keep panel-specific boot logic explicit
* validate the first proof surface before migrating more screens
* update the canonical feature doc, planning note, and phase development log in the same work cycle

## Related

* [[V2 App/Reference/Reference Index]] | [Reference Index](Reference%20Index.md)
* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](../Architecture/Stack%20Overview.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../Planning/Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](../Planning/Phase%202/Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
