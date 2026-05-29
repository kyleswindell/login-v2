# Brochure Sites Authoring And Publishing

This document defines the canonical scope and intent for Brochure Sites Authoring And Publishing.

Status: Planned (not implemented)

## Purpose

Define the expected behavior contract for brochure-site authoring, preview, review, publish, and archive workflows.

This note owns brochure behavior only. Architecture boundaries, flow steps, and schema contracts are owned in their respective branches.

## Editorial Model

Brochure content is authored through structured records:

* brochure site
* page registry record
* template assignment
* section profile selection
* ordered section instances
* head and schema inputs or overrides
* redirect and lifecycle controls

Editors should operate on structured content, not on one-off route files or unmanaged HTML blobs.

## Lifecycle States

Planned lifecycle states:

* `draft`
  * editable
  * not publicly discoverable
  * accessible only through explicit preview handling
* `review`
  * available for stakeholder review
  * not production-indexable
  * available through review host, signed preview, auth gate, or an approved combination
* `production`
  * publicly resolvable
  * eligible for sitemap and normal canonical handling when `is_indexable` is true
* `archived`
  * not a normal public page
  * returns redirect, `410`, or non-resolving behavior by policy

## Preview And Review

Preview and review must use the same page system as production.

Rules:

* preview must not create a second rendering system
* draft preview must be explicit
* review-state pages must not claim production canonical ownership
* review delivery must remain excluded from production sitemap behavior

Approved preview/review channels may include:

* signed preview URLs
* authenticated internal preview
* review host with noindex behavior
* both review host and signed preview where justified

Locked default sequence:

* first release uses signed preview URLs for `draft`
* next release adds review-host support for `review`
* both remain valid channels after review-host support exists

## Publish Contract

Publish converts editorial state into a delivery-safe published contract.

Publish must resolve:

* effective route ownership
* selected template definition
* selected section profile
* validated ordered section instances
* head and schema payloads
* redirect state
* navigation and sitemap eligibility

Public delivery must consume published state rather than reconstructing editorial logic from scratch on every request.

## Integrated And Decoupled Delivery Rule

Behavior must remain consistent across both delivery modes.

That means:

* the same lifecycle semantics
* the same canonical rules
* the same redirect behavior
* the same page payload meaning
* the same sitemap eligibility rules

Changing the public renderer must not change brochure business behavior.

## Template And Section Governance

Recommended baseline:

* templates are developer-governed first
* section definitions are developer-governed first
* editors manage page assignment, ordered section instances, content payloads, and approved overrides
* templates and section catalogs remain central-only in the first release

Admin-managed template editing may be added later only after the underlying render contract is stable.

## Publish Modes

Allowed future publish models may include:

* immediate publish
* draft plus review plus publish
* versioned site publication batches

Recommended default direction:

* draft plus review plus publish
* site-level publication manifest
* explicit cache invalidation on publish

## Redirect And Archive Behavior

When a page is retired:

* redirect rules should be explicit
* archival should not leave abandoned public routes unresolved by accident
* delivery adapters should read the same redirect intent from published state

## Admin Boundary

Platform-owned brochure behavior:

* site provisioning
* domain ownership
* publishing policy defaults
* review-host policy

Tenant-owned brochure behavior:

* page authoring
* section authoring
* preview and review operations
* publish requests where allowed
* redirect management within tenant-owned brochure scope

## First Vertical Slice Behavior

The first proof should cover:

* one brochure site
* one production host
* one signed preview path for the first proof
* one service-detail or detail page family
* one template
* one section profile
* several reusable section definitions
* one `draft -> review -> production` path
* review-host support deferred to a later follow-up

## Related

* [Features Index](../index.md)
* [Brochure Sites Subsystem](../../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Data Contract](../../06-database/feature-contracts/brochure-sites.md)
* [Brochure Integrated Delivery Flow](../../05-flows/brochure-integrated-delivery-flow.md)
* [Brochure Astro Delivery Flow](../../05-flows/brochure-astro-delivery-flow.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](../../07-planning/phases/phase-3/Phase%203%20-%20Brochure%20Subsystem%20Hybrid%20Delivery%20Planning.md)
