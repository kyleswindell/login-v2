# Change Queue

This queue is agent-managed and implementation-ready. It is not a scratchpad.
- Exploratory review discussion stays in chat until normalized into concise queue language.
- Active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###` (e.g. `P2-F-CQ-001`).
- `In Progress` marks the queue item currently claimed by the writable `work-batch` owner.
- An unfinished `In Progress` item must be continued or explicitly reclassified before a new `Ready To Implement` item is claimed.

## Ready To Implement

### P2-F-CQ-002 - Module home and dashboard summary starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide starter examples for module home / overview, dashboard/module summary surfaces, and dashboard widget examples by module content type.
- Acceptance:
  - module home starter includes page title/actions, summary content, primary content section, and empty/next-action state
  - dashboard/module summary starter uses dashboard grid, widget shell, and stat-card conventions
  - widget starter examples cover approved content-type examples without introducing feature-specific workflows

### P2-F-CQ-003 - Settings and setup starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide complete settings and setup/configuration starter examples and normalize proof surfaces only where needed for starter parity.
- Acceptance:
  - settings starter includes title/actions, settings navigation, form sections, validation placement, and form actions
  - setup starter includes task-oriented setup framing, setup navigation or peer-entry structure, and registration/config sections
  - touched setup/settings proof surfaces preserve existing feature behavior

### P2-F-CQ-004 - Account/profile starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide account/profile read-only and editable starter examples using the existing account proof surfaces and UI Reference catalog.
- Acceptance:
  - read-only account starter uses identity summary and key-value detail
  - editable account starter uses settings-style form scaffolding
  - account feature behavior remains out of scope

### P2-F-CQ-005 - List, detail, and create/edit starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide starter examples for list/index, table-management index, operational log/detail, content browser/split-view, detail/read-only, create/edit form, and blocked/empty/unavailable page states.
- Acceptance:
  - list/index starter includes page title/actions, search/filter, table or list content, and empty state
  - table-management index starter includes filters, row actions, and empty/bulk-action posture where applicable
  - operational log/detail starter demonstrates diagnostic read-only hierarchy
  - content browser/split-view starter demonstrates list/detail browsing structure
  - detail/read-only starter includes section blocks, key-value detail, and action placement
  - create/edit starter includes form sections, validation summary, field grouping, and form actions
  - blocked/empty/unavailable state starter demonstrates permission-blocked, no-data, and unavailable patterns without feature-specific behavior

### P2-F-CQ-006 - Batch F docs, tests, and handoff readiness
- Status: Ready To Implement
- Owner: Batch F
- Scope: Add automated coverage and synchronize planning/handoff notes after starter implementation.
- Acceptance:
  - tests verify starter routes and required markers
  - Phase 2 docs reflect Batch F implementation status
  - Batch E remains the post-F close-out path and staging deploy remains out of scope

### P2-F-CQ-033 - T1 component family depth pass: actions
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Button, Menu, Menu buttons, and Link T1 pages after Foundation Elements and T1 contracts are accepted.
- Acceptance:
  - canonical docs and UI Reference examples are updated together
  - each page shows actual variants, states, spacing behavior, implementation owner, and queued gaps
  - tests include component-specific assertions for the implemented action-family pages

### P2-F-CQ-034 - T1 component family depth pass: inputs
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Text input, Textarea, Number input, Select, Dropdown, Multiselect, Search, Date picker, File uploader, and Slider T1 pages.
- Acceptance:
  - input docs and UI Reference examples apply Foundation Element color, spacing, typography, icon, and theme rules
  - examples include default, variant, focus, hover-capable, disabled, read-only, validation, and loading states where applicable
  - queued gaps remain explicit where final component behavior is not yet implemented

### P2-F-CQ-035 - T1 component family depth pass: selection controls
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Checkbox, Radio button, Toggle, and Content switcher T1 pages.
- Acceptance:
  - checkbox versus radio usage is visually demonstrated
  - selection group states, orientation variants, disabled/read-only states, validation states, and helper text are represented
  - content switcher remains queued or receives concrete examples according to accepted app need

### P2-F-CQ-036 - T1 component family depth pass: feedback and loading
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Notification, Tag, AI label, Inline loading, Loading, Progress bar, and Progress indicator T1 pages.
- Acceptance:
  - semantic status and loading examples use current token standards
  - AI label remains gated unless a real AI-assisted feature exists
  - loading and progress pages distinguish spinner, inline loading, skeleton, determinate, and step-progress expectations

### P2-F-CQ-037 - T1 component family depth pass: overlays and help
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Accordion, Modal, Popover, Tooltip, and Toggletip T1 pages.
- Acceptance:
  - overlay/help docs and UI Reference examples distinguish blocking, contextual, non-interactive, and interactive disclosure
  - examples show focus, hover, disabled, open/closed, dismiss, and reduced-motion expectations where applicable
  - popover remains queued unless a concrete consumer exists

### P2-F-CQ-038 - T1 component family depth pass: data display
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Data table, Pagination, Structured list, List, Contained list, Tile, and Tree view T1 pages.
- Acceptance:
  - data display pages show concrete variants, states, spacing behavior, and T2 consumption links
  - pagination and structured-list coverage remains visual and implementation-oriented
  - queued data-display gaps include trigger conditions

### P2-F-CQ-039 - T1 component family depth pass: navigation and shell
- Status: Ready To Implement
- Owner: Batch F
- Scope: Deepen Breadcrumb, Tabs, and UI shell T1 pages.
- Acceptance:
  - tabs include line, contained, vertical, icon-leading, icon-only, overflow/scroll, selected, focus, and disabled states
  - UI shell remains one family with Login-specific header, left panel, and right panel guidance as subsections
  - navigation pages link to T2 pattern composition owners where primitives are consumed

### P2-F-CQ-040 - Foundation Elements concrete example correction pass
- Status: Ready To Implement
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-027, P2-F-CQ-028, P2-F-CQ-029, P2-F-CQ-030
- Scope: Correct the Foundation Elements UI Reference pages so they show concrete built examples, not token lists or prose-only standards. Start with Color because manual review found that page insufficient, then apply the same concrete-example bar to Themes, Spacing, Typography, Icons, Grid, Motion, and Pictograms.
- Acceptance:
  - Color page documents and displays Login App theme-layer equivalents for light/base, gray-10-style lower layer, dark/base, and gray-90-style lower layer surfaces
  - Color page demonstrates stacked surface levels such as base page, muted/layer surface, and nested elevated/default element behavior
  - Color page demonstrates hover/focus deltas on muted/layer surfaces and states whether defaults are automatic or require explicit theming
  - Color page includes high-contrast and inverse-token examples, including light components on dark backgrounds and dark shell/header treatment on a light page
  - Color page replaces the six token namespace cards with actual rendered examples for text, icon, border, surface, action, status, and shadow tokens
  - canonical Color and Themes docs are updated with the same standards and usage rules
  - remaining Foundation Elements pages are reviewed against the same "built examples over lists" bar and either corrected or explicitly queued with a narrow follow-up
  - tests assert rendered example markers and content that would fail if pages regress to token-list-only guidance

## In Progress

## Implemented Pending Review

### P2-F-CQ-025 - Foundation Elements inventory and UI Reference menu
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add a Foundation Elements dropdown and catalog-driven UI Reference pages for overview, grid, color, icons, pictograms, motion, spacing, themes, and typography.
- Acceptance:
  - UI Reference sidebar shows Foundation Elements as its own category before T1 Components
  - overview explains Foundation Elements versus T1 Components, T2 Patterns, and T3 Feature Modules
  - each element page has a disposition of Implemented, Partially Implemented, Queued Gap, or Not Applicable Yet
  - existing CSS tokens and standards docs are mapped before new token work
  - tests prove every element route is reachable and appears in sidebar navigation
- Implemented in: worklog-2-F-0017

### P2-F-CQ-026 - Foundation Elements documentation model
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Create canonical element-level standards under `docs/02-standards/ui/elements/` and non-canonical Carbon comparison notes under `docs/09-reference/ui/`.
- Acceptance:
  - each element doc defines Login App standards and includes purpose, current implementation, UI Reference route, required visible examples, usage rules, queued gaps, and Carbon comparison notes
  - Carbon comparison/source notes live in `docs/09-reference/ui/`, not as canonical rules
  - UI Reference element pages link to the canonical docs
  - existing document library can surface the docs through its current docs route
- Implemented in: worklog-2-F-0017

### P2-F-CQ-027 - Color and theme token audit
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Audit and document the existing token model for text, icon, border, surface, action, status, and shadow namespaces without broad renaming.
- Acceptance:
  - clarify that text-primary means primary content hierarchy, not primary blue action color
  - map current tokens such as `--ui-text-strong` as accepted aliases or preferred terminology
  - Color page displays actual app tokens in light and dark mode
  - Themes page displays theme behavior and token inheritance
  - no arbitrary hard-coded component colors are introduced
- Implemented in: worklog-2-F-0017

### P2-F-CQ-028 - Spacing and grid foundation standard
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Define the app's 2x/8px-compatible spacing and grid foundation decision and expose it in UI Reference.
- Acceptance:
  - document the Tailwind-compatible, 8px-centered spacing model
  - define spacing scale and show it visually in UI Reference
  - define grid, page, and content-region examples
  - establish that components own internal spacing and parent layouts own external spacing
  - UI Reference shows approved stack/gap, form row, action row, table cell, card grid, and dashboard/widget spacing examples or owner references
- Implemented in: worklog-2-F-0017

### P2-F-CQ-029 - Typography foundation standard
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Define and display typography roles for page title, section title, card title, table header, body, muted text, label, helper text, error text, and code text.
- Acceptance:
  - UI Reference Typography page displays each required type role using final app styling
  - type color uses text tokens, not action tokens
  - component pages are contracted to apply typography rules directly in examples
  - tests assert the Typography page exposes required roles
- Implemented in: worklog-2-F-0017

### P2-F-CQ-030 - Iconography, pictograms, and motion foundation standard
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Document Heroicons usage, pictogram disposition, and motion rules for hover/focus, loading, overlays, notifications, and reduced motion.
- Acceptance:
  - Heroicons remain the default app icon library unless a later ADR changes it
  - Icon page documents size, color, touch target, icon/text alignment, decorative versus semantic icons, and common usage posture
  - Pictograms are queued with trigger conditions and Carbon pictograms are not imported
  - Motion page documents hover/focus transitions, loading motion, toast/drawer/modal motion, and reduced-motion behavior
  - UI Reference shows built examples, not prose only
- Implemented in: worklog-2-F-0017

### P2-F-CQ-031 - T1 component doc and UI Reference display contract
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add canonical doc metadata to the T1 component catalog and create the standard quality bar for implemented T1 component pages.
- Acceptance:
  - component catalog includes `doc_path` and `doc_route`
  - every T1 page links to its canonical doc and every canonical T1 doc links back to the UI Reference route
  - implemented T1 pages have a required display contract covering default, variants/colors, focus, disabled, hover-capable default state, semantic states, loading/read-only states where applicable, spacing, implementation owner, and queued gaps
  - generic scaffold content is allowed only for queued or not-applicable dispositions
  - tests assert implemented pages link to canonical docs
- Implemented in: worklog-2-F-0017

### P2-F-CQ-032 - Carbon inventory correction before T1 deepening
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Correct component inventory mismatches before deeper T1 family work.
- Acceptance:
  - add Multiselect to the T1 catalog with explicit disposition
  - normalize Carbon UI shell as one family while preserving Login-specific header, left panel, and right panel guidance as subsections
  - update overview, sidebar, tests, and docs links
  - no Carbon component remains unmapped
- Implemented in: worklog-2-F-0017

### P2-F-CQ-016 - Carbon component inventory and T1 disposition map
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Create a UI Reference inventory matrix for the full Carbon component list and classify each component for Login App 2.0 as `Implement T1 Page`, `Represent As T2 Pattern`, `Queued Gap`, or `Not Applicable Yet`.
- Acceptance:
  - every Carbon component named in the review plan has a Login App 2.0 disposition
  - each disposition identifies the owner route or trigger condition
  - Carbon remains a completeness benchmark only and does not introduce Carbon visual tokens
- Implemented in: worklog-2-F-0016

### P2-F-CQ-017 - UI Reference T1 component menu architecture
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Replace the three combined Component Library links with a catalog-driven expandable T1 Components menu and keep T2 Pattern Standards separate.
- Acceptance:
  - sidebar and overview consume one component catalog source
  - tests prove cataloged T1 entries appear in navigation and are routable
  - legacy combined routes are no longer the primary navigation surface
- Implemented in: worklog-2-F-0016

### P2-F-CQ-018 - Split existing combined T1 pages
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add primary T1 pages for existing primitives currently combined across actions, status, forms, overlays, and utility examples.
- Acceptance:
  - component pages exist for button, icon button, menu item, badge/tag, status, text input, textarea, select, checkbox, radio button, toggle, searchable select, date input, file input, link, divider, icon, tooltip, toggletip, loading/spinner, modal, drawer, and notification
  - notifications may remain grouped as one T1 page for inline, toast, actionable, callout/banner, and persisted handoff
  - T2 pages compose or link to T1 owners instead of acting as the only primitive owner
- Implemented in: worklog-2-F-0016

### P2-F-CQ-019 - Missing input/control components
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add missing input/control component pages for number input, slider, dropdown, search, progress bar, and progress indicator.
- Acceptance:
  - number input includes default/fluid variants, stepper controls, min/max/step guidance, error/warning inline status icon, disabled, read-only, focus, and keyboard behavior
  - each missing control has concrete examples or an explicit queued implementation contract
- Implemented in: worklog-2-F-0016

### P2-F-CQ-020 - Selection component depth pass
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Expand checkbox and radio button representation into separate T1 pages with usage boundaries and states.
- Acceptance:
  - radio shows vertical/horizontal groups, selected/unselected, focus, disabled, read-only, error, warning, helper text, group states, and single-select-only rule
  - checkbox shows independent choice, multi-select group, checked/unchecked/indeterminate where supported or queued, disabled, read-only, error, and warning
  - checkbox vs radio usage is demonstrated, not only described
- Implemented in: worklog-2-F-0016

### P2-F-CQ-021 - Data display T1 expansion
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add dedicated T1 pages or dispositions for data table, pagination, structured list, list, contained list, tile, and tree view.
- Acceptance:
  - structured list includes default/selectable, condensed/default density, hang/flush alignment where supported, selected/focus/disabled/skeleton states
  - pagination includes full pagination, compact nav, page-size selector, overflow, disabled prev/next, size pairings, and placement below related content
  - T2 Data + Content and Tables consume/link to T1 owners instead of owning primitive standards
- Implemented in: worklog-2-F-0016

### P2-F-CQ-022 - Navigation/action primitives depth pass
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add or deepen breadcrumb, tabs, menu, menu buttons, content switcher, popover, accordion, and UI shell header/left/right T1 pages.
- Acceptance:
  - tabs include line, contained, vertical, icon-leading, icon-only, overflow/scroll, selected/focus/disabled, and tab-vs-progress/comparison guidance
  - menu includes action items, sizing, alignment, selected/current, disabled, danger, dividers, submenu boundary, keyboard/mouse expectations
  - Navigation + Actions becomes a T2 composition page only
- Implemented in: worklog-2-F-0016

### P2-F-CQ-023 - Low-applicability Carbon items and future gates
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Decide and document Login-specific treatment for AI label and code snippet and ensure no Carbon component remains unmapped.
- Acceptance:
  - AI label and code snippet have explicit dispositions and trigger conditions
  - speculative UI is not built for low-applicability components
  - no Carbon component is silently ignored
- Implemented in: worklog-2-F-0016

### P2-F-CQ-024 - T1 route, test, docs, and handoff cleanup
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add route/sidebar/catalog tests, update overview/checklist/active docs, and validate the full T1 component reference update.
- Acceptance:
  - every T1 sidebar route has automated coverage
  - overview and active docs reflect the new T1 component library model
  - focused UI Reference tests, build, docs guardrails, and browser review pass
- Implemented in: worklog-2-F-0016

### P2-F-CQ-012 - UI control module ownership cleanup
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-010, P2-F-CQ-011
- Scope: Split `resources/js/ui-controls.js` into smaller control-family modules only where it supports Batch F form, selection, table/search, dropdown, and filter guidance work. Keep runtime behavior unchanged and keep `resources/js/app.js` as the lifecycle registration entry point.
- Acceptance:
  - control behavior is grouped by concern rather than one mixed module for all controls
  - lifecycle registration remains centralized and readable from `resources/js/app.js`
  - selectors, UI behavior, route behavior, and rendered markup contracts remain unchanged
  - no notification feature expansion or unrelated shell behavior is introduced
  - `npm run build` passes
  - focused UI Reference tests pass for touched control surfaces
- Implemented in: worklog-2-F-0009

### P2-F-CQ-013 - UI CSS ownership map and first safe extraction boundary
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-008, P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011
- Scope: Turn the `resources/css/app.css` read map into concrete UI-standardization ownership sections for Batch F. If a low-risk boundary is clear, extract one cohesive UI section into an imported CSS module without changing visual tokens or behavior.
- Acceptance:
  - CSS ownership/read map identifies action/button, form/control, table/data, notification/feedback, dashboard/widget, theme-token, and compatibility-override sections
  - nearest agent guidance points future UI work to targeted CSS sections instead of broad stylesheet reads
  - any extraction keeps Tailwind/Vite build behavior stable
  - no new color, spacing, radius, typography, or component variants are introduced
  - `npm run build` passes
  - focused UI Reference tests pass for touched surfaces
- Implemented in: worklog-2-F-0010

## Blocked

## Deferred

### P2-F-CQ-014 - SettingsController settings-update extraction
- Status: Deferred
- Owner: Future platform architecture cleanup
- Scope: Repeated validation/write/logging patterns in `SettingsController` are a SOLID cleanup candidate, but this is backend settings architecture rather than Batch F UI element standardization.
- Revisit When: P2-F-CQ-003 exposes a settings starter blocker that requires backend refactoring, or a later platform architecture cleanup batch owns settings update flow extraction.

### P2-F-CQ-015 - Realtime notification transport/rendering split
- Status: Deferred
- Owner: Future notifications architecture cleanup
- Scope: `resources/js/realtime-notifications.js` can later split transport setup from notification rendering and local read-state updates, but notifications feature expansion is out of Batch F scope.
- Revisit When: P2-F-CQ-009 requires runtime notification behavior changes, or a later notifications batch owns realtime client behavior.

## Passed Review

### P2-F-CQ-008 - Usage guidance standards for button variants and action labels
- Status: Passed Review
- Owner: Batch F
- Scope: Reworked button/action guidance into concrete T1/T2 UI Reference examples for button variants, states, labels, one-primary-action rule, grouped menus, and implementation ownership.
- Implemented in: worklog-2-F-0015
- Review result: Approved on 2026-06-06
- Follow-up: P2-F-CQ-016 through P2-F-CQ-024 realign the accepted examples into a component-specific T1 library structure.

### P2-F-CQ-009 - Usage guidance for notifications, badges, and feedback
- Status: Passed Review
- Owner: Batch F
- Scope: Reworked notification/badge/feedback guidance into concrete T1/T2 examples for badges, statuses, inline alerts, toasts, page feedback, persisted notification handoff, and implementation ownership.
- Implemented in: worklog-2-F-0015
- Review result: Approved on 2026-06-06
- Follow-up: P2-F-CQ-016 through P2-F-CQ-024 keep notifications grouped but move the broader T1 library toward component-specific pages.

### P2-F-CQ-010 - Usage guidance for form field standards and selection controls
- Status: Passed Review
- Owner: Batch F
- Scope: Reworked form/selection guidance into concrete T1/T2 examples for field states, native controls, validation placement, selection boundaries, searchable select, and queued gaps.
- Implemented in: worklog-2-F-0015
- Review result: Approved on 2026-06-06
- Follow-up: P2-F-CQ-016 through P2-F-CQ-024 split accepted form/control examples into component-specific T1 pages.

### P2-F-CQ-011 - Usage guidance for data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile
- Status: Passed Review
- Owner: Batch F
- Scope: Reworked broader guidance into concrete T1/T2 examples across routed table, pagination, tabs, modal, tooltip/toggletip, loading, search/filter, input, overflow, breadcrumb, structured-list, file-uploader, date-picker, grid, and tile surfaces.
- Implemented in: worklog-2-F-0015
- Review result: Approved on 2026-06-06
- Follow-up: P2-F-CQ-016 through P2-F-CQ-024 split accepted broader examples into component-specific T1 pages and disposition gaps.

### P2-F-CQ-001 - Carbon contrast audit and starter catalog matrix
- Status: Passed Review
- Owner: Batch F
- Scope: Fifth correction pass (queue wording cleanup) complete. Queue state inconsistency resolved. P2-F-CQ-011 contract expanded and corrected to cover all 15 gap series and all 32 routed gaps. review.md Pass Summary synced. Dates corrected.
- Acceptance:
  - P2-F-CQ-001 appears in exactly one queue section
  - P2-F-CQ-011 scope and acceptance explicitly cover all 15 gap series: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02
  - review.md Pass Summary reflects all five correction passes and current state
  - all worklog and index dates are 2026-06-03
  - gap count is 62 across 22 areas consistently
  - P2-F-CQ-008 remains button variant and action label guidance only
  - P2-F-CQ-011 queue wording matches the audit gap definitions
- Implemented in: worklog-2-F-0002 (initial); worklog-2-F-0003 (correction pass 1); worklog-2-F-0004 (correction pass 2 — depth); worklog-2-F-0005 (correction pass 3 — missing areas + evidence fix); worklog-2-F-0006 (correction pass 4 — queue state reconciliation); worklog-2-F-0007 (correction pass 5 — queue wording cleanup)
- Review result: Approved on 2026-06-03

### P2-F-CQ-007 - UI Reference starter catalog entry point
- Status: Passed Review
- Owner: Batch F
- Scope: Added `/platform/ui-reference/patterns/starters` as the discoverable starter catalog entry point, registered sidebar navigation, documented route disposition, and added focused route coverage.
- Acceptance:
  - starter catalog entry is visible from UI Reference navigation
  - route and tests identify starter examples intentionally
  - starter catalog lists all 14 required starter examples with owner CQ, target route, required states, and primary patterns
  - route disposition matrix identifies keep/update/add/support-route decisions for current UI Reference routes
- Implemented in: worklog-2-F-0008
- Review result: Approved on 2026-06-03

## Closed
