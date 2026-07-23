<!--
DOC-META
title: Webhook Delivery Adapter Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Webhook-Delivery-Adapters/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Webhook Delivery Adapter as owner-local inbound or outbound webhook transport integration around owner-controlled behavior.
-->

# Webhook Delivery Adapter Definition

Parent: [Definitions Index](../Index.md)

- [1. Definition](#1-definition)
- [2. Classification Rule](#2-classification-rule)
- [3. Owns](#3-owns)
- [4. Must Not Own](#4-must-not-own)
- [5. Dependency Rules](#5-dependency-rules)
- [6. Target Status](#6-target-status)
- [7. Accepted Decision](#7-accepted-decision)
- [8. Open Questions](#8-open-questions)
- [9. Related](#9-related)

## 1. Definition

A Webhook Delivery Adapter is owner-local inbound or outbound webhook transport integration around owner-controlled application behavior.

An inbound adapter receives, authenticates, validates, translates, and acknowledges a remote webhook.

An outbound adapter translates owner-controlled behavior or Events into a remote webhook request.

Webhook Delivery Adapter is a specialization of Delivery Adapter.

## 2. Classification Rule

An artifact is a Webhook Delivery Adapter when it primarily handles:

- webhook endpoint or sender transport;
- signature, timestamp, replay, or source validation;
- payload parsing or serialization;
- event-type or message translation;
- invocation of owner-controlled Actions, Queries, or workflows;
- acknowledgement, retry, or remote response handling;
- webhook-specific failure translation.

## 3. Owns

A Webhook Delivery Adapter may own:

- transport authentication and signature checks;
- inbound payload validation;
- outbound payload serialization;
- webhook acknowledgement;
- provider-specific error translation;
- delivery identifiers required by the transport;
- webhook-specific tests and documentation.

## 4. Must Not Own

A Webhook Delivery Adapter must not own:

- application workflows;
- authoritative business policy;
- another owner’s internals;
- reusable integration behavior unrelated to the webhook;
- generic Event ownership;
- secret storage policy;
- broad retry infrastructure;
- persistence rules beyond bounded delivery-state requirements.

## 5. Dependency Rules

A Webhook Delivery Adapter:

- may invoke owner-controlled Actions, Queries, Contracts, and workflows;
- may consume owner-defined Events for outbound delivery;
- may use public integration and security contracts;
- must not be depended on by owner domain behavior;
- must not access another owner’s internals;
- must preserve authentication, replay, idempotency, privacy, and operational requirements;
- must separate provider transport concerns from owner application behavior.

## 6. Target Status

Status: permanent

Webhook Delivery Adapter is a permanent delivery specialization.

The accepted delivery-artifact role is `Webhooks` beneath the explicit owner when a dedicated folder is required. Webhook handler classes use `<Provider><Event>WebhookHandler`.

Inbound and outbound subdivision remains owner-specific and sparse.

## 7. Accepted Decision

Status: accepted

Webhook adapters remain with the Core capability or Module responsible for the integration or behavior they expose.

They own webhook transport, validation, translation, acknowledgement, and channel-specific failure handling while delegating application behavior to the owner.

## 8. Open Questions

The following details remain deferred:

- final physical folder label;
- inbound versus outbound subdivision;
- exact provider-specific organization;
- exact signature and replay standards;
- exact retry, idempotency, and delivery-state proof;
- exact route and registration placement.

## 9. Related

- [Definitions Index](../Index.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- [HTTP Delivery Adapter Definition](../HTTP-Delivery-Adapters/Definition.md)
- [Event Definition](../Events/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Phase 2.4 Delivery Code Organization](../../Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md)
- Related GitHub issue: #49
