# Foundation Elements Standards

Foundation Elements are the baseline layer beneath Tier 1 components. They define the visual and behavioral primitives used by components, patterns, and feature modules.

## Element Set

- [Grid](grid.md)
- [Color](color.md)
- [Icons](icons.md)
- [Pictograms](pictograms.md)
- [Motion](motion.md)
- [Spacing](spacing.md)
- [Themes](themes.md)
- [Typography](typography.md)

## Tier Relationship

- Foundation Elements own tokens, grid, spacing, typography, iconography, motion, and themes.
- Tier 1 components consume Foundation Elements and define reusable primitives.
- Tier 2 patterns compose Tier 1 components into reusable page and workflow structures.
- Tier 3 feature modules compose approved lower tiers into app-specific behavior.

## UI Reference Requirement

Each Foundation Element must have a UI Reference route that displays final Login App examples, not only prose. The route must link back to its canonical standard doc.

## Carbon Comparison

Carbon is a completeness and organization benchmark only. Login App standards must not copy Carbon visual tokens, IBM-specific assets, or Carbon component chrome without a separate decision record.
