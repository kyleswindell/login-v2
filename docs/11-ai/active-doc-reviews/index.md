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
| doc-review-0003  | 2026-05-29 | `.agents/skills/batch-generate-manual-review-checklist.md` | Docs Review | CLOSED                      | implemented                    | Benchmark audit found no material gaps in the reviewed scope |
| doc-review-0004  | 2026-05-29 | `.agents/skills/batch-generate-work-prompt.md` | Docs Review | CLOSED                      | implemented                    | Prompt generation now uses the canonical `/worklogs/` model and halts on missing or non-actionable active state |
| doc-review-0005  | 2026-05-29 | `.agents/skills/batch-review-and-finalize.md` | Docs Review | CLOSED                      | implemented                    | Finalize skill now defines archive naming and archive-collision halt conditions |
| doc-review-0006  | 2026-05-29 | `.agents/skills/batch-start.md` | Docs Review | CLOSED                      | implemented                    | Benchmark audit found no material gaps in the reviewed scope |
| doc-review-0007  | 2026-05-29 | `.agents/skills/batch-update-manual-review-status.md` | Docs Review | CLOSED                      | implemented                    | Manual-review status skill now fails closed on ambiguous or non-mappable review input |
| doc-review-0008  | 2026-05-29 | `.agents/skills/implement-docs-fix.md` | Docs Review | CLOSED                      | implemented                    | `implement-docs-fix` now routes `doc-sync` records to the dedicated docs-sync fix workflow |
| doc-review-0009  | 2026-05-29 | `.agents/skills/implement-docs-sync-fix.md` | Docs Review | CLOSED                      | implemented                    | Benchmark audit found no material gaps in the reviewed scope |
| doc-review-0010  | 2026-05-29 | `.agents/skills/review-docs-sync.md` | Docs Review | CLOSED                      | implemented                    | `review-docs-sync` now declares exact review-artifact writes and halts on missing or overly broad targets |
| doc-review-0011  | 2026-05-29 | `.agents/skills/review-document.md` | Docs Review | CLOSED                      | implemented                    | `review-document` was rewritten into an actual review skill with a real output contract |
| doc-review-0012  | 2026-05-29 | `.agents/skills/work-batch.md` | Docs Review | CLOSED                      | implemented                    | `work-batch` now declares all mutated active-batch files and references the canonical deployment runbooks |
| doc-review-0013  | 2026-05-29 | `AGENTS.md` | Docs Review | CLOSED                      | implemented                    | `AGENTS.md` now distinguishes active batch execution from review-only governance work and scopes batch commit rules correctly |
| doc-review-0014  | 2026-05-29 | `AGENTS.md`, concurrency runbooks, and writable review/batch skills | Docs Review | CLOSED                      | implemented                    | Concurrency support, advisory claims, writable-skill preflights, and automation policy are now documented with singleton batch execution preserved |
| doc-review-0015  | 2026-05-29 | `docs/11-ai/agent-skill-writing-benchmark.md` and attached commercial `AGENTS.md` / `SKILL.md` source pack | Docs Review | CLOSED                      | implemented                    | Benchmark was broadened, source-weighted, and re-reviewed cleanly against the updated roadmap |
| doc-review-0016  | 2026-05-29 | `docs/00-start-here.md`, `docs/11-ai/index.md`, `docs/11-ai/workflows/agent-governance-correction-roadmap.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md` | Docs Review | IMPLEMENTED_PENDING_REVIEW  | implemented                    | Fixed the broken AI-governance root link, de-staled roadmap positioning, and normalized the obsolete active-workspace path |
| doc-review-0017  | 2026-05-29 | `docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 2.md`, `docs/07-planning/phases/phase-3/Phase 3 - Brochure Batch 2 Implementation Prep.md` | Docs Review | IMPLEMENTED_PENDING_REVIEW  | implemented                    | Narrowed the brochure batch notes back to planning ownership and routed exact design detail to canonical docs |
| doc-review-0018  | 2026-05-29 | `docs/09-reference/laravel-brochure-handoff-packet/` | Docs Review | IMPLEMENTED_PENDING_REVIEW  | implemented                    | Replaced legacy packet source claims and broken wiki-style packet links with valid current references |

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
