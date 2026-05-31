# Notes

## Findings
- Promoted Tier 1 entry points are now implemented as canonical Blade components for buttons, icon buttons, inline alerts, toasts, drawers, and modals.
- Batch B pass `2-B-0001` is deployed to staging on `main` and ready for manual review.

## Decisions
- Batch B starts with Tier 1 library hardening for the promoted Blade-component candidates before broader Tier 2 implementation continues.
- Batch B pass `2-B-0001` uses the existing Tier 1 class contracts as the styling baseline and wraps them in canonical Blade entry points rather than redefining visual rules.

## Risks / Questions
- First-pass operator-table proof surfaces still need to be confirmed at batch execution time if table-oriented proof coverage becomes necessary.
- Realtime notification toast rendering remains a feature-level JS path and is intentionally outside this Tier 1 hardening pass.
