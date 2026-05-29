# Document Review 0013

## Review Pass
2

## Target
`AGENTS.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit the root agent-instruction file for completeness and procedural clarity relative to the repo's skill benchmark and current review ledger model.

## Scope
- `AGENTS.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/10-runbooks/git-batch-commit-workflow.md`
- `docs/11-ai/active-doc-reviews/index.md`

## Findings

### Finding 1
- type: conflict
- location: `AGENTS.md:72-85`, `docs/10-runbooks/git-batch-commit-workflow.md:5-8`
- issue: `AGENTS.md` says to follow `docs/10-runbooks/git-batch-commit-workflow.md` for all commits, but the runbook itself says it applies to active-batch execution using `/docs/08-active/`. That over-expands batch commit rules to non-batch review/governance work such as active-doc audits.
- required action: Scope the commit-rule statement in `AGENTS.md` to batch execution, or add a separate rule for non-batch commits.
- constraints: Do not blur batch save-point rules into unrelated review-only documentation work.
- decision state: resolved

### Finding 2
- type: ambiguity
- location: `AGENTS.md:89-121`, `docs/11-ai/active-doc-reviews/index.md:1-60`, `docs/11-ai/agent-skill-writing-benchmark.md:72-79`, `docs/11-ai/agent-skill-writing-benchmark.md:81-91`
- issue: The file requires separation between prompt generation, implementation, and review, but it does not define a named workflow or storage convention for review-only audits outside the batch system. That leaves non-batch reviews procedurally underdefined even though the repo already maintains a dedicated review ledger under `docs/11-ai/active-doc-reviews/`.
- required action: Add explicit guidance for review-only work, including where review artifacts should live and how those tasks differ from active batch workflows.
- constraints: Preserve the current separation between review and implementation work.
- decision state: resolved

### Finding 3
- type: ambiguity
- location: `AGENTS.md:61-65`
- issue: The instruction to record unrelated issues in `/docs/08-active/notes.md` is written as a general rule, but that workspace is only valid for one active batch and may be unrelated to review-only work. In non-batch audit sessions, this rule would direct findings into the wrong workspace.
- required action: Scope the unrelated-issues note rule to active batch implementation work only, or define an alternate recording path for non-batch review findings.
- constraints: Do not push review-only findings into an unrelated active batch workspace.
- decision state: resolved

## Summary
- benchmark alignment: strong on core principles, but incomplete on review-only operating paths
- workflow alignment: active-batch rules are clear; non-batch review guidance remains underspecified
- readiness: ready for a focused procedural clarification pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- batch-only commit rules are scoped correctly
- review-only audit work has an explicit storage/procedure path
- unrelated-issue recording rules no longer force non-batch findings into `/docs/08-active/`

## Resolution Notes
- Vendor dependency file `vendor/kirschbaum-development/eloquent-power-joins/AGENTS.md` was not reviewed in this pass because it is third-party content and not a repo-owned agent workflow file.
- Implementation pass updated `AGENTS.md` to:
  - scope `git-batch-commit-workflow.md` usage to active batch execution only
  - add non-batch commit guidance for review and governance work
  - scope unrelated-issue recording in `/docs/08-active/notes.md` to active batch implementation work only
  - add explicit review-only governance rules using `docs/11-ai/active-doc-reviews/` and its review ledger as the canonical non-batch audit path
  - add `01-decisions` to the branch-responsibility list now that the decisions branch is active
- Re-review confirmed the procedural ambiguity identified in this review is resolved and the root instruction file now distinguishes active batch execution from review-only governance work cleanly.
