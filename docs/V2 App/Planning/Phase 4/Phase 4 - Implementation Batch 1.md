# Phase 4 - Implementation Batch 1

## Purpose

Define the first implementation batch for Phase 4 by establishing module contracts, dependency-safe sequencing, and the first core-module delivery slice.

## Implementation Status

Current status:

* planning drafted
* not started in code

Parent planning note:

* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)

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
* permission declarations and policy gates
* audit/error logging hooks for core create/update/payment state transitions
* notification events for high-value actions (invoice state changes, payment recorded)
* clean data APIs and query contracts for Phase 5 publishing connector integration
* integration tests covering permission-gated setup/settings writes and key CRUD workflows

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
* PostgreSQL table family and foreign-key map for each module
* declared UI owner per surface (Filament, Livewire/custom Blade, or hybrid)

## Acceptance Criteria

* customers, finance setup, and sales core modules are navigable and permission-gated
* each module has at least one real setup workflow and one real settings workflow
* all module writes emit expected audit events
* critical failures route through centralized error logging
* feature tests for primary module workflows and security boundaries are passing
* automated finance and customer notices resolve sender aliases correctly and respect mandatory-notice rules
* schema decisions avoid Perfex-style soft relationships and generic polymorphic line-item shortcuts
* canonical feature docs and planning status are updated in the same work cycle

## Dependencies

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](../Phase%203/Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Microsoft Graph Email Sending Planning]] | [Phase 3 - Microsoft Graph Email Sending Planning](../Phase%203/Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../../../V1%20App/Reference/Setup%20And%20Settings%20Map.md)
* [[V2 App/Planning/Phase 4/Phase 4 - UI Ownership And PostgreSQL Schema Map]] | [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)

## Related

* [[V2 App/Planning/Phase 4/Phase 4 Index]] | [Phase 4 Index](Phase%204%20Index.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Development/Development Index]] | [Development Index](../../Development/Development%20Index.md)
