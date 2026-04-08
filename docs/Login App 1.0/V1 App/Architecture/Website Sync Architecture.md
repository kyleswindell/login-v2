# Website Sync Architecture

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Document the pattern used to publish admin-managed data to public websites.

## Use This Note When

Use this note when you need the architecture-level answer to:

- how website publishing currently works in V1
- which sync modes exist
- how future website-content publishing should reuse the same pattern

Do not use this note as the main owner of:

- the feature-level events sync behavior summary
- the exact routes or table schema involved
- future website builder content modeling

## Current Implementation

The Events module already supports website JSON export using either filesystem writes or authenticated HTTPS endpoint pushes.

## Important Files

- `application/modules/events/helpers/events_helper.php`: Contains sync path and endpoint helper logic.
- `application/modules/events/controllers/Events.php`: Builds event payloads and syncs index/detail JSON.
- `New Website/events-sync-endpoint.php`: Example authenticated website endpoint.
- `application/modules/admin_core/views/tenants/tenant.php`: Stores frontend site URL, root path, endpoint URL, and shared secret.

## Future Use

The Website Builder module should reuse this pattern for page content, metadata, schema, and block payloads.

## Sync Modes

- Filesystem mode: Admin/tenant CRM writes JSON into the configured frontend site root path and relative sync directory.
- HTTPS endpoint mode: Admin/tenant CRM posts JSON to a website endpoint using a shared secret.

## Safety Rules

- Never hardcode sync secrets in reusable module code.
- Validate sync relative paths before writing or deleting files.
- Prefer warning alerts for admin-facing sync failures instead of hard 500 pages.
- Include tenant and record context in operational logs.

## Related

- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
- [[V1 App/Architecture/Website Builder Architecture]] | [Website Builder Architecture](Website%20Builder%20Architecture.md)
- [[Standards/Logging Standards]] | [Logging Standards](../../Standards/Logging%20Standards.md)
