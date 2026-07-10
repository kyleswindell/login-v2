---
title: Typography
slug: typography
guide_status: implemented
system_maturity: implemented-standard
api_layer: Foundation Element API
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/elements/typography.md
carbon_reference:
  - https://carbondesignsystem.com/elements/typography/overview/
  - https://carbondesignsystem.com/elements/typography/style-strategies/
  - https://carbondesignsystem.com/elements/typography/type-sets/
  - https://carbondesignsystem.com/elements/typography/code/
related_elements:
  - color
  - spacing
  - themes
  - 2x-grid
  - icons
  - motion
related_components:
  - button
  - link
  - text-input
  - textarea
  - notification
  - data-table
  - code-snippet
related_patterns:
  - forms
  - layout
  - navigation
  - data-content
---

# Typography Element API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
  - [2.1. Carbon benchmark note](#21-carbon-benchmark-note)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed type-set model](#31-installed-type-set-model)
  - [3.2. Productive Type Set](#32-productive-type-set)
    - [3.2.1. Purpose](#321-purpose)
    - [3.2.2. Required productive contexts](#322-required-productive-contexts)
    - [3.2.3. Productive rules](#323-productive-rules)
    - [3.2.4. Productive anti-patterns](#324-productive-anti-patterns)
  - [3.3. Expressive Type Set](#33-expressive-type-set)
    - [3.3.1. Purpose](#331-purpose)
    - [3.3.2. Required expressive contexts](#332-required-expressive-contexts)
    - [3.3.3. Expressive rules](#333-expressive-rules)
    - [3.3.4. Expressive anti-patterns](#334-expressive-anti-patterns)
  - [3.4. Type-set blending standard](#34-type-set-blending-standard)
    - [3.4.1. Approved blends](#341-approved-blends)
    - [3.4.2. Prohibited blends](#342-prohibited-blends)
  - [3.5. Type selection decision tree](#35-type-selection-decision-tree)
    - [3.5.1. Step 1. Identify the role](#351-step-1-identify-the-role)
    - [3.5.2. Step 2. Identify the owner](#352-step-2-identify-the-owner)
    - [3.5.3. Step 3. Select the type set](#353-step-3-select-the-type-set)
    - [3.5.4. Step 4. Select the approved role class or helper](#354-step-4-select-the-approved-role-class-or-helper)
  - [3.6. Installed font stacks](#36-installed-font-stacks)
  - [3.7. Installed hierarchy model](#37-installed-hierarchy-model)
  - [3.8. Installed weight model](#38-installed-weight-model)
  - [3.9. Installed code and monospace model](#39-installed-code-and-monospace-model)
- [4. Token API](#4-token-api)
  - [4.1. Type-set context tokens](#41-type-set-context-tokens)
  - [4.2. Productive type roles](#42-productive-type-roles)
  - [4.3. Expressive type roles](#43-expressive-type-roles)
  - [4.4. Shared code roles](#44-shared-code-roles)
  - [4.5. Legacy role-class compatibility](#45-legacy-role-class-compatibility)
  - [4.6. Type scale guidance](#46-type-scale-guidance)
    - [4.6.1. Productive fixed scale](#461-productive-fixed-scale)
    - [4.6.2. Expressive responsive scale](#462-expressive-responsive-scale)
- [5. CSS variable API](#5-css-variable-api)
  - [5.1. Font-family variables](#51-font-family-variables)
  - [5.2. Type-set variables](#52-type-set-variables)
  - [5.3. Text color variables](#53-text-color-variables)
  - [5.4. Not approved CSS variables](#54-not-approved-css-variables)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Public type-set classes](#61-public-type-set-classes)
  - [6.2. Public role classes](#62-public-role-classes)
  - [6.3. Allowed utility families](#63-allowed-utility-families)
  - [6.4. Preferred productive examples](#64-preferred-productive-examples)
    - [6.4.1. Productive page header](#641-productive-page-header)
    - [6.4.2. Productive field and action text](#642-productive-field-and-action-text)
  - [6.5. Preferred expressive examples](#65-preferred-expressive-examples)
    - [6.5.1. Expressive empty state](#651-expressive-empty-state)
    - [6.5.2. Expressive onboarding intro with productive controls](#652-expressive-onboarding-intro-with-productive-controls)
  - [6.6. Preferred code examples](#66-preferred-code-examples)
    - [6.6.1. Inline technical value](#661-inline-technical-value)
    - [6.6.2. Code snippet](#662-code-snippet)
  - [6.7. Not approved examples](#67-not-approved-examples)
    - [6.7.1. Local typography class](#671-local-typography-class)
    - [6.7.2. Arbitrary utility styling](#672-arbitrary-utility-styling)
    - [6.7.3. Placeholder-only label](#673-placeholder-only-label)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Type-set selection guidance](#71-type-set-selection-guidance)
  - [7.2. Role selection guidance](#72-role-selection-guidance)
  - [7.3. Relationship guidance](#73-relationship-guidance)
  - [7.4. Tips and techniques](#74-tips-and-techniques)
    - [7.4.1. Preserve semantic structure](#741-preserve-semantic-structure)
    - [7.4.2. Use type sets as moments](#742-use-type-sets-as-moments)
    - [7.4.3. Keep body copy readable](#743-keep-body-copy-readable)
    - [7.4.4. Use contrast through hierarchy, not random styling](#744-use-contrast-through-hierarchy-not-random-styling)
    - [7.4.5. Pair headings and body roles deliberately](#745-pair-headings-and-body-roles-deliberately)
    - [7.4.6. Keep dense UI dense](#746-keep-dense-ui-dense)
  - [7.5. Readability and accessibility rules](#75-readability-and-accessibility-rules)
  - [7.6. Content writing rules](#76-content-writing-rules)
    - [7.6.1. Labels](#761-labels)
    - [7.6.2. Helper text](#762-helper-text)
    - [7.6.3. Validation text](#763-validation-text)
    - [7.6.4. Button and action labels](#764-button-and-action-labels)
    - [7.6.5. Links](#765-links)
    - [7.6.6. Code and technical copy](#766-code-and-technical-copy)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Component consumer rules](#81-component-consumer-rules)
  - [8.2. Pattern consumer rules](#82-pattern-consumer-rules)
  - [8.3. Feature/page consumer rules](#83-featurepage-consumer-rules)
- [9. Theme behavior](#9-theme-behavior)
  - [9.1. Theme context requirements](#91-theme-context-requirements)
  - [9.2. Type-set theme behavior](#92-type-set-theme-behavior)
    - [9.2.1. Productive theme behavior](#921-productive-theme-behavior)
    - [9.2.2. Expressive theme behavior](#922-expressive-theme-behavior)
  - [9.3. Theme prohibition](#93-theme-prohibition)
- [10. State behavior](#10-state-behavior)
  - [10.1. State ownership matrix](#101-state-ownership-matrix)
  - [10.2. Expressive state behavior](#102-expressive-state-behavior)
- [11. Prohibited usage](#11-prohibited-usage)
- [12. Deferred or gated capabilities](#12-deferred-or-gated-capabilities)
- [13. Rendered evidence requirements](#13-ui-reference-requirements)
  - [13.1. Required page structure](#131-required-page-structure)
  - [13.2. Required live examples](#132-required-live-examples)
  - [13.3. Required developer API references on the page](#133-required-developer-api-references-on-the-page)
    - [13.3.1. Type-set APIs](#1331-type-set-apis)
    - [13.3.2. Productive compatibility APIs](#1332-productive-compatibility-apis)
    - [13.3.3. Code APIs](#1333-code-apis)
    - [13.3.4. Boundaries](#1334-boundaries)
  - [13.4. Required page text](#134-required-page-text)
- [14. Testing and acceptance criteria](#14-testing-and-acceptance-criteria)
  - [14.1. Suggested automated assertions](#141-suggested-automated-assertions)
- [15. Related APIs](#15-related-apis)
- [16. References](#16-references)

## 1. API summary

Typography controls readable hierarchy, role-based text styling, labels, helper text, validation copy, captions, links, code, and high-presence editorial moments.

Typography is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local font size, font family, weight, line height, letter spacing, text color, or type-set behavior.

Use the Typography Element API whenever implementation needs a text role. Choose the text role first, then the type set, then the owning Component or Pattern API. Do not choose typography by visual preference.

### 1.1. Canonical API responsibilities

- Define the installed Productive Type Set and Expressive Type Set.
- Define role-based type usage for page, section, card, field, table, navigation, status, code, and documentation contexts.
- Define the public typography classes, CSS variables, helpers, and token roles consumed by Components and Patterns.
- Define fixed and fluid heading ownership.
- Define productive and expressive blending rules.
- Define typography boundaries for labels, helper text, validation text, links, buttons, metadata, code, and long-form content.
- Define theme-safe text behavior through Color and Themes Elements.
- Define typography-specific accessibility and content rules.
- Prohibit local font-size, line-height, font-family, weight, color, letter-spacing, and truncation decisions in feature code.

### 1.2. Non-owned responsibilities

- Text color values. Use the Color Element API.
- External spacing between text blocks, cards, fields, and page sections. Use Spacing and 2x Grid Element APIs.
- Icon sizing, icon alignment, and icon selection. Use the Icons Element API.
- Motion, focus transitions, and reduced-motion behavior. Use the Motion Element API.
- Full page layout hierarchy. Use Pattern APIs and layout wrappers.
- Component-specific label placement, helper placement, validation placement, or table-cell behavior. Use the owning Component API.

## 2. Status and ownership

| Field              | Value                                                                                         |
| ------------------ | --------------------------------------------------------------------------------------------- |
| Guide status       | Implemented                                                                                   |
| System maturity    | Implemented standard                                                                          |
| API layer          | Foundation Element API                                                                        |
| Element slug       | typography                                                                                    |
| Rendered evidence route | `not installed`; `not installed` |
| Canonical doc      | `docs/02-standards/ui/elements/typography.md`                                                 |
| Primary consumers  | Components, Patterns, page shell, docs pages, forms, tables, cards, notifications, navigation |
| Required type sets | Productive Type Set and Expressive Type Set                                                   |
| Carbon benchmark   | Carbon Typography overview, style strategies, type sets, and code guidance                    |

`Implemented standard` means Productive and Expressive type sets are part of the app typography model. Productive remains the default for task-oriented product UI. Expressive is no longer deferred; it is an installed type set with controlled Pattern ownership for high-presence, explanatory, onboarding, documentation, and editorial moments.

### 2.1. Carbon benchmark note

Carbon uses typography tokens across two type sets: Productive and Expressive. Carbon positions productive styles for task-focused product spaces and expressive styles for larger editorial or marketing-style moments, while also allowing intentional blends when the alternate type set better supports hierarchy or user intent. Login App keeps its own font stack, `ui-*` namespace, CSS variable model, Blade components, and rendered evidence proof.

## 3. Installed standard

Typography is installed as a role-based type system with two required type sets.

### 3.1. Installed type-set model

| Type set            | Status                     | Default base | Heading behavior                                | Primary role                                                                                     |
| ------------------- | -------------------------- | -----------: | ----------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| Productive Type Set | Implemented default        |         14px | Fixed headings                                  | Dense, task-focused product UI.                                                                  |
| Expressive Type Set | Implemented controlled set |         16px | Fixed small headings plus fluid larger headings | High-presence, explanatory, onboarding, help, documentation, empty-state, and editorial moments. |

Both type sets are required standards. The question is not whether expressive type is allowed; the question is which owner is allowed to select it.

### 3.2. Productive Type Set

#### 3.2.1. Purpose

Use Productive Type Set for work surfaces where users need to complete tasks efficiently.

#### 3.2.2. Required productive contexts

- Admin pages.
- Settings pages.
- Forms and validation.
- Data tables.
- Toolbars.
- Navigation.
- Cards in dense product UI.
- Modals and side panels used for tasks.
- Notifications and status messages.
- rendered evidence implementation tables and developer examples.

#### 3.2.3. Productive rules

- Use fixed type styles.
- Use compact body styles for dense UI.
- Use semibold headings and labels only where hierarchy requires it.
- Keep helper and metadata copy concise.
- Use productive body text for component-level explanatory text.
- Use productive headings inside containers, forms, tables, panels, cards, and overlays.

#### 3.2.4. Productive anti-patterns

- Do not use expressive display type inside dense table rows, form rows, modal action areas, or navigation menus.
- Do not enlarge individual labels, helper text, or button text to create emphasis.
- Do not create local page-title sizes because a page feels visually weak.

### 3.3. Expressive Type Set

#### 3.3.1. Purpose

Use Expressive Type Set for moments where type needs to create a clearer pause, a stronger hierarchy, or a more readable explanatory surface.

#### 3.3.2. Required expressive contexts

- Onboarding intro panels.
- Empty states with a high-presence explanation.
- No-results recovery surfaces when explanation matters more than density.
- Documentation or help landing sections.
- Learning-oriented feature introductions.
- Large explanatory cards or banners where the content is not competing with dense controls.
- Editorial-style rendered evidence or platform documentation moments.

#### 3.3.3. Expressive rules

- Use expressive type through Pattern-owned role classes or documented Pattern slots.
- Use expressive headings to create high-presence hierarchy.
- Use expressive body copy when reading comfort matters more than dense control proximity.
- Use fluid expressive headings where the standard or owning Pattern defines responsive behavior.
- Keep productive controls productive inside expressive regions unless the owning Pattern explicitly documents otherwise.
- Treat expressive type as a designed moment, not a feature-code style preference.

#### 3.3.4. Expressive anti-patterns

- Do not use expressive type for every page title by default.
- Do not use expressive headings inside tables, compact cards, dense forms, button groups, toolbars, menus, or inline validation.
- Do not use expressive body copy for dense admin instructions that should remain compact.
- Do not mix multiple expressive heading levels in one small card.

### 3.4. Type-set blending standard

Productive and Expressive type sets may be blended only when the hierarchy becomes clearer and the ownership boundary remains explicit.

#### 3.4.1. Approved blends

| Blend                                                          | Owner                                | Use                                                                 |
| -------------------------------------------------------------- | ------------------------------------ | ------------------------------------------------------------------- |
| Expressive heading with productive body                        | Pattern                              | Empty states, onboarding intros, documentation landing sections.    |
| Expressive heading with productive controls                    | Pattern                              | A banner or intro panel followed by task controls.                  |
| Productive page with expressive empty-state title              | Data/content Pattern                 | No-results or blocked states where a larger message helps recovery. |
| Expressive documentation content with productive code examples | Documentation Pattern + Code snippet | Help/reference pages that include implementation examples.          |
| Productive shell/navigation with expressive main-region moment | Navigation Pattern + page Pattern    | High-presence page content inside the normal app shell.             |

#### 3.4.2. Prohibited blends

| Blend                                                          | Reason                                                          |
| -------------------------------------------------------------- | --------------------------------------------------------------- |
| Expressive labels inside productive forms                      | Breaks field density and label consistency.                     |
| Expressive table cell text                                     | Breaks scanability and row comparison.                          |
| Expressive button labels                                       | Button Component owns action typography.                        |
| Expressive helper/error text                                   | Field and validation APIs own helper/error legibility.          |
| Expressive navigation labels                                   | Navigation needs stable, compact orientation.                   |
| Productive and expressive utilities mixed inside one paragraph | Creates local visual styling instead of a role-based hierarchy. |

### 3.5. Type selection decision tree

#### 3.5.1. Step 1. Identify the role

Choose whether the text is a page title, section heading, body copy, label, helper text, validation text, link, action label, metadata, code, or high-presence explanatory content.

#### 3.5.2. Step 2. Identify the owner

Use the Component API for component text, the Pattern API for cross-component hierarchy, and the Element API for raw role rules.

#### 3.5.3. Step 3. Select the type set

Use Productive for task-dense product UI. Use Expressive for a Pattern-owned explanatory or high-presence moment.

#### 3.5.4. Step 4. Select the approved role class or helper

Use an installed `ui-*` role class, Component prop, Pattern slot, or documented utility. Do not use arbitrary values.

### 3.6. Installed font stacks

Login App uses system font stacks by default. IBM Plex remains a Carbon comparison reference only; it is not an installed app dependency.

| Stack | Installed family list                                                                                                                           | Use for                                                                                                          |
| ----- | ----------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Sans  | `ui-sans-serif`, `system-ui`, `-apple-system`, `BlinkMacSystemFont`, `Segoe UI`, `Roboto`, `Helvetica Neue`, `Arial`, `Noto Sans`, `sans-serif` | Product UI, labels, navigation, forms, tables, notifications, reference pages, help content, and normal content. |
| Mono  | `ui-monospace`, `SFMono-Regular`, `Menlo`, `Monaco`, `Consolas`, `Liberation Mono`, `Courier New`, `monospace`                                  | Code snippets, commands, tokens, paths, IDs, technical values, and developer implementation examples.            |

### 3.7. Installed hierarchy model

| Role                     | Installed class/API                                            | Type set        | Typical element              | Use when                                                           |
| ------------------------ | -------------------------------------------------------------- | --------------- | ---------------------------- | ------------------------------------------------------------------ |
| Productive page title    | `ui-page-header-title`; `ui-type-productive-heading-05`        | Productive      | `h1`                         | Primary title for an app page or rendered evidence page.                |
| Productive page intro    | `ui-page-header-copy`; `ui-type-productive-body`               | Productive      | `p`                          | Introductory page guidance under the page title.                   |
| Expressive page title    | `ui-expressive-page-title`; `ui-type-expressive-heading-05`    | Expressive      | `h1`                         | Pattern-owned onboarding, help, docs, or high-presence page intro. |
| Expressive page intro    | `ui-expressive-page-copy`; `ui-type-expressive-body`           | Expressive      | `p`                          | Pattern-owned explanatory copy with more comfortable reading.      |
| Kicker/eyebrow           | `ui-kicker`; `ui-type-productive-label`                        | Productive      | `p`, `span`                  | Small context label above a section/card title.                    |
| Expressive kicker        | `ui-expressive-kicker`; `ui-type-expressive-label`             | Expressive      | `p`, `span`                  | High-presence intro or documentation section label.                |
| Card/section title       | `ui-card-title`; `ui-type-productive-heading-03`               | Productive      | `h2`, `h3`                   | Title inside cards, panels, component sections, and docs regions.  |
| Expressive section title | `ui-expressive-section-title`; `ui-type-expressive-heading-03` | Expressive      | `h2`, `h3`                   | Pattern-owned explanatory sections.                                |
| Card/supporting copy     | `ui-card-copy`; `ui-type-productive-body`                      | Productive      | `p`                          | Supporting text inside card or reference sections.                 |
| Expressive body copy     | `ui-expressive-body`; `ui-type-expressive-body`                | Expressive      | `p`, `li`                    | Longer help/onboarding/explanatory copy.                           |
| Field label              | Component-owned field label class/API                          | Productive      | `label`                      | Visible form labels and control names.                             |
| Field helper text        | Component-owned helper text class/API                          | Productive      | `p`, `div`                   | Non-blocking field or control guidance.                            |
| Validation text          | Component-owned validation/error class/API                     | Productive      | `p`, `div`                   | Error, warning, or success feedback tied to a field or action.     |
| Caption/metadata         | `ui-type-productive-label`; caption/helper utilities           | Productive      | `span`, `p`, `figcaption`    | Timestamps, source labels, secondary metadata, small helper notes. |
| Link text                | `ui-link` or Link Component API                                | Productive      | `a`                          | Navigation to another route or resource.                           |
| Button/action text       | Button Component API                                           | Productive      | `button`, app-owned CTA link | Action labels.                                                     |
| Table header             | Data table Component API                                       | Productive      | `th`                         | Column labels and sortable headers.                                |
| Table cell               | Data table Component API                                       | Productive      | `td`                         | Cell content, metadata, inline actions.                            |
| Code text                | `font-mono`, `ui-code-snippet`, `ui-code-token-*`              | Productive/code | `code`, `pre`                | Tokens, file paths, component calls, commands, and examples.       |

### 3.8. Installed weight model

| Weight role | Status                  | Use for                                                                                              | Avoid for                                                            |
| ----------- | ----------------------- | ---------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Regular     | Implemented default     | Body copy, helper copy, captions, table cells, and normal labels where the component API chooses it. | Emphasis that needs hierarchy.                                       |
| Medium      | Implemented             | Slight emphasis, compact UI labels, table headers, and metadata where semibold is too strong.        | Long running text.                                                   |
| Semibold    | Implemented             | Productive headings, labels, button text, status labels, and important short emphasis.               | Paragraphs, helper text, dense table cells, or long-form copy.       |
| Light       | Expressive heading only | Large expressive headings where the Pattern owns the hierarchy.                                      | Productive UI, labels, controls, tables, and small headings.         |
| Bold        | Limited                 | Rare third-party content or Pattern-owned expressive moments only.                                   | General admin UI.                                                    |
| Italic      | Limited                 | Short inline emphasis, terms, captions, or quoted titles when needed.                                | Required instructions, validation, button labels, or long body copy. |

### 3.9. Installed code and monospace model

Use monospace text only for technical material:

- CSS variables and design tokens.
- Blade component calls.
- Class names.
- File paths.
- Commands.
- IDs, keys, slugs, and machine-readable values.
- Inline code snippets and code blocks.

Do not use monospace for visual decoration, emphasis, or ordinary metadata.

## 4. Token API

Typography tokens are exposed by role and type set. Component and Pattern standards may map these roles to internal classes, props, slots, or generated CSS.

### 4.1. Type-set context tokens

| Token/helper           | Status                                    | Allowed API/consumer                                     | Example                                                   |
| ---------------------- | ----------------------------------------- | -------------------------------------------------------- | --------------------------------------------------------- |
| Productive context     | Implemented                               | `ui-type-set-productive`; default app shell/page context | Dense admin pages and forms.                              |
| Expressive context     | Implemented                               | `ui-type-set-expressive`; Pattern-owned sections         | Onboarding, empty states, help, docs, explanatory panels. |
| Productive base        | Implemented                               | `--ui-type-productive-base-size`                         | `14px` expected base.                                     |
| Expressive base        | Implemented                               | `--ui-type-expressive-base-size`                         | `16px` expected base.                                     |
| Fixed heading behavior | Implemented                               | Productive headings and small expressive headings        | Container and task UI.                                    |
| Fluid heading behavior | Implemented for expressive large headings | Pattern-owned expressive headings and display roles      | Responsive high-presence moments.                         |

### 4.2. Productive type roles

| Token/helper               | CSS variable or class                | Allowed API/consumer                     | Example                          |
| -------------------------- | ------------------------------------ | ---------------------------------------- | -------------------------------- |
| Productive label           | `ui-type-productive-label`           | Field labels, captions, compact metadata | Component label text.            |
| Productive helper          | `ui-type-productive-helper`          | Field helper text and compact guidance   | Form helper copy.                |
| Productive legal           | `ui-type-productive-legal`           | Legal/footnote copy in product UI        | Footer or disclosure copy.       |
| Productive body compact    | `ui-type-productive-body-compact`    | Dense body copy inside components        | Compact cards, table details.    |
| Productive body            | `ui-type-productive-body`            | Standard product body copy               | Cards, modal copy, docs details. |
| Productive heading compact | `ui-type-productive-heading-compact` | Small layout headings                    | Dense cards, panel headings.     |
| Productive heading 01      | `ui-type-productive-heading-01`      | Small component/layout headings          | Table sections, form sections.   |
| Productive heading 02      | `ui-type-productive-heading-02`      | Secondary layout headings                | Cards and panels.                |
| Productive heading 03      | `ui-type-productive-heading-03`      | Component and layout headings            | Section titles.                  |
| Productive heading 04      | `ui-type-productive-heading-04`      | Larger layout headings                   | Major page sections.             |
| Productive heading 05      | `ui-type-productive-heading-05`      | Page titles                              | Default page `h1`.               |
| Productive heading 06      | `ui-type-productive-heading-06`      | High-emphasis product heading            | Pattern-owned only.              |

### 4.3. Expressive type roles

| Token/helper               | CSS variable or class                | Allowed API/consumer                                        | Example                                   |
| -------------------------- | ------------------------------------ | ----------------------------------------------------------- | ----------------------------------------- |
| Expressive label           | `ui-type-expressive-label`           | High-presence section labels                                | Help or onboarding eyebrow.               |
| Expressive helper          | `ui-type-expressive-helper`          | Explanatory helper copy in expressive sections              | Guided setup details.                     |
| Expressive legal           | `ui-type-expressive-legal`           | Legal/footnote copy in expressive or documentation surfaces | Help/disclosure copy.                     |
| Expressive body compact    | `ui-type-expressive-body-compact`    | Short explanatory copy with expressive rhythm               | Empty-state support copy.                 |
| Expressive body            | `ui-type-expressive-body`            | Long-form or reading-oriented copy                          | Help/documentation sections.              |
| Expressive heading compact | `ui-type-expressive-heading-compact` | Smaller expressive headings                                 | Documentation subheadings.                |
| Expressive heading 01      | `ui-type-expressive-heading-01`      | Small expressive heading                                    | Intro card titles.                        |
| Expressive heading 02      | `ui-type-expressive-heading-02`      | Small expressive heading                                    | Explanatory subheadings.                  |
| Expressive heading 03      | `ui-type-expressive-heading-03`      | Medium expressive heading                                   | Empty-state titles.                       |
| Expressive heading 04      | `ui-type-expressive-heading-04`      | Large expressive heading                                    | Onboarding or docs section title.         |
| Expressive heading 05      | `ui-type-expressive-heading-05`      | Large fluid expressive heading                              | Help landing or high-presence page title. |
| Expressive heading 06      | `ui-type-expressive-heading-06`      | Largest fluid expressive heading                            | Rare hero-like app moment.                |
| Expressive display 01      | `ui-type-expressive-display-01`      | Display role                                                | Documentation or onboarding hero moment.  |
| Expressive display 02      | `ui-type-expressive-display-02`      | Display role                                                | High-presence landing/intro moment.       |

### 4.4. Shared code roles

| Token/helper            | CSS variable or class                | Allowed API/consumer                   | Example                                                       |
| ----------------------- | ------------------------------------ | -------------------------------------- | ------------------------------------------------------------- |
| Code small              | `ui-type-code-01`; `font-mono`       | Inline code and small technical values | `<code>ui-card-title</code>`                                  |
| Code block              | `ui-type-code-02`; `ui-code-snippet` | Code Snippet Component                 | `<x-ui.code-snippet language="Blade">...</x-ui.code-snippet>` |
| Code syntax keyword     | `ui-code-token-keyword`              | Code snippets only                     | `class`, `function`, `return` roles.                          |
| Code syntax property    | `ui-code-token-property`             | Code snippets only                     | Prop or object key roles.                                     |
| Code syntax string      | `ui-code-token-string`               | Code snippets only                     | String literal roles.                                         |
| Code syntax punctuation | `ui-code-token-punctuation`          | Code snippets only                     | Syntax punctuation roles.                                     |

### 4.5. Legacy role-class compatibility

The following existing role classes remain approved compatibility APIs. They should map to the Productive Type Set unless the owning Pattern explicitly maps them to Expressive.

| Existing class/helper  | Type-set mapping      | Status      |
| ---------------------- | --------------------- | ----------- |
| `ui-page-header-title` | Productive heading 05 | Implemented |
| `ui-page-header-copy`  | Productive body       | Implemented |
| `ui-kicker`            | Productive label      | Implemented |
| `ui-card-title`        | Productive heading 03 | Implemented |
| `ui-card-copy`         | Productive body       | Implemented |
| `ui-link`              | Productive link text  | Implemented |
| `ui-code-snippet`      | Code block            | Implemented |

### 4.6. Type scale guidance

The rendered evidence page must display the installed type scale. Use these values through role classes, component APIs, Pattern slots, or documented utility use only.

#### 4.6.1. Productive fixed scale

| Size | Typical utility | Type-set role                                    | Installed use                                                        |
| ---: | --------------- | ------------------------------------------------ | -------------------------------------------------------------------- |
| 12px | `text-xs`       | Productive label/helper/legal/code small         | Kicker, metadata, helper labels, compact badges, table utility text. |
| 14px | `text-sm`       | Productive body compact/body/heading 01          | Productive body copy, form helper text, table cells, dense admin UI. |
| 16px | `text-base`     | Productive heading 02 and standard body contexts | Modal copy, readable content regions, compact headings.              |
| 20px | `text-xl`       | Productive heading 03                            | Component and layout headings.                                       |
| 24px | `text-2xl`      | Productive page title role where installed       | Page title or major section title.                                   |
| 28px | Role-owned      | Productive heading 04                            | Pattern-owned larger layout heading.                                 |
| 32px | Role-owned      | Productive heading 05                            | Default page title role.                                             |
| 42px | Role-owned      | Productive heading 06                            | Rare product heading, Pattern-owned.                                 |

#### 4.6.2. Expressive responsive scale

| Size or range  | Type-set role                 | Installed use                                     |
| -------------- | ----------------------------- | ------------------------------------------------- |
| 14px           | Expressive label/helper/legal | Expressive support labels and guidance.           |
| 16px           | Expressive body/body compact  | Long-form/help/onboarding body copy.              |
| 20px           | Expressive heading 03         | Empty-state or help section title.                |
| 28px           | Expressive heading 04         | Larger explanatory headings.                      |
| 32px and above | Expressive heading 05/06      | Fluid page or hero-like Pattern-owned headings.   |
| Display scale  | Expressive display 01/02      | Rare high-presence Pattern-owned display moments. |

Do not use arbitrary size utilities such as `text-[15px]`, `text-[17px]`, or `leading-[23px]` in feature views.

## 5. CSS variable API

Use only the CSS variables and token aliases listed in this standard or the linked Element standards. Do not introduce feature-local CSS variables for Typography without updating this standard and the rendered evidence proof.

### 5.1. Font-family variables

| Variable/API            | Status      | Allowed use                                       |
| ----------------------- | ----------- | ------------------------------------------------- |
| `--ui-font-family-sans` | Implemented | Default app text stack.                           |
| `--ui-font-family-mono` | Implemented | Code, commands, paths, IDs, and technical values. |

### 5.2. Type-set variables

| Variable/API                         | Status                                    | Allowed use                              |
| ------------------------------------ | ----------------------------------------- | ---------------------------------------- |
| `--ui-type-productive-base-size`     | Implemented                               | Productive base size, expected `14px`.   |
| `--ui-type-expressive-base-size`     | Implemented                               | Expressive base size, expected `16px`.   |
| `--ui-type-productive-heading-scale` | Implemented by role mapping               | Fixed productive heading roles.          |
| `--ui-type-expressive-heading-scale` | Implemented by role mapping               | Expressive fixed/fluid heading roles.    |
| `--ui-type-fluid-min`                | Implemented for expressive fluid headings | Pattern-owned responsive heading bounds. |
| `--ui-type-fluid-max`                | Implemented for expressive fluid headings | Pattern-owned responsive heading bounds. |

### 5.3. Text color variables

Typography consumes Color Element API variables for text color and code syntax.

| Variable/API                                                | Owner                                  | Allowed use                                                                         |
| ----------------------------------------------------------- | -------------------------------------- | ----------------------------------------------------------------------------------- |
| `--ui-text-primary`                                         | Color Element API                      | Primary readable text and heading roles.                                            |
| `--ui-text-strong`                                          | Color Element API alias when installed | High-emphasis heading/strong text roles.                                            |
| `--ui-text-secondary`                                       | Color Element API                      | Supporting copy and lower-emphasis body text.                                       |
| `--ui-text-helper`                                          | Color Element API                      | Kicker text, helper labels, captions, metadata.                                     |
| `--ui-text-muted`                                           | Color Element API alias when installed | Low-emphasis metadata and secondary helper copy.                                    |
| `--ui-link` / link state aliases                            | Color Element API                      | Navigation and docs links through `ui-link` or component APIs.                      |
| `--ui-code-token-*`                                         | Code Snippet / Color Element API       | Syntax highlighting in approved code snippets.                                      |
| Component-owned type variables documented by that component | Component API                          | Only when the component standard defines the variable, default, and allowed values. |

### 5.4. Not approved CSS variables

```css
.feature-callout-title {
    --local-title-size: 21px;
    --local-title-leading: 1.17;
}
```

```html
<p style="font-size: 15px; line-height: 23px; color: #666">
    ...
</p>
```

If a new semantic type token is needed, update this Element standard, the consuming Component or Pattern doc, and the rendered evidence proof before using it in feature code.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the Rendered evidence route.

### 6.1. Public type-set classes

| Class/helper             | Status      | Use                                                              |
| ------------------------ | ----------- | ---------------------------------------------------------------- |
| `ui-type-set-productive` | Implemented | Productive context wrapper; default product UI.                  |
| `ui-type-set-expressive` | Implemented | Expressive context wrapper; Pattern-owned high-presence section. |
| `ui-type-productive-*`   | Implemented | Productive role utilities.                                       |
| `ui-type-expressive-*`   | Implemented | Expressive role utilities.                                       |
| `ui-type-code-*`         | Implemented | Code and technical text roles.                                   |

### 6.2. Public role classes

| Class/helper                  | Status      | Use                                                       |
| ----------------------------- | ----------- | --------------------------------------------------------- |
| `ui-page-header-title`        | Implemented | Page-level `h1` titles.                                   |
| `ui-page-header-copy`         | Implemented | Page intro/supporting copy under a page title.            |
| `ui-kicker`                   | Implemented | Small section/category label.                             |
| `ui-card-title`               | Implemented | Card, panel, and reference section headings.              |
| `ui-card-copy`                | Implemented | Supporting copy in cards, panels, and reference sections. |
| `ui-expressive-page-title`    | Implemented | Pattern-owned expressive page/hero titles.                |
| `ui-expressive-page-copy`     | Implemented | Pattern-owned expressive page/hero copy.                  |
| `ui-expressive-section-title` | Implemented | Pattern-owned expressive section headings.                |
| `ui-expressive-body`          | Implemented | Pattern-owned expressive body copy.                       |
| `ui-link`                     | Implemented | Text links and docs/navigation anchors.                   |
| `ui-code-snippet`             | Implemented | Code examples in docs and rendered evidence pages.             |
| `ui-code-token-keyword`       | Implemented | Syntax token styling inside approved code snippets.       |
| `ui-code-token-property`      | Implemented | Syntax token styling inside approved code snippets.       |
| `ui-code-token-string`        | Implemented | Syntax token styling inside approved code snippets.       |
| `ui-code-token-punctuation`   | Implemented | Syntax token styling inside approved code snippets.       |

### 6.3. Allowed utility families

Use Tailwind-compatible utilities only when a semantic role class or component API is not the correct owner.

| Utility family | Allowed values                                                           | Owner                                                                               |
| -------------- | ------------------------------------------------------------------------ | ----------------------------------------------------------------------------------- |
| Font family    | `font-sans`, `font-mono`                                                 | `font-sans` is default; `font-mono` is for technical text only.                     |
| Font size      | `text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`, `text-2xl`      | Component or Pattern source, docs examples, limited feature use when role is clear. |
| Font weight    | `font-normal`, `font-medium`, `font-semibold`                            | Component or Pattern source; feature use only when matching an approved role.       |
| Line height    | `leading-5`, `leading-6`, role-owned defaults                            | Component or Pattern source; avoid arbitrary line-height values.                    |
| Text transform | `uppercase` only for `ui-kicker`-style micro labels                      | Component/docs source only; do not uppercase body copy or button labels.            |
| Letter spacing | Kicker-style tracking only through installed classes or component source | Not a general feature utility.                                                      |
| Text alignment | `text-left`, `text-center`, `text-right` when Pattern-owned              | Productive UI defaults to left alignment.                                           |
| Text wrapping  | Normal wrapping; no truncation unless component owns it                  | Components must document truncation behavior if allowed.                            |
| Color          | Use Color Element variables/classes, not ad hoc color utilities          | Color Element API owns text color values.                                           |

### 6.4. Preferred productive examples

#### 6.4.1. Productive page header

```html
<header class="ui-type-set-productive">
    <p class="ui-kicker">Settings</p>
    <h1 class="ui-page-header-title">Workspace access</h1>
    <p class="ui-page-header-copy">Manage who can sign in and administer this workspace.</p>
</header>
```

#### 6.4.2. Productive field and action text

```blade
<x-ui.text-input
    name="email"
    label="Work email"
    helper="Use the email address assigned to this workspace."
/>

<x-ui.button semantic="primary">Save changes</x-ui.button>
```

### 6.5. Preferred expressive examples

#### 6.5.1. Expressive empty state

```html
<section class="ui-type-set-expressive" aria-labelledby="empty-users-title">
    <p class="ui-expressive-kicker">No users found</p>
    <h2 id="empty-users-title" class="ui-expressive-section-title">Invite your first team member</h2>
    <p class="ui-expressive-body">Add users to start assigning roles and managing workspace access.</p>
</section>
```

#### 6.5.2. Expressive onboarding intro with productive controls

```html
<section class="ui-type-set-expressive" aria-labelledby="setup-title">
    <h1 id="setup-title" class="ui-expressive-page-title">Set up your workspace</h1>
    <p class="ui-expressive-page-copy">Complete the basic steps before inviting users.</p>

    <div class="ui-type-set-productive">
        <x-ui.button semantic="primary">Start setup</x-ui.button>
    </div>
</section>
```

### 6.6. Preferred code examples

#### 6.6.1. Inline technical value

```html
<p class="ui-card-copy">
    Use <code>--ui-text-primary</code> for primary readable text.
</p>
```

#### 6.6.2. Code snippet

```blade
<x-ui.code-snippet language="Blade" copyable>
&lt;x-ui.button semantic="primary"&gt;Save&lt;/x-ui.button&gt;
</x-ui.code-snippet>
```

### 6.7. Not approved examples

#### 6.7.1. Local typography class

```css
.feature-title-special {
    font-size: 21px;
    line-height: 25px;
    font-weight: 700;
}
```

#### 6.7.2. Arbitrary utility styling

```html
<p class="text-[15px] leading-[23px] font-bold text-slate-500">
    ...
</p>
```

#### 6.7.3. Placeholder-only label

```blade
{{-- Not approved --}}
<x-ui.text-input name="email" placeholder="Email" />
```

## 7. Allowed usage

Use Typography when selecting text role, hierarchy, label treatment, helper text, validation, captions, links, code, productive type, expressive type, or type-set blending.

Avoid Typography decisions based on visual guessing, one-off utility styling, local CSS, or Carbon class copying.

### 7.1. Type-set selection guidance

| Need                                               | Use                                                                |
| -------------------------------------------------- | ------------------------------------------------------------------ |
| Dense task UI                                      | Productive Type Set.                                               |
| Forms, fields, labels, helper text, and validation | Productive Type Set through Component APIs.                        |
| Data table headers and cells                       | Productive Type Set through Data table Component API.              |
| Navigation, shell labels, menus, and toolbars      | Productive Type Set through Navigation/Button/Menu APIs.           |
| Documentation/help landing title                   | Expressive Type Set through Pattern-owned roles.                   |
| Onboarding intro                                   | Expressive Type Set through Onboarding or Page Pattern.            |
| Empty-state title and explanatory copy             | Expressive Type Set when the Data/content Pattern owns the state.  |
| No-results recovery surface                        | Expressive or Productive depending on Pattern context and density. |
| Code examples                                      | Code roles through Code snippet Component API.                     |
| Marketing-like hero moment inside the app          | Expressive Type Set through an approved Pattern only.              |
| Feature-local visual emphasis                      | No local typography override; use the owning API.                  |

### 7.2. Role selection guidance

| Need                                   | Use                                                       |
| -------------------------------------- | --------------------------------------------------------- |
| Main product page title                | `ui-page-header-title` on the page's `h1`.                |
| Product page intro or explanatory copy | `ui-page-header-copy`.                                    |
| Expressive page title                  | `ui-expressive-page-title` through a Pattern.             |
| Expressive page copy                   | `ui-expressive-page-copy` through a Pattern.              |
| Small section/category label           | `ui-kicker` or `ui-expressive-kicker` when Pattern-owned. |
| Card or panel heading                  | `ui-card-title`.                                          |
| Supporting copy inside a card/panel    | `ui-card-copy`.                                           |
| Inline or standalone navigation        | `ui-link` or the Link Component API.                      |
| Action label                           | Button/Menu Button Component APIs.                        |
| Form label/helper/error                | Field Component APIs.                                     |
| Data table text                        | Data table Component API.                                 |
| Technical value or component call      | `code`, `font-mono`, or Code snippet Component API.       |
| High-presence empty-state title        | Expressive Pattern-owned role.                            |

### 7.3. Relationship guidance

Typography must coordinate with spacing, hierarchy, and ownership.

| Relationship                              | Standard                                                                    |
| ----------------------------------------- | --------------------------------------------------------------------------- |
| Label to field                            | Field Component owns label placement and spacing.                           |
| Field to helper/error                     | Field Component owns helper/error spacing and text role.                    |
| Section title to body copy                | Parent Pattern or card wrapper owns spacing.                                |
| Card title to card body                   | `ui-card-title` and `ui-card-copy` inside the card component/wrapper.       |
| Table header to table cell                | Data table Component API owns both roles.                                   |
| Icon to text                              | Icons follow text color through `currentColor`; spacing is component-owned. |
| Expressive heading to productive controls | Pattern owns transition spacing and type-set boundary.                      |

### 7.4. Tips and techniques

#### 7.4.1. Preserve semantic structure

Use `h1` through `h6` for document structure. Do not choose heading levels by visual size alone.

#### 7.4.2. Use type sets as moments

Treat expressive type as a larger moment or region. Do not sprinkle expressive utilities into dense product rows.

#### 7.4.3. Keep body copy readable

Use normal wrapping, appropriate line height, and Pattern-owned max widths for long-form content.

#### 7.4.4. Use contrast through hierarchy, not random styling

Use type role, spacing, and semantic text color. Do not create local bold, uppercase, or color overrides.

#### 7.4.5. Pair headings and body roles deliberately

Productive headings pair with productive body in dense product UI. Expressive headings may pair with expressive body for readable explanatory content or productive body when the moment leads into controls.

#### 7.4.6. Keep dense UI dense

Forms, filters, tables, and shell navigation should remain productive even when placed near expressive onboarding or help content.

### 7.5. Readability and accessibility rules

- Preserve heading order.
- Keep visible labels for fields and controls.
- Associate helper, error, and warning text through the owning Component API.
- Avoid long uppercase text.
- Avoid low-contrast small text for required or blocking information.
- Keep links visually distinguishable from surrounding text.
- Let text wrap by default.
- Do not truncate important copy unless the owning Component documents full-value access.
- Keep code snippets readable and copy-safe.

### 7.6. Content writing rules

#### 7.6.1. Labels

- Use sentence case.
- Name the control or data directly.
- Avoid vague labels such as `Value`, `Info`, `Details`, or `Other` unless context makes the meaning explicit.
- Keep required labels visible.

#### 7.6.2. Helper text

- Use helper text for non-blocking guidance.
- Keep helper text concise.
- Do not put required instructions only in helper text if the task depends on the instruction.
- Do not replace visible labels with helper or placeholder text.

#### 7.6.3. Validation text

- State the problem and recovery action when possible.
- Use direct, specific language.
- Do not rely on red text alone.
- Keep field-level validation near the field and summary-level validation in the owning Pattern.

#### 7.6.4. Button and action labels

- Prefer verb + noun when the action may otherwise be ambiguous.
- Use sentence case.
- Avoid vague action labels such as `Submit`, `OK`, `Yes`, or `Continue` when the action has meaningful consequence.
- Destructive actions must name the destructive outcome.

#### 7.6.5. Links

- Link text should describe the destination or resource.
- Avoid `click here`, `learn more` without context, or raw URLs as visible text unless the URL itself is the content.
- Use external/help icon treatment only through the Link Component API when installed.

#### 7.6.6. Code and technical copy

- Use inline code for tokens, classes, component names, file paths, commands, and values.
- Keep code examples canonical and copyable.
- Do not use placeholder comments instead of real implementation examples in standards docs or rendered evidence pages.

## 8. Component and pattern consumers

Components and Patterns must consume Typography through documented tokens, utilities, role classes, component props, component slots, or Pattern-owned wrappers. They must not hard-code alternate local values for the same role.

### 8.1. Component consumer rules

Components must:

- Expose labels, helper text, validation text, titles, captions, and action labels through component props or slots where applicable.
- Use installed text role classes or internal component classes backed by this Element API.
- Use Productive Type Set by default.
- Use Expressive Type Set only when the Component standard explicitly installs an expressive variant or the parent Pattern owns the expressive context.
- Keep semantic text colors tied to status, validation, or action roles.
- Preserve accessible names and visible labels.
- Document any truncation, wrapping, line-clamp, icon-text, or hidden-label behavior in the component standard.

Components must not:

- Require callers to pass raw font-size classes for normal use.
- Require callers to pass local text color utilities to achieve the approved visual treatment.
- Use placeholder text as the only label.
- Use color-only typography to communicate state.
- Add expressive type internally without documenting the expressive role and rendered evidence proof.

### 8.2. Pattern consumer rules

Patterns must:

- Own page/workflow text hierarchy.
- Choose the correct type set for the region.
- Compose component text roles instead of restyling child components.
- Use Productive Type Set for task-heavy workflows.
- Use Expressive Type Set for approved onboarding, empty-state, help, documentation, no-results, and explanatory moments.
- Document any expressive type usage, large empty-state title treatment, or custom documentation typography.
- Keep external spacing around text groups in Pattern-owned layout wrappers.
- Preserve productive controls inside expressive sections unless the Pattern explicitly installs expressive control treatment.

Patterns must not:

- Create new type scales locally.
- Override component labels, helper text, validation text, or button labels with arbitrary classes.
- Use expressive display typography inside admin screens without an owning Pattern standard.
- Blend type sets without documenting the ownership boundary.

### 8.3. Feature/page consumer rules

Feature code may:

- Choose the correct installed role class.
- Choose a Component or Pattern that owns the needed text role.
- Pass copy through documented props and slots.

Feature code must not:

- Define local typography CSS.
- Use arbitrary text utilities.
- Override Component typography internals.
- Create local expressive moments without Pattern ownership.

## 9. Theme behavior

Typography must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the rendered evidence page.

Typography consumes theme-aware Color Element tokens. A text role must preserve readability when the surface changes.

### 9.1. Theme context requirements

| Context              | Requirement                                                                                       |
| -------------------- | ------------------------------------------------------------------------------------------------- |
| Light theme          | Text roles use approved neutral, link, action, and semantic color tokens.                         |
| Dark theme           | Text roles remain readable on dark surfaces without local color overrides.                        |
| Inline theme         | Text roles adapt to nested surface/layer context.                                                 |
| Inverse context      | Text and link roles use inverse-safe tokens provided by the Color Element or owning Pattern.      |
| High-contrast moment | Text remains readable and does not rely on thin weight, color alone, or low-contrast helper copy. |

### 9.2. Type-set theme behavior

#### 9.2.1. Productive theme behavior

Productive roles must stay compact and readable across all supported themes. Dense labels, helper text, table text, and navigation text must not become low-contrast in dark or inverse contexts.

#### 9.2.2. Expressive theme behavior

Expressive roles must preserve contrast and rhythm on large surfaces. Expressive headings may use larger sizes or fluid scaling, but they must not rely on thin weight or low contrast to create visual drama.

### 9.3. Theme prohibition

Do not fix contrast issues by adding a local one-off color class. Update the Color Element token, Typography Element standard, or owning Component/Pattern contract.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, validation, and current state must use documented Element roles where applicable.

Typography state behavior is usually owned by the component that renders the text. Typography defines the roles that state text may consume.

### 10.1. State ownership matrix

| State            | Typography requirement                                                                                    | Owner                                            |
| ---------------- | --------------------------------------------------------------------------------------------------------- | ------------------------------------------------ |
| Default          | Use the approved text role and theme-aware color token.                                                   | Component/Pattern.                               |
| Hover            | Link/action text may change only through component-approved state styling.                                | Link/Button/Menu APIs.                           |
| Focus-visible    | Focus indication is not text styling alone; use Focus/Color/Motion contracts.                             | Component API.                                   |
| Active/pressed   | Action text remains readable and state-specific.                                                          | Component API.                                   |
| Selected/current | Text role may gain emphasis only through the selected/current component contract.                         | Tabs, menu, table, navigation, content switcher. |
| Disabled         | Disabled text uses disabled role and remains visibly unavailable.                                         | Component API.                                   |
| Read-only        | Read-only text remains readable; do not make it look disabled unless component standard says so.          | Field/component API.                             |
| Loading          | Loading labels must be concise and may require `aria-live` through Loading/Inline Loading Component APIs. | Loading components/patterns.                     |
| Error            | Error text uses semantic role plus visible copy and association to the related field/control.             | Field/notification APIs.                         |
| Warning          | Warning text uses semantic role plus visible copy and non-color cue where appropriate.                    | Field/notification APIs.                         |
| Success          | Success text uses semantic role plus visible copy.                                                        | Notification/status APIs.                        |
| Empty            | Empty-state text hierarchy is Pattern-owned and may use Expressive Type Set where approved.               | Empty-state/Data-content Pattern.                |

### 10.2. Expressive state behavior

Expressive type does not create new interactive state rules. Interactive states remain owned by the child Component or Pattern. Expressive type may change hierarchy, rhythm, and scale, but not focus, hover, validation, or selected-state semantics.

## 11. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Do not treat Productive Type Set or Expressive Type Set as optional undocumented style choices.
- Do not mark expressive type as deferred in component or pattern docs when the Typography Element standard installs it.
- Do not use expressive type outside a documented Component or Pattern owner.
- Do not use Carbon type classes, Sass mixins, IBM Plex dependencies, or token names directly in app feature code unless the app explicitly installs them.
- Do not introduce feature-local font families.
- Do not use arbitrary values such as `text-[15px]`, `leading-[23px]`, `tracking-[0.18em]`, or local `font-size` styles.
- Do not create local typography classes such as `.feature-title-special`.
- Do not use decorative bold, italic, uppercase, or monospace treatments.
- Do not hide labels and rely on placeholder text.
- Do not communicate status with text color alone.
- Do not use headings for visual size only; keep heading structure semantic.
- Do not truncate important copy unless the owning component documents the behavior and fallback access.
- Do not use expressive type for dense form, table, navigation, toolbar, or validation text.
- Do not use productive type to shrink long-form help content until it becomes hard to read.
- Do not create broad typography changes from a feature ticket.

## 12. Deferred or gated capabilities

Both Productive and Expressive Type Sets are installed standards. The capabilities below remain deferred, gated, or prohibited because they require implementation proof beyond the core type-set model.

| Capability                                     | Status                 | Gate                                                                                                                         |
| ---------------------------------------------- | ---------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Full generated type-token alias layer          | Deferred               | Requires source implementation, token map, docs update, and rendered evidence proof.                                              |
| IBM Plex adoption                              | Deferred / not default | Requires product/design decision, font-loading strategy, performance review, license/source review, and cross-browser proof. |
| Additional expressive display roles            | Gated                  | Requires Pattern need, responsive/fluid scale, rendered evidence examples, and accessibility review.                              |
| Custom fluid type outside expressive roles     | Not allowed            | Use installed expressive heading/display roles only.                                                                         |
| Local feature typography overrides             | Not allowed            | Use Component or Pattern standards instead.                                                                                  |
| Custom font family per feature                 | Not allowed            | Requires system-level decision, not feature code.                                                                            |
| Text truncation utilities for critical content | Gated                  | Owning Component must document full-value access and responsive behavior.                                                    |
| Markdown/prose renderer type scale             | Pattern-owned / gated  | Requires documentation/content Pattern standard and rendered evidence proof.                                                      |
| Alternate type-set naming                      | Not allowed            | Productive and Expressive are the app terms.                                                                                 |
| Direct Carbon token/class adoption             | Not allowed            | Requires explicit app adoption decision and migration plan.                                                                  |

## 13. Rendered evidence requirements

The rendered evidence pages at `not installed` and `not installed` must prove the installed Typography Element API with live rendered examples, not screenshots only. The overview owns font, scale, role, weight, color, and code proof. The nested Type Sets page owns full Productive and Expressive role matrices, comparison, blending, and API proof.

### 13.1. Required page structure

The pages should provide enough rendered proof for visual review without opening source code first.

### 13.2. Required live examples

| Required proof             | Rendered behavior                                                                                                                                                          | Variants/options shown                      |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------- |
| API status proof           | Page states that Typography is an implemented Foundation Element API and that both Productive and Expressive Type Sets are installed standards.                            | Implemented, Productive, Expressive         |
| Font specimens             | Show the installed app sans stack and mono stack. If IBM Plex is not installed, state that Carbon's type model is the benchmark but IBM Plex is not the app default.       | Sans, Mono, Carbon benchmark note           |
| Productive Type Set        | Nested Type Sets page renders productive label, helper, body compact, body, heading compact, and headings 01-06.                                                           | Productive roles, fixed headings, 14px base |
| Expressive Type Set        | Nested Type Sets page renders expressive label, helper, body compact, body, heading compact, headings 01-06, and display roles where installed.                            | Expressive roles, fluid headings, 16px base |
| Type-set comparison        | Compare the same content in productive and expressive treatment with use guidance.                                                                                         | Productive vs. Expressive                   |
| Type-set blending examples | Show approved blends such as expressive empty-state title with productive action button.                                                                                   | Blending, Pattern-owned boundary            |
| Type scale                 | Render 12px, 14px, 16px, 18px, 20px, 24px, 28px, 32px, 42px, and expressive fluid examples with ownership labels.                                                          | Fixed, Fluid, Productive, Expressive        |
| Type roles                 | Render page title, page copy, kicker, card title, card copy, body text, label, helper text, validation text, caption, link, table header/cell, button text, and code text. | Role examples                               |
| Productive examples        | Show admin page header, settings form text, data table text, notification text, and docs/reference card text.                                                              | Productive use cases                        |
| Expressive examples        | Show onboarding intro, help/documentation section, empty state, and no-results recovery examples.                                                                          | Expressive use cases                        |
| Weight examples            | Render regular, medium, semibold, limited italic, expressive light-heading usage, and not-approved decorative bold examples.                                               | Weight rules                                |
| Color examples             | Render primary, secondary, helper/muted, link, disabled, error, warning, success, and inverse text where supported.                                                        | Color roles                                 |
| Content examples           | Show correct label/helper/validation copy, button label rules, link text rules, and code/token text.                                                                       | Content rules                               |
| Wrapping and truncation    | Show normal wrapping and document when truncation is not allowed.                                                                                                          | Wrapping, truncation gate                   |
| Code examples              | Render inline code and a code block using `x-ui.code-snippet`, `ui-code-snippet`, and `ui-code-token-*` classes.                                                           | Code roles                                  |
| Prohibited usage proof     | Show examples of arbitrary sizes, local classes, placeholder-only labels, expressive form labels, Carbon classes, and local font families as prohibited.                   | Prohibited usage                            |
| Deferred gate proof        | Show remaining deferred/gated items such as IBM Plex adoption, generated token aliases, prose renderer scale, and custom fluid type.                                       | Deferred/gated                              |

### 13.3. Required developer API references on the page

The rendered evidence pages must list or demonstrate:

#### 13.3.1. Type-set APIs

- `ui-type-set-productive`
- `ui-type-set-expressive`
- `ui-type-productive-*`
- `ui-type-expressive-*`
- `--ui-type-productive-base-size`
- `--ui-type-expressive-base-size`

#### 13.3.2. Productive compatibility APIs

- `ui-page-header-title`
- `ui-page-header-copy`
- `ui-kicker`
- `ui-card-title`
- `ui-card-copy`
- `ui-link`

#### 13.3.3. Code APIs

- `ui-code-snippet`
- `ui-code-token-keyword`
- `ui-code-token-property`
- `ui-code-token-string`
- `ui-code-token-punctuation`
- `font-mono` for technical text only

#### 13.3.4. Boundaries

- approved size/weight utility boundaries
- related Color Element text tokens
- Productive vs. Expressive selection rules
- blending rules
- prohibited local typography overrides

### 13.4. Required page text

The rendered evidence page should include this implementation note:

```text
Use typography by role, not by visual guessing. Productive Type Set is the default for task-focused Login App UI. Expressive Type Set is also an installed standard and must be used for approved high-presence, explanatory, onboarding, help, documentation, and empty-state moments through an owning Pattern. Do not introduce local font sizes, weights, line heights, colors, type sets, or font families in feature views.
```

## 14. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page states that both Productive Type Set and Expressive Type Set are installed standards.
- The page renders the installed app font stack and mono stack.
- The page renders Productive Type Set examples and identifies the 14px base.
- The page renders Expressive Type Set examples and identifies the 16px base.
- The page documents fixed productive headings and fluid expressive headings.
- The page renders approved blending examples.
- The page renders role examples for page title, page copy, kicker, card title, card copy, body text, label, helper text, validation text, caption, link, table text, button text, and code text.
- The page demonstrates productive app UI examples.
- The page demonstrates expressive onboarding, help, documentation, empty-state, or no-results examples.
- The page renders weight examples and explains semibold, light-heading, italic, and bold limits.
- The page renders primary, secondary, helper/muted, link, disabled, validation, and inverse text examples where supported.
- The page shows visible labels and does not treat placeholder text as a label.
- The page shows code examples using canonical Code snippet classes.
- The page does not contain placeholder comments, generic fallback content, raw arbitrary typography values, deprecated `expressive deferred` copy, or unapproved font-family examples.
- The page does not include direct Carbon production classes such as `cds--type-*` or `bx--type-*` as app-approved implementation.

### 14.1. Suggested automated assertions

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Typography');
$response->assertSee('Foundation Element API');
$response->assertSee('Productive Type Set');
$response->assertSee('Expressive Type Set');
$response->assertSee('implemented standards');
$response->assertSee('14px');
$response->assertSee('16px');
$response->assertSee('fixed productive headings');
$response->assertSee('fluid expressive headings');
$response->assertSee('ui-type-set-productive');
$response->assertSee('ui-type-set-expressive');
$response->assertSee('ui-page-header-title');
$response->assertSee('ui-page-header-copy');
$response->assertSee('ui-kicker');
$response->assertSee('ui-card-title');
$response->assertSee('ui-card-copy');
$response->assertSee('ui-link');
$response->assertSee('ui-code-snippet');
$response->assertSee('placeholder text is not a label');
$response->assertSee('Do not introduce local font sizes');
$response->assertDontSee('Expressive type set                            | Deferred');
$response->assertDontSee('Expressive type is deferred');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('text-[15px]');
$response->assertDontSee('leading-[23px]');
$response->assertDontSee('cds--type-');
$response->assertDontSee('bx--type-');
```

## 15. Related APIs

| API                                | Route                                                                  |
| ---------------------------------- | ---------------------------------------------------------------------- |
| Color element                      | `not installed`                                |
| Spacing element                    | `not installed`                              |
| Themes element                     | `not installed`                               |
| Icons element                      | `not installed`                                |
| Motion element                     | `not installed`                               |
| 2x Grid element                    | `not installed`                              |
| Form patterns                      | `not installed`                                |
| Data and content patterns          | `not installed`                         |
| Layout patterns                    | `not installed`                               |
| Navigation patterns                | `not installed`                           |
| Button component                   | `not installed`                             |
| Link component                     | `not installed`                               |
| Text input component               | `not installed`                         |
| Textarea component                 | `not installed`                           |
| Notification component             | `not installed`                       |
| Data table component               | `not installed`                         |
| Code snippet component             | `not installed`                       |
| Canonical typography doc           | `/platform/docs?path=02-standards%2Fui%2Felements%2Ftypography.md`     |
| Carbon typography overview         | `https://carbondesignsystem.com/elements/typography/overview/`         |
| Carbon typography style strategies | `https://carbondesignsystem.com/elements/typography/style-strategies/` |
| Carbon type sets                   | `https://carbondesignsystem.com/elements/typography/type-sets/`        |
| Carbon typography code             | `https://carbondesignsystem.com/elements/typography/code/`             |

## 16. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Typography overview, style strategies, type sets, and code guidance inform the two type-set model, productive and expressive selection rules, base type-size distinction, fixed and fluid heading behavior, type-set blending, and helper-based implementation discipline. Login App keeps its own system font stack, `ui-*` namespace, Foundation Element tokens, Component APIs, Pattern ownership, and rendered evidence proof.
