# AGENTS.md

## Folder Purpose

This folder owns accepted and transitional **Core planning** within Login 2.0.

It may plan Core capability decomposition, implementation sequencing, migration, compatibility, and unresolved owner-specific work. It does not own the accepted repository topology.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of Core.

Core authority is split intentionally:

- [Core Definition](../Definitions/Core/Definition.md) owns the canonical Core meaning and classification boundary.
- accepted ADRs own durable architectural decisions and rationale.
- [Repository Architecture](../../03-architecture/repository-architecture.md) owns the accepted target repository topology and structural placement model.
- canonical standards own durable implementation rules.
- this folder owns Core-specific planning intent that has not been promoted elsewhere.

## Ownership

This folder may contain:

- `README.md`
- `AGENTS.md`
- `Index.md`
- Core capability planning
- Core implementation sequencing
- current-to-target Core mapping
- Core migration and compatibility planning
- unresolved Core planning questions
- supporting matrices or references with one clear Core planning responsibility

This folder must not contain:

- a competing Core definition
- accepted repository topology already owned by `docs/03-architecture/`
- optional Module definitions or Module-owned planning
- reusable UI-system definitions
- generic delivery-Surface definitions
- Laravel integration rules that are not specifically Core-owned
- source code, generated evidence, or runtime artifacts
- duplicate copies of accepted decisions
- active issue queues, Project status, or chronological worklogs

If a requested change crosses this folder's ownership boundary, stop and identify the correct canonical owner before editing.

## Required Reading Before Editing

Before making changes in this folder, read:

1. `../../../AGENTS.md`
2. `../../AGENTS.md`
3. `../AGENTS.md`
4. `README.md`
5. [Core Definition](../Definitions/Core/Definition.md)
6. [Repository Architecture](../../03-architecture/repository-architecture.md)
7. `Index.md`
8. only the specific supporting document required by the task

Required standards:

- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required decisions:

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)

Prefer targeted section reads over loading unrelated Core planning documents.

## Canonical Owners To Check

| Change Type | Canonical Owner |
| --- | --- |
| Core definition or ownership boundary | [Core Definition](../Definitions/Core/Definition.md) and applicable ADRs |
| Accepted target repository topology and structural placement | [Repository Architecture](../../03-architecture/repository-architecture.md) |
| Repository naming rules | `docs/02-standards/coding/repository-naming-standards.md` |
| Core capability behavior | `docs/04-features/` |
| Core execution path or workflow | `docs/05-flows/` |
| Core schema or data Contract | `docs/06-database/` |
| Coding or implementation convention | `docs/02-standards/` |
| Core implementation sequence, migration, compatibility, or unresolved planning | this folder |
| Operational procedure | `docs/10-runbooks/` |
| Agent workflow guidance | root/folder `AGENTS.md` and `.agents/skills/` |

Do not restate accepted repository architecture here when a link to the canonical architecture is sufficient.

## File And Shape Rules

When creating or modifying files in this folder:

- identify the document type before editing;
- use the applicable template from `docs/09-reference/templates/docs/`;
- preserve the `DOC-META` block;
- keep metadata, title, filename, canonical path, parent, and template aligned;
- keep changes narrow and scoped to the current issue or planning concern;
- distinguish accepted canonical architecture from remaining planning and migration state;
- preserve accepted Core terminology unless the task explicitly changes it;
- do not treat current physical placement as proof of Core ownership;
- do not duplicate content already owned by the Core definition, Repository Architecture, a standard, feature, flow, database Contract, or runbook.

Folder-specific rules:

- the [Core Definition](../Definitions/Core/Definition.md) is authoritative for the Core boundary;
- [Repository Architecture](../../03-architecture/repository-architecture.md) is authoritative for accepted target structural placement;
- `README.md` owns package purpose, reading order, and maintenance rules;
- `Index.md` owns routing and document status;
- `AGENTS.md` owns agent-facing routing and folder-specific working rules;
- additional files must own one distinct Core planning subject;
- do not add generic files such as `notes.md`, `misc.md`, or `shared.md`;
- do not recreate accepted Goal 03 architecture as parallel planning authority;
- do not convert this folder into a complete repository inventory or implementation history.

## Documentation Rules

Documentation changes in this folder must:

- use portable Markdown links;
- keep parent and related links current;
- update `Index.md` when documents are added, moved, renamed, superseded, or removed;
- update `README.md` only when the package contract or reading order changes;
- update the [Core Definition](../Definitions/Core/Definition.md) only when the Core boundary itself changes and that external file is explicitly in scope;
- link to accepted architecture and decisions instead of reproducing them;
- state whether remaining planning is proposed, accepted, transitional, compatibility-only, superseded, or implemented;
- identify the issue or later implementation/migration owner for unresolved executable work.

Do not create a document that competes with the Core definition, Repository Architecture, or another canonical owner.

## Core Boundary Guardrails

When reviewing or drafting Core planning:

- classify Core by architectural necessity and authoritative responsibility;
- require Core to operate when no optional Modules are installed;
- keep Core independent of optional Module implementation and internal state;
- do not classify a responsibility as Core solely because it is shared;
- do not place reusable UI infrastructure under Core ownership;
- do not place Module-specific behavior, records, workflows, or extensions under Core ownership;
- keep Core business and system logic independent of Blade, CSS, JavaScript, and reusable UI implementation Contracts;
- keep ownership separate from package shape, namespace, folder, route, and current implementation location;
- treat `app/Platform/`, `app/Surfaces/`, and other non-target branches according to accepted Repository Architecture and migration planning rather than as peer owners.

A proposal that changes an accepted repository-wide boundary requires explicit architecture authority rather than a local planning edit.

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually that:

- `DOC-META` paths and parent links are correct;
- `Index.md` routes all current documents;
- no document duplicates another document's ownership;
- accepted architecture and remaining planning are clearly separated;
- accepted decisions and open questions remain separate;
- links use the correct filename casing.

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

## Security And Data Rules

Core planning may address authentication, access, security, audit, monitoring, privacy, persistence, and operational responsibilities.

When editing those subjects:

- do not weaken authorization, validation, audit, monitoring, or data-protection boundaries;
- do not record secrets, tokens, cookies, MFA material, private keys, credentials, or sensitive runtime data;
- do not present proposed security behavior as implemented or accepted;
- preserve fail-closed access expectations unless an accepted standard explicitly states otherwise;
- route detailed schema, security, privacy, testing, and operational Contracts to their canonical owners.

## Git And Scope Rules

Before editing:

- confirm the active issue or authorized task;
- confirm the intended branch and worktree for writable work;
- inspect for unrelated changes when practical;
- avoid overwriting another writer's work;
- stage explicit files only when staging is authorized;
- do not use `git add .` in a dirty worktree.

When reporting work, include:

- files changed;
- planning rules changed;
- indexes or related docs updated;
- verification run;
- unresolved questions or required review.

## Stop Conditions

Stop and report before editing when:

- the requested document does not have a clear Core planning owner;
- the change conflicts with the [Core Definition](../Definitions/Core/Definition.md), [Repository Architecture](../../03-architecture/repository-architecture.md), or an accepted ADR;
- another document already owns the same subject;
- the change would introduce a competing Core definition or repository architecture;
- the change would redefine Modules, UI, Delivery Adapters, or Laravel integration without explicit scope;
- current physical placement is being treated as target ownership;
- an accepted decision is being replaced without explicit repository-owner authority;
- the request attempts to reopen accepted Goal 03 topology without a new architecture decision;
- sensitive implementation or runtime data would be recorded;
- unrelated working-tree changes may be overwritten.

## Related

- [Root AGENTS](../../../AGENTS.md)
- [Docs AGENTS](../../AGENTS.md)
- [Planning AGENTS](../AGENTS.md)
- [Core README](README.md)
- [Core Definition](../Definitions/Core/Definition.md)
- [Core Index](Index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Repository Naming Standards](../../02-standards/coding/repository-naming-standards.md)
- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
