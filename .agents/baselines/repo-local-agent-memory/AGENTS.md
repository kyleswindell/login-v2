# Starter Pack Bootstrap

Use this file when the repo-local agent memory starter pack has already been copied into a target repository and an agent should install and configure it there.

## Goal

Apply the starter pack into the target repo's live agent surfaces without writing repo-specific memory entries yet.

## What To Review First

1. `README.md`
2. `memory/CONFIG.example.md`
3. `snippets/adoption-checklist.md`

## Required Outcomes

1. install or reconcile the live `.agents/memory/` lane
2. install or reconcile the memory skills under `.agents/skills/`
3. replace placeholder owner-path values with the target repo's real paths or `none`
4. apply only the generic governance snippets that the target repo does not already have
5. keep this baseline pack generic
6. do not write repo-specific memory entries yet

## Required Decisions

Determine whether the target repo has:

- a canonical docs owner path
- an active workflow-state owner path
- a branch-handoff owner path
- a review/governance artifact owner path

Record real paths or `none` values where appropriate.

## Rules

- Do NOT duplicate rules if the target repo already has equivalent instruction surfaces.
- Do NOT add repo-specific memory content yet.
- Do NOT treat `.agents/memory/` as canonical truth.
- If the target repo's current instruction layering conflicts with this starter pack, stop and explain the conflict before making broad changes.
- Use the adoption checklist before considering the installation pass complete.

## Installation Flow

1. Read the starter-pack README.
2. Review the configuration example and map the owner paths for the target repo.
3. Install or reconcile:
   - `.agents/memory/`
   - the memory skills
   - the required memory-governance snippet(s)
4. Apply recommended generic companion snippets only when the target repo does not already define equivalent governance:
   - instruction-surface separation
   - read-only-to-writable stop gate
   - AI-governance instruction-surface policy
5. Run the adoption checklist.
6. Stop after the baseline is installed and configured. Repo-specific memory seeding should happen in a separate pass.

## Output

1. files updated
2. owner-path decisions made
3. which optional snippets were applied or skipped
4. any conflicts or follow-up decisions
