---
title: Pattern Library Checklist
slug: pattern-library-checklist
api_layer: Pattern API Checklist
status: implemented-pending-manual-review
system_maturity: partial-family-rollout
category: pattern-library
priority: pattern-library-baseline
canonical_doc: docs/02-standards/ui/patterns/checklist.md
source_owner: not installed
rendered_evidence_route: null
related_indexes:
  - docs/02-standards/ui/patterns/index.md
  - docs/02-standards/ui/patterns/boundary-and-validation.md
  - docs/02-standards/ui/components/checklist.md
  - docs/02-standards/ui/components/index.md
  - docs/02-standards/ui/elements/index.md
foundation_elements:
  - color
  - spacing
  - typography
  - icons
  - motion
  - themes
  - 2x-grid
---

# Pattern Library Checklist
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Purpose](#3-purpose)
- [4. Pattern definition](#4-pattern-definition)
- [5. Component and Pattern boundary](#5-component-and-pattern-boundary)
- [6. Required API contract per Pattern](#6-required-api-contract-per-pattern)
- [7. Required Pattern front matter](#7-required-pattern-front-matter)
- [8. Global implementation checklist](#8-global-implementation-checklist)
  - [8.1. Scope and goal](#81-scope-and-goal)
  - [8.2. API contract](#82-api-contract)
  - [8.3. Element consumption](#83-element-consumption)
  - [8.4. Component composition](#84-component-composition)
  - [8.5. Layout and responsive behavior](#85-layout-and-responsive-behavior)
  - [8.6. State ownership](#86-state-ownership)
  - [8.7. Accessibility](#87-accessibility)
  - [8.8. Content](#88-content)
  - [8.9. rendered evidence proof](#89-ui-reference-proof)
  - [8.10. Testing](#810-testing)
- [9. Pattern family checklist](#9-pattern-family-checklist)
- [10. Pattern standard review checklist](#10-pattern-standard-review-checklist)
- [11. rendered evidence validation](#11-ui-reference-validation)
- [12. Regression checks](#12-regression-checks)
- [13. Read guidance](#13-read-guidance)
- [14. Update workflow](#14-update-workflow)
- [15. Related](#15-related)
- [16. References](#16-references)

## 1. API summary

This document is the canonical implementation checklist hub for Login App 2.0 Pattern API standards.

Pattern standards define reusable goal-oriented compositions built from Element APIs and Component APIs. They are not abstract design articles. They are implementation contracts for composition, state ownership, responsive behavior, accessibility, content, rendered evidence proof, and tests.

Use this checklist when creating, correcting, or reviewing Pattern standards under `docs/02-standards/ui/patterns`.

Carbon alignment note: Carbon describes patterns as best-practice solutions for how users achieve goals through reusable combinations of components and templates that address common objectives with sequences and flows. Login App applies that concept through app-owned Pattern API standards, route-owned rendered evidence proof, Foundation Element consumption, and installed Component composition rather than copying Carbon implementation classes.

## 2. Status and ownership

| Field                        | Value                                                      |
| ---------------------------- | ---------------------------------------------------------- |
| Status                       | Implemented - pending manual review                        |
| System maturity              | Partial family rollout                                     |
| API layer                    | Pattern API Checklist                                      |
| Checklist slug               | `pattern-library-checklist`                                |
| Canonical doc                | `docs/02-standards/ui/patterns/checklist.md`               |
| Source owner                 | `not installed`                          |
| rendered evidence owner           | `not installed`                          |
| Applies to                   | Pattern standards and Pattern rendered evidence pages           |
| Related boundary doc         | `docs/02-standards/ui/patterns/boundary-and-validation.md` |
| Related Pattern index        | `docs/02-standards/ui/patterns/index.md`                   |
| Related Component checklist  | `docs/02-standards/ui/components/checklist.md`             |
| Foundation Elements consumed | Color, Spacing, Typography, Icons, Motion, Themes, 2x Grid |

`Implemented - pending manual review` means this hub is the installed checklist model, but each Pattern family file and individual Pattern standard still needs review against this hub as it is corrected or added.

## 3. Purpose

Use this checklist to verify that every Pattern standard:

- Defines a reusable user goal, sequence, or workflow.
- Composes installed Component APIs instead of rebuilding local UI.
- Consumes Foundation Elements instead of creating local design primitives.
- Documents what the Pattern owns and what the child Components own.
- Defines state ownership across the full composition.
- Defines responsive layout and workflow behavior.
- Defines accessibility, keyboard, focus, and announcement requirements.
- Defines content rules for headings, labels, actions, helper text, empty states, and status copy.
- Defines prohibited local implementations.
- Defines deferred or gated extensions.
- Defines rendered evidence proof requirements.
- Defines route, source, and test expectations.

Every Pattern checklist item must be evaluated against the installed API-contract structure in [Pattern API Standards](index.md).

## 4. Pattern definition

A Pattern is a reusable composition that helps a user complete a goal or understand a workflow.

A Pattern may own:

- A sequence of steps or states.
- Component composition and ordering.
- Cross-component spacing and layout.
- State orchestration across multiple Components.
- Responsive behavior for a composed region.
- Accessibility relationships across Components.
- Workflow-level feedback and error placement.
- Content hierarchy and copy patterns.
- rendered evidence proof for the full composition.

A Pattern must not own:

- Local replacements for installed Component APIs.
- Local tokens, colors, spacing, typography, icons, motion, or theme behavior.
- A one-off page implementation with no reusable boundary.
- A speculative workflow that is not installed, queued, gated, or explicitly deferred.
- Feature-specific business logic that belongs to a product route, controller, service, policy, or data model.

## 5. Component and Pattern boundary

Component and Pattern boundaries, implementation rules, shared checklist format, cross-cutting constraints, rendered evidence validation, and Batch B exit criteria are owned by:

- [Pattern Boundary And Validation](boundary-and-validation.md)

Read that file when any of these are unclear:

- Whether a composition is a Pattern or just a Component example.
- Whether spacing/layout is owned by a Component, Pattern, or page route.
- Whether state is owned by a child Component or parent Pattern.
- Whether a proposed API should be installed, deferred, gated, or rejected.
- Whether rendered evidence proof is sufficient for Pattern acceptance.
- Whether a test belongs to a Component, Pattern, or route feature test.

Default boundary rule:

| Layer         | Owns                                                                                                                   | Does not own                                                                             |
| ------------- | ---------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------- |
| Element API   | Tokens, primitives, utility roles, theme behavior, motion roles, icon source, grid model                               | Component-specific markup or workflow composition                                        |
| Component API | Single reusable UI primitive or baseline control/display component                                                     | Page-level layout, multi-component workflows, parent spacing, persistence, orchestration |
| Pattern API   | Reusable composition, workflow, state orchestration, layout region, responsive behavior, cross-component accessibility | Local replacements for Components, feature-specific business logic, raw tokens           |

## 6. Required API contract per Pattern

Every Pattern standard must define these sections in this order unless the Pattern index accepts a family-specific exception:

1. API summary.
2. Status and ownership.
3. Installed standard.
4. Pattern API.
5. Required composition.
6. Optional composition.
7. Consumed Element APIs.
8. Owned Component APIs.
9. Allowed variants and layout options.
10. State ownership.
11. Responsive behavior.
12. Composition rules.
13. Selection guidance.
14. Accessibility contract.
15. Content contract.
16. Prohibited usage.
17. Deferred or gated capabilities.
18. Rendered evidence requirements.
19. Testing and acceptance criteria.
20. Related APIs.
21. References.

Every section must be concrete and reviewable. Do not leave placeholder copy such as `Pattern implementation pending`, `Use documented components`, `See rendered evidence`, or `Variants: None` when the Pattern has layout options, state modes, responsive modes, or composition variants.

## 7. Required Pattern front matter

Every Pattern standard should include front matter that makes ownership machine-readable.

Minimum front matter:

```yaml
---
title: Pattern name
slug: pattern-slug
api_layer: Pattern API
status: implemented-pending-correction
system_maturity: partial
category: pattern-family
priority: pattern-priority
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/patterns/pattern-slug.md
source_owner: not installed
consumed_elements:
  - color
  - spacing
  - typography
owned_components:
  - button
  - link
related_patterns:
  - related-pattern
---
```

Allowed status values:

| Status                                | Use when                                                                                  |
| ------------------------------------- | ----------------------------------------------------------------------------------------- |
| `Implemented`                         | Pattern is installed, documented, proved, and tested.                                     |
| `Implemented - pending manual review` | Pattern is installed and documented but needs human review before being marked complete.  |
| `Approved API`                        | Pattern exists but docs, rendered evidence proof, tests, or API boundaries need correction.    |
| `Partial`                             | Some Pattern behavior is installed but major variants/states remain incomplete.           |
| `Deferred`                            | No production Pattern API is approved yet.                                                |
| `Not implemented`                     | Pattern is not installed and should not be used.                                          |
| `App-approved exception`              | Pattern intentionally diverges from general guidance with documented rationale and tests. |
| `Pattern-owned`                       | Behavior is intentionally owned by a parent Pattern rather than a child Component.        |

## 8. Global implementation checklist

Use this checklist for every Pattern standard and rendered evidence page.

### 8.1. Scope and goal

| Check                          | Requirement                                                                                               |
| ------------------------------ | --------------------------------------------------------------------------------------------------------- |
| User goal is explicit          | The Pattern states the user objective, workflow, or decision it supports.                                 |
| Reusable boundary is explicit  | The Pattern names where it can be reused and where it must not be used.                                   |
| Component boundary is explicit | The Pattern states which child Components it composes and what each child owns.                           |
| Feature logic is excluded      | Business rules, permissions, persistence, and route-specific data logic are not presented as Pattern API. |
| Status is reviewable           | Installed, partial, deferred, gated, or exception status is visible and consistent.                       |

### 8.2. API contract

| Check                                 | Requirement                                                                                                              |
| ------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Pattern API is named                  | The Pattern names its public route, Blade composition, classes, data attributes, slots, or native structure where known. |
| Required composition is defined       | Required child Components, headings, regions, actions, feedback, layout containers, and landmarks are listed.            |
| Optional composition is defined       | Optional actions, empty states, helper text, filters, secondary regions, and support content are listed.                 |
| Non-public API is blocked             | Undocumented props, local classes, raw utilities, data attributes, custom JS, or local tokens are prohibited.            |
| Unknown details are safely classified | Uncertain or future behavior is marked deferred, gated, not installed, or Pattern-owned.                                 |

### 8.3. Element consumption

| Check                                          | Requirement                                                                                                       |
| ---------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Color is consumed through tokens               | No raw hex values, local semantic colors, or feature-local status colors are approved.                            |
| Spacing is consumed through tokens/classes     | No arbitrary margins, gaps, paddings, or one-off layout utilities are approved as Pattern API.                    |
| Typography is consumed through the type system | No feature-local type scales or local heading/body overrides are approved.                                        |
| Icons use approved sources                     | No local SVG/icon set is introduced by the Pattern.                                                               |
| Motion uses approved roles                     | Transitions, disclosure, loading, overlays, and progress behavior use Foundation Motion and reduced-motion rules. |
| Themes resolve through tokens                  | Pattern proof covers supported theme behavior where applicable.                                                   |
| 2x Grid is used where layout matters           | Page/region layout follows the approved grid model instead of local grid systems.                                 |

### 8.4. Component composition

| Check                             | Requirement                                                                                      |
| --------------------------------- | ------------------------------------------------------------------------------------------------ |
| Installed Components are used     | Pattern examples compose approved Component APIs instead of rebuilding local markup.             |
| Child ownership is respected      | Components own internal semantics, states, and styling; Patterns own grouping and workflow.      |
| Parent spacing is Pattern-owned   | External spacing between Components is owned by Pattern layout rules, not child Component hacks. |
| Component state is not duplicated | Pattern does not create local state classes that conflict with child Component APIs.             |
| Component alternatives are named  | Pattern selection guidance explains when to use nearby Components or Patterns instead.           |

### 8.5. Layout and responsive behavior

| Check                                     | Requirement                                                                                                          |
| ----------------------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Layout regions are named                  | Header, body, toolbar, footer, sidebar, content, empty, loading, and action regions are identified where applicable. |
| Breakpoints are described                 | Responsive changes are explicit and tied to approved Grid/layout behavior.                                           |
| Stacking rules are defined                | Buttons, filters, fields, rows, cards, and toolbars define narrow-width stacking behavior.                           |
| Overflow behavior is defined              | Long labels, table overflow, filter overflow, action wrapping, and scroll containment are specified.                 |
| Page-level layout is not invented locally | Pattern routes use installed layout/shell/grid APIs.                                                                 |

### 8.6. State ownership

| Check                                                         | Requirement                                                                                                      |
| ------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Default state is defined                                      | Initial rendering and baseline content are documented.                                                           |
| Loading state is defined where applicable                     | Loading indicators, skeletons, busy regions, and disabled controls are owned by the Pattern or child Components. |
| Empty state is defined where applicable                       | No-data, no-results, and first-use states have content and layout rules.                                         |
| Error/warning/success states are defined where applicable     | Feedback placement and semantics are owned by the Pattern or Notification Component.                             |
| Disabled/read-only state is defined where applicable          | Disabled controls, permission boundaries, and read-only display states are documented.                           |
| Open/closed or expanded/collapsed is defined where applicable | Disclosure state, focus return, and keyboard behavior are documented.                                            |
| Selection/current state is defined where applicable           | Selection, current item, and route/current behavior are not conflated.                                           |
| Async state is owned                                          | Pending, optimistic, failed, retry, and rollback behavior are Pattern-owned unless a child Component owns it.    |

### 8.7. Accessibility

| Check                         | Requirement                                                                                                              |
| ----------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Landmarks/regions are clear   | Pattern defines required landmarks, regions, headings, captions, labels, and group semantics.                            |
| Focus order is logical        | Keyboard order follows visual/workflow order.                                                                            |
| Focus management is explicit  | Modal, drawer, disclosure, toast, menu, and async updates define focus behavior.                                         |
| Announcements are owned       | Status, validation, loading, completion, and error announcements use installed Components or Pattern-owned live regions. |
| Keyboard behavior is complete | Interactive compositions define Tab, Enter, Space, Escape, arrow keys, and focus return where relevant.                  |
| Color is not the only cue     | State, meaning, errors, warnings, and selection are supported by text/icon/semantics.                                    |
| Reduced motion is respected   | Motion-bearing Patterns document reduced-motion behavior.                                                                |
| Accessible names are required | Icon-only actions, field groups, regions, filters, and controls have clear names.                                        |

### 8.8. Content

| Check                               | Requirement                                                                          |
| ----------------------------------- | ------------------------------------------------------------------------------------ |
| Headings are concrete               | Pattern headings describe the user goal or region.                                   |
| Labels are specific                 | Buttons, filters, fields, links, and controls use concrete labels.                   |
| Helper/status copy is short         | Support copy is concise and placed near the relevant region.                         |
| Error copy explains recovery        | Errors state what failed and what the user can do next.                              |
| Empty copy is useful                | Empty states explain why content is missing and what can happen next.                |
| Action copy follows Component rules | Button and Link labels follow their Component content contracts.                     |
| No placeholder copy remains         | `Lorem ipsum`, `TODO`, `Sample text`, or implementation-pending copy is not allowed. |

### 8.9. rendered evidence proof

| Check                             | Requirement                                                                                                                           |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| Route exists                      | `not installed{slug}` returns 200 for authorized users when the Pattern is installed.                              |
| Five-card scaffold renders        | Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns render in order.                             |
| Live examples are production-like | Examples compose installed Components and app-owned classes.                                                                          |
| Variants/layouts render visually  | Supported variants, layout options, densities, alignments, and responsive modes are rendered, not only listed.                        |
| States render visually            | Default, loading, empty, error, warning, success, disabled, read-only, selection, expanded, and async states render where applicable. |
| Deferred states show gates        | Deferred/gated behavior shows trigger conditions and alternatives instead of fake UI.                                                 |
| Developer implementation is shown | Canonical composition code renders with token-backed Code snippet styling where useful.                                               |
| Prohibited usage is visible       | The page calls out local anti-patterns without presenting them as approved examples.                                                  |

### 8.10. Testing

| Check                                       | Requirement                                                                                                             |
| ------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Authorized route test exists                | Installed Pattern Rendered evidence route returns 200 for authorized users.                                                  |
| Unauthorized route behavior is covered      | Admin-only or platform authorization behavior is tested where applicable.                                               |
| Section assertions exist                    | Tests assert required cards/sections are visible.                                                                       |
| API assertions exist                        | Tests assert installed Components, classes, routes, and composition names are visible.                                  |
| State assertions exist                      | Tests assert required states, variants, layout options, and deferred gates are visible.                                 |
| Regression absence checks exist             | Tests assert placeholder and prohibited implementation strings are absent.                                              |
| Accessibility-critical strings are asserted | Tests assert labels, helper text, `aria-*` relationships, role notes, and focus/focus-return guidance where applicable. |

## 9. Pattern family checklist

Detailed pattern-family checklists live in focused child files so implementation and review agents can read only the family they are changing.

| Pattern family                           | Child file                                                 | Primary scope                                                                                              |
| ---------------------------------------- | ---------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| Common Actions Patterns                  | [common-actions/index.md](common-actions/index.md)         | Repeated action meaning, hierarchy, permission handling, loading, failure feedback, primitive readiness, confirmation, destructive action, and command/navigation wording. |
| Form Patterns                            | [forms.md](forms.md)                                       | Form layout, field groups, validation summaries, submit/cancel placement, helper/error/status composition. |
| Data And Content Patterns                | [data-and-content.md](data-and-content.md)                 | Tables, lists, cards, content sections, empty states, metadata, comparison, content review flows.          |
| Navigation Patterns                      | [navigation.md](navigation.md)                             | Breadcrumb/page hierarchy, tabs/view navigation, shell navigation, local navigation, current state.        |
| Feedback Patterns                        | [feedback.md](feedback.md)                                 | Inline feedback, loading states, progress, validation summaries, status placement.                         |
| Overlay And Action Patterns              | [overlays-and-actions.md](overlays-and-actions.md)         | Modals, confirmations, destructive flows, action groups, menu/disclosure composition.                      |
| Interaction Patterns                     | [interactions.md](interactions.md)                         | Selection, filtering, search, sorting, disclosure, inline edit, drag/reorder only when approved.           |
| Layout Patterns                          | [layout.md](layout.md)                                     | Page layout, section layout, grids, responsive regions, shell-adjacent composition.                        |
| Notification And Toast Pattern Standards | [notifications-and-toasts.md](notifications-and-toasts.md) | Toast placement, queues, persistence, dismissal, announcement behavior, global notification boundaries.    |

Do not load every Pattern family file unless the task is a full Pattern audit.

## 10. Pattern standard review checklist

For each individual Pattern standard, verify the following before marking the standard complete.

| Area             | Required outcome                                                                                                                                                           |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Ownership        | The Pattern owner route, canonical doc path, source owner, status, and consumed APIs are documented.                                                                       |
| Goal             | The Pattern states the user objective and when the Pattern is appropriate.                                                                                                 |
| Boundary         | The Pattern clearly distinguishes Element, Component, Pattern, page route, and feature/business logic ownership.                                                           |
| Composition      | Required and optional child Components are named with exact routes/API names.                                                                                              |
| Variants/layouts | Supported layout options are documented and visually proved.                                                                                                               |
| States           | State ownership is documented for baseline, loading, empty, error, warning, success, disabled, read-only, open/closed, selection/current, and async states where relevant. |
| Responsive       | Narrow, medium, wide, overflow, stacking, and scroll behavior are documented.                                                                                              |
| Accessibility    | Keyboard, focus, labels, landmarks, live regions, reduced motion, and color-independent meaning are documented.                                                            |
| Content          | Copy rules are concrete and tied to user action/recovery.                                                                                                                  |
| Prohibited usage | Raw utilities, direct Carbon classes, Bootstrap/local classes, raw tokens, fake APIs, local JS, and one-off markup are rejected.                                           |
| Deferred/gated   | Future behavior has explicit gates and approved alternatives.                                                                                                              |
| rendered evidence     | Route proof, live examples, state proof, implementation snippets, and related links exist.                                                                                 |
| Tests            | Route, visible proof, absence, and accessibility-critical assertions exist.                                                                                                |

## 11. rendered evidence validation

Every installed Pattern rendered evidence page must render the approved five-card scaffold:

1. Purpose.
2. Use cases.
3. Pattern contract.
4. Live examples.
5. Related components and patterns.

The Pattern contract card should include:

| Contract section           | Required content                                                                                                                               |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Anatomy                    | Named regions, required child Components, optional child Components, and ownership boundaries.                                                 |
| States                     | Default, loading, empty, error, warning, success, disabled, read-only, open/closed, selected/current, and async states where applicable.       |
| Behavior                   | Workflow sequence, keyboard behavior, pointer behavior, focus behavior, dismissal, persistence, routing, and async ownership where applicable. |
| Developer implementation   | Canonical Blade composition, app classes, data attributes, route owner, source files, and code snippets where known.                           |
| Content guidance           | Headings, labels, helper text, action copy, error copy, empty copy, status copy, and localization/length rules.                                |
| Accessibility requirements | Landmarks, labels, keyboard, focus management, live-region/announcement behavior, reduced motion, and color-independent meaning.               |

Live examples should use the structure that best proves the Pattern:

| Proof structure           | Use for                                                                      |
| ------------------------- | ---------------------------------------------------------------------------- |
| Scenario tabs             | Workflow Patterns with a small number of distinct user scenarios.            |
| Matrices                  | Patterns with many variants, states, densities, alignments, or layout modes. |
| Comparison grids          | Patterns where selection guidance depends on side-by-side alternatives.      |
| State tables              | Patterns with many loading/empty/error/disabled/async states.                |
| Full-width demonstrations | Shell, page layout, table, overlay, or responsive Patterns.                  |
| Internal subsections      | Broad Patterns where grouped proof is clearer than tabs.                     |

## 12. Regression checks

Pattern tests should include absence checks for stale placeholders and prohibited implementation paths where applicable.

Suggested baseline assertions:

```php
$response = $this->actingAs($admin)->get('not installed{slug}');

$response->assertOk();
$response->assertSee('Purpose');
$response->assertSee('Use cases');
$response->assertSee('Pattern contract');
$response->assertSee('Live examples');
$response->assertSee('Related components and patterns');
$response->assertDontSee('Pattern implementation pending');
$response->assertDontSee('Pattern-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('Lorem ipsum');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('btn btn-primary');
```

Add Pattern-specific assertions for consumed Components, state proof, deferred gates, accessibility-critical copy, and prohibited local implementation examples.

## 13. Read guidance

For a narrow implementation or review task:

1. Read this hub.
2. Read [Pattern Boundary And Validation](boundary-and-validation.md) only when boundary ownership or validation is unclear.
3. Read only the pattern-family file tied to the route or composition being changed.
4. Read the Component standards for every Component the Pattern composes.
5. Read the Foundation Element standards for any Element behavior the Pattern consumes directly.

Do not load every Pattern family file unless the task is a full Pattern audit.

## 14. Update workflow

When correcting a Pattern standard:

1. Confirm the Pattern family and canonical doc path.
2. Confirm whether the Pattern is implemented, partial, deferred, gated, or not implemented.
3. Identify consumed Element APIs.
4. Identify owned/composed Component APIs.
5. Define the Pattern API and composition boundary.
6. Define states and responsive behavior.
7. Define accessibility and content contracts.
8. Define prohibited local implementations.
9. Define deferred or gated capabilities.
10. Define rendered evidence proof.
11. Define route and regression tests.
12. Update only the scoped Pattern doc and any directly required child checklist/reference file.

Do not run a broad Pattern-library rewrite during a narrow Pattern task.

## 15. Related

| API                                      | Route or path                                              |
| ---------------------------------------- | ---------------------------------------------------------- |
| Pattern API Standards                    | [index.md](index.md)                                       |
| Pattern Boundary And Validation          | [boundary-and-validation.md](boundary-and-validation.md)   |
| Form Patterns                            | [forms.md](forms.md)                                       |
| Data And Content Patterns                | [data-and-content.md](data-and-content.md)                 |
| Navigation Patterns                      | [navigation.md](navigation.md)                             |
| Feedback Patterns                        | [feedback.md](feedback.md)                                 |
| Overlay And Action Patterns              | [overlays-and-actions.md](overlays-and-actions.md)         |
| Interaction Patterns                     | [interactions.md](interactions.md)                         |
| Layout Patterns                          | [layout.md](layout.md)                                     |
| Notification And Toast Pattern Standards | [notifications-and-toasts.md](notifications-and-toasts.md) |
| Component Implementation Checklist       | [../components/checklist.md](../components/checklist.md)   |
| Component Standards Index                | [../components/index.md](../components/index.md)           |
| Foundation Elements Standards            | [../elements/index.md](../elements/index.md)               |
| UI Standards Index                       | [../index.md](../index.md)                                 |
| UI API Registry                          | [../api-registry.md](../api-registry.md)                   |
| rendered evidence Pattern Library             | `not installed`                          |
| Carbon Patterns overview                 | `https://carbondesignsystem.com/patterns/overview/`        |

## 16. References

- [Pattern API Standards](index.md)
- [Pattern Boundary And Validation](boundary-and-validation.md)
- [Component Implementation Checklist](../components/checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- Carbon Patterns overview is used as the external completeness benchmark for defining Patterns as reusable goal-oriented component/template combinations. Login App keeps its own Pattern API contract, app-owned Component composition, Foundation Element token model, route ownership, rendered evidence proof, and tests.
