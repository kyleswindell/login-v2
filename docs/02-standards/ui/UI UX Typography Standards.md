# UI UX Typography Standards

This document defines the canonical scope and intent for UI UX Typography Standards.

## Purpose

Define canonical typography tokens and role usage for Login App 2.0.

## Source And Scope

This standard is adapted from:

- `docs/Personal Notes/App Typography Standard Note.md`

The personal note remains a working source. This file is the canonical implementation owner.

## Implementation Status

Current status:

- base font-stack direction is locked
- allowed font weights are locked
- role-based type scale is defined
- token naming alignment in Tailwind config is pending implementation lock

## Locked Direction

1. Use a system sans stack for primary UI typography.
2. Use monospace stack for technical values and code-like content.
3. Restrict UI weights to `400`, `500`, `600`, `700`.
4. Use tokenized role names instead of ad hoc text sizes.

## Font Stacks

Sans stack:

- `ui-sans-serif`
- `system-ui`
- `-apple-system`
- `BlinkMacSystemFont`
- `Segoe UI`
- `Roboto`
- `Helvetica Neue`
- `Arial`
- `Noto Sans`
- `sans-serif`

Mono stack:

- `ui-monospace`
- `SFMono-Regular`
- `Menlo`
- `Monaco`
- `Consolas`
- `Liberation Mono`
- `Courier New`
- `monospace`

## Role Scale

Display roles (rare use):

- `display-large` 36/44 600
- `display-medium` 30/38 600

Core product hierarchy:

- `page-title` 24/32 600
- `section-title` 20/28 600
- `subsection-title` 18/26 600
- `body-large` 16/24 400
- `body` 14/22 400
- `body-strong` 14/22 500
- `label-large` 14/20 500
- `label` 13/18 500
- `table-header` 12/16 600
- `meta-caption` 12/16 400
- `overline-eyebrow` 11/16 600
- `code-value` 13/20 400 mono

## Usage Rules

1. Use display roles only for rare hero-style internal surfaces.
2. Default app body copy uses `body`.
3. Buttons/chips/tabs use label roles.
4. Dense table headers use `table-header`.
5. Timestamps, helper text, and metadata use `meta-caption`.
6. IDs/tokens/log fragments use `code-value`.

## Implementation Direction

Tailwind token mapping must be added under `theme.extend` for:

- `fontFamily.sans`
- `fontFamily.mono`
- role-based `fontSize` keys

## Related

- [UI UX Foundations And Theming Standards](UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
