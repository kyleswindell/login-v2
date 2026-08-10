<!--
DOC-META
title: Browser Test Implementation Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/browser-test-implementation-standards.md
parent: docs/02-standards/coding/test-implementation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines Playwright source, user-observable interaction, selectors, synchronization, browser actors and data, test hooks, external-state handling, and browser-evidence safety.
-->

# Browser Test Implementation Standards

Parent: [Test Implementation Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Playwright Source](#2-playwright-source)
- [3. User-Observable Interaction](#3-user-observable-interaction)
- [4. Selectors And Test Hooks](#4-selectors-and-test-hooks)
- [5. Waiting And Synchronization](#5-waiting-and-synchronization)
- [6. Browser Actors, Data, And Authentication](#6-browser-actors-data-and-authentication)
- [7. Browser External State](#7-browser-external-state)
- [8. Browser Evidence Safety](#8-browser-evidence-safety)
- [9. Prohibited Patterns](#9-prohibited-patterns)
- [10. Review](#10-review)
- [11. Related](#11-related)

## 1. Purpose And Scope

Define how Playwright browser test source is written and maintained after the verification contract has selected browser execution as a required proof.

This standard owns implementation rules for:

- Playwright source files;
- browser-test placement as applied through the general placement standard;
- user-observable interaction;
- selectors and production test hooks;
- waiting and synchronization;
- browser actor and data setup;
- authentication shortcuts when authentication is outside the proof;
- browser-visible external state;
- trace, screenshot, video, DOM, and network evidence safety.

It does not decide whether browser proof, accessibility review, visual review, or a specific browser project is required. Use [UI, Accessibility, And Interaction Testing Standards](../../testing/ui-accessibility-and-interaction-testing-standards.md), the verification contract, and the applicable UI or feature Contract for those decisions.

Browser placement follows [Test Source And Placement Standards](test-source-and-placement-standards.md).

## 2. Playwright Source

Use the installed Playwright runner and current repository configuration.

Browser specs use the configured `.spec.js` discovery convention unless an accepted repository change updates that convention.

Do not introduce another browser or JavaScript test runner without the accepted dependency and architecture authority required by the repository.

A browser spec should make discoverable the material:

- target route, Product, Page, or UI artifact;
- actor state;
- fixture or content state;
- viewport when material;
- browser project when material;
- public interaction;
- expected final observable state.

Do not encode the entire verification contract as comments in the spec. Keep issue and proof mapping in the designated evidence or work-packet surfaces when source comments are not needed to understand the test.

Keep each spec focused enough that a failure identifies one coherent workflow or interaction responsibility.

## 3. User-Observable Interaction

Perform user-observable interaction through the browser.

Use applicable:

- navigation;
- accessible control activation;
- keyboard input;
- pointer input;
- form completion;
- visible state;
- browser history;
- download behavior;
- public DOM state;
- public URL state.

Do not:

- call private JavaScript functions;
- invoke internal controllers or server methods directly from the browser test;
- mutate component internals through `page.evaluate()` merely to create the final state;
- set final DOM state manually;
- bypass the UI action solely to make the spec pass.

A browser setup helper may provision prerequisite state through an accepted test boundary when that prerequisite is outside the proof. It must not bypass the behavior the browser proof claims to verify.

When a workflow includes a real download, navigation, dialog, or browser-history behavior, interact through the browser surface rather than asserting only internal JavaScript state.

## 4. Selectors And Test Hooks

Prefer selectors based on accepted semantics in this order when practical:

1. role and accessible name;
2. label;
3. placeholder when contractually stable;
4. visible text when uniquely meaningful;
5. accepted public `data-ui-*` or test hook;
6. stable CSS selector only when the UI Contract owns it.

Avoid selectors based on:

- DOM position;
- `nth-child` or equivalent ordinal structure;
- generated framework wrappers;
- incidental class order;
- private implementation IDs;
- broad text that appears in multiple locations;
- transient animation or state classes;
- current markup nesting that is not part of the public UI Contract.

Do not add a production test hook without a clear stable owner.

A test hook must:

- exist only when semantic selectors are insufficient or unstable for an accepted reason;
- remain presentation-oriented rather than becoming a hidden business API;
- not expose sensitive data or authorization state;
- have a stable name controlled by the owning UI or Product presentation Contract.

Do not use test hooks to reach into private component state when the same behavior can be observed publicly.

## 5. Waiting And Synchronization

Use Playwright assertions and auto-waiting whenever possible.

Wait for an observable condition such as:

- URL or navigation state;
- role or accessible control;
- visible text;
- public state attribute;
- response or request completion when transport is material;
- download;
- dialog;
- stable final UI state.

Do not use arbitrary fixed sleeps as the primary synchronization mechanism.

A bounded delay is acceptable only when timing itself is part of the accepted behavior and the proof documents why a clock-based wait is necessary.

Do not use a long timeout to conceal a race condition or missing readiness signal.

When application code exposes a stable public state transition, wait on that state instead of implementation-specific animation timing.

## 6. Browser Actors, Data, And Authentication

Use isolated synthetic browser actors and data.

Do not depend on:

- a developer's existing browser session;
- manually created shared records;
- production accounts;
- production customer data;
- persistent browser storage from another spec;
- execution order;
- a previous spec's cookies or local storage.

Provision actors and fixtures through an accepted test setup boundary.

Do not bypass authentication when authentication is part of the criterion.

A storage-state or session shortcut may be used when authentication is outside the proof and the shortcut is:

- isolated;
- synthetic;
- safe;
- deterministic;
- declared by the browser harness;
- invalidated or replaced when actor state changes materially.

Do not use a privileged shared browser actor merely to simplify unrelated tests.

When authorization is material, use the narrowest actor state required by the verification contract.

## 7. Browser External State

Browser tests that interact with external services, downloads, uploads, realtime channels, or other environment state must use the isolation mechanism selected by the verification contract.

Implementation options may include an accepted:

- sandbox;
- protocol fixture;
- mock server;
- service virtualization layer;
- temporary file or directory;
- owner-controlled test account;
- isolated realtime channel.

Do not mutate a shared external environment without explicit authorization and cleanup.

When a service is replaced by a mock or virtualization layer, browser assertions must not claim the replaced service itself was verified.

Downloads and uploads must use synthetic content and temporary storage controlled by the test.

Clean up browser-created external state when the environment does not guarantee isolation automatically.

## 8. Browser Evidence Safety

Browser traces, screenshots, videos, DOM snapshots, console output, and network logs may contain sensitive information.

Test source and configuration must prevent unnecessary retention of:

- passwords;
- MFA material;
- recovery codes;
- raw tokens;
- cookies;
- authorization headers;
- private personal data;
- unrestricted server logs;
- production identifiers that are not required for the proof.

Use synthetic data.

Redact or omit sensitive evidence at the source rather than relying only on later cleanup.

Do not enable unrestricted request or response-body logging merely to debug a browser failure.

When a screenshot, video, trace, or network artifact is retained as material evidence, its handling and retention remain governed by the Testing Standards suite.

## 9. Prohibited Patterns

Do not:

- directly mutate final DOM or component state;
- call private JavaScript or server implementation instead of browser-visible behavior;
- rely on DOM position or generated framework wrappers as the normal selector strategy;
- add a production test hook without an owner;
- expose secrets or authorization state through a test hook;
- use arbitrary sleeps as normal synchronization;
- depend on a developer's session or another spec's browser state;
- use production accounts or customer data;
- claim a replaced external service was verified by a mock-backed browser test;
- retain sensitive browser evidence unnecessarily;
- place browser specs in production JavaScript directories without an accepted owner-local convention and configured discovery.

## 10. Review

Before accepting browser test source, confirm:

- placement follows the smallest clear owner and configured Playwright discovery;
- the spec performs user-observable interaction;
- selectors use stable public semantics;
- test hooks are justified, owned, and safe;
- synchronization waits on observable state rather than arbitrary delay;
- actors and data are synthetic and isolated;
- authentication shortcuts do not bypass the behavior under test;
- external state is isolated and cleaned up;
- browser evidence does not expose restricted material;
- the spec does not claim behavior hidden behind mocks or setup shortcuts.

Visual, accessibility, browser-matrix, and acceptance sufficiency remain governed by their canonical testing and UI owners.

## 11. Related

- [Test Implementation Standards Index](index.md)
- [Test Source And Placement Standards](test-source-and-placement-standards.md)
- [Fixtures, Doubles, And Async Test Implementation Standards](fixtures-doubles-and-async-test-implementation-standards.md)
- [Test Source Lifecycle Standards](test-source-lifecycle-standards.md)
- [Testing Standards Index](../../testing/index.md)
- [UI, Accessibility, And Interaction Testing Standards](../../testing/ui-accessibility-and-interaction-testing-standards.md)
- [UI Standards Index](../../ui/index.md)
- [Repository Architecture](../../../03-architecture/repository-architecture.md)
- [Playwright Configuration](../../../../playwright.config.js)
