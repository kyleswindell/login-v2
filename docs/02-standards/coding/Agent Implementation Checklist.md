<!--
DOC-META
title: Agent Implementation Checklist
doc_type: agent-guidance
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding/Agent Implementation Checklist.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines repository-facing implementation readiness, source routing, bounded execution, verification handoff, documentation synchronization, review, and stop conditions for coding agents.
-->

# Agent Implementation Checklist

Parent: [Coding Standards Index](index.md)

Use this checklist before Codex or another coding agent creates, modifies, moves, or deletes repository files.

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Definition Of Ready](#2-definition-of-ready)
  - [Work identity and scope](#work-identity-and-scope)
  - [Ownership and behavior](#ownership-and-behavior)
  - [Data, security, and reliability](#data-security-and-reliability)
  - [Verification](#verification)
- [3. Repository And Worktree Preflight](#3-repository-and-worktree-preflight)
- [4. Owner, Boundary, And File Archetype](#4-owner-boundary-and-file-archetype)
- [5. Required Source Routing](#5-required-source-routing)
- [6. Verification Readiness](#6-verification-readiness)
- [7. Plan The Smallest Safe Change](#7-plan-the-smallest-safe-change)
- [8. Implementation Rules](#8-implementation-rules)
- [9. Test Source And Verification](#9-test-source-and-verification)
- [10. Documentation Synchronization](#10-documentation-synchronization)
- [11. Diff And Review Handoff](#11-diff-and-review-handoff)
- [12. Result Reporting](#12-result-reporting)
- [13. Stop Conditions](#13-stop-conditions)
- [14. Related](#14-related)

## 1. Purpose And Authority

Provide the repository-facing execution checklist from a bounded work packet to reviewable implementation.

This checklist owns implementation readiness and routing. It does not replace:

- root or scoped `AGENTS.md` instructions;
- architecture;
- feature or flow behavior;
- database Contracts;
- Security standards;
- UI Contracts;
- operational runbooks;
- Testing Standards;
- file archetype or naming standards;
- issue-specific acceptance criteria.

Use higher-authority canonical owners for the meaning of requirements. Use `.agents/skills/` for repeatable execution procedures that are too detailed to belong in this checklist.

Testing and verification semantics belong to the [Testing Standards Index](../testing/index.md). Test-source implementation belongs to the [Test Implementation Standards Index](test-implementation/index.md).

GitHub issues own bounded work packets. GitHub Projects own delivery state. This checklist does not authorize issue, Project, merge, deployment, or other external-state changes unless the current task explicitly grants that authority.

## 2. Definition Of Ready

Before production implementation, confirm applicable:

### Work identity and scope

- issue number or explicit user-authorized task;
- requested outcome;
- in-scope behavior;
- explicit non-goals;
- compatibility requirements;
- allowed and forbidden paths;
- shared-file risks;
- expected review state.

### Ownership and behavior

- primary repository work owner;
- application ownership area when application behavior is involved;
- specific Core capability, Module, UI responsibility, or restricted Laravel integration boundary;
- applicable Technical Roles;
- canonical architecture and behavior owners;
- public Contracts and dependency boundaries.

Application architecture uses the accepted ownership areas `core`, `module`, and `ui`. Laravel integration is an integration boundary, not a fourth application owner. Docs, Ops, Tests, and Tooling are repository work owners rather than application ownership areas.

Do not use generic `Platform` or `Surface` as owners. A named Frame Surface may be part of the technical scope only when persistent Frame composition is involved.

### Data, security, and reliability

For protected or data-bearing work, confirm applicable actor or Principal, Action, target, object-level boundary, canonical scope, authorization, validation, data classification, Audit, Monitoring, sensitive fields, export, retention, and redaction requirements.

For mutations or retryable work, confirm applicable transaction owner, rollback behavior, concurrency, retry, idempotency, duplicate delivery, after-commit effects, remote side effects, and public failure behavior.

### Verification

Confirm the work packet has the verification information required by the Testing Standards suite, including applicable acceptance criteria, declared proofs, environments, initial-proof requirements, protected baselines, final proof, broader verification, and manual or specialist review.

An issue is not implementation-ready when a material requirement depends on undefined phrases such as `make it production-ready`, `improve security`, `finish the feature`, `match the design`, or `handle edge cases` without observable criteria.

Stop rather than inventing unresolved architecture, behavior, schema, security, compatibility, transaction, or design decisions.

## 3. Repository And Worktree Preflight

Before editing:

- confirm the repository and intended branch or worktree;
- read root `AGENTS.md`;
- read applicable folder-level `AGENTS.md` files;
- inspect `git status`;
- identify staged, unstaged, and untracked files;
- identify unrelated dirty work;
- identify whether another writer owns the same worktree or file scope;
- identify shared-file collision risks;
- preserve unrelated work.

Do not:

- switch, reset, clean, stash, overwrite, or relocate another issue's work without explicit authority;
- use `git add .` in an unverified dirty tree;
- treat local file presence as independent repository authority;
- silently convert a read-only session into a writer when another writer owns the tree.

Stage explicit paths only when staging is authorized.

## 4. Owner, Boundary, And File Archetype

Identify the smallest clear owner before selecting a file path.

Target application ownership follows [Repository Architecture](../../03-architecture/repository-architecture.md):

```text
Core capability
    app/Core/<Capability>/

Module
    Modules/<Module>/

Reusable UI PHP/runtime responsibility
    app/UI/<Responsibility>/

Reusable UI presentation
    resources/views/**

Application-wide Laravel integration
    app/Http/
    app/Console/
    app/Providers/
```

Existing `app/Platform/`, `app/Surfaces/`, and generic `Surface/` structures are transitional where they remain and are not target destinations.

A Frame Surface is a named persistent-Frame composition concept, not a generic owner-local Technical Role.

Then identify the file archetype using [File Archetypes](File%20Archetypes.md) and applicable specialist standards.

Examples include controller, Form Request, middleware, Action, Service, Query, Resolver, Data Object, Model, policy, Event, Listener, Job, command, migration, factory, seeder, Blade view, UI Component, CSS, JavaScript, test, documentation, generator, or stub.

For each file, confirm:

- owner;
- primary responsibility;
- target path;
- naming rule;
- allowed and forbidden dependencies;
- public Contract when applicable;
- required verification;
- required documentation sync.

Stop when a file has competing primary responsibilities or multiple credible owners.

## 5. Required Source Routing

Read the smallest set of current sources needed for the task.

At minimum use applicable:

- [Standards Index](../index.md);
- [Coding Standards](Coding%20Standards.md);
- [File Building Standards](File%20Building%20Standards.md);
- [File Archetypes](File%20Archetypes.md);
- [Repository Naming Standards](repository-naming-standards.md);
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md);
- [Testing Standards Index](../testing/index.md);
- [Test Implementation Standards Index](test-implementation/index.md) when test source is involved.

Read specialist standards only when applicable: Actions and data objects, errors, transactions, Events and queues, queries and performance, database, security, logging, UI, documentation, and operations.

Read canonical owner docs for architecture, feature behavior, flows, database Contracts, UI Contracts, Security requirements, and runbooks as required by the work.

Planning defines sequencing and intent. It does not replace accepted architecture, behavior, schema, security, or operations.

Do not rely on remembered standards when current repository sources are available.

Do not use the superseded `Testing Standards.md` or `Test Implementation Standards.md` compatibility files as canonical detail owners.

## 6. Verification Readiness

Use the [Testing Standards Index](../testing/index.md) for proof semantics and gate requirements.

Before the first production implementation write, confirm the responsible execution session has satisfied the verification state required by the work packet, including applicable:

- `AC-*` and `PF-*` mapping;
- proof applicability;
- required environment and executor;
- expected initial result;
- initial proof when required;
- protected verification baseline;
- permitted proof edits;
- required final targeted proof;
- broader checks;
- manual or specialist review.

This checklist does not redefine `PASS`, `EXPECTED_NONPASS`, `FAIL`, environment equivalence, evidence sufficiency, or protected-baseline revision authority.

Do not begin production implementation merely because tests are listed. Follow the verification lifecycle required by the current canonical Testing Standards.

If the required proof cannot run or produces an unexpected result, follow the work packet and applicable testing failure rules rather than improvising a new proof or weakening source.

## 7. Plan The Smallest Safe Change

Before editing production source, identify:

- files to create, modify, or delete;
- files explicitly out of scope;
- file archetypes;
- stubs or generators;
- public Contracts;
- compatibility behavior;
- test or other proof source to add or modify;
- documentation to synchronize;
- exact verification commands or procedures;
- manual and specialist review;
- known risks and stop conditions.

Every production change must support an accepted criterion, required integration, documentation synchronization, or explicitly authorized migration or compatibility need.

Avoid broad rewrites, unrelated cleanup, speculative abstractions, premature Registries or persistence, unrelated renames, and future-proofing without a current requirement.

When the required implementation becomes materially larger than the work packet, stop for a scope decision.

## 8. Implementation Rules

During implementation:

- preserve ownership and dependency direction;
- use public Contracts across owners;
- follow the selected file archetype and naming rules;
- use explicit native types and current PHP/Laravel style;
- validate untrusted input;
- authorize protected behavior;
- keep Delivery Adapters thin;
- keep Actions focused, Services cohesive, and Queries bounded;
- preserve transaction and PostgreSQL semantics;
- keep asynchronous payloads bounded and safe;
- protect sensitive data;
- preserve compatibility unless an accepted break is in scope;
- maintain required comments and file headers;
- remove temporary debugging and scaffold-only source;
- implement only accepted scope.

Generated source is not complete until placeholders, types, dependencies, behavior, and required verification are resolved.

Do not create a production seam solely for test convenience unless it has a real application responsibility.

## 9. Test Source And Verification

The verification contract determines which proof is required. Do not invent a test solely because production source changed.

When proof requires test source, use the [Test Implementation Standards Index](test-implementation/index.md).

Target placement follows the smallest clear owner and deterministic discovery. Applicable locations include:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
tests/
```

Root `tests/` is not the default target for owner-specific behavior. Existing root `tests/Unit/` and `tests/Feature/` may remain during migration while owner-local discovery is incomplete.

Do not weaken, skip, delete, undiscover, narrow, or materially redirect protected proof without the authority required by the verification contract.

Run the exact proofs and repository checks required by the accepted contract. Do not claim a command or review passed unless it actually ran successfully.

Automated success does not replace declared visual, accessibility, security, database, privacy, operational, or repository-owner review.

## 10. Documentation Synchronization

Update canonical documentation when implementation changes durable truth.

Check applicable:

- ADR or architecture;
- feature behavior;
- flow;
- database Contract;
- Security standard;
- UI Contract;
- runbook;
- implementation status;
- standard or index;
- `AGENTS.md` or skill when durable agent behavior changes;
- stub or generator documentation.

Use [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md).

Do not use planning as an implementation worklog or mark an entire capability, Product, Module, milestone, or goal complete when only one bounded slice is complete.

## 11. Diff And Review Handoff

Before staging, committing, or handing work off:

- inspect `git status` and the complete diff;
- verify exact changed and staged paths;
- confirm no unrelated files or formatter changes are included;
- confirm no unexpected generated files or unresolved placeholders remain;
- confirm no debug output, secrets, credentials, or sensitive evidence is present;
- confirm imports, dependencies, comments, and headers are current;
- confirm public Contracts, target placement, test placement, and documentation remain aligned;
- confirm deletions and compatibility changes are intentional;
- confirm required verification and evidence are complete for the declared review state.

Before moving work to Review, list remaining manual or specialist review explicitly. Review may contain planned human review; it must not conceal incomplete mandatory implementation or automated proof.

## 12. Result Reporting

Report applicable:

- issue or task;
- execution mode;
- repository work owner and application owner;
- criteria addressed;
- files created, modified, or deleted;
- stubs or generators used;
- behavior and compatibility changes;
- canonical docs synchronized;
- test source added or changed;
- verification proofs and exact commands or procedures;
- results and evidence location when required;
- checks not run;
- manual and specialist review remaining;
- known gaps and pre-existing failures;
- follow-up work discovered but not implemented.

Distinguish implemented, verified, reviewed, accepted, deferred, and blocked states. Do not claim a state established by another authority.

## 13. Stop Conditions

Stop when applicable:

- Definition of Ready is incomplete;
- scope, owner, file archetype, or public Contract is unclear;
- canonical sources conflict;
- a required decision or dependency remains open;
- implementation would require an unapproved dependency or architecture change;
- security, Access, schema, data, transaction, retry, compatibility, or UI behavior is unresolved;
- a destructive change lacks accepted recovery behavior;
- required verification cannot run or produces an unexpected result;
- protected proof would require a material revision without authority;
- another writer owns the same worktree or file scope;
- unrelated dirty work may be overwritten;
- multiple implementation paths have materially different behavioral consequences;
- completing the task requires broad unrelated cleanup;
- a human-led decision is being implicitly delegated.

When stopping, report the exact blocker, affected scope or criterion, canonical owner that must resolve it, and minimum decision, environment, or evidence needed to continue.

A failed verification requirement is not automatic authorization for broad remediation.

## 14. Related

- [Coding Standards Index](index.md)
- [Standards Index](../index.md)
- [Coding Standards](Coding%20Standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [File Archetypes](File%20Archetypes.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [Test Implementation Standards Index](test-implementation/index.md)
- [Testing Standards Index](../testing/index.md)
- [Security Standards Index](../security/index.md)
- [Database Standards Index](../database/index.md)
- [UI Standards Index](../ui/index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Stub Templates README](../../../stubs/README.md)
