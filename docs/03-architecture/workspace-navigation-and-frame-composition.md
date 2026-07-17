<!--
DOC-META
title: Workspace Navigation And Frame Composition
doc_type: architecture
status: draft
owner: architecture
canonical: false
canonical_path: docs/03-architecture/workspace-navigation-and-frame-composition.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines the proposed Workspace, persistent Frame, Frame Surface, and System-to-Product navigation architecture for authenticated Login 2.0 experiences.
-->

# Workspace Navigation And Frame Composition

Parent: [Architecture Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Scope](#3-scope)
  - [3.1. In Scope](#31-in-scope)
  - [3.2. Out Of Scope](#32-out-of-scope)
- [4. Authority And External Benchmark](#4-authority-and-external-benchmark)
- [5. Current Architecture](#5-current-architecture)
- [6. Proposed Target Architecture](#6-proposed-target-architecture)
  - [6.1. Architecture Hierarchy](#61-architecture-hierarchy)
  - [6.2. Workspace](#62-workspace)
  - [6.3. Frame](#63-frame)
  - [6.4. Frame Surface](#64-frame-surface)
  - [6.5. Main Content Outlet](#65-main-content-outlet)
- [7. Navigation Hierarchy](#7-navigation-hierarchy)
  - [7.1. System Navigation](#71-system-navigation)
  - [7.2. Product Navigation](#72-product-navigation)
  - [7.3. Product Area Navigation](#73-product-area-navigation)
  - [7.4. Page And Drill-Down Navigation](#74-page-and-drill-down-navigation)
- [8. Frame Composition](#8-frame-composition)
  - [8.1. Global Header Navigation Surface](#81-global-header-navigation-surface)
  - [8.2. Sidebar Navigation Surface](#82-sidebar-navigation-surface)
  - [8.3. Main](#83-main)
  - [8.4. Responsive Composition](#84-responsive-composition)
- [9. Resolution Model](#9-resolution-model)
- [10. Ownership And Boundaries](#10-ownership-and-boundaries)
- [11. Contribution And Dependency Model](#11-contribution-and-dependency-model)
- [12. Example Classifications](#12-example-classifications)
  - [Default Workspace](#default-workspace)
  - [Global Administration Workspace](#global-administration-workspace)
  - [Tenant Administration Workspace](#tenant-administration-workspace)
  - [Home Product](#home-product)
  - [Settings Product](#settings-product)
  - [Projects Product](#projects-product)
- [13. Canonical Hierarchy, Deep Links, And Breadcrumbs](#13-canonical-hierarchy-deep-links-and-breadcrumbs)
- [14. Data And Persistence](#14-data-and-persistence)
- [15. Permissions, Security, And Isolation](#15-permissions-security-and-isolation)
- [16. Accessibility And Interaction](#16-accessibility-and-interaction)
- [17. Operational Considerations](#17-operational-considerations)
- [18. Decisions](#18-decisions)
- [19. Open Questions](#19-open-questions)
- [20. Related](#20-related)

## 1. Purpose

Define the proposed authenticated Workspace, persistent Frame, named Frame Surface, and navigation hierarchy architecture for Login 2.0.

This document describes what the architecture will mean if [ADR-0008](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md) is accepted. It does not authorize implementation or claim that current repository structure already conforms.

## 2. Status

- Document lifecycle: draft
- Decision state: pending ADR-0008 acceptance
- Current implementation state: transitional and not reconciled to this model
- Owning architecture issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Parent Goal: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Canonical status: proposed architecture owner; not current accepted truth until ADR-0008 acceptance
- Existing-document reconciliation: deferred until Phase 6 closeout and final Goal 3 documentation alignment

## 3. Scope

### 3.1. In Scope

This document defines:

- available and active Workspaces;
- the persistent authenticated Frame;
- Frame Surface meaning and boundaries;
- the initial global-header and sidebar Frame Surfaces;
- Main as a route-owned content outlet;
- System, Product, Product Area, Page, and drill-down navigation;
- navigation placement in the global header and persistent sidebar;
- canonical hierarchy, deep links, and breadcrumbs;
- ownership and dependency direction;
- Workspace, Product, and Page classification examples;
- accessibility and security boundaries relevant to navigation composition.

### 3.2. Out Of Scope

This document does not define:

- Tenant or Instance data architecture;
- User Account or User Identity schemas;
- active Workspace storage;
- exact Workspace switcher implementation;
- exact route, URL, or permission keys;
- exact PHP classes, descriptor schemas, or registration implementation;
- exact Blade, JavaScript, or CSS APIs;
- detailed Product information architecture;
- responsive breakpoint values;
- feature-specific behavior;
- physical repository migration;
- implementation sequencing.

## 4. Authority And External Benchmark

If accepted, [ADR-0008](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md) owns the durable rationale and supersession boundary.

This document owns the resulting architecture model.

The [IBM Carbon Global Header pattern](https://carbondesignsystem.com/patterns/global-header/) is an external benchmark. Carbon distinguishes:

- globally persistent system and product navigation;
- System-level class A links;
- Product-level class B links;
- local navigation among areas of a Product;
- a left panel that supports Product navigation and one visible nested level;
- drill-down Pages with breadcrumb paths;
- a switcher for moving among available Products or systems.

Login 2.0 adapts those ideas to its accepted Core, Module, UI, Tenant, Instance, User Account, and Workspace architecture.

Carbon terminology and implementation are not repository authority. Login 2.0 retains its own ownership, authorization, registration, and naming rules.

## 5. Current Architecture

The current accepted documentation describes:

- one resolved Workspace for one active authenticated User Account runtime;
- Global Administration as a privileged Surface inside that Workspace;
- Surface as a broad owner-specific UI presentation concept that may represent a page, destination, area, or multi-step flow;
- owner-local `Surface/` placement for some presentation-specific code;
- UI shell regions without a complete A-to-E navigation classification.

Current implementation includes a persistent header and sidebar, existing shell aliases, route-owned views, Core and Module navigation declarations, and transitional `Surface` identifiers in UI contract or inventory tooling.

This current state is not the target described below.

## 6. Proposed Target Architecture

### 6.1. Architecture Hierarchy

```text
Tenant
└── Instance
    └── User Account
        └── available Workspaces
            └── active Workspace
                └── Frame
                    ├── Global Header Navigation Surface
                    ├── Sidebar Navigation Surface
                    └── Main Content Outlet
                        └── active Product Page or flow
```

Navigation inside the active Workspace follows:

```text
System (A)
└── Product (B)
    └── Product Area (C)
        └── Page (D)
            └── Drill-down (E+)
```

The two diagrams describe different dimensions:

- Workspace and Frame describe rendered experience composition;
- A through E describe navigation hierarchy.

### 6.2. Workspace

A Workspace is a named, top-level rendered application experience available to an authenticated User Account within its resolved Tenant Instance.

A User Account may have one or more available Workspaces. One Workspace is active for a rendered interaction context.

Workspace availability is resolved from:

- Tenant and Instance state;
- User Account lifecycle and access;
- installed and active Modules;
- configuration;
- Settings and Preferences;
- presentation state.

A Workspace may define:

- a default landing Product;
- a default route;
- an available Product set;
- A-class System navigation;
- Frame Surface composition;
- high-level operating purpose.

A Workspace is not a separate Tenant, Instance, database boundary, Principal, or authorization grant.

Workspace switching normally remains inside the same authenticated User Account and Tenant Instance. Switching Tenant, Instance, or User Account context is a separate identity and scope transition.

### 6.3. Frame

The Frame is the persistent authenticated application structure used to render the active Workspace.

The Frame provides:

- stable header placement;
- stable sidebar placement;
- the Main Content Outlet;
- skip-link and landmark structure;
- responsive navigation disclosure;
- accepted globally placed panels and overlays;
- predictable keyboard and source order.

The Frame is rendered once by application composition.

The active Workspace changes resolved Frame content without requiring each Workspace or Product to reimplement the Frame.

Products and Pages must not create feature-local application headers, sidebars, account menus, or global action clusters.

### 6.4. Frame Surface

A Frame Surface is a named compositional region within the persistent Frame.

A Frame Surface may accept:

- active Workspace composition;
- Core capability Contributions;
- Module Contributions;
- active-route and active-Product state;
- authorization-filtered navigation declarations.

A Frame Surface defines:

- accepted content types;
- ordering;
- filtering;
- active-state representation;
- fallback output;
- UI rendering input.

A Frame Surface does not own the behavior or routes represented by its content.

The initial Frame Surfaces are:

1. Global Header Navigation Surface
2. Sidebar Navigation Surface

Additional Frame Surfaces require explicit architecture and UI-contract acceptance. Frame Surface must not become a generic name for every shell slot or visual region.

### 6.5. Main Content Outlet

Main is the route-owned content outlet of the Frame.

Main renders:

- Product home Pages;
- D-class Pages;
- drill-down Pages;
- forms;
- details;
- tables;
- dashboards;
- widgets;
- flows.

Main is not a Frame Surface because its content is selected directly by routing and remains owned by the applicable Core capability or Module.

## 7. Navigation Hierarchy

| Class | Term         | Definition                                                                      | Default placement                                               |
| ----- | ------------ | ------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| A     | System       | High-level Workspace switching, system destinations, and system-wide navigation | Global Actions region of the global header only                 |
| B     | Product      | Major Core- or Module-owned capability used directly by the User                | Persistent sidebar; optional header Product Navigation          |
| C     | Product Area | Coherent area within one Product containing related Pages and workflows         | One nested sidebar level or Product-local navigation            |
| D     | Page         | One routed Product destination                                                  | Main; breadcrumbs begin when hierarchy is not otherwise visible |
| E+    | Drill-down   | Resource, subresource, task, or deeper focused context                          | Page-local and contextual navigation                            |

### 7.1. System Navigation

System navigation is intentionally rare and sparse.

It includes:

- Workspace switching;
- major accepted system destinations;
- other globally applicable navigation that is broader than one Product.

A-class links render only in the Global Actions region.

Global utilities may occupy the same region but are not automatically A-class navigation. For example, a notification icon may open a panel rather than become a canonical parent in the navigation hierarchy.

### 7.2. Product Navigation

A Product is the B-class user-facing navigation identity of a major Core capability or optional Module.

Representative Products include:

- Home;
- Settings;
- Projects.

A Product may define:

- a display label;
- a Product home Page;
- its Product Areas;
- active-route patterns;
- navigation Contributions;
- applicable local actions.

Product classification does not create a new application ownership area. The underlying Core capability or Module remains the behavior owner.

B-class Products appear primarily in the persistent sidebar.

Selected B-class links may later appear in the global header Product Navigation region when duplication, capacity, responsive behavior, and source order are explicitly accepted.

### 7.3. Product Area Navigation

A Product Area is a coherent C-class part of one Product.

A Product Area groups Pages that support one recognizable responsibility or workflow without requiring the User to change Products.

C-class navigation may appear:

- as the single supported nested level under the active Product in the sidebar;
- on the Product home Page;
- as Product-local tabs;
- through another accepted local-navigation Pattern.

Product Areas remain owned by the Product owner.

### 7.4. Page And Drill-Down Navigation

A Page is one D-class routed destination.

D-class and deeper destinations do not belong in the persistent shell by default.

They use:

- breadcrumbs;
- tabs;
- contextual navigation;
- in-page links;
- tables and lists;
- dashboard widgets;
- task-flow controls.

Unbounded user-created records must not be inserted into persistent shell navigation. Use search, lists, recent items, favorites, or drill-down patterns instead.

## 8. Frame Composition

### 8.1. Global Header Navigation Surface

```text
Global Header Navigation Surface
├── product identity and orientation
├── Product Navigation region
│   └── optional B-class Product links
└── Global Actions region
    ├── A-class System navigation
    └── global utilities
```

Rules:

- A-class navigation appears only in Global Actions;
- B-class links may appear only in the Product Navigation region when separately accepted;
- C-class and deeper navigation do not appear in the global header initially;
- the header remains persistent across Product and Page navigation;
- Workspace changes may update identity, available system links, and resolved Product navigation while preserving Frame structure.

### 8.2. Sidebar Navigation Surface

The sidebar is the primary B- and C-class navigation location.

Initial composition:

```text
Sidebar Navigation Surface
├── authorized B-class Product
├── active B-class Product
│   └── authorized C-class Product Areas
└── authorized sibling B-class Products
```

Rules:

- sibling Products remain accessible;
- only the active Product’s C-class Product Areas are expanded or otherwise exposed by default;
- D-class Pages are excluded;
- Product Areas may use nested disclosure but the sidebar does not add an unlimited hierarchy;
- route state determines the active Product and Product Area;
- authorization filtering occurs before rendering;
- Product navigation Contributions remain owned by Contributors.

Default behavior:

1. enter the Default Workspace;
2. activate the Home Product;
3. render Home and the authorized Product list in the sidebar;
4. navigate to Settings;
5. activate Settings and expose its Product Areas;
6. retain access to Home, Projects, and other authorized sibling Products.

### 8.3. Main

Main receives the active route output.

The owning Core capability or Module controls:

- Page behavior;
- data retrieval;
- authorization;
- PageData and ViewModels when required;
- Product-local actions;
- Product-local navigation;
- view and asset ownership.

UI owns reusable presentation Components and Patterns used to render the Page.

### 8.4. Responsive Composition

Responsive behavior may move navigation controls between header and sidebar presentations without changing canonical hierarchy.

The implementation must preserve:

- semantic source order;
- accessible landmarks and labels;
- focus order;
- current state;
- A/B/C classification;
- one active Workspace;
- one active Product;
- the skip path to Main.

Visual movement at narrow widths does not reclassify a Product link as System navigation or a Product Area as a Product.

## 9. Resolution Model

The conceptual resolution order is:

1. resolve Tenant and Instance;
2. authenticate the User Account;
3. resolve User Account lifecycle and assurance;
4. load active Modules, configuration, Settings, and Preferences;
5. resolve available Workspaces;
6. resolve the active Workspace;
7. resolve the authorized B-class Product set;
8. resolve the active Product and Product Area from the route;
9. collect, validate, filter, and order Frame Surface Contributions;
10. render the Frame through UI-owned presentation;
11. render the active route result in Main.

Exact runtime classes and storage mechanisms are deferred.

Resolution must be deterministic. Filesystem presence alone must not establish Workspace, Product, Product Area, or Frame Surface registration.

## 10. Ownership And Boundaries

| Area                                       | Owner                                                                     | Responsibility                                                                      | Boundary                                             |
| ------------------------------------------ | ------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- | ---------------------------------------------------- |
| Tenant and Instance resolution             | Applicable Core runtime and tenancy owners                                | Establish the isolated runtime scope                                                | Workspace does not replace Instance isolation        |
| User Account access                        | Identity, Auth, and Access                                                | Establish authenticated Principal and allowed operations                            | Workspace selection does not grant authority         |
| Available and active Workspaces            | Core application composition with applicable Workspace owner declarations | Resolve high-level rendered experiences                                             | Must not inspect optional Module internals           |
| Frame                                      | Core application composition plus UI rendering                            | Provide persistent authenticated structure                                          | Products must not create local Frames                |
| Global Header Navigation Surface           | Core navigation Host plus UI                                              | Resolve and render global-header navigation                                         | Does not own linked behavior                         |
| Sidebar Navigation Surface                 | Core navigation Host plus UI                                              | Resolve and render Product and Product Area navigation                              | Does not own Product behavior                        |
| Product                                    | Owning Core capability or Module                                          | Own B-class identity, home Page, Product Areas, routes, behavior, and Contributions | Product is not a fourth owner type                   |
| Product Area                               | Owning Product                                                            | Own C-class grouping and local navigation                                           | Does not become a generic repository owner           |
| Page and drill-down                        | Owning Core capability or Module                                          | Own routed presentation and behavior                                                | Remain outside persistent shell navigation           |
| Reusable Frame and navigation presentation | UI                                                                        | Own Components, Patterns, Layouts, accessibility, and responsive behavior           | Must not query domain state or resolve authorization |
| Navigation authorization and active state  | Core Navigation and Access with owning route policies                     | Filter available navigation and resolve current state                               | Visibility is not authorization                      |

## 11. Contribution And Dependency Model

Frame Surface content uses explicit owner declarations and Host-owned resolution.

Conceptual relationship:

```text
Core capability or Module
    └── owns Product and navigation Contribution
        └── targets Core navigation or Frame Surface Contract
            └── Host Registry validates, filters, orders, and resolves
                └── UI renders the resolved Frame Surface
```

Rules:

- Contributors retain ownership of labels, destinations, active-route patterns, and applicability declarations they supply;
- the Host owns contract validation, collision handling, ordering boundaries, filtering, and output;
- UI renders resolved content and does not discover Modules or query authorization;
- Core navigation does not import optional Module implementation;
- a Module depends only on public Core contracts;
- one Module may not access another Module’s internal navigation implementation;
- route registration and navigation registration remain separate declarations even when one owner supplies both;
- navigation entries must not be inferred from route or filesystem presence alone.

## 12. Example Classifications

### Default Workspace

Contains ordinary authenticated Products such as Home, Settings, and Projects.

### Global Administration Workspace

A rare high-level Workspace for authorized Internal Tenant User Accounts.

It may define a distinct:

- default Product;
- Product set;
- System navigation set;
- global-header composition;
- sidebar composition;
- operating purpose.

It remains within the Internal Tenant Instance and preserves target Tenant and Instance scope separately for authorization and audit.

### Tenant Administration Workspace

A candidate Workspace when tenant administration becomes broad enough to require a distinct high-level rendered experience.

A small group of administration Pages does not automatically justify a Workspace.

### Home Product

The default B-class Product in the Default Workspace.

Its home Page may present dashboard widgets and links to deeper Product Pages without owning every linked behavior.

### Settings Product

A Core-owned B-class Product inside the Default Workspace.

Settings Product Areas may include General, Organization, Localization, Email, and Security.

Navigating to Settings changes the active Product and active C-class navigation. It does not change Workspace.

### Projects Product

An optional Module-owned B-class Product inside the Default Workspace.

Projects may define a Product home, Product Areas, Pages, drill-down resources, and navigation Contributions.

Projects does not own a Workspace, Frame, Frame Surface, or generic `Surface/` Technical Role.

## 13. Canonical Hierarchy, Deep Links, And Breadcrumbs

Canonical hierarchy describes where a destination belongs:

```text
Workspace
→ Product
→ Product Area
→ Page
→ drill-down
```

The invocation path may differ.

A User may open a deep Page from:

- search;
- notifications;
- recent items;
- favorites;
- a dashboard widget;
- an audit event;
- a direct authorized URL.

The deep link does not redefine the Page’s Product or Product Area.

Breadcrumbs should represent the canonical hierarchy needed to return upward.

Breadcrumbs normally begin at D-class Page context when the higher Product and Product Area relationship is no longer sufficiently visible through the global shell or local navigation.

Workspace may be omitted from breadcrumb display when the active Workspace is already clearly indicated by the Frame.

## 14. Data And Persistence

This architecture does not select persistence for:

- available Workspace assignments;
- active Workspace;
- last active Product;
- expanded Product Areas;
- recent Pages;
- navigation customization;
- restored Page state.

Those decisions require applicable feature, database, privacy, and implementation authority.

Possible URL, session, cache, persisted preference, and server-resolved approaches remain open.

No Workspace or navigation table, column, key, or migration is accepted by this document.

## 15. Permissions, Security, And Isolation

- available Workspace resolution must fail closed;
- active Workspace selection must verify User Account access;
- hidden navigation does not replace authorization;
- direct route access must enforce the same policy as visible navigation;
- Core and Module behavior owners retain route and Action authorization;
- Global Administration must preserve Internal Tenant Actor scope and target Tenant and Instance scope;
- Workspace switching must not create implicit cross-Tenant identity linkage;
- navigation Contributions must not expose secrets or sensitive target data;
- Product labels and counts must not reveal unauthorized resources;
- stale or unknown Workspace, Product, and Product Area identifiers must be rejected or mapped only through accepted compatibility rules.

## 16. Accessibility And Interaction

The Frame and navigation implementation must preserve:

- a first-focusable skip link to Main;
- unique labels for multiple navigation landmarks;
- semantic source order matching navigation hierarchy;
- visible current Workspace, Product, Product Area, and Page state where applicable;
- keyboard-operable menus and disclosure controls;
- focus restoration for switchers and collapsed navigation;
- responsive behavior that preserves classification and reading order;
- reduced-motion behavior;
- breadcrumb semantics for drill-down Pages;
- an understandable consequence when Workspace switching would discard unsaved state.

## 17. Operational Considerations

- Workspace and navigation declarations must compile or resolve deterministically;
- duplicate keys, unknown parents, invalid hierarchy, unauthorized targets, and stale output must be detectable;
- active Workspace and navigation state may require cache invalidation after access or Module changes;
- Module enablement or disablement must not leave broken Product navigation;
- removal of a Product must define fallback behavior when it was active;
- Workspace switcher availability must remain consistent with current authorization and Instance state;
- state restoration must not reopen unauthorized Pages after access changes.

## 18. Decisions

The proposed durable decision is [ADR-0008](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md).

This document must not be treated as accepted current architecture until ADR-0008 is accepted by the repository owner and required reviewers.

## 19. Open Questions

The following decisions remain deferred:

1. whether B-class Product links will also appear in the global header;
2. the exact UI and interaction model for the Workspace switcher;
3. whether Tenant Administration qualifies as a separate Workspace;
4. how available and active Workspace state is represented at runtime;
5. whether Workspace selection appears in the URL;
6. whether active Product and sidebar expansion are restored per Workspace;
7. exact Workspace, Product, Product Area, and navigation Contribution descriptor schemas;
8. exact Core capability split among Shell, Navigation, Workspace resolution, and application composition;
9. exact compatibility treatment for current `Surface`, `Shell`, `Platform`, and UI inventory identifiers;
10. exact automated architecture and registration guardrails.

These open questions do not reopen the proposed definitions of Workspace, Frame, Frame Surface, Product, Product Area, Page, or drill-down.

## 20. Related

- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Workspace Identity Model](workspace-identity-model.md)
- [System Overview](system-overview.md)
- [Architecture Index](index.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](../07-planning/Milestones/milestone-0/goal-3/phase-6/6-90-workspace-navigation-and-frame-surface-clarification.md)
- [Navigation Pattern API](../02-standards/ui/patterns/navigation.md)
- [UI Shell Component API Standard](../02-standards/ui/components/ui-shell.md)
- [IBM Carbon Global Header Pattern](https://carbondesignsystem.com/patterns/global-header/)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
