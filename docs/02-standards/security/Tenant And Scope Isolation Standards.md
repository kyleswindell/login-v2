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
summary: Defines Tenant and Instance isolation, User Account scope, Workspace resolution, asynchronous execution, and Global Administration access requirements.
-->

# Tenant And Scope Isolation Standards

Parent: [Security Standards Index](index.md)

## 1. Purpose

Prevent cross-Tenant, cross-Instance, wrong-Account, wrong-customer, and wrong-resource access.

These rules apply regardless of whether Instances share code, infrastructure, or database infrastructure.

## 2. Canonical Context

Security-sensitive operations must resolve:

- Tenant
- Instance
- Principal
- applicable User Account or NHI
- target resource
- target Tenant and Instance when different
- Module or capability
- Invocation Channel
- applicable Machine Identity, Network Identity, and Network Context
- environment

One Tenant owns one Instance. One User Account belongs to one Tenant Instance.

Workspace is the User Account-specific resolved runtime scope. It is not a persistent security or database boundary.

Do not infer security scope only from a URL prefix, route name, UI area, hostname label, model class, navigation entry, or client-provided identifier.

## 3. Object-Level Authorization

Every protected Action must verify:

- Principal authority
- User Account or NHI lifecycle state
- target identity
- target Tenant and Instance
- target resource scope
- Action-specific constraints
- applicable authentication assurance
- applicable Invocation Channel restrictions

A valid permission without a valid Tenant Instance and Target scope must deny.

## 4. Query Isolation

Queries must begin from the resolved Instance or an explicitly authorized Global Administration target.

Apply scope before pagination, aggregates, sorting, search, export, and mutation.

Do not fetch broad cross-Instance data and filter it later in memory.

Direct IDs must not bypass Tenant Instance resolution.

## 5. Route Model Binding

Binding must not expose a Target outside the authorized Instance or explicitly selected Global Administration target.

Use scoped binding, explicit query resolution, or policy denial.

Return 404 when revealing existence would leak information.

## 6. Jobs, Events, Commands, And Schedules

Queued, event-driven, command, and scheduled execution must carry enough context to re-resolve:

- Principal
- Tenant
- Instance
- Target
- Invocation Channel
- correlation and initiating-Principal evidence when applicable

Workers must revalidate current lifecycle, authorization, and scope before mutation.

Do not trust serialized model identity, stale permissions, or stale Tenant state.

A job, event, command, or scheduler is not the Principal.

## 7. APIs And Webhooks

API and webhook processing must resolve an attributable NHI and the permitted Tenant Instance scope.

A valid token, signature, or certificate without valid target scope must deny.

Webhook retries and API idempotency must not cross Instance boundaries.

## 8. Exports And Downloads

Export and download operations must:

- capture intended Tenant Instance and Target scope
- authorize at creation and download
- prevent cross-scope filters
- use private storage
- avoid predictable identifiers
- expire and revoke access
- audit sensitive movement

## 9. Notifications And Action Links

Notification payloads must contain safe identifiers and minimal summaries.

Action links must reauthorize when opened.

Receiving a notification does not grant access to its Target.

## 10. Global Administration

Global Administration is an authorized Surface within the Internal Tenant Instance.

Every cross-Instance Action requires:

- authorized Internal Tenant User Account or NHI
- explicit target Tenant and Instance
- purpose, reason, or support context where required
- recent authentication or MFA step-up when high risk
- separate Actor and target scope
- audit evidence
- time-bounded access when applicable
- no silent global fallback

Global Administration must not use unscoped model queries or implicit shared session state.

## 11. Tenant Lifecycle

Inactive, suspended, or deactivated Tenant and Instance state must fail closed for:

- login
- API
- webhook
- queued jobs
- event consumers
- schedules
- commands
- notifications
- integrations

Retention and deletion remain separate governance decisions.

## 12. Data Movement

Data Protection rules apply before sensitive data leaves its Instance through export, download, API, webhook, email, realtime payload, backup, support evidence, or Global Administration.

## 13. Tests

Required tests include:

- wrong-Instance denial
- wrong-Account denial
- wrong-resource denial
- wrong-customer denial
- cross-Instance export denial
- notification-action reauthorization
- queue and schedule scope revalidation
- inactive-Tenant denial
- Global Administration target-scope denial
- aggregate isolation
- direct-ID isolation
- NHI target-scope restrictions

## 14. Prohibited Practices

Do not:

- use multi-Tenant Instance assumptions
- treat Workspace as persistent scope
- hardcode Tenant domains or database names as authority
- assume an admin Surface removes object authorization
- treat navigation filtering as isolation
- share cache keys without Instance scope
- trust client-provided scope
- expose raw cross-Instance logs or evidence
- infer identity from source IP
- treat jobs or commands as Principals

## 15. Related

- [ADR-0006](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Data Protection And Data Loss Prevention Standards](Data%20Protection%20And%20Data%20Loss%20Prevention%20Standards.md)
- [Database Tenant Workspace Isolation Standards](../database/Database%20Tenant%20Workspace%20Isolation%20Standards.md)
- [Tenancy](../../03-architecture/tenancy.md)
