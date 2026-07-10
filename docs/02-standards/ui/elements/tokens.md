---
title: Token Governance
status: Approved API
api_layer: Foundation Element API
owner: UI Standards
---

# Token Governance Element Standard
- [1. Purpose](#1-purpose)
- [2. Ownership Model](#2-ownership-model)
- [3. Color Token Rules](#3-color-token-rules)
- [4. Component Token Rules](#4-component-token-rules)
- [5. Allowed Literals](#5-allowed-literals)
- [6. Testing Rules](#6-testing-rules)
- [7. Related](#7-related)

## 1. Purpose

Token Governance defines how Foundation Element tokens flow into Components and Patterns. It prevents two opposite failures: hard-coded local values and excessive one-off token creation.

Use this standard with the specific Element standards for Color, Themes, Spacing, Typography, Motion, Icons, Pictograms, and 2x Grid.

## 2. Ownership Model

The token pipeline is:

1. Foundation token sources define Carbon-derived raw values.
2. Core Element tokens expose stable UI roles.
3. Approved component token files expose component-owned roles only for Carbon component-token families adopted by Login App.
4. Component CSS consumes core Element tokens unless that component owns an approved component token.
5. Pattern and feature views consume Component APIs, Pattern APIs, and Element roles. They must not define local tokens for lower-layer behavior.

Do not add a token just because a literal appears in CSS. First identify whether the literal is Carbon structural geometry, an accessibility constant, a true Element role, or a component-owned state. Add or promote a token only when the owning standard defines that role.

## 3. Color Token Rules

Carbon core color tokens are the source-of-truth model for app color roles. Login App exposes app-owned CSS variables, but their role coverage must align to Carbon's core token families:

- Background
- Layer
- Layer accent
- Field
- Border
- Text
- Link
- Syntax
- Icon
- Support
- Focus
- Miscellaneous

Component and Pattern CSS must use those core roles for ordinary color behavior. They must not consume primitive palette values such as gray, blue, red, white, or black directly. Primitive palette values belong in token source files, theme files, and documented token examples only.

## 4. Component Token Rules

Only these Carbon component-token families are approved for Login App component color token files:

| Carbon component token family | Login App file |
| --- | --- |
| Button | `resources/css/tokens/components/buttons.css` |
| Content switcher | `resources/css/tokens/components/content-switcher.css` |
| Notification | `resources/css/tokens/components/notifications.css` |
| Tag | `resources/css/tokens/components/tags.css` |

No other component may introduce a component color token file or component-specific color token family without updating this standard, the Color Element standard, the owning Component standard, rendered evidence proof, and token-governance tests in the same pass.

Status, UI shell, modal, table, form, list, loading, and layout surfaces consume core Color, Theme, Spacing, Typography, and Motion roles unless a later approved standard explicitly promotes a Carbon component-token family for that component.

Component tokens are private to their owning component. Do not use Button, Content switcher, Notification, or Tag component tokens outside the owning component source or the Pattern API that composes that exact component.

## 5. Allowed Literals

Allowed literals are structural, not visual-role shortcuts:

- `0`, percentages, transforms, grid/flex mechanics, keyframe percentages, and media query breakpoints.
- Fixed Carbon structural geometry such as icon dimensions, spinner geometry, caret geometry, and control affordance sizing when the owning Component standard documents the geometry.
- Accessibility constants such as `currentColor`, `transparent`, `inherit`, forced-colors keywords, and outline mechanics.
- Raw values inside token source files where the file owns the Foundation value definition.

Raw color values, primitive palette token references, raw type values, raw transition timings, and one-off component variables are not allowed in component CSS unless the owning standard explicitly categorizes the exception.

## 6. Testing Rules

Co-located Element tests must enforce this pipeline:

- Color tests fail on extra component color token files or imports outside Button, Content switcher, Notification, and Tag.
- Color tests fail when component CSS consumes primitive palette tokens directly.
- Token tests fail on raw fallback values in component CSS when the fallback bypasses the owning Element token.
- Spacing, Typography, and Motion tests classify literals by role before allowing them; a passing test means drift is categorized, not that every token issue is fixed.
- Existing drift must be recorded as a narrow failing case or a narrow categorized exception with an owner and reason. Do not add broad allowlists.

## 7. Related

- [Foundation Elements Standards](index.md)
- [Color Element Standard](color.md)
- [Themes Element Standard](themes.md)
- [Spacing Element Standard](spacing.md)
- [Typography Element Standard](typography.md)
- [Motion Element Standard](motion.md)
