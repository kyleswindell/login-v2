<!--
DOC-META
title: Accessibility Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/ui-and-accessibility/accessibility-testing-standards.md
parent: docs/02-standards/testing/ui-and-accessibility/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines accessibility verification rules for automated checks, semantic assertions, keyboard and focus, assistive technology, dynamic content, contrast and reflow, reduced motion, and specialist review.
-->

# Accessibility Testing Standards

Parent: [UI And Accessibility Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Accessibility Requirement Authority](#2-accessibility-requirement-authority)
- [3. Automated Accessibility Checks](#3-automated-accessibility-checks)
- [4. Semantic Assertions](#4-semantic-assertions)
- [5. Keyboard And Focus Testing](#5-keyboard-and-focus-testing)
- [6. Screen Reader And Assistive Technology](#6-screen-reader-and-assistive-technology)
- [7. Error, Status, Loading, And Dynamic Content](#7-error-status-loading-and-dynamic-content)
- [8. Contrast, Zoom, Reflow, And Forced Colors](#8-contrast-zoom-reflow-and-forced-colors)
- [9. Reduced Motion And Accessibility](#9-reduced-motion-and-accessibility)
- [10. Manual And Specialist Review](#10-manual-and-specialist-review)
- [11. Evidence And Reporting](#11-evidence-and-reporting)
- [12. Prohibited Patterns](#12-prohibited-patterns)
- [13. Related](#13-related)

## 1. Purpose And Authority

Define how accepted accessibility requirements are verified through automation, semantic assertions, real-browser interaction, assistive-technology evaluation, and named human review.

No single tool or proof layer establishes complete accessibility conformance.

This standard does not select the accessibility conformance target, WCAG version/level, keyboard Contract, assistive-technology matrix, browser matrix, visual design, or final accessibility authority. Those requirements remain with their canonical owners.

## 2. Accessibility Requirement Authority

Every material accessibility proof must cite the applicable authority for the condition being tested, such as:

- conformance target;
- native semantic requirement;
- accessible name/description;
- keyboard interaction;
- focus behavior;
- error/status behavior;
- contrast;
- zoom/reflow;
- motion/reduced motion;
- assistive-technology combination;
- manual/specialist review.

When an accepted target is missing, testing may report findings but must not infer final conformance from a tool's default ruleset.

## 3. Automated Accessibility Checks

Automated tools may prove machine-detectable conditions such as:

- missing accessible names;
- duplicate IDs;
- invalid ARIA or relationships;
- missing form labels;
- certain landmark/heading failures;
- certain contrast failures;
- prohibited focusable/hidden states.

Record tool/version/ruleset, browser or rendered surface, relevant exclusions, findings, and limitations.

Zero automated violations is not final accessibility approval or proof of complete WCAG conformance.

## 4. Semantic Assertions

Use focused assertions where they express the accepted behavior more reliably than broad scans.

Verify applicable:

- native semantic element/role;
- accessible name and description;
- label association;
- state/value/current/selected/expanded/invalid semantics;
- help/error/status relationships;
- live-region or announcement wiring;
- focus target;
- reduced-motion state.

Semantic assertions should complement—not be replaced by—broad automated scanning.

## 5. Keyboard And Focus Testing

Exact interaction comes from the governing Component, Pattern, or accessibility Contract.

Verify applicable keyboard operations, including Tab/Shift+Tab, Enter, Space, Escape, arrows, Home/End, Page Up/Down, type-ahead, accepted shortcuts, cancellation, and absence of pointer-only requirements.

Verify applicable focus behavior:

- logical order and visible focus;
- no hidden focusable content or keyboard trap;
- focus not obscured;
- correct handling of disabled items;
- opening/closing focus movement;
- restoration to a valid origin;
- focus after route change, validation error, dynamic insertion/removal, completion, or cancellation;
- accepted composite-widget behavior such as roving tab index or active descendant.

The UI Contract must identify the applicable composite-widget model. Do not import keyboard behavior from an unrelated pattern.

Use real-browser user interaction for focus proof. Directly calling `.focus()` alone does not establish the accepted user workflow.

## 6. Screen Reader And Assistive Technology

When required, declare:

- assistive technology/version;
- browser/OS;
- route/surface and UI state;
- task/navigation method;
- expected and actual announcement/interpretation;
- reviewer;
- limitations.

Verify applicable name, role, value, state, description, group context, table/form structure, instructions, error/status announcements, dynamic updates, dialog context, reading order, and hidden-content behavior.

One AT/browser/OS combination proves only that declared combination unless the accessibility plan accepts a representative matrix strategy.

## 7. Error, Status, Loading, And Dynamic Content

Verify applicable:

- error identification and field/summary association;
- invalid state and recovery instruction;
- focus after validation;
- status/live-region announcement;
- loading and pending state;
- duplicate-action prevention where required;
- completion indication;
- empty/unavailable/stale state;
- dynamic insertion/removal;
- preserved user input;
- no misleading success.

Automation may prove DOM/markup changes. Browser or human review may still be required for announcement timing, focus, clarity, and hierarchy.

## 8. Contrast, Zoom, Reflow, And Forced Colors

Verify the accepted requirements for applicable text/non-text/focus contrast, browser zoom, text resizing, reflow, clipping, horizontal scrolling, fixed obstruction, overlay behavior, and forced-color/high-contrast modes.

Declare the environment conditions material to the proof, including browser/OS, viewport, zoom, theme/color mode, forced-color mode, and content state.

Token validation can prove approved source values but may not prove rendered contrast because composition, transparency, imagery, and state can change the effective result.

Do not infer responsive or accessibility compliance from one screenshot.

## 9. Reduced Motion And Accessibility

Verify accepted reduced-motion requirements, including applicable:

- user preference changes behavior;
- nonessential animation is removed or reduced as required;
- interaction remains understandable and complete;
- stable final state is preserved;
- required information is not conveyed only through motion;
- reduced-motion behavior does not prevent interaction.

Testing does not invent a reduced-motion design or choose motion values.

Visual/motion quality review outside the accessibility requirement belongs to [Visual, Responsive, And Specialist Review Standards](visual-responsive-and-specialist-review-standards.md).

## 10. Manual And Specialist Review

Manual or specialist review may be mandatory for:

- screen-reader interpretation;
- keyboard workflow/focus logic;
- cognitive clarity and error recovery;
- zoom/reflow/forced colors;
- complex widgets;
- dynamic content;
- responsive composition;
- motion accessibility;
- content order.

Each mandatory review is a declared proof with named authority, procedure, environment, expected conditions, and recorded result.

The implementing agent may prepare the review surface and evidence. It cannot record its own required specialist or repository-owner approval unless that authority was explicitly delegated.

## 11. Evidence And Reporting

Accessibility evidence must distinguish automated findings, browser assertions, assistive-technology observations, and specialist acceptance. Record only the matrix entries actually executed and preserve limitations.

Detailed artifact format/retention follow [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 12. Prohibited Patterns

Do not:

- let testing select the accessibility target;
- treat zero scanner violations as complete conformance;
- use screenshots as the only semantic/accessibility proof;
- impose an unrelated keyboard model;
- treat direct `.focus()` as complete focus proof;
- generalize one AT combination to the entire matrix without authority;
- infer rendered contrast solely from token values;
- let the implementation agent self-approve required specialist review;
- classify missing reviewer/tool/environment as a passing result.

## 13. Related

- [UI And Accessibility Testing Standards Index](index.md)
- [UI Contract And Interaction Testing Standards](ui-contract-and-interaction-testing-standards.md)
- [Visual, Responsive, And Specialist Review Standards](visual-responsive-and-specialist-review-standards.md)
- [UI Standards Index](../../ui/index.md)
- [Browser Test Implementation Standards](../../coding/test-implementation/browser-test-implementation-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
