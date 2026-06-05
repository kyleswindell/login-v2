# .agents AGENTS.md

## Purpose

Agent support material. This folder owns executable workflow skills, repo-local memory, branch handoffs, advisory claims, and exportable baseline packs.

## Read Order

1. For workflow execution, read only the named skill in `.agents/skills/`.
2. For memory questions, read `.agents/memory/README.md` and the specific memory file.
3. For branch worker integration, read only the relevant handoff artifact.

## Avoid

- Do not read all skills before executing one workflow.
- Do not treat memory as canonical product truth.
- Do not edit handoff artifacts outside their branch-worker or integrator workflow.
- Do not use baseline pack files as active repo rules unless they have been promoted into the live instruction surface.

## Token Discipline

Skill files are execution playbooks. Read the active skill, then follow its required inputs instead of loading neighboring skills speculatively.

For workflow prompts and long-running work, keep context bounded:

- name the exact workflow before reading or writing
- name the target ID when one exists, such as a CQ, doc-review, or doc-sync ID
- state the allowed file scope before edits
- follow the smallest read path that can answer the task
- stop when scope, owner, or review surface becomes ambiguous

Record repeated broad reads, repeated long-file loads, or unclear prompt/read paths in `.agents/memory/working/token-usage-observations.md` when they are likely to recur.
