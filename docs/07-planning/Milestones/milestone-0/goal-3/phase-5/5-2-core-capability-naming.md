<!--
DOC-META
title: Phase 5.2 Core Capability Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-2-core-capability-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the explicit Core capability identity model and separates owner names from machine keys, resources, paths, and presentation labels.
-->

# Phase 5.2 Core Capability Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define how an accepted Core capability owner is named across PHP folders, namespaces, machine identity, non-PHP paths, tests, and documentation.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decision 5.1, ADR-0005, and ADR-0007

## 3. Capability Identity Record

Every permanent direct child of `app/Core/` represents one accepted Core capability owner and maintains one explicit identity record.

| Field                    | Purpose                                                         |
| ------------------------ | --------------------------------------------------------------- |
| Canonical technical name | Stable architecture-facing identity                             |
| `ownership_area`         | Always `core`                                                   |
| `owner_key`              | Stable owner identity governed by ADR-0007                      |
| PHP folder segment       | Direct child beneath `app/Core/`                                |
| PHP namespace segment    | Exact segment beneath `App\Core`                                |
| Non-PHP path slug        | Kebab-case form where a physical non-PHP owner path is required |
| Documentation title      | Human-readable canonical title                                  |
| Prose reference          | Standard wording such as “the Identity capability”              |
| Legacy names             | Prior package, resource, route, or presentation names           |
| Status                   | Accepted, transitional, reserved, or retired                    |
| Governing decision       | Authority accepting the identity                                |

Example:

```text
Canonical technical name: DataGovernance
ownership_area:          core
owner_key:               data_governance
PHP path:                app/Core/DataGovernance/
PHP namespace:           App\Core\DataGovernance
Non-PHP path slug:       data-governance
Documentation title:     Data Governance
Prose reference:         the Data Governance capability
```

## 4. Naming Rules

A Core capability name:

- uses PascalCase for the PHP folder and namespace segment;
- describes one enduring required or authoritative responsibility;
- remains stable when internal Technical Roles, URLs, resources, packages, or presentation labels change;
- uses its natural singular, plural, collective, abstract, or process form;
- does not include `Core`, `Platform`, `Module`, `Capability`, generic `Service`, or generic `Management` affixes;
- does not use a current resource, controller, route, navigation group, team, or implementation technology as automatic naming authority.

Valid examples include:

```text
Auth
Identity
Access
Security
DataGovernance
DataProtection
Audit
Monitoring
Notifications
Preferences
Settings
Shell
Navigation
Dashboard
Setup
```

These are accepted canonical forms where the corresponding owner is accepted. This decision does not require every representative Core responsibility to become a separate direct `app/Core/` child without an explicit owner-decomposition decision.

## 5. Owner Identity Versus Functional Capability

Owner keys and functional capability keys remain separate even when values currently match.

```yaml
ownership_area: core
owner_key: identity
capability_key: users
```

A Core owner may provide several narrower capabilities and resources. The direct folder beneath `app/Core/` represents the owner, not every resource.

Examples:

```text
Identity owns users, invitations, profiles, and identity lifecycle.
Access owns roles, permissions, assignments, and authorization evaluation.
```

`Users` and `Roles` therefore do not become direct Core owners merely because they are prominent resources.

## 6. Natural Grammar And Controlled Abbreviations

Do not mechanically singularize or pluralize capability identities.

```text
Notifications
Preferences
Settings
```

Once accepted, the grammatical form remains consistent across the capability identity record.

`Auth` is an accepted controlled abbreviation because it is established, unambiguous, and stable in the repository and Laravel context. Other abbreviations or initialisms require explicit acceptance; terms such as `IAM`, `DLP`, `SSO`, `MFA`, `API`, and `DB` do not automatically become Core owner names.

## 7. Legacy And Presentation Terms

| Term                      | Default classification                                                          |
| ------------------------- | ------------------------------------------------------------------------------- |
| `Account`                 | User-facing context or Surface beneath the applicable owner, commonly Identity  |
| `Users`                   | Resource or capability key beneath Identity                                     |
| `Roles`                   | Resource or capability key beneath Access                                       |
| `Logging`                 | Legacy implementation term; classify into Audit, Monitoring, or the exact owner |
| `Administration`          | Surface, invocation context, navigation grouping, or capability key             |
| `GlobalAdministration`    | Cross-owner administrative context unless a distinct owner is separately proven |
| `Registries`              | Host-owned technical responsibility, not a generic centralized Core owner       |
| `ApplicationRegistration` | Architecture mechanism, not automatically a direct Core capability              |

These names require an explicit relationship to the canonical owner and do not compete with it.

## 8. Platform Reservation

`Platform` remains retired as a peer ownership category. It is narrowly reserved as a potential transitional placeholder for the unresolved global-administration tooling namespace.

The reservation:

- does not create `app/Core/Platform/`;
- does not create an `owner_key` of `platform`;
- does not absorb Identity, Access, Audit, Security, Settings, or other Core behavior;
- requires explicit transitional status and a resolution owner if used in implementation.

## 9. Accepted Decision

> Every permanent direct child of `app/Core/` represents one accepted Core capability owner and uses one canonical PascalCase technical name. The same case-sensitive capability segment is used in the PHP folder and namespace beneath `App\Core`.
> Each Core capability maintains an explicit identity record containing its canonical technical name, `ownership_area`, `owner_key`, PHP folder and namespace segment, non-PHP path slug where needed, documentation title, accepted prose reference, compatibility names, status, and governing decision.
> The canonical technical name describes an enduring required or authoritative responsibility. It must not be derived solely from a current resource, package, route, controller, navigation group, implementation technology, team name, or presentation label.
> Core capability names must not include `Core`, `Platform`, `Module`, `Capability`, generic `Service`, generic `Management`, or another ownership or artifact-type suffix. Names may use singular, plural, collective, abstract, or process forms when that form is the natural stable name of the responsibility. Once accepted, the grammatical form is fixed across repository surfaces.
> The PHP folder and namespace segment use PascalCase. The `owner_key` uses the independently governed snake-case grammar from ADR-0007. Non-PHP capability path slugs use lowercase kebab-case where required. Documentation titles use a human-readable rendering of the same canonical identity. These representations remain separate identifier families and must be related through the capability identity record rather than inferred silently.
> A direct Core capability folder corresponds to one Core owner identity. Functional `capability_key` values may identify narrower resources or responsibilities beneath that owner and remain separate from `owner_key`.
> Legacy package, resource, route, and presentation names such as `Account`, `Users`, `Roles`, `Logging`, and `Administration` do not become Core capability identities merely because they currently exist. Their relationship to canonical owners must be explicit and any required compatibility mapping remains governed by Decision 5.13.
> `Platform` remains retired as a peer ownership category. It is narrowly reserved as a potential transitional placeholder for the unresolved global-administration tooling namespace. That reservation does not create a canonical Core capability, `platform` owner key, or generic `app/Core/Platform/` destination.
> A Core capability rename requires a material ownership, boundary, collision, compatibility, or clarity justification. Cosmetic grammatical normalization alone is insufficient.

## 10. Boundaries And Handoff

- This decision defines identity rules, not the final decomposition of every representative Core responsibility.
- Decision 5.11 owns test class, method, dataset, fixture, and suite naming.
- Decision 5.13 owns legacy-name compatibility and removal.
- Phase 6 validates the identity model against one representative Core capability.
- Phase 5 does not authorize folder, namespace, route, or documentation migration.

## 11. Related

- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0005](../../../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Implementation Placement](../phase-4/4-2-implementation-placement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
