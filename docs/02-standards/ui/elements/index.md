# Foundation Elements Standards

Foundation Elements are the baseline visual system beneath Tier 1 components. They define layout, color, typography, spacing, motion, iconography, pictograms, and themes before components or patterns compose them.

## UI Reference Route

`/platform/ui-reference/elements`

## Tier Relationship

- Foundation Elements own tokens, grid, spacing, typography, iconography, motion, and themes.
- Tier 1 components consume Foundation Elements and define reusable primitives.
- Tier 2 patterns compose Tier 1 components into reusable page and workflow structures.
- Tier 3 feature modules compose approved lower tiers into app-specific behavior.

## Page Contract

Every Foundation Element UI Reference page must answer what the element looks like in Login App 2.0, what token/class/helper/component to use, when to use it, what to avoid, and what accessibility constraints apply.

Each page must visibly include:

- Purpose
- Live examples rendered with app CSS/JS
- Token/class/API reference
- Usage guidance
- Accessibility notes
- Developer notes
- Related implementation links
- Implementation status

## Element Set

- [2x Grid](grid.md)
- [Color](color.md)
- [Icons](icons.md)
- [Pictograms](pictograms.md)
- [Motion](motion.md)
- [Spacing](spacing.md)
- [Themes](themes.md)
- [Typography](typography.md)

## Carbon Comparison

Carbon is a completeness and organization benchmark only. Login App standards must not copy Carbon visual tokens, IBM-specific assets, icons, pictograms, spacing, or component chrome without a separate decision record.
