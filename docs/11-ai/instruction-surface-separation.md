# Agent Instruction Surface Separation

Use this note as the compact map of where agent-facing information belongs in this repo.

## Purpose

Keep agent rules, workflow playbooks, canonical system truth, repo-local memory, and exportable starter packs in separate owner surfaces so they do not drift into one another.

## Surface Map

| Surface | Primary job | What belongs here |
|---|---|---|
| `AGENTS.md` | persistent operating rules | repo-wide constraints, approval gates, standing workflow boundaries, durable execution norms |
| `.agents/skills/` | executable workflow playbooks | when to run a workflow, ordered steps, stop conditions, outputs, escalation behavior |
| `docs/` | canonical truth | product behavior, architecture, planning, database truth, operational runbooks, review/governance records |
| `.agents/memory/` | repo-local working memory | non-canonical preferences, heuristics, open loops, compact session continuity |
| `.agents/baselines/` | exportable starter packs | reusable generic scaffolding that another repo can adopt before repo-specific configuration |

## Core Rule

Information should live in the surface that matches its authority.

That means:

- if it is a durable repo rule, it belongs in `AGENTS.md`
- if it is a task workflow, it belongs in a skill file
- if it is a reusable operator trigger for a repeatable workflow, prefer a skill file over a long manually reconstructed prompt
- if it is canonical system truth, it belongs in `docs/`
- if it is non-canonical local memory, it belongs in `.agents/memory/`
- if it is reusable starter scaffolding for other repos, it belongs in `.agents/baselines/`

## Promotion Rules

When memory or chat-derived notes become durable enough to keep, promote them to the correct owner:

- durable repo-wide operating rule -> `AGENTS.md`
- repeatable workflow behavior -> relevant `.agents/skills/` file
- canonical product/system truth -> canonical `docs/` owner
- reusable starter-pack improvement -> `.agents/baselines/`

After promotion:

1. trim or delete the memory copy
2. leave only a short pointer when useful
3. avoid keeping two competing owners

## Anti-Patterns

Do not:

- let `.agents/memory/` become a shadow `AGENTS.md`
- let skills carry large amounts of canonical product explanation
- let `AGENTS.md` become a workflow encyclopedia
- let baseline packages absorb repo-specific live memory
- let canonical docs become an agent scratchpad

## Related

- [AI Governance Rules](rules.md)
- [Agent Instruction Writing Benchmark](agent-skill-writing-benchmark.md)
- [Repo-Local Agent Memory](../10-runbooks/repo-local-agent-memory.md)
