---
description: "Define or refine a phase's goals, deliverables, constraints, and cross-phase dependencies. Produces the finalized phase plan that phase-batch-planning then consumes. Use before batches exist or when phase scope needs realignment."
name: "Phase Planning"
argument-hint: "Phase to define or realign, for example: Phase 3"
agent: "Plan"
---
Define or refine the goals, deliverables, and constraints for the specified phase.

Execution guardrails:
- Prefer direct file edits in the VS Code editor.
- Do not use bash or scripted bulk search/replace to rewrite documentation unless explicitly requested.
- Keep edits minimal and scoped to the target phase docs, linked canonical docs, and the relevant indexes.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Read the overall roadmap, the V2 Documentation Map, and the Architecture Index.
2. Read adjacent phase plans (phase before and phase after if they exist) to understand hand-off contracts.
3. Review any existing planning note for the target phase, or create one if none exists.
4. Define or confirm:
   - Phase goal in one sentence
   - Primary deliverables (user-visible and architectural)
   - Explicit exclusions (what is deferred to later phases)
   - Cross-phase dependencies (what this phase requires from prior phases, what later phases require from this phase)
   - Open decisions that must be resolved before implementation can begin
5. Identify any canonical feature, reference, or runbook docs that this phase owns or extends.
6. Confirm the phase index is accurate — create or update it to reflect the defined plan.
7. Flag any conflicts between this phase definition and adjacent phase boundaries.

Output format:
- Phase Goal
- Primary Deliverables
- Explicit Exclusions
- Cross-Phase Dependencies (requires / provides)
- Open Decisions Required Before Implementation
- Canonical Docs Owned Or Extended
- Phase Index Status (current / updated / needs creation)
- Conflicts With Adjacent Phases (if any)

Git close-out (required when edits were made):
1. Stage only the files changed for this task.
2. Commit with a clear summary of completed work.
3. Push to the current branch.
4. Report commit SHA and pushed branch in the final summary.
