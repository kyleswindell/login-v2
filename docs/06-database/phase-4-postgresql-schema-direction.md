# Phase 4 PostgreSQL Schema Direction

This document defines the canonical scope and intent for Phase 4 PostgreSQL Schema Direction.

## Purpose

Capture canonical PostgreSQL schema/table direction by module family.

## Schema Direction By Table Family

| Module family | PostgreSQL-first table direction | Notes |
| --- | --- | --- |
| CRM | `customers`, `contacts`, `customer_contact_roles`, `customer_addresses` | Replace loose contact/customer linking with explicit foreign keys and join tables. |
| Projects and Tasks | `projects`, `project_members`, `project_statuses`, `tasks`, `task_assignments`, `task_comments`, `task_time_entries` | Avoid generic `rel_type` patterns; use explicit ownership and membership tables. |
| Finance | `estimates`, `estimate_items`, `proposals`, `proposal_items`, `invoices`, `invoice_items`, `payments`, `payment_allocations`, `tax_rates` | Use numeric money columns, stable status enums, and explicit allocation tables. |
| Contracts and Subscriptions | `contracts`, `contract_versions`, `subscriptions`, `subscription_plans`, `subscription_cycles` | Keep recurring billing state separate from document/version history. |
| Support | `tickets`, `ticket_statuses`, `ticket_priorities`, `ticket_messages`, `ticket_participants`, `ticket_attachments` | Model conversations explicitly instead of packing message state into ticket rows. |
| Content and Knowledge | `knowledge_base_articles`, `knowledge_base_categories`, `announcement_posts`, `announcement_audiences` | Keep publishing metadata explicit; use `jsonb` only for extensibility fields. |
| Reporting support | materialized views or reporting tables as needed | Prefer transaction-source tables first, then derived reporting structures where justified. |

## Related

- [Database Index](index.md)
- [Schema Hub](schema.md)
