# Release Session Scope

Release or clear an advisory writable-scope claim when a writable session ends or hands off.

## Goal

Remove or mark stale the current session's claim from `.agents/session-scope-claims.json`.

This skill:
- writes only the advisory claim file
- does NOT modify canonical docs
- does NOT affect Git worktrees or branches directly

## Required Input

- session name or identifier

## Scope

Read:
- `.agents/session-scope-claims.json`

Write:
- `.agents/session-scope-claims.json`

## Rules

- Remove only the matching session claim
- If no matching claim exists, report that clearly and do not modify unrelated claims
- Use this when writable ownership ends, is handed off, or was recorded incorrectly

## Output

1. whether a claim was released
2. released claim summary, if any
3. whether stale claims still remain for manual follow-up
