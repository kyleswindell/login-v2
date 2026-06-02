# Dashboard Widget Content Standards Plan

## Purpose

Plan the rework of the standalone Widget Content Standards page after `P2-B-CQ-021` failed manual review.

The failed implementation showed supported spans, but it did not prove realistic content allowances. Most cards used sparse sample content inside large fixed-height shells, especially in `1x2`, `2x2`, and `3x2` examples. Before another implementation pass, the dashboard grid geometry and widget content density must be planned together.

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

## Content Allowance Model

Every size needs a realistic filled example and an explicit negative boundary.

| Size | Intended allowance | Must show in proof | Not allowed by default |
| --- | --- | --- | --- |
| `1x1` | Compact summary: title, one primary metric/status, one support line, optional small trend/status chip | Dense but readable metric card that uses the slot without nested boxes consuming the whole surface | Lists, multiple unrelated metrics, paragraph-heavy detail |
| `2x1` | Wide summary: two to three related metrics, mini trend, or compact status strip | Horizontal content that proves the width supports comparison in one row | Tall lists, dense detail blocks, workflow controls |
| `1x2` | Tall narrow list/activity: four to six compact items or a timeline with statuses | Content that visibly uses the second row with a vertical sequence | Side-by-side layout, wide charts, unrelated groups |
| `2x2` | Detail summary: primary metric group plus one same-topic list/chart/body block | A filled two-row composition with top summary and lower supporting content | Multi-section workflow page, tables with filters, unrelated panels |
| `3x1` | Full-row or wide-row summary, depending on selected geometry | Broad single-row scan with three or four related compact blocks | Content that needs a second row to make sense |
| `3x2` or full-row x2 | Rich same-topic dashboard summary: KPI group, compact visualization/table, and exception list | A genuinely two-row composition with enough related detail to justify the height | Independent sections, complex filters, editable forms |

## Proof Page Requirements

The reworked Widget Content Standards page must include:

1. A short geometry decision section explaining the selected width model, row height, and breakpoints.
2. A viewport review note naming the constrained desktop widths used for validation.
3. A realistic filled example for every supported size.
4. A per-size allowance table with “fits,” “stretch,” and “escalate to page” guidance.
5. At least one negative example or boundary note showing when content no longer belongs in a dashboard widget.
6. No unapproved semantic color palettes for default cards.
7. No sparse placeholder cards that imply empty area is an acceptable allowance.

## Acceptance Criteria For Next CQ

- The current failed sparse examples are replaced, not just padded or decorated.
- The standards page visibly demonstrates content occupying one-row and two-row cards appropriately.
- The grid geometry is explicitly reviewed and documented before final examples are presented.
- Tests assert the selected geometry documentation and the presence of realistic per-size examples.
- The implementation remains UI Reference-first and does not change live dashboard feature behavior unless a grid-token decision explicitly requires shared component updates.
