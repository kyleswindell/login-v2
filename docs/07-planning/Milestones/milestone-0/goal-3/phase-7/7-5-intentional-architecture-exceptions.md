<!--
DOC-META
title: Phase 7.5 Intentional Architecture Exceptions
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-5-intentional-architecture-exceptions.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the requirements for accepting intentional deviations from the Goal 3 target architecture and records the initial conclusion that no architecture exceptions are currently required.
-->

# Phase 7.5 Intentional Architecture Exceptions

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Define when the repository may intentionally deviate from an accepted Goal 3 architecture rule.

An architecture exception is a reviewed and explicitly accepted deviation from the target architecture.

It is not:

* an unresolved design question;
* current-state inconsistency;
* temporary migration sequencing;
* compatibility behavior;
* deferred cleanup;
* implementation convenience;
* authorization to preserve obsolete structure.

No architecture exception exists unless it is entered in the architecture-exception register and explicitly accepted by the repository owner.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Exception implementation authorized: no
* Register: [Architecture Exception Register](architecture-exception-register.md)
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * Phase 7.1 mapping scope;
  * reconciled Phase 7.2 direction matrix;
  * Phase 7.3 migration classification;
  * Phase 7.4 compatibility requirements.

## 3. Exception Policy

The Phase 7 default is:

```text
Architecture exceptions accepted: none
Architecture exceptions proposed: none
```

The accepted Goal 3 architecture applies unless a register entry states otherwise.

A later implementation issue may refine internal design without creating an exception when:

* the accepted owner remains unchanged;
* the accepted placement direction remains unchanged;
* public Contracts remain respected;
* prohibited dependencies are not introduced;
* no generic owner or structural bypass is created.

Silence, historical placement, or implementation difficulty does not create an exception.

## 4. Definition

An intentional architecture exception exists when all of the following are true:

1. an accepted architecture rule applies;
2. the proposed target state would violate that rule;
3. the deviation is deliberate rather than accidental;
4. conforming to the rule is not reasonably available for the required outcome;
5. the exact deviation is bounded;
6. risks and prohibited expansion are documented;
7. verification is defined;
8. one accountable owner is identified;
9. repository-owner acceptance is recorded.

If no accepted rule is being violated, the subject is not an architecture exception.

## 5. Potentially Qualifying Exceptions

A proposed exception may qualify when evidence requires a permanent or explicitly bounded deviation such as:

* a required Core capability remaining outside the accepted Core topology;
* a permanent cross-owner implementation dependency that cannot use a public Contract;
* an optional Module depending directly on another owner’s private implementation;
* a generic root directory retained as a permanent owner despite normal owner-local placement;
* a Laravel integration constraint that permanently prevents the accepted owner-local structure;
* a legacy external integration that requires structurally inconsistent ownership;
* a permanent shared persistence owner that contradicts accepted capability ownership;
* a required runtime dependency that reverses the accepted dependency direction.

These examples do not authorize an exception. Each case still requires complete evidence and review.

## 6. Matters That Are Not Architecture Exceptions

### 6.1. Current-State Inconsistency

Existing Platform, Surface, false Module, centralized manifest, generic Support, or mixed root placement is migration evidence.

It is not an accepted exception merely because it currently exists.

### 6.2. Temporary Migration State

A temporary state needed while responsibilities move, split, extract, or replace belongs to the later migration plan.

Temporary sequencing does not establish permanent architectural authority.

### 6.3. Compatibility Mechanism

An alias, redirect, adapter, dual-read period, or translation layer belongs in the compatibility register.

Compatibility may temporarily bridge architectures but does not change the accepted target.

### 6.4. Later-Owner Detail

Unknown filenames, class design, test layout, schema details, migration order, or route structure belong in the later-owner decision register when ownership and direction are already accepted.

### 6.5. Deferred Removal

Obsolete code or tooling classified as `Remove later` belongs to a cleanup issue.

Continued physical presence before cleanup is not an architecture exception.

### 6.6. Framework Integration Boundary

Retained Laravel-native boundaries such as `bootstrap/`, `config/`, sparse root route files, root Providers, public entrypoints, and genuinely application-wide middleware are normal target structures when used within their accepted restrictions.

### 6.7. Accepted UI Contract Preservation

Preserving accepted UI Elements, Components, Patterns, Layouts, aliases, tokens, JavaScript APIs, accessibility behavior, or interaction Contracts is a normal preservation requirement.

It is not an exception.

### 6.8. Public Cross-Owner Contract

One owner consuming another through an accepted public Contract, Query, Event, read model, or Contribution mechanism is normal architecture.

Direct private implementation access would require separate review.

### 6.9. Implementation Convenience

Reduced effort, fewer changed files, existing test expectations, or a desire to avoid migration work do not qualify.

## 7. Initial Phase 7 Conclusion

No reviewed evidence currently requires a deviation from the accepted Goal 3 target architecture.

The following are resolved through normal migration direction rather than exceptions:

* `app/Platform/` is split, replaced, or removed;
* generic Surface ownership is removed;
* required Core capabilities under `Modules/` are extracted into Core;
* optional Modules remain independently managed packages;
* Application Registration replaces centralized manifest authority;
* owner-specific Delivery, persistence, presentation, and runtime artifacts move owner-local;
* accepted reusable UI remains UI-owned;
* framework roots remain restricted integration boundaries;
* temporary and obsolete tooling receives later cleanup ownership;
* cross-owner use occurs through public Contracts or accepted Contribution mechanisms.

Initial register result:

```text
Accepted architecture exceptions: none
Proposed architecture exceptions: none
```

## 8. Architecture Exception Register Contract

Each proposed exception must contain:

| Field                          | Requirement                                                              |
| ------------------------------ | ------------------------------------------------------------------------ |
| Exception ID                   | Stable identifier such as `P7-EXC-001`                                   |
| Architecture rule              | Exact accepted rule that would be violated                               |
| Rule source                    | Canonical or accepted planning source containing the rule                |
| Exact deviation                | Narrow statement of what may differ                                      |
| Evidence and rationale         | Concrete reason conformity is not reasonably available                   |
| Affected owners and paths      | Exact capability, Module, integration boundary, and relevant paths       |
| Scope                          | Behavior and files covered by the exception                              |
| Duration                       | Permanent or explicitly bounded                                          |
| Start condition                | Event or accepted implementation state activating the exception          |
| Review or expiration condition | Date, event, or evidence requiring reconsideration                       |
| Risks                          | Dependency, security, data, operational, maintenance, or ownership risks |
| Prohibited expansion           | Adjacent uses that remain forbidden                                      |
| Verification                   | Automated, manual, architecture, security, or operational proof          |
| Responsible owner              | One accountable capability, Module, repository, or operations owner      |
| Review state                   | Proposed, accepted, rejected, expired, or retired                        |
| Acceptance evidence            | Repository-owner action accepting the entry                              |

A proposed entry must remain unaccepted until explicit repository-owner action occurs.

## 9. Qualification Requirements

Before an exception may be accepted, confirm:

1. the governing architecture rule is identified exactly;
2. the proposed state genuinely violates that rule;
3. normal target-conforming options were evaluated;
4. the reason is stronger than implementation convenience;
5. the affected responsibility and owner are explicit;
6. the deviation is the smallest viable exception;
7. security, authorization, Workspace, Tenant, privacy, audit, and persistence effects are defined;
8. dependency direction remains understandable;
9. verification can prove the exception stays within its boundary;
10. prohibited expansion is explicit;
11. duration and review conditions are explicit;
12. repository-owner acceptance is recorded.

An exception with an unknown owner, unknown rule, or unbounded scope must be rejected.

## 10. Scope And Containment

An accepted exception applies only to its stated scope.

It must not be used to justify:

* new generic Platform or Surface ownership;
* unrelated cross-owner dependencies;
* additional private implementation access;
* broader root placement;
* new optional Module exceptions;
* reduced authorization checks;
* wider persistence access;
* bypassing Application Registration;
* bypassing accepted UI Contracts;
* retaining adjacent obsolete structures.

Similar future cases require their own review unless the accepted entry explicitly covers them.

## 11. Duration And Review

An exception must be classified as:

```text
Permanent
The deviation is part of the accepted target architecture unless a later architecture decision replaces it.

Bounded
The deviation is accepted only until a stated event, date, migration completion, dependency removal, or review gate.
```

A bounded exception must define:

* activation condition;
* expiration or review condition;
* responsible review owner;
* evidence required for continuation;
* removal or normalization owner.

An expired exception does not remain active automatically.

## 12. Verification Requirements

Verification must prove:

* the exception is limited to its accepted paths and owner;
* prohibited dependencies are not introduced elsewhere;
* security and authorization boundaries remain intact;
* Workspace and Tenant boundaries remain intact where applicable;
* persistence access remains within the accepted exception;
* no generic owner is created through expansion;
* required public Contracts remain stable;
* expiration or review signals are observable;
* target-conforming behavior remains the default outside the exception.

Applicable proof may include:

* architecture dependency checks;
* namespace or path validation;
* static repository guardrails;
* public Contract tests;
* security and authorization tests;
* persistence-boundary tests;
* configuration validation;
* manual architecture review;
* operational monitoring.

Passing implementation tests alone does not approve an architecture exception.

## 13. Relationship To Other Phase 7 Artifacts

| Artifact                           | Responsibility                                                                            |
| ---------------------------------- | ----------------------------------------------------------------------------------------- |
| Current-to-target direction matrix | Records accepted target ownership and structural direction                                |
| Migration classification           | Defines Retain, Move, Split, Extract, Replace, and other dispositions                     |
| Compatibility register             | Records exceptional continuity obligations during transition                              |
| Architecture exception register    | Records accepted deviations from target architecture                                      |
| Later-owner decision register      | Records unresolved detail whose owner and direction are already established               |
| Durable promotion register         | Records architecture rules that should become permanent canonical standards               |
| Goal 9 migration work              | Implements accepted movement, replacement, compatibility, cleanup, and bounded exceptions |

A subject must not be recorded in multiple registers merely to avoid classifying it correctly.

## 14. Later Implementation Requirements

An accepted exception does not itself authorize implementation.

The later implementation issue must define:

* acceptance criteria;
* verification Contract;
* exact paths;
* allowed and forbidden dependencies;
* smallest complete implementation slice;
* security and data review;
* documentation synchronization;
* expiration or review mechanism;
* cleanup or normalization behavior when bounded.

The implementation must not exceed the accepted register entry.

## 15. Proposed Decision

Accept the Phase 7 intentional-exception policy as follows:

* the Goal 3 target architecture applies by default;
* no exception exists without an accepted register entry;
* current-state inconsistency is not an exception;
* temporary migration and compatibility behavior are governed separately;
* later-owner implementation detail is not an exception;
* exceptions must identify the exact violated rule;
* every exception must be minimal, bounded, verifiable, and owner-accountable;
* prohibited expansion must be explicit;
* no architecture exceptions are currently required.

## 16. Validation

Before acceptance:

* confirm the exception definition requires an actual rule violation;
* confirm current transitional structures are not treated as accepted exceptions;
* confirm compatibility and later-owner decisions remain separate;
* confirm each register field is mandatory;
* confirm duration, risks, prohibited expansion, verification, and owner are required;
* confirm accepted and proposed exception registers remain empty;
* confirm no exception implementation or repository change is authorized;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 17. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Accepted exception policy:
* Accepted architecture exceptions:
* Proposed architecture exceptions:
* Rejected presumed exceptions:
* Required corrections:
* Validation evidence:
* Downstream handoff:

## 18. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Architecture Exception Register](architecture-exception-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
