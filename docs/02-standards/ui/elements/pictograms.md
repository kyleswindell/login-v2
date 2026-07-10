---
title: Pictograms
slug: pictograms
api_layer: Foundation Element API
guide_status: implemented
system_maturity: needs-audit
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/elements/pictograms.md
source_owner: not installed
asset_source: gated
blade_api: []
css_variable_api:
  - --ui-pictogram-size-min
  - --ui-pictogram-size-sm
  - --ui-pictogram-size-md
  - --ui-pictogram-size-lg
  - --ui-pictogram-size-xl
utility_api:
  - ui-pictogram
  - ui-pictogram--productive
  - ui-pictogram--expressive
  - ui-pictogram--sm
  - ui-pictogram--md
  - ui-pictogram--lg
  - ui-pictogram--xl
related_elements:
  - icons
  - color
  - spacing
  - typography
  - themes
  - motion
related_patterns:
  - data-content
  - interactions
  - layout
carbon_reference:
  - https://carbondesignsystem.com/elements/pictograms/usage/
  - https://carbondesignsystem.com/elements/pictograms/library/
  - https://carbondesignsystem.com/elements/pictograms/code/
---

# Pictograms Element API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical Element responsibilities:](#11-canonical-element-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Current installed disposition:](#31-current-installed-disposition)
  - [3.2. Installed use rules:](#32-installed-use-rules)
- [4. Token API](#4-token-api)
- [5. CSS variable API](#5-css-variable-api)
  - [5.1. Expected default mapping:](#51-expected-default-mapping)
  - [5.2. Implementation rules:](#52-implementation-rules)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Reserved utility classes:](#61-reserved-utility-classes)
  - [6.2. Current status:](#62-current-status)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Use Pictograms when:](#71-use-pictograms-when)
  - [7.2. Avoid Pictograms when:](#72-avoid-pictograms-when)
  - [7.3. Common app examples:](#73-common-app-examples)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Approved or expected consumers:](#81-approved-or-expected-consumers)
  - [8.2. Consumer rules:](#82-consumer-rules)
- [9. Theme behavior](#9-theme-behavior)
  - [9.1. Theme rules:](#91-theme-rules)
  - [9.2. Required rendered evidence theme proof:](#92-required-ui-reference-theme-proof)
- [10. State behavior](#10-state-behavior)
- [11. Prohibited usage](#11-prohibited-usage)
- [12. Deferred or gated capabilities](#12-deferred-or-gated-capabilities)
- [13. Rendered evidence requirements](#13-ui-reference-requirements)
- [14. Testing and acceptance criteria](#14-testing-and-acceptance-criteria)
- [15. Related APIs](#15-related-apis)
- [16. References](#16-references)

## 1. API summary

Pictograms are larger illustrative assets for empty, onboarding, help, blocked, or explanatory moments. They are not UI icons, status icons, logos, product lockups, button icons, navigation icons, or decorative filler.

Pictograms is a Foundation Element API. Component and Pattern APIs must consume this standard instead of redefining local illustration sizing, asset sourcing, color behavior, clearance, or usage rules.

This standard is implemented as a governance and sizing contract. The production asset library remains gated. No feature may import Carbon pictograms, third-party pictograms, stock illustrations, AI-generated artwork, custom SVGs, or local image assets as app pictograms until the asset source is approved through an ADR or equivalent implementation decision.

### 1.1. Canonical Element responsibilities:

- Define the difference between pictograms, icons, logos, screenshots, photos, charts, and decorative illustrations.
- Define allowed pictogram use cases for empty, onboarding, help, blocked, unavailable, explanatory, and no-results states.
- Define minimum and recommended pictogram sizes.
- Define productive-versus-expressive disposition for future assets.
- Define container, clearance, theme, accessibility, responsive, and reduced-motion rules.
- Reserve app-owned `ui-pictogram*` classes and CSS variables for an approved source implementation.
- Prevent local asset imports, arbitrary recoloring, cropping, distortion, and one-off illustration systems.
- Provide rendered evidence proof for the current queued/gated disposition.

### 1.2. Non-owned responsibilities:

- UI icons and icon-only actions. Use the Icons Element and the owning Component.
- Brand marks, logos, product lockups, campaign art, and client-specific marketing graphics.
- Empty-state layout, headings, body text, and recovery actions. Use the Empty state or Data/content Pattern.
- Notification, alert, validation, and status semantics. Use Notification, Tag, field Components, or the owning Pattern.
- Loading placeholders. Use Loading.
- Feature-specific business rules for why a state is empty, blocked, or unavailable.

Carbon alignment note: Carbon separates pictograms from icons, defines productive and expressive pictograms, recommends productive pictograms for most contexts, reserves expressive pictograms for selective high-presence moments, sets 48px as the minimum size, and warns against using pictograms as logos or UI icons. Login App uses that guidance as a category benchmark only and does not currently adopt Carbon pictogram assets.

## 2. Status and ownership

| Field                   | Value                                                                                   |
| ----------------------- | --------------------------------------------------------------------------------------- |
| Guide status            | Implemented                                                                             |
| System maturity         | Needs audit                                                                             |
| API layer               | Foundation Element API                                                                  |
| Element slug            | pictograms                                                                              |
| Rendered evidence route      | `not installed`                                            |
| Canonical doc           | `docs/02-standards/ui/elements/pictograms.md`                                           |
| Source owner            | `not installed`                                            |
| Asset source            | Gated; no production source approved                                                    |
| Blade API               | None approved                                                                           |
| JavaScript API          | None approved                                                                           |
| CSS namespace           | Reserved app-owned `ui-pictogram*` classes                                              |
| Foundation dependencies | Color, Spacing, Typography, Themes, Motion where animated assets are ever approved      |
| Primary consumers       | Empty state, Data/content Pattern, onboarding/help surfaces, blocked/unavailable states |
| Carbon benchmark        | Carbon Pictograms usage, library, and code guidance                                     |

`Implemented` means the Element standard and Rendered evidence route define the contract. `Needs audit` means production asset source, exact class implementation, source files, and rendered examples must be audited before pictograms can be treated as a fully installed asset API.

## 3. Installed standard

The installed standard is a guarded Foundation Element contract.

Use this standard when a Component or Pattern needs a larger illustrative symbol to support a user-facing state such as no records, onboarding, permission blocked, unavailable content, help content, or explanatory panels.

### 3.1. Current installed disposition:

| Capability                    | Status                     | Production rule                                                                                                                                     |
| ----------------------------- | -------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| Pictogram category definition | Implemented                | Pictograms are larger illustrative assets, not UI icons.                                                                                            |
| Minimum size rule             | Implemented                | Pictograms must not render below 48px.                                                                                                              |
| Empty-state sizing guidance   | Implemented                | Empty, no-results, and onboarding uses generally target 96px to 128px or larger when layout allows.                                                 |
| Productive pictogram default  | Implemented as future rule | If an asset library is approved, productive pictograms are the default for app/product contexts.                                                    |
| Expressive pictogram usage    | Gated                      | Expressive/high-presence pictograms require Pattern or product approval.                                                                            |
| Asset source                  | Gated                      | No Carbon, third-party, stock, AI-generated, or feature-local assets may be imported yet.                                                           |
| Public Blade wrapper          | Not approved               | No `x-ui.pictogram` API is installed.                                                                                                               |
| Public CSS utility classes    | Reserved / needs audit     | `ui-pictogram*` classes may appear in rendered evidence as queued API names, but feature code must not depend on them until implementation is confirmed. |
| rendered evidence placeholders     | Approved for proof only    | The rendered evidence may use neutral placeholder panels to show size, clearance, and theme behavior without pretending an asset is approved.            |

### 3.2. Installed use rules:

- Use pictograms only when a larger visual anchor helps clarify an empty, onboarding, help, blocked, unavailable, explanatory, or no-results moment.
- Prefer no pictogram when text, a small icon, or component status treatment is enough.
- Use productive pictograms by default if an asset library is approved later.
- Use expressive pictograms only for rare, high-presence moments approved by the owning Pattern.
- Keep pictograms secondary to the heading, explanation, and recovery action.
- Do not make pictograms interactive.
- Do not use pictograms as icons in buttons, nav items, badges, alerts, tables, or filters.
- Do not use pictograms as product marks, logos, event marks, or brand lockups.
- Do not import unapproved assets or create local illustration sets.
- Do not recolor, crop, rotate, stretch, distort, animate, or layer pictograms unless a future asset implementation explicitly permits it.
- Component and Pattern consumers must use the approved Element API, not local sizes, classes, colors, or asset paths.

## 4. Token API

Pictogram tokens define size and disposition rules. Because the production asset source is gated, token names are installed as the canonical contract and must be proven in rendered evidence before feature use.

| Token/helper           | Variable or value                                                                             | Status                                | Allowed API/consumer                                            | Example                                               |
| ---------------------- | --------------------------------------------------------------------------------------------- | ------------------------------------- | --------------------------------------------------------------- | ----------------------------------------------------- |
| Minimum pictogram      | `48px`; reserved variable `--ui-pictogram-size-min`                                           | Implemented sizing rule               | Empty state, onboarding, help, blocked states                   | Minimum small explanatory pictogram.                  |
| Small pictogram        | `64px`; reserved variable `--ui-pictogram-size-sm`                                            | Reserved / needs audit                | Compact empty states and help panels after asset approval       | Compact empty-state visual.                           |
| Medium pictogram       | `96px`; reserved variable `--ui-pictogram-size-md`                                            | Reserved / needs audit                | Standard no-results and empty-state panels after asset approval | No-results panel visual.                              |
| Large pictogram        | `128px`; reserved variable `--ui-pictogram-size-lg`                                           | Reserved / needs audit                | Onboarding or larger explanatory states after asset approval    | Onboarding panel visual.                              |
| Extra large pictogram  | `160px+`; reserved variable `--ui-pictogram-size-xl`                                          | Gated                                 | Approved expressive or hero-style explanatory moments           | Large onboarding/help illustration.                   |
| Productive disposition | `productive`                                                                                  | Implemented as future default         | App/product empty, help, and onboarding states                  | Simple, scalable, product-friendly pictogram style.   |
| Expressive disposition | `expressive`                                                                                  | Gated                                 | Rare high-presence moments only                                 | Larger expressive onboarding or announcement visual.  |
| Asset source           | Not approved                                                                                  | Gated                                 | Future ADR required                                             | Do not import unapproved pictograms.                  |
| Color behavior         | Asset-defined or token-backed only                                                            | Gated                                 | Future source implementation                                    | Do not arbitrary-recolor pictograms.                  |
| Clearance              | Minimum one pictogram stroke/body spacing unit around asset; Pattern owns external layout gap | Implemented rule / needs visual proof | Empty states, cards, help panels                                | Pictogram must not crowd headings or container edges. |

Token values are approved sizing boundaries, not permission to use an asset. A feature still needs an approved pictogram asset source before rendering production pictograms.

## 5. CSS variable API

The following CSS variables are the reserved public variable surface for a future implementation. They must not be redefined locally in feature CSS.

```css
--ui-pictogram-size-min
--ui-pictogram-size-sm
--ui-pictogram-size-md
--ui-pictogram-size-lg
--ui-pictogram-size-xl
```

### 5.1. Expected default mapping:

```css
--ui-pictogram-size-min: 48px;
--ui-pictogram-size-sm: 64px;
--ui-pictogram-size-md: 96px;
--ui-pictogram-size-lg: 128px;
--ui-pictogram-size-xl: 160px;
```

### 5.2. Implementation rules:

- Define these variables only in the Foundation Element implementation or app token layer.
- Do not redefine these variables in feature views, Components, or Patterns.
- Do not introduce feature-local variables such as `--empty-illustration-size`, `--onboarding-icon-size`, or `--help-graphic-size`.
- Do not couple pictogram sizing to raw arbitrary values, Bootstrap utilities, or inline styles.
- If the approved implementation changes these values, update this standard, the rendered evidence proof, and regression tests together.

## 6. Utility class/helper API

No production Blade helper or asset-rendering wrapper is approved yet.

### 6.1. Reserved utility classes:

```css
.ui-pictogram
.ui-pictogram--productive
.ui-pictogram--expressive
.ui-pictogram--sm
.ui-pictogram--md
.ui-pictogram--lg
.ui-pictogram--xl
.ui-pictogram--empty
.ui-pictogram--onboarding
.ui-pictogram--help
.ui-pictogram--blocked
.ui-pictogram--no-results
```

### 6.2. Current status:

| API                         | Status                 | Rule                                                                                                                  |
| --------------------------- | ---------------------- | --------------------------------------------------------------------------------------------------------------------- |
| `.ui-pictogram`             | Reserved / needs audit | Base class for approved future pictogram assets. Do not use in feature code until rendered evidence proves implementation. |
| `.ui-pictogram--productive` | Reserved               | Future default style disposition.                                                                                     |
| `.ui-pictogram--expressive` | Gated                  | Future high-presence disposition requiring approval.                                                                  |
| `.ui-pictogram--sm`         | Reserved               | Future 64px class.                                                                                                    |
| `.ui-pictogram--md`         | Reserved               | Future 96px class.                                                                                                    |
| `.ui-pictogram--lg`         | Reserved               | Future 128px class.                                                                                                   |
| `.ui-pictogram--xl`         | Gated                  | Future 160px+ class for approved expressive moments.                                                                  |
| Usage modifiers             | Reserved               | Future app usage hooks only; not a substitute for Pattern ownership.                                                  |
| `x-ui.pictogram`            | Deferred               | Requires approved source file, asset registry, props, accessibility rules, theme behavior, and tests.                 |
| Asset import helper         | Deferred               | Requires ADR, package/source decision, build pipeline, naming rules, and tests.                                       |

Until a production asset source is approved, rendered evidence examples may show neutral placeholder boxes or outlined illustrative containers to prove size, placement, and theme behavior. Those placeholders must be labeled as placeholders and must not be copied into production features as fake pictograms.

## 7. Allowed usage

### 7.1. Use Pictograms when:

- An empty state needs a larger visual anchor to help users understand that no content exists yet.
- A no-results state needs a supportive visual while the heading and recovery action still carry the meaning.
- An onboarding panel needs a simple explanatory visual.
- A blocked, unavailable, or permission-limited state needs a visual to support the explanation.
- A help or explanatory panel needs a lightweight illustration.
- A feature card needs an approved illustrative asset that remains secondary to the heading and action.

### 7.2. Avoid Pictograms when:

- A normal UI icon communicates the meaning at component scale.
- A status icon, badge, alert icon, button icon, nav icon, or table icon is needed.
- A logo, product mark, brand lockup, client logo, or event mark is needed.
- A photo, screenshot, chart, diagram, or product preview is more accurate.
- The graphic would be decorative only and add no meaning.
- The Pattern already communicates the state clearly with text and action.
- The asset source has not been approved.
- The use would require arbitrary recoloring, cropping, distortion, or local editing.

### 7.3. Common app examples:

| App moment              | Pictogram disposition    | Notes                                                              |
| ----------------------- | ------------------------ | ------------------------------------------------------------------ |
| Empty data list         | Productive, medium/large | Use through Empty state/Data-content Pattern after asset approval. |
| No search results       | Productive, medium       | Pair with search/filter recovery actions.                          |
| Onboarding card         | Productive, large        | Keep secondary to heading and next action.                         |
| Help panel              | Productive, small/medium | Use only when visual explanation helps.                            |
| Permission blocked      | Productive, medium       | Pair with plain-language reason and recovery path.                 |
| Major new feature intro | Expressive, gated        | Requires Pattern/product approval.                                 |
| Product header logo     | Not allowed              | Use brand asset rules, not pictograms.                             |
| Button or nav icon      | Not allowed              | Use Icons Element.                                                 |

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, wrappers, or approved asset registry entries. They must not hard-code alternate local values for the same role.

### 8.1. Approved or expected consumers:

| Consumer                           | Route                                          | Usage                                                                                    |
| ---------------------------------- | ---------------------------------------------- | ---------------------------------------------------------------------------------------- |
| Empty state / Data-content Pattern | `not installed` | Empty, blocked, unavailable, and no-results state visuals.                               |
| Interaction Pattern                | `not installed` | No-results recovery visuals where approved by Data-content ownership.                    |
| Layout Pattern                     | `not installed`       | Explanatory panels, feature cards, and onboarding sections.                              |
| Navigation Pattern                 | `not installed`   | Help or onboarding panels only when approved; not nav icons.                             |
| Loading Component                  | `not installed`    | Boundary only; Loading owns skeleton/spinner states, not pictograms.                     |
| Icons Element                      | `not installed`        | Boundary only; Icons handles UI-scale glyphs, not illustrative pictograms.               |
| Color Element                      | `not installed`        | Supplies token-backed color behavior when a source implementation permits color mapping. |
| Spacing Element                    | `not installed`      | Supplies gaps, clearance, and layout spacing around pictogram containers.                |
| Themes Element                     | `not installed`       | Supplies theme context and contrast expectations.                                        |

### 8.2. Consumer rules:

- Patterns own placement, grouping, text/action relationship, and responsive layout.
- Components own their own icons or media slots only when their API explicitly allows pictogram consumption.
- Features own why the state exists and what recovery action is valid.
- Pictograms Element owns size, asset-source disposition, asset treatment, and usage boundaries.

## 9. Theme behavior

Pictograms must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply.

### 9.1. Theme rules:

- Use only approved asset colors or token-backed color roles.
- Do not recolor SVG paths locally for dark mode.
- Do not invert, filter, opacity-hack, or blend pictogram artwork in feature CSS.
- Do not use a pictogram whose contrast or details disappear in a supported theme.
- Do not place pictograms on busy backgrounds.
- Preserve enough surrounding container contrast for the pictogram to remain recognizable.
- If the approved asset source includes theme-specific variants, use the documented variant mapping only.
- If no theme-safe asset exists, omit the pictogram rather than forcing a local edit.

### 9.2. Required rendered evidence theme proof:

| Theme context  | Required proof                                                         |
| -------------- | ---------------------------------------------------------------------- |
| Light          | Pictogram placeholder or approved asset remains legible and secondary. |
| Dark           | Asset or placeholder retains contrast without local recoloring.        |
| Layered/inline | Container spacing and clearance remain readable.                       |
| Inverse        | Asset usage is either proven or marked unsupported/gated.              |
| High contrast  | Shape and meaning are not dependent on subtle color-only differences.  |

## 10. State behavior

Pictograms are non-interactive illustrative assets. They do not own hover, active, selected, focus-visible, disabled, loading, validation, expanded, collapsed, open, or closed states.

| State                      | Status                  | Rule                                                                                                  |
| -------------------------- | ----------------------- | ----------------------------------------------------------------------------------------------------- |
| Default/static             | Implemented rule        | Pictograms are static supportive visuals.                                                             |
| Hover                      | Not applicable          | Do not add hover affordance to pictograms.                                                            |
| Focus-visible              | Not applicable          | Pictograms are not focusable.                                                                         |
| Active/pressed             | Not applicable          | Pictograms are not commands.                                                                          |
| Selected/unselected        | Not applicable          | Pictograms are not selection controls.                                                                |
| Disabled                   | Not applicable          | Disabled state belongs to the owning control or Pattern.                                              |
| Loading                    | Not applicable          | Use Loading, skeleton, or the owning Pattern.                                                         |
| Validation                 | Not applicable          | Use field Components, Forms Pattern, or Notification.                                                 |
| Error/warning/success/info | Not applicable as state | Use Notification, Tag, or status components for semantic feedback.                                    |
| Animated                   | Gated                   | Animated pictograms require Motion Element approval, reduced-motion behavior, and rendered evidence proof. |
| Reduced motion             | Gated                   | Required if animated pictograms are ever approved.                                                    |
| Responsive scaling         | Implemented rule        | Scale only through approved size tokens/classes and preserve aspect ratio.                            |
| Overflow/crop              | Not allowed             | Do not crop, mask, or truncate pictograms.                                                            |

## 11. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, inline styles, local CSS variables, or custom design tokens.
- Do not import Carbon pictograms, third-party pictograms, stock illustrations, AI-generated artwork, or local SVG/PNG assets without an approved asset decision.
- Do not use pictograms as UI icons, status icons, button icons, nav icons, menu icons, table icons, or badges.
- Do not use pictograms as logos, product marks, client marks, event marks, lockups, or brand graphics.
- Do not use pictograms for decorative emphasis only.
- Do not use pictograms as the only way to communicate meaning.
- Do not place pictograms before critical instructions when that harms scanning or task completion.
- Do not use expressive pictograms by default.
- Do not overuse expressive pictograms in productive app workflows.
- Do not crop, stretch, rotate, skew, mirror, distort, outline, shadow, blur, filter, opacity-hack, or arbitrarily recolor pictograms.
- Do not combine multiple pictograms into a custom composition unless a future asset system permits it.
- Do not create local sizes below 48px.
- Do not use raw `img` tags or inline SVG for pictograms in feature views without an approved wrapper/registry.
- Do not expose decorative pictograms to assistive technology when adjacent text provides the meaning.
- Do not use pictograms in loading, validation, notification, or status contexts where another Component owns the role.
- Do not create broad illustration-library corrections from this standard.

## 12. Deferred or gated capabilities

| Capability                            | Status       | Gate                                                                                                                                                                 |
| ------------------------------------- | ------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Production asset library              | Gated        | Requires ADR/source decision, license review, asset inventory, naming convention, build pipeline, theme proof, and rendered evidence examples.                            |
| Carbon pictogram adoption             | Gated        | Requires explicit decision to adopt Carbon assets, package/source choice, license review, import path, tree-shaking/build proof, and no direct Carbon class leakage. |
| Custom Login App pictogram set        | Gated        | Requires art direction, asset ownership, export standards, accessibility review, and implementation plan.                                                            |
| Public `x-ui.pictogram` Blade wrapper | Deferred     | Requires source file, asset registry, props, size mapping, alt/decorative behavior, theme behavior, and tests.                                                       |
| Public asset registry/helper          | Deferred     | Requires approved source, namespaced identifiers, missing-asset fallback, build validation, and tests.                                                               |
| Expressive pictograms                 | Gated        | Requires product/Pattern approval, large-size context, usage limit, theme proof, and rendered evidence example.                                                           |
| Animated pictograms                   | Gated        | Requires Motion Element approval, reduced-motion fallback, pause/stop behavior if needed, and tests.                                                                 |
| Theme-specific pictogram variants     | Gated        | Requires source support, token mapping, and visual regression proof.                                                                                                 |
| AI-generated pictograms               | Not approved | Requires legal/source review, editorial approval, asset standard, and repeatability rules.                                                                           |
| Inline SVG editing                    | Not approved | Requires approved wrapper and path-level styling policy.                                                                                                             |
| Additional sizes                      | Gated        | Requires Spacing Element update, rendered evidence proof, and regression tests.                                                                                           |

New reusable illustration capability belongs in this Element doc only after a concrete app use case and source decision exist.

## 13. Rendered evidence requirements

The rendered evidence page must render Element proof, not abstract notes only. Because production assets are gated, the page must explicitly show the queued asset-library disposition instead of fake complete pictograms.

Required proof:

| Required proof                      | Rendered behavior                                                                                                                             | Variants/options shown                                          |
| ----------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| API status proof                    | Page states that Pictograms is implemented as a Foundation Element standard, system maturity is Needs audit, and production assets are gated. | Implemented, Needs audit, Gated asset source                    |
| Queued library disposition          | Page shows asset-source decision is pending and no Carbon/third-party/local assets are approved.                                              | Asset source, ADR required, Prohibited imports                  |
| Size examples                       | Placeholder containers or approved future examples show minimum and common pictogram sizes.                                                   | 48px minimum, 64px, 96px, 128px, 160px+ gated                   |
| Productive vs expressive comparison | Page explains productive as the future default and expressive as gated.                                                                       | Productive, Expressive, Gated expressive                        |
| Container examples                  | Empty, onboarding, help, blocked, and no-results containers show where pictograms may appear.                                                 | Empty state, Onboarding, Help, Blocked, No results              |
| Clearance demo                      | Page shows required spacing around a pictogram container and relationship to heading/body/action.                                             | Clearance, Heading gap, Action separation                       |
| Theme background examples           | Page shows light, dark, layered, inverse, and high-contrast disposition.                                                                      | Light, Dark, Layered, Inverse gated, High contrast              |
| App usage examples                  | Page links pictogram use to Data-content/Empty state and Interaction no-results Patterns.                                                     | Empty state, Data-content, Interactions                         |
| Boundary comparison                 | Page distinguishes pictograms from Icons, logos, photos, screenshots, charts, and decorative art.                                             | Pictogram vs Icon, Logo, Media, Chart                           |
| Accessibility proof                 | Page documents decorative treatment, adjacent text meaning, non-focusable behavior, contrast/theme expectations, and no color-only meaning.   | `aria-hidden`, Adjacent text, Non-focusable, Contrast           |
| Prohibited usage proof              | Page shows UI icon misuse, logo misuse, cropped/distorted artwork, unapproved imports, and arbitrary recolor as prohibited.                   | Icons, Logos, Cropping, Recoloring, Imports                     |
| Deferred gate proof                 | Page shows trigger conditions for asset library, Carbon adoption, wrapper, registry, expressive, animated, and theme-specific variants.       | Asset library, `x-ui.pictogram`, Registry, Expressive, Animated |
| Token/API references                | Page lists the reserved CSS variables, size rules, and utility class names.                                                                   | `--ui-pictogram-*`, `ui-pictogram*`                             |
| Related APIs                        | Page links consuming Patterns, Icons Element, and canonical doc.                                                                              | Data-content, Interactions, Icons, Canonical doc                |

The page must not present placeholder boxes as approved assets. It must label placeholders as sizing and disposition proof only.

## 14. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page identifies Pictograms as a Foundation Element API.
- The page identifies Guide status as `Implemented` and System maturity as `Needs audit`.
- The page states that production asset source is gated.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page shows 48px as the minimum pictogram size.
- The page shows 96px to 128px+ as common large empty-state/onboarding sizing.
- The page distinguishes productive from expressive disposition and marks expressive usage as gated.
- The page distinguishes pictograms from UI icons, logos, photos, screenshots, charts, and decorative art.
- The page shows theme behavior expectations for light, dark, layered, inverse, and high-contrast contexts.
- The page links to consuming Component and Pattern standards.
- Deferred capabilities are represented with trigger conditions and prohibited local workarounds.
- No rendered evidence example imports unapproved assets, direct Carbon assets, third-party pictograms, feature-local SVGs, or fake production artwork.
- No example uses pictograms as button icons, nav icons, logos, status icons, or loading indicators.
- No example hard-codes Foundation Element decisions that already have approved APIs.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent unless they are intentionally part of the approved UI copy.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap utility-only examples, hard-coded colors, arbitrary spacing, inline SVG path edits, or feature-local pictogram classes are presented as approved.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Pictograms');
$response->assertSee('Foundation Element API');
$response->assertSee('Implemented');
$response->assertSee('Needs audit');
$response->assertSee('Asset source');
$response->assertSee('Gated');
$response->assertSee('48px');
$response->assertSee('96px');
$response->assertSee('128px');
$response->assertSee('Productive');
$response->assertSee('Expressive');
$response->assertSee('ui-pictogram');
$response->assertSee('--ui-pictogram-size-min');
$response->assertSee('Empty state');
$response->assertSee('No results');
$response->assertSee('Icons element');
$response->assertSee('Do not import unapproved pictograms');
$response->assertSee('Do not use pictograms as UI icons');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('@carbon/pictograms');
$response->assertDontSee('<svg');
```

## 15. Related APIs

| API                                | Route                                                              |
| ---------------------------------- | ------------------------------------------------------------------ |
| Foundation Elements overview       | `not installed`                                  |
| Empty state / Data-content Pattern | `not installed`                     |
| Interaction Pattern                | `not installed`                     |
| Layout Pattern                     | `not installed`                           |
| Icons Element                      | `not installed`                            |
| Color Element                      | `not installed`                            |
| Spacing Element                    | `not installed`                          |
| Typography Element                 | `not installed`                       |
| Themes Element                     | `not installed`                           |
| Motion Element                     | `not installed`                           |
| Loading Component                  | `not installed`                        |
| Notification Component             | `not installed`                   |
| Canonical pictograms doc           | `/platform/docs?path=02-standards%2Fui%2Felements%2Fpictograms.md` |
| Carbon pictograms usage            | `https://carbondesignsystem.com/elements/pictograms/usage/`        |
| Carbon pictograms library          | `https://carbondesignsystem.com/elements/pictograms/library/`      |
| Carbon pictograms code             | `https://carbondesignsystem.com/elements/pictograms/code/`         |

## 16. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Pictograms usage, library, and code guidance inform the category distinction between pictograms and UI icons, productive-versus-expressive disposition, minimum 48px sizing, large explanatory usage, logo/icon prohibitions, and possible package-based implementation. Login App does not currently adopt Carbon pictogram assets and keeps asset sourcing gated until a concrete implementation decision is approved.
