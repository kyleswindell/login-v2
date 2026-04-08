# V1 Application Structure And MVC Map

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Explain how the V1 application is structured in code, how requests move through the system, and how controllers, models, views, config files, helpers, hooks, libraries, and services relate to the feature areas documented elsewhere in the vault.

This note describes the current V1 implementation only. It is not a prescribed architecture for V2.

## Use This Note When

Use this note when you need the implementation map:

- request flow
- MVC responsibilities
- where config/hooks/helpers/services fit
- which files or layers support which feature areas

Do not use this note as the primary owner of:

- the user-facing feature inventory
- long-form architectural rationale
- exact table-by-table or route-by-route reference data

## Current Implementation

The current V1 app is a CodeIgniter/Perfex MVC application with custom module extensions.

The main code layers are:

- `application/application/controllers/`
- `application/application/models/`
- `application/application/views/`
- `application/application/config/`
- `application/application/helpers/`
- `application/application/hooks/`
- `application/application/libraries/`
- `application/application/services/`
- `application/modules/`

In the local repo snapshot reviewed for this note, the app contains roughly:

- 77 controller files
- 47 model files
- 580 view files
- 47 helper files
- 19 config files
- 6 hook/bootstrap files
- 75 service classes/files

## Request Flow

A typical admin request follows this path:

1. `index.php` boots CodeIgniter and Perfex.
2. `application/application/config/routes.php` maps the URL to a controller/action.
3. `application/application/config/hooks.php` registers early hook handlers.
4. `application/application/hooks/App_Autoloader.php`, `InitModules.php`, and `InitHook.php` prepare classes, module bootstrapping, and shared app services.
5. `application/application/core/App_Controller.php` performs app-level initialization.
6. `application/application/core/AdminController.php` enforces staff auth, tenant-aware restrictions, setup warnings, quick actions, and shared admin view state.
7. The target controller loads models, helpers, services, and views.
8. Models query the database, often with helper-generated SQL fragments or relation helpers.
9. Views render HTML, often with subviews, shared includes, and JS/CSS assets registered by helpers or services.

## MVC In Practice

### Controllers

Controllers are the request entry points. In V1 they usually do four things:

- check permission and tenant access
- gather view data from models and services
- branch between full-page and AJAX/table responses
- choose the view or JSON response

Examples:

- `application/application/controllers/admin/Clients.php` drives customer profile tabs and related record views.
- `application/application/controllers/admin/Invoices.php` loads invoice list filters, customer billing context, and invoice actions.
- `application/application/controllers/admin/Projects.php` coordinates projects, expenses, members, and tenant-aware internal-customer fallback.
- `application/application/controllers/admin/Tasks.php` switches between task list, kanban, timers, and billable-task AJAX helpers.
- `application/application/controllers/admin/Tickets.php` drives ticket list, ticket detail, reply flows, and support setup records.

### Models

Models own most database access and business rules.

Common patterns in the reviewed code:

- joining related entities such as customers, contacts, staff, and statuses
- storing attachments and notes through relation tables using `rel_type` and `rel_id`
- logging activity after important changes
- sending notifications or mail templates after mutations
- converting between features, such as leads to customers or billable tasks to invoice lines

Examples:

- `Clients_model` links customers to contacts, groups, admins, statements, and related sales/project data.
- `Projects_model` orchestrates project members, files, tasks, expenses, discussions, notes, activity, and notifications.
- `Tasks_model` manages assignments, followers, timers, checklist items, billing eligibility, and task filtering.
- `Tickets_model` manages statuses, priorities, services, replies, attachments, merges, assignees, and notifications.
- `Reports_model` aggregates data across invoices, payments, expenses, leads, and timesheets.

### Views

Views are mostly server-rendered PHP templates.

Important view patterns:

- feature folders under `application/application/views/admin/<feature>/`
- shared includes under `application/application/views/admin/includes/`
- sidebar/setup/header components shared across features
- table partials and widget partials for AJAX-heavy screens
- settings group views under `application/application/views/admin/settings/includes/`

Examples:

- dashboard widgets live in `application/application/views/admin/dashboard/widgets/`
- notifications render from `application/application/views/admin/includes/notifications.php`
- settings pages compose from `application/application/views/admin/settings/all.php` plus group includes

## Configuration And Bootstrap Files

### Core Config Files

These files shape how the whole application behaves:

- `application/application/config/routes.php`
  Maps URLs to controllers. This includes custom admin routes that send `/admin/events/...` into the Events module.
- `application/application/config/database.php`
  Handles V1 multi-tenant database routing by host, including admin-host lookup of `tbltenants`.
- `application/application/config/hooks.php`
  Registers pre-system, pre-controller, and post-controller hook handlers.
- `application/application/config/autoload.php`
  Declares always-loaded libraries/helpers/config.
- `application/application/config/config.php`
  Base framework/app settings.
- `application/application/config/constants.php`
  Shared constants used throughout the app.
- `application/application/config/migration.php`
  Migration behavior.
- `application/application/config/email.php`
  Email transport defaults.

### Hook Bootstrap Files

- `application/application/hooks/App_Autoloader.php`
  Adds Perfex/CodeIgniter class-loading support.
- `application/application/hooks/InitModules.php`
  Loads early module config such as CSRF exclusions before normal request handling.
- `application/application/hooks/InitHook.php`
  Loads shared libraries, loads active modules, includes module init files, and fires module boot hooks.
- `application/application/hooks/EnhanceSecurity.php`
  Adds early request hardening.

## Shared Libraries, Helpers, And Services

### Libraries

The app libraries provide shared framework-like behavior above raw CodeIgniter:

- `application/application/libraries/App_menu.php`
  Owns sidebar, setup, theme, and user menu registration.
- `application/application/libraries/App.php`
  Owns settings sections, app metadata, version helpers, and some shared UI support.
- `application/application/libraries/App_table.php`
  Drives reusable table/list rendering for many admin screens.

### Helpers

Helpers are heavily used in V1 to centralize feature-specific glue.

Important examples:

- `menu_helper.php`
  Builds the default admin sidebar and setup menu.
- `settings_helper.php`
  Registers settings sections and settings child pages.
- `relation_helper.php`
  Resolves cross-feature relations such as customer, project, invoice, or task references.
- `projects_helper.php`, `tasks_helper.php`, `tickets_helper.php`, `sales_helper.php`
  Feature-specific helper logic for permissions, rendering, or shared calculations.
- `modules_helper.php`
  Module registry/support functions.
- `admin_helper.php` and `general_helper.php`
  Broad utility behavior used across many features.

### Services

Services hold richer behavior that would otherwise bloat controllers or models.

Important examples:

- `application/application/services/tasks/TasksKanban.php`
  Task kanban filtering and paging.
- `application/application/services/projects/`
  Gantt and project chart builders.
- `application/application/services/TicketsReportByStaff.php`
  Ticket dashboard/report aggregation by staff member.
- `application/application/services/ActivityLogger.php`
  Shared activity logging support.
- `application/application/services/imap/`
  Support email ingestion support.
- `application/application/services/ai/`
  AI integration support for ticket-related features.

## Menus And Navigation Wiring

The current feature surface is primarily wired from two files:

- `application/application/helpers/menu_helper.php`
- `application/application/helpers/settings_helper.php`

`menu_helper.php` defines the default sidebar and setup menus for:

- Dashboard
- Customers
- Sales
- Subscriptions
- Expenses
- Contracts
- Projects
- Tasks
- Support
- Leads
- Estimate Request
- Knowledge Base
- Utilities
- Reports
- Setup sections such as Staff, Customers, Support, Leads, Finance, Contracts, Modules, Custom Fields, GDPR, Roles, Email Templates, Estimate Request, and Settings

`settings_helper.php` defines the settings-page section hierarchy for:

- General
- Finance
- Configure Features
- Integrations
- Other
- Misc
- AI Integration

Module code can extend both menus. In the reviewed V1 code:

- `application/modules/admin_core/admin_core.php` adds the admin-host-only `Admin Core` menu.
- `application/modules/events/events.php` adds the `Events` menu and related event workflow entries.
- `application/modules/theme_style/theme_style.php` adds the `Theme Style` setup item.

## Feature-To-Code Map

### Dashboard And Widgets

Primary files:

- controller: `application/application/controllers/admin/Dashboard.php`
- model: `application/application/models/Dashboard_model.php`
- views: `application/application/views/admin/dashboard/`
- widgets: `application/application/views/admin/dashboard/widgets/`

Cross-feature data pulled in:

- contracts
- todos
- tickets
- projects
- leads
- payments
- announcements
- calendar data

### Login Auth

Primary files:

- controller: `application/application/controllers/admin/Authentication.php`
- model: `application/application/models/Authentication_model.php`
- base controller: `application/application/core/App_Controller.php`
- routes: `application/application/config/routes.php`

Cross-feature dependencies:

- staff sessions
- remember-me/autologin support
- two-factor and password reset flows
- customer/public access to sales and contract documents

### Customers

Primary files:

- controller: `application/application/controllers/admin/Clients.php`
- model: `application/application/models/Clients_model.php`
- views: `application/application/views/admin/clients/`

Cross-feature dependencies:

- contacts
- groups
- invoices
- estimates
- credit notes
- projects
- contracts
- statements
- vault entries

### Subscriptions

Primary files:

- controller: `application/application/controllers/admin/Subscriptions.php`
- model: `application/application/models/Subscriptions_model.php`
- views: `application/application/views/admin/subscriptions/`
- helper: `application/application/helpers/subscriptions_helper.php`

Cross-feature dependencies:

- customers
- invoices
- payment gateways
- finance settings

### Expenses

Primary files:

- controller: `application/application/controllers/admin/Expenses.php`
- model: `application/application/models/Expenses_model.php`
- views: `application/application/views/admin/expenses/`

Cross-feature dependencies:

- staff
- customers when billing is involved
- projects for project expenses
- reports and finance setup

### Contracts

Primary files:

- controller: `application/application/controllers/admin/Contracts.php`
- model: `application/application/models/Contracts_model.php`
- views: `application/application/views/admin/contracts/`
- helper: `application/application/helpers/contracts_helper.php`

Cross-feature dependencies:

- customers
- staff
- reminders
- attachments
- email templates

### Sales And Finance

Primary files:

- controllers: `Proposals.php`, `Estimates.php`, `Invoices.php`, `Payments.php`, `Credit_notes.php`, `Invoice_items.php`
- models: matching sales models under `application/application/models/`
- helpers: `sales_helper.php`, `invoices_helper.php`, `estimates_helper.php`, `credit_notes_helper.php`

Cross-feature dependencies:

- customers
- payment modes
- currencies
- taxes
- expenses-to-bill
- billable tasks
- subscriptions
- reports

### Projects And Tasks

Primary files:

- controllers: `Projects.php`, `Tasks.php`
- models: `Projects_model.php`, `Tasks_model.php`
- services: `services/projects/`, `services/tasks/TasksKanban.php`
- views: `application/application/views/admin/projects/`, `application/application/views/admin/tasks/`

Cross-feature dependencies:

- staff
- customers
- invoices
- expenses
- files
- notes
- reminders
- notifications
- timesheets

### Support

Primary files:

- controllers: `Tickets.php`, `Departments.php`, `Spam_filters.php`
- model: `Tickets_model.php`
- services: `MergeTickets.php`, `services/imap/`
- views: `application/application/views/admin/tickets/`

Cross-feature dependencies:

- customers and contacts
- departments
- priorities
- statuses
- predefined replies
- services
- notifications
- reports
- knowledge base

### Leads

Primary files:

- controller: `application/application/controllers/admin/Leads.php`
- model: `application/application/models/Leads_model.php`
- service: `application/application/services/leads/LeadsKanban.php`

Cross-feature dependencies:

- lead statuses and sources
- email integration
- web-to-lead forms
- conversion into customers

### Estimate Request

Primary files:

- controller: `application/application/controllers/admin/Estimate_request.php`
- model: `application/application/models/Estimate_request_model.php`
- views: `application/application/views/admin/estimate_request/`

Cross-feature dependencies:

- forms and statuses from setup
- attachments and notifications
- downstream estimate creation workflows

### Knowledge Base

Primary files:

- controller: `application/application/controllers/admin/Knowledge_base.php`
- model: `application/application/models/Knowledge_base_model.php`
- public routes in `application/application/config/routes.php`

Cross-feature dependencies:

- support content
- article feedback
- reports

### Utilities

Primary files:

- controller: `application/application/controllers/admin/Utilities.php`
- supporting controller: `application/application/controllers/admin/Announcements.php`
- model: `application/application/models/Utilities_model.php`
- views: `application/application/views/admin/utilities/`

Cross-feature dependencies:

- media and file handling
- bulk PDF export over sales documents
- calendar aggregation
- activity log visibility
- ticket pipe log visibility

### Reports

Primary files:

- controller: `application/application/controllers/admin/Reports.php`
- model: `application/application/models/Reports_model.php`
- views: `application/application/views/admin/reports/`

Cross-feature dependencies:

- invoices and payments
- expenses
- leads
- knowledge base
- timesheets and staff

### Setup And Settings

Primary files:

- controllers: `Settings.php`, `Staff.php`, `Custom_fields.php`, `Emails.php`, `Gdpr.php`, `Roles.php`, `Mods.php`
- helpers: `menu_helper.php`, `settings_helper.php`
- views: `application/application/views/admin/includes/setup_menu.php`, `application/application/views/admin/settings/`

Cross-feature dependencies:

- permissions and staff roles
- shared option storage in `tbloptions`
- module activation
- custom fields
- email templates

### Notifications

Primary files:

- header include: `application/application/views/admin/includes/header.php`
- notification dropdown: `application/application/views/admin/includes/notifications.php`
- controller endpoints: `application/application/controllers/admin/Misc.php`
- notification data table: `tblnotifications`

Cross-feature dependencies:

- any feature that inserts staff notifications

### Logging

Primary files:

- operational logging calls appear throughout the app as `log_message('error', ...)`
- audit/activity logging calls appear throughout the app as `log_activity(...)`
- Utilities and Admin Core expose human-readable log views

Cross-feature dependencies:

- all write-heavy features can emit activity
- failures and scheduler issues can emit operational logs

### Admin Core

Primary files:

- module bootstrap: `application/modules/admin_core/admin_core.php`
- installer: `application/modules/admin_core/install.php`
- helper: `application/modules/admin_core/helpers/admin_core_helper.php`
- controllers/models/views under `application/modules/admin_core/`

Cross-feature dependencies:

- `application/application/config/database.php`
- `application/application/core/AdminController.php`
- tenant tables in the admin host database

### Events

Primary files:

- module bootstrap: `application/modules/events/events.php`
- installer: `application/modules/events/install.php`
- controller(s), models, helpers, and views under `application/modules/events/`
- event-related routes in `application/application/config/routes.php`

Cross-feature dependencies:

- module activation
- event-specific tables
- dashboard and calendar hooks
- website/export sync features

## Setup And Settings Implementation

Setup and Settings are wired differently from most top-level features.

Setup:

- menu registration comes from `menu_helper.php` plus module hooks
- rendering comes from `application/application/views/admin/includes/setup_menu.php`

Settings:

- section registration comes from `settings_helper.php`
- page orchestration comes from `application/application/controllers/admin/Settings.php`
- rendering comes from `application/application/views/admin/settings/all.php` plus `admin/settings/includes/*`
- V1 tenant-aware filtering is applied inside `Settings.php` through Admin Core helper checks

## Practical Dependency Map

The codebase repeatedly reinforces these practical dependencies:

- staff/session context is required almost everywhere in admin
- customer records are shared by sales, subscriptions, contracts, projects, tickets, and some reports
- project and task code are deeply intertwined
- finance setup records influence invoices, subscriptions, payments, expenses, and reporting
- support requires its setup records to be useful
- module installation extends the app surface rather than living entirely outside it

For product-facing summaries of those relationships, see the feature catalog.

## Related

- [[V1 App/V1 App Documentation Map]] | [V1 App Documentation Map](../V1%20App%20Documentation%20Map.md)
- [[V1 App/Architecture/System Overview]] | [System Overview](System%20Overview.md)
- [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)
- [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../Features/V1%20Feature%20Catalog.md)
- [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../Reference/Setup%20And%20Settings%20Map.md)
- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](Core%20Perfex%20Customizations.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](Request%20And%20Database%20Routing.md)
