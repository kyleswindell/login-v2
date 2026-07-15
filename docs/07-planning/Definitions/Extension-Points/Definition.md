<!--
DOC-META
title: Extension Point Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Extension-Points/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines an Extension Point as a named Host-owned contract describing one bounded kind of Contribution accepted by a Registry.
-->

# Extension Point Definition

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

An Extension Point is a named Host-owned contract that describes one bounded kind of Contribution accepted by a Registry.

It defines how a Contributor may participate in an extensible feature without accessing Host internals or transferring ownership of Contributor behavior.

An Extension Point is part of the Host’s public extensibility boundary.

## 2. Classification Rule

A contract qualifies as an Extension Point when:

- one Host owns it;
- its accepted Contribution type is explicit;
- required fields or behavior are defined;
- validation and rejection behavior are defined;
- compatibility expectations are defined;
- ordering, indexing, or conflict metadata is defined when applicable;
- Contributions can target it without depending on Host internals.

A general public contract is not automatically an Extension Point.

## 3. Owns

An Extension Point may own:

- its canonical name or identifier;
- the accepted Contribution shape;
- required and optional metadata;
- validation constraints;
- compatibility requirements;
- ordering or conflict semantics;
- availability requirements;
- rejection conditions;
- Extension Point documentation and examples.

The Host remains the owner of these rules.

## 4. Must Not Own

An Extension Point must not own:

- Contributor behavior;
- Contributor implementation;
- Contributor persistence;
- another Extension Point’s entries;
- UI layout beyond the bounded contract it exposes;
- arbitrary callback execution;
- unrestricted access to Host internals;
- generic dependency injection;
- transport-specific registration requirements unless the contract explicitly requires them.

An Extension Point must not become an unbounded hook.

## 5. Dependency Rules

An Extension Point:

- is exposed through a Host-owned public contract;
- may be depended on by permitted Contributors;
- must not depend on Contributor implementations;
- must preserve Core independence from optional Modules;
- must respect explicit Module-to-Module dependency rules;
- may be consumed by the Host Registry during validation and resolution;
- may expose resolved data to the Host’s behavior or Surface;
- must not require direct access to another owner’s internals.

## 6. Target Status

Status: permanent

Extension Point is a permanent extensibility concept.

Its exact contract format, identifier rules, physical placement, and versioning representation remain subject to later placement, naming, and contract-discovery decisions.

## 7. Accepted Decision

Status: accepted

A Host may expose a Registry containing explicit Extension Points.

Contributors target those Extension Points through owner-local Contributions.

The Host Registry validates each Contribution against the applicable Extension Point and rejects invalid or incompatible entries.

## 8. Open Questions

The following details remain deferred:

- exact Extension Point declaration format;
- exact identifier grammar;
- exact versioning and compatibility metadata;
- exact ordering and conflict semantics;
- exact machine-readable discovery and export requirements;
- exact validation tooling.

These questions belong to later Goal 3 and Goal 4 work.

## 9. Related

- [Definitions Index](../Index.md)
- [Host Definition](../Hosts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Contributor Definition](../Contributors/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- Related GitHub issue: #49
