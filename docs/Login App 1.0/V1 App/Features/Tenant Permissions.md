# Tenant Permissions

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how tenant feature/module access is controlled.

## Use This Note When

Use this note when you need the feature-level answer to:

- how tenant access control behaves from a product/admin perspective
- where module vs native-core restrictions show up in the UI and routes
- which related allowlist notes to open next

Do not use this note as the main owner of:

- the underlying `tbltenants` data model
- Admin Core implementation details
- generalized role/permission behavior outside tenant policy

## Current Implementation

Admin Core stores `allowed_modules` and `allowed_core_features` as data-driven tenant policy values.

These policies are enforced across module visibility, setup menu visibility, sidebar links, quick actions, project tabs, settings sections, and direct admin route access.

## Related Capabilities

- Module allowlist controls tenant module availability.
- Core feature allowlist controls native Perfex areas such as customers, sales, projects, tasks, support, leads, reports, and knowledge base.

## Related

- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](Tenant%20Module%20Allowlist.md)
- [[V1 App/Features/Tenant Core Feature Allowlist]] | [Tenant Core Feature Allowlist](Tenant%20Core%20Feature%20Allowlist.md)
