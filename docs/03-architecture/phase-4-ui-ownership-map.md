# Phase 4 UI Ownership Map

This document defines the canonical scope and intent for Phase 4 UI Ownership Map.

## Purpose

Capture the architecture-side UI ownership baseline extracted from Phase 4 planning.

## Ownership Direction

- Filament-first for CRUD-heavy internal/admin module management surfaces
- hybrid Filament plus Livewire/custom UI for workflow-heavy modules
- custom/public UI remains outside Filament for customer-facing or public submission flows

## Module Ownership Baseline

| Module family | UI ownership default | Notes |
| --- | --- | --- |
| CRM, Customers, Contacts | Filament-first | Standard CRUD, filters, status changes, and related-record management fit panel resources well. |
| Projects and Tasks | Hybrid Filament plus Livewire/custom | Administrative CRUD can live in Filament; board/timeline/workflow surfaces likely need custom Livewire UI. |
| Estimates, Proposals, Invoices, Payments | Filament-first with targeted custom flows | Core finance CRUD and approval states fit Filament; document preview/send/payment flows may need custom surfaces. |
| Contracts and Subscriptions | Filament-first with targeted custom flows | Entity management is panel-friendly; signing/renewal/customer-facing acceptance flows stay outside the panel. |
| Support and Tickets | Hybrid Filament plus Livewire/custom | Internal queues and admin state changes fit Filament; threaded conversation and customer-facing ticket views need custom surfaces. |
| Knowledge Base and Announcements | Filament-first | Structured admin CRUD with publishing flags and role-based visibility. |
| Reports and Dashboards | Custom or Livewire-first | Cross-module metrics/charts/drill-downs need tailored UX beyond standard panel CRUD. |

## Related

- [Architecture Index](index.md)
- [Phase 4 Planning Note](../07-planning/phases/phase-4/Phase 4 - UI Ownership And PostgreSQL Schema Map.md)
