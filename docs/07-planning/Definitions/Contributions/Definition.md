<!--
DOC-META
title: Contribution Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Contributions/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Contribution as Contributor-owned integration targeting one explicit Extension Point exposed by a Host Registry.
-->

# Contribution Definition

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

A Contribution is Contributor-owned integration that targets one explicit Extension Point exposed by a Host Registry.

A Contribution may be declarative metadata, a contract implementation, or another bounded integration artifact accepted by the Extension Point.

The Contributor retains ownership of the behavior exposed through the Contribution.

Registration does not transfer ownership to the Host.

## 2. Classification Rule

An artifact is a Contribution when:

- one Contributor owns it;
- one target Host and Extension Point are explicit;
- it conforms to the Host’s public Contribution contract;
- its underlying behavior remains owned by the Contributor;
- the Host Registry can validate, accept, reject, order, and resolve it;
- it does not require access to Host internals.

General cross-owner calls are not Contributions unless they participate through an explicit Extension Point.

## 3. Owns

A Contribution may own:

- Contributor-local declaration metadata;
- an implementation of the accepted Contribution contract;
- references to Contributor-owned Actions, Queries, routes, views, or behavior;
- permitted ordering or availability metadata;
- compatibility metadata;
- Contributor-specific authorization or availability inputs required by the Host contract;
- Contribution-specific tests and documentation.

The Contribution remains part of the Contributor’s owner boundary.

## 4. Must Not Own

A Contribution must not own:

- the Host Registry;
- the Extension Point contract;
- Host-wide ordering or conflict policy;
- another Contributor’s behavior;
- Host internals;
- reusable UI infrastructure;
- authoritative Host navigation or layout policy beyond accepted metadata;
- direct mutation of Registry state outside the registration contract;
- behavior merely copied from the Contributor into the Host.

A Contribution must not become a backdoor dependency on the Host implementation.

## 5. Dependency Rules

A Contribution:

- may depend on the target Host’s public Extension Point contract;
- may reference public behavior owned by its Contributor;
- must not depend on Host internals;
- must not bypass the Host Registry;
- must respect Core and Module dependency direction;
- must not cause Core to depend on an optional Module;
- may be rejected when its declared dependency or compatibility requirements are not satisfied;
- must preserve Contributor ownership of behavior, data, authorization, and lifecycle.

## 6. Target Status

Status: permanent

Contribution is a permanent extensibility concept.

The working physical role label is:

```text
Contrib/<Host>/
```

Final casing, exact placement, file naming, declaration format, and namespaces remain subject to Goal 3 Phases 3 through 5.

## 7. Accepted Decision

Status: accepted

Other owners contribute to a Host through owner-local Contributions targeting explicit Extension Points.

The Host Registry validates and assembles accepted Contributions.

Contribution ownership remains with the Contributor. Registry and Extension Point ownership remain with the Host.

A Surface may present resolved Contributions but does not own them.

## 8. Open Questions

The following details remain deferred:

- final `Contrib/` folder naming;
- exact Contribution declaration schema;
- exact registration mechanism;
- exact ordering and conflict metadata;
- exact compatibility versioning;
- exact tests required for each Contribution type.

These questions belong to later Goal 3, Goal 4, and owner-specific implementation contracts.

## 9. Related

- [Definitions Index](../Index.md)
- [Contributor Definition](../Contributors/Definition.md)
- [Host Definition](../Hosts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Extension Point Definition](../Extension-Points/Definition.md)
- [Surface Definition](../Surfaces/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- Related GitHub issue: #49
