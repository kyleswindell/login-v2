# App 2.0 Blueprint

High-level architecture intent for Login App 2.0.

## Locked Direction

See: `/docs/03-architecture/stack-overview.md`

## Domains

Platform admin:

- `login.parasolutions.com`

Tenant admin:

- arbitrary tenant admin domains, for example `login.clientdomain.com`

Tenant resolution order:

1. exact tenant admin domain match
2. optional alias domain match
3. resolve tenant from central platform database
4. initialize tenant database connection
5. boot tenant context

## Related

- [Architecture Index](index.md)
- [Platform Boundary](platform-boundary.md)
- [Stack Overview](stack-overview.md)
- [Brochure Sites Subsystem](subsystems/brochure-sites-subsystem.md)
- [App 2.0 Blueprint Initial Build Order](../07-planning/app-2-0-blueprint-initial-build-order.md)
- [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)
