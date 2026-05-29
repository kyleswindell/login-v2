---
doc_type: database
status: active
owner: shared
tags:
  - database
  - schema
  - sections
  - templates
  - content
---

# Section Instance Data Model

Purpose:

- define the canonical brochure-site section-definition and section-instance fields so page templates, page records, and future admin-managed content can share one durable section contract

Scope:

- this note defines the section-level data contract
- it is intended to work in both:
  - flat-file content JSON and manifest form
  - future PostgreSQL-backed storage inside a Laravel or similar admin system

Core entities:

- `section_definition`
  - one record per reusable section type or approved variant contract
  - defines what a section is allowed to contain
  - this is the logical contract name for the section catalog layer; future Laravel model and table naming should follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
- `section_instance`
  - one record per actual section placed on a page or preview baseline
  - stores the instance-level content and configuration for that page placement
  - this is the logical contract name for the page-owned section layer; future Laravel model and table naming should follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)

Required `section_definition` identity fields:

- `section_definition_id`
  - stable internal unique identifier
- `section_key`
  - stable machine-readable section contract id such as:
    - `service-detail.image-carousel`
    - `service-detail.left-text-right-image`
    - `shared.faq`
- `section_family`
  - broader grouping such as `service-detail`, `shared`, `hub`, or `legal`
- `section_variant`
  - optional controlled variant key when one base section contract supports multiple allowed visual or structural modes

Required `section_definition` contract fields:

- `label`
  - short human-readable name for admin or catalog display
- `description`
  - short explanation of the section's intended use
- `schema_version`
  - version key for the section field contract
- `field_schema`
  - canonical definition of the allowed fields for the section
- `allowed_page_families`
  - list of page families allowed to use this section
- `allowed_page_modes`
  - optional list of page modes allowed to use this section
- `asset_profile_key`
  - optional asset dependency profile for this section type

Recommended `section_definition` contract fields:

- `default_heading`
- `default_cta_profile_key`
- `supports_sidebar_context`
- `supports_repeater_items`
- `supports_background_media`
- `supports_schema_derivation`
- `preview_baseline_ref`
  - optional pointer to a canonical preview baseline example

Required `section_instance` identity fields:

- `section_instance_id`
  - stable internal unique identifier
- `page_id`
  - foreign key or equivalent reference to the owning page-registry record
- `section_definition_id`
  - foreign key or equivalent reference to the section definition
- `section_key`
  - denormalized stable machine-readable section id for portability and easier flat-file use

Required `section_instance` placement fields:

- `placement_key`
  - stable page-local identifier for the section placement
- `sort_order`
  - explicit order within the page
- `region_key`
  - page region such as `main`, `sidebar`, `below-content`, or `footer-band`
- `is_enabled`
  - controls whether the section should render

Required `section_instance` content fields:

- `content_payload`
  - structured instance data for the section
  - should match the selected `field_schema`
- `content_source_type`
  - identifies where the instance payload currently comes from
  - expected values should include:
    - `inline_json`
    - `shared_content`
    - `database`
    - `generated`
- `content_source_ref`
  - pointer to the current content source when payload is not fully inline

Recommended `section_instance` behavior fields:

- `display_mode_override`
  - optional override when the page uses an allowed non-default display mode
- `visibility_rule`
  - optional environment or status-based visibility rule
- `anchor_id`
  - optional in-page anchor id
- `nav_label_override`
  - optional short label when the section should appear in jump navigation
- `sidebar_group_override`
  - optional override when a section participates in derived sidebar logic
- `asset_profile_override`
  - optional instance-level asset override when allowed

Recommended `section_instance` lifecycle fields:

- `status`
  - preferred allowed values:
    - `production`
    - `review`
    - `draft`
    - `archived`
- `published_at`
- `archived_at`

Audit fields:

- `created_at`
- `updated_at`
- `created_by`
- `updated_by`

Field-schema expectations:

- `field_schema` should define:
  - required fields
  - optional fields
  - allowed data types
  - allowed repeater structures
  - whether rich text is allowed
  - whether media references are allowed
  - whether CTA objects are allowed
  - whether nested cards, slides, FAQs, or accordion items are allowed
- `field_schema` should remain machine-readable
- presentation copy should not be the field key source of truth

Required relationships:

- each `section_instance` must belong to one `page_registry` record through `page_id`
- each `section_instance` must resolve to one `section_definition`
- each page may have many section instances
- each section definition may be reused by many pages
- a page's `page_family` and `page_mode` should be validated against the section definition's allowlists

Uniqueness constraints:

- `section_definition_id` must be globally unique within the owning application
- `section_instance_id` must be globally unique within the owning application
- `section_key` should be unique within the section-definition catalog
- `page_id + placement_key` must be unique
- `page_id + sort_order + region_key` should be unique unless a documented exception exists

Normalization constraints:

- `section_key`, `section_family`, `section_variant`, `region_key`, and `asset_profile_key` should use stable machine-readable ids
- `sort_order` should always be explicit; section order should not depend on filesystem order or implicit array position alone
- `content_payload` should remain data-like and should not embed renderer or layout code
- section instances should not store raw assumptions about physical route files or filesystem structure
- follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md) for section, profile, and asset key naming

Template-alignment expectations:

- page templates should define allowed section-definition sets, not hardcoded one-off HTML assumptions
- `section_profile_key` on the page registry should be able to map to:
  - an approved ordered set of section definitions
  - an allowlist of optional section definitions
  - optional region and order constraints
- two pages may share a `page_family` while using different approved `section_profile_key` values

Flat-file compatibility guidance:

- flat-file content JSON may store section instances as ordered arrays
- flat-file implementations should still preserve:
  - stable `section_key`
  - explicit `sort_order`
  - explicit `placement_key`
  - structured `content_payload`
- when section definitions are not yet externalized, the content model should still be written so those definitions can later be extracted into a catalog without rewriting every page

Future PostgreSQL intent:

- `section_definition` should become a reusable catalog table
- `section_instance` should become a page-owned content table keyed to `page_id`
- repeater children may later become normalized child tables only when needed; they do not need to be split out prematurely
- shared section content may later use separate shared-content tables when multiple pages intentionally reuse the same authored content block

Operational implication:

- renderers should consume section instances through validated section definitions rather than free-form ad hoc arrays
- asset loading can aggregate from section definitions or instance overrides
- admin UI can present only the sections allowed for the selected page family, page mode, and section profile
- preview baselines can use the same section-instance contract as live pages

Related notes:

- [Packet README](README.md)
- [Page Registry Data Model](page-registry-data-model.md)
- [Template Catalog Data Model](template-catalog-data-model.md)
- [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
