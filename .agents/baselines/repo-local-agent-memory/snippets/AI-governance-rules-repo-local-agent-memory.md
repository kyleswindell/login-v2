## Repo-Local Agent Memory Policy

- `.agents/memory/` is the canonical repo-local owner for non-canonical agent memory.
- That memory layer exists to support agent continuity and handoff; it does not replace canonical docs ownership.
- Promote durable system truth into canonical docs owners when the remembered information becomes a rules, behavior, structure, planning, database, or runbook fact.
- Promote durable repo-wide operating rules into `AGENTS.md`.
- Promote repeatable workflow behavior into the relevant skill file.
- Promote reusable starter-pack improvements into `.agents/baselines/` instead of hiding them in repo-local memory.
- Keep `.agents/memory/` free of secrets, credentials, tokens, and production-sensitive raw data.
- Treat `.agents/memory/` as writable repo content: normal branch/worktree concurrency rules still apply.
