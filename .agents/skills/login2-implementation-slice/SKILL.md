---
name: login2-implementation-slice
description: Implement a bounded, Ready Login 2.0 GitHub issue or explicitly authorized implementation task with defined ownership, acceptance criteria, dependencies, verification, and review requirements. Use as the outer workflow for application, tooling, test, documentation-sync, and mixed implementation slices. Do not use for unresolved planning, architecture decisions, visual design creation, production operations, or broad matrix-row implementation.
---

# Login 2.0 Implementation Slice

## Purpose

Execute one bounded Login 2.0 implementation slice from readiness preflight through implementation, verification, documentation synchronization, diff review, and review handoff.

This skill is the outer implementation workflow.

Apply narrower skills inside this workflow when the task includes specialized file generation, database changes, Shared UI work, security-sensitive behavior, or final verification.

This skill does not define product, architecture, schema, security, or design truth. Read those requirements from their canonical owners.

## Use This Skill When

Use this skill when:

- a GitHub implementation issue is marked `Ready`
- an explicit user-authorized task provides equivalent implementation detail
- the work has bounded acceptance criteria
- the owning layer and specific owner are known
- relevant decisions and dependencies are resolved
- verification and review expectations are defined
- Codex is expected to modify repository files

Typical work includes:

- implementing a Core Capability slice
- implementing a Platform Surface slice
- implementing a Business Module slice
- adding or changing application behavior
- adding tests for established behavior
- creating compatibility wrappers
- moving established behavior behind a new owner boundary
- implementing generator or tooling behavior
- synchronizing canonical documentation with completed code

## Do Not Use This Skill When

Do not use this skill for:

- planning-only discussion
- architecture selection
- unresolved schema design
- permission-model design
- visual design creation
- legal or privacy interpretation
- security risk acceptance
- production incident response
- production deployment execution
- broad implementation of an entire planning matrix row
- unrelated cleanup
- review-only work with no implementation authorization

Use `login2-file-implementation` directly when the task is limited to creating or reshaping files from approved archetypes and no broader implementation workflow is required.

## Required Inputs

Obtain the following from the GitHub issue or explicit task:

- issue number or task identifier
- requested outcome
- primary owner layer
- specific owner
- execution mode
- in-scope behavior
- explicit non-goals
- observable acceptance criteria
- canonical document paths
- accepted decisions
- blocking dependencies
- expected file archetypes
- security and data boundaries
- transaction and reliability boundaries
- required tests
- required verification
- documentation synchronization requirements
- manual or specialist review requirements
- agent stop conditions

Do not infer missing high-impact inputs.

## Canonical Procedure

### 1. Declare The Workflow

Before editing, state:

- that `login2-implementation-slice` is being used
- the issue or task identifier
- the intended owner
- the planned file scope
- whether a specialist skill is also required

Do not describe the work as implementation-ready until the readiness gate passes.

### 2. Load Repository Instructions

Read:

1. repository-root `AGENTS.md`
2. each applicable nested `AGENTS.md` from the repository root to the target directory
3. `docs/02-standards/coding/Agent Implementation Checklist.md`
4. `docs/02-standards/coding/index.md`

Read `stubs/AGENTS.md` before editing or consuming files under `stubs/`.

Closer `AGENTS.md` files refine broader instructions. Canonical documentation remains authoritative for durable system behavior.

### 3. Load The Complete Work Packet

Read the complete GitHub issue or explicit task.

Include materially relevant:

- issue body
- issue comments
- linked decisions
- linked parent issues
- linked canonical documents
- dependency state
- acceptance-criteria changes

Do not implement from the title alone.

When the issue is unavailable through current tooling, stop and request the full work packet rather than guessing.

### 4. Apply The Definition Of Ready

Use the Definition of Ready in:

- `docs/02-standards/coding/Agent Implementation Checklist.md`

Confirm:

- ownership is explicit
- scope is bounded
- non-goals are explicit
- acceptance criteria are observable
- canonical owners are linked
- dependencies are complete
- applicable decisions are accepted
- implementation boundaries are defined
- security and data implications are defined
- transaction and reliability implications are defined
- tests and verification are defined
- review requirements are defined
- stop conditions are defined

A GitHub issue in `Inbox`, `Todo`, or `Planned` is not independently delegable.

When project status cannot be inspected, require the work packet or user instruction to explicitly authorize implementation.

When readiness fails:

1. do not edit repository files
2. identify the missing or conflicting inputs
3. identify the canonical owner that must resolve them
4. report the minimum information needed to continue

### 5. Inspect The Working Tree

Run the applicable Git inspection commands before editing.

At minimum, inspect:

    git status --short --branch

Identify:

- current branch
- staged changes
- unstaged changes
- untracked files
- unrelated work
- whether another writable session owns the worktree

Do not:

- overwrite unrelated work
- reset files outside the task
- use `git add .`
- assume staged files belong to this task
- start a second writable workflow in the same worktree

Stop when safe file ownership is unclear.

### 6. Confirm The Execution Mode

Confirm one execution mode:

- Human-led
- Codex-assisted
- Codex-delegable
- Codex-delegable with specialist review

Do not use a delegable mode to bypass human-owned decisions.

Require specialist review for applicable:

- authentication and MFA
- access control
- service accounts and tokens
- secrets
- webhooks
- sensitive exports
- audit evidence
- security middleware
- retention or erasure
- destructive migrations
- concurrency-sensitive writes
- design-sensitive Shared UI

### 7. Classify The Slice

Record:

- primary owner layer
- specific owner
- affected workflows
- file archetypes
- applicable stubs or generators
- security risk
- data risk
- transaction risk
- concurrency or retry risk
- UI impact
- database impact
- documentation impact
- operational impact
- required specialist review

Use current ownership:

- Core Capability → `app/Core/*`
- Platform Surface → `app/Platform/*`
- Business Module → `Modules/*`
- Shared UI → `resources/views/components/*`, `resources/css/*`, `resources/js/*`
- Source templates → `stubs/*`
- Database implementation → `database/*`
- Tests → `tests/*`
- Canonical documentation → `docs/*`

Do not create a future owner merely because it appears as a candidate in planning.

### 8. Select Specialized Skills

Use a narrower skill when applicable.

For new or materially reshaped files, apply:

- `login2-file-implementation`

Future specialized skills may govern:

- database changes
- Shared UI components
- security-sensitive changes
- verification and review

The general issue scope remains authoritative.

A specialized skill must not broaden the issue.

### 9. Read Targeted Canonical Sources

At minimum, read the relevant sections of:

- `docs/02-standards/coding/Coding Standards.md`
- `docs/02-standards/coding/PHP And Laravel Style Standards.md`
- `docs/02-standards/coding/File Building Standards.md`
- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/Testing Standards.md`

Read additional owners only when applicable:

- application actions, services, and data objects
- errors and exceptions
- transactions, concurrency, and idempotency
- events, jobs, and queues
- query and performance
- database standards and contracts
- security standards
- UI standards and contracts
- logging standards
- documentation standards
- runbooks
- accepted decisions

Prefer targeted section reads.

Do not load unrelated planning, archives, or research.

### 10. Inspect Current Implementation

Inspect applicable:

- existing source files
- tests
- routes
- configuration
- interfaces
- actions
- services
- queries
- DTOs
- policies
- middleware
- models
- migrations
- database contracts
- Blade files
- component contracts
- CSS
- JavaScript controls
- documentation status

Determine whether each reference is:

- current
- transitional
- compatibility-only
- deprecated
- scheduled for replacement

Do not copy a deprecated pattern merely because it is common.

### 11. Confirm High-Risk Boundaries

Before editing protected behavior, confirm:

- actor
- action
- target
- scope
- authentication requirement
- authorization mechanism
- object-level authorization
- tenant or workspace isolation
- validation
- data classification
- sensitive fields
- audit requirements
- monitoring requirements
- notification requirements
- log redaction
- export implications
- retention or erasure implications

For mutations, also confirm:

- transaction owner
- rollback behavior
- concurrency control
- retry behavior
- idempotency
- duplicate-delivery behavior
- after-commit effects
- remote side-effect ordering
- expected failure states

Stop when any applicable boundary is unresolved.

### 12. Produce A Bounded Implementation Plan

Before changing files, list:

- files to create
- files to modify
- files to delete
- files explicitly out of scope
- archetype for each affected file
- stubs or generators to use
- behavior to preserve
- tests to add or update
- documentation to synchronize
- verification commands
- required manual review
- required specialist review
- known risks

Each proposed change must support an acceptance criterion.

Stop when the plan becomes materially broader than the issue.

### 13. Implement The Smallest Complete Slice

During implementation:

- preserve owner boundaries
- follow the selected archetypes
- use approved stubs when applicable
- replace all placeholders
- remove non-applicable scaffold
- use strict types for new PHP files
- use explicit native types
- use constructor injection where appropriate
- validate input
- authorize protected actions
- protect mass assignment
- keep controllers and views thin
- keep queries scoped and bounded
- keep transactions focused
- keep queued payloads small
- preserve PostgreSQL behavior
- keep sensitive values out of logs and evidence
- preserve compatibility unless a break is explicitly authorized
- avoid unrelated cleanup
- remove debugging code

Do not implement deferred behavior.

Do not add speculative abstractions.

### 14. Add Or Update Tests

Add the narrowest tests that prove applicable acceptance criteria.

Cover applicable:

- success
- validation failure
- unauthenticated denial
- unauthorized denial
- object-level denial
- cross-scope denial
- rollback
- concurrency
- retries
- duplicate execution
- idempotency
- after-commit behavior
- exception translation
- audit events
- monitoring signals
- notifications
- PostgreSQL behavior
- migrations
- component contracts
- semantic markup
- accessibility wiring
- browser interactions
- generator output
- documentation guardrails

Do not weaken existing tests.

Do not use unconditional passing assertions.

Do not leave required incomplete tests.

### 15. Synchronize Canonical Documentation

Update documentation when the slice changes:

- behavior
- ownership
- schema
- routes
- public APIs
- security boundaries
- operational behavior
- implementation status
- agent workflows
- stubs or generators

Use:

- `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`

Update only the canonical owners affected by this slice.

Do not use the planning matrix as a worklog.

Do not mark an entire capability complete because one issue is complete.

### 16. Run Verification

Run required issue-specific checks.

Also run applicable baseline checks:

- unresolved-placeholder scan
- PHP syntax
- formatter
- targeted Laravel tests
- broader Laravel tests
- PostgreSQL-backed tests
- migration tests
- frontend build
- Playwright tests
- documentation guardrails
- link checks
- generator tests

Use the repository-level verification command when one exists.

Record:

- exact command
- result
- relevant failure
- whether the failure was pre-existing
- whether it blocks completion

Do not claim a check passed unless it ran successfully.

### 17. Review The Final Diff

Inspect:

    git status --short

Then inspect the complete diff for the task.

Confirm:

- only intended files changed
- no unrelated staged files are included
- no placeholders remain
- no debug code remains
- no secrets are present
- imports are intentional
- comments remain accurate
- public APIs match contracts
- database changes match contracts
- documentation links are valid
- deleted files are intentional
- compatibility requirements are preserved
- acceptance criteria are addressed

Do not stage, commit, push, open a pull request, or alter GitHub Project state unless the work packet explicitly authorizes that action.

### 18. Prepare The Review Handoff

Move or recommend movement to `Review` only when:

- the bounded implementation is complete
- required automated checks passed
- documentation is synchronized
- unresolved implementation decisions are absent
- known failures are disclosed
- manual review requirements are identified
- specialist review requirements are identified

Keep the issue `In Progress` or mark it `Blocked` when required implementation or verification remains incomplete.

### 19. Report The Result

Use this report structure:

## Implementation Result

- Issue or task:
- Execution mode:
- Owner:
- Scope completed:

## Files

- Created:
- Modified:
- Deleted:

## Behavior

- Implemented:
- Compatibility preserved:
- Deferred or out of scope:

## Tests And Verification

- Tests added or changed:
- Commands run:
- Results:
- Checks not run:

## Documentation

- Canonical docs updated:
- Status changes made:

## Review

- Manual review required:
- Specialist review required:
- Known gaps:
- Pre-existing failures:
- Follow-up work discovered:

Distinguish completed, verified, reviewed, deferred, and blocked work.

## Stop Conditions

Stop without editing, or stop before continuing, when:

- the Definition of Ready fails
- scope is ambiguous
- acceptance criteria are not observable
- ownership is unclear
- an archetype is unclear
- canonical sources conflict
- a required decision remains open
- a dependency is incomplete
- a new production dependency is not authorized
- schema behavior lacks a contract
- destructive behavior lacks recovery
- authorization is unresolved
- tenant or workspace scope is unresolved
- sensitive-data handling is unresolved
- transaction ownership is unresolved
- retryable behavior lacks idempotency
- visual design is unspecified
- tests fail in a way that changes the plan
- required verification cannot run
- another writer owns the same files
- the task requires broad unrelated cleanup
- multiple valid implementations have materially different consequences
- a human-led decision is being delegated implicitly

When stopping, report:

- exact blocker
- why implementation cannot safely continue
- canonical owner that must resolve it
- minimum decision or input required
