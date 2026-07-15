# AGENTS.md

## Folder Purpose

This folder owns the architecture and planning documentation for Modules within Login 2.0.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of a Module.

The canonical Module definition is external to this package. Module truth remains in:

* [Module Definition](../Definitions/Modules/Definition.md)
* accepted architecture decisions
* later canonical architecture and standards documents

---

## Ownership

This folder may contain:

* the Modules documentation package files:

  * `README.md`
  * `AGENTS.md`
  * `Index.md`
* Module architecture and planning documents
* Module package and lifecycle planning
* Module dependency and extension planning
* Module placement, naming, implementation, and migration planning
* supporting matrices or references with a clear Module architecture owner

This folder must not contain:

* required Core capability definitions
* reusable UI-system definitions
* generic delivery-Surface definitions
* Laravel integration rules that are not Module-specific
* source code, generated runtime evidence, or package artifacts
* individual feature truth owned by `docs/04-features/`
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
5. [Module Definition](../Definitions/Modules/Definition.md)
6. `Index.md`
7. only the specific supporting document required by the task

Required standards:

* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required architecture sources:

* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)

Prefer targeted section reads over loading unrelated Module planning documents.

---

## Canonical Owners To Check

| Change Type                                 | Canonical Owner                                                                                                   |
| ------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Module definition or ownership boundary     | [Module Definition](../Definitions/Modules/Definition.md) and applicable files under `docs/01-decisions/`         |
| Target repository architecture              | `docs/07-planning/00-overview/m0-target-repository-architecture.md` during Goal 03; later `docs/03-architecture/` |
| Individual Module behavior                  | `docs/04-features/`                                                                                               |
| Module execution path or workflow           | `docs/05-flows/`                                                                                                  |
| Module schema or data contract              | `docs/06-database/`                                                                                               |
| Module coding or package convention         | `docs/02-standards/`                                                                                              |
| Module implementation or migration planning | this folder                                                                                                       |
| Operational procedure                       | `docs/10-runbooks/`                                                                                               |
| Agent workflow guidance                     | root/folder `AGENTS.md`, `.agents/skills/`, or `docs/11-ai/`                                                      |

Do not leave durable cross-cutting truth only in this `AGENTS.md` file.

---

## File And Shape Rules

When creating or modifying files in this folder:

* identify the document type before editing
* use the applicable template from `docs/09-reference/templates/docs/`
* preserve the `DOC-META` block
* keep metadata, title, filename, canonical path, parent, and template aligned
* keep changes narrow and scoped to the current issue or phase
* distinguish accepted target rules from transitional implementation state
* preserve accepted Module terminology unless the task explicitly changes it
* keep ownership separate from package identity and physical placement
* do not duplicate content already owned by another Module document

Folder-specific rules:

* The [Module Definition](../Definitions/Modules/Definition.md) is external to this package and authoritative for the Module boundary.
* `README.md` owns package purpose, reading order, and maintenance rules.
* `Index.md` owns routing and document status.
* `AGENTS.md` owns agent-facing routing and folder-specific working rules.
* Additional files must own one distinct Module architecture subject.
* Keep the folder flat unless a later accepted architecture decision authorizes subfolders.
* Do not add generic files such as `notes.md`, `misc.md`, or `shared.md`.
* Do not convert this folder into an inventory of every current Module file.
* Individual Module packages and their product documentation remain separate from this architecture-area documentation package.

---

## Documentation Rules

Documentation changes in this folder must:

* use portable Markdown links
* keep parent and related links current
* update `Index.md` when documents are added, moved, renamed, superseded, or removed
* update `README.md` only when the package contract or reading order changes
* update the central [Module Definition](../Definitions/Modules/Definition.md) only when the Module boundary itself changes and that external file is in scope
* link to accepted decisions instead of reproducing their full contents
* state whether a rule is proposed, accepted, transitional, compatibility-only, or superseded
* identify the later owner for unresolved placement, naming, migration, implementation, or verification work

Do not create a document that competes with the central Module definition or an existing Modules package document for the same responsibility.

---

## Module Boundary Guardrails

When reviewing or drafting Module documentation:

* classify a Module by cohesive optional responsibility and independent lifecycle
* require Core to remain operational when the Module is absent
* treat independent Composer packaging as the mandatory target state
* permit transitional implementation to be classified before package migration is complete
* do not treat placement under `Modules/` as ownership proof
* do not classify required Core behavior as a Module because it is package-shaped
* do not permit Modules to redefine Core invariants
* do not permit Modules to own reusable UI infrastructure
* require cross-Module dependencies to be explicit, versioned, declared, validated, and contract-based
* prohibit access to another Module’s internal implementation or private state
* keep `module_key`, Composer identity, folder name, namespace, route prefix, and display name as distinct concepts
* require every distinct responsibility to have one primary owner

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
* mandatory target state and current transitional state are not conflated

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

---

## Security And Data Rules

Modules may own business, administrative, integration, operational, or internal-tool behavior that affects sensitive data or privileged workflows.

When editing those subjects:

* do not allow a Module to bypass Core authorization, validation, audit, monitoring, governance, or data-protection rules
* do not record secrets, tokens, cookies, MFA material, private keys, credentials, or sensitive runtime data
* do not present proposed security or data behavior as implemented or accepted
* preserve fail-closed access expectations unless an accepted standard explicitly states otherwise
* require Module-owned persistence and data contracts to identify their canonical database owner
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

* the requested document does not have a clear Module architecture owner
* the change conflicts with the [Module Definition](../Definitions/Modules/Definition.md) or an accepted ADR
* another document already owns the same subject
* the change would introduce a competing Module definition inside this package
* the proposed responsibility may actually be required Core behavior
* the change would redefine Core, UI, delivery Surfaces, or Laravel integration without explicit scope
* a cross-Module dependency lacks a public contract or declared version relationship
* physical placement is being used as the sole evidence of Module ownership
* package completion and ownership classification are being conflated
* an accepted decision is being replaced without explicit repository-owner authority
* a new subfolder is required but has not been architecturally approved
* sensitive implementation or runtime data would be recorded
* unrelated working-tree changes may be overwritten

---

## Related

* [Root AGENTS](../../../AGENTS.md)
* [Docs AGENTS](../../AGENTS.md)
* [Planning AGENTS](../AGENTS.md)
* [Modules README](README.md)
* [Module Definition](../Definitions/Modules/Definition.md)
* [Modules Index](Index.md)
* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
