# database AGENTS.md

## Purpose

Core schema-lifecycle artifacts, application-wide database integration, root database composition, and bounded cross-owner database support.

Target ownership is not flat:

```text
database/core/<Capability>/migrations/
database/core/<Capability>/factories/
database/core/<Capability>/seeders/

Modules/<Module>/database/
```

Module-owned database artifacts remain with their Module.

Existing root migration, factory, or seeder placement may be transitional evidence. Do not move or duplicate it merely to match target topology without accepted migration scope.

## Read Order

1. Read the issue or authorized task.
2. Identify the owner of the persisted behavior or schema.
3. Read [Repository Architecture](../docs/03-architecture/repository-architecture.md) when placement or ownership matters.
4. Read the applicable [Database Standards](../docs/02-standards/database/index.md).
5. Read the related database Contract under `docs/06-database/` when schema, relationship, key, index, lifecycle, classification, retention, or migration behavior changes.
6. Open only the affected migration, factory, seeder, or database integration file and its direct dependencies.
7. Read applicable security, logging, coding, or operational standards only when the change crosses those boundaries.
8. For test source, use the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md).
9. For proof semantics and database verification, use the [Testing Standards Index](../docs/02-standards/testing/index.md).

Do not scan all historical migrations unless the task explicitly requires repository/schema history.

## Ownership Rules

- Core capability persistence behavior remains owned by its Core capability even when schema-lifecycle files live beneath root `database/core/<Capability>/`.
- Module persistence and database artifacts remain Module-owned under `Modules/<Module>/database/`.
- Root `database/` does not become a generic application owner.
- Laravel conventions do not transfer database ownership away from the capability or Module whose data lifecycle is being implemented.
- Shared use of a table or migration helper does not create generic shared ownership.

Before adding a database artifact, identify:

- owning capability or Module;
- applicable table/database Contract;
- scope boundary;
- migration and rollback expectations;
- compatibility requirements;
- verification environment.

## PostgreSQL And Data Safety

PostgreSQL is the target database.

Do not introduce MySQL-specific behavior as active implementation unless an explicit compatibility requirement requires it.

For protected or tenant-owned data, confirm applicable:

- Tenant / Instance / Workspace scope;
- keys and relationships;
- uniqueness and indexes;
- authorization and object boundaries;
- classification and sensitive fields;
- retention, erasure, and export requirements;
- Audit and evidence requirements;
- transaction and rollback behavior.

## Verification

Database changes must use the verification contract declared by the issue or authorized task.

Use the required PostgreSQL/native database environment when proof depends on PostgreSQL semantics.

Do not:

- substitute SQLite for PostgreSQL-dependent proof;
- classify migration boot, fixture, dependency, environment, or tooling failures as expected missing behavior;
- weaken protected database tests or fixtures after the initial proof;
- claim migration or rollback behavior passed without executing the declared proof.

## Avoid

- Do not change schema behavior without checking the owning database Contract.
- Do not create Module-owned schema lifecycle artifacts under Core database paths.
- Do not create new owner-local paths solely for symmetry.
- Do not perform broad migration renames or moves as part of a narrow behavior issue.
- Do not infer deployed database state from source-controlled migrations alone.
- Do not add destructive migrations without accepted recovery, compatibility, and review requirements.
- Do not place secrets, production data, or sensitive evidence in migrations, factories, seeders, or fixtures.

## Stop Conditions

Stop and report when:

- persistent-data ownership is unresolved;
- table or field behavior conflicts with the canonical database Contract;
- a migration requires an unresolved compatibility or data-migration decision;
- the required PostgreSQL environment is unavailable for a mandatory proof;
- rollback or recovery behavior is unresolved;
- a protected fixture or database proof would require material revision without authority;
- unrelated migration history would need to be rewritten;
- another writer owns the same database or shared migration scope.

## Related

- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [Database Standards Index](../docs/02-standards/database/index.md)
- [Database Documentation Index](../docs/06-database/index.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../docs/02-standards/testing/index.md)
