<!--
DOC-META
title: Phase 4.5 Configuration Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-5-configuration-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-local configuration placement, root configuration boundaries, declarative registration, and runtime-setting separation.
-->

# Phase 4.5 Configuration Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where configuration belongs and how owner-specific configuration enters Laravel’s runtime configuration repository.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decision 4.4 registration model

## 3. Default Placement

| Configuration owner                                | Default placement                                                   |
| -------------------------------------------------- | ------------------------------------------------------------------- |
| Core capability                                    | Owner-local configuration branch beneath `app/Core/<Capability>/`   |
| Module                                             | `Modules/<Module>/config/`                                          |
| Reusable UI runtime                                | Owner-local configuration branch beneath `app/UI/<Responsibility>/` |
| Laravel framework and application-wide composition | Root `config/`                                                      |
| Shared infrastructure integration                  | Root `config/` only when genuinely application-wide                 |

Root `config/` must not become a generic location for owner-specific settings.

## 4. Registration

Each owner descriptor declares:

- configuration file paths;
- stable configuration namespace;
- defaults;
- publishability where applicable;
- required environment inputs;
- validation requirements;
- configuration dependencies.

The registration compiler validates missing files, duplicate keys, namespace conflicts, unknown dependencies, and stale output. Laravel remains responsible for the final runtime configuration repository and `config:cache`.

## 5. Configuration Versus Runtime Data

Laravel configuration contains deployment-level defaults and environment-backed application settings.

It is not the store for:

- Tenant settings;
- User preferences;
- editable operational state;
- database-backed feature configuration;
- committed secrets.

Runtime values remain owner-controlled data. Environment variables are read by configuration files; application code consumes configuration values rather than calling `env()` directly.

## 6. Accepted Decision

> Login 2.0 places configuration with the owner whose behavior it controls. Core capability configuration lives in an owner-local configuration branch beneath `app/Core/<Capability>/`; Module configuration lives beneath `Modules/<Module>/config/`; and reusable UI runtime configuration lives beneath the applicable `app/UI/<Responsibility>/` owner. Repository-root `config/` is restricted to Laravel framework configuration, application-wide composition, shared infrastructure integration, bootstrap requirements, and bounded compatibility concerns.
>
> Each registrable owner declares its configuration files, stable configuration namespace, defaults, required environment inputs, and registration requirements through its owner-controlled registration descriptor. The deterministic registration compiler validates paths, duplicate keys, namespace conflicts, dependencies, and required inputs before the root Laravel registrar merges the accepted configuration. Laravel remains responsible for the final runtime configuration repository and `config:cache`.
>
> Tenant settings, User preferences, editable operational state, and other runtime values remain owner-controlled data rather than Laravel configuration. Secrets must not be committed, and application code must consume configuration values instead of reading environment variables directly.

## 7. Boundaries And Handoff

Final configuration filenames, namespaces, keys, environment-variable names, and publication conventions remain Phase 5 authority.

## 8. Related

- [Route Placement And Registration](4-4-route-placement-and-registration.md)
- [Database And Migration Placement](4-6-database-and-migration-placement.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51
