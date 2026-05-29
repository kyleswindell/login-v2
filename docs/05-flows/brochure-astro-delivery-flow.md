# Brochure Astro Delivery Flow

This document defines the canonical scope and intent for Brochure Astro Delivery Flow.

Status: Planned (not implemented)

## Purpose

Define the request flow when public brochure traffic is rendered by Astro or another decoupled frontend adapter.

## Preconditions

Astro delivery assumes:

* Laravel remains the canonical brochure authoring and publishing system
* Astro consumes published brochure state only
* Astro does not mutate editorial truth
* host ownership and page lifecycle rules remain aligned to Laravel-published contract data

## Flow

1. accept request
   * receive host, scheme, method, path, query, and environment context
2. resolve brochure site
   * load site manifest or host map for the request host
3. normalize route path
   * apply the same canonical path policy used by Laravel publishing
4. resolve published route
   * load published route entry, page payload reference, or redirect entry
5. apply lifecycle and canonical checks
   * honor `draft`, `review`, `production`, and `archived` semantics as published
6. load published payload
   * load page payload, head payload, schema payload, navigation data, and asset hints
7. render Astro response
   * map the payload into Astro page and section components
8. emit response
   * send HTML, redirect, `404`, or `410` as required

## Published Data Sources

Astro may read published brochure state through:

* Laravel delivery API
* versioned JSON artifacts
* read-only published tables or views

Whichever source is used, the contract must remain the same.

## Rendering Rule

Astro should be a thin delivery adapter.

It should not:

* infer unpublished editorial state
* re-implement authoring validation
* own redirect policy
* own lifecycle semantics separately from Laravel

## Cache Behavior

Astro delivery may use:

* CDN caching
* edge caching
* static page generation
* ISR-like rebuild patterns where appropriate

Cache and rebuild triggers must originate from Laravel publishing events or publication manifests.

## Cutover Rule

Host-by-host cutover is preferred.

That means:

* Laravel integrated delivery and Astro delivery may coexist during transition
* both must consume the same published contract
* changing delivery adapters must not require content-model or workflow rewrites

## Related

* [Flows Index](index.md)
* [Brochure Sites Subsystem](../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Authoring And Publishing](../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Sites Data Contract](../06-database/feature-contracts/brochure-sites.md)
* [Brochure Integrated Delivery Flow](brochure-integrated-delivery-flow.md)
