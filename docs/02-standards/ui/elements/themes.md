# Themes Foundation Standard

## Purpose

Define how light and dark visual modes resolve through semantic tokens.

## Current Implementation

The app uses root and resolved-theme CSS variables for surfaces, text, borders, actions, statuses, and shadows.

## UI Reference Route

`/platform/ui-reference/elements/themes`

## Required Visible Examples

- dark theme token set
- light theme token set
- theme inheritance
- accepted aliases

## Usage Rules

- Theme changes must happen at the token layer.
- Component-level theme overrides require an owning standard.
- Light and dark modes must preserve hierarchy, contrast, and component state meaning.

## Queued Gaps

- A formal theme token alias table is queued for the color/theme hardening pass.

## Carbon Comparison Notes

Carbon themes inform token inheritance and theme layering. Login App keeps its own theme names, values, and CSS variable model.
