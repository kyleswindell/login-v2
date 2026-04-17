# Active Document Reviews Index

Tracks in-progress and recently completed document review passes.

---

## Entries

| ID               | Date       | Target                              | Type        | Status                      | Implementation Status          | Notes |
|------------------|------------|-------------------------------------|-------------|-----------------------------|--------------------------------|-------|

---

## Naming Rules

- File names must follow:
  - `doc-review-####.md`
  - `doc-sync-####.md`
- IDs must be:
  - sequential within each type
  - zero-padded (0001, 0002, ...)
- Determine next ID by:
  - reading existing entries for the same type
  - incrementing the highest existing value
- If no entries exist for a type:
  - start at `0001`
- Do NOT reuse or overwrite IDs

---

## Status Definitions

### Review Status

- `OPEN` → review created, findings active
- `PARTIAL` → findings partially addressed
- `READY_FOR_IMPLEMENTATION` → review complete, ready for correction pass
- `IMPLEMENTED_PENDING_REVIEW` → corrections applied, re-review required
- `CLOSED` → review findings resolved

### Implementation Status

- `not started`
- `in progress`
- `implemented`
- `implemented with follow-up needed`

---

## Rules

- Add a new row for every new review file created
- Update the same row as the review progresses
- Do NOT modify historical entries except to correct factual errors
- Status must reflect actual state, not assumptions
- Keep entries concise and scannable
- IDs must align exactly with the corresponding review file name