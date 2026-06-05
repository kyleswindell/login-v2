# Dirty Worktree Scope Review - 2026-06-05

Purpose: reduce repeated broad diff reads by grouping current dirty work into reviewable concerns. This is a repo-local working memory note, not canonical project truth.

## Recommended Handling

- Commit or review one concern group at a time.
- Do not mix active batch state, governance docs, frontend refactors, controller extraction, and environment changes in one commit.
- Keep `storage/review.sqlite` out of commits unless a later workflow explicitly proves it is an intended repo artifact.

## Concern Groups

### 1. Active Batch F State

Files:
- `docs/08-active/change-queue.md`
- `docs/08-active/notes.md`
- `docs/08-active/review.md`
- `docs/08-active/worklogs/worklog-2-F-0006.md`

Status:
- Active workspace cleanup and new Batch F queue bookkeeping are present.
- Worklog edits should be reviewed carefully because worklogs are normally immutable history.

Recommended action:
- Review separately under active batch workflow rules before committing.

### 2. Token-Hygiene And Agent Governance

Files:
- `.agents/AGENTS.md`
- `.agents/memory/working/token-usage-observations.md`
- `.agents/skills/batch-generate-work-prompt.md`
- `.agents/skills/review-docs-sync.md`
- `.agents/skills/review-document.md`
- `.agents/skills/work-batch.md`
- `docs/10-runbooks/AGENTS.md`
- `docs/10-runbooks/agent-token-efficiency.md`
- `docs/10-runbooks/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-2026-06-05-solid-token-efficiency-architecture-audit.md`
- `docs/11-ai/active-doc-reviews/doc-review-2026-06-05-platform-solid-hotspot-audit.md`
- `docs/11-ai/active-doc-reviews/index.md`

Status:
- Token-hygiene review is closed.
- SOLID hotspot audit is closed.
- Prompt/read-budget fields are present in core runbook and skills.

Recommended action:
- Commit as one governance concern after final review.

### 3. Branch/Workflow Governance And Runbook Restructure

Files:
- `.agents/skills/batch-update-manual-review-status.md`
- `.agents/skills/orchestrate-work-batch-branches.md`
- `.agents/skills/work-batch-branch.md`
- `AGENTS.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/batch-workflow/`
- `docs/10-runbooks/branch-based-batch-integration.md`
- `docs/10-runbooks/git-batch-commit-workflow.md`
- `docs/10-runbooks/git-batch-commit-workflow/`
- `docs/10-runbooks/local-dev.md`

Status:
- Appears to be broader workflow/concurrency cleanup from earlier work.
- Needs separate review from token/SOLID closure.

Recommended action:
- Review and commit separately from current UI/token changes.

### 4. Documentation Standards And UI Standards Cleanup

Files:
- `docs/02-standards/documentation/Doc Governance.md`
- `docs/02-standards/documentation/Documentation Review Standards.md`
- `docs/02-standards/documentation/How To Write Docs.md`
- `docs/02-standards/index.md`
- `docs/02-standards/ui/UI UX System Index.md`
- `docs/02-standards/ui/components/Tier 2 Pattern Library Checklist.md`
- `docs/02-standards/ui/components/tier-2-patterns/`
- branch-level `AGENTS.md` files under `docs/`

Status:
- Appears to be docs structure and standards cleanup from earlier token-efficiency work.

Recommended action:
- Review as docs-governance concern before committing.

### 5. Frontend Token/SOLID Refactor

Files:
- `resources/AGENTS.md`
- `resources/js/app.js`
- `resources/js/log-drawers.js`
- `resources/js/realtime-notifications.js`
- `resources/js/shell-ui.js`
- `resources/js/ui-controls.js`
- `resources/js/ui-reference.js`
- `resources/css/app.css`

Status:
- `app.js` was reduced to lifecycle registration/imports.
- CSS gained a read map only.
- `ui-controls.js` and CSS cleanup are now queued as Batch F follow-ups.

Recommended action:
- Commit separately from backend controller extraction and active batch queue state.

### 6. UI Reference Controller Extraction

Files:
- `app/Http/Controllers/Platform/UiReferenceController.php`
- `app/Platform/UiReference/UiReferenceSamples.php`
- `app/Platform/UiReference/UiReferenceTables.php`
- `resources/views/platform/ui-reference/patterns/widget-content.blade.php`

Status:
- SOLID high-impact finding is resolved and review is closed.
- `PlatformUiReferenceTest` passed in Docker.

Recommended action:
- Commit as one code refactor concern.

### 7. Layout And UI Reference View Split

Files:
- `resources/views/components/layouts/app.blade.php`
- `resources/views/components/layouts/app/`
- `resources/views/platform/ui-reference/index.blade.php`
- `resources/views/platform/ui-reference/index/`
- `resources/views/platform/ui-reference/patterns/tables.blade.php`
- `resources/views/platform/ui-reference/patterns/tables/`
- related `AGENTS.md` files under `resources/views/`

Status:
- Appears to be prior view decomposition and local read-map work.
- Overlaps with active Batch F UI Reference work but is separate from the SOLID controller extraction.

Recommended action:
- Review against Batch F queue ownership before committing.

### 8. Environment And Miscellaneous

Files:
- `docker-compose.yml`
- `.github/AGENTS.md`
- top-level folder `AGENTS.md` additions outside docs/resources/app
- `storage/review.sqlite`

Status:
- Environment/config and local artifact changes should not be bundled with docs/code cleanup.

Recommended action:
- Review separately; avoid committing `storage/review.sqlite` unless intentionally promoted.
