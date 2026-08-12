# AGENTS.md

## Folder Purpose

This folder owns canonical standards for documentation quality, document types, governance, structure, review, planning, decisions, runbooks, and implementation-status synchronization.

This file is agent-facing routing guidance. Durable requirements remain in the standards documents in this folder.

---

## Ownership

This folder may contain standards governing:

- universal documentation authoring
- controlled document types
- document metadata and lifecycle
- canonical branch ownership
- folder placement and navigation
- software design documentation governance and design-readiness requirements
- planning-document governance
- decision-record governance
- runbook-document governance
- documentation review
- implementation-status synchronization
- documentation template usage

This folder must not contain:

- copyable templates
- project planning documents
- decision records
- executable operational runbooks
- architecture, feature, flow, or database truth
- agent working-document drafts
- source research
- implementation worklogs
- executable agent skills
- generated reports

Copyable templates belong in:

- `docs/09-reference/templates/docs/`
- `docs/09-reference/templates/agents/`

Planning documents belong in:

- `docs/07-planning/`

Decision records belong in:

- `docs/01-decisions/`

Executable runbooks belong in:

- `docs/10-runbooks/`

Coding-agent standards belong in:

- `docs/02-standards/coding-agents/`

Agent working documents belong in:

- `docs/11-ai/`

Executable agent workflows belong in:

- `.agents/skills/`

---

## Required Reading

Before editing this folder, read:

1. root `AGENTS.md`
2. `docs/AGENTS.md` if present
3. `docs/02-standards/AGENTS.md` if present
4. `docs/02-standards/documentation/index.md`
5. the standard that owns the requested change

Use this routing table:

| Change | Canonical Owner |
| --- | --- |
| Universal writing, metadata, lifecycle, and author workflow | `How To Write Docs.md` |
| Controlled `doc_type` values and baseline type contracts | `Document Type Standards.md` |
| Software Design Documents, implementation-blueprint ownership, and design readiness | `Software Design Documentation Standard.md` |
| Planning-document structure, lifecycle, issue boundaries, and promotion | `Planning Documentation Standards.md` |
| Decision elevation, numbering, acceptance, amendment, and supersession | `Decision Record Standards.md` |
| Runbook qualification, safety, recovery, evidence, and validation | `Runbook Documentation Standards.md` |
| Branch ownership, classification, links, indexes, and promotion | `Doc Governance.md` |
| Folder placement, naming, parent/child graph, and Obsidian portability | `Obsidian Vault Structure Guide.md` |
| Documentation review and completion checks | `Documentation Review Standards.md` |
| Planning, issue, implementation, and canonical-doc synchronization | `Implementation Status And Development Sync Standard.md` |

When changing planning requirements, also inspect:

- `docs/07-planning/AGENTS.md`
- `docs/07-planning/index.md`
- `docs/09-reference/templates/docs/_planning.md`

When changing software-design requirements, also inspect:

- `docs/08-design/AGENTS.md`
- `docs/08-design/index.md`
- `docs/09-reference/templates/docs/_design.md`

When changing decision-record requirements, also inspect:

- `docs/01-decisions/AGENTS.md`
- `docs/01-decisions/index.md`
- `docs/09-reference/templates/docs/_decision.md`

When changing runbook requirements, also inspect:

- `docs/10-runbooks/AGENTS.md`
- `docs/10-runbooks/index.md`
- `docs/09-reference/templates/docs/_runbook.md`

Prefer targeted section reads. Do not load unrelated branches, all planning files, all decisions, or all runbooks.

---

## Authoring Rules

When creating or materially rewriting a standard in this folder:

- include a valid `DOC-META` block
- use `doc_type: standard`
- use `owner: docs`
- use this folder index as the parent
- use portable Markdown links
- update `index.md` in the same change
- update `docs/02-standards/index.md` when the standard should be visible there
- keep rules enforceable
- route type-specific requirements to the correct type standard
- link to templates instead of copying complete template bodies
- avoid duplicating requirements owned by another standard
- update affected branch indexes and `AGENTS.md` files when routing changes

Do not introduce new metadata fields, controlled values, document types, or documentation branches without explicit approval.

---

## Current Source Roles

| Surface | Owns |
| --- | --- |
| Canonical documentation branches | Durable repository truth |
| GitHub issues | Bounded work packets and acceptance criteria |
| GitHub Projects | Active delivery status, priority, and sequencing |
| Root and scoped `AGENTS.md` | Persistent agent rules |
| `.agents/skills/` | Repeatable agent procedures |
| `docs/11-ai/` | Non-canonical agent drafts, reviews, research, and promotion candidates |
| Templates | Copyable document shape |
| Standards | Rules governing use and completion |

Planning documents own accepted planning intent, not active task state.

Decision records own durable rationale, not complete current-state descriptions.

---

## Verification

For changes in this folder, verify:

- every new or materially rewritten standard has valid `DOC-META`
- `canonical_path` matches the actual path
- `parent` points to this folder index
- important links use portable Markdown
- `index.md` is current
- the parent standards index is updated when required
- the selected `doc_type` is valid
- the correct template is referenced
- no complete template body was copied into a standard
- no competing canonical owner was introduced
- planning and decision routing is current
- `docs/11-ai/` remains non-canonical
- GitHub issues and Projects remain delivery owners
- executable agent workflows remain under `.agents/skills/`

Run documentation guardrails when available.

---

## Stop Conditions

Stop and ask when:

- standards conflict
- the canonical owner is unclear
- a change mixes document-type policy with domain-specific technical policy
- a change would introduce a new controlled `doc_type`, status, or owner
- a change would move content across canonical branches
- a change requires broad path or link rewrites
- a dedicated type standard would overlap an existing standard
- a procedure may belong in a runbook rather than a standard
- a workflow may belong in a skill rather than documentation
- a proposed file may be working material rather than canonical documentation
- a decision lacks human acceptance authority
- a planning document would recreate delivery-state ownership
- the change would create a second active authority

---

## Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Planning Documentation Standards](Planning%20Documentation%20Standards.md)
- [Decision Record Standards](Decision%20Record%20Standards.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Standards Index](../index.md)
- [Documentation Templates](../../09-reference/templates/docs/_index.md)
