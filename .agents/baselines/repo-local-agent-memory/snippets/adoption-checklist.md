# Repo-Local Agent Memory Adoption Checklist

Use this checklist after copying the baseline into a target repo and before agents begin writing memory.

## Required

- [ ] `.agents/memory/` was installed
- [ ] memory skills were installed under `.agents/skills/`
- [ ] placeholder owner paths were replaced or explicitly set to `none`
- [ ] the target repo's `AGENTS.md` or equivalent instruction layer now defines repo-local memory ownership
- [ ] the target repo now distinguishes canonical docs truth from repo-local memory
- [ ] the target repo explicitly forbids secrets and sensitive raw data in memory

## Recommended

- [ ] the target repo defines instruction-surface separation
- [ ] the target repo defines the read-only-to-writable stop gate for shared worktrees
- [ ] the target repo added an optional memory runbook or equivalent governance note
- [ ] the target repo seeded only stable high-signal memory first
- [ ] the target repo has not copied repo-specific live memory back into the baseline pack
