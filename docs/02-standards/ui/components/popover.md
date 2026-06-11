---
title: Popover
slug: popover
status: implemented-standard
api_layer: Component API
category: Navigation and disclosure
priority: Tier C - Contextual component
ui_reference_route: /platform/ui-reference/components/popover
canonical_doc: docs/02-standards/ui/components/popover.md
source_owner: /platform/ui-reference/components/popover
carbon_reference: https://carbondesignsystem.com/components/popover/usage/
consumes:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - modal
  - tooltip
  - toggletip
  - menu-buttons
  - dropdown
  - contained-list
related_patterns:
  - overlays-feedback
---

# Popover Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard supports:](#31-the-installed-standard-supports)
- [4. Public API](#4-public-api)
  - [4.1. Props and options](#41-props-and-options)
  - [4.2. Slots](#42-slots)
  - [4.3. Data attributes](#43-data-attributes)
  - [4.4. CSS namespace](#44-css-namespace)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed](#71-foundation-elements-consumed)
  - [7.2. Token and class requirements](#72-token-and-class-requirements)
  - [7.3. Installed CSS namespace](#73-installed-css-namespace)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use Popover when](#91-use-popover-when)
  - [9.2. Do not use Popover when](#92-do-not-use-popover-when)
  - [9.3. Choose nearby APIs this way](#93-choose-nearby-apis-this-way)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. UI Reference requirements](#14-ui-reference-requirements)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Recommended regression assertions](#151-recommended-regression-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Popover presents a temporary floating layer of supporting content attached to a trigger.

Canonical API owner: `/platform/ui-reference/components/popover`. Use this Component API instead of creating local floating panels, custom positioned layers, tooltip-like hybrids, menu hybrids, or ad hoc disclosure overlays for the same UI role.

Popover is the app-owned Component API for non-blocking floating content that may contain readable supporting content and limited interactive controls. It is not a command menu, selection menu, tooltip, modal, or replacement for visible page content.

## 2. Status and ownership

| Field              | Value                                        |
| ------------------ | -------------------------------------------- |
| Status             | Implemented standard                         |
| API layer          | Component API                                |
| Component slug     | popover                                      |
| Category           | Navigation and disclosure                    |
| Priority           | Tier C - Contextual component                |
| UI Reference route | `/platform/ui-reference/components/popover`  |
| Canonical doc      | `docs/02-standards/ui/components/popover.md` |
| Source owner       | `/platform/ui-reference/components/popover`  |
| Blade owner        | `x-ui.popover`                               |
| JavaScript owner   | `initPopovers`                               |
| CSS namespace      | `ui-popover*`                                |

## 3. Installed standard

Popover is the installed floating-content component for contextual, non-blocking supporting content.

### 3.1. The installed standard supports:

- A trigger connected to one floating panel.
- Open and closed states.
- Focus-visible trigger and panel controls.
- Escape dismissal.
- Outside-click dismissal.
- Trigger reactivation dismissal.
- Focus return to the trigger after dismissal.
- Placement options.
- Alignment options.
- Size options.
- Optional caret/tip.
- Optional close control.
- Limited interactive content inside the panel.
- Theme-aware surface, border, shadow, text, focus, and state tokens.
- Reduced-motion behavior.

Use Popover only when content must appear near a trigger and does not justify a Modal, Menu button, Dropdown, Tooltip, Toggletip, or visible page section.

## 4. Public API

| API surface     | Installed value                                                                                                    |
| --------------- | ------------------------------------------------------------------------------------------------------------------ |
| Blade           | `x-ui.popover`                                                                                                     |
| JavaScript      | `initPopovers` exported from the app UI controls bundle                                                            |
| Data attributes | `data-ui-popover`, `data-ui-popover-trigger`, `data-ui-popover-panel`, `data-ui-popover-close`                     |
| Props/options   | `id`, `placement`, `align`, `size`, `tip`, `caret`, `triggerKind`, `triggerIcon`, `interaction`, `closeable`, `open`, `disabled`, `label`, `panelLabel`, `strategy` |
| CSS namespace   | `ui-popover`, `ui-popover-trigger`, `ui-popover-panel`, `ui-popover-content`, `ui-popover-caret`                   |
| Source files    | `resources/views/components/ui/popover.blade.php`; `resources/js/ui-controls/popovers.js`; `resources/css/app.css` |

Example call:

```blade
<x-ui.popover
    id="workspace-status-popover"
    placement="bottom"
    align="start"
    size="md"
    panel-label="Workspace status details"
>
    <x-slot:trigger>
        <x-ui.button semantic="ghost" size="sm">
            View status details
        </x-ui.button>
    </x-slot:trigger>

    <p>
        Workspace status summarizes sync, access, and review activity for this record.
    </p>
</x-ui.popover>
```

### 4.1. Props and options

| Prop         | Type   | Default  | Allowed values                           | Notes                                                                |
| ------------ | ------ | -------- | ---------------------------------------- | -------------------------------------------------------------------- |
| `id`         | string | required | unique HTML id                           | Used to connect trigger and panel.                                   |
| `placement`  | string | `bottom` | `top`, `right`, `bottom`, `left`, `auto` | Defines preferred panel placement relative to the trigger.           |
| `align`      | string | `center` | `start`, `center`, `end`                 | Defines panel alignment along the trigger edge.                      |
| `size`       | string | `md`     | `sm`, `md`, `lg`                         | Defines panel width and padding treatment.                           |
| `tip`        | string | `caret`  | `none`, `caret`, `tab`                   | Defines the visual connector between trigger and panel.              |
| `caret`      | bool   | `null`   | `true`, `false`, `null`                  | Backward-compatible alias; `false` resolves to `tip="none"`.        |
| `triggerKind` | string | `icon` | `icon`, `button`, `ghost`                | Defines the rendered trigger shape.                                  |
| `triggerIcon` | string | `heroicon-o-information-circle` | approved icon component | Icon used by icon trigger mode.                                      |
| `interaction` | string | `click` | `click`, `hover`, `focus`                | Opens the panel according to the approved disclosure trigger mode.   |
| `closeable`  | bool   | `true`   | `true`, `false`                          | Adds an internal close button for panels with richer content.        |
| `open`       | bool   | `false`  | `true`, `false`                          | Initial open state for UI Reference proof or controlled integration. |
| `disabled`   | bool   | `false`  | `true`, `false`                          | Disables the trigger and prevents the panel from opening.            |
| `label`      | string | `null`   | accessible trigger label                 | Required when the trigger is icon-only.                              |
| `panelLabel` | string | required | accessible panel label                   | Describes the panel content for assistive technology.                |
| `strategy`   | string | `fixed`  | `fixed`, `absolute`                      | Use `fixed` for overlays; use `absolute` only inside bounded owners. |

### 4.2. Slots

| Slot      | Required | Purpose                                                       |
| --------- | -------- | ------------------------------------------------------------- |
| `trigger` | Yes      | Renders the button or approved trigger control.               |
| default   | Yes      | Renders panel content.                                        |
| `title`   | No       | Optional concise panel heading.                               |
| `footer`  | No       | Optional low-density action row for secondary panel controls. |

### 4.3. Data attributes

| Attribute                 | Owner   | Purpose                                            |
| ------------------------- | ------- | -------------------------------------------------- |
| `data-ui-popover`         | Root    | Popover initialization scope.                      |
| `data-ui-popover-trigger` | Trigger | Opens, closes, and owns expanded state.            |
| `data-ui-popover-panel`   | Panel   | Floating panel controlled by the trigger.          |
| `data-ui-popover-tip`     | Root    | Records `none`, `caret`, or `tab` tip treatment.   |
| `data-ui-popover-content` | Body    | Scrollable body region when overflow is needed.    |
| `data-ui-popover-close`   | Control | Closes the panel and returns focus to the trigger. |

### 4.4. CSS namespace

```css
.ui-popover
.ui-popover-trigger
.ui-popover-panel
.ui-popover-content
.ui-popover-caret
.ui-popover-open
.ui-popover-placement-top
.ui-popover-placement-right
.ui-popover-placement-bottom
.ui-popover-placement-left
.ui-popover-align-start
.ui-popover-align-center
.ui-popover-align-end
.ui-popover-size-sm
.ui-popover-size-md
.ui-popover-size-lg
```

## 5. Allowed variants, options, and modifiers

| Name                   | Type       | Status      | API                                   | Use when                                                                 |
| ---------------------- | ---------- | ----------- | ------------------------------------- | ------------------------------------------------------------------------ |
| No tip                 | Variant    | Implemented | `tip="none"`                          | The trigger already has a visually defined down state.                   |
| Caret tip              | Variant    | Implemented | `tip="caret"`                         | A pointed connector helps associate panel and trigger.                   |
| Tab tip                | Variant    | Implemented | `tip="tab"`                           | A wider tab connector fits a broader trigger edge.                       |
| Basic popover          | Variant    | Implemented | default slot content                  | A trigger needs nearby supporting content.                               |
| Interactive popover    | Variant    | Implemented | focusable controls in panel           | The panel includes limited links, buttons, or simple controls.           |
| Top placement          | Placement  | Implemented | `placement="top"`                     | The panel should appear above the trigger.                               |
| Right placement        | Placement  | Implemented | `placement="right"`                   | The panel should appear to the right of the trigger.                     |
| Bottom placement       | Placement  | Implemented | `placement="bottom"`                  | Default placement below the trigger.                                     |
| Left placement         | Placement  | Implemented | `placement="left"`                    | The panel should appear to the left of the trigger.                      |
| Auto placement         | Placement  | Implemented | `placement="auto"`                    | The panel may choose the best available viewport position.               |
| Start alignment        | Alignment  | Implemented | `align="start"`                       | Align the panel start edge to the trigger.                               |
| Center alignment       | Alignment  | Implemented | `align="center"`                      | Center the panel to the trigger.                                         |
| End alignment          | Alignment  | Implemented | `align="end"`                         | Align the panel end edge to the trigger.                                 |
| Small panel            | Size       | Implemented | `size="sm"`                           | Short supporting text.                                                   |
| Medium panel           | Size       | Implemented | `size="md"`                           | Default contextual content.                                              |
| Large panel            | Size       | Implemented | `size="lg"`                           | Richer supporting content that still does not require Modal.             |
| Trigger button         | Trigger    | Implemented | `triggerKind="button"`                | Visible text trigger with button structure is needed.                    |
| Ghost trigger          | Trigger    | Implemented | `triggerKind="ghost"`                 | Low-emphasis text trigger is appropriate.                                |
| Icon trigger           | Trigger    | Implemented | `triggerKind="icon"`                  | The default compact trigger has an accessible label.                     |
| Click interaction      | Trigger    | Implemented | `interaction="click"`                 | Default disclosure behavior.                                             |
| Hover interaction      | Trigger    | Implemented | `interaction="hover"`                 | The disclosure pattern explicitly allows hover opening.                  |
| Focus interaction      | Trigger    | Implemented | `interaction="focus"`                 | Keyboard focus should reveal supporting content.                         |
| Close control          | Modifier   | Implemented | `closeable`                           | The panel contains richer content or needs an explicit dismissal target. |
| Async content          | Capability | Gated       | requires loading/error/retry contract | Use only after loading, error, and retry behavior are documented.        |
| Rich form content      | Capability | Gated       | requires Pattern review               | Use Modal or a page section unless the content is limited and justified. |
| Contained list content | Capability | Gated       | requires Contained list approval      | Use only when bounded rows are approved as a child composition.          |
| Nested popover         | Capability | Not allowed | none                                  | Nested floating layers are not approved.                                 |
| Command menu popover   | Capability | Not allowed | none                                  | Use Menu buttons/Menu for grouped commands.                              |
| Selection menu popover | Capability | Not allowed | none                                  | Use Dropdown, Select, or Multiselect when approved.                      |
| Blocking popover       | Capability | Not allowed | none                                  | Use Modal for blocking decisions or focused tasks.                       |

## 6. States

| State              | Status         | Required behavior                                                                  |
| ------------------ | -------------- | ---------------------------------------------------------------------------------- |
| Closed             | Implemented    | Panel is hidden; trigger `aria-expanded` is `false`.                               |
| Open               | Implemented    | Panel is visible; trigger `aria-expanded` is `true`.                               |
| Hover              | Implemented    | Trigger hover uses token-backed state styles.                                      |
| Focus-visible      | Implemented    | Trigger and internal panel controls show visible focus.                            |
| Active/pressed     | Implemented    | Trigger active state is visible during activation.                                 |
| Disabled trigger   | Implemented    | Trigger cannot open the panel.                                                     |
| Dismissed          | Implemented    | Escape, close control, outside click, or trigger reactivation closes the panel.    |
| Placement fallback | Implemented    | Auto placement prevents viewport clipping where available.                         |
| Overflow/scroll    | Implemented    | Panel content wraps; capped overflow uses approved max-height and scroll behavior. |
| Loading content    | Gated          | Requires async content approval.                                                   |
| Error content      | Gated          | Requires async content approval.                                                   |
| Validation         | Not applicable | Popover does not own field validation.                                             |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Popover consumes Foundation Element APIs through the installed `ui-popover*` namespace.

### 7.1. Foundation Elements consumed

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons, when a trigger icon, close icon, or caret is used.

### 7.2. Token and class requirements

| Foundation Element | Allowed usage                                                          |
| ------------------ | ---------------------------------------------------------------------- |
| Color              | Panel background, border, shadow, text, focus, and state tokens.       |
| Spacing            | Panel padding, trigger gap, caret offset, and internal content rhythm. |
| Typography         | Title, body, helper copy, metadata, and action text roles.             |
| Themes             | Light, dark, inverse, layered, and inline theme contexts.              |
| Motion             | Open/close transition with reduced-motion support.                     |
| Icons              | Trigger, close, and caret icons only through the approved Icon API.    |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Standard popover container background | `ui-popover-panel`, layer surface role | App layer palette | Same role / app value | Popover surfaces share layer roles with menus/dialog panels. |
| `$text-primary`, `$text-secondary` | Popover title/body/helper text | `ui-popover-content` text roles | App text palette | Same role / app value | Popover does not define custom text colors. |
| `$border-subtle`, elevation/shadow token roles | Popover panel edge/elevation where tokenized | `ui-popover-panel` border/elevation aliases | App border/elevation palette | Same role / app value | Shadow/elevation must be token-backed where installed. |
| `$focus` | Trigger/close focus treatment | Trigger component focus or `ui-popover-trigger:focus-visible` | App focus palette | Same role / app value | Trigger components own their own focus where composed. |
| `$background-inverse` | Inverse popover container | No hard standard until verified | None | Needs verification | Carbon inventory marks inverse popover mapping partial; do not standardize inverse popovers without source proof. |

### 7.3. Installed CSS namespace

```css
.ui-popover
.ui-popover-trigger
.ui-popover-panel
.ui-popover-content
.ui-popover-caret
.ui-popover-open
.ui-popover-placement-top
.ui-popover-placement-right
.ui-popover-placement-bottom
.ui-popover-placement-left
.ui-popover-align-start
.ui-popover-align-center
.ui-popover-align-end
.ui-popover-size-sm
.ui-popover-size-md
.ui-popover-size-lg
```

Do not add feature-local popover classes. Extend this Component API standard and UI Reference proof before adding new namespace entries.

## 8. Composition rules

Popover composes a trigger and a temporary floating panel.

- The trigger is a native button or approved Button/Icon button Component.
- The trigger owns `aria-expanded`.
- The trigger controls one panel.
- The panel is positioned relative to the trigger.
- The panel closes on Escape.
- The panel closes on outside click.
- The panel closes when a close control is activated.
- The panel closes when the trigger is reactivated.
- Focus returns to the trigger after dismissal.
- The panel must not trap focus like Modal.
- The panel must not open another Popover.
- The panel may contain limited focusable controls.
- The panel must hand off to Modal or a Pattern-owned page section when content becomes too large or task-like.
- Parent Patterns own placement in the workflow and external spacing.
- Popover owns trigger/panel semantics, internal spacing, local state, and dismissal behavior.

## 9. Selection guidance

### 9.1. Use Popover when

- A trigger needs temporary supporting content near its source.
- The content is more than a Tooltip but less than a Modal.
- The content may include limited links, buttons, or simple controls.
- The user can continue the page workflow without completing the popover content.
- The panel helps explain or supplement a local control, status, summary, or object.

### 9.2. Do not use Popover when

- The content is short and non-interactive. Use Tooltip.
- The content is brief click-triggered help. Use Toggletip.
- The user must make a blocking decision or complete a focused task. Use Modal.
- The trigger reveals grouped commands. Use Menu buttons/Menu.
- The trigger selects from known options. Use Dropdown or Select.
- The content is long documentation, a multi-step workflow, or a substantial form. Use a page section, Modal, or Pattern-owned flow.
- The content can remain visible without harming scanability.

### 9.3. Choose nearby APIs this way

| Need                                   | Use                                     |
| -------------------------------------- | --------------------------------------- |
| Short non-interactive hover/focus text | Tooltip                                 |
| Brief click-triggered help             | Toggletip                               |
| Grouped commands                       | Menu buttons/Menu                       |
| Known-option selection                 | Dropdown or Select                      |
| Blocking decision or contained task    | Modal                                   |
| Large help or documentation            | Page section or Pattern-owned help flow |
| Local supporting floating content      | Popover                                 |

## 10. Accessibility contract

Popover must:

- Use a semantic trigger, usually a native `button` or approved Button/Icon button Component.
- Provide an accessible name for icon-only triggers.
- Keep trigger `aria-expanded` synchronized with panel state.
- Keep `aria-controls` synchronized with the panel `id` when applicable.
- Provide an accessible panel label through `panelLabel`, `aria-label`, or a labelled heading.
- Keep focus movement predictable.
- Return focus to the trigger after dismissal.
- Support Escape dismissal.
- Keep all panel controls keyboard reachable.
- Preserve visible focus on trigger and panel controls.
- Avoid focus traps.
- Avoid relying on color alone for status or state.
- Maintain contrast in supported themes.
- Respect reduced-motion preferences.

Use ARIA only to describe the installed behavior. Do not use ARIA to compensate for missing keyboard, focus, or dismissal behavior.

## 11. Content contract

Popover content must be concise and task-bound.

- Use a clear trigger label or accessible trigger name.
- Use a short title only when the panel needs structure.
- Keep body copy brief.
- Use visible labels for interactive controls.
- Use specific action labels.
- Avoid vague trigger labels such as More, Info, or Details unless surrounding context makes the target clear.
- Do not put required instructions, validation recovery, or destructive confirmation only inside a popover.
- Do not use Popover for long documentation, multi-step workflows, large forms, or marketing copy.
- Move substantial content to a Modal, page section, or Pattern-owned flow.

## 12. Prohibited usage

- Do not bypass this Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create local `data-popover`, `data-tooltip`, `data-float`, or one-off positioning attributes outside the documented API.
- Do not use Popover for command menus. Use Menu buttons/Menu.
- Do not use Popover for selection menus. Use Dropdown, Select, or Multiselect when approved.
- Do not use Popover for non-interactive hover/focus text. Use Tooltip.
- Do not use Popover for brief click-triggered help when Toggletip satisfies the requirement.
- Do not use Popover for blocking decisions, destructive confirmation, or contained tasks. Use Modal.
- Do not nest popovers or layer multiple floating surfaces from one trigger.
- Do not place required form validation recovery only inside Popover.
- Do not hard-code panel color, shadow, z-index, spacing, animation, or focus treatment.

## 13. Deferred or gated capabilities

The core Popover API is implemented as the expected standard. Advanced capabilities require an updated Component standard and UI Reference proof before use.

| Capability              | Status      | Requirement                                                                                  |
| ----------------------- | ----------- | -------------------------------------------------------------------------------------------- |
| Async content           | Gated       | Define loading, error, retry, and persistence behavior.                                      |
| Rich form content       | Gated       | Use Modal or a page section unless the form is limited and the accessibility flow is proven. |
| Contained list content  | Gated       | Requires approved Contained list API and keyboard behavior.                                  |
| Search/filter content   | Gated       | Requires Pattern review for search scope, loading, no-results, and keyboard behavior.        |
| Persistent pinned panel | Gated       | Requires explicit persistence, dismissal, and layout rules.                                  |
| Nested popovers         | Not allowed | Nested floating layers are not approved.                                                     |
| Blocking workflow       | Not allowed | Use Modal.                                                                                   |
| Command menu behavior   | Not allowed | Use Menu buttons/Menu.                                                                       |
| Known-option selection  | Not allowed | Use Dropdown or Select.                                                                      |

## 14. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Popover UI Reference page must render production examples through the installed Component API.

| Required proof           | Rendered behavior                                                                                  | Variants/options shown                                          |
| ------------------------ | -------------------------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| No tip                   | A closed text/button trigger opens a nearby panel without a visual connector.                      | `tip="none"`, button and ghost trigger options                  |
| Caret tip                | A closed trigger opens a panel with a pointed caret connector.                                     | `tip="caret"`, top/bottom alignment behavior                    |
| Tab tip                  | A closed trigger opens a panel with a wider tab connector.                                        | `tip="tab"`, center/end alignment behavior                      |
| Placement and alignment  | Examples show top, right, bottom, left, start, center, and end behavior.                           | Placement, alignment, tip behavior                              |
| Overflow content         | Header/footer stay fixed while only the body region scrolls vertically.                            | `data-ui-popover-content`, large panel, no horizontal overflow  |
| Trigger button options   | Examples show icon, visible button, ghost, hover, focus, disabled, and click triggers.             | `triggerKind`, `interaction`, disabled                          |
| Related API boundary     | Comparison explains Popover versus Tooltip, Toggletip, Modal, Menu buttons/Menu, and Dropdown.     | Boundary rules                                                  |
| Gated capability rows    | Advanced capabilities appear as gated rows with requirements instead of unsupported live controls. | Async content, rich forms, persistent panels, nested popovers   |
| Developer implementation | Page shows canonical Blade, data attributes, JavaScript initializer, classes, and source owners.   | `x-ui.popover`, `initPopovers`, `data-ui-popover`, `ui-popover` |

## 15. Testing and acceptance criteria

- `/platform/ui-reference/components/popover` returns 200 for authorized users.
- The page shows status `Implemented standard`.
- The page shows the installed `x-ui.popover` API.
- The page shows `initPopovers`.
- The page shows installed data attributes and `ui-popover*` classes.
- The page shows allowed placements, alignments, sizes, caret behavior, close behavior, and trigger types.
- The page shows states, prohibited usage, gated capabilities, and Foundation Elements consumed.
- The page renders production Popover examples with app CSS/JS rather than screenshots only.
- The page distinguishes Popover from Tooltip, Toggletip, Modal, Menu buttons/Menu, Dropdown, and visible page content.
- The page does not include generic placeholder content.

### 15.1. Recommended regression assertions

```php
$response->assertOk();
$response->assertSee('Popover');
$response->assertSee('Implemented standard');
$response->assertSee('x-ui.popover');
$response->assertSee('initPopovers');
$response->assertSee('data-ui-popover');
$response->assertSee('ui-popover');
$response->assertSee('No tip');
$response->assertSee('Caret tip');
$response->assertSee('Tab tip');
$response->assertSee('Placement options');
$response->assertSee('Overflow content');
$response->assertSee('Trigger button options');
$response->assertSee('Gated capability rows');
$response->assertSee('Use Tooltip');
$response->assertSee('Use Toggletip');
$response->assertSee('Use Modal');
$response->assertSee('Use Menu buttons');
$response->assertSee('Use Dropdown');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Popover remains deferred');
$response->assertDontSee('Use this deferred page');
$response->assertDontSee('No production public API is approved');
$response->assertDontSee('Reserved future');
$response->assertDontSee('Future implementation');
$response->assertDontSee('Future token');
$response->assertDontSee('cds--popover');
$response->assertDontSee('bx--popover');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
```

## 16. Related APIs

| API                            | Route                                               |
| ------------------------------ | --------------------------------------------------- |
| Tooltip                        | `/platform/ui-reference/components/tooltip`         |
| Toggletip                      | `/platform/ui-reference/components/toggletip`       |
| Modal                          | `/platform/ui-reference/components/modal`           |
| Menu buttons                   | `/platform/ui-reference/components/menu-buttons`    |
| Dropdown                       | `/platform/ui-reference/components/dropdown`        |
| Contained list                 | `/platform/ui-reference/components/contained-list`  |
| Overlays and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback` |
| Disclosure behavior owner      | `/platform/ui-reference/patterns/overlays-feedback` |
| Components overview            | `/platform/ui-reference/components`                 |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Popover provides the completeness benchmark for floating layers that display additional details above page content. Login App implements Popover through its own `x-ui.popover`, `initPopovers`, and `ui-popover*` APIs.
