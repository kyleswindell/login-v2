# UI Reference Workspace Workflow

## Purpose

Define the quickest repeatable workflow for updating the canonical UI reference workspace at `/platform/ui-reference`.

Use this when multiple agents are updating UI reference sections in parallel.

## Canonical Location

Primary implementation files:

* `resources/views/platform/ui-reference/index.blade.php`
* `resources/css/app.css`
* `app/Http/Controllers/Platform/UiReferenceController.php`
* `tests/Feature/Platform/PlatformUiReferenceTest.php`

Canonical standards owner:

* [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](UI%20Design%20System%20Standards.md)

## Parallel Ownership Model

Split work by fixed section ownership in `resources/views/platform/ui-reference/index.blade.php`:

1. Button/Token section owner
2. Form section owner
3. General table section owner
4. Audit/Error table + drawer section owner

Shared file rule:

* If more than one agent edits `resources/css/app.css`, assign explicit token subsets (for example: button tokens vs table tokens) before starting.

## Input Workflow (Per Agent)

1. State target section and owned files.
2. Implement only the assigned section.
3. Verify route + view compile:
   * `php artisan route:list --path=platform/ui-reference`
   * `php artisan view:cache`
4. Update tests only for owned behavior changes.
5. Update docs only if canonical standards changed.

## Baseline Prompt Template

Use this baseline prompt when launching an agent:

```text
Update only the [SECTION_NAME] area of /platform/ui-reference.

Owned files:
- [ABSOLUTE_FILE_PATH_1]
- [ABSOLUTE_FILE_PATH_2]

Requirements:
- Keep existing route/auth contracts unchanged.
- Use existing ui-action token naming conventions.
- Do not modify sections outside [SECTION_NAME].
- Run: php artisan route:list --path=platform/ui-reference
- Run: php artisan view:cache
- Return exact files changed and a concise test/verification summary.
```

## Review Checklist

* styles match light/dark token behavior
* mobile layouts remain usable under 1024px
* tables keep header control row (rows selector, search input, filter pop-up toggle), pagination, and result summary
* icon-only controls retain accessible labels
* drawers keep Escape/backdrop/close behavior

## Related

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](UI%20Design%20System%20Standards.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
