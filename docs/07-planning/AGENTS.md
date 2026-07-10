# AGENTS.md

## Folder Purpose

This folder owns accepted planning intent, sequencing rationale, decomposition, migration planning, implementation slices, open planning questions, and planning matrices.

Planning is not the active delivery-state system.

GitHub issues own bounded work packets.

GitHub Projects own current priority, sequencing, dependencies, and workflow status.

---

## Required Reading

Before reading or editing planning:

1. read root `AGENTS.md`
2. read `docs/AGENTS.md` if present
3. read this folder's `index.md`
4. read [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
5. open only the planning document that owns the requested scope
6. inspect linked GitHub issues and canonical owners when current state matters

For decisions, also read:

- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)

For implementation readiness, also read:

- [Agent Implementation Checklist](../02-standards/coding/Agent%20Implementation%20Checklist.md)

Do not read all planning documents or archived phase history speculatively.

---

## Ownership

Planning documents may own:

- current-versus-target-state analysis
- implementation intent
- scope and non-goals
- dependency and sequence rationale
- capability decomposition
- migration and refactor plans
- implementation-slice preparation
- unresolved planning questions
- documentation promotion targets
- accepted variance from a plan

Planning documents must not remain the final owner of:

- accepted architecture
- implemented feature behavior
- schema or data contracts
- standards
- operational runbooks
- persistent agent rules
- active issue status
- current assignees
- chronological implementation history

Promote durable truth into the correct canonical branch.

---

## GitHub Ownership Boundaries

Use GitHub issues for:

- requested outcome
- acceptance criteria
- bounded scope
- dependencies
- implementation discussion
- tests and verification
- review requirements

Use GitHub Projects for:

- Inbox, Todo, Planned, Ready, In Progress, Review, Blocked, Deferred, and Done status
- priority
- milestone or phase fields
- sequencing
- risk
- dependency tracking when configured

Do not recreate those fields as a planning-document queue.

---

## Planning Authoring Rules

New or materially rewritten planning documents must:

- use `doc_type: planning` unless the primary artifact is a matrix or index
- use the planning template
- distinguish current state from target state
- state scope and non-goals
- identify ownership
- identify dependencies
- separate accepted decisions from open questions
- identify implementation slices when applicable
- identify tests and review requirements
- identify canonical documents to create or update
- link related GitHub issues
- state lifecycle accurately

Use:

- [Planning Template](../09-reference/templates/docs/_planning.md)

Planning matrices must link to detailed owners rather than replacing them.

---

## Decision Rules

Planning may identify and analyze a decision.

Create or link a decision record when the decision is cross-cutting, durable, superseding, or requires explicit acceptance history.

Do not leave accepted durable decisions only in planning or issue comments.

Agents may draft proposed decisions but must not mark them accepted without explicit human authority.

---

## Existing Phase And Batch Material

Existing phase and batch files may contain useful planning history, but they do not automatically own current delivery status.

During cleanup, classify each as:

- current planning
- useful historical planning
- implemented
- superseded
- archived
- delete

Do not preserve deprecated batch-workflow ownership merely because the files already exist.

Do not update old phase or batch documents as active status ledgers unless a scoped cleanup task explicitly retains that responsibility.

---

## Promotion And Synchronization

When implementation changes planning truth:

- update the relevant planning document
- update the GitHub issue when bounded scope changes
- update the canonical owner when durable truth changes
- create or update a decision record when required
- update indexes
- mark superseded or completed planning accurately

Do not copy full canonical content back into planning.

---

## Verification

Before completing planning changes, verify:

- the correct planning owner was edited
- current and target states are distinct
- scope and non-goals are clear
- dependencies are classified
- open questions are not presented as accepted
- implementation slices are bounded
- issue and Project ownership is preserved
- canonical promotion targets are listed
- lifecycle status is accurate
- parent and related links are current
- no deprecated delivery workflow was reintroduced

---

## Stop Conditions

Stop and ask when:

- current and target state cannot be separated
- ownership is unclear
- a durable decision lacks acceptance
- planning would contradict a canonical owner
- implementation status cannot be verified
- a planning document would become an active task board
- a change requires broad phase or batch reclassification
- multiple planning documents compete for the same responsibility
- sensitive data would be recorded
- another writer owns the same planning files

---

## Related

- [Planning Index](index.md)
- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Implementation Status And Development Sync Standard](../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Planning Template](../09-reference/templates/docs/_planning.md)
- [Decisions Index](../01-decisions/index.md)
