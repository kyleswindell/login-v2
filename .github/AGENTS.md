# .github AGENTS.md

## Purpose

GitHub-specific repository configuration, issue and pull-request metadata, workflows, automation, and GitHub/Copilot-facing instruction surfaces.

This folder does not own canonical application behavior, architecture, implementation policy, testing policy, or repository-wide agent workflow.

## Read Order

1. Read root `AGENTS.md`.
2. Open only the exact `.github` file or scoped instruction surface required by the task.
3. When changing agent-facing workflow behavior, read the applicable `.agents/skills/` workflow and `docs/02-standards/coding-agents/` standard.
4. When changing issue-template requirements, read the canonical readiness, verification, and documentation owners referenced by that template.

Do not inspect unrelated workflows, prompts, templates, or automation for a bounded task.

## Authority Boundaries

- Root and scoped `AGENTS.md` files own persistent repository execution rules.
- `.agents/skills/` owns repository execution workflows.
- `docs/02-standards/` owns durable repository policy.
- GitHub Issues own bounded work packets.
- GitHub Projects own current delivery state.
- `.github/` may provide GitHub-specific entrypoints and metadata but must route to those owners rather than duplicate them.

## Avoid

- Do not duplicate persistent repository rules from root `AGENTS.md`.
- Do not create a second implementation workflow under `.github/`.
- Do not copy verification semantics, owner topology, or coding standards into prompts or GitHub-specific skills.
- Do not preserve obsolete planning, batch, queue, or delivery-state workflows for compatibility unless an active GitHub integration still requires them.
- Do not mutate issues, Projects, pull requests, workflows, or other GitHub state unless the current task explicitly authorizes that action.

## Stop Conditions

Stop when:

- a GitHub-specific instruction conflicts with root/scoped `AGENTS.md` or canonical standards;
- a requested GitHub workflow would duplicate an existing `.agents/skills/` workflow;
- issue, Project, PR, workflow, or automation mutation lacks explicit authority;
- the correct canonical owner for a requirement is unclear.