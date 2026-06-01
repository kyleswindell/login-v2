## Repo-Local Agent Memory

- `.agents/memory/` is the repo-local home for non-canonical, non-production-facing agent memory.
- Use `.agents/memory/` for durable agent support material such as:
  - operator preferences
  - repo heuristics and recurring gotchas
  - compressed project-context summaries
  - non-canonical open loops and handoff notes
  - ephemeral session summaries that should not live in chat alone
- Do NOT use `.agents/memory/` for:
  - canonical product, architecture, planning, database, or runbook truth
  - active workflow state
  - worker-branch integration handoff artifacts that belong elsewhere
  - secrets, credentials, tokens, raw customer data, or production-only sensitive values
- If repo-local memory reveals durable system truth, promote that truth into its canonical owner rather than treating `.agents/memory/` as the final source of truth.
- If repo-local memory reveals durable agent operating rules, workflow behavior, or reusable starter-pack improvements, promote them into `AGENTS.md`, the relevant skill file, or `.agents/baselines/` respectively.
- Keep repo-local memory concise, prunable, and explicitly dated or reviewable when practical.
- Prefer updating existing memory notes over creating overlapping ones.
