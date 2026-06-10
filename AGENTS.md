# AGENTS.md

## Project Context

This repository contains Login App 2.0, a Laravel-based platform intended to replace the current customized Perfex 1.0 foundation over time.

---

## Core Principles

- Treat this repository as the source of truth for App 2.0.
- Keep the Perfex 1.0 repository as reference only unless explicitly instructed otherwise.
- Use Laravel, Filament, Livewire, PostgreSQL, Redis, and Apache/PHP-FPM as the locked foundation unless a decision record changes that.
- Support arbitrary tenant admin domains from day one.
- Keep tenants isolated with one tenant database and one PostgreSQL role per tenant.
- Prefer data-driven tenant configuration over file-copy-driven behavior.
- Do not build meaningful untracked application code directly on the production server.

---

## Canonical Documentation Rules

- Treat `/docs/` as the canonical root for all active documentation.
- Ignore `/docs/_archive/` unless explicitly requested.
- Do not introduce legacy documentation paths or outdated references.

### Branch Responsibilities

- `01-decisions` → ADRs and elevated decision records only  
- `02-standards` → rules only  
- `03-architecture` → system structure only  
- `04-features` → behavior only  
- `05-flows` → execution paths only  
- `06-database` → schema and constraints only  
- `07-planning` → sequencing and intent only  
- `09-reference` → non-canonical support only  
- `10-runbooks` → operations only  

Always respect branch ownership. Do not duplicate or reassign responsibility across branches.

---

## Active Workspace (`/docs/08-active/`)

- `/docs/08-active/` represents the current batch workspace.
- It is the only location where active batch state is stored.
- Only batch workflows (`batch-start`, `work-batch`, `integrate-work-batch-branch`, `batch-update-manual-review-status`, `batch-review-and-finalize`) may modify it.
- Do not manually alter its structure outside those workflows.
- Active `change-queue.md` items should use stable queue IDs in the format `P<phase>-<batch>-CQ-###`.
- `In Progress` is the active claim state for the current `work-batch` owner on a targeted queue item.
- `work-batch` must move a targeted queue item from `Ready To Implement` to `In Progress` when implementation begins, and must move it out of `In Progress` to an outcome state before claiming another queue item unless the pass genuinely stops mid-item.
- `Implemented Pending Review` is reserved for queue items that are actually reviewable on the required review surface; if deployment is required for review, the item does not belong there until that deploy succeeds.
- Local development may be the review surface when the reviewer is inspecting the same working tree, but accepted local-review work must be committed before moving to `Passed Review`.
- In branch-based parallel execution, `/docs/08-active/` remains a singleton integrator-owned workspace; worker branches may read it for context but must not update it directly.
- Keep exploratory review discussion in chat until an agent normalizes it into concise queue language.
- When discussing an existing queue item in chat, reference its queue ID when available.

---

## Implementation and Docs Sync

- When implementing a planned system, update canonical docs and related planning notes in the same work cycle.
- Planning notes must reflect current implementation status.
- Canonical system docs and planning notes must remain linked.
- If a reviewed batch or phase changes parent planning truth but the current workflow does not own those planning files directly, run the scoped docs sync path in the same work cycle:
  - `review-docs-sync`
  - `implement-docs-sync-fix`
- Use that docs sync path for roadmap, phase-index, deferment, and parent planning-status synchronization instead of broadening active batch lifecycle skills beyond their owned scope.

---

## Code and Documentation Discipline

- Only modify files directly required for the current scope.
- Do not include unrelated changes in commits.
- If unrelated issues are found during active batch implementation work:
  - record them in `/docs/08-active/notes.md`
  - do not fix them immediately
- If unrelated issues are found during review-only governance or documentation audit work:
  - record them in the active review file under `docs/11-ai/active-doc-reviews/`
  - update the review ledger entry if the finding changes the audit status
  - do not push them into `/docs/08-active/` unless they belong to the current active batch

- Prefer minimal, explicit changes over broad rewrites.
- Maintain consistency with existing naming, tokens, and patterns.

---

## Git and Deployment Rules

- Follow `docs/10-runbooks/git-batch-commit-workflow.md` for active batch execution commits only.
- Active batch commits must:
  - map to a single batch and a single concern
  - include only files touched for that scope
- Use the restored local development stack as the default verification surface; do not push or deploy implementation micro-steps to the server when local validation is sufficient.
- Local development review may inspect uncommitted scoped changes, but accepted queue-item work must be committed before the item is treated as passed review.
- If staging, server, or another shared surface is required for review, commit, push, and deploy before calling the item reviewable.
- When one work pass handles multiple change-queue items, the worklog must identify the targeted queue IDs, grouping rationale, affected files by item or tightly coupled group, validation performed, and review surface used.

- Use batch checkpoints for active batch execution:
  - batch initialized
  - implementation save points
  - review-ready
  - finalized

- For non-batch review or governance work:
  - keep one commit scoped to one review, sync pass, or governance concern
  - include only files directly required for that review or governance update
  - do not force batch checkpoint naming onto review-only work

- For branch-based parallel batch execution:
  - worker branch commits must map to one queue item and one concern
  - worker branch commits must not update `/docs/08-active/`
  - integration commits own `/docs/08-active/` state reconciliation, deploy gating, and review-surface publication

- Only commit when the work is scoped, intentional, and reviewable.

---

## Agent Execution Rules

- Only one agent may modify canonical docs or code in a session.
- Separate:
  - prompt generation
  - implementation
  - review
- Do not combine review and implementation in the same step.
- Before executing a batch workflow step, explicitly state which workflow is being entered.
- If a batch workflow step was explicitly requested by the user, it may be executed without an extra confirmation step.
- If a batch workflow step is only inferred from the conversation and it will modify `/docs/08-active/`, canonical docs, or code, ask for confirmation before executing it.
- Do not enter `work-batch` from methodology, review, diagnosis, planning, or "what should we do?" discussion. Treat those prompts as read-only unless the user explicitly says to implement, execute `work-batch`, or provides a paste-ready work-batch prompt.
- Exception: when the user provides clear manual-review feedback that unambiguously maps to existing active-batch items or to a concise new finding, that feedback itself authorizes `batch-update-manual-review-status`; do not stop just to confirm that the review-status skill should be executed.
- Read-only analysis, workflow interpretation, and prompt generation do not require confirmation.
- If a read-only planning, research, audit, or review session becomes ready to write while another writable session already owns the current working tree, stop before editing and require either:
  - a separate branch plus separate worktree for the new writable session
  - or an explicit handoff of writable ownership into the current session
- After completing a batch workflow step, report which workflow was executed, which files were updated, and what state changed.
- Review-only audit work must use `docs/11-ai/active-doc-reviews/` as its canonical artifact path and must not be treated as active batch workflow execution unless the user explicitly switches into a batch workflow step.

---

## Batch Workflow Enforcement

- Always execute batch work through:
  - `batch-start`
  - `work-batch`
  - `integrate-work-batch-branch`
  - `batch-update-manual-review-status`
  - `batch-review-and-finalize`

- Required workflow notice format before execution:
  - name the workflow step being executed
  - name the file scope that will be modified
  - if the step is inferred, request confirmation before making changes
- For `batch-update-manual-review-status`, clear mappable manual-review feedback counts as sufficient authorization even when the step is inferred from the review conversation; only stop if the finding mapping or requested state change is ambiguous.

- Required workflow completion notice after execution:
  - name the workflow step that completed
  - summarize the files updated
  - summarize the resulting state change

- Do not:
  - skip batch initialization
  - mix multiple batches
  - introduce Tier 2 or Tier 3 work into a Tier 1 batch

---

## Review-Only Governance Work

- Use review files under `docs/11-ai/active-doc-reviews/` for non-batch documentation and agent-governance audits.
- Use the review ledger at `docs/11-ai/active-doc-reviews/index.md` to track actual review and implementation status.
- Keep review, implementation, and re-review as separate steps even when they happen in the same broader session.
- Do not store review-only governance state in `/docs/08-active/` unless the review is explicitly about the current active batch workspace.
- When implementing a review-only fix, update the scoped review file and ledger entry in the same work cycle.

---

## Agent Instruction Surfaces

- `AGENTS.md` owns persistent repo rules and operating boundaries.
- Folder-level `AGENTS.md` files own local read-scope guidance, retrieval boundaries, and agent-only orientation for their folder tree.
- `.agents/skills/` owns executable workflow playbooks.
- canonical `docs/` owns durable product, architecture, planning, database, runbook, and review/governance truth.
- `.agents/memory/` owns non-canonical repo-local working memory only.
- `.agents/baselines/` owns exportable generic starter packs.
- If a memory note becomes a durable repo rule, workflow behavior, canonical system truth, or reusable starter-pack improvement, promote it into the correct owner surface instead of leaving it in memory.

---

## Folder-Level Read Scope

- Before broad file traversal, read the nearest applicable folder-level `AGENTS.md`.
- For work inside `docs/`, read `docs/AGENTS.md` and then the relevant branch-level `AGENTS.md` when one exists before opening long canonical docs.
- Use folder-level `AGENTS.md` files as agent-only retrieval maps; do not copy their agent-specific language into human-facing canonical docs.
- Treat Obsidian links as discovery aids, not as permission to load every linked file into context.
- Prefer indexes, headings, exact queue items, and targeted section reads over whole-branch or whole-repo context loading.
- Do not read archive folders, long research artifacts, or unrelated workflow history unless the task explicitly requires them.
- When a folder-level `AGENTS.md` conflicts with this root file, this root file wins.

---

## Repo-Local Agent Memory

- `.agents/memory/` is the repo-local home for non-canonical, non-production-facing agent memory.
- Use `.agents/memory/` for durable agent support material such as:
  - operator preferences
  - repo heuristics and recurring gotchas
  - compressed project-context summaries
  - non-canonical open loops and handoff notes
  - ephemeral session summaries that should not live in chat alone
- Do NOT use `.agents/memory/` for:
  - canonical product, architecture, planning, database, or runbook truth that belongs in `docs/`
  - active batch workflow state that belongs in `/docs/08-active/`
  - worker-branch integration handoff artifacts that belong in `.agents/batch-branch-handoffs/`
  - secrets, credentials, tokens, raw customer data, or production-only sensitive values
- If repo-local memory reveals durable system truth, promote that truth into its canonical `docs/` owner rather than treating `.agents/memory/` as the final source of truth.
- If repo-local memory reveals durable agent operating rules, workflow behavior, or reusable starter-pack improvements, promote them into `AGENTS.md`, the relevant skill file, or `.agents/baselines/` respectively.
- Keep repo-local memory concise, prunable, and explicitly dated or reviewable when practical.
- Prefer updating existing memory notes over creating overlapping ones.

---

## Concurrency Support Matrix

- Supported: one writable session in one working tree.
- Supported: multiple read-only planning, audit, or review sessions in the same folder while one writer owns edits.
- Supported by default: one writable runtime batch worker plus one integrator/doc-review/change-queue writer, with the integrator owning `/docs/08-active/`, review state, staging, and final merge/promotion.
- Supported by exception only: multiple writable sessions when each writable session has its own branch, worktree, and explicitly accepted scope.
- Supported by exception only: multiple Codex app project threads when each writable thread uses its own worktree and owned scope.
- Supported by exception only: multiple parallel queue-item workers in separate branches/worktrees when a single integrator session serializes `/docs/08-active/` updates, deploy ownership, and final merge/promotion.
- Supported by exception only: spawned child agents as worker executors when they are explicitly bound to the assigned dedicated branch/worktree and complete the full worker contract.
- Supported: spawned child agents for bounded read-only sidecar work inside an already-owned writable context.
- Not supported: concurrent `batch-start` or `work-batch` execution against the same shared `/docs/08-active/` workspace.
- Not supported: multiple writable sessions editing the same working tree folder at the same time.
- Not supported: splitting active-batch queue items across multiple writers by treating `In Progress` or advisory scope claims as per-item locks inside the same shared `/docs/08-active/` workspace.
- Not supported: concurrent review-ledger final writes without serialization, because `doc-review-####` and `doc-sync-####` IDs are sequential and the shared index is a collision point.
- Staging review ownership is single-branch at a time; only one non-`main` review branch should own staging during manual QA.

Coordination notes:

- worktree isolation is the real safety boundary for concurrent writable work
- for normal active-batch execution, prefer one runtime worker thread plus one integrator/doc-review/change-queue writer
- use multiple worker worktrees only after explicit operator approval for a temporary, bounded parallel burst
- prefer a Codex app project thread for the single worker worktree; use spawned child agents as worker executors only by exception when they are explicitly bound to the assigned dedicated branch/worktree, stay out of `/docs/08-active/`, and complete commit plus handoff requirements
- advisory scope claims are coordination aids only and do not guarantee protection
- use `.agents/session-scope-claims.json` only as a lightweight visibility layer, not as a lock
- a session that began read-only must not silently become a same-folder writer while another writable session is active; it must either move to its own branch/worktree or remain read-only
- writes to `.agents/memory/` are still ordinary repo writes and follow the same one-writer-per-worktree rule
- for `batch-start` and `work-batch`, the writable claim scope is the whole `/docs/08-active/` workspace; queue item IDs may appear only as descriptive context inside that broader claim
- use `.agents/batch-branch-handoffs/` for worker-to-integrator handoff artifacts; those files coordinate branch integration but do not replace the singleton ownership of `/docs/08-active/`

---

## Automation Policy

Default rule:

- if the next step is unclear, stop and ask

Automation tiers:

- Tier A: always allowed
  - read-only analysis
  - workflow interpretation
  - prompt generation
  - standards and source review
- Tier B: allowed within the active scoped workflow
  - narrow in-scope updates that the current workflow explicitly owns
  - matching review-ledger or active-workspace state updates required by that workflow
  - targeted verification tied directly to that workflow
- Tier C: explicit approval or workflow-specific authorization required
  - deploy, publish, or other external-state changes
  - new dependencies
  - infrastructure, auth, database, or architecture changes
  - destructive resets, archive moves, or workspace-clearing steps
- Tier D: stop and ask
  - scope ambiguity
  - ownership ambiguity
  - conflicting standards or source inputs
  - multiple plausible implementation directions with materially different outcomes

Continuation rule:

- continue automatically only while scope, risk, and ownership remain unchanged inside the current workflow
- crossing from read-only research, planning, audit, or review into writable execution counts as an ownership/risk change when another writer already owns the current working tree; stop and require separate branch/worktree setup or explicit writable handoff before editing
- if the next action increases risk or changes workflow type, stop and ask unless the user already requested that exact workflow step

Workflow-specific authorization note:

- an explicitly requested batch workflow step authorizes the normal actions that workflow requires when its own completion criteria are met
- for `work-batch`, local development review does not require push or staging deployment; it does require a scoped commit after accepted local review and before passed-review state
- for `work-batch`, shared manual visual review includes scoped commit, push, and canonical staging deployment when the pass is review-ready
- do not stop for a second approval in that case unless a documented deployment precondition is missing or the workflow would need to improvise an unapproved execution path

---

## UI and Component Standards

- Tier 1 = primitives and baseline components  
- Tier 2 = reusable patterns  
- Tier 3 = feature modules  

Rules:
- Do not bypass tiers
- Do not redefine primitives at higher tiers
- UI Reference must reflect actual component behavior

---

## Important Docs

- `docs/00-start-here.md`
- `docs/02-standards/index.md`
- `docs/03-architecture/index.md`
- `docs/04-features/index.md`
- `docs/05-flows/index.md`
- `docs/06-database/index.md`
- `docs/07-planning/index.md`
- `docs/09-reference/index.md`
- `docs/10-runbooks/index.md`

---

## Final Rule

If a change cannot be clearly tied to:
- one batch
- one concern
- one canonical owner

then do not implement it yet.
