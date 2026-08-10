# routes AGENTS.md

## Purpose

Application-wide Laravel route entrypoints, owner-route registration, global routing infrastructure, and bounded compatibility routing.

Root `routes/` is not the default owner of capability or Module behavior.

Target owner-local routes include:

```text
app/Core/<Capability>/routes/
Modules/<Module>/routes/
```

UI does not own application routes.

Existing root route definitions may remain transitional or composition-level entrypoints until an accepted migration moves them.

## Read Order

1. Read the issue or authorized task.
2. Identify the Core capability or Module that owns the routed behavior.
3. Open the exact root route entrypoint or owner-local route file involved.
4. Follow the route to its controller, Livewire component, handler, or other Delivery Adapter.
5. Read [Repository Architecture](../docs/03-architecture/repository-architecture.md) when placement or route ownership changes.
6. Read applicable feature or flow documentation for observable behavior.
7. Read [Repository Naming Standards](../docs/02-standards/coding/repository-naming-standards.md) when route paths or route names change.
8. Read applicable Security standards when authentication, authorization, elevated access, CSRF, signed URLs, webhooks, or protected resources are involved.
9. Route test-source work through the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md) and proof semantics through the [Testing Standards Index](../docs/02-standards/testing/index.md).

Do not scan unrelated route files for a bounded URL change.

## Route Ownership Rules

- Route registration does not transfer behavior ownership.
- Core-owned routes remain tied to the owning Core capability.
- Module-owned routes remain tied to the owning Module.
- Root route files should coordinate application-wide entrypoints, registration, infrastructure, or accepted compatibility only.
- Controllers and other Delivery Adapters must remain thin and delegate durable behavior to the owning responsibility.
- Route names, URL paths, permission keys, and owner keys are distinct contracts and must not be conflated.

## Compatibility

Do not create aliases, redirects, duplicate endpoints, or transitional route paths without an accepted compatibility requirement and removal/retention direction.

Preserve current public route behavior unless the issue explicitly authorizes a change.

## Verification

Map route behavior to the issue's declared `AC-*` and `PF-*` proof.

Verify applicable:

- successful request behavior;
- denied and unauthorized behavior;
- method restrictions;
- validation failure;
- redirects;
- route names and parameters;
- state-changing request semantics;
- compatibility behavior.

Do not use a state-changing `GET` route.

Do not weaken protected route tests or fixtures after the accepted initial proof.

## Avoid

- Do not place owner-specific business logic in route files.
- Do not use root `routes/` as a generic target for new capability or Module routes.
- Do not create route aliases without accepted compatibility authority.
- Do not bypass authorization because the route is internal or administrative.
- Do not perform broad route renames during a narrow feature issue.
- Do not infer permission to change public URLs from a folder or namespace migration.

## Stop Conditions

Stop and report when:

- route ownership is unclear;
- feature behavior or rejection behavior is unresolved;
- route naming conflicts with canonical naming standards;
- a compatibility path lacks accepted retention/removal behavior;
- protected authorization or security behavior is unclear;
- the issue would require a repository-wide URL migration;
- required route proof cannot run or returns an unexpected result.

## Related

- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [Repository Naming Standards](../docs/02-standards/coding/repository-naming-standards.md)
- [Security Standards Index](../docs/02-standards/security/index.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../docs/02-standards/testing/index.md)
