<!--
DOC-META
title: Phase 5 Durable Promotion Register
doc_type: matrix
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/durable-promotion-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Routes accepted Phase 5 naming results into durable standards, architecture, Definitions, agent guidance, validation, and later migration ownership.
-->

# Phase 5 Durable Promotion Register

Parent: [Phase 5 Naming Conventions Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Register For](#3-use-this-register-for)
- [4. Do Not Use This Register For](#4-do-not-use-this-register-for)
- [5. Source Documents](#5-source-documents)
- [6. Promotion Principles](#6-promotion-principles)
- [7. Decision Promotion Register](#7-decision-promotion-register)
- [8. Consolidated Artifact Promotion](#8-consolidated-artifact-promotion)
- [9. Verification And Enforcement Handoff](#9-verification-and-enforcement-handoff)
- [10. Open Decisions](#10-open-decisions)
- [11. Maintenance Notes](#11-maintenance-notes)
- [12. Related](#12-related)

## 1. Purpose

Route accepted Phase 5 planning results into the long-lived canonical owners that must govern implementation after Goal 3, while keeping planning, standards, architecture, Definitions, agent guidance, verification, and migration responsibilities separate.

## 2. Status

- Register lifecycle: planned
- Promotion state: primary canonical targets synchronized by the Phase 5 canonical-promotion package; repository validation and final acceptance pending
- Implementation state: documentation promotion only; no runtime guardrail implementation, physical rename, alias implementation, or migration
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

## 3. Use This Register For

Use this register to:

- identify the durable canonical destination for each Phase 5 result;
- distinguish create, update, cross-link, validation, and migration actions;
- prevent accepted naming rules from remaining only in planning;
- avoid copying the same durable rule into several competing documents;
- identify later implementation and enforcement owners.

## 4. Do Not Use This Register For

Do not use this register to:

- claim that repository validation or final acceptance passed without exact command and review evidence;
- create new standards without repository-owner review;
- replace the detailed Phase 5 decisions;
- treat planning as implemented truth;
- implement static checks, namespace changes, package migration, aliases, or database work;
- update `AGENTS.md` unless durable agent execution behavior genuinely requires it.

## 5. Source Documents

- Decisions 5.1 through 5.14
- [Naming Convention Matrix](naming-convention-matrix.md)
- [Role Terminology Matrix](role-terminology-matrix.md)
- [Module Identity Matrix](module-identity-matrix.md)
- [Compatibility And Rename Register](compatibility-and-rename-register.md)
- [Application Registration Terminology And Naming Boundaries](5-14-application-registration-terminology-and-naming-boundaries.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Durable Promotion Register](../phase-4/durable-promotion-register.md)
- [Doc Governance](../../../../../02-standards/documentation/Doc%20Governance.md)
- [Planning Documentation Standards](../../../../../02-standards/documentation/Planning%20Documentation%20Standards.md)

## 6. Promotion Principles

1. Phase 5 planning remains canonical for accepted decision history and traceability; promoted standards, architecture, and Definitions own durable implementation rules.
2. Durable rules belong in standards; long-lived ownership and topology belong in architecture; reusable role meaning may also require synchronized Definitions.
3. One canonical owner contains the full durable rule. Related documents link to it and summarize only what their own responsibility requires.
4. Promotion updates indexes, metadata, parent links, terminology, and active planning references in the same work cycle.
5. Promotion is incomplete when the new owner and Phase 5 planning remain competing full authorities.
6. Agent guidance receives only durable execution constraints that agents must follow; it must route to canonical docs rather than duplicate them.
7. Verification and migration are separate later actions. A promoted rule is not proof that implementation follows it.

## 7. Decision Promotion Register

| Decision                                                        | Durable result                                                                                                                                                    | Primary canonical target                                                                                                                  | Additional synchronization                                                                                                                                                                                           | Action type                                                                    | Later verification or implementation owner                                                                    | Status                           |
| --------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------- | -------------------------------- |
| 5.1 Folder and namespace naming                                 | Native-convention-first folder families, PSR-4 case matching, controlled Technical Role labels, prohibited generic destinations                                   | Create or update `docs/02-standards/coding/repository-naming-standards.md`                                                                | Update `docs/03-architecture/repository-architecture.md`; cross-link `PHP And Laravel Style Standards.md`; update root/scoped agent guardrails only if enforcement behavior is accepted                              | Create standard; update architecture and links                                 | Phase 6 representative validation; later static path and namespace checks                                     | synchronized; validation pending |
| 5.2 Core capability naming                                      | Explicit Core owner identity records and separation of owner, capability, path, namespace, slug, and title                                                        | `docs/03-architecture/repository-architecture.md`                                                                                         | Cross-link `Identifier And Key Standards.md`; synchronize the reusable Core Definition and Core planning identity matrices where applicable                                                                          | Update architecture and Definition references                                  | Phase 6 Core example; later Core migration issues                                                             | synchronized; validation pending |
| 5.3 Module naming                                               | Explicit Module identity record; `Parasolutions\Modules\<Module>\`; `parasolutions/module-<slug>`                                                                 | `docs/03-architecture/repository-architecture.md` and the durable Module architecture/package standard selected by later promotion review | Synchronize Module Definition, Module layout/package planning, Composer guidance, and `Identifier And Key Standards.md` cross-links                                                                                  | Update architecture; create or update Module package standard                  | Phase 6 Module example; later package and namespace migration                                                 | synchronized; validation pending |
| 5.4 Class and interface naming                                  | Type/file matching, interface suffix, semantic implementations, Data Object terminology, Provider/Registry/Definition naming, abstraction boundary                | `docs/02-standards/coding/repository-naming-standards.md` and `PHP And Laravel Style Standards.md`                                        | Synchronize relevant reusable Definitions for Contracts, Data Objects, Providers, Registries, and Module Definitions                                                                                                 | Create/update standards and Definitions                                        | Later coding guardrails and representative implementation proof                                               | synchronized; validation pending |
| 5.5 Action, service, query, and coordination naming             | Distinct Action, Query, Resolver, Coordinator, Handler, Service, Manager, and Creator roles                                                                       | `docs/02-standards/coding/repository-naming-standards.md`                                                                                 | Synchronize Action and Query Definitions plus any future service-layer or feature-development guidance                                                                                                               | Update standard and Definitions                                                | Phase 6 examples; later architecture tests or code review rules                                               | synchronized; validation pending |
| 5.6 Delivery artifact naming                                    | Precise Controller, Request, Middleware, Resource, Presenter, Renderer, PageData, ViewModel, Command, and WebhookHandler roles                                    | `docs/02-standards/coding/repository-naming-standards.md` and applicable HTTP/console coding standards                                    | Synchronize HTTP and Console Delivery Adapter Definitions; update repository architecture delivery examples                                                                                                          | Update standards, architecture, and Definitions                                | Phase 6 delivery Surface example; later delivery tests                                                        | synchronized; validation pending |
| 5.7 Route and URL naming                                        | Capability-first route names, independently migratable lowercase URLs, separate alias and redirect mechanisms                                                     | `docs/02-standards/coding/repository-naming-standards.md` and applicable route standards                                                  | Cross-link `Identifier And Key Standards.md`; preserve Issue #5 ownership of exact administrative prefix                                                                                                             | Update standards and cross-links                                               | Phase 6 route example; later route migration and static duplicate checks                                      | synchronized; validation pending |
| 5.8 Configuration naming                                        | Owner-specific config files and roots, snake-case keys, environment mapping, runtime settings separation                                                          | `docs/02-standards/coding/repository-naming-standards.md` and applicable configuration standards                                          | Update repository architecture configuration examples and settings/configuration boundary links                                                                                                                      | Update standards and architecture                                              | Phase 6 config example; later config-key migration and validation                                             | synchronized; validation pending |
| 5.9 Event, Listener, Job, Queue, Notification, and Audit naming | Completed-fact Events, imperative Listeners and Jobs, semantic Notifications, Audit Event naming, broad logical queues, class/key separation                      | `docs/02-standards/coding/Events Jobs And Queue Standards.md` plus repository naming standard                                             | Synchronize Event, Listener, and Job Definitions; update audit and notification standards where class/key naming is owned                                                                                            | Update standards and Definitions                                               | Phase 6 communication example; later queue/event compatibility and observability checks                       | synchronized; validation pending |
| 5.10 Database naming boundary                                   | Broad Model/table/migration expectations and explicit Goal 6 boundary                                                                                             | `docs/02-standards/database/Schema Design Standards.md` and `Database Migration Standards.md`                                             | Update repository architecture persistence examples; cross-link Goal 6 and database table-contract standards                                                                                                         | Update database standards and architecture links                               | Goal 6; Phase 6 only verifies naming/placement applicability                                                  | synchronized; validation pending |
| 5.11 Test and fixture naming                                    | Behavior-focused names, precise fixtures/factories, owner/type/group execution dimensions, no aggregator index files                                              | `docs/02-standards/coding/Testing Standards.md`                                                                                           | Update future PHPUnit discovery configuration, test templates, and agent verification guidance only when implementation is accepted                                                                                  | Update testing standard; later tooling/config implementation                   | Phase 6 representative discovery proof; later CI and suite implementation                                     | synchronized; validation pending |
| 5.12 Documentation naming                                       | New kebab-case prose paths, reserved filenames, ADR sequence, indexes, legacy path compatibility                                                                  | `docs/02-standards/documentation/How To Write Docs.md`, `Doc Governance.md`, and `Decision Record Standards.md`                           | Update document templates and guardrail tooling only where the accepted naming contract requires it                                                                                                                  | Update documentation standards and templates                                   | Documentation guardrails; later authorized path migration                                                     | synchronized; validation pending |
| 5.13 Compatibility and rename rules                             | Material rename gate, explicit direct aliases, compatibility record, transitional default, removal ownership                                                      | Create or update `docs/02-standards/coding/repository-naming-standards.md`; cross-link relevant migration and compatibility standards     | Update Phase 7 migration planning; add agent stop rules only if durable execution behavior is accepted                                                                                                               | Create/update standard and planning handoff                                    | Phase 7 and bounded migration issues                                                                          | synchronized; validation pending |
| 5.14 Application Registration terminology and naming boundaries | Canonical architecture terms, conditional custom-artifact names, native-framework fulfillment, existing identifier reuse, and generated-output authority boundary | `docs/03-architecture/application-registration.md` and `docs/07-planning/Definitions/Application-Registration/Definition.md`              | Update `docs/03-architecture/repository-architecture.md`, architecture index, repository naming standard, naming matrix, and role matrix; retain format, cache, bootstrap, implementation, and migration as deferred | Update architecture and Definition; cross-link standard and Phase 6/7 handoffs | Phase 6 representative validation; Phase 7 migration; later accepted design and vertical-slice implementation | synchronized; validation pending |

The primary targets listed below are supplied by the Phase 5 canonical-promotion package. Their repository state is authoritative only after application, validation, and repository-owner review.

## 8. Consolidated Artifact Promotion

| Phase 5 artifact                                                          | Durable use after promotion                                    | Promotion treatment                                                                                                                | Status                           |
| ------------------------------------------------------------------------- | -------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- | -------------------------------- |
| [Naming Convention Matrix](naming-convention-matrix.md)                   | Concise cross-standard lookup and future guardrail source      | Retained as Goal 3 planning evidence; durable rules synchronized into standards and architecture                                   | synchronized; validation pending |
| [Role Terminology Matrix](role-terminology-matrix.md)                     | Shared role vocabulary for developers, Definitions, and review | Role meanings synchronized into the repository naming standard and affected Definitions; planning matrix retained for traceability | synchronized; validation pending |
| [Module Identity Matrix](module-identity-matrix.md)                       | Module architecture and package identity contract              | Identity fields synchronized into repository architecture, naming standards, Identifier standards, and Module Definition           | synchronized; validation pending |
| [Compatibility And Rename Register](compatibility-and-rename-register.md) | Phase 7 migration input and later compatibility records        | Retain as planning register; create exact implementation records only after inventory and owner acceptance                         | planned                          |
| [Durable Promotion Register](durable-promotion-register.md)               | Promotion routing and closeout evidence                        | Retain through Goal 3 closeout and update final status only from applied repository validation and owner review                    | active planning owner            |

## 9. Verification And Enforcement Handoff

| Rule family                                    | Phase 6 proof                                                                                                                                                                                 | Later automated enforcement candidate                                                                                                                                      |
| ---------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Folder and namespace mapping                   | Representative Core, Module, UI, and delivery paths map without ambiguity                                                                                                                     | Case-sensitive namespace/path checks; prohibited direct roots and generic folders                                                                                          |
| Core and Module identity                       | Representative identity records contain all required fields and do not collapse naming families                                                                                               | Identity-schema validation; duplicate owner/module key checks; package metadata validation                                                                                 |
| Role terminology                               | Representative classes can be named without generic role ambiguity                                                                                                                            | Static prohibited-suffix/name checks where reliable; review remains necessary for semantics                                                                                |
| Route and configuration identity               | Representative route and config names follow capability or Module ownership                                                                                                                   | Duplicate route/config-key checks; invalid generic prefixes                                                                                                                |
| Events, Jobs, notifications, audit, and queues | Representative class/key pairs remain separate and correctly worded                                                                                                                           | Identifier grammar, duplicate-key, and registration checks                                                                                                                 |
| Tests and fixtures                             | Owner-local path and type selection discover unchanged proof without duplication                                                                                                              | Deterministic local/CI discovery and duplicate-execution checks                                                                                                            |
| Documentation                                  | New package passes metadata, parent, index, path, and link guardrails                                                                                                                         | Documentation naming and canonical-path validation                                                                                                                         |
| Compatibility                                  | Representative migration subjects show exact family, owner, proof, and removal condition                                                                                                      | Alias-chain, missing-target, stale-alias, and prohibited-new-legacy-use checks                                                                                             |
| Application Registration terminology           | Representative Core, Module, UI, and delivery examples can fulfill registration responsibilities without mandatory redundant wrappers while preserving deterministic validation and ownership | Descriptor/definition contract validation, duplicate and cycle checks, generated-output traceability, and prohibited generic registration-class checks where deterministic |

Phase 6 selects bounded guardrail candidates. This register does not implement them.

## 10. Open Decisions

| Decision                                                                                                                                                                                                   | Owner                                                     | Required action                                                                                                                                                                                         |
| ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Canonical naming-standard ownership                                                                                                                                                                        | Resolved by Phase 5 promotion                             | `repository-naming-standards.md` owns the general rule set; specialist standards own their domain-specific detail and cross-link it                                                                     |
| Module package naming ownership                                                                                                                                                                            | Resolved for Phase 5                                      | Repository architecture, repository naming standards, Identifier standards, and Module Definition own the accepted identity relationship; a separate package standard requires future independent need  |
| Reusable Definition synchronization                                                                                                                                                                        | Resolved by promotion package                             | Affected Core, Module, Technical Role, application-object, event/background, notification, Model, delivery, Registry, Contribution, Provider, and Application Registration Definitions are synchronized |
| Whether any naming rule belongs in root or scoped `AGENTS.md`                                                                                                                                              | Repository-owner agent-governance review                  | Add only durable execution constraints that agents must enforce; route to canonical standards                                                                                                           |
| Exact automated naming checks                                                                                                                                                                              | Phase 6 and later verification issues                     | Select checks that are deterministic and do not replace semantic review                                                                                                                                 |
| Promotion timing relative to final Goal 3 acceptance                                                                                                                                                       | Resolved for Phase 5                                      | Apply and validate promotion before the Issue #52 Final Acceptance Record; runtime implementation and migration remain later work                                                                       |
| Application Registration descriptor schema, serialization, generated-output path, source-control and cache policy, bootstrap integration, compiler architecture, performance model, and migration sequence | Phase 6, Phase 7, and later bounded implementation issues | Preserve 5.14 terminology and naming boundaries while requiring accepted design, smallest vertical slice, and validation before expanded tooling                                                        |

## 11. Maintenance Notes

- Change `synchronized; validation pending` to completed only after the exact package is applied, required repository commands pass, the diff is reviewed, and repository-owner acceptance is recorded.
- Preserve the distinction among `create`, `update`, `cross-link`, `Definition synchronization`, `agent guidance`, `validation`, and `migration` actions.
- Do not add speculative standards or Definitions solely to make the register appear complete.
- Keep detailed rationale in the Phase 5 decision and durable rule in one accepted canonical owner.
- When promotion occurs, update affected indexes and remove duplicated authoritative wording from planning where practical while preserving traceability.
- Record unexecuted checks and unresolved destinations directly.

## 12. Related

- [Phase 5 Naming Conventions Index](index.md)
- [Naming Convention Matrix](naming-convention-matrix.md)
- [Role Terminology Matrix](role-terminology-matrix.md)
- [Module Identity Matrix](module-identity-matrix.md)
- [Compatibility And Rename Register](compatibility-and-rename-register.md)
- [Application Registration Terminology And Naming Boundaries](5-14-application-registration-terminology-and-naming-boundaries.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Durable Promotion Register](../phase-4/durable-promotion-register.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
