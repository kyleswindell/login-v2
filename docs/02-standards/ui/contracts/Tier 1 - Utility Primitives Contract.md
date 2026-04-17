# Tier 1 - Utility Primitives Contract

This document defines the canonical scope and intent for Tier 1 - Utility Primitives Contract.

## Component Contract

### 1. Component Identity

- Component name: Divider, Tooltip, Spinner, Icon, Label, Link
- Taxonomy path (L1/L2): Cross-cutting Tier 1 utility primitives
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Provide the smallest reusable display, assistive, and loading primitives used across Tier 1 shells and controls.
- When to use: Structural separation, short helper affordances, lightweight loading indication, iconography, labels, and navigation/link text.
- When not to use: Pattern-level overlays, feature-specific loading workflows, or composed menu/panel behavior.
- Interaction intent summary: small primitives should remain predictable, semantically correct, and token-aligned.

### 3. States

- Divider: passive only.
- Tooltip: default and visible states only; non-interactive.
- Spinner: default and active loading states.
- Icon: passive by default; interactive state belongs to the owning control, not the icon itself.
- Label: passive only.
- Link: default, hover, focus, active, disabled where applicable.

### 4. Key Rules

- Divider is structural only and must not be used as a spacing substitute.
- Tooltip is non-interactive and must not replace popovers or menus.
- Spinner indicates loading only and must not be the sole status message where text is required.
- Icon names and usage follow canonical iconography standards.
- Label must clearly associate with its target field or control.
- Link is for navigation and destination changes, not primary action-button behavior.

### 5. Token Usage

- use semantic text, border, focus, and muted tokens
- use canonical spacing and typography roles
- use semantic state tokens for link emphasis only where appropriate

### 6. Variant Rules

- Divider: not variant-bearing
- Tooltip: `base` only
- Spinner: `base` only
- Icon: not variant-bearing at the utility-primitive level
- Label: not variant-bearing
- Link: `base` only

## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI Design System Standards](../UI%20Design%20System%20Standards.md)
- [UI UX Iconography Standards](../UI%20UX%20Iconography%20Standards.md)
