# App 2.0 Blueprint Planning

This file is the planning-only sequencing note for Login App 2.0.

Architecture and server policy extracted from this note now live in:

* [App 2.0 Blueprint Architecture Baseline](../03-architecture/app-2-0-blueprint-architecture-baseline.md)
* [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)

## Initial Build Order

1. Repository foundation and documentation.
2. Laravel scaffold.
3. Docker Compose local development stack.
4. Platform database schema.
5. Tenant domain registry.
6. Tenant resolver and database connection manager.
7. Tenant active/inactive middleware.
8. Tenant template database creation process.
9. Provisioning pipeline and logs.
10. Tenant storage initializer.
11. Platform panel tenant resources.
12. Tenant panel authentication and minimal dashboard.
13. Module policy model.
14. Page/block/article/media content foundation.
15. Publish job and Astro build hook.

## Related

* [Planning Index](index.md)
* [App 2.0 Blueprint Initial Build Order](app-2-0-blueprint-initial-build-order.md)
* [App 2.0 Blueprint Architecture Baseline](../03-architecture/app-2-0-blueprint-architecture-baseline.md)
* [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)
