# app/Platform AGENTS.md

## Status

**Transitional guardrail only.**

`app/Platform/` remains populated with current source, but Platform is not an accepted target ownership area.

This file exists to prevent transitional maintenance from creating new Platform ownership. Delete this `AGENTS.md` when the `app/Platform/` tree is fully retired.

## Purpose

Permit only bounded:

- maintenance required to preserve current behavior;
- compatibility fixes;
- defect fixes where the current implementation still lives here;
- migration work explicitly authorized by a bounded issue.

Do not use this folder as the destination for new canonical capabilities, reusable infrastructure, or generic shared behavior.

## Read Order

Before editing anything under `app/Platform/`:

1. Read root `AGENTS.md`.
2. Read `app/AGENTS.md`.
3. Read the issue or authorized task.
4. Read [Repository Architecture](../../docs/03-architecture/repository-architecture.md).
5. Identify the accepted target owner: Core capability, Module, UI responsibility, or restricted Laravel integration boundary.
6. Read the applicable canonical definition, feature/flow/schema Contract, and standards.
7. Read the existing Platform source and directly affected tests.
8. Identify compatibility and migration constraints before changing namespace, path, public API, serialized identity, routing, configuration, or persistence behavior.

Do not read all Platform subtrees for a local maintenance change.

## Guardrails

- Platform is transitional placement, not a fourth application owner.
- Do not create a new canonical `App\Platform\...` responsibility.
- Do not add a generic `Shared`, `Common`, `Support`, `Services`, or `Infrastructure` branch here.
- Do not migrate source merely to make the tree look closer to target architecture.
- Do not combine behavior changes with physical migration unless both are explicitly in scope.
- Do not remove compatibility behavior until its dependency and removal condition are verified.
- New behavior should normally be implemented under its accepted target owner rather than added here.

A temporary adapter or compatibility change may remain here only when the accepted issue explicitly requires it.

## Verification

Maintenance or migration work must preserve the issue's accepted `AC-*` / `PF-*` verification contract.

Before a physical move or namespace change, identify applicable:

- route/configuration references;
- service-container or provider registration;
- serialized/queued class identity;
- factories, seeders, policies, or framework discovery;
- UI and JavaScript consumers;
- tests and fixtures;
- compatibility requirements.

Do not weaken protected proof to complete a migration.

## Stop Conditions

Stop and report when:

- the target owner is unresolved;
- the change would create new Platform ownership;
- migration scope or compatibility requirements are incomplete;
- a namespace/path change has unverified runtime consumers;
- the issue does not authorize the required physical move;
- required proof fails unexpectedly;
- unrelated Platform cleanup would be required.

## Related

- [Repository Architecture](../../docs/03-architecture/repository-architecture.md)
- [Coding Standards Index](../../docs/02-standards/coding/index.md)
- [Agent Implementation Checklist](../../docs/02-standards/coding/Agent%20Implementation%20Checklist.md)
- [Testing Standards Index](../../docs/02-standards/testing/index.md)
