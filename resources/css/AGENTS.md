# resources/css AGENTS.md

## Purpose

CSS source for the app-owned UI system, Tailwind theme seed overrides, compatibility overrides, and UI Reference proof styling.

## Read Order

1. Read the ownership map at the top of `app.css`.
2. For Tailwind font or slate seed overrides, read `ui/theme-seed.css`.
3. For component CSS, search `app.css` for the specific selector family named in the ownership map before opening broad ranges.
4. For build-path questions, check `vite.config.js` and `resources/views/components/layouts/app/head.blade.php`.

## Avoid

- Do not add new color, spacing, radius, typography, or component variant tokens without an owning standard or queue item.
- Do not move broad CSS sections unless a build passes and the visual contract is behavior-preserving.
- Do not treat compatibility overrides as new component styling; they only bridge existing utility-heavy markup across theme modes.
