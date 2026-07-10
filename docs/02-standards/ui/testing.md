# UI Testing Standards

## Purpose

UI tests for Foundation Elements and Components must live beside the source they protect so a developer can inspect the component, its contract metadata, and its tests in one folder.

This file owns UI testing policy. Implementation-facing test criteria live in [UI Test Requirements](test-requirements/index.md) so per-surface requirements stay easy to find and do not get buried in long Element, Component, or Pattern standards.

## Test Layers

UI testing has two complementary layers:

- Adopted Carbon parity: tests verify only the Carbon roles, token families, values, component concepts, or behavior that Login App explicitly adopted. Deferred, gated, or not-adopted Carbon capabilities do not require parity tests.
- Login App governance: tests verify app consumers do not bypass approved Element, Component, or Pattern APIs with raw values, unapproved local tokens, stale APIs, or local behavior forks.

Element tests enforce global API boundaries. Component tests enforce the exact Element consumption, variants, states, accessibility, and behavior promised by the owning Component standard. Pattern tests enforce composition-level Element and Component usage without overriding component-owned internals.

## Co-Located Test Folders

Use these folders for UI API-owned tests:

| UI surface | Test folder |
| --- | --- |
| Component | `resources/views/components/ui/{component}/__tests__/` |
| Foundation Element | `resources/views/elements/{element}/__tests__/` |

Pattern-owned tests should use the app test tree or a future co-located Pattern source folder when that owner exists. Rendered evidence route and catalog coverage remains in `owner-specific feature tests`; shared UI static/unit helpers may live under `tests/Unit/Ui/`.

Executable test locations are future/expected ownership paths when a folder does not exist yet. Do not create executable test folders from documentation requirements alone.

Each `__tests__` folder may contain:

- `index.md` as the human test map.
- PHP `*Test.php` files for Blade render contracts, static governance, source ownership, and registry checks.
- Playwright `*.spec.js` files for browser behavior, keyboard behavior, focus, visibility, and JavaScript state.
- Fixture files when a browser test needs stable markup without creating a product route.

Do not create executable `IndexTest.php` dispatchers. The folder path is the runnable index; `index.md` is the human map.

## Requirement Files

[UI Test Requirements](test-requirements/index.md) is the implementation-facing checklist layer. It records required tests, source files, failure conditions, approved exceptions, status, and validation notes.

Requirement files do not contain executable tests and do not replace the owning standards. They translate policy and standards into checklists for implementation.

Use these requirement statuses:

- `planned`
- `partial`
- `implemented`
- `blocked`
- `deferred`
- `needs-confirmation`

## Failure Expectations

CI should fail when an implemented requirement detects an unapproved API bypass, stale public API, missing adopted Carbon parity, missing required accessibility behavior, or missing rendered evidence proof.

Structural CSS values such as `0`, `100%`, `auto`, `none`, `transparent`, `inherit`, `currentColor`, and approved `1px` borders are not failures unless the owning requirement file explicitly forbids them.

Primitive palette values are allowed inside approved token source files where they map into semantic Element or Component roles. Consumers must use the approved role tokens instead of raw colors or direct primitive palette tokens.

## Runner Contract

PHPUnit discovers co-located UI `*Test.php` files under component and element folders. Playwright discovers co-located `*.spec.js` files under the same `__tests__` folders.

Use `scripts/Test-UiSurface.ps1` for human-friendly runs:

```powershell
.\scripts\Test-UiSurface.ps1 -Component accordion
.\scripts\Test-UiSurface.ps1 -Components
.\scripts\Test-UiSurface.ps1 -Element color
.\scripts\Test-UiSurface.ps1 -Elements
.\scripts\Test-UiSurface.ps1 -All
```

The script must use `docker compose exec -T app ...` for PHP tests and `docker compose exec -T playwright ...` for browser tests. It must not use `docker compose run`. Use non-TTY exec so PowerShell logs remain readable and Docker/npm spinner output does not overwrite prompt text.

When running Playwright directly, pass concrete `*.spec.js` paths or use `scripts/Test-UiSurface.ps1`. Do not rely on a `__tests__` folder path as a Playwright positional argument because Playwright treats positional arguments as file-matching expressions.

## Carbon Alignment

Carbon React tests are a completeness benchmark, not Login App implementation truth. Use `docs/09-reference/ui/carbon-ui-provenance/carbon-react-test-alignment.md` to classify Carbon assertions before adding local tests.

Allowed local classifications:

- Blade contract
- Browser behavior
- Static governance
- Documentation/reference evidence
- React-only / not portable
- Discrepancy candidate

Do not add a failing local test for a Carbon-only behavior unless the owning Login App standard already adopts that behavior and the implementation pass is explicitly scoped to fix it.

## Component Index Requirements

Every co-located `index.md` must record:

- Carbon files reviewed.
- Local source and standard files covered.
- Implemented PHP and browser tests.
- Intentional divergences.
- Drift candidates not yet enforced.
