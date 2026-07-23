# AGENTS.md

## Folder Purpose

This folder owns the architecture and planning documentation for the reusable UI system within Login 2.0.

Use this file to guide Codex and other AI agents working inside this folder. This file is agent-facing routing guidance, not the canonical definition of UI.

The canonical UI definition is external to this package. UI truth remains in:

* [UI Definition](../Definitions/UI/Definition.md)
* accepted architecture decisions
* later canonical UI architecture and standards documents

---

## Ownership

This folder may contain:

* the UI documentation package files:

  * `README.md`
  * `AGENTS.md`
  * `Index.md`
* UI architecture and planning documents
* Element, Component, Pattern, and Layout planning
* design-token and icon planning
* reusable CSS and JavaScript-control planning
* UI contract, accessibility, review, placement, naming, and migration planning
* supporting matrices or references with a clear UI owner

This folder must not contain:

* routed Core or Module feature definitions
* authorization, persistence, or domain behavior
* generic delivery-Surface definitions
* source code or generated runtime artifacts
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
5. [UI Definition](../Definitions/UI/Definition.md)
6. `Index.md`
7. only the specific supporting document required by the task

Required standards:

* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required architecture sources:

* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)

Prefer targeted section reads over loading unrelated UI planning documents.

---

## Canonical Owners To Check

| Change Type                             | Canonical Owner                                                                                                   |
| --------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| UI definition or ownership boundary     | [UI Definition](../Definitions/UI/Definition.md) and applicable files under `docs/01-decisions/`                 |
| Target repository architecture          | `docs/07-planning/00-overview/m0-target-repository-architecture.md` during Goal 03; later `docs/03-architecture/` |
| UI implementation convention            | `docs/02-standards/ui/` and `docs/02-standards/coding/`                                                           |
| Core or Module feature behavior         | `docs/04-features/`                                                                                               |
| UI workflow or interaction flow         | `docs/05-flows/`                                                                                                  |
| UI implementation or migration planning | this folder                                                                                                       |
| Agent workflow guidance                 | root/folder `AGENTS.md`, `.agents/skills/`, or `docs/11-ai/`                                                      |

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
* preserve accepted UI terminology unless the task explicitly changes it
* keep ownership separate from physical placement and file type
* do not duplicate content already owned by another UI document

Folder-specific rules:

* The [UI Definition](../Definitions/UI/Definition.md) is external to this package and authoritative for the UI boundary.
* `README.md` owns package purpose, reading order, and maintenance rules.
* `Index.md` owns routing and document status.
* `AGENTS.md` owns agent-facing routing and folder-specific working rules.
* Additional files must own one distinct UI subject.
* Keep the folder flat unless a later accepted architecture decision authorizes subfolders.
* Do not add generic files such as `notes.md`, `misc.md`, or `shared.md`.
* Do not convert this folder into a complete UI implementation inventory.

---

## UI Boundary Guardrails

When reviewing or drafting UI documentation:

* classify UI by reusable presentation responsibility
* do not use Blade, CSS, JavaScript, or `resources/` placement as ownership proof
* keep routed, stateful, authorized, and capability-specific presentation with Core or the applicable Module
* prohibit database access, domain queries, mutations, and authorization decisions in UI contracts
* require UI to render from data and decisions supplied by its consumer
* keep UI independent of Core and Module implementation
* permit Core presentation and Modules to depend on public UI contracts
* keep navigation data, contribution aggregation, active-state resolution, and authorization filtering under Core ownership
* keep layout and shell rendering reusable and presentation-only
* require every distinct responsibility to have one primary owner

A proposed document that contradicts these rules requires explicit architecture review before editing proceeds.

---

## Documentation Rules

Documentation changes in this folder must:

* use portable Markdown links
* keep parent and related links current
* update `Index.md` when documents are added, moved, renamed, superseded, or removed
* update `README.md` only when the package contract or reading order changes
* update the central [UI Definition](../Definitions/UI/Definition.md) only when the UI boundary itself changes and that external file is in scope
* link to accepted decisions instead of reproducing their full contents
* distinguish reusable UI contracts from feature-specific implementation
* identify the later owner for unresolved placement, naming, migration, implementation, or verification work

Do not create a document that competes with the central UI definition or an existing UI package document for the same responsibility.

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
* reusable UI and capability-owned presentation remain clearly separated

Do not claim verification passed unless the commands were run successfully.

If verification cannot be run, report the unexecuted commands directly.

---

## UI And Visual Review Rules

* Codex is not the primary visual design authority.
* Do not redesign layout, spacing, hierarchy, color, typography, or interaction behavior without explicit direction.
* Preserve existing component and pattern contracts unless the task explicitly changes them.
* Manual visual review is required for design-sensitive changes.
* Documentation must distinguish automated contract verification from manual visual acceptance.
* Do not present generated examples or screenshots as accepted visual truth without repository-owner review.

---

## Security And Data Rules

UI documentation may affect authentication, authorization, administrative workflows, sensitive data display, and user interaction.

When editing those subjects:

* do not move authorization decisions into UI components or patterns
* do not expose secrets, tokens, cookies, MFA material, private keys, or sensitive personal data
* do not allow presentation state to substitute for server-side enforcement
* preserve fail-closed access behavior
* route security, privacy, data, and audit contracts to their canonical owners

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
* manual visual review requirements
* unresolved questions or required review

---

## Stop Conditions

Stop and report before editing when:

* the requested document does not have a clear UI owner
* the change conflicts with the [UI Definition](../Definitions/UI/Definition.md) or an accepted ADR
* another document already owns the same subject
* the change would introduce a competing UI definition inside this package
* the proposed responsibility may actually be Core- or Module-owned presentation
* authorization, persistence, domain behavior, or lifecycle logic is being assigned to UI
* physical placement or file type is being used as the sole evidence of UI ownership
* the change requires unspecified visual design judgment
* an accepted decision is being replaced without explicit repository-owner authority
* a new subfolder is required but has not been architecturally approved
* sensitive implementation or runtime data would be recorded
* unrelated working-tree changes may be overwritten

---

## Related

* [Root AGENTS](../../../AGENTS.md)
* [Docs AGENTS](../../AGENTS.md)
* [Planning AGENTS](../AGENTS.md)
* [UI README](README.md)
* [UI Definition](../Definitions/UI/Definition.md)
* [UI Index](Index.md)
* [How To Write Docs](../../02-standards/documentation/How%20To%20Write%20Docs.md)
* [Doc Governance](../../02-standards/documentation/Doc%20Governance.md)
* [Documentation Review Standards](../../02-standards/documentation/Documentation%20Review%20Standards.md)
* [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
