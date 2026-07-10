<!--
DOC-META
title: ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary
doc_type: decision
status: active
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Records the canonical Tenant, Instance, Workspace, human and non-human principal, assurance, Actor, and Invocation Channel vocabulary.
-->

# ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary

Parent: [Decisions Index](index.md)

## 1. Decision Status

Accepted

## 2. Dates

- Proposed: 2026-07-10
- Accepted, rejected, deprecated, or superseded: 2026-07-10

## 3. Decision Owner

- Owner: Login 2.0 architecture owner
- Required reviewers: repository owner; architecture reviewer; Identity/Auth/Access reviewer; security and audit reviewer; database-scope reviewer
- Acceptance source: explicit repository-owner approval recorded through GitHub issue #27 and the associated pull request

## 4. Related Work

- GitHub issue: [#27 — Define Tenant, Instance, Workspace, principal, Actor, and invocation terms](https://github.com/kyleswindell/login-v2/issues/27)
- Parent goal: [#17 — M0 Goal 01: Canonical vocabulary and ownership](https://github.com/kyleswindell/login-v2/issues/17)
- Planning document: [M0 Repository Convergence Planning](../07-planning/00-overview/m0-repository-convergence-planning.md)
- Planning matrix: [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Pull request: pending
- Prior decisions:
  - [ADR-0005: Core, Modules, And UI Ownership Taxonomy](adr-0005-core-modules-ui-ownership-taxonomy.md)
- Affected canonical owners:
  - `docs/03-architecture/`
  - `docs/02-standards/security/`
  - `docs/02-standards/database/`
  - `docs/02-standards/logging/`
  - `docs/07-planning/core-service-build-plan-matrix.md`
  - Auth, Identity, Access, Audit, Monitoring, API, webhook, and Non-Human Identity planning

## 5. Context

The repository uses `tenant`, `instance`, `workspace`, `account`, `user`, `identity`, `service identity`, `machine identity`, `actor`, `job`, `console`, and related terms inconsistently.

Several current documents model Workspace as a persistent data boundary, separate internal and tenant workspace types, or a separate control-plane context. Other documents mix identity-bearing Principals with execution mechanisms such as jobs and commands.

M0 cannot establish target topology, persistent-data scope, authorization subjects, audit event shape, integration security, or migration direction until these terms have one accepted meaning.

## 6. Decision Drivers

- strict Tenant isolation
- one Tenant-owned lifecycle boundary
- no implicit cross-Tenant human identity linkage
- clear separation of persistent Principals from execution mechanisms
- accurate human and non-human audit attribution
- Zero Trust machine and network assurance
- reusable vocabulary for Auth, Identity, Access, Audit, Monitoring, API, webhook, queue, command, and scheduler behavior
- compatibility with shared application code without requiring shared Tenant state
- explicit migration from stale repository terminology

## 7. Decision

Login 2.0 will use the canonical model and terms defined below.

### 7.1 Tenant And Instance

A **Tenant** is the organization or group that exclusively owns one **Instance**.

```text
One Tenant -> One Instance
One Instance -> One Tenant
```

An Instance is the isolated application data and configuration package assigned to one Tenant. It includes installed and active Modules, configuration, setup state, User Accounts, access assignments, business data, notifications, audit records, operational records, and other Tenant-owned runtime state.

Instance is the logical isolation boundary. It does not necessarily require a separate application build, repository, container, VM, or physical host.

Deactivating a Tenant deactivates its Instance and User Accounts. Ordinary authentication and runtime activity must fail closed. Retention and deletion remain governed separately.

`App Instance` is a transitional descriptive alias. `Instance` is canonical.

### 7.2 Internal Tenant And Global Administration

The internal organization uses the same Tenant, Instance, User Account, User Identity, and Workspace model as every client.

Global Administration is a privileged Surface rendered only within authorized User Workspaces in the Internal Tenant Instance. It is not another Tenant, Instance, Workspace, or identity realm.

Global Administration packaging as Core or a restricted Module remains deferred.

### 7.3 Workspace

A **Workspace** is the User Account-specific resolved runtime and user-experience scope through which an authenticated User interacts with their Tenant Instance.

A Workspace is assembled from Tenant and Instance resolution, Instance configuration and Module state, User Account access, and User Account personalization.

A Workspace is not a stored container, database boundary, Tenant, Instance, organization, Principal, or replacement for authorization.

### 7.4 Human User, User Account, And User Identity

A **Human User** is the person interacting with the application.

A **User Account** is the Tenant-owned, Instance-specific human Principal and participation package through which a Human User accesses one Instance.

A **User Identity** is the identifying and profile subset of one User Account.

A human participating in two Tenants has two separate User Accounts and two separate User Identity records. There is no canonical global User Identity or implicit cross-Tenant identity link.

Matching email, phone, name, profile image, or external identifier does not establish a shared application identity.

### 7.5 Principal

A **Principal** is the human or non-human entity requesting access, receiving authorization, or being attributed as responsible for an operation.

```text
Principal Identity
├── Human Principal
│   └── User Account
│       └── User Identity
└── Non-Human Principal
    └── Non-Human Identity
        ├── Service Account
        ├── Workload Identity
        └── Application Principal
```

A credential authenticates or helps authenticate a Principal. A credential is not the Principal.

### 7.6 Non-Human Identity

A **Non-Human Identity (NHI)** is a non-human digital Principal used by software, workloads, services, integrations, or applications.

`Service Identity` is not the canonical umbrella.

- **Service Account**: persistent lifecycle-managed NHI account
- **Workload Identity**: NHI assigned to a running workload or workload class
- **Application Principal**: authorized representation of an application or API client

Not every NHI requires a Service Account.

Storage, credential, federation, and authentication-mechanism choices remain deferred.

### 7.7 Machine Identity

A **Machine Identity** identifies or attests the device or execution environment through which a human or non-human Principal acts.

Machine Identity is independent from NHI and is not an NHI subtype.

Machine Identity may accompany a User Account or an NHI. It must not be inferred solely from IP address, hostname, user agent, browser fingerprint, route, NAT address, or unverified request header.

### 7.8 Network Identity And Network Context

A **Network Identity** is an authenticated or verifiably identified network path, peer, gateway, tunnel, session, or appliance.

**Network Context** is observed transport, routing, location, and network-risk evidence.

Source IP alone is Network Context, not authoritative identity.

### 7.9 Actor, Action, Target, Result, And Scope

An **Actor** is the full event-time attribution envelope:

```text
Actor
├── Principal
├── Machine Identity
├── Network Identity
└── Network Context
```

The Principal may be a User Account, Service Account, Workload Identity, Application Principal, or named System Actor.

A **System Actor** is stable, bounded internal attribution used only when application-owned behavior is not performed by a User Account or managed NHI.

- **Action**: what occurred or was attempted
- **Target**: what was affected
- **Result**: the outcome
- **Scope**: the applicable Tenant Instance and narrower resource context

Jobs, commands, APIs, webhooks, events, and schedulers are execution mechanisms, not Actor types.

Global Administration events preserve both the Actor’s Internal Tenant Instance scope and the target Tenant and Instance scope.

### 7.10 Invocation Channel

An **Invocation Channel** identifies the immediate runtime ingress or dispatch mechanism through which an Actor initiates or continues an operation.

Canonical values:

```text
interactive_web
api_request
webhook_request
console_command
queued_job
event_consumer
scheduled_task
internal_system
```

Invocation Channel is separate from the Principal, credential, authentication mechanism, authorization grant, Action, target, Machine Identity, Network Identity, and Network Context.

Authorization may consider the channel, but the channel does not grant authority.

## 8. Scope And Boundaries

### Applies To

- Tenant and Instance lifecycle
- Workspace resolution
- User Account and User Identity
- Non-Human Identity
- Machine and network assurance
- Auth, Access, and authorization subjects
- APIs, webhooks, commands, jobs, events, and schedules
- audit, monitoring, and security events
- Global Administration attribution
- database and migration vocabulary
- repository terminology and planning

### Does Not Apply To

- final table design
- credential storage
- first NHI authentication mechanism
- route migration
- physical deployment topology
- Global Administration packaging
- detailed authorization policy
- provider-specific machine or network integrations

### Compatibility And Transition Boundaries

- current paths, table names, route names, classes, and keys may remain temporarily
- stale planning may remain only when marked superseded or compatibility-only
- new work must use the canonical terms unless an explicit compatibility constraint applies
- runtime behavior is not changed by this decision alone

## 9. Alternatives Considered

### Alternative A — Global Human Identity With Tenant Accounts

Not selected because it creates a canonical cross-Tenant identity relationship and weakens the required isolation model.

### Alternative B — Multi-Tenant Instance

Not selected because the current target model requires exclusive one-to-one Tenant and Instance ownership.

### Alternative C — Persistent Workspace Container

Not selected because Workspace is a runtime resolution derived from Instance and User Account state.

### Alternative D — Separate Control-Plane Workspace

Not selected because the Internal Tenant uses the same runtime model as clients; privileged global behavior is a Surface, not another Workspace.

### Alternative E — Service Identity As The NHI Umbrella

Not selected because NHI is the broader principal category and Service Account is one persistent subtype.

### Alternative F — Machine Identity As An NHI Subtype

Not selected because Machine Identity may accompany either human or non-human Principals.

### Alternative G — Job, Command, Or Webhook As Actor Types

Not selected because those identify invocation mechanisms rather than accountable Principals.

## 10. Consequences

### Positive

- strict Tenant and Account isolation
- one clear lifecycle boundary
- Workspace no longer competes with Instance as persistent scope
- human and non-human Principals are attributable consistently
- machine and network assurance remain orthogonal
- audit and authorization can evaluate channel without confusing it with identity
- Global Administration fits the same Tenant runtime model
- later topology and database work can rely on stable terms

### Negative

- several architecture and planning documents become stale immediately
- existing code and schema names may remain incompatible during migration
- cross-Tenant SSO or federation requires a separate future decision
- event schemas need additional Actor and invocation fields
- machine and network assurance may be unavailable in early implementations

### Neutral Tradeoffs

- shared application code remains possible while Instance state is isolated
- one person may manage multiple unrelated Accounts but Login 2.0 does not canonically link them
- a Service Account remains a common NHI pattern without becoming mandatory for all NHI forms

### Security, Privacy, And Data

- Tenant deactivation must suspend Instance and Account access
- profile similarity must not create cross-Tenant links
- credentials and secret-bearing evidence must not enter audit or documentation
- machine and network evidence must be stored as safe references or snapshots
- Global Administration must preserve Actor and target scope separately
- unknown attribution must not be normalized as `system`

### Operational And Migration

- no immediate runtime migration is authorized
- canonical docs and planning must be synchronized
- superseded three-context and persistent-workspace planning must be marked
- later migrations must explicitly map compatibility names
- the next available ADR identifier becomes ADR-0007

## 11. Implementation Implications

- Instance resolver and Tenant lifecycle contracts
- User Account and User Identity schema design
- NHI storage decision
- request-security and Actor context structures
- audit event shape
- queue, command, event, scheduler, API, and webhook instrumentation
- Global Administration authorization and audit contracts
- migration and compatibility maps

Required follow-up remains owned by Goals 03, 06, 07, 08, and 09 and by the service-account storage issue.

## 12. Canonical Documentation Updates

### Create

- `docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md`

### Update

- `docs/01-decisions/index.md`
- `docs/03-architecture/index.md`
- `docs/03-architecture/system-overview.md`
- `docs/03-architecture/workspace-identity-model.md`
- `docs/03-architecture/tenancy.md`
- `docs/02-standards/security/Tenant And Scope Isolation Standards.md`
- `docs/02-standards/database/Database Tenant Workspace Isolation Standards.md`
- `docs/02-standards/logging/Audit Logging Standards.md`
- `docs/07-planning/core-service-build-plan-matrix.md`
- `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md`

### Supersede Or Mark Superseded

- `docs/07-planning/01-architecture-boundaries/registry-instance-workspace-module-vocabulary-planning.md`
- `docs/07-planning/01-architecture-boundaries/workspace-identity-implementation-planning.md`
- `docs/07-planning/01-architecture-boundaries/platform-context-route-reorganization-planning.md`

## 13. Verification

- run documentation guardrails
- run `git diff --check`
- verify ADR metadata, filename, index, and links
- verify canonical docs do not define global User Identity
- verify canonical docs do not treat Workspace as persistent scope
- verify canonical docs do not place Machine Identity under NHI
- verify jobs and commands are Invocation Channels rather than Principals
- verify the eight channel values are consistent
- verify superseded planning is clearly marked

## 14. Supersession

### Supersedes

- no active ADR
- supersedes conflicting architecture and planning direction that models three runtime contexts, persistent workspace identity, global identity, Service Identity as the umbrella, or execution mechanisms as Actors

### Superseded By

- None

### Transition Plan

- retain physical compatibility names where necessary
- update canonical owners now
- mark stale planning superseded
- route physical and schema migration through later M0 goals

## 15. Acceptance Or Rejection Record

- Outcome: Accepted
- Date: 2026-07-10
- Accepted or rejected by: Login 2.0 repository owner
- Evidence: explicit approval in GitHub issue #27 and the associated pull request
- Required follow-up: Goals 03, 06, 07, 08, and 09; service-account storage decision; implementation issues for runtime context and event attribution

## 16. Related

- [Decisions Index](index.md)
- [System Overview](../03-architecture/system-overview.md)
- [Tenant, Instance, User Account, And Workspace Model](../03-architecture/workspace-identity-model.md)
- [Tenancy](../03-architecture/tenancy.md)
- [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Related GitHub issue: [#27](https://github.com/kyleswindell/login-v2/issues/27)
