# AGENTS.md

## Folder Purpose

This folder owns accepted and transitional **Module planning** within Login 2.0.

It may plan Module package/lifecycle work, implementation sequencing, dependencies, migration, compatibility, and unresolved Module-specific work. It does not own the accepted repository topology.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of a Module.

Module authority is split intentionally:

- [Module Definition](../Definitions/Modules/Definition.md) owns the canonical Module meaning and classification boundary.
- accepted ADRs own durable architectural decisions and rationale.
- [Repository Architecture](../../03-architecture/repository-architecture.md) owns the accepted target repository topology and structural placement model.
- canonical standards own durable package and implementation rules.
- this folder owns Module-specific planning intent that has not been promoted elsewhere.

## Ownership

This folder may contain:

- `README.md`
- `AGENTS.md`
- `Index.md`
- Module package and lifecycle planning
- Module dependency and extension planning
- Module implementation sequencing
- current-to-target Module mapping
- Module migration and compatibility planning
- unresolved Module planning questions
- supporting matrices or references with one clear Module planning responsibility

This folder must not contain:

- a competing Module definition
- accepted repository topology already owned by `docs/03-architecture/`
- required Core capability definitions
- reusable UI-system definitions
- generic delivery-Surface definitions
- Laravel integration rules that are not Module-specific
- source code, generated runtime evidence, or package artifacts
- individual feature truth owned by `docs/04-features/`
- duplicate copies of accepted decisions
- active issue queues, Project status, or chronological worklogs

If a requested change crosses this folder's ownership boundary, stop and identify the correct canonical owner before editing.

## Required Reading Before Editing

Before making changes in this folder, read:

1. `../../../AGENTS.md`
2. `../../AGENTS.md`
3. `../AGENTS.md`
4. `README.md`
5. [Module Definition](../Definitions/Modules/Definition.md)
6. [Repository Architecture](../../03-architecture/repository-architecture.md)
7. `Index.md`
8. only the specific supporting document required by the task

Required standards:

- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required decisions:

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)

Prefer targeted section reads over loading unrelated Module planning documents.

## Canonical Owners To Check

| Change Type | Canonical Owner |
| --- | --- |
| Module definition or ownership boundary | [Module Definition](../Definitions/Modules/Definition.md) and applicable ADRs |
| Accepted target repository topology and structural placement | [Repository Architecture](../../03-architecture/repository-architecture.md) |
| Repository naming rules | `docs/02-standards/coding/repository-naming-standards.md` |
| Individual Module behavior | `docs/04-features/` |
| Module execution path or workflow | `docs/05-flows/` |
| Module schema or data Contract | `docs/06-database/` |
| Module coding, packaging, or implementation convention | `docs/02-standards/` |
| Module implementation sequence, migration, compatibility, or unresolved planning | this folder |
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
- preserve accepted Module terminology unless the task explicitly changes it;
- keep ownership separate from package identity and physical placement;
- do not duplicate content already owned by the Module definition, Repository Architecture, a standard, feature, flow, database Contract, or runbook.

Folder-specific rules:

- the [Module Definition](../Definitions/Modules/Definition.md) is authoritative for the Module boundary;
- [Repository Architecture](../../03-architecture/repository-architecture.md) is authoritative for accepted target structural placement;
- `README.md` owns package purpose, reading order, and maintenance rules;
- `Index.md` owns routing and document status;
- `AGENTS.md` owns agent-facing routing and folder-specific working rules;
- additional files must own one distinct Module planning subject;
- do not add generic files such as `notes.md`, `misc.md`, or `shared.md`;
- do not recreate accepted Goal 03 architecture as parallel planning authority;
- do not convert this folder into an inventory of every current Module file;
- individual Module packages and their product documentation remain separate from this planning package.

## Documentation Rules

Documentation changes in this folder must:

- use portable Markdown links;
- keep parent and related links current;
- update `Index.md` when documents are added, moved, renamed, superseded, or removed;
- update `README.md` only when the package contract or reading order changes;
- update the [Module Definition](../Definitions/Modules/Definition.md) only when the Module boundary itself changes and that external file is explicitly in scope;
- link to accepted architecture and decisions instead of reproducing them;
- state whether remaining planning is proposed, accepted, transitional, compatibility-only, superseded, or implemented;
- identify the issue or later implementation/migration owner for unresolved executable work.

Do not create a document that competes with the Module definition, Repository Architecture, or another canonical owner.

## Module Boundary Guardrails

When reviewing or drafting Module planning:

- classify a Module by cohesive optional responsibility and independent lifecycle;
- require Core to remain operational when the Module is absent;
- treat independent Composer packaging as the mandatory target state;
- permit transitional implementation to be classified before package migration is complete;
- do not treat placement under `Modules/` as ownership proof;
- do not classify required Core behavior as a Module because it is package-shaped;
- do not permit Modules to redefine Core invariants;
- do not permit Modules to own reusable UI infrastructure;
- require cross-Module dependencies to be explicit, versioned, declared, validated, and Contract-based;
- prohibit access to another Module's internal implementation or private state;
- keep `module_key`, Composer identity, folder name, namespace, route prefix, and display name as distinct concepts;
- require every distinct responsibility to have one primary owner.

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
- links use the correct filename casing;
- mandatory target state and current transitional state are not conflated.

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

## Security And Data Rules

Modules may own business, administrative, integration, operational, or internal-tool behavior that affects sensitive data or privileged workflows.

When editing those subjects:

- do not allow a Module to bypass Core authorization, validation, audit, monitoring, governance, or data-protection rules;
- do not record secrets, tokens, cookies, MFA material, private keys, credentials, or sensitive runtime data;
- do not present proposed security or data behavior as implemented or accepted;
- preserve fail-closed access expectations unless an accepted standard explicitly states otherwise;
- require Module-owned persistence and data Contracts to identify their canonical database owner;
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

- the requested document does not have a clear Module planning owner;
- the change conflicts with the [Module Definition](../Definitions/Modules/Definition.md), [Repository Architecture](../../03-architecture/repository-architecture.md), or an accepted ADR;
- another document already owns the same subject;
- the change would introduce a competing Module definition or repository architecture;
- the proposed responsibility may actually be required Core behavior;
- the change would redefine Core, UI, Delivery Adapters, or Laravel integration without explicit scope;
- a cross-Module dependency lacks a public Contract or declared version relationship;
- physical placement is being used as the sole evidence of Module ownership;
- an accepted decision is being replaced without explicit repository-owner authority;
- the request attempts to reopen accepted Goal 03 topology without a new architecture decision;
- sensitive implementation or runtime data would be recorded;
- unrelated working-tree changes may be overwritten.

## Related

- [Root AGENTS](../../../AGENTS.md)
- [Docs AGENTS](../../AGENTS.md)
- [Planning AGENTS](../AGENTS.md)
- [Modules README](README.md)
- [Module Definition](../Definitions/Modules/Definition.md)
- [Modules Index](Index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Repository Naming Standards](../../02-standards/coding/repository-naming-standards.md)
- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
