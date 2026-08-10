<!--
DOC-META
title: Visual, Responsive, And Specialist Review Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/ui-and-accessibility/visual-responsive-and-specialist-review-standards.md
parent: docs/02-standards/testing/ui-and-accessibility/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines verification rules for browser and viewport matrices, responsive composition, input modes, motion quality, manual visual review, visual regression, screenshots, snapshots, and rendered-evidence surfaces.
-->

# Visual, Responsive, And Specialist Review Standards

Parent: [UI And Accessibility Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Supported Browser, Viewport, And Input Matrix](#2-supported-browser-viewport-and-input-matrix)
- [3. Responsive Proof](#3-responsive-proof)
- [4. Pointer, Touch, And Input Modes](#4-pointer-touch-and-input-modes)
- [5. Motion And Visual Quality](#5-motion-and-visual-quality)
- [6. Manual Visual And Interaction Review](#6-manual-visual-and-interaction-review)
- [7. Visual Regression, Snapshots, And Screenshots](#7-visual-regression-snapshots-and-screenshots)
- [8. Reference And Rendered-Evidence Surfaces](#8-reference-and-rendered-evidence-surfaces)
- [9. Evidence And Reporting](#9-evidence-and-reporting)
- [10. Prohibited Patterns](#10-prohibited-patterns)
- [11. Related](#11-related)

## 1. Purpose And Authority

Define how accepted responsive, visual, motion, and design-sensitive UI requirements are verified across declared browser/viewport/input combinations and through protected visual evidence or named human review.

This standard does not define the supported browser matrix, breakpoints, Layout/Frame composition, visual hierarchy, tokens, motion design, responsive behavior, Product behavior, or final design approval. Those remain with their canonical UI, architecture, feature, or repository-owner authorities.

Automation detects and demonstrates conditions. It does not grant final visual or interaction approval.

## 2. Supported Browser, Viewport, And Input Matrix

Every material matrix proof cites the owner of the supported combinations.

Applicable dimensions include:

- browser engine/version;
- operating system;
- viewport/orientation;
- pixel density when material;
- zoom;
- pointer/touch/keyboard input;
- theme/color mode;
- forced colors;
- reduced motion;
- assistive technology when accessibility proof is also involved.

Declare selected combinations, exclusions, rationale, and limitations.

One browser or viewport proves only that combination unless an accepted representative strategy says otherwise. Testing must not expand the supported matrix merely because another combination happens to pass.

## 3. Responsive Proof

Declare target surface/content state, viewport or responsive boundary, orientation, expected composition, overflow/reflow behavior, hidden or moved content, interaction changes, and reviewer when required.

Verify applicable:

- Layout and Frame composition;
- navigation;
- tables/data presentation;
- forms/dialogs/menus;
- long or localized content;
- empty/error/loading states;
- zoom/reflow behavior;
- preservation of access to required controls and information.

Breakpoint values and responsive composition come from canonical UI owners.

Responsive proof should cover meaningful behavior boundaries rather than arbitrary screenshots at every width.

## 4. Pointer, Touch, And Input Modes

Where input modality is material, verify applicable:

- activation and target size;
- hover-independent access;
- touch behavior;
- pointer cancellation;
- drag/resize behavior;
- keyboard equivalent when required;
- absence of gesture-only dependency;
- orientation independence;
- focus/state after pointer interaction.

A desktop pointer run does not prove touch behavior. A touch run does not replace required keyboard accessibility proof.

## 5. Motion And Visual Quality

Browser automation may verify accepted mechanical behavior such as animation start/end, state transition, interruption/cancellation, reinitialization, reduced-motion switching, and stable final state.

Human review is required when acceptance depends on whether motion or transition behavior is understandable, restrained, comfortable, appropriately paced, visually coherent, or consistent with the accepted design.

Testing does not choose duration, easing, delay, visual treatment, or reduced-motion design. Accessibility-specific reduced-motion requirements are governed by [Accessibility Testing Standards](accessibility-testing-standards.md).

## 6. Manual Visual And Interaction Review

Manual visual/interaction review is normally required when accepted criteria concern:

- spacing or Layout;
- hierarchy/emphasis;
- color or typography;
- responsive composition;
- interaction feel;
- motion quality;
- loading/empty/error/destructive states;
- cross-Component composition;
- new or materially changed rendered-evidence examples.

A passing build, server-rendered test, browser interaction test, screenshot comparison, or accessibility scan does not replace required human review.

Each mandatory review declares:

- proof/criterion IDs;
- canonical design/UI Contract;
- source revision;
- route/reference surface;
- actor/content/UI states;
- browser/viewport/theme/motion condition;
- review procedure and expected result;
- reviewer authority;
- evidence;
- stage.

Reviewer unavailability before review starts is not approval. A completed review that does not satisfy the declared conditions is a failed proof according to the shared state/result standard.

The implementing agent may prepare review evidence but may not record itself as repository-owner, design-authority, or accessibility-specialist approval without explicit delegated authority.

## 7. Visual Regression, Snapshots, And Screenshots

### Visual regression

A protected visual baseline identifies the proof/criteria, source revision, browser/OS/viewport, pixel density when material, theme/motion state, route, actor/data/UI state, baseline identity/hash, reviewer, permitted variation, and update authority.

Visual regression detects change; it does not determine whether the change is correct.

Do not automatically update a baseline because a screenshot differs. A material baseline change requires review of the difference, accepted UI change authority, preservation of the prior baseline, and verification-contract revision where proof meaning changes.

Do not hide real changes through unjustified masking, ignored regions, or threshold expansion.

### DOM/rendered-output snapshots

Use snapshots only when the output is stable, bounded, meaningful, and reviewable. They should supplement focused assertions rather than replace them. Snapshot changes require inspection and must not be accepted through unconditional regeneration.

### Screenshot limits

A screenshot proves appearance only for its declared environment/browser/viewport/state/data/theme/moment. It does not by itself prove semantic HTML, accessible name, keyboard or screen-reader behavior, browser compatibility, responsive behavior outside that viewport, correct interaction, or final design acceptance.

## 8. Reference And Rendered-Evidence Surfaces

Reference/rendered-evidence surfaces may support proof of installed UI Contracts through accepted examples.

Verify applicable canonical route/Contract identity/source trace, implemented API only, representative states/variants/content/accessibility/responsive examples, and accurate treatment of prohibited or deferred capability.

A rendered-evidence surface is proof support. It must not:

- invent a public API;
- present external-system variants as installed;
- show deferred features as active;
- transfer feature business behavior into UI ownership;
- approve its own visual result.

## 9. Evidence And Reporting

Material visual/responsive evidence records the exact matrix entry, route/state/content, source revision, command/procedure, screenshots or visual report, reviewer when applicable, and limitations.

Detailed artifact/retention requirements follow [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 10. Prohibited Patterns

Do not:

- let testing define breakpoints, design, motion, or supported matrix;
- infer full responsive behavior from one viewport;
- infer touch behavior from desktop pointer testing;
- treat browser automation as final visual approval;
- auto-approve or auto-regenerate visual baselines;
- weaken visual thresholds merely to pass;
- use broad snapshots instead of focused assertions;
- let the implementation agent self-approve required design review;
- use rendered-evidence examples to invent UI API;
- retain sensitive data in visual evidence.

## 11. Related

- [UI And Accessibility Testing Standards Index](index.md)
- [UI Contract And Interaction Testing Standards](ui-contract-and-interaction-testing-standards.md)
- [Accessibility Testing Standards](accessibility-testing-standards.md)
- [UI Standards Index](../../ui/index.md)
- [Browser Test Implementation Standards](../../coding/test-implementation/browser-test-implementation-standards.md)
- [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Workspace Navigation And Frame Composition](../../../03-architecture/workspace-navigation-and-frame-composition.md)
