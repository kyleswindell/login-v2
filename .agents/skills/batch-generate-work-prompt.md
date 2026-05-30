# Generate Batch Work Prompt

Generate a precise next-step batch-work prompt for the currently active batch using the active workspace state.

## Scope
Read only from:

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/review.md`
- `/docs/08-active/notes.md`
- `/docs/08-active/worklogs/index.md`
- supporting `/docs/08-active/worklogs/worklog-<phase>-<batch>-####.md` files when needed for current-pass context
- `/docs/08-active/change-queue.md`

Reference:
- `/docs/10-runbooks/git-batch-commit-workflow.md`
- current `Work Batch` skill behavior

Do not modify files.

---

## Goal
Produce a clean, implementation-ready prompt for the next `Work Batch` pass that:

- stays within the active batch scope
- prioritizes unresolved queued issues
- preserves batch boundaries
- includes commit/deploy instructions only when appropriate
- is easy to paste directly to the batch agent

---

## Rules
- Work only from the currently loaded active batch
- Use `change-queue.md` as the primary driver for next-step fixes
- Refer to queue items by `ID:` when available
- Treat queue-item headline bullets as the actionable units; use continuation lines such as `ID:`, `Iteration:`, `Scope:`, `Path Coverage:`, `Implemented in:`, `Follow-up To:`, and `Supersedes:` as support context only
- Use `review.md` to understand current blockers and review state
- Use `checklist.md` to avoid repeating already-completed work
- Use `notes.md` and `/worklogs/` for supporting context only
- Do NOT invent new scope
- Do NOT escalate Tier boundaries
- Do NOT include unrelated cleanup
- Keep the prompt direct, specific, and grouped by implementation goals
- Prefer outcome-based instructions over implementation micromanagement
- If a queued issue reflects a standards ambiguity rather than implementation work, call that out instead of forcing a work-batch prompt

## Stop Conditions

Stop and report instead of generating a work prompt if:

- no active batch is loaded
- `change-queue.md` has no actionable items and the batch state does not indicate remaining implementation work
- the available `/docs/08-active/` state is too incomplete to identify a safe next pass
- the next apparent action is a review-only or standards decision rather than batch implementation work

---

## Prompt Construction Logic

### 1. Read active batch context
Extract:
- batch name
- scope
- out-of-scope boundaries
- validation surface
- whether visual/manual review is pending

### 2. Read current progress state
Determine:
- what has already been completed
- what remains unchecked
- what blockers are still open
- what has already been confirmed fixed

### 3. Read change queue
Prioritize items in this order:
1. blocking implementation issues
2. visual review failures
3. functional review failures
4. standards-aligned cleanup required for review completion
5. deferred items must be excluded

### 4. Build the next work prompt
The generated prompt should include:

- short goal line
- instruction to execute the Work Batch workflow
- grouped implementation sections based on queued items
- explicit exclusions to prevent drift
- `/docs/08-active/` update requirement
- commit/push/deploy requirement only if the pass is intended to produce a reviewable result

### 5. Commit/deploy decision
Include commit/push/deploy instructions only when:
- the requested work is expected to result in a visual/functional reviewable pass
- the queue items are implementation fixes, not exploratory work
- no unresolved blocker prevents reviewable output

If not appropriate, explicitly omit commit/deploy from the generated prompt.

---

## Output Format

Return:

### 1. Prompt
A ready-to-paste batch-work prompt in plain text.

### 2. Rationale
Very brief:
- why these items were prioritized
- whether commit/deploy was included or omitted

### 3. Deferred Items
List any queue items intentionally excluded from this prompt because they are:
- out of scope
- already resolved
- standards/review issues rather than work-batch tasks

---

## Prompt Style Requirements
The generated prompt must:

- begin with:
  `Goal: ...`
- include:
  `Execute the Work Batch workflow for the active batch.`
- use grouped numbered sections when multiple fix clusters exist
- include a `Rules` section
- include an `Output` section
- avoid unnecessary explanation
- be immediately usable without cleanup

---

## Default Output Skeleton

Use this structure unless the active queue clearly requires something else:

```text
Goal: <short batch goal>

Execute the Work Batch workflow for the active batch.

Focus only on the following items:

1) <group 1>
- <specific outcomes>

2) <group 2>
- <specific outcomes>

Rules:
- Stay within current batch scope
- <other necessary constraints>
- Update /docs/08-active/worklogs/, notes.md, review.md, and checklist.md to reflect actual progress

Output:
1. files changed
2. fixes applied
3. checklist items completed or affected
4. blockers or remaining issues
5. whether another work pass is required
