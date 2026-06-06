# Typography Foundation Standard

## Purpose

Typography defines readable hierarchy, roles, weights, color use, emphasis, and code text treatment across product UI.

## Current Implementation

Login App uses app CSS and Tailwind-compatible utilities for page titles, headings, body text, labels, helper text, error text, tables, buttons, links, and code.

## UI Reference Route

`/platform/ui-reference/elements/typography`

## Required Visible Examples

- app font specimens for Sans and Mono, with Serif documented as not currently used
- type scale for 12, 14, 16, 18, 20, 24, 28, and 32px
- role examples for page title, section heading, subsection heading, body, label, helper, error, caption, mono/code, table header, table cell, button text, and link text
- productive UI examples for settings form, table, notification, and inline validation
- Light 300, Regular 400, Semibold 600, and limited italic examples
- type color examples for neutral text, disabled/placeholder text, links/actions, semantic alerts, and code

## Token/Class/API Reference

Use text tokens such as `--ui-text-strong`, `--ui-text-secondary`, `--ui-text-muted`, `--ui-action-disabled-text`, `--ui-link-text`, and semantic alert/status tokens.

## Usage Guidance

Use typography by role, not visual guessing. Productive type is the default for app UI. Use semibold for headings and short emphasis, not long body copy. Italic is limited to short emphasis such as terms, titles, captions, or technical distinctions.

## Accessibility Notes

Running text must remain neutral, legible, and high contrast. Colored type must carry semantic meaning or link/action affordance, not decoration.

## Developer Notes

Type color is part of the color system. Do not use arbitrary colored text for visual interest.

## Implementation Status

Guide status: Implemented. System maturity: Partial.

## Carbon Comparison Notes

Carbon's productive type, weight, and type-color guidance informs the standard. Login App keeps its own font stack and scale.
