---
title: Carbon Color Token Mapping Inventory
slug: carbon-color-token-mapping-inventory
status: research-reference
api_layer: Support reference
canonical_doc: docs/02-standards/ui/elements/color-carbon-token-inventory.md
source_owner: docs/02-standards/ui/elements/color.md
related_element: docs/02-standards/ui/elements/color.md
---

# Carbon Color Token Mapping Inventory
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard relationship](#3-installed-standard-relationship)
  - [3.1. Carbon layer model](#31-carbon-layer-model)
  - [3.2. Login App governance rule](#32-login-app-governance-rule)
- [4. Research cleanup notes](#4-research-cleanup-notes)
- [5. Master token catalog](#5-master-token-catalog)
  - [5.1. Core semantic token families](#51-core-semantic-token-families)
  - [5.2. Contextual aliases and scoped token families](#52-contextual-aliases-and-scoped-token-families)
- [6. Component token mappings](#6-component-token-mappings)
  - [6.1. Component table schema](#61-component-table-schema)
  - [6.2. Button](#62-button)
    - [6.2.1. Source pages](#621-source-pages)
    - [6.2.2. Token mappings](#622-token-mappings)
  - [6.3. Checkbox](#63-checkbox)
    - [6.3.1. Source pages](#631-source-pages)
    - [6.3.2. Token mappings](#632-token-mappings)
  - [6.4. Link](#64-link)
    - [6.4.1. Source pages](#641-source-pages)
    - [6.4.2. Token mappings](#642-token-mappings)
  - [6.5. List](#65-list)
    - [6.5.1. Source pages](#651-source-pages)
    - [6.5.2. Token mappings](#652-token-mappings)
  - [6.6. Loading](#66-loading)
    - [6.6.1. Source pages](#661-source-pages)
    - [6.6.2. Token mappings](#662-token-mappings)
  - [6.7. Toggle](#67-toggle)
    - [6.7.1. Source pages](#671-source-pages)
    - [6.7.2. Token mappings](#672-token-mappings)
  - [6.8. Select](#68-select)
    - [6.8.1. Source pages](#681-source-pages)
    - [6.8.2. Token mappings](#682-token-mappings)
  - [6.9. Dropdown](#69-dropdown)
    - [6.9.1. Source pages](#691-source-pages)
    - [6.9.2. Token mappings](#692-token-mappings)
  - [6.10. Number input](#610-number-input)
    - [6.10.1. Source pages](#6101-source-pages)
    - [6.10.2. Token mappings](#6102-token-mappings)
  - [6.11. Text input](#611-text-input)
    - [6.11.1. Source pages](#6111-source-pages)
    - [6.11.2. Token mappings](#6112-token-mappings)
  - [6.12. Text area](#612-text-area)
    - [6.12.1. Source pages](#6121-source-pages)
    - [6.12.2. Token mappings](#6122-token-mappings)
  - [6.13. Text input / Text area](#613-text-input--text-area)
    - [6.13.1. Source pages](#6131-source-pages)
    - [6.13.2. Token mappings](#6132-token-mappings)
  - [6.14. Date picker](#614-date-picker)
    - [6.14.1. Source pages](#6141-source-pages)
    - [6.14.2. Token mappings](#6142-token-mappings)
  - [6.15. Time picker](#615-time-picker)
    - [6.15.1. Source pages](#6151-source-pages)
    - [6.15.2. Token mappings](#6152-token-mappings)
  - [6.16. Date picker / Time picker](#616-date-picker--time-picker)
    - [6.16.1. Source pages](#6161-source-pages)
    - [6.16.2. Token mappings](#6162-token-mappings)
  - [6.17. Data table](#617-data-table)
    - [6.17.1. Source pages](#6171-source-pages)
    - [6.17.2. Token mappings](#6172-token-mappings)
  - [6.18. Form](#618-form)
    - [6.18.1. Source pages](#6181-source-pages)
    - [6.18.2. Token mappings](#6182-token-mappings)
- [7. Pattern token mappings](#7-pattern-token-mappings)
  - [7.1. Read-only states](#71-read-only-states)
    - [7.1.1. Source pages](#711-source-pages)
    - [7.1.2. Token mappings](#712-token-mappings)
  - [7.2. Status indicators](#72-status-indicators)
    - [7.2.1. Source pages](#721-source-pages)
    - [7.2.2. Token mappings](#722-token-mappings)
- [8. Coverage and gaps report](#8-coverage-and-gaps-report)
  - [8.1. Pages checked by the research pass](#81-pages-checked-by-the-research-pass)
  - [8.2. Pages with the clearest explicit color-token mappings](#82-pages-with-the-clearest-explicit-color-token-mappings)
  - [8.3. Known extraction gaps](#83-known-extraction-gaps)
- [9. Login App conversion guidance](#9-login-app-conversion-guidance)
  - [9.1. Convert into Color Element roles](#91-convert-into-color-element-roles)
  - [9.2. Convert into Component standards](#92-convert-into-component-standards)
  - [9.3. Convert into Pattern standards](#93-convert-into-pattern-standards)
  - [9.4. Do not copy blindly](#94-do-not-copy-blindly)
- [10. Related Login App standards](#10-related-login-app-standards)
- [11. References](#11-references)

## 1. API summary

This support reference organizes the Carbon Design System color-token research into a standards-friendly structure for Login App 2.0 color-governance work.

This file is not the Login App Color Element API. The canonical app color rules belong in `docs/02-standards/ui/elements/color.md`. Use this report as third-party benchmark material when deciding whether a color role belongs globally in the Color Element, locally in a Component API, or compositionally in a Pattern API.

## 2. Status and ownership

| Field                  | Value                                                                                           |
| ---------------------- | ----------------------------------------------------------------------------------------------- |
| Status                 | Research reference                                                                              |
| API layer              | Support reference for Foundation Element API work                                               |
| Primary app standard   | `docs/02-standards/ui/elements/color.md`                                                        |
| Source report          | Uploaded Carbon color-token research report                                                     |
| Canonical support path | `docs/02-standards/ui/elements/color-carbon-token-inventory.md`                                 |
| rendered evidence owner     | `not installed`                                                         |
| Carbon scope           | Current public Carbon color, component style, and pattern pages identified by the research pass |

## 3. Installed standard relationship

Login App should mirror Carbon's structural separation, not copy Carbon tokens directly.

### 3.1. Carbon layer model

| Layer                  | Carbon role                                                                                                              | Login App interpretation                                                                    |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------- |
| Global semantic tokens | System-wide roles such as background, layer, text, border, link, icon, support, focus, overlay, and skeleton             | Candidate source material for the Color Element API vocabulary.                             |
| Contextual aliases     | Placement-aware roles such as `$field`, `$field-hover`, `$layer`, `$layer-hover`, `$border-strong`, and `$border-subtle` | Candidate app aliases only when the app needs contextual layer/field behavior.              |
| Component tokens       | Component-scoped tokens such as Button-specific colors                                                                   | Belong in the owning Component API unless Login App intentionally promotes a role globally. |
| Pattern tokens         | Pattern-scoped status or composition colors                                                                              | Belong in the owning Pattern API unless promoted through the Color Element standard.        |
| AI tokens              | AI-specific surface, aura, border, overlay, and shadow roles                                                             | Keep isolated behind AI-specific Component/Pattern gates.                                   |

### 3.2. Login App governance rule

Use this file to locate Carbon source material. Do not treat this file as permission to use Carbon token names, Carbon classes, Carbon visual values, or Carbon component implementations in Login App source code.

## 4. Research cleanup notes

- The original report used one large mixed component/pattern mapping table. This replacement separates those rows by Component or Pattern so they can be reviewed, copied, or converted into Login App standards independently.
- Old inline research citation markers were removed from table cells and replaced with source page names and URLs where the source page is identifiable.
- Obvious formatting omissions from the report were normalized, such as `field-hover` to `$field-hover` and `support-warning` to `$support-warning`.
- Token rows that still look legacy, incomplete, or source-inferred should be verified against the current Carbon package before becoming a hard Login App standard.

## 5. Master token catalog

### 5.1. Core semantic token families

| Token family                                                                                                                                                                                                                                                                                                            | Category      | Scope       | Purpose / semantic role                                                                   | Theme notes                                                                    | Status  | Source                                                                                                         |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------- | ----------- | ----------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------ | ------- | -------------------------------------------------------------------------------------------------------------- |
| `$background`, `$layer-background-01`                                                                                                                                                                                                                                                                                   | Background    | Core/global | Default page background; contextual layer background alias                                | Theme-controlled global role                                                   | Current | [Color tokens — Background](https://carbondesignsystem.com/elements/color/tokens/)                             |
| `$background-hover`, `$background-active`, `$background-selected`, `$background-selected-hover`                                                                                                                                                                                                                         | Background    | Core/global | Hover, active, selected, and selected-hover states for base backgrounds                   | Current docs describe state logic as systematic by token suffix                | Current | [Color tokens — Background; Color overview state logic](https://carbondesignsystem.com/elements/color/tokens/) |
| `$background-inverse`, `$background-inverse-hover`, `$background-brand`                                                                                                                                                                                                                                                 | Background    | Core/global | High-contrast backgrounds and branded feature background                                  | Theme-controlled; inverse roles are used in high-contrast moments              | Current | [Color tokens — Background](https://carbondesignsystem.com/elements/color/tokens/)                             |
| `$layer-01`, `$layer-02`, `$layer-03`                                                                                                                                                                                                                                                                                   | Layer         | Core/global | Sequential container colors as layers stack                                               | Layering is theme-driven; light and dark themes behave differently in practice | Current | [Color tokens — Layer; Themes overview](https://carbondesignsystem.com/elements/color/tokens/)                 |
| `$layer-background-02`, `$layer-background-03`                                                                                                                                                                                                                                                                          | Layer         | Core/global | Contextual layer-background aliases for deeper stacks                                     | Automatically match contextual layer background                                | Current | [Color tokens — Layer](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$layer-hover-01`, `$layer-hover-02`, `$layer-hover-03`                                                                                                                                                                                                                                                                 | Layer         | Core/global | Hover states for layer containers                                                         | State suffix follows Carbon state logic                                        | Current | [Color tokens — Layer](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$layer-active-01`, `$layer-active-02`, `$layer-active-03`                                                                                                                                                                                                                                                              | Layer         | Core/global | Active states for layer containers                                                        | State suffix follows Carbon state logic                                        | Current | [Color tokens — Layer](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$layer-selected-01`, `$layer-selected-02`, `$layer-selected-03`                                                                                                                                                                                                                                                        | Layer         | Core/global | Selected states for layer containers                                                      | State suffix follows Carbon state logic                                        | Current | [Color tokens — Layer](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$layer-selected-hover-01`, `$layer-selected-hover-02`, `$layer-selected-hover-03`                                                                                                                                                                                                                                      | Layer         | Core/global | Hover states for selected layers                                                          | State suffix follows Carbon state logic                                        | Current | [Color tokens — Layer](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$border-interactive`                                                                                                                                                                                                                                                                                                   | Border        | Core/global | Interactive/selected/active borders with 3:1 non-text contrast intent                     | Theme-controlled                                                               | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$border-subtle-00`, `$border-subtle-01`, `$border-subtle-02`, `$border-subtle-03`                                                                                                                                                                                                                                      | Border        | Core/global | Subtle borders paired with background/layer contexts                                      | Layer-paired by suffix number                                                  | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$border-subtle-selected-01`, `$border-subtle-selected-02`, `$border-subtle-selected-03`                                                                                                                                                                                                                                | Border        | Core/global | Selected subtle-border states                                                             | Contextual by layer suffix                                                     | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$border-strong-01`, `$border-strong-02`, `$border-strong-03`                                                                                                                                                                                                                                                           | Border        | Core/global | Medium-contrast borders; specifically documented as border-bottom partners for field sets | Contextual by field/layer suffix                                               | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$border-tile-01`, `$border-tile-02`, `$border-tile-03`                                                                                                                                                                                                                                                                 | Border        | Core/global | Operable tile indicators paired with corresponding layer contexts                         | Contextual by layer suffix                                                     | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$border-inverse`, `$border-disabled`                                                                                                                                                                                                                                                                                   | Border        | Core/global | High-contrast border; disabled border color                                               | Theme-controlled                                                               | Current | [Color tokens — Border](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$text-primary`                                                                                                                                                                                                                                                                                                         | Text          | Core/global | Primary text, body copy, headers; hover text color for `$text-secondary`                  | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-secondary`                                                                                                                                                                                                                                                                                                       | Text          | Core/global | Secondary text and input labels                                                           | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-placeholder`                                                                                                                                                                                                                                                                                                     | Text          | Core/global | Placeholder text                                                                          | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-on-color`, `$text-on-color-disabled`                                                                                                                                                                                                                                                                             | Text          | Core/global | Text on interactive/button colors; disabled state for that role                           | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-helper`                                                                                                                                                                                                                                                                                                          | Text          | Core/global | Tertiary/help text                                                                        | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-error`                                                                                                                                                                                                                                                                                                           | Text          | Core/global | Error-message text                                                                        | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$text-inverse`, `$text-disabled`                                                                                                                                                                                                                                                                                       | Text          | Core/global | Inverse text; disabled text                                                               | Theme-controlled                                                               | Current | [Color tokens — Text](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$link-primary`, `$link-primary-hover`, `$link-secondary`                                                                                                                                                                                                                                                               | Link          | Core/global | Primary, primary-hover, and secondary-link roles                                          | Theme-controlled                                                               | Current | [Color tokens — Link](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$link-inverse`, `$link-inverse-hover`, `$link-inverse-active`, `$link-inverse-visited`                                                                                                                                                                                                                                 | Link          | Core/global | Link roles on inverse/high-contrast backgrounds                                           | Inverse/high-contrast usage                                                    | Current | [Color tokens — Link](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$link-visited`                                                                                                                                                                                                                                                                                                         | Link          | Core/global | Visited-link color                                                                        | Theme-controlled                                                               | Current | [Color tokens — Link](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$icon-primary`, `$icon-secondary`                                                                                                                                                                                                                                                                                      | Icon          | Core/global | Primary and secondary icons                                                               | Theme-controlled                                                               | Current | [Color tokens — Icon](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$icon-on-color`, `$icon-on-color-disabled`                                                                                                                                                                                                                                                                             | Icon          | Core/global | Icons on interactive/non-layer colors and their disabled state                            | Theme-controlled                                                               | Current | [Color tokens — Icon](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$icon-interactive`, `$icon-inverse`, `$icon-disabled`                                                                                                                                                                                                                                                                  | Icon          | Core/global | Operability icons; inverse icons; disabled icons                                          | Theme-controlled                                                               | Current | [Color tokens — Icon](https://carbondesignsystem.com/elements/color/tokens/)                                   |
| `$support-error`, `$support-success`, `$support-warning`, `$support-info`                                                                                                                                                                                                                                               | Support       | Core/global | Standard error/success/warning/info roles                                                 | Theme-controlled                                                               | Current | [Color tokens — Support](https://carbondesignsystem.com/elements/color/tokens/)                                |
| `$support-error-inverse`, `$support-success-inverse`, `$support-warning-inverse`, `$support-info-inverse`                                                                                                                                                                                                               | Support       | Core/global | High-contrast variants for support roles                                                  | Used in high-contrast moments                                                  | Current | [Color tokens — Support](https://carbondesignsystem.com/elements/color/tokens/)                                |
| `$support-caution-minor`, `$support-caution-major`, `$support-caution-undefined`                                                                                                                                                                                                                                        | Support       | Core/global | Minor caution, major caution, and undefined status roles                                  | Theme-controlled                                                               | Current | [Color tokens — Support](https://carbondesignsystem.com/elements/color/tokens/)                                |
| `$focus`, `$focus-inset`, `$focus-inverse`                                                                                                                                                                                                                                                                              | Focus         | Core/global | Focus border/underline; inset contrast border; focus on high-contrast moments             | Carbon says focus is usually standardized around one focus token per theme     | Current | [Color tokens — Focus](https://carbondesignsystem.com/elements/color/tokens/)                                  |
| `$interactive`                                                                                                                                                                                                                                                                                                          | Miscellaneous | Core/global | Selected/active elements and accent icons with 3:1 AA intent                              | Theme-controlled                                                               | Current | [Color tokens — Miscellaneous](https://carbondesignsystem.com/elements/color/tokens/)                          |
| `$highlight`                                                                                                                                                                                                                                                                                                            | Miscellaneous | Core/global | Highlight color                                                                           | Theme-controlled                                                               | Current | [Color tokens — Miscellaneous](https://carbondesignsystem.com/elements/color/tokens/)                          |
| `$toggle-off`                                                                                                                                                                                                                                                                                                           | Miscellaneous | Core/global | Off-state background with 3:1 AA intent                                                   | Theme-controlled                                                               | Current | [Color tokens — Miscellaneous](https://carbondesignsystem.com/elements/color/tokens/)                          |
| `$overlay`                                                                                                                                                                                                                                                                                                              | Miscellaneous | Core/global | Background overlay                                                                        | Theme-controlled                                                               | Current | [Color tokens — Miscellaneous](https://carbondesignsystem.com/elements/color/tokens/)                          |
| `$skeleton-element`, `$skeleton-background`                                                                                                                                                                                                                                                                             | Miscellaneous | Core/global | Skeleton colors for text/UI elements and containers                                       | Theme-controlled                                                               | Current | [Color tokens — Miscellaneous](https://carbondesignsystem.com/elements/color/tokens/)                          |
| `$syntax-comment`, `$syntax-line-comment`, `$syntax-block-comment`, `$syntax-doc-comment`                                                                                                                                                                                                                               | Syntax        | Core/global | Comment syntax-highlighting roles                                                         | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-doc-string`, `$syntax-string`, `$syntax-character`, `$syntax-attribute-value`, `$syntax-color`, `$syntax-content`, `$syntax-list`, `$syntax-emphasis`, `$syntax-strong`, `$syntax-monospace`, `$syntax-strikethrough`, `$syntax-macro-name`, `$syntax-atom`, `$syntax-literal`, `$syntax-bool`, `$syntax-null` | Syntax        | Core/global | String/literal/content highlighting roles                                                 | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-tag`, `$syntax-tag-name`, `$syntax-type`, `$syntax-type-name`, `$syntax-class-name`, `$syntax-namespace`, `$syntax-self`, `$syntax-annotation`, `$syntax-type-operator`                                                                                                                                        | Syntax        | Core/global | Type-like and tag-like syntax roles                                                       | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-number`, `$syntax-integer`, `$syntax-float`, `$syntax-unit`                                                                                                                                                                                                                                                    | Syntax        | Core/global | Numeric syntax roles                                                                      | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-special-string`, `$syntax-regexp`, `$syntax-control-operator`, `$syntax-processing-instruction`                                                                                                                                                                                                                | Syntax        | Core/global | Special-string/regexp/control-like syntax roles                                           | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-escape`, `$syntax-url`, `$syntax-operator`, `$syntax-update-operator`, `$syntax-brace`, `$syntax-content-separator`                                                                                                                                                                                            | Syntax        | Core/global | Escape/operator/separator syntax roles                                                    | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-heading`, `$syntax-heading-1`, `$syntax-heading-2`, `$syntax-heading-3`, `$syntax-heading-4`, `$syntax-heading-5`, `$syntax-heading-6`, `$syntax-definition`, `$syntax-definition-operator`                                                                                                                    | Syntax        | Core/global | Heading/definition syntax roles                                                           | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-quote`, `$syntax-link`, `$syntax-invalid`, `$syntax-meta`, `$syntax-document-meta`                                                                                                                                                                                                                             | Syntax        | Core/global | Quote/link/invalid/meta syntax roles                                                      | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |
| `$syntax-constant`, `$syntax-function`, `$syntax-standard`, `$syntax-local`, `$syntax-special`, `$syntax-deleted`, `$syntax-inserted`                                                                                                                                                                                   | Syntax        | Core/global | Constant/function/standard/local/special and diff syntax roles                            | Theme-controlled syntax family                                                 | Current | [Color tokens — Syntax](https://carbondesignsystem.com/elements/color/tokens/)                                 |

### 5.2. Contextual aliases and scoped token families

| Token family                                                                                                                                          | Category                | Scope              | Purpose / semantic role                                                                                                                  | Theme notes                                                                                                            | Status                                                        | Source                                                                                                |
| ----------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------- | ------------------ | ---------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| `$field`, `$field-hover`                                                                                                                              | Field contextual alias  | Core/contextual    | Field background and hover field background used across form controls                                                                    | Current style pages mark these as contextual tokens that change with layer                                             | Current                                                       | Select, Dropdown, Number input, Date picker, Text input style pages                                   |
| `$layer`, `$layer-hover`, `$layer-active`, `$layer-selected`                                                                                          | Layer contextual alias  | Core/contextual    | Menu/calendar/table/container background roles on the contextual layer                                                                   | Contextual aliases change with placement/layer                                                                         | Current                                                       | Dropdown, Date picker, Data table AI, Loading style pages                                             |
| `$border-strong`, `$border-subtle`                                                                                                                    | Border contextual alias | Core/contextual    | Common form-control border-bottom roles for enabled/disabled/read-only contexts                                                          | Contextual aliases change with layer/variant                                                                           | Current                                                       | Select, Dropdown, Number input, Date picker, Text input style pages                                   |
| `$button-primary`, `$button-primary-hover`, `$button-primary-active`                                                                                  | Button component tokens | Component-specific | Primary-button container and interactive states                                                                                          | Public docs show exact usage; Sass docs confirm a component-token module exists for button                             | Current                                                       | [Button style; Sass docs](https://carbondesignsystem.com/components/button/style/)                    |
| `$button-secondary`, `$button-secondary-hover`, `$button-secondary-active`                                                                            | Button component tokens | Component-specific | Secondary-button container and interactive states                                                                                        | Same as above                                                                                                          | Current                                                       | [Button style; Sass docs](https://carbondesignsystem.com/components/button/style/)                    |
| `$button-tertiary`, `$button-tertiary-hover`, `$button-tertiary-active`                                                                               | Button component tokens | Component-specific | Tertiary-button text/border/container roles and states                                                                                   | Same as above                                                                                                          | Current                                                       | [Button style; GitHub button-token examples](https://carbondesignsystem.com/components/button/style/) |
| `$button-danger-primary`, `$button-danger-hover`, `$button-danger-active`, `$button-danger-secondary`, `$button-disabled`                             | Button component tokens | Component-specific | Danger and disabled button states/variants                                                                                               | Public docs show usage directly                                                                                        | Current                                                       | [Button style](https://carbondesignsystem.com/components/button/style/)                               |
| `$ai-drop-shadow`, `$ai-inner-shadow`, `$ai-aura-start-sm`, `$ai-aura-stop`, `$ai-border-start`, `$ai-border-end`, `$ai-border-strong`, `$ai-overlay` | AI tokens               | AI-specific        | AI surfaces, glows, borders, shadows, and overlays for AI variants/instances                                                             | Carbon says AI tokens live in the main themes but should only be used for custom AI components, variants, or instances | Current                                                       | AI Tokens intro; Form/Data table/Modal/Select/Number input pages                                      |
| `$ai-aura-start`, `$ai-aura-hover-start`, `$ai-popover-background`, `$ai-popover-shadow-outer-01`, `$ai-popover-shadow-outer-02`                      | AI tokens               | AI-specific        | Additional AI token names surfaced in official GitHub design work but not fully exposed in the public token page excerpts retrieved here | Theme-specific values shown in official GitHub design-kit issue; treat as lower-confidence than current public docs    | GitHub-documented, not fully public-doc-verified in this pass | Official Carbon design-kit issue                                                                      |
| `$status-red`, `$status-orange`, `$status-yellow`, `$status-purple`, `$status-green`, `$status-blue`, `$status-gray`                                  | Status-indicator tokens | Pattern-level      | Contextual/icon/shape status semantics in the Status indicators pattern                                                                  | Status-indicator guidance is contextual rather than foundational core-token guidance                                   | Current                                                       | [Status indicators pattern](https://carbondesignsystem.com/patterns/status-indicator-pattern/)        |
| `$status-orange-outline`, `$status-yellow-outline`                                                                                                    | Status-indicator tokens | Pattern-level      | Outline variants for lighter shape indicators in low-contrast conditions                                                                 | Pattern-level status guidance                                                                                          | Current                                                       | [Status indicators pattern](https://carbondesignsystem.com/patterns/status-indicator-pattern/)        |

## 6. Component token mappings

Each subsection below preserves the same normalized schema so rows can be moved into the corresponding Login App Component API standard if the app adopts the mapping.

### 6.1. Component table schema

| Column                | Meaning                                                                              |
| --------------------- | ------------------------------------------------------------------------------------ |
| Variant               | Carbon variant, mode, or family.                                                     |
| Mode / size / density | Additional condition from the Carbon page.                                           |
| State                 | Default, hover, focus, active, disabled, selected, warning, error, AI presence, etc. |
| Anatomy element       | Component part receiving the token.                                                  |
| Property              | CSS/property role documented by Carbon.                                              |
| Color token           | Exact token/value reported by the research pass.                                     |
| Source section        | Carbon page section or table heading.                                                |
| Confidence            | `Documented`, `Source-inferred`, or other confidence note from the report.           |

### 6.2. Button

#### 6.2.1. Source pages

- [Button style](https://carbondesignsystem.com/components/button/style/)

#### 6.2.2. Token mappings

| Variant        | Mode / size / density | State    | Anatomy element | Property         | Color token                | Source section                                | Confidence |
| -------------- | --------------------- | -------- | --------------- | ---------------- | -------------------------- | --------------------------------------------- | ---------- |
| Primary        | Default               | Default  | Label           | text-color       | `$text-on-color`           | Primary button color                          | Documented |
| Primary        | Default               | Default  | Icon            | svg              | `$icon-on-color`           | Primary button color                          | Documented |
| Primary        | Default               | Default  | Container       | background-color | `$button-primary`          | Primary button color                          | Documented |
| Primary        | Default               | Hover    | Container       | background-color | `$button-primary-hover`    | Primary button interactive state color        | Documented |
| Primary        | Default               | Focus    | Container       | border           | `$focus`                   | Primary button interactive state color        | Documented |
| Primary        | Default               | Focus    | Container       | inset            | `$focus-inset`             | Primary button interactive state color        | Documented |
| Primary        | Default               | Active   | Container       | background-color | `$button-primary-active`   | Primary button interactive state color        | Documented |
| Primary        | Default               | Disabled | Label           | text-color       | `$text-on-color-disabled`  | Primary button interactive state color        | Documented |
| Primary        | Default               | Disabled | Icon            | svg              | `$icon-on-color-disabled`  | Primary button interactive state color        | Documented |
| Primary        | Default               | Disabled | Container       | background-color | `$button-disabled`         | Primary button interactive state color        | Documented |
| Secondary      | Default               | Default  | Label           | text-color       | `$text-on-color`           | Secondary button color                        | Documented |
| Secondary      | Default               | Default  | Icon            | svg              | `$icon-on-color`           | Secondary button color                        | Documented |
| Secondary      | Default               | Default  | Container       | background-color | `$button-secondary`        | Secondary button color                        | Documented |
| Secondary      | Default               | Hover    | Container       | background-color | `$button-secondary-hover`  | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Focus    | Container       | border           | `$focus`                   | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Focus    | Container       | inset            | `$focus-inset`             | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Active   | Container       | background-color | `$button-secondary-active` | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Disabled | Label           | text-color       | `$text-on-color-disabled`  | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Disabled | Icon            | svg              | `$icon-on-color-disabled`  | Secondary button interactive state color      | Documented |
| Secondary      | Default               | Disabled | Container       | background-color | `$button-disabled`         | Secondary button interactive state color      | Documented |
| Tertiary       | Default               | Default  | Label           | text-color       | `$button-tertiary`         | Tertiary button color                         | Documented |
| Tertiary       | Default               | Default  | Icon            | svg              | `$button-tertiary`         | Tertiary button color                         | Documented |
| Tertiary       | Default               | Default  | Container       | border           | `$button-tertiary`         | Tertiary button color                         | Documented |
| Tertiary       | Default               | Hover    | Label           | text-color       | `$text-inverse`            | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Hover    | Icon            | svg              | `$icon-inverse`            | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Hover    | Container       | background-color | `$button-tertiary-hover`   | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Focus    | Container       | background-color | `$button-tertiary`         | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Focus    | Container       | border           | `$focus`                   | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Focus    | Container       | inset            | `$focus-inset`             | Tertiary button interactive state color       | Documented |
| Tertiary       | Default               | Active   | Container       | background-color | `$button-tertiary-active`  | Tertiary button interactive state color       | Documented |
| Ghost          | Default               | Default  | Label           | text-color       | `$link-primary`            | Ghost button color                            | Documented |
| Ghost          | Default               | Default  | Icon            | svg              | `$link-primary`            | Ghost button color                            | Documented |
| Ghost          | Default               | Hover    | Label           | text-color       | `$link-primary-hover`      | Ghost button interactive state color          | Documented |
| Ghost          | Default               | Hover    | Container       | background-color | `$background-hover`        | Ghost button interactive state color          | Documented |
| Ghost          | Default               | Focus    | Container       | background-color | `$focus`                   | Ghost button interactive state color          | Documented |
| Ghost          | Default               | Active   | Container       | background-color | `$background-hover`        | Ghost button interactive state color          | Documented |
| Danger primary | Default               | Default  | Container       | background-color | `$button-danger-primary`   | Danger primary button color                   | Documented |
| Danger primary | Default               | Hover    | Container       | background-color | `$button-danger-hover`     | Danger primary button interactive state color | Documented |
| Danger primary | Default               | Focus    | Container       | border           | `$focus`                   | Danger primary button interactive state color | Documented |
| Danger primary | Default               | Focus    | Container       | inset            | `$focus-inset`             | Danger primary button interactive state color | Documented |
| Danger primary | Default               | Active   | Container       | background-color | `$button-danger-active`    | Danger primary button interactive state color | Documented |
| Danger primary | Default               | Disabled | Container       | background-color | `$button-disabled`         | Danger primary button interactive state color | Documented |

### 6.3. Checkbox

#### 6.3.1. Source pages

- [Checkbox style](https://carbondesignsystem.com/components/checkbox/style/)

#### 6.3.2. Token mappings

| Variant  | Mode / size / density | State     | Anatomy element | Property         | Color token        | Source section     | Confidence |
| -------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | ------------------ | ---------- |
| Standard | Default               | Default   | Group label     | text color       | `$text-secondary`  | Color              | Documented |
| Standard | Default               | Default   | Checkbox label  | text color       | `$text-primary`    | Color              | Documented |
| Standard | Default               | Unchecked | Checkbox        | border           | `$icon-primary`    | Color              | Documented |
| Standard | Default               | Checked   | Checkbox        | background-color | `$icon-primary`    | Color              | Documented |
| Standard | Default               | Checked   | Checkmark       | fill             | `$icon-inverse`    | Color              | Documented |
| Standard | Default               | Default   | Helper text     | text color       | `$text-secondary`  | Color              | Documented |
| Standard | Default               | Focus     | Checkbox        | border           | `$focus`           | Interactive states | Documented |
| Standard | Default               | Disabled  | Label           | text color       | `$text-disabled`   | Interactive states | Documented |
| Standard | Default               | Disabled  | Checkbox        | border           | `$icon-disabled`   | Interactive states | Documented |
| Standard | Default               | Disabled  | Checkbox        | background       | `$icon-disabled`   | Interactive states | Documented |
| Standard | Default               | Read-only | Checkbox        | border           | `$icon-disabled`   | Interactive states | Documented |
| Standard | Default               | Read-only | Checkbox        | inner fill       | `$icon-primary`    | Interactive states | Documented |
| Standard | Default               | Error     | Checkbox        | border           | `$support-error`   | Interactive states | Documented |
| Standard | Default               | Error     | Error message   | text color       | `$text-error`      | Interactive states | Documented |
| Standard | Default               | Error     | Error icon      | svg              | `$support-error`   | Interactive states | Documented |
| Standard | Default               | Warning   | Warning icon    | svg              | `$support-warning` | Interactive states | Documented |

### 6.4. Link

#### 6.4.1. Source pages

- [Link style](https://carbondesignsystem.com/components/link/style/)

#### 6.4.2. Token mappings

| Variant             | Mode / size / density | State    | Anatomy element | Property   | Color token           | Source section          | Confidence |
| ------------------- | --------------------- | -------- | --------------- | ---------- | --------------------- | ----------------------- | ---------- |
| Standalone / inline | Any                   | Default  | Link            | text-color | `$link-primary`       | Color                   | Documented |
| Standalone / inline | Any                   | Default  | Icon            | svg        | `$link-primary`       | Color                   | Documented |
| Standalone / inline | Any                   | Hover    | Link            | text-color | `$link-primary-hover` | Interactive state color | Documented |
| Standalone / inline | Any                   | Focus    | Link            | text-color | `$link-primary`       | Interactive state color | Documented |
| Standalone / inline | Any                   | Active   | Link            | text-color | `$text-primary`       | Interactive state color | Documented |
| Standalone / inline | Any                   | Visited  | Link            | text-color | `$link-visited`       | Interactive state color | Documented |
| Standalone / inline | Any                   | Disabled | Link            | text-color | `$text-disabled`      | Interactive state color | Documented |
| Standalone / inline | Any                   | Hover    | Icon            | svg        | `$link-primary-hover` | Interactive state color | Documented |
| Standalone / inline | Any                   | Focus    | Border          | border     | `$focus`              | Interactive state color | Documented |

### 6.5. List

#### 6.5.1. Source pages

- [List style](https://carbondesignsystem.com/components/list/style/)

#### 6.5.2. Token mappings

| Variant             | Mode / size / density | State   | Anatomy element | Property   | Color token     | Source section | Confidence |
| ------------------- | --------------------- | ------- | --------------- | ---------- | --------------- | -------------- | ---------- |
| Ordered / unordered | Any                   | Default | Item            | text-color | `$text-primary` | Color          | Documented |

### 6.6. Loading

#### 6.6.1. Source pages

- [Loading style](https://carbondesignsystem.com/components/loading/style/)

#### 6.6.2. Token mappings

| Variant      | Mode / size / density | State   | Anatomy element      | Property         | Color token     | Source section | Confidence |
| ------------ | --------------------- | ------- | -------------------- | ---------------- | --------------- | -------------- | ---------- |
| Large        | Large                 | Default | Indicator            | stroke           | `$interactive`  | Color          | Documented |
| Small        | Small                 | Default | Indicator            | stroke           | `$interactive`  | Color          | Documented |
| Small        | Small                 | Default | Indicator background | background-color | `$layer-accent` | Color          | Documented |
| Page overlay | Any                   | Default | Overlay              | background-color | `$overlay`      | Color          | Documented |

### 6.7. Toggle

#### 6.7.1. Source pages

- [Toggle style](https://carbondesignsystem.com/components/toggle/style/)

#### 6.7.2. Token mappings

| Variant         | Mode / size / density | State       | Anatomy element | Property         | Color token               | Source section          | Confidence |
| --------------- | --------------------- | ----------- | --------------- | ---------------- | ------------------------- | ----------------------- | ---------- |
| Default / small | Any                   | Default off | Background      | background-color | `$toggle-off`             | Color                   | Documented |
| Default / small | Any                   | Default off | Handle          | background-color | `$icon-on-color`          | Color                   | Documented |
| Default / small | Any                   | Default on  | Background      | background-color | `$support-success`        | Color                   | Documented |
| Default / small | Any                   | Default on  | Handle          | background-color | `$icon-on-color`          | Color                   | Documented |
| Default / small | Any                   | Default on  | Checkmark       | fill             | `$support-success`        | Color                   | Documented |
| Default / small | Any                   | Focus       | Toggle          | border           | `$focus`                  | Interactive state color | Documented |
| Default / small | Any                   | Disabled    | Background      | background-color | `$button-disabled`        | Interactive state color | Documented |
| Default / small | Any                   | Disabled    | Handle          | background-color | `$icon-on-color-disabled` | Interactive state color | Documented |
| Default / small | Any                   | Read-only   | Border          | border           | `$border-subtle`          | Interactive state color | Documented |
| Default / small | Any                   | Read-only   | Handle          | background-color | `$icon-primary`           | Interactive state color | Documented |

### 6.8. Select

#### 6.8.1. Source pages

- [Select style](https://carbondesignsystem.com/components/select/style/)

#### 6.8.2. Token mappings

| Variant         | Mode / size / density | State     | Anatomy element | Property         | Color token        | Source section     | Confidence |
| --------------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | ------------------ | ---------- |
| Default / fluid | Any                   | Default   | Field           | background       | `$field`           | Color              | Documented |
| Default / fluid | Any                   | Default   | Field           | border-bottom    | `$border-strong`   | Color              | Documented |
| Inline          | Any                   | Default   | Field           | background       | transparent        | Color              | Documented |
| Default / fluid | Any                   | Default   | Label           | text color       | `$text-secondary`  | Color              | Documented |
| Default / fluid | Any                   | Default   | Field text      | text color       | `$text-primary`    | Color              | Documented |
| Default / fluid | Any                   | Default   | Helper text     | text color       | `$text-helper`     | Color              | Documented |
| Default / fluid | Any                   | Default   | Icon            | fill             | `$icon-primary`    | Color              | Documented |
| Default / fluid | Any                   | Hover     | Field           | background-color | `$field-hover`     | Interactive states | Documented |
| Default / fluid | Any                   | Focus     | Field           | border           | `$focus`           | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Field           | border           | `$support-error`   | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Error message   | text-color       | `$text-error`      | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Error icon      | fill             | `$support-error`   | Interactive states | Documented |
| Default / fluid | Any                   | Warning   | Warning icon    | fill             | `$support-warning` | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Label           | text-color       | `$text-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Input text      | text-color       | `$text-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Chevron icon    | fill             | `$icon-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Read-only | Border          | border-bottom    | `$border-subtle`   | Interactive states | Documented |
| Default / fluid | Any                   | Read-only | Chevron icon    | fill             | `$icon-disabled`   | Interactive states | Documented |

### 6.9. Dropdown

#### 6.9.1. Source pages

- [Dropdown style](https://carbondesignsystem.com/components/dropdown/style/)

#### 6.9.2. Token mappings

| Variant         | Mode / size / density | State         | Anatomy element       | Property         | Color token           | Source section     | Confidence |
| --------------- | --------------------- | ------------- | --------------------- | ---------------- | --------------------- | ------------------ | ---------- |
| Default / fluid | Any                   | Default       | Menu option           | text-color       | `$text-secondary`     | Color              | Documented |
| Default / fluid | Any                   | Default       | Menu option           | background-color | `$layer`              | Color              | Documented |
| Default / fluid | Any                   | Focus         | Field                 | border           | `$focus`              | Interactive states | Documented |
| Default / fluid | Any                   | Hover         | Field                 | background-color | `$field-hover`        | Interactive states | Documented |
| Default / fluid | Any                   | Hover         | Menu option           | background-color | `$layer-hover`        | Interactive states | Documented |
| Default / fluid | Any                   | Hover         | Menu option           | text-color       | `$text-primary`       | Interactive states | Documented |
| Default / fluid | Any                   | Active        | Menu option           | background-color | `$layer-active`       | Interactive states | Documented |
| Multiselect     | Any                   | Selected      | Menu option           | background-color | `$layer-selected`     | Interactive states | Documented |
| Multiselect     | Any                   | Selected      | Menu option checkmark | fill             | `$icon-primary`       | Interactive states | Documented |
| Multiselect     | Any                   | Multiselected | Tag                   | background-color | `$background-inverse` | Interactive states | Documented |
| Multiselect     | Any                   | Multiselected | Tag                   | text-color       | `$text-inverse`       | Interactive states | Documented |
| Default / fluid | Any                   | Invalid       | Field                 | border           | `$support-error`      | Interactive states | Documented |
| Default / fluid | Any                   | Invalid       | Error icon            | svg              | `$support-error`      | Interactive states | Documented |
| Default / fluid | Any                   | Invalid       | Error message         | text-color       | `$text-error`         | Interactive states | Documented |
| Default / fluid | Any                   | Disabled      | Field                 | text-color       | `$text-disabled`      | Interactive states | Documented |
| Default / fluid | Any                   | Disabled      | Label                 | text-color       | `$text-disabled`      | Interactive states | Documented |
| Default / fluid | Any                   | Disabled      | Chevron icon          | svg              | `$icon-disabled`      | Interactive states | Documented |
| Default / fluid | Any                   | Read-only     | Border                | border-bottom    | `$border-subtle`      | Interactive states | Documented |
| Default / fluid | Any                   | Read-only     | Chevron icon          | svg              | `$icon-disabled`      | Interactive states | Documented |

### 6.10. Number input

#### 6.10.1. Source pages

- [Number input style](https://carbondesignsystem.com/components/number-input/style/)

#### 6.10.2. Token mappings

| Variant         | Mode / size / density | State     | Anatomy element | Property         | Color token        | Source section     | Confidence |
| --------------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | ------------------ | ---------- |
| Default / fluid | Any                   | Default   | Label           | text color       | `$text-secondary`  | Color              | Documented |
| Default / fluid | Any                   | Default   | Number text     | text color       | `$text-primary`    | Color              | Documented |
| Default / fluid | Any                   | Default   | Field           | background-color | `$field`           | Color              | Documented |
| Default / fluid | Any                   | Default   | Field           | border-bottom    | `$border-strong`   | Color              | Documented |
| Default / fluid | Any                   | Default   | Controls        | svg color        | `$icon-primary`    | Color              | Documented |
| Default / fluid | Any                   | Hover     | Controls        | background-color | `$field-hover`     | Interactive states | Documented |
| Default / fluid | Any                   | Focus     | Field           | border           | `$focus`           | Interactive states | Documented |
| Default / fluid | Any                   | Focus     | Controls        | border           | `$focus`           | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Field           | border           | `$support-error`   | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Error icon      | svg              | `$support-error`   | Interactive states | Documented |
| Default / fluid | Any                   | Invalid   | Error message   | text color       | `$text-error`      | Interactive states | Documented |
| Default / fluid | Any                   | Warning   | Warning icon    | svg              | `$support-warning` | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Label           | text color       | `$text-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Number text     | text color       | `$text-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Disabled  | Controls        | svg color        | `$icon-disabled`   | Interactive states | Documented |
| Default / fluid | Any                   | Read-only | Border          | border-bottom    | `$border-subtle`   | Interactive states | Documented |
| Default / fluid | Any                   | Read-only | Controls        | svg color        | `$icon-disabled`   | Interactive states | Documented |

### 6.11. Text input

#### 6.11.1. Source pages

- [Text input style](https://carbondesignsystem.com/components/text-input/style/)

#### 6.11.2. Token mappings

| Variant        | Mode / size / density | State   | Anatomy element  | Property         | Color token         | Source section       | Confidence |
| -------------- | --------------------- | ------- | ---------------- | ---------------- | ------------------- | -------------------- | ---------- |
| Password input | Default / fluid       | Default | Label            | text-color       | `$text-secondary`   | Password input color | Documented |
| Password input | Default / fluid       | Default | Field text       | text-color       | `$text-primary`     | Password input color | Documented |
| Password input | Default / fluid       | Default | Placeholder text | text-color       | `$text-placeholder` | Password input color | Documented |
| Password input | Default / fluid       | Default | Helper text      | text-color       | `$text-helper`      | Password input color | Documented |
| Password input | Default / fluid       | Default | Field            | background-color | `$field`            | Password input color | Documented |
| Password input | Default / fluid       | Default | Field            | border-bottom    | `$border-strong`    | Password input color | Documented |
| Password input | Default / fluid       | Default | View icon        | svg              | `$icon-primary`     | Password input color | Documented |

### 6.12. Text area

#### 6.12.1. Source pages

- [Text input style](https://carbondesignsystem.com/components/text-input/style/)

#### 6.12.2. Token mappings

| Variant         | Mode / size / density | State   | Anatomy element  | Property         | Color token         | Source section  | Confidence |
| --------------- | --------------------- | ------- | ---------------- | ---------------- | ------------------- | --------------- | ---------- |
| Default / fluid | Default               | Default | Field text       | text-color       | `$text-primary`     | Text area color | Documented |
| Default / fluid | Default               | Default | Placeholder text | text-color       | `$text-placeholder` | Text area color | Documented |
| Default / fluid | Default               | Default | Field            | background-color | `$field`            | Text area color | Documented |
| Default / fluid | Default               | Default | Field            | border-bottom    | `$border-strong`    | Text area color | Documented |

### 6.13. Text input / Text area

#### 6.13.1. Source pages

- [Text input style](https://carbondesignsystem.com/components/text-input/style/)

#### 6.13.2. Token mappings

| Variant         | Mode / size / density | State       | Anatomy element | Property      | Color token         | Source section | Confidence |
| --------------- | --------------------- | ----------- | --------------- | ------------- | ------------------- | -------------- | ---------- |
| Default / fluid | Any                   | AI presence | Gradient start  | background    | `$ai-aura-start-sm` | AI presence    | Documented |
| Default / fluid | Any                   | AI presence | Gradient stop   | background    | `$ai-aura-stop`     | AI presence    | Documented |
| Default / fluid | Any                   | AI presence | Field           | border-bottom | `$ai-border-strong` | AI presence    | Documented |

### 6.14. Date picker

#### 6.14.1. Source pages

- [Date picker style](https://carbondesignsystem.com/components/date-picker/style/)

#### 6.14.2. Token mappings

| Variant       | Mode / size / density | State    | Anatomy element | Property         | Color token         | Source section          | Confidence |
| ------------- | --------------------- | -------- | --------------- | ---------------- | ------------------- | ----------------------- | ---------- |
| Calendar menu | Any                   | Default  | Calendar        | background-color | `$layer`            | Calendar menu color     | Documented |
| Calendar menu | Any                   | Default  | Today           | text-color       | `$link-01`          | Calendar menu color     | Documented |
| Calendar menu | Any                   | Hover    | Day             | background-color | `$layer-hover`      | Interactive state color | Documented |
| Calendar menu | Any                   | Focus    | Day             | border           | `$focus`            | Interactive state color | Documented |
| Calendar menu | Any                   | Disabled | Day             | text-color       | `$text-disabled`    | Interactive state color | Documented |
| Calendar menu | Any                   | Selected | Day             | text-color       | `$text-on-color`    | Interactive state color | Documented |
| Calendar menu | Any                   | Selected | Day             | background-color | `$background-brand` | Interactive state color | Documented |
| Calendar menu | Any                   | In range | Day             | text-color       | `$text-primary`     | Interactive state color | Documented |
| Calendar menu | Any                   | In range | Day             | background-color | `$highlight`        | Interactive state color | Documented |

### 6.15. Time picker

#### 6.15.1. Source pages

- [Date picker style](https://carbondesignsystem.com/components/date-picker/style/)

#### 6.15.2. Token mappings

| Variant         | Mode / size / density | State    | Anatomy element | Property         | Color token       | Source section          | Confidence |
| --------------- | --------------------- | -------- | --------------- | ---------------- | ----------------- | ----------------------- | ---------- |
| Default / fluid | Default               | Default  | Label           | text-color       | `$text-secondary` | Time picker color       | Documented |
| Default / fluid | Default               | Default  | Field           | background-color | `$field`          | Time picker color       | Documented |
| Default / fluid | Default               | Default  | Field           | border-bottom    | `$border-strong`  | Time picker color       | Documented |
| Default / fluid | Default               | Default  | Chevron icon    | svg              | `$icon-primary`   | Time picker color       | Documented |
| Default / fluid | Any                   | Focus    | Field           | border           | `$focus`          | Interactive state color | Documented |
| Default / fluid | Any                   | Error    | Field           | border           | `$support-error`  | Interactive state color | Documented |
| Default / fluid | Any                   | Error    | Error message   | text-color       | `$text-error`     | Interactive state color | Documented |
| Default / fluid | Any                   | Disabled | Label           | text-color       | `$text-disabled`  | Interactive state color | Documented |
| Default / fluid | Any                   | Disabled | Chevron icon    | svg              | `$icon-disabled`  | Interactive state color | Documented |

### 6.16. Date picker / Time picker

#### 6.16.1. Source pages

- [Date picker style](https://carbondesignsystem.com/components/date-picker/style/)

#### 6.16.2. Token mappings

| Variant         | Mode / size / density | State       | Anatomy element | Property      | Color token         | Source section | Confidence |
| --------------- | --------------------- | ----------- | --------------- | ------------- | ------------------- | -------------- | ---------- |
| Default / fluid | Any                   | AI presence | Gradient start  | background    | `$ai-aura-start-sm` | AI presence    | Documented |
| Default / fluid | Any                   | AI presence | Gradient stop   | background    | `$ai-aura-stop`     | AI presence    | Documented |
| Default / fluid | Any                   | AI presence | Field           | border-bottom | `$ai-border-strong` | AI presence    | Documented |

### 6.17. Data table

#### 6.17.1. Source pages

- [Data table style](https://carbondesignsystem.com/components/data-table/style/)

#### 6.17.2. Token mappings

| Variant     | Mode / size / density | State   | Anatomy element     | Property         | Color token         | Source section                 | Confidence |
| ----------- | --------------------- | ------- | ------------------- | ---------------- | ------------------- | ------------------------------ | ---------- |
| AI presence | Entire table          | Default | Table background    | background-color | `$layer`            | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Table surface       | box-shadow       | `$ai-drop-shadow`   | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Table surface       | inner-shadow     | `$ai-inner-shadow`  | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Gradient background | start            | `$ai-aura-start-sm` | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Gradient background | stop             | `$ai-aura-stop`     | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Gradient border     | top              | `$ai-border-start`  | AI presence — Entire table     | Documented |
| AI presence | Entire table          | Default | Gradient border     | bottom           | `$ai-border-end`    | AI presence — Entire table     | Documented |
| AI presence | Rows and columns      | Default | Gradient background | start            | `$ai-aura-start-sm` | AI presence — Rows and columns | Documented |
| AI presence | Rows and columns      | Default | Gradient background | stop             | `$ai-aura-stop`     | AI presence — Rows and columns | Documented |
| AI presence | Rows and columns      | Default | Gradient border     | left, top        | `$ai-border-strong` | AI presence — Rows and columns | Documented |

### 6.18. Form

#### 6.18.1. Source pages

- [Form style](https://carbondesignsystem.com/components/form/style/)

#### 6.18.2. Token mappings

| Variant     | Mode / size / density | State   | Anatomy element     | Property         | Color token         | Source section | Confidence |
| ----------- | --------------------- | ------- | ------------------- | ---------------- | ------------------- | -------------- | ---------- |
| AI presence | Form surface          | Default | Form background     | background-color | `$layer`            | AI presence    | Documented |
| AI presence | Form surface          | Default | Form surface        | box-shadow       | `$ai-drop-shadow`   | AI presence    | Documented |
| AI presence | Form surface          | Default | Form surface        | inner-shadow     | `$ai-inner-shadow`  | AI presence    | Documented |
| AI presence | Form surface          | Default | Gradient background | start            | `$ai-aura-start-sm` | AI presence    | Documented |
| AI presence | Form surface          | Default | Gradient background | stop             | `$ai-aura-stop`     | AI presence    | Documented |
| AI presence | Form surface          | Default | Gradient border     | top              | `$ai-border-start`  | AI presence    | Documented |
| AI presence | Form surface          | Default | Gradient border     | bottom           | `$ai-border-end`    | AI presence    | Documented |

## 7. Pattern token mappings

Pattern token rows belong in the owning Login App Pattern API when they describe composition-level status, read-only, blocked, empty, loading, or cross-component behavior.

### 7.1. Read-only states

#### 7.1.1. Source pages

- [Read-only states pattern](https://carbondesignsystem.com/patterns/read-only-states-pattern/)

#### 7.1.2. Token mappings

| Variant                   | Mode / size / density | State     | Anatomy element              | Property    | Color token      | Source section            | Confidence |
| ------------------------- | --------------------- | --------- | ---------------------------- | ----------- | ---------------- | ------------------------- | ---------- |
| Read-only signifier icons | Any                   | Read-only | Chevron/close/calendar icons | color token | `$icon-disabled` | Component icon signifiers | Documented |

### 7.2. Status indicators

#### 7.2.1. Source pages

- [Status indicators pattern](https://carbondesignsystem.com/patterns/status-indicator-pattern/)

#### 7.2.2. Token mappings

| Variant         | Mode / size / density | State                                           | Anatomy element      | Property | Color token                                | Source section           | Confidence |
| --------------- | --------------------- | ----------------------------------------------- | -------------------- | -------- | ------------------------------------------ | ------------------------ | ---------- |
| Icon indicator  | Any                   | Failed                                          | Status indicator     | token    | `$status-red`                              | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Caution major                                   | Status indicator     | token    | `$status-orange`                           | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Caution major                                   | Status label pairing | token    | `$black`                                   | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Caution minor                                   | Status indicator     | token    | `$status-yellow`                           | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Caution minor                                   | Status label pairing | token    | `$black`                                   | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Undefined                                       | Status indicator     | token    | `$status-purple`                           | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Succeeded                                       | Status indicator     | token    | `$status-green`                            | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Normal / In progress / Incomplete / Informative | Status indicator     | token    | `$status-blue`                             | Icon indicator statuses  | Documented |
| Icon indicator  | Any                   | Not started / Pending / Unknown                 | Status indicator     | token    | `$status-gray`                             | Icon indicator statuses  | Documented |
| Shape indicator | Any                   | Medium                                          | Shape indicator      | token    | `$status-orange`, `$status-orange-outline` | Shape indicator statuses | Documented |
| Shape indicator | Any                   | Low / Cautious                                  | Shape indicator      | token    | `$status-yellow`, `$status-yellow-outline` | Shape indicator statuses | Documented |

## 8. Coverage and gaps report

### 8.1. Pages checked by the research pass

The original research pass checked Carbon color and theme pages, the components overview and feature-flag pages, component style pages for Button, Checkbox, Link, List, Loading, Toggle, Select, Dropdown, Number input, Text input, Date picker, Data table, Tag, and Form, and pattern pages for Loading, Read-only states, Status indicators, Login, Forms, Notifications, Search, Empty states, Fluid styles, and Common actions.

### 8.2. Pages with the clearest explicit color-token mappings

- Button
- Checkbox
- Link
- List
- Loading
- Toggle
- Select
- Dropdown
- Number input
- Text input
- Date picker
- Data table
- Form
- Status indicators pattern
- Read-only states pattern

### 8.3. Known extraction gaps

| Gap                                                                 | Disposition                                             | Recommended next step                                                                   |
| ------------------------------------------------------------------- | ------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| Content switcher component token family                             | Documented family, incomplete exact-name retrieval      | Verify against current Carbon package token modules and current style docs.             |
| Notification component token family                                 | Documented family, incomplete exact-name retrieval      | Verify against current Carbon package token modules and current style docs.             |
| Full Tag component-token inventory                                  | Documented family, incomplete exact-name retrieval      | Re-run targeted extraction against Tag style docs and package token modules.            |
| AI token catalog                                                    | Public docs plus lower-confidence official GitHub names | Verify exact names against current public docs and package exports before app adoption. |
| Data table and Tag doc/source mismatches noted by original research | Documentation quality caveat                            | Validate high-risk mappings against package output before codifying.                    |

## 9. Login App conversion guidance

### 9.1. Convert into Color Element roles

Promote a Carbon token idea into `docs/02-standards/ui/elements/color.md` only when the role is reusable across components and patterns.

Good Color Element candidates:

- Background and layer roles.
- Text roles.
- Border roles.
- Link roles.
- Icon roles.
- Support/status roles.
- Focus roles.
- Overlay and skeleton roles.
- Contextual field/layer aliases if Login App needs layer-aware behavior.

### 9.2. Convert into Component standards

Keep a mapping inside the owning Component API when it describes component anatomy, variants, or local state behavior.

Examples:

- Button variant/state colors.
- Select field, label, helper, chevron, disabled, read-only, error, and warning colors.
- Dropdown menu option hover/active/selected colors.
- Number input controls, field, label, validation, and disabled colors.
- Loading spinner, overlay, and skeleton colors.

### 9.3. Convert into Pattern standards

Keep a mapping inside the owning Pattern API when it describes cross-component placement, escalation, status, read-only, blocked, empty, or workflow behavior.

Examples:

- Read-only signifier icon behavior.
- Status indicator pattern colors.
- Form-level validation summaries.
- Data/content empty or no-results state color roles.
- AI presence across a full form/table region.

### 9.4. Do not copy blindly

- Do not use Carbon token names directly in app CSS unless the Login App Color Element standard adopts that alias.
- Do not use direct Carbon classes such as `cds--*` or `bx--*`.
- Do not promote component-scoped Carbon tokens into global app tokens without a documented app need.
- Do not use AI tokens outside AI-labeled, AI-owned, or AI-gated UI.
- Do not convert source-inferred or incomplete rows into hard standards without package verification.

## 10. Related Login App standards

| API                       | Path                                          |
| ------------------------- | --------------------------------------------- |
| Color Element standard    | `docs/02-standards/ui/elements/color.md`      |
| Themes Element standard   | `docs/02-standards/ui/elements/themes.md`     |
| Icons Element standard    | `docs/02-standards/ui/elements/icons.md`      |
| Component Standards Index | `docs/02-standards/ui/components/index.md`    |
| Pattern Standards Index   | `docs/02-standards/ui/patterns/index.md`      |
| Carbon source notes       | `docs/02-standards/ui/carbon-source-notes.md` |

## 11. References

- [Carbon color tokens](https://carbondesignsystem.com/elements/color/tokens/)
- [Carbon color overview](https://carbondesignsystem.com/elements/color/overview/)
- [Carbon themes overview](https://carbondesignsystem.com/elements/themes/overview/)
- [Carbon components overview](https://carbondesignsystem.com/components/overview/components/)
- [Carbon patterns overview](https://carbondesignsystem.com/patterns/overview/)
- [Carbon source notes](../carbon-source-notes.md)
- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)