<!--
DOC-META
title: UI Contract And Interaction Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/ui-and-accessibility/ui-contract-and-interaction-testing-standards.md
parent: docs/02-standards/testing/ui-and-accessibility/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines verification rules for public UI Contracts, rendered semantics, real-browser interaction, repository-wide UI usage, and semantic action, navigation, and state conformance.
-->

# UI Contract And Interaction Testing Standards

Parent: [UI And Accessibility Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. UI Proof Declaration](#2-ui-proof-declaration)
- [3. Public UI Contract Validation](#3-public-ui-contract-validation)
- [4. Rendered Semantic Conformance](#4-rendered-semantic-conformance)
- [5. Real-Browser Interaction Testing](#5-real-browser-interaction-testing)
- [6. Repository-Wide Usage Conformance](#6-repository-wide-usage-conformance)
- [7. Semantic Action, Navigation, And State Usage](#7-semantic-action-navigation-and-state-usage)
- [8. Evidence And Reporting](#8-evidence-and-reporting)
- [9. Prohibited Patterns](#9-prohibited-patterns)
- [10. Related](#10-related)

## 1. Purpose And Authority

Define how accepted reusable UI Contracts and owner-specific presentation behavior are verified through Contract validation, rendered semantics, real-browser interaction, and repository-wide usage checks.

This standard applies to applicable Elements, Components, Patterns, Layouts, Frame rendering, owner-specific Product/Page presentation, and active consumers of installed UI APIs.

It does not define UI public APIs, visual design, semantic action vocabulary, accessibility targets, keyboard Contracts, browser-support matrices, Product behavior, authorization, or final design approval. Those remain with their canonical UI, feature, architecture, accessibility, or repository owners.

Passing UI automation proves only the declared assurance layer. It does not constitute visual, usability, accessibility, or repository-owner approval.

## 2. UI Proof Declaration

In addition to shared verification-contract fields, declare applicable:

- UI owner and target artifact/surface;
- canonical UI Contract;
- assurance layer;
- source/consumer scope;
- route or entry point;
- actor/content/data/UI state;
- browser/viewport/input method when material;
- exact command or procedure;
- expected semantic or interaction result;
- evidence and reviewer when required;
- limitations.

A missing or unresolved Contract does not authorize the test to invent API behavior. Use the shared state model when a required prerequisite prevents execution.

## 3. Public UI Contract Validation

The governing UI standard owns the public API. Testing verifies it.

Verify applicable Contract declarations and accepted values, including:

- ownership/status;
- public props/options and types;
- required/default/allowed values;
- slots/content boundaries;
- stable data attributes or JavaScript API;
- CSS namespace and dependencies;
- item/data shape;
- variants/sizes/modifiers/states;
- composition rules;
- accessibility/content Contracts;
- prohibited, deferred, or gated capabilities.

Verify both allowed API use and accepted rejection of unsupported properties/values, missing required values, invalid combinations, duplicate identifiers, retired API, uninstalled capability, prohibited dependency, or owner/tier violation.

Do not convert draft, deferred, external, or uninstalled capability into an implemented Contract through tests.

Maintain traceability where required:

```text
canonical UI Contract
    ↓
source implementation
    ↓
targeted proof
    ↓
rendered/reference evidence
    ↓
active usage
```

Generated registries or usage inventories support traceability but do not become independent UI authority.

## 4. Rendered Semantic Conformance

Rendered semantic proof verifies accepted output without relying on appearance alone.

Verify applicable:

- native element/role;
- heading, landmark, list, table, and form structure;
- action versus navigation semantics;
- link destination;
- disabled/readonly/current/selected/expanded/invalid states;
- accessible names/descriptions/relationships;
- help/error/status relationships;
- generated identifiers and duplicate-ID prevention;
- supported Contract state rendering.

Only test states and semantics actually owned by the canonical Contract.

Server-rendered assertions may prove markup, attributes, content, class/token output, identifiers, initial state, and Contract mapping. They do not prove actual browser focus movement, keyboard/pointer events, JavaScript initialization, animation, browser storage/navigation, responsive layout, rendered contrast, or assistive-technology interpretation.

Use browser or specialist proof when those behaviors are material.

## 5. Real-Browser Interaction Testing

A real-browser proof is required when acceptance depends on actual DOM/JavaScript behavior, focus, keyboard/pointer/touch interaction, browser navigation/history/storage, downloads, viewport behavior, animation, or browser security behavior.

Verify applicable:

- initialization and required idempotent reinitialization;
- no duplicate handlers;
- behavior after partial Page update or navigation;
- teardown/cleanup of listeners, observers, timers, and temporary nodes;
- user-observable activation, typing, selection, disclosure, menu/dialog/form behavior, cancellation, navigation, pagination, filtering, sorting, download, pointer/touch, and stable final state;
- accepted progressive enhancement;
- target interaction actually initialized and executed.

Do not invoke private JavaScript or manually force final DOM state merely to make a test pass.

Browser-source implementation details such as selectors, waits, storage-state setup, and Playwright code organization belong to [Browser Test Implementation Standards](../../coding/test-implementation/browser-test-implementation-standards.md).

## 6. Repository-Wide Usage Conformance

Repository-wide validation may detect applicable:

- unregistered UI artifacts;
- unsupported or retired API;
- missing required API values;
- invalid combinations;
- missing accessible naming/state wiring;
- direct legacy icon use;
- one-off markup bypassing an installed API;
- prohibited raw class/token usage;
- invalid owner/tier dependency;
- incorrect source placement;
- active use of draft/deferred API.

Use semantic parsing when template syntax requires structure-aware analysis. Fragile regex alone is insufficient when it cannot reliably identify the relevant Blade or markup structure.

Generated observations must remain reproducible and separate from reviewed truth. A tool may identify usage and ambiguity; it cannot approve a Component or semantic choice without sufficient Contract context.

## 7. Semantic Action, Navigation, And State Usage

Verify the applicable rules defined by the governing UI Component, Pattern, feature, route, or interaction Contract.

Applicable proof may establish that:

- action controls use action semantics;
- navigation uses navigation semantics;
- state-changing behavior does not use a prohibited navigation method;
- destructive behavior receives required treatment/confirmation;
- icon-only controls have accepted names;
- loading/pending behavior prevents duplicate action when required;
- selected, current, active, pressed, and expanded states are not conflated;
- disabled/unavailable controls are represented accurately;
- UI visibility never replaces backend authorization.

These are proof categories, not an independent source of public UI API values.

## 8. Evidence And Reporting

Material UI evidence must make clear which assurance layer actually ran and what environment/state it covered. Retain applicable route, actor/content state, browser/viewport/input mode, command/procedure, automated report, trace/screenshot, cleanup, and limitations.

Do not retain credentials, tokens, cookies, authorization headers, private data, or unrestricted server logs in browser evidence.

Artifact schema and retention follow [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 9. Prohibited Patterns

Do not:

- let tests invent Component or Pattern APIs;
- treat server-rendered output as proof of browser interaction;
- call private JavaScript instead of using the accepted user interaction;
- assert private DOM structure consumers do not depend on;
- treat generated usage observations as reviewed truth;
- use UI visibility as authorization proof;
- use one generic `UI passed` claim when only one assurance layer ran;
- retain sensitive browser evidence;
- treat browser automation as final visual or accessibility approval.

## 10. Related

- [UI And Accessibility Testing Standards Index](index.md)
- [Accessibility Testing Standards](accessibility-testing-standards.md)
- [Visual, Responsive, And Specialist Review Standards](visual-responsive-and-specialist-review-standards.md)
- [Browser Test Implementation Standards](../../coding/test-implementation/browser-test-implementation-standards.md)
- [UI Standards Index](../../ui/index.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
