# Document Review 0030

## Review Pass
2

## Target
`AGENTS.md`, `docs/10-runbooks/batch-workflow.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md`, `docs/10-runbooks/advisory-session-scope-claims.md`, `.agents/skills/batch-start.md`, `.agents/skills/work-batch.md`, `.agents/skills/batch-generate-work-prompt.md`, `.agents/skills/claim-session-scope.md`, and `.agents/skills/check-session-scope-conflicts.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Tighten the active batch queue lifecycle so `work-batch` treats `In Progress` as the explicit active claim state for a targeted change-queue item, forces sequential completion of claimed items inside a multi-item work pass, and prevents the advisory session-claim layer from being interpreted as a per-item lock model for the singleton `/docs/08-active/` workspace.

## Scope
- `AGENTS.md`
- `docs/10-runbooks/batch-workflow.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/10-runbooks/advisory-session-scope-claims.md`
- `.agents/skills/batch-start.md`
- `.agents/skills/work-batch.md`
- `.agents/skills/batch-generate-work-prompt.md`
- `.agents/skills/claim-session-scope.md`
- `.agents/skills/check-session-scope-conflicts.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0030.md`

## Findings

### Finding 1
- type: in-progress-claim-semantics-gap
- location: `AGENTS.md:43-52`, `docs/10-runbooks/batch-workflow.md:117-151`, `.agents/skills/work-batch.md:150-181`
- issue: The current queue lifecycle defines the `In Progress` section, but it never states clearly enough that this is the active claim state for the currently targeted change-queue item. That leaves room for agents to treat `Ready To Implement` as a loose backlog instead of reflecting active ownership in the queue as soon as implementation begins.
- required action: Define `In Progress` as the explicit claimed-work state for the current `work-batch` pass, require the queue transition at the moment work begins, and state that other workflow steps should treat an `In Progress` item as already owned rather than as general backlog.
- constraints: Preserve the existing queue sections and singleton `/docs/08-active/` model. Do not add a new lock file or invent a new queue section in this pass.
- decision state: resolved

### Finding 2
- type: sequential-queue-execution-gap
- location: `docs/10-runbooks/batch-workflow.md:206-237`, `.agents/skills/work-batch.md:58-72`, `.agents/skills/work-batch.md:152-181`, `.agents/skills/batch-generate-work-prompt.md:35-104`
- issue: The current workflow says to move a targeted item to `In Progress` when work begins and later update it to an outcome state, but it never requires a multi-item `work-batch` pass to finish or explicitly park that claimed item before claiming the next one. The prompt-generation skill likewise does not prioritize existing `In Progress` items or instruct sequential handling when multiple actionable queue items exist.
- required action: Require `work-batch` to complete each claimed queue item's lifecycle one at a time, continuing any existing `In Progress` item before starting a new `Ready To Implement` item, and update prompt generation so it prioritizes in-progress carryover first and frames multi-item passes as sequential claims rather than parallel picks.
- constraints: Keep multi-item passes allowed when they remain in scope, but make the queue transitions serial and explicit. Do not broaden this into a general multi-agent planning system.
- decision state: resolved

### Finding 3
- type: singleton-workspace-claim-boundary-gap
- location: `AGENTS.md:157-171`, `docs/10-runbooks/agent-sessions-and-parallel-work.md:120-141`, `docs/10-runbooks/advisory-session-scope-claims.md:27-48`, `.agents/skills/claim-session-scope.md:14-42`, `.agents/skills/check-session-scope-conflicts.md:15-32`
- issue: The concurrency docs correctly say advisory claims are not locks and that concurrent `batch-start` or `work-batch` execution is unsupported, but the claim workflow still uses generic `owned scope` language without stating how active batch execution should be represented. That leaves room for a session to record only a single CQ item as its writable scope and to misread the advisory registry as if per-item claims made same-workspace batch execution safe.
- required action: State explicitly that `batch-start` and `work-batch` claim the whole `/docs/08-active/` workspace as their writable scope, and that CQ item IDs may appear only as descriptive context inside that broader claim. Make conflict checking treat any active batch-workspace claim as conflicting regardless of which queue item is mentioned in the note.
- constraints: Preserve advisory claims as a lightweight visibility layer. Do not imply that item-level claim notes create a supported parallel-writer mode for the shared active workspace.
- decision state: resolved

### Finding 4
- type: queue-template-orientation-gap
- location: `.agents/skills/batch-start.md:93-105`, `docs/10-runbooks/batch-workflow.md:134-151`
- issue: The queue initialization guidance explains IDs and normalization but does not orient future queue users that `In Progress` is a live claim marker rather than a generic status bucket. That makes the intended execution semantics too easy to forget once a batch has been initialized and handed across sessions.
- required action: Add queue-template guidance that explains `In Progress` as the current active claim for the writable `work-batch` owner and that new `Ready To Implement` items should not be picked up ahead of an existing unfinished `In Progress` item.
- constraints: Keep the queue intro short and implementation-oriented. Do not turn the active queue template into a long concurrency primer.
- decision state: resolved

## Summary
- The current workflow already has the right basic lifecycle sections, but it still underdefines what `In Progress` means operationally.
- The biggest remaining gap is not queue shape but execution discipline: the docs do not force a claimed item to be finished or explicitly parked before the same pass claims another item.
- The advisory claim layer also needs a stronger boundary statement so queue-item references are not mistaken for supported item-level write locks inside the singleton active workspace.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- `In Progress` is documented as the active claim state for a targeted queue item
- `work-batch` must move a queue item into `In Progress` before implementation edits tied to that item begin
- a multi-item `work-batch` pass must finish or explicitly park one claimed item before claiming the next
- `batch-generate-work-prompt` prioritizes carryover `In Progress` items and frames multi-item work as sequential queue claims
- the advisory-claim workflow states that active batch execution claims the whole `/docs/08-active/` workspace, not individual queue items
- batch-start queue initialization explains the intended `In Progress` semantics briefly enough for future sessions to inherit the same model

## Resolution Notes
- Updated `AGENTS.md` so the active workspace rules define `In Progress` as the live claim state for a targeted queue item and explicitly reject per-item lock interpretations inside the shared `/docs/08-active/` workspace.
- Updated `docs/10-runbooks/batch-workflow.md` so queue-state rules and `work-batch` execution rules require serial queue claiming, carry forward unfinished `In Progress` items first, and forbid using queue state or advisory claims as a parallel-writer loophole.
- Updated `.agents/skills/work-batch.md` so the skill claims queue items before implementation edits, completes or explicitly parks each claimed item before touching the next, and treats active-batch ownership as the whole `/docs/08-active/` workspace.
- Updated `.agents/skills/batch-generate-work-prompt.md` so prompt generation prioritizes unfinished `In Progress` items and frames multi-item work as sequential queue claims.
- Updated `.agents/skills/batch-start.md` so future queue templates explain the intended `In Progress` semantics at initialization time.
- Updated `docs/10-runbooks/agent-sessions-and-parallel-work.md`, `docs/10-runbooks/advisory-session-scope-claims.md`, `.agents/skills/claim-session-scope.md`, and `.agents/skills/check-session-scope-conflicts.md` so advisory claims for active batch execution are recorded at whole-workspace scope and cannot be misread as per-CQ-item locks.
- Re-review found no remaining scoped drift in the CQ claim, sequential execution, or advisory-claim boundary guidance.
