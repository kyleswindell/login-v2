---
description: "Define or refine a phase's goals, deliverables, constraints, and cross-phase dependencies. Produces the finalized phase plan that phase-batch-planning then consumes. Use before batches exist or when phase scope needs realignment."
name: "Phase Planning"
argument-hint: "Phase to define or realign, for example: Phase 3"
agent: "plan"
---
Define or refine the goals, deliverables, and constraints for the specified phase.

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
