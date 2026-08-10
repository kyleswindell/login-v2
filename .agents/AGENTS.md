# .agents AGENTS.md

## Purpose

Repository-local agent support material.

This folder owns:

- executable workflow skills;
- non-canonical repo-local memory;
- session/worktree handoff artifacts;
- advisory scope claims;
- exportable baseline packs.

It does not own canonical product, architecture, feature, schema, standards, planning, or delivery-state truth.

## Read Order

1. Read root `AGENTS.md`.
2. For workflow execution, read only the named skill under `.agents/skills/`.
3. When changing agent instruction or skill behavior, read the applicable [Coding Agent Standards](../docs/02-standards/coding-agents/index.md).
4. For memory work, read `.agents/memory/README.md` and only the specific memory file required.
5. For session/worktree handoff or scope coordination, read only the relevant artifact and the applicable concurrency/worktree standard.
6. For baseline-pack work, read only that baseline's README and scoped instructions.

Do not load neighboring skills, memory, handoffs, or baselines speculatively.

## Authority Boundaries

- `.agents/skills/` contains repeatable execution playbooks, not canonical technical policy.
- `.agents/memory/` is optional, non-canonical, and prunable.
- handoff and advisory-claim artifacts coordinate execution; they are not file locks or implementation authority.
- `.agents/baselines/` contains reusable/exportable starter material and is not an active repository rule unless promoted into the live instruction surface.
- durable rules discovered during agent work must be promoted to the correct canonical owner.

## Avoid

- Do not read all skills before executing one workflow.
- Do not treat memory as canonical truth or current issue state.
- Do not edit a session/worktree handoff outside the workflow that owns it.
- Do not treat advisory scope claims as write permission or conflict prevention.
- Do not use baseline-pack files as active repo rules unless they have been explicitly promoted.
- Do not duplicate large canonical standards blocks inside skills or memory.
- Do not store secrets, credentials, tokens, customer data, or production-sensitive material anywhere under `.agents/`.

## Token Discipline

Keep context bounded:

- name the exact workflow before reading or writing;
- name the target ID when one exists;
- state the accepted file scope before edits;
- follow the smallest read path that can answer the task;
- load only the canonical owner and execution procedure required;
- stop when scope, owner, verification, or review authority becomes ambiguous.

Record recurring broad-read or retrieval-path problems in `.agents/memory/working/token-usage-observations.md` only when they are genuinely reusable.

## Stop Conditions

Stop and report when:

- an agent artifact conflicts with root or scoped `AGENTS.md`;
- a skill conflicts with canonical standards;
- memory is being used as the only source for durable repository truth;
- a handoff would transfer unclear branch/worktree or file ownership;
- a baseline is being treated as live repository policy;
- the requested workflow requires authority not granted by the issue or user.

## Related

- [Coding Agent Standards Index](../docs/02-standards/coding-agents/index.md)
- [Agent Instruction Surface And Skill Authoring Standards](../docs/02-standards/coding-agents/Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md)
- [Agent Session Concurrency And Worktree Standards](../docs/02-standards/coding-agents/Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md)
- [Repo-Local Agent Memory Standards](../docs/02-standards/coding-agents/Repo-Local%20Agent%20Memory%20Standards.md)
