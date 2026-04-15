# Tenant Safety Standards

This document defines the canonical scope and intent for Tenant Safety Standards.

## Purpose

Document rules for safely changing tenant-aware code.

## Standards

- Do not hardcode tenant domains, paths, or database names.
- Do not assume admin-host and tenant-host behavior is the same.
- Use Admin Core helpers where possible to resolve tenant policy and configuration.
- Include tenant context in operational logs.
- Keep tenant website sync settings data-driven.
- Avoid cross-tenant reads/writes unless the feature explicitly requires admin-host fan-out.

## Related

- [Tenancy Architecture](../../03-architecture/tenancy.md)
- [Platform Boundary](../../03-architecture/platform-boundary.md)
