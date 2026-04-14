# UI UX Color Token Standards

## Purpose

Define the canonical tokenized color architecture for Login V2 across light and dark themes.

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
4. Map status/feedback through semantic roles (`success`, `warning`, `danger`, `info`, `notice`).
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

- green (`success`)
- amber (`warning`)
- red (`danger`)
- blue (`info`)

## Semantic Role Mapping

Use semantic role aliases rather than direct palette names:

- `primary -> accent`
- `secondary -> neutral`
- `success -> green`
- `warning -> amber`
- `danger -> red`
- `info -> blue`

## State Ramp Rules

Each semantic role must provide:

- `default`
- `hover`
- `active`
- `subtle`
- `muted`
- `disabled`
- `focus`

Locked ramp behavior:

1. `hover` is one step darker than `default`
2. `active` is two steps darker than `default`
3. `subtle` uses 50-100 range
4. `muted` uses 100-200 range
5. `disabled` uses neutral-based tokens
6. focus ring must be explicit and visible

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

- [[V2 App/Reference/UI UX System/UI UX Foundations And Theming Standards]] | [UI UX Foundations And Theming Standards](UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Source Of Truth And Decision Log]] | [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
