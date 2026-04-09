# Documentation Review Standards

## Purpose

Keep documentation accurate as application behavior changes.

## Standards

- Documentation changes should travel with code changes when behavior, setup, operations, tenant rules, releases, or public interfaces change.
- If a change has no documentation impact, note that explicitly in the PR or work summary.
- Prefer updating existing docs over creating duplicate notes.
- Every concept must exist in exactly one place, and everything else should link to it.
- Use both Obsidian links and standard Markdown links for important cross-references.
- Keep indexes current when adding new docs sections or major notes.
- Keep the vault graph healthy so notes remain reachable from the start note and from their parent/index notes.
- Use ADRs for meaningful architecture decisions and release notes for rollout context.
- When a planned system becomes implemented, review both the canonical system doc and the linked planning note for current implementation status accuracy.
- Confirm that planning notes and canonical system docs link to each other so the implementation state is discoverable through the graph.

## Review Questions

- Does this change alter how a developer builds, tests, deploys, or operates the app?
- Does this change alter how an admin, tenant, or public website user interacts with the app?
- Does this change alter database schema, sync payloads, permissions, or tenant configuration?
- Does this change need a release note or ADR?
- Does the canonical system doc now need an updated implementation status section?
- Does the related planning note still reflect the current implementation state accurately?

## Related

- [[Documentation Standards/How To Write Docs]] | [How To Write Docs](../Documentation%20Standards/How%20To%20Write%20Docs.md)
- [[Documentation Standards/Obsidian Vault Structure Guide]] | [Obsidian Vault Structure Guide](../Documentation%20Standards/Obsidian%20Vault%20Structure%20Guide.md)
- [[Standards/Release Notes Standards]] | [Release Notes Standards](Release%20Notes%20Standards.md)
