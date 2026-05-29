---
doc_type: standard
status: active
owner: shared
tags:
  - standards
  - naming
  - database
  - templates
  - sections
---

# Catalog and Model Naming Standard

Purpose:

- define the naming conventions for brochure-site catalogs, models, registry records, and machine-readable keys so the current flat-file system can evolve into a Laravel and PostgreSQL-backed admin model without naming drift

Naming layers:

- human-facing labels
  - readable admin or catalog copy such as `Commercial Detail Page`
- machine-readable keys
  - stable identifiers used across config, manifests, routing, and rendering
- physical implementation names
  - future Laravel model names, PHP classes, PostgreSQL table names, and column names

Core rules:

- keep human-facing labels separate from machine-readable keys
- treat machine-readable keys as stable API and content-contract values
- do not encode filesystem assumptions into canonical keys
- do not use visual presentation copy as a primary identifier
- prefer explicit naming over abbreviations when the abbreviation is not already a durable domain term

Model and class naming:

- PHP classes and Laravel models should use singular PascalCase
- preferred examples:
  - `Page`
  - `TemplateDefinition`
  - `SectionDefinition`
  - `SectionProfile`
  - `SectionInstance`
  - `PageRedirect`
  - `Site`

Table naming:

- PostgreSQL tables should use plural snake_case
- preferred examples:
  - `pages`
  - `template_definitions`
  - `section_definitions`
  - `section_profiles`
  - `section_instances`
  - `page_redirects`
  - `sites`

Column naming:

- columns should use snake_case
- foreign keys should use singular stem plus `_id`
- preferred examples:
  - `page_id`
  - `template_definition_id`
  - `section_definition_id`
  - `section_profile_id`
  - `site_id`

Stable machine-key naming:

- stable keys should use lowercase segments
- segment separators should follow these rules:
  - dots separate namespaces or contract layers
  - hyphens separate words inside one segment
- preferred examples:
  - `detail.commercial`
  - `detail.commercial.default`
  - `service-detail.left-text-right-image`
  - `shared.faq`
  - `shell.subpage-sidebar-left`

Disallowed or discouraged machine-key patterns:

- mixed casing such as `DetailCommercial`
- spaces
- underscores inside stable machine keys when dot-plus-kebab notation is the chosen contract layer
- ad hoc abbreviations such as `img` when `image` is clearer
- donor- or client-specific copy embedded into reusable catalog keys unless the catalog record is intentionally site-specific

Allowed abbreviation guidance:

- allow well-established domain abbreviations only when they are already first-class repo or implementation terms
- acceptable examples may include:
  - `faq`
  - `cta`
  - `rfq`
  - `seo`
- prefer full words when there is any ambiguity

Template-key convention:

- `template_key` should use:
  - `<page-family>.<page-mode>`
  - or `<page-family>.default` when no special mode exists
- preferred examples:
  - `home.default`
  - `hub.category-card`
  - `detail.commercial`
  - `contact.rfq`

Section-definition-key convention:

- `section_key` should use:
  - `<scope>.<section-type>`
  - or `<scope>.<section-type>.<variant>` when a third segment is required
- `scope` should normally be:
  - the owning page family
  - or `shared` for cross-family sections
- preferred examples:
  - `service-detail.image-carousel`
  - `service-detail.left-text-right-image`
  - `service-detail.left-text-right-info-card`
  - `shared.faq`

Section-profile-key convention:

- `section_profile_key` should extend the template identity rather than replace it
- preferred format:
  - `<template-key>.<profile-name>`
- preferred examples:
  - `detail.commercial.default`
  - `detail.commercial.alt-a`
  - `service-detail.support.info-card-heavy`

Profile-key convention:

- non-template profile keys such as shell, asset, sidebar, head, schema, and CTA profiles should use:
  - `<domain>.<profile-name>`
- preferred examples:
  - `asset.carousel-heavy`
  - `shell.subpage-sidebar-left`
  - `sidebar.capabilities-default`
  - `schema.detail-commercial`

Page-key convention:

- `page_key` should remain a stable join key independent from the public route path
- for new registry-driven systems, prefer logical dot notation when it materially improves uniqueness or hierarchy clarity
- preferred examples:
  - `home`
  - `capabilities`
  - `capabilities.four-slide-stamping`
- legacy flat page keys may remain in transitional systems where changing them would create avoidable drift

Route-path convention:

- `route_path` should stay separate from `page_key`
- `route_path` should use:
  - leading slash
  - extensionless path
  - one consistent trailing-slash policy across the system

Enum and status naming:

- enum-like stored values should use lowercase snake_case
- single-word values remain single lowercase words
- preferred examples:
  - `production`
  - `review`
  - `draft`
  - `archived`
  - `content_json`
  - `legacy_php`

Migration safety rule:

- treat machine-readable keys as long-lived contracts
- changing a human-facing label should not require changing:
  - `template_key`
  - `section_key`
  - `section_profile_key`
  - `page_key`

Related notes:

- [Packet README](README.md)
- [Page Registry Data Model](page-registry-data-model.md)
- [Section Instance Data Model](section-instance-data-model.md)
- [Template Catalog Data Model](template-catalog-data-model.md)
