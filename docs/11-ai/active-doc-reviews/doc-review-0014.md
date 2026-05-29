# Document Review 0014

## Review Pass
2

## Target
`AGENTS.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md`, `docs/10-runbooks/git-remote-and-multi-device-workflow.md`, `docs/10-runbooks/batch-workflow.md`, `.agents/skills/batch-start.md`, `.agents/skills/work-batch.md`, and `.agents/skills/review-document.md` for scoped session claims and worktree-backed concurrent write handling.

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit what repo-owned files must be updated or created if the repo wants a documented, repeatable workflow for advisory scope claims and safer concurrent writable agent work.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/git-remote-and-multi-device-workflow.md`
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/staging-deployment.md`
- `.agents/skills/batch-start.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/review-document.md`
- Official reference: [Codex app worktrees](https://developers.openai.com/codex/app/worktrees)
- Official reference: [Codex skills](https://developers.openai.com/codex/skills)

## Findings

### Finding 1
- type: conflict
- location: `AGENTS.md:35-41`, `AGENTS.md:91-121`, `docs/10-runbooks/batch-workflow.md:11-17`, `docs/10-runbooks/batch-workflow.md:84-99`, `.agents/skills/batch-start.md:1-79`, `.agents/skills/work-batch.md:1-152`
- issue: The repo currently defines `/docs/08-active/` as a single active batch workspace and requires `batch-start` to reset it before work begins. That means truly parallel `batch-start` or `work-batch` execution is not just undocumented; it is structurally incompatible with the current singleton workspace model, even if separate Git worktrees are used.
- required action: Decide whether concurrent batch execution is actually supported. If not, explicitly document that `batch-start` and `work-batch` remain singleton workflows regardless of worktree support. If yes, redesign the batch workflow to use branch- or session-scoped active workspaces before adding any claim/checkout skill layer.
- constraints: Do not imply that worktrees alone make the current `/docs/08-active/` model safe for multiple active batches.
- decision state: resolved

### Finding 2
- type: gap
- location: `docs/10-runbooks/agent-sessions-and-parallel-work.md:152-164`, `docs/10-runbooks/git-remote-and-multi-device-workflow.md:39-48`, `AGENTS.md:91-101`
- issue: The repo already recognizes that lock notes are advisory only, but there is no canonical registry file, no repo-owned skill, and no required preflight flow for claiming or releasing scope. As written, the concept exists only as prose.
- required action: Create a small advisory coordination layer if the repo wants visible scope claims. Minimum likely file set:
  - `.agents/skills/check-session-scope-conflicts.md`
  - `.agents/skills/claim-session-scope.md`
  - `.agents/skills/release-session-scope.md`
  - one dedicated state file outside `/docs/08-active/` for live claim data, likely under `.agents/` rather than canonical docs
- constraints: The live claim file must not live in `/docs/08-active/`, must not be treated as protection, and must stay separate from canonical runbook prose.
- decision state: resolved

### Finding 3
- type: gap
- location: `docs/10-runbooks/agent-sessions-and-parallel-work.md:166-228`, `docs/10-runbooks/git-remote-and-multi-device-workflow.md:39-48`, [Codex app worktrees](https://developers.openai.com/codex/app/worktrees), [Codex skills](https://developers.openai.com/codex/skills)
- issue: Local runbooks describe manual `git worktree` usage, but they do not document the Codex app's built-in Worktree mode, Handoff flow, or the official one-branch-per-worktree limitation. Official Codex guidance already covers managed worktrees and explicitly states that Git only allows a branch to be checked out in one worktree at a time.
- required action: Update the runbooks to add an app-native path for concurrent writable sessions and to state that a custom repo skill should coordinate scope, not reimplement Codex-managed worktree creation. Minimum updates:
  - `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  - `docs/10-runbooks/git-remote-and-multi-device-workflow.md`
  - optionally `AGENTS.md` for the short rule summary
- constraints: Keep the manual Git path as fallback, but make the official Codex worktree path first-class where this repo is expected to be used from the Codex app.
- decision state: resolved

### Finding 4
- type: ambiguity
- location: `.agents/skills/work-batch.md:1-152`, `.agents/skills/batch-start.md:1-79`, `.agents/skills/review-document.md:1-45`, `AGENTS.md:91-121`
- issue: Writable skills do not currently require a session-role preflight. They do not tell the agent to confirm writer status, current branch, worktree path, whether another writable session already owns the shared folder, or whether an advisory claim exists before editing files.
- required action: Update each writable skill to include a concurrency preflight section. Minimum likely updates:
  - `.agents/skills/batch-start.md`
  - `.agents/skills/work-batch.md`
  - `.agents/skills/review-document.md`
  - optionally any future review-writing or docs-sync implementation skills that create files
- constraints: Read-only review and planning work should remain allowed without forcing claim-file writes; only writable flows need the stronger preflight.
- decision state: resolved

### Finding 5
- type: conflict
- location: `.agents/skills/review-document.md:1-45`, `docs/11-ai/active-doc-reviews/index.md:1-60`, `AGENTS.md:43-48`
- issue: Concurrent review writing has an additional collision point beyond file claims: the review ledger itself depends on a shared sequential ID namespace and a shared index file. Two review writers can independently choose the same next ID or race on index updates, even if they intend to review different targets.
- required action: Decide whether review-writing concurrency is a supported use case. If it is, update the review workflow to define one of:
  - a reserved-ID workflow
  - a non-sequential ID scheme
  - a merge-time reconciliation rule
  - or an explicit requirement that review writers use separate worktrees and serialize final ledger updates
- constraints: Advisory claim files do not solve sequential ID allocation by themselves.
- decision state: resolved

### Finding 6
- type: gap
- location: `AGENTS.md:91-121`, `docs/10-runbooks/agent-sessions-and-parallel-work.md:247-255`, `docs/10-runbooks/staging-deployment.md:165-185`
- issue: The repo has pieces of the concurrency story, but not a single explicit support matrix. That leaves too much room for inference about what is actually allowed: same-folder single writer, separate worktree multiple writers, singleton active batch workspace, and single-owner staging review branches all behave differently.
- required action: Update the governing docs to state the supported modes directly. Minimum likely updates:
  - `AGENTS.md`
  - `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  - `docs/10-runbooks/staging-deployment.md`
- constraints: The final wording should distinguish coordination features from isolation features and should not overstate what advisory claims can guarantee.
- decision state: resolved

### Finding 7
- type: gap
- location: `AGENTS.md:89-121`, `.agents/skills/batch-update-manual-review-status.md`, `.agents/skills/work-batch.md`, `docs/11-ai/agent-skill-writing-benchmark.md:57-79`, `docs/11-ai/agent-skill-writing-benchmark.md:130-161`
- issue: The repo does not define a generalized automation policy for how far an agent may continue on its own once a task enters a known workflow. That leaves continuation behavior too dependent on case-by-case inference: the current rules talk about explicit versus inferred workflow execution, but they do not define automation tiers, default continuation limits, mandatory stop conditions, or a clear "if unsure, stop and ask" standard for intermediate steps.
- required action: Add a repo-level automation policy that distinguishes at least:
  - always-allowed read-only analysis
  - low-risk in-scope workflow continuation
  - higher-risk actions that always require explicit approval
  - hard stop conditions when scope, ownership, or implementation direction becomes unclear
  The writable workflow skills should then either inherit that policy explicitly or restate only the skill-specific exceptions.
- constraints: Do not phrase the policy as a blanket approval for "UI changes" or similar broad categories. The rule needs systematic gates based on scope, risk, and workflow state, and it must preserve the default requirement to stop and ask whenever the next step is ambiguous.
- decision state: resolved

## Summary
- official-guidance alignment: the repo already matches the core OpenAI/Codex position that real concurrent write safety comes from worktree isolation, not checkout notes
- primary blocker: the current singleton `/docs/08-active/` workflow prevents straightforward parallel batch execution
- likely implementation shape: update runbooks and governing rules, add a small advisory scope-claim skill set, define a generalized automation/continuation policy for writable skills, and keep worktree creation itself aligned to Codex app or Git-native behavior rather than inventing a parallel repo-specific automation layer

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the repo explicitly states which concurrent workflows are supported and which remain singleton-only
- writable skills include a concurrency preflight or delegated claim-check step
- advisory claim files, if adopted, have a canonical non-batch storage location and release path
- the repo defines a generalized automation policy with continuation tiers, approval gates, and stop conditions
- runbooks document Codex app worktrees and the one-branch-per-worktree limitation
- review-writing concurrency rules cover ledger ID and index-update collisions

## Resolution Notes
- Official Codex documentation reviewed for this pass:
  - `developers.openai.com/codex/app/worktrees`
  - `developers.openai.com/codex/skills`
- The official docs support using worktrees for isolation and skills for repeatable workflow packaging, but they do not change the repo-local conflict created by the singleton `/docs/08-active/` workspace.
- Implementation pass updated the repo to:
  - declare `/docs/08-active/` as a singleton active batch workspace with concurrent `batch-start` / `work-batch` explicitly unsupported
  - add a support matrix to `AGENTS.md` and the concurrency runbook
  - document Codex app Worktree mode as the first-class writable-isolation path, with manual `git worktree` as fallback
  - add `.agents/session-scope-claims.json` plus advisory scope-claim skills under `.agents/skills/`
  - add writable-session concurrency preflight sections to `batch-start`, `work-batch`, and `review-document`
  - define review-ledger final-write serialization as the supported rule while sequential IDs remain in place
  - add a generalized automation policy with continuation tiers, approval gates, and stop conditions
- Re-review confirmed the concurrency/governance model now distinguishes isolation features from advisory coordination and does not overstate what claim files can guarantee.
