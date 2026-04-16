# Notes

## Findings
- The current Batch A implementation surface already existed, but it had material Tier 1 gaps: missing checkbox/radio/switch coverage, no visible utility primitives section, and a status validation example using a non-contract `solid` badge variant.
- Core platform tables and dashboard controls were only partially aligned with Tier 1 shared primitives; this pass moved key surfaces toward the canonical actions/badges/input controls already in the app.
- `php artisan route:list --path=platform/ui-reference` succeeds after the changes, so the UI Reference route surface remains intact.
- Host-shell test execution still fails outside Docker because `phpunit.xml` uses Docker-network host `postgres`.
- Dockerized test execution succeeds for `tests/Feature/Platform/PlatformUiReferenceTest.php` after fixing the stale assertions and deterministic permission setup.
- The remaining Batch A gaps were presentation and validation-surface gaps rather than missing standards: overlays, feedback, navigation, and explicit state visibility all needed cleaner, more reviewable rendering in the UI Reference workspace.
- Live drawer/modal demos can be exercised directly in the UI Reference now, including `Escape`, backdrop close, dismiss paths, and focus-return behavior.
- The remaining coverage issues after the prior pass were mostly review-surface precision issues: the overview still implied a disabled badge state that is not part of the Tier 1 contract, the switch example was not a real control, and table loading/empty states were not isolated enough for clean visual review.
- The manual visual review surfaced a separate set of implementation-only polish issues in Batch A: semantic contrast in light mode, danger/warning hue tuning, link readability, spinner visibility, checkbox focus rendering, and switch/toggle interaction fidelity.
- The follow-up visual review pass identified additional Tier 1 presentation issues around disabled-state clarity, primary/info separation in dark mode, soft-vs-base distinction, and ad hoc parity tokens in the navigation review surface.
- The current toast baseline work required a standards correction: the active standards tree did not contain a separate Tier 2 notification/toast addendum entry for toast animation, but the Tier 1 toast contract still discouraged animated entry/exit even though minimal baseline motion is appropriate for Tier 1.
- The toast baseline review surface still lacked an on-demand generation path after the motion work landed, which made it harder to inspect entry/dismiss animation on a fresh example without resetting the entire stack.
- The latest Batch A review pass centered on Tier 1 normalization rather than feature expansion: sortable demo columns, stronger disabled/pagination visibility, filter-panel sizing, semantic palette correction, and more complete action/control state coverage in the UI Reference.
- Numbered pagination was evaluated during the table pass, but keeping the current Prev / page select / Next baseline is safer for Batch A because a numbered paginator treatment reads like a broader pattern decision rather than a settled Tier 1 requirement.


## Decisions
- Keep Batch A scoped to implementation changes in the app/UI surface and do not modify canonical planning or standards docs during this pass.
- Treat the badge `solid` variant as out of Batch A contract scope and normalize Tier 1 badge examples to base/outline only.
- Add utility primitives and layout/scaffolding examples into existing UI Reference views instead of creating a new route, to stay within the current Batch A validation surface.
- Keep automated feature verification Docker-first for this repo instead of changing the canonical `postgres` host configuration.
- Fix the permission failure by seeding canonical permissions and looking up `platform.docs.view` by name after clearing the permission cache, instead of relying on ad hoc permission creation state.
- Add generic UI Reference demo overlay handling in `resources/js/app.js` rather than feature-specific JS, so Batch A can validate drawer/modal behavior without introducing production feature drift.
- Remove invalid disabled-state claims from badge/status coverage instead of inventing a disabled badge contract.
- Normalize toast and inline-alert rendering through shared semantic classes instead of one-off hardcoded color utilities in the UI Reference views.
- Keep primary mapped to blue in dark mode; no standards clarification blocked that normalization, so this remained an implementation-level alignment task.
- Normalize the account dropdown parity chips to canonical badge styling instead of leaving them as ad hoc token pills.
- Treat disabled-state clarity as a shared Tier 1 action/icon-button concern rather than a one-off view-level opacity tweak.
- The first deploy attempt for this follow-up pass failed during `vite build` on the server because `@apply peer` is not accepted in this Tailwind setup; the switch helper was revised to use explicit CSS instead.
- Treat minimal toast appear/dismiss motion as a Tier 1 baseline behavior and keep it reduced-motion-safe; do not expand that into richer notification-system logic in Batch A.
- Add a single generated example toast control to the UI Reference baseline instead of introducing a richer notification queue or feature-level notification behavior.
- Keep sortable headers and pagination-state polish inside the current Tier 1 table baseline, but defer any numbered pagination pattern finalization to a follow-up standards/doc-sync pass.
- Add semantic ghost coverage and an inverse spinner helper in the implementation layer for this pass, and record them for doc-sync follow-up instead of editing canonical standards during Batch A work.


## Risks / Questions
- Manual visual review is still required for hover/focus/active states, overlay focus return, shell navigation behavior, and responsive layout behavior.
- Manual functional validation is still required before the batch can be finalized, even though the implementation surface is now ready for that review pass.
- Docker verification was re-run after this final UI Reference cleanup pass and the targeted suite remained green.
- The latest visual review fixes still need a fresh manual re-review to confirm the adjusted contrast and palette behavior in both light and dark modes.
- Docker verification was re-run after the visual review fix pass and the targeted UI Reference suite remained green.
- Docker verification was refreshed after the latest disabled/info/soft/navigation parity adjustments and the targeted suite remained green.
- Docker verification remained green after replacing the unsupported `@apply peer` switch helper implementation.
- Docker verification was refreshed after the Tier 1 toast motion correction pass and the targeted suite remained green.
- Docker verification was refreshed after adding the generated toast trigger and the overlays reference page remained covered by the targeted Batch A suite.
- Canonical docs likely need a follow-up sync pass if semantic ghost coverage and inverse spinner usage are intended to remain part of the supported Tier 1 action utility surface.
- Docker verification was refreshed after the table/control/palette normalization pass and the targeted UI Reference suite remained green.
