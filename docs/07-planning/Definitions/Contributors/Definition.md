<!--
DOC-META
title: Contributor Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Contributors/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Contributor as the Core capability or Module that owns and supplies a Contribution to another Host’s Extension Point.
-->

# Contributor Definition

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

A Contributor is the Core capability or Module that owns and supplies a Contribution to an Extension Point exposed by another Host.

Contributor describes a relationship role performed by an existing application owner. It is not a separate source-of-truth application owner.

The Contributor retains ownership of the behavior, data, authorization, lifecycle, and implementation exposed through its Contribution.

## 2. Classification Rule

A Core capability or Module acts as a Contributor when:

- it owns behavior relevant to another Host’s accepted Extension Point;
- it supplies a Contribution through the Host’s public contract;
- it remains responsible for the contributed behavior;
- it can operate within applicable dependency and compatibility rules;
- the Host Registry may validate and reject the Contribution without accessing Contributor internals.

An owner is not a Contributor merely because the Host calls one of its public contracts.

## 3. Owns

A Contributor owns:

- its underlying behavior;
- its data and persistence;
- its authorization and lifecycle rules;
- its owner-local Contribution artifacts;
- compatibility metadata it declares;
- Contributor-side tests;
- Contributor-side documentation;
- remediation when its Contribution no longer satisfies the Host contract.

The Contributor may expose public Actions, Queries, routes, views, or other behavior referenced by the Contribution when permitted.

## 4. Must Not Own

A Contributor must not own:

- the Host Registry;
- the Host’s Extension Point contract;
- Host-wide ordering or conflict policy;
- another Contributor’s entry;
- Host navigation resolution, Frame composition, layout, or behavior beyond accepted Contribution metadata;
- Host internals;
- acceptance of its own Contribution;
- reusable UI infrastructure unless the Contributor is separately acting within the UI owner boundary.

Contributor status must not transfer Host responsibilities.

## 5. Dependency Rules

A Contributor:

- may depend on the Host’s public Extension Point contract when architecture dependency rules permit;
- must not access Host internals;
- must register only through the accepted Contribution boundary;
- must preserve Core independence from optional Modules;
- must use explicit versioned dependencies for permitted Module-to-Module extension relationships;
- must not require the Host to depend on Contributor implementation;
- must tolerate valid rejection or unavailability of its Contribution;
- remains responsible for its own behavior when presented through owner-controlled Product presentation or a named Frame Surface.

A Core capability must not become dependent on an optional Module Host solely to contribute to it.

## 6. Target Status

Status: permanent

Contributor is a permanent relationship concept.

Contributors remain physically organized as their existing Core capability or Module owner. There is no default top-level `Contributors/` application ownership branch implied by this definition.

The working owner-local Contribution role may be represented as:

```text
Contrib/<Host>/
```

## 7. Accepted Decision

Status: accepted

Other owners may contribute to a Host through owner-local Contribution integration.

The Contributor retains ownership of its behavior. The Host retains ownership of the Registry, Extension Points, validation, ordering, and resolved result.

Owner-controlled Product presentation or a named Frame Surface may present contributed behavior without changing either ownership boundary.

## 8. Open Questions

The following details remain deferred:

- exact Contributor registration mechanism;
- exact Module dependency declaration requirements for Contribution relationships;
- exact compatibility negotiation behavior;
- exact contributor-side verification requirements;
- exact handling of disabled, unavailable, or rejected Contributions.

These questions belong to later placement, contract, Module, and verification work.

## 9. Related

- [Definitions Index](../Index.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Host Definition](../Hosts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Extension Point Definition](../Extension-Points/Definition.md)
- [Frame Surface Definition](../Surfaces/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- Related GitHub issue: #49
