---
title: Content switcher
slug: content-switcher
api_layer: Component API
status: implemented-pending-manual-review
system_maturity: partial
category: navigation-and-disclosure
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/content-switcher.md
source_owner: resources/views/components/ui/content-switcher/index.blade.php
blade_api:
  - x-ui.content-switcher
javascript_api:
  - initContentSwitchers exported from resources/js/ui-controls/content-switchers.js
data_attributes:
  - data-ui-content-switcher
  - data-ui-content-switcher-list
  - data-ui-content-switcher-option
  - data-ui-content-switcher-panel
source_files:
  - resources/views/components/ui/content-switcher/index.blade.php
  - resources/js/ui-controls/content-switchers.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - tabs
  - radio-button
  - toggle
  - button
related_patterns:
  - navigation
  - forms
carbon_reference:
  - https://carbondesignsystem.com/components/content-switcher/usage/
  - https://carbondesignsystem.com/components/content-switcher/style/
---

# Content switcher Component API Standard

## API Summary

Content switcher switches compact peer views inside the same workflow region without implying primary navigation, form selection, or task progress.

Canonical API owner: `resources/views/components/ui/content-switcher/index.blade.php`. Use `x-ui.content-switcher` instead of local segmented-control markup.

Content switcher owns compact peer-view option groups, selected/unselected state, disabled options, optional icons, optional panel switching, focus treatment, keyboard behavior, and its component token aliases. It does not own route navigation, command actions, workflow progress, or form value submission.

## Status And Ownership

| Field | Value |
| --- | --- |
| Status | Implemented - pending manual review |
| API layer | Component API |
| Component slug | `content-switcher` |
| Category | Navigation and disclosure |
| Priority | Tier B - Common reusable component |
| Rendered evidence route | `not installed` |
| Canonical doc | `docs/02-standards/ui/components/content-switcher.md` |
| Source owner | `resources/views/components/ui/content-switcher/index.blade.php` |
| Blade API | `x-ui.content-switcher` |
| JavaScript API | `initContentSwitchers` from `resources/js/ui-controls/content-switchers.js` |
| Source files | `resources/views/components/ui/content-switcher/index.blade.php`; `resources/js/ui-controls/content-switchers.js`; `resources/css/app.css` |

## Public API

Canonical call:

```blade
<x-ui.content-switcher
    label="View mode"
    :options="$options"
    value="summary"
/>
```

Options are arrays with `label`, `value`, optional `id`, optional `panel_id`, optional `selected`, optional `disabled`, optional `icon`, optional `icon_only`, optional `panel_title`, and optional `panel`.

Approved props:

| Prop | Type | Default | Purpose |
| --- | --- | --- | --- |
| `options` | array | `[]` | Switcher options and optional panel content. |
| `value` | string/null | `null` | Selected option value. Falls back to the first option marked `selected`, then first enabled option. |
| `label` | string | `Content switcher` | Accessible tablist label. |
| `size` | `sm`, `md` | `md` | Compact or default option height. |
| `show-panels` | bool | `true` | Render and switch local panels. Set false only when a nearby parent owns the switched region. |

## Allowed Variants, Options, And Modifiers

- Default text options.
- Small/compact size.
- Icon with label.
- Disabled option.
- Local panel switching.
- No-panel mode when a nearby parent component or Pattern owns the switched content region.

Icon-only options remain gated until Tooltip ownership and accessible name requirements are added to the component standard and rendered evidence proof.

## States

- Default.
- Hover.
- Focus-visible.
- Selected.
- Disabled.

Selected state must be represented through `aria-selected="true"` and token-backed visual treatment. Disabled options must not receive focus or change the selected panel.

## Token, Class, And Helper Usage

Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Motion

Allowed CSS namespace:

- `ui-content-switcher`
- `ui-content-switcher-list`
- `ui-content-switcher-option`
- `ui-content-switcher-icon`
- `ui-content-switcher-panels`
- `ui-content-switcher-panel`

Component token aliases:

- `--ui-content-switcher-background`
- `--ui-content-switcher-background-hover`
- `--ui-content-switcher-background-disabled`
- `--ui-content-switcher-selected`
- `--ui-content-switcher-border`
- `--ui-content-switcher-divider`
- `--ui-content-switcher-selected-border`
- `--ui-content-switcher-text`
- `--ui-content-switcher-text-hover`
- `--ui-content-switcher-selected-text`

These aliases map to the app-owned Color Element roles. Do not use direct Carbon class names or raw color utilities.

## Composition Rules

- Use two or three options by default.
- Keep labels short and noun-based.
- Use Content switcher for compact peer views where Tabs would be too visually heavy.
- Use Tabs when panels need heavier content hierarchy, scrollable tablists, dismissible tabs, manual activation, or vertical layout.
- Use Radio button or Select for form values.
- Use Toggle for immediate binary settings.
- Use Button or Menu buttons for commands.
- Use Progress indicator for sequential tasks.

## Accessibility Contract

- Root emits `data-ui-component="content-switcher"` and `data-ui-content-switcher`.
- The option list uses `role="tablist"` and receives an accessible label.
- Options use `role="tab"`, `aria-selected`, `aria-controls`, and roving `tabindex`.
- Panels use `role="tabpanel"` and `aria-labelledby`.
- Arrow keys, Home, and End move across enabled options.
- Enter and Space select the focused option.
- Disabled options are skipped by keyboard navigation.

## Content Contract

- Use sentence case.
- Prefer short nouns: Summary, Activity, Settings, Open, Closed.
- Do not use command labels such as Save, Create, Delete, or Export.
- Do not use vague labels such as View 1 or Option A.

## Prohibited Usage

- Do not build local segmented controls with raw buttons.
- Do not use Content switcher for primary route navigation.
- Do not use Content switcher for form value submission.
- Do not use Content switcher for commands.
- Do not wrap Content switcher options into a Button group.
- Do not replace Tabs when tab semantics, overflow, vertical layout, or richer panel hierarchy is required.

## Deferred Or Gated Capabilities

- Icon-only switcher options.
- More than three options.
- Vertical content switcher.
- URL/hash persistence.
- Remote-loaded panels.

## Implementation And Rendered Evidence Checklist

| Requirement | Standard expectation |
| --- | --- |
| Public API/source | `x-ui.content-switcher`, `initContentSwitchers`, `ui-content-switcher*`, and `data-ui-content-switcher*` are installed. |
| Variants/options/modifiers | Default, compact, icon with label, disabled, local panel, and no-panel mode are represented. |
| States | Default, hover, focus-visible, selected, and disabled are token-backed. |
| Accessibility/content | Tablist semantics, roving focus, panel relationships, concise labels, and disabled behavior are present. |
| Element consumption | Color, Spacing, Typography, Themes, and Motion are consumed through app-owned roles. |
| Tests | Source/API assertions and Rendered evidence route assertions block deferred fallback content. |

## Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

Required live examples:

- Peer view switcher.
- Icon view switcher.
- Toolbar/no-panel mode.
- Default, compact, disabled, selected, and icon-with-label variants.
- Developer implementation snippet using `x-ui.content-switcher`.

## Testing And Acceptance Criteria

- `not installed` returns 200 for authorized users.
- The page renders `x-ui.content-switcher` examples instead of deferred trigger-condition placeholders.
- Rendered output includes `data-ui-component="content-switcher"`, `data-ui-content-switcher`, `data-ui-content-switcher-option`, and `data-ui-content-switcher-panel`.
- Source assertions verify `initContentSwitchers` is exported and registered in `resources/js/app.js`.
- CSS assertions verify `ui-content-switcher*` classes and component token aliases.

## Related APIs

| API | Route |
| --- | --- |
| Tabs | `not installed` |
| Radio button | `not installed` |
| Toggle | `not installed` |
| Button | `not installed` |
| Navigation Pattern | `not installed` |

## References

- [Component Standards Index](index.md)
- [UI API Registry](../api-registry.md)
- [Foundation Elements Standards](../elements/index.md)
