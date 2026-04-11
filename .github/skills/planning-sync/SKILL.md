---
name: planning-sync
description: "Use when updating planning, feature, reference, or runbook docs and you need canonical-owner sync, implementation-status updates, and index/link consistency in one workflow."
argument-hint: "Describe the change and target notes"
user-invocable: true
disable-model-invocation: false
---

# Planning Sync

## When To Use

Use this skill when a task changes behavior, contracts, sequencing, or delivery scope and multiple docs must stay aligned.

Trigger phrases:
- update planning and canonical docs together
- sync phase note with feature doc
- align implementation status and indexes
- audit cross-links for a phase

## Procedure

1. Identify owner notes.
   - Sequencing owner: `docs/V2 App/Planning/...`
   - Canonical owner: `docs/V2 App/Features/...`, `docs/V2 App/Reference/...`, or `docs/V2 App/Runbooks/...`
2. Read the relevant phase/index notes and current implementation status blocks.
3. Apply edits to both owner notes in the same work cycle when behavior/contracts change.
4. Update related indexes and phase notes that route discovery.
5. Verify bidirectional links between planning and canonical owners.
6. Verify implementation status sections reflect the current state.
7. Summarize changed files and any follow-up decisions still open.

## Quality Gate

Before finishing, confirm all of the following:
- contract language is consistent across edited notes
- implementation status is current in planning notes
- index notes include any newly added owner notes
- no dangling links were introduced
