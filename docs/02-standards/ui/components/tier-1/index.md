# Tier 1 Component Standards

Tier 1 component standards define the durable expectations for primitive UI components. Each implemented T1 component must have a UI Reference page that displays final Login App examples and links back to its canonical standard.

## Page Display Contract

Implemented T1 pages must visibly show default examples, supported variants or colors, focus, disabled, hover-capable default behavior, applicable error/warning/success/info states, applicable loading or read-only states, spacing and padding behavior, implementation owner, and queued gaps.

Generic fallback content is allowed only for `Queued Gap` or `Not Applicable Yet` components.

## Spacing Contract

Components own internal padding, icon gap, label gap, border, radius, min-height, and typography. Parent layouts own external spacing through gap, stack, grid, action row, form row, table cell, or list row patterns.

## Component Docs

Each component doc in this folder links to the UI Reference owner route for that component.
