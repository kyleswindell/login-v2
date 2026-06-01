# Document Review doc-review-2026-06-01-parallel-batch-orchestrator-entrypoint

## Review Pass
3

## Target
Parallel batch orchestrator entrypoint across branch-based batch runbooks, instruction-surface guidance, and a new orchestration skill

## Review Type
Document Review

## Status
CLOSED

## Purpose
Eliminate the need for operators to hand-author large controller prompts when they want one session to provision and start branch-based parallel batch workers.

## Scope
- `.agents/skills/orchestrate-work-batch-branches.md`
- `docs/10-runbooks/branch-based-batch-integration.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/11-ai/instruction-surface-separation.md`

## Findings

### Finding 1
- type: missing orchestration entrypoint
- location: branch-based batch governance surfaces
- issue: The repo documented worker/integrator ownership and app-native worker threads, but it still left the operator to reconstruct a large orchestration prompt manually to trigger the pattern. That is instruction-surface drift: a repeatable operator trigger belongs in a workflow surface, not in ad hoc chat prose.
- required action: Add a dedicated orchestration skill that owns worker-lane setup and worker-start contracts, and update the runbooks to point operators at that named workflow instead of long manual prompts.
- constraints: Keep `/docs/08-active/` singleton-owned by the integrator and do not collapse orchestration, worker implementation, and integration into one multi-owner workflow.
- decision state: required

## Summary
- instruction-surface alignment: improved; the reusable trigger now lives in a skill rather than operator memory
- workflow alignment: improved; branch-based parallel setup now has a named integrator entrypoint
- operator burden: reduced; the operator can invoke the named workflow and only specify exceptions

## Implementation Status
implemented

## Exit Criteria
- branch-based parallel setup has a named orchestration skill
- runbooks point operators at that workflow as the preferred entrypoint
- instruction-surface guidance explicitly prefers reusable skill triggers over giant reconstructed prompts

## Resolution Notes
- Added `.agents/skills/orchestrate-work-batch-branches.md` as the named integrator/orchestrator workflow for provisioning or attaching worker lanes and optionally starting worker execution.
- Updated branch-based batch runbooks so the preferred operator trigger is to execute `orchestrate-work-batch-branches` for the current ready queue items.
- Updated instruction-surface guidance to explicitly prefer a skill file over a long manually reconstructed prompt when the operator trigger is reusable.
- Re-review found no remaining scoped drift. The operator no longer needs to manually author a large controller prompt for the standard branch-based parallel batch pattern.
