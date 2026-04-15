# Multi Language Content

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how language-aware content should work for future website editing.

## Current Status

This is a planned/future-oriented concept note, not a description of a completed current V1 website-content implementation.

## Use This Note When

Use this note when you need the product-level answer to:

- how planned website content should support multiple languages
- what fallback behavior is expected
- which architecture/module notes own the deeper planned design

Do not use this note as the main owner of:

- current implemented translation behavior outside this planned area
- exact storage schema for future translations
- website builder architecture as a whole

## Planned Direction

Each editable field should support language-specific values. The front-end renderer should select the current language and fall back to a default language when a translation is missing.

## Related

- [[V1 App/Architecture/Website Builder Architecture]] | [Website Builder Architecture](../Architecture/Website%20Builder%20Architecture.md)
- [[V1 App/Modules/Website Content]] | [Website Content](../Modules/Website%20Content.md)
