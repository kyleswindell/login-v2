---
title: Accordion
slug: accordion
api_layer: Component API
status: implemented-pending-manual-review
system_maturity: implemented
category: navigation-and-disclosure
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/accordion
canonical_doc: docs/02-standards/ui/components/accordion.md
source_owner: /platform/ui-reference/components/accordion
blade_api:
  - x-ui.accordion
javascript_api:
  - initAccordions
source_files:
  - resources/views/components/ui/accordion.blade.php
  - resources/js/ui-controls/accordions.js
  - resources/js/ui-controls.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - tabs
  - structured-list
  - modal
  - popover
  - toggletip
  - tooltip
related_patterns:
  - data-content
  - forms
carbon_reference:
  - https://carbondesignsystem.com/components/accordion/usage/
  - https://carbondesignsystem.com/components/accordion/style/
  - https://carbondesignsystem.com/components/accordion/accessibility/
---

# Accordion Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical call](#41-canonical-call)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Item data contract](#44-item-data-contract)
  - [4.5. Data attributes](#45-data-attributes)
  - [4.6. CSS namespace](#46-css-namespace)
  - [4.7. JavaScript API](#47-javascript-api)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when](#91-use-when)
  - [9.2. Do not use when](#92-do-not-use-when)
  - [9.3. Choose another API](#93-choose-another-api)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Route and authorization](#161-route-and-authorization)
  - [16.2. Page scaffold assertions](#162-page-scaffold-assertions)
  - [16.3. Live example assertions](#163-live-example-assertions)
  - [16.4. Behavior assertions](#164-behavior-assertions)
  - [16.5. Accessibility assertions](#165-accessibility-assertions)
  - [16.6. Token and implementation assertions](#166-token-and-implementation-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Use accordion to reveal optional supporting content within the current page context.

Canonical API owner: `/platform/ui-reference/components/accordion`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Accordion is the installed Login App 2.0 disclosure API. It owns local expand/collapse semantics, trigger state, panel visibility, animation behavior, and accordion-specific styling. It does not own page-level spacing, workflow orchestration, primary navigation, wizard/progress behavior, validation recovery, or required task instructions.

### 1.1. Canonical API responsibilities:

- Local disclosure for optional secondary content.
- Native trigger semantics.
- Expanded and collapsed state synchronization.
- Optional multi-open or single-open panel behavior.
- Optional compact density.
- Optional contained/contextual surface usage.
- Optional capped scrollable panel behavior for approved secondary reference content.
- Theme-aware color, border, text, icon, focus, spacing, and motion behavior.
- UI Reference proof of supported examples, states, and variants.

### 1.2. Non-owned responsibilities:

- Required task guidance. Keep required instructions visible in the owning Pattern or page section.
- Validation state ownership. Form fields own labels, helper text, errors, and warnings.
- Page-level layout. Use the 2x Grid, Spacing, and Pattern APIs.
- Primary navigation. Use navigation components or Pattern-owned shell APIs.
- Peer-view switching. Use Tabs or Content switcher when implemented.
- Comparable data rows. Use Structured list or Data table.
- Focused tasks. Use Modal or a Pattern-owned workflow.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                 |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented - pending manual review                                                                                                                   |
| System maturity              | Implemented                                                                                                                                           |
| API layer                    | Component API                                                                                                                                         |
| Component slug               | accordion                                                                                                                                             |
| Category                     | Navigation and disclosure                                                                                                                             |
| Priority                     | Tier B - Common reusable component                                                                                                                    |
| UI Reference route           | `/platform/ui-reference/components/accordion`                                                                                                         |
| Canonical doc                | `docs/02-standards/ui/components/accordion.md`                                                                                                        |
| Source owner                 | `/platform/ui-reference/components/accordion`                                                                                                         |
| Blade API                    | `x-ui.accordion`                                                                                                                                      |
| JavaScript API               | `initAccordions`                                                                                                                                      |
| Source files                 | `resources/views/components/ui/accordion.blade.php`; `resources/js/ui-controls/accordions.js`; `resources/js/ui-controls.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion                                                                                                            |
| Carbon benchmark             | Carbon Accordion usage, style, and accessibility guidance                                                                                             |

`Implemented - pending manual review` means the installed API and UI Reference proof exist, but implementation, accessibility, and docs-path alignment still require final manual verification before the component is marked fully reviewed.

## 3. Installed standard

Accordion is the app-owned disclosure primitive for secondary local detail. It supports multiple panels by default, optional single-open behavior, compact density, flush alignment, whole-accordion icon alignment, contained surfaces, and capped scrollable panels.

### The installed standard is:

- Render accordions through `<x-ui.accordion>`.
- Initialize behavior through the installed `initAccordions` JavaScript API.
- Use `data-ui-accordion` attributes as the component behavior contract.
- Use `ui-accordion*` classes as the only component-owned CSS namespace.
- Use native `<button type="button">` triggers.
- Keep `aria-expanded`, `aria-controls`, panel `id`, panel visibility, and internal data state synchronized.
- Use multiple-open behavior by default.
- Use `mode="single"` only when the workflow is clearer with one open section at a time.
- Use compact density only in constrained secondary regions.
- Use contained/contextual treatment only when the accordion is composed inside a parent card, panel, or bounded surface.
- Use scrollable panels only as an app-approved exception for capped secondary reference content.
- Keep required instructions, validation recovery, destructive-action explanation, and primary workflow steps outside collapsed panels.

Carbon divergence note: Carbon guidance generally prefers the whole accordion region to scroll rather than making individual panels scroll. Login App allows capped scrollable panels only as an app-approved exception for secondary reference content that must remain attached to its source setting. Do not use a scrollable accordion panel for required content, long workflows, validation recovery, or primary task steps.

## 4. Public API

### 4.1. Canonical call

```blade
<x-ui.accordion :items="$items" />
```

Use the Blade API instead of hand-building accordion markup in feature views.

### 4.2. API surfaces

| API surface               | Installed value                                              |
| ------------------------- | ------------------------------------------------------------ |
| Blade                     | `x-ui.accordion`                                             |
| JavaScript initializer    | `initAccordions` exported from `resources/js/ui-controls.js` |
| JavaScript implementation | `resources/js/ui-controls/accordions.js`                     |
| Root data attribute       | `data-ui-accordion`                                          |
| Trigger data attribute    | `data-ui-accordion-trigger`                                  |
| Panel data attribute      | `data-ui-accordion-panel`                                    |
| Mode data attribute       | `data-ui-accordion-mode`                                     |
| Alignment data attribute  | `data-ui-accordion-alignment`                                |
| Icon data attribute       | `data-ui-accordion-icon-alignment`                           |
| CSS namespace             | `ui-accordion*`                                              |
| Component route owner     | `/platform/ui-reference/components/accordion`                |

### 4.3. Props and options

| Prop/option      | Type     | Default           | Allowed values                     | Required | Notes                                                                        |
| ---------------- | -------- | ----------------- | ---------------------------------- | -------- | ---------------------------------------------------------------------------- |
| `items`          | `array`  | none              | Accordion item configuration array | Yes      | Preferred data-driven API. Each item must have a stable id and direct title. |
| `variant`        | `string` | `default`         | `default`, `contained`             | No       | Use `contained` only inside a bounded parent surface.                        |
| `alignment`      | `string` | `default`         | `default`, `flush`                 | No       | Use `flush` in smaller side panels or sidebars when rows must align to neighboring rule lines. |
| `iconAlignment`  | `string` | `end`             | `end`, `start`                     | No       | Use `end` by default. Use `start` only for rare tree-like disclosure surfaces and keep it consistent per page. |
| `size`           | `string` | `default`         | `default`, `compact`               | No       | Use `compact` only for dense secondary disclosure.                           |
| `mode`           | `string` | `multiple`        | `multiple`, `single`               | No       | `multiple` allows multiple panels open. `single` keeps only one item open.   |
| `scrollable`     | `bool`   | `false`           | `true`, `false`                    | No       | App-approved exception for capped secondary reference content.               |
| `panelMaxHeight` | `string` | component default | CSS length                         | No       | Only valid when `scrollable=true`. Prefer token-compatible values.           |

### 4.4. Item data contract

The preferred `items` payload should be explicit and stable.

```php
$items = [
    [
        'id' => 'review-summary',
        'title' => 'Review summary',
        'meta' => 'Optional supporting detail',
        'body' => 'Concise secondary content.',
        'open' => true,
        'disabled' => false,
    ],
];
```

| Item key   | Type                         | Required | Allowed values      | Notes                                                                                         |
| ---------- | ---------------------------- | -------- | ------------------- | --------------------------------------------------------------------------------------------- |
| `id`       | `string`                     | Yes      | Stable slug-like id | Must be unique on the page and used to connect trigger and panel ids.                         |
| `title`    | `string`                     | Yes      | Plain text label    | Use sentence case and name the disclosed content directly.                                    |
| `meta`     | `string / null`              | none     | No                  | Optional short metadata under the title. Must not replace required helper or validation text. |
| `body`     | `string / HtmlString / View` | none     | Yes                 | Approved rendered content. Body remains secondary and optional.                               |
| `open`     | `bool`                       | No       | `true`, `false`     | Controls initial expanded state.                                                              |
| `disabled` | `bool`                       | No       | `true`, `false`     | Disabled triggers cannot expand. Explain disabled behavior outside the collapsed panel.       |

Do not pass unreviewed interactive workflows, form validation recovery, navigation menus, or large task flows as accordion body content.

### 4.5. Data attributes

| Attribute                                     | Element | Owner        | Purpose                                                               |
| --------------------------------------------- | ------- | ------------ | --------------------------------------------------------------------- |
| `data-ui-component="accordion"`               | Root    | Component    | Identifies the rendered UI component family.                          |
| `data-ui-accordion="{id}"`                    | Root    | Component    | Identifies one accordion group instance.                              |
| `data-ui-accordion-mode="multiple / single"`  | Root    | Component    | Declares sibling panel behavior.                                      |
| `data-ui-accordion-alignment="default / flush"` | Root  | Component    | Declares row alignment treatment.                                     |
| `data-ui-accordion-icon-alignment="end / start"` | Root | Component    | Declares consistent chevron placement for the accordion instance.     |
| `data-ui-accordion-item`                      | Item    | Component    | Identifies one accordion item.                                        |
| `data-ui-accordion-trigger`                   | Button  | Component JS | Toggle target for the associated panel.                               |
| `data-ui-accordion-panel`                     | Panel   | Component JS | Associated collapsible region.                                        |
| `data-ui-accordion-panel-open="true / false"` | Panel   | Component JS | Read-only rendered state marker.                                      |
| `data-ui-accordion-animating="true / false"`  | Panel   | Component JS | Read-only animation state marker.                                     |
| `data-ui-accordion-init`                      | Root    | Component JS | Read-only initialization marker. Do not set manually in feature code. |

Feature code may configure public props/options. Feature code must not mutate read-only state markers directly.

### 4.6. CSS namespace

Allowed component classes:

```css
.ui-accordion
.ui-accordion-item
.ui-accordion-heading
.ui-accordion-trigger
.ui-accordion-label
.ui-accordion-title
.ui-accordion-meta
.ui-accordion-icon
.ui-accordion-panel
.ui-accordion-body
.ui-accordion-contained
.ui-accordion-flush
.ui-accordion-icon-start
.ui-accordion-compact
.ui-accordion-scrollable
```

Do not create feature-local `accordion-*`, `collapse-*`, Bootstrap collapse, Alpine-only disclosure, or raw utility clusters for the same UI role.

### 4.7. JavaScript API

Canonical initializer:

```js
import { initAccordions } from './ui-controls';

initAccordions();
```

The initializer owns:

- Binding trigger events.
- Synchronizing `aria-expanded`.
- Synchronizing panel `hidden` state.
- Synchronizing `data-ui-accordion-panel-open`.
- Enforcing `multiple` or `single` mode.
- Measuring open and close height when motion is enabled.
- Respecting reduced-motion preferences.
- Preserving focus on the trigger.

Do not create local click handlers for accordion triggers. If behavior is missing, update the component initializer and this standard.

## 5. Allowed variants, options, and modifiers

Only the variants, options, and modifiers below are allowed for Login App 2.0 feature work.

| Name                 | Type           | Status                             | API                                                 | Use when                                                                                 | Do not use when                                                                                                                 |
| -------------------- | -------------- | ---------------------------------- | --------------------------------------------------- | ---------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Default              | Variant        | Implemented                        | `variant="default"`                                 | Standard in-page optional disclosure.                                                    | The accordion is visually nested inside a card/panel requiring contained surface treatment.                                     |
| Contained/contextual | Variant        | Implemented                        | `variant="contained"` or installed contextual class | Accordion sits inside a bounded card, panel, tile-like surface, or settings region.      | The accordion is the primary page structure.                                                                                    |
| Default alignment    | Alignment      | Implemented                        | `alignment="default"`                               | Standard page content needs divider rows with normal interaction padding.                | A constrained side panel or sidebar needs row content flush to neighboring rule lines.                                          |
| Flush alignment      | Alignment      | Implemented                        | `alignment="flush"`                                 | Smaller spaces such as side panels or sidebars need title and chevron alignment with nearby rule dividers. | Primary page content benefits from standard row padding.                                                                        |
| End icon alignment   | Icon alignment | Implemented                        | `iconAlignment="end"`                               | Preferred content and documentation scenario where titles align with surrounding text.   | A rare tree-like disclosure surface needs the chevron before the title.                                                        |
| Start icon alignment | Icon alignment | Implemented                        | `iconAlignment="start"`                             | Rare tree-like disclosure where the chevron should lead the row label.                  | Pure content, documentation, or pages that already use end-aligned accordions.                                                  |
| Default density      | Size           | Implemented                        | `size="default"`                                    | Normal content sections and standard admin pages.                                        | Dense side-panel or utility areas.                                                                                              |
| Compact              | Size           | Implemented                        | `size="compact"`                                    | Dense secondary disclosure inside constrained settings, side panels, or utility regions. | Primary content or large reading areas.                                                                                         |
| Multiple-open        | Mode           | Implemented                        | `mode="multiple"`                                   | Users may need more than one optional section visible at once.                           | Only one section should remain visible to reduce scan noise.                                                                    |
| Single-open          | Mode           | Implemented                        | `mode="single"`                                     | One visible support section is clearer than several expanded panels.                     | Users need to compare multiple pieces of optional content.                                                                      |
| Scrollable panel     | Modifier       | Implemented app-approved exception | `scrollable` with `panelMaxHeight`                  | Capped secondary reference content must stay attached to its source setting.             | Required content, primary workflows, validation recovery, long forms, or anything users must read before continuing.            |
| Disabled item        | State/modifier | Implemented                        | Item `disabled=true`                                | A panel is unavailable because its prerequisite is missing.                              | The user needs the panel to understand why the action is unavailable unless that reason is visible outside the collapsed panel. |

Not installed or not approved:

| Capability                        | Status                 | Reason                                                  |
| --------------------------------- | ---------------------- | ------------------------------------------------------- |
| Nested accordions                 | Deferred               | Requires separate accessibility and content review.     |
| Accordion as navigation           | Not allowed            | Use navigation or shell Pattern APIs.                   |
| Accordion as wizard/progress      | Not allowed            | Use Progress indicator or Pattern-owned workflow.       |
| Accordion as validation container | Not allowed            | Field and Form Pattern APIs own validation.             |
| Custom icon placement per item    | Not allowed by default | Icon alignment must stay consistent within a page.      |
| Feature-local animation           | Not allowed            | Motion belongs to the component and Motion Element API. |

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State          | Status         | Implementation contract                                                             |
| -------------- | -------------- | ----------------------------------------------------------------------------------- |
| Collapsed      | Implemented    | Trigger uses `aria-expanded="false"`; associated panel is hidden and marked closed. |
| Expanded       | Implemented    | Trigger uses `aria-expanded="true"`; associated panel is visible and marked open.   |
| Hover          | Implemented    | Trigger hover uses component-owned token-backed styling.                            |
| Focus-visible  | Implemented    | Trigger exposes a visible token-backed focus indicator.                             |
| Pressed/active | Implemented    | Trigger press state uses component-owned active treatment.                          |
| Disabled       | Implemented    | Trigger is a native disabled button and cannot expand.                              |
| Read-only      | Not applicable | Accordion is disclosure, not data entry.                                            |
| Loading        | Not applicable | Loading belongs to Loading/Inline loading or the owning Pattern.                    |
| Validation     | Not applicable | Validation belongs to fields and Form Patterns.                                     |
| Empty          | Not applicable | Do not render empty accordion items.                                                |

State synchronization requirements:

- `aria-expanded` must match the panel open state.
- `aria-controls` must reference the associated panel `id`.
- Panel `aria-labelledby` must reference the trigger `id` when the panel uses `role="region"`.
- `hidden` must match collapsed panel visibility.
- `data-ui-accordion-panel-open` must match rendered state.
- `mode="single"` must close sibling panels when a new item opens.

## 7. Token, class, and helper usage

Accordion consumes Foundation Color, Spacing, Typography, Motion, and Theme tokens through `ui-accordion` classes.

### Foundation Elements consumed:

| Foundation Element | Required usage                                                                                                               |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------- |
| Color              | Trigger, panel, border, text, helper, icon, hover, active, disabled, and focus styles use role-based tokens.                 |
| Spacing            | Component owns trigger/panel/internal item spacing. Parent layout owns external spacing.                                     |
| Typography         | Trigger titles, metadata, and body copy use approved text roles and sentence case.                                           |
| Themes             | Accordion remains readable in supported light, dark, inline, inverse, and high-contrast contexts where those contexts apply. |
| Motion             | Open/close motion uses installed productive motion and respects reduced-motion preferences.                                  |
| Icons              | Chevron is decorative and hidden from assistive technology. Icon styling uses `currentColor`.                                |

Allowed token/class usage:

```blade
<x-ui.accordion
    :items="$items"
    variant="contained"
    size="compact"
    mode="single"
/>
```

Allowed component namespaces:

- `ui-accordion*`
- `data-ui-accordion*`
- `x-ui.accordion`

Disallowed implementation patterns:

```blade
{{-- Do not hand-roll local disclosure UI. --}}
<div class="accordion custom-collapse" onclick="toggleSomething()">...</div>
```

```html
<!-- Do not use Bootstrap collapse for app-owned disclosure. -->
<div class="accordion" id="localFeatureAccordion">...</div>
```

```js
// Do not attach feature-local toggle handlers for accordion behavior.
document.querySelector('.my-trigger').addEventListener('click', () => {});
```

## 8. Composition rules

Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.

Accordion may be composed inside:

- Page content sections.
- Settings cards.
- Review/configuration cards.
- Side panels.
- Utility panels.
- Form support areas, when content remains optional.
- Documentation/help regions.

Accordion must not own:

- Page-level spacing.
- Grid column behavior.
- Required form labels, helper text, validation, or errors.
- Primary navigation.
- Wizard/progress behavior.
- Action menus.
- Dialog focus trapping.
- Table row expansion behavior unless an explicit Pattern composes it.

Interaction and composition behavior:

- Click, tap, Enter, and Space toggle the focused trigger.
- Focus stays on the trigger after expansion or collapse.
- Tab and Shift+Tab move through accordion triggers and other focusable elements in document order.
- Multiple panels can stay open by default; use `mode="single"` when only one section should remain open.
- Disabled items use native disabled button behavior and cannot expand.
- Panels wrap inside the available width and must not create horizontal overflow.
- Open and close motion uses measured panel height and respects reduced-motion preferences.
- Parent layouts own external spacing; Accordion owns only trigger, item, and panel internals.
- Default Accordion uses divider rules rather than a rounded bordered container.
- Contained Accordion may use a bounded surface only when the parent context requires that treatment.
- Flush Accordion sets row title and chevron padding to 0px at rest and adds 16px inline padding for hover and focus-visible interaction states.
- Icon alignment is selected for the whole accordion instance. Do not alternate start and end icon placement on the same page.
- Nested interactive controls inside a panel must have enough spacing from the trigger region to avoid accidental collapse.

## 9. Selection guidance

### 9.1. Use when

- Secondary details help the task but are not required to continue.
- Grouped help, advanced settings, or review notes would otherwise add visual noise.
- A local section needs optional explanation while the main workflow stays visible.
- Users benefit from a quick overview of available secondary topics.
- Content can be understood from clear, concise trigger labels.

### 9.2. Do not use when

- Users must read the content before continuing, including required instructions or validation errors.
- The UI is primary navigation, wizard steps, or a progress indicator.
- Users need to compare all sections at once; use tabs, a structured list, or visible page sections.
- The content is long enough to require a dedicated page, modal, or Pattern-owned workflow.
- The trigger label would be vague, generic, or unable to accurately summarize the hidden content.
- The panel content is the only explanation for a disabled, destructive, or irreversible action.

### 9.3. Choose another API

| Need                                             | Use instead                                      |
| ------------------------------------------------ | ------------------------------------------------ |
| Switch between peer views                        | Tabs or Content switcher when implemented.       |
| Compare row-like content                         | Structured list or Data table.                   |
| Show focused task or confirmation                | Modal.                                           |
| Show short contextual help attached to a trigger | Toggletip or Tooltip depending on interactivity. |
| Show floating interactive content                | Popover when implemented and approved.           |
| Show primary navigation                          | UI shell or navigation Pattern.                  |
| Show linear process status                       | Progress indicator.                              |
| Show required form guidance                      | Field and Form Pattern APIs.                     |

## 10. Accessibility contract

Accordion must:

- Use a semantic `<button type="button">` for every trigger.
- Keep `aria-expanded`, `aria-controls`, and panel `id` values in sync.
- Use unique trigger and panel ids on the page.
- Show a visible focus state on every trigger.
- Hide decorative chevrons from assistive technology with `aria-hidden="true"`.
- Preserve local heading hierarchy around accordion triggers when the accordion titles function as section headings.
- Ensure panel content remains reachable in normal document and keyboard order when expanded.
- Keep focus on the trigger after expansion or collapse.
- Prevent disabled triggers from receiving active/toggle behavior.
- Keep required instructions, errors, and primary task steps visible outside collapsed panels.
- Avoid horizontal scrolling in panel content.
- Respect reduced-motion preferences for open/close animation.

Recommended semantic structure:

```html
<section class="ui-accordion-item" data-ui-accordion-item>
    <h3 class="ui-accordion-heading">
        <button
            id="accordion-example-trigger"
            type="button"
            class="ui-accordion-trigger"
            aria-expanded="false"
            aria-controls="accordion-example-panel"
            data-ui-accordion-trigger
        >
            <span class="ui-accordion-title">Review history</span>
            <svg class="ui-accordion-icon" aria-hidden="true"></svg>
        </button>
    </h3>

    <div
        id="accordion-example-panel"
        class="ui-accordion-panel"
        role="region"
        aria-labelledby="accordion-example-trigger"
        data-ui-accordion-panel
        hidden
    >
        <div class="ui-accordion-body">...</div>
    </div>
</section>
```

Use `role="region"` only when the panel needs a named region for assistive technology. Do not create excessive landmark noise for many small panels.

## 11. Content contract

Trigger labels must:

- Be sentence case.
- Be brief, direct, and descriptive.
- Name the disclosed content directly, such as `Review history` or `Advanced settings`.
- Avoid vague labels such as `More`, `Details`, `Information`, `Read more`, or `Click here`.
- Remain understandable when all panels are collapsed.
- Avoid ending punctuation unless the label is a question.

Panel content must:

- Stay concise and secondary.
- Support the nearby task without becoming the task.
- Use visible headings, paragraphs, and lists only when needed.
- Keep required guidance, labels, helper text, and validation outside collapsed regions.
- Avoid long workflows. Move substantial content to a page section, modal, or Pattern-owned flow.
- Avoid using collapsed content as the only explanation for disabled or destructive actions.

Metadata text must:

- Be optional.
- Help distinguish the trigger when the title alone is not enough.
- Stay short.
- Not replace visible helper text, validation text, or accessibility naming.

## 12. Prohibited usage

Do not:

- Bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Use Bootstrap collapse, custom Alpine disclosure, or local click handlers for app-owned accordion behavior.
- Hide content users must read before continuing.
- Hide required instructions, validation errors, or recovery steps.
- Use Accordion as primary navigation.
- Use Accordion as wizard steps or a progress indicator.
- Use Accordion where users need to compare all sections at once.
- Use Accordion for menu actions or action overflow.
- Put long forms or multi-step workflows inside an accordion panel.
- Render empty accordion items.
- Add alternate icon sets or custom chevrons without updating the Icons Element standard.
- Change icon placement per item or mix icon alignment within the same page.
- Add raw hex colors, arbitrary spacing, custom focus rings, or feature-local animation.
- Use scrollable panel behavior for required content, validation recovery, destructive-action guidance, or primary workflows.

## 13. Deferred or gated capabilities

| Capability                     | Status      | Gate                                                                                         |
| ------------------------------ | ----------- | -------------------------------------------------------------------------------------------- |
| Nested accordion               | Deferred    | Requires explicit accessibility review, heading hierarchy review, and product-approved need. |
| Async panel loading            | Deferred    | Requires loading, empty, error, retry, focus, and persistence contract.                      |
| Accordion-managed validation   | Not allowed | Field and Form Pattern APIs own validation.                                                  |
| Accordion as navigation        | Not allowed | Use navigation or shell Pattern APIs.                                                        |
| Accordion as wizard/progress   | Not allowed | Use Progress indicator or a Pattern-owned workflow.                                          |
| Per-item custom icon alignment | Deferred    | Requires Icons Element update and accessibility review.                                      |
| Drag/reorder accordion items   | Deferred    | Requires separate sortable pattern and keyboard interaction contract.                        |

Future extensions require an updated Component standard and UI Reference proof before feature implementation.

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

The UI Reference page must render the approved five-card scaffold:

1. Purpose.
2. Use cases.
3. Component contract.
4. Live examples.
5. Related components and patterns.

Accordion is approved as a simple, scenario-driven component page. Its Live examples section should use tabs where each tab is a base usage scenario and variants are shown inside the scenario they affect.

Required rendered proof:

| Required proof                 | Rendered behavior                                                                         | Variants/options shown        |
| ------------------------------ | ----------------------------------------------------------------------------------------- | ----------------------------- |
| Basic accordion                | Minimum viable disclosure with one open panel and one collapsed panel.                    | Compact                       |
| Multiple independent sections  | Independent groups allow more than one optional section to stay open.                     | Single-open                   |
| Long content accordion         | Wrapped body content demonstrates overflow and readable spacing behavior.                 | Scrollable panel              |
| Accordion inside card or panel | A contextual accordion used inside a bounded surface without redefining card spacing.     | Contained contextual, Flush alignment |
| Form assistance accordion      | Optional guidance for form settings that should not replace visible labels or validation. | Compact assistance disclosure |
| Icon alignment                 | Whole-accordion chevron placement remains consistent across all rows in an instance.      | End alignment, Start alignment |

### The UI Reference page must also show:

- Purpose Card with implementation status.
- Use Cases Card with 50/50 `Use when` and `Do not use when` content.
- Component Contract Card with Anatomy and States in a 50/50 split.
- Behavior, Developer implementation, Content guidance, and Accessibility requirements in the Component Contract Card.
- Live Examples section using rendered production component code, not screenshots.
- Variant proof rendered inside the relevant live-example scenario.
- Related Components and Patterns Card.
- Foundation Elements consumed.
- Canonical API call.
- Source files.
- Data attributes.
- Props/options.
- Deferred/gated capabilities, if any.

Required anatomy labels for the UI Reference page:

- Group.
- Item.
- Heading.
- Trigger.
- Title.
- Chevron.
- Icon alignment: end.
- Icon alignment: start.
- Flush alignment.
- Panel.
- Body.
- Metadata.

Required state labels for the UI Reference page:

- Collapsed.
- Expanded.
- Hover.
- Focus-visible.
- Pressed.
- Disabled.
- Not applicable: read-only.
- Not applicable: loading.
- Not applicable: validation.
- Not applicable: empty.

## 16. Testing and acceptance criteria

### 16.1. Route and authorization

- `/platform/ui-reference/components/accordion` returns 200 for authorized users.
- Unauthorized users cannot access the route.
- The route renders the current canonical doc path: `docs/02-standards/ui/components/accordion.md`.
- The route must not link to the deprecated `docs/02-standards/ui/components/tier-1/accordion.md` path after the documentation migration is complete.

### 16.2. Page scaffold assertions

- The page renders Purpose, Use cases, Component contract, Live examples, and Related components and patterns in that order.
- No `Legacy Contract Summary`, duplicate `Reference Examples`, or generic fallback sections appear.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.

### 16.3. Live example assertions

- `Basic accordion` renders one expanded item and one collapsed item.
- `Multiple independent sections` renders multiple open panels and includes disabled item behavior.
- `Single-open` proof renders `data-ui-accordion-mode="single"`.
- `Long content accordion` demonstrates wrapping and no horizontal overflow.
- `Scrollable panel` proof renders only as an app-approved secondary reference exception.
- `Accordion inside card or panel` renders contained/contextual styling inside a parent surface.
- `Flush alignment` renders `data-ui-accordion-alignment="flush"` and keeps row title and chevron flush to the rule line at rest.
- `Start icon alignment` renders `data-ui-accordion-icon-alignment="start"` and `ui-accordion-icon-start`.
- `Form assistance accordion` explicitly states that hidden content does not replace visible labels, helper text, or validation.

### 16.4. Behavior assertions

- Trigger click toggles the associated panel.
- Enter toggles the focused trigger.
- Space toggles the focused trigger.
- Focus remains on the trigger after toggle.
- `aria-expanded` changes with state.
- Collapsed panels use `hidden`.
- Disabled triggers do not toggle.
- In `mode="single"`, opening one item closes sibling panels.
- Open/close behavior respects reduced-motion preferences.

### 16.5. Accessibility assertions

- Each trigger is a native button.
- Every trigger has a unique `id`.
- Every panel has a unique `id`.
- Every trigger has `aria-controls` pointing to the associated panel.
- Every panel using `role="region"` has `aria-labelledby` pointing to the trigger.
- Decorative chevrons are hidden from assistive technology.
- Visible focus is present.
- Required instructions and validation are not hidden inside collapsed panels.

### 16.6. Token and implementation assertions

- Rendered examples use `x-ui.accordion`, `ui-accordion*`, and `data-ui-accordion*` conventions.
- Rendered examples do not use Bootstrap collapse, local feature toggles, raw hex colors, arbitrary spacing, or one-off icon markup outside the allowed API.
- Component examples remain readable in supported theme contexts.
- Component examples use production CSS/JS rather than screenshots only.

## 17. Related APIs

| API                        | Route                                               | Use instead when                                                              |
| -------------------------- | --------------------------------------------------- | ----------------------------------------------------------------------------- |
| Tabs                       | `/platform/ui-reference/components/tabs`            | Users switch between peer views or sections of comparable importance.         |
| Structured list            | `/platform/ui-reference/components/structured-list` | Users need to scan comparable row-like content.                               |
| Modal                      | `/platform/ui-reference/components/modal`           | Users must complete or confirm a focused task.                                |
| Popover                    | `/platform/ui-reference/components/popover`         | Floating interactive content is required and the Popover API is implemented.  |
| Toggletip                  | `/platform/ui-reference/components/toggletip`       | Short contextual help needs a focusable trigger and dismissible rich content. |
| Tooltip                    | `/platform/ui-reference/components/tooltip`         | Non-interactive hover/focus assistance is enough.                             |
| Help/documentation pattern | `/platform/ui-reference/patterns/data-content`      | The page needs documentation or help composition beyond one component.        |
| Forms/settings patterns    | `/platform/ui-reference/patterns/forms`             | Form layout, validation, and required guidance are the owner.                 |
| 2x Grid Element            | `/platform/ui-reference/elements/2x-grid`           | Page-level placement and responsive columns are needed.                       |
| Spacing Element            | `/platform/ui-reference/elements/spacing`           | Parent-owned external spacing or layout rhythm is needed.                     |
| Motion Element             | `/platform/ui-reference/elements/motion`            | Motion or reduced-motion behavior needs adjustment.                           |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Accordion usage: `https://carbondesignsystem.com/components/accordion/usage/`
- Carbon Accordion style: `https://carbondesignsystem.com/components/accordion/style/`
- Carbon Accordion accessibility: `https://carbondesignsystem.com/components/accordion/accessibility/`
- Carbon informs the Accordion completeness benchmark for anatomy, alignment, placement, content, states, keyboard behavior, and accessibility. Login App owns the installed Blade, JavaScript, CSS, token, and UI Reference API.
