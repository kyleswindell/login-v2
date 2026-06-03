# Notes

## Findings

- Batch F was initialized after Batch E close-out preflight identified that Phase 2 still needs concrete page archetype starter proofs before final close-out. The gap is implementation-readiness for Phase 3 and Phase 4, not feature behavior.
- Staging deploy is explicitly out of scope for Batch F and remains disabled pending security incident review.
- Existing Batch B artifacts provide the shell-family, archetype, setup/settings registration, and future-module ownership contracts. Batch F should turn those contracts into concrete starter-page examples and proof-surface parity.
- The required starter set now includes module home, settings, setup/configuration, account/profile, list/index, table-management index, operational log/detail, content browser/split-view, detail/read-only, create/edit, dashboard/module summary, widget examples by module content type, and blocked/empty/unavailable states.
- Batch F must begin with a Carbon-informed contrast audit so missing usage guidance for buttons, badges, alerts, toasts, notifications, status indicators, forms, action labels, AJAX feedback, and selection controls is mapped before implementation.
- The Carbon audit should use both the public docs site and the GitHub sources: `carbon-design-system/carbon-website`, `carbon-design-system/carbon`, and `carbon/tree/main/docs`.

## Implementation Notes

- Use existing Tier 1 primitives and Tier 2 patterns.
- Keep starter examples reusable and generic.
- Normalize existing proof surfaces only where needed to demonstrate the starter contract.
- Do not expand account, notifications, customer/public, or module-specific behavior.
- Do not copy Carbon as the app standard; use it as a completeness benchmark and translate relevant findings into Login App 2.0-specific guidance.
