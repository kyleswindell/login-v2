<!--
DOC-META
title: Phase 3.7 Supporting Repository Branches
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-7-supporting-repository-branches.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the bounded permanent responsibilities of database, tests, config, routes, docs, agents, stubs, scripts, and operations.
-->

# Phase 3.7 Supporting Repository Branches

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the permanent role and limits of supporting repository branches.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: Decisions 3.1 and 3.9

## 3. Supporting Branch Principle

Supporting branches describe repository function. They do not create application ownership.

Every supported artifact retains an explicit Core, Module, UI, Laravel integration, documentation, operations, or verification owner.

## 4. Branch Responsibilities

| Branch      | Permanent responsibility                                                                                                 | Must not become                                                                    |
| ----------- | ------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------- |
| `database/` | Base-application Laravel database integration, ordering, bootstrap, and genuinely cross-owner database support           | Default owner of all persistence or Module database artifacts                      |
| `tests/`    | Cross-owner, system, browser, architecture, compatibility, repository, and shared test infrastructure                    | Default location for every owner-specific test                                     |
| `config/`   | Root framework, base-application, composition, and bounded compatibility configuration                                   | Replacement for owner-specific settings or Module configuration                    |
| `routes/`   | Root route entrypoints, registration, bootstrapping, global infrastructure routes, and compatibility routes              | Default location for all owner-specific routes or behavior                         |
| `docs/`     | Canonical repository documentation system                                                                                | Task board, implementation diary, or duplicate application owner                   |
| `.agents/`  | Agent skills, workflow playbooks, bounded memory, and noncanonical support                                               | Canonical architecture, product, feature, database, or standards authority         |
| `stubs/`    | Canonical generator and scaffolding inputs                                                                               | Generic examples, production copies, or universal empty skeletons                  |
| `scripts/`  | Executable repository validation, generation, inventory, maintenance, deployment orchestration, and developer automation | Application runtime behavior or generic scratch work                               |
| `ops/`      | Machine-consumed deployment, service, proxy, infrastructure, monitoring, and environment configuration                   | Human procedures, secrets, application behavior, or repository-maintenance scripts |

## 5. `database/`

Module-owned database artifacts remain package-local:

```text
Modules/<Module>/database/
```

Whether Core capability migrations, factories, and seeders remain root-integrated or become owner-local is Phase 4 authority.

## 6. `tests/`

Root `tests/` is narrowed under Decision 3.9:

```text
tests/
├── Architecture/
├── Integration/
├── System/
├── Browser/
├── Compatibility/
├── Repository/
├── Support/
└── TestCase.php
```

Owner-local tests remain with Core capabilities, UI responsibilities, UI artifacts, Modules, or bounded Laravel integration.

## 7. `config/`

Module configuration remains package-local:

```text
Modules/<Module>/config/
```

Core capability configuration remains owner-controlled even when Laravel requires root publication or composition.

Exact placement and registration remain Phase 4 authority.

## 8. `routes/`

Owner-specific route behavior remains with its owner.

Examples:

```text
app/Core/<Capability>/Http/
Modules/<Module>/routes/
```

Root route files may compose owner routes but must not absorb owner behavior.

Core route-file placement remains Phase 4 authority.

## 9. `docs/`

Root documentation branches retain their established responsibilities:

```text
docs/01-decisions/
docs/02-standards/
docs/03-architecture/
docs/04-features/
docs/05-flows/
docs/06-database/
docs/07-planning/
docs/09-reference/
docs/10-runbooks/
docs/11-ai/
```

Module package documentation may remain package-local, but repository-wide canonical truth remains under root `docs/`.

## 10. `.agents/`

`.agents/` routes agents to canonical documentation rather than duplicating it.

Persistent execution guidance may live in `AGENTS.md` or `.agents/skills/`, while underlying durable truth remains in `docs/`.

## 11. `stubs/`

Recommended target categories include:

```text
stubs/
├── archetypes/
├── framework/
├── modules/
├── tests/
└── ui/
```

`Modules/_Template/` moves into generator-owned structure beneath this branch.

Templates generate only required or explicitly selected roles.

## 12. `scripts/`

Scripts must:

- discover the active repository root;
- avoid workstation-specific paths;
- remain deterministic and reviewable;
- document nontrivial behavior;
- keep fixtures and internal libraries scoped to the owning script system.

`scripts/notes.md` requires later classification but does not change the branch’s target status.

## 13. `ops/`

Current examples include staging proxy and service definitions.

The permanent separation is:

```text
scripts/
→ executable repository and deployment orchestration

ops/
→ machine-consumed environment and service configuration

docs/10-runbooks/
→ human-executed operational and recovery procedures
```

Current `platform-*` operational filenames are transitional naming evidence.

## 14. No Ownership Bypass

Invalid examples include:

```text
scripts/UserService.php
config/audit-business-rules.php
routes/settings-domain-logic.php
database/Models/User.php
ops/NotificationDispatcher.php
stubs/current-production-copy/
```

when the actual responsibility has a more precise owner.

## 15. No Additional Generic Supporting Roots

Do not add generic root branches such as:

```text
tools/
support/
infrastructure/
deployment/
templates/
utilities/
shared/
```

when their responsibility belongs to an accepted root.

A new root requires a distinct permanent repository responsibility and repository-owner acceptance.

## 16. Accepted Decision

> Login 2.0 retains `database/`, `tests/`, `config/`, `routes/`, `docs/`, `.agents/`, `stubs/`, `scripts/`, and `ops/` as permanent supporting repository branches. Each branch has one bounded repository responsibility and supports explicit Core, Module, UI, or Laravel integration owners without becoming an application owner itself. Root `tests/` is limited to cross-owner, system, browser, architecture, compatibility, repository, and shared test infrastructure under the accepted hybrid test-location model. Root `config/`, `routes/`, and `database/` provide base-application and Laravel integration rather than absorbing owner-specific responsibility. `docs/` remains canonical documentation authority, `.agents/` remains noncanonical execution guidance, `stubs/` owns generator inputs, `scripts/` owns executable repository automation, and `ops/` owns machine-consumed operational assets. Human operational procedures remain in `docs/10-runbooks/`, and no additional generic support root is introduced without a separately accepted repository responsibility.

## 17. Related

- [Phase 3 Index](index.md)
- [Target Top-Level Branches](3-1-target-top-level-branches.md)
- [Transitional And Prohibited Branches](3-8-transitional-and-prohibited-branches.md)
- [Test Folder Locations](3-9-test-folder-locations.md)
- Related GitHub issue: #50