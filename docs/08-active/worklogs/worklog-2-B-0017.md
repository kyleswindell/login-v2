# Worklog 2-B-0017

## Prompt Summary

Conduct `work-batch` on `P2-B-CQ-017`.

## Scope

- shared internal phone-input normalization baseline
- form-pattern proof expectations for plain digit entry
- touched account, company-information, and staff-profile phone-entry surfaces
- active batch documentation and worklog updates for `P2-B-CQ-017`

## Files Changed

- `app/Support/InternalPhoneFormatter.php`
- `app/Http/Controllers/Platform/AccountController.php`
- `app/Http/Controllers/Platform/SettingsController.php`
- `app/Http/Requests/Platform/StorePlatformUserRequest.php`
- `app/Http/Requests/Platform/UpdatePlatformUserRequest.php`
- `app/Filament/Resources/PlatformUsers/PlatformUserResource.php`
- `resources/js/app.js`
- `resources/views/platform/account/settings.blade.php`
- `resources/views/platform/settings/general-company-information.blade.php`
- `resources/views/platform/users/partials/form.blade.php`
- `resources/views/platform/ui-reference/patterns/forms.blade.php`
- `tests/Unit/InternalPhoneFormatterTest.php`
- `tests/Feature/Platform/PlatformAccountTest.php`
- `tests/Feature/Platform/PlatformSettingsTest.php`
- `tests/Feature/Platform/PlatformUserManagementTest.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`
- `docs/04-features/account/account-management-and-settings.md`
- `docs/04-features/notifications/platform-notifications-and-settings.md`
- `docs/04-features/users/platform-users-and-rbac.md`
- `docs/08-active/change-queue.md`
- `docs/08-active/review.md`
- `docs/08-active/notes.md`
- `docs/08-active/worklogs/index.md`
- `docs/08-active/worklogs/worklog-2-B-0017.md`

## Work Completed

- added a shared internal phone formatter that normalizes plain ten-digit entry to the canonical `(555) 555-5555` baseline while preserving explicit extensions
- applied that formatter to the touched account, company-information, and staff-profile persistence paths so stored values stay consistent even without browser formatting
- wired the adopted phone inputs to a shared frontend normalizer so raw digit entry auto-formats on the UI Reference proof surface and the touched live forms
- updated the forms proof-review coverage so `P2-B-CQ-017` is visible where reviewers judge the phone-entry contract
- extended unit and feature coverage for the formatter, the touched live surfaces, and the proof page
- synced the account, settings, and platform-user feature docs to the new phone-entry behavior

## Checklist Impact

- no checklist section moved to pass in this implementation pass
- `Tier 1 Library Hardening`, `Proof Surface Coverage`, `Validation Readiness`, and `Batch B Exit Criteria` remain pending manual review

## Change Queue Impact

- `P2-B-CQ-017` -> implemented pending review

## Issues Found

- the default WSL feature-test environment still hangs against the repo's PostgreSQL test host configuration because `phpunit.xml` points to `DB_HOST=postgres`, which is not resolvable from this thread
- the targeted feature suite passed when run through the same WSL PHP runtime with `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` overrides
- the WSL command wrapper still prints a non-blocking `Failed to translate 'G:\Program Files\Git\cmd'` warning after successful commands

## Deferred Items

- targeted manual re-review of `P2-B-CQ-001`, `P2-B-CQ-003`, `P2-B-CQ-004`, `P2-B-CQ-006`, `P2-B-CQ-007`, `P2-B-CQ-008`, `P2-B-CQ-010`, `P2-B-CQ-011`, `P2-B-CQ-013`, `P2-B-CQ-014`, `P2-B-CQ-016`, and `P2-B-CQ-017`
- the remaining reopened Tier 1 follow-up queue on `P2-B-CQ-005`
- the blocked downstream account-menu adoption work on `P2-B-CQ-015`

## Commit / Deploy Status

- Commit: review-fix save point completed for this pass
- Deploy: canonical staging deployment completed on `main` for review-backed queue state

## Notes

- This pass keeps `P2-B-CQ-017` separate from the searchable-selector and action/menu queue so the internal phone-input baseline is judged as its own Tier 1 contract.
- Staging is now ready for targeted re-review of `P2-B-CQ-017`.
