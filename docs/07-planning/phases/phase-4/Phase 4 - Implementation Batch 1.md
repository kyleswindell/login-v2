# Phase 4 - Implementation Batch 1

This document defines the canonical scope and intent for Phase 4 - Implementation Batch 1.

## Purpose

Define the first implementation batch for Phase 4 by establishing module contracts, dependency-safe sequencing, and the first core-module delivery slice.

## Implementation Status

Current status:

* planning drafted
* not started in code

Parent planning note:

* [Phase 4 - Remaining Core Module Planning](Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)

## Batch Goal

Deliver the first dependency-safe core slice required for broader Phase 4 rollout:

* Customers And Contacts foundation
* Finance Setup baseline (taxes/currencies/payment modes/expense categories)
* Sales Core contracts (estimates/invoices/payments/credit notes/items)

## Why This Batch First

This batch establishes data and workflow primitives that later modules rely on:

* projects, contracts, and support often require customer linkage
* invoices/payments and expense behavior require finance setup baselines
* reports and downstream customer-facing surfaces depend on sales contract stability

## In Scope

* module registration entries for the three batch modules
* setup views and settings pages for customer, finance, and sales defaults
* module notice settings using Phase 3 Graph email foundation (templates, sender alias mapping, mandatory-vs-optional policy)
* module-level customer visibility toggles and record-level ownership visibility rules for customer-facing Sales records
* customer-company and customer-user membership-aware authorization rules for estimates, quotes, and invoices
* permission declarations and policy gates
* audit/error logging hooks for core create/update/payment state transitions
* notification events for high-value actions (invoice state changes, payment recorded)
* clean data APIs and query contracts for Phase 5 publishing connector integration
* integration tests covering permission-gated setup/settings writes, ownership authorization, and key CRUD workflows

## Out Of Scope

* full projects/tasks/support/leads implementation
* customer/public foundation work (Phase 3)
* tenant rollout/provisioning behavior (Phase 5)
* platform-management control-plane expansion (Phase 6)

## Required Contracts Before Build

* module key and route namespace per module
* setup entry key and settings group keys per module
* permission matrix per module action
* event taxonomy for audits and notifications
* validation schema for each settings page
* notice taxonomy and sender-alias routing keys for each module event that can send email
* module-level customer visibility toggle contract
* record-level customer ownership visibility contract
* customer-company and customer-user membership authorization contract
* declared UI owner per surface (Filament, Livewire/custom Blade, or hybrid)

## Acceptance Criteria

* customers, finance setup, and sales core modules are navigable and permission-gated
* each module has at least one real setup workflow and one real settings workflow
* all module writes emit expected audit events
* critical failures route through centralized error logging
* feature tests for primary module workflows, security boundaries, and customer ownership authorization are passing
* customer-facing sales records are visible only to authorized users within the attached customer company
* module-level and record-level visibility toggles are enforceable by policy
* automated finance and customer notices resolve sender aliases correctly and respect mandatory-notice rules
* canonical feature docs and planning status are updated in the same work cycle

## Dependencies

* [Phase 2 - Final Stack And UI System Planning](../phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 3 - Customer And Public View Planning](../phase-3/Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Phase 3 - Microsoft Graph Email Sending Planning](../phase-3/Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [Phase 3 - OAuth And Customer Access Mode Planning](../phase-3/Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)
* V1 Feature Catalog
* Setup And Settings Map
* [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)
* [Phase 4 PostgreSQL Schema Direction](../../../06-database/phase-4-postgresql-schema-direction.md)

## Batch 1 Schema Dependencies

Phase 4 Batch 1 sequencing depends on these table families being finalized first:

* customers and contacts: `customers`, `contacts`, role/link tables
* finance setup and sales core: `tax_rates`, `currencies`, `payment_modes`, `expense_categories`, `estimates`, `estimate_items`, `invoices`, `invoice_items`, `payments`, `payment_allocations`

## Related

* [Phase 4 Index](Phase%204%20Index.md)
* [Feature Roadmap](../../roadmap.md)
* Development Index
