# Color Token Implementation Audit

Audit date: 2026-06-10
Latest update: 2026-06-10 global, Button, and Notification/status token alignment passes

Canonical standards compared:

- `docs/02-standards/ui/elements/color.md`
- `docs/02-standards/ui/components/*.md` Carbon color role mapping sections
- `docs/02-standards/ui/patterns/*.md` Carbon color composition mapping sections

Source surfaces inspected:

- `resources/css/app.css`
- `resources/views/**/*.blade.php`
- `resources/js/**/*.js`

This file is support evidence only. The canonical rules remain in `docs/02-standards/ui/`.

## Summary

`resources/css/app.css` has a broad token base. The 2026-06-10 global alias pass resolved the immediate undefined variable and installed the missing global aliases/state roles identified in this audit. The Button alias pass then added canonical secondary, tertiary, danger-tertiary, and danger-ghost action aliases and routed the existing Button class combinations through those aliases. The Notification/status pass added notification-owned inline, toast, trigger, unread, and preview aliases; retained `--ui-alert-*` as compatibility aliases; added Carbon `error` aliases that map to the app's `danger` semantic role; and moved notification menu preview styling off Button/action tokens.

Implemented token-family alignment is now complete for the scoped Color, Button, Notification/status, Link, Code snippet, layer, field, border, support, overlay, skeleton, and on-color roles. Remaining work is implementation consumption, not missing baseline tokens: raw Tailwind color utility migration, removal of the light-theme slate compatibility bridge after consumers are migrated, and gated Carbon role promotion only when the owning component/pattern standards install those capabilities. The first consumption pass migrated the shared shell/sidebar and runtime notification surfaces listed in this audit to app-owned classes.

Current extracted CSS token counts:

| Measure | Count |
| ------- | ----- |
| Unique `--ui-*` definitions in `resources/css/app.css` after Notification/status pass | 409 |
| Unique `--ui-*` references in `resources/css/app.css` after Notification/status pass | 321 |
| Referenced required tokens not defined in `resources/css/app.css` after Notification/status pass | 0 |

The main implementation gaps are:

- Carbon-equivalent state aliases for layer active, selected-hover, and accent-hover are now installed.
- Generic field aliases, on-color text/icon roles, inverse support roles, overlay role, and link secondary/inverse active/visited roles are now installed.
- Button tokens now expose the canonical Button hierarchy roles (`primary`, `secondary`, `tertiary`, `ghost`, `danger`, `danger-tertiary`, `danger-ghost`). Older status-oriented action variants (`success`, `warning`, `notice`, `info`, `soft-*`, and `outline-*`) remain compatibility aliases until their owning standards are narrowed.
- Notification/status tokens now expose `--ui-notification-*` as the canonical full-message feedback surface while `--ui-alert-*` remains a compatibility alias family.
- Raw Tailwind color utility use remains widespread in Blade/JS and is partly masked by a light-theme compatibility override block in `app.css`.

## Current Variable Families

| Family | Count | Current coverage |
| ------ | ----- | ---------------- |
| `--ui-action-*` | 133 | Canonical Button semantic aliases exist for primary, secondary, tertiary, ghost, danger, danger-tertiary, and danger-ghost. Older status/action variants still need ownership review. |
| `--ui-alert-*` | 18 | Compatibility aliases to Notification-owned feedback roles, including Carbon `error` aliases mapped to app `danger`. |
| `--ui-background-*` | 5 | Hover, active, selected, inverse, and brand roles exist. Generic background is exposed through `--ui-background`. |
| `--ui-border-*` | 14 | Subtle, strong, interactive, inverse, disabled, and tile alias roles exist. |
| `--ui-field-*` | 7 | Generic and depth-specific field and field-hover tokens exist. |
| `--ui-focus*` | 4 | Focus, focus ring, inset, and inverse roles exist. |
| `--ui-icon-*` | 7 | Primary, secondary, inverse, disabled, on-color, on-color-disabled, and interactive roles exist. |
| `--ui-layer-*` | 21 | Depth, hover, active, selected, selected-hover, accent, and accent-hover roles exist. |
| `--ui-link-*` / `--ui-link-text*` | 11 | Primary, hover, secondary, inverse, inverse-hover, inverse-active, inverse-visited, visited, and generic aliases exist. |
| `--ui-login-*` | 14 | Login-provider-specific action tokens exist. |
| `--ui-notification-*` | 88 | Inline, toast, trigger, unread, badge, preview, preview-pill, and Carbon `error` aliases exist. |
| `--ui-skeleton-*` | 2 | Skeleton background and element roles exist. |
| `--ui-status-*` | 22 | Status background/text/solid roles exist for neutral/info/success/warning/danger/notice, with Carbon `error` aliases mapped to app `danger`. |
| `--ui-support-*` | 9 | Error, warning, success, info, notice, and inverse error/warning/success/info roles exist. |
| `--ui-switch-*` | 6 | Switch component-specific roles exist. |
| `--ui-syntax-*` / `--ui-code-token-*` | 13 | Existing syntax roles now have canonical code-token aliases, including number and function aliases. |
| `--ui-text-*` | 11 | Primary, secondary, strong, muted, helper, placeholder, error, inverse, disabled, on-color, and on-color-disabled exist. |

## Immediate Defect

| Finding | Evidence | Required correction |
| ------- | -------- | ------------------- |
| `--ui-border-strong` was referenced but not defined. | `resources/css/app.css` referenced `var(--ui-border-strong)` and defined only depth-specific strong border roles. | Resolved: `--ui-border-strong: var(--ui-border-strong-01);` now exists in each theme token block. |

## Missing Canonical Roles

These roles were required by the Carbon-to-Login standards mapping and were added in the global alias pass. Keep them stable while component classes migrate.

| Role group | Tokens | Current status |
| ---------- | ------ | -------------- |
| Layer state | `--ui-layer-active-01..03`, `--ui-layer-selected-hover-01..03`, `--ui-layer-accent-hover-01..03` | Installed in each theme block. |
| Field aliases | `--ui-field`, `--ui-field-hover` | Installed as depth-01 aliases in each theme block. |
| Text on-color | `--ui-text-on-color`, `--ui-text-on-color-disabled` | Installed in each theme block. |
| Icon on-color | `--ui-icon-on-color`, `--ui-icon-on-color-disabled`, `--ui-icon-interactive` | Installed in each theme block. |
| Link aliases | `--ui-link`, `--ui-link-hover`, `--ui-link-secondary`, `--ui-link-inverse-active`, `--ui-link-inverse-visited` | Installed in each theme block. |
| Border aliases | `--ui-border-strong`, `--ui-border-tile` | Installed in each theme block. |
| Inverse support | `--ui-support-error-inverse`, `--ui-support-success-inverse`, `--ui-support-warning-inverse`, `--ui-support-info-inverse` | Installed in each theme block. |
| Overlay | `--ui-overlay` | Installed in each theme block. |
| Code token aliases | `--ui-code-token-*` aliases | Installed and code-token classes now consume the canonical aliases. |
| Button semantic aliases | `--ui-action-secondary-*`, `--ui-action-tertiary-*`, `--ui-action-danger-tertiary-*`, `--ui-action-danger-ghost-*` | Installed in each theme block and consumed by the existing Button class combinations. |
| Notification/status aliases | `--ui-notification-*`, `--ui-notification-toast-*`, `--ui-notification-preview-*`, `--ui-status-error-*`, `--ui-alert-error-*` | Installed in each theme block. Inline alerts, toasts, and notification menu preview styling consume notification-owned aliases. |

## Inconsistent Or Duplicated Role Families

| Area | Current state | Risk | Correction direction |
| ---- | ------------- | ---- | -------------------- |
| Button/action roles | CSS exposes the canonical Button semantic alias surface while retaining `neutral`, `success`, `warning`, `notice`, `info`, `soft-*`, and `outline-*` compatibility roles. | Agents may still use status/action colors as visual Button variants unless ownership is clarified. | Token work is complete; future API cleanup should narrow or deprecate status-colored Button aliases through the Button standard and rendered evidence proof. |
| Notification/status roles | CSS exposes `--ui-notification-*` as the canonical full-message feedback surface and keeps `--ui-alert-*` as compatibility aliases. Compact tag/status pills continue to use `--ui-status-*`. | Feature views can still bypass component APIs with raw utilities. | Token work is complete; migration work should replace raw notification/status styling with `x-ui.notification.inline`, `x-ui.notification.toast`, `x-ui.tag`, `x-ui.status`, or app-owned classes. |
| Link roles | CSS has app-level `--ui-link`, `--ui-link-hover`, secondary, inverse active, inverse visited, and legacy `--ui-link-text*` aliases. | Components may still consume older link names. | Token work is complete; migrate consumers gradually where touched. |
| Surface aliases | CSS has `--ui-canvas`, `--ui-surface`, `--ui-surface-elevated`, `--ui-layer-*`, and `--ui-background-*`. | Background/surface/layer roles may be used interchangeably without depth rules. | Token work is complete; enforce depth usage in component/pattern reviews. |
| Login-provider tokens | CSS has provider-specific login button tokens. | Provider buttons could be mistaken for generic Button hierarchy. | Keep provider tokens as Login Pattern owned exceptions with Button-compatible focus/disabled/on-color roles. No additional generic token work is required. |
| Switch tokens | CSS has switch-specific tokens. | Switch may diverge from Carbon toggle/support roles. | No baseline token expansion until Toggle/Switch component ownership is audited separately against Carbon toggle rows. |

## Raw Color Utility Hotspots

Raw Tailwind color utility classes remain in app and rendered evidence surfaces. Excluding `resources/views/welcome.blade.php`, the post-rendered evidence examples/status/table-index/notifications migration scan found:

| Measure | Count |
| ------- | ----- |
| Files with raw color utility matches | 45 |
| Raw color utility matches | 169 |

Remaining matches by area:

| Area | Matches |
| ---- | ------- |
| rendered evidence | 61 |
| Platform Settings | 48 |
| Other / uncategorized views | 34 |
| Other Platform pages | 13 |
| Platform Docs | 10 |
| Tests | 3 |

Highest-count hotspots:

| File | Matches | Notes |
| ---- | ------- | ----- |
| `resources/views/platform/settings/general-system-update.blade.php` | 7 | Platform Settings form/surface page. |
| `resources/views/platform/docs/index.blade.php` | 7 | Platform docs index surface. |
| `resources/views/platform/settings/general-email.blade.php` | 7 | Platform Settings form/surface page. |
| `resources/views/platform/settings/general-localization.blade.php` | 7 | Platform Settings form/surface page. |
| `retired reference viewer path` | 7 | rendered evidence index drawer proof. |
| `resources/views/platform/settings/general-company-information.blade.php` | 7 | Platform Settings form/surface page. |
| `retired reference viewer path` | 6 | rendered evidence table state proof. |
| `resources/views/platform/settings/notifications.blade.php` | 5 | Platform Settings notification page. |
| `retired reference viewer path` | 5 | rendered evidence component catalog overview. |
| `retired reference viewer path` | 5 | rendered evidence index drawer proof. |
| `retired reference viewer path` | 5 | rendered evidence layout pattern examples. |
| `retired reference viewer path` | 5 | rendered evidence starter catalog examples. |
| `retired reference viewer path` | 5 | rendered evidence audit table proof. |
| `retired reference viewer path` | 5 | rendered evidence error table proof. |
| `retired reference viewer path` | 5 | rendered evidence workspace table proof. |

The light-theme compatibility block in `app.css` remaps slate utility classes at runtime:

- `.bg-slate-*`
- `.border-slate-*`
- `.text-slate-*`
- `.placeholder:text-slate-*`
- `.shadow-black/*`

That block is a compatibility bridge, not standards-compliant implementation. It is still required because 169 targeted raw utility matches remain outside the migrated shell/runtime/forms/actions/overlays/navigation/user-form/log/rendered evidence example/notification files. Remove it only after raw color utility consumers are migrated to app-owned `ui-*` classes and token roles.

## Gated Carbon Roles Not To Implement Yet

| Role family | Status | Rule |
| ----------- | ------ | ---- |
| Tag all-color component token families (`$tag-background-*`, `$tag-color-*`, `$tag-hover-*`, `$tag-border-*`) | Needs verification | Do not create local tag palettes until the source-inferred rows are verified and promoted. |
| Popover inverse container mapping | Needs verification | Do not standardize inverse popovers until the Carbon row is verified. |
| AI token families (`$ai-*`) | Not adopted | Do not add baseline app tokens or apply AI chrome to non-AI components. |
| Content switcher component tokens | Component-specific / not currently in the scoped implementation list | Do not express as generic Tabs/Button roles unless a Content switcher component standard maps them. |
| Data table batch action bar (`$background-brand`, `$text-on-color`) | Gated by batch action implementation | Add on-color roles now if needed, but do not create batch bars until Data table batch action behavior is installed. |

## Recommended Implementation Order

1. Done: replace raw color utility clusters in the shared shell/sidebar and runtime JS first:
   - `resources/views/components/layouts/app/sidebar.blade.php`
   - `resources/views/components/layouts/mobile-sidebar.blade.php`
   - `resources/views/platform/settings/_sidebar.blade.php`
   - `resources/js/ui-controls/ui-shell.js`
   - `resources/js/realtime-notifications.js`
2. Done: migrate the top rendered evidence and production hotspots:
   - `retired reference viewer path`
   - `retired reference viewer path`
   - `retired reference viewer path`
   - `retired reference viewer path`
   - `resources/views/platform/users/partials/form.blade.php`
   - `resources/views/platform/error-logs/index.blade.php`
   - `resources/views/platform/error-logs/show.blade.php`
   - `resources/views/platform/audit-logs/index.blade.php`
   - `resources/views/platform/audit-logs/show.blade.php`
3. Done: migrate the remaining top rendered evidence table/index/status/example hotspots and `resources/views/platform/notifications/index.blade.php`.
4. Continue with Platform Settings pages, rendered evidence drawer/table proof partials, Platform Docs index, component overview, layout, and starter catalog surfaces.
5. Remove the light-theme slate compatibility override only after raw utility consumers are eliminated or intentionally exempted.

## Validation Guidance For The Next Pass

Use focused checks only:

- CSS source assertions for required aliases and absence of new raw color utilities in changed files.
- Component-specific feature tests only for touched rendered evidence/component routes.
- `npm run lint:docs:guardrails` if docs are updated.
- `npm run build` after CSS/JS changes.

Do not run the full rendered evidence feature file for this audit or for narrow token-alias edits.
