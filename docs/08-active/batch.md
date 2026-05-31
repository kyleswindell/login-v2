# Active Batch

## Name
Phase 2 - Implementation Batch B

## Metadata
- Phase: 2
- Batch: B
- Worklog Prefix: `2-B`

## Source
- [Phase 2 - Implementation Batch B](../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20B.md)
- [Phase 2 - Batch B Implementation Prep](../07-planning/phases/phase-2/Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)

## Objective
Implement the remaining Tier 1 library hardening required for safe reuse, then deliver the reusable Tier 2 internal UI library and the internal app-surface scaffolding standards that later phases will consume.

## In Scope
- implement the promoted Tier 1 Blade-component candidates listed in the Batch B prerequisite:
  - Button
  - Icon Button
  - Toast baseline
  - Inline alert baseline
  - Drawer baseline
  - Modal baseline
- implement the required Tier 2 internal patterns using existing Tier 1 primitives
- define internal shell family standards for dashboard, app shell, setup, settings, and account/profile surfaces
- define reusable page/module scaffolding archetypes for dashboard, list/detail, form, setup, and settings surfaces
- establish dashboard widget-shell and summary/stat-card conventions
- define setup/settings registration conventions for future modules
- define future-module UI ownership declaration requirements for later phases
- converge shared layout behavior across dashboard and shell-owned proof surfaces where needed to validate the internal library/scaffolding direction
- implement operator table and filter pattern work only where those surfaces are already in current platform-owned scope
- align responsive behavior for dashboard, setup, settings, and shell proof surfaces
- complete limited route and navigation cleanup required for the converged internal shell direction
- update UI Reference and planning notes for touched Tier 1 promotions, Tier 2 patterns, and internal scaffolding outputs

## Out of Scope
- creation of new UI standards
- creation of new Tier 1 primitives beyond the explicitly promoted Tier 1 Blade-component candidates already directionally approved
- account feature behavior
- notifications feature behavior
- notification persistence or realtime redesign
- messaging
- platform-users Filament migration strategy
- final panel option selection
- auth guard/session redesign
- final `/console` proof-route retirement decision
- staging deploy and visual QA

## Required Deliverables
- [ ] Promoted Tier 1 Blade-component candidates implemented with reviewable proof coverage before broader Tier 2 implementation closes
- [ ] Required Tier 2 patterns implemented and represented in UI Reference
- [ ] Internal shell family standards explicit for dashboard, app shell, setup, settings, and account/profile surfaces
- [ ] Reusable page/module scaffolding archetypes explicit for dashboard/overview, list/detail, form, setup, and settings surfaces
- [ ] Dashboard widget-shell and summary/stat-card conventions explicit enough for later modules to reuse
- [ ] Setup/settings registration conventions and future-module UI ownership declaration requirements explicit for later phases
- [ ] Proof-touch scope explicit for dashboard, shell, setup, settings, account/profile, and any conditional operator-table surfaces
- [ ] Route and navigation cleanup stays inside the documented ownership boundary
- [ ] Verification scope defined for desktop, mobile, navigation, responsive layout, promoted Tier 1 candidates, touched Tier 2 patterns, and internal shell/scaffolding outputs
- [ ] Proof-page coverage explicit for promoted Tier 1 proofs, required Tier 2 pattern pages, and archetype proof surfaces

## Validation Surface
- promoted Tier 1 action, feedback, and overlay entry points normalized first
- desktop and mobile shell behavior on touched surfaces
- shell-family consistency across dashboard, setup, settings, and account/profile proof surfaces
- page/module scaffolding consistency across dashboard, list/detail, form, setup, and settings proof surfaces
- dashboard widget-shell and summary/stat-card consistency where adopted
- page-title, action-row, section, and card consistency where adopted
- operator table/search/filter parity where touched
- dashboard layout and widget-shell consistency
- settings and setup responsive layout consistency
- shell-owned notification preview parity after any shell framing updates
- setup/settings registration and future-module UI ownership requirements documented clearly enough for later phases
- confirmation that no feature behavior or panel-architecture decisions were introduced implicitly
