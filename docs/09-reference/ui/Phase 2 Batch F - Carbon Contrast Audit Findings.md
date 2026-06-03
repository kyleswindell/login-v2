# Phase 2 Batch F - Carbon Contrast Audit Findings

## Purpose

Document the findings from a focused contrast audit of Login App 2.0's current UI Reference against the Carbon Design System, conducted as the required first step before Batch F starter catalog implementation.

## Audit Method

**Sources used (all accessed via carbondesignsystem.com, the public aggregation of the upstream repositories):**
- carbondesignsystem.com/components/button/usage/
- carbondesignsystem.com/components/notification/usage/
- carbondesignsystem.com/components/form/usage/
- carbondesignsystem.com/guidelines/content/action-labels/
- carbondesignsystem.com/components/tag/usage/
- carbondesignsystem.com/patterns/notification-pattern/
- carbondesignsystem.com/patterns/status-indicator-pattern/
- carbondesignsystem.com/patterns/empty-states-pattern/

This site aggregates the content of `carbon-design-system/carbon-website`, `carbon-design-system/carbon`, and `carbon/tree/main/docs`, satisfying the required audit source set defined in P2-F-CQ-001.

**Framing:** Carbon is used here as a documentation-depth and completeness benchmark only. No IBM or Carbon visual patterns are being adopted. All findings are translated into Login App 2.0-specific language and tied to this app's existing token, contract, and guidance structures.

---

## 1. Actions and Buttons

### What Login App 2.0 currently has
- Semantic action tokens: `primary`, `neutral`, `success`, `warning`, `danger`, `info`, `notice`
- Style variants: `base`, `soft`, `outline`, `ghost`
- Size variants: `xs`, `sm`, `md`, `lg`, `xl`
- Basic rules: verbs first in labels; known anti-patterns documented; `aria-label` required on icon buttons
- Class pattern: `ui-action`, `ui-action-{semantic}`, `ui-action-{variant}`, `ui-icon-button`

### Gaps revealed by Carbon audit

**G-ACT-01 — No "when to use each variant" rule**
Carbon documents explicit selection criteria for each variant (primary: once per page for the most important action; secondary/paired: only alongside a primary; tertiary/less-prominent: independent or lower-emphasis actions; ghost: lowest emphasis, mostly icon-only or in dense UI). Login App 2.0's Tier 1 contract lists the variants but has no documented decision rule for choosing between them.

**G-ACT-02 — `soft` vs `outline` selection undefined**
Login App 2.0 defines both `soft` (reduced-intensity colorway) and `outline` as style variants, but no documented rule distinguishes when to choose `soft` over `outline`. Carbon doesn't use this split, but the gap is the absence of any app-specific decision boundary.

**G-ACT-03 — No explicit "one primary per action row" rule**
Carbon states that no more than one primary-emphasis action should appear in any given action row. Login App 2.0's contract says "avoid primary vs primary" in anti-patterns but does not state this as an explicit rule.

**G-ACT-04 — Destructive action emphasis tiers not split**
Carbon defines three danger styles: primary danger (required or primary destructive action), tertiary danger (lower-emphasis destructive), and ghost danger (minimal-emphasis inline destructive). Login App 2.0 uses `ui-action-danger` as a single semantic token. No guidance distinguishes emphasis tiers for destructive actions.

**G-ACT-05 — No page-level action alignment rule**
Carbon specifies that form-level primary actions should be left-aligned to match the form's reading flow, while dialog/wizard primary actions should be right-aligned. Login App 2.0's shell family rule matrix documents the page title/actions row but does not capture this form vs dialog alignment distinction.

---

## 2. Action Labels

### What Login App 2.0 currently has
- Basic guidance: "verbs first in label text"
- Some form-specific labels mentioned inline in Tier 1 contracts (Save, Apply)

### Gaps revealed by Carbon audit

**G-LABEL-01 — No canonical action label glossary**
Carbon maintains a comprehensive action label list with distinct behavioral semantics per label. Login App 2.0 has no equivalent canonical list. The gap means different agents and developers may use the same labels for different behaviors.

**G-LABEL-02 — Apply vs Save vs Submit distinction undocumented**
Carbon defines clear behavioral boundaries: **Apply** = save current settings without closing the view; **Save** = commit file or content to storage without closing; **Submit** = complete and return from a flow (Carbon avoids "Submit" in most cases; uses "Create" or "Done" instead). Login App 2.0's contracts mention "Save/Apply bar" but do not document what behavior each label implies.

**G-LABEL-03 — Cancel vs Close behavioral difference not documented**
Carbon distinguishes: **Cancel** = stop a pending action and close the dialog (warn of data loss); **Close** = close a view or panel without implying a pending action to stop. Login App 2.0 uses both without a documented distinction.

**G-LABEL-04 — Add vs Create vs New usage rule absent**
Carbon distinguishes: **Add** = use an existing object in a new context; **Create** = make a new object from scratch; **New** = initiate creation (use only as a last resort when space is too limited for "Create"). No equivalent rule exists in Login App 2.0.

**G-LABEL-05 — Delete vs Remove vs Clear behavioral difference absent**
Carbon distinguishes: **Delete** = permanently destroy; **Remove** = remove from a context but do not destroy; **Clear** = empty a selection, field, or set. No equivalent distinction is documented for Login App 2.0.

**G-LABEL-06 — Wizard-step label convention not documented**
Carbon specifies: **Back** (not "Previous") for the prior wizard step; **Next** for the following step; **Finish** for the final step that completes a sequence; **Done** for returning after editing without completing a sequence. Login App 2.0 has no wizard-step label convention documented.

---

## 3. Notifications: Inline Alert, Toast, AJAX Feedback, and Persisted Notifications

### What Login App 2.0 currently has
- Toast: semantic variants, dismiss button, short title + 1–2 lines, shared toast event system
- Inline alert: semantic variants, `role="alert"` / `role="status"` by severity
- Persisted platform notifications: stored in DB, displayed in notification inbox widget

### Gaps revealed by Carbon audit

**G-NOTIF-01 — No documented boundary between inline alert and toast**
Carbon clearly distinguishes: **inline alert** (appears within the task flow, near affected content, persists until the issue resolves or the user dismisses it); **toast** (top-right, non-modal, time-based, not tied to specific content); **actionable notification** (requires user interaction before dismissal). Login App 2.0's Tier 1 contract documents the components but not the usage selection rule.

**G-NOTIF-02 — Same-page AJAX feedback type undefined**
When a Livewire form is submitted and returns an error or success, an inline alert is rendered on the same page without a full page redirect. There is no documented rule distinguishing: same-page Livewire inline alert (rendered in component, no redirect); toast (dispatched as an event, appears in the global toast stack); persisted platform notification (stored in DB, shown in the notification inbox). Each has different persistence, dismissal, and urgency semantics that are currently undocumented.

**G-NOTIF-03 — Callout / persistent notice concept absent**
Carbon's callout is a non-dismissible, non-interactive informational block that loads with the page content. It is not triggered by user action and is not ephemeral. Login App 2.0 has no named equivalent. Similar constructs exist informally on setup and settings pages, but they are not formally defined as a component category.

**G-NOTIF-04 — High-contrast vs low-contrast notification distinction absent**
Carbon recommends high-contrast notification style for urgent or critical conditions and low-contrast for supplemental or informational conditions. Login App 2.0 does not document this distinction.

**G-NOTIF-05 — Notification inbox vs toast routing rule absent**
The notification inbox (persisted platform notifications) and the global toast stack are separate surfaces but no documented rule defines which type of event routes to each.

---

## 4. Badges, Status Pills, and Status Indicators

### What Login App 2.0 currently has
- `ui-status-pill` with semantic variants: `neutral`, `success`, `warning`, `danger`, `info`, `notice`
- Accessibility: "text-first; do not rely on color alone"

### Gaps revealed by Carbon audit

**G-BADGE-01 — Badge color semantic mapping not written down in guidance form**
The semantic token names imply color, but no guidance document maps what each color communicates in user-facing terms. Carbon's status indicator pattern explicitly states: red = error/danger (immediate action); green = success/normal (healthy state); yellow = warning (non-critical issue); blue = informational/in-progress; gray = draft/not-started; purple = undefined/outlier. Login App 2.0 has the `notice` token (no direct Carbon analog), and `danger` maps to Carbon's "error". These mappings should be explicit.

**G-BADGE-02 — Interactive badge variant boundary absent**
Carbon distinguishes tag types by interactivity: read-only tags (categorization, no interaction); dismissible tags (filterable, user-generated content); selectable tags (selection/filter posture); operational tags (overflow display). Login App 2.0's badge contract documents only the passive pill. No guidance exists for when a passive pill should become interactive and which variant that requires.

**G-BADGE-03 — Badge indicator (dot, count) not documented**
The notification inbox widget uses a dot/count badge on the header icon to signal unread items. There is no formal guidance for when to use a numeric count badge vs a dot-only badge vs no badge.

**G-BADGE-04 — WCAG non-text contrast requirement not explicitly linked**
Carbon states that status indicators must use at least two of: color, shape, or symbol — because color alone fails WCAG 2.2 non-text contrast for users with color vision deficiencies. Login App 2.0's badge contract says "text-first" but doesn't explicitly document the WCAG non-text contrast requirement or the two-element rule.

---

## 5. Forms: Fields, Required/Optional, Validation, Helper Text, Field States

### What Login App 2.0 currently has
- Inline validation: errors shown under field; validation summary at top of form when needed
- Required field indicator: "required fields must be indicated consistently (label marker or helper text)"
- Field states: default, focus, error, disabled
- Consistent field spacing and label alignment

### Gaps revealed by Carbon audit

**G-FORM-01 — Required vs optional field marking strategy undefined**
Carbon recommends: if most fields on a form are required, mark only optional fields with "(optional)"; if most fields are optional, mark only required fields with an asterisk or "(required)". This "mark the minority" principle is not documented in Login App 2.0's form standards. The current rule ("indicated consistently") is correct but incomplete.

**G-FORM-02 — Warning field state not referenced**
Carbon documents a "warning" field state distinct from error: the value is valid but may have unintended consequences. Login App 2.0's Tier 1 Input Controls contract covers enabled, active, focus, error, and disabled but not warning.

**G-FORM-03 — Helper text replacement on error not documented**
Carbon specifies that helper text below a field is replaced by the error message when an error state is triggered — they should not coexist. Login App 2.0 has no documented rule for this replacement behavior.

**G-FORM-04 — Inline validation vs validation summary trigger condition undefined**
The form contract says "show errors inline under the field and at the top only when needed for summary." The trigger condition ("when needed") is not defined. Carbon recommends: inline per-field error on blur; summary above the form's action buttons only for complex forms with more than one section or multi-step flows.

---

## 6. Selection Controls

### What Login App 2.0 currently has
- Checkbox, Radio, Toggle, Select: listed in Tier 1 component coverage matrix
- Status: most selection controls are "Not Started" or "In Progress" in the coverage matrix

### Gaps revealed by Carbon audit

**G-SEL-01 — No checkbox vs radio vs toggle usage boundary document**
Carbon distinguishes: **checkbox** (multi-select, independent options, no mutual exclusion); **radio** (single-select, mutually exclusive, recommend ≤ 5 options); **toggle** (immediate on/off effect without requiring form submission). No equivalent Login App 2.0 document defines when to use each.

**G-SEL-02 — No rule for when to use a select vs combo box vs multi-select**
No document in Login App 2.0 defines when to use a plain select vs a combo/search-type-ahead vs a multi-select dropdown.

**G-SEL-03 — Selectable tags as a selection input alternative not addressed**
Carbon's selectable tag is a recognized alternative to checkboxes when the interface uses a tag or chip metaphor for selection. This pattern is not referenced in Login App 2.0's selection guidance.

---

## 7. Starter Page Organization

### What Login App 2.0 currently has
- `/platform/ui-reference/patterns/archetypes` route (existing, documents archetype vocabulary)
- Batch B archetype matrix and shell family matrix (planning docs, not UI Reference views)
- No dedicated "starters" catalog surface

### Gaps revealed by Carbon audit

**G-STARTERS-01 — No discoverable starter catalog entry point**
Carbon's pattern library is organized with a navigable patterns index at the top level of the design system site. Login App 2.0's UI Reference has no top-level "Starters" navigation entry, meaning future agents have no intentional discovery path for concrete starter examples.

**G-STARTERS-02 — No concrete starter page examples exist yet**
All required starter proofs are planned but not yet implemented. The archetype matrix (Batch B) documents the vocabulary; no concrete page-composition views exist at UI Reference routes.

**G-STARTERS-03 — Blocked/empty/unavailable states have no dedicated starter**
Carbon's empty states pattern covers: no-data first use; user-action result (search no results, confirmation); and error management (permissions issue, systems issue, configuration required). Login App 2.0 has no dedicated starter that demonstrates how each of these blocked/empty conditions should appear inside the app's shell and content blocks.

---

## Gap-to-Queue Routing Summary

The following queue items absorb the gaps documented above.

| Gap ID | Description | Queue Item |
| --- | --- | --- |
| G-ACT-01 | No "when to use each variant" rule | P2-F-CQ-008 |
| G-ACT-02 | `soft` vs `outline` selection undefined | P2-F-CQ-008 |
| G-ACT-03 | No explicit "one primary per action row" rule | P2-F-CQ-008 |
| G-ACT-04 | Destructive action emphasis tiers not split | P2-F-CQ-008 |
| G-ACT-05 | No page-level action alignment rule (form vs dialog) | P2-F-CQ-008 |
| G-LABEL-01 | No canonical action label glossary | P2-F-CQ-008 |
| G-LABEL-02 | Apply vs Save vs Submit distinction undocumented | P2-F-CQ-008 |
| G-LABEL-03 | Cancel vs Close behavioral difference not documented | P2-F-CQ-008 |
| G-LABEL-04 | Add vs Create vs New usage rule absent | P2-F-CQ-008 |
| G-LABEL-05 | Delete vs Remove vs Clear distinction absent | P2-F-CQ-008 |
| G-LABEL-06 | Wizard-step label convention not documented | P2-F-CQ-008 |
| G-NOTIF-01 | No inline alert vs toast selection rule | P2-F-CQ-008 |
| G-NOTIF-02 | Same-page AJAX feedback type undefined | P2-F-CQ-008 |
| G-NOTIF-03 | Callout / persistent notice concept absent | P2-F-CQ-008 |
| G-NOTIF-04 | High-contrast vs low-contrast notification distinction | P2-F-CQ-008 |
| G-NOTIF-05 | Notification inbox vs toast routing rule absent | P2-F-CQ-008 |
| G-BADGE-01 | Badge color semantic mapping not explicit | P2-F-CQ-008 |
| G-BADGE-02 | Interactive badge/tag variant boundary absent | P2-F-CQ-008 |
| G-BADGE-03 | Badge indicator (dot, count) not documented | P2-F-CQ-008 |
| G-BADGE-04 | WCAG non-text contrast not explicitly linked | P2-F-CQ-008 |
| G-FORM-01 | Required vs optional marking strategy undefined | P2-F-CQ-008 |
| G-FORM-02 | Warning field state not referenced | P2-F-CQ-008 |
| G-FORM-03 | Helper text replacement on error not documented | P2-F-CQ-008 |
| G-FORM-04 | Inline vs summary validation trigger undefined | P2-F-CQ-008 |
| G-SEL-01 | No checkbox vs radio vs toggle usage boundary | P2-F-CQ-008 |
| G-SEL-02 | No select vs combo box vs multi-select rule | P2-F-CQ-008 |
| G-SEL-03 | Selectable tags as selection input not addressed | P2-F-CQ-008 |
| G-STARTERS-01 | No discoverable starter catalog entry point | P2-F-CQ-007 |
| G-STARTERS-02 | No concrete starter page examples | P2-F-CQ-002 through P2-F-CQ-005 |
| G-STARTERS-03 | No blocked/empty/unavailable starter | P2-F-CQ-005 |

All design-system usage guidance gaps route to **P2-F-CQ-008**. Starter catalog entry point routes to **P2-F-CQ-007**. Concrete starter implementation gaps route to **P2-F-CQ-002 through P2-F-CQ-005**.

---

## Related

- [Phase 2 Batch F - Starter Catalog Matrix](Phase%202%20Batch%20F%20-%20Starter%20Catalog%20Matrix.md)
- [Tier 1 - Buttons And Icon Buttons Contract](../../02-standards/ui/contracts/Tier%201%20-%20Buttons%20And%20Icon%20Buttons%20Contract.md)
- [Tier 1 - Toast And Inline Alert Contract](../../02-standards/ui/contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)
- [Tier 1 - Badges And Status Contract](../../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)
- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
- [Phase 2 - Implementation Batch F](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20F.md)
