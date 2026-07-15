# AGENTS.md

## Folder Purpose

This folder owns temporary Goal 03 planning for Laravel integration, root-folder roles, owner-local conventions, and migration direction.

This file is agent-facing routing guidance. It is not the canonical Laravel definition.

Canonical Laravel truth remains in:

- `../../Definitions/Laravel/Definition.md`

## Ownership

This folder may contain:

- `README.md`
- `Index.md`
- Laravel integration planning
- root-folder role planning
- owner-local Laravel convention planning
- placement, naming, registration, and migration planning

This folder must not contain:

- the canonical Laravel definition
- Core, Module, UI, or Surface definitions
- implementation code
- feature behavior
- permanent architecture after promotion
- unrelated temporary notes
- active issue or Project status

Every document must have a clear Goal 03 purpose and a promotion, supersession, or removal path.

## Required Reading Before Editing

Read:

1. `../../../../AGENTS.md`
2. `../../../AGENTS.md`
3. `../../AGENTS.md`
4. `README.md`
5. `Index.md`
6. `../../Definitions/Laravel/Definition.md`
7. only the supporting document required by the task

Required sources:

- [Laravel Definition](../../Definitions/Laravel/Definition.md)
- [Core Definition](../../Definitions/Core/Definition.md)
- [Module Definition](../../Definitions/Modules/Definition.md)
- [UI Definition](../../Definitions/UI/Definition.md)
- [Surface Definition](../../Definitions/Surfaces/Definition.md)
- [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)

Prefer targeted reads over loading unrelated planning documents.

## Canonical Owners To Check

| Change Type                     | Canonical Owner                                       |
| ------------------------------- | ----------------------------------------------------- |
| Laravel framework definition    | `docs/07-planning/Definitions/Laravel/Definition.md`  |
| Core ownership                  | `docs/07-planning/Definitions/Core/Definition.md`     |
| Module ownership                | `docs/07-planning/Definitions/Modules/Definition.md`  |
| UI ownership                    | `docs/07-planning/Definitions/UI/Definition.md`       |
| Surface definition              | `docs/07-planning/Definitions/Surfaces/Definition.md` |
| Temporary Laravel planning      | this folder                                           |
| Accepted permanent architecture | `docs/03-architecture/` after promotion               |
| Implementation conventions      | `docs/02-standards/`                                  |

Do not leave durable accepted architecture only under `temp/`.

## Laravel Boundary Guardrails

When drafting Laravel planning:

- treat Laravel as the framework, runtime, and composition system
- do not treat Laravel as a source-of-truth application owner
- preserve Core, Module, and UI ownership
- use Laravel-native concepts within owner-first boundaries
- reserve root Laravel folders for application-wide framework roles
- keep owner-specific Laravel artifacts with their Core capability or Module when practical
- do not treat a class as framework-owned solely because it is a controller, model, job, event, policy, or provider
- keep bootstrap and adapter code thin
- do not move application behavior into providers, controllers, middleware, commands, or other entry adapters
- do not accept exact physical placement before the owning Goal 03 phase resolves it

## File And Documentation Rules

- Use the applicable template from `docs/09-reference/templates/docs/`.
- Preserve `DOC-META`.
- Mark temporary documents non-canonical.
- Keep metadata, title, path, parent, and status aligned.
- Update `Index.md` when documents are added, moved, promoted, superseded, or removed.
- Link to definitions instead of duplicating them.
- Separate current implementation, target state, and migration direction.
- Identify the permanent promotion or removal target.
- Do not add generic `notes.md`, `misc.md`, or `draft.md` files.
- Do not create child folders without explicit scope.

## Testing And Verification

For documentation changes, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify:

* metadata paths and parent links
* filename casing
* temporary documents remain non-canonical
* definitions are linked rather than duplicated
* proposed and accepted rules remain separate
* every temporary document has a promotion or removal path

Do not claim verification passed unless the commands ran successfully.

## Stop Conditions

Stop and report when:

* the content belongs in the canonical Laravel definition
* the subject already has a permanent owner
* Laravel is being treated as an application owner
* Core, Module, UI, or Surface ownership is unclear
* root technical folders are being used as generic owner buckets
* physical placement is being accepted prematurely
* durable content would remain under `temp/`
* a new child folder is required without explicit scope
* unrelated working-tree changes may be overwritten

## Related

* [Root AGENTS](../../../../AGENTS.md)
* [Docs AGENTS](../../../AGENTS.md)
* [Planning AGENTS](../../AGENTS.md)
* [Laravel README](README.md)
* [Laravel Index](Index.md)
* [Laravel Definition](../../Definitions/Laravel/Definition.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)

```

These drafts intentionally defer the individual `Bootstrap`, `Config`, `Routes`, and other Laravel-area definitions until the target tree and placement phases resolve their exact roles.