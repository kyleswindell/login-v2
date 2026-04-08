# Setup And Settings Map

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Summary

This note is the exact V1 reference map for the Setup sidebar and the Settings screen hierarchy.

Use this note when you need to answer:

- what appears in Setup today
- which files register those menu items
- which settings groups and child pages exist
- which parts come from core Perfex versus modules

Do not use this note as the main owner of:

- the full product-level feature catalog
- the overall MVC or request-flow architecture
- database schema ownership and table relationships

## Interface

### Setup Menu Source

Primary files:

- `application/application/helpers/menu_helper.php`
- `application/application/views/admin/includes/setup_menu.php`

Module additions reviewed for this note:

- `application/modules/theme_style/theme_style.php`
- `application/modules/admin_core/admin_core.php`
- `application/modules/events/events.php`

Important behavior:

- `menu_helper.php` registers the default Setup tree.
- `setup_menu.php` renders that tree and optionally appends a Help link.
- modules can add extra Setup items during the `admin_init` hook.

### Settings Screen Source

Primary files:

- `application/application/helpers/settings_helper.php`
- `application/application/controllers/admin/Settings.php`
- `application/application/views/admin/settings/all.php`
- `application/application/views/admin/settings/includes/`

Important behavior:

- `settings_helper.php` registers settings sections and child pages.
- `Settings.php` selects the active group, loads supporting records, and saves options.
- `all.php` renders the left navigation plus the child group view.
- in V1 tenant contexts, Admin Core can filter visible settings sections/groups.

## Setup Menu

### Default Setup Items

- Staff
- Customers
  - Customer Groups
- Support
  - Departments
  - Predefined Replies
  - Ticket Priorities
  - Ticket Statuses
  - Services
  - Spam Filters
- Leads
  - Sources
  - Statuses
  - Email Integration
  - Web to Lead
- Finance
  - Taxes
  - Currencies
  - Payment Modes
  - Expense Categories
- Contracts
  - Types
- Estimate Request
  - Forms
  - Statuses
- Modules
- Email Templates
- Custom Fields
- GDPR
- Roles
- Settings

### Module-Added Setup Items

- Theme Style
  - added by `application/modules/theme_style/theme_style.php`
  - appears only for admin users

### Conditional Setup Item

- Help
  - rendered by `application/application/views/admin/includes/setup_menu.php`
  - shown only when option `show_help_on_setup_menu` is enabled
  - links externally to the configured help URL, defaulting to Perfex help

### Notes About Setup Ownership

- most Setup items are core Perfex/CodeIgniter admin features
- `Theme Style` is a module-provided Setup extension
- `Admin Core` is not a Setup item in the reviewed V1 code; it appears as its own top-level admin menu on the admin host
- `Events` is not a Setup item in the reviewed V1 code; it appears as its own top-level admin menu when the module is active

## Settings Sections

### General

Children:

- General
- Company Information
- Localization
- Email
- System Update
- System/Server Info

Notes:

- `System Update` and `System/Server Info` are special admin settings views wired by `Settings.php` and `all.php`

### Finance

Children:

- General
- Invoices
- Proposals
- Estimates
- Credit Notes
- Subscriptions
- Payment Gateways

### Configure Features

Children:

- Customers
- Tasks
- Support
- Leads

### Integrations

Children:

- Google
- Pusher.com

### AI Integration

Children:

- General

Notes:

- this appears as the `ai` settings section in `settings_helper.php`

### Other

Children:

- Calendar
- PDF
- E-Sign
- Tags

### Misc

Children:

- Cron Job
- Misc

## Related Parent Features

Setup and Settings are shared infrastructure for these feature areas:

- Staff and Roles support permission checks across the whole admin app.
- Customer settings influence Customers and customer-facing flows.
- Finance settings influence Sales, Subscriptions, Expenses, and Reports.
- Support setup items drive Tickets and related notifications/reports.
- Leads setup items drive lead pipeline, intake, and conversion.
- Contracts setup items drive contract classification.
- Estimate Request setup items drive intake forms and request statuses.
- Modules and Theme Style change the available feature surface and presentation.
- Email Templates and Custom Fields support many parent features instead of a single isolated feature.

## Version Notes

- This note documents the current V1 menu/settings structure only.
- V2 may keep similar business concerns while implementing them in a different code structure.

## Related

- [[V1 App/V1 App Documentation Map]] | [V1 App Documentation Map](../V1%20App%20Documentation%20Map.md)
- [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../Features/V1%20Feature%20Catalog.md)
- [[V1 App/Architecture/V1 Application Structure And MVC Map]] | [V1 Application Structure And MVC Map](../Architecture/V1%20Application%20Structure%20And%20MVC%20Map.md)
- [[V1 App/Modules/Theme Style]] | [Theme Style](../Modules/Theme%20Style.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
