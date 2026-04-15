# Phase 3 - OAuth And Customer Access Mode Planning

This document defines the canonical scope and intent for Phase 3 - OAuth And Customer Access Mode Planning.

## Purpose

Define Phase 3 planning for customer-facing and tenant-facing OAuth sign-in options and customer access mode controls.

This note sets the contract for Google and Microsoft/Outlook sign-in support, per-tenant account enrollment modes, and strict module and record-level customer visibility controls.

## Implementation Status

Current status:

* planning drafted
* no OAuth providers implemented yet
* no customer-access mode controls implemented yet

Parent planning note:

* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## OAuth Provider Scope

Phase 3 should support planning and interface contracts for:

* Sign in with Google (Gmail/Google Workspace identities)
* Sign in with Microsoft (Outlook.com and Microsoft Entra/Microsoft 365 identities)

Target usage:

* customer-facing sign-in where enabled by tenant policy
* tenant staff sign-in where tenant policy and platform policy allow it

## Per-Tenant Customer Access Modes

Each tenant should be able to configure customer auth mode independently.

Required modes:

1. `disabled`
   * customer login unavailable
   * no public registration routes
   * no invitation acceptance flow
2. `invite_only`
   * customer login available
   * public registration unavailable
   * tenant staff must create/invite customer users
3. `open_enrollment`
   * customer login available
   * public self-registration available
   * optional approval workflow by tenant policy

Each tenant must be able to switch between these modes via setup/settings GUI without code changes.

## OAuth Policy Controls

### Platform controls

Platform should define global policy envelopes:

* which providers are supported globally
* whether provider is allowed for customer sign-in, staff sign-in, or both
* mandatory security requirements (MFA, verified email, domain restrictions where needed)

### Tenant controls

Tenant should define local policy within platform limits:

* provider enablement per provider (Google, Microsoft)
* provider allowlist by sign-in surface (customer, staff)
* whether local-password login is enabled alongside OAuth
* default mode for new customer users (invited only vs self-enrolled)

## Customer Company And Multi-User Model

Phase 3 should formalize customer identity as:

* customer company account as the ownership boundary for business records
* one or more customer users linked to each customer company
* customer users can only access records owned by their customer company unless explicit sharing policy exists

Required contracts:

* `customer_companies` as first-class domain entity
* `customer_company_users` membership relation
* membership role model for company users (for example owner, billing, collaborator)

## Module Visibility Controls

### Per-module customer-view toggle

Every customer-facing-capable module should declare whether customer-facing access is:

* disabled
* enabled with internal-only defaults
* enabled with public/customer presentation rules

### Per-record line-item visibility controls

Where applicable, each module must support record-level visibility controls, for example:

* Events: module customer/public visibility can be disabled; if enabled, each event still requires explicit `is_public` or customer-visibility toggle
* Estimates/Quotes: visible only to attached customer company and authorized users
* Invoices: visible only to attached customer company and authorized users
* Projects: visible only to attached customer company and authorized users
* Support tickets: visible only to ticket-linked customer company users per policy

No customer user should ever see records that are not explicitly associated with their customer company context.

## Authorization Baseline

Authorization should enforce all of the following:

* tenant boundary first
* customer company ownership second
* user membership in customer company third
* module enabled and record visibility flags last

This ordering prevents accidental access due to module-level toggles without ownership checks.

## Setup And Settings Surfaces To Plan Now

### Tenant setup/settings

* customer access mode selector (`disabled`, `invite_only`, `open_enrollment`)
* provider toggles (Google, Microsoft)
* provider-by-surface policy (customer vs staff)
* invite policy defaults and approval requirements
* customer company membership and role defaults
* module customer-visibility defaults

### Module settings

Each module with customer-facing potential should define:

* module-level customer visibility toggle
* record-level visibility default
* per-record override capability
* audit events for visibility changes

## Acceptance Criteria For Phase 3 Planning Contract

* all three customer access modes are documented and represented in setup/settings contracts
* OAuth provider scope and policy boundaries are documented for Google and Microsoft
* customer company and multi-user membership model is documented
* customer-capable modules have both module-level and record-level visibility contracts
* strict ownership-based authorization ordering is documented

## Out Of Scope

Not in this note:

* provider-specific implementation code for OAuth callbacks
* full SSO/SCIM enterprise provisioning
* advanced identity federation beyond Google and Microsoft providers

## Related

* [Phase 3 Index](Phase%203%20Index.md)
* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [Phase 4 - Remaining Core Module Planning]../phase-/Phase  - Remaining Core Module Planning.md
* [Feature Roadmap](../../roadmap.md)
