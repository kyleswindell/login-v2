# Batch Workflow - Work Batch

[Back to Batch Workflow](../batch-workflow.md)

### 2. Work Batch

Workflow entry point:
- `work-batch`

Responsibilities:
- execute scoped implementation
- create a new worklog file
- update worklog index
- update notes.md
- annotate checklist.md (not complete)
- update review.md with factual status only
- commit accepted local-review work before it can be marked passed review
- commit/push/deploy when the pass is review-ready and manual visual review requires a shared surface

Rules:
- enter `work-batch` only when the user explicitly requests execution, asks to implement an already selected batch item, or provides a paste-ready work-batch prompt
- treat methodology, review, diagnosis, planning, and "what should we do?" prompts as read-only until implementation is explicitly requested
- do not expand scope
- use the narrowest validation path that proves the targeted contract before running broader suites
- set checklist `Status` only
- do not mark checklist items complete
- do not finalize batch
- if the pass builds Tier 2 patterns or feature UI from existing Tier 1 work, complete a Tier 1 consumption preflight before coding
- treat `In Progress` as the explicit claim marker for the currently targeted queue item
- if a prior pass left a queue item in `In Progress`, continue or explicitly reclassify that item before selecting a new `Ready To Implement` item
- when multiple queue items are handled in one pass, claim and complete them sequentially; do not move a second independently tracked item into `In Progress` until the current one reaches an outcome state
- when multiple queue items are handled in one pass, record the targeted queue IDs, grouping rationale, affected files by item or tightly coupled group, validation performed, and review surface in the worklog
- before a large grouped CQ pass, state the grouping rationale and validation strategy; if one UI surface fails twice, stop for root-cause review before another correction pass
- for shared UI or system surfaces, identify the relevant render/update paths before calling the pass review-ready
- examples of parallel paths include:
  - server-rendered markup
  - realtime or client-injected markup
  - toast or overlay variants
  - full-index or detail views for the same system
- if one of those paths is intentionally not updated in the pass, record it explicitly as a follow-up item instead of implying full surface completion
- preserve existing `ID:` lines when moving items between sections
- preserve existing queue metadata lines when moving items between sections
- assign the next sequential queue ID when a new active queue item is created and no stable ID already exists
- add or update `Implemented in:` when that improves traceability for a targeted item
- if the pass changes queue IDs consumed by the temporary active-batch UI Reference review overlay, regenerate the derived runtime manifest from the current queue state before the pass is considered review-ready
- if local development is the review surface, the item can be reviewable before push or deploy, but accepted work must be committed before it is marked passed review
- if a targeted item needs staging or another deploy-backed review surface, treat deploy completion as part of the implementation outcome before moving that item into `Implemented Pending Review`

Validation selection:
- Matrix:
  - docs or instruction-only: docs guardrail or targeted text/link checks only
  - single UI route/component/partial: named `--filter` test plus source assertions
  - shared JS lifecycle, global CSS, catalogs, routes, or generated assets: focused tests plus build and browser review
  - final batch review: full integration files only when the final gate requires them
- Start with the most specific test, static check, or browser route that proves the touched behavior.
- Run broad test files, full suites, builds, or docs guardrails only when the queue item requires them, the change touches shared routing/catalogs/lifecycle/generated assets/cross-page contracts, focused checks cannot prove the behavior, or the pass is at a final review gate.
- Do not rerun broad suites only because a worklog, notes file, or review annotation changed after source validation already passed. Use the docs guardrail for docs inside its responsibility.
- For expensive test files, use `--filter` or named test methods during iteration and reserve the full file for a final justified regression pass.
- Record the validation scope in the worklog, including why broad validation was necessary when it was run.
- If a broad command is slow or times out, record the duration and the narrower command future agents should start with.
- Scope negative assertions to the owning partial/component/container. Do not assert that a generic tag or string is absent from an entire route response when other page regions may legitimately render it.

UI Reference validation guidance:
- `tests/Feature/Platform/PlatformUiReferenceTest.php` is broad integration coverage across many UI Reference routes and can take minutes.
- Sidebar-only changes should start with the focused sidebar/workspace test filter and source-level assertions for the sidebar partial.
- Run the full UI Reference test file only after shared catalog, route, sidebar lifecycle, or cross-route contract changes, or as a final justified regression gate.
- Before authenticated local browser review, run `php artisan local:ready` or `npm run local:ready` so the review user and `public/hot` are normalized. If readiness reports a broken service, use [Local Browser Review Setup](../local-browser-review.md); do not repeatedly restart, cache-bust, or move `public/hot` during iteration.

Worklog compression:
- record final validation, material caveats, and durable findings only
- do not narrate every failed attempt, cache-bust, restart, temporary hot-file move, or repeated environment workaround
- move recurring operational facts into runbooks instead of copying them into each worklog

Tier 1 consumption preflight:
- identify the exact Tier 1 building blocks the pass depends on
- name whether each one is consumed as:
  - `Blade component`
  - `Class/markup contract`
  - `Hybrid`
- confirm the canonical entry point is explicit in current standards/reference material
- if the needed Tier 1 item is represented only by demo-only snapshot markup or otherwise has a `Missing abstraction`, stop and record the gap instead of improvising a Tier 2 or feature-level substitute

---
