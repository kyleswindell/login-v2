<!--
DOC-META
title: Decision Record Template
doc_type: reference
status: active
owner: docs
canonical: false
canonical_path: docs/09-reference/templates/docs/_decision.md
parent: docs/09-reference/templates/docs/_index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Provides the copyable structure for elevated decision records governed by Decision Record Standards.
-->

# Decision Record Template

Parent: [Documentation Templates Index](_index.md)

Use this template for elevated decision records under `docs/01-decisions/`.

Before using it, read:

- [Decision Record Standards](../../../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)

Assign the next unused four-digit ADR number, copy the block below, replace every instructional placeholder, and remove only sections that the decision standard permits you to omit.

```md
<!--
DOC-META
title: ADR-0000: Decision Title
doc_type: decision
status: draft
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0000-decision-title.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Records the durable decision to ...
-->

# ADR-0000: Decision Title

Parent: [Decisions Index](index.md)

## 1. Decision Status

Proposed

Allowed values:

- Proposed
- Accepted
- Rejected
- Deprecated
- Superseded

## 2. Dates

- Proposed:
- Accepted, rejected, deprecated, or superseded:

## 3. Decision Owner

- Owner:
- Required reviewers:
- Acceptance source:

An agent must not mark the decision Accepted without explicit authorized acceptance.

## 4. Related Work

- GitHub issue:
- Planning document:
- Pull request:
- Prior decisions:
- Affected canonical owners:

## 5. Context

Describe:

- the problem
- why a decision is needed now
- current constraints
- relevant facts
- consequences of not deciding

Link large research material instead of copying it here.

## 6. Decision Drivers

- ...
- ...
- ...

## 7. Decision

Login 2.0 will ...

State one clear selected direction.

## 8. Scope And Boundaries

### Applies To

- ...

### Does Not Apply To

- ...

### Compatibility And Transition Boundaries

- ...

## 9. Alternatives Considered

### Alternative A — Name

Summary:

Reasons not selected:

- ...

### Alternative B — Name

Summary:

Reasons not selected:

- ...

Do not include artificial alternatives that were not credible.

## 10. Consequences

### Positive

- ...

### Negative

- ...

### Neutral Tradeoffs

- ...

### Security, Privacy, And Data

- ...

### Operational And Migration

- ...

## 11. Implementation Implications

- implementation areas:
- migrations:
- compatibility behavior:
- deployment or rollback:
- required GitHub issues:
- specialist review:

This section is not a full implementation plan.

## 12. Canonical Documentation Updates

### Create

- `docs/...`

### Update

- `docs/...`

### Supersede Or Archive

- `docs/...`

## 13. Verification

Describe how implementation and documentation alignment will be confirmed.

- ...

## 14. Supersession

### Supersedes

- None

### Superseded By

- None

### Transition Plan

- Not applicable

## 15. Acceptance Or Rejection Record

Complete this section when the proposal is resolved.

- Outcome:
- Date:
- Accepted or rejected by:
- Evidence:
- Required follow-up:

## 16. Related

- [Decisions Index](index.md)
- [Related Planning](../07-planning/path/planning-document.md)
- [Related Architecture](../03-architecture/path/document.md)
- [Related Feature](../04-features/path/document.md)
- Related GitHub issue: #...
```

## Replacement Note

This template replaces:

- `docs/02-standards/documentation/Templates/ADR Template.md`

Delete the old template after updating inbound links, or preserve it temporarily as a concise superseded pointer only when path compatibility is still required.

## Related

- [Decision Record Standards](../../../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)
- [Decisions Index](../../../01-decisions/index.md)
