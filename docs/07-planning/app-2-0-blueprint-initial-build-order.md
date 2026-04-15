# App 2.0 Blueprint Initial Build Order

This document defines the canonical scope and intent for App 2.0 Blueprint Initial Build Order.

## Purpose

Planning extraction from the original App 2.0 blueprint.

## Initial Build Order

1. repository foundation and documentation
2. Laravel scaffold
3. Docker Compose local development stack
4. platform-vs-tenant application boundary planning
5. V2 feature roadmap and folder/panel structure planning
6. platform database schema
7. tenant domain registry
8. tenant resolver and database connection manager
9. tenant active/inactive middleware
10. tenant template database creation process
11. provisioning pipeline and logs
12. tenant storage initializer
13. platform panel tenant resources
14. tenant panel authentication and minimal dashboard
15. module policy model
16. page/block/article/media content foundation
17. publish job and Astro build hook

## Open Implementation Detail

Local development currently recommends Docker Compose. The scaffold can still begin by verifying the production-like `platform-prod` environment over SSH before the full local Compose file is finalized.

## Related

- [App 2.0 Blueprint](../03-architecture/app-2-0-blueprint.md)
- [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)
