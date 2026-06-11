# Checklist

## Batch Initialization
- [x] Batch Initialization
  Status: implemented
  - Batch F planning source exists
  - active workspace points to Phase 2 Batch F
  - Batch E close-out is paused until Batch F exits
  - staging deploy remains out of scope

## UI Reference Starter Catalog
- [ ] UI Reference Starter Catalog
  Status: partially implemented — Carbon audit and starter catalog entry point passed review on 2026-06-03: P2-F-CQ-001 and P2-F-CQ-007 are approved; `/platform/ui-reference/patterns/starters` is registered; sidebar navigation exposes Starter Catalog; route disposition matrix is documented; concrete starter pages remain in P2-F-CQ-002 through P2-F-CQ-005
  - [x] Carbon contrast audit is complete
  - [x] audit source set includes Carbon documentation site, Carbon website source repo, Carbon main repo, and Carbon main docs directory
  - [x] audit treats Carbon as a completeness benchmark, not a visual adoption target
  - [x] authoritative starter catalog matrix is documented
  - [x] required starter examples are visible and locatable in UI Reference
  - [x] UI Reference navigation exposes the starter catalog intentionally
  - [ ] starter examples are concrete page compositions, not only rule summaries

## Design-System Usage Guidance
- [x] Design-System Usage Guidance
  Status: passed review — P2-F-CQ-008 through P2-F-CQ-011 were manually approved on 2026-06-06; follow-up pass 2-F-0016 realigned the accepted examples into a component-specific T1 library structure
  - [x] badge, alert, toast, notification, and status color semantics are explicit
  - [x] guidance preserves the existing Login App 2.0 visual direction
  - [x] standard, soft, ghost, outline, and destructive button usage rules are explicit
  - [x] common action labels and action hierarchy are documented
  - [x] form action labels distinguish apply/stay-on-page from submit/complete/return behavior
  - [x] inline validation, page-level AJAX alerts, toasts, and persisted notifications have clear usage boundaries
  - [x] same-page AJAX feedback does not imply a full page refresh unless explicitly documented
  - [x] required and optional field marker rules are documented
  - [x] selection option variants and usage rules are documented
  - [x] required classes, ready-to-use components, component sets, and starter views are identified or queued
  - [x] concrete T1/T2 reference examples and implementation guides are present for actions, forms, feedback, data, navigation, overlays, loading, inputs, and layout guidance

## Carbon-Aligned T1 Component Library
- [ ] Carbon-Aligned T1 Component Library
  Status: partial — P2-F-CQ-066 through P2-F-CQ-073 passed manual review on 2026-06-08; P2-F-CQ-016 through P2-F-CQ-024 and P2-F-CQ-033 through P2-F-CQ-039 are closed as superseded by the current Component API standards, API proof sync, and component-specific recovery queue; P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, P2-F-CQ-128, P2-F-CQ-129, P2-F-CQ-136 through P2-F-CQ-163, and P2-F-CQ-166 through P2-F-CQ-169 are implemented pending review
  - [x] every reviewed Carbon component has a Login App 2.0 disposition and owner route
  - [x] sidebar and overview are generated from the same component catalog source
  - [x] legacy combined T1 routes remain available as index/compatibility surfaces, not primary navigation
  - [x] number input, radio button, checkbox, pagination, structured list, tabs, menu, and UI shell pages include focused state/depth coverage
  - [x] AI label, code snippet, and other low-applicability items have explicit queued or gated treatment
  - [x] UI Reference menu uses Components and Patterns as product-facing labels
  - [x] Component page contract is adopted into canonical component standards
  - [x] every component route exposes the approved Purpose, Use Cases, Component Contract, Live Examples, and Related Components and Patterns scaffold
  - [x] Accordion has a canonical minimal component and exemplar page for manual scaffold approval
  - [x] Components index exposes priority buckets, status legend, canonical docs, and Foundation Element dependencies
  - [x] manual review approves the Accordion scaffold exemplar before broader component family-depth work resumes
  - [x] remaining action, input, selection, feedback/loading, overlay/help, data-display, navigation, and shell Component pages use the approved scaffold
  - [x] live examples render sample output and variants for implemented pages; broad components may use approved matrices or full-width live-example sections instead of tab-only examples
  - [x] deferred Component pages expose trigger conditions and alternatives instead of speculative complete UI
  - [x] Date picker now has an installed `x-ui.date-picker` API and component-specific UI Reference examples
  - [x] remaining Component standards docs have clean Markdown tables, correct Tag/Tabs ownership, current Pattern owner routes, and deferred-page placeholder cleanup
  - [x] standards-defined public Component APIs from P2-F-CQ-122 through P2-F-CQ-127 are installed as public Blade wrappers or mapped to existing source aliases
  - [x] UI standards navigation separates final API expectations from active implementation tracking through `docs/02-standards/ui/api-registry.md` and `docs/08-active/ui-implementation-sync.md`
  - [x] UI API standards now require explicit implementation and UI Reference proof checklists, with active per-API progress tracked in `docs/08-active/ui-implementation-sync.md`
  - [x] UI standards registry and indexes have been reconciled after the numbered standards updates; newly approved target APIs are separated from active implementation progress
  - [x] newly approved target APIs from updated standards are installed or mapped before UI Reference proof sync resumes
  - [x] Component UI Reference pages prove the newly installed public APIs instead of local/reference-only markup
  - [x] component-by-component recovery review sequencing resumes after the API proof sync
  - [x] UI API Standards Preflight guidance requires related API, checklist, installed source, and live-example review before UI source edits
  - [x] UI Reference sidebar dropdowns use productive disclosure motion, reduced-motion handling, chevron state, and one shell scroll owner
  - [x] UI Reference sidebar uses one controlled disclosure API for Foundation Elements, Color, Typography, and Components with no native instant disclosure left in the shared sidebar partial
  - [x] UI Reference sidebar native-disclosure recovery was failed/reopened and replaced with a Navigation Pattern/UI shell correction using token-backed classes, controlled disclosure lifecycle, named nav regions, current-route semantics, and Heroicon chevrons
  - [ ] component-specific recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 is implemented and ready for manual review

## Foundation Elements Layer
- [x] Foundation Elements Layer
  Status: passed review baseline with typography update pending review — P2-F-CQ-025 through P2-F-CQ-032 and P2-F-CQ-040 through P2-F-CQ-065 were manually approved on 2026-06-08; P2-F-CQ-164 is implemented pending review to add the now-required Productive and Expressive Typography Type Sets API/proof surface
  - [x] UI Reference sidebar exposes Foundation Elements before T1 Components
  - [x] Foundation Elements overview explains Foundation Elements, T1 Components, T2 Patterns, and T3 Feature Modules
  - [x] grid, color, icons, pictograms, motion, spacing, themes, and typography have catalog dispositions and owner routes
  - [x] canonical element docs exist under `docs/02-standards/ui/elements/`
  - [x] Carbon comparison notes are kept in `docs/09-reference/ui/`
  - [x] Color, Themes, Spacing, Typography, and Icons pages show built examples rather than token-list-only guidance
  - [x] Grid, Pictograms, and Motion pages expose live-guide examples or queued implementation contracts
  - [x] guide status and system maturity are shown separately
  - [x] Color page shows full palette, interaction states, layering, and high-contrast moments
  - [x] Themes page owns token role/value inheritance and links high-contrast guidance to Color
  - [x] Icons, Typography, Motion, and Pictograms pages use token-backed examples or explicit audit disposition
  - [x] T1 component catalog includes canonical doc metadata and Multiselect
  - [x] UI shell is normalized as one T1 family with header, left panel, and right panel subsections
  - [x] Color exposes a separate Token Palette route for Carbon-depth token role coverage
  - [x] expanded background, layer, field, border, text, link, icon, support/status, focus, skeleton, and syntax namespaces are documented
  - [x] P2-F-CQ-040 through P2-F-CQ-065 correct Foundation Elements example and token depth before T1 family depth passes begin
  - [x] manual review confirms Foundation Elements pages are sufficiently concrete for later T1 depth passes
  - [x] Typography now exposes Productive and Expressive Type Sets through source classes and a nested Type Sets UI Reference page

## Module Home And Dashboard Summary Starters
- [ ] Module Home And Dashboard Summary Starters
  Status: not implemented
  - module home / overview starter is reviewable
  - dashboard/module summary starter uses widget-shell and stat-card conventions
  - dashboard widget examples by module content type are reviewable
  - empty or next-action state is represented where applicable

## Settings And Setup Starters
- [ ] Settings And Setup Starters
  Status: not implemented
  - settings starter demonstrates title/actions, settings navigation, form sections, validation, and form actions
  - setup/configuration starter demonstrates task-oriented setup framing, setup navigation, registration/config sections, and action placement
  - current setup/settings proof surfaces are normalized only where needed for starter parity

## Account/Profile Starters
- [ ] Account/Profile Starters
  Status: not implemented
  - account/profile read-only starter demonstrates identity summary and key-value detail
  - account/profile editable starter demonstrates settings-style form scaffolding
  - `/account`, `/account/settings`, and `/account/preferences` remain feature-behavior stable

## List, Detail, And Form Starters
- [ ] List, Detail, And Form Starters
  Status: not implemented
  - list/index starter demonstrates page title/actions, search/filter, table or list content, and empty state
  - table-management index starter demonstrates filters, row actions, and empty/bulk-action posture where applicable
  - operational log/detail starter demonstrates diagnostic read-only hierarchy
  - content browser/split-view starter demonstrates list/detail browsing structure
  - detail/read-only starter demonstrates section blocks, key-value detail, and action placement
  - create/edit form starter demonstrates form sections, validation summary, field grouping, and form actions
  - blocked/empty/unavailable state starter demonstrates permission-blocked, no-data, and unavailable patterns without feature-specific behavior

## Automated Coverage
- [ ] Automated Coverage
  Status: partially implemented
  - route tests confirm starter examples are reachable
  - assertions confirm required starter labels and pattern markers are present
  - no staging deploy validation is required in this batch
  - component recovery tests now block generic fallback comments and verify Breadcrumb, Tabs, Menu, Code snippet, and Button correction markers
  - breadcrumb-focused assertions verify trailing omitted-current trails, four/five item overflow rules, and open overflow menu review examples
  - date-picker-focused assertions verify `x-ui.date-picker`, native date/date-time examples, validation/warning, disabled/read-only, range deferral, and fallback absence
  - component-standards scans verify table structure, file/slug identity, stale Pattern routes, and stale UI navigation guidance
  - public Component API wrapper test verifies installed markers for Link, Menu buttons, Pagination, Search, Dropdown, File uploader, Number input, Select, Radio, Toggle, Inline loading, Progress, Tag, Structured list, Tile, Tooltip, and Toggletip
  - UI registry reconciliation scans verify stale planned routes, deleted token guidance, promoted API dispositions, and active-sync coverage for newly approved target APIs
  - component API proof-sync assertions verify contained list, native list classes, multiselect, popover, slider/range slider, and tree view UI Reference pages render installed APIs instead of local/reference-only markup
  - component recovery sequencing now has one queued correction/proof item per remaining unresolved Component API or disposition group
  - menu-focused assertions verify closed interactive examples, static item-state proof panels, item sizing, placement, checkable roles, submenu hooks, title text, and no forced-open menu state
  - button-focused assertions verify variant purpose, size, state, group, icon-only, content, and token/style role matrices
  - menu-buttons-focused assertions verify Menu button, Combo button, Overflow menu, size/width/state/keyboard proof, and canonical developer examples
  - typography type-set assertions verify nested Typography route, Productive/Expressive matrices, app-owned class names, 14px/16px bases, fixed/fluid heading behavior, blending/prohibited examples, and no Carbon production class API exposure
  - sidebar assertions verify Color/Typography dropdown state, productive disclosure motion markers, reduced-motion support, chevron open-state markers, native disclosure markup, readable category hover CSS, flat alphabetical Component menu order, one shell scroll owner, and removal of old Component category groups from the primary sidebar

## Handoff Readiness
- [ ] Handoff Readiness
  Status: not implemented
  - Phase 3 and Phase 4 can consume the starter catalog without reopening Phase 2 UI decisions
  - Batch E entry gates remain blocked until Batch F is complete
  - final Batch F state is explicit before close-out resumes
