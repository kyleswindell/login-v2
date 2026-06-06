# Pictograms Foundation Standard

## Purpose

Pictograms are illustrative assets used to simplify or support larger ideas in empty states, onboarding, help, and feature-introduction surfaces.

## Current Implementation

Login App has no approved pictogram library yet. Pictograms remain queued until app-safe assets and usage owners are approved.

## UI Reference Route

`/platform/ui-reference/elements/pictograms`

## Required Visible Examples

- queued approved-library table with productive/expressive disposition and trigger conditions
- size examples for 48px, 64px, 80px, 96px, and 128px+
- productive versus expressive comparison using app-safe placeholder treatment
- container examples for none, circle, rectangle, correct padding, and incorrect cropping
- clearance demo and incorrect collapsed spacing
- light, dark, monochrome, and contrast examples
- app usage examples for empty state, onboarding panel, feature card, help section, and no results

## Token/Class/API Reference

Until assets are approved, use placeholder treatment only in UI Reference. Do not add external pictogram packages or Carbon pictograms.

## Usage Guidance

Pictograms are not UI icons, button icons, logos, or product lockups. Productive pictograms should be the default once approved. Expressive pictograms should be reserved for high-presence moments.

Avoid cropping, distortion, arbitrary recoloring, unsupported containers, and speculative asset imports.

## Accessibility Notes

Pictograms must remain legible and accessible against their background. Decorative pictograms should be hidden from assistive tech; meaningful pictograms need adjacent text or an accessible label.

## Developer Notes

Do not import Carbon pictograms without a separate decision record. Trigger a pictogram asset decision only when a real empty state, onboarding, help, or feature-card consumer needs the asset.

## Implementation Status

Needs audit.

## Carbon Comparison Notes

Carbon pictogram guidance informs the distinction between icons and illustrations. Login App has not adopted Carbon pictogram assets.
