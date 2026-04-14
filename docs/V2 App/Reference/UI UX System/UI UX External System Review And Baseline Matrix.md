# UI UX External System Review And Baseline Matrix

## Purpose

Translate Material and Carbon guidance into actionable Login V2 decisions, implementation requirements, and consistency rules.

## Review Scope

Reviewed external systems:

- Material design guidance (`m2.material.io` request scope, with static archive references where JS extraction is unavailable)
- IBM Carbon Design System guidance (elements, tokens, accessibility, enterprise patterns)

## Review Findings

### Foundational alignment

Both systems strongly align on:

1. tokenized design systems over hard-coded values
2. explicit light/dark theming models
3. consistent spacing grids and typography scales
4. accessible contrast/focus/interaction defaults
5. predictable component behaviors

### Strategic synthesis for Login V2

Recommended synthesis:

1. adopt Carbon-style token governance and theme/layer model rigor
2. adopt Material responsive structure and motion clarity patterns
3. keep Login V2 visual identity custom (not vendor look-alike)

## Required Decisions Matrix

### 1. Design Principles

#### Spacing scale

Decision needed:

- lock 8px base with explicit token ladder and allowed exceptions

Implementation requirement:

- all component spacing must consume tokens only

#### Typography hierarchy

Decision needed:

- lock primary and fallback font stacks, type scale, role mapping, and language fallback rules

Implementation requirement:

- map each UI text role to exactly one tokenized style

#### Elevation and layering

Decision needed:

- lock surface layer stack and shadow tokens for light and dark themes

Implementation requirement:

- overlays and panels must use locked layer roles; no ad hoc shadows

#### Interaction states

Decision needed:

- lock hover, focus, active, selected, disabled, and loading semantics

Implementation requirement:

- each interactive component must expose all required states

#### Accessibility standards

Decision needed:

- lock WCAG target and test method for contrast, keyboard, and motion sensitivity

Implementation requirement:

- every component acceptance test includes accessibility checks

### 2. Component Behavior

#### Drawers and panels

Decision needed:

- lock when to use drawer vs side panel vs modal vs full page

Implementation requirement:

- focus return, escape behavior, and body scroll lock must be consistent

#### Tables

Decision needed:

- lock default sorting/filtering/search/pagination behavior

Implementation requirement:

- all data tables follow shared toolbar + pagination + batch action rules

#### Forms

Decision needed:

- lock validation timing and error presentation model

Implementation requirement:

- inline errors and summary behavior must be standardized

#### Empty states

Decision needed:

- lock required content structure and action hierarchy

Implementation requirement:

- empty states must always provide a next action

### 3. UX Consistency Rules

#### Navigation hierarchy

Decision needed:

- lock global/section/context navigation structure

Implementation requirement:

- every route maps to one defined navigation level

#### Action placement

Decision needed:

- lock primary/secondary/destructive action locations by page type

Implementation requirement:

- page templates enforce standard action zones

#### Destructive patterns

Decision needed:

- lock warning copy and confirmation thresholds

Implementation requirement:

- high-impact destructive actions require explicit confirmation

#### Feedback timing

Decision needed:

- lock toast duration, loader threshold, and completion messaging rules

Implementation requirement:

- async operations must show standard pending/success/error feedback

## High-Level Baseline To Lock First

1. Semantic color token model and theme maps
2. Typography and spacing scales
3. State tokens and accessibility gates
4. Navigation and action hierarchy
5. Core behavior patterns (table/form/overlay/toast)
6. Component inventory coverage in `/platform/ui-reference`

## Current Locked Baseline Inputs

1. Accessibility target: WCAG 2.2 AA (mandatory)
2. Typography baseline source: `UI UX Typography Standards` (canonicalized from personal-note baseline)
3. Corner radius baseline: subtle `4/6/8`
4. Color baseline: neutral enterprise with restrained accent
5. Icon direction: Material-style semantics with Heroicons
6. Future theming direction: DB-stored palette tokens with derived ramps for variant states

## External References

Material references:

- https://m2.material.io
- https://m2.material.io/inline-tools/typography/
- https://m1.material.io/
- https://m1.material.io/style/color.html
- https://m1.material.io/style/typography.html
- https://m1.material.io/layout/metrics-keylines.html
- https://m1.material.io/layout/responsive-ui.html
- https://m1.material.io/motion/duration-easing.html
- https://m1.material.io/usability/accessibility.html

Carbon references:

- https://carbondesignsystem.com/elements/color/overview/
- https://carbondesignsystem.com/elements/themes/overview/
- https://carbondesignsystem.com/elements/2x-grid/overview/
- https://carbondesignsystem.com/elements/spacing/overview/
- https://carbondesignsystem.com/elements/icons/usage/
- https://v10.carbondesignsystem.com/components/data-table/usage/
- https://v10.carbondesignsystem.com/components/text-input/usage/
- https://v10.carbondesignsystem.com/components/notification/usage/
- https://v10.carbondesignsystem.com/patterns/empty-states-pattern/
- https://v10.carbondesignsystem.com/guidelines/accessibility/overview/

## Related

- [[V2 App/Reference/UI UX System/UI UX Source Of Truth And Decision Log]] | [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
- [[V2 App/Reference/UI UX System/UI UX Foundations And Theming Standards]] | [UI UX Foundations And Theming Standards](UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Color Token Standards]] | [UI UX Color Token Standards](UI%20UX%20Color%20Token%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Typography Standards]] | [UI UX Typography Standards](UI%20UX%20Typography%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Iconography Standards]] | [UI UX Iconography Standards](UI%20UX%20Iconography%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Component Library Standards]] | [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
