# AGENTS.md

## Folder Purpose

This folder owns the definition and enforceable requirements for repository documents using `doc_type: definition`.

Use this file to guide Codex and other AI agents working within this package. This file is agent-facing routing guidance, not the canonical definition or standard.

Canonical truth remains in:

- `Definition.md`
- `Standard.md`
- the parent document-type standard
- accepted documentation governance

## Ownership

This folder may contain:

- `README.md`
- `Definition.md`
- `Standard.md`
- `index.md`
- `AGENTS.md`
- supporting documents with one distinct definition-type responsibility

This folder must not contain:

- individual repository concept definitions
- copyable templates
- glossary collections
- architecture plans
- feature or database documentation
- active issue or Project status
- unrelated document-type standards

## Required Reading Before Editing

Read:

1. `../../../../../AGENTS.md`
2. `../../../../AGENTS.md`
3. `../../../AGENTS.md`
4. `../../AGENTS.md`
5. `../AGENTS.md`
6. `README.md`
7. `Definition.md`
8. `Standard.md`
9. `index.md`

Required standards:

- [How To Write Docs](../../How%20To%20Write%20Docs.md)
- [Doc Governance](../../Doc%20Governance.md)
- [Documentation Review Standards](../../Documentation%20Review%20Standards.md)
- [Parent Document Type Standard](../Standard.md)

Required references:

- [Definition Template](../../../../09-reference/templates/docs/_definition.md)
- [Repository Definitions](../../../../07-planning/Definitions/Index.md)

## Canonical Owners To Check

| Change Type                       | Canonical Owner                                   |
| --------------------------------- | ------------------------------------------------- |
| Meaning of `doc_type: definition` | `Definition.md`                                   |
| Definition-document requirements  | `Standard.md`                                     |
| Shared document-type rules        | `../Standard.md`                                  |
| Copyable definition shape         | `docs/09-reference/templates/docs/_definition.md` |
| Repository concept meaning        | applicable canonical `Definition.md`              |
| Branch and canonical ownership    | `../../Doc Governance.md`                         |
| Documentation review              | `../../Documentation Review Standards.md`         |

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
````

Also verify:

* metadata values are controlled;
* parent and related links resolve;
* required sections are present;
* no definition duplicates another concept owner;
* accepted status has repository-owner authority;
* the template and standard remain synchronized;
* definition paths use correct casing.

Do not claim validation passed unless the commands ran successfully.

## Git And Scope Rules

Before editing:

* confirm the active issue branch and worktree;
* inspect unrelated changes;
* stage only accepted files;
* do not overwrite concurrent documentation work;
* do not use `git add .` in a dirty worktree.

When reporting work, include:

* files changed;
* definition requirements changed;
* template changes;
* validation run;
* affected existing definitions;
* unresolved governance questions.

## Stop Conditions

Stop and report when:

* the concept does not require a formal definition;
* another definition already owns the concept;
* the document is actually planning, architecture, feature, database, or standard content;
* canonical placement is unresolved;
* accepted status lacks repository-owner authority;
* required changes would conflict with the template;
* validation tooling does not recognize the type;
* unrelated working-tree changes may be overwritten.

## Related

* [Definition Document Type README](README.md)
* [Definition Document Type Index](index.md)
* [Definition Document Definition](Definition.md)
* [Definition Document Standard](Standard.md)
* [Parent Document Type Standard](../Standard.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)

````

### FILE: `docs/02-standards/documentation/doc-types/definition/Definition.md`

```md
<!--
DOC-META
title: Definition Document Definition
doc_type: definition
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/Definition.md
parent: docs/02-standards/documentation/doc-types/definition/index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a definition document as the canonical source for the stable meaning and boundary of one reusable repository concept.
-->

# Definition Document Definition

Parent: [Definition Document Type Index](index.md)

- [1. Definition](#1-definition)
- [2. Classification Rule](#2-classification-rule)
- [3. Owns](#3-owns)
- [4. Must Not Own](#4-must-not-own)
- [5. Dependency Rules](#5-dependency-rules)
- [6. Target Status](#6-target-status)
- [7. Accepted Decision](#7-accepted-decision)
- [8. Open Questions](#8-open-questions)
- [9. Related](#9-related)

## 1. Definition

A definition document establishes the stable meaning and boundary of one reusable repository concept.

It explains:

- what the concept is;
- how to determine whether something belongs to it;
- what responsibilities or characteristics it includes;
- what it explicitly excludes;
- which dependencies or relationships apply;
- whether its target status is permanent, transitional, compatibility-only, deprecated, or proposed.

A definition is independent of current physical implementation placement.

## 2. Classification Rule

Use a definition document when a concept:

- is referenced from multiple repository or documentation areas;
- requires one stable and reusable meaning;
- has an ownership, classification, responsibility, or dependency boundary;
- must remain understandable independently of one implementation plan;
- is expected to be consumed by architecture, standards, planning, implementation, or agent guidance.

Do not create a definition document merely because:

- a repository folder exists;
- a class or package has a name;
- one issue uses a local term;
- a temporary planning label needs explanation;
- a glossary entry would be useful;
- a document needs introductory prose.

## 3. Owns

A definition document owns:

- the canonical meaning of its concept;
- the concept’s classification rule;
- authoritative included responsibilities or characteristics;
- explicit excluded responsibilities or characteristics;
- permitted and prohibited dependencies where applicable;
- permanent or transitional target status;
- the concise accepted or proposed controlling statement;
- unresolved questions that could materially change the definition;
- links to governing decisions and consuming documents.

## 4. Must Not Own

A definition document must not own:

- implementation sequencing;
- physical migration plans;
- file-by-file mappings;
- active issue or Project status;
- chronological work history;
- detailed physical placement unless placement is intrinsic to the concept;
- feature behavior;
- execution flows;
- schema or data contracts;
- implementation conventions;
- operational procedures;
- duplicated decision history already owned by an ADR.

A definition must not become a broad architecture plan or a substitute for an accepted decision record.

## 5. Dependency Rules

A definition document:

- may depend on accepted ADRs and canonical standards;
- may reference current implementation as evidence;
- may be consumed by multiple architecture, planning, standards, implementation, and agent-guidance documents;
- must remain understandable without loading every consuming document;
- must not derive meaning solely from current physical placement;
- must not conflict with a higher-authority accepted decision;
- must not mark a proposed definition accepted without repository-owner authority.

When a definition and implementation differ:

- the definition states the accepted target boundary;
- implementation is classified separately as current, transitional, compatibility-only, or incorrect;
- migration remains owned by a separate accepted plan or issue.

## 6. Target Status

Status: permanent

`definition` is a permanent controlled document type.

Canonical reusable architecture definitions normally use:

```text
docs/07-planning/Definitions/<Concept>/Definition.md
````

Document-type definitions use:

```text
docs/02-standards/documentation/doc-types/<doc_type>/Definition.md
```

Another location may be used only when an accepted documentation standard assigns that definition to a different canonical owner.

## 7. Accepted Decision

Status: accepted

A definition document is the canonical source for a reusable repository concept requiring stable classification, inclusion, exclusion, dependency, and target-status rules.

Each defined concept has one authoritative definition.

Other documents consume that definition through links and must not create a competing meaning.

Definition ownership remains independent of physical implementation placement.

## 8. Open Questions

None.

New canonical definition roots or alternative definition locations require an explicit documentation-governance decision.

## 9. Related

* [Definition Document Type README](README.md)
* [Definition Document Type Index](index.md)
* [Definition Document Standard](Standard.md)
* [Parent Document Type Definition](../Definition.md)
* [Parent Document Type Standard](../Standard.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)