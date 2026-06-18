---
title: Carbon Color Token Mapping Master Inventory
slug: carbon-color-token-mapping-master-inventory
status: support-reference
api_layer: Foundation Element Support Reference
canonical_doc: docs/09-reference/ui/color-carbon-token-master-inventory.md
source_owner: docs/02-standards/ui/elements/color.md
related_color_standard: docs/02-standards/ui/elements/color.md
source_scope: Carbon Design System public docs plus official source references from merged research files
merged_from:
  - Color Token Matrix - Carbon Deep Research Report.md
  - Color Token Matrix - Addendum 1.md
  - Color Token Matrix - Addendum 2.md
---

# Carbon Color Token Mapping Master Inventory
- [1. Reference status and scope](#1-reference-status-and-scope)
- [2. Source files merged](#2-source-files-merged)
- [3. Governance relationship to Login App](#3-governance-relationship-to-login-app)
  - [3.1. Carbon evidence is not Login App API](#31-carbon-evidence-is-not-login-app-api)
  - [3.2. Carbon layer model](#32-carbon-layer-model)
- [4. Evidence confidence model](#4-evidence-confidence-model)
- [5. Master token catalog](#5-master-token-catalog)
  - [5.1. Core semantic token families](#51-core-semantic-token-families)
  - [5.2. Contextual aliases and scoped token families](#52-contextual-aliases-and-scoped-token-families)
  - [5.3. Component-token family clarifications](#53-component-token-family-clarifications)
  - [5.4. Supplemental global and contextual tokens confirmed by addendum](#54-supplemental-global-and-contextual-tokens-confirmed-by-addendum)
  - [5.5. AI tokens surfaced directly on current style pages](#55-ai-tokens-surfaced-directly-on-current-style-pages)
  - [5.6. Source-inferred Tag component-token family](#56-source-inferred-tag-component-token-family)
  - [5.7. Source-inferred Tag component-token family](#57-source-inferred-tag-component-token-family)
  - [5.8. Source-confirmed Content switcher component tokens](#58-source-confirmed-content-switcher-component-tokens)
  - [5.9. Source-confirmed Content switcher component tokens](#59-source-confirmed-content-switcher-component-tokens)
  - [5.10. AI-token catalog cleanup](#510-ai-token-catalog-cleanup)
  - [5.11. Public documentation finding](#511-public-documentation-finding)
  - [5.12. Public/style-page verified AI tokens](#512-publicstyle-page-verified-ai-tokens)
  - [5.13. GitHub/design-kit documented AI tokens](#513-githubdesign-kit-documented-ai-tokens)
  - [5.14. Source-inferred AI skeleton tokens](#514-source-inferred-ai-skeleton-tokens)
- [6. Mapping table schema](#6-mapping-table-schema)
- [7. Component color-token mappings](#7-component-color-token-mappings)
  - [7.1. Actions and navigation](#71-actions-and-navigation)
    - [7.1.1. Button](#711-button)
    - [7.1.2. Menu](#712-menu)
    - [7.1.3. Overflow menu](#713-overflow-menu)
    - [7.1.4. Link](#714-link)
    - [7.1.5. Breadcrumb](#715-breadcrumb)
    - [7.1.6. Tabs](#716-tabs)
    - [7.1.7. Content switcher](#717-content-switcher)
    - [7.1.8. Pagination](#718-pagination)
    - [7.1.9. Pagination nav](#719-pagination-nav)
  - [7.2. Forms, selection, and inputs](#72-forms-selection-and-inputs)
    - [7.2.1. Checkbox](#721-checkbox)
    - [7.2.2. Radio button](#722-radio-button)
    - [7.2.3. Toggle](#723-toggle)
    - [7.2.4. Search](#724-search)
    - [7.2.5. Dropdown](#725-dropdown)
    - [7.2.6. Dropdown / Combo box / Multiselect](#726-dropdown--combo-box--multiselect)
    - [7.2.7. Select](#727-select)
    - [7.2.8. Number input](#728-number-input)
    - [7.2.9. Slider](#729-slider)
    - [7.2.10. Text input](#7210-text-input)
    - [7.2.11. Password input](#7211-password-input)
    - [7.2.12. Text area](#7212-text-area)
    - [7.2.13. Text input / Text area](#7213-text-input--text-area)
    - [7.2.14. Date picker](#7214-date-picker)
    - [7.2.15. Date picker calendar](#7215-date-picker-calendar)
    - [7.2.16. Time picker](#7216-time-picker)
    - [7.2.17. Date picker / Time picker](#7217-date-picker--time-picker)
    - [7.2.18. File uploader](#7218-file-uploader)
  - [7.3. Overlays, feedback, status, and AI](#73-overlays-feedback-status-and-ai)
    - [7.3.1. Notification](#731-notification)
    - [7.3.2. Modal](#732-modal)
    - [7.3.3. Popover](#733-popover)
    - [7.3.4. Tooltip](#734-tooltip)
    - [7.3.5. Toggletip](#735-toggletip)
    - [7.3.6. Loading](#736-loading)
    - [7.3.7. Inline loading](#737-inline-loading)
    - [7.3.8. Progress indicator](#738-progress-indicator)
    - [7.3.9. Progress bar](#739-progress-bar)
    - [7.3.10. AI label](#7310-ai-label)
  - [7.4. Data display, collection, and structure](#74-data-display-collection-and-structure)
    - [7.4.1. Data table](#741-data-table)
    - [7.4.2. Structured list](#742-structured-list)
    - [7.4.3. Contained list](#743-contained-list)
    - [7.4.4. List](#744-list)
    - [7.4.5. Tile](#745-tile)
    - [7.4.6. Tree view](#746-tree-view)
    - [7.4.7. Code snippet](#747-code-snippet)
    - [7.4.8. Tag](#748-tag)
    - [7.4.9. Form](#749-form)
- [8. Pattern color-token mappings](#8-pattern-color-token-mappings)
  - [8.1. Read-only states](#81-read-only-states)
  - [8.2. Status indicators](#82-status-indicators)
- [9. Element and support color-token mappings](#9-element-and-support-color-token-mappings)
  - [9.1. Skeleton](#91-skeleton)
- [10. UI shell and side nav disposition](#10-ui-shell-and-side-nav-disposition)
- [11. UI shell and side nav cleanup](#11-ui-shell-and-side-nav-cleanup)
  - [11.1. Current public documentation finding](#111-current-public-documentation-finding)
  - [11.2. Legacy style documentation finding](#112-legacy-style-documentation-finding)
  - [11.3. UI shell / side nav disposition](#113-ui-shell--side-nav-disposition)
  - [11.4. UI shell merge guidance](#114-ui-shell-merge-guidance)
- [12. Skeleton state disposition](#12-skeleton-state-disposition)
- [13. Skeleton states cleanup](#13-skeleton-states-cleanup)
  - [13.1. Public documentation finding](#131-public-documentation-finding)
  - [13.2. Source-inferred skeleton rows](#132-source-inferred-skeleton-rows)
  - [13.3. Skeleton merge guidance](#133-skeleton-merge-guidance)
- [14. Coverage matrix after merge](#14-coverage-matrix-after-merge)
- [15. Remaining gaps after merge](#15-remaining-gaps-after-merge)
  - [15.1. Verification warnings](#151-verification-warnings)
  - [15.2. Pattern family gaps still worth researching](#152-pattern-family-gaps-still-worth-researching)
- [16. Login App conversion guidance](#16-login-app-conversion-guidance)
  - [16.1. Convert into Color Element roles](#161-convert-into-color-element-roles)
  - [16.2. Convert into Component standards](#162-convert-into-component-standards)
  - [16.3. Convert into Pattern standards](#163-convert-into-pattern-standards)
  - [16.4. Do not copy blindly](#164-do-not-copy-blindly)
- [17. Source index](#17-source-index)
  - [17.1. URLs collected across merged files](#171-urls-collected-across-merged-files)
- [18. Related Login App standards](#18-related-login-app-standards)

## 1. Reference status and scope

This support reference merges the original Carbon color-token research inventory with the first follow-up addendum and the final gap-cleanup addendum.

This file is not the Login App Color Element API. The canonical app color rules belong in `docs/02-standards/ui/elements/color.md`. Use this master inventory as third-party Carbon evidence when deciding whether a color role belongs globally in the Color Element, locally in a Component API, or compositionally in a Pattern API.

## 2. Source files merged

| Source file                                           | Role in this master document                                                                                         | Merge handling                                                                                             |
| ----------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| `Color Token Matrix - Carbon Deep Research Report.md` | Original inventory, base token catalog, original component/pattern rows, and first coverage report.                  | Used as the base for global token catalog, original component rows, pattern rows, and conversion guidance. |
| `Color Token Matrix - Addendum 1.md`                  | Broad component-family expansion and source-page audit.                                                              | Merged into component mapping sections and supplemental token clarifications.                              |
| `Color Token Matrix - Addendum 2.md`                  | Manual cleanup of remaining gaps: Tag, Content switcher, AI, UI shell/side nav, Skeleton, Slider, and File uploader. | Treated as the final override for those gap areas.                                                         |

## 3. Governance relationship to Login App

### 3.1. Carbon evidence is not Login App API

Carbon token names, Carbon source paths, and Carbon class names appear here only as third-party evidence. They must not be copied directly into Login App implementation standards without an app-owned decision.

### 3.2. Carbon layer model

| Layer                  | Carbon role                                                                                                               | Login App interpretation                                                                    |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| Global semantic tokens | System-wide roles such as background, layer, text, border, link, icon, support, focus, overlay, and skeleton.             | Candidate source material for the Color Element API vocabulary.                             |
| Contextual aliases     | Placement-aware roles such as `$field`, `$field-hover`, `$layer`, `$layer-hover`, `$border-strong`, and `$border-subtle`. | Candidate app aliases only when the app needs contextual layer/field behavior.              |
| Component tokens       | Component-scoped tokens such as Button, Tag, Content switcher, and Notification-specific colors.                          | Belong in the owning Component API unless Login App intentionally promotes a role globally. |
| Pattern tokens         | Pattern-scoped status or composition colors.                                                                              | Belong in the owning Pattern API unless promoted through the Color Element standard.        |
| AI tokens              | AI-specific surface, aura, border, overlay, and shadow roles.                                                             | Keep isolated behind AI-specific Component/Pattern gates.                                   |

## 4. Evidence confidence model

| Confidence             | Meaning                                                                                                                      | Merge rule                                                    |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- |
| `Documented`           | The mapping appears as a direct row or token-specific statement in current Carbon public docs captured by the research pass. | May be used as Carbon reference evidence.                     |
| `Documented guidance`  | Carbon gives a token-family rule or usage rule but not every exact token row.                                                | Keep as guidance; do not treat as complete row-level mapping. |
| `Documented anomaly`   | Carbon public docs show a value that appears malformed, surprising, or inconsistent.                                         | Preserve exact evidence and verify before standardizing.      |
| `Needs verification`   | Carbon guidance exists, but exact token names, source rows, or public-doc visibility remain incomplete or uncertain.         | Do not convert into hard app standards until verified.        |
| `Source-inferred`      | Mapping or token family came from official Carbon source/package files rather than current public docs.                      | Keep separate from public-doc-confirmed rows.                 |
| `GitHub-documented`    | Evidence appears in official Carbon GitHub issue/discussion/design-kit work.                                                 | Use as caveat or lead, not as public-doc-confirmed mapping.   |
| `Docs-source conflict` | Carbon docs and official source disagree.                                                                                    | Preserve both values and do not normalize silently.           |

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

### 5.3. Component-token family clarifications

| Family           | Scope              | What current docs explicitly say                                                                                                                                                            | Status in this addendum                             | Evidence                                                                                                                            |
| ---------------- | ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Button           | Component-specific | Listed as one of Carbon’s current component-token families, separate from global core tokens                                                                                                | Family confirmed; not re-extracted in this addendum | Color tokens page, “Component Tokens”                                                                                               |
| Content switcher | Component-specific | Listed as a component-token family; style page exposes high-contrast mappings with core tokens, but the accessible public page text did not surface the full component-token name list      | **Partial public enumeration**                      | Color tokens page, “Component Tokens”; Content switcher style page, “High contrast color” / “High contrast interactive state color” |
| Tag              | Component-specific | Read-only, dismissible, and operational tag variants use component tokens; selectable uses only core tokens; high-contrast and outline variants use core tokens instead of component tokens | **Partial public enumeration**                      | Tag style page, “Color”                                                                                                             |
| Notification     | Component-specific | Notification page surfaces explicit component-token names for low-contrast backgrounds                                                                                                      | **Explicitly surfaced**                             | Notification style page, “Low contrast”                                                                                             |

### 5.4. Supplemental global and contextual tokens confirmed by addendum

| Token                      | Category       | Purpose / semantic role                        | Theme or layer note                                            | Evidence                                                                                                                                                                   |
| -------------------------- | -------------- | ---------------------------------------------- | -------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `$focus`                   | Focus          | Focus border / focus underline                 | Core token; used widely across components                      | Color tokens page, “Focus”                                                                                                                                                 |
| `$focus-inset`             | Focus          | Contrast border paired with `$focus`           | Core token; appears in selected-focus content switcher state   | Color tokens page, “Focus”; Content switcher style, “High contrast interactive state color”                                                                                |
| `$focus-inverse`           | Focus          | Focus in high-contrast moments                 | Core token                                                     | Color tokens page, “Focus”                                                                                                                                                 |
| `$interactive`             | Miscellaneous  | Selected / active elements and accent icons    | Core token                                                     | Color tokens page, “Miscellaneous”                                                                                                                                         |
| `$highlight`               | Miscellaneous  | Highlight color                                | Core token; used on date-range calendar fill                   | Color tokens page, “Miscellaneous”; Date picker style, “Calendar menu color” → “Interactive state color”                                                                   |
| `$toggle-off`              | Miscellaneous  | Off-state background with contrast requirement | Core token; used by Toggle off state                           | Color tokens page, “Miscellaneous”; Toggle style, “Color”                                                                                                                  |
| `$overlay`                 | Miscellaneous  | Background overlay                             | Core token; used by modal/loading page overlays                | Color tokens page, “Miscellaneous”; Modal style, “Color”; Loading style, “Color”                                                                                           |
| `$skeleton-element`        | Miscellaneous  | Skeleton color for text and UI elements        | Core token                                                     | Color tokens page, “Miscellaneous”                                                                                                                                         |
| `$skeleton-background`     | Miscellaneous  | Skeleton color for containers                  | Core token                                                     | Color tokens page, “Miscellaneous”                                                                                                                                         |
| `$layer-selected-inverse`  | Layer          | High-contrast selected element surface         | Core token; used by Content switcher selected state            | Color tokens page, AI-token section snapshot where token reappears with core list; Content switcher style, “High contrast color” / “High contrast interactive state color” |
| `$layer-selected-disabled` | Layer          | Disabled color for selected layers             | Core token; used by Content switcher disabled selected state   | Color tokens page snapshot; Content switcher style, “High contrast interactive state color”                                                                                |
| `$border-tile-01`          | Border         | Operable tile indicator on `$layer-01`         | Layer-specific border-tile token                               | Color tokens page, “Border”                                                                                                                                                |
| `$border-tile-02`          | Border         | Operable tile indicator on `$layer-02`         | Layer-specific border-tile token                               | Color tokens page, “Border”                                                                                                                                                |
| `$border-tile-03`          | Border         | Operable tile indicator on `$layer-03`         | Layer-specific border-tile token                               | Color tokens page, “Border”                                                                                                                                                |
| `$support-error-inverse`   | Support/status | Error in high-contrast moments                 | Core support token; used by high-contrast notification error   | Notification style, “High contrast”                                                                                                                                        |
| `$support-success-inverse` | Support/status | Success in high-contrast moments               | Core support token; used by high-contrast notification success | Notification style, “High contrast”                                                                                                                                        |
| `$support-warning-inverse` | Support/status | Warning in high-contrast moments               | Core support token; used by high-contrast notification warning | Notification style, “High contrast”                                                                                                                                        |
| `$support-info-inverse`    | Support/status | Info in high-contrast moments                  | Core support token; used by high-contrast notification info    | Notification style, “High contrast”                                                                                                                                        |

### 5.5. AI tokens surfaced directly on current style pages

| Token                    | Scope       | Purpose / semantic role as documented in component pages                     | Where surfaced directly                                                               | Evidence                                                                                                                                                       |
| ------------------------ | ----------- | ---------------------------------------------------------------------------- | ------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `$ai-aura-start-sm`      | AI-specific | Small aura gradient start for AI variants                                    | Text input, Number input, Dropdown, Select, Date/Time picker, Modal, Data table       | Text input AI presence; Number input AI presence; Dropdown AI presence; Select AI presence; Date picker AI presence; Modal AI presence; Data table AI presence |
| `$ai-aura-stop`          | AI-specific | Aura gradient stop for AI variants                                           | Text input, Number input, Dropdown, Select, Date/Time picker, Modal, Data table       | Same sections as above                                                                                                                                         |
| `$ai-border-strong`      | AI-specific | Strong AI border treatment, usually input border-bottom or row/column border | Text input, Number input, Dropdown, Select, Date/Time picker, Data table rows/columns | Text input AI presence; Number input AI presence; Dropdown AI presence; Select AI presence; Date picker AI presence; Data table AI presence                    |
| `$ai-drop-shadow`        | AI-specific | AI exterior shadow                                                           | Modal, Data table, Tile                                                               | Modal AI presence; Data table AI presence; Tile AI presence                                                                                                    |
| `$ai-inner-shadow`       | AI-specific | AI interior shadow                                                           | Modal, Data table, Tile                                                               | Modal AI presence; Data table AI presence; Tile AI presence                                                                                                    |
| `$ai-overlay`            | AI-specific | AI modal overlay color                                                       | Modal AI presence                                                                     | Modal AI presence                                                                                                                                              |
| `$ai-border-start`       | AI-specific | Gradient border start                                                        | Modal, Data table, Tile, AI label explainability popover                              | Modal AI presence; Data table AI presence; Tile AI presence; AI label “Explainability popover color”                                                           |
| `$ai-border-end`         | AI-specific | Gradient border end                                                          | Modal, AI label explainability popover                                                | Modal AI presence; AI label “Explainability popover color”                                                                                                     |
| `$ai-aura-start`         | AI-specific | Full-size aura gradient start                                                | Tile AI presence; AI label explainability popover                                     | Tile AI presence; AI label “Explainability popover color”                                                                                                      |
| `$ai-aura-end`           | AI-specific | Full-size aura gradient end                                                  | AI label explainability popover                                                       | AI label “Explainability popover color”                                                                                                                        |
| `$ai-popover-background` | AI-specific | Explainability popover background                                            | AI label explainability popover                                                       | AI label “Explainability popover color”                                                                                                                        |
| `$ai-border-stop`        | AI-specific | Gradient border stop                                                         | Tile AI presence                                                                      | Tile AI presence                                                                                                                                               |

### 5.6. Source-inferred Tag component-token family

### 5.7. Source-inferred Tag component-token family

Official Carbon source exposes the component-token family names for all-color tags. These names should be treated as **Source-inferred** until confirmed in a stable public documentation table.

Source:

- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_tag.scss`

| Token family        | Token names                                                                                                                                                                                                                                                   | Scope                  | Confidence      |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------- | --------------- |
| Tag background      | `$tag-background-red`, `$tag-background-magenta`, `$tag-background-purple`, `$tag-background-blue`, `$tag-background-cyan`, `$tag-background-teal`, `$tag-background-green`, `$tag-background-gray`, `$tag-background-cool-gray`, `$tag-background-warm-gray` | Tag component-specific | Source-inferred |
| Tag text/icon color | `$tag-color-red`, `$tag-color-magenta`, `$tag-color-purple`, `$tag-color-blue`, `$tag-color-cyan`, `$tag-color-teal`, `$tag-color-green`, `$tag-color-gray`, `$tag-color-cool-gray`, `$tag-color-warm-gray`                                                   | Tag component-specific | Source-inferred |
| Tag hover           | `$tag-hover-red`, `$tag-hover-magenta`, `$tag-hover-purple`, `$tag-hover-blue`, `$tag-hover-cyan`, `$tag-hover-teal`, `$tag-hover-green`, `$tag-hover-gray`, `$tag-hover-cool-gray`, `$tag-hover-warm-gray`                                                   | Tag component-specific | Source-inferred |
| Tag border          | `$tag-border-red`, `$tag-border-magenta`, `$tag-border-purple`, `$tag-border-blue`, `$tag-border-cyan`, `$tag-border-teal`, `$tag-border-green`, `$tag-border-gray`, `$tag-border-cool-gray`, `$tag-border-warm-gray`                                         | Tag component-specific | Source-inferred |

### 5.8. Source-confirmed Content switcher component tokens

### 5.9. Source-confirmed Content switcher component tokens

| Token                                | Scope                               | Confidence                    | Source                                                |
| ------------------------------------ | ----------------------------------- | ----------------------------- | ----------------------------------------------------- |
| `$content-switcher-background`       | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |
| `$content-switcher-background-hover` | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |
| `$content-switcher-selected`         | Content switcher component-specific | Documented + source-confirmed | Public style page and official component-token source |

### 5.10. AI-token catalog cleanup

### 5.11. Public documentation finding

Carbon’s public token page confirms that AI tokens exist inside the main Carbon themes and should only be used for custom AI components, variants, or instances. The parsed public docs expose the section families **General AI**, **Chat**, and **Chat button**, but they do not expose a clean complete machine-readable token list in the retrieved text.

This addendum therefore separates:

- **Public/style-page verified AI tokens**.
- **GitHub/design-kit documented AI tokens**.
- **Source-inferred AI skeleton tokens**.

### 5.12. Public/style-page verified AI tokens

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

### 5.13. GitHub/design-kit documented AI tokens

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

### 5.14. Source-inferred AI skeleton tokens

Official source for AI skeleton styles references AI skeleton utility tokens. These should remain **Source-inferred** unless added to the public token page or style pages.

| Token / source reference         | Scope       | Confidence      | Notes                                                                              |
| -------------------------------- | ----------- | --------------- | ---------------------------------------------------------------------------------- |
| `$ai-skeleton-background`        | AI skeleton | Source-inferred | Referenced by AI skeleton source.                                                  |
| `ai-skeleton-element-background` | AI skeleton | Source-inferred | Used by source utility to render AI skeleton element gradient/background behavior. |

## 6. Mapping table schema

Use this schema for every component, pattern, and element mapping row.

| Column                | Meaning                                                                                                            |
| --------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Variant               | Carbon variant or family-specific visual mode.                                                                     |
| Mode / Size / Density | Size, density, AI mode, display mode, or context when documented.                                                  |
| State                 | Default, hover, focus, active, disabled, selected, error, warning, loading, AI present, or other documented state. |
| Anatomy element       | Specific element inside the component or pattern.                                                                  |
| Property              | CSS/property role such as text-color, background-color, border, svg, fill, stroke, box-shadow, or inset.           |
| Color token           | Exact Carbon token or documented value.                                                                            |
| Source page           | Carbon page or source label.                                                                                       |
| Source section        | Carbon section/table heading where available.                                                                      |
| Confidence            | Evidence confidence from this document's model.                                                                    |
| Notes                 | Verification notes, anomalies, contextual-token notes, or merge warnings.                                          |

## 7. Component color-token mappings

### 7.1. Actions and navigation

#### 7.1.1. Button

Coverage status: Confirmed row-level mappings.

| Variant        | Mode / Size / Density | State    | Anatomy element | Property         | Color token                | Source page         | Source section                                | Confidence | Notes |
| -------------- | --------------------- | -------- | --------------- | ---------------- | -------------------------- | ------------------- | --------------------------------------------- | ---------- | ----- |
| Danger primary | Default               | Active   | Container       | background-color | `$button-danger-active`    | Carbon Button style | Danger primary button interactive state color | Documented |       |
| Danger primary | Default               | Default  | Container       | background-color | `$button-danger-primary`   | Carbon Button style | Danger primary button color                   | Documented |       |
| Danger primary | Default               | Disabled | Container       | background-color | `$button-disabled`         | Carbon Button style | Danger primary button interactive state color | Documented |       |
| Danger primary | Default               | Focus    | Container       | border           | `$focus`                   | Carbon Button style | Danger primary button interactive state color | Documented |       |
| Danger primary | Default               | Focus    | Container       | inset            | `$focus-inset`             | Carbon Button style | Danger primary button interactive state color | Documented |       |
| Danger primary | Default               | Hover    | Container       | background-color | `$button-danger-hover`     | Carbon Button style | Danger primary button interactive state color | Documented |       |
| Ghost          | Default               | Active   | Container       | background-color | `$background-hover`        | Carbon Button style | Ghost button interactive state color          | Documented |       |
| Ghost          | Default               | Default  | Icon            | svg              | `$link-primary`            | Carbon Button style | Ghost button color                            | Documented |       |
| Ghost          | Default               | Default  | Label           | text-color       | `$link-primary`            | Carbon Button style | Ghost button color                            | Documented |       |
| Ghost          | Default               | Focus    | Container       | background-color | `$focus`                   | Carbon Button style | Ghost button interactive state color          | Documented |       |
| Ghost          | Default               | Hover    | Container       | background-color | `$background-hover`        | Carbon Button style | Ghost button interactive state color          | Documented |       |
| Ghost          | Default               | Hover    | Label           | text-color       | `$link-primary-hover`      | Carbon Button style | Ghost button interactive state color          | Documented |       |
| Primary        | Default               | Active   | Container       | background-color | `$button-primary-active`   | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Default  | Container       | background-color | `$button-primary`          | Carbon Button style | Primary button color                          | Documented |       |
| Primary        | Default               | Default  | Icon            | svg              | `$icon-on-color`           | Carbon Button style | Primary button color                          | Documented |       |
| Primary        | Default               | Default  | Label           | text-color       | `$text-on-color`           | Carbon Button style | Primary button color                          | Documented |       |
| Primary        | Default               | Disabled | Container       | background-color | `$button-disabled`         | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Disabled | Icon            | svg              | `$icon-on-color-disabled`  | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Disabled | Label           | text-color       | `$text-on-color-disabled`  | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Focus    | Container       | border           | `$focus`                   | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Focus    | Container       | inset            | `$focus-inset`             | Carbon Button style | Primary button interactive state color        | Documented |       |
| Primary        | Default               | Hover    | Container       | background-color | `$button-primary-hover`    | Carbon Button style | Primary button interactive state color        | Documented |       |
| Secondary      | Default               | Active   | Container       | background-color | `$button-secondary-active` | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Default  | Container       | background-color | `$button-secondary`        | Carbon Button style | Secondary button color                        | Documented |       |
| Secondary      | Default               | Default  | Icon            | svg              | `$icon-on-color`           | Carbon Button style | Secondary button color                        | Documented |       |
| Secondary      | Default               | Default  | Label           | text-color       | `$text-on-color`           | Carbon Button style | Secondary button color                        | Documented |       |
| Secondary      | Default               | Disabled | Container       | background-color | `$button-disabled`         | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Disabled | Icon            | svg              | `$icon-on-color-disabled`  | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Disabled | Label           | text-color       | `$text-on-color-disabled`  | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Focus    | Container       | border           | `$focus`                   | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Focus    | Container       | inset            | `$focus-inset`             | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Secondary      | Default               | Hover    | Container       | background-color | `$button-secondary-hover`  | Carbon Button style | Secondary button interactive state color      | Documented |       |
| Tertiary       | Default               | Active   | Container       | background-color | `$button-tertiary-active`  | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Default  | Container       | border           | `$button-tertiary`         | Carbon Button style | Tertiary button color                         | Documented |       |
| Tertiary       | Default               | Default  | Icon            | svg              | `$button-tertiary`         | Carbon Button style | Tertiary button color                         | Documented |       |
| Tertiary       | Default               | Default  | Label           | text-color       | `$button-tertiary`         | Carbon Button style | Tertiary button color                         | Documented |       |
| Tertiary       | Default               | Focus    | Container       | background-color | `$button-tertiary`         | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Focus    | Container       | border           | `$focus`                   | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Focus    | Container       | inset            | `$focus-inset`             | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Hover    | Container       | background-color | `$button-tertiary-hover`   | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Hover    | Icon            | svg              | `$icon-inverse`            | Carbon Button style | Tertiary button interactive state color       | Documented |       |
| Tertiary       | Default               | Hover    | Label           | text-color       | `$text-inverse`            | Carbon Button style | Tertiary button interactive state color       | Documented |       |


#### 7.1.2. Menu

Coverage status: Confirmed row-level mappings.

| Variant | Mode / Size / Density | State   | Anatomy element  | Property         | Color token       | Source page | Source section          | Confidence | Notes |
| ------- | --------------------- | ------- | ---------------- | ---------------- | ----------------- | ----------- | ----------------------- | ---------- | ----- |
| Danger  | Any                   | Hover   | Icon             | svg              | `$icon-on-color`  | Menu style  | Interactive state color | Documented |       |
| Danger  | Any                   | Hover   | Menu option      | background-color | `$support-error`  | Menu style  | Interactive state color | Documented |       |
| Danger  | Any                   | Hover   | Menu option text | text-color       | `$text-on-color`  | Menu style  | Interactive state color | Documented |       |
| Default | Any                   | Enabled | Caret icon       | svg              | `$icon-secondary` | Menu style  | Color                   | Documented |       |
| Default | Any                   | Enabled | Divider          | border-top       | `$border-subtle`  | Menu style  | Color                   | Documented |       |
| Default | Any                   | Enabled | Menu option      | background-color | `$layer`          | Menu style  | Color                   | Documented |       |
| Default | Any                   | Enabled | Menu option text | text-color       | `$text-secondary` | Menu style  | Color                   | Documented |       |
| Default | Any                   | Focus   | Menu option      | border           | `$focus`          | Menu style  | Interactive state color | Documented |       |
| Default | Any                   | Hover   | Menu option      | background-color | `$layer-hover`    | Menu style  | Interactive state color | Documented |       |
| Default | Any                   | Hover   | Menu option text | text-color       | `$text-primary`   | Menu style  | Interactive state color | Documented |       |


#### 7.1.3. Overflow menu

Coverage status: Confirmed row-level mappings.

| Variant | Mode / Size / Density | State   | Anatomy element    | Property         | Color token              | Source page         | Source section     | Confidence | Notes |
| ------- | --------------------- | ------- | ------------------ | ---------------- | ------------------------ | ------------------- | ------------------ | ---------- | ----- |
| Danger  | Any                   | Hover   | Danger option      | background-color | `$button-danger-primary` | Overflow menu style | Interactive states | Documented |       |
| Default | Any                   | Enabled | Menu option        | background-color | `$layer`                 | Overflow menu style | Color              | Documented |       |
| Default | Any                   | Enabled | Overflow menu icon | fill             | `$icon-primary`          | Overflow menu style | Color              | Documented |       |
| Default | Any                   | Focus   | Menu option        | border           | `$focus`                 | Overflow menu style | Interactive states | Documented |       |
| Default | Any                   | Hover   | Icon button        | background-color | `$background-hover`      | Overflow menu style | Interactive states | Documented |       |


#### 7.1.4. Link

Coverage status: Confirmed row-level mappings.

| Variant             | Mode / Size / Density | State    | Anatomy element | Property   | Color token           | Source page       | Source section          | Confidence | Notes |
| ------------------- | --------------------- | -------- | --------------- | ---------- | --------------------- | ----------------- | ----------------------- | ---------- | ----- |
| Link with icon      | Any                   | Enabled  | Icon            | svg        | `$link-primary`       | Link style        | Color                   | Documented |       |
| Standalone / inline | Any                   | Active   | Link            | text-color | `$text-primary`       | Link style        | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Default  | Icon            | svg        | `$link-primary`       | Carbon Link style | Color                   | Documented |       |
| Standalone / inline | Any                   | Default  | Link            | text-color | `$link-primary`       | Carbon Link style | Color                   | Documented |       |
| Standalone / inline | Any                   | Disabled | Link            | text-color | `$text-disabled`      | Link style        | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Enabled  | Link            | text-color | `$link-primary`       | Link style        | Color                   | Documented |       |
| Standalone / inline | Any                   | Focus    | Border          | border     | `$focus`              | Link style        | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Focus    | Link            | text-color | `$link-primary`       | Carbon Link style | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Hover    | Icon            | svg        | `$link-primary-hover` | Carbon Link style | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Hover    | Link            | text-color | `$link-primary-hover` | Link style        | Interactive state color | Documented |       |
| Standalone / inline | Any                   | Visited  | Link            | text-color | `$link-visited`       | Link style        | Interactive state color | Documented |       |


#### 7.1.5. Breadcrumb

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State   | Anatomy element         | Property   | Color token           | Source page      | Source section                              | Confidence | Notes |
| -------- | --------------------- | ------- | ----------------------- | ---------- | --------------------- | ---------------- | ------------------------------------------- | ---------- | ----- |
| Overflow | Any                   | Active  | Icon                    | svg        | `$icon-primary`       | Breadcrumb style | Breadcrumb overflow interactive state color | Documented |       |
| Overflow | Any                   | Enabled | Overflow icon           | svg        | `$link-primary`       | Breadcrumb style | Color                                       | Documented |       |
| Standard | Any                   | Enabled | Current breadcrumb text | text-color | `$text-primary`       | Breadcrumb style | Color                                       | Documented |       |
| Standard | Any                   | Enabled | Enabled breadcrumb text | text-color | `$link-primary`       | Breadcrumb style | Color                                       | Documented |       |
| Standard | Any                   | Focus   | Border                  | border     | `$focus`              | Breadcrumb style | Breadcrumb interactive state color          | Documented |       |
| Standard | Any                   | Hover   | Text                    | text-color | `$link-primary-hover` | Breadcrumb style | Breadcrumb interactive state color          | Documented |       |


#### 7.1.6. Tabs

Coverage status: Confirmed row-level mappings.

| Variant                   | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page | Source section                                    | Confidence | Notes |
| ------------------------- | --------------------- | ---------- | --------------- | ---------------- | --------------------- | ----------- | ------------------------------------------------- | ---------- | ----- |
| Contained tab             | Any                   | Disabled   | Tab             | background-color | `$button-disabled`    | Tabs style  | Contained tab interactive state color             | Documented |       |
| Contained tab             | Any                   | Selected   | Tab             | background-color | `$layer`              | Tabs style  | Contained tab color                               | Documented |       |
| Contained tab             | Any                   | Unselected | Tab             | background-color | `$layer-accent`       | Tabs style  | Contained tab color                               | Documented |       |
| Dismissible contained tab | Any                   | Focus      | Tab             | border           | `$focus`              | Tabs style  | Dismissible contained tab interactive state color | Documented |       |
| Line tab                  | Any                   | Disabled   | Tab             | border-bottom    | `$border-disabled`    | Tabs style  | Line tab interactive state color                  | Documented |       |
| Line tab                  | Any                   | Focus      | Tab             | border           | `$focus`              | Tabs style  | Line tab interactive state color                  | Documented |       |
| Line tab                  | Any                   | Hover      | Tab             | border-bottom    | `$border-strong`      | Tabs style  | Line tab interactive state color                  | Documented |       |
| Line tab                  | Any                   | Selected   | Tab             | border-bottom    | `$border-interactive` | Tabs style  | Line tab color                                    | Documented |       |
| Line tab                  | Any                   | Unselected | Label           | text-color       | `$text-secondary`     | Tabs style  | Line tab color                                    | Documented |       |
| Vertical tab              | Any                   | Hover      | Tab             | background-color | `$layer-hover`        | Tabs style  | Vertical tab interactive state color              | Documented |       |
| Vertical tab              | Any                   | Selected   | Tab             | border-left      | `$border-interactive` | Tabs style  | Vertical tab color                                | Documented |       |


#### 7.1.7. Content switcher

Coverage status: Partial / verification required.

| Variant       | Mode / Size / Density | State               | Anatomy element | Property         | Color token                          | Source page                   | Source section                        | Confidence         | Notes                                                                                     |
| ------------- | --------------------- | ------------------- | --------------- | ---------------- | ------------------------------------ | ----------------------------- | ------------------------------------- | ------------------ | ----------------------------------------------------------------------------------------- |
| High contrast | Default / Icon        | Disabled selected   | Container       | background-color | `$layer-selected-disabled`           | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Disabled selected   | Icon            | svg              | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented anomaly | Public docs use `$text-disabled` for selected disabled icon. Verify before standardizing. |
| High contrast | Default / Icon        | Disabled selected   | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Disabled unselected | Border          | border           | `$border-disabled`                   | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Disabled unselected | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Disabled unselected | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Focus selected      | Container       | inner-border     | `$focus-inset`                       | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Focus unselected    | Container       | border           | `$focus`                             | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Hover unselected    | Container       | background-color | `$background-hover`                  | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Hover unselected    | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Hover unselected    | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | High contrast interactive state color | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Selected            | Container       | background-color | `$layer-selected-inverse`            | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Selected            | Icon            | svg              | `$icon-inverse`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Selected            | Label           | text-color       | `$text-inverse`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Unselected          | Container       | background-color | transparent                          | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Unselected          | Container       | border           | `$border-inverse`                    | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Unselected          | Divider         | border           | `$border-subtle`                     | Carbon Content switcher style | High contrast color                   | Documented         | Contextual token.                                                                         |
| High contrast | Default / Icon        | Unselected          | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| High contrast | Default / Icon        | Unselected          | Label           | text-color       | `$text-secondary`                    | Carbon Content switcher style | High contrast color                   | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Disabled selected   | Container       | background-color | `$content-switcher-selected`         | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Low contrast  | Default / Icon        | Disabled selected   | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Disabled selected   | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Disabled unselected | Container       | background-color | `$content-switcher-background`       | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Low contrast  | Default / Icon        | Disabled unselected | Icon            | svg              | `$icon-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Disabled unselected | Label           | text-color       | `$text-disabled`                     | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Focus               | Container       | border           | `$focus`                             | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Hover unselected    | Container       | background-color | `$content-switcher-background-hover` | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Component token.                                                                          |
| Low contrast  | Default / Icon        | Hover unselected    | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Hover unselected    | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | Low contrast interactive state color  | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Selected            | Container       | background-color | `$content-switcher-selected`         | Carbon Content switcher style | Low contrast color                    | Documented         | Component token.                                                                          |
| Low contrast  | Default / Icon        | Selected            | Icon            | svg              | `$icon-primary`                      | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Selected            | Label           | text-color       | `$text-primary`                      | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Unselected          | Border          | border           | `$border-strong`                     | Carbon Content switcher style | Low contrast color                    | Documented         | Contextual token.                                                                         |
| Low contrast  | Default / Icon        | Unselected          | Container       | background-color | `$content-switcher-background`       | Carbon Content switcher style | Low contrast color                    | Documented         | Component token.                                                                          |
| Low contrast  | Default / Icon        | Unselected          | Divider         | border           | `$border-strong`                     | Carbon Content switcher style | Low contrast color                    | Documented         | Contextual token.                                                                         |
| Low contrast  | Default / Icon        | Unselected          | Icon            | svg              | `$icon-secondary`                    | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |
| Low contrast  | Default / Icon        | Unselected          | Label           | text-color       | `$text-secondary`                    | Carbon Content switcher style | Low contrast color                    | Documented         | Public-doc row.                                                                           |


#### 7.1.8. Pagination

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State   | Anatomy element | Property         | Color token       | Source page      | Source section   | Confidence | Notes |
| -------- | --------------------- | ------- | --------------- | ---------------- | ----------------- | ---------------- | ---------------- | ---------- | ----- |
| Standard | Any                   | Enabled | Container       | background-color | `$layer`          | Pagination style | Pagination color | Documented |       |
| Standard | Any                   | Enabled | Container       | border-top       | `$border-subtle`  | Pagination style | Pagination color | Documented |       |
| Standard | Any                   | Enabled | Page-range text | text-color       | `$text-secondary` | Pagination style | Pagination color | Documented |       |


#### 7.1.9. Pagination nav

Coverage status: Confirmed row-level mappings.

| Variant | Mode / Size / Density | State    | Anatomy element | Property         | Color token           | Source page      | Source section                                                | Confidence | Notes |
| ------- | --------------------- | -------- | --------------- | ---------------- | --------------------- | ---------------- | ------------------------------------------------------------- | ---------- | ----- |
| Nav     | Any                   | Disabled | Icon            | fill             | `$icon-disabled`      | Pagination style | Pagination nav interactive state color                        | Documented |       |
| Nav     | Any                   | Disabled | Text            | text-color       | `$text-disabled`      | Pagination style | Pagination nav interactive state color                        | Documented |       |
| Nav     | Any                   | Hover    | Background      | background-color | `$layer-hover`        | Pagination style | Pagination nav interactive state color                        | Documented |       |
| Nav     | Any                   | Selected | Page            | border           | `$border-interactive` | Pagination style | Pagination nav color / Pagination nav interactive state color | Documented |       |

### 7.2. Forms, selection, and inputs

#### 7.2.1. Checkbox

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State     | Anatomy element | Property         | Color token        | Source page           | Source section     | Confidence | Notes |
| -------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | --------------------- | ------------------ | ---------- | ----- |
| Default  | Any                   | Checked   | Checkbox        | background-color | `$icon-primary`    | Checkbox style        | Color              | Documented |       |
| Default  | Any                   | Checked   | Checkmark       | fill             | `$icon-inverse`    | Checkbox style        | Color              | Documented |       |
| Default  | Any                   | Disabled  | Checkbox        | border           | `$icon-disabled`   | Checkbox style        | Interactive states | Documented |       |
| Default  | Any                   | Error     | Checkbox        | border           | `$support-error`   | Checkbox style        | Interactive states | Documented |       |
| Default  | Any                   | Focus     | Checkbox        | border           | `$focus`           | Checkbox style        | Interactive states | Documented |       |
| Default  | Any                   | Unchecked | Checkbox        | border           | `$icon-primary`    | Checkbox style        | Color              | Documented |       |
| Default  | Any                   | Warning   | Inner fill      | fill             | `$black`           | Checkbox style        | Interactive states | Documented |       |
| Standard | Default               | Checked   | Checkbox        | background-color | `$icon-primary`    | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Checked   | Checkmark       | fill             | `$icon-inverse`    | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Default   | Checkbox label  | text color       | `$text-primary`    | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Default   | Group label     | text color       | `$text-secondary`  | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Default   | Helper text     | text color       | `$text-secondary`  | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Disabled  | Checkbox        | background       | `$icon-disabled`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Disabled  | Checkbox        | border           | `$icon-disabled`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Disabled  | Label           | text color       | `$text-disabled`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Error     | Checkbox        | border           | `$support-error`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Error     | Error icon      | svg              | `$support-error`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Error     | Error message   | text color       | `$text-error`      | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Focus     | Checkbox        | border           | `$focus`           | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Read-only | Checkbox        | border           | `$icon-disabled`   | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Read-only | Checkbox        | inner fill       | `$icon-primary`    | Carbon Checkbox style | Interactive states | Documented |       |
| Standard | Default               | Unchecked | Checkbox        | border           | `$icon-primary`    | Carbon Checkbox style | Color              | Documented |       |
| Standard | Default               | Warning   | Warning icon    | svg              | `$support-warning` | Carbon Checkbox style | Interactive states | Documented |       |


#### 7.2.2. Radio button

Coverage status: Confirmed row-level mappings.

| Variant    | Mode / Size / Density | State      | Anatomy element | Property   | Color token        | Source page        | Source section     | Confidence | Notes |
| ---------- | --------------------- | ---------- | --------------- | ---------- | ------------------ | ------------------ | ------------------ | ---------- | ----- |
| AI variant | Any                   | AI present | AI label        | size token | `mini`             | Radio button style | AI presence        | Documented |       |
| Default    | Any                   | Disabled   | Label           | text-color | `$text-disabled`   | Radio button style | Interactive colors | Documented |       |
| Default    | Any                   | Enabled    | Group label     | text-color | `$text-secondary`  | Radio button style | Color              | Documented |       |
| Default    | Any                   | Enabled    | Radio label     | text-color | `$text-primary`    | Radio button style | Color              | Documented |       |
| Default    | Any                   | Error      | Error message   | text-color | `$text-error`      | Radio button style | Interactive colors | Documented |       |
| Default    | Any                   | Error      | Radio control   | border     | `$support-error`   | Radio button style | Interactive colors | Documented |       |
| Default    | Any                   | Focus      | Radio control   | border     | `$focus`           | Radio button style | Interactive colors | Documented |       |
| Default    | Any                   | Warning    | Warning icon    | svg        | `$support-warning` | Radio button style | Interactive colors | Documented |       |
| Selected   | Any                   | Enabled    | Radio dot       | fill       | `$icon-primary`    | Radio button style | Color              | Documented |       |
| Unselected | Any                   | Enabled    | Radio control   | border     | `$icon-primary`    | Radio button style | Color              | Documented |       |


#### 7.2.3. Toggle

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State       | Anatomy element | Property         | Color token               | Source page         | Source section          | Confidence | Notes |
| --------------- | --------------------- | ----------- | --------------- | ---------------- | ------------------------- | ------------------- | ----------------------- | ---------- | ----- |
| Default / Small | Any                   | Disabled    | Background      | background-color | `$button-disabled`        | Toggle style        | Interactive state color | Documented |       |
| Default / Small | Any                   | Disabled    | Handle          | background-color | `$icon-on-color-disabled` | Toggle style        | Interactive state color | Documented |       |
| Default / Small | Any                   | Focus       | Toggle          | border           | `$focus`                  | Toggle style        | Interactive state color | Documented |       |
| Default / Small | Any                   | Off         | Background      | background-color | `$toggle-off`             | Toggle style        | Color                   | Documented |       |
| Default / Small | Any                   | Off         | Handle          | background-color | `$icon-on-color`          | Toggle style        | Color                   | Documented |       |
| Default / Small | Any                   | On          | Background      | background-color | `$support-success`        | Toggle style        | Color                   | Documented |       |
| Default / Small | Any                   | Read-only   | Border          | border           | `$border-subtle`          | Toggle style        | Interactive state color | Documented |       |
| Default / small | Any                   | Default off | Background      | background-color | `$toggle-off`             | Carbon Toggle style | Color                   | Documented |       |
| Default / small | Any                   | Default off | Handle          | background-color | `$icon-on-color`          | Carbon Toggle style | Color                   | Documented |       |
| Default / small | Any                   | Default on  | Background      | background-color | `$support-success`        | Carbon Toggle style | Color                   | Documented |       |
| Default / small | Any                   | Default on  | Checkmark       | fill             | `$support-success`        | Carbon Toggle style | Color                   | Documented |       |
| Default / small | Any                   | Default on  | Handle          | background-color | `$icon-on-color`          | Carbon Toggle style | Color                   | Documented |       |
| Default / small | Any                   | Read-only   | Handle          | background-color | `$icon-primary`           | Carbon Toggle style | Interactive state color | Documented |       |


#### 7.2.4. Search

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State    | Anatomy element  | Property         | Color token         | Source page  | Source section     | Confidence | Notes |
| --------------- | --------------------- | -------- | ---------------- | ---------------- | ------------------- | ------------ | ------------------ | ---------- | ----- |
| Default / Fluid | Any                   | Disabled | Field text       | text-color       | `$text-disabled`    | Search style | Interactive colors | Documented |       |
| Default / Fluid | Any                   | Enabled  | Field            | background-color | `$field`            | Search style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled  | Field            | border-bottom    | `$border-strong`    | Search style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled  | Placeholder text | text-color       | `$text-placeholder` | Search style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled  | Search icon      | fill             | `$icon-secondary`   | Search style | Color              | Documented |       |
| Default / Fluid | Any                   | Filled   | Close icon       | fill             | `$icon-primary`     | Search style | Interactive colors | Documented |       |
| Default / Fluid | Any                   | Filled   | Field text       | text-color       | `$text-primary`     | Search style | Interactive colors | Documented |       |
| Default / Fluid | Any                   | Focus    | Field            | border           | `$focus`            | Search style | Interactive colors | Documented |       |


#### 7.2.5. Dropdown

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State         | Anatomy element       | Property         | Color token           | Source page           | Source section     | Confidence | Notes |
| --------------- | --------------------- | ------------- | --------------------- | ---------------- | --------------------- | --------------------- | ------------------ | ---------- | ----- |
| Default / fluid | Any                   | Active        | Menu option           | background-color | `$layer-active`       | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Default       | Menu option           | background-color | `$layer`              | Carbon Dropdown style | Color              | Documented |       |
| Default / fluid | Any                   | Default       | Menu option           | text-color       | `$text-secondary`     | Carbon Dropdown style | Color              | Documented |       |
| Default / fluid | Any                   | Disabled      | Chevron icon          | svg              | `$icon-disabled`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Disabled      | Field                 | text-color       | `$text-disabled`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Disabled      | Label                 | text-color       | `$text-disabled`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Focus         | Field                 | border           | `$focus`              | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Hover         | Field                 | background-color | `$field-hover`        | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Hover         | Menu option           | background-color | `$layer-hover`        | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Hover         | Menu option           | text-color       | `$text-primary`       | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid       | Error icon            | svg              | `$support-error`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid       | Error message         | text-color       | `$text-error`         | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid       | Field                 | border           | `$support-error`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only     | Border                | border-bottom    | `$border-subtle`      | Carbon Dropdown style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only     | Chevron icon          | svg              | `$icon-disabled`      | Carbon Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Multiselected | Tag                   | background-color | `$background-inverse` | Carbon Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Multiselected | Tag                   | text-color       | `$text-inverse`       | Carbon Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Selected      | Menu option           | background-color | `$layer-selected`     | Carbon Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Selected      | Menu option checkmark | fill             | `$icon-primary`       | Carbon Dropdown style | Interactive states | Documented |       |


#### 7.2.6. Dropdown / Combo box / Multiselect

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page    | Source section     | Confidence | Notes |
| --------------- | --------------------- | ---------- | --------------- | ---------------- | --------------------- | -------------- | ------------------ | ---------- | ----- |
| AI variant      | Default / Fluid       | AI present | Field           | border-bottom    | `$ai-border-strong`   | Dropdown style | AI presence        | Documented |       |
| Default / Fluid | Any                   | Active     | Menu option     | background-color | `$layer-active`       | Dropdown style | Interactive states | Documented |       |
| Default / Fluid | Any                   | Enabled    | Field           | background-color | `$field`              | Dropdown style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled    | Label           | text-color       | `$text-secondary`     | Dropdown style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled    | Menu option     | background-color | `$layer`              | Dropdown style | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled    | Prompt text     | text-color       | `$text-helper`        | Dropdown style | Color              | Documented |       |
| Default / Fluid | Any                   | Hover      | Field           | background-color | `$field-hover`        | Dropdown style | Interactive states | Documented |       |
| Default / Fluid | Any                   | Hover      | Menu option     | background-color | `$layer-hover`        | Dropdown style | Interactive states | Documented |       |
| Default / Fluid | Any                   | Invalid    | Field           | border           | `$support-error`      | Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Selected   | Tag             | background-color | `$background-inverse` | Dropdown style | Interactive states | Documented |       |
| Multiselect     | Any                   | Selected   | Tag             | text-color       | `$text-inverse`       | Dropdown style | Interactive states | Documented |       |


#### 7.2.7. Select

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State      | Anatomy element | Property             | Color token         | Source page         | Source section     | Confidence | Notes |
| --------------- | --------------------- | ---------- | --------------- | -------------------- | ------------------- | ------------------- | ------------------ | ---------- | ----- |
| AI variant      | Default / Fluid       | AI present | Field           | border-bottom        | `$ai-border-strong` | Select style        | AI presence        | Documented |       |
| Default / Fluid | Any                   | Disabled   | Chevron icon    | fill                 | `$icon-disabled`    | Select style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Enabled    | Helper text     | text color           | `$text-helper`      | Select style        | Color              | Documented |       |
| Default / Fluid | Any                   | Enabled    | Icon            | fill                 | `$icon-primary`     | Select style        | Color              | Documented |       |
| Default / Fluid | Any                   | Hover      | Field           | background-color     | `$field-hover`      | Select style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Read-only  | Input text      | text-color (default) | `$text-primary`     | Select style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Read-only  | Input text      | text-color (fluid)   | `$text-secondary`   | Select style        | Interactive states | Documented |       |
| Default / fluid | Any                   | Default    | Field           | background           | `$field`            | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Field           | border-bottom        | `$border-strong`    | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Field text      | text color           | `$text-primary`     | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Helper text     | text color           | `$text-helper`      | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Icon            | fill                 | `$icon-primary`     | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Label           | text color           | `$text-secondary`   | Carbon Select style | Color              | Documented |       |
| Default / fluid | Any                   | Disabled   | Input text      | text-color           | `$text-disabled`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Disabled   | Label           | text-color           | `$text-disabled`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Focus      | Field           | border               | `$focus`            | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid    | Error icon      | fill                 | `$support-error`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid    | Error message   | text-color           | `$text-error`       | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid    | Field           | border               | `$support-error`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only  | Border          | border-bottom        | `$border-subtle`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only  | Chevron icon    | fill                 | `$icon-disabled`    | Carbon Select style | Interactive states | Documented |       |
| Default / fluid | Any                   | Warning    | Warning icon    | fill                 | `$support-warning`  | Carbon Select style | Interactive states | Documented |       |
| Inline          | Any                   | Default    | Field           | background           | transparent         | Carbon Select style | Color              | Documented |       |


#### 7.2.8. Number input

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State      | Anatomy element | Property         | Color token         | Source page               | Source section     | Confidence | Notes |
| --------------- | --------------------- | ---------- | --------------- | ---------------- | ------------------- | ------------------------- | ------------------ | ---------- | ----- |
| AI variant      | Default / Fluid       | AI present | Field           | border-bottom    | `$ai-border-strong` | Number input style        | AI presence        | Documented |       |
| Default / Fluid | Any                   | Disabled   | Controls        | svg color        | `$icon-disabled`    | Number input style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Enabled    | Controls        | svg color        | `$icon-primary`     | Number input style        | Color              | Documented |       |
| Default / Fluid | Any                   | Focus      | Controls        | border           | `$focus`            | Number input style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Hover      | Controls        | background-color | `field-hover`       | Number input style        | Interactive states | Documented |       |
| Default / Fluid | Any                   | Invalid    | Field           | border           | `$support-error`    | Number input style        | Interactive states | Documented |       |
| Default / fluid | Any                   | Default    | Controls        | svg color        | `$icon-primary`     | Carbon Number input style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Field           | background-color | `$field`            | Carbon Number input style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Field           | border-bottom    | `$border-strong`    | Carbon Number input style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Label           | text color       | `$text-secondary`   | Carbon Number input style | Color              | Documented |       |
| Default / fluid | Any                   | Default    | Number text     | text color       | `$text-primary`     | Carbon Number input style | Color              | Documented |       |
| Default / fluid | Any                   | Disabled   | Label           | text color       | `$text-disabled`    | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Disabled   | Number text     | text color       | `$text-disabled`    | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Focus      | Field           | border           | `$focus`            | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Hover      | Controls        | background-color | `$field-hover`      | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid    | Error icon      | svg              | `$support-error`    | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Invalid    | Error message   | text color       | `$text-error`       | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only  | Border          | border-bottom    | `$border-subtle`    | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Read-only  | Controls        | svg color        | `$icon-disabled`    | Carbon Number input style | Interactive states | Documented |       |
| Default / fluid | Any                   | Warning    | Warning icon    | svg              | `$support-warning`  | Carbon Number input style | Interactive states | Documented |       |


#### 7.2.9. Slider

Coverage status: Confirmed row-level mappings.

| Variant | Mode / Size / Density | State     | Anatomy element | Property         | Color token        | Source page         | Source section          | Confidence | Notes             |
| ------- | --------------------- | --------- | --------------- | ---------------- | ------------------ | ------------------- | ----------------------- | ---------- | ----------------- |
| Default | Any                   | Active    | Handle          | fill             | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Active    | Track           | background-color | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Default   | Handle          | fill             | `$icon-primary`    | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Default | Any                   | Default   | Label           | text-color       | `$text-secondary`  | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Default | Any                   | Default   | Range label     | text-color       | `$text-primary`    | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Default | Any                   | Default   | Track           | background-color | `$border-subtle`   | Carbon Slider style | Color                   | Documented | Contextual token. |
| Default | Any                   | Default   | Track filled    | background-color | `$border-inverse`  | Carbon Slider style | Color                   | Documented | Public-doc row.   |
| Default | Any                   | Disabled  | Handle          | fill             | `$border-disabled` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Disabled  | Label           | text-color       | `$text-disabled`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Disabled  | Range label     | text-color       | `$text-disabled`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Disabled  | Track           | background-color | `$border-disabled` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Error     | Error icon      | svg              | `$support-error`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Error     | Error message   | text-color       | `$text-error`      | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Error     | Number input    | border           | `$support-error`   | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Focus     | Handle          | border           | `$focus`           | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Focus     | Track           | background-color | `$interactive`     | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Read-only | Label           | text-color       | `$text-secondary`  | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Read-only | Range label     | text-color       | `$text-primary`    | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Read-only | Track           | background-color | `$border-subtle`   | Carbon Slider style | Interactive state color | Documented | Contextual token. |
| Default | Any                   | Read-only | Track filled    | background-color | `$border-inverse`  | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Warning   | Warning icon    | svg              | `$support-warning` | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |
| Default | Any                   | Warning   | Warning message | text-color       | `$text-primary`    | Carbon Slider style | Interactive state color | Documented | Public-doc row.   |


#### 7.2.10. Text input

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State     | Anatomy element  | Property         | Color token         | Source page             | Source section                             | Confidence | Notes |
| --------------- | --------------------- | --------- | ---------------- | ---------------- | ------------------- | ----------------------- | ------------------------------------------ | ---------- | ----- |
| Default / Fluid | Any                   | Enabled   | Field            | background-color | `$field`            | Text input style        | Text input color                           | Documented |       |
| Default / Fluid | Any                   | Enabled   | Label            | text-color       | `$text-secondary`   | Text input style        | Text input color / Interactive state color | Documented |       |
| Default / Fluid | Any                   | Enabled   | Placeholder      | text-color       | `$text-placeholder` | Text input style        | Text input color                           | Documented |       |
| Default / Fluid | Any                   | Invalid   | Error message    | text-color       | `$text-error`       | Text input style        | Interactive state color                    | Documented |       |
| Default / Fluid | Any                   | Invalid   | Field            | border           | `$support-error`    | Text input style        | Interactive state color                    | Documented |       |
| Default / Fluid | Any                   | Read-only | Field            | border-bottom    | `$border-subtle`    | Text input style        | Interactive state color                    | Documented |       |
| Password input  | Default / fluid       | Default   | Field            | background-color | `$field`            | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | Field            | border-bottom    | `$border-strong`    | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | Field text       | text-color       | `$text-primary`     | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | Helper text      | text-color       | `$text-helper`      | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | Label            | text-color       | `$text-secondary`   | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | Placeholder text | text-color       | `$text-placeholder` | Carbon Text input style | Password input color                       | Documented |       |
| Password input  | Default / fluid       | Default   | View icon        | svg              | `$icon-primary`     | Carbon Text input style | Password input color                       | Documented |       |


#### 7.2.11. Password input

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State   | Anatomy element | Property | Color token     | Source page      | Source section                                 | Confidence | Notes |
| --------------- | --------------------- | ------- | --------------- | -------- | --------------- | ---------------- | ---------------------------------------------- | ---------- | ----- |
| Default / Fluid | Any                   | Enabled | View icon       | svg      | `$icon-primary` | Text input style | Password input color / Interactive state color | Documented |       |
| Default / Fluid | Any                   | Hover   | View icon       | svg      | `$icon-primary` | Text input style | Interactive state color                        | Documented |       |


#### 7.2.12. Text area

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State     | Anatomy element  | Property         | Color token         | Source page            | Source section          | Confidence | Notes |
| --------------- | --------------------- | --------- | ---------------- | ---------------- | ------------------- | ---------------------- | ----------------------- | ---------- | ----- |
| Default / Fluid | Any                   | Enabled   | Field            | background-color | `$field`            | Text input style       | Text area color         | Documented |       |
| Default / Fluid | Any                   | Invalid   | Field            | border           | `$support-error`    | Text input style       | Interactive state color | Documented |       |
| Default / Fluid | Any                   | Read-only | Field            | border-bottom    | `$border-subtle`    | Text input style       | Interactive state color | Documented |       |
| Default / fluid | Default               | Default   | Field            | background-color | `$field`            | Carbon Text area style | Text area color         | Documented |       |
| Default / fluid | Default               | Default   | Field            | border-bottom    | `$border-strong`    | Carbon Text area style | Text area color         | Documented |       |
| Default / fluid | Default               | Default   | Field text       | text-color       | `$text-primary`     | Carbon Text area style | Text area color         | Documented |       |
| Default / fluid | Default               | Default   | Placeholder text | text-color       | `$text-placeholder` | Carbon Text area style | Text area color         | Documented |       |


#### 7.2.13. Text input / Text area

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State       | Anatomy element       | Property         | Color token         | Source page                         | Source section | Confidence | Notes |
| --------------- | --------------------- | ----------- | --------------------- | ---------------- | ------------------- | ----------------------------------- | -------------- | ---------- | ----- |
| AI variant      | Default / Fluid       | AI present  | Field                 | border-bottom    | `$ai-border-strong` | Text input style                    | AI presence    | Documented |       |
| AI variant      | Default / Fluid       | AI present  | Linear gradient start | background start | `$ai-aura-start-sm` | Text input style                    | AI presence    | Documented |       |
| AI variant      | Default / Fluid       | AI present  | Linear gradient stop  | background stop  | `$ai-aura-stop`     | Text input style                    | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Field                 | border-bottom    | `$ai-border-strong` | Carbon Text input / Text area style | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Gradient start        | background       | `$ai-aura-start-sm` | Carbon Text input / Text area style | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Gradient stop         | background       | `$ai-aura-stop`     | Carbon Text input / Text area style | AI presence    | Documented |       |


#### 7.2.14. Date picker

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State    | Anatomy element | Property         | Color token         | Source page              | Source section          | Confidence | Notes |
| --------------- | --------------------- | -------- | --------------- | ---------------- | ------------------- | ------------------------ | ----------------------- | ---------- | ----- |
| Calendar menu   | Any                   | Default  | Calendar        | background-color | `$layer`            | Carbon Date picker style | Calendar menu color     | Documented |       |
| Calendar menu   | Any                   | Default  | Today           | text-color       | `$link-01`          | Carbon Date picker style | Calendar menu color     | Documented |       |
| Calendar menu   | Any                   | Disabled | Day             | text-color       | `$text-disabled`    | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | Focus    | Day             | border           | `$focus`            | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | Hover    | Day             | background-color | `$layer-hover`      | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | In range | Day             | background-color | `$highlight`        | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | In range | Day             | text-color       | `$text-primary`     | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | Selected | Day             | background-color | `$background-brand` | Carbon Date picker style | Interactive state color | Documented |       |
| Calendar menu   | Any                   | Selected | Day             | text-color       | `$text-on-color`    | Carbon Date picker style | Interactive state color | Documented |       |
| Default / Fluid | Any                   | Enabled  | Calendar icon   | svg              | `$icon-primary`     | Date picker style        | Date picker color       | Documented |       |
| Default / Fluid | Any                   | Focus    | Field           | border           | `$focus`            | Date picker style        | Interactive state color | Documented |       |


#### 7.2.15. Date picker calendar

Coverage status: Confirmed row-level mappings.

| Variant        | Mode / Size / Density | State    | Anatomy element | Property         | Color token         | Source page       | Source section                                | Confidence | Notes |
| -------------- | --------------------- | -------- | --------------- | ---------------- | ------------------- | ----------------- | --------------------------------------------- | ---------- | ----- |
| Calendar       | Any                   | Enabled  | Calendar menu   | background-color | `$layer`            | Date picker style | Calendar menu color                           | Documented |       |
| Calendar       | Any                   | Selected | Day             | background-color | `$background-brand` | Date picker style | Calendar menu color → Interactive state color | Documented |       |
| Calendar       | Any                   | Selected | Day text        | text-color       | `$text-on-color`    | Date picker style | Calendar menu color → Interactive state color | Documented |       |
| Calendar       | Any                   | Today    | Day text        | text-color       | `$link-01`          | Date picker style | Calendar menu color                           | Documented |       |
| Calendar range | Any                   | In range | Day             | background-color | `$highlight`        | Date picker style | Calendar menu color → Interactive state color | Documented |       |


#### 7.2.16. Time picker

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State    | Anatomy element | Property         | Color token       | Source page              | Source section                              | Confidence | Notes |
| --------------- | --------------------- | -------- | --------------- | ---------------- | ----------------- | ------------------------ | ------------------------------------------- | ---------- | ----- |
| Default / Fluid | Any                   | Disabled | Chevron icon    | svg              | `$icon-disabled`  | Date picker style        | Time picker color → Interactive state color | Documented |       |
| Default / Fluid | Any                   | Enabled  | Divider         | border           | `$border-strong`  | Date picker style        | Time picker color                           | Documented |       |
| Default / fluid | Any                   | Disabled | Label           | text-color       | `$text-disabled`  | Carbon Time picker style | Interactive state color                     | Documented |       |
| Default / fluid | Any                   | Error    | Error message   | text-color       | `$text-error`     | Carbon Time picker style | Interactive state color                     | Documented |       |
| Default / fluid | Any                   | Error    | Field           | border           | `$support-error`  | Carbon Time picker style | Interactive state color                     | Documented |       |
| Default / fluid | Any                   | Focus    | Field           | border           | `$focus`          | Carbon Time picker style | Interactive state color                     | Documented |       |
| Default / fluid | Default               | Default  | Chevron icon    | svg              | `$icon-primary`   | Carbon Time picker style | Time picker color                           | Documented |       |
| Default / fluid | Default               | Default  | Field           | background-color | `$field`          | Carbon Time picker style | Time picker color                           | Documented |       |
| Default / fluid | Default               | Default  | Field           | border-bottom    | `$border-strong`  | Carbon Time picker style | Time picker color                           | Documented |       |
| Default / fluid | Default               | Default  | Label           | text-color       | `$text-secondary` | Carbon Time picker style | Time picker color                           | Documented |       |


#### 7.2.17. Date picker / Time picker

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State       | Anatomy element | Property      | Color token         | Source page                            | Source section | Confidence | Notes |
| --------------- | --------------------- | ----------- | --------------- | ------------- | ------------------- | -------------------------------------- | -------------- | ---------- | ----- |
| AI variant      | Default / Fluid       | AI present  | Field           | border-bottom | `$ai-border-strong` | Date picker style                      | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Field           | border-bottom | `$ai-border-strong` | Carbon Date picker / Time picker style | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Gradient start  | background    | `$ai-aura-start-sm` | Carbon Date picker / Time picker style | AI presence    | Documented |       |
| Default / fluid | Any                   | AI presence | Gradient stop   | background    | `$ai-aura-stop`     | Carbon Date picker / Time picker style | AI presence    | Documented |       |


#### 7.2.18. File uploader

Coverage status: Partial / verification required.

| Variant   | Mode / Size / Density | State    | Anatomy element     | Property         | Color token        | Source page                | Source section          | Confidence          | Notes                                                                         |
| --------- | --------------------- | -------- | ------------------- | ---------------- | ------------------ | -------------------------- | ----------------------- | ------------------- | ----------------------------------------------------------------------------- |
| Drop zone | Any                   | Default  | Drop zone container | border           | `$border-strong`   | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Default  | Drop zone text      | text-color       | `$link-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Disabled | Description         | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Disabled | Drop zone text      | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Disabled | Label               | text-color       | `$text-disabled`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Focus    | Drop zone container | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Hover    | Drop zone container | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| Drop zone | Any                   | Hover    | Drop zone text      | text-color       | `link-primary`     | Carbon File uploader style | Interactive state color | Documented anomaly  | Public docs omit `$`; preserve exact and verify before standardizing.         |
| File item | Any                   | Default  | Delete icon         | svg              | `$icon-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| File item | Any                   | Default  | Divider             | border           | `$border-subtle`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Default  | File container      | background-color | `$field`           | Carbon File uploader style | Color                   | Documented          | Contextual token.                                                             |
| File item | Any                   | Default  | File name           | text-color       | `$text-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| File item | Any                   | Error    | Error message       | text-color       | `$text-error`      | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Error    | Error title         | text-color       | `$text-primary`    | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Focus    | Delete icon         | border           | `$focus`           | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Invalid  | File container      | border           | `$support-error`   | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Loading  | Loader              | token family     | See inline loading | Carbon File uploader style | Interactive state color | Documented guidance | Delegates to Inline loading token mappings.                                   |
| File item | Any                   | Uploaded | Checkmark           | svg              | `$interactive`     | Carbon File uploader style | Interactive state color | Documented          | Public-doc row.                                                               |
| File item | Any                   | Warning  | Warning icon        | svg              | `$support-error`   | Carbon File uploader style | Interactive state color | Documented anomaly  | Public docs show support-error for warning icon; verify before standardizing. |
| Standard  | Any                   | Default  | Button              | token family     | See primary button | Carbon File uploader style | Color                   | Documented guidance | Delegates to Button token mappings.                                           |
| Standard  | Any                   | Default  | Description         | text-color       | `$text-secondary`  | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |
| Standard  | Any                   | Default  | Heading             | text-color       | `$text-primary`    | Carbon File uploader style | Color                   | Documented          | Public-doc row.                                                               |

### 7.3. Overlays, feedback, status, and AI

#### 7.3.1. Notification

Coverage status: Confirmed row-level mappings.

| Variant       | Mode / Size / Density | State       | Anatomy element | Property         | Color token                              | Source page        | Source section | Confidence | Notes |
| ------------- | --------------------- | ----------- | --------------- | ---------------- | ---------------------------------------- | ------------------ | -------------- | ---------- | ----- |
| High contrast | Any                   | Enabled     | Background      | background-color | `$background-inverse`                    | Notification style | High contrast  | Documented |       |
| High contrast | Any                   | Error       | Border-left     | border-left      | `$support-error-inverse`                 | Notification style | High contrast  | Documented |       |
| High contrast | Any                   | Information | Border-left     | border-left      | `$support-info-inverse`                  | Notification style | High contrast  | Documented |       |
| High contrast | Any                   | Success     | Border-left     | border-left      | `$support-success-inverse`               | Notification style | High contrast  | Documented |       |
| High contrast | Any                   | Warning     | Border-left     | border-left      | `$support-warning-inverse`               | Notification style | High contrast  | Documented |       |
| Low contrast  | Any                   | Error       | Notification    | background-color | `$notification-error-background-color`   | Notification style | Low contrast   | Documented |       |
| Low contrast  | Any                   | Information | Notification    | background-color | `$notification-info-background-color`    | Notification style | Low contrast   | Documented |       |
| Low contrast  | Any                   | Success     | Notification    | background-color | `$notification-success-background-color` | Notification style | Low contrast   | Documented |       |
| Low contrast  | Any                   | Warning     | Notification    | background-color | `$notification-warning-background-color` | Notification style | Low contrast   | Documented |       |


#### 7.3.2. Modal

Coverage status: Confirmed row-level mappings.

| Variant                 | Mode / Size / Density | State      | Anatomy element               | Property         | Color token        | Source page | Source section | Confidence | Notes |
| ----------------------- | --------------------- | ---------- | ----------------------------- | ---------------- | ------------------ | ----------- | -------------- | ---------- | ----- |
| AI variant              | Any                   | AI present | Linear gradient border bottom | border end       | `$ai-border-end`   | Modal style | AI presence    | Documented |       |
| AI variant              | Any                   | AI present | Linear gradient border top    | border start     | `$ai-border-start` | Modal style | AI presence    | Documented |       |
| AI variant              | Any                   | AI present | Modal background              | box-shadow       | `$ai-drop-shadow`  | Modal style | AI presence    | Documented |       |
| AI variant              | Any                   | AI present | Modal background              | inner-shadow     | `$ai-inner-shadow` | Modal style | AI presence    | Documented |       |
| AI variant              | Any                   | AI present | Overlay                       | background-color | `$ai-overlay`      | Modal style | AI presence    | Documented |       |
| Passive / transactional | Any                   | Enabled    | Container                     | background-color | `$layer`           | Modal style | Color          | Documented |       |
| Passive / transactional | Any                   | Enabled    | Container                     | border           | `$border-subtle`   | Modal style | Color          | Documented |       |
| Passive / transactional | Any                   | Enabled    | Page overlay                  | color            | `$overlay`         | Modal style | Color          | Documented |       |
| Passive / transactional | Any                   | Hover      | Close icon                    | background-color | `$layer-hover`     | Modal style | Color          | Documented |       |


#### 7.3.3. Popover

Coverage status: Partial / verification required.

| Variant               | Mode / Size / Density | State   | Anatomy element | Property         | Color token           | Source page   | Source section | Confidence         | Notes |
| --------------------- | --------------------- | ------- | --------------- | ---------------- | --------------------- | ------------- | -------------- | ------------------ | ----- |
| Any                   | Any                   | Enabled | Container       | background-color | `$layer`              | Popover style | Color          | Documented         |       |
| Inverse / unspecified | Any                   | Enabled | Container       | background-color | `$background-inverse` | Popover style | Color          | Needs verification |       |


#### 7.3.4. Tooltip

Coverage status: Confirmed row-level mappings.

| Variant            | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page   | Source section          | Confidence | Notes |
| ------------------ | --------------------- | ---------- | --------------- | ---------------- | --------------------- | ------------- | ----------------------- | ---------- | ----- |
| Definition tooltip | Any                   | Focus open | Border          | border           | `$focus`              | Tooltip style | Interactive state color | Documented |       |
| Definition tooltip | Any                   | Hover open | Border-bottom   | border           | `$border-interactive` | Tooltip style | Interactive state color | Documented |       |
| Open               | Any                   | Enabled    | Container       | background-color | `$background-inverse` | Tooltip style | Interactive state color | Documented |       |
| Open               | Any                   | Enabled    | Text            | text-color       | `$text-inverse`       | Tooltip style | Interactive state color | Documented |       |


#### 7.3.5. Toggletip

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State        | Anatomy element | Property         | Color token           | Source page     | Source section          | Confidence | Notes |
| -------- | --------------------- | ------------ | --------------- | ---------------- | --------------------- | --------------- | ----------------------- | ---------- | ----- |
| Standard | Any                   | Closed       | Trigger button  | svg              | `$icon-secondary`     | Toggletip style | Color                   | Documented |       |
| Standard | Any                   | Focus        | Border          | border           | `$focus`              | Toggletip style | Interactive state color | Documented |       |
| Standard | Any                   | Hover closed | Trigger button  | svg              | `$icon-primary`       | Toggletip style | Interactive state color | Documented |       |
| Standard | Any                   | Open         | Container       | background-color | `$background-inverse` | Toggletip style | Color                   | Documented |       |
| Standard | Any                   | Open         | Text            | color            | `$text-inverse`       | Toggletip style | Color                   | Documented |       |


#### 7.3.6. Loading

Coverage status: Confirmed row-level mappings.

| Variant       | Mode / Size / Density | State   | Anatomy element      | Property         | Color token     | Source page          | Source section | Confidence | Notes |
| ------------- | --------------------- | ------- | -------------------- | ---------------- | --------------- | -------------------- | -------------- | ---------- | ----- |
| Large         | Large                 | Default | Indicator            | stroke           | `$interactive`  | Carbon Loading style | Color          | Documented |       |
| Large / Small | Any                   | Enabled | Indicator            | stroke           | `$interactive`  | Loading style        | Color          | Documented |       |
| Page overlay  | Any                   | Default | Overlay              | background-color | `$overlay`      | Carbon Loading style | Color          | Documented |       |
| Page overlay  | Any                   | Enabled | Overlay              | background-color | `$overlay`      | Loading style        | Color          | Documented |       |
| Small         | Any                   | Enabled | Indicator background | background-color | `$layer-accent` | Loading style        | Color          | Documented |       |
| Small         | Small                 | Default | Indicator            | stroke           | `$interactive`  | Carbon Loading style | Color          | Documented |       |
| Small         | Small                 | Default | Indicator background | background-color | `$layer-accent` | Carbon Loading style | Color          | Documented |       |


#### 7.3.7. Inline loading

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State   | Anatomy element             | Property | Color token           | Source page          | Source section | Confidence | Notes |
| -------- | --------------------- | ------- | --------------------------- | -------- | --------------------- | -------------------- | -------------- | ---------- | ----- |
| Finished | Any                   | Success | Status icon                 | svg      | `$support-success`    | Inline loading style | Color          | Documented |       |
| Standard | Any                   | Enabled | Text                        | color    | `$text-secondary`     | Inline loading style | Color          | Documented |       |
| Standard | Any                   | Loading | `.cds--loading__background` | stroke   | `$border-subtle`      | Inline loading style | Color          | Documented |       |
| Standard | Any                   | Loading | `.cds--loading__stroke`     | stroke   | `$border-interactive` | Inline loading style | Color          | Documented |       |


#### 7.3.8. Progress indicator

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State       | Anatomy element | Property         | Color token           | Source page              | Source section     | Confidence | Notes |
| -------- | --------------------- | ----------- | --------------- | ---------------- | --------------------- | ------------------------ | ------------------ | ---------- | ----- |
| Standard | Any                   | Active      | Step line       | background-color | `$border-interactive` | Progress indicator style | Color              | Documented |       |
| Standard | Any                   | Complete    | Icon            | fill             | `$interactive`        | Progress indicator style | Color              | Documented |       |
| Standard | Any                   | Disabled    | Icon            | fill             | `$icon-disabled`      | Progress indicator style | Interactive states | Documented |       |
| Standard | Any                   | Error       | Icon            | fill             | `$support-error`      | Progress indicator style | Interactive states | Documented |       |
| Standard | Any                   | Not started | Icon            | fill             | `$icon-primary`       | Progress indicator style | Color              | Documented |       |


#### 7.3.9. Progress bar

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State   | Anatomy element | Property   | Color token           | Source page        | Source section | Confidence | Notes |
| -------- | --------------------- | ------- | --------------- | ---------- | --------------------- | ------------------ | -------------- | ---------- | ----- |
| Standard | Big / Small           | Active  | Bar             | background | `$border-interactive` | Progress bar style | Color          | Documented |       |
| Standard | Big / Small           | Error   | Bar             | background | `$support-error`      | Progress bar style | Color          | Documented |       |
| Standard | Big / Small           | Success | Bar             | background | `$support-success`    | Progress bar style | Color          | Documented |       |


#### 7.3.10. AI label

Coverage status: Confirmed row-level mappings.

| Variant                | Mode / Size / Density | State   | Anatomy element         | Property   | Color token              | Source page    | Source section               | Confidence | Notes |
| ---------------------- | --------------------- | ------- | ----------------------- | ---------- | ------------------------ | -------------- | ---------------------------- | ---------- | ----- |
| Default                | xl / sm–lg / 2xs–mini | Enabled | Text                    | text color | `$text-primary`          | AI label style | Default color                | Documented |       |
| Default                | xl / sm–lg / 2xs–mini | Focus   | Button                  | border     | `$focus`                 | AI label style | Default color                | Documented |       |
| Default                | xl / sm–lg / 2xs–mini | Hover   | Button                  | background | `$background-inverse`    | AI label style | Default color                | Documented |       |
| Explainability popover | Any                   | Enabled | Linear gradient         | end        | `$ai-aura-end`           | AI label style | Explainability popover color | Documented |       |
| Explainability popover | Any                   | Enabled | Linear gradient         | start      | `$ai-aura-start`         | AI label style | Explainability popover color | Documented |       |
| Explainability popover | Any                   | Enabled | Popover background      | background | `$ai-popover-background` | AI label style | Explainability popover color | Documented |       |
| Explainability popover | Any                   | Enabled | Popover border gradient | end        | `$ai-border-end`         | AI label style | Explainability popover color | Documented |       |
| Explainability popover | Any                   | Enabled | Popover border gradient | start      | `$ai-border-start`       | AI label style | Explainability popover color | Documented |       |
| Inline                 | lg / md / sm          | Enabled | Dot                     | fill       | `$icon-primary`          | AI label style | Inline color                 | Documented |       |

### 7.4. Data display, collection, and structure

#### 7.4.1. Data table

Coverage status: Confirmed row-level mappings.

| Variant          | Mode / Size / Density | State            | Anatomy element          | Property         | Color token             | Source page             | Source section                 | Confidence | Notes |
| ---------------- | --------------------- | ---------------- | ------------------------ | ---------------- | ----------------------- | ----------------------- | ------------------------------ | ---------- | ----- |
| AI presence      | Entire table          | Default          | Gradient background      | start            | `$ai-aura-start-sm`     | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Gradient background      | stop             | `$ai-aura-stop`         | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Gradient border          | bottom           | `$ai-border-end`        | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Gradient border          | top              | `$ai-border-start`      | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Table background         | background-color | `$layer`                | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Table surface            | box-shadow       | `$ai-drop-shadow`       | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Entire table          | Default          | Table surface            | inner-shadow     | `$ai-inner-shadow`      | Carbon Data table style | AI presence — Entire table     | Documented |       |
| AI presence      | Rows and columns      | Default          | Gradient background      | start            | `$ai-aura-start-sm`     | Carbon Data table style | AI presence — Rows and columns | Documented |       |
| AI presence      | Rows and columns      | Default          | Gradient background      | stop             | `$ai-aura-stop`         | Carbon Data table style | AI presence — Rows and columns | Documented |       |
| AI presence      | Rows and columns      | Default          | Gradient border          | left, top        | `$ai-border-strong`     | Carbon Data table style | AI presence — Rows and columns | Documented |       |
| AI variant       | Entire table          | AI present       | Entire table             | box-shadow       | `$ai-drop-shadow`       | Data table style        | AI presence                    | Documented |       |
| AI variant       | Entire table          | AI present       | Entire table             | inner-shadow     | `$ai-inner-shadow`      | Data table style        | AI presence                    | Documented |       |
| AI variant       | Rows and columns      | AI present       | Gradient border left/top | border           | `$ai-border-strong`     | Data table style        | AI presence                    | Documented |       |
| Batch action bar | Any                   | Enabled          | Bar                      | background-color | `$background-brand`     | Data table style        | Batch action bar               | Documented |       |
| Batch action bar | Any                   | Enabled          | Summary                  | text-color       | `$text-on-color`        | Data table style        | Batch action bar               | Documented |       |
| Standard         | Any                   | Enabled          | Column header            | background-color | `$layer-accent`         | Data table style        | Column header                  | Documented |       |
| Standard         | Any                   | Enabled          | Row                      | background-color | `$layer`                | Data table style        | Row                            | Documented |       |
| Standard         | Any                   | Enabled          | Table header             | background-color | `$layer`                | Data table style        | Table header                   | Documented |       |
| Standard         | Any                   | Enabled          | Title                    | text-color       | `$text-primary`         | Data table style        | Table header                   | Documented |       |
| Standard         | Any                   | Hover            | Column header            | background-color | `$layer-accent-hover`   | Data table style        | Column header                  | Documented |       |
| Standard         | Any                   | Selected         | Row                      | background-color | `$layer-selected`       | Data table style        | Row                            | Documented |       |
| Standard         | Any                   | Selected + hover | Row                      | background-color | `$layer-selected-hover` | Data table style        | Row                            | Documented |       |
| Standard         | Any                   | Zebra            | Row                      | background-color | `$layer-accent`         | Data table style        | Row                            | Documented |       |


#### 7.4.2. Structured list

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State    | Anatomy element | Property         | Color token       | Source page           | Source section                     | Confidence | Notes |
| --------------- | --------------------- | -------- | --------------- | ---------------- | ----------------- | --------------------- | ---------------------------------- | ---------- | ----- |
| Default         | Hang / Flush          | Enabled  | Divider         | border-bottom    | `$border-subtle`  | Structured list style | Default color                      | Documented |       |
| Default         | Hang / Flush          | Enabled  | Row text        | text color       | `$text-secondary` | Structured list style | Default color                      | Documented |       |
| Selectable      | Feature-flagged       | Disabled | Row text        | text color       | `$text-disabled`  | Structured list style | Selectable interactive state color | Documented |       |
| Selectable      | Feature-flagged       | Focus    | Row             | border           | `$focus`          | Structured list style | Selectable interactive state color | Documented |       |
| Selectable      | Feature-flagged       | Hover    | Row             | background-color | `$layer-hover`    | Structured list style | Selectable interactive state color | Documented |       |
| Selectable      | Feature-flagged       | Selected | Row             | background-color | `$layer-selected` | Structured list style | Selectable interactive state color | Documented |       |
| With background | Feature-flagged       | Enabled  | Header / Row    | background-color | `$layer`          | Structured list style | With background color              | Documented |       |


#### 7.4.3. Contained list

Coverage status: Confirmed row-level mappings.

| Variant             | Mode / Size / Density | State   | Anatomy element    | Property         | Color token       | Source page          | Source section     | Confidence | Notes |
| ------------------- | --------------------- | ------- | ------------------ | ---------------- | ----------------- | -------------------- | ------------------ | ---------- | ----- |
| Disclosed           | Any                   | Enabled | Title background   | background-color | `$layer`          | Contained list style | Color              | Documented |       |
| On-page             | Any                   | Enabled | Title background   | background-color | `$background`     | Contained list style | Color              | Documented |       |
| On-page / Disclosed | Any                   | Enabled | Disclosed title    | text color       | `$text-secondary` | Contained list style | Color              | Documented |       |
| On-page / Disclosed | Any                   | Enabled | List title on-page | text color       | `$text-primary`   | Contained list style | Color              | Documented |       |
| Standard            | Any                   | Active  | Row                | background-color | `$layer-active`   | Contained list style | Interactive states | Documented |       |
| Standard            | Any                   | Focus   | Row                | border           | `$focus`          | Contained list style | Interactive states | Documented |       |
| Standard            | Any                   | Hover   | Row                | background-color | `$layer-hover`    | Contained list style | Interactive states | Documented |       |


#### 7.4.4. List

Coverage status: Confirmed row-level mappings.

| Variant             | Mode / Size / Density | State   | Anatomy element | Property   | Color token     | Source page       | Source section | Confidence | Notes |
| ------------------- | --------------------- | ------- | --------------- | ---------- | --------------- | ----------------- | -------------- | ---------- | ----- |
| Ordered / unordered | Any                   | Default | Item            | text-color | `$text-primary` | Carbon List style | Color          | Documented |       |
| Ordered / unordered | Any                   | Enabled | Item            | text-color | `$text-primary` | List style        | Color          | Documented |       |


#### 7.4.5. Tile

Coverage status: Confirmed row-level mappings.

| Variant         | Mode / Size / Density | State      | Anatomy element        | Property         | Color token         | Source page | Source section                          | Confidence | Notes |
| --------------- | --------------------- | ---------- | ---------------------- | ---------------- | ------------------- | ----------- | --------------------------------------- | ---------- | ----- |
| AI variant      | Any                   | AI present | Linear gradient        | start            | `$ai-aura-start`    | Tile style  | AI presence                             | Documented |       |
| AI variant      | Any                   | AI present | Linear gradient border | stop             | `$ai-border-stop`   | Tile style  | AI presence                             | Documented |       |
| AI variant      | Any                   | AI present | Tile background        | box-shadow       | `$ai-drop-shadow`   | Tile style  | AI presence                             | Documented |       |
| Base tile       | Any                   | Enabled    | Container              | background-color | `$layer`            | Tile style  | Base tile color                         | Documented |       |
| Clickable tile  | Feature-flagged       | Enabled    | Border                 | border           | `$border-tile`      | Tile style  | Clickable tile color                    | Documented |       |
| Clickable tile  | Feature-flagged       | Enabled    | Icon                   | svg              | `$icon-interactive` | Tile style  | Clickable tile color                    | Documented |       |
| Clickable tile  | Feature-flagged       | Hover      | Container              | background-color | `$layer-hover`      | Tile style  | Clickable tile interactive state color  | Documented |       |
| Expandable tile | Feature-flagged       | Disabled   | Container              | border           | `$border-disabled`  | Tile style  | Expandable tile interactive state color | Documented |       |
| Selectable tile | Feature-flagged       | Selected   | Container              | border           | `$border-inverse`   | Tile style  | Selectable tile interactive state color | Documented |       |


#### 7.4.6. Tree view

Coverage status: Confirmed row-level mappings.

| Variant  | Mode / Size / Density | State    | Anatomy element | Property         | Color token           | Source page     | Source section             | Confidence | Notes |
| -------- | --------------------- | -------- | --------------- | ---------------- | --------------------- | --------------- | -------------------------- | ---------- | ----- |
| Standard | Any                   | Disabled | Label           | text-color       | `$text-disabled`      | Tree view style | Interactive states         | Documented |       |
| Standard | Any                   | Enabled  | Label           | text color       | `$text-secondary`     | Tree view style | Color / Interactive states | Documented |       |
| Standard | Any                   | Enabled  | Node            | background-color | `$layer`              | Tree view style | Color                      | Documented |       |
| Standard | Any                   | Hover    | Node            | background-color | `$layer-hover`        | Tree view style | Interactive states         | Documented |       |
| Standard | Any                   | Selected | Node            | background-color | `$layer-selected`     | Tree view style | Interactive states         | Documented |       |
| Standard | Any                   | Selected | Node            | border-left      | `$border-interactive` | Tree view style | Interactive states         | Documented |       |


#### 7.4.7. Code snippet

Coverage status: Confirmed row-level mappings.

| Variant        | Mode / Size / Density | State   | Anatomy element | Property         | Color token     | Source page        | Source section | Confidence | Notes |
| -------------- | --------------------- | ------- | --------------- | ---------------- | --------------- | ------------------ | -------------- | ---------- | ----- |
| Inline snippet | Any                   | Active  | Container       | background-color | `$layer-active` | Code snippet style | Inline snippet | Documented |       |
| Inline snippet | Any                   | Hover   | Container       | background-color | `$layer-hover`  | Code snippet style | Inline snippet | Documented |       |
| Multi-line     | Any                   | Enabled | Icon            | svg              | `$icon-primary` | Code snippet style | Multi-line     | Documented |       |
| Single line    | Any                   | Enabled | Container       | background       | `$layer`        | Code snippet style | Single line    | Documented |       |
| Single line    | Any                   | Focus   | Container       | border           | `$focus`        | Code snippet style | Single line    | Documented |       |


#### 7.4.8. Tag

Coverage status: Partial / verification required.

| Variant     | Mode / Size / Density | State    | Anatomy element          | Property         | Color token                                                          | Source page      | Source section          | Confidence          | Notes                                                                                                |
| ----------- | --------------------- | -------- | ------------------------ | ---------------- | -------------------------------------------------------------------- | ---------------- | ----------------------- | ------------------- | ---------------------------------------------------------------------------------------------------- |
| AI presence | All variants          | Default  | AI label                 | text/icon color  | Match tag text color                                                 | Carbon Tag style | AI presence             | Documented guidance | No separate Tag AI color token mapping; AI label size is small and padding-right uses `$spacing-02`. |
| Dismissible | All colors            | Default  | Background               | background-color | See component token family                                           | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens but do not expose every exact all-color token row.             |
| Dismissible | All colors            | Disabled | Background               | background-color | `$layer`                                                             | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Dismissible | All colors            | Disabled | Text                     | text-color       | `$text-disabled`                                                     | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Dismissible | All colors            | Enabled  | Background               | background-color | `See all component color tokens`                                     | Tag style        | Color                   | Needs verification  |                                                                                                      |
| Dismissible | All colors            | Focus    | Container                | border           | `$focus`                                                             | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Dismissible | All colors            | Hover    | Background               | background-color | See component token family                                           | Carbon Tag style | Interactive state color | Documented guidance | Public docs point to component hover tokens.                                                         |
| Dismissible | High contrast         | Enabled  | Border                   | border           | `$border-inverse`                                                    | Tag style        | Color                   | Documented          |                                                                                                      |
| Dismissible | High contrast         | Focus    | Container                | border           | `$focus`                                                             | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Dismissible | High contrast         | Hover    | Background               | background-color | `$background-hover`                                                  | Carbon Tag style | Interactive state color | Documented          | High contrast exception.                                                                             |
| Dismissible | Outline               | Disabled | Background               | background-color | `$background-disabled`                                               | Carbon Tag style | Interactive state color | Documented          | Core disabled background.                                                                            |
| Dismissible | Outline               | Disabled | Border                   | border           | `$border-disabled`                                                   | Carbon Tag style | Interactive state color | Documented          | Core disabled border.                                                                                |
| Dismissible | Outline               | Disabled | Text                     | text-color       | `$text-disabled`                                                     | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Dismissible | Outline               | Enabled  | Background               | background-color | `$background`                                                        | Tag style        | Color                   | Documented          |                                                                                                      |
| Dismissible | Outline               | Hover    | Background               | background-color | `$background-hover`                                                  | Carbon Tag style | Interactive state color | Documented          | Outline exception.                                                                                   |
| Operational | All colors            | Default  | Text / icon / background | token family     | See component token family                                           | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens.                                                               |
| Operational | All colors            | Disabled | Background               | background-color | `$layer`                                                             | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Operational | All colors            | Disabled | Border                   | border           | `$border-disabled`                                                   | Carbon Tag style | Interactive state color | Documented          | Core disabled border.                                                                                |
| Operational | All colors            | Disabled | Text                     | text-color       | `$text-disabled`                                                     | Carbon Tag style | Interactive state color | Documented          | Core disabled text.                                                                                  |
| Operational | All colors            | Focus    | Container                | border           | `$focus`                                                             | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Operational | All colors            | Hover    | Background               | background-color | See component token family                                           | Carbon Tag style | Interactive state color | Documented guidance | Public docs point to component hover tokens.                                                         |
| Read-only   | All colors            | Default  | Text / icon / background | token family     | See component token family                                           | Carbon Tag style | Color                   | Documented guidance | Public docs point to component tokens but do not expose every exact all-color token row.             |
| Read-only   | All colors            | Enabled  | Text                     | text-color       | `See all component color tokens`                                     | Tag style        | Color                   | Needs verification  |                                                                                                      |
| Read-only   | High contrast         | Default  | Background               | background-color | `$background-inverse`                                                | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | High contrast         | Default  | Border                   | border           | `$border-inverse`                                                    | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | High contrast         | Default  | Icon                     | svg              | `$icon-color`                                                        | Carbon Tag style | Color                   | Documented anomaly  | Public docs show `$icon-color`; verify against source before standardizing.                          |
| Read-only   | High contrast         | Default  | Text                     | text-color       | `$text-inverse`                                                      | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | High contrast         | Enabled  | Background               | background-color | `$background-inverse`                                                | Tag style        | Color                   | Documented          |                                                                                                      |
| Read-only   | High contrast         | Enabled  | Text                     | text-color       | `$text-inverse`                                                      | Tag style        | Color                   | Documented          |                                                                                                      |
| Read-only   | Outline               | Default  | Background               | background-color | `$background`                                                        | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | Outline               | Default  | Border                   | border           | `$border-inverse`                                                    | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | Outline               | Default  | Icon                     | svg              | `$icon-primary`                                                      | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | Outline               | Default  | Text                     | text-color       | `$text-primary`                                                      | Carbon Tag style | Color                   | Documented          | Core-token exception.                                                                                |
| Read-only   | Outline               | Enabled  | Text                     | text-color       | `$text-primary`                                                      | Tag style        | Color                   | Documented          |                                                                                                      |
| Selectable  | Any                   | Enabled  | Token model note         | token family     | `Core tokens only; exact row mapping not surfaced on inspected page` | Tag style        | Color                   | Needs verification  |                                                                                                      |
| Selectable  | Standard              | Default  | Background               | background-color | `$layer`                                                             | Carbon Tag style | Color                   | Documented          | Contextual layer token.                                                                              |
| Selectable  | Standard              | Default  | Border                   | border           | `$border-inverse`                                                    | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Selectable  | Standard              | Default  | Icon                     | svg              | `$icon-primary`                                                      | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Selectable  | Standard              | Default  | Text                     | text-color       | `$text-primary`                                                      | Carbon Tag style | Color                   | Documented          | Selectable uses core tokens only.                                                                    |
| Selectable  | Standard              | Disabled | Background               | background-color | `$layer`                                                             | Carbon Tag style | Interactive state color | Documented          | Contextual layer token.                                                                              |
| Selectable  | Standard              | Disabled | Border                   | border           | `$border-disabled`                                                   | Carbon Tag style | Interactive state color | Documented          | Disabled state.                                                                                      |
| Selectable  | Standard              | Disabled | Text                     | text-color       | `$text-disabled`                                                     | Carbon Tag style | Interactive state color | Documented          | Disabled state.                                                                                      |
| Selectable  | Standard              | Focus    | Container                | border           | `$focus`                                                             | Carbon Tag style | Interactive state color | Documented          | Core focus token.                                                                                    |
| Selectable  | Standard              | Hover    | Background               | background-color | `$layer-hover`                                                       | Carbon Tag style | Interactive state color | Documented          | Contextual layer hover.                                                                              |
| Selectable  | Standard              | Selected | Background               | background-color | `$background-inverse`                                                | Carbon Tag style | Interactive state color | Documented          | Selected state.                                                                                      |
| Selectable  | Standard              | Selected | Text                     | text-color       | `$text-inverse`                                                      | Carbon Tag style | Interactive state color | Documented          | Selected state.                                                                                      |


#### 7.4.9. Form

Coverage status: Confirmed row-level mappings.

| Variant     | Mode / Size / Density | State   | Anatomy element     | Property         | Color token         | Source page       | Source section | Confidence | Notes |
| ----------- | --------------------- | ------- | ------------------- | ---------------- | ------------------- | ----------------- | -------------- | ---------- | ----- |
| AI presence | Form surface          | Default | Form background     | background-color | `$layer`            | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Form surface        | box-shadow       | `$ai-drop-shadow`   | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Form surface        | inner-shadow     | `$ai-inner-shadow`  | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Gradient background | start            | `$ai-aura-start-sm` | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Gradient background | stop             | `$ai-aura-stop`     | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Gradient border     | bottom           | `$ai-border-end`    | Carbon Form style | AI presence    | Documented |       |
| AI presence | Form surface          | Default | Gradient border     | top              | `$ai-border-start`  | Carbon Form style | AI presence    | Documented |       |


## 8. Pattern color-token mappings

Pattern rows remain intentionally separate from Component rows because they describe composition-level semantics, not reusable component primitives.

### 8.1. Read-only states

Coverage status: Confirmed row-level mappings retained from original inventory.

| Variant                   | Mode / Size / Density | State     | Anatomy element              | Property    | Color token      | Source page                     | Source section            | Confidence | Notes |
| ------------------------- | --------------------- | --------- | ---------------------------- | ----------- | ---------------- | ------------------------------- | ------------------------- | ---------- | ----- |
| Read-only signifier icons | Any                   | Read-only | Chevron/close/calendar icons | color token | `$icon-disabled` | Carbon Read-only states pattern | Component icon signifiers | Documented |       |

### 8.2. Status indicators

Coverage status: Confirmed row-level mappings retained from original inventory.

| Variant         | Mode / Size / Density | State                                           | Anatomy element      | Property | Color token                                | Source page                      | Source section           | Confidence | Notes |
| --------------- | --------------------- | ----------------------------------------------- | -------------------- | -------- | ------------------------------------------ | -------------------------------- | ------------------------ | ---------- | ----- |
| Icon indicator  | Any                   | Caution major                                   | Status indicator     | token    | `$status-orange`                           | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Caution major                                   | Status label pairing | token    | `$black`                                   | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Caution minor                                   | Status indicator     | token    | `$status-yellow`                           | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Caution minor                                   | Status label pairing | token    | `$black`                                   | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Failed                                          | Status indicator     | token    | `$status-red`                              | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Normal / In progress / Incomplete / Informative | Status indicator     | token    | `$status-blue`                             | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Not started / Pending / Unknown                 | Status indicator     | token    | `$status-gray`                             | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Succeeded                                       | Status indicator     | token    | `$status-green`                            | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Icon indicator  | Any                   | Undefined                                       | Status indicator     | token    | `$status-purple`                           | Carbon Status indicators pattern | Icon indicator statuses  | Documented |       |
| Shape indicator | Any                   | Low / Cautious                                  | Shape indicator      | token    | `$status-yellow`, `$status-yellow-outline` | Carbon Status indicators pattern | Shape indicator statuses | Documented |       |
| Shape indicator | Any                   | Medium                                          | Shape indicator      | token    | `$status-orange`, `$status-orange-outline` | Carbon Status indicators pattern | Shape indicator statuses | Documented |       |


## 9. Element and support color-token mappings

### 9.1. Skeleton

Coverage status: Partial support mapping.

| Variant     | Mode / Size / Density | State   | Anatomy element                | Property            | Color token                      | Source page            | Source section      | Confidence      | Notes                                                                 |
| ----------- | --------------------- | ------- | ------------------------------ | ------------------- | -------------------------------- | ---------------------- | ------------------- | --------------- | --------------------------------------------------------------------- |
| AI skeleton | Any                   | Loading | AI skeleton background         | background-color    | `$ai-skeleton-background`        | Official Carbon source | AI skeleton styles  | Source-inferred | Keep AI-only.                                                         |
| AI skeleton | Any                   | Loading | AI skeleton element background | background/gradient | `ai-skeleton-element-background` | Official Carbon source | AI skeleton utility | Source-inferred | Keep AI-only; exact public token spelling needs package verification. |
| Standard    | Any                   | Loading | Skeleton container             | background-color    | `$skeleton-background`           | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |
| Standard    | Any                   | Loading | Skeleton element               | background-color    | `$skeleton-element`              | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |


## 10. UI shell and side nav disposition

## 11. UI shell and side nav cleanup

### 11.1. Current public documentation finding

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

### 11.2. Legacy style documentation finding

Legacy v10 UI shell left-panel style documentation explicitly states that UI shell did not use Carbon theme tokens at that time and instead used IBM Design Language palette values. This is useful historical context, but it is not a current token mapping.

Source:

- `https://v10.carbondesignsystem.com/components/UI-shell-left-panel/style/`

### 11.3. UI shell / side nav disposition

| Family               | Current-doc result                           | Legacy/source result                                                             | Updated disposition                                                                         |
| -------------------- | -------------------------------------------- | -------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| UI shell header      | No row-level current color-token table found | Current usage docs explain shell structure and header role                       | No current token mappings extracted. Keep as unresolved / guidance-only.                    |
| UI shell left panel  | No row-level current color-token table found | Legacy v10 says UI shell did not use Carbon theme tokens and used palette values | Do not convert legacy palette rows into token mappings.                                     |
| UI shell right panel | No row-level current color-token table found | Current usage docs explain right-panel/switcher behavior                         | No current token mappings extracted. Keep as unresolved / guidance-only.                    |
| Side nav             | No standalone current style page resolved    | Current source tree contains side-nav source under UI shell package              | Source follow-up could inspect implementation, but no public-doc mapping is confirmed here. |

### 11.4. UI shell merge guidance

Do not add UI shell or side-nav color mappings to the confirmed mapping table unless a current public style table or official source token usage is reviewed and marked as Source-inferred.

For Login App, shell/navigation color should remain Pattern-owned and app-defined.

## 12. Skeleton state disposition

## 13. Skeleton states cleanup

### 13.1. Public documentation finding

Carbon’s public Color → Tokens page explicitly documents:

| Token                  | Category                 | Purpose                                 | Confidence |
| ---------------------- | ------------------------ | --------------------------------------- | ---------- |
| `$skeleton-element`    | Miscellaneous / skeleton | Skeleton color for text and UI elements | Documented |
| `$skeleton-background` | Miscellaneous / skeleton | Skeleton color for containers           | Documented |

A standalone current public Skeleton component style page was not found in this pass. Skeleton guidance appears through Loading/Loading pattern docs and through component examples rather than a complete row-level Skeleton style table.

### 13.2. Source-inferred skeleton rows

| Area    | Component / Pattern / Element | Variant     | Mode / Size / Density | State   | Anatomy element                | Property            | Color token                      | Source page            | Source section      | Confidence      | Notes                                                                 |
| ------- | ----------------------------- | ----------- | --------------------- | ------- | ------------------------------ | ------------------- | -------------------------------- | ---------------------- | ------------------- | --------------- | --------------------------------------------------------------------- |
| Element | Skeleton                      | Standard    | Any                   | Loading | Skeleton element               | background-color    | `$skeleton-element`              | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |
| Element | Skeleton                      | Standard    | Any                   | Loading | Skeleton container             | background-color    | `$skeleton-background`           | Carbon Color tokens    | Miscellaneous       | Documented      | Public global token.                                                  |
| Element | Skeleton                      | AI skeleton | Any                   | Loading | AI skeleton background         | background-color    | `$ai-skeleton-background`        | Official Carbon source | AI skeleton styles  | Source-inferred | Keep AI-only.                                                         |
| Element | Skeleton                      | AI skeleton | Any                   | Loading | AI skeleton element background | background/gradient | `ai-skeleton-element-background` | Official Carbon source | AI skeleton utility | Source-inferred | Keep AI-only; exact public token spelling needs package verification. |

### 13.3. Skeleton merge guidance

Keep skeleton tokens in the global/miscellaneous color-token section. Keep AI skeleton tokens in the AI/scoped-token section.

Do not create a fake Skeleton component mapping table unless a current public Skeleton style page or official component source is reviewed.

## 14. Coverage matrix after merge

| Family                             | Type      | Rows | Documented rows | Source-inferred rows | Verification rows | Status                          |
| ---------------------------------- | --------- | ---- | --------------- | -------------------- | ----------------- | ------------------------------- |
| Button                             | Component | 42   | 42              | 0                    | 0                 | Confirmed row-level mappings    |
| Menu                               | Component | 10   | 10              | 0                    | 0                 | Confirmed row-level mappings    |
| Overflow menu                      | Component | 5    | 5               | 0                    | 0                 | Confirmed row-level mappings    |
| Link                               | Component | 11   | 11              | 0                    | 0                 | Confirmed row-level mappings    |
| Breadcrumb                         | Component | 6    | 6               | 0                    | 0                 | Confirmed row-level mappings    |
| Tabs                               | Component | 11   | 11              | 0                    | 0                 | Confirmed row-level mappings    |
| Content switcher                   | Component | 37   | 37              | 0                    | 1                 | Partial / verification required |
| Pagination                         | Component | 3    | 3               | 0                    | 0                 | Confirmed row-level mappings    |
| Pagination nav                     | Component | 4    | 4               | 0                    | 0                 | Confirmed row-level mappings    |
| Checkbox                           | Component | 23   | 23              | 0                    | 0                 | Confirmed row-level mappings    |
| Radio button                       | Component | 10   | 10              | 0                    | 0                 | Confirmed row-level mappings    |
| Toggle                             | Component | 13   | 13              | 0                    | 0                 | Confirmed row-level mappings    |
| Search                             | Component | 8    | 8               | 0                    | 0                 | Confirmed row-level mappings    |
| Dropdown                           | Component | 19   | 19              | 0                    | 0                 | Confirmed row-level mappings    |
| Dropdown / Combo box / Multiselect | Component | 11   | 11              | 0                    | 0                 | Confirmed row-level mappings    |
| Select                             | Component | 23   | 23              | 0                    | 0                 | Confirmed row-level mappings    |
| Number input                       | Component | 20   | 20              | 0                    | 0                 | Confirmed row-level mappings    |
| Slider                             | Component | 22   | 22              | 0                    | 0                 | Confirmed row-level mappings    |
| Text input                         | Component | 13   | 13              | 0                    | 0                 | Confirmed row-level mappings    |
| Password input                     | Component | 2    | 2               | 0                    | 0                 | Confirmed row-level mappings    |
| Text area                          | Component | 7    | 7               | 0                    | 0                 | Confirmed row-level mappings    |
| Text input / Text area             | Component | 6    | 6               | 0                    | 0                 | Confirmed row-level mappings    |
| Date picker                        | Component | 11   | 11              | 0                    | 0                 | Confirmed row-level mappings    |
| Date picker calendar               | Component | 5    | 5               | 0                    | 0                 | Confirmed row-level mappings    |
| Time picker                        | Component | 10   | 10              | 0                    | 0                 | Confirmed row-level mappings    |
| Date picker / Time picker          | Component | 4    | 4               | 0                    | 0                 | Confirmed row-level mappings    |
| File uploader                      | Component | 22   | 22              | 0                    | 2                 | Partial / verification required |
| Notification                       | Component | 9    | 9               | 0                    | 0                 | Confirmed row-level mappings    |
| Modal                              | Component | 9    | 9               | 0                    | 0                 | Confirmed row-level mappings    |
| Popover                            | Component | 2    | 1               | 0                    | 1                 | Partial / verification required |
| Tooltip                            | Component | 4    | 4               | 0                    | 0                 | Confirmed row-level mappings    |
| Toggletip                          | Component | 5    | 5               | 0                    | 0                 | Confirmed row-level mappings    |
| Loading                            | Component | 7    | 7               | 0                    | 0                 | Confirmed row-level mappings    |
| Inline loading                     | Component | 4    | 4               | 0                    | 0                 | Confirmed row-level mappings    |
| Progress indicator                 | Component | 5    | 5               | 0                    | 0                 | Confirmed row-level mappings    |
| Progress bar                       | Component | 3    | 3               | 0                    | 0                 | Confirmed row-level mappings    |
| AI label                           | Component | 9    | 9               | 0                    | 0                 | Confirmed row-level mappings    |
| Skeleton                           | Element   | 4    | 2               | 2                    | 0                 | Source-inferred included        |
| Data table                         | Component | 23   | 23              | 0                    | 0                 | Confirmed row-level mappings    |
| Structured list                    | Component | 7    | 7               | 0                    | 0                 | Confirmed row-level mappings    |
| Contained list                     | Component | 7    | 7               | 0                    | 0                 | Confirmed row-level mappings    |
| List                               | Component | 2    | 2               | 0                    | 0                 | Confirmed row-level mappings    |
| Tile                               | Component | 9    | 9               | 0                    | 0                 | Confirmed row-level mappings    |
| Tree view                          | Component | 6    | 6               | 0                    | 0                 | Confirmed row-level mappings    |
| Code snippet                       | Component | 5    | 5               | 0                    | 0                 | Confirmed row-level mappings    |
| Tag                                | Component | 46   | 43              | 0                    | 4                 | Partial / verification required |
| Form                               | Component | 7    | 7               | 0                    | 0                 | Confirmed row-level mappings    |
| Read-only states                   | Pattern   | 1    | 1               | 0                    | 0                 | Confirmed row-level mappings    |
| Skeleton                           | Element   | 4    | 2               | 2                    | 0                 | Source-inferred included        |
| Status indicators                  | Pattern   | 11   | 11              | 0                    | 0                 | Confirmed row-level mappings    |

## 15. Remaining gaps after merge

The merge closes the known Slider and File uploader row-level omissions and expands Tag, Content switcher, AI, Skeleton, and UI shell/side nav dispositions. The following gaps still remain.

| Gap                                                        | Type                   | Status     | Reason                                                                                                                                          |
| ---------------------------------------------------------- | ---------------------- | ---------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| Full public AI token master list                           | AI/scoped token family | Partial    | Public docs/style rows expose many tokens, but a complete machine-readable current public AI token list was not verified.                       |
| UI shell                                                   | Component / Pattern    | Unresolved | Current usage docs reviewed; no current public row-level color-token table found.                                                               |
| Side nav                                                   | Component / Pattern    | Unresolved | No standalone current style page resolved; requires current source review if needed.                                                            |
| Standalone Skeleton component/page                         | Element / Component    | Partial    | Core `$skeleton-element` and `$skeleton-background` are confirmed; standalone style table was not found.                                        |
| Tag all-color component token rows                         | Component              | Partial    | Public docs point to component-token families; exact all-color token names are source-inferred, not fully public-doc rowed.                     |
| Pattern family mappings beyond read-only/status indicators | Pattern                | Partial    | Forms, search, empty states, loading pattern, navigation shell, table toolbar, common actions, and login pattern remain light or guidance-only. |

### 15.1. Verification warnings

The following rows should remain out of hard Login App standards until verified against current Carbon package output or public docs:

| Area                | Verification concern                                                                                             |
| ------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Tag                 | Public docs show `$icon-color` for high-contrast icon; verify before standardizing.                              |
| Tag                 | All-color component token names are source-inferred from `_tag.scss`, not fully rowed in public docs.            |
| Content switcher    | Public docs show `$text-disabled` for selected disabled icon in high contrast; verify before standardizing.      |
| File uploader       | Public docs omit `$` in `link-primary` hover text row.                                                           |
| File uploader       | Public docs map warning icon to `$support-error`; verify whether this is intentional or a documentation issue.   |
| Number input        | Earlier addendum noted missing `$` prefixes in some public-doc rows; verify before standardizing.                |
| Popover             | One inverse container mapping remains marked `Needs verification`.                                               |
| AI tokens           | The full public master AI token catalog was not machine-readably verified; keep AI token adoption gated.         |
| UI shell / side nav | No current public row-level token mappings were found; do not use legacy palette rows as current token evidence. |
| Pattern families    | Pattern coverage remains light outside Read-only states and Status indicators.                                   |

### 15.2. Pattern family gaps still worth researching

| Pattern family                            | Why it remains a gap                                                                                                                                                    |
| ----------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Forms pattern                             | Validation summaries, field grouping, AI presence, fluid style escalation, helper/error/warning/success placement may have guidance but are not fully token-rowed here. |
| Search pattern                            | Active query, no-results, result-count, filter interaction, and status treatment remain pattern-level guidance gaps.                                                    |
| Empty states / no-results                 | Pictogram/icon, title/body, action, unavailable/blocked/empty distinction is not yet row-level mapped.                                                                  |
| Loading pattern                           | Region loading, skeleton, page overlay, delayed-loading, reduced-motion, and handoff behavior are only partially captured through Loading/Skeleton tokens.              |
| Navigation shell pattern                  | Header/left-panel/right-panel composition remains unresolved in current public row-level token terms.                                                                   |
| Table toolbar / batch actions             | Data table batch action rows exist, but broader toolbar/filter summary/pending/disabled composition remains under-extracted.                                            |
| Common actions / destructive confirmation | Action grouping and destructive escalation are component-driven, but pattern-level token rules are not fully mapped.                                                    |
| Login pattern                             | Login form surface, background, brand/illustration, support links, and action hierarchy are not extracted.                                                              |

## 16. Login App conversion guidance

### 16.1. Convert into Color Element roles

Keep global semantic token families and contextual alias concepts in the Color Element standard:

- Background.
- Layer.
- Text.
- Border.
- Field.
- Icon.
- Link.
- Support/status.
- Focus.
- Overlay.
- Skeleton.
- Disabled.
- Inverse.
- Theme and layer behavior.

### 16.2. Convert into Component standards

Keep component-specific mappings in the owning Component standard:

- Button.
- Tag.
- Notification.
- Content switcher.
- Form controls.
- Data table.
- Menu/overflow.
- Modal/popover/tooltip.
- Loading/inline loading/progress.
- Slider/file uploader.

### 16.3. Convert into Pattern standards

Keep composition-level mappings and state placement in the owning Pattern standard:

- Validation summary placement.
- Empty/no-results/blocked state treatment.
- Read-only vs. disabled escalation.
- Status indicator semantics.
- Shell, navigation, form, table toolbar, search/filter, and notification composition.

### 16.4. Do not copy blindly

Do not promote the following into Login App standards without review:

- Carbon component-specific token families.
- Pattern-level status indicator tokens.
- AI tokens.
- Feature-flagged component mappings.
- Source-inferred rows.
- GitHub-only token names.
- Rows marked `Documented anomaly`, `Needs verification`, or `Docs-source conflict`.
- Direct Carbon production class names.
- Carbon Sass module names as app API.

## 17. Source index

### 17.1. URLs collected across merged files

- `https://carbondesignsystem.com/components/UI-shell-header/usage/`
- `https://carbondesignsystem.com/components/UI-shell-left-panel/usage/`
- `https://carbondesignsystem.com/components/UI-shell-right-panel/usage/`
- `https://carbondesignsystem.com/components/ai-label/style/`
- `https://carbondesignsystem.com/components/breadcrumb/style/`
- `https://carbondesignsystem.com/components/button/style/`
- `https://carbondesignsystem.com/components/checkbox/style/`
- `https://carbondesignsystem.com/components/code-snippet/style/`
- `https://carbondesignsystem.com/components/contained-list/style/`
- `https://carbondesignsystem.com/components/content-switcher/style/`
- `https://carbondesignsystem.com/components/data-table/style/`
- `https://carbondesignsystem.com/components/date-picker/style/`
- `https://carbondesignsystem.com/components/dropdown/style/`
- `https://carbondesignsystem.com/components/file-uploader/style/`
- `https://carbondesignsystem.com/components/form/style/`
- `https://carbondesignsystem.com/components/inline-loading/style/`
- `https://carbondesignsystem.com/components/link/style/`
- `https://carbondesignsystem.com/components/list/style/`
- `https://carbondesignsystem.com/components/loading/style/`
- `https://carbondesignsystem.com/components/menu/style/`
- `https://carbondesignsystem.com/components/modal/style/`
- `https://carbondesignsystem.com/components/notification/style/`
- `https://carbondesignsystem.com/components/number-input/style/`
- `https://carbondesignsystem.com/components/overflow-menu/style/`
- `https://carbondesignsystem.com/components/overview/components/`
- `https://carbondesignsystem.com/components/pagination/style/`
- `https://carbondesignsystem.com/components/popover/style/`
- `https://carbondesignsystem.com/components/progress-bar/style/`
- `https://carbondesignsystem.com/components/progress-indicator/style/`
- `https://carbondesignsystem.com/components/radio-button/style/`
- `https://carbondesignsystem.com/components/search/style/`
- `https://carbondesignsystem.com/components/select/style/`
- `https://carbondesignsystem.com/components/slider/style/`
- `https://carbondesignsystem.com/components/structured-list/style/`
- `https://carbondesignsystem.com/components/tabs/style/`
- `https://carbondesignsystem.com/components/tag/style/`
- `https://carbondesignsystem.com/components/text-input/style/`
- `https://carbondesignsystem.com/components/tile/style/`
- `https://carbondesignsystem.com/components/toggle/style/`
- `https://carbondesignsystem.com/components/toggletip/style/`
- `https://carbondesignsystem.com/components/tooltip/style/`
- `https://carbondesignsystem.com/components/tree-view/style/`
- `https://carbondesignsystem.com/elements/color/overview/`
- `https://carbondesignsystem.com/elements/color/tokens/`
- `https://carbondesignsystem.com/elements/themes/overview/`
- `https://carbondesignsystem.com/guidelines/carbon-for-ai/`
- `https://carbondesignsystem.com/guidelines/carbon-for-ai/overview/`
- `https://carbondesignsystem.com/patterns/loading-pattern/`
- `https://carbondesignsystem.com/patterns/overview/`
- `https://carbondesignsystem.com/patterns/read-only-states-pattern/`
- `https://carbondesignsystem.com/patterns/status-indicator-pattern/`
- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_content-switcher.scss`
- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/component-tokens/_tag.scss`
- `https://github.com/carbon-design-system/carbon/blob/main/packages/styles/scss/utilities/_skeleton.scss`
- `https://github.com/carbon-design-system/carbon/issues/13418`
- `https://v10.carbondesignsystem.com/components/UI-shell-left-panel/style/`

## 18. Related Login App standards

| API                       | Route / path                                  |
| ------------------------- | --------------------------------------------- |
| Color Element standard    | `docs/02-standards/ui/elements/color.md`      |
| Foundation Elements index | `docs/02-standards/ui/elements/index.md`      |
| Component Standards index | `docs/02-standards/ui/components/index.md`    |
| Pattern Standards index   | `docs/02-standards/ui/patterns/index.md`      |
| Carbon source notes       | `docs/02-standards/ui/carbon-source-notes.md` |
