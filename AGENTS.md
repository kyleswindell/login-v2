# AGENTS.md

## Project Context

This repository contains Login App 2.0, a Laravel-based platform intended to replace the current customized Perfex 1.0 foundation over time.

---

## Core Principles

- Treat this repository as the source of truth for App 2.0.
- Keep the Perfex 1.0 repository as reference only unless explicitly instructed otherwise.
- Use Laravel, Filament, Livewire, PostgreSQL, Redis, and Apache/PHP-FPM as the locked foundation unless a decision record changes that.
- Support arbitrary tenant admin domains from day one.
- Keep tenants isolated with one tenant database and one PostgreSQL role per tenant.
- Prefer data-driven tenant configuration over file-copy-driven behavior.
- Do not build meaningful untracked application code directly on the production server.

---

## Canonical Documentation Rules

- Treat `/docs/` as the canonical root for all active documentation.
- Ignore `/docs/_archive/` unless explicitly requested.
- Do not introduce legacy documentation paths or outdated references.

### Branch Responsibilities

- `02-standards` → rules only  
- `03-architecture` → system structure only  
- `04-features` → behavior only  
- `05-flows` → execution paths only  
- `06-database` → schema and constraints only  
- `07-planning` → sequencing and intent only  
- `09-reference` → non-canonical support only  
- `10-runbooks` → operations only  

Always respect branch ownership. Do not duplicate or reassign responsibility across branches.

---

## Active Workspace (`/docs/08-active/`)

- `/docs/08-active/` represents the current batch workspace.
- It is the only location where active batch state is stored.
- Only batch workflows (`batch-start`, `work-batch`, `batch-update-manual-review-status`, `batch-review-and-finalize`) may modify it.
- Do not manually alter its structure outside those workflows.

---

## Implementation and Docs Sync

- When implementing a planned system, update canonical docs and related planning notes in the same work cycle.
- Planning notes must reflect current implementation status.
- Canonical system docs and planning notes must remain linked.

---

## Code and Documentation Discipline

- Only modify files directly required for the current scope.
- Do not include unrelated changes in commits.
- If unrelated issues are found:
  - record them in `/docs/08-active/notes.md`
  - do not fix them immediately

- Prefer minimal, explicit changes over broad rewrites.
- Maintain consistency with existing naming, tokens, and patterns.

---

## Git and Deployment Rules

- Follow `docs/10-runbooks/git-batch-commit-workflow.md` for all commits.
- Commits must:
  - map to a single batch and a single concern
  - include only files touched for that scope

- Use batch checkpoints:
  - batch initialized
  - implementation save points
  - review-ready
  - finalized

- Only commit when the work is scoped, intentional, and reviewable.

---

## Agent Execution Rules

- Only one agent may modify canonical docs or code in a session.
- Separate:
  - prompt generation
  - implementation
  - review
- Do not combine review and implementation in the same step.

---

## Batch Workflow Enforcement

- Always execute batch work through:
  - `batch-start`
  - `work-batch`
  - `batch-update-manual-review-status`
  - `batch-review-and-finalize`

- Do not:
  - skip batch initialization
  - mix multiple batches
  - introduce Tier 2 or Tier 3 work into a Tier 1 batch

---

## UI and Component Standards

- Tier 1 = primitives and baseline components  
- Tier 2 = reusable patterns  
- Tier 3 = feature modules  

Rules:
- Do not bypass tiers
- Do not redefine primitives at higher tiers
- UI Reference must reflect actual component behavior

---

## Important Docs

- `docs/00-start-here.md`
- `docs/02-standards/index.md`
- `docs/03-architecture/index.md`
- `docs/04-features/index.md`
- `docs/05-flows/index.md`
- `docs/06-database/index.md`
- `docs/07-planning/index.md`
- `docs/09-reference/index.md`
- `docs/10-runbooks/index.md`

---

## Final Rule

If a change cannot be clearly tied to:
- one batch
- one concern
- one canonical owner

then do not implement it yet.
