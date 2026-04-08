# Tenant Backup

Parent: [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)

## Purpose

Document how tenant backups are reviewed and executed.

## Current Implementation

Admin Core includes backup overview and scheduler-related UI. Tenant backup behavior depends on tenant database context and Admin Core scheduler dispatching.

The current repo shows:

- a shared backup root at `application/backups/`
- an admin/global backup artifact pattern such as `database_backup_*.zip`
- tenant-scoped backup directories under `application/backups/tenants/`

## Operational Notes

- Tenant backups should be treated as per-tenant operational artifacts, not as a single undifferentiated backup pool.
- Weekly Admin Core scheduler behavior is the main current clue for centralized backup dispatch.
- Backup review should verify both admin/global backup output and tenant-scoped backup output when relevant.
- Backup paths and tenant identifiers should remain data-driven rather than hardcoded.

## Related Folders

- `application/backups/`
- `application/backups/tenants/`

## Related

- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Folder Reference/Backups Folder]] | [Backups Folder](../Folder%20Reference/Backups%20Folder.md)
- [[V1 App/Runbooks/Run Cron]] | [Run Cron](Run%20Cron.md)
