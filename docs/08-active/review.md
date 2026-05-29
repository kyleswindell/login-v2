# Review

## Status
PARTIAL

## Issues
- Phase 2 still needs a separate later-batch full UI standards pass across existing views and elements before overall close-out.
- The latest Batch A implementation pass replaced the sortable-header badge treatment with an icon-led active sort state, but that refreshed visual treatment still requires manual re-review before the full visual review can pass.
- The current table filter pop-up does not close when the page is clicked outside the pop-up shell, so outside-click dismissal still needs to be restored.
- The header notification trigger still does not read clearly enough as an unread-notifications state, especially in light mode where the bell and count treatment stay too monotone and easy to overlook.
- Docker remains the canonical verification path for this repo because the host shell does not provide the same Laravel runtime/dependency surface.
- The refreshed sortable-header pass is pushed to `main`, but this Codex shell cannot access the same WSL/SSH deployment path as the interactive local shell, so staging still needs a user-side deploy before remote manual review can continue.


## Required Fixes
- Re-run manual review on the refreshed sortable table header active-state treatment to confirm the current sorted column is now obvious and the directional arrow reads clearly across the UI Reference table surfaces.
- Restore outside-click dismissal for the table filter pop-up so clicking the page outside the pop-up shell closes it consistently.
- Strengthen the unread-state treatment of the header notification trigger so unread notifications are visually obvious in both themes, with the primary gap currently on the light-mode shell. The unread state should read as active at the full trigger-control level rather than only through the tiny count pill, while the zero/unread-none state stays subdued.
- Carry the later Phase 2 full UI standards pass note forward as deferred close-out scope rather than expanding the current batch.
- Keep using Docker for automated UI Reference verification during the review/finalization pass.
- Deploy `main` from the interactive local WSL shell before attempting remote manual review of this sort-state pass.


## Manual Review

Visual: FAIL  
Functional: FAIL
