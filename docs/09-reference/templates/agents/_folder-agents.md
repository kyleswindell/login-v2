<!--
DOC-META
title: Folder AGENTS Template
doc_type: reference
status: active
owner: ai
canonical: false
canonical_path: docs/09-reference/templates/agents/_folder-agents.md
parent: docs/09-reference/templates/agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Copyable template for folder-level AGENTS.md files that route Codex to local ownership rules, canonical docs, standards, and stop conditions.
-->

# Folder AGENTS Template

Use this template when creating a folder-level `AGENTS.md` file.

Actual copied `AGENTS.md` files outside `docs/` should start at `# AGENTS.md`. Do not copy the `DOC-META` block above into runtime agent instruction files unless the target file itself lives under `docs/`.

---

# AGENTS.md

## Folder Purpose

This folder owns: `<briefly describe what this folder owns>`.

Use this file to guide Codex and other AI agents working inside this folder tree. This file is agent-facing routing guidance, not canonical product or architecture documentation.

Canonical truth must remain in the relevant `docs/` owner documents.

---

## Ownership

This folder may contain:

- `<allowed file/category>`
- `<allowed file/category>`
- `<allowed file/category>`

This folder must not contain:

- `<forbidden responsibility>`
- `<forbidden responsibility>`
- `<forbidden responsibility>`

If a requested change crosses this folder’s ownership boundary, stop and identify the correct owner before editing.

---

## Required Reading Before Editing

Before making changes in this folder, read the nearest applicable root and folder-level `AGENTS.md` files, then read the relevant canonical docs.

Required standards:

- [How To Write Docs](<relative-path-to-docs>/02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](<relative-path-to-docs>/02-standards/documentation/Doc%20Governance.md)
- [Implementation Status And Development Sync Standard](<relative-path-to-docs>/02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required local sources:

- `<path-to-local-standard-or-index>`
- `<path-to-local-architecture-or-planning-doc>`
- `<path-to-local-test-or-contract-doc>`

Prefer targeted section reads over loading large unrelated documents.

---

## Canonical Owners To Check

When work in this folder affects durable behavior, update or link to the correct canonical owner.

| Change Type                               | Canonical Owner                                              |
| ----------------------------------------- | ------------------------------------------------------------ |
| Architecture boundary or ownership model  | `docs/03-architecture/`                                      |
| User/admin/system behavior                | `docs/04-features/`                                          |
| Execution path or workflow                | `docs/05-flows/`                                             |
| Schema, table, or data contract           | `docs/06-database/`                                          |
| Implementation rule or convention         | `docs/02-standards/`                                         |
| Planning, sequencing, or migration intent | `docs/07-planning/`                                          |
| Operational procedure                     | `docs/10-runbooks/`                                          |
| Agent workflow guidance                   | root/folder `AGENTS.md`, `.agents/skills/`, or `docs/11-ai/` |

Do not leave durable truth only in this `AGENTS.md` file.

---

## File And Shape Rules

When creating or modifying files in this folder:

- identify the file type before editing
- follow the relevant file archetype or local convention
- preserve existing public contracts unless the issue explicitly changes them
- keep changes narrow and scoped to the issue/task
- do not perform broad cleanup while making a targeted change
- do not introduce new dependencies without explicit approval
- do not leave temporary debugging, commented-out code, or unused imports
- update tests and docs when behavior or contracts change

Folder-specific file rules:

- `<rule>`
- `<rule>`
- `<rule>`

---

## Documentation Rules

Documentation changes in this folder must:

- use portable Markdown links for important references
- keep parent/index links current
- update local indexes when child documents are added, moved, split, archived, or superseded
- link to canonical owners instead of duplicating durable truth
- include or preserve `DOC-META` headers for new or materially rewritten docs
- use the correct template from `docs/09-reference/templates/docs/`

Do not add new loose documentation files when a stable subfolder or index owner already exists.

---

## Testing And Verification

For changes in this folder, prefer the narrowest verification that proves the change.

Expected verification may include:

- `<test command or test type>`
- `<lint/build command or manual verification>`
- `<docs/link/index review>`
- `<manual review surface if applicable>`

Do not claim tests passed unless they were run successfully.

If verification cannot be run, state why and identify the minimum command or review the user should run.

---

## UI / Visual Review Rules

Use this section only when the folder owns UI, CSS, Blade, JS controls, or visual references.

- Codex is not the primary visual design authority.
- Do not redesign layouts, spacing, visual hierarchy, or interaction behavior without explicit direction.
- Preserve component contracts and reference docs.
- Manual visual review is required for spacing, layout, hierarchy, or design-sensitive changes.
- Report whether manual visual review is still needed after the change.

Remove this section if the folder does not own UI work.

---

## Security And Data Rules

Use this section when the folder may affect auth, access, audit, data, secrets, exports, webhooks, APIs, or operational safety.

- Do not bypass authorization, validation, audit, monitoring, or data-protection boundaries.
- Do not expose secrets, tokens, cookies, MFA material, authorization headers, private keys, or sensitive personal data.
- Do not add state-changing GET routes.
- Do not expose protected files through public storage.
- Use fail-closed behavior for access decisions unless a canonical standard explicitly says otherwise.
- Update security, audit, data, or runbook docs when those contracts change.

Remove this section if the folder has no realistic security or data impact.

---

## Git And Scope Rules

Before editing:

- inspect current scope
- check for unrelated dirty files when practical
- avoid overwriting unrelated work
- do not stage unrelated changes
- do not use `git add .` in a dirty working tree

When reporting work, include:

- files changed
- behavior changed
- docs updated
- tests or verification run
- known gaps or manual review needs

---

## Stop Conditions

Stop and ask before editing when:

- the requested change crosses folder ownership boundaries
- the correct canonical owner is unclear
- relevant standards or planning docs conflict
- the change would require a new dependency
- the change would alter auth, access, security, data, deployment, or schema without explicit scope
- UI work requires design judgment not specified by the issue/task
- tests fail in a way that changes the implementation plan
- the working tree contains unrelated changes that may be overwritten

---

## Related

- [Root AGENTS](<relative-path-to-root>/AGENTS.md)
- [How To Write Docs](<relative-path-to-docs>/02-standards/documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](<relative-path-to-docs>/02-standards/documentation/Doc%20Governance.md)
- [Documentation Review Standards](<relative-path-to-docs>/02-standards/documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](<relative-path-to-docs>/02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)