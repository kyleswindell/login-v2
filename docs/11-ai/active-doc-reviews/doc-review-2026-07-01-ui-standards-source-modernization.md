# Document Review 2026-07-01 UI Standards Source Modernization

## Review Pass
1

## Target
`docs/02-standards/ui` coherence against current installed UI source under `resources/views/components/ui`, `resources/views/components/icons`, `resources/css`, `resources/js`, and UI Reference views.

## Review Type
Document Review

## Status
PARTIAL

## Purpose
Record the cleanup and modernization path after comparing UI standards to the current Blade, CSS, JS, and UI Reference source. Current installed Blade components under `resources/views/components/ui/{component}/index.blade.php` are the source truth for components. Documentation, tests, or reference pages that do not match those installed components are stale until modernized or intentionally aliased.

## Scope
- `docs/02-standards/ui/index.md`
- `docs/02-standards/ui/api-registry.md`
- `docs/02-standards/ui/components/index.md`
- `docs/02-standards/ui/contract-file.md`
- `docs/02-standards/ui/elements/icons.md`
- `docs/04-features/**`
- `docs/07-planning/**`
- `docs/09-reference/ui/**`
- `docs/11-ai/active-doc-reviews/index.md`
- `resources/views/components/ui/**`
- `resources/views/components/icons/**`
- `resources/views/platform/ui-reference/**`
- `resources/css/**`
- `resources/js/**`

## Source Truth Decisions

### Current component source truth
Current installed Component Blade source is under:

```text
resources/views/components/ui/{component}/index.blade.php
```

Sibling files in that component folder are current internal partials, subcomponents, skeletons, or family variants unless the source indicates otherwise. Deleted flat files such as `resources/views/components/ui/button.blade.php` are stale references unless restored intentionally.

### Current Pattern helper source truth
Current Pattern helpers are under:

```text
resources/views/components/patterns/*.blade.php
```

References under the deleted `resources/views/components/ui/patterns/` path are stale and should point to the current Pattern helper root when the helper still exists.

### Current icon source truth
The internal icon library under `resources/views/components/icons/` is primary. Heroicons or other external icon components should be replaced when an internal icon has a suitable replacement. External icons are placeholders only when no internal icon exists yet.

### Contract rollout state
`contract.php` rollout is in progress and should eventually cover every UI standard. Missing `contract.php` is a migration backlog item, not by itself evidence that a current installed Blade component is stale. Current `docs.php` files remain transitional source inventory until their component has a real contract.

## Findings

### Finding 1
- type: stale-flat-component-paths
- location: `docs/02-standards/ui/**/*.md`, `docs/09-reference/ui/carbon-ui-provenance/blade-source-map.md`
- issue: Many docs still reference deleted flat component paths such as `resources/views/components/ui/button/index.blade.php`, while current components live in folder-based `index.blade.php` files.
- removal candidate: old flat-path source maps and source-file tables should be removed or modernized to `resources/views/components/ui/{component}/index.blade.php`.
- required action: Update source-file tables and reference maps from installed folder paths; remove historical flat-path maps if they no longer serve a support-reference purpose.
- decision state: implemented for reachable active source and docs; inaccessible UI Reference element paths still block a full traversal claim

### Finding 2
- type: stale-public-api-spelling
- location: Multiselect standards, UI Reference examples, tests
- issue: Docs and UI Reference examples reference `x-ui.multiselect`, but the installed source folder and docs metadata expose `x-ui.multi-select`; `x-ui.filterable-multi-select` also exists for filterable behavior.
- removal candidate: stale `x-ui.multiselect` examples, assertions, and prose should be removed or replaced unless an explicit compatibility alias is intentionally added.
- required action: Standardize the public API on the installed component source or add a deliberate alias with tests and docs.
- decision state: implemented for active standards, UI Reference examples/catalogs, and tests

### Finding 3
- type: stale-standalone-range-slider-api
- location: Slider standards, UI Reference sample renderer, tests
- issue: Docs and examples reference `x-ui.range-slider`, but no current `resources/views/components/ui/range-slider` source exists. The installed `x-ui.slider` source owns slider behavior.
- removal candidate: standalone `x-ui.range-slider` documentation, tests, and examples should be removed or converted to the installed `x-ui.slider` paired-range API unless an alias is intentionally restored.
- required action: Update slider docs, UI Reference sample rendering, and tests to prove range behavior through `x-ui.slider`.
- decision state: implemented for active standards, UI Reference examples/catalogs, and tests

### Finding 4
- type: stale-standalone-toast-api
- location: Notification standards, overlays UI Reference pattern, tests
- issue: Docs and UI Reference examples reference standalone `x-ui.toast`, but current source is nested under `resources/views/components/ui/notification/toast.blade.php`.
- removal candidate: standalone `x-ui.toast` documentation, examples, and assertions should be removed or converted to `x-ui.notification.toast` unless a compatibility alias is intentionally restored.
- required action: Update Notification Component and Feedback/Notifications Pattern docs and UI Reference examples to use the installed notification family source.
- decision state: implemented for active standards, UI Reference examples, and tests

### Finding 5
- type: stale-css-js-paths
- location: UI standards, feature docs, planning docs, reference audits
- issue: Several docs reference deleted or renamed files such as `resources/css/components/multiselect.css`, `resources/js/setup-sidebar.js`, `resources/js/shell-ui.js`, `resources/js/components/tree-view.js`, and `resources/js/ui-controls/toggletips.js`.
- removal candidate: stale file-path instructions should be removed or modernized to current files such as `resources/css/components/multi-select.css`, `resources/js/ui-controls/ui-shell.js`, `resources/js/ui-controls/side-nav.js`, `resources/js/ui-controls/tree-views.js`, and `resources/js/ui-controls/toggletip.js`.
- required action: Modernize source path references during the component-doc cleanup pass; delete outdated support-reference maps if they are no longer useful.
- decision state: implemented for the identified stale CSS/JS path set in active docs

### Finding 6
- type: icon-source-priority-drift
- location: `docs/02-standards/ui/elements/icons.md`, UI Reference examples, component tests
- issue: Existing docs and tests treated Heroicons as the default icon library, but current source includes an internal icon library under `resources/views/components/icons/` and current components already use `x-icons.*`.
- removal candidate: Heroicons-first instructions, examples, and assertions should be removed unless documenting an external placeholder gap.
- required action: Replace Heroicons references with internal icon components where suitable internal icons exist; keep outside icons only as documented placeholders.
- decision state: implemented with external icon usage retained only as documented placeholder or reference fallback

### Finding 7
- type: undocumented-current-source-surfaces
- location: `resources/views/components/ui/*`
- issue: Current source contains many folders that do not have a one-to-one `docs/02-standards/ui/components/{slug}.md` standard. Some are valid subcomponents or skeleton states; others need promotion, internal marking, or removal.
- removal candidate: source folders with no durable owner should be triaged before feature reuse. Public candidates include `badge`, `status`, `switch`, `time-picker`, `password-input`, `text-area`, `searchable-select`, `filterable-multi-select`, `dialog`, and `drawer`. Subcomponents and skeletons should generally be documented under their parent component rather than as standalone pages.
- required action: For each source-only folder, classify as public Component, parent-owned subcomponent, Pattern helper, internal-only implementation detail, legacy compatibility alias, or removal candidate.
- decision state: follow-up required

### Finding 8
- type: inaccessible-ui-reference-element-folders
- location: `resources/views/platform/ui-reference/elements/*`
- issue: Several UI Reference element subfolders returned access-denied errors during traversal, preventing full counterpart inspection.
- required action: Correct filesystem access or remove the inaccessible directories if they are stale artifacts; rerun UI Reference element-source comparison afterward.
- decision state: follow-up required

## Modernization Plan

1. Normalize canonical source paths.
   - Replace flat `resources/views/components/ui/*.blade.php` references with `resources/views/components/ui/*/index.blade.php`.
   - Replace deleted Pattern paths under `resources/views/components/ui/patterns/` with `resources/views/components/patterns/`.
   - Update CSS/JS paths to current module names.

2. Normalize public API names to current installed Blade source.
   - Multiselect: use `x-ui.multi-select` and `x-ui.filterable-multi-select`.
   - Slider: use `x-ui.slider` for single-handle and two-handle range behavior.
   - Notification: use `x-ui.notification.inline` and `x-ui.notification.toast`.

3. Normalize icon guidance and examples.
   - Prefer `x-icons.*` from `resources/views/components/icons/`.
   - Replace Heroicons where internal equivalents exist.
   - Track remaining external icons as explicit placeholder gaps.

4. Triage current source-only folders.
   - Public components get standards and UI Reference proof.
   - Parent-owned subcomponents move into parent standards.
   - Internal-only folders are marked internal and excluded from public docs.
   - Legacy aliases without current consumers become removal candidates.

5. Continue `contract.php` rollout from evidence.
   - Do not bulk-convert `docs.php` by guessing.
   - Create contracts from installed Blade source, examples, classes, dependencies, and review requirements.

## Implementation Status
implemented with follow-up needed

## Resolution Notes
- Updated `docs/02-standards/ui/index.md` to name folder-based Component source truth, Pattern helper source truth, internal icon priority, and contract rollout state.
- Updated `docs/02-standards/ui/api-registry.md` to modernize source roots and flag stale API spellings for Multiselect, Slider, and Notification.
- Updated `docs/02-standards/ui/components/index.md` to reflect current installed public surfaces for Multiselect, Notification, and Slider.
- Updated `docs/02-standards/ui/contract-file.md` so missing contracts are treated as rollout backlog rather than current-source invalidation.
- Updated `docs/02-standards/ui/elements/icons.md` so internal `x-icons.*` components are primary and external icons are placeholder-only fallbacks.
- Rewrote `docs/02-standards/ui/components/multiselect.md` and `docs/02-standards/ui/components/slider.md` around the installed Blade APIs and current source files.
- Updated Dropdown and Notification standards cross-links, including `x-ui.filterable-multi-select` ownership and toast `kind` usage.
- Updated UI Reference runtime examples, the shared component sample renderer, and `UiReferenceComponentDepthCatalog` to use current multiselect, filterable multiselect, two-handle slider, nested toast, and internal icon patterns.
- Updated `tests/Feature/Platform/PlatformUiReferenceTest.php` to read foldered component paths and assert current data hooks.
- Removed legacy multiselect hook fallbacks from `resources/js/ui-controls/multiselects.js` and normalized stale selector aliases in `resources/css/components/multi-select.css`.
- Modernized identified stale CSS/JS path references for shell, side-nav, tree-view, and toggletip docs.
- Remaining blocker: `resources/views/platform/ui-reference/elements/*` and `resources/views/elements/color/examples/usage` still return access-denied during traversal, so a complete element-source comparison cannot be claimed.

## Exit Criteria
- All source-file tables in `docs/02-standards/ui` point to current installed files or are removed.
- UI Reference live examples render only current installed APIs or documented compatibility aliases.
- `docs/09-reference/ui` support maps no longer present deleted flat component paths as current source.
- Heroicons references remain only where documenting a placeholder gap or external fallback.
- Source-only UI component folders have explicit public, parent-owned, internal, alias, or removal disposition.
