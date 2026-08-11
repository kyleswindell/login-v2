<!--
DOC-META
title: Persistent Data Architecture
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/persistent-data-architecture.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines the initial isolated Tenant Instance database boundary, persistent-concept ownership, identity and attribution boundaries, configuration categories, cross-owner persistence, durable Module data, and lifecycle and protection rules.
-->

# Persistent Data Architecture

Parent: [Architecture Index](index.md)

- [1. Purpose And Status](#1-purpose-and-status)
- [2. Scope](#2-scope)
  - [2.1. In Scope](#21-in-scope)
  - [2.2. Out Of Scope](#22-out-of-scope)
- [3. Initial Deployment And Isolation Boundary](#3-initial-deployment-and-isolation-boundary)
- [4. Accepted Persistence Decisions](#4-accepted-persistence-decisions)
- [5. Persistent Concept Ownership](#5-persistent-concept-ownership)
- [6. Human Users, Authentication, Access, And Non-Human Identity](#6-human-users-authentication-access-and-non-human-identity)
- [7. Preferences, Settings, Setup, And Installation](#7-preferences-settings-setup-and-installation)
  - [7.1. Preferences](#71-preferences)
  - [7.2. Settings](#72-settings)
  - [7.3. Setup](#73-setup)
  - [7.4. Installation And Update](#74-installation-and-update)
- [8. Keys, Relationships, Uniqueness, And Invariants](#8-keys-relationships-uniqueness-and-invariants)
- [9. Cross-Owner Reads, Writes, Foreign Keys, And Projections](#9-cross-owner-reads-writes-foreign-keys-and-projections)
  - [Foreign keys](#foreign-keys)
  - [Projections](#projections)
- [10. Module Schema And Data Durability](#10-module-schema-and-data-durability)
- [11. Lifecycle, Classification, Retention, And Protection](#11-lifecycle-classification-retention-and-protection)
- [12. Principal, Actor, Audit, Monitoring, And Assurance Evidence](#12-principal-actor-audit-monitoring-and-assurance-evidence)
- [13. Owner-Local Persistence Placement](#13-owner-local-persistence-placement)
- [14. Global Administration And Explicit Deferrals](#14-global-administration-and-explicit-deferrals)
- [15. Implementation Handoff Requirements](#15-implementation-handoff-requirements)
- [16. Open Questions](#16-open-questions)
- [17. Related](#17-related)

## 1. Purpose And Status

Define the target-state ownership, scope, isolation, relationship, lifecycle, and cross-owner boundaries for persistent data in Login 2.0 before detailed schema design or implementation planning.

This document is the canonical architecture result for GitHub issue [#22](https://github.com/kyleswindell/login-v2/issues/22).

Status:

- Target design: accepted through GitHub issue #22.
- Document lifecycle: active.
- Current implementation: pre-alpha and not target authority.
- Detailed tables, columns, constraints, indexes, and migrations authorized: no.
- Current-table inventory, compatibility planning, and migration sequencing authorized: no.

This document owns architecture-level persistence boundaries. Detailed schema and table contracts remain the responsibility of `docs/06-database/`, and mandatory implementation rules remain the responsibility of applicable standards.

## 2. Scope

### 2.1. In Scope

This document defines:

- the initial isolated Tenant Instance deployment and database boundary;
- conceptual Tenant and Instance cardinality;
- material persistent concepts and their authoritative owners;
- human User Account and User Identity persistence;
- Auth, Access, Principal, Actor, Non-Human Identity, Machine Identity, Network Identity, and Network Context boundaries;
- Preferences, Settings, Setup, and Installation distinctions;
- ownership of configured values and setup or installation progress;
- relationship, key, uniqueness, and invariant expectations;
- cross-owner reads, writes, foreign keys, and projections;
- durable Module schema and data behavior;
- lifecycle, classification, retention, legal-hold, audit, security, and protection expectations;
- owner-local Models, migrations, factories, seeders, and persistence support;
- the deferred boundary for Global Administration and multi-Instance operation.

### 2.2. Out Of Scope

This document does not define:

- a current table inventory or current-to-target table mapping;
- exact table, column, index, constraint, or database object names;
- migration sequencing, compatibility adapters, or production data migration;
- cleanup or disposition of current or deprecated tables;
- implementation Models, migrations, factories, seeders, or schemas;
- a Global Administration database or control-plane schema;
- multi-Instance routing, hostname resolution, dynamic connection switching, or provisioning;
- exact Non-Human Identity implementation;
- exact Module installation, activation, entitlement, or update-state implementation;
- exact application installer or updater ownership;
- exact Settings registry or storage implementation;
- Row-Level Security policy implementation;
- broad reopening of Goal 3 repository topology, placement, or naming beyond the bounded Core Users ownership clarification accepted by this document.

## 3. Initial Deployment And Isolation Boundary

The initial target is one isolated Parasolutions Tenant Instance:

```text
login.parasolutions.com
        ↓
one isolated Login 2.0 deployment
        ↓
one PostgreSQL database
        ↓
one PostgreSQL schema
```

The entire database is the initial Instance persistence boundary.

The initial target therefore has:

- no Global Administration database;
- no persisted Tenant registry;
- no persisted Instance registry;
- no hostname-to-Instance resolver;
- no dynamic database selection or switching;
- no global authentication system;
- no cross-Instance data access;
- no application awareness of other Tenant Instances.

Auth and every other Core capability operate only against the database configured for this deployment.

One Tenant conceptually owns exactly one Instance, and one Instance belongs to exactly one Tenant. Separate local Tenant and Instance records are not required merely to restate the deployment boundary. Persisted Tenant and Instance records are deferred until a future provisioning or Global Administration design requires them.

Ordinary tables do not require `tenant_id` or `instance_id` solely to enforce Tenant isolation. A table may still require another real scope key, such as `user_account_id`, `customer_id`, `project_id`, `module_key`, or another owner-defined resource boundary.

The phrase “one database and schema” means one database shared by the Core capabilities and installed Modules of this isolated Tenant Instance. It does not mean one database shared across multiple Tenants.

## 4. Accepted Persistence Decisions

1. **One PostgreSQL database and schema serves the initial isolated Tenant Instance.**
2. **One Tenant conceptually owns exactly one Instance, and one Instance belongs to exactly one Tenant. Separate persisted Tenant and Instance records are deferred until provisioning or Global Administration requires them.**
3. **No Core Tenancy capability, hostname resolver, or dynamic database-selection mechanism is required for the initial isolated deployment.**
4. **The isolated database is the Instance boundary; ordinary tables do not require `tenant_id` or `instance_id` solely for Tenant isolation.**
5. **Workspace is never a general persistent scope. Workspace is a named top-level rendered application experience. It may affect the active Product set and Frame composition, but it is not a general data-ownership, isolation, or authorization scope.**
6. **Core Users owns human User Accounts and User Identity persistence. Non-Human Identity persistence remains separate and must not be modeled as a User subtype or child of Core Users.**
7. **Service Accounts do not belong in the User Account table, model, or Core Users ownership. Future Service Account persistence remains separate under the applicable Non-Human Identity owner.**
8. **Auth owns credentials and authentication state. Access owns roles, permissions, grants, and assignments. Core Users owns human User Account lifecycle. A future NHI owner owns Non-Human Identity lifecycle. Principal is a shared conceptual role, not a separately persisted lifecycle owner.**
9. **Machine Identity and Network Identity remain separate from human and non-human Principals. Network Context is observational event-time evidence, not identity.**
10. **Actor is event-time evidence, not an authoritative mutable table.**
11. **Cross-owner reads and writes use public Contracts even inside one database.**
12. **Cross-owner foreign keys are allowed for stable identity and integrity, but cascading deletes are prohibited by default.**
13. **Core never references optional Module tables.**
14. **Shared projections are explicitly owned, non-authoritative, scoped, classified, and rebuildable.**
15. **Owner-local migration, factory, and seeder placement remains mandatory.**
16. **RLS is optional defense in depth for sensitive or internally partitioned data; it is not required to provide Tenant isolation in the initial database-per-Instance deployment.**
17. **The initial target is one isolated Parasolutions deployment at `login.parasolutions.com` using one Parasolutions database. Global Administration, multi-Instance provisioning, Tenant discovery, dynamic routing, and cross-Instance administration are deferred.**

These decisions establish persistence architecture. They do not create exact schema names or implementation work.

## 5. Persistent Concept Ownership

Every in-scope persistent concept has one authoritative owner. A shared screen, shared database, broad reuse, or cross-owner reference does not create shared ownership.

| Persistent concept                                                                                                                                                    | Authoritative owner                                                          | Boundary                                                                                                                                                                                               |
| --------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Human User Accounts, User Identity, profile data, contact data, invitations, and human-account lifecycle                                                              | Core Users                                                                   | Does not own passwords, MFA, sessions, roles, permissions, or NHI                                                                                                                                      |
| Password credentials, password reset state, MFA methods and challenges, recovery material, authentication sessions, recent-auth state, and other authentication proof | Core Auth                                                                    | Does not own human identity lifecycle or access grants                                                                                                                                                 |
| Roles, permissions, grants, assignments, groups, authorization policies, elevated-access records, and access reviews                                                  | Core Access                                                                  | Does not own credentials or human identity records                                                                                                                                                     |
| Private rendered-experience choices for one User Account                                                                                                              | Core Preferences                                                             | Must not become shared authoritative or business state                                                                                                                                                 |
| User Account Settings                                                                                                                                                 | The capability whose behavior or authoritative data is changed               | A Settings Product may compose the UI but does not absorb ownership                                                                                                                                    |
| Instance-, capability-, resource-, or Module-level Settings                                                                                                           | The capability or Module that defines the setting                            | Core Settings may provide shared registry or storage infrastructure without owning provider semantics                                                                                                  |
| Shared Setup Product Area, contribution Contract, navigation, composition, ordering, and presentation                                                                 | Core Setup                                                                   | Provider-specific requirements, prerequisites, validation, readiness, completion state, configured values, and persistence remain with the contributing Core capability or Module                      |
| Application or Module installation, activation, entitlement, and update progress                                                                                      | Deferred future installation or Module lifecycle owner                       | Not part of the initial persistence target; implementation is prohibited until ownership is accepted                                                                                                   |
| Notifications, delivery attempts, inbox state, read state, and notification lifecycle                                                                                 | Core Notifications                                                           | Domain owners define occurrence semantics; Notifications owns delivery state                                                                                                                           |
| Audit events and immutable or append-oriented evidence                                                                                                                | Core Audit                                                                   | Does not own mutable source records or monitoring detections                                                                                                                                           |
| Health observations, failures, detections, alerts, and operational signal state                                                                                       | Core Monitoring                                                              | Does not own audit truth or domain state                                                                                                                                                               |
| Machine Identity, Network Identity, device relationships, and related persisted state                                                                                 | The capability that owns the behavior or evidence                            | Auth may own trusted-device and assurance state; Users may own User Account device relationships; Security may own policy; Audit owns event-time evidence; Monitoring owns detections and observations |
| Network Context captured for a request or event                                                                                                                       | The owner of the event-time evidence, commonly Core Audit or Core Monitoring | Observational snapshot, not authoritative identity                                                                                                                                                     |
| Data domains, stewardship, processing purposes, privacy requirements, retention-policy intent, and legal holds                                                        | Core DataGovernance                                                          | Defines governance intent and hold authority; does not execute technical erasure                                                                                                                       |
| Data classification declarations, redaction, masking, encryption policy, movement controls, retention execution, anonymization, and erasure execution                 | Core DataProtection                                                          | Enforces approved governance intent and data-handling controls                                                                                                                                         |
| Application security controls, route and request trust, secure transport behavior, CSP, and security-control evaluation                                               | Core Security                                                                | May consume DataGovernance and DataProtection Contracts but does not own their data truth                                                                                                              |
| Host Registry persistence                                                                                                                                             | The applicable Host capability or Module                                     | Registry state does not become generic shared ownership                                                                                                                                                |
| Shared projections                                                                                                                                                    | The explicitly named projection owner                                        | Source owner remains authoritative; projection is non-authoritative and rebuildable                                                                                                                    |
| Optional Module schema and business data                                                                                                                              | The owning Module                                                            | Tables and data survive ordinary disablement or uninstall                                                                                                                                              |
| Non-Human Identity and Service Account records                                                                                                                        | Deferred future NHI owner                                                    | Must not be implemented beneath Core Users or as User subtypes                                                                                                                                         |

Core Users is the canonical Core capability owner for human User Accounts, User Identity, profile and contact data, invitations, and human-account lifecycle. Identity remains a domain concept used in terms such as User Identity, Machine Identity, and Network Identity; it is not a separate broad Core owner containing Users.

User Identity is a conceptual classification of the identifying and profile attributes carried by one User Account. It does not require a separate persistent entity, table, Model, lifecycle, or capability owner.

Once a User Account has been created, supported application behavior must never physically delete it. Human-account offboarding uses deactivation. Inactive User Accounts remain permanently persisted for stable identity, historical relationships, Audit attribution, and possible later reactivation.

A concept marked deferred is outside the initial target rather than unowned implementation work. It must not be implemented until a later accepted architecture decision names its owner and boundaries.

## 6. Human Users, Authentication, Access, And Non-Human Identity

The human persistence model is:

```text
Human Principal role
        ↓
User Account
        ↓
User Identity and profile subset
```

The authoritative ownership split is:

```text
Core Users
├── User Account
├── User Identity
├── profile and contact data
├── invitation and participation lifecycle
└── activation, suspension, deactivation, and comparable human-account state

Core Auth
├── passwords and password verification state
├── MFA methods and challenge state
├── recovery material
├── sessions and remember state
├── authentication assurance
└── recent-auth and step-up state

Core Access
├── roles
├── permissions
├── grants and assignments
├── groups and memberships
├── policy state
└── elevated-access and review state
```

A User Account and its User Identity belong to the isolated Tenant Instance. There is no canonical global human identity implied by similar names, email addresses, or profile data.

Principal remains a conceptual role used by Auth, Access, Audit, and other consumers to describe an entity that requests access, receives authorization, or is attributed for an operation. Principal does not require:

- a shared `principals` table;
- one shared persistence root;
- one capability that owns both humans and non-humans;
- inheritance between User Account and Service Account tables.

Non-Human Identity remains separate:

```text
Non-Human Principal role
        ↓
future Non-Human Identity owner
├── Service Account
├── Workload Identity
└── Application Principal
```

Service Accounts must not be stored as Users, distinguished by a type column in the User Account table, or placed beneath Core Users merely to reuse authentication or authorization code.

Machine Identity, Network Identity, and Network Context remain separate from Principal, but they are cross-capability concepts rather than automatic standalone persistence owners. Each persisted record belongs to the capability that owns its behavior or evidence. Auth may own trusted-device and authentication-assurance state; Users may own User Account device relationships or user-facing device presentation; Security may own device or network policy; Audit owns event-time attribution evidence; and Monitoring owns detections and operational observations. Network Context is observed transport, source, and risk evidence captured for an invocation or event and is not promoted into identity merely because it is persisted.

## 7. Preferences, Settings, Setup, And Installation

Category is determined by meaning and effect, not by whether an administrator or ordinary user can access the screen.

Authorization determines who may read or change a value. Authorization does not determine whether the value is a Preference, Setting, Setup requirement, or Installation state.

### 7.1. Preferences

A Preference is a private choice that affects only one User Account’s rendered Workspace experience.

Preferences may include:

- theme;
- density;
- font or display scale;
- sidebar expansion or collapse state;
- preferred landing Product;
- personal display timezone;
- other private presentation choices.

A Preference:

- is scoped to one User Account;
- is not visible as shared authoritative state to other users;
- does not change how shared records are created, processed, connected, secured, or interpreted;
- does not grant access or change authorization;
- does not become Instance configuration.

A useful classification rule is:

> If a change affects only how one user sees or experiences rendered Workspaces, it is a Preference.

### 7.2. Settings

A Setting is authoritative or functional configuration that changes application, account, capability, resource, integration, security, or data-processing behavior.

Settings may be scoped to:

- one User Account;
- the entire Tenant Instance;
- one Core capability;
- one installed Module;
- one resource;
- one integration;
- another explicit owner-defined boundary.

A normal User may have access to Settings. Role and permission evaluation determine which Settings each authenticated User Account may view or change.

User Account Settings may include:

- display name;
- contact email address;
- personal MFA configuration;
- personal API-token capability when later accepted;
- out-of-office or automated-response behavior;
- account-level integration connections.

These values are Settings rather than Preferences because they change authoritative identity, technical capability, application behavior, data processing, connectivity, security, or what other users observe.

Instance or capability Settings may include:

- Instance timezone;
- organization display name;
- sales-tax rules;
- default integrations;
- data-retention policy;
- security policy;
- future Project status definitions;
- future inventory or ordering defaults.

A useful classification rule is:

> If a change modifies how data is processed, created, connected, secured, or exposed to others, it is normally a Setting.

A Settings Product may be available to every authenticated User Account while filtering Products, Product Areas, Pages, fields, and operations according to authorization.

The Settings Product does not become the persistence owner of every value shown inside it. Each provider owns:

- meaning;
- validation;
- defaults;
- authorization requirements;
- persistence;
- lifecycle;
- public read and write Contracts.

Core Settings may later provide shared setting-definition, registry, lookup, composition, or storage infrastructure. That infrastructure does not transfer provider ownership.

### 7.3. Setup

Setup is required foundational configuration without which the application, a Core capability, or a future Module cannot operate correctly, safely, or meaningfully.

Setup may be required for:

- external dependencies and credentials;
- data-architecture or custom-schema preparation;
- domain or DNS verification;
- mail or integration plumbing;
- required security foundations;
- baseline workflows;
- mandatory routing or status definitions;
- other cold-start prerequisites.

Setup is an administrator-oriented Product Area. Only User Accounts with the required roles and permissions may access its applicable Pages and operations.

Setup may be revisited after initial installation to update already configured Core capabilities or Modules. Examples include:

- Instance timezone;
- sales-tax configuration;
- external service configuration;
- mandatory security configuration;
- future custom Project statuses or variables.

Core Setup owns the shared Setup Product Area and contribution host:

- the Setup contribution Contract;
- Setup navigation and composition;
- contribution validation, ordering, visibility, and presentation;
- shared administrative setup interaction patterns;
- an explicitly non-authoritative aggregate readiness projection when one is needed.

Each contributing Core capability or Module owns:

- its setup requirements and prerequisite definitions;
- authorization;
- validation;
- configured values;
- authoritative readiness and completion state;
- persistence;
- public read and write Contracts.

Core Setup does not become the authoritative owner of provider setup state merely because it presents or coordinates that setup.

```text
Administrator opens Setup
        ↓
Core Setup composes provider contributions
        ↓
provider public Contract validates and writes
        ↓
provider owns readiness, completion, configuration, and persistence
        ↓
Core Setup may present a non-authoritative aggregate status
```

### 7.4. Installation And Update

Installation or update is the lifecycle process that introduces an application component or future Module, applies its schema requirements, and determines whether Setup must be completed.

```text
Install or major update
        ↓
apply accepted package and schema lifecycle
        ↓
resolve required Setup steps
        ↓
provider owners persist their configuration
        ↓
verify readiness
        ↓
record installation or update completion
```

Installation or update progress may include:

- installed version;
- target version;
- required Setup step identifiers;
- pending, blocked, failed, or completed state;
- failure and retry information;
- responsible administrator;
- completion timestamp.

Installation does not own the resulting Settings. The provider that defines each value remains authoritative.

The exact owner and persistence design for application installation, Module installation, activation, entitlement, and update progress are deferred. Module implementation must not begin until that later architecture is accepted.

## 8. Keys, Relationships, Uniqueness, And Invariants

Detailed key types and table names remain future schema decisions. The architecture requires the following:

1. Each table has one explicit owner.
2. Internal primary keys follow the accepted project key standard unless a later schema contract provides a documented exception.
3. External or cross-system stable identifiers use separate unique columns rather than replacing internal primary keys by default.
4. `tenant_id` and `instance_id` are not added solely to restate the isolated database boundary.
5. Genuine internal scopes use explicit keys, such as User Account, customer, Project, resource, integration, or Module-defined scope.
6. Unique constraints include the actual scope when uniqueness is scoped.
7. Required relationships use explicit foreign keys when the relationship is stable and permitted by dependency rules.
8. Nullable foreign keys are used only for genuinely optional relationships.
9. Polymorphic relationships are avoided for identity, security, access, ownership, financial, audit, and data-protection boundaries unless separately accepted.
10. Lifecycle state uses explicit, meaningful states and timestamps rather than overloading `updated_at`, soft deletion, or a vague `active` flag.
11. Soft deletion does not replace lifecycle design.
12. Hard deletion is not permitted while required references, retention, legal holds, audit meaning, or security evidence prohibit it.
13. Cascading deletion across owner boundaries is prohibited by default.
14. Conceptual one-to-one Tenant and Instance cardinality does not require local Tenant and Instance rows in the initial isolated database.
15. Workspace selection does not create a persistent ownership or uniqueness scope.

## 9. Cross-Owner Reads, Writes, Foreign Keys, And Projections

One physical database does not permit owners to bypass architectural boundaries.

Cross-owner reads use provider-owned Query Contracts. Cross-owner writes use provider-owned Operation Contracts.

The following remain prohibited across ownership boundaries:

- direct Eloquent Model access;
- direct repository or query-builder access;
- direct table reads or writes;
- returning provider Models as public results;
- treating a foreign key as authorization to mutate provider state;
- UI-owned database access;
- Core access to optional Module implementation or tables.

The provider remains authoritative for:

- authorization;
- validation;
- invariants;
- persistence mutation;
- transaction boundary;
- lifecycle effects;
- Events;
- deferred Jobs;
- public rejection.

### Foreign keys

Cross-owner foreign keys are permitted only when they provide durable identity or integrity and the dependency direction is allowed.

Examples may include:

- a Module record referencing a stable Core User Account identifier;
- a consumer-owned record referencing a provider-owned stable resource identity;
- an explicit Module-to-Module relationship when the Module dependency is declared, version constrained, and accepted.

A foreign key does not transfer ownership or permit direct behavioral access.

Rules:

- Core must never reference an optional Module table.
- Optional Module tables may reference stable Core identities when public dependency rules permit.
- Module-to-Module foreign keys require an explicit accepted Module dependency.
- Cascading deletes across owners are prohibited by default.
- Provider deletion or deactivation must use explicit lifecycle coordination through public Contracts.
- Cross-owner database triggers that perform hidden business behavior are prohibited unless separately accepted.

### Projections

A shared or cross-owner projection must declare:

- projection owner;
- authoritative source owner or owners;
- purpose;
- scope;
- classification;
- refresh or update mechanism;
- rebuild procedure;
- staleness expectations;
- authorization behavior;
- retention behavior.

A projection is non-authoritative and must not become the write source for provider-owned truth. Rebuilding or removing a projection must not delete or rewrite authoritative source records.

## 10. Module Schema And Data Durability

An optional Module owns its schema and business data.

Installing a Module may apply additive Module-owned migrations that create durable tables and other persistent database structures inside the Tenant Instance database.

Ordinary Module lifecycle behavior is:

```text
Install Module
├── register stable Module identity
├── validate accepted dependencies
├── run outstanding owner-local migrations
├── create durable Module-owned tables
└── preserve Module data in the Instance database

Disable Or Deactivate Module
├── stop or restrict Module routes and operations
├── stop active Contributions
├── prevent unauthorized new Module behavior
└── retain Module tables and data unchanged

Uninstall Module
├── remove package or runtime availability
├── remove active registration when applicable
└── retain Module tables and data unchanged

Reinstall Or Reactivate Module
├── recognize the same stable Module identity
├── reuse retained schema and data
├── inspect applied migration state
└── run only outstanding forward migrations
```

Disabling, deactivating, or uninstalling a Module must not:

- drop Module tables;
- delete Module records;
- cascade-delete data referenced by other owners;
- erase audit evidence;
- bypass retention or legal holds;
- silently anonymize or purge data;
- treat package absence as authorization for destructive schema reversal.

Module uninstall and Module data purge are separate operations.

A future destructive purge workflow requires, at minimum:

- explicit administrator authorization;
- explicit identification of the Module and affected data;
- dependency and foreign-key checks;
- retention and legal-hold evaluation;
- backup or export safeguards where required;
- DataGovernance and DataProtection evaluation;
- audit evidence;
- clear confirmation;
- separately accepted schema-removal behavior.

Until that workflow is accepted, Module-owned schema is non-removable through ordinary disablement or uninstall.

Core must not reference Module tables. A disabled or uninstalled Module therefore cannot break Core merely because its retained tables remain in the Instance database.

## 11. Lifecycle, Classification, Retention, And Protection

Every material data asset must identify:

- authoritative owner;
- purpose;
- scope;
- classification;
- sensitive fields;
- access boundary;
- export eligibility;
- lifecycle states;
- retention intent;
- legal-hold behavior;
- deletion, deactivation, or anonymization behavior;
- audit expectations;
- monitoring expectations where applicable;
- protection requirements;
- backup implications.

Ownership is separated as follows:

```text
Core DataGovernance
├── data domains
├── ownership and stewardship
├── processing purpose
├── privacy requirements
├── retention-policy intent
└── legal holds

Core DataProtection
├── classification declarations
├── redaction and masking
├── encryption policy
├── data-movement controls
├── retention execution
├── anonymization
└── erasure execution

Core Security
├── application and request security controls
├── route and transport protections
├── security-control evaluation
└── enforcement support through public Contracts
```

DataGovernance defines whether data should be retained, may be deleted, or is subject to a legal hold. DataProtection executes the approved technical handling.

```text
DataGovernance retention intent
        ↓
DataProtection retention execution
```

```text
DataGovernance legal hold
        ↓
DataProtection blocks pruning, anonymization, or erasure
```

Deletion is not the default lifecycle action.

Use:

- deactivation when participation or operation must stop while history remains;
- anonymization when identifying data should be removed while business or audit integrity remains;
- soft deletion when recoverability is required;
- hard deletion only when retention, legal hold, dependencies, audit meaning, and security evidence permit it;
- explicit archival where records remain intentionally retained outside ordinary active use.

Raw passwords, recovery values, API tokens, secrets, private keys, and comparable restricted values must not be stored when a hash, encrypted value, or external secret reference is sufficient.

Backups inherit the highest classification of the data they contain and remain subject to intentional retention, access control, encryption, and restore verification.

Row-Level Security may later provide defense in depth for sensitive or internally partitioned data. It is not the initial Tenant isolation mechanism and must not replace application authorization or provider-owned Contracts.

## 12. Principal, Actor, Audit, Monitoring, And Assurance Evidence

Principal describes the human or non-human entity requesting access, receiving authorization, or being attributed for an operation. It is a conceptual role and does not require a shared persistence table.

Actor is the event-time attribution envelope for an action, decision, or observation.

An Actor record or audit representation may capture:

- Principal type and stable identifier;
- applicable User Account or NHI identifier;
- Machine Identity when available;
- Network Identity when available;
- Network Context snapshot;
- invocation channel;
- session, request, correlation, or causation identifiers;
- target type and identifier;
- action;
- result;
- timestamp;
- reason or support context when required.

Actor is not an authoritative mutable identity record. Historical evidence must remain interpretable even when the current User Account, NHI, machine, network, or target state later changes.

Core Audit owns durable audit evidence. Audit should preserve the event-time meaning needed for reconstruction and must not depend solely on a mutable join to a current profile record.

Core Monitoring owns operational observations, health state, detections, and alert signals. Monitoring may consume Audit and domain Events but does not replace Audit evidence or provider-owned state.

Machine Identity, Network Identity, and Network Context do not require standalone Core capabilities or universal root tables in the current target. Persisted state remains with the behavior or evidence owner:

- Auth may own trusted-device registration, authentication-assurance state, revocation, and security-sensitive device credentials;
- Users may own User Account device relationships, user-assigned device labels, or the user-facing device-management experience;
- Security may own device or network policy and trust evaluation;
- Audit owns event-time sign-in and attribution evidence;
- Monitoring owns detections and operational observations.

A Users-owned device-management surface may consume Auth-owned Query and Operation Contracts without transferring Auth’s trusted-device records to Users.

Network Context is stored only as event-time evidence or an explicitly justified operational observation. An IP address, user agent, transport property, VPN or proxy signal, approximate location, or risk signal is not automatically Machine Identity or Network Identity.

## 13. Owner-Local Persistence Placement

Runtime persistence implementation remains owner-local.

Core runtime persistence:

```text
app/Core/<Capability>/Models/
app/Core/<Capability>/Data/
app/Core/<Capability>/Queries/
app/Core/<Capability>/<OtherApplicableTechnicalRole>/
```

Core schema-lifecycle artifacts:

```text
database/core/<Capability>/migrations/
database/core/<Capability>/factories/
database/core/<Capability>/seeders/
```

Module runtime persistence:

```text
Modules/<Module>/src/Models/
Modules/<Module>/src/Data/
Modules/<Module>/src/Queries/
Modules/<Module>/src/<OtherApplicableTechnicalRole>/
```

Module schema-lifecycle artifacts:

```text
Modules/<Module>/database/migrations/
Modules/<Module>/database/factories/
Modules/<Module>/database/seeders/
```

Rules:

- Models, Queries, persistence Actions, factories, seeders, and migrations remain with their authoritative owner.
- New canonical persistence must not use generic root `app/Models/`, shared repositories, or ownerless persistence services.
- Generic root database folders are restricted to application bootstrap, genuinely cross-owner database infrastructure, root composition, and bounded compatibility.
- Each registrable owner declares migration, factory, and seeder paths and ordering dependencies through accepted application registration.
- Laravel executes migrations and seeders without becoming the persistence owner.
- Shared projections remain with the projection owner.
- Human-readable schema and table contracts belong beneath `docs/06-database/`.
- Owner-local placement does not permit direct cross-owner Model or table access.

## 14. Global Administration And Explicit Deferrals

Global Administration is outside the current persistent target.

The initial Parasolutions deployment does not require:

- a Global Administration database;
- a control-plane Tenant or Instance registry;
- shared global User Accounts;
- global authentication;
- cross-Instance sessions;
- dynamic database routing;
- hostname resolution;
- provisioning records;
- cross-Instance support or administration records.

Future isolated deployments on separate servers or droplets remain compatible with this architecture because each deployment may continue to own one Instance database.

If Global Administration is later accepted, it must preserve these scopes separately:

```text
administrating Actor
├── Actor Principal
├── Actor Tenant and Instance
├── Actor Machine and Network assurance
└── authorization and reason

administrative target
├── target Tenant
├── target Instance
├── target resource
└── requested operation
```

A future control plane must not collapse the Internal Tenant Actor scope with the target Tenant or Instance.

The following remain explicit deferrals:

- Global Administration persistence;
- persisted Tenant and Instance records;
- multi-Instance discovery and routing;
- dynamic database selection;
- provisioning and deployment records;
- exact NHI owner and schema;
- Service Account implementation;
- Module installation, activation, entitlement, disablement, and update-state ownership;
- application installer and updater ownership;
- exact Settings registry and storage model;
- exact Setup persistence tables;
- RLS implementation;
- exact schema, keys, indexes, constraints, and table names;
- production migration and compatibility.

No implementation issue may fill one of these deferrals by inference.

## 15. Implementation Handoff Requirements

Before implementing a persistent concept, the applicable issue and database contract must identify:

1. the authoritative owner;
2. the exact scope;
3. the table classification;
4. sensitive and restricted fields;
5. primary and stable external identifiers;
6. required relationships and foreign keys;
7. uniqueness and invariant constraints;
8. lifecycle states and timestamps;
9. deactivation, deletion, anonymization, and archival behavior;
10. retention intent and legal-hold behavior;
11. audit and monitoring expectations;
12. encryption, hashing, masking, redaction, and export behavior;
13. public Query and Operation Contracts for cross-owner use;
14. prohibited direct access;
15. owner-local Model, migration, factory, seeder, and test placement;
16. Module disablement, uninstall, reinstallation, and purge behavior when applicable;
17. automated and manual proof for the declared invariants.

The implementation must not weaken an accepted ownership, isolation, retention, audit, or protection boundary merely to fit an existing table or framework convention.

## 16. Open Questions

No unresolved question blocks the initial isolated Tenant Instance persistence architecture.

The items listed in Section 14 are deliberate future deferrals. They require separate accepted architecture before implementation and must not be treated as implied work.

## 17. Related

- [Architecture Index](index.md)
- [Repository Architecture](repository-architecture.md)
- [Application Registration](application-registration.md)
- [Public Contract And Interaction Model](public-contract-and-interaction-model.md)
- [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md)
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)
- [Tenancy](tenancy.md)
- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Schema Design Standards](../02-standards/database/Schema%20Design%20Standards.md)
- [Database Data Classification And Retention Standards](../02-standards/database/Database%20Data%20Classification%20And%20Retention%20Standards.md)
- [Data Protection And Data Loss Prevention Standards](../02-standards/security/Data%20Protection%20And%20Data%20Loss%20Prevention%20Standards.md)
- [Phase 4.6 Database And Migration Placement](../07-planning/Milestones/milestone-0/goal-3/phase-4/4-6-database-and-migration-placement.md)
- [GitHub Issue #22: Persistent-data architecture](https://github.com/kyleswindell/login-v2/issues/22)
