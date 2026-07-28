<!--
DOC-META
title: UI, Accessibility, And Interaction Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/ui-accessibility-and-interaction-testing-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines UI contract, implementation, usage, accessibility, browser, responsive, motion, visual, and manual interaction testing.
-->

# UI, Accessibility, And Interaction Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Four UI Assurance Layers](#2-four-ui-assurance-layers)
  - [2.1. Public UI Contract validation](#21-public-ui-contract-validation)
  - [2.2. Component implementation conformance](#22-component-implementation-conformance)
  - [2.3. Repository-wide usage conformance](#23-repository-wide-usage-conformance)
  - [2.4. Manual or specialist review](#24-manual-or-specialist-review)
- [3. Public UI Contract Validation](#3-public-ui-contract-validation)
- [4. Component Implementation Conformance](#4-component-implementation-conformance)
- [5. Repository-Wide Usage Conformance](#5-repository-wide-usage-conformance)
- [6. Semantic Action And Navigation Usage](#6-semantic-action-and-navigation-usage)
- [7. Accessibility Testing](#7-accessibility-testing)
- [8. Keyboard And Focus](#8-keyboard-and-focus)
- [9. Browser And Responsive Testing](#9-browser-and-responsive-testing)
- [10. Motion And Reduced Motion](#10-motion-and-reduced-motion)
- [11. Visual And Interaction Review](#11-visual-and-interaction-review)
- [12. Snapshots And Screenshots](#12-snapshots-and-screenshots)
- [13. Active Usage Validation](#13-active-usage-validation)
- [14. Related](#14-related)

## 1. Purpose

Define objective and human verification for UI Elements, Components, Patterns, Layouts, Frame rendering, owner-specific Product presentation, and browser interaction.

This standard defines how accepted UI Contracts and design rules are verified. It does not define Component or Pattern public APIs, variants, states, semantic meanings, visual hierarchy, accessibility requirements, motion rules, or supported browser matrices. Those remain with the applicable UI, feature, architecture, accessibility, and browser-support owners.

Passing UI automation does not constitute visual approval.

## 2. Four UI Assurance Layers

### 2.1. Public UI Contract validation

Proves only allowed properties, variants, sizes, states, slots, events, and combinations are accepted.

### 2.2. Component implementation conformance

Proves each supported Contract state renders and behaves correctly.

### 2.3. Repository-wide usage conformance

Proves consumers use the Component or Pattern according to semantic and architectural rules.

### 2.4. Manual or specialist review

Proves design-sensitive, usability, accessibility, motion, and interaction qualities that automation cannot fully determine.

A Component Contract can prevent invalid construction. It cannot always determine whether a valid option is semantically correct in the caller’s context.

## 3. Public UI Contract Validation

Verify:

- supported props;
- required props;
- defaults;
- enums;
- mutually exclusive options;
- valid combinations;
- slots;
- events and JavaScript controls;
- generated identifiers;
- accessible-name requirements;
- class and data-attribute output;
- dependency declarations;
- lifecycle and status metadata;
- Contract-to-implementation link;
- Contract-to-test link;
- Contract-to-reference link.

Invalid values should fail clearly during validation, development, static checks, or tests rather than silently degrading.

When a governing UI Contract models semantic intent, verification should prove that the accepted semantic input maps to the Contract-owned rendering, state, interaction, and accessibility behavior. This testing standard does not select or invent that public API.

## 4. Component Implementation Conformance

For every supported state, verify applicable:

- semantic HTML;
- role and accessible name;
- props and slots;
- classes and tokens;
- variants and sizes;
- disabled, loading, selected, expanded, invalid, and empty states;
- keyboard behavior;
- focus behavior;
- JavaScript initialization and teardown;
- events;
- generated IDs and relationships;
- error and help text;
- responsive behavior;
- reduced-motion behavior;
- reference examples.

Test the public Contract, not private rendering details that consumers do not depend on.

## 5. Repository-Wide Usage Conformance

Repository usage validation should detect applicable:

- unsupported props or values;
- deprecated variants;
- missing required accessible labels;
- direct legacy icon components;
- one-off markup that bypasses an accepted Component;
- raw styling that contradicts semantic intent;
- invalid Component combinations;
- incorrect owner or tier usage;
- navigation implemented as an action or action implemented as navigation;
- direct CSS duplication of accepted UI behavior;
- missing required state handling;
- active usage of draft or retired APIs.

Usage validation may combine:

- Blade parsing;
- static analysis;
- Component Registry checks;
- Contract export validation;
- targeted rendering tests;
- architecture tests.

Do not rely on fragile regular expressions as the only parser when Blade structure requires semantic understanding.

## 6. Semantic Action And Navigation Usage

Verify the applicable semantic action, navigation, hierarchy, confirmation, accessibility, and state rules defined by the governing UI Component, Pattern, feature, route, or interaction Contract.

Applicable verification may include:

- action controls use the Contract-owned action semantics;
- navigation controls use the Contract-owned navigation semantics;
- state-changing behavior is not exposed through a prohibited navigation method;
- destructive behavior uses the accepted destructive treatment;
- primary and secondary hierarchy follows the governing UI rule;
- required confirmation behavior is present;
- icon-only controls have accepted accessible names;
- disabled controls do not remain misleadingly actionable;
- loading or pending behavior prevents duplicate action where required;
- permission-hidden UI does not replace backend authorization.

These are testing categories, not independent UI API definitions. The exact semantic terms, visual treatment, component choice, and interaction behavior come from the governing UI or feature owner.

Semantic usage tests need the caller’s context. A raw Component variant enum alone cannot prove correct intent.

## 7. Accessibility Testing

Accessibility verification combines:

- automated accessibility rules;
- semantic markup assertions;
- accessible-name and description assertions;
- keyboard testing;
- focus testing;
- screen-reader review;
- contrast and token validation;
- zoom and reflow review;
- reduced-motion behavior;
- error identification;
- status and live-region behavior;
- manual specialist review where required.

Automated accessibility tests may prove machine-checkable conditions. They cannot establish complete WCAG conformance.

The applicable UI Contract must identify accessibility requirements and known manual-review needs.

## 8. Keyboard And Focus

Verify applicable:

- logical tab order;
- visible focus;
- focus entry and return;
- escape behavior;
- arrow-key behavior;
- roving tab index;
- focus trapping;
- no keyboard trap;
- disabled-item behavior;
- menu, dialog, combobox, tabs, and disclosure patterns;
- focus after validation errors;
- focus after route or state changes.

Browser-level proof is required when JavaScript or real focus behavior is material.

## 9. Browser And Responsive Testing

Declare the supported browser matrix.

Verify applicable:

- rendering;
- interaction;
- DOM events;
- storage;
- navigation;
- form behavior;
- downloads;
- pointer and keyboard input;
- responsive layout;
- overflow;
- reflow;
- zoom;
- mobile viewport;
- orientation;
- high contrast or forced colors where supported.

Do not expand the browser matrix without accepted support requirements.

## 10. Motion And Reduced Motion

Verify:

- approved duration and easing tokens;
- motion purpose;
- entry and exit states;
- interruption behavior;
- no duplicate animation initialization;
- reduced-motion alternative;
- no required information conveyed only through motion;
- no motion that prevents interaction;
- stable final state;
- performance under representative conditions.

Token and CSS checks can prove approved values. Human review is required to judge whether motion is understandable, restrained, and appropriate.

## 11. Visual And Interaction Review

Manual visual review is required for changes affecting:

- spacing;
- layout;
- hierarchy;
- color use;
- visual emphasis;
- responsive composition;
- interaction feel;
- motion;
- empty, loading, error, and destructive states;
- cross-Component composition.

Record:

- environment;
- viewport;
- browser;
- route or reference Page;
- states reviewed;
- expected design;
- actual result;
- screenshots when useful;
- reviewer;
- unresolved findings.

Codex is not the final visual design authority.

## 12. Snapshots And Screenshots

Use snapshots only when the output is:

- stable;
- meaningful;
- reviewable;
- not dominated by irrelevant generated values.

Snapshots should supplement focused assertions.

A screenshot proves appearance in one environment and state. It does not by itself prove semantic HTML, accessibility, responsive behavior, or correct interaction.

Visual regression tooling requires approved baselines and explicit review of baseline changes.

## 13. Active Usage Validation

An active-usage validator may enforce:

- every used Component slug is registered;
- every used prop and value is allowed;
- required props are present;
- retired APIs are absent;
- semantic action values map to accepted rendering;
- direct legacy patterns are absent;
- required Contracts and references exist;
- Component dependencies are valid;
- usage remains within accepted owner and tier boundaries.

The validator must consume canonical Component Contracts. Generated output remains non-authoritative and rebuildable.

A validator cannot independently determine every semantic context. Ambiguous cases require targeted tests or review.

## 14. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [UI Standards Index](../ui/index.md)
- [UI API Registry](../ui/api-registry.md)
- [Component Implementation Checklist](../ui/components/checklist.md)
- [Workspace Navigation And Frame Composition](../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Carbon Design System Accessibility Status](https://carbondesignsystem.com/components/overview/accessibility-status/)
- [Carbon Design System Button Usage](https://carbondesignsystem.com/components/button/usage/)
- [W3C Accessibility Conformance Testing Rules](https://www.w3.org/WAI/standards-guidelines/act/)
