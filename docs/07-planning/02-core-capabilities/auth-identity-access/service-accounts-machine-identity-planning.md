<!--
DOC-META
title: Service Accounts, Non-Human Identity, And Machine Assurance Planning
doc_type: planning
status: planning
owner: identity
canonical: true
canonical_path: docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Plans Service Accounts and other NHI forms while keeping Machine Identity, Network Identity, and Network Context independent assurance layers.
-->

# Service Accounts, Non-Human Identity, And Machine Assurance Planning

Parent: [Planning Index](../../index.md)

## 1. Purpose

Plan Service Accounts and other Non-Human Identity forms before API, webhook, integration, workload, and automation authentication is implemented.

This document follows [ADR-0006](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md).

## 2. Canonical Identity Model

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

Request Assurance Context
├── Machine Identity
├── Network Identity
└── Network Context
```

`Service Identity` is not the canonical umbrella.

Machine Identity is independent from NHI and may accompany either human or non-human Principals.

## 3. Ownership Boundary

| Owner                        | Responsibility                                                                    |
| ---------------------------- | --------------------------------------------------------------------------------- |
| Core/Identity                | NHI record, stable key, type, owner, purpose, lifecycle state, Instance scope     |
| Core/Auth                    | authentication mechanism, credential verification, token and assertion validation |
| Core/Access                  | permissions, policies, resource boundaries, least privilege                       |
| Core/Security/Secrets        | credential handling, storage rules, references, rotation, redaction               |
| Core/Audit                   | Actor attribution and NHI lifecycle/use history                                   |
| Core/Monitoring              | failed authentication, unexpected use, stale NHI, anomalous volume                |
| Core/Notifications           | expiry, rotation, disabled-use, and abnormal-use alerts                           |
| Core/VulnerabilityManagement | exposed credentials, stale access, weak rotation, excessive privilege             |

Do not model an NHI as a Human User Account.

## 4. NHI Types

### Service Account

Persistent lifecycle-managed NHI account for a service, integration, automation process, synchronization process, application, or managed machine use case.

### Workload Identity

NHI assigned to an executing workload or workload class. It may be short-lived, federated, certificate-backed, attested, or managed by infrastructure.

### Application Principal

Authorized representation of an application, API client, external SaaS product, or connector.

Not every NHI requires a Service Account.

## 5. Instance Scope

Each locally managed NHI must state its permitted Tenant and Instance scope.

No NHI may silently authorize another Instance.

Global Administration NHI access requires explicit target Tenant and Instance scope and the same audit and step-up rules applicable to cross-Instance administration.

## 6. Initial NHI Attributes

Applicable NHI records should eventually support:

- stable key;
- type;
- display name;
- purpose and description;
- human or organizational owner;
- Tenant and Instance scope;
- environment;
- lifecycle status;
- credential type or credential reference;
- allowed Actions;
- resource constraints;
- expiry or review date;
- rotation policy;
- last-used timestamp;
- created-by evidence;
- disabled or revoked timestamp.

## 7. Machine And Network Assurance

Machine Identity may accompany an NHI but is not owned by it.

Applicable evidence includes:

- machine identity ID;
- device or node ID;
- certificate or public-key fingerprint;
- key ID;
- attestation result;
- compliance state;
- management state.

Network Identity may represent a verified ZTNA session, VPN session, gateway, proxy, mTLS peer, service-mesh peer, or appliance.

Network Context may include source IP, proxy chain, ASN, geolocation, protocol, TLS properties, and risk signals.

Do not infer Machine or Network Identity from IP address alone.

## 8. Invocation Channels

NHI Actions may execute through:

- `api_request`;
- `webhook_request`;
- `console_command`;
- `queued_job`;
- `event_consumer`;
- `scheduled_task`;
- `internal_system`.

The channel is execution metadata, not the NHI.

## 9. Credential Handling

Potential credential mechanisms include:

- generated API token;
- client secret;
- OAuth client credential;
- signed assertion;
- federated token;
- certificate or key proof;
- webhook signing secret;
- managed identity;
- workload attestation.

Rules:

- show generated tokens once when applicable;
- store prefix plus hash when only verification is needed;
- encrypt reusable credentials or store vault references;
- keep infrastructure secrets in approved host or vault storage;
- never log raw credentials;
- keep credentials separate from Principal identity.

Auth owns verification. Secrets owns handling rules.

## 10. Access Model

NHI access defaults to least privilege:

- explicit Tenant and Instance scope;
- explicit Actions and resources;
- no broad inherited human role;
- no interactive web login unless explicitly approved;
- no MFA bypass by pretending to be human;
- no ownerless NHI;
- no cross-Instance authority by default;
- no object-level authorization bypass.

Sensitive use requires explicit permission, owner, audit, rotation or expiry policy, and review cadence.

## 11. Actor, Audit, And Monitoring

NHI audit events should include applicable:

- Principal type and ID;
- NHI type and stable key;
- owner;
- Machine Identity;
- Network Identity;
- Network Context;
- Invocation Channel;
- Action;
- Target;
- Result;
- Tenant and Instance;
- safe credential fingerprint;
- correlation identifiers.

Monitoring should detect failed authentication spikes, unexpected source or Machine Identity, stale NHI, disabled-use attempts, expiry, rotation failure, abnormal volume, and unauthorized channel use.

## 12. Storage Decision

The exact Service Account storage model is intentionally deferred to bounded M1 capability/schema planning.

Candidate models remain:

```text
users.type = service
```

or:

```text
service_accounts
```

or another explicit NHI model.

M0 issue #7 was closed as not planned because selecting the exact table/relationship strategy is not an M0 prerequisite. No storage model is accepted by that closure.

The first bounded M1 slice that requires persistent Service Account/NHI storage must resolve this decision together with:

- the applicable behavior Contract;
- exact database Contract;
- migration and compatibility requirements;
- verification-first proof;
- implementation scope and non-goals.

## 13. Implementation Sequence

1. retain the accepted NHI vocabulary and Actor shape;
2. resolve Service Account storage in the bounded M1 slice that first requires persistence;
3. define the minimal NHI lifecycle Contract;
4. define the credential and verification Contract;
5. define Access scope and review rules;
6. define Audit, Monitoring, and Notification coverage;
7. implement one bounded authentication method;
8. add API, webhook, queue, event, command, and schedule integrations incrementally.

This sequence is planning direction, not current GitHub Project priority.

## 14. Future Verification

Future proofs should demonstrate, as applicable:

- NHI cannot use normal human interactive login unless approved;
- disabled or revoked NHI fails;
- NHI cannot access another Instance;
- generated tokens are not stored raw;
- credentials do not enter logs or exports;
- Audit records the NHI Principal and Invocation Channel;
- Machine Identity remains separate from NHI;
- source IP is not accepted as authoritative identity;
- privileged NHI access requires explicit scope and review.

Exact `AC-*` and `PF-*` mappings belong to the bounded M1 issue that implements the behavior.

## 15. Transition Rules

- do not use `Service Identity` as the umbrella;
- do not model jobs, commands, schedules, or webhooks as NHI records;
- do not create ownerless NHI;
- do not store raw secrets;
- do not grant global or cross-Instance access implicitly;
- do not place Machine Identity under NHI;
- do not implement storage through drift;
- do not treat closure of M0 issue #7 as acceptance of a storage model.

## 16. Deferred M1 Decisions

These decisions remain explicit planning inputs and do not reopen M0:

- Service Account storage model;
- first NHI authentication method;
- first rotation and expiry policy;
- approval requirements for privileged NHI;
- persistent notification types;
- first access-review integration;
- provider-specific machine and network assurance.

## 17. Out Of Scope

This planning document does not itself authorize:

- implementing NHI;
- creating migrations;
- implementing OAuth, OIDC, SPIFFE, or federation;
- selecting provider integrations;
- changing current runtime behavior.

## 18. Related

- [ADR-0006](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Core Service Build Plan Matrix](../../core-service-build-plan-matrix.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
