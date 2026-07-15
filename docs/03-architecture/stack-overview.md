<!--
DOC-META
title: Stack Overview
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/stack-overview.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines the accepted application, data, runtime, frontend-build, local-development, and production technology stack for Login 2.0.
-->

# Stack Overview

Parent: [Architecture Index](index.md)

## 1. Purpose

This document is the canonical architecture owner for the Login 2.0 technology stack and the high-level responsibility of each stack layer.

It identifies the accepted framework, language, persistence, runtime-support, asset-build, local-development, and production technologies.

Repository ownership and physical source placement are defined by [Repository Architecture](repository-architecture.md). Tenant, Workspace, Principal, and execution relationships are defined by [System Overview](system-overview.md).

## 2. Status

- Architecture state: active
- Application framework: Laravel `13.x`
- PHP runtime target: PHP `8.3`
- Primary relational database: PostgreSQL `16`
- Runtime support: Redis `7`
- Frontend build: Vite
- Local orchestration: Docker Compose
- Planned production web runtime: Apache with PHP-FPM
- UI rendering: Blade, with Livewire used selectively where reactive server-driven behavior is justified

Exact installed versions remain verified through repository configuration, dependency manifests, container definitions, and deployment configuration.

## 3. Stack Summary

| Layer | Technology | Responsibility |
| --- | --- | --- |
| Language and runtime | PHP `8.3` | Executes Laravel application code |
| Application framework | Laravel `13.x` | Framework integration, routing, middleware, validation, service composition, queues, console integration, and application bootstrapping |
| Server-rendered UI | Blade | Primary rendering technology for application views and reusable UI presentation |
| Reactive server UI | Livewire | Selective reactive behavior where a server-driven interaction model is appropriate |
| Relational persistence | PostgreSQL `16` | Authoritative relational system of record |
| Runtime support | Redis `7` | Cache, queue, locks, and other approved transient infrastructure |
| Frontend build | Vite | CSS and JavaScript compilation, development server integration, and production asset builds |
| Local environment | Docker Compose | Repeatable local service orchestration |
| Production web runtime | Apache and PHP-FPM | HTTP serving, proxying, and PHP process execution |

A technology layer does not create an application owner. Core, Modules, and UI remain the application source-of-truth owners.

## 4. Application Framework

Laravel is the application framework and integration center.

Laravel provides or coordinates:

- application bootstrapping;
- HTTP routing and middleware;
- request validation;
- service-container composition;
- console integration;
- queues and scheduled execution;
- logging integration;
- framework configuration;
- database integration;
- test application bootstrapping.

Laravel does not own capability or Module behavior merely because that behavior uses Laravel classes or conventions.

Owner-specific implementations remain with their Core, Module, or UI owner. Application-wide framework integration remains in the restricted Laravel integration branches defined by Repository Architecture.

## 5. UI Rendering

Blade is the primary server-rendered presentation technology.

UI responsibilities remain divided by ownership:

- UI owns reusable Elements, Components, Patterns, Layouts, presentation contracts, and reusable UI runtime infrastructure;
- Core capabilities own their application-specific Surfaces;
- Modules own their package-specific Surfaces;
- Laravel and Vite provide rendering and build integration without becoming presentation owners.

Livewire may be used when a server-driven reactive interaction is justified by the owning Surface. Livewire is a framework implementation choice, not a peer architecture owner or default location.

The target source model uses artifact-owned presentation bundles as defined by [Repository Architecture](repository-architecture.md).

## 6. Data And Persistence

PostgreSQL is the authoritative relational system of record.

The current central application database stores the Tenant registry and other application-wide data. This responsibility does not create a `Platform` application owner.

The target tenancy direction may use separate Tenant databases and PostgreSQL roles where required by the accepted tenancy and database architecture.

Database schema, migration, table-contract, isolation, and access requirements remain governed by:

- `docs/02-standards/database/`;
- `docs/06-database/`;
- [Tenancy](tenancy.md);
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md).

## 7. Runtime Support

Redis provides approved transient runtime infrastructure, including applicable:

- cache storage;
- queue coordination;
- distributed locks;
- rate-limiting support;
- other bounded ephemeral state.

Redis is not the authoritative store for business records, durable configuration, audit evidence, or other data requiring relational persistence.

The owning capability or Module remains responsible for the behavior using Redis.

## 8. Frontend Build

Vite is the frontend asset-build system.

It owns:

- development asset serving;
- CSS and JavaScript compilation;
- module bundling;
- production asset generation;
- Laravel asset-pipeline integration.

The primary application entrypoints are:

```text
resources/css/app.css
resources/js/app.js
```

These entrypoints compose owner-local and UI-owned source. They must not become generic feature implementation files.

Vite does not own application state or UI behavior.

## 9. Local Development

Docker Compose is the standard local orchestration contract for application services such as:

- PHP/Laravel;
- Node/Vite;
- PostgreSQL;
- Redis;
- mail tooling;
- other explicitly configured local dependencies.

Repository tooling must discover the active Git root and must not depend on workstation-specific or network-drive paths.

Contributors may use additional native tooling only when the repository’s required environment and verification contracts remain reproducible.

## 10. Production Runtime

The planned production web runtime uses Apache with PHP-FPM.

Operational configuration belongs beneath:

```text
ops/
```

Executable deployment and validation orchestration belongs beneath:

```text
scripts/
```

Human deployment and recovery procedures belong beneath:

```text
docs/10-runbooks/
```

Production configuration should remain explicit, reviewable, and free of embedded secrets.

## 11. Stack Boundaries

The following boundaries apply:

- Laravel is framework integration, not an application owner.
- Blade and Livewire are presentation technologies, not owner roots.
- PostgreSQL and Redis are infrastructure technologies, not behavior owners.
- Vite is an asset-build system, not an application-state manager.
- Docker Compose defines local orchestration, not production architecture.
- Apache and PHP-FPM define production serving mechanics, not application ownership.
- Current technology-specific paths do not override the accepted target repository topology.

## 12. Maintenance

Update this document when:

- a stack technology is accepted, replaced, or removed;
- the target runtime version changes;
- a technology’s architectural responsibility changes;
- local or production architecture changes materially.

Do not use this document to track dependency-update progress, migration tasks, implementation status, or operational procedures.

## 13. Related

- [Architecture Index](index.md)
- [System Overview](system-overview.md)
- [Repository Architecture](repository-architecture.md)
- [Tenancy](tenancy.md)
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)
- [Database Standards Index](../02-standards/database/index.md)
- [Goal 3 Target Repository Architecture](../07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 2 Stack And UI System Notes](../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
