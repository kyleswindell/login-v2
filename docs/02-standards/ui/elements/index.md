# Foundation Elements API Standards

Foundation Elements are the lowest-level UI APIs. They define visual primitives before Components and Patterns compose them.

Use this index for quick lookup. The owning `elements/{element}.md` file remains the full standard.
- [1. Element Matrix](#1-element-matrix)
- [2. API Contract](#2-api-contract)
- [3. UI Reference Contract](#3-ui-reference-contract)
- [4. Element Checklist Template](#4-element-checklist-template)
  - [4.1. Implementation checklist](#41-implementation-checklist)
  - [4.2. UI Reference proof checklist](#42-ui-reference-proof-checklist)
- [5. Related](#5-related)

## 1. Element Matrix

| Element             | Disposition  | API / token families                                                                        | UI Reference route                             | Primary consumers                                      | Deferred gates                                       |
| ------------------- | ------------ | ------------------------------------------------------------------------------------------- | ---------------------------------------------- | ------------------------------------------------------ | ---------------------------------------------------- |
| 2x Grid             | Approved API | page grid, responsive columns, content regions, layout alignment                            | `/platform/ui-reference/elements/2x-grid`      | Layout, navigation, data/content, page shells          | None                                                 |
| Color               | Approved API | background, layer, field, border, text, link, icon, support, focus, skeleton, syntax tokens | `/platform/ui-reference/elements/color`        | All Components and Patterns                            | New role tokens require Color Token Palette update   |
| Color token palette | Approved API | full color token role matrix                                                                | `/platform/ui-reference/elements/color/tokens` | Component and Pattern token adoption                   | New token families require registry update           |
| Icons               | Approved API | Heroicons source, sizing, alignment, status icon rules, hit target rules                    | `/platform/ui-reference/elements/icons`        | Buttons, links, menus, status, navigation              | Carbon icons require separate decision               |
| Motion              | Approved API | productive transition rules, reduced motion, component-owned motion boundaries              | `/platform/ui-reference/elements/motion`       | Accordion, menu, modal, tooltip, loading, notification | Expressive motion remains gated                      |
| Pictograms          | Deferred API | pictogram disposition, size, clearance, library audit rules                                 | `/platform/ui-reference/elements/pictograms`   | Empty states, onboarding, help surfaces                | Asset library decision required before import        |
| Spacing             | Approved API | spacing scale, stack, gap, internal/external spacing ownership                              | `/platform/ui-reference/elements/spacing`      | All Components and Patterns                            | Arbitrary spacing exceptions require owner doc       |
| Themes              | Approved API | theme role/value behavior, light/dark contexts, inline theme rules                          | `/platform/ui-reference/elements/themes`       | All tokenized Components and Patterns                  | New theme override requires documented reason/source |
| Typography          | Approved API | font stacks, type roles, scale, weights, code text, text color usage                        | `/platform/ui-reference/elements/typography`   | All text-bearing Components and Patterns               | New type roles require Typography standard update    |
| Typography type sets | Approved API | Productive Type Set, Expressive Type Set, fixed productive headings, fluid expressive headings | `/platform/ui-reference/elements/typography/type-sets` | Components and Patterns that render text hierarchy | IBM Plex adoption and additional display roles remain gated |

## 2. API Contract

Each Element standard must define:

- API summary
- status and ownership
- installed standard
- token API
- CSS variable API
- utility class/helper API
- allowed usage
- component and pattern consumers
- theme behavior
- state behavior
- prohibited usage
- deferred or gated capabilities
- UI Reference requirements
- testing and acceptance criteria
- related APIs
- references

## 3. UI Reference Contract

Every Element page must show purpose, live examples, token/class/API references, usage guidance, accessibility notes, developer notes, related implementation links, and implementation disposition.

Element pages distinguish guide readiness from underlying system maturity when that distinction is useful, but active build/review progress belongs in `docs/08-active/`.

## 4. Element Checklist Template

Every Element standard must include `## Implementation and UI Reference Checklist`.

### 4.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | Name the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | List the durable Element API surface that Components and Patterns may consume.                                      |
| Theme/state behavior        | Define light/dark, interaction, reduced-motion, accessibility, or state rules owned by the Element.                 |
| Consumers                   | Name the Component and Pattern APIs that must consume this Element.                                                 |
| Prohibited usage            | State what feature code, Components, and Patterns must not redefine locally.                                        |
| Tests                       | Define route/content/API assertions that prove the Element contract.                                                |

### 4.2. UI Reference proof checklist

| Requirement          | Visual proof expectation                                                                                     |
| -------------------- | ------------------------------------------------------------------------------------------------------------ |
| Live examples        | Show rendered examples with app CSS/JS, not screenshots only.                                                |
| Token/API references | Show token/class/helper names and example usage.                                                             |
| Theme/state examples | Show relevant theme contexts, variants, states, or gated disposition surfaces.                               |
| Accessibility proof  | Show or document contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints. |
| Related APIs         | Link consuming Components, Patterns, source files, and the canonical standard.                               |
| Manual review        | Provide enough rendered proof for visual review without opening source code first.                           |

## 5. Related

- [UI Standards Index](../index.md)
- [UI API Registry](../api-registry.md)
- [Component API Standards](../components/index.md)
- [Pattern API Standards](../patterns/index.md)
