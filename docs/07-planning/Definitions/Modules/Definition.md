<!--
DOC-META
title: Module Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Modules/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines Module ownership, classification, package target state, lifecycle, dependency boundaries, and extension rules within the Login 2.0 architecture.
-->

# Module Definition

Parent: [Modules Index](Index.md)

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

A Module is an optional, cohesive, independently managed feature set that may be installed, enabled, assigned, updated, disabled, or omitted without breaking Core.

Modules may be business-oriented, administrative, operational, analytical, integration-focused, or internal tooling.

Module ownership is determined by optional responsibility and independent lifecycle. It is not determined by current physical placement, route prefix, namespace, package completion, or whether the feature is customer-facing.

## 2. Classification Rule

A responsibility is Module-owned when:

* it represents a cohesive feature or product capability;
* the base application remains valid and operational without it;
* it has an independent installation, enablement, assignment, update, disablement, or omission lifecycle;
* it can own its behavior, state, contracts, dependencies, tests, documentation, and presentation where applicable;
* its dependencies on Core or other Modules can be expressed through public contracts;
* it does not redefine behavior or invariants that must remain authoritative in Core.

Every Module must reach the mandatory target state of an independently versioned, installable, and distributable Composer package.

Package completion is not a prerequisite for classifying transitional implementation as Module-owned. Transitional code may be classified by its target responsibility before its package migration is complete.

A folder under `Modules/` is not automatically Module-owned. Likewise, Module-owned behavior may temporarily exist outside `Modules/` while migration remains incomplete.

## 3. Owns

A Module owns:

* its feature behavior and workflows;
* its feature-specific state and persistence;
* its public contracts and extension points;
* its actions, services, queries, policies, events, listeners, jobs, and notifications where applicable;
* its routes and delivery adapters where applicable;
* its configuration and dependency declarations;
* its presentation and UI contributions;
* its tests, fixtures, and documentation;
* its compatibility requirements and migration rules;
* its Module definition and stable Module identity.

A Module may expose contributions through:

* public contracts;
* events;
* registries;
* actions;
* relationships;
* page sections;
* navigation entries;
* settings pages;
* setup steps;
* dashboard widgets;
* other explicitly declared extension points.

## 4. Must Not Own

A Module must not own:

* required base-application behavior or state;
* Core authentication, authorization, security, audit, governance, data-protection, or lifecycle invariants merely because the Module consumes them;
* reusable UI Elements, Components, Patterns, Layouts, design tokens, icons, or general interaction controls;
* another Module’s internal implementation or private state;
* generic package, registry, contribution, or lifecycle infrastructure owned by Core;
* functionality placed in a Module solely because that Module is its first consumer;
* undeclared cross-Module behavior;
* responsibilities that prevent Core from operating when the Module is absent.

Optionality does not permit a Module to weaken or replace Core invariants.

## 5. Dependency Rules

A Module:

* may depend on Core public contracts;
* may use UI Elements, Components, Patterns, and Layouts;
* may depend on another Module only when the dependency is explicit, version-constrained, declared, validated, and contract-based;
* may extend another Module only through published extension points;
* must declare compatible Core requirements;
* must declare required Module dependencies and version constraints;
* must declare extension relationships and contributions;
* must not import or invoke another Module’s internal implementation;
* must not depend on another Module through physical paths, undocumented classes, database assumptions, or incidental runtime behavior;
* must remain removable without invalidating Core.

Composer owns package installation and version resolution.

Login 2.0 owns runtime enablement, assignment, dependency validation, activation order, extension registration, disable protection, and uninstall protection.

## 6. Target Status

Status: permanent

Modules are a permanent source-of-truth ownership area.

Every Module must reach the mandatory target state of an independently versioned Composer package with:

* a stable Module identity;
* a formal Module definition;
* explicit Core compatibility;
* declared dependencies;
* declared extensions and contributions;
* Module-owned implementation, tests, and documentation.

Current implementations may remain transitional until their package, placement, namespace, migration, and compatibility work is completed through later Goal 03 phases and Goal 09.

Physical placement does not determine Module ownership.

## 7. Accepted Decision

Status: accepted

A Module is defined by cohesive optional responsibility and an independently managed lifecycle.

Every Module must be capable of existing as an independently versioned, installable, and distributable Composer package. This is the mandatory target state, not a prerequisite for classifying transitional implementation.

Core must remain valid and operational when the Module is absent.

## 8. Open Questions

None.

Specific Module identities, package locations, internal structures, naming conventions, and migration order are resolved through later Goal 03 phases and implementation planning without changing this definition.

## 9. Related

* [Modules README](README.md)
* [Modules Index](Index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
* Related GitHub issue: #48

---