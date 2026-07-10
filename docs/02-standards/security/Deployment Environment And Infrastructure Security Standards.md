<!--
DOC-META
title: Deployment Environment And Infrastructure Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Deployment Environment And Infrastructure Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines environment separation, configuration, infrastructure hardening, database exposure, deployment evidence, production access, rollback, and runtime verification.
-->

# Deployment Environment And Infrastructure Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Environment Separation](#2-environment-separation)
- [3. Source Of Truth](#3-source-of-truth)
- [4. Configuration](#4-configuration)
- [5. Production Access](#5-production-access)
- [6. Host And Network](#6-host-and-network)
- [7. Database Security](#7-database-security)
- [8. Storage](#8-storage)
- [9. Deployment](#9-deployment)
- [10. Rollback And Database Limits](#10-rollback-and-database-limits)
- [11. Runtime Security](#11-runtime-security)
- [12. Drift](#12-drift)
- [13. Backups](#13-backups)
- [14. Completion](#14-completion)
- [15. Related](#15-related)

## 1. Purpose

Define security requirements for local, test, staging, and production environments and the infrastructure and deployment processes that operate them.

## 2. Environment Separation

Each environment must have explicit purpose, data classification, credentials, domains and certificates, database, storage, mail behavior, integrations, access rules, monitoring, and reset and recovery rules.

Production secrets and data must not be copied into lower environments without approved protection.

## 3. Source Of Truth

Code and versioned non-secret configuration must originate from the repository.

Production server state must not become the sole source of truth.

Manual server changes require reconciliation into approved automation or documentation.

## 4. Configuration

Configuration must be environment-specific, reviewed, reproducible where practical, secret-safe, validated before deployment, checked for drift, and linked to evidence.

Do not commit production secret values.

## 5. Production Access

Production access must be least privilege, named and attributable, MFA-protected where available, limited to approved operations, auditable, and revoked when no longer needed.

Shared administrator accounts are prohibited.

## 6. Host And Network

Harden firewall exposure, SSH, web server, PHP-FPM, database, Redis, queue and realtime services, file permissions, service users, update process, and time synchronization.

Database, Redis, and internal services must not be publicly exposed unless an explicit architecture and control set requires it.

## 7. Database Security

Use least-privilege runtime credentials, separated migration/admin privileges when feasible, encrypted transport across trust boundaries, restricted network access, private backups, audited administrative access, and restore validation.

Do not expose raw connection strings in evidence.

## 8. Storage

Application writable paths must use least privilege.

Do not use world-writable permissions.

Sensitive storage, logs, backups, exports, and evidence must remain outside public web access.

## 9. Deployment

Deployments must use committed state, identify branch and SHA, verify dependencies and build, review migrations, clear and rebuild caches appropriately, restart long-lived services, verify runtime and application health, preserve prior release identity, maintain rollback or recovery boundaries, and record evidence.

## 10. Rollback And Database Limits

Code rollback must not be assumed safe after incompatible forward migrations.

A deployment must identify prior release, database compatibility, rollback trigger, recovery procedure, backup dependency, and escalation.

## 11. Runtime Security

Production must verify debug disabled, HTTPS, proxy trust, secure cookies, session protection, HSTS when safe, security headers, service health, scheduler, queue, realtime, storage permissions, and non-public internal ports.

## 12. Drift

Review drift in package versions, server config, virtual hosts, service units, firewall, environment keys, file permissions, scheduled tasks, and deployment scripts.

Unexpected drift requires issue ownership.

## 13. Backups

Production maturity requires backup procedure, protected storage, retention, monitoring, restore procedure, restore drill, and failure notification.

A backup without restore validation is not proven recovery.

## 14. Completion

An environment is security-ready when server readiness, deployment verification, runtime checks, service health, backup expectations, and required evidence pass.

## 15. Related

- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Cloud And Deployment Hardening Planning](../../07-planning/02-core-capabilities/security/cloud-deployment-hardening-planning.md)
- [Runbook Index](../../10-runbooks/index.md)
