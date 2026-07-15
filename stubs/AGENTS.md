# AGENTS.md

## Folder Purpose

This folder owns coding and implementation standards for Login App 2.0.

Use this file to guide Codex and other AI agents working inside `docs/02-standards/coding/`.

This file is agent-facing routing guidance, not a canonical coding standard. Durable coding rules remain in the Markdown standards files in this folder.

---

## Ownership

This folder may contain standards that govern:

- general application coding rules
- PHP and Laravel conventions
- file ownership and file construction
- file archetypes
- actions, services, queries, DTOs, value objects, enums, and result objects
- source templates, placeholders, generators, and generated-output validation
- comments, PHPDoc, TODOs, and file headers
- error and exception handling
- transactions, concurrency, retries, and idempotency
- events, listeners, jobs, queues, and scheduled work
- query design, pagination, caching, and performance
- feature and capability development
- testing and verification
- agent implementation checklists for coding work

This folder must not contain:

- architecture owner documents
- canonical feature behavior documents
- database schema or table contracts
- implementation planning notes
- operational runbooks
- source research
- executable source templates
- documentation templates
- AI review artifacts
- implementation worklogs
- issue-specific coding instructions

Repository-owned source templates belong in:

- `stubs/framework/`
- `stubs/archetypes/`
- `stubs/tests/`
- `stubs/ui/`

Documentation templates belong in:

- `docs/09-reference/templates/docs/`
- `docs/09-reference/templates/agents/`

Template and generator policy belongs in:

- `docs/02-standards/coding/Code Template And Generator Standards.md`

Documentation-system standards belong in:

- `docs/02-standards/documentation/`

Database standards belong in:

- `docs/02-standards/database/`

UI standards belong in:

- `docs/02-standards/ui/`

Security standards belong in:

- `docs/02-standards/security/`

Architecture truth belongs in:

- `docs/03-architecture/`

Feature behavior belongs in:

- `docs/04-features/`

Database contracts belong in:

- `docs/06-database/`

Planning belongs in:

- `docs/07-planning/`

Operational procedures belong in:

- `docs/10-runbooks/`

---

## Required Reading Before Editing

Before editing this folder, read:

- root `AGENTS.md`
- `docs/AGENTS.md` if present
- `docs/02-standards/AGENTS.md` if present
- `docs/02-standards/coding/index.md`
- `docs/02-standards/coding/Coding Standards.md`
- `docs/02-standards/coding/File Building Standards.md`
- `docs/02-standards/coding/Testing Standards.md`

When creating or changing file-shape guidance, also read:

- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/PHP And Laravel Style Standards.md`
- `docs/02-standards/coding/Commenting Standards.md`

When changing source-template, placeholder, generator, framework-override, or generated-output rules, also read:

- `docs/02-standards/coding/Code Template And Generator Standards.md`
- `stubs/README.md`
- `stubs/AGENTS.md`
- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/File Building Standards.md`
- `docs/02-standards/coding/Commenting Standards.md`
- `docs/02-standards/coding/Testing Standards.md`

When changing application-object boundaries, also read:

- `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md`
- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/PHP And Laravel Style Standards.md`

When changing failure behavior, also read:

- `docs/02-standards/coding/Error And Exception Handling Standards.md`
- `docs/02-standards/logging/Logging Standards.md`
- relevant security standards when protected behavior is affected

When changing mutation, transaction, retry, or duplicate-delivery behavior, also read:

- `docs/02-standards/coding/Transaction Concurrency And Idempotency Standards.md`
- `docs/02-standards/coding/Events Jobs And Queue Standards.md`
- `docs/02-standards/coding/Error And Exception Handling Standards.md`

When changing events, jobs, listeners, queues, or scheduled commands, also read:

- `docs/02-standards/coding/Events Jobs And Queue Standards.md`
- `docs/02-standards/coding/Transaction Concurrency And Idempotency Standards.md`
- `docs/02-standards/coding/Testing Standards.md`

When changing queries, lists, exports, or performance rules, also read:

- `docs/02-standards/coding/Query And Performance Standards.md`
- `docs/02-standards/database/Schema Design Standards.md`
- `docs/02-standards/database/Database Tenant Workspace Isolation Standards.md`

When changing capability or feature development rules, also read:

- `docs/02-standards/coding/Feature Development Standards.md`
- `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`

When changing agent implementation behavior, also read:

- `docs/02-standards/coding/Agent Implementation Checklist.md`
- root `AGENTS.md`
- `docs/09-reference/templates/agents/_folder-agents.md`

When changing documentation metadata, documentation templates, indexes, or doc-sync expectations, also read:

- `docs/02-standards/documentation/How To Write Docs.md`
- `docs/02-standards/documentation/Doc Governance.md`
- `docs/02-standards/documentation/Documentation Review Standards.md`
- `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`

Prefer targeted section reads over loading unrelated standards or reference material.

---

## Canonical Owners To Check

When work in this folder affects durable coding behavior, keep ownership clear.

| Change Type                                                                                      | Canonical Owner                                                                       |
| ------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------- |
| General code structure, naming, validation, and ownership                                        | `docs/02-standards/coding/Coding Standards.md`                                        |
| PHP strictness, typing, dependency injection, container use, config, and Laravel style           | `docs/02-standards/coding/PHP And Laravel Style Standards.md`                         |
| File ownership and construction                                                                  | `docs/02-standards/coding/File Building Standards.md`                                 |
| Expected shape and responsibility of common file types                                           | `docs/02-standards/coding/File Archetypes.md`                                         |
| Source templates, placeholders, generators, framework overrides, and generated-output validation | `docs/02-standards/coding/Code Template And Generator Standards.md`                   |
| Actions, services, queries, DTOs, page data, value objects, enums, and results                   | `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md` |
| Comments, PHPDoc, TODOs, and file headers                                                        | `docs/02-standards/coding/Commenting Standards.md`                                    |
| Errors, exceptions, failure translation, and fail-open/fail-closed behavior                      | `docs/02-standards/coding/Error And Exception Handling Standards.md`                  |
| Transactions, concurrency, retries, locks, and idempotency                                       | `docs/02-standards/coding/Transaction Concurrency And Idempotency Standards.md`       |
| Events, listeners, jobs, queues, scheduling, and asynchronous behavior                           | `docs/02-standards/coding/Events Jobs And Queue Standards.md`                         |
| Queries, pagination, eager loading, bounded reads, caching, and performance                      | `docs/02-standards/coding/Query And Performance Standards.md`                         |
| Testing and verification expectations                                                            | `docs/02-standards/coding/Testing Standards.md`                                       |
| Feature and capability implementation rules                                                      | `docs/02-standards/coding/Feature Development Standards.md`                           |
| Codex implementation preflight and execution checklist                                           | `docs/02-standards/coding/Agent Implementation Checklist.md`                          |
| Current source-template inventory and operator instructions                                      | `stubs/README.md`                                                                     |
| Agent execution rules for source templates                                                       | `stubs/AGENTS.md`                                                                     |
| Database design, migrations, table contracts, and data isolation                                 | `docs/02-standards/database/`                                                         |
| Documentation metadata, structure, review, and synchronization                                   | `docs/02-standards/documentation/`                                                    |
| UI components, patterns, tokens, and visual standards                                            | `docs/02-standards/ui/`                                                               |
| Logging and operational log behavior                                                             | `docs/02-standards/logging/`                                                          |
| Security, auth, access, secrets, and protected data rules                                        | `docs/02-standards/security/`                                                         |

Do not leave durable coding rules only in this `AGENTS.md`.

Do not treat `stubs/README.md`, `stubs/AGENTS.md`, or individual `.stub` files as substitutes for canonical coding standards.

---

## Current Vocabulary

Use current project vocabulary consistently.

Preferred terms:

- Core capability
- Module
- UI
- Laravel integration
- Surface
- Delivery Adapter
- Registry
- canonical owner
- file archetype
- source template
- reviewed source template
- active framework override
- project-owned generator
- generated output
- application action
- implementation slice
- GitHub issue
- GitHub Project

Avoid older terminology when it conflicts with the current architecture model.

Treat Surface, Delivery Adapter, Registry, Action, Query, Contract, and similar terms as technical responsibilities beneath an explicit owner, not as application owners.

Do not describe `app/Platform/` as a target owner or the default home for reusable application behavior. It is transitional current placement, establishes no target ownership, and must not receive new canonical work unless a bounded Goal 3 decision explicitly authorizes it.

Reusable behavior belongs to the layer that owns the responsibility.

Do not describe deprecated UI Reference files or `reference.php` as required component ownership.

---

## Coding Standards Baseline

Coding standards in this folder must preserve these baseline rules:

- identify the owning layer before defining implementation rules
- identify the file archetype before defining file shape
- use an approved repository stub when one matches the selected archetype
- treat generated output as scaffolding that still requires implementation and review
- reject unresolved template placeholders
- use strict types for new PHP source files unless a documented constraint prevents it
- prefer explicit native types and dependencies
- keep controllers and views thin
- use validated input
- protect mass assignment
- use explicit authorization
- define transaction ownership
- define retry and idempotency behavior
- keep asynchronous payloads small and safe
- keep queries scoped and bounded
- test successful and denied behavior
- use PostgreSQL for PostgreSQL-dependent verification
- protect sensitive data
- keep documentation synchronized with implementation
- stop when ownership, security, data, transaction, generator, or UI intent is unclear

Standards must not conflict with more specialized database, security, UI, logging, or documentation owners.

---

## File And Shape Rules

When creating or materially rewriting coding standards in this folder:

- include a `DOC-META` header block
- use portable Markdown links for important references
- link to the parent index
- update `docs/02-standards/coding/index.md`
- update `docs/02-standards/index.md` when the standard should be visible from the branch index
- update this `AGENTS.md` when routing or ownership changes
- keep standards enforceable and concise
- keep examples current with the Core capability, Module, UI, and Laravel integration owner model and the separate technical-role vocabulary
- link to specialized standards rather than duplicating their full contents
- avoid mixing standards, planning, architecture, research, and issue-specific instructions in one file

Do not store executable `.stub` files in this folder.

Do not duplicate the full `stubs/README.md` inventory inside a coding standard.

Do not require Obsidian-only links. Markdown links are required; Obsidian links are optional graph aids only.

---

## Coding Standards Rules

Coding standards in this folder should define:

- what rule applies
- when it applies
- which layer owns the behavior
- which file archetype is affected
- whether an approved source template applies
- where the canonical owner lives
- which files, templates, generators, or indexes must be updated
- what generated-output validation is required
- what testing or verification is expected
- what documentation sync is required
- when Codex or a developer must stop and ask

They should not:

- duplicate full source-template bodies
- duplicate template inventories
- duplicate long planning documents
- include broad historical commentary
- preserve deprecated `/docs/08-active/` workflows as active rules
- introduce conflicting terminology for Core, Modules, UI, Laravel integration, or Planning
- define issue-specific instructions as reusable standards
- prescribe a new architecture without an accepted planning or decision owner
- duplicate database, UI, security, logging, or documentation standards unnecessarily
- reintroduce removed UI Reference or `reference.php` ownership requirements

---

## Source Template And Generator Rules

When a coding-standard change affects repository-owned templates or generators, review:

- `docs/02-standards/coding/Code Template And Generator Standards.md`
- `stubs/README.md`
- `stubs/AGENTS.md`
- the affected `.stub` files
- any generator that consumes those files
- representative current generated output
- relevant file-archetype and specialized standards

Template-related standards should define policy.

The `stubs/README.md` file should define current inventory and operator usage.

The `stubs/AGENTS.md` file should define scoped agent execution rules.

Individual stubs should implement the approved mechanical structure.

Custom generators should define validated replacement and file-creation behavior.

Do not activate a Laravel root override without confirming:

- the installed framework generator
- the expected stub filename
- supported placeholders
- representative output from the actual Artisan command
- the project’s willingness to maintain the override through upgrades

Do not add a machine-readable template manifest until a real generator or validator consumes it.

---

## Agent Implementation Rules

When a coding-standard change affects Codex behavior, review:

- `docs/02-standards/coding/Agent Implementation Checklist.md`
- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/Code Template And Generator Standards.md` when file creation or generation is affected
- root `AGENTS.md`
- relevant folder-level `AGENTS.md`
- applicable `.agents/skills/`
- `docs/09-reference/templates/agents/_folder-agents.md`

Agent guidance should route Codex to canonical standards.

Do not duplicate large standards blocks inside `AGENTS.md` files or skills.

If agent guidance reveals a durable coding rule, promote that rule into the correct standard before relying on it.

---

## Testing And Verification

For changes in this folder, verification is primarily documentation and consistency review.

Expected checks:

- confirm every new or materially rewritten standard has `DOC-META`
- confirm important links are Markdown links
- confirm `docs/02-standards/coding/index.md` is updated
- confirm `docs/02-standards/index.md` is updated when needed
- confirm this `AGENTS.md` is updated when routing changes
- confirm related standards do not contradict each other
- confirm examples use current paths, vocabulary, and PostgreSQL assumptions where relevant
- confirm deprecated phase, batch, Perfex, UI Reference, `reference.php`, or `docs/08-active/` language was not reintroduced as active guidance
- confirm full source-template bodies were not copied into standards docs unnecessarily
- confirm template policy remains in the canonical coding standard
- confirm current inventory remains in `stubs/README.md`
- confirm scoped template execution rules remain in `stubs/AGENTS.md`
- confirm standards remain enforceable rather than advisory prose
- confirm agent guidance points to the new standards when applicable
- confirm specialized rules remain with their database, security, UI, logging, or documentation owners

When template or generator rules change, also confirm:

- `stubs/README.md` remains accurate
- `stubs/AGENTS.md` remains aligned
- affected stubs are identified
- affected generators are identified
- representative generated output can be validated
- unresolved-placeholder checks are documented
- active Laravel overrides are distinguished from reviewed nested source templates

If a docs guardrail script exists, run it or report that it was not run.

---

## Stop Conditions

Stop and ask before editing when:

- two coding standards conflict
- the correct canonical owner is unclear
- a proposed standard crosses coding, database, security, UI, logging, or documentation ownership
- a change would move standards across canonical branches
- a standard would introduce a new mandatory file shape without an accepted architecture or refactor plan
- a standard would introduce a new mandatory source template without an approved archetype or repeated need
- a standard would activate a Laravel framework override without confirmed generator behavior
- a standard would introduce a new custom generator without a stable consumption model
- a standard would introduce new required tooling or dependencies
- a standard would introduce new mandatory tests across the repository without an accepted implementation path
- a standard would change Core, Module, or UI ownership or Laravel integration boundaries
- a standard would affect auth, access, audit, security, data, schema, exports, or deployment beyond coding implementation rules
- a change would require broad link rewrites
- a change would rename many files or paths
- a proposed template contains unresolved ownership, security, schema, transaction, or UI decisions
- the requested change is better owned by documentation, database, security, UI, logging, planning, runbook, AGENTS, skill guidance, or the `stubs/` implementation directory

---

## Related

- [Coding Standards Index](index.md)
- [Coding Standards](Coding%20Standards.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [File Archetypes](File%20Archetypes.md)
- [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Query And Performance Standards](Query%20And%20Performance%20Standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)
- [Database Standards Index](../database/index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Standards Index](../index.md)
