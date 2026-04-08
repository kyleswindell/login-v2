# Agent Instruction Model

## Purpose

Document how project instructions should be layered for Codex and other AI-assisted development tools.

## Model

- `AGENTS.md`: small always-on repo-level contract.
- `docs/Codex/`: deeper guidance, checklists, and project-specific workflows.
- Future `.agents/skills/**/SKILL.md`: reusable on-demand workflows for repeatable tasks.
- Optional future `.github/` instructions: Copilot-specific rules only if needed.

## Why This Matters

Always-on instructions should stay short so they do not bloat agent context. Detailed task instructions belong in docs or skills and should be loaded when relevant.

## Related

- [[Codex/Codex Working Rules]] | [Codex Working Rules](Codex%20Working%20Rules.md)
- [[Codex/Skills Index]] | [Skills Index](Skills%20Index.md)
- [[Documentation Standards/How To Write Docs]] | [How To Write Docs](../Documentation%20Standards/How%20To%20Write%20Docs.md)
- [[00 - Start Here]] | [00 - Start Here](../00%20-%20Start%20Here.md)
