# Orchestrate Work Batch Branches

Act as the integrator/orchestrator for branch-based parallel batch execution.

## Natural-Language Trigger

Treat prompts in this shape as a direct request to execute this workflow:

`Start branch-based parallel batch execution: create separate worker branches/worktrees for the current ready queue items and keep /docs/08-active integrator-owned.`

Equivalent operator phrasings should map here when they clearly request:

- branch-based parallel worker setup
- worker branch/worktree creation or attachment
- singleton integrator ownership of `/docs/08-active/`

## Goal

Create or attach the worker execution lanes for ready change-queue items without turning `/docs/08-active/` into a multi-writer workspace.

This skill owns orchestration only:

- worker branch/worktree selection or provisioning
- worker thread/session assignment
- handoff artifact seeding or reconciliation
- advisory claim visibility updates when needed

This skill does NOT:

- implement queue items itself
- move queue items through `/docs/08-active/`
- integrate worker results

## Required Inputs

- `/docs/08-active/batch.md`
- `/docs/08-active/change-queue.md`
- `.agents/session-scope-claims.json`
- `.agents/batch-branch-handoffs/`

## Rules

- Remain the singleton integrator owner of `/docs/08-active/`
- Treat this as orchestration for `work-batch-branch`, not ordinary `work-batch`
- Default to one Codex app project thread per worker queue item in Worktree mode when available
- Do not manually provision Git worktrees when the Codex app can create or attach the worker lane in Worktree mode
- Use manually provisioned Git worktrees only as fallback when Codex app Worktree mode is unavailable, cannot attach the worker lane cleanly, or the operator explicitly requests manual worktrees
- Manually provisioned worker worktrees for this repo must live under `C:\Users\kswin\Desktop\Work 2023\8. Login V2.worktrees\`
- Do not create new worker worktrees directly under `C:\Users\kswin\Desktop\Work 2023`; older handoff paths in `.agents/batch-branch-handoffs/` are historical state, not the current provisioning convention
- If worker project-thread attachment is unavailable but the dedicated branch/worktree exists, spawned child agents are an acceptable worker fallback only when they are explicitly bound to that assigned branch/worktree and still complete the full worker contract
- One worker lane per queue item
- Do not let worker lanes edit `/docs/08-active/`
- Do not move queue items into `In Progress` during orchestration alone
- Seed or update one handoff artifact per worker queue item
- Keep worker ownership and worktree ownership explicit and non-overlapping

## Concurrency Preflight

Before writing:

- confirm this session is the integrator thread/session
- confirm `/docs/08-active/` is currently integrator-owned
- confirm the target queue items are actually `Ready To Implement`
- confirm no other integrator is already orchestrating the same worker lanes

Stop if:

- active batch ownership is unclear
- the target queue items are ambiguous
- a worker lane would reuse a branch/worktree already assigned to another active queue item
- this session is not the integrator context

## Execution

1. Read the active batch and identify ready queue items that should receive worker lanes.
2. For each selected queue item:
   - determine whether a dedicated worker lane already exists
   - create or attach a dedicated Codex app project thread/session in Worktree mode when the Codex app supports it
   - if Codex app Worktree mode cannot create or attach the worker lane cleanly, provision a dedicated manual branch/worktree under `C:\Users\kswin\Desktop\Work 2023\8. Login V2.worktrees\`
   - for manual fallback worktrees, use worker folder names in the shape `login-v2-<queue-id-lowercase>` unless the operator assigns a specific name
   - if app-thread attachment is unavailable but the dedicated manual branch/worktree exists, allow a spawned child-agent fallback only when the child agent will operate explicitly in that assigned branch/worktree
   - seed or update `.agents/batch-branch-handoffs/<queue-id>.md` with:
     - queue ID
     - assigned branch
     - assigned worker thread and Codex-managed worktree when using app Worktree mode, or assigned manual worktree path when using the fallback path
     - base SHA
     - status `draft`
     - merge notes stating that `/docs/08-active/` remains integrator-owned
3. Update `.agents/session-scope-claims.json` only as a lightweight visibility layer when needed.
4. Start worker execution only if explicitly requested as part of the same orchestration pass.

## Worker Start Contract

When asked to start worker execution, each worker lane should receive the equivalent of:

- execute `work-batch-branch`
- use the assigned worker thread/worktree
- implement the assigned queue item only
- do not edit `/docs/08-active/`
- run scoped verification
- commit scoped changes
- update the matching handoff artifact to `ready_for_integration`

Do not require the human operator to manually rewrite this contract each time. The orchestrator should derive and apply it from this workflow.

If a spawned child-agent fallback is used instead of a dedicated worker project thread, the orchestrator must report that explicitly in its output instead of treating the fallback as invisible.

## Output

1. worker lanes created or attached
2. branch/worktree assignment per queue item
3. worker execution started or not started
4. handoff artifacts seeded or updated
5. blockers or follow-up needed before integration
