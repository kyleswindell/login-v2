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
| doc-sync-0010    | 2026-06-01 | Roadmap and planning-navigation sync against the current phase indices and active development state after `doc-review-0035` | Docs Sync   | CLOSED                      | implemented                    | Updated the roadmap to reflect the active Phase 2 lock and current phase states, replaced stale roadmap guidance, and made phase-index status ownership explicit in planning navigation; re-review found no remaining scoped drift |
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
| doc-review-0019  | 2026-05-30 | `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md` and related Batch B prep references | Docs Review | CLOSED                      | implemented                    | Re-review after Batch A close-out confirmed the Batch B prep lane no longer has remaining drift |
| doc-review-0020  | 2026-05-30 | `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md` and the current Batch B planning/support set | Docs Review | READY_FOR_IMPLEMENTATION    | not started                    | Identified remaining Batch B planning ownership, checklist, rollout-tracking, and candidate-surface gaps that still need an implementation pass |
| doc-review-0021  | 2026-05-30 | `AGENTS.md`, `docs/10-runbooks/batch-workflow.md`, and the active change-queue workflow skills | Docs Review | IMPLEMENTED_PENDING_REVIEW  | implemented                    | Added explicit queue-transition classification, shared-surface parity rules, chat-to-queue normalization, a lightweight queue-item format, stable queue IDs, deploy-gated review readiness, and direct manual-review authorization for queue-state updates |
| doc-review-0022  | 2026-05-31 | `docs/07-planning/roadmap.md`, the active Phase 2 Batch B planning set, and the linked Phase 3/Phase 4 planning notes | Docs Review | CLOSED                      | implemented                    | Re-review confirmed the revised Phase 2/3/4 planning handoff is internally consistent and ready for use |
| doc-review-0023  | 2026-05-31 | `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md`, `docs/07-planning/phases/phase-2/Phase 2 - Batch B Implementation Prep.md`, and related Phase 2 planning references | Docs Review | CLOSED                      | implemented                    | Re-review confirmed Batch B’s Tier 2 disposition contract and handoff-artifact requirements are now explicit enough for execution planning |
| doc-review-0024  | 2026-05-31 | `docs/07-planning/phases/phase-2/Phase 2 - Implementation Batch B.md` and `docs/07-planning/phases/phase-2/Phase 2 - Batch B Implementation Prep.md` | Docs Review | CLOSED                      | implemented                    | Re-review confirmed Batch B now defines the proof-page and component-view coverage needed for intentional manual review |
| doc-review-0025  | 2026-05-31 | Tier 1 UI system consumability and planning-to-implementation anti-drift workflow | Docs Review | CLOSED                      | implemented                    | Closed after defining the T1 consumption model, implementation-form inventory, workflow preflight, and the minimal automation boundary for stable entry points and reference availability |
| doc-review-0026  | 2026-05-31 | Current Tier 1 implementation-form inventory and its suitability as the building-block layer for Tier 2 and feature work | Docs Review | CLOSED                      | implemented                    | Re-review confirmed the Tier 1 standards correction is internally consistent, and Batch B should begin with the promoted Blade-component candidates rather than deferring them |
| doc-review-0027  | 2026-05-31 | Phase 2 Batch B planning sequence after the Tier 1 implementation-form direction was locked in `doc-review-0026` | Docs Review | CLOSED                      | implemented                    | Batch B planning now explicitly starts with Tier 1 library hardening for the promoted Blade-component candidates before broader Tier 2 implementation continues |
| doc-review-0028  | 2026-05-31 | Canonical doc consistency after the recent Tier 1 consumption/implementation-form corrections and the Batch B sequencing update | Docs Review | CLOSED                      | implemented                    | Corrected the remaining drift in the Tier 1 implementation checklist, the high-level Phase 2 sequencing note, and the Tier 1 rollout tracker; re-review found no remaining scoped drift |
| doc-review-0029  | 2026-06-01 | Current platform RBAC suitability for least-privilege read-only review access across admin and super-admin surfaces used during staging review | Docs Review | CLOSED                      | implemented                    | Added a dedicated reviewer role plus view/manage permission splits for users/settings and a permission-backed UI Reference gate; re-review passed against the scoped auth/platform feature suite |
| doc-review-0030  | 2026-06-01 | Active batch CQ claim semantics, sequential queue execution, and advisory-claim boundaries across the batch workflow docs and skills | Docs Review | CLOSED                      | implemented                    | Re-review confirmed the scoped workflow and claim docs now treat `In Progress` as a serial claim state and keep active-batch ownership at whole-workspace scope |
| doc-review-0033  | 2026-06-01 | Phase alignment for the new security standards across roadmap and Phase 0, Phase 1, and Phase 3 planning | Docs Review | CLOSED                      | implemented                    | Aligned roadmap and phase planning so deployment/runtime hardening stays in Phase 0 follow-up, current auth hardening stays in a Phase 1 carry-forward lane, and Phase 3 OAuth/Graph work is blocked on those outputs plus the secret-backed settings model; re-review found no remaining scoped drift |
| doc-review-0034  | 2026-06-01 | Correction of security implementation phase allocation so new work stays in Phase 3 or later rather than reopening completed phases | Docs Review | CLOSED                      | implemented                    | Corrected the prior allocation so completed Phase 0 and Phase 1 notes remain historical, Phase 2 stays untouched, and the new security implementation work now lives in Phase 3 planning and Batch 1 scope; re-review found no remaining scoped drift |
| doc-review-0035  | 2026-06-01 | Roadmap status-tracking accuracy against the current phase indices and active development state | Docs Review | CLOSED                      | implemented                    | The roadmap now reflects the active Phase 2 lock, uses consistent phase status summaries, replaces stale next-doc guidance, and points detailed status ownership back to the phase indices; re-review found no remaining scoped drift |
| doc-review-0036  | 2026-06-01 | Batch lifecycle skills, missing phase lifecycle skill coverage, and runbook ownership for roadmap and phase-status synchronization | Docs Review | CLOSED                      | implemented                    | Mapped parent planning/status synchronization onto the existing docs sync workflows, updated close-out handoff language in the parent runbooks and batch finalize skill, and extended `review-docs-sync` scope to cover `/docs/07-planning/`; re-review found no remaining scoped ownership gap |
| doc-review-0031  | 2026-06-01 | Auth, OAuth, MFA, account-linking, and secret-management baseline across the canonical security/auth docs | Docs Review | CLOSED                      | implemented                    | Added a dedicated identity/account security standard and synchronized auth architecture, authentication behavior notes, and the planned customer OAuth flow to reflect MFA assurance, Entra tenant restriction, anti-auto-linking rules, and production credential handling; re-review found no remaining scoped drift |
| doc-review-0032  | 2026-06-01 | Current repo security posture against OWASP-aligned enterprise expectations, secure-delivery practice, and modern production-hardening baselines | Docs Review | CLOSED                      | implemented                    | Added secure-delivery and transport/session/browser standards, tightened identity and logging standards, and updated production policy links so the repo now has canonical owners for the major OWASP-aligned baseline gaps found in the review; re-review found no remaining scoped drift |

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
