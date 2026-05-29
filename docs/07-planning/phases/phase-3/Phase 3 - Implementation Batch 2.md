# Phase 3 - Implementation Batch 2

This document defines the canonical scope and intent for Phase 3 - Implementation Batch 2.

## Purpose

Define the first implementation batch for the brochure-sites subsystem by delivering the initial hybrid portable-contract slice:

* Laravel-native brochure authoring
* published brochure contract generation
* integrated Laravel delivery from published payloads
* Astro-compatible contract outputs

## Implementation Status

Current status:

* planning drafted
* not started in code

Parent planning notes:

* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## Batch Goal

Deliver the first dependency-safe brochure slice required before broader brochure family rollout:

* one brochure site control-plane record
* one brochure page authoring flow
* one publication pipeline
* one integrated public delivery route
* one portable published contract that a future Astro adapter can consume unchanged

## Why This Batch Early

This batch establishes brochure primitives that later page families and public-facing modules will rely on:

* site and domain ownership
* page registry ownership
* section-instance authoring contract
* authoring-to-publication separation
* public rendering from published state instead of direct editorial state

## In Scope

* central control-plane records for `BrochureSite` and `BrochureDomain`
* shared catalog baseline for `TemplateDefinition`, `SectionDefinition`, and `SectionProfile`
* tenant-owned `Page`, `SectionInstance`, and `PageRedirect` baseline
* one service-detail or detail page family proof with one template and one section profile
* three to five reusable section definitions
* page lifecycle support for `draft`, `review`, and `production`
* publication records for `BrochurePublication`, `PublishedPage`, and `PublishedRedirect`
* publication manifest generation
* integrated Laravel route resolution for brochure hosts
* integrated Laravel public rendering from published payloads
* signed preview proof for the first release slice
* cache invalidation event or manifest output on publish
* tests for publication payload generation, route resolution, lifecycle enforcement, and redirect behavior

## Out Of Scope

* broad multi-family brochure rollout
* admin-managed template editing
* full media library design
* Astro runtime implementation
* static export pipeline hardening
* customer-authenticated portal surfaces unrelated to brochure delivery

## Canonical Scope References

This batch intentionally depends on canonical details that live outside planning:

* architecture and namespace boundaries:
  * [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
  * [Application Structure](../../../03-architecture/subsystems/application-structure.md)
* behavior and lifecycle rules:
  * [Brochure Sites Authoring And Publishing](../../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* flow and delivery responsibilities:
  * [Brochure Integrated Delivery Flow](../../../05-flows/brochure-integrated-delivery-flow.md)
  * [Brochure Astro Delivery Flow](../../../05-flows/brochure-astro-delivery-flow.md)
* exact models, tables, and published-contract shape:
  * [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)

Planning ownership for this note is limited to batch scope, sequencing, dependency order, and acceptance intent.

Deferred immediately after this batch when review-state access needs broader stakeholder coverage:

* review-host support for `review` pages

## Recommended Order

1. Define brochure site and domain records.
2. Define template, section-definition, and section-profile catalog baseline.
3. Define page and section-instance authoring records.
4. Build one page-family authoring proof.
5. Build publication record and payload generation.
6. Build integrated Laravel brochure route resolution from published state.
7. Build preview/review proof.
8. Add tests for lifecycle, redirects, and payload generation.

## Locked Batch Defaults

This batch assumes these locked defaults:

* brochure routes use trailing-slash canonical paths, except root `/`
* signed preview ships first for `draft`
* review-host support follows for `review`
* publication writes PostgreSQL published tables and storage artifacts
* template and section catalogs remain central-only in the first release
* the first proof uses one service-detail or detail page family

## Acceptance Criteria

* one brochure host resolves to one `BrochureSite`
* one authored brochure page can move from `draft` to `review` to `production`
* publication creates a portable page payload rather than relying on direct public reads from draft authoring state
* integrated Laravel delivery renders the page from published payload data
* the integrated resolver enforces canonical trailing-slash brochure paths
* redirect and archive behavior is explicit and testable
* the published payload shape is sufficient for a later Astro adapter without changing authoring records
* tests pass for path normalization, lifecycle visibility, publication output, and integrated route resolution
* canonical docs and planning notes remain synchronized in the same work cycle

## Validation Surface

Validation should cover:

* control-plane, authoring, publication, and delivery work all land in the intended sequence
* page publication proves the authoring-to-publication boundary before public rendering hardens
* public resolution, lifecycle rules, canonical redirects, and preview/review handling are covered in the first proof
* the published contract remains portable enough for a later Astro adapter without revisiting the authoring model

## Data Contract Reference

Schema, table, and publication contract details are canonicalized in:

* [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)

Architecture and behavior ownership are canonicalized in:

* [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Authoring And Publishing](../../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Integrated Delivery Flow](../../../05-flows/brochure-integrated-delivery-flow.md)
* [Brochure Astro Delivery Flow](../../../05-flows/brochure-astro-delivery-flow.md)

## Dependencies

* [Phase 2 - Final Stack And UI System Planning](../phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)

## Related

* [Phase 3 Index](Phase%203%20Index.md)
* [Phase 3 Batches](../../batches/phase-3/index.md)
* [Phase 3 - Brochure Batch 2 Implementation Prep](Phase%203%20-%20Brochure%20Batch%202%20Implementation%20Prep.md)
* [Feature Roadmap](../../roadmap.md)
