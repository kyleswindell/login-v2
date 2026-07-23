<!--
DOC-META
title: Phase 5 Compatibility And Rename Register
doc_type: matrix
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/compatibility-and-rename-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Records verified Phase 5 compatibility subjects, classification requirements, prohibited assumptions, migration ownership, and objective removal conditions without implementing aliases.
-->

# Phase 5 Compatibility And Rename Register

Parent: [Phase 5 Naming Conventions Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Register For](#3-use-this-register-for)
- [4. Do Not Use This Register For](#4-do-not-use-this-register-for)
- [5. Source Documents](#5-source-documents)
- [6. Record Contract](#6-record-contract)
- [7. Known Compatibility Subjects](#7-known-compatibility-subjects)
- [8. Classification-Required Legacy Terms](#8-classification-required-legacy-terms)
- [9. Rejected Alternatives Are Not Aliases](#9-rejected-alternatives-are-not-aliases)
- [10. Open Decisions And Later Authority](#10-open-decisions-and-later-authority)
- [11. Maintenance Notes](#11-maintenance-notes)
- [12. Related](#12-related)

## 1. Purpose

Record Phase 5 compatibility subjects and rename boundaries without presenting unverified mappings, rejected alternatives, or proposed aliases as implemented or accepted runtime behavior.

## 2. Status

- Register lifecycle: planned
- Policy source: Decision 5.13 accepted through repository-owner Phase 5 review
- Implementation state: no aliases, redirects, compatibility readers, package replacements, or physical renames implemented by this register
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Migration handoff: Phase 7 and bounded later implementation issues

## 3. Use This Register For

Use this register to:

- distinguish accepted canonical direction from implemented compatibility;
- identify legacy subjects that require inventory or per-artifact classification;
- prevent blanket aliases across unrelated owners;
- assign the later migration or removal owner;
- record objective removal conditions before compatibility is implemented.

## 4. Do Not Use This Register For

Do not use this register to:

- claim that a compatibility mechanism exists;
- create a runtime alias from a planning row;
- infer one canonical target for a broad legacy area such as `Platform`;
- treat a rejected Phase 5 alternative as a legacy dependency;
- replace issue-specific impact, proof, rollout, rollback, or removal planning;
- authorize physical repository, namespace, route, configuration, documentation, or database migration.

## 5. Source Documents

- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Core Capability Naming](5-2-core-capability-naming.md)
- [Module Naming](5-3-module-naming.md)
- [Route And URL Naming](5-7-route-and-url-naming.md)
- [Configuration Naming](5-8-configuration-naming.md)
- [Documentation Naming](5-12-documentation-naming.md)
- [Phase 4 Exceptions And Future Enforcement](../phase-4/4-12-exceptions-and-future-enforcement.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)

## 6. Record Contract

Every implemented or permanently retained compatibility mapping must identify:

```text
identifier family
legacy name
canonical name
responsible owner
compatibility surface
verified reason
status
introduced by
required verification
removal condition
migration owner
tracking issue
```

Register status terms used here:

| Status                    | Meaning                                                                              |
| ------------------------- | ------------------------------------------------------------------------------------ |
| `target-accepted`         | Canonical direction is accepted, but compatibility and migration are not implemented |
| `classification-required` | No safe canonical mapping exists until each artifact and owner are classified        |
| `inventory-required`      | A target rule exists, but current consumers or references have not been verified     |
| `deferred`                | Later work explicitly owns the mapping or migration decision                         |
| `prohibited-assumption`   | A proposed or rejected name must not be treated as an alias without evidence         |

These are register classifications, not GitHub Project workflow states and not proof that compatibility exists.

## 7. Known Compatibility Subjects

| ID          | Identifier family                         | Legacy or transitional subject                                                                                                                   | Canonical direction                                                                                                                                                       | Responsible owner                                             | Status                                     | Compatibility treatment before implementation                                                                                                                                                       | Objective removal condition                                                                                                                                  | Later owner or issue                                                | Source                                                                                                               |
| ----------- | ----------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| P5-COMP-001 | PHP namespace                             | `App\Modules\<Module>\...` where verified                                                                                                        | `Parasolutions\Modules\<Module>\...` for each accepted Module                                                                                                             | Applicable Module and package-migration owner                 | `target-accepted` and `inventory-required` | Inventory all imports, serialized references, service-container bindings, generated caches, tests, and package consumers; introduce a direct temporary bridge only if proof requires it             | No runtime, test, serialized, cached, or external consumer references the legacy namespace; legacy mapping removed; unchanged targeted proof passes          | Phase 7 plus per-Module migration issue                             | [5.3](5-3-module-naming.md)                                                                                          |
| P5-COMP-002 | Composer autoload mapping                 | Root or shared mapping that treats `Modules/` as ordinary application source                                                                     | Package-local PSR-4 mapping from `Modules/<Module>/src/`                                                                                                                  | Root composition owner plus each accepted Module              | `target-accepted` and `inventory-required` | Verify root and package Composer files, autoload order, development/test autoload, discovery, and distribution requirements before changing mappings                                                | Every accepted Module owns its mapping; no legacy class depends on the root mapping; autoload verification passes                                            | Phase 7 and package implementation                                  | [5.1](5-1-folder-and-namespace-naming.md), [5.3](5-3-module-naming.md)                                               |
| P5-COMP-003 | Repository path and ownership terminology | Current `app/Platform/*` or other verified `Platform`-named implementation                                                                       | No universal target; classify each artifact into its actual Core capability, Module, UI responsibility, Surface, Registry, Delivery Adapter, or Laravel integration owner | Architecture owner plus each destination owner                | `classification-required`                  | Do not create a blanket namespace, path, owner-key, or configuration alias; classify source behavior, state, presentation, delivery, and consumers first                                            | Every artifact has one accepted target owner and path; required compatibility is separately recorded; no canonical work remains in the transitional location | Phase 7 and bounded migration issues                                | [5.2](5-2-core-capability-naming.md)                                                                                 |
| P5-COMP-004 | Configuration root                        | Verified generic `platform.*`, `shared.*`, or otherwise unowned configuration keys                                                               | Applicable capability or Module configuration root                                                                                                                        | Owner identified by behavior and configuration responsibility | `classification-required`                  | Inventory every key, environment mapping, default, consumer, cache, persisted override, and operational dependency; map each old key directly to one canonical key only after ownership is accepted | All consumers use the canonical key; legacy lookup removed; no persisted or environment dependency remains; targeted config proof passes                     | Later configuration migration issue                                 | [5.8](5-8-configuration-naming.md)                                                                                   |
| P5-COMP-005 | Route name                                | Verified generic or owner-derived route names such as `admin.*`, `core.*`, or `module.*` where the prefix is not part of the capability identity | Capability-first canonical route name                                                                                                                                     | Owning Core capability or Module                              | `inventory-required`                       | Inventory code generation, redirects, tests, navigation, policies, notifications, external clients, and stored route names; route-name alias is separate from URL compatibility                     | No consumer resolves the legacy route name; canonical route proof passes; alias removed                                                                      | Phase 7 or route-owner migration issue                              | [5.7](5-7-route-and-url-naming.md)                                                                                   |
| P5-COMP-006 | URL                                       | Verified legacy URL that differs from the accepted canonical resource or domain-action path                                                      | Accepted canonical lowercase kebab-case URL                                                                                                                               | Owning route and Surface owner                                | `inventory-required`                       | Define redirect status, method behavior, parameter translation, authorization, analytics, SEO, external-client, and bookmark impact; do not conflate with route-name alias                          | Redirect or compatibility path is no longer required under accepted product and operational criteria                                                         | Route-owner migration issue; Issue #5 retains admin-prefix decision | [5.7](5-7-route-and-url-naming.md)                                                                                   |
| P5-COMP-007 | Documentation path                        | Existing canonical path using spaces, older casing, or a superseded naming family                                                                | Accepted lowercase kebab-case path when an authorized move is justified                                                                                                   | Documentation owner                                           | `deferred`                                 | Update inbound links and metadata; preserve the old path as a concise pointer only when material inbound-link or historical value exists                                                            | Important inbound links use the canonical path; no practical compatibility need remains; pointer removed or archived                                         | Documentation migration issue                                       | [5.12](5-12-documentation-naming.md)                                                                                 |
| P5-COMP-008 | Stable machine identifier                 | Verified legacy event, Job, notification, audit, queue, registry, capability, Module, route, or configuration key                                | Exact accepted canonical key in the same identifier family                                                                                                                | Owner of the stable identifier                                | `inventory-required`                       | Inventory persisted values, messages, schedules, queues, audit records, external consumers, caches, and observability; use one direct alias or dual-reader only when accepted                       | No producer or consumer emits, stores, or resolves the legacy key; migration and replay obligations are satisfied                                            | Identifier-owner migration issue                                    | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md), [5.13](5-13-compatibility-and-rename-rules.md) |
| P5-COMP-009 | Database identifier                       | Any verified legacy table, column, index, constraint, foreign key, schema, or persisted value name                                               | Goal 6-approved canonical database identity                                                                                                                               | Goal 6 and table owner                                        | `deferred`                                 | No physical rename is authorized by Phase 5; define data-preservation, deployment, rollback, compatibility, and proof in Goal 6 work                                                                | Goal 6 migration acceptance and removal criteria are met                                                                                                     | Goal 6                                                              | [5.10](5-10-database-naming-boundary.md)                                                                             |

## 8. Classification-Required Legacy Terms

These terms describe known current or historical concepts but do not support one blanket legacy-to-canonical alias.

| Term                      | Likely relationship                                                                                              | Why a blanket alias is unsafe                                                                                   | Required next classification                                                                                      |
| ------------------------- | ---------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| `Account`                 | User-facing context or Surface, commonly backed by Identity-owned behavior                                       | Account presentation may compose Auth, Identity, Access, Preferences, and Security                              | Classify each route, view, class, key, and database artifact by actual owner and role                             |
| `Users`                   | Resource or `capability_key` commonly beneath Identity                                                           | Resource identity is not always owner identity                                                                  | Determine whether each occurrence is a resource, capability key, route family, table, UI label, or legacy package |
| `Roles`                   | Resource or `capability_key` commonly beneath Access                                                             | Roles may appear in routes, permissions, data, UI, and current package names                                    | Classify each occurrence and preserve Access ownership boundaries                                                 |
| `Logging`                 | Legacy implementation term that may map to Audit, Monitoring, operational logging, or infrastructure integration | Audit evidence and operational logs have different ownership, retention, security, and reliability requirements | Classify by purpose, data contract, consumer, and lifecycle                                                       |
| `Administration`          | Surface, invocation context, navigation grouping, or capability key                                              | Administrative presentation often composes several owners                                                       | Classify presentation, routes, behavior, data, and navigation independently                                       |
| `GlobalAdministration`    | Cross-owner administrative context unless a distinct owner is proven                                             | A context label does not create a Core capability or generic owner                                              | Resolve the later global-administration tooling owner and namespace without defaulting to `Platform`              |
| `Registries`              | Host-owned Registry responsibilities                                                                             | Centralizing by artifact type would transfer ownership from Hosts                                               | Identify each Host, extension family, and Contribution contract                                                   |
| `ApplicationRegistration` | Architecture mechanism and Laravel integration concern                                                           | Mechanism identity does not automatically prove a direct Core owner                                             | Confirm durable architecture owner, integration placement, and public Contracts before any move                   |

## 9. Rejected Alternatives Are Not Aliases

| Rejected or invalid form                                                                    | Phase 5 treatment                                                                                                                  |
| ------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| `ParaSolutions\Login\<Module>\`                                                             | Rejected namespace proposal; do not implement compatibility unless verified repository or external consumers actually depend on it |
| `parasolutions/login-<module-slug>`                                                         | Rejected package proposal; not a migration obligation without evidence                                                             |
| `Modules/<Module>Module/`                                                                   | Invalid new folder form; not an alias by default                                                                                   |
| `module_<module_key>` or `business_<module_key>`                                            | Invalid Module key forms; reject rather than silently normalize                                                                    |
| Generic `Common`, `Shared`, `Helpers`, `Services`, `Managers`, or `Platform` target folders | Prohibited new destinations; current occurrences require classification, not blanket preservation                                  |
| Mechanically singularized or pluralized accepted owner names                                | Cosmetic alternative only; no alias unless an external or persisted reference requires it                                          |

A design alternative considered during Phase 5 does not become a compatibility obligation merely because it appeared in working notes or an earlier draft.

## 10. Open Decisions And Later Authority

| Decision                                               | Owner                                | Required before implementation                                                                                                                                                |
| ------------------------------------------------------ | ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Exact legacy artifact inventory                        | Phase 7 and bounded migration issues | Read source, consumers, tests, persistence, configuration, routes, packages, generated state, and external references                                                         |
| Compatibility mechanism type                           | Applicable implementation owner      | Choose class alias, autoload bridge, route alias, redirect, config fallback, dual reader, data migration, documentation pointer, or no compatibility based on verified impact |
| Compatibility lifetime                                 | Repository owner and affected owner  | Define objective removal condition and whether a permanent external constraint exists                                                                                         |
| Global-administration terminology and target namespace | Later architecture decision          | Must not be inferred from `Platform`, `Administration`, or current presentation grouping                                                                                      |
| Database compatibility                                 | Goal 6                               | Phase 5 records boundary only                                                                                                                                                 |
| Package release and versioning compatibility           | Later Module packaging work          | Must include Composer constraints and consumer migration                                                                                                                      |

## 11. Maintenance Notes

- Add an exact mapping only after the legacy value and canonical target are verified.
- Keep `legacy name`, `canonical name`, identifier family, and compatibility surface distinct.
- Do not record a row as implemented because the target naming rule is accepted.
- Do not use synthetic reviewer or owner identities.
- Every transitional mapping requires a tracking issue, proof, objective removal condition, and migration owner before implementation.
- Permanent compatibility requires an exact external, vendor, protocol, public API, or persisted-data constraint plus repository-owner acceptance.
- If a machine-readable registry is later required, accept one canonical structured source and generate or summarize this Markdown register rather than maintaining independent copies.

## 12. Related

- [Phase 5 Naming Conventions Index](index.md)
- [Naming Convention Matrix](naming-convention-matrix.md)
- [Role Terminology Matrix](role-terminology-matrix.md)
- [Module Identity Matrix](module-identity-matrix.md)
- [Durable Promotion Register](durable-promotion-register.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
