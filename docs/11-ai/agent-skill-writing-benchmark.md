# Agent Instruction Writing Benchmark

## Purpose

Define the benchmark for auditing and updating repo instruction files used by AI coding agents.

This benchmark now covers:

- root and nested `AGENTS.md` guidance
- repo-owned `SKILL.md` workflow files
- the boundary between instruction files and canonical docs
- source weighting for future governance reviews

This note is an audit aid. It does not require every instruction file to have the same structure or length. It does require each instruction surface to carry the right kind of information, at the right depth, with the right authority.

## Core Model

The repo should not treat all “agent files” as interchangeable.

Use this operating split:

| Surface | Primary job | Typical content |
|---|---|---|
| `AGENTS.md` | persistent rules and execution norms | repo boundaries, approval gates, coding constraints, preferred command paths, doc/governance rules |
| nested/scoped `AGENTS.md` | narrower overrides close to specialized work | domain- or directory-specific rules that should not burden the repo root |
| `SKILL.md` | task workflow and execution playbook | when to use the workflow, what to read first, ordered steps, stop conditions, outputs |
| canonical docs | product, architecture, planning, database, and operational truth | durable system knowledge that should be linked, not duplicated |
| repo-local memory | non-canonical working memory | preferences, heuristics, open loops, short continuity notes that should not become source-of-truth docs |
| exportable baselines | reusable starter scaffolding | generic starter packs, snippets, and install guidance for other repos |
| `09-reference/` or support notes | non-canonical background and research | support material that may inform instructions but should not silently replace canonical owners |

The benchmark should preserve this separation. A strong audit does not only ask whether an instruction file is thorough. It asks whether the instruction is living in the correct surface at all.

## Source Hierarchy

Future instruction-file changes should use a clear source hierarchy.

| Source class | Role in benchmark decisions |
|---|---|
| official product docs | define behavior, discovery rules, and supported capabilities |
| repo-owned standards and runbooks | define local policy and canonical ownership |
| strong secondary examples | inform commercial heuristics and authoring patterns |
| community threads, gists, issues, blog summaries | discovery only unless corroborated |

Apply this rule consistently:

- official docs define platform behavior
- repo docs define repo policy
- secondary sources may suggest heuristics
- discovery-only sources do not become standards by default

## Instruction Surface Placement Rules

Before changing or creating an instruction file, confirm the information belongs there.

### Information That Belongs In `AGENTS.md`

- repo-wide or subtree-wide rules
- approval and automation boundaries
- persistent command preferences
- stable verification expectations
- permanent file-ownership and workflow rules

### Information That Belongs In `SKILL.md`

- when to execute a specific workflow
- what must be read first
- ordered execution steps
- stop conditions
- expected outputs or state updates
- failure recovery and escalation behavior for that workflow

### Information That Belongs In Repo-Local Memory

- non-canonical operator preferences
- repo heuristics and recurring gotchas
- open loops that outlive a single chat but are not canonical workflow state
- compact session continuity notes

Repo-local memory should not be the final home for durable execution policy, workflow design, or canonical system truth.

### Information That Belongs In Exportable Baselines

- generic scaffolding that another repo can copy
- starter skill files for reusable local patterns
- setup snippets and configuration examples

Exportable baselines should stay generic and should not absorb live repo-specific memory.

### Information That Should Stay In Canonical Docs

- architecture explanation
- feature behavior and contracts
- planning intent and sequencing
- database truth
- operational runbooks
- long-form product or subsystem context

If a skill or `AGENTS.md` is carrying large amounts of canonical product explanation, the benchmark should treat that as duplication risk unless it is reduced to a concise execution-facing summary with links outward.

## Repo Canonical Mapping

Generic AI-documentation advice must be normalized against this repo’s existing docs system.

Use these existing owners:

- roadmap and sequencing -> `docs/07-planning/`
- active implementation status -> `docs/08-active/`
- chronological delivery traceability -> `docs/08-active/worklogs/`
- planning/doc sync expectations -> `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`
- decision records -> `docs/01-decisions/`
- durable rationale for broad decisions -> ADRs in `docs/01-decisions/`

Do not add generic files like `roadmap.md`, `implementation_status.md`, `decisions.md`, or `context.md` unless the repo first determines that no canonical branch already owns that responsibility.

For agent-facing non-canonical information:

- repo-local working memory -> `.agents/memory/`
- exportable starter scaffolding -> `.agents/baselines/`

## Benchmark For `AGENTS.md`

### What Strong `AGENTS.md` Files Should Do

Strong `AGENTS.md` files should:

- declare scope clearly
- lead with the highest-value operational rules
- define explicit file and workflow boundaries
- state approval gates for risky actions
- provide exact command paths where reproducibility matters
- direct specialized work into narrower files rather than overloading the root

### Commercial Authoring Heuristics

These are useful heuristics, not hard platform rules:

- prefer command-first structure over explanation-first structure
- keep root instruction files compact and high-signal
- push detailed domain guidance into narrower scopes when possible
- prefer targeted verification commands before full-suite defaults
- point to known-good and known-avoid examples where that materially reduces ambiguity

Do not treat numeric advice such as “150 lines or less” as a mandatory rule unless the repo explicitly adopts it as a local convention. The benchmark should prefer “concise and high-signal” over arbitrary length policing.

### Root File Audit Questions

1. Does the file clearly define repo-wide rules rather than mixing in task-specific workflows?
2. Are the highest-value commands and safety boundaries easy to find early?
3. Are risky actions gated appropriately?
4. Is the root file carrying detail that should move into a narrower instruction surface?
5. Does it point to canonical docs instead of duplicating long-form system knowledge?
6. Does it preserve the repo’s actual workflows instead of flattening them into generic advice?

## Benchmark For Scoped Or Nested `AGENTS.md`

Scoped `AGENTS.md` files should exist only when the narrower area truly needs additional standing rules.

Use them for:

- technology- or subsystem-specific overrides
- narrower testing/build commands
- local file ownership exceptions
- domain-specific safety boundaries

Audit questions:

1. Is the narrower file justified by real specialization?
2. Does it override or extend the parent rules cleanly?
3. Does it avoid repeating the full root file unnecessarily?
4. Is the scope obvious from directory placement and content?

## Benchmark For `SKILL.md`

The repo’s skill benchmark remains execution-focused.

### Core Lifecycle Coverage

A dependable skill should define:

- when to use it
- what must be read first
- what files or docs are authoritative
- the ordered execution path
- what must never be done
- when to stop and ask
- what state or artifacts must be written back

### Higher-Risk Skills Should Also Define

- prerequisite checks
- exact read/write scope
- state transition rules
- failure recovery
- examples or anti-patterns
- validation requirements
- escalation boundaries

### Skill Audit Questions

1. Does the skill identify exact source-of-truth inputs?
2. Does it distinguish files it may read from files it may update?
3. Does it define deterministic execution order?
4. Does it define real stop conditions rather than vague caution?
5. Does it specify what evidence or records must be written after execution?
6. Does it clarify whether commit, deploy, archive, or reset actions are required, forbidden, or conditional?

## Decision Record Benchmark

Instruction files should respect the repo’s ADR elevation rule.

Keep decisions in canonical owner notes by default.

Elevate into `docs/01-decisions/` when the decision is:

- cross-cutting across branches, subsystems, or phases
- long-lived enough to need durable rationale
- superseding or replacing an earlier accepted decision
- important enough to need explicit lifecycle state such as `Proposed`, `Accepted`, `Deprecated`, or `Superseded`

Instruction files should not invent parallel decision ledgers or scatter local `decisions.md` files.

## Implementation Status And Traceability Benchmark

Instruction files should reinforce, not replace, the repo’s existing status-tracking model.

Preferred traceability surfaces:

- planning notes for sequencing and intent
- canonical docs for current implemented truth
- `docs/08-active/` for active batch state
- worklogs for dated execution history, commit status, deploy status, and follow-up work

The benchmark should prefer:

- dated worklogs
- batch or pass IDs
- commit and deploy references where relevant

over:

- ad hoc status files
- free-floating “last updated” notes used as the primary history source
- duplicate delivery ledgers outside canonical owners

## Memory And Baseline Benchmark

Repo-local memory should:

- stay non-canonical
- stay concise and prunable
- point outward to canonical owners when needed
- promote durable rules into `AGENTS.md`, skills, or canonical docs instead of hoarding them

Exportable baselines should:

- remain generic
- avoid live repo-specific memory
- include just enough scaffolding and setup guidance for another repo to adopt them intentionally

## Obsidian And Canonical Docs Constraints

This repo still operates as a documentation vault with explicit branch ownership and link discipline.

Instruction-file guidance must therefore preserve:

- stable canonical paths
- index-based navigation
- one-concept-one-owner discipline
- explicit markdown linking

Do not optimize for agent convenience in a way that degrades the docs graph or creates overlapping ownership.

## Expected Outcome Of The Audit

After audit and update work, the repo should have:

- `AGENTS.md` files that are concise, operational, and correctly scoped
- `SKILL.md` files that act as real execution playbooks rather than summaries
- clear separation between instruction files and canonical docs
- explicit source weighting in future AI-governance updates
- no generic AI-context files that duplicate existing planning, worklog, or decision owners

## Final Guidance

Use official docs to determine platform behavior.

Use repo standards to determine local policy.

Use strong secondary examples to improve authoring quality.

Use community sources to discover ideas, not to define rules.

The standard for this repo should be:

- compact when the instruction surface is always-on
- deeper when the workflow is fragile or risky
- explicit wherever workflow state, canonical docs, approvals, or destructive actions are involved
- disciplined about reusing the repo’s existing planning, worklog, and decision systems instead of inventing new ones
