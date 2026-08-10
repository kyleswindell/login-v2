# AGENTS.md

## Folder Purpose

This folder owns canonical coding and implementation standards.

Testing and verification policy is owned separately by `docs/02-standards/testing/`. This folder owns only the coding and implementation conventions for test source.

## Required Reading

1. Read `index.md`.
2. Read only the standards applicable to the task.
3. For test-source implementation, read `Test Implementation Standards.md`.
4. For proof design, verification state, evidence, environments, or testing gates, route to `../testing/index.md`.
5. Read the nearest source-tree `AGENTS.md`.
6. Read the issue or authorized task.
7. Read `Agent Implementation Checklist.md` for implementation readiness.

## Routing

| Topic                                | Owner                                                        |
| ------------------------------------ | ------------------------------------------------------------ |
| General coding                       | `Coding Standards.md`                                        |
| File responsibility                  | `File Archetypes.md`                                         |
| File construction                    | `File Building Standards.md`                                 |
| PHP and Laravel style                | `PHP And Laravel Style Standards.md`                         |
| Application actions and data objects | `Application Actions Services And Data Objects Standards.md` |
| Errors                               | `Error And Exception Handling Standards.md`                  |
| Transactions and idempotency         | `Transaction Concurrency And Idempotency Standards.md`       |
| Events and queues                    | `Events Jobs And Queue Standards.md`                         |
| Queries and performance              | `Query And Performance Standards.md`                         |
| Test source implementation           | `Test Implementation Standards.md`                           |
| Verification and proof               | `../testing/index.md`                                        |
| Templates and generators             | `Code Template And Generator Standards.md`                   |
| Git scope and commits                | `Git Change Scope And Commit Standards.md`                   |
| Implementation readiness             | `Agent Implementation Checklist.md`                          |

## Avoid

- Do not load every coding standard.
- Do not add testing or verification policy to `Testing Standards.md`; it is superseded.
- Do not duplicate proof, result, environment, evidence, or gate rules from `../testing/`.
- Do not duplicate agent governance here.
- Do not use deprecated batch workflow rules.
- Do not stage unrelated files.
- Do not use `git add .` in a dirty working tree.
- Do not infer permission to commit, push, migrate, or deploy.

## Related

- [Coding Standards Index](index.md)
- [Testing Standards Index](../testing/index.md)
- [Test Implementation Standards](Test%20Implementation%20Standards.md)
- [Coding Agent Standards Index](../coding-agents/index.md)
- [Documentation Standards Index](../documentation/index.md)
