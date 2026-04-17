# Document Sync Review 0003

## Review Pass
2

## Target
Updated batch workflow and related skills after `doc-review-0002` closure

## Review Type
Docs Sync

## Status
IMPLEMENTED_PENDING_REVIEW

## Purpose
Validate that the corrected batch workflow skills remain synchronized with the canonical batch workflow runbook, governing repo instructions, and active docs-review tracking after `doc-review-0002` was closed.

## Scope
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/index.md`
- `docs/10-runbooks/git-batch-save-points.md`
- `AGENTS.md`
- `.agents/skills/start-batch.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/review-and-finalize-batch.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0002.md`

## Findings

### Finding 1
- type: conflict
- location: `docs/10-runbooks/batch-workflow.md:241-243`, `AGENTS.md:72-85`, `.agents/skills/work-batch.md:22`, `.agents/skills/work-batch.md:163`, `docs/10-runbooks/git-batch-save-points.md:1`
- issue: The corrected skills and `AGENTS.md` still point to `docs/10-runbooks/git-batch-commit-workflow.md`, but the canonical runbook path present in the repo is `docs/10-runbooks/git-batch-save-points.md`, and `batch-workflow.md` also points to that file. The docs system still has two competing commit-workflow names, and one of them does not exist.
- required action: Normalize all batch git-workflow references to the one canonical runbook path that actually exists in the repo.
- constraints: Keep one operational owner for batch commit guidance; do not leave dual references.
- decision state: required

### Finding 2
- type: inconsistency
- location: `docs/10-runbooks/batch-workflow.md:47-49`, `docs/10-runbooks/batch-workflow.md:152-196`, `AGENTS.md:100-105`, `.agents/skills/start-batch.md:23`, `.agents/skills/work-batch.md:3`, `.agents/skills/review-and-finalize-batch.md:1`
- issue: The runbook still uses actor labels such as `Batch Management Agent`, `Batch Work Implementation Agent`, and `Batch Manual Review Agent`, while the governing repo instructions and corrected skills define the workflow by the actual entry points `start-batch`, `work-batch`, and `review-and-finalize-batch`. The corrected skill set and the canonical runbook are still not using the same workflow vocabulary.
- required action: Align the runbook wording to the active workflow names or explicitly map actor labels to those workflow entry points.
- constraints: Preserve the separation between start, work, manual review, and finalize responsibilities.
- decision state: required

### Finding 3
- type: gap
- location: `docs/10-runbooks/index.md:20-31`, `docs/10-runbooks/batch-workflow.md:1`
- issue: `batch-workflow.md` still is not listed in the canonical runbook index. The workflow exists, but it is still not discoverable from the branch hub.
- required action: Add the batch workflow runbook to `docs/10-runbooks/index.md`.
- constraints: Keep the index within runbook ownership only.
- decision state: required

### Finding 4
- type: inconsistency
- location: `docs/10-runbooks/batch-workflow.md:289`
- issue: The batch workflow runbook still ends with a stray closing code fence. This is a formatting defect in the canonical workflow doc.
- required action: Remove the stray closing code fence.
- constraints: No content redesign required.
- decision state: required

### Finding 5
- type: conflict
- location: `docs/10-runbooks/git-batch-save-points.md:144-196`, `.agents/skills/work-batch.md:185-198`, `.agents/skills/review-and-finalize-batch.md:91-99`
- issue: `git-batch-save-points.md` still contains an appended `Review Batch` skill block that refers to `worklog.md`, but the active batch workflow and corrected skills now use `/docs/08-active/worklogs/index.md` plus per-pass worklog files. The runbook content itself is therefore still not synchronized with the corrected active-workspace model.
- required action: Remove or reconcile the appended skill block so the runbook reflects the current `/worklogs/` model only.
- constraints: Keep one canonical active-workspace history model; do not reintroduce `worklog.md`.
- decision state: required

### Finding 6
- type: gap
- location: `docs/11-ai/active-doc-reviews/index.md:13`
- issue: The active review index still contains a placeholder `doc-sync-0002` row with no real date, target, or corresponding review file. That breaks the review ledger after `doc-review-0002` closure and makes sequential docs-sync tracking unreliable.
- required action: Replace the placeholder with a real review record or remove it and keep the index synchronized to actual files.
- constraints: Do not reuse IDs silently; the index must reflect real review artifacts only.
- decision state: required

## Summary
- standards alignment: not applicable for this pass; the drift is in workflow/runbook ownership and operational references
- contract accuracy: not applicable for this pass; no component-contract review was required
- implementation vs docs consistency: partial; the corrected skills are internally aligned, but the canonical runbook layer and active review index are still out of sync

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the canonical batch workflow runbook matches the corrected active workflow skills
- all batch git-workflow references point to one canonical runbook path
- the batch workflow runbook is indexed from `docs/10-runbooks/index.md`
- no stale `worklog.md` guidance remains in batch workflow materials
- the active docs-review index reflects only real review records with matching files

## Resolution Notes
- Updated `AGENTS.md` and `.agents/skills/work-batch.md` to point all batch commit guidance at the existing canonical runbook: `docs/10-runbooks/git-batch-save-points.md`.
- Updated `docs/10-runbooks/batch-workflow.md` to use the active workflow vocabulary: `start-batch`, `work-batch`, manual review, and `review-and-finalize-batch`.
- Added `docs/10-runbooks/batch-workflow.md` to the canonical runbook index in `docs/10-runbooks/index.md`.
- Removed the stray closing code fence from `docs/10-runbooks/batch-workflow.md`.
- Removed the appended `Review Batch` skill block from `docs/10-runbooks/git-batch-save-points.md` so the runbook no longer reintroduces stale `worklog.md` guidance.
- Removed the placeholder `doc-sync-0002` row from `docs/11-ai/active-doc-reviews/index.md` so the ledger reflects real review artifacts only.
- Findings unresolved: none.
- Blockers: none.
