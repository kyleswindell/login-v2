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

A Contribution may be declarative metadata, a Contract implementation, or another bounded integration artifact accepted by the Extension Point.

The Contributor retains ownership of the behavior exposed through the Contribution.

Registration does not transfer ownership to the Host.

A Contributor may declare a Contribution through its Owner Registration Descriptor, but the artifact is a Contribution only when it targets one explicit Host-owned Extension Point. General route, Provider, view, command, migration, configuration, or asset registration is not a Contribution.

## 2. Classification Rule

An artifact is a Contribution when:

- one Contributor owns it;
- one target Host and Extension Point are explicit;
- it conforms to the Host’s public Contribution Contract;
- its underlying behavior remains owned by the Contributor;
- the Host Registry can validate, accept, reject, order, and resolve it;
- it does not require access to Host internals.

General cross-owner calls and general application registration are not Contributions unless they participate through an explicit Host-owned Extension Point.

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
- the Extension Point Contract;
- Host-wide ordering or conflict policy;
- another Contributor’s behavior;
- Host internals;
- reusable UI infrastructure;
- authoritative Host navigation or layout policy beyond accepted metadata;
- direct mutation of Registry state outside the registration Contract;
- general Laravel or build-system registration unrelated to the target Extension Point;
- behavior merely copied from the Contributor into the Host.

A Contribution must not become a backdoor dependency on the Host implementation.

## 5. Dependency Rules

A Contribution:

- may depend on the target Host’s public Extension Point Contract;
- may reference public behavior owned by its Contributor;
- may be declared through the Contributor’s Owner Registration Descriptor;
- must not depend on Host internals;
- must not bypass the Host Registry or be treated as registered solely because a file exists;
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

Default target placement remains owner-local:

```text
app/Core/<ContributorCapability>/Contrib/<Host>/
Modules/<ContributorModule>/src/Contrib/<Host>/
```

`Contrib/<Host>/` is reserved for Host Extension Point Contributions and is not a general framework-registration folder.

Contribution class names remain specific to the Host-owned Extension Point Contract. Generic `RegistrationContribution` and `ModuleContribution` wrappers are not canonical names. Declaration schemas, filenames, and namespaces remain Host Contract authority.

## 7. Accepted Decision

Status: accepted

Other owners contribute to a Host through owner-local Contributions targeting explicit Extension Points.

The Application Registration System may validate and route declared Contributions to the applicable Host Registry. The Host Registry remains authoritative for acceptance, rejection, ordering, and resolution.

Contribution ownership remains with the Contributor. Registry and Extension Point ownership remain with the Host.

Owner-controlled Product presentation or a named Frame Surface may present resolved Contributions but does not own them.

## 8. Open Questions

The following details remain deferred:

- final `Contrib/` class and namespace naming;
- exact Contribution declaration schema;
- exact descriptor-to-Registry handoff and runtime binding mechanism;
- exact ordering and conflict metadata;
- exact compatibility versioning;
- exact tests required for each Contribution type.

These questions belong to later Goal 3 migration planning, Goal 4, and owner-specific implementation Contracts. Phase 6 accepted `Contrib/Navigation/` as the owner-local Product navigation Contribution family.

## 9. Related

- [Definitions Index](../Index.md)
- [Contributor Definition](../Contributors/Definition.md)
- [Host Definition](../Hosts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Extension Point Definition](../Extension-Points/Definition.md)
- [Frame Surface Definition](../Surfaces/Definition.md)
- [Application Registration System Definition](../Application-Registration/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issues: #49, #51
