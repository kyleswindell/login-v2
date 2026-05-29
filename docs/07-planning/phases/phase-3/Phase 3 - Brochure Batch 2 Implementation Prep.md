# Phase 3 - Brochure Batch 2 Implementation Prep

This document defines the canonical scope and intent for Phase 3 - Brochure Batch 2 Implementation Prep.

## Purpose

Break [Phase 3 - Implementation Batch 2](Phase%203%20-%20Implementation%20Batch%202.md) into a concrete future build checklist so implementation can start with minimal batch-start ambiguity.

This note is execution-prep planning only. It does not replace the batch scope note.

## Use At Batch Start

When Batch 2 becomes active:

1. confirm the locked brochure decisions still stand
2. move this checklist into `/docs/08-active/`
3. execute in the recommended order unless a dependency forces a documented deviation

## Canonical Detail Sources

This prep note should not become a second architecture, database, or implementation-design document.

Use these canonical sources when Batch 2 starts:

* system boundary and namespace direction:
  * [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
  * [Application Structure](../../../03-architecture/subsystems/application-structure.md)
* behavior and lifecycle:
  * [Brochure Sites Authoring And Publishing](../../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* request and delivery paths:
  * [Brochure Integrated Delivery Flow](../../../05-flows/brochure-integrated-delivery-flow.md)
  * [Brochure Astro Delivery Flow](../../../05-flows/brochure-astro-delivery-flow.md)
* schema, model, and publication-shape details:
  * [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)

This note owns execution order and readiness checks only.

## Execution Sequence

Recommended execution order:

1. control-plane brochure site and host ownership foundation
2. shared catalog baseline and tenant authoring baseline
3. publication pipeline and portable contract generation
4. integrated Laravel delivery from published state
5. admin publishing surface, cache invalidation, and validation hardening

Rules:

* finish the authoring-to-publication boundary before treating integrated delivery as stable
* keep public rendering dependent on published state rather than direct editorial reads
* keep Astro readiness as a contract check, not as same-batch runtime implementation

## Validation Focus

Batch implementation should verify:

* known brochure hosts resolve cleanly and unknown hosts fail closed
* route normalization and canonical trailing-slash behavior remain deterministic
* lifecycle handling cleanly separates `draft`, `review`, `production`, and archive/redirect outcomes
* publication outputs are deterministic enough for both integrated Laravel delivery and later Astro consumption
* publish actions trigger the expected invalidation or manifest refresh signals

## Recommended Build Passes

### Pass 1

* confirm control-plane and tenant ownership boundaries
* land the minimum persistence and path-normalization foundation needed for the first brochure slice

### Pass 2

* land the first authoring and catalog baseline
* prove one page-family authoring flow

### Pass 3

* land publication and portable-contract generation
* prove authoring-to-publication separation

### Pass 4

* land integrated Laravel delivery from published state
* prove signed preview for the chosen first family

### Pass 5

* harden admin publish actions, invalidation behavior, and docs/test sync

## Recommended First Family Shape

Use one detail-family template with:

* hero
* text/media split
* feature or capability cards
* FAQ
* CTA band

This is the preferred first proof because it exercises the contract cleanly without homepage-specific exceptions.

## Batch-Start Checklist

Before opening execution:

* confirm central versus tenant DB boundaries for this batch
* confirm review-preview access mode for the first slice
* confirm first template key and section profile key
* confirm whether `published_navigation_snapshots` is needed in the same batch
* confirm whether artifacts write to local storage first or object storage

## Related

* [Phase 3 - Implementation Batch 2](Phase%203%20-%20Implementation%20Batch%202.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
* [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)
