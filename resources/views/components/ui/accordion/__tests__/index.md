# Accordion Tests

## Purpose

This folder owns co-located tests for `x-ui.accordion`.

Current status: pilot coverage only. Passing these tests means the installed Login App Blade contract and a small set of browser interactions are working. It does not mean the component has passed Carbon parity review, automated accessibility review, visual review, or final manual component approval.

## Carbon Files Reviewed

- `reference/carbon-main/packages/react/src/components/Accordion/Accordion.tsx`
- `reference/carbon-main/packages/react/src/components/Accordion/AccordionItem.tsx`
- `reference/carbon-main/packages/react/src/components/Accordion/Accordion.Skeleton.tsx`
- `reference/carbon-main/packages/react/src/components/Accordion/__tests__/Accordion-test.tsx`
- `reference/carbon-main/packages/react/src/components/Accordion/__tests__/AccordionItem-test.tsx`
- `reference/carbon-main/packages/react/src/components/Accordion/__tests__/AccordionSkeleton-test.tsx`

## Local Files Covered

- `resources/views/components/ui/accordion/index.blade.php`
- `resources/js/ui-controls/accordions.js`
- `docs/02-standards/ui/components/accordion.md`

## Local Standards Consulted

- `docs/02-standards/ui/components/accordion.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `AccordionBladeContractTest.php` covers installed Blade markup, public prop resolution, item IDs, ARIA pairing, open/closed panels, disabled item state, HTML body rendering, and supported variants.
- `AccordionInteraction.spec.js` covers installed browser behavior for click, Enter, Space, single-open mode, disabled no-op, persisted focus data, and hidden/ARIA state sync.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Rendered snapshot shape | Not ported | Carbon snapshots are React/Carbon class snapshots. Local tests should use explicit Blade contract assertions instead. |
| Axe and Accessibility Checker | Not covered | Requires an approved browser accessibility test setup before enforcement. |
| Tab focus reaches first trigger | Not covered | Portable browser behavior; add before final manual approval. |
| Enter and Space activation | Covered | `AccordionInteraction.spec.js` verifies native button activation. |
| Flush alignment class | Partially covered | Blade test verifies `alignment="flush"` resolves app-owned class and data attributes. Carbon's `isFlush` + `align="start"` edge case is not directly portable. |
| Expand/collapse all controlled state | Not portable as Carbon test | Carbon React rerender behavior does not map directly to the current Blade array API. App-level bulk state would need an approved local API first. |
| Ordered `ol` / unordered `ul` semantics | Drift candidate | Carbon supports `ordered`; Login App currently renders a `div` root with `section` items and has no ordered accordion prop. |
| Extra props and custom class spreading | Partially covered | Root class merging is covered indirectly; item-level arbitrary prop spreading is not a local public API. |
| Disabled item | Covered | Blade and browser tests verify disabled trigger behavior. |
| Click callbacks | React-only / not portable | Current Blade component has no `onClick` or `onHeadingClick` callback API. |
| Open prop and state changes | Partially covered | Initial open/closed state and browser toggles are covered. React rerender semantics are not portable. |
| Custom toggle rendering | React-only / not portable | Login App owns the chevron icon contract through the Blade component. |
| Title and aria-label props | Partially covered | Title rendering is covered. Custom trigger `aria-label` is not a local public API. |
| Escape closes open trigger panel | Drift candidate | Carbon supports Escape close from the trigger. Login App current standard/test pilot does not enforce it. |
| Escape inside panel does not close | Drift candidate | Only relevant if Escape close is adopted locally. |
| Accordion skeleton API | Drift candidate | Carbon has skeleton tests. Login App currently has no accordion skeleton Blade API. |

## Intentional Divergences

- Login App owns app-specific `ui-*` classes and `data-ui-*` attributes instead of Carbon `cds--*` classes.
- Login App uses an app-owned array item API instead of React child components.
- Login App tests use focused contract and behavior assertions instead of Carbon snapshots.

## Drift Candidates Not Yet Enforced

- Carbon renders the root as `ul` or `ol` and items as `li`; Login App currently renders a `div` root and item `section` elements.
- Carbon supports an `ordered` prop; Login App currently has separate list components and no ordered accordion prop.
- Carbon supports root-level disabled state; Login App currently supports item-level disabled state.
- Carbon closes an open item on Escape from the trigger; Login App currently relies on native button activation and click handling.
- The Login App standard says `role="region"` should be used only when a panel needs a named region, while the installed Blade currently emits `role="region"` on every panel.
- Carbon has a dedicated Accordion skeleton; Login App currently has no accordion skeleton Blade API.
