<!--
DOC-META
title: Phase 6.6 Preimplementation Proof Requirements
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-6-preimplementation-proof-requirements.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the proof categories future implementation issues must establish before changing the representative architecture examples.
-->

# Phase 6.6 Preimplementation Proof Requirements

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Define the proof strategy future implementation or migration issues must complete before changing production code for the representative examples.

This document does not write the tests or authorize implementation.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: verification-design only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phase 6.5
- Required execution rule: each future issue must define exact criteria, fixtures, environments, commands, expected initial results, and final required results

## 3. Proof Matrix

| Example            | Required preimplementation proof                                                                                                                                                                                                     |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Settings           | Characterize public reads and writes, routes, authorization, persistence, Registry registration, Contribution rejection, and compatibility behavior before relocation or refactor                                                    |
| Projects           | Prove Core operates without the Module; validate package identity and declared dependencies; establish Product Contribution, route, policy, persistence, and package-local test contracts                                            |
| Modal and Dialog   | Prove machine-readable Contract, Blade rendering, deterministic assets, focus, keyboard, dismissal, accessibility, and UI isolation                                                                                                  |
| Sidebar Navigation | Prove Workspace Product scope, Contribution validation, active Product and Product Area resolution, permission evaluation, Module availability, fallback behavior, normalized UI render data, and deep-link authorization separation |

## 4. Required Proof Types

### 4.1. Preservation Refactors

Use characterization tests when relocating or reorganizing accepted behavior. The protected baseline must cover the public behavior being preserved and pass unchanged after implementation.

### 4.2. New Or Corrected Behavior

Use the smallest expected-nonpass proof for the exact missing behavior. Syntax, fixture, dependency, boot, environment, and discovery failures are failures rather than accepted evidence.

### 4.3. Public Contracts And Contributions

Prove:

- valid declarations are accepted;
- unknown Host, Extension Point, key, route, or incompatible declaration is rejected;
- duplicates and ordering follow the Host Contract;
- optional Contributors may be absent;
- the Host does not import Contributor implementation.

### 4.4. Authorization And Availability

Prove allowed and denied paths independently:

- route or Action authorization;
- permission declaration and evaluation;
- Module active and inactive states;
- Workspace inclusion and exclusion;
- navigation visibility without treating visibility as authorization.

### 4.5. UI And Browser Behavior

Automated proof must cover semantics and interaction. Manual review remains required for hierarchy, spacing, responsive behavior, visual state, and Carbon-aligned navigation composition.

### 4.6. Static Architecture

Use path, namespace, package, import, dependency, registration, test-discovery, and asset-composition checks where runtime behavior is not the correct proof.

## 5. Example-Specific Minimums

### Settings

- current behavior characterization;
- authorized and unauthorized route proof;
- settings Contract and Registry proof;
- persistence and rollback proof for any schema change;
- optional Contribution absence and invalid Contribution rejection;
- documentation synchronization.

### Projects

- Core boot and required behavior with Projects absent;
- Composer and Module-definition identity agreement;
- declared Core and Module dependency validation;
- Product Contribution acceptance and Module-disabled exclusion;
- owner-local policy, route, persistence, and package tests;
- uninstall or disable protection where state exists.

### Modal And Dialog

- contract schema and Blade compile proof;
- keyboard, focus, Escape, backdrop, inertness, and dismissal proof as applicable;
- accessibility names and relationships;
- asset inclusion exactly once;
- no Core or Module imports;
- manual visual and responsive review.

### Sidebar Navigation

- active Workspace determines eligible Products;
- Home is the default Product where applicable;
- active Product exposes C-level Product Areas while sibling Products remain accessible;
- Access and Module lifecycle results are honored;
- invalid, duplicate, unauthorized, inactive, and missing-route Contributions fail or disappear according to the Contract;
- UI receives normalized render data only;
- direct deep links remain route-authorized independently of navigation visibility.

## 6. Proof Ownership

| Proof category                            | Primary owner                                   |
| ----------------------------------------- | ----------------------------------------------- |
| Owner-local behavior and persistence      | Settings or Projects                            |
| Host Contract and Registry                | Settings or Core Navigation                     |
| Permission evaluation                     | Access/Permissions                              |
| Module lifecycle availability             | Core Module lifecycle                           |
| UI contract and interaction               | UI                                              |
| Cross-owner dependency and registration   | Repository verification owner                   |
| Browser, accessibility, and visual review | UI plus repository owner or designated reviewer |
| Documentation alignment                   | Applicable canonical document owner             |

## 7. Findings

The representative examples have clear proof strategies. No proof requires inventing a new architecture mechanism.

Exact commands, fixtures, expected initial results, protected baselines, and manual-review procedures remain mandatory inputs to each future executable issue.

## 8. Accepted Decision

> Future implementation issues must establish the smallest accepted behavior, contract, authorization, persistence, UI, registration, and architecture proofs before production changes.
>
> Refactors use protected characterization baselines. New behavior uses exact expected-nonpass proofs. The same accepted proof must pass unchanged after implementation, and automated proof does not replace required visual, accessibility, security, database, or repository-owner review.

## 9. Phase 6.7 Handoff

Phase 6.7 must select the bounded architecture rules that should later receive automated enforcement based on these proof requirements.

## 10. Related

- [Phase 6.5 Placement And Naming Verification](6-5-placement-and-naming-verification.md)
- [Testing Standards](../../../../../02-standards/coding/Testing%20Standards.md)
- [Feature Development Standards](../../../../../02-standards/coding/Feature%20Development%20Standards.md)
- [Phase 4 Exceptions And Future Enforcement](../phase-4/4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)