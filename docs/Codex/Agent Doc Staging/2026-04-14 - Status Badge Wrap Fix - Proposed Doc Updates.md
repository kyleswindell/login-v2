# 2026-04-14 - Status Badge Wrap Fix - Proposed Doc Updates

## Staging Status

- proposed

## Metadata

- Owner agent/session: Codex (current session)
- Created date: 2026-04-14
- Requested by: project owner
- Related implementation scope: status badge one-line rendering correction in shared token class

## Scope

A regression caused status badges to wrap into two lines after the status/badge component rollout.

A shared CSS fix was applied to enforce one-line status badge rendering globally.

This staged note proposes minimal canonical doc updates so the one-line requirement is explicit in standards.

## Canonical Target Docs

- `docs/V2 App/Reference/UI Design System Standards.md`
- `docs/V2 App/Reference/UI UX System/UI UX Component Library Standards.md`

## Proposed Updates

1. Add an explicit status/badge rule:
- status pills must render in one line by default
- icon + label must stay horizontally aligned
- wrapping should be disabled for pill labels in standard table/card/filter contexts

2. Add implementation note:
- shared class `ui-status-pill` is the canonical owner for single-line badge layout behavior

## Implementation Status Impact

- No architecture/planning milestone changes.
- This is a standards clarification tied to a shipped UI fix.

## Supporting Links

- Implementation file: `resources/css/app.css`
- Class updated: `ui-status-pill`

## Review Outcome

- decision: pending docs-sync review
- applied locations: pending
- follow-up needed: docs-sync agent to apply approved canonical note updates
