<!--
DOC-META
title: Phase 2 Repository Organization Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the resolved Goal 3 Phase 2 repository-organization decisions, supporting decision records, documentation follow-up, and Phase 3 handoff.
-->

# Phase 2 Repository Organization Index

Parent: [Goal 3 Index](../index.md)

Use this index to navigate the resolved Goal 3 Phase 2 repository-organization decisions and their required documentation follow-up.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Status](#3-status)
- [4. Documents](#4-documents)
- [5. Resolved Phase 2 Direction](#5-resolved-phase-2-direction)
- [6. Resulting Documentation Work](#6-resulting-documentation-work)
  - [6.1. Definition Work](#61-definition-work)
    - [Organization And Extension Concepts](#organization-and-extension-concepts)
    - [Shared Technical Roles](#shared-technical-roles)
  - [6.2. Capability And Module Contracts](#62-capability-and-module-contracts)
  - [6.3. Existing Documentation To Update](#63-existing-documentation-to-update)
- [7. Downstream Handoff](#7-downstream-handoff)
- [8. Verification And Closeout](#8-verification-and-closeout)
- [9. Subfolders](#9-subfolders)
- [10. Maintenance Notes](#10-maintenance-notes)
- [11. Related](#11-related)

## 1. Purpose

Phase 2 defines the primary organizational model that Login 2.0 will use before Phase 3 defines the target repository tree.

This index routes:

* the resolved decisions from 2.1 through 2.5;
* the corrective Surface reclassification recorded as 2.90;
* the full planning document for each decision;
* the definitions and owner-specific documentation required by the decisions;
* the accepted constraints handed to Phase 3.

The detailed child documents remain the full Phase 2 records for their individual subjects.

## 2. Scope

### 2.1. Belongs Here

This folder owns the resolved Phase 2 planning for:

* the primary repository organizing principle;
* secondary organization within Core capabilities and Modules;
* ownership of cross-cutting technical code;
* delivery-code organization;
* mandatory structural boundaries;
* structural exceptions;
* the distinction between UI Surfaces and Host Registries;
* Phase 2 documentation synchronization and closeout.

### 2.2. Does Not Belong Here

This folder does not own:

* the complete target repository tree;
* exact physical paths or namespaces;
* detailed artifact-placement rules;
* final folder, namespace, or file naming conventions;
* current-to-target file mappings;
* physical repository migration;
* Registry discovery implementation;
* contribution manifest implementation;
* dependency-enforcement tooling;
* active GitHub delivery status.

Those concerns belong to later Goal 3 phases, bounded implementation issues, or their applicable canonical owners.

## 3. Status

* Planning lifecycle: active
* Acceptance state: Decisions 2.1 through 2.5 and 2.90 are resolved through repository-owner review.
* Implementation state: planning and documentation only
* Owning GitHub issue: #49
* Parent GitHub issue: #19
* Downstream GitHub issue: #50
* Formal closeout: pending documentation synchronization, validation, and completion of the Issue #49 Final Acceptance Record
* Required final reviewer: repository owner

## 4. Documents

| Document                                                                                                  | Purpose                                                                                                                | Status  |
| --------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- | ------- |
| [2.1 Primary Organizing Principle](2.1%20Primary%20Organizing%20Principle.md)                             | Records the owner-first, capability-first primary organization decision.                                               | planned |
| [2.2 Secondary Organization Within Each Owner](2.2%20Secondary%20Organization%20Within%20Each%20Owner.md) | Records the shared sparse technical-role vocabulary used beneath Core capabilities and Modules.                        | planned |
| [2.3 Cross-Cutting Technical Code](2.3%20Cross-Cutting%20Technical%20Code.md)                             | Records how broadly consumed technical behavior retains one explicit responsibility owner.                             | planned |
| [2.4 Delivery-Code Organization](2.4%20Delivery-Code%20Organization.md)                                   | Records how web, API, console, webhook, and presentation delivery code follows behavior ownership.                     | planned |
| [2.5 Structural Consistency And Exceptions](2.5%20Structural%20Consistency%20And%20Exceptions.md)         | Records mandatory structural boundaries, normal variation, and the bounded exception policy.                           | planned |
| [2.90 Surface Reclassification](2-90-surface-host-registry-reclassification.md)                          | Corrects the earlier Surface model by separating UI presentation from Host Registry and contribution responsibilities. | planned |

## 5. Resolved Phase 2 Direction

| Decision                                  | Resolved Direction                                                                                                                               |
| ----------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| 2.1 Primary Organizing Principle          | Login 2.0 uses owner-first, capability-first organization. Technical role is secondary to owner and capability.                                  |
| 2.2 Secondary Organization                | Core capabilities and Modules use the same sparse technical-role vocabulary. Role definitions do not require universal folder presence.          |
| 2.3 Cross-Cutting Technical Code          | Cross-cutting use does not create cross-cutting ownership. Every responsibility retains one explicit owner.                                      |
| 2.4 Delivery-Code Organization            | Delivery adapters remain beneath the Core capability or Module that owns the behavior they expose.                                               |
| 2.5 Structural Consistency And Exceptions | Shared ownership and role boundaries are mandatory; identical folder trees are not. Actual exceptions are bounded and repository-owner accepted. |
| 2.90 Surface Reclassification             | A Surface is an owner-specific UI presentation layer. A Host-owned Registry defines and resolves contributions from other owners.                |

The consolidated Phase 2 rule is:

> Login 2.0 uses owner-first, capability-first organization. Core capabilities and Modules use the same sparse technical-role vocabulary beneath their owner boundary. Cross-cutting use does not create cross-cutting ownership. Delivery adapters remain with the owner of the behavior they expose. Structural variation is permitted when accepted role meanings and ownership boundaries remain intact; actual exceptions require bounded repository-owner acceptance. A Surface is an owner-specific UI presentation layer, while a Host-owned Registry defines and resolves contributions from other owners.

## 6. Resulting Documentation Work

### 6.1. Definition Work

Phase 2 requires the following reusable concepts and technical roles to be created, updated, or explicitly assigned.

#### Organization And Extension Concepts

- Technical Role
- Delivery Adapter
- Host
- Registry
- Extension Point
- Contribution
- Contributor
- Surface — updated through Decision 2.90

#### Shared Technical Roles

- Action and the working `Actions/` role
- Query and the working `Queries/` role
- Contract and the working `Contracts/` role
- Data Object and the working `Data/` role
- Model and the working `Models/` role
- Policy and the working `Policies/` role
- Event and the working `Events/` role
- Listener and the working `Listeners/` role
- Job and the working `Jobs/` role
- Notification and the working `Notifications/` role
- Provider and the working `Providers/` role
- Registry and the working `Registry/` role
- Surface and the working `Surface/` role
- Contribution and the working `Contrib/` role
- HTTP Delivery Adapter and the working `Http/` role
- Console Delivery Adapter and the working `Console/` role
- Webhook Delivery Adapter

The reusable definitions establish meaning, ownership, permitted contents, prohibited contents, and dependency boundaries. They do not require every capability or Module to contain every technical role.

`Contrib/`, `Http/`, `Console/`, and any future webhook folder are working physical labels. Their final placement, casing, namespaces, and naming belong to Goal 3 Phases 3 through 5.

Controller, Request, API Resource, PageData, ViewModel, Presenter, Renderer, and other subordinate delivery or presentation roles are assigned to Phase 4 placement review and do not block Phase 2 definition closeout.

Capability- and Module-specific required folders and files remain owned by the applicable Feature Spec or other accepted owner-specific contract.

### 6.2. Capability And Module Contracts

Shared role definitions explain meaning and boundaries. They do not require universal folder presence.

Each capability or Module contract must declare:

* required folders and files;
* the responsibility of each required artifact;
* public contracts and allowed dependencies;
* required tests and documentation;
* conditions that make an optional role required.

A capability or Module `Feature-Spec.md`, or another accepted owner-specific contract, is the expected owner of these requirements.

### 6.3. Existing Documentation To Update

Phase 2 requires synchronization of:

* the Goal 3 target-repository-architecture artifact;
* the existing Surface definition;
* planning or architecture text that treats Surface as a Registry or delivery channel;
* applicable capability and Module specifications;
* later tree, placement, naming, validation, and migration documents;
* repository-agent instructions after the organizational model becomes durable repository policy.

## 7. Downstream Handoff

Phase 3 consumes the accepted organizational model to define the target repository tree.

Phase 3 may decide the exact physical branches needed to express the model, but it must not reopen:

* owner-first, capability-first organization;
* the shared sparse technical-role vocabulary;
* explicit ownership of cross-cutting responsibilities;
* delivery ownership;
* bounded exception requirements;
* the distinction between Surface, Host, Registry, and Contribution.

## 8. Verification And Closeout

Phase 2 is ready for formal closeout when:

* [X] this index and all six detailed Phase 2 documents use their accepted document formats;
* [X] the Goal 3 target-architecture artifact contains the accepted Phase 2 result;
* [X] the Surface definition is reconciled with Decision 2.90;
* [ ] required definition work is created or explicitly assigned;
* [x] stale conflicting terminology is removed or marked transitional;
* [ ] the parent Goal 3 index routes to this Phase 2 index;
* [ ] `npm run lint:docs:guardrails` passes;
* [ ] `git diff --check` passes;
* [ ] the repository owner completes the Issue #49 Final Acceptance Record.

## 9. Subfolders

This folder has no child subfolders.

Phase 2 decision documents remain direct children because they share:

* one planning phase;
* one GitHub issue;
* one architecture owner;
* one acceptance lifecycle;
* direct lateral relationships.

Definitions and capability-specific documentation created from these decisions belong in their applicable canonical or planning owner packages rather than beneath this folder.

## 10. Maintenance Notes

* Keep this index current when a Phase 2 document is renamed, superseded, archived, or promoted.
* Do not duplicate the detailed option analysis or decision rationale from child documents here.
* Keep the resolved-direction summaries aligned with the detailed child documents.
* Update `DOC-META`, parent links, and child links whenever paths change.
* Route durable definitions, standards, architecture, and Feature Specs to their actual owners.
* Preserve this index as the Phase 2 navigation and consolidation hub after detailed planning is promoted.
* Do not use this index as an active task board.

## 11. Related

* [Goal 3 Index](../index.md)
* [Milestone 0 Index](../../index.md)
* [Milestones Index](../../../index.md)
* [Planning Index](../../../../index.md)
* [Goal 3 Target Repository Architecture](../../../../00-overview/m0-target-repository-architecture.md)
* GitHub issue: #49
* Parent GitHub issue: #19
* Downstream GitHub issue: #50
