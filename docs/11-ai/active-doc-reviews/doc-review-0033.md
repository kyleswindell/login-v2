# Document Review 0033

## Review Pass
3

## Target
`docs/07-planning/roadmap.md`, `docs/07-planning/dependency-map.md`, `docs/07-planning/phases/phase-0/Phase 0 - Deployment And Environment Setup.md`, `docs/07-planning/phases/phase-1/Phase 1 - Platform Foundation Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - Customer And Public View Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`, and `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Align the newly established security standards with the appropriate implementation phases so planning clearly states where login hardening, secret-backed settings, security headers, transport/session hardening, and production hardening checks must land before Phase 3 external identity and Graph work begins.

## Scope
- `docs/07-planning/roadmap.md`
- `docs/07-planning/dependency-map.md`
- `docs/07-planning/phases/phase-0/Phase 0 - Deployment And Environment Setup.md`
- `docs/07-planning/phases/phase-1/Phase 1 - Platform Foundation Planning.md`
- `docs/07-planning/phases/phase-3/Phase 3 Index.md`
- `docs/07-planning/phases/phase-3/Phase 3 - Customer And Public View Planning.md`
- `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`
- `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0033.md`

## Findings

### Finding 1
- type: cross-phase-security-allocation-gap
- location: `docs/07-planning/roadmap.md`, `docs/07-planning/dependency-map.md`
- issue: The roadmap and dependency map now reference customer/public OAuth and Graph work, but they do not yet place the newly documented security implementation concerns into the correct phases. That leaves room for secret-backed settings, login anti-automation, or transport/browser hardening to be treated as optional later cleanup instead of as prerequisites.
- required action: Update the roadmap and dependency map so the security implementation split is explicit: Phase 0 follow-up owns deployment/runtime hardening and release verification gates, Phase 1 carry-forward owns current platform-auth hardening such as login abuse controls, and Phase 3 depends on those outputs plus secret-backed settings before OAuth or Graph implementation proceeds.
- constraints: Keep planning ownership limited to sequencing and intent. Do not restate standards or implementation detail verbatim in the roadmap.
- decision state: resolved

### Finding 2
- type: phase-0-and-phase-1-prerequisite-gap
- location: `docs/07-planning/phases/phase-0/Phase 0 - Deployment And Environment Setup.md`, `docs/07-planning/phases/phase-1/Phase 1 - Platform Foundation Planning.md`
- issue: Phase 0 currently treats hardening as a vague follow-up, and Phase 1 is marked complete without naming the current-platform-auth security carry-forward work that should be finished before outward-facing auth increases exposure.
- required action: Update Phase 0 planning to distinguish original deployment bootstrap from the now-required production-hardening follow-up lane, and update Phase 1 planning to record the carry-forward security corrections for the existing auth baseline without reopening completed Phase 1 scope wholesale.
- constraints: Preserve the fact that original Phase 0 and Phase 1 foundation goals were completed. The update should clarify follow-up sequencing, not rewrite history.
- decision state: resolved

### Finding 3
- type: phase-3-security-entry-gap
- location: `docs/07-planning/phases/phase-3/Phase 3 Index.md`, `docs/07-planning/phases/phase-3/Phase 3 - Customer And Public View Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md`, `docs/07-planning/phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md`
- issue: Phase 3 planning correctly covers OAuth, access modes, and Microsoft Graph mail direction, but it does not yet state that these implementation lanes are blocked on secret-backed settings and on the earlier transport/session/browser and login-hardening outputs. That leaves a sequencing hole where Phase 3 could begin coding external identity and Graph flows on top of an unsafe credential-storage model or incomplete auth hardening baseline.
- required action: Add explicit Phase 3 entry or dependency language so OAuth and Graph implementation cannot start until secret-backed settings and the necessary earlier security prerequisites are in place.
- constraints: Keep Phase 3 planning focused on sequencing and dependencies, not detailed implementation design.
- decision state: resolved

## Summary
- The new standards created the right canonical security rules, but the planning branch still needs to place them in the delivery order.
- The correct split is cross-phase rather than a single future hardening bucket: deployment/runtime hardening in Phase 0 follow-up, current login-surface hardening as a Phase 1 carry-forward prerequisite, and secret-backed settings as a direct Phase 3 prerequisite.
- Without that planning alignment, Phase 3 OAuth and Graph implementation could start on the wrong substrate.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- roadmap and dependency map explicitly place the security implementation work into the right phases
- Phase 0 and Phase 1 planning notes clarify the hardening follow-up lane without rewriting completed history
- Phase 3 planning notes block OAuth and Graph implementation on secret-backed settings and earlier security prerequisites

## Resolution Notes
- Updated the roadmap and dependency map so the new security implementation work is split across the right phases: Phase 0 carry-forward for deployment/runtime hardening, Phase 1 carry-forward for current auth hardening, and Phase 3 prerequisite dependency on secret-backed credential storage.
- Updated Phase 0 planning so it now owns the carry-forward sequencing for transport, session, browser-header, proxy, and release-hardening prerequisites needed by later identity and Graph work.
- Updated Phase 1 planning so it records current-platform-auth security corrections as a pre-Phase-3 carry-forward lane without rewriting the historical Phase 1 completion state.
- Updated the Phase 3 index plus the customer/public, OAuth, and Microsoft Graph planning notes so OAuth and Graph implementation are now explicitly blocked on the earlier hardening outputs and the secret-backed settings model.
- Re-review found no remaining scoped drift in the phase allocation, historical-status preservation, or Phase 3 prerequisite sequencing added in this pass.
