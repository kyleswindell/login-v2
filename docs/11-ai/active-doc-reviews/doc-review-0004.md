# Document Review 0004

## Review Pass
2

## Target
`.agents/skills/batch-generate-work-prompt.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit the batch work prompt generation skill for benchmark completeness and alignment with the current `/docs/08-active/` workspace model.

## Scope
- `.agents/skills/batch-generate-work-prompt.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/10-runbooks/batch-workflow.md`
- `.agents/skills/work-batch.md`

## Findings

### Finding 1
- type: conflict
- location: `.agents/skills/batch-generate-work-prompt.md:8-17`, `.agents/skills/batch-generate-work-prompt.md:39`, `.agents/skills/batch-generate-work-prompt.md:149`, `docs/10-runbooks/batch-workflow.md:23-34`, `docs/10-runbooks/batch-workflow.md:112-145`
- issue: The skill still reads from and writes guidance about a root-level `/docs/08-active/worklog.md`, but the canonical active workspace uses `/docs/08-active/worklogs/index.md` plus per-pass `worklog-<phase>-<batch>-####.md` files. This reintroduces a retired history model and prevents the skill from using the real current pass records.
- required action: Replace all `worklog.md` references with the canonical `/worklogs/` model and specify which worklog artifacts are supporting context for prompt generation.
- constraints: Do not reintroduce a root `worklog.md` path or mixed history models.
- decision state: resolved in favor of the `/worklogs/` structure; current skill text conflicts with canonical workspace shape

### Finding 2
- type: gap
- location: `.agents/skills/batch-generate-work-prompt.md:34-45`, `.agents/skills/batch-generate-work-prompt.md:49-90`, `docs/11-ai/agent-skill-writing-benchmark.md:81-91`, `docs/11-ai/agent-skill-writing-benchmark.md:144-152`, `docs/11-ai/agent-skill-writing-benchmark.md:225-232`
- issue: The skill defines normal prompt-construction behavior but no explicit stop path when no active batch is loaded, when the queue is empty, or when the available workspace state is not sufficient to produce a safe next-pass prompt. The benchmark expects real stop conditions and non-happy-path behavior for operational skills.
- required action: Add stop conditions and explicit output states for missing active context, empty actionable queue, or insufficient supporting state.
- constraints: The skill should fail closed rather than inventing work or broadening scope.
- decision state: resolved

## Summary
- benchmark alignment: incomplete due to stale workspace references and missing non-happy-path handling
- workflow alignment: not fully aligned to the canonical `/worklogs/` model
- readiness: ready for a focused correction pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- all stale `worklog.md` references are removed
- supporting worklog inputs point to the canonical `/worklogs/` structure
- explicit stop/output behavior exists for missing or non-actionable active state

## Resolution Notes
- Implementation pass updated `.agents/skills/batch-generate-work-prompt.md` to:
  - replace the retired root `worklog.md` model with `/docs/08-active/worklogs/index.md` plus supporting per-pass worklogs
  - add explicit stop conditions for missing active batch state, empty actionable queue state, insufficient supporting context, and review-only next actions
  - update output guidance to reference `/worklogs/` rather than a retired root worklog file
- Re-review confirmed the skill now aligns to the canonical `/worklogs/` structure and fails closed when no safe next work pass can be generated.
