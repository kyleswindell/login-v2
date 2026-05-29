# Document Review 0017

## Review Pass
1

## Target
`docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 2.md` and `docs/07-planning/phases/phase-3/Phase 3 - Brochure Batch 2 Implementation Prep.md`

## Review Type
Document Review

## Status
IMPLEMENTED_PENDING_REVIEW

## Purpose
Clean up the remaining brochure/planning documentation slice so the new Phase 3 batch notes stay within planning ownership instead of duplicating architecture, database, and implementation-design detail.

## Scope
- `docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 2.md`
- `docs/07-planning/phases/phase-3/Phase 3 - Brochure Batch 2 Implementation Prep.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0017.md`

## Findings

### Finding 1
- type: branch-ownership-drift
- location: `docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 2.md`
- issue: The batch note embedded exact model-table mappings, namespace/folder targets, and published-contract output detail that belongs to architecture and database branches, not planning.
- required action: Reduce the planning note to batch scope, sequence, dependency, and acceptance intent while pointing exact structural and schema detail to canonical docs.
- constraints: Preserve the batch goal and acceptance framing; do not delete canonical brochure references needed for future implementation.
- decision state: resolved

### Finding 2
- type: branch-ownership-drift
- location: `docs/07-planning/phases/phase-3/Phase 3 - Brochure Batch 2 Implementation Prep.md`
- issue: The prep note encoded concrete migrations, model/service/job names, route/file targets, and test-class design, turning planning into a second implementation-design document.
- required action: Keep the prep note focused on execution order, readiness checks, and validation focus, and route detailed structure/schema concerns back to canonical architecture, feature, flow, and database docs.
- constraints: Preserve batch-start usefulness; do not remove the prep note's sequencing value.
- decision state: resolved

## Summary
- The Phase 3 Batch 2 note now stays at planning scope and links outward for exact structure, flow, and data-contract detail.
- The Batch 2 prep note now acts as an execution-order and readiness checklist instead of duplicating implementation design.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- Phase 3 brochure batch planning notes stay within planning ownership
- exact structural, behavioral, and schema detail is referenced from canonical non-planning branches
- the brochure/planning slice remains link-valid after cleanup

## Resolution Notes
- Implementation updated:
  - `docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 2.md`
  - `docs/07-planning/phases/phase-3/Phase 3 - Brochure Batch 2 Implementation Prep.md`
- This review pass remains `IMPLEMENTED_PENDING_REVIEW` until a follow-up re-review confirms the narrowed planning scope is sufficient and no adjacent brochure planning drift remains.
