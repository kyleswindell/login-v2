# resources/views/components/layouts/app AGENTS.md

## Purpose

Partialized shell for the `x-layouts.app` anonymous component. These files own shared layout structure, not page-specific behavior.

## Read Order

1. Start with `../app.blade.php` to see shell state and include order.
2. Open only the partial tied to the change:
   - `head.blade.php` for metadata, theme boot payload usage, Livewire styles, or Vite assets.
   - `realtime-notifications.blade.php` for realtime notification hooks and toast containers.
   - `header.blade.php` for the top shell bar and header composition.
   - `notification-menu.blade.php` for recent-notification dropdown behavior.
   - `account-menu.blade.php` for account navigation, theme controls, or logout.
   - `authenticated-main.blade.php` and `sidebar.blade.php` for authenticated shell layout and navigation panels.
   - `guest-main.blade.php` for unauthenticated page layout.
3. Cross-check `mobile-sidebar.blade.php` only when mobile navigation behavior is affected.

## Avoid

- Do not put feature-page markup in shell partials.
- Do not merge these partials back into the root layout component.
- Do not read every layout partial for a narrow notification, account-menu, or sidebar change.
