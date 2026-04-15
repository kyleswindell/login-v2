# UI UX Iconography Standards

This document defines the canonical scope and intent for UI UX Iconography Standards.

## Purpose

Define canonical icon library usage, sizing, semantics, and accessibility rules for Login App 2.0.

## Source And Scope

This standard is adapted from:

- `docs/Personal Notes/Icon Integration Reference and Mapping.md`

The personal note remains a working source. This file is the canonical implementation owner.

## Implementation Status

Current status:

- single icon-library direction is locked
- variant, size, and semantic-mapping rules are defined
- shared semantic wrapper layer is pending full implementation lock

## Locked Direction

1. Use Heroicons as the single icon set.
2. Use Material-style semantics for meaning mapping.
3. Default to outline variant.
4. Use solid variant only for selected/high-emphasis/state contexts.
5. Icons are supportive and cannot replace critical text meaning.

## Integration Standards

Filament:

- use Heroicons through Filament icon support

Blade/Livewire:

- use Blade Heroicons components

## Variant Rules

- outline: default for navigation, neutral actions, filters, and table affordances
- solid: selected states, emphasized status, and high-priority feedback
- mini: compact controls in dense rows
- micro: metadata-only contexts; never primary navigation or primary CTAs

## Size Tokens

- `icon-xs = 16px`
- `icon-sm = 20px`
- `icon-md = 24px`
- `icon-lg = 32px`

Default mapping:

1. page/action buttons -> `icon-sm`
2. navigation -> `icon-md`
3. table row actions -> `icon-sm`
4. status badges -> `icon-sm`
5. dense metadata -> `icon-xs`
6. empty-state feature symbols -> `icon-lg`

## Semantic Mapping Rule

Reference semantic icon keys in code, not raw icon filenames.

Examples:

- `dashboard`
- `users`
- `settings`
- `notifications`
- `save`
- `delete`
- `success`
- `warning`
- `error`

## Accessibility Rules

1. Icon-only controls require accessible labels.
2. Decorative icons should be hidden from assistive technology.
3. Icons cannot be the only critical status signal.
4. Destructive actions require icon + text + confirmation.

## Pattern Rules

Navigation:

- keep icon usage consistent within each nav group

Buttons:

- use icon + text for primary/destructive/ambiguous actions
- icon-only is limited to widely recognized secondary controls

Tables:

- use icons for compact row actions and state support, not decoration

Alerts and toasts:

- use one leading status icon only

## Change Control

Any semantic icon mapping change must update:

1. this canonical file
2. `App\Support\AppIcon` (or equivalent semantic map owner)
3. wrapper usage in Blade/Filament layers

## Related

- [UI UX Foundations And Theming Standards](UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
