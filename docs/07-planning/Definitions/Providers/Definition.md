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

A Provider is owner-local Laravel registration and composition code that connects owner-controlled artifacts to the framework runtime.

A Provider belongs to the Core capability or Module whose services, routes, Events, policies, commands, or other artifacts it registers.

The working Technical Role label is:

```text
Providers/
```

## 2. Classification Rule

An artifact is a Provider when its primary responsibility is to:

- register bindings;
- register owner-local routes, commands, Events, Listeners, or policies;
- connect owner-controlled Contracts to implementations;
- configure owner-local framework integration;
- participate in framework bootstrapping for one explicit owner.

## 3. Owns

A Provider may own:

- owner-local service-container bindings;
- owner-local registration;
- owner-local framework bootstrapping;
- registration order required by its owner;
- bounded compatibility registration;
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
- generic cross-owner coordination.

## 5. Dependency Rules

A Provider:

- may depend on owner-controlled Contracts and implementations;
- may use Laravel framework APIs required for registration;
- must not transfer application ownership to Laravel integration;
- must not register another owner’s internals without an accepted composition contract;
- must preserve Core independence from optional Modules;
- must not be depended on by owner domain behavior;
- may register Host Contributions or Registry entries only through accepted public contracts.

## 6. Target Status

Status: permanent

Provider is a permanent shared Technical Role for Laravel-based owners.

This definition does not require every owner to contain a `Providers/` folder.

Application-wide root providers remain Laravel integration concerns; owner-local providers remain with their owner.

## 7. Accepted Decision

Status: accepted

Core capabilities and Modules may use owner-local Providers for Laravel registration and composition.

Providers adapt owner-controlled artifacts to Laravel and do not become owners of the behavior they register.

## 8. Open Questions

The following details remain deferred:

- exact Provider naming conventions;
- exact package-provider requirements for Modules;
- exact route and Event registration boundaries;
- exact root versus owner-local provider placement;
- exact automated registration proof.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- Related GitHub issue: #49
