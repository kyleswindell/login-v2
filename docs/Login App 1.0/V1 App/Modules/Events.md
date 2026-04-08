# Events

Parent: [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)

## Purpose

The Events module manages tenant events, photo uploads, sponsors, website publishing, and scheduler-based sync workflows.

## Use This Note When

Use this note when you need the clearest module-level answer to:

- what the V1 `events` module owns
- which files implement event CRUD, public upload flows, and sync behavior
- where module responsibilities stop and related feature/reference notes begin

Do not use this note as the main owner of:

- the exact events table schema
- the website sync architecture as a whole
- the broader V1 feature catalog

## Current Implementation

The module uses admin CRUD screens, public upload portals, website JSON export, and Admin Core scheduler hooks.

## Important Files

- `application/modules/events/events.php`
- `application/modules/events/controllers/Events.php`
- `application/modules/events/controllers/Public_portal.php`
- `application/modules/events/helpers/events_helper.php`
- `application/modules/events/models/Events_model.php`
- `application/modules/events/install.php`

## Main Responsibilities

- Tenant event CRUD.
- Event channels and collections.
- Public photo-drop upload portal.
- Upload moderation and blocked submitters.
- Sponsor management.
- Event slideshow data.
- Website JSON detail/index export.
- Scheduler-based status rollover.
- Scheduler-based website sync.

## Scheduler Hooks

The Events module uses Admin Core scheduler hooks:

- `admin_core_scheduler_minutely`
- `admin_core_scheduler_five_minutely`

Scheduler fan-out runs from the admin host and iterates active tenant records. Tenant failures should be logged and isolated so one tenant cannot stop the full scheduler run.

## Website Publishing

Events can publish detail payloads such as `events/{slug}.json` and index payloads such as `events/index.json`. Sync can run through local filesystem writes or authenticated HTTPS endpoint pushes.

## Error Handling

Runtime failures in website sync should become safe warning messages for admin users. Operational details belong in logs.

## Related

- [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../Architecture/Website%20Sync%20Architecture.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
- [[V1 App/Features/Event Website Sync]] | [Event Website Sync](../Features/Event%20Website%20Sync.md)
- [[V1 App/Reference/Events Data Model]] | [Events Data Model](../Reference/Events%20Data%20Model.md)
- [[V1 App/Reference/Events Routes]] | [Events Routes](../Reference/Events%20Routes.md)
