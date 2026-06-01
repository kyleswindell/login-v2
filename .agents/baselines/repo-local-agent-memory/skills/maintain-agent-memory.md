# Maintain Agent Memory

Review and prune repo-local agent memory so it stays useful, non-duplicative, and non-canonical.

## Goal

Keep `.agents/memory/` healthy by consolidating duplicates, clearing stale ephemeral state, and identifying memory that should be promoted into the correct owner surface.

This skill:
- reads and writes `.agents/memory/`
- does NOT modify canonical docs in this step
- may recommend a follow-up docs workflow when promotion is needed

## Required Input

- target memory area or `all`

## Scope

Read:
- `.agents/memory/**`

Write:
- `.agents/memory/**`

## Rules

- Keep stable memory small and durable
- Prune stale working and ephemeral memory aggressively
- Do NOT convert this directory into a second documentation system
- Do NOT store secrets or sensitive values
- If another writable session already owns this same shared worktree, STOP before editing and require a separate branch/worktree or an explicit writable handoff into this session
- If a memory item has become canonical truth, do NOT rewrite canonical docs here; instead flag the required promotion clearly
- If a memory item has become a durable repo rule, workflow behavior, or reusable starter-pack improvement, do NOT leave it in memory; flag the required promotion into the target repo's `AGENTS.md`, relevant skill file, or baseline package

## Execution

1. Review the targeted memory area.
2. Remove duplication and stale noise.
3. Tighten entries so they remain concise and readable.
4. Mark any item that should be promoted into the correct owner surface.
5. Leave the memory area cleaner than it started.

## Output

1. files updated
2. stale items removed or consolidated
3. promotion candidates identified
