---
title: Carbon Source Notes
slug: carbon-source-notes
status: support-reference
api_layer: Support documentation
canonical_doc: docs/02-standards/ui/carbon-source-notes.md
related_element_index: docs/02-standards/ui/elements/index.md
related_component_index: docs/02-standards/ui/components/index.md
related_pattern_index: docs/02-standards/ui/patterns/index.md
source_reference: https://carbondesignsystem.com/
---

# Carbon Source Notes
- [1. Purpose](#1-purpose)
- [2. What Carbon is](#2-what-carbon-is)
- [3. What purpose Carbon serves in Login App](#3-what-purpose-carbon-serves-in-login-app)
- [4. Relationship to Login App UI standards](#4-relationship-to-login-app-ui-standards)
- [5. How to use Carbon during standards work](#5-how-to-use-carbon-during-standards-work)
- [6. How to find general Carbon information](#6-how-to-find-general-carbon-information)
- [7. What Carbon is trying to achieve](#7-what-carbon-is-trying-to-achieve)
- [8. App-specific guardrails](#8-app-specific-guardrails)
- [9. Appropriate use cases for this note](#9-appropriate-use-cases-for-this-note)
- [10. Maintenance expectations](#10-maintenance-expectations)
- [11. Related Login App standards](#11-related-login-app-standards)
- [12. References](#12-references)

## 1. Purpose

This document explains how Login App 2.0 uses Carbon Design System as third-party reference material when maintaining the internal UI Reference Library.

Carbon is not the canonical source of truth for Login App implementation. Canonical app rules live in the Login App standards under:

- `docs/02-standards/ui/elements/`
- `docs/02-standards/ui/components/`
- `docs/02-standards/ui/patterns/`

Use Carbon to understand mature design-system theory, interaction expectations, accessibility considerations, and completeness checks. Do not use Carbon as a direct implementation dependency unless a Login App standard explicitly approves that decision.

## 2. What Carbon is

Carbon Design System is IBM’s open-source design system for products and digital experiences. It is built on the IBM Design Language and includes design guidance, coded components, foundational elements, patterns, tools, and community-maintained resources.

Carbon is useful to Login App because it shows how a mature product design system defines reusable UI concepts at multiple levels:

- foundations and elements such as color, spacing, typography, icons, motion, pictograms, themes, and grid behavior;
- components such as controls, feedback, data display, navigation, overlays, and form inputs;
- patterns that combine components into reusable user-goal workflows;
- accessibility expectations and interaction models;
- implementation guidance, examples, and migration notes.

Carbon is broad because it serves IBM products. Login App is narrower and app-owned. The value of Carbon is not that Login App copies it; the value is that it provides a mature external benchmark for deciding whether Login App standards are complete enough.

## 3. What purpose Carbon serves in Login App

Carbon serves as a reference benchmark for Login App UI standards. It helps answer questions such as:

- Has the Login App standard considered the correct interaction states?
- Does the standard distinguish components, elements, and patterns clearly?
- Are keyboard, focus, reduced-motion, and screen-reader expectations covered?
- Does the standard explain when to use a UI type and when not to use it?
- Does the standard separate visual tokens from component behavior and pattern orchestration?
- Does the UI Reference page prove live behavior instead of showing abstract notes?

Carbon does not decide Login App API names, Blade components, CSS classes, source files, routes, token values, icon libraries, status labels, content language, or feature behavior. Those decisions belong to Login App standards.

## 4. Relationship to Login App UI standards

Login App standards translate Carbon-informed concepts into the app’s own implementation model.

| Carbon role              | Login App interpretation                                                                              |
| ------------------------ | ----------------------------------------------------------------------------------------------------- |
| Foundations and elements | Benchmark for Login App Foundation Element APIs.                                                      |
| Components               | Benchmark for Login App Component API completeness, states, accessibility, and usage boundaries.      |
| Patterns                 | Benchmark for reusable compositions and user-goal flows built from app-owned Components and Elements. |
| Code examples            | Reference only; Login App keeps its own Blade, CSS, JavaScript, and route model.                      |
| Accessibility guidance   | Benchmark for app-specific accessibility contracts and UI Reference proof.                            |
| Visual style             | Reference only; Login App keeps its own visual system and tokens.                                     |

When Carbon and Login App differ, the Login App standard wins. Differences are acceptable when they are intentional, documented, and supported by the app’s current implementation.

## 5. How to use Carbon during standards work

Use Carbon at the beginning of a standards update to understand the shape of the UI problem, then return to Login App standards to define the actual API.

Recommended workflow:

1. Start with the relevant Login App standard and route.
2. Review Carbon’s overview, usage, style, accessibility, and code pages when available.
3. Identify the interaction model, state model, accessibility requirements, and usage boundaries Carbon treats as important.
4. Translate only the relevant concepts into Login App language.
5. Mark unsupported Carbon-only capabilities as deferred, gated, not implemented, not applicable, or app-approved exceptions.
6. Keep Login App API surfaces app-owned: `x-ui.*`, `ui-*`, Laravel/Blade source files, app routes, and app tests.
7. Require UI Reference proof for the final app standard.

Do not copy Carbon text, class names, token values, React APIs, pictogram assets, icon assets, feature-flag behavior, or component visuals directly into Login App.

## 6. How to find general Carbon information

Use Carbon’s top-level site navigation before jumping to a specific component page.

Good starting points:

- Carbon home: `https://carbondesignsystem.com/`
- What is Carbon: `https://carbondesignsystem.com/all-about-carbon/what-is-carbon/`
- Carbon ecosystem: `https://carbondesignsystem.com/all-about-carbon/the-carbon-ecosystem/`
- Designing get started: `https://carbondesignsystem.com/designing/get-started/`
- Developing get started: `https://carbondesignsystem.com/developing/get-started/`
- Components overview: `https://carbondesignsystem.com/components/overview/components/`
- Patterns overview: `https://carbondesignsystem.com/patterns/overview/`
- Elements and foundations sections: use the site navigation under Carbon’s element pages, such as color, typography, icons, motion, grid, themes, and pictograms.
- Accessibility status and component accessibility pages: use when checking whether a component’s keyboard, screen-reader, focus, or state behavior is sufficiently documented.
- Carbon for AI: use only when a Login App AI-related UI standard is explicitly being defined.

The most useful Carbon pages are usually not just the code pages. For standards writing, prioritize usage, accessibility, style, overview, and pattern guidance because those pages explain purpose, boundaries, states, and behavior.

## 7. What Carbon is trying to achieve

Carbon attempts to create consistency across large product ecosystems by defining shared foundations, reusable components, tested patterns, content guidance, coded implementations, and accessibility expectations.

Its broader goals are useful to Login App because they mirror what an internal UI Reference Library should do at smaller scale:

- make recurring UI decisions explicit;
- reduce one-off local markup and styling;
- create shared language for designers and developers;
- make accessibility part of the component and pattern contract;
- separate primitive tokens, component APIs, and pattern orchestration;
- provide live examples that prove the standards;
- make future UI work easier to review and maintain.

Login App applies those goals through its own Element, Component, and Pattern API standards.

## 8. App-specific guardrails

Use these rules whenever Carbon is consulted:

- Login App canonical docs override Carbon.
- Carbon is a benchmark, not an implementation dependency.
- Login App keeps its own `ui-*` classes and `x-ui.*` Blade APIs.
- Login App keeps its own route model under `/platform/ui-reference`.
- Login App keeps its own Foundation Element tokens and theme behavior.
- Login App does not adopt Carbon production classes such as `cds--*` or `bx--*`.
- Login App does not adopt Carbon React/Web Component APIs without a separate implementation decision.
- Login App does not import Carbon icons, pictograms, typefaces, visual assets, feature flags, or AI styling without an approved app decision.
- Carbon-only features must be marked as deferred, gated, not implemented, not applicable, or app-approved exceptions until Login App explicitly installs them.
- UI Reference examples must prove Login App behavior with app-owned classes, helpers, Blade components, and routes.

## 9. Appropriate use cases for this note

Use this note when:

- starting a new UI standard and deciding how Carbon should inform it;
- auditing whether an existing standard over-copied Carbon;
- deciding whether a Carbon capability is installed, gated, deferred, or not applicable in Login App;
- reviewing why the UI Reference Library uses Element, Component, and Pattern layers;
- onboarding a developer to how third-party design-system guidance should influence app standards.

Do not use this note as:

- a component inventory;
- a replacement for canonical Login App standards;
- a migration checklist;
- a list of all Carbon pages;
- proof that Login App implements a Carbon component or pattern;
- permission to copy Carbon classes, code, assets, or token values.

## 10. Maintenance expectations

This document should stay high-level. Do not expand it into a catalog of every Carbon element, component, or pattern.

When updating this note:

- keep it focused on Carbon’s role as third-party reference material;
- prefer source categories and navigation guidance over exhaustive link lists;
- keep app guardrails explicit;
- remove stale component-specific lists;
- link to canonical Login App standards for implementation decisions;
- update Carbon links only when top-level navigation or terminology changes.

## 11. Related Login App standards

| Standard                           | Path                                                       |
| ---------------------------------- | ---------------------------------------------------------- |
| Foundation Elements Standards      | `docs/02-standards/ui/elements/index.md`                   |
| Component Standards Index          | `docs/02-standards/ui/components/index.md`                 |
| Component Implementation Checklist | `docs/02-standards/ui/components/checklist.md`             |
| Pattern Standards Index            | `docs/02-standards/ui/patterns/index.md`                   |
| Pattern Library Checklist          | `docs/02-standards/ui/patterns/checklist.md`               |
| Boundary and validation Pattern    | `docs/02-standards/ui/patterns/boundary-and-validation.md` |

## 12. References

- Carbon Design System: `https://carbondesignsystem.com/`
- What is Carbon: `https://carbondesignsystem.com/all-about-carbon/what-is-carbon/`
- Carbon ecosystem: `https://carbondesignsystem.com/all-about-carbon/the-carbon-ecosystem/`
- Carbon components overview: `https://carbondesignsystem.com/components/overview/components/`
- Carbon patterns overview: `https://carbondesignsystem.com/patterns/overview/`
- Carbon developing get started: `https://carbondesignsystem.com/developing/get-started/`
- Carbon for AI: `https://carbondesignsystem.com/guidelines/carbon-for-ai/`
