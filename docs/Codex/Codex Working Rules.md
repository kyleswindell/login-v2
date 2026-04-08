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

## Related

- [[Standards/Module Development Standards]] | [Module Development Standards](../Standards/Module%20Development%20Standards.md)
- [[Standards/Coding Standards]] | [Coding Standards](../Standards/Coding%20Standards.md)
- [[Standards/Commenting Standards]] | [Commenting Standards](../Standards/Commenting%20Standards.md)
- [[Standards/File Building Standards]] | [File Building Standards](../Standards/File%20Building%20Standards.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../Standards/Tenant%20Safety%20Standards.md)
- [[Codex/Codex Review Checklist]] | [Codex Review Checklist](Codex%20Review%20Checklist.md)
- [[Codex/Codex Module Checklist]] | [Codex Module Checklist](Codex%20Module%20Checklist.md)
- [[Codex/Agent Instruction Model]] | [Agent Instruction Model](Agent%20Instruction%20Model.md)
- [[Codex/Skills Index]] | [Skills Index](Skills%20Index.md)
