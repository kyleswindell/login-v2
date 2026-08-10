# Modules AGENTS.md

## Purpose

Permanent owner root for optional Login 2.0 Modules.

A Module is defined by cohesive optional responsibility and independent lifecycle, not by current folder placement. Every Module must reach the accepted target state of an independently versioned, installable, and distributable Composer package.

Target package shape is owner-local and sparse:

```text
Modules/<Module>/
├── composer.json
├── README.md
├── src/<TechnicalRole>/
├── config/
├── routes/
├── database/
├── resources/
├── tests/
└── docs/
```

Only create branches the Module actually requires.

## Read Order

1. Read root `AGENTS.md`.
2. Read the issue or authorized task.
3. Read the [Module Definition](../docs/07-planning/Definitions/Modules/Definition.md).
4. Read [Repository Architecture](../docs/03-architecture/repository-architecture.md) when ownership or placement matters.
5. Open the target Module's `composer.json`, README, Module definition/identity source, and nearest scoped `AGENTS.md` when present.
6. Read only the Module-owned source and public Contracts required by the task.
7. Read applicable coding, database, security, UI, logging, and operational standards.
8. For test-source work, route through the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md).
9. For proof semantics and verification gates, route through the [Testing Standards Index](../docs/02-standards/testing/index.md).

Do not scan every Module for a bounded change.

## Ownership

A responsibility is Module-owned only when Core remains valid and operational without it and the responsibility has an independent lifecycle.

A Module may own:

- its feature behavior and workflows;
- its feature-specific state and persistence;
- its public Contracts and extension points;
- its routes and Delivery Adapters;
- its configuration and dependency declarations;
- its presentation and UI contributions;
- its tests, fixtures, documentation, compatibility, and migration behavior.

A Module must not own:

- required Core invariants;
- reusable UI infrastructure;
- another Module's private implementation or state;
- generic Registry, contribution, or lifecycle infrastructure owned by Core.

Placement beneath `Modules/` alone does not prove Module ownership.

## Package And Placement Rules

- New canonical Module PHP implementation belongs under `Modules/<Module>/src/<TechnicalRole>/`.
- Module configuration, routes, database artifacts, resources, tests, and docs remain package-local when applicable.
- Current direct-root PHP branches such as `Actions/`, `Models/`, `Services/`, `Providers/`, `Support/`, or `Http/` may be transitional. Do not expand them as target structure.
- Do not create empty universal Module skeletons for symmetry.
- Do not use `Modules/_Template/` as a new Module owner.
- Keep Module identity representations distinct: PascalCase folder/namespace, Composer identity, slug, route/config roots, and `module_key`.

## Dependencies

- Modules may depend on Core public Contracts.
- Modules may consume public UI Contracts.
- Module-to-Module dependencies must be explicit, version-constrained, declared, validated, and Contract-based.
- A Module may extend another Module only through published extension points.
- Do not import or invoke another Module's internal implementation.
- Do not create cross-Module behavior through incidental database knowledge, physical paths, or undocumented classes.

## Verification

Use the issue's accepted `AC-*` / `PF-*` verification contract.

Keep Module-owned tests and fixtures with the Module. Preserve required Core-absent, dependency, compatibility, denied/rejection, and package-boundary proof when applicable.

Do not weaken protected tests, fixtures, Contracts, or package verification after the accepted initial baseline.

## Avoid

- Do not classify required base-application behavior as a Module because it is package-shaped.
- Do not move reusable UI into a Module because the Module is its first consumer.
- Do not add undeclared cross-Module dependencies.
- Do not broaden a Module's public API during unrelated implementation.
- Do not perform package migration as incidental cleanup.

## Stop Conditions

Stop and report when:

- Module ownership is unclear;
- the responsibility may actually be required Core behavior or reusable UI;
- package identity or dependency rules are unresolved;
- a cross-Module dependency lacks a public Contract;
- the change would expand transitional direct-root structure;
- required compatibility or migration behavior is unresolved;
- protected proof would require material revision without accepted authority.

## Related

- [Module Definition](../docs/07-planning/Definitions/Modules/Definition.md)
- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [Coding Standards Index](../docs/02-standards/coding/index.md)
- [Agent Implementation Checklist](../docs/02-standards/coding/Agent%20Implementation%20Checklist.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../docs/02-standards/testing/index.md)
