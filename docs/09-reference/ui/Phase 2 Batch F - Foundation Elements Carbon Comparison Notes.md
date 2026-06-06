# Phase 2 Batch F - Foundation Elements Carbon Comparison Notes

## Purpose

Non-canonical support notes for using Carbon Elements as a completeness benchmark for Login App 2.0 Foundation Elements.

## Carbon Element Mapping

| Carbon Element | Login App Treatment |
|---|---|
| 2x Grid | 8px-compatible grid and region foundation, not Carbon grid package adoption |
| Color | Semantic CSS token namespaces for text, icons, borders, surfaces, actions, statuses, and shadows |
| Icons | Heroicons remain the default library; Carbon icon usage guidance informs sizing/alignment only |
| Pictograms | Queued asset category requiring a later decision record before import or standardization |
| Motion | Restrained state-change motion with reduced-motion support |
| Spacing | Tailwind-compatible spacing scale; components do not own external margins |
| Themes | Root and resolved-theme CSS variables for light/dark behavior |
| Typography | Login App type roles and text color tokens, not IBM Plex-specific type sets |

## Implementation Boundary

Carbon is not a source of Login App visual tokens, images, icons, pictograms, or component chrome. Durable rules must live under `docs/02-standards/ui/`; this file remains supporting reference only.
