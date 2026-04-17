# Active Document Reviews Index

Tracks in-progress and recently completed document review passes.

---

## Entries

| ID               | Date       | Target                              | Type        | Status                      | Implementation Status          | Notes |
|------------------|------------|-------------------------------------|-------------|-----------------------------|--------------------------------|-------|
| doc-review-0001  | 2026-04-17 | `docs/10-runbooks/batch-workflow.md` | Docs Review | CLOSED                      | implemented                    | Re-validated after docs sync fixes; prior workflow conflicts are resolved |
| doc-review-0002  | 2026-04-17 | `.agents/skills/start-batch.md`, `.agents/skills/review-and-finalize-batch.md` | Docs Review | CLOSED                      | implemented                    | Additional pass confirmed prior findings are resolved |
| doc-sync-0003    | 2026-04-17 | Updated batch workflow and related skills after `doc-review-0002` closure | Docs Sync   | IMPLEMENTED_PENDING_REVIEW  | implemented                    | Canonical runbook refs, workflow naming, runbook index, and review ledger were synchronized |
| doc-sync-0004    | 2026-04-17 | Batch workflow docs sync after `doc-sync-0003` fixes | Docs Sync   | CLOSED                      | implemented                    | Closed after `doc-review-0001` status was corrected and no remaining drift remained |
| doc-sync-0005    | 2026-04-17 | Batch workflow, `batch-start`, `work-batch`, `update-batch-manual-review-status`, and `batch-review-and-finalize` against `AGENTS.md` and runbooks | Docs Sync   | CLOSED                      | implemented                    | Closed after `doc-sync-0006` confirmed no remaining drift in the scoped workflow docs and skills |
| doc-sync-0006    | 2026-04-17 | Re-review of `doc-sync-0005` batch workflow sync updates | Docs Sync   | CLOSED                      | implemented                    | Re-review found no remaining drift in the scoped batch workflow docs and skills |
| doc-sync-0007    | 2026-04-17 | Batch workflow, `batch-start`, `work-batch`, `update-batch-manual-review-status`, `batch-review-and-finalize`, change-queue lifecycle, checklist state model, and `AGENTS.md` | Docs Sync   | CLOSED                      | implemented                    | Review found no remaining drift in the scoped batch workflow docs and skills |
| doc-sync-0008    | 2026-04-17 | Batch checklist workflow across `batch-workflow.md`, `checklist.md`, `batch-start`, `work-batch`, `batch-update-manual-review-status`, `batch-review-and-finalize`, change-queue lifecycle, checklist state model, and `AGENTS.md` | Docs Sync   | CLOSED                      | implemented                    | Re-review confirmed no remaining drift in the scoped checklist workflow docs and skills |
| doc-sync-0009    | 2026-04-17 | `batch-generate-manual-review-checklist` and active-batch manual review checklist output contract | Docs Sync   | CLOSED                      | implemented                    | Manual review passed; re-review confirmed no remaining drift in the scoped checklist-generation workflow |

---

## Naming Rules

- File names must follow:
  - `doc-review-####.md`
  - `doc-sync-####.md`
- IDs must be:
  - sequential within each type
  - zero-padded (0001, 0002, ...)
- Do NOT reuse or overwrite IDs

---

## Status Definitions

### Review Status

- `OPEN` → review created, findings active
- `PARTIAL` → findings partially addressed
- `READY_FOR_IMPLEMENTATION` → review complete, ready for correction pass
- `IMPLEMENTED_PENDING_REVIEW` → corrections applied, re-review required
- `CLOSED` → review findings resolved

### Implementation Status

- `not started`
- `in progress`
- `implemented`
- `implemented with follow-up needed`

---

## Rules

- Add a new row for every new review file created
- Update the same row as the review progresses
- Do NOT modify historical entries except to correct factual errors
- Status must reflect actual state, not assumptions
- Keep entries concise and scannable
