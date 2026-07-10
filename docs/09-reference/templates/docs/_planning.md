<!--
DOC-META
title: Planning Document Template
doc_type: reference
status: active
owner: docs
canonical: false
canonical_path: docs/09-reference/templates/docs/_planning.md
parent: docs/09-reference/templates/docs/_index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Provides the copyable structure for planning documents governed by Planning Documentation Standards.
-->

# Planning Document Template

Parent: [Documentation Templates Index](_index.md)

Use this template for planning documents under `docs/07-planning/`.

Before using it, read:

- [Planning Documentation Standards](../../../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)

Copy the block below, replace every instructional placeholder, and remove sections that are genuinely not applicable.

```md
<!--
DOC-META
title: Planning Document Title
doc_type: planning
status: draft
owner: core
canonical: true
canonical_path: docs/07-planning/path/planning-document.md
parent: docs/07-planning/path/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: One sentence describing the planning intent owned by this document.
-->

# Planning Document Title

Parent: [Parent Planning Index](index.md)

## 1. Purpose

State what change, capability, migration, refactor, or decomposition this document plans and why the plan is needed.

## 2. Status

- Planning lifecycle: draft | planned | active | implemented | superseded | archived
- Acceptance state:
- Current implementation state:
- Owning GitHub issue or planning issue:
- GitHub Project or milestone:
- Known gaps:

Do not use this section as a parallel task board.

## 3. Planning Scope

### In Scope

- ...

### Non-Goals

- ...

### Affected Actors, Systems, Or Environments

- ...

## 4. Current State

Describe only the current facts needed to understand the plan.

Link to canonical architecture, feature, database, standard, or runbook documents for complete current truth.

## 5. Target State

Describe the intended accepted outcome.

Separate:

- required target
- optional future enhancement
- unresolved alternative

## 6. Requirements And Constraints

### Architecture

- ...

### Security, Privacy, And Data

- ...

### Compatibility And Migration

- ...

### Operations And Reliability

- ...

### UI And Accessibility

- ...

### Performance

- ...

## 7. Ownership And Canonical Targets

| Planned Concern | Current Owner | Target Owner | Canonical Document To Create Or Update |
| --------------- | ------------- | ------------ | -------------------------------------- |
| ...             | ...           | ...          | `docs/...`                             |

## 8. Dependencies

### Blocking Dependencies

- ...

### Non-Blocking Relationships

- ...

### Required Decisions

- [ ] Decision — owner — required by — proposed decision record

## 9. Decisions And Open Questions

| Item | Type                     | Owner | Required By | Resolution Or Next Action |
| ---- | ------------------------ | ----- | ----------- | ------------------------- |
| ...  | decision / open question | ...   | ...         | ...                       |

Promote durable accepted decisions according to Decision Record Standards.

## 10. Implementation Slices

| Slice | Outcome | Owner | Dependencies | GitHub Issue | Verification | Required Review |
| ----- | ------- | ----- | ------------ | ------------ | ------------ | --------------- |
| 1     | ...     | ...   | ...          | #...         | ...          | ...             |

Each implementation issue should define its own acceptance criteria, scope, non-goals, and stop conditions.

## 11. Risks And Review Requirements

| Risk | Impact | Mitigation | Review Owner |
| ---- | ------ | ---------- | ------------ |
| ...  | ...    | ...        | ...          |

Include security, privacy, data, migration, concurrency, operational, accessibility, and compatibility risk when applicable.

## 12. Tests And Verification

### Automated Verification

- ...

### Manual Verification

- ...

### Operational Exercises

- ...

### Documentation Guardrails

- ...

## 13. Documentation Promotion And Synchronization

### Create

- `docs/...`

### Update

- `docs/...`

### Supersede, Archive, Or Delete

- `docs/...`

### Agent And Repository Instructions

- `AGENTS.md`, `.agents/skills/`, or Not applicable

## 14. Implementation Variance

Record material accepted differences from the original plan.

Do not use this section as a chronological worklog.

| Date | Variance | Reason | Accepted By | Affected Issues Or Docs |
| ---- | -------- | ------ | ----------- | ----------------------- |
| ...  | ...      | ...    | ...         | ...                     |

## 15. Completion And Exit Criteria

Planning is complete when:

- [ ] accepted target state is documented
- [ ] scope and non-goals are explicit
- [ ] dependencies and decisions are resolved or clearly blocking
- [ ] implementation slices are bounded
- [ ] verification and review requirements are defined
- [ ] canonical promotion targets are identified

The planning document may become `implemented`, `superseded`, or `archived` when:

- ...

## 16. Related

- [Planning Index](../index.md)
- [Related Canonical Owner](../../path/document.md)
- [Related Decision](../../01-decisions/adr-0000-decision-title.md)
- Related GitHub issue: #...
```

## 1. Related

- [Planning Documentation Standards](../../../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)
- [Planning Index](../../../07-planning/index.md)
