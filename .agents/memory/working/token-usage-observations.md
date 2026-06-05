# Token Usage Observations

Use this lightweight note for recurring context-cost patterns. Keep entries concise and remove stale items when the owner surface is corrected.

Operational trigger: add an entry when a session repeatedly opens the same long file, loads multiple broad docs to answer one narrow task, or finds that a workflow prompt omitted workflow name, target ID, file scope, read path, stop condition, or validation path. If the same observation recurs, promote the correction into the nearest `AGENTS.md`, skill, or runbook.

## Template

### YYYY-MM-DD - <workflow or area>

- workflow:
- target ID:
- allowed file scope:
- intended read path:
- broad or repeated reads:
- long files loaded:
- AGENTS/read-path adherence:
- token-efficiency issue:
- recommended owner surface:
- follow-up status:

## Active Observations

- 2026-06-05 - Token-hygiene cleanup
  - workflow: review-only governance plus scoped implementation
  - target ID: doc-review-2026-06-05-solid-token-efficiency-architecture-audit
  - allowed file scope: agent governance, runbooks, active doc reviews, frontend assets
  - intended read path: nearest AGENTS, targeted skills, runbook index, largest asset files, architecture standards
  - broad or repeated reads: prior work repeatedly loaded active workspace and long workflow narratives
  - long files loaded: `resources/js/app.js`, `resources/css/app.css`, selected workflow skills
  - AGENTS/read-path adherence: needs prompt-level enforcement so future sessions declare workflow, target, file scope, read path, and stop condition
  - token-efficiency issue: long skills and monolithic assets encouraged broad context loading
  - recommended owner surface: `.agents/skills/`, `docs/10-runbooks/agent-token-efficiency.md`, `resources/AGENTS.md`
  - follow-up status: governance, skill compression, frontend entrypoint cleanup, and SOLID audit closure completed; continue watching future prompts for read-budget adherence
