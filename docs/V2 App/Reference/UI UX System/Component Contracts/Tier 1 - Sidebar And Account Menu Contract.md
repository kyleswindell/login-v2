# Tier 1 - Sidebar And Account Menu Contract

## Component Contract

### 1. Component Identity

- Component name: Sidebar, Mobile Dock, Account Menu
- Taxonomy path (L1/L2): Shell And Navigation / Global shell
- Owner: Platform UI baseline owner
- Status (`Draft`/`Proposed`/`Locked`): Proposed (`Ready For Review` in matrix)

### 2. Intent And Theory

- Primary use case: persistent orientation and fast movement between app areas.
- When to use: global app navigation and identity/account controls.
- When not to use: in-page secondary filters or tab content swapping.
- Interaction intent summary: one coherent navigation model across desktop and mobile.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): persistent header + sidebar surfaces with active route emphasis.
- Light theme behavior: maintain separator and active state contrast.
- Dark theme behavior: maintain panel hierarchy with restrained contrast ramps.
- Density/size variants: desktop sticky sidebar and mobile modal + dock switcher.

### 4. Behavior Rules

- Default behavior: desktop sidebar visible; mobile sidebar collapsed by default.
- Hover/focus/active behavior: active route always distinct from hover-only states.
- Disabled/loading behavior: not applicable.
- Error/warning/success behavior (if applicable): not applicable.
- Responsive behavior (desktop/tablet/mobile): toggle only appears below desktop breakpoint; menu auto-closes after navigation.

### 5. Accessibility Requirements

- Semantic structure required: nav landmarks and explicit button controls for toggles.
- Keyboard interactions: open/close via keyboard and escape where applicable.
- Focus-visible rules: toggle and menu items must show visible focus.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: toggles expose `aria-expanded` and clear labels.
- Reduced-motion behavior: transforms optional and non-essential.

### 6. Content Rules

- Label/content guidelines: concise route labels and grouped section headings.
- Error/help messaging rules: not applicable.
- Localization notes: avoid hard-coded widths tied to English labels.

### 7. Implementation Artifacts

- UI reference example path: `/platform/ui-reference/patterns/navigation`
- Production component/view paths: `resources/views/components/layouts/app.blade.php`, `resources/views/components/layouts/mobile-sidebar.blade.php`
- JS behavior path (if any): `resources/js/app.js`, `resources/js/setup-sidebar.js`
- Token/CSS path (if any): `resources/css/app.css`

### 8. Validation Checklist

- [x] meets WCAG 2.2 AA baseline
- [x] light/dark parity verified
- [x] responsive behavior verified
- [x] all required states implemented
- [x] keyboard and focus behavior verified
- [x] documentation updated in canonical notes

### 9. Anti-Patterns

- Anti-pattern 1: showing toggle in desktop widths where sidebar is fixed-open
- Anti-pattern 2: leaving mobile menu open after route navigation
- Anti-pattern 3: exposing multiple sidebar contexts simultaneously on mobile

### 10. Lock Record

- Lock date: pending
- Reviewers: pending
- Notes: move to `Locked` after cross-device visual QA confirms behavior parity.

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Taxonomy And Coverage Matrix]] | [UI UX Component Taxonomy And Coverage Matrix](../UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [[V2 App/Reference/UI UX System/UI UX Tier 1 UI Reference Implementation Checklist]] | [UI UX Tier 1 UI Reference Implementation Checklist](../UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
