<!--
DOC-META
title: Phase 7 Architecture Exception Register
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/architecture-exception-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-5-intentional-architecture-exceptions.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records proposed, accepted, rejected, expired, and retired intentional deviations from the Goal 3 target architecture.
-->

# Phase 7 Architecture Exception Register

Parent: [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)

## 1. Purpose

Record every proposed or accepted intentional deviation from the Goal 3 target architecture.

No architecture exception exists unless it appears in this register and has been explicitly accepted by the repository owner.

Current implementation inconsistency, temporary migration state, compatibility, deferred cleanup, and later-owner design detail do not establish exceptions.

## 2. Status

* Planning lifecycle: draft
* Register state: no proposed or accepted architecture exceptions
* Exception implementation authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Governing policy: [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)

## 3. Register Rules

Each entry must:

* identify the exact accepted architecture rule being violated;
* link the source establishing that rule;
* define one narrow deviation;
* provide concrete evidence and rationale;
* identify affected owners and paths;
* state whether the exception is permanent or bounded;
* identify risks and prohibited expansion;
* define verification;
* identify one responsible owner;
* remain proposed until explicit repository-owner acceptance.

No entry may use a synthetic repository-owner identity.

No register entry means the accepted target architecture applies without exception.

## 4. Accepted Architecture Exceptions

None.

| Exception ID | Architecture rule and source        | Exact deviation | Evidence and rationale | Affected owners and paths | Duration | Review or expiration condition | Risks | Prohibited expansion | Verification | Responsible owner | Acceptance evidence |
| ------------ | ----------------------------------- | --------------- | ---------------------- | ------------------------- | -------- | ------------------------------ | ----- | -------------------- | ------------ | ----------------- | ------------------- |
| —            | No accepted architecture exceptions | —               | —                      | —                         | —        | —                              | —     | —                    | —            | —                 | —                   |

## 5. Proposed Architecture Exceptions

None.

| Exception ID | Architecture rule and source        | Exact deviation | Evidence and rationale | Affected owners and paths | Duration | Review or expiration condition | Risks | Prohibited expansion | Verification | Responsible owner | Review state |
| ------------ | ----------------------------------- | --------------- | ---------------------- | ------------------------- | -------- | ------------------------------ | ----- | -------------------- | ------------ | ----------------- | ------------ |
| —            | No proposed architecture exceptions | —               | —                      | —                         | —        | —                              | —     | —                    | —            | —                 | —            |

## 6. Rejected Presumed Exceptions

The following reviewed subjects are not architecture exceptions:

| Subject                                                            | Decision         | Reason                                                                           |
| ------------------------------------------------------------------ | ---------------- | -------------------------------------------------------------------------------- |
| Current `app/Platform/` structure                                  | Not an exception | Transitional implementation is split, replaced, or removed                       |
| Generic `app/Surfaces/Contracts/`                                  | Not an exception | Generic Surface is not an accepted target owner                                  |
| Required Core capabilities under `Modules/`                        | Not an exception | False Module packaging is extracted into accepted Core owners                    |
| Root Laravel bootstrap and configuration boundaries                | Not an exception | Restricted framework integration roots are part of the accepted target           |
| Genuinely application-wide middleware under `app/Http/Middleware/` | Not an exception | Root placement is accepted when behavior remains owner-controlled                |
| Sparse root route and console entrypoints                          | Not an exception | Framework composition entrypoints are accepted when owner behavior remains local |
| Accepted reusable UI structure                                     | Not an exception | UI Contract preservation is an accepted target requirement                       |
| Owner-local public Contracts and Contributions                     | Not an exception | Public cross-owner collaboration is part of the accepted architecture            |
| Temporary route aliases or adapters                                | Not an exception | Governed by the compatibility register                                           |
| Temporary migration duplication                                    | Not an exception | Governed by the bounded migration implementation plan                            |
| Obsolete code awaiting deletion                                    | Not an exception | Governed by `Remove later` and Goal 9 cleanup                                    |
| Exact migration folder organization                                | Not an exception | Assigned to Goal 6 within accepted ownership                                     |
| Exact target test layout                                           | Not an exception | Assigned to Goal 10 within accepted verification ownership                       |
| Current internal test expectations                                 | Not an exception | Historical evidence does not establish target architecture                       |
| Current registration implementation                                | Not an exception | Replaced by accepted Application Registration direction                          |
| Existing direct cross-owner implementation access                  | Not an exception | Must be replaced by accepted public boundaries rather than preserved             |
| Implementation convenience                                         | Rejected basis   | Cost or effort alone cannot justify architecture deviation                       |

## 7. Entry Schema

Add a proposed entry using this structure:

```text
Exception ID:
Architecture rule:
Rule source:
Exact deviation:
Evidence and rationale:
Affected owners:
Affected paths:
Scope:
Duration: permanent | bounded
Start condition:
Review or expiration condition:
Risks:
Prohibited expansion:
Verification:
Responsible owner:
Review state: proposed
Reviewed by:
Reviewed at:
Acceptance evidence:
```

Use identifiers in this form:

```text
P7-EXC-001
P7-EXC-002
```

Identifiers must not be reused after rejection, expiration, or retirement.

## 8. Proposal Requirements

Before adding a proposed entry, confirm:

1. an accepted architecture rule exists;
2. the proposed state violates that rule;
3. target-conforming alternatives were evaluated;
4. the reason is not implementation convenience;
5. the exception is the smallest viable deviation;
6. affected owners and paths are explicit;
7. security and data effects are understood;
8. duration and review conditions are defined;
9. prohibited expansion is explicit;
10. verification is possible;
11. one responsible owner is identified.

A proposal that fails these requirements should be recorded as rejected reasoning, not as an active exception.

## 9. Acceptance Requirements

A proposed entry may move to accepted only when:

* the governing rule and source are verified;
* the exact deviation is understood;
* architectural alternatives were considered;
* security, authorization, Workspace, Tenant, privacy, audit, persistence, and operational effects are addressed where applicable;
* verification is complete enough to constrain implementation;
* scope and prohibited expansion are reviewable;
* the duration is explicit;
* the responsible owner accepts later implementation responsibility;
* repository-owner acceptance is recorded.

Passing automated validation alone does not accept an exception.

## 10. Active Exception Controls

Every active exception must be checked during applicable:

* architecture reconciliation;
* dependency validation;
* code review;
* security review;
* persistence review;
* compatibility review;
* migration planning;
* documentation reconciliation.

Validation must distinguish:

```text
Inside accepted exception scope
The deviation is allowed only as recorded.

Outside accepted exception scope
The normal target architecture applies.
```

An accepted exception must not be generalized by analogy.

## 11. Review, Expiration, And Retirement

### 11.1. Bounded Exceptions

A bounded exception must be reviewed when its declared condition occurs.

Possible outcomes:

* continue with updated evidence;
* narrow the exception;
* replace it with target-conforming architecture;
* expire and remove it;
* convert it to permanent through a new accepted architecture decision.

### 11.2. Permanent Exceptions

A permanent exception remains active until superseded by an accepted architecture decision.

Permanent does not mean exempt from future architecture review.

### 11.3. Retirement Fields

Retired or expired entries remain in the register with:

```text
Final status:
Retirement or expiration issue:
Final verification:
Removal or normalization evidence:
Accepted by:
Accepted at:
```

Do not delete historical entries from the register.

## 12. Relationship To Other Registers

* Compatibility obligations belong in [Compatibility Register](compatibility-register.md).
* Later implementation details belong in [Later-Owner Decision Register](later-owner-decision-register.md).
* Target direction belongs in [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md).
* Migration classifications are governed by [Phase 7.3 Migration Classification](7-3-migration-classification.md).
* Durable architecture-rule promotion belongs in `durable-promotion-register.md`.

A single concern may reference several artifacts, but each artifact must retain its distinct authority.

## 13. Validation

Before Phase 7.5 acceptance:

* confirm accepted architecture exceptions remain empty;
* confirm proposed architecture exceptions remain empty;
* confirm rejected presumed exceptions match the accepted direction matrix;
* confirm current inconsistencies are not treated as accepted deviations;
* confirm compatibility and later-owner decisions remain separate;
* confirm the entry schema requires rule source, scope, duration, risk, prohibited expansion, verification, and owner;
* confirm no entry attributes repository-owner acceptance without explicit owner action;
* confirm no exception implementation is authorized by this register;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 14. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Accepted architecture exceptions:
* Proposed architecture exceptions:
* Rejected presumed exceptions:
* Required corrections:
* Validation evidence:
* Downstream handoff:

## 15. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
