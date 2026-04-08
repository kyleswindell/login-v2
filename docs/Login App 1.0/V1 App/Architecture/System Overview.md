# V1 System Overview

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

This note describes the high-level shape of the current V1 Login / Perfex application.

## Use This Note When

Use this note for the shortest architecture-level answer to:

- what kind of application V1 is
- what the biggest moving parts are
- where tenant-aware behavior and major customizations live

Do not use this note as the primary owner of:

- detailed feature behavior
- file-by-file MVC explanations
- exact setup/settings/schema reference material

## Current Implementation

The admin application is a PHP/CodeIgniter-based Perfex CRM codebase with custom modules for multi-tenant management, events, backups, theme styling, and related functionality.

The app currently uses PHP views for most admin UI, with some Vue 3 components and a Laravel Mix/Tailwind asset pipeline.

The codebase is shared between a master admin CRM and tenant CRM hosts. The request host determines whether the app uses the admin database or a tenant database.

For a feature-by-feature description of what V1 currently offers, use the feature catalog. For the file-level MVC and bootstrap map, use the dedicated application structure note. For exact lookups, use the reference index.

## Major Areas

- Core Perfex app: `application/application/`
- Custom and bundled modules: `application/modules/`
- Static/compiled assets: `application/assets/`
- Source assets: `application/resources/`
- Runtime uploads: `application/uploads/`
- Local backups: `application/backups/`
- Reference templates: `application/vendor-templates/`

## Architectural Reading Order

Start here, then branch as needed:

1. product surface: `[[V1 App/Features/V1 Feature Catalog]]`
2. implementation structure: `[[V1 App/Architecture/V1 Application Structure And MVC Map]]`
3. exact lookup material: `[[V1 App/Reference Index]]`

## Important Current Customizations

- Tenant database routing is implemented in `application/application/config/database.php`.
- Tenant feature enforcement is wired into `application/application/core/AdminController.php`.
- Tenant module visibility/action restrictions are implemented in `application/application/controllers/admin/Mods.php`.
- Tenant module UI behavior is adjusted in `application/application/views/admin/modules/list.php`.
- Admin Core owns tenant records, module allowlists, core feature allowlists, frontend integration settings, logs, backups, and tenant staff management.
- Events owns tenant event management, public upload portals, website JSON export, and scheduler-based status/sync workflows.

## Related

- [[V1 App/V1 App Documentation Map]] | [V1 App Documentation Map](../V1%20App%20Documentation%20Map.md)
- [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../Features/V1%20Feature%20Catalog.md)
- [[V1 App/Architecture/V1 Application Structure And MVC Map]] | [V1 Application Structure And MVC Map](V1%20Application%20Structure%20And%20MVC%20Map.md)
- [[V1 App/Modules/Module Index]] | [Module Index](../Modules/Module%20Index.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](Multi%20Tenant%20Architecture.md)
- [[V1 App/Architecture/Website Builder Architecture]] | [Website Builder Architecture](Website%20Builder%20Architecture.md)
- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](Core%20Perfex%20Customizations.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](Request%20And%20Database%20Routing.md)
- [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](../Features/Tenant%20Module%20Allowlist.md)
- [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](../Folder%20Reference/Application%20Tree%20Map.md)
