<!--
DOC-META
title: Phase 4.4 Route Placement And Registration
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-local route placement and the declarative registration-compiler model for Laravel routing and other registrable owner artifacts.
-->

# Phase 4.4 Route Placement And Registration

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where routes live, how they are registered, and how owner-local artifacts become discoverable without centralized feature files or uncontrolled filesystem discovery.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decisions 4.1–4.3

## 3. Route Placement

Core routes remain owner-local beneath the capability:

```text
app/Core/<Capability>/routes/
```

Module routes remain package-local:

```text
Modules/<Module>/routes/
```

Routes may be separated by delivery channel, such as interactive web, API, or webhook routes. Final filenames remain Phase 5 authority.

Repository-root `routes/` is restricted to:

- application-wide entrypoints;
- bootstrap composition;
- global infrastructure;
- compatibility routes;
- owner-route registration.

It must not become a centralized feature-route collection.

## 4. Owner Registration Descriptor

Each registrable Core capability, Module, or UI responsibility declares its applicable:

- providers;
- routes and route metadata;
- commands;
- views and namespaces;
- Blade and Livewire registrations;
- migrations and translations;
- configuration;
- events and listeners;
- asset bundles;
- Host Registry Contributions;
- owner dependencies.

The descriptor is owner-controlled. Final descriptor schema and naming remain Phase 5 authority.

## 5. Deterministic Registration Compiler

A repository registration compiler resolves owner descriptors, validates them, orders them by accepted dependencies, and produces a deterministic generated registration manifest.

```text
owner descriptors
→ validation and dependency ordering
→ generated registration manifest
→ root Laravel registrar
```

The root registrar owns composition only. It delegates to typed registrars and does not own registered behavior.

Filesystem presence alone does not register canonical artifacts. Unrestricted request-time directory scanning is prohibited.

## 6. Laravel And Build-System Responsibilities

The custom registration layer prepares and validates registration. Laravel remains responsible for loading and caching the final route collection.

```text
owner route declaration
→ application registration manifest
→ Laravel route registration
→ Laravel route cache
```

Livewire classes outside its conventional root require explicit alias-to-class registration. Blade package paths and component namespaces require explicit registration. CSS and JavaScript composition is handled through deterministic asset declarations and Vite entrypoints under Decision 4.7.

`Contrib/<Host>/` is for Contributions to Host Extension Points, not general Laravel or asset discovery.

## 7. Required Validation

Later validation should reject:

- missing declared files or classes;
- duplicate route names or prefixes;
- duplicate Livewire aliases or view namespaces;
- unknown dependencies or dependency cycles;
- Contributions targeting unknown Hosts or Extension Points;
- stale compiled output;
- declared assets absent from deterministic composition.

Required declarations must fail rather than disappear silently.

## 8. Accepted Decision

> Login 2.0 places route definitions with the Core capability or Module that owns the exposed behavior. Core routes live in an owner-local route branch beneath `app/Core/<Capability>/`; Module routes live beneath `Modules/<Module>/routes/`. Each registrable owner declares its route files and related registration metadata through an owner-controlled registration descriptor. A deterministic application registration compiler resolves descriptors, validates paths and conflicts, orders registrations by accepted dependencies, and produces the application registration manifest consumed by the root Laravel registrar. Laravel remains responsible for loading and caching the final route collection. Repository-root `routes/` files are restricted to genuinely application-wide routes, bootstrap composition, compatibility, and registration infrastructure. Filesystem presence alone does not register a route or other canonical artifact, and missing required declarations must fail validation rather than being silently ignored.

## 9. Boundaries And Handoff

Phase 4 identifies the registration architecture but does not implement the compiler, manifest, typed registrars, or validation commands. Phase 5 owns final names and schema. Later implementation and verification work owns construction and proof.

## 10. Related

- [Delivery Adapter Placement](4-3-delivery-adapter-placement.md)
- [Configuration Placement](4-5-configuration-placement.md)
- [View And Asset Placement](4-7-view-and-asset-placement.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51
