# Tenant Safety Standards

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

- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../V1%20App/Architecture/Multi%20Tenant%20Architecture.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../V1%20App/Modules/Admin%20Core.md)

