# Document Review 0021

## Review Pass
2

## Target
`AGENTS.md`, `docs/10-runbooks/batch-workflow.md`, `.agents/skills/batch-start.md`, `.agents/skills/work-batch.md`, `.agents/skills/batch-update-manual-review-status.md`, and `.agents/skills/batch-generate-work-prompt.md`

## Review Type
Document Review

## Status
IMPLEMENTED_PENDING_REVIEW

## Purpose
Tighten the batch queue/workflow rules so implemented items are not reopened incorrectly when manual review finds a separate adjacent gap, shared UI systems are not treated as review-ready while parallel render paths remain out of parity, and the queue layout stays agent-managed and implementation-ready instead of becoming a scratchpad for exploratory review discussion. This second pass also adds stable queue IDs and clarifies how live `change-queue.md` files should introduce and preserve them.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/batch-workflow.md`
- `.agents/skills/batch-start.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/batch-update-manual-review-status.md`
- `.agents/skills/batch-generate-work-prompt.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0021.md`

## Findings

### Finding 1
- type: queue-state-ambiguity
- location: `docs/10-runbooks/batch-workflow.md:100-114`, `.agents/skills/batch-update-manual-review-status.md:42-57`
- issue: The current queue lifecycle defines `Implemented Pending Review -> Ready To Implement if failed`, but it does not distinguish between a true failure of the implemented item itself and a newly discovered adjacent finding on the same broad surface. That allows new review findings to reopen completed items incorrectly.
- required action: Add an explicit manual-review classification rule: each review finding must be treated as either confirmation of an existing item, failure of an existing item, or a new finding. Only reopen an implemented item when the review evidence directly shows that item's own acceptance outcome failed.
- constraints: Keep the existing queue lifecycle sections; do not replace the active queue model or require a new queue file format in this pass.
- decision state: resolved

### Finding 2
- type: shared-surface-parity-gap
- location: `docs/10-runbooks/batch-workflow.md:176-204`, `.agents/skills/work-batch.md:46-77`, `.agents/skills/work-batch.md:144-177`
- issue: The current `work-batch` guidance processes ready queue items, but it does not force a shared-surface implementation pass to account for parallel render/update paths such as server-rendered markup, realtime injected markup, and toast overlays. That makes it too easy to mark a UI surface review-ready while a second path still renders stale output.
- required action: Add a shared-surface parity rule requiring `work-batch` to identify the relevant render/update paths for a targeted shared UI system and either update them together or explicitly record any excluded path as a new follow-up item before calling the pass review-ready.
- constraints: Keep the rule implementation-oriented; do not broaden it into a new architecture or planning workflow.
- decision state: resolved

### Finding 3
- type: queue-layout-underdefinition
- location: `docs/10-runbooks/batch-workflow.md:100-122`, `.agents/skills/batch-start.md:117-126`, `.agents/skills/work-batch.md:145-177`
- issue: The queue model still relies almost entirely on prose-only bullets. Without a minimal item structure, adjacent findings on the same broad surface remain easy to collapse together, especially once implementation, follow-up, and path-coverage context start accumulating.
- required action: Define a lightweight queue-item format that keeps the bullet as the actionable headline but allows short continuation lines such as `Scope:`, `Path Coverage:`, `Implemented in:`, and `Follow-up To:` when they improve traceability.
- constraints: Keep the queue readable as Markdown; do not replace it with a heavy table or require a new file type.
- decision state: resolved

### Finding 4
- type: chat-to-queue-normalization-gap
- location: `docs/10-runbooks/batch-workflow.md:214-232`, `.agents/skills/batch-update-manual-review-status.md:14-18`, `.agents/skills/batch-generate-work-prompt.md:25-47`
- issue: The workflow does not explicitly distinguish exploratory review discussion in chat from normalized queue items. That leaves it unclear whether a user should write raw review commentary directly into the queue or let the agent investigate and condense it first.
- required action: Add an explicit normalization rule: exploratory discussion stays in chat, while `batch-update-manual-review-status` converts confirmed findings into concise implementation-ready queue language. Update prompt-generation guidance so queue metadata is treated as support context, not as separate actionable items.
- constraints: Preserve the queue as the canonical implementation list; do not turn `change-queue.md` into a conversation log.
- decision state: resolved

### Finding 5
- type: queue-identity-gap
- location: `AGENTS.md:37-44`, `docs/10-runbooks/batch-workflow.md:126-142`, `.agents/skills/work-batch.md:147-177`, `.agents/skills/batch-update-manual-review-status.md:52-68`
- issue: Even with better queue-state semantics, prose-only items are still easy to lose in chat because the workflow has no required stable identifier for active queue items. Without a shared reference key, adjacent findings can still be mis-mapped during discussion or review.
- required action: Require stable queue IDs for active items, keep those IDs constant across queue-state transitions, and track reopen/refinement history separately through metadata such as `Iteration:` instead of mutating the identifier itself.
- constraints: Keep IDs lightweight and human-readable; do not encode iteration history directly into the stable ID.
- decision state: resolved

## Summary
- The queue-state mistake came from underdefined transition semantics, not from missing lifecycle sections.
- The implementation scoping mistake came from underdefined shared-surface parity expectations, not from missing deployment or checklist rules.
- The queue also needed a clearer item format and an explicit chat-to-queue normalization boundary so exploratory discussion does not become queue-state drift.
- The queue also needed stable item identity so chat, manual review, and implementation passes can refer to the same finding without relying on prose matching.
- The updated runbook, AGENTS rules, and skills now force explicit review-finding classification, shared-surface parity checks, stable queue IDs, and normalized queue-item structure.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- review findings are explicitly classified as confirmation, failure of an existing item, or a new finding
- `Implemented Pending Review` items are reopened only when their own implemented outcome actually failed
- `work-batch` documents shared render/update paths for targeted UI systems before calling a pass review-ready
- a newly discovered adjacent path gap opens a separate follow-up item instead of silently collapsing queue state
- the queue has a documented minimal item format that supports implementation traceability without becoming a heavy schema
- exploratory review discussion is kept in chat until the agent normalizes it into concise queue language
- active queue items use stable IDs and preserve them across queue-state transitions

## Resolution Notes
- Updated `AGENTS.md` to require stable queue IDs for active `change-queue.md` items and to prefer queue-ID references in chat.
- Updated `docs/10-runbooks/batch-workflow.md` to add manual-review classification rules and shared-surface parity expectations.
- Updated `docs/10-runbooks/batch-workflow.md` to define a lightweight queue-item format and to keep exploratory discussion out of the queue until normalized.
- Updated `docs/10-runbooks/batch-workflow.md` to define the stable queue ID format `P<phase>-<batch>-CQ-###` and keep iteration history separate from the identifier.
- Updated `.agents/skills/batch-start.md` so future active queues initialize against the documented item-format expectations.
- Updated `.agents/skills/work-batch.md` to require render/update-path identification for shared UI systems and to treat uncovered parallel paths as follow-up queue items before a pass is called review-ready.
- Updated `.agents/skills/work-batch.md` to preserve or add stable queue IDs and concise queue metadata when that improves item-level traceability.
- Updated `.agents/skills/batch-update-manual-review-status.md` to classify review findings explicitly, reopen implemented items only when the same item's scoped outcome failed, and normalize exploratory chat into concise queue language instead of copying it verbatim.
- Updated `.agents/skills/batch-update-manual-review-status.md` to preserve IDs for mapped items and assign new IDs to truly new findings.
- Updated `.agents/skills/batch-generate-work-prompt.md` so queue IDs and metadata are treated as support context rather than separate actionable items.
- Re-review is still required before this governance correction can be closed.
