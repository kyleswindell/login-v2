<!--
DOC-META
title: Coding Agent Standards Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding-agents/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Indexes coding-agent instruction, skill, context, concurrency, memory, working-document, and promotion standards.
-->

# Coding Agent Standards Index

Parent: [Standards Index](../index.md)

## 1. Purpose

This folder owns durable coding-agent governance.

Use it to determine:

- where agent-facing information belongs
- how `AGENTS.md` files and skills are written
- how agent context is bounded
- how writable sessions and worktrees are coordinated
- how repo-local memory is maintained
- how agent working documents are promoted

## 2. Active Standards

| Document | Purpose |
| --- | --- |
| [Agent Instruction Surface And Skill Authoring Standards](Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md) | Defines instruction-surface ownership, skill structure, context budgets, side effects, validation, and lifecycle. |
| [Agent Working Documentation And Promotion Standards](Agent%20Working%20Documentation%20And%20Promotion%20Standards.md) | Defines `docs/11-ai/` working-document ownership, review, promotion, and closure. |
| [Agent Session Concurrency And Worktree Standards](Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md) | Defines one-writer ownership, worktree isolation, advisory claims, shared-resource serialization, and handoff. |
| [Agent Context And Retrieval Standards](Agent%20Context%20And%20Retrieval%20Standards.md) | Defines bounded context loading, source selection, targeted retrieval, and long-file handling. |
| [Repo-Local Agent Memory Standards](Repo-Local%20Agent%20Memory%20Standards.md) | Defines memory classes, allowed content, promotion, security, concurrency, and pruning. |

## 3. Surface Map

| Surface | Owns |
| --- | --- |
| Root and scoped `AGENTS.md` | Persistent operating rules |
| `.agents/skills/` | Repeatable executable agent workflows |
| `.agents/memory/` | Non-canonical agent memory |
| `.agents/baselines/` | Generic exportable starter material |
| `docs/11-ai/` | Non-canonical agent working documents |
| GitHub issues | Bounded work packets |
| GitHub Projects | Active delivery status |
| Canonical docs | Durable product and technical truth |

## 4. Reading Order

Read only the standard relevant to the task.

For skill work:

1. instruction-surface and skill authoring
2. context and retrieval
3. applicable workflow standard

For concurrent work:

1. session concurrency and worktrees
2. Git change scope and commit standards
3. parallel worktree runbook

For memory:

1. repo-local memory
2. working-document promotion when the content may need human review

## 5. Related

- [Standards Index](../index.md)
- [Coding Standards Index](../coding/index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Parallel Worktree Setup](../../10-runbooks/parallel-worktree-setup.md)
