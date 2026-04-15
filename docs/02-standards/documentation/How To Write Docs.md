# How To Write Docs

Use this guide before creating or expanding documentation in this vault.

## Authority And Scope

Use this note together with the vault structure guide:

- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)

This note governs:

- documentation content quality
- documentation types and sections
- when docs must be updated

The Obsidian vault structure guide governs and overrides this note for:

- file naming
- folder naming
- note placement
- parent/child graph structure
- Obsidian link/reference structure

## Principles

- Every concept must exist in exactly one place, and everything else links to it.
- Write for the next developer or future version of yourself.
- Prefer short, accurate notes over long, stale documentation.
- Explain why a thing exists, not only where it lives.
- Link related notes using both Obsidian links and standard Markdown links.
- Keep implementation details close to feature/module docs, and general rules in `02-standards/`.
- Treat documentation like code: keep it in version control, review it with changes, and make it searchable.
- When code changes affect setup, usage, releases, tenant behavior, public website behavior, or developer workflow, update the related docs in the same change.
- Prefer portable Markdown over Obsidian-only features so notes remain useful in GitHub, IDE previews, and agent context.

## Documentation Modes

Use a Diataxis-style split so every note has a clear job.

- `Tutorial`: teaches a path from zero to success.
- `How-to`: gives steps to complete a specific task.
- `Reference`: documents exact interfaces, folders, config, tables, and commands.
- `Explanation`: explains rationale, tradeoffs, and system behavior.
- `Decision`: records a specific architecture or product decision.
- `Runbook`: captures repeatable operational procedures.

## Canonical Ownership

Before writing a note, decide where the concept canonically lives.

- `03-architecture/`: system structure, boundaries, and architecture ownership
- `04-features/`: canonical feature behavior and contracts
- `06-database/`: schema and data contracts
- `10-runbooks/`: repeatable operational procedures
- `02-standards/`: implementation rules and conventions
- `09-reference/`: non-canonical support, research, and tracking notes
- `01-decisions/`: ADRs and decision records
- `11-ai/`: AI-assistance instructions and lifecycle rules

If the concept already exists somewhere else, update the canonical note and link to it instead of creating a second owner.

## Standard Sections

Use these sections when they fit. It is okay to omit sections that do not apply.

```md
# Title

## Purpose

## Implementation Status

## Current Implementation

## Important Files

## Data / Tables

## Permissions / Security

## Tenant Considerations

## Logging / Observability

## Common Workflows

## Open Questions

## Related
```

## Link Format

Each important cross-reference should include both styles:

```md
[Logging Standards](../logging/Logging%20Standards.md)
```

Use links intentionally:

- link upward to the parent/index note
- link laterally to strong dependencies
- prefer links over duplicated explanation
- keep index notes current when adding child notes

## Documentation Types

- `03-architecture/`: system-wide design and boundaries.
- `04-features/`: user-facing and business capabilities.
- `06-database/`: data structures, contracts, and schema notes.
- `02-standards/`: global rules and conventions.
- `10-runbooks/`: repeatable operational steps.
- `01-decisions/`: architecture and product decisions.
- `09-reference/`: non-authoritative support material.
- `11-ai/`: AI-assistance instructions and checklists.

## Docs Travel With Code

When changing behavior, ask:

- Does a user/admin workflow change?
- Does setup, build, cron, deployment, or release behavior change?
- Does a tenant-aware rule change?
- Does a module interface, table, option, or endpoint change?
- Does an agent/Codex workflow need an updated rule?

If yes, update or create the relevant documentation note before considering the work complete.

When a planned system becomes implemented or changes materially:

- update the canonical system doc in the same work cycle
- update the linked planning note in the same work cycle
- make sure both notes link to each other
- make sure both notes state the current implementation status clearly enough to answer:
  - is it planned only?
  - is it implemented in code?
  - is it migrated or deployed on staging?
  - is there a UI yet?

## Structure Expectations

For vault organization, obey the Obsidian structure guide first:

- every note must be reachable from `[[00-start-here]]`
- every concept must have one canonical home
- parent/index notes must link to children
- detailed notes should link back to their parent/index note
- when a planning note drives a system, it should link to the canonical system doc and the canonical system doc should link back to the planning note
- folder placement alone is not enough; the graph must be built with links

## Writing Expectations

Inside the note itself:

- state the purpose clearly
- describe the current implementation rather than an imagined target state unless the note is explicitly a plan or ADR
- distinguish summary from exact reference material
- keep explanations close to the feature, module, or reference that owns the concept
- avoid repeating the same explanation across multiple notes
- when a note mainly exists to route readers, keep it concise and make the links strong
- planning notes may repeat a short implementation status summary from the canonical system doc when that helps readers confirm the current state quickly

## Changelog And Release Notes

- Keep short curated patch notes in a future `CHANGELOG.md`.
- Keep longer narrative release notes in `99-changelog/` when that branch is introduced.
- Use release notes for migration steps, operational cautions, screenshots, rollout notes, and breaking behavior changes.
- Link release notes to ADRs when a release contains important architectural decisions.

## Related

- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Documentation Template](Documentation%20Template.md)
- [Tutorial Template](Templates/Tutorial%20Template.md)
- [How-To Template](Templates/How-To%20Template.md)
- [Reference Template](Templates/Reference%20Template.md)
- [Explanation Template](Templates/Explanation%20Template.md)
- [Feature Spec Template](Templates/Feature%20Spec%20Template.md)
- [Runbook Template](Templates/Runbook%20Template.md)
- [ADR Template](Templates/ADR%20Template.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [00-start-here](../../00-start-here.md)
