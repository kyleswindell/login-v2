<!--
DOC-META
title: Phase 7.4 Compatibility Requirements
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-4-compatibility-requirements.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines when migration compatibility is required, establishes the compatibility-register contract, and records the initial Phase 7 conclusion that current internal pre-alpha structures do not require compatibility by default.
-->

# Phase 7.4 Compatibility Requirements

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Define when Goal 3 migration work must preserve a current interface, identifier, protocol, route, data reference, or other dependency during transition to the accepted target architecture.

Compatibility is exceptional and evidence-based.

No compatibility obligation exists unless it is explicitly recorded in the Phase 7 compatibility register.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Compatibility implementation authorized: no
* Register: [Compatibility Register](compatibility-register.md)
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * Phase 7.1 mapping scope;
  * reconciled Phase 7.2 direction matrix;
  * Phase 7.3 migration-classification contract.

## 3. Compatibility Policy

The Phase 7 default is:

```text
Compatibility required: no
```

Compatibility is required only when concrete evidence proves that a current contract or identifier must remain available during migration.

Current implementation, usage, naming, or placement does not create a compatibility obligation by itself.

The absence of a compatibility-register entry means:

```text
No compatibility requirement has been accepted.
```

## 4. Qualifying Compatibility Evidence

A compatibility obligation may be proposed when supported by one or more of the following.

### 4.1. External Consumer

A system, customer integration, service, deployment process, or other consumer outside the replaceable application implementation depends on the current contract.

Examples:

* externally invoked API route;
* webhook;
* public callback URL;
* integration command;
* documented machine-consumed file;
* package interface consumed outside the repository.

### 4.2. Accepted Public Contract

An accepted public application or UI Contract requires continuity during migration.

Examples:

* accepted UI Blade alias;
* accepted JavaScript initialization API;
* accepted public component property or event;
* published integration Contract;
* externally supported protocol.

Preserving an accepted public Contract is not automatically a temporary compatibility mechanism. It may instead be the permanent target Contract.

### 4.3. Persisted Identifier Or Data Reference

Persisted data contains an identifier, class reference, route key, configuration key, type discriminator, or other value that cannot be discarded or changed atomically.

Examples:

* persisted permission or capability keys;
* queued job identifiers;
* stored event or notification type keys;
* database values interpreted by deployed code;
* retained URLs stored in records;
* serialized integration references.

### 4.4. Operational Dependency

Operations, deployment, monitoring, backup, recovery, support, or incident-response processes require continuity.

Examples:

* health or readiness endpoint;
* deployment command;
* monitoring integration;
* log or audit ingestion contract;
* rollback dependency.

### 4.5. Security, Legal, Privacy, Or Audit Requirement

A requirement mandates continuity, traceability, retention, or controlled transition.

Examples:

* audit event identity;
* security monitoring signal;
* legally retained identifier;
* privacy export field;
* regulated integration Contract.

### 4.6. Non-Atomic Repository Transition

A retained repository tool or independent package cannot change in the same accepted migration slice.

This basis is valid only when:

* the dependency is concrete;
* the transition cannot be atomic;
* the compatibility period is bounded;
* the removal condition is declared.

Convenience alone is not sufficient.

## 5. Non-Qualifying Evidence

The following do not establish compatibility:

* current internal references;
* current filesystem placement;
* current namespace or class name;
* current route or command name;
* current configuration key;
* current manifest format;
* current test expectation;
* current database design without retained data evidence;
* current use by unfinished pre-alpha application code;
* implementation convenience;
* fear of changing several internal callers;
* a stale document or comment;
* an inventory classification of `compatibility` that deferred the target decision;
* physical presence without proven registration or consumption.

A current test may provide historical behavior evidence, but it does not create compatibility authority independently.

## 6. Initial Phase 7 Compatibility Conclusion

No accepted compatibility obligation is currently identified for:

* `App\Platform\` namespaces;
* `App\Modules\` namespaces;
* current internal class or interface names;
* `/platform/*` routes;
* a shared `/admin/*` route family;
* current internal route names;
* current command names;
* current configuration keys;
* current manifest formats;
* the `PlatformManagement` category;
* current Platform or generic Surface paths;
* required Core capabilities currently packaged under `Modules/`;
* current non-UI test structure;
* obsolete Docs Viewer behavior;
* active-batch workflow tooling;
* current internal registration implementation.

These may be replaced, renamed, moved, split, extracted, or removed without compatibility unless later evidence proves a qualifying obligation.

## 7. UI Contract Treatment

Accepted UI public contracts remain protected.

Applicable contracts include:

* Blade aliases;
* public props and slots;
* variants, sizes, and states;
* JavaScript initialization APIs;
* data attributes;
* CSS classes explicitly accepted as public APIs;
* accessibility and interaction behavior;
* machine-readable UI contracts;
* accepted examples, fixtures, and verification evidence.

This protection normally represents permanent Contract preservation, not temporary compatibility.

A compatibility-register entry is needed only when:

* the accepted target changes the public Contract;
* old and new Contracts must coexist temporarily;
* a deprecation or adapter period is required;
* an external consumer cannot migrate atomically.

## 8. Compatibility Register Contract

Each accepted compatibility obligation must use these fields:

| Field                          | Requirement                                                                             |
| ------------------------------ | --------------------------------------------------------------------------------------- |
| Compatibility ID               | Stable identifier such as `P7-COMP-001`                                                 |
| Current contract or identifier | Exact route, key, namespace, protocol, data reference, or public API                    |
| Evidence and consumer          | Concrete evidence establishing the obligation                                           |
| Target contract                | Accepted replacement or permanent target                                                |
| Compatibility mechanism        | Alias, redirect, adapter, translation, dual read, migration, or other bounded mechanism |
| Start condition                | Event or implementation state that activates compatibility                              |
| Removal condition              | Observable condition permitting removal                                                 |
| Verification                   | Automated, manual, operational, or specialist proof                                     |
| Later owner                    | Goal, issue, capability, Module, UI, or operations owner                                |
| Risk                           | Security, data, operational, maintenance, or ambiguity risk                             |
| Notes                          | Material qualification only                                                             |

A proposed entry must remain unaccepted until repository-owner review.

## 9. Allowed Compatibility Mechanisms

A compatibility entry may use one or more bounded mechanisms such as:

* route redirect;
* route-name alias;
* class or interface adapter;
* configuration-key translation;
* command alias;
* data migration;
* dual-read transition;
* write-new/read-old transition;
* event or notification key translation;
* public API deprecation wrapper;
* temporary Registration Descriptor translation.

The mechanism must be selected by the later implementation owner.

Phase 7 records the obligation and boundaries, not the detailed implementation.

## 10. Compatibility Mechanism Requirements

Every mechanism must:

* have one accepted owner;
* preserve required behavior only;
* avoid granting broader authorization;
* preserve security and Tenant or Workspace boundaries;
* be testable;
* be observable where operationally necessary;
* avoid silent data loss;
* have an explicit removal condition;
* avoid becoming the permanent architecture accidentally.

A compatibility mechanism must not:

* preserve an obsolete owner model;
* create a generic Platform or Surface layer;
* bypass public Contracts;
* weaken authorization;
* conceal unresolved architecture;
* persist indefinitely without review;
* be added merely because migration sequencing is inconvenient.

## 11. Verification Requirements

Each compatibility entry must define proof for:

* the retained old contract;
* the accepted new contract;
* translation or routing between them;
* rejection behavior;
* authorization and scope boundaries;
* persisted-data handling where applicable;
* observability and audit behavior where applicable;
* removal readiness.

The verification contract must identify:

* exact actor and fixture;
* exact environment;
* exact command or procedure;
* expected behavior before removal;
* expected behavior after removal;
* protected verification baseline.

Passing the new Contract alone does not prove that temporary compatibility works.

## 12. Removal Requirements

Every temporary compatibility mechanism must define a removal owner and removal gate.

Removal may occur only when:

* all known consumers have migrated;
* retained data has been migrated or no longer references the old identity;
* required monitoring shows no remaining use;
* rollback and deployment requirements permit removal;
* required verification passes without the mechanism;
* repository-owner acceptance authorizes removal.

Removal work belongs to a separately accepted implementation or cleanup issue.

Phase 7 does not authorize deletion.

## 13. Relationship To The Direction Matrix

The direction matrix records the target architectural relationship.

The compatibility register records exceptional transition obligations.

Examples:

| Matrix disposition | Compatibility implication                                                          |
| ------------------ | ---------------------------------------------------------------------------------- |
| Retain             | No compatibility needed unless a public Contract changes                           |
| Move               | Old path or namespace is not preserved unless a consumer requires it               |
| Rename             | Old identity is not aliased unless evidence requires it                            |
| Split              | Current umbrella is not preserved merely to bridge new owners                      |
| Extract            | False Module package identity is not preserved by default                          |
| Replace            | Old abstraction is removed after replacement unless a consumer requires transition |
| Remove later       | No compatibility unless removal affects a qualifying dependency                    |
| Decision blocked   | Compatibility cannot be accepted until the target is known                         |

Disposition and compatibility must remain separate.

## 14. Initial Compatibility Register State

The initial register should record:

```text
Accepted compatibility obligations: none
Proposed compatibility obligations: none
Rejected presumed obligations:
- App\Platform namespaces
- App\Modules namespaces
- /platform routes
- shared /admin route family
- internal command names
- internal configuration keys
- central manifest formats
- Platform and Surface paths
- current non-UI tests
```

A new entry may be added only when qualifying evidence is discovered and reviewed.

## 15. Proposed Decision

Accept the Phase 7 compatibility policy as follows:

* compatibility is opt-in and evidence-based;
* no register entry means no compatibility requirement;
* internal pre-alpha implementation does not create compatibility;
* accepted UI public contracts remain protected;
* qualifying external, persisted, operational, security, legal, privacy, audit, or non-atomic dependencies must be registered;
* every temporary mechanism requires verification and removal conditions;
* Phase 7 records obligations but does not implement them;
* no current compatibility obligations have been identified.

## 16. Validation

Before acceptance:

* confirm every proposed compatibility obligation has concrete evidence;
* confirm no matrix row implies compatibility through wording;
* confirm accepted UI Contract preservation is distinguished from temporary compatibility;
* confirm every register field is required;
* confirm removal conditions and later owners are mandatory;
* confirm the initial register records no accepted obligations;
* confirm no compatibility implementation or deletion is authorized;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 17. Acceptance Record

- Outcome: Accepted
- Date: 2026-07-22
- Accepted or rejected by: Repository owner
- Accepted compatibility policy: Compatibility is opt-in, evidence-based, and requires an accepted register entry
- Accepted compatibility entries: None
- Rejected presumed obligations: As recorded in compatibility-register.md
- Required corrections: None
- Validation evidence:
  - npm run lint:docs:guardrails — PASS
  - git diff --check — PASS
- Downstream handoff: Phase 7.5 intentional architecture exceptions

## 18. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.1 Current-To-Target Mapping Scope](7-1-current-to-target-mapping-scope.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
