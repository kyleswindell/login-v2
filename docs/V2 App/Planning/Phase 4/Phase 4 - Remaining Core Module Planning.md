# Phase 4 - Remaining Core Module Planning

## Purpose

Plan Phase 4: introduction of remaining core business modules (V1-inspired core feature set) with consistent setup views, settings surfaces, and cross-module interaction rules.

This note is the active planning surface for Phase 4 module scope, ordering, dependencies, and implementation guardrails.

## Implementation Status

Current status:

* Phase 4 planning has started
* module and interaction mapping drafted from V1 references
* implementation is blocked on final Phase 2 stack/UI ownership decisions and Phase 3 customer/public foundation outcomes
* no Phase 4 module implementation has started yet

Canonical roadmap owner:

* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)

Phase index:

* [[V2 App/Planning/Phase 4/Phase 4 Index]] | [Phase 4 Index](Phase%204%20Index.md)

## Source Review Inputs

This Phase 4 draft is informed by:

* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../../../V1%20App/Reference/Setup%20And%20Settings%20Map.md)
* [[V1 App/Features/Tenant Core Feature Allowlist]] | [Tenant Core Feature Allowlist](../../../V1%20App/Features/Tenant%20Core%20Feature%20Allowlist.md)
* [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](../../../V1%20App/Features/Tenant%20Module%20Allowlist.md)
* [[V1 App/Features/Tenant Permissions]] | [Tenant Permissions](../../../V1%20App/Features/Tenant%20Permissions.md)
* [[V2 App/Planning/Phase 4/Phase 4 - UI Ownership And PostgreSQL Schema Map]] | [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)

## Phase Goal

Deliver the remaining shared core modules after customer/public view foundations are in place, while preserving a consistent, data-driven contract for:

* setup entries
* settings groups and pages
* module-level email notice setup and preference controls
* permission declarations
* audit and error logging
* notifications
* cross-module dependency behavior
* customer-facing module and record-level visibility controls
* strict customer-company ownership authorization contracts
* data APIs and query contracts that Phase 5 can consume for tenant-initialization publishing connectors

## Proposed Phase 4 Module Scope

Phase 4 candidate modules (V1-derived, normalized for V2 boundaries):

1. Customers And Contacts
2. Sales Core (Estimates, Invoices, Payments, Credit Notes, Items)
3. Finance Setup (Taxes, Currencies, Payment Modes, Expense Categories)
4. Expenses
5. Contracts
6. Projects
7. Tasks
8. Support
9. Leads
10. Estimate Requests
11. Knowledge Base
12. Reports

Explicit follow-up scope call:

* Subscriptions should be treated as a separate finance-adjacent module candidate if recurring billing is part of the required base system, not silently assumed inside Sales Core.

Phase 4 excludes:

* tenant runtime provisioning and rollout workflows (Phase 5)
* customer/public foundation work already targeted in Phase 3
* platform-management control-plane expansion (Phase 6)

## Current Filament And UI Ownership Direction

Planning default based on Phase 2 UI docs:

* Filament-first for CRUD-heavy internal/admin module management surfaces
* hybrid Filament plus Livewire/custom UI for workflow-heavy modules such as Projects, Tasks, Support, and Reports
* custom/public UI remains outside Filament for customer-facing or public submission flows

Detailed module-by-module guidance lives in:

* [[V2 App/Planning/Phase 4/Phase 4 - UI Ownership And PostgreSQL Schema Map]] | [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)

## Setup Views And Settings Coverage Plan

Each Phase 4 module should ship with both:

* one setup-oriented entry or section for onboarding/configuration workflow
* one or more settings pages for default behavior and operational controls

Baseline mapping draft:

* Customers And Contacts: customer company and customer-user membership policy, lifecycle defaults, and company-scoped authorization defaults
* Sales Core: invoice/estimate defaults, numbering/format policy, payment defaults, overdue reminder cadence, finance sender-alias defaults, module-level customer visibility, and record-level ownership enforcement
* Finance Setup: tax catalogs, currencies, payment modes, expense categories
* Expenses: default categories, approval policy, billable defaults
* Contracts: type catalog, expiration/reminder defaults, contract notice templates and sender defaults, customer visibility defaults
* Projects: project defaults, member policy, billing defaults, customer ownership attachment rules, and record-level customer visibility controls
* Tasks: task statuses/priorities defaults, timer/reminder defaults, due-soon and past-due alert defaults, and customer-linked task visibility rules
* Support: departments, statuses, priorities, service categories, canned replies, ticket update email defaults, and customer-company ticket authorization rules
* Leads: sources, statuses, intake defaults, conversion defaults
* Estimate Requests: form templates, statuses, intake routing defaults, acknowledgement email defaults, and customer visibility defaults
* Knowledge Base: article groups, access defaults, publishing defaults
* Reports: report preset defaults, retention/export behavior, periodic report email schedule defaults, and customer-safe reporting scope rules

## Cross-Module Interaction Requirements

Phase 4 must preserve and formalize these core interaction rules:

* Customers are a base dependency for Sales, Contracts, Projects, Support, and parts of reporting.
* Sales and Finance setup must be available before invoice/payment workflows are enabled.
* Projects and Tasks should share a consistent linkage model (project-linked and standalone tasks both supported).
* Support requires setup-backed records (departments, statuses, priorities, services) before ticket intake is usable.
* Leads should support independent capture but clean conversion handoff into customer records.
* Reports should read from shared module contracts, not feature-specific one-off query assumptions.
* Module email automations should use the shared Phase 3 Graph mail delivery foundation, sender-alias routing rules, and notice-class policy model.
* Customer-facing module enablement must be separate from record-level visibility and ownership enforcement.
* Customer-facing record access must require tenant boundary, customer-company ownership, and customer-user membership validation.

## Phase 4 Design And Implementation Guardrails

Every module delivered in Phase 4 must include:

* declared permissions and policy gates
* setup page registration and settings group registration
* module-level customer visibility toggle definitions
* record-level customer visibility and ownership fields where customer-facing access is possible
* audit events for high-value state changes
* error logging coverage for critical failure paths
* notification events where user action or system state changes matter
* each automated email-capable feature must declare sender alias, template keys, user preference behavior, and mandatory-notice behavior
* feature tests for permission gates, setup/settings writes, customer-ownership authorization, and key workflows
* clean data APIs and query contracts so Phase 5 can expose module data through tenant-initialized publishing connectors

## Potential Improvements Over V1

Phase 4 should intentionally improve on V1 by:

* replacing ad hoc setup/menu coupling with data-driven module registration
* standardizing settings validation contracts by module and page
* reducing soft relationship ambiguity with explicit service-level domain contracts
* enforcing module dependency checks before module enablement
* introducing consistent status vocabularies (for tasks, tickets, leads, invoices) through shared enums/config
* creating report data contracts so reporting survives module evolution
* establishing payment integration abstraction points instead of gateway-specific coupling
* adding explicit module health/diagnostic notes for faster support and rollout readiness
* replacing Perfex-style soft relationship and polymorphic table shortcuts with PostgreSQL-first explicit schema design

## Additional Module Review

Current evidence does not support treating true stock inventory as a Phase 4 core module.

Planning default:

* keep item/catalog behavior inside Sales Core for Phase 4
* defer true stock/warehouse/procurement inventory to a future distinct module unless a concrete business requirement elevates it
* keep cross-cutting shared services such as custom fields, email templates, announcements, todos, and calendar aggregation outside the Phase 4 business-module list unless a later phase promotes them intentionally

## Risks And Mitigations

Risks:

* module scope creep across 12 feature areas
* hidden coupling inherited from V1 behavior expectations
* inconsistent setup/settings UX if module teams diverge in patterns
* regressions in permission behavior when multiple modules ship concurrently

Mitigations:

* batch modules by dependency layers, not by menu labels
* require setup/settings/permissions/logging checklist pass before feature acceptance
* lock module contracts before broad implementation starts
* keep Phase 4 development log updated per batch with integration notes and blockers

## Proposed Delivery Sequence

1. Foundation batch: Customers, Finance Setup, Sales Core contracts
2. Operations batch: Projects, Tasks, Support
3. Pipeline batch: Leads, Estimate Requests, Knowledge Base
4. Consolidation batch: Reports + cross-module hardening

## Entry Criteria

Phase 4 implementation should not start until Phase 2 confirms:

* final route/panel/UI ownership decisions
* module scaffolding standard and design-system baseline
* setup/settings registration pattern for new modules

And until Phase 3 confirms:

* customer/public shell and auth direction
* outward-facing module integration contract
* Graph email delivery foundation contract, including sender-alias routing and notice-class policy

## Exit Criteria

Phase 4 can close when:

* all planned modules have setup and settings coverage
* cross-module dependencies are documented and enforced
* required permission/audit/error/notification contracts are implemented
* canonical feature docs and planning notes are synchronized per batch
* development log captures major milestones, testing status, and unresolved carry-over items

## Related

* [[V2 App/Planning/Phase 4/Phase 4 Index]] | [Phase 4 Index](Phase%204%20Index.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Implementation Batch 1]] | [Phase 4 - Implementation Batch 1](Phase%204%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 4/Phase 4 - UI Ownership And PostgreSQL Schema Map]] | [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](../Phase%203/Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
