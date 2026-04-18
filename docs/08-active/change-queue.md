# Change Queue

## Ready To Implement

## In Progress

## Implemented Pending Review
- [x] Added visible icon + text button examples to the UI Reference `Buttons + icons` surface so the library demonstrates canonical text-bearing action buttons alongside icon-only controls.
- [x] Strengthened selected-state indication for the current single-select and multi-select selectable-group surfaces by layering the existing focused treatment onto selected items as the first Batch A correction, without introducing a new variant.
- [x] Increased the shared select/dropdown indicator spacing so the down-arrow affordance sits farther from the right border across canonical select surfaces.
- [x] Re-aligned the shared shell breakpoint behavior so the main content does not switch to the full-width state before the sidebar crosses into the mobile-nav state at the same breakpoint.
- [x] Replaced table pagination and rows-per-page full-page reloads with the existing in-place table refresh path plus the canonical table loading state where feasible inside the current Batch A table baseline, without broad table-system redesign.
- [x] Changed the dark-mode table drawer close control to the neutral outline button treatment so the button keeps a visible border and matches the drawer/modal action baseline.
- [x] Increased dark-mode toast background opacity while keeping the generated example toast fixed to the approved page-level overlay location.

## Blocked

## Deferred
- [ ] Record Phase 2 follow-up scope for a full UI standards pass across existing views and elements in a later Phase 2 batch.

## Passed Review
- [x] Generated example toast deploys to the approved fixed overlay location.
- [x] Normalized the remaining reviewed navigation and UI Reference icon surfaces to the approved Heroicons path and removed the lingering inline SVG usage from those reviewed surfaces.
- [x] Restored Documentation Vault repository-tree sidebar behavior so the page can scroll normally, the docs sidebar scrolls off-screen before sticking, and the repository-tree card supports its own themed vertical scrollbar in light and dark mode when content overflows.
- [x] Removed the stray border from the neutral ghost button so ghost semantic variants render consistently.
- [x] Shifted the dark-mode primary semantic background toward `#1d95d873` and retuned related border, text, and state colors to match.
- [x] Shifted the dark-mode info semantic background toward `#6ef3ff66` and retuned related border, text, and state colors to match.

## Closed
