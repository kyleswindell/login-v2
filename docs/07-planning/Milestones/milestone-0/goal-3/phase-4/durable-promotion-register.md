<!--
DOC-META
title: Phase 4 Durable Promotion Register
doc_type: matrix
status: draft
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/durable-promotion-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Routes every durable Phase 4 placement, dependency, communication, registration, documentation, definition, agent-guidance, and enforcement result to its long-term owner.
-->

# Phase 4 Durable Promotion Register

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Register For](#3-use-this-register-for)
- [4. Do Not Use This Register For](#4-do-not-use-this-register-for)
- [5. Authoritative Source Inputs](#5-authoritative-source-inputs)
- [6. Controlled Values](#6-controlled-values)
- [7. Promotion Register](#7-promotion-register)
  - [7.1. Architecture](#71-architecture)
  - [7.2. Coding Standards](#72-coding-standards)
  - [7.3. Documentation And Agent Standards](#73-documentation-and-agent-standards)
  - [7.4. Database Standards](#74-database-standards)
  - [7.5. Reusable Definitions](#75-reusable-definitions)
  - [7.6. Agent Guidance](#76-agent-guidance)
  - [7.7. Future Enforcement](#77-future-enforcement)
- [8. Promotion Sequence](#8-promotion-sequence)
- [9. Closeout Interpretation](#9-closeout-interpretation)
- [10. Update Triggers And Maintenance](#10-update-triggers-and-maintenance)
- [11. Related](#11-related)

## 1. Purpose

This register identifies every accepted Phase 4 result that must remain available after the Goal 3 planning package is no longer the primary implementation source.

Each row records:

- the smallest durable truth;
- its long-term owner;
- whether to create, amend, replace, or defer;
- current alignment;
- sequencing dependencies;
- required verification;
- whether Phase 4 promotes it now or queues later work.

## 2. Status

- Document status: draft
- Review state: agent-proposed consolidation; repository-owner acceptance pending
- Source-decision state: Decisions 4.1 through 4.12 accepted
- Implementation state: no production implementation claimed
- Owning GitHub issue: #51
- Promotion completion: mixed; see row disposition
- Definition package: prepared; repository application and validation unverified
- Durable architecture promotion package: prepared; repository application and validation unverified
- Consolidation blocker: none found

## 3. Use This Register For

Use this register to:

- prevent accepted Phase 4 rules from remaining only in planning;
- sequence architecture, standard, definition, and agent-guidance updates;
- distinguish durable documentation promotion from implementation work;
- identify existing documents that conflict with the accepted target;
- identify indexes that must route to new or amended owners;
- preserve unexecuted validation and enforcement limitations;
- prepare bounded later issues without inventing implementation scope.

## 4. Do Not Use This Register For

Do not use this register to:

- mark a promotion complete before the repository file is applied and validated;
- claim an architecture test, compiler, manifest, build, or CI check exists;
- replace the destination architecture or standard;
- introduce detailed schema, route, class, descriptor, or manifest naming;
- create implicit owner acceptance;
- authorize broad cleanup outside the exact promotion row;
- convert queued enforcement into implementation permission.

## 5. Authoritative Source Inputs

| Key | Source |
| --- | --- |
| P3 | [Accepted Phase 3 target repository architecture](../target-repository-architecture.md) |
| P4.1 | [Decision 4.1 — Contract Placement](4-1-contract-placement.md) |
| P4.2 | [Decision 4.2 — Implementation Placement](4-2-implementation-placement.md) |
| P4.3 | [Decision 4.3 — Delivery Adapter Placement](4-3-delivery-adapter-placement.md) |
| P4.4 | [Decision 4.4 — Route Placement And Registration](4-4-route-placement-and-registration.md) |
| P4.5 | [Decision 4.5 — Configuration Placement](4-5-configuration-placement.md) |
| P4.6 | [Decision 4.6 — Database And Migration Placement](4-6-database-and-migration-placement.md) |
| P4.7 | [Decision 4.7 — View And Asset Placement](4-7-view-and-asset-placement.md) |
| P4.8 | [Decision 4.8 — Test Placement](4-8-test-placement.md) |
| P4.9 | [Decision 4.9 — Documentation Placement](4-9-documentation-placement.md) |
| P4.10 | [Decision 4.10 — Dependency Direction](4-10-dependency-direction.md) |
| P4.11 | [Decision 4.11 — Cross-Owner Communication](4-11-cross-owner-communication.md) |
| P4.12 | [Decision 4.12 — Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md) |
| MATRIX-P | [Artifact Placement Matrix](artifact-placement-matrix.md) |
| DEF-ACT | [Action Definition](../../../../Definitions/Actions/Definition.md) |
| DEF-QUERY | [Query Definition](../../../../Definitions/Queries/Definition.md) |
| DEF-CONTRACT | [Contract Definition](../../../../Definitions/Contracts/Definition.md) |
| DEF-DATA | [Data Object Definition](../../../../Definitions/Data-Objects/Definition.md) |
| DEF-EVENT | [Event Definition](../../../../Definitions/Events/Definition.md) |
| DEF-LISTENER | [Listener Definition](../../../../Definitions/Listeners/Definition.md) |
| DEF-JOB | [Job Definition](../../../../Definitions/Jobs/Definition.md) |
| DEF-PROVIDER | [Provider Definition](../../../../Definitions/Providers/Definition.md) |
| DEF-DELIVERY | [Delivery Adapter Definition](../../../../Definitions/Delivery-Adapters/Definition.md) |
| DEF-HOST | [Host Definition](../../../../Definitions/Hosts/Definition.md) |
| DEF-REGISTRY | [Registry Definition](../../../../Definitions/Registries/Definition.md) |
| DEF-EXT | [Extension Point Definition](../../../../Definitions/Extension-Points/Definition.md) |
| DEF-CONTRIB | [Contribution Definition](../../../../Definitions/Contributions/Definition.md) |
| DEF-CONTRIBUTOR | [Contributor Definition](../../../../Definitions/Contributors/Definition.md) |
| DEF-REGISTER | [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md) |

Current-state classifications for existing standards are based on their current repository content and may change before application. Repository truth must be rechecked immediately before writable promotion work.

## 6. Controlled Values

### 6.1. Type

| Value | Meaning |
| --- | --- |
| architecture | Long-lived structure, ownership, dependency, or composition truth |
| standard | Enforceable coding, documentation, database, or review rule |
| definition | Reusable concept meaning and boundary |
| agent guidance | Scoped execution and retrieval guidance that routes to canonical truth |
| future enforcement | Later static, build, CI, compiler, or verification implementation |

### 6.2. Change

| Value | Meaning |
| --- | --- |
| create | The durable destination does not yet exist |
| amend | The destination is broadly compatible but incomplete |
| replace | A section or rule conflicts materially with the accepted target |
| no change | The destination already owns the complete durable truth |

### 6.3. Current State

| Value | Meaning |
| --- | --- |
| missing | The durable truth is absent |
| partial | The destination contains compatible but incomplete material |
| conflicting | Current wording or paths conflict with accepted Phase 4 direction |
| aligned | No promotion change is required |
| prepared | A drop-in update exists, but repository application and validation are unverified |

### 6.4. Disposition

| Value | Meaning |
| --- | --- |
| promote during Phase 4 closeout | Include in the same accepted documentation work before Issue #51 final acceptance |
| promote after owner review | Apply only after the repository owner accepts the proposed durable wording |
| apply Phase 4 definition package | Apply the already prepared definition drop-in package |
| apply Phase 4 architecture closeout package | Apply the prepared architecture and planning promotion package after owner review |
| queue after canonical promotion | Update agent guidance only after canonical architecture or standards exist |
| queue for later implementation | Record the requirement without implementing or claiming it |
| queue for later promotion and implementation | A durable standard and later tooling are both still required |

## 7. Promotion Register

### 7.1. Architecture

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-ARCH-01 | P4.1–P4.9; MATRIX-P | Every artifact remains with the narrowest explicit owner of its promise, behavior, state, delivery, presentation, or extension responsibility. | architecture | `docs/03-architecture/repository-architecture.md` | Owner-first artifact placement | amend | prepared | apply Phase 4 architecture closeout package | none | documentation guardrails; terminology scan; owner review | Use the artifact-placement matrix as the detailed planning trace. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-02 | P3; P4.2–P4.6 | Root Laravel and repository support branches are restricted integration or composition locations, not default feature owners. | architecture | `docs/03-architecture/repository-architecture.md` | Restricted application integration branches | amend | prepared | apply Phase 4 architecture closeout package | none | path review; prohibited-root terminology scan | Preserve existing accepted root branch list. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-03 | P4.4; DEF-REGISTER | Application registration uses owner descriptors, deterministic compilation, a generated manifest, one root registrar, and bounded typed registrars. | architecture | `docs/03-architecture/application-registration.md` | Complete document | create | prepared | apply Phase 4 architecture closeout package | Phase 5 naming for exact identifiers | architecture review; link validation | Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-04 | P4.4; DEF-REGISTER | The repository architecture summary must route to the Application Registration System without duplicating its complete contract. | architecture | `docs/03-architecture/repository-architecture.md` | Application registration summary | amend | prepared | apply Phase 4 architecture closeout package | P4-ARCH-03 | link validation; duplicate-authority review | Summary and dependency direction only. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-05 | P4.10; P4.11 | Dependencies flow toward provider-owned public boundaries; Core remains independent of optional Modules; Module dependencies are explicit and acyclic. | architecture | `docs/03-architecture/repository-architecture.md` | Dependency direction | amend | prepared | apply Phase 4 architecture closeout package | none | matrix traceability review; architecture review | Use the dependency matrix as structured support. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-06 | P4.11 | Synchronous Contracts, Query Contracts, Events, Jobs, Delivery Adapters, and Host Contributions are selected by interaction need and failure semantics. | architecture | `docs/03-architecture/repository-architecture.md` | Cross-owner communication | amend | prepared | apply Phase 4 architecture closeout package | none | communication matrix traceability review | Detailed enforceable coding rules remain standards-owned. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-07 | P4.1; P4.2; P4.11 | Hosts own Registry and Extension Point Contracts; Contributors retain Contributions; registration may route declarations without becoming the Registry. | architecture | `docs/03-architecture/repository-architecture.md` | Host, Registry, and Contribution boundaries | amend | prepared | apply Phase 4 architecture closeout package | none | ADR consistency review; terminology scan | Must remain consistent with ADR-0007. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-08 | P4.7 | Presentation follows its behavior or reusable-UI owner, and Vite composition is explicit, deterministic, ordered, and complete. | architecture | `docs/03-architecture/repository-architecture.md` | Presentation and asset composition | amend | prepared | apply Phase 4 architecture closeout package | Phase 5 asset naming | asset topology review; owner review | Do not promote exact generated import format yet. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-09 | P4.8 | Tests live with the smallest owner or artifact, while root tests own cross-owner, system, browser, architecture, and repository proof. | architecture | `docs/03-architecture/repository-architecture.md` | Test topology | amend | prepared | apply Phase 4 architecture closeout package | Phase 5 suite naming | test-topology review | Complete verification architecture remains separate. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-10 | P4.12 | Architecture exceptions are explicit, bounded, owner-accepted, nonprecedential, and stop execution on undeclared mandatory failures. | architecture | `docs/03-architecture/repository-architecture.md` | Architecture exceptions | amend | prepared | apply Phase 4 architecture closeout package | none | owner review; documentation guardrails | Detailed exception record may later receive a dedicated standard. Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-11 | P4-ARCH-03 | The architecture index must route readers to the Application Registration System document. | architecture | `docs/03-architecture/index.md` | Documents and related architecture | amend | prepared | apply Phase 4 architecture closeout package | P4-ARCH-03 | link validation | Prepared with the new Application Registration architecture document; repository application and validation remain unverified. |
| P4-ARCH-12 | P4.4; P4.10; P4.11 | The system overview routes high-level application composition and cross-owner communication to the detailed architecture owners. | architecture | `docs/03-architecture/system-overview.md` | Application ownership; repository architecture | amend | prepared | apply Phase 4 architecture closeout package | P4-ARCH-03; P4-ARCH-05; P4-ARCH-06 | architecture review; link validation | Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |
| P4-ARCH-13 | P4.4; P4.7; DEF-REGISTER | The stack overview distinguishes Laravel and Vite native responsibilities from deterministic owner registration and composition. | architecture | `docs/03-architecture/stack-overview.md` | Application framework; frontend build; stack boundaries | amend | prepared | apply Phase 4 architecture closeout package | P4-ARCH-03 | architecture review; link validation | Prepared in the Phase 4 architecture promotion package; repository application and validation remain unverified. |

### 7.2. Coding Standards

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-CODE-01 | P4.1; P4.10; P4.11; DEF-ACT; DEF-QUERY; DEF-CONTRACT; DEF-DATA | Cross-owner immediate commands and reads use provider-owned public Contracts and provider-owned boundary Data Objects. | standard | `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md` | Core rule; Actions; Query objects; DTOs; outputs and error behavior | amend | conflicting | promote after owner review | Phase 5 naming | coding-standard review; terminology scan | Current file still uses broad Service and Platform examples. |
| P4-CODE-02 | P4.2; P4.10 | Generic Services are not a default Technical Role or ownership root; cohesive behavior must use an accepted named owner responsibility. | standard | `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md` | Services and placement | replace | conflicting | promote after owner review | Phase 5 Technical Role naming | targeted stale-term scan; owner review | Do not preserve vague `application service` terminology. |
| P4-CODE-03 | P4.11; DEF-EVENT; DEF-LISTENER | Events announce completed facts to independent consumers; Listeners do not hide required publisher mutations or results. | standard | `docs/02-standards/coding/Events Jobs And Queue Standards.md` | Core rule; Events; Listeners | amend | partial | promote after owner review | none | coding-standard review; event examples review | Existing standard is broadly aligned. |
| P4-CODE-04 | P4.11; DEF-JOB | Jobs represent deliberately deferred, retryable, scheduled, or isolated work and must not hide an immediate dependency. | standard | `docs/02-standards/coding/Events Jobs And Queue Standards.md` | Core rule; Jobs; Scheduling | amend | partial | promote after owner review | none | coding-standard review; queue tests later | Existing standard already rejects queues used only to avoid explicit dependencies. |
| P4-CODE-05 | P4.3; P4.10; DEF-DELIVERY | Delivery Adapters own channel translation only and depend inward on owner behavior; owner behavior never depends on adapters. | standard | `docs/02-standards/coding/File Building Standards.md` | Controllers; middleware; commands; views; Delivery Adapter boundary | amend | conflicting | promote after owner review | Phase 5 role naming | coding-standard review; stale Platform path scan | Current standard uses controller/service wording and transitional Platform placement. |
| P4-CODE-06 | P4.4; DEF-PROVIDER; DEF-REGISTER | Providers execute bounded validated registration; descriptors, compiler, manifest, and registrars retain distinct responsibilities. | standard | `docs/02-standards/coding/File Building Standards.md` | Providers and application registration | amend | missing | promote after architecture promotion | P4-ARCH-03; Phase 5 naming | coding-standard review; link validation | May require a new section. |
| P4-CODE-07 | P4.5 | Environment variables are read through configuration; runtime Tenant/User settings remain owner-controlled data rather than Laravel configuration. | standard | `docs/02-standards/coding/PHP And Laravel Style Standards.md` | Configuration and environment access | amend | partial | promote after owner review | none | targeted `env(` usage review; coding-standard review | Exact key names remain Phase 5. |
| P4-CODE-08 | P4.1–P4.9; MATRIX-P | File construction begins by identifying owner, artifact family, target role, registration, tests, and canonical documentation. | standard | `docs/02-standards/coding/File Building Standards.md` | Core rule; application structure; file responsibility | replace | conflicting | promote after owner review | Phase 5 naming | artifact-matrix traceability; stale path scan | Replace transitional Platform and root-test defaults with accepted topology. |
| P4-CODE-09 | P4.7 | Owner CSS and JavaScript bundles are declared exactly once through deterministic ordered Vite composition; uncontrolled globs are prohibited. | standard | `docs/02-standards/coding/File Building Standards.md` | CSS; JavaScript; assets | amend | partial | promote after architecture promotion | P4-ARCH-03; Phase 5 asset naming | Vite build validation later; coding-standard review | Do not define generated-file implementation yet. |
| P4-CODE-10 | P4.8 | Accepted owner-local, artifact-local, package-local, and root test locations must all be discovered locally and in CI without duplication or production loading. | standard | `docs/02-standards/coding/File Building Standards.md` | Tests | amend | conflicting | promote after owner review | Phase 5 suite naming; verification architecture | test-discovery proof later; coding-standard review | Current standard presents root tests as the broad default. |
| P4-CODE-11 | P4-CODE-01–10 | The coding standards index must route to amended application-object, event/job, file-building, and PHP/Laravel standards. | standard | `docs/02-standards/coding/index.md` | Standards routing | amend | partial | promote with coding-standard updates | dependent standard updates | link validation | Index-only routing and descriptions. |

### 7.3. Documentation And Agent Standards

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-DOC-01 | P4.9 | Meaningful repository folders default to a `README.md`, `index.md`, and `AGENTS.md` package with distinct purposes. | standard | `docs/02-standards/documentation/Doc Governance.md` | Folder-level documentation package | amend | partial | promote after owner review | none | documentation guardrails; owner review | Default is intentionally non-universal. |
| P4-DOC-02 | P4.9 | Folder-package omissions are allowed when deep standardized contents, inherited guidance, generation, redundancy, or deliberate exclusion make a file unnecessary. | standard | `docs/02-standards/documentation/Doc Governance.md` | Permitted folder-documentation omissions | amend | missing | promote with P4-DOC-01 | P4-DOC-01 | documentation guardrails | Omissions must not leave ownership, navigation, or execution ambiguous. |
| P4-DOC-03 | P4.9 | Canonical documentation routing is explicit through metadata, parent indexes, README routing, and scoped agent-guidance inheritance. | standard | `docs/02-standards/documentation/Doc Governance.md` | Routing and inheritance | amend | partial | promote after owner review | none | link validation; metadata validation | Avoid unrestricted Markdown discovery. |
| P4-DOC-04 | P4.9 | Scoped `AGENTS.md` files contain execution guidance and canonical routing, not duplicated architecture or standards prose. | standard | `docs/02-standards/coding-agents/Agent Instruction Surface And Skill Authoring Standards.md` | Folder-level AGENTS scope and inheritance | amend | partial | promote after owner review | P4-DOC-01 | agent-guidance review; conflict scan | Preserve deliberate omission option. |
| P4-DOC-05 | P4-DOC-01–04 | Documentation and coding-agent indexes must route to the amended folder documentation and AGENTS requirements. | standard | `docs/02-standards/documentation/index.md`; `docs/02-standards/coding-agents/index.md` | Standards routing | amend | partial | promote with standard updates | dependent standard updates | link validation | Index-only routing and descriptions. |

### 7.4. Database Standards

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-DB-01 | P4.6 | Runtime persistence implementation remains owner-local while schema-lifecycle files use owner-grouped Core database paths or package-local Module database paths. | standard | `docs/02-standards/coding/File Building Standards.md` | Models; migrations; factories; seeders | replace | conflicting | promote after owner review | Phase 5 naming | path review; coding-standard review | Detailed schema design remains Goal 6. |
| P4-DB-02 | P4.6 | Human-readable schema and table Contracts remain in `docs/06-database/` and do not replace executable migrations. | standard | `docs/02-standards/database/Database Table Contract Standards.md` | Ownership and migration relationship | amend | partial | promote after owner review | Goal 6 | database-standard review; link validation | No table-level design is introduced by Phase 4. |

### 7.5. Reusable Definitions

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-DEF-01 | DEF-ACT | Action definition includes synchronous cross-owner Contract use and owner-local target placement. | definition | `docs/07-planning/Definitions/Actions/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-02 | DEF-QUERY | Query definition includes public Query Contract use and prohibits cross-owner persistence access. | definition | `docs/07-planning/Definitions/Queries/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-03 | DEF-CONTRACT | Contract definition distinguishes public boundaries from internal abstractions and makes the provider owner of compatibility. | definition | `docs/07-planning/Definitions/Contracts/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-04 | DEF-DATA | Data Object definition makes cross-owner values provider-owned parts of public Contracts. | definition | `docs/07-planning/Definitions/Data-Objects/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-05 | DEF-EVENT | Event definition distinguishes completed facts from commands requiring synchronous results. | definition | `docs/07-planning/Definitions/Events/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-06 | DEF-LISTENER | Listener definition requires independent reaction ownership and prohibits hidden publisher success dependencies. | definition | `docs/07-planning/Definitions/Listeners/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-07 | DEF-JOB | Job definition limits Jobs to deliberately deferred work and prohibits hidden immediate dependencies. | definition | `docs/07-planning/Definitions/Jobs/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-08 | DEF-PROVIDER | Provider definition separates owner-local registration, root composition, descriptors, compiler, and manifest. | definition | `docs/07-planning/Definitions/Providers/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-09 | DEF-DELIVERY | Delivery Adapter definition includes owner-local placement, restricted root integration, and inward dependencies. | definition | `docs/07-planning/Definitions/Delivery-Adapters/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | HTTP and Console specialization updates are included separately. |
| P4-DEF-10 | P4.3 | HTTP Delivery Adapter definition records owner-local target paths and restricted root HTTP integration. | definition | `docs/07-planning/Definitions/HTTP-Delivery-Adapters/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-11 | P4.3 | Console Delivery Adapter definition records owner-local target paths and restricted root Console integration. | definition | `docs/07-planning/Definitions/Console-Delivery-Adapters/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-12 | DEF-REGISTRY | Registry definition separates Host entry authority from application registration and filesystem discovery. | definition | `docs/07-planning/Definitions/Registries/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-13 | DEF-CONTRIB | Contribution definition reserves `Contrib/<Host>/` for explicit Host Extension Points and allows descriptor-based declaration routing. | definition | `docs/07-planning/Definitions/Contributions/Definition.md` | Complete definition | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-14 | DEF-REGISTER | The Application Registration System receives one reusable architecture definition. | definition | `docs/07-planning/Definitions/Application-Registration/Definition.md` | Complete definition | create | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |
| P4-DEF-15 | P4-DEF-01–14 | The Definitions Index routes all synchronized definitions and the new Application Registration definition. | definition | `docs/07-planning/Definitions/Index.md` | Documents and subfolders | amend | prepared | apply Phase 4 definition package | repository application unverified | documentation guardrails; link validation | Prepared in the prior definition drop-in package. |

### 7.6. Agent Guidance

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-AGENT-01 | P4-ARCH-01–10; P4-CODE-01–10 | Root agent guidance must route writable work to the accepted architecture, placement matrix, dependency matrix, and promoted standards. | agent guidance | `AGENTS.md` | Architecture boundaries; implementation rules; required reading | amend | partial | queue after canonical promotion | architecture and standards promotion | agent-guidance review; link validation | Do not copy full canonical rules into AGENTS. |
| P4-AGENT-02 | P4-DOC-01–04 | Planning and documentation AGENTS files must route to folder-package and matrix rules without becoming canonical architecture owners. | agent guidance | `docs/AGENTS.md`; `docs/07-planning/AGENTS.md` | Read order; planning authoring; folder guidance | amend | partial | queue after documentation-standard promotion | P4-DOC-01–04 | agent-guidance review; link validation | Keep retrieval guidance concise. |

### 7.7. Future Enforcement

| Promotion ID | Source | Durable truth | Type | Canonical destination | Target section | Change | Current state | Disposition | Dependency | Verification | Notes |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| P4-ENF-01 | P4.2; P4.12; MATRIX-P | Prohibited and transitional target paths require static enforcement. | future enforcement | Future repository architecture-test implementation | Path allowlist and prohibited-root checks | create | missing | queue for later implementation | Phase 5 names; accepted implementation issue | exact command, OS/runtime, exit code, and output hash when implemented | No implementation or pass claim in Phase 4. |
| P4-ENF-02 | P4.10; P4.11 | Cross-owner imports must target permitted public Contracts and preserve Core independence from optional Modules. | future enforcement | Future repository architecture-test implementation | Dependency direction and Core/Module import checks | create | missing | queue for later implementation | Phase 5 namespaces; accepted implementation issue | architecture-test proof when implemented | Include UI and Delivery Adapter direction checks. |
| P4-ENF-03 | P4.4; P4.12; DEF-REGISTER | Owner descriptors, dependency ordering, duplicate detection, and generated manifest staleness require deterministic compiler validation. | future enforcement | Future Application Registration System implementation | Compiler, schema, manifest, and typed registrar validation | create | missing | queue for later implementation | P4-ARCH-03; Phase 5 naming; accepted implementation issue | native runtime command and report hash when implemented | Do not replace Laravel or Vite native validation. |
| P4-ENF-04 | P4.4; P4.7 | Duplicate route names, view namespaces, Livewire aliases, configuration keys, and asset entries must fail validation. | future enforcement | Future Application Registration System implementation | Typed duplicate and conflict validation | create | missing | queue for later implementation | P4-ENF-03 | targeted fixtures and unchanged failing/passing proofs | Missing required resources must also fail. |
| P4-ENF-05 | P4.7 | Every declared canonical asset must be included exactly once in deterministic order. | future enforcement | Future asset-registration and Vite validation implementation | Asset declaration, import, duplicate, and stale-output checks | create | missing | queue for later implementation | Phase 5 asset naming; P4-ENF-03 | Vite build and targeted manifest tests when implemented | Uncontrolled glob discovery remains prohibited. |
| P4-ENF-06 | P4.8 | Every accepted test location must be discovered locally and in CI without omission, duplication, or production loading. | future enforcement | Future verification-architecture implementation | Test discovery and production-autoload checks | create | missing | queue for later implementation | Phase 5 suite naming; verification architecture | unchanged discovery command locally and in CI | Physical test movement remains separately gated. |
| P4-ENF-07 | P4.9; P4.12 | Significant folders must contain the applicable README, index, and AGENTS package or a reviewable accepted omission. | future enforcement | Future documentation guardrail implementation | Folder-package and omission validation | create | missing | queue for later implementation | P4-DOC-01–04; Phase 5 naming | documentation guardrail command and fixtures | Do not require empty files in deep standardized folders. |
| P4-ENF-08 | P4.12 | Architecture exceptions require a structured record and exact scope before they can suppress a mandatory rule. | future enforcement | Future architecture exception standard and validation | Exception-record schema and scope validation | create | missing | queue for later promotion and implementation | owner acceptance; future standard | manual owner review plus static validation when implemented | Unexpected failure never creates an implicit exception. |

## 8. Promotion Sequence

Use this order:

1. obtain repository-owner review of the consolidated matrices, promotion register, definition wording, and durable architecture wording;
2. apply and validate the synchronized Definitions package;
3. apply and validate the Phase 4 architecture closeout package, including Application Registration, Repository Architecture, System Overview, Stack Overview, Goal 3 synthesis, indexes, and Decision 4.11 terminology cleanup;
4. amend coding, documentation, coding-agent, and database standards only through their accepted later promotion scope;
5. update root and folder-level AGENTS routing only after canonical architecture and standards exist;
6. retain enforcement rows as unimplemented requirements until a separately accepted issue defines architecture, smallest vertical slice, native validation, and proof.

A failed promotion validation is not authorization to weaken the accepted Phase 4 rule.

## 9. Closeout Interpretation

The register itself is complete when:

- every Decision 4.1 through 4.12 has at least one applicable promotion or explicit no-change disposition;
- every durable result has one primary destination;
- conflicting existing standards are identified;
- definition updates are distinguished from repository application;
- agent-guidance updates follow canonical promotion;
- future enforcement remains unimplemented and unclaimed;
- no row leaves a generic `TBD`.

Completing this register does not mean every queued promotion or enforcement item has been executed. A `prepared` row means a drop-in file exists but has not been proven applied or validated in the repository.

Issue #51 final acceptance must use the accepted closeout scope and repository-owner direction to decide which durable document updates are mandatory before closure and which are formally handed off.

## 10. Update Triggers And Maintenance

Update this register when:

- a destination file is applied and validated;
- repository-owner review changes a proposed durable destination;
- Phase 5 accepts final naming that affects target sections;
- a later issue accepts implementation of an enforcement row;
- an existing destination is renamed or superseded;
- Phase 6 representative validation identifies a missing promotion.

When a promotion is completed:

- change `prepared`, `missing`, `partial`, or `conflicting` to the verified state;
- record the exact validation in the issue or pull request evidence;
- preserve queued implementation limitations;
- update indexes and source links;
- do not attribute repository-owner acceptance without explicit owner action.

## 11. Related

- [Phase 4 Index](index.md)
- [Artifact Placement Matrix](artifact-placement-matrix.md)
- [Dependency And Communication Matrix](dependency-and-communication-matrix.md)
- [Definitions Index](../../../../Definitions/Index.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
- [Application Registration](../../../../../03-architecture/application-registration.md)
- Related GitHub issue: #51
