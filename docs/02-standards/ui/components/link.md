---
title: Link
slug: link
status: implemented-pending-correction
api_layer: Component API
category: Utilities
priority: Tier A - Baseline app development
ui_reference_route: /platform/ui-reference/components/link
canonical_doc: docs/02-standards/ui/components/link.md
source_owner: /platform/ui-reference/components/link
blade_api:
  - x-ui.link
css_namespace:
  - ui-link
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
related_components:
  - button
  - menu-buttons
  - breadcrumb
  - tile
  - tooltip
  - toggletip
related_patterns:
  - navigation
  - documentation-help
---

# Link Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Props and options](#41-props-and-options)
  - [4.2. Allowed href types](#42-allowed-href-types)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Token and class contract](#72-token-and-class-contract)
  - [7.3. Approved classes](#73-approved-classes)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Choosing nearby APIs](#93-choosing-nearby-apis)
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

Links move users to related locations, page sections, protocol destinations, or trusted reference content.

Canonical API owner: `/platform/ui-reference/components/link`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Link is a navigation and resource-reference API. It is not an action-command API. Use Button for commands that submit, save, delete, confirm, cancel, reveal a menu, change state, or manipulate displayed data.

## 2. Status and ownership

| Field              | Value                                   |
| ------------------ | --------------------------------------- |
| Status             | Approved API                            |
| API layer          | Component API                           |
| Component slug     | link                                    |
| Category           | Utilities                               |
| Priority           | Tier A - Baseline app development       |
| UI Reference route | /platform/ui-reference/components/link  |
| Canonical doc      | docs/02-standards/ui/components/link.md |
| Source owner       | /platform/ui-reference/components/link  |

## 3. Installed standard

Link is the app-owned navigation and reference component for inline text links, standalone resource links, internal route links, external links, same-page anchor links, protocol links, and documented unavailable-link treatment.

The installed standard must correct any button-like language. A link takes the user somewhere or references a destination. It must not be used as a visual substitute for Button, Menu button, Toggle, or form controls.

Login App uses the app-owned `ui-link` class and the canonical `x-ui.link` Blade API target for reusable links. During correction, plain anchors may continue to use `class="ui-link"` only when they follow this standard and do not need extra API behavior. New reusable examples should prefer `x-ui.link`.

## 4. Public API

| API surface     | Installed value                                                                                                                                                                |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Blade           | `x-ui.link`                                                                                                                                                                    |
| Utility class   | `a.ui-link` is allowed for simple static anchors that do not need component props.                                                                                             |
| JavaScript      | No dedicated JavaScript controller required.                                                                                                                                   |
| Data attributes | None required for the base Link API. Pattern-owned links may add documented pattern attributes.                                                                                |
| Props/options   | `href`, `variant`, `size`, `external`, `newTab`, `icon`, `iconPosition`, `visited`, `current`, `unavailable`, `download`, `navigate`, `ariaLabel`, `describedBy`, `attributes` |
| CSS namespace   | `ui-link`, `ui-link-inline`, `ui-link-standalone`, `ui-link-external`, `ui-link-with-icon`, `ui-link-unavailable`                                                              |
| Source files    | `resources/views/components/ui/link.blade.php`; `resources/css/app.css`; UI Reference route `/platform/ui-reference/components/link`                                           |

Example calls:

```blade
<x-ui.link href="{{ route('platform.docs') }}">
    View documentation
</x-ui.link>

<x-ui.link href="https://example.com/docs" external new-tab>
    View provider docs
</x-ui.link>

<a href="/platform/docs" class="ui-link" wire:navigate>
    Open internal docs
</a>
```

### 4.1. Props and options

| Prop/option    | Type            |      Default | Allowed values                               | Required behavior                                                                                                  |
| -------------- | --------------- | -----------: | -------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| `href`         | `string / null` |       `null` | valid URL, route, hash, `mailto:`, `tel:`    | Required for an interactive link unless `unavailable=true`.                                                        |
| `variant`      | `string`        | `standalone` | `standalone`, `inline`                       | `inline` is used inside prose and must not include an icon.                                                        |
| `size`         | `string`        |         `md` | `sm`, `md`, `lg`                             | Size must map to app typography tokens and must not be hard-coded locally.                                         |
| `external`     | `bool`          |      `false` | `true`, `false`                              | Adds external-link semantics and an external icon when the visual context requires it.                             |
| `newTab`       | `bool`          |      `false` | `true`, `false`                              | Requires `target="_blank"` and `rel="noopener noreferrer"`. Use only when preserving the current app task matters. |
| `icon`         | `string / null` |       `null` | approved Heroicon alias                      | Icons are allowed on standalone links only.                                                                        |
| `iconPosition` | `string`        |   `trailing` | `trailing`; `leading` only when app-approved | Trailing is the default. Leading icons are restricted to approved resource-list or navigation compositions.        |
| `visited`      | `bool`          |      `false` | `true`, `false`                              | Enables visited styling only where knowing prior navigation helps the task.                                        |
| `current`      | `bool / string` |      `false` | `false`, `page`, `step`, `location`          | Adds `aria-current` only when the link represents the current item in a navigation context.                        |
| `unavailable`  | `bool`          |      `false` | `true`, `false`                              | Renders non-interactive unavailable treatment. Do not leave a navigable `href` on unavailable links.               |
| `download`     | `bool / string` |      `false` | `true`, `false`, file name                   | Use only for file-download links where the destination is a download resource.                                     |
| `navigate`     | `bool`          |      `false` | `true`, `false`                              | Adds app navigation behavior such as `wire:navigate` only for internal routes.                                     |
| `ariaLabel`    | `string / null` |       `null` | meaningful accessible label                  | Use only when visible text needs extra context, such as an icon-only pattern-owned link.                           |
| `describedBy`  | `string / null` |       `null` | element id                                   | Use to associate generic link text with nearby context when unavoidable.                                           |
| `attributes`   | `array`         |         `[]` | valid HTML attributes                        | Must not override required accessibility, target, rel, or state attributes.                                        |

### 4.2. Allowed href types

| Href type              | Status      | Example                      | Notes                                                            |
| ---------------------- | ----------- | ---------------------------- | ---------------------------------------------------------------- |
| Internal route         | Implemented | `/platform/settings`         | Use app navigation behavior when appropriate.                    |
| Same-page anchor       | Implemented | `#billing-settings`          | Destination must exist and be focusable or near a clear heading. |
| External URL           | Implemented | `https://example.com/docs`   | Use external treatment when leaving the app or trust boundary.   |
| Email link             | Implemented | `mailto:support@example.com` | Text must clarify the destination or action.                     |
| Phone link             | Implemented | `tel:+15555555555`           | Use only where phone support is part of the workflow.            |
| Download link          | Implemented | `/exports/report.csv`        | Use `download` only for real downloadable resources.             |
| JavaScript pseudo-link | Not allowed | `href="#"`                   | Use Button or a Pattern-owned trigger instead.                   |

## 5. Allowed variants, options, and modifiers

| Name                      | Type           | Status                       | API                                                      | Use when                                                                                                         |
| ------------------------- | -------------- | ---------------------------- | -------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Standalone link           | Variant        | Implemented                  | `variant="standalone"`                                   | A link sits by itself after content or in a resource list.                                                       |
| Inline link               | Variant        | Implemented                  | `variant="inline"`                                       | A link appears inside a sentence or paragraph.                                                                   |
| Internal route link       | Destination    | Implemented                  | `href="/path"`, optional `navigate`                      | Navigating within Login App.                                                                                     |
| Same-page anchor link     | Destination    | Implemented                  | `href="#section-id"`                                     | Jumping to a section on the current page.                                                                        |
| External link             | Modifier       | Implemented                  | `external`                                               | Leaving Login App or opening trusted reference content.                                                          |
| New-tab link              | Modifier       | Implemented with restriction | `newTab`                                                 | Preserve the current task while opening external reference content.                                              |
| Email/phone protocol link | Destination    | Implemented                  | `mailto:`, `tel:`                                        | The protocol destination is the expected behavior.                                                               |
| Download link             | Modifier       | Implemented                  | `download`                                               | The destination is a file or export.                                                                             |
| Small link                | Size           | Implemented                  | `size="sm"`                                              | Dense helper or metadata regions.                                                                                |
| Medium link               | Size           | Implemented                  | `size="md"`                                              | Default UI text and standalone links.                                                                            |
| Large link                | Size           | Implemented                  | `size="lg"`                                              | Page-level or higher-emphasis resource links.                                                                    |
| Trailing icon             | Modifier       | Implemented                  | `icon="arrow-right"`, `icon="arrow-top-right-on-square"` | Standalone internal/external links where the icon clarifies destination.                                         |
| Leading icon              | Modifier       | App-approved exception       | `iconPosition="leading"`                                 | Only in approved resource-list or navigation compositions where every item uses the same leading icon structure. |
| Visited style             | Modifier       | Opt-in                       | `visited`                                                | Use only where knowing a previous visit helps task completion.                                                   |
| Current page/location     | State/modifier | Pattern-owned, supported     | `current="page"`                                         | Navigation contexts such as side nav, breadcrumbs, or local navigation.                                          |
| Unavailable treatment     | State/modifier | Implemented with restriction | `unavailable`                                            | A destination exists conceptually but is not available yet; prefer omitting the link when possible.              |
| Danger/destructive link   | Variant        | Not allowed                  | None                                                     | Use Button for destructive commands.                                                                             |
| Icon-only link            | Variant        | Deferred/gated               | Pattern-owned only                                       | Requires a specific approved navigation pattern and accessible-name review.                                      |
| Image link                | Variant        | Not allowed                  | None                                                     | Use Tile or a composed card/tile pattern instead.                                                                |

## 6. States

| State                     | Status                       | Implementation rule                                                                                       |
| ------------------------- | ---------------------------- | --------------------------------------------------------------------------------------------------------- |
| Enabled / unvisited       | Implemented                  | Default navigable anchor state with `href`.                                                               |
| Hover                     | Implemented                  | Uses token-backed link hover color/underline treatment.                                                   |
| Focus-visible             | Implemented                  | Uses visible focus styling; standalone links receive clear focus indication.                              |
| Active / pressed          | Implemented                  | Uses token-backed active link styling during activation.                                                  |
| Visited                   | Opt-in                       | Use only where prior navigation state helps task completion; do not enable globally without product need. |
| Current                   | Pattern-owned, supported     | Use `aria-current` only when the link is part of a navigation set that includes the current item.         |
| Unavailable / disabled    | Implemented with restriction | Do not render a normal active `href`. Prefer non-interactive text or a clearly unavailable treatment.     |
| Loading                   | Not applicable               | Links do not own loading. Use Button, Inline loading, or a Pattern-owned loading state.                   |
| Error / warning / success | Not applicable               | Links do not own semantic status. Use Notification, Tag, form validation, or status components.           |
| Danger                    | Not allowed                  | Destructive intent belongs to Button and confirmation patterns.                                           |
| Empty                     | Not applicable               | Do not render an empty link or icon-only link without a specific approved pattern.                        |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Link consumes Foundation Color, Spacing, Typography, Themes, Icons, and limited Motion tokens through app-owned classes.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Icons
- Motion

### 7.2. Token and class contract

| API        | Allowed usage                                                                                                                          |
| ---------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Color      | Use link, link-hover, visited, disabled, focus, and text tokens. Do not use support or danger colors for decorative links.             |
| Typography | Link size and line-height must match approved text roles. Inline links inherit surrounding prose size.                                 |
| Spacing    | Links do not own external margin. Link groups and resource lists are Pattern-owned.                                                    |
| Icons      | Use approved Heroicons through `currentColor`. Icons are allowed on standalone links only unless a Pattern owns a different structure. |
| Themes     | Link text, icon color, visited color, and focus ring must remain readable in supported theme contexts.                                 |
| Motion     | No decorative motion. Only normal hover/focus transitions are allowed.                                                                 |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$link-primary` | Default enabled link text and link icon | `ui-link`, `ui-link-inline`, `ui-link-standalone`, `--ui-link` | App link palette | Same role / app value | Link Component owns the role; Navigation/Breadcrumb/Patterns consume it. |
| `$link-primary-hover` | Hover link text and icon | `ui-link:hover`, `--ui-link-hover` | App link palette | Same role / app value | Hover must not be replaced by action/button hover colors. |
| `$link-visited` | Visited link text | `ui-link` visited state / `--ui-link-visited` when installed | App link palette | Same role / app value | If visited styling is not installed, do not fake it locally. |
| `$text-primary` | Active/pressed link text | `ui-link` active state using primary text role | App text palette | Same role / app value | Active link state may fall back to text primary only through Link CSS. |
| `$text-disabled` | Disabled/unavailable link text | `ui-link-unavailable`, disabled link state | App text disabled role | Same role / app value | Disabled links are non-interactive and must not rely on opacity alone. |
| `$focus` | Keyboard focus border/ring | `ui-link:focus-visible`, `--ui-focus` | App focus palette | Same role / app value | Focus treatment is shared Color Element ownership. |

### 7.3. Approved classes

```css
.ui-link
.ui-link-inline
.ui-link-standalone
.ui-link-with-icon
.ui-link-external
.ui-link-unavailable
```

Do not introduce feature-local link colors, one-off underline rules, arbitrary spacing, local icon sourcing, or custom focus treatment.

## 8. Composition rules

- Use a native `<a>` element with a valid `href` for every interactive link.
- Use Button when the control changes data, submits a form, triggers a command, opens an action menu, toggles state, or manipulates displayed content.
- Inline links sit inside prose and must not include icons.
- Standalone links sit outside prose and may include a trailing icon when the icon clarifies the destination.
- External links use consistent external-destination treatment and must include secure `rel` attributes when opening in a new tab.
- Same-page anchor links must point to a real destination and should not replace page-level navigation patterns.
- Current-link behavior belongs to navigation, breadcrumb, or shell patterns; the Link API only provides the underlying anchor semantics and optional `aria-current` support.
- Unavailable links should usually be omitted. If shown for clarity, they must be visually unavailable, non-interactive, and explained by nearby copy when needed.
- Parent Patterns own link grouping, external spacing, navigation hierarchy, resource-list structure, and route orchestration.

## 9. Selection guidance

### 9.1. Use when:

- A user needs to navigate to another Login App page.
- A user needs to jump to a section on the same page.
- A user needs to open trusted reference content, documentation, or a related resource.
- A user needs to start a protocol destination such as email or phone.
- A text reference needs a lightweight navigational affordance inside body copy.

### 9.2. Do not use when:

- The control changes data, submits a form, deletes a record, saves changes, confirms, cancels, or manipulates displayed state.
- The control opens an action menu. Use Menu buttons or Menu APIs.
- The control toggles an immediate setting. Use Toggle.
- The control selects one or more values. Use Checkbox, Radio button, Select, Dropdown, or Multiselect.
- The element is only decoration, status, or emphasis.
- The destination is represented only by an image. Use Tile or a Pattern-owned card/tile composition.

### 9.3. Choosing nearby APIs

| Need                                                        | Use                                    |
| ----------------------------------------------------------- | -------------------------------------- |
| Navigate to a route or reference                            | Link                                   |
| Submit, save, cancel, delete, confirm, or trigger a command | Button                                 |
| Show a list of actions from a trigger                       | Menu buttons / Menu                    |
| Show the current page hierarchy                             | Breadcrumb                             |
| Represent navigation structure                              | UI shell or Navigation Pattern         |
| Show a resource card with image or richer content           | Tile or Pattern-owned card composition |
| Show inline explanatory help without navigation             | Tooltip or Toggletip                   |

## 10. Accessibility contract

- Use a native anchor with a valid `href` for interactive links.
- Links must be keyboard reachable with Tab and activated with Enter.
- Every link must have meaningful visible text or an accessible name that identifies the destination.
- Avoid generic text such as Click here, More, or Read more. If unavoidable, associate the link with nearby context using `aria-describedby` or `aria-labelledby`.
- Inline links must remain visually distinguishable from surrounding text, including in high-contrast and color-limited contexts.
- Link text and icons must meet contrast requirements against the background and be distinguishable from nearby body text.
- External or new-tab links must make the destination or new context clear through text, icon, or accessible description.
- Icon-only links are not approved as a base component pattern. If a Pattern gates one, it must provide an accessible name, visible focus, and a clear target size.
- Do not rely on color alone to show state, current location, unavailable status, or visited status.
- Do not use `aria-disabled` alone on a link that still has an active `href`.

## 11. Content contract

- Link text must describe the destination, not the action of clicking.
- Use sentence case.
- Keep link text concise but specific.
- Use unique link text for different destinations on the same page.
- Inline link text should fit naturally in the sentence and should not make the sentence hard to scan.
- External links should clarify the destination or provider when that matters for trust.
- New-tab links should not surprise users; prefer same-tab navigation unless preserving the current task is important.
- Do not use vague labels such as Here, Click here, Learn more, More, or Read more unless nearby context is programmatically associated.
- Do not use destructive labels such as Delete tenant as links. Destructive commands are Button-owned.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use links for state-changing commands, form submission, destructive actions, toggles, menu triggers, filtering, sorting, or selection.
- Do not use action-control language in the Link standard or UI Reference page.
- Do not create local colors, margins, underline rules, focus rings, or hover treatments for links.
- Do not use support colors or danger colors as decorative link variants.
- Do not use inline links with icons.
- Do not create image-only links. Use Tile or a Pattern-owned composition.
- Do not render disabled links as normal anchors with active `href` values.
- Do not use `href="#"`, `javascript:void(0)`, or empty `href` as a fake button.
- Do not reuse the same link text for different destinations in the same page region.
- Do not use direct Carbon production classes such as `cds--link` or `bx--link`.

## 13. Deferred or gated capabilities

| Capability                  | Status                 | Gate                                                                                                                                   |
| --------------------------- | ---------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Icon-only link              | Deferred/gated         | Requires an approved navigation/resource pattern, visible focus, accessible-name review, and UI Reference proof.                       |
| Leading icon link           | App-approved exception | Allowed only where an approved Pattern owns a repeated leading-icon layout.                                                            |
| Global visited-link styling | Deferred               | Requires product decision that visited state helps task completion without adding scan noise.                                          |
| Link opens modal            | Gated                  | Requires Overlay/Modal Pattern approval. Use Button unless the trigger is clearly a navigation/reference handoff to read-only content. |
| Link groups helper          | Pattern-owned          | Horizontal/vertical link groups are owned by navigation/resource-list Patterns, not the base Link component.                           |
| Analytics attributes        | Pattern/feature-owned  | Allowed only through documented analytics helpers; do not add one-off data attributes to the Link API.                                 |
| Danger link                 | Not approved           | Use Button with danger semantics and confirmation patterns.                                                                            |

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

The Link page may use grouped examples, comparison grids, and state tables instead of forcing an Accordion-style tab layout. The page must visually prove the difference between navigation links and action controls.

| Required proof                      | Rendered behavior                                                       | Variants/options shown                                                                       |
| ----------------------------------- | ----------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| Inline content link                 | A link embedded in body copy without taking over action hierarchy.      | Inline text, default, hover, focus-visible, active; no icon.                                 |
| Standalone internal link            | A standalone route link after supporting copy.                          | Standalone, medium size, trailing arrow icon optional, app navigation behavior.              |
| External/help link                  | A trusted external or help reference with clear destination treatment.  | External, new-tab treatment when used, trailing launch icon, secure `rel` behavior.          |
| Same-page anchor link               | A link that jumps to a real section on the current page.                | Hash destination, focus-visible, no fake `href="#"`.                                         |
| Navigation/current link             | A lightweight route link where Button would imply a command.            | Current/`aria-current` treatment as Pattern-owned, unavailable treatment.                    |
| Size scale                          | Small, medium, and large link examples using app typography roles.      | `size="sm"`, `size="md"`, `size="lg"`.                                                       |
| Visited policy                      | Opt-in visited styling shown as a policy example, not a global default. | Unvisited, visited, visited disabled/gated note.                                             |
| Unavailable link treatment          | Non-interactive unavailable destination treatment.                      | No active `href`, explanatory copy when needed.                                              |
| Link versus Button versus Menu item | A comparison that prevents command/action misuse.                       | Link for navigation, Button for command, Menu item for grouped actions/navigation.           |
| Developer implementation            | Canonical code examples using installed app APIs.                       | `x-ui.link`, `a.ui-link`, `external`, `newTab`, `variant`, `size`, `current`, `unavailable`. |

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/link` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page includes examples for inline, standalone, external/help, navigation/current, unavailable, visited policy, and size scale behavior.
- The page explicitly distinguishes Link from Button and Menu item.
- Inline links do not render icons.
- External new-tab examples include `target="_blank"` and `rel="noopener noreferrer"` or the app-approved equivalent.
- Unavailable link examples do not include an active navigable `href`.
- Developer examples use canonical APIs and real code, not placeholder comments.
- Regression checks must assert absence of `Component-specific API pending correction`.
- Regression checks must assert absence of `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` labels.
- Regression checks must assert absence of deprecated `tier-1` and `tier-2` canonical documentation paths.
- Regression checks must assert absence of direct Carbon production classes such as `cds--link` and `bx--link`.
- Regression checks must assert absence of button-like Link guidance such as `Use when a user needs to start, confirm`.

## 17. Related APIs

| API                         | Route                                          |
| --------------------------- | ---------------------------------------------- |
| Button                      | /platform/ui-reference/components/button       |
| Menu buttons                | /platform/ui-reference/components/menu-buttons |
| Breadcrumb                  | /platform/ui-reference/components/breadcrumb   |
| Tile                        | /platform/ui-reference/components/tile         |
| Tooltip                     | /platform/ui-reference/components/tooltip      |
| Toggletip                   | /platform/ui-reference/components/toggletip    |
| Color element               | /platform/ui-reference/elements/color          |
| Typography element          | /platform/ui-reference/elements/typography     |
| Icons element               | /platform/ui-reference/elements/icons          |
| Navigation patterns         | /platform/ui-reference/patterns/navigation     |
| Documentation/help patterns | /platform/ui-reference/patterns/data-content   |
| Components overview         | /platform/ui-reference/components              |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Link usage: https://carbondesignsystem.com/components/link/usage/
- Carbon Link style: https://carbondesignsystem.com/components/link/style/
- Carbon Link accessibility: https://carbondesignsystem.com/components/link/accessibility/
- Carbon Link guidance is used as a completeness benchmark for navigation purpose, inline versus standalone variants, states, icon treatment, meaningful text, and accessibility. Login App keeps its own `x-ui.link`, `ui-link`, Heroicons, and token model.