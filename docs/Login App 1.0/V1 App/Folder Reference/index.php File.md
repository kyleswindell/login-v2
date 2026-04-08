# index.php File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/index.php`

## Purpose

This note describes the primary web front controller for the V1 Perfex / CodeIgniter application.

## Use This Note When

Use this note when you need the clearest file-level answer to:

- where normal web requests first enter the app
- which early bootstrap concerns are handled before the framework fully runs
- how V1 injects tenant-host awareness at the front-controller level

Do not use this note as the main owner of:

- the full MVC flow after bootstrap
- tenant database routing details
- setup, feature, or module behavior

## Current Behavior

`application/index.php` is the main front controller for browser-based requests.

In the current V1 code it:

- sets the PHP timezone to `GMT` when none is configured
- defines `ENVIRONMENT` as `development`
- derives the current host from `$_SERVER['HTTP_HOST']`
- defines `TENANT_KEY` from the current host when it is not already defined
- sets the system and application paths for the CodeIgniter bootstrap
- hands control into the framework bootstrap after the basic environment setup

## Relationship To Other Notes

- This note owns the front-controller entry point only.
- The larger request and MVC flow belongs in [[V1 App/Architecture/V1 Application Structure And MVC Map]].
- Tenant DB selection and host routing belong in [[V1 App/Architecture/Request And Database Routing]] and [[V1 App/Architecture/Multi Tenant Architecture]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Architecture/V1 Application Structure And MVC Map]] | [V1 Application Structure And MVC Map](../Architecture/V1%20Application%20Structure%20And%20MVC%20Map.md)
