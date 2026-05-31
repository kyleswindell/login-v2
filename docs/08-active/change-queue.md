# Change Queue

Use this file as the agent-managed canonical queue for active-batch implementation work.

### Rules:
- Discuss exploratory review findings in chat first; only normalized implementation-ready items belong here.
- Active items in `Ready To Implement`, `In Progress`, and `Implemented Pending Review` use stable `ID:` values in the format `P<phase>-<batch>-CQ-###`.
- Keep `Iteration:` separate from the stable ID when an item is reopened or refined.
- Continuation lines such as `Scope:`, `Path Coverage:`, `Implemented in:`, `Follow-up To:`, and `Supersedes:` are for traceability only.
- This queue is agent-managed and implementation-ready, not a scratchpad for exploratory discussion.
- Exploratory review discussion stays in chat until it is normalized into concise queue language.

## Ready To Implement

## In Progress

## Implemented Pending Review
- [ ] Replace the free-text `Default Timezone` and `Default Locale` examples with searchable option-backed selectors on the form-pattern proof and touched localization proof surfaces; keep validator-driven examples on true free-entry fields such as email address and phone number instead of using locale/timezone as text-input validation demos.
  ID: P2-B-CQ-001
  Scope: Tier 2 form patterns, localization defaults, account preference localization fields
  Path Coverage: `/platform/ui-reference/patterns/forms`, `/platform/settings/general`, `/account/preferences`
  Implemented in: `2-B-0011`
- [ ] Repair the `Key Value Display` read-only detail proof so linked/value content renders correctly instead of leaking broken inline markup into the UI Reference output.
  ID: P2-B-CQ-002
  Scope: Tier 2 data/content patterns, read-only detail proof
  Path Coverage: `/platform/ui-reference/patterns/data-content`
  Implemented in: `2-B-0011`
- [ ] Clarify the Tier 2 proof-page intent so examples read as intentional library demonstrations instead of ambiguous mockups; make the `Search And Filter Bar` proof explicit about what the search input, filter select, and actions represent, and add stronger on-page descriptors where component behavior or scope is otherwise unclear.
  ID: P2-B-CQ-003
  Scope: Tier 2 proof-page clarity, search/filter pattern guidance, on-page usage notes
  Path Coverage: `/platform/ui-reference/patterns/navigation`, related Tier 2 proof pages where intent is unclear
  Implemented in: `2-B-0011`

## Blocked

## Deferred

## Passed Review

## Closed
