<!--
DOC-META
title: Phase 4.12 Exceptions And Future Enforcement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-12-exceptions-and-future-enforcement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the bounded placement and dependency exception policy and the architecture rules assigned to later static or automated enforcement.
-->

# Phase 4.12 Exceptions And Future Enforcement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define when placement or dependency exceptions are permitted and identify rules that require later enforcement.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: policy and enforcement targets only
- Owning GitHub issue: #51
- Later implementation owner: future architecture and verification work

## 3. Permitted Exception Reasons

An exception may be considered only for an exact:

- framework or vendor integration requirement;
- verified compatibility dependency;
- temporary migration constraint;
- serialized, persisted, routed, queued, or externally referenced identifier;
- capability-specific need that cannot follow the default model without greater harm.

Convenience, current placement, broad reuse, reduced migration effort, and framework convention alone do not justify an exception.

## 4. Required Exception Record

Every exception must identify:

- governing rule;
- responsible owner;
- exact files, folders, namespaces, or dependency edge;
- permanent or transitional status;
- verified reason;
- permitted deviation;
- prohibited expansion;
- compatibility impact;
- required verification;
- repository-owner acceptance;
- objective removal condition and migration owner when transitional.

Exceptions do not create precedent outside their declared scope and must not establish a new generic owner.

## 5. Failure And Stop Rule

An unexpected architecture, dependency, discovery, or validation failure is a failure rather than implicit permission to remediate, weaken a rule, or create an exception.

Unless an exact bounded recovery was accepted before execution, work stops and preserves the failure evidence.

## 6. Future Enforcement Priorities

### Repository structure

- accepted direct `app/` branches only;
- no new canonical work in prohibited or transitional roots;
- Module PHP source beneath `src/`;
- required Module metadata and definition;
- significant folder documentation or accepted omission.

### Registration and discovery

- declared files and classes exist;
- duplicate route names, view namespaces, Livewire aliases, configuration keys, and asset entries fail;
- missing declared routes, migrations, views, commands, providers, or assets fail;
- dependency cycles fail;
- compiled registration output is deterministic and current;
- filesystem presence does not silently register canonical artifacts.

### Dependency direction

- Core does not depend on optional Modules;
- cross-owner dependencies target public Contracts;
- Module dependencies are declared and acyclic;
- reusable UI does not import domain implementation;
- application behavior does not depend on Delivery Adapters;
- Contributors do not import Host internals.

### Tests and documentation

- every accepted test location is discovered locally and in CI;
- tests are not silently omitted or duplicated;
- canonical document metadata and routing are valid;
- planning is not presented as durable policy;
- scoped agent guidance does not conflict with architecture.

## 7. Accepted Decision

> Login 2.0 permits placement or dependency exceptions only for an exact framework, vendor, compatibility, migration, or capability-specific constraint that cannot reasonably follow the accepted default architecture. Convenience, current placement, broad reuse, reduced migration effort, or framework convention alone do not justify an exception.
>
> Every exception must identify the governing rule, responsible owner, exact scope, permanent or transitional status, verified reason, permitted deviation, prohibited expansion, compatibility impact, required verification, acceptance authority, and—when transitional—an objective removal condition and migration owner. Exceptions do not create precedent outside their declared scope and must not establish a new generic ownership area.
>
> Repository-owner acceptance is required before an exception becomes authoritative. An unexpected architecture, dependency, discovery, or validation failure is a failure rather than implicit permission to remediate, weaken a rule, or create an exception. Unless an exact bounded recovery was accepted before execution, work stops and preserves the failure evidence.
>
> Later automated enforcement should verify accepted repository branches, owner-local implementation, Module package structure, registration completeness, deterministic compiled manifests, dependency direction, Core independence from optional Modules, declared Module dependencies, UI isolation from domain implementation, owner-local test discovery, documentation routing, and prohibited transitional destinations. Phase 4 identifies these guardrails but does not implement them.

## 8. Boundaries And Handoff

Phase 4 does not implement architecture checks, the registration compiler, dependency analysis, CI jobs, or migration tooling. Later accepted issues must define and execute those proofs.

## 9. Related

- [Dependency Direction](4-10-dependency-direction.md)
- [Cross-Owner Communication](4-11-cross-owner-communication.md)
- [Test Placement](4-8-test-placement.md)
- [Documentation Placement](4-9-documentation-placement.md)
- Related GitHub issue: #51
