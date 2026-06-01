# Review Docs Sync

Review documentation against current implementation to identify drift, inconsistency, and missing coverage.

## Goal
Perform a direct docs sync review and produce structured findings comparing:

- implementation (code, UI Reference, behavior)
- canonical documentation (standards, contracts, features, architecture)
- parent planning/status docs when reviewed implementation or approved deferments changed their current truth

This agent:
- performs the review directly
- does NOT generate a prompt
- does NOT modify canonical docs
- writes findings to a review file in `/docs/11-ai/active-doc-reviews/`

---

## Required Input

The request should indicate:
- implementation area, system, or batch
- or a tightly scoped parent planning/status surface that must be synchronized to recently reviewed implementation truth
- or default to current `/docs/08-active/` context

Stop if:
- neither a target area nor active batch context exists
- the requested scope is so broad that it would require a repo-wide audit in one pass
- the request is for a standards or governance review rather than implementation-versus-doc drift review

---

## Scope

Read from:

- `/docs/02-standards/`
- `/docs/03-architecture/`
- `/docs/04-features/`
- `/docs/05-flows/`
- `/docs/06-database/`
- `/docs/07-planning/`
- `/resources/views/`
- `/resources/js/`
- `/app/` (if relevant)

If batch context exists:
- `/docs/08-active/`

Exclude:
- `/docs/_archive/`

Write:
- one `docs/11-ai/active-doc-reviews/doc-sync-####.md` review file
- the matching row in `docs/11-ai/active-doc-reviews/index.md`

Do NOT write:
- canonical docs
- planning notes
- active batch state files outside evidence gathering
- any file outside `docs/11-ai/active-doc-reviews/`

---

## Rules

- Do NOT modify files
- Do NOT propose redesign
- Do NOT expand scope
- Do NOT introduce new systems or layers
- Only identify:
  - drift
  - inconsistencies
  - gaps
  - ambiguities
  - conflicts
- Treat implementation as source of truth unless clearly incorrect
- When the review is triggered by approved batch or phase close-out, also treat the reviewed implementation outcome and approved deferment state as source of truth for affected planning/status docs
- If the request references an existing `doc-sync-####` file or indicates a re-review:
  - do NOT create a new review file
  - update the existing review file
  - increment `Review Pass`
  - update the existing index row
- If the requested target is missing, or the scope expands beyond one implementation area or active batch, STOP and narrow it before continuing

---

## Review Focus

### 1. Standards Alignment
Confirm:
- implementation matches UI standards (tokens, variants, semantics)
- no drift from Tier 1 / Tier 2 rules

Flag:
- mismatches between implementation and standards

---

### 2. Contract Alignment
Confirm:
- components behave as defined in Tier 1 contracts
- allowed variants and states match contracts

Flag:
- missing or incorrect behavior

---

### 3. UI Reference Accuracy
Confirm:
- UI Reference reflects real component behavior
- no mock or outdated examples

Flag:
- incorrect examples
- missing coverage

---

### 4. Feature Documentation Alignment
Confirm:
- feature docs match actual UI/behavior

Flag:
- outdated descriptions
- missing features

---

### 5. Architecture Alignment
Confirm:
- implementation matches documented structure
- no undocumented patterns

Flag:
- structure drift
- ownership inconsistencies

---

### 6. Active Batch Alignment
Confirm:
- `/docs/08-active/checklist.md` reflects actual implementation state

Flag:
- incorrect or prematurely completed items

---

### 7. Naming and Terminology
Confirm:
- canonical naming is consistent across implementation and docs

Flag:
- legacy terms
- conflicting terminology

---

### 8. Ownership Boundaries
Confirm:
- one canonical owner per concern

Flag:
- duplicated ownership
- conflicting definitions

---

### 9. Planning and Status Synchronization
Confirm:
- roadmap summaries, phase indices, and parent planning notes reflect the current reviewed implementation state when that state changed sequencing or progress truth
- deferments discovered during reviewed close-out are written to the correct future batch, future phase, or linked planning note

Flag:
- stale roadmap or phase-index status
- missing deferment handoff
- parent planning notes that no longer match the reviewed implementation outcome

---

## Output

Create file:

`/docs/11-ai/active-doc-reviews/doc-sync-####.md`

Determine next ID from:

`/docs/11-ai/active-doc-reviews/index.md`

---

## Output File Structure

# Document Sync Review <ID>

## Review Pass
1

## Target
<system or area>

## Review Type
Docs Sync

## Status
OPEN

## Purpose
<short description>

## Scope
- <paths reviewed>

## Findings

### Finding 1
- type:
- location:
- issue:
- required action:
- constraints:
- decision state:

## Summary
- standards alignment:
- contract accuracy:
- implementation vs docs consistency:

## Unresolved Decisions
- none

## Implementation Status
not started

## Exit Criteria
- no implementation-doc mismatches
- no ownership conflicts
- no outdated documentation
- no missing required coverage

## Resolution Notes
- none

---

## Index Update

Update:

`/docs/11-ai/active-doc-reviews/index.md`

Add row:

- ID
- Date
- Target
- Type = Docs Sync
- Status = OPEN
- Implementation Status = not started

---

## Final Rule

If no meaningful drift is detected:
- still create the review file
- set Status = CLOSED
- record "no findings" in Resolution Notes
