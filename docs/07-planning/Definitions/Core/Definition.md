<!--
DOC-META
title: Core Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Core/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines Core ownership, classification, dependency boundaries, and target status within the Login 2.0 architecture.
-->

# Core Definition

Parent: [Core Index](Index.md)

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

Core owns the required base-application behavior, state, coordination, infrastructure, contracts, persistence, and lifecycle rules that must remain available when no optional Modules are installed.

Core ownership is determined by architectural necessity and authoritative responsibility. It is not determined by whether a capability is always enabled, visible to every user, or executed during every request.

## 2. Classification Rule

A responsibility is Core-owned when one or more of the following are true:

* the base application cannot operate correctly or securely without it;
* it defines authoritative application-wide behavior or state;
* it enforces an invariant that optional Modules must obey;
* it coordinates application composition or lifecycle;
* it provides infrastructure or contracts that optional Modules consume rather than recreate;
* it owns required base-application persistence or lifecycle rules;
* it presents or delivers behavior whose underlying responsibility is Core-owned.

A responsibility may remain Core-owned even when:

* only administrators can access it;
* access is conditional on authorization;
* it is disabled in a particular environment;
* it is not used during every request;
* its presentation is not visible to every application user.

## 3. Owns

Core owns:

* authoritative base-application capabilities;
* application-wide coordination and composition;
* Module lifecycle and contribution infrastructure;
* required registries and contribution discovery;
* required authentication, identity, access, security, governance, audit, and monitoring behavior;
* required shell, navigation, dashboard, setup, settings, and preference behavior;
* public contracts consumed by Modules;
* required internal operational tooling;
* required base-application persistence and lifecycle rules;
* Core-owned delivery adapters and presentation surfaces.

## 4. Must Not Own

Core must not own:

* optional feature sets that may be omitted without breaking the base application;
* reusable UI Elements, Components, Patterns, Layouts, design tokens, icons, or general interaction controls;
* Module-specific records, workflows, state, or extension behavior;
* functionality placed in Core solely because multiple Modules use it;
* generic utilities or shared code without an explicit Core responsibility.

Shared use does not by itself make a responsibility Core-owned.

## 5. Dependency Rules

Core:

* may depend on Laravel and required infrastructure integrations;
* may expose public contracts for Modules;
* may use UI from Core-owned presentation code;
* may depend on other Core public contracts where the dependency is explicit;
* must operate when no optional Modules are installed;
* must not import, require, or directly invoke optional Module implementation;
* must not depend on Module-owned internal contracts or state;
* must keep business and system logic independent of Blade, CSS, JavaScript, and UI implementation contracts.

## 6. Target Status

Status: permanent

Core is a permanent source-of-truth ownership area.

Its target physical organization, folder structure, namespace structure, and detailed artifact placement are defined by later Goal 03 phases.

Current physical placement does not determine Core ownership.

## 7. Accepted Decision

Status: accepted

A responsibility is Core-owned when it represents architecturally required or authoritative base-application behavior, state, coordination, infrastructure, or contracts that optional Modules must consume rather than recreate.

Core classification is based on architectural necessity and ownership, not universal visibility, constant execution, packaging, or physical placement.

## 8. Open Questions

None.

Whether a specific existing or planned capability satisfies the Core classification rule is resolved during later capability mapping and migration planning without changing this definition.

## 9. Related

* [Core README](README.md)
* [Core Index](Index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* Related GitHub issue: #48
