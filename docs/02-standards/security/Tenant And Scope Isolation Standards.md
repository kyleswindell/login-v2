<!--
DOC-META
title: Tenant And Scope Isolation Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Tenant And Scope Isolation Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines app-instance, tenant, workspace, customer, resource, queue, export, notification, and support-access isolation requirements.
-->

# Tenant And Scope Isolation Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Explicit Context](#2-explicit-context)
- [3. Object-Level Authorization](#3-object-level-authorization)
- [4. Query Isolation](#4-query-isolation)
- [5. Route Model Binding](#5-route-model-binding)
- [6. Jobs, Events, And Commands](#6-jobs-events-and-commands)
- [7. Exports And Downloads](#7-exports-and-downloads)
- [8. Notifications And Action Links](#8-notifications-and-action-links)
- [9. Support And Administrative Access](#9-support-and-administrative-access)
- [10. Data Movement](#10-data-movement)
- [11. Tests](#11-tests)
- [12. Prohibited Practices](#12-prohibited-practices)
- [13. Related](#13-related)

## 1. Purpose

Prevent cross-instance, cross-tenant, cross-workspace, cross-customer, and wrong-resource access.

These rules apply even while Login 2.0 operates as one configured app instance.

## 2. Explicit Context

Security-sensitive operations must resolve an explicit context appropriate to the current architecture:

- app instance
- workspace
- tenant or customer scope
- module or capability
- target resource
- environment

Do not infer security scope only from a URL prefix, route name, UI area, hostname label, or model class name.

## 3. Object-Level Authorization

Every protected resource action must verify actor ability, target identity, target scope, context relationship, and action-specific constraints.

A valid permission without a valid target scope must deny.

## 4. Query Isolation

Queries must begin from the resolved scope where applicable, apply scope before pagination and aggregates, prevent IDs from bypassing context, and test wrong-scope IDs.

## 5. Route Model Binding

Binding must not expose a target outside the current scope.

Use scoped binding, explicit query resolution, or policy denial appropriate to the route.

A 404 may be preferable when revealing existence would leak information.

## 6. Jobs, Events, And Commands

Queued and background work must carry sufficient scope identity.

Workers must re-resolve and revalidate scope before mutation.

Do not trust serialized model identity alone when scope may change.

## 7. Exports And Downloads

Export and download operations must capture intended scope, reauthorize at creation and download, prevent cross-scope filters, use private storage, avoid predictable identifiers, expire and revoke access, and audit sensitive movement.

## 8. Notifications And Action Links

Notification payloads must contain safe identifiers and minimal summaries.

Action links must reauthorize when opened.

Receiving a notification does not grant access to its target.

## 9. Support And Administrative Access

Cross-instance or cross-scope support access requires explicit purpose, permission, target selection, recent authentication or MFA when high risk, audit evidence, time-bounded access where applicable, and no silent global fallback.

## 10. Data Movement

Data Protection rules apply before sensitive data leaves its scope through export, download, API, webhook, email, realtime payload, backup, or support evidence.

## 11. Tests

Required tests include wrong-resource denial, wrong-customer denial, wrong-workspace denial when implemented, cross-scope export denial, notification-action reauthorization, queued-job scope revalidation, support-access denial, aggregate isolation, and no IDOR through direct identifiers.

## 12. Prohibited Practices

Do not hardcode tenant domains or database names, assume an admin area removes object authorization, treat navigation filtering as isolation, share cache keys without scope, trust client-provided scope identifiers, or expose raw cross-instance logs or evidence by default.

## 13. Related

- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Data Protection And Data Loss Prevention Standards](Data%20Protection%20And%20Data%20Loss%20Prevention%20Standards.md)
- [Workspace Identity Implementation Planning](../../07-planning/01-architecture-boundaries/workspace-identity-implementation-planning.md)
