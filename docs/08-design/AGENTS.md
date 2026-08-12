# AGENTS.md

## Purpose

`docs/08-design/` owns accepted pre-implementation software design for Login 2.0.

Software design translates accepted architecture, behavior, flows, database Contracts, standards, and planning into the concrete technical blueprint used to prepare implementation work.

## Required Reading

Before reading or editing a Software Design Document:

1. read root `AGENTS.md`;
2. read `docs/AGENTS.md`;
3. read this folder's `index.md`;
4. read [Software Design Documentation Standard](../02-standards/documentation/Software%20Design%20Documentation%20Standard.md);
5. read the SDD's governing canonical sources;
6. read applicable accepted planning.

## Rules

- Design from accepted canonical requirements rather than current implementation structure.
- Keep one primary implementation owner for every component and responsibility.
- Use accepted public Contracts across owner boundaries.
- Define exact intended implementation components, paths, interactions, persistence, security, reliability, and verification surfaces.
- Link to canonical architecture, feature, flow, database, and standard owners instead of duplicating their complete content.
- Treat current implementation as reference evidence, not target-design authority.
- Keep implementation status, acceptance criteria, and delivery state in GitHub issues and Projects.
- Do not create empty design folders or speculative components for symmetry.
- Do not resolve missing architecture, behavior, schema, security, or ownership requirements by inference.

## Design Completion

An SDD is implementation-ready only when implementation can proceed without making a new material decision about:

- ownership;
- architecture;
- behavior;
- schema;
- public Contracts;
- security;
- transactions or concurrency;
- component placement;
- integration behavior;
- verification strategy.

## Stop Conditions

Stop when:

- governing canonical sources conflict;
- a material upstream requirement is missing;
- ownership is unclear;
- multiple implementation choices would materially change accepted behavior, architecture, schema, security, or compatibility;
- another writer owns the same design scope.

Resolve the requirement in its canonical owner before finalizing the affected design.