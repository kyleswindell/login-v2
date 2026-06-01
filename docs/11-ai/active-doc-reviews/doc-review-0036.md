# Document Review 0036

## Review Pass
3

## Target
Batch lifecycle skills, the missing phase lifecycle skill surface, and the related runbook guidance that should govern roadmap and phase-status synchronization.

## Review Type
Document Review

## Status
CLOSED

## Purpose
Review the agent workflow skill set and related runbooks so roadmap, phase indices, and other parent planning docs are updated by the correct workflow owner instead of being implicitly expected from active-batch start or finalize steps.

## Scope
- `.agents/skills/batch-start.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/batch-review-and-finalize.md`
- `.agents/skills/review-docs-sync.md`
- `.agents/skills/implement-docs-sync-fix.md`
- `.agents/skills/`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/staging-deployment.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0036.md`

## Findings

### Finding 1
- type: missing-phase-lifecycle-skill-coverage
- location: `docs/10-runbooks/agent-sessions-and-parallel-work.md`, `docs/10-runbooks/staging-deployment.md`, `.agents/skills/`
- issue: The runbooks define `/phase-planning`, `/phase-batch-planning`, `/phase-batch-development`, `/phase-batch-implementation`, `/phase-batch-review`, `/phase-batch-close-out`, and `/phase-close-out` as the delivery flow, and they explicitly say phase-batch-close-out must sync deferments and parent phase planning docs before a batch is considered complete. The repo-owned skill inventory does not currently contain those phase workflow skill files, so there is no executable instruction surface that actually owns roadmap, phase-index, and parent-phase planning synchronization at the lifecycle point where the runbooks require it.
- required action: Add the missing phase workflow skill files or revise the runbooks to map those commands to an existing owned workflow. At minimum, the repo needs an explicit phase close-out instruction surface that owns roadmap, phase-index, deferment, and parent planning synchronization after reviewed batch completion.
- constraints: Keep active-batch skills scoped to `/docs/08-active/` and do not push parent planning sync responsibilities into `batch-start` or `batch-review-and-finalize`.
- decision state: resolved

### Finding 2
- type: batch-finalization-handoff-gap
- location: `.agents/skills/batch-review-and-finalize.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- issue: `batch-review-and-finalize` correctly forbids canonical doc changes and ends with archiving and resetting `/docs/08-active/`, but it does not explicitly hand off to the required post-review phase close-out step that the runbook uses to sync parent planning docs and mark the broader batch lifecycle complete. That makes it easy to treat active-workspace finalization as the end of the documentation lifecycle even though the runbook says a further planning-sync step still exists.
- required action: Add an explicit boundary note in `batch-review-and-finalize` that parent phase planning, roadmap, and deferment synchronization are outside this workflow and must be completed by `phase-batch-close-out`, `phase-close-out`, or the repo's designated successor workflow.
- constraints: Do not widen `batch-review-and-finalize` to edit canonical planning docs directly; clarify ownership and handoff only.
- decision state: resolved

### Finding 3
- type: lifecycle-owner-visibility-gap
- location: `.agents/skills/batch-start.md`, `.agents/skills/work-batch.md`, `.agents/skills/batch-review-and-finalize.md`, `docs/11-ai/agent-skill-writing-benchmark.md`
- issue: The current batch lifecycle skills clearly state what they may write, but they do not collectively identify which workflow owns parent planning-status synchronization when implementation progress changes a batch, phase, or roadmap state. Because the boundary is only inferable from separate runbooks, readers can incorrectly assume that either active-batch finalization already covered planning sync or that no further sync owner exists.
- required action: Tighten the relevant batch and phase workflow instructions so the boundary is explicit: batch workflows own active workspace execution state, while phase close-out or a designated planning-sync workflow owns updates to roadmap, phase indices, deferments, and related parent planning notes.
- constraints: Preserve the benchmark split between `SKILL.md` workflow playbooks and canonical planning docs; this should clarify workflow authority, not duplicate roadmap content inside skills.
- decision state: resolved

## Summary
- The reviewed batch skills are not wrong for refusing to update roadmap and parent planning docs.
- The real problem is that the repo's runbooks depend on a phase close-out lifecycle that is not currently backed by corresponding repo-owned skill files or an equally explicit alternative workflow.
- Until that lifecycle owner is restored or remapped, roadmap and phase-status drift will remain easy to reintroduce because the post-batch planning sync point is not enforceable.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the repo has an explicit workflow owner for roadmap, phase-index, and parent planning synchronization after reviewed batch completion
- batch lifecycle skills explicitly clarify that parent planning sync is outside active-workspace start/finalize scope
- runbooks and skill inventory refer to the same supported workflow names for phase close-out and status synchronization

## Resolution Notes
- Implementation pass updated:
  - `AGENTS.md`
  - `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  - `docs/10-runbooks/batch-workflow.md`
  - `docs/10-runbooks/staging-deployment.md`
  - `.agents/skills/batch-review-and-finalize.md`
  - `.agents/skills/review-docs-sync.md`
  - `.agents/skills/implement-docs-sync-fix.md`
- The parent workflow surfaces now route roadmap, phase-index, deferment, and parent planning-status synchronization through the existing docs sync path instead of implying that active batch lifecycle skills should write those docs directly.
- `review-docs-sync` now includes `/docs/07-planning/` in scope and explicitly supports planning/status synchronization after reviewed close-out when implementation or deferment truth changed.
- `implement-docs-sync-fix` now explicitly covers planning/status synchronization within the review findings scope.
- Re-review found no remaining scoped ownership gap: batch finalize stays limited to `/docs/08-active/`, while the existing docs sync skills are now the explicit downstream owner for parent planning synchronization.
