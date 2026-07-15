<!--
DOC-META
title: Definition Document Type
doc_type: readme
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/README.md
parent: docs/02-standards/documentation/doc-types/definition/index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the definition document-type package, read order, folder contract, and maintenance requirements.
-->

# Definition Document Type

Parent: [Definition Document Type Index](index.md)

Use this README to understand the purpose, structure, and maintenance rules for the `definition` document type.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder defines and governs repository documents using:

```yaml
doc_type: definition
````

A definition document establishes the stable meaning and boundary of one reusable repository concept.

This package separates:

* the meaning of a definition document;
* enforceable definition-document requirements;
* package navigation and maintenance;
* type-specific agent guidance;
* the copyable definition template.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and use.
2. [Definition Document Definition](Definition.md) for the type’s meaning and classification.
3. [Definition Document Standard](Standard.md) for metadata, structure, placement, review, and maintenance requirements.
4. `index.md` for package routing.
5. [Definition Template](../../../../09-reference/templates/docs/_definition.md) when creating a definition document.

## 3. Folder Contract

This folder contains documentation governing the `definition` document type.

It owns:

* the meaning of a definition document;
* qualification and classification rules;
* required definition-document structure;
* metadata and placement requirements;
* acceptance and review requirements;
* maintenance and validation rules.

It does not contain:

* repository concept definitions themselves;
* architecture planning;
* feature definitions;
* glossary entries;
* copyable templates;
* active issue or Project status.

Reusable repository concept definitions remain with their assigned canonical definition roots.

## 4. Required Files

This package contains:

| File            | Purpose                                                    |
| --------------- | ---------------------------------------------------------- |
| `README.md`     | Explains package purpose, read order, and maintenance.     |
| `Definition.md` | Defines the `definition` document type.                    |
| `Standard.md`   | Defines enforceable requirements for definition documents. |
| `index.md`      | Routes readers to package documents and related owners.    |
| `AGENTS.md`     | Provides type-specific agent guidance.                     |

The copyable template is maintained separately at:

```text
docs/09-reference/templates/docs/_definition.md
```

## 5. Content Rules

* Keep `Definition.md` focused on type meaning.
* Keep `Standard.md` focused on enforceable requirements.
* Keep the template focused on reusable shape.
* Do not place repository-specific concept definitions in this package.
* Do not use a definition document as a broad architecture plan.
* Do not use a definition document as a glossary merely because it defines a term.
* Do not duplicate accepted decision history already owned by an ADR.
* Do not mark a proposed concept accepted without repository-owner authority.

## 6. Maintenance

Update this package when:

* the definition type’s classification changes;
* required definition sections change;
* canonical definition locations change;
* definition metadata rules change;
* review or validation requirements change;
* the definition template changes;
* a competing definition-document authority is found.

Changes to reusable shape must update both the standard and template.

## 7. Related

* [Definition Document Type Index](index.md)
* [Definition Document Definition](Definition.md)
* [Definition Document Standard](Standard.md)
* [Document Types README](../README.md)
* [Document Type Standard](../Standard.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)

````

### FILE: `docs/02-standards/documentation/doc-types/definition/index.md`

```md
<!--
DOC-META
title: Definition Document Type Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/index.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the definition document-type definition, standard, package guidance, template, and canonical repository definitions.
-->

# Definition Document Type Index

Parent: [Document Types Index](../index.md)

Use this index to navigate the `definition` document-type package.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
- [4. Subfolders](#4-subfolders)
- [5. Maintenance Notes](#5-maintenance-notes)
- [6. Related](#6-related)

## 1. Purpose

Route readers to the authoritative meaning and enforceable requirements for documents using:

```yaml
doc_type: definition
````

## 2. Scope

### 2.1. Belongs Here

This folder contains:

* the definition of the `definition` document type;
* type-specific standards;
* package guidance;
* package routing;
* type-specific agent instructions.

### 2.2. Does Not Belong Here

This folder does not contain:

* individual repository concept definitions;
* copyable templates;
* architecture plans;
* feature or database documentation;
* glossary collections;
* active issue or Project status.

## 3. Documents

| Document                                        | Purpose                                                                      | Status |
| ----------------------------------------------- | ---------------------------------------------------------------------------- | ------ |
| [README](README.md)                             | Explains package purpose, read order, and maintenance.                       | active |
| [Definition Document Definition](Definition.md) | Defines the meaning and classification of a definition document.             | active |
| [Definition Document Standard](Standard.md)     | Defines metadata, structure, placement, review, and validation requirements. | active |
| [Agents](AGENTS.md)                             | Provides type-specific agent guidance and stop conditions.                   | active |

## 4. Subfolders

No subfolders currently exist.

Supporting material should be added only when it owns a distinct definition-type responsibility that does not belong in `Definition.md` or `Standard.md`.

## 5. Maintenance Notes

* Keep this index synchronized with package files.
* Do not duplicate the type definition or standard here.
* Keep links to the template and repository definition roots current.
* Update status when the package lifecycle changes.
* Do not add individual concept definitions to this package.

## 6. Related

* [Document Types Index](../index.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)
* [Doc Governance](../../Doc%20Governance.md)
* [Documentation Review Standards](../../Documentation%20Review%20Standards.md)

````

### FILE: `docs/02-standards/documentation/doc-types/definition/AGENTS.md`

```md
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
* Related GitHub issue: #48

````

### FILE: `docs/02-standards/documentation/doc-types/definition/Standard.md`

```md
<!--
DOC-META
title: Definition Document Standard
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/Standard.md
parent: docs/02-standards/documentation/doc-types/definition/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines qualification, metadata, structure, placement, acceptance, review, validation, and maintenance requirements for definition documents.
-->

# Definition Document Standard

Parent: [Definition Document Type Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Qualification](#3-qualification)
- [4. Required Metadata](#4-required-metadata)
- [5. Required Structure](#5-required-structure)
- [6. Content Rules](#6-content-rules)
- [7. Placement And Naming](#7-placement-and-naming)
- [8. Linking And Dependencies](#8-linking-and-dependencies)
- [9. Status And Acceptance](#9-status-and-acceptance)
- [10. Review And Validation](#10-review-and-validation)
- [11. Maintenance](#11-maintenance)
- [12. Related](#12-related)

## 1. Purpose

Define the enforceable requirements for repository documents using:

```yaml
doc_type: definition
````

## 2. Scope

This standard applies to:

* reusable architecture concept definitions;
* document-type definitions;
* framework or repository concept definitions;
* other formal definitions assigned to a canonical owner by documentation governance.

This standard does not apply to:

* glossary entries;
* ordinary introductory sections;
* feature specifications;
* architecture plans;
* implementation standards;
* decision records;
* migration plans;
* temporary terminology notes.

## 3. Qualification

A document qualifies as a definition when it must establish one stable reusable concept and answer:

* What is the concept?
* How is it classified?
* What does it include?
* What does it exclude?
* Which dependencies or relationships apply?
* What is its target status?
* Is the controlling definition proposed or accepted?

A concept should not receive a standalone definition when:

* it appears in only one local document;
* a concise glossary entry is sufficient;
* its meaning is already owned by another canonical source;
* it is merely a physical folder or class name;
* it exists only for one temporary issue;
* the proposed document would primarily contain planning or implementation detail.

## 4. Required Metadata

A definition document must use:

```yaml
doc_type: definition
template: docs/09-reference/templates/docs/_definition.md
```

It must also provide accurate values for:

* `title`;
* `status`;
* `owner`;
* `canonical`;
* `canonical_path`;
* `parent`;
* `summary`.

A canonical accepted definition normally uses:

```yaml
status: active
canonical: true
```

A proposed definition must use an accurate draft lifecycle and must not claim accepted authority.

Metadata path, visible parent link, filename casing, and repository location must agree.

## 5. Required Structure

Every definition document must contain:

1. Definition
2. Classification Rule
3. Owns
4. Must Not Own
5. Dependency Rules
6. Target Status
7. Accepted Decision
8. Open Questions
9. Related

The exact prose may vary, but each section must preserve its assigned responsibility.

### Definition

State the stable meaning of the concept and distinguish it from adjacent concepts.

### Classification Rule

State the conditions used to determine whether something belongs within the definition.

### Owns

List authoritative inclusions, responsibilities, or characteristics.

### Must Not Own

List explicit exclusions and adjacent-owner boundaries.

### Dependency Rules

State permitted and prohibited dependency or relationship directions.

### Target Status

State whether the concept is permanent, transitional, compatibility-only, deprecated, or proposed.

### Accepted Decision

State the concise controlling definition and whether it is proposed or accepted.

### Open Questions

Include only unresolved questions that could materially change the definition.

Use `None.` when no such question remains.

### Related

Link to parent routing, governing decisions, standards, planning, architecture, and consuming documents.

## 6. Content Rules

A definition must:

* define one concept;
* remain concise enough to be reused broadly;
* separate meaning from current physical implementation;
* distinguish accepted rules from open questions;
* identify explicit exclusions;
* identify later owners for placement, naming, migration, or implementation questions;
* link to detailed supporting material rather than absorbing it.

A definition must not:

* become a complete implementation plan;
* duplicate an ADR’s full rationale;
* become a file inventory;
* own active delivery status;
* contain broad chronological history;
* use current placement as sole classification evidence;
* preserve multiple alternative definitions as equal active truth;
* attribute repository-owner acceptance without explicit authority.

## 7. Placement And Naming

Reusable architecture definitions normally live at:

```text
docs/07-planning/Definitions/<Concept>/Definition.md
```

Document-type definitions live at:

```text
docs/02-standards/documentation/doc-types/<doc_type>/Definition.md
```

An alternate location is permitted only when:

* another accepted documentation standard assigns the concept elsewhere;
* the alternate owner is explicit;
* no competing active definition remains;
* indexes and inbound links are updated.

Definition filenames use:

```text
Definition.md
```

Concept-folder naming must follow the applicable repository naming standard.

## 8. Linking And Dependencies

A definition must:

* link upward to its parent index;
* link to directly related definitions;
* link to governing ADRs when applicable;
* link to planning or migration owners for deferred work;
* link to its package README or consuming package when useful;
* use portable relative Markdown links for repository paths.

Consuming documents must link to the canonical definition rather than reproducing complete definition sections.

A definition may summarize an accepted decision but must not replace an ADR when durable rationale and decision history require one.

## 9. Status And Acceptance

Metadata lifecycle and the `Accepted Decision` section must remain consistent.

Use:

```text
Status: proposed
```

when repository-owner acceptance has not occurred.

Use:

```text
Status: accepted
```

only after explicit repository-owner acceptance.

Acceptance of a definition does not prove:

* implementation matches the definition;
* migration is complete;
* validation of dependent code has passed;
* every existing artifact has been classified.

Those claims require separate evidence.

## 10. Review And Validation

Review must confirm:

* the concept requires a formal definition;
* one canonical definition exists;
* classification is unambiguous;
* inclusions and exclusions do not overlap adjacent owners;
* dependency rules are explicit;
* physical placement does not silently determine meaning;
* proposed and accepted states are accurate;
* open questions are bounded;
* links and metadata are correct;
* no competing definition remains active.

Required repository checks:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually:

* required headings exist;
* parent and related links resolve;
* `canonical_path` matches the file;
* filename casing is correct;
* template and standard remain synchronized.

Do not claim validation passed unless the exact commands succeeded.

## 11. Maintenance

Update a definition when:

* concept meaning changes;
* classification changes;
* included or excluded responsibilities change;
* dependency rules change;
* target status changes;
* an open question is resolved;
* a governing decision supersedes the definition.

When reusable definition structure changes:

* update this standard;
* update the definition template;
* review existing canonical definitions;
* update documentation validation where applicable.

Do not rewrite an accepted definition merely to reflect physical migration that does not change the concept boundary.

## 12. Related

* [Definition Document Type README](README.md)
* [Definition Document Type Index](index.md)
* [Definition Document Definition](Definition.md)
* [Parent Document Type Standard](../Standard.md)
* [How To Write Docs](../../How%20To%20Write%20Docs.md)
* [Doc Governance](../../Doc%20Governance.md)
* [Documentation Review Standards](../../Documentation%20Review%20Standards.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)