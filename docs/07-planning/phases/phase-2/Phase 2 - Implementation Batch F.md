# Phase 2 - Implementation Batch F

This document defines the canonical scope and intent for Phase 2 - Implementation Batch F.

## Purpose

Complete the internal page archetype starter-proof layer required before Phase 2 close-out.

Batch F exists because Batch E close-out preflight identified a handoff-readiness gap: Phase 2 planning requires future Phase 3 and Phase 4 work to consume established shell families and page/module scaffolding, but the current UI Reference archetype coverage is not yet sufficient as a concrete starter-page catalog.

## Planning Owner

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

## Canonical Owners

* [UI Design System Standards](../../../02-standards/ui/UI%20Design%20System%20Standards.md)
* [Tier 2 Pattern Library Checklist](../../../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)
* [Phase 2 Batch B - Internal Shell Family Rule Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Internal%20Shell%20Family%20Rule%20Matrix.md)
* [Phase 2 Batch B - Page And Module Archetype Matrix](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)
* [Phase 2 Batch B - Setup And Settings Registration Field Contract](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Setup%20And%20Settings%20Registration%20Field%20Contract.md)
* [Phase 2 Batch B - Future Module UI Ownership Declaration Field Contract](../../../09-reference/ui/Phase%202%20Batch%20B%20-%20Future%20Module%20UI%20Ownership%20Declaration%20Field%20Contract.md)

## Batch Goal

Turn the existing Tier 1/Tier 2 UI system and Batch B archetype rules into concrete, reviewable starter-page examples that later phases can copy conceptually without inventing new visual structure.

The batch should answer one implementation-readiness question: can a future module plan name a shell family and page/module archetype, then open UI Reference and find a complete starter example for that surface type?

## In Scope

* UI Reference page archetype starter examples
* starter-proof coverage for module home, settings, setup/configuration, account/profile, list/index, detail/read-only, create/edit form, and dashboard/module-summary surfaces
* adoption of existing Tier 1 primitives and Tier 2 patterns inside those starter examples
* limited normalization of current permanent/proof surfaces where needed to validate the starter contract
* UI Reference navigation and automated coverage updates needed to make starter examples locatable and testable
* documentation updates that synchronize Phase 2 planning, handoff readiness, and Batch E entry gates

## Out Of Scope

* staging deploy
* new feature behavior
* account feature expansion from Batch C
* notifications feature expansion from Batch D
* new business modules
* customer/public shell implementation
* new UI-system rules unless implementation exposes a documented standards gap
* broad redesign of existing platform surfaces
* final Phase 2 close-out decision

## Required Starter Proofs

Batch F must leave reviewable starter coverage for:

1. Module home / module overview.
2. Settings page.
3. Setup / configuration page.
4. Account / profile read-only page.
5. Account / profile editable settings or preferences page.
6. List / index page.
7. Detail / read-only page.
8. Create / edit form page.
9. Dashboard/module summary surface, including widget-shell and summary/stat-card usage.

## Starter Proof Requirements

Each starter proof should demonstrate:

* page title/actions placement
* shell-family inheritance
* primary Tier 2 pattern composition
* action placement
* empty state where the archetype commonly needs it
* validation/error placement where forms are involved
* responsive behavior where layout materially changes
* route or UI Reference location that reviewers and future agents can find intentionally

## Permanent / Proof Surface Alignment

Batch F may touch existing permanent or proof surfaces only when doing so validates the starter-page contract without changing feature behavior.

Priority alignment surfaces:

* `/platform/ui-reference/patterns/archetypes`
* `/platform/ui-reference/patterns/widget-content/*`
* `/platform/settings/*` where used as settings starter proof
* `/platform/setup/*` where used as setup starter proof
* `/account`, `/account/settings`, and `/account/preferences` where used as account/profile starter proof
* selected platform-owned list/detail/form proof surfaces when needed for list, detail, or create/edit starter parity

## Implementation Guardrails

* Use existing Tier 1 primitives and Tier 2 patterns.
* Do not create feature-specific workflows to make a starter look complete.
* Do not treat starter examples as production feature delivery.
* If a starter cannot be built from existing Tier 1/Tier 2 contracts, document the standards gap before adding new implementation rules.
* Keep UI Reference examples concrete enough for future module work, but generic enough to remain reusable.
* Do not deploy to staging during this batch while staging deployment is disabled pending security incident review.

## Required Deliverables

1. Batch F active workspace is initialized and implementation queue items are ready.
2. UI Reference exposes concrete starter-page examples for the required archetypes.
3. Existing proof surfaces are normalized only where needed to demonstrate starter parity.
4. Automated coverage confirms starter examples are routable and visible.
5. Phase 2 planning and handoff references identify Batch F as the required pre-closeout implementation batch.
6. Batch E entry gates are updated so close-out resumes only after Batch F is complete.
7. Staging deploy remains explicitly out of scope.

## Entry Gates

* Batch A is complete.
* Batch B is complete.
* Batch E close-out has not earned final readiness.
* Staging deploy remains disabled pending security incident review.

## Exit Criteria

This batch is complete when:

* every required starter proof is visible and test-covered
* starter examples demonstrate existing Tier 1/Tier 2 composition rather than feature-specific behavior
* current proof surfaces used by the starter contract no longer show avoidable visual drift from the standard shell/pattern conventions
* Phase 3 and Phase 4 can consume the starter catalog without reopening Phase 2 UI decisions
* Batch E can resume as staging deploy and visual QA close-out only

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Implementation Batch A](Phase%202%20-%20Implementation%20Batch%20A.md)
* [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
* [Phase 2 - Implementation Batch E](Phase%202%20-%20Implementation%20Batch%20E.md)
* [Phase 3 - Customer And Public View Planning](../phase-3/Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Phase 4 - Remaining Core Module Planning](../phase-4/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
