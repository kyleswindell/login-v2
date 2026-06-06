# Typography Foundation Standard

## Purpose

Typography defines readable hierarchy, roles, weights, color use, and code text treatment across product UI.

## Current Implementation

Login App uses app CSS and Tailwind-compatible typography utilities for page titles, headings, body text, labels, helper text, error text, table text, button text, links, and code.

## UI Reference Route

`/platform/ui-reference/elements/typography`

## Required Visible Examples

- app font specimens for Sans and Mono, with Serif omitted unless the app adopts it
- type scale for 12, 14, 16, 18, 20, 24, 28, and 32px
- roles for page title, section heading, subsection heading, body, label, helper, error, caption, mono/code, table header, table cell, button text, and link text
- productive examples for admin page title, settings form, data table, empty state, notification, and inline validation
- expressive example only as an app-specific exception with “not for admin/product UI” guidance
- regular and semibold weights, with light/italic only when actually used
- color examples for primary, secondary, placeholder, link, error/helper, and disabled text

## Token/Class/API Reference

Use app typography roles, text token utilities, component classes, and code/mono classes. Text color must use text tokens, not action tokens.

## Usage Guidance

Use typography tokens by role. Productive type is the default for app UI. Use neutral color for running text and blue for links/actions. Use semibold for headings and emphasis, not long body copy.

Avoid choosing font size, weight, line height, or color by visual guessing.

## Accessibility Notes

Typography must maintain legibility, contrast, predictable hierarchy, and sufficient line height. Error and helper text must remain associated with the relevant field.

## Developer Notes

Component pages should apply typography rules directly in rendered examples instead of restating prose-only recommendations.

## Implementation Status

Implemented.

## Carbon Comparison Notes

Carbon's productive/expressive split informs the page structure. Login App keeps its own font stack and visual scale.
