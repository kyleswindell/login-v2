# AGENTS.md

## Folder Purpose

This folder owns accepted and transitional **reusable UI planning** within Login 2.0.

It may plan reusable UI implementation sequencing, migration, compatibility, review preparation, and unresolved UI-specific work. It does not own the accepted repository topology or final UI standards.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of UI.

UI authority is split intentionally:

- [UI Definition](../Definitions/UI/Definition.md) owns the canonical UI meaning and classification boundary.
- accepted ADRs own durable architectural decisions and rationale.
- [Repository Architecture](../../03-architecture/repository-architecture.md) owns the accepted target repository topology and structural placement model.
- `docs/02-standards/ui/` owns durable reusable UI API and implementation standards.
- this folder owns UI-specific planning intent that has not been promoted elsewhere.

## Ownership

This folder may contain:

- `README.md`
- `AGENTS.md`
- `Index.md`
- Element, Component, Pattern, and Layout planning
- design-token and icon planning
- reusable CSS and JavaScript-control planning
- UI migration and compatibility planning
- implementation sequencing and review preparation
- unresolved UI planning questions
- supporting matrices or references with one clear UI planning responsibility

This folder must not contain:

- a competing UI definition
- accepted repository topology already owned by `docs/03-architecture/`
- final reusable UI standards already owned by `docs/02-standards/ui/`
- routed Core or Module feature definitions
- authorization, persistence, or domain behavior
- generic delivery-Surface definitions
- source code or generated runtime artifacts
- duplicate copies of accepted decisions
- active issue queues, Project status, or chronological worklogs

If a requested change crosses this folder's ownership boundary, stop and identify the correct canonical owner before editing.

## Required Reading Before Editing

Before making changes in this folder, read:

1. `../../../AGENTS.md`
2. `../../AGENTS.md`
3. `../AGENTS.md`
4. `README.md`
5. [UI Definition](../Definitions/UI/Definition.md)
6. [Repository Architecture](../../03-architecture/repository-architecture.md)
7. `Index.md`
8. only the specific supporting document required by the task

Required standards:

- [UI Standards Index](../../02-standards/ui/index.md)
- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required decisions:

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)

Prefer targeted section reads over loading unrelated UI planning documents.

## Canonical Owners To Check

| Change Type | Canonical Owner |
| --- | --- |
| UI definition or ownership boundary | [UI Definition](../Definitions/UI/Definition.md) and applicable ADRs |
| Accepted target repository topology and structural placement | [Repository Architecture](../../03-architecture/repository-architecture.md) |
| Reusable UI API and implementation standards | `docs/02-standards/ui/` |
| General coding and test-source implementation rules | `docs/02-standards/coding/` |
| Core or Module feature behavior | `docs/04-features/` |
| UI or cross-owner interaction flow | `docs/05-flows/` |
| UI implementation sequence, migration, compatibility, or unresolved planning | this folder |
| Verification and specialist UI testing policy | `docs/02-standards/testing/ui-and-accessibility/` |
| Agent workflow guidance | root/folder `AGENTS.md` and `.agents/skills/` |

Do not restate accepted repository architecture or final UI standards here when links to their canonical owners are sufficient.

## File And Shape Rules

When creating or modifying files in this folder:

- identify the document type before editing;
- use the applicable template from `docs/09-reference/templates/docs/`;
- preserve the `DOC-META` block;
- keep metadata, title, filename, canonical path, parent, and template aligned;
- keep changes narrow and scoped to the current issue or planning concern;
- distinguish accepted canonical architecture and standards from remaining planning and migration state;
- preserve accepted UI terminology unless the task explicitly changes it;
- keep ownership separate from physical placement and file type;
- do not duplicate content already owned by the UI definition, Repository Architecture, UI standards, a feature, flow, or testing standard.

Folder-specific rules:

- the [UI Definition](../Definitions/UI/Definition.md) is authoritative for the reusable UI boundary;
- [Repository Architecture](../../03-architecture/repository-architecture.md) is authoritative for accepted target structural placement;
- [UI Standards](../../02-standards/ui/index.md) own durable reusable UI API requirements;
- `README.md` owns package purpose, reading order, and maintenance rules;
- `Index.md` owns routing and document status;
- `AGENTS.md` owns agent-facing routing and folder-specific working rules;
- additional files must own one distinct UI planning subject;
- do not add generic files such as `notes.md`, `misc.md`, or `shared.md`;
- do not recreate accepted Goal 03 architecture or promoted UI standards as parallel planning authority;
- do not convert this folder into a complete UI implementation inventory.

## UI Boundary Guardrails

When reviewing or drafting UI planning:

- classify UI by reusable presentation responsibility;
- do not use Blade, CSS, JavaScript, or `resources/` placement as ownership proof;
- keep routed, stateful, authorized, and capability-specific presentation with Core or the applicable Module;
- prohibit database access, domain queries, mutations, and authorization decisions in reusable UI Contracts;
- require UI to render from data and decisions supplied by its consumer;
- keep UI independent of Core and Module implementation;
- permit Core presentation and Modules to depend on public UI Contracts;
- keep navigation data, contribution aggregation, active-state resolution, and authorization filtering under Core ownership;
- keep reusable layout rendering and interface infrastructure presentation-only;
- require every distinct responsibility to have one primary owner.

A proposal that changes an accepted repository-wide boundary requires explicit architecture authority rather than a local planning edit.

## Documentation Rules

Documentation changes in this folder must:

- use portable Markdown links;
- keep parent and related links current;
- update `Index.md` when documents are added, moved, renamed, superseded, or removed;
- update `README.md` only when the package contract or reading order changes;
- update the [UI Definition](../Definitions/UI/Definition.md) only when the UI boundary itself changes and that external file is explicitly in scope;
- link to accepted architecture, decisions, and standards instead of reproducing them;
- distinguish reusable UI planning from Core- or Module-specific feature implementation;
- state whether remaining planning is proposed, accepted, transitional, compatibility-only, superseded, or implemented;
- identify the issue or later implementation/migration owner for unresolved executable work.

Do not create a document that competes with the UI definition, Repository Architecture, UI standards, or another canonical owner.

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
- accepted architecture/standards and remaining planning are clearly separated;
- accepted decisions and open questions remain separate;
- links use the correct filename casing;
- reusable UI and capability-owned presentation remain clearly separated.

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

## UI And Visual Review Rules

- Codex is not the primary visual design authority.
- Do not redesign layout, spacing, hierarchy, color, typography, or interaction behavior without explicit direction.
- Preserve accepted Component and Pattern Contracts unless the task explicitly changes them.
- Manual visual review remains required when the verification contract declares design-sensitive review.
- Documentation must distinguish automated Contract verification from manual visual acceptance.
- Do not present generated examples or screenshots as accepted visual truth without the required review authority.

## Security And Data Rules

UI planning may affect authentication, authorization, administrative workflows, sensitive data display, and user interaction.

When editing those subjects:

- do not move authorization decisions into UI Components or Patterns;
- do not expose secrets, tokens, cookies, MFA material, private keys, or sensitive personal data;
- do not allow presentation state to substitute for server-side enforcement;
- preserve fail-closed access behavior;
- route security, privacy, data, audit, and testing Contracts to their canonical owners.

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
- manual visual review requirements;
- unresolved questions or required review.

## Stop Conditions

Stop and report before editing when:

- the requested document does not have a clear UI planning owner;
- the change conflicts with the [UI Definition](../Definitions/UI/Definition.md), [Repository Architecture](../../03-architecture/repository-architecture.md), [UI Standards](../../02-standards/ui/index.md), or an accepted ADR;
- another document already owns the same subject;
- the change would introduce a competing UI definition, repository architecture, or final UI standard;
- the proposed responsibility may actually be Core- or Module-owned presentation;
- authorization, persistence, domain behavior, or lifecycle logic is being assigned to reusable UI;
- physical placement or file type is being used as the sole evidence of UI ownership;
- the change requires unspecified visual design judgment;
- an accepted decision is being replaced without explicit repository-owner authority;
- the request attempts to reopen accepted Goal 03 topology without a new architecture decision;
- sensitive implementation or runtime data would be recorded;
- unrelated working-tree changes may be overwritten.

## Related

- [Root AGENTS](../../../AGENTS.md)
- [Docs AGENTS](../../AGENTS.md)
- [Planning AGENTS](../AGENTS.md)
- [UI README](README.md)
- [UI Definition](../Definitions/UI/Definition.md)
- [UI Index](Index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [UI Standards Index](../../02-standards/ui/index.md)
- [UI And Accessibility Testing Standards Index](../../02-standards/testing/ui-and-accessibility/index.md)
- [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
- [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
