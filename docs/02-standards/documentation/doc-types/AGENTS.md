# AGENTS.md

## Folder Purpose

This folder owns the controlled document-type system for Login 2.0 documentation.

Use this file to guide Codex and other AI agents working within the `doc-types/` tree. This file is agent-facing routing guidance, not the canonical definition or standard for a document type.

Canonical truth remains in:

- `Definition.md`
- `Standard.md`
- the applicable child type package
- accepted documentation governance standards

## Ownership

This folder may contain:

- `README.md`
- `Definition.md`
- `Standard.md`
- `index.md`
- child document-type packages
- type-specific definitions and standards
- type-specific `AGENTS.md` files
- compatibility guidance for migrating legacy document-type rules

This folder must not contain:

- copyable document templates
- project planning
- product or feature documentation
- implementation architecture
- database contracts
- operational runbooks
- unrelated documentation standards
- active issue or Project status
- empty type packages created only for symmetry

If a requested change crosses this folder's ownership boundary, stop and identify the correct documentation owner before editing.

## Required Reading Before Editing

Read:

1. `../../../../AGENTS.md`
2. `../../../AGENTS.md`
3. `../../AGENTS.md`
4. `../AGENTS.md`
5. `README.md`
6. `Definition.md`
7. `Standard.md`
8. `index.md`
9. the applicable child package files

Required standards:

- [How To Write Docs](../How%20To%20Write%20Docs.md)
- [Doc Governance](../Doc%20Governance.md)
- [Documentation Review Standards](../Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required references:

- [Documentation Templates](../../../09-reference/templates/docs/_index.md)
- [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)

Prefer targeted reads over loading unrelated document-type packages.

## Canonical Owners To Check

| Change Type | Canonical Owner |
| --- | --- |
| Meaning of a document type | applicable child `Definition.md` |
| Type-specific requirements | applicable child `Standard.md` |
| Common type-system requirements | `Standard.md` |
| Registered type routing | `index.md` |
| General writing requirements | `../How To Write Docs.md` |
| Branch and canonical ownership | `../Doc Governance.md` |
| Copyable shape | `docs/09-reference/templates/docs/` |
| Documentation review | `../Documentation Review Standards.md` |
| Agent guidance | nearest applicable `AGENTS.md` |

Do not leave durable type-system truth only in an `AGENTS.md` file.

## Document-Type Registration Rules

Do not register a new type unless:

- it represents a distinct durable documentation responsibility;
- it cannot be represented accurately by an existing controlled type;
- its classification rule is explicit;
- its normal branch or placement is defined;
- its canonical default is defined;
- its review requirements are defined;
- its template relationship is defined;
- its child package has a clear maintenance owner.

Do not create a document type merely because:

- a new topic exists;
- a different writing style is desired;
- a filename is common;
- one issue needs a temporary artifact;
- a folder would look more symmetrical.

## Child Package Rules

A mature child package contains:

- `Definition.md`
- `Standard.md`
- `README.md`
- `index.md`
- `AGENTS.md`

The copyable template remains under:

- `docs/09-reference/templates/docs/`

When a child package is added or changed:

- update the parent `index.md`;
- update applicable templates;
- update validation tooling when controlled values change;
- update documentation governance where branch or canonical ownership changes;
- retire competing legacy authority;
- update inbound links.

## File And Documentation Rules

- Preserve exact controlled `doc_type` values.
- Use singular lowercase child-folder names matching the controlled type.
- Use `Definition.md` for type meaning.
- Use `Standard.md` for enforceable requirements.
- Use `README.md` for package use and maintenance.
- Use `index.md` for routing.
- Keep type-specific rules out of the parent standard unless they apply to all types.
- Keep copyable content in templates, not standards.
- Do not duplicate complete legacy type sections after migration.
- Preserve transitional authority explicitly until migration is complete.
- Do not mark a package accepted without repository-owner authority.

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually that:

- every metadata path exists;
- parent and related links resolve;
- controlled type values are registered;
- child package status matches the parent index;
- definitions, standards, and templates do not duplicate one another;
- migrated legacy authority has been retired or bounded;
- filename and folder casing are correct.

Do not claim verification passed unless the commands ran successfully.

## Git And Scope Rules

Before editing:

- confirm the active issue or authorized task;
- confirm the intended branch and worktree for writable work;
- inspect for unrelated changes;
- stage only files within the accepted scope when staging is authorized;
- do not overwrite concurrent documentation work;
- do not use `git add .` in a dirty worktree.

When reporting work, include:

- files changed;
- document types registered or migrated;
- standards or templates updated;
- validation run;
- remaining compatibility authority;
- unresolved governance questions.

## Stop Conditions

Stop and report when:

- the proposed type overlaps an existing type;
- the type's durable responsibility is unclear;
- the correct normal branch is unresolved;
- canonical status cannot be determined;
- the package would duplicate another authority;
- a controlled metadata value would change without tooling review;
- a template and standard would conflict;
- a legacy type section would remain as competing authority;
- unrelated working-tree changes may be overwritten.

## Related

- [Document Types README](README.md)
- [Document Types Index](index.md)
- [Document Type Definition](Definition.md)
- [Document Type Standard](Standard.md)
- [How To Write Docs](../How%20To%20Write%20Docs.md)
- [Doc Governance](../Doc%20Governance.md)
- [Documentation Review Standards](../Documentation%20Review%20Standards.md)
- [Documentation Templates](../../../09-reference/templates/docs/_index.md)
