# Phase 2 - Final Stack And UI System Planning

## Purpose

Plan Phase 2: the final stack and UI system introduction phase.

This note is the active planning surface for deciding how the Phase 1 foundation becomes the long-term admin application structure.

## Implementation Status

Current status:

* Phase 2 planning is active and Batch 6 is complete
* Batch 5 final audit passed (testing and visual web app confirmation)
* Phase 1 is complete and signed off
* current app surfaces are custom Blade, Vite, Tailwind, Laravel controllers, and small DOM-driven JavaScript
* realtime notifications already use Reverb and Echo
* Filament is installed and validated through read-only audit/error operational proofs
* `/console` currently exists as a temporary proof path for operational Filament surfaces only
* Livewire is present through Filament, while broad custom Livewire shell ownership remains deferred
* Batch 4 route/navigation convergence is complete through target `/platform/operations/*` routes and centralized shell navigation
* Batch 5 visual baseline and first-pass owner matrix are implemented and verified for shared admin migrations
* Batch 6 close-out contract pass is implemented for optional module schema direction, platform-to-tenant handoff, UI ownership declaration standards, and `/console` proof-path retirement control
* full existing UI surface review is completed and synced in the UI Surface Disposition Audit sign-off matrix
* Batch 7 implementation is complete for final visual UI migration scope that was expected as part of Phase 2 deliverables
* Batch 8 and Batch 9 planning drafts are created for account IA close-out and inter-tenant messaging foundation sequencing
* Batch 9 planning now locks a single core Thread/Message messaging engine with module-specific shells attached by context instead of separate parallel messaging systems
* Batch 10 planning draft is created for calendar foundation and CalendarEntry contract sequencing
* Batch 10 calendar contract is documented and locked in its canonical feature owner note
* Batch 11 dashboard widgets are implemented and locally verified in Docker; staging deployment and visual QA are pending
* Batch 8 and Batch 9 now have canonical feature owner notes and remain blocked by execution gates (Batch 7 visual sign-off before Batch 8, then Batch 8 completion before Batch 9)
* app-owned `/platform/ui-reference` workspace is implemented as the canonical repeatable review surface for Phase 2+ UI baselines (shell, forms, tables, action tokens, and drawer interactions)
* `/platform/ui-reference` access is restricted to platform super admins
* `/platform/ui-reference` now carries expanded button baseline references and a parallel-agent update workflow template
* final visual sign-off review remains before Phase 2 can be fully closed

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
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 5]] | [Phase 2 - Implementation Batch 5](Phase%202%20-%20Implementation%20Batch%205.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 6]] | [Phase 2 - Implementation Batch 6](Phase%202%20-%20Implementation%20Batch%206.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 7]] | [Phase 2 - Implementation Batch 7](Phase%202%20-%20Implementation%20Batch%207.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 8]] | [Phase 2 - Implementation Batch 8](Phase%202%20-%20Implementation%20Batch%208.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 9]] | [Phase 2 - Implementation Batch 9](Phase%202%20-%20Implementation%20Batch%209.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 10]] | [Phase 2 - Implementation Batch 10](Phase%202%20-%20Implementation%20Batch%2010.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 11]] | [Phase 2 - Implementation Batch 11](Phase%202%20-%20Implementation%20Batch%2011.md)

## Phase Goal

Complete the final stack and UI architecture decisions before Phase 3 adds customer/public foundations and Phase 4 adds broad business modules.

## Locked Phase 2 Decisions

The following direction is now accepted for Phase 2 planning and execution:

* the app must present one coherent experience across shared-core and platform-management surfaces
* `/console` is transitional and should not remain a long-term standalone product surface
* the current Blade shell remains the primary shell during Phase 2 while migrations are sequenced
* Filament remains approved for admin and operational data-heavy surfaces, but must be integrated under the unified app direction
* audit and error log Filament proofs are complete as technical validation and now move into migration planning
* operational log navigation now targets `/platform/operations/*` routes, which gate access before redirecting to app-owned operational views
* notifications realtime transport remains Reverb and Echo; migration work should not replace it with polling-first behavior
* UI ownership must be declared per surface before implementation: custom Blade, Filament, or hybrid
* Batch 5 will not adopt a third-party dashboard/admin template; it uses the current Tailwind Blade shell plus Filament-owned admin/data surfaces

This keeps implementation consistent with the existing UI design workflow and avoids two parallel products forming accidentally.

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

## Phase 2 Workstreams

### 1. Route and panel ownership lock

Locked for Batch 4:

* shell navigation ownership lives in `App\Platform\Navigation\PlatformNavigation`
* operational log navigation uses `/platform/operations/audit-logs` and `/platform/operations/error-logs`
* `/console/platform-audit-logs` and `/console/central-error-logs` remain transitional Filament proof targets with direct access disabled by default behind `CONSOLE_PROOF_PATHS_ENABLED=false`

Still to lock before broader migrations:

* shared core app shell route space
* platform-management route space
* final removal timing for direct `/console/*` proof resources after post-close monitoring window
* future tenant route/panel path under tenant domains
* which auth guard/session rules apply to each surface
* setup/settings ownership target and migration sequence
* how platform-only modules appear inside the same overall app experience

Required output:

* architecture owner update with locked route/panel direction
* route/panel map with transitional and target routes
* migration list for existing screens with owner and sequence

### 2. Navigation and app shell lock

Lock:

* keep full-page Blade navigation
* defer broad custom Livewire shell work until after Phase 2 migration deliverables are complete
* use Filament navigation only where surfaces are intentionally migrated
* use a hybrid shell where custom pages and Filament panels coexist

Required output:

* selected shell model
* back/forward/sidebar state expectations
* page transition and panel behavior rules for both shared-core and operational surfaces

### 3. Visual design and template review

Locked for Batch 5:

* no third-party dashboard/admin template adoption
* current full-page Blade shell remains primary
* current Tailwind shell primitives remain the shared baseline
* Filament resources use Filament-native tables, forms, filters, actions, and detail behavior while matching unified navigation direction
* broad visual redesign is deferred unless local parity fixes are needed for a migrated surface

Future design-system work still needs to decide:

* whether to select a dashboard/admin template
* whether to keep a custom Tailwind design system
* how closely the current dashboard should be redesigned
* what component primitives all new pages must use
* how the same visual system will support platform and tenant instances

Required output:

* visual baseline
* accepted/rejected template notes
* table/form/card/header/sidebar standards
* canonical UI design system owner note that consolidates action tokens, tables, forms, and drawer patterns: [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](../Reference/UI%20Design%20System%20Standards.md)

### 4. Filament/Livewire introduction

Lock:

* Filament remains active in Phase 2 and moves from proof to migration sequencing
* no additional Phase 2 proof-only surfaces should be created under `/console`
* how panel resources interact with existing services and policies
* how notifications, audit logs, and settings appear across panel/custom UI

Required output:

* migration sequence from proof-only operational routes into unified app navigation
* panel resource standards for permission, timezone display, and diagnostic table behavior
* explicit stop conditions for creating new transitional routes

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

## Recommended Remaining Order

1. Audit Phase 1 screens and classify each as permanent, transitional, or migration candidate.
2. Write the route/panel ownership decision.
3. Decide the app shell and persistent navigation strategy.
4. Review visual design/template options and lock a minimal design baseline.
5. Convert the proof outcome into an integrated migration plan for existing surfaces.
6. Migrate operational proof surfaces from transitional access into unified navigation and ownership.
7. Define optional module schema installation rules before tenant-specific modules are planned.
8. Define platform-to-tenant access handoff principles before tenant rollout work begins.
9. Update standards so every future module declares UI ownership, setup/settings entries, permissions, logs, notifications, and schema installation rules before implementation.
10. Close Phase 2 only when future Phase 3 customer/public scaffolding and Phase 4 module scaffolding are repeatable.

Current progress:

* screen audit is completed and locked for Batch 6 review-readiness
* route/panel ownership map is synchronized to Batch 6 retirement slices
* Filament proof targets for audit and error logs are deployed and accepted as complete for Phase 2 proof purposes
* app shell navigation ownership has a first implementation slice through a centralized navigation contract in the Blade shell
* Batch 6 operational retirement slice updates `/platform/operations/*` target routes to redirect to app-owned operational views with gate parity
* Batch 5 visual baseline/template direction is locked: no external template, current Tailwind Blade shell, Filament-owned admin/data surfaces
* Batch 5 owner matrix is locked for dashboard, shell, users, settings, notifications, operational logs, docs vault, and setup pages
* Batch 6 users retirement slice resolves `/platform/administration/users` to app-owned `/platform/users` while keeping `/console/platform-users` as direct transitional proof access
* Batch 6 sets `CONSOLE_PROOF_PATHS_ENABLED=false` as the default so direct `/console/*` proof access is deprecated while app-owned fallback redirects remain
* Batch 5 target administration routes are implemented for users, notifications, and settings
* Batch 5 operational setup links use `/platform/operations/*` target routes
* broad custom Livewire shell work remains deferred behind core migration deliverables
* next implementation sequence is: final staging visual review and sign-off, then close Phase 2 with Phase 3/4 handoff sequencing

## Remaining Decisions

### UI design decisions

Locked at Phase 2 close:

* current dashboard layout remains app-owned custom Blade
* current top header/sidebar model remains app-owned custom Blade shell
* Filament data-table density/style follows Filament-native patterns for migrated admin/operational surfaces
* full-width desktop behavior remains the current Tailwind Blade shell baseline
* current responsive behavior remains the Phase 2 baseline pending Phase 3 design-system expansion
* docs vault remains a specialized custom view and locked exception

### Templating decisions

Locked at Phase 2 close:

* no dashboard/admin template is adopted
* current Tailwind Blade shell baseline is retained
* future template/design-system work is deferred and must be evaluated under later-phase scope

### Framework boundary decisions

Open:

* final removal timing for `/console/*` proof resources after post-close monitoring
* whether platform-management and core-app admin screens finish Phase 2 as a hybrid shell with shared design and unified navigation entry points
* whether future tenant screens use a separate panel provider
* whether Livewire is used outside Filament before Phase 3
* broad post-Phase-2 migration disposition sequencing for custom Blade screens beyond locked Phase 2 ownership

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
* implementation details for token storage, revocation, and tenant-auth callback exchange timing

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
* transitional `/console` usage is resolved into the unified app direction and route plan
* existing Phase 1 screens have a disposition list
* users/settings/notifications/operational-log surfaces have explicit owner+route migration plans
* optional module schema installation pattern is documented
* platform-to-tenant access direction is documented
* standards require future modules to declare UI ownership and schema installation behavior during design
* Phase 3 customer/public scaffolding and Phase 4 module scaffolding are clear enough to build without inventing patterns

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 1]] | [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 2]] | [Phase 2 - Implementation Batch 2](Phase%202%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 5]] | [Phase 2 - Implementation Batch 5](Phase%202%20-%20Implementation%20Batch%205.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 6]] | [Phase 2 - Implementation Batch 6](Phase%202%20-%20Implementation%20Batch%206.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](../../Architecture/Stack%20Overview.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)
* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)
