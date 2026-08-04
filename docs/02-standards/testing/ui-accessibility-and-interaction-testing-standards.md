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
summary: Defines construction and evidence rules for UI Contract validation, rendered semantics, browser interaction, repository usage, accessibility, keyboard and focus, responsive behavior, motion, visual regression, and manual specialist review.
-->

# UI, Accessibility, And Interaction Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. UI Assurance Model](#2-ui-assurance-model)
  - [2.1. Public UI Contract validation](#21-public-ui-contract-validation)
  - [2.2. Rendered semantic conformance](#22-rendered-semantic-conformance)
  - [2.3. Real-browser interaction proof](#23-real-browser-interaction-proof)
  - [2.4. Repository-wide usage conformance](#24-repository-wide-usage-conformance)
  - [2.5. Visual-regression proof](#25-visual-regression-proof)
  - [2.6. Manual or specialist review](#26-manual-or-specialist-review)
- [3. UI Proof Declaration](#3-ui-proof-declaration)
- [4. Public UI Contract Validation](#4-public-ui-contract-validation)
  - [4.1. Contract completeness](#41-contract-completeness)
  - [4.2. Allowed API validation](#42-allowed-api-validation)
  - [4.3. Invalid API rejection](#43-invalid-api-rejection)
  - [4.4. Contract traceability](#44-contract-traceability)
- [5. Rendered Semantic Conformance](#5-rendered-semantic-conformance)
  - [5.1. Semantic structure](#51-semantic-structure)
  - [5.2. State rendering](#52-state-rendering)
  - [5.3. Names, descriptions, and relationships](#53-names-descriptions-and-relationships)
  - [5.4. Server-rendered proof limits](#54-server-rendered-proof-limits)
- [6. Real-Browser Interaction Testing](#6-real-browser-interaction-testing)
  - [6.1. Browser requirement](#61-browser-requirement)
  - [6.2. Initialization and teardown](#62-initialization-and-teardown)
  - [6.3. User interaction](#63-user-interaction)
  - [6.4. State synchronization](#64-state-synchronization)
  - [6.5. Failure evidence](#65-failure-evidence)
- [7. Repository-Wide Usage Conformance](#7-repository-wide-usage-conformance)
  - [7.1. Static usage validation](#71-static-usage-validation)
  - [7.2. Semantic-context validation](#72-semantic-context-validation)
  - [7.3. Owner and tier boundaries](#73-owner-and-tier-boundaries)
  - [7.4. Generated observations](#74-generated-observations)
- [8. Semantic Action, Navigation, And State Usage](#8-semantic-action-navigation-and-state-usage)
- [9. Accessibility Proof Model](#9-accessibility-proof-model)
  - [9.1. Accessibility requirement authority](#91-accessibility-requirement-authority)
  - [9.2. Automated accessibility checks](#92-automated-accessibility-checks)
  - [9.3. Semantic assertions](#93-semantic-assertions)
  - [9.4. Manual and specialist accessibility review](#94-manual-and-specialist-accessibility-review)
- [10. Keyboard And Focus Testing](#10-keyboard-and-focus-testing)
  - [10.1. Keyboard operation](#101-keyboard-operation)
  - [10.2. Focus order and visibility](#102-focus-order-and-visibility)
  - [10.3. Focus movement and restoration](#103-focus-movement-and-restoration)
  - [10.4. Composite widgets](#104-composite-widgets)
  - [10.5. Keyboard and focus evidence](#105-keyboard-and-focus-evidence)
- [11. Screen-Reader And Assistive-Technology Review](#11-screen-reader-and-assistive-technology-review)
- [12. Error, Status, Loading, And Dynamic-Content Testing](#12-error-status-loading-and-dynamic-content-testing)
- [13. Contrast, Zoom, Reflow, And Forced-Color Testing](#13-contrast-zoom-reflow-and-forced-color-testing)
- [14. Browser, Viewport, Input, And Responsive Testing](#14-browser-viewport-input-and-responsive-testing)
  - [14.1. Supported matrix authority](#141-supported-matrix-authority)
  - [14.2. Responsive proof declaration](#142-responsive-proof-declaration)
  - [14.3. Pointer, touch, and keyboard input](#143-pointer-touch-and-keyboard-input)
  - [14.4. Browser-proof limits](#144-browser-proof-limits)
- [15. Motion And Reduced-Motion Testing](#15-motion-and-reduced-motion-testing)
- [16. Visual And Interaction Review](#16-visual-and-interaction-review)
  - [16.1. Required manual review](#161-required-manual-review)
  - [16.2. Review declaration](#162-review-declaration)
  - [16.3. Reviewer authority](#163-reviewer-authority)
  - [16.4. Review result](#164-review-result)
- [17. Visual Regression, Snapshots, And Screenshots](#17-visual-regression-snapshots-and-screenshots)
  - [17.1. Visual-regression baseline](#171-visual-regression-baseline)
  - [17.2. Baseline revision](#172-baseline-revision)
  - [17.3. DOM and rendered-output snapshots](#173-dom-and-rendered-output-snapshots)
  - [17.4. Screenshot limits](#174-screenshot-limits)
- [18. Reference And Rendered-Evidence Surfaces](#18-reference-and-rendered-evidence-surfaces)
- [19. UI Evidence And Reporting](#19-ui-evidence-and-reporting)
- [20. Failure Classification](#20-failure-classification)
  - [`BLOCKED`](#blocked)
  - [`EXECUTED + FAIL`](#executed--fail)
- [21. Prohibited Patterns](#21-prohibited-patterns)
- [22. Related](#22-related)

## 1. Purpose And Authority

Define how accepted UI Contracts, semantic behavior, accessibility requirements, browser interaction, responsive behavior, motion rules, and visual requirements are verified.

This standard applies to:

- Foundation Elements;
- Components;
- Patterns;
- Layouts;
- Frame rendering;
- owner-specific Product presentation;
- rendered-evidence and reference surfaces;
- real-browser interaction;
- repository-wide UI usage.

This standard owns:

- UI proof construction;
- assurance-layer selection;
- browser-proof requirements;
- accessibility evidence methods;
- visual-regression evidence;
- manual-review records;
- result classification.

This standard does not define:

- Element, Component, Pattern, or Layout public APIs;
- installed variants, options, sizes, states, or modifiers;
- semantic action or navigation meanings;
- visual hierarchy;
- spacing or token values;
- accessibility conformance target;
- applicable WCAG version or level;
- assistive-technology matrix;
- keyboard interaction Contract;
- browser-support matrix;
- responsive breakpoints;
- motion behavior;
- Product or feature behavior;
- authorization;
- final visual approval.

Those requirements remain with the applicable UI, feature, architecture, accessibility, browser-support, Product, or repository owner.

Passing UI automation does not constitute visual, usability, accessibility, or repository-owner approval.

Codex is not the final visual design authority and cannot approve its own required manual or specialist review.

## 2. UI Assurance Model

UI proof is divided into six assurance layers.

A material UI `PF-*` proof must identify the layer or layers it uses.

No one layer proves every UI quality.

### 2.1. Public UI Contract validation

Proves that the canonical UI Contract is complete enough for the target work and that only accepted API inputs, states, relationships, and combinations are permitted.

### 2.2. Rendered semantic conformance

Proves that accepted API inputs produce the required semantic HTML, attributes, relationships, content, and states.

This proof may use server-rendered output where real browser behavior is not material.

### 2.3. Real-browser interaction proof

Proves behavior that depends on:

- browser DOM;
- JavaScript;
- focus;
- keyboard;
- pointer or touch;
- navigation;
- storage;
- viewport;
- animation;
- browser events.

### 2.4. Repository-wide usage conformance

Proves that active consumers use canonical UI APIs and follow accepted semantic, ownership, and tier rules.

### 2.5. Visual-regression proof

Detects rendered visual differences against a protected baseline for declared environments and states.

Visual regression detects change. It does not independently determine whether the change is correct.

### 2.6. Manual or specialist review

Provides human judgment for qualities that automation cannot fully establish, including:

- visual hierarchy;
- usability;
- interaction clarity;
- motion quality;
- screen-reader interpretation;
- complex accessibility behavior;
- responsive composition;
- cross-Component composition;
- design acceptance.

A valid Component API can prevent invalid construction. It cannot always determine whether the caller selected the semantically correct option for its context.

## 3. UI Proof Declaration

Every material UI `PF-*` proof declares applicable:

- proof ID;
- mapped `AC-*` criteria;
- requirement source;
- UI owner;
- proof layer;
- target Element, Component, Pattern, Layout, Frame, or Product surface;
- canonical UI Contract;
- source files;
- rendered-evidence or reference surface;
- route or entry point;
- actor or user state;
- content and data state;
- UI state;
- browser;
- viewport;
- input method;
- assistive technology;
- color mode or theme;
- motion preference;
- zoom or display condition;
- exact command or procedure;
- expected result;
- evidence;
- reviewer;
- stage applicability;
- cleanup;
- limitations.

Use `NOT_APPLICABLE` only when a proof layer is intentionally excluded at a declared stage with an accepted reason.

Example:

```text
Preimplementation browser review:
NOT_APPLICABLE — no executable interaction surface exists.

Final browser review:
REQUIRED
```

A missing browser, Contract, reference surface, or required reviewer may make a proof `BLOCKED`. It does not authorize speculative API or design decisions.

## 4. Public UI Contract Validation

The individual UI standard owns its public API.

Testing verifies that Contract without inventing it.

### 4.1. Contract completeness

Verify applicable Contract declarations:

- purpose;
- status;
- ownership;
- public Blade or markup API;
- props and options;
- types;
- defaults;
- allowed values;
- required values;
- slots;
- data attributes;
- JavaScript API;
- CSS namespace;
- item or data Contract;
- variants;
- sizes;
- modifiers;
- states;
- token use;
- composition rules;
- accessibility Contract;
- content Contract;
- prohibited usage;
- deferred or gated capabilities;
- source files;
- rendered-evidence requirements;
- testing and acceptance criteria.

A testing rule must not convert an uncertain, deferred, gated, uninstalled, or Pattern-owned capability into an implemented API.

### 4.2. Allowed API validation

Verify applicable:

- supported properties;
- required properties;
- accepted values;
- defaults;
- enumerations;
- mutually exclusive values;
- allowed combinations;
- slots and allowed content;
- events;
- generated identifiers;
- item structures;
- dependency declarations;
- status and lifecycle metadata.

When the Contract models semantic intent, prove that accepted semantic input maps to Contract-owned rendering, state, interaction, and accessibility behavior.

Testing does not select or rename the semantic API.

### 4.3. Invalid API rejection

Invalid input should fail clearly through the accepted validation boundary.

Verify applicable rejection of:

- unsupported property;
- unsupported value;
- missing required property;
- invalid combination;
- prohibited slot content;
- duplicate identifier;
- invalid item shape;
- retired API;
- uninstalled capability;
- prohibited dependency;
- owner or tier violation.

Silent degradation is not valid rejection when the Contract requires explicit failure.

Do not create a stricter rule than the canonical Contract.

### 4.4. Contract traceability

Verify applicable links among:

```text
canonical UI Contract
    ↓
source implementation
    ↓
targeted tests
    ↓
rendered-evidence or reference surface
    ↓
active usage
```

A missing or stale link is a Contract or evidence failure when the governing UI standard requires it.

Generated registries and exports may support traceability but remain rebuildable observations rather than independent UI authority.

## 5. Rendered Semantic Conformance

Rendered semantic proof verifies accepted output without relying on visual appearance alone.

### 5.1. Semantic structure

Verify applicable:

- correct native element;
- required role;
- heading hierarchy;
- landmark;
- list or table structure;
- form association;
- link destination;
- action control semantics;
- disabled semantics;
- selected or current semantics;
- expanded or collapsed semantics;
- invalid state;
- description relationship;
- error relationship;
- live-region relationship;
- generated identifiers;
- no duplicate identifiers.

Prefer native semantic HTML where required by the governing UI Contract.

Testing does not replace accepted native semantics with ARIA merely to satisfy an assertion.

### 5.2. State rendering

For each supported Contract state, verify applicable:

- default;
- hover-capable state when machine-verifiable;
- focus;
- active or pressed;
- selected;
- current;
- expanded;
- collapsed;
- disabled;
- readonly;
- loading;
- pending;
- invalid;
- error;
- warning;
- success;
- empty;
- unavailable;
- destructive;
- reduced-motion state;
- responsive state.

Only test states actually owned by the UI Contract.

Do not infer a state from an external design system when Login 2.0 has not installed it.

### 5.3. Names, descriptions, and relationships

Verify applicable:

- accessible name;
- visible label;
- label association;
- description;
- help text;
- error text;
- status text;
- icon-only control name;
- relationship identifiers;
- group label;
- table caption or name;
- dialog name and description.

The expected name and description come from the governing UI, content, feature, or accessibility Contract.

### 5.4. Server-rendered proof limits

Server-rendered assertions may prove:

- markup;
- attributes;
- text;
- class and token output;
- identifiers;
- initial state;
- Contract mapping.

They do not prove:

- real focus movement;
- keyboard event handling;
- pointer behavior;
- JavaScript initialization;
- animation;
- browser storage;
- browser navigation;
- responsive layout;
- rendered contrast;
- screen-reader interpretation.

Use real-browser or manual proof when those behaviors are material.

## 6. Real-Browser Interaction Testing

### 6.1. Browser requirement

A real-browser proof is required when acceptance depends on:

- JavaScript;
- browser DOM state;
- focus;
- keyboard;
- pointer or touch;
- drag or resize;
- navigation;
- storage;
- history;
- downloads;
- viewport;
- animation;
- browser security behavior.

A server-side renderer, DOM string parser, or direct JavaScript unit test does not replace browser proof for those behaviors.

### 6.2. Initialization and teardown

Verify applicable:

- one initialization;
- idempotent reinitialization when required;
- no duplicate handlers;
- correct behavior after partial page update;
- teardown;
- cleanup of listeners, observers, timers, and temporary nodes;
- restoration after navigation;
- no stale state after Component removal;
- accepted progressive enhancement.

A browser test should fail if the target controller or interaction did not initialize.

### 6.3. User interaction

Use user-observable interaction rather than private JavaScript calls.

Verify applicable:

- click or activation;
- keyboard activation;
- typing;
- selection;
- disclosure;
- menu operation;
- dialog operation;
- form submission;
- cancellation;
- navigation;
- pagination;
- filtering;
- sorting;
- file selection or download;
- pointer and touch behavior;
- loading and completion;
- rejection and recovery.

Do not bypass the accepted entry point solely to make the browser test simpler.

### 6.4. State synchronization

Verify applicable synchronization among:

- DOM state;
- accessible state;
- visible state;
- URL or navigation state;
- server state;
- loading state;
- error state;
- stored state;
- Component relationships.

The proof should establish stable final state after the interaction completes.

### 6.5. Failure evidence

For material browser failures, retain applicable:

- screenshot;
- browser trace;
- console log;
- network log;
- DOM snapshot;
- video;
- route;
- viewport;
- browser version;
- actor and state;
- server correlation identifier;
- cleanup result.

Evidence must not expose credentials, tokens, cookies, authorization headers, private data, or unrestricted server logs.

## 7. Repository-Wide Usage Conformance

Repository usage validation enforces accepted active-use rules.

### 7.1. Static usage validation

Detect applicable:

- unregistered Component or Pattern;
- unsupported property;
- unsupported value;
- missing required property;
- invalid combination;
- deprecated or retired API;
- missing accessible name;
- missing state handling;
- direct legacy icon component;
- one-off markup bypassing an installed API;
- duplicate accepted UI behavior;
- prohibited raw class or token use;
- invalid dependency;
- incorrect source placement;
- active use of draft or deferred API.

Use semantic parsing when Blade or another template language requires structure-aware analysis.

Fragile regular expressions must not be the only parser when they cannot reliably identify the relevant syntax.

### 7.2. Semantic-context validation

Some UI choices are valid only in context.

Applicable targeted proof or review may verify:

- action versus navigation;
- destructive versus ordinary action;
- primary versus secondary hierarchy;
- confirmation requirement;
- icon-only control purpose;
- loading or pending protection;
- visible versus hidden state;
- selection versus activation;
- feature-owned permission context;
- responsive composition.

A raw enumeration value cannot establish that the caller selected the correct semantic intent.

Ambiguous cases require targeted rendering, browser proof, or human review.

### 7.3. Owner and tier boundaries

Verify applicable:

- Foundation Elements own primitives;
- Components own reusable local UI APIs;
- Patterns own reusable composition and interaction arrangements;
- Layouts own accepted structural composition;
- Product or feature owners own business rules, data, permissions, persistence, and workflow branching;
- UI does not perform domain authorization;
- higher tiers do not redefine lower-tier APIs;
- one issue does not silently expand into family-wide correction.

The exact boundaries come from canonical UI and architecture owners.

### 7.4. Generated observations

An active-usage inventory or validator may report:

- usage location;
- API version;
- status;
- violation;
- source trace;
- unresolved ambiguity.

Generated observations:

- do not set reviewed target state;
- do not approve a Component;
- do not classify a semantic choice as correct without sufficient Contract context;
- do not replace owner review;
- must remain reproducible.

Separate collection, review, rendering, and validation when inventory workflows require those phases.

## 8. Semantic Action, Navigation, And State Usage

Verify the applicable rules defined by the governing UI Component, Pattern, feature, route, or interaction Contract.

Applicable proof may include:

- action controls use accepted action semantics;
- navigation controls use accepted navigation semantics;
- state-changing behavior does not use a prohibited navigation method;
- destructive behavior uses the accepted treatment;
- hierarchy follows the governing UI rule;
- required confirmation is present;
- icon-only controls have accepted names;
- disabled controls do not remain misleadingly actionable;
- loading or pending behavior prevents duplicate action where required;
- selected, current, active, and expanded states are not conflated;
- permission-hidden UI does not replace backend authorization.

These are testing categories, not public API definitions.

Do not invent a generic action property, navigation property, hierarchy value, or destructive option in this standard.

## 9. Accessibility Proof Model

Accessibility verification combines objective automation and human review.

No single tool establishes complete conformance.

### 9.1. Accessibility requirement authority

The proof must cite applicable authority for:

- conformance target;
- WCAG version or level;
- native semantic requirement;
- keyboard behavior;
- accessible name;
- error behavior;
- contrast;
- zoom and reflow;
- motion;
- assistive technology;
- browser matrix;
- manual-review authority.

This standard does not select those targets.

When no accepted accessibility target exists, do not infer final acceptance from a scanner’s default rules.

### 9.2. Automated accessibility checks

Automated checks may prove machine-detectable conditions such as:

- missing accessible name;
- duplicate identifiers;
- invalid ARIA use;
- invalid relationships;
- missing form label;
- certain contrast failures;
- certain landmark or heading failures;
- prohibited focusable states.

Record:

- tool;
- version;
- ruleset;
- browser;
- route or rendered surface;
- exclusions;
- violations;
- limitations.

Automated accessibility tools cannot establish complete accessibility or WCAG conformance.

An automated result of zero violations is not final accessibility approval.

### 9.3. Semantic assertions

Use focused assertions for applicable:

- native semantic element;
- role;
- accessible name;
- description;
- state;
- relationship;
- error association;
- status announcement;
- focus target;
- keyboard behavior;
- reduced-motion state.

Focused semantic assertions should supplement broad automated scanning.

### 9.4. Manual and specialist accessibility review

Manual or specialist review may be required for:

- screen-reader interpretation;
- keyboard workflow;
- focus logic;
- cognitive clarity;
- error recovery;
- zoom and reflow;
- forced colors;
- motion;
- complex widgets;
- dynamic content;
- responsive composition;
- content order.

Every mandatory accessibility review receives a `PF-*` identifier and names the required reviewer authority.

Codex may prepare the review surface and evidence. It cannot approve the required specialist result unless explicitly delegated that authority by the repository owner.

## 10. Keyboard And Focus Testing

Exact keyboard and focus behavior comes from the governing Component, Pattern, or accessibility Contract.

### 10.1. Keyboard operation

Verify applicable:

- Tab;
- Shift+Tab;
- Enter;
- Space;
- Escape;
- arrow keys;
- Home;
- End;
- Page Up or Page Down;
- type-ahead;
- accepted shortcut;
- cancellation;
- no pointer-only requirement.

Do not impose keyboard behavior from an unrelated widget pattern.

### 10.2. Focus order and visibility

Verify applicable:

- logical focus order;
- visible focus indicator;
- focus is not obscured;
- disabled items are handled correctly;
- hidden content is not focusable;
- no unintended positive tab index;
- no keyboard trap;
- content order remains meaningful.

Visual focus review may be required even when DOM focus can be asserted automatically.

### 10.3. Focus movement and restoration

Verify applicable:

- initial focus;
- focus on opening;
- focus containment;
- focus after closing;
- focus after route change;
- focus after validation error;
- focus after dynamic insertion or removal;
- focus after destructive completion;
- focus after cancellation;
- focus restoration to a valid origin.

The expected destination comes from the governing interaction Contract.

### 10.4. Composite widgets

For accepted composite widgets, verify applicable:

- roving tab index;
- active descendant;
- arrow-key movement;
- wrapping behavior;
- selection behavior;
- activation behavior;
- disabled-item handling;
- Home and End behavior;
- Escape behavior;
- focus and selection distinction.

The UI Contract must identify the applicable interaction model.

### 10.5. Keyboard and focus evidence

Real-browser evidence should record:

- browser;
- viewport;
- input method;
- starting focus;
- interaction sequence;
- expected focus;
- actual focus;
- visible focus result;
- final state;
- limitation.

A direct call to `.focus()` alone does not prove the accepted user interaction.

## 11. Screen-Reader And Assistive-Technology Review

When required, declare:

- assistive technology;
- version;
- browser;
- operating system;
- route or reference surface;
- Component or Pattern state;
- reading or interaction task;
- expected announcement;
- actual announcement;
- navigation method;
- reviewer;
- findings;
- limitations.

Verify applicable:

- name;
- role;
- value;
- state;
- description;
- group context;
- table structure;
- form instructions;
- error announcement;
- status announcement;
- dynamic updates;
- dialog context;
- reading order;
- hidden-content behavior.

One assistive-technology combination proves only the declared combination.

Do not generalize one result to the entire supported matrix unless the governing accessibility plan permits it.

## 12. Error, Status, Loading, And Dynamic-Content Testing

Verify applicable:

- error identification;
- error association;
- summary and field relationship;
- invalid state;
- recovery instructions;
- focus after validation;
- live-region behavior;
- status announcement;
- loading indication;
- pending action;
- duplicate-action prevention;
- completion indication;
- empty state;
- unavailable state;
- stale state;
- dynamically inserted content;
- content removal;
- preserved user input;
- no misleading success.

Automated proof may verify markup and DOM updates.

Browser and manual proof may be required to verify timing, announcement quality, focus, visual hierarchy, and interaction clarity.

Do not rely on color alone to communicate state when the governing accessibility Contract prohibits it.

## 13. Contrast, Zoom, Reflow, And Forced-Color Testing

Verify accepted requirements for applicable:

- text contrast;
- non-text contrast;
- focus indicator contrast;
- disabled-state treatment;
- hover or selected state;
- high-contrast or forced-color mode;
- browser zoom;
- text resizing;
- reflow;
- content clipping;
- horizontal scrolling;
- fixed-position obstruction;
- overlay behavior;
- pointer target visibility.

Token validation may prove approved source values.

Rendered contrast may still require browser measurement or review because composition, transparency, imagery, and state can affect the result.

Declare:

- browser;
- operating system;
- viewport;
- zoom;
- theme;
- color mode;
- forced-color mode;
- content state.

Do not infer full responsive or accessibility compliance from one screenshot.

## 14. Browser, Viewport, Input, And Responsive Testing

### 14.1. Supported matrix authority

The proof must cite the supported matrix owner.

Applicable dimensions include:

- browser engine and version;
- operating system;
- viewport;
- orientation;
- pixel density where material;
- zoom;
- pointer;
- touch;
- keyboard;
- assistive technology;
- theme;
- forced colors;
- reduced motion.

Testing does not expand the supported matrix.

### 14.2. Responsive proof declaration

Declare:

- target surface;
- content state;
- viewport or breakpoint;
- orientation;
- expected composition;
- overflow behavior;
- reflow behavior;
- hidden or moved content;
- interaction changes;
- comparison baseline;
- reviewer where required.

Verify applicable:

- Layout;
- Frame;
- navigation;
- table or data presentation;
- forms;
- dialogs;
- menus;
- long content;
- localization expansion;
- empty and error states;
- zoom and reflow.

Breakpoint values and responsive composition come from canonical UI owners.

### 14.3. Pointer, touch, and keyboard input

Verify applicable:

- activation;
- target size;
- hover-independent access;
- touch behavior;
- pointer cancellation;
- drag behavior;
- keyboard equivalent;
- no gesture-only requirement;
- orientation independence;
- focus after pointer interaction.

A desktop pointer test does not prove touch behavior.

### 14.4. Browser-proof limits

One browser run does not prove:

- full browser compatibility;
- screen-reader compatibility;
- all responsive states;
- visual approval;
- motion quality;
- production performance.

Report exactly which matrix entries ran.

## 15. Motion And Reduced-Motion Testing

Verify accepted:

- motion purpose;
- duration token;
- easing token;
- delay;
- entry state;
- exit state;
- interruption;
- cancellation;
- reinitialization;
- stable final state;
- reduced-motion alternative;
- no required information conveyed only through motion;
- no motion that prevents interaction;
- no duplicate animation;
- acceptable performance in the declared environment.

Static checks may prove approved token use.

Browser proof may establish:

- animation starts;
- state changes;
- interruption works;
- reduced-motion media condition changes behavior;
- final state is correct.

Human review is required when acceptance depends on whether motion is:

- understandable;
- restrained;
- comfortable;
- appropriately paced;
- visually coherent.

Testing does not choose motion values or invent a reduced-motion design.

## 16. Visual And Interaction Review

### 16.1. Required manual review

Manual visual or interaction review is normally required for changes affecting:

- spacing;
- Layout;
- hierarchy;
- color use;
- visual emphasis;
- typography;
- responsive composition;
- interaction feel;
- motion;
- loading;
- empty state;
- error state;
- destructive state;
- cross-Component composition;
- new or materially changed rendered-evidence examples.

A passing build, rendering test, browser test, screenshot comparison, or accessibility scan does not replace required manual review.

### 16.2. Review declaration

Every mandatory review receives a `PF-*` identifier and declares:

- mapped criteria;
- canonical UI Contract;
- source revision;
- route or reference Page;
- actor;
- content state;
- UI states;
- browser;
- viewport;
- theme;
- motion preference;
- expected result;
- review procedure;
- evidence;
- reviewer;
- stage.

### 16.3. Reviewer authority

The accepted work packet or canonical UI owner identifies review authority.

Applicable reviewers may include:

- repository owner;
- delegated UI reviewer;
- accessibility specialist;
- Product owner;
- interaction reviewer.

The implementing Codex session may not record itself as repository-owner, design-authority, or accessibility-specialist approval.

Agent-generated review findings remain proposals until the accepted reviewer records the result.

### 16.4. Review result

Record:

- applicability;
- execution status;
- verification result;
- expected design;
- actual result;
- accepted conditions;
- unresolved findings;
- screenshots or recording;
- limitations;
- reviewer identity;
- date.

Reviewer unavailability before review begins is `BLOCKED`.

Completed review that does not satisfy the declared criteria is `EXECUTED + FAIL`.

## 17. Visual Regression, Snapshots, And Screenshots

### 17.1. Visual-regression baseline

A visual-regression baseline must identify:

- `PF-*` proof;
- `AC-*` criteria;
- exact source revision;
- browser and version;
- operating system;
- viewport;
- pixel density where material;
- theme;
- motion state;
- route;
- actor;
- data and content state;
- UI state;
- screenshot identity;
- approved baseline hash;
- reviewer;
- permitted variation;
- update authority.

Visual-regression baselines are protected verification evidence.

### 17.2. Baseline revision

Do not automatically update a baseline because a screenshot differs.

A material baseline change requires:

1. identified difference;
2. explanation of the accepted UI change;
3. affected criteria and proof;
4. preservation of prior baseline;
5. reviewer assessment;
6. accepted verification-contract revision where proof meaning changes;
7. new baseline identity and hash.

The implementation session may propose a baseline update. It may not approve its own design-sensitive baseline revision without delegated authority.

Masking, threshold adjustment, or ignored regions must not hide real UI changes.

### 17.3. DOM and rendered-output snapshots

Use snapshots only when output is:

- stable;
- meaningful;
- reviewable;
- bounded;
- not dominated by irrelevant generated values.

Snapshots should supplement focused assertions.

Avoid broad snapshots that make meaningful changes difficult to review.

A snapshot change requires inspection. It must not be accepted through unconditional regeneration.

### 17.4. Screenshot limits

A screenshot proves appearance only for the declared:

- environment;
- browser;
- viewport;
- state;
- data;
- theme;
- moment.

A screenshot does not by itself prove:

- semantic HTML;
- accessible name;
- keyboard behavior;
- screen-reader behavior;
- browser compatibility;
- responsive behavior outside that viewport;
- correct interaction;
- final design acceptance.

## 18. Reference And Rendered-Evidence Surfaces

Reference and rendered-evidence surfaces should prove the installed UI Contract through accepted examples.

Verify applicable:

- canonical route;
- Contract identity;
- source trace;
- implemented API only;
- states;
- variants;
- content;
- accessibility examples;
- responsive examples;
- prohibited or deferred capabilities represented accurately;
- no fake controls;
- no placeholder API;
- reference-to-source and reference-to-test links.

A rendered-evidence surface is proof support. It does not become the public API when it contradicts the canonical UI Contract.

A reference surface must not:

- invent a Blade API;
- present external-system variants as installed;
- show deferred features as interactive;
- transfer feature business behavior into UI ownership;
- silently approve its own visual result.

## 19. UI Evidence And Reporting

Material UI proof should retain applicable:

- proof ID;
- criterion IDs;
- UI Contract;
- source revision;
- target surface;
- route;
- actor;
- content and data state;
- UI state;
- browser;
- operating system;
- viewport;
- input method;
- assistive technology;
- theme;
- motion preference;
- zoom or forced-color setting;
- command or procedure;
- execution status;
- result;
- automated report;
- screenshot;
- browser trace;
- video;
- DOM snapshot;
- visual baseline hash;
- reviewer;
- limitations;
- cleanup.

Evidence must distinguish:

- machine-checked result;
- visual-regression difference;
- manual observation;
- specialist acceptance;
- unresolved finding.

Do not use one “UI passed” statement when only one assurance layer ran.

## 20. Failure Classification

Use the accepted verification-state model.

### `BLOCKED`

Use when a known prerequisite prevents execution from beginning.

Examples:

- canonical UI Contract is unresolved;
- browser environment is unavailable;
- required reference surface does not exist;
- supported matrix is unresolved;
- required assistive technology is unavailable;
- required reviewer is unavailable.

### `EXECUTED + FAIL`

Use when execution begins and:

- Contract validation fails;
- rendering fails;
- target state does not render;
- browser initialization fails;
- expected focus does not occur;
- accessibility scan fails;
- required interaction fails;
- screenshot differs without accepted explanation;
- manual review rejects the result;
- evidence capture fails;
- cleanup compromises evidence;
- environment differs materially from the declaration.

Do not classify as `EXPECTED_NONPASS`:

- browser-driver failure;
- application boot failure;
- missing asset;
- invalid fixture;
- broken test discovery;
- unavailable reviewer;
- screenshot-tool failure;
- unresolved design;
- missing Contract;
- unsupported environment.

A valid preimplementation proof may use `EXPECTED_NONPASS` only for the exact declared missing UI behavior after the proof executes correctly.

## 21. Prohibited Patterns

Do not:

- let this standard define a Component or Pattern API;
- invent properties, variants, states, or semantic values in tests;
- treat a browser runner as visual approval;
- treat an accessibility scanner as complete conformance proof;
- use a screenshot as the only semantic or accessibility proof;
- assert private DOM structure consumers do not depend on;
- use server-rendered markup proof for real focus or JavaScript behavior;
- call private JavaScript methods instead of performing accepted user interaction;
- use direct `.focus()` as the sole focus proof;
- hide a visual difference through automatic baseline replacement;
- weaken screenshot thresholds merely to pass;
- use broad snapshots instead of focused assertions;
- treat generated usage observations as reviewed truth;
- rely on fragile regular expressions as the sole parser for structured Blade usage;
- let UI visibility replace backend authorization;
- expand the supported browser or assistive-technology matrix through testing;
- infer responsive behavior from one viewport;
- infer touch behavior from pointer testing;
- approve design-sensitive work through Codex self-review;
- label an unexecuted manual review `PASS`;
- convert browser, fixture, environment, tooling, or review-availability failure to `EXPECTED_NONPASS`;
- retain credentials, cookies, authorization headers, private data, or secrets in browser evidence.

## 22. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [UI Standards Index](../ui/index.md)
- [UI API Registry](../ui/api-registry.md)
- [Component Implementation Checklist](../ui/components/checklist.md)
- [Pattern Implementation Checklist](../ui/patterns/checklist.md)
- [Workspace Navigation And Frame Composition](../../03-architecture/workspace-navigation-and-frame-composition.md)
