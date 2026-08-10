<!--
DOC-META
title: Standards Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/index.md
parent: docs/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes canonical Login 2.0 coding, testing, database, security, logging, UI, documentation, and coding-agent standards.
-->

# Standards Index

Parent: [Documentation Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Canonical Standards Areas](#3-canonical-standards-areas)
  - [3.1. Coding](#31-coding)
  - [3.2. Testing And Verification](#32-testing-and-verification)
  - [3.3. Database](#33-database)
  - [3.4. Security](#34-security)
  - [3.5. Logging](#35-logging)
  - [3.6. UI](#36-ui)
  - [3.7. Documentation](#37-documentation)
  - [3.8. Coding Agents](#38-coding-agents)
- [4. Responsibility Routing](#4-responsibility-routing)
- [5. Authority Boundaries](#5-authority-boundaries)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

Provide the canonical navigation hub for enforceable Login 2.0 implementation, verification, data, security, observability, UI, documentation, and coding-agent standards.

Use this index to locate the standards area that owns a rule. Use the child index for detailed standards within that area.

## 2. Scope

`docs/02-standards/` owns enforceable rules, conventions, and review requirements.

This branch does not own:

- architecture structure or repository topology;
- feature or capability behavior;
- cross-capability execution flows;
- exact schema and table contracts;
- implementation sequencing or planning state;
- reference research or templates;
- executable operational procedures;
- active GitHub issue or Project status.

Route those responsibilities to their canonical owners rather than duplicating them in standards.

## 3. Canonical Standards Areas

| Area                     | Canonical index                                         | Owns                                                                                                                                                                                                                          |
| ------------------------ | ------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Coding                   | [Coding Standards Index](coding/index.md)               | Application coding, file construction, naming, PHP and Laravel style, application-layer roles, reliability-oriented coding rules, test-source implementation, generators, Git scope, and implementation-readiness conventions |
| Testing and verification | [Testing Standards Index](testing/index.md)             | Proof design, `AC-*` and `PF-*`, verification methods and levels, applicability and results, initial proof, protected baselines, environments, specialist testing, evidence, and testing gates                                |
| Database                 | [Database Standards Index](database/index.md)           | PostgreSQL schema-design rules, migrations, table-contract standards, isolation, access-control data, audit evidence, data classification, settings, and registry data                                                        |
| Security                 | [Security Standards Index](security/index.md)           | Security, identity, access, scope, application security, data protection, delivery assurance, vulnerability management, threat detection, evidence, and incident-response requirements                                        |
| Logging                  | [Logging Standards Index](logging/index.md)             | Audit logging, operational monitoring, error logging, telemetry, health, alerting, correlation, and evidence requirements                                                                                                     |
| UI                       | [UI Standards Index](ui/index.md)                       | Foundation Elements, Components, Patterns, UI public APIs, UI contracts, rendered evidence requirements, and reusable interface-system rules                                                                                  |
| Documentation            | [Documentation Standards Index](documentation/index.md) | Documentation authoring, document types, planning and decision documentation, runbook-document standards, governance, structure, review, and implementation synchronization                                                   |
| Coding agents            | [Coding Agent Standards Index](coding-agents/index.md)  | Durable coding-agent instruction surfaces, skills, context, worktree concurrency, repo-local memory, working documents, and promotion rules                                                                                   |

### 3.1. Coding

Start with the [Coding Standards Index](coding/index.md).

Use coding standards for how repository source is implemented.

For test source specifically, use the [Test Implementation Standards Index](coding/test-implementation/index.md).

Testing and verification policy does not belong under `coding/`; use the [Testing Standards Index](testing/index.md).

### 3.2. Testing And Verification

Start with the [Testing Standards Index](testing/index.md).

This area is the canonical owner for:

- testing and verification terminology;
- acceptance-to-proof mapping;
- proof lifecycle and state;
- initial proof and protected verification baselines;
- automated, integration, system, acceptance, reliability, performance, compatibility, operational, UI, accessibility, and browser proof;
- environment and fixture validity;
- verification evidence and testing gates.

Repository-specific test-source construction remains with the [Test Implementation Standards Index](coding/test-implementation/index.md).

### 3.3. Database

Start with the [Database Standards Index](database/index.md).

Database standards define how PostgreSQL schema, migrations, persistence isolation, database evidence, settings data, and registry-backed data must be designed and reviewed.

Exact table contracts belong under `docs/06-database/`.

### 3.4. Security

Start with the [Security Standards Index](security/index.md).

Security standards define required controls and security-specific acceptance requirements.

The Testing Standards suite defines how required security proof is declared, executed, classified, and reported. Security standards remain authoritative for what security behavior is required.

### 3.5. Logging

Start with the [Logging Standards Index](logging/index.md).

Use logging standards to distinguish accountable audit evidence from operational monitoring, errors, health, telemetry, and alerts.

### 3.6. UI

Start with the [UI Standards Index](ui/index.md).

UI standards own reusable interface-system APIs and design-system requirements.

Repository source topology and transitional placement remain governed by [Repository Architecture](../03-architecture/repository-architecture.md). Do not duplicate transitional source-tree inventories in this top-level standards index.

UI testing and accessibility proof methods are governed by the [Testing Standards Index](testing/index.md), while individual UI standards remain authoritative for the UI behavior and public Contract being verified.

### 3.7. Documentation

Start with the [Documentation Standards Index](documentation/index.md).

Documentation standards own writing, metadata, document types, branch placement, lifecycle, review, governance, and synchronization rules.

Reusable copyable templates belong under `docs/09-reference/templates/`, not in this standards branch.

### 3.8. Coding Agents

Start with the [Coding Agent Standards Index](coding-agents/index.md).

Coding-agent standards own durable repository-facing agent governance.

Root and scoped `AGENTS.md` files, `.agents/skills/`, GitHub issues, GitHub Projects, and canonical docs retain their separate responsibilities.

## 4. Responsibility Routing

| Question                                                               | Start here                                                                   |
| ---------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| How should application or framework source be implemented?             | [Coding Standards Index](coding/index.md)                                    |
| How should test source be written or organized?                        | [Test Implementation Standards Index](coding/test-implementation/index.md)   |
| What must be proven, in which environment, and with what evidence?     | [Testing Standards Index](testing/index.md)                                  |
| How should PostgreSQL schema or migration behavior be designed?        | [Database Standards Index](database/index.md)                                |
| What security control or security behavior is required?                | [Security Standards Index](security/index.md)                                |
| Is this audit evidence or operational monitoring?                      | [Logging Standards Index](logging/index.md)                                  |
| What UI API, Component, Pattern, Element, or design rule applies?      | [UI Standards Index](ui/index.md)                                            |
| Where should documentation live and how should it be governed?         | [Documentation Standards Index](documentation/index.md)                      |
| How should Codex or another coding agent be instructed or coordinated? | [Coding Agent Standards Index](coding-agents/index.md)                       |

When one task crosses areas, read the smallest set of applicable owners.

Do not copy a specialist rule into another standards area merely to make it easier to find.

## 5. Authority Boundaries

Use the documentation branch that owns the type of truth:

| Branch                  | Owns                                                                        |
| ----------------------- | --------------------------------------------------------------------------- |
| `docs/01-decisions/`    | Accepted elevated decisions and rationale                                   |
| `docs/02-standards/`    | Enforceable standards and conventions                                       |
| `docs/03-architecture/` | System structure, boundaries, ownership, and topology                       |
| `docs/04-features/`     | User and system behavior                                                    |
| `docs/05-flows/`        | Cross-capability execution paths                                            |
| `docs/06-database/`     | Exact schema, table, constraint, and persistence contracts                  |
| `docs/07-planning/`     | Planning intent, sequencing, decomposition, and unresolved target analysis  |
| `docs/09-reference/`    | Non-canonical research, examples, legacy references, and reusable templates |
| `docs/10-runbooks/`     | Repeatable operator-executable procedures                                   |
| `docs/11-ai/`           | Non-canonical agent working documents and review candidates                 |

GitHub issues own bounded work packets.

GitHub Projects own active delivery state.

Root and scoped `AGENTS.md` files own persistent agent operating instructions.

`.agents/skills/` owns repeatable agent procedures.

## 6. Maintenance

When adding, moving, splitting, superseding, or removing a standards area or canonical standards index:

- update this index in the same change;
- update the child index;
- preserve one clear canonical owner;
- remove or supersede competing authorities;
- update active inbound references where practical;
- preserve compatibility pointers when heavily linked paths need a transition period;
- keep non-canonical reference material out of the canonical standards list;
- run documentation guardrails and link validation when available.

Do not maintain duplicate lists of every child standard here.

Detailed inventories belong in the applicable child index.

## 7. Related

- [Documentation Index](../index.md)
- [Documentation Start](../00-start-here.md)
- [Architecture Index](../03-architecture/index.md)
- [Features Index](../04-features/index.md)
- [Flows Index](../05-flows/index.md)
- [Database Index](../06-database/index.md)
- [Planning Index](../07-planning/index.md)
- [Runbook Index](../10-runbooks/index.md)
- [Legacy V1 Perfex Module Development Standards](../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md)
