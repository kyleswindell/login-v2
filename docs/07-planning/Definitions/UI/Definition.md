<!--
DOC-META
title: UI Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/UI/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines UI ownership, classification, presentation boundaries, dependency rules, and target status within the Login 2.0 architecture.
-->

# UI Definition

Parent: [Definitions Index](../Index.md)

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

UI owns the reusable application interface system and its presentation-only contracts.

UI provides reusable visual, structural, accessibility, and interaction behavior that Core capabilities and Modules consume when presenting their own routes, state, workflows, and content.

UI ownership is determined by reusable presentation responsibility. It is not determined by whether a file is Blade, CSS, JavaScript, or located under `resources/`.

## 2. Classification Rule

A responsibility is UI-owned when:

* its primary purpose is reusable presentation or interaction;
* it can be consumed by more than one Core capability or Module;
* it renders from data and decisions supplied by its consumer;
* it does not query persistence or resolve domain state;
* it does not make authorization, routing, lifecycle, or business decisions;
* it does not depend on Core or Module implementation.

A UI-owned artifact may express loading, empty, error, validation, disabled, expanded, selected, or other presentation states when those states are supplied through its public contract.

A routed, stateful, authorized, or capability-specific presentation remains owned by the Core capability or Module whose behavior it presents.

## 3. Owns

UI owns:

* Elements;
* Components;
* Patterns;
* reusable Layouts;
* design tokens;
* icons;
* reusable CSS;
* reusable JavaScript interaction controls;
* presentation-only contracts and data shapes;
* accessibility behavior intrinsic to reusable UI;
* reusable loading, empty, error, and interaction-state presentation;
* UI-specific tests;
* examples, references, and review evidence.

UI owns reusable layout and shell components such as:

* headers;
* sidebars;
* menus;
* breadcrumbs;
* tabs;
* page structure;
* content regions.

UI does not determine the capability-specific data or actions rendered inside those components.

## 4. Must Not Own

UI must not own:

* routed pages or URL behavior;
* capability-specific page content or composition;
* authorization or permission resolution;
* database access, queries, or mutations;
* Core or Module lifecycle rules;
* Module discovery;
* contribution aggregation;
* navigation filtering;
* active context or active route resolution;
* feature-specific state or workflows;
* business decisions merely because their result is displayed visually.

UI must not become a universal application layer that hides or replaces explicit Core and Module ownership.

## 5. Dependency Rules

UI:

* may depend on Laravel presentation APIs;
* may depend on Blade and browser APIs;
* may depend on other public UI contracts;
* may accept already-resolved labels, URLs, actions, states, and display data;
* may expose reusable contracts consumed by Core and Modules;
* must not depend on Core or Module domain implementation;
* must not query models, registries, permissions, routes, or persistence;
* must not resolve authorization, ownership, lifecycle, or business state.

Core presentation and Modules may depend on UI.

UI must not depend back on their implementation.

For authenticated application composition:

* UI owns reusable layout and shell rendering;
* Core owns navigation data, contribution aggregation, active-state resolution, authorization filtering, and application composition.

## 6. Target Status

Status: permanent

UI is a permanent source-of-truth ownership area.

Its target physical organization, folder structure, namespace structure, asset placement, and detailed contract placement are defined by later Goal 03 phases.

Current physical placement under `resources/`, `app/`, or another folder does not determine UI ownership.

## 7. Accepted Decision

Status: accepted

UI is the permanent owner of reusable presentation infrastructure and presentation-only contracts.

Core and Modules retain ownership of routed, stateful, authorized, or capability-specific presentation.

Physical placement under `resources/` does not determine UI ownership.

## 8. Open Questions

None.

Specific placement, naming, contract structure, and migration decisions are resolved through later Goal 03 phases without changing this definition.

## 9. Related

* [UI README](../../UI/README.md)
* [UI Index](../../UI/Index.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* Related GitHub issue: #48
