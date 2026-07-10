# Module Contribution Registries

This document defines the canonical schema contract for module contribution registry projections.

## Tables

- `module_registry_entries`
- `notification_registry_entries`
- `settings_registry_entries`
- `setup_registry_entries`
- `preference_registry_entries`

## Persistence Rules

- Module manifests remain the canonical source of module contribution metadata.
- Registry tables are synced DB projections used for global lists, stale detection, and future instance or tenant filtering.
- Removed declarations are marked inactive and stale instead of deleted.
- `source_hash` records normalized declaration metadata at sync time.
- DB rows must not introduce executable routes, views, handlers, permissions, or notification types.

## Runtime Boundaries

- `permission_registry_entries` remains the permission metadata registry.
- `settings` remains settings value storage.
- `user_notification_preferences` remains personal notification delivery preference storage.
- Navigation consumers may use registry rows for active/stale inclusion, but executable behavior must still resolve from module manifests.

## Related

- [Schema](../schema.md)
- [module_registry_entries](../tables/module_registry_entries.md)
- [notification_registry_entries](../tables/notification_registry_entries.md)
- [settings_registry_entries](../tables/settings_registry_entries.md)
- [setup_registry_entries](../tables/setup_registry_entries.md)
- [preference_registry_entries](../tables/preference_registry_entries.md)
