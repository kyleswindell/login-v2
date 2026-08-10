# app AGENTS.md

## Purpose

Base-application PHP source and bounded application-wide Laravel integration.

Application ownership is owner-first:

```text
app/Core/<Capability>/
app/UI/<Responsibility>/
app/Http/
app/Console/
app/Providers/
```

- `app/Core/<Capability>/` owns required base-application capabilities.
- `app/UI/<Responsibility>/` owns reusable UI PHP/runtime responsibilities.
- `app/Http/`, `app/Console/`, and `app/Providers/` are restricted application-wide Laravel integration boundaries, not default feature owners.
- Optional Modules remain under repository-root `Modules/`.

Existing `app/Platform/`, `app/Surfaces/`, and generic `Surface/` structures are transitional where they remain. They are not target owners or default destinations for new canonical work.

## Read Order

1. Read the issue or authorized task.
2. Identify the smallest clear Core, UI, Module, or Laravel-integration owner.
3. Read [Repository Architecture](../docs/03-architecture/repository-architecture.md) when placement or ownership matters.
4. Read the nearest applicable source-tree `AGENTS.md` when one exists.
5. Open only the directly affected classes before expanding to collaborators.
6. Read the applicable feature, flow, database Contract, security standard, UI Contract, or runbook only when the behavior crosses that owner.
7. For implementation mechanics, route through the [Coding Standards Index](../docs/02-standards/coding/index.md).
8. For test source, use the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md).
9. For proof semantics and verification gates, use the [Testing Standards Index](../docs/02-standards/testing/index.md).

Do not scan the entire `app/` tree for a bounded implementation slice.

## Ownership And Placement

Before creating or moving PHP source:

- identify the application ownership area: Core, Module, or UI;
- identify the specific capability, Module, UI responsibility, or restricted Laravel integration boundary;
- identify the Technical Role or file archetype;
- confirm the target path against Repository Architecture and naming standards;
- identify public Contracts required across owners.

Technical Roles such as Action, Service, Query, Model, Policy, Event, Listener, Job, Resolver, Delivery Adapter, Registry, or Contract remain beneath an explicit owner.

Do not use a Technical Role as a substitute application owner.

## Laravel Integration Boundaries

Use root Laravel integration folders only for genuinely application-wide framework integration.

Do not place owner-specific behavior in root `Http`, `Console`, or `Providers` merely because Laravel supports that artifact type there.

Keep controllers, middleware, commands, providers, and other Delivery Adapters thin. Route durable behavior to its owning capability, Module, or UI responsibility.

## Verification

The issue or authorized work packet determines required `AC-*` criteria and `PF-*` proof.

Before production implementation, follow the [Agent Implementation Checklist](../docs/02-standards/coding/Agent%20Implementation%20Checklist.md) and the applicable Testing Standards.

Do not:

- begin production implementation when required initial proof has not reached its declared state;
- weaken, skip, delete, or materially rewrite protected tests or fixtures to make implementation pass;
- treat unexpected syntax, fixture, dependency, boot, discovery, tooling, or environment failures as expected missing behavior;
- claim verification passed unless the declared command or procedure actually ran successfully.

## Avoid

- Do not use `app/Platform/` as a default home for reusable application behavior.
- Do not create a generic `Shared`, `Common`, `Support`, `Services`, or `Infrastructure` owner bucket.
- Do not move files across ownership boundaries without accepted scope and migration authority.
- Do not change tenant/Instance/Workspace isolation, authorization, security, transaction, or persistence behavior without checking the canonical owner.
- Do not put feature behavior into providers, controllers, middleware, commands, or other framework entry adapters.
- Do not change behavior while performing a structure-only move unless both are explicitly in scope.
- Do not perform unrelated cleanup during a bounded implementation slice.

## Stop Conditions

Stop and report when:

- the application owner is unclear;
- multiple owners could credibly own the same responsibility;
- target placement conflicts with Repository Architecture;
- a cross-owner dependency lacks a public Contract;
- behavior, schema, security, compatibility, transaction, or UI requirements are unresolved;
- required verification cannot run or produces an unexpected result;
- another writer owns the same worktree or file scope;
- completing the task requires broad unrelated migration or cleanup.

## Related

- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [Coding Standards Index](../docs/02-standards/coding/index.md)
- [Agent Implementation Checklist](../docs/02-standards/coding/Agent%20Implementation%20Checklist.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../docs/02-standards/testing/index.md)
