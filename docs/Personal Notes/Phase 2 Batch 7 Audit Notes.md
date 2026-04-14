# Phase 2 Batch 7 Audit Notes

## Scope

Capture current Batch 7 UI audit findings, likely causes, and solution paths for open deliverables and additional UI design regressions.

## Summary Of Open Deliverables

- 7c: Audit/error log modal detail views (Microsoft-style side pop-out) still not restored.
- 7c: Audit log filter control now uses the default filter icon on staging after redeploy; error log parity still needs its own verification pass.
- 7c: Audit log row actions now render as button-styled actions on staging after redeploy; error log parity still needs its own verification pass.
- 7d: Mobile sidebar toggle behavior is broken at small widths (starts open, toggle not interactable).
- 7e: Light-mode action buttons have contrast regressions and unreadable text.
- 7e: Notification widget and dashboard action buttons lack consistent action styling.
- 7e: Notification inbox "Open notification link" actions still render as plain text links.
- 7e: Development Tools "Generate" button is too dark in light mode.
- 7e/7f: No standardized action colorway system (success/warning/error/notice/info/neutral) across surfaces.
- Planning: Batch 7 and future batches need explicit links to canonical UI design docs for feature UI patterns.

## Findings, Causes, Solution Paths

### 1) Audit & Error Log View Buttons Not Styled As Action Buttons

- Problem
	- Row-level View actions in audit/error logs render as plain text (no button affordance), reducing scanability and accessibility.
- Current slice status
	- Audit logs are now rendering the `View` action as a shared `ui-action ui-action-primary` button on staging.
	- Error logs still need a dedicated parity verification pass before this finding can be closed completely.
- Likely causes or pitfalls
	- Recent refactors swapped link/button styling without applying the shared action button classes.
	- Focus on modal hookup led to missing UI action styling pass.
- Potential solution paths
	- Replace the plain text link/button styling with the shared action button class set used elsewhere (e.g., settings/actions).
	- Ensure hover/focus states follow the same contrast rules in light mode.

### 2) Colored Action Buttons Unreadable In Light Mode

- Problem
	- Colored action buttons become low-contrast in light mode (text and background too close).
- Likely causes or pitfalls
	- Global light-mode overrides in `resources/css/app.css` are flattening Tailwind color utilities (e.g., `bg-slate-*` overrides) and indirectly affecting action button palettes.
	- Missing light-mode specific overrides for action buttons.
- Potential solution paths
	- Add explicit light-mode variants for action buttons (e.g., `html[data-theme-resolved='light'] .ui-button-*`), avoid relying on generic slate overrides.
	- Audit button classes to ensure they use intentional color tokens rather than inherited slate backgrounds.

### 3) Audit & Error Log Pop-Out Views

- Problem
	- Microsoft-style side pop-out detail views are not present. Error logs currently use a centered modal; audit logs have no modal at all.
- Likely causes or pitfalls
	- Modal restoration focused on error logs only, and used a centered overlay for speed.
	- Audit logs still missing modal wiring entirely.
- Potential solution paths
	- Implement a shared right-side drawer component (fixed, right-aligned, full-height, overlay backdrop).
	- Use a common payload loader for both audit and error logs (same pattern, different schemas).
	- Ensure ESC/backdrop close and focus trapping.

### 4) Filter Button Not Using Default Filter Icon

- Problem
	- Filter buttons show text "Filters" instead of the standard filter icon.
- Current slice status
	- Audit logs now render the compact filter icon button on staging with the expected accessible label.
	- Error logs still need a dedicated parity verification pass before this finding can be closed completely.
- Likely causes or pitfalls
	- Recent toggle refactor added text labels but removed the icon-only affordance.
- Potential solution paths
	- Restore icon-only button (or icon + label) consistent with the legacy Filament convention.
	- Standardize a reusable filter-toggle component for all tables.

### 5) Mobile Sidebar Toggle Not Interactable + Sidebar Starts Open

- Problem
	- At small widths the sidebar is visible by default and the hamburger toggle cannot be clicked.
	- Mobile-width pass (390px) still shows the full sidebar and setup panel instead of a collapsed hamburger menu.
- Likely causes or pitfalls
	- The fixed sidebar overlay sits above the header toggle, intercepting clicks.
	- `sidebar-open` class persists across navigation and prevents auto-collapsing on resize.
- Potential solution paths
	- Ensure sidebar has lower z-index than the header toggle, or place toggle inside the sidebar overlay.
	- Clear `sidebar-open` on small screens; force closed on <1024px.
	- Add backdrop and body scroll lock when sidebar is open.

### 6) Notifications Widget "View" Actions Not Styled As Buttons

- Problem
	- Notifications dashboard widget "View" actions render as plain text links (missing button affordance).
- Likely causes or pitfalls
	- Widget uses the default anchor styling instead of shared action-button classes.
	- No standardized UI action token system guiding widget-level actions.
- Potential solution paths
	- Apply the shared action button class set to widget actions.
	- Align action style with the primary/secondary action palette defined for the dashboard.

### 7) Development Tools "Generate" Button Too Dark In Light Mode

- Problem
	- The "Generate" action in the Development Tools widget uses a dark blue that reads muddy or low-contrast on light backgrounds.
- Likely causes or pitfalls
	- Light-mode overrides flatten the blue palette without providing a tuned light-mode token.
	- No consistent color token system for action buttons.
- Potential solution paths
	- Introduce explicit light-mode button tokens (e.g., `ui-action-primary`, `ui-action-secondary`).
	- Update the widget to use the standardized action button tokens.

### 8) Missing Standardized Action Colorways

- Problem
	- Action button colors are being chosen ad-hoc, causing inconsistency and regressions across light/dark mode.
- Likely causes or pitfalls
	- No canonical design doc for action button colorways and states (normal/hover/active/focus).
	- No shared CSS tokens (utility classes are overridden by light-mode rules).
- Potential solution paths
	- Define a shared action colorway system (at least 8-10 tokens: primary, secondary, success, warning, danger, info, notice, neutral, ghost, outline).
	- Provide both light and dark equivalents with contrast checks.
	- Reference the system from widget actions, table row actions, and notification/category badges.

### 9) Missing Canonical UI Design Doc Links In Planning

- Problem
	- Batch 7 (and future batches) lack explicit links to canonical UI design docs for the features they implement.
- Likely causes or pitfalls
	- Design system and component pattern docs were not created or linked during Batch 7.
- Potential solution paths
	- Add explicit design owner links in Batch 7 planning for UI patterns (drawer, action buttons, filter icons, badges).
	- Create a canonical UI design system doc and link it from Phase planning notes.

### 10) Notification Inbox Action Link Still Plain Text

- Problem
	- Notification inbox cards render the "Open notification link" as plain text links instead of button-styled actions.
- Likely causes or pitfalls
	- Inbox card template does not apply shared action token classes to inline links.
	- Action token usage is inconsistent between dashboard widgets and inbox cards.
- Potential solution paths
	- Apply the `ui-action` or `ui-action-notice` class to inbox action links.
	- Standardize notification action styling across inbox and dashboard widgets.

## Additional UI Design Problems Observed

- Action color tokens are inconsistent between dashboards, tables, and forms.
- Row detail affordances are inconsistent (text link vs button) across audit/error tables.
- Modal vs drawer patterns are inconsistent (center modal vs right drawer) between error logs and audit logs.
- Notification widget action affordances differ from table action affordances.

## Proposed Next Steps

- Standardize action button styling and light-mode overrides in a shared class.
- Implement a single right-side drawer component and reuse for audit/error detail views.
- Reintroduce filter icon button as the default table filter affordance.
- Fix sidebar z-index and state handling for small screens, add a backdrop.
