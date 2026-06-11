---
title: Boundary and validation
slug: boundary-and-validation
api_layer: Pattern API
status: implemented-standard
system_maturity: governance-standard
category: pattern-governance
priority: baseline-pattern-governance
ui_reference_route: /platform/ui-reference/patterns
canonical_doc: docs/02-standards/ui/patterns/boundary-and-validation.md
source_owner: /platform/ui-reference/patterns
pattern_api:
  - boundary-decision-checklist
  - primitive-consumption-rule
  - pattern-owned-validation-placement
  - feature-owned-business-validation-handoff
  - deferred-capability-review
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
  - 2x-grid
related_components:
  - button
  - text-input
  - select
  - checkbox
  - radio-button
  - toggle
  - notification
  - loading
  - inline-loading
  - tag
  - breadcrumb
  - ui-shell
related_patterns:
  - forms
  - navigation
  - page-header
  - table-toolbar
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/patterns/overview/
  - https://carbondesignsystem.com/patterns/forms-pattern/
  - https://carbondesignsystem.com/elements/2x-grid/usage/
---

# Boundary and validation Pattern API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. API surfaces](#41-api-surfaces)
  - [4.2. Boundary decision checklist](#42-boundary-decision-checklist)
  - [4.3. Primitive consumption rule](#43-primitive-consumption-rule)
  - [4.4. Pattern-owned validation placement](#44-pattern-owned-validation-placement)
  - [4.5. Feature-owned business validation handoff](#45-feature-owned-business-validation-handoff)
- [5. Required composition](#5-required-composition)
- [6. Optional composition](#6-optional-composition)
- [7. Consumed Element APIs](#7-consumed-element-apis)
- [8. Owned Component APIs](#8-owned-component-apis)
- [9. Allowed variants and layout options](#9-allowed-variants-and-layout-options)
- [10. State ownership](#10-state-ownership)
- [11. Responsive behavior](#11-responsive-behavior)
- [12. Composition rules](#12-composition-rules)
- [13. Selection guidance](#13-selection-guidance)
- [14. Accessibility contract](#14-accessibility-contract)
- [15. Content contract](#15-content-contract)
- [16. Prohibited usage](#16-prohibited-usage)
- [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
- [Implementation and UI Reference Checklist](#implementation-and-ui-reference-checklist)
  - [Implementation checklist](#implementation-checklist)
  - [UI Reference proof checklist](#ui-reference-proof-checklist)
- [19. UI Reference requirements](#19-ui-reference-requirements)
- [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
- [21. Related APIs](#21-related-apis)
- [22. References](#22-references)

## 1. API summary

Boundary and validation defines how reusable Patterns consume Foundation Elements and Components without redefining them, and how validation responsibilities are split between Patterns, Components, and feature modules.

Canonical API owner: `/platform/ui-reference/patterns`. Use this Pattern API whenever a UI surface needs to decide whether behavior belongs to a Foundation Element, Component, Pattern, or feature module.

Patterns are reusable solutions for user goals. They combine installed Foundation Element and Component APIs into layout, state-placement, orchestration, and workflow-adjacent compositions. They do not redefine primitive visual decisions, component internals, or feature-specific business rules.

Canonical API responsibilities:

- Define the boundary decision checklist used before adding markup, classes, JavaScript, validation placement, or reusable layout behavior.
- Require Patterns to consume Foundation Element APIs for visual primitives.
- Require Patterns to consume Component APIs for fields, controls, feedback, navigation primitives, and local interactive states.
- Define Pattern-owned validation placement such as form summaries, blocked states, empty states, unavailable states, and escalation paths.
- Define feature-owned validation handoff for business rules, permissions, server validation, persistence, and workflow-specific branching.
- Define how deferred or gated capabilities are recorded without fake examples.
- Prevent local one-off markup from filling missing Component or Pattern API gaps.
- Prove boundary review, validation placement review, and deferred capability review on the Pattern UI Reference route.

Non-owned responsibilities:

- Token names, raw values, theme resolution, icon inventories, motion timing, or grid primitives. Use Foundation Element APIs.
- Component props, slots, internal classes, local states, accessibility semantics, icons, field internals, button internals, and feedback internals. Use Component APIs.
- Product-specific business validation, authorization, data loading, persistence, service rules, and conditional workflow decisions. Use feature modules.
- Broad library-wide corrections from a single Pattern update.

Carbon alignment note: Carbon describes Patterns as reusable best-practice solutions for how a user achieves a goal, built from components and templates that address common objectives through sequences and flows. Login App maps that principle to a three-layer API boundary: Foundation Elements own primitives, Components own reusable controls and local states, Patterns own composition and state placement, and feature modules own product-specific behavior.

## 2. Status and ownership

| Field                        | Value                                                                    |
| ---------------------------- | ------------------------------------------------------------------------ |
| Status                       | Implemented standard                                                     |
| System maturity              | Governance standard                                                      |
| API layer                    | Pattern API                                                              |
| Pattern slug                 | boundary-and-validation                                                  |
| Category                     | Pattern governance                                                       |
| Priority                     | Baseline pattern governance                                              |
| Owner route                  | `/platform/ui-reference/patterns`                                        |
| Canonical path               | `docs/02-standards/ui/patterns/boundary-and-validation.md`               |
| UI Reference proof           | `/platform/ui-reference/patterns`                                        |
| Source owner                 | `/platform/ui-reference/patterns`                                        |
| Blade API                    | None; this standard governs Pattern composition and ownership decisions  |
| JavaScript API               | None; Pattern-specific behavior must be documented by the owning Pattern |
| Data attributes              | None approved by this governance standard                                |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid               |
| Carbon benchmark             | Carbon Patterns overview and relevant pattern guidance                   |

`Implemented standard` means this governance contract is active for all Login App 2.0 Pattern standards and UI Reference Pattern examples.

`Governance standard` means this document is not a visual component or a one-off page layout. It defines how Pattern API ownership is decided and how reusable Pattern examples must prove they are consuming approved APIs correctly.

## 3. Installed standard

Use this pattern contract whenever a UI surface needs to decide whether behavior belongs to an Element, Component, Pattern, or feature module.

The installed standard is:

- Patterns compose approved Foundation Element APIs and Component APIs.
- Patterns own grouping, external spacing, state placement, responsive behavior, orchestration, and workflow-adjacent composition.
- Components own local component semantics, props, slots, states, icons, internal spacing, field associations, and accessibility behavior.
- Foundation Elements own visual primitives such as color, spacing, typography, themes, icons, motion, and 2x Grid.
- Feature modules own business rules, permissions, server validation, data loading, persistence, workflow-specific branching, and route-specific decisions.
- Pattern validation placement must show where summaries, blocked states, unavailable states, empty states, field groups, and recovery actions appear.
- Business validation rules must be handed to feature code and server validation instead of being encoded in UI standards.
- Missing reusable behavior must be recorded as deferred or gated instead of patched with local markup, local CSS, local JavaScript, or fake examples.
- UI Reference Pattern examples must render concrete compositions that consume app-owned tokens, classes, helpers, and Blade components where available.

Installed review modes:

| Review mode                  | Status      | Use                                                                                                      |
| ---------------------------- | ----------- | -------------------------------------------------------------------------------------------------------- |
| Boundary review              | Implemented | Decide whether the behavior belongs to an Element, Component, Pattern, or feature module.                |
| Primitive consumption review | Implemented | Verify the Pattern consumes Element and Component APIs rather than redefining primitives.                |
| Validation placement review  | Implemented | Decide where validation, status, blocked, empty, unavailable, and recovery UI appears.                   |
| Business validation handoff  | Implemented | Keep feature-specific rules in the feature/server layer while letting the Pattern place the UI response. |
| Deferred capability review   | Implemented | Record missing reusable capability as gated with trigger conditions.                                     |
| UI Reference proof review    | Implemented | Ensure rendered examples prove real installed compositions and do not present fake controls.             |

## 4. Pattern API

This standard exposes governance checklists and composition contracts, not a Blade component.

### 4.1. API surfaces

| API surface                               | Installed value                                             | Rule                                                                                                        |
| ----------------------------------------- | ----------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Boundary decision checklist               | Implemented                                                 | Use before creating or updating a Pattern, Component, Element, or feature-local behavior.                   |
| Primitive consumption rule                | Implemented                                                 | Patterns consume Element and Component APIs; they do not redefine them.                                     |
| Pattern-owned validation placement        | Implemented                                                 | Patterns decide where cross-component validation and recovery UI is placed.                                 |
| Feature-owned business validation handoff | Implemented                                                 | Feature code owns rule truth, server validation, permissions, persistence, and data decisions.              |
| Deferred capability review                | Implemented                                                 | Missing reusable behavior is documented as deferred/gated with triggers and approved alternatives.          |
| Blade API                                 | None                                                        | Do not create a helper for this governance standard. Pattern-specific helpers belong in the owning Pattern. |
| JavaScript API                            | None                                                        | Behavior APIs belong to the owning Pattern or Component.                                                    |
| Data attributes                           | None                                                        | Data attributes must be documented by the owning Pattern or Component before use.                           |
| CSS namespace                             | Pattern-owned only where documented by the specific Pattern | This governance standard does not install a shared visual class namespace.                                  |

### 4.2. Boundary decision checklist

Use this checklist before adding reusable UI code or documentation.

| Question                                                                                                      | If yes                                                                    | If no                                                     |
| ------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------- | --------------------------------------------------------- |
| Is the need a raw visual primitive such as color, spacing, typography, icon, motion, grid, or theme behavior? | Use or update the Foundation Element API.                                 | Continue review.                                          |
| Is one reusable primitive control enough to solve the UI role?                                                | Use or update the Component API.                                          | Continue review.                                          |
| Do multiple Components need shared layout, grouping, state placement, or workflow-adjacent behavior?          | Use or update a Pattern API.                                              | Continue review.                                          |
| Does the behavior depend on product-specific rules, permissions, data, or persistence?                        | Keep it in the feature module and let the Pattern place the UI response.  | Continue review.                                          |
| Is the same composition needed in more than one concrete app context?                                         | Document or update a Pattern API.                                         | Keep it feature-owned unless it is likely to repeat soon. |
| Does a missing Component API force local one-off markup?                                                      | Mark the Component capability gated or add a scoped Component correction. | Use the installed Component.                              |
| Does a missing Pattern force repeated layout/orchestration code?                                              | Mark the Pattern capability gated or add a scoped Pattern correction.     | Use the installed Pattern.                                |
| Would the change redefine tokens, internal Component classes, or child semantics?                             | Stop and use the owning Element or Component API.                         | Continue review.                                          |

### 4.3. Primitive consumption rule

Patterns must consume primitives through their owning APIs.

| Primitive need                                                              | Owning API                                | Pattern rule                                                                               |
| --------------------------------------------------------------------------- | ----------------------------------------- | ------------------------------------------------------------------------------------------ |
| Surface, text, border, status, focus, action, or overlay color              | Color Element + Themes Element            | Use token-backed classes, variables, or child Component APIs. Do not hard-code colors.     |
| Gaps, padding, density, and repeated local relationships                    | Spacing Element                           | Use approved spacing roles or Pattern-owned wrappers. Do not use arbitrary spacing.        |
| Page, shell, dashboard, side-panel, modal, or responsive region geometry    | 2x Grid Element + owning Pattern          | Use grid-aware wrappers or Pattern APIs. Do not create local row/column systems.           |
| Headings, labels, helper text, body copy, code, or status copy              | Typography Element + Component APIs       | Use approved type roles. Do not redefine type sizes locally.                               |
| Status, affordance, navigation, or action icons                             | Icons Element + Component APIs            | Use approved icon inventory and accessible treatment. Do not introduce local icon sources. |
| Hover, focus, disclosure, loading, overlay, or responsive transition motion | Motion Element + owning Component/Pattern | Use token-backed motion and reduced-motion rules. Do not create feature-local animation.   |
| Light, dark, inverse, layered, or nested contexts                           | Themes Element + owning Pattern           | Use theme wrappers/tokens only where approved. Do not create local theme overrides.        |

### 4.4. Pattern-owned validation placement

Patterns own where validation and recovery surfaces appear across multiple Components. They do not own the business rule that determines whether a value is valid.

| Validation surface            | Pattern responsibility                                                                      | Component responsibility                                                                            | Feature responsibility                                                |
| ----------------------------- | ------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------- |
| Field-level error             | Place fields within the form layout and preserve room for messages.                         | Render field state, label association, `aria-describedby`, `aria-invalid`, and local error styling. | Provide server validation message and invalid value.                  |
| Form-level validation summary | Decide if and where summary appears, how it links to affected fields, and how it escalates. | Render fields and local states.                                                                     | Provide error bag/rule truth and field IDs/names.                     |
| Blocked state                 | Place blocked content, reason, and recovery action within the workflow.                     | Render Notification, Button, Tag, or other primitives.                                              | Determine permission/business reason and recovery route.              |
| Empty state                   | Place empty-state content, affordance, and optional action.                                 | Render Button, Link, Illustration/Icon if installed, and text roles.                                | Determine whether content is truly empty and which action is allowed. |
| Unavailable state             | Place unavailable explanation and fallback action.                                          | Render local Components.                                                                            | Determine availability, permissions, and alternative path.            |
| Warning/advisory state        | Place warning near the affected group or action.                                            | Render field, Notification, Tag, or Tooltip state.                                                  | Determine warning condition and allowed continuation.                 |
| Async/load failure            | Place retry/cancel/status escalation.                                                       | Render Loading, Inline loading, Button, Notification.                                               | Determine fetch state, retry endpoint, and persistence behavior.      |

### 4.5. Feature-owned business validation handoff

Feature modules own these decisions and must hand the resulting messages/states to the Pattern:

- Required rules beyond simple UI conventions.
- Unique constraints, account rules, role rules, quotas, permission failures, plan limits, and policy restrictions.
- Server-side validation and normalized submitted values.
- Authorization and visibility of actions or navigation.
- Data loading, empty results, failed requests, and retry behavior.
- Persistence success/failure and route-level redirects.
- Workflow-specific branching such as review states, approval states, and conditional fields.

Patterns may define how those states are displayed, ordered, escalated, and linked back to Components. Patterns must not encode feature-specific policy text or validation truth.

## 5. Required composition

Patterns must compose the installed UI API layers in this order.

| Composition layer   | Required consumption                                                                                         | Pattern rule                                                                                  |
| ------------------- | ------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------- |
| Foundation Elements | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid where applicable                                  | Use Element APIs for visual primitives and theme/responsive behavior.                         |
| Components          | Fields, controls, feedback, loading, navigation, tags, table primitives, overlays where installed            | Use public Component APIs and documented props/classes only.                                  |
| Patterns            | Grouping, orchestration, validation placement, responsive layout, action placement, shell/page relationships | Use the owning Pattern for repeated compositions. Update or gate missing Patterns.            |
| Feature modules     | Business rules, permissions, data, persistence, route decisions                                              | Keep product-specific logic out of standards; pass display-ready states/messages to Patterns. |

Pattern examples must show the consumed APIs explicitly enough that a developer can identify the ownership boundary without reading source code.

## 6. Optional composition

| Optional composition   | Status  | Rule                                                                                                    |
| ---------------------- | ------- | ------------------------------------------------------------------------------------------------------- |
| Queue item references  | Allowed | Use when a requested behavior is known but gated. Include trigger conditions and approved alternatives. |
| Feature links          | Allowed | Link to consuming workflows when a Pattern is proven by a concrete app use case.                        |
| Example route links    | Allowed | Use UI Reference or app route references when examples require context.                                 |
| Implementation notes   | Allowed | Keep notes scoped to the Pattern and avoid library-wide TODOs.                                          |
| Migration notes        | Allowed | Use only when replacing legacy local markup with an installed Pattern API.                              |
| Carbon benchmark notes | Allowed | Use as completeness guidance only; do not install Carbon classes or variants directly.                  |

## 7. Consumed Element APIs

Patterns consume Foundation Element APIs by role. They must not re-specify raw token values.

| Element API | Consumed by Patterns for                                                                                                          | Must not do                                                                       |
| ----------- | --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| Color       | Surfaces, text, status, focus, borders, dividers, overlays, disabled states, and validation/state placement.                      | Hard-code hex/rgb values, local semantic palettes, or Pattern-only status colors. |
| Spacing     | Cross-component gaps, section spacing, action placement, validation-summary spacing, group density, and responsive stacking gaps. | Patch child Component internal spacing or create arbitrary one-off margins.       |
| Typography  | Pattern headings, descriptions, helper text, validation summaries, empty/blocked copy, and action group labels.                   | Create local type scales or override child Component text roles.                  |
| Themes      | Light, dark, layered, inverse, nested, and high-contrast contexts where the Pattern owns the surface.                             | Create feature-local theme wrappers or raw alternate values.                      |
| Icons       | Status summaries, empty/blocked states, disclosure affordances, action groups, and table/filter helpers where installed.          | Introduce local icon files, icon libraries, or unlabeled icon-only actions.       |
| Motion      | Disclosure, overlay, loading escalation, responsive reveal/collapse, and state transition behavior.                               | Create feature-local keyframes, delayed focus, or motion-only meaning.            |
| 2x Grid     | Page/shell geometry, dashboard regions, side panels, forms, tables, and responsive layout zones.                                  | Use Bootstrap rows, arbitrary widths, or local grid systems.                      |

## 8. Owned Component APIs

Patterns do not own Component internals. They may own cross-component composition involving Components.

| Component role             | Pattern may own                                                                                               | Component still owns                                                                                   |
| -------------------------- | ------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------ |
| Form fields                | Field order, grouping, layout, summary placement, required/optional convention, and validation recovery path. | Field markup, labels, helper/error associations, local states, internal spacing, and native semantics. |
| Buttons and icon buttons   | Action order, grouping, alignment, escalation, sticky/fixed placement when approved, and workflow ownership.  | Button variants, sizes, disabled/loading state, icon rules, accessible labels, and internal spacing.   |
| Notifications and feedback | Placement, escalation priority, persistence rules, and relationship to affected region.                       | Notification variants, icons, title/body/action slots, dismissal behavior if installed.                |
| Loading and inline loading | Where pending states appear, whether region or action loading is needed, and retry/escalation placement.      | Spinner/skeleton/inline loading visuals, status text structure, reduced-motion behavior.               |
| Tags/badges                | Grouping, wrapping, active filter removal, table/card placement, and overflow behavior.                       | Status values, icon treatment, removable control internals, label rules.                               |
| Navigation components      | Shell/page relationship, current route mapping, responsive movement, and placement.                           | Link/Button/Menu APIs, current-state internals, focus styling, disclosure semantics.                   |
| Data table components      | Toolbar placement, filter/search relationship, empty/blocked states, and row action grouping.                 | Table semantics, cell/header states, sorting/pagination controls where installed.                      |
| Overlay components         | Trigger placement, escalation path, relationship to page content, and workflow copy.                          | Modal/panel/popover internal focus trap, backdrop, dismissal, and component states.                    |

## 9. Allowed variants and layout options

| Name                                          | Type               | Status                                   | API                                       | Notes                                                                                         |
| --------------------------------------------- | ------------------ | ---------------------------------------- | ----------------------------------------- | --------------------------------------------------------------------------------------------- |
| Boundary review                               | Review mode        | Implemented                              | Pattern governance checklist              | Use before installing or changing UI behavior.                                                |
| Validation placement review                   | Review mode        | Implemented                              | Pattern validation table                  | Use when a field/group/page can show errors, warnings, blocked, empty, or unavailable states. |
| Primitive consumption review                  | Review mode        | Implemented                              | Element/Component consumption matrix      | Use to prevent Pattern-local primitives.                                                      |
| Feature handoff review                        | Review mode        | Implemented                              | Feature-owned business validation handoff | Use to keep rule truth outside UI standards.                                                  |
| Deferred capability review                    | Review mode        | Implemented                              | Gated disposition rows                    | Use when a missing reusable behavior is requested.                                            |
| UI Reference proof review                     | Review mode        | Implemented                              | Rendered examples and route tests         | Use to ensure examples are concrete and not abstract notes only.                              |
| Pattern-owned responsive layout               | Layout option      | Implemented where Pattern-specific       | Owning Pattern classes/wrappers           | Must consume 2x Grid and Spacing APIs.                                                        |
| Pattern-owned validation summary              | Composition option | Implemented where Pattern-specific       | Forms/feedback Pattern                    | Must link to or identify affected fields.                                                     |
| Pattern-owned blocked/empty/unavailable state | Composition option | Implemented where Pattern-specific       | Owning Pattern + Components               | Must distinguish UI placement from feature rule truth.                                        |
| Pattern-owned overlay/escalation              | Composition option | Gated unless installed by owning Pattern | Overlay/feedback Pattern                  | Requires focus, dismissal, and reduced-motion proof.                                          |
| Pattern-local primitive                       | Prohibited         | None                                     | Not allowed                               | Use Element or Component owner instead.                                                       |

## 10. State ownership

Patterns own cross-component state placement and escalation. Components own local visual states and semantic attributes.

| State               | Element owner                    | Component owner                                          | Pattern owner                                   | Feature owner                                    |
| ------------------- | -------------------------------- | -------------------------------------------------------- | ----------------------------------------------- | ------------------------------------------------ |
| Default             | Tokens and base roles            | Local default rendering                                  | Composition and placement                       | Data/content values                              |
| Hover/focus/active  | Color/Motion/Theme roles         | Local interactive state                                  | Focus order across composed controls            | None unless business behavior changes            |
| Disabled            | Color/theme roles                | Native disabled semantics and styling                    | Placement/explanation of disabled group/region  | Permission/availability truth                    |
| Loading             | Motion/theme/loading tokens      | Loading/Inline loading/Button loading APIs               | Where loading appears and how it escalates      | Fetch/save/process state                         |
| Error               | Status color/type/icon roles     | Field/Notification local error state                     | Summary placement and affected-region recovery  | Rule truth and message content                   |
| Warning             | Status roles                     | Field/Notification/Tag warning state                     | Warning placement and continuation rules        | Warning condition and allowed continuation       |
| Success             | Status roles                     | Notification/Tag/Button completion state where installed | Post-action placement or redirect cue           | Persistence truth                                |
| Empty               | Typography/spacing/surface roles | Child components used inside the state                   | Empty-state layout and action placement         | Whether the dataset is empty and allowed actions |
| Blocked/unavailable | Status/surface roles             | Child components used inside the state                   | Placement and recovery/escalation path          | Permission, policy, or availability condition    |
| Current/selected    | Color/theme roles                | Component current/selected states                        | Cross-navigation placement and consistency      | Current route/filter/value                       |
| Overflow            | Grid/spacing/theme roles         | Component-local truncation/overflow                      | Group wrapping, collapse, scroll, or disclosure | Data length and route constraints                |

State rules:

- Patterns may define when to escalate from field-level to group-level to page-level feedback.
- Patterns may define how cross-component state is placed, ordered, and announced.
- Patterns must not invent child Component state classes.
- Patterns must not hide state truth inside CSS or client-only behavior when server validation owns the rule.

## 11. Responsive behavior

Patterns define how composed components stack, collapse, scroll, or remain fixed across supported breakpoints.

Responsive Pattern rules:

- Use 2x Grid for page, shell, panel, and major region geometry.
- Use Spacing for cross-component gaps and stacking relationships.
- Use Component APIs for child dimensions, density, and internal states.
- Preserve focus order when layout changes.
- Preserve validation-summary and affected-field relationships across breakpoints.
- Avoid horizontal scrolling unless the owning Pattern explicitly supports it.
- Do not use local breakpoint patches in feature views.
- Do not let a child Component’s internal layout dictate page-level behavior.

| Responsive behavior | Pattern owns                                                      | Must prove                                                           |
| ------------------- | ----------------------------------------------------------------- | -------------------------------------------------------------------- |
| Stack               | Order, spacing, and grouping when layout becomes single-column.   | Reading order, focus order, label/message association.               |
| Collapse            | Trigger, label, state, controlled region, and dismissal behavior. | `aria-expanded`, `aria-controls`, keyboard behavior, reduced motion. |
| Scroll              | Scroll container selection and relationship to shell/page.        | Focus visibility, sticky/fixed regions, no clipped controls.         |
| Fixed/sticky        | Placement and overlap rules.                                      | Zoom behavior, reduced motion, mobile behavior, no covered content.  |
| Overflow/disclosure | What moves into overflow and how it remains reachable.            | Accessible trigger, menu/panel behavior, focus return.               |
| Region loading      | Where pending content appears and how it preserves layout.        | Loading status, skeleton dimensions, reduced layout shift.           |

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, responsive composition, cross-component state placement, and reusable workflow-adjacent behavior.
- Child Components own public APIs, local states, accessibility semantics, internal spacing, icons, and local interaction behavior.
- Foundation Elements own token values, CSS variables, primitive helpers, icon inventory, theme behavior, motion behavior, and grid geometry.
- Feature modules own business rules, permissions, data loading, persistence, and workflow-specific branching.
- Pattern examples must use installed Components and Elements wherever they exist.
- Pattern examples must not patch child Component internals with local classes or utility clusters.
- Pattern examples must not use raw colors, arbitrary spacing, local icons, Bootstrap utilities, direct Carbon classes, or feature-local JavaScript.
- Pattern validation examples must separate rule truth from UI placement.
- Pattern docs must explicitly mark missing reusable behavior as deferred or gated.
- Deferred capabilities must show trigger conditions and approved alternatives instead of fake production controls.
- New reusable orchestration belongs in a Pattern doc only after at least one concrete app use case exists.
- If a requested behavior is one-off and product-specific, keep it in the feature module and document only the consumed Pattern/Component APIs.
- If a requested behavior appears across multiple product areas, create or update the appropriate Pattern standard.

## 13. Selection guidance

Use a Foundation Element when:

- The problem is a primitive visual or system rule: color, spacing, typography, theme, icon, motion, or grid.
- Multiple Components or Patterns need the same primitive rule.
- A local view tries to create raw values for a primitive already owned by an Element API.

Use a Component when:

- One reusable control, field, feedback primitive, navigation item, or display primitive solves the UI problem.
- The behavior is local to the primitive and can be expressed as props, slots, states, or documented classes.
- The needed state is local, such as field error, button loading, tag status, or notification variant.

Use a Pattern when:

- Multiple Components need shared layout, grouping, external spacing, state placement, or workflow-adjacent behavior.
- A form, table toolbar, navigation shell, overlay, dashboard, page header, or settings layout repeats across the app.
- Validation summaries, blocked states, empty states, unavailable states, or recovery actions need reusable placement.
- Responsive behavior affects a group of Components rather than one primitive.

Use a feature module when:

- The behavior depends on business rules, permissions, product data, account state, plan limits, or persistence.
- The workflow-specific branch is unlikely to repeat outside the feature.
- The UI display can consume existing Pattern/Component APIs without adding reusable behavior.

Boundary examples:

| Need                                                           | Correct owner                                                | Not correct                                   |
| -------------------------------------------------------------- | ------------------------------------------------------------ | --------------------------------------------- |
| Add error text under a text input                              | Text input Component + server validation                     | Pattern-local field error markup              |
| Place a summary above a form and link to invalid fields        | Forms Pattern                                                | Text input Component                          |
| Decide that a user cannot delete a tenant                      | Feature module/server authorization                          | Button or Pattern standard                    |
| Display a disabled delete action with explanation              | Feature module truth + Button/Notification/Pattern placement | Button CSS override                           |
| Arrange filters, search, active filter tags, and table actions | Table toolbar Pattern                                        | Feature-local utility rows                    |
| Define focus ring color                                        | Color/Theme Element                                          | Pattern CSS                                   |
| Define responsive two-column form section                      | Forms Pattern + 2x Grid/Spacing                              | Component internals or feature Bootstrap grid |
| Add a missing selectable-card interaction                      | New or gated Pattern/Component                               | Local div/button hybrid controls              |

## 14. Accessibility contract

- Preserve semantic ownership from child Components.
- Do not hide required instructions inside optional components such as tooltips, popovers, collapsed panels, or hover-only UI.
- Validation summaries must identify affected fields and link to them when the fields can be focused.
- Group-level validation must identify the affected group and provide recovery instructions.
- Blocked, empty, unavailable, and permission states must include enough visible text to explain the state without relying on color or icon alone.
- Pattern-owned focus order must remain predictable after responsive changes, disclosure, validation, or async updates.
- Pattern-owned overlays, drawers, or panels must define focus movement, dismissal, focus return, scroll behavior, and reduced-motion behavior.
- Pattern-owned loading or async escalation must expose status text and preserve layout where needed.
- Pattern-owned hidden/collapsed content must not contain the only required instruction unless the disclosure state makes the requirement clear.
- Pattern-owned recovery actions must be keyboard accessible and must use installed Button/Link/Menu APIs.
- Do not duplicate or override child Component ARIA unless the owning Component or Pattern documents the contract.
- Do not use color alone to communicate state, grouping, validation, current location, or availability.

## 15. Content contract

- Use plain language for validation, blocked, empty, and unavailable states.
- State validation problems in terms of what the user can fix.
- Use action-oriented labels for recovery actions.
- Keep Pattern copy reusable and product-neutral unless the Pattern is explicitly feature-specific.
- Keep feature policy text out of Pattern standards.
- Do not duplicate server/business-rule language in Pattern standards.
- Use Pattern examples that show message shape, placement, and escalation without hard-coding feature policy truth.
- Use concrete labels in examples, but do not imply those labels are the only approved product copy.
- Avoid vague action labels such as `Submit`, `Continue`, or `OK` when the Pattern can show a more specific recovery action.
- Avoid decorative status copy that does not help users recover or continue.

## 16. Prohibited usage

- Do not redefine tokens or component internals from a Pattern.
- Do not bypass a missing Component API with local one-off markup.
- Do not bypass a missing Pattern API with repeated feature-local layout, state placement, or JavaScript.
- Do not move business validation rules into UI standards.
- Do not encode product policy, permissions, plan limits, or account rules as Pattern rules.
- Do not create local CSS variables, local token names, local icon sources, local focus rings, raw colors, or arbitrary spacing.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use Bootstrap grid, form, navbar, offcanvas, badge, alert, or utility classes as Pattern APIs.
- Do not create fake UI Reference examples for deferred capabilities.
- Do not mark a deferred capability as implemented until source, docs, UI Reference proof, and tests are updated.
- Do not create broad library-wide corrections from this governance Pattern.
- Do not place required instructions in hover-only, pointer-only, or optional disclosure content.
- Do not create Pattern-owned JavaScript without a documented API, data attributes, lifecycle, accessibility contract, and tests.

## 17. Deferred or gated capabilities

| Capability                                      | Status                                  | Gate                                                                                                                                |
| ----------------------------------------------- | --------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| New reusable orchestration Pattern              | Gated                                   | Requires at least one concrete app use case, source owner, composition contract, consumed APIs, UI Reference proof, and tests.      |
| Pattern-owned JavaScript controller             | Gated                                   | Requires documented data attributes, lifecycle, keyboard/focus behavior, reduced-motion behavior, teardown rules, and tests.        |
| Pattern-owned overlay/drawer/panel behavior     | Gated                                   | Requires Overlay/feedback ownership, focus trap or focus management, dismissal, inert/background rules, scroll behavior, and tests. |
| Pattern-owned validation summary helper         | Gated unless installed by Forms Pattern | Requires field ID mapping, focus behavior, links to fields, screen-reader behavior, and tests.                                      |
| Feature-specific Pattern variant                | Gated                                   | Requires proof that the variant repeats or is intentionally product-standardized. Otherwise keep feature-owned.                     |
| Pattern-owned async/load orchestration          | Gated                                   | Requires Loading/Inline loading/Notification boundaries, retry/cancel behavior, and state handoff.                                  |
| New Element primitive introduced by a Pattern   | Not allowed                             | Add or update the Element API first.                                                                                                |
| New Component primitive introduced by a Pattern | Not allowed                             | Add or update the Component API first.                                                                                              |
| Fake examples for deferred capabilities         | Not allowed                             | Use trigger-condition rows and approved alternatives instead.                                                                       |

## Implementation and UI Reference Checklist
### Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### UI Reference proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. UI Reference requirements

The UI Reference Pattern index must render concrete governance proof, not abstract notes only.

Required UI Reference sections:

| Required proof               | Rendered behavior                                                                                                                               | Variants/options shown                                                        |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------- |
| Pattern API layer boundary   | Page explains Element, Component, Pattern, and feature-module ownership with concrete examples.                                                 | Element owner, Component owner, Pattern owner, Feature owner                  |
| Boundary decision checklist  | Checklist/table helps decide where a behavior belongs.                                                                                          | Boundary review, Primitive review, Feature handoff                            |
| Primitive consumption proof  | Examples show Pattern consuming Element tokens and Component APIs without redefining them.                                                      | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid                    |
| Validation placement proof   | Examples show field-level, group-level, form-summary, blocked, empty, and unavailable placement.                                                | Field error, Summary, Blocked, Empty, Unavailable                             |
| Feature-owned handoff proof  | Examples show business rule truth passed from feature/server into Pattern placement.                                                            | Permission, Plan limit, Server validation, Data state                         |
| Deferred capability proof    | Gated rows show trigger conditions and approved alternatives.                                                                                   | Deferred, Gated, Not allowed                                                  |
| Responsive behavior proof    | Examples show stacking, collapse, overflow, fixed/sticky, and scroll ownership.                                                                 | Stack, Collapse, Overflow, Scroll, Sticky                                     |
| Accessibility boundary proof | Examples preserve child Component semantics and show summary links/focus behavior requirements.                                                 | Labels, ARIA ownership, Focus order, Validation links                         |
| Prohibited usage proof       | Page shows token redefinition, local markup, local JS, direct Carbon classes, Bootstrap classes, and business rules in standards as prohibited. | Raw tokens, Local markup, Local JS, Carbon classes, Bootstrap, Business rules |
| Related API links            | Page links to this canonical standard and consumed Element/Component/Pattern standards.                                                         | Elements, Components, Patterns, Checklist                                     |

All Pattern UI Reference examples must:

- Use app-owned tokens, classes, helpers, and Blade components where available.
- Link to consumed Element and Component standards.
- Show real rendered examples for implemented compositions.
- Show trigger conditions for deferred capabilities instead of fake complete controls.
- Preserve top-level Pattern page accessibility and responsive behavior.

## 20. Testing and acceptance criteria

- `/platform/ui-reference/patterns` returns 200 for authorized users.
- The Pattern route links to `docs/02-standards/ui/patterns/boundary-and-validation.md` or equivalent docs view.
- Rendered examples include boundary decision, primitive consumption, validation placement, feature handoff, responsive behavior, accessibility boundary, and deferred capability sections.
- Rendered examples include required composition markers and consumed Component/Element links.
- Rendered examples use installed Component APIs and Foundation Element APIs where available.
- Rendered examples do not hard-code Foundation Element decisions that already have approved APIs.
- Rendered examples do not redefine Component internals or child state classes.
- Deferred capabilities are represented with trigger conditions and prohibited local workarounds.
- Feature-owned examples clearly distinguish business rule truth from Pattern placement.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent unless intentionally used as visible approved copy.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production classes, Bootstrap classes, hard-coded colors, arbitrary spacing, local icons, local focus rings, or feature-local JavaScript examples are presented as approved.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/patterns');

$response->assertOk();
$response->assertSee('Boundary and validation');
$response->assertSee('Element');
$response->assertSee('Component');
$response->assertSee('Pattern');
$response->assertSee('Feature module');
$response->assertSee('Boundary decision checklist');
$response->assertSee('Primitive consumption');
$response->assertSee('Validation placement');
$response->assertSee('Feature-owned business validation');
$response->assertSee('Deferred capability');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Icons');
$response->assertSee('Motion');
$response->assertSee('2x Grid');
$response->assertSee('Do not redefine tokens or component internals');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('btn btn-primary');
$response->assertDontSee('row col-');
```

## 21. Related APIs

| API                                   | Route                                                                           |
| ------------------------------------- | ------------------------------------------------------------------------------- |
| Pattern standards index               | `/platform/ui-reference/patterns`                                               |
| Pattern implementation checklist      | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fchecklist.md`               |
| Component standards index             | `/platform/ui-reference/components`                                             |
| Component implementation checklist    | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fchecklist.md`             |
| Foundation Elements standards index   | `/platform/ui-reference/elements`                                               |
| Color element                         | `/platform/ui-reference/elements/color`                                         |
| Spacing element                       | `/platform/ui-reference/elements/spacing`                                       |
| Typography element                    | `/platform/ui-reference/elements/typography`                                    |
| Themes element                        | `/platform/ui-reference/elements/themes`                                        |
| Icons element                         | `/platform/ui-reference/elements/icons`                                         |
| Motion element                        | `/platform/ui-reference/elements/motion`                                        |
| 2x Grid element                       | `/platform/ui-reference/elements/2x-grid`                                       |
| Forms pattern                         | `/platform/ui-reference/patterns/forms`                                         |
| Navigation pattern                    | `/platform/ui-reference/patterns/navigation`                                    |
| Page header planned gap               | `/platform/ui-reference/patterns/layout`                                        |
| Table toolbar planned gap             | `/platform/ui-reference/patterns/tables`                                        |
| Overlay and feedback patterns         | `/platform/ui-reference/patterns/overlays-feedback`                             |
| Button                                | `/platform/ui-reference/components/button`                                      |
| Notification                          | `/platform/ui-reference/components/notification`                                |
| Loading                               | `/platform/ui-reference/components/loading`                                     |
| Tag                                   | `/platform/ui-reference/components/tag`                                         |
| UI shell                              | `/platform/ui-reference/components/ui-shell`                                    |
| Canonical boundary and validation doc | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fboundary-and-validation.md` |
| Carbon Patterns overview              | `https://carbondesignsystem.com/patterns/overview/`                             |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Pattern Standards Index](index.md)
- [Component Standards](../components/index.md)
- [Component Implementation Checklist](../components/checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- Carbon Patterns overview guidance informs the Pattern API definition: reusable best-practice compositions that help users achieve goals through sequences and flows. Login App keeps its own Element, Component, Pattern, and feature-module boundaries, app-owned APIs, UI Reference proof, and gated-capability model.