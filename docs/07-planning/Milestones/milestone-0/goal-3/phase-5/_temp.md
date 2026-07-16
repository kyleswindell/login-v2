# Phase 5 overview

## Overall goal

Phase 5 converts the accepted Goal 3 architecture into a **deterministic naming system**.

Phases 1–4 established:

* who owns an artifact;
* where it belongs;
* which dependencies are allowed;
* how owners communicate;
* how artifacts are registered.

Phase 5 determines **what each of those artifacts is called** across folders, namespaces, PHP classes, machine identifiers, routes, configuration, tests, documentation, and compatibility mappings. It must apply the accepted architecture without reopening ownership, placement, dependency, or ADR-0007 machine-key decisions.

The intended result is that a future implementation issue can derive an exact target name from:

```text
owner
+ responsibility
+ artifact type
+ public/internal role
+ placement
+ compatibility status
```

without inventing a new naming convention.

Phase 5 is still planning. It does **not** rename files, namespaces, routes, keys, classes, tables, tests, or documentation in the current repository.

---

# What Phase 5 must decide

Issue #52 defines thirteen naming decisions.

## Foundation naming

### 5.1 Folder and namespace naming

Defines:

* folder casing;
* singular versus plural folders;
* folder-to-namespace mapping;
* capability and Module namespace structures;
* prohibited generic names.

This is the foundation for most later decisions.

### 5.2 Core capability naming

Defines one canonical capability identity across:

* folder;
* namespace;
* capability reference;
* tests;
* documentation.

A Core capability should not acquire slightly different names on different repository surfaces.

### 5.3 Module naming

Separates and relates:

* Module display name;
* `module_key`;
* folder name;
* PHP namespace;
* Composer package name;
* route-name root;
* configuration root;
* documentation title.

These are related identifiers, but they are not interchangeable.

### 5.4 Class and interface naming

Defines conventions for:

* interfaces;
* abstract classes;
* traits;
* enums;
* value objects;
* Data Objects;
* exceptions;
* Providers;
* Registries;
* Definitions.

---

## Responsibility and delivery naming

### 5.5 Action, Service, Query, and coordination naming

Defines distinct meanings for suffixes such as:

* `Action`;
* `Query`;
* `Resolver`;
* `Coordinator`;
* `Manager`;
* `Creator`;
* `Handler`;
* `Service`.

This decision should prevent generic classes such as `UserService`, `CommonManager`, or `DataHandler` when the class has a more precise role.

### 5.6 Delivery artifact naming

Defines names for:

* controllers;
* requests;
* middleware;
* presenters;
* renderers;
* ViewModels;
* PageData objects;
* console commands;
* webhook handlers.

The name should communicate both the behavior and the delivery role.

---

## External and machine-visible naming

### 5.7 Route and URL naming

Defines:

* route-name grammar;
* URL-path grammar;
* resource versus domain-action names;
* administrative prefixes;
* Module prefixes;
* compatibility route aliases.

Route names, URLs, controllers, and physical folders remain separate concepts.

### 5.8 Configuration naming

Defines:

* configuration filenames;
* configuration roots;
* nested keys;
* environment-variable names;
* Module configuration names;
* compatibility aliases.

This decision should eliminate generic roots such as `platform.*`.

### 5.9 Event, Listener, Job, Queue, Notification, and Audit naming

Defines the relationship between:

* PHP class names;
* domain-event keys;
* Listener keys;
* Job keys;
* logical queue keys;
* notification identifiers;
* audit-event identifiers.

Machine identifiers and PHP class names should correspond predictably without being treated as the same identifier.

### 5.10 Database naming boundary

Defines only broad repository-facing rules such as:

* Model-to-table expectations;
* migration filename conventions;
* owner visibility;
* broad capability or Module prefixes where necessary.

Goal 6 retains detailed authority over columns, indexes, constraints, foreign keys, and schema-specific exceptions.

---

## Verification, documentation, and migration naming

### 5.11 Test and fixture naming

Defines:

* test class names;
* test method names;
* datasets;
* fixtures;
* factories;
* browser specifications;
* architecture tests.

Names should reveal owner, behavior, condition, and expected result.

### 5.12 Documentation naming

Defines:

* filename casing;
* separators;
* titles;
* canonical paths;
* ADR numbering;
* planning-document names;
* architecture-document names;
* Module documentation names;
* index relationships.

### 5.13 Compatibility and rename rules

Defines:

* when a legacy name may remain;
* how legacy-to-canonical mappings are recorded;
* whether aliases may chain;
* when a rename justifies migration cost;
* which later issue owns removal.

Compatibility aliases should be explicit, bounded, and non-chainable.

---

# Recommended Phase 5 file package

The phase should follow the established Phase 4 structure: one decision document per accepted decision, an index, and consolidated artifacts. Phase 4 already uses a decision register, matrices, a promotion register, and closeout routing, which provides the appropriate structural precedent.

## Required directory

```text
docs/07-planning/Milestones/milestone-0/goal-3/phase-5/
```

## Decision files

```text
5-1-folder-and-namespace-naming.md
5-2-core-capability-naming.md
5-3-module-naming.md
5-4-class-and-interface-naming.md
5-5-action-service-query-and-coordination-naming.md
5-6-delivery-artifact-naming.md
5-7-route-and-url-naming.md
5-8-configuration-naming.md
5-9-event-listener-job-queue-notification-and-audit-naming.md
5-10-database-naming-boundary.md
5-11-test-and-fixture-naming.md
5-12-documentation-naming.md
5-13-compatibility-and-rename-rules.md
```

These filenames directly correspond to the thirteen decisions in Issue #52.

## Phase index

```text
index.md
```

The final index should contain:

* authority and scope;
* phase status;
* reading order;
* Decision 5.1–5.13 register;
* consolidated deliverables;
* accepted naming summary;
* ADR-0007 boundary;
* Definition synchronization;
* durable-promotion routing;
* Phase 6 handoff;
* closeout checklist;
* Final Acceptance Record requirements.

---

# Consolidated Phase 5 artifacts

## 1. Naming convention matrix

```text
naming-convention-matrix.md
```

This is explicitly required by Issue #52. It should contain at least:

| Field                           | Purpose                                                    |
| ------------------------------- | ---------------------------------------------------------- |
| Artifact type                   | What is being named                                        |
| Owner type                      | Core, Module, UI, Laravel integration, documentation, etc. |
| Canonical naming pattern        | Accepted grammar                                           |
| Valid example                   | Correct representative name                                |
| Invalid example                 | Rejected name and reason                                   |
| Machine identifier relationship | Where applicable                                           |
| Physical-path relationship      | Where applicable                                           |
| Compatibility rule              | Whether legacy aliasing is permitted                       |
| Naming authority                | Phase 5, ADR, standard, Goal 6, or owner Contract          |
| Future enforcement              | Candidate lint or architecture check                       |
| Source decision                 | Decision 5.x                                               |

This will be the primary lookup artifact for Phase 6 and later implementation work.

## 2. Role terminology matrix

```text
role-terminology-matrix.md
```

This consolidates Decision 5.4 through 5.6 terminology.

Recommended columns:

```text
Term
Required meaning
Expected suffix
Valid use
Invalid use
Nearest competing term
Selection rule
Owner
Example
Source
```

It should distinguish at least:

* Action;
* Query;
* Resolver;
* Coordinator;
* Manager;
* Handler;
* Creator;
* Provider;
* Registry;
* Listener;
* Job;
* Controller;
* Presenter;
* Renderer;
* ViewModel;
* PageData;
* Delivery Adapter.

This prevents the naming matrix from becoming overloaded with long conceptual definitions.

## 3. Module identity matrix

```text
module-identity-matrix.md
```

This records the deterministic transformation among:

```text
display name
module_key
folder
PHP namespace
Composer package
route-name root
configuration root
view namespace
asset identifier
documentation title
```

The issue explicitly requires the relationship among Module naming identities to be recorded.

## 4. Compatibility and rename register

```text
compatibility-and-rename-register.md
```

This should record accepted naming exceptions and migration handoffs without mapping every current file.

Recommended fields:

```text
legacy name
canonical name
identifier family
owner
reason retained
alias permitted
alias chain prohibited
compatibility surface
removal condition
removal owner
later issue or goal
verification
status
```

This register should contain only material compatibility classes or accepted mappings, not a comprehensive current-file migration inventory.

## 5. Durable promotion register

```text
durable-promotion-register.md
```

This should route accepted Phase 5 results to their eventual durable owners, such as:

* repository architecture;
* coding standards;
* route standards;
* event and queue standards;
* configuration standards;
* testing standards;
* documentation standards;
* reusable Definitions;
* applicable `AGENTS.md`;
* later static enforcement.

As with Phase 4, the register should distinguish:

```text
planning accepted
durable wording drafted
repository application pending
later implementation
future enforcement
```

---

# Minimum required files versus full recommended package

## Minimum issue-compliant package

```text
phase-5/
├── index.md
├── 5-1-folder-and-namespace-naming.md
├── 5-2-core-capability-naming.md
├── 5-3-module-naming.md
├── 5-4-class-and-interface-naming.md
├── 5-5-action-service-query-and-coordination-naming.md
├── 5-6-delivery-artifact-naming.md
├── 5-7-route-and-url-naming.md
├── 5-8-configuration-naming.md
├── 5-9-event-listener-job-queue-notification-and-audit-naming.md
├── 5-10-database-naming-boundary.md
├── 5-11-test-and-fixture-naming.md
├── 5-12-documentation-naming.md
├── 5-13-compatibility-and-rename-rules.md
└── naming-convention-matrix.md
```

## Recommended complete package

```text
phase-5/
├── index.md
├── 5-1-folder-and-namespace-naming.md
├── 5-2-core-capability-naming.md
├── 5-3-module-naming.md
├── 5-4-class-and-interface-naming.md
├── 5-5-action-service-query-and-coordination-naming.md
├── 5-6-delivery-artifact-naming.md
├── 5-7-route-and-url-naming.md
├── 5-8-configuration-naming.md
├── 5-9-event-listener-job-queue-notification-and-audit-naming.md
├── 5-10-database-naming-boundary.md
├── 5-11-test-and-fixture-naming.md
├── 5-12-documentation-naming.md
├── 5-13-compatibility-and-rename-rules.md
├── naming-convention-matrix.md
├── role-terminology-matrix.md
├── module-identity-matrix.md
├── compatibility-and-rename-register.md
└── durable-promotion-register.md
```

That produces **19 Phase 5 files**:

```text
13 decision documents
1 index
5 consolidated artifacts
```

---

# Existing files Phase 5 will eventually update

These should not all be changed at the beginning. They are closeout or promotion targets after the relevant decisions are accepted.

## Goal 3 synthesis and routing

```text
docs/07-planning/Milestones/milestone-0/goal-3/index.md
docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md
```

The target architecture must receive the accepted Phase 5 naming summary and matrix links because Issue #52 explicitly requires Phase 5 results to be added to that artifact.

## Likely reusable Definition updates

Depending on accepted decisions:

```text
docs/07-planning/Definitions/Index.md
docs/07-planning/Definitions/Core/Definition.md
docs/07-planning/Definitions/Modules/Definition.md
docs/07-planning/Definitions/Technical-Roles/Definition.md
docs/07-planning/Definitions/Actions/Definition.md
docs/07-planning/Definitions/Queries/Definition.md
docs/07-planning/Definitions/Contracts/Definition.md
docs/07-planning/Definitions/Data-Objects/Definition.md
docs/07-planning/Definitions/Events/Definition.md
docs/07-planning/Definitions/Listeners/Definition.md
docs/07-planning/Definitions/Jobs/Definition.md
docs/07-planning/Definitions/Providers/Definition.md
docs/07-planning/Definitions/Registries/Definition.md
docs/07-planning/Definitions/Contributions/Definition.md
docs/07-planning/Definitions/Application-Registration/Definition.md
```

These should receive exact accepted naming only where the Definition owns that terminology.

## Likely architecture promotion

```text
docs/03-architecture/repository-architecture.md
docs/03-architecture/application-registration.md
docs/03-architecture/index.md
```

These may need final names for previously conceptual labels such as:

* Owner Registration Descriptor;
* Registration Compiler;
* Compiled Registration Manifest;
* Root Application Registrar;
* Typed Registrar families.

Phase 4 intentionally deferred exact names to Phase 5.

## Later standards promotion

Likely destinations include:

```text
docs/02-standards/coding/
docs/02-standards/routes/
docs/02-standards/database/
docs/02-standards/testing/
docs/02-standards/documentation/
```

Updating every standard is explicitly outside Phase 5’s required scope. The phase should identify and route required promotions rather than rewriting all standards immediately.

---

# Recommended decision order

The issue lists the decisions numerically, but the most efficient review sequence is:

## Pass 1 — Naming foundation

```text
5.1 Folder and namespace naming
5.2 Core capability naming
5.3 Module naming
5.4 Class and interface naming
```

These establish casing, identity transformations, and base suffix rules.

## Pass 2 — Responsibility names

```text
5.5 Action, Service, Query, and coordination naming
5.6 Delivery artifact naming
```

These rely on the folder, namespace, and class rules.

## Pass 3 — Machine-visible names

```text
5.7 Routes and URLs
5.8 Configuration
5.9 Events, Listeners, Jobs, queues, notifications, and audit
5.10 Database boundary
```

These must preserve ADR-0007 identifiers and keep code names separate from machine keys.

## Pass 4 — Supporting artifacts and migration

```text
5.11 Tests and fixtures
5.12 Documentation
5.13 Compatibility and rename rules
```

## Pass 5 — Consolidation and promotion

```text
naming-convention-matrix.md
role-terminology-matrix.md
module-identity-matrix.md
compatibility-and-rename-register.md
durable-promotion-register.md
index.md
Goal 3 synthesis updates
```

---

# Phase 5 completion standard

Phase 5 is ready for closeout when:

* all thirteen decisions are accepted;
* every material artifact type has a canonical naming pattern;
* valid and invalid examples are recorded;
* Module naming identities have deterministic transformations;
* overlapping suffixes have distinct meanings;
* code names and machine identifiers remain separate;
* ADR-0007 grammar is not reopened;
* compatibility aliases are explicit and non-chainable;
* Goal 6 database authority remains protected;
* the naming matrix contains no unresolved owner decision;
* Phase 6 can construct representative examples without inventing a name;
* documentation guardrails and `git diff --check` pass;
* the repository owner completes the Issue #52 Final Acceptance Record.

The appropriate first working document is:

```text
docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-1-folder-and-namespace-naming.md
```

Decision 5.1 should establish the controlled naming vocabulary and transformations consumed by every later Phase 5 decision.
