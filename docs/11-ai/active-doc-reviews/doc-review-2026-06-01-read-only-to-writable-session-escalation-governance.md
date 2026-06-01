# Document Review doc-review-2026-06-01-read-only-to-writable-session-escalation-governance

## Review Pass
3

## Target
Read-only-to-writable session escalation governance across `AGENTS.md`, concurrency runbooks, and writable documentation workflow skills

## Review Type
Document Review

## Status
CLOSED

## Purpose
Confirm that agent governance explicitly stops a read-only planning, research, or review session before it turns into writable docs work while another writable session already owns the shared worktree.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/git-remote-and-multi-device-workflow.md`
- `.agents/skills/review-document.md`
- `.agents/skills/review-docs-sync.md`
- `.agents/skills/implement-docs-fix.md`
- `.agents/skills/implement-docs-sync-fix.md`

## Findings

### Finding 1
- type: missing procedure safeguard
- location: `AGENTS.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md`, `docs/10-runbooks/git-remote-and-multi-device-workflow.md`, and the scoped writable docs workflow skills
- issue: The repo documents the steady-state rule that concurrent writable work requires separate branches and separate worktrees, but it does not explicitly define the transition rule for a session that began as read-only research, planning, or review and later becomes ready to write docs while another writable session is already active. Without that stop gate, an agent can remain in the shared worktree and drift from analysis into writes even though the concurrency model intended that session to fork into its own branch/worktree first.
- required action: Add an explicit read-only-to-writable escalation rule to the top-level agent governance and concurrency runbooks, and add matching stop conditions/output guidance to the scoped review and docs-fix skills so they require separate branch/worktree setup or continued read-only operation when another writer already owns the shared folder.
- constraints: Keep the change governance-only; do not redesign batch workflow ownership or introduce automation requirements that do not exist yet.
- decision state: implied by existing concurrency rules

## Summary
- benchmark alignment: partial; the current files define steady-state writable isolation but not the escalation moment
- workflow alignment: partial; the intended concurrency model exists, but the transition from research to writing is not enforced consistently across the touched surfaces
- readiness: ready for a narrow governance correction pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- `AGENTS.md` explicitly requires a read-only session to halt before writing when another writer already owns the shared worktree
- concurrency runbooks explain the same transition rule and the expected agent response
- the scoped docs review and docs-fix skills stop and require separate branch/worktree setup or continued read-only operation when that transition would otherwise create an unsafe same-folder writer

## Resolution Notes
- Review found one scoped governance gap; no broader concurrency-model redesign is required for this correction.
- Implemented the required stop gate in:
  - `AGENTS.md`
  - `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  - `docs/10-runbooks/git-remote-and-multi-device-workflow.md`
  - `.agents/skills/review-document.md`
  - `.agents/skills/review-docs-sync.md`
  - `.agents/skills/implement-docs-fix.md`
  - `.agents/skills/implement-docs-sync-fix.md`
- Resolved finding 1 by making the read-only-to-writable transition explicit: a session that becomes ready to write while another writer already owns the shared worktree must stop and either move to a separate branch/worktree or remain read-only unless writable ownership is explicitly handed over.
- Re-review found no remaining scoped inconsistency. The top-level governance, concurrency runbooks, and scoped docs-review/docs-fix skills now all express the same transition rule and stop condition.
