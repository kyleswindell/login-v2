# Document Review doc-review-2026-06-01-child-agent-dedicated-worktree-worker-fallback

## Review Pass
3

## Target
Child-agent dedicated-worktree worker fallback governance across top-level concurrency rules, branch-based batch runbooks, and worker orchestration skills

## Review Type
Document Review

## Status
CLOSED

## Purpose
Resolve whether a spawned child agent that is explicitly bound to the assigned dedicated branch/worktree should count as a valid branch-based batch worker when it still preserves isolated writes and completes the full worker contract.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/branch-based-batch-integration.md`
- `.agents/skills/orchestrate-work-batch-branches.md`
- `.agents/skills/work-batch-branch.md`

## Findings

### Finding 1
- type: overconstrained worker-executor rule
- location: concurrency rules and branch-based worker orchestration guidance
- issue: The repo treated spawned child agents as sidecars only, even when the observed execution model preserved the actual safety boundary by performing writes only inside the assigned dedicated sibling worktrees and staying out of `/docs/08-active/`. That made the governance stricter than the practical safety model and caused a successful isolated-write fallback to be misclassified as categorically invalid.
- required action: Allow spawned child agents as valid worker executors when they are explicitly bound to the assigned dedicated branch/worktree and still complete the full worker lifecycle: scoped verification, scoped worker commit when reviewable, and handoff update.
- constraints: Do not relax `/docs/08-active/` singleton ownership. Do not allow same-folder shared-session edits to masquerade as this fallback.
- decision state: required

## Summary
- safety-boundary alignment: improved; the rules now key off actual dedicated-worktree isolation and full worker close-out rather than overfitting to one app-thread shape
- workflow alignment: improved; the worker contract still requires commit plus handoff completion
- fallback clarity: improved; orchestrators must now report when a child-agent fallback is being used

## Implementation Status
implemented

## Exit Criteria
- child-agent worker fallback is either explicitly allowed or explicitly forbidden
- the allowed path requires explicit binding to the assigned dedicated branch/worktree
- the allowed path still requires full `work-batch-branch` completion, not partial dirty-worktree edits

## Resolution Notes
- Updated top-level governance so spawned child agents are allowed as worker executors only when they are explicitly bound to the assigned dedicated branch/worktree and complete the full worker contract.
- Updated the concurrency runbook and branch-based batch runbook so project threads remain preferred, but a child-agent fallback is valid when real worker-thread attachment is unavailable and the edits still occur only inside the dedicated worker worktree.
- Updated the orchestration and worker skills so the fallback must be explicit and still finish with verification, scoped commit, and handoff update.
- Re-review found no remaining scoped drift. The repo now distinguishes between:
  - valid dedicated-worktree child-agent fallback
  - invalid same-folder or unbound child-agent execution
