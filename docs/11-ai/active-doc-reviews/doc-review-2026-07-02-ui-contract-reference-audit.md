# Document Review 2026-07-02 UI Contract Reference Audit

## Review Pass
1

## Target
UI standards, UI contracts, component source, token CSS, UI Reference rendering, UI Reference JavaScript, and `/platform/ui-reference/**` routes.

## Review Type
Document Review

## Status
READY_FOR_IMPLEMENTATION

## Implementation Status
not started

## Purpose
Map the current UI contract and UI Reference source truth before any further contract rollout or UI Reference rewrite. This is a review-only governance artifact. It records evidence from active standards docs, runtime contracts, Blade source, CSS token source, UI Reference catalogs/views, JavaScript initializers, and routes. It does not create contracts, edit component source, rewrite UI Reference pages, delete docs, or change routes.

## Audit Rules
- Treat installed Blade/CSS/JS as evidence of what exists.
- Treat docs as evidence, not automatic truth.
- Treat runtime `contract.php` files as the preferred durable UI Reference source when present.
- Report docs/code/contract conflicts instead of silently choosing one.
- Ignore `docs/_archive/`.
- Treat missing contracts as rollout backlog, not removal evidence.
- Preserve comments and source headers in future implementation.

## Executive Findings

### Finding 1
- type: partial-contract-rollout
- evidence: `resources/views/components/ui/tag/contract.php`, `resources/views/elements/**/contract.php`, `app/Ui/Contracts/UiContractRepository.php`
- issue: Runtime contracts are registered for Tag and eight Elements only. Button was believed to have a runtime contract in planning notes, but full search found no `resources/views/components/ui/button/contract.php`.
- impact: Button should not be used as observed contract schema evidence yet. Tag plus Element contracts are the current schema evidence.
- required action: Use the existing Tag contract and Element contracts as the first migration references. Do not bulk-create contracts from docs alone.

### Finding 2
- type: token-standards-gap
- evidence: `docs/02-standards/ui/tokens/` exists but has no active files; implementation tokens exist under `resources/css/tokens/**`.
- issue: Token implementation has a real source tree, but active UI token standards have no file-level owner under the expected docs branch.
- impact: Token guidance must be reconstructed from CSS source and the root UI token docs before component contract migration can rely on docs as complete token truth.
- required action: Add a scoped token-standards docs pass later. This audit only records the gap.

### Finding 3
- type: component-doc-source-drift
- evidence: 44 component-branch markdown files, 100 installed `x-ui` Blade folders, 1 component contract.
- issue: Component docs, installed Blade folders, Definitions pages, live examples, and contracts do not have one-to-one coverage. Several Blade folders are valid owner-owned subcomponents or skeletons, but several are uncataloged or need disposition review.
- impact: UI Reference migration should use an owner model, not one standalone public page per implementation folder.
- required action: Use `UiReferenceComponentCatalog::SOURCE_OWNER_BY_FOLDER` as migration evidence and add contracts to owner components first.

### Finding 4
- type: mixed-ui-reference-source-model
- evidence: `app/Platform/UiReference/*`, `app/Ui/Contracts/*`, `app/Ui/Reference/*`, `resources/views/platform/ui-reference/**`, `resources/js/platform/ui-reference/token-tables.js`, `resources/js/ui-reference.js`
- issue: UI Reference currently mixes PHP Definitions arrays, runtime contracts, reference definition files, Blade views, live examples, and JS helpers.
- impact: A broad rewrite would risk breaking working reference pages. The migration should be staged around contract-backed examples.
- required action: Keep Overview/Usage/Tokens pages optional for now. Make Examples the required manual review surface.

### Finding 5
- type: internal-icon-source-confirmed
- evidence: `resources/views/components/icons/icon-list.txt`, `docs/02-standards/ui/elements/icons.md`, `resources/views/components/ui/icon/docs.php`
- issue: Active icon docs now mark Heroicons as placeholders only, and the internal icon list is the primary source. One component docs file warns not to add dynamic `x-icons.*` usage.
- impact: Contract migration should prefer internal icon names for static component APIs and treat external icons as documented gaps only.
- required action: Record icon dependencies in contracts using internal icon names when suitable.

## Source-Truth Map

| Surface                   | Current evidence                                                                                          | Status                           | Notes                                                                                         |
| ------------------------- | --------------------------------------------------------------------------------------------------------- | -------------------------------- | --------------------------------------------------------------------------------------------- |
| UI standards root         | `docs/02-standards/ui/AGENTS.md`, `api-registry.md`, `contract-file.md`, `index.md`, `testing.md`         | active docs                      | Root UI standards exist and include the contract-file model.                                  |
| Component standards       | `docs/02-standards/ui/components/*.md`                                                                    | active docs with drift           | Primary component docs exist, but not all installed Blade folders have exact standards pages. |
| Element standards         | `docs/02-standards/ui/elements/*.md`                                                                      | active docs                      | Elements align better with runtime contracts than components do.                              |
| Pattern standards         | `docs/02-standards/ui/patterns/*.md`                                                                      | active docs                      | Pattern docs map to UI Reference pattern pages, not direct `x-ui` contracts.                  |
| Token standards           | `docs/02-standards/ui/tokens/`                                                                            | missing/incomplete               | Directory exists but contains no active files. Cross-reference `resources/css/tokens/**`.     |
| Contract template         | `docs/09-reference/ui/ui-contract-template.php`, `docs/02-standards/ui/contract-file.md`                  | active reference and standard    | Template exists and matches the observed contract shape.                                      |
| Component contracts       | `resources/views/components/ui/tag/contract.php`                                                          | partial rollout                  | Tag is the only registered component contract.                                                |
| Element contracts         | `resources/views/elements/{2x-grid,color,icons,motion,pictograms,spacing,themes,typography}/contract.php` | partial rollout                  | Registered by `UiContractRepository`.                                                         |
| UI Reference definitions  | `resources/views/elements/color/reference.php`, `resources/views/elements/themes/reference.php`           | partial rollout                  | Only Color and Themes have owner-local `reference.php`.                                       |
| Component Blade source    | `resources/views/components/ui/*/index.blade.php`                                                         | installed source truth           | 100 installed `x-ui` folders were found.                                                      |
| Shell Blade source        | `resources/views/components/shell/**`                                                                     | installed source truth for shell | Shell is not under `x-ui`; UI Reference Definitions represents it as a pattern.                   |
| Component CSS             | `resources/css/components/**`                                                                             | installed style truth            | Includes split UI shell CSS and component styles.                                             |
| Token CSS                 | `resources/css/tokens/**`                                                                                 | installed token truth            | Active token implementation exists here, including component token files.                     |
| UI Reference PHP catalogs | `app/Platform/UiReference/*.php`                                                                          | active runtime Definitions           | Component and Element catalogs remain major source inputs.                                    |
| Contract runtime          | `app/Ui/Contracts/*.php`                                                                                  | active runtime reader            | Validates registered contracts and readiness.                                                 |
| Reference runtime         | `app/Ui/Reference/*.php`                                                                                  | active runtime reader            | Reads owner-local `reference.php` files.                                                      |
| UI Reference views        | `resources/views/platform/ui-reference/**`                                                                | active rendering                 | 87 Blade files found under the UI Reference tree.                                             |
| UI Reference JS           | `resources/js/platform/ui-reference/token-tables.js`, `resources/js/ui-reference.js`                      | active behavior                  | Token tables and reference interactions are JS-supported.                                     |
| UI routes                 | `routes/web.php` `/platform/ui-reference/**` group                                                        | active routes                    | 32 route lines reference UI Reference paths.                                                  |

## UI Standards Docs Audit

Every active file under `docs/02-standards/ui/components`, `docs/02-standards/ui/elements`, and `docs/02-standards/ui/patterns` is listed here. `docs/02-standards/ui/tokens/` is listed as an empty active directory.

| File                                                        | Branch     | Runtime counterpart                                                                             | Audit result                                                                              |
| ----------------------------------------------------------- | ---------- | ----------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- |
| `docs/02-standards/ui/components/AGENTS.md`                 | components | agent guidance only                                                                             | Reviewed as retrieval guidance, not component truth.                                      |
| `docs/02-standards/ui/components/accordion.md`              | components | `resources/views/components/ui/accordion/index.blade.php`                                       | Component exists; no contract; examples are Definitions-driven rather than live-example only. |
| `docs/02-standards/ui/components/ai-label.md`               | components | no `x-ui` Blade folder found                                                                    | Docs/Definitions surface exists; runtime source needs confirmation before implementation.     |
| `docs/02-standards/ui/components/breadcrumb.md`             | components | `resources/views/components/ui/breadcrumb/index.blade.php`                                      | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/button.md`                 | components | `resources/views/components/ui/button/index.blade.php`                                          | Component exists; live example exists; Button contract not found.                         |
| `docs/02-standards/ui/components/checkbox.md`               | components | `resources/views/components/ui/checkbox/index.blade.php`                                        | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/checklist.md`              | components | standards checklist                                                                             | Meta standards file; not an `x-ui` surface.                                               |
| `docs/02-standards/ui/components/code-snippet.md`           | components | `resources/views/components/ui/code-snippet/index.blade.php`                                    | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/combo-box.md`              | components | `resources/views/components/ui/combo-box/index.blade.php`                                       | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/contained-list.md`         | components | `resources/views/components/ui/contained-list/index.blade.php`                                  | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/content-switcher.md`       | components | `resources/views/components/ui/content-switcher/index.blade.php`                                | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/data-table.md`             | components | `resources/views/components/ui/data-table/index.blade.php`                                      | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/date-picker.md`            | components | `resources/views/components/ui/date-picker/index.blade.php`                                     | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/dropdown.md`               | components | `resources/views/components/ui/dropdown/index.blade.php`                                        | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/family-depth-pages.md`     | components | UI Reference depth model                                                                        | Meta standards file; compare to `UiReferenceComponentDepthCatalog`.                       |
| `docs/02-standards/ui/components/file-uploader.md`          | components | `resources/views/components/ui/file-uploader/index.blade.php`                                   | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/form.md`                   | components | `resources/views/components/ui/form/index.blade.php` and Forms pattern                          | Definitions represents Form as pattern-owned; no contract.                                    |
| `docs/02-standards/ui/components/index.md`                  | components | component Definitions overview                                                                      | Meta standards file; not an `x-ui` surface.                                               |
| `docs/02-standards/ui/components/inline-loading.md`         | components | `resources/views/components/ui/inline-loading/index.blade.php`                                  | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/link.md`                   | components | `resources/views/components/ui/link/index.blade.php`                                            | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/list.md`                   | components | `resources/views/components/ui/ordered-list`, `unordered-list`, `list-item`                     | No exact `list` folder; family source exists under child folders.                         |
| `docs/02-standards/ui/components/loading.md`                | components | `resources/views/components/ui/loading/index.blade.php`                                         | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/menu.md`                   | components | `resources/views/components/ui/menu/index.blade.php`                                            | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/menu-buttons.md`           | components | `resources/views/components/ui/menu-button`, `combo-button`, `overflow-menu`                    | No exact folder; family-owned implementation source exists.                               |
| `docs/02-standards/ui/components/modal.md`                  | components | `resources/views/components/ui/modal/index.blade.php`                                           | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/multiselect.md`            | components | `resources/views/components/ui/multi-select`, `filterable-multi-select`                         | No exact `multiselect` folder; installed source uses hyphenated family members.           |
| `docs/02-standards/ui/components/notification.md`           | components | `notification/inline`, `notification/toast`, `status`, `status-icon`, notification CSS          | Notification folder exists; inline/toast are current approved calls.                      |
| `docs/02-standards/ui/components/number-input.md`           | components | `resources/views/components/ui/number-input/index.blade.php`                                    | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/pagination.md`             | components | `resources/views/components/ui/pagination/index.blade.php`                                      | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/popover.md`                | components | `resources/views/components/ui/popover/index.blade.php`                                         | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/progress-bar.md`           | components | `resources/views/components/ui/progress-bar/index.blade.php`                                    | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/progress-indicator.md`     | components | `resources/views/components/ui/progress-indicator/index.blade.php`                              | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/radio-button.md`           | components | `resources/views/components/ui/radio-button/index.blade.php`                                    | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/search.md`                 | components | `resources/views/components/ui/search/index.blade.php`                                          | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/select.md`                 | components | `resources/views/components/ui/select/index.blade.php`                                          | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/slider.md`                 | components | `resources/views/components/ui/slider/index.blade.php`                                          | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/structured-list.md`        | components | `resources/views/components/ui/structured-list/index.blade.php`                                 | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/tabs.md`                   | components | `resources/views/components/ui/tabs/index.blade.php`                                            | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/tag.md`                    | components | `resources/views/components/ui/tag/index.blade.php`                                             | Component exists; contract exists; live example exists.                                   |
| `docs/02-standards/ui/components/text-input.md`             | components | `resources/views/components/ui/text-input`, `password-input`, `text-area`                       | Family source exists; live example exists; no owner contract.                             |
| `docs/02-standards/ui/components/tile.md`                   | components | `resources/views/components/ui/tile/index.blade.php`                                            | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/toggle.md`                 | components | `resources/views/components/ui/toggle/index.blade.php` and `switch`                             | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/toggletip.md`              | components | `resources/views/components/ui/toggletip/index.blade.php`                                       | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/tooltip.md`                | components | `resources/views/components/ui/tooltip/index.blade.php`                                         | Component exists; live example exists; no contract.                                       |
| `docs/02-standards/ui/components/tree-view.md`              | components | `resources/views/components/ui/tree-view/index.blade.php`                                       | Component exists; no live example found; no contract.                                     |
| `docs/02-standards/ui/components/ui-shell.md`               | components | `resources/views/components/shell/**` and `resources/css/components/ui-shell/**`                | Shell source exists outside `x-ui`; represented as pattern in Definitions.                    |
| `docs/02-standards/ui/elements/2x-grid.md`                  | elements   | `resources/views/elements/2x-grid/contract.php`                                                 | Element contract exists.                                                                  |
| `docs/02-standards/ui/elements/AGENTS.md`                   | elements   | agent guidance only                                                                             | Reviewed as retrieval guidance, not element truth.                                        |
| `docs/02-standards/ui/elements/color.md`                    | elements   | `resources/views/elements/color/contract.php`, `reference.php`                                  | Contract and reference definition exist.                                                  |
| `docs/02-standards/ui/elements/icons.md`                    | elements   | `resources/views/elements/icons/contract.php`, `resources/views/components/icons/icon-list.txt` | Contract exists; internal icon list is source evidence.                                   |
| `docs/02-standards/ui/elements/index.md`                    | elements   | element Definitions overview                                                                        | Meta standards file.                                                                      |
| `docs/02-standards/ui/elements/motion.md`                   | elements   | `resources/views/elements/motion/contract.php`, `resources/css/tokens/motion.css`               | Contract and token CSS source exist.                                                      |
| `docs/02-standards/ui/elements/pictograms.md`               | elements   | `resources/views/elements/pictograms/contract.php`                                              | Element contract exists.                                                                  |
| `docs/02-standards/ui/elements/spacing.md`                  | elements   | `resources/views/elements/spacing/contract.php`, `resources/css/tokens/spacing.css`             | Contract and token CSS source exist.                                                      |
| `docs/02-standards/ui/elements/themes.md`                   | elements   | `resources/views/elements/themes/contract.php`, `reference.php`                                 | Contract and reference definition exist.                                                  |
| `docs/02-standards/ui/elements/typography.md`               | elements   | `resources/views/elements/typography/contract.php`, `resources/css/tokens/type/index.css`       | Contract and token CSS source exist.                                                      |
| `docs/02-standards/ui/patterns/AGENTS.md`                   | patterns   | agent guidance only                                                                             | Reviewed as retrieval guidance, not pattern truth.                                        |
| `docs/02-standards/ui/patterns/boundary-and-validation.md`  | patterns   | UI Reference pattern pages                                                                      | Pattern docs exist; no direct contract source.                                            |
| `docs/02-standards/ui/patterns/checklist.md`                | patterns   | pattern checklist                                                                               | Meta standards file.                                                                      |
| `docs/02-standards/ui/patterns/data-and-content.md`         | patterns   | `resources/views/platform/ui-reference/patterns/data-content.blade.php`                         | Pattern page exists.                                                                      |
| `docs/02-standards/ui/patterns/feedback.md`                 | patterns   | overlays and feedback reference page                                                            | Pattern docs exist; route uses overlays-feedback.                                         |
| `docs/02-standards/ui/patterns/forms.md`                    | patterns   | `resources/views/platform/ui-reference/patterns/forms.blade.php`                                | Pattern page exists.                                                                      |
| `docs/02-standards/ui/patterns/index.md`                    | patterns   | pattern overview                                                                                | Meta standards file.                                                                      |
| `docs/02-standards/ui/patterns/interactions.md`             | patterns   | UI Reference patterns and component behavior                                                    | Pattern docs exist; no direct contract source.                                            |
| `docs/02-standards/ui/patterns/layout.md`                   | patterns   | `resources/views/platform/ui-reference/patterns/layout.blade.php`                               | Pattern page exists.                                                                      |
| `docs/02-standards/ui/patterns/navigation.md`               | patterns   | `resources/views/platform/ui-reference/patterns/navigation.blade.php`                           | Pattern page exists and owns UI shell representation.                                     |
| `docs/02-standards/ui/patterns/notifications-and-toasts.md` | patterns   | overlays and feedback reference page                                                            | Pattern docs exist; compare to notification family source in future pass.                 |
| `docs/02-standards/ui/patterns/overlays-and-actions.md`     | patterns   | `resources/views/platform/ui-reference/patterns/overlays.blade.php`                             | Pattern page exists.                                                                      |
| `docs/02-standards/ui/tokens/`                              | tokens     | `resources/css/tokens/**`                                                                       | Directory exists with zero active files; missing/incomplete standards owner.              |

## Runtime Contract and Reference Audit

| File                                                | Registered by                                         | Type              | Schema evidence  | Audit result                                                     |
| --------------------------------------------------- | ----------------------------------------------------- | ----------------- | ---------------- | ---------------------------------------------------------------- |
| `docs/09-reference/ui/ui-contract-template.php`     | reference template                                    | template          | full schema      | Exists and matches the observed contract family shape.           |
| `resources/views/components/ui/tag/contract.php`    | `UiContractRepository::COMPONENT_CONTRACTS`           | component         | full schema      | Only registered component contract. Use as pilot evidence.       |
| `resources/views/elements/2x-grid/contract.php`     | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/color/contract.php`       | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract; `reference.php` also exists.        |
| `resources/views/elements/icons/contract.php`       | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/motion/contract.php`      | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/pictograms/contract.php`  | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/spacing/contract.php`     | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/themes/contract.php`      | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract; `reference.php` also exists.        |
| `resources/views/elements/typography/contract.php`  | `UiContractRepository::ELEMENT_CONTRACTS`             | element           | full schema      | Registered element contract.                                     |
| `resources/views/elements/color/reference.php`      | `UiReferenceDefinitionRepository::ELEMENT_REFERENCES` | element reference | reference schema | Only Color and Themes use owner-local UI Reference definitions.  |
| `resources/views/elements/themes/reference.php`     | `UiReferenceDefinitionRepository::ELEMENT_REFERENCES` | element reference | reference schema | Only Color and Themes use owner-local UI Reference definitions.  |
| `resources/views/components/ui/button/contract.php` | not found                                             | component         | none             | Button contract believed in notes, but not found by full search. |

## UI Reference Runtime Classification

| File                                                            | Classification                  | Audit result                                                                                   |
| --------------------------------------------------------------- | ------------------------------- | ---------------------------------------------------------------------------------------------- |
| `app/Http/Controllers/Platform/UiReferenceController.php`       | route controller                | Active controller for UI Reference pages; not contract-owned yet.                              |
| `app/Platform/UiReference/UiReferenceComponentCatalog.php`      | component Definitions               | Active source for component page list, owner mappings, visibility, and Tag contract readiness. |
| `app/Platform/UiReference/UiReferenceComponentDepthCatalog.php` | component deep examples/Definitions | Active source for detailed component example pages and live-example view names.                |
| `app/Platform/UiReference/UiReferenceDetailPages.php`           | detail page registry            | Active source for detail-page ordering and route parameter constants.                          |
| `app/Platform/UiReference/UiReferenceElementCatalog.php`        | element Definitions                 | Active source for element pages and contract/reference integration.                            |
| `app/Platform/UiReference/UiReferenceSamples.php`               | reference samples               | Active source for sample data.                                                                 |
| `app/Platform/UiReference/UiReferenceTables.php`                | reference table samples         | Active source for table-pattern payloads.                                                      |
| `app/Platform/UiReference/UiReferenceTypographyTypeSets.php`    | typography reference data       | Active source for typography type-set examples.                                                |
| `app/Ui/Contracts/UiContractReadiness.php`                      | contract readiness service      | Active contract status helper.                                                                 |
| `app/Ui/Contracts/UiContractRepository.php`                     | contract repository             | Active registered-contract loader; registers eight Elements and Tag.                           |
| `app/Ui/Reference/UiReferenceDefinitionRepository.php`          | reference definition repository | Active owner-local `reference.php` loader; registers Color and Themes.                         |
| `resources/js/platform/ui-reference/token-tables.js`            | UI Reference JS                 | Active token-table helper.                                                                     |
| `resources/js/ui-reference.js`                                  | UI Reference JS                 | Active general UI Reference behavior.                                                          |
| `routes/web.php` lines 139-174                                  | route definitions               | Active `/platform/ui-reference/**` route group; no route changes required in audit.            |

## UI Reference View Coverage

| View group                                                                                          | Count | Classification        | Notes                                                                        |
| --------------------------------------------------------------------------------------------------- | ----: | --------------------- | ---------------------------------------------------------------------------- |
| `resources/views/platform/ui-reference/components/*.blade.php` and `components/example/*.blade.php` |     6 | component pages       | Actions, Forms, Overview, Show, Status, and Example detail wrapper.          |
| `resources/views/platform/ui-reference/components/examples/*.blade.php`                             |    12 | Definitions examples      | Accordion and sample example views; not the same as live examples.           |
| `resources/views/platform/ui-reference/components/live-examples/*.blade.php`                        |    23 | live examples         | Listed individually below and should become required manual review surfaces. |
| `resources/views/platform/ui-reference/components/live-examples/partials/*.blade.php`               |     5 | live example partials | Proof partials for Breadcrumb, List, Menu, Multiselect, and Tabs.            |
| `resources/views/platform/ui-reference/elements/*.blade.php` and `elements/partials/*.blade.php`    |     4 | element pages         | Overview, Show, Type Sets, and contract placeholder partial.                 |
| `resources/views/platform/ui-reference/{index,overview}.blade.php`                                  |     2 | root pages            | UI Reference landing and overview views.                                     |
| `resources/views/platform/ui-reference/index/**/*.blade.php`                                        |     8 | landing/index support | Dashboard and sample drawer/table views.                                     |
| `resources/views/platform/ui-reference/partials/*.blade.php`                                        |     2 | shared partials       | Sidebar and detail section bridge.                                           |
| `resources/views/platform/ui-reference/patterns/**/*.blade.php`                                     |    25 | pattern pages         | Pattern pages plus table and widget-content subpages.                        |

### Component Live Examples

| Live example                                                                               | Component owner | Audit result                                                                              |
| ------------------------------------------------------------------------------------------ | --------------- | ----------------------------------------------------------------------------------------- |
| `resources/views/platform/ui-reference/components/live-examples/breadcrumb.blade.php`      | breadcrumb      | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/button.blade.php`          | button          | Current live example; Button contract not found.                                          |
| `resources/views/platform/ui-reference/components/live-examples/checkbox.blade.php`        | checkbox        | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/code-snippet.blade.php`    | code-snippet    | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/contained-list.blade.php`  | contained-list  | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/data-table.blade.php`      | data-table      | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/date-picker.blade.php`     | date-picker     | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/dropdown.blade.php`        | dropdown        | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/link.blade.php`            | link            | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/list.blade.php`            | list            | Current live example; family source uses list child folders.                              |
| `resources/views/platform/ui-reference/components/live-examples/loading.blade.php`         | loading         | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/menu.blade.php`            | menu            | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/menu-buttons.blade.php`    | menu-buttons    | Current live example; family source uses menu-button/combo-button/overflow-menu.          |
| `resources/views/platform/ui-reference/components/live-examples/multiselect.blade.php`     | multiselect     | Current live example; installed source uses `multi-select` and `filterable-multi-select`. |
| `resources/views/platform/ui-reference/components/live-examples/pagination.blade.php`      | pagination      | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/search.blade.php`          | search          | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/select.blade.php`          | select          | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/structured-list.blade.php` | structured-list | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/tabs.blade.php`            | tabs            | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/tag.blade.php`             | tag             | Current live example; contract exists.                                                    |
| `resources/views/platform/ui-reference/components/live-examples/text-input.blade.php`      | text-input      | Current live example; family source includes password-input and text-area.                |
| `resources/views/platform/ui-reference/components/live-examples/tile.blade.php`            | tile            | Current live example; no contract.                                                        |
| `resources/views/platform/ui-reference/components/live-examples/tooltip.blade.php`         | tooltip         | Current live example; no contract.                                                        |

## Component Matrix

This matrix is the union of documented component surfaces and installed `resources/views/components/ui/*/index.blade.php` folders. Owner mapping follows the current `UiReferenceComponentCatalog` where present.

| Surface                      | Blade source                                                                 | Standards doc              | Definitions/disposition                  | Contract            | UI Reference example                | Assessment                                                                   |
| ---------------------------- | ---------------------------------------------------------------------------- | -------------------------- | ------------------------------------ | ------------------- | ----------------------------------- | ---------------------------------------------------------------------------- |
| accordion                    | `resources/views/components/ui/accordion/index.blade.php`                    | exact                      | primary page                         | no                  | Definitions examples                    | needs contract migration                                                     |
| ai-label                     | not found                                                                    | exact                      | primary page                         | no                  | none found                          | documented without `x-ui` Blade source                                       |
| badge                        | deprecated; direct callers migrated to `resources/views/components/ui/tag/index.blade.php` | missing                    | removal candidate                    | no                  | none found                          | safe to delete once `resources/views/components/ui/badge/` is removed         |
| breadcrumb                   | `resources/views/components/ui/breadcrumb/index.blade.php`                   | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| button                       | `resources/views/components/ui/button/index.blade.php`                       | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| button-set                   | `resources/views/components/ui/button-set/index.blade.php`                   | family: button             | owned by button                      | no                  | owner live example: button          | keep under owner unless public API is required                               |
| button-skeleton              | `resources/views/components/ui/button-skeleton/index.blade.php`              | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| chat-button                  | `resources/views/components/ui/chat-button/index.blade.php`                  | missing                    | not in Definitions or needs owner review | no                  | none found                          | installed source needs owner/disposition review                              |
| chat-button-skeleton         | `resources/views/components/ui/chat-button-skeleton/index.blade.php`         | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| checkbox                     | `resources/views/components/ui/checkbox/index.blade.php`                     | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| checkbox-group               | `resources/views/components/ui/checkbox-group/index.blade.php`               | family: checkbox           | owned by checkbox                    | no                  | owner live example: checkbox        | keep under owner unless public API is required                               |
| checkbox-skeleton            | `resources/views/components/ui/checkbox-skeleton/index.blade.php`            | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| code-snippet                 | `resources/views/components/ui/code-snippet/index.blade.php`                 | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| combo-box                    | `resources/views/components/ui/combo-box/index.blade.php`                    | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| combo-button                 | `resources/views/components/ui/combo-button/index.blade.php`                 | family: menu-buttons       | owned by menu-buttons                | no                  | owner live example: menu-buttons    | keep under owner unless public API is required                               |
| contained-list               | `resources/views/components/ui/contained-list/index.blade.php`               | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| contained-list-item          | `resources/views/components/ui/contained-list-item/index.blade.php`          | family: contained-list     | owned by contained-list              | no                  | owner live example: contained-list  | keep under owner unless public API is required                               |
| content-switcher             | `resources/views/components/ui/content-switcher/index.blade.php`             | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| copy-button                  | `resources/views/components/ui/copy-button/index.blade.php`                  | family: code-snippet       | owned by code-snippet                | no                  | owner live example: code-snippet    | keep under owner unless public API is required                               |
| danger-button                | `resources/views/components/ui/danger-button/index.blade.php`                | family: button             | owned by button                      | no                  | owner live example: button          | keep under owner unless public API is required                               |
| data-table                   | `resources/views/components/ui/data-table/index.blade.php`                   | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| data-table-empty-state       | `resources/views/components/ui/data-table/empty-state.blade.php`             | family: data-table         | owned by data-table                  | no                  | owner live example: data-table      | keep under owner unless public API is required                               |
| data-table-skeleton          | `resources/views/components/ui/data-table-skeleton/index.blade.php`          | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| data-table-toolbar           | `resources/views/components/ui/data-table/toolbar/index.blade.php`           | family: data-table         | owned by data-table                  | no                  | owner live example: data-table      | keep under owner unless public API is required                               |
| date-picker                  | `resources/views/components/ui/date-picker/index.blade.php`                  | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| date-picker-input            | `resources/views/components/ui/date-picker-input/index.blade.php`            | family: date-picker        | owned by date-picker                 | no                  | owner live example: date-picker     | keep under owner unless public API is required                               |
| date-picker-skeleton         | `resources/views/components/ui/date-picker-skeleton/index.blade.php`         | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| drawer                       | `resources/views/components/ui/drawer/index.blade.php`                       | missing                    | not in Definitions or needs owner review | no                  | none found                          | installed source needs owner/disposition review                              |
| dropdown                     | `resources/views/components/ui/dropdown/index.blade.php`                     | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| dropdown-skeleton            | `resources/views/components/ui/dropdown-skeleton/index.blade.php`            | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| file-uploader                | `resources/views/components/ui/file-uploader/index.blade.php`                | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| file-uploader-button         | `resources/views/components/ui/file-uploader-button/index.blade.php`         | family: file-uploader      | owned by file-uploader               | no                  | none found                          | keep under owner unless public API is required                               |
| file-uploader-drop-container | `resources/views/components/ui/file-uploader-drop-container/index.blade.php` | family: file-uploader      | owned by file-uploader               | no                  | none found                          | keep under owner unless public API is required                               |
| file-uploader-item           | `resources/views/components/ui/file-uploader-item/index.blade.php`           | family: file-uploader      | owned by file-uploader               | no                  | none found                          | keep under owner unless public API is required                               |
| file-uploader-skeleton       | `resources/views/components/ui/file-uploader-skeleton/index.blade.php`       | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| filename                     | `resources/views/components/ui/filename/index.blade.php`                     | family: file-uploader      | owned by file-uploader               | no                  | none found                          | keep under owner unless public API is required                               |
| filterable-multi-select      | `resources/views/components/ui/filterable-multi-select/index.blade.php`      | family: multiselect        | owned by multiselect                 | no                  | owner live example: multiselect     | keep under owner unless public API is required                               |
| form                         | `resources/views/components/ui/form/index.blade.php`                         | exact                      | primary page                         | no                  | none found                          | pattern-owned; needs contract migration only if kept as public component API |
| form-group                   | `resources/views/components/ui/form-group/index.blade.php`                   | family: form               | owned by form                        | no                  | none found                          | keep under owner unless public API is required                               |
| form-item                    | `resources/views/components/ui/form-item/index.blade.php`                    | family: form               | owned by form                        | no                  | none found                          | keep under owner unless public API is required                               |
| form-label                   | `resources/views/components/ui/form-label/index.blade.php`                   | family: form               | owned by form                        | no                  | none found                          | keep under owner unless public API is required                               |
| h-stack                      | `resources/views/components/ui/h-stack/index.blade.php`                      | missing                    | owned by stack                       | no                  | none found                          | stack owner is uncataloged; needs disposition review                         |
| icon                         | `resources/views/components/ui/icon/index.blade.php`                         | missing                    | not in Definitions or needs owner review | no                  | none found                          | installed source needs owner/disposition review                              |
| icon-button                  | `resources/views/components/ui/icon-button/index.blade.php`                  | family: button             | owned by button                      | no                  | owner live example: button          | recommended pilot after Tag                                                  |
| icon-skeleton                | `resources/views/components/ui/icon-skeleton/index.blade.php`                | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| notification-inline          | `resources/views/components/ui/notification/inline.blade.php`                | family: notification       | owned by notification                | yes                 | notification examples               | current inline notification owner                                            |
| inline-loading               | `resources/views/components/ui/inline-loading/index.blade.php`               | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| link                         | `resources/views/components/ui/link/index.blade.php`                         | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| list                         | not found                                                                    | exact                      | primary page                         | no                  | live example                        | family source uses child folders                                             |
| list-item                    | `resources/views/components/ui/list-item/index.blade.php`                    | family: list               | owned by list                        | no                  | owner live example: list            | keep under owner unless public API is required                               |
| loading                      | `resources/views/components/ui/loading/index.blade.php`                      | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| menu                         | `resources/views/components/ui/menu/index.blade.php`                         | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| menu-button                  | `resources/views/components/ui/menu-button/index.blade.php`                  | family: menu-buttons       | owned by menu-buttons                | no                  | owner live example: menu-buttons    | keep under owner unless public API is required                               |
| menu-buttons                 | not found                                                                    | exact                      | primary page                         | no                  | live example                        | family source uses child folders                                             |
| menu-item                    | `resources/views/components/ui/menu-item/index.blade.php`                    | family: menu               | owned by menu                        | no                  | owner live example: menu            | keep under owner unless public API is required                               |
| modal                        | `resources/views/components/ui/modal/index.blade.php`                        | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| multi-select                 | `resources/views/components/ui/multi-select/index.blade.php`                 | family: multiselect        | owned by multiselect                 | no                  | owner live example: multiselect     | current installed public API candidate                                       |
| multiselect                  | not found                                                                    | exact                      | primary page                         | no                  | live example                        | docs/reference owner exists; exact Blade folder does not                     |
| notification                 | not found                                                                    | exact                      | primary page                         | no                  | none found                          | docs/reference owner exists; exact Blade folder does not                     |
| number-input                 | `resources/views/components/ui/number-input/index.blade.php`                 | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| number-input-skeleton        | `resources/views/components/ui/number-input-skeleton/index.blade.php`        | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| ordered-list                 | `resources/views/components/ui/ordered-list/index.blade.php`                 | family: list               | owned by list                        | no                  | owner live example: list            | keep under owner unless public API is required                               |
| overflow-menu                | `resources/views/components/ui/overflow-menu/index.blade.php`                | family: menu-buttons       | owned by menu-buttons                | no                  | owner live example: menu-buttons    | keep under owner unless public API is required                               |
| pagination                   | `resources/views/components/ui/pagination/index.blade.php`                   | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| password-input               | `resources/views/components/ui/password-input/index.blade.php`               | family: text-input         | owned by text-input                  | no                  | owner live example: text-input      | keep under owner unless public API is required                               |
| popover                      | `resources/views/components/ui/popover/index.blade.php`                      | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| progress-bar                 | `resources/views/components/ui/progress-bar/index.blade.php`                 | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| progress-indicator           | `resources/views/components/ui/progress-indicator/index.blade.php`           | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| progress-step                | `resources/views/components/ui/progress-step/index.blade.php`                | family: progress-indicator | owned by progress-indicator          | no                  | none found                          | keep under owner unless public API is required                               |
| radio-button                 | `resources/views/components/ui/radio-button/index.blade.php`                 | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| radio-button-group           | `resources/views/components/ui/radio-button-group/index.blade.php`           | family: radio-button       | owned by radio-button                | no                  | none found                          | keep under owner unless public API is required                               |
| radio-button-skeleton        | `resources/views/components/ui/radio-button-skeleton/index.blade.php`        | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| radio-group                  | `resources/views/components/ui/radio-group/index.blade.php`                  | family: radio-button       | owned by radio-button                | no                  | none found                          | keep under owner unless public API is required                               |
| search                       | `resources/views/components/ui/search/index.blade.php`                       | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| search-skeleton              | `resources/views/components/ui/search-skeleton/index.blade.php`              | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| searchable-select            | `resources/views/components/ui/searchable-select/index.blade.php`            | missing                    | not in Definitions or needs owner review | no                  | none found                          | installed source needs owner/disposition review                              |
| select                       | `resources/views/components/ui/select/index.blade.php`                       | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| select-item                  | `resources/views/components/ui/select-item/index.blade.php`                  | family: select             | owned by select                      | no                  | owner live example: select          | keep under owner unless public API is required                               |
| select-item-group            | `resources/views/components/ui/select-item-group/index.blade.php`            | family: select             | owned by select                      | no                  | owner live example: select          | keep under owner unless public API is required                               |
| select-skeleton              | `resources/views/components/ui/select-skeleton/index.blade.php`              | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| slider                       | `resources/views/components/ui/slider/index.blade.php`                       | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| slider-skeleton              | `resources/views/components/ui/slider-skeleton/index.blade.php`              | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| stack                        | `resources/views/components/ui/stack/index.blade.php`                        | missing                    | not in Definitions or needs owner review | no                  | none found                          | stack owner needs disposition review before h/v-stack contracts              |
| status                       | `resources/views/components/ui/status/index.blade.php`                       | family: notification       | owned by notification                | no                  | none found                          | keep under notification owner                                                |
| status-icon                  | `resources/views/components/ui/status-icon/index.blade.php`                  | family: notification       | owned by notification                | no                  | none found                          | keep under notification owner                                                |
| structured-list              | `resources/views/components/ui/structured-list/index.blade.php`              | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| structured-list-row          | `resources/views/components/ui/structured-list-row/index.blade.php`          | family: structured-list    | owned by structured-list             | no                  | owner live example: structured-list | keep under owner unless public API is required                               |
| switch                       | `resources/views/components/ui/switch/index.blade.php`                       | family: toggle             | owned by toggle                      | no                  | none found                          | keep under toggle owner unless public API is required                        |
| tabs                         | `resources/views/components/ui/tabs/index.blade.php`                         | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| tag                          | `resources/views/components/ui/tag/index.blade.php`                          | exact                      | primary page                         | yes                 | live example                        | pilot contract surface                                                       |
| tag-group                    | `resources/views/components/ui/tag-group/index.blade.php`                    | family: tag                | owned by tag                         | owner contract: tag | owner live example: tag             | keep under Tag contract unless public API is required                        |
| text-area                    | `resources/views/components/ui/text-area/index.blade.php`                    | family: text-input         | owned by text-input                  | no                  | owner live example: text-input      | keep under owner unless public API is required                               |
| text-area-skeleton           | `resources/views/components/ui/text-area-skeleton/index.blade.php`           | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| text-input                   | `resources/views/components/ui/text-input/index.blade.php`                   | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| text-input-skeleton          | `resources/views/components/ui/text-input-skeleton/index.blade.php`          | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| tile                         | `resources/views/components/ui/tile/index.blade.php`                         | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| time-picker                  | `resources/views/components/ui/time-picker/index.blade.php`                  | family: date-picker        | owned by date-picker                 | no                  | owner live example: date-picker     | keep under date-picker owner unless public API is required                   |
| toggle                       | `resources/views/components/ui/toggle/index.blade.php`                       | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| toggle-skeleton              | `resources/views/components/ui/toggle-skeleton/index.blade.php`              | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| toggle-small-skeleton        | `resources/views/components/ui/toggle-small-skeleton/index.blade.php`        | family/skeleton            | skeleton/helper                      | no                  | none found                          | keep under owner unless public API is required                               |
| toggletip                    | `resources/views/components/ui/toggletip/index.blade.php`                    | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| tooltip                      | `resources/views/components/ui/tooltip/index.blade.php`                      | exact                      | primary page                         | no                  | live example                        | needs contract migration                                                     |
| tree-view                    | `resources/views/components/ui/tree-view/index.blade.php`                    | exact                      | primary page                         | no                  | none found                          | needs contract migration                                                     |
| ui-shell                     | `resources/views/components/shell/**`                                        | exact                      | represented as pattern               | no                  | represented as navigation pattern   | shell contract should be considered separately from `x-ui` components        |
| unordered-list               | `resources/views/components/ui/unordered-list/index.blade.php`               | family: list               | owned by list                        | no                  | owner live example: list            | keep under owner unless public API is required                               |
| v-stack                      | `resources/views/components/ui/v-stack/index.blade.php`                      | missing                    | owned by stack                       | no                  | none found                          | stack owner needs disposition review                                         |

## Token CSS Audit

| CSS token source                                       | Audit result                                                    |
| ------------------------------------------------------ | --------------------------------------------------------------- |
| `resources/css/tokens/index.css`                       | Token entry point exists.                                       |
| `resources/css/tokens/layout.css`                      | Layout tokens exist.                                            |
| `resources/css/tokens/motion.css`                      | Motion tokens exist.                                            |
| `resources/css/tokens/shadow.css`                      | Shadow tokens exist.                                            |
| `resources/css/tokens/spacing.css`                     | Spacing tokens exist.                                           |
| `resources/css/tokens/z-index.css`                     | Z-index tokens exist.                                           |
| `resources/css/tokens/components/buttons.css`          | Component token file exists.                                    |
| `resources/css/tokens/components/content-switcher.css` | Component token file exists.                                    |
| `resources/css/tokens/components/index.css`            | Component token entry point exists.                             |
| `resources/css/tokens/components/notifications.css`    | Component token file exists.                                    |
| `resources/css/tokens/components/status.css`           | Component token file exists.                                    |
| `resources/css/tokens/components/tags.css`             | Component token file exists.                                    |
| `resources/css/tokens/components/ui-shell.css`         | Shell token file exists, including recent shell migration work. |
| `resources/css/tokens/palette/**`                      | Palette token family exists.                                    |
| `resources/css/tokens/semantic/**`                     | Semantic token family exists.                                   |
| `resources/css/tokens/themes/**`                       | Theme token family exists.                                      |
| `resources/css/tokens/type/index.css`                  | Type token entry point exists.                                  |

## Recommended Launch Target Model

Use this target model for contract-driven UI Reference migration:

1. `contract.php` is durable API/config truth for a UI owner.
2. `reference.php` is optional owner-local UI Reference page structure when the owner needs detail tabs beyond contract data.
3. Examples are required manual review surfaces for launch.
4. Overview, Usage, Tokens, Accessibility, and supporting educational pages are optional until the owner needs them.
5. Subcomponents, skeletons, variants, aliases, and internal helpers should live under owner contracts unless they are intentionally public APIs.
6. Missing contracts are backlog, not stale-source evidence.
7. Installed Blade remains the source evidence for what a contract may claim.

## Recommended Migration Sequence

1. Normalize the contract template and contract-file standard against observed Tag and Element contracts. Do not add component contracts yet.
2. Confirm the canonical example contract from actual source: use Tag as the component contract reference and Color/Themes as Element reference-definition examples.
3. Create a migration matrix in implementation docs or a generated report that classifies each installed `x-ui` folder as owner, subcomponent, skeleton, alias, internal, planned, or removal candidate.
4. Pilot Tag as the first contract-backed component reference page. Confirm its Examples surface is contract-backed or can be read from the existing live example without breaking current UI Reference.
5. Pilot Icon Button as a Button-owned subcomponent or advanced Button variant after Button source is reviewed. Do not claim a Button owner contract exists until it is created from source.
6. Add or confirm an Examples-only renderer that can consume contract example entries where available while preserving existing PHP Definitions pages.
7. Batch migrate owner components by category after the pilot proves the renderer and readiness states.
8. Defer Overview/Usage/Tokens page rewrites until owner contracts exist and manual Examples review is stable.

## Recommended Next Prompt

```text
PLEASE IMPLEMENT ONE SCOPED PASS FROM doc-review-2026-07-02-ui-contract-reference-audit:

Implement the contract-driven UI Reference pilot only. Use the current Tag contract and installed Tag Blade/CSS/JS source as the component proof, and use Color/Themes Element contracts plus reference.php files as schema references. Do not bulk-create contracts. Do not rewrite all UI Reference pages.

Scope:
- Confirm `docs/02-standards/ui/contract-file.md` and `docs/09-reference/ui/ui-contract-template.php` match the observed runtime contract shape.
- Update only stale docs or reference wording that implies Button already has a runtime contract.
- Add the minimal Examples-only contract renderer or adapter if one is missing, preserving current Definitions-driven pages.
- Keep Tag as the component pilot and add tests for contract loading/readiness and Examples rendering if the current test stack supports it.
- Produce a follow-up migration matrix for the next owner components, including Button/Icon Button, Multiselect, Notification, and Text Input families.

Validation:
- Prove no new contracts were created except if the implementation explicitly scopes a single pilot subcomponent and documents why.
- Prove Tag contract still loads through `UiContractRepository`.
- Prove existing UI Reference routes still resolve for Tag, Color, and Themes.
- Update the review ledger row for this review to implemented or partial, based on actual completion.
```

## Validation Evidence

Commands were run excluding `docs/_archive/` unless the searched path was already outside docs:

```text
Get-ChildItem resources/views -Recurse -Filter contract.php
```

Result: 9 contracts found. They are Tag plus eight Elements. No Button contract was found.

```text
Get-ChildItem resources/views -Recurse -Filter reference.php
```

Result: 2 reference definition files found: Color and Themes.

```text
Get-ChildItem docs/02-standards/ui/components,docs/02-standards/ui/elements,docs/02-standards/ui/patterns -File -Recurse
```

Result: 68 active files found and listed in the standards audit table.

```text
Get-ChildItem docs/02-standards/ui/tokens -Recurse -File
```

Result: 0 active token docs found. The token docs directory exists but is empty.

```text
Get-ChildItem resources/views/components/ui -Directory | Where-Object { Test-Path (Join-Path $_.FullName 'index.blade.php') }
```

Result: 100 installed `x-ui` folders found and included in the component matrix.

```text
Get-ChildItem resources/views/platform/ui-reference -Recurse -Filter *.blade.php
```

Result: 87 active UI Reference Blade views found and classified by view group.

```text
Get-ChildItem resources/views/platform/ui-reference/components/live-examples -File -Filter *.blade.php
```

Result: 23 component live examples found and individually classified.

```text
rg -n "/platform/ui-reference" routes/web.php
```

Result: 32 route lines found in the UI Reference route group.

```text
rg -n "Heroicons|heroicon|x-heroicon|x-icons" docs/02-standards/ui app resources/views/platform/ui-reference resources/views/components/ui -g "*.md" -g "*.php" -g "*.blade.php"
```

Result: active Heroicons references are placeholder guidance in `docs/02-standards/ui/elements/icons.md`; `resources/views/components/ui/icon/docs.php` includes a caution about dynamic `x-icons.*` usage.

## Open Follow-Up Items

- Decide whether `badge`, `chat-button`, `drawer`, `icon`, `searchable-select`, and `stack` are public components, owner-owned helpers, internal-only, or removal candidates.
- Decide whether `ai-label` remains a planned standards surface without runtime Blade source.
- Decide whether `form` should receive a public component contract or stay pattern-owned.
- Add token standards docs under `docs/02-standards/ui/tokens/` or deliberately point token standards ownership elsewhere.
- Build contracts from installed source and examples, not from documentation claims alone.
