---
title: Motion
slug: motion
api_layer: Foundation Element API
guide_status: implemented
system_maturity: partial
ui_reference_route: /platform/ui-reference/elements/motion
canonical_doc: docs/02-standards/ui/elements/motion.md
carbon_reference:
  - https://carbondesignsystem.com/elements/motion/overview/
  - https://carbondesignsystem.com/elements/motion/choreography/
  - https://carbondesignsystem.com/elements/motion/code/
external_reference:
  - https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion
related_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
related_components:
  - accordion
  - button
  - dropdown
  - menu-buttons
  - modal
  - notification
  - loading
  - inline-loading
  - progress-bar
  - progress-indicator
  - tile
  - toggle
  - tooltip
  - toggletip
  - tree-view
  - data-table
related_patterns:
  - overlays-and-actions
  - layout
  - forms
  - data-and-content
  - navigation
---

# Motion Element API Standard
- [1. API summary](#1-api-summary)
  - [Canonical API responsibilities:](#canonical-api-responsibilities)
  - [Non-owned responsibilities:](#non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed motion role model](#31-installed-motion-role-model)
  - [3.2. Productive motion as default](#32-productive-motion-as-default)
  - [3.3. Expressive motion gate](#33-expressive-motion-gate)
  - [3.4. Easing model](#34-easing-model)
  - [3.5. Duration model](#35-duration-model)
  - [3.6. Reduced-motion standard](#36-reduced-motion-standard)
- [4. Token API](#4-token-api)
  - [4.1. Motion token status](#41-motion-token-status)
- [5. CSS variable API](#5-css-variable-api)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Allowed utility classes](#61-allowed-utility-classes)
  - [6.2. Prohibited utility patterns](#62-prohibited-utility-patterns)
  - [6.3. Component wrapper API](#63-component-wrapper-api)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Use when](#71-use-when)
  - [7.2. Avoid when](#72-avoid-when)
  - [7.3. Selection guidance](#73-selection-guidance)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Component consumer rules](#81-component-consumer-rules)
  - [8.2. Pattern consumer rules](#82-pattern-consumer-rules)
- [9. Theme behavior](#9-theme-behavior)
- [10. State behavior](#10-state-behavior)
- [11. Prohibited usage](#11-prohibited-usage)
- [12. Deferred or gated capabilities](#12-deferred-or-gated-capabilities)
- [13. Implementation and UI Reference Checklist](#13-implementation-and-ui-reference-checklist)
  - [13.1. Implementation checklist](#131-implementation-checklist)
  - [13.2. UI Reference proof checklist](#132-ui-reference-proof-checklist)
- [14. UI Reference requirements](#14-ui-reference-requirements)
  - [14.1. Productive easing demos](#141-productive-easing-demos)
  - [14.2. Expressive easing demos](#142-expressive-easing-demos)
  - [14.3. Common UI motion examples](#143-common-ui-motion-examples)
  - [14.4. Duration examples](#144-duration-examples)
  - [14.5. Reduced motion preview](#145-reduced-motion-preview)
  - [14.6. Do and do not samples](#146-do-and-do-not-samples)
  - [14.7. API reference display](#147-api-reference-display)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested automated assertions](#151-suggested-automated-assertions)
  - [15.2. Manual review checklist](#152-manual-review-checklist)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Motion clarifies state change for hover, focus, overlays, loading, feedback, and reduced-motion contexts.

Motion is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

Motion is the installed transition and animation standard for Login App 2.0. It defines when motion is allowed, which easing and duration roles are allowed, how reduced-motion preferences are respected, and which Components or Patterns may own visible motion behavior. It does not authorize decorative animation, feature-local keyframes, page-transition effects, bounce/stretch motion, parallax, one-off animation libraries, or motion that delays usable content.

### Canonical API responsibilities:

- Productive transition rules for normal admin UI.
- Expressive motion gating rules.
- Hover, focus-visible, active, selected, disabled, loading, and validation transition behavior.
- Overlay entrance and exit behavior.
- Disclosure, dropdown, toast, drawer, modal, and tooltip/toggletip timing rules.
- Reduced-motion behavior.
- Loading and skeleton motion boundaries.
- Motion accessibility constraints.
- Prohibited animation patterns.
- UI Reference proof requirements.

### Non-owned responsibilities:

- Component state ownership. Each Component API owns its state model and event behavior.
- Color values during state changes. Use the Color Element API.
- Layout geometry during motion. Use the 2x Grid, Spacing, Component, or Pattern API that owns the layout.
- Loading status semantics. Use Loading, Inline loading, Progress bar, or Progress indicator Component APIs.
- Overlay focus management. Use Modal, Popover, Toggletip, Tooltip, Menu, or Pattern APIs as applicable.
- Page/workflow choreography. Use Pattern APIs and explicit product approval.

Use Motion only when it helps users understand what changed, where focus or content moved, or whether work is in progress. Do not add motion because the interface feels static.

## 2. Status and ownership

| Field                        | Value                                                                                                                   |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Guide status                 | Implemented                                                                                                             |
| System maturity              | Partial                                                                                                                 |
| API layer                    | Foundation Element API                                                                                                  |
| Element slug                 | motion                                                                                                                  |
| UI Reference route           | `/platform/ui-reference/elements/motion`                                                                                |
| Canonical doc                | `docs/02-standards/ui/elements/motion.md`                                                                               |
| Primary implementation model | Tailwind transition utilities, component-owned CSS classes, and `prefers-reduced-motion` rules                          |
| Primary consumers            | Buttons, links, forms, dropdowns, menus, accordions, modals, notifications, loading states, shell panels, table actions |
| Carbon benchmark             | Carbon Motion overview, easing, duration, and adaptive motion guidance                                                  |

`System maturity: Partial` means Login App 2.0 has installed transition utilities and reduced-motion expectations, but a complete named motion-token layer may still be expanding. Until named CSS variables or helpers are installed, use the approved utility classes, component APIs, and reduced-motion rules documented here. Do not invent feature-local motion variables or animation keyframes.

## 3. Installed standard

Transitions and reduced-motion behavior for hover, focus, overlays, loading, and feedback.

Login App 2.0 uses restrained productive motion by default. Motion should be fast, subtle, and tied to a state change. The installed standard is:

1. Use productive motion for normal admin UI.
2. Use motion only to guide, clarify, confirm, or preserve spatial continuity.
3. Use immediate feedback for hover, focus-visible, active, selected, disabled, loading, and validation states.
4. Use entrance motion when adding transient UI, such as dropdown menus, modals, toasts, popovers, and panels.
5. Use exit motion when removing transient UI, except when a panel remains spatially nearby and ready to return.
6. Use standard easing when an element remains visible throughout the motion or moves/repositions within the current context.
7. Use reduced-motion fallbacks for all non-essential transform, movement, scale, scroll, and loading motion.
8. Keep content usable without waiting for animation to finish.
9. Keep focus behavior deterministic. Focus must not be delayed or lost because of animation.
10. Do not use motion as decoration, entertainment, or branding unless a Pattern API explicitly owns the expressive moment.

### 3.1. Installed motion role model

| Role              | Installed standard                                                              | Allowed usage                                                                  | Default treatment                                                                     |
| ----------------- | ------------------------------------------------------------------------------- | ------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------- |
| Microinteraction  | Fast productive transition tied to user input.                                  | Button hover, link hover, field focus, menu item hover, table row hover.       | `transition duration-150 ease-out`, or the owning component's equivalent.             |
| Disclosure/reveal | Productive entrance/exit treatment for local content appearing or disappearing. | Accordion panel, dropdown menu, details area, expandable row.                  | Component-owned height/opacity transition with reduced-motion fallback.               |
| Overlay entrance  | Transient surface enters the current view.                                      | Modal, drawer, popover, toggletip, toast.                                      | Component or Pattern-owned opacity/translate/scale transition with focus rules.       |
| Overlay exit      | Transient surface leaves the current view.                                      | Modal close, toast dismissal, popover/toggletip close.                         | Component or Pattern-owned exit transition; focus returns immediately or predictably. |
| Nearby panel exit | Surface leaves but remains spatially associated with the trigger.               | Side panel, collapsible shell panel.                                           | Standard easing instead of aggressive exit easing.                                    |
| Loading motion    | Indicates active local work or pending region state.                            | Spinner, inline loading, skeleton shimmer if approved.                         | Loading Component API owns semantics; Motion owns reduced-motion limits.              |
| Progress motion   | Reinforces measured progress, not generic waiting.                              | Progress bar, progress indicator.                                              | Progress Component APIs own updates; Motion prevents decorative looping.              |
| Expressive moment | High-attention motion used sparingly.                                           | Major system notice, route-level Pattern transition, high-impact confirmation. | Gated. Requires explicit owner and UI Reference proof.                                |

### 3.2. Productive motion as default

Productive motion is the default for Login App 2.0 because the app is an admin/productivity interface. Productive motion should:

- Feel responsive.
- Stay subtle.
- Avoid competing with task content.
- Help users understand state change.
- Complete quickly enough that it does not become a blocker.
- Work across light, dark, inverse, inline, and high-contrast contexts.

### 3.3. Expressive motion gate

Expressive motion is not globally available. It may be used only when all of the following are true:

1. A Pattern or product workflow explicitly owns the moment.
2. The motion communicates meaningful state, priority, or spatial context.
3. The same message remains understandable with reduced motion.
4. The UI Reference page demonstrates the motion and reduced-motion fallback.
5. Accessibility review confirms it does not introduce vestibular, focus, timing, or distraction issues.

Examples that may qualify if explicitly approved:

- Important system notification entrance.
- Route-level workflow transition where continuity prevents disorientation.
- Primary completion moment for a high-value task.

Examples that do not qualify:

- Decorative card bounce.
- Decorative icon spin.
- Parallax.
- Confetti.
- Unnecessary page fade.
- Delayed hover reveal.
- Animated background effects.

### 3.4. Easing model

The installed app API currently uses Tailwind easing utilities and component-owned CSS. Carbon's motion model is the benchmark for deciding which easing role applies.

| Easing role         | Carbon benchmark                  | App API status                                         | Use when                                                       | App treatment                                                                 |
| ------------------- | --------------------------------- | ------------------------------------------------------ | -------------------------------------------------------------- | ----------------------------------------------------------------------------- |
| Standard productive | `cubic-bezier(0.2, 0, 0.38, 0.9)` | Benchmark / map through component classes where needed | Element remains visible throughout the motion or moves nearby. | Use component-owned transition or approved utility treatment.                 |
| Entrance productive | `cubic-bezier(0, 0, 0.38, 0.9)`   | Benchmark / map through component classes where needed | UI is added to the view.                                       | Use `ease-out` or component-owned entrance class until named token exists.    |
| Exit productive     | `cubic-bezier(0.2, 0, 1, 0.9)`    | Benchmark / map through component classes where needed | UI is removed from the view.                                   | Use component-owned exit class when implemented; avoid lingering transitions. |
| Standard expressive | `cubic-bezier(0.4, 0.14, 0.3, 1)` | Gated                                                  | High-attention motion where the element remains visible.       | Do not use unless Pattern-owned.                                              |
| Entrance expressive | `cubic-bezier(0, 0, 0.3, 1)`      | Gated                                                  | High-attention UI is added.                                    | Do not use unless Pattern-owned.                                              |
| Exit expressive     | `cubic-bezier(0.4, 0.14, 1, 1)`   | Gated                                                  | High-attention UI leaves.                                      | Do not use unless Pattern-owned.                                              |

Do not use easing curves that imply bounce, elastic stretch, sudden stop, rubber-band behavior, or decorative physical simulation.

### 3.5. Duration model

Login App 2.0 does not require every feature to expose Carbon's duration token names, but app motion should stay within Carbon-compatible timing ranges unless a component API documents a reason otherwise.

| Role                           |                Carbon benchmark | App default                                          | Allowed usage                                               |
| ------------------------------ | ------------------------------: | ---------------------------------------------------- | ----------------------------------------------------------- |
| Fast microinteraction          |                   70ms to 110ms | Component-owned or `duration-100` where already used | Very small hover/active/fade feedback.                      |
| Standard productive transition |                           150ms | `duration-150`                                       | Default hover/focus/reveal utility for admin UI.            |
| Moderate entrance/feedback     |                  150ms to 240ms | Component-owned                                      | Dropdowns, accordions, toasts, small panels.                |
| Larger surface transition      |                  240ms to 400ms | Pattern-owned                                        | Modal, drawer, page-region expansion.                       |
| Background dimming             | Up to 700ms in Carbon benchmark | Pattern-owned and usually shorter in app             | Backdrop treatment only when Modal/Overlay pattern owns it. |

Rules:

- Smaller changes should use shorter durations.
- Larger distance or size changes may use longer durations only when they improve spatial understanding.
- Loading motion may loop only while work is active.
- Do not delay usable content for animation.
- Do not add arbitrary durations such as `duration-[375ms]` without updating this standard.

### 3.6. Reduced-motion standard

Every non-essential motion must have a reduced-motion path. Reduced-motion support may:

- Remove transform-based motion.
- Replace motion with an instant state change.
- Keep opacity-only changes when they do not create a vestibular concern.
- Shorten duration.
- Stop shimmer, parallax, scale, pan, and large movement.
- Preserve status, hierarchy, and affordance through static styling.

Required CSS pattern:

```css
@media (prefers-reduced-motion: reduce) {
  .ui-motion-reducible,
  [data-ui-motion="reducible"] {
    animation-duration: 0.01ms;
    animation-iteration-count: 1;
    scroll-behavior: auto;
    transition-duration: 0.01ms;
  }
}
```

Use a more specific component-owned selector when the component has special behavior. Do not remove focus outlines, state color, status text, `aria-live`, or accessible state naming when reducing motion.

## 4. Token API

| Token/helper                   | Variable or value                                                | Allowed API/consumer                                            | Example                                                                              |
| ------------------------------ | ---------------------------------------------------------------- | --------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| Productive transition          | `transition duration-150 ease-out`                               | Control hover/focus classes, buttons, links, fields, row hovers | `<button class="transition duration-150 ease-out hover:border-sky-400">...</button>` |
| Fast state transition          | `transition duration-100 ease-out` where already component-owned | Very small opacity/color feedback                               | `<span class="transition duration-100 ease-out">...</span>`                          |
| Standard reveal                | Component-owned height/opacity transition                        | Accordion, expandable rows, dropdown-like reveal                | `data-ui-accordion-panel` uses measured panel motion and reduced-motion fallback.    |
| Overlay transition             | Current modal/drawer transition classes                          | `ui-modal-panel`, drawer surfaces, popover/toggletip surfaces   | Modal enter/exit treatment owned by Modal or Overlay Pattern.                        |
| Toast/feedback transition      | Component-owned feedback transition                              | Notification/toast entrance and dismissal                       | Toast appears without delaying content interaction.                                  |
| Loading motion                 | Loading/Inline loading Component API                             | `ui-spinner`, skeleton blocks, progress components              | `<span class="ui-spinner" aria-hidden="true"></span>`                                |
| Skeleton/loading fallback      | Static or reduced animation under reduced motion                 | Loading Component API, table/page-region loading                | Skeleton shape remains visible when shimmer is removed.                              |
| Reduced motion                 | `@media (prefers-reduced-motion: reduce)`                        | CSS media feature, component-owned CSS                          | Disable non-essential transform motion.                                              |
| Motion-safe utility boundary   | `motion-safe:*` where available and documented                   | Optional utility layer for non-essential animation              | Use only when the default static state remains complete.                             |
| Motion-reduce utility boundary | `motion-reduce:*` where available and documented                 | Optional utility layer for fallback behavior                    | Remove transform/animation while preserving state visibility.                        |

Only use Token API rows as installed standards where the helper, class, component, or selector exists in the application. If a named motion helper is not present in code, do not invent it inside feature work.

### 4.1. Motion token status

| Token or helper family                    | Status                                   | Owner                                                 | Notes                                                                                               |
| ----------------------------------------- | ---------------------------------------- | ----------------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| Tailwind transition utilities             | Implemented                              | Foundation Element API + Tailwind config              | Allowed when used with approved durations/easing and component ownership.                           |
| Component-owned motion classes            | Implemented / expanding                  | Component APIs                                        | Allowed for Accordion, Modal, Loading, Notification, Dropdown/Menu, and other installed components. |
| `@media (prefers-reduced-motion: reduce)` | Implemented requirement                  | Foundation Element API                                | Required for non-essential animation and transform motion.                                          |
| `--ui-motion-*` CSS variables             | Deferred / queued unless present in code | Motion Element API                                    | Do not consume until installed and proven on the UI Reference route.                                |
| Custom keyframes                          | Deferred / gated                         | Component or Pattern API plus Motion Element approval | Not allowed in feature code without a specific standard update.                                     |
| External animation library                | Not implemented                          | No default owner                                      | Requires decision record, accessibility review, and UI Reference proof.                             |

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

Current installed usage is utility-first and component-owned. Named CSS variables such as `--ui-motion-duration-fast`, `--ui-motion-duration-moderate`, `--ui-motion-easing-productive`, or `--ui-motion-easing-expressive` are not public feature-code API unless they exist in the codebase and are demonstrated by the UI Reference route.

Allowed CSS variable usage:

| Variable family                   | Status                           | Owner              | Allowed usage                                                                                                                         |
| --------------------------------- | -------------------------------- | ------------------ | ------------------------------------------------------------------------------------------------------------------------------------- |
| Component-owned custom properties | Implemented where present        | Component API      | Use only through the component's documented props/classes. Example: an accordion panel max-height custom property owned by Accordion. |
| `--ui-motion-*`                   | Deferred / queued unless present | Motion Element API | May be introduced only by updating this standard, the UI Reference page, and tests.                                                   |
| Feature-local motion variables    | Prohibited                       | No owner           | Do not create variables such as `--reports-card-delay` or `--dashboard-bounce-duration`.                                              |

Rules:

- Do not create local duration variables.
- Do not create local easing variables.
- Do not create local keyframe variables.
- Do not use inline style animation values except through an installed component prop or documented component-owned custom property.
- Do not add per-feature transition values without updating this standard.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the UI Reference route.

### 6.1. Allowed utility classes

| Utility                         | Status                                          | Use                                                                          |
| ------------------------------- | ----------------------------------------------- | ---------------------------------------------------------------------------- |
| `transition`                    | Implemented                                     | Enables transition on supported properties.                                  |
| `transition-colors`             | Implemented                                     | Color, border, background, and text state changes.                           |
| `transition-opacity`            | Implemented                                     | Opacity-only entrance/exit where component-owned.                            |
| `duration-100`                  | Implemented where already used                  | Very small feedback only.                                                    |
| `duration-150`                  | Implemented                                     | Default productive transition duration.                                      |
| `duration-200` / `duration-300` | Component/Pattern-owned only                    | Larger surface motion when the owning API documents it.                      |
| `ease-out`                      | Implemented                                     | Default productive entrance/interaction approximation.                       |
| `ease-in`                       | Component/Pattern-owned only                    | Exit transition when the owning API documents it.                            |
| `ease-in-out`                   | Component/Pattern-owned only                    | Standard repositioning or nearby panel motion when documented.               |
| `motion-reduce:transition-none` | Implemented where Tailwind variant is available | Removes transitions in reduced-motion contexts.                              |
| `motion-reduce:transform-none`  | Implemented where Tailwind variant is available | Removes transform motion in reduced-motion contexts.                         |
| `motion-safe:*`                 | Allowed only for non-essential animation        | Ensures animation appears only when users have not requested reduced motion. |

### 6.2. Prohibited utility patterns

Do not use:

- Arbitrary durations such as `duration-[375ms]`.
- Arbitrary easing such as `ease-[cubic-bezier(...)]` unless this Element standard exposes it.
- `animate-bounce`.
- `animate-ping` for non-status decoration.
- Decorative `animate-spin`; spinner animation belongs to Loading/Inline loading.
- Feature-local keyframes.
- Motion utilities that hide labels, helper text, validation, or focus states until animation finishes.
- Route/page transition effects unless a Pattern API owns them.

### 6.3. Component wrapper API

Components must expose motion through their own canonical APIs when motion is part of the component contract.

Examples:

| API                                 | Motion owner                                | Required behavior                                                           |
| ----------------------------------- | ------------------------------------------- | --------------------------------------------------------------------------- |
| `<x-ui.accordion>`                  | Accordion Component API + Motion Element    | Panel open/close motion; reduced-motion fallback; focus stays on trigger.   |
| `<x-ui.button>`                     | Button Component API + Motion Element       | Hover/focus/active/loading state transitions; no decorative motion.         |
| `<x-ui.modal>` or Modal Pattern API | Modal/Overlay owner + Motion Element        | Entrance/exit/backdrop motion; focus trap and focus return are not delayed. |
| Notification/toast API              | Notification Component API + Motion Element | Entrance/dismissal motion; `aria-live` behavior remains intact.             |
| Loading/Inline loading API          | Loading Component API + Motion Element      | Looping only while active; reduced-motion fallback.                         |

Feature views should call the component/pattern API instead of assembling local transition clusters.

## 7. Allowed usage

- Use when: motion guides, clarifies, or confirms state change.
- Avoid when: motion is decorative friction, bounce, stretch, sudden stop, or delays usable content.
- Common app examples: dropdowns, modals, toasts, accordions, side panels, table sorting, and loading skeletons.

### 7.1. Use when

Use Motion when:

- A visible state changes in response to user input.
- A transient surface enters or exits the view.
- A disclosure opens or closes.
- A loading or progress state needs to communicate pending work.
- A row, card, tile, or list item changes hover, active, selected, or disabled state.
- Feedback appears after a save, delete, validation failure, or background job update.
- Spatial continuity prevents disorientation.

### 7.2. Avoid when

Avoid Motion when:

- The change is already clear without animation.
- Animation would delay the user from acting.
- Motion only makes the UI feel more lively.
- The user must wait for the animation before reading or interacting.
- Motion draws attention away from the primary task.
- The state can be communicated through text, color, icon, layout, or focus alone.
- Reduced-motion support cannot be provided.

### 7.3. Selection guidance

| Need                           | Use                                                                    | Do not use                                     |
| ------------------------------ | ---------------------------------------------------------------------- | ---------------------------------------------- |
| Hover/focus feedback           | Productive transition.                                                 | Decorative scale, bounce, or delayed reveal.   |
| Open local secondary content   | Disclosure/reveal transition owned by component.                       | Custom JS animation.                           |
| Add transient overlay          | Entrance transition owned by Modal/Popover/Toggletip/Menu/Pattern API. | Feature-local transform/fade assembly.         |
| Remove transient overlay       | Exit transition owned by the overlay API.                              | Delayed focus return or motion-only dismissal. |
| Indicate waiting               | Loading/Inline loading or skeleton Component API.                      | Decorative spinner outside a status owner.     |
| Indicate measured progress     | Progress bar/indicator Component API.                                  | Generic loading spinner.                       |
| Page-level workflow transition | Pattern-owned transition, gated.                                       | Local page fade or route animation.            |

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

### 8.1. Component consumer rules

Component APIs must:

- Own their own state names and event behavior.
- Use approved motion utilities or component-owned motion classes.
- Respect reduced-motion preferences.
- Keep focus visible and deterministic.
- Keep content available without waiting for animation.
- Avoid motion-only meaning.
- Document any loading, validation, dismissal, or persistence behavior affected by motion.

### 8.2. Pattern consumer rules

Pattern APIs may own larger motion only when the behavior is part of a reusable composition, such as:

- Overlay and feedback pattern.
- App shell panel pattern.
- Table toolbar/filter pattern.
- Navigation/shell pattern.
- Wizard/progress pattern.

Pattern-owned motion must still consume this Motion Element API. Do not create Pattern motion that bypasses reduced-motion or component accessibility requirements.

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the UI Reference page.

Motion itself is not a color token, but many moving states change color, background, border, shadow, opacity, or layer. Motion must preserve theme correctness:

- Hover/focus/active transitions must use theme-aware Color Element roles.
- Overlay transitions must preserve readable surfaces and backdrops.
- Focus-visible styling must remain visible throughout motion.
- Disabled states must not animate into misleading active treatments.
- Loading and skeleton motion must remain readable in light and dark contexts.
- High-contrast contexts must not depend on subtle opacity-only motion.

Do not use opacity animation as the only way to communicate a state change in high-contrast or reduced-motion contexts.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

| State            | Motion behavior                                                                            | Owner                                           |
| ---------------- | ------------------------------------------------------------------------------------------ | ----------------------------------------------- |
| Default          | No motion. Static base state.                                                              | Component API.                                  |
| Hover            | Fast productive transition if visual state changes.                                        | Component API + Motion Element.                 |
| Focus-visible    | Visible immediately; may transition color/border but focus ring must not be delayed.       | Component API + Color/Motion Elements.          |
| Active/pressed   | Immediate feedback. Short transition only if it improves responsiveness.                   | Component API.                                  |
| Selected/current | State should settle quickly and remain clear without motion.                               | Component API.                                  |
| Disabled         | Usually static. Do not animate into disabled; avoid misleading hover transitions.          | Component API.                                  |
| Loading          | Loading Component API owns status and looping behavior. Motion owns reduced-motion limits. | Loading/Inline loading.                         |
| Validation       | Error/warning/success state must appear clearly. Do not rely on shake or animation.        | Form field/Notification APIs.                   |
| Empty state      | Usually static. Skeleton/loading may transition into final content if component-owned.     | Component or Pattern API.                       |
| Dismissed        | Exit transition may occur, but status/dismissal semantics must remain correct.             | Notification/Modal/Popover/Toggletip/Menu APIs. |

Do not use animated shake, pulse, bounce, or color flash for validation. Validation meaning must be visible through text, icon, color role, and accessible state.

## 11. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Productive motion is default for admin UI.
- Expressive motion requires a high-attention moment and explicit owner.
- Use entrance easing when adding UI and exit easing when removing UI.
- Avoid bounce, decorative spin, excessive distance, and long animations.

Additional prohibitions:

- Do not add arbitrary animation durations or easing values in feature views.
- Do not create feature-local `@keyframes`.
- Do not use animation libraries without a decision record and UI Reference proof.
- Do not animate required instructions, labels, helper text, or validation so they appear late.
- Do not move focus as part of a visual animation without an accessibility contract.
- Do not delay keyboard access until animation completes.
- Do not use motion-only cues for success, error, warning, selection, or dismissal.
- Do not use parallax, animated backgrounds, decorative looping motion, bounce, elastic movement, or confetti in admin UI.
- Do not animate layout in a way that creates unexpected horizontal scroll.
- Do not use shimmer or spinner motion indefinitely after work completes or fails.
- Do not animate route/page transitions unless a Pattern API explicitly owns the behavior.
- Do not rely on hover-only motion for essential information.

## 12. Deferred or gated capabilities

| Capability                                     | Status                                     | Gate                                                                                                    |
| ---------------------------------------------- | ------------------------------------------ | ------------------------------------------------------------------------------------------------------- |
| Named `--ui-motion-*` CSS variables            | Deferred / queued unless installed in code | Requires token definition, UI Reference proof, docs update, and tests.                                  |
| Expressive motion                              | Gated                                      | Requires product/workflow owner, accessibility review, reduced-motion fallback, and UI Reference proof. |
| Page or route transitions                      | Gated Pattern capability                   | Requires Pattern API ownership, focus/scroll behavior, reduced-motion fallback, and testing.            |
| Custom keyframes                               | Gated                                      | Requires component/pattern standard update and no safer utility alternative.                            |
| External animation library                     | Not implemented                            | Requires decision record, bundle/performance review, accessibility review, and UI Reference proof.      |
| Lottie or illustrated animation                | Not implemented                            | Requires brand/content/design review and reduced-motion fallback.                                       |
| Parallax or scroll-linked animation            | Not allowed by default                     | Requires explicit exception; generally inappropriate for admin UI.                                      |
| Motion choreography across multiple components | Gated Pattern capability                   | Requires one Pattern owner and clear state/focus contracts.                                             |

No additional capability is approved without updating this Element standard and UI Reference proof.

## 13. Implementation and UI Reference Checklist

### 13.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 13.2. UI Reference proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 14. UI Reference requirements

The UI Reference page must prove this standard with live rendered examples using app CSS/JS. It must not rely on screenshots only.

Required sections and examples:

### 14.1. Productive easing demos

Render examples that demonstrate productive motion for:

- Hover/focus transition.
- Disclosure/reveal.
- Dropdown/menu surface entrance.
- Table row or list row feedback.
- Toast or inline feedback entrance.

Each example must show the class/helper/API used and identify the owning Component or Pattern API.

### 14.2. Expressive easing demos

Render expressive examples only if a real app-owned expressive motion API exists. Otherwise show a gated/deferred reference card that explains:

- Expressive motion is not generally available.
- Which product trigger is required.
- Which owner must approve it.
- What reduced-motion fallback is required.

Do not fake expressive motion as an implemented app capability.

### 14.3. Common UI motion examples

Render live examples for:

- Dropdown or menu opening.
- Modal or overlay entrance/exit preview.
- Toast or notification entrance/dismissal.
- Accordion open/close.
- Side panel or app shell panel behavior if implemented.
- Table sorting, row expansion, or row feedback if implemented.
- Loading spinner and skeleton transition behavior.

Each example should indicate whether the behavior is Element-owned, Component-owned, or Pattern-owned.

### 14.4. Duration examples

Render a duration comparison for:

- Fast microinteraction.
- Standard productive transition.
- Moderate entrance/feedback.
- Larger surface transition, if Pattern-owned.

The comparison must show approved classes or component APIs. Do not include arbitrary duration examples as if they are allowed.

### 14.5. Reduced motion preview

Provide one of the following:

- A live preview toggle that simulates reduced-motion behavior.
- A side-by-side default/reduced comparison.
- A reduced-motion requirements card with visible component examples.

The page must explain that `prefers-reduced-motion` removes, reduces, or replaces non-essential motion while preserving meaning.

### 14.6. Do and do not samples

Show examples of:

| Do                                           | Do not                                        |
| -------------------------------------------- | --------------------------------------------- |
| Use fast productive hover/focus transition.  | Use bounce on hover.                          |
| Use entrance motion for a menu or modal.     | Delay content until animation completes.      |
| Use reduced-motion fallback.                 | Require transform motion to understand state. |
| Use Loading/Inline loading for pending work. | Use decorative spinning icons.                |
| Use static validation text/icon/color.       | Shake fields or flash errors.                 |

### 14.7. API reference display

The page must display:

- Token/helper API table.
- CSS variable API rules.
- Utility class/helper API rules.
- Allowed usage.
- Prohibited usage.
- Deferred/gated capabilities.
- Accessibility constraints.
- Implementation status.
- Related Components and Patterns.

## 15. Testing and acceptance criteria

- `/platform/ui-reference/elements/motion` returns 200 for authorized users.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page identifies productive motion as the default for admin UI.
- The page marks expressive motion as gated unless a real app-owned API exists.
- The page shows reduced-motion requirements and at least one rendered reduced-motion comparison or preview.
- The page includes do/do-not samples and does not present prohibited motion as acceptable.
- The page distinguishes Motion Element ownership from Component and Pattern ownership.
- The page links to Loading, Inline loading, Modal/Overlay, Notification, Accordion, and other motion-consuming APIs where applicable.
- Automated tests assert that generic fallback text is absent.
- Automated tests assert that reduced-motion copy or selectors are present.
- Automated tests assert that arbitrary motion values are not presented as approved API.

### 15.1. Suggested automated assertions

```php
$response->assertOk();
$response->assertSee('Motion Element API Standard');
$response->assertSee('Productive motion is default');
$response->assertSee('Reduced motion');
$response->assertSee('prefers-reduced-motion');
$response->assertSee('transition duration-150 ease-out');
$response->assertSee('Expressive motion');
$response->assertSee('Gated');
$response->assertDontSee('animate-bounce is allowed', false);
$response->assertDontSee('generic fallback', false);
```

### 15.2. Manual review checklist

- Verify all rendered motion examples are actual app CSS/JS behavior.
- Verify keyboard focus remains visible and predictable during motion.
- Verify reduced-motion preference removes or replaces transform/large movement.
- Verify loading examples stop when complete or show an explicit static fallback.
- Verify no page example encourages decorative animation.
- Verify dark, light, inverse, inline, and high-contrast contexts remain readable where demonstrated.

## 16. Related APIs

| API                           | Route                                                                            |
| ----------------------------- | -------------------------------------------------------------------------------- |
| Accordion component           | `/platform/ui-reference/components/accordion`                                    |
| Button component              | `/platform/ui-reference/components/button`                                       |
| Dropdown component            | `/platform/ui-reference/components/dropdown`                                     |
| Menu buttons component        | `/platform/ui-reference/components/menu-buttons`                                 |
| Modal component               | `/platform/ui-reference/components/modal`                                        |
| Notification component        | `/platform/ui-reference/components/notification`                                 |
| Loading component             | `/platform/ui-reference/components/loading`                                      |
| Inline loading component      | `/platform/ui-reference/components/inline-loading`                               |
| Progress bar component        | `/platform/ui-reference/components/progress-bar`                                 |
| Progress indicator component  | `/platform/ui-reference/components/progress-indicator`                           |
| Overlays and feedback pattern | `/platform/ui-reference/patterns/overlays-feedback`                              |
| Layout pattern                | `/platform/ui-reference/patterns/layout`                                         |
| Navigation pattern            | `/platform/ui-reference/patterns/navigation`                                     |
| Canonical motion doc          | `/platform/docs?path=02-standards%2Fui%2Felements%2Fmotion.md`                   |
| Carbon motion overview        | `https://carbondesignsystem.com/elements/motion/overview/`                       |
| MDN prefers-reduced-motion    | `https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion` |

## 17. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon Motion overview](https://carbondesignsystem.com/elements/motion/overview/)
- [MDN `prefers-reduced-motion`](https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion)
- Carbon motion guidance informs purposeful state-change motion. Login App keeps restrained interaction motion.
