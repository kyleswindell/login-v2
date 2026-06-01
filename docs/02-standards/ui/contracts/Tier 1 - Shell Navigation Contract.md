# Tier 1 - Shell Navigation Contract

This document defines the canonical scope and intent for Tier 1 - Shell Navigation Contract.

## Component Contract

### 1. Component Identity

- Component name: Sidebar, Header, Mobile Dock, Account Menu
- Taxonomy path (L1/L2): Shell And Navigation / Global shell
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: persistent orientation and fast movement between app areas with a coherent top-level shell.
- When to use: global app navigation and identity/account controls.
- When not to use: in-page secondary filters or tab content swapping.
- Interaction intent summary: one coherent navigation model across desktop and mobile.

### 2A. Implementation Form Decision

- Current implementation form: `Hybrid`
- Intended long-term direction: `keep as hybrid with clearer wrapper contract`
- Canonical shell regions:
  - sidebar:
    - brand / workspace identity region
    - primary navigation group region
    - optional secondary/support navigation region
  - header:
    - page-context region
    - global utility/action region
    - notification/account control region
  - account menu:
    - trigger control
    - menu surface
    - grouped account/session actions
  - mobile dock:
    - compact primary destination row
    - active destination indicator
- Transitional rule:
  - shell-level templates may continue to own the composition, but downstream work must treat the region structure and behavior rules here as the contract rather than copying shell-local markup opportunistically

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): persistent header and sidebar surfaces with active route emphasis.
- Grouped shell/account menu actions should consume the shared action/menu-item semantic suite rather than shell-local text-color overrides.
- Light theme behavior: maintain separator and active state contrast.
- Dark theme behavior: maintain panel hierarchy with restrained contrast ramps.
- Density/size variants: desktop sticky sidebar and mobile modal + dock switcher.
- Allowed variants: `base` only.

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

### 7. Anti-Patterns

- Anti-pattern 1: showing toggle in desktop widths where sidebar is fixed-open
- Anti-pattern 2: leaving mobile menu open after route navigation
- Anti-pattern 3: exposing multiple sidebar contexts simultaneously on mobile
- Anti-pattern 4: rebuilding shell navigation affordances outside the declared sidebar/header/account-menu/mobile-dock regions


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
