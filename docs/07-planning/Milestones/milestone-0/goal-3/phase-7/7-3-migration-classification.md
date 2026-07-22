<!--
DOC-META
title: Phase 7.3 Migration Classification
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-3-migration-classification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the controlled migration dispositions used by the Phase 7 current-to-target direction matrix and establishes rules for selecting, interpreting, and implementing each classification.
-->

# Phase 7.3 Migration Classification

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Define the controlled migration dispositions used by the Phase 7 current-to-target direction matrix.

Each matrix row must use one primary disposition that communicates the architectural relationship between the current pattern and its accepted target.

The disposition does not:

* authorize repository changes;
* prescribe implementation order;
* establish compatibility;
* require preservation of current implementation;
* replace the later owner’s verification and migration plan.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Physical migration authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * Phase 7.1 mapping scope;
  * reconciled Phase 7.2 current-to-target direction matrix.

## 3. Classification Contract

Every matrix row must use exactly one of these primary dispositions:

```text
Retain
Move
Rename
Split
Merge
Extract
Replace
Remove later
Decision blocked
```

Do not combine dispositions in the disposition field.

Invalid examples include:

```text
Retain / replace
Split / move
Extract / replace
Replace / remove later
Retain / align
```

Secondary implementation treatment belongs in the row’s Notes field.

Example:

```text
Disposition: Retain

Notes:
The Core Runtime capability and target path remain, but the current implementation may be rewritten.
```

## 4. Controlled Dispositions

### 4.1. Retain

Use `Retain` when the current owner, responsibility, or structural role remains valid in the target architecture.

`Retain` does not require the current implementation to remain unchanged.

It may include:

* internal rewriting;
* dependency correction;
* naming alignment;
* contract hardening;
* decomposition of implementation details;
* removal of obsolete internals;
* physical reorganization within the same accepted owner.

Examples:

* `app/Core/Runtime/` remains Core Runtime;
* accepted reusable UI artifacts remain UI-owned;
* root Laravel configuration remains a framework integration boundary;
* documentation guardrails remain repository tooling.

Do not use `Retain` merely because current code is useful. The owner and target responsibility must remain valid.

### 4.2. Move

Use `Move` when one coherent responsibility remains substantially intact but its authoritative owner or structural placement changes.

Examples:

* a capability-owned Controller moves from root `app/Http/` into owner-local Delivery;
* a UI icon command moves from generic `app/Console/` into UI tooling;
* Module-owned database artifacts move into the optional Module package.

A `Move` may require namespace and registration changes, but its primary architectural meaning is relocation of one coherent responsibility.

Do not use `Move` when the current pattern must first be divided among several owners. Use `Split`.

### 4.3. Rename

Use `Rename` when ownership, behavior, and placement remain materially stable but an accepted identity must change.

A rename may apply to:

* a class;
* namespace segment;
* route name;
* configuration key;
* command name;
* capability key;
* file or folder name.

Use `Rename` only when the identity change is the primary migration action.

Do not use `Rename` when:

* the responsibility moves to another owner;
* the implementation is being replaced;
* the current abstraction is obsolete;
* several current responsibilities are being separated.

Compatibility for an old name is not implied. Any required alias or transition must be recorded separately in the compatibility register.

### 4.4. Split

Use `Split` when one current pattern combines responsibilities that belong to multiple target owners, target patterns, or lifecycle rules.

Examples:

* `app/Platform/Shell/` divides among Workspace, Core Navigation, UI, and restricted layout composition;
* `app/Platform/Security/` divides among Security, Access, Data Protection, HTTP Delivery, Monitoring, and Audit;
* the central definitions system divides among owner declarations, Application Registration, Host Registries, persistence ownership, and UI;
* root factories and seeders divide by owner and purpose.

`Split` is the normal classification for mixed transitional roots.

The Notes field should identify the major target groups without defining file-by-file movement.

Do not use `Split` merely because several files exist. The responsibilities themselves must differ materially.

### 4.5. Merge

Use `Merge` when multiple current patterns represent one target responsibility and should converge into a single accepted owner or structural pattern.

Examples may include:

* duplicate registries converging into one Host Registry;
* parallel configuration declarations converging into one owner-local Contract;
* duplicate UI implementations converging into one accepted reusable artifact.

`Merge` preserves the target responsibility, not necessarily either current implementation.

The matrix should identify the current patterns being combined and the accepted target owner.

Do not use `Merge` to hide unresolved ownership. The resulting target must be explicit.

### 4.6. Extract

Use `Extract` when a coherent responsibility is currently contained inside the wrong architectural package or owner and must be separated into its already accepted target owner.

Examples:

* required Auth behavior extracted from `Modules/Auth/` into `app/Core/Auth/`;
* required Access behavior extracted from `Modules/Roles/`;
* required Settings behavior extracted from `Modules/Settings/`.

`Extract` differs from `Move` because the current container itself is architecturally invalid for that responsibility.

Extraction normally includes:

* removal of false package identity;
* replacement of namespace and registration assumptions;
* separation from unrelated package infrastructure;
* owner-local rebuilding.

Do not interpret `Extract` as preserving the current package implementation.

### 4.7. Replace

Use `Replace` when the current responsibility remains necessary but the current abstraction, implementation model, or integration mechanism is not an acceptable basis for the target.

Examples:

* `PlatformLogger` replaced by Core Monitoring Contracts and a Laravel reporting adapter;
* current Application Registration replaced by the accepted descriptor/compiler/registrar model;
* current application tests replaced by a new verification-first architecture;
* direct cross-owner Model access replaced by public Contracts or Queries.

`Replace` preserves accepted requirements and behavior where applicable, not the current implementation.

Do not use `Replace` when the current responsibility is no longer needed. Use `Remove later`.

### 4.8. Remove Later

Use `Remove later` when the current pattern has no target responsibility and should be deleted through separately accepted cleanup work.

Examples:

* obsolete Docs Viewer;
* framework example commands;
* active-batch workflow utilities;
* obsolete generic Surface Contracts with no surviving owner-specific responsibility;
* expired migration tooling.

`Remove later` does not authorize immediate deletion.

The matrix row must identify:

* the cleanup owner;
* any required dependency or consumer check;
* related registrations, routes, permissions, views, tests, or generated artifacts that must be removed together.

Do not use `Remove later` when required behavior still needs replacement.

### 4.9. Decision Blocked

Use `Decision blocked` only when the target owner or structural direction cannot be selected from accepted authority.

The row must state:

* the unresolved question;
* why accepted Goal 3 sources do not answer it;
* the authority responsible for the decision;
* the temporary planning treatment;
* what downstream work is blocked.

Do not use `Decision blocked` merely because implementation details remain unknown.

The following do not require this classification when ownership and direction are already established:

* exact filenames;
* detailed migration order;
* internal class design;
* exact test layout;
* exact schema details assigned to Goal 6;
* exact implementation assigned to a later owner.

## 5. Selection Rules

Choose the disposition using this order:

1. **Does the responsibility have no target?**
   Use `Remove later`.

2. **Is the target owner or direction unresolved?**
   Use `Decision blocked`.

3. **Does one current pattern contain several target responsibilities?**
   Use `Split`.

4. **Do several current patterns converge into one target responsibility?**
   Use `Merge`.

5. **Is a required responsibility trapped inside an invalid architectural container?**
   Use `Extract`.

6. **Does the responsibility stay coherent but move to another owner or path?**
   Use `Move`.

7. **Does only the accepted identity change?**
   Use `Rename`.

8. **Does the current responsibility remain but require a new abstraction or implementation model?**
   Use `Replace`.

9. **Does the current owner and target structural role remain valid?**
   Use `Retain`.

When two actions appear applicable, choose the one that best describes the highest-level architectural relationship.

Examples:

* A retained capability whose classes are rewritten remains `Retain`.
* A mixed folder whose resulting classes move elsewhere remains `Split`.
* A required Core capability leaving a false Module package remains `Extract`.
* A root Controller relocating owner-local remains `Move`.
* An obsolete prototype with no replacement remains `Remove later`.

## 6. Relationship To Preservation

Disposition and preservation answer different questions.

* **Disposition:** What is the architectural relationship between the current pattern and the target?
* **Preservation basis:** What accepted value, if any, must survive?

Valid preservation bases include:

```text
UI contract
Tooling
Behavior/evidence
External/persisted dependency
None
```

Examples:

| Disposition      | Possible preservation basis             |
| ---------------- | --------------------------------------- |
| Retain           | UI contract, tooling, behavior/evidence |
| Move             | behavior/evidence, UI contract          |
| Split            | behavior/evidence, tooling              |
| Extract          | behavior/evidence                       |
| Replace          | behavior/evidence                       |
| Remove later     | none                                    |
| Decision blocked | depends on known evidence               |

A retained owner does not require implementation preservation.

A replaced implementation may still require behavior, security proof, or persisted information to survive.

## 7. Relationship To Compatibility

Migration disposition does not create compatibility.

Compatibility is required only when supported by concrete evidence such as:

* an external consumer;
* an accepted public Contract;
* a persisted identifier;
* retained data;
* a route or protocol used outside the replaceable pre-alpha implementation;
* a security, legal, privacy, audit, or operational requirement.

No compatibility-register entry means compatibility is not required.

In particular, disposition values do not preserve:

* `App\Platform\` namespaces;
* `App\Modules\` namespaces;
* current internal class names;
* `/platform/*` routes;
* current command names;
* current configuration keys;
* current manifest formats;
* current non-UI test layout.

## 8. Relationship To Later Implementation

The later owner determines:

* implementation sequence;
* verification contract;
* exact files;
* worktree and branch;
* detailed namespace changes;
* temporary adapters;
* data migration;
* test replacement;
* cleanup order;
* final deletion.

The later implementation issue must preserve the accepted disposition unless a new accepted architecture decision revises it.

A later owner may refine implementation details without reopening Goal 3 when:

* the accepted owner remains unchanged;
* the direction remains unchanged;
* no new compatibility obligation is introduced;
* no prohibited dependency or generic owner is created.

## 9. Matrix Usage Rules

For each current-to-target matrix row:

1. use one primary disposition;
2. keep target ownership explicit;
3. record preservation separately;
4. assign a later owner;
5. place implementation qualifications in Notes;
6. do not imply physical authorization;
7. do not use a generic target to avoid a decision;
8. do not create compatibility through wording.

A row is invalid when:

* it uses multiple dispositions;
* its target lists several unresolved alternatives;
* its target owner is generic or ownerless;
* its preservation basis is unsupported;
* its later owner is missing;
* it authorizes immediate deletion or migration;
* it treats current placement as target authority.

## 10. Examples

| Current pattern              | Primary disposition | Reason                                                               |
| ---------------------------- | ------------------- | -------------------------------------------------------------------- |
| `app/Core/Runtime/`          | Retain              | Core Runtime remains a valid capability and target path              |
| `app/Platform/Shell/`        | Split               | Current responsibilities divide among several accepted owners        |
| `Modules/Auth/`              | Extract             | Required Core behavior is contained inside an invalid Module package |
| root capability Controller   | Move                | Coherent Delivery responsibility moves owner-local                   |
| `PlatformLogger`             | Replace             | Logging remains necessary but the abstraction is rejected            |
| obsolete Docs Viewer         | Remove later        | No target application responsibility remains                         |
| duplicate UI implementations | Merge               | Several current implementations converge into one accepted artifact  |
| transitional route name only | Rename              | Use only when route ownership and behavior remain otherwise stable   |

## 11. Proposed Decision

Accept the Phase 7 migration-classification contract as follows:

* one controlled primary disposition per matrix row;
* secondary implementation actions recorded in Notes;
* disposition separate from preservation and compatibility;
* `Retain` preserves the accepted owner or structural role, not necessarily implementation;
* `Split` governs mixed current patterns;
* `Extract` governs required capabilities leaving false Module packages;
* `Replace` governs necessary behavior whose implementation model is rejected;
* `Remove later` requires separately accepted cleanup;
* `Decision blocked` is reserved for unresolved target authority;
* detailed migration remains later-owner work.

## 12. Validation

Before acceptance:

* confirm every matrix row uses one controlled disposition;
* confirm no combined dispositions remain;
* confirm every disposition matches the definitions in this document;
* confirm Notes capture secondary treatment where needed;
* confirm preservation bases remain separate;
* confirm compatibility remains exception-only;
* confirm later owners remain explicit;
* confirm no classification authorizes physical migration;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 13. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Accepted disposition vocabulary:
* Required corrections:
* Matrix rows corrected:
* Compatibility implications:
* Validation evidence:
* Downstream handoff:

## 14. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.1 Current-To-Target Mapping Scope](7-1-current-to-target-mapping-scope.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
