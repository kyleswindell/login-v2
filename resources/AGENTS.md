# resources AGENTS.md

## Purpose

Frontend and Blade resources. This folder owns Blade views, CSS, JavaScript, and UI Reference implementation surfaces.

## Read Order

1. Identify the exact view, component, script, or stylesheet section tied to the task.
2. For UI changes, run the UI API Standards Preflight before editing source: identify the primary UI API standard, read its table of contents, read `Related APIs`, token/class/helper usage, accessibility, content, UI Reference requirements, and checklist sections, then open related API standards when the change touches those dependencies.
3. Read the nearest Blade component, pattern file, script, or live example before broad CSS.
4. Inspect installed source behavior before changing a UI Reference proof surface.

## Avoid

- Do not read all UI Reference pattern files for one surface.
- Do not redefine Tier 1 primitives inside Tier 2 patterns or feature views.
- Do not expand CSS tokens or variants unless the batch or canonical standard explicitly allows it.
- Do not implement UI behavior from a local view alone when the owning API standard or its related APIs define motion, accessibility, layout, or token requirements.

## Large Files

`resources/css/app.css`, `resources/js/app.js`, and UI Reference pattern views are large. Use targeted search and line reads.

JavaScript behavior should live in concern-based modules under `resources/js/`; keep `resources/js/app.js` as the bootstrap and event-registration entrypoint.

Shared JavaScript initializer contract:

- Initializers accept `root = document` and may be called with either `document` or a subtree.
- Initializers are idempotent and mark initialized elements or regions to prevent duplicate listeners.
- Initializers are safe on initial page load and `livewire:navigated`.
- Initializers must not rely on receiving a DOM event object.
- When registering a new shared initializer, add a lightweight focused test or source assertion that verifies the lifecycle registration contract.

For `resources/css/app.css`, use the file's section map before reading broadly. Split CSS only when the build path and ownership boundary are clear.
