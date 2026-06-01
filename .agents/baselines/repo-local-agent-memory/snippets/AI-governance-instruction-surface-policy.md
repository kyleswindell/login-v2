## Instruction Surface Policy

- `AGENTS.md` owns persistent agent rules and operating boundaries.
- `.agents/skills/` owns executable workflow playbooks.
- canonical docs own durable product, architecture, planning, database, runbook, and review/governance truth.
- `.agents/memory/` owns non-canonical repo-local working memory only.
- `.agents/baselines/` owns exportable starter packs and must stay generic enough for reuse in other repos.
- If information becomes durable enough to outgrow memory, promote it into the correct owner surface instead of leaving it in `.agents/memory/`.
