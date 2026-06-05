# Documentation Review Standards

This document defines the canonical scope and intent for Documentation Review Standards.

## Purpose

Keep documentation accurate as application behavior changes.

## Standards

- Documentation changes should travel with code changes when behavior, setup, operations, tenant rules, releases, or public interfaces change.
- If a change has no documentation impact, note that explicitly in the PR or work summary.
- Prefer updating existing docs over creating duplicate notes.
- Every concept must exist in exactly one place, and everything else should link to it.
- Use both Obsidian links and standard Markdown links for important cross-references.
- Keep indexes current when adding new docs sections or major notes.
- Confirm large or mixed-scope files are split into indexed child files when future readers usually need only one section.
- Keep the vault graph healthy so notes remain reachable from the start note and from their parent/index notes.
- Use ADRs for meaningful architecture decisions and release notes for rollout context.
- When a planned system becomes implemented, review both the canonical system doc and the linked planning note for current implementation status accuracy.
- Confirm that planning notes and canonical system docs link to each other so the implementation state is discoverable through the graph.
- Keep decisions in canonical owner notes by default, and elevate them into `01-decisions/` only when they are cross-cutting, durable, superseding, or require explicit lifecycle status.

## Review Questions

- Does this change alter how a developer builds, tests, deploys, or operates the app?
- Does this change alter how an admin, tenant, or public website user interacts with the app?
- Does this change alter database schema, sync payloads, permissions, or tenant configuration?
- Does this change need a release note or ADR?
- If it needs an ADR, is the decision cross-cutting or durable enough that future readers will need explicit rationale and status outside the owner note?
- Does the canonical system doc now need an updated implementation status section?
- Does the related planning note still reflect the current implementation state accurately?
- Did this change make a doc too broad, or should a new focused child file and index entry own the added material?
- If a large doc was split, does the old path remain as a hub when existing links target it?

## Related

- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Release Notes Standards](Release%20Notes%20Standards.md)
