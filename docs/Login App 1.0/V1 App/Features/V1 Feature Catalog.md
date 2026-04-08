# V1 Feature Catalog

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document what the current V1 application actually does today, with a readable feature list that includes base Perfex behavior plus the V1 custom additions.

This note is intentionally V1-focused. It describes current behavior and current coupling in the existing app. It is not a build spec or source of truth for V2.

## Use This Note When

Use this note when you need the clearest product-level answer to:

- what V1 offers
- which feature areas are foundational versus optional
- which features are tightly coupled in practice

Do not use this note as the primary owner of:

- file-by-file implementation structure
- exact route/config/table lookups
- operational procedures

## How To Read This Note

- `Foundational` means the area is reused by many other features and usually needs to exist in any practical deployment.
- `Optional` means the area adds capability but is not required for the rest of the CRM to operate.
- `Admin-host only` means the feature belongs to the main admin CRM in the current V1 architecture, not to every tenant CRM.

## Current V1 Baseline

The current V1 app is a Perfex CRM codebase running on CodeIgniter, extended with custom multi-tenant and events behavior.

At a product level, the app currently offers:

- staff authentication and staff profile management
- customer and contact management
- quotes, estimates, invoices, credit notes, payments, items, and subscriptions
- expenses and finance configuration
- contracts
- projects and tasks
- support tickets
- leads and lead conversion
- estimate request intake forms
- knowledge base articles
- dashboards, widgets, notifications, todos, and reports
- setup, roles, permissions, settings, modules, and custom fields
- V1-specific admin-host tenant management via Admin Core
- V1-specific event and photo-drop workflows via Events

## Foundational Shared Features

These are the areas that act like shared platform capabilities inside V1.

### Login Auth

Status: Foundational

What V1 offers:

- staff login, logout, remember-me, password reset, and two-factor entry points
- customer/public authentication routes for invoices, estimates, proposals, contracts, and portal access
- session-aware redirect behavior and autologin support

Why it is foundational:

- every staff-facing feature depends on staff authentication
- notifications, profile preferences, timesheets, dashboard visibility, and setup access all attach to staff sessions

Key files:

- `application/application/controllers/admin/Authentication.php`
- `application/application/models/Authentication_model.php`
- `application/application/core/App_Controller.php`
- `application/application/config/routes.php`

### Staff, Roles, Permissions, And Setup Access

Status: Foundational

What V1 offers:

- staff records, permissions, role assignment, department membership, and profile management
- permission-gated menu visibility for sidebar, setup, and quick-create actions

Why it is foundational:

- all admin features are permission checked with `staff_can(...)` and `staff_cant(...)`
- tickets, tasks, projects, reports, setup areas, and notifications all use staff identity

Key files:

- `application/application/controllers/admin/Staff.php`
- `application/application/controllers/admin/Roles.php`
- `application/application/models/Staff_model.php`
- `application/application/models/Roles_model.php`
- `application/application/helpers/menu_helper.php`

### Customers And Contacts

Status: Foundational

What V1 offers:

- customer companies, primary contacts, multiple contacts, groups, admins, notes, attachments, vault entries, and customer profile tabs
- customer-level access to invoices, estimates, credit notes, payments, projects, contracts, support, and statements

Why it is foundational:

- sales, subscriptions, contracts, projects, support, and many reports are customer-linked
- in tenant-constrained scenarios, Admin Core can force projects to use an internal customer record, which still shows that customer linkage is a core assumption in V1

Key files:

- `application/application/controllers/admin/Clients.php`
- `application/application/models/Clients_model.php`
- `application/application/views/admin/clients/`

### Sales And Finance Core

Status: Foundational

What V1 offers:

- proposals
- estimates
- invoices
- payments
- credit notes
- items and item groups
- taxes, currencies, payment modes, expense categories

Why it is foundational:

- customer records, finance configuration, reporting, reminders, and email templates all feed this area
- projects and tasks can be billed into invoices
- subscriptions depend on invoice/payment infrastructure

Key files:

- `application/application/controllers/admin/Proposals.php`
- `application/application/controllers/admin/Estimates.php`
- `application/application/controllers/admin/Invoices.php`
- `application/application/controllers/admin/Payments.php`
- `application/application/controllers/admin/Credit_notes.php`
- `application/application/controllers/admin/Invoice_items.php`
- `application/application/models/Proposals_model.php`
- `application/application/models/Estimates_model.php`
- `application/application/models/Invoices_model.php`
- `application/application/models/Payments_model.php`
- `application/application/helpers/sales_helper.php`

### Projects And Tasks

Status: Foundational

What V1 offers:

- projects with members, milestones, files, notes, discussions, timesheets, expenses, and activity history
- standalone and project-linked tasks with assignees, followers, checklist items, comments, timers, reminders, kanban, and billing hooks

Why it is foundational:

- projects depend on staff and usually customers
- tasks can exist alone, but V1 repeatedly links tasks to projects, customers, invoices, reminders, timers, and reports
- billing flows pull billable tasks into invoices

Key files:

- `application/application/controllers/admin/Projects.php`
- `application/application/controllers/admin/Tasks.php`
- `application/application/models/Projects_model.php`
- `application/application/models/Tasks_model.php`
- `application/application/services/projects/`
- `application/application/services/tasks/TasksKanban.php`
- `application/application/helpers/projects_helper.php`
- `application/application/helpers/tasks_helper.php`

### Support

Status: Foundational

What V1 offers:

- support tickets, replies, attachments, statuses, priorities, departments, predefined replies, services, and spam filters
- project-linked or customer-linked ticket creation
- email piping and IMAP-related support infrastructure

Why it is foundational:

- tickets depend on staff, departments, statuses, and often customers or contacts
- support is wired into notifications, dashboard widgets, setup menus, and reports

Key files:

- `application/application/controllers/admin/Tickets.php`
- `application/application/controllers/admin/Departments.php`
- `application/application/controllers/admin/Spam_filters.php`
- `application/application/models/Tickets_model.php`
- `application/application/models/Departments_model.php`
- `application/application/services/MergeTickets.php`
- `application/application/services/imap/`
- `application/application/helpers/tickets_helper.php`

### Dashboard, Notifications, Logging, And Reports

Status: Foundational

What V1 offers:

- dashboard widgets for finance, tickets, leads, projects, contracts, todos, events, and personal summary data
- in-app notification bell, profile notification history, desktop notification polling, and todo/timer indicators
- admin activity log, project activity, ticket pipe log, and application error logging conventions
- reports across sales, expenses, income comparison, leads, knowledge base, and timesheets

Why it is foundational:

- this is the main cross-feature observability layer for the app
- it aggregates data from customers, finance, tickets, projects, leads, and announcements

Key files:

- `application/application/controllers/admin/Dashboard.php`
- `application/application/controllers/admin/Reports.php`
- `application/application/controllers/admin/Misc.php`
- `application/application/models/Dashboard_model.php`
- `application/application/models/Reports_model.php`
- `application/application/models/Misc_model.php`
- `application/application/views/admin/dashboard/`
- `application/application/views/admin/includes/notifications.php`
- `application/application/services/TicketsReportByStaff.php`

### Setup, Settings, Modules, And Customization

Status: Foundational

What V1 offers:

- setup menu for staff, customers, support, leads, finance, contracts, modules, custom fields, GDPR, roles, estimate request, email templates, settings, theme style, and optional help link
- settings sections for general, finance, configurable features, integrations, AI, other, and misc
- module activation and module database upgrades

Why it is foundational:

- almost every feature depends on setup records, options, permissions, or module activation state
- custom fields and email templates are shared infrastructure across many features

Key files:

- `application/application/helpers/menu_helper.php`
- `application/application/helpers/settings_helper.php`
- `application/application/controllers/admin/Settings.php`
- `application/application/controllers/admin/Mods.php`
- `application/application/controllers/admin/Custom_fields.php`
- `application/application/controllers/admin/Emails.php`
- `application/application/models/Settings_model.php`
- `application/application/models/Custom_fields_model.php`

## Feature Areas By Menu

### Dashboard

Status: Foundational

Offers:

- top-level operational summary page
- todo lists, upcoming events, contracts expiring, finance overview, ticket charts, projects activity, leads chart, payments chart, tickets report, and user widget data

Depends on:

- staff auth
- dashboard model aggregations
- underlying sales, projects, leads, contracts, tickets, todos, and announcements data

### Customers

Status: Foundational

Offers:

- customer companies
- customer contacts
- groups, admins, attachments, notes, vault entries, statements, map view, and related records

Depends on:

- staff permissions
- custom fields
- sales, projects, contracts, support, and subscriptions if those related tabs are used

### Sales

Status: Foundational

Offers:

- proposals
- estimates
- invoices
- payments
- credit notes
- items

Depends on:

- customers
- staff permissions
- taxes, currencies, payment modes, and email templates

### Subscriptions

Status: Foundational in finance-heavy deployments

Offers:

- recurring subscription records and their billing linkage

Depends on:

- customers
- invoices
- payment gateways and finance settings

### Expenses

Status: Foundational in finance-heavy deployments

Offers:

- expenses, categories, project-linked billing, and reporting

Depends on:

- staff
- finance setup
- projects for project-specific expenses

### Contracts

Status: Foundational

Offers:

- contracts, renewals, comments, attachments, signatures, reminders, and contract types

Depends on:

- customers
- staff
- email templates

### Projects

Status: Foundational

Offers:

- project records with members, billing type, milestones, files, discussions, notes, timesheets, expenses, tasks, and activity

Depends on:

- staff
- usually customers
- tasks, expenses, files, discussions, and notifications for full value

### Tasks

Status: Foundational

Offers:

- standalone tasks
- project tasks
- assignees, followers, checklists, comments, timers, reminders, kanban, billable task workflows

Depends on:

- staff
- projects for project-linked work
- invoices for billable conversion workflows

### Support

Status: Foundational

Offers:

- tickets, replies, departments, priorities, statuses, services, predefined replies, attachments, pipe log, spam filters

Depends on:

- staff
- departments and ticket setup records
- customers or contacts for most ticket flows

### Leads

Status: Optional but strongly integrated

Offers:

- lead intake, statuses, sources, email integration, web-to-lead forms, and conversion to customers

Depends on:

- staff
- custom fields
- customer creation if conversion is used

### Estimate Request

Status: Optional

Offers:

- estimate request forms, statuses, request intake, and attachments

Depends on:

- setup forms and statuses
- staff review workflows
- estimates if requests are converted into formal sales work

### Knowledge Base

Status: Optional

Offers:

- article groups, articles, feedback, public/customer access, and reporting

Depends on:

- staff authoring
- support when used as ticket deflection/support content

### Utilities

Status: Mixed foundational support tools

Offers:

- media
- bulk PDF exporter
- calendar
- announcements
- activity log
- ticket pipe log

Depends on:

- whichever underlying features produce the content being surfaced

### Reports

Status: Foundational

Offers:

- sales reports
- expense reports
- expenses vs income
- leads reports
- knowledge base reports
- timesheets overview

Depends on:

- source data from finance, leads, KB, projects, tasks, and staff timesheets

### Setup

Status: Foundational

Offers:

- administrative configuration for staff, support, leads, finance, contracts, modules, custom fields, GDPR, roles, estimate request, email templates, settings, theme style, and optional help

Depends on:

- staff permissions
- module activation state

### Notifications

Status: Foundational cross-cutting service

Offers:

- bell dropdown
- unread counters
- inline mark-as-read
- full notification history on profile
- optional desktop notification polling

Depends on:

- staff sessions
- feature-specific notification producers across projects, tickets, finance, leads, and admin workflows

### Logging

Status: Foundational cross-cutting service

Offers:

- activity log entries for audit-worthy actions
- operational error logging through application logs
- project-specific activity history
- ticket pipe log visibility

Depends on:

- feature code actually calling `log_activity(...)` and `log_message('error', ...)`

### Admin Core

Status: Optional, admin-host only, V1-specific

Offers:

- tenant records
- tenant routing support
- tenant module allowlists
- tenant core-feature allowlists
- admin-host-only views for logs, backups, and tenant management

Depends on:

- main admin CRM database
- host-based tenant routing in core config

Important note:

In V1 this concern is implemented as the `admin_core` module. That module shape is a V1 implementation detail, not a requirement for V2.

### Events

Status: Optional, module-driven, V1-specific

Offers:

- event records
- sponsor management
- blocked submitters
- uploads/review flow
- website sync/export behavior
- dashboard/calendar integration

Depends on:

- module activation
- custom event tables created at install time
- public upload/event website flows when enabled

## Dependency Rules That Matter In V1

The current codebase shows a few especially important relationships:

- Customers are a practical base dependency for Sales, Subscriptions, Contracts, Projects, Support, and many Reports.
- Staff/Auth is a base dependency for every admin-facing feature, Notifications, Logging, Dashboard, Setup, and Reports.
- Projects and Tasks are tightly coupled in V1 even though tasks can technically exist without a project.
- Finance setup records are a base dependency for Sales, Expenses, Subscriptions, and finance reporting.
- Support depends on Setup records such as Departments, Priorities, Statuses, Services, and often Customers.
- Leads can stand on their own, but their highest-value workflow is conversion into Customers.
- Admin Core belongs to the admin host only in V1.
- Events is additive and appears only after its module is installed in a given instance.

## Related

- [[V1 App/V1 App Documentation Map]] | [V1 App Documentation Map](../V1%20App%20Documentation%20Map.md)
- [[V1 App/Architecture/System Overview]] | [System Overview](../Architecture/System%20Overview.md)
- [[V1 App/Architecture/V1 Application Structure And MVC Map]] | [V1 Application Structure And MVC Map](../Architecture/V1%20Application%20Structure%20And%20MVC%20Map.md)
- [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)
- [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../Reference/Setup%20And%20Settings%20Map.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
