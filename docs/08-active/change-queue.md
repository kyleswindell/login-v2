# Change Queue

## Ready To Implement

## In Progress

## Implemented Pending Review
- [ ] Rework the notification trigger unread state around a danger/red direction so unread notifications are unmistakable at a glance; use a danger-outline bell treatment, a danger badge, and allow the stronger icon glow/emphasis to return only when unread items exist.
- [ ] Add a clearer unread-vs-read distinction inside the notifications pop-out list so unread rows do not read like recently read items; use a stronger unread background/shell treatment in addition to the existing labels.

## Blocked

## Deferred
- [ ] Record Phase 2 follow-up scope for a full UI standards pass across existing views and elements in a later Phase 2 batch.

## Passed Review
- [x] Retuned the light-mode notification dropdown severity labels so the pills read clearly against the light card backgrounds while keeping the existing semantic color mapping.
- [x] Added a visible `Mark all as read` action to the notifications pop-out / dropdown surface so the quick-access menu supports the same bulk-clear path as the full notifications view.
- [x] Added visible icon + text button examples to the UI Reference `Buttons + icons` surface so the library demonstrates canonical text-bearing action buttons alongside icon-only controls.
- [x] Replaced table pagination and rows-per-page full-page reloads with the existing in-place table refresh path plus the canonical table loading state where feasible inside the current Batch A table baseline, without broad table-system redesign.
- [x] Changed the dark-mode table drawer close control to the neutral outline button treatment so the button keeps a visible border and matches the drawer/modal action baseline.
- [x] Generated example toast deploys to the approved fixed overlay location.
- [x] Normalized the remaining reviewed navigation and UI Reference icon surfaces to the approved Heroicons path and removed the lingering inline SVG usage from those reviewed surfaces.
- [x] Restored Documentation Vault repository-tree sidebar behavior so the page can scroll normally, the docs sidebar scrolls off-screen before sticking, and the repository-tree card supports its own themed vertical scrollbar in light and dark mode when content overflows.
- [x] Removed the stray border from the neutral ghost button so ghost semantic variants render consistently.
- [x] Shifted the dark-mode primary semantic background toward `#1d95d873` and retuned related border, text, and state colors to match.
- [x] Shifted the dark-mode info semantic background toward `#6ef3ff66` and retuned related border, text, and state colors to match.
- [x] Restored desktop sticky behavior for the custom-sidebar host so the Documentation Vault sidebar container itself remains sticky again instead of only the inner repository-tree card sticking.
- [x] Refined the shared select/dropdown indicator spacing again so the overall right-side offset is not excessive and the dropdown arrow remains visually centered.
- [x] Made selectable-group selected-state styling update dynamically on click so the stronger focused-style emphasis is added and removed live instead of only appearing from the initial server-rendered state.
- [x] Retuned dark-mode toast backgrounds across all semantic colorways so they are fully opaque and visibly darker, using the newly approved darker direction for each toast/alert family (for example, info aligned closer to `#2f4e51`) while keeping the current overlay placement intact.
- [x] Made the current table filter button perform the expected filter-panel toggle/action instead of remaining inert.
- [x] Added automatic timeout dismissal for toast pop-ups after a short interval in the 15-20 second range while preserving manual dismiss behavior.
- [x] Replaced the badge-style sortable-header treatment with an icon-led active-sort indicator so unsorted columns show a neutral sort glyph and the active column shows a directional arrow with clearer emphasis.
- [x] Restored outside-click dismissal for the table filter pop-up so clicking the page outside the pop-up shell closes it consistently again, while keeping the current toggle path intact.

## Closed
- [x] Increase the unread count badge opacity/contrast on the header notification trigger, especially in dark mode where the current badge background is still too transparent.
- [x] Rework the header notification trigger unread-state treatment to follow an established menu-button-plus-badge direction instead of relying mainly on tinting the bell/control shell; keep the trigger close to a standard menu button and let the numeric unread badge carry the primary unread signal.
- [x] Rework the unread notification visual treatment again so unread state does not rely so heavily on the current primary blue direction; the current follow-up now replaces that direction with an explicit danger/red unread treatment.
- [x] Audit the main notification trigger highlight / hover-outline treatment and remove or soften any always-on visual ring that makes the control read as pre-hovered when it should only show that emphasis intentionally; the current follow-up now replaces that direction with an explicit danger-outline unread trigger treatment.
