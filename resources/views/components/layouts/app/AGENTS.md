# resources/views/components/layouts/app AGENTS.md

## Purpose

Private layout tree for the `x-layouts.app` anonymous component. This folder owns shared layout structure and app-frame adapters, not page-specific behavior.

## Read Order

1. Start with `../app.blade.php` to see shell state and include order.
2. Open only the partial tied to the change:
   - `partials/head.blade.php` for metadata, theme boot payload usage, Livewire styles, or Vite assets.
   - `partials/header.blade.php` for app header data handoff into `x-layouts.app.frame.header`.
   - `partials/header-panels.blade.php` for Frame-owned app header panels composed through `x-layouts.app.frame.header.panels`.
   - `partials/authenticated-main.blade.php` for authenticated layout composition, `x-layouts.app.frame.sidebar`, and `x-shell.content`.
   - `partials/guest-main.blade.php` for unauthenticated page layout.
3. For app header, account menu, search, or sidebar composition, read `frame/AGENTS.md`. Notification header actions are module-owned contributions.

## Avoid

- Do not put feature-page markup in shell partials.
- Do not merge these partials back into the root layout component.
- Do not recreate layout-owned account-menu, notification-menu, sidebar, or mobile-sidebar fragments outside `partials/*`, `frame/*`, or reusable `components/shell/*` primitives.
