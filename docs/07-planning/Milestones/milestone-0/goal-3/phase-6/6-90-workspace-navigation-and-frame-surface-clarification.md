<!--
DOC-META
title: Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-90-workspace-navigation-and-frame-surface-clarification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted Phase 6 correction for multiple available Workspaces, persistent Frame composition, Frame Surface terminology, and the System-to-Product navigation hierarchy.
-->

# Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Record the accepted corrective architecture identified while selecting and mapping the representative Goal 3 Phase 6 examples.

The correction establishes a deterministic distinction among:

- Workspaces;
- the persistent authenticated Frame;
- named Frame Surfaces;
- System, Product, Product Area, Page, and drill-down navigation;
- global-shell navigation and page-local navigation;
- navigation Contributions and routed application behavior.

This document prevents the broad term `Surface` from continuing to mean a Workspace, product area, page, flow, delivery adapter, Registry, or arbitrary rendered view.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: architecture clarification only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Durable decision: [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- Canonical architecture owner: [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- Current repository implementation: unchanged
- Existing-document reconciliation: applied by the Phase 6 closeout change set; repository validation and Issue #53 closeout remain pending

## 3. Validation Finding

The accepted pre-Phase 6 architecture uses `Surface` as an owner-specific UI presentation and interaction layer that may include a page, destination, area, or multi-step flow.

Applying that definition to the representative Projects Module produced an ambiguous result:

- a Projects overview page could be called a Surface;
- a Projects page family could be called a Surface;
- a Projects interaction flow could be called a Surface;
- a dedicated `Modules/Projects/src/Surface/` Technical Role could appear justified even when no distinct shell-composition responsibility exists.

That ambiguity prevents future work from selecting one obvious owner, role, and repository location.

The validation also exposed that the existing Workspace model does not adequately describe rare, high-level switches among complete rendered experiences such as:

- the normal authenticated application experience;
- Tenant Administration;
- Global Administration.

Phase 6 therefore requires a bounded correction before representative mapping continues.

## 4. External Navigation Benchmark

The proposal uses the [IBM Carbon Global Header pattern](https://carbondesignsystem.com/patterns/global-header/) as an external design benchmark rather than repository authority.

Relevant Carbon concepts include:

- a persistent global header containing system-wide and product-level functionality;
- System-level navigation identified as class A;
- Product-level navigation identified as class B;
- local navigation between areas of a Product;
- a left panel that supports Product navigation and one additional visible hierarchy level;
- drill-down Pages that use breadcrumbs to show the canonical path back upward;
- switcher behavior for moving among Products or systems available to an account.

Login 2.0 adapts those concepts to its accepted Core, Module, UI, Tenant, Instance, User Account, and Workspace model.

## 5. Accepted Vocabulary

### 5.1. Workspace

A **Workspace** is a named, top-level rendered application experience available to an authenticated User Account within its resolved Tenant Instance.

A User Account may have access to one or more Workspaces. Exactly one Workspace is active for a rendered request or interaction context.

A Workspace determines the high-level experience occupying the persistent Frame, including applicable:

- default landing Product and route;
- available Product set;
- System-level navigation;
- Frame Surface composition;
- global navigation context;
- authorized high-level operational purpose.

A Workspace remains derived from Tenant and Instance state, User Account access, active Modules, configuration, Settings, Preferences, and presentation state.

A Workspace is not:

- a Tenant;
- an Instance;
- a database or persistence boundary;
- a Principal;
- an authorization grant;
- an ordinary Product, Module, Page, or sidebar variation.

Workspace availability does not grant access. Every Workspace, Product, route, Page, Action, and target remains subject to its owning authorization policy.

Candidate Workspace classifications are:

| Candidate                       | Accepted treatment                                                                                         |
| ------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| Default Workspace               | Normal authenticated application experience and default Workspace for ordinary Products                    |
| Tenant Administration Workspace | Candidate high-level administration experience when its breadth and ownership justify a separate Workspace |
| Global Administration Workspace | High-level internal administration experience for authorized Internal Tenant User Accounts                 |

Settings and Projects do not qualify as separate Workspaces under this proposal.

### 5.2. Frame

The **Frame** is the persistent authenticated application structure that renders the active Workspace.

The Frame provides stable structural placement for:

- the global header;
- the persistent sidebar;
- the main content outlet;
- responsive navigation disclosure;
- skip-link and landmark behavior;
- globally placed panels and overlays when separately accepted.

The Frame is rendered once by application composition. Products and Pages render within it and must not instantiate independent application shells.

The active Workspace supplies resolved content to the Frame without becoming the reusable Frame implementation owner.

`Shell` may remain an implementation or compatibility term where existing code uses it. `Frame` is the preferred architecture term in this proposal.

### 5.3. Frame Surface

A **Frame Surface** is a named compositional region of the persistent Frame whose resolved content may be contributed to or contextually selected by the active Workspace, Core capabilities, or Modules.

A Frame Surface defines:

- the location in the Frame;
- the accepted content family;
- contribution or replacement behavior;
- ordering and fallback rules;
- presentation contract consumed by UI rendering.

A Frame Surface does not own:

- application behavior;
- route behavior;
- authorization policy;
- persistence;
- Product or Module lifecycle;
- reusable UI implementation;
- Host-independent discovery;
- another owner’s Contribution.

`Surface` may be used as shorthand only when the Frame context is explicit. Generic `Surface`, `Surfaces/`, or owner-local `Surface/` folders are not authorized by this proposal.

The lowercase visual-design use of “surface,” such as a background or layer token, remains unrelated to the formal `Frame Surface` architecture term.

### 5.4. Initial Frame Surfaces

The initial Frame Surfaces are:

#### Global Header Navigation Surface

The persistent global-header navigation region.

It may contain two governed subregions:

- a Product Navigation region for optional B-class Product links;
- a Global Actions region for A-class System navigation and global utilities.

A-class navigation belongs only in the Global Actions portion of the global header.

Global utilities such as notifications, account access, search, or help may share the Global Actions region but remain utilities rather than canonical navigation parents.

#### Sidebar Navigation Surface

The persistent left-panel navigation region.

Its initial model is:

- display the B-class Products available in the active Workspace;
- expand or otherwise reveal the C-class Product Areas for the active Product;
- preserve obvious access to sibling B-class Products;
- exclude D-class Pages and unbounded user-created content from global-shell navigation.

The Home Product is active by default after login in the Default Workspace. Navigating to Settings changes the active Product and exposes Settings Product Areas while retaining access to sibling Products.

### 5.5. Main Content Outlet

The Frame’s main region is the **Main Content Outlet**.

It is not a Frame Surface under this proposal.

The active route renders the owning Product’s Page or flow into Main. Calling Main a Surface would reintroduce the ambiguity this correction is intended to remove.

## 6. Accepted Navigation Hierarchy

| Class | Canonical term | Responsibility                                                                          | Global shell placement                                                 |
| ----- | -------------- | --------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| A     | System         | Workspace switching, major system destinations, and system-wide navigation              | Global Actions portion of the global header only                       |
| B     | Product        | Major Core- or Module-owned capability used directly by the User                        | Persistent sidebar; optionally Product Navigation in the global header |
| C     | Product Area   | Coherent area of one Product containing related Pages and workflows                     | One nested sidebar level or Product-local navigation                   |
| D     | Page           | One routed destination, overview, collection, detail, form, report, or operational view | Main content only; breadcrumbs begin at this level                     |
| E+    | Drill-down     | Resource, subresource, task, or deeper focused context                                  | Page-local and contextual navigation only                              |

The class letters are review shorthand. Canonical prose and implementation-facing vocabulary should use the semantic terms.

### 6.1. A-Class System Navigation

A-class navigation:

- belongs only in the Global Actions portion of the global header;
- may expose the Workspace switcher and other accepted system destinations;
- must remain globally understandable and intentionally sparse;
- must not contain ordinary Product Areas or Pages;
- must not be inferred from authorization alone.

### 6.2. B-Class Product Navigation

A Product is a major user-facing capability owned by one Core capability or optional Module.

Representative Products include:

- Home;
- Settings;
- Projects.

A Product normally owns:

- one B-class navigation identity;
- a Product home or overview Page;
- its C-class Product Areas;
- Product-local route hierarchy;
- applicable navigation Contributions.

Product is a navigation and UX classification. It does not create a fourth source-of-truth ownership area.

The initial target places B-class Products primarily in the persistent sidebar. Whether selected B-class links also appear in the global header remains deferred.

### 6.3. C-Class Product Area Navigation

A Product Area is a coherent part of one Product containing related Pages that support a recognizable workflow or responsibility.

Examples may include:

```text
Settings
├── General
├── Organization
├── Localization
├── Email
└── Security
```

```text
Projects
├── Overview
├── Active Projects
├── Templates
└── Archive
```

C-class Product Areas may appear:

- as the single supported nested level beneath an active B-class Product in the sidebar;
- within the Product home or overview Page;
- through Product-local tabs or another accepted local-navigation pattern.

### 6.4. D-Class Page Navigation

A Page is one routed Product destination.

D-class Pages:

- do not belong in the global header or persistent sidebar by default;
- render within Main;
- begin the breadcrumb requirement when the Page is below the visible Product and Product Area hierarchy;
- may be linked from Product dashboards, widgets, lists, tables, search, notifications, recent items, or contextual actions.

### 6.5. E-Class And Deeper Drill-Down

E-class and deeper locations represent resource or task drill-down within the owning Product.

They remain Page-local and use:

- breadcrumbs;
- tabs;
- contextual navigation;
- in-page links;
- table or list navigation;
- task-flow controls.

No fixed noun is required for every deeper level. Use the actual domain term when it is clearer than generic depth language.

## 7. Canonical Hierarchy And Shortcut Navigation

The navigation hierarchy defines canonical parentage, not every possible click path.

A deep link may open a D- or E-level Page from:

- search;
- a notification;
- a recent-item list;
- a favorite;
- a dashboard widget;
- an audit event;
- another authorized contextual link.

That shortcut does not change the Page’s canonical hierarchy.

Breadcrumbs and current-navigation state reflect canonical Product and Product Area ownership rather than the shortcut used to arrive.

## 8. Accepted Composition Model

### 8.1. Global Header

The global header remains persistent across the active Workspace.

Accepted placement:

```text
Global Header Navigation Surface
├── Product Navigation region
│   └── optional B-class Product links
└── Global Actions region
    ├── A-class System navigation
    └── global utilities
```

A-class links must not move into the Product Navigation region.

B-class header links are optional and remain deferred until navigation density, responsive behavior, and duplication rules are accepted.

### 8.2. Persistent Sidebar

The initial sidebar model is:

```text
Sidebar Navigation Surface
├── Home Product
├── Projects Product
│   └── C-class Product Areas when active
├── Settings Product
│   └── C-class Product Areas when active
└── other authorized Products
```

The sidebar does not disappear merely because a Product needs contextual navigation. The active Product controls the C-class portion while sibling B-class Products remain accessible.

### 8.3. Main

Main renders:

- the Product home or overview Page;
- D-class Pages;
- drill-down Pages;
- Product-owned dashboards, widgets, lists, forms, details, and flows.

Main does not participate in Frame Surface contribution resolution.

## 9. Example Classifications

| Example                              | Accepted classification                       | Rationale                                                                                   |
| ------------------------------------ | --------------------------------------------- | ------------------------------------------------------------------------------------------- |
| Default authenticated experience     | Default Workspace                             | High-level rendered experience containing ordinary Products                                 |
| Global Administration                | Global Administration Workspace               | Rare, high-level experience with different system purpose and navigation composition        |
| Tenant Administration                | Candidate Tenant Administration Workspace     | Requires separate acceptance when breadth and ownership justify it                          |
| Home or Dashboard                    | B-class Product and default Product home Page | Provides the default Product context after login                                            |
| Settings                             | B-class Core Product                          | Uses C-class Product Areas; does not require a separate Workspace                           |
| Projects                             | B-class optional Module Product               | Uses Product home, Areas, Pages, and drill-down without owning a Workspace or Frame Surface |
| General, Email, Security settings    | C-class Settings Product Areas                | Visible beneath Settings or through Product-local navigation                                |
| Project detail                       | D- or deeper Page                             | Rendered in Main with breadcrumb and contextual navigation                                  |
| Modal and Dialog                     | Reusable UI Components                        | Presentation infrastructure, not navigation hierarchy or Frame Surface                      |
| Global Header navigation region      | Frame Surface                                 | Accepts resolved A/B navigation according to its contract                                   |
| Persistent sidebar navigation region | Frame Surface                                 | Resolves B Products and active C Product Areas                                              |
| Main content                         | Main Content Outlet                           | Route-owned content destination, not a Frame Surface                                        |

## 10. Ownership And Dependency Direction

| Concern                                                                   | Accepted owner                                                                  | Boundary                                                                     |
| ------------------------------------------------------------------------- | ------------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Workspace availability and active Workspace resolution                    | Core application composition, Navigation, and Access responsibilities           | Must not depend on optional Module internals or filesystem discovery         |
| Frame structure and Frame Surface hosting                                 | Core application composition with UI-owned reusable rendering                   | Products may contribute content but may not replace the Frame implementation |
| Frame reusable Components and responsive behavior                         | UI                                                                              | Must not resolve Products, Workspaces, authorization, or route ownership     |
| A-class System navigation definitions                                     | Applicable Workspace or Core system owner                                       | Must be declared and authorized; only rendered in Global Actions             |
| B-class Product definition                                                | Owning Core capability or Module                                                | Product identity does not transfer behavior ownership                        |
| C-class Product Area definition                                           | Owning Product                                                                  | Must not create generic cross-owner navigation ownership                     |
| D-class and deeper Pages                                                  | Owning Core capability or Module                                                | Render in Main and remain outside global-shell navigation                    |
| Navigation contribution validation, ordering, filtering, and active state | Host-owned Core Navigation Registry or equivalent accepted composition boundary | Contributors retain ownership; Registry must not inspect internals           |
| Route authorization and Action authorization                              | Owning Core capability or Module plus Access                                    | Navigation visibility is not authorization                                   |

Dependency direction remains:

```text
Core or Module owner declaration
    -> Core navigation and Frame Surface contracts
    -> Host-owned validation and resolution
    -> UI-owned Frame rendering
```

UI must not depend on Core or Module implementation.

Core must not depend on optional Module implementation.

## 11. Phase 6 Impact

The representative set should be revised to:

1. Settings as the required Core capability;
2. Projects as the optional Module;
3. Modal and Dialog as the reusable UI example;
4. Sidebar Navigation Surface as the representative Frame Surface.

Projects must not be represented through `Modules/Projects/src/Surface/`.

The Projects mapping should instead validate applicable:

- Product identity;
- Product home Page;
- Product Areas;
- route ownership;
- navigation Contributions;
- PageData, ViewModels, Presenters, or other precise roles only when required;
- package-local views and assets.

## 12. Deferred Reconciliation Register

No existing file is updated by this draft package.

After ADR-0008 is accepted, Phase 6 closeout and Goal 3 reconciliation must evaluate and update the applicable portions of:

- `docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md`;
- `docs/01-decisions/index.md`;
- `docs/03-architecture/workspace-identity-model.md`;
- `docs/03-architecture/system-overview.md`;
- `docs/03-architecture/index.md`;
- `docs/02-standards/ui/patterns/navigation.md`;
- `docs/02-standards/ui/components/ui-shell.md`;
- `docs/02-standards/ui/patterns/layout.md` only where terminology conflicts;
- `docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md`;
- Phase 2.90 Surface, Host, and Registry correction documents;
- Phase 4 placement and dependency matrices;
- Phase 5 naming and role terminology documents;
- GitHub Issue #53 wording and final acceptance record.

Reconciliation must preserve historical decisions and use explicit supersession or compatibility notes rather than silently rewriting accepted history.

## 13. Non-Goals

This clarification does not define:

- database storage for available or active Workspace state;
- whether the active Workspace is represented in URL, session, cache, User preference, or another mechanism;
- exact Workspace, Product, Product Area, or navigation descriptor schemas;
- exact resolver, Registry, Provider, or class names;
- complete authorization behavior;
- exact Blade APIs;
- exact responsive breakpoints or mobile movement rules;
- every future Frame Surface;
- every future Workspace;
- detailed Product information architecture;
- migration of current shell, route, or navigation implementation;
- implementation of the Carbon switcher component.

## 14. Accepted Decision

> Login 2.0 will treat a Workspace as a rare, named, top-level rendered experience available to an authenticated User Account within its resolved Tenant Instance. A User Account may have access to multiple Workspaces, with exactly one active for a rendered interaction context.
>
> The persistent authenticated structure is the Frame. The Frame hosts named Frame Surfaces whose resolved content may be contributed to or contextually selected without transferring application behavior ownership.
>
> The initial Frame Surfaces are the Global Header Navigation Surface and Sidebar Navigation Surface. Main is a route-owned content outlet rather than a Frame Surface.
>
> Navigation uses System (A), Product (B), Product Area (C), Page (D), and drill-down (E+) classes. A-class navigation appears only in the Global Actions portion of the global header. B-class Products appear primarily in the persistent sidebar. The active Product exposes its C-class Product Areas while sibling Products remain accessible. D-class and deeper destinations render in Main and use breadcrumbs and local navigation.
>
> Settings and Projects are Products within the Default Workspace. Global Administration is a separate Workspace candidate selected through A-class System navigation. `Surface` no longer means a page, area, flow, Product, Workspace, delivery adapter, or generic owner-local Technical Role.

## 15. Verification

Before Phase 6 accepts this correction, confirm that:

- Workspace, Frame, Frame Surface, Product, Product Area, Page, and drill-down terms have non-overlapping definitions;
- multiple available Workspaces do not create a new Tenant, Instance, Principal, or authorization boundary;
- Global Administration is no longer described as an ordinary Surface;
- A-class links are restricted to the Global Actions region;
- B-class Products remain accessible while the active Product exposes C-class navigation;
- D-class and deeper locations remain outside global-shell navigation;
- deep links do not alter canonical hierarchy;
- Main is not classified as a Frame Surface;
- Projects does not require a `Surface/` Technical Role;
- UI remains independent of Core and Module implementation;
- Core remains independent of optional Module implementation;
- existing accepted documents are listed for later explicit reconciliation;
- documentation guardrails and `git diff --check` pass after repository application.

## 16. Related

- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../phase-2/2-90-surface-host-registry-reclassification.md)
- [Phase 4 Artifact Placement Matrix](../phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](../phase-4/dependency-and-communication-matrix.md)
- [Phase 5 Role Terminology Matrix](../phase-5/role-terminology-matrix.md)
- [ADR-0006](../../../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [IBM Carbon Global Header Pattern](https://carbondesignsystem.com/patterns/global-header/)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
