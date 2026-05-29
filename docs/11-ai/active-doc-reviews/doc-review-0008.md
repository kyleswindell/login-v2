# Document Review 0008

## Review Pass
2

## Target
`.agents/skills/implement-docs-fix.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit the generic document-fix implementation skill for benchmark completeness and clean workflow ownership.

## Scope
- `.agents/skills/implement-docs-fix.md`
- `.agents/skills/implement-docs-sync-fix.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/11-ai/active-doc-reviews/index.md`

## Findings

### Finding 1
- type: ambiguity
- location: `.agents/skills/implement-docs-fix.md:8-13`, `.agents/skills/implement-docs-sync-fix.md:16-21`, `docs/11-ai/agent-skill-writing-benchmark.md:154-161`, `docs/11-ai/agent-skill-writing-benchmark.md:199-206`
- issue: The generic docs-fix skill explicitly accepts both `doc-review-####` and `doc-sync-####` IDs, even though the repo also has a dedicated `implement-docs-sync-fix.md` skill for docs sync corrections. That creates overlapping ownership and makes routing between the two implementation skills ambiguous.
- required action: Restrict `implement-docs-fix.md` to `doc-review-####` records only, or explicitly document the division of labor between the two fix skills so the overlap is intentional and enforceable.
- constraints: Preserve one clear implementation owner per review type.
- decision state: resolved

## Summary
- benchmark alignment: structurally solid, but workflow ownership is ambiguous
- workflow alignment: overlaps with the dedicated docs-sync fix skill
- readiness: ready for a narrow ownership clarification pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- review-file routing is unambiguous between docs-fix and docs-sync-fix workflows
- accepted input types are explicit and enforceable
- one implementation skill owns each review record type

## Resolution Notes
- Implementation pass updated `.agents/skills/implement-docs-fix.md` to:
  - accept `doc-review-####` inputs only
  - stop and route `doc-sync-####` records to `implement-docs-sync-fix.md`
  - declare the docs-sync workflow split explicitly in the required input and final-rule sections
- Re-review confirmed the implementation routing is now unambiguous between docs-fix and docs-sync-fix workflows.
