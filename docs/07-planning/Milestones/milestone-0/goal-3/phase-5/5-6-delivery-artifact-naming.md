<!--
DOC-META
title: Phase 5.6 Delivery Artifact Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-6-delivery-artifact-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records naming rules for HTTP, console, presentation, rendering, and webhook delivery artifacts.
-->

# Phase 5.6 Delivery Artifact Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define delivery names that identify both the exposed behavior and the delivery responsibility while keeping application behavior with its Core capability or Module owner.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decisions 5.4 and 5.5 plus Phase 4 Delivery Adapter placement

## 3. Naming Matrix

| Artifact                  | Pattern                           | Example                                   |
| ------------------------- | --------------------------------- | ----------------------------------------- |
| Resource controller       | `<Subject>Controller`             | `UserController`                          |
| Single-purpose controller | `<Verb><Subject>Controller`       | `SuspendUserController`                   |
| Form Request              | `<Verb><Subject>Request`          | `UpdateUserRequest`                       |
| Middleware                | `<Purpose>Middleware`             | `RequireRecentAuthenticationMiddleware`   |
| API Resource              | `<Subject>Resource`               | `UserResource`                            |
| API collection            | `<Subject>Collection`             | `UserCollection`                          |
| Presenter                 | `<SubjectOrSurface>Presenter`     | `UserIndexPresenter`                      |
| Renderer                  | `<SubjectOrFormat>Renderer`       | `AuditCsvRenderer`                        |
| Page data                 | `<PageOrSurface>PageData`         | `UserIndexPageData`                       |
| ViewModel                 | `<SubjectOrSurface>ViewModel`     | `UserIndexViewModel`                      |
| Console command           | `<Verb><Subject>Command`          | `RebuildRegistrationManifestCommand`      |
| Webhook handler           | `<Provider><Event>WebhookHandler` | `QuickBooksCustomerUpdatedWebhookHandler` |

## 4. Role Distinctions

- A Controller parses an HTTP invocation, delegates application behavior, and shapes an HTTP response.
- A Form Request validates and normalizes one HTTP operation.
- Middleware names the condition enforced, context established, or transport concern applied.
- An API Resource or Collection represents prepared application results for API delivery.
- A Presenter transforms results into presentation-ready data without rendering output or owning policy.
- A Renderer produces one concrete representation such as CSV, JSON, or document output.
- PageData is an immutable data carrier for one page or Surface.
- A ViewModel is used only when presentation-specific derived state or behavior is required beyond PageData.
- A Command parses console input, invokes owner-controlled behavior, formats output, and returns an exit result.
- A WebhookHandler handles one explicit provider event or payload type.

Controller subjects are singular.

## 5. Sparse Delivery Structure

Owner-local delivery roles may use these sparse subdivisions when needed:

```text
Http/
├── Controllers/
├── Requests/
├── Middleware/
├── Resources/
├── Presenters/
├── Renderers/
├── ViewModels/
├── PageData/
└── Webhooks/

Console/
└── Commands/
```

API delivery remains beneath `Http/`. These role folders do not become owners and must not be created solely to complete a template.

## 6. Generic Abstraction Boundary

Concrete delivery classes remain specific.

Avoid:

```text
DeliveryAdapter
BaseController
CommonPresenter
DefaultRenderer
PageViewModel
WebhookHandler
IntegrationHandler
PayloadHandler
```

A framework root `Controller`, abstract delivery base, or shared middleware contract may retain a generic role only when it provides one exact bounded framework mechanism. It must not absorb owner behavior or create a generic application layer.

## 7. Accepted Decision

> Delivery artifact class names identify both the behavior exposed and the delivery role.
> Resource-oriented controllers use `<Subject>Controller`. Controllers dedicated to one operation use `<Verb><Subject>Controller`. Controller subjects are singular. Controllers coordinate HTTP delivery and delegate application behavior to owner-controlled Actions, Queries, or Contracts.
> Form Requests use `<Verb><Subject>Request` and correspond to one HTTP operation. Generic names such as `UserRequest`, `BaseRequest`, and `DataRequest` are prohibited.
> Middleware uses `<Purpose>Middleware`. The name must state the condition enforced, context established, or transport concern applied.
> API representations use `<Subject>Resource`; resource collections use `<Subject>Collection`. API delivery remains within the owner’s `Http/` role.
> Presenters use `<SubjectOrSurface>Presenter` and transform application results into presentation-ready structures without rendering output or owning application policy.
> Renderers use `<SubjectOrFormat>Renderer` and produce one concrete representation from prepared data.
> Page-specific immutable data carriers use `<PageOrSurface>PageData`. ViewModels use `<SubjectOrSurface>ViewModel` only when presentation-specific derived state or behavior is required beyond a PageData object.
> Console commands use `<Verb><Subject>Command`. The PHP class name remains separate from the Artisan command signature. Commands parse input, invoke owner-controlled behavior, format output, and return an exit result without absorbing the workflow.
> Incoming webhook handlers use `<Provider><Event>WebhookHandler` and handle one explicit provider event or payload type. Generic names such as `WebhookHandler`, `IntegrationHandler`, and `PayloadHandler` are prohibited.
> Generic class names such as `DeliveryAdapter`, `BaseController`, `CommonPresenter`, `DefaultRenderer`, and `PageViewModel` are prohibited unless an exact bounded framework role independently requires them.

## 8. Boundaries And Handoff

- Delivery artifacts remain owner-local under Phase 4 placement rules.
- Application behavior must not depend outward on delivery classes.
- Route and URL naming remains with Decision 5.7.
- This decision does not define Artisan signatures, API versioning, response schemas, or webhook verification behavior.

## 9. Related

- [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md)
- [Route And URL Naming](5-7-route-and-url-naming.md)
- [Phase 4 Delivery Adapter Placement](../phase-4/4-3-delivery-adapter-placement.md)
- [Phase 4 Dependency Direction](../phase-4/4-10-dependency-direction.md)
- [Definitions Index](../../../../Definitions/Index.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
