# Event Website Sync

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how event content is published from the admin app to a public website.

## Use This Note When

Use this note when you need the feature-level answer to:

- what event website sync does for users/admins in V1
- which tenant settings must be present
- what outputs are normally produced

Do not use this note as the main owner of:

- the cross-cutting website sync architecture pattern
- the Events module implementation map
- low-level route or schema references

## Current Implementation

The Events module exports event detail JSON and index JSON. It supports filesystem mode and authenticated HTTPS endpoint mode.

## Required Tenant Settings

- `events_sync_enabled`
- Local mode: `frontend_site_root_path` plus `events_sync_relative_dir`
- Endpoint mode: `events_sync_endpoint_url` plus `events_sync_secret`

## Typical Outputs

- `events/index.json`
- `events/{event-slug}.json`
- Channel index payloads where configured.

## Failure Behavior

Expected sync failures should show admin warning alerts and log operational details. Scheduler failures should include tenant context and should not stop other tenant sync attempts.

## Related

- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
- [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../Architecture/Website%20Sync%20Architecture.md)
