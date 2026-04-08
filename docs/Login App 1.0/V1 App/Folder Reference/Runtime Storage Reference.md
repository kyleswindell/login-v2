# Runtime Storage Reference

Parent: [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md)

## Purpose

Document the main runtime storage folders used by the current application.

## Folders

| Folder | Purpose |
|---|---|
| `application/uploads/` | User/module uploaded files, including tenant-scoped uploads and event files. |
| `application/media/` | Media library or app-managed media files. |
| `application/temp/` | Temporary runtime files and scoped temp directories. |
| `application/backups/` | Backup artifacts for admin and tenant backup scopes. |
| `application/application/logs/` | CodeIgniter/PHP log files. |

## Tenant Notes

Admin Core helper functions provide tenant-scoped upload, media, and temp paths. Use those helpers instead of hardcoding tenant storage paths.

## Related

- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md)
