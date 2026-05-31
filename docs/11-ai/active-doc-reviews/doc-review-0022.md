# Document Review 0022

## Review Pass
2

## Target
`docs/07-planning/roadmap.md`, the active Phase 2 Batch B planning set, and the linked Phase 3/Phase 4 planning notes that inherit the Phase 2 UI-system handoff

## Review Type
Document Review

## Status
CLOSED

## Purpose
Tighten the remaining Phase 2 UI-system lane so it explicitly leaves behind the reusable internal shells, page/module scaffolding, dashboard widget-shell conventions, setup/settings registration rules, and future-module UI ownership requirements that later phases already assume. This review also makes the Phase 3 planning set explicitly carry customer account-creation/enrollment policy milestones, Google/Microsoft OAuth baseline direction, and shared app-mailer/Microsoft Graph configuration milestones so the customer/public foundation is not under-scoped.

## Scope
- `docs/07-planning/roadmap.md`
- `docs/07-planning/phases/phase-2/Phase 2 - Final Stack And UI System Planning.md`
- `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md`
- `docs/07-planning/phases/phase-2/Phase 2 - Batch B Implementation Prep.md`
- `docs/07-planning/phases/phase-3/Phase 3 - Customer And Public View Planning.md`
- `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`
- `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`
- `docs/07-planning/phases/phase-4/Phase 4 - Remaining Core Module Planning.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0022.md`

## Findings

### Finding 1
- type: underdefined-phase-2-handoff
- location: `docs/07-planning/roadmap.md`, `docs/07-planning/phases/phase-2/Phase 2 - Final Stack And UI System Planning.md`, `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md`
- issue: Phase 2 was described as the final stack/UI-system introduction, but the planning set did not explicitly require the internal shell families, page/module scaffolding archetypes, dashboard widget shells, setup/settings registration conventions, and future-module UI ownership rules that later phases already depend on.
- required action: Make those outputs explicit in the roadmap, the Phase 2 lane note, and Batch B so Phase 2 closes with a reusable internal UI system rather than only polished current pages.
- constraints: Keep customer/public shells and feature-specific behavior in later phases; do not invent new later-batch sequencing in this pass.
- decision state: resolved

### Finding 2
- type: batch-b-scope-misalignment
- location: `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md`, `docs/07-planning/phases/phase-2/Phase 2 - Batch B Implementation Prep.md`
- issue: Batch B still read like a loose shared-surface convergence pass rather than the concrete Tier 2/internal-scaffolding implementation handoff the roadmap and later phases actually need.
- required action: Reframe Batch B around the Tier 2 internal library, shell-family standards, page/module archetypes, dashboard widget/stat shells, setup/settings registration expectations, and future-module UI ownership handoff requirements.
- constraints: Preserve the current batch naming and do not introduce new Batch C/D sequencing decisions in this review.
- decision state: resolved

### Finding 3
- type: underdefined-phase-3-access-and-mailer-milestones
- location: `docs/07-planning/phases/phase-3/Phase 3 - Customer And Public View Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`
- issue: The Phase 3 planning set already covered customer/public contracts, OAuth, and Microsoft Graph, but it did not make customer account-creation pathways, enrollment vocabulary, and shared app-mailer configuration explicit enough as major milestones.
- required action: Add customer account-creation/enrollment standards, clarify the Google/Microsoft-first but extensible provider policy model, and make shared app-mailer configuration direction explicit alongside the Microsoft Graph provider contract.
- constraints: Keep this as milestone/contract planning only; do not lock detailed UX for each pathway in this pass.
- decision state: resolved

### Finding 4
- type: phase-4-hidden-phase-2-dependencies
- location: `docs/07-planning/phases/phase-4/Phase 4 - Remaining Core Module Planning.md`
- issue: Phase 4 already depended on module scaffolding and design-system baseline, but it did not explicitly inherit the concrete internal shell/scaffolding outputs that Phase 2 must leave behind.
- required action: Make Phase 4 entry criteria and planning assumptions explicitly depend on internal shell-family standards, page/module archetypes, dashboard widget/stat-shell rules, and setup/settings registration conventions from Phase 2.
- constraints: Keep Phase 4 focused on module rollout, not on re-owning the Phase 2 UI-system work.
- decision state: resolved

### Finding 5
- type: cross-phase-link-drift
- location: `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`, `docs/07-planning/phases/phase-4/Phase 4 - Remaining Core Module Planning.md`
- issue: Related-link references in the touched planning notes had broken relative-link formatting, making the planning chain harder to navigate reliably.
- required action: Repair the broken related links while updating the same planning set.
- constraints: Keep link corrections scoped to the touched files.
- decision state: resolved

## Summary
- Phase 2 now explicitly owns the reusable internal UI-system handoff that later phases depend on, not just current-surface cleanup.
- Batch B now reads as the implementation batch for Tier 2 internal patterns plus shell/scaffolding standards, without requiring new phase-batch sequencing decisions now.
- Phase 3 now explicitly includes customer account-creation/enrollment policy milestones, extensible Google/Microsoft OAuth direction, and shared app-mailer configuration direction alongside the Graph provider contract.
- Phase 4 now names the concrete UI-system handoff artifacts it expects from Phase 2 instead of depending on an underspecified “design-system baseline.”

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- Phase 2 explicitly owns the internal shell/scaffolding outputs that later phases depend on
- Batch B deliverables and exit criteria reflect the Tier 2/internal-scaffolding handoff rather than only vague convergence language
- Phase 3 explicitly carries customer account-creation/enrollment and shared app-mailer planning milestones
- Phase 4 explicitly depends on the concrete Phase 2 UI-system outputs it will consume
- touched planning docs link cleanly across the Phase 2/3/4 handoff chain

## Resolution Notes
- Updated the roadmap and Phase 2 planning lane to make the internal shell families, page/module archetypes, widget-shell conventions, setup/settings registration rules, and UI ownership declaration requirements explicit.
- Reframed Batch B and its prep note around the reusable internal Tier 2 library plus the internal shell/scaffolding handoff, while keeping later batch sequencing out of scope for this pass.
- Updated the Phase 3 customer/public planning set to include customer account-creation/enrollment standards, a Google/Microsoft-first but extensible OAuth provider model, and shared app-mailer configuration direction alongside Microsoft Graph.
- Updated Phase 4 planning to name the specific Phase 2 UI-system outputs its module batches must inherit before coding.
- Follow-up re-review found no remaining drift in the scoped planning set.
