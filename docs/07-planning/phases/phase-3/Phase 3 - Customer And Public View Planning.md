# Phase 3 - Customer And Public View Planning

This document defines the canonical scope and intent for Phase 3 - Customer And Public View Planning.

## Purpose

Plan Phase 3: customer/public-facing foundations that must exist before broad core-module expansion so outward-facing business features do not need late reintegration.

This note is the active planning surface for customer/public route ownership, visibility models, events-driven public business presentation, and Microsoft Graph email delivery foundations.

Brochure-site authoring and publishing blueprinting now has a dedicated planning companion:

* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)

## Implementation Status

Current status:

* Phase 3 planning has started
* V1 Events module review indicates customer/public functionality is an architectural prerequisite for multiple outward-facing modules
* implementation now consumes Phase 2 Batch 6 close-out contracts for handoff token direction and UI ownership declaration requirements
* no Phase 3 customer/public implementation has started yet

Canonical roadmap owner:

* [Feature Roadmap](../../roadmap.md)

Phase index:

* [Phase 3 Index](Phase%203%20Index.md)

## Source Review Inputs

This Phase 3 draft is informed by:

* Events
* Event Website Sync
* Website Sync Architecture
* Events Routes
* Events Data Model
* [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [Phase 3 - Microsoft Graph Email Sending Planning](Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [Phase 3 - OAuth And Customer Access Mode Planning](Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)

## Phase Goal

Establish customer/public-facing contracts early enough that:

* outward-facing event and business-module views are part of initial design rather than retrofitted later
* portal and public visibility rules are defined before core-module expansion
* customer account-creation and enrollment models are established before customer-capable modules start inventing their own access flows
* tenant email-delivery behavior is built on one configurable Microsoft Graph foundation before module-specific automation grows
* legacy JSON publishing support can be added cleanly where business continuity requires it
* platform-controlled integrations and tenant-operated workflows remain clearly separated
* external identity and Graph implementation are built on a deliberate Phase 3 security substrate instead of on one-off shortcuts

## Why Phase 3 Must Come Before Broad Module Expansion

The V1 custom Events module proves that at least some tenant business modules are not complete when only the internal admin side exists.

In V1, Events included:

* admin CRUD and setup
* public event access
* sponsor and public presentation controls
* photo-drop uploads and moderation
* website JSON publishing
* scheduler-driven sync behavior

That means V2 needs customer/public foundations before broader module rollout, or later phases will be forced to revisit modules for:

* public/customer route models
* public visibility and policy rules
* payload shaping and rendering
* publishing integration points
* outward-facing UX patterns

## Recommended Scope For Phase 3

Phase 3 should establish:

1. customer and public route ownership model
2. customer/public shell and navigation baseline
3. public versus customer-authenticated visibility contracts
4. OAuth sign-in policy contracts (Google and Microsoft providers first, with an extensible policy model for additional major providers later)
5. per-tenant customer access mode contracts (`disabled`, `invite_only`, `open_enrollment`)
6. customer account-creation and enrollment standards, including tenant-created/invited, self-registration, invitation-only, and code/invite-based acceptance pathways
7. customer company multi-user authorization model
8. module-level and record-level customer visibility contracts
9. outward-facing module rendering conventions
10. events as the first outward-facing business module proof
11. data API and query contracts for Phase 4/Phase 5 integration with legacy website connectors
12. brochure-site authoring, publish-contract, and portable delivery direction
13. shared app-mailer configuration and Microsoft Graph email sending foundation with platform defaults, tenant overrides, per-feature alias mapping, and notice preference policy

## Customer Account Creation And Enrollment Standards

Phase 3 should establish the shared contract for how customer-capable surfaces gain accounts.

Required pathways to define now:

* tenant-created accounts
* tenant-invited accounts
* invitation-only customer access
* open self-registration where tenant policy allows it
* code- or invite-based acceptance paths when a tenant requires controlled enrollment without full manual account creation

These pathways are planning milestones, not final UX decisions. Phase 3 should lock the allowed contract set and policy vocabulary so later modules do not invent incompatible account-entry models.

## Microsoft Graph Email Delivery Foundation

Phase 3 should establish one shared email-delivery foundation for all transactional and automated module mail.

Required baseline:

* application mailer configuration model and provider-abstraction direction for transactional outbound email
* Microsoft Graph-backed outbound mail transport for transactional application email
* GUI setup for platform-managed default sender accounts and aliases
* GUI setup for tenant-managed sender accounts and aliases when tenants choose custom domain mailboxes
* feature-level sender alias routing (for example finance, notifications, events, support)
* user preference controls for optional notification classes
* non-optional notice classes that cannot be opted out when legally or operationally required

Mandatory notice baseline should include at least:

* manually sent invoices and invoice delivery confirmations
* invoice overdue reminders and escalating past-due notices
* legally or contractually required billing and support status notices

Detailed planning note:

* [Phase 3 - Microsoft Graph Email Sending Planning](Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)

## Events Module Implications For V2

Recommended V2 direction:

* Events should be a shared-core module with optional capability toggles, not a replacement-style add-on over a base event feature
* advanced outward-facing capabilities should be data-driven and enableable per tenant
* platform should own publishing-adapter configuration and policy
* tenant users should operate event content and day-to-day publishing workflows through their tenant GUI once enabled

Suggested event capability toggles:

* public event visibility
* short-code public access
* sponsor management
* photo-drop uploads
* moderation tools
* website JSON publishing
* legacy-site compatibility mode

Detailed planning note:

* [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)

## Customer/Public Foundation Contracts

Phase 3 should define explicit contracts for:

* `public` surfaces: no authentication required, controlled by visibility rules and publish state
* `customer` surfaces: customer-authenticated and scoped to permitted records
* `staff` surfaces: tenant admin/staff internal management
* `platform` surfaces: platform-only control-plane and integration configuration

OAuth and access-mode baseline:

* support Google and Microsoft OAuth provider contracts for allowed sign-in surfaces
* keep the provider-policy contract extensible enough to add other major providers later without changing the customer/staff access-mode model
* per-tenant customer auth mode must be configurable as `disabled`, `invite_only`, or `open_enrollment`
* customer login mode must be enforceable independently from staff login mode
* customer account-creation pathways must be configurable independently from the OAuth provider choice

Customer company baseline:

* customer-facing records are owned by customer companies, not loose individual user links
* each customer company can include multiple customer users with membership roles
* authorization checks must enforce tenant context, customer-company ownership, and user membership before module visibility flags are evaluated

Module visibility baseline:

* each customer-capable module must support module-level customer visibility toggle
* each customer-visible record must support record-level visibility decision where required
* module-level enablement must never override ownership-based authorization

These contracts must be declared during feature design so later modules do not invent their own outward-facing models.

## Out Of Scope

Not in current Phase 3 scope:

* legacy JSON connector setup GUI (Phase 5 tenant initialization)
* publishing job framework or scheduler (Phase 5)
* full website CMS editing or page builder tooling (future)
* generalized website content management and deployment pipelines (future)
* tenant self-service creation of publishing integrations (future)
* broad remaining core-module rollout (moved to Phase 4)
* tenant provisioning/runtime rollout (Phase 5)

## Proposed Delivery Sequence

1. Define customer/public route and shell ownership.
2. Define visibility and access contracts for public, customer, staff, and platform surfaces.
3. Prove one outward-facing business module with Events and clean data APIs.
4. Lock reusable patterns before Phase 4 module expansion.

## Entry Criteria

Phase 3 implementation should not start until Phase 2 confirms:

* final route/panel/UI ownership decisions
* shell and navigation direction
* which surfaces remain custom versus Filament-owned
* platform-to-tenant access handoff direction and mandatory audit events
* UI ownership declaration matrix requirements for future module plans
* internal shell-family, page/module scaffolding, and setup/settings registration standards are explicit enough that customer/public shells can be designed as a deliberate extension rather than an ad hoc exception

Phase 3 implementation should also wait for the following security prerequisites:

* the first Phase 3 implementation lane defines and delivers the security substrate for outward-facing auth and Graph-bearing integrations
* login abuse defenses are in place before customer/public or OAuth-enabled auth surfaces broaden exposure
* the secret-backed settings and credential-reference model needed by OAuth and Microsoft Graph is delivered before provider credentials are treated as deployable
* auth-bearing Phase 3 surfaces adopt the required runtime hardening and production environment checks before they are treated as review-ready

## Exit Criteria

Phase 3 can close when:

* customer/public route and visibility contracts are documented and implemented
* at least one outward-facing module proof validates the pattern
* Events module exposes clean data APIs for Phase 5 publishing connector integration
* Phase 4 can build core modules with publishable data contracts without re-inventing outward-facing integration rules

## Related

* [Phase 3 Index](Phase%203%20Index.md)
* [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
* [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [Phase 3 - Microsoft Graph Email Sending Planning](Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [Phase 3 - OAuth And Customer Access Mode Planning](Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)
* [Phase 4 - Remaining Core Module Planning](../phase-4/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [Phase 2 - Final Stack And UI System Planning](../phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Feature Roadmap](../../roadmap.md)
