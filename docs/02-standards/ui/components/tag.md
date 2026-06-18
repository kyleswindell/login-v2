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
  - x-ui.tag-group
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

# Tag Component Standard

- [1. Ownership](#1-ownership)
- [2. Public API](#2-public-api)
- [3. Variants](#3-variants)
- [4. Tag group](#4-tag-group)
- [5. Structure and behavior](#5-structure-and-behavior)
- [6. Color model](#6-color-model)
- [7. UI Reference requirements](#7-ui-reference-requirements)
- [8. Acceptance criteria](#8-acceptance-criteria)

## 1. Ownership

The public API is `x-ui.tag`. Use it for compact metadata, filter tokens, selectable choices, and operational tag disclosure.

`x-ui.tag-group` owns tag grouping semantics, wrapping, spacing, accessible group labels, and optional `selection-mode="single|multiple"` declarations.

Legacy `x-ui.badge` and `x-ui.status` are deprecated for new tag work. They may remain only as transitional status-taxonomy helpers until a later migration replaces legacy badge usage.

Tags do not replace Notifications, Buttons, Menu buttons, Tabs, Breadcrumbs, or long-form feedback surfaces.

## 2. Public API

```blade
<x-ui.tag text="Internal" />

<x-ui.tag type="green" text="Verified" icon="heroicon-o-check-circle" />

<x-ui.tag
    variant="dismissible"
    type="blue"
    text="Region"
    dismiss-label="Remove region filter"
/>

<x-ui.tag variant="selectable" text="Open" selected />

<x-ui.tag
    variant="operational"
    type="teal"
    text="View more"
    disclosure-target="tag-disclosure-text-list"
/>
```

| Prop | Default | Allowed values | Notes |
| --- | --- | --- | --- |
| `variant` | `read-only` | `read-only`, `dismissible`, `selectable`, `operational` | Required behavior owner. |
| `type` | `gray` | `gray`, `cool-gray`, `warm-gray`, `red`, `magenta`, `purple`, `blue`, `cyan`, `teal`, `green`, `high-contrast`, `outline` | Component color role for read-only, dismissible, and operational tags. |
| `size` | `md` | `sm`, `md`, `lg` | 18px, 24px, and 32px. |
| `text` | none | short string | Required visible label. |
| `icon` | `null` | approved icon component alias | Decorative by default. |
| `disabled` | `false` | boolean | Uses disabled token hooks. |
| `selected` | `false` | boolean | Selectable tag state. |
| `defaultSelected` | `false` | boolean | Initial selectable state for live examples. |
| `dismissLabel` | generated | string | Required when generated text is not specific enough. |
| `dismissTooltipAlignment` | `center` | `start`, `center`, `end` | Hook for close-button tooltip alignment. |
| `tagTitle` / `title` | generated from `text` | string | Full label text exposed on the label title. |
| `truncate` | `null` | `start`, `middle`, `end` | Keeps the tag one line. |
| `disclosureTarget` | `null` | element id | Operational disclosure target. |

Do not add `tone`, `color`, `label`, slot text, `removeLabel`, `removable`, `selectable`, or `operational` aliases unless a real migration requires compatibility.

## 3. Variants

| Variant | Element | Behavior |
| --- | --- | --- |
| Read-only | `span` | Noninteractive label for compact metadata. |
| Dismissible | `span` plus close `button` | Only the close button removes the tag. |
| Selectable | `button` | Whole tag toggles `aria-pressed` and selected styling. |
| Operational | `button` | Whole tag toggles a related disclosure target and keeps `aria-expanded` synchronized. |

Operational tags are not Menu buttons and do not get a default caret. Full Popover composition is owned by the Popover/Disclosure pattern after that surface is approved.

## 4. Tag group

```blade
<x-ui.tag-group label="Status filters" selection-mode="single">
    <x-ui.tag variant="selectable" text="Open" selected />
    <x-ui.tag variant="selectable" text="Closed" />
</x-ui.tag-group>
```

Tag group owns:

- `role="group"`
- accessible label
- 8px wrapping gap
- `data-ui-tag-selection-mode="single|multiple"` when selection behavior must be coordinated

Tag JavaScript owns toggling behavior. The group does not become a full form-control framework in this pass.

## 5. Structure and behavior

Tags are fixed-height inline-flex pills. Do not use vertical padding, icon size, or line-height to create the tag height.

| Size | Height | Radius |
| --- | ---: | ---: |
| `sm` | 18px / 1.125rem | 16px |
| `md` | 24px / 1.5rem | 16px |
| `lg` | 32px / 2rem | 16px |

- Base tags use `display: inline-flex`, `align-items: center`, `width: fit-content`, `max-width: 100%`, `white-space: nowrap`, `font-size: 12px`, `font-weight: 400`, and `line-height: 1`.
- Tag labels use `title` with the full text and `dir="ltr"` by default.
- Tag labels remain single-line and truncate instead of wrapping.
- End and start truncation use normal one-line ellipsis behavior.
- Middle truncation uses split label markup so the start and end remain visible.
- Decorative icons are 16px, inherit `currentColor`, and use the variant/size-specific icon-to-text spacing.
- Dismissible close icons are 16px real buttons with their own 16px hit area and focus state.
- Dismissible focus applies only to the close button, not the whole tag.
- Selectable and operational variants have visible 1px borders and whole-tag focus states.
- Disabled tags use disabled token hooks, not opacity-only styling.

Read-only padding:

| Case | `lg` | `md` / `sm` |
| --- | --- | --- |
| No icon | 12px left/right | 8px left/right |
| Decorative icon | 8px left, 4px icon gap, 12px right | 4px left, 4px icon gap, 8px right |

Dismissible padding:

| Size | Left text padding | Text-to-close gap | Close icon | Right close padding |
| --- | ---: | ---: | ---: | ---: |
| `lg` | 12px | 12px | 16px | 8px |
| `md` | 8px | 8px | 16px | 4px |
| `sm` | 8px | 8px | 16px | 1px |

Operational/selectable padding:

| Case | `lg` | `md` / `sm` |
| --- | --- | --- |
| No icon | 12px left/right | 8px left/right |
| Decorative icon | 8px left, 4px icon gap, 12px right | 4px left, 4px icon gap, 8px right |

## 6. Color model

Read-only, dismissible, and operational tags use Tag component color tokens. Selectable tags use core tokens only. They must not display red, blue, green, or other component color families.

Each color type maps to component-scoped roles:

- `--ui-tag-background`
- `--ui-tag-color`
- `--ui-tag-hover`
- `--ui-tag-border`

### Light theme values

White and Gray 10 themes use these values:

| Type | Background | Text/Icon | Hover | Border |
| --- | --- | --- | --- | --- |
| `gray` | `#e0e0e0` | `#161616` | `#d1d1d1` | `#a8a8a8` |
| `cool-gray` | `#dde1e6` | `#121619` | `#cdd3da` | `#a2a9b0` |
| `warm-gray` | `#e5e0df` | `#171414` | `#d8d0cf` | `#ada8a8` |
| `red` | `#ffd7d9` | `#a2191f` | `#ffc2c5` | `#ff8389` |
| `magenta` | `#ffd6e8` | `#9f1853` | `#ffbdda` | `#ff7eb6` |
| `purple` | `#e8daff` | `#6929c4` | `#dcc7ff` | `#be95ff` |
| `blue` | `#d0e2ff` | `#0043ce` | `#b8d3ff` | `#78a9ff` |
| `cyan` | `#bae6ff` | `#00539a` | `#99daff` | `#33b1ff` |
| `teal` | `#9ef0f0` | `#005d5d` | `#57e5e5` | `#08bdba` |
| `green` | `#a7f0ba` | `#0e6027` | `#74e792` | `#42be65` |

### Dark theme values

Gray 90 and Gray 100 themes use these values:

| Type | Background | Text/Icon | Hover | Border |
| --- | --- | --- | --- | --- |
| `gray` | `#525252` | `#e0e0e0` | `#636363` | `#8d8d8d` |
| `cool-gray` | `#4d5358` | `#dde1e6` | `#5d646a` | `#878d96` |
| `warm-gray` | `#565151` | `#e5e0df` | `#696363` | `#8f8b8b` |
| `red` | `#a2191f` | `#ffd7d9` | `#c21e25` | `#fa4d56` |
| `magenta` | `#9f1853` | `#ffd6e8` | `#bf1d63` | `#ee5396` |
| `purple` | `#6929c4` | `#e8daff` | `#7c3dd6` | `#a56eff` |
| `blue` | `#0043ce` | `#d0e2ff` | `#0053ff` | `#4589ff` |
| `cyan` | `#00539a` | `#bae6ff` | `#0066bd` | `#1192e8` |
| `teal` | `#005d5d` | `#9ef0f0` | `#007070` | `#009d9a` |
| `green` | `#0e6027` | `#a7f0ba` | `#11742f` | `#24a148` |

### Variant rules

- Read-only tags consume `--ui-tag-background` and `--ui-tag-color`; they do not have hover, focus, selected, or click states.
- Dismissible tags consume `--ui-tag-background` and `--ui-tag-color`; close-target hover uses `--ui-tag-hover`; close-target focus uses `--ui-focus`.
- Operational tags consume `--ui-tag-background`, `--ui-tag-color`, `--ui-tag-hover`, and `--ui-tag-border`; full-tag focus uses `--ui-focus`.
- High contrast applies to read-only and dismissible tags and uses `--ui-background-inverse`, `--ui-text-inverse`, and `--ui-border-inverse`.
- Outline applies to read-only and dismissible tags and uses `--ui-background`, `--ui-text-primary`, `--ui-icon-primary`, and `--ui-border-inverse`.
- Disabled tags preserve geometry, remove interaction, and use disabled core tokens for text, icon, border, and background.
- Skeleton tags preserve tag geometry and use skeleton background/element tokens.

Do not promote tag color families into the global Color Element standard as generic roles.

## 7. UI Reference requirements

The Tag UI Reference page must show:

- Approved variant tabs for Read-only, Dismissible, Selectable, and Operational.
- Live dismissible removal.
- Live selectable single-select and multiple-select groups.
- Live operational disclosure using `x-ui.tag` as the trigger.
- Small, medium, and large sizes.
- Disabled, hover, focus, selected, and overflow examples where applicable.
- Dedicated color token proof for all supported read-only and dismissible types.
- Operational color proof for `gray`, `cool-gray`, `warm-gray`, `red`, `magenta`, `purple`, `blue`, `cyan`, `teal`, and `green`.
- Selectable proof shown separately with core-token enabled, hover, focus, selected, disabled, and skeleton states.
- Start, middle, and end truncation support where needed.
- Related API boundaries that mark `x-ui.badge` as deprecated for new tag work.

The UI Reference page must not use raw `<details>/<summary>` as the operational tag implementation.

## 8. Acceptance criteria

- `/platform/ui-reference/components/tag` renders authorized UI Reference examples.
- Existing active `x-ui.tag` usages use canonical props.
- `x-ui.tag-group` renders group semantics and selection-mode hooks.
- Tag JavaScript initializes dismissible, selectable, and operational behavior idempotently.
- Selectable tags expose `aria-pressed`.
- Operational tags expose `aria-expanded` and target the paired disclosure element.
- Middle truncation renders split label markup.
- Read-only, dismissible, and operational tags consume the Tag component color matrix.
- Selectable tags use core tokens only and do not expose component color families.
- Dismissible close hover uses the component hover token.
- Operational hover and border use the component hover/border tokens.
- High contrast and outline use their documented token roles.
- Disabled and skeleton states preserve tag geometry.
- Tests assert structure, behavior hooks, and docs rather than preserving old aliases.
