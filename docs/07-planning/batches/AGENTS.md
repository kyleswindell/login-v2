# docs/07-planning/batches AGENTS.md

## Purpose

Batch planning indexes and batch sequencing support.

## Read Order

1. Open only the phase batch index related to the current phase.
2. Use the linked phase planning file for details instead of scanning all batch folders.

## Avoid

- Do not treat batch indexes as canonical implementation state; active batch state belongs in `docs/08-active/`.
- Do not read old phase batch indexes for current implementation unless the task asks for sequencing history.
