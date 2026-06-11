# UI Standards Index
- [1. Layer Map](#1-layer-map)
- [2. API Registry](#2-api-registry)
- [3. Where To Go](#3-where-to-go)
- [4. Standards Rules](#4-standards-rules)
- [5. Required UI API Checklist](#5-required-ui-api-checklist)
- [6. Related](#6-related)

This folder defines the final Login App 2.0 UI API expectations. It is not the active implementation progress tracker.

Use this index to locate the correct Element, Component, or Pattern standard before adding UI, changing a public API, or updating a UI Reference proof page.

`UI API` is the shared term for any Foundation Element API, Component API, or Pattern API. Each UI API standard must define the final contract and the required UI Reference proof for that API.

## 1. Layer Map

| Layer               | Owns                                                                                         | Canonical folder                  | UI Reference root                   |
| ------------------- | -------------------------------------------------------------------------------------------- | --------------------------------- | ----------------------------------- |
| Foundation Elements | Tokens, grid, spacing, typography, color, iconography, motion, themes, pictogram disposition | [elements](elements/index.md)     | `/platform/ui-reference/elements`   |
| Components          | Primitive and baseline reusable UI APIs                                                      | [components](components/index.md) | `/platform/ui-reference/components` |
| Patterns            | Reusable compositions that coordinate Elements and Components                                | [patterns](patterns/index.md)     | `/platform/ui-reference/patterns`   |

Components consume Elements. Patterns compose Components and consume Elements. Feature modules consume Patterns and Components; they must not redefine lower-level UI rules locally.

## 2. API Registry

[UI API Registry](api-registry.md) is the durable source-of-inventory for UI APIs and planned API gaps.

Use the registry to answer:

- whether a UI API name is approved, deferred, prohibited, represented by a Pattern, or a planned registry gap
- which standards doc owns the API contract
- which UI Reference route proves the API, when a route exists
- which source surface is expected to implement or expose the API
- where planned API names first appeared

The registry is not active work progress. Current implementation/review tracking lives in `docs/08-active/`.

## 3. Where To Go

| Need                                                                            | Start here                                 | Then read                                            |
| ------------------------------------------------------------------------------- | ------------------------------------------ | ---------------------------------------------------- |
| Token, color, spacing, grid, icon, motion, theme, pictogram, or type rule       | [Elements index](elements/index.md)        | The specific `elements/{element}.md` standard        |
| Button, input, menu, table, modal, notification, tabs, or other primitive API   | [Components index](components/index.md)    | The specific `components/{component}.md` standard    |
| Form, layout, navigation, overlay, feedback, validation, or content composition | [Patterns index](patterns/index.md)        | The specific `patterns/{pattern}.md` standard        |
| Unsure whether an API exists or is planned                                      | [UI API Registry](api-registry.md)         | The owning Element, Component, or Pattern standard   |
| Current build/review state                                                      | `docs/08-active/ui-implementation-sync.md` | `docs/08-active/change-queue.md` and current worklog |

## 4. Standards Rules

- Standards describe final API expectations, approved usage, prohibited usage, accessibility/content contracts, UI Reference requirements, and tests.
- Standards may mark a capability as `Deferred API`, `Do not implement`, `Represented by pattern`, or `Planned registry gap` when that is a durable API disposition.
- Standards must not track volatile queue state such as in progress, pending review, pending correction, or passed review.
- UI Reference pages are the live rendered proof of standards. They must consume installed app APIs rather than reference-only markup.

## 5. Required UI API Checklist

Every Element, Component, and Pattern standard must include a section named `Implementation and UI Reference Checklist`.

That section must include:

- `Implementation checklist`: durable build requirements for the API/source, variants/options, states, accessibility, content, tokens/classes/helpers, and tests.
- `UI Reference proof checklist`: durable visual-review requirements for live examples, rendered variants/states, developer snippets, deferred gates, related APIs, and manual review coverage.

Use requirement language in standards. Track current completion state in `docs/08-active/ui-implementation-sync.md`.

## 6. Related

- [Documentation standards](../index.md)
- [Carbon comparison and support notes](../../09-reference/ui/)
- [Active Batch F queue](../../08-active/change-queue.md)
