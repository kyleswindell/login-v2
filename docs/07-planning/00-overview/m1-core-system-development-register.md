<!--
DOC-META
title: M1 Core System Development Register
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/00-overview/m1-core-system-development-register.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the M1 system-design scope, classifications, first-order dependencies, cross-system workflows, intentional deferrals, serial design method, and repeatable system-development specification contract used before implementation.
-->

# M1 Core System Development Register

Parent: [Planning Index](../index.md)

## 1. Purpose

Define the system-development planning model for M1.

M1 designs the foundational systems of Login 2.0 as implementation-ready specifications before production implementation begins.

The milestone starts from accepted M0 architecture, standards, ownership, interaction, persistence, naming, and verification rules. It does **not** treat the current pre-alpha implementation as the target system to migrate forward.

Current implementation may be reviewed later as reference evidence for useful behavior, edge cases, tests, and constraints. It must not dictate M1 target architecture, system boundaries, data ownership, public Contracts, or implementation decomposition.

This register establishes:

1. the systems within M1 design scope;
2. their classifications;
3. one primary responsibility per system;
4. first-order provider/consumer dependencies;
5. major cross-system workflows;
6. intentional deferrals beyond M1;
7. the serial system-design method;
8. the repeatable system-development document structure;
9. promotion from planning into canonical documentation and later implementation work.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted M1 planning control document
- Current implementation state: pre-alpha and reference-only for M1 target design
- M0 state: accepted and complete
- Owning GitHub issue: not yet created
- GitHub Project: Login 2.0 Core Build Plan
- M1 implementation issues: none
- Working system-design progression: accepted for M1 design steering only
- Accepted system designs: Core Runtime; Core Users
- Next system-design target: Security

Known gaps:

- the remaining M1 systems do not yet have accepted system-development specifications;
- first-order dependencies may be refined as later systems expose real interaction requirements;
- older planning contains superseded ownership, migration, and placement terminology;
- actual production implementation and verification order remains intentionally unresolved until the full M1 system-design set is complete.

This document is planning authority, not an active delivery-state board.

## 3. M1 Goal

Design the Core systems of Login 2.0 one system at a time so later implementation work can proceed from accepted specifications rather than rediscovering behavior or inventing cross-owner boundaries during coding.

Each completed system design should define applicable:

- responsibility and non-responsibility;
- concepts and vocabulary;
- state and lifecycle;
- public Contracts;
- provider/consumer dependencies;
- Events and deferred work;
- persistent-data requirements;
- security and authorization;
- Audit, Monitoring, and Notification behavior;
- Settings, Preferences, and configuration;
- delivery and registration requirements;
- failure, transaction, concurrency, and reliability behavior;
- verification requirements;
- future implementation decomposition.

## 4. Scope

### 4.1 In Scope

- foundation infrastructure required by Core systems;
- required Core capabilities;
- foundational Core subcapabilities;
- first-order cross-system dependencies;
- major cross-system workflows;
- public Contract requirements;
- system-owned state and lifecycle;
- conceptual persistence requirements;
- security and evidence requirements;
- delivery and registration requirements;
- reliability requirements;
- verification requirements;
- future implementation decomposition;
- canonical documentation promotion.

### 4.2 Non-Goals

M1 does not:

- implement production application code;
- migrate the current implementation architecture;
- treat current source paths as target authority;
- perform source moves or namespace migration;
- write database migrations;
- keep exact schema truth only in planning;
- create optional business Modules;
- build customer/public products;
- implement Global Administration or multi-Instance provisioning;
- implement NHI or Service Accounts before their owner is accepted;
- build security-operations tooling merely because planning exists;
- redesign reusable UI accepted by M0;
- replace GitHub issues as future executable implementation packets;
- replace GitHub Projects as delivery-state authority.

### 4.3 Supporting Owners Outside This Register

M1 consumes but does not redesign as Core systems:

- reusable UI;
- restricted Laravel integration;
- PostgreSQL and Laravel framework behavior;
- documentation governance;
- testing and verification policy;
- future optional Modules.

## 5. Governing Authority

Primary M0 authority:

- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [Application Registration](../../03-architecture/application-registration.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Repository Naming Standards](../../02-standards/coding/repository-naming-standards.md)
- [Testing Standards](../../02-standards/testing/index.md)
- [Agent Implementation Checklist](../../02-standards/coding/Agent%20Implementation%20Checklist.md)
- [M0 Repository Convergence Planning](m0-repository-convergence-planning.md)

Planning inputs:

- [Core Service Build Plan Matrix](../core-service-build-plan-matrix.md)
- existing capability and subsystem planning documents.

Planning inputs do not override later accepted canonical architecture or current repository-owner direction.

## 6. M1 Design Rules

### 6.1 Target First

Design from accepted architecture, standards, product intent, and system interactions.

Do not begin system design from current:

- classes;
- folders;
- tables;
- routes;
- package boundaries;
- Services;
- tests.

Review current implementation only after target design is coherent enough to avoid accidental migration-driven design.

### 6.2 Serial Design

Design one system at a time.

After each system:

1. review provider and consumer relationships;
2. update this register when the cross-system model changes;
3. update earlier system plans when a newly discovered requirement belongs there;
4. promote durable truth;
5. accept the system plan before starting the next system.

### 6.3 One Primary Owner

Every responsibility, state transition, public promise, policy decision, and authoritative data concept has one primary owner.

Shared use does not create shared ownership.

### 6.4 Provider-Owned Contracts

Cross-owner consumers depend on provider-owned public Contracts, never provider internals.

Do not design cross-owner dependencies against:

- Models;
- tables;
- concrete Actions;
- concrete Services;
- query builders;
- internal projections;
- framework implementation details.

### 6.5 DRY By Ownership

Eliminate duplicated responsibility before implementation exists.

Do not create generic shared abstractions merely to reduce repeated words or anticipated future code.

A reusable abstraction requires:

- multiple concrete consumers;
- one clear provider;
- stable semantic meaning;
- no loss of domain ownership;
- compliance with accepted dependency direction.

### 6.6 Iterative Refinement

A later system may reveal that an earlier system needs a narrower or additional Contract, Event, lifecycle rule, rejection rule, or verification requirement.

Update the authoritative earlier design rather than creating a workaround in the later system.

## 7. Classification Model

| Classification                 | Meaning                                                                                                              |
| ------------------------------ | -------------------------------------------------------------------------------------------------------------------- |
| Foundation infrastructure      | Technical composition or invocation infrastructure that supports owners without becoming a product capability owner. |
| Core capability                | Required base-application system with one explicit owner and stable responsibility.                                  |
| Core subcapability             | Specialized responsibility beneath one accepted Core capability owner.                                               |
| Boundary-only M1 subcapability | Ownership and interaction boundary is reserved in M1; detailed behavior is intentionally deferred.                   |
| Deferred future system         | Known future concern intentionally outside detailed M1 design.                                                       |

## 8. M1 System Register

### 8.1 Foundation Infrastructure

| System                   | M1 Treatment | Primary Responsibility                                                                                                                                                            | First-Order Providers                                      | First-Order Consumers                                                                                   |
| ------------------------ | ------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- |
| Application Registration | Full design  | Validate, order, compile, and connect owner-controlled registration declarations to approved application integrations without taking ownership of registered behavior.            | owner registration declarations; owner/dependency metadata | Laravel/bootstrap integration; Core; Modules; UI; Host Registries                                       |
| Core Runtime             | Full design  | Provide the narrow technical invocation envelope and lifecycle used to identify, correlate, and trace approved invocation channels without becoming semantic application context. | Delivery Adapters; native invocation integrations          | Audit; Monitoring; Jobs; commands; events; APIs; webhooks; other owners requiring technical correlation |

### 8.2 Core Capabilities

| System         | M1 Treatment | Primary Responsibility                                                                                                                                                               | First-Order Providers                                                                                     | First-Order Consumers                                                           |
| -------------- | ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- |
| Users          | Full design  | Own human User Accounts, User Identity attributes, profile/contact data, invitations, and human-account lifecycle.                                                                   | Auth operations; Access; Audit; Notifications                                                             | Auth; Access; Security; Preferences; Workspace; Notifications; other human-user consumers |
| Auth           | Full design  | Own authentication credentials, methods, factors, challenges, recovery, sessions, authentication assurance, recent authentication, and step-up authentication.                       | Users; Security/Secrets; Audit; Notifications; Core Runtime                                               | Access; DataProtection; sensitive Core operations                               |
| Access         | Full design  | Own authorization policy, roles, permissions, groups, grants, assignments, effective-access evaluation, elevated access, and access review behavior.                                 | Users; Auth; Audit; Settings where applicable                                                             | all protected Core capabilities; Modules; Navigation; Workspace                 |
| Security       | Full design  | Own cross-cutting application-security guardrails and security-control enforcement without absorbing Auth, Access, DataProtection, Audit, or Monitoring ownership.                   | Settings; Core Runtime; security standards                                                                | Core; Modules; Delivery Adapters; release verification                          |
| Audit          | Full design  | Own append-oriented accountable evidence describing who or what performed meaningful actions and expose stable evidence/query Contracts.                                             | Core Runtime; provider-supplied Actor/subject/target data; DataProtection handling rules where applicable | all Audit-producing owners; evidence consumers; future Forensics                |
| Monitoring     | Full design  | Own operational failures, health observations, anomaly/health signal state, and evidence describing what broke or requires operational attention.                                    | Core Runtime; operational/error sources; applicable evidence                                              | Notifications; operations; future Threat Detection                              |
| Notifications  | Full design  | Own durable notification definitions, delivery state, inbox/read/dismiss lifecycle, required-delivery behavior, and channel-delivery infrastructure.                                 | Users; Access for protected actions; owner notification declarations                                      | all Core and Module producers; notification UI                                  |
| Settings       | Full design  | Provide settings registration, storage, retrieval, validation, and presentation infrastructure while contributors retain semantic ownership of the behavior their Settings control.  | Application Registration; Access; owner declarations                                                      | Core and Modules with functional configuration                                  |
| Preferences    | Full design  | Own private User Account choices that affect only that user's rendered application experience.                                                                                       | Users                                                                                                     | Workspace; UI composition; account surfaces                                     |
| Workspace      | Full design  | Resolve the authenticated user's top-level application experience and applicable Product set without becoming a persistence, Tenant-isolation, or authorization scope.               | Users; Preferences; Access; applicable availability Contracts                                             | Navigation; Dashboard; persistent Frame composition                             |
| Navigation     | Full design  | Host Product and Product Area navigation Extension Points and resolve accepted Contributions, ordering, active state, and fallback without owning access policy or Product behavior. | Workspace; Access-filtered availability; Application Registration; Contributions                          | persistent Frame/UI                                                             |
| Dashboard      | Full design  | Host dashboard composition and widget Extension Points while Contributors retain behavior and data ownership.                                                                        | Workspace; Access; Application Registration; Contributions                                                | dashboard presentation                                                          |
| Setup          | Full design  | Host shared setup composition while each contributing owner retains prerequisites, validation, readiness, configured values, and completion state.                                   | Access; Application Registration; Contributions                                                           | setup presentation and administration                                           |
| DataGovernance | Full design  | Own data purpose, ownership, stewardship, privacy-right intent, processing-purpose governance, data-quality accountability, retention-policy intent, and legal-hold authority.       | Users; Access; Audit; Notifications; Settings                                                             | DataProtection; future data-owning Modules                                      |
| DataProtection | Full design  | Own technical classification, masking, redaction, secure data movement/export handling, retention execution, anonymization/erasure execution, and data-handling enforcement.         | DataGovernance; Access; Auth; Security; Settings                                                          | data-owning systems; Audit; Monitoring; Notifications; future Modules           |

### 8.3 Core Subcapabilities

| Subcapability            | Parent         | M1 Treatment  | Responsibility                                                                                                                                                     |
| ------------------------ | -------------- | ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Secrets                  | Security       | Full design   | Credential handling, secure storage/reference rules, redaction, one-time display, reveal/copy rules, rotation, revocation, expiry, and secret-health requirements. |
| DLP                      | DataProtection | Boundary only | Reserve DataProtection ownership of sensitive data-movement policy and enforcement; detailed behavior waits for concrete movement/export use cases.                |
| Forensics                | Audit          | Boundary only | Reserve Audit ownership of forensic timeline and evidence-package semantics; detailed behavior waits for incident/evidence use cases.                              |
| Threat Detection         | Monitoring     | Boundary only | Reserve Monitoring ownership of detection/anomaly signals; detailed rules wait for stable evidence sources.                                                        |
| Vulnerability Management | Security       | Boundary only | Reserve Security ownership of vulnerability finding lifecycle and accepted-risk integration.                                                                       |
| Supply Chain             | Security       | Boundary only | Reserve Security ownership of dependency, SBOM, artifact-integrity, provenance, and supply-chain evidence concerns.                                                |
| Offensive Testing        | Security       | Boundary only | Reserve Security ownership of authorized offensive-testing scope, evidence handoff, and retest requirements.                                                       |

## 9. Intentional Deferrals

| Deferred Concern                                                       | Reason                                                                                                                                                     |
| ---------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Non-Human Identity / Service Accounts                                  | NHI must remain separate from Users, but its future owner and exact persistent model remain deferred. `users.type = service` is not a valid design option. |
| API and webhook products                                               | Design when a concrete supported machine-access or integration use case exists.                                                                            |
| Provider-specific OAuth/OIDC/SSO and future phishing-resistant factors | Auth must leave room for them without overdesigning provider-specific behavior.                                                                            |
| Global Administration                                                  | Initial architecture is one isolated Tenant Instance.                                                                                                      |
| Tenant/Instance provisioning and discovery                             | Persisted Tenant/Instance registries and dynamic routing are explicitly deferred.                                                                          |
| Module lifecycle, installation, entitlement, and update state          | Persistent owner remains deferred and M1 does not require optional business Module implementation.                                                         |
| Business Modules                                                       | M1 is Core-system design.                                                                                                                                  |
| Customer/public product foundation                                     | Design after Core Users/Auth/Access/data/security boundaries are stable.                                                                                   |
| Full DLP implementation                                                | Requires concrete data assets and movement/export workflows.                                                                                               |
| Formal forensic evidence workflows                                     | Requires stable Audit/Monitoring evidence and real incident workflows.                                                                                     |
| Threat-detection rule catalog/security cases                           | Requires stable evidence and response behavior.                                                                                                            |
| Vulnerability-management persistence/UI                                | Requires real finding producers and reporting need.                                                                                                        |
| Supply-chain automation/UI                                             | Requires defined build/release evidence needs.                                                                                                             |
| Offensive-security tooling/UI                                          | Requires an authorized testing program and findings handoff.                                                                                               |
| Incident Response application UI                                       | Remains standards/runbook-owned until an app-visible workflow is justified.                                                                                |
| Backup/Recovery application UI                                         | Remains operational/runbook-owned until application-visible state is justified.                                                                            |

## 10. First-Order Dependency Rules

- Auth consumes Users for human-account identity and lifecycle.
- Access consumes Users for human subjects and Auth for assurance requirements.
- Security supplies guardrails without taking over provider domain policy.
- Audit consumes Core Runtime correlation and provider-owned semantic evidence.
- Monitoring consumes Core Runtime correlation and operational/system evidence.
- Notifications consumes Users for recipients and Access where actionable targets require revalidation.
- Workspace consumes Users, Preferences, and Access; it is not a persistence or authorization owner.
- Navigation consumes Workspace context, Access-filtered availability, and Contributions.
- DataGovernance supplies governance intent required by DataProtection.
- DataProtection consumes Access authorization and Auth assurance for applicable sensitive operations.
- Settings provides infrastructure; contributing capabilities retain Setting semantics.
- Application Registration connects declarations to integrations without taking behavior ownership.

## 11. Major Cross-System Workflows

### WF-01 — Application Registration

```text
Owner declaration
    -> Application Registration
    -> native application/build integration
    -> Host Registry handoff when applicable
```

### WF-02 — Human Authentication

```text
User identification
    -> Users human-account/lifecycle Contract
    -> Auth credential/factor verification
    -> Auth session/assurance
    -> Audit evidence
    -> required Notifications
```

Security supplies cross-cutting guardrails.

### WF-03 — Human User Lifecycle

```text
Users lifecycle transition
    -> Auth credential/session effects
    -> Access effects
    -> Audit evidence
    -> Notifications
```

Users remains authoritative for human-account lifecycle.

### WF-04 — Authorization And Sensitive Action

```text
authenticated Principal
    -> Access Action/target decision
    -> optional Auth recent-auth/step-up
    -> optional DataProtection handling requirement
    -> owning capability operation
    -> Audit evidence
```

### WF-05 — Evidence And Attention

```text
accountable fact -> Audit
unexpected failure / health condition -> Monitoring
required human attention -> Notifications
```

An operation may produce both Audit and Monitoring evidence.

### WF-06 — Application Experience Composition

```text
Users + Preferences + Access
    -> Workspace
    -> Navigation
    -> Dashboard / Frame composition
    -> reusable UI
```

### WF-07 — Settings And Setup

```text
provider owns behavior
    -> provider declaration
    -> Application Registration
    -> Settings or Setup Host
    -> authorized presentation
```

### WF-08 — Governed Sensitive Data

```text
DataGovernance intent
    -> DataProtection handling
    -> Access authorization
    -> Auth assurance when required
    -> owning system operation
    -> Audit / Monitoring / Notifications
```

## 12. Serial System-Design Cycle

For each system:

1. **Select** the next accepted system in the serial design order.
2. **Design target state** from canonical M0 authority, accepted earlier M1 plans, standards, and product requirements.
3. **Resolve public Contracts** for every provider/consumer dependency.
4. **Resolve data, security, reliability, and evidence requirements.**
5. **Review current implementation only as reference evidence** after target design is coherent.
6. **Reconcile cross-system effects** by updating earlier system plans when ownership requires it.
7. **Promote durable truth** to architecture, feature, flow, database, standard, or runbook owners.
8. **Accept the system plan** before beginning the next system.

## 13. Serial Design Progression

This is the accepted M1 working design progression.

It steers system-design order only. It is not the final production implementation, GitHub issue, integration, or verification execution order.

1. Core Runtime
2. Users
3. Security
4. Security / Secrets
5. Audit
6. Auth
7. Access
8. Notifications
9. Monitoring
10. Application Registration
11. Settings
12. Preferences
13. Workspace
14. Navigation
15. Dashboard
16. Setup
17. DataGovernance
18. DataProtection

The progression may be refined when a later system exposes a real design dependency that changes the appropriate planning order.

After all eighteen system plans are accepted, reconcile the actual implementation and verification sequence from the completed cross-system design rather than assuming this planning progression is the build order.

## 14. System Development Specification Contract

Every full M1 system-development document uses `doc_type: planning`.

Use these sections unless genuinely not applicable.

### 1. Purpose And System Identity

System name, classification, canonical owner, purpose, responsibility, planning outcome.

### 2. Status And Authority

Lifecycle, acceptance state, governing sources, accepted related M1 systems, known gaps.

### 3. Scope And Non-Goals

In-scope behavior, exclusions, affected actors/Principals, invocation channels, deferred concerns.

### 4. Concepts And Vocabulary

System-owned concepts, meanings, ownership, lifecycle relevance, public-boundary relevance.

### 5. Responsibilities And Ownership Boundaries

Define:

```text
Owns
Does not own
Delegates to
Consumes from
Provides to
```

### 6. State And Lifecycle

Authoritative state, lifecycle states, valid/invalid transitions, prerequisites, side effects.

### 7. Public Contract Model

For each Contract:

- family;
- provider;
- consumers;
- input;
- result;
- expected rejection;
- authorization owner;
- sensitivity;
- transaction/consistency expectation.

### 8. Dependencies And Interaction Map

Reason, interaction type, required/optional status, failure behavior, cycle risk, prohibited coupling.

### 9. Events, Listeners, And Jobs

Completed facts, Event ownership, reactions, Job ownership, after-commit requirements, retries, idempotency.

### 10. Persistent Data And Invariants

Conceptual entities, relationships, uniqueness, invariants, ownership, foreign keys, projections, sensitivity, retention, deletion/anonymization.

Promote exact accepted schema Contracts to `docs/06-database/`.

### 11. Security, Authorization, And Abuse Cases

Principal/Actor, Action, target, authorization, object boundary, assurance, validation, rate limits, abuse cases, secrets, classification, controls.

### 12. Audit Requirements

Semantic accountable facts, Actor, subject/target, result, sensitivity/redaction, emission point.

### 13. Monitoring Requirements

Failure modes, health observations, operational/security signals, severity, correlation.

### 14. Notification Requirements

Attention event, recipient, required/optional delivery, actionability, access revalidation, minimization.

### 15. Settings, Preferences, And Configuration

Classify values as capability-owned Settings, Settings infrastructure, User Preferences, Laravel configuration, secrets, setup state, or installation state.

### 16. Delivery Surfaces And Presentation

Applicable web, admin/account, API, webhook, command, Job, scheduler, Setup, Settings, Dashboard, and Navigation requirements.

### 17. Registration And Extensibility

Owner registration declarations, dependencies, Host Contributions, Extension Points.

### 18. Failure, Transaction, Concurrency, And Reliability

Expected rejection, validation, denial, not-found, conflict, dependency/system failure, transaction owner, rollback, after-commit effects, concurrency, retries, idempotency, remote effects.

### 19. Reference Implementation Review

After target design is coherent, classify current code/tests as:

- behavior worth retaining;
- edge case worth retaining;
- test scenario worth retaining;
- implementation detail irrelevant to target design;
- behavior intentionally rejected;
- unresolved evidence.

Do not turn this section into migration planning.

### 20. Verification Model

Required unit, feature, integration, database, architecture, security, browser, accessibility/manual, operational, and specialist proof.

Define observable behavior sufficiently for later stable `AC-*` and `PF-*` contracts.

### 21. Development Decomposition

Future implementation slices with outcome, owner, dependencies, behavior, canonical docs, data/security impact, verification type, and non-goals.

These are planning slices, not executable packets.

### 22. Decisions And Open Questions

Decision, owner, affected systems, required-by point, blocking status, required canonical decision owner.

### 23. Documentation Promotion And Synchronization

Architecture, feature, flow, database, standards, runbooks, superseded planning, index updates.

### 24. Completion And Exit Criteria

A system plan is complete when ownership, behavior, Contracts, dependencies, data, security, evidence, failure/reliability, delivery, registration, verification, decomposition, and promotion are sufficient for later implementation planning without rediscovery.

## 15. System Planning Placement

Do not create one milestone-specific folder containing every M1 system.

### Foundation Infrastructure

Default:

```text
docs/07-planning/01-architecture-boundaries/<system>-development-planning.md
```

### Core Capabilities

Default:

```text
docs/07-planning/02-core-capabilities/<domain-group>/<system>-development-planning.md
```

Use an owner-accurate domain grouping.

Do not create new planning under stale group names solely because older planning used them.

Canonical human-account ownership is **Core Users**, not a broad Core Identity owner.

### Core Subcapabilities

Keep subcapability planning adjacent to the parent capability when practical.

## 16. Documentation Synchronization

Update this register when:

- a system enters or leaves M1;
- classification changes;
- first-order dependencies change materially;
- a major workflow changes;
- a deferred concern enters M1;
- the accepted serial design order changes.

When accepted, link this register from [Planning Index](../index.md).

Promote durable truth to:

- decisions -> `docs/01-decisions/`;
- standards -> `docs/02-standards/`;
- architecture -> `docs/03-architecture/`;
- features -> `docs/04-features/`;
- flows -> `docs/05-flows/`;
- database Contracts -> `docs/06-database/`;
- runbooks -> `docs/10-runbooks/`.

Supersede older planning when accepted M1 design invalidates it.

## 17. Completion And Exit Criteria

This register is active because:

- [x] M1 system list is accepted;
- [x] classifications are accepted;
- [x] primary responsibilities are accepted;
- [x] first-order dependencies are accepted as the initial graph;
- [x] major workflows are sufficient to guide serial design;
- [x] intentional deferrals are accepted;
- [x] the system-development specification contract is accepted;
- [x] the serial design method is accepted.

M1 system-design planning is complete when:

- [ ] every full-design M1 system has an accepted system-development specification;
- [ ] every boundary-only subcapability has a reserved owner and interaction boundary;
- [ ] cross-system Contracts and workflows are mutually coherent;
- [ ] no M1 system depends on an undefined owner or hidden shared state;
- [ ] data ownership/lifecycle is sufficient for exact database Contract work;
- [ ] security, Audit, Monitoring, and Notification behavior is explicit where applicable;
- [ ] durable architecture, behavior, flow, schema, standards, and runbook truth has been promoted;
- [ ] later implementation work can be written without reopening M0 architecture or inventing M1 system behavior;
- [ ] deferred future systems remain explicit and outside M1 scope.

This document may become `implemented` when the accepted M1 system-design package and canonical promotions are complete.

## 18. Related

- [Planning Index](../index.md)
- [M0 Repository Convergence Planning](m0-repository-convergence-planning.md)
- [Core Service Build Plan Matrix](../core-service-build-plan-matrix.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [Application Registration](../../03-architecture/application-registration.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Planning Documentation Standards](../../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Repository Naming Standards](../../02-standards/coding/repository-naming-standards.md)
- [Testing Standards](../../02-standards/testing/index.md)
