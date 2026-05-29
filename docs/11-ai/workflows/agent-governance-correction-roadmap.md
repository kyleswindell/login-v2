# Agent Governance Correction Roadmap

## Purpose

Define the ordered correction path that was used for the 2026-05 AI governance and skill-document review set.

This file is retained as a historical sequencing reference after that correction wave was implemented.

This roadmap consolidates the active review findings from:

- `docs/11-ai/active-doc-reviews/doc-review-0004.md`
- `docs/11-ai/active-doc-reviews/doc-review-0005.md`
- `docs/11-ai/active-doc-reviews/doc-review-0007.md`
- `docs/11-ai/active-doc-reviews/doc-review-0008.md`
- `docs/11-ai/active-doc-reviews/doc-review-0010.md`
- `docs/11-ai/active-doc-reviews/doc-review-0011.md`
- `docs/11-ai/active-doc-reviews/doc-review-0012.md`
- `docs/11-ai/active-doc-reviews/doc-review-0013.md`
- `docs/11-ai/active-doc-reviews/doc-review-0014.md`
- `docs/11-ai/active-doc-reviews/doc-review-0015.md`

The goal is not to restate every finding. The goal is to define the safest implementation order, the dependency chain between open reviews, and the decisions that must be settled before lower-level doc fixes should proceed.

## Current State

The referenced review set is now closed in the active review ledger. This roadmap remains useful as rationale for the implementation order and the boundary decisions that were adopted.

At the time this roadmap was created, the active review set was broadly aligned. Most findings fell into one of four buckets:

1. canonical workflow boundary clarity
2. writable-skill hardening
3. concurrency and multi-session governance
4. benchmark and source-quality expansion

There is little conceptual disagreement across the review set. The main drift is historical and procedural:

- some reviews still reflect older canonical path assumptions
- some reviews assume batch-only governance where later reviews correctly widen the model to review-only work
- the benchmark is still skill-centric even though later reviews now require a broader instruction-system model

## Existing Repo Coverage To Preserve

The roadmap should not treat every external AI-documentation suggestion as an unmet need. Several concepts are already covered well by the current docs system and should be preserved rather than replaced:

- roadmap and sequencing already have a canonical home in `docs/07-planning/roadmap.md` plus the phase and batch indexes
- active implementation status already has a canonical home in `docs/08-active/`
- chronological delivery traceability already has a canonical home in `docs/08-active/worklogs/` and the worklog index, including date, batch/pass ID, commit state, deploy state, and follow-up notes
- implementation-status synchronization rules already have a canonical home in `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`
- Obsidian/vault path stability, graph structure, and branch ownership already have canonical standards under `docs/02-standards/documentation/`

The correction work should therefore prefer:

- mapping generic advice into existing canonical branches
- strengthening agent guidance about when to reuse those branches
- avoiding duplicate AI-convenience files when the repo already has a stronger owner path

## Key Drift Points

### 1. Canonical Git Runbook Naming Drift

The review history still reflects two naming eras:

- `docs/10-runbooks/git-batch-save-points.md`
- `docs/10-runbooks/git-batch-commit-workflow.md`

This is primarily a chronology issue, not a theory conflict, but it must be normalized before the remaining governance corrections are implemented.

### 2. Batch-Only Versus Review-Only Governance Drift

Earlier workflow corrections focused on `/docs/08-active/` and batch execution.

Later reviews correctly identify that:

- `AGENTS.md` currently over-applies batch rules to non-batch review work
- review-only audit workflows need their own explicit storage and procedure path
- unrelated issue recording cannot default to `/docs/08-active/notes.md` outside active batch implementation work

### 3. Skill-Centric Versus System-Centric Benchmark Drift

The current benchmark is still framed mainly around `SKILL.md` quality.

Later reviews now require the benchmark to cover:

- `AGENTS.md` persistence and layering
- `SKILL.md` progressive disclosure and execution packaging
- source weighting between official, secondary, and discovery-only guidance
- tool-specific instruction ecosystems rather than a flattened “all agent files work the same” model

### 4. Singleton Workflow Versus Parallel Session Ambition

The repo already has runbooks discussing multiple sessions and worktrees, but the open reviews correctly identify that:

- `/docs/08-active/` is a singleton active batch workspace
- worktrees alone do not make `batch-start` or `work-batch` safe to run concurrently
- concurrency claims need a support matrix, advisory claim layer, and explicit non-support statements where appropriate

### 5. Decision-Record Elevation Drift

The canonical decision-record branch now exists, but the repo still needs a clearer operating rule for when decisions should be elevated into ADRs versus remaining inside architecture or planning owner notes.

The current state is:

- `How To Write Docs` treats `01-decisions/` as the canonical home for ADRs and decision records
- the ADR template already exists
- `docs/01-decisions/` is now active as a live branch
- planning notes and architecture notes already record meaningful decisions in practice

This is not a reason to add scattered `decisions.md` files. It is a reason to settle the ADR elevation rule explicitly.

## Correction Strategy

Implement the open corrections in the following order.

### Phase 1: Re-establish Canonical Governance Boundaries

Priority: highest

Resolve the governing rules before updating additional skills.

Required outputs:

- scope `AGENTS.md` commit rules correctly between batch and non-batch work
- define the review-only workflow/storage path under `docs/11-ai/active-doc-reviews/`
- scope the unrelated-issue recording rule so non-batch review findings do not default to `/docs/08-active/notes.md`
- settle the canonical git runbook path and remove historical ambiguity
- publish a reuse map for common AI-documentation suggestions so agents know that:
  - roadmap intent belongs in `docs/07-planning/`
  - active implementation status belongs in `docs/08-active/`
  - chronological update traceability belongs in dated worklogs plus git-batch-linked commit/deploy notes
  - generic AI-context files should not duplicate those existing owners

Primary source reviews driving this phase:

- `doc-review-0013`
- historical drift noted across `doc-review-0001`, `doc-sync-0003`, `doc-sync-0005`, and `doc-review-0012`

Why this phase comes first:

- writable skills should not be tightened further while the governing repo rules still blur batch and non-batch behavior

### Phase 2: Expand the Benchmark Into a Full Instruction-System Benchmark

Priority: high

Once governance boundaries are correct, widen the benchmark so future skill and agent-file reviews use the same model.

Required outputs:

- add `AGENTS.md` versus `SKILL.md` loading-model distinctions
- add source-weighting rules
- add commercial production characteristics for strong `AGENTS.md` files
- add commercial authoring heuristics for:
  - command-first root-file structure
  - compact high-signal root files with lower-scope specialization
  - targeted verification commands before full-suite commands
  - good-example and avoid-example anchors where the repo has clear exemplars
- add tool-scoped instruction ecosystem guidance
- add explicit checks for duplication between canonical docs and skill bodies
- add explicit checks that roadmap/status/versioning suggestions are normalized against existing planning and worklog surfaces before new files are introduced
- add explicit guidance that timestamped delivery history should prefer dated worklogs, batch IDs, and commit/deploy references over ad hoc `Last Updated` style tracking fields
- add explicit guidance for how decision records are stored and when ADR elevation is expected

Primary source reviews driving this phase:

- `doc-review-0015`

Why this phase comes before most remaining skill updates:

- several open skill reviews should be corrected against the broadened benchmark, not only the earlier skill-centric one

### Phase 3: Repair Review-Workflow Skill Ownership

Priority: high

The review workflow skill set is currently the least stable part of the system outside concurrency.

Required outputs:

- rewrite or remove `review-document.md` as a fake skill/template hybrid
- clarify ownership split between `implement-docs-fix.md` and `implement-docs-sync-fix.md`
- declare exact write targets and stop conditions in `review-docs-sync.md`
- ensure review-oriented doc updates respect the existing implementation-status sync and worklog model instead of inventing alternate tracking conventions

Primary source reviews driving this phase:

- `doc-review-0008`
- `doc-review-0010`
- `doc-review-0011`

Why this phase comes before concurrency:

- concurrent writable review flows cannot be designed safely while the base review-writing skills are still ambiguous or non-executable

### Phase 4: Harden Remaining Batch Workflow Skills

Priority: medium-high

After the benchmark and ownership model are stable, apply the narrower corrections to the remaining batch workflow skills.

Required outputs:

- `batch-generate-work-prompt.md`
  - remove stale `worklog.md` references
  - add stop conditions for missing or empty active context
- `batch-update-manual-review-status.md`
  - add explicit halt conditions for ambiguous human review input
- `batch-review-and-finalize.md`
  - define archive naming and collision stop conditions
- `work-batch.md`
  - declare full read/write scope including `review.md` and `notes.md`
  - point deployment behavior to the canonical deployment runbook and preconditions

Primary source reviews driving this phase:

- `doc-review-0004`
- `doc-review-0005`
- `doc-review-0007`
- `doc-review-0012`

Why this phase is fourth:

- these are mostly local hardening fixes and do not require the same level of architectural decision-making as the earlier phases

### Phase 5: Define the Concurrency Support Model

Priority: medium-high

Only begin this phase after the governing rules, benchmark, and review-writing skills are corrected.

Required outputs:

- explicit support matrix covering:
  - single writer in one shared folder
  - multiple writers in separate worktrees
  - singleton active batch behavior
  - review-writing concurrency limits
  - staging/deployment ownership boundaries
- advisory scope-claim design, if adopted
- writable skill preflight for branch/worktree/session-role checks
- decision on review ledger ID collision handling
- Codex app worktree path documented as first-class where relevant

Primary source reviews driving this phase:

- `doc-review-0014`

Why this phase is not first:

- the concurrency review is correct, but it depends on unresolved decisions in the governance and review-writing layers

## Dependency Map

### Must Be Settled Before Skill Hardening

- canonical git workflow owner/path
- batch-only versus review-only governance split
- benchmark breadth beyond `SKILL.md`
- decision-record elevation rule

### Must Be Settled Before Concurrency Work

- whether `review-document.md` is rewritten or removed
- whether review-only workflows have explicit canonical procedures
- whether the repo wants review ledger IDs to remain sequential under concurrent authorship

### Can Be Implemented In Parallel After Phase 2

Once Phases 1 and 2 are complete, these can likely be corrected in parallel review/fix passes:

- `batch-generate-work-prompt.md`
- `batch-update-manual-review-status.md`
- `batch-review-and-finalize.md`
- `work-batch.md`
- `review-docs-sync.md`
- `implement-docs-fix.md`

## Recommended Implementation Units

To keep changes reviewable, use the following correction units:

1. `AGENTS.md` governance clarification pass
2. benchmark expansion pass
3. review-skill ownership and rewrite pass
4. remaining batch-skill hardening pass
5. concurrency support-matrix and claim-layer pass

Do not combine all open review corrections into one implementation pass.

## Proposed Near-Term Sequence

### Immediate Next Step

Create and execute a correction pass for:

- `doc-review-0013`
- the canonical git-runbook naming drift those findings depend on

This is the smallest correction that unlocks the rest of the roadmap cleanly.

### Next After That

Create and execute a correction pass for:

- `doc-review-0015`

That will give later skill revisions a stronger benchmark and source-weighting model, and it should explicitly preserve the repo’s existing roadmap/worklog/status system rather than implying those concepts still need new generic files.
It should also capture the useful secondary heuristics around command ordering, compact root-file scope, and targeted verification without treating numeric line-count advice as a hard standard.

### Then

Create a combined review-workflow correction pass for:

- `doc-review-0008`
- `doc-review-0010`
- `doc-review-0011`

### Then

Create a batch-skill hardening pass for:

- `doc-review-0004`
- `doc-review-0005`
- `doc-review-0007`
- `doc-review-0012`

### Finally

Create the concurrency-governance correction pass for:

- `doc-review-0014`

This should be last because it spans the largest surface and depends on the earlier governance clarifications.

## Success Condition

The roadmap is complete when:

- `AGENTS.md` cleanly distinguishes batch, review-only, and approval-gated behavior
- the benchmark covers both instruction quality and source quality
- the benchmark explicitly maps common AI-documentation suggestions to the repo’s existing planning, worklog, and status-sync surfaces
- the repo states where decision records canonically live and when decisions should be elevated into ADRs
- the benchmark distinguishes between primary behavior rules and secondary commercial heuristics such as compact root files, command-first ordering, and layered specificity
- all writable skills declare exact authority, stop conditions, and escalation boundaries
- the repo states which concurrent modes are supported and which are intentionally singleton-only
- no review file still depends on historical or ambiguous workflow assumptions
