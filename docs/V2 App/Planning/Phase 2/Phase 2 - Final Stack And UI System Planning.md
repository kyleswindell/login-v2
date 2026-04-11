# Phase 2 - Final Stack And UI System Planning

## Purpose

Plan Phase 2: the final stack and UI system introduction phase.

This note is the active planning surface for deciding how the Phase 1 foundation becomes the long-term admin application structure.

## Implementation Status

Current status:

* Phase 2 planning has started
* Phase 1 is complete and signed off
* current app surfaces are custom Blade, Vite, Tailwind, Laravel controllers, and small DOM-driven JavaScript
* realtime notifications already use Reverb and Echo
* Filament is installed and validated through read-only audit/error operational proofs
* Livewire is present through Filament, but no custom Livewire app shell decision has been made yet
* final app shell, navigation, and UI design decisions remain open

Canonical architecture owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

Development log:

* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

Batch artifacts:

* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 2]] | [Phase 2 - Implementation Batch 2](Phase%202%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 4]] | [Phase 2 - Implementation Batch 4](Phase%202%20-%20Implementation%20Batch%204.md)

## Phase Goal

Complete the final stack and UI architecture decisions before Phase 3 adds customer/public foundations and Phase 4 adds broad business modules.

Phase 2 should prevent future rework by deciding:

* which UI framework owns each surface
* how persistent navigation should work
* how Filament and Livewire enter the app
* which current Blade screens are permanent, transitional, or candidates for migration
* what design system or template direction future screens must follow

## Clarified Product Direction

The platform app should not feel like a separate internal-only product.

The platform context is the first Parasolutions-owned instance of the shared core app. It should use the same user experience that tenant instances will use later, with additional platform-management modules available only to authorized platform users.

Accepted direction:

* one Laravel codebase
* one central platform database for the Parasolutions instance and platform-management records
* one isolated PostgreSQL database and role per tenant
* shared visual style across platform and tenant instances
* future colorway and user-design customization may vary appearance without changing the base UX model
* optional tenant-specific modules may install tenant-specific tables only for selected tenants
* tenant schema creation should be migration/seeder driven, with generated template DBs allowed as artifacts
* platform-to-tenant access should be explicit, secure, and auditable

Decision owner:

* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)

## Current Implementation Compared To Final Stack

### Current implementation

Phase 1 produced:

* Laravel 13 platform app
* PostgreSQL-backed auth, RBAC, settings, logs, and notifications
* Redis-backed queue/cache direction
* Reverb/Echo realtime notification foundation
* custom Blade platform shell
* Tailwind-styled app pages
* full-page navigation with sidebar state helpers
* setup/settings overlay and second-column navigation
* docs viewer, users UI, notification inbox, audit log viewer, error log viewer, and settings pages

### Final stack plan

The final stack still expects:

* Filament for admin-panel-heavy workflows
* Livewire for reactive panel/admin behavior where appropriate
* explicit platform versus tenant route and panel boundaries
* reusable design-system primitives
* repeatable scaffolding for Phase 3 customer/public surfaces and Phase 4 module expansion

### Main difference

The main difference is not backend architecture. The backend foundation is mostly aligned.

The main difference is UI ownership:

* today, the app owns admin UI through custom Blade pages
* final plan expects Filament/Livewire to own at least some shared core and platform-management workflows
* Phase 2 must decide the boundary before new modules multiply the current pattern
* the selected pattern must preserve the same visual style across platform and future tenant instances

## Implications Of Introducing The Final Stack Now

Introducing Filament/Livewire after Phase 1 has these implications:

* current Blade screens should be evaluated before being extended further
* CRUD-heavy screens are likely Filament candidates
* workflow-heavy or custom pages may remain Blade or use Livewire
* services, policies, migrations, settings keys, notifications, audit logs, and error logs should remain reusable regardless of UI
* permissions must stay stable even if screens move to a new panel
* Reverb/Echo should stay as the realtime transport rather than being replaced by Livewire polling
* UI migration should happen with one proving-ground surface before broad conversion

## Proposed Phase 2 Workstreams

### 1. Route and panel ownership decision

Decide:

* shared core app shell route space
* platform-management route space
* Filament panel path or paths, if introduced
* future tenant route/panel path under tenant domains
* which auth guard/session rules apply to each surface
* whether setup/settings should remain custom or move into Filament
* how platform-only modules appear inside the same overall app experience

Required output:

* ADR or architecture update
* route/panel map
* migration candidate list for existing screens

### 2. Navigation and app shell decision

Decide:

* keep full-page Blade navigation
* introduce a Livewire persistent shell
* let Filament own panel navigation
* use a hybrid shell where custom pages and Filament panels coexist

Required output:

* selected shell model
* back/forward/sidebar state expectations
* page transition and persistent panel behavior rules

### 3. Visual design and template review

Decide:

* whether to select a dashboard/admin template
* whether to keep a custom Tailwind design system
* how closely the current dashboard should be redesigned
* what component primitives all new pages must use
* how the same visual system will support platform and tenant instances

Required output:

* visual baseline
* accepted/rejected template notes
* table/form/card/header/sidebar standards

### 4. Filament/Livewire introduction

Decide:

* install Filament during Phase 2 or defer to Phase 3
* if installed, what low-risk surface proves the pattern
* how panel resources interact with existing services and policies
* how notifications, audit logs, and settings appear across panel/custom UI

Required output:

* install/defer decision
* proof-of-concept scope
* panel resource standards if installed

### 5. Future module scaffolding

Decide:

* standard folder structure for new modules/features
* route registration pattern
* permission naming pattern
* settings/setup registration pattern
* audit/error/notification requirement checklist
* UI ownership declaration requirement
* optional module migration and seeding pattern for selected tenants
* module installed/enabled/disabled state model

Required output:

* Phase 3 customer/public scaffold checklist and Phase 4 module scaffold checklist
* updates to feature development standards if needed

## Recommended Order

1. Audit Phase 1 screens and classify each as permanent, transitional, or migration candidate.
2. Write the route/panel ownership decision.
3. Decide the app shell and persistent navigation strategy.
4. Review visual design/template options and lock a minimal design baseline.
5. Decide whether Filament is installed in Phase 2 or deferred to the first Phase 4 module after Phase 3 customer/public foundations are established.
6. If installed, migrate one low-risk administrative surface as a proof of concept.
7. Define optional module schema installation rules before tenant-specific modules are planned.
8. Define platform-to-tenant access handoff principles before tenant rollout work begins.
9. Update standards so every future module declares UI ownership, setup/settings entries, permissions, logs, notifications, and schema installation rules before implementation.
10. Close Phase 2 only when future Phase 3 customer/public scaffolding and Phase 4 module scaffolding are repeatable.

Current Batch 1 progress:

* screen audit is drafted
* route/panel ownership map is drafted
* Filament proof targets for audit and error logs are deployed and accepted as complete for Phase 2 proof purposes
* app shell navigation ownership has a first implementation slice through a centralized navigation contract in the Blade shell
* visual design/template brief remains pending
* Livewire shell decision remains pending
* next implementation focus remains visual baseline and template/design decision, followed by broader shell ownership lock

## Decisions Still Needed

### UI design decisions

Open:

* what final dashboard layout should look like
* whether the current top header/sidebar model remains
* how dense data tables should be
* how full-width pages should behave on desktop
* how mobile/tablet behavior should work
* whether the docs vault remains a specialized custom view

### Templating decisions

Open:

* adopt a dashboard/admin template, reference one, or avoid templates
* if a template is used, whether it is applied only visually or structurally
* template license and maintenance acceptability
* compatibility with Tailwind, Filament, Livewire, and Vite
* whether template assets introduce unnecessary JavaScript or CSS weight

### Framework boundary decisions

Open:

* exact Filament panel paths
* whether platform-management and core-app admin screens share one panel, separate internal panels, or a hybrid shell with consistent styling
* whether future tenant screens use a separate panel provider
* whether Livewire is used outside Filament
* whether current custom Blade screens are wrapped, migrated, or left alone

### Tenant and module boundary decisions

Partially resolved:

* tenant instances should use separate databases and roles
* schema should be migration/seeder driven rather than maintained only through a physical template DB
* optional module tables may be installed only for selected tenants
* module installation state and active/inactive state must be separate concepts

Open:

* exact module manifest shape
* exact tenant module migration runner
* whether generated tenant template DBs are used for provisioning speed
* platform-to-tenant access method: audited handoff token, redirected tenant login, or auto-created tenant admin account
* what audit events are mandatory for platform-to-tenant access

## Non-Goals

Phase 2 should not introduce broad business modules.

Out of scope:

* full customers/projects/finance implementation
* tenant provisioning runtime
* customer portal implementation
* website builder implementation
* wide conversion of all Phase 1 screens before one proof-of-concept validates the pattern

## Phase 2 Exit Criteria

Phase 2 can close when:

* final stack/UI architecture is documented
* route and panel ownership is documented
* app shell/navigation behavior is selected
* design system or template direction is selected
* Filament/Livewire introduction timing is decided
* existing Phase 1 screens have a disposition list
* optional module schema installation pattern is documented
* platform-to-tenant access direction is documented
* standards require future modules to declare UI ownership and schema installation behavior during design
* Phase 3 customer/public scaffolding and Phase 4 module scaffolding are clear enough to build without inventing patterns

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 1]] | [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 2]] | [Phase 2 - Implementation Batch 2](Phase%202%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](../../Architecture/Stack%20Overview.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)
* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)
