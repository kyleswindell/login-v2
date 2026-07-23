# AGENTS.md

## Folder Purpose

This folder owns the architecture and planning documentation for Core within Login 2.0.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of Core.

The canonical Core definition is external to this package. Core truth remains in:

* [Core Definition](../Definitions/Core/Definition.md)
* accepted architecture decisions
* later canonical architecture and standards documents

---

## Ownership

This folder may contain:

* the Core documentation package files:

  * `README.md`
  * `AGENTS.md`
  * `Index.md`
* Core-specific architecture and planning documents
* Core capability planning
* Core contract, placement, dependency, naming, and migration planning
* supporting matrices or references that have a clear Core owner

This folder must not contain:

* optional Module definitions or Module-owned planning
* reusable UI-system definitions
* generic delivery-Surface definitions
* Laravel integration rules that are not specifically Core-owned
* source code, generated evidence, or runtime artifacts
* duplicate copies of accepted decisions owned elsewhere
* active issue queues, Project status, or chronological worklogs

If a requested change crosses this folder’s ownership boundary, stop and identify the correct documentation owner before editing.

---

## Required Reading Before Editing

Before making changes in this folder, read:

1. `../../../AGENTS.md`
2. `../../AGENTS.md`
3. `../AGENTS.md`
4. `README.md`
5. [Core Definition](../Definitions/Core/Definition.md)
6. `Index.md`
7. only the specific supporting document required by the task

Required standards:

* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required architecture sources:

* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)

Prefer targeted section reads over loading unrelated Core planning documents.

---

## Canonical Owners To Check

| Change Type                               | Canonical Owner                                                                                                   |
| ----------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Core definition or ownership boundary     | [Core Definition](../Definitions/Core/Definition.md) and applicable files under `docs/01-decisions/`             |
| Target repository architecture            | `docs/07-planning/00-overview/m0-target-repository-architecture.md` during Goal 03; later `docs/03-architecture/` |
| Core capability behavior                  | `docs/04-features/`                                                                                               |
| Core execution path or workflow           | `docs/05-flows/`                                                                                                  |
| Core schema or data contract              | `docs/06-database/`                                                                                               |
| Coding or implementation convention       | `docs/02-standards/`                                                                                              |
| Core implementation or migration planning | this folder                                                                                                       |
| Operational procedure                     | `docs/10-runbooks/`                                                                                               |
| Agent workflow guidance                   | root/folder `AGENTS.md`, `.agents/skills/`, or `docs/11-ai/`                                                      |

Do not leave durable cross-cutting truth only in this `AGENTS.md` file.

---

## File And Shape Rules

When creating or modifying files in this folder:

* identify the document type before editing
* use the applicable template from `docs/09-reference/templates/docs/`
* preserve the `DOC-META` block
* keep metadata, title, filename, canonical path, parent, and template aligned
* keep changes narrow and scoped to the current issue or phase
* distinguish accepted target rules from current implementation and migration state
* preserve accepted Core terminology unless the task explicitly changes it
* do not treat current physical placement as proof of Core ownership
* do not duplicate content already owned by another Core document

Folder-specific rules:

* The [Core Definition](../Definitions/Core/Definition.md) is external to this package and authoritative for the Core boundary.
* `README.md` owns package purpose, reading order, and maintenance rules.
* `Index.md` owns routing and document status.
* `AGENTS.md` owns agent-facing routing and folder-specific working rules.
* Additional files must own one distinct Core subject.
* Keep the folder flat unless a later accepted architecture decision authorizes subfolders.
* Do not add generic files such as `notes.md`, `misc.md`, or `shared.md`.
* Do not convert this folder into a complete repository inventory or implementation history.

---

## Documentation Rules

Documentation changes in this folder must:

* use portable Markdown links
* keep parent and related links current
* update `Index.md` when documents are added, moved, renamed, superseded, or removed
* update `README.md` only when the package contract or reading order changes
* update the central [Core Definition](../Definitions/Core/Definition.md) only when the Core boundary itself changes and that external file is in scope
* link to accepted decisions instead of reproducing their full contents
* state whether a rule is proposed, accepted, transitional, compatibility-only, or superseded
* identify the later owner for unresolved placement, naming, migration, implementation, or verification work

Do not create a document that competes with the central Core definition or an existing Core package document for the same responsibility.

---

## Core Boundary Guardrails

When reviewing or drafting Core documentation:

* classify Core by architectural necessity and authoritative responsibility
* require Core to operate when no optional Modules are installed
* keep Core independent of optional Module implementation and internal state
* do not classify a responsibility as Core solely because it is shared
* do not place reusable UI infrastructure under Core ownership
* do not place Module-specific behavior, records, workflows, or extensions under Core ownership
* keep Core business and system logic independent of Blade, CSS, JavaScript, and UI implementation contracts
* keep ownership separate from package shape, namespace, folder, route, and current implementation location

A proposed document that contradicts these rules requires explicit architecture review before editing proceeds.

---

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually that:

* `DOC-META` paths and parent links are correct
* `Index.md` routes all current documents
* no document duplicates another document’s ownership
* accepted decisions and open questions remain separate
* links use the correct filename casing

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

---

## Security And Data Rules

Core documentation may define authentication, access, security, audit, monitoring, privacy, persistence, and operational responsibilities.

When editing those subjects:

* do not weaken authorization, validation, audit, monitoring, or data-protection boundaries
* do not record secrets, tokens, cookies, MFA material, private keys, credentials, or sensitive runtime data
* do not present proposed security behavior as implemented or accepted
* preserve fail-closed access expectations unless an accepted standard explicitly states otherwise
* route detailed schema, security, privacy, and operational contracts to their canonical owners

---

## Git And Scope Rules

Before editing:

* confirm the active branch and task scope
* inspect for unrelated changes when practical
* avoid overwriting another writer’s work
* stage explicit files only
* do not use `git add .` in a dirty worktree

When reporting work, include:

* files changed
* definitions or planning rules changed
* indexes or related docs updated
* verification run
* unresolved questions or required review

---

## Stop Conditions

Stop and report before editing when:

* the requested document does not have a clear Core owner
* the change conflicts with the [Core Definition](../Definitions/Core/Definition.md) or an accepted ADR
* another document already owns the same subject
* the change would introduce a competing Core definition inside this package
* the change would redefine Modules, UI, Delivery Adapters, or Laravel integration without explicit scope
* the change would treat current physical placement as target ownership
* an accepted decision is being replaced without explicit repository-owner authority
* a new subfolder is required but has not been architecturally approved
* sensitive implementation or runtime data would be recorded
* unrelated working-tree changes may be overwritten

---

## Related

* [Root AGENTS](../../../AGENTS.md)
* [Docs AGENTS](../../AGENTS.md)
* [Planning AGENTS](../AGENTS.md)
* [Core README](README.md)
* [Core Definition](../Definitions/Core/Definition.md)
* [Core Index](Index.md)
* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
