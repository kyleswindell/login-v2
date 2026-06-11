# Worklog 2-F-0038

## Summary

Implemented P2-F-CQ-135 for the newly approved UI API source installation pass.

This pass installs or maps the source APIs promoted by the updated UI standards before UI Reference proof sync resumes. UI Reference page correction remains owned by P2-F-CQ-128.

## Queue Items

- P2-F-CQ-135 - Newly approved UI API source installation pass

## Changes

- Added public Blade APIs:
  - `x-ui.contained-list`
  - `x-ui.contained-list-item`
  - `x-ui.multiselect`
  - `x-ui.popover`
  - `x-ui.slider`
  - `x-ui.range-slider`
  - `x-ui.tree-view`
- Added the native List CSS/class contract through `ui-list`, `ui-list-ordered`, `ui-list-unordered`, `ui-list-nested`, and `ui-list-content`.
- Added minimal UI control initializers:
  - `initMultiselects`
  - `initPopovers`
  - `initSliders`
  - `initTreeViews`
- Registered the new initializers in the app lifecycle.
- Added token-backed CSS namespaces for contained list, native lists, multiselect, popover, slider/range slider, and tree view.
- Extended public wrapper render coverage to assert the new `data-ui-component` markers and behavior hooks.
- Updated the UI standards contract test to accept numbered headings and the removed transitional `contracts/` folder state.
- Updated active queue, checklist, review, notes, and implementation sync so P2-F-CQ-135 is reviewable and P2-F-CQ-128 is the next ready proof-sync gate.

## Validation

- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component_public_api_wrappers` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=ui_standards_docs_use_api_contract_sections` passed after the numbered-heading test correction.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php` passed.
- `npm run build` passed after escalated rerun; the sandboxed attempt failed with the known Tailwind/Vite native binary access denial.
- `npm run lint:docs:guardrails` passed after escalated rerun; the sandboxed attempt failed with the known Bash access denial and the passing run reported existing WSL/rg permission warnings.

## Notes

- P2-F-CQ-128 remains responsible for replacing UI Reference local/reference-only examples with installed API proof.
- The new wrappers are intentionally minimal source APIs. Rich async loading, remote option loading, complex floating positioning, and advanced tree selection remain outside this pass unless a future standard explicitly requires them.
