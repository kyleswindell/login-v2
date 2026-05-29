---
doc_type: database
status: active
owner: shared
tags:
  - database
  - schema
  - routing
  - registry
  - pages
---

# Page Registry Data Model

Purpose:

- define the canonical brochure-site page registry fields and constraints so routing, rendering, head, schema, sitemap, and page lifecycle can move from flat files to PostgreSQL later without changing the higher-level runtime contract

Scope:

- this note defines the page-registry data contract
- it is intended to work in both:
  - flat-file manifest form
  - future PostgreSQL-backed storage inside a Laravel or similar admin system

Core entity:

- `page_registry`
  - one record per public brochure-site page route
  - owns the path-level identity and lifecycle state for that page
  - does not need to store the full page content body inline if content lives in JSON, PHP, or later database-backed section records
  - this is the logical contract name for the registry layer; future Laravel model and table naming should follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)

Required identity fields:

- `page_id`
  - stable internal unique identifier
  - should not depend on slug, path, or filesystem location
- `site_key`
  - identifies the brochure site or project owning the page
  - allows one future platform to store multiple brochure sites cleanly
- `page_key`
  - stable human-readable application key used by renderers, head records, schema records, analytics defaults, and internal references
  - should remain stable even if the public path changes

Required routing fields:

- `route_path`
  - normalized public path such as `/capabilities/four-slide-stamping/`
  - should be the canonical resolved request path for the page
- `slug`
  - leaf slug such as `four-slide-stamping`
  - should not be treated as globally unique without site context
- `parent_page_id`
  - optional link to the logical parent page when the page belongs to a hierarchy
  - should support navigation, breadcrumbs, and grouping without forcing filesystem nesting

Required rendering fields:

- `page_family`
  - renderer family such as `home`, `hub`, `detail`, `contact`, `legal`, or `error`
- `page_mode`
  - optional controlled renderer mode such as `category-card`, `pathway-and-category`, `commercial`, or `support`
- `template_key`
  - canonical template or layout contract identifier used for admin selection, preview, and migration safety
- `content_source_type`
  - identifies where the page content currently comes from
  - expected values should include:
    - `content_json`
    - `legacy_php`
    - `database`
    - `generated`
- `content_source_ref`
  - pointer to the content record currently feeding the page
  - examples:
    - route-mirrored JSON path
    - legacy PHP page key
    - future database record id

Required lifecycle fields:

- `status`
  - current page lifecycle state
  - preferred allowed values:
    - `production`
    - `review`
    - `draft`
    - `archived`
- `is_indexable`
  - controls whether the page should be eligible for sitemap and normal indexation flows
- `is_canonical`
  - indicates whether this record represents the canonical served page rather than a helper, alias, or transitional route
- `published_at`
  - optional timestamp for when the page first became production-eligible
- `archived_at`
  - optional timestamp for when the page moved into archived state

Recommended SEO and head fields:

- `canonical_path_override`
  - optional explicit canonical path when it should differ from `route_path`
- `robots_override`
  - optional page-level robots directive override
- `head_source_type`
  - indicates whether head data is:
    - `derived`
    - `authored`
    - `hybrid`
- `schema_source_type`
  - indicates whether schema is:
    - `derived`
    - `authored`
    - `hybrid`

Recommended structure and grouping fields:

- `nav_group_key`
  - optional grouping key for navigation, sidebar, and sitemap categorization
- `sidebar_group_key`
  - optional group key when sidebar behavior is parent- or cluster-owned
- `sort_order`
  - optional explicit order for sibling pages inside navigation or grouped displays
- `section_profile_key`
  - optional identifier for the allowed section arrangement profile when two pages share a family shell but differ in approved section structure

Recommended asset and behavior fields:

- `asset_profile_key`
  - optional page-level asset dependency profile when assets are not derived entirely from sections
- `redirect_target`
  - optional target path or URL when the page is archived or intentionally redirected
- `redirect_type`
  - optional redirect type such as `301`, `302`, or `410`

Audit fields:

- `created_at`
- `updated_at`
- `created_by`
- `updated_by`

Required relationships:

- one `page_registry` record should resolve to one primary rendered page contract
- `page_key` should be the stable join target for:
  - head metadata
  - schema records
  - analytics defaults when page-scoped overrides exist
  - optional redirects
  - optional preview/baseline mappings
- `parent_page_id` should resolve within the same `site_key`
- `content_source_ref` should resolve to exactly one current content source for the selected `content_source_type`

Uniqueness constraints:

- `page_id` must be globally unique within the owning application
- `site_key + page_key` must be unique
- `site_key + route_path` must be unique for canonical page records
- `site_key + slug + parent_page_id` should be unique for hierarchical sibling pages unless a documented exception exists

Normalization constraints:

- `route_path` should be stored in one normalized extensionless form
- `route_path` should include a leading slash
- `route_path` should prefer a trailing slash convention or a non-trailing-slash convention consistently across the whole system
- `page_family`, `page_mode`, `template_key`, `nav_group_key`, and `sidebar_group_key` should use stable machine-readable ids rather than presentation copy
- `status` should be data-driven and must not depend on whether a physical `index.php` file exists
- follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md) for key and model naming

Lifecycle behavior expectations:

- `production`
  - page may resolve publicly
  - page may be indexable when `is_indexable` is true
- `review`
  - page may resolve on review hosts or behind auth
  - page should not be treated as a production-indexable page by default
- `draft`
  - page should not resolve publicly without an intentional preview path
- `archived`
  - page should either:
    - redirect
    - return `410`
    - or remain non-resolving by deliberate policy

Flat-file compatibility guidance:

- the registry can begin as one manifest file or one generated normalized array keyed by `page_key`
- flat-file implementations should still store:
  - stable `page_id`
  - `route_path`
  - `page_family`
  - `status`
  - `content_source_type`
  - `content_source_ref`
- do not make the filesystem path the primary identity field if database migration is a real target

Future PostgreSQL intent:

- `page_registry` should become a first-class table
- redirects may later move into a separate `page_redirects` table
- section-instance content may later move into related section tables keyed back to `page_id`
- tenant or multi-site ownership should prefer `site_key` or equivalent site id instead of assuming one global brochure site

Operational implication:

- a front controller or route resolver should depend on `route_path` plus `site_key`
- renderers should depend on `page_family`, `page_mode`, and `content_source_*`
- sitemap, breadcrumb, navigation, sidebar, head, and schema layers should all resolve from the same page-registry contract instead of maintaining separate path ownership rules

Related notes:

- [Packet README](README.md)
- [Section Instance Data Model](section-instance-data-model.md)
- [Template Catalog Data Model](template-catalog-data-model.md)
- [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
