# Database Migration Standards

This document defines the canonical scope and intent for Database Migration Standards.

## Purpose

Document database schema change conventions.

## Standards

- Module `install.php` files should be idempotent.
- Check whether tables/fields/indexes exist before creating them.
- Avoid destructive schema changes unless explicitly planned and backed up.
- Preserve tenant data when adding module features.
- Use clear table/field names that include module context.

## Related

- [Legacy V1 Perfex Module Development Standards](../../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
