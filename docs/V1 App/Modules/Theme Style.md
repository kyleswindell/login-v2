# Theme Style

Parent: [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)

## Purpose

Theme Style provides admin/customer interface styling configuration.

## Use This Note When

Use this note when you need the module-level answer to:

- what the `theme_style` module contributes to V1
- where theme-style settings are managed
- how this module extends Setup/admin configuration

Do not use this note as the main owner of:

- the full asset pipeline
- all visual styling behavior in the app
- general settings/navigation mapping

## Current Implementation

The module registers language files and includes views/helpers for managing theme-related visual settings.

## Important Files

- `application/modules/theme_style/theme_style.php`
- `application/modules/theme_style/controllers/Theme_style.php`
- `application/modules/theme_style/helpers/theme_style_helper.php`
- `application/modules/theme_style/install.php`
- `application/modules/theme_style/views/theme_style.php`

## Notes

- The module ships its own controller, helper, install file, view, and language packs.
- In the reviewed V1 UI mapping, `Theme Style` appears as a module-added Setup item for admin users.

## Related

- [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)
- [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../Reference/Setup%20And%20Settings%20Map.md)
