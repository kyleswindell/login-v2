# Uploads Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/uploads/`

## Purpose

This note describes the main upload storage root used by the V1 application.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- what kinds of uploaded files live under `application/uploads/`
- which feature areas write to the upload tree
- where tenant-specific or module-specific upload subfolders appear

Do not use this note as the main owner of:

- tenant storage policy rules
- the full runtime storage picture
- feature behavior beyond the storage location itself

## Current Structure

The current repo shows feature-scoped subfolders such as:

- `client_profile_images/`
- `clients/`
- `company/`
- `contracts/`
- `credit_notes/`
- `discussions/`
- `estimates/`
- `events/`
- `event_photo_drop/`
- `expenses/`
- `invoices/`
- `leads/`
- `newsfeed/`
- `projects/`
- `proposals/`
- `staff_profile_images/`
- `tasks/`
- `ticket_attachments/`
- `tenants/`

## Notes

- This tree is strongly feature-oriented rather than flat.
- Both legacy `event_photo_drop/` and newer `events/` upload areas exist in the current V1 app tree.
- A `tenants/` subtree is present, which aligns with V1 tenant-aware storage concerns.

## Relationship To Other Notes

- This note owns the upload root as a code location.
- Broader runtime storage ownership belongs in [[V1 App/Folder Reference/Runtime Storage Reference]].
- Tenant-safe path usage belongs with [[Standards/Tenant Safety Standards]] and Admin Core guidance.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Folder Reference/Runtime Storage Reference]] | [Runtime Storage Reference](Runtime%20Storage%20Reference.md) | [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)
