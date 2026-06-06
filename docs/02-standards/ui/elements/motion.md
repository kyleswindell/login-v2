# Motion Foundation Standard

## Purpose

Define motion rules for hover, focus, overlays, feedback, loading, and reduced-motion behavior.

## Current Implementation

The app uses restrained transitions for controls, toasts, drawers, modals, and dashboard interactions.

## UI Reference Route

`/platform/ui-reference/elements/motion`

## Required Visible Examples

- hover transition
- focus transition
- toast motion
- drawer and modal motion
- reduced-motion requirement

## Usage Rules

- Motion must clarify state change, not decorate.
- Motion must not be the only signal of meaning.
- Reduced-motion users must retain equivalent feedback and state visibility.
- Long or repeated motion requires an explicit owner standard.

## Queued Gaps

- A consolidated transition duration/easing table is queued.

## Carbon Comparison Notes

Carbon motion guidance informs purposeful state-change motion. Login App keeps its current restrained interaction style.
