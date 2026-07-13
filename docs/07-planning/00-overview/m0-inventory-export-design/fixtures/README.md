# Fixture Design

## Purpose

These fixtures exercise the corrected Issue #45 CSV and SQLite design without copying accepted Issue #30 records.

## Source Fixtures

- `source/classifications.json`
- `source/observations.json`
- `source/test-traces.json`

The source fixtures use the accepted Issue #30 top-level roles and representative reviewed metadata fields.

## Expected CSV

`expected-csv/` contains one deterministic fixture projection for every required CSV table.

The expected fixture intentionally covers:

- scalar and multiple Blade aliases;
- a non-applicable alias;
- one unique standard linked to more than one surface;
- standard staleness evidence;
- moved responsibilities;
- trace relationship kinds;
- `present_claim`, `not_observed`, and `unknown` coverage states;
- multiple evidence sources;
- exact raw evidence tokens, including issue-qualified values such as `issue-29:route-list`;
- explicit surface, standard, and test-trace source-reference bindings;
- resolved and unresolved dependencies;
- surface, standard, and trace review records;
- spreadsheet formula neutralization.

## Invalid Fixtures

`invalid/` contains bounded rejection examples. Each file states the expected validation failure.

These fixtures are design examples only. They are not authoritative repository inventory data.
