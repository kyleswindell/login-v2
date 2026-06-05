# resources/views/platform/ui-reference/index AGENTS.md

## Purpose

UI Reference workspace landing page partials. These files back the `/platform/ui-reference` route and should stay split by the visible section they render.

## Read Order

1. Start with `../index.blade.php` to see the include order.
2. Open only the partial for the section being changed:
   - `overview.blade.php` for the page header and baseline cards.
   - `action-tokens.blade.php` for button and badge examples.
   - `forms.blade.php` for field/action examples.
   - `workspace-table.blade.php`, `audit-table.blade.php`, or `error-table.blade.php` for table examples.
   - `audit-drawer.blade.php` or `error-drawer.blade.php` for log drawer markup.
3. Read controller/test code only when data shape, filtering, pagination, or drawer routes are affected.

## Avoid

- Do not merge these partials back into one large route view.
- Do not read unrelated pattern pages for a landing-page-only edit.
- Do not change visible examples without keeping `PlatformUiReferenceTest` expectations aligned.
