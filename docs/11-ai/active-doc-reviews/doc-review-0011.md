# Document Review 0011

## Review Pass
2

## Target
`.agents/skills/review-document.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit the `review-document` skill file for whether it actually functions as a document-review skill under the benchmark.

## Scope
- `.agents/skills/review-document.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/11-ai/active-doc-reviews/index.md`

## Findings

### Finding 1
- type: conflict
- location: `.agents/skills/review-document.md:1-57`, `docs/11-ai/agent-skill-writing-benchmark.md:146-170`, `docs/11-ai/agent-skill-writing-benchmark.md:176-191`
- issue: The file is named like an executable review skill, but its content is just an index-style ledger template. It has no goal section, no scope of reviewed documents, no ordered review method, no stop conditions, and no output contract for creating `doc-review-####.md` records. As written, it cannot function as a review skill.
- required action: Rewrite the file as an actual document-review skill with purpose, review method, findings format, stop conditions, and index-update behavior, or move this content out of `.agents/skills/` if it is only a template/reference.
- constraints: Do not leave a non-executable template masquerading as a runnable skill.
- decision state: resolved

### Finding 2
- type: ambiguity
- location: `.agents/skills/review-document.md:1-57`, `docs/11-ai/active-doc-reviews/index.md:1-60`
- issue: The file duplicates the shape of the active review index without defining how a document review should create or update review files. That creates overlapping ownership between a supposed skill and the canonical review ledger while leaving the actual review workflow unspecified.
- required action: Separate executable instructions from ledger/template content so only the canonical index owns index structure, while the skill owns the review procedure.
- constraints: Preserve `docs/11-ai/active-doc-reviews/index.md` as the canonical review ledger.
- decision state: resolved

## Summary
- benchmark alignment: materially inadequate
- workflow alignment: review-ledger content is present, but review procedure is missing
- readiness: requires rewrite before it can be treated as an operational skill

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the file is either rewritten as a real review skill or removed from the skill set
- review procedure, stop conditions, and output contract are explicit
- ledger/template ownership is separated from executable workflow instructions

## Resolution Notes
- Implementation pass replaced `.agents/skills/review-document.md` with an actual executable review skill that now defines:
  - purpose and scope
  - required input
  - stop conditions
  - ordered review method
  - `doc-review-####` output contract
  - review-index update behavior
- Re-review confirmed the file no longer duplicates the active review ledger structure and now owns a real review procedure.
