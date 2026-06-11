# Notes

## Current Batch F State

- Batch F remains active for Phase 2 starter-proof implementation. It is not ready for finalization because active queue items remain.
- Staging deploy is explicitly out of scope for Batch F and remains disabled pending security incident review.
- P2-F-CQ-001 is Passed Review. The Carbon contrast audit, starter catalog matrix, and route disposition matrix are accepted as sufficient routing source material for the remaining Batch F work.
- P2-F-CQ-007 is Passed Review. `/platform/ui-reference/patterns/starters` is the accepted UI Reference starter catalog entry point.
- P2-F-CQ-128 is Implemented Pending Review. The newly installed/promoted APIs from P2-F-CQ-135 now have UI Reference proof pages using installed APIs instead of local/reference-only markup.
- P2-F-CQ-129 is Implemented Pending Review. It established the component recovery sequence, added one queued correction/proof item per remaining unresolved Component API or disposition group, and made Menu the first correction target.
- P2-F-CQ-074, P2-F-CQ-079, P2-F-CQ-093, and P2-F-CQ-151 are Passed Review as of 2026-06-11. Breadcrumb, Button, Menu buttons, and Tooltip are accepted Component recovery pages and are shown as approved in the UI Reference sidebar.
- P2-F-CQ-077 is Implemented Pending Review. Menu now uses the documented `x-ui.menu` / `x-ui.menu-item` API, examples start closed and interactable by default, and static proof panels demonstrate item states, sizing, placement, checkable roles, submenu hooks, and title behavior without hiding surrounding reference text.
- P2-F-CQ-136 through P2-F-CQ-150 and P2-F-CQ-152 through P2-F-CQ-163 are Implemented Pending Review. The remaining Component API proof/recovery pages now use installed APIs or explicit disposition/gap ownership instead of generic placeholders.
- P2-F-CQ-160 is Implemented Pending Review. Content switcher has been promoted from deferred to an installed `x-ui.content-switcher` API with lifecycle-owned switching behavior, token-backed classes, and UI Reference proof examples.
- Starter items P2-F-CQ-002 through P2-F-CQ-006 remain blocked behind manual review of the remaining component recovery queue: P2-F-CQ-075 through P2-F-CQ-078, P2-F-CQ-080, P2-F-CQ-136 through P2-F-CQ-150, and P2-F-CQ-152 through P2-F-CQ-163.
- P2-F-CQ-008, P2-F-CQ-009, P2-F-CQ-010, and P2-F-CQ-011 are Passed Review as of 2026-06-06. Correction pass 2-F-0015 was accepted, with follow-up scope normalized into P2-F-CQ-016 through P2-F-CQ-024.
- P2-F-CQ-016 through P2-F-CQ-024 are Closed as superseded by the later Component UI Reference/API standards, installed public API wrapper layer, and component-specific recovery queue.
- P2-F-CQ-025 through P2-F-CQ-032 are Passed Review as of 2026-06-08. Worklog 2-F-0017 added the Foundation Elements catalog/sidebar/pages, canonical element docs, non-canonical Carbon comparison notes, token/theme/spacing/typography/icon standards, T1 component doc-link contract, Multiselect catalog correction, and UI shell family normalization.
- P2-F-CQ-040 through P2-F-CQ-048 are Passed Review as of 2026-06-08. Worklog 2-F-0018 replaced the broad Foundation Elements correction with page-level live implementation guides for Color, Themes, 2x Grid, Spacing, Typography, Icons, Pictograms, Motion, and Overview/renderer cleanup.
- P2-F-CQ-049 through P2-F-CQ-058 are Passed Review as of 2026-06-08. Worklog 2-F-0019 corrected status labeling, token-backed Color/Themes/Icons/Typography/Motion/Pictograms examples, shared focus/status/alert usage, docs, tests, and handoff.
- P2-F-CQ-059 is Passed Review as of 2026-06-08. Worklog 2-F-0020 corrected the final Color layering and Typography scale review gaps before Foundation Elements approval.
- P2-F-CQ-060 through P2-F-CQ-065 are Passed Review as of 2026-06-08. Worklog 2-F-0021 added the separate Color Token Palette route, token family disposition map, expanded app role-token namespaces, component adoption audit, docs, tests, and handoff.
- P2-F-CQ-066 through P2-F-CQ-069 are Passed Review as of 2026-06-08. Worklog 2-F-0022 adopts the Component UI Reference requirements into canonical docs, corrects visible menu terminology to Components/Patterns, expands the component catalog metadata, and updates the Components index.
- P2-F-CQ-070 through P2-F-CQ-073 are Passed Review as of 2026-06-08. The corrected five-card Component page scaffold shape and Accordion exemplar are approved for now and should be used as the baseline for broader component family-depth rollout.
- P2-F-CQ-033 through P2-F-CQ-039 are Closed as superseded. Manual review rejected the broad family-depth pass because several pages still used generic sample content, weak one-sentence state summaries, placeholder developer examples, and incomplete scenario/variant mapping.
- P2-F-CQ-075, P2-F-CQ-076, and P2-F-CQ-078 are Implemented Pending Review. Worklog 2-F-0025 starts component-by-component recovery with Tabs, Code snippet, and a generic fallback ban.
- P2-F-CQ-079 passed manual review after its final Button correction against the expanded variant, size, group, icon, content, and tooltip requirements.
- P2-F-CQ-116 is Implemented Pending Review. Component pages still use the five-card scaffold, but broad components may now use matrices, sizing scales, state tables, grouped examples, and full-width demonstrations inside Live examples instead of a tab-only layout.
- P2-F-CQ-117 is Implemented Pending Review. Canonical UI standards now use flat `docs/02-standards/ui/components/{component}.md`, `docs/02-standards/ui/patterns/{pattern}.md`, and existing `docs/02-standards/ui/elements/{element}.md` paths.
- P2-F-CQ-118 is Implemented Pending Review. Element, Component, and Pattern standards now read as installed UI API contracts, UI Reference pages remain the rendered proof surface, and `docs/02-standards/ui/contracts/` is transitional source material only.
- P2-F-CQ-119 is Implemented Pending Review. `2x-grid` is now the canonical Foundation Element slug, route, and doc; `grid` remains only as a compatibility alias and the duplicate `grid.md` standard was removed.
- P2-F-CQ-120 is Implemented Pending Review. Motion now renders expressive motion as gated, uses installed component APIs for productive motion proof where available, replaces native `<details>` accordion proof with the canonical Accordion API, normalizes Pattern links, and strengthens focused Foundation assertions.
- P2-F-CQ-132 through P2-F-CQ-134 are Implemented Pending Review. Worklog 2-F-0037 reconciles the updated numbered UI standards with `api-registry.md`, folder indexes, stale planned route references, malformed promoted-standard tables, active implementation sync, and follow-up install queue state.
- P2-F-CQ-135 is Implemented Pending Review. It installed or mapped newly approved target APIs now declared by the updated standards: Contained list, List, Multiselect, Popover, Slider/Range slider, and Tree view.
- P2-F-CQ-128 is Implemented Pending Review. Contained list, List, Multiselect, Popover, Slider/Range slider, and Tree view UI Reference pages now prove the installed APIs, developer snippets, rendered scenarios, variants/states, and behavior hooks.
- P2-F-CQ-074 passed manual review after the focused Breadcrumb correction: default trails stop at the previous page with a trailing separator, overflow uses an interactable menu styled through the Menu API, and compact widths collapse to the overflow trigger plus final crumb without horizontal spill.
- P2-F-CQ-012 and P2-F-CQ-013 are Closed as superseded by the later UI API standards and active implementation sync model.
- P2-F-CQ-169 failed manual review after worklog 2-F-0049 because the native disclosure recovery restored behavior through local `<details>/<summary>` navigation. Worklog 2-F-0050 reopens and corrects it as Navigation Pattern/UI shell work with token-backed sidebar classes, lifecycle-owned disclosure buttons, named nav regions, `aria-current` links, Heroicon chevrons, focused regression tests, and authenticated browser review.
- Detailed correction history for P2-F-CQ-001 and P2-F-CQ-007 is preserved in worklog-2-F-0002 through worklog-2-F-0008. Do not duplicate that history in active notes.

## Current Implementation Guidance

- Use existing Components and Patterns.
- Keep starter examples reusable and generic.
- Normalize existing proof surfaces only where needed to demonstrate the starter contract.
- Do not expand account, notifications, customer/public, or module-specific behavior.
- Carbon remains a documentation-depth and completeness benchmark only. Do not visually copy IBM software or replace the existing Login App 2.0 visual direction.
- Translate audit findings into Login App 2.0-specific standards, examples, classes, ready-to-use components, component sets, and starter views.
- P2-F-CQ-129 established the component-by-component recovery sequence. Treat current standards docs as the contract, installed Component APIs as source truth, and UI Reference pages as rendered proof.
- The next implementation pass should not start starter pages until manual review accepts the component recovery sequence as starter-safe.
- P2-F-CQ-025 through P2-F-CQ-032 establish Foundation Elements beneath Components. Future component deepening should consume those standards for tokens, spacing, typography, iconography, themes, grid, and motion rather than restating them per component.
- P2-F-CQ-040 through P2-F-CQ-065 supersede the previous broad Foundation Elements correction item. The accepted bar is page-level: every Foundation page must show rendered examples and applied behaviors, not just token inventories or prose, and examples must use app tokens/classes where they represent app components.
- The Color Overview owns palette, layering, state, focus, disabled, inverse, and high-contrast examples. The nested Color Token Palette route owns Carbon-depth token family coverage and app disposition mapping.
- Typography and component developer examples must use token-backed code snippet treatment for highlighted code roles; plain monospace labels are not sufficient when the page is demonstrating code or syntax color.
- Keep examples within existing Login App 2.0 visual direction. Do not create reference photo examples, broad accessibility test suites, Carbon visual token adoption, or unrelated runtime feature expansion.
- Installation/implementation guidance means local component usage guidance: component names, props/attributes, required classes/wrappers, data attributes, owner routes, and expected usage boundaries.
- P2-F-CQ-012 and P2-F-CQ-013 no longer own active implementation decisions; use current UI API standards and active implementation sync for next work.

## Current Risks And Follow-Ups

- The previously noted widget-content `data-ui-pattern="dashboard-grid"` validation gap has been stabilized in the token/SOLID cleanup validation pass. Future Batch F work should keep that route covered by focused UI Reference tests.
- SettingsController update-flow extraction and realtime notification transport/rendering cleanup are deferred out of Batch F unless the current UI starter/guidance work exposes a direct blocker.
- Future work passes should read the targeted queue item first, then open only the specific source/reference files needed for that item.
- Manual review should not approve P2-F-CQ-016 through P2-F-CQ-024 or P2-F-CQ-033 through P2-F-CQ-039 as standalone passes; they are superseded by the current API proof/recovery gates.
- Manual review should focus next on the remaining component recovery set: `/platform/ui-reference/components/tabs`, `/platform/ui-reference/components/code-snippet`, `/platform/ui-reference/components/menu`, and the remaining `P2-F-CQ-136` through `P2-F-CQ-150` plus `P2-F-CQ-152` through `P2-F-CQ-163` routes starting with `/platform/ui-reference/components/link`.
- Worklogs remain the immutable history location for detailed pass notes, failed review attempts, and correction narratives.
