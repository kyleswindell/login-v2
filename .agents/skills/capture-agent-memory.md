# Capture Agent Memory

Capture or update repo-local agent memory under `.agents/memory/` without changing canonical docs.

## Goal

Store useful non-canonical memory in the correct repo-local memory lane so future agent sessions can reuse it safely.

This skill:
- writes only under `.agents/memory/`
- does NOT modify canonical `docs/`
- does NOT update `/docs/08-active/`

## Required Input

- the memory to capture
- intended memory class:
  - stable
  - working
  - ephemeral
- relevant source or justification

## Scope

Read:
- relevant `.agents/memory/` files
- directly relevant repo files or current session context

Write:
- `.agents/memory/**`

## Rules

- Prefer updating an existing memory note over creating a duplicate
- Keep entries concise and scannable
- Do NOT store secrets, credentials, tokens, or sensitive raw production/customer data
- Do NOT restate large canonical docs sections
- If the information is actually canonical truth, STOP and route it to the correct `docs/` owner instead
- If the information is really a durable repo rule, workflow behavior, or reusable starter-pack improvement, STOP and route it to `AGENTS.md`, the relevant skill file, or `.agents/baselines/` instead of memory
- If the information is active batch state, STOP and route it to `/docs/08-active/`
- If another writable session already owns this same shared worktree, STOP before editing and require a separate branch/worktree or an explicit writable handoff into this session

## Execution

1. Determine whether the information belongs in stable, working, or ephemeral memory.
2. Identify the correct existing note or create a narrowly scoped new note only when necessary.
3. Record the memory with source/context fields when practical.
4. Add canonical links when the memory points back to repo truth owned elsewhere.
5. Keep the final note readable by both humans and agents.

## Output

1. memory file updated
2. memory class used
3. whether any canonical promotion is recommended
