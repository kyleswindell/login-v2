# bootstrap AGENTS.md

## Purpose

Laravel bootstrap files and application startup wiring.

## Read Order

1. Open only the bootstrap file tied to the task or error.
2. Cross-check architecture and runbooks before changing startup behavior.

## Avoid

- Do not inspect bootstrap files for ordinary feature implementation.
- Do not change application startup, provider registration, or cache behavior without a clear root-cause requirement.
