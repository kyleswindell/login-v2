<!--
DOC-META
title: Test Source Lifecycle Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/test-source-lifecycle-standards.md
parent: docs/02-standards/coding/test-implementation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines test-source rules for time and randomness, datasets, assertion helpers, generated tests, discovery, protected source, review, and ongoing maintenance.
-->

# Test Source Lifecycle Standards

Parent: [Test Implementation Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Time, Randomness, Identifiers, And External State](#2-time-randomness-identifiers-and-external-state)
- [3. Datasets And Parameterized Cases](#3-datasets-and-parameterized-cases)
- [4. Assertions And Custom Assertion Helpers](#4-assertions-and-custom-assertion-helpers)
- [5. Templates, Generated Tests, And Incomplete Scaffolds](#5-templates-generated-tests-and-incomplete-scaffolds)
- [6. Discovery, Suites, Groups, And Selection](#6-discovery-suites-groups-and-selection)
- [7. Protected Test Source](#7-protected-test-source)
- [8. Test-Source Review Checklist](#8-test-source-review-checklist)
  - [Ownership and placement](#ownership-and-placement)
  - [PHP or JavaScript source](#php-or-javascript-source)
  - [Setup and isolation](#setup-and-isolation)
  - [Test boundary](#test-boundary)
  - [Assertions](#assertions)
  - [Discovery and maintenance](#discovery-and-maintenance)
- [9. Prohibited Patterns](#9-prohibited-patterns)
- [10. Related](#10-related)

## 1. Purpose And Scope

Define how test source remains deterministic, discoverable, maintainable, and safe after initial construction.

This standard owns implementation and maintenance rules for:

- time and randomness controls in test source;
- identifier assertions;
- external-state setup not owned by a more specific browser or integration standard;
- datasets and parameterized test source;
- custom assertion helpers;
- generated tests and incomplete scaffolds;
- test discovery, suites, groups, and selection;
- source artifacts that participate in protected verification baselines;
- test-source review and maintenance.

It does not define proof applicability, baseline acceptance, material-revision authority, evidence retention, or testing gates. Those remain with the [Testing Standards Index](../../testing/index.md).

## 2. Time, Randomness, Identifiers, And External State

Control time when behavior depends on applicable:

- expiry;
- scheduling;
- retention;
- token lifetime;
- MFA;
- recent authentication;
- retry or backoff;
- lifecycle transitions.

Use repository-supported Laravel or Carbon time controls when testing Laravel behavior.

Always restore frozen or overridden time when the harness does not restore it automatically.

Do not use the developer machine clock as an implicit expected value.

Control randomness when reproducibility matters.

Record or fix seeds for generated cases when applicable and supported by the selected testing method.

Do not assert an exact random identifier unless the identifier is injected, contractually fixed, or produced by a deterministic test generator.

Prefer asserting the accepted:

- shape;
- uniqueness;
- relationship;
- persistence;
- public result;

over incidental exact random values.

External state must be isolated through the mechanism selected by the verification contract, such as an accepted sandbox, protocol fixture, mock server, service virtualization layer, temporary resource, or owner-controlled test account.

Do not mutate a shared external environment without explicit authorization and cleanup.

Browser-specific external-state rules belong to [Browser Test Implementation Standards](browser-test-implementation-standards.md).

## 3. Datasets And Parameterized Cases

Use datasets when multiple cases share the same meaningful:

- setup shape;
- public action;
- assertion structure;
- varying condition.

Keep materially different workflows, actors, owners, environments, side effects, or assertion families in separate tests.

Dataset cases should identify the condition, rejection reason, boundary, or expected outcome clearly in failure output.

Avoid opaque numeric case labels when a meaningful case name is possible.

Follow the installed PHPUnit API. Do not introduce deprecated annotations when the current runner provides supported attributes or method conventions.

Do not use a dataset to hide:

- materially different actor states;
- different owners;
- different environments;
- materially different side effects;
- materially different expected results.

A dataset that participates in a protected proof is protected when changing its cases changes coverage or proof meaning.

## 4. Assertions And Custom Assertion Helpers

General assertion-quality policy belongs to [Automated And Static Testing Standards](../../testing/automated-and-static-testing-standards.md).

In source:

- keep important expected values visible;
- prefer focused framework-native assertions when they express the behavior clearly;
- assert public outcomes rather than private collaborator structure;
- assert unchanged state on rejection when the criterion requires it;
- assert material side effects and prohibited side effects when they are part of the proof;
- keep failure output actionable.

Create a custom assertion helper only when it:

- repeats across multiple tests;
- represents one stable accepted concept;
- has one clear owner;
- makes failures more understandable;
- does not hide expected values or actor state.

A custom assertion should accept expected state explicitly when practical.

Avoid generic helpers such as:

```text
assertEverythingIsCorrect
assertValidResponse
assertUserState
```

when the helper conceals which conditions are required.

Test custom assertion helpers when their own logic is non-trivial enough that a defect could produce false-positive proof.

Do not turn assertion helpers into alternate application APIs or hidden repositories.

## 5. Templates, Generated Tests, And Incomplete Scaffolds

Use approved test stubs under `stubs/tests/` when their archetype matches the required source.

A generated test is scaffolding until:

- every required placeholder is replaced;
- applicable `markTestIncomplete()` calls are replaced with meaningful assertions;
- inapplicable scaffold methods are removed;
- imports and namespace are correct;
- actor and fixture state are explicit;
- the public target path executes;
- the authoritative runner discovers the test;
- applicable formatting and syntax checks pass.

Do not commit required behavior with:

- unresolved placeholders;
- `markTestIncomplete()`;
- unconditional assertions;
- empty test bodies;
- placeholder fixtures;
- commented-out expectations;
- `test_expected_behavior` or equivalent scaffold naming as the final test name.

A test generator must not invent:

- requirements;
- permissions;
- schema;
- public APIs;
- expected values;
- browser selectors;
- fixture meaning;
- proof classification.

Generated output remains ordinary repository source and becomes subject to protected-baseline rules once accepted as proof.

Generator and stub behavior also follows [Code Template And Generator Standards](../Code%20Template%20And%20Generator%20Standards.md).

## 6. Discovery, Suites, Groups, And Selection

Every test must be discovered by the authoritative runner without a manual aggregator.

Use applicable:

- named PHPUnit suites for stable test families;
- filesystem paths for owner selection;
- groups for orthogonal execution characteristics;
- Playwright discovery for `.spec.js` browser and interaction tests.

Do not create:

- manual `index.php` test aggregators;
- duplicate suite entries that execute one test twice;
- owner-by-type suite explosion;
- a group that merely duplicates an owner path;
- a hidden test root not registered with the runner;
- a filename that bypasses configured discovery.

When adding a new accepted test root:

1. identify its owner and reason;
2. update the authoritative runner configuration;
3. prove discovery in required local and CI environments;
4. prove the test is not executed twice;
5. update applicable documentation and templates.

Do not narrow a command, suite, group, or discovery root merely to exclude a failing protected test.

Do not classify current `tests/Unit/` or `tests/Feature/` as target owner locations solely because the root runner discovers them. Target placement is governed by [Test Source And Placement Standards](test-source-and-placement-standards.md) and Repository Architecture.

## 7. Protected Test Source

A test, fixture, factory state, scenario builder, dataset, helper, mock server, snapshot, or review procedure may become protected verification evidence.

Once accepted as part of a protected baseline, do not:

- weaken it;
- skip it;
- delete it;
- move it out of discovery;
- narrow its data cases;
- change its actor, target, or scope;
- replace a real required boundary with a fake;
- change expected behavior to match implementation;
- regenerate expected output without review.

The verification contract defines:

- baseline identity;
- protected semantics;
- permitted mechanical edits;
- required hashes or revision identity;
- material revision authority.

This coding standard does not authorize a protected-proof edit.

Before changing protected test source, read the applicable verification contract and classify the edit under the Testing Standards suite.

A path-only move may still require discovery and baseline handling even when proof semantics are intended to remain unchanged.

## 8. Test-Source Review Checklist

Before accepting test-source changes, confirm applicable:

### Ownership and placement

- the smallest clear owner is identified;
- the file uses an accepted discovered path;
- no transitional or generic owner was invented;
- cross-owner access uses public Contracts.

### PHP or JavaScript source

- PHP strict types and imports follow current style standards;
- class, spec, dataset, and fixture names follow Repository Naming Standards;
- methods or cases describe behavior clearly;
- no unresolved placeholders remain;
- no required test remains incomplete or focused-only.

### Setup and isolation

- actor and fixture state are visible;
- setup does not grant hidden broad access;
- cleanup restores owned state;
- time and randomness are controlled when material;
- the test does not depend on execution order.

### Test boundary

- the public entry point executes;
- doubles replace only intentionally excluded boundaries;
- framework fakes do not support a broader claim than they prove;
- middleware relevant to the proof remains active;
- direct database writes do not bypass behavior being claimed.

### Assertions

- observable success or rejection is asserted as required by the verification contract;
- unchanged state is asserted when material;
- material side effects and prohibited side effects are visible;
- failure messages remain actionable.

### Discovery and maintenance

- the authoritative runner discovers the test;
- the test is not executed twice;
- no broad shared-base or helper coupling was introduced;
- protected-baseline rules were followed;
- applicable formatting and syntax checks pass.

## 9. Prohibited Patterns

Do not:

- define proof applicability, `PASS`, `EXPECTED_NONPASS`, `FAIL`, or delivery gates in test-source standards;
- depend on local clock, uncontrolled randomness, or test execution order when reproducibility matters;
- hide materially different workflows inside one dataset;
- hide expected values inside generic assertion helpers;
- leave required tests incomplete, skipped, focused-only, or undiscovered;
- narrow runner selection to hide a failure;
- automatically regenerate expected outputs or protected snapshots;
- move protected source out of discovery;
- modify protected test source without the verification-contract authority required for a material revision;
- use generated scaffolding as accepted proof before it is completed;
- create manual aggregators or duplicate discovery;
- add production-only test hooks without a real owned application purpose;
- duplicate exact naming rules already owned by Repository Naming Standards.

## 10. Related

- [Test Implementation Standards Index](index.md)
- [Test Source And Placement Standards](test-source-and-placement-standards.md)
- [Laravel And Database Test Implementation Standards](laravel-and-database-test-implementation-standards.md)
- [Fixtures, Doubles, And Async Test Implementation Standards](fixtures-doubles-and-async-test-implementation-standards.md)
- [Browser Test Implementation Standards](browser-test-implementation-standards.md)
- [Testing Standards Index](../../testing/index.md)
- [Verification Contract And Evidence Standards](../../testing/verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](../../testing/automated-and-static-testing-standards.md)
- [Repository Naming Standards](../repository-naming-standards.md)
- [Code Template And Generator Standards](../Code%20Template%20And%20Generator%20Standards.md)
- [Stub Templates](../../../../stubs/README.md)
