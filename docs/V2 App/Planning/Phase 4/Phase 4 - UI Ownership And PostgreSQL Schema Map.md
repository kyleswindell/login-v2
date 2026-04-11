# Phase 4 - UI Ownership And PostgreSQL Schema Map

## Purpose

Document the current planning recommendation for Phase 4 UI ownership, Filament fit, Livewire fit, and PostgreSQL-first schema direction for each core module.

This note is the Phase 4 continuation of the V1-to-V2 module mapping work after customer/public foundations are established in Phase 3.

## Implementation Status

Current status:

* planning drafted
* no Phase 4 module code has started yet

Root planning owner:

* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)

## Planning Default

Use the same core conclusions already derived from the earlier module-mapping pass:

* Filament-first for CRUD-heavy internal/admin module management surfaces
* hybrid Filament plus Livewire/custom UI for workflow-heavy modules such as Projects, Tasks, Support, and Reports
* custom/public UI remains outside Filament for customer-facing or public submission flows
* PostgreSQL-first schema design should replace Perfex soft relationships and generic polymorphic shortcuts

Module-by-module planning default:

| Module family | UI ownership default | Notes |
| --- | --- | --- |
| CRM, Customers, Contacts | Filament-first | Standard CRUD, filters, status changes, and related-record management fit panel resources well. |
| Projects and Tasks | Hybrid Filament plus Livewire/custom | Administrative CRUD can live in Filament, but board, timeline, and workflow surfaces likely need custom Livewire UI. |
| Estimates, Proposals, Invoices, Payments | Filament-first with targeted custom flows | Core finance CRUD and approval states fit Filament; document preview, send, and payment flows may need custom surfaces. |
| Contracts and Subscriptions | Filament-first with targeted custom flows | Entity management is panel-friendly; signing, renewal, and customer-facing acceptance flows stay outside the panel. |
| Support and Tickets | Hybrid Filament plus Livewire/custom | Internal queues and admin state changes fit Filament, but threaded conversation and customer-facing ticket views need custom surfaces. |
| Knowledge Base and Announcements | Filament-first | Mostly structured admin CRUD with publishing flags and role-based visibility. |
| Reports and Dashboards | Custom or Livewire-first | Cross-module metrics, charts, and drill-downs need more tailored UX than standard panel CRUD. |

Schema direction by table family:

| Module family | PostgreSQL-first table direction | Notes |
| --- | --- | --- |
| CRM | `customers`, `contacts`, `customer_contact_roles`, `customer_addresses` | Replace loose contact/customer linking with explicit foreign keys and join tables. |
| Projects and Tasks | `projects`, `project_members`, `project_statuses`, `tasks`, `task_assignments`, `task_comments`, `task_time_entries` | Avoid generic `rel_type` patterns; use explicit ownership and membership tables. |
| Finance | `estimates`, `estimate_items`, `proposals`, `proposal_items`, `invoices`, `invoice_items`, `payments`, `payment_allocations`, `tax_rates` | Use numeric money columns, stable status enums, and explicit allocation tables. |
| Contracts and Subscriptions | `contracts`, `contract_versions`, `subscriptions`, `subscription_plans`, `subscription_cycles` | Keep recurring billing state separate from document/version history. |
| Support | `tickets`, `ticket_statuses`, `ticket_priorities`, `ticket_messages`, `ticket_participants`, `ticket_attachments` | Model conversations explicitly instead of packing message state into ticket rows. |
| Content and Knowledge | `knowledge_base_articles`, `knowledge_base_categories`, `announcement_posts`, `announcement_audiences` | Keep publishing metadata explicit; use `jsonb` only for extensibility fields. |
| Reporting support | materialized views or reporting tables as needed | Prefer transaction-source tables first, then derived reporting structures where justified. |

Cross-module schema rules:

* use plural snake_case table names without Perfex `tbl` prefixes
* prefer explicit foreign keys and join tables over soft relationship columns
* use `jsonb` only for metadata or extension points, not core relational structure
* keep central platform operational tables separate from tenant business tables
* define indexes around tenant-local lookup patterns, status filters, and date-range queries early

## Related

* [[V2 App/Planning/Phase 4/Phase 4 Index]] | [Phase 4 Index](Phase%204%20Index.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
