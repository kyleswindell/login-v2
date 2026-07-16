<!--
DOC-META
title: Phase 5.11 Test And Fixture Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-11-test-and-fixture-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records behavior-focused test, dataset, factory, fixture, and execution-group naming while preserving deterministic owner-local discovery.
-->

# Phase 5.11 Test And Fixture Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define test and fixture names that communicate owner, behavior, scenario, and expected result while preserving the accepted owner-local and repository-wide test topology.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Phase 4 test placement and canonical Testing Standards

## 3. Naming Matrix

| Artifact          | Pattern                                          | Example                                |
| ----------------- | ------------------------------------------------ | -------------------------------------- |
| Test class        | `<SubjectOrBehavior>Test`                        | `SuspendUserActionTest`                |
| Test method       | `test_<context>_<expected_outcome>`              | `test_admin_can_suspend_active_user`   |
| Browser test      | `<Flow>BrowserTest`                              | `MfaEnrollmentBrowserTest`             |
| Architecture test | `<BoundaryOrRule>ArchitectureTest`               | `CoreModuleDependencyArchitectureTest` |
| Contract test     | `<Subject>ContractTest`                          | `UserRepositoryContractTest`           |
| Dataset           | Descriptive snake-case name                      | `authorization_cases`                  |
| Dataset case      | Condition or expected result                     | `user_without_permission`              |
| Factory           | `<Model>Factory`                                 | `UserFactory`                          |
| PHP fixture class | `<Subject>Fixture`                               | `SuspendedUserFixture`                 |
| Data fixture file | Descriptive native format; kebab-case by default | `suspended-user.json`                  |
| Shared test base  | `<Concern>TestCase`                              | `ModuleTestCase`                       |

## 4. Behavior-Focused Tests

Test methods begin with `test_` and describe observable behavior.

Preferred structures:

```text
test_<actor_or_context>_<expected_outcome>
test_<expected_outcome>_when_<condition>
```

Examples:

```text
test_admin_can_suspend_active_user
test_suspension_is_rejected_when_user_is_already_deleted
test_module_registration_fails_when_dependency_is_missing
test_guest_cannot_view_project
```

Avoid:

```text
test_success
test_user
test_action
test_validation
test_case_1
test_it_works
```

Owner identity is normally communicated by placement rather than repeated in every class name. Root cross-owner tests may include owner or boundary names where required for clarity.

## 5. Fixtures And Factories

Laravel Model factories use `<Model>Factory`.

Factory states use precise lower-camel-case behavior names:

```php
UserFactory::new()->suspended();
UserFactory::new()->withMfa();
UserFactory::new()->withoutPermission();
```

Fixtures describe the represented scenario or data shape. Avoid `sample.json`, `data.json`, `fixture1.json`, and `test-user.json` when an exact scenario name is available.

Test data must remain explicit and minimal. Real customer data, credentials, secrets, tokens, production exports, and private information are prohibited.

## 6. Test Organization And Execution Dimensions

Tests remain beneath the smallest accepted owner test root:

```text
app/Core/Auth/__tests__/
├── Unit/
├── Feature/
├── Contracts/
├── Architecture/
├── Fixtures/
└── Support/
```

Subordinate folders may mirror the production Technical Role when useful:

```text
app/Core/Auth/__tests__/Unit/Actions/AuthenticateUserActionTest.php
```

Do not create `index.php`, `AuthTestSuite`, or similar aggregator files merely to run a directory. Directory discovery provides owner and owner-plus-type selection.

Test execution uses separate dimensions:

- named PHPUnit suites represent stable test types such as `Unit`, `Feature`, `Contracts`, `Architecture`, and `UI`;
- accepted filesystem paths select a Core capability, Module, UI responsibility, or integration owner;
- PHPUnit groups identify orthogonal characteristics such as `security`, `database`, `slow`, or `external-integration`.

Do not create an owner-by-type matrix of permanent suites such as `AuthUnit`, `AuthFeature`, `IdentityUnit`, and `IdentityFeature`.

Exact PHPUnit discovery configuration, CI partitioning, browser-runner selection, parallel execution, and complete verification architecture remain later implementation authority.

## 7. Shared Test Abstractions

Generic test infrastructure may use exact names such as:

```text
TestCase
ModuleTestCase
DatabaseTestCase
RegistryContractTestCase
```

only when it defines one reusable testing mechanism, contract, or invariant. Concrete behavior tests remain specifically named. The framework root `TestCase` remains valid.

## 8. Accepted Decision

> Test classes use `<SubjectOrBehavior>Test`. A test focused on one production type normally uses that type’s name, such as `SuspendUserActionTest`. A test focused on a workflow, boundary, or feature uses the precise behavior name.
>
> PHPUnit test methods use behavior-focused snake-case names beginning with `test_`. Names should identify the relevant actor or context, expected outcome, and material condition where needed. Generic method names such as `test_it_works`, `test_success`, `test_page`, and numbered cases are prohibited.
>
> Owner identity should normally be communicated through test placement rather than repeated unnecessarily in every class name. Root cross-owner tests may include owner or boundary names where required for clarity.
>
> Browser tests use `<Flow>BrowserTest`. Architecture tests use `<BoundaryOrRule>ArchitectureTest`. Contract-verification tests use `<Subject>ContractTest`.
>
> Datasets use descriptive snake-case names. Dataset case labels describe the condition, input category, rejection reason, or expected outcome rather than sequence numbers.
>
> Laravel Model factories use `<Model>Factory`. Factory states use precise lower-camel-case behavioral names such as `suspended`, `withMfa`, or `withoutPermission`.
>
> PHP fixture classes use `<Subject>Fixture`. Non-PHP fixture filenames follow the native format and use descriptive lowercase kebab-case names by default. Fixture names must communicate the represented scenario or data shape.
>
> Shared test abstractions may use `<Concern>TestCase`, an abstract test class, trait, or helper only when they define one exact reusable testing mechanism or invariant. Concrete behavior tests must remain specifically named. The framework root `TestCase` remains valid.
>
> Generic names such as `ExampleTest`, `FeatureTest`, `UnitTest`, `TestHelper`, `TestData`, `SampleFixture`, and `FixtureOne` are prohibited unless an external framework or generated template requires the exact name.
>
> Test and fixture renaming must not weaken, omit, skip, duplicate, or materially rewrite accepted proof. Test discovery must remain deterministic across every accepted owner-local and repository-wide test location.

## 9. Boundaries And Handoff

- Phase 4 remains authority for test placement.
- Testing Standards remain authority for required proof and test-type selection.
- Phase 6 validates naming and discovery expectations against representative owners.
- Later verification work owns exact suite configuration and commands.

## 10. Related

- [Class And Interface Naming](5-4-class-and-interface-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Phase 4 Test Placement](../phase-4/4-8-test-placement.md)
- [Testing Standards](../../../../../02-standards/coding/Testing%20Standards.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
