<!--
DOC-META
title: UI And Accessibility Testing Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/ui-and-accessibility/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes UI Contract, semantic, browser interaction, accessibility, responsive, visual-regression, and specialist-review testing standards.
-->

# UI And Accessibility Testing Standards Index

Parent: [Testing Standards Index](../index.md)

## 1. Purpose

Route proof for reusable UI, owner-specific Product presentation, Frame rendering, accessibility, real-browser interaction, responsive behavior, visual change, and human UI review.

## 2. Scope

This family owns testing methods and evidence expectations for public UI Contract validation, rendered semantic conformance, real-browser interaction, repository-wide UI usage, accessibility verification, responsive/input/browser coverage, visual regression, and specialist review.

It does not define UI public APIs, visual design, accessibility targets, keyboard Contracts, supported browser matrices, breakpoints, motion design, Product behavior, or final approval authority.

## 3. Assurance Model

UI assurance may combine public Contract validation, rendered semantic conformance, real-browser interaction, repository-wide usage conformance, accessibility verification, visual/regression proof, and manual/specialist review. No one layer proves every UI quality.

## 4. Standards

| Standard | Owns |
| --- | --- |
| [UI Contract And Interaction Testing Standards](ui-contract-and-interaction-testing-standards.md) | UI Contract validation, rendered semantics, real-browser interaction, repository-wide usage conformance, and semantic action/navigation/state proof |
| [Accessibility Testing Standards](accessibility-testing-standards.md) | Accessibility requirement routing, automated checks, semantic assertions, keyboard/focus, assistive technology, dynamic content, contrast/reflow, and reduced-motion accessibility |
| [Visual, Responsive, And Specialist Review Standards](visual-responsive-and-specialist-review-standards.md) | Supported browser/viewport/input matrices, responsive composition, visual/motion review, visual regression, screenshots/snapshots, and rendered-evidence review |

## 5. Authority Boundaries

- UI public APIs/design-system behavior remain with `docs/02-standards/ui/`.
- Product/Page behavior remains with the feature owner.
- Browser test source: [Browser Test Implementation Standards](../../coding/test-implementation/browser-test-implementation-standards.md).
- Proof-state semantics: [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).
- Evidence artifacts: [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).
- Final design/accessibility approval remains with named human authority.

## 6. Related

- [Testing Standards Index](../index.md)
- [UI Standards Index](../../ui/index.md)
- [Test Implementation Standards Index](../../coding/test-implementation/index.md)
- [Workspace Navigation And Frame Composition](../../../03-architecture/workspace-navigation-and-frame-composition.md)
