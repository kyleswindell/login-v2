# Pattern API Standards

Pattern standards define reusable UI compositions. Patterns consume Foundation Elements, coordinate Components, and own page/workflow structure that should not live inside primitive Components.

Use this index for quick lookup. The owning `patterns/{pattern}.md` file remains the full API standard.
- [1. Pattern Matrix](#1-pattern-matrix)
- [2. Planned Pattern Gaps](#2-planned-pattern-gaps)
- [3. Pattern Contract](#3-pattern-contract)
- [4. Pattern Checklist Template](#4-pattern-checklist-template)
  - [4.1. Implementation checklist](#41-implementation-checklist)
  - [4.2. rendered evidence proof checklist](#42-ui-reference-proof-checklist)
- [5. Related](#5-related)

## 1. Pattern Matrix

| Pattern                  | Disposition  | Composition owner                                                    | Consumed Elements                          | Coordinated Components                                                                    | Rendered evidence route                                   | Planned sub-APIs                            |
| ------------------------ | ------------ | -------------------------------------------------------------------- | ------------------------------------------ | ----------------------------------------------------------------------------------------- | ---------------------------------------------------- | ------------------------------------------- |
| Boundary and validation  | Approved API | validation placement, blocked/error boundaries                       | Color, Typography, Spacing, Icons          | Text input, Select, Checkbox, Notification, Tag                                           | represented through Forms/Feedback pages             | validation summary refinements              |
| Common Actions           | Approved API | repeated action meaning, hierarchy, permission, loading, feedback, primitive readiness | Color, Spacing, Typography, Icons, Motion  | Button, Link, Menu, Modal, Checkbox, Toggle, Tooltip, Toggletip, Notification             | `not installed`     | action-set implemented; confirmation, destructive flows, primitive readiness |
| Data and content         | Approved API | read-only detail, key-value, identity/content composition            | 2x Grid, Spacing, Typography, Color        | Structured list, Data table, Tile, Tag, Code snippet                                      | `not installed`       | content browser, enhanced detail surfaces   |
| Feedback                 | Approved API | inline/page feedback composition                                     | Color, Typography, Icons, Motion           | Notification, Tag, Loading, Inline loading                                                | `not installed`  | feedback/notification boundary cleanup      |
| Forms                    | Approved API | form sections, rows, validation summary, actions                     | Spacing, Typography, Color, Icons, Motion  | Text input, Select, Dropdown, Checkbox, Radio, Toggle, Date picker, File uploader, Button | `not installed`              | scheduling, complex field groups            |
| Interactions             | Approved API | interaction rules across composed surfaces                           | Motion, Color, Icons, Typography           | Button, Menu, Tabs, Modal, Tooltip                                                        | represented through data/content and component pages | dedicated route decision                    |
| Layout                   | Approved API | page structure, content sections, grid composition, dashboard layout | 2x Grid, Spacing, Themes, Color            | Breadcrumb, Tabs, Tile, Data table, UI shell sections                                     | `not installed`             | page header, dashboard grid, widget shell   |
| Navigation               | Approved API | app shell, subnavigation, search/filter navigation                   | 2x Grid, Spacing, Color, Icons, Typography | Breadcrumb, Tabs, Menu, Menu buttons, Search, UI shell                                    | `not installed`         | navigation shell, filters/search-filter bar |
| Notifications and toasts | Approved API | transient and persistent notification behavior                       | Color, Typography, Icons, Motion           | Notification, Tag, Button, Link                                                           | `not installed`  | notification/toast boundary confirmation    |
| Overlays and actions     | Approved API | blocking/nonblocking overlay composition and action placement        | Color, Spacing, Typography, Motion, Icons  | Modal, Tooltip, Toggletip, Popover, Button, Menu                                          | `not installed`  | drawer/side panel, dropdown action menu     |

## 2. Planned Pattern Gaps

These names are tracked in [UI API Registry](../api-registry.md) until they receive owning standards and routes:

- table toolbar
- common actions source and rendered evidence proof
- page header
- navigation shell
- text toolbar
- filters / search and filter bar
- scheduling
- enhanced data table
- dropdown action menu
- form field
- settings surface
- page title and actions row
- dashboard grid
- widget shell

## 3. Pattern Contract

Every Pattern standard must define the Pattern API, required composition, optional composition, consumed Element APIs, owned/coordinated Component APIs, allowed variants/layout options, state ownership, responsive behavior, accessibility/content contracts, prohibited usage, deferred gates, Rendered evidence requirements, and tests.

Implementation-facing Pattern test criteria live in [Pattern Test Requirements](../test-requirements/patterns.md). Pattern tests must verify composition-level Element consumption and approved Component usage without overriding component-owned internals.

## 4. Pattern Checklist Template

Every Pattern standard must include `## Implementation and Rendered Evidence Checklist`.

### 4.1. Implementation checklist

| Requirement                | Standard expectation                                                                                                                 |
| -------------------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| Pattern API/source         | Name the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.                      |
| Required composition       | List Components and Elements the Pattern must coordinate.                                                                            |
| Optional composition       | List optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs.                                           |
| State/responsive ownership | Define loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern. |
| Accessibility/content      | Define page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning.               |
| Tests                      | Define route/content/API assertions that prove the Pattern and coordinated Component usage.                                          |

### 4.2. rendered evidence proof checklist

| Requirement            | Visual proof expectation                                                                                                 |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Live compositions      | Render production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Show how child Components consume the Pattern layout and state ownership.                                                |
| Element consumption    | Show spacing, grid, typography, color, theme, icon, and motion use at the Pattern level.                                 |
| Variants/states        | Show required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates.                 |
| Related APIs           | Link coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs.                      |
| Manual review          | Provide enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |

## 5. Related

- [UI Standards Index](../index.md)
- [UI API Registry](../api-registry.md)
- [Foundation Elements](../elements/index.md)
- [Component API Standards](../components/index.md)
- [Pattern Test Requirements](../test-requirements/patterns.md)
- [Pattern checklist](checklist.md)
