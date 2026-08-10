# docs/02-standards/testing AGENTS.md

## Purpose

This folder owns canonical testing and verification policy.

Repository-specific test-source coding is owned separately by `docs/02-standards/coding/test-implementation/`.

## Read Order

1. Read `index.md`.
2. Read `testing-and-verification-standards.md` for the shared taxonomy and verification model.
3. Read `verification-contract/index.md` when declaring proof, interpreting proof state, or handling initial proof and protected baselines.
4. Read only the specialist testing family applicable to the current proof.
5. Read `reporting-and-gates/index.md` when recording material evidence or evaluating testing-stage completeness.
6. Read `../coding/test-implementation/index.md` only when constructing or modifying test source.
7. Read Security, Database, UI, Documentation, or Runbook standards when those owners define domain-specific requirements.

Do not load the entire testing suite for a narrow task.

## Authority Boundary

This folder owns:

- testing and verification terminology;
- proof selection and test levels;
- verification-contract structure;
- applicability, execution status, and verification results;
- initial proof and protected-baseline policy;
- static and automated proof policy;
- environment and fixture validity;
- integration, system, acceptance, reliability, performance, compatibility, operational, UI, accessibility, browser, responsive, and visual testing policy;
- execution evidence;
- testing-stage gates.

This folder does not own:

- feature behavior;
- architecture;
- public Contracts;
- exact schema behavior;
- security-control requirements;
- UI public APIs;
- operational procedures;
- GitHub issue or Project state;
- repository implementation authorization;
- PHPUnit, Laravel, Playwright, fixture, double, dataset, selector, or test-helper source construction.

Test-source implementation belongs to `docs/02-standards/coding/test-implementation/`.

## Routing

| Topic                                              | Owner                                                                       |
| -------------------------------------------------- | --------------------------------------------------------------------------- |
| Shared verification model                          | `testing-and-verification-standards.md`                                     |
| `AC-*` / `PF-*` declarations                       | `verification-contract/verification-contract-standards.md`                  |
| Applicability / status / results                   | `verification-contract/verification-state-and-result-standards.md`          |
| Initial proof / protected baseline                 | `verification-contract/initial-proof-and-baseline-standards.md`             |
| Static and automated proof policy                  | `automated-and-static-testing-standards.md`                                 |
| Environments / equivalence                         | `test-environments/test-environment-and-equivalence-standards.md`           |
| Test data / fixtures                               | `test-environments/test-data-and-fixture-standards.md`                      |
| External services / resource isolation             | `test-environments/external-service-and-resource-isolation-standards.md`    |
| Integration proof                                  | `integration-and-system/integration-testing-standards.md`                   |
| System / end-to-end / application smoke            | `integration-and-system/system-and-end-to-end-testing-standards.md`         |
| Acceptance / exploratory proof                     | `integration-and-system/acceptance-and-exploratory-testing-standards.md`    |
| Reliability proof                                  | `quality-and-operational-testing/reliability-testing-standards.md`          |
| Performance proof                                  | `quality-and-operational-testing/performance-testing-standards.md`          |
| Compatibility proof                                | `quality-and-operational-testing/compatibility-testing-standards.md`        |
| Build / deployment / migration / operational proof | `quality-and-operational-testing/operational-testing-standards.md`          |
| UI Contract / semantic / interaction proof         | `ui-and-accessibility/ui-contract-and-interaction-testing-standards.md`     |
| Accessibility proof                                | `ui-and-accessibility/accessibility-testing-standards.md`                   |
| Responsive / visual / specialist UI review         | `ui-and-accessibility/visual-responsive-and-specialist-review-standards.md` |
| Execution artifacts and reporting                  | `reporting-and-gates/verification-reporting-and-artifact-standards.md`      |
| Testing-stage completeness                         | `reporting-and-gates/testing-gate-standards.md`                             |
| Test-source coding                                 | `../coding/test-implementation/index.md`                                    |

## Avoid

- Do not treat test level as a quality characteristic.
- Do not treat a browser runner as proof of visual acceptance.
- Do not duplicate OWASP ASVS requirements from Security standards.
- Do not redefine state or result semantics in specialist standards.
- Do not duplicate test-source implementation rules from `../coding/test-implementation/`.
- Do not duplicate execution-manifest or artifact-retention rules outside `reporting-and-gates/`.
- Do not weaken accepted tests, fixtures, Contracts, or review procedures without the required revision authority.
- Do not classify syntax, fixture, dependency, boot, discovery, environment, or tooling failures as expected missing behavior.
- Do not infer merge, release, deployment, closure, or repository-owner acceptance from testing completeness.
