# Backups Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/backups/`

## Purpose

This note describes the backup storage root used by the V1 application.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- where backup artifacts are stored in the repo/runtime tree
- how admin/global and tenant backup output is separated
- which runbook to open for backup-related operations

Do not use this note as the main owner of:

- backup scheduling behavior
- backup retention policy
- disaster recovery procedures

## Current Structure

The current repo shows:

- a backup artifact like `database_backup_2026-03-20-18-00-06-v3-4-0.zip`
- a `tenants/` subtree
- tenant-specific subdirectories such as `client1-local`, `client3-local`, and `client4-local`

## Notes

- This folder is a runtime/storage location, not the owner of backup logic.
- The presence of both top-level backup artifacts and tenant subfolders aligns with the V1 split between admin/global and tenant scopes.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Runbooks/Tenant Backup]] | [Tenant Backup](../Runbooks/Tenant%20Backup.md)
