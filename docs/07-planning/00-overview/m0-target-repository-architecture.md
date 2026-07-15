<!--
DOC-META
title: M0 Target Repository Architecture
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/00-overview/m0-target-repository-architecture.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the accepted target ownership boundaries, repository organization, topology, placement, dependency, naming, validation, and migration direction for M0 Goal 03.
-->

# M0 Target Repository Architecture

Parent: [Planning Index](../index.md)

Related GitHub issues:

* Parent goal: [#19 — M0 Goal 03: Target repository topology and naming](https://github.com/kyleswindell/login-v2/issues/19)
* Active phase: [#48 — Confirm repository architecture boundaries](https://github.com/kyleswindell/login-v2/issues/48)

## 1. Purpose

Define and accept the target repository architecture for Login 2.0.

This document establishes the ownership boundaries, repository organization, target folder and namespace structure, artifact placement rules, dependency direction, naming conventions, architecture validation, and high-level migration direction that later refactor and implementation work must follow.

The completed architecture must allow a future issue to determine, without making additional repository-structure decisions:

* which architecture area owns a responsibility;
* where its contracts and implementation belong;
* which dependencies are permitted;
* how its folders, namespaces, classes, routes, configuration, tests, and documentation are named;
* what compatibility or migration treatment is required.

This document defines the target destination. It does not perform the physical repository refactor, implement compatibility layers, or replace the specialized decisions owned by later M0 goals.

Goal 03 is completed through seven ordered phases:

1. confirm architecture boundaries;
2. choose the primary repository organization;
3. define the target repository tree;
4. define placement and dependency rules;
5. define naming conventions;
6. validate the model against representative examples;
7. document migration direction and accept the final architecture.

Accepted durable architecture decisions produced through this plan must be promoted to the appropriate architecture, standards, agent-guidance, or verification owners rather than remaining solely in planning.


## 6. Phase 1 — Architecture Boundaries

### 6.1 Core Boundary

#### Definition

Core owns the required base-application behavior, state, coordination, infrastructure, contracts, persistence, and lifecycle rules that must remain available when no optional Modules are installed.

Core ownership is determined by architectural necessity and authoritative responsibility. It is not determined by whether a capability is always enabled, visible to every user, or executed during every request.

