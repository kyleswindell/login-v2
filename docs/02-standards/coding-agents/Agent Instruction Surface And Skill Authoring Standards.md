<!--
DOC-META
title: Agent Instruction Surface And Skill Authoring Standards
doc_type: standard
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding-agents/Agent Instruction Surface And Skill Authoring Standards.md
parent: docs/02-standards/coding-agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines ownership, authoring, token discipline, validation, side-effect boundaries, and lifecycle requirements for AGENTS files, coding-agent skills, references, scripts, memory, and related instruction surfaces.
-->

# Agent Instruction Surface And Skill Authoring Standards

Parent: [Coding Agent Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Authority And Source Hierarchy](#3-authority-and-source-hierarchy)
- [4. Instruction Surface Ownership](#4-instruction-surface-ownership)
- [5. `AGENTS.md` Standards](#5-agentsmd-standards)
  - [5.1. Purpose](#51-purpose)
  - [5.2. Root Versus Scoped Instructions](#52-root-versus-scoped-instructions)
  - [5.3. Authoring Requirements](#53-authoring-requirements)
- [6. Skill Ownership](#6-skill-ownership)
- [7. Skill Directory Contract](#7-skill-directory-contract)
- [8. Skill Frontmatter](#8-skill-frontmatter)
- [9. Skill Body Requirements](#9-skill-body-requirements)
- [10. Progressive Disclosure And Token Discipline](#10-progressive-disclosure-and-token-discipline)
- [11. Skill References](#11-skill-references)
- [12. Skill Scripts](#12-skill-scripts)
- [13. Skill Assets](#13-skill-assets)
- [14. Skill Composition](#14-skill-composition)
- [15. Side-Effect Boundaries](#15-side-effect-boundaries)
- [16. Required Inputs And Stop Conditions](#16-required-inputs-and-stop-conditions)
- [17. Skill Outputs](#17-skill-outputs)
- [18. Skill Testing](#18-skill-testing)
- [19. Review Checklist](#19-review-checklist)
- [20. Skill Lifecycle](#20-skill-lifecycle)
- [21. Memory And Baseline Boundaries](#21-memory-and-baseline-boundaries)
- [22. Prohibited Practices](#22-prohibited-practices)
- [23. Maintenance](#23-maintenance)
- [24. Related](#24-related)

## 1. Purpose

Define where coding-agent instructions belong and how repository-owned agent instructions and skills must be written, reviewed, tested, and maintained.

The objective is to provide agents with the smallest reliable instruction set needed to perform a bounded task without duplicating canonical product, architecture, schema, security, or operational truth.

Agent convenience must not create competing documentation owners.

## 2. Scope

This standard applies to:

- repository-root `AGENTS.md`
- nested and folder-scoped `AGENTS.md` files
- `.agents/AGENTS.md`
- `.agents/skills/*/SKILL.md`
- skill-local `references/`
- skill-local `scripts/`
- skill-local `assets/`
- `.agents/memory/`
- `.agents/baselines/`
- agent instruction templates
- coding-agent workflow descriptions
- agent instruction audits
- skill trigger and behavior testing

This standard does not define:

- product behavior
- application architecture
- database schema
- feature acceptance criteria
- active issue scope
- operational runbooks
- final implementation status
- source-file templates under `stubs/`

Those responsibilities remain with their canonical owners.

## 3. Authority And Source Hierarchy

Use this source hierarchy when authoring or reviewing agent instructions.

| Source                                                     | Authority                                                       |
| ---------------------------------------------------------- | --------------------------------------------------------------- |
| Official product documentation                             | Defines supported agent, tool, skill, and instruction behavior. |
| Repository canonical standards and runbooks                | Define Login 2.0 policy and local operating requirements.       |
| Root and scoped `AGENTS.md` files                          | Define persistent repository and subtree execution rules.       |
| GitHub issue or explicit authorized task                   | Defines the current bounded work packet.                        |
| Strong secondary examples                                  | May inform authoring quality and structure.                     |
| Community posts, gists, discussions, and informal examples | Discovery only unless corroborated.                             |

Apply these rules:

- official documentation defines platform behavior
- repository standards define repository policy
- GitHub issues define current task scope
- secondary examples may improve presentation
- discovery sources must not silently become repository standards

## 4. Instruction Surface Ownership

Information must live in the surface matching its authority.

| Surface                    | Primary Responsibility                                                                                   |
| -------------------------- | -------------------------------------------------------------------------------------------------------- |
| Canonical `docs/` branches | Durable product, architecture, feature, flow, schema, planning, standards, reference, and runbook truth. |
| Root `AGENTS.md`           | Persistent repository-wide execution rules and safety boundaries.                                        |
| Scoped `AGENTS.md`         | Persistent rules specific to one directory tree.                                                         |
| `.agents/skills/`          | Repeatable task procedures and workflow playbooks.                                                       |
| GitHub issues              | Current bounded implementation scope, acceptance criteria, dependencies, and review requirements.        |
| `stubs/`                   | Mechanical source-file templates and generator inputs.                                                   |
| Scripts and CI             | Deterministic checking and transformation.                                                               |
| `.agents/memory/`          | Non-canonical working memory and continuity notes.                                                       |
| `.agents/baselines/`       | Generic exportable starter material.                                                                     |
| `docs/11-ai/`              | Non-canonical working documentation, reviews, research, and promotion candidates.                        |

When content no longer matches its current surface, promote or move it to the correct owner.

Do not preserve two active authoritative copies.

## 5. `AGENTS.md` Standards

### 5.1. Purpose

An `AGENTS.md` file defines standing execution rules for its directory scope.

It may contain:

- scope and ownership boundaries
- required read order
- local command requirements
- persistent safety restrictions
- approval gates
- local testing requirements
- file-placement rules
- stop conditions
- pointers to canonical standards

It must not become:

- a feature specification
- an architecture document
- a database contract
- a complete workflow encyclopedia
- a substitute for coding standards
- a task-specific work packet
- a repository history log

### 5.2. Root Versus Scoped Instructions

The root `AGENTS.md` should contain only repository-wide rules.

Create a scoped `AGENTS.md` only when the subtree has materially different:

- ownership rules
- read requirements
- validation commands
- safety restrictions
- file-shape constraints
- workflow behavior

Do not create scoped files merely to repeat the root file.

Closer instructions may refine broader instructions but must not contradict canonical documentation.

### 5.3. Authoring Requirements

An `AGENTS.md` file should:

- declare its scope near the beginning
- place the highest-risk rules early
- use direct imperative language
- link to canonical owners
- provide exact commands where reproducibility matters
- distinguish allowed actions from prohibited actions
- include real stop conditions
- avoid broad explanatory history
- avoid duplicating parent instructions unnecessarily

Always-on instruction surfaces must remain concise and high-signal.

## 6. Skill Ownership

A skill defines one repeatable workflow.

A skill may define:

- when the workflow applies
- when it must not apply
- required inputs
- authoritative sources to read
- ordered execution steps
- allowed file scope
- required outputs
- validation requirements
- side-effect boundaries
- failure handling
- stop and escalation conditions

A skill must not define durable application truth.

A skill should link to canonical standards rather than copying them.

## 7. Skill Directory Contract

Use one directory per current-format skill:

    .agents/skills/{skill-name}/
    ├── SKILL.md
    ├── references/
    ├── scripts/
    └── assets/

Only `SKILL.md` is required.

Add the other directories only when they have a real consumer.

Skill directory names must:

- use lowercase letters, numbers, and hyphens
- match the skill `name`
- describe one recognizable workflow
- remain distinguishable from neighboring skills

Do not add overlapping skills with materially identical trigger conditions.

## 8. Skill Frontmatter

Each `SKILL.md` must begin with YAML frontmatter containing:

    ---
    name: skill-name
    description: Concise statement of what the skill does and when it should be used.
    ---

The `name` must:

- match the directory name
- use lowercase letters, numbers, and hyphens
- remain concise
- identify the workflow rather than the implementation area alone

The `description` must:

- state the workflow’s primary action
- state when the skill should activate
- include important trigger terms early
- identify major negative boundaries when false activation is likely
- avoid marketing language
- avoid duplicating the full procedure

Do not add custom frontmatter fields until repository tooling consumes them.

## 9. Skill Body Requirements

A skill should normally contain:

1. purpose
2. use conditions
3. non-use conditions
4. required inputs
5. authoritative sources
6. ordered procedure
7. outputs
8. validation
9. stop conditions

Use imperative steps.

Prefer:

> Apply the Definition of Ready in `Agent Implementation Checklist.md`. Stop and report any missing required input.

Avoid copying the full Definition of Ready into the skill.

Prefer:

> Select the file archetype using `File Archetypes.md`, then use the matching approved stub from `stubs/README.md`.

Avoid embedding every archetype and stub definition.

## 10. Progressive Disclosure And Token Discipline

Skills use progressive disclosure. The full skill enters active context when selected.

Therefore, the main `SKILL.md` must remain focused.

Project targets are:

| Measure                               |                      Project Target |
| ------------------------------------- | ----------------------------------: |
| Normal `SKILL.md`                     |          Approximately 80–200 lines |
| Complex or higher-risk workflow       |         Approximately 200–300 lines |
| Mandatory review threshold            |                 More than 300 lines |
| Maximum without an accepted exception |                           500 lines |
| Normal instruction budget             | Approximately 2,500 tokens or fewer |
| Maximum without an accepted exception |          Approximately 5,000 tokens |
| Reference depth                       |           One level from `SKILL.md` |

A skill exceeding 300 lines must be reviewed for content that belongs in:

- canonical standards
- a focused reference
- a deterministic script
- a separate non-overlapping skill
- the GitHub issue
- an `AGENTS.md` file

The 500-line limit is a ceiling, not a normal target.

Do not shorten a skill at the expense of removing essential safety or recovery rules. Move optional detail instead.

## 11. Skill References

Use `references/` for skill-specific supporting information that is:

- too detailed for the main workflow
- needed only for some executions
- not already owned by canonical documentation
- stable enough to maintain with the skill

Examples include:

- report formats
- decision tables used only by the skill
- protocol-specific examples
- tool response interpretation guidance

Do not copy canonical standards into skill references.

Link directly from `SKILL.md` to the required reference.

Avoid chains such as:

    SKILL.md
      → reference-a.md
        → reference-b.md
          → reference-c.md

References should normally remain one level deep.

## 12. Skill Scripts

Use `scripts/` when behavior should be deterministic.

Appropriate script responsibilities include:

- placeholder scanning
- frontmatter validation
- file inventory generation
- generated-output checks
- schema validation
- link checking
- repeatable parsing
- deterministic transformation

Use prose instructions for:

- classification
- ownership decisions
- scope analysis
- canonical-source selection
- risk review
- escalation
- human-review handoff

A script must:

- have a clear input and output contract
- fail with a non-zero status when validation fails
- avoid silent destructive behavior
- avoid network access unless explicitly required
- be testable independently
- report actionable failure information

Do not hide policy decisions inside scripts.

## 13. Skill Assets

Use `assets/` only for static resources consumed by the skill.

Examples include:

- non-source templates
- example payloads
- static schemas
- report shells

Source-file implementation templates belong under `stubs/`, not skill assets.

Documentation templates belong under `docs/09-reference/templates/`.

## 14. Skill Composition

One outer workflow skill may use a narrower specialized skill.

For example:

    login2-implementation-slice
      → login2-file-implementation

Composition rules:

- the outer skill owns task readiness and overall scope
- the specialized skill owns its narrow procedure
- the specialized skill must not broaden the issue
- the outer skill should not duplicate the specialized procedure
- a skill should not load neighboring skills speculatively
- recursive or circular skill composition is prohibited
- the final report should identify which skills were used

Create a new skill only when the workflow has a distinct trigger, execution path, outputs, and stop conditions.

## 15. Side-Effect Boundaries

Every skill must make consequential side effects explicit.

The skill should state whether it may:

- edit files
- create files
- delete files
- overwrite files
- stage files
- commit
- push
- open or update issues
- update GitHub Project fields
- deploy
- run migrations
- access external networks
- invoke third-party services
- alter production or shared environments

Default behavior:

- file edits require an implementation-authorized task
- deletion requires explicit scope
- overwriting requires explicit scope
- staging and committing require explicit authorization
- pushing requires explicit authorization
- issue or Project changes require explicit authorization
- deployment requires explicit authorization
- destructive database operations require explicit authorization and recovery planning
- production actions remain human-led unless a runbook explicitly delegates them

A skill must not infer consequential authorization from a general request for advice or review.

## 16. Required Inputs And Stop Conditions

A skill must identify the inputs required to execute safely.

Stop conditions must be specific.

Good stop condition:

> Stop when the work packet does not define the transaction owner for a multi-write mutation.

Weak stop condition:

> Be careful with transactions.

When stopping, report:

- the exact missing or conflicting input
- why it prevents safe execution
- the canonical owner that should resolve it
- the minimum information needed to continue

Do not convert stop conditions into silent assumptions.

## 17. Skill Outputs

A skill must identify its expected outputs.

Outputs may include:

- changed files
- generated files
- validation results
- documentation updates
- issue comments
- status recommendations
- handoff artifacts
- review requirements
- blocker reports

Do not require a new status artifact when GitHub issues, GitHub Projects, canonical docs, or an existing review record already own that responsibility.

## 18. Skill Testing

Before a new skill is considered active, test at least:

- one positive trigger
- one negative trigger
- one ambiguous trigger
- one missing-input case
- one stop-condition case
- one expected output
- one prohibited side effect

Also validate:

- frontmatter
- directory/name alignment
- referenced paths
- bundled scripts
- output formatting
- compatibility with applicable `AGENTS.md` files

Trigger tests should confirm that:

- the skill activates for the intended request
- it does not activate for neighboring workflows
- ambiguous requests cause clarification or stop behavior
- the description is sufficient for correct selection

## 19. Review Checklist

Review each skill for:

- one clear workflow
- accurate trigger description
- explicit non-use boundary
- required inputs
- canonical-source links
- deterministic step order
- read and write scope
- explicit side effects
- meaningful stop conditions
- validation requirements
- outputs and handoff
- context size
- duplication with standards or other skills
- stale paths or commands
- references that are actually needed
- scripts that are deterministic and safe

Review each `AGENTS.md` for:

- clear scope
- justified existence
- minimal duplication
- accurate local rules
- correct canonical links
- direct safety boundaries
- current commands
- concise always-on context

## 20. Skill Lifecycle

Skill lifecycle values are:

- experimental
- active
- deprecated
- superseded
- removed

Until metadata tooling exists, record lifecycle in the skill body or its inventory rather than adding unsupported frontmatter.

Review a skill when:

- canonical standards change
- folder ownership changes
- the issue form changes
- verification commands change
- tools or dependencies change
- side-effect policy changes
- repeated execution failures reveal ambiguity
- the skill grows beyond its normal target
- another skill begins overlapping its responsibility

When superseding a skill:

1. identify the replacement
2. update inbound references
3. stop automatic selection of the old workflow
4. archive or remove the obsolete skill
5. avoid maintaining two active equivalent workflows

## 21. Memory And Baseline Boundaries

`.agents/memory/` owns non-canonical working memory such as:

- operator preferences
- recurring repository gotchas
- compact continuity notes
- non-canonical open loops

Memory must not become:

- canonical application truth
- a shadow `AGENTS.md`
- an implementation-status system
- a workflow definition
- a secret store

Promote durable content into:

- `AGENTS.md` for standing execution rules
- a skill for repeatable workflow behavior
- canonical docs for system truth
- `.agents/baselines/` for reusable generic scaffolding

`.agents/baselines/` must remain generic enough for deliberate reuse outside the current repository.

## 22. Prohibited Practices

Do not:

- duplicate canonical standards inside skills
- place repeatable workflow procedures in root `AGENTS.md`
- place permanent repository rules only in a skill
- store active issue scope in a skill
- treat `docs/11-ai/` as canonical truth
- place source-file stubs inside skill assets
- load every skill before selecting one
- create overlapping skills without a distinct workflow
- use vague stop conditions
- hide destructive behavior in scripts
- assume permission to commit, push, deploy, or migrate
- retain obsolete instruction files as competing authorities
- optimize for agent convenience by weakening canonical documentation ownership

## 23. Maintenance

When changing instruction-surface policy:

- update this standard
- update [Coding Agent Standards Index](index.md)
- update this folder’s `AGENTS.md`
- update root or scoped `AGENTS.md` files when their persistent rules change
- update `.agents/skills/AGENTS.md` when skill-local execution rules change
- update the skill template when the standard skill shape changes
- update affected skills
- update or archive superseded AI-governance notes
- run applicable documentation guardrails

Do not leave durable agent policy only in `docs/11-ai/`.

## 24. Related

- [Coding Agent Standards Index](index.md)
- [Agent Working Documentation And Promotion Standards](Agent%20Working%20Documentation%20And%20Promotion%20Standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Code Template And Generator Standards](../coding/Code%20Template%20And%20Generator%20Standards.md)
- [Documentation Standards Index](../documentation/index.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)