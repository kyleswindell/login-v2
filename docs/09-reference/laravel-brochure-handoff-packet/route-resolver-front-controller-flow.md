---
doc_type: flow
status: active
owner: shared
tags:
  - flows
  - routing
  - front-controller
  - registry
---

# Route Resolver and Front Controller Flow

Purpose:

- define the execution path for resolving brochure-site requests through a front controller and page registry instead of one physical route file per page

Scope:

- this flow applies to the future registry-driven routing model
- it complements the page registry, template catalog, and section-instance data models
- it does not require immediate database-backed implementation; the same flow can start from flat-file registry data

Entry conditions:

- Apache routes extensionless public requests through the site's front controller
- explicit utility endpoints, error documents, and any intentionally physical preview endpoints are exempted before normal content-page resolution

Flow:

1. Accept request
   - receive host, scheme, method, path, query string, and environment context
2. Normalize request path
   - normalize extensionless path form
   - apply one trailing-slash policy
   - strip duplicate slashes
   - resolve the effective `route_path`
3. Resolve site context
   - determine the effective brochure site from host or equivalent site config
   - resolve the effective `site_key`
4. Check reserved physical endpoints
   - allow explicit handling for:
     - error documents
     - form handlers
     - webhooks
     - other utility endpoints
   - if matched, exit the normal content-page flow
5. Look up page record
   - query the page registry by:
     - `site_key`
     - normalized `route_path`
   - if no canonical page record exists, continue to missing-route behavior
6. Resolve lifecycle status
   - inspect `status`, `is_canonical`, `is_indexable`, `redirect_target`, and `redirect_type`
   - apply lifecycle behavior:
     - `production` may continue normally
     - `review` may require review-host or auth checks
     - `draft` should normally require explicit preview handling
     - `archived` should redirect, `410`, or remain non-resolving by policy
7. Resolve canonical behavior
   - determine the effective canonical path from:
     - `canonical_path_override`
     - otherwise `route_path`
   - if the request hits a non-canonical alias or normalized mismatch, issue the configured canonical redirect
8. Resolve template definition
   - load the `template_definition` by `template_key`
   - validate the page record's `page_family` and `page_mode`
9. Resolve section profile
   - load the selected `section_profile_key`
   - if not explicitly set, use the template's `default_section_profile_key`
   - validate that the selected profile is allowed under the template
10. Resolve content source
   - load content based on:
     - `content_source_type`
     - `content_source_ref`
   - examples:
     - route-mirrored JSON
     - legacy PHP fallback
     - database-backed content
11. Resolve section instances
   - load or derive the ordered section instances for the page
   - validate them against:
     - the template definition
     - the selected section profile
     - the section definitions
12. Build resolved page context
   - assemble one request-scoped page context containing:
     - page registry record
     - template definition
     - section profile
     - section instances
     - head and schema source decisions
     - navigation and sidebar context
     - asset requirements
13. Resolve head and schema
   - derive or load head metadata and structured data from the resolved page context
   - apply robots behavior from lifecycle and environment rules
14. Aggregate assets
   - combine asset requirements from:
     - template definition
     - section profile
     - section definitions
     - section-instance overrides where allowed
15. Render response
   - call the renderer family selected by:
     - `page_family`
     - `page_mode`
   - render the page through the shared shell and resolved content context
16. Emit final response
   - send the final HTML response
   - or send the resolved redirect or archival response when lifecycle rules require it

Missing-route behavior:

- if no page registry record matches the normalized path:
  - optionally check explicit redirect records
  - otherwise return the standardized branded `404` flow

Preview behavior:

- preview routes should not invent a separate rendering system
- preview resolution should load:
  - template definition
  - section profile
  - canonical preview baseline content
- preview output should use the same family renderer and shared shell contracts as live pages

Sitemap implication:

- sitemap generation should use the page registry rather than filesystem discovery
- only pages with eligible lifecycle and indexation state should be emitted into production sitemap output

Operational implication:

- normal content-page resolution becomes data-driven rather than file-driven
- route creation, status control, canonical handling, and archive behavior can be managed without generating physical `index.php` files per page
- the same flow can begin with flat-file manifests and later move to PostgreSQL-backed lookup with minimal higher-level change

Related notes:

- [Packet README](README.md)
- [Page Registry Data Model](page-registry-data-model.md)
- [Section Instance Data Model](section-instance-data-model.md)
- [Template Catalog Data Model](template-catalog-data-model.md)
