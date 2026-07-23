<!--
DOC-META
title: Phase 7.1 Current-To-Target Mapping Scope
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-1-current-to-target-mapping-scope.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the pattern-level mapping scope, default preservation policy, matrix fields, exclusions, and completion rules for the Goal 3 Phase 7 current-to-target direction map.
-->

# Phase 7.1 Current-To-Target Mapping Scope

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Define the scope and granularity of the Goal 3 Phase 7 current-to-target direction map.

The map must show how material current repository patterns relate to the accepted Goal 3 architecture without becoming:

* a file-by-file inventory;
* a detailed migration sequence;
* an implementation plan;
* a broad compatibility-preservation exercise;
* a substitute for decisions owned by Goals 4 through 10.

Phase 7 defines migration direction. It does not perform the physical migration.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Physical migration authorized: no
* Compatibility implementation authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on: accepted Goal 3 Phases 1 through 6

## 3. Decision

Phase 7 will use a **pattern-level current-to-target direction map**.

The normal mapping unit is one:

* major subtree;
* repeated placement pattern;
* cohesive responsibility group;
* transitional architecture area;
* conventional Laravel integration boundary;
* reusable UI ownership pattern;
* verified compatibility subject.

The map will not enumerate every current file or class.

Mixed current areas must be divided until each mapping has one understandable target direction.

Current implementation is evidence of what exists. It is not permanent target authority.

## 4. Default Preservation Policy

Login 2.0 remains a pre-alpha application.

Current non-UI application implementation is disposable by default.

The normal Phase 7 result is:

```text
Implementation preservation: none
Compatibility: none
Disposition: replace, split, extract, move, rename, or remove later
```

This default applies to unfinished internal:

* PHP classes and namespaces;
* routes and URLs;
* configuration keys;
* database structures;
* service and manager abstractions;
* Registry implementations;
* feature views;
* shell and navigation composition;
* Core and Module implementations;
* internal scripts or tooling without continuing value.

Phase 7 does not authorize immediate deletion. It records the direction for later bounded work.

## 5. Preservation Exceptions

Preservation is required only when there is a concrete reason.

### 5.1. Accepted UI Contracts

Preserve accepted public UI contracts by default, including applicable:

* Elements;
* Components;
* Patterns;
* Layouts;
* shell APIs and `ui-shell*` classes;
* Blade aliases;
* tokens;
* data attributes;
* JavaScript initialization APIs;
* machine-readable `contract.php` contracts;
* accessibility and interaction requirements;
* accepted tests, fixtures, examples, and rendered evidence.

Physical placement may still change. Public UI behavior and APIs remain protected unless Goal 5 or another accepted UI decision authorizes a change.

### 5.2. Useful Repository Tooling

Retain or deliberately migrate repository tooling that continues to provide value, including applicable:

* development-environment configuration;
* Composer, npm, Laravel, Vite, and Docker setup;
* documentation guardrails;
* inventory and evidence tooling;
* formatters and static checks;
* reusable test infrastructure;
* CI workflows;
* generators and validators that match the target architecture.

Tooling is reviewed separately from obsolete application implementation.

### 5.3. Behavior And Evidence

Preserve required behavior, proof, and knowledge even when replacing the implementation.

Examples include:

* authentication and MFA outcomes;
* authorization rejection behavior;
* Tenant isolation;
* audit and monitoring requirements;
* security and data-protection behavior;
* lifecycle requirements;
* accessibility requirements;
* accepted characterization tests;
* canonical architecture and current-state evidence.

The implementation may be replaced while the requirement and proof remain authoritative.

### 5.4. Verified Consumers Or Persisted References

Compatibility may be required when supported by a concrete:

* external integration;
* public protocol;
* externally used route or URL;
* persisted identifier;
* retained data set;
* accepted public Contract;
* repository tool that cannot be changed atomically;
* security, legal, privacy, audit, or operational requirement.

Internal usage or filesystem presence alone does not establish a preservation requirement.

## 6. Mapping Granularity

Appropriate mapping subjects include:

```text
app/Platform/*
app/Surfaces/*
app/Core/*
app/Http/*
app/Console/*
app/Providers/*
app/Models/*
app/Rules/*
Modules/*
resources/views/platform/*
resources/views/livewire/platform/*
parallel reusable UI asset trees
root feature routes
root feature configuration
owner-local and root test patterns
database lifecycle patterns
application registration patterns
repository scripts and tooling
```

A broad subtree must be split when it contains materially different owners or dispositions.

For example, `app/Platform/` must not receive one undifferentiated mapping if it contains:

* required Core behavior;
* optional Module behavior;
* reusable UI;
* Product presentation;
* Frame composition;
* Laravel integration;
* obsolete compatibility code.

Do not split rows merely because a folder contains multiple files with the same owner, target, and disposition.

## 7. Direction Matrix Fields

The current-to-target direction matrix will use these fields:

| Field                              | Purpose                                                                                 |
| ---------------------------------- | --------------------------------------------------------------------------------------- |
| Mapping ID                         | Stable Phase 7 reference such as `P7-MAP-001`                                           |
| Current pattern and responsibility | What currently exists and what it appears to perform                                    |
| Target owner and pattern           | Accepted owner and structural destination                                               |
| Disposition                        | Retain, move, rename, split, merge, extract, replace, remove later, or decision blocked |
| Preservation basis                 | UI contract, tooling, behavior/evidence, external or persisted dependency, or none      |
| Later owner                        | Goal, issue, capability, Module, UI owner, or migration work responsible for follow-up  |
| Notes                              | Material boundaries, qualifications, or blockers only                                   |

Representative paths may be included within the current-pattern field or notes as evidence.

A separate compatibility-register entry is required only when an actual compatibility obligation exists.

No compatibility-register entry means compatibility is not required.

## 8. Required Mapping Coverage

Phase 7.2 must cover the material current patterns for:

### 8.1. Ownership And Transitional Areas

* `app/Platform`;
* current Core-like responsibilities;
* current generic Surface organization;
* optional behavior in required application areas;
* Global Administration;
* Shell, Navigation, Dashboard, Settings, Preferences, and Setup;
* generic Shared, Common, Support, Service, or Manager areas.

### 8.2. Modules

* current Module packages;
* direct-root Module PHP layouts;
* optional features not yet packaged as Modules;
* Module definitions and dependencies;
* package-local routes, configuration, persistence, presentation, tests, and documentation.

### 8.3. Laravel Integration

* root HTTP and Console integration;
* middleware;
* application-wide Providers;
* root routes and configuration;
* bootstrap behavior;
* Application Registration composition.

### 8.4. UI And Presentation

* accepted reusable UI artifacts;
* parallel CSS and JavaScript trees;
* Product and Page presentation;
* shell and navigation implementation;
* Frame composition;
* UI contracts, references, examples, and evidence;
* duplicate feature-local UI implementation.

### 8.5. Persistence

* root Models and generic persistence;
* Core-owned persistence;
* Module-owned persistence;
* root migrations and seeders;
* Core schema-lifecycle grouping;
* Module package-local database artifacts;
* decisions transferred to Goal 6.

Phase 7 records structural direction only. It does not design schemas or data migration.

### 8.6. Tests, Documentation, Scripts, And Tooling

* owner-local tests;
* Module tests;
* UI artifact tests;
* root integration, browser, architecture, and repository-rule tests;
* canonical and package-local documentation;
* repository scripts;
* inventories, generators, validators, and supporting tooling.

## 9. Excluded Detail

The Phase 7 mapping must not define:

* one disposition per file or class;
* exact future filenames for every artifact;
* detailed namespace rename lists;
* migration waves or implementation order;
* commit or worktree sequencing;
* detailed redirect or adapter designs;
* database column mappings;
* record-level data migration;
* UI redesign;
* complete test rewrites;
* implementation estimates;
* cleanup commands.

Those belong to later Goals and bounded implementation issues.

## 10. Completion Rules

The mapping scope is satisfied when:

1. every material current repository pattern is represented;
2. each row has one target owner, removal direction, or explicit later-owner blocker;
3. mixed-owner areas are divided appropriately;
4. every row uses a controlled disposition;
5. preservation is tied to a concrete basis;
6. compatibility is recorded only for verified obligations;
7. accepted UI public contracts remain protected;
8. useful tooling, behavior, and evidence are not discarded accidentally;
9. transitional placement is not represented as permanent ownership;
10. later implementation can proceed without reopening Goal 3 ownership, placement, dependency, or naming decisions.

The map may retain decisions for later Goals, but every such decision must have an assigned owner.

## 11. Alternatives Not Selected

### File-By-File Mapping

Rejected because it would duplicate inventory work, become difficult to review, and drift into implementation sequencing.

### Preserve-Current-Implementation Mapping

Rejected because the application remains pre-alpha and most non-UI implementation will be redesigned or replaced.

### Compatibility-First Mapping

Rejected because compatibility is exceptional rather than a default requirement.

### Implementation-Wave Mapping

Rejected because detailed sequencing, compatibility implementation, deprecation, and cleanup belong to Goal 9.

## 12. Proposed Acceptance

Accept the following Phase 7.1 direction:

* Mapping granularity: major subtree, repeated pattern, or cohesive responsibility group
* Default non-UI disposition: replace, split, extract, move, rename, or remove later
* Default implementation preservation: none
* Default compatibility: none
* Protected exceptions:

  * accepted UI public contracts;
  * useful repository tooling;
  * required behavior and evidence;
  * verified external or persisted dependencies
* Main direction-matrix fields: seven
* File-by-file disposition and implementation sequencing: excluded

## 13. Validation

Before acceptance:

* confirm Issue #54 requirements are represented;
* confirm the Phase 7 index links to this document;
* confirm the matrix fields are sufficient for Phase 7.2;
* confirm compatibility remains opt-in;
* confirm accepted UI preservation is explicit;
* confirm later-goal decisions remain outside Goal 3;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 14. Acceptance Record

* Outcome: Accepted
* Accepted mapping granularity: Pattern-level major subtree, repeated placement pattern, cohesive responsibility group, transitional architecture area, Laravel boundary, reusable UI pattern, or verified compatibility subject
* Accepted preservation policy: Current non-UI implementation is disposable by default; accepted UI Contracts, useful tooling, required behavior and evidence, and verified external or persisted dependencies remain protected
* Accepted compatibility policy: Opt-in and evidence-based
* Required corrections: None
* Downstream handoff: Phase 7.2 current-to-target placement mappings

## 15. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Goal 3 Index](../index.md)
* [Phase 6 Representative Architecture Validation Index](../phase-6/index.md)
* [Phase 6 Model Acceptance And Corrections](../phase-6/6-8-model-acceptance-and-corrections.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Application Registration](../../../../../03-architecture/application-registration.md)
* [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
