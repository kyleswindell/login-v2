# Document Review doc-review-2026-06-01-agent-instruction-surface-separation

## Review Pass
3

## Target
Agent instruction-surface separation across `AGENTS.md`, AI governance docs, skills, and repo-local memory

## Review Type
Document Review

## Status
CLOSED

## Purpose
Confirm that the repo now defines clear responsibilities between persistent agent rules, workflow skills, canonical docs, repo-local memory, and exportable baselines.

## Scope
- `AGENTS.md`
- `docs/11-ai/index.md`
- `docs/11-ai/rules.md`
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/10-runbooks/repo-local-agent-memory.md`
- `.agents/skills/capture-agent-memory.md`
- `.agents/skills/maintain-agent-memory.md`

## Findings

### Finding 1
- type: incomplete surface map
- location: `docs/11-ai/rules.md`, `docs/11-ai/index.md`, and `docs/11-ai/agent-skill-writing-benchmark.md`
- issue: The repo now has five distinct agent-facing surfaces in practice: `AGENTS.md`, workflow skills, canonical docs/runbooks, repo-local memory, and exportable baselines. The benchmark and top-level AI governance docs still center mainly on `AGENTS.md`, skills, and canonical docs, which leaves the newer memory and baseline layers under-described as first-class instruction surfaces.
- required action: Update the AI governance docs to include repo-local memory and exportable baselines in the explicit instruction-surface model, and make the intended owner split easy to find from the AI governance index.
- constraints: Keep the model concise. Do not introduce a sprawling taxonomy when one compact surface map will do.
- decision state: required

### Finding 2
- type: incomplete promotion rule
- location: `AGENTS.md`, `docs/11-ai/rules.md`, `docs/10-runbooks/repo-local-agent-memory.md`, and memory skills
- issue: The current memory guidance correctly says that durable system truth should move into canonical `docs/`, but it does not yet say what should happen when a remembered item becomes a durable agent-execution rule, workflow behavior, or reusable starter-pack concern. That leaves a gap where long-lived execution guidance could remain in memory even though it belongs in `AGENTS.md`, a skill file, or the exportable baseline.
- required action: Expand the promotion rule so memory is promoted into the correct owner surface, which may be canonical `docs/`, `AGENTS.md`, a scoped skill, or the exportable baseline package depending on the type of truth being captured.
- constraints: Preserve canonical product/system truth in `docs/`; do not let memory become a shadow instruction layer.
- decision state: required

### Finding 3
- type: missing memory stop condition
- location: `.agents/skills/capture-agent-memory.md` and `.agents/skills/maintain-agent-memory.md`
- issue: The memory skills already block canonical system truth and active workflow state, but they do not yet explicitly stop when the content is really a persistent instruction-layer change that belongs in `AGENTS.md`, a skill, or the exportable baseline. That weakens the practical separation between memory and agent instructions.
- required action: Add explicit stop/promotion guidance in the memory skills for instruction-layer content.
- constraints: Keep the skills lightweight and repo-local.
- decision state: required

## Summary
- benchmark alignment: partial; the original instruction benchmark is sound, but the newer memory/baseline layers are not yet fully integrated into it
- workflow alignment: partial; the repo has the surfaces, but the separation between memory and durable instruction layers is not yet fully encoded
- readiness: ready for a narrow governance pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- AI governance docs explicitly map `AGENTS.md`, skills, canonical docs/runbooks, repo-local memory, and exportable baselines
- memory promotion rules cover both canonical docs and durable instruction surfaces
- memory skills stop or escalate when content belongs in agent instructions rather than memory

## Resolution Notes
- Review found a layering/ownership clarification gap, not a need to redesign the existing memory model.
- Added a compact surface map in:
  - `docs/11-ai/instruction-surface-separation.md`
  - `docs/11-ai/index.md`
  - `docs/11-ai/rules.md`
  - `docs/11-ai/agent-skill-writing-benchmark.md`
  - `AGENTS.md`
- Expanded the memory promotion rules in:
  - `AGENTS.md`
  - `docs/10-runbooks/repo-local-agent-memory.md`
  - `docs/11-ai/rules.md`
  - `.agents/skills/capture-agent-memory.md`
  - `.agents/skills/maintain-agent-memory.md`
- Mirrored the same separation rule into the exportable baseline package so the baseline and live installation do not drift immediately.
- Re-review found no remaining scoped drift. The top-level governance docs, live memory layer, memory skills, and exportable baseline now agree on the owner split between `AGENTS.md`, skills, canonical docs, repo-local memory, and reusable baseline packaging.
