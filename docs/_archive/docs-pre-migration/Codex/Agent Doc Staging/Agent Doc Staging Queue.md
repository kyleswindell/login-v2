# Agent Doc Staging Queue

## Purpose

Define a shared staging location where coding agents can draft documentation updates for review agents to validate and then apply into canonical docs.

## Staging Location

Use this folder for staged doc updates:

* `docs/Codex/Agent Doc Staging/`

Canonical docs still live in their existing owner branches:

* `docs/V2 App/Features/`
* `docs/V2 App/Reference/`
* `docs/V2 App/Runbooks/`
* `docs/V2 App/Planning/`
* `docs/Standards/`
* `docs/Decisions/`

## Workflow

1. Implementation agent creates one staged update note per batch or scoped change in this folder.
2. Implementation agent fills the template sections and links all impacted canonical docs.
3. Implementation agent does not directly edit canonical docs for this staged scope unless explicitly assigned as docs-sync reviewer.
4. Docs-sync review agent periodically reviews queue items, validates accuracy, resolves cross-agent conflicts, and applies approved changes into canonical docs.
5. Docs-sync review agent updates staged note status to `applied` (or `rejected` with reason and follow-up action).

## Naming Convention

Use:

* `YYYY-MM-DD - [Scope] - Proposed Doc Updates.md`

Example:

* `2026-04-14 - Phase 2 Batch 7 - Proposed Doc Updates.md`

## Required Content In Every Staged Note

* staging status (`proposed`, `in review`, `applied`, `rejected`)
* owner agent/session identifier
* created date
* scope summary
* canonical target docs
* proposed content updates
* implementation status impact
* links to code or planning notes that support the update
* final review status

## Related

* [[Codex/Codex Working Rules]] | [Codex Working Rules](../Codex%20Working%20Rules.md)
* [[Standards/Documentation Review Standards]] | [Documentation Review Standards](../../Standards/Documentation%20Review%20Standards.md)
* [[Standards/Implementation Status And Development Sync Standard]] | [Implementation Status And Development Sync Standard](../../Standards/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
