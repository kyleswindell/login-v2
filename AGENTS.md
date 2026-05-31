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
- Only batch workflows (`batch-start`, `work-batch`, `batch-update-manual-review-status`, `batch-review-and-finalize`) may modify it.
- Do not manually alter its structure outside those workflows.
- Active `change-queue.md` items should use stable queue IDs in the format `P<phase>-<batch>-CQ-###`.
- `Implemented Pending Review` is reserved for queue items that are actually reviewable on the required review surface; if deployment is required for review, the item does not belong there until that deploy succeeds.
- Keep exploratory review discussion in chat until an agent normalizes it into concise queue language.
- When discussing an existing queue item in chat, reference its queue ID when available.

---

## Implementation and Docs Sync

- When implementing a planned system, update canonical docs and related planning notes in the same work cycle.
- Planning notes must reflect current implementation status.
- Canonical system docs and planning notes must remain linked.

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

- Use batch checkpoints for active batch execution:
  - batch initialized
  - implementation save points
  - review-ready
  - finalized

- For non-batch review or governance work:
  - keep one commit scoped to one review, sync pass, or governance concern
  - include only files directly required for that review or governance update
  - do not force batch checkpoint naming onto review-only work

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
- Exception: when the user provides clear manual-review feedback that unambiguously maps to existing active-batch items or to a concise new finding, that feedback itself authorizes `batch-update-manual-review-status`; do not stop just to confirm that the review-status skill should be executed.
- Read-only analysis, workflow interpretation, and prompt generation do not require confirmation.
- After completing a batch workflow step, report which workflow was executed, which files were updated, and what state changed.
- Review-only audit work must use `docs/11-ai/active-doc-reviews/` as its canonical artifact path and must not be treated as active batch workflow execution unless the user explicitly switches into a batch workflow step.

---

## Batch Workflow Enforcement

- Always execute batch work through:
  - `batch-start`
  - `work-batch`
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

## Concurrency Support Matrix

- Supported: one writable session in one working tree.
- Supported: multiple read-only planning, audit, or review sessions in the same folder while one writer owns edits.
- Supported: multiple writable sessions only when each writable session has its own branch and its own worktree.
- Not supported: concurrent `batch-start` or `work-batch` execution against the same shared `/docs/08-active/` workspace.
- Not supported: multiple writable sessions editing the same working tree folder at the same time.
- Not supported: concurrent review-ledger final writes without serialization, because `doc-review-####` and `doc-sync-####` IDs are sequential and the shared index is a collision point.
- Staging review ownership is single-branch at a time; only one non-`main` review branch should own staging during manual QA.

Coordination notes:

- worktree isolation is the real safety boundary for concurrent writable work
- advisory scope claims are coordination aids only and do not guarantee protection
- use `.agents/session-scope-claims.json` only as a lightweight visibility layer, not as a lock

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
- if the next action increases risk or changes workflow type, stop and ask unless the user already requested that exact workflow step

Workflow-specific authorization note:

- an explicitly requested batch workflow step authorizes the normal actions that workflow requires when its own completion criteria are met
- for `work-batch`, that includes scoped commit, push, and canonical staging deployment when the pass is review-ready and manual visual review is required
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
