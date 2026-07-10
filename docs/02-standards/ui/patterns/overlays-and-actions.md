---
title: Overlays and actions
slug: overlays-and-actions
api_layer: Pattern API
status: implemented-standard
system_maturity: partial
category: overlays-feedback
priority: tier-b-common-reusable-pattern
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/patterns/overlays-and-actions.md
source_owner: not installed
pattern_api:
  - x-ui.modal
  - x-ui.drawer
  - x-patterns.dropdown-action-menu
  - confirmation action group
  - destructive action confirmation composition
required_components:
  - modal
  - menu
  - menu-buttons
  - button
  - notification
  - tooltip
  - toggletip
  - progress-indicator
  - inline-loading
optional_components:
  - form components
  - tabs
  - breadcrumb
consumed_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - modal
  - menu
  - menu-buttons
  - button
  - notification
  - tooltip
  - toggletip
  - inline-loading
related_patterns:
  - common-actions
  - forms
  - table-toolbar
  - navigation
carbon_reference:
  - https://carbondesignsystem.com/patterns/overview/
  - https://carbondesignsystem.com/patterns/dialog-pattern/
  - https://carbondesignsystem.com/components/modal/usage/
  - https://carbondesignsystem.com/components/modal/accessibility/
  - https://carbondesignsystem.com/components/overflow-menu/usage/
  - https://carbondesignsystem.com/components/menu-buttons/usage/
  - https://carbondesignsystem.com/patterns/common-actions/
  - https://carbondesignsystem.com/community/patterns/create-flows/
  - https://carbondesignsystem.com/community/patterns/edit-pattern/
---

# Overlays And Actions Pattern API
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. Public composition APIs](#41-public-composition-apis)
  - [4.2. Canonical modal decision composition](#42-canonical-modal-decision-composition)
  - [4.3. Canonical destructive confirmation composition](#43-canonical-destructive-confirmation-composition)
  - [4.4. Canonical drawer detail composition](#44-canonical-drawer-detail-composition)
  - [4.5. Canonical overflow action menu composition](#45-canonical-overflow-action-menu-composition)
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
- [18. Rendered evidence requirements](#18-ui-reference-requirements)
- [19. Testing and acceptance criteria](#19-testing-and-acceptance-criteria)
- [20. Related APIs](#20-related-apis)
- [21. References](#21-references)

## 1. API summary

Overlay and action patterns define how blocking decisions, contextual panels, action menus, and recovery controls compose around a user task.

Canonical API owner: `not installed`. Use this Pattern API instead of creating local overlay, floating action, destructive confirmation, or contextual action compositions for the same workflow role.

Overlays and actions is the installed Login App 2.0 pattern for modal decisions, drawer-style contextual review, row/card overflow actions, destructive confirmations, pending action feedback, and recovery controls. It composes approved Component and Element APIs. It does not redefine primitive modal, drawer, menu, button, tooltip, toggletip, notification, focus, color, spacing, typography, icon, or motion behavior.

Canonical Pattern responsibilities:

- Choose the correct blocking or non-blocking action surface for a task.
- Compose modal, drawer, menu, button, notification, tooltip, toggletip, inline loading, and progress components into safe task flows.
- Define action hierarchy for confirmation, cancellation, destructive escalation, and recovery.
- Define focus return, opening context, dismissal rules, and pending action feedback across composed components.
- Define when overlays should become full-width or use a different pattern at small widths.
- Define rendered evidence proof for modal decisions, detail drawers, overflow action menus, destructive confirmations, and recovery feedback.

Non-owned responsibilities:

- Primitive modal/drawer/menu/button markup and keyboard semantics. Child Components own their public APIs.
- Business permissions, route authorization, record state, server validation, persistence, and audit logging.
- Page-level navigation, table data loading, form field internals, or notification delivery infrastructure.
- Arbitrary design choices such as local colors, local spacing, local focus rings, local overlay z-index values, or local animation curves.

## 2. Status and ownership

| Field               | Value                                                                                                                                  |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Status              | Implemented standard                                                                                                                   |
| System maturity     | Partial                                                                                                                                |
| API layer           | Pattern API                                                                                                                            |
| Pattern slug        | `overlays-and-actions`                                                                                                                 |
| Category            | Overlays and feedback                                                                                                                  |
| Priority            | Tier B - Common reusable pattern                                                                                                       |
| Owner route         | `not installed`                                                                                    |
| rendered evidence proof  | `not installed`                                                                                    |
| Canonical path      | `docs/02-standards/ui/patterns/overlays-and-actions.md`                                                                                |
| Source owner        | `not installed`                                                                                    |
| Pattern API         | `x-ui.modal`; `x-ui.drawer`; `x-patterns.dropdown-action-menu`; confirmation action group; destructive action confirmation composition |
| Required Components | Modal, Drawer, Menu, Menu buttons, Button, Notification, Tooltip/Toggletip, Inline loading as applicable                               |
| Required Elements   | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid where layout applies                                                        |
| Carbon benchmark    | Carbon patterns overview, dialog pattern, modal, overflow menu, menu buttons, common actions, create/edit flows                        |

`Implemented standard` means this pattern is approved for production composition. The rendered evidence page must prove the installed compositions with app-owned components, tokens, classes, and helper APIs, not generic notes or fake overlay examples.

## 3. Installed standard

Use overlay and action patterns for modal decisions, drawer-style contextual review, overflow actions, destructive confirmations, and recovery controls. Patterns compose approved Component and Element APIs; they do not redefine primitive visual decisions or feature-specific business behavior.

The installed standard is:

- Use `x-ui.modal` for blocking decisions, brief blocking forms, and destructive confirmations.
- Use `x-ui.drawer` for contextual review or edit surfaces where the source context should remain visually connected.
- Use `x-patterns.dropdown-action-menu` or approved Menu/Menu button APIs for row, card, toolbar, or object-level overflow actions.
- Use Button semantic variants for action hierarchy and destructive emphasis.
- Use Common Actions vocabulary for delete/remove, reset/clear, close/cancel, confirmation, and destructive action semantics.
- Use Notification for post-action feedback, recovery notices, blocking warnings, or action result summaries.
- Use Tooltip only for short non-interactive hints.
- Use Toggletip for focusable, dismissible contextual help.
- Use Inline loading or Button loading for pending action feedback.
- Use Progress indicator only when an overlay hosts a linear step flow approved by this pattern and the Forms pattern.
- Keep focus return tied to the opener when overlays close.
- Trap focus only in blocking modal contexts.
- Keep menu, tooltip, toggletip, modal, and drawer responsibilities separated.
- Escalate destructive or irreversible actions through explicit destructive copy and a danger action.
- Do not bypass installed Modal, Drawer, Menu, Button, Notification, Tooltip, or Toggletip APIs with local floating markup.

Carbon alignment note: Carbon defines patterns as reusable combinations that help users achieve goals, documents dialog/modal patterns for focused decisions, uses danger modal treatment for destructive or irreversible actions, uses overflow menus when space is constrained, and places create/edit flows in modals, side panels, tearsheets, or full pages depending on task complexity. Login App maps those principles to its own Blade APIs, app-owned `ui-*` classes, Element tokens, and rendered evidence proof rather than adopting Carbon implementation classes.

## 4. Pattern API

### 4.1. Public composition APIs

| API                                         | Status                                      | Purpose                                                                                        |
| ------------------------------------------- | ------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| `x-ui.modal`                                | Implemented Component API                   | Blocking decisions, short blocking forms, destructive confirmations, focused recovery choices. |
| `x-ui.drawer`                               | Implemented or Pattern-approved composition | Contextual review, read-only detail, and side-panel handoff surfaces.                          |
| `x-patterns.dropdown-action-menu`           | Implemented Pattern API                     | Standardized overflow action menu composition for rows, cards, and object-level actions.       |
| Confirmation action group                   | Implemented Pattern composition             | Primary/secondary/cancel hierarchy for modal and drawer decisions.                             |
| Destructive action confirmation composition | Implemented Pattern composition             | Warning copy, danger action, safer cancellation focus, and recovery feedback.                  |
| Validation/recovery action composition      | Implemented Pattern composition             | Notification plus action row for retry, dismiss, or return flows.                              |

### 4.2. Canonical modal decision composition

```blade
<x-ui.modal
    id="archive-project-modal"
    title="Archive project?"
    size="sm"
    labelled-by="archive-project-title"
    described-by="archive-project-description"
>
    <p id="archive-project-description" class="ui-overlay-body-text">
        Archived projects are hidden from active dashboards but can be restored later.
    </p>

    <x-patterns.form-actions alignment="end">
        <x-ui.button semantic="ghost" type="button" data-ui-modal-close>
            Cancel
        </x-ui.button>

        <x-ui.button semantic="primary" type="submit" form="archive-project-form">
            Archive project
        </x-ui.button>
    </x-patterns.form-actions>
</x-ui.modal>
```

### 4.3. Canonical destructive confirmation composition

```blade
<x-ui.modal
    id="delete-user-modal"
    title="Delete user?"
    variant="danger"
    size="sm"
    initial-focus="cancel"
    labelled-by="delete-user-title"
    described-by="delete-user-description"
>
    <p id="delete-user-description" class="ui-overlay-body-text">
        This permanently removes the user account and cannot be undone.
    </p>

    <x-patterns.form-actions alignment="end">
        <x-ui.button semantic="secondary" type="button" data-ui-modal-close>
            Cancel
        </x-ui.button>

        <x-ui.button semantic="danger" type="submit" form="delete-user-form">
            Delete user
        </x-ui.button>
    </x-patterns.form-actions>
</x-ui.modal>
```

### 4.4. Canonical drawer detail composition

```blade
<x-ui.drawer
    id="tenant-detail-drawer"
    title="Tenant details"
    placement="end"
    labelled-by="tenant-detail-title"
>
    <x-patterns.read-only-detail-group>
        {{-- Read-only field rows use approved Forms/Data display composition. --}}
    </x-patterns.read-only-detail-group>

    <x-patterns.form-actions alignment="between">
        <x-ui.button semantic="ghost" type="button" data-ui-drawer-close>
            Close
        </x-ui.button>

        <x-ui.button semantic="tertiary" href="{{ route('tenants.edit', $tenant) }}">
            Edit tenant
        </x-ui.button>
    </x-patterns.form-actions>
</x-ui.drawer>
```

### 4.5. Canonical overflow action menu composition

```blade
<x-patterns.dropdown-action-menu
    label="Open actions for {{ $tenant->name }}"
    placement="bottom-end"
    :items="[
        ['label' => 'View details', 'href' => route('tenants.show', $tenant)],
        ['label' => 'Edit tenant', 'href' => route('tenants.edit', $tenant)],
        ['type' => 'divider'],
        ['label' => 'Delete tenant', 'danger' => true, 'target' => '#delete-tenant-modal'],
    ]"
/>
```

Feature views may provide routes, labels, permissions, and state-specific copy. They must not redefine overlay chrome, action spacing, menu keyboard behavior, destructive styling, or focus management.

## 5. Required composition

Required Components as applicable:

- Modal.
- Drawer.
- Menu.
- Menu buttons.
- Button.
- Notification.
- Tooltip.
- Toggletip.
- Inline loading.
- Progress indicator when a gated linear overlay flow is approved.
- Form Components when the overlay contains editable fields.

Required Element APIs:

- Color tokens for surfaces, text, status, focus, danger, warning, disabled, and state behavior.
- Spacing and 2x Grid APIs for layout relationships, panel body spacing, action rows, and responsive collapse.
- Typography APIs for headings, labels, helper text, body copy, warning copy, and confirmation text.
- Icon APIs for action/menu/status symbols where approved.
- Motion APIs for modal, drawer, menu, toggletip, and disclosure transitions.
- Theme APIs for light, dark, layered, and inverse contexts.

## 6. Optional composition

| Composition                | Status                               | Use when                                                                                   |
| -------------------------- | ------------------------------------ | ------------------------------------------------------------------------------------------ |
| Read-only detail overlay   | Implemented                          | Users need quick contextual inspection without leaving the source page.                    |
| Form modal                 | Implemented with constraints         | The form is short, blocking, and can be completed without preserving broad page context.   |
| Drawer handoff             | Implemented                          | A detail/edit workflow benefits from staying visually attached to the originating record.  |
| Destructive warning copy   | Required for destructive actions     | The action is destructive, irreversible, or high-impact.                                   |
| Recovery notification      | Implemented                          | A completed or failed action needs next-step feedback.                                     |
| Retry action group         | Implemented                          | A failed operation can be retried safely.                                                  |
| Section-level loading      | Implemented through child Components | Pending work should not freeze unrelated page regions.                                     |
| Overlay progress indicator | Gated                                | Only for approved short linear flows using Progress indicator and Forms Pattern ownership. |

## 7. Consumed Element APIs

| Element API | Pattern usage                                                                                                                          |
| ----------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Overlay surfaces, scrims, text, subtle text, focus, borders, warning, danger, disabled, notification, and action hierarchy roles.      |
| Spacing     | Overlay header/body/footer rhythm, drawer insets, menu offsets, action group gaps, confirmation copy spacing, and responsive collapse. |
| Typography  | Overlay titles, body text, destructive warning copy, button labels, menu item labels, helper text, and notification titles.            |
| Themes      | Light, dark, layered, and inverse surface behavior for overlays and menu panels.                                                       |
| Motion      | Entrance/exit transitions, drawer slide behavior, menu/toggletip disclosure, reduced-motion behavior, and focus-visible transitions.   |
| Icons       | Menu trigger icons, destructive/status icons, close icons, disclosure icons, and notification icons from the approved icon API.        |
| 2x Grid     | Page-level placement, drawer/content relationships, form layout inside overlays, and responsive handoff.                               |

Carbon color composition mapping:

| Pattern need                                           | Carbon benchmark role                                     | Login App owner to compose               | Mapping rule                                                                                |
| ------------------------------------------------------ | --------------------------------------------------------- | ---------------------------------------- | ------------------------------------------------------------------------------------------- |
| Modal/drawer surface and scrim                         | Modal `$layer`, `$border-subtle`, `$overlay` rows         | Modal Component + Overlay Pattern role   | Pattern chooses blocking/non-blocking surface; Modal/Color own surface and overlay colors.  |
| Destructive, primary, secondary, cancel, retry actions | Button token families                                     | Button Component                         | Action hierarchy must consume Button semantic roles consistently across overlays and menus. |
| Overflow and contextual actions                        | Menu/Menu button rows plus layer state roles              | Menu and Menu buttons Components         | Pattern owns grouping; Menu owns item hover/active/focus colors.                            |
| Confirmation warnings and recovery messages            | Notification, Inline loading, Loading support/status rows | Feedback/Notification/Loading Components | Overlay Pattern places feedback; components own status colors.                              |
| Form-in-overlay fields                                 | Field Component rows                                      | Forms Pattern + field Components         | Overlay does not redefine form field colors.                                                |
| AI overlay/modal variants                              | `$ai-*` modal rows                                        | AI-specific gates                        | Not adopted unless AI Pattern/Component standards approve.                                  |

Pattern examples must consume these Element APIs through installed classes, tokens, and Components. They must not hard-code raw colors, arbitrary spacing, local focus rings, or custom motion values.

## 8. Owned Component APIs

The pattern owns composition-level decisions, not child internals.

| Owned by this Pattern             | Owned by child Components                           | Owned by feature modules                             |
| --------------------------------- | --------------------------------------------------- | ---------------------------------------------------- |
| Action hierarchy across surfaces  | Button variants, sizes, loading, disabled states    | Permission checks and route availability             |
| Overlay opening context           | Modal/drawer/menu trigger semantics                 | Business rules for when actions appear               |
| Blocking vs non-blocking choice   | Modal focus trap and drawer behavior                | Data loading and persistence                         |
| Destructive escalation            | Danger button styling and notification styling      | Audit logging and irreversible operation enforcement |
| Focus-return expectation          | Component-level focus movement                      | Record-specific fallback focus if opener disappears  |
| Pending action feedback placement | Button loading, inline loading, notification states | Async request handling and error mapping             |
| Responsive composition            | Component internal responsive behavior              | Page-specific layout constraints                     |

## 9. Allowed variants and layout options

| Variant/layout               | Type                   | Status                         | Use when                                                                                    | Notes                                                           |
| ---------------------------- | ---------------------- | ------------------------------ | ------------------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| Confirmation modal           | Modal pattern          | Implemented                    | User must explicitly confirm or cancel a focused decision.                                  | Keep copy short and actions visible.                            |
| Form modal                   | Modal pattern          | Implemented with constraints   | The form is brief, blocking, and context-light.                                             | Use Forms Pattern for field composition.                        |
| Read-only detail drawer      | Drawer pattern         | Implemented                    | User needs contextual inspection without leaving source context.                            | Source page may remain visible where space allows.              |
| Edit drawer                  | Drawer pattern         | Implemented with Forms Pattern | Contextual edits fit in a side panel and do not require full-page workflow.                 | Use warning step for high-impact edits.                         |
| Overflow action menu         | Menu pattern           | Implemented                    | There are more than three peer actions or row/card space is constrained.                    | Keep menu item limits from Menu standard.                       |
| Confirmation action group    | Action group           | Implemented                    | A decision has confirm/cancel or save/cancel controls.                                      | Use Button semantic hierarchy.                                  |
| Destructive confirmation     | Danger pattern         | Implemented                    | The action deletes, removes, resets, revokes, or cannot easily be undone.                   | Use explicit destructive title/copy and danger action.          |
| Recovery action group        | Feedback pattern       | Implemented                    | A failed or partial action needs retry, dismiss, or return controls.                        | Pair Notification with Button actions.                          |
| Full-width mobile overlay    | Responsive behavior    | Implemented                    | Modal/drawer width would otherwise hide content or actions.                                 | Keep action order and focus order stable.                       |
| Drawer-to-full-width handoff | Responsive behavior    | Implemented                    | Side panel cannot preserve readability at narrow widths.                                    | Do not split labels from fields.                                |
| Complex wizard overlay       | Gated                  | Deferred                       | A feature-backed multi-step flow requires overlay containment.                              | Requires Progress indicator and Forms Pattern ownership review. |
| Nested overlay               | Not allowed by default | Prohibited                     | Avoid opening modal from modal/drawer/menu unless a specific Pattern exception is approved. | Use same surface or route to a full page.                       |
| Persistent pinned overlay    | Deferred               | Not installed                  | Would require layout, focus, resizing, and persistence rules.                               | Use drawer or full page today.                                  |
| Drag-resizable drawer        | Deferred               | Not installed                  | Requires pointer/keyboard resize semantics and responsive proof.                            | Use fixed approved drawer sizes today.                          |

## 10. State ownership

The pattern owns orchestration states across composed surfaces.

| State                  | Pattern ownership                                                         | Child Component ownership                           |
| ---------------------- | ------------------------------------------------------------------------- | --------------------------------------------------- |
| Closed                 | Tracks source opener and hidden surface.                                  | Modal/drawer/menu hidden internals.                 |
| Opening                | Coordinates trigger, focus target, and motion entry.                      | Component transition classes and focus behavior.    |
| Open                   | Chooses blocking/non-blocking mode and action hierarchy.                  | Component semantics and local keyboard interaction. |
| Closing                | Coordinates dismissal reason and focus return.                            | Component exit transition and cleanup.              |
| Pending action         | Chooses where pending feedback appears and which controls are disabled.   | Button loading, Inline loading, disabled controls.  |
| Saved/completed        | Chooses notification or recovery placement after close or inline.         | Notification rendering and Button state reset.      |
| Failed/recoverable     | Chooses retry/dismiss/return options.                                     | Notification status styling and action controls.    |
| Blocked                | Chooses whether user stays in overlay or returns to source.               | Disabled controls and error messages.               |
| Destructive escalation | Requires confirmation, warning copy, and danger action.                   | Danger Button and Notification styling.             |
| Dismiss prevented      | Allows Escape/outside click to be disabled only when safe and documented. | Modal/drawer close behavior.                        |
| Disabled trigger       | Pattern prohibits opening from disabled controls.                         | Button/Menu disabled state.                         |

Field Components own focused, disabled, readonly, error, warning, helper, and validation states. Feature modules own permissions, data loading, persistence, and workflow-specific branching.

## 11. Responsive behavior

- Blocking overlays must fit small widths without hiding actions.
- Side panels may become full-width overlays when space is constrained.
- Menus must reposition or align to available space using the Menu Component API.
- Action groups must wrap or stack without changing semantic order.
- Confirmation copy must remain visible above actions at narrow widths.
- Destructive actions must remain visible and clearly separated from cancellation.
- Drawer content must preserve label/control relationships when collapsing.
- Long menus must not become scroll-trap surfaces; use a full page or drawer when action volume exceeds Menu limits.
- Form modal fields must stack at narrow widths through the Forms Pattern.
- Avoid fixed heights that hide recovery controls, close controls, or primary actions.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, and responsive composition.
- Child Components own their public APIs, local states, accessibility semantics, and internal spacing.
- Feature modules own business rules, permissions, data loading, persistence, and workflow-specific branching.
- Use modal patterns for blocking decisions and short blocking forms.
- Use drawer patterns for contextual details, read-only review, or edit handoff where the source context matters.
- Use menu buttons when there are more than three peer actions or row/card space is constrained.
- Use tooltip only for short non-interactive help.
- Use toggletip for focusable dismissible help.
- Use notification for result, warning, and recovery feedback.
- Use explicit destructive confirmation before irreversible, high-impact, or hard-to-undo actions.
- Do not open overlays from disabled controls.
- Do not trap focus outside blocking modal contexts.
- Return focus to the opener when an overlay closes whenever the opener still exists.
- If the opener is removed after action completion, return focus to the nearest stable source region or documented fallback.
- Keep actions in visible action rows, not buried in scrollable overlay bodies.
- Keep destructive actions visually and semantically distinct from ordinary confirmation actions.
- Keep pending action feedback close to the action that started the operation.
- Do not use overlays to avoid designing clear page structure.

## 13. Selection guidance

| User need                                             | Use                                       | Do not use                                   |
| ----------------------------------------------------- | ----------------------------------------- | -------------------------------------------- |
| Confirm a focused blocking decision                   | Confirmation modal                        | Drawer or tooltip                            |
| Confirm destructive or irreversible action            | Destructive confirmation modal            | Plain menu item alone when warning is needed |
| Review object details while preserving source context | Read-only detail drawer                   | Blocking modal unless decision is required   |
| Edit a short contextual object                        | Edit drawer or brief form modal           | Full wizard overlay without Pattern review   |
| Expose row/card secondary actions                     | Overflow action menu                      | Visible button group with many equal actions |
| Show short non-interactive explanation                | Tooltip                                   | Toggletip/modal/menu                         |
| Show focusable contextual help                        | Toggletip                                 | Tooltip                                      |
| Show action result/recovery                           | Notification with action group            | Modal unless the feedback blocks progress    |
| Handle many actions or complex choices                | Full page or Pattern-owned workflow       | Long overflow menu                           |
| Guide required linear setup steps                     | Forms Pattern + Progress indicator review | Ad hoc modal wizard                          |

Use modal patterns for blocking decisions. Use drawer patterns for contextual details that keep the source visible. Use menu buttons when there are more than three peer actions. Use full-page flows when the task is long, complex, or requires multiple data relationships.

## 14. Accessibility contract

- Trap focus only in blocking modal contexts.
- Return focus to the opener when overlays close.
- Support Escape dismissal when safe and documented.
- Do not support Escape dismissal when data loss would occur unless the user is warned or changes are recoverable.
- Provide visible focus on every interactive element.
- Keep keyboard order aligned with visual order.
- Maintain a stable, predictable focus target when an overlay opens.
- Destructive modals should focus the safer action first when the destructive action could cause data loss.
- Every modal and drawer must expose an accessible name through its title.
- Every modal or drawer with explanatory copy should expose that copy through an accessible description.
- Icon-only action triggers must include accessible labels.
- Menus must preserve Menu Component keyboard behavior.
- Tooltip content must not contain interactive controls.
- Toggletip content must be focusable/dismissible when it contains interactive or persistent contextual help.
- Do not rely on color alone for warning, danger, disabled, focus, selected, or pending states.
- Maintain contrast in supported light and dark themes.
- Avoid nested overlays that create ambiguous focus containment.
- If an overlay closes after deleting the opener’s source object, move focus to a stable region such as the updated table, list, or page heading.

## 15. Content contract

- Use sentence case.
- Use specific destructive titles: `Delete user?`, `Remove role?`, `Reset API key?`.
- Keep button labels outcome-oriented: `Delete user`, `Archive project`, `Save changes`, `Cancel`.
- Do not put irreversible actions behind vague menu labels such as `More`, `Manage`, or `Options`.
- State consequences before destructive confirmation actions.
- Avoid policy-length copy in modals. Link to details or use a full page when the user must read more.
- Use drawer titles that identify the object or task.
- Use menu labels that name the action, not the menu mechanics.
- Use notification copy to explain what happened and what the user can do next.
- Use warning copy for high-impact edits before saving.
- Keep recovery actions direct: `Retry`, `Review details`, `Return to list`.
- Avoid duplicate action terms. Move repeated context into the title or menu trigger when possible.

## 16. Prohibited usage

- Do not use a tooltip for interactive content.
- Do not open overlays from disabled controls.
- Do not bypass Modal, Drawer, Menu, Button, Notification, Tooltip, or Toggletip Component APIs with local floating markup.
- Do not create feature-local overlay shells, z-index systems, focus traps, scrims, dropdowns, or action-row spacing.
- Do not hard-code Foundation Element decisions such as raw colors, raw spacing, arbitrary shadows, local icons, local motion curves, or custom focus rings.
- Do not hide required actions inside scrollable overlay body content.
- Do not place destructive and primary submit actions without clear hierarchy.
- Do not use vague destructive labels such as `OK`, `Confirm`, or `Proceed`.
- Do not use menu overflow to hide a primary action that should be visible.
- Do not place more actions in a menu than the Menu Component limit allows.
- Do not use nested overlays unless a documented Pattern exception is approved.
- Do not use modal patterns for long, exploratory, or multi-relationship workflows that need full-page context.
- Do not use drawer patterns as permanent page layout.
- Do not use notification as the only confirmation for irreversible destructive actions when warning is required.
- Do not present deferred wizard, persistent panel, or custom right-click menu behavior as installed production API.

## 17. Deferred or gated capabilities

| Capability                          | Status                 | Gate                                                                                                                                                                  |
| ----------------------------------- | ---------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Complex wizard overlays             | Gated                  | Requires feature-backed trigger, Forms Pattern ownership, Progress indicator ownership review, focus and validation model, recovery behavior, and rendered evidence proof. |
| Multi-step destructive confirmation | Gated                  | Requires specific high-risk feature need, typed confirmation or secondary review requirements, and accessibility proof.                                               |
| Nested modal/drawer flows           | Gated                  | Requires explicit Pattern exception, focus-containment proof, Escape/back behavior, and recovery plan.                                                                |
| Persistent pinned panel             | Deferred               | Requires layout API, resize behavior, focus model, persistence rules, responsive behavior, and rendered evidence proof.                                                    |
| Drag-resizable drawer               | Deferred               | Requires pointer and keyboard resizing semantics, size constraints, responsive collapse, and tests.                                                                   |
| Right-click context menu            | Deferred               | Requires Menu Pattern/API support, keyboard equivalent, positioning, and focus recovery.                                                                              |
| Async overlay body loading          | Gated                  | Requires loading, error, retry, skeleton/inline-loading choice, focus preservation, and announcement behavior.                                                        |
| Full-screen modal app shell         | Not allowed by default | Use full-page route unless a Pattern exception proves why an overlay is required.                                                                                     |
| Local overlay component             | Not allowed            | Must update Component or Pattern API first.                                                                                                                           |

Future extensions require an updated Pattern standard and rendered evidence proof before production use.

## 18. Rendered evidence requirements

The rendered evidence page must show rendered examples of the approved pattern compositions, not abstract notes only. The page must link to this canonical standard and to consumed Element and Component standards. Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples. Examples must use app-owned tokens, classes, helpers, and Blade components where available.

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns.

Required Live examples:

| Required proof              | Rendered behavior                                                                                                                   | Variants/options shown                                                              |
| --------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Confirmation modal          | A blocking modal decision opens from a valid trigger, traps focus, shows concise copy, and returns focus on close.                  | Open/closed, focus trap, Escape close when safe, primary/secondary action hierarchy |
| Destructive confirmation    | A destructive action escalates from trigger/menu to warning copy and danger confirmation.                                           | Danger action, safer cancel focus, destructive title, warning copy, pending state   |
| Form modal                  | A brief blocking form composes Forms Pattern fields and modal action row behavior.                                                  | Form fields, validation summary, save/cancel actions, submitting feedback           |
| Read-only detail drawer     | A drawer shows contextual read-only details and preserves source context where space allows.                                        | Drawer handoff, close action, read-only group, responsive full-width handoff        |
| Edit drawer with warning    | A drawer-hosted edit flow warns before high-impact save when required.                                                              | Drawer actions, Forms Pattern composition, warning notification, pending save       |
| Overflow action menu        | Row/card/object actions use approved Menu/Menu buttons and keep secondary actions behind a trigger.                                 | Menu trigger, divided groups, danger menu item, item limits, focus return           |
| Recovery feedback           | A failed or completed action uses Notification and action controls for retry/dismiss/return.                                        | Inline/toast/modal notification choice, retry action, dismiss action                |
| Tooltip versus toggletip    | Short non-interactive help and focusable contextual help are shown as separate choices.                                             | Tooltip, Toggletip, no interactive tooltip content                                  |
| Responsive overlay behavior | Modal and drawer examples adapt at narrow widths without hiding actions.                                                            | Full-width handoff, stacked actions, preserved semantic order                       |
| Deferred gates              | Wizard overlays, nested overlays, persistent panels, right-click context menus, and resizable drawers show trigger conditions only. | Gated disposition rows, approved alternatives                                       |

Implementation proof must include:

- Canonical Blade examples for `x-ui.modal`, `x-ui.drawer`, `x-patterns.dropdown-action-menu`, confirmation action groups, and destructive confirmation composition.
- Links to Modal, Menu, Menu buttons, Button, Notification, Tooltip, Toggletip, Forms Pattern, and relevant Element standards.
- A selection matrix that chooses modal, drawer, menu, tooltip, toggletip, notification, full page, or wizard review.
- A state ownership table that separates Pattern, Component, and feature-module responsibilities.
- Regression examples showing prohibited local overlay markup, hard-coded z-index/focus traps, local menu/dropdown code, and fake wizard examples as not approved.

## 19. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows installed Pattern APIs, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Rendered examples include the required composition markers and consumed Component links.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- The page shows confirmation modal, destructive confirmation, form modal, read-only detail drawer, overflow action menu, recovery feedback, and responsive behavior examples.
- The page documents focus trap, focus return, Escape behavior, outside-click behavior where applicable, and pending feedback behavior.
- The page shows destructive confirmation copy and danger Button usage.
- The page distinguishes Tooltip from Toggletip and Menu from Modal.
- The page uses app-owned tokens, classes, helpers, and Blade components where available.
- The page does not present nested overlays, wizard overlays, custom right-click menus, persistent pinned panels, or resizable drawers as installed.
- The page contains no generic placeholder content.
- Regression checks assert no `Live Examples Card`, `Reference Examples`, `Legacy Contract Summary`, `tier-1`, `tier-2`, direct Carbon production classes, raw Bootstrap modal/dropdown classes, or feature-local overlay JavaScript is presented as approved.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Overlays and actions');
$response->assertSee('x-ui.modal');
$response->assertSee('x-ui.drawer');
$response->assertSee('x-patterns.dropdown-action-menu');
$response->assertSee('Confirmation modal');
$response->assertSee('Destructive confirmation');
$response->assertSee('Read-only detail drawer');
$response->assertSee('Overflow action menu');
$response->assertSee('Recovery feedback');
$response->assertSee('focus trap');
$response->assertSee('focus return');
$response->assertSee('Escape');
$response->assertSee('danger');
$response->assertSee('Tooltip versus toggletip');
$response->assertSee('Complex wizard overlays');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('modal fade');
$response->assertDontSee('dropdown-menu');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 20. Related APIs

| API                                | Route                                                                        |
| ---------------------------------- | ---------------------------------------------------------------------------- |
| Modal                              | `not installed`                                    |
| Drawer                             | `not installed`                                   |
| Menu                               | `not installed`                                     |
| Menu buttons                       | `not installed`                             |
| Button                             | `not installed`                                   |
| Notification                       | `not installed`                             |
| Tooltip                            | `not installed`                                  |
| Toggletip                          | `not installed`                                |
| Inline loading                     | `not installed`                           |
| Progress indicator                 | `not installed`                       |
| Forms pattern                      | `not installed`                                      |
| Common Actions patterns            | `docs/02-standards/ui/patterns/common-actions/index.md`                      |
| Table toolbar planned gap          | `not installed`                                     |
| Navigation patterns                | `not installed`                                 |
| Color element                      | `not installed`                                      |
| Spacing element                    | `not installed`                                    |
| Typography element                 | `not installed`                                 |
| Themes element                     | `not installed`                                     |
| Motion element                     | `not installed`                                     |
| Icons element                      | `not installed`                                      |
| Pattern overview                   | `not installed`                                            |
| Canonical overlays and actions doc | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Foverlays-and-actions.md` |
| Carbon patterns overview           | `https://carbondesignsystem.com/patterns/overview/`                          |
| Carbon dialog pattern              | `https://carbondesignsystem.com/patterns/dialog-pattern/`                    |
| Carbon common actions pattern      | `https://carbondesignsystem.com/patterns/common-actions/`                    |

## 21. References

- [Pattern Library Checklist](checklist.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- [Component Implementation Checklist](../components/checklist.md)
- Carbon patterns overview, dialog pattern, modal, overflow menu, menu buttons, common actions, create flows, edit flows, and notification guidance inform overlay selection, destructive escalation, focus behavior, overflow action grouping, recovery feedback, and task-flow placement. Login App keeps its own Pattern APIs, Blade components, app-owned `ui-*` class contract, Element token model, and rendered evidence proof.
