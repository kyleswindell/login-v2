# AGENTS.md

## Folder Purpose

This folder owns ADRs and other elevated decision records that require durable rationale, explicit lifecycle, acceptance authority, and supersession history.

Decision records explain why a durable choice was made.

Current-state documentation explains what is true now.

---

## Required Reading

Before reading or editing decision records:

1. read root `AGENTS.md`
2. read `docs/AGENTS.md` if present
3. read this folder's `index.md`
4. read [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
5. open only the relevant decision record and directly affected canonical owners

For planning context, also read:

- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)

Use the template:

- [Decision Template](../09-reference/templates/docs/_decision.md)

Do not read all archived decisions unless identifier assignment or supersession review requires it.

---

## Elevation Gate

Create a decision record only when the decision is materially:

- cross-cutting
- long-lived
- difficult to reverse
- superseding
- security, privacy, or data-governance significant
- operationally significant
- important enough to need explicit proposal and acceptance history

Keep narrow implementation choices in their canonical owner, issue, or implementation.

Do not create ADRs for normal local engineering decisions.

---

## Identifier Rules

Use repository-wide sequential identifiers:

- `ADR-0001`
- `ADR-0002`
- `ADR-0003`

Before assigning an ID:

1. inspect this folder and `index.md`
2. inspect archived ADR filenames
3. reserve all previously used identifiers
4. assign the next unused number
5. serialize assignment when another writer may create a decision concurrently

Historical identifiers `ADR-0001` through `ADR-0004` are already used in the archived pre-migration decision set.

The next available identifier is therefore `ADR-0005` unless another decision is added first.

Never reuse or renumber an identifier.

---

## Acceptance Boundary

Agents may:

- identify that a decision record is needed
- draft a Proposed record
- compare alternatives
- analyze consequences
- prepare canonical-document updates

Agents must not:

- mark a decision Accepted without explicit authorized approval
- infer acceptance from implementation alone
- rewrite an accepted decision to change its meaning
- remove supersession history
- hide material negative consequences

Record the decision owner, required reviewers, and acceptance source.

---

## Current-State Synchronization

After a decision is accepted:

- update affected standards
- update architecture
- update feature behavior
- update flows
- update database contracts
- update planning
- update runbooks
- update agent instructions when applicable

Do not leave the decision record as the only description of current truth.

Link canonical owners to the ADR when rationale remains important.

---

## Amendment And Supersession

An accepted record may receive non-substantive corrections and implementation links.

Create a new decision record when changing:

- the decision
- material scope
- core rationale
- consequences
- compatibility direction

The new record must identify the older record it supersedes.

The older record must link to the replacement and use accurate lifecycle status.

---

## Verification

Before completing a decision change, verify:

- the elevation gate is met
- the identifier is unused
- filename and H1 match the identifier
- decision status is explicit
- decision owner is identified
- acceptance authority is recorded when accepted
- alternatives and consequences are honest
- security, privacy, data, migration, and operations impacts are addressed
- affected canonical owners are linked
- planning is updated
- the decision index is updated
- supersession links are bidirectional
- no sensitive information is present

---

## Stop Conditions

Stop and ask when:

- elevation is questionable
- identifier ownership is unclear
- another writer may be assigning an ADR ID
- acceptance authority is absent
- a proposed decision conflicts with an accepted ADR
- affected canonical owners cannot be identified
- security or privacy review is required but unavailable
- the change would substantively rewrite an accepted record
- supersession impact is unresolved
- restricted evidence would need to be included

---

## Related

- [Decisions Index](index.md)
- [Decision Record Standards](../02-standards/documentation/Decision%20Record%20Standards.md)
- [Planning Documentation Standards](../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Template](../09-reference/templates/docs/_decision.md)
- [Planning Index](../07-planning/index.md)
