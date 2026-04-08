# Application Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/application/`

## Purpose

This note describes the main CodeIgniter/Perfex application folder and what kinds of framework-level code live there in V1.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- what `application/application/` contains
- where core MVC and framework wiring live outside modules
- which subfolders matter most when tracing request flow

Do not use this note as the main owner of:

- module-specific code locations
- feature behavior
- detailed request-flow explanations

## Main Contents

Top-level areas present in the current repo include:

- `config/`: application configuration, routes, hooks, constants, and environment-specific config
- `controllers/`: main web controllers, including `admin/` and gateway controllers
- `core/`: Perfex / CodeIgniter base controller extensions such as `AdminController.php`
- `helpers/`: reusable helper functions used across features
- `hooks/`: boot-time and lifecycle hooks such as the app autoloader and init behavior
- `libraries/`: reusable classes for sessions, assets, mails, merge fields, PDF, SMS, import, and gateways
- `models/`: core Perfex domain models
- `services/`: service-layer logic for tasks, projects, proposals, leads, utilities, AI, upgrade, and more
- `views/`: admin, authentication, theme, error, and form views
- `language/`: translation packs
- `migrations/`: database migration files
- `logs/` and `cache/`: runtime artifacts
- `vendor/` and `third_party/`: third-party dependencies and extensions

## Relationship To Other Notes

- The folder-level MVC summary lives here.
- The main implementation-flow note lives in [[V1 App/Architecture/V1 Application Structure And MVC Map]].
- Module-specific code belongs under [[V1 App/Folder Reference/Modules Folder]] and the module notes in [[V1 App/Modules/Module Index]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Architecture/V1 Application Structure And MVC Map]] | [V1 Application Structure And MVC Map](../Architecture/V1%20Application%20Structure%20And%20MVC%20Map.md)
