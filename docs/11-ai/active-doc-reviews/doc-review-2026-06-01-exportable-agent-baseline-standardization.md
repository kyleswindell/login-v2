# Document Review doc-review-2026-06-01-exportable-agent-baseline-standardization

## Review Pass
3

## Target
Exportable agent baseline standardization across the repo-local memory starter pack and its setup guidance

## Review Type
Document Review

## Status
CLOSED

## Purpose
Identify whether the exportable memory baseline should also carry a few small, reusable agent-system standards that this repo has already proven valuable.

## Scope
- `.agents/baselines/repo-local-agent-memory/`
- setup guidance and snippets in the exportable pack

## Findings

### Finding 1
- type: missing optional governance companions
- location: `.agents/baselines/repo-local-agent-memory/README.md` and `snippets/`
- issue: The current pack exports the memory system itself, but it does not yet package the small surrounding standards that make the memory layer safer to use in practice, especially instruction-surface separation and the read-only-to-writable stop gate for shared-folder sessions. Those standards are generic enough to be useful outside this repo and would improve first-install correctness.
- required action: Add optional companion snippets or setup guidance for:
  - instruction-surface separation
  - the shared-worktree read-only-to-writable stop gate
  - a short adoption checklist that makes the first configuration pass less implicit
- constraints: Keep these additions optional and generic. Do not drag batch-specific or Login V2-specific workflow systems into the starter pack.
- decision state: required

### Finding 2
- type: missing baseline adoption checklist
- location: exportable baseline README
- issue: The README explains installation and first configuration, but it does not provide a compact “minimum safe adoption” checklist that a user can follow before agents begin writing. That increases the chance of partial installation where the memory lane exists but the surrounding governance snippets were never applied.
- required action: Add a concise adoption checklist and make the README state which companion standards are recommended versus optional.
- constraints: Keep it short and practical.
- decision state: required

## Summary
- benchmark alignment: good; the pack is already generic and exportable
- workflow alignment: partial; the memory pack would be safer with a few tiny companion standards and a more explicit adoption checklist
- readiness: ready for a narrow packaging improvement pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the exportable pack includes optional generic governance companions that materially improve safe adoption
- the README clearly distinguishes required versus recommended installation pieces
- a concise adoption checklist exists inside the exportable baseline pack

## Resolution Notes
- Review found a small packaging opportunity, not a flaw in the underlying baseline.
- Added optional generic companion snippets for:
  - instruction-surface separation
  - the read-only-to-writable shared-worktree stop gate
  - AI-governance instruction-surface policy
- Added a concise adoption checklist for first installation and safe activation.
- Updated the baseline README to distinguish required installation steps from recommended companion standards.
- Re-review found no remaining scoped drift. The added companions stay generic, optional, and broadly applicable, and the starter pack now carries a clearer minimum safe adoption path without importing Login V2-specific workflow systems.
