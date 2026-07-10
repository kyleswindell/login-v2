# Module UI Surface Contract Readiness Review

Review ID: `doc-review-2026-07-02-module-ui-surface-contract-readiness`  
Date: 2026-07-02  
Type: Review-only governance audit  
Status: PARTIAL  
Implementation status: implemented with follow-up needed

## Scope

Review the new module UI entry direction before implementation. This review covers how modules should contribute navigation, settings pages, setup pages, dashboard widgets, content views, and extension points into core-owned rendered surfaces.

This review does not implement UI rendering changes.

## Current Contract

Canonical architecture now defines:

- core-owned app layout, header menu, app sidebar, settings sidebar, setup navigation, dashboard grid, content layout, and extension-point regions
- module-contributed navigation, settings, setup, dashboard, content, and extension surfaces
- explicit extension points instead of arbitrary view overrides
- forbidden behavior for rendered layout replacement, duplicate surface keys, permission bypasses, and default tenant eligibility for platform-management surfaces

Planning now sequences:

- manifest UI metadata
- validation
- current surface classification
- one rendered-surface consumption proof
- broader rendered-surface consumption
- persisted module state after rendering parity is proven

## Findings

### MUSC-F1: Manifest fields for UI entries are implemented

Classification: `coverage_gap`  
Priority: P1

Risk:

The current module definitions now own typed UI entry metadata for current navigation, settings, setup, dashboard widget, and top-level content-view evidence. Most runtime rendered surfaces still do not consume the metadata.

Expected contract:

Modules should declare typed UI entry entries for header/app sidebar navigation, settings navigation, settings pages, setup steps, content routes/views, extension points, and extension contributions before rendered views consume them.

Recommended correction:

Implemented: dedicated UI entry model/enums on `Manifest`, registry validation for duplicate keys, required targets, access metadata, extension-point dependencies, and tenant eligibility, plus Definitions evidence tests. Settings navigation is now the first rendered-surface consumption proof.

### MUSC-F2: Settings navigation should be the first consumption proof

Classification: `implementation_sequence`  
Priority: P1

Risk:

Migrating all rendered surfaces at once would make it hard to tell whether failures come from manifest modeling, navigation rendering, settings routing, widgets, or extension points.

Expected contract:

One rendered surface should consume module surface metadata first while rendering the same UI as before.

Recommended correction:

Implemented: settings navigation is the first rendered-surface consumption proof. The settings-page column now consumes module surface metadata. The setup/admin column is transitional and should be removed only after setup navigation has its own route/navigation treatment outside the settings sidebar.

### MUSC-F3: Extension points have strict dependency rules

Classification: `platform_singleton_coupling`  
Priority: P2

Risk:

Without explicit dependency and extension-point checks, future modules may try to override another module's views directly or render dependent UI before the owner module is enabled.

Expected contract:

Extension contributions must target declared extension points and depend on the owner module.

Recommended correction:

Implemented: registry validation rejects extension contributions that target unknown extension points or target an extension point owned by a module that is not a dependency.

### MUSC-F4: Platform-management UI entries have tenant eligibility defaults

Classification: `future_tenant_defer`  
Priority: P2

Risk:

UI Reference, docs vault, security checklist, runtime readiness, setup pages, and development tools are useful in internal platform mirrors but should not become tenant-eligible by accident.

Expected contract:

Platform-management UI entries remain not tenant-eligible by default.

Recommended correction:

Implemented: UI entry metadata carries tenant eligibility, registry validation rejects tenant-eligible surfaces on non-tenant-eligible modules, and Definitions tests keep platform-management surfaces not tenant-eligible by default.

## Recommended Follow-Up Order

1. Split module definitions into separate definition classes if Definitions growth becomes difficult to review.
2. Complete the header navigation and settings pattern readiness follow-up before consuming more rendered navigation metadata.
3. Expand consumption to setup navigation or header/app sidebar navigation only after notification bell ownership, platform-management grouping, settings/setup separation, and settings page pattern readiness are resolved.
4. Expand consumption to dashboard widgets, content routes, and extension points after navigation parity is proven.
5. Add persisted module lifecycle state after rendering parity is proven.

## Validation Performed

Initial review plus implementation evidence for typed UI entry metadata, validation, Definitions coverage, and settings navigation consumption. Runtime rendering outside the settings-page navigation column remains unchanged.

## Out Of Scope

- Runtime UI rendering changes
- Dynamic module installs
- Persisted module state
- Tenant resolver implementation
- Tenant database provisioning
- Route renaming
- Arbitrary Blade overrides
