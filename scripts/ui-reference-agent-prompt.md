# UI Reference Agent Prompt

Update only the `[SECTION_NAME]` area of `/platform/ui-reference`.

## Ownership

Files you may edit:

- `[ABSOLUTE_FILE_PATH_1]`
- `[ABSOLUTE_FILE_PATH_2]`

Do not edit other sections/files.

## Constraints

- Preserve existing route and super-admin auth behavior.
- Keep naming in the current token system (`ui-action-*`, etc.).
- Keep mobile and light/dark behavior intact.

## Required Verification

Run:

- `php artisan route:list --path=platform/ui-reference`
- `php artisan view:cache`

Report:

- files changed
- what behavior changed
- verification result
