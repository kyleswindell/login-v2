---
title: Tag
slug: tag
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/tag
canonical_doc: docs/02-standards/ui/components/tag.md
source_owner: /platform/ui-reference/components/tag
blade_api:
  - x-ui.tag
related_components:
  - notification
  - data-table
  - tile
  - button
related_patterns:
  - layout
  - tables
  - navigation
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
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Tag consumes Foundation Element APIs:](#71-tag-consumes-foundation-element-apis)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Tag labels short metadata, categorization, state, or filter information without taking over the surrounding workflow.

Canonical API owner: `/platform/ui-reference/components/tag`. Use this Component API instead of creating local badge, chip, pill, status-label, or filter-token markup for the same UI role.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                                  |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                                                           |
| System maturity              | Partial                                                                                                                                                                |
| API layer                    | Component API                                                                                                                                                          |
| Component slug               | `tag`                                                                                                                                                                  |
| Category                     | Feedback and loading                                                                                                                                                   |
| Priority                     | Tier B - Common reusable component                                                                                                                                     |
| UI Reference route           | `/platform/ui-reference/components/tag`                                                                                                                                |
| Canonical doc                | `docs/02-standards/ui/components/tag.md`                                                                                                                               |
| Source owner                 | `/platform/ui-reference/components/tag`                                                                                                                                |
| Blade API                    | `x-ui.tag`                                                                                                                                                             |
| Source files                 | `resources/views/components/ui/badge.blade.php`; `resources/views/components/ui/status.blade.php`; `resources/css/app.css`; final `x-ui.tag` wrapper installation gate |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons                                                                                                                              |
| Carbon benchmark             | Carbon Tag usage, style, and accessibility guidance                                                                                                                    |

`Approved API` means the app already has badge/status surfaces, but the public Tag API, UI Reference page, and source naming need to be aligned before this component can be accepted.

## 3. Installed standard

Tag is the app-owned component family for compact label-like metadata and semantic state markers.

### 3.1. The installed standard is:

- Use tags for short metadata, classification, status, and filter-token display.
- Use semantic tone only when the tag communicates real status or system meaning.
- Use neutral tags for category, ownership, type, or metadata that is not a status.
- Keep tags compact and inline with surrounding content.
- Use icons only when the icon reinforces the visible tag text.
- Use removable/filter tags only after the owning Pattern defines filter state, removal behavior, keyboard behavior, and persistence.
- Do not use tags as buttons, tabs, breadcrumbs, notifications, or primary actions.

## 4. Public API

### 4.1. Canonical calls

The desired public API is `x-ui.tag`. If the current implementation still exposes `x-ui.badge` or `x-ui.status`, those APIs must be bridged or renamed during the Tag component correction instead of leaving the standard pointed at Tabs or local markup.

```blade
<x-ui.tag tone="neutral">Internal</x-ui.tag>

<x-ui.tag tone="success" icon="heroicon-o-check-circle">
    Active
</x-ui.tag>

<x-ui.tag tone="warning">Pending review</x-ui.tag>
```

Use the Blade API instead of hand-building badge/tag/chip markup in feature views.

### 4.2. API surfaces

| API surface           | Installed value                                                                                                                                                                                   |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade API             | `x-ui.tag` desired public API; existing `x-ui.badge` / `x-ui.status` surfaces are transitional until corrected                                                                                    |
| JavaScript            | No dedicated JavaScript controller for static tags                                                                                                                                                |
| Root semantic element | Non-interactive text element by default                                                                                                                                                           |
| Data attributes       | `data-ui-component="tag"` when the corrected API renders                                                                                                                                          |
| CSS namespace         | `ui-tag*`; existing `ui-badge*` and `ui-status*` are transitional aliases until correction                                                                                                        |
| Source files          | `resources/views/components/ui/badge.blade.php`; `resources/views/components/ui/status.blade.php`; `resources/css/app.css`; final `resources/views/components/ui/tag.blade.php` installation gate |

### 4.3. Props and options

| Prop/option            | Type                  | Default   | Allowed values                                              | Required                       | Notes                                                                                                                  |
| ---------------------- | --------------------- | --------- | ----------------------------------------------------------- | ------------------------------ | ---------------------------------------------------------------------------------------------------------------------- |
| Default slot / `label` | `string / HtmlString` | none      | Short visible text                                          | Yes                            | Keep the label concise and meaningful without relying on color.                                                        |
| `tone`                 | `string`              | `neutral` | `neutral`, `info`, `success`, `warning`, `error`, `inverse` | No                             | Use semantic tones only for real semantic meaning.                                                                     |
| `size`                 | `string`              | `md`      | `sm`, `md`                                                  | No                             | `sm` is for dense tables/lists; `md` is the default.                                                                   |
| `icon`                 | `string / null`       | `null`    | Approved Heroicon alias/component                           | No                             | Decorative unless the icon conveys state not already in text.                                                          |
| `removable`            | `bool`                | `false`   | `true`, `false`                                             | No                             | Gated until removal behavior and Pattern ownership are installed.                                                      |
| `removeLabel`          | `string / null`       | `null`    | Short action label                                          | Required when `removable=true` | Must describe what will be removed.                                                                                    |
| `class`                | `string / null`       | `null`    | Layout passthrough if supported                             | No                             | Parent Patterns may pass placement classes only. Do not use for local color, typography, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and UI Reference proof before production use.

## 5. Allowed variants, options, and modifiers

| Name          | Type     | Status       | API              | Use when                                                                           | Do not use when                                               |
| ------------- | -------- | ------------ | ---------------- | ---------------------------------------------------------------------------------- | ------------------------------------------------------------- |
| Neutral tag   | Tone     | Approved API | `tone="neutral"` | The tag is metadata, type, owner, category, or non-semantic classification.        | The tag communicates error, success, warning, or info status. |
| Info tag      | Tone     | Approved API | `tone="info"`    | The tag communicates neutral system information or in-progress state.              | The value is only decorative or category metadata.            |
| Success tag   | Tone     | Approved API | `tone="success"` | The item is complete, active, verified, or healthy.                                | The tag is merely positive marketing copy.                    |
| Warning tag   | Tone     | Approved API | `tone="warning"` | The item needs attention but is not blocking.                                      | The issue is blocking or invalid.                             |
| Error tag     | Tone     | Approved API | `tone="error"`   | The item is blocked, failed, invalid, or unsafe.                                   | Use Notification when the user needs explanatory feedback.    |
| Inverse tag   | Tone     | Gated        | `tone="inverse"` | A tag appears on an inverse/high-contrast surface and Color tokens prove contrast. | Use on normal light/dark layers.                              |
| Small tag     | Size     | Approved API | `size="sm"`      | Dense tables, list rows, metadata lines, or compact panels.                        | Tags need to stand alone in larger content.                   |
| Medium tag    | Size     | Approved API | `size="md"`      | Default app UI and card/list metadata.                                             | Dense table cells require a smaller treatment.                |
| Icon tag      | Modifier | Approved API | `icon="..."`     | The icon reinforces state or category and text remains visible.                    | The icon replaces text or adds decorative noise.              |
| Removable tag | Modifier | Gated        | `removable`      | Pattern-owned filters or selected criteria need removal controls.                  | Static metadata, status, or category tags.                    |

## 6. States

| State                      | Status                         | API representation          | Notes                                                                                          |
| -------------------------- | ------------------------------ | --------------------------- | ---------------------------------------------------------------------------------------------- |
| Default                    | Approved API                   | `x-ui.tag` with tone/size   | Non-interactive display state.                                                                 |
| Hover                      | Not applicable for static tags | none                        | Static tags do not respond to hover. Removable tags must define hover for the remove control.  |
| Focus-visible              | Gated for removable tags       | Remove button focus         | Static tags are not focusable.                                                                 |
| Active/pressed             | Gated for removable tags       | Remove button pressed state | Only applies to the removal action.                                                            |
| Disabled                   | Not applicable for static tags | none                        | Disabled tags are usually a smell; explain unavailable status through content or Notification. |
| Selected                   | Pattern-owned                  | Filter Pattern state        | Selected filters may render as tags, but the Pattern owns state.                               |
| Error/warning/success/info | Approved API                   | `tone`                      | Semantic tones must not rely on color alone.                                                   |
| Loading                    | Not applicable                 | none                        | Use Inline loading or Loading.                                                                 |
| Empty                      | Not applicable                 | none                        | Do not render empty tags.                                                                      |

## 7. Token, class, and helper usage

### 7.1. Tag consumes Foundation Element APIs:

- Color: token-backed neutral and semantic surfaces, text, icon, border, inverse, and disabled roles.
- Spacing: internal padding and icon/label gap.
- Typography: compact label text.
- Themes: light/dark and inverse contrast.
- Icons: approved Heroicons only when text remains visible.

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$tag-background-*`, `$tag-color-*`, `$tag-hover-*`, `$tag-border-*` | Read-only, operational, and dismissible all-color tag families | Tag tone/variant API and app-owned tag variables only when installed | Component-owned tag palette | Needs verification | Public Carbon docs point to component token families but exact all-color rows remain source-inferred; do not standardize local palettes until verified. |
| `$layer` | Disabled tag background and selectable default background | Tag disabled/selectable classes using layer role | App layer palette | Same role / app value | Disabled/selectable layer use must match the global layer mapping. |
| `$text-disabled` | Disabled tag text | Tag disabled text role | App text palette | Same role / app value | Disabled tags must not use opacity-only treatment. |
| `$border-disabled` | Disabled outline/operational border | Tag disabled border role | App border palette | Same role / app value | Border-disabled stays Color-owned. |
| `$focus` | Tag focus container border | Tag focus-visible state | App focus palette | Same role / app value | Only interactive/removable/selectable tags receive focus. |
| `$background-inverse`, `$text-inverse`, `$border-inverse` | High-contrast and selected tag roles | `tone="inverse"` / selected tag state when installed | App inverse palette | Same role / app value | Inverse and selected roles are gated until contrast proof exists. |
| `$background`, `$background-hover`, `$text-primary`, `$icon-primary` | Outline and selectable core-token exceptions | Outline/selectable tag variant roles | App background/text/icon palettes | Same role / app value | These are core-token exceptions, not a separate tag color family. |
| `$icon-color` | Public-doc high-contrast read-only icon anomaly | No standard Login App mapping yet | None | Needs verification | Treat the Carbon row as anomalous until source verification promotes a real token. |

Do not hard-code tag colors, arbitrary border colors, pill radii, icon sources, or local spacing.

## 8. Composition rules

- Tags may appear in table cells, list rows, tiles, cards, filters, headers, and metadata groups.
- Parent Patterns own external spacing and wrapping behavior.
- A tag group must wrap predictably and preserve scan order.
- Static tags must not contain buttons, links, menus, or form controls.
- Removable tags are gated until the Pattern owns filter state, removal behavior, focus, and persistence.

## 9. Selection guidance

### 9.1. Use when:

- The UI needs compact metadata, type, category, ownership, status, or filter-token display.
- A semantic state needs a short visual marker next to the relevant object.
- A table/list/card needs scannable labels.

### 9.2. Do not use when:

- The message needs explanation or action; use Notification.
- The user must activate a command; use Button, Link, Menu, or Menu buttons.
- The UI is switching views; use Tabs or Content switcher when installed.
- The value is long-form content; use plain text or a Structured list.

## 10. Accessibility contract

- Tag text must communicate the meaning without relying on color alone.
- Semantic tones must meet contrast requirements in supported themes.
- Icons are decorative unless they add meaning not present in text; meaningful icons need accessible text.
- Removable tags must expose a keyboard-focusable remove control with an accessible name before production use.
- Do not make static tags focusable.

## 11. Content contract

- Use short sentence-case labels.
- Prefer nouns or concise state phrases such as `Active`, `Pending review`, `Internal`, or `Trial`.
- Avoid vague labels such as `Other`, `Misc`, or `New` unless the surrounding data model defines them.
- Do not use tags as full sentences or explanatory copy.

## 12. Prohibited usage

- Do not render Tag through copied Tabs, Badge, or Status standards text.
- Do not use tags as buttons, tabs, breadcrumbs, or notifications.
- Do not hard-code tag color, border, typography, icon, radius, or spacing.
- Do not use semantic tones for decoration.
- Do not create local removable/filter-chip behavior before the Pattern and Component API are installed.

## 13. Deferred or gated capabilities

| Capability               | Status       | Trigger condition                                                                           |
| ------------------------ | ------------ | ------------------------------------------------------------------------------------------- |
| Final `x-ui.tag` wrapper | Approved API | Create or alias the public wrapper, source file, UI Reference examples, and tests.          |
| Removable/filter tag     | Gated        | Filter/search Pattern defines removal behavior, focus, persistence, and empty-filter state. |
| Inverse tag              | Gated        | Color token proof shows contrast on inverse/high-contrast surfaces.                         |
| Tag group helper         | Deferred     | Needed only when repeated tag wrapping and spacing require a reusable API.                  |

## 14. Implementation and UI Reference Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and UI Reference route assertions block generic fallback content.                                                            |

### 14.2. UI Reference proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

| Required proof            | Rendered behavior                                                          | Variants/options shown                        |
| ------------------------- | -------------------------------------------------------------------------- | --------------------------------------------- |
| Metadata tags             | Neutral tags in list/card/table contexts.                                  | Neutral, small, medium                        |
| Semantic status tags      | Status tags that remain readable in light and dark themes.                 | Info, success, warning, error                 |
| Icon-supported tags       | Icons paired with visible text.                                            | Icon tag, decorative icon handling            |
| Filter/removable boundary | Gated disposition for removable tags until Pattern ownership exists.       | Removable deferred/gated                      |
| Developer implementation  | Canonical calls and transitional alias notes render as real code examples. | `x-ui.tag`, transitional badge/status aliases |

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/tag` returns 200 for authorized users.
- The page identifies Tag as the Tag/Badge/Status boundary, not Tabs.
- The page shows `x-ui.tag` or explicitly marks the final wrapper as gated until wrapper installation while naming transitional badge/status source files.
- The page renders neutral, info, success, warning, error, small, medium, and icon-supported examples.
- The page does not render removable tags as implemented until Pattern-owned behavior is installed.
- Tests assert the page does not contain copied Tabs copy, `x-ui.tabs`, or `data-ui-tabs`.

## 17. Related APIs

| API                 | Route                                            |
| ------------------- | ------------------------------------------------ |
| Notification        | `/platform/ui-reference/components/notification` |
| Data table          | `/platform/ui-reference/components/data-table`   |
| Tile                | `/platform/ui-reference/components/tile`         |
| Tables Pattern      | `/platform/ui-reference/patterns/tables`         |
| Layout Pattern      | `/platform/ui-reference/patterns/layout`         |
| Components overview | `/platform/ui-reference/components`              |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Color](../elements/color.md)
- [Foundation Typography](../elements/typography.md)
- [Foundation Icons](../elements/icons.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tag usage, style, and accessibility guidance are comparison input only; Login App owns its Tag API, tone names, token values, and UI Reference proof.