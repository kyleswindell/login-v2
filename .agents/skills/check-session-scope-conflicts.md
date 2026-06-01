# Check Session Scope Conflicts

Inspect the advisory claim registry before writable work begins.

## Goal

Read `.agents/session-scope-claims.json` and report whether an existing advisory claim appears to overlap the requested writable scope.

This skill:
- is read-only
- does NOT create or release claims
- does NOT guarantee safety
- only reports visible coordination risk

## Required Input

- intended writable scope
- current branch
- current worktree path

## Scope

Read:
- `.agents/session-scope-claims.json`

Do NOT write files.

## Rules

- Treat the claim file as advisory only
- Do NOT assume the absence of a claim means writable safety
- If the scope overlaps an active claim, report the conflict and stop writable execution until the owner clarifies or releases it
- If the intended writable task is `batch-start` or `work-batch`, treat any active claim on `/docs/08-active/` as conflicting even when the note mentions a different CQ item

## Output

1. whether a conflicting claim exists
2. matching claim details, if any
3. whether writable work should stop for clarification
