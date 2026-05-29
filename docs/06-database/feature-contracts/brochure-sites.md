# Brochure Sites Data Contract

This document defines the canonical scope and intent for Brochure Sites Data Contract.

Status: Planned (not implemented)

## Purpose

Define the planned exact model list and publish storage direction for the brochure-sites subsystem under the hybrid portable-contract architecture.

## Data Planes

The subsystem uses three logical data planes:

* control plane
  * site and host ownership records
* authoring plane
  * editable editorial records
* published delivery plane
  * resolved public delivery payloads

## Exact Model List

### Control-Plane Models

Recommended central-database models:

* `BrochureSite`
  * one record per brochure site
  * owns stable `site_key`, tenant ownership, brand defaults, and publish policy defaults
* `BrochureDomain`
  * one record per brochure host or alias
  * owns host mapping, kind, primary/canonical flags, and activity state

### Catalog Models

Recommended shared-catalog models:

* `TemplateDefinition`
* `SectionDefinition`
* `SectionProfile`

Default direction:

* central/shared catalog first
* tenant-scoped catalog variants only when a real requirement exists
* central-only template and section catalogs in the first release

### Authoring Models

Recommended tenant-owned editorial models:

* `Page`
  * page registry record
* `SectionInstance`
  * page-owned ordered content block
* `PageRedirect`
  * path retirement and redirect ownership

Optional future authoring models:

* `PageVersion`
* `SharedSectionContent`
* `BrochureMediaAsset`

### Published Models

Recommended published-delivery models:

* `BrochurePublication`
  * one record per site publication version
* `PublishedPage`
  * one record per published brochure route payload
* `PublishedRedirect`
  * one record per published redirect
* `PublishedNavigationSnapshot`
  * one record per site publication navigation payload

Optional future published models:

* `PublishedSitemapEntry`
* `PublishedAssetManifest`

## Recommended Table List

### Central Database

* `brochure_sites`
* `brochure_domains`
* `template_definitions`
* `section_definitions`
* `section_profiles`

### Tenant Database

* `pages`
* `section_instances`
* `page_redirects`

### Published Delivery Plane

The preferred initial PostgreSQL table set is:

* `brochure_publications`
* `published_pages`
* `published_redirects`
* `published_navigation_snapshots`

The preferred first-release publication strategy is:

* PostgreSQL published tables as the in-app published read model
* storage artifacts as portable delivery exports for future Astro consumption

## Core Table Responsibilities

### `brochure_sites`

Owns:

* tenant ownership
* `site_key`
* label
* status
* default locale/timezone
* review-host policy defaults
* publishing mode defaults

### `brochure_domains`

Owns:

* `brochure_site_id`
* host
* host kind such as `production`, `review`, or `redirect`
* primary/canonical flag
* activity state

### `pages`

Owns the canonical authoring registry record for one brochure page.

Required direction:

* stable `page_key`
* stable `route_path`
* `page_family`
* `page_mode`
* `template_key`
* selected `section_profile_key`
* lifecycle fields
* head/schema ownership hints
* audit columns

### `section_instances`

Owns:

* `page_id`
* `section_key`
* `placement_key`
* `sort_order`
* `region_key`
* `content_payload`
* lifecycle and visibility overrides where allowed

### `page_redirects`

Owns:

* site-local path retirement or alias rules
* redirect target
* redirect type
* activation state

### `brochure_publications`

Owns one site publication batch or version.

Recommended fields:

* `brochure_publication_id`
* `brochure_site_id`
* `publish_version`
* `status`
* `published_at`
* `published_by`
* `source_revision`
* `manifest_json`
* `cache_tags_json`

### `published_pages`

Owns the resolved delivery payload for one route in one publication version.

Recommended fields:

* `brochure_publication_id`
* `page_id`
* `site_key`
* `page_key`
* `route_path`
* `payload_json`
* `head_json`
* `schema_json`
* `checksum`

### `published_redirects`

Owns published redirect entries for one publication version.

Recommended fields:

* `brochure_publication_id`
* `site_key`
* `from_path`
* `target`
* `redirect_type`
* `checksum`

### `published_navigation_snapshots`

Owns navigation and sitemap-support payloads for one site publication version.

Recommended fields:

* `brochure_publication_id`
* `site_key`
* `payload_json`
* `checksum`

## Artifact Design

The portable published contract should also be exportable as artifacts.

Recommended artifact family:

* `manifest.json`
  * publish version, timestamps, checksums, and cache tags
* `site.json`
  * site-level public metadata
* `routes.json`
  * route index and page payload references
* `pages/<page-key>.json`
  * resolved page payloads
* `redirects.json`
  * published redirects
* `navigation.json`
  * navigation payload

These artifacts are not an alternative to the published tables in the first release. They are parallel outputs from the same publication event.

Integrated Laravel delivery may read published tables directly.

Astro delivery may read:

* these artifacts
* or an API backed by the same published tables

## Design Rules

* authoring tables are the source of truth for editorial workflows
* published tables and artifacts are the source of truth for public delivery
* delivery adapters must not rely on draft-only joins into authoring tables
* publish must create a stable contract boundary between editorial state and public rendering

## Recommended First Vertical Slice Table Use

Initial proof should use:

* `brochure_sites`
* `brochure_domains`
* `pages`
* `section_instances`
* `page_redirects`
* `brochure_publications`
* `published_pages`
* `published_redirects`

`published_navigation_snapshots` can be added in the same slice if navigation or sitemap proof is required.

## Related

* [Database Index](../index.md)
* [Brochure Sites Subsystem](../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Authoring And Publishing](../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Integrated Delivery Flow](../../05-flows/brochure-integrated-delivery-flow.md)
* [Brochure Astro Delivery Flow](../../05-flows/brochure-astro-delivery-flow.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](../../07-planning/phases/phase-3/Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
