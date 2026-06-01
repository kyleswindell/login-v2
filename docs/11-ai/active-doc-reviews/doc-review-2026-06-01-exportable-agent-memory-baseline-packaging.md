# Document Review doc-review-2026-06-01-exportable-agent-memory-baseline-packaging

## Review Pass
3

## Target
Exportable agent-memory baseline packaging across `.agents/memory/`, memory skills, and setup instructions

## Review Type
Document Review

## Status
CLOSED

## Purpose
Package the new repo-local memory system into a self-contained baseline that can be copied into another repo before any Login V2-specific memory is added.

## Scope
- `.agents/memory/`
- `.agents/skills/capture-agent-memory.md`
- `.agents/skills/maintain-agent-memory.md`
- setup/readme guidance for adopting the baseline in another repo

## Findings

### Finding 1
- type: missing exportable packaging
- location: `.agents/memory/` and related skill files
- issue: The repo now has a live repo-local memory installation, but it does not yet provide a separate exportable baseline pack. Another repo would have to copy files by inference from the live installation instead of having a deliberate starter package.
- required action: Create a separate baseline package under `.agents/` that contains the starter memory structure, the related skills, and a top-level README describing installation and first-configuration steps for another repo.
- constraints: Keep the baseline generic. Do not bake Login V2-specific memory content into the exportable pack.
- decision state: required

### Finding 2
- type: missing setup instructions
- location: memory README and baseline adoption guidance
- issue: The live repo-local memory README explains what the installed memory lane is for, but it does not yet tell another repo how to adopt, configure, and keep the baseline separated from its own canonical docs and workflow state.
- required action: Add explicit installation/configuration instructions for another repo, including what to copy, what to review in that repo's AGENTS/rules/runbooks, and what first-pass configuration decisions should be made before agents start writing memory.
- constraints: Keep instructions tool-agnostic and repo-local.
- decision state: required

## Summary
- benchmark alignment: good direction, but packaging is incomplete
- workflow alignment: partial; the live memory lane is usable here, but the starter-pack adoption path is still implicit
- readiness: ready for a narrow packaging and README pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- an exportable agent-memory baseline package exists separately from the live repo-local installation
- the baseline package includes the starter memory files and related skills
- the README explains how to install and configure the baseline in another repo before writing repo-specific memory

## Resolution Notes
- Review found a packaging/documentation gap, not a problem with the underlying memory model.
- Added an exportable starter pack under `.agents/baselines/repo-local-agent-memory/` with:
  - baseline memory structure
  - baseline memory skills
  - a generic runbook copy
  - setup snippets
  - installation/configuration README guidance
- Updated the live memory README and runbook so the exportable package is discoverable from the configured Login V2 installation.
- Re-review found no remaining scoped packaging issue. The baseline pack is now separate from the live installation, uses generic placeholders where another repo must configure owner paths, and includes enough README/snippet guidance to bootstrap adoption intentionally.
