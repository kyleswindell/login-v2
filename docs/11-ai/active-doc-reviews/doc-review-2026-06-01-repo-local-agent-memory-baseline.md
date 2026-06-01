# Document Review doc-review-2026-06-01-repo-local-agent-memory-baseline

## Review Pass
3

## Target
Repo-local agent memory baseline across `AGENTS.md`, AI governance rules, and `.agents/` memory scaffolding

## Review Type
Document Review

## Status
CLOSED

## Purpose
Define a safe local agent-memory baseline that stays outside canonical `docs/`, remains non-production-facing, and gives agents a repeatable place to store durable non-canonical memory.

## Scope
- `AGENTS.md`
- `docs/11-ai/rules.md`
- `.agents/`

## Findings

### Finding 1
- type: missing owner path
- location: `AGENTS.md`, `docs/11-ai/rules.md`, and `.agents/`
- issue: The repo has strong canonical documentation and active-workspace rules, but it does not define a canonical non-`docs/` home for durable agent memory such as operator preferences, repo heuristics, project context summaries, and non-canonical open loops. That leaves any future memory-writing behavior ambiguous and risks mixing agent memory into chat, `docs/`, or ad hoc files.
- required action: Establish `.agents/memory/` as the repo-local owner for non-canonical agent memory, and explicitly distinguish it from canonical `docs/` truth and from active batch workspace state.
- constraints: Do not move product, architecture, planning, or operations truth out of `docs/`. Keep the new memory layer clearly agent-facing and non-production-facing.
- decision state: required

### Finding 2
- type: missing memory taxonomy
- location: `.agents/` governance baseline
- issue: Even if a memory folder existed, the repo currently has no rule for what kinds of memory are allowed there, what should stay ephemeral, what should be promoted into canonical docs, or what should never be written at all. Without those boundaries, a local memory system would quickly become either a duplicate knowledge base or a junk drawer.
- required action: Define a minimal memory taxonomy and promotion rule set, including at least stable memory, working memory, and ephemeral memory, plus a clear rule for when something must be promoted into canonical `docs/`.
- constraints: Keep the model lightweight and readable in plain Markdown. Avoid inventing a complex database-like schema.
- decision state: required

### Finding 3
- type: missing workflow baseline
- location: `.agents/skills/` and `.agents/` memory operations
- issue: The repo has no baseline skills or operating notes for starting, updating, pruning, or handing off local agent memory. That means even a well-placed memory folder would not be used consistently.
- required action: Add baseline skill guidance and starter files for reading/writing repo-local agent memory, including creation, update, handoff, and cleanup expectations.
- constraints: Keep this repo-local and tool-agnostic. Do not assume a third-party memory product or hosted service.
- decision state: required

## Summary
- benchmark alignment: partial; the repo preserves canonical docs well but lacks a scoped agent-memory layer
- workflow alignment: partial; current agent governance covers workflows, claims, and handoffs, but not durable non-canonical memory
- readiness: ready for a narrow governance and scaffolding pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- `.agents/memory/` exists as the repo-owned home for non-canonical agent memory
- `AGENTS.md` and AI governance rules distinguish canonical docs, active workspace state, and agent memory cleanly
- baseline memory classes, promotion rules, and cleanup expectations are documented
- baseline skill guidance exists for capturing and maintaining agent memory

## Resolution Notes
- Review found a narrow governance/scaffolding gap rather than a need to redesign the existing documentation system.
- Implemented the baseline in:
  - `AGENTS.md`
  - `docs/11-ai/rules.md`
  - `docs/10-runbooks/repo-local-agent-memory.md`
  - `docs/10-runbooks/index.md`
  - `.agents/memory/`
  - `.agents/skills/capture-agent-memory.md`
  - `.agents/skills/maintain-agent-memory.md`
- Resolved finding 1 by establishing `.agents/memory/` as the repo-local owner for non-canonical agent memory outside `docs/`.
- Resolved finding 2 by defining stable, working, and ephemeral memory classes plus promotion and cleanup rules.
- Resolved finding 3 by adding baseline scaffolding and two repo-local skills for capture and maintenance.
- Re-review found no remaining scoped conflict. The new memory layer stays outside canonical `docs/`, does not compete with `docs/08-active/` or branch handoff owners, and provides a minimal baseline without turning `.agents/` into a second documentation vault.
