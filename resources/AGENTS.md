# resources AGENTS.md

## Purpose

Frontend and Blade resources. This folder owns Blade views, CSS, JavaScript, and UI Reference implementation surfaces.

## Read Order

1. Identify the exact view, component, script, or stylesheet section tied to the task.
2. For UI changes, read the nearest Blade component or pattern file before broad CSS.
3. Cross-check relevant UI standards/contracts only for the component tier being touched.

## Avoid

- Do not read all UI Reference pattern files for one surface.
- Do not redefine Tier 1 primitives inside Tier 2 patterns or feature views.
- Do not expand CSS tokens or variants unless the batch or canonical standard explicitly allows it.

## Large Files

`resources/css/app.css`, `resources/js/app.js`, and UI Reference pattern views are large. Use targeted search and line reads.

JavaScript behavior should live in concern-based modules under `resources/js/`; keep `resources/js/app.js` as the bootstrap and event-registration entrypoint.

For `resources/css/app.css`, use the file's section map before reading broadly. Split CSS only when the build path and ownership boundary are clear.
