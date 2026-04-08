# Website Content

Parent: [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)

## Purpose

Website Content is the planned module for editable public website content, metadata, schema, multi-language values, and page-builder blocks.

## Current Status

This note describes a planned module/concept direction. A concrete `application/modules/website_content/` implementation is not present in the current repo snapshot.

## Use This Note When

Use this note when you need the module-level answer to:

- what the future website-content module is intended to own
- how its scope differs from the current Events website sync feature
- which related planned feature and architecture notes to follow

Do not use this note as the main owner of:

- current V1 implemented website-content code
- future schema specifics
- the generic website sync transport pattern

## Planned Direction

This module should be built as a structured content system, not as raw HTML editing. Admins should edit safe fields and section order while developers control templates, layouts, and allowed block types.

## Related

- [[V1 App/Architecture/Website Builder Architecture]] | [Website Builder Architecture](../Architecture/Website%20Builder%20Architecture.md)
- [[V1 App/Features/Frontend Website Editing]] | [Frontend Website Editing](../Features/Frontend%20Website%20Editing.md)
- [[V1 App/Features/Multi Language Content]] | [Multi Language Content](../Features/Multi%20Language%20Content.md)
