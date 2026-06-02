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
- [ ] Fix the Layout + Dashboard multi-row widget proof so `1x2`, `2x2`, and other two-row widgets are reviewable at their true grid spans; the proof must keep the expected widget width variants in place and must demonstrate that taller widgets reserve and occupy two full rows without being compressed or hidden by following widgets.
  ID: P2-B-CQ-018
  Iteration: 3
  Scope: enforced dashboard row-span occupancy, non-overlapping dense grid placement, true two-row widget height, visible multi-row proof integrity, reviewable widget-size examples
  Path Coverage: `/platform/ui-reference/patterns/layout`, `/platform/ui-reference/patterns/archetypes`, shared dashboard/widget-shell proof surfaces where taller spans should be judged in context
  Follow-up To: P2-B-CQ-005, P2-B-CQ-006
  Implemented in: `2-B-0038`
- [ ] Repair the Layout + Dashboard customization proof after the failed `2-B-0038` pass by preserving the approved save behavior, drag/move sorting preview, and full main-content-width dashboard proof container while restoring correct widget grid-size examples for `1x1`, `2x1`, `1x2`, `2x2`, and `3x1`; each widget example must include legible header/title and body/supporting content without converting every example into a full-row card.
  ID: P2-B-CQ-019
  Iteration: 6
  Scope: UI Reference-first dashboard customization proof layout, approved full-width dashboard composition, approved save/reorder proof behavior, correct widget grid-size examples, widget-card header/body content examples, responsive widget-card default integrity
  Path Coverage: `/platform/ui-reference/patterns/layout` as the canonical review surface, shared dashboard/widget shell layout defaults that affect proof-card content structure, proof drag/reorder interaction model, `/dashboard` only as downstream consumer validation after the proof surface is correct
  Follow-up To: P2-B-CQ-006, P2-B-CQ-018
  Implemented in: `2-B-0038`
- [ ] Remove the unapproved `ui-soft-card*` full-card palette treatment from the Layout + Dashboard proof and return proof widgets, saved-layout preview, support cards, and explanatory proof blocks to the approved default neutral card/surface or existing alert/notice/status treatments; the current-item/menu-state label colorways from Buttons + Icons must not be reused as full dashboard card palettes unless a separate UI Reference proof is explicitly created and approved.
  ID: P2-B-CQ-020
  Iteration: 3
  Scope: default shared widget-card palette, default supporting info-card palette, removal of unapproved `ui-soft-card*` full-card surfaces, semantic-only alert/notice/status usage, legible header/body/supporting text treatments
  Path Coverage: shared card/surface primitives or support classes that own default and semantic card presentation, UI Reference Layout + Dashboard proof surfaces, saved-layout preview widgets, supporting proof/info cards on the dashboard proof page, UI Reference action/menu current-state labels as a non-card contrast reference
  Follow-up To: P2-B-CQ-019
  Implemented in: `2-B-0038`
## In Progress

## Implemented Pending Review
- [ ] Resynchronize the temporary active-batch proof review mode so it reflects the live queue state exactly; only current `Implemented Pending Review` items should appear in page banners and scoped card targets, reopened or passed IDs must drop out immediately, and every current pending-review item with a visible proof surface must be tagged accurately at the point of review.
  ID: P2-B-CQ-013
  Iteration: 4
  Scope: temporary active-batch proof review mode, derived runtime manifest synchronization, live queue-state alignment, full current pending-review coverage, stale active-review target removal
  Path Coverage: active-batch UI Reference proof pages, all current `Implemented Pending Review` items with visible proof surfaces, relevant component library cards under review, current review-mode entry points
  Implemented in: `2-B-0028`
- [ ] Apply the established Tier 1 action/menu-item suite to the account dropdown header menu so the theme-mode options and account actions stop using outdated local option styling; the active and hover theme option should use the shared outline-neutral treatment, the sign-out action should use the shared ghost-danger treatment, and the account-menu text color should match the current shared menu-item contract while preserving the existing layout.
  ID: P2-B-CQ-015
  Iteration: 2
  Scope: account-menu action styling, theme-option state styling, shared outline-neutral and ghost-danger consumption, dropdown option typography/color consistency
  Path Coverage: shared account dropdown in the app shell header, theme-mode option row, account-menu action list, sign-out action treatment
  Follow-up To: P2-B-CQ-014, P2-B-CQ-016
  Implemented in: `2-B-0036`

## Blocked

## Deferred

## Passed Review
- [x] Refine the Tier 1 searchable dropdown-select baseline so the shared searchable control matches the canonical select-field shell across spacing, typography, trigger/menu border treatment, and Inputs And Forms proof coverage while still presenting one integrated searchable dropdown with one intentional current-selection treatment.
  ID: P2-B-CQ-001
  Iteration: 4
  Scope: Tier 1 searchable dropdown-select baseline, select-family visual parity, current-selection treatment, shared Inputs And Forms dropdown standard
  Path Coverage: `/platform/ui-reference/patterns/forms`, shared `inline-form-row` and `searchable-select` entry points, `/platform/settings/general`, `/account/preferences`
  Implemented in: `2-B-0019`
- [x] Normalize the Tier 2 proof-note treatment so explanatory library guidance is presented through one clearly defined shared notice style instead of a mix of subtle in-card text blocks and stronger top-of-page notices; proof-only notes should read clearly as library guidance rather than component UI, and the treatment should be used consistently wherever intended behavior or scope needs explanation.
  ID: P2-B-CQ-003
  Iteration: 2
  Scope: Tier 2 proof-page clarity, shared proof-note styling, explanation of intended behavior and scope
  Path Coverage: `/platform/ui-reference/patterns/*`, related proof surfaces where explanatory notes appear
  Implemented in: `2-B-0013`
- [x] Make the grouped-actions dropdown action menu close when focus or pointer interaction moves outside the open menu, and treat that outside-click dismissal as the shared default behavior for this pattern instead of a page-by-page expectation.
  ID: P2-B-CQ-004
  Scope: Tier 2 dropdown action menu behavior, shared dismissal contract
  Path Coverage: shared `dropdown-action-menu` pattern, current UI Reference grouped-action proofs
  Implemented in: `2-B-0012`
- [x] Correct the shared dashboard row-span rendering so multi-row widgets actually render at the documented taller heights instead of collapsing to a single-row card; `1x2` and `2x2` proofs should visibly honor row-span height as part of the reusable widget span model.
  ID: P2-B-CQ-005
  Iteration: 2
  Scope: dashboard grid sizing contract, shared row-span rendering, multi-row widget proof behavior
  Path Coverage: shared `dashboard-grid` pattern, layout/dashboard proof surfaces, widget-shell guidance, `1x2` and `2x2` widget proofs
  Implemented in: `2-B-0018`
- [x] Establish the dashboard widget shell contract explicitly so Batch B defines what a reusable internal widget may contain and how dense it is allowed to become; document the allowed widget regions, content combinations, and fallback states instead of leaving widget structure implied by stat cards alone.
  ID: P2-B-CQ-006
  Scope: widget shell anatomy, density constraints, allowed content regions, widget proof coverage
  Path Coverage: dashboard/layout proof surfaces, widget-shell guidance, related handoff artifacts
  Implemented in: `2-B-0012`
- [x] Establish a canonical Tier 1 date and date-time selection baseline so internal forms stop improvising calendar/date controls ad hoc; define the default control form, validation expectations, and proof coverage for reusable date entry.
  ID: P2-B-CQ-007
  Scope: Tier 1 date/date-time input baseline, reusable date selection proof coverage
  Path Coverage: UI Reference control/forms surfaces, future settings/setup/account form reuse
  Implemented in: `2-B-0012`
- [x] Establish a reusable Tier 2 date-filter and date-range pattern built from the shared date baseline so list/index and reporting surfaces can expose time-based filtering without inventing one-off control rows.
  ID: P2-B-CQ-008
  Scope: Tier 2 date filtering controls, range selection pattern, list/report filter reuse
  Path Coverage: UI Reference navigation/tables/archetype proofs, future reporting/list surfaces
  Implemented in: `2-B-0012`
- [x] Retune the sub-navigation bar active state so the current item is clearly readable in both dark and light mode; use a more visible soft neutral active treatment instead of the current barely perceptible state.
  ID: P2-B-CQ-010
  Scope: Tier 2 sub-navigation active-state treatment, shared navigation readability
  Path Coverage: shared `sub-navigation-bar` pattern, current settings/setup/navigation proofs
  Implemented in: `2-B-0012`
- [x] Fix the grouped-actions dropdown action menu layering so the open panel can render above surrounding cards and containers without being clipped by content-section or card borders.
  ID: P2-B-CQ-011
  Scope: Tier 2 dropdown action menu overlay layering, clipping and stacking behavior
  Path Coverage: shared `dropdown-action-menu` pattern, current grouped-action proofs inside content-section blocks
  Implemented in: `2-B-0012`
- [x] Complete the Tier 1 ghost action variant parity pass so neutral ghost uses the same borderless baseline as the semantic ghost variants inside the shared action/menu-item suite; close this parity gap before downstream menu consumers are retuned.
  ID: P2-B-CQ-016
  Scope: Tier 1 ghost action variant parity, supported colorway suite consistency, light/dark consistency
  Path Coverage: shared `ui-action-ghost` primitive, supported standard colorway proofs, UI Reference action proofs, all consuming ghost-action surfaces
  Follow-up To: P2-B-CQ-014
  Implemented in: `2-B-0015`
- [x] Refine the Tier 1 action and menu-item component-library suite so supported menus also define the canonical current-item/selected-item state alongside the shared colorway contract; grouped-action and future consumer menus should not improvise their own current-item styling.
  ID: P2-B-CQ-014
  Iteration: 2
  Scope: Tier 1 action/menu-item colorway suite, current-item menu state, shared semantic/ghost action treatment, supported standard colorway proof coverage
  Path Coverage: shared Tier 1 action and menu-item entry points, supported standard colorway proofs, grouped-action UI Reference proof surfaces that validate the suite
  Implemented in: `2-B-0020`
- [x] Refine the Tier 1 internal phone-input baseline so formatting begins with the first typed digit instead of waiting for a complete ten-digit value; shared internal phone inputs should progressively render the canonical US national pattern during entry, with an explicit partial-entry display contract and full normalization to `(555) 555-5555` once all digits are present.
  ID: P2-B-CQ-017
  Iteration: 2
  Scope: Tier 1 internal phone-input as-you-type formatting baseline, partial-entry display contract, reusable phone entry normalization
  Path Coverage: `/platform/ui-reference/patterns/forms`, `/account/settings`, `/platform/settings/general-company-information`, shared phone-input entry points where adopted
  Implemented in: `2-B-0021`
- [x] Repair the `Key Value Display` read-only detail proof so linked/value content renders correctly instead of leaking broken inline markup into the UI Reference output.
  ID: P2-B-CQ-002
  Scope: Tier 2 data/content patterns, read-only detail proof
  Path Coverage: `/platform/ui-reference/patterns/data-content`
  Implemented in: `2-B-0011`
- [x] Refine the identity summary pattern so it supports multiple density variants instead of one overly busy default card; the current proof should establish lighter and fuller identity-summary options and clarify that the same pattern family can represent either a person or a company/entity summary when the required fields stay structurally similar.
  ID: P2-B-CQ-009
  Iteration: 2
  Scope: Tier 2 identity summary variants, person/company entity-summary flexibility, density guidance
  Path Coverage: `/platform/ui-reference/patterns/data-content`, `/platform/ui-reference/patterns/archetypes`, `/account`, future operator/customer/company summary surfaces
  Implemented in: `2-B-0013`
- [x] Improve the readability contract for compact metadata groups on Tier 2 summary/list surfaces so adjacent metadata items do not visually collapse into one sentence; establish a clearer separator/grouping treatment and reduce overuse of all-caps metadata where it harms scanability.
  ID: P2-B-CQ-012
  Scope: compact metadata readability, separators/grouping, typographic treatment on Tier 2 summaries and list rows
  Path Coverage: `identity-summary-card`, `data-list-item`, related summary/list proof surfaces
  Implemented in: `2-B-0013`

## Closed
