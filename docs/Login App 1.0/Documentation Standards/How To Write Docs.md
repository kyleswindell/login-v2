# How To Write Docs

Use this guide before creating or expanding documentation in this vault.

## Authority And Scope

Use this note together with the vault structure guide:

- [[Documentation Standards/Obsidian Vault Structure Guide]] | [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)

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
- Keep implementation details close to feature/module docs, and general rules in `Standards/`.
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

- `V1 App/Architecture/`: current V1 system behavior and implementation rationale
- `V1 App/Features/`: current V1 user/admin capabilities spanning one or more modules
- `V1 App/Modules/`: V1 module-specific implementation and responsibilities
- `V1 App/Reference/`: exact V1 interfaces, tables, routes, settings, and maps
- `V1 App/Folder Reference/`: V1 files/folders and what belongs there
- `V1 App/Runbooks/`: V1 repeatable operational procedures
- `Standards/`: implementation rules and conventions
- `Documentation Standards/`: documentation-system rules and templates
- `Decisions/`: ADRs and important decision records
- `V1 App/Releases/`: V1 narrative release notes and rollout context
- `Codex/`: AI-assistance instructions and checklists

If the concept already exists somewhere else, update the canonical note and link to it instead of creating a second owner.

## Standard Sections

Use these sections when they fit. It is okay to omit sections that do not apply.

```md
# Title

## Purpose

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
[[Standards/Logging Standards]] | [Logging Standards](../Standards/Logging%20Standards.md)
```

Use links intentionally:

- link upward to the parent/index note
- link laterally to strong dependencies
- prefer links over duplicated explanation
- keep index notes current when adding child notes

## Documentation Types

- `Architecture/`: System-wide design and how major parts fit together.
- `Modules/`: Module-specific docs for custom or important Perfex modules.
- `Features/`: User-facing or business capability docs that may span multiple modules.
- `Folder Reference/`: What folders/files are for and what belongs there.
- `Standards/`: Rules and conventions for implementation.
- `Runbooks/`: Repeatable operational steps.
- `Decisions/`: Architecture decision records.
- `Releases/`: Narrative release notes and migration/rollout context.
- `Codex/`: Instructions and checklists for AI-assisted development.

## Docs Travel With Code

When changing behavior, ask:

- Does a user/admin workflow change?
- Does setup, build, cron, deployment, or release behavior change?
- Does a tenant-aware rule change?
- Does a module interface, table, option, or endpoint change?
- Does an agent/Codex workflow need an updated rule?

If yes, update or create the relevant documentation note before considering the work complete.

## Structure Expectations

For vault organization, obey the Obsidian structure guide first:

- every note must be reachable from `[[00 - Start Here]]`
- every concept must have one canonical home
- parent/index notes must link to children
- detailed notes should link back to their parent/index note
- folder placement alone is not enough; the graph must be built with links

## Writing Expectations

Inside the note itself:

- state the purpose clearly
- describe the current implementation rather than an imagined target state unless the note is explicitly a plan or ADR
- distinguish summary from exact reference material
- keep explanations close to the feature, module, or reference that owns the concept
- avoid repeating the same explanation across multiple notes
- when a note mainly exists to route readers, keep it concise and make the links strong

## Changelog And Release Notes

- Keep short curated patch notes in a future `CHANGELOG.md`.
- Keep longer narrative release notes in `Releases/`.
- Use release notes for migration steps, operational cautions, screenshots, rollout notes, and breaking behavior changes.
- Link release notes to ADRs when a release contains important architectural decisions.

## Related

- [[Documentation Standards/Obsidian Vault Structure Guide]] | [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [[Documentation Standards/Documentation Template]] | [Documentation Template](Documentation%20Template.md)
- [[Documentation Standards/Templates/Tutorial Template]] | [Tutorial Template](Templates/Tutorial%20Template.md)
- [[Documentation Standards/Templates/How-To Template]] | [How-To Template](Templates/How-To%20Template.md)
- [[Documentation Standards/Templates/Reference Template]] | [Reference Template](Templates/Reference%20Template.md)
- [[Documentation Standards/Templates/Explanation Template]] | [Explanation Template](Templates/Explanation%20Template.md)
- [[Documentation Standards/Templates/Feature Spec Template]] | [Feature Spec Template](Templates/Feature%20Spec%20Template.md)
- [[Documentation Standards/Templates/Runbook Template]] | [Runbook Template](Templates/Runbook%20Template.md)
- [[Documentation Standards/Templates/ADR Template]] | [ADR Template](Templates/ADR%20Template.md)
- [[Standards/Documentation Review Standards]] | [Documentation Review Standards](../Standards/Documentation%20Review%20Standards.md)
- [[00 - Start Here]] | [00 - Start Here](../00%20-%20Start%20Here.md)
