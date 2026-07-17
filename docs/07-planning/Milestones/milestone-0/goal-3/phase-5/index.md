<!--
DOC-META
title: Phase 5 Naming Conventions Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the accepted Phase 5 naming decisions, consolidated matrices and registers, compatibility boundaries, promotion targets, and downstream handoffs.
-->

# Phase 5 Naming Conventions Index

Parent: [Goal 3 Target Repository Architecture Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Authority And Scope](#2-authority-and-scope)
- [3. Phase Status](#3-phase-status)
- [4. Reading Order](#4-reading-order)
- [5. Decision Register](#5-decision-register)
- [6. Consolidated Deliverables](#6-consolidated-deliverables)
- [7. Accepted Naming Summary](#7-accepted-naming-summary)
- [8. Deferred Decisions And Downstream Handoffs](#8-deferred-decisions-and-downstream-handoffs)
- [9. Durable Promotion](#9-durable-promotion)
- [10. Validation And Closeout](#10-validation-and-closeout)
- [11. Related](#11-related)

## 1. Purpose

Phase 5 defines how material Login 2.0 repository artifacts are named from their owner, responsibility, Technical Role, identifier family, physical placement, public or internal purpose, and compatibility status.

This index routes Decisions 5.1 through 5.14 and the consolidated lookup artifacts required by Issue #52.

## 2. Authority And Scope

Phase 5 consumes:

- accepted Goal 3 Phases 1 through 4;
- [ADR-0005](../../../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md);
- [ADR-0006](../../../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md);
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md);
- [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md) for the later bounded Workspace, Frame Surface, and Core Navigation correction;
- applicable coding, database, testing, and documentation standards;
- current repository names only as implementation and compatibility evidence.

Phase 5 does not:

- reopen ADR-0007 machine-key grammar or identifier-family decisions;
- rename current files, namespaces, routes, configuration, database objects, or documentation;
- implement aliases, redirects, compatibility readers, or package migrations;
- design detailed database identifiers owned by Goal 6;
- define the complete verification architecture;
- reopen placement or dependency decisions owned by Phase 4.

## 3. Phase Status

- Planning lifecycle: active
- Decision state: Decisions 5.1 through 5.14 accepted through repository-owner Phase 5 review
- Consolidated deliverables: complete
- Implementation state: accepted target direction only
- Canonical promotion: synchronized across the primary standards, architecture, Definitions, and Goal 3 synthesis owners by this promotion package; repository validation remains required
- Final Phase 5 acceptance: pending repository checks and the Issue #52 Final Acceptance Record
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Downstream validation issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)

This index does not claim runtime implementation or migration. Promotion validation and final acceptance must be recorded from the applied repository state.

## 4. Reading Order

For a complete Phase 5 review:

1. read this index;
2. use the [Naming Convention Matrix](naming-convention-matrix.md) for artifact-level lookup;
3. use the [Role Terminology Matrix](role-terminology-matrix.md) when selecting a PHP Technical Role or suffix;
4. use the [Module Identity Matrix](module-identity-matrix.md) for Module identity fields and representations;
5. read the applicable Decision 5.1 through 5.14 document for rationale and boundaries;
6. use the [Compatibility And Rename Register](compatibility-and-rename-register.md) before retaining or migrating a legacy name;
7. use the [Durable Promotion Register](durable-promotion-register.md) when moving accepted Phase 5 rules into long-lived standards, architecture, Definitions, or verification ownership.

## 5. Decision Register

| Decision | Document | Accepted result |
| --- | --- | --- |
| 5.1 | [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md) | Folder families follow native conventions; namespace-bearing PHP paths map case-sensitively; generic production folders are prohibited |
| 5.2 | [Core Capability Naming](5-2-core-capability-naming.md) | Each accepted Core owner has one explicit identity record with separate technical, machine, path, and documentation forms |
| 5.3 | [Module Naming](5-3-module-naming.md) | Each Module has one explicit package identity using `Parasolutions\Modules\<Module>\` and `parasolutions/module-<module-slug>` |
| 5.4 | [Class And Interface Naming](5-4-class-and-interface-naming.md) | Declared types communicate purpose and role; interfaces use `Interface`; concrete implementations name their mechanism |
| 5.5 | [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md) | Action, Query, Resolver, Coordinator, Handler, Service, Manager, and Creator have distinct bounded meanings |
| 5.6 | [Delivery Artifact Naming](5-6-delivery-artifact-naming.md) | Delivery classes identify both exposed behavior and delivery responsibility |
| 5.7 | [Route And URL Naming](5-7-route-and-url-naming.md) | Route names are capability-first dotted keys; URLs are independently migratable lowercase kebab-case paths |
| 5.8 | [Configuration Naming](5-8-configuration-naming.md) | Configuration names reveal ownership; roots use capability or Module keys; runtime settings remain separate |
| 5.9 | [Event, Listener, Job, Queue, Notification, And Audit Naming](5-9-event-listener-job-queue-notification-and-audit-naming.md) | PHP class names and machine identifiers are predictably related but remain separate naming families |
| 5.10 | [Database Naming Boundary](5-10-database-naming-boundary.md) | Goal 3 defines broad Model, table, migration, and ownership expectations while Goal 6 retains detailed database authority |
| 5.11 | [Test And Fixture Naming](5-11-test-and-fixture-naming.md) | Tests and fixtures name observable behavior and scenarios; owner, type, and cross-cutting execution dimensions remain separate |
| 5.12 | [Documentation Naming](5-12-documentation-naming.md) | New prose paths use lowercase kebab-case, reserved filenames retain exact meanings, and legacy paths remain compatibility concerns |
| 5.13 | [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md) | Every retained legacy name requires one explicit bounded compatibility record or accepted exception |
| 5.14 | [Application Registration Terminology And Naming Boundaries](5-14-application-registration-terminology-and-naming-boundaries.md) | Application Registration terms identify required responsibilities and conditional artifact categories without mandating unnecessary custom classes or wrappers |

## 6. Consolidated Deliverables

| Artifact | Responsibility | Relationship to detailed decisions |
| --- | --- | --- |
| [Naming Convention Matrix](naming-convention-matrix.md) | Repository-wide lookup by artifact or identifier family | Summarizes Decisions 5.1 through 5.14 without replacing them |
| [Role Terminology Matrix](role-terminology-matrix.md) | Distinguishes commonly confused PHP and delivery roles plus abstraction boundaries | Consolidates Decisions 5.4, 5.5, 5.6, and 5.9 |
| [Module Identity Matrix](module-identity-matrix.md) | Defines the complete Module identity record and accepted representation relationships | Consolidates Decision 5.3 and applicable ADR-0007 rules |
| [Compatibility And Rename Register](compatibility-and-rename-register.md) | Records verified compatibility subjects, classification requirements, and removal ownership | Applies Decision 5.13 without implementing aliases or migration |
| [Durable Promotion Register](durable-promotion-register.md) | Routes accepted Phase 5 results into long-lived documentation, Definitions, agent guidance, validation, and later-goal ownership | Prevents Phase 5 planning from remaining the final durable standards owner |

These matrices and registers are canonical for their accepted Phase 5 planning relationships. Durable rules are promoted into their primary standards, architecture, and Definition owners; final Phase 5 acceptance remains pending. They do not replace the detailed decisions or their future durable promotion targets.

### Phase 6 correction

Phase 6 accepts `Navigation`, `app/Core/Navigation/`, `App\Core\Navigation\`, `navigation`, and owner-local `Contrib/Navigation/` as the Core Host and Contribution identity family. It also removes broad `Surface/`, `Surfaces/`, `<SubjectOrSurface>`, and Product-or-Page `Surface` naming from target architecture. Use the actual Product, Page, subject, format, or precise presentation role instead. Frame Surface remains a prose architecture term for named persistent-Frame regions and does not require a PHP suffix or folder.

All unrelated Phase 5 naming, package, route, configuration, Event, Job, test, fixture, documentation, Application Registration, and compatibility rules remain unchanged.

## 7. Accepted Naming Summary

- Folder naming is native-convention-first rather than governed by one universal casing rule.
- Namespace-bearing PHP directories use PascalCase and match their namespace segments exactly.
- Core capabilities and Modules use explicit identity records; machine keys, folders, namespaces, packages, URLs, configuration, and labels remain separate naming families.
- Concrete classes name their exact subject and Technical Role. Generic abstractions require one bounded reusable contract, invariant, lifecycle, or mechanism.
- Actions own state-changing intents; Queries own read intents; Resolvers derive results; Coordinators own reusable orchestration; Handlers own exact messages or protocols; Services are exceptional; Managers and generic Creators are prohibited by default.
- Delivery artifacts identify both behavior and delivery role and delegate application behavior inward.
- Route names, URLs, configuration keys, PHP event classes, stable machine identifiers, and logical queue names remain explicitly separate.
- Goal 3 defines broad database naming expectations but does not design Goal 6 schema details.
- Tests remain owner-local and behavior-focused; suite type, owner path, and cross-cutting group are separate execution dimensions.
- Compatibility is transitional by default, one-way, non-chainable, bounded, verified, and removal-owned.
- Application Registration terms identify architecture responsibilities and conditional artifact categories; native framework or existing repository artifacts may fulfill them, and custom descriptors, compilers, manifests, registrars, commands, or files are introduced only when independently justified.

## 8. Deferred Decisions And Downstream Handoffs

- Issue #5 retains the exact administrative URL-prefix decision.
- Goal 6 retains detailed database naming, schema, and physical database-migration authority.
- Phase 6 accepted the naming model against Settings, Projects, Modal and Dialog, and the Sidebar Navigation Frame Surface, with the bounded Core Navigation and Surface correction recorded above.
- Later verification work owns exact PHPUnit discovery configuration, CI partitioning, browser-runner selection, parallel execution, and architecture guardrail implementation.
- Phase 7 and later migration issues own physical renames, namespaces, package replacement, route and URL migration, configuration aliases, database migration, and compatibility removal.
- The final identity and ownership of the unresolved global-administration tooling namespace remains a bounded later decision; `Platform` is only a reserved transitional placeholder.
- Exact current-to-target mappings remain unaccepted until source artifacts, consumers, persistence, and external references are verified.
- Application Registration descriptor schema, serialization format, generated-output location, cache and source-control policy, bootstrap integration, compiler implementation, performance model, and migration sequence remain later implementation authority.

## 9. Durable Promotion

The [Durable Promotion Register](durable-promotion-register.md) routes Phase 5 results to:

- repository naming and PHP/Laravel coding standards;
- repository and Module architecture;
- event, queue, testing, database, and documentation standards;
- reusable Definitions where accepted terminology must be synchronized;
- scoped `AGENTS.md` or verification guardrails where durable execution behavior requires repository enforcement;
- Phase 6 validation and later migration owners.

Promotion must update the canonical owner and retire duplicated planning authority rather than copying full Phase 5 documents into multiple locations.

## 10. Validation And Closeout

Before Phase 5 closeout, verify in the active Goal 3 worktree:

```text
npm run lint:docs:guardrails
git diff --check
```

Also confirm:

- all 20 Phase 5 files are linked and discoverable;
- metadata, titles, canonical paths, parents, and templates are valid;
- matrix and register rows link to their detailed Phase 5 owners;
- the Goal 3 synthesis includes the accepted Phase 5 result;
- the Goal 3 index routes to this package;
- ADR-0007 identifier-family decisions were not reopened;
- no unresolved database, administrative-prefix, migration, global-administration, or verification decision is presented as accepted;
- the compatibility register does not manufacture aliases from rejected alternatives or unverified current names;
- Issue #52 contains the final repository-owner acceptance record.

## 11. Related

- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Placement And Dependency Rules Index](../phase-4/index.md)
- [Goal 3 Target Repository Architecture Index](../index.md)
- [Identifier And Key Standards](../../../../../02-standards/coding/Identifier%20And%20Key%20Standards.md)
- [PHP And Laravel Style Standards](../../../../../02-standards/coding/PHP%20And%20Laravel%20Style%20Standards.md)
- [Testing Standards](../../../../../02-standards/coding/Testing%20Standards.md)
- [Database Standards Index](../../../../../02-standards/database/index.md)
- [Documentation Standards Index](../../../../../02-standards/documentation/index.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
