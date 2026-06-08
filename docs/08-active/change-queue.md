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

## In Progress

## Implemented Pending Review

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

### P2-F-CQ-040 - Foundation Color page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-027
- Scope: Correct the Foundation Color UI Reference page so it shows concrete rendered examples of Login App color tokens, theme contexts, state behavior, semantic colors, and high-contrast moments.
- Acceptance:
  - theme-aware swatches cover app default, White-equivalent, Gray 10-equivalent, Gray 90-equivalent, and Gray 100-equivalent contexts
  - rendered examples cover background, layer, field, border, text, link, icon, support/status, focus, and skeleton/loading token groups
  - stacked surface, hover/focus delta, common component, and high-contrast examples are visible
  - `docs/02-standards/ui/elements/color.md` documents the same rules
  - tests assert rendered examples rather than token strings only
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-041 - Foundation Themes page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-027
- Scope: Correct the Foundation Themes UI Reference page with concrete theme matrices, component previews, layer examples, inline theme examples, and documented overrides.
- Acceptance:
  - page displays theme matrix, component preview matrix, layer inheritance, inline theme examples, and approved override table
  - page states that themes change token values, not token roles
  - `docs/02-standards/ui/elements/themes.md` documents the same rules
  - tests assert theme matrix, component previews, inline theme rule, and override table
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-042 - Foundation 2x Grid page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-028
- Scope: Correct the Foundation Grid UI Reference page and label it as 2x Grid while keeping `/platform/ui-reference/elements/grid` and supporting `/platform/ui-reference/elements/2x-grid`.
- Acceptance:
  - page displays responsive grid visualizer, breakpoints, column spans, gutter/padding/margin examples, fluid/fixed/hybrid examples, and app scaffold
  - page includes grid usage warnings and Carbon breakpoint test targets
  - `docs/02-standards/ui/elements/grid.md` documents the same rules
  - tests assert breakpoints, spans, scaffold, and alias route
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-043 - Foundation Spacing page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-028
- Scope: Correct the Foundation Spacing UI Reference page with a full live spacing scale, applied margin/padding/stack examples, relationship examples, density examples, and external-spacing ownership rules.
- Acceptance:
  - page displays `$spacing-01` through `$spacing-13` with rem, px, and utility/helper mapping
  - page displays margin, padding, stack, relationship, and density examples
  - page states that components own internal spacing and parent layouts own external spacing
  - `docs/02-standards/ui/elements/spacing.md` documents the same rules
  - tests assert scale table, applied examples, and no-default-external-margin rule
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-044 - Foundation Typography page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-029
- Scope: Correct the Foundation Typography UI Reference page with rendered font specimens, scale, role examples, productive UI examples, limited expressive guidance, weights, and text color examples.
- Acceptance:
  - page displays required type roles using final app styling
  - page displays productive content examples and states productive type is the default for app UI
  - page avoids adopting unsupported serif/expressive typography as normal product UI
  - `docs/02-standards/ui/elements/typography.md` documents the same rules
  - tests assert roles and applied UI examples
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-045 - Foundation Icons page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-030
- Scope: Correct the Foundation Icons UI Reference page with concrete Heroicons usage, sizing, text alignment, icon-only states, semantic/decorative examples, and hit target guidance.
- Acceptance:
  - page displays approved Heroicons table, size matrix, icon-with-text examples, icon-only controls, status icons, semantic/decorative examples, and 44px target example
  - page states Heroicons remain the approved icon library
  - `docs/02-standards/ui/elements/icons.md` documents the same rules
  - tests assert size matrix, hit target, semantic/decorative examples, and Heroicons dependency rule
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-046 - Foundation Pictograms page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-030
- Scope: Correct the Foundation Pictograms UI Reference page as a queued app-specific guide with placeholder examples, trigger conditions, sizing, clearance, container, and no-import rules.
- Acceptance:
  - pictograms remain queued because no real app pictogram library exists
  - page displays queued library, size, productive/expressive, container/clearance/theme, and app usage examples
  - page states Carbon pictograms must not be imported without a separate decision record
  - `docs/02-standards/ui/elements/pictograms.md` documents the same rules
  - tests assert queued status, trigger conditions, size/clearance examples, and no-import rule
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-047 - Foundation Motion page live implementation guide
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026, P2-F-CQ-030
- Scope: Correct the Foundation Motion UI Reference page with productive/expressive examples, common UI motion examples, duration examples, reduced-motion guidance, and do/don't samples.
- Acceptance:
  - page displays easing demos, common UI motion, duration examples, reduced-motion preview, and do/don't samples
  - page states productive motion is default and `prefers-reduced-motion` must be respected
  - `docs/02-standards/ui/elements/motion.md` documents the same rules
  - tests assert motion categories, common UI examples, reduced-motion rule, and do/don't samples
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-048 - Foundation Elements overview and renderer cleanup
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-025, P2-F-CQ-026
- Scope: Update Foundation Elements overview and renderer so repeated page sections are catalog/config-driven and all Foundation pages expose the shared live-guide contract.
- Acceptance:
  - overview includes status table for all Foundation Elements and links each element route and canonical doc
  - overview states Foundation Elements feed T1, T1 feeds T2, and T2 feeds T3
  - repeated page sections are rendered consistently from catalog metadata where practical
  - status vocabulary is consistent: Implemented, Partial, Needs audit, Deprecated, App-specific exception
  - `docs/02-standards/ui/elements/index.md` documents the shared contract
  - tests assert all element pages expose shared sections and overview status links
- Implemented in: worklog-2-F-0018
- Review result: Approved on 2026-06-08

### P2-F-CQ-049 - Foundation guide status vs system maturity correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-040 through P2-F-CQ-048
- Scope: Split Foundation Element catalog status into guide readiness and underlying system maturity.
- Acceptance:
  - catalog exposes `guide_status` and `system_status`
  - overview and element pages show guide readiness first and system maturity separately
  - badges no longer imply complete guide pages are only partial because app-wide enforcement is still maturing
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-050 - Color palette and state-token contract
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-040, P2-F-CQ-049
- Scope: Add full Login App palette display and explicit app state-token contract for active, selected, hover, focus, disabled, inverse, and high-contrast states.
- Acceptance:
  - Color page displays neutral ramp, blue/action ramp, support colors, token role groups, and state contract examples
  - Carbon one-step/two-step state logic is documented as comparison guidance only
  - focus token is represented with an app-owned variable
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-051 - Color page live example correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-040, P2-F-CQ-050
- Scope: Replace dark-only hard-coded Color examples with app-token-backed examples for palette, layering, states, alerts, form fields, selected rows, icon buttons, links, destructive actions, and high-contrast moments.
- Acceptance:
  - light and dark layer examples are visible
  - high-contrast moments belong to Color, not Themes
  - token-backed alerts, form fields, selected rows, links, icon buttons, and destructive actions are rendered
  - tests fail if Color regresses to token-list-only or text-only content
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-052 - Shared status, alert, text, and icon token repair
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-050, P2-F-CQ-051
- Scope: Repair Foundation examples to use supported app status, alert, text, icon, helper, placeholder/disabled, and focus tokens/classes in light and dark mode.
- Acceptance:
  - Foundation examples use `ui-status-pill`, `ui-status-inline-*`, `ui-inline-alert-*`, `ui-control-*`, `ui-link`, `ui-input`, and token variables where applicable
  - `--ui-focus-ring` is available in light and dark resolved themes
  - Color, Icons, and Typography pages no longer depend on dark-only Tailwind text/status colors
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-053 - Themes page refocus
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-041, P2-F-CQ-051
- Scope: Refocus Themes on token role/value inheritance and remove high-contrast ownership from the Themes page.
- Acceptance:
  - Themes page explains Theme, Token, Role, and Value
  - Themes page shows applied token role/value matrix and component previews
  - Themes page links high-contrast and inverse guidance to Color
  - Themes page does not own interaction-state or high-contrast examples
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-054 - Icons page correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-045, P2-F-CQ-052
- Scope: Correct Icons examples for token-aware color, text alignment, icon sizes, icon-only states, status/decorative/meaningful examples, and 44px hit target.
- Acceptance:
  - leading, trailing, inline link, button, and menu-item examples align icons and labels
  - 16px/20px and 24px/32px guidance is visible
  - status icons use app token-backed status classes
  - Heroicons remains the approved default library
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-055 - Typography page correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-044, P2-F-CQ-052
- Scope: Correct Typography examples for weights, italic, type color, alert/status color, hierarchy, and light/dark readable text.
- Acceptance:
  - Light 300, Regular 400, Semibold 600, and italic examples are visible
  - type color examples distinguish neutral text, disabled/placeholder text, links/actions, semantic alerts, and code
  - examples use app tokens and shared app classes instead of hard-coded dark-mode-only color classes
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-056 - Motion page live demonstration correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-047
- Scope: Replace static Motion cards with component-like previews and reduced-motion guidance.
- Acceptance:
  - Motion page includes dropdown, modal, toast, accordion/collapse, side panel, table sort/reorder, skeleton-to-content, reduced-motion, and do/don't examples
  - examples demonstrate actual motion or interactive states rather than static labels only
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-057 - Pictogram relevance and asset library audit
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-046
- Scope: Audit pictogram relevance and candidate asset-library paths without importing assets.
- Acceptance:
  - Pictograms page documents current disposition, trigger conditions, candidate options, licensing/dependency concerns, and recommended next action
  - no Carbon pictograms or third-party assets are imported
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-058 - Foundation correction tests, docs, and handoff
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-049 through P2-F-CQ-057
- Scope: Update canonical docs, tests, active batch docs, validation notes, and handoff state for the second Foundation Elements correction pass.
- Acceptance:
  - canonical docs for Color, Themes, Icons, Typography, Motion, and Pictograms match the corrected pages
  - focused UI Reference tests cover palette, states, status split, theme terms, icon alignment, typography weights/type color, motion previews, and pictogram audit
  - full UI Reference tests, build, docs guardrails, and browser review pass
- Implemented in: worklog-2-F-0019
- Review result: Approved on 2026-06-08

### P2-F-CQ-059 - Foundation final Color layering and Typography scale correction
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-050, P2-F-CQ-051, P2-F-CQ-055
- Scope: Correct final manual-review gaps on the Foundation Color and Typography pages before Foundation Elements approval.
- Acceptance:
  - Color layering model explains light versus dark layer logic in app terms
  - Color layering examples show nested depth rather than sibling layers
  - Color layering labels name the actual background color step, not generic layer numbers
  - Typography type scale renders the full Carbon benchmark scale from 12px through 92px
  - canonical Color and Typography docs plus focused UI Reference tests match the corrected examples
- Implemented in: worklog-2-F-0020
- Review result: Approved on 2026-06-08

### P2-F-CQ-060 - Carbon color token role inventory map
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-050 through P2-F-CQ-059
- Scope: Map Carbon color-token role families to Login App token dispositions and owner routes.
- Acceptance:
  - background, layer, layer accent, field, border, text, link, syntax, icon, support/status, focus, miscellaneous/inverse/skeleton, component tokens, and AI tokens are all mapped
  - each family is classified as Implemented, Covered By App Alias, Queued Token Gap, or Not Applicable Yet
  - each family has a Login App owner route
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-061 - Color token palette route and nested navigation
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-060
- Scope: Add the nested Color Token Palette route and sidebar entry while keeping the existing Color route as the overview page.
- Acceptance:
  - `/platform/ui-reference/elements/color` remains the Color Overview
  - `/platform/ui-reference/elements/color/tokens` is reachable before the generic element catch-all route
  - Foundation Elements sidebar separates Color Overview and Token Palette
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-062 - App color token namespace expansion
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-060
- Scope: Add app-owned token namespaces for missing role coverage while preserving existing aliases.
- Acceptance:
  - expanded namespaces cover background, layer, layer accent, field, border, text, link, icon, support/status, focus, skeleton/loading, and syntax/code roles
  - existing surface/text/border/link/spinner/action/status variables remain valid aliases where needed
  - token values are selected by design role, contrast, state behavior, layer logic, and accessibility rather than copied mechanically
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-063 - Color Token Palette page implementation
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-061, P2-F-CQ-062
- Scope: Build the Color Token Palette page as a matrix-oriented route separate from the Color Overview.
- Acceptance:
  - token rows show family, role, CSS variable, light value, dark value, rendered swatch/example, and Carbon comparison disposition
  - sections cover background/layer/field, border, text/icon, link, support/status, focus/skeleton, and syntax/code tokens
  - component and AI token dispositions are documented without crowding the Color Overview
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-064 - Component token adoption audit
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-062
- Scope: Audit shared T1/T2 CSS classes for expanded role-token adoption without visual redesign.
- Acceptance:
  - shared shell/card, field, border, text/icon, link, selected, focus, and spinner examples consume expanded role tokens where appropriate
  - legacy aliases remain available for compatibility
  - remaining component-specific token work is explicit future T1 family-depth scope
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-065 - Color token tests, docs, and handoff
- Status: Passed Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-060 through P2-F-CQ-064
- Scope: Sync canonical docs, active queue state, worklog, and focused UI Reference tests for the Color Token Palette expansion.
- Acceptance:
  - canonical color docs reference the new token-palette route and expanded namespace model
  - focused UI Reference tests cover nested Color sidebar navigation and every token-family section
  - T1 family-depth items remain blocked until the Foundation/token correction set passes review unless explicitly waived
- Implemented in: worklog-2-F-0021
- Review result: Approved on 2026-06-08

### P2-F-CQ-025 - Foundation Elements inventory and UI Reference menu
- Status: Passed Review
- Owner: Batch F
- Scope: Add a Foundation Elements dropdown and catalog-driven UI Reference pages for overview, grid, color, icons, pictograms, motion, spacing, themes, and typography.
- Acceptance:
  - UI Reference sidebar shows Foundation Elements as its own category before T1 Components
  - overview explains Foundation Elements versus T1 Components, T2 Patterns, and T3 Feature Modules
  - each element page has a disposition of Implemented, Partially Implemented, Queued Gap, or Not Applicable Yet
  - existing CSS tokens and standards docs are mapped before new token work
  - tests prove every element route is reachable and appears in sidebar navigation
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-026 - Foundation Elements documentation model
- Status: Passed Review
- Owner: Batch F
- Scope: Create canonical element-level standards under `docs/02-standards/ui/elements/` and non-canonical Carbon comparison notes under `docs/09-reference/ui/`.
- Acceptance:
  - each element doc defines Login App standards and includes purpose, current implementation, UI Reference route, required visible examples, usage rules, queued gaps, and Carbon comparison notes
  - Carbon comparison/source notes live in `docs/09-reference/ui/`, not as canonical rules
  - UI Reference element pages link to the canonical docs
  - existing document library can surface the docs through its current docs route
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-027 - Color and theme token audit
- Status: Passed Review
- Owner: Batch F
- Scope: Audit and document the existing token model for text, icon, border, surface, action, status, and shadow namespaces without broad renaming.
- Acceptance:
  - clarify that text-primary means primary content hierarchy, not primary blue action color
  - map current tokens such as `--ui-text-strong` as accepted aliases or preferred terminology
  - Color page displays actual app tokens in light and dark mode
  - Themes page displays theme behavior and token inheritance
  - no arbitrary hard-coded component colors are introduced
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-028 - Spacing and grid foundation standard
- Status: Passed Review
- Owner: Batch F
- Scope: Define the app's 2x/8px-compatible spacing and grid foundation decision and expose it in UI Reference.
- Acceptance:
  - document the Tailwind-compatible, 8px-centered spacing model
  - define spacing scale and show it visually in UI Reference
  - define grid, page, and content-region examples
  - establish that components own internal spacing and parent layouts own external spacing
  - UI Reference shows approved stack/gap, form row, action row, table cell, card grid, and dashboard/widget spacing examples or owner references
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-029 - Typography foundation standard
- Status: Passed Review
- Owner: Batch F
- Scope: Define and display typography roles for page title, section title, card title, table header, body, muted text, label, helper text, error text, and code text.
- Acceptance:
  - UI Reference Typography page displays each required type role using final app styling
  - type color uses text tokens, not action tokens
  - component pages are contracted to apply typography rules directly in examples
  - tests assert the Typography page exposes required roles
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-030 - Iconography, pictograms, and motion foundation standard
- Status: Passed Review
- Owner: Batch F
- Scope: Document Heroicons usage, pictogram disposition, and motion rules for hover/focus, loading, overlays, notifications, and reduced motion.
- Acceptance:
  - Heroicons remain the default app icon library unless a later ADR changes it
  - Icon page documents size, color, touch target, icon/text alignment, decorative versus semantic icons, and common usage posture
  - Pictograms are queued with trigger conditions and Carbon pictograms are not imported
  - Motion page documents hover/focus transitions, loading motion, toast/drawer/modal motion, and reduced-motion behavior
  - UI Reference shows built examples, not prose only
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-031 - T1 component doc and UI Reference display contract
- Status: Passed Review
- Owner: Batch F
- Scope: Add canonical doc metadata to the T1 component catalog and create the standard quality bar for implemented T1 component pages.
- Acceptance:
  - component catalog includes `doc_path` and `doc_route`
  - every T1 page links to its canonical doc and every canonical T1 doc links back to the UI Reference route
  - implemented T1 pages have a required display contract covering default, variants/colors, focus, disabled, hover-capable default state, semantic states, loading/read-only states where applicable, spacing, implementation owner, and queued gaps
  - generic scaffold content is allowed only for queued or not-applicable dispositions
  - tests assert implemented pages link to canonical docs
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

### P2-F-CQ-032 - Carbon inventory correction before T1 deepening
- Status: Passed Review
- Owner: Batch F
- Scope: Correct component inventory mismatches before deeper T1 family work.
- Acceptance:
  - add Multiselect to the T1 catalog with explicit disposition
  - normalize Carbon UI shell as one family while preserving Login-specific header, left panel, and right panel guidance as subsections
  - update overview, sidebar, tests, and docs links
  - no Carbon component remains unmapped
- Implemented in: worklog-2-F-0017
- Review result: Approved on 2026-06-08

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
