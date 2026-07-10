---
title: Carbon Package Overview
slug: carbon-package-overview
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main/packages
---

# Carbon Package Overview

## Snapshot

Current local reference checkout:

| Area                                                   | Count |
| ------------------------------------------------------ | ----: |
| Carbon packages under `reference/carbon-main/packages` |    27 |
| React component directories                            |   126 |
| Styles SCSS component directories                      |    71 |
| Web Component directories                              |    85 |
| Carbon icon SVG files                                  |  2767 |
| Local exported UI icon SVG files                       |  2767 |

The current Login App UI build primarily used `react` for Blade component
anatomy and behavior naming, and `styles` for component CSS and primitive style
ownership.

## Package Groups

| Group                              | Packages                                                                                                                                                | Local relevance                                                                              |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| Primary component sources          | `react`, `styles`                                                                                                                                       | Used for Blade component naming/anatomy and component CSS ownership.                         |
| Primitive/style owners             | `colors`, `themes`, `type`, `layout`, `motion`, `grid`, `icons`, `elements`                                                                             | Used to reason about token, type, base, layout, color, and icon ownership.                   |
| Duplicated implementation families | `web-components`, `icons-react`, `icons-vue`, `pictograms-react`, deprecated `carbon-components`, deprecated `carbon-components-react`                  | Useful for cross-checking concepts, but not primary sources for the current Blade/CSS build. |
| Assets and visual libraries        | `icons`, `pictograms`                                                                                                                                   | Icons appear exported locally; pictograms are not part of the current component inventory.   |
| Tooling and support                | `cli`, `cli-reporter`, `feature-flags`, `icon-build-helpers`, `icon-helpers`, `scss-generator`, `test-utils`, `upgrade`, `utilities`, `utilities-react` | Reference/tooling only unless a later workflow needs migration or generation behavior.       |

## Primary Sources Used Now

| Carbon package   | Relevant path                                                                  | Current local use                                                           |
| ---------------- | ------------------------------------------------------------------------------ | --------------------------------------------------------------------------- |
| `react`          | `reference/carbon-main/packages/react/src/components`                          | Source-name benchmark for Blade component inventory and behavior ownership. |
| `styles`         | `reference/carbon-main/packages/styles/scss/components`                        | Source-name benchmark for component CSS inventory.                          |
| `colors`         | `reference/carbon-main/packages/colors`                                        | Primitive color provenance for local palette tokens.                        |
| `themes`         | `reference/carbon-main/packages/themes`                                        | Theme role provenance for local theme tokens.                               |
| `type`           | `reference/carbon-main/packages/type`                                          | Type token/style provenance for local type CSS.                             |
| `layout`, `grid` | `reference/carbon-main/packages/layout`, `reference/carbon-main/packages/grid` | Layout, spacing, grid, and responsive primitive provenance.                 |
| `motion`         | `reference/carbon-main/packages/motion`                                        | Motion duration/easing provenance.                                          |
| `icons`          | `reference/carbon-main/packages/icons`                                         | Local icon SVG export source.                                               |

## Duplicated Examples And Non-Primary Sources

`web-components` contains component implementations for another runtime model.
It is useful for behavior comparison when React is ambiguous, but it should not
override React/source-style mappings for current Blade components.

`icons-react` and `icons-vue` are framework wrappers around icon assets. They
are duplicate implementation surfaces for icons, not additional UI component
sources for Blade components.

`carbon-components` and `carbon-components-react` are deprecated package
surfaces in this checkout. Treat them as historical compatibility references
only.

## Filename-Level Missing Candidates

These Carbon React names appear potentially relevant by filename but are not
clear direct top-level local Blade components in the current canonical direct
component list. This is not a required-work list; it is a later rendered evidence
review checklist.

| Carbon React candidate                                              | Why it may matter later                                                                        |
| ------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| `AspectRatio`                                                       | Current CSS moved aspect-ratio ownership to base; no direct Blade component is mapped.         |
| `AISkeleton`, `SkeletonIcon`, `SkeletonPlaceholder`, `SkeletonText` | Local skeleton files exist by component, but no generic skeleton component map is established. |
| `ContextMenu`, `Disclosure`, `ExpandableSearch`                     | May overlap with menu, popover, search, or disclosure behavior.                                |
| `FlexGrid`, `Grid`, `HideAtBreakpoint`                              | May overlap with local base grid and responsive visibility primitives.                         |
| `Heading`, `Text`, `OrderedList`, `UnorderedList`, `ListItem`       | May overlap with type/list primitives rather than dedicated Blade components.                  |
| `Layer`, `Layout`, `LayoutDirection`, `Theme`                       | May overlap with token/base/theme primitives.                                                  |
| `Portal`                                                            | May matter for overlay review, but current Blade implementation does not map it directly.      |
| `RadioTile`, `TileGroup`                                            | May matter for future selectable tile review.                                                  |
| `TimePickerSelect`, `FluidTimePickerSelect`                         | May matter if time picker subcontrols are added later.                                         |

## Source-Depth Rule

Use this overview for package ownership and filename relation only. Review
actual Carbon source code later only when visual/API review needs to resolve a
specific anatomy, state, accessibility, or behavior question.
