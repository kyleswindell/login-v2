# UI Standards Index
- [1. Layer Map](#1-layer-map)
- [2. API Registry](#2-api-registry)
- [3. Contract File](#3-contract-file)
- [4. Reference File](#4-reference-file)
- [5. UI Testing](#5-ui-testing)
- [6. Where To Go](#6-where-to-go)
- [7. Standards Rules](#7-standards-rules)
- [8. Required UI API Checklist](#8-required-ui-api-checklist)
- [9. Related](#9-related)

This folder defines the final Login App 2.0 UI API expectations. It is not the active implementation progress tracker.

Use this index to locate the correct Element, Component, or Pattern standard before adding UI, changing a public API, or updating a rendered evidence proof page.

`UI API` is the shared term for any Foundation Element API, Component API, or Pattern API. Each UI API standard must define the final contract and the required rendered evidence proof for that API.

## 1. Layer Map

| Layer               | Owns                                                                                         | Canonical folder                  | rendered evidence root                   |
| ------------------- | -------------------------------------------------------------------------------------------- | --------------------------------- | ----------------------------------- |
| Foundation Elements | Tokens, grid, spacing, typography, color, iconography, motion, themes, pictogram disposition | [elements](elements/index.md)     | `not installed`   |
| Components          | Primitive and baseline reusable UI APIs                                                      | [components](components/index.md) | `not installed` |
| Patterns            | Reusable compositions that coordinate Elements and Components                                | [patterns](patterns/index.md)     | `not installed`   |

Components consume Elements. Patterns compose Components and consume Elements. Feature modules consume Patterns and Components; they must not redefine lower-level UI rules locally.

## 2. API Registry

[UI API Registry](api-registry.md) is the durable source-of-inventory for UI APIs and planned API gaps.

Use the registry to answer:

- whether a UI API name is approved, deferred, prohibited, represented by a Pattern, or a planned registry gap
- which standards doc owns the API contract
- which Rendered evidence route proves the API, when a route exists
- which source surface is expected to implement or expose the API
- where planned API names first appeared

The registry is not active work progress. Current implementation/review tracking lives in `docs/08-active/`.

## 3. Contract File

The `contract.php` convention is the target state for every approved UI standard, including surfaces hidden from rendered evidence navigation. The rollout is still in progress. Until a surface has a real `contract.php`, treat the installed Blade source and its existing `docs.php` metadata as transitional source inventory, not as a reason to reject or de-approve the current component.

Contracts are additive first and restrictive later: a contract means the surface is tracked, while approved lifecycle status is what allows strict enforcement.

- [UI contract.php File](contract-file.md)

## 4. Reference File

The `reference.php` convention is the target state for rendered evidence display definitions. A contract may exist for a hidden child, alias, skeleton, internal helper, Pattern-owned surface, or inventory-only surface without creating a visible rendered evidence page.

rendered evidence visibility, overview cards, side navigation, route slugs, owner-tab placement, rendered examples, display tabs, and page sections are controlled by `reference.php`, not by contract registration.

Missing `reference.php`, or missing explicit page mode, means `inventory-only`.

- [rendered evidence.php File](reference-file.md)

## 5. UI Testing

[UI Testing Standards](testing.md) defines the co-located test convention for Foundation Elements and Components.

[UI Test Requirements](test-requirements/index.md) is the implementation-facing checklist layer for Element, Component, and Pattern test criteria.

## 6. Where To Go

| Need                                                                            | Start here                                 | Then read                                            |
| ------------------------------------------------------------------------------- | ------------------------------------------ | ---------------------------------------------------- |
| Token, color, spacing, grid, icon, motion, theme, pictogram, or type rule       | [Elements index](elements/index.md)        | [Token governance](elements/tokens.md), [Element test requirements](test-requirements/elements.md), and the specific `elements/{element}.md` standard |
| Button, input, menu, table, modal, notification, tabs, or other primitive API   | [Components index](components/index.md)    | The specific `components/{component}.md` standard    |
| Form, layout, navigation, overlay, feedback, validation, or content composition | [Patterns index](patterns/index.md)        | The specific `patterns/{pattern}.md` standard        |
| Unsure whether an API exists or is planned                                      | [UI API Registry](api-registry.md)         | The owning Element, Component, or Pattern standard   |
| Defining what rendered evidence renders or hides                                     | [rendered evidence.php File](reference-file.md) | The owner-local `reference.php` beside the surface   |
| Current build/review state                                                      | `docs/08-active/ui-implementation-sync.md` | `docs/08-active/change-queue.md` and current worklog |

## 7. Standards Rules

- Standards describe final API expectations, approved usage, prohibited usage, accessibility/content contracts, Rendered evidence requirements, and tests.
- Standards may mark a capability as `Deferred API`, `Do not implement`, `Represented by pattern`, or `Planned registry gap` when that is a durable API disposition.
- Standards must not track volatile queue state such as in progress, pending review, pending correction, or passed review.
- rendered evidence pages are the live rendered proof of standards. They must consume installed app APIs rather than reference-only markup.
- rendered evidence display decisions must come from `reference.php`; contract registration alone must not create visible pages.
- For Component source accuracy, the current installed Blade source under `resources/views/components/ui/{component}/index.blade.php` is the source truth. References to deleted flat files such as `resources/views/components/ui/{component}.blade.php` are stale cleanup candidates unless that file exists.
- For Pattern helper source accuracy, use `resources/views/components/patterns/*.blade.php`.
- For Icons, the internal Blade icon library under `resources/views/components/icons/` is the primary source. External icon libraries are placeholders only when no suitable internal icon exists yet.

## 8. Required UI API Checklist

Every Element, Component, and Pattern standard must include a section named `Implementation and Rendered Evidence Checklist`.

That section must include:

- `Implementation checklist`: durable build requirements for the API/source, variants/options, states, accessibility, content, tokens/classes/helpers, and tests.
- `rendered evidence proof checklist`: durable visual-review requirements for live examples, rendered variants/states, developer snippets, deferred gates, related APIs, and manual review coverage.

Use requirement language in standards. Track current completion state in `docs/08-active/ui-implementation-sync.md`.

## 9. Related

- [Documentation standards](../index.md)
- [UI contract.php File](contract-file.md)
- [rendered evidence.php File](reference-file.md)
- [UI Testing Standards](testing.md)
- [UI Test Requirements](test-requirements/index.md)
- [Token Governance](elements/tokens.md)
- [Carbon comparison and support notes](../../09-reference/ui/)
- [Active Batch F queue](../../08-active/change-queue.md)
