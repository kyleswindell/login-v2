---
title: Component Implementation Checklist
slug: component-implementation-checklist
status: implemented
system_maturity: current-standard
api_layer: Component API governance
canonical_doc: docs/02-standards/ui/components/checklist.md
owner_route: not installed
related_element_index: docs/02-standards/ui/elements/index.md
related_component_index: docs/02-standards/ui/components/index.md
related_pattern_index: docs/02-standards/ui/patterns/index.md
---

# Component Implementation Checklist

## API summary

This checklist defines the canonical implementation and documentation gate for Login App 2.0 Component API standards.

Canonical doc: `docs/02-standards/ui/components/checklist.md`. Use this checklist when creating, auditing, correcting, or accepting a Component standard and its rendered evidence proof.

Component standards are installed API contracts. They define what the component is, what is already built, which Blade APIs/classes/helpers/data attributes are public, which variants/options/states exist, how the component consumes Foundation Elements, how it composes with Patterns, what not to do, and what remains deferred or gated.

This checklist is not a generic design guideline and is not a replacement for a component’s own standard. Every component still requires its own canonical doc at:

```text
docs/02-standards/ui/components/{component}.md
```

Do not create canonical component docs under tier folders. Tier language may appear only as priority, hierarchy explanation, historical queue context, or migration note.

## Status and ownership

| Field                   | Value                                            |
| ----------------------- | ------------------------------------------------ |
| Status                  | Implemented                                      |
| System maturity         | Current standard                                 |
| API layer               | Component API governance                         |
| Checklist slug          | component-implementation-checklist               |
| Canonical doc           | `docs/02-standards/ui/components/checklist.md`   |
| Applies to              | `docs/02-standards/ui/components/{component}.md` |
| rendered evidence scope      | `not installed{component}`  |
| Related Element index   | `docs/02-standards/ui/elements/index.md`         |
| Related Component index | `docs/02-standards/ui/components/index.md`       |
| Related Pattern index   | `docs/02-standards/ui/patterns/index.md`         |

This checklist owns Component standard completeness, Component rendered evidence proof expectations, acceptance gates, migration rules, and scope boundaries. It does not own any individual component’s installed API. Each component standard owns its own public API, source files, states, variants, accessibility contract, content contract, prohibited usage, and tests.

## Installed standard

Use this checklist for all Component standards and Component rendered evidence correction work.

Installed Component standard rules:

- Write each Component doc as an implementation API standard, not abstract design commentary.
- Keep each Component standard scoped to one component.
- Define installed APIs explicitly.
- Define deferred and gated APIs explicitly.
- Use app-owned `x-ui.*` Blade APIs and `ui-*` classes where they exist.
- Do not invent a Blade API when the baseline only confirms native markup or app classes.
- Do not collapse variants/options/modifiers to `None` when states, sizes, modes, dispositions, or capabilities actually exist.
- Do not list external system variants as implemented unless Login App implements them.
- Mark uncertain or uninstalled capabilities as `Deferred`, `Gated`, `Not implemented`, `Not owned`, `Pattern-owned`, or `App-approved exception`.
- Require rendered rendered evidence proof for implemented APIs.
- Require deferred APIs to show trigger conditions instead of fake controls.
- Preserve Element, Component, Pattern, and feature-module ownership boundaries.
- Keep feature-owned business rules, permissions, data loading, persistence, and workflow branching out of Component standards.
- Prevent broad “fix all components,” “update all pages,” renderer-wide, scaffold-wide, or family-wide corrections from a single component ticket.

The accepted Component standard section order is fixed. The rendered evidence page must prove the same contract visually through the approved five-card scaffold.

## API layer boundary

Login App 2.0 UI standards are organized into three related API layers.

| API layer              | Owns                                                                                                                                                                                                     | Canonical path                                   |
| ---------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------ |
| Foundation Element API | Tokens and primitives such as Color, Spacing, Typography, 2x Grid, Icons, Motion, Themes, and Pictograms.                                                                                                | `docs/02-standards/ui/elements/{element}.md`     |
| Component API          | Reusable UI primitives and baseline components such as Button, Link, Text input, Select, Checkbox, Radio button, Tag, Loading, Modal, and Data table.                                                    | `docs/02-standards/ui/components/{component}.md` |
| Pattern API            | Reusable compositions and goal-oriented flows built from Elements and Components, such as Forms, Navigation, Layout, Interactions, Table toolbar, Notifications and toasts, and Boundary and validation. | `docs/02-standards/ui/patterns/{pattern}.md`     |

Ownership rule:

```text
Foundation Elements own primitives.
Components own reusable local UI APIs.
Patterns own reusable composition, grouping, orchestration, validation placement, and responsive behavior.
Feature modules own business rules, permissions, data, persistence, and workflow-specific branching.
```

A Component doc must not redefine Element tokens, Pattern layouts, or feature business behavior.

## Required Component section order

Every Component standard must define these sections in this order unless the component has an approved split-file structure.

```md
# {Component Name} Component API Standard

## API summary

## Status and ownership

## Installed standard

## Public API

## Allowed variants, options, and modifiers

## States

## Token, class, and helper usage

## Composition rules

## Selection guidance

## Accessibility contract

## Content contract

## Prohibited usage

## Deferred or gated capabilities

## Rendered evidence requirements

## Testing and acceptance criteria

## Related APIs

## References
```

A Component standard is incomplete if any section is missing, vague, generic, or contradicted by the rendered rendered evidence page.

## Required section expectations

### API summary

The API summary must state the installed UI role and canonical owner route.

Required content:

- one-sentence component purpose;
- canonical rendered evidence owner route;
- instruction to use the Component API instead of local markup, styling, or behavior for the same UI role;
- a short ownership summary for what the component owns and what it does not own.

Example:

```md
Button chooses, confirms, or reveals a user command with explicit action hierarchy.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.
```

### Status and ownership

Every Component doc must include a status table.

Required fields:

| Field                        | Requirement                                                                               |
| ---------------------------- | ----------------------------------------------------------------------------------------- |
| Status                       | One approved status or explicit baseline-required status.                                 |
| System maturity              | Current maturity, such as complete, partial, catalog-only, pattern-owned, or needs audit. |
| API layer                    | Must be `Component API`.                                                                  |
| Component slug               | Must match route and file slug.                                                           |
| Category                     | Component family/category.                                                                |
| Priority                     | Implementation priority or historical tier note.                                          |
| Rendered evidence route           | `not installed{component}`.                                          |
| Canonical doc                | `docs/02-standards/ui/components/{component}.md`.                                         |
| Source owner                 | Blade component, app route, Pattern owner, or implementation owner.                       |
| Blade API                    | Public Blade components, or explicit “none approved”.                                     |
| JavaScript API               | Controller/initializer, or explicit “none approved/none required”.                        |
| Data attributes              | Public behavior attributes, or explicit “none approved”.                                  |
| Source files                 | Known Blade, CSS, JS, route, config, test, or rendered evidence files.                         |
| Foundation Elements consumed | Concrete Element APIs consumed by the component.                                          |

Approved current status values:

| Status                                | Meaning                                                                                          |
| ------------------------------------- | ------------------------------------------------------------------------------------------------ |
| `Implemented`                         | API and rendered evidence proof are installed and accepted.                                           |
| `Implemented - pending manual review` | API/page exists and needs human verification before acceptance.                                  |
| `Implemented Pending Correction`      | API/page exists but docs, examples, or tests require correction before acceptance.               |
| `Partial`                             | Some behavior is installed; missing behavior must be listed as deferred/gated.                   |
| `Deferred`                            | No production API is approved until trigger conditions are met.                                  |
| `Not implemented`                     | No app API exists. Do not fake controls in rendered evidence.                                         |
| `App-approved exception`              | Intentional app-specific divergence or catalog-only disposition. Must document reason and owner. |
| `Pattern-owned`                       | Component catalog entry exists, but production composition/API ownership belongs to a Pattern.   |

Legacy labels such as `Approved API` or `Do not implement` should be migrated unless a supplied baseline explicitly requires them. Use `Implemented Pending Correction`, `Not implemented`, `Deferred`, `App-approved exception`, or `Pattern-owned` instead.

### Installed standard

Define the actual installed Login App 2.0 standard.

This section must answer:

- what the component is the approved API for;
- what it supports today;
- how it is rendered today;
- what it intentionally does not own;
- whether the implementation is complete, partial, deferred, gated, app-specific, or Pattern-owned;
- which nearby Components or Patterns own adjacent responsibilities.

Do not describe only the abstract design concept. Do not imply a public Blade wrapper exists unless the baseline, source file, or rendered evidence context confirms it.

### Public API

Define the actual installed API surface.

Include every applicable API surface:

| API surface        | Required detail                                                                           |
| ------------------ | ----------------------------------------------------------------------------------------- |
| Blade              | Canonical Blade component, helper, include, or explicit “none approved”.                  |
| Markup             | Native semantic element contract when no Blade wrapper is approved.                       |
| Props/options      | Supported props with types, defaults, allowed values, required status, and notes.         |
| Slots              | Named/default slots and allowed content.                                                  |
| Data attributes    | Only documented app-owned `data-ui-*` attributes.                                         |
| JavaScript         | Controller/initializer name, lifecycle, or `No dedicated JavaScript controller required`. |
| CSS namespace      | App-owned classes or namespace, usually `ui-*`.                                           |
| Source files       | Blade, CSS, JS, tests, route, config/data owners when known.                              |
| Item/data contract | Option, menu item, table column, filter item, or list item contract when applicable.      |
| Canonical examples | Real calls or real markup using the installed API.                                        |

Use explicit examples. Do not leave placeholder text such as:

```text
Component-specific API pending correction.
Use only documented props/options.
See rendered evidence developer implementation section.
```

Placeholder examples are allowed only for `Deferred`, `Not implemented`, or catalog-only exception entries, and those docs must state trigger conditions and approved alternatives.

### Allowed variants, options, and modifiers

Document only Login App-approved capabilities.

For each variant, option, size, mode, modifier, disposition, or boundary, include:

| Field    | Requirement                                                                                                                                  |
| -------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| Name     | Developer-facing name.                                                                                                                       |
| Type     | Variant, size, mode, modifier, state, composition, boundary, deferred, gated, not owned, or app-approved exception.                          |
| Status   | Implemented, Implemented Pending Correction, Partial, Deferred, Gated, Not implemented, Not owned, Pattern-owned, or App-approved exception. |
| API      | Prop, class, helper, native attribute, or composition rule.                                                                                  |
| Use      | Selection rule or context.                                                                                                                   |
| Boundary | Do-not-use or ownership rule when needed.                                                                                                    |

Do not document Carbon or external-system variants as implemented unless Login App implements them. Mark them as deferred/gated/not owned when they are useful comparison points.

### States

List every applicable state and how the installed API represents it.

Typical state checklist:

- Default.
- Hover-capable.
- Focus-visible.
- Active/pressed.
- Selected/unselected, checked/unchecked, expanded/collapsed, open/closed, current, sortable/sorted, or active/inactive when applicable.
- Disabled.
- Read-only when applicable.
- Loading/pending when applicable.
- Error, warning, success, and informational states when applicable.
- Empty/no-results/unavailable when applicable.
- Overflow/truncated when applicable.
- Reduced-motion when applicable.
- Not applicable states explicitly marked.

State rows must explain implementation ownership. Examples:

- `Implemented`: represented through the installed Component API and token-backed classes.
- `Pattern-owned`: placed or orchestrated by a Pattern.
- `Not owned`: use another Component or Pattern.
- `Not applicable`: the state does not apply to the component role.

Do not create state-only local CSS outside the installed API.

### Token, class, and helper usage

List the Foundation Element APIs consumed by the component.

Baseline Element APIs:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons, when applicable.
- Motion, when applicable.
- 2x Grid, when applicable.
- Pictograms, when applicable.

This section must also define:

- allowed token roles;
- allowed `ui-*` class families;
- allowed Blade helpers/wrappers;
- allowed native attributes;
- approved icon source, if applicable;
- approved motion/reduced-motion roles, if applicable;
- prohibited local substitutions.

Components must consume Foundation Elements through documented tokens, utilities, helpers, wrappers, or component classes. They must not hard-code alternate local values for the same role.

### Composition rules

Define how the component may be composed and where ownership boundaries exist.

Include, when applicable:

- click/tap behavior;
- keyboard behavior;
- focus behavior;
- validation behavior;
- loading behavior;
- dismissal behavior;
- responsive behavior;
- stacking and overflow behavior;
- persistence behavior;
- grouping behavior;
- child/parent ownership boundaries;
- Pattern ownership boundaries.

Required ownership line:

```text
Components own internal semantics, state, and styling. Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.
```

For Pattern-owned component dispositions, replace or extend this with the actual Pattern owner.

### Selection guidance

Include concrete `Use when` and `Do not use when` guidance.

This section must help developers choose between nearby APIs. Examples:

- Button vs Link vs Menu buttons.
- Checkbox vs Radio button vs Toggle.
- Text input vs Number input vs Select.
- Dropdown/Menu buttons vs Select.
- Tooltip vs Toggletip vs Popover.
- Modal vs Popover vs page flow.
- Breadcrumb vs Progress indicator vs Tabs.
- Loading vs Inline loading vs Progress indicator.
- Tag vs Notification vs Button.
- UI shell vs Page header vs Navigation Pattern.

Use selection tables when adjacent API boundaries are likely to cause mistakes.

### Accessibility contract

Document concrete accessibility requirements for the installed API.

Include, when applicable:

- native semantic element requirements;
- keyboard support;
- focus-visible behavior;
- focus management;
- accessible names and labels;
- ARIA requirements only where native semantics are not enough;
- non-color meaning;
- contrast;
- reduced motion;
- current/selected/expanded/checked/open state synchronization;
- disabled/read-only handling;
- error/helper/status association;
- hit target expectations;
- live-region or status announcement behavior;
- screen-reader behavior for icons/decorative content.

Do not use generic accessibility text alone. For implemented components, the accessibility contract must be component-specific.

### Content contract

Define writing and content requirements.

Include, when applicable:

- label style;
- title/message structure;
- button label rules;
- placeholder/helper text rules;
- empty/error copy rules;
- status/severity wording;
- destructive action wording;
- truncation/wrapping rules;
- icon-only label rules;
- required/optional wording;
- recovery action wording.

Content rules must be specific enough for rendered evidence examples and tests to validate.

### Prohibited usage

List direct prohibitions.

Every Component standard must include this baseline prohibition:

```text
Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
```

Then add component-specific prohibitions.

Every implemented Component standard should also prohibit, when relevant:

- direct Carbon production classes such as `cds--*` or `bx--*`;
- Bootstrap classes as app-owned API;
- feature-local `*-*` class families for the same role;
- placeholder rendered evidence copy;
- fake controls for deferred APIs;
- hard-coded colors, arbitrary spacing, local icons, custom focus rings, and local motion.

### Deferred or gated capabilities

Document uninstalled, deferred, gated, not-owned, or prohibited capabilities.

Use a table when there is more than one capability:

| Capability         | Status   | Gate or trigger condition                                                                  | Local workaround allowed? |
| ------------------ | -------- | ------------------------------------------------------------------------------------------ | ------------------------- |
| Example capability | Deferred | Product need, Component API contract, accessibility review, rendered evidence proof, and tests. | No.                       |

Deferred capabilities must include trigger conditions and prohibited local workarounds.

If no deferred capabilities exist, use:

```md
No known deferred capability for the installed API. Future extensions require an updated Component standard and rendered evidence proof.
```

### Rendered evidence requirements

Every Component standard must define exactly what the live rendered evidence page must prove.

The rendered evidence page must render the approved five-card scaffold:

1. Purpose.
2. Use cases.
3. Component contract.
4. Live examples.
5. Related components and patterns.

The `Live examples` card may use the layout that best represents the component:

- tabs;
- matrices;
- comparison grids;
- state tables;
- size scales;
- grouped examples;
- full-width sections;
- scenario cards;
- region maps;
- implementation examples.

Do not force broad components into the Accordion tab model. Use tabs for scenario-driven components. Use matrices/scales/grids/sections for broad components.

Every Rendered evidence requirements section must include a table:

| Required proof | Rendered behavior                | Variants/options shown                                    |
| -------------- | -------------------------------- | --------------------------------------------------------- |
| Example name   | Exact behavior that must render. | Exact variants, states, sizes, modes, or modifiers shown. |

Implemented APIs must render production examples. Deferred APIs must render trigger conditions instead of fake controls. The page must not display generic fallback/reference sections or placeholder developer comments for implemented APIs.

### Testing and acceptance criteria

Every implemented Component standard must include route, rendering, content, API, state, accessibility, and regression assertions.

Required baseline:

- `not installed{component}` returns 200 for authorized users.
- The page shows installed API, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Implemented APIs render production examples.
- Deferred APIs render trigger conditions instead of fake controls.
- The five-card scaffold renders in top-level order.
- Generic fallback content is absent for implemented components.
- Canonical docs use `docs/02-standards/ui/components/{component}.md`, not deprecated tier paths.
- Tests assert absence of stale placeholder labels and unsupported implementation classes.

Recommended generic regression strings:

```php
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

Component-specific assertions must be added for:

- canonical Blade/API names;
- required live examples;
- required variants/options/sizes/modifiers;
- required states;
- required accessibility behavior;
- prohibited usage;
- nearby API boundaries;
- deferred or gated capabilities.

### Related APIs

List concrete app Rendered evidence routes, not vague references.

Use related links to prevent boundary mistakes.

Example:

| API           | Route                                      |
| ------------- | ------------------------------------------ |
| Button        | `not installed` |
| Link          | `not installed`   |
| Form patterns | `not installed`    |
| Color element | `not installed`    |

Include the owning Pattern for Pattern-owned subjects and the most likely alternate Components.

### References

Include internal documentation references and, where useful, external design-system pages as benchmarks only.

Required internal references:

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)

When Carbon or another external source is relevant, cite it as a completeness benchmark in prose. Do not copy external text into Login App standards. Do not use direct Carbon production class names in examples.

## Status and disposition rules

Use these statuses unless the supplied baseline explicitly requires another value.

| Status                                | Use when                                                                        | Required doc behavior                                                                                |
| ------------------------------------- | ------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------- |
| `Implemented`                         | API and rendered evidence examples are accepted.                                     | Document full public API, states, variants/options, source ownership, rendered evidence proof, and tests. |
| `Implemented - pending manual review` | API/page exists but still needs human verification.                             | Document full expected API and identify manual review points.                                        |
| `Implemented Pending Correction`      | API/page exists but standard, examples, or tests are not yet accepted.          | Document installed target API and exact correction/proof requirements.                               |
| `Partial`                             | Some API exists but not enough for full acceptance.                             | Separate implemented, deferred, gated, and not-owned behavior clearly.                               |
| `Deferred`                            | Component appears in queue/catalog but no production API is approved.           | State no public API is approved; provide trigger conditions and alternatives; no fake controls.      |
| `Not implemented`                     | No app API exists.                                                              | Provide prohibited local workaround rules and alternatives.                                          |
| `App-approved exception`              | App intentionally diverges or keeps catalog-only disposition.                   | Document why, owner, allowed usage, approved alternative, and future gate.                           |
| `Pattern-owned`                       | Component catalog entry exists but production composition belongs to a Pattern. | Link owning Pattern; do not invent primitive API; require rendered evidence disposition proof.            |

Do not use old or ambiguous statuses such as `Approved API` for current correction work unless specifically required by a legacy migration note.

## Foundation Element consumption checklist

Every Component standard must name and constrain the Foundation Elements it consumes.

| Element    | Required review                                                                                          |
| ---------- | -------------------------------------------------------------------------------------------------------- |
| Color      | Semantic colors, text, borders, surfaces, status, disabled, focus, hover, active, and theme behavior.    |
| Spacing    | Internal padding/gaps only; parent Patterns own external spacing unless component grouping is installed. |
| Typography | Labels, headings, helper text, body text, code, truncation/wrapping, and responsive type behavior.       |
| Themes     | Light, dark, inverse, layered, and high-contrast behavior where supported.                               |
| Icons      | Approved icon source, size, position, accessible/decorative status, and prohibited local icon sources.   |
| Motion     | Transitions, open/close, loading, reduced-motion behavior, and prohibited one-off timing.                |
| 2x Grid    | Layout zones only when the component owns layout; most page placement remains Pattern-owned.             |
| Pictograms | Large illustrative assets only; do not use as UI icons or logos.                                         |

Components must not define raw token values, raw hex colors, arbitrary spacing values, local icon imports, local focus rings, or custom motion timings.

## rendered evidence validation

Every implemented Component must be represented at:

```text
not installed{component}
```

The rendered evidence page is the rendered proof of the Component API standard. It may use Carbon-like page organization and live examples, but it must prove the installed Login App API.

### Required top-level cards

| Card                            | Required content                                                                                                                                 |
| ------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Purpose                         | Component name, purpose, status, category, source ownership, canonical doc.                                                                      |
| Use cases                       | Use when and do not use when, preferably split 50/50.                                                                                            |
| Component contract              | Anatomy, public API, states, behavior, developer implementation, content guidance, accessibility requirements, and Foundation Elements consumed. |
| Live examples                   | Production examples proving required scenarios, variants/options, sizes, states, and contextual usage.                                           |
| Related components and patterns | Nearby alternatives, commonly composed Components, and Patterns that own higher-level behavior.                                                  |

### Live examples layout rule

Live examples do not have to use one layout everywhere.

| Component type                                                                                                                    | Recommended live-example layout                                                                                            |
| --------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Scenario-driven components such as Accordion, Modal, Popover, or complex disclosure                                               | Tabs, scenario cards, or grouped examples.                                                                                 |
| Broad components such as Button, Tag, Link, Checkbox, Radio button, Toggle, Text input, Select, Loading, Menu buttons, Data table | Matrices, state tables, comparison grids, size scales, grouped sections, and implementation examples.                      |
| Shell/navigation components such as UI shell, Breadcrumb, Tabs, Navigation-owned subjects                                         | Region maps, current-state matrices, responsive examples, keyboard/focus proof.                                            |
| Input components such as Text input, Number input, Select, Checkbox, Radio button                                                 | Field examples, validation matrices, disabled/read-only examples, accessibility proof, related-control selection guidance. |
| Feedback components such as Notification, Loading, Inline loading, Tag                                                            | Family/status matrices, boundary examples, motion/reduced-motion proof, content examples.                                  |

### Generic fallback ban

Implemented Component pages must not render generic fallback content such as:

- `Component-specific API pending correction.`
- `Use only documented props/options.` without listing props/options.
- `See rendered evidence developer implementation section.` without defining the API in the standard.
- `Allowed variants: None` when any variants, modes, states, dispositions, or options exist.
- one-sentence state badges without a state contract.
- placeholder developer comments instead of canonical calls.
- fake controls for deferred APIs.
- raw screenshot-only examples instead of live app CSS/JS examples.

## Component implementation acceptance gate

A component is not accepted until all applicable gates pass.

| Gate                  | Requirement                                                                                                      |
| --------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Documentation gate    | Component standard exists at the canonical path and includes every required section.                             |
| API gate              | Public API is explicitly documented and implemented or explicitly deferred.                                      |
| Token gate            | Component consumes approved Foundation Elements and does not introduce local replacements.                       |
| Variant/options gate  | Variants, modes, sizes, modifiers, dispositions, and options are documented or explicitly marked non-applicable. |
| State gate            | States are documented and rendered where applicable.                                                             |
| Accessibility gate    | Component-specific accessibility contract is documented and testable.                                            |
| Content gate          | Labels, helper text, errors, statuses, destructive copy, truncation/wrapping, and action wording are documented. |
| Prohibited-usage gate | Local markup, local CSS, raw tokens, direct external classes, fake APIs, and one-off JS are prohibited.          |
| Deferred gate         | Deferred/gated/not-owned capabilities have trigger conditions and no local workaround.                           |
| rendered evidence gate     | Five-card scaffold renders at the component route.                                                               |
| Live example gate     | Required production examples render with app CSS/JS.                                                             |
| Related API gate      | Nearby alternatives and Pattern ownership are linked.                                                            |
| Test gate             | Route, content, API, state, accessibility, and regression assertions exist.                                      |
| Migration gate        | No deprecated tier path is treated as canonical.                                                                 |

## Component test checklist

Use these checks as the default feature/test coverage for implemented component pages.

```php
$response = $this->actingAs($admin)->get('not installed{component}');

$response->assertOk();
$response->assertSee('Purpose');
$response->assertSee('Use cases');
$response->assertSee('Component contract');
$response->assertSee('Live examples');
$response->assertSee('Related components and patterns');
$response->assertSee('Foundation Elements');
$response->assertSee('Prohibited usage');
$response->assertSee('Deferred or gated');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('docs/02-standards/ui/components/tier-1/');
$response->assertDontSee('docs/02-standards/ui/components/tier-2/');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

Each component must add component-specific assertions for:

- canonical Blade/API names or native markup API;
- public props/options/slots/data attributes;
- required live examples;
- required variants/options/sizes/modes/modifiers;
- required states;
- accessibility behavior;
- content behavior;
- prohibited local/external classes;
- nearby API boundaries;
- deferred or gated capabilities.

## Deferred component rules

Deferred components must still have a standard if they appear in the rendered evidence library, queue, or standards index.

A deferred Component page must show:

- exact product trigger condition;
- required API design work before implementation;
- required accessibility review before implementation;
- required source ownership decision;
- related installed alternative APIs;
- prohibited local workarounds;
- no fake implemented controls.

Recommended deferred language:

```md
This API is deferred. Do not build local feature-specific versions. Implementation requires a product-approved use case, canonical Component API, accessibility contract, rendered evidence proof, and test coverage.
```

## Pattern-owned component disposition rules

Some app UI subjects have Component catalog pages but Pattern-owned production behavior.

When a subject is Pattern-owned:

- the Component doc must state the disposition clearly;
- the Component rendered evidence page must link to the owning Pattern;
- the doc must not invent a primitive Blade API;
- the rendered evidence page must show disposition proof, approved alternatives, and deferred gates;
- the Pattern doc must own workflow, composition, responsive behavior, and state orchestration;
- child Components used inside the Pattern must still link back to their Component API standards.

Examples that may require Pattern ownership or disposition review:

- Form.
- UI shell.
- Table toolbar compositions.
- Overlay/action compositions.
- Navigation/header compositions.

## App-specific exception rules

Use `App-approved exception` or `App-specific exception` only when the app intentionally preserves a catalog entry or divergence from a generic design-system model.

An exception doc must include:

- why the exception exists;
- who owns the production behavior today;
- what developers should use instead;
- what is explicitly not installed;
- what future gate would be required to install the missing API;
- rendered evidence proof that renders the exception/disposition rather than fake controls.

## Required docs migration rules

The approved component docs path is:

```text
docs/02-standards/ui/components/{component}.md
```

Deprecated paths must not be used as canonical docs:

```text
docs/02-standards/ui/components/tier-1/{component}.md
docs/02-standards/ui/components/tier-2/{component}.md
docs/02-standards/ui/components/tier-a/{component}.md
docs/02-standards/ui/components/tier-b/{component}.md
```

Migration acceptance:

- rendered evidence pages link to the new canonical path.
- Component docs link to sibling component docs using the new flat path unless a heavy component has an approved folder.
- Queue items may mention historical tiers only as priority/context, not as canonical folder structure.
- Tests fail if implemented component pages link to deprecated canonical paths.
- New component docs must not be generated into tier folders.

## Split rule

Keep each Component standard as one flat file by default.

Use child files only after one specific component standard becomes too large to review as one file.

Approved folder pattern for heavy components:

```text
docs/02-standards/ui/components/{component}/
  index.md
  api.md
  variants.md
  states.md
  tokens.md
  composition.md
  accessibility.md
  content.md
  prohibited-usage.md
  deferred.md
  ui-reference.md
  tests.md
  related.md
```

When a component is split, `index.md` must remain the hub and include:

- API summary;
- status and ownership;
- documentation map;
- Rendered evidence requirements summary;
- scope boundary;
- links to child files.

Do not split a component only because it has a few tables. Split only when reviewability is meaningfully improved.

## Per-component scope boundary rule

Every component correction item must include a scope boundary.

Template:

```text
Scope boundary: This ticket updates only the {Component name} rendered evidence page, {Component name} Component API, {Component name} canonical docs/config/examples, and {Component name}-specific tests. Do not use this ticket as a broad scaffold, renderer, family-wide, or all-component correction. If another component page needs the same layout or behavior adjustment, create or update that component’s own queue item with its own explicit requirements.
```

This rule prevents broad queue items from missing page-specific requirements.

## Component correction audit checklist

Use this checklist before accepting a corrected Component standard.

| Audit item        | Passing condition                                                                               |
| ----------------- | ----------------------------------------------------------------------------------------------- |
| Canonical path    | Doc is at `docs/02-standards/ui/components/{component}.md`.                                     |
| Required sections | All required Component sections appear in the correct order.                                    |
| Status language   | Status uses current approved wording.                                                           |
| Installed API     | Installed, deferred, gated, not-owned, and Pattern-owned behavior is separated clearly.         |
| Public API        | Blade/native markup, props, slots, classes, data attributes, JS, and source files are explicit. |
| Variants/options  | Every option, variant, size, mode, and modifier is documented or marked non-applicable.         |
| States            | Applicable and non-applicable states are classified.                                            |
| Elements          | Consumed Foundation Elements and token roles are listed.                                        |
| Composition       | Component vs Pattern vs feature ownership is clear.                                             |
| Selection         | Nearby API boundaries are concrete.                                                             |
| Accessibility     | Requirements are component-specific, not generic.                                               |
| Content           | Labels, helper/status/error/action copy, wrapping, truncation, and recovery rules are defined.  |
| Prohibited usage  | Local markup/classes/tokens/JS and direct external classes are prohibited.                      |
| Deferred gates    | Future capabilities have trigger conditions and no local workaround.                            |
| rendered evidence      | Five-card scaffold and required live proof table are specified.                                 |
| Tests             | Route, scaffold, API, state, accessibility, content, and regression assertions are included.    |
| Related APIs      | Concrete app routes are listed.                                                                 |
| References        | Internal indexes and relevant benchmarks are included.                                          |

## Related APIs

| API                             | Route                                        |
| ------------------------------- | -------------------------------------------- |
| Component Standards Index       | `docs/02-standards/ui/components/index.md`   |
| Foundation Elements Standards   | `docs/02-standards/ui/elements/index.md`     |
| Pattern Standards Index         | `docs/02-standards/ui/patterns/index.md`     |
| Pattern Library Checklist       | `docs/02-standards/ui/patterns/checklist.md` |
| UI API Registry                 | `docs/02-standards/ui/api-registry.md`       |
| Button                          | `not installed`   |
| Form patterns                   | `not installed`      |
| Boundary and validation pattern | `not installed`            |

## References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Pattern Library Checklist](../patterns/checklist.md)
- [UI API Registry](../api-registry.md)