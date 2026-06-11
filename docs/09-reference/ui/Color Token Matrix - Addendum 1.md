---
title: Carbon Color Token Mapping Addendum
slug: color-carbon-token-addendum
status: support-reference
api_layer: Foundation Element support reference
canonical_doc: docs/02-standards/ui/elements/color-carbon-token-addendum.md
related_color_standard: docs/02-standards/ui/elements/color.md
source_scope: Carbon Design System public docs and official source references from deep research
generated_from: Carbon Design System Color Token Addendum follow-up research
---

# Carbon Color Token Mapping Addendum
- [1. Document purpose](#1-document-purpose)
- [2. Review and cleanup notes](#2-review-and-cleanup-notes)
  - [2.1. What changed from the uploaded addendum](#21-what-changed-from-the-uploaded-addendum)
  - [2.2. Important audit note](#22-important-audit-note)
  - [2.3. Evidence confidence values](#23-evidence-confidence-values)
- [3. Executive summary](#3-executive-summary)
- [4. Carbon token model clarifications](#4-carbon-token-model-clarifications)
  - [4.1. Component-token family clarifications](#41-component-token-family-clarifications)
  - [4.2. Supplemental global and contextual tokens confirmed in this pass](#42-supplemental-global-and-contextual-tokens-confirmed-in-this-pass)
  - [4.3. AI tokens surfaced directly on current style pages](#43-ai-tokens-surfaced-directly-on-current-style-pages)
- [5. Extraction summary](#5-extraction-summary)
  - [5.1. Mapping-row count by family](#51-mapping-row-count-by-family)
- [6. Action and navigation components](#6-action-and-navigation-components)
  - [6.1. Menu](#61-menu)
  - [6.2. Overflow menu](#62-overflow-menu)
  - [6.3. Link](#63-link)
  - [6.4. Breadcrumb](#64-breadcrumb)
  - [6.5. Tabs](#65-tabs)
  - [6.6. Content switcher](#66-content-switcher)
  - [6.7. Pagination](#67-pagination)
  - [6.8. Pagination nav](#68-pagination-nav)
- [7. Form, selection, and input components](#7-form-selection-and-input-components)
  - [7.1. Search](#71-search)
  - [7.2. Radio button](#72-radio-button)
  - [7.3. Dropdown / Combo box / Multiselect](#73-dropdown--combo-box--multiselect)
  - [7.4. Text input](#74-text-input)
  - [7.5. Password input](#75-password-input)
  - [7.6. Text area](#76-text-area)
  - [7.7. Text input / Text area](#77-text-input--text-area)
  - [7.8. Number input](#78-number-input)
  - [7.9. Select](#79-select)
  - [7.10. Checkbox](#710-checkbox)
  - [7.11. Toggle](#711-toggle)
  - [7.12. Date picker](#712-date-picker)
  - [7.13. Date picker calendar](#713-date-picker-calendar)
  - [7.14. Time picker](#714-time-picker)
  - [7.15. Date picker / Time picker](#715-date-picker--time-picker)
- [8. Overlays, feedback, status, and AI components](#8-overlays-feedback-status-and-ai-components)
  - [8.1. Notification](#81-notification)
  - [8.2. Modal](#82-modal)
  - [8.3. Popover](#83-popover)
  - [8.4. Tooltip](#84-tooltip)
  - [8.5. Toggletip](#85-toggletip)
  - [8.6. Loading](#86-loading)
  - [8.7. Inline loading](#87-inline-loading)
  - [8.8. Progress indicator](#88-progress-indicator)
  - [8.9. Progress bar](#89-progress-bar)
  - [8.10. AI label](#810-ai-label)
- [9. Data display, collection, and tag components](#9-data-display-collection-and-tag-components)
  - [9.1. Data table](#91-data-table)
  - [9.2. Structured list](#92-structured-list)
  - [9.3. Tile](#93-tile)
  - [9.4. Tree view](#94-tree-view)
  - [9.5. Contained list](#95-contained-list)
  - [9.6. Code snippet](#96-code-snippet)
  - [9.7. List](#97-list)
  - [9.8. Tag](#98-tag)
- [10. Pattern mapping status](#10-pattern-mapping-status)
  - [10.1. Pattern evidence retained from the prior inventory](#101-pattern-evidence-retained-from-the-prior-inventory)
- [11. Coverage status and source-page audit](#11-coverage-status-and-source-page-audit)
  - [11.1. Coverage status table](#111-coverage-status-table)
  - [11.2. Source URL index](#112-source-url-index)
- [12. Remaining gaps after this addendum](#12-remaining-gaps-after-this-addendum)
  - [12.1. Highest-priority remaining gaps](#121-highest-priority-remaining-gaps)
  - [12.2. Documentation quality caveats](#122-documentation-quality-caveats)
- [13. Login App merge guidance](#13-login-app-merge-guidance)
  - [13.1. Merge into Color Element standard](#131-merge-into-color-element-standard)
  - [13.2. Merge into Component standards](#132-merge-into-component-standards)
  - [13.3. Merge into Pattern standards](#133-merge-into-pattern-standards)
  - [13.4. Adoption policy fields](#134-adoption-policy-fields)
- [14. Related files](#14-related-files)
- [15. References](#15-references)

## 1. Document purpose

This file is a **support reference** for the Login App 2.0 Color Element standard. It is not the canonical app color-token API and it does not define app-owned token names.

Use this addendum to merge confirmed Carbon color-token evidence into the broader Carbon color inventory. Keep Carbon evidence separated from Login App decisions:

- Carbon global/core tokens may inform app-wide semantic roles.
- Carbon component tokens must remain component-owned evidence.
- Carbon AI tokens must remain AI-scoped evidence.
- Uncertain, malformed, or unresolved mappings must stay out of app standards until verified.

## 2. Review and cleanup notes

### 2.1. What changed from the uploaded addendum

- Removed stale inline deep-research citation artifacts from mapping table cells.
- Added support-reference frontmatter and Login App governance framing.
- Preserved the Carbon evidence model without converting Carbon token names to app token names.
- Split the supplemental mapping inventory into component-family subsections.
- Added an extraction summary and explicit coverage contradictions.
- Kept uncertain rows as `Needs verification` instead of normalizing or guessing.
- Kept unresolved shell, side-nav, and skeleton-state coverage as follow-up work.

### 2.2. Important audit note

The uploaded addendum's coverage table marks **Slider** and **File uploader** as explicit checked pages, but the uploaded mapping tables do not contain row-level Slider or File uploader rows. This file preserves that as a coverage contradiction. Do not treat Slider or File uploader as complete until those row-level mappings are inserted.

### 2.3. Evidence confidence values

| Confidence             | Meaning                                                                                                                                  |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| `Documented`           | The mapping appears as a direct row or token-specific statement in the current Carbon public docs captured by the research pass.         |
| `Needs verification`   | Carbon guidance exists, but exact token names, source rows, or public-doc visibility remain incomplete or uncertain.                     |
| `Source-inferred`      | Mapping came from official source/package files rather than public docs. No source-inferred rows were included in the uploaded addendum. |
| `Docs-source conflict` | Carbon docs and official source disagree. Preserve both values and do not normalize silently.                                            |

## 3. Executive summary

Carbon’s current color model separates global/core tokens, component-specific token families, contextual aliases, and AI-specific tokens. The uploaded addendum confirms that most row-level mappings come from component style pages, while the biggest remaining public-doc gaps are Tag, Content switcher, the full AI-token catalog, and unresolved shell/navigation pages.

The addendum contains **242 row-level component mapping rows**: **238 documented rows** and **4 rows requiring verification after cleanup**. It does not add pattern mapping rows; pattern-level status indicators and read-only-state mappings remain in the prior inventory and should stay in a separate Pattern section.

## 4. Carbon token model clarifications

### 4.1. Component-token family clarifications

| Family           | Scope              | What current docs explicitly say                                                                                                                                                            | Status in this addendum                             | Evidence                                                                                                                            |
| ---------------- | ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Button           | Component-specific | Listed as one of Carbon’s current component-token families, separate from global core tokens                                                                                                | Family confirmed; not re-extracted in this addendum | Color tokens page, “Component Tokens”                                                                                               |
| Content switcher | Component-specific | Listed as a component-token family; style page exposes high-contrast mappings with core tokens, but the accessible public page text did not surface the full component-token name list      | **Partial public enumeration**                      | Color tokens page, “Component Tokens”; Content switcher style page, “High contrast color” / “High contrast interactive state color” |
| Tag              | Component-specific | Read-only, dismissible, and operational tag variants use component tokens; selectable uses only core tokens; high-contrast and outline variants use core tokens instead of component tokens | **Partial public enumeration**                      | Tag style page, “Color”                                                                                                             |
| Notification     | Component-specific | Notification page surfaces explicit component-token names for low-contrast backgrounds                                                                                                      | **Explicitly surfaced**                             | Notification style page, “Low contrast”                                                                                             |

### 4.2. Supplemental global and contextual tokens confirmed in this pass

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

### 4.3. AI tokens surfaced directly on current style pages

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

## 5. Extraction summary

### 5.1. Mapping-row count by family

| Family                             | Group                                         | Rows | Documented rows | Needs verification rows | Coverage note                                                                                |
| ---------------------------------- | --------------------------------------------- | ---- | --------------- | ----------------------- | -------------------------------------------------------------------------------------------- |
| Menu                               | Action and navigation components              | 10   | 10              | 0                       | Mapped rows present                                                                          |
| Overflow menu                      | Action and navigation components              | 5    | 5               | 0                       | Mapped rows present                                                                          |
| Link                               | Action and navigation components              | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Breadcrumb                         | Action and navigation components              | 6    | 6               | 0                       | Mapped rows present                                                                          |
| Tabs                               | Action and navigation components              | 11   | 11              | 0                       | Mapped rows present                                                                          |
| Content switcher                   | Action and navigation components              | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Pagination                         | Action and navigation components              | 3    | 3               | 0                       | Mapped rows present                                                                          |
| Pagination nav                     | Action and navigation components              | 4    | 4               | 0                       | Mapped rows present                                                                          |
| Search                             | Form, selection, and input components         | 8    | 8               | 0                       | Mapped rows present                                                                          |
| Radio button                       | Form, selection, and input components         | 10   | 10              | 0                       | Mapped rows present                                                                          |
| Dropdown / Combo box / Multiselect | Form, selection, and input components         | 11   | 11              | 0                       | Mapped rows present                                                                          |
| Text input                         | Form, selection, and input components         | 6    | 6               | 0                       | Mapped rows present                                                                          |
| Password input                     | Form, selection, and input components         | 2    | 2               | 0                       | Mapped rows present                                                                          |
| Text area                          | Form, selection, and input components         | 3    | 3               | 0                       | Mapped rows present                                                                          |
| Text input / Text area             | Form, selection, and input components         | 3    | 3               | 0                       | Mapped rows present                                                                          |
| Number input                       | Form, selection, and input components         | 6    | 6               | 0                       | Mapped rows present                                                                          |
| Select                             | Form, selection, and input components         | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Checkbox                           | Form, selection, and input components         | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Toggle                             | Form, selection, and input components         | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Date picker                        | Form, selection, and input components         | 2    | 2               | 0                       | Mapped rows present                                                                          |
| Date picker calendar               | Form, selection, and input components         | 5    | 5               | 0                       | Mapped rows present                                                                          |
| Time picker                        | Form, selection, and input components         | 2    | 2               | 0                       | Mapped rows present                                                                          |
| Date picker / Time picker          | Form, selection, and input components         | 1    | 1               | 0                       | Mapped rows present                                                                          |
| Notification                       | Overlays, feedback, status, and AI components | 9    | 9               | 0                       | Mapped rows present                                                                          |
| Modal                              | Overlays, feedback, status, and AI components | 9    | 9               | 0                       | Mapped rows present                                                                          |
| Popover                            | Overlays, feedback, status, and AI components | 2    | 1               | 1                       | Mapped rows present                                                                          |
| Tooltip                            | Overlays, feedback, status, and AI components | 4    | 4               | 0                       | Mapped rows present                                                                          |
| Toggletip                          | Overlays, feedback, status, and AI components | 5    | 5               | 0                       | Mapped rows present                                                                          |
| Loading                            | Overlays, feedback, status, and AI components | 3    | 3               | 0                       | Mapped rows present                                                                          |
| Inline loading                     | Overlays, feedback, status, and AI components | 4    | 4               | 0                       | Mapped rows present                                                                          |
| Progress indicator                 | Overlays, feedback, status, and AI components | 5    | 5               | 0                       | Mapped rows present                                                                          |
| Progress bar                       | Overlays, feedback, status, and AI components | 3    | 3               | 0                       | Mapped rows present                                                                          |
| AI label                           | Overlays, feedback, status, and AI components | 9    | 9               | 0                       | Mapped rows present                                                                          |
| Data table                         | Data display, collection, and tag components  | 13   | 13              | 0                       | Mapped rows present                                                                          |
| Structured list                    | Data display, collection, and tag components  | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Tile                               | Data display, collection, and tag components  | 9    | 9               | 0                       | Mapped rows present                                                                          |
| Tree view                          | Data display, collection, and tag components  | 6    | 6               | 0                       | Mapped rows present                                                                          |
| Contained list                     | Data display, collection, and tag components  | 7    | 7               | 0                       | Mapped rows present                                                                          |
| Code snippet                       | Data display, collection, and tag components  | 5    | 5               | 0                       | Mapped rows present                                                                          |
| List                               | Data display, collection, and tag components  | 1    | 1               | 0                       | Mapped rows present                                                                          |
| Tag                                | Data display, collection, and tag components  | 8    | 5               | 3                       | Mapped rows present                                                                          |
| Slider                             | Form, selection, and input components         | 0    | 0               | 0                       | Coverage table says explicit, but uploaded addendum does not include row-level mapping rows. |
| File uploader                      | Form, selection, and input components         | 0    | 0               | 0                       | Coverage table says explicit, but uploaded addendum does not include row-level mapping rows. |
| UI shell                           | Navigation / shell                            | 0    | 0               | 0                       | Unresolved; style page not extractable in the addendum.                                      |
| Side nav                           | Navigation / shell                            | 0    | 0               | 0                       | Unresolved; style page not extractable in the addendum.                                      |
| Skeleton states                    | Feedback / loading                            | 0    | 0               | 0                       | Unresolved; only core skeleton tokens confirmed.                                             |

## 6. Action and navigation components

### 6.1. Menu

Coverage status: Confirmed.

Rows: 10 total; 10 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant | Mode / Size / Density | State   | Anatomy element  | Property         | Color token       | Source page | Source section          | Confidence |
| --------- | ----------------------------- | ------- | --------------------- | ------- | ---------------- | ---------------- | ----------------- | ----------- | ----------------------- | ---------- |
| Component | Menu                          | Default | Any                   | Enabled | Menu option      | background-color | `$layer`          | Menu style  | Color                   | Documented |
| Component | Menu                          | Default | Any                   | Enabled | Menu option text | text-color       | `$text-secondary` | Menu style  | Color                   | Documented |
| Component | Menu                          | Default | Any                   | Enabled | Divider          | border-top       | `$border-subtle`  | Menu style  | Color                   | Documented |
| Component | Menu                          | Default | Any                   | Enabled | Caret icon       | svg              | `$icon-secondary` | Menu style  | Color                   | Documented |
| Component | Menu                          | Default | Any                   | Hover   | Menu option      | background-color | `$layer-hover`    | Menu style  | Interactive state color | Documented |
| Component | Menu                          | Default | Any                   | Hover   | Menu option text | text-color       | `$text-primary`   | Menu style  | Interactive state color | Documented |
| Component | Menu                          | Default | Any                   | Focus   | Menu option      | border           | `$focus`          | Menu style  | Interactive state color | Documented |
| Component | Menu                          | Danger  | Any                   | Hover   | Menu option      | background-color | `$support-error`  | Menu style  | Interactive state color | Documented |
| Component | Menu                          | Danger  | Any                   | Hover   | Menu option text | text-color       | `$text-on-color`  | Menu style  | Interactive state color | Documented |
| Component | Menu                          | Danger  | Any                   | Hover   | Icon             | svg              | `$icon-on-color`  | Menu style  | Interactive state color | Documented |

### 6.2. Overflow menu

Coverage status: Confirmed.

Rows: 5 total; 5 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant | Mode / Size / Density | State   | Anatomy element    | Property         | Color token              | Source page         | Source section     | Confidence |
| --------- | ----------------------------- | ------- | --------------------- | ------- | ------------------ | ---------------- | ------------------------ | ------------------- | ------------------ | ---------- |
| Component | Overflow menu                 | Default | Any                   | Enabled | Overflow menu icon | fill             | `$icon-primary`          | Overflow menu style | Color              | Documented |
| Component | Overflow menu                 | Default | Any                   | Enabled | Menu option        | background-color | `$layer`                 | Overflow menu style | Color              | Documented |
| Component | Overflow menu                 | Default | Any                   | Hover   | Icon button        | background-color | `$background-hover`      | Overflow menu style | Interactive states | Documented |
| Component | Overflow menu                 | Default | Any                   | Focus   | Menu option        | border           | `$focus`                 | Overflow menu style | Interactive states | Documented |
| Component | Overflow menu                 | Danger  | Any                   | Hover   | Danger option      | background-color | `$button-danger-primary` | Overflow menu style | Interactive states | Documented |

### 6.3. Link

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant             | Mode / Size / Density | State    | Anatomy element | Property   | Color token           | Source page | Source section          | Confidence |
| --------- | ----------------------------- | ------------------- | --------------------- | -------- | --------------- | ---------- | --------------------- | ----------- | ----------------------- | ---------- |
| Component | Link                          | Standalone / inline | Any                   | Enabled  | Link            | text-color | `$link-primary`       | Link style  | Color                   | Documented |
| Component | Link                          | Link with icon      | Any                   | Enabled  | Icon            | svg        | `$link-primary`       | Link style  | Color                   | Documented |
| Component | Link                          | Standalone / inline | Any                   | Hover    | Link            | text-color | `$link-primary-hover` | Link style  | Interactive state color | Documented |
| Component | Link                          | Standalone / inline | Any                   | Active   | Link            | text-color | `$text-primary`       | Link style  | Interactive state color | Documented |
| Component | Link                          | Standalone / inline | Any                   | Visited  | Link            | text-color | `$link-visited`       | Link style  | Interactive state color | Documented |
| Component | Link                          | Standalone / inline | Any                   | Disabled | Link            | text-color | `$text-disabled`      | Link style  | Interactive state color | Documented |
| Component | Link                          | Standalone / inline | Any                   | Focus    | Border          | border     | `$focus`              | Link style  | Interactive state color | Documented |

### 6.4. Breadcrumb

Coverage status: Confirmed.

Rows: 6 total; 6 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State   | Anatomy element         | Property   | Color token           | Source page      | Source section                              | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ------- | ----------------------- | ---------- | --------------------- | ---------------- | ------------------------------------------- | ---------- |
| Component | Breadcrumb                    | Standard | Any                   | Enabled | Enabled breadcrumb text | text-color | `$link-primary`       | Breadcrumb style | Color                                       | Documented |
| Component | Breadcrumb                    | Standard | Any                   | Enabled | Current breadcrumb text | text-color | `$text-primary`       | Breadcrumb style | Color                                       | Documented |
| Component | Breadcrumb                    | Overflow | Any                   | Enabled | Overflow icon           | svg        | `$link-primary`       | Breadcrumb style | Color                                       | Documented |
| Component | Breadcrumb                    | Standard | Any                   | Hover   | Text                    | text-color | `$link-primary-hover` | Breadcrumb style | Breadcrumb interactive state color          | Documented |
| Component | Breadcrumb                    | Standard | Any                   | Focus   | Border                  | border     | `$focus`              | Breadcrumb style | Breadcrumb interactive state color          | Documented |
| Component | Breadcrumb                    | Overflow | Any                   | Active  | Icon                    | svg        | `$icon-primary`       | Breadcrumb style | Breadcrumb overflow interactive state color | Documented |

### 6.5. Tabs

Coverage status: Confirmed.

Rows: 11 total; 11 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant                   | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page | Source section                                    | Confidence |
| --------- | ----------------------------- | ------------------------- | --------------------- | ---------- | --------------- | ---------------- | --------------------- | ----------- | ------------------------------------------------- | ---------- |
| Component | Tabs                          | Line tab                  | Any                   | Unselected | Label           | text-color       | `$text-secondary`     | Tabs style  | Line tab color                                    | Documented |
| Component | Tabs                          | Line tab                  | Any                   | Selected   | Tab             | border-bottom    | `$border-interactive` | Tabs style  | Line tab color                                    | Documented |
| Component | Tabs                          | Line tab                  | Any                   | Hover      | Tab             | border-bottom    | `$border-strong`      | Tabs style  | Line tab interactive state color                  | Documented |
| Component | Tabs                          | Line tab                  | Any                   | Focus      | Tab             | border           | `$focus`              | Tabs style  | Line tab interactive state color                  | Documented |
| Component | Tabs                          | Line tab                  | Any                   | Disabled   | Tab             | border-bottom    | `$border-disabled`    | Tabs style  | Line tab interactive state color                  | Documented |
| Component | Tabs                          | Contained tab             | Any                   | Unselected | Tab             | background-color | `$layer-accent`       | Tabs style  | Contained tab color                               | Documented |
| Component | Tabs                          | Contained tab             | Any                   | Selected   | Tab             | background-color | `$layer`              | Tabs style  | Contained tab color                               | Documented |
| Component | Tabs                          | Contained tab             | Any                   | Disabled   | Tab             | background-color | `$button-disabled`    | Tabs style  | Contained tab interactive state color             | Documented |
| Component | Tabs                          | Dismissible contained tab | Any                   | Focus      | Tab             | border           | `$focus`              | Tabs style  | Dismissible contained tab interactive state color | Documented |
| Component | Tabs                          | Vertical tab              | Any                   | Selected   | Tab             | border-left      | `$border-interactive` | Tabs style  | Vertical tab color                                | Documented |
| Component | Tabs                          | Vertical tab              | Any                   | Hover      | Tab             | background-color | `$layer-hover`        | Tabs style  | Vertical tab interactive state color              | Documented |

### 6.6. Content switcher

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

Content switcher remains partial because the uploaded addendum only captured high-contrast and high-contrast interactive rows, not the full component-token family.

| Area      | Component / Pattern / Element | Variant       | Mode / Size / Density | State             | Anatomy element | Property         | Color token                | Source page            | Source section                                              | Confidence |
| --------- | ----------------------------- | ------------- | --------------------- | ----------------- | --------------- | ---------------- | -------------------------- | ---------------------- | ----------------------------------------------------------- | ---------- |
| Component | Content switcher              | High contrast | Default / Icon        | Unselected        | Container       | border           | `$border-inverse`          | Content switcher style | High contrast color / High contrast interactive state color | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Selected          | Container       | background-color | `$layer-selected-inverse`  | Content switcher style | High contrast color                                         | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Selected          | Label           | text-color       | `$text-inverse`            | Content switcher style | High contrast color                                         | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Hover unselected  | Container       | background-color | `$background-hover`        | Content switcher style | High contrast interactive state color                       | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Focus unselected  | Container       | border           | `$focus`                   | Content switcher style | High contrast interactive state color                       | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Focus selected    | Container       | inner-border     | `$focus-inset`             | Content switcher style | High contrast interactive state color                       | Documented |
| Component | Content switcher              | High contrast | Default / Icon        | Disabled selected | Container       | background-color | `$layer-selected-disabled` | Content switcher style | High contrast interactive state color                       | Documented |

### 6.7. Pagination

Coverage status: Confirmed.

Rows: 3 total; 3 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State   | Anatomy element | Property         | Color token       | Source page      | Source section   | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ------- | --------------- | ---------------- | ----------------- | ---------------- | ---------------- | ---------- |
| Component | Pagination                    | Standard | Any                   | Enabled | Container       | background-color | `$layer`          | Pagination style | Pagination color | Documented |
| Component | Pagination                    | Standard | Any                   | Enabled | Container       | border-top       | `$border-subtle`  | Pagination style | Pagination color | Documented |
| Component | Pagination                    | Standard | Any                   | Enabled | Page-range text | text-color       | `$text-secondary` | Pagination style | Pagination color | Documented |

### 6.8. Pagination nav

Coverage status: Confirmed.

Rows: 4 total; 4 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant | Mode / Size / Density | State    | Anatomy element | Property         | Color token           | Source page      | Source section                                                | Confidence |
| --------- | ----------------------------- | ------- | --------------------- | -------- | --------------- | ---------------- | --------------------- | ---------------- | ------------------------------------------------------------- | ---------- |
| Component | Pagination nav                | Nav     | Any                   | Selected | Page            | border           | `$border-interactive` | Pagination style | Pagination nav color / Pagination nav interactive state color | Documented |
| Component | Pagination nav                | Nav     | Any                   | Hover    | Background      | background-color | `$layer-hover`        | Pagination style | Pagination nav interactive state color                        | Documented |
| Component | Pagination nav                | Nav     | Any                   | Disabled | Text            | text-color       | `$text-disabled`      | Pagination style | Pagination nav interactive state color                        | Documented |
| Component | Pagination nav                | Nav     | Any                   | Disabled | Icon            | fill             | `$icon-disabled`      | Pagination style | Pagination nav interactive state color                        | Documented |

## 7. Form, selection, and input components

### 7.1. Search

Coverage status: Confirmed.

Rows: 8 total; 8 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State    | Anatomy element  | Property         | Color token         | Source page  | Source section     | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | -------- | ---------------- | ---------------- | ------------------- | ------------ | ------------------ | ---------- |
| Component | Search                        | Default / Fluid | Any                   | Enabled  | Field            | background-color | `$field`            | Search style | Color              | Documented |
| Component | Search                        | Default / Fluid | Any                   | Enabled  | Field            | border-bottom    | `$border-strong`    | Search style | Color              | Documented |
| Component | Search                        | Default / Fluid | Any                   | Enabled  | Placeholder text | text-color       | `$text-placeholder` | Search style | Color              | Documented |
| Component | Search                        | Default / Fluid | Any                   | Enabled  | Search icon      | fill             | `$icon-secondary`   | Search style | Color              | Documented |
| Component | Search                        | Default / Fluid | Any                   | Focus    | Field            | border           | `$focus`            | Search style | Interactive colors | Documented |
| Component | Search                        | Default / Fluid | Any                   | Filled   | Field text       | text-color       | `$text-primary`     | Search style | Interactive colors | Documented |
| Component | Search                        | Default / Fluid | Any                   | Filled   | Close icon       | fill             | `$icon-primary`     | Search style | Interactive colors | Documented |
| Component | Search                        | Default / Fluid | Any                   | Disabled | Field text       | text-color       | `$text-disabled`    | Search style | Interactive colors | Documented |

### 7.2. Radio button

Coverage status: Confirmed.

Rows: 10 total; 10 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant    | Mode / Size / Density | State      | Anatomy element | Property   | Color token        | Source page        | Source section     | Confidence |
| --------- | ----------------------------- | ---------- | --------------------- | ---------- | --------------- | ---------- | ------------------ | ------------------ | ------------------ | ---------- |
| Component | Radio button                  | Default    | Any                   | Enabled    | Group label     | text-color | `$text-secondary`  | Radio button style | Color              | Documented |
| Component | Radio button                  | Default    | Any                   | Enabled    | Radio label     | text-color | `$text-primary`    | Radio button style | Color              | Documented |
| Component | Radio button                  | Unselected | Any                   | Enabled    | Radio control   | border     | `$icon-primary`    | Radio button style | Color              | Documented |
| Component | Radio button                  | Selected   | Any                   | Enabled    | Radio dot       | fill       | `$icon-primary`    | Radio button style | Color              | Documented |
| Component | Radio button                  | Default    | Any                   | Focus      | Radio control   | border     | `$focus`           | Radio button style | Interactive colors | Documented |
| Component | Radio button                  | Default    | Any                   | Disabled   | Label           | text-color | `$text-disabled`   | Radio button style | Interactive colors | Documented |
| Component | Radio button                  | Default    | Any                   | Error      | Radio control   | border     | `$support-error`   | Radio button style | Interactive colors | Documented |
| Component | Radio button                  | Default    | Any                   | Error      | Error message   | text-color | `$text-error`      | Radio button style | Interactive colors | Documented |
| Component | Radio button                  | Default    | Any                   | Warning    | Warning icon    | svg        | `$support-warning` | Radio button style | Interactive colors | Documented |
| Component | Radio button                  | AI variant | Any                   | AI present | AI label        | size token | `mini`             | Radio button style | AI presence        | Documented |

### 7.3. Dropdown / Combo box / Multiselect

Coverage status: Confirmed.

Rows: 11 total; 11 documented; 0 needs verification.

This group remains combined because the uploaded addendum treats Carbon’s Dropdown style page as the shared source for Dropdown, Combo box, and Multiselect rows.

| Area      | Component / Pattern / Element      | Variant         | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page    | Source section     | Confidence |
| --------- | ---------------------------------- | --------------- | --------------------- | ---------- | --------------- | ---------------- | --------------------- | -------------- | ------------------ | ---------- |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Enabled    | Label           | text-color       | `$text-secondary`     | Dropdown style | Color              | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Enabled    | Field           | background-color | `$field`              | Dropdown style | Color              | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Enabled    | Prompt text     | text-color       | `$text-helper`        | Dropdown style | Color              | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Enabled    | Menu option     | background-color | `$layer`              | Dropdown style | Color              | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Hover      | Field           | background-color | `$field-hover`        | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Hover      | Menu option     | background-color | `$layer-hover`        | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Invalid    | Field           | border           | `$support-error`      | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | Default / Fluid | Any                   | Active     | Menu option     | background-color | `$layer-active`       | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | Multiselect     | Any                   | Selected   | Tag             | background-color | `$background-inverse` | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | Multiselect     | Any                   | Selected   | Tag             | text-color       | `$text-inverse`       | Dropdown style | Interactive states | Documented |
| Component | Dropdown / Combo box / Multiselect | AI variant      | Default / Fluid       | AI present | Field           | border-bottom    | `$ai-border-strong`   | Dropdown style | AI presence        | Documented |

### 7.4. Text input

Coverage status: Confirmed.

Rows: 6 total; 6 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State     | Anatomy element | Property         | Color token         | Source page      | Source section                             | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | --------- | --------------- | ---------------- | ------------------- | ---------------- | ------------------------------------------ | ---------- |
| Component | Text input                    | Default / Fluid | Any                   | Enabled   | Label           | text-color       | `$text-secondary`   | Text input style | Text input color / Interactive state color | Documented |
| Component | Text input                    | Default / Fluid | Any                   | Enabled   | Field           | background-color | `$field`            | Text input style | Text input color                           | Documented |
| Component | Text input                    | Default / Fluid | Any                   | Enabled   | Placeholder     | text-color       | `$text-placeholder` | Text input style | Text input color                           | Documented |
| Component | Text input                    | Default / Fluid | Any                   | Invalid   | Field           | border           | `$support-error`    | Text input style | Interactive state color                    | Documented |
| Component | Text input                    | Default / Fluid | Any                   | Invalid   | Error message   | text-color       | `$text-error`       | Text input style | Interactive state color                    | Documented |
| Component | Text input                    | Default / Fluid | Any                   | Read-only | Field           | border-bottom    | `$border-subtle`    | Text input style | Interactive state color                    | Documented |

### 7.5. Password input

Coverage status: Confirmed.

Rows: 2 total; 2 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State   | Anatomy element | Property | Color token     | Source page      | Source section                                 | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | ------- | --------------- | -------- | --------------- | ---------------- | ---------------------------------------------- | ---------- |
| Component | Password input                | Default / Fluid | Any                   | Enabled | View icon       | svg      | `$icon-primary` | Text input style | Password input color / Interactive state color | Documented |
| Component | Password input                | Default / Fluid | Any                   | Hover   | View icon       | svg      | `$icon-primary` | Text input style | Interactive state color                        | Documented |

### 7.6. Text area

Coverage status: Confirmed.

Rows: 3 total; 3 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State     | Anatomy element | Property         | Color token      | Source page      | Source section          | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | --------- | --------------- | ---------------- | ---------------- | ---------------- | ----------------------- | ---------- |
| Component | Text area                     | Default / Fluid | Any                   | Enabled   | Field           | background-color | `$field`         | Text input style | Text area color         | Documented |
| Component | Text area                     | Default / Fluid | Any                   | Invalid   | Field           | border           | `$support-error` | Text input style | Interactive state color | Documented |
| Component | Text area                     | Default / Fluid | Any                   | Read-only | Field           | border-bottom    | `$border-subtle` | Text input style | Interactive state color | Documented |

### 7.7. Text input / Text area

Coverage status: Confirmed.

Rows: 3 total; 3 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant    | Mode / Size / Density | State      | Anatomy element       | Property         | Color token         | Source page      | Source section | Confidence |
| --------- | ----------------------------- | ---------- | --------------------- | ---------- | --------------------- | ---------------- | ------------------- | ---------------- | -------------- | ---------- |
| Component | Text input / Text area        | AI variant | Default / Fluid       | AI present | Linear gradient start | background start | `$ai-aura-start-sm` | Text input style | AI presence    | Documented |
| Component | Text input / Text area        | AI variant | Default / Fluid       | AI present | Linear gradient stop  | background stop  | `$ai-aura-stop`     | Text input style | AI presence    | Documented |
| Component | Text input / Text area        | AI variant | Default / Fluid       | AI present | Field                 | border-bottom    | `$ai-border-strong` | Text input style | AI presence    | Documented |

### 7.8. Number input

Coverage status: Confirmed.

Rows: 6 total; 6 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State      | Anatomy element | Property         | Color token         | Source page        | Source section     | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | ---------- | --------------- | ---------------- | ------------------- | ------------------ | ------------------ | ---------- |
| Component | Number input                  | Default / Fluid | Any                   | Enabled    | Controls        | svg color        | `$icon-primary`     | Number input style | Color              | Documented |
| Component | Number input                  | Default / Fluid | Any                   | Hover      | Controls        | background-color | `field-hover`       | Number input style | Interactive states | Documented |
| Component | Number input                  | Default / Fluid | Any                   | Focus      | Controls        | border           | `$focus`            | Number input style | Interactive states | Documented |
| Component | Number input                  | Default / Fluid | Any                   | Invalid    | Field           | border           | `$support-error`    | Number input style | Interactive states | Documented |
| Component | Number input                  | Default / Fluid | Any                   | Disabled   | Controls        | svg color        | `$icon-disabled`    | Number input style | Interactive states | Documented |
| Component | Number input                  | AI variant      | Default / Fluid       | AI present | Field           | border-bottom    | `$ai-border-strong` | Number input style | AI presence        | Documented |

### 7.9. Select

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State      | Anatomy element | Property             | Color token         | Source page  | Source section     | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | ---------- | --------------- | -------------------- | ------------------- | ------------ | ------------------ | ---------- |
| Component | Select                        | Default / Fluid | Any                   | Enabled    | Helper text     | text color           | `$text-helper`      | Select style | Color              | Documented |
| Component | Select                        | Default / Fluid | Any                   | Enabled    | Icon            | fill                 | `$icon-primary`     | Select style | Color              | Documented |
| Component | Select                        | Default / Fluid | Any                   | Hover      | Field           | background-color     | `$field-hover`      | Select style | Interactive states | Documented |
| Component | Select                        | Default / Fluid | Any                   | Disabled   | Chevron icon    | fill                 | `$icon-disabled`    | Select style | Interactive states | Documented |
| Component | Select                        | Default / Fluid | Any                   | Read-only  | Input text      | text-color (default) | `$text-primary`     | Select style | Interactive states | Documented |
| Component | Select                        | Default / Fluid | Any                   | Read-only  | Input text      | text-color (fluid)   | `$text-secondary`   | Select style | Interactive states | Documented |
| Component | Select                        | AI variant      | Default / Fluid       | AI present | Field           | border-bottom        | `$ai-border-strong` | Select style | AI presence        | Documented |

### 7.10. Checkbox

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant | Mode / Size / Density | State     | Anatomy element | Property         | Color token      | Source page    | Source section     | Confidence |
| --------- | ----------------------------- | ------- | --------------------- | --------- | --------------- | ---------------- | ---------------- | -------------- | ------------------ | ---------- |
| Component | Checkbox                      | Default | Any                   | Unchecked | Checkbox        | border           | `$icon-primary`  | Checkbox style | Color              | Documented |
| Component | Checkbox                      | Default | Any                   | Checked   | Checkbox        | background-color | `$icon-primary`  | Checkbox style | Color              | Documented |
| Component | Checkbox                      | Default | Any                   | Checked   | Checkmark       | fill             | `$icon-inverse`  | Checkbox style | Color              | Documented |
| Component | Checkbox                      | Default | Any                   | Focus     | Checkbox        | border           | `$focus`         | Checkbox style | Interactive states | Documented |
| Component | Checkbox                      | Default | Any                   | Disabled  | Checkbox        | border           | `$icon-disabled` | Checkbox style | Interactive states | Documented |
| Component | Checkbox                      | Default | Any                   | Error     | Checkbox        | border           | `$support-error` | Checkbox style | Interactive states | Documented |
| Component | Checkbox                      | Default | Any                   | Warning   | Inner fill      | fill             | `$black`         | Checkbox style | Interactive states | Documented |

### 7.11. Toggle

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State     | Anatomy element | Property         | Color token               | Source page  | Source section          | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | --------- | --------------- | ---------------- | ------------------------- | ------------ | ----------------------- | ---------- |
| Component | Toggle                        | Default / Small | Any                   | Off       | Background      | background-color | `$toggle-off`             | Toggle style | Color                   | Documented |
| Component | Toggle                        | Default / Small | Any                   | Off       | Handle          | background-color | `$icon-on-color`          | Toggle style | Color                   | Documented |
| Component | Toggle                        | Default / Small | Any                   | On        | Background      | background-color | `$support-success`        | Toggle style | Color                   | Documented |
| Component | Toggle                        | Default / Small | Any                   | Focus     | Toggle          | border           | `$focus`                  | Toggle style | Interactive state color | Documented |
| Component | Toggle                        | Default / Small | Any                   | Disabled  | Background      | background-color | `$button-disabled`        | Toggle style | Interactive state color | Documented |
| Component | Toggle                        | Default / Small | Any                   | Disabled  | Handle          | background-color | `$icon-on-color-disabled` | Toggle style | Interactive state color | Documented |
| Component | Toggle                        | Default / Small | Any                   | Read-only | Border          | border           | `$border-subtle`          | Toggle style | Interactive state color | Documented |

### 7.12. Date picker

Coverage status: Confirmed.

Rows: 2 total; 2 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State   | Anatomy element | Property | Color token     | Source page       | Source section          | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | ------- | --------------- | -------- | --------------- | ----------------- | ----------------------- | ---------- |
| Component | Date picker                   | Default / Fluid | Any                   | Enabled | Calendar icon   | svg      | `$icon-primary` | Date picker style | Date picker color       | Documented |
| Component | Date picker                   | Default / Fluid | Any                   | Focus   | Field           | border   | `$focus`        | Date picker style | Interactive state color | Documented |

### 7.13. Date picker calendar

Coverage status: Confirmed.

Rows: 5 total; 5 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant        | Mode / Size / Density | State    | Anatomy element | Property         | Color token         | Source page       | Source section                                | Confidence |
| --------- | ----------------------------- | -------------- | --------------------- | -------- | --------------- | ---------------- | ------------------- | ----------------- | --------------------------------------------- | ---------- |
| Component | Date picker calendar          | Calendar       | Any                   | Enabled  | Calendar menu   | background-color | `$layer`            | Date picker style | Calendar menu color                           | Documented |
| Component | Date picker calendar          | Calendar       | Any                   | Today    | Day text        | text-color       | `$link-01`          | Date picker style | Calendar menu color                           | Documented |
| Component | Date picker calendar          | Calendar       | Any                   | Selected | Day             | background-color | `$background-brand` | Date picker style | Calendar menu color → Interactive state color | Documented |
| Component | Date picker calendar          | Calendar       | Any                   | Selected | Day text        | text-color       | `$text-on-color`    | Date picker style | Calendar menu color → Interactive state color | Documented |
| Component | Date picker calendar          | Calendar range | Any                   | In range | Day             | background-color | `$highlight`        | Date picker style | Calendar menu color → Interactive state color | Documented |

### 7.14. Time picker

Coverage status: Confirmed.

Rows: 2 total; 2 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State    | Anatomy element | Property | Color token      | Source page       | Source section                              | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | -------- | --------------- | -------- | ---------------- | ----------------- | ------------------------------------------- | ---------- |
| Component | Time picker                   | Default / Fluid | Any                   | Enabled  | Divider         | border   | `$border-strong` | Date picker style | Time picker color                           | Documented |
| Component | Time picker                   | Default / Fluid | Any                   | Disabled | Chevron icon    | svg      | `$icon-disabled` | Date picker style | Time picker color → Interactive state color | Documented |

### 7.15. Date picker / Time picker

Coverage status: Confirmed.

Rows: 1 total; 1 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant    | Mode / Size / Density | State      | Anatomy element | Property      | Color token         | Source page       | Source section | Confidence |
| --------- | ----------------------------- | ---------- | --------------------- | ---------- | --------------- | ------------- | ------------------- | ----------------- | -------------- | ---------- |
| Component | Date picker / Time picker     | AI variant | Default / Fluid       | AI present | Field           | border-bottom | `$ai-border-strong` | Date picker style | AI presence    | Documented |

## 8. Overlays, feedback, status, and AI components

### 8.1. Notification

Coverage status: Confirmed.

Rows: 9 total; 9 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant       | Mode / Size / Density | State       | Anatomy element | Property         | Color token                              | Source page        | Source section | Confidence |
| --------- | ----------------------------- | ------------- | --------------------- | ----------- | --------------- | ---------------- | ---------------------------------------- | ------------------ | -------------- | ---------- |
| Component | Notification                  | Low contrast  | Any                   | Error       | Notification    | background-color | `$notification-error-background-color`   | Notification style | Low contrast   | Documented |
| Component | Notification                  | Low contrast  | Any                   | Success     | Notification    | background-color | `$notification-success-background-color` | Notification style | Low contrast   | Documented |
| Component | Notification                  | Low contrast  | Any                   | Warning     | Notification    | background-color | `$notification-warning-background-color` | Notification style | Low contrast   | Documented |
| Component | Notification                  | Low contrast  | Any                   | Information | Notification    | background-color | `$notification-info-background-color`    | Notification style | Low contrast   | Documented |
| Component | Notification                  | High contrast | Any                   | Enabled     | Background      | background-color | `$background-inverse`                    | Notification style | High contrast  | Documented |
| Component | Notification                  | High contrast | Any                   | Error       | Border-left     | border-left      | `$support-error-inverse`                 | Notification style | High contrast  | Documented |
| Component | Notification                  | High contrast | Any                   | Success     | Border-left     | border-left      | `$support-success-inverse`               | Notification style | High contrast  | Documented |
| Component | Notification                  | High contrast | Any                   | Warning     | Border-left     | border-left      | `$support-warning-inverse`               | Notification style | High contrast  | Documented |
| Component | Notification                  | High contrast | Any                   | Information | Border-left     | border-left      | `$support-info-inverse`                  | Notification style | High contrast  | Documented |

### 8.2. Modal

Coverage status: Confirmed.

Rows: 9 total; 9 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant                 | Mode / Size / Density | State      | Anatomy element               | Property         | Color token        | Source page | Source section | Confidence |
| --------- | ----------------------------- | ----------------------- | --------------------- | ---------- | ----------------------------- | ---------------- | ------------------ | ----------- | -------------- | ---------- |
| Component | Modal                         | Passive / transactional | Any                   | Enabled    | Container                     | background-color | `$layer`           | Modal style | Color          | Documented |
| Component | Modal                         | Passive / transactional | Any                   | Enabled    | Container                     | border           | `$border-subtle`   | Modal style | Color          | Documented |
| Component | Modal                         | Passive / transactional | Any                   | Hover      | Close icon                    | background-color | `$layer-hover`     | Modal style | Color          | Documented |
| Component | Modal                         | Passive / transactional | Any                   | Enabled    | Page overlay                  | color            | `$overlay`         | Modal style | Color          | Documented |
| Component | Modal                         | AI variant              | Any                   | AI present | Overlay                       | background-color | `$ai-overlay`      | Modal style | AI presence    | Documented |
| Component | Modal                         | AI variant              | Any                   | AI present | Modal background              | box-shadow       | `$ai-drop-shadow`  | Modal style | AI presence    | Documented |
| Component | Modal                         | AI variant              | Any                   | AI present | Modal background              | inner-shadow     | `$ai-inner-shadow` | Modal style | AI presence    | Documented |
| Component | Modal                         | AI variant              | Any                   | AI present | Linear gradient border top    | border start     | `$ai-border-start` | Modal style | AI presence    | Documented |
| Component | Modal                         | AI variant              | Any                   | AI present | Linear gradient border bottom | border end       | `$ai-border-end`   | Modal style | AI presence    | Documented |

### 8.3. Popover

Coverage status: Partial / needs verification.

Rows: 2 total; 1 documented; 1 needs verification.

| Area      | Component / Pattern / Element | Variant               | Mode / Size / Density | State   | Anatomy element | Property         | Color token           | Source page   | Source section | Confidence         |
| --------- | ----------------------------- | --------------------- | --------------------- | ------- | --------------- | ---------------- | --------------------- | ------------- | -------------- | ------------------ |
| Component | Popover                       | Any                   | Any                   | Enabled | Container       | background-color | `$layer`              | Popover style | Color          | Documented         |
| Component | Popover                       | Inverse / unspecified | Any                   | Enabled | Container       | background-color | `$background-inverse` | Popover style | Color          | Needs verification |

### 8.4. Tooltip

Coverage status: Confirmed.

Rows: 4 total; 4 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant            | Mode / Size / Density | State      | Anatomy element | Property         | Color token           | Source page   | Source section          | Confidence |
| --------- | ----------------------------- | ------------------ | --------------------- | ---------- | --------------- | ---------------- | --------------------- | ------------- | ----------------------- | ---------- |
| Component | Tooltip                       | Open               | Any                   | Enabled    | Container       | background-color | `$background-inverse` | Tooltip style | Interactive state color | Documented |
| Component | Tooltip                       | Open               | Any                   | Enabled    | Text            | text-color       | `$text-inverse`       | Tooltip style | Interactive state color | Documented |
| Component | Tooltip                       | Definition tooltip | Any                   | Hover open | Border-bottom   | border           | `$border-interactive` | Tooltip style | Interactive state color | Documented |
| Component | Tooltip                       | Definition tooltip | Any                   | Focus open | Border          | border           | `$focus`              | Tooltip style | Interactive state color | Documented |

### 8.5. Toggletip

Coverage status: Confirmed.

Rows: 5 total; 5 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State        | Anatomy element | Property         | Color token           | Source page     | Source section          | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ------------ | --------------- | ---------------- | --------------------- | --------------- | ----------------------- | ---------- |
| Component | Toggletip                     | Standard | Any                   | Closed       | Trigger button  | svg              | `$icon-secondary`     | Toggletip style | Color                   | Documented |
| Component | Toggletip                     | Standard | Any                   | Open         | Container       | background-color | `$background-inverse` | Toggletip style | Color                   | Documented |
| Component | Toggletip                     | Standard | Any                   | Open         | Text            | color            | `$text-inverse`       | Toggletip style | Color                   | Documented |
| Component | Toggletip                     | Standard | Any                   | Hover closed | Trigger button  | svg              | `$icon-primary`       | Toggletip style | Interactive state color | Documented |
| Component | Toggletip                     | Standard | Any                   | Focus        | Border          | border           | `$focus`              | Toggletip style | Interactive state color | Documented |

### 8.6. Loading

Coverage status: Confirmed.

Rows: 3 total; 3 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant       | Mode / Size / Density | State   | Anatomy element      | Property         | Color token     | Source page   | Source section | Confidence |
| --------- | ----------------------------- | ------------- | --------------------- | ------- | -------------------- | ---------------- | --------------- | ------------- | -------------- | ---------- |
| Component | Loading                       | Large / Small | Any                   | Enabled | Indicator            | stroke           | `$interactive`  | Loading style | Color          | Documented |
| Component | Loading                       | Small         | Any                   | Enabled | Indicator background | background-color | `$layer-accent` | Loading style | Color          | Documented |
| Component | Loading                       | Page overlay  | Any                   | Enabled | Overlay              | background-color | `$overlay`      | Loading style | Color          | Documented |

### 8.7. Inline loading

Coverage status: Confirmed.

Rows: 4 total; 4 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State   | Anatomy element             | Property | Color token           | Source page          | Source section | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ------- | --------------------------- | -------- | --------------------- | -------------------- | -------------- | ---------- |
| Component | Inline loading                | Standard | Any                   | Loading | `.cds--loading__background` | stroke   | `$border-subtle`      | Inline loading style | Color          | Documented |
| Component | Inline loading                | Standard | Any                   | Loading | `.cds--loading__stroke`     | stroke   | `$border-interactive` | Inline loading style | Color          | Documented |
| Component | Inline loading                | Standard | Any                   | Enabled | Text                        | color    | `$text-secondary`     | Inline loading style | Color          | Documented |
| Component | Inline loading                | Finished | Any                   | Success | Status icon                 | svg      | `$support-success`    | Inline loading style | Color          | Documented |

### 8.8. Progress indicator

Coverage status: Confirmed.

Rows: 5 total; 5 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State       | Anatomy element | Property         | Color token           | Source page              | Source section     | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ----------- | --------------- | ---------------- | --------------------- | ------------------------ | ------------------ | ---------- |
| Component | Progress indicator            | Standard | Any                   | Complete    | Icon            | fill             | `$interactive`        | Progress indicator style | Color              | Documented |
| Component | Progress indicator            | Standard | Any                   | Not started | Icon            | fill             | `$icon-primary`       | Progress indicator style | Color              | Documented |
| Component | Progress indicator            | Standard | Any                   | Active      | Step line       | background-color | `$border-interactive` | Progress indicator style | Color              | Documented |
| Component | Progress indicator            | Standard | Any                   | Error       | Icon            | fill             | `$support-error`      | Progress indicator style | Interactive states | Documented |
| Component | Progress indicator            | Standard | Any                   | Disabled    | Icon            | fill             | `$icon-disabled`      | Progress indicator style | Interactive states | Documented |

### 8.9. Progress bar

Coverage status: Confirmed.

Rows: 3 total; 3 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State   | Anatomy element | Property   | Color token           | Source page        | Source section | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | ------- | --------------- | ---------- | --------------------- | ------------------ | -------------- | ---------- |
| Component | Progress bar                  | Standard | Big / Small           | Active  | Bar             | background | `$border-interactive` | Progress bar style | Color          | Documented |
| Component | Progress bar                  | Standard | Big / Small           | Success | Bar             | background | `$support-success`    | Progress bar style | Color          | Documented |
| Component | Progress bar                  | Standard | Big / Small           | Error   | Bar             | background | `$support-error`      | Progress bar style | Color          | Documented |

### 8.10. AI label

Coverage status: Confirmed.

Rows: 9 total; 9 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant                | Mode / Size / Density | State   | Anatomy element         | Property   | Color token              | Source page    | Source section               | Confidence |
| --------- | ----------------------------- | ---------------------- | --------------------- | ------- | ----------------------- | ---------- | ------------------------ | -------------- | ---------------------------- | ---------- |
| Component | AI label                      | Default                | xl / sm–lg / 2xs–mini | Enabled | Text                    | text color | `$text-primary`          | AI label style | Default color                | Documented |
| Component | AI label                      | Default                | xl / sm–lg / 2xs–mini | Hover   | Button                  | background | `$background-inverse`    | AI label style | Default color                | Documented |
| Component | AI label                      | Default                | xl / sm–lg / 2xs–mini | Focus   | Button                  | border     | `$focus`                 | AI label style | Default color                | Documented |
| Component | AI label                      | Inline                 | lg / md / sm          | Enabled | Dot                     | fill       | `$icon-primary`          | AI label style | Inline color                 | Documented |
| Component | AI label                      | Explainability popover | Any                   | Enabled | Popover background      | background | `$ai-popover-background` | AI label style | Explainability popover color | Documented |
| Component | AI label                      | Explainability popover | Any                   | Enabled | Linear gradient         | start      | `$ai-aura-start`         | AI label style | Explainability popover color | Documented |
| Component | AI label                      | Explainability popover | Any                   | Enabled | Linear gradient         | end        | `$ai-aura-end`           | AI label style | Explainability popover color | Documented |
| Component | AI label                      | Explainability popover | Any                   | Enabled | Popover border gradient | start      | `$ai-border-start`       | AI label style | Explainability popover color | Documented |
| Component | AI label                      | Explainability popover | Any                   | Enabled | Popover border gradient | end        | `$ai-border-end`         | AI label style | Explainability popover color | Documented |

## 9. Data display, collection, and tag components

### 9.1. Data table

Coverage status: Confirmed.

Rows: 13 total; 13 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant          | Mode / Size / Density | State            | Anatomy element          | Property         | Color token             | Source page      | Source section   | Confidence |
| --------- | ----------------------------- | ---------------- | --------------------- | ---------------- | ------------------------ | ---------------- | ----------------------- | ---------------- | ---------------- | ---------- |
| Component | Data table                    | Standard         | Any                   | Enabled          | Table header             | background-color | `$layer`                | Data table style | Table header     | Documented |
| Component | Data table                    | Standard         | Any                   | Enabled          | Title                    | text-color       | `$text-primary`         | Data table style | Table header     | Documented |
| Component | Data table                    | Standard         | Any                   | Enabled          | Column header            | background-color | `$layer-accent`         | Data table style | Column header    | Documented |
| Component | Data table                    | Standard         | Any                   | Hover            | Column header            | background-color | `$layer-accent-hover`   | Data table style | Column header    | Documented |
| Component | Data table                    | Standard         | Any                   | Enabled          | Row                      | background-color | `$layer`                | Data table style | Row              | Documented |
| Component | Data table                    | Standard         | Any                   | Selected         | Row                      | background-color | `$layer-selected`       | Data table style | Row              | Documented |
| Component | Data table                    | Standard         | Any                   | Selected + hover | Row                      | background-color | `$layer-selected-hover` | Data table style | Row              | Documented |
| Component | Data table                    | Standard         | Any                   | Zebra            | Row                      | background-color | `$layer-accent`         | Data table style | Row              | Documented |
| Component | Data table                    | Batch action bar | Any                   | Enabled          | Bar                      | background-color | `$background-brand`     | Data table style | Batch action bar | Documented |
| Component | Data table                    | Batch action bar | Any                   | Enabled          | Summary                  | text-color       | `$text-on-color`        | Data table style | Batch action bar | Documented |
| Component | Data table                    | AI variant       | Entire table          | AI present       | Entire table             | box-shadow       | `$ai-drop-shadow`       | Data table style | AI presence      | Documented |
| Component | Data table                    | AI variant       | Entire table          | AI present       | Entire table             | inner-shadow     | `$ai-inner-shadow`      | Data table style | AI presence      | Documented |
| Component | Data table                    | AI variant       | Rows and columns      | AI present       | Gradient border left/top | border           | `$ai-border-strong`     | Data table style | AI presence      | Documented |

### 9.2. Structured list

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State    | Anatomy element | Property         | Color token       | Source page           | Source section                     | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | -------- | --------------- | ---------------- | ----------------- | --------------------- | ---------------------------------- | ---------- |
| Component | Structured list               | Default         | Hang / Flush          | Enabled  | Row text        | text color       | `$text-secondary` | Structured list style | Default color                      | Documented |
| Component | Structured list               | Default         | Hang / Flush          | Enabled  | Divider         | border-bottom    | `$border-subtle`  | Structured list style | Default color                      | Documented |
| Component | Structured list               | Selectable      | Feature-flagged       | Selected | Row             | background-color | `$layer-selected` | Structured list style | Selectable interactive state color | Documented |
| Component | Structured list               | Selectable      | Feature-flagged       | Hover    | Row             | background-color | `$layer-hover`    | Structured list style | Selectable interactive state color | Documented |
| Component | Structured list               | Selectable      | Feature-flagged       | Focus    | Row             | border           | `$focus`          | Structured list style | Selectable interactive state color | Documented |
| Component | Structured list               | Selectable      | Feature-flagged       | Disabled | Row text        | text color       | `$text-disabled`  | Structured list style | Selectable interactive state color | Documented |
| Component | Structured list               | With background | Feature-flagged       | Enabled  | Header / Row    | background-color | `$layer`          | Structured list style | With background color              | Documented |

### 9.3. Tile

Coverage status: Confirmed.

Rows: 9 total; 9 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant         | Mode / Size / Density | State      | Anatomy element        | Property         | Color token         | Source page | Source section                          | Confidence |
| --------- | ----------------------------- | --------------- | --------------------- | ---------- | ---------------------- | ---------------- | ------------------- | ----------- | --------------------------------------- | ---------- |
| Component | Tile                          | Base tile       | Any                   | Enabled    | Container              | background-color | `$layer`            | Tile style  | Base tile color                         | Documented |
| Component | Tile                          | Clickable tile  | Feature-flagged       | Enabled    | Border                 | border           | `$border-tile`      | Tile style  | Clickable tile color                    | Documented |
| Component | Tile                          | Clickable tile  | Feature-flagged       | Enabled    | Icon                   | svg              | `$icon-interactive` | Tile style  | Clickable tile color                    | Documented |
| Component | Tile                          | Clickable tile  | Feature-flagged       | Hover      | Container              | background-color | `$layer-hover`      | Tile style  | Clickable tile interactive state color  | Documented |
| Component | Tile                          | Selectable tile | Feature-flagged       | Selected   | Container              | border           | `$border-inverse`   | Tile style  | Selectable tile interactive state color | Documented |
| Component | Tile                          | Expandable tile | Feature-flagged       | Disabled   | Container              | border           | `$border-disabled`  | Tile style  | Expandable tile interactive state color | Documented |
| Component | Tile                          | AI variant      | Any                   | AI present | Tile background        | box-shadow       | `$ai-drop-shadow`   | Tile style  | AI presence                             | Documented |
| Component | Tile                          | AI variant      | Any                   | AI present | Linear gradient        | start            | `$ai-aura-start`    | Tile style  | AI presence                             | Documented |
| Component | Tile                          | AI variant      | Any                   | AI present | Linear gradient border | stop             | `$ai-border-stop`   | Tile style  | AI presence                             | Documented |

### 9.4. Tree view

Coverage status: Confirmed.

Rows: 6 total; 6 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant  | Mode / Size / Density | State    | Anatomy element | Property         | Color token           | Source page     | Source section             | Confidence |
| --------- | ----------------------------- | -------- | --------------------- | -------- | --------------- | ---------------- | --------------------- | --------------- | -------------------------- | ---------- |
| Component | Tree view                     | Standard | Any                   | Enabled  | Label           | text color       | `$text-secondary`     | Tree view style | Color / Interactive states | Documented |
| Component | Tree view                     | Standard | Any                   | Enabled  | Node            | background-color | `$layer`              | Tree view style | Color                      | Documented |
| Component | Tree view                     | Standard | Any                   | Hover    | Node            | background-color | `$layer-hover`        | Tree view style | Interactive states         | Documented |
| Component | Tree view                     | Standard | Any                   | Selected | Node            | background-color | `$layer-selected`     | Tree view style | Interactive states         | Documented |
| Component | Tree view                     | Standard | Any                   | Selected | Node            | border-left      | `$border-interactive` | Tree view style | Interactive states         | Documented |
| Component | Tree view                     | Standard | Any                   | Disabled | Label           | text-color       | `$text-disabled`      | Tree view style | Interactive states         | Documented |

### 9.5. Contained list

Coverage status: Confirmed.

Rows: 7 total; 7 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant             | Mode / Size / Density | State   | Anatomy element    | Property         | Color token       | Source page          | Source section     | Confidence |
| --------- | ----------------------------- | ------------------- | --------------------- | ------- | ------------------ | ---------------- | ----------------- | -------------------- | ------------------ | ---------- |
| Component | Contained list                | On-page / Disclosed | Any                   | Enabled | List title on-page | text color       | `$text-primary`   | Contained list style | Color              | Documented |
| Component | Contained list                | On-page / Disclosed | Any                   | Enabled | Disclosed title    | text color       | `$text-secondary` | Contained list style | Color              | Documented |
| Component | Contained list                | On-page             | Any                   | Enabled | Title background   | background-color | `$background`     | Contained list style | Color              | Documented |
| Component | Contained list                | Disclosed           | Any                   | Enabled | Title background   | background-color | `$layer`          | Contained list style | Color              | Documented |
| Component | Contained list                | Standard            | Any                   | Hover   | Row                | background-color | `$layer-hover`    | Contained list style | Interactive states | Documented |
| Component | Contained list                | Standard            | Any                   | Focus   | Row                | border           | `$focus`          | Contained list style | Interactive states | Documented |
| Component | Contained list                | Standard            | Any                   | Active  | Row                | background-color | `$layer-active`   | Contained list style | Interactive states | Documented |

### 9.6. Code snippet

Coverage status: Confirmed.

Rows: 5 total; 5 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant        | Mode / Size / Density | State   | Anatomy element | Property         | Color token     | Source page        | Source section | Confidence |
| --------- | ----------------------------- | -------------- | --------------------- | ------- | --------------- | ---------------- | --------------- | ------------------ | -------------- | ---------- |
| Component | Code snippet                  | Single line    | Any                   | Enabled | Container       | background       | `$layer`        | Code snippet style | Single line    | Documented |
| Component | Code snippet                  | Single line    | Any                   | Focus   | Container       | border           | `$focus`        | Code snippet style | Single line    | Documented |
| Component | Code snippet                  | Multi-line     | Any                   | Enabled | Icon            | svg              | `$icon-primary` | Code snippet style | Multi-line     | Documented |
| Component | Code snippet                  | Inline snippet | Any                   | Hover   | Container       | background-color | `$layer-hover`  | Code snippet style | Inline snippet | Documented |
| Component | Code snippet                  | Inline snippet | Any                   | Active  | Container       | background-color | `$layer-active` | Code snippet style | Inline snippet | Documented |

### 9.7. List

Coverage status: Confirmed.

Rows: 1 total; 1 documented; 0 needs verification.

| Area      | Component / Pattern / Element | Variant             | Mode / Size / Density | State   | Anatomy element | Property   | Color token     | Source page | Source section | Confidence |
| --------- | ----------------------------- | ------------------- | --------------------- | ------- | --------------- | ---------- | --------------- | ----------- | -------------- | ---------- |
| Component | List                          | Ordered / unordered | Any                   | Enabled | Item            | text-color | `$text-primary` | List style  | Color          | Documented |

### 9.8. Tag

Coverage status: Partial / needs verification.

Rows: 8 total; 5 documented; 3 needs verification.

Tag remains partial because Carbon component-token ownership is documented, but the uploaded addendum did not expose a full all-color component-token enumeration.

| Area      | Component / Pattern / Element | Variant     | Mode / Size / Density | State   | Anatomy element  | Property         | Color token                                                          | Source page | Source section | Confidence         |
| --------- | ----------------------------- | ----------- | --------------------- | ------- | ---------------- | ---------------- | -------------------------------------------------------------------- | ----------- | -------------- | ------------------ |
| Component | Tag                           | Read-only   | All colors            | Enabled | Text             | text-color       | `See all component color tokens`                                     | Tag style   | Color          | Needs verification |
| Component | Tag                           | Read-only   | High contrast         | Enabled | Text             | text-color       | `$text-inverse`                                                      | Tag style   | Color          | Documented         |
| Component | Tag                           | Read-only   | High contrast         | Enabled | Background       | background-color | `$background-inverse`                                                | Tag style   | Color          | Documented         |
| Component | Tag                           | Read-only   | Outline               | Enabled | Text             | text-color       | `$text-primary`                                                      | Tag style   | Color          | Documented         |
| Component | Tag                           | Dismissible | All colors            | Enabled | Background       | background-color | `See all component color tokens`                                     | Tag style   | Color          | Needs verification |
| Component | Tag                           | Dismissible | High contrast         | Enabled | Border           | border           | `$border-inverse`                                                    | Tag style   | Color          | Documented         |
| Component | Tag                           | Dismissible | Outline               | Enabled | Background       | background-color | `$background`                                                        | Tag style   | Color          | Documented         |
| Component | Tag                           | Selectable  | Any                   | Enabled | Token model note | token family     | `Core tokens only; exact row mapping not surfaced on inspected page` | Tag style   | Color          | Needs verification |

## 10. Pattern mapping status

This addendum does not add new Pattern mapping rows. Keep Pattern evidence separate from Component evidence in the merged inventory.

### 10.1. Pattern evidence retained from the prior inventory

| Pattern family                | Status after this addendum                                      | Merge guidance                                                                                                      |
| ----------------------------- | --------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Read-only states              | Prior-inventory evidence only                                   | Keep rows under Pattern mappings, not Component mappings.                                                           |
| Status indicators             | Prior-inventory evidence only                                   | Keep `$status-*` tokens Pattern-scoped unless Login App explicitly adopts a status-indicator token family.          |
| Forms                         | Partial component-style evidence through Form AI-presence rows  | Keep Form AI rows separate from general form validation/status guidance.                                            |
| Loading pattern               | Partial through Loading component rows and core skeleton tokens | Do not claim complete pattern coverage until skeleton-state and page-region guidance is extracted.                  |
| Search / filtering patterns   | Not added in this addendum                                      | Use component Search rows only as Component evidence; Pattern behavior still needs separate extraction if required. |
| Empty states                  | Not added in this addendum                                      | Pictogram/icon/text/action color treatment remains a Pattern extraction gap.                                        |
| Navigation shell              | Not added in this addendum                                      | UI shell and side-nav remained unresolved and must not be treated as adoption-ready.                                |
| Table toolbar / batch actions | Partial through Data table rows                                 | Keep batch-action rows under Data table evidence unless a separate Table toolbar Pattern extraction is completed.   |

## 11. Coverage status and source-page audit

### 11.1. Coverage status table

The coverage table below is cleaned from the uploaded addendum. It records which Carbon resources were checked and how usable each page was for row-level extraction.

| Resource checked                  | Type                | Status              | How it contributed                                                                  | Notes                                                                                       | Source URL / route                                                  |
| --------------------------------- | ------------------- | ------------------- | ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| Color → Tokens                    | Foundation          | Explicit + partial  | Confirmed component-token model, core-token additions, AI-token suite sections      | AI section headings visible; full `$ai-*` list not machine-readable in inspected snapshot   | https://carbondesignsystem.com/elements/color/tokens/               |
| Carbon for AI guideline           | Guideline           | Guidance            | Confirmed Carbon’s AI styling model and component AI-presence context               | High-level guidance, not a token table                                                      | https://carbondesignsystem.com/guidelines/carbon-for-ai/            |
| Notification style                | Component           | Explicit            | Low-contrast and high-contrast notification token rows                              | Strong public coverage                                                                      | https://carbondesignsystem.com/components/notification/style/       |
| Tag style                         | Component           | Partial             | Confirmed component-token ownership rules and explicit high-contrast / outline rows | Exact all-color component token names not surfaced                                          | https://carbondesignsystem.com/components/tag/style/                |
| Content switcher style            | Component           | Partial             | Captured high-contrast and interactive rows                                         | Component-token family exists, but full default-family names not surfaced in inspected text | https://carbondesignsystem.com/components/content-switcher/style/   |
| AI label style                    | Component           | Explicit            | Default, inline, and explainability-popover AI token mappings                       | Best direct public exposure of several `$ai-*` tokens                                       | https://carbondesignsystem.com/components/ai-label/style/           |
| Menu style                        | Component           | Explicit            | Full default + interactive mapping rows                                             | Also confirms contextual-token asterisk convention                                          | https://carbondesignsystem.com/components/menu/style/               |
| Overflow menu style               | Component           | Explicit            | Default + interactive mapping rows                                                  | Good coverage                                                                               | https://carbondesignsystem.com/components/overflow-menu/style/      |
| Link style                        | Component           | Explicit            | Full link/icon state table                                                          | Good coverage                                                                               | https://carbondesignsystem.com/components/link/style/               |
| Radio button style                | Component           | Explicit            | Full state table + AI-label note                                                    | Good coverage                                                                               | https://carbondesignsystem.com/components/radio-button/style/       |
| Search style                      | Component           | Explicit            | Default, filled, focus, disabled rows                                               | Good coverage                                                                               | https://carbondesignsystem.com/components/search/style/             |
| Slider style                      | Component           | Explicit            | Default, focus, active, error/warning, disabled, read-only                          | Good coverage                                                                               | https://carbondesignsystem.com/components/slider/style/             |
| File uploader style               | Component           | Explicit            | Heading, drop zone, file rows, invalid, disabled                                    | Contains at least one token-string typo in docs                                             | https://carbondesignsystem.com/components/file-uploader/style/      |
| Dropdown style                    | Component           | Explicit + merged   | Shared page for Dropdown, Combo box, and Multiselect, plus AI presence              | Combo box has no separate style page in inspected current docs                              | https://carbondesignsystem.com/components/dropdown/style/           |
| Text input style                  | Component           | Explicit + merged   | Shared page for Text input, Password input, Text area, and AI presence              | Good coverage                                                                               | https://carbondesignsystem.com/components/text-input/style/         |
| Number input style                | Component           | Explicit            | Full token table + AI presence                                                      | Contains several token-string typos/omitted `$` in docs                                     | https://carbondesignsystem.com/components/number-input/style/       |
| Select style                      | Component           | Explicit            | Default/fluid states + AI presence                                                  | Good coverage                                                                               | https://carbondesignsystem.com/components/select/style/             |
| Checkbox style                    | Component           | Explicit            | Full state table + AI-label note                                                    | Good coverage                                                                               | https://carbondesignsystem.com/components/checkbox/style/           |
| Toggle style                      | Component           | Explicit            | Off/on, disabled, read-only, feature-flag note                                      | Good coverage                                                                               | https://carbondesignsystem.com/components/toggle/style/             |
| Date picker style                 | Component           | Explicit + merged   | Date picker, calendar, time picker, AI presence                                     | Time picker is documented here rather than on a separate page                               | https://carbondesignsystem.com/components/date-picker/style/        |
| Breadcrumb style                  | Component           | Explicit            | Standard and overflow token mappings                                                | Good coverage                                                                               | https://carbondesignsystem.com/components/breadcrumb/style/         |
| Tabs style                        | Component           | Explicit            | Line, dismissible, contained, vertical tables                                       | One of the richest style pages                                                              | https://carbondesignsystem.com/components/tabs/style/               |
| Modal style                       | Component           | Explicit            | Base modal + AI modal token mappings                                                | Good coverage                                                                               | https://carbondesignsystem.com/components/modal/style/              |
| Popover style                     | Component           | Partial             | Container background rows only                                                      | Variant naming is sparse in accessible text                                                 | https://carbondesignsystem.com/components/popover/style/            |
| Tooltip style                     | Component           | Explicit            | Open-state container/text and definition-tooltip states                             | Good coverage                                                                               | https://carbondesignsystem.com/components/tooltip/style/            |
| Toggletip style                   | Component           | Explicit            | Closed/open and focus/hover rows                                                    | Good coverage                                                                               | https://carbondesignsystem.com/components/toggletip/style/          |
| Inline loading style              | Component           | Explicit            | Spinner strokes, text, success status icon                                          | Error/failure row label appears truncated in accessible snapshot                            | https://carbondesignsystem.com/components/inline-loading/style/     |
| Loading style                     | Component           | Explicit            | Indicator + overlay rows                                                            | Good coverage                                                                               | https://carbondesignsystem.com/components/loading/style/            |
| Progress indicator style          | Component           | Explicit            | Complete/current/not started + focus/error/disabled                                 | Good coverage                                                                               | https://carbondesignsystem.com/components/progress-indicator/style/ |
| Progress bar style                | Component           | Explicit            | Active/success/error track rows                                                     | Good coverage                                                                               | https://carbondesignsystem.com/components/progress-bar/style/       |
| Data table style                  | Component           | Explicit            | Header, row, toolbar, batch actions, AI presence                                    | One of the richest pages                                                                    | https://carbondesignsystem.com/components/data-table/style/         |
| Structured list style             | Component           | Explicit + partial  | Default, selectable, with-background rows                                           | Some with-background interactive states appear image-only in accessible snapshot            | https://carbondesignsystem.com/components/structured-list/style/    |
| Tile style                        | Component           | Explicit            | Base, clickable, selectable, expandable, AI variant                                 | Good coverage                                                                               | https://carbondesignsystem.com/components/tile/style/               |
| Tree view style                   | Component           | Explicit            | Full state table                                                                    | Good coverage                                                                               | https://carbondesignsystem.com/components/tree-view/style/          |
| Code snippet style                | Component           | Explicit + guidance | Single-line, multi-line, inline snippets                                            | Syntax-color section is guidance-only on this page                                          | https://carbondesignsystem.com/components/code-snippet/style/       |
| Pagination style                  | Component           | Explicit            | Standard + nav variants                                                             | Good coverage                                                                               | https://carbondesignsystem.com/components/pagination/style/         |
| Contained list style              | Component           | Explicit + guidance | Variant colors + row states                                                         | Inline actions referenced mostly by example, not a full token table                         | https://carbondesignsystem.com/components/contained-list/style/     |
| List style                        | Component           | Explicit            | Item text color                                                                     | Minimal but explicit                                                                        | https://carbondesignsystem.com/components/list/style/               |
| Combo box standalone style slug   | Component           | Merged / unresolved | Covered through Dropdown style page                                                 | Current docs appear to fold combo box into Dropdown style coverage                          |                                                                     |
| Time picker standalone style slug | Component           | Merged / unresolved | Covered through Date picker style page                                              | Current docs appear to fold time picker into Date picker style coverage                     |                                                                     |
| UI shell style slug               | Component / pattern | Unresolved          | Not extractable in this session                                                     | Candidate for future source/doc follow-up                                                   |                                                                     |
| Side nav style slug               | Component / pattern | Unresolved          | Not extractable in this session                                                     | Candidate for future source/doc follow-up                                                   |                                                                     |
| Skeleton-states style slug        | Component / pattern | Unresolved          | Only skeleton core tokens confirmed from Color tokens page                          | Candidate for future source/doc follow-up                                                   |                                                                     |

### 11.2. Source URL index

The source labels in the mapping tables refer to current Carbon style or token pages. Use this index when verifying rows.

| Source label             | URL                                                                 |
| ------------------------ | ------------------------------------------------------------------- |
| AI label style           | https://carbondesignsystem.com/components/ai-label/style/           |
| Breadcrumb style         | https://carbondesignsystem.com/components/breadcrumb/style/         |
| Carbon for AI guideline  | https://carbondesignsystem.com/guidelines/carbon-for-ai/            |
| Checkbox style           | https://carbondesignsystem.com/components/checkbox/style/           |
| Code snippet style       | https://carbondesignsystem.com/components/code-snippet/style/       |
| Color → Tokens           | https://carbondesignsystem.com/elements/color/tokens/               |
| Contained list style     | https://carbondesignsystem.com/components/contained-list/style/     |
| Content switcher style   | https://carbondesignsystem.com/components/content-switcher/style/   |
| Data table style         | https://carbondesignsystem.com/components/data-table/style/         |
| Date picker style        | https://carbondesignsystem.com/components/date-picker/style/        |
| Dropdown style           | https://carbondesignsystem.com/components/dropdown/style/           |
| File uploader style      | https://carbondesignsystem.com/components/file-uploader/style/      |
| Inline loading style     | https://carbondesignsystem.com/components/inline-loading/style/     |
| Link style               | https://carbondesignsystem.com/components/link/style/               |
| List style               | https://carbondesignsystem.com/components/list/style/               |
| Loading style            | https://carbondesignsystem.com/components/loading/style/            |
| Menu style               | https://carbondesignsystem.com/components/menu/style/               |
| Modal style              | https://carbondesignsystem.com/components/modal/style/              |
| Notification style       | https://carbondesignsystem.com/components/notification/style/       |
| Number input style       | https://carbondesignsystem.com/components/number-input/style/       |
| Overflow menu style      | https://carbondesignsystem.com/components/overflow-menu/style/      |
| Pagination style         | https://carbondesignsystem.com/components/pagination/style/         |
| Popover style            | https://carbondesignsystem.com/components/popover/style/            |
| Progress bar style       | https://carbondesignsystem.com/components/progress-bar/style/       |
| Progress indicator style | https://carbondesignsystem.com/components/progress-indicator/style/ |
| Radio button style       | https://carbondesignsystem.com/components/radio-button/style/       |
| Search style             | https://carbondesignsystem.com/components/search/style/             |
| Select style             | https://carbondesignsystem.com/components/select/style/             |
| Slider style             | https://carbondesignsystem.com/components/slider/style/             |
| Structured list style    | https://carbondesignsystem.com/components/structured-list/style/    |
| Tabs style               | https://carbondesignsystem.com/components/tabs/style/               |
| Tag style                | https://carbondesignsystem.com/components/tag/style/                |
| Text input style         | https://carbondesignsystem.com/components/text-input/style/         |
| Tile style               | https://carbondesignsystem.com/components/tile/style/               |
| Toggle style             | https://carbondesignsystem.com/components/toggle/style/             |
| Toggletip style          | https://carbondesignsystem.com/components/toggletip/style/          |
| Tooltip style            | https://carbondesignsystem.com/components/tooltip/style/            |
| Tree view style          | https://carbondesignsystem.com/components/tree-view/style/          |

## 12. Remaining gaps after this addendum

### 12.1. Highest-priority remaining gaps

| Gap                                          | Why it remains                                                                                                                           | Required next step                                                              |
| -------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- |
| Tag full component-token family              | Current rows include high-contrast, outline, dismissible, and selectable notes, but not the exact all-color component-token enumeration. | Verify current public docs and official package/source token modules.           |
| Content switcher full component-token family | Current rows include high-contrast mappings but not full default component-token mappings.                                               | Verify public style docs and source token module.                               |
| Full AI-token master catalog                 | Component pages expose many `$ai-*` tokens, but the full token-page AI sections were not recovered as a stable complete list.            | Extract from current token docs and verify against official package source.     |
| UI shell / side nav                          | Standalone style pages were unresolved in the addendum.                                                                                  | Perform targeted Carbon docs/source verification for shell/navigation surfaces. |
| Skeleton states                              | Only core skeleton tokens were confirmed; no standalone skeleton-state mappings were extracted.                                          | Review Carbon Loading/Skeleton docs and source for row-level mappings.          |
| Slider and File uploader row mappings        | Coverage table marks them explicit, but row-level mappings were not present in the uploaded addendum.                                    | Re-extract rows or insert from verified source.                                 |

### 12.2. Documentation quality caveats

Preserve apparent Carbon documentation anomalies exactly in the evidence log and annotate them instead of silently correcting them.

| Issue                                                    | Where surfaced                                                                                              | Merge rule                                                                   |
| -------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Missing `$` prefix in token names                        | Number input rows such as `field-hover`; possible File uploader hover row noted in coverage text.           | Mark as possible documentation-generation issue until verified.              |
| Unusual token name `$icon-color`                         | Tag page caveat in remaining-gaps text.                                                                     | Do not normalize to `$icon-primary` without source confirmation.             |
| Feature-flagged components                               | Structured list, Tile, Toggle, Tree view and other current Carbon feature-flag references where applicable. | Mark as feature-flagged or source-verification required before app adoption. |
| Component-token families without full public enumeration | Tag and Content switcher.                                                                                   | Treat as known Carbon families with incomplete public enumeration.           |

## 13. Login App merge guidance

### 13.1. Merge into Color Element standard

Keep only global governance in the Login App Color Element standard:

- Global semantic color roles.
- Theme behavior.
- Contextual aliases and layer behavior.
- Focus, support/status, link, icon, border, field, overlay, skeleton, inverse, and disabled governance.
- Prohibitions against raw colors and direct Carbon class/token copying.

### 13.2. Merge into Component standards

Move component-specific mappings into the owning Component standard when they become app-relevant:

- Button-like variants and action hierarchy.
- Field/control states and validation.
- Tag, Notification, Content switcher, and other component-token families.
- Data table row/header/selection/batch-action states.
- Overlay, menu, tooltip, tree, tile, list, and navigation component states.

### 13.3. Merge into Pattern standards

Move composition-level mappings into Pattern standards:

- Read-only vs. disabled escalation.
- Status indicator semantics.
- Empty/no-results/blocked/unavailable states.
- Form validation summaries.
- Search/filter and table toolbar behavior.
- Shell/navigation layering.
- Loading and skeleton region behavior.

### 13.4. Adoption policy fields

Add these fields to any downstream inventory or spreadsheet:

| Field                | Allowed values                                                                                | Purpose                                                           |
| -------------------- | --------------------------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Carbon evidence type | `Core`, `Contextual alias`, `Component token`, `AI token`, `Pattern token`, `Guidance-only`   | Prevents flattening Carbon evidence into one app-wide token pool. |
| Carbon confidence    | `Documented`, `Needs verification`, `Source-inferred`, `Docs-source conflict`, `Undocumented` | Preserves evidence quality.                                       |
| Adoption policy      | `Adopt`, `Benchmark`, `Quarantine`, `App decision required`, `Do not adopt`                   | Separates research from Login App standards decisions.            |

## 14. Related files

| Reference                                  | Path                                                            |
| ------------------------------------------ | --------------------------------------------------------------- |
| Login App Color Element standard           | `docs/02-standards/ui/elements/color.md`                        |
| Prior Carbon color-token mapping inventory | `docs/02-standards/ui/elements/color-carbon-token-inventory.md` |
| This addendum                              | `docs/02-standards/ui/elements/color-carbon-token-addendum.md`  |
| Carbon source notes                        | `docs/02-standards/ui/carbon-source-notes.md`                   |

## 15. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon source notes](../carbon-source-notes.md)
- Carbon Design System color, component style, AI, and pattern pages remain third-party reference material only. Login App standards must translate relevant concepts into app-owned color roles before implementation.
