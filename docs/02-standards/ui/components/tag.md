---
title: Tag
slug: tag
api_layer: Component API
status: implemented-pending-review
system_maturity: installed
category: feedback-and-loading
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/tag
canonical_doc: docs/02-standards/ui/components/tag.md
source_owner: /platform/ui-reference/components/tag
blade_api:
  - x-ui.tag
related_components:
  - notification
  - tooltip
  - popover
  - button
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
carbon_reference:
  - https://carbondesignsystem.com/components/tag/usage/
  - https://carbondesignsystem.com/components/tag/style/
  - https://carbondesignsystem.com/components/tag/accessibility/
---

# Tag Component API Standard

- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
- [5. Anatomy](#5-anatomy)
- [6. Variants, sizes, and states](#6-variants-sizes-and-states)
- [7. Color tokens](#7-color-tokens)
- [8. Structure](#8-structure)
- [9. Overflow and grouping](#9-overflow-and-grouping)
- [10. Accessibility and content](#10-accessibility-and-content)
- [11. UI Reference requirements](#11-ui-reference-requirements)
- [12. Testing and acceptance criteria](#12-testing-and-acceptance-criteria)
- [13. Related APIs](#13-related-apis)
- [14. References](#14-references)

## 1. API summary

Tag labels compact metadata, categorization, filter state, compact choices, or overflow tag disclosure without becoming a generic Button, Menu, Notification, Badge, or Status wrapper.

Canonical API owner: `/platform/ui-reference/components/tag`.

The public API is `x-ui.tag`. Legacy `x-ui.badge` and `x-ui.status` usage may remain only as transitional status-taxonomy helpers; new compact label, filter-token, selectable, and operational tag usage must use `x-ui.tag`.

## 2. Status and ownership

| Field                        | Value                                                                                                   |
| ---------------------------- | ------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented pending review                                                                               |
| System maturity              | Installed                                                                                                |
| API layer                    | Component API                                                                                            |
| Component slug               | `tag`                                                                                                    |
| UI Reference route           | `/platform/ui-reference/components/tag`                                                                  |
| Canonical doc                | `docs/02-standards/ui/components/tag.md`                                                                 |
| Blade API                    | `x-ui.tag`                                                                                               |
| Source files                 | `resources/views/components/ui/tag.blade.php`; `resources/css/app.css`                                  |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons                                                                |
| Carbon benchmark             | Carbon Tag usage, style, accessibility, and color-token guidance                                         |

## 3. Installed standard

- Implement all four variants: read-only, dismissible, selectable, and operational.
- Use read-only tags for non-interactive category, metadata, or status labels.
- Use dismissible tags for filter tokens or user-generated labels that can be removed through the close icon only.
- Use selectable tags for compact choices that toggle selected/unselected state on the whole container.
- Use operational tags for compact disclosure of additional or overflow tags.
- Use small, medium, and large sizes.
- Use component Tag color tokens for read-only, dismissible, and operational color families.
- Use core tokens only for selectable tags.
- Keep tag labels one line; truncate long labels with ellipsis and expose the full title through tooltip/title behavior.
- Do not use tags for primary commands, navigation, explanatory feedback, or long-form copy.

## 4. Public API

```blade
<x-ui.tag color="gray">Internal</x-ui.tag>

<x-ui.tag color="green" icon="heroicon-o-check-circle">
    Verified
</x-ui.tag>

<x-ui.tag variant="dismissible" color="blue" remove-label="Remove region filter">
    Region
</x-ui.tag>

<x-ui.tag variant="selectable" selected>
    Open
</x-ui.tag>

<x-ui.tag variant="operational" color="teal">
    More tags
</x-ui.tag>
```

| Prop/option            | Type                  | Default     | Allowed values                                                                                  | Notes |
| ---------------------- | --------------------- | ----------- | ----------------------------------------------------------------------------------------------- | ----- |
| Default slot / `label` | `string / HtmlString` | none        | Short visible text                                                                               | Required unless `skeleton=true`. |
| `variant`              | `string`              | `read-only` | `read-only`, `dismissible`, `selectable`, `operational`                                          | `removable`, `selectable`, and `operational` boolean props remain compatibility aliases. |
| `color` / `tone`       | `string`              | `gray`      | `gray`, `cool-gray`, `warm-gray`, `red`, `magenta`, `purple`, `blue`, `cyan`, `teal`, `green`, `high-contrast`, `outline` | Legacy `neutral/info/success/warning/error` map to the closest Tag colors. |
| `size`                 | `string`              | `md`        | `sm`, `md`, `lg`                                                                                 | Required sizes are 18px, 24px, and 32px. |
| `icon`                 | `string / null`       | `null`      | Approved Heroicon component alias                                                                | Decorative by default; visible text remains required. |
| `removeLabel`          | `string / null`       | generated   | Specific action label                                                                            | Required for production dismissible tags when generated text is insufficient. |
| `selected`             | `bool`                | `false`     | `true`, `false`                                                                                  | Selectable tags expose selected state with `aria-pressed`. |
| `disabled`             | `bool`                | `false`     | `true`, `false`                                                                                  | Uses core disabled roles, not opacity-only styling. |
| `skeleton`             | `bool`                | `false`     | `true`, `false`                                                                                  | Loading placeholder only. |
| `truncate`             | `string / null`       | `null`      | `start`, `middle`, `end`                                                                         | Keeps the tag one line and pairs with `title`. |
| `title`                | `string / null`       | `null`      | Full title text                                                                                  | Required when visible title is truncated. |

## 5. Anatomy

| Variant         | Decorative icon | Title | Container | Close icon | Border | Interactivity |
| --------------- | --------------- | ----- | --------- | ---------- | ------ | ------------- |
| Read-only       | Optional        | Required | Required | Not allowed | Not required by default | None |
| Dismissible     | Optional        | Required | Required | Required | Not required by default | Close icon only |
| Selectable      | Optional        | Required | Required | Not allowed | Required | Entire container toggles selected state |
| Operational     | Optional        | Required | Required | Not allowed | Required | Entire container discloses additional tags |

Selectable and operational tags must include a visible border to distinguish them from read-only tags.

## 6. Variants, sizes, and states

| Variant     | Installed API | Required states |
| ----------- | ------------- | --------------- |
| Read-only   | `variant="read-only"` | Enabled, disabled when context requires unavailable metadata |
| Dismissible | `variant="dismissible"` or `removable` | Enabled, hover, focus, disabled |
| Selectable  | `variant="selectable"` or `selectable` | Enabled, hover, focus, selected, disabled |
| Operational | `variant="operational"` or `operational` | Enabled, hover, focus, disabled, disclosed content proof |
| Skeleton    | `skeleton` | Loading placeholder |

| Size | API | Container height |
| ---- | --- | ---------------- |
| Small | `size="sm"` | 18px / 1.125rem |
| Medium | `size="md"` | 24px / 1.5rem |
| Large | `size="lg"` | 32px / 2rem |

## 7. Color tokens

Read-only, dismissible, and operational tags use component Tag color tokens. Selectable tags use core tokens only.

| Color | Background token | Background value | Text/icon token | Text/icon value | Hover token | Hover value | Border token | Border value |
| ----- | ---------------- | ---------------- | --------------- | --------------- | ----------- | ----------- | ------------ | ------------ |
| Gray | `$tag-background-gray` | `#e0e0e0` | `$tag-color-gray` | `#161616` | `$tag-hover-gray` | `#d1d1d1` | `$tag-border-gray` | `#a8a8a8` |
| Cool gray | `$tag-background-cool-gray` | `#dde1e6` | `$tag-color-cool-gray` | `#121619` | `$tag-hover-cool-gray` | `#cdd3da` | `$tag-border-cool-gray` | `#a2a9b0` |
| Warm gray | `$tag-background-warm-gray` | `#e5e0df` | `$tag-color-warm-gray` | `#171414` | `$tag-hover-warm-gray` | `#d8d0cf` | `$tag-border-warm-gray` | `#ada8a8` |
| Red | `$tag-background-red` | `#ffd7d9` | `$tag-color-red` | `#a2191f` | `$tag-hover-red` | `#ffc2c5` | `$tag-border-red` | `#ff8389` |
| Magenta | `$tag-background-magenta` | `#ffd6e8` | `$tag-color-magenta` | `#9f1853` | `$tag-hover-magenta` | `#ffbdda` | `$tag-border-magenta` | `#ff7eb6` |
| Purple | `$tag-background-purple` | `#e8daff` | `$tag-color-purple` | `#6929c4` | `$tag-hover-purple` | `#dcc7ff` | `$tag-border-purple` | `#be95ff` |
| Blue | `$tag-background-blue` | `#d0e2ff` | `$tag-color-blue` | `#0043ce` | `$tag-hover-blue` | `#b8d3ff` | `$tag-border-blue` | `#78a9ff` |
| Cyan | `$tag-background-cyan` | `#bae6ff` | `$tag-color-cyan` | `#00539a` | `$tag-hover-cyan` | `#99daff` | `$tag-border-cyan` | `#33b1ff` |
| Teal | `$tag-background-teal` | `#9ef0f0` | `$tag-color-teal` | `#005d5d` | `$tag-hover-teal` | `#57e5e5` | `$tag-border-teal` | `#08bdba` |
| Green | `$tag-background-green` | `#a7f0ba` | `$tag-color-green` | `#0e6027` | `$tag-hover-green` | `#74e792` | `$tag-border-green` | `#42be65` |

Selectable tag core colors:

| Element | Property | Token |
| ------- | -------- | ----- |
| Text | `color` | `$text-primary` |
| Icon | `color` | `$icon-primary` |
| Border | `border` | `$border-inverse` |
| Background | `background-color` | `$layer` |
| Hover background | `background-color` | `$layer-hover` |
| Selected text | `color` | `$text-inverse` |
| Selected background | `background-color` | `$background-inverse` |

High contrast and outline styles use core tokens instead of the component color family.

## 8. Structure

| Element | Small | Medium | Large |
| ------- | ----- | ------ | ----- |
| Container height | 18px | 24px | 32px |
| Border radius | 16px | 16px | 16px |
| Container padding | 8px left/right | 8px left/right | 12px left/right |
| Decorative icon size | 16px | 16px | 16px |
| Dismissible icon size | 16px | 16px | 16px |

Icon spacing must vary by size and icon purpose. Decorative icon spacing must not be reused blindly for the dismissible close icon.

## 9. Overflow and grouping

- Long titles truncate with ellipsis and never wrap.
- Truncated titles must expose the full title through browser tooltip/title behavior on hover and keyboard focus.
- Truncation may occur at the start, middle, or end depending on the use case.
- Tag groups use 8px spacing and may wrap while preserving scan order.
- Dismissible filter tag groups must keep each close action independently focusable.

## 10. Accessibility and content

- Visible tag text must carry meaning without relying on color alone.
- Icons are decorative unless the visible text does not already communicate the meaning.
- Dismissible close icons require a specific accessible label.
- Selectable tags expose state with `aria-pressed`.
- Operational tags expose disclosure semantics through the owning trigger/disclosure pattern.
- Use short sentence-case labels.
- Avoid vague tags such as `Other`, `Misc`, or `New` unless the data model defines them.

## 11. UI Reference requirements

The UI Reference page must render:

- Read-only tag.
- Read-only tag with decorative icon.
- Dismissible tag.
- Dismissible tag with decorative icon.
- Selectable tag, unselected and selected.
- Operational tag and operational tag disclosing overflow content.
- Disabled examples where applicable.
- Skeleton example.
- Small, medium, and large examples.
- Overflow/truncated title examples with tooltip/title behavior.
- Read-only, dismissible, and operational examples for every supported component color.
- Selectable examples separately from component-color examples.
- High contrast and outline examples.
- Tag group, wrapping tag group, selectable group, and dismissible filter group.

## 12. Testing and acceptance criteria

- `/platform/ui-reference/components/tag` returns 200 for authorized users.
- `x-ui.tag` is the canonical component name.
- Legacy Badge/Status usage is documented as transitional or related, not the Tag owner.
- All four variants render on the UI Reference page.
- Dismissible tags render a close button.
- Selectable tags render a bordered button and selected state.
- Operational tags render a bordered trigger and overflow-disclosure example.
- `sm`, `md`, and `lg` sizes render with exact component size classes.
- Tag CSS includes component color tokens for all ten supported color families.
- Selectable tags use core tokens only.
- Truncated examples remain single-line and expose full text through `title`.
- Tests assert live examples, component source, CSS tokens, and standard text.

## 13. Related APIs

| API | Route |
| --- | ----- |
| Notification | `/platform/ui-reference/components/notification` |
| Tooltip | `/platform/ui-reference/components/tooltip` |
| Popover | `/platform/ui-reference/components/popover` |
| Button | `/platform/ui-reference/components/button` |
| Components overview | `/platform/ui-reference/components` |

## 14. References

- [Component Standards Index](index.md)
- [Foundation Color](../elements/color.md)
- [Foundation Typography](../elements/typography.md)
- [Foundation Icons](../elements/icons.md)
- Carbon Tag usage, style, color, and accessibility guidance inform the variant, state, size, overflow, and token coverage. Login App owns the `x-ui.tag` API and app-owned `ui-*` implementation contract.
