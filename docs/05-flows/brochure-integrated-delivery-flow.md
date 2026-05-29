# Brochure Integrated Delivery Flow

This document defines the canonical scope and intent for Brochure Integrated Delivery Flow.

Status: Planned (not implemented)

## Purpose

Define the request flow when Laravel serves public brochure traffic directly in integrated delivery mode.

## Preconditions

Integrated delivery assumes:

* Laravel remains the public entrypoint
* host ownership resolves to a brochure site
* published brochure data is available
* integrated rendering reads published payloads rather than raw editorial state where possible

## Flow

1. accept request
   * receive host, scheme, method, path, query, and environment context
2. resolve site context
   * map host to one brochure site record
   * reject unknown or inactive brochure hosts
3. normalize route path
   * apply extensionless path rules
   * apply the canonical brochure trailing-slash policy for non-root pages
   * derive the canonical `route_path`
4. check reserved endpoints
   * allow explicit non-brochure endpoints to exit before page resolution
5. resolve published route
   * load the published page or redirect for `site + route_path`
6. apply lifecycle handling
   * enforce `draft`, `review`, `production`, and `archived` behavior
7. apply canonical behavior
   * redirect non-canonical no-slash requests to the canonical trailing-slash path
   * redirect when canonical path requires it
8. resolve published page payload
   * load template key, page family, page mode, ordered sections, head payload, schema payload, and asset hints
9. render response
   * map the published payload into the Laravel brochure renderer
10. emit response
   * send HTML, redirect, `404`, or `410` as required

## Rendering Rule

Integrated delivery should not bypass the publish contract by rebuilding page meaning from ad hoc authoring tables inside controllers.

The public renderer should consume the same contract shape that a future Astro adapter will consume.

## Missing Route Behavior

When no published brochure route matches:

* check published redirects
* otherwise emit the standardized brochure `404`

## Cache Behavior

Integrated delivery may cache:

* site host resolution
* route index lookups
* published page payloads
* rendered response fragments where safe

Cache invalidation must be driven by brochure publish events rather than ad hoc manual clears.

## Related

* [Flows Index](index.md)
* [Brochure Sites Subsystem](../03-architecture/subsystems/brochure-sites-subsystem.md)
* [Brochure Sites Authoring And Publishing](../04-features/brochure/brochure-sites-authoring-and-publishing.md)
* [Brochure Sites Data Contract](../06-database/feature-contracts/brochure-sites.md)
* [Brochure Astro Delivery Flow](brochure-astro-delivery-flow.md)
