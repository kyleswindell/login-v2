# Implement Docs Sync Fix

Implement documentation corrections from a docs sync review file.

## Goal
Apply only the documented fixes from a docs sync review to bring canonical documentation in alignment with current implementation.

This includes parent planning/status synchronization when reviewed implementation or approved deferments changed the current truth of roadmap, phase-index, or linked planning docs.

This agent:
- performs corrections directly
- does NOT generate a prompt
- updates canonical docs only within scope
- updates the review file and index after implementation

---

## Required Input

- docs sync review file or ID (e.g. `doc-sync-0001`)

Resolve file via:
- `/docs/11-ai/active-doc-reviews/index.md`

---

## Scope

Read:
- the target docs sync review file
- related canonical docs required to resolve findings

Write:
- canonical docs required to fix drift
- the review file
- `/docs/11-ai/active-doc-reviews/index.md`

Exclude:
- `/docs/_archive/`

---

## Rules

- Do NOT redesign the system
- Do NOT expand scope
- Fix only issues identified in findings
- Keep changes minimal and explicit
- Maintain one canonical owner per concern
- Do NOT duplicate rules across docs
- Do NOT introduce new systems or layers
- Do NOT resolve unresolved decisions unless already implied by canonical docs
- If a finding is actually a code/UI issue, STOP and route to batch workflow

---

## Execution

### 1. Read review state

Extract:
- findings
- status
- unresolved decisions
- implementation status

Proceed only if status is:
- OPEN
- PARTIAL
- READY_FOR_IMPLEMENTATION
- IMPLEMENTED_PENDING_REVIEW

---

### 2. Determine correction scope

- Identify only files required to resolve findings
- Do NOT widen scope unnecessarily

---

### 3. Apply corrections

Implement only required actions.

Focus on:
- removing implementation-doc mismatches
- correcting outdated documentation
- enforcing ownership boundaries
- normalizing terminology
- aligning structure with implementation
- synchronizing affected planning/status docs when the review findings explicitly identified roadmap, phase-index, deferment, or parent planning drift

Do NOT:
- rewrite stable sections unnecessarily
- introduce new standards
- fix unrelated issues

---

### 4. Handle blocked findings

If blocked by unresolved decision:
- do NOT guess
- leave unresolved
- record in Resolution Notes

---

### 5. Update review file

Increment:

## Review Pass
+1 (default = 1 if missing)

Update:

## Implementation Status
- in progress
- implemented
- implemented with follow-up needed

## Status
- PARTIAL
- IMPLEMENTED_PENDING_REVIEW
- CLOSED

Rules:
- NEVER set CLOSED unless all findings resolved and exit criteria met
- default after fix = IMPLEMENTED_PENDING_REVIEW

---

### 6. Enforce Exit Criteria

Only allow CLOSED if:
- no implementation-doc mismatches remain
- no ownership conflicts
- no outdated documentation
- no missing required coverage

---

### 7. Update Resolution Notes

Add:
- files updated
- findings resolved
- findings unresolved
- blockers

---

### 8. Update review index

Update row in:
- `/docs/11-ai/active-doc-reviews/index.md`

Update:
- Status
- Implementation Status
- Notes

Do NOT modify other rows

---

## Validation

Confirm:
- docs reflect current implementation
- ownership is correct
- no conflicting terminology introduced
- no scope expansion occurred
- unresolved decisions preserved
- planning/status docs updated by this pass still summarize state at the right level and defer detailed ownership to their canonical parent docs

---

## Output

1. files updated  
2. findings resolved  
3. findings unresolved  
4. review pass incremented  
5. updated status  
6. updated implementation status  

---

## Final Rule

If the review findings are not docs sync issues, STOP and route to appropriate workflow.
