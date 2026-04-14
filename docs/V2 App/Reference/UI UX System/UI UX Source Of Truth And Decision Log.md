# UI UX Source Of Truth And Decision Log

## Purpose

Define the external guidance sources, adaptation rules, and explicit decision register for Login V2 UI/UX standards.

This note is the canonical source-of-truth owner for UI/UX decision governance.

## Implementation Status

Current status:

- canonical owner note created for UI/UX decision governance
- Material Design and IBM Carbon reference review started
- Phase 2 planning owner note created and linked
- initial decision backlog and lock workflow defined
- component-level implementation lock decisions are in progress
- accessibility baseline is locked to WCAG 2.2 AA
- initial theme/shape/icon direction is locked (subtle radius, neutral enterprise default, Heroicons)
- canonical standards notes for color, typography, and iconography are now established

## External Source Baseline

Primary design references for this program:

- Material Design (M2 request scope): `https://m2.material.io`
- Material Design static docs archive used for text-accessible review in Codex runtime: `https://m1.material.io`
- IBM Carbon Design System: `https://carbondesignsystem.com`

Runtime note:

- `m2.material.io` pages are JavaScript-rendered in this environment, so detailed extraction used text-accessible Material documentation pages and M2 typography tooling where available.
- when a standard below is inferred from Material archive content instead of directly scraped M2 pages, it is marked as `Inference`.
- these source notes are intended to serve as both theory references and concrete implementation examples for Login V2 adaptation work.

## Adaptation Rules

Use this hierarchy when standards conflict:

1. product constraints and accessibility requirements for Login V2
2. locked stack/architecture constraints in V2 canonical docs
3. Carbon accessibility and enterprise rigor patterns
4. Material system guidance (M2 intent and interaction model)
5. local historical styling conventions

## Decision Register

Decision status values:

- `Draft`
- `Proposed`
- `Locked`

### Foundation decisions

1. Design principles set (`Proposed`)
2. Base spacing scale and layout grid (`Proposed`)
3. Typography families and type scale (`Locked`: canonical typography standard established)
4. Corner radius scale (`Locked`: subtle `4/6/8` baseline)
5. Elevation/shadow model (`Draft`)
6. Motion durations/easing/curve set (`Draft`)
7. Icon library and icon sizing rules (`Locked`: Material-style semantics + Heroicons; canonical iconography standard established)
8. Light/dark semantic theme tokens (`Proposed`: canonical token architecture is documented)
9. State and feedback colors (success/info/warning/danger) (`Proposed`)
10. Accessibility target level (`Locked`: WCAG 2.2 AA minimum)
11. Baseline color strategy (`Locked`: neutral enterprise with restrained accent)
12. Theme customization direction (`Proposed`: tenant/theme palette values stored in DB-backed token map with derived ramps)

### UX consistency decisions

1. Navigation hierarchy and persistent shell rules (`Draft`)
2. Primary vs secondary action placement rules (`Draft`)
3. Destructive action confirmation model (`Draft`)
4. Toast/loader feedback timing standards (`Draft`)
5. Empty state content framework (`Draft`)

### Component behavior decisions

1. Drawer/modal/side-panel selection rules (`Draft`)
2. Table filter/sort/pagination interaction model (`Draft`)
3. Form validation, inline errors, and submit lifecycle (`Draft`)
4. Menu and submenu interaction model (`Draft`)
5. Mobile navigation and responsive shell standards (`Draft`)

## Lock Workflow

Before moving a decision to `Locked`, complete all checks:

1. Accessibility check documented (contrast, focus, keyboard, screen reader implications)
2. Light/dark behavior documented with token mapping
3. Desktop/tablet/mobile behavior documented
4. Example implemented in `/platform/ui-reference` or equivalent reference surface
5. Canonical and planning notes updated in the same cycle

## Locked Decisions (Current)

1. Accessibility baseline: WCAG 2.2 AA is mandatory for all surfaces.
2. Typography baseline is canonicalized in `UI UX Typography Standards`.
3. Radius baseline: subtle corner system (`4/6/8`) is the default.
4. Color baseline: neutral enterprise with restrained accent is the default.
5. Icon baseline: Material-style semantics with Heroicons as the icon library.
6. Source docs role: docs must include both theory references and concrete interaction/component implementation examples.

## Planning Source

- [[V2 App/Planning/Phase 2/Phase 2 - UI UX System Baseline Planning]] | [Phase 2 - UI UX System Baseline Planning](../../Planning/Phase%202/Phase%202%20-%20UI%20UX%20System%20Baseline%20Planning.md)

## Related

- [[V2 App/Reference/UI UX System/UI UX Foundations And Theming Standards]] | [UI UX Foundations And Theming Standards](UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Color Token Standards]] | [UI UX Color Token Standards](UI%20UX%20Color%20Token%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Typography Standards]] | [UI UX Typography Standards](UI%20UX%20Typography%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Iconography Standards]] | [UI UX Iconography Standards](UI%20UX%20Iconography%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Component Library Standards]] | [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
- [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](../UI%20Design%20System%20Standards.md)
