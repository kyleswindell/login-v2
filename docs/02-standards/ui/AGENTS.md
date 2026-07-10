# docs/02-standards/ui AGENTS.md
- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. UI API Standards Preflight](#3-ui-api-standards-preflight)
- [4. Avoid](#4-avoid)
- [5. Split Rule](#5-split-rule)

## 1. Purpose

UI standards only. This folder owns final Login App UI API expectations for Foundation Elements, Components, Patterns, and the stable UI API inventory.

Standards define public API contracts, allowed tokens/classes/helpers/components, supported variants/options/states, prohibited usage, deferred gates, Rendered evidence requirements, and testing expectations. rendered evidence pages are the live rendered proof of these standards.

Implementation progress, queue state, review state, and worklog status belong in `docs/08-active/`, not in this standards folder.

## 2. Read Order

1. Read `index.md` for UI standards navigation.
2. Read `api-registry.md` to confirm API ownership, disposition, route, source surface, and planned gaps.
3. For Foundation Elements, read `elements/index.md` and then the specific `elements/{element}.md` standard.
4. For Components, read `components/index.md` and then the specific `components/{component}.md` standard.
5. For Patterns, read `patterns/index.md`, `patterns/checklist.md`, and only the relevant `patterns/{pattern}.md` standard.
6. For color/theme token work, read `elements/color.md`, `elements/themes.md`, and `api-registry.md` for the current token ownership map.
7. For current build/review progress, switch to `docs/08-active/ui-implementation-sync.md` and the active queue/worklog.

## 3. UI API Standards Preflight

Before any UI source or rendered evidence edit, identify the primary UI API standard for the surface being changed and read that standard's table of contents. Then read these sections when present:

- `Related APIs`
- `Token, class, and helper usage`
- `Accessibility contract`
- `Content contract`
- `Rendered evidence requirements`
- `Implementation and Rendered Evidence Checklist`

Open related API standards when the requested change touches those dependencies. For example, sidebar navigation work must check the Navigation or Layout Pattern standard plus related Motion, Icons, Spacing, Typography, Color, and Theme Element standards as applicable.

Inspect the installed source API and any current rendered evidence live examples before editing. If the primary standard or `Related APIs` section is missing enough behavior guidance for a behavior-heavy UI change, stop and queue a standards gap instead of inventing local behavior.

Active UI worklogs must include a `UI API Standards Preflight` section with: primary API, standards reviewed, related APIs consulted, Foundation Elements consumed, source/live examples inspected, motion/accessibility/layout requirements, and visual-review notes.

## 4. Avoid

- Do not read every UI standard by default.
- Do not treat reference/audit material as rules unless this standards folder adopts it.
- Do not store active progress statuses here, including in progress, pending review, pending correction, passed review, or worklog-only notes.
- Do not add generic placeholder examples to implemented API standards.
- Do not write abstract design essays where an installed API contract is required.
- Do not reintroduce deleted transitional `contracts/` or stale UI UX component/taxonomy files.
- Do not edit UI source from memory when the relevant UI API standard has `Related APIs` and checklist sections available.

## 5. Split Rule

Keep canonical standards flat by default:

- `elements/{element}.md`
- `components/{component}.md`
- `patterns/{pattern}.md`

Split a single standard into child pages such as `usage.md`, `style.md`, or `accessibility.md` only after that specific standard becomes too large to review safely as one file.
