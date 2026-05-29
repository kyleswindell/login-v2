---
doc_type: planning
status: active
owner: shared
tags:
  - planning
  - handoff
  - laravel
  - brochure-sites
  - subsystem
---

# Laravel Brochure Subsystem Handoff

Purpose:

- provide a clean handoff package for the next Codex review inside the Laravel platform repo
- reduce redesign risk by making the Laravel-side review start from explicit brochure-site contracts instead of rediscovering intent from chat history

Scope:

- this note is intentionally high-level
- it describes what the Laravel-side review must confirm
- it does not assume that the Laravel repo has already been inspected in this workspace

## Handoff Checklist

Laravel-side review should confirm:

1. platform ownership boundary
   - whether brochure sites belong to one platform account, one tenant, or both
2. data placement strategy
   - whether brochure-site data lives in:
     - the central platform database
     - a tenant database
     - or a hybrid model
3. domain and host ownership
   - how brochure public domains, review hosts, and admin domains are modeled today
4. request entry path
   - whether brochure public requests should resolve through the main Laravel app directly or through a dedicated module/subsystem boundary
5. admin boundary
   - whether brochure-site management belongs inside the current Filament/admin surfaces or needs a separate panel/role boundary
6. publishing workflow
   - whether the platform already supports draft/review/publish patterns that brochure pages should reuse
7. current content model overlap
   - whether the platform already has models or tables analogous to:
     - sites
     - pages
     - templates
     - sections
     - redirects
     - domains
8. media strategy
   - whether brochure-site uploaded media should be site-scoped, tenant-scoped, or shared
9. deployment path
   - whether brochure public traffic will be served from the same Laravel public entry and release process already used by the platform
10. caching and invalidation
   - how Redis, queues, and cache invalidation should participate in page publish and route updates

## Required Decisions

These decisions should be answered early in the Laravel-side chat:

1. Is the brochure-site subsystem central-database only, tenant-database only, or dual-mode?
2. Is a brochure site a first-class model of its own, or only an attribute of an existing tenant/site concept?
3. Will public brochure pages resolve through one front controller in the main Laravel app?
4. Will brochure-site admin use existing Filament panels, a new Filament panel, or a separate role-scoped area?
5. Should templates be admin-managed, developer-managed, or hybrid?
6. Should non-technical admins edit only page instances, or also section instances and template assignments?
7. What is the publish model:
   - immediate live edits
   - draft plus review plus publish
   - versioned release batches
8. What is the canonical review-host model:
   - authenticated review only
   - public review host with noindex
   - both
9. What is the redirect and archive policy for pages moved out of production?
10. What is the minimum viable first page-family slice to prove the subsystem?

## Target Subsystem Boundaries

These are the intended brochure-subsystem boundaries to test against the Laravel repo.

Brochure subsystem should own:

- page registry
- template catalog
- section definitions
- section profiles
- section instances
- route resolution for brochure public pages
- preview and review lifecycle behavior
- brochure sitemap generation
- brochure head/schema derivation or authored overrides

Brochure subsystem should integrate with, not re-own:

- platform authentication
- platform users and roles
- platform tenancy primitives
- Redis cache and queue infrastructure
- storage and media infrastructure
- deployment and release tooling
- domain and SSL automation where already platform-owned

Brochure subsystem should avoid inheriting prematurely:

- unnecessary tenant complexity when one brochure site does not need it
- unrelated platform app UI assumptions
- platform-specific content abstractions that do not map cleanly to page, template, and section contracts

## Required Repo Context For The Next Chat

Minimum useful inputs:

- `composer.json`
- `package.json`
- `php artisan route:list`
- relevant models for tenants, domains, sites, pages, or content
- relevant migrations
- Filament panel/provider files
- tenancy config or package configuration
- deployment/readme notes describing staging and production release flow

## Source Contract Notes

The Laravel-side review should treat these current brochure-site docs as the source contract set:

- [Page Registry Data Model](page-registry-data-model.md)
- [Section Instance Data Model](section-instance-data-model.md)
- [Template Catalog Data Model](template-catalog-data-model.md)
- [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
- [Page Lifecycle and Preview Delivery](page-lifecycle-and-preview-delivery.md)
- [Route Resolver and Front Controller Flow](route-resolver-front-controller-flow.md)

## Suggested Outcome For The Next Chat

The next Laravel-side Codex chat should aim to produce:

- a fit-gap review against the existing Laravel repo
- proposed Laravel model names and table mapping
- proposed front-controller and route-resolver implementation path
- proposed admin-panel boundaries
- one vertical-slice implementation plan for the first brochure page family

Related notes:

- [Packet README](README.md)
