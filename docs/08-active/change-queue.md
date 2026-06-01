# Change Queue

Use this file as the agent-managed canonical queue for active-batch implementation work.

### Rules:
- Discuss exploratory review findings in chat first; only normalized implementation-ready items belong here.
- Active items in `Ready To Implement`, `In Progress`, and `Implemented Pending Review` use stable `ID:` values in the format `P<phase>-<batch>-CQ-###`.
- Keep `Iteration:` separate from the stable ID when an item is reopened or refined.
- Continuation lines such as `Scope:`, `Path Coverage:`, `Implemented in:`, `Follow-up To:`, and `Supersedes:` are for traceability only.
- This queue is agent-managed and implementation-ready, not a scratchpad for exploratory discussion.
- Exploratory review discussion stays in chat until it is normalized into concise queue language.

## Ready To Implement

## In Progress

## Implemented Pending Review
- [ ] Replace the free-text `Default Timezone` and `Default Locale` examples with searchable option-backed selectors on the form-pattern proof and touched localization proof surfaces; keep validator-driven examples on true free-entry fields such as email address and phone number instead of using locale/timezone as text-input validation demos.
  ID: P2-B-CQ-001
  Scope: Tier 2 form patterns, localization defaults, account preference localization fields
  Path Coverage: `/platform/ui-reference/patterns/forms`, `/platform/settings/general`, `/account/preferences`
  Implemented in: `2-B-0011`
- [ ] Repair the `Key Value Display` read-only detail proof so linked/value content renders correctly instead of leaking broken inline markup into the UI Reference output.
  ID: P2-B-CQ-002
  Scope: Tier 2 data/content patterns, read-only detail proof
  Path Coverage: `/platform/ui-reference/patterns/data-content`
  Implemented in: `2-B-0011`
- [ ] Clarify the Tier 2 proof-page intent so examples read as intentional library demonstrations instead of ambiguous mockups; make the `Search And Filter Bar` proof explicit about what the search input, filter select, and actions represent, and add stronger on-page descriptors where component behavior or scope is otherwise unclear.
  ID: P2-B-CQ-003
  Scope: Tier 2 proof-page clarity, search/filter pattern guidance, on-page usage notes
  Path Coverage: `/platform/ui-reference/patterns/navigation`, related Tier 2 proof pages where intent is unclear
  Implemented in: `2-B-0011`
- [ ] Make the grouped-actions dropdown action menu close when focus or pointer interaction moves outside the open menu, and treat that outside-click dismissal as the shared default behavior for this pattern instead of a page-by-page expectation.
  ID: P2-B-CQ-004
  Scope: Tier 2 dropdown action menu behavior, shared dismissal contract
  Path Coverage: shared `dropdown-action-menu` pattern, current UI Reference grouped-action proofs
  Implemented in: `2-B-0012`
- [ ] Expand the dashboard widget layout contract so widget sizing is defined by an explicit reusable span model instead of an overly narrow fixed-size convention; document and prove the allowed grid-span combinations intentionally rather than assuming only `1x1` through `2x2` cards.
  ID: P2-B-CQ-005
  Scope: dashboard grid sizing contract, widget shell span rules, dashboard proof coverage
  Path Coverage: shared `dashboard-grid` pattern, layout/dashboard proof surfaces, widget-shell guidance
  Implemented in: `2-B-0012`
- [ ] Establish the dashboard widget shell contract explicitly so Batch B defines what a reusable internal widget may contain and how dense it is allowed to become; document the allowed widget regions, content combinations, and fallback states instead of leaving widget structure implied by stat cards alone.
  ID: P2-B-CQ-006
  Scope: widget shell anatomy, density constraints, allowed content regions, widget proof coverage
  Path Coverage: dashboard/layout proof surfaces, widget-shell guidance, related handoff artifacts
  Implemented in: `2-B-0012`
- [ ] Establish a canonical Tier 1 date and date-time selection baseline so internal forms stop improvising calendar/date controls ad hoc; define the default control form, validation expectations, and proof coverage for reusable date entry.
  ID: P2-B-CQ-007
  Scope: Tier 1 date/date-time input baseline, reusable date selection proof coverage
  Path Coverage: UI Reference control/forms surfaces, future settings/setup/account form reuse
  Implemented in: `2-B-0012`
- [ ] Establish a reusable Tier 2 date-filter and date-range pattern built from the shared date baseline so list/index and reporting surfaces can expose time-based filtering without inventing one-off control rows.
  ID: P2-B-CQ-008
  Scope: Tier 2 date filtering controls, range selection pattern, list/report filter reuse
  Path Coverage: UI Reference navigation/tables/archetype proofs, future reporting/list surfaces
  Implemented in: `2-B-0012`
- [ ] Establish a reusable Tier 2 profile or identity summary card pattern for internal account/operator summaries so avatar, name, supporting metadata, statuses, and optional actions are standardized instead of assembled ad hoc from key-value or list blocks.
  ID: P2-B-CQ-009
  Scope: Tier 2 identity summary pattern, account/profile card anatomy, avatar/meta/action composition
  Path Coverage: account/profile proofs, future operator/customer summary surfaces
  Implemented in: `2-B-0012`
- [ ] Retune the sub-navigation bar active state so the current item is clearly readable in both dark and light mode; use a more visible soft neutral active treatment instead of the current barely perceptible state.
  ID: P2-B-CQ-010
  Scope: Tier 2 sub-navigation active-state treatment, shared navigation readability
  Path Coverage: shared `sub-navigation-bar` pattern, current settings/setup/navigation proofs
  Implemented in: `2-B-0012`
- [ ] Fix the grouped-actions dropdown action menu layering so the open panel can render above surrounding cards and containers without being clipped by content-section or card borders.
  ID: P2-B-CQ-011
  Scope: Tier 2 dropdown action menu overlay layering, clipping and stacking behavior
  Path Coverage: shared `dropdown-action-menu` pattern, current grouped-action proofs inside content-section blocks
  Implemented in: `2-B-0012`

## Blocked

## Deferred

## Passed Review

## Closed
