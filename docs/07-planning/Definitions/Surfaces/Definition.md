<!--
DOC-META
title: Surface Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Surfaces/Definition.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Surface as an assembled interaction boundary through which Core- or Module-owned application behavior is exposed.
-->

# Surface Definition

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

A Surface is a distinct assembled interaction boundary through which application behavior is exposed to a user, operator, system, or external caller.

A Surface is defined by how behavior is encountered or accessed. It does not determine who owns the underlying behavior.

Core and Modules retain ownership of the behavior, state, contracts, authorization, persistence, and lifecycle exposed through a Surface. UI owns reusable presentation infrastructure used to render interactive Surfaces.

## 2. Classification Rule

An interface is a Surface when it provides:

* a recognizable entry point;
* a defined audience or caller;
* a consistent interaction or response model;
* assembled behavior or content supplied by one or more owners.

A Surface may include multiple routes, views, endpoints, commands, or contribution regions when they form one coherent interaction boundary.

A single route, view, controller, component, or invocation channel is not automatically a Surface.

## 3. Owns

A Surface may own:

* interaction-level composition;
* entry-point organization;
* channel-specific presentation or response structure;
* navigation or interaction flow within the Surface;
* adaptation of owner-supplied behavior into the Surface experience;
* integration of contributions from multiple owners;
* Surface-specific documentation and review requirements.

Examples include:

* the authenticated Dashboard;
* the Settings area;
* the Account area;
* the Global Administration interface;
* a public API;
* an operator-facing command interface.

## 4. Must Not Own

A Surface must not own:

* authoritative business or system behavior;
* Core or Module state;
* persistence rules;
* authorization policy;
* reusable UI infrastructure;
* Module lifecycle or discovery;
* behavior solely because it is exposed through the Surface;
* another owner’s internal implementation.

A Surface is not:

* a fourth source-of-truth owner;
* automatically a repository folder;
* synonymous with a route or Blade view;
* synonymous with an invocation channel;
* a substitute for Core, Module, or UI ownership.

## 5. Dependency Rules

A Surface:

* may consume public contracts from Core and Modules;
* may use reusable UI contracts for interactive presentation;
* may assemble contributions from multiple owners;
* may adapt behavior to web, API, command, or other interaction models;
* must not access owner internals;
* must not move authoritative behavior into presentation or delivery code;
* must preserve the authorization and lifecycle rules defined by the behavior owner.

Core and Modules must remain usable independently of a particular Surface unless that Surface is explicitly part of their public contract.

## 6. Target Status

Status: permanent

Surface is a permanent architecture concept.

A Surface is not a canonical ownership area alongside Core, Modules, and UI.

The physical organization of Surface-specific adapters, presentation, routes, and documentation is defined by later Goal 03 phases.

The same Surface definition may apply across multiple repository and documentation locations.

## 7. Accepted Decision

Status: accepted

A Surface is the assembled interaction boundary through which application behavior is exposed.

It is broader than an individual route, view, endpoint, or command, but narrower than an architecture owner.

A Surface may combine behavior from multiple owners while every underlying responsibility retains exactly one primary Core, Module, or UI owner.

## 8. Open Questions

The following decisions remain deferred:

* which Surfaces require dedicated physical repository locations;
* which Surface adapters remain colocated with their Core or Module owner;
* how interactive, API, command, webhook, and background interaction boundaries are physically organized;
* which Surface-specific naming conventions apply.

These questions are owned by later Goal 03 phases and do not change this definition.

## 9. Related

* [Temporary Surfaces README](../../temp/Surfaces/README.md)
* [Definitions Index](../Index.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0006: Tenant, Instance, Workspace, Principal, And Invocation Vocabulary](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
* Related GitHub issue: #48
