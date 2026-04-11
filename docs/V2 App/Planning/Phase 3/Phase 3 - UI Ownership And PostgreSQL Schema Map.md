# Phase 3 - UI Ownership And PostgreSQL Schema Map

## Purpose

Document the current planning recommendation for Phase 3 UI ownership, Filament fit, Livewire fit, and PostgreSQL-first schema direction for each core module.

This note is a second-pass planning artifact that combines:

* Phase 2 final stack/UI guidance
* V1 feature and setup behavior
* V1 table families and column patterns
* V2 database and service conventions already established in Phase 1

## Implementation Status

Current status:

* planning drafted
* no Phase 3 module code has started yet
* recommendations here are planning defaults and may be refined when Phase 2 closes panel/shell decisions

Root planning owner:

* [[V2 App/Planning/Phase 3/Phase 3 - Remaining Core Module Planning]] | [Phase 3 - Remaining Core Module Planning](Phase%203%20-%20Remaining%20Core%20Module%20Planning.md)

## Source Inputs

UI and stack inputs:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](../Phase%202/Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)

V1 feature and schema inputs:

* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../../../V1%20App/Reference/Setup%20And%20Settings%20Map.md)
* [[V1 App/Reference/Database Schema And Relationships]] | [Database Schema And Relationships](../../../V1%20App/Reference/Database%20Schema%20And%20Relationships.md)
* [[V1 App/Reference/Admin Core Data Model]] | [Admin Core Data Model](../../../V1%20App/Reference/Admin%20Core%20Data%20Model.md)
* [[V1 App/Reference/Events Data Model]] | [Events Data Model](../../../V1%20App/Reference/Events%20Data%20Model.md)

## Phase 3 UI Ownership Defaults

Planning default:

* use Filament first for CRUD-heavy internal/admin module management surfaces
* use custom Blade or Livewire for specialized workflow-heavy pages, real-time experiences, or public/customer-facing flows
* keep business logic in services, actions, events, policies, and jobs rather than in Filament resources
* treat Setup and Settings as module contracts that may be rendered through Filament pages/forms unless the workflow is wizard-like or specialized

Module-by-module UI recommendation:

| Module | Recommended UI owner | Why |
| --- | --- | --- |
| Customers And Contacts | Filament-first | CRUD-heavy records, groups, contacts, assignments, notes, and admin data management fit resource/page patterns well. |
| Sales Core | Hybrid | record indexes and admin forms fit Filament; document composition, previews, and send/payment workflows may need custom Blade or Livewire. |
| Finance Setup | Filament-first | master-data and settings management fit Filament forms/tables cleanly. |
| Expenses | Filament-first | table/filter/form workflows are straightforward admin CRUD. |
| Contracts | Filament-first with custom exceptions | contract records/types fit Filament; rich signing or public acceptance flows should remain outside Filament if introduced later. |
| Projects | Hybrid | CRUD shell fits Filament, but discussions, milestones, timelines, and activity-heavy views may need custom Livewire or Blade. |
| Tasks | Hybrid | list/detail/admin management fits Filament, but kanban, timers, checklists, and live interaction are better treated as Livewire/custom workflow surfaces. |
| Support | Hybrid | ticket tables/setup fit Filament, but agent workspace, threaded conversation, and future realtime interactions may need custom UI. |
| Leads | Filament-first, with optional Livewire pipeline later | lead records and setup tables are CRUD-heavy; visual conversion/pipeline views can be layered later. |
| Estimate Requests | Hybrid | form definitions and statuses fit Filament; public intake/submission pages should remain custom. |
| Knowledge Base | Filament-first for authoring/admin | article/group management fits Filament; public or customer-facing reading surfaces are Phase 4 concerns. |
| Reports | Custom or hybrid | report filters may fit Filament, but chart-heavy dashboards, exports, and comparative analysis should not be forced into panel resources. |

## Phase 3 Setup And Settings UI Guidance

Default rule:

* module setup catalogs, defaults, and master-data managers should prefer Filament pages/forms
* module onboarding flows, wizards, or operational guidance pages may remain custom Blade/Livewire when they do not map cleanly to panel resources
* public forms are not Filament targets just because their admin definitions are

Examples:

* Support departments, priorities, statuses, and canned replies are good Filament pages/resources
* Lead sources and statuses are good Filament setup resources
* Estimate request form builders may start in Filament, but public estimate request submission should remain custom
* Task board and timer workflows should not be forced into Filament if Livewire/custom interaction is materially better

## PostgreSQL Schema Design Direction

Phase 3 schema work should follow these V2 rules:

* no `tbl` prefixes or Perfex-era naming carryover
* plural snake_case table names
* explicit foreign keys for owned relationships whenever practical
* dedicated join tables for many-to-many relationships
* `jsonb` only for metadata/extensibility, not for core transactional data
* `timestampTz`-style semantics preferred for business events, due dates, and audit-sensitive time fields
* `numeric(19,4)` style columns for money rather than float types
* stable public identifiers (`uuid` or `ulid`) where records may be referenced externally
* use unique constraints and partial/composite indexes intentionally for natural keys and filtered workloads
* avoid Perfex-style soft relationships such as `relid` or `itemable` unless the polymorphism is strongly justified and documented

V2 should preserve the useful V1 concepts, not the V1 table design shortcuts.

## Existing V2 Convention Signals

Current Phase 1 migrations already point in the correct direction:

* simple plural table names such as `users`, `settings`, `notifications`, and `platform_audit_logs`
* explicit foreign keys via `foreignId(...)->constrained(...)`
* indexed timestamps and event fields for operational queries
* JSON columns reserved for settings metadata and notification payloads rather than main record structure

Phase 3 should continue that direction rather than introducing Perfex-style generic relationship columns.

## Module Schema Mapping Draft

### 1. Customers And Contacts

Relevant V1 tables:

* `tblclients`
* `tblcontacts`
* `tblcustomer_groups`
* `tblcustomers_groups`
* `tblcustomer_admins`

Relevant V1 behavior:

* customer companies and multiple contacts are foundational dependencies for sales, contracts, projects, support, and portal visibility
* V1 uses `userid` and other mixed naming conventions that should not be preserved

Recommended V2 table family:

* `customers`
* `customer_contacts`
* `customer_groups`
* `customer_group_memberships`
* `customer_staff_assignments`
* optional later: `customer_notes`, `customer_attachments`, `customer_vault_entries`

Recommended V2 changes from V1:

* replace `userid` naming with explicit `customer_id`
* separate company record from contact records cleanly
* use explicit booleans like `is_primary_contact` rather than inferred behavior
* prefer structured address fields or a dedicated address table over mixed free-text blobs when operationally useful
* ensure customer lifecycle states are explicit (`active`, `inactive`, `prospect`, etc.)

### 2. Sales Core

Relevant V1 tables:

* `tblestimates`
* `tblinvoices`
* `tblcreditnotes`
* `tblinvoicepaymentrecords`
* `tblpayments`
* `tblitems`
* `tblitems_groups`
* `tblitemable`
* `tblitem_tax`

Relevant V1 behavior:

* estimates, invoices, credit notes, payments, and item catalogs are tightly coupled to customers and finance setup
* V1 uses polymorphic line attachment patterns that reduce DB-level clarity

Recommended V2 table family:

* `estimates`
* `estimate_line_items`
* `invoices`
* `invoice_line_items`
* `credit_notes`
* `credit_note_line_items`
* `payments`
* `payment_allocations`
* `catalog_items`
* `catalog_item_groups`

Recommended V2 changes from V1:

* replace `tblitemable` and `tblitem_tax` with explicit line-item tables or clearly owned line-item relations
* use `payment_allocations` to model invoice-credit/payment relationships explicitly
* treat catalog items as reusable pricing/catalog records, not inventory records by default
* support immutable financial snapshots on line items so document history survives future catalog changes
* reserve subscriptions for a later scoped decision unless Phase 3 scope explicitly expands

### 3. Finance Setup

Relevant V1 tables:

* `tbltaxes`
* `tblcurrencies`
* `tblpayment_modes`
* expense category records used by expenses

Recommended V2 table family:

* `taxes`
* `currencies`
* `payment_methods`
* `expense_categories`

Recommended V2 changes from V1:

* prefer `payment_methods` over `payment_modes` naming
* use ISO currency codes and explicit decimal precision metadata
* track activation state and display ordering as first-class columns
* keep setup/master-data tables distinct from transactional sales tables

### 4. Expenses

Relevant V1 tables:

* `tblexpenses`
* expense-category setup tables

Recommended V2 table family:

* `expenses`
* `expense_categories` (shared with finance setup)
* optional later: `expense_attachments`, `expense_approvals`

Recommended V2 changes from V1:

* explicit foreign keys to customer/project when billable or related
* explicit status/approval state rather than overloaded booleans
* separate monetary columns for subtotal, tax, and total where needed

### 5. Contracts

Relevant V1 tables:

* `tblcontracts`
* contract type setup records

Recommended V2 table family:

* `contracts`
* `contract_types`
* optional later: `contract_comments`, `contract_attachments`, `contract_signatures`

Recommended V2 changes from V1:

* contract type modeled as FK, not a free-text convention
* explicit renewal/expiration/reminder fields
* signature/public acceptance behavior separated from internal CRUD concerns

### 6. Projects

Relevant V1 tables:

* `tblprojects`
* `tblproject_members`
* `tblmilestones`
* `tblproject_files`
* `tblproject_notes`
* `tblproject_activity`
* `tblprojectdiscussions`
* `tblprojectdiscussioncomments`

Recommended V2 table family:

* `projects`
* `project_memberships`
* `project_milestones`
* `project_files`
* `project_notes`
* `project_discussions`
* `project_discussion_comments`
* `project_activity_logs`

Recommended V2 changes from V1:

* explicit project lifecycle/status model
* member roles and billing relationships modeled with dedicated columns
* activity logging integrated with the shared audit/event vocabulary rather than feature-isolated log styles

### 7. Tasks

Relevant V1 tables:

* `tbltasks`
* `tbltask_assigned`
* `tbltask_followers`
* `tbltask_comments`
* `tbltask_checklist_items`
* `tbltaskstimers`

Recommended V2 table family:

* `tasks`
* `task_assignees`
* `task_followers`
* `task_comments`
* `task_checklist_items`
* `task_time_entries`

Recommended V2 changes from V1:

* replace `taskstimers` naming with explicit time-entry language
* make project linkage optional but explicit via nullable FK
* use due/start/completed timestamps with timezone-safe semantics
* keep kanban ordering separate from lifecycle state to avoid workflow coupling

### 8. Support

Relevant V1 tables:

* `tbltickets`
* `tblticket_replies`
* `tblticket_attachments`
* `tbltickets_status`
* `tbltickets_priorities`
* `tbldepartments`
* services and predefined reply setup tables

Recommended V2 table family:

* `tickets`
* `ticket_replies`
* `ticket_attachments`
* `ticket_statuses`
* `ticket_priorities`
* `support_departments`
* `support_services`
* `support_canned_replies`

Recommended V2 changes from V1:

* support setup catalogs should be normalized and fully permission-gated
* ticket/customer/contact/project relationships should use explicit nullable FKs
* email piping or IMAP ingestion should remain a separate integration concern, not a core schema shortcut

### 9. Leads

Relevant V1 tables:

* `tblleads`
* `tblleads_status`
* `tblleads_sources`
* `tbllead_activity_log`
* email integration and web-to-lead tables

Recommended V2 table family:

* `leads`
* `lead_statuses`
* `lead_sources`
* `lead_activity_logs`
* optional later: `lead_capture_forms`, `lead_email_integrations`

Recommended V2 changes from V1:

* separate pipeline/status catalogs from live lead records
* model conversion into customers explicitly rather than burying it in ad hoc controller flow
* keep intake integrations outside the main lead record when they are channel-specific

### 10. Estimate Requests

Relevant V1 tables:

* `tblestimate_requests`
* `tblestimate_request_forms`
* `tblestimate_request_status`

Recommended V2 table family:

* `estimate_requests`
* `estimate_request_forms`
* `estimate_request_statuses`
* optional later: `estimate_request_attachments`

Recommended V2 changes from V1:

* separate admin form definition from public request submission records
* explicit routing/assignment fields for intake handling
* keep public submission endpoints custom and outside Filament unless proven otherwise

### 11. Knowledge Base

Relevant V1 tables:

* `tblknowledge_base`
* `tblknowledge_base_groups`
* `tblknowedge_base_article_feedback`

Recommended V2 table family:

* `knowledge_base_articles`
* `knowledge_base_groups`
* `knowledge_base_feedback`

Recommended V2 changes from V1:

* normalize article/group ownership and visibility fields
* treat public visibility separately from internal authoring workflow
* fix naming inconsistencies from V1 (`knowedge` typo-style legacy)

### 12. Reports

Relevant V1 behavior:

* reporting aggregates data from finance, leads, knowledge base, projects, tasks, tickets, and staff activity
* V1 is report-heavy but not driven by a clean reporting contract

Recommended V2 direction:

* do not create report-owned transactional tables just to mirror source data
* use service/query-layer reporting first
* add explicit reporting snapshot/materialization tables only when performance requires them
* if snapshot tables are introduced, they should be named by purpose (`report_runs`, `report_snapshots`, `report_export_jobs`) rather than by source-feature leakage

## PostgreSQL-Specific Standards To Prefer

For V2 PostgreSQL work:

* prefer `jsonb` over `json` when queryability matters
* use partial indexes for common filtered admin workloads where appropriate
* use check constraints for narrow, stable domain rules when the value set is not expected to churn often
* use explicit unique indexes for natural identifiers such as document numbers or public codes
* favor `text` over arbitrary varchar limits unless a true business limit exists
* avoid storing booleans plus status strings that encode the same state twice

## Distinct Module Review: Inventory

Current evidence from V1:

* V1 has `items` and `item groups` inside the sales/finance surface
* the reviewed V1 docs do not show a true stock, warehouse, reorder, fulfillment, or inventory-movement subsystem
* there is no current evidence that V1 inventory behavior is a foundational shared module in the same way as customers, sales, support, projects, or setup

Planning conclusion:

* a true inventory module should **not** be treated as Phase 3 core by default based on current evidence
* catalog items should remain part of Sales Core in Phase 3
* if the product direction requires stock control later, it should be introduced as a distinct future module such as `Inventory And Fulfillment` or `Catalog And Inventory`, with its own schema and dependency review

If inventory is introduced later, likely schema families would include:

* `warehouses`
* `stock_items` or `inventory_items`
* `stock_levels`
* `stock_movements`
* `suppliers`
* `purchase_orders`

That is a materially different concern from V1-style item catalogs and should not be merged into basic sales items without a clear business requirement.

## Other Distinct Module Candidates Worth Explicit Review

### Subscriptions

V1 includes subscriptions as a distinct finance-adjacent capability.

Planning recommendation:

* do not silently bury subscriptions inside invoices/payments if recurring billing is a real product requirement
* treat subscriptions as a separate finance-adjacent module candidate with explicit scope review
* if adopted, place it after Sales Core baseline is stable because it depends on customer, invoice, payment, tax, and notification contracts

Likely V2 table family if adopted:

* `subscriptions`
* `subscription_plans` or `billing_plans`
* `subscription_cycles`
* `subscription_invoices` or explicit invoice linkage fields

### Shared Services That Should Not Become Fake Modules

The following are important, but should usually remain shared services or infrastructure rather than separate Phase 3 business modules unless a later phase changes that decision:

* custom fields
* email templates
* announcements
* todos
* calendar aggregation

These are cross-cutting surfaces that support many modules rather than standing alone as primary business domains.

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Remaining Core Module Planning]] | [Phase 3 - Remaining Core Module Planning](Phase%203%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Implementation Batch 1]] | [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
