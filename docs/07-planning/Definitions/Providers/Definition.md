<!--
DOC-META
title: Provider Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Providers/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Provider as owner-local Laravel registration and composition code that connects owner-controlled artifacts to framework runtime.
-->

# Provider Definition

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

A Provider is Laravel registration and composition code that connects owner-controlled artifacts to the framework runtime.

An owner-local Provider belongs to the Core capability or Module whose Contracts, implementations, routes, Events, Policies, commands, or other artifacts it registers. A root application Provider is restricted to application-wide Laravel integration, bootstrap composition, compatibility, or the bounded Root Application Registrar.

A Provider is an execution mechanism within the Application Registration System; it is not the Owner Registration Descriptor, Registration Compiler, or Compiled Registration Manifest.

The working Technical Role label is:

```text
Providers/
```

## 2. Classification Rule

An artifact is a Provider when its primary responsibility is to:

- register bindings;
- register owner-local routes, commands, Events, Listeners, or Policies;
- connect owner-controlled Contracts to implementations;
- configure owner-local framework integration;
- execute typed registration declared by an owner descriptor;
- participate in framework bootstrapping for one explicit owner or one bounded application-wide composition concern.

## 3. Owns

A Provider may own:

- owner-local service-container bindings;
- owner-local registration;
- owner-local framework bootstrapping;
- execution of accepted typed registration instructions;
- registration order required by its owner;
- bounded root composition or compatibility registration;
- Provider-specific tests and documentation.

## 4. Must Not Own

A Provider must not own:

- application business behavior;
- broad unrelated application bootstrap;
- another owner’s implementation;
- hidden service-locator behavior;
- persistence rules;
- HTTP request handling;
- UI presentation;
- arbitrary configuration mutation;
- descriptor discovery, validation, or compilation unless it is explicitly designated application registration infrastructure;
- generic cross-owner coordination;
- silent filesystem scanning used as owner registration.

## 5. Dependency Rules

A Provider:

- may depend on owner-controlled Contracts and implementations;
- may use Laravel framework APIs required for registration;
- may consume validated instructions from the Compiled Registration Manifest;
- must not transfer application ownership to Laravel integration;
- must not register another owner’s internals without an accepted composition Contract;
- must preserve Core independence from optional Modules;
- must not be depended on by owner domain behavior;
- may register Host Contributions or Registry entries only through accepted public Contracts;
- must not bypass descriptor validation or treat filesystem presence as registration.

## 6. Target Status

Status: permanent

Provider is a permanent shared Technical Role for Laravel-based owners.

This definition does not require every owner to contain a `Providers/` folder.

Default target placement is:

```text
app/Core/<Capability>/Providers/
Modules/<Module>/src/Providers/
app/Providers/
```

Root `app/Providers/` is restricted to application-wide Laravel integration, Root Application Registrar composition, base integration, and bounded compatibility. Owner-local Providers remain with their owner.

## 7. Accepted Decision

Status: accepted

Core capabilities and Modules may use owner-local Providers for Laravel registration and composition.

Providers execute validated registration and adapt owner-controlled artifacts to Laravel without becoming owners of the behavior they register. The Root Application Registrar consumes the Compiled Registration Manifest and delegates to Typed Registrars or owner-local Providers.

## 8. Open Questions

The following details remain deferred:

- exact Provider naming conventions;
- exact package-Provider requirements for Modules;
- exact Typed Registrar and Provider boundaries;
- exact Provider and Root Application Registrar naming;
- exact automated registration proof and cache integration.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- [Application Registration System Definition](../Application-Registration/Definition.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issues: #49, #51
