---
name: login2-implementation-slice
description: Execute one bounded, implementation-authorized Login 2.0 work packet using verification-first preflight, owner-first placement, protected proof, targeted implementation, final verification, documentation sync, and review handoff. Use for application, tooling, test, documentation-sync, or mixed implementation slices. Do not use for unresolved planning, architecture selection, visual design creation, production operations, or review-only work.
---

# Login 2.0 Implementation Slice

Lifecycle: active.

## Purpose

Execute one bounded repository implementation slice from readiness through review handoff.

This is the outer implementation workflow. It owns execution order and scope discipline, not product behavior, architecture, schema, Security policy, UI design, verification semantics, or test-source rules.

Use `login2-file-implementation` only when new or materially reshaped files are required.

## Use And Non-Use

Use when the issue or explicit task:

- authorizes repository implementation;
- defines bounded scope and non-goals;
- identifies repository work ownership and application ownership when applicable;
- defines observable acceptance criteria;
- resolves canonical sources and dependencies;
- defines verification, environments, review, and stop conditions.

Do not use for planning, architecture selection, unresolved schema/authorization/transaction/compatibility/UI decisions, review-only work, deployment/incident response, broad cleanup, or milestone-wide implementation.

## Required Inputs

Obtain:

- issue/task identifier and requested outcome;
- scope, non-goals, allowed/forbidden paths, shared-file risks;
- repository work owner and specific Core/Module/UI/Laravel-integration owner when applicable;
- canonical source paths, accepted decisions, public Contracts, dependencies;
- acceptance criteria and required rejection behavior;
- `AC-*` → `PF-*` mapping when required;
- proof methods, environments, fixtures, commands, expected initial result;
- protected-baseline requirements and permitted proof edits;
- final targeted proof, broader verification, manual/specialist review;
- compatibility requirements and stop conditions;
- authorization for consequential side effects.

Stop rather than infer a missing high-impact input.

## Canonical Sources

Always read:

1. root `AGENTS.md`;
2. applicable scoped `AGENTS.md`;
3. the complete issue or explicit work packet;
4. `docs/02-standards/coding/Agent Implementation Checklist.md`;
5. `docs/02-standards/testing/index.md`.

Read only when applicable:

- `docs/03-architecture/repository-architecture.md`;
- `docs/02-standards/coding/test-implementation/index.md`;
- exact feature, flow, database, Security, UI, logging, documentation, or runbook owners;
- `stubs/AGENTS.md` and `stubs/README.md` for stubs/generators.

Prefer targeted sections. Do not load unrelated standards, planning history, archives, skills, or review records.

## Side-Effect Boundary

Within accepted scope this skill may create, modify, move, or delete repository files.

It does not authorize, unless explicitly granted:

- staging, committing, pushing, merging, rebasing, resetting, cleaning, or branch deletion;
- issue or GitHub Project mutation;
- dependency installation/upgrades;
- shared-environment migrations;
- deployment/staging/production actions;
- destructive data operations;
- secret rotation or third-party mutation.

A failed gate is not authorization for undeclared remediation.

## Procedure

### 1. Declare The Slice

State the issue/task, execution mode, repository owner, application owner when applicable, intended file scope, specialist skill/review needs, and authorized consequential side effects.

### 2. Apply Definition Of Ready

Use `Agent Implementation Checklist.md`.

Confirm outcome, scope, non-goals, compatibility, ownership, target placement, public Contracts, dependencies, Security/data/transaction/reliability/UI boundaries, acceptance/rejection behavior, verification, docs sync, review authority, and stop conditions.

If readiness fails, do not edit files. Report the missing input and canonical owner.

### 3. Preflight Repository And Writable Ownership

Inspect:

```text
git status --short --branch
git worktree list
```

Confirm branch/worktree, dirty state, unrelated work, current writable owner, and shared-file risks.

One writer in one working tree is the default. Use another branch/worktree when concurrency or isolation requires it. Never overwrite, reset, clean, stash, or relocate another task's work.

### 4. Resolve Owner And Target Paths

Use Repository Architecture and scoped `AGENTS.md`.

Select the smallest clear owner before choosing paths:

- Core capability;
- Module;
- reusable UI responsibility;
- restricted application-wide Laravel integration;
- repository Docs/Ops/Tests/Tooling owner.

Treat `app/Platform/`, `app/Surfaces/`, and generic owner branches as transitional, not target owners.

### 5. Establish Verification Readiness

Use Testing Standards for proof meaning and gates.

Before the first production implementation write, confirm applicable:

- criterion-to-proof mapping and proof applicability;
- executor/environment;
- fixtures/commands;
- expected initial result;
- initial-proof requirement or declared non-applicability;
- protected baseline and permitted edits;
- final targeted proof;
- broader/manual/specialist verification.

This skill does not redefine result-state semantics.

### 6. Prepare Required Proof Source

If the verification contract requires new test/proof source or fixtures before initial execution, create only those accepted proof artifacts first.

Use `login2-file-implementation` when mechanical construction is needed.

Do not modify production implementation while preparing initial proof.

### 7. Run Initial Proof

Run the exact declared initial proof in the required environment. Record command/procedure, environment/runtime, result, and evidence location when required.

Proceed only when the observed result matches the verification contract.

Unexpected syntax, fixture, dependency, boot, discovery, infrastructure, tooling, or environment failures stop execution unless an exact bounded recovery was predeclared.

### 8. Protect The Baseline

Identify protected tests, fixtures, Contracts, datasets, selectors, scripts, and review procedures.

Do not weaken, skip, delete, undiscover, narrow, redirect, or materially rewrite protected proof to make implementation pass.

If material baseline revision is required, stop for verification-contract authority.

### 9. Plan The Smallest Production Change

List files to create/modify/move/delete, files out of scope, owner/archetype, public Contracts, compatibility behavior, shared-file risks, docs sync, final proof, broader verification, and specialist review.

Every production change must support accepted scope. Stop if the plan materially expands.

### 10. Implement

Implement only the smallest complete production change.

Use `login2-file-implementation` for file construction/reshape.

Preserve owner/dependency boundaries, public Contracts, validation/authorization, transaction/PostgreSQL semantics, Security/data handling, compatibility, source headers/comments, accepted UI authority, and the protected proof baseline.

No unrelated cleanup or speculative future work.

### 11. Run Final Targeted Proof

Run the accepted targeted proof after implementation. When required, run the same proof unchanged.

If it does not satisfy the contract, stop, preserve evidence/state, and do not weaken proof or broaden remediation without authority.

### 12. Synchronize Canonical Documentation

Use `Implementation Status And Development Sync Standard.md`.

Update only affected canonical owners. Do not create a second durable owner in planning, `docs/11-ai/`, memory, issue comments, or skills.

Do not mark a broader capability/Module/milestone/goal complete because one slice completed.

### 13. Run Required Broader Verification

Run only declared broader checks and required browser, PostgreSQL, accessibility, Security, native-platform, operational, manual, or specialist proof.

Automated success does not replace required human review.

### 14. Review Final Diff

Inspect:

```text
git status --short
git diff --check
git diff
```

Confirm only accepted files changed, protected proof is intact, no placeholders/debug/secrets remain, ownership/paths/Contracts/tests/docs align, and deletions/compatibility changes are intentional.

Stage explicit paths only when staging is authorized.

### 15. Report And Handoff

Report:

- issue/task, execution mode, owner, scope completed;
- files created/modified/moved/deleted;
- criteria addressed;
- proof source changes;
- initial proof/result and protected baseline;
- production implementation;
- final targeted proof/result;
- broader verification;
- canonical docs synchronized;
- manual/specialist review remaining;
- gaps/pre-existing failures;
- exact next authorized action.

Distinguish implemented, verified, reviewed, accepted, deferred, and blocked.

## Stop Conditions

Stop when readiness, ownership, placement, acceptance/rejection behavior, verification environment/fixtures/expected initial result, required dependency/decision, schema/authorization/Security/data/transaction/retry/compatibility/UI behavior, writable ownership, or required proof is unresolved.

Also stop when:

- initial proof produces an unexpected result;
- protected proof needs unauthorized material revision;
- implementation requires broad unrelated cleanup;
- a consequential side effect lacks explicit authority.

Report the blocker, affected scope/criterion, canonical owner, and minimum input or authority needed.
