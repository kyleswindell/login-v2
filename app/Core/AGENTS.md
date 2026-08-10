# app/Core AGENTS.md

## Purpose

Permanent owner root for required Login 2.0 Core capabilities.

Every direct child of `app/Core/` must represent one cohesive required capability. Technical roles remain beneath that capability; they are not peer application owners.

Target shape:

```text
app/Core/<Capability>/
├── <TechnicalRole>/
├── routes/
├── config/
└── __tests__/
```

Structure is sparse. Create only the branches a capability actually requires.

## Read Order

1. Read root `AGENTS.md`.
2. Read `app/AGENTS.md`.
3. Read the issue or authorized task.
4. Read the [Core Definition](../../docs/07-planning/Definitions/Core/Definition.md).
5. Read [Repository Architecture](../../docs/03-architecture/repository-architecture.md) when ownership or placement matters.
6. Identify the exact Core capability before opening source broadly.
7. Read the capability-owned source, public Contracts, and directly affected tests.
8. Read only the applicable coding, database, security, UI, logging, or operational standards.
9. For test-source construction, route through the [Test Implementation Standards Index](../../docs/02-standards/coding/test-implementation/index.md).
10. For proof semantics and verification gates, route through the [Testing Standards Index](../../docs/02-standards/testing/index.md).

Do not scan all Core capabilities for a bounded change.

## Ownership

A responsibility belongs in Core only when it satisfies the canonical Core classification rule.

Core may own:

- required base-application behavior and state;
- required coordination and lifecycle behavior;
- required infrastructure and registries;
- public Contracts consumed by Modules;
- Core-owned persistence;
- Core-owned Delivery Adapters and presentation.

Core must not absorb:

- optional Module behavior;
- reusable UI infrastructure;
- another capability's internal implementation;
- generic shared code without one explicit Core responsibility.

Shared use alone does not make something Core-owned.

## Placement

- Keep capability implementation beneath `app/Core/<Capability>/`.
- Keep public Contracts with the capability that owns them.
- Keep owner-specific routes and configuration with the capability when the accepted architecture assigns them there.
- Keep owner-specific tests under `app/Core/<Capability>/__tests__/`.
- Keep Core schema-lifecycle artifacts under the accepted `database/core/<Capability>/` structure.
- Use root `app/Http`, `app/Console`, and `app/Providers` only for genuinely application-wide Laravel integration.
- Do not use `app/Platform/`, `app/Surfaces/`, `Shared/`, `Common/`, `Support/`, or other generic branches as target ownership.

Technical roles such as Action, Query, Policy, Event, Listener, Job, Registry, Contract, Model, Resolver, or Delivery Adapter must remain beneath an explicit capability owner.

## Dependencies

- Core must operate with no optional Modules installed.
- Core must not import or depend on optional Module implementation.
- Core may depend on another Core public Contract when the dependency is explicit.
- Core presentation may consume public UI Contracts.
- Core business and system logic must not depend on Blade, CSS, JavaScript, or UI implementation details.
- Cross-owner behavior must use the accepted public Contract, event, Registry, or other canonical interaction boundary.

## Verification

Use the issue's accepted `AC-*` / `PF-*` verification contract and the repository Testing standards.

Do not:

- begin production implementation before a required initial proof reaches its declared state;
- weaken, skip, delete, redirect, or materially rewrite protected proof to make implementation pass;
- classify unexpected tooling, dependency, fixture, boot, discovery, or environment failures as expected missing behavior;
- claim verification passed unless the exact required command or procedure ran successfully.

The accepted targeted proof must pass unchanged after implementation when the verification contract requires it.

## Avoid

- Do not create generic Core layers such as `Core/Services`, `Core/Models`, `Core/Shared`, `Core/Common`, or `Core/Infrastructure`.
- Do not place behavior in Core merely because several owners consume it.
- Do not move existing transitional code into Core without accepted classification, target placement, compatibility, and migration scope.
- Do not invent a new capability because the target class needs somewhere to live.
- Do not perform unrelated cleanup during a bounded implementation slice.

## Stop Conditions

Stop and report when:

- the Core capability owner is unclear;
- the responsibility may actually be optional Module behavior or reusable UI;
- a cross-owner dependency lacks a public Contract;
- target placement conflicts with Repository Architecture;
- required behavior, schema, security, transaction, compatibility, or verification authority is unresolved;
- protected evidence would require material revision without accepted authority;
- another writer owns the same worktree or shared file scope.

## Related

- [Core Definition](../../docs/07-planning/Definitions/Core/Definition.md)
- [Repository Architecture](../../docs/03-architecture/repository-architecture.md)
- [Coding Standards Index](../../docs/02-standards/coding/index.md)
- [Agent Implementation Checklist](../../docs/02-standards/coding/Agent%20Implementation%20Checklist.md)
- [Test Implementation Standards Index](../../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../../docs/02-standards/testing/index.md)
