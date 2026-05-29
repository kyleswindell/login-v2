# Brochure Sites Subsystem

This document defines the canonical scope and intent for Brochure Sites Subsystem.

Status: Planned (not implemented)

## Purpose

Define the target architecture boundary for brochure marketing sites as a first-class subsystem of App 2.0.

This subsystem uses a hybrid portable-contract model:

* Laravel owns authoring, workflow, publishing, and canonical brochure data.
* Public delivery may run in Laravel or in a separate frontend runtime.
* Both delivery modes consume the same published brochure contract.

## Target Delivery Model

The planned default architecture is:

* Laravel-native authoring and publishing
* portable published page contract
* integrated Laravel delivery supported
* decoupled Astro delivery supported later without replacing the authoring model

The published contract is the stability layer. Delivery runtimes are adapters.

## Locked Decisions

The current locked defaults for this subsystem are:

* brochure page routes use trailing-slash canonical paths, except root `/`
* draft pages use signed preview first
* review-state pages add review-host support next
* published delivery uses both PostgreSQL published tables and storage artifacts
* template and section catalogs are central-only in the first release
* the first implementation proof uses one service-detail or detail page family

These defaults should remain in place unless a later canonical decision record replaces them.

## Subsystem Ownership

The brochure subsystem owns:

* brochure site registry
* brochure domain registry
* page registry
* template catalog
* section definitions
* section profiles
* section instances
* preview, review, publish, and archive lifecycle handling
* brochure redirect resolution
* brochure sitemap, head, and schema derivation
* publish contract generation
* cache invalidation events for public delivery

The brochure subsystem integrates with, but does not re-own:

* platform authentication
* platform and tenant RBAC
* tenant resolution primitives
* storage and media infrastructure
* Redis cache and queue infrastructure
* deployment tooling
* CDN or frontend hosting infrastructure

## Runtime Boundary

The planned runtime boundary is:

* `platform` context owns cross-tenant control-plane concerns such as site provisioning, host ownership, and publishing policy
* `tenant` context owns tenant-authored brochure content and day-to-day editorial workflows
* `delivery` adapters own public rendering only

Brochure delivery must not collapse platform, tenant, and public concerns into one undifferentiated route surface.

## Supported Delivery Modes

### Integrated Laravel Delivery

Laravel serves public brochure traffic directly.

Recommended use:

* early delivery
* low operational overhead
* environments where one runtime is preferred

Rule:

* integrated delivery should still render from the published contract rather than a private authoring-only view model
* integrated delivery should honor the canonical trailing-slash brochure route policy

### Astro Delivery Adapter

Astro serves public brochure traffic from the same published contract produced by Laravel.

Recommended use:

* stronger public/admin isolation
* CDN-first delivery
* independent frontend release cadence
* higher public performance specialization

Rule:

* Astro is a delivery adapter, not a second CMS

## Core Architectural Rule

Only Laravel writes brochure content.

Public delivery runtimes may:

* read published brochure data
* render published brochure pages
* cache published brochure outputs

Public delivery runtimes must not:

* mutate authoring data
* bypass lifecycle rules
* invent separate canonical routing ownership

## Module Boundary

Recommended Laravel namespace ownership:

* `App\Brochure\Domain`
  * brochure site, page, redirect, lifecycle enums, value objects
* `App\Brochure\Catalog`
  * template definitions, section definitions, section profiles
* `App\Brochure\Authoring`
  * editorial services, validation, preview orchestration
* `App\Brochure\Publishing`
  * publish pipeline, versioning, cache invalidation, artifact generation
* `App\Brochure\Delivery`
  * Laravel public route resolver and integrated renderer
* `App\Brochure\Admin`
  * Filament resources, actions, and admin orchestration
* `App\Brochure\Support`
  * path normalization, canonical helpers, payload transformers

## Data Boundary

Planned data ownership:

* central platform database
  * brochure site control-plane records
  * brochure domain ownership records
  * global template and section catalog records when shared across tenants
* tenant databases
  * tenant-authored pages
  * tenant-authored section instances
  * tenant-authored redirects and lifecycle state
* published delivery plane
  * versioned published page payloads
  * versioned redirect payloads
  * versioned navigation and sitemap payloads

The published delivery plane may be stored in:

* PostgreSQL published tables
* JSON artifacts in storage or object storage
* or both

## Transition Rule

The subsystem must support this path without changing the authoring model:

1. tenant authors content in Laravel
2. Laravel publishes the canonical brochure contract
3. Laravel integrated delivery consumes that contract
4. Astro later consumes the same contract
5. delivery cutover occurs host-by-host or site-by-site

Only the delivery adapter should change at cutover.

## Non-Goals

This subsystem architecture does not require:

* raw HTML page-builder ownership as the primary model
* one physical PHP file per public route
* direct editorial writes from the public frontend
* permanent coupling between public rendering and Laravel Blade

## Related

* [Architecture Index](../index.md)
* [Platform Boundary](../platform-boundary.md)
* [Tenancy](../tenancy.md)
* [Application Structure](application-structure.md)
* [Brochure Sites Authoring And Publishing](../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Sites Data Contract](../../06-database/feature-contracts/brochure-sites.md)
* [Brochure Integrated Delivery Flow](../../05-flows/brochure-integrated-delivery-flow.md)
* [Brochure Astro Delivery Flow](../../05-flows/brochure-astro-delivery-flow.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](../../07-planning/phases/phase-3/Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
