<!--
DOC-META
title: Laravel Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Laravel/Definition.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines Laravel as the framework, runtime, and composition system used across Login 2.0 ownership areas without making Laravel a source-of-truth application owner.
-->

# Laravel Definition

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

Laravel is the application framework, runtime, and composition system used by Login 2.0.

Laravel provides the mechanisms through which Core, Modules, UI, and Surfaces are bootstrapped, registered, invoked, persisted, queued, scheduled, rendered, and tested.

Laravel is not a source-of-truth application owner. Application responsibilities remain owned by Core, Modules, or UI.

## 2. Classification Rule

A responsibility is Laravel integration when:

* its primary reason for existing is a Laravel framework contract;
* it performs application bootstrap, registration, discovery, or framework wiring;
* it configures a framework-wide mechanism;
* it adapts an application owner to a Laravel entry point;
* it delegates durable behavior to the applicable Core or Module owner.

An artifact is not Laravel integration merely because it is implemented as a controller, request, model, policy, event, listener, job, notification, command, middleware, or provider.

Owner-specific Laravel artifacts remain owned by their Core capability or Module.

## 3. Owns

Within Login 2.0, Laravel integration owns:

* application bootstrap and framework startup;
* service-container composition;
* framework-wide providers and bindings;
* global HTTP middleware;
* root route entry registration;
* framework-wide console and scheduler integration;
* package discovery and registration;
* base Laravel application classes;
* framework configuration loading;
* global compatibility adapters;
* integration of required Laravel and third-party packages.

Laravel supplies framework mechanisms for:

* routing;
* validation;
* authorization integration;
* events;
* queues;
* scheduling;
* persistence;
* cache;
* sessions;
* logging;
* filesystem access;
* notifications;
* views and rendering.

Use of a Laravel mechanism does not transfer ownership of the underlying application responsibility to Laravel integration.

## 4. Must Not Own

Laravel integration must not own:

* business or system behavior;
* authoritative Core or Module state;
* capability-specific workflows;
* application authorization policy;
* persistence rules merely because Eloquent is used;
* reusable UI infrastructure;
* Module lifecycle or feature behavior;
* Surface behavior beyond framework adaptation;
* generic technical-layer folders used as default homes for owner-specific artifacts.

Root Laravel folders must not become competing application owners.

## 5. Dependency Rules

Core, Modules, UI, and Surface adapters may use appropriate Laravel APIs and framework mechanisms.

Owner-specific Laravel artifacts should remain with their Core capability or Module when Laravel permits owner-local registration and discovery.

Application-wide Laravel integration:

* may register owners and their public integration points;
* may depend on public owner contracts required for composition;
* must not reach into owner internals for application behavior;
* must remain thin where it adapts a route, command, request, job, event, or other entry point.

Core and Module behavior must not depend on controllers, middleware, commands, views, serializers, or other delivery implementations.

Transport-specific Laravel details should not become required domain inputs unless the accepted contract explicitly requires them.

## 6. Target Status

Status: permanent

Laravel is the permanent framework, runtime, and composition system for Login 2.0 unless superseded by a later accepted decision.

The target architecture uses owner-first organization with Laravel-native concepts inside Core and Module boundaries.

Root Laravel folders retain application-wide framework and composition responsibilities.

Exact root-folder roles, owner-local placement, namespaces, and compatibility rules are defined by later Goal 03 phases.

## 7. Accepted Decision

Status: accepted

Laravel is the framework, runtime, and composition system used across every Login 2.0 ownership area.

Core and Modules organize application responsibilities using Laravel-native concepts within their own boundaries. Root Laravel folders retain application-wide framework integration and composition responsibilities, while owner-specific Laravel artifacts follow their Core capability or Module.

Laravel does not become a source-of-truth application owner.

## 8. Open Questions

Later Goal 03 phases must determine:

* which root Laravel folders remain permanent;
* the exact role of each retained root folder;
* which Laravel artifacts remain application-wide;
* which artifacts move under Core capabilities or Modules;
* how root and owner-local registration is performed;
* where shared and transitional models, migrations, resources, and tests belong;
* which child Laravel definitions are required.

These questions do not change Laravel’s framework role.

## 9. Related

* [Core Definition](../Core/Definition.md)
* [Module Definition](../Modules/Definition.md)
* [UI Definition](../UI/Definition.md)
* [Surface Definition](../Surfaces/Definition.md)
* [Temporary Laravel README](../../temp/Laravel/README.md)
* [Definitions Index](../Index.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
* Related GitHub issue: #48
