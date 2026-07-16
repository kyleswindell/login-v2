<!--
DOC-META
title: Phase 4.7 View And Asset Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-7-view-and-asset-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-local presentation placement, reusable UI artifact bundles, public-asset boundaries, and deterministic Vite composition.
-->

# Phase 4.7 View And Asset Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where views, layouts, CSS, JavaScript, icons, images, and other presentation assets belong.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Phase 3 artifact-owned presentation bundles and Decision 4.4 registration model

## 3. Default Placement

| Presentation owner             | Default placement                                |
| ------------------------------ | ------------------------------------------------ |
| Reusable UI Component          | `resources/views/components/ui/<Component>/`     |
| Reusable UI Pattern            | `resources/views/components/patterns/<Pattern>/` |
| Reusable UI Layout             | `resources/views/components/layouts/<Layout>/`   |
| Foundation Element             | `resources/views/elements/<Element>/`            |
| Core-owned Surface             | `resources/views/core/<Capability>/`             |
| Module-owned Surface           | `Modules/<Module>/resources/`                    |
| Reusable UI PHP/runtime        | `app/UI/<Responsibility>/`                       |
| Directly web-accessible output | `public/` only when public access is required    |

An artifact bundle may colocate its applicable Blade, CSS, JavaScript, `contract.php`, partials, internal support, and targeted tests.

## 4. Ownership Rules

- Reusable Elements, Components, Patterns, Layouts, icons, and presentation infrastructure remain UI-owned.
- Core page and workflow presentation remains Core-owned.
- Module presentation remains package-local.
- Reusable layout primitives are UI-owned; an application shell or capability-specific layout remains with its owning Surface.
- Livewire classes remain owner-local Surface implementation; their views remain owner-local presentation resources.
- Feature-specific images and assets remain with their owner.
- `public/` is publishable output or direct public source, not a generic editable asset owner.

## 5. Asset Composition

The primary Vite entrypoints remain:

```text
resources/css/app.css
resources/js/app.js
```

Owners declare canonical CSS and JavaScript bundles through their registration descriptors.

A deterministic compiler or validator maintains explicit ordered composition so that:

- every declared asset is included exactly once;
- missing assets fail;
- duplicate declarations fail;
- unregistered imports fail;
- CSS order remains explicit;
- JavaScript initialization remains reviewable;
- installed Module assets can be built without Tenant-specific rebuilds.

Uncontrolled glob discovery is prohibited where it obscures ordering or registration.

## 6. Contribution Boundary

`Contrib/<Host>/` is for owner Contributions to Host Extension Points. It is not a general location for route, view, CSS, JavaScript, or framework registration.

## 7. Accepted Decision

> Login 2.0 places presentation source with the owner of the interface. Reusable Foundation Elements, Components, Patterns, Layouts, icons, and presentation infrastructure remain UI-owned and use owner-visible artifact bundles beneath the accepted `resources/views/` UI branches. Core-owned Surfaces place their Blade, CSS, JavaScript, partials, contracts, and targeted tests beneath `resources/views/core/<Capability>/`; Module-owned presentation remains package-local beneath `Modules/<Module>/resources/`.
>
> Reusable layout primitives belong to UI, while application shells and capability-specific presentation remain with their owning Core capability or Module Surface. Livewire classes remain owner-local Surface implementation, and their views remain owner-local presentation resources. Feature-specific images and assets remain with their owner; `public/` contains only assets requiring direct public access and does not become the editable source owner.
>
> `resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints. Registrable owners declare CSS and JavaScript bundles through their registration descriptors, and the deterministic registration compiler generates or validates explicit ordered asset composition. Missing assets, duplicate declarations, unregistered imports, and stale compiled manifests must fail validation. Filesystem presence alone does not register an asset.

## 8. Boundaries And Handoff

Final bundle filenames, internal-folder names, aliases, import syntax, and category aggregator names remain Phase 5 authority.

## 9. Related

- [Route Placement And Registration](4-4-route-placement-and-registration.md)
- [Test Placement](4-8-test-placement.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51
