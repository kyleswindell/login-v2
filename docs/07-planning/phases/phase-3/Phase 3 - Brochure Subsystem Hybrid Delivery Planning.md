# Phase 3 - Brochure Subsystem Hybrid Delivery Planning

This document defines the canonical scope and intent for Phase 3 - Brochure Subsystem Hybrid Delivery Planning.

## Purpose

Plan the brochure-sites subsystem under the chosen hybrid portable-contract strategy:

* Laravel-native authoring and publishing
* portable published brochure contract
* integrated Laravel delivery supported first
* Astro delivery supported later as a thin adapter

## Planning Status

Current status:

* planning drafted
* no brochure subsystem implementation started
* hybrid portable-contract model selected as the long-term direction

Parent phase:

* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## Planning Decision Summary

The system should not choose between:

* Laravel as CMS
* separate frontend as public renderer

too early at the cost of rewrite safety.

Instead it should lock:

* one canonical authoring model in Laravel
* one portable published contract
* one transition path where Laravel and Astro can both render from the same published outputs

## Target Deliverables

This planning track should produce:

1. brochure subsystem architecture boundary
2. brochure feature behavior contract
3. brochure exact data model and publish plane direction
4. integrated Laravel delivery flow
5. Astro delivery flow
6. first vertical-slice implementation plan

## Recommended Delivery Sequence

### Stage 1: Authoring Foundation

Build:

* brochure site registry
* brochure domain registry
* page registry
* section instances
* template and section catalog baseline
* preview and review workflow

### Stage 2: Publish Contract

Build:

* site publication record
* published page payload generation
* published redirect generation
* manifest and invalidation payload generation

Rule:

* before public rendering hardens, the publish contract must harden first

### Stage 3: Integrated Laravel Delivery

Build:

* host-aware brochure route resolver
* integrated public rendering from published payloads
* public redirect handling
* canonical and sitemap behavior

### Stage 4: Astro Delivery Adapter

Build:

* published contract API or artifact feed
* Astro route resolver and section rendering adapter
* host-by-host cutover support

## Recommended First Vertical Slice

The first proof should be intentionally narrow.

Recommended slice:

* one `BrochureSite`
* one production domain
* one signed-preview mode for the first proof
* one page family
* one template definition
* one section profile
* three to five reusable section definitions
* page CRUD with ordered section instances
* `draft -> review -> production` lifecycle
* one site publication record
* one published page payload
* integrated Laravel delivery reading that published payload
* review-domain support planned as a follow-up after signed preview ships

This first slice proves:

* central versus tenant ownership
* authoring-to-publish separation
* portable contract generation
* integrated delivery without locking out Astro later

## Batch Recommendation

Recommended implementation sequencing:

1. control-plane site and domain records
2. tenant page and section authoring records
3. publish plane records and manifest generation
4. integrated Laravel delivery adapter
5. Astro proof adapter after the contract is stable

## Locked Decisions

The following implementation-shaping decisions are now locked for the brochure subsystem:

1. brochure routes use trailing-slash canonical paths, except root `/`
2. signed preview ships first for `draft`, then review-host support is added for `review`, with both supported after that
3. publication writes both PostgreSQL published tables and storage artifacts
4. template and section catalogs remain central-only in the first release
5. the first proof uses one service-detail or detail page family

## Entry Criteria

Brochure implementation should not start until:

* the hybrid portable-contract direction is accepted
* tenant versus control-plane ownership is accepted
* the locked brochure decisions above are accepted as the batch defaults

## Exit Criteria For The Planning Track

This planning track is complete when:

* architecture boundary is documented
* feature contract is documented
* data contract is documented
* both delivery flows are documented
* the first implementation slice is explicitly scoped

## Related

* [Phase 3 Index](Phase%203%20Index.md)
* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Phase 3 - Implementation Batch 2](Phase%203%20-%20Implementation%20Batch%202.md)
* [Phase 3 - Brochure Batch 2 Implementation Prep](Phase%203%20-%20Brochure%20Batch%202%20Implementation%20Prep.md)
* [Brochure Sites Subsystem](../../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Authoring And Publishing](../../../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Sites Data Contract](../../../06-database/feature-contracts/brochure-sites.md)
* [Brochure Integrated Delivery Flow](../../../05-flows/brochure-integrated-delivery-flow.md)
* [Brochure Astro Delivery Flow](../../../05-flows/brochure-astro-delivery-flow.md)
