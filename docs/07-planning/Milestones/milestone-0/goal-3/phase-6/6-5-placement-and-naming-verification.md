<!--
DOC-META
title: Phase 6.5 Placement And Naming Verification
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-5-placement-and-naming-verification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Verifies predictable target placement and naming for Settings, Projects, Modal and Dialog, and Sidebar Navigation.
-->

# Phase 6.5 Placement And Naming Verification

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Confirm that each representative example has one predictable owner path, namespace, naming family, test location, and documentation owner.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: placement and naming validation only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phase 6.4 and accepted Goal 3 Phases 3 through 5
- Migration authorization: none

## 3. Verified Target Matrix

| Example               | PHP or artifact root                                    | Namespace or public identity                                                               | Supporting locations                                                                                                                                              |
| --------------------- | ------------------------------------------------------- | ------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Settings              | `app/Core/Settings/`                                    | `App\Core\Settings\`                                                                       | `app/Core/Settings/routes/`, `app/Core/Settings/config/settings.php`, `database/core/settings/`, `resources/views/core/settings/`, `app/Core/Settings/__tests__/` |
| Projects              | `Modules/Projects/` with PHP under `src/`               | `Parasolutions\Modules\Projects\`; package `parasolutions/module-projects`; key `projects` | Package-local `config/`, `routes/`, `database/`, `resources/`, `tests/`, and `docs/`                                                                              |
| Modal                 | `resources/views/components/ui/modal/`                  | Blade alias `x-ui.modal`; artifact-local `contract.php`                                    | Colocated CSS, JavaScript, partials, internals, and `__tests__/`                                                                                                  |
| Dialog                | `resources/views/components/ui/dialog/`                 | Accepted `x-ui.dialog.*` aliases and artifact-local Contract                               | Colocated CSS, JavaScript, internals, and `__tests__/`                                                                                                            |
| Core Navigation Host  | `app/Core/Navigation/`                                  | `App\Core\Navigation\`; owner key `navigation`                                             | Public Contracts, Registry, Data, Queries or precise resolution roles, owner registration, and `__tests__/`                                                       |
| Product Contributions | Contributor-local `Contrib/Navigation/`                 | Host Contract-defined declaration names and keys                                           | `app/Core/<Contributor>/Contrib/Navigation/` or `Modules/<Module>/src/Contrib/Navigation/`                                                                        |
| Sidebar rendering     | Accepted UI shell and Navigation Pattern artifact owner | Frame Surface and UI API names, not a PHP owner namespace                                  | UI-owned Blade, CSS, JavaScript, accessibility, and artifact tests                                                                                                |

## 4. Naming Findings

### Settings

`Settings` is the accepted capability name. `settings` is the owner, route, and configuration key family where applicable. The current `Modules/Settings/` namespace and package shape are transitional.

### Projects

The accepted representations remain:

```text
Projects
projects
Modules/Projects/
Parasolutions\Modules\Projects\
parasolutions/module-projects
projects.*
```

No `ProjectsModule`, `module_projects`, or `App\Modules\Projects` target identity is required.

### Navigation

`Navigation` accurately names the required Core capability that owns Product and Product Area navigation Contracts, Registry behavior, resolution, ordering, current state, and fallback.

Use:

```text
app/Core/Navigation/
App\Core\Navigation\
navigation
Contrib/Navigation/
```

`Frame Surface` remains a composition term. Do not create `app/Surfaces/`, `app/Core/Navigation/Surface/`, or another generic Surface implementation branch.

### Modal And Dialog

Artifact identity remains singular and kebab-case where applicable. Contracts, implementation, assets, and tests remain artifact-owned rather than copied into parallel technical trees.

## 5. Placement Boundaries

- Technical Roles remain sparse.
- Core and Module behavior does not move into `resources/`.
- Reusable UI does not move into Core or Module source.
- Contributor declarations remain under `Contrib/Navigation/`; ordinary routes, views, assets, or Providers do not.
- Root `app/Http`, `routes/`, `config/`, and database branches remain restricted.
- Test placement follows the smallest owner; root `tests/` is reserved for cross-owner, browser, system, and architecture proof.
- Exact internal UI-shell subpaths remain UI artifact authority and do not create a Goal 3 ownership ambiguity.

## 6. Prohibited Destinations

```text
app/Platform/
app/Surfaces/
Shared/
Common/
Helpers/
Utilities/
Services/
Managers/
Modules/Projects/src/Surface/
app/Core/Settings/Surface/
root feature Models, routes, config, or migrations
parallel unowned CSS or JavaScript trees
```

## 7. Findings

- Each representative example has one predictable owner root and naming family.
- `app/Core/Navigation/` resolves the remaining Host identity question from Phase 6.2.
- No generic ownership folder or unnecessary structural layer is required.
- UI-shell internal organization remains an artifact-level decision under the accepted UI owner, not a competing repository location.
- Current transitional files require later migration planning but do not create valid alternate targets.

## 8. Accepted Decision

> Settings, Projects, Modal, Dialog, Core Navigation, and Navigation Contributions each have one predictable target identity and location.
>
> Core Navigation uses `app/Core/Navigation/`, `App\Core\Navigation\`, and the `navigation` key family. Settings and Projects contribute through owner-local `Contrib/Navigation/`. Frame Surface remains a composition term and does not authorize a `Surface/` Technical Role.
>
> The accepted placement and naming model applies without a structural exception or new generic folder.

## 9. Phase 6.6 Handoff

Phase 6.6 must identify the smallest preimplementation proofs future refactor or implementation issues require before changing these owners or artifacts.

## 10. Related

- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md)
- [Phase 6.4 Dependency Direction Verification](6-4-dependency-direction-verification.md)
- [Phase 5 Naming Conventions Index](../phase-5/index.md)
- [Phase 4 Artifact Placement Matrix](../phase-4/artifact-placement-matrix.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
