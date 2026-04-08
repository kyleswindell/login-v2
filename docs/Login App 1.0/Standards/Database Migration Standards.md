# Database Migration Standards

## Purpose

Document database schema change conventions.

## Standards

- Module `install.php` files should be idempotent.
- Check whether tables/fields/indexes exist before creating them.
- Avoid destructive schema changes unless explicitly planned and backed up.
- Preserve tenant data when adding module features.
- Use clear table/field names that include module context.

## Related

- [[Standards/Module Development Standards]] | [Module Development Standards](Module%20Development%20Standards.md)

