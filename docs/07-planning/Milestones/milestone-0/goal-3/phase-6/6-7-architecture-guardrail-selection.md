<!--
DOC-META
title: Phase 6.7 Architecture Guardrail Selection
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-7-architecture-guardrail-selection.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Selects bounded architecture rules for later static checks, registration validation, and targeted tests.
-->

# Phase 6.7 Architecture Guardrail Selection

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Select the accepted Goal 3 rules that should later receive automated enforcement.

This phase identifies guardrails only. It does not implement them.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: guardrail selection only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phase 6.6
- Later implementation owner: bounded verification, registration, package, UI, or CI issues

## 3. Selected Guardrails

| ID         | Rule                                                                                                                                                                     | Preferred enforcement                                |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------- |
| `P6-GR-01` | Required Core cannot import or require optional Module implementation                                                                                                    | Static namespace and package dependency check        |
| `P6-GR-02` | UI cannot import Core or Module implementation                                                                                                                           | Static import and package check                      |
| `P6-GR-03` | Cross-owner communication uses provider-owned public Contracts, accepted Events, Jobs, or explicit Host Contributions according to the applicable communication contract | Architecture test and dependency allowlist           |
| `P6-GR-04` | Host Registries cannot import Contributor implementation or persistence                                                                                                  | Static dependency test plus Registry contract tests  |
| `P6-GR-05` | Module dependencies are declared, version constrained, acyclic, and consistent across Composer and Module definitions                                                    | Package and registration validation                  |
| `P6-GR-06` | Physical paths and PHP namespaces match accepted owner and Technical Role placement                                                                                      | Static path-to-namespace validation                  |
| `P6-GR-07` | New canonical production code cannot enter transitional or prohibited generic roots                                                                                      | Changed-path CI check                                |
| `P6-GR-08` | Contributions target explicit Hosts and Extension Points and are not inferred from filesystem presence                                                                   | Registration schema and compile validation           |
| `P6-GR-09` | Delivery depends inward on owner behavior; owner behavior does not import delivery artifacts                                                                             | Static dependency test                               |
| `P6-GR-10` | Cross-owner Models, tables, repositories, and internal configuration state are not accessed directly                                                                     | Static import checks plus targeted integration tests |
| `P6-GR-11` | UI artifact contracts, implementation, assets, and tests remain artifact-owned and assets compose deterministically                                                      | UI contract, path, and asset checks                  |
| `P6-GR-12` | Accepted test locations are discovered exactly once and do not load in production                                                                                        | Test-discovery and production-autoload checks        |

## 4. Navigation-Specific Applications

The selected rules must prove that:

- `app/Core/Navigation/` does not import optional Product Modules;
- Product Contributions target Navigation public Contracts;
- Navigation visibility consumes Access and Module lifecycle results through public Core boundaries;
- UI renders normalized navigation data without Core or Module dependencies;
- no generic `Surface/` or `Surfaces/` implementation owner is introduced;
- Main content is not registered as a Frame Surface;
- navigation visibility is not treated as route authorization.

These are applications of the selected guardrails rather than a separate enforcement system.

## 5. Enforcement Boundaries

Guardrails must:

- evaluate accepted target architecture rather than current transitional exceptions without a migration allowance;
- report exact offending path, namespace, package, declaration, or edge;
- distinguish new violations from approved compatibility paths;
- remain deterministic locally and in CI;
- avoid uncontrolled repository-wide reflection or request-time scanning;
- not rewrite files, classifications, or accepted tests automatically;
- stop on tooling, discovery, fixture, or environment failures.

## 6. Deferred Guardrails

The following remain owner-specific or premature:

- exact Workspace-switching URL or persistence rules;
- complete Product and Product Area schemas;
- visual navigation quality;
- every class suffix or internal folder;
- detailed database naming and constraints;
- exact compiled registration format;
- all compatibility alias removal dates.

## 7. Findings

The twelve selected guardrails are bounded, enforceable, and directly supported by the representative examples and Phase 6 proof plan.

No new architecture layer or generic validation framework is required.

## 8. Accepted Decision

> Phase 6 selects twelve future guardrails covering optional-Module isolation, UI independence, public cross-owner boundaries, Registry inversion, Module declaration integrity, path and namespace agreement, prohibited roots, explicit Contributions, delivery inversion, persistence isolation, UI artifact ownership, and deterministic test discovery.
>
> Navigation-specific checks apply these rules to Core Navigation, Workspace inputs, Product Contributions, Access evaluation, Module lifecycle, and UI rendering.

## 9. Phase 6.8 Handoff

Phase 6.8 must classify each representative example, record bounded corrections and later-owner decisions, and determine whether Goal 3 can proceed to Phase 7 without unresolved structural ambiguity.

## 10. Related

- [Phase 6.6 Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md)
- [Phase 4 Exceptions And Future Enforcement](../phase-4/4-12-exceptions-and-future-enforcement.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)