<!--
DOC-META
title: Phase 3.1 Target Top-Level Branches
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-1-target-top-level-branches.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted permanent repository-root branches, bounded responsibility of each branch, generated roots, and prohibited generic roots.
-->

# Phase 3.1 Target Top-Level Branches

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the permanent repository-root branches and the bounded repository function owned by each.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Parent GitHub issue: #19
- Downstream consumer: Phase 4, Issue #51

## 3. Evidence Reviewed

The accepted current tree contains:

```text
.agents/
.docker/
.github/
app/
bootstrap/
config/
database/
docs/
Modules/
ops/
public/
resources/
routes/
scripts/
storage/
stubs/
tests/
```

The supporting-branch inventory confirmed distinct responsibilities:

- `.docker/` contains container image and initialization assets;
- `ops/` contains environment-deployable service and proxy configuration;
- `scripts/` contains repository automation, inventory tooling, validation, deployment orchestration, fixtures, and libraries;
- `stubs/` contains generator inputs for application archetypes, framework artifacts, tests, and UI bundles.

Current presence is evidence, not automatic acceptance of each child path or artifact.

## 4. Permanent Source And Repository-Control Branches

| Root branch  | Target responsibility                                                                                          |
| ------------ | -------------------------------------------------------------------------------------------------------------- |
| `.agents/`   | Repository-local agent skills, bounded execution guidance, noncanonical memory, and reusable agent support     |
| `.docker/`   | Docker image definitions, container initialization, and container-specific support                             |
| `.github/`   | GitHub workflows, templates, repository ownership metadata, and GitHub-specific automation                     |
| `app/`       | Base-application PHP source and bounded Laravel integration                                                    |
| `bootstrap/` | Laravel bootstrap source and required framework cache structure                                                |
| `config/`    | Root Laravel and base-application configuration                                                                |
| `database/`  | Base-application database source and support                                                                   |
| `docs/`      | Canonical repository documentation and defined noncanonical documentation branches                             |
| `Modules/`   | Optional, independently understandable, versioned, installable, and distributable Module packages              |
| `ops/`       | Deployment-target configuration, service definitions, infrastructure integration, and operational assets       |
| `public/`    | Public web root, front controller, and publishable public assets                                               |
| `resources/` | Base-application presentation source, assets, localization, and UI source                                      |
| `routes/`    | Application-wide route entry points, root registration, and bounded compatibility routes                       |
| `scripts/`   | Repository maintenance, validation, generation, collection, deployment orchestration, and developer automation |
| `stubs/`     | Canonical templates consumed by generators and scaffolding workflows                                           |
| `tests/`     | Cross-owner, application-wide, architecture, integration, browser, compatibility, and repository verification  |

## 5. Permanent Runtime-Support Branch

| Root branch | Target responsibility                                                                       |
| ----------- | ------------------------------------------------------------------------------------------- |
| `storage/`  | Laravel runtime state, logs, caches, temporary artifacts, and required tracked placeholders |

`storage/` is permanent infrastructure but is not a canonical source-code ownership branch.

## 6. Supporting-Branch Distinctions

```text
.docker/
→ container mechanics

ops/
→ machine-consumed environment and service configuration

scripts/
→ executable repository and deployment automation

stubs/
→ generator and scaffolding inputs
```

These branches remain separate because their consumers, lifecycle, review, and failure modes differ.

Human operational procedures remain in `docs/10-runbooks/`.

## 7. Acceptance Qualification

Acceptance of a root branch does not accept every current child path, file, name, or responsibility beneath it.

Examples:

- accepting `app/` does not accept `app/Platform/`, `app/Surfaces/`, or `app/Support/`;
- accepting `Modules/` does not confirm that current required Core responsibilities remain Modules;
- accepting `ops/` does not accept `platform-*` as final naming;
- accepting `scripts/` does not accept every existing script as permanent;
- accepting `stubs/` does not retain `Modules/_Template/` beneath the Module catalog.

## 8. Generated And Local Roots

The following may exist locally or during builds but are not canonical tracked repository branches:

```text
.git/
vendor/
node_modules/
coverage/
playwright-report/
test-results/
public/build/
```

Generated or dependency output must not be treated as a permanent architectural owner.

## 9. Prohibited Generic Root Branches

Do not introduce generic root ownership branches such as:

```text
Platform/
Surfaces/
Shared/
Common/
Helpers/
Utilities/
Services/
Features/
```

This prohibition applies when the name is used as a generic repository-root owner. It does not prohibit ordinary nonownership use of those words.

## 10. Transitional Root Result

No current repository-root directory requires transitional status.

Known transitional structures are children of accepted permanent roots and are classified through Decisions 3.2, 3.3, 3.7, and 3.8.

## 11. Accepted Decision

> Login 2.0 retains seventeen permanent repository-root directories: `.agents/`, `.docker/`, `.github/`, `app/`, `bootstrap/`, `config/`, `database/`, `docs/`, `Modules/`, `ops/`, `public/`, `resources/`, `routes/`, `scripts/`, `storage/`, `stubs/`, and `tests/`. Each branch owns one bounded repository function and does not create a peer application owner. Generated dependency, build, test-report, and runtime output directories are not canonical repository branches. Generic root ownership branches such as `Platform/`, `Surfaces/`, `Shared/`, `Common/`, `Helpers/`, and `Utilities/` are prohibited. Acceptance of a root branch does not accept every current child path, artifact, or name beneath it.

## 12. Boundaries And Handoff

Decision 3.1 does not decide:

- internal `app/` structure;
- Core capability names;
- Module catalog disposition;
- detailed supporting-branch artifact placement;
- final naming;
- physical migration.

Those decisions remain with later Phase 3 decisions, Phase 4, Phase 5, and migration work.

## 13. Related

- [Phase 3 Index](index.md)
- [Target `app/` Branches](3-2-target-app-branches.md)
- [Supporting Repository Branches](3-7-supporting-repository-branches.md)
- [Transitional And Prohibited Branches](3-8-transitional-and-prohibited-branches.md)
- Related GitHub issue: #50