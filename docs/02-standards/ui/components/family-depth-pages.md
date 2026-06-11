---
title: Component Family Depth Page Standard
slug: component-family-depth-page-standard
api_layer: Component UI Reference Standard
status: implemented-pending-manual-review
system_maturity: partial-family-rollout
category: component-reference-pages
priority: component-family-correction
ui_reference_owner: /platform/ui-reference/components
canonical_doc: docs/02-standards/ui/components/family-depth-pages.md
source_owner: /platform/ui-reference/components
foundation_elements:
  - color
  - spacing
  - typography
  - icons
  - motion
  - themes
  - 2x-grid
related_indexes:
  - docs/02-standards/ui/components/index.md
  - docs/02-standards/ui/components/checklist.md
  - docs/02-standards/ui/elements/index.md
  - docs/02-standards/ui/patterns/index.md
---

# Component Family Depth Page Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Required page shape](#4-required-page-shape)
  - [4.1. Purpose card](#41-purpose-card)
  - [4.2. Use cases card](#42-use-cases-card)
  - [4.3. Component contract card](#43-component-contract-card)
  - [4.4. Live examples card](#44-live-examples-card)
  - [4.5. Related components and patterns card](#45-related-components-and-patterns-card)
- [5. Live example selection rules](#5-live-example-selection-rules)
- [6. Foundation Element dependency](#6-foundation-element-dependency)
- [7. Family coverage](#7-family-coverage)
- [8. Deferred boundary](#8-deferred-boundary)
- [9. Developer implementation](#9-developer-implementation)
- [10. Review rule](#10-review-rule)
- [11. Prohibited usage](#11-prohibited-usage)
- [12. UI Reference requirements](#12-ui-reference-requirements)
- [13. Testing and acceptance criteria](#13-testing-and-acceptance-criteria)
- [14. Related APIs](#14-related-apis)
- [15. References](#15-references)

## 1. API summary

This standard governs Login App 2.0 Component UI Reference family-depth pages under `/platform/ui-reference/components`.

Use this standard when creating, correcting, or reviewing a Component UI Reference page. It preserves the approved Accordion scaffold while allowing each Component page to choose the live-example structure that best proves the installed API.

Component family-depth pages are rendered proof for Component API standards. They must show app-owned examples, supported variants, states, behavior, implementation details, content guidance, accessibility requirements, deferred gates, and related Pattern links. They must not render abstract design commentary, generic fallback text, speculative complete UI, or disconnected prose-only variant lists.

## 2. Status and ownership

| Field                        | Value                                                                                                                 |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented - pending manual review                                                                                   |
| System maturity              | Partial family rollout                                                                                                |
| API layer                    | Component UI Reference Standard                                                                                       |
| Standard slug                | `component-family-depth-page-standard`                                                                                |
| UI Reference owner           | `/platform/ui-reference/components`                                                                                   |
| Canonical doc                | `docs/02-standards/ui/components/family-depth-pages.md`                                                               |
| Applies to                   | All Component family-depth pages under `/platform/ui-reference/components/{slug}`                                     |
| Source owner                 | Component route owner for each page                                                                                   |
| Foundation Elements consumed | Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid where layout is relevant                               |
| Related standards            | Component Standards Index, Component Implementation Checklist, Foundation Elements Standards, Pattern Standards Index |

`Implemented - pending manual review` means the page model is approved for use, but individual Component pages still need review against this standard as they are corrected or added.

## 3. Installed standard

Every Component page must use the approved five-card layout in this order:

1. Purpose.
2. Use cases.
3. Component contract.
4. Live examples.
5. Related components and patterns.

The five cards are the top-level contract. Do not rename, remove, reorder, or replace them with legacy headings such as `Reference Examples`, `Legacy Contract Summary`, or `Live Examples Card`.

Each page must prove the installed Component API for the app, not a generic design-system concept. The page must identify what is built, what is allowed, what is deferred or gated, what is prohibited, and which Foundation Elements the page consumes.

The installed page standard is:

- Preserve the five-card scaffold from the approved Accordion exemplar.
- Use app-owned rendered examples for implemented APIs.
- Use trigger-condition proof for deferred, gated, do-not-implement, or app-specific exception pages.
- Render supported variants visually inside the Live examples card.
- Render supported states visually or in a state matrix when the state is meaningful for the component.
- Name canonical Blade components, app CSS classes, native element contracts, JavaScript initializers, and source routes where they exist.
- Use token-backed code snippet styling for developer implementation examples.
- Link to concrete Component, Element, and Pattern UI Reference routes.
- Consume Foundation Element standards instead of creating local colors, spacing, typography, icon sourcing, motion timing, theme behavior, or grid behavior.
- Keep broad components out of forced tab-only layouts when matrices, scales, grids, state tables, grouped examples, or full-width demonstrations prove the API more accurately.

## 4. Required page shape

### 4.1. Purpose card

The Purpose card must state the component’s role in Login App 2.0 and the boundary of ownership.

Required content:

| Requirement               | Rule                                                                  |
| ------------------------- | --------------------------------------------------------------------- |
| Component purpose         | Define what the component does in the app.                            |
| Ownership boundary        | State what the component owns and what parent Patterns own.           |
| Installed/deferred signal | Make the implementation status visible without generic fallback copy. |
| Foundation dependency     | Name the primary Foundation Elements the component consumes.          |

### 4.2. Use cases card

The Use cases card must describe when to use and when not to use the component.

Required content:

| Requirement           | Rule                                                                                                                         |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Approved use cases    | List app-specific use cases that match the installed API.                                                                    |
| Selection guidance    | Explain how to choose this component instead of nearby components or Patterns.                                               |
| Non-use cases         | Name nearby alternatives such as Link, Menu buttons, Tabs, Form patterns, Modal, Data table, or Notification where relevant. |
| Deferred alternatives | For deferred pages, list approved alternatives developers should use today.                                                  |

### 4.3. Component contract card

The Component contract card must contain Anatomy and States in the first row, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.

Required contract sections:

| Section                    | Required content                                                                                                                                                                             |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Anatomy                    | Named structural parts, slots, native elements, item structure, option structure, icon placement, labels, helper text, or container regions.                                                 |
| States                     | Supported and non-applicable states, including default, hover, focus-visible, active/pressed, disabled, loading, validation, empty, selected, expanded, current, or overflow where relevant. |
| Behavior                   | Interaction rules, keyboard behavior, mouse/touch behavior, focus management, dismissal, loading, validation, selection, disclosure, and parent Pattern handoff.                             |
| Developer implementation   | Canonical Blade component, CSS namespace, native element contract, data attributes, JavaScript initializer, source files, and code snippets where known.                                     |
| Content guidance           | Label rules, helper/error text, truncation/wrapping, empty copy, destructive copy, accessible labels, and localization concerns.                                                             |
| Accessibility requirements | Semantics, ARIA ownership, keyboard support, focus-visible treatment, target size, reduced motion, color independence, and screen-reader naming.                                             |

The first row must make Anatomy and States immediately scannable. The remaining contract sections may stack, use cards, or use a responsive grid as long as the source order stays readable.

### 4.4. Live examples card

The Live examples card must render production proof for implemented APIs and explicit trigger-condition proof for deferred or gated APIs.

Allowed internal structures:

| Structure                 | Use for                                                                                                          |
| ------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Tabs                      | Scenario-driven components where each tab represents a usage scenario or mode.                                   |
| Matrices                  | Broad components with multiple variants, states, sizes, or semantic roles.                                       |
| Comparison grids          | Components that require side-by-side selection or hierarchy proof.                                               |
| State tables              | Components with meaningful interaction, validation, loading, selected, expanded, or disabled states.             |
| Size scales               | Components with a public size API.                                                                               |
| Grouped examples          | Components often used in clusters, toolbars, forms, page headers, table rows, or overlays.                       |
| Full-width demonstrations | Components whose behavior depends on page width, shell layout, table width, modal width, or responsive wrapping. |
| Internal subsections      | Components with several independent proof obligations that are clearer without tabs.                             |

Simple scenario-driven components may use tabs. Each tab must contain the applicable rendered variants and states for that scenario.

Broad components must not be forced into the Accordion tab model. Use matrices, grids, scales, and grouped examples when those structures better prove the API.

### 4.5. Related components and patterns card

The Related components and patterns card must link to concrete app routes.

Required link types:

| Link type           | Requirement                                                                  |
| ------------------- | ---------------------------------------------------------------------------- |
| Related components  | Link nearby Component pages by route.                                        |
| Related patterns    | Link consuming Pattern pages by route.                                       |
| Foundation Elements | Link consumed Element pages when the dependency affects implementation.      |
| Current doc         | Link the canonical Markdown doc when the UI Reference supports docs routing. |

Do not use vague copy such as `See also` without route-backed links.

## 5. Live example selection rules

Use the simplest structure that proves the component completely.

| Component type                        | Preferred proof model                                                                                       | Examples                                                                                                                |
| ------------------------------------- | ----------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Scenario-driven disclosure or overlay | Tabs with rendered scenario panels                                                                          | Accordion, Modal, Toggletip where scenarios are distinct and manageable.                                                |
| Broad action/control component        | Variant matrix, size scale, state matrix, and grouped examples                                              | Button, Link, Menu buttons, Checkbox, Radio button, Toggle.                                                             |
| Broad input component                 | Field matrix, validation matrix, helper/error content, disabled/read-only states, form composition examples | Text input, Textarea, Select, Dropdown, Number input, Date picker, File uploader, Search.                               |
| Feedback/loading component            | Status matrix, severity matrix, motion/loading proof, content rules                                         | Notification, Tag, Inline loading, Loading, Progress bar, Progress indicator.                                           |
| Data display component                | Full-width demos, empty/loading/error states, density/overflow proof, action composition                    | Data table, Pagination, Structured list, List, Code snippet, Tile.                                                      |
| Navigation/shell component            | Responsive/full-width examples, current state, overflow behavior, route ownership                           | Breadcrumb, Tabs, UI shell.                                                                                             |
| Deferred or gated component           | Trigger-condition cards, approved alternatives, queued owner/API boundary                                   | Multiselect, Content switcher, Popover, Slider, Tree view, Contained list, AI label unless later accepted as canonical. |

Variants must render visually where supported. They may appear inside a scenario, variant matrix, size scale, state matrix, comparison grid, or another clearly labeled live-example section. Do not add disconnected prose-only variant lists.

Every Live examples card must include a proof table in this shape:

| Required proof | Rendered behavior                                     | Variants/options shown                               |
| -------------- | ----------------------------------------------------- | ---------------------------------------------------- |
| Basic example  | The installed component renders with its default API. | Default variant, default state, and primary options. |

Broad component pages should extend the proof table with rows such as:

| Required proof           | Rendered behavior                                                                                                     | Variants/options shown                                                                                                       |
| ------------------------ | --------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Variant purpose matrix   | Supported variants render side by side with short purpose labels.                                                     | All installed semantic variants.                                                                                             |
| Size scale               | Supported sizes render in order with consistent labels.                                                               | All installed size options.                                                                                                  |
| State matrix             | States render using production component markup and token-backed state classes.                                       | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, expanded, or current as applicable.  |
| Group examples           | Common app compositions render in realistic parent contexts.                                                          | Form actions, toolbar actions, table row actions, page header actions, modal footer actions, or shell actions as applicable. |
| Icon usage               | Icon-bearing variants render with approved icon sourcing and accessible names.                                        | Leading/trailing/icon-only rules as supported.                                                                               |
| Content behavior         | Labels, helper text, wrapping, truncation, empty copy, and destructive copy render according to the content contract. | Normal, long, empty, destructive, localized, or RTL examples as applicable.                                                  |
| Developer implementation | Canonical calls render as token-backed code snippets.                                                                 | Blade API, props, slots, classes, data attributes, JavaScript initializer, and source route where known.                     |

## 6. Foundation Element dependency

Component pages must consume approved Foundation Element APIs.

| Foundation Element | Required Component page behavior                                                                                                               |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Color              | Use semantic token roles for surface, text, border, icon, state, status, disabled, danger, focus, and interactive treatment.                   |
| Spacing            | Use approved spacing tokens/classes for component internals, example layout, gaps, and responsive grouping.                                    |
| Typography         | Use approved type scale, weight, line-height, wrapping, truncation, and code-snippet typography.                                               |
| Icons              | Use approved icon sourcing where icons are supported; explicitly state `No icon API` when the component must not render icons.                 |
| Motion             | Use approved motion timing/easing for transitions, disclosure, loading, progress, overlay, and state changes. Respect reduced-motion behavior. |
| Themes             | Prove token-backed behavior in supported themes where the component appears on theme-sensitive surfaces.                                       |
| 2x Grid            | Use grid rules where layout, width, alignment, density, responsive behavior, shell placement, or page composition is relevant.                 |

Do not create local colors, raw hex values, arbitrary spacing, feature-local type scales, local icon sources, one-off animation timing, custom focus rings, custom theme behavior, or page-local grid systems inside a Component page or downstream Pattern.

## 7. Family coverage

The Component family includes the following pages. Individual pages must use their own canonical doc, status, owner route, and installed API details.

| Family               | Component pages                                                                                               |
| -------------------- | ------------------------------------------------------------------------------------------------------------- |
| Actions              | Button, Link, Menu, Menu buttons                                                                              |
| Inputs               | Text input, Textarea, Select, Dropdown, Multiselect, Number input, Date picker, File uploader, Search, Slider |
| Selection controls   | Checkbox, Radio button, Toggle, Content switcher                                                              |
| Feedback and loading | Notification, Tag, AI label, Inline loading, Loading, Progress bar, Progress indicator                        |
| Overlays and help    | Modal, Popover, Tooltip, Toggletip, Accordion                                                                 |
| Data display         | Data table, Pagination, Structured list, List, Contained list, Code snippet, Tile, Tree view                  |
| Navigation and shell | Breadcrumb, Tabs, UI shell                                                                                    |

Use these route conventions unless an accepted implementation item documents a different canonical slug:

| Component          | Route                                                  |
| ------------------ | ------------------------------------------------------ |
| Button             | `/platform/ui-reference/components/button`             |
| Link               | `/platform/ui-reference/components/link`               |
| Menu               | `/platform/ui-reference/components/menu`               |
| Menu buttons       | `/platform/ui-reference/components/menu-buttons`       |
| Text input         | `/platform/ui-reference/components/text-input`         |
| Textarea           | `/platform/ui-reference/components/textarea`           |
| Select             | `/platform/ui-reference/components/select`             |
| Dropdown           | `/platform/ui-reference/components/dropdown`           |
| Multiselect        | `/platform/ui-reference/components/multiselect`        |
| Number input       | `/platform/ui-reference/components/number-input`       |
| Date picker        | `/platform/ui-reference/components/date-picker`        |
| File uploader      | `/platform/ui-reference/components/file-uploader`      |
| Search             | `/platform/ui-reference/components/search`             |
| Slider             | `/platform/ui-reference/components/slider`             |
| Checkbox           | `/platform/ui-reference/components/checkbox`           |
| Radio button       | `/platform/ui-reference/components/radio-button`       |
| Toggle             | `/platform/ui-reference/components/toggle`             |
| Content switcher   | `/platform/ui-reference/components/content-switcher`   |
| Notification       | `/platform/ui-reference/components/notification`       |
| Tag                | `/platform/ui-reference/components/tag`                |
| AI label           | `/platform/ui-reference/components/ai-label`           |
| Inline loading     | `/platform/ui-reference/components/inline-loading`     |
| Loading            | `/platform/ui-reference/components/loading`            |
| Progress bar       | `/platform/ui-reference/components/progress-bar`       |
| Progress indicator | `/platform/ui-reference/components/progress-indicator` |
| Modal              | `/platform/ui-reference/components/modal`              |
| Popover            | `/platform/ui-reference/components/popover`            |
| Tooltip            | `/platform/ui-reference/components/tooltip`            |
| Toggletip          | `/platform/ui-reference/components/toggletip`          |
| Accordion          | `/platform/ui-reference/components/accordion`          |
| Data table         | `/platform/ui-reference/components/data-table`         |
| Pagination         | `/platform/ui-reference/components/pagination`         |
| Structured list    | `/platform/ui-reference/components/structured-list`    |
| List               | `/platform/ui-reference/components/list`               |
| Contained list     | `/platform/ui-reference/components/contained-list`     |
| Code snippet       | `/platform/ui-reference/components/code-snippet`       |
| Tile               | `/platform/ui-reference/components/tile`               |
| Tree view          | `/platform/ui-reference/components/tree-view`          |
| Breadcrumb         | `/platform/ui-reference/components/breadcrumb`         |
| Tabs               | `/platform/ui-reference/components/tabs`               |
| UI shell           | `/platform/ui-reference/components/ui-shell`           |

## 8. Deferred boundary

Deferred, gated, do-not-implement, and app-specific exception pages still use the full five-card scaffold. They must show explicit deferral proof rather than speculative complete UI.

Current deferred or gated components include:

| Component        | Default status    | Required page behavior                                                                                                                          |
| ---------------- | ----------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| Multiselect      | Deferred or gated | Show trigger conditions, approved alternatives, implementation owner route, and queued API boundary. Do not render a fake complete multiselect. |
| Content switcher | Deferred or gated | Show when Tabs, Toggle, or Pattern-owned navigation should be used instead. Do not render a speculative complete switcher.                      |
| Popover          | Deferred or gated | Show trigger conditions and nearby Tooltip/Toggletip/Modal alternatives. Do not fake overlay behavior.                                          |
| Slider           | Deferred or gated | Show approved field alternatives and required implementation gates. Do not render a speculative range control.                                  |
| Tree view        | Deferred or gated | Show hierarchy/navigation alternatives and data contract gates. Do not fake tree keyboard behavior.                                             |
| Contained list   | Deferred or gated | Show List, Structured list, Tile, or Data table alternatives as applicable. Do not render speculative contained-list behavior.                  |
| AI label         | Deferred or gated | Show trigger conditions, content policy, owner route, and approved labeling alternatives. Do not render speculative AI affordances.             |

A later accepted queue item may promote a deferred component to a canonical implementation. When that happens, update the component source, canonical Component API standard, UI Reference page, tests, and this deferred boundary if needed.

Deferred pages must include:

| Required proof        | Rendered behavior                                                                      | Variants/options shown                                                                                                     |
| --------------------- | -------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Deferral status       | A visible status panel explains that no production public API is approved.             | Deferred, gated, do-not-implement, or app-specific exception status.                                                       |
| Trigger conditions    | The page lists conditions required before implementation can begin.                    | Owner route, data/API requirement, accessibility requirement, visual proof requirement, test requirement.                  |
| Approved alternatives | Nearby installed components or Patterns render or link as the current production path. | Link, Button, Tabs, Toggle, Modal, Tooltip, Form patterns, Data table, List, or other approved alternatives as applicable. |
| Queued API boundary   | The page names the proposed boundary without fake props or fake behavior.              | Pending Blade/API owner, pending source file, pending data contract, pending tests.                                        |

## 9. Developer implementation

Developer implementation sections must show the installed API directly.

| Implementation type              | Required proof                                                                                           |
| -------------------------------- | -------------------------------------------------------------------------------------------------------- |
| Canonical Blade component exists | Name the Blade component and show a minimal production call.                                             |
| Multiple Blade APIs exist        | Name each API and the use case boundary for each.                                                        |
| Native element contract exists   | Name the native element, required attributes, allowed classes, and state behavior.                       |
| App CSS class contract exists    | Name app-owned `ui-*` classes and clarify which classes are public.                                      |
| JavaScript controller exists     | Name the controller/initializer, required data attributes, lifecycle rules, and focus/cleanup ownership. |
| No JavaScript required           | State that no dedicated JavaScript API is required for baseline behavior.                                |
| Deferred component               | State that no production public API is approved and do not show fake calls.                              |

Use token-backed code snippet styling. Do not use unstyled local `<pre>` blocks or one-off code display markup in the rendered UI Reference page.

Example implementation proof shape:

```blade
<x-ui.code-snippet language="blade">
    &lt;x-ui.component-name variant="default"&gt;
        Example content
    &lt;/x-ui.component-name&gt;
</x-ui.code-snippet>
```

The exact code snippet API must match the installed Code snippet Component standard. If the installed API differs from the example shape above, use the installed API and correct this standard.

## 10. Review rule

Implemented Component pages must not render generic fallback text.

Prohibited placeholder copy includes:

- `family-depth implementation pending`
- `Component-specific API pending correction`
- `Use only documented props/options`
- `See UI Reference developer implementation section`
- `Allowed variants: None` when variants, options, modes, sizes, modifiers, or states exist
- `Live Examples Card` when used as a stale card label instead of approved UI copy
- `Reference Examples`
- `Legacy Contract Summary`
- `Generic fallback`
- `TODO`

Queued, deferred, do-not-implement, and app-specific exception pages may render trigger-condition content, but it must be explicit, reviewable, and scoped to the component. They must not render speculative complete controls or fake production props.

## 11. Prohibited usage

- Do not bypass this page standard for Component family-depth pages.
- Do not remove or reorder the five top-level cards.
- Do not force broad components into tab-only examples when matrices, scales, grids, state tables, grouped examples, or full-width demonstrations are more accurate.
- Do not render prose-only variant lists for supported variants.
- Do not render Carbon production class names such as `cds--*` or `bx--*` as app implementation classes.
- Do not create local colors, raw hex values, local spacing, feature-local typography, custom focus rings, one-off icon sources, or one-off JavaScript.
- Do not create `tier-1` or `tier-2` component doc paths.
- Do not use tier language except for priority, hierarchy explanation, historical queue context, or migration notes.
- Do not update unrelated Component, Element, or Pattern pages as part of a single page correction.
- Do not mark deferred or gated APIs as implemented unless a later accepted queue item creates and proves the canonical implementation.
- Do not use generic family-depth fallback content for implemented components.

## 12. UI Reference requirements

Every Component UI Reference page must render the five top-level cards and must prove the component according to its status.

| Required proof           | Rendered behavior                                                                                                                  | Variants/options shown                                                                               |
| ------------------------ | ---------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------- |
| Five-card scaffold       | Purpose, Use cases, Component contract, Live examples, and Related components and patterns render in order.                        | All Component pages.                                                                                 |
| Component contract       | Anatomy and States render first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements. | Installed, deferred, gated, and exception pages.                                                     |
| Foundation Elements      | The page names consumed Foundation Elements and uses token-backed examples.                                                        | Color, Spacing, Typography, Icons, Motion, Themes, 2x Grid where relevant.                           |
| Installed API proof      | Implemented pages render production examples, source-owned markup, and token-backed states.                                        | Installed variants, options, sizes, modes, states, and modifiers.                                    |
| Broad component proof    | Broad pages use matrices, grids, scales, state tables, grouped examples, or full-width sections as needed.                         | Variants, states, sizes, groups, icon usage, content behavior, developer implementation.             |
| Scenario component proof | Scenario-driven pages may use tabs where each tab is a real usage scenario.                                                        | Scenario variants and states inside each tab.                                                        |
| Deferred proof           | Deferred/gated pages render trigger conditions, approved alternatives, owner route, and queued API boundary.                       | Deferred, gated, do-not-implement, and app-specific exception status.                                |
| Related links            | The final card links to concrete Component, Pattern, and Element routes.                                                           | Route-backed links only.                                                                             |
| Prohibited usage         | The page lists relevant prohibited implementation patterns.                                                                        | Local colors, local spacing, fake APIs, direct Carbon classes, speculative UI, generic placeholders. |

## 13. Testing and acceptance criteria

For each Component page under this standard:

- `/platform/ui-reference/components/{slug}` returns 200 for authorized users.
- The page is admin-only according to the platform’s existing authorization policy.
- The page shows installed API, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Implemented APIs render production examples.
- Deferred APIs render trigger conditions instead of fake controls.
- Purpose, Use cases, Component contract, Live examples, and Related components and patterns render in that top-level order.
- Anatomy and States render before Behavior, Developer implementation, Content guidance, and Accessibility requirements inside the Component contract card.
- Variants render visually wherever the installed component supports visual variants.
- Broad component pages can use matrices, scales, comparison grids, grouped examples, full-width demonstrations, and state tables.
- Scenario-driven pages can use tabs when each tab represents a real usage scenario.
- Developer implementation examples use token-backed code snippet styling.
- Related APIs use concrete app UI Reference routes.
- No generic placeholder content appears.
- No direct Carbon production classes are presented as app implementation classes.
- No raw hex colors, arbitrary local spacing, feature-local typography, local icon sources, custom focus rings, or one-off JavaScript are presented as approved implementation.

Regression checks must assert absence of stale or prohibited strings where applicable:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/{slug}');

$response->assertOk();
$response->assertSee('Purpose');
$response->assertSee('Use cases');
$response->assertSee('Component contract');
$response->assertSee('Live examples');
$response->assertSee('Related components and patterns');
$response->assertSee('Anatomy');
$response->assertSee('States');
$response->assertSee('Behavior');
$response->assertSee('Developer implementation');
$response->assertSee('Content guidance');
$response->assertSee('Accessibility requirements');
$response->assertDontSee('family-depth implementation pending');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('btn btn-primary');
```

For broad component pages, add page-specific assertions for the rendered matrices, scales, states, groups, icon usage, content behavior, and developer implementation examples required by that component’s canonical standard.

For deferred or gated component pages, add assertions that the page shows `Deferred`, `Gated`, `Trigger conditions`, `Approved alternatives`, and `Queued API boundary`, and does not show fake production Blade calls.

## 14. Related APIs

| API                           | Route                                               |
| ----------------------------- | --------------------------------------------------- |
| Components overview           | `/platform/ui-reference/components`                 |
| Button                        | `/platform/ui-reference/components/button`          |
| Link                          | `/platform/ui-reference/components/link`            |
| Menu buttons                  | `/platform/ui-reference/components/menu-buttons`    |
| Accordion                     | `/platform/ui-reference/components/accordion`       |
| Modal                         | `/platform/ui-reference/components/modal`           |
| Tooltip                       | `/platform/ui-reference/components/tooltip`         |
| Data table                    | `/platform/ui-reference/components/data-table`      |
| Tabs                          | `/platform/ui-reference/components/tabs`            |
| Code snippet                  | `/platform/ui-reference/components/code-snippet`    |
| Color element                 | `/platform/ui-reference/elements/color`             |
| Spacing element               | `/platform/ui-reference/elements/spacing`           |
| Typography element            | `/platform/ui-reference/elements/typography`        |
| Icons element                 | `/platform/ui-reference/elements/icons`             |
| Motion element                | `/platform/ui-reference/elements/motion`            |
| Themes element                | `/platform/ui-reference/elements/themes`            |
| 2x Grid element               | `/platform/ui-reference/elements/2x-grid`           |
| Forms pattern                 | `/platform/ui-reference/patterns/forms`             |
| Tables Pattern                | `/platform/ui-reference/patterns/tables`            |
| Overlay and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback` |
| Layout Pattern                | `/platform/ui-reference/patterns/layout`            |

## 15. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Component-specific Carbon pages may be used as completeness benchmarks when updating an individual Component API standard. Login App keeps its own Blade APIs, app-owned `ui-*` class contracts, token model, Heroicons icon source, route ownership, and UI Reference proof requirements.