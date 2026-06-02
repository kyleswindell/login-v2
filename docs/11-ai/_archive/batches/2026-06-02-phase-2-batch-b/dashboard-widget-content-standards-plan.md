# Dashboard Widget Content Standards Plan

## Purpose

Plan the rework of the standalone Widget Content Standards page after `P2-B-CQ-021` failed manual review.

The failed implementation showed supported spans, but it did not prove realistic content allowances. Most cards used sparse sample content inside large fixed-height shells, especially in `1x2`, `2x2`, and `3x2` examples. Before another implementation pass, the dashboard grid geometry and widget content density must be planned together.

## Updated Direction: Content-Space Units First

The next implementation must stop treating semantic content names such as metric, status chip, support row, list, chart, or paragraph as the primary allowance standard. Those labels are too variable: a "metric" can be compact or large, a "list row" can be one line or three lines, and a "support row" can carry different visual weight. Trying to enumerate every possible widget content type will not produce a durable dashboard standard.

The current standard should instead define reusable **content-space units** first. Concrete widget content examples can be approved later by showing how they consume these units.

Implementation direction:

- Define content-space shapes up to `3x3`.
- Define compact status/counter shapes, including `0.5x0.5`, `1x0.5`, and a specialized `4x0.5` top-of-dashboard strip made from four `1x0.5` status/counter cards.
- Keep the widget shell title/kicker plain text and outside the colored content-space measurement blocks.
- Use the existing Current Item States palette only as internal shape visualization blocks inside neutral cards, not as full-card palettes.
- Preserve the four-unit dashboard model and `18rem` one-row shell baseline unless implementation proves a more constrained token is required.
- Show approximate usable content area after widget chrome, padding, and gaps. Example framing: `1 row = 18rem / 288px shell`, then subtract title/header/padding to show the available content-space region.

This makes the standard measurable without overfitting to arbitrary content semantics.

## Third-Party Review Inputs

- Material Design responsive layout guidance uses breakpoint-driven grids, including 4 columns on small screens, 8 columns around tablet widths, and 12 columns at larger widths. It also distinguishes summary-only content at narrow widths from summary-plus-detail content when screen width allows it. Source: https://m1.material.io/layout/responsive-ui.html
- Material Design card guidance frames cards as entry points to more detailed views, warns against overloading cards with extraneous information or actions, and expects hierarchy inside cards to emphasize the most important information first. Source: https://m1.material.io/components/cards.html
- Tableau dashboard layout guidance recommends deciding dashboard size before layout work, warns that automatic resizing can be unpredictable across screens, recommends tiled/grid-based layouts for predictable resizing, and advises arranging/sizing dashboard items over a grid. Source: https://help.tableau.com/current/pro/desktop/en-us/dashboards_organize_floatingandtiled.htm
- Microsoft Viva dashboard card guidance defines card anatomy as card bar, header, body, and footer; it also states that heading/body text must fit in card width across desktop/mobile and that medium-size cards have reduced action/content allowances due to lack of space. Source: https://learn.microsoft.com/en-us/sharepoint/dev/spfx/viva/design/designing-card
- Carbon 2x Grid guidance emphasizes consistent base units, fixed padding, breakpoint testing, and the distinction between fluid grids, fixed boxes, and hybrid boxes. It specifically says to test at standard breakpoints and to choose grid behavior based on whether users need more items visible or more content within each item. Source: https://carbondesignsystem.com/elements/2x-grid/overview/

## Current Implementation Problem

The current shared widget grid uses a `24rem` row size. At desktop widths this makes every one-row widget 384px tall before content. That solved physical row-span proofing, but it created an inflated content allowance surface for the standards page.

The current span model also uses a six-column widget grid at the shared component level:

- `1x*` spans 2 of 6 columns, or roughly one third of the row.
- `2x*` spans 4 of 6 columns, or roughly two thirds of the row.
- `3x*` spans 6 of 6 columns, or full row.

This is functionally a three-unit dashboard grid, not a four-across dashboard grid. The manual review question about whether the grid should be four across is valid because a four-unit model would change the meaning of `1x`, `2x`, and `3x`:

- Four-unit model: `1x` = one quarter, `2x` = half, `3x` = three quarters, `4x` = full row.
- Current three-unit model: `1x` = one third, `2x` = two thirds, `3x` = full row.

The next implementation must not silently keep the current geometry if the standards page is meant to guide future modules.

## Planning Decision Required Before Implementation

The next pass must evaluate and choose one of these geometry directions:

| Option | Width model | Pros | Risks |
| --- | --- | --- | --- |
| A. Keep current three-unit model | `1x` third, `2x` two-thirds, `3x` full row | Matches current code and approved span proof language; fewer migration changes | `1x1` is wide and `1x2` is very tall/wide for small widgets; can encourage sparse cards |
| B. Move to four-unit model | `1x` quarter, `2x` half, `3x` three-quarter, `4x` full row | Common dashboard rhythm; better small-card density; answers four-across review concern | Requires adding/renaming full-row spans or redefining `3x`; affects approved proof assumptions |
| C. Keep three-unit naming but calibrate row height down | Current width model, shorter row track | Lowest disruption; fixes the worst whitespace problem | Does not answer whether four-across should be the real future-module baseline |

Recommended planning outcome: prototype Option A and Option B inside the standards page or a temporary proof section, then select the production contract based on 1280px, 1366px, 1440px, and 1920px desktop review. Do not finalize content allowances until the width model and one-row height are chosen.

## Viewport Baseline

The standard must be judged at constrained office-monitor widths, not only on a large 27-inch 1440p monitor.

Required review widths:

- `1024px`: small laptop or constrained split-screen review.
- `1280px`: common laptop/desktop baseline.
- `1366px`: common office laptop width.
- `1440px`: common desktop width.
- `1920px`: large monitor upper-bound behavior.

Required behavior:

- No widget example should depend on a 1440p monitor to look valid.
- No standard example should clip at 1280px or 1366px once app shell/sidebar space is considered.
- `x2` height should be used for actual same-topic content capacity, not left mostly empty.
- Wide screens may reveal more horizontal comparison, but they must not be the only place the page works.

## Geometry Calibration Targets

The next pass should calibrate:

- Column model: three-unit versus four-unit dashboard width rhythm.
- Row height: whether `24rem` is only a proof/debug height and whether production widget standards should use a shorter row such as `18rem`, `20rem`, or responsive `clamp()`.
- Gap and padding: avoid inflated borders/section boxes that consume visual area without content.
- Content fill target: examples should use roughly 65-85% of the available content region, with intentional breathing room but no large unused lower half.
- Overflow rule: widgets must not introduce internal scrolling as a baseline; overflow means the widget size or content allowance is wrong.

## Content-Space Allowance Model

Every size needs a shape-composition proof and an explicit negative boundary. Semantic examples may appear as secondary examples only after the shape capacity is visible.

| Size | Shape allowance | Must show in proof | Not allowed by default |
| --- | --- | --- | --- |
| `0.5x0.5` | Tiny status/count atom | Compact color block used only inside status-strip planning | Rich content, labels that need wrapping |
| `1x0.5` | Compact status/counter item | Half-height item suitable for a top dashboard strip | Paragraphs, lists, charts, multi-action controls |
| `1x1` | One base content-space unit | A single reusable unit that can later host one approved compact content pattern | Multiple stacked full units, dense lists, paragraph-heavy detail |
| `2x1` | Two `1x1` units or one horizontal `2x1` unit | Both split and unified compositions | Tall content, second-row detail |
| `1x2` | Two stacked `1x1` units or one vertical `1x2` unit | Both split and unified vertical compositions | Wide charts or side-by-side content |
| `2x2` | Four `1x1`, two `2x1`, two `1x2`, or one `2x2` unit | Composition grid that visibly uses the full surface | Unrelated sections, forms, table/filter workflows |
| `3x1` | Three `1x1`, one `2x1` plus one `1x1`, or one `3x1` unit | Single-row comparison and unified wide compositions | Content that requires a second row |
| `3x2` | Six `1x1`, three `1x2`, two `3x1`, one `3x2`, or mixed valid combinations | Rich same-topic two-row capacity without whitespace | Independent workflows, complex tables, unrelated panels |
| `3x3` | Nine `1x1`, three `3x1`, three `1x3` if accepted later, or one `3x3` unit | Upper-bound dashboard module capacity for future standards | Treating it as a general page replacement |
| `4x0.5` | Four `1x0.5` status/counter cards across the dashboard row | Specialized dashboard-header/status-strip proof | Reusing it as a normal widget body without separate approval |

## Proof Page Requirements

The reworked Widget Content Standards page must include:

1. A short geometry decision section explaining the selected width model, row height, and breakpoints.
2. A content-space unit system that defines `0.5x0.5`, `1x0.5`, `1x1`, `2x1`, `1x2`, `2x2`, `3x1`, `3x2`, `3x3`, and specialized `4x0.5`.
3. A px budget explanation showing one-row shell size and approximate usable content area after widget chrome/padding/gaps.
4. A visual shape map using Current Item States palette blocks inside neutral card shells.
5. A composition matrix that shows which smaller units may combine into each widget size.
6. Standalone UI Reference pages/routes for size-specific standards so future approved widget-content examples can grow without bloating the landing page.
7. A viewport review note naming the constrained desktop widths used for validation.
8. At least one negative example or boundary note showing when content no longer belongs in a dashboard widget.
9. No unapproved semantic color palettes for default cards.
10. No sparse placeholder cards that imply empty area is an acceptable allowance.

## Standalone Page Plan

Create standalone Widget Content standards pages now, even if most pages initially focus on content-space capacity rather than final approved module examples.

Required page structure:

- Widget Content landing page: shape system overview, geometry, px budget, and navigation into size pages.
- Shape Map page: full content-space unit map up to `3x3`, including compact status units and the `4x0.5` strip.
- Size pages:
  - `1x1`
  - `2x1`
  - `1x2`
  - `2x2`
  - `3x1`
  - `3x2`
  - `3x3`
  - compact status strip / `4x0.5`

The size pages may start as standards scaffolds with shape compositions and accepted/invalid capacity examples. Later batches may add approved real widget-content patterns by size.

## Acceptance Criteria For Next CQ

- The current semantic-content allowance framing is replaced with content-space unit standards.
- The standards page visibly demonstrates shape capacity and composition rules up to `3x3`, plus compact status/counter units.
- The specialized `4x0.5` dashboard status strip is represented as four `1x0.5` cards, not as a normal full-card palette.
- The grid geometry and px budget are explicitly documented before concrete content examples are presented.
- Standalone size-standard routes/pages exist so future approved widget content examples can be added without overloading the landing page.
- Tests assert the selected geometry documentation, content-space unit map, standalone page navigation, and key size-specific routes.
- The implementation remains UI Reference-first and does not change live dashboard feature behavior unless a grid-token decision explicitly requires shared component updates.
