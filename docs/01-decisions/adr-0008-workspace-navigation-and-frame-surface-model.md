<!--
DOC-META
title: ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model
doc_type: decision
status: draft
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Proposes multiple available Workspaces, a persistent authenticated Frame, narrowly defined Frame Surfaces, and a System-to-Product navigation hierarchy.
-->

# ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model

Parent: [Decisions Index](index.md)

## 1. Decision Status

Proposed

## 2. Dates

- Proposed: 2026-07-17
- Accepted, rejected, deprecated, or superseded:

## 3. Decision Owner

- Owner: Login 2.0 architecture owner
- Required reviewers: repository owner; architecture reviewer; UI and navigation reviewer; accessibility reviewer; Access and security reviewer
- Acceptance source: pending repository-owner review in GitHub Issue #53 and the associated Goal 3 Phase 6 review

## 4. Related Work

- GitHub issue: [#53 — Validate the repository architecture model](https://github.com/kyleswindell/login-v2/issues/53)
- Parent goal: [#19 — M0 Goal 03: Target repository topology and naming](https://github.com/kyleswindell/login-v2/issues/19)
- Planning document: [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](../07-planning/Milestones/milestone-0/goal-3/phase-6/6-90-workspace-navigation-and-frame-surface-clarification.md)
- Proposed architecture owner: [Workspace Navigation And Frame Composition](../03-architecture/workspace-navigation-and-frame-composition.md)
- Prior decisions:
  - [ADR-0005: Core, Modules, And UI Ownership Taxonomy](adr-0005-core-modules-ui-ownership-taxonomy.md)
  - [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
  - [ADR-0007: Owner, Registry, And Identifier Key Conventions](adr-0007-owner-registry-and-identifier-key-conventions.md)
- External benchmark: [IBM Carbon Global Header Pattern](https://carbondesignsystem.com/patterns/global-header/)
- Affected canonical owners:
  - `docs/01-decisions/`
  - `docs/02-standards/ui/`
  - `docs/03-architecture/`
  - `docs/07-planning/Milestones/milestone-0/goal-3/`

## 5. Context

ADR-0006 established Workspace as the User Account-specific resolved runtime and user-experience scope through which an authenticated User interacts with one Tenant Instance.

It also classified Global Administration as a privileged Surface inside the Internal Tenant User Account’s resolved Workspace.

Goal 3 later defined Surface broadly as an owner-specific UI presentation and interaction layer that might represent a page, destination, area, or multi-step flow. Phase 4 permitted owner-local `Surface/` Technical Roles for presentation-specific implementation.

Phase 6 representative mapping demonstrated that these meanings are not deterministic enough for repository architecture:

- an ordinary Module overview could be classified as a Surface;
- a page family could be classified as a Surface;
- a multi-step flow could be classified as a Surface;
- a dedicated `Surface/` folder could be introduced without a distinct architecture responsibility;
- Global Administration, Settings, Projects, and ordinary Pages could all compete for the same term despite materially different scope.

The repository also requires a stable model for navigation through a persistent global header and persistent sidebar. The chosen Carbon-aligned navigation direction distinguishes:

- System-level navigation;
- Product-level navigation;
- Product Areas;
- routed Pages;
- deeper drill-down.

Without a durable correction, navigation ownership, Workspace switching, Frame composition, route hierarchy, breadcrumbs, and repository placement will remain ambiguous.

## 6. Decision Drivers

- preserve Tenant, Instance, User Account, Principal, and authorization boundaries accepted by ADR-0006;
- support rare high-level switching among complete rendered experiences;
- retain one persistent authenticated Frame;
- make Frame contribution regions explicit and bounded;
- prevent `Surface` from becoming a generic owner, folder, page, flow, or delivery term;
- align global-header and persistent-sidebar behavior with a coherent System-to-Product navigation hierarchy;
- keep ordinary Core capabilities and Modules from gaining shell-level authority merely because they render Pages;
- preserve Core independence from optional Modules;
- preserve UI independence from Core and Module implementation;
- support deterministic ownership, placement, naming, testing, and future architecture enforcement;
- retain clear accessibility landmarks, source order, skip-link behavior, and breadcrumb expectations.

## 7. Decision

Login 2.0 will use the model below.

### 7.1. Workspace Availability And Active Workspace

A **Workspace** is a named, top-level rendered application experience available to an authenticated User Account within its resolved Tenant Instance.

A User Account may have access to one or more Workspaces. Exactly one Workspace is active for a rendered request or interaction context.

The available Workspace set and active Workspace are resolved from applicable:

- Tenant and Instance state;
- User Account lifecycle and access;
- active Modules;
- configuration;
- Settings and Preferences;
- presentation state.

A Workspace may define:

- a default landing Product and route;
- the available Product set;
- A-class System navigation;
- Frame Surface composition;
- high-level operational purpose.

A Workspace remains a runtime and UX scope. It is not:

- a Tenant;
- an Instance;
- a database boundary;
- a stored organization container;
- a Principal;
- an authorization grant;
- an ordinary Product, Page, Module, or navigation submenu.

Workspace selection does not grant authority. Route, Action, resource, and target authorization remain owned by the applicable behavior owner and Access policy.

The initial architecture recognizes:

- a Default Workspace;
- a Global Administration Workspace for authorized Internal Tenant User Accounts;
- a candidate Tenant Administration Workspace subject to later breadth, ownership, and product review.

Settings and Projects are Products within the Default Workspace rather than separate Workspaces.

### 7.2. Persistent Frame

The **Frame** is the persistent authenticated application structure that renders the active Workspace.

The Frame provides stable placement and accessibility structure for:

- the global header;
- the persistent sidebar;
- the Main Content Outlet;
- responsive navigation disclosure;
- skip-link behavior;
- landmark regions;
- accepted globally placed panels and overlays.

The Frame is rendered once by application composition. Products and Pages render inside it and must not create independent application shells.

The active Workspace provides resolved composition to the Frame without becoming the reusable Frame implementation owner.

`Shell` may remain a compatibility or implementation term in existing code. `Frame` is the canonical architecture term for the persistent authenticated structure.

### 7.3. Frame Surface

A **Frame Surface** is a named compositional region of the persistent Frame whose content may be contributed to or contextually selected by an authorized Workspace, Core capability, or Module.

A Frame Surface owns only its composition contract:

- location;
- accepted contribution family;
- ordering;
- filtering;
- active-state input;
- fallback behavior;
- output consumed by UI rendering.

A Frame Surface does not own:

- application behavior;
- routes;
- persistence;
- authorization policy;
- Product lifecycle;
- Module lifecycle;
- reusable UI implementation;
- another owner’s Contribution.

The initial Frame Surfaces are:

1. **Global Header Navigation Surface**
2. **Sidebar Navigation Surface**

The Main Content Outlet is not a Frame Surface. It renders route-owned Product Pages and flows.

`Surface` may be used as shorthand only when the Frame context is explicit. Generic `Surface`, plural `Surfaces/`, and owner-local catch-all `Surface/` Technical Roles are not canonical target destinations.

The visual-design use of “surface” for backgrounds, layers, and color roles is unaffected.

### 7.4. Navigation Hierarchy

Login 2.0 navigation uses these semantic classes:

| Class | Term         | Meaning                                                                    |
| ----- | ------------ | -------------------------------------------------------------------------- |
| A     | System       | Workspace switching, major system destinations, and system-wide navigation |
| B     | Product      | Major Core- or Module-owned capability used directly by the User           |
| C     | Product Area | Coherent area of one Product containing related Pages and workflows        |
| D     | Page         | One routed Product destination                                             |
| E+    | Drill-down   | Resource, subresource, task, or deeper focused context                     |

The class letters are review shorthand. Canonical names are System, Product, Product Area, Page, and drill-down.

### 7.5. Shell Placement

A-class System navigation appears only in the **Global Actions** portion of the Global Header Navigation Surface.

The Global Actions region may also host global utilities such as notifications, account access, search, or help. Those utilities are not canonical navigation parents merely because they occupy the same region.

B-class Product navigation appears primarily in the persistent Sidebar Navigation Surface.

Selected B-class links may also appear in the Product Navigation portion of the global header after a later accepted navigation-density and duplication decision.

C-class Product Areas may appear:

- as one nested visible level beneath the active Product in the sidebar;
- on the Product home Page;
- through Product-local tabs or another accepted local-navigation pattern.

D-class Pages and deeper locations do not belong in the persistent global shell by default. They render in Main and use breadcrumbs or local navigation when hierarchy must be exposed.

### 7.6. Sidebar Resolution

The initial Sidebar Navigation Surface model is persistent Product navigation with active Product Area expansion.

The sidebar:

- lists the authorized B-class Products in the active Workspace;
- reveals the C-class Product Areas for the active Product;
- preserves access to sibling Products;
- excludes D-class Pages and unbounded user-created resources from persistent shell navigation.

The Home Product is active by default after entering the Default Workspace.

Navigating to Settings activates the Settings Product, navigates to its Product home or requested Page, and reveals the Settings Product Areas without hiding all sibling Products.

Projects follows the same model and does not receive a Workspace, Frame, or generic Surface merely because it has an overview Page and contextual navigation.

### 7.7. Canonical Hierarchy And Deep Links

The hierarchy defines canonical parentage, not every possible click path.

Search, notifications, recent items, favorites, widgets, audit records, and contextual links may open D- or E-level Pages directly.

A shortcut does not alter Product or Product Area ownership. Breadcrumbs and active navigation reflect canonical hierarchy rather than the shortcut used to arrive.

Breadcrumbs normally begin when a route enters D-class Page context below the visible Product and Product Area hierarchy.

### 7.8. Ownership And Dependency Direction

Core application composition, Navigation, Access, and applicable Workspace owners resolve:

- available Workspaces;
- active Workspace;
- authorized Product availability;
- Frame Surface Contributions;
- ordering and active state.

Core capabilities and Modules own their:

- Product identities;
- Product Areas;
- routes;
- Pages;
- Actions and Queries;
- navigation Contributions.

UI owns reusable Frame, header, sidebar, navigation, menu, breadcrumb, layout, responsive, and accessibility rendering contracts.

The accepted dependency direction is:

```text
Core capability or Module declaration
    -> Core navigation and Frame Surface contracts
    -> Host-owned validation and resolution
    -> UI-owned Frame rendering
```

UI must not depend on Core or Module implementation.

Core must not depend on optional Module implementation.

Navigation visibility must not replace route or Action authorization.

## 8. Scope And Boundaries

### Applies To

- authenticated Workspace resolution;
- Workspace availability and active Workspace selection;
- Global Administration and Tenant Administration classification;
- persistent Frame composition;
- global header and persistent sidebar responsibilities;
- Frame Surface terminology;
- System, Product, Product Area, Page, and drill-down navigation;
- navigation Contributions, ordering, filtering, and current state;
- breadcrumb hierarchy;
- responsive movement of navigation regions;
- Goal 3 ownership, placement, naming, and future guardrails.

### Does Not Apply To

- Tenant or Instance cardinality;
- User Account or User Identity cardinality;
- Principal, Actor, Machine Identity, Network Identity, or Invocation Channel definitions;
- detailed Workspace authorization policy;
- database schema;
- active Workspace persistence mechanism;
- exact route or URL design;
- exact registration descriptor schemas;
- exact Blade, JavaScript, or CSS APIs;
- detailed Product information architecture;
- product-specific feature behavior;
- implementation sequencing;
- physical repository migration.

### Compatibility And Transition Boundaries

- existing `Surface`, `Shell`, `Platform`, route, navigation, and UI-shell identifiers may remain temporarily when verified compatibility requires them;
- compatibility identifiers do not remain equally canonical;
- existing documents must be reconciled through explicit supersession, replacement notes, or terminology corrections;
- no physical migration is authorized by this decision alone;
- no current `app/Surfaces/`, owner-local `Surface/`, or other transitional path becomes target authority.

## 9. Alternatives Considered

### Alternative A — Retain The Broad Surface Definition

Summary:

Continue using Surface for pages, destinations, areas, multi-step flows, and shell-level experiences.

Reasons not selected:

- does not yield deterministic repository placement;
- encourages generic `Surface/` Technical Roles;
- overlaps Product, Product Area, Page, Flow, Workspace, and delivery terminology;
- caused Projects to be misclassified during Phase 6 validation.

### Alternative B — Replace Surface With Application Area Or Application Experience

Summary:

Create a new top-level term beneath Workspace for major shell-changing experiences.

Reasons not selected:

- duplicates the high-level UX purpose already carried by Workspace;
- creates another layer between Workspace and Product without a demonstrated need;
- leaves the shell-region contribution problem unresolved;
- risks `Area` becoming as broad as Surface.

### Alternative C — Preserve One Workspace And Keep Global Administration As A Surface

Summary:

Continue treating Global Administration as one privileged Surface inside the Internal Tenant Workspace.

Reasons not selected:

- understates the magnitude of the navigation and operating-context change;
- keeps Workspace switching unavailable as a first-class concept;
- conflicts with the desired high-level switcher experience;
- continues to overload Surface.

### Alternative D — Replace The Sidebar Completely For Every Active Product

Summary:

Allow each Product to replace the entire sidebar with only its own Product Areas.

Reasons not selected:

- removes the primary access path to sibling Products when B-class navigation is sidebar-owned;
- makes B-class header duplication mandatory before it has been accepted;
- increases orientation and backtracking costs;
- does not follow the initial persistent B plus active C model.

## 10. Consequences

### Positive

- Workspace becomes the clear high-level switcher identity;
- Global Administration receives an appropriately large UX boundary;
- Surface becomes a deterministic Frame-composition term;
- ordinary Products and Pages no longer gain generic Surface ownership;
- the persistent header and sidebar receive explicit composition contracts;
- A, B, C, D, and deeper navigation have stable semantic names;
- Projects and Settings can be mapped without creating owner-local `Surface/` folders;
- navigation hierarchy, breadcrumbs, shortcuts, and active state become separately understandable;
- future static checks can prohibit broad Surface paths and validate shell-level contribution families.

### Negative

- ADR-0006 and several accepted Goal 3 documents require explicit reconciliation;
- current UI and planning documentation use `surface` in several incompatible senses;
- Workspace cardinality and Global Administration classification change materially;
- implementation cannot proceed safely from existing Surface terminology until reconciliation is accepted;
- some existing inventory and tooling fields may retain historical `surface` names during compatibility migration.

### Neutral Tradeoffs

- `Surface` remains available as shorthand only for Frame Surface and as an unrelated lowercase visual-design term;
- B-class header links remain possible but are not required initially;
- Tenant Administration remains a candidate Workspace rather than an automatically accepted one;
- the Frame can remain structurally persistent while Workspace-level content changes substantially.

### Security, Privacy, And Data

- Workspace visibility and navigation visibility do not grant authorization;
- every deep link must enforce its owning route and Action policies;
- Global Administration must preserve Internal Tenant Actor scope and target Tenant and Instance scope separately;
- unavailable or unauthorized Workspaces and Products must fail closed;
- the decision creates no new cross-Tenant identity relationship;
- no persistence design or sensitive data is accepted by this decision.

### Operational And Migration

- existing documents require staged terminology reconciliation;
- current implementation may retain compatibility paths and identifiers until bounded migration work proves removal safety;
- active Workspace persistence, URL behavior, session behavior, and restoration remain later implementation decisions;
- responsive movement between header and sidebar must preserve source order, accessibility, and canonical hierarchy.

## 11. Implementation Implications

- implementation areas: Workspace resolution; Core navigation composition; Frame Surface Host contracts; navigation Contributions; UI Frame rendering; breadcrumb and active-state resolution
- migrations: none authorized by this decision
- compatibility behavior: verified legacy `Surface`, `Shell`, `Platform`, navigation, and UI inventory identifiers may remain transitional with explicit migration ownership
- deployment or rollback: not applicable to this decision-only proposal
- required GitHub issues: later bounded Workspace switching, navigation registration, UI-shell correction, and compatibility migration issues as needed
- specialist review: architecture; UI/navigation; accessibility; Access/security; repository-owner review

This section is not a full implementation plan.

## 12. Canonical Documentation Updates

### Create

- `docs/03-architecture/workspace-navigation-and-frame-composition.md`

### Update After Acceptance

- `docs/01-decisions/index.md`
- `docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md`
- `docs/03-architecture/index.md`
- `docs/03-architecture/workspace-identity-model.md`
- `docs/03-architecture/system-overview.md`
- `docs/02-standards/ui/patterns/navigation.md`
- `docs/02-standards/ui/components/ui-shell.md`
- `docs/02-standards/ui/patterns/layout.md` only where terminology conflicts
- `docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md`
- applicable Phase 2, Phase 4, Phase 5, and Phase 6 Goal 3 documents
- GitHub Issue #53

### Supersede Or Archive

- no file is superseded in full by this proposed decision;
- the applicable Workspace and Global Administration provisions of ADR-0006 are partially superseded only if this ADR is accepted;
- the broad Surface definition and owner-local generic `Surface/` role are replaced through later canonical reconciliation rather than archival of all affected documents.

## 13. Verification

Implementation and documentation alignment must confirm:

- one or more Workspaces can be available without changing Tenant, Instance, or User Account identity;
- exactly one Workspace is active for a rendered interaction context;
- Global Administration is modeled as a Workspace rather than an ordinary Surface;
- Frame and Frame Surface have non-overlapping responsibilities;
- Global Header Navigation Surface and Sidebar Navigation Surface use explicit contribution contracts;
- A-class links render only in Global Actions;
- B-class Products remain accessible while active C-class Product Areas are exposed;
- D-class and deeper Pages remain outside persistent shell navigation;
- breadcrumbs and deep links preserve canonical hierarchy;
- Main remains a content outlet rather than a Frame Surface;
- Projects and Settings do not require generic `Surface/` Technical Roles;
- UI contains no dependency on Core or Module implementation;
- Core contains no dependency on optional Module implementation;
- navigation visibility never replaces authorization;
- affected documentation is reconciled without hiding prior accepted history;
- repository documentation guardrails pass;
- `git diff --check` passes.

## 14. Supersession

### Supersedes

If accepted, this decision partially supersedes:

- ADR-0006 Section 7.2 only where Global Administration is classified as a Surface inside one Workspace;
- ADR-0006 Section 7.3 only where one User Account is described as receiving one indivisible resolved Workspace per active authenticated runtime;
- ADR-0006 Alternative D only where a separate high-level administration Workspace is rejected solely in favor of a Surface.

All ADR-0006 Tenant, Instance, User Account, User Identity, Principal, Actor, Machine Identity, Network Identity, Network Context, and Invocation Channel decisions remain operative.

### Superseded By

- None

### Transition Plan

- record acceptance or rejection in Issue #53;
- add bidirectional partial-supersession notes to ADR-0006 only after acceptance;
- synchronize the current-state architecture and UI standards during Phase 6 closeout and final Goal 3 documentation alignment;
- retain existing runtime identifiers as transitional until separately verified migration issues authorize changes.

## 15. Acceptance Or Rejection Record

Complete this section when the proposal is resolved.

- Outcome:
- Date:
- Accepted or rejected by:
- Evidence:
- Required follow-up:

## 16. Related

- [Decisions Index](index.md)
- [ADR-0006](adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0005](adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0007](adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](../07-planning/Milestones/milestone-0/goal-3/phase-6/6-90-workspace-navigation-and-frame-surface-clarification.md)
- [Workspace Navigation And Frame Composition](../03-architecture/workspace-navigation-and-frame-composition.md)
- [IBM Carbon Global Header Pattern](https://carbondesignsystem.com/patterns/global-header/)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
