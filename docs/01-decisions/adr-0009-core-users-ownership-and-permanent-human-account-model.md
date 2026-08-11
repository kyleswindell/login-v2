<!--
DOC-META
title: ADR-0009: Core Users Ownership And Permanent Human Account Model
doc_type: decision
status: active
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0009-core-users-ownership-and-permanent-human-account-model.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Establishes Core Users as the human-account owner, defines User Identity as a conceptual attribute subset, makes User Accounts permanently retained, and supersedes prior broad Identity ownership for human Users.
-->

# ADR-0009: Core Users Ownership And Permanent Human Account Model

Parent: [Decisions Index](index.md)

## 1. Decision Status

Accepted

## 2. Date

- Accepted: 2026-08-11

## 3. Decision Owner

- Owner: Login 2.0 architecture owner
- Required reviewers: repository owner; architecture reviewer; security/authentication reviewer; data/schema reviewer
- Acceptance source: explicit repository-owner approval during M1 Core Users system-design review on 2026-08-11

## 4. Related Work

- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Persistent Data Architecture](../03-architecture/persistent-data-architecture.md)
- [M1 Core System Development Register](../07-planning/00-overview/m1-core-system-development-register.md)
- [Core Users Development Planning](../07-planning/02-core-capabilities/users/users-development-planning.md)
- [Users Data Contract](../06-database/feature-contracts/users.md)

## 5. Context

Earlier Login 2.0 planning and decisions used `Identity` as a broad Core owner containing human Users and described a User Identity as a separate record beneath a User Account.

M0 persistence reconciliation and M1 Core Users design established a narrower model.

Human account lifecycle, identifying/profile attributes, and invitations form one cohesive Core Users responsibility. `Identity` remains useful domain vocabulary for concepts such as User Identity, Machine Identity, Network Identity, and Non-Human Identity, but it is not the broad application owner of human User Accounts.

The human-account lifecycle also requires permanent identity and historical reference. Supported application behavior therefore must not delete a User Account after creation.

## 6. Decision Drivers

- one authoritative owner for human-account behavior and persistence;
- avoid an unnecessary separately persisted User Identity entity;
- preserve stable historical User references;
- maintain Audit and business-record attribution;
- keep Auth, Access, Security, and NHI ownership separate;
- prevent deletion semantics from weakening historical integrity;
- align canonical owner and identifier vocabulary;
- prevent future implementation from rebuilding the superseded broad Core Identity model.

## 7. Decision

### 7.1 Core Users

Core Users is the authoritative owner of:

- human User Accounts;
- User Identity attributes;
- human profile and primary contact information;
- User invitations;
- active/inactive account participation;
- active-account suspension;
- human-account lifecycle.

The canonical owner key for this capability is:

```text
users
```

### 7.2 User Identity

A User Identity is the identifying and profile subset of one User Account.

It is a conceptual classification, not a separately required persistent entity.

The target architecture does not require:

```text
user_identities
UserIdentity Model
separate User Identity lifecycle
broad Core Identity capability containing Users
```

A Human User participating in two Tenant Instances has two separate User Accounts. Each User Account carries its own User Identity attributes.

There is no canonical global human identity or implicit cross-Tenant identity link.

### 7.3 Permanent User Accounts

Once a User Account is created, supported application behavior must never physically or softly delete it.

A User Account has permanent identity.

Normal participation is controlled through:

```text
active
inactive
```

Suspension is a separate condition applicable only to an active User Account.

Inactive User Accounts remain persisted for:

- stable references;
- historical relationships;
- Audit attribution;
- retained business records;
- possible later reactivation.

### 7.4 Invitations

An Invitation is separate temporary operational persistence that exists before a User Account.

Issuing an Invitation does not create a User Account.

A permanent User Account is created only when the accepted account-creation boundary is reached.

### 7.5 Auth And Access Separation

Core Users does not own:

- passwords;
- password-reset state;
- MFA;
- sessions;
- authentication assurance;
- roles;
- permissions;
- groups;
- grants;
- access assignments.

Core Auth owns authentication state.

Core Access owns authorization state.

### 7.6 Non-Human Identity

Service Accounts and other Non-Human Identities are not Users and must not be represented through a User Account type discriminator.

Their future owner and persistence remain separately deferred.

## 8. Scope And Boundaries

This decision partially supersedes ADR-0006 only where ADR-0006 describes User Identity as a separately persisted `record`.

ADR-0006 remains authoritative for Human User, User Account, Principal, Actor, Tenant, Instance, Workspace, NHI, Machine Identity, Network Identity, Network Context, and Invocation vocabulary except where another accepted ADR explicitly supersedes it.

This decision partially supersedes ADR-0007 where `identity` is used as the owner key for human User Account behavior.

ADR-0007 remains authoritative for identifier grammar, identifier families, collision rules, compatibility aliases, and all unrelated owner/key decisions.

## 9. Alternatives Considered

### Broad Core Identity Owner

Not selected.

It adds an ownership layer above Users without an independent responsibility and encourages human, machine, and non-human identity concerns to collapse into one capability.

### Separate User Identity Persistence

Not selected.

The accepted User Identity concept is the identifying/profile subset of a User Account and does not currently justify a separate lifecycle or persistence root.

### Deletable User Accounts

Not selected.

Deleting User Accounts weakens stable historical references, attribution, and account reactivation while providing no required capability that cannot be handled through deactivation and later data-protection rules for specific attributes.

## 10. Consequences

- new human-account implementation belongs to Core Users;
- `owner_key: users` replaces `owner_key: identity` for human Users;
- User Identity terminology remains valid but does not imply separate persistence;
- User Accounts require no supported delete operation;
- inactive accounts remain durable;
- invitation persistence remains separate from User Account persistence;
- Auth and Access consume Core Users public Contracts rather than a broad Core Identity implementation;
- stale planning that targets `app/Core/Identity` for Users must be superseded.

## 11. Implementation Implications

Target implementation may use:

```text
app/Core/Users/
database/core/Users/
resources/views/core/Users/
```

according to Repository Architecture and naming standards.

Exact classes, migrations, Contracts, and implementation sequencing remain bounded implementation decisions.

## 12. Canonical Documentation Updates

Synchronize:

- Persistent Data Architecture;
- Identifier And Key Standards;
- Schema Design Standards;
- Users database Contracts;
- M1 Core System Development Register;
- applicable agent guidance;
- ADR-0006 and ADR-0007 supersession notes/index descriptions.

Supersede stale broad-Identity Users planning.

## 13. Verification

Documentation review must confirm:

- no current canonical owner assigns human User Accounts to broad Core Identity;
- no target schema requires separate User Identity persistence;
- no supported Users delete operation exists;
- Users owner-key examples use `users`;
- Auth and Access boundaries remain separate;
- NHI remains outside Users.

## 14. Supersession

This decision partially supersedes ADR-0006 and ADR-0007 only as described in Section 8.

No replacement decision currently exists.

## 15. Related

- [Decisions Index](index.md)
- [Persistent Data Architecture](../03-architecture/persistent-data-architecture.md)
- [Identifier And Key Standards](../02-standards/coding/Identifier%20And%20Key%20Standards.md)
- [Users Data Contract](../06-database/feature-contracts/users.md)
- [Core Users Development Planning](../07-planning/02-core-capabilities/users/users-development-planning.md)