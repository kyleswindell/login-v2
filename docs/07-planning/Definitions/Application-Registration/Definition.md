<!--
DOC-META
title: Application Registration System Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Application-Registration/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines the deterministic application composition system that declares, validates, orders, compiles, and registers owner-controlled framework and build integrations.
-->

# Application Registration System Definition

Parent: [Definitions Index](../Index.md)

- [1. Definition](#1-definition)
- [2. Constituent Concepts](#2-constituent-concepts)
- [3. Classification Rule](#3-classification-rule)
- [4. Owns](#4-owns)
- [5. Must Not Own](#5-must-not-own)
- [6. Dependency Rules](#6-dependency-rules)
- [7. Target Status](#7-target-status)
- [8. Accepted Decision](#8-accepted-decision)
- [9. Open Questions](#9-open-questions)
- [10. Related](#10-related)

## 1. Definition

The Application Registration System is the deterministic application-wide composition mechanism that declares, validates, dependency-orders, compiles, and registers owner-controlled artifacts with Laravel, Livewire, Blade, Vite, and other approved runtime or build integrations.

The system is application composition infrastructure. It is not a Core, Module, UI, Surface, Delivery Adapter, Host, Registry, Contribution, or feature-behavior owner.

Registration connects an artifact to an approved runtime or build integration. Registration does not transfer ownership of the artifact or its behavior.

## 2. Constituent Concepts

### 2.1. Owner Registration Descriptor

An Owner Registration Descriptor is the owner-controlled canonical declaration of registrable artifacts and registration dependencies.

A descriptor may declare applicable:

- Providers;
- routes;
- commands and schedules;
- views, Blade namespaces, and components;
- Livewire aliases;
- migrations, factories, and seeders;
- configuration and required environment inputs;
- translations;
- Events and Listeners;
- CSS and JavaScript bundles;
- Host Contributions;
- explicit owner or package dependencies.

The descriptor declares registration intent. It does not execute registration or own the declared behavior.

### 2.2. Registration Compiler

The Registration Compiler consumes Owner Registration Descriptors, validates their declarations, resolves accepted dependencies, produces deterministic ordering, and generates the Compiled Registration Manifest.

The compiler is build, cache-preparation, or deployment tooling. It is not request-time feature discovery.

### 2.3. Compiled Registration Manifest

The Compiled Registration Manifest is generated deterministic output containing the validated and ordered instructions required for application composition.

The manifest is derived output. Owner Registration Descriptors remain canonical inputs.

### 2.4. Root Application Registrar

The Root Application Registrar is restricted application-wide Laravel integration that consumes the Compiled Registration Manifest and delegates registration to Typed Registrars, framework APIs, or owner-local Providers.

It owns root composition only. It does not own registered behavior.

### 2.5. Typed Registrar

A Typed Registrar performs one bounded registration family, such as routes, views, Livewire aliases, commands, migrations, configuration, assets, Events, or Host Contributions.

A Typed Registrar validates and executes its accepted registration Contract without becoming the owner of registered artifacts.

## 3. Classification Rule

A mechanism is part of the Application Registration System when it:

- consumes explicit owner-controlled declarations;
- validates required paths, classes, identifiers, aliases, and dependencies;
- produces deterministic ordering and output;
- distinguishes canonical declarations from generated manifests;
- delegates final framework or build integration to the applicable native system;
- fails required missing, duplicate, conflicting, cyclic, unknown, or stale declarations;
- avoids unrestricted request-time filesystem discovery.

A service container, Laravel Provider, Host Registry, configuration array, Vite entrypoint, package manifest, or filesystem scan is not by itself the Application Registration System.

## 4. Owns

The Application Registration System may own:

- descriptor schema and validation;
- registration dependency resolution;
- deterministic compilation;
- generated manifest structure;
- duplicate and conflict detection;
- missing-file and missing-class detection;
- stale-output detection;
- Typed Registrar Contracts;
- root application registration composition;
- registration-specific architecture tests and documentation.

It may validate that declared Contributions target known Hosts and Extension Points, but the Host Registry remains authoritative for Contribution acceptance and resolved output.

## 5. Must Not Own

The Application Registration System must not own:

- Core, Module, or UI behavior;
- owner Contracts or implementation;
- routes, commands, views, migrations, configuration, assets, or tests merely because it registers them;
- Host Registry entry semantics, ordering policy, or resolved output;
- Contributor behavior;
- Tenant enablement or runtime settings;
- secrets;
- arbitrary dependency lookup;
- unrestricted recursive filesystem discovery;
- Laravel route, configuration, view, event, or package caches;
- Vite’s build responsibility.

The system must not become a generic application owner or service locator.

## 6. Dependency Rules

The Application Registration System:

- may depend on Owner Registration Descriptors and approved framework or build APIs;
- may consume only public registration metadata and accepted dependency declarations;
- must preserve Core independence from optional Modules;
- must reject unknown or cyclic dependencies;
- must not require owner behavior to depend on the Compiled Registration Manifest or Root Application Registrar;
- may route Contribution declarations to Host-owned Registries without becoming the Registry owner;
- must preserve deterministic composition across local and CI execution;
- must not silently ignore a required declared resource.

Laravel remains responsible for final route, configuration, view, event, package, and other native caches. Vite remains responsible for asset compilation. The custom registration system prepares, validates, and deterministically composes their inputs.

## 7. Target Status

Status: accepted proposed target

The Application Registration System is an accepted permanent target architecture concept introduced by Phase 4. It is not yet implemented or validated.

Phase 5 accepted the architecture terminology and conditional names for independently justified descriptors, compilers, manifests, registrars, commands, and generated files. Physical placement, schemas, serialization, cache locations, bootstrap integration, and generated-output policy remain later implementation authority.

## 8. Accepted Decision

Status: accepted

Each registrable owner exposes one explicit Owner Registration Descriptor. A deterministic Registration Compiler validates and dependency-orders those descriptors and produces a Compiled Registration Manifest. One Root Application Registrar consumes that manifest and delegates to bounded Typed Registrars, framework APIs, or owner-local Providers.

Filesystem presence alone does not register a canonical artifact. Required missing declarations, duplicate identifiers, conflicts, unknown dependencies, cycles, unknown Hosts or Extension Points, missing assets, and stale generated output fail validation.

The Application Registration System does not replace Laravel or Vite native runtime and build responsibilities and does not transfer ownership of registered artifacts.

## 9. Open Questions

The following details remain deferred:

- final PHP, JSON, YAML, or other machine-readable descriptor format;
- final source-controlled versus generated manifest policy;
- exact compiler command and cache lifecycle;
- exact Typed Registrar boundaries;
- exact package install, update, disable, and uninstall integration;
- exact Tenant Module enablement interaction;
- exact validation command, architecture tests, and CI enforcement;
- exact bootstrap and performance requirements.

These questions belong to Phase 6, Phase 7, and later bounded implementation and verification work. Naming boundaries are accepted by Phase 5.

## 10. Related

- [Definitions Index](../Index.md)
- [Provider Definition](../Providers/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- [Phase 4.5 Configuration Placement](../../Milestones/milestone-0/goal-3/phase-4/4-5-configuration-placement.md)
- [Phase 4.7 View And Asset Placement](../../Milestones/milestone-0/goal-3/phase-4/4-7-view-and-asset-placement.md)
- [Phase 4.12 Exceptions And Future Enforcement](../../Milestones/milestone-0/goal-3/phase-4/4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51
