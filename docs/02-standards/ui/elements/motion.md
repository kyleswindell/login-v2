# Motion Foundation Standard

## Purpose

Motion guides, clarifies, or confirms state change without adding decorative friction.

## Current Implementation

Login App uses CSS transitions and component behavior for hover/focus, dropdowns, modals, toasts, accordions, panels, table changes, and loading states.

## UI Reference Route

`/platform/ui-reference/elements/motion`

## Required Visible Examples

- productive and expressive easing demos
- component motion previews for dropdown, modal, toast, accordion/collapse, side panel, table sort/reorder, and skeleton-to-content transition
- reduced-motion preview
- do/don't samples for subtle entrance, clear exit, no bounce, no decorative spin, and no long delay

## Token/Class/API Reference

Use approved CSS transition utilities and component-owned motion behavior. New motion must respect `prefers-reduced-motion`.

## Usage Guidance

Productive motion is the default. Expressive motion requires a high-attention moment and explicit owner. Use entrance easing when adding UI and exit easing when removing UI.

## Accessibility Notes

Reduced-motion users must retain equivalent state visibility and feedback. Motion must not be the only signal of meaning.

## Developer Notes

Avoid bounce, decorative spin, sudden stops, excessive distance, and long animations. Do not delay content usability for animation.

## Implementation Status

Guide status: Implemented. System maturity: Partial.

## Carbon Comparison Notes

Carbon's productive/expressive split informs classification. Login App keeps restrained app-specific motion.
