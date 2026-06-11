---
title: Spacing Element API Standard
slug: spacing
guide_status: implemented
system_maturity: partial
api_layer: Foundation Element API
ui_reference_route: /platform/ui-reference/elements/spacing
canonical_doc: docs/02-standards/ui/elements/spacing.md
related_elements:
  - 2x-grid
  - typography
  - themes
related_patterns:
  - forms
  - layout
---

# Spacing Element API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed density model](#31-installed-density-model)
  - [3.2. Responsive spacing rule](#32-responsive-spacing-rule)
- [4. Token API](#4-token-api)
- [5. CSS variable API](#5-css-variable-api)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Allowed utility families](#61-allowed-utility-families)
  - [6.2. Preferred composition examples](#62-preferred-composition-examples)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Selection guidance](#71-selection-guidance)
  - [7.2. Relationship guidance](#72-relationship-guidance)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Component API requirements:](#81-component-api-requirements)
  - [8.2. Pattern API requirements:](#82-pattern-api-requirements)
  - [8.3. Feature/page requirements:](#83-featurepage-requirements)
- [9. Theme behavior](#9-theme-behavior)
  - [9.1. Theme-related spacing rules:](#91-theme-related-spacing-rules)
- [10. State behavior](#10-state-behavior)
  - [10.1. Spacing state rules:](#101-spacing-state-rules)
- [11. Accessibility contract](#11-accessibility-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Spacing scale](#151-spacing-scale)
  - [15.2. Margin examples](#152-margin-examples)
  - [15.3. Padding examples](#153-padding-examples)
  - [15.4. Stack examples](#154-stack-examples)
  - [15.5. Relationship examples](#155-relationship-examples)
  - [15.6. Density examples](#156-density-examples)
  - [15.7. Implementation reference](#157-implementation-reference)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Spacing controls layout rhythm, component padding, content relationships, density, and visual hierarchy.

Spacing is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

This document defines the installed Login App 2.0 spacing contract: what spacing values are allowed, which utility classes map to those values, which layer owns spacing, how density is selected, and what the UI Reference page must prove with live rendered examples.

## 2. Status and ownership

| Field              | Value                                    |
| ------------------ | ---------------------------------------- |
| Guide status       | Implemented                              |
| System maturity    | Partial                                  |
| API layer          | Foundation Element API                   |
| Element slug       | spacing                                  |
| UI Reference route | /platform/ui-reference/elements/spacing  |
| Canonical doc      | docs/02-standards/ui/elements/spacing.md |

## 3. Installed standard

Component internal spacing and parent-owned layout spacing.

The installed standard uses the Carbon-compatible spacing scale as the app's approved spacing vocabulary. The scale is expressed through Carbon token names, rem/px values, Tailwind-compatible utility classes, and component or pattern wrappers that consume those utilities.

Spacing ownership is split by layer:

| Owner             | Owns                                                                                                                                        | Does not own                                                                     |
| ----------------- | ------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| Element API       | Approved spacing values, token names, scale, and utility mapping.                                                                           | Component-specific layout decisions.                                             |
| Component API     | Internal padding, internal gaps, label/helper relationships, cell padding, trigger/icon spacing, and state-safe spacing.                    | External page rhythm, inter-component stacking, or page section separation.      |
| Pattern API       | Layout rhythm between components, form rows, page sections, dashboard widgets, action rows, toolbar groups, and responsive spacing changes. | Redefining spacing values outside the Element API.                               |
| Feature/page code | Choosing approved wrappers and utility classes for local composition.                                                                       | New spacing scales, arbitrary pixel values, or component-owned external margins. |

Use this decision rule:

```text
Inside a component: component owns spacing.
Between components: parent layout or Pattern owns spacing.
Across a page or dashboard: 2x Grid and Pattern APIs own spacing.
```

### 3.1. Installed density model

| Density role              | Usual token range             | Use for                                                                                       |
| ------------------------- | ----------------------------- | --------------------------------------------------------------------------------------------- |
| Fine relationship         | `$spacing-01` - `$spacing-02` | Hairline relationships, tiny icon/text offsets, compact separators.                           |
| Close relationship        | `$spacing-03` - `$spacing-04` | Label/helper relationships, compact control groups, dense metadata.                           |
| Standard component rhythm | `$spacing-05` - `$spacing-06` | Cards, panels, form rows, action groups, field groups, standard content blocks.               |
| Section rhythm            | `$spacing-07` - `$spacing-09` | Page sections, dashboard regions, major content group separation.                             |
| Large layout rhythm       | `$spacing-10` - `$spacing-13` | Rare large layout moments, empty-state breathing room, hero-like or onboarding-style spacing. |

### 3.2. Responsive spacing rule

Spacing tokens themselves do not change value by viewport. A layout or Pattern may step up or down the spacing scale at approved breakpoints, but the selected value must still come from this scale.

Allowed:

```html
<section class="grid gap-4 md:gap-6 xl:gap-8">
    ...
</section>
```

Not allowed:

```html
<section style="gap: 19px">
    ...
</section>
```

## 4. Token API

| Token/helper           | Variable or value                                                                     | Allowed API/consumer                                     | Example                                                            |
| ---------------------- | ------------------------------------------------------------------------------------- | -------------------------------------------------------- | ------------------------------------------------------------------ |
| `$spacing-01`          | `0.125rem` / `2px`                                                                    | `gap-0.5`, `p-0.5`, component micro-offsets              | Fine separator or hairline relationship.                           |
| `$spacing-02`          | `0.25rem` / `4px`                                                                     | `gap-1`, `p-1`, compact icon/text spacing                | Icon-to-label or tight metadata relationship.                      |
| `$spacing-03`          | `0.5rem` / `8px`                                                                      | `gap-2`, `p-2`, `space-y-2`                              | Label to helper relationship.                                      |
| `$spacing-04`          | `0.75rem` / `12px`                                                                    | `gap-3`, `p-3`, compact card internals                   | Compact field group or small inline cluster.                       |
| `$spacing-05`          | `1rem` / `16px`                                                                       | `gap-4`, `p-4`, standard card/panel internals            | Standard compact panel rhythm.                                     |
| `$spacing-06`          | `1.5rem` / `24px`                                                                     | `gap-6`, `p-6`, standard form group rhythm               | Form section or card content grouping.                             |
| `$spacing-07`          | `2rem` / `32px`                                                                       | `gap-8`, `p-8`, section separation                       | Page section separation.                                           |
| `$spacing-08`          | `2.5rem` / `40px`                                                                     | `gap-10`, `p-10`, spacious section rhythm                | Wider dashboard or landing-style grouping.                         |
| `$spacing-09`          | `3rem` / `48px`                                                                       | `gap-12`, `p-12`, large region rhythm                    | Major page section separation.                                     |
| `$spacing-10`          | `4rem` / `64px`                                                                       | `gap-16`, `p-16`, rare large region spacing              | Large empty-state or onboarding panel.                             |
| `$spacing-11`          | `5rem` / `80px`                                                                       | `gap-20`, `p-20`, rare layout spacing                    | Large visual pause or hero-like section.                           |
| `$spacing-12`          | `6rem` / `96px`                                                                       | `gap-24`, `p-24`, rare layout spacing                    | Large empty region or high-level page composition.                 |
| `$spacing-13`          | `10rem` / `160px`                                                                     | `gap-40`, `p-40`, large layout spacing only              | Rare large empty/hero-like spacing.                                |
| Parent stack gap       | Approved `gap-*` values from this scale                                               | Flex, grid, form, toolbar, and content stack wrappers    | `<div class="grid gap-4">...</div>`                                |
| Component padding      | Approved `p-*`, `px-*`, `py-*`, `pt-*`, `pr-*`, `pb-*`, `pl-*` values from this scale | Component source, `ui-card`, fields, table cells, panels | `<article class="ui-card">...</article>`                           |
| External layout margin | Approved `m-*`, `mx-*`, `my-*`, `mt-*`, `mr-*`, `mb-*`, `ml-*` values from this scale | Parent layout or Pattern only                            | `<section class="mt-8">...</section>`                              |
| Dashboard grid spacing | `--ui-dashboard-grid-row-size` / `--ui-dashboard-grid-gap`                            | `x-ui.patterns.dashboard-grid`                           | `<x-ui.patterns.dashboard-grid>...</x-ui.patterns.dashboard-grid>` |

The table above is the public spacing API for feature implementation. If a value or helper does not appear here or in a component/pattern-specific standard, it is not approved for new UI work.

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

Current public spacing usage is primarily utility-driven. CSS variables are allowed only when a component or pattern owns a dynamic spacing contract that cannot be expressed clearly with static utility classes.

Approved CSS variable cases:

| Variable/API                                                   | Owner                  | Allowed use                                                                           |
| -------------------------------------------------------------- | ---------------------- | ------------------------------------------------------------------------------------- |
| `--ui-dashboard-grid-row-size`                                 | Dashboard Grid Pattern | Defines widget row sizing for dashboard composition.                                  |
| `--ui-dashboard-grid-gap`                                      | Dashboard Grid Pattern | Defines dashboard widget gap when the pattern requires a variable.                    |
| Component-owned spacing variables documented by that component | Component API          | Only when the component standard documents the variable, default, and allowed values. |

Not approved:

```css
.feature-card {
    --local-card-spacing: 18px;
}
```

Not approved:

```html
<div style="padding: 22px">
    ...
</div>
```

If a new semantic spacing alias is needed, update this Element standard, the consuming component or pattern doc, and the UI Reference proof before using it in feature code.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the UI Reference route.

### 6.1. Allowed utility families

| Utility family                             | Allowed values                                                          | Owner                                         |
| ------------------------------------------ | ----------------------------------------------------------------------- | --------------------------------------------- |
| `gap-*`                                    | `0.5`, `1`, `2`, `3`, `4`, `6`, `8`, `10`, `12`, `16`, `20`, `24`, `40` | Parent layouts, patterns, flex/grid wrappers. |
| `space-x-*`, `space-y-*`                   | Same scale values when `gap-*` cannot be used                           | Parent layouts and local stacks.              |
| `p-*`, `px-*`, `py-*`, directional padding | Same scale values                                                       | Components, cards, panels, layout wrappers.   |
| `m-*`, `mx-*`, `my-*`, directional margin  | Same scale values                                                       | Parent layouts and patterns only.             |
| Responsive variants                        | Same scale values at documented breakpoints                             | Patterns and page layouts.                    |

### 6.2. Preferred composition examples

Use `gap-*` for flex and grid relationships:

```html
<div class="flex items-center gap-2">
    <span>Label</span>
    <span>Value</span>
</div>
```

Use grid or flex parent wrappers for inter-component spacing:

```html
<section class="grid gap-6">
    <x-ui.card>...</x-ui.card>
    <x-ui.card>...</x-ui.card>
</section>
```

Use component props or component classes for component internals:

```blade
<x-ui.button size="sm">Save</x-ui.button>
```

Do not add margin to the child component to force surrounding layout rhythm:

```blade
{{-- Not approved --}}
<x-ui.button class="mt-[13px]">Save</x-ui.button>
```

## 7. Allowed usage

- Use when: defining margin, padding, gaps, stack rhythm, component internals, or layout relationships.
- Avoid when: setting arbitrary pixel values or component-owned external margins.
- Common app examples: form rows, action rows, table cells, cards, dashboard widgets, and page sections.

### 7.1. Selection guidance

| Need                                                          | Use                                                               |
| ------------------------------------------------------------- | ----------------------------------------------------------------- |
| Page-level columns, responsive regions, or dashboard geometry | 2x Grid Element and layout Pattern wrappers.                      |
| Local relationship between label/helper/error text            | Spacing Element tokens through component-owned internals.         |
| Space between repeated components                             | Parent `grid`, `flex`, `gap-*`, or Pattern wrapper.               |
| Internal control padding                                      | Component API props/classes, not feature-local padding overrides. |
| Dense admin data display                                      | Smaller spacing tokens through the table/list/form component API. |
| High-priority empty state or onboarding region                | Larger spacing tokens through a Pattern-owned layout.             |

### 7.2. Relationship guidance

Use tighter spacing when content belongs together:

```text
Label -> field -> helper text
Icon -> text label
Status tag -> status copy
```

Use larger spacing when content groups should scan as separate sections:

```text
Page heading -> section group
Settings section -> settings section
Dashboard region -> dashboard region
```

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

### 8.1. Component API requirements:

- Use this spacing scale for internal padding, row height, label/helper relationships, cell padding, menu item spacing, trigger/icon spacing, and inline validation spacing.
- Do not create unpredictable external margin inside the component source.
- Expose size, density, or compact props only when the component standard defines how those props map to this scale.
- Preserve layout stability across hover, focus-visible, selected, disabled, loading, and validation states.

### 8.2. Pattern API requirements:

- Own spacing between components.
- Own form row rhythm, toolbar groups, dashboard widget gaps, page section separation, split-view regions, and responsive spacing changes.
- Consume 2x Grid for page-level geometry and Spacing for local rhythm.
- Document any responsive step changes from one spacing token to another.

### 8.3. Feature/page requirements:

- Use approved wrappers before adding utilities directly.
- Use direct utilities only when no component or pattern wrapper owns the layout.
- Keep repeated spacing decisions in a pattern or component, not duplicated across feature views.

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the UI Reference page.

Spacing values are not theme-specific. The same spacing token keeps the same value across themes. Theme changes may alter color, border, shadow, or layer tokens, but must not create layout shifts or change spacing rhythm unless a documented Pattern explicitly changes density.

### 9.1. Theme-related spacing rules:

- Focus rings must not add layout shift.
- Borders must not alter component size unexpectedly.
- Inverse or inline themed regions must preserve the same content relationship spacing.
- High-contrast moments may increase visible border/focus treatment but should not use local spacing overrides unless the owning component standard allows it.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

### 10.1. Spacing state rules:

| State            | Spacing requirement                                                                                          |
| ---------------- | ------------------------------------------------------------------------------------------------------------ |
| Hover            | Must not move content or resize the component.                                                               |
| Active/pressed   | Must not collapse or expand spacing unless the component owns an explicit pressed motion treatment.          |
| Focus-visible    | Focus outline/ring must not cause layout shift.                                                              |
| Selected/current | Selected visuals must use color/border/layer tokens without changing spacing unexpectedly.                   |
| Disabled         | Disabled controls keep the same layout footprint as enabled controls.                                        |
| Loading          | Loading indicators and skeletons preserve the final content footprint where possible.                        |
| Validation       | Error/helper text spacing is component or form-pattern owned; do not add arbitrary margins in feature views. |
| Empty state      | Empty-state spacing is pattern-owned and should use larger tokens intentionally.                             |

## 11. Accessibility contract

Spacing must preserve readable relationships, target usability, focus visibility, and validation recovery.

Required:

- Focus-visible rings, outlines, and inset focus treatments must not create layout shift.
- Interactive targets must keep enough internal padding or parent-owned hit area to remain usable in dense layouts.
- Icon-only controls must use the Icons and Component APIs for target sizing rather than shrinking spacing locally.
- Labels, helper text, warning text, and error text must stay visually associated with the related field or control.
- Dense tables, menus, lists, and forms may use smaller spacing tokens only when focus, selection, validation, and row-action states remain readable.
- Loading and skeleton placeholders must preserve the final content footprint where possible.
- Empty states and blocked states must use enough spacing to separate title, body, action, and secondary detail without hiding hierarchy.
- Responsive spacing changes must not reorder relationships or separate labels from their controls.

Not allowed:

- Compressing required instructions, validation messages, or task-critical copy with fine spacing tokens.
- Using negative margins or arbitrary pixel offsets to force focus rings, icons, or validation text into alignment.
- Reducing component padding below the owning Component API to fit more content into a dense page.
- Hiding insufficient hierarchy behind oversized spacing instead of using correct typography, grouping, or layout.

## 12. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Use spacing tokens for margin, padding, and gaps.
- Components own internal spacing; parent layouts own external spacing.
- Smaller spacing creates close relationships; larger spacing separates sections and creates hierarchy.
- Do not use arbitrary values such as `p-[13px]`, `mt-[18px]`, `gap-[21px]`, or inline `style="padding: ..."` for standard UI spacing.
- Do not add external margins to reusable components to make one page layout work.
- Do not create feature-local spacing variables or Sass variables.
- Do not rely on Bootstrap row/column gutters or ad hoc utility clusters as substitutes for this standard.
- Do not use negative margins for normal alignment. If alignment cannot be achieved with this scale, update the component or pattern contract.
- Do not use large spacing tokens to hide weak hierarchy or missing section structure.
- Do not use tiny spacing tokens to compress required reading, error recovery, or task-critical information.

## 13. Deferred or gated capabilities

No additional capability is approved without updating this Element standard and UI Reference proof.

| Capability                                                     | Status       | Gate                                                                                  |
| -------------------------------------------------------------- | ------------ | ------------------------------------------------------------------------------------- |
| New spacing values outside `$spacing-01` - `$spacing-13`       | Not approved | Requires Element standard update, UI Reference proof, and consuming API update.       |
| Semantic CSS variables such as `--ui-spacing-05`               | Deferred     | Requires token build pipeline decision and migration plan.                            |
| Component-owned external margin exceptions                     | Gated        | Requires component standard update explaining why parent ownership is not sufficient. |
| Density scale beyond current compact/default/spacious patterns | Gated        | Requires Pattern standard, component mapping, and UI Reference examples.              |
| Arbitrary viewport-based spacing formulas                      | Not approved | Use breakpoint-based token step changes instead.                                      |

## 14. Implementation and UI Reference Checklist

### 14.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 14.2. UI Reference proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 15. UI Reference requirements

The `/platform/ui-reference/elements/spacing` page must render live examples with application CSS/JS, not screenshots only.

Required live sections:

### 15.1. Spacing scale

- Render all thirteen spacing tokens from `$spacing-01` through `$spacing-13`.
- Show token name, rem value, px value, and utility-class mapping.
- Show a visual bar or measurement block for each token.
- Mark which values are common, rare, or layout-only.

### 15.2. Margin examples

- Show approved top, right, bottom, left, horizontal, and vertical margin usage.
- Label examples as parent-layout owned.
- Include a note that reusable components should not own unpredictable external margins.

### 15.3. Padding examples

- Show card/panel padding.
- Show form-group padding.
- Show section padding.
- Show dense table/list padding.
- Identify whether the padding is component-owned or pattern-owned.

### 15.4. Stack examples

- Show vertical stack.
- Show horizontal stack.
- Show compact, standard, and spacious gaps.
- Show form rows and action rows.
- Show that parent wrappers own inter-component spacing.

### 15.5. Relationship examples

- Label to input.
- Input to helper text.
- Input to validation text.
- Section heading to content.
- Card title to body.
- Card to card.
- Page section to page section.

### 15.6. Density examples

- Dense admin table/list rhythm.
- Standard form rhythm.
- Standard card/panel rhythm.
- Spacious empty-state or onboarding rhythm.
- Responsive step change example using approved breakpoints and token values.

### 15.7. Implementation reference

- Show the allowed utility class groups.
- Show component/pattern wrappers that consume spacing.
- Show prohibited examples such as arbitrary pixel spacing, component-owned external margin, and feature-local CSS variables.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/elements/spacing` returns 200 for authorized users.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page renders all thirteen approved spacing tokens with rem and px values.
- The page demonstrates margin, padding, stack, relationship, and density examples.
- The page distinguishes component-owned internal spacing from parent-owned external spacing.
- The page documents that arbitrary pixel values, feature-local spacing variables, and component-owned external margins are not approved.
- The page links to the 2x Grid Element, Form Patterns, and this canonical documentation route.

### 16.1. Suggested automated assertions:

```text
GET /platform/ui-reference/elements/spacing -> 200 for authorized users
assertSee('$spacing-01')
assertSee('$spacing-13')
assertSee('Component internal spacing')
assertSee('parent-owned layout spacing')
assertSee('Do not bypass this Element API')
assertSee('spacing scale')
assertSee('margin examples')
assertSee('padding examples')
assertSee('stack examples')
assertSee('density examples')
```

## 17. Related APIs

| API                     | Route                                                         |
| ----------------------- | ------------------------------------------------------------- |
| 2x Grid element         | /platform/ui-reference/elements/2x-grid                       |
| Typography element      | /platform/ui-reference/elements/typography                    |
| Themes element          | /platform/ui-reference/elements/themes                        |
| Form patterns           | /platform/ui-reference/patterns/forms                         |
| Layout patterns         | /platform/ui-reference/patterns/layout                        |
| Canonical spacing doc   | /platform/docs?path=02-standards%2Fui%2Felements%2Fspacing.md |
| Carbon spacing overview | https://carbondesignsystem.com/elements/spacing/overview/     |

## 18. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon Spacing overview](https://carbondesignsystem.com/elements/spacing/overview/)
- Carbon spacing tokens and stack guidance support the same ownership principle: components do not rely on self-owned margins.
- Carbon spacing maps to Login App as a token-compatible spacing scale and ownership model, not a requirement to install Carbon's React Stack component.
