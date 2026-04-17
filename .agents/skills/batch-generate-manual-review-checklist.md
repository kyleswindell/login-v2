# Generate Manual Review Checklist

Create a step-based manual review checklist from the current active batch workspace.

## Scope
- `/docs/08-active/`
  - `batch.md`
  - `checklist.md`
  - `review.md`

## Goal
Translate the current active batch state into a human-executable manual review workflow for visual and functional verification.

## Rules
- Read batch scope and validation surface from `batch.md`
- Derive review items from `checklist.md` only
- Use `review.md` only for blockers and known open issues
- Do NOT derive checklist content from:
  - contracts
  - `worklogs/`
  - `notes.md`
  - implementation history
- Top-level unchecked checklist items are the review drivers
- Each top-level unchecked checklist item must appear in the generated checklist
- You may use checklist-local requirement bullets from the same section in `checklist.md` to expand a top-level unchecked item into executable review steps
- Only use requirement bullets that live in the same checklist section as the unchecked top-level item being expanded
- Do NOT use requirement bullets to introduce new review drivers; they may only expand an existing unchecked top-level item
- Do not assume a specific phase, batch, or system beyond what `batch.md` states
- Do not rewrite implementation details as design critique
- Prefer explicit review steps over generic “review X” wording
- Do NOT output generic entries such as `Review Button`
- Each unchecked top-level item must expand into multiple concrete, verifiable review checks when checklist-local requirement bullets provide that detail
- If an unchecked top-level item cannot be expanded into at least one concrete executable step from `checklist.md`, return `status: NOT READY` or `PARTIAL` with a warning instead of emitting a generic placeholder line

## Tasks

### 1. Read active batch context
Identify:
- batch name
- scope
- out-of-scope boundaries
- validation surface

### 2. Derive pending review items
- Use only top-level unchecked checklist items
- Each top-level unchecked checklist item must appear in the manual review workflow
- Use checklist-local requirement bullets from the same section only when needed to turn those unchecked items into concrete review steps
- Do NOT use `review.md` to create checklist steps
- Do NOT use `batch.md` beyond scope and validation-surface framing
- Do NOT use any external sources

### 3. Expand each item into executable review steps
For each unchecked top-level item:
- convert it into concrete review steps
- include the specific states, behaviors, structural checks, or validations that a human should verify
- use section-local requirement bullets where they provide the executable detail needed for expansion
- do not rely on memory of contracts or prior context
- do not leave items as generic `Review <item>` lines
- require expansion format:
  - component -> multiple verifiable checks
- each item must produce at least one explicit step
- if checklist-local content is insufficient to produce an executable step, flag the item as a warning or blocker instead of outputting a generic review line

Examples:
- `Button` should expand into checks for default, hover, focus, active, disabled, loading, and variant rendering where applicable
- `Table baseline` should expand into checks for sorting, pagination, search/filter visibility, loading state, and empty state
- `Toast baseline` should expand into checks for overlay position, stacking, dismiss behavior, motion, and layout independence

### 4. Organize into step-based review phases
Organize the checklist into these execution phases:
- Coverage / Presence
- State Validation
- Interaction Validation
- Structural / Navigation
- Responsive
- Functional Pass

Do not output a flat undifferentiated list.
Do not use fallback flat-list behavior.
Every generated review step must appear under one of these phases.

### 5. Mark blockers separately
- If `review.md` contains issues that affect meaningful review, list them under blockers
- Do not bury blockers inside the checklist
- If no blockers exist, state that clearly

### 6. Identify high-risk areas
Produce a short list of the most failure-prone areas based on the unchecked checklist items.

### 7. Verify output before returning
Confirm all of the following before returning output:
- no generic `Review <item>` entries remain
- every unchecked top-level checklist item appears in the output
- every unchecked top-level checklist item has at least one expanded executable step
- only `checklist.md` content plus same-section requirement bullets were used for checklist steps
- blockers come from `review.md` only
- the output is grouped into the required execution phases

If any verification check fails:
- do not silently continue
- return `status: PARTIAL` or `status: NOT READY`
- list the affected items under blockers or warnings
- state that executable expansion could not be produced from the allowed sources

## Output
1. status: READY / PARTIAL / NOT READY
2. batch name
3. phase-based manual review checklist
4. high-risk areas
5. blockers (if any)

## Output style
- Use clear section headers
- Use checkboxes
- Use simple human-readable wording
- Expand unchecked checklist items into explicit review steps
- Group output into the required execution phases only
- Do not include file paths unless necessary
- Do not modify files
