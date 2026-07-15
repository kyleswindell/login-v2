# AGENTS.md

## Folder Purpose

This folder owns temporary Goal 03 planning for Surfaces whose permanent documentation and repository locations have not yet been accepted.

Use this file to guide Codex and other AI agents working inside this temporary folder.

This file is routing guidance. It is not the canonical Surface definition.

Canonical Surface truth remains in:

* `../../Definitions/Surfaces/Definition.md`

---

## Ownership

This folder may contain:

* `README.md`
* `Index.md`
* temporary Surface architecture planning
* Surface placement and dependency planning
* Surface naming planning
* representative Surface mappings
* Surface migration and compatibility planning

This folder must not contain:

* the canonical Surface definition
* Core, Module, or UI definitions
* implementation code
* generated runtime evidence
* permanent architecture after its target owner is accepted
* unrelated notes or drafts
* active issue queues or Project status

Every document in this folder must have a clear Goal 03 purpose and a defined promotion, supersession, or removal path.

---

## Required Reading Before Editing

Before making changes in this folder, read:

1. `../../../../AGENTS.md`
2. `../../../AGENTS.md`
3. `../../AGENTS.md`
4. `README.md`
5. `Index.md`
6. `../../Definitions/Surfaces/Definition.md`
7. only the specific supporting document required by the task

Required standards:

* [How To Write Docs](../../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../../02-standards/documentation/Doc%20Governance.md)
* [Implementation Status And Development Sync Standard](../../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required architecture sources:

* [Surface Definition](../../Definitions/Surfaces/Definition.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0006: Tenant, Instance, Workspace, Principal, And Invocation Vocabulary](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)

Prefer targeted section reads over loading unrelated planning documents.

---

## Canonical Owners To Check

| Change Type                     | Canonical Owner                                                     |
| ------------------------------- | ------------------------------------------------------------------- |
| Surface definition              | `docs/07-planning/Definitions/Surfaces/Definition.md`               |
| Core ownership                  | `docs/07-planning/Core/Definition.md`                               |
| Module ownership                | `docs/07-planning/Modules/Definition.md`                            |
| UI ownership                    | `docs/07-planning/UI/Definition.md`                                 |
| Goal 03 coordination            | `docs/07-planning/00-overview/m0-target-repository-architecture.md` |
| Accepted permanent architecture | `docs/03-architecture/` after promotion                             |
| Implementation convention       | `docs/02-standards/`                                                |
| Temporary Surface planning      | this folder                                                         |

Do not leave durable accepted architecture only under `temp/`.

---

## File And Shape Rules

When creating or modifying files in this folder:

* identify the document type before editing
* use the applicable template from `docs/09-reference/templates/docs/`
* preserve `DOC-META`
* mark documents as non-canonical unless explicitly promoted
* keep metadata, title, path, parent, and status aligned
* keep changes narrow and scoped to Goal 03
* identify the permanent promotion or removal target
* do not duplicate the Surface definition
* do not treat current physical placement as accepted architecture

Folder-specific rules:

* `README.md` owns temporary-package purpose and promotion requirements.
* `Index.md` owns routing and current document status.
* Additional files must own one distinct unresolved Surface-planning subject.
* Do not create subfolders without explicit approval.
* Do not add generic files such as `notes.md`, `misc.md`, or `draft.md`.
* Do not allow temporary documents to become permanent by neglect.

---

## Surface Boundary Guardrails

When drafting Surface planning:

* treat a Surface as an owner-specific UI presentation and interaction layer
* do not treat a Surface as a fourth source-of-truth owner
* preserve Core and Module ownership of behavior and state
* preserve UI ownership of reusable presentation infrastructure
* do not classify APIs, console commands, webhooks, queues, schedulers, or background entry points as Surfaces; they are Delivery Adapters or invocation channels
* keep Host-owned Registry discovery, validation, ordering, and resolution separate from Surface presentation
* allow a Surface to present resolved Contributions from multiple owners without taking ownership of those Contributions
* require each underlying responsibility to retain one primary owner
* do not move business logic into Delivery Adapters or Surface presentation code
* do not assume that every Surface needs a centralized repository folder

A proposal that contradicts the canonical Surface definition requires explicit architecture review.

---

## Documentation Rules

Documentation changes in this folder must:

* use portable Markdown links
* keep parent and related links current
* update `Index.md` when documents are added, moved, promoted, superseded, or removed
* link to the canonical Surface definition instead of reproducing it
* clearly separate accepted rules from unresolved proposals
* name the later Goal 03 phase that owns each unresolved question
* identify the permanent documentation owner before promotion
* remove stale temporary content after promotion

---

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually that:

* `DOC-META` paths and parent links are correct
* all links use the correct filename casing
* temporary documents are marked non-canonical
* no document duplicates the Surface definition
* accepted and proposed rules remain separate
* every temporary document has a promotion or removal path

Do not claim verification passed unless the commands were run successfully.

---

## Git And Scope Rules

Before editing:

* confirm the active Goal 03 branch and issue scope
* inspect for unrelated changes when practical
* avoid overwriting another writer’s work
* stage explicit files only
* do not use `git add .` in a dirty worktree

When reporting work, include:

* files changed
* proposed or accepted rules changed
* indexes updated
* verification run
* promotion or removal targets
* unresolved questions

---

## Stop Conditions

Stop and report before editing when:

* the work does not have a clear Surface-planning purpose
* the proposed content belongs directly in the canonical Surface definition
* the proposed content already has a permanent owner
* the proposal treats Surface as an ownership area
* behavior ownership between Core and a Module is unclear
* reusable UI and capability-specific presentation are being conflated
* physical placement is being accepted prematurely
* a new subfolder is requested without approval
* durable accepted content would remain under `temp/`
* unrelated working-tree changes may be overwritten

---

## Related

* [Root AGENTS](../../../../AGENTS.md)
* [Docs AGENTS](../../../AGENTS.md)
* [Planning AGENTS](../../AGENTS.md)
* [Temporary Surfaces README](README.md)
* [Temporary Surfaces Index](Index.md)
* [Surface Definition](../../Definitions/Surfaces/Definition.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
