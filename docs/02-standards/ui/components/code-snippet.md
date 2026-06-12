---
title: Code snippet
slug: code-snippet
api_layer: Component API
status: implemented-pending-review
system_maturity: implemented
category: developer-documentation
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/code-snippet
canonical_doc: docs/02-standards/ui/components/code-snippet.md
source_owner: /platform/ui-reference/components/code-snippet
blade_api:
  - x-ui.code-snippet
javascript_api:
  - initCodeSnippets
data_attributes:
  - data-ui-component="code-snippet"
  - data-ui-code-snippet
  - data-ui-code-snippet-variant
  - data-ui-code-copy-state
  - data-ui-code-copy-button
  - data-ui-code-show-more
source_files:
  - resources/views/components/ui/code-snippet.blade.php
  - resources/js/ui-controls/code-snippets.js
  - resources/js/ui-controls.js
  - resources/js/app.js
  - resources/css/app.css
  - resources/views/platform/ui-reference/components/live-examples/code-snippet.blade.php
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - button
  - icon-button
  - tooltip
  - notification
  - inline-loading
related_patterns:
  - documentation
  - data-content
carbon_reference:
  - https://carbondesignsystem.com/components/code-snippet/usage/
  - https://carbondesignsystem.com/components/code-snippet/style/
  - https://carbondesignsystem.com/components/code-snippet/accessibility/
---

# Code snippet Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed modes:](#32-installed-modes)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Data attribute contract](#44-data-attribute-contract)
  - [4.5. Syntax token class contract](#45-syntax-token-class-contract)
  - [4.6. CSS class contract](#46-css-class-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Do not use Code snippet when:](#91-do-not-use-code-snippet-when)
  - [9.2. Component selection:](#92-component-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. UI Reference requirements](#14-ui-reference-requirements)
  - [14.1. Required Live examples internal sections:](#141-required-live-examples-internal-sections)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested automated assertions:](#151-suggested-automated-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Code snippet presents exact implementation syntax with app-approved code typography, syntax token color, overflow behavior, and optional copy affordance.

Canonical API owner: `/platform/ui-reference/components/code-snippet`. Use this Component API instead of creating local markup, styling, syntax colors, copy controls, or behavior for the same UI role.

Code snippet is the installed Login App 2.0 developer-documentation primitive for canonical implementation examples inside UI Reference pages and internal standards. It owns code container anatomy, inline/single-line/multi-line disposition, language labels, copy affordance behavior, copy-state presentation, show-more/show-less expansion for multi-line snippets, syntax token classes, code typography, horizontal overflow, token-backed focus and copy states, and code-specific content rules. It does not own prose formatting, API contract tables, long tutorials, live code execution, syntax parsing, full source viewers, or feature-specific examples.

### 1.1. Canonical API responsibilities:

- Render implementation examples through `<x-ui.code-snippet>`.
- Preserve semantic `pre` and `code` structure for block snippets.
- Preserve inline code semantics for inline snippets when that variant is installed.
- Support the installed `single` and `multi` variants.
- Support the installed `inline` variant for short code terms inside prose.
- Support optional language/context labels.
- Support optional copy affordance markup when copying the exact snippet is useful.
- Support visual copy states through `copyState="idle"` and `copyState="copied"`.
- Run copy and show-more behavior through the documented `initCodeSnippets` lifecycle controller.
- Support app-owned syntax token classes for highlighted examples.
- Preserve whitespace, indentation, and line breaks.
- Keep long code readable with horizontal overflow rather than misleading wraps.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove variants, copy states, syntax tokens, overflow behavior, accessibility, and implementation examples on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Developer prose or explanatory paragraphs. Use body copy and documentation patterns.
- API tables, prop matrices, and status tables. Use Markdown/table rendering and Pattern-owned documentation layout.
- Full source file display, code viewers, editors, diffs, or interactive playgrounds. Gate those as separate Components or Patterns.
- Clipboard JavaScript behavior. Gate through this component before production use.
- Toasts or long-form copied/failure feedback. Use Notification or Pattern-owned feedback if needed.
- Loading or pending code examples. Use Loading if content is actually pending.
- Syntax parsing or automatic highlighting. Use explicit token spans or an approved highlighter gate.
- Page-level spacing around examples. Parent documentation Patterns own external spacing and grouping.

Carbon alignment note: Carbon documents inline, single-line, and multi-line code snippet variants, copy affordances, show-more behavior for multi-line snippets, token-backed focus/hover/active states, accessible syntax colors, and text updates for copy/show-more controls. Login App installs those baseline behaviors through its own `x-ui.code-snippet`, `ui-*` namespace, `initCodeSnippets` controller, explicit token classes, and UI Reference proof.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                      |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented Pending Review                                                                                                                                 |
| System maturity              | Implemented                                                                                                                                                |
| API layer                    | Component API                                                                                                                                              |
| Component slug               | code-snippet                                                                                                                                               |
| Category                     | Developer documentation                                                                                                                                    |
| Priority                     | Tier B - Common reusable component                                                                                                                         |
| UI Reference route           | `/platform/ui-reference/components/code-snippet`                                                                                                           |
| Canonical doc                | `docs/02-standards/ui/components/code-snippet.md`                                                                                                          |
| Source owner                 | `/platform/ui-reference/components/code-snippet`                                                                                                           |
| Blade API                    | `x-ui.code-snippet`                                                                                                                                        |
| JavaScript API               | `initCodeSnippets`                                                                                                                                         |
| Data attributes              | `data-ui-component="code-snippet"`, `data-ui-code-snippet-variant`, `data-ui-code-copy-state`                                                              |
| Props/options                | `variant`, `language`, `copyable`, `copyState`, `expandable`, `collapsedLines`, `light`, content slot                                                      |
| Source files                 | `resources/views/components/ui/code-snippet.blade.php`; `resources/js/ui-controls/code-snippets.js`; `resources/css/app.css`; `resources/views/platform/ui-reference/components/live-examples/code-snippet.blade.php` |
| CSS namespace                | `ui-code-snippet*` and `ui-code-token*`                                                                                                                    |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons                                                                                                          |
| Carbon benchmark             | Carbon Code snippet usage, style, and accessibility guidance                                                                                               |

`Implemented Pending Review` means the component has a concrete Blade API, lifecycle-owned copy/show-more behavior, UI Reference proof, and focused tests, and is waiting for manual visual review.

## 3. Installed standard

The installed standard is the `x-ui.code-snippet` Blade Component API.

Use Code snippet when the user needs to read, compare, or copy exact implementation syntax. Code snippets should appear in UI Reference implementation examples, canonical standards, internal developer documentation, and pattern/component proof pages where exact code matters.

### 3.1. Installed production rules:

- Render code snippets through `<x-ui.code-snippet>`.
- Use `variant="single"` for one-line API calls, token names, class names, route names, or commands.
- Use `variant="multi"` for multiline Blade, PHP, JavaScript, CSS, HTML, JSON, or test examples.
- Use `variant="inline"` for short copyable code terms inside body copy.
- Use `language` when the snippet benefits from a visible language or context label.
- Use `copyable` only when copying the exact snippet is useful.
- Use `copyState="idle"` and `copyState="copied"` for initial copy affordance state; live copying updates the state through `initCodeSnippets`.
- Preserve whitespace and line breaks in multi-line examples.
- Use horizontal overflow for long code instead of wrapping into misleading syntax.
- Use explicit syntax token spans only where the UI Reference needs to prove code-token color roles.
- Use token-backed syntax spans for UI Reference live examples that demonstrate implementation code, copy feedback, horizontal overflow, or multi-line syntax.
- Keep code examples real and tied to the current installed API.
- Block snippet shells use one standard card-like border and one layer surface across the language header, code body, and footer controls. Do not add a separate header/footer background band or internal header/footer divider by default.
- Do not show speculative, deferred, or fake API calls as complete production examples.
- Parent Patterns own surrounding explanatory copy, example grouping, external spacing, and page layout.
- Do not use raw `<pre>`, raw `<code>` blocks with local classes, Bootstrap code utilities, direct Carbon classes, raw colors, arbitrary spacing, or feature-local JavaScript to create code snippets.

### 3.2. Installed modes:

| Mode                      | Status                   | Use                                                                                                   |
| ------------------------- | ------------------------ | ----------------------------------------------------------------------------------------------------- |
| Inline snippet            | Implemented              | Short code term or command embedded in prose.                                                         |
| Single-line snippet       | Implemented              | Short API call, class name, route, command, token, or one-line implementation example.                |
| Multi-line snippet        | Implemented              | Longer example that requires indentation, whitespace, or multiple lines.                              |
| Language label            | Implemented              | Visible language/context label in the snippet header.                                                 |
| Copy ready                | Implemented visual state | Copy affordance is rendered in idle state.                                                            |
| Copied                    | Implemented visual state | Copied state is rendered for UI Reference proof or server-rendered state.                             |
| Syntax token highlighting | Implemented              | Explicit `ui-code-token-*` spans provide token-backed syntax color roles.                             |
| Overflow                  | Implemented              | Long examples scroll horizontally without wrapping into incorrect syntax.                             |
| Show more/show less       | Implemented              | Optional multi-line ghost button expands or collapses the snippet.                                    |
| Live clipboard behavior   | Implemented              | Copy buttons and copyable inline snippets write exact snippet text and show copied feedback.          |

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.code-snippet language="Blade" copyable>
    &lt;x-ui.button semantic="primary"&gt;Save changes&lt;/x-ui.button&gt;
</x-ui.code-snippet>
```

```blade
<x-ui.code-snippet variant="single" language="Blade">
    &lt;x-ui.badge status="approved" /&gt;
</x-ui.code-snippet>
```

```blade
<x-ui.code-snippet variant="multi" language="PHP" copyable>
    $response = $this-&gt;actingAs($admin)-&gt;get('/platform/ui-reference/components/button');

    $response-&gt;assertOk();
    $response-&gt;assertSee('x-ui.button');
</x-ui.code-snippet>
```

```blade
<x-ui.code-snippet
    variant="single"
    language="Blade"
    copyable
    copyState="copied"
>
    &lt;x-ui.code-snippet language="Blade" copyable&gt;...&lt;/x-ui.code-snippet&gt;
</x-ui.code-snippet>
```

Use the Blade API instead of hand-building code snippet markup in feature views or UI Reference pages.

### 4.2. API surfaces

| API surface             | Installed value                                                                                                                                            |
| ----------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade API               | `x-ui.code-snippet`                                                                                                                                        |
| JavaScript              | `initCodeSnippets`                                                                                                                                        |
| Root semantic structure | `pre` and `code` for block snippets; inline variant renders inline `code` or copyable button plus `code`                                                   |
| Data attributes         | `data-ui-component="code-snippet"`, `data-ui-code-snippet`, `data-ui-code-snippet-variant`, `data-ui-code-copy-state`, copy/show-more hooks                |
| CSS namespace           | `ui-code-snippet*` and `ui-code-token*`                                                                                                                    |
| Source files            | `resources/views/components/ui/code-snippet.blade.php`; `resources/js/ui-controls/code-snippets.js`; `resources/css/app.css`; `resources/views/platform/ui-reference/components/live-examples/code-snippet.blade.php` |

### 4.3. Props and options

| Prop/option  | Type     | Default      | Allowed values    | Required                                                                                                  | Notes                                                                                                                                 |
| ------------ | -------- | ------------ | ----------------- | --------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| `variant`    | `string` | `single`     | `inline`, `single`, `multi` | No                                                                                               | `inline` embeds short code terms in prose. `single` keeps short calls compact. `multi` preserves line breaks and indentation.         |
| `language`   | `string` | `null`       | `null`            | Short language/context label such as `Blade`, `PHP`, `CSS`, `JavaScript`, `JSON`, `HTML`, `Route`, `Test` | No                                                                                                                                    | Renders the optional header label. Keep labels short and factual.                                             |
| `copyable`   | `bool`   | `false`      | `true`, `false`   | No                                                                                                        | Renders copy behavior when copying the exact snippet is useful.                                                                        |
| `copyState`  | `string` | `idle`       | `idle`, `copied`  | No                                                                                                        | Sets initial copy tooltip/status state; `initCodeSnippets` updates it after copy.                                                     |
| `expandable` | `bool`   | `false`      | `true`, `false`   | No                                                                                                        | Multi-line snippets may expose a Show more/Show less ghost button.                                                                    |
| `collapsedLines` | `int` | `9`          | `2+`              | No                                                                                                        | Sets the collapsed visible line count for expandable multi-line snippets.                                                             |
| `light`      | `bool`   | `false`      | `true`, `false`   | No                                                                                                        | Uses the alternate field/layer treatment when the snippet sits on a non-default layer.                                                 |
| Default slot | `string` | `HtmlString` | none              | Exact escaped or safe code content                                                                        | Yes                                                                                                                                   | Content must be the canonical code being documented.                                                          |
| `class`      | `string` | `null`       | `null`            | Layout passthrough if supported                                                                           | No                                                                                                                                    | Parent Patterns may pass layout classes. Do not use for local color, typography, spacing, or state overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, UI Reference proof, and tests before production use.

### 4.4. Data attribute contract

| Attribute                       | Status                   | Value             | Rule                                                                        |
| ------------------------------- | ------------------------ | ----------------- | --------------------------------------------------------------------------- |
| `data-ui-component`             | Implemented              | `code-snippet`    | Identifies the rendered component for tests and future behavior hooks.      |
| `data-ui-code-snippet`          | Implemented              | present           | Lifecycle hook for `initCodeSnippets`.                                      |
| `data-ui-code-snippet-variant`  | Implemented              | `inline`, `single`, `multi` | Mirrors the installed variant for UI Reference proof and tests.      |
| `data-ui-code-copy-state`       | Implemented              | `idle`, `copied`  | Mirrors and updates copy-state presentation.                                |
| `data-ui-code-copy-source`      | Implemented              | present           | Source text copied to clipboard.                                            |
| `data-ui-code-copy-button`      | Implemented              | present           | Copy trigger hook.                                                          |
| `data-ui-code-show-more`        | Implemented              | present           | Show more/show less trigger hook.                                           |
| `data-ui-code-snippet-expanded` | Implemented              | `true`, `false`   | Mirrors expandable multi-line state.                                        |

Feature views must not invent new `data-ui-code-*` attributes.

### 4.5. Syntax token class contract

Use explicit token spans only when the example needs syntax highlighting proof or code-token roles. Plain code is allowed and preferred for simple examples.

| Class                       | Type         | Status                       | Purpose                                                          |
| --------------------------- | ------------ | ---------------------------- | ---------------------------------------------------------------- |
| `ui-code-token-keyword`     | Syntax token | Implemented                  | Keywords such as `function`, `return`, `class`, `if`, `foreach`. |
| `ui-code-token-property`    | Syntax token | Implemented                  | Props, attributes, variables, property names, or keys.           |
| `ui-code-token-string`      | Syntax token | Implemented                  | String literals and quoted values.                               |
| `ui-code-token-punctuation` | Syntax token | Implemented                  | Punctuation that benefits from token proof.                      |
| `ui-code-token-comment`     | Syntax token | Implemented / required proof | Comments when needed in examples.                                |
| `ui-code-token-number`      | Syntax token | Implemented / required proof | Numeric literals when useful.                                    |
| `ui-code-token-function`    | Syntax token | Implemented / required proof | Function, method, helper, or component call names.               |

Do not add feature-local token classes. New token roles require Typography/Color review, this standard update, UI Reference proof, and tests.

### 4.6. CSS class contract

| Class                         | Type     | Status                        | Purpose                      |
| ----------------------------- | -------- | ----------------------------- | ---------------------------- |
| `ui-code-snippet`             | Root     | Implemented                   | Base code snippet wrapper.   |
| `ui-code-snippet--single`     | Variant  | Implemented                   | Single-line treatment.       |
| `ui-code-snippet--multi`      | Variant  | Implemented                   | Multi-line block treatment.  |
| `ui-code-snippet--copyable`   | Modifier | Implemented                   | Copy affordance is rendered. |
| `ui-code-snippet--copied`     | State    | Implemented visual state      | Copied state is visible.     |
| `ui-code-snippet__header`     | Element  | Implemented                   | Optional label/copy header.  |
| `ui-code-snippet__language`   | Element  | Implemented                   | Language/context label.      |
| `ui-code-snippet__copy`       | Element  | Implemented visual affordance | Copy control when rendered.  |
| `ui-code-snippet__copy-label` | Element  | Implemented                   | Copy/copy-state label.       |
| `ui-code-snippet__body`       | Element  | Implemented                   | Scrollable code body region. |
| `ui-code-snippet__pre`        | Element  | Implemented                   | `pre` wrapper.               |
| `ui-code-snippet__code`       | Element  | Implemented                   | `code` element.              |

Feature views must not create additional `code-snippet-*`, `snippet-*`, `highlight-*`, `syntax-*`, or local code token classes. New classes require source implementation, this standard update, UI Reference proof, and tests.

## 5. Allowed variants, options, and modifiers

| Name                    | Type         | Status                    | API                           | Notes                                                                                    |
| ----------------------- | ------------ | ------------------------- | ----------------------------- | ---------------------------------------------------------------------------------------- |
| Inline code snippet     | Variant      | Implemented               | `variant="inline"`            | Short code term or command embedded in prose.                                            |
| Single-line             | Variant      | Implemented               | `variant="single"`            | Short API calls, route names, class names, token names, or commands.                     |
| Multi-line              | Variant      | Implemented               | `variant="multi"`             | Preserved line breaks, indentation, and longer examples.                                 |
| Language label          | Option       | Implemented               | `language="Blade"`            | Shows language/context in the snippet header.                                            |
| Copy ready              | Option/state | Implemented visual state  | `copyable copyState="idle"`   | Renders copy affordance in idle state.                                                   |
| Copied                  | State        | Implemented               | `copyable copyState="copied"` | Renders copied confirmation and is updated by the controller after activation.            |
| Syntax tokens           | Modifier     | Implemented               | `ui-code-token-*` spans       | Token-backed highlighting for examples that need it.                                     |
| Overflow scroll         | Behavior     | Implemented               | component-owned CSS           | Long examples scroll horizontally.                                                       |
| Show more/show less     | Behavior     | Implemented               | `expandable`                  | Multi-line snippets may collapse/expand with a ghost button.                             |
| Live clipboard copy     | Behavior     | Implemented               | `copyable`                    | Copy button or copyable inline snippet writes exact snippet text and updates feedback.   |
| Executable/live preview | Behavior     | Not owned by Code snippet | none                          | Requires separate playground/live-preview Pattern.                                       |
| Diff view               | Variant      | Gated                     | none                          | Requires dedicated diff token model, accessibility proof, and tests.                     |
| Line numbers            | Modifier     | Gated                     | none                          | Requires copy behavior rules, wrapping/scroll proof, and screen-reader treatment.        |
| Error/warning snippet   | State        | Not applicable            | none                          | Use prose, Notification, or code comments; Code snippet does not own severity.           |
| Loading snippet         | State        | Not applicable            | none                          | Use Loading when code content is pending.                                                |
| Disabled snippet        | State        | Not applicable            | none                          | Snippets are read-only content. Only copy controls can be unavailable by gated behavior. |

## 6. States

| State                      | Status                            | Implementation requirement                                                                                    |
| -------------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| Default                    | Implemented                       | Renders the selected variant with code typography and token-backed container styling.                         |
| Single-line                | Implemented                       | Keeps short code compact and horizontally scrollable if needed.                                               |
| Multi-line                 | Implemented                       | Preserves line breaks and indentation with block scrolling.                                                   |
| Highlighted                | Implemented                       | Syntax roles use `ui-code-token-*` spans and Foundation Color/Typography roles.                               |
| Copy ready                 | Implemented visual state          | Copy affordance is visible when `copyable` is true and `copyState="idle"`.                                    |
| Copied                     | Implemented                       | Copied state is visible when `copyState="copied"` and after copy activation.                                  |
| Hover                      | Implemented for copy control only | Copy control uses token-backed hover treatment. Read-only code body should not imply interactivity.           |
| Focus-visible              | Implemented for copy control only | Copy control has visible focus in all supported themes. Clicked controls retain visible focus until another pointer or keyboard interaction. |
| Active/pressed             | Implemented for copy control only | Copy control has token-backed active treatment.                                                               |
| Overflow                   | Implemented                       | Long code scrolls horizontally without changing syntax meaning.                                               |
| Read-only                  | Implemented                       | Code content is read-only; it is selectable text but not editable.                                            |
| Disabled                   | Copy control only                 | Snippet content is read-only; copy controls may be disabled when copying is unavailable.                       |
| Loading                    | Not applicable                    | Use Loading if snippet content is not ready.                                                                  |
| Error/warning/success/info | Not applicable                    | These are not Code snippet states. Use copy-state text, comments inside code, or Notification as appropriate. |
| Selected/unselected        | Not applicable                    | Snippet content is not a selection control.                                                                   |
| Expanded/collapsed         | Implemented                       | Expandable multi-line snippets expose Show more/Show less and `aria-expanded`.                                |
| Empty                      | Not allowed                       | Do not render an empty code snippet. Use explanatory text or remove the example.                              |
| Reduced motion             | Implemented where motion exists   | Copy-state transitions must use Foundation Motion and respect reduced-motion preferences when animated.       |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Code snippet consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.

2x Grid is not a public Code snippet API dependency. Parent documentation Patterns may use 2x Grid to place snippet groups.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                           |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Code container surface, text, syntax token roles, copy control icon/text, hover/focus/active state, copied state, borders, and theme-specific contrast. |
| Spacing     | Snippet padding, header gap, language-label spacing, copy-control gap, multi-line body spacing, and scroll affordance spacing.                          |
| Typography  | Monospace code face, code size, line height, language label typography, copy label text, and token role styling.                                        |
| Themes      | Light, dark, layered, and inverse token resolution for code container, syntax colors, and copy controls.                                                |
| Motion      | Short productive transitions for copy control hover/focus/active/copied states where implemented.                                                       |
| Icons       | Approved copy/check icons when copy affordance is rendered.                                                                                             |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Single-line snippet container background | `ui-code-snippet--single` surface role | App layer palette | Same role / app value | Code snippet surfaces use layer roles, not local gray blocks. |
| `$layer` | Header/body/footer surface | `--ui-code-snippet-layer` | App layer palette | Same role / app value | Block snippet header, code body, and footer controls share one layer surface in the same shell. |
| `$layer-hover`, `$layer-active` | Inline snippet hover/active background | Inline snippet state roles | App layer state palette | Same role / app value | Hover/active shares layer state mapping. |
| `$icon-primary` | Multi-line/copy icon color | Code snippet copy/icon role | App icon palette | Same role / app value | Icons inherit currentColor from component state. |
| `$focus` | Single-line/container/copy focus | Code snippet focus-visible role | App focus palette | Same role / app value | Focus must remain visible on copyable snippets, including the most recently clicked copy or show-more control. |
| `--ui-code-token-*` syntax roles | Syntax highlighting colors | Code snippet token spans | App code token palette | App-specific role | Syntax token colors are component-owned and must not be reused as generic text colors. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-code-snippet
.ui-code-snippet--single
.ui-code-snippet--multi
.ui-code-snippet--copyable
.ui-code-snippet--copied
.ui-code-snippet__header
.ui-code-snippet__language
.ui-code-snippet__copy
.ui-code-snippet__copy-label
.ui-code-snippet__body
.ui-code-snippet__pre
.ui-code-snippet__code
.ui-code-token-keyword
.ui-code-token-property
.ui-code-token-string
.ui-code-token-punctuation
.ui-code-token-comment
.ui-code-token-number
.ui-code-token-function
```

Feature views must not create local syntax classes, hard-coded token colors, arbitrary code backgrounds, Bootstrap code utilities, direct Carbon classes, local copy icons, custom focus rings, arbitrary spacing, or feature-local clipboard JavaScript for the same UI role.

### 7.4. Helper usage

| Helper/mechanism           | Status                       | Rule                                                                                                  |
| -------------------------- | ---------------------------- | ----------------------------------------------------------------------------------------------------- |
| `x-ui.code-snippet`        | Approved                     | Required Blade API for code snippets.                                                                 |
| Default slot               | Approved                     | Contains exact code content.                                                                          |
| Escaped HTML entities      | Required when showing markup | Do not allow markup examples to execute.                                                              |
| `variant` prop             | Approved                     | Use `inline`, `single`, or `multi`.                                                                   |
| `language` prop            | Approved                     | Use short labels only.                                                                                |
| `copyable` prop            | Approved visual affordance   | Use only when copying exact snippet is useful.                                                        |
| `copyState` prop           | Approved initial state       | Use `idle` or `copied`; live copy behavior updates this state.                                        |
| `expandable` prop          | Approved                     | Use only on multi-line snippets that need collapsed and expanded views.                               |
| `data-ui-*` attributes     | Approved only as documented  | Do not invent new snippet data attributes.                                                            |
| `initCodeSnippets`         | Approved                     | Owns copy-to-clipboard, copied feedback, and show-more behavior.                                      |
| Syntax highlighter library | Gated                        | Requires dependency approval, token mapping, accessibility review, performance review, and tests.     |

## 8. Composition rules

- Use Code snippet for exact implementation syntax, not general emphasis.
- Use prose for explanations and tables for API matrices.
- Use `variant="single"` when the example fits one logical line.
- Use `variant="multi"` when line breaks, indentation, or multiple statements matter.
- Preserve indentation and line breaks.
- Escape HTML and Blade examples so they render as code, not executable markup.
- Keep examples scoped to the API currently being documented.
- Do not show deferred or speculative APIs as complete examples unless clearly marked as deferred trigger conditions.
- Use `language` labels consistently across related examples.
- Use `copyable` when the snippet is intended to be copied exactly.
- Copy button tooltips must use Tooltip positioning that can resolve within the viewport and must not be clipped by the snippet shell or surrounding card.
- Do not render copy controls for examples that require developer substitution unless the copy label/context makes that clear.
- Long examples scroll horizontally instead of wrapping into misleading syntax.
- Avoid very long examples; link to source docs or split examples when a snippet becomes hard to scan.
- Keep syntax token highlighting supportive, not decorative.
- Parent Patterns own surrounding explanatory copy, grouping, spacing, cards, tabs, scenario layouts, and page-level placement.
- Components own internal code semantics, styling, copy affordance presentation, syntax token roles, and overflow behavior.

## 9. Selection guidance

Use Code snippet when:

- A developer needs exact implementation syntax.
- A UI Reference page needs to show canonical Blade, PHP, JavaScript, CSS, HTML, JSON, route, or test examples.
- A code value must preserve whitespace, punctuation, casing, or indentation.
- Copying the exact snippet is useful.
- Syntax token colors help distinguish code roles in documentation.

### 9.1. Do not use Code snippet when:

- The content is ordinary prose, labels, field values, or metadata.
- The example is speculative, outdated, or not accepted as an app API.
- The content is a full source file, long tutorial, diff, terminal log, stack trace, or live playground.
- The content needs to be executed, edited, or previewed interactively.
- The content is ordinary prose or metadata; use Typography/body text instead.
- A visual token sample is needed; use the owning Foundation Element page.
- A status, warning, or recovery message is needed; use Notification or prose.

### 9.2. Component selection:

| Need                             | Use                                                                                 |
| -------------------------------- | ----------------------------------------------------------------------------------- |
| Exact one-line component call    | Code snippet `variant="single"`                                                     |
| Multiline implementation example | Code snippet `variant="multi"`                                                      |
| Inline code term inside prose    | Code snippet `variant="inline"`                                                     |
| API props/options table          | Markdown table / documentation Pattern                                              |
| Long source file                 | Link to source or gated code viewer                                                 |
| Copyable command/example         | Code snippet with `copyable` visual affordance                                      |
| Live copy-to-clipboard behavior  | Code snippet with `copyable`                                                        |
| Syntax-highlighted example       | Code snippet with `ui-code-token-*` spans                                           |
| Warning about a code example     | Prose or Notification, not a severity snippet                                       |

## 10. Accessibility contract

- Block snippets must use semantic `pre` and `code` structure.
- Code content must be readable as text and must not be conveyed only through images or screenshots.
- Copy controls, when rendered, must be native buttons or use Button/Icon button behavior.
- Copy controls must have an accessible name such as `Copy code`.
- Copy controls must be keyboard reachable when rendered.
- Copy controls must show visible focus in every supported theme.
- Copy controls and show-more controls must keep visible clicked focus until another click, Tab, Escape, or other keyboard interaction changes focus context.
- Copy state must be conveyed through text, not icon or color alone.
- Live clipboard behavior must announce successful copy and failure states through component feedback text.
- Syntax colors must meet contrast requirements in supported light and dark themes.
- Syntax meaning must not rely on color alone where the token distinction is necessary to understand the example.
- Long snippets must remain reachable with keyboard and pointer scrolling where horizontal overflow is present.
- Do not trap keyboard focus inside the code snippet or scroll region.
- Escaped markup must not execute or create unexpected focusable controls.
- Copy buttons must not remove the user’s current focus unexpectedly.
- Reduced-motion preferences must be respected for any copied-state transition.

## 11. Content contract

- Keep examples short and tied to the current component or pattern API.
- Use sentence case for language labels if the label is a phrase; standard language names may use their conventional casing.
- Use labels such as `Blade`, `PHP`, `CSS`, `JavaScript`, `JSON`, `HTML`, `Route`, or `Test`.
- Use canonical component calls from the current app API.
- Use realistic but generic variable names.
- Do not include secrets, tokens, credentials, personal data, production hostnames, or private keys.
- Do not include destructive commands unless the example is specifically documenting destructive behavior.
- Do not include copied third-party code unless licensing and source context are approved.
- Do not include placeholder comments instead of real examples.
- Do not show deprecated paths as canonical examples.
- Do not use syntax color as decoration outside code.
- Prefer concise code examples over long copied sections.
- If a snippet is intentionally partial, label or introduce it as partial in the surrounding documentation.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, direct Carbon classes, Bootstrap code utilities, or custom JavaScript.
- Do not render `Component-specific API pending correction` as the example call or installed guidance.
- Do not create feature-local `x-code-snippet`, `x-ui.code`, `x-ui.copy-code`, raw `<pre>` wrappers, or equivalent local components.
- Do not hard-code syntax colors; use `ui-code-token-*` classes.
- Do not use code snippets for ordinary prose, labels, status text, or metadata.
- Do not show speculative API calls as complete examples.
- Do not show deferred APIs without deferred/gated disposition text.
- Do not use screenshots of code as the primary code example.
- Do not use fake controls for diff, line numbers, syntax highlighter libraries, or live-preview behavior.
- Do not attach feature-local clipboard JavaScript.
- Do not use Bootstrap `.code`, `.pre-scrollable`, `.text-monospace`, or utility clusters as the app Code snippet API.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not include secrets, credentials, private keys, production tokens, or sensitive user data in examples.
- Do not create broad documentation-library corrections from this standard.

## 13. Deferred or gated capabilities

| Capability                                  | Status                    | Gate                                                                                                                                                                 | Local workaround allowed?                                           |
| ------------------------------------------- | ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| Syntax highlighter integration              | Gated                     | Requires dependency approval, performance review, token mapping, accessibility review, no raw theme colors, and UI Reference proof.                                  | Use explicit `ui-code-token-*` spans for proof examples.            |
| Line numbers                                | Gated                     | Requires copy behavior decision, screen-reader handling, overflow proof, and tests.                                                                                  | No local line-number markup.                                        |
| Diff view                                   | Gated                     | Requires addition/deletion token model, non-color-only meaning, line labels, accessibility proof, and tests.                                                         | Use prose or separate examples.                                     |
| Terminal/console output variant             | Gated                     | Requires content rules, prompt/output distinction, copy behavior decision, and UI Reference proof.                                                                   | Use normal multi-line snippet with language label if needed.        |
| Full source viewer or playground            | Not owned by Code snippet | Requires separate Component/Pattern standard.                                                                                                                        | Link to source or use documentation prose.                          |

Future extensions require an updated Component standard and UI Reference proof before production use.

## 14. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Code snippet page is a developer-documentation reference page. The Live examples card should use grouped examples, variant comparison, copy-state examples, syntax token proof, overflow proof, accessibility notes, and developer implementation examples.

### 14.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                                                      | Variants/options shown                                                    |
| --------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------- |
| API status proof                  | Page states that Code snippet is implemented pending correction and uses `x-ui.code-snippet`.                                                                                          | `x-ui.code-snippet`, implemented pending correction                       |
| Single-line code                  | Short API calls stay visually compact, use token-backed code colors in live proof, and may include copy affordance.                                                                    | Single-line, Language label, Copy ready, Copied, Token colors             |
| Multi-line code                   | Longer examples preserve line breaks, indentation, token-backed code colors, and horizontal overflow.                                                                                  | Multi-line, Without copy, With copy, Overflow, Token colors               |
| Syntax token proof                | Token spans render with approved Typography and Color roles.                                                                                                                           | Keyword, Property, String, Punctuation, Comment, Number, Function         |
| Copy behavior proof               | Idle and copied states render through the icon-only copy button, non-clipped auto-positioning tooltip, copied-state color, and live feedback text.                                     | Copy to clipboard, Copied to clipboard, Accessible copy label, Tooltip    |
| Overflow behavior                 | Long snippets scroll horizontally instead of wrapping into misleading syntax.                                                                                                          | Overflow, Multi-line, Single-line                                         |
| Theme proof                       | Snippets render correctly on supported light, dark, layered, and inverse surfaces where applicable.                                                                                    | Themes, Contrast, Token colors                                            |
| Accessibility proof               | Examples show `pre`/`code`, copy button label, focus-visible state, text-based copied feedback, and non-color-only token meaning.                                                      | Semantics, Copy button, Focus-visible, Copied text                        |
| Content behavior proof            | Examples use real canonical app APIs, no placeholder comments, no secrets, no deprecated paths, and no speculative complete APIs.                                                      | Canonical examples, Safe content, No placeholders                         |
| Selection guidance matrix         | Page distinguishes Code snippet from prose, tables, inline code, source viewers, screenshots, live previews, and Notifications.                                                        | Code snippet, Typography inline code, Documentation Pattern, Notification |
| Prohibited usage proof            | Page shows raw `<pre>` wrappers, Bootstrap code utilities, direct Carbon classes, hard-coded syntax colors, screenshots of code, and speculative examples as prohibited.               | Raw wrappers, Bootstrap, Carbon classes, Fake controls                    |
| Gated capability proof            | Page shows trigger conditions for syntax highlighter libraries, line numbers, diff, terminal variants, and playground.                                                                 | Highlighter, Line numbers, Diff, Playground                              |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                                                    | Color, Spacing, Typography, Themes, Motion, Icons                         |
| Developer implementation examples | Canonical Blade calls render as real code examples.                                                                                                                                    | Single, Multi, Copyable, Copied, Syntax tokens                            |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed Blade API, props, rendered variants, rendered copy behavior, token classes, prohibited usage, remaining gated capabilities, accessibility behavior, and consumed Foundation Elements.

## 15. Testing and acceptance criteria

- `/platform/ui-reference/components/code-snippet` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, remaining gated capabilities, and Foundation Elements consumed.
- Implemented APIs render production examples; remaining deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Code snippet as `Implemented Pending Review`.
- The page shows canonical `<x-ui.code-snippet>` examples.
- The page renders inline, single-line, and multi-line examples.
- The page renders language-label examples.
- The page renders copy ready and copied visual states.
- The page documents live clipboard behavior through `initCodeSnippets`.
- The page renders syntax token examples using `ui-code-token-*` classes.
- The page renders overflow examples without misleading wrapped syntax.
- The page documents `variant`, `language`, `copyable`, `copyState`, `expandable`, `collapsedLines`, `light`, and content slot behavior.
- The page documents semantic `pre` and `code` structure.
- The page distinguishes Code snippet from prose, tables, inline code, source viewers, screenshots, live previews, and Notifications.
- The page documents prohibited usage for raw `<pre>` wrappers, Bootstrap code utilities, direct Carbon classes, raw syntax colors, screenshots of code, feature-local clipboard behavior, and speculative examples.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, `Legacy Contract Summary`, and duplicated implementation checklist sections remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap code classes, hard-coded colors, arbitrary local spacing, local icons, custom JavaScript, or feature-local code snippet classes are presented as approved.

### 15.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/code-snippet');

$response->assertOk();
$response->assertSee('Code snippet');
$response->assertSee('Implemented Pending Review');
$response->assertSee('x-ui.code-snippet');
$response->assertSee('ui-code-snippet');
$response->assertSee('variant');
$response->assertSee('single');
$response->assertSee('multi');
$response->assertSee('inline');
$response->assertSee('language');
$response->assertSee('copyable');
$response->assertSee('copyState');
$response->assertSee('Copy to clipboard');
$response->assertSee('Copied to clipboard');
$response->assertSee('Show more');
$response->assertSee('Show less');
$response->assertSee('ui-code-token-keyword');
$response->assertSee('ui-code-token-property');
$response->assertSee('ui-code-token-string');
$response->assertSee('pre');
$response->assertSee('code');
$response->assertSee('initCodeSnippets');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Motion');
$response->assertSee('Icons');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Implementation and UI Reference Checklist');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('pre-scrollable');
$response->assertDontSee('text-monospace');
```

## 16. Related APIs

| API                        | Route                                                                  |
| -------------------------- | ---------------------------------------------------------------------- |
| Components overview        | `/platform/ui-reference/components`                                    |
| Button                     | `/platform/ui-reference/components/button`                             |
| Icon button                | `/platform/ui-reference/components/button`                             |
| Tooltip                    | `/platform/ui-reference/components/tooltip`                            |
| Notification               | `/platform/ui-reference/components/notification`                       |
| Inline loading             | `/platform/ui-reference/components/inline-loading`                     |
| Typography element         | `/platform/ui-reference/elements/typography`                           |
| Color element              | `/platform/ui-reference/elements/color`                                |
| Spacing element            | `/platform/ui-reference/elements/spacing`                              |
| Themes element             | `/platform/ui-reference/elements/themes`                               |
| Motion element             | `/platform/ui-reference/elements/motion`                               |
| Icons element              | `/platform/ui-reference/elements/icons`                                |
| Documentation pattern      | `/platform/ui-reference/patterns/documentation`                        |
| Data/content pattern       | `/platform/ui-reference/patterns/data-content`                         |
| Canonical code snippet doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fcode-snippet.md` |
| Carbon code snippet usage  | `https://carbondesignsystem.com/components/code-snippet/usage/`        |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Code snippet usage, style, and accessibility guidance inform inline/single/multi variant boundaries, copy affordance labeling, copied-state text, show-more behavior, token-backed focus/hover/active states, and accessible syntax color expectations. Login App keeps its own `x-ui.code-snippet` API, `ui-*` namespace, explicit token classes, `initCodeSnippets` controller, Foundation Element tokens, and UI Reference proof.
