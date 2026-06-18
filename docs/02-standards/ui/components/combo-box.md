---
title: Combo box
slug: combo-box
status: queued-gap
api_layer: Component API
category: Inputs
priority: Tier B - Common reusable component
ui_reference_route: /platform/ui-reference/components/combo-box
canonical_doc: docs/02-standards/ui/components/combo-box.md
source_owner: /platform/ui-reference/components/combo-box
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - dropdown
  - multiselect
  - select
  - text-input
related_patterns:
  - forms
---

# Combo Box Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Combo box is the future Component API owner for typed known-option selection, typeahead filtering, highlighted suggestions, clear control behavior, and optional custom-value entry.

Canonical API owner: `/platform/ui-reference/components/combo-box`. This page exists so Combo box is not treated as a Dropdown variant or hidden inside Multiselect.

## 2. Status and ownership

| Field              | Value                                         |
| ------------------ | --------------------------------------------- |
| Status             | Queued gap                                    |
| API layer          | Component API                                 |
| Component slug     | combo-box                                     |
| Category           | Inputs                                        |
| Priority           | Tier B - Common reusable component            |
| UI Reference route | `/platform/ui-reference/components/combo-box` |
| Canonical doc      | `docs/02-standards/ui/components/combo-box.md` |
| Source owner       | `/platform/ui-reference/components/combo-box` |

## 3. Installed standard

No public Combo box Blade API is approved yet.

The installed standard is the boundary:

- Do not implement Combo box behavior inside Dropdown.
- Do not implement Combo box behavior inside Select.
- Do not implement typed filtering or custom-value entry through feature-local markup.
- Use Dropdown when the user chooses one known option without typing.
- Use Multiselect when the user chooses multiple known options.
- Use Select when native short-list form selection is the better fit.
- Use Text input or Search when the user enters free text and no option selection is required.

## 4. Public API

| API surface   | Installed value |
| ------------- | --------------- |
| Blade         | No public API approved. |
| JavaScript    | No public API approved. |
| CSS namespace | `resources/css/components/combo-box.css` is a Carbon SCSS-derived visual target only until Blade/API work is approved. |
| Route         | `/platform/ui-reference/components/combo-box` |

## 5. Allowed variants, options, and modifiers

None are approved for production use.

## 6. States

Queued states include default, open, highlighted suggestion, selected value, typed query, clearable, disabled, read-only, invalid, warning, loading, empty, and custom-value pending. These states are not complete until the public API, JavaScript behavior, accessibility contract, and UI Reference proof are implemented.

## 7. Token, class, and helper usage

Future implementation must consume existing field, listbox, text input, icon, focus, motion, and theme tokens. It must not define raw colors, local focus rings, or feature-owned listbox styling.

## 8. Composition rules

Combo box will compose Text input and ListBox behavior. Parent Patterns own layout, submission, filtering intent, persistence, and remote-data policy.

## 9. Selection guidance

Use Combo box only when typing is part of the selection workflow. If users only choose from visible or short known options, use Select, Dropdown, Radio button, Checkbox, or Multiselect according to the selection count and visibility requirements.

## 10. Accessibility contract

Before implementation, the component must define keyboard behavior for typing, arrow navigation, Home/End, Escape, Enter, Tab, clear control focus order, listbox option announcement, active descendant behavior, disabled/read-only state, and validation copy association.

## 11. Content contract

Option labels must remain short and text-first. Helper, empty, loading, error, and warning copy must be concise and state the user action or consequence.

## 12. Prohibited usage

- Do not use Dropdown markup plus a local input to create Combo box behavior.
- Do not use Menu roles for selectable values.
- Do not use feature-local JavaScript for typed option filtering.
- Do not approve custom-value entry without validation and persistence rules.

## 13. Deferred or gated capabilities

Combo box remains gated until a concrete workflow requires typed known-option selection or custom-value entry and the component API pass defines the full Blade, CSS, JavaScript, accessibility, and UI Reference contract.

## 14. Implementation and UI Reference Checklist

### 14.1. Implementation checklist

| Area                       | Requirement |
| -------------------------- | ----------- |
| Public API                 | Blade props, data attributes, and source ownership are defined. |
| States                     | Default, hover, focus, open, selected, highlighted, disabled, read-only, validation, loading, empty, and custom-value states are defined. |
| Accessibility/content      | Keyboard, focus, ARIA, naming, helper, error, warning, and option announcement behavior are defined. |
| Foundation dependencies    | Color, Spacing, Typography, Themes, Motion, and Icons are consumed through approved tokens/classes. |

### 14.2. UI Reference proof checklist

| Area | Requirement |
| ---- | ----------- |
| Live examples | Render default, selected, filtered, clearable, invalid, disabled, read-only, loading, empty, and custom-value-gated examples after implementation. |
| Boundaries | Link Dropdown, Multiselect, Select, Text input, Search, and Forms Pattern boundaries. |
| Tests | Assert the route renders as queued until the API is implemented, then assert public Blade/CSS/JS behavior. |

## 15. UI Reference requirements

The UI Reference page must exist as a standalone route while queued. It must not render fake working Combo box controls before the actual API is approved.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/combo-box` renders as a standalone queued-gap component page.
- The page states that no public Combo box API is approved.
- Dropdown UI Reference does not render Combo box as a Dropdown variant.

## 17. Related APIs

- [Dropdown](dropdown.md)
- [Multiselect](multiselect.md)
- [Select](select.md)
- [Text input](text-input.md)
- [Search](search.md)

## 18. References

- Carbon Combo box guidance is reference material for the later API pass. Login App will keep app-owned Blade, CSS, JavaScript, token, and UI Reference contracts.
