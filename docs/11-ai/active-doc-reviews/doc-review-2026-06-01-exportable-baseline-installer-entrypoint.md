# Document Review doc-review-2026-06-01-exportable-baseline-installer-entrypoint

## Review Pass
3

## Target
Exportable baseline installer entrypoint across the starter-pack root README and agent-facing bootstrap instructions

## Review Type
Document Review

## Status
CLOSED

## Purpose
Provide a single file inside the exportable starter pack that an import-repo agent can be pointed at directly to install and configure the baseline.

## Scope
- `.agents/baselines/repo-local-agent-memory/README.md`
- a new root-level agent-facing bootstrap file inside `.agents/baselines/repo-local-agent-memory/`

## Findings

### Finding 1
- type: missing agent-facing entrypoint
- location: `.agents/baselines/repo-local-agent-memory/`
- issue: The starter pack README explains the baseline well, but an import-repo operator still has to restate or paste a bootstrap prompt manually. The pack does not yet contain a single agent-facing entrypoint file that can be referenced as “apply this starter pack here.”
- required action: Add a root-level bootstrap instruction file such as `AGENTS.md` or an equivalent explicit installer entrypoint inside the exportable pack, and update the README to point agents/operators to it as the direct starting file.
- constraints: Keep the file generic and installation-focused. Do not turn it into repo-specific memory content or a second copy of the whole README.
- decision state: required

## Summary
- benchmark alignment: good; the pack is already exportable, but missing a direct agent bootstrap surface
- workflow alignment: partial; installation guidance exists, but not yet as a single agent-facing starting file
- readiness: ready for a narrow packaging pass

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the exportable starter pack contains a single direct agent-facing bootstrap file
- the README tells operators to point an import-repo agent at that file
- the bootstrap file covers the installation/configuration pass without requiring pasted prompt prose

## Resolution Notes
- Review found a packaging/entrypoint gap, not a problem with the baseline design.
- Added a root-level exportable bootstrap file:
  - `.agents/baselines/repo-local-agent-memory/AGENTS.md`
- Updated the baseline README so operators know to point an import-repo agent at that file directly.
- Kept the new file installation-focused and generic rather than duplicating the full README or adding repo-specific memory content.
- Re-review found no remaining scoped issue. The starter pack now has a direct agent-facing bootstrap file, and the README clearly points operators to it as the intended import-repo entrypoint.
