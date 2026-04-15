# Codex Working Rules

## Purpose

Give Codex a concise project-specific operating guide.

## Rules

- Keep `AGENTS.md` concise and treat it as the always-on contract.
- Use this vault as the deeper instruction layer for both V1 and V2 work.
- For V1 work, prefer custom module changes under `application/modules/`.
- For V1 work, do not edit `application/system/` unless explicitly requested.
- For V1 work, treat Perfex vendor and template folders as third-party code.
- For V2 work, keep Laravel as the application integration center and use the V2 stack/reference notes before changing stack behavior.
- Use server-side validation for admin or write actions in both codebases.
- Avoid hardcoded tenant paths, domains, secrets, database names, and environment-specific assumptions.
- Follow the shared commenting, logging, security, and testing standards from `Standards/`.
- Prefer structured website content blocks over raw editable HTML when designing editable website systems.
- When a planned V2 system becomes implemented or changes materially, update the canonical system doc and the related planning note in the same work cycle.
- Planning notes must carry a current implementation status section and link directly to their canonical system doc.
- Canonical system docs must link back to the source planning note so the graph shows both design intent and live implementation state.
- For concurrent agent work, keep one writable session per working tree and use separate branches plus separate worktrees when multiple sessions must both edit files.
- CPD guardrail: during `commit/push/deploy`, stage only files the active agent touched for the current requested scope; avoid `git add .` and do not include unrelated staged files.
- If unrelated staged files are discovered before commit, unstage them or pause and ask before proceeding.
- For concurrent documentation work, implementation agents should stage proposed canonical doc updates under `docs/Codex/Agent Doc Staging/`; docs-sync review agents apply approved changes into canonical docs.
- Canonical docs should not be directly edited by multiple implementation agents in parallel without going through the staging queue workflow.

## Related

- [[Standards/Module Development Standards]] | [Module Development Standards](../Standards/Module%20Development%20Standards.md)
- [[Standards/Coding Standards]] | [Coding Standards](../Standards/Coding%20Standards.md)
- [[Standards/Commenting Standards]] | [Commenting Standards](../Standards/Commenting%20Standards.md)
- [[Standards/File Building Standards]] | [File Building Standards](../Standards/File%20Building%20Standards.md)
- [[Standards/Implementation Status And Development Sync Standard]] | [Implementation Status And Development Sync Standard](../Standards/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../Standards/Tenant%20Safety%20Standards.md)
- [[Codex/Codex Review Checklist]] | [Codex Review Checklist](Codex%20Review%20Checklist.md)
- [[Codex/Codex Module Checklist]] | [Codex Module Checklist](Codex%20Module%20Checklist.md)
- [[Codex/Agent Instruction Model]] | [Agent Instruction Model](Agent%20Instruction%20Model.md)
- [[Codex/Agent Doc Staging/Agent Doc Staging Queue]] | [Agent Doc Staging Queue](Agent%20Doc%20Staging/Agent%20Doc%20Staging%20Queue.md)
- [[V2 App/Runbooks/Agent Sessions And Parallel Work]] | [Agent Sessions And Parallel Work](../V2%20App/Runbooks/Agent%20Sessions%20And%20Parallel%20Work.md)
- [[Codex/Skills Index]] | [Skills Index](Skills%20Index.md)
