# 2026-04-14 - UI Reference Table Baselines Corrections - Proposed Doc Updates

## Staging Status

* applied

## Metadata

* Owner agent/session: Codex GPT-5 (session date 2026-04-14)
* Created date: 2026-04-14
* Requested by: @kswin
* Related implementation scope: UI Reference `Patterns / Tables` baseline control-row corrections from `docs/Personal Notes/UI Reference Table Baselines Corrections.md`

## Scope

Adjusted the table-baseline control layout in the UI reference workspace so all baseline tables follow a consistent header control pattern.
Rows selectors now render in each table's header control row, search inputs are right-aligned beside the filter icon, and filter controls open as a pop-up panel instead of an inline row.
The filter pop-up now contains only non-search filters, while search is handled directly in the header controls.

## Canonical Target Docs

* `docs/V2 App/Reference/UI Design System Standards.md`
* `docs/V2 App/Reference/UI Reference Workspace Workflow.md`

## Proposed Updates

1. In `UI Design System Standards.md` under `Tables And Data Grids`, replace the baseline sequence that currently calls for a dedicated inline `filter row`.
   Proposed baseline sequence:
   * page title/subtitle row
   * optional table stats row
   * table control row:
     * left side: rows selector followed by table action buttons (when present)
     * right side: right-justified search input + filter icon toggle
   * filter pop-up panel (toggle-opened, not inline)
   * table
   * table footer controls:
     * bottom-left: result summary
     * bottom-right: Prev / page selector / Next

2. In `UI Design System Standards.md` under `Filter Toggle Pattern`, update behavior language:
   * filter toggle opens a pop-up menu/panel anchored to the table controls row
   * panel should contain scoped filter fields and Apply/Reset actions
   * table search stays in the control row and is not duplicated inside the filter pop-up panel

3. In `UI Reference Workspace Workflow.md` review checklist, replace wording `tables keep filter row + rows-per-page + pagination + summary` with wording aligned to the updated pattern:
   * tables keep header control row (rows selector, search, filter pop-up toggle), pagination, and result summary

## Implementation Status Impact

`UI Design System Standards` implementation status should note that `/platform/ui-reference/patterns/tables` now reflects:

* header-level rows selector placement
* right-side search + filter toggle pairing
* pop-up filter panel behavior for all baseline table examples

No change required to platform auth/route contracts.

## Supporting Links

* Planning/input note: `docs/Personal Notes/UI Reference Table Baselines Corrections.md`
* Updated implementation file: `resources/views/platform/ui-reference/patterns/tables.blade.php`
* Verification commands run:
  * `php artisan route:list --path=platform/ui-reference` (pass)
  * `php artisan view:cache` (pass)
  * `php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php` (environment failure: PostgreSQL host `postgres` not resolvable in current shell)

## Review Outcome

Used by review agents to record:

* decision: applied
* applied locations:
  * `docs/V2 App/Reference/UI Design System Standards.md`
  * `docs/V2 App/Reference/UI Reference Workspace Workflow.md`
* follow-up needed: none for docs sync; implementation verification remains owned by platform UI reference QA cycle

## Related

* [[Codex/Agent Doc Staging/Agent Doc Staging Queue]] | [Agent Doc Staging Queue](Agent%20Doc%20Staging%20Queue.md)
