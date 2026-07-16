<!--
DOC-META
title: Registry Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Registries/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Registry as an owner-controlled authoritative mechanism for validating, collecting, resolving, and exposing a bounded set of registered entries.
-->

# Registry Definition

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

A Registry is an owner-controlled authoritative mechanism for validating, collecting, resolving, and exposing a bounded set of registered entries under one explicit Contract.

When used for extensibility, the Registry belongs to a Host and resolves Contributions targeting Host-owned Extension Points.

Registry describes both an architecture mechanism and a working Technical Role. It is not a source-of-truth application owner.

Identifier and registry-key conventions remain governed by applicable accepted decisions and standards.

The Application Registration System may deliver validated declarations to a Registry, but it does not become authoritative for the Registry’s entry Contract, acceptance, ordering, or resolved output.

## 2. Classification Rule

A mechanism qualifies as a Registry when:

- one explicit owner controls it;
- the registered entry type or types are bounded;
- registration Contracts are explicit;
- validation and rejection behavior are defined;
- resolution behavior is deterministic or explicitly governed;
- consumers use resolved Registry output rather than Contributor internals;
- the mechanism is authoritative for its declared scope.

A collection, configuration array, service container, discovery scan, Owner Registration Descriptor, or Compiled Registration Manifest is not automatically a Registry.

## 3. Owns

A Registry may own:

- registration contracts;
- entry validation;
- rejection behavior;
- duplicate and conflict handling;
- ordering and indexing rules;
- availability filtering;
- compatibility checks;
- resolved output;
- Registry-specific identifiers and metadata;
- Registry documentation and verification.

A Host extension Registry may expose one or more explicit Extension Points.

## 4. Must Not Own

A Registry must not own:

- Contributor behavior;
- Contributor persistence;
- Contributor authorization policy;
- unrelated registered entry types;
- generic arbitrary services;
- application-wide dependency lookup;
- another owner’s internal implementation;
- UI presentation merely because Registry output is displayed;
- delivery transport merely because registration occurs during framework bootstrap;
- application-wide route, Provider, view, command, migration, configuration, or asset composition.

A Registry must not become a generic service locator, application registrar, or dumping ground.

## 5. Dependency Rules

A Registry:

- remains owned by its explicit capability or Module;
- may depend on owner-controlled Contracts and validation rules;
- may accept Contributions only through public registration Contracts;
- may receive validated Contribution declarations through the Application Registration System;
- must not depend on Contributor implementations;
- must not require Core to depend on optional Module Contributors;
- may expose resolved output to owner-controlled behavior, Delivery Adapters, or Surfaces;
- must preserve deterministic or explicitly governed resolution;
- must not bypass Module dependency rules.

Framework composition may deliver declarations or bind the Registry, but Laravel integration and the Application Registration System do not become the Registry owner.

## 6. Target Status

Status: permanent

Registry is a permanent architecture concept and Technical Role.

The working folder label is:

```text
Registry/
```

Default target placement is beneath the Host owner’s `Registry/` role. The Host’s public Registry and Extension Point Contracts remain in its `Contracts/` role.

Unrestricted runtime filesystem discovery is not the target model. Final class names, namespaces, subordinate folders, cache behavior, and Registry-specific declaration APIs remain Phase 5 and owner implementation-contract authority.

## 7. Accepted Decision

Status: accepted

A Host-owned Registry declares or exposes explicit Extension Points, validates Contributions, collects accepted entries, applies ordering and availability rules, and exposes resolved output.

Registry ownership remains with the Host. Contribution ownership remains with each Contributor. The Application Registration System may validate and route Contribution declarations but does not replace the Host Registry.

A Surface may consume resolved Registry output but is not the Registry.

## 8. Open Questions

The following details remain deferred:

- exact Host-specific registration API;
- exact Registry export or introspection requirements;
- exact ordering and conflict metadata;
- exact cache and invalidation integration with compiled application registration;
- exact validation proof and tooling.

These questions belong to later Goal 3, Goal 4, and implementation work.

## 9. Related

- [Definitions Index](../Index.md)
- [Host Definition](../Hosts/Definition.md)
- [Extension Point Definition](../Extension-Points/Definition.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Contributor Definition](../Contributors/Definition.md)
- [Surface Definition](../Surfaces/Definition.md)
- [Application Registration System Definition](../Application-Registration/Definition.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issues: #49, #51
