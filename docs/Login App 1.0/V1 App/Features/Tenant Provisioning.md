# Tenant Provisioning

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how tenant records, databases, users, and initial settings are created.

## Use This Note When

Use this note when you need the feature-level answer to:

- what tenant provisioning does in V1
- which validations and inputs matter during tenant creation
- which deeper architecture/module notes own the implementation details

Do not use this note as the main owner of:

- the exact `tbltenants` schema
- host-based database routing after provisioning
- backup or scheduler behavior

## Current Implementation

Admin Core owns tenant creation and update flows. Tenant records contain host, database, status, module access, core feature access, and website integration settings.

Tenant provisioning creates a tenant database/user from the configured template database, applies tenant identity, saves the tenant record, updates selected tenant options, and syncs allowed modules.

## Validation Notes

- `tenant_key`, `db_name`, and `db_user` are required.
- Hostnames are normalized and validated.
- DB name and user values must not contain whitespace.
- Frontend URL and sync endpoint URL must be valid URLs when provided.
- Sync must have either a filesystem root path or endpoint URL when enabled.
- Endpoint sync requires a shared secret.
- Relative sync paths must not contain `..`.

## Related

- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
