<!--
DOC-META
title: Phase 3.3 Conventional Laravel Folder Roles
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-3-conventional-laravel-folder-roles.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records which conventional Laravel folders remain restricted root integration boundaries and which become owner-local roles.
-->

# Phase 3.3 Conventional Laravel Folder Roles

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document defines the target role of conventional Laravel folders beneath `app/`.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: Decision 3.2

## 3. Permanent Restricted Integration Folders

### 3.1. `app/Http/`

Target status: permanent, restricted Laravel integration boundary.

Permitted responsibilities include:

- root or base controllers;
- application-wide middleware;
- trusted-proxy, request-ID, security-header, and similar global integration;
- application-wide HTTP bootstrapping or response integration;
- bounded compatibility adapters requiring root placement.

Owner-specific HTTP artifacts follow their owner:

```text
app/Core/Audit/Http/
app/Core/Identity/Http/
Modules/Example/src/Http/
```

### 3.2. `app/Console/`

Target status: permanent, restricted Laravel integration boundary.

Permitted responsibilities include:

- root console integration;
- application-wide command base classes;
- global command registration or composition;
- repository-wide commands with no more precise application owner;
- bounded compatibility adapters.

Owner-specific commands follow their owner:

```text
app/Core/Audit/Console/
app/UI/Console/
Modules/Example/src/Console/
```

### 3.3. `app/Providers/`

Target status: permanent, restricted Laravel composition boundary.

Permitted responsibilities include:

- `AppServiceProvider`;
- application-wide Laravel bootstrapping;
- root framework composition;
- registration of owner-local providers;
- bounded global compatibility registration.

Owner-specific providers remain with their owner.

## 4. Owner-Local Conventional Roles

These remain valid concepts but do not remain permanent peer `app/` branches:

| Conventional role | Target owner-local meaning                                              |
| ----------------- | ----------------------------------------------------------------------- |
| `Models/`         | State and persistence models owned by a capability or Module            |
| `Jobs/`           | Deferred or queued work owned by the behavior owner                     |
| `Events/`         | Occurrences owned by the capability or Module producing them            |
| `Listeners/`      | Reactions owned by the capability or Module performing them             |
| `Policies/`       | Authorization owned by the protected responsibility                     |
| `Notifications/`  | Owner-specific notification implementations                             |
| `Rules/`          | Validation rules owned by the applicable policy or input owner          |
| `Livewire/`       | Framework-specific Surface or delivery implementation beneath its owner |

Examples:

```text
app/Core/Audit/Models/AuditLog.php
app/Core/Identity/Policies/UserPolicy.php
app/Core/Monitoring/Jobs/ProcessHealthCheck.php
app/Core/Audit/Events/AuditEntryRecorded.php
app/Core/Dashboard/Surface/Livewire/DashboardPage.php
Modules/Example/src/Notifications/ExampleAlert.php
```

## 5. Transitional Conventional Roots

The following are transitional or compatibility-only:

```text
app/Models/
app/Jobs/
app/Events/
app/Listeners/
app/Policies/
app/Notifications/
app/Rules/
app/Livewire/
```

Rules:

- no new canonical owner-specific work may be added;
- existing artifacts must later be reclassified;
- temporary compatibility classes require an accepted exception;
- framework generator defaults do not establish target authority;
- empty conventional folders are not retained merely because Laravel commonly creates them.

## 6. Compatibility Exception

A conventional root file or subtree may remain compatibility-only when movement would break a verified contract such as:

- serialized or queued class names;
- framework configuration;
- authentication model references;
- package integrations;
- policy, factory, seeder, migration, or test references;
- other verified compatibility dependencies.

The exception must identify:

- exact path and owner;
- dependency requiring retention;
- prohibited expansion;
- verification;
- removal condition;
- migration owner.

Compatibility does not make the location permanent.

## 7. Application-Wide Use Does Not Create A Generic Root

Broad use does not justify root technical-layer ownership.

A broadly used:

- Model belongs to the capability owning its state;
- Rule belongs to the capability owning its validation policy;
- Event belongs to the capability owning the occurrence;
- Notification belongs to the capability owning the communication;
- Job belongs to an existing or explicitly named Core capability.

## 8. Accepted Decision

> Login 2.0 retains `app/Http/`, `app/Console/`, and `app/Providers/` as permanent but restricted application-wide Laravel integration boundaries. They may contain root framework integration, base artifacts, global registration, and bounded compatibility code, but they must not become default owners of capability- or Module-specific behavior. Models, Rules, Jobs, Events, Listeners, Policies, Notifications, Livewire components, and similar conventional Laravel roles remain valid only beneath their explicit Core, Module, or UI owner. Existing root folders for those roles are transitional or compatibility-only, are prohibited destinations for new canonical work, and may remain temporarily only through a bounded accepted exception.

## 9. Phase 4 Handoff

Phase 4 decides:

- exact controller, request, resource, and middleware placement;
- exact command placement and registration;
- exact provider composition;
- exact Core route-file location;
- compatibility implementation;
- detailed owner-local placement.

## 10. Related

- [Phase 3 Index](index.md)
- [Target `app/` Branches](3-2-target-app-branches.md)
- [Core Physical Structure](3-4-core-physical-structure.md)
- [Transitional And Prohibited Branches](3-8-transitional-and-prohibited-branches.md)
- Related GitHub issue: #50