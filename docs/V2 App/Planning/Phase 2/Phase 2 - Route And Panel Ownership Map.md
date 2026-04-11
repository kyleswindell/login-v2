# Phase 2 - Route And Panel Ownership Map

## Purpose

Map the route, panel, domain, and database-context ownership decisions that must be settled before Filament and broader Phase 3 modules are introduced.

This note is a Phase 2 working decision artifact.

## Implementation Status

Current status:

* drafted for Phase 2 Batch 1
* no route or panel code changes made yet
* current Phase 1 routes remain custom Blade under `/dashboard` and `/platform/...`
* Filament is not installed yet

Canonical owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

Source planning note:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

## Current Route State

Current Phase 1 route families:

| Route family | Current owner | Current purpose | Phase 2 status |
| --- | --- | --- | --- |
| `/` | custom Blade/Laravel redirect | app entry redirects guests to login and users to dashboard | keep behavior |
| `/login` | custom Blade auth | platform login | keep until panel/auth decision |
| `/dashboard` | custom Blade | main authenticated dashboard | shared core candidate |
| `/platform/users` | custom Blade | platform user management | migration candidate |
| `/platform/setup/*` | custom Blade | Setup shell pages | route strategy pending |
| `/platform/settings/*` | custom Blade | Settings pages | migration candidate |
| `/platform/notifications` | custom Blade plus Echo | notification inbox | hybrid candidate |
| `/platform/audit-logs` | custom Blade | audit log viewer | Filament candidate |
| `/platform/error-logs` | custom Blade | error log viewer | Filament candidate |
| `/platform/docs` | custom Blade | internal docs vault | keep custom Blade |
| `/platform/realtime/auth` | Laravel endpoint | Echo private-channel auth | keep backend endpoint |

## Domain-Based Context Direction

The domain should determine runtime context.

Expected direction:

| Domain type | Context | Database | Capabilities |
| --- | --- | --- | --- |
| platform domain | Parasolutions platform context | central platform DB | shared core app plus platform-management modules |
| tenant admin domain | tenant context | tenant DB and tenant DB role | shared core app plus enabled tenant modules |

This means shared core routes should not permanently depend on the word `platform`.

## Long-Term Route Direction

Recommended long-term route separation:

| Route space | Context | Purpose | Notes |
| --- | --- | --- | --- |
| `/dashboard` | platform and tenant | shared core dashboard | context chooses DB and available modules |
| `/users` or panel equivalent | platform and tenant | shared staff/user management | permissions and DB context differ by host |
| `/settings` or panel equivalent | platform and tenant | shared settings | platform-only settings are scoped separately |
| `/notifications` or panel equivalent | platform and tenant | shared notifications | Reverb/Echo channel context must stay isolated |
| `/audit-logs` or panel equivalent | platform and tenant | context-local audit visibility | central vs tenant-local log ownership differs |
| `/errors` or panel equivalent | platform primarily, tenant-local later if needed | operational error review | central operational visibility remains platform-owned |
| `/docs` or `/platform-management/docs` | platform only | internal documentation vault | not a tenant shared-core feature |
| `/tenants` or `/platform-management/tenants` | platform only | tenant registry and provisioning | future platform-management feature |
| `/platform-management/*` | platform only | platform-only operations | not available on tenant domains |

The exact paths are still open, but the direction should avoid treating shared core features as inherently platform-only.

## Filament Panel Options

### Option A: One shared core panel path per context

Pattern:

* same panel path on platform and tenant domains
* context resolver determines platform DB or tenant DB
* platform context displays extra platform-management navigation

Benefits:

* strongest user-experience consistency
* easiest to explain to users
* supports platform as first internal instance

Risks:

* panel boot logic must be careful about context
* platform-only features must be strictly hidden and policy-gated on tenant domains

### Option B: Separate internal panels with shared styling

Pattern:

* one panel for shared core app
* one panel for platform-management operations
* visual design and navigation conventions are shared

Benefits:

* clearer technical ownership
* lower risk of platform-only capabilities leaking into tenant context

Risks:

* can feel like separate products if navigation is not integrated well
* more panel/provider configuration

### Option C: Custom shell plus Filament islands

Pattern:

* current custom app shell remains primary
* Filament handles selected CRUD-heavy admin areas

Benefits:

* lower immediate migration cost
* preserves custom docs and dashboard work

Risks:

* two UI systems can drift
* future modules may need extra rules to decide where they belong

## Current Recommendation

Use Option B as the planning default unless the Filament proof of concept shows Option A is clean and safe.

Reasoning:

* user-facing style can remain consistent across platform and tenant contexts
* technical boundaries stay explicit
* platform-management capabilities can be isolated without changing the core app's visual language
* it avoids prematurely forcing every shared core screen into one complex context-aware panel

## Filament Timing Recommendation

Do not install Filament until the following are documented:

* selected panel option
* panel paths
* auth guard/session expectations
* current screen disposition list
* first proof-of-concept target

Phase 2 can still introduce Filament after this decision pass. The blocker is not tenancy being fully implemented; the blocker is unclear panel ownership.

## Open Decisions

Open:

* exact platform production domain
* exact tenant admin domain pattern
* exact Filament panel path or paths
* whether shared core routes become unprefixed, `/app/*`, or Filament-owned
* whether current `/platform/*` routes are retained as aliases, migrated, or reserved for platform-management only
* whether platform-management is a separate panel or a grouped capability inside the shared core shell

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)
