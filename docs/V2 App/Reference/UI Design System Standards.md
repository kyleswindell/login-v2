# UI Design System Standards

## Purpose

Consolidate the canonical UI design system standards for Login V2, including action tokens, table UX baselines, filter affordances, and drawer vs modal patterns.

This note is the primary source of truth for UI design element standards. The Batch 7 action-token note remains a scoped reference for implementation details.

## Planning Sources

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 7]] | [Phase 2 - Implementation Batch 7](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%207.md)

## Implementation Status

Current status:

* canonical owner note created for UI design system standards
* action tokens and drawer patterns migrated from Batch 7 reference
* table UX baseline synchronized with Feature Development Standards
* forms, cards, and notification standards added; typography and spacing remain to be fully standardized
* app-owned UI reference workspace is implemented at `/platform/ui-reference` as the canonical future UI reference surface for shell, forms, table, token, and drawer examples
* UI reference workspace access is intentionally restricted to platform super admins for baseline governance and review control

## Design Tokens

Define and standardize these token groups:

* colorways: primary, secondary, success, warning, danger, info, notice, neutral, ghost, outline
* light/dark mode variants with contrast checks
* typography and type scale
* spacing, border radius, and elevation

## Action Buttons

Shared action-token classes:

* `ui-action` - neutral action baseline for secondary actions
* `ui-action-primary` - primary emphasis actions
* `ui-action-success` - affirmative actions
* `ui-action-warning` - cautionary actions
* `ui-action-danger` - destructive actions
* `ui-action-notice` - informational actions
* `ui-action-ghost` - low-emphasis border actions
* `ui-icon-button` - icon-only button affordance for compact controls

Rules:

* apply shared action tokens to table row actions, widget actions, and dashboard actions
* ensure light and dark mode variants are explicit for each action token
* do not rely on plain text links for primary actions

## Tables And Data Grids

Baseline requirements for operator tables:

1. page title/subtitle row
2. optional table stats row
3. table action row (left-aligned actions such as Create, Settings, Export)
4. filter row (if scoped filters apply)
5. table
6. table footer controls:
   * bottom-left: rows selector + result summary
   * bottom-right: Prev / page selector / Next

Additional rules:

* provide search/filter capability for regular operator views
* include prominent row action buttons for primary actions
* do not use text-only action links for primary actions

## Filter Toggle Pattern

* use the shared `ui-icon-button` affordance
* include an accessible label via `aria-label` or visually hidden text
* toggle a nearby `data-filter-panel` region rather than navigating away
* prefer icon-first affordance over plain text-only "Filters" buttons on dense operator tables

## Drawer Pattern

App-owned operational detail drawers should follow these rules:

* use a fixed right-side panel instead of a centered modal when reviewing row detail from a dense operator table
* keep a direct page fallback route for non-JavaScript access and deep links
* load detail payloads as JSON from the same controller route when JavaScript opens the drawer
* support backdrop close, explicit close action, and Escape close
* lock body scroll while the drawer is open

## Toasts And Notifications

### Toasts

* use the shared toast pattern for success/error feedback
* avoid raw JSON or inline HTML blocks for standard notifications
* keep toasts short: title + 1-2 lines, optional single action
* match toast colorways to action tokens (success, warning, danger, notice)

### Notification Widgets

* use action tokens for all widget row actions (no plain text links)
* keep severity indicators consistent with badge colorways
* maintain parity between Livewire widgets and Filament widgets for action styling

### Notification Inbox

* keep realtime preview behavior aligned with inbox actions
* show status and severity with standardized badges
* preserve Echo/Reverb realtime behavior; do not replace with polling without explicit decision

## Forms And Inputs

Baseline rules:

* use consistent field spacing and label alignment across settings and account pages
* show validation errors inline under the field and at the top only when needed for summary
* required fields must be indicated consistently (label marker or helper text)
* buttons follow action tokens with explicit primary vs secondary intent
* avoid introducing Save/Apply bars outside of data-table flows (settings and account forms use explicit Save + Cancel when required)

Input standards:

* text inputs, selects, and textareas share the same height, padding, and border radius
* disabled fields must remain readable and visibly distinct
* helper text uses a consistent muted style

## Cards And Panels

* cards use a consistent radius, border, and shadow in light and dark mode
* card headers align with the page title hierarchy (avoid oversized or duplicated headings)
* metric cards should use consistent spacing and value typography
* action areas inside cards use the shared action token classes

## Accessibility

* include aria labels for icon-only controls
* maintain visible focus rings for keyboard navigation
* ensure action states meet contrast requirements in light and dark mode

## Important Files

* `resources/css/app.css` - shared action-token and light-mode overrides
* `resources/js/app.js` - filter toggle wiring and drawer logic
* `resources/views/platform/audit-logs/index.blade.php` - filter toggle, row actions, drawer markup
* `resources/views/platform/error-logs/index.blade.php` - filter toggle, row actions, drawer markup
* `resources/views/platform/ui-reference/index.blade.php` - app-owned UI reference examples for shell, forms, tables, tokens, and drawer behavior
* `resources/views/livewire/platform/dashboard/widgets/development-tools.blade.php` - dashboard action token usage
* `resources/views/livewire/platform/dashboard/widgets/system-notifications.blade.php` - dashboard notification action tokens
* `resources/views/filament/widgets/system-notifications-widget.blade.php` - Filament widget action tokens
* `app/Http/Controllers/Platform/UiReferenceController.php` - reference-page and sample drawer JSON payload contracts
* `routes/web.php` - `/platform/ui-reference` and sample payload routes

## Related

* [[V2 App/Reference/UI Action Tokens And Drawer Patterns]] | [UI Action Tokens And Drawer Patterns](UI%20Action%20Tokens%20And%20Drawer%20Patterns.md)
* [[Standards/Feature Development Standards]] | [Feature Development Standards](../../Standards/Feature%20Development%20Standards.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 8]] | [Phase 2 - Implementation Batch 8](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%208.md)
