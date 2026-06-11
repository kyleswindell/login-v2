---
title: Navigation Pattern API
slug: navigation
status: implemented-standard
api_layer: Pattern API
owner_route: /platform/ui-reference/patterns/navigation
canonical_path: docs/02-standards/ui/patterns/navigation.md
ui_reference_proof: /platform/ui-reference/patterns/navigation
consumed_elements:
  - 2x-grid
  - color
  - spacing
  - typography
  - icons
  - motion
  - themes
consumed_components:
  - breadcrumb
  - tabs
  - link
  - button
  - menu-buttons
  - search
  - ui-shell
related_patterns:
  - data-and-content
  - forms
  - tables
---

# Navigation Pattern API
- [Navigation Pattern API](#navigation-pattern-api)
  - [1. API summary](#1-api-summary)
  - [2. Status and ownership](#2-status-and-ownership)
  - [3. Installed standard](#3-installed-standard)
  - [4. Pattern API](#4-pattern-api)
    - [4.1. Canonical composition examples](#41-canonical-composition-examples)
  - [5. Required composition](#5-required-composition)
  - [6. Optional composition](#6-optional-composition)
  - [7. Consumed Element APIs](#7-consumed-element-apis)
  - [8. Owned Component APIs](#8-owned-component-apis)
  - [9. Allowed variants and layout options](#9-allowed-variants-and-layout-options)
  - [10. State ownership](#10-state-ownership)
  - [11. Responsive behavior](#11-responsive-behavior)
  - [12. Composition rules](#12-composition-rules)
  - [13. Selection guidance](#13-selection-guidance)
  - [14. Accessibility contract](#14-accessibility-contract)
  - [15. Content contract](#15-content-contract)
  - [16. Prohibited usage](#16-prohibited-usage)
  - [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
  - [Implementation and UI Reference Checklist](#implementation-and-ui-reference-checklist)
    - [Implementation checklist](#implementation-checklist)
    - [UI Reference proof checklist](#ui-reference-proof-checklist)
  - [19. UI Reference requirements](#19-ui-reference-requirements)
  - [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
  - [21. Related APIs](#21-related-apis)
  - [22. References](#22-references)

## 1. API summary

Navigation patterns define page-local wayfinding, shell composition, breadcrumbs, tabs, search/filter navigation, and action placement.

Navigation is a Pattern API. Feature modules must compose approved Component and Element APIs through this Pattern instead of creating local navigation bars, local title/action rows, duplicate shell regions, custom breadcrumb trails, or one-off section-switching controls.

Carbon describes patterns as reusable combinations of components and templates that help users complete goals through common objectives, sequences, and flows. Login App uses this Pattern standard to define the installed navigation composition contract for route hierarchy, page-local orientation, shell regions, and action placement.

## 2. Status and ownership

| Field              | Value                                         |
| ------------------ | --------------------------------------------- |
| Status             | Implemented standard                          |
| API layer          | Pattern API                                   |
| Pattern slug       | navigation                                    |
| Category           | Navigation and wayfinding                     |
| Owner route        | `/platform/ui-reference/patterns/navigation`  |
| Canonical path     | `docs/02-standards/ui/patterns/navigation.md` |
| UI Reference proof | `/platform/ui-reference/patterns/navigation`  |
| Source owner       | `/platform/ui-reference/patterns/navigation`  |

## 3. Installed standard

Use Navigation patterns for route hierarchy, local section switching, shell areas, page title/action composition, contextual search/filter navigation, and responsive navigation collapse.

Navigation Patterns compose approved Component and Element APIs. They do not redefine primitive visual decisions, child Component behavior, feature-specific permissions, route authorization, or business workflow branching.

The installed standard owns these app-level composition decisions:

- How Breadcrumb, page title, page description, and page actions are arranged.
- How local navigation, tabs, search/filter bars, and page actions relate to the current content region.
- How shell navigation regions compose header, side navigation, account menu, notification/action areas, and responsive collapse.
- How current-route context is exposed visually and semantically.
- How overflow is handled for breadcrumbs, tabs, action rows, and shell regions.
- Which Component API owns each interactive control used inside the pattern.

## 4. Pattern API

| Pattern API                        | Status                         | Purpose                                                                                   | Notes                                                                          |
| ---------------------------------- | ------------------------------ | ----------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------ |
| `x-ui.patterns.page-header`        | Implemented / canonical target | Composes page title, description, breadcrumbs, and page actions.                          | Parent pattern owns external spacing and action placement.                     |
| `x-ui.patterns.sub-navigation-bar` | Implemented / canonical target | Composes local page navigation or peer section switching.                                 | Use Tabs when the UI switches peer content sections.                           |
| `x-ui.patterns.search-filter-bar`  | Implemented / canonical target | Composes scoped Search, filters, and supporting actions.                                  | Filtering behavior is Pattern-owned; Search owns the text input control.       |
| Breadcrumb composition             | Implemented                    | Composes Breadcrumb inside page header or route context.                                  | Breadcrumb Component owns trail semantics and overflow menu behavior.          |
| Page title and actions row         | Implemented                    | Places primary and supporting page-level actions.                                         | Button/Menu buttons own the controls. Pattern owns placement and grouping.     |
| UI shell composition               | Implemented / pattern-owned    | Composes global header, navigation regions, account menu, action area, and content frame. | Shell layout is Pattern-owned even when represented in the Component catalog.  |
| Search/filter navigation           | Implemented / pattern-owned    | Coordinates search scope, filters, result context, and reset/clear affordances.           | Search Component owns field behavior; Pattern owns query/filter orchestration. |

### 4.1. Canonical composition examples

```blade
<x-ui.patterns.page-header
    title="Users"
    description="Manage account access, roles, and status."
    :breadcrumbs="$breadcrumbs"
    :actions="$actions"
/>
```

```blade
<x-ui.patterns.sub-navigation-bar :items="$sections" current="overview" />
```

```blade
<x-ui.patterns.search-filter-bar
    search-name="q"
    search-label="Search users"
    :filters="$filters"
    :actions="$tableActions"
/>
```

These examples document the intended Pattern API shape. If the project has not yet installed a named Blade wrapper for one of these compositions, feature work must either use the documented owner route examples exactly or update this Pattern standard and UI Reference proof before introducing a new wrapper.

## 5. Required composition

Navigation Pattern implementations may compose only approved Element, Component, and Pattern APIs.

| Required composition | API owner                                         | Usage                                                                              |
| -------------------- | ------------------------------------------------- | ---------------------------------------------------------------------------------- |
| Breadcrumb trail     | `docs/02-standards/ui/components/breadcrumb.md`   | Shows hierarchy and current location context.                                      |
| Tabs                 | `docs/02-standards/ui/components/tabs.md`         | Switches between peer content sections in the current context.                     |
| Link                 | `docs/02-standards/ui/components/link.md`         | Navigates to related locations or trusted references.                              |
| Button               | `docs/02-standards/ui/components/button.md`       | Triggers page-level or region-level commands.                                      |
| Menu buttons         | `docs/02-standards/ui/components/menu-buttons.md` | Exposes grouped secondary actions and overflow actions.                            |
| Search               | `docs/02-standards/ui/components/search.md`       | Captures scoped free-entry keywords.                                               |
| UI shell             | `docs/02-standards/ui/components/ui-shell.md`     | Provides shell regions when installed; composition behavior remains Pattern-owned. |
| 2x Grid              | `docs/02-standards/ui/elements/2x-grid.md`        | Owns page-level region geometry and shell alignment.                               |
| Spacing              | `docs/02-standards/ui/elements/spacing.md`        | Owns external gaps, stack rhythm, and responsive layout spacing.                   |
| Typography           | `docs/02-standards/ui/elements/typography.md`     | Owns title, label, helper, and navigation text roles.                              |
| Color                | `docs/02-standards/ui/elements/color.md`          | Owns surfaces, text, borders, links, actions, states, and focus color roles.       |
| Icons                | `docs/02-standards/ui/elements/icons.md`          | Owns navigation, overflow, account, notification, and action icon usage.           |
| Motion               | `docs/02-standards/ui/elements/motion.md`         | Owns menu open/close, shell collapse, and reduced-motion behavior.                 |
| Themes               | `docs/02-standards/ui/elements/themes.md`         | Owns light, dark, inline, inverse, and layered shell contexts.                     |

## 6. Optional composition

| Optional composition                | Status                                       | Usage                                                                                          |
| ----------------------------------- | -------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| Overflow breadcrumb menu            | Implemented through Breadcrumb/Menu behavior | Use when the breadcrumb trail exceeds the allowed visible item count.                          |
| Tab overflow control                | Gated until installed in Tabs                | Use only when Tabs defines the overflow API and UI Reference proof.                            |
| Account menu area                   | Implemented / shell-owned                    | Use inside the global shell; Menu buttons own trigger/menu behavior.                           |
| Notification action area            | Implemented / shell-owned                    | Use in the shell or page header only when notifications/actions are approved.                  |
| Search/filter bar reset action      | Implemented / Pattern-owned                  | Use when scoped filters/search can be cleared together.                                        |
| Page action overflow                | Implemented through Menu buttons             | Use when lower-priority actions must stay available without competing with the primary action. |
| Mobile/collapsed navigation trigger | Implemented / shell-owned                    | Use when shell navigation collapses at narrow widths.                                          |
| Right panel shell region            | Deferred/gated                               | Do not render as production UI until a concrete workflow requires it.                          |

## 7. Consumed Element APIs

Navigation Pattern implementations consume these Foundation Element APIs:

| Element API | Required usage                                                                                                                                    |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Use role-based tokens for shell surfaces, page surfaces, navigation text, link text, action color, current-route state, focus rings, and borders. |
| Spacing     | Use pattern-owned gaps and stack utilities for page headers, breadcrumb placement, tab spacing, action rows, and shell regions.                   |
| Typography  | Use approved page-title, kicker, link, tab, menu, helper, and metadata roles.                                                                     |
| Icons       | Use approved icons for overflow, account, notifications, search, menu triggers, collapsible shell regions, and external/reference cues.           |
| Motion      | Use approved transition timing for menus, collapsed shell regions, and other navigation disclosure. Respect reduced-motion preferences.           |
| Themes      | Preserve readability in light, dark, inline, inverse, layered, and high-contrast contexts when applicable.                                        |
| 2x Grid     | Align shell, header, content, and local navigation regions to approved page-level geometry.                                                       |

Carbon color composition mapping:

| Pattern need | Carbon benchmark role | Login App owner to compose | Mapping rule |
| ------------ | --------------------- | -------------------------- | ------------ |
| Links, breadcrumbs, current-route anchors | Link and Breadcrumb link/text/focus rows | Link/Breadcrumb Components + Color Element | Navigation composes current context; Link/Breadcrumb own link colors. |
| Local tabs and section switching | Tabs selected, hover, focus, disabled, contained rows | Tabs Component | Pattern chooses tabs vs links; Tabs owns selected and tablist colors. |
| Page and shell actions | Button/Menu button token families | Button and Menu buttons Components | Navigation places actions; Button/Menu buttons own hierarchy, danger, disabled, and focus colors. |
| Search/filter navigation | Search, field, filter components, Tag, Pagination rows | Search and filter child Components | Pattern owns scope/orchestration; controls own field/status colors. |
| Shell/header/sidebar surfaces and current item state | Layer/background/text/icon/border/focus roles | UI Shell Component + Color/Theme Elements | Shell and side-nav roles must be app-owned `ui-*` classes, not local utility clusters. |
| Notification/action shell slots | Notification/Button/Menu rows | Notification and action Components | Pattern may reserve slots; child APIs own visual color treatment. |

Do not hard-code color, spacing, font size, icon source, focus style, motion timing, breakpoint behavior, or theme-specific values inside Navigation Pattern views.

## 8. Owned Component APIs

Navigation Patterns do not own the internals of Breadcrumb, Tabs, Button, Link, Menu buttons, Search, or UI shell Components. They own how those Components are composed into navigational experiences.

| Owned responsibility            | Owner                  | Notes                                                                                                              |
| ------------------------------- | ---------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Page-level action placement     | Navigation Pattern     | Determines primary/supporting action grouping and placement.                                                       |
| Local navigation grouping       | Navigation Pattern     | Determines whether the page uses breadcrumbs, tabs, sub-navigation, search/filter navigation, or visible sections. |
| Shell region composition        | Navigation Pattern     | Determines header/sidebar/content/account/action region relationships.                                             |
| Responsive navigation collapse  | Navigation Pattern     | Determines when shell/local navigation collapses, truncates, scrolls, or moves to overflow.                        |
| Current-route context           | Navigation Pattern     | Determines which route, section, tab, or shell item is current.                                                    |
| Breadcrumb item rendering       | Breadcrumb Component   | Breadcrumb owns trail semantics, current-page rules, and overflow behavior.                                        |
| Tab state and keyboard behavior | Tabs Component         | Tabs own selected/active states and tablist behavior.                                                              |
| Menu trigger/menu behavior      | Menu buttons Component | Menu buttons own trigger state, menu placement, item behavior, and keyboard handling.                              |
| Search input behavior           | Search Component       | Search owns field, clear action, loading state, and input accessibility.                                           |
| Button/link internals           | Button/Link Components | Components own command/navigation semantics and local states.                                                      |

## 9. Allowed variants and layout options

| Variant or layout option            | Status                                 | Use when                                                                                    | Required constraints                                                                                                                   |
| ----------------------------------- | -------------------------------------- | ------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Page title and actions              | Implemented                            | A page needs title, optional description, and page-level actions.                           | Use one primary action per region; supporting actions use secondary, ghost, link, or menu placement as documented by their Components. |
| Breadcrumb trail                    | Implemented                            | The user needs route hierarchy and location orientation.                                    | Breadcrumbs truncate/overflow; they do not wrap or represent task progress.                                                            |
| Breadcrumb plus page header         | Implemented                            | A nested page needs hierarchy plus a visible title.                                         | Breadcrumb may omit current page when the page title is visible and clear.                                                             |
| Sub-navigation bar                  | Implemented / canonical target         | A local page needs peer destination links or section-level navigation.                      | Do not duplicate shell navigation; do not replace Tabs when switching visible peer panels in the same view.                            |
| Tabs inside content                 | Implemented when Tabs API is installed | Users switch peer content sections inside the current context.                              | Tabs are not global navigation and must not replace shell navigation.                                                                  |
| Search/filter bar                   | Implemented / Pattern-owned            | A data/content region needs scoped keyword search and filters.                              | Search owns the field; Pattern owns filter orchestration and result context.                                                           |
| Shell navigation                    | Implemented / Pattern-owned            | The global app frame needs persistent navigation and account/action areas.                  | Shell composition owns responsive collapse and repeated-region accessibility.                                                          |
| Account menu area                   | Implemented / shell-owned              | Authenticated shell needs profile/account/session actions.                                  | Use Menu buttons/Menu behavior; do not create custom account dropdowns.                                                                |
| Notification/action area            | Implemented / shell-owned              | Shell needs global notification or utility actions.                                         | Use Button/Menu buttons/Notification APIs.                                                                                             |
| Right-panel shell behavior          | Deferred                               | A concrete workflow needs persistent side detail, inspection, or contextual utility region. | Requires updated Pattern standard, UI Reference proof, focus/order review, and responsive rules.                                       |
| Vertical tabs as primary navigation | Not allowed                            | Not applicable.                                                                             | Use shell navigation, visible sections, or another approved Pattern.                                                                   |

## 10. State ownership

Navigation Patterns own context and composition states. Child Components own local control states.

| State                              | Owner                                  | Required behavior                                                                                                   |
| ---------------------------------- | -------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Current route                      | Navigation Pattern                     | Current shell item, breadcrumb context, local nav item, or tab context must be clear and non-color-only.            |
| Current page in breadcrumb         | Breadcrumb Component with Pattern data | Current page is plain text when listed and uses current-page semantics.                                             |
| Active tab                         | Tabs Component with Pattern data       | Active tab reflects the visible peer content section.                                                               |
| Page action priority               | Navigation Pattern                     | Primary action remains visually and spatially clear; lower-priority actions move to secondary/ghost/menu placement. |
| Collapsed shell                    | Navigation Pattern                     | Repeated shell regions collapse predictably and preserve access to navigation.                                      |
| Search/filter active               | Search/filter Pattern                  | Active filters/search terms are visible and clearable where applicable.                                             |
| Overflow menu open                 | Menu buttons or Breadcrumb Component   | Trigger and menu state is owned by the child Component.                                                             |
| Hover/focus/disabled/local loading | Child Components                       | Local states must use each Component API and Element tokens.                                                        |
| Empty/no-results route context     | Feature module or Data/Content Pattern | Navigation Pattern may place the state but does not own business-specific messaging.                                |

## 11. Responsive behavior

- Breadcrumbs truncate or overflow instead of wrapping onto a second line.
- Horizontal tabs scroll, overflow, or defer to an approved responsive Tabs behavior instead of wrapping unpredictably.
- Page title/actions stack predictably at narrow widths: title and description remain readable, and actions retain priority order.
- Primary actions stay discoverable; secondary actions may move to Menu buttons when the page width cannot support all visible controls.
- Search/filter bars stack in a predictable order: scope/search first, filters second, actions/reset third unless the UI Reference proves a different order.
- Shell regions collapse predictably at narrow widths and preserve keyboard access to global navigation, account actions, and content.
- Repeated shell regions must preserve skip-link behavior and content-first keyboard recovery.
- Long labels wrap only where the child Component allows wrapping. Breadcrumbs and tabs use truncation/overflow rules instead of multi-line wrapping.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, responsive composition, and current-route context.
- Child Components own their public APIs, local states, accessibility semantics, internal spacing, and token-backed styling.
- Feature modules own business rules, permissions, data loading, persistence, route generation, authorization, and workflow-specific branching.
- Use Navigation Pattern APIs for page headers, local navigation, search/filter bars, shell composition, and title/action placement.
- Do not create local header/action rows when the Pattern API already owns the same role.
- Do not create custom breadcrumb markup; use the Breadcrumb Component inside the Navigation Pattern.
- Do not create custom tablists; use the Tabs Component inside the Navigation Pattern.
- Do not create custom account menus, action menus, or overflow triggers; use Menu buttons/Menu behavior.
- Do not place workflow progress into Breadcrumbs, Tabs, or shell navigation. Use Progress indicator or a workflow Pattern when installed.
- Do not duplicate global shell navigation inside page content.

## 13. Selection guidance

| User need                                        | Use                                    | Do not use                                                  |
| ------------------------------------------------ | -------------------------------------- | ----------------------------------------------------------- |
| Show hierarchy and current location              | Breadcrumb trail                       | Progress indicator, tabs, local ad hoc links                |
| Switch peer content sections in the current page | Tabs                                   | Breadcrumbs, shell navigation, vertical tabs as primary nav |
| Navigate between global app areas                | Shell navigation                       | Tabs inside page content                                    |
| Place title, summary, and page-level commands    | Page title/actions pattern             | Local header markup or arbitrary action rows                |
| Expose grouped secondary page actions            | Menu buttons inside page action row    | Multiple competing primary buttons                          |
| Search/filter a data region                      | Search/filter bar pattern              | Unscoped text inputs or local custom filter bars            |
| Link to related route/reference                  | Link Component                         | Button when no command is performed                         |
| Trigger a command                                | Button Component                       | Link if data/state changes                                  |
| Show task progress                               | Progress indicator or workflow Pattern | Breadcrumb, Tabs, or shell navigation                       |

## 14. Accessibility contract

Navigation Patterns must:

- Expose current location semantically where supported by child Components.
- Preserve logical focus order through shell, header, local navigation, main content, and action regions.
- Provide skip-link support where shell content repeats across pages.
- Use semantic navigation landmarks only when the region is navigational.
- Avoid creating multiple indistinguishable `nav` regions without accessible names.
- Keep current state discoverable without relying on color alone.
- Preserve visible focus for all child Components.
- Keep overflow triggers keyboard reachable and labeled by their child Component APIs.
- Ensure collapsed shell or local navigation remains reachable by keyboard and assistive technology.
- Avoid focus traps in navigation patterns unless a child overlay Component explicitly owns and documents them.

## 15. Content contract

- Use short, specific page link labels.
- Use page titles that describe the current route or task outcome.
- Use breadcrumb labels that match the information architecture, not marketing copy.
- Use tab labels for peer sections, not verbs or workflow actions.
- Use action labels that describe outcomes, such as `Create user`, `Save changes`, or `Export report`.
- Avoid vague navigation labels such as `More` unless paired with context, accessible text, or a Menu buttons pattern.
- Keep search/filter labels scoped, such as `Search users`, `Search audit events`, or `Filter status`.
- Do not use breadcrumbs, tabs, or shell items as hidden explanations for feature permissions or disabled states.

## 16. Prohibited usage

- Do not bypass the installed Pattern API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use breadcrumbs as workflow progress.
- Do not use tabs for global navigation.
- Do not use shell navigation for peer panels inside page content.
- Do not duplicate shell navigation inside page content.
- Do not wrap breadcrumbs onto a second line.
- Do not build local tab overflow behavior before Tabs owns it.
- Do not create local account menus, overflow menus, or action menus outside Menu buttons/Menu behavior.
- Do not create local page-header action layouts that conflict with the page title/actions Pattern.
- Do not use vertical tabs as primary navigation.
- Do not hide primary navigation or required route context behind icons without accessible labels and approved responsive behavior.
- Do not hard-code Foundation Element decisions that already have approved APIs.

## 17. Deferred or gated capabilities

| Capability                     | Status                         | Trigger condition                                                                                                                           | Prohibited workaround                                                                   |
| ------------------------------ | ------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| Right-panel shell behavior     | Deferred                       | A concrete workflow requires persistent side detail, inspection, or contextual utility while preserving main content.                       | Do not create local right panels, sticky sidebars, or floating inspectors.              |
| Tab overflow control           | Gated                          | Tabs Component defines overflow behavior, keyboard handling, and UI Reference proof.                                                        | Do not build local tab dropdowns or wrapped tab rows.                                   |
| Collapsible sub-navigation     | Gated                          | A real narrow-width local navigation need exists and the Pattern defines focus, current state, and disclosure behavior.                     | Do not replace local nav with ad hoc accordions or menus.                               |
| Global search shell slot       | Gated                          | Product requires global search across app entities and Search/Navigation patterns define scope, results, keyboard, and no-results behavior. | Do not add a local header search input that looks global but searches only one feature. |
| Notification center shell slot | Gated                          | Product requires global notification history or unread actions.                                                                             | Do not create shell notification icons without Notification/Menu ownership.             |
| Multi-level shell navigation   | Gated                          | Information architecture requires nested global navigation.                                                                                 | Do not use Tree view or nested custom menus until keyboard/ARIA ownership is approved.  |
| Mobile drawer shell navigation | Gated if not already installed | Product requires mobile shell navigation beyond simple collapse.                                                                            | Do not add custom off-canvas drawers outside the shell Pattern.                         |

## Implementation and UI Reference Checklist
### Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### UI Reference proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. UI Reference requirements

The UI Reference page must show rendered examples of approved Navigation Pattern compositions, not abstract notes only.

| Required proof                 | Rendered behavior                                                                                                           | APIs shown                                                  |
| ------------------------------ | --------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------- |
| Page title and actions         | Page title, optional description, breadcrumbs, one primary action, and supporting actions render in approved placement.     | Breadcrumb, Button, Menu buttons, Typography, Spacing, Grid |
| Breadcrumb hierarchy           | Breadcrumb trail shows route hierarchy, current-page disposition, and overflow/truncation behavior.                         | Breadcrumb, Link, Menu buttons, Icons                       |
| Local tabs inside content      | Tabs switch peer page sections without pretending to be global navigation.                                                  | Tabs, Typography, Color, Motion                             |
| Sub-navigation bar             | Local navigation grouping shows current item and narrow-width behavior.                                                     | Link, Button/Menu buttons as applicable, Spacing, Color     |
| Search/filter navigation       | Search, filters, reset/clear action, and result-context copy compose as one scoped region.                                  | Search, Button, Menu buttons, Tag, Spacing                  |
| Page action overflow           | Primary action remains visible while lower-priority actions move into a menu.                                               | Button, Menu buttons                                        |
| Shell navigation composition   | Header, side/global navigation, account menu area, notification/action area, and content region render as a composed shell. | UI shell, Link, Button, Menu buttons, Icons, 2x Grid        |
| Responsive navigation behavior | Breadcrumbs truncate, tabs/section navigation do not wrap unpredictably, shell regions collapse predictably.                | Breadcrumb, Tabs, UI shell, 2x Grid                         |
| Deferred right-panel gate      | Right-panel shell behavior appears as a gated disposition row with trigger conditions.                                      | Deferred gate, not fake UI                                  |
| Component boundary comparison  | UI Reference explains Breadcrumb vs Tabs vs Shell navigation vs Progress indicator vs Link/Button.                          | Related APIs                                                |

The page must link to this canonical standard and to consumed Element and Component standards.

Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples.

Examples must use app-owned tokens, classes, helpers, and Blade components where available.

## 20. Testing and acceptance criteria

- `/platform/ui-reference/patterns/navigation` returns 200 for authorized users.
- The page shows the installed Pattern API, required composition, optional composition, prohibited usage, deferred gates, and consumed Element/Component APIs.
- Rendered examples include required composition markers for page title/actions, breadcrumb hierarchy, tabs/local navigation, search/filter navigation, page action overflow, and shell navigation composition.
- Breadcrumb examples truncate or overflow instead of wrapping.
- Tabs/local navigation examples do not present tabs as global navigation.
- Shell examples preserve skip-link/main-content behavior where repeated shell content appears.
- Search/filter examples identify their scope and do not imply global search unless global search is installed.
- Page action examples show one primary action per region.
- Deferred capabilities render trigger conditions and prohibited workarounds instead of fake production controls.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- The rendered UI Reference links to consumed Component and Element standards.
- The canonical docs link points to `docs/02-standards/ui/patterns/navigation.md`.
- Deprecated `tier-1` or `tier-2` component paths do not appear as canonical links.

Suggested regression assertions:

```php
$response->assertOk();
$response->assertSee('Navigation Pattern API');
$response->assertSee('Page title and actions');
$response->assertSee('Breadcrumb hierarchy');
$response->assertSee('Search/filter navigation');
$response->assertSee('Shell navigation composition');
$response->assertSee('Right-panel shell behavior');
$response->assertSee('docs/02-standards/ui/patterns/navigation.md');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
```

## 21. Related APIs

| API                      | Route                                                  |
| ------------------------ | ------------------------------------------------------ |
| Breadcrumb               | `/platform/ui-reference/components/breadcrumb`         |
| Tabs                     | `/platform/ui-reference/components/tabs`               |
| Link                     | `/platform/ui-reference/components/link`               |
| Button                   | `/platform/ui-reference/components/button`             |
| Menu buttons             | `/platform/ui-reference/components/menu-buttons`       |
| Search                   | `/platform/ui-reference/components/search`             |
| UI shell                 | `/platform/ui-reference/components/ui-shell`           |
| Progress indicator       | `/platform/ui-reference/components/progress-indicator` |
| Data and content Pattern | `/platform/ui-reference/patterns/data-content`         |
| Forms Pattern            | `/platform/ui-reference/patterns/forms`                |
| Tables Pattern           | `/platform/ui-reference/patterns/tables`               |
| 2x Grid element          | `/platform/ui-reference/elements/2x-grid`              |
| Spacing element          | `/platform/ui-reference/elements/spacing`              |
| Color element            | `/platform/ui-reference/elements/color`                |
| Typography element       | `/platform/ui-reference/elements/typography`           |
| Icons element            | `/platform/ui-reference/elements/icons`                |
| Motion element           | `/platform/ui-reference/elements/motion`               |
| Themes element           | `/platform/ui-reference/elements/themes`               |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- Carbon Pattern overview: patterns are best-practice solutions for how users achieve goals through reusable combinations of components and templates.