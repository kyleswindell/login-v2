# Claim Session Scope

Create or update an advisory writable-scope claim for the current session.

## Goal

Record a lightweight claim in `.agents/session-scope-claims.json` so other sessions can see intended writable ownership.

This skill:
- writes only the advisory claim file
- does NOT create locks
- does NOT authorize otherwise-unsafe shared-folder writes

## Required Input

- session name or identifier
- owned scope
- branch name
- worktree path
- expected close-out or handoff note

## Scope

Read:
- `.agents/session-scope-claims.json`

Write:
- `.agents/session-scope-claims.json`

## Rules

- Keep one active claim per writable session
- Update an existing claim for the same session instead of duplicating it
- Do NOT use this file for read-only sessions unless visibility is explicitly needed
- Do NOT treat a claim as protection against conflicting writes
- If the writable task is `batch-start` or `work-batch`, record the owned scope as the full `/docs/08-active/` workspace; mention CQ item IDs only as descriptive context, not as the actual ownership boundary

## Stop Conditions

Stop if:
- the session identity is missing
- the writable scope is unclear
- the branch or worktree path is unknown

## Output

1. claim created or updated
2. claim summary
3. reminder that the claim is advisory only
