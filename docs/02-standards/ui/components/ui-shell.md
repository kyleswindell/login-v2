---
title: UI shell
slug: ui-shell
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial-pattern-owned
category: shell
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/ui-shell.md
source_owner: not installed
blade_api: []
javascript_api: []
data_attributes: []
source_files:
  - resources/views/layouts/app.blade.php
  - resources/css/app.css
  - not installed
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
  - 2x-grid
related_components:
  - breadcrumb
  - button
  - icon-button
  - link
  - menu-buttons
  - notification
  - tooltip
  - modal
related_patterns:
  - navigation
  - layout
  - tables
  - overlays-feedback
architecture_owner: docs/03-architecture/workspace-navigation-and-frame-composition.md
carbon_reference:
  - https://carbondesignsystem.com/components/UI-shell-header/usage/
  - https://carbondesignsystem.com/components/UI-shell-header/accessibility/
  - https://carbondesignsystem.com/components/UI-shell-left-panel/usage/
  - https://carbondesignsystem.com/components/UI-shell-right-panel/usage/
  - https://carbondesignsystem.com/patterns/global-header/
---

# UI shell Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. ### Canonical API responsibilities:](#11--canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
  - [2.1. Phase 6 architecture mapping](#21-phase-6-architecture-mapping)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed regions:](#32-installed-regions)
- [4. Public API](#4-public-api)
  - [4.1. API status](#41-api-status)
  - [4.2. Canonical shell composition](#42-canonical-shell-composition)
  - [4.3. Header baseline](#43-header-baseline)
  - [4.4. Left panel](#44-left-panel)
  - [4.5. Account menu and utility actions](#45-account-menu-and-utility-actions)
  - [4.6. Mobile/collapsed behavior](#46-mobilecollapsed-behavior)
  - [4.7. Public class contract](#47-public-class-contract)
  - [4.8. Reserved future Blade contract](#48-reserved-future-blade-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use UI shell when:](#91-use-ui-shell-when)
  - [9.2. Do not use UI shell when:](#92-do-not-use-ui-shell-when)
  - [9.3. Configuration selection:](#93-configuration-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

UI shell frames the global app experience with persistent orientation, navigation, account access, utility actions, skip-link behavior, and responsive shell regions.

Canonical API owner: `not installed`. Use this Component API entry instead of creating local markup, styling, or behavior for the same shell role.

UI shell is an installed, pattern-owned Component API. The component catalog route documents the shell contract, but production ownership belongs to the Navigation Pattern at `not installed`. Feature work must not create page-local headers, sidebars, mobile drawers, account menus, notification action areas, skip links, or responsive shell wrappers. The app layout and Navigation Pattern render those Frame regions; Core Navigation owns authoritative Product and Product Area resolution.

### 1.1. ### Canonical API responsibilities:

- Frame the authenticated app experience with a persistent shell root.
- Preserve header, left panel, account menu, utility/action area, main content, and responsive collapse behavior.
- Provide a skip link to the main content region.
- Preserve current-location state for global and local navigation.
- Preserve predictable keyboard order from skip link to header, navigation, utility actions, main content, and any open panel.
- Preserve responsive collapse and overflow behavior through the Navigation Pattern.
- Keep shell landmarks, labels, focus-visible behavior, icon labels, and reduced-motion behavior consistent.
- Consume Foundation Element APIs for color, spacing, typography, themes, icons, motion, and 2x Grid.
- Prove header baseline, left panel, account menu, notification/action area, mobile/collapsed behavior, and deferred right-panel behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Page-specific headings, page actions, breadcrumbs, route-level page tabs, and page-level layout. Use `x-shell.page-header` for the shell page header composition and the owning Layout or Navigation Pattern for page placement.
- Table action bars, filter bars, and row actions. Use Table toolbar and Data table Patterns.
- Modal, drawer, overlay, inert-state, and focus-trap behavior outside the shell navigation contract. Use Modal and Overlay/feedback Patterns.
- Inline command styling. Use Button, Icon button, Link, or Menu buttons.
- Long-form status messages. Use Notification.
- Task progress, step progress, or workflow status. Use Progress indicator when installed; do not repurpose shell navigation.
- Route authorization, user role resolution, unread notification counts, and account data retrieval.
- Feature-local shell variants.

Carbon alignment note: Carbon describes UI shell as a persistent navigation framework made from header, left panel, and right panel pieces that can work independently or together. Carbon positions the header as the highest-level navigation, the left panel as optional product navigation, and the right panel as additional system-level actions tied to header icons. Login App maps those principles to a Navigation Pattern-owned shell, app-owned `ui-*` classes, Laravel layout composition, Foundation Element tokens, and rendered evidence proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                                                   |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                            |
| System maturity              | Partial, pattern-owned                                                                                                                  |
| API layer                    | Component API                                                                                                                           |
| Component slug               | ui-shell                                                                                                                                |
| Category                     | Shell                                                                                                                                   |
| Priority                     | Tier A - Baseline app development                                                                                                       |
| Rendered evidence route           | `not installed`                                                                                            |
| Canonical doc                | `docs/02-standards/ui/components/ui-shell.md`                                                                                           |
| Source owner                 | `not installed`                                                                                            |
| Blade API                    | No standalone public `x-ui.shell` wrapper is approved                                                                                   |
| JavaScript API               | No public JavaScript controller or initializer is approved                                                                              |
| Data attributes              | None approved as a public Component API                                                                                                 |
| Props/options                | No public Blade props; shell options are Navigation Pattern-owned layout modes and classes                                              |
| Source files                 | `resources/views/layouts/app.blade.php`; `resources/css/app.css`; `not installed` |
| CSS namespace                | App-owned `ui-shell*` classes documented by the implementation                                                                          |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid                                                                              |
| Carbon benchmark             | Carbon UI shell header, left panel, right panel, accessibility, and global header guidance                                              |

`Approved API` means the shell experience and Rendered evidence route exist, but the canonical documentation, rendered examples, and regression tests must be corrected to replace placeholder copy with the installed shell and Navigation Pattern contract.

`Pattern-owned` means the component catalog documents the role and proof requirements, while production composition and shell behavior are owned by `not installed` and the app layout.

### 2.1. Phase 6 architecture mapping

The architecture term **Frame** describes the persistent authenticated structure. **UI shell** remains the installed UI implementation and API term.

- the global header and sidebar are named Frame regions;
- Global Header Navigation and Sidebar Navigation are Frame Surfaces;
- Main is a route-owned content outlet and is not a Frame Surface;
- Workspace composition supplies Product scope;
- Core Navigation resolves Product and Product Area Contributions;
- Access and Module lifecycle provide authoritative inputs;
- UI shell renders normalized data and must not evaluate permissions, Module state, Product behavior, or Contributor implementation.

The accepted initial sidebar model preserves B-class sibling Products while exposing one C-class Product Area level for the active Product. D-class Pages and deeper destinations remain outside persistent shell navigation by default.

This mapping preserves every installed `ui-shell*` class, public API status, example, state, modifier, and proof requirement already defined below. Phase 6 does not authorize a visual redesign or a class/API rename.

## 3. Installed standard

The installed standard is a Navigation Pattern-owned shell composition, represented by app layout markup and app-owned `ui-shell*` classes.

Use UI shell for the authenticated app frame only. The shell should be rendered once by the app layout, not recreated by pages or features.

### 3.1. Installed production rules:

- Render the shell through the app layout and Navigation Pattern, not through feature-local markup.
- Use `ui-shell` as the shell root.
- Use `ui-shell__skip-link` as the first focusable item in the authenticated shell.
- Use `ui-shell__header` for the persistent global header.
- Use `ui-shell__brand` for the app/product name link.
- Use `ui-shell__nav` for primary/global navigation when rendered in the header.
- Use `ui-shell__actions` for header utility actions such as notifications, help, settings, and account access.
- Use `ui-shell__account` for the account menu trigger and menu composition when present.
- Use `ui-shell__sidebar` for the left panel/product navigation.
- Use `ui-shell__main` for the main content region and make it the skip-link target.
- Use `aria-current="page"` for the current route link and approved current-state classes for visual treatment.
- Use icon-only header actions only through the installed Button/Icon button/Menu buttons APIs with accessible names.
- Use `aria-expanded`, `aria-controls`, and visible focus for shell toggles when the Navigation Pattern exposes collapsible regions.
- Use responsive collapse only through the installed shell/navigation classes and Pattern behavior.
- Keep only one mobile/overlay shell panel open at a time unless a future Pattern update explicitly supports multiple panels.
- Keep shell motion token-backed and respect reduced-motion preferences.
- Treat the right panel as deferred unless the Navigation Pattern installs it with focus, dismissal, anchoring, and accessibility proof.
- Parent pages own content inside `ui-shell__main` only. They do not own header, sidebar, or shell utilities.
- Do not create page-local shell wrappers, local sidebars, local header utility clusters, local account menus, direct Carbon classes, Bootstrap navbars, or feature-local shell JavaScript.

### 3.2. Installed regions:

| Region                   | Status                            | Owner                                    | Use                                                                   |
| ------------------------ | --------------------------------- | ---------------------------------------- | --------------------------------------------------------------------- |
| Shell root               | Implemented                       | App layout / Navigation Pattern          | Frames the authenticated app experience.                              |
| Skip link                | Implemented                       | UI shell                                 | First focusable bypass link to main content.                          |
| Header baseline          | Implemented                       | UI shell / Navigation Pattern            | Persistent global orientation, brand, global nav, utility actions.    |
| Header navigation        | Implemented / Pattern-owned       | Navigation Pattern                       | Global or top-level app navigation.                                   |
| Left panel               | Implemented / Pattern-owned       | Navigation Pattern                       | Secondary/product navigation.                                         |
| Account menu             | Implemented / Menu-owned behavior | Navigation Pattern + Menu buttons        | Account identity and account/user actions.                            |
| Notification/action area | Implemented / Pattern-owned       | Navigation Pattern + Button/Notification | Utility actions and compact notification entry points.                |
| Main content region      | Implemented                       | App layout                               | Page content target and skip-link destination.                        |
| Mobile/collapsed shell   | Implemented / Pattern-owned       | Navigation Pattern                       | Responsive disclosure of navigation/actions.                          |
| Right panel              | Deferred                          | Navigation Pattern                       | Future system panel/switcher region; do not fake production controls. |
| Workspace switcher       | Deferred                          | Navigation Pattern                       | Future A-class Workspace switching behavior; not installed as a shell component today. |

## 4. Public API

### 4.1. API status

The current public API is layout markup plus app-owned CSS classes. A dedicated Blade component such as `x-ui.shell`, `x-ui.shell-header`, or `x-ui.shell-sidebar` is reserved for a future correction pass and must not be used in production until installed, documented, rendered in rendered evidence, and tested.

| API surface           | Installed value                                                                                                                         |
| --------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| Blade                 | No standalone public shell Blade wrapper approved                                                                                       |
| Layout owner          | App layout and `not installed`                                                                             |
| JavaScript            | No public shell JavaScript controller or initializer approved                                                                           |
| Data attributes       | None approved as a public shell behavior API                                                                                            |
| Props/options         | No Blade props; use Pattern-owned layout modes and documented classes                                                                   |
| Root semantic element | Native landmarks: header, nav, main, aside where appropriate                                                                            |
| CSS namespace         | `ui-shell*`                                                                                                                             |
| Source files          | `resources/views/layouts/app.blade.php`; `resources/css/app.css`; `not installed` |

Feature views may render content inside the shell’s main slot/region only. They must not instantiate or override the shell frame.

### 4.2. Canonical shell composition

```blade
<div class="ui-shell ui-shell--with-sidebar">
    <a class="ui-shell__skip-link" href="#main-content">
        Skip to main content
    </a>

    <header class="ui-shell__header" role="banner">
        <button
            class="ui-shell__menu-toggle"
            type="button"
            aria-label="Open navigation"
            aria-controls="app-sidebar"
            aria-expanded="false"
        >
            <span class="ui-shell__icon" aria-hidden="true"></span>
        </button>

        <a class="ui-shell__brand" href="{{ route('dashboard') }}">
            Login App
        </a>

        <nav class="ui-shell__nav" aria-label="Primary navigation">
            <a class="ui-shell__nav-link" href="{{ route('dashboard') }}" aria-current="page">
                Dashboard
            </a>
            <a class="ui-shell__nav-link" href="{{ url('#') }}">
                rendered evidence
            </a>
        </nav>

        <div class="ui-shell__actions" aria-label="Header actions">
            <x-ui.icon-button
                icon="notification"
                label="Open notifications"
                semantic="ghost"
            />

            <x-ui.icon-button
                icon="user"
                label="Open account menu"
                semantic="ghost"
            />
        </div>
    </header>

    <aside class="ui-shell__sidebar" id="app-sidebar" aria-label="Section navigation">
        <nav class="ui-shell__sidebar-nav" aria-label="rendered evidence navigation">
            <a class="ui-shell__sidebar-link" href="{{ url('#') }}" aria-current="page">
                Components
            </a>
            <a class="ui-shell__sidebar-link" href="{{ url('#') }}">
                Patterns
            </a>
        </nav>
    </aside>

    <main class="ui-shell__main" id="main-content" tabindex="-1">
        {{ $slot ?? '' }}
    </main>
</div>
```

This markup documents the canonical ownership boundary. Production may use the app layout instead of a literal slot, but must preserve the same semantics, labels, current-state behavior, and class family.

### 4.3. Header baseline

```blade
<header class="ui-shell__header" role="banner">
    <a class="ui-shell__brand" href="{{ route('dashboard') }}">
        Login App
    </a>

    <nav class="ui-shell__nav" aria-label="Primary navigation">
        <a class="ui-shell__nav-link" href="{{ route('dashboard') }}" aria-current="page">
            Dashboard
        </a>
    </nav>

    <div class="ui-shell__actions" aria-label="Header actions">
        <x-ui.icon-button icon="notification" label="Open notifications" semantic="ghost" />
        <x-ui.icon-button icon="user" label="Open account menu" semantic="ghost" />
    </div>
</header>
```

Header links and icon actions must use installed Link, Button, Icon button, and Menu buttons behavior. Header utility icons require accessible names and visible focus.

### 4.4. Left panel

```blade
<aside class="ui-shell__sidebar" id="app-sidebar" aria-label="Section navigation">
    <nav class="ui-shell__sidebar-nav" aria-label="Platform navigation">
        <a class="ui-shell__sidebar-link" href="{{ url('#') }}" aria-current="page">
            Components
        </a>
        <a class="ui-shell__sidebar-link" href="{{ url('#') }}">
            Patterns
        </a>
    </nav>
</aside>
```

Use the left panel when the product area needs secondary navigation that should remain visible or easy to revisit. Do not create more than two practical navigation levels in the shell sidebar; deeper navigation belongs inside the page through Tabs, Breadcrumb, or the owning Pattern.

### 4.5. Account menu and utility actions

```blade
<div class="ui-shell__actions" aria-label="Header actions">
    <x-ui.icon-button
        icon="help"
        label="Open help"
        semantic="ghost"
    />

    <x-ui.icon-button
        icon="notification"
        label="Open notifications"
        semantic="ghost"
    />

    {{-- Menu behavior is owned by Menu buttons or the Navigation Pattern. --}}
    <x-ui.icon-button
        icon="user"
        label="Open account menu"
        semantic="ghost"
    />
</div>
```

Account menu disclosure, keyboard navigation, dismissal, and focus return must be owned by Menu buttons or the Navigation Pattern. Feature views must not attach local account-menu JavaScript.

### 4.6. Mobile/collapsed behavior

```blade
<button
    class="ui-shell__menu-toggle"
    type="button"
    aria-label="Open navigation"
    aria-controls="app-sidebar"
    aria-expanded="false"
>
    <span class="ui-shell__icon" aria-hidden="true"></span>
</button>
```

The disclosure button must update `aria-expanded` when the panel opens or closes. The Navigation Pattern owns how this state is updated. The UI shell standard owns the required semantics and proof.

### 4.7. Public class contract

| Class                         | Type                  | Status                               | Purpose                                       |
| ----------------------------- | --------------------- | ------------------------------------ | --------------------------------------------- |
| `ui-shell`                    | Root                  | Implemented                          | Authenticated app shell wrapper.              |
| `ui-shell--with-sidebar`      | Layout modifier       | Implemented                          | Shell includes left panel.                    |
| `ui-shell--header-only`       | Layout modifier       | Implemented / required proof         | Header-only shell configuration.              |
| `ui-shell--sidebar-collapsed` | State/layout modifier | Implemented / Pattern-owned          | Collapsed left panel state.                   |
| `ui-shell--mobile-open`       | State/layout modifier | Implemented / Pattern-owned          | Mobile navigation open state.                 |
| `ui-shell__skip-link`         | Element               | Implemented                          | First focusable bypass link to main content.  |
| `ui-shell__header`            | Region                | Implemented                          | Persistent global header.                     |
| `ui-shell__brand`             | Element               | Implemented                          | Product/app name link.                        |
| `ui-shell__menu-toggle`       | Control               | Implemented / Pattern-owned behavior | Opens/closes navigation panel.                |
| `ui-shell__nav`               | Region                | Implemented                          | Header/global navigation.                     |
| `ui-shell__nav-link`          | Element               | Implemented                          | Header navigation link.                       |
| `ui-shell__actions`           | Region                | Implemented                          | Header utility/action cluster.                |
| `ui-shell__account`           | Region/control        | Implemented / Menu-owned behavior    | Account menu trigger or wrapper.              |
| `ui-shell__sidebar`           | Region                | Implemented                          | Left panel navigation.                        |
| `ui-shell__sidebar-nav`       | Region                | Implemented                          | Navigation inside left panel.                 |
| `ui-shell__sidebar-link`      | Element               | Implemented                          | Left panel link.                              |
| `ui-shell__sidebar-group`     | Element               | Implemented / Pattern-owned          | Group of related sidebar links.               |
| `ui-shell__main`              | Region                | Implemented                          | Main content region and skip-link target.     |
| `ui-shell__scrim`             | Element               | Implemented / Pattern-owned          | Mobile overlay/scrim when navigation is open. |
| `ui-shell__right-panel`       | Region                | Deferred                             | Future right-side system panel.               |
| `ui-shell__switcher`          | Region                | Deferred                             | Future product/property switcher.             |

Feature views must not create additional `ui-shell-*`, `app-shell-*`, `navbar-*`, `sidebar-*`, or local shell classes. New classes require source implementation, this standard update, rendered evidence proof, and tests.

### 4.8. Reserved future Blade contract

| Reserved API              | Current status | Gate                                                                                                      |
| ------------------------- | -------------- | --------------------------------------------------------------------------------------------------------- |
| `x-ui.shell`              | Deferred       | Requires source file, slot contract, layout options, landmark behavior, rendered evidence examples, and tests. |
| `x-ui.shell-header`       | Deferred       | Requires brand/nav/action slots, current-state mapping, icon action rules, and tests.                     |
| `x-ui.shell-sidebar`      | Deferred       | Requires item data contract, nested group rules, responsive/collapse behavior, and tests.                 |
| `x-ui.shell-account-menu` | Deferred       | Requires Menu buttons integration, accessible labels, dismissal, focus return, and tests.                 |
| `x-ui.shell-right-panel`  | Deferred       | Requires anchoring, open/closed state, focus management, dismissal, responsive behavior, and tests.       |
| `x-ui.shell-switcher`     | Deferred       | Requires switcher semantics, placement rules, item grouping, keyboard behavior, and tests.                |

Do not create feature-local Blade components with these names.

## 5. Allowed variants, options, and modifiers

| Name                     | Type                  | Status                            | API                                                            | Notes                                                             |
| ------------------------ | --------------------- | --------------------------------- | -------------------------------------------------------------- | ----------------------------------------------------------------- |
| Header baseline          | Region                | Implemented                       | `ui-shell__header`                                             | Persistent top shell region.                                      |
| Header only              | Layout                | Implemented / required proof      | `ui-shell--header-only`                                        | Simple shell without left panel.                                  |
| Header with left panel   | Layout                | Implemented                       | `ui-shell--with-sidebar`                                       | Default app shell when secondary navigation is needed.            |
| Left panel               | Region                | Implemented / Pattern-owned       | `ui-shell__sidebar`                                            | Product/section navigation.                                       |
| Account menu             | Composition           | Implemented / Menu-owned behavior | `ui-shell__account` plus Menu buttons                          | Account actions and identity access.                              |
| Notification/action area | Composition           | Implemented                       | `ui-shell__actions` plus Icon button/Notification entry points | Header utility actions.                                           |
| Skip link                | Accessibility feature | Implemented                       | `ui-shell__skip-link`                                          | First focusable item.                                             |
| Main content region      | Landmark              | Implemented                       | `ui-shell__main`                                               | Page content and skip-link target.                                |
| Current location         | State                 | Implemented                       | `aria-current="page"` plus current class                       | Current nav item.                                                 |
| Keyboard navigation      | Behavior              | Implemented                       | Native links/buttons and Menu buttons behavior                 | Logical focus order and activation.                               |
| Responsive collapse      | Behavior/layout       | Implemented / Pattern-owned       | `ui-shell--sidebar-collapsed`, `ui-shell--mobile-open`         | Navigation Pattern owns state changes.                            |
| Overflow handling        | Behavior/layout       | Implemented / Pattern-owned       | documented shell classes                                       | Keeps nav/actions usable at narrow widths.                        |
| Mobile drawer/scrim      | Composition           | Implemented / Pattern-owned       | `ui-shell__scrim`                                              | Used only by Navigation Pattern.                                  |
| Right panel              | Region                | Deferred                          | `ui-shell__right-panel` reserved                               | Do not render fake right-panel controls as production UI.         |
| Product switcher         | Region/control        | Deferred                          | `ui-shell__switcher` reserved                                  | Requires right-panel gate.                                        |
| Third navigation tier    | Behavior              | Not allowed in shell              | none                                                           | Use in-page Tabs/Breadcrumb/Pattern.                              |
| Local shell variant      | Variant               | Not allowed                       | none                                                           | Do not create page-local shells.                                  |
| Custom header utility    | Extension             | Gated                             | none                                                           | Requires action owner, icon label, focus, and rendered evidence proof. |
| Shell loading state      | State                 | Not applicable                    | none                                                           | Loading belongs inside page content or specific actions.          |
| Shell validation state   | State                 | Not applicable                    | none                                                           | Validation belongs to Forms Pattern and fields.                   |

## 6. States

| State                      | Status                                  | Implementation requirement                                                                                          |
| -------------------------- | --------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Default                    | Implemented                             | Renders header, main content region, skip link, and any configured navigation regions.                              |
| Current location           | Implemented                             | Current route uses `aria-current="page"` and token-backed current-state styling.                                    |
| Hover                      | Implemented for interactive shell items | Header links, sidebar links, and icon actions use token-backed hover treatment.                                     |
| Focus-visible              | Implemented                             | All shell links, buttons, menu triggers, and skip link have visible focus in every supported theme.                 |
| Active/pressed             | Implemented                             | Menu toggles and header actions use token-backed active treatment while activated.                                  |
| Keyboard navigation        | Implemented                             | Tab order starts with skip link and follows visible shell order before main content interactions.                   |
| Skip-link visible on focus | Implemented                             | Skip link appears when focused and moves focus/viewport to main content.                                            |
| Expanded/collapsed         | Implemented / Pattern-owned             | Collapsible navigation toggles update visual state and `aria-expanded`.                                             |
| Open/closed                | Implemented / Pattern-owned             | Mobile navigation, account menu, and action panels expose open/closed state through owning APIs.                    |
| Responsive collapse        | Implemented / Pattern-owned             | Header nav and left panel adapt at narrow widths without page-local overrides.                                      |
| Overflow                   | Implemented / Pattern-owned             | Header actions and nav items remain reachable; hidden overflow must have an approved disclosure path.               |
| Disabled                   | Limited / child-owned                   | Shell-level regions are not disabled. Individual actions may be disabled through Button/Menu APIs.                  |
| Loading                    | Not applicable                          | Loading belongs to page regions, menu content, or individual actions, not the shell root.                           |
| Validation                 | Not applicable                          | Validation belongs to forms and fields.                                                                             |
| Read-only                  | Not applicable                          | Shell navigation is not read-only data.                                                                             |
| Empty                      | Not applicable                          | A shell without brand, main content, or navigation/accessibility landmarks is invalid.                              |
| Error/warning/success/info | Not owned by shell                      | Use Notification or page status. Header notification entry points may expose counts only through owning components. |
| Reduced motion             | Implemented                             | Collapse/open animations respect reduced-motion preferences.                                                        |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

UI shell consumes Foundation Color, Spacing, Typography, Themes, Icons, Motion, and 2x Grid.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.
- Motion.
- 2x Grid.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                                  |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Color       | Header surface, sidebar surface, borders, current state, hover, active, focus, icon, text, inverse/dark theme roles, and scrim/overlay roles when Pattern-owned.               |
| Spacing     | Header height, action target spacing, nav item padding, sidebar width/gaps, skip-link offset, main content offset, mobile drawer spacing, and shell-to-content grid alignment. |
| Typography  | Brand text, navigation labels, account labels, utility labels, sidebar group headings, and menu labels.                                                                        |
| Themes      | Light, dark, and inverse token resolution for shell zones and nested controls.                                                                                                 |
| Icons       | Internal icon components for menu toggle, account, notifications, help, settings, and utility actions.                                                                               |
| Motion      | Collapse/open transitions, menu toggle feedback, sidebar reveal, scrim fade, and reduced-motion behavior.                                                                      |
| 2x Grid     | Main content alignment, page gutters, shell offsets, sidebar/content relationship, and responsive layout zones.                                                                |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-shell
.ui-shell--with-sidebar
.ui-shell--header-only
.ui-shell--sidebar-collapsed
.ui-shell--mobile-open
.ui-shell__skip-link
.ui-shell__header
.ui-shell__brand
.ui-shell__menu-toggle
.ui-shell__icon
.ui-shell__nav
.ui-shell__nav-link
.ui-shell__actions
.ui-shell__account
.ui-shell__sidebar
.ui-shell__sidebar-nav
.ui-shell__sidebar-link
.ui-shell__sidebar-group
.ui-shell__main
.ui-shell__scrim
.ui-shell__right-panel
.ui-shell__switcher
```

Feature views must not create `app-shell-*`, `layout-shell-*`, `navbar-*`, `sidebar-*`, Bootstrap `.navbar`, Bootstrap `.offcanvas`, direct Carbon classes, raw utility clusters, arbitrary positioning, hard-coded z-index stacks, raw colors, arbitrary spacing, local icon sources, custom focus rings, or feature-local shell JavaScript for the same UI role.

### 7.4. Helper usage

| Helper/mechanism             | Status                                     | Rule                                                                                                     |
| ---------------------------- | ------------------------------------------ | -------------------------------------------------------------------------------------------------------- |
| Laravel app layout           | Approved owner                             | Owns the single production shell frame.                                                                  |
| Route helpers                | Approved                                   | Use for shell links; do not hard-code app URLs in shell navigation.                                      |
| Authorization checks         | Approved / app-owned                       | Use to include or omit shell items by role; do not render inaccessible links only to hide them visually. |
| `aria-current="page"`        | Required for current page link             | Use for the current destination only.                                                                    |
| `aria-expanded`              | Required for shell toggles                 | Must reflect open/closed state.                                                                          |
| `aria-controls`              | Required for shell toggles where practical | Must reference the controlled panel ID.                                                                  |
| `aria-label`                 | Required for icon-only shell actions       | Labels must describe the action.                                                                         |
| Skip link target             | Required                                   | Must point to the main content region.                                                                   |
| `tabindex="-1"` on main      | Approved                                   | Allows programmatic focus after skip link when implementation needs it.                                  |
| Public shell data attributes | Not approved                               | Add only through a future documented behavior gate.                                                      |
| Feature-local JavaScript     | Not approved                               | Disclosure behavior belongs to Navigation Pattern or installed components.                               |

## 8. Composition rules

- Render the shell once at the app layout level.
- Keep the shell persistent across authenticated app pages.
- Put page content inside `ui-shell__main` only.
- Put global/product orientation in the header.
- Put secondary/product navigation in the left panel when the product area needs persistent secondary links.
- Put user/account actions in the account menu.
- Put utility actions such as notifications, help, settings, or global search in the header action area only when those actions are installed and labeled.
- Put page-level actions in Page header, not in the shell header, unless the action is global to the application.
- Compose page breadcrumbs, page title, page subtitle, and page-title actions through `x-shell.page-title` inside `x-shell.page-header`.
- Compose route-level page navigation through `x-shell.page-tabs` inside `x-shell.page-header`; do not replace it with `x-ui.tabs`, which owns in-page tab-panel behavior.
- Use one current-location indicator per navigation set.
- Use native landmarks: `header`, `nav`, `aside`, and `main` where appropriate.
- Use native links for navigation and native buttons for disclosure/actions.
- Use Menu buttons for account and dropdown behavior.
- Use Icon button for icon-only header actions.
- Use Notification for messages and alerts, not custom shell banners.
- Use Modal/Overlay Patterns for blocking overlay behavior outside navigation.
- Keep left panel navigation to practical depth. Do not create a third shell-navigation tier.
- Ensure mobile/collapsed navigation has a visible trigger, accessible name, open/closed state, and dismissal path.
- Keep focus order stable when panels open or close.
- Do not hide navigation or actions without an approved overflow/disclosure path.
- Do not use shell navigation for task progress or step completion.
- Parent Patterns own page content, page header placement, and workflow orchestration inside main.
- UI shell and Navigation Pattern own header, side navigation, mobile collapse, utility regions, landmarks, and shell-level responsive behavior.

## 9. Selection guidance

### 9.1. Use UI shell when:

- A page belongs to the authenticated app experience.
- Users need persistent orientation across app pages.
- Users need global navigation, product navigation, account access, or utility actions.
- The page needs a consistent skip link and main content target.
- The page lives inside the same app frame as the rest of Login App 2.0.

### 9.2. Do not use UI shell when:

- Rendering public/auth pages such as login, register, password recovery, or standalone marketing pages unless the app explicitly installs a public shell variant.
- Rendering modal content, embedded widgets, print views, export views, or email templates.
- Creating a one-off admin section header or feature-specific sidebar.
- Representing workflow steps or task progress.
- Building local tabs, content switchers, or section navigation inside a page.
- The interaction is a menu, modal, notification, or page action owned by another Component or Pattern.

### 9.3. Configuration selection:

| Need                                                                     | Use                                                       |
| ------------------------------------------------------------------------ | --------------------------------------------------------- |
| Simple authenticated app area with few global destinations               | Header baseline or header-only shell.                     |
| Product area with more secondary destinations or frequent peer switching | Header with left panel.                                   |
| Account/user actions                                                     | Account menu through Navigation Pattern and Menu buttons. |
| Utility actions such as notifications/help/settings                      | Header action area with Icon button/Menu buttons.         |
| Long secondary navigation with nested sections                           | Left panel with approved grouping; no third shell tier.   |
| Narrow viewport navigation                                               | Pattern-owned mobile/collapsed shell.                     |
| Additional system-level panel tied to a header icon                      | Deferred right panel gate.                                |
| Product/property switcher                                                | Deferred switcher/right-panel gate.                       |
| Page-specific actions                                                    | `x-shell.page-header` plus Page header Pattern ownership. |
| Route-level page navigation                                              | `x-shell.page-tabs` through `x-shell.page-header`.        |
| In-page peer switching                                                   | Tabs or Content switcher when installed.                  |

## 10. Accessibility contract

- The shell must provide a skip link as the first focusable item in the authenticated app frame.
- The skip link must become visible on focus and move the user to the main content region.
- The main content region must use a native `main` element and a stable ID target.
- The header must use native `header` semantics or an equivalent banner landmark when required by the layout.
- Navigation sets must use native `nav` elements with accessible labels.
- The left panel must have an accessible label that describes its navigation scope.
- Header icon-only actions must have accessible names that describe the action, not the icon.
- Header icon-only actions should reveal the name on hover/focus through Tooltip or the owning component when applicable.
- Shell disclosure controls must use native buttons, not links or divs.
- Shell disclosure controls must expose `aria-expanded` and `aria-controls` where they control a visible panel.
- Current navigation links must use `aria-current="page"` where appropriate.
- Focus-visible treatment must be visible for skip link, brand, nav links, sidebar links, account trigger, utility actions, and disclosure controls in every supported theme.
- Keyboard order must be predictable and match the visible shell structure.
- Open menus or panels must have a documented dismissal path and focus return behavior through the owning Pattern.
- Mobile/collapsed navigation must remain reachable and operable by keyboard.
- Meaning must not rely on color alone for current, hover, focus, open, or selected state.
- Shell motion must respect reduced-motion preferences.
- Page content must not be obscured by fixed shell regions at normal zoom or narrow widths.
- The shell must maintain readable contrast in supported light and dark themes.

## 11. Content contract

- Use sentence case for shell labels, navigation labels, menu labels, and utility action labels.
- Use concise labels that identify destinations or actions.
- Use stable app/product naming in the brand region.
- Use destination nouns for navigation labels: `Dashboard`, `Components`, `Patterns`, `Users`.
- Use verb-led accessible labels for icon actions: `Open account menu`, `Open notifications`, `Open navigation`.
- Do not use vague utility labels such as `Menu`, `Icon`, `More`, or `Click here` when the action is known.
- Do not duplicate the same destination label in multiple shell regions unless the responsive behavior intentionally moves the same item between regions.
- Keep sidebar group labels short and scannable.
- Avoid labels that wrap in the header. Move longer navigation to the left panel or page content.
- Do not encode critical context only in icons, color, tooltip, or position.
- Account menu labels must clearly identify account actions such as `Profile`, `Settings`, or `Sign out`.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, direct Carbon classes, Bootstrap navbars/offcanvas components, or custom JavaScript.
- Do not render `Component-specific API pending correction` as the example call or installed guidance.
- Do not create feature-local `x-ui.shell`, `x-shell`, `x-sidebar`, `x-header`, `x-nav`, or equivalent wrappers.
- Do not create page-local app headers, sidebars, account menus, or notification/action areas.
- Do not create local shell or tab behavior outside the owner route.
- Do not use `x-ui.tabs` for route-level page navigation that belongs to `x-shell.page-tabs`.
- Do not use navigation primitives for task progress unless a future component contract explicitly allows it.
- Do not hide critical navigation behind an unlabelled icon or inaccessible overflow control.
- Do not use icon-only shell actions without accessible names.
- Do not omit the skip link in authenticated shell layouts.
- Do not remove visible focus from shell controls.
- Do not use `aria-current` on more than one item in the same navigation set.
- Do not create more than two practical shell navigation levels.
- Do not put page-specific actions in the global header unless approved by Page header/Navigation Pattern ownership.
- Do not implement right panels, switchers, or utility drawers as fake production controls before the gate is approved.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use Bootstrap `.navbar`, `.offcanvas`, `.dropdown-menu`, `.nav`, or `.sidebar` classes as app shell API.
- Do not create broad navigation-library corrections from this standard.

## 13. Deferred or gated capabilities

| Capability                                 | Status      | Gate                                                                                                                                      |
| ------------------------------------------ | ----------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Public `x-ui.shell` Blade wrapper          | Deferred    | Requires source file, slot contract, layout props, landmark mapping, rendered evidence examples, migration guidance, and tests.                |
| Public shell header/sidebar Blade wrappers | Deferred    | Requires brand/nav/action slots, item data contract, current-route mapping, responsive behavior, and tests.                               |
| Right panel                                | Deferred    | Requires anchored trigger, open/closed state, dismissal behavior, focus management, responsive behavior, reduced-motion proof, and tests. |
| Product/property switcher                  | Deferred    | Requires switcher placement, item grouping, keyboard behavior, selected/current rules, right-panel relationship, and tests.               |
| Header search                              | Gated       | Requires Search Component/Pattern ownership, expanded/collapsed behavior, keyboard/focus rules, and tests.                                |
| Notification drawer                        | Gated       | Requires Notification/Overlay ownership, unread count behavior, focus management, empty/loading/error states, and tests.                  |
| Multi-level sidebar beyond two levels      | Not allowed | Use in-page navigation such as Tabs, Breadcrumb, or section Patterns.                                                                     |
| Shell-specific JavaScript controller       | Deferred    | Requires documented data attributes, lifecycle, responsive behavior, focus management, and tests.                                         |
| Public shell data attributes               | Deferred    | Requires documented behavior contract and regression tests.                                                                               |
| Public/auth shell variant                  | Gated       | Requires separate layout contract, route scope, accessibility proof, and rendered evidence examples.                                           |
| Custom header utility                      | Gated       | Requires action owner, accessible label, icon source approval, placement rule, and rendered evidence proof.                                    |
| Custom theme or brand color shell          | Not allowed | Requires Themes and Color Element standard updates plus rendered evidence proof.                                                               |

Future extensions require an updated Component standard and rendered evidence proof before production use.

## 14. Implementation and Rendered Evidence Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and Rendered evidence route assertions block generic fallback content.                                                            |

### 14.2. rendered evidence proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The UI shell page is a broad shell/navigation reference page. The Live examples card should use full-width shell diagrams, region maps, state matrices, responsive examples, and implementation examples rather than a simple tab-only scaffold.

### 15.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                                               | Variants/options shown                                                   |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| API status proof                  | Page states that UI shell is Approved API, pattern-owned by Navigation, and has no standalone public Blade wrapper.                                                             | Pattern-owned, App layout, Deferred `x-ui.shell`                         |
| Header baseline                   | Header renders brand, global navigation, utility actions, current state, and accessible icon labels.                                                                            | Standard layout, Current location, Focus-visible, Header actions         |
| Left panel                        | Sidebar renders product/section navigation with current state, grouping, focus-visible behavior, and no third shell tier.                                                       | Left panel, Current/selected, Focus-visible, Overflow                    |
| Account menu                      | Account trigger and menu boundary render with Menu buttons ownership, accessible label, keyboard/focus expectations, and focus return rules.                                    | Account menu, Open/closed, Focus-visible, Keyboard                       |
| Notification/action area          | Header utility actions render through Icon button/Menu/Notification boundaries, with labels and overflow guidance.                                                              | Action area, Icon labels, Notification entry, Overflow                   |
| Mobile/collapsed behavior         | Responsive shell example shows menu trigger, `aria-expanded`, `aria-controls`, mobile open state, scrim/dismissal guidance, and reduced-motion expectations.                    | Responsive collapse, Expanded/collapsed, Open/closed, Reduced motion     |
| Skip-link and landmarks           | Example shows skip link, header/banner, nav labels, aside/left panel, and main content target.                                                                                  | Skip link, Header, Nav, Aside, Main                                      |
| Current-location matrix           | Header and sidebar current-state examples show `aria-current` and token-backed visual treatment.                                                                                | Current location, Selected, Non-color-only meaning                       |
| Keyboard/focus order              | Page documents the expected tab sequence and panel focus behavior.                                                                                                              | Skip link, Header actions, Sidebar, Main, Open panel                     |
| Overflow behavior                 | Page shows how navigation and actions remain reachable at constrained widths.                                                                                                   | Header overflow, Sidebar collapse, Mobile drawer                         |
| Right panel deferred              | Page shows right panel trigger conditions and does not render fake production right-panel controls.                                                                             | Deferred right panel, Switcher gate, Trigger conditions                  |
| Selection guidance matrix         | Page distinguishes UI shell from Page header, Breadcrumb, Tabs, Table toolbar, Modal, Notification, and Progress.                                                               | Shell, Page header, Breadcrumb, Tabs, Table toolbar, Modal, Notification |
| Prohibited usage proof            | Page shows local shells, Bootstrap navbars/offcanvas, direct Carbon classes, unlabeled icon actions, missing skip link, fake right panels, and task-progress nav as prohibited. | Local shell, Bootstrap, Carbon classes, Missing skip link, Fake panels   |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                                             | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid               |
| Developer implementation examples | Canonical layout/class examples render as real code examples and do not include placeholder text.                                                                               | `ui-shell`, Header, Left panel, Main, Mobile toggle                      |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed shell contract, app layout ownership, pattern ownership, rendered regions, states, prohibited usage, deferred gates, accessibility behavior, responsive behavior, and consumed Foundation Elements.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies UI shell as `Approved API`.
- The page identifies `not installed` as the production source owner.
- The page states that no standalone public `x-ui.shell` Blade wrapper is approved yet.
- The page shows canonical shell layout markup with `ui-shell`, `ui-shell__header`, `ui-shell__sidebar`, `ui-shell__main`, and `ui-shell__skip-link`.
- The page renders header baseline, left panel, account menu, notification/action area, mobile/collapsed behavior, skip-link behavior, and current-location examples.
- The page documents `aria-current`, `aria-expanded`, `aria-controls`, accessible icon labels, nav labels, and main content skip target requirements.
- The page documents right panel and switcher behavior as deferred rather than fake installed controls.
- The page distinguishes UI shell from Page header, Breadcrumb, Tabs, Table toolbar, Modal, Notification, and Progress indicator.
- The page documents prohibited usage for local shells, Bootstrap navbars/offcanvas, direct Carbon classes, raw utility clusters, arbitrary spacing, hard-coded z-index stacks, local icons, missing skip link, unlabeled icon actions, and feature-local shell JavaScript.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap navigation/offcanvas classes, hard-coded colors, arbitrary local spacing, local icons, custom JavaScript, or feature-local shell classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('UI shell');
$response->assertSee('Approved API');
$response->assertSee('Pattern-owned');
$response->assertSee('not installed');
$response->assertSee('ui-shell');
$response->assertSee('ui-shell__header');
$response->assertSee('ui-shell__sidebar');
$response->assertSee('ui-shell__main');
$response->assertSee('ui-shell__skip-link');
$response->assertSee('Header baseline');
$response->assertSee('Left panel');
$response->assertSee('Account menu');
$response->assertSee('Notification/action area');
$response->assertSee('Mobile/collapsed behavior');
$response->assertSee('Right panel deferred');
$response->assertSee('aria-current');
$response->assertSee('aria-expanded');
$response->assertSee('aria-controls');
$response->assertSee('Skip to main content');
$response->assertSee('No standalone public');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Icons');
$response->assertSee('Motion');
$response->assertSee('2x Grid');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('navbar navbar');
$response->assertDontSee('offcanvas');
```

## 17. Related APIs

| API                               | Route                                                                   |
| --------------------------------- | ----------------------------------------------------------------------- |
| Components overview               | `not installed`                                     |
| Navigation pattern                | `not installed`                            |
| Layout Pattern                    | `not installed`                                |
| Breadcrumb                        | `not installed`                          |
| Link                              | `not installed`                                |
| Button                            | `not installed`                              |
| Icon button                       | `not installed`                              |
| Menu buttons                      | `not installed`                        |
| Notification                      | `not installed`                        |
| Tooltip                           | `not installed`                             |
| Modal                             | `not installed`                               |
| Tables Pattern                    | `not installed`                                |
| Overlay and feedback patterns     | `not installed`                     |
| Color element                     | `not installed`                                 |
| Spacing element                   | `not installed`                               |
| Typography element                | `not installed`                            |
| Themes element                    | `not installed`                                |
| Icons element                     | `not installed`                                 |
| Motion element                    | `not installed`                                |
| 2x Grid element                   | `not installed`                               |
| Canonical UI shell doc            | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fui-shell.md`      |
| Carbon UI shell header usage      | `https://carbondesignsystem.com/components/UI-shell-header/usage/`      |
| Carbon UI shell left panel usage  | `https://carbondesignsystem.com/components/UI-shell-left-panel/usage/`  |
| Carbon UI shell right panel usage | `https://carbondesignsystem.com/components/UI-shell-right-panel/usage/` |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon UI shell header, left panel, right panel, accessibility, and global header guidance inform shell region ownership, header/left/right panel distinctions, persistent navigation behavior, skip-link and keyboard expectations, responsive movement of navigation, and right-panel deferral. Login App keeps its own Navigation Pattern ownership, app layout composition, `ui-*` namespace, Foundation Element tokens, and rendered evidence proof.
