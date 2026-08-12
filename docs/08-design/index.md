<!--
DOC-META
title: Software Design Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/08-design/index.md
parent: docs/00-start-here.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes accepted pre-implementation software designs that map canonical requirements to concrete Login 2.0 implementation blueprints.
-->

# Software Design Index

Parent: [Documentation Start](../00-start-here.md)

## 1. Purpose

This branch owns accepted pre-implementation software design.

A Software Design Document (SDD) defines how accepted system requirements will be realized in repository implementation.

## 2. Authority

Software design may own:

- implementation components and responsibilities;
- exact intended repository placement;
- public Contract realization;
- component interactions;
- persistence realization;
- Delivery Adapter and presentation mapping;
- Events, Listeners, and Jobs;
- transaction and concurrency design;
- registration and configuration;
- security enforcement points;
- implementation manifests;
- verification design.

Software design does not redefine requirements owned by:

- `docs/01-decisions/`;
- `docs/02-standards/`;
- `docs/03-architecture/`;
- `docs/04-features/`;
- `docs/05-flows/`;
- `docs/06-database/`;
- `docs/07-planning/`.

GitHub issues remain the bounded implementation work packets and own issue-specific acceptance criteria and verification contracts.

## 3. Organization

Organize designs by application owner and system.

Default paths:

```text
docs/08-design/foundation/<system>/software-design.md
docs/08-design/core/<capability>/software-design.md
docs/08-design/ui/<responsibility>/software-design.md
docs/08-design/modules/<module>/software-design.md
docs/08-design/laravel-integration/<boundary>/software-design.md