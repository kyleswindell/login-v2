<!--
DOC-META
title: Host Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Hosts/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Host as the Core capability or Module that owns a bounded extensible feature and its Registry contracts.
-->

# Host Definition

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

A Host is a Core capability or Module that owns a bounded extensible feature and exposes explicit extension points through a Host-owned Registry.

Host describes a role performed by an existing Core capability or Module. It is not a separate source-of-truth application owner.

A Host retains ownership of the extensible feature, the extension contract, contribution acceptance rules, and resolved result.

## 2. Classification Rule

A Core capability or Module acts as a Host when:

- it owns one cohesive feature or responsibility;
- external Contributions are intentionally permitted;
- accepted extension points are explicit;
- one Registry validates and resolves Contributions for the bounded scope;
- the Host can define compatibility and rejection behavior;
- Contributors can participate without transferring ownership of their behavior.

A capability or Module is not automatically a Host merely because other owners call its public contracts.

## 3. Owns

A Host owns:

- the extensible feature;
- the Registry for that bounded extension scope;
- extension-point contracts;
- accepted Contribution types;
- validation and rejection requirements;
- ordering and conflict rules;
- compatibility requirements;
- resolved Registry output;
- Host-specific documentation and verification.

A Host may expose resolved Registry output to owner-controlled Product presentation or, when the Host owns persistent Frame composition, to a named Frame Surface.

## 4. Must Not Own

A Host must not own:

- a Contributor’s underlying behavior;
- a Contributor’s internal implementation;
- reusable UI infrastructure;
- a generic application-wide service locator;
- unrelated extension scopes;
- optional Module behavior merely because it contributes;
- cross-owner code outside the accepted extension contract;
- delivery-channel behavior that belongs to another owner.

Host status must not become a reason to absorb another owner’s responsibility.

## 5. Dependency Rules

A Host:

- exposes extension-point contracts through public boundaries;
- must not depend on Contributor implementations;
- must remain valid when no optional Contributions are registered unless its accepted contract states otherwise;
- may depend on Core and UI only as permitted by its ownership classification;
- may depend on required Module relationships only when explicit Module dependency rules permit;
- must reject invalid or incompatible Contributions without bypassing ownership boundaries;
- may expose resolved Registry output to its own Actions, Queries, Delivery Adapters, owner-controlled Product presentation, or an applicable named Frame Surface.

A Core Host must not depend on optional Modules that contribute to it.

## 6. Target Status

Status: permanent

Host is a permanent architecture role.

Hosts remain physically organized as Core capabilities or Modules. There is no default top-level `Hosts/` application ownership branch implied by this definition.

The working `Registry/` role may contain Host extension infrastructure. Final placement and naming remain subject to later Goal 3 phases.

## 7. Accepted Decision

Status: accepted

A Core capability or Module may act as a Host by exposing a Registry containing explicit extension points.

Other owners contribute through their own owner-local Contribution integration. The Host Registry validates and assembles Contributions.

Owner-controlled Product presentation or an applicable named Frame Surface may present the resolved result through UI-owned reusable infrastructure.

## 8. Open Questions

The following details remain deferred:

- exact Registry registration and discovery mechanism;
- exact compatibility-version representation;
- exact Contribution ordering model;
- exact conflict-resolution rules;
- exact static proof that a Host does not depend on Contributor implementations.

These questions belong to later contract, placement, and verification work.

## 9. Related

- [Definitions Index](../Index.md)
- [Registry Definition](../Registries/Definition.md)
- [Extension Point Definition](../Extension-Points/Definition.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Contributor Definition](../Contributors/Definition.md)
- [Frame Surface Definition](../Surfaces/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- Related GitHub issue: #49
