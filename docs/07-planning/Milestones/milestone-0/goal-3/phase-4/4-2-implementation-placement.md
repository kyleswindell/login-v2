<!--
DOC-META
title: Phase 4.2 Implementation Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-2-implementation-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the owner-local placement rule for concrete Core, Module, UI, Surface, Registry, Contribution, and Laravel integration implementation.
-->

# Phase 4.2 Implementation Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where concrete implementations belong for every accepted owner type.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decision 4.1

## 3. Default Placement

| Owner or concern                     | Default implementation placement                                       |
| ------------------------------------ | ---------------------------------------------------------------------- |
| Core capability                      | `app/Core/<Capability>/<TechnicalRole>/`                               |
| Module                               | `Modules/<Module>/src/<TechnicalRole>/`                                |
| Reusable UI PHP/runtime              | `app/UI/<Responsibility>/<TechnicalRole>/`                             |
| Reusable presentation artifact       | Owning artifact bundle beneath accepted `resources/views/` UI branches |
| Core Surface                         | Core owner’s `Surface/` role plus Core-owned presentation resources    |
| Module Surface                       | Module `src/Surface/` plus package-local presentation resources        |
| Host Registry                        | Host owner’s `Registry/` role                                          |
| Contribution                         | Contributor-owned `Contrib/<Host>/`                                    |
| Application-wide Laravel integration | Restricted `app/Http/`, `app/Console/`, or `app/Providers/`            |

Every implementation belongs to the narrowest owner and Technical Role that owns its behavior.

## 4. Ownership Rule

Ownership is not determined by:

- the framework class extended;
- the interface implemented;
- broad reuse;
- the delivery channel;
- current placement;
- labels such as service, helper, support, shared, or utility.

Broadly used behavior belongs to the capability or UI responsibility that owns the policy or invariant. Consumers use that owner’s public contract.

## 5. Framework And External Integrations

An adapter around Laravel or an external dependency remains with the owner of the application responsibility using it.

Application-wide integration may remain in a restricted root Laravel branch only when the concern is genuinely global or required before an owner can be resolved.

## 6. Prohibited Placement

Do not create new canonical implementation in generic roots such as:

```text
app/Platform/
app/Surfaces/
app/Support/
app/Services/
app/Helpers/
app/Utilities/
app/Common/
app/Shared/
app/Infrastructure/
app/Models/
app/Rules/
app/Livewire/
app/Core/Services/
app/Core/Shared/
Modules/<Module>/<DirectRootPhpRole>/
```

Existing files in those locations remain transitional or compatibility-only.

## 7. Accepted Decision

> Login 2.0 places every concrete implementation beneath the narrowest Core capability, Module, UI responsibility, presentation artifact, or restricted Laravel integration concern that owns the behavior. Core implementations use `app/Core/<Capability>/<TechnicalRole>/`; Module PHP implementations use `Modules/<Module>/src/<TechnicalRole>/`; reusable UI PHP and runtime implementations use `app/UI/<Responsibility>/<TechnicalRole>/`; and presentation implementation follows the accepted owner-visible artifact-bundle structure. Hosts own Registry implementations, while Contributors retain owner-local Contribution implementations beneath `Contrib/<Host>/`. Root Laravel integration folders contain only genuinely application-wide framework integration. Framework conventions, reuse, and broad consumption do not create neutral ownership, and generic implementation roots are prohibited for new canonical work.

## 8. Boundaries And Handoff

Detailed placement for delivery, routes, configuration, database artifacts, presentation, and tests remains with Decisions 4.3–4.8. Phase 5 owns final naming.

## 9. Related

- [Contract Placement](4-1-contract-placement.md)
- [Delivery Adapter Placement](4-3-delivery-adapter-placement.md)
- [Dependency Direction](4-10-dependency-direction.md)
- Related GitHub issue: #51
