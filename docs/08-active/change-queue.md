# Change Queue

This queue is agent-managed and implementation-ready. It is not a scratchpad.
- Exploratory review discussion stays in chat until normalized into concise queue language.
- Active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###` (e.g. `P2-F-CQ-001`).
- `In Progress` marks the queue item currently claimed by the writable `work-batch` owner.
- An unfinished `In Progress` item must be continued or explicitly reclassified before a new `Ready To Implement` item is claimed.

## Ready To Implement

## In Progress

## Implemented Pending Review

### P2-F-CQ-169 - UI Reference sidebar Navigation Pattern correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-167, P2-F-CQ-168
- Manual Review: Failed/reopened after worklog 2-F-0049 because the native disclosure recovery restored dropdown behavior by locking in local `<details>/<summary>` navigation instead of the standards-owned Navigation/UI shell surface.
- Scope: Correct the UI Reference sidebar as a Navigation Pattern/UI shell surface after the native disclosure recovery left raw utility clusters, native instant disclosure, text glyph chevrons, missing named navigation landmarks, and tests that asserted the workaround as success.
- Acceptance:
  - sidebar visual treatment is owned by scoped `ui-reference-sidebar-*` classes in `resources/css/app.css` and consumes `var(--ui-*)` role tokens instead of raw Tailwind color/state clusters in the partial
  - Foundation Elements, Components, Color, and Typography use button-controlled disclosure with lifecycle initialization, explicit `aria-expanded`, controlled panels, productive motion markers, and reduced-motion handling
  - sidebar navigation regions have accessible names and active route links expose `aria-current="page"`
  - disclosure chevrons use approved Heroicons with decorative `aria-hidden="true"` semantics and token-backed rotation state
  - Components remain a flat alphabetical list, Color/Typography remain nested links, Widget Content subpages remain nested only when active, and old grouped/legacy sidebar surfaces remain absent
  - route tests reject native `<details>/<summary>`, text glyph chevrons, raw sidebar color utilities, and native-disclosure CSS selectors while asserting the Navigation Pattern contract
- Implemented in: worklog-2-F-0050

### P2-F-CQ-168 - UI Reference sidebar disclosure consistency correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-167
- Scope: Re-run the UI Reference sidebar menu correction so every sidebar disclosure group uses the approved controlled disclosure behavior instead of leaving native instant `<details>` behavior in the primary menu.
- Acceptance:
  - Foundation Elements and Components section groups use the same button/panel disclosure API as Color and Typography
  - no native `<details>` or `<summary>` disclosure remains in the shared sidebar partial
  - Foundation Elements and Components remain expanded by default while remaining keyboard-reachable controlled disclosures
  - route tests assert all four sidebar disclosure groups, productive motion markers, open/closed state markers, no nested Component scrollbar, alphabetical Components, and absence of native disclosure in the sidebar partial
- Implemented in: worklog-2-F-0048

### P2-F-CQ-167 - UI Reference sidebar dropdown motion and scroll correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-165, P2-F-CQ-166
- Scope: Treat the UI Reference sidebar as a Navigation/Layout Pattern surface and correct the Color/Typography dropdown and sidebar scroll behavior against related Motion, Icon, Accessibility, and Layout standards.
- Acceptance:
  - Color and Typography remain independent sidebar dropdowns with explicit disclosure buttons, `aria-expanded`, controlled panels, chevron rotation, productive motion, and reduced-motion handling
  - sidebar uses one shell scroll owner instead of a nested Component-list scrollbar
  - Components remain a flat alphabetical list with old Component category groups and legacy combined sidebar links absent from the primary menu
  - tests assert disclosure/motion markers, reduced-motion source support, chevron open-state markers, no nested Component `overflow-y-auto`, alphabetical order, and stale group absence
- Implemented in: worklog-2-F-0047

### P2-F-CQ-166 - UI API Standards Preflight enforcement
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-130, P2-F-CQ-131
- Scope: Add durable agent guidance requiring UI work to start from the owning UI API standard, its table of contents, required implementation sections, related APIs, installed source, and live examples before source edits.
- Acceptance:
  - UI standards AGENTS guidance defines the UI API Standards Preflight and requires it in active UI worklogs
  - resource-side AGENTS files require the same preflight before Blade, UI Reference partial, UI component, CSS, or JS behavior edits
  - guidance tells agents to stop and queue a standards gap when behavior-heavy UI work lacks sufficient primary or related API guidance
  - worklog 2-F-0047 includes the required `UI API Standards Preflight` section
- Implemented in: worklog-2-F-0047

### P2-F-CQ-165 - UI Reference sidebar menu standards correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-164
- Scope: Update the UI Reference sidebar to follow current menu standards by making Color and Typography independent dropdowns and replacing grouped Component menu categories with a flat alphabetical Component list.
- Acceptance:
  - Color and Typography render as collapsed dropdown menu items unless their own route or nested route is active
  - Components sidebar uses one alphabetical list from the Component catalog
  - old Component category headings and legacy combined sidebar links are removed from the primary menu
  - route tests assert dropdown state, alphabetical order, and absence of stale sidebar group surfaces
- Implemented in: worklog-2-F-0046
- Correction Follow-up: P2-F-CQ-167 adds the missing disclosure motion, reduced-motion behavior, and single sidebar scroll-owner proof.

### P2-F-CQ-164 - Typography type sets source API and UI Reference proof
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-130, P2-F-CQ-131, P2-F-CQ-132
- Scope: Install the app-owned Productive and Expressive Typography Type Set source API and add a nested UI Reference proof page at `/platform/ui-reference/elements/typography/type-sets`.
- Acceptance:
  - app CSS exposes `ui-type-set-productive`, `ui-type-set-expressive`, productive role classes, expressive role classes, display roles, and related CSS variables
  - Typography sidebar exposes nested `Overview` and `Type Sets` links
  - `/platform/ui-reference/elements/typography/type-sets` renders Productive and Expressive matrices, comparison examples, blending examples, API matrix, prohibited usage, and gated capabilities
  - Typography catalog, API registry, Elements index, and active implementation sync no longer describe expressive type as deferred
  - focused Foundation tests assert route, sidebar, class coverage, 14px/16px bases, fixed/fluid heading behavior, blending/prohibited examples, and no Carbon production class API exposure
- Implemented in: worklog-2-F-0045

### P2-F-CQ-136 - Link component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-122, P2-F-CQ-129
- Scope: Prove `x-ui.link` against the Link standard and replace local/reference-only examples.
- Acceptance:
  - page renders inline, external/help, icon-leading/trailing, focus-visible, hover, visited-policy, and unavailable/deferred link treatments
  - developer implementation uses `x-ui.link`
  - tests assert rendered API markers, state examples, content rules, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-137 - Pagination component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-122, P2-F-CQ-129
- Scope: Prove `x-ui.pagination` against the Pagination standard.
- Acceptance:
  - page renders full pagination, compact pagination, page-size selector, overflow, disabled previous/next, and responsive placement examples
  - developer implementation uses `x-ui.pagination`
  - tests assert rendered API markers, labels, disabled states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-138 - Search component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-122, P2-F-CQ-129
- Scope: Prove `x-ui.search` against the Search standard.
- Acceptance:
  - page renders page search, table search, clear action, loading/no-results, disabled/read-only, and gated behavior where applicable
  - developer implementation uses `x-ui.search`
  - tests assert rendered API markers, clear/loading hooks, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-139 - Dropdown component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-123, P2-F-CQ-129
- Scope: Prove `x-ui.dropdown` against the Dropdown standard.
- Acceptance:
  - page renders known-option handoff, validation, disabled/read-only, and menu state examples
  - developer implementation uses `x-ui.dropdown`
  - tests assert rendered API markers, option hooks, state examples, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-140 - File uploader component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-123, P2-F-CQ-129
- Scope: Prove `x-ui.file-uploader` against the File uploader standard.
- Acceptance:
  - page renders button upload, file validation, disabled state, and drag-drop gated disposition
  - developer implementation uses `x-ui.file-uploader`
  - tests assert rendered API markers, validation hooks, deferred drag-drop gate, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-141 - Number input component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-123, P2-F-CQ-129
- Scope: Prove `x-ui.number-input` against the Number input standard.
- Acceptance:
  - page renders min/max/step, increment/decrement, error/warning, disabled/read-only, compact, and fluid examples
  - developer implementation uses `x-ui.number-input`
  - tests assert rendered API markers, validation states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-142 - Select component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-123, P2-F-CQ-129
- Scope: Prove `x-ui.select` against the Select standard.
- Acceptance:
  - page renders native selection, helper text, validation, disabled/read-only, placeholder, and long-option handoff guidance
  - developer implementation uses `x-ui.select`
  - tests assert rendered API markers, option states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-143 - Radio button component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-124, P2-F-CQ-129
- Scope: Prove `x-ui.radio-button` and `x-ui.radio-group` against the Radio button standard.
- Acceptance:
  - page renders vertical/horizontal groups, selected/unselected, disabled/read-only, validation, and helper text examples
  - developer implementation uses `x-ui.radio-group` and `x-ui.radio-button`
  - tests assert rendered API markers, group semantics, state examples, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-144 - Toggle component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-124, P2-F-CQ-129
- Scope: Prove `x-ui.toggle` against the Toggle standard.
- Acceptance:
  - page renders immediate setting, disabled setting, read-only/gated state, helper text, on/off, focus, and reduced-motion expectations
  - developer implementation uses `x-ui.toggle`
  - tests assert rendered API markers, binary semantics, state examples, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-145 - Inline loading component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-125, P2-F-CQ-129
- Scope: Prove `x-ui.inline-loading` against the Inline loading standard.
- Acceptance:
  - page renders action pending, local save pending, polite status, success/error completion, and reduced-motion behavior
  - developer implementation uses `x-ui.inline-loading`
  - tests assert rendered API markers, status semantics, motion handling, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-146 - Progress bar component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-125, P2-F-CQ-129
- Scope: Prove `x-ui.progress-bar` against the Progress bar standard.
- Acceptance:
  - page renders determinate progress, gated indeterminate guidance, success/error completion, label/value, and reduced-motion examples
  - developer implementation uses `x-ui.progress-bar`
  - tests assert rendered API markers, ARIA/value attributes, state examples, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-147 - Progress indicator component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-125, P2-F-CQ-129
- Scope: Prove `x-ui.progress-indicator` and `x-ui.progress-step` against the Progress indicator standard.
- Acceptance:
  - page renders step flow, current/completed/error step, horizontal/vertical where supported, disabled/gated states, and content guidance
  - developer implementation uses `x-ui.progress-indicator` and `x-ui.progress-step`
  - tests assert rendered API markers, step states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-148 - Tag component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-125, P2-F-CQ-129
- Scope: Prove `x-ui.tag` and the Tag/Badge/Status boundary against the Tag standard.
- Acceptance:
  - page renders metadata tag, status tag, semantic tag, removable/filter tag where supported, disabled/gated states, and icon use
  - developer implementation uses `x-ui.tag`
  - tests assert rendered API markers, boundary language, semantic states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-149 - Structured list component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-126, P2-F-CQ-129
- Scope: Prove `x-ui.structured-list` and `x-ui.structured-list-row` against the Structured list standard.
- Acceptance:
  - page renders default, selectable, condensed, selected/current, focus, disabled, skeleton/loading, and responsive examples
  - developer implementation uses `x-ui.structured-list` and `x-ui.structured-list-row`
  - tests assert rendered API markers, row states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-150 - Tile component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-126, P2-F-CQ-129
- Scope: Prove `x-ui.tile` against the Tile standard.
- Acceptance:
  - page renders static, clickable, selectable, expandable, disabled/gated, focus, selected, and content-density examples
  - developer implementation uses `x-ui.tile`
  - tests assert rendered API markers, interaction states, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-151 - Tooltip component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-127, P2-F-CQ-129
- Scope: Prove `x-ui.tooltip` against the Tooltip standard.
- Acceptance:
  - page renders icon-only button tooltip, definition tooltip, disabled-control explanation pattern, placement, hover/focus, and non-interactive constraints
  - developer implementation uses `x-ui.tooltip`
  - tests assert rendered API markers, accessible naming, placement/state examples, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-152 - Toggletip component API proof and recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-127, P2-F-CQ-129
- Scope: Prove `x-ui.toggletip` against the Toggletip standard.
- Acceptance:
  - page renders contextual help, dismissible rich help, form assistance, placement, click/dismiss behavior, and reduced-motion expectations
  - developer implementation uses `x-ui.toggletip`
  - tests assert rendered API markers, trigger/panel/close hooks, accessible naming, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-153 - Checkbox component source/API and proof recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Audit and prove the Checkbox standard against the installed API.
- Acceptance:
  - source/API is confirmed as `x-ui.checkbox` / `x-ui.checkbox-group`
  - page renders independent choice, multi-select group, settings group, validation group, checked/unchecked/indeterminate, disabled, read-only, error, and warning examples
  - tests assert source/API markers, state proof, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-154 - Text input component source/API and proof recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Audit and prove the Text input standard against the installed native-plus-`ui-*` API.
- Acceptance:
  - source/API is confirmed as native input with `ui-field`, `ui-input`, and `ui-text-input` classes
  - page renders login/profile form, settings form, validation field, read-only field, disabled field, helper text, placeholder, and error/warning examples
  - tests assert source/API markers, state proof, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-155 - Data table component and Tables Pattern boundary recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Reconcile Data table Component proof with the upcoming table overhaul and Tables Pattern ownership.
- Acceptance:
  - current page does not fake final table-toolbar behavior
  - page renders basic sortable, filterable toolbar handoff, row actions, loading, empty, and responsive overflow examples using installed APIs or explicit gated dispositions
  - table-toolbar, enhanced data table, and related planned sub-APIs remain registry gaps
  - tests assert component/pattern boundary, rendered table proof, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-156 - Loading component source/API and proof recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Audit and prove the Loading standard against installed spinner/skeleton class API.
- Acceptance:
  - page renders spinner, skeleton text/card/table, page-region loading, reduced-motion behavior, and component-owned loading boundaries
  - developer implementation uses the confirmed loading/skeleton class API
  - tests assert rendered loading markers, reduced-motion proof, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-157 - Modal component source/API and proof recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Audit and prove the Modal standard against installed API and Overlays Pattern ownership.
- Acceptance:
  - source/API is confirmed as `x-ui.modal`
  - page renders confirmation, form modal, read-only detail, destructive action, wizard gated disposition, focus trap/return, Escape/outside-click rules, and reduced-motion behavior
  - tests assert modal API markers, accessibility behavior markers, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-158 - Notification component source/API and proof recovery
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Audit and prove Notification against installed alert/toast/status APIs and Feedback/Notifications Pattern ownership.
- Acceptance:
  - page renders form validation error, saved success, API failure, background job completed, maintenance/system notice, dismissible/gated behavior, and token-correct status colors
  - developer implementation uses the confirmed notification/toast API
  - tests assert status colors/classes, rendered API markers, and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-159 - AI label deferred disposition proof
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Keep AI label as a clear gated/no-public-API Component disposition unless a product AI decision approves it.
- Acceptance:
  - page shows no callable public API
  - trigger conditions, prohibited local workarounds, and current alternatives are explicit
  - tests assert deferred disposition rather than fake implemented examples
- Implemented in: worklog-2-F-0044

### P2-F-CQ-160 - Content switcher deferred disposition proof
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Keep Content switcher as a gated/deferred Component unless a product need approves it, with Tabs as the current alternative.
- Acceptance:
  - page shows no callable public API
  - trigger conditions, prohibited local workarounds, and Tabs alternative are explicit
  - tests assert deferred disposition rather than fake implemented examples
- Implemented in: worklog-2-F-0044

### P2-F-CQ-161 - Form represented-by-pattern disposition proof
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Keep Form represented by the Forms Pattern unless a standalone Component API is approved.
- Acceptance:
  - Component page does not fake standalone form ownership
  - Forms Pattern route and form-field/helper boundaries are linked clearly
  - tests assert represented-by-pattern disposition and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-162 - UI shell represented-by-pattern disposition proof
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Keep UI shell represented by Navigation/Layout Patterns unless a standalone Component API is approved.
- Acceptance:
  - Component page does not fake standalone shell ownership
  - Navigation/Layout Pattern routes and shell sub-API registry gaps are linked clearly
  - tests assert represented-by-pattern disposition and no generic fallback
- Implemented in: worklog-2-F-0044

### P2-F-CQ-163 - Component adjacent gap ownership decisions
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-129
- Scope: Resolve active-sync adjacent gaps that are not yet flat Component standards.
- Items: Textarea, Searchable select, Divider, Badge/Status, Drawer/Side panel, Form field.
- Acceptance:
  - each adjacent gap is assigned to an existing Component, Pattern, Element, planned registry gap, or new queue item
  - no speculative API is introduced without a standard and route owner
  - `docs/08-active/ui-implementation-sync.md` and `docs/02-standards/ui/api-registry.md` remain aligned
- Implemented in: worklog-2-F-0044

### P2-F-CQ-077 - Menu component correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-033, P2-F-CQ-129
- Scope: Replace generic Menu depth content with canonical `x-ui.menu` and `x-ui.menu-item` primitives, rendered anatomy/state examples, sizing, alignment, dividers, shortcuts, submenu boundary, and select/danger states.
- Acceptance:
  - Menu page shows contextual action, row action, grouped/selected, and alignment/RTL examples
  - variants render size, alignment, state, divider, shortcut, submenu, single-select, multi-select, danger, and disabled treatments
  - live examples render as normal closed/interactable menu controls by default, not forced-open static displays
  - helper and UI reference text must remain visible and unobscured when menus are closed
  - developer implementation uses `x-ui.menu`
  - focused tests assert anatomy coverage, sizes, alignment, states, and no generic fallback
  - worklog-2-F-0025 output is corrected rather than treated as accepted final proof
- Implemented in: worklog-2-F-0041

### P2-F-CQ-079 - Button component correction
- Status: Implemented Pending Review
- Unblocked By: P2-F-CQ-077 Menu component correction
- Owner: Batch F
- Follow-up To: P2-F-CQ-033, P2-F-CQ-116, P2-F-CQ-129
- Scope: Correct Button as the broad, matrix-heavy Component page exemplar with full variant, size, state, group, icon, content, and implementation coverage.
- Acceptance:
  - Button page renders a variant purpose matrix for primary, secondary, tertiary, ghost, danger primary, danger tertiary, and danger ghost
  - Button page renders seven size examples, state matrix, recommended groups, icon usage, content behavior, and token/style roles
  - icon-only hover/focus/disabled/loading/pressed/danger states are represented correctly
  - developer implementation uses `x-ui.button` and `x-ui.icon-button`
  - focused tests assert required matrices and no generic fallback
  - worklog-2-F-0026 output is corrected rather than treated as accepted final proof
- Implemented in: worklog-2-F-0042

### P2-F-CQ-093 - Menu buttons component correction
- Status: Implemented Pending Review
- Unblocked By: P2-F-CQ-079 Button component correction
- Owner: Batch F
- Follow-up To: P2-F-CQ-033, P2-F-CQ-122, P2-F-CQ-129
- Scope: Correct Menu buttons after the installed menu-button, combo-button, and overflow-menu APIs are proven in UI Reference.
- Acceptance:
  - Menu button, Combo button, and Overflow menu are represented as distinct base options with normal interactive closed-state examples
  - size variants cover extra small, small, medium, and large with matching trigger/menu item heights
  - width behavior documents the 160px menu minimum and ghost button exception
  - examples are not forced open unless scoped as explicit state/anatomy proof
  - developer implementation uses `x-ui.menu-button`, `x-ui.combo-button`, and `x-ui.overflow-menu`
  - focused tests assert rendered API markers, size/width behavior, and no generic fallback
- Implemented in: worklog-2-F-0043

### P2-F-CQ-129 - Component recovery review and correction sequencing
- Status: Implemented Pending Review
- Unblocked By: P2-F-CQ-128 Component UI Reference API proof sync
- Owner: Batch F
- Follow-up To: P2-F-CQ-128
- Scope: Resume component-by-component recovery review after the public APIs and UI Reference proof surfaces are in sync.
- Acceptance:
  - review order starts with Breadcrumb, Tabs, Menu, Code snippet, and Button
  - each reviewed page compares standards doc, installed API, rendered UI Reference proof, and focused tests
  - pages cannot move toward approval unless standards, source, examples, and tests agree
  - remaining catalog items continue in component route order
- Recovery Sequence:
  - Manual review first: Breadcrumb, Tabs, and Code snippet because those pages already have focused recovery output pending review.
  - Correct next: Menu, Button, and Menu buttons because they have known review blockers.
  - Continue through the remaining component catalog with one queue item per UI API or tightly bound ownership group.
- Implemented in: worklog-2-F-0040

### P2-F-CQ-128 - Component UI Reference API proof sync
- Status: Implemented Pending Review
- Unblocked By: P2-F-CQ-135 source/API installation pass
- Owner: Batch F
- Follow-up To: P2-F-CQ-122 through P2-F-CQ-127 and P2-F-CQ-135
- Scope: Replace local/reference-only examples on affected Component pages with the installed `x-ui.*` APIs.
- Acceptance:
  - affected UI Reference pages render installed APIs instead of native/local stand-ins
  - developer implementation sections show real canonical calls
  - rendered examples cover documented states, variants/options, accessibility behavior, and deferred gates
  - tests fail for generic fallback text, undocumented local markup, or standards/API mismatch
- Implemented in: worklog-2-F-0039

### P2-F-CQ-135 - Newly approved UI API source installation pass
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-132 through P2-F-CQ-134
- Scope: Install or expose the public source APIs now declared by the updated standards and registry before UI Reference proof sync resumes.
- Components: Contained list, List, Multiselect, Popover, Slider, Range slider, Tree view.
- Acceptance:
  - `x-ui.contained-list`, `x-ui.contained-list-item`, `x-ui.multiselect`, `x-ui.popover`, `x-ui.slider`, `x-ui.range-slider`, and `x-ui.tree-view` exist or are explicitly mapped to equivalent installed APIs
  - List has an approved native-plus-class source/API contract with UI Reference proof requirements
  - source files, public props/options, data attributes, and tests align with each owning standard
  - no standard is weakened only because source implementation is missing
  - P2-F-CQ-128 is unblocked once this installation pass is reviewable
- Implemented in: worklog-2-F-0038

### P2-F-CQ-132 - UI standards registry and index reconciliation
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Reconcile `docs/02-standards/ui/api-registry.md`, UI folder indexes, and UI AGENTS guidance with the current numbered standards docs.
- Acceptance:
  - `api-registry.md` reflects target API dispositions from current standards docs
  - formerly deferred APIs that now define public standards are marked `Approved API`
  - represented-by-pattern entries remain discoverable without pretending to own standalone Component source
  - folder indexes match the registry
  - stale deleted-folder guidance such as `tokens/AGENTS.md` is removed

### P2-F-CQ-133 - Substantial UI standards update audit
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Audit UI standards that changed beyond ToC/numbering for stale routes, malformed tables, source/API mismatches, and old deferred language.
- Acceptance:
  - malformed union-type Markdown tables found in promoted standards are corrected with `/` separators
  - stale planned Pattern routes are normalized to current owner routes or registry-gap language
  - source/API declarations that do not have matching source are not hidden; they are pushed into active sync/follow-up queue
  - standards remain target contracts and are not weakened to match missing implementation

### P2-F-CQ-134 - UI implementation sync refresh from updated standards
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Refresh `docs/08-active/ui-implementation-sync.md` from the reconciled registry and create follow-up queue work for approved target APIs whose source/proof is missing.
- Acceptance:
  - active sync tracks every registry API or planned gap affected by the standards update
  - implementation progress remains in `docs/08-active/`, not `docs/02-standards/ui`
  - missing source APIs are marked as missing/needs install rather than complete
  - follow-up source installation work is queued before UI Reference proof sync resumes

### P2-F-CQ-130 - UI standards navigation, registry, and implementation tracking correction
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Correct the UI standards navigation model so standards remain final API expectations, `api-registry.md` remains durable API ownership/disposition inventory, and active implementation proof tracking moves into `docs/08-active/`.
- Acceptance:
  - `docs/02-standards/ui/index.md` maps Elements, Components, Patterns, the API registry, and developer lookup paths without active progress tracking
  - `docs/02-standards/ui/api-registry.md` uses policy/disposition statuses only and removes progress statuses such as installed pending review/correction
  - `elements/index.md`, `components/index.md`, and `patterns/index.md` expose practical matrices for API lookup
  - UI standards `AGENTS.md` files route agents through indexes plus the API registry and remove stale deleted-file references
  - active implementation tracking lives in `docs/08-active/ui-implementation-sync.md`
  - stale `UI UX Typography Standards.md` is salvaged into `elements/typography.md` where needed and removed
- Implemented in: worklog-2-F-0034

### P2-F-CQ-131 - UI API checklist standardization and implementation sync expansion
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Add explicit per-UI API implementation/proof checklists to Element, Component, and Pattern standards while expanding the active implementation sync tracker to one row per known UI API and planned gap.
- Acceptance:
  - `UI API` is defined as the shared term for Foundation Element, Component, and Pattern APIs
  - standards guidance requires `Implementation and UI Reference Checklist`
  - each UI API standard includes `Implementation checklist` and `UI Reference proof checklist`
  - standards use requirement language, not active progress status
  - `docs/08-active/ui-implementation-sync.md` tracks current implementation/proof/test/review state for every API listed in `api-registry.md`
  - flat standards files remain the canonical default in this pass
  - closeout guidance states durable post-Batch implementation status moves to planning, not standards
- Implemented in: worklog-2-F-0035

### P2-F-CQ-122 - Missing action and navigation component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose the public APIs that current action/navigation standards define but source implementation has not fully caught up to.
- Components: Link, Menu buttons, Pagination, Search.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.link`, `x-ui.menu-button`, `x-ui.combo-button`, `x-ui.overflow-menu`, `x-ui.pagination`, and `x-ui.search` exist or are explicitly mapped to already-installed differently named APIs
  - source files and focused tests agree on component markers, state hooks, and public names
  - no standard is weakened only because the implementation was previously missing
- Implemented in: worklog-2-F-0033

### P2-F-CQ-123 - Missing input component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose missing public input APIs declared by the current standards.
- Components: Dropdown, File uploader, Number input, Select.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.dropdown`, `x-ui.file-uploader`, `x-ui.number-input`, and `x-ui.select` exist or are explicitly mapped to installed native-plus-`ui-*` APIs
  - documented public wrappers render field labels, helper/status text, disabled/read-only/error/warning hooks where applicable
  - richer behavior remains gated with trigger conditions
- Implemented in: worklog-2-F-0033

### P2-F-CQ-124 - Missing selection component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose selection APIs declared by the current standards.
- Components: Radio button, Toggle.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.radio-button`, `x-ui.radio-group`, and `x-ui.toggle` exist or are explicitly mapped to installed native-plus-`ui-*` APIs
  - public wrappers render documented selected/on/off, disabled, readonly, helper, and validation hooks
  - read-only/gated semantics are proven without fake unsupported controls
- Implemented in: worklog-2-F-0033

### P2-F-CQ-125 - Missing feedback and loading component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose feedback/loading APIs declared by the current standards.
- Components: Inline loading, Progress bar, Progress indicator, Tag.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.inline-loading`, `x-ui.progress-bar`, `x-ui.progress-indicator`, `x-ui.progress-step`, and `x-ui.tag` exist or are explicitly mapped to installed source aliases
  - Tag owns the Tag/Badge/Status boundary and no longer contains Tabs content
  - public wrappers render semantic/status/loading examples with token-backed Color, Typography, Icons, and Motion usage
- Implemented in: worklog-2-F-0033

### P2-F-CQ-126 - Missing data display component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose data-display APIs declared by the current standards.
- Components: Structured list, Tile.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.structured-list`, `x-ui.structured-list-row`, and `x-ui.tile` exist or are explicitly mapped to installed source aliases
  - public wrappers render default, selected/current, focus, disabled, density, and responsive markers where applicable
  - Pattern-owned grouping, filter, table-toolbar, and page-header behavior remains linked to current Pattern owners or the registry
- Implemented in: worklog-2-F-0033

### P2-F-CQ-127 - Missing overlay and help component API installation
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-121
- Scope: Install or expose overlay/help APIs declared by the current standards.
- Components: Tooltip, Toggletip.
- Review Gate: Not eligible for passed review until P2-F-CQ-128 proves installed APIs against current standards and UI Reference pages.
- Acceptance:
  - `x-ui.tooltip` and `x-ui.toggletip` exist or are explicitly mapped to installed source aliases
  - public wrappers prove hover/focus/click, dismissal, placement, accessible naming, and reduced-motion ownership markers where applicable
  - Popover remains deferred unless a separate product need installs it
- Implemented in: worklog-2-F-0033

### P2-F-CQ-074 - Breadcrumb component correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-039
- Scope: Replace generic Breadcrumb depth content with a canonical `x-ui.breadcrumb` primitive, functional overflow menu, small/medium live examples, and rendered nested variants.
- Acceptance:
  - Breadcrumb page shows small and medium base examples
  - variants render truncated menu, current-page-listed, and truncated-menu-with-current-page-listed treatments
  - default behavior omits the current page link unless the current-page-listed variant is used
  - developer implementation uses `x-ui.breadcrumb`
  - focused tests assert overflow menu, current page text, sizing, and no generic fallback
- Implemented in: worklog-2-F-0025

### P2-F-CQ-075 - Tabs component correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-039
- Scope: Replace generic Tabs depth content with a canonical `x-ui.tabs` primitive, working tab panel switching, and required line/contained/vertical examples plus rendered variants.
- Acceptance:
  - Tabs page shows line, contained, and vertical base examples
  - variants render scrollable tabs, icons, icon-only tabs, secondary labels, dismissible tabs, manual activation, and small-breakpoint handoff
  - tab panels contain unique scenario content
  - developer implementation uses `x-ui.tabs`
  - focused tests assert panel switching markers, required variants, and no generic fallback
- Implemented in: worklog-2-F-0025

### P2-F-CQ-076 - Component depth recovery audit and generic fallback ban
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-033 through P2-F-CQ-039
- Scope: Reclassify broad family-depth work as pending correction and add quality assertions that block generic fallback content on implemented component pages.
- Acceptance:
  - P2-F-CQ-033 through P2-F-CQ-039 are marked Implemented Pending Correction or closed as superseded after recovery queue creation
  - corrected component pages do not render generic developer comments, one-sentence state badges, or family-depth fallback panels
  - uncorrected broad pages no longer claim manual-review-ready completion
  - tests fail corrected pages that lack rendered scenario/variant examples or real component API examples
- Implemented in: worklog-2-F-0025

### P2-F-CQ-078 - Code snippet component correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-038
- Scope: Replace generic Code snippet depth content with canonical `x-ui.code-snippet` examples for single-line, multi-line, highlighted syntax tokens, copy-state disposition, and token-backed developer snippets.
- Acceptance:
  - Code snippet page renders single-line and multi-line examples
  - highlighted syntax-token examples use approved Typography and Color token guidance
  - copy behavior is implemented or explicitly gated with trigger conditions
  - developer implementation uses `x-ui.code-snippet`
  - focused tests assert highlighted-token proof and no generic fallback
- Implemented in: worklog-2-F-0025

### P2-F-CQ-080 - Date picker component correction
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-034
- Scope: Install `x-ui.date-picker`, update Date picker UI Reference examples to use the canonical API, and correct reviewed standards table/link issues.
- Acceptance:
  - Date picker standards API is represented by an installed component
  - UI Reference examples use the canonical API rather than local native-only markup
  - single date, date-time, validation, disabled/read-only, and gated range behavior are documented or rendered as appropriate
  - focused Date picker and component tests pass
- Implemented in: worklog-2-F-0031

### P2-F-CQ-116 - Component page layout flexibility correction
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Update the Component page requirements so the five-card scaffold remains required, but `Live examples` can use tabs, matrices, comparison grids, state tables, size scales, grouped examples, and full-width sections.
- Acceptance:
  - Purpose, Use cases, Component contract, Live examples, and Related components remain the required top-level order
  - variants are rendered visually but can live in a variant matrix when clearer than nesting under every scenario
  - broad components can use internal live-example subsections such as variants, sizes, states, groups, icon usage, content behavior, and token/style roles
  - tests keep stale scaffold labels absent without requiring every component to use tab-only live examples
- Implemented in: worklog-2-F-0026

### P2-F-CQ-117 - UI standards component and pattern path realignment
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Realign canonical UI standards paths to flat Component, Pattern, and Foundation Element folders and update supporting links/metadata.
- Acceptance:
  - Component standards live under `docs/02-standards/ui/components/{component}.md`
  - Pattern standards live under `docs/02-standards/ui/patterns/{pattern}.md`
  - Foundation Elements remain under `docs/02-standards/ui/elements/{element}.md`
  - supporting links, indexes, checklists, and UI Reference metadata no longer point at stale tier folders
- Implemented in: worklog-2-F-0027

### P2-F-CQ-118 - UI standards API-contract rewrite
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Rewrite Element, Component, and Pattern standards as installed UI API contracts and mark legacy UI contracts as transitional source material.
- Acceptance:
  - standards define installed APIs, allowed variants/options/states, prohibited usage, deferred gates, UI Reference requirements, and tests
  - UI Reference pages remain rendered proof surfaces
  - legacy contracts are not treated as canonical owner files
  - docs contract tests and guardrails pass
- Implemented in: worklog-2-F-0028

### P2-F-CQ-119 - Foundation 2x Grid canonical slug cleanup
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Make `2x-grid` the canonical Foundation Element slug, route, and doc while keeping `grid` only as a compatibility alias.
- Acceptance:
  - `docs/02-standards/ui/elements/2x-grid.md` is canonical
  - duplicate `grid.md` standard is removed
  - UI Reference route and tests support `2x-grid` while preserving `grid` compatibility where required
- Implemented in: worklog-2-F-0029

### P2-F-CQ-120 - Motion Foundation Element UI proof correction
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Correct Motion Foundation Element proof so expressive motion is gated, productive examples use installed APIs/utilities, Pattern routes are current, and reduced-motion proof is visible.
- Acceptance:
  - expressive motion renders as gated, not implemented live demos
  - productive examples use approved classes and installed component APIs where available
  - Accordion proof uses the canonical accordion API
  - reduced-motion proof includes visible default/static comparison and `prefers-reduced-motion`
  - no stale `/patterns/app-shell` route remains
- Implemented in: worklog-2-F-0030

## Implemented Pending Correction

## Blocked

### P2-F-CQ-002 - Module home and dashboard summary starters
- Status: Blocked
- Blocked Until: Component recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 reaches a starter-safe review state.
- Owner: Batch F
- Scope: Provide starter examples for module home / overview, dashboard/module summary surfaces, and dashboard widget examples by module content type.
- Acceptance:
  - module home starter includes page title/actions, summary content, primary content section, and empty/next-action state
  - dashboard/module summary starter uses dashboard grid, widget shell, and stat-card conventions
  - widget starter examples cover approved content-type examples without introducing feature-specific workflows

### P2-F-CQ-003 - Settings and setup starters
- Status: Blocked
- Blocked Until: Component recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 reaches a starter-safe review state.
- Owner: Batch F
- Scope: Provide complete settings and setup/configuration starter examples and normalize proof surfaces only where needed for starter parity.
- Acceptance:
  - settings starter includes title/actions, settings navigation, form sections, validation placement, and form actions
  - setup starter includes task-oriented setup framing, setup navigation or peer-entry structure, and registration/config sections
  - touched setup/settings proof surfaces preserve existing feature behavior

### P2-F-CQ-004 - Account/profile starters
- Status: Blocked
- Blocked Until: Component recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 reaches a starter-safe review state.
- Owner: Batch F
- Scope: Provide account/profile read-only and editable starter examples using the existing account proof surfaces and UI Reference catalog.
- Acceptance:
  - read-only account starter uses identity summary and key-value detail
  - editable account starter uses settings-style form scaffolding
  - account feature behavior remains out of scope

### P2-F-CQ-005 - List, detail, and create/edit starters
- Status: Blocked
- Blocked Until: Component recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 reaches a starter-safe review state.
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
- Status: Blocked
- Blocked Until: Component recovery queue P2-F-CQ-077, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-136 through P2-F-CQ-163 reaches a starter-safe review state.
- Owner: Batch F
- Scope: Add automated coverage and synchronize planning/handoff notes after starter implementation.
- Acceptance:
  - tests verify starter routes and required markers
  - Phase 2 docs reflect Batch F implementation status
  - Batch E remains the post-F close-out path and staging deploy remains out of scope

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

### P2-F-CQ-066 - Component UI Reference terminology and menu correction
- Status: Passed Review
- Owner: Batch F
- Scope: Rename UI Reference menu labels from tier-coded labels to product-facing Components and Patterns labels while preserving tier hierarchy in explanatory copy.
- Acceptance:
  - primary sidebar shows `Components` and `Patterns`, not `T1 Components` or `Pattern Standards`
  - overview copy uses Components and Patterns as the visible library labels
  - legacy grouped component links remain compatibility/index surfaces only
  - tests assert menu terminology and route reachability
- Implemented in: worklog-2-F-0022
- Review result: Approved on 2026-06-08

### P2-F-CQ-067 - Component requirements adoption into canonical docs
- Status: Passed Review
- Owner: Batch F
- Scope: Distill the downloaded Component UI Reference requirements into canonical component standards and non-canonical Carbon reference notes.
- Acceptance:
  - canonical component docs define the required Component page contract
  - Carbon source/comparison notes are stored as reference support, not app rules
  - Foundation Elements are documented as mandatory inputs for Component, Pattern, and later feature UI work
- Implemented in: worklog-2-F-0022
- Review result: Approved on 2026-06-08

### P2-F-CQ-068 - Component catalog metadata and shared renderer contract
- Status: Passed Review
- Owner: Batch F
- Scope: Expand the component catalog data model and shared renderer so component pages can consistently display purpose, guidance, states, anatomy, behavior, accessibility, developer API, related links, and status.
- Acceptance:
  - catalog entries expose priority, category, status, page-contract metadata, related owners, queued gaps, and Foundation Element dependencies
  - flat `/platform/ui-reference/components/{component}` routes remain canonical
  - route aliases are not introduced in this pass
- Implemented in: worklog-2-F-0022
- Review result: Approved on 2026-06-08

### P2-F-CQ-069 - Component overview, category, and priority surfaces
- Status: Passed Review
- Owner: Batch F
- Scope: Update the Components index with app-owned intro text, priority buckets, status legend, disposition matrix, canonical docs, and Foundation Element links.
- Acceptance:
  - index presents Components as reusable app building blocks
  - priority buckets A, B, and C are visible and generated from catalog data
  - disposition matrix uses app-owned wording rather than Carbon-oriented ownership language
  - Foundation Elements dependency is visible on the index
- Implemented in: worklog-2-F-0022
- Review result: Approved on 2026-06-08

### P2-F-CQ-070 - Component page scaffold contract for all catalog entries
- Status: Passed Review
- Owner: Batch F
- Scope: Replace generic component fallback rendering with the shared Component page renderer and Foundation Elements dependency section.
- Acceptance:
  - every component route renders the required shared section markers
  - implemented component pages do not pass with generic cards only
  - deferred/queued components include trigger conditions and do not fake complete UI
  - every component page links to relevant Foundation Elements
- Implemented in: worklog-2-F-0022
- Review result: Approved on 2026-06-08

### P2-F-CQ-071 - Component page scaffold correction
- Status: Passed Review
- Owner: Batch F
- Scope: Correct the shared Component page scaffold to the approved five-card order and remove stale/duplicated sections.
- Acceptance:
  - component pages use Purpose, Use cases, Component contract, Live examples, and Related components and patterns in order
  - stale `Legacy Contract Summary`, duplicate `{Component} Reference Examples`, and `Live Examples Card` labels are removed
  - Use cases and Anatomy/States use the required desktop split structure where applicable
  - Live examples support scenario-specific rendered proof
- Implemented in: worklog-2-F-0023
- Review result: Approved on 2026-06-08

### P2-F-CQ-072 - Accordion component and reference exemplar
- Status: Passed Review
- Owner: Batch F
- Scope: Install or expose the canonical minimal Accordion API and build `/platform/ui-reference/components/accordion` as the approved first Component page exemplar.
- Acceptance:
  - Accordion has a canonical component/API instead of reference-only markup
  - Accordion page renders the approved five-card scaffold
  - live examples include basic, independent, long-content, inside-card/panel, and form-assistance scenarios
  - compact, single-open, and scrollable variants render as implemented options where applicable
  - motion uses approved productive timing and reduced-motion handling
- Implemented in: worklog-2-F-0023
- Review result: Approved on 2026-06-08

### P2-F-CQ-073 - Component scaffold approval gate
- Status: Passed Review
- Owner: Batch F
- Scope: Hold full Component catalog rollout until the Accordion exemplar page shape is manually approved.
- Acceptance:
  - Accordion page shape is accepted as the simple component-page baseline
  - full catalog expansion remains blocked until manual approval
  - after approval, broad components may still request richer internal live-example layouts where needed
- Implemented in: worklog-2-F-0023
- Review result: Approved on 2026-06-08

### P2-F-CQ-121 - Remaining component standards review correction
- Status: Passed Review
- Owner: Batch F
- Scope: Correct remaining Component standards blockers before using them as UI Reference implementation contracts.
- Acceptance:
  - malformed Markdown tables are repaired
  - Tag/Tabs identity is corrected
  - deferred placeholder example calls are removed
  - planned Pattern references are normalized to current owner routes or registry gaps
  - follow-up API installation queue items are scheduled
- Implemented in: worklog-2-F-0032
- Review result: Approved on 2026-06-09

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

### P2-F-CQ-033 - T1 component family depth pass: actions
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Button, Menu, Menu buttons, and Link T1 pages after Foundation Elements and T1 contracts are accepted.
- Acceptance:
  - canonical docs and UI Reference examples are updated together
  - each page shows actual variants, states, spacing behavior, implementation owner, and queued gaps
  - tests include component-specific assertions for the implemented action-family pages

### P2-F-CQ-034 - T1 component family depth pass: inputs
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Text input, Textarea, Number input, Select, Dropdown, Multiselect, Search, Date picker, File uploader, and Slider T1 pages.
- Acceptance:
  - input docs and UI Reference examples apply Foundation Element color, spacing, typography, icon, and theme rules
  - examples include default, variant, focus, hover-capable, disabled, read-only, validation, and loading states where applicable
  - queued gaps remain explicit where final component behavior is not yet implemented

### P2-F-CQ-035 - T1 component family depth pass: selection controls
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Checkbox, Radio button, Toggle, and Content switcher T1 pages.
- Acceptance:
  - checkbox versus radio usage is visually demonstrated
  - selection group states, orientation variants, disabled/read-only states, validation states, and helper text are represented
  - content switcher remains queued or receives concrete examples according to accepted app need

### P2-F-CQ-036 - T1 component family depth pass: feedback and loading
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Notification, Tag, AI label, Inline loading, Loading, Progress bar, and Progress indicator T1 pages.
- Acceptance:
  - semantic status and loading examples use current token standards
  - AI label remains gated unless a real AI-assisted feature exists
  - loading and progress pages distinguish spinner, inline loading, skeleton, determinate, and step-progress expectations

### P2-F-CQ-037 - T1 component family depth pass: overlays and help
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Accordion, Modal, Popover, Tooltip, and Toggletip T1 pages.
- Acceptance:
  - overlay/help docs and UI Reference examples distinguish blocking, contextual, non-interactive, and interactive disclosure
  - examples show focus, hover, disabled, open/closed, dismiss, and reduced-motion expectations where applicable
  - popover remains queued unless a concrete consumer exists

### P2-F-CQ-038 - T1 component family depth pass: data display
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Data table, Pagination, Structured list, List, Contained list, Tile, and Tree view T1 pages.
- Acceptance:
  - data display pages show concrete variants, states, spacing behavior, and T2 consumption links
  - pagination and structured-list coverage remains visual and implementation-oriented
  - queued data-display gaps include trigger conditions

### P2-F-CQ-039 - T1 component family depth pass: navigation and shell
- Status: Closed
- Closed reason: Superseded by P2-F-CQ-128, P2-F-CQ-129, and component-specific recovery queue items.
- Owner: Batch F
- Depends On: P2-F-CQ-066 through P2-F-CQ-070
- Scope: Deepen Breadcrumb, Tabs, and UI shell T1 pages.
- Acceptance:
  - tabs include line, contained, vertical, icon-leading, icon-only, overflow/scroll, selected, focus, and disabled states
  - UI shell remains one family with Login-specific header, left panel, and right panel guidance as subsections
  - navigation pages link to T2 pattern composition owners where primitives are consumed

### P2-F-CQ-016 - Carbon component inventory and T1 disposition map
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Create a UI Reference inventory matrix for the full Carbon component list and classify each component for Login App 2.0 as `Implement T1 Page`, `Represent As T2 Pattern`, `Queued Gap`, or `Not Applicable Yet`.
- Acceptance:
  - every Carbon component named in the review plan has a Login App 2.0 disposition
  - each disposition identifies the owner route or trigger condition
  - Carbon remains a completeness benchmark only and does not introduce Carbon visual tokens
- Implemented in: worklog-2-F-0016

### P2-F-CQ-017 - UI Reference T1 component menu architecture
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Replace the three combined Component Library links with a catalog-driven expandable T1 Components menu and keep T2 Pattern Standards separate.
- Acceptance:
  - sidebar and overview consume one component catalog source
  - tests prove cataloged T1 entries appear in navigation and are routable
  - legacy combined routes are no longer the primary navigation surface
- Implemented in: worklog-2-F-0016

### P2-F-CQ-018 - Split existing combined T1 pages
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Add primary T1 pages for existing primitives currently combined across actions, status, forms, overlays, and utility examples.
- Acceptance:
  - component pages exist for button, icon button, menu item, badge/tag, status, text input, textarea, select, checkbox, radio button, toggle, searchable select, date input, file input, link, divider, icon, tooltip, toggletip, loading/spinner, modal, drawer, and notification
  - notifications may remain grouped as one T1 page for inline, toast, actionable, callout/banner, and persisted handoff
  - T2 pages compose or link to T1 owners instead of acting as the only primitive owner
- Implemented in: worklog-2-F-0016

### P2-F-CQ-019 - Missing input/control components
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Add missing input/control component pages for number input, slider, dropdown, search, progress bar, and progress indicator.
- Acceptance:
  - number input includes default/fluid variants, stepper controls, min/max/step guidance, error/warning inline status icon, disabled, read-only, focus, and keyboard behavior
  - each missing control has concrete examples or an explicit queued implementation contract
- Implemented in: worklog-2-F-0016

### P2-F-CQ-020 - Selection component depth pass
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Expand checkbox and radio button representation into separate T1 pages with usage boundaries and states.
- Acceptance:
  - radio shows vertical/horizontal groups, selected/unselected, focus, disabled, read-only, error, warning, helper text, group states, and single-select-only rule
  - checkbox shows independent choice, multi-select group, checked/unchecked/indeterminate where supported or queued, disabled, read-only, error, and warning
  - checkbox vs radio usage is demonstrated, not only described
- Implemented in: worklog-2-F-0016

### P2-F-CQ-021 - Data display T1 expansion
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Add dedicated T1 pages or dispositions for data table, pagination, structured list, list, contained list, tile, and tree view.
- Acceptance:
  - structured list includes default/selectable, condensed/default density, hang/flush alignment where supported, selected/focus/disabled/skeleton states
  - pagination includes full pagination, compact nav, page-size selector, overflow, disabled prev/next, size pairings, and placement below related content
  - T2 Data + Content and Tables consume/link to T1 owners instead of owning primitive standards
- Implemented in: worklog-2-F-0016

### P2-F-CQ-022 - Navigation/action primitives depth pass
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Add or deepen breadcrumb, tabs, menu, menu buttons, content switcher, popover, accordion, and UI shell header/left/right T1 pages.
- Acceptance:
  - tabs include line, contained, vertical, icon-leading, icon-only, overflow/scroll, selected/focus/disabled, and tab-vs-progress/comparison guidance
  - menu includes action items, sizing, alignment, selected/current, disabled, danger, dividers, submenu boundary, keyboard/mouse expectations
  - Navigation + Actions becomes a T2 composition page only
- Implemented in: worklog-2-F-0016

### P2-F-CQ-023 - Low-applicability Carbon items and future gates
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Decide and document Login-specific treatment for AI label and code snippet and ensure no Carbon component remains unmapped.
- Acceptance:
  - AI label and code snippet have explicit dispositions and trigger conditions
  - speculative UI is not built for low-applicability components
  - no Carbon component is silently ignored
- Implemented in: worklog-2-F-0016

### P2-F-CQ-024 - T1 route, test, docs, and handoff cleanup
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
- Owner: Batch F
- Scope: Add route/sidebar/catalog tests, update overview/checklist/active docs, and validate the full T1 component reference update.
- Acceptance:
  - every T1 sidebar route has automated coverage
  - overview and active docs reflect the new T1 component library model
  - focused UI Reference tests, build, docs guardrails, and browser review pass
- Implemented in: worklog-2-F-0016

### P2-F-CQ-012 - UI control module ownership cleanup
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
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
- Status: Closed
- Closed reason: Superseded by later Component UI Reference/API standards work and current component proof/recovery queue items.
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
