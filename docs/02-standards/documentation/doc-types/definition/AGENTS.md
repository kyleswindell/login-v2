# AGENTS.md

## Folder Purpose

This folder owns the definition and enforceable requirements for repository documents using `doc_type: definition`.

Use this file to guide Codex and other AI agents working within this package. This file is agent-facing routing guidance, not the canonical definition or standard.

Canonical truth remains in:

- `Definition.md`;
- `Standard.md`;
- the parent document-type standard;
- accepted documentation governance.

## Ownership

This folder may contain:

- `README.md`;
- `Definition.md`;
- `Standard.md`;
- `index.md`;
- `AGENTS.md`;
- supporting documents with one distinct definition-type responsibility.

This folder must not contain:

- individual repository concept definitions;
- copyable templates;
- glossary collections;
- architecture plans;
- feature or database documentation;
- active issue or Project status;
- unrelated document-type standards.

## Required Reading Before Editing

Read:

1. `../../../../../AGENTS.md`;
2. `../../../../AGENTS.md`;
3. `../../../AGENTS.md`;
4. `../../AGENTS.md`;
5. `../AGENTS.md`;
6. `README.md`;
7. `Definition.md`;
8. `Standard.md`;
9. `index.md`.

Required standards:

- [How To Write Docs](../../How%20To%20Write%20Docs.md)
- [Doc Governance](../../Doc%20Governance.md)
- [Documentation Review Standards](../../Documentation%20Review%20Standards.md)
- [Parent Document Type Standard](../Standard.md)

Required references:

- [Definition Template](../../../../09-reference/templates/docs/_definition.md)
- [Repository Definitions](../../../../07-planning/Definitions/Index.md)

Prefer targeted reads over loading unrelated document-type packages.

## Canonical Owners To Check

| Change Type | Canonical Owner |
| --- | --- |
| Meaning of `doc_type: definition` | `Definition.md` |
| Definition-document requirements | `Standard.md` |
| Shared document-type rules | `../Standard.md` |
| Copyable definition shape | `docs/09-reference/templates/docs/_definition.md` |
| Repository concept meaning | applicable canonical `Definition.md` |
| Branch and canonical ownership | `../../Doc Governance.md` |
| Documentation review | `../../Documentation Review Standards.md` |

Do not leave durable type requirements only in this `AGENTS.md`.

## Definition Qualification Rules

Use `doc_type: definition` only when a document:

- establishes one stable reusable concept;
- provides a classification rule;
- identifies authoritative inclusions and exclusions;
- identifies dependency relationships where applicable;
- remains useful independently of one implementation plan.

Do not use `doc_type: definition` for:

- a glossary entry;
- a filename explanation;
- a temporary issue term;
- a broad architecture plan;
- a feature specification;
- a migration plan;
- a decision history;
- an implementation standard.

## File And Shape Rules

Definition documents must:

- use `Definition.md` filename casing when stored in a concept package;
- use `doc_type: definition`;
- use the definition template;
- preserve the required section responsibilities;
- identify accepted versus proposed status;
- separate concept meaning from physical placement;
- link to planning and implementation documents rather than absorbing them;
- avoid duplicating complete ADR rationale.

When required structure changes:

- update `Standard.md`;
- update the definition template;
- review existing canonical definitions;
- update validation tooling where applicable.

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify:

- metadata values are controlled;
- parent and related links resolve;
- required sections are present;
- no definition duplicates another concept owner;
- accepted status has repository-owner authority;
- the template and standard remain synchronized;
- definition paths use correct casing.

Do not claim validation passed unless the commands ran successfully.

## Git And Scope Rules

Before editing:

- confirm the active issue or authorized task;
- confirm the intended branch and worktree for writable work;
- inspect unrelated changes;
- stage only accepted files when staging is authorized;
- do not overwrite concurrent documentation work;
- do not use `git add .` in a dirty worktree.

When reporting work, include:

- files changed;
- definition requirements changed;
- template changes;
- validation run;
- affected existing definitions;
- unresolved governance questions.

## Stop Conditions

Stop and report when:

- the concept does not require a formal definition;
- another definition already owns the concept;
- the document is actually planning, architecture, feature, database, or standard content;
- canonical placement is unresolved;
- accepted status lacks repository-owner authority;
- required changes would conflict with the template;
- validation tooling does not recognize the type;
- unrelated working-tree changes may be overwritten.

## Related

- [Definition Document Type README](README.md)
- [Definition Document Type Index](index.md)
- [Definition Document Definition](Definition.md)
- [Definition Document Standard](Standard.md)
- [Parent Document Type Standard](../Standard.md)
- [Definition Template](../../../../09-reference/templates/docs/_definition.md)
- [Repository Definitions](../../../../07-planning/Definitions/Index.md)
