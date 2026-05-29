---
doc_type: feature
status: active
owner: shared
tags:
  - features
  - pages
  - lifecycle
  - preview
  - routing
---

# Page Lifecycle and Preview Delivery

Purpose:

- define the expected behavior for brochure-page lifecycle states, preview access, canonical handling, and sitemap eligibility

Scope:

- this note defines runtime behavior
- it applies whether page resolution is still flat-file based or later moves to a registry-driven front controller

Lifecycle states:

- `production`
  - page may resolve publicly on the production host
  - page may be indexable when `is_indexable` is true
  - page should participate in normal canonical handling
- `review`
  - page may resolve on the configured review host or behind auth
  - page should not be production-indexable by default
  - page may share the same renderer and template path as production pages
- `draft`
  - page should not resolve publicly through the normal production route
  - page may resolve only through an intentional preview path or authenticated internal review flow
- `archived`
  - page should not remain a normal live content route
  - page should either:
    - redirect
    - return `410`
    - or remain intentionally non-resolving by policy

Canonical behavior:

- production pages should emit canonical values aligned with the production public route
- review and preview views should not behave like separate canonical public pages
- a review host should not claim production canonical ownership for a page that is not yet live
- canonical redirects should be applied only where the page lifecycle and environment make that redirect correct

Robots behavior:

- production pages may emit the intended indexation behavior for the site
- review pages should default to non-production robots behavior
- preview-only and draft-only paths should not be treated as production-indexable pages
- archived routes should follow the chosen redirect or non-resolving policy and should not remain discoverable as active content

Preview behavior:

- preview should use the same renderer family and shared shell contracts as the live page system
- preview should not create a second visual system
- preview should be able to render:
  - template baselines
  - review-state pages
  - draft pages when explicitly allowed
- preview URLs should be explicit and should not silently replace the public route contract

Sitemap behavior:

- production sitemap output should include only pages eligible for public production discovery
- review, draft, preview-only, and archived pages should be excluded from the production sitemap by default
- alternate review-host sitemap behavior should be opt-in and should not be confused with production sitemap ownership

Navigation and sidebar behavior:

- production navigation should not surface draft or archived pages by default
- review environments may surface review-state pages when that is helpful for stakeholder review
- derived sidebar and sibling-navigation behavior should respect lifecycle visibility rules rather than only page hierarchy

Operational implication:

- page lifecycle is a first-class behavior contract, not just a content label
- route resolution, head/schema, sitemap, navigation, and preview delivery should all interpret lifecycle state consistently

Related notes:

- [Packet README](README.md)
- [Page Registry Data Model](page-registry-data-model.md)
- [Route Resolver and Front Controller Flow](route-resolver-front-controller-flow.md)
