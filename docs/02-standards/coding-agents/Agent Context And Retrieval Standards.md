<!--
DOC-META
title: Agent Context And Retrieval Standards
doc_type: standard
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding-agents/Agent Context And Retrieval Standards.md
parent: docs/02-standards/coding-agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines bounded context loading, targeted retrieval, long-file handling, source selection, and context-efficiency requirements for coding-agent work.
-->

# Agent Context And Retrieval Standards

Parent: [Coding Agent Standards Index](index.md)

## 1. Purpose

Reduce avoidable context usage and instruction competition while ensuring agents load enough authoritative material to perform safe, bounded work.

## 2. Core Rule

Load the smallest authoritative context that can answer or execute the task safely.

Context efficiency must not remove:

- required safety rules
- canonical owner documents
- acceptance criteria
- dependencies
- verification requirements
- relevant stop conditions

## 3. Retrieval Order

Use this order:

1. task or GitHub issue
2. root `AGENTS.md`
3. nearest scoped `AGENTS.md`
4. named skill, when one applies
5. branch or folder index
6. exact canonical owner documents
7. directly affected implementation files
8. supporting references only when needed

Do not begin by reading every standard, skill, planning document, or runbook.

## 4. Source Authority

Prefer:

1. current repository files
2. official product documentation for product behavior
3. canonical repository standards and owner docs
4. current GitHub issues and Project state
5. non-canonical references and working documents

Do not use:

- archived docs as current truth
- `docs/11-ai/` drafts as canonical truth
- memory as canonical truth
- planning as implemented truth
- old compatibility aliases when a replacement exists

## 5. Task Contract

Before broad retrieval, identify:

- task
- owner
- target files
- required output
- required canonical sources
- verification
- stop conditions

When these cannot be identified, clarify the task before loading broad context.

## 6. Folder Navigation

Read folder indexes and scoped `AGENTS.md` files before traversing large branches.

Use indexes to locate:

- canonical owners
- active children
- deprecated areas
- templates
- related standards

Do not infer authority from folder proximity alone.

## 7. Long Files

For long files:

- search headings first
- search exact terms
- open targeted sections
- expand only when dependencies require it
- avoid loading appendices or history without need
- split the file when it owns multiple independent responsibilities

A file exceeding a size guideline is not automatically invalid. Repeated broad reads are evidence that scope or navigation may need improvement.

## 8. Skills

Read only the selected skill.

Do not load neighboring skills to discover what might apply unless trigger ambiguity cannot be resolved from names and descriptions.

Skills should route to canonical standards rather than duplicate them.

Use:

- [Agent Instruction Surface And Skill Authoring Standards](Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md)

## 9. Planning And Matrices

For planning work:

- read the branch index
- read the exact planning owner
- read only relevant matrix rows
- inspect linked issues
- inspect canonical owners affected by the slice

Do not load all phase history or every matrix row for one issue.

## 10. Documentation Review

For documentation review:

- read the target document
- read its parent index
- read the applicable documentation standard
- inspect direct dependencies
- inspect inbound links only when moving or deleting

Do not audit a whole branch unless the task explicitly owns a branch-wide review.

## 11. UI Work

For UI work, read:

- nearest `AGENTS.md`
- exact component contract
- exact Blade, CSS, JavaScript, and test files
- applicable UI standard
- approved visual authority

Do not load unrelated component families or deprecated UI Reference files.

## 12. Database Work

For database work, read:

- exact schema contract
- affected migrations
- affected models and queries
- database standards
- transaction and concurrency standards
- affected tests

Do not inspect the whole schema when one bounded table or workflow is affected.

## 13. Runbooks

Open only the runbook for the operation being performed.

Do not read every runbook before:

- deployment
- local setup
- scheduler verification
- log inspection
- realtime service checks

Use the runbook index for routing.

## 14. Search Before Creation

Before creating a new:

- document
- skill
- memory note
- standard
- runbook
- template
- source file

search for an existing owner or similar artifact.

Prefer updating an existing owner over creating a near-duplicate.

## 15. Context Observations

Record recurring retrieval problems in:

- `.agents/memory/working/token-usage-observations.md`

Promote durable solutions into:

- indexes
- scoped `AGENTS.md`
- standards
- skills
- file splits
- deterministic scripts

Do not let the observation file become a permanent standards owner.

## 16. Prohibited Practices

Do not:

- load all skills
- load all runbooks
- load all planning history
- load archives without explicit need
- read generated vendor or reference trees for ordinary application work
- duplicate canonical docs into prompts
- retain stale context after the task changes materially
- optimize token usage by omitting safety-critical sources

## 17. Stop Conditions

Stop and clarify when:

- no task owner is identifiable
- sources conflict
- the canonical owner cannot be determined
- broad traversal is required because indexes are stale
- a long file mixes unrelated owners
- the selected skill conflicts with the issue
- current repository state cannot be verified

## 18. Related

- [Coding Agent Standards Index](index.md)
- [Agent Instruction Surface And Skill Authoring Standards](Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md)
- [Agent Session Concurrency And Worktree Standards](Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md)
- [Repo-Local Agent Memory Standards](Repo-Local%20Agent%20Memory%20Standards.md)
