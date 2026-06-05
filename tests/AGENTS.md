# tests AGENTS.md

## Purpose

Automated test coverage. This folder owns feature, unit, and integration tests that verify application behavior and UI Reference contracts.

## Read Order

1. Locate the test file nearest to the changed code path.
2. Read existing assertions around the affected behavior.
3. Run the narrowest relevant test before broad suites when practical.

## Avoid

- Do not read the full test suite for one component or route.
- Do not add broad snapshot-style assertions when targeted behavioral assertions are clearer.
- Do not update tests to match broken behavior.
