# Active Batch

## Name
Phase 2 - Implementation Batch F

## Metadata
- Phase: 2
- Batch: F
- Worklog Prefix: `2-F`

## Source
- [Phase 2 - Implementation Batch F](../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20F.md)
- [Phase 2 - Final Stack And UI System Planning](../07-planning/phases/phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

## Objective
Complete the internal page archetype starter-proof layer required before Phase 2 close-out. Turn the existing Tier 1/Tier 2 UI system and Batch B archetype rules into concrete, reviewable starter-page examples that later phases can consume without inventing new visual structure.

## In Scope
- UI Reference page archetype starter examples
- starter-proof coverage for module home, settings, setup/configuration, account/profile, list/index, table-management index, operational log/detail, content browser/split-view, detail/read-only, create/edit form, dashboard/module-summary, and blocked/empty/unavailable state surfaces
- Carbon-informed UI Reference audit for missing usage guidance, variants, states, and standard action/feedback rules
- adoption of existing Tier 1 primitives and Tier 2 patterns inside starter examples
- limited normalization of current permanent/proof surfaces where needed to validate starter parity
- UI Reference navigation and automated coverage updates needed to make starter examples locatable and testable
- documentation updates that synchronize Phase 2 planning, handoff readiness, and Batch E entry gates

## Out Of Scope
- staging deploy
- new feature delivery
- account feature expansion from Batch C
- notifications feature expansion from Batch D
- new business modules
- customer/public shell implementation
- new UI-system rules unless implementation exposes a documented standards gap
- broad redesign of existing platform surfaces
- final Phase 2 close-out decision

## Deliverables
1. UI Reference exposes concrete starter-page examples for the required archetypes
2. Existing proof surfaces are normalized only where needed to demonstrate starter parity
3. Automated coverage confirms starter examples are routable and visible
4. Phase 2 planning and handoff references identify Batch F as the required pre-closeout implementation batch
5. Batch E entry gates are updated so close-out resumes only after Batch F is complete
6. Staging deploy remains explicitly out of scope

## Validation Surface
Required starter proofs:
- module home / module overview
- settings page
- setup / configuration page
- account / profile read-only page
- account / profile editable settings or preferences page
- list / index page
- table-management index page
- operational log/detail page
- content browser / split-view page
- detail / read-only page
- create / edit form page
- dashboard/module summary surface, including widget-shell and summary/stat-card usage
- dashboard widget size examples by module content type
- empty / unavailable / permission-blocked page state

Priority permanent/proof surfaces:
- `/platform/ui-reference`
- `/platform/ui-reference/patterns/archetypes`
- `/platform/ui-reference/patterns/widget-content/*`
- `/platform/settings/*`
- `/platform/setup/*`
- `/account`, `/account/settings`, and `/account/preferences`
- selected platform-owned list/detail/form proof surfaces where needed for starter parity

## Entry Gates
- Batch A: complete
- Batch B: complete
- Batch E: paused before final readiness
- staging deploy: disabled pending security incident review
