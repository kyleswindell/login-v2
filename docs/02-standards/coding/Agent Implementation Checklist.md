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
summary: Defines implementation readiness, preflight, execution, verification, documentation synchronization, review, and reporting requirements for Codex and other coding agents.
-->

# Agent Implementation Checklist

Parent: [Coding Standards Index](index.md)

Use this checklist before Codex or another coding agent creates, modifies, moves, or deletes repository files.

- [1. Purpose](#1-purpose)
- [2. Delegation States](#2-delegation-states)
- [3. Definition Of Ready](#3-definition-of-ready)
  - [3.1. Required Identity](#31-required-identity)
  - [3.2. Required Scope](#32-required-scope)
  - [3.3. Required Acceptance Criteria](#33-required-acceptance-criteria)
  - [3.4. Required Canonical Owners](#34-required-canonical-owners)
  - [3.5. Required Implementation Boundaries](#35-required-implementation-boundaries)
  - [3.6. Required Security And Data Information](#36-required-security-and-data-information)
  - [3.7. Required Mutation And Reliability Information](#37-required-mutation-and-reliability-information)
  - [3.8. Required Verification Information](#38-required-verification-information)
  - [3.9. Required Dependencies And Decisions](#39-required-dependencies-and-decisions)
  - [3.10. Required Stop Conditions](#310-required-stop-conditions)
- [4. Identify The Work Packet](#4-identify-the-work-packet)
- [5. Inspect The Working Tree](#5-inspect-the-working-tree)
- [6. Select The Execution Mode](#6-select-the-execution-mode)
- [7. Identify The Owner Layer](#7-identify-the-owner-layer)
- [8. Identify The File Archetype](#8-identify-the-file-archetype)
- [9. Read Applicable AGENTS Files](#9-read-applicable-agents-files)
- [10. Select Applicable Skills](#10-select-applicable-skills)
- [11. Read Canonical Standards](#11-read-canonical-standards)
- [12. Read Canonical Owner Docs](#12-read-canonical-owner-docs)
- [13. Confirm Decisions And Dependencies](#13-confirm-decisions-and-dependencies)
- [14. Inspect Nearby Implementation](#14-inspect-nearby-implementation)
- [15. Check Approved Stubs And Generators](#15-check-approved-stubs-and-generators)
- [16. Confirm Security And Data Boundaries](#16-confirm-security-and-data-boundaries)
- [17. Confirm Transaction And Failure Behavior](#17-confirm-transaction-and-failure-behavior)
- [18. Confirm UI Authority](#18-confirm-ui-authority)
- [19. Plan The Smallest Safe Change](#19-plan-the-smallest-safe-change)
- [20. Implement To The Archetype](#20-implement-to-the-archetype)
- [21. Add Or Update Tests](#21-add-or-update-tests)
- [22. Synchronize Documentation](#22-synchronize-documentation)
- [23. Run Verification](#23-run-verification)
- [24. Review The Diff](#24-review-the-diff)
- [25. Prepare The Review Handoff](#25-prepare-the-review-handoff)
- [26. Report The Result](#26-report-the-result)
- [27. Stop Conditions](#27-stop-conditions)
- [28. Related](#28-related)

---

## 1. Purpose

Make implementation behavior predictable and reviewable during the Core Capability, Platform Surface, Business Module, and Shared UI refactor.

This checklist provides the standard execution path from a bounded work item to a reviewed implementation.

It does not replace:

- canonical architecture
- feature behavior
- database contracts
- security standards
- UI contracts
- operational runbooks
- file archetype standards
- template and generator standards
- issue-specific acceptance criteria

The checklist routes an agent to the correct owners and determines whether the task is ready to be delegated.

---

## 2. Delegation States

GitHub Projects owns active delivery state.

Use the following meanings for implementation work:

| State       | Meaning                                                                                                                             |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Inbox       | Work has been captured but not yet classified.                                                                                      |
| Todo        | Work is understood at a high level but is not yet implementation-ready.                                                             |
| Planned     | The slice belongs in the approved plan, but canonical documents, decisions, dependencies, or acceptance criteria remain incomplete. |
| Ready       | The Definition of Ready is satisfied and implementation may begin.                                                                  |
| In Progress | The bounded implementation slice is actively being worked.                                                                          |
| Review      | Implementation and required automated verification are complete; human or specialist review remains.                                |
| Blocked     | A named dependency, decision, failure, or unavailable owner prevents progress.                                                      |
| Deferred    | Work is intentionally postponed and must not be implemented as part of the current slice.                                           |
| Done        | Acceptance criteria, code, tests, documentation synchronization, and required review are complete.                                  |

An agent must not treat `Planned`, `Todo`, or `Inbox` work as independently delegable implementation.

An issue may move to `Ready` only when the requirements in this checklist are satisfied.

---

## 3. Definition Of Ready

Before beginning implementation, confirm that the work packet declares all applicable information below.

### 3.1. Required Identity

Confirm:

- GitHub issue number or explicit user-authorized task
- issue title or task name
- primary ownership area
- specific capability, surface, module, component family, or tooling owner
- intended execution mode
- expected delivery state

### 3.2. Required Scope

Confirm:

- requested outcome
- in-scope behavior
- explicit non-goals
- affected user or system workflow
- compatibility expectations
- files or areas known to be affected
- files or areas explicitly out of scope

Do not infer a broad refactor from a narrow request.

### 3.3. Required Acceptance Criteria

Acceptance criteria must be observable.

They should identify applicable:

- behavior that must succeed
- behavior that must be rejected
- data that must be stored or returned
- routes or interfaces that must remain stable
- expected side effects
- required events, audit records, or notifications
- expected UI states
- required tests
- required documentation updates
- required manual review

An issue is not ready when completion depends on undefined phrases such as:

- make it production-ready
- improve security
- clean up the architecture
- finish the feature
- match the design
- handle edge cases

These phrases may appear only when supported by explicit acceptance criteria.

### 3.4. Required Canonical Owners

Confirm links or paths for every applicable owner:

- architecture
- feature behavior
- execution flow
- database contract
- coding standard
- security standard
- UI contract
- runbook
- accepted decision record
- implementation planning source

Planning documents may establish sequencing and intent, but they do not replace canonical behavior, schema, security, or operational owners.

### 3.5. Required Implementation Boundaries

Confirm:

- expected file archetypes
- expected owner directories
- applicable stubs or generators
- required integration boundaries
- prohibited dependencies
- compatibility or migration constraints
- whether existing URLs, keys, tables, or contracts must remain stable

### 3.6. Required Security And Data Information

For protected or data-bearing work, confirm:

- actor
- action
- target
- scope
- authorization mechanism
- validation boundary
- data classification
- tenant or workspace isolation rule
- audit requirement
- monitoring requirement
- secret or sensitive fields
- export, retention, or deletion implications

### 3.7. Required Mutation And Reliability Information

For mutations, jobs, webhooks, imports, or other retryable work, confirm:

- transaction owner
- rollback behavior
- concurrency risk
- retry behavior
- idempotency requirement
- duplicate-delivery behavior
- after-commit effects
- remote side-effect ordering
- expected failure states

### 3.8. Required Verification Information

Confirm:

- targeted tests
- broader tests when required
- formatter or lint requirements
- build requirements
- PostgreSQL verification where applicable
- browser tests where applicable
- documentation guardrails
- unresolved-placeholder checks when generated files are involved
- required manual review

### 3.9. Required Dependencies And Decisions

Confirm:

- blocking issues are complete
- required decisions are accepted
- required migrations or contracts exist
- required standards exist
- required runbooks exist when operational behavior depends on them
- unresolved planning questions do not affect the slice

An issue is not `Ready` while a relevant blocking decision remains open.

### 3.10. Required Stop Conditions

The work packet should identify known circumstances that require the agent to stop rather than infer.

Examples include:

- unresolved owner placement
- unclear permission vocabulary
- missing table contract
- unspecified destructive migration behavior
- unspecified UI design
- conflicting standards
- missing security review
- unavailable external service contract

When the Definition of Ready is not satisfied, move or keep the issue in `Planned`, `Todo`, or `Blocked` and report the missing inputs.

---

## 4. Identify The Work Packet

Confirm:

- GitHub issue number or explicit user task
- requested outcome
- acceptance criteria
- in-scope behavior
- out-of-scope behavior
- ownership area
- implementation dependencies
- execution mode
- expected status or delivery state

Read the complete issue, including linked decisions and comments that materially change scope.

Do not implement from the issue title alone.

Do not implement the entire planning matrix row when the issue defines only one bounded slice.

Do not expand the work packet based on nearby technical debt.

---

## 5. Inspect The Working Tree

Before editing:

- inspect `git status`
- identify the current branch
- identify unrelated staged files
- identify unrelated unstaged files
- identify untracked files
- identify whether another writer owns the same worktree
- avoid overwriting unrelated work
- avoid resetting files not owned by the task
- do not use `git add .` in a dirty working tree
- stage explicit files only when staging is requested

Record any pre-existing failures or unrelated changes that may affect verification.

Stop when unrelated work makes safe editing unclear.

---

## 6. Select The Execution Mode

Classify the work using one of these modes.

| Execution Mode                         | Appropriate Use                                                                                                                                                                          |
| -------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Human-led                              | Architecture decisions, visual design creation, destructive migration strategy, production operations, legal/privacy interpretation, risk acceptance, or unresolved high-impact choices. |
| Codex-assisted                         | Human owns the implementation direction while the agent performs bounded analysis, drafting, mechanical edits, or verification.                                                          |
| Codex-delegable                        | The issue is fully ready, low-to-moderate risk, bounded, and covered by established standards and tests.                                                                                 |
| Codex-delegable with specialist review | The issue is fully ready for implementation but requires mandatory security, data, database, UI, or operational review before completion.                                                |

Examples that normally require specialist review include:

- authentication and MFA
- permissions and access policy
- service accounts and API tokens
- webhooks
- sensitive exports
- secrets
- audit evidence
- security middleware
- retention and erasure
- concurrency-sensitive writes
- destructive or high-volume migrations

The selected execution mode must not be used to bypass stop conditions.

---

## 7. Identify The Owner Layer

Choose one primary owner:

- Core Capability
- Platform Surface
- Business Module
- Shared UI
- Database
- Docs
- Ops
- Tests
- Tooling

Then identify the specific capability, surface, module, component family, documentation branch, or tool owner.

Use the current ownership model:

- Core Capability → `app/Core/*`
- Platform Surface → `app/Platform/*`
- Business Module → `Modules/*`
- Shared UI → `resources/views/components/*`, `resources/css/*`, `resources/js/*`
- Source templates → `stubs/*`
- Database implementation → `database/*`
- Automated tests → `tests/*`
- Canonical documentation → `docs/*`

Do not default reusable application behavior to Platform.

Do not create a new owner folder merely because a planning matrix lists it as a future possibility.

Stop when multiple layers have credible competing ownership.

---

## 8. Identify The File Archetype

For every file to be created or materially changed, classify it using:

- [File Archetypes](File%20Archetypes.md)

Examples:

- controller
- Form Request
- action
- service
- query object
- DTO
- page-data object
- value object
- enum
- result object
- application exception
- model
- policy
- middleware
- event
- listener
- job
- command
- migration
- factory
- seeder
- Blade component
- URL view
- CSS component
- JavaScript control
- feature test
- unit test
- browser test
- documentation file
- generator
- source template

For each file, confirm:

- primary responsibility
- allowed dependencies
- forbidden responsibilities
- expected tests
- expected owner path

Stop when a file has multiple competing primary responsibilities.

---

## 9. Read Applicable AGENTS Files

Read in this order:

1. root `AGENTS.md`
2. nearest parent `AGENTS.md`
3. target folder `AGENTS.md`
4. more specific nested `AGENTS.md` when present

When editing source templates, also read:

- `stubs/AGENTS.md`

When editing documentation standards, also read:

- applicable `docs/**/AGENTS.md`

Closer folder instructions refine root rules.

An `AGENTS.md` file must not override canonical architecture, feature, database, security, or coding truth.

When an agent instruction appears to conflict with a canonical owner, stop and report the conflict.

---

## 10. Select Applicable Skills

Review available project skills under:

    .agents/skills/

Select the smallest skill or skill set that matches the work.

Potential skill categories include:

- general implementation slice
- file implementation
- database change
- UI component
- security-sensitive change
- verification and review

A skill defines a repeatable execution procedure.

A skill does not replace:

- the GitHub issue
- acceptance criteria
- canonical documentation
- folder-level `AGENTS.md`
- coding standards
- file archetypes
- stubs
- tests

When multiple skills apply:

1. use the general implementation workflow as the outer procedure
2. use the specialized skill for the affected area
3. follow the most specific applicable `AGENTS.md`
4. defer durable behavior to canonical standards

Do not use a skill to broaden task scope.

Do not use a skill that assumes missing architecture, security, schema, or design decisions.

When no skill applies, continue with this checklist and report the missing reusable workflow after completing the bounded task.

---

## 11. Read Canonical Standards

At minimum, inspect:

- [Coding Standards](Coding%20Standards.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [File Archetypes](File%20Archetypes.md)

When creating files from source templates or changing generator behavior, also inspect:

- [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)

Then inspect applicable specialized standards:

- application actions, services, and data objects
- errors and exceptions
- transactions, concurrency, and idempotency
- events, jobs, and queues
- query and performance
- database
- security
- UI
- logging
- documentation
- deployment or operations

Prefer targeted section reads over loading unrelated documents.

Do not rely on remembered standards when the repository contains a current canonical file.

---

## 12. Read Canonical Owner Docs

Identify the durable owner documents affected.

Potential owners include:

- architecture
- feature behavior
- execution flow
- database contract
- security standard
- UI contract
- accepted decision record
- runbook
- planning source

Confirm:

- which document defines current behavior
- which document defines future intent
- which document defines implementation status
- which document must be updated when the implementation changes

Do not implement from a planning note alone when canonical owner documents already exist.

Do not treat the Core Service Build Plan Matrix as final architecture, schema, feature, or runbook truth.

When planning and canonical documents disagree, stop and report the conflict.

---

## 13. Confirm Decisions And Dependencies

Before implementation, identify:

- accepted decisions that control the slice
- open decisions that affect the slice
- blocking issues
- required prior migrations
- required prior capability foundations
- required standards or contracts
- external package or service dependencies
- compatibility dependencies
- expected follow-up work

Do not solve an open architecture decision incidentally inside an implementation issue.

Do not create future folders, tables, registries, or abstractions solely because they appear as deferred candidates in planning.

Stop when a required decision is still open.

---

## 14. Inspect Nearby Implementation

Inspect:

- current implementation
- current tests
- interfaces and contracts
- related services and actions
- related DTOs and queries
- configuration
- routes
- policies
- migrations
- current database contracts
- current UI component contracts
- CSS and JavaScript owners
- recent compliant patterns in the owning folder
- relevant framework behavior

Determine whether nearby code is:

- current
- transitional
- deprecated
- compatibility-only
- scheduled for replacement

Use nearby files as references only after confirming they are current and compliant.

Do not copy deprecated shapes merely because they are common.

Do not reintroduce removed UI Reference or `reference.php` ownership assumptions.

---

## 15. Check Approved Stubs And Generators

After selecting the file archetype, check whether an approved source template exists under:

    stubs/

Review:

- [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)

Use an approved stub when:

- it matches the selected archetype
- it reflects current project standards
- its owner and destination are appropriate
- its structure reduces mechanical work without forcing incorrect behavior

Do not select an archetype merely because a stub exists.

When using a stub:

1. copy or generate it through the approved mechanism
2. replace every required placeholder
3. remove optional sections that do not apply
4. add actual types, dependencies, contracts, and behavior
5. remove scaffold-only comments
6. validate the generated output
7. confirm no unresolved placeholders remain

Check generated paths with:

    rg -n "\{\{[^}]+\}\}" <generated-path>

An unresolved placeholder is a generation failure.

When using a custom generator, confirm:

- the generator owns the selected template
- required arguments are present
- destination paths are valid
- existing files are protected
- optional files are omitted when not applicable
- dry-run or preview behavior is used when available
- generated files are reviewed rather than accepted blindly

Do not activate or modify a root-level Laravel framework override without confirming the installed generator, expected filename, supported placeholders, and representative Artisan output.

---

## 16. Confirm Security And Data Boundaries

Before changing protected behavior, identify:

- actor
- action
- target
- scope
- authentication requirement
- authorization mechanism
- object-level authorization
- tenant or workspace isolation
- request validation
- audit requirement
- monitoring requirement
- data classification
- secret or sensitive fields
- export or download implications
- retention or erasure implications
- notification redaction requirements
- log redaction requirements

Verify both allowed and denied behavior.

Do not rely only on route-level access when object-level authorization is required.

Do not expose raw models, secrets, credentials, tokens, or sensitive metadata through generic serialization.

Stop when any high-risk boundary is unresolved.

---

## 17. Confirm Transaction And Failure Behavior

For mutations, identify:

- transaction owner
- durable write set
- rollback behavior
- concurrency risk
- locking requirement
- duplicate or retry risk
- idempotency key or strategy
- after-commit side effects
- event timing
- notification timing
- audit timing
- remote side-effect ordering
- expected exceptions
- expected result states
- user-facing failure behavior
- operational failure evidence

Do not:

- add remote side effects inside a transaction without explicit design
- dispatch dependent work before commit
- retry non-idempotent behavior without duplicate protection
- swallow exceptions broadly
- return generic success when durable work failed
- log raw sensitive values

Stop when transaction ownership, retry behavior, or failure semantics are unclear.

---

## 18. Confirm UI Authority

For UI work, identify:

- Shared UI, shell, Platform, Core, or Business Module owner
- public component contract
- Blade owner
- CSS owner
- JavaScript owner
- test owner
- canonical design source
- expected visual behavior
- supported variants and states
- accessibility requirements
- browser interaction requirements
- manual review surface

Do not require deprecated UI Reference or `reference.php` files.

Use current component contracts, standards, approved designs, screenshots, or explicit user direction as the visual authority.

Codex must not independently redesign:

- spacing
- layout
- hierarchy
- typography
- color treatment
- interaction behavior
- responsive behavior
- component API
- accessibility behavior

When JavaScript behavior is introduced:

- initialization must be idempotent
- selectors must align with the Blade contract
- browser behavior must receive Playwright coverage where applicable

Manual visual review remains required for design-sensitive changes.

Stop when design direction is not explicit.

---

## 19. Plan The Smallest Safe Change

Before editing, list:

- files to modify
- files to create
- files to delete
- files explicitly out of scope
- file archetypes
- stubs or generators to use
- compatibility behavior to preserve
- tests to add or update
- docs to update
- verification commands
- manual review requirements
- known risks
- stop conditions

Confirm that each proposed file supports an acceptance criterion.

Avoid:

- broad rewrites
- unrelated cleanup
- speculative abstractions
- premature registries
- premature dashboards
- premature persistence
- future-proofing without a current requirement
- renaming unrelated paths
- altering public interfaces outside the issue

When the implementation plan becomes materially larger than the issue, stop and request a scope decision.

---

## 20. Implement To The Archetype

During implementation:

- preserve ownership boundaries
- use strict types for new PHP files
- use explicit native types
- use constructor injection where appropriate
- use validated input
- use explicit authorization
- protect mass assignment
- keep controllers and views thin
- keep actions focused
- keep services cohesive
- keep queries scoped and bounded
- keep transactions focused
- keep asynchronous payloads small and safe
- preserve PostgreSQL behavior
- avoid raw secrets or sensitive logs
- maintain comments and file headers according to standards
- remove temporary debugging
- preserve compatibility unless the issue explicitly authorizes a break
- implement only the bounded acceptance criteria

Generated files must be completed as real source files.

Do not leave:

- unresolved placeholders
- scaffold-only methods
- empty public APIs without an intentional contract
- meaningless comments
- fake return values
- permissive authorization defaults
- incomplete required tests

---

## 21. Add Or Update Tests

Use the narrowest tests that prove the change.

Verify as applicable:

- successful behavior
- validation failure
- unauthenticated denial
- unauthorized denial
- object-level denial
- cross-tenant or cross-workspace denial
- transaction rollback
- concurrency behavior
- duplicate execution
- retry behavior
- idempotency
- after-commit behavior
- exception translation
- audit behavior
- monitoring behavior
- notification behavior
- PostgreSQL behavior
- migration behavior
- UI component contract
- semantic markup
- accessibility wiring
- browser interaction
- documentation guardrails
- generator output

Do not:

- delete or weaken tests to make the task pass
- use unconditional passing assertions
- leave required `markTestIncomplete()` calls
- use snapshots as a substitute for critical contract assertions
- use SQLite-only tests when PostgreSQL behavior matters
- claim manual visual behavior is covered by automated tests

When behavior is intentionally unchanged, add regression coverage where the issue risk justifies it.

---

## 22. Synchronize Documentation

Update documentation when the implementation changes:

- behavior
- ownership
- schema
- route contracts
- file placement
- public API
- security boundaries
- operational behavior
- implementation status
- agent workflow
- source templates
- generators

Check applicable:

- canonical owner document
- architecture document
- feature contract
- flow
- database contract
- planning status
- runbook
- accepted decision record
- standard
- index
- `AGENTS.md`
- skill
- `stubs/README.md`

Use:

- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Do not use the planning matrix as an implementation worklog.

Do not update broad planning status when only a small sub-slice is complete.

Do not mark a capability implemented while required verification or review remains incomplete.

---

## 23. Run Verification

Run the narrowest relevant commands first, followed by broader checks required by the risk and acceptance criteria.

Potential checks include:

- unresolved-placeholder scan
- PHP syntax
- formatter
- static analysis
- targeted Laravel tests
- broader Laravel test suite
- PostgreSQL-backed tests
- migration tests
- frontend production build
- Playwright browser tests
- documentation guardrails
- link checks
- generator tests
- custom repository verification commands
- manual visual review

When a repository-level verification command exists, use it as the standard baseline and add specialized checks required by the task.

Do not claim a check passed unless it ran successfully.

For each check, record:

- exact command
- result
- relevant failure
- whether the failure existed before the task
- whether the failure blocks completion

When a required check cannot run, report:

- why it could not run
- what remains unverified
- who or what must complete the check

Automated success does not replace required specialist or visual review.

---

## 24. Review The Diff

Before reporting, staging, or committing:

- inspect `git status`
- inspect changed file names
- inspect staged file names
- inspect the complete diff
- confirm no unrelated files are included
- confirm no unexpected generated files exist
- confirm no unresolved placeholders remain
- confirm no debug output remains
- confirm no secrets or credentials are present
- confirm comments and headers are current
- confirm imports and dependencies are intentional
- confirm public APIs match contracts
- confirm docs and index links are updated
- confirm deleted files are intentional
- confirm compatibility behavior remains intact
- confirm acceptance criteria are addressed

Do not use `git add .` when unrelated changes exist.

Do not include formatter changes to unrelated files without explicit scope.

---

## 25. Prepare The Review Handoff

Before moving work to `Review`, confirm:

- implementation is complete for the bounded issue
- required automated checks passed
- required documentation is synchronized
- known failures are recorded
- manual review requirements are listed
- specialist review requirements are listed
- acceptance criteria can be reviewed individually
- no unresolved implementation decision remains hidden in the code

Identify the required reviewer type when applicable:

- general code review
- architecture review
- database review
- security review
- privacy or data-governance review
- UI and accessibility review
- operational review

An issue must remain `In Progress` or move to `Blocked` when required implementation or verification is incomplete.

Use `Review` when the implementation is ready for the identified human checks.

---

## 26. Report The Result

The final work report must include:

- issue or task handled
- execution mode
- ownership area and specific owner
- acceptance criteria addressed
- files created
- files modified
- files deleted
- stubs or generators used
- behavior changed
- compatibility preserved or intentionally changed
- docs updated
- tests added or changed
- verification commands run
- verification results
- checks not run
- manual review still required
- specialist review still required
- known gaps
- pre-existing failures encountered
- follow-up work discovered but not implemented

Distinguish clearly between:

- completed work
- verified work
- manually reviewed work
- deferred work
- blocked work
- suggested follow-up work

Do not state that work is complete when required verification, documentation synchronization, specialist review, or manual visual review remains outstanding.

Do not claim that a planning row or capability is complete when only one bounded issue was implemented.

---

## 27. Stop Conditions

Stop and ask when:

- the Definition of Ready is not satisfied
- task scope is ambiguous
- acceptance criteria are not observable
- ownership area is unclear
- file archetype is unclear
- standards conflict
- canonical docs conflict with implementation
- planning conflicts with canonical ownership
- a required decision remains open
- a required dependency is incomplete
- the change requires a new dependency not authorized by the issue
- the change alters auth, access, security, data, schema, or deployment beyond accepted scope
- destructive behavior lacks a rollback or recovery plan
- a migration lacks an approved schema contract or data strategy
- transaction ownership is unclear
- retryable behavior lacks an idempotency strategy
- a protected action lacks an authorization model
- tenant or workspace scope is unclear
- sensitive data handling is unresolved
- UI work requires unspecified design judgment
- a stub or generator would produce unresolved or contradictory output
- tests fail in a way that materially changes the implementation plan
- required verification cannot run
- unrelated dirty work may be overwritten
- multiple implementation paths have materially different consequences
- completing the task would require broad unrelated cleanup
- a human-led decision is being implicitly delegated to the agent

When stopping, report:

- the exact ambiguity or blocker
- why it prevents safe implementation
- the canonical owner that should resolve it
- the minimum decision or information needed to continue

---

## 28. Related

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
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)
