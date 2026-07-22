<!--
DOC-META
title: Phase 7 Compatibility Register
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/compatibility-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-4-compatibility-requirements.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records accepted and proposed compatibility obligations required during migration from the current repository structure to the accepted Goal 3 target architecture.
-->

# Phase 7 Compatibility Register

Parent: [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)

## 1. Purpose

Record every accepted compatibility obligation required during migration to the Goal 3 target architecture.

Compatibility is opt-in and evidence-based.

A current contract, identifier, route, namespace, command, configuration key, data reference, or implementation pattern has no compatibility requirement unless it appears as an accepted entry in this register.

## 2. Status

* Planning lifecycle: draft
* Register state: no proposed or accepted compatibility obligations
* Compatibility implementation authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Governing policy: [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)

## 3. Register Rules

Each compatibility entry must:

* identify concrete evidence and a specific consumer or retained dependency;
* identify the accepted target Contract;
* define a bounded compatibility mechanism;
* define activation and removal conditions;
* define verification;
* identify one later owner;
* remain proposed until explicit repository-owner acceptance;
* avoid preserving an obsolete owner or architecture model.

The following do not create compatibility by themselves:

* current internal references;
* filesystem placement;
* namespaces or class names;
* internal route or command names;
* configuration keys;
* current tests;
* current manifest formats;
* unfinished pre-alpha implementation;
* migration convenience.

No register entry means no accepted compatibility requirement.

## 4. Accepted Compatibility Obligations

None.

| Compatibility ID | Current contract or identifier        | Evidence and consumer | Target contract | Compatibility mechanism | Start condition | Removal condition | Verification | Later owner | Risk | Notes |
| ---------------- | ------------------------------------- | --------------------- | --------------- | ----------------------- | --------------- | ----------------- | ------------ | ----------- | ---- | ----- |
| —                | No accepted compatibility obligations | —                     | —               | —                       | —               | —                 | —            | —           | —    | —     |

## 5. Proposed Compatibility Obligations

None.

| Compatibility ID | Current contract or identifier        | Evidence and consumer | Target contract | Compatibility mechanism | Start condition | Removal condition | Verification | Later owner | Risk | Notes |
| ---------------- | ------------------------------------- | --------------------- | --------------- | ----------------------- | --------------- | ----------------- | ------------ | ----------- | ---- | ----- |
| —                | No proposed compatibility obligations | —                     | —               | —                       | —               | —                 | —            | —           | —    | —     |

## 6. Rejected Presumed Obligations

The following current structures do not qualify for compatibility based on the evidence reviewed during Phase 7:

| Current contract or pattern                 | Compatibility decision | Reason                                                                                   |
| ------------------------------------------- | ---------------------- | ---------------------------------------------------------------------------------------- |
| `App\Platform\` namespaces                  | Not required           | Transitional internal pre-alpha namespace with no proven external consumer               |
| `App\Modules\` namespaces                   | Not required           | Internal namespace supporting required Core capabilities incorrectly packaged as Modules |
| `/platform/*` URLs                          | Not required           | Internal transitional route family; target routes become owner- and Product-specific     |
| Proposed shared `/admin/*` route family     | Rejected as target     | Would recreate a generic administrative umbrella across separate owners                  |
| Current internal route names                | Not required           | No accepted external or persisted dependency identified                                  |
| Current command names                       | Not required           | Internal development and operational commands may be replaced or removed                 |
| Current configuration keys                  | Not required           | No persisted or externally consumed dependency identified                                |
| Current central manifest formats            | Not required           | Internal registration implementation is being replaced                                   |
| `PlatformManagement` category               | Not required           | Superseded category with no accepted target role                                         |
| Platform and generic Surface paths          | Not required           | Transitional placement is not target authority                                           |
| Required Core capabilities under `Modules/` | Not required           | False Module packaging is being extracted into Core                                      |
| Current non-UI test structure               | Not required           | Current suite is non-authoritative for target-state behavior                             |
| Docs Viewer routes and permissions          | Not required           | Obsolete prototype capability is removed later                                           |
| Active-batch workflow commands and files    | Not required           | Historical workflow tooling with no target application responsibility                    |

## 7. Protected UI Contracts

Accepted UI public Contracts remain protected independently of this register.

Applicable protected contracts include:

* Blade aliases;
* public props and slots;
* variants, sizes, and states;
* JavaScript initialization APIs;
* accepted data attributes;
* accepted public CSS APIs;
* accessibility and interaction behavior;
* machine-readable UI contracts;
* accepted examples, fixtures, tests, and rendered evidence.

A compatibility entry is required only when an accepted target change requires old and new UI Contracts to coexist temporarily.

No temporary UI compatibility obligation has currently been identified.

## 8. New Entry Template

Add a proposed entry using this structure:

```text
Compatibility ID:
Current contract or identifier:
Evidence and consumer:
Target contract:
Compatibility mechanism:
Start condition:
Removal condition:
Verification:
Later owner:
Risk:
Notes:
Review state: proposed
Reviewed by:
Reviewed at:
```

New entries must not be marked accepted until explicit repository-owner review.

## 9. Entry Acceptance Requirements

Before an entry may move from proposed to accepted, confirm:

1. the consumer or retained dependency is concrete;
2. the current Contract is identified exactly;
3. the accepted target Contract is known;
4. atomic migration is not possible or permanent Contract continuity is required;
5. the mechanism does not weaken authorization, Tenant isolation, Workspace isolation, security, privacy, or audit behavior;
6. the compatibility period is bounded;
7. removal conditions are observable;
8. verification covers both old and new Contracts;
9. one later owner is accountable;
10. repository-owner acceptance is recorded.

An unresolved target Contract cannot receive an accepted compatibility mechanism.

## 10. Removal And Retirement

A temporary compatibility entry may be retired only when:

* all known consumers have migrated;
* retained data no longer depends on the old identity;
* monitoring or other evidence confirms the old Contract is no longer used;
* verification passes without the compatibility mechanism;
* rollback and deployment requirements permit removal;
* repository-owner acceptance authorizes removal.

Retired entries remain recorded as historical evidence.

Use the following retirement fields:

```text
Retirement status:
Retirement issue:
Removal verification:
Removal evidence:
Accepted by:
Accepted at:
```

## 11. Relationship To Other Phase 7 Artifacts

* The [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md) records target architectural direction.
* [Phase 7.3 Migration Classification](7-3-migration-classification.md) defines the primary migration disposition.
* This register records only exceptional continuity obligations.
* The [Later-Owner Decision Register](later-owner-decision-register.md) records details assigned to later Goals or issues.
* The [Architecture Exception Register](architecture-exception-register.md) records accepted deviations from the target architecture.

A migration disposition does not create a compatibility requirement.

## 12. Validation

Before Phase 7.4 acceptance:

* confirm accepted compatibility obligations remain empty unless qualifying evidence is identified;
* confirm proposed obligations remain empty unless supported by concrete evidence;
* confirm rejected presumed obligations match the direction matrix;
* confirm protected UI Contracts are not misclassified as temporary compatibility;
* confirm no entry is attributed to repository-owner review without explicit owner action;
* confirm no compatibility implementation or cleanup is authorized by this register;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 13. Acceptance Record

- Outcome: Accepted
- Date: 2026-07-21
- Accepted or rejected by: Repository owner
- Accepted compatibility entries: None
- Proposed compatibility entries: None
- Rejected presumed obligations: As listed in Section 6
- Required corrections: None
- Validation evidence:
  - npm run lint:docs:guardrails — PASS
  - git diff --check — PASS
- Downstream handoff: Phase 7.5 intentional architecture exceptions

## 14. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Architecture Exception Register](architecture-exception-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
