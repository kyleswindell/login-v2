# AGENTS.md

## Folder Purpose

This folder owns canonical coding-agent standards.

It does not own executable skills, memory content, working-document drafts, or product truth.

## Required Reading

1. Read `index.md`.
2. Open only the standard relevant to the task.
3. Read root and nearest scoped `AGENTS.md`.
4. Read the exact skill only when executing or reviewing that skill.

## Routing

| Task | Owner |
| --- | --- |
| Instruction surfaces and skills | `Agent Instruction Surface And Skill Authoring Standards.md` |
| Agent working docs and promotion | `Agent Working Documentation And Promotion Standards.md` |
| Concurrent sessions and worktrees | `Agent Session Concurrency And Worktree Standards.md` |
| Context and retrieval | `Agent Context And Retrieval Standards.md` |
| Repo-local memory | `Repo-Local Agent Memory Standards.md` |

## Avoid

- Do not read every agent standard or skill.
- Do not place executable procedures here.
- Do not duplicate canonical product or technical docs.
- Do not treat memory or `docs/11-ai/` as canonical.
- Do not preserve deprecated batch-workflow ownership.
- Do not authorize commit, push, merge, deploy, migration, or destructive actions implicitly.

## Verification

For changes in this folder:

- update `index.md`
- update related `AGENTS.md` files
- update affected skills
- update templates when reusable shapes change
- verify portable links
- remove or supersede competing authorities
- run documentation guardrails when available

## Related

- [Coding Agent Standards Index](index.md)
- [Coding Standards Index](../coding/index.md)
- [Documentation Standards Index](../documentation/index.md)
