# database AGENTS.md

## Purpose

Laravel database implementation files: migrations, seeders, factories, and database-local setup.

## Read Order

1. Locate the migration, seeder, or factory tied to the schema or data task.
2. Read the related database contract in `docs/06-database/` when schema shape changes.
3. Cross-check tenant-safety standards for tenant-owned data changes.

## Avoid

- Do not change schema behavior without checking the owning database doc.
- Do not scan every migration unless the task is explicitly historical/schema-audit work.
