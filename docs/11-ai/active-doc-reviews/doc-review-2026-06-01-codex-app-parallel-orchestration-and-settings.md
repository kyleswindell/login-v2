# Document Review doc-review-2026-06-01-codex-app-parallel-orchestration-and-settings

## Review Pass
3

## Target
Codex app parallel orchestration and settings guidance across `AGENTS.md`, concurrency runbooks, and branch-based batch skills

## Review Type
Document Review

## Status
CLOSED

## Purpose
Reconcile the repo's parallel-work governance with the Codex desktop app's actual thread, worktree, and child-agent capabilities, and capture the small app-settings baseline that matters for this repo.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/branch-based-batch-integration.md`
- `docs/10-runbooks/git-remote-and-multi-device-workflow.md`
- `.agents/skills/work-batch-branch.md`
- `.agents/skills/integrate-work-batch-branch.md`

## Findings

### Finding 1
- type: app-capability drift
- location: concurrency runbooks and branch-based batch skills
- issue: The repo correctly documented separate branches/worktrees, but it still treated Codex app orchestration as mostly conceptual. In this environment, actual Codex thread and sub-agent tooling is exposed, so the repo should distinguish the recommended long-lived path from narrow sidecar delegation.
- required action: Make one project thread per worker worktree plus one integrator thread the preferred long-lived parallel path, and reserve child agents for bounded sidecar work inside already-owned contexts.
- constraints: Do not weaken the singleton ownership of `/docs/08-active/` or imply that child agents remove the need for branch/worktree isolation.
- decision state: required

### Finding 2
- type: missing app-settings baseline
- location: concurrency runbooks
- issue: The repo did not record which current Codex desktop settings are already acceptable and which ones deserve a deliberate review before relying on longer-running background workers.
- required action: Add a short settings baseline covering the current approval/sandbox posture, review delivery mode, worktree retention, and the need to verify background-running behavior for longer jobs.
- constraints: Keep this narrow. Do not turn repo docs into a generic Codex settings manual.
- decision state: required

## Summary
- official-capability alignment: improved; the repo now acknowledges app-native project threads/worktrees and exposed child-agent tooling without overstating what those tools should own
- workflow alignment: improved; long-lived queue-item ownership is now separated from narrow sidecar delegation
- settings alignment: improved; the repo now records the small set of app settings that materially matter for this workflow

## Sources Reviewed
- OpenAI announcement: `https://openai.com/index/introducing-the-codex-app/`
- OpenAI Academy: `https://openai.com/academy/codex-how-to-start/`
- OpenAI Academy: `https://openai.com/academy/working-with-codex/`
- OpenAI Help: `https://help.openai.com/en/articles/11391654`
- current session tool surfaces: `multi_agent_v1.*`, `codex_app.create_thread`, `codex_app.send_message_to_thread`, `codex_app.list_threads`, `codex_app.read_thread`
- local app config: `%USERPROFILE%\\.codex\\config.toml`

## Implementation Status
implemented

## Exit Criteria
- the repo distinguishes recommended app-native worker-thread/worktree orchestration from child-agent sidecar use
- long-lived CQ execution still preserves singleton integrator ownership of `/docs/08-active/`
- the runbooks capture the current small app-settings baseline relevant to this repo

## Resolution Notes
- Updated top-level governance and concurrency runbooks so long-lived parallel queue-item work prefers one integrator project thread on local `main` plus one worker project thread per queue item in Worktree mode.
- Explicitly limited spawned child agents to bounded sidecar work such as exploration, verification, or narrowly owned disjoint implementation inside an already-owned worker thread.
- Added a short settings baseline covering:
  - `approval_policy = "on-failure"`
  - `sandbox_mode = "workspace-write"`
  - `desktop.reviewDelivery = "detached"`
  - `desktop.worktree-keep-count = 5`
  - explicit verification of background-running behavior before relying on longer-lived unattended execution
- Re-review found no remaining scoped drift. The repo now matches the actual Codex app/tool capability shape without relaxing the existing singleton active-workspace model.
