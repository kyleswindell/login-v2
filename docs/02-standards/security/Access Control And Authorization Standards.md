<!--
DOC-META
title: Access Control And Authorization Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Access Control And Authorization Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines permission ownership, roles, policies, object and scope authorization, elevated access, separation of duties, and authorization evidence.
-->

# Access Control And Authorization Standards

Parent: [Security Standards Index](index.md)
- [1. Purpose](#1-purpose)
- [2. Authentication Is Not Authorization](#2-authentication-is-not-authorization)
- [3. Permission Ownership](#3-permission-ownership)
- [4. Authorization Layers](#4-authorization-layers)
- [5. Roles, Groups, And Policies](#5-roles-groups-and-policies)
- [6. Effective Access](#6-effective-access)
- [7. Elevated Access](#7-elevated-access)
- [8. Guardrails](#8-guardrails)
- [9. Object And Scope Checks](#9-object-and-scope-checks)
- [10. Service Actors](#10-service-actors)
- [11. Denials](#11-denials)
- [12. Tests](#12-tests)
- [13. Related](#13-related)

## 1. Purpose

Define how authenticated human and non-human actors are authorized to perform actions on specific targets and scopes.

## 2. Authentication Is Not Authorization

A valid session, MFA result, service token, or provider identity does not grant access by itself.

Every protected action requires an authorization decision.

## 3. Permission Ownership

Capabilities and Business Modules declare the permissions they introduce.

The Roles or Access capability may group permissions but must not become the owner of every permission meaning.

Permission keys must be stable, readable, and owner-qualified.

Do not add new generic `platform.*` permission keys.

## 4. Authorization Layers

Apply:

- route prerequisite
- action ability
- object-level target check
- scope check
- state and lifecycle check
- contextual assurance check
- domain invariant

A broad manage permission does not bypass target or scope constraints unless the standard explicitly defines that behavior.

## 5. Roles, Groups, And Policies

Roles group permissions.

Groups organize subjects.

Policies connect subject, target, role or actions, constraints, reason, and expiration.

Direct user assignment should be treated as an exception when policy-backed assignment exists.

## 6. Effective Access

The system should be able to explain who has access, what action is allowed, which target and scope apply, why access exists, whether access is inherited or direct, whether access expires, and which assurance is required.

## 7. Elevated Access

High-risk access should support explicit activation, MFA or recent authentication, reason, bounded duration, visible state, revocation, and audit evidence.

Do not keep elevated access silently active for the full session when just-in-time activation is required.

## 8. Guardrails

Protect against self-escalation, last-admin removal, assignment of immutable system roles, privilege changes without required approval, conflicting duties, expired assignments, disabled subjects, and broad service-account inheritance.

## 9. Object And Scope Checks

Authorization must use the actual target and current context.

Route names, sidebar location, hidden actions, and model ID format do not prove scope.

## 10. Service Actors

Service accounts require explicit identity, owner, purpose, environment, scoped actions, target restrictions, credential lifecycle, audit actor representation, and review cadence.

Do not grant a machine identity normal human roles by default.

## 11. Denials

Security-relevant denials should record safe evidence including actor, action, target, scope, reason category, request ID, and result.

Do not expose sensitive policy internals in user-facing denial messages.

## 12. Tests

Verify permission allow and deny, object denial, scope denial, expired policy, inactive subject, self-escalation block, last-admin guard, elevated-access expiry, separation-of-duty conflict, service-account scope, and effective-access explanation.

## 13. Related

- [Zero Trust Security Standards](Zero%20Trust%20Security%20Standards.md)
- [Tenant And Scope Isolation Standards](Tenant%20And%20Scope%20Isolation%20Standards.md)
- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Access Control Implementation Planning](../../07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md)
