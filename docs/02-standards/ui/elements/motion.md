# Motion Foundation Standard

## Purpose

Motion guides, clarifies, or confirms state change without adding decorative friction.

## Current Implementation

Login App uses app CSS transitions and JavaScript-driven UI behavior for hover/focus, dropdowns, modals, toasts, accordions, panels, table changes, and loading states.

## UI Reference Route

`/platform/ui-reference/elements/motion`

## Required Visible Examples

- productive standard, productive entrance, and productive exit motion
- expressive standard, expressive entrance, and expressive exit motion
- dropdown open, modal enter/exit, toast, accordion/collapse, side panel, table sort/reorder, and loading/skeleton transition examples
- duration examples for small, medium, large, productive, and expressive movement
- reduced-motion preview or static comparison
- do/don't samples for subtle entrance, clear exit, no bounce, no decorative spin, and no long delay

## Token/Class/API Reference

Use approved CSS transition utilities, app component behavior, and `prefers-reduced-motion` media handling. Component-specific motion belongs to the component or pattern owner.

## Usage Guidance

Productive motion is the default for normal app interactions. Expressive motion is reserved for important or high-attention moments. Use entrance easing when adding content, exit easing when removing content, and standard easing when an element remains visible.

Avoid bounce, stretch, sudden stops, excessive distance, decorative spin, and long animations.

## Accessibility Notes

Respect `prefers-reduced-motion`. Non-essential motion should be removed, shortened, or replaced when reduced motion is active.

## Developer Notes

Do not delay content usability for animation. Any new motion behavior must include reduced-motion handling and should be represented in UI Reference before reuse.

## Implementation Status

Partial.

## Carbon Comparison Notes

Carbon's productive/expressive motion split informs classification. Login App keeps its own durations, easing, and implementation details.
