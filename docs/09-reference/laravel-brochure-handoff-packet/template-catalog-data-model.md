---
doc_type: database
status: active
owner: shared
tags:
  - database
  - schema
  - templates
  - catalog
  - pages
---

# Template Catalog Data Model

Purpose:

- define the canonical template-definition fields and constraints so `template_key`, `page_family`, `page_mode`, and `section_profile_key` resolve through one durable brochure-site template catalog

Scope:

- this note defines the template-catalog data contract
- it is intended to work in both:
  - flat-file manifest form
  - future PostgreSQL-backed storage inside a Laravel or similar admin system

Core entities:

- `template_definition`
  - one record per reusable page template contract
  - owns page-family, mode, shell, and section-profile rules
  - this is the logical contract name for the template catalog layer; future Laravel model and table naming should follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
- `section_profile`
  - one record per approved section arrangement profile used by one or more templates or pages
  - owns the allowed ordered section-definition set for a given profile
  - this is the logical contract name for the section-profile layer; future Laravel model and table naming should follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)

Required `template_definition` identity fields:

- `template_definition_id`
  - stable internal unique identifier
- `template_key`
  - stable machine-readable template id such as:
    - `home.default`
    - `hub.category-card`
    - `detail.commercial`
    - `service-detail.support`
- `page_family`
  - canonical renderer family such as `home`, `hub`, `detail`, `contact`, `legal`, or `error`
- `page_mode`
  - optional controlled family mode such as `category-card`, `pathway-and-category`, `commercial`, or `support`

Required `template_definition` contract fields:

- `label`
  - short admin- or catalog-facing name
- `description`
  - short explanation of intended template use
- `template_status`
  - preferred allowed values:
    - `active`
    - `draft`
    - `deprecated`
    - `archived`
- `shell_profile_key`
  - global shell contract key for header, footer, subpage header, breadcrumbs, sidebar ownership, and other page-frame concerns
- `default_section_profile_key`
  - default approved section arrangement profile for this template
- `allowed_section_profile_keys`
  - optional list of section profiles allowed under this template when siblings may use different approved arrangements
- `allowed_section_definition_keys`
  - allowlist of section definitions usable by the template

Recommended `template_definition` contract fields:

- `preview_baseline_ref`
  - optional pointer to the canonical preview baseline record
- `asset_profile_key`
  - optional page-level asset dependency profile
- `sidebar_profile_key`
  - optional sidebar or sibling-navigation ownership profile
- `cta_profile_key`
  - optional default CTA behavior/profile key
- `schema_profile_key`
  - optional schema derivation profile key
- `head_profile_key`
  - optional head derivation profile key
- `supports_child_pages`
- `supports_parent_page_linkage`

Required `section_profile` identity fields:

- `section_profile_id`
  - stable internal unique identifier
- `section_profile_key`
  - stable machine-readable id such as:
    - `detail.commercial.default`
    - `detail.commercial.alt-a`
    - `service-detail.support.info-card-heavy`

Required `section_profile` contract fields:

- `label`
- `description`
- `page_family`
  - family this section profile is intended to support
- `page_mode`
  - optional mode this section profile is intended to support
- `ordered_section_slots`
  - canonical ordered slot definition list for the profile

Recommended `section_profile` contract fields:

- `optional_section_definition_keys`
- `required_section_definition_keys`
- `region_rules`
- `max_instance_rules`
- `asset_profile_key`
- `preview_baseline_ref`

Required `ordered_section_slots` expectations:

- each slot should define:
  - `slot_key`
  - `sort_order`
  - `region_key`
  - `allowed_section_definition_keys`
  - whether the slot is required
  - whether repeat instances are allowed
- slot rules should be machine-readable and should not depend on prose-only interpretation

Required relationships:

- each `page_registry.template_key` should resolve to one `template_definition`
- each `page_registry.section_profile_key` should resolve to one `section_profile` when present
- each `template_definition.default_section_profile_key` should resolve to one `section_profile`
- each `section_profile` should be validated against:
  - the template's `page_family`
  - the template's `page_mode`
  - the template's `allowed_section_definition_keys`
- each `section_instance.section_key` should be validated against the selected template and section profile

Uniqueness constraints:

- `template_definition_id` must be globally unique within the owning application
- `section_profile_id` must be globally unique within the owning application
- `template_key` must be unique within the owning application
- `section_profile_key` must be unique within the owning application
- `page_family + page_mode + template_key` must not collide with another active template definition

Normalization constraints:

- `template_key`, `page_family`, `page_mode`, `shell_profile_key`, `asset_profile_key`, `sidebar_profile_key`, `cta_profile_key`, `head_profile_key`, `schema_profile_key`, and `section_profile_key` should use stable machine-readable ids
- template definitions should not embed route paths or physical filesystem assumptions
- section profiles should describe approved structure, not duplicate full page content
- a page may override the section profile when the selected template explicitly allows more than one profile
- follow [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md) for template, profile, and model naming

Lifecycle behavior expectations:

- `active`
  - may be assigned to production pages
- `draft`
  - may be used for preview or internal testing only
- `deprecated`
  - may continue supporting older pages but should not be the default for new pages
- `archived`
  - should not be assigned to new pages and should normally be hidden from active admin selection

Flat-file compatibility guidance:

- template definitions can begin as one manifest keyed by `template_key`
- section profiles can begin as one manifest keyed by `section_profile_key`
- flat-file implementations should still preserve:
  - stable `template_key`
  - stable `section_profile_key`
  - explicit allowlists
  - explicit ordered slot rules
- do not rely on implicit renderer assumptions alone if database-backed admin control is a real target

Future PostgreSQL intent:

- `template_definition` should become a reusable catalog table
- `section_profile` should become a reusable profile table
- template-to-section-definition allowlists may later move into join tables when normalization is beneficial
- admin UI should be able to offer:
  - template selection by `template_key`
  - allowed section-profile selection by `section_profile_key`
  - section-instance editing constrained by the selected profile and section catalog

Operational implication:

- renderers should depend on `page_family` and `page_mode`, but template selection should be tracked explicitly through `template_key`
- page creation should choose a template first, then a valid section profile, then valid section instances
- preview baselines should map to template definitions and section profiles, not to ad hoc one-off page assumptions
- front-controller routing, head, schema, sitemap, sidebar, and admin page-editing flows should all be able to resolve back to the same template-definition layer

Related notes:

- [Packet README](README.md)
- [Page Registry Data Model](page-registry-data-model.md)
- [Section Instance Data Model](section-instance-data-model.md)
- [Catalog and Model Naming Standard](catalog-and-model-naming-standard.md)
