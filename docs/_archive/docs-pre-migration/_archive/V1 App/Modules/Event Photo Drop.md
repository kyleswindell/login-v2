# Event Photo Drop

Parent: [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)

## Purpose

Event Photo Drop is the legacy or related module for event-based public photo upload and website sync functionality.

## Use This Note When

Use this note when you need the module-level answer to:

- what the legacy `event_photo_drop` module appears to have owned
- how it relates to the newer `events` module
- which legacy files still exist and may matter during cleanup or migration

Do not use this note as the main owner of:

- the current primary Events module behavior
- the overall website sync architecture
- future website-content plans

## Current Implementation

This module overlaps with or predates the Events module. Treat it carefully when making changes so legacy functionality is not accidentally broken.

## Important Files

- `application/modules/event_photo_drop/event_photo_drop.php`
- `application/modules/event_photo_drop/controllers/Event_photo_drop.php`
- `application/modules/event_photo_drop/controllers/Public_portal.php`
- `application/modules/event_photo_drop/helpers/event_photo_drop_helper.php`
- `application/modules/event_photo_drop/models/Event_photo_drop_model.php`
- `application/modules/event_photo_drop/install.php`

## Notes

- The module has its own routes and CSRF exclusions config.
- It includes public portal, slideshow, QR, and event views, which suggests a fuller legacy feature surface than just a single upload form.
- The V1 `events` module installer includes rename/migration logic around legacy event photo drop behavior, so this module should be treated as legacy-but-relevant during upgrades or cleanup.

## Related

- [[V1 App/Modules/Events]] | [Events](Events.md)
- [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../Architecture/Website%20Sync%20Architecture.md)
