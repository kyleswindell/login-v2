# Module Definition Drafts

This directory is the planned home for module definition classes.

Module definitions are not module packages. They are app-owned metadata
used by `Definitions` and `Repository` to describe ownership, dependencies,
and UI entry contributions for known modules.

Use module definitions for:

- module key, display name, type, lifecycle defaults, and dependencies
- route, permission, widget, settings group, table, command, and view ownership
- UI entry metadata consumed by Workspace surfaces
- transitional ownership of existing Laravel-standard folders before files move

Do not use module definitions for:

- controllers, models, actions, policies, jobs, or business logic
- routes, migrations, seeders, views, translations, or assets
- runtime install, enable, disable, or setup state
- app-instance-specific configuration or tenant data

Physical module packages live under `Modules/<ModuleName>/`.

`Modules/Dashboard/Definition.php` is the first real module-owned definition
proof. It is not duplicated in this app-level definitions folder.

`Modules/_Template` is the copy source for a future module package. This
directory is only for module definition classes and examples.

`Example` is a non-runtime draft. It must not be added to
`Definitions::manifests()` unless it is deliberately converted into a real
module definition.
