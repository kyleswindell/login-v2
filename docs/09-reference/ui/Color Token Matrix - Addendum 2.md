---
title: Carbon Color Token Gap Cleanup Addendum
slug: carbon-color-token-gap-cleanup-addendum
status: support-reference
api_layer: Foundation Element Support Reference
canonical_doc: docs/02-standards/ui/elements/color-carbon-token-gap-cleanup-addendum.md
related_inventory: docs/02-standards/ui/elements/color-carbon-token-inventory.md
related_addendum: docs/02-standards/ui/elements/color-carbon-token-addendum.md
source_scope: official-carbon-docs-and-source
---

# Carbon Color Token Gap Cleanup Addendum
- [1. Reference status and scope](#1-reference-status-and-scope)
- [2. Reviewed gap list](#2-reviewed-gap-list)
- [3. Resolution summary](#3-resolution-summary)
- [4. Tag gap cleanup](#4-tag-gap-cleanup)
  - [4.1 Public documentation finding](#41-public-documentation-finding)
  - [4.2 Public-doc Tag mappings](#42-public-doc-tag-mappings)
  - [4.3 Source-inferred Tag component-token family](#43-source-inferred-tag-component-token-family)
  - [4.4 Tag merge guidance](#44-tag-merge-guidance)
- [5. Content switcher gap cleanup](#5-content-switcher-gap-cleanup)
  - [5.1 Public documentation finding](#51-public-documentation-finding)
  - [5.2 Content switcher mappings](#52-content-switcher-mappings)
  - [5.3 Source-confirmed Content switcher component tokens](#53-source-confirmed-content-switcher-component-tokens)
- [6. AI-token catalog cleanup](#6-ai-token-catalog-cleanup)
  - [6.1 Public documentation finding](#61-public-documentation-finding)
  - [6.2 Public/style-page verified AI tokens](#62-publicstyle-page-verified-ai-tokens)
  - [6.3 GitHub/design-kit documented AI tokens](#63-githubdesign-kit-documented-ai-tokens)
  - [6.4 Source-inferred AI skeleton tokens](#64-source-inferred-ai-skeleton-tokens)
  - [6.5 AI merge guidance](#65-ai-merge-guidance)
- [7. UI shell and side nav cleanup](#7-ui-shell-and-side-nav-cleanup)
  - [7.1 Current public documentation finding](#71-current-public-documentation-finding)
  - [7.2 Legacy style documentation finding](#72-legacy-style-documentation-finding)
  - [7.3 UI shell / side nav disposition](#73-ui-shell--side-nav-disposition)
  - [7.4 UI shell merge guidance](#74-ui-shell-merge-guidance)
- [8. Skeleton states cleanup](#8-skeleton-states-cleanup)
  - [8.1 Public documentation finding](#81-public-documentation-finding)
  - [8.2 Source-inferred skeleton rows](#82-source-inferred-skeleton-rows)
  - [8.3 Skeleton merge guidance](#83-skeleton-merge-guidance)
- [9. Slider row-level mapping addendum](#9-slider-row-level-mapping-addendum)
- [10. File uploader row-level mapping addendum](#10-file-uploader-row-level-mapping-addendum)
  - [10.1 File uploader documented rows](#101-file-uploader-documented-rows)
  - [10.2 File uploader merge guidance](#102-file-uploader-merge-guidance)
- [11. Updated remaining gaps after manual review](#11-updated-remaining-gaps-after-manual-review)
- [12. Merge guidance](#12-merge-guidance)
  - [12.1 Add to master token catalog](#121-add-to-master-token-catalog)
  - [12.2 Add to component mapping inventory](#122-add-to-component-mapping-inventory)
  - [12.3 Add to element/support sections](#123-add-to-elementsupport-sections)
  - [12.4 Do not merge as app rules without review](#124-do-not-merge-as-app-rules-without-review)
- [13. Source index](#13-source-index)

## 1. Reference status and scope

This addendum manually reviews the remaining unresolved Carbon color-token gaps left after the first inventory and the first follow-up addendum.

This file is a **support reference** for Login App 2.0 color governance. It is not the canonical Login App Color Element API. Carbon token names, Carbon source paths, and Carbon class names appear here only as third-party evidence and must not be copied directly into Login App implementation standards without an app-owned decision.

## 2. Reviewed gap list

The prior addendum preserved the following unresolved or contradictory areas:

- Tag component-token family.
- Content switcher component-token family.
- Full AI-token catalog.
- UI shell and side nav color-token coverage.
- Skeleton state tokens.
- Slider row-level mappings.
- File uploader row-level mappings.

This addendum updates each area with the most defensible current disposition.

## 3. Resolution summary

| Gap                   | Updated disposition                                         | Result                                                                                                                                                                                 |
| --------------------- | ----------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Tag                   | Partial public docs + official source-inferred token family | Public docs give variant rules and core-token exceptions. Official source exposes component-token names for tag color families.                                                        |
| Content switcher      | Public docs documented + source-confirmed                   | Low-contrast component tokens and high-contrast core-token mappings are documented. Official source confirms the component-token names.                                                |
| Full AI-token catalog | Partial public docs + GitHub/source evidence                | Public docs confirm AI-token namespace and several style-page mappings. A stable public master list still was not available from the parsed docs.                                      |
| UI shell / side nav   | No current public row-level color-token table found         | Current pages document shell structure/usage. Legacy v10 style docs state UI shell did not use Carbon theme tokens and used palette values instead. Treat as historical guidance only. |
| Skeleton states       | Core tokens confirmed + source-inferred AI skeleton utility | Public docs confirm `$skeleton-element` and `$skeleton-background`. Source shows AI skeleton utility tokens. No standalone public skeleton style table was found.                      |
| Slider                | Row-level mappings added                                    | The prior addendum coverage table marked Slider as explicit but omitted rows. Rows are added here.                                                                                     |
| File uploader         | Row-level mappings added                                    | The prior addendum coverage table marked File uploader as explicit but omitted rows. Rows are added here, including documentation anomalies.                                           |

## 4. Tag gap cleanup

### 4.1 Public documentation finding

Carbon’s Tag style page states that **read-only**, **dismissible**, and **operational** tag variants use component tokens. It also states that **selectable** tags use core tokens only, and that high-contrast and outline styles use core tokens instead of component tokens.

The current public Tag style page does not expose every all-color component-token name as a row-level table in the accessible text. It does expose exact core-token mappings for high-contrast, outline, focus, disabled, and selectable states.

Source:

- `https://carbondesignsystem.com/components/tag/style/`

### 4.2 Public-doc Tag mappings

| Area      | Component / Pattern / Element | Variant     | Mode / Size / Density | State    | Anatomy element          | Property         | Color token                | Source page      | Source section          | Confidence          | Notes                                                                                                |
| --------- | ----------------------------- | ----------- | --------------------- | -------- | ------------------------ | ---------------- | -------------------------- | ---------------- | ----------------------- | ------------------- | ---------------------------------------------------------------------------------------------------- |
| Component | Tag                           | Read-only   | All colors            | Default  | Text / icon / background | token family     | See component token family | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens but do not expose every exact all-color token row.             |
| Component | Tag                           | Read-only   | High contrast         | Default  | Text                     | text-color       | `$text-inverse`            | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | High contrast         | Default  | Icon                     | svg              | `$icon-color`              | Carbon Tag style | Color                   | Documented anomaly  | Public docs show `$icon-color`; verify against source before standardizing.                          |
| Component | Tag                           | Read-only   | High contrast         | Default  | Border                   | border           | `$border-inverse`          | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | High contrast         | Default  | Background               | background-color | `$background-inverse`      | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | Outline               | Default  | Text                     | text-color       | `$text-primary`            | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | Outline               | Default  | Icon                     | svg              | `$icon-primary`            | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | Outline               | Default  | Border                   | border           | `$border-inverse`          | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Read-only   | Outline               | Default  | Background               | background-color | `$background`              | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Component | Tag                           | Dismissible | All colors            | Default  | Background               | background-color | See component token family | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens but do not expose every exact all-color token row.             |
| Component | Tag                           | Dismissible | All colors            | Hover    | Background               | background-color | See component token family | Carbon Tag style | Interactive state color | Documented guidance | Public docs point to component hover tokens.                                                         |
| Component | Tag                           | Dismissible | All colors            | Focus    | Container                | border           | `$focus`                   | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Component | Tag                           | Dismissible | All colors            | Disabled | Text                     | text-color       | `$text-disabled`           | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Component | Tag                           | Dismissible | All colors            | Disabled | Background               | background-color | `$layer`                   | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Component | Tag                           | Dismissible | High contrast         | Hover    | Background               | background-color | `$background-hover`        | Carbon Tag style | Interactive state color | Documented          | High contrast exception.                                                                             |
| Component | Tag                           | Dismissible | High contrast         | Focus    | Container                | border           | `$focus`                   | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Component | Tag                           | Dismissible | Outline               | Hover    | Background               | background-color | `$background-hover`        | Carbon Tag style | Interactive state color | Documented          | Outline exception.                                                                                   |
| Component | Tag                           | Dismissible | Outline               | Disabled | Text                     | text-color       | `$text-disabled`           | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Component | Tag                           | Dismissible | Outline               | Disabled | Border                   | border           | `$border-disabled`         | Carbon Tag style | Interactive state color | Documented          | Core disabled border.                                                                                |
| Component | Tag                           | Dismissible | Outline               | Disabled | Background               | background-color | `$background-disabled`     | Carbon Tag style | Interactive state color | Documented          | Core disabled background.                                                                            |
| Component | Tag                           | Operational | All colors            | Default  | Text / icon / background | token family     | See component token family | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens.                                                               |
| Component | Tag                           | Operational | All colors            | Hover    | Background               | background-color | See component token family | Carbon Tag style | Interactive state color | Documented guidance | Public docs point to component hover tokens.                                                         |
| Component | Tag                           | Operational | All colors            | Focus    | Container                | border           | `$focus`                   | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Component | Tag                           | Operational | All colors            | Disabled | Text                     | text-color       | `$text-disabled`           | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Component | Tag                           | Operational | All colors            | Disabled | Border                   | border           | `$border-disabled`         | Carbon Tag style | Interactive state color | Documented          | Core disabled border.                                                                                |
| Component | Tag                           | Operational | All colors            | Disabled | Background               | background-color | `$layer`                   | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Component | Tag                           | Selectable  | Standard              | Default  | Text                     | text-color       | `$text-primary`            | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Component | Tag                           | Selectable  | Standard              | Default  | Icon                     | svg              | `$icon-primary`            | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Component | Tag                           | Selectable  | Standard              | Default  | Border                   | border           | `$border-inverse`          | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Component | Tag                           | Selectable  | Standard              | Default  | Background               | background-color | `$layer`                   | Carbon Tag style | Color                   | Documented          | Contextual layer token.                                                                              |
| Component | Tag                           | Selectable  | Standard              | Hover    | Background               | background-color | `$layer-hover`             | Carbon Tag style | Interactive state color | Documented          | Contextual layer hover.                                                                              |
| Component | Tag                           | Selectable  | Standard              | Focus    | Container                | border           | `$focus`                   | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Component | Tag                           | Selectable  | Standard              | Selected | Text                     | text-color       | `$text-inverse`            | Carbon Tag style | Interactive state color | Documented          | Selected state.                                                                                      |
| Component | Tag                           | Selectable  | Standard              | Selected | Background               | background-color | `$background-inverse`      | Carbon Tag style | Interactive state color | Documented          | Selected state.                                                                                      |
| Component | Tag                           | Selectable  | Standard              | Disabled | Text                     | text-color       | `$text-disabled`           | Carbon Tag style | Interactive state color | Documented          | Disabled state.                                                                                      |
| Component | Tag                           | Selectable  | Standard              | Disabled | Border                   | border           | `$border-disabled`         | Carbon Tag style | Interactive state color | Documented          | Disabled state.                                                                                      |
| Component | Tag                           | Selectable  | Standard              | Disabled | Background               | background-color | `$layer`                   | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Component | Tag                           | AI presence | All variants          | Default  | AI label                 | text/icon color  | Match tag text color       | Carbon Tag style | AI presence             | Documented guidance | No separate Tag AI color token mapping; AI label size is small and padding-right uses `$spacing-02`. |

### 4.3 Source-inferred Tag component-token family

Official Carbon source exposes the component-token family names for all-color tags. These names should be treated as **Source-inferred** until confirmed in a stable public documentation table.

Source:

- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_tag.scss`

| Token family        | Token names                                                                                                                                                                                                                                                   | Scope                  | Confidence      |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------- | --------------- |
| Tag background      | `$tag-background-red`, `$tag-background-magenta`, `$tag-background-purple`, `$tag-background-blue`, `$tag-background-cyan`, `$tag-background-teal`, `$tag-background-green`, `$tag-background-gray`, `$tag-background-cool-gray`, `$tag-background-warm-gray` | Tag component-specific | Source-inferred |
| Tag text/icon color | `$tag-color-red`, `$tag-color-magenta`, `$tag-color-purple`, `$tag-color-blue`, `$tag-color-cyan`, `$tag-color-teal`, `$tag-color-green`, `$tag-color-gray`, `$tag-color-cool-gray`, `$tag-color-warm-gray`                                                   | Tag component-specific | Source-inferred |
| Tag hover           | `$tag-hover-red`, `$tag-hover-magenta`, `$tag-hover-purple`, `$tag-hover-blue`, `$tag-hover-cyan`, `$tag-hover-teal`, `$tag-hover-green`, `$tag-hover-gray`, `$tag-hover-cool-gray`, `$tag-hover-warm-gray`                                                   | Tag component-specific | Source-inferred |
| Tag border          | `$tag-border-red`, `$tag-border-magenta`, `$tag-border-purple`, `$tag-border-blue`, `$tag-border-cyan`, `$tag-border-teal`, `$tag-border-green`, `$tag-border-gray`, `$tag-border-cool-gray`, `$tag-border-warm-gray`                                         | Tag component-specific | Source-inferred |

### 4.4 Tag merge guidance

Keep public-doc rows and source-inferred component-token lists separate.

Do not promote Tag component tokens into the Login App Color Element standard as global tokens. If Login App needs tag color families, map them inside the Tag Component standard.

## 5. Content switcher gap cleanup

### 5.1 Public documentation finding

The Content switcher style page exposes both high-contrast mappings using core tokens and low-contrast mappings using Content switcher component tokens. The official source confirms the low-contrast component token names.

Sources:

- `https://carbondesignsystem.com/components/content-switcher/style/`
- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_content-switcher.scss`

### 5.2 Content switcher mappings

| Area      | Component / Pattern / Element | Variant       | Mode / Size / Density | State               | Anatomy element | Property         | Color token                          | Source page                   | Source section                        | Confidence         | Notes                                                                                     |
| --------- | ----------------------------- | ------------- | --------------------- | ------------------- | --------------- | ---------------- | ------------------------------------ | ----------------------------- | ------------------------------------- | ------------------ | ----------------------------------------------------------------------------------------- |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected          | Container       | background-color | transparent                          | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected          | Label           | text-color       | `$text-secondary`                    | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected          | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected          | Container       | border           | `$border-inverse`                    | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected          | Divider         | border           | `$border-subtle`                     | Carbon Content switcher style | High contrast color                   | Documented         | Contextual token.                                                                         |
| Component | Content switcher              | High contrast | Default / Icon        | Selected            | Container       | background-color | `$layer-selected-inverse`            | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Selected            | Label           | text-color       | `$text-inverse`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Selected            | Icon            | svg              | `$icon-inverse`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Hover unselected    | Container       | background-color | `$background-hover`                  | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Hover unselected    | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Hover unselected    | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Focus unselected    | Container       | border           | `$focus`                             | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled unselected | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled unselected | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled unselected | Border          | border           | `$border-disabled`                   | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Focus selected      | Container       | inner-border     | `$focus-inset`                       | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled selected   | Container       | background-color | `$layer-selected-disabled`           | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled selected   | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled selected   | Icon            | svg              | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented anomaly | Public docs use `$text-disabled` for selected disabled icon. Verify before standardizing. |
| Component | Content switcher              | Low contrast  | Default / Icon        | Unselected          | Container       | background-color | `$content-switcher-background`       | Carbon Content switcher style | Low contrast color                    | Documented         | Component token.                                                                          |
| Component | Content switcher              | Low contrast  | Default / Icon        | Unselected          | Label           | text-color       | `$text-secondary`                    | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Unselected          | Icon            | svg              | `$icon-secondary`                    | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Unselected          | Border          | border           | `$border-strong`                     | Carbon Content switcher style | Low contrast color                    | Documented         | Contextual token.                                                                         |
| Component | Content switcher              | Low contrast  | Default / Icon        | Unselected          | Divider         | border           | `$border-strong`                     | Carbon Content switcher style | Low contrast color                    | Documented         | Contextual token.                                                                         |
| Component | Content switcher              | Low contrast  | Default / Icon        | Selected            | Container       | background-color | `$content-switcher-selected`         | Carbon Content switcher style | Low contrast color                    | Documented         | Component token.                                                                          |
| Component | Content switcher              | Low contrast  | Default / Icon        | Selected            | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Selected            | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Hover unselected    | Container       | background-color | `$content-switcher-background-hover` | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Component | Content switcher              | Low contrast  | Default / Icon        | Hover unselected    | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Hover unselected    | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Focus               | Container       | border           | `$focus`                             | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled unselected | Container       | background-color | `$content-switcher-background`       | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled unselected | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled unselected | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled selected   | Container       | background-color | `$content-switcher-selected`         | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled selected   | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Component | Content switcher              | Low contrast  | Default / Icon        | Disabled selected   | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |

### 5.3 Source-confirmed Content switcher component tokens

| Token                                | Scope                               | Confidence                    | Source                                                |
| ------------------------------------ | ----------------------------------- | ----------------------------- | ----------------------------------------------------- |
| `$content-switcher-background`       | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |
| `$content-switcher-background-hover` | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |
| `$content-switcher-selected`         | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |

## 6. AI-token catalog cleanup

### 6.1 Public documentation finding

Carbon’s public token page confirms that AI tokens exist inside the main Carbon themes and should only be used for custom AI components, variants, or instances. The parsed public docs expose the section families **General AI**, **Chat**, and **Chat button**, but they do not expose a clean complete machine-readable token list in the retrieved text.

This addendum therefore separates:

- **Public/style-page verified AI tokens**.
- **GitHub/design-kit documented AI tokens**.
- **Source-inferred AI skeleton tokens**.

### 6.2 Public/style-page verified AI tokens

| Token                    | Source family          | Where documented                                                                      | Confidence |
| ------------------------ | ---------------------- | ------------------------------------------------------------------------------------- | ---------- |
| `$ai-aura-start-sm`      | AI presence            | Text input, Number input, Dropdown, Select, Date/Time picker, Modal, Data table       | Documented |
| `$ai-aura-stop`          | AI presence            | Text input, Number input, Dropdown, Select, Date/Time picker, Modal, Data table       | Documented |
| `$ai-border-strong`      | AI presence            | Text input, Number input, Dropdown, Select, Date/Time picker, Data table rows/columns | Documented |
| `$ai-drop-shadow`        | AI presence            | Modal, Data table, Tile                                                               | Documented |
| `$ai-inner-shadow`       | AI presence            | Modal, Data table, Tile                                                               | Documented |
| `$ai-overlay`            | AI presence            | Modal                                                                                 | Documented |
| `$ai-border-start`       | AI presence / AI label | Modal, Data table, Tile, AI label explainability popover                              | Documented |
| `$ai-border-end`         | AI presence / AI label | Modal, AI label explainability popover                                                | Documented |
| `$ai-aura-start`         | AI presence / AI label | Tile, AI label explainability popover                                                 | Documented |
| `$ai-aura-end`           | AI label               | AI label explainability popover                                                       | Documented |
| `$ai-popover-background` | AI label               | AI label explainability popover                                                       | Documented |
| `$ai-border-stop`        | AI presence            | Tile                                                                                  | Documented |

### 6.3 GitHub/design-kit documented AI tokens

The following tokens appear in official Carbon design-kit issue material or source-adjacent work but should remain lower confidence until verified in current public docs or package token source.

| Token                         | Confidence                                | Notes                                                 |
| ----------------------------- | ----------------------------------------- | ----------------------------------------------------- |
| `$ai-inner-shadow`            | GitHub-documented / public-style verified | Also appears in public component style mappings.      |
| `$ai-aura-start`              | GitHub-documented / public-style verified | Also appears in Tile and AI label mappings.           |
| `$ai-border-start`            | GitHub-documented / public-style verified | Also appears in public component style mappings.      |
| `$ai-border-end`              | GitHub-documented / public-style verified | Also appears in public component style mappings.      |
| `$ai-drop-shadow`             | GitHub-documented / public-style verified | Also appears in public component style mappings.      |
| `$ai-aura-hover-start`        | GitHub-documented                         | Not confirmed in the public style rows reviewed here. |
| `$ai-overlay`                 | GitHub-documented / public-style verified | Also appears in Modal AI mappings.                    |
| `$ai-popover-background`      | GitHub-documented / public-style verified | Also appears in AI label mapping.                     |
| `$ai-popover-shadow-outer-01` | GitHub-documented                         | Not confirmed in public style rows reviewed here.     |
| `$ai-popover-shadow-outer-02` | GitHub-documented                         | Not confirmed in public style rows reviewed here.     |

### 6.4 Source-inferred AI skeleton tokens

Official source for AI skeleton styles references AI skeleton utility tokens. These should remain **Source-inferred** unless added to the public token page or style pages.

| Token / source reference         | Scope       | Confidence      | Notes                                                                              |
| -------------------------------- | ----------- | --------------- | ---------------------------------------------------------------------------------- |
| `$ai-skeleton-background`        | AI skeleton | Source-inferred | Referenced by AI skeleton source.                                                  |
| `ai-skeleton-element-background` | AI skeleton | Source-inferred | Used by source utility to render AI skeleton element gradient/background behavior. |

### 6.5 AI merge guidance

Do not merge `$ai-*` tokens into the normal Login App Color Element token set. Keep them in an AI-only namespace or quarantine section until Login App has an approved AI component/pattern standard.

## 7. UI shell and side nav cleanup

### 7.1 Current public documentation finding

Current Carbon UI shell pages document the role and structure of the shell:

- Header.
- Left panel.
- Right panel.
- Switcher/right-panel behavior.

The current public pages reviewed here did not expose row-level color-token style tables for UI shell or side nav.

Sources:

- `https://carbondesignsystem.com/components/UI-shell-header/usage/`
- `https://carbondesignsystem.com/components/UI-shell-left-panel/usage/`
- `https://carbondesignsystem.com/components/UI-shell-right-panel/usage/`

### 7.2 Legacy style documentation finding

Legacy v10 UI shell left-panel style documentation explicitly states that UI shell did not use Carbon theme tokens at that time and instead used IBM Design Language palette values. This is useful historical context, but it is not a current token mapping.

Source:

- `https://v10.carbondesignsystem.com/components/UI-shell-left-panel/style/`

### 7.3 UI shell / side nav disposition

| Family               | Current-doc result                           | Legacy/source result                                                             | Updated disposition                                                                         |
| -------------------- | -------------------------------------------- | -------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| UI shell header      | No row-level current color-token table found | Current usage docs explain shell structure and header role                       | No current token mappings extracted. Keep as unresolved / guidance-only.                    |
| UI shell left panel  | No row-level current color-token table found | Legacy v10 says UI shell did not use Carbon theme tokens and used palette values | Do not convert legacy palette rows into token mappings.                                     |
| UI shell right panel | No row-level current color-token table found | Current usage docs explain right-panel/switcher behavior                         | No current token mappings extracted. Keep as unresolved / guidance-only.                    |
| Side nav             | No standalone current style page resolved    | Current source tree contains side-nav source under UI shell package              | Source follow-up could inspect implementation, but no public-doc mapping is confirmed here. |

### 7.4 UI shell merge guidance

Do not add UI shell or side-nav color mappings to the confirmed mapping table unless a current public style table or official source token usage is reviewed and marked as Source-inferred.

For Login App, shell/navigation color should remain Pattern-owned and app-defined.

## 8. Skeleton states cleanup

### 8.1 Public documentation finding

Carbon’s public Color → Tokens page explicitly documents:

| Token                  | Category                 | Purpose                                 | Confidence |
| ---------------------- | ------------------------ | --------------------------------------- | ---------- |
| `$skeleton-element`    | Miscellaneous / skeleton | Skeleton color for text and UI elements | Documented |
| `$skeleton-background` | Miscellaneous / skeleton | Skeleton color for containers           | Documented |

A standalone current public Skeleton component style page was not found in this pass. Skeleton guidance appears through Loading/Loading pattern docs and through component examples rather than a complete row-level Skeleton style table.

### 8.2 Source-inferred skeleton rows

| Area    | Component / Pattern / Element | Variant     | Mode / Size / Density | State   | Anatomy element                | Property            | Color token                      | Source page            | Source section      | Confidence      | Notes                                                                 |
| ------- | ----------------------------- | ----------- | --------------------- | ------- | ------------------------------ | ------------------- | -------------------------------- | ---------------------- | ------------------- | --------------- | --------------------------------------------------------------------- |
| Element | Skeleton                      | Standard    | Any                   | Loading | Skeleton element               | background-color    | `$skeleton-element`              | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |
| Element | Skeleton                      | Standard    | Any                   | Loading | Skeleton container             | background-color    | `$skeleton-background`           | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |
| Element | Skeleton                      | AI skeleton | Any                   | Loading | AI skeleton background         | background-color    | `$ai-skeleton-background`        | Official Carbon source | AI skeleton styles  | Source-inferred | Keep AI-only.                                                         |
| Element | Skeleton                      | AI skeleton | Any                   | Loading | AI skeleton element background | background/gradient | `ai-skeleton-element-background` | Official Carbon source | AI skeleton utility | Source-inferred | Keep AI-only; exact public token spelling needs package verification. |

### 8.3 Skeleton merge guidance

Keep skeleton tokens in the global/miscellaneous color-token section. Keep AI skeleton tokens in the AI/scoped-token section.

Do not create a fake Skeleton component mapping table unless a current public Skeleton style page or official component source is reviewed.

## 9. Slider row-level mapping addendum

The previous addendum coverage table marked Slider as explicit, but row-level Slider mappings were not present in the uploaded mapping table. This section adds the documented rows.

Source:

- `https://carbondesignsystem.com/components/slider/style/`

| Area      | Component / Pattern / Element | Variant | Mode / Size / Density | State     | Anatomy element | Property         | Color token        | Source page         | Source section          | Confidence | Notes             |
| --------- | ----------------------------- | ------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | ------------------- | ----------------------- | ---------- | ----------------- |
| Component | Slider                        | Default | Any                   | Default   | Handle          | fill             | `$icon-primary`    | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Default   | Track           | background-color | `$border-subtle`   | Carbon Slider style | Color                   | Documented | Contextual token. |
| Component | Slider                        | Default | Any                   | Default   | Track filled    | background-color | `$border-inverse`  | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Default   | Label           | text-color       | `$text-secondary`  | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Default   | Range label     | text-color       | `$text-primary`    | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Focus     | Handle          | border           | `$focus`           | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Focus     | Track           | background-color | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Active    | Handle          | fill             | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Active    | Track           | background-color | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Error     | Number input    | border           | `$support-error`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Error     | Error icon      | svg              | `$support-error`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Error     | Error message   | text-color       | `$text-error`      | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Warning   | Warning icon    | svg              | `$support-warning` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Warning   | Warning message | text-color       | `$text-primary`    | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Disabled  | Label           | text-color       | `$text-disabled`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Disabled  | Range label     | text-color       | `$text-disabled`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Disabled  | Handle          | fill             | `$border-disabled` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Disabled  | Track           | background-color | `$border-disabled` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Read-only | Label           | text-color       | `$text-secondary`  | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Read-only | Range label     | text-color       | `$text-primary`    | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Component | Slider                        | Default | Any                   | Read-only | Track           | background-color | `$border-subtle`   | Carbon Slider style | Interactive state color | Documented | Contextual token. |
| Component | Slider                        | Default | Any                   | Read-only | Track filled    | background-color | `$border-inverse`  | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |

## 10. File uploader row-level mapping addendum

The previous addendum coverage table marked File uploader as explicit, but row-level File uploader mappings were not present in the uploaded mapping table. This section adds the documented rows.

Source:

- `https://carbondesignsystem.com/components/file-uploader/style/`

### 10.1 File uploader documented rows

| Area      | Component / Pattern / Element | Variant   | Mode / Size / Density | State    | Anatomy element     | Property         | Color token        | Source page                | Source section          | Confidence          | Notes                                                                         |
| --------- | ----------------------------- | --------- | --------------------- | -------- | ------------------- | ---------------- | ------------------ | -------------------------- | ----------------------- | ------------------- | ----------------------------------------------------------------------------- |
| Component | File uploader                 | Standard  | Any                   | Default  | Heading             | text-color       | `$text-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Standard  | Any                   | Default  | Description         | text-color       | `$text-secondary`  | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Standard  | Any                   | Default  | Button              | token family     | See primary button | Carbon File uploader style | Color                   | Documented guidance | Delegates to Button token mappings.                                           |
| Component | File uploader                 | Drop zone | Any                   | Default  | Drop zone text      | text-color       | `$link-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Default  | Drop zone container | border           | `$border-strong`   | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Default  | File name           | text-color       | `$text-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Default  | File container      | background-color | `$field`           | Carbon File uploader style | Color                   | Documented          | Contextual token.                                                             |
| Component | File uploader                 | File item | Any                   | Default  | Delete icon         | svg              | `$icon-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Hover    | Drop zone text      | text-color       | `link-primary`     | Carbon File uploader style | Interactive state color | Documented anomaly  | Public docs omit `$`; preserve exact and verify before standardizing.         |
| Component | File uploader                 | Drop zone | Any                   | Hover    | Drop zone container | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Focus    | Delete icon         | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Focus    | Drop zone container | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Loading  | Loader              | token family     | See inline loading | Carbon File uploader style | Interactive state color | Documented guidance | Delegates to Inline loading token mappings.                                   |
| Component | File uploader                 | File item | Any                   | Uploaded | Checkmark           | svg              | `$interactive`     | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Invalid  | File container      | border           | `$support-error`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Error    | Error title         | text-color       | `$text-primary`    | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Error    | Error message       | text-color       | `$text-error`      | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | File item | Any                   | Warning  | Warning icon        | svg              | `$support-error`   | Carbon File uploader style | Interactive state color | Documented anomaly  | Public docs show support-error for warning icon; verify before standardizing. |
| Component | File uploader                 | File item | Any                   | Default  | Divider             | border           | `$border-subtle`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Disabled | Label               | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Disabled | Description         | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Component | File uploader                 | Drop zone | Any                   | Disabled | Drop zone text      | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |

### 10.2 File uploader merge guidance

Preserve the documentation anomalies exactly in the evidence matrix, but do not promote them into Login App standards without verification against Carbon package source:

- `link-primary` appears without `$`.
- Warning icon maps to `$support-error`.

## 11. Updated remaining gaps after manual review

| Gap                                         | Updated status                      | Recommended next source                                                               | Risk if ignored                                                                                                |
| ------------------------------------------- | ----------------------------------- | ------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| Full public AI-token master list            | Still partial                       | Carbon package token source / theme token files                                       | Medium: app could miss AI-only tokens or over-promote source-only tokens.                                      |
| UI shell / side nav current token mappings  | Still unresolved                    | Current Carbon UI shell source files and current docs if style page becomes available | Low-to-medium: Login App should own shell tokens anyway, but Carbon shell benchmark remains incomplete.        |
| Skeleton standalone component/page mappings | Still unresolved as standalone page | Carbon skeleton utility source and Loading pattern docs                               | Low: core skeleton tokens are already known.                                                                   |
| Tag public component-token row table        | Still public-doc partial            | Carbon Tag source + future public docs                                                | Medium: source-inferred names are now available, but public docs still do not expose all exact all-color rows. |

## 12. Merge guidance

### 12.1 Add to master token catalog

Add these as confirmed or updated families:

- Content switcher component tokens:
  - `$content-switcher-background`
  - `$content-switcher-background-hover`
  - `$content-switcher-selected`
- Tag source-inferred component-token families:
  - `$tag-background-{color}`
  - `$tag-color-{color}`
  - `$tag-hover-{color}`
  - `$tag-border-{color}`
- Skeleton tokens:
  - `$skeleton-element`
  - `$skeleton-background`
- AI public/style-page verified tokens:
  - `$ai-aura-start-sm`
  - `$ai-aura-stop`
  - `$ai-border-strong`
  - `$ai-drop-shadow`
  - `$ai-inner-shadow`
  - `$ai-overlay`
  - `$ai-border-start`
  - `$ai-border-end`
  - `$ai-aura-start`
  - `$ai-aura-end`
  - `$ai-popover-background`
  - `$ai-border-stop`

### 12.2 Add to component mapping inventory

Add component-family sections or merge rows into existing sections for:

- Tag.
- Content switcher.
- Slider.
- File uploader.

### 12.3 Add to element/support sections

Add or update support sections for:

- AI-token catalog.
- Skeleton tokens.
- UI shell / side nav unresolved disposition.

### 12.4 Do not merge as app rules without review

Do not promote the following into Login App standards without source review and app decisions:

- Source-inferred Tag token names.
- GitHub-only AI token names.
- UI shell legacy palette values.
- File uploader documentation anomalies.
- Tag `$icon-color` row anomaly.
- Any Carbon production class names or implementation-specific Sass module names.

## 13. Source index

| Source                                         | URL                                                                                                                     |
| ---------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Carbon Color tokens                            | `https://carbondesignsystem.com/elements/color/tokens/`                                                                 |
| Carbon for AI                                  | `https://carbondesignsystem.com/guidelines/carbon-for-ai/overview/`                                                     |
| Carbon Tag style                               | `https://carbondesignsystem.com/components/tag/style/`                                                                  |
| Carbon Tag component-token source              | `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_tag.scss`              |
| Carbon Content switcher style                  | `https://carbondesignsystem.com/components/content-switcher/style/`                                                     |
| Carbon Content switcher component-token source | `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_content-switcher.scss` |
| Carbon AI design-kit issue                     | `https://github.com/carbon-design-system/carbon/issues/13418`                                                           |
| Carbon UI shell header usage                   | `https://carbondesignsystem.com/components/UI-shell-header/usage/`                                                      |
| Carbon UI shell left panel usage               | `https://carbondesignsystem.com/components/UI-shell-left-panel/usage/`                                                  |
| Carbon UI shell right panel usage              | `https://carbondesignsystem.com/components/UI-shell-right-panel/usage/`                                                 |
| Carbon UI shell left panel v10 style           | `https://v10.carbondesignsystem.com/components/UI-shell-left-panel/style/`                                              |
| Carbon Loading pattern                         | `https://carbondesignsystem.com/patterns/loading-pattern/`                                                              |
| Carbon Slider style                            | `https://carbondesignsystem.com/components/slider/style/`                                                               |
| Carbon File uploader style                     | `https://carbondesignsystem.com/components/file-uploader/style/`                                                        |
| Carbon AI skeleton source                      | `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/utilities/_skeleton.scss`                |
