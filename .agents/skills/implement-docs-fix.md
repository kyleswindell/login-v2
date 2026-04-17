# Docs Fix Implementation

Implement documentation corrections from a structured review file.

## Goal
Apply only the documented fixes from an existing review record in `/docs/11-ai/active-doc-reviews/` while preserving canonical ownership, boundaries, and current system intent.

## Required Input

- Review file or ID (e.g. `doc-review-0001`, `doc-sync-0002`)

Resolve file via:
- `/docs/11-ai/active-doc-reviews/index.md`

## Scope

Read:
- review file
- related canonical docs

Write:
- canonical docs (in scope)
- review file
- `/docs/11-ai/active-doc-reviews/index.md`

Exclude:
- `/docs/_archive/`

## Rules

- Do NOT redesign the system
- Do NOT expand scope
- Fix only identified findings
- Keep changes minimal and explicit
- Maintain one canonical owner per concern
- Do NOT duplicate rules across docs
- Do NOT resolve unresolved decisions unless already implied
- If issue is implementation (code/UI), STOP and route to batch work

## Execution

### 1. Read review state

Extract:
- findings
- status
- unresolved decisions
- implementation status

Proceed only if status is:
- `OPEN`
- `PARTIAL`
- `READY_FOR_IMPLEMENTATION`
- `IMPLEMENTED_PENDING_REVIEW`

---

### 2. Determine correction scope

- Identify only files required to resolve findings
- Do NOT widen scope unnecessarily

---

### 3. Apply corrections

- Implement only required actions
- Focus on:
  - ownership
  - terminology
  - boundaries
  - contradictions
  - explicit mappings

Do NOT:
- rewrite stable sections
- introduce new policy
- fix unrelated issues

---

### 4. Handle blocked findings

If blocked by unresolved decision:
- leave finding unresolved
- record in `Resolution Notes`

---

### 5. Update review file

Increment:

## Review Pass
+1 from previous value (default = 1 if missing)

Update:

## Implementation Status
- `in progress`
- `implemented`
- `implemented with follow-up needed`

## Status
- `PARTIAL`
- `IMPLEMENTED_PENDING_REVIEW`
- `CLOSED`

Rules:
- NEVER set `CLOSED` unless all findings are resolved AND exit criteria met
- Default after implementation = `IMPLEMENTED_PENDING_REVIEW`

---

### 6. Enforce Exit Criteria

Only allow `CLOSED` if ALL are true:

- no remaining findings
- no ambiguity
- no ownership conflicts
- no unenforceable rules

If not:
- keep `IMPLEMENTED_PENDING_REVIEW` or `PARTIAL`

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

Fields:
- Status
- Implementation Status
- Notes

Do NOT modify other rows.

---

## Validation

Confirm:
- only in-scope docs changed
- ownership is correct
- no conflicts introduced
- no scope expansion
- unresolved decisions preserved

---

## Output

1. files updated  
2. findings resolved  
3. findings unresolved  
4. review pass incremented  
5. updated status  
6. updated implementation status  

## Final Rule

If findings are actually implementation issues, STOP and route to batch workflow.