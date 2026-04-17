# Document Sync Review 0005

## Review Pass
2

## Target
Batch workflow, `batch-start`, `work-batch`, `update-batch-manual-review-status`, and `batch-review-and-finalize` against `AGENTS.md` and runbooks

## Review Type
Docs Sync

## Status
CLOSED

## Purpose
Validate the current batch workflow skill set against the governing batch workflow runbooks and `AGENTS.md` after the recent batch-workflow corrections.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/git-batch-save-points.md`
- `docs/10-runbooks/index.md`
- `.agents/skills/batch-start.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/update-batch-manual-review-status.md`
- `.agents/skills/batch-review-and-finalize.md`

## Findings

### Finding 1
- type: conflict
- location: `AGENTS.md:46`, `AGENTS.md:102-105`, `docs/10-runbooks/batch-workflow.md:47-48`, `docs/10-runbooks/batch-workflow.md:195-196`, `.agents/skills/batch-start.md`, `.agents/skills/batch-review-and-finalize.md`
- issue: `AGENTS.md` and the canonical runbook define the workflow entry points as `start-batch`, `work-batch`, and `review-and-finalize-batch`, but the actual skill files are named `batch-start.md` and `batch-review-and-finalize.md`. The docs system currently names workflow entry points one way and stores the implementation files under different names without any explicit mapping.
- required action: Align the canonical workflow names and the actual skill file names, or add an explicit mapping so the documented entry points match the executable skill set.
- constraints: Preserve the same batch workflow phases and separation of concerns.
- decision state: required

### Finding 2
- type: conflict
- location: `.agents/skills/work-batch.md:22`, `.agents/skills/work-batch.md:166`, `AGENTS.md:74`, `docs/10-runbooks/batch-workflow.md:241-243`, `docs/10-runbooks/git-batch-save-points.md:1`
- issue: `work-batch.md` still instructs agents to use `docs/10-runbooks/git-batch-commit-workflow.md`, but `AGENTS.md` and the canonical batch workflow runbook point to `docs/10-runbooks/git-batch-save-points.md`, which is the actual file present in the repo. `work-batch` is still out of sync with the canonical git workflow owner.
- required action: Normalize `work-batch.md` to the existing canonical git batch runbook path.
- constraints: Keep one canonical owner for batch commit guidance.
- decision state: required

### Finding 3
- type: conflict
- location: `docs/10-runbooks/batch-workflow.md:89-99`, `docs/10-runbooks/batch-workflow.md:230-235`, `.agents/skills/batch-start.md:95-105`, `.agents/skills/work-batch.md:122-141`, `.agents/skills/update-batch-manual-review-status.md:30-49`, `.agents/skills/batch-review-and-finalize.md:53-65`
- issue: The canonical runbook still defines `change-queue.md` as a manual-review-owned document with sections `New Findings`, `Confirmed Fixed`, and `Deferred / Out of Scope`, but the active skills use a lifecycle model with `Ready To Implement`, `In Progress`, `Implemented Pending Review`, `Blocked`, `Deferred`, `Passed Review`, and `Closed`. The runbook and skills currently enforce two different queue models.
- required action: Reconcile the canonical runbook and the active skills to one `change-queue.md` lifecycle model.
- constraints: Keep the queue under a single canonical structure; do not leave two competing state systems active.
- decision state: required

### Finding 4
- type: conflict
- location: `AGENTS.md:44-47`, `docs/10-runbooks/batch-workflow.md:171-181`, `.agents/skills/update-batch-manual-review-status.md:5-20`
- issue: `AGENTS.md` says only the batch workflows `start-batch`, `work-batch`, and `review-and-finalize-batch` may modify `/docs/08-active/`, but `update-batch-manual-review-status.md` also modifies `/docs/08-active/` and is effectively the concrete manual-review update step. The active manual-review workflow exists, but it is not recognized by the governing workspace-ownership rule.
- required action: Either include the manual-review update skill in the allowed `/docs/08-active/` workflow set or revise the runbook/skill structure so the manual review step is explicitly covered by the documented workflow list.
- constraints: Preserve workspace ownership discipline; do not create an undocumented writer to `/docs/08-active/`.
- decision state: required

## Summary
- standards alignment: not applicable for this pass; the scope is workflow and operational docs
- contract accuracy: not applicable for this pass
- implementation vs docs consistency: partial; the batch workflow docs are closer than before, but the active skill filenames, git-runbook reference in `work-batch`, `change-queue` lifecycle, and manual-review ownership still drift from the governing docs

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- batch workflow entry-point names match the actual skill files or have an explicit canonical mapping
- all batch git guidance points to one canonical runbook path
- `change-queue.md` has one canonical lifecycle model across runbooks and skills
- `/docs/08-active/` ownership rules explicitly cover the actual manual-review update step

## Resolution Notes
- Updated `AGENTS.md` to recognize the actual active batch workflow skills: `batch-start`, `work-batch`, `update-batch-manual-review-status`, and `batch-review-and-finalize`.
- Updated `docs/10-runbooks/batch-workflow.md` to match the current skill names, document `update-batch-manual-review-status` as the manual-review writer, and replace the old `change-queue.md` section model with the lifecycle used by the skills.
- Added `docs/10-runbooks/git-batch-commit-workflow.md` as the canonical commit workflow path because `work-batch.md` already points to that runbook.
- Reduced `docs/10-runbooks/git-batch-save-points.md` to a compatibility alias so there is one canonical owner and the docs still explain the older filename.
- Added the canonical commit workflow to `docs/10-runbooks/index.md`.
- Re-reviewed in `doc-sync-0006`; no remaining drift was found in the scoped batch workflow docs and skills.
- Findings unresolved: none.
- Blockers: none.
