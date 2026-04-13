---
description: "Optional pre-implementation workflow for a phase batch: map scope, dependencies, contracts, implementation slice, tests, and doc sync when the batch note is not yet delivery-ready."
name: "Phase Batch Development"
argument-hint: "Phase and batch target, for example: Phase 4 Batch 1 - Sales Core"
agent: "plan"
---
Create a delivery-ready implementation plan for the requested phase batch.

Use this only when the batch note still needs a concrete build slice before coding. If the batch note already defines clear contracts, touchpoints, tests, and doc sync expectations, skip this prompt and move directly to `/phase-batch-implementation`.

Requirements:
1. Confirm whether this session is operating read-only or writable before any edits.
2. Read the phase index, batch note, and linked canonical owner docs.
3. Produce a dependency-safe implementation slice with explicit in-scope and out-of-scope.
4. List required contracts before build starts.
5. Define code touchpoints by area (routes, requests, services, policies, migrations, tests, views/components).
6. Define test matrix (authorization, ownership, validation, integration, regression).
7. Define documentation sync updates required in the same work cycle.
8. Call out blockers and missing decisions separately from implementation steps.

Guardrails:
- shared-folder batch development planning should stay read-only when another writable session is active
- if this session must edit while another writer is active, move to a separate branch and separate worktree first

Output format:
- Scope Summary
- Required Contracts
- Implementation Steps
- Test Plan
- Doc Sync Plan
- Risks And Blockers

Git close-out (required when edits were made):
1. Stage only the files changed for this task.
2. Commit with a clear summary of completed work.
3. Push to the current branch.
4. Report commit SHA and pushed branch in the final summary.
