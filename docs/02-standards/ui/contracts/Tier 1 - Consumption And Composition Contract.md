# Tier 1 - Consumption And Composition Contract

This document defines the canonical scope and intent for Tier 1 - Consumption And Composition Contract.

## Purpose

Define how Tier 1 UI items must be consumed as the building-block layer for Tier 2 patterns and feature work.

This contract exists to prevent drift between:

* visual reference examples
* implementation-time usage
* the actual reusable entry points available to later work

## Core Rule

Every Tier 1 item must expose a clear reusable entry point before Tier 2 or feature work should depend on it.

Tier 1 consumption should be described in common language first:

* what UI role this item serves
* which descriptors the caller is allowed to supply
* which implementation form delivers the default styling and behavior

Developers and agents should think in UI roles and descriptors, not raw one-off styling assembly.

## Tier 1 Consumption Model

Every Tier 1 item must define:

1. role
2. allowed descriptors
3. implementation form
4. canonical usage example
5. anti-drift constraints

### 1. Role

The role is the common-language identity of the item.

Examples:

* button
* icon button
* text input
* select
* inline alert
* toast
* badge
* status pill
* table baseline
* section or panel baseline

### 2. Allowed Descriptors

Descriptors are the approved inputs a caller may use without redefining the primitive.

Examples:

* semantic: `primary`, `neutral`, `success`, `warning`, `danger`, `notice`, `info`
* variant: `base`, `soft`, `outline`, `ghost`
* state: `disabled`, `loading`, `readonly`, `error`
* structure flags: `required`, `dismissible`, `showIcon`
* size: `xs`, `sm`, `md`, `lg`, `xl`

Descriptors must come from canonical contracts. Callers must not invent new descriptors ad hoc inside Tier 2 or feature work.

### 3. Implementation Form

Every Tier 1 item must be classified as one of:

* `Blade component`
  * a reusable Blade component is the primary entry point
* `Class/markup contract`
  * the primary entry point is a documented markup structure plus canonical classes
* `Hybrid`
  * a reusable component exists for some uses, but a documented class/markup contract is still required for others
* `Missing abstraction`
  * the item is visually demonstrated, but the reusable entry point is not explicit enough yet for safe downstream reuse

This classification must be explicit. Mixed implementation forms are allowed, but they must be named intentionally.

The standards layer must also declare the intended long-term direction when that differs from the current implementation.

Allowed direction labels:

* `keep as class/markup contract`
* `promote to Blade component`
* `keep as hybrid with clearer wrapper contract`
* `revalidate Tier 1 boundary`

### 4. Canonical Usage Example

Every Tier 1 item should have at least one canonical usage example that shows:

* the common-language role
* the allowed descriptors
* the implementation form in practice

Examples:

```blade
<x-ui.badge status="pending review" />
```

```html
<label class="block">
  <span class="ui-control-label">Workspace Name</span>
  <input class="ui-input" aria-invalid="true">
  <p class="ui-control-error">Workspace name is required.</p>
</label>
```

### 5. Anti-Drift Constraints

Tier 2 and feature work must not:

* copy demo-only snapshot markup as if it were the primitive contract
* recreate Tier 1 visuals from raw utility classes when a canonical entry point already exists
* invent new wrapper structures for an existing class/markup contract without updating the contract
* treat UI Reference state snapshots as the production API for a Tier 1 item

## Common-Language Usage Standard

Tier 1 usage should be understandable in plain language.

Examples:

* "This is a toast. Severity is notice. It is dismissible."
* "This is a text input. It is required and currently in error state."
* "This is a button. Semantic role is danger. Variant is outline."

The code or markup entry point should make those statements true without additional ad hoc styling work.

## UI Reference Relationship

UI Reference proves visual behavior and state visibility.

UI Reference does **not** automatically prove library readiness.

A Tier 1 item is only library-ready when its implementation form and canonical entry point are explicit enough for Tier 2 and feature work to consume without guessing.

## Automation Boundary

Automated tests may support Tier 1 library-readiness, but they must remain narrow.

Acceptable automated enforcement includes:

* confirming that known canonical entry points still exist
* confirming that required UI Reference surfaces still render
* confirming that a documented reusable entry point has not silently disappeared

Automated tests should **not** be treated as proof of:

* visual quality
* composability quality
* whether a primitive is pleasant or intuitive to consume
* whether a demo snapshot is the right abstraction boundary

Those concerns still require standards review, reference review, and manual judgment.

The project policy is:

* use documentation and review as the primary enforcement for Tier 1 library ergonomics
* use lightweight automated checks only to guard stable entry points and reference-surface availability

## Tier 2 And Feature Preflight Requirement

Before implementing Tier 2 or feature UI that depends on Tier 1:

1. identify the Tier 1 items being consumed
2. name their implementation form
3. confirm the canonical entry point is clear
4. stop and resolve the gap if the needed Tier 1 item is still a `Missing abstraction`

## Allowed Implementation Shapes

This contract does **not** require all Tier 1 items to become Blade components.

Acceptable end states include:

* a Blade component when that is the best primitive surface
* a documented class/markup contract when the structure is simple and stable
* a hybrid approach when both are needed

What matters is not uniform mechanism. What matters is explicit and reviewable consumption.

## Directional Decisions From Review

Until a later decision record changes them, the current Tier 1 directional rules are:

* structural utility primitives such as divider, spinner, label, link, container, grid, and stack/flex should remain `class/markup contract`
* higher-semantic feedback and action objects such as buttons, icon buttons, toasts, inline alerts, modals, and drawers should move toward `Blade component` entry points
* native form controls and shell-navigation surfaces may remain `class/markup contract` or `hybrid`, but they require explicit wrapper and slot contracts
* table baseline and section/panel baseline must be treated carefully and revalidated against the Tier 1/Tier 2 boundary before they become deeper dependencies for Tier 2 work

## Related

* [Component Contracts Index](Component%20Contracts%20Index.md)
* [Tier 1 Component Implementation Checklist](../components/Tier%201%20Component%20Implementation%20Checklist.md)
* [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
