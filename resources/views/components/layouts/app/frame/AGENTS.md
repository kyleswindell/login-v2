# resources/views/components/layouts/app/frame AGENTS.md

## Purpose

Private app-frame adapters consumed by `x-layouts.app`. These files compose app navigation, header actions, account controls, search, and sidebar content from lower-level `x-shell.*` primitives.

## Read Order

1. Start with `header/index.blade.php` for the app header composition.
2. Read `sidebar.blade.php` and `nav-link.blade.php` for app navigation composition.
3. Read `header/*.blade.php` for header actions, account menu, Frame-owned panels, or search.

## Avoid

- Do not create public reusable patterns in this folder.
- Do not redefine shell primitives here; compose `x-shell.*` instead.
- Do not move module-owned header action views into this folder.
