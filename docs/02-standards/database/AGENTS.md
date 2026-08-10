# AGENTS.md

## 1. Folder Purpose

This folder owns database standards for Login App 2.0.

Use this file to guide Codex and other AI agents working inside `docs/02-standards/database/`.

This file is agent-facing routing guidance, not a canonical database standard. Canonical rules remain in the Markdown standards files in this folder.

- [1. Folder Purpose](#1-folder-purpose)
- [2. Ownership](#2-ownership)
- [3. Required Reading Before Editing](#3-required-reading-before-editing)
- [4. Canonical Owners To Check](#4-canonical-owners-to-check)
- [5. Current Database Assumptions](#5-current-database-assumptions)
- [6. File And Shape Rules](#6-file-and-shape-rules)
- [7. Database Standards Rules](#7-database-standards-rules)
- [8. Testing And Verification](#8-testing-and-verification)
- [9. Stop Conditions](#9-stop-conditions)
- [10. Related](#10-related)

---

## 2. Ownership

This folder may contain standards that govern:

- PostgreSQL schema design
- Laravel migration safety
- table documentation contracts
- tenant/workspace/account/customer/module scope isolation
- access-control data models
- audit and evidence data models
- data classification and retention
- settings and preference data governance
- registry-backed data
- database documentation expectations

This folder must not contain:

- table documentation files
- database feature contracts
- migration source files
- model source files
- seed data
- feature behavior docs
- architecture owner docs
- implementation planning notes
- operational runbooks
- source research
- copyable templates
- AI worklogs

Table documentation belongs in:

- `docs/06-database/tables/`

Database feature contracts belong in:

- `docs/06-database/feature-contracts/`

Planning belongs in:

- `docs/07-planning/`

Operational procedures belong in:

- `docs/10-runbooks/`

---

## 3. Required Reading Before Editing

Before editing this folder, read:

- root `AGENTS.md`
- `docs/AGENTS.md` if present
- `docs/02-standards/AGENTS.md` if present
- `docs/02-standards/database/index.md`
- `docs/02-standards/database/Schema Design Standards.md`
- `docs/02-standards/database/Database Migration Standards.md`
- `docs/02-standards/database/Database Table Contract Standards.md`

When changing scope, tenancy, workspace, account, customer, module, or cross-boundary rules, also read:

- `docs/02-standards/database/Database Tenant Workspace Isolation Standards.md`

When changing auth, identity, roles, permissions, groups, service accounts, elevated access, or access reviews, also read:

- `docs/02-standards/database/Database Access Control Data Model Standards.md`

When changing audit, evidence, forensic readiness, security events, or chain-of-custody rules, also read:

- `docs/02-standards/database/Database Audit And Evidence Standards.md`

When changing sensitive data, classification, retention, deletion, anonymization, masking, or export rules, also read:

- `docs/02-standards/database/Database Data Classification And Retention Standards.md`

When changing settings, preferences, setup metadata, notification type metadata, module registries, contribution registries, or seeded keys, also read:

- `docs/02-standards/database/Settings Data Governance Standards.md`
- `docs/02-standards/database/Database Registry Data Standards.md`

When changing documentation metadata, templates, index, or docs-sync expectations, also read:

- `docs/02-standards/documentation/How To Write Docs.md`
- `docs/02-standards/documentation/Doc Governance.md`
- `docs/02-standards/documentation/Documentation Review Standards.md`
- `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`

Prefer targeted section reads over loading unrelated standards or reference material.

---

## 4. Canonical Owners To Check

When work in this folder affects durable database behavior, keep ownership clear.

| Change Type                                                                               | Canonical Owner                                                                      |
| ----------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| PostgreSQL schema naming, relationships, types, indexes, and constraints                  | `docs/02-standards/database/Schema Design Standards.md`                              |
| Laravel migration safety, backfills, rollback, destructive changes, and seeders           | `docs/02-standards/database/Database Migration Standards.md`                         |
| Required table documentation shape                                                        | `docs/02-standards/database/Database Table Contract Standards.md`                    |
| Tenant/workspace/account/customer/module scope isolation                                  | `docs/02-standards/database/Database Tenant Workspace Isolation Standards.md`        |
| Access-control data shape                                                                 | `docs/02-standards/database/Database Access Control Data Model Standards.md`         |
| Audit, evidence, forensic, and chain-of-custody data shape                                | `docs/02-standards/database/Database Audit And Evidence Standards.md`                |
| Classification, retention, deletion, anonymization, masking, and export eligibility       | `docs/02-standards/database/Database Data Classification And Retention Standards.md` |
| Settings, preferences, scoped config, and sensitive setting governance                    | `docs/02-standards/database/Settings Data Governance Standards.md`                   |
| Registry-backed data, stable keys, contribution metadata, and idempotent registry seeders | `docs/02-standards/database/Database Registry Data Standards.md`                     |
| Table documentation                                                                       | `docs/06-database/tables/`                                                           |
| Database feature contracts                                                                | `docs/06-database/feature-contracts/`                                                |
| Operational database procedures                                                           | `docs/10-runbooks/`                                                                  |

Do not leave durable database rules only in this `AGENTS.md`.

---

## 5. Current Database Assumptions

PostgreSQL is the active database target.

Use PostgreSQL-compatible terminology and avoid MySQL/Perfex assumptions unless explicitly discussing legacy reference material.

Do not reintroduce V1 Perfex `install.php` or `tbl`-prefixed schema conventions as active Login App 2.0 standards.

Use current project vocabulary:

- Core capability
- Module
- UI
- Laravel integration
- Surface
- Delivery Adapter
- Registry
- Planning Document
- canonical owner
- implementation slice
- GitHub issue
- GitHub Project

Surface, Delivery Adapter, Registry, and other technical responsibilities must be classified beneath an explicit Core, Module, or UI owner. Existing `app/Platform/*` paths describe transitional current placement only and must not be treated as target ownership or a destination for new canonical work.

---

## 6. File And Shape Rules

When creating or materially rewriting database standards in this folder:

- include a `DOC-META` header block
- use portable Markdown links for important references
- link to the parent index
- update `docs/02-standards/database/index.md`
- update `docs/02-standards/index.md` when the standard should be visible from the branch index
- keep standards enforceable and concise
- keep examples current with PostgreSQL and Laravel migrations
- avoid mixing standards, planning, architecture, research, and implementation checklists in one file

Do not use this folder for copyable templates.

Do not require Obsidian-only links. Markdown links are required; Obsidian links are optional graph aids only.

---

## 7. Database Standards Rules

Database standards in this folder should define:

- what rule applies
- when it applies
- where the canonical owner lives
- what table docs or database indexes must be updated
- what testing or verification is expected
- what stop conditions apply
- how Core, Module, UI, and Laravel integration boundaries affect database design

Testing and verification result semantics are owned by `docs/02-standards/testing/`.

Repository-specific test-source construction is owned by `docs/02-standards/coding/test-implementation/`. Link to those owners instead of redefining their rules here.

They should not:

- duplicate full table docs
- duplicate migration source code
- include broad historical commentary
- preserve deprecated Perfex module behavior as active rules
- reintroduce deprecated `/docs/08-active` workflow language
- introduce conflicting terminology for Core, Modules, UI, Laravel integration, or Planning
- define one-off rules for a single table unless they are being promoted into a reusable standard

---

## 8. Testing And Verification

For changes in this folder, verification is usually documentation review rather than automated tests.

Expected checks:

- confirm every new or materially rewritten standard has `DOC-META`
- confirm important links are Markdown links
- confirm the database standards index is updated
- confirm the branch standards index is updated when needed
- confirm related database standards do not contradict each other
- confirm examples use PostgreSQL, Laravel migrations, and current project vocabulary
- confirm deprecated Perfex migration/module language was not reintroduced as active guidance
- confirm deprecated Phase or `docs/08-active` language was not reintroduced
- confirm rules remain enforceable, not just advisory prose
- confirm table docs under `docs/06-database/tables/` are referenced where appropriate

If a docs guardrail script exists, run it or report that it was not run.

---

## 9. Stop Conditions

Stop and ask before editing when:

- two database standards conflict
- the correct canonical owner is unclear
- a change would move standards across branches
- a standard would change PostgreSQL assumptions
- a standard would change Core, Module, or UI ownership or Laravel integration boundaries
- a standard would affect auth, access, audit, security, data governance, data protection, retention, deletion, exports, or deployment beyond database documentation
- a change would require broad link rewrites
- a change would rename many files or paths
- the requested change is better owned by coding, security, documentation, planning, runbook, table docs, AGENTS, or skill guidance

---

## 10. Related

- [Database Standards Index](index.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Database Tenant Workspace Isolation Standards](Database%20Tenant%20Workspace%20Isolation%20Standards.md)
- [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)
- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)
- [Database Data Classification And Retention Standards](Database%20Data%20Classification%20And%20Retention%20Standards.md)
- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Database Registry Data Standards](Database%20Registry%20Data%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)
- [Testing Standards Index](../testing/index.md)
- [Test Implementation Standards Index](../coding/test-implementation/index.md)
