<!--
DOC-META
title: Repo-Local Agent Memory Standards
doc_type: standard
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding-agents/Repo-Local Agent Memory Standards.md
parent: docs/02-standards/coding-agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the ownership, classes, allowed content, security, promotion, concurrency, pruning, and maintenance requirements for repo-local agent memory.
-->

# Repo-Local Agent Memory Standards

Parent: [Coding Agent Standards Index](index.md)

## 1. Purpose

Define the non-canonical memory layer under `.agents/memory/` without allowing it to replace canonical docs, persistent instructions, skills, issues, or delivery state.

## 2. Core Rule

Repo-local memory supports agent continuity.

It is not source-of-truth documentation.

When remembered information becomes durable, promote it to the correct owner.

## 3. Ownership

Use:

- `.agents/memory/` for non-canonical agent memory
- canonical `docs/` for durable system truth
- `AGENTS.md` for persistent agent rules
- `.agents/skills/` for repeatable workflows
- `.agents/baselines/` for reusable generic starter material
- GitHub issues for bounded work
- GitHub Projects for delivery state
- `docs/11-ai/` for reviewable working documents and promotion candidates

## 4. Memory Classes

### Stable

Use for:

- operator preferences
- recurring repository heuristics
- stable non-canonical context summaries
- repeated gotchas

Stable memory must be concise and periodically reverified.

### Working

Use for:

- open loops
- active investigations
- temporary cross-session context
- bounded handoff notes not owned elsewhere
- token-usage observations

Working memory must be pruned when the work closes.

### Ephemeral

Use for:

- short-lived compression
- temporary scratch continuity
- disposable session summaries

Ephemeral memory should be deleted aggressively.

## 5. Allowed Content

Memory may contain:

- concise preferences
- repository heuristics
- recurring troubleshooting observations
- compact non-canonical context
- unresolved non-sensitive open loops
- temporary session continuity
- pointers to canonical owners

## 6. Prohibited Content

Memory must not contain:

- canonical architecture
- feature contracts
- schema truth
- planning sequence
- operational procedures
- active issue state
- delivery status
- permanent workflow rules
- secrets
- credentials
- tokens
- private keys
- raw customer data
- production-sensitive evidence
- large copies of canonical docs

## 7. Promotion

Promote information when it becomes:

| Information | Owner |
| --- | --- |
| Durable repository rule | Root or scoped `AGENTS.md` |
| Repeatable agent procedure | `.agents/skills/` |
| Product or technical truth | Canonical `docs/` branch |
| Planning intent | `docs/07-planning/` |
| Operational procedure | `docs/10-runbooks/` |
| Reviewable draft or research | `docs/11-ai/` |
| Generic reusable starter material | `.agents/baselines/` |

After promotion:

- remove duplicated detail
- retain only a short pointer when useful
- update stale references
- avoid two active owners

## 8. File Creation

Before creating a memory file:

- search existing memory
- identify its class
- confirm the information does not belong elsewhere
- choose a bounded filename
- identify a review or deletion trigger

Avoid vague overlapping files.

## 9. Maintenance

Memory files should:

- state purpose
- distinguish fact from hypothesis
- link canonical owners
- include a review date when staleness matters
- remain short and scannable
- be updated instead of duplicated
- be deleted after expiration

## 10. Concurrency

Memory is writable repository content.

The one-writer-per-worktree rule applies.

Memory notes are not locks and must not be used to coordinate concurrent file edits.

Use:

- [Agent Session Concurrency And Worktree Standards](Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md)

## 11. Security

Never store:

- secret values
- access tokens
- personal credentials
- private vulnerability evidence
- unredacted customer information
- production-only sensitive configuration

Use redacted descriptions and approved restricted storage.

## 12. Baselines

`.agents/baselines/` may contain generic reusable memory scaffolding.

Baseline files must:

- avoid live repo-specific memory
- avoid private operator information
- include adoption guidance
- remain non-authoritative until promoted into the live repository surface

## 13. Review

Review memory for:

- correct class
- correct owner
- duplication
- staleness
- promotion need
- security
- closed loops
- excessive length

## 14. Stop Conditions

Stop before writing memory when:

- the content is canonical
- the content defines a permanent rule
- the content defines a repeatable workflow
- the content is issue or Project state
- the content includes sensitive information
- another writer owns the worktree
- a near-duplicate memory file exists

## 15. Related

- [Coding Agent Standards Index](index.md)
- [Agent Instruction Surface And Skill Authoring Standards](Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md)
- [Agent Working Documentation And Promotion Standards](Agent%20Working%20Documentation%20And%20Promotion%20Standards.md)
- [Agent Context And Retrieval Standards](Agent%20Context%20And%20Retrieval%20Standards.md)
