# Document Review 0001

## Review Pass
1

## Target
`docs/10-runbooks/batch-workflow.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Review the new batch workflow runbook for correctness, internal consistency, and alignment with the current active batch workflow files and governing repo instructions.

## Scope
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/index.md`
- `docs/10-runbooks/git-batch-save-points.md`
- `AGENTS.md`
- `.agents/skills/start-batch.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/update-batch-manual-review-status.md`
- `.agents/skills/review-and-finalize-batch.md`
- `docs/11-ai/rules.md`

## Findings

### Finding 1
- type: conflict
- location: `docs/10-runbooks/batch-workflow.md:23-33`, `docs/10-runbooks/batch-workflow.md:103-119`, `.agents/skills/start-batch.md:20-26`, `.agents/skills/start-batch.md:46-58`, `.agents/skills/review-and-finalize-batch.md:8-12`
- issue: The runbook defines `/docs/08-active/worklogs/index.md` plus per-pass `worklog-<phase>-<batch>-####.md` files as the active workspace history model, but the current start/finalize skills still operate on a root-level `worklog.md`. The workflow document and the active workflow skills disagree on the shape of `/docs/08-active/`.
- required action: Align the runbook and active workflow skills to one worklog model. Either the runbook must reflect the current root `worklog.md` workflow, or the skills must be updated to the `/worklogs/` structure before this runbook can be treated as canonical.
- constraints: Keep `/docs/08-active/` as a workflow-controlled workspace and do not create mixed history models.
- decision state: resolved in favor of needing a single canonical active-workspace structure; current documents conflict

### Finding 2
- type: conflict
- location: `docs/10-runbooks/batch-workflow.md:239-243`, `AGENTS.md:74`, `.agents/skills/work-batch.md:21`, `.agents/skills/work-batch.md:172`
- issue: The runbook tells readers to follow `docs/10-runbooks/git-batch-save-points.md`, while AGENTS and the active `work-batch` skill instruct agents to follow `docs/10-runbooks/git-batch-commit-workflow.md`. The current operational guidance points to two different canonical runbook names for the same commit workflow.
- required action: Normalize all workflow references to one canonical git batch runbook path and title.
- constraints: Do not leave dual canonical references for the same operational procedure.
- decision state: resolved in favor of one canonical runbook reference; current documents conflict

### Finding 3
- type: ambiguity
- location: `docs/10-runbooks/batch-workflow.md:47-48`, `docs/10-runbooks/batch-workflow.md:195-196`, `AGENTS.md:45-46`, `AGENTS.md:102-105`
- issue: The runbook uses actor names such as `Batch Management Agent`, `Batch Work Implementation Agent`, and `Batch Manual Review Agent`, but the governing repo instructions define the workflow in terms of `start-batch`, `work-batch`, and `review-and-finalize-batch`. The runbook does not map these actor names back to the actual workflow entry points, which makes execution ownership ambiguous.
- required action: Align role naming to the actual workflow names or explicitly map actor labels to the workflow skills that implement them.
- constraints: Preserve separation between start, work, manual review, and finalize steps.
- decision state: resolved in favor of explicit workflow-name alignment; current wording is ambiguous

### Finding 4
- type: gap
- location: `docs/10-runbooks/index.md`
- issue: The new `batch-workflow.md` runbook is not listed in the runbook index, so it is not discoverable from the canonical branch hub.
- required action: Add the new runbook to the canonical runbook index once the document is corrected.
- constraints: Keep index entries within runbook branch ownership only.
- decision state: resolved

### Finding 5
- type: inconsistency
- location: `docs/10-runbooks/batch-workflow.md:291`
- issue: The document ends with a stray closing code fence. The body is not opened as a code block, so the trailing fence is a formatting defect in the runbook.
- required action: Remove the stray closing code fence.
- constraints: No content redesign required.
- decision state: resolved

## Summary
- document correctness: not yet clean enough to treat as canonical due to workflow conflicts
- workflow alignment: conflicts exist with current active batch skills and AGENTS guidance
- implementation readiness: ready for a focused document-fix pass after conflicts are reconciled

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the batch workflow runbook matches the active `/docs/08-active/` structure
- all git workflow references point to one canonical runbook
- workflow actor naming maps cleanly to the active skills
- the runbook is indexed in `docs/10-runbooks/index.md`
- no formatting defects remain

## Resolution Notes
- Re-validated after the `doc-sync-0003` correction pass.
- `docs/10-runbooks/batch-workflow.md` now matches the active `/docs/08-active/` worklog structure and workflow naming.
- Batch git workflow references are normalized to `docs/10-runbooks/git-batch-save-points.md`.
- `docs/10-runbooks/batch-workflow.md` is indexed in `docs/10-runbooks/index.md`.
- The stray closing code fence was removed from `docs/10-runbooks/batch-workflow.md`.
- No remaining findings from this review remain active.
