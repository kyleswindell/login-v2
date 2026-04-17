# UI UX Color Token Standards

This document defines the canonical scope and intent for UI UX Color Token Standards.

## Purpose

Define the canonical tokenized color architecture for Login App 2.0 across light and dark themes.

This note is the canonical owner for explicit light, dark, and state token mappings.

## Source And Scope

This standard is adapted from:

- `docs/Personal Notes/Color Palette Note.md`

The personal note remains a working draft source. This file is the canonical implementation owner.

## Implementation Status

Current status:

- neutral enterprise + restrained accent direction is locked
- semantic role model is defined
- state ramp rules are defined
- contrast rules are defined
- final token naming and automated contrast audit workflow are pending lock sign-off

## Locked Direction

1. Use semantic tokens only; no hardcoded hex values in feature markup.
2. Keep neutral palette as base surface system.
3. Use restrained accent palette for primary interactions.
4. Map status/feedback through the canonical semantic set (`primary`, `neutral`, `success`, `warning`, `danger`, `info`, `notice`) as applicable to the component contract.
5. Require WCAG 2.2 AA minimum across text and UI controls.
6. Support future DB-backed tenant palette storage with derived ramps.

## Color Architecture

The color system has four layers:

1. Base palettes
2. Semantic roles
3. State ramps
4. Component-level usage

### Base Palette Baseline

Neutral (light):

- `0 #FFFFFF`
- `50 #F8FAFC`
- `100 #F1F5F9`
- `200 #E2E8F0`
- `300 #CBD5E1`
- `400 #94A3B8`
- `500 #64748B`
- `600 #475569`
- `700 #334155`
- `800 #1E293B`
- `900 #0F172A`

Neutral (dark):

- `0 #020617`
- `50 #0F172A`
- `100 #1E293B`
- `200 #334155`
- `300 #475569`
- `400 #64748B`
- `500 #94A3B8`
- `600 #CBD5E1`
- `700 #E2E8F0`
- `800 #F1F5F9`
- `900 #F8FAFC`

Accent baseline (primary):

- `50 #EFF6FF`
- `100 #DBEAFE`
- `200 #BFDBFE`
- `300 #93C5FD`
- `400 #60A5FA`
- `500 #3B82F6`
- `600 #2563EB`
- `700 #1D4ED8`
- `800 #1E40AF`
- `900 #1E3A8A`

Supporting semantic families follow the same 50-900 ramp:

- accent (`primary`)
- neutral (`neutral`)
- green (`success`)
- amber (`warning`)
- red (`danger`)
- blue (`info`)

Notice baseline:

- notice uses a distinct attention ramp separate from warning and info
- use amber-derived but less hazard-coded values until a later token lock introduces a separate palette

## Semantic Role Mapping

Use semantic role aliases rather than direct palette names:

- `primary -> accent`
- `neutral -> neutral`
- `success -> green`
- `warning -> amber`
- `danger -> red`
- `info -> blue`
- `notice -> amber-derived notice ramp`

Action-family clarification:

- `secondary` is not a standalone semantic color family
- `ghost` and `outline` are variants, not semantic roles
- secondary-emphasis actions use neutral-family action tokens and component-level variants such as `base`, `outline`, or `ghost`
- components may use only the semantic subsets defined by their Tier 1 contract

## Canonical State Mapping

The required state model for every semantic role is:

- `default`
- `hover`
- `active`
- `disabled`
- `focus`
- `selected`

### Action Surface Mapping

Use the following ramp rules for `base` semantic action surfaces:

| Semantic | Light default | Light hover | Light active | Light disabled | Light focus | Light selected | Dark default | Dark hover | Dark active | Dark disabled | Dark focus | Dark selected |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `primary` | accent-600 | accent-700 | accent-800 | neutral-300 | accent-500 | accent-700 | accent-400 | accent-300 | accent-200 | neutral-600 | accent-400 | accent-300 |
| `neutral` | neutral-600 | neutral-700 | neutral-800 | neutral-300 | neutral-500 | neutral-700 | neutral-500 | neutral-400 | neutral-300 | neutral-700 | neutral-400 | neutral-400 |
| `success` | green-600 | green-700 | green-800 | neutral-300 | green-500 | green-700 | green-500 | green-400 | green-300 | neutral-700 | green-400 | green-400 |
| `warning` | amber-600 | amber-700 | amber-800 | neutral-300 | amber-500 | amber-700 | amber-500 | amber-400 | amber-300 | neutral-700 | amber-400 | amber-400 |
| `danger` | red-600 | red-700 | red-800 | neutral-300 | red-500 | red-700 | red-500 | red-400 | red-300 | neutral-700 | red-400 | red-400 |
| `info` | blue-600 | blue-700 | blue-800 | neutral-300 | blue-500 | blue-700 | blue-500 | blue-400 | blue-300 | neutral-700 | blue-400 | blue-400 |
| `notice` | amber-500 | amber-600 | amber-700 | neutral-300 | amber-400 | amber-600 | amber-400 | amber-300 | amber-200 | neutral-700 | amber-300 | amber-300 |

### Non-Action Surface Mapping

Use the following ramp rules for Tier 1 non-action surfaces:

#### Badge / Status

| Semantic | Light base | Light outline | Dark base | Dark outline |
| --- | --- | --- | --- | --- |
| `neutral` | neutral-600 | neutral-500 | neutral-500 | neutral-400 |
| `success` | green-600 | green-600 | green-500 | green-400 |
| `warning` | amber-600 | amber-600 | amber-500 | amber-400 |
| `danger` | red-600 | red-600 | red-500 | red-400 |
| `info` | blue-600 | blue-600 | blue-500 | blue-400 |
| `notice` | amber-500 | amber-500 | amber-400 | amber-300 |

#### Toast / Inline Alert

| Semantic | Light base | Dark base |
| --- | --- | --- |
| `neutral` | neutral-600 | neutral-500 |
| `success` | green-600 | green-500 |
| `warning` | amber-600 | amber-500 |
| `danger` | red-600 | red-500 |
| `info` | blue-600 | blue-500 |
| `notice` | amber-500 | amber-400 |

Variant note:

- `base`, `soft`, `outline`, and `ghost` are the only Tier 1 variants
- non-action Tier 1 surfaces do not use `ghost`
- non-action Tier 1 surfaces do not use `soft` unless a component contract explicitly allows it
- components may use only the subset of variants defined by their Tier 1 contract

## State Ramp Rules

Locked ramp behavior:

1. `hover` is one step stronger than `default` within the active semantic family
2. `active` is one step stronger than `hover`
3. `disabled` uses neutral-based tokens
4. `focus` ring must be explicit and visible
5. `selected` persists semantic emphasis without requiring press state

## Contrast And Accessibility

Minimum targets:

- normal text: `4.5:1`
- large text: `3:1`
- non-text UI controls: `3:1`

Usage rules:

1. Primary and destructive filled surfaces use white foreground text.
2. Subtle fills use strong neutral foreground tokens.
3. Status semantics must never rely on color alone.
4. Disabled UI must stay readable.

## Dark Theme Rules

1. Do not invert values mechanically.
2. Preserve semantic intent across modes.
3. Keep accent ramps readable against dark surfaces.
4. Reduce saturation where needed for visual comfort.

## Implementation Direction

Token categories that must exist in code:

- background
- text
- border
- action
- feedback
- focus

Implementation target:

- runtime token substitution via DB-backed palette settings and derived semantic ramps.

## Related

- [UI UX Foundations And Theming Standards](../UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI UX Source Of Truth And Decision Log](../UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
