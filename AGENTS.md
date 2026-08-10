# AGENTS.md

## Project Context

This repository contains Login App 2.0, a Laravel-based platform intended to replace the current customized Perfex 1.0 foundation over time.

This file defines persistent repository rules for Codex and other AI coding agents. It is an execution contract, not a product specification.

---

## Operating Model

- GitHub Issues are the current work packets.
- GitHub Projects are the sequencing and status layer.
- Pull requests are the review and implementation evidence layer.
- `/docs/` is the canonical source of product, architecture, standards, planning, database, runbook, and governance truth.
- `AGENTS.md` files and `.agents/skills/` are agent guidance only. They must route agents to canonical docs instead of duplicating canonical truth.

Do not use the old `/docs/08-active/` batch workflow unless the user explicitly asks to inspect, archive, migrate, or recover historical batch material.

Deprecated workflow terms such as `batch-start`, `work-batch`, `change-queue`, `Implemented Pending Review`, and `Passed Review` are historical unless an issue explicitly says otherwise.

---

## Core Principles

- Treat this repository as the source of truth for Login App 2.0.
- Keep the Perfex 1.0 repository as reference only unless explicitly instructed otherwise.
- Use the stack and runtime already present in this repository unless a decision record changes it.
- Do not introduce new framework, database, queue, cache, auth, UI, deployment, or infrastructure dependencies without explicit approval.
- Prefer data-driven configuration over file-copy-driven behavior.
- Do not build meaningful untracked application code directly on a production server.
- Make narrow, reviewable changes.
- Do not “clean up” unrelated files while completing a scoped issue.
- Stop when scope, ownership, or expected behavior is unclear.

---

## Canonical Documentation Rules

Treat `/docs/` as the canonical root for active documentation.

Ignore these unless explicitly requested:

- `/docs/_archive/`
- historical phase or batch records
- old `/docs/08-active/` workflow state
- long research artifacts not named by the issue

Do not introduce legacy documentation paths or outdated references.

### Documentation Branch Responsibilities

- `docs/01-decisions/` → ADRs and elevated decision records only.
- `docs/02-standards/` → rules and standards only.
- `docs/03-architecture/` → system structure and boundaries only.
- `docs/04-features/` → user/system behavior only.
- `docs/05-flows/` → execution paths only.
- `docs/06-database/` → schema, tables, constraints, and data contracts only.
- `docs/07-planning/` → sequencing, implementation intent, and planning matrices only.
- `docs/09-reference/` → non-canonical support/reference material only.
- `docs/10-runbooks/` → operations and recovery procedures only.
- `docs/11-ai/` → AI review/governance artifacts only when an issue explicitly targets that area.

Always respect branch ownership. Do not duplicate or reassign responsibility across branches.

---

## Source-of-Truth Priority

When instructions conflict, use this priority order:

1. Explicit user instruction in the current task.
2. Security/safety requirements.
3. Root `AGENTS.md`.
4. Nearest folder-level `AGENTS.md`.
5. Canonical docs in `/docs/`.
6. Existing implementation patterns.
7. Agent skill guidance.
8. Inference.

If conflict remains after reading the relevant sources, stop and ask.

---

## GitHub Issue Workflow

For implementation work, start from the GitHub issue or the user-provided task.

Before editing files:

- Identify the issue number or task scope.
- Identify the intended repository work owner area: Core, Module, UI, Docs, Ops, or Tests.
- When recording application architecture ownership, use ADR-0005 `ownership_area` values `core`, `module`, or `ui`; Docs, Ops, and Tests are repository workflow owners rather than application ownership areas.
- Identify the canonical docs that govern the change.
- Identify the expected files or folders in scope.
- Identify the required verification path from the issue and applicable Testing standards.
- For implementation work, read `docs/02-standards/coding/Agent Implementation Checklist.md` before the first production write.
- Check the working tree and avoid unrelated changes.

Do not create, edit, close, relabel, or reprioritize GitHub issues or Project fields unless the user explicitly asks.

Do not create broad “future work” issues unless requested. If a related issue is found during implementation, mention it in the final report instead of expanding scope.

---

## Architecture Boundaries

Use [ADR-0005: Core, Modules, And UI Ownership Taxonomy](docs/01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md).

### Core

Core owns required base-application behavior, state, coordination, infrastructure, and contracts that must operate without optional Modules.

Examples include:

- Auth
- Identity
- Access
- DataGovernance
- DataProtection
- Security
- Audit
- Monitoring
- Notifications
- Settings
- Preferences
- Workspace
- Navigation
- Dashboard
- Setup
- registries, Module lifecycle, and contribution discovery

Core does not own one consolidated `Shell` capability. Workspace and Navigation own application-state resolution for the persistent Frame, while UI owns the reusable Frame Layout and rendering contracts. The persistent Frame is limited to Global Header Navigation, Sidebar Navigation, and the Main content outlet.

Core may expose routes, services, policies, events, migrations, tests, account/admin surfaces, and presentation adapters when it owns the underlying responsibility.

Current `app/Platform/*` paths are transitional physical locations, not a separate source-of-truth owner. Accepted target topology is owned by `docs/03-architecture/repository-architecture.md`.
Do not add new canonical Platform ownership. Bounded maintenance, compatibility, or migration work requires accepted issue scope, target ownership, compatibility direction, and verification.

### Modules

Modules own optional, cohesive feature sets that may be installed, enabled, assigned, updated, disabled, or omitted without breaking Core.

Every Module must be an independently versioned, installable, and distributable Composer package with a formal Module definition.

Modules may require and extend other Modules only through explicit version constraints, declared dependencies, and public contracts. Modules must consume Core capabilities instead of redefining authentication, authorization, audit, notifications, settings, data protection, security, or other required base behavior.

### UI

UI owns the reusable interface system:

- Elements
- Components
- Patterns
- Layouts
- design tokens and icons
- reusable CSS and JavaScript controls
- UI contracts, tests, references, and review evidence

UI must not own route behavior, authorization decisions, database access, domain queries or mutations, Core policy, Module behavior, or Module discovery.

A file under `resources/` is not automatically UI-owned. URL views remain owned by the Core area or Module whose behavior they present.

### Dependency Direction

- Core must operate without optional Modules.
- Modules may depend on Core and UI.
- Core presentation may depend on UI; Core business and system logic may not.
- UI may not depend on Core or Module domain implementation.
- Module-to-Module dependencies must be explicit, versioned, declared, and contract-based.
- Every distinct responsibility has one primary owner.

## Implementation Rules

- Only modify files directly required for the current issue/task.
- Prefer small explicit changes over broad rewrites.
- Preserve existing naming, conventions, tokens, contracts, and public APIs unless the issue requires a change.
- Do not move files across architecture boundaries without accepted scope, canonical target placement, compatibility direction, and migration authority.
- Do not change behavior while “just reorganizing” unless the issue explicitly asks for both.
- Do not add new abstractions before there is a repeated implementation need.
- Do not silently delete or replace existing tests.
- Do not use generated code as a substitute for understanding the existing implementation.
- Do not leave temporary debugging output, dump statements, console logs, or commented-out code.
- Do not log secrets, tokens, MFA material, authorization headers, cookies, or sensitive personal data.
- Use FormRequest validation, policies/gates, middleware, and domain/service guardrails according to existing Laravel conventions.
- Do not use state-changing GET routes.
- Do not bypass authorization checks on protected routes or actions.
- Do not expose protected files through public storage.

---

## Documentation Sync

When implementation changes canonical behavior, update the relevant docs in the same work cycle.

Update docs only where ownership matches the change:

- Standards changes go in `docs/02-standards/`.
- Architecture boundary changes go in `docs/03-architecture/`.
- Feature behavior changes go in `docs/04-features/`.
- Flow changes go in `docs/05-flows/`.
- Schema/table changes go in `docs/06-database/`.
- Sequencing/planning changes go in `docs/07-planning/`.
- Operational procedure changes go in `docs/10-runbooks/`.

Do not update docs broadly to make unrelated documentation “look current.”

If implementation and docs disagree, do not guess. Identify the conflict and ask which source should be corrected unless the issue already provides the answer.

---

## UI and Component Work Rules

Codex is not the primary visual design authority for this repository.

For UI work, Codex may implement narrowly scoped changes only when the target component, contract, reference file, CSS file, expected behavior, and review surface are specified.

Do not redesign layouts, spacing, visual hierarchy, component structure, or interaction behavior from screenshots alone. Manual visual approval remains required for design-sensitive work.

### UI Tiers

- Tier 1 = primitives and baseline components.
- Tier 2 = reusable patterns.
- Tier 3 = feature/module/application surfaces.

Rules:

- Do not bypass tiers.
- Do not redefine primitives at higher tiers.
- Do not duplicate component logic in feature views.
- Component contracts and direct source evidence must stay aligned with implementation.
- Tests must cover public component contracts and important rendering states when applicable.
- CSS and Blade files must include the repository’s required file/header comments and relevant section comments.
- Use the unified icon component pattern where icons are required.
- Do not introduce one-off CSS when a token, primitive, utility, or existing component pattern should own the behavior.
- Do not make broad visual “improvements” without explicit direction.

For UI changes, report whether manual visual review is still required.

---

## Testing and Verification

Canonical testing and verification policy is owned by `docs/02-standards/testing/`.

Repository-specific test-source construction and maintenance are owned by `docs/02-standards/coding/test-implementation/`.

For implementation work:

- read `docs/02-standards/coding/Agent Implementation Checklist.md`;
- use the issue's accepted `AC-*` / `PF-*` verification contract;
- run the declared initial proof before production implementation when required;
- protect accepted tests, fixtures, Contracts, and review procedures from weakening or silent replacement;
- require the accepted targeted proof to pass unchanged after implementation when the verification contract requires it;
- run broader, browser, database, native-platform, manual, accessibility, security, operational, or specialist proof only as declared by the applicable contract and standards.

Do not redefine `PASS`, `FAIL`, `EXPECTED_NONPASS`, applicability, evidence, or testing-gate semantics in `AGENTS.md`.

Unexpected syntax, fixture, dependency, boot, discovery, tooling, environment, or infrastructure failures are not expected missing behavior.

Do not claim verification passed unless the exact required command or procedure ran successfully.

---

## Git and Commit Rules

Before editing or committing:

- Run or inspect `git status`.
- Identify unrelated dirty files.
- Do not overwrite unrelated changes.
- Do not stage unrelated changes.
- Do not use `git add .` unless the user explicitly approves and the working tree is known clean except for the current scoped work.

Commits should be scoped to one issue or one tightly related concern.

Only commit when the work is intentional, reviewable, and limited to the accepted scope.

Do not push, deploy, tag, release, reset, rebase, force-push, clean, or delete branches unless explicitly instructed.

If the repository already has a large dirty working tree, protect unrelated work by staging explicit file paths only.

---

## Deployment and External-State Rules

Do not perform external-state changes without explicit approval.

External-state changes include:

- Deployment.
- Staging publication.
- Production changes.
- Database migrations against shared environments.
- New dependencies.
- Infrastructure changes.
- GitHub Project/Issue mutation.
- Secret rotation.
- Cache clearing on shared environments.
- Destructive file/database operations.

Local development verification is preferred when sufficient.

---

## Agent Execution Rules

Separate these phases unless the user explicitly asks to combine them:

- planning
- implementation
- review
- remediation

Read-only planning, diagnosis, source review, and prompt generation do not require confirmation.

Writable work requires a clear scope.

Before writable work, state:

- the issue/task being handled
- the intended file scope
- the governing docs or contracts
- the verification plan

After writable work, report:

- files changed
- behavior changed
- docs updated
- tests run and results
- known remaining risks or manual review needs

Do not continue into a higher-risk task just because a previous scoped change succeeded.

---

## Folder-Level Instruction Rules

Before broad file traversal, read the nearest applicable folder-level `AGENTS.md`.

For work inside `docs/`, read `docs/AGENTS.md` and then the relevant branch-level `AGENTS.md` when one exists.

Use folder-level `AGENTS.md` files as retrieval maps and local operating rules. Do not copy agent-specific language from folder-level files into human-facing canonical docs.

Prefer:

- indexes
- headings
- exact issue references
- exact contract files
- exact planning sections
- targeted file reads

Avoid whole-repo or whole-branch context loading unless the task requires it.

When a folder-level `AGENTS.md` conflicts with this root file, this root file wins.

---

## Agent Instruction Surfaces

- Root `AGENTS.md` owns persistent repo-wide rules and operating boundaries.
- Folder-level `AGENTS.md` files own local read-scope guidance, retrieval boundaries, and folder-specific rules.
- `.agents/skills/` owns executable workflow playbooks.
- `/docs/` owns durable product, architecture, planning, database, runbook, and governance truth.
- `.agents/memory/` may own non-canonical repo-local working memory only.
- `.agents/baselines/` may own exportable generic starter packs only.

If a memory note reveals durable system truth, promote it into the correct canonical docs owner.

If a memory note reveals durable agent operating behavior, promote it into `AGENTS.md`, a folder-level `AGENTS.md`, or a skill file.

Do not store secrets, credentials, tokens, raw customer data, or production-only sensitive values in agent memory, skills, docs, comments, or logs.

---

## Skills Policy

Skills are repeatable execution playbooks. They are not canonical documentation.

Use skills for workflows such as:

- implementing from a GitHub issue
- syncing docs after implementation
- maintaining UI component contracts
- performing security foundation changes
- reviewing PRs against Login 2.0 boundaries

Skills must route to canonical docs instead of duplicating large documentation blocks.

If a skill conflicts with this root file, this root file wins.

Do not create new skills unless the workflow is expected to repeat.

---

## Repo-Local Agent Memory

`.agents/memory/` is optional, non-canonical, and prunable.

Allowed uses:

- operator preferences
- recurring repository gotchas
- compressed context summaries
- non-canonical open loops
- temporary handoff notes

Not allowed:

- canonical product truth
- canonical architecture truth
- canonical planning truth
- active issue status
- secrets or sensitive data
- customer data
- production-only information

Prefer updating existing memory notes over creating overlapping notes.

---

## Concurrency Rules

Default rule: one writable agent/session per working tree.

Supported:

- one writable session in one working tree
- multiple read-only planning/review sessions while one writer owns edits
- multiple writable sessions only when each has its own branch, worktree, and accepted scope

Not supported:

- multiple writable sessions editing the same working tree
- silently switching a read-only session into a writer while another writer owns the tree
- treating advisory notes as file locks
- relying on issue status as a concurrency lock
- overwriting unrelated dirty changes

Worktree isolation is the real safety boundary for concurrent writable work.

---

## Automation Policy

Default rule: if the next step is unclear, stop and ask.

Always allowed:

- read-only analysis
- source review
- documentation review
- workflow interpretation
- prompt drafting
- test recommendation

Allowed within an accepted scope:

- narrow implementation
- targeted docs sync
- targeted tests
- targeted formatting
- final summary

Requires explicit approval:

- new dependencies
- auth/security/database architecture changes
- data migrations
- deployment or staging publication
- destructive operations
- broad refactors
- mass formatting
- GitHub issue/project mutations
- work outside the current issue scope

Stop and ask when:

- scope is ambiguous
- ownership is ambiguous
- docs conflict
- tests fail in a way that changes the plan
- UI behavior requires design judgment
- security implications are unclear
- multiple implementation paths have materially different tradeoffs

---

## Important Docs

Start with these when the issue does not name a more specific source:

- `docs/00-start-here.md`
- `docs/02-standards/index.md`
- `docs/02-standards/coding/Agent Implementation Checklist.md`
- `docs/02-standards/coding/test-implementation/index.md`
- `docs/02-standards/testing/index.md`
- `docs/03-architecture/index.md`
- `docs/04-features/index.md`
- `docs/05-flows/index.md`
- `docs/06-database/index.md`
- `docs/07-planning/index.md`
- `docs/09-reference/index.md`
- `docs/10-runbooks/index.md`

Security-sensitive work should also inspect the relevant files under:

- `docs/02-standards/security/`
- `docs/07-planning/*security*`
- `docs/07-planning/*audit*`
- `docs/07-planning/*access*`
- `docs/07-planning/*data*`
- `docs/07-planning/*threat*`

UI-sensitive work should also inspect the relevant files under:

- `docs/02-standards/ui/`
- `docs/09-reference/ui/`
- `resources/views/components/`
- `resources/css/`

---

## Final Rule

If a change cannot be clearly tied to:

- one GitHub issue or explicit user task
- one accepted scope
- one canonical owner
- one verification path

then do not implement it yet.
