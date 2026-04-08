# Website Builder Architecture

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Capture the intended direction for admin-managed public websites and future page-builder functionality.

## Use This Note When

Use this note when you need the architecture-level answer to:

- how planned website-content management should be structured
- what the preferred safe editing model is
- how future website content architecture should differ from raw HTML editing

Do not use this note as the main owner of:

- current V1 feature behavior already implemented today
- module-specific implementation details
- exact data model or route reference material

## Planned Direction

The admin app should become the source of truth for public website content, metadata, schema, and block configuration.

For fresh websites, the preferred direction is a structured block-based template system instead of raw HTML editing. Developers define safe templates and fields; admins edit content, section order, publishing state, language variants, and media.

## Initial Model

- Page records define route, title, SEO fields, schema, and status.
- Section records define block type, sort order, status, and variant.
- Field records define editable content values.
- Translation records define language-specific field values.
- Sync/export logic publishes website-ready JSON or API responses.

## Related

- [[V1 App/Features/Frontend Website Editing]] | [Frontend Website Editing](../Features/Frontend%20Website%20Editing.md)
- [[V1 App/Features/Multi Language Content]] | [Multi Language Content](../Features/Multi%20Language%20Content.md)
- [[V1 App/Modules/Website Content]] | [Website Content](../Modules/Website%20Content.md)
- [[Standards/Module Development Standards]] | [Module Development Standards](../../Standards/Module%20Development%20Standards.md)
