<!--
DOC-META
title: Phase 5.13 Compatibility And Rename Rules
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-13-compatibility-and-rename-rules.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records material rename criteria, one-way compatibility mapping, exception boundaries, removal ownership, and migration authority.
-->

# Phase 5.13 Compatibility And Rename Rules

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define when a legacy name may remain, when a rename justifies its migration cost, how compatibility is recorded, and which later owner implements or removes it.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: policy only; no aliases or renames implemented
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: ADR-0007 and Phase 4 exception rules

## 3. Core Distinctions

A **rename** establishes a new canonical name.

A **compatibility alias** allows a legacy name to resolve temporarily to one canonical name.

An **architecture exception** permits one bounded deviation from a naming or placement rule. It is not automatically an alias.

Either may require the other, but each is recorded under its own rules.

## 4. Rename Criteria

A rename requires a material benefit such as:

- clearer ownership or responsibility;
- removal of conflicting Core, Module, UI, or `Platform` terminology;
- elimination of ambiguity or collision;
- alignment with an accepted Technical Role;
- correction of a misleading public contract;
- deterministic registration or enforcement;
- removal of a compatibility hazard.

Cosmetic consistency, personal preference, name length, or mechanical grammatical normalization alone do not justify migration cost.

## 5. Treatment By Impact

| Impact                                             | Default treatment                                       |
| -------------------------------------------------- | ------------------------------------------------------- |
| Private internal class with no external references | Coordinated direct rename                               |
| Public PHP Contract or namespace                   | Compatibility and consumer migration plan               |
| Route name                                         | Explicit route-name alias when required                 |
| URL                                                | Redirect or other accepted URL compatibility behavior   |
| Config key or environment variable                 | Explicit old-to-new mapping                             |
| Persisted or serialized identifier                 | Compatibility reader and migration required             |
| Event, Job, notification, audit, or queue key      | Stable-key compatibility review required                |
| Composer package                                   | Package migration, dependency, and versioning plan      |
| Documentation path                                 | Update links; retain a concise pointer only when useful |
| Database identifier                                | Goal 6 migration authority                              |

## 6. Compatibility Record

Every retained legacy name records:

```text
identifier family
legacy name
canonical name
responsible owner
compatibility surface
verified reason
status
introduced by
required verification
removal condition
migration owner
tracking issue
```

The record identifies whether compatibility is transitional or permanent and must prohibit expansion beyond its exact declared scope.

## 7. Alias Rules

Aliases:

- map one legacy name directly to one canonical name;
- must not form chains;
- must not be used for new canonical code, documentation, configuration, registration, or tests;
- must not remain equally canonical;
- must not create ambiguous reverse lookup;
- must fail explicitly when the canonical target no longer exists;
- must not silently normalize arbitrary invalid names;
- must not be reused for a different concept.

```text
Allowed:
legacy_name -> canonical_name

Prohibited:
legacy_a -> legacy_b -> canonical_name
```

## 8. Transitional And Permanent Compatibility

Compatibility is transitional by default.

Permanent compatibility requires:

- an exact external, vendor, protocol, public API, or persisted-data constraint;
- an identified responsible owner;
- exact accepted scope;
- verification;
- explicit repository-owner acceptance.

A transitional alias or exception requires an objective removal condition, migration owner, and tracking issue. Convenience, current placement, broad reuse, or reduced migration effort alone do not justify permanent compatibility.

## 9. Accepted Decision

> A naming change is accepted only when it materially improves ownership clarity, responsibility, collision avoidance, contract accuracy, deterministic discovery, compatibility, or enforceability. Cosmetic consistency alone does not justify migration cost.
>
> Every artifact has one canonical name within its identifier family. Legacy names may remain only through an explicit compatibility record or bounded exception.
>
> A compatibility record identifies the identifier family, legacy name, canonical name, responsible owner, compatibility surface, verified reason, status, required verification, removal condition, migration owner, and tracking issue.
>
> Aliases are one-way mappings from one legacy name directly to one canonical name. Alias chains, competing canonical names, ambiguous reverse lookup, silent normalization, and reuse of a retired legacy name for another concept are prohibited.
>
> New code, documentation, configuration, registration, and tests use the canonical name. Legacy names may appear only where required to implement, verify, document, or remove compatibility.
>
> Internal names without public, serialized, persisted, routed, packaged, or external references may be renamed directly through a bounded migration issue. Public Contracts, namespaces, routes, URLs, configuration keys, environment variables, persisted identifiers, queue or event keys, Composer packages, documentation paths, and database identifiers require review of their specific compatibility surfaces.
>
> Compatibility is transitional by default. Permanent compatibility requires an exact external, vendor, protocol, public API, or persisted-data constraint and explicit repository-owner acceptance.
>
> A compatibility alias is distinct from an architecture exception. An exception permits one bounded naming deviation; an alias preserves access from a legacy name to the canonical name. Either may require the other, but each must be recorded according to its own rules.
>
> Phase 5 defines compatibility and rename policy only. It does not authorize physical renaming, alias implementation, namespace migration, schema migration, package replacement, route migration, or compatibility removal.

## 10. Boundaries And Handoff

- Every implementation rename requires an issue-specific impact and proof map.
- Database renames remain Goal 6 authority.
- Phase 7 records coarse Goal 3 migration and compatibility direction.
- Later implementation issues own exact adapters, redirects, readers, dual-write behavior, package migration, and removal.
- A failed mandatory gate does not authorize an unplanned compatibility workaround or exception.

## 11. Related

- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Route And URL Naming](5-7-route-and-url-naming.md)
- [Configuration Naming](5-8-configuration-naming.md)
- [Documentation Naming](5-12-documentation-naming.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Exceptions And Future Enforcement](../phase-4/4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
