# Document Review 0015

## Review Pass
2

## Target
`docs/11-ai/agent-skill-writing-benchmark.md` and the attached commercial guidance source set for `AGENTS.md` / `SKILL.md` writing.

## Review Type
Document Review

## Status
CLOSED

## Purpose
Audit the attached notes and cited sources for accuracy, source quality, and practical value, then identify what the repo's benchmark and future review files should actually absorb about commercial-grade `AGENTS.md` and `SKILL.md` authoring.

## Scope
- `docs/11-ai/agent-skill-writing-benchmark.md`
- `docs/11-ai/active-doc-reviews/doc-review-0015.md`
- Attached note source: `C:\Users\kswin\.codex\attachments\daafad93-72d2-452f-9f45-5254f56506ce\pasted-text.txt`
- Official reference: [Custom instructions with AGENTS.md – Codex](https://developers.openai.com/codex/guides/agents-md)
- Official reference: [Agent Skills – Codex](https://developers.openai.com/codex/skills)
- Official reference: [Worktrees – Codex app](https://developers.openai.com/codex/app/worktrees)
- Secondary reference: [How to write a great agents.md: Lessons from over 2,500 repositories](https://github.blog/ai-and-ml/github-copilot/how-to-write-a-great-agents-md-lessons-from-over-2500-repositories/)
- Secondary reference: [microsoft/aspire `AGENTS.md`](https://github.com/microsoft/aspire/blob/main/AGENTS.md)
- Secondary reference: [skill.md explained: How to structure your product for AI agents](https://www.gitbook.com/blog/skill-md)
- Secondary reference: [Paradime guide to Claude skills, plugins, and rules](https://www.paradime.io/guides/claude-code-skills-plugins-rules-guide)
- Discovery/community references from the attached note were reviewed as lower-authority background only.

## Findings

### Finding 1
- type: accuracy
- location: `C:\Users\kswin\.codex\attachments\daafad93-72d2-452f-9f45-5254f56506ce\pasted-text.txt`
- issue: The attached note is not safe to treat as canonical in its current form. It contains formatting loss where key filenames are missing, mixes official and community sources without source weighting, and includes cross-tool claims that are broader than what the primary Codex documentation directly supports.
- required action: Any repo-owned benchmark or runbook that uses this note should convert it into a weighted source review first, not copy it as-is. At minimum, distinguish:
  - Codex-native behavior and file discovery rules
  - broadly useful commercial writing heuristics
  - speculative or community-only conventions
- constraints: Do not let a pasted synthesis become a hidden source of truth when it includes malformed placeholders and unsupported generalizations.
- decision state: resolved

### Finding 2
- type: gap
- location: `docs/11-ai/agent-skill-writing-benchmark.md:1-124`, [Custom instructions with AGENTS.md – Codex](https://developers.openai.com/codex/guides/agents-md), [Agent Skills – Codex](https://developers.openai.com/codex/skills)
- issue: The current benchmark is strong on `SKILL.md` operational depth, but it underemphasizes instruction discovery, layering, and file-loading behavior for `AGENTS.md` and skills. The official Codex docs make these behaviors explicit: root and nested `AGENTS.md` files layer by directory, overrides should live close to specialized work, and skills use progressive disclosure with only name/description loaded up front.
- required action: Expand the benchmark so it audits not just skill body quality, but also whether a repo is using the right instruction surface for the right kind of knowledge:
  - persistent repo norms in `AGENTS.md`
  - local overrides near specialized directories
  - task-specific workflows in `SKILL.md`
  - optional scripts/references/assets for progressive disclosure
- constraints: Do not collapse `AGENTS.md` and `SKILL.md` into interchangeable “agent files”; the benchmark should preserve their distinct loading models and context costs.
- decision state: resolved

### Finding 3
- type: gap
- location: `docs/11-ai/agent-skill-writing-benchmark.md:125-216`, [How to write a great agents.md: Lessons from over 2,500 repositories](https://github.blog/ai-and-ml/github-copilot/how-to-write-a-great-agents-md-lessons-from-over-2500-repositories/), [microsoft/aspire `AGENTS.md`](https://github.com/microsoft/aspire/blob/main/AGENTS.md)
- issue: The benchmark currently focuses on completeness and safety, but it does not yet call out several commercial-writing traits that recur in stronger production rulebooks:
  - exact build, test, and lint commands early
  - explicit boundaries on what the agent must not modify
  - concrete examples copied from real repo conventions
  - environment-specific verification guidance
  - operational notes for long-running processes, background jobs, and test reliability
- required action: Add a section to the benchmark for “commercial production characteristics” so repo audits check whether `AGENTS.md` files are not only safe, but also operationally useful to a delivery team.
- constraints: Keep this additive; do not replace the existing lifecycle/safety benchmark with style-only heuristics.
- decision state: resolved

### Finding 4
- type: conflict
- location: `C:\Users\kswin\.codex\attachments\daafad93-72d2-452f-9f45-5254f56506ce\pasted-text.txt`, [Agent Skills – Codex](https://developers.openai.com/codex/skills)
- issue: The attached note presents several quantitative or universal claims that the primary sources reviewed here do not establish as hard rules. Examples include:
  - a fixed “under 5,000 tokens” body target for skills
  - an implied universal open standard equally “natively understood” across all major coding agents
  - directory/path claims that may be valid for some tools but are not Codex-global facts unless the official docs say so
  The official Codex docs do support progressive disclosure and a capped initial skill list, but not all of the stronger numeric or cross-vendor claims in the note.
- required action: Add a source-weighting rule to the benchmark and future review notes:
  - official product docs define behavior
  - repo examples and reputable platform guidance inform patterns
  - blogs, issues, awesome lists, and Reddit threads are discovery aids only unless corroborated
- constraints: Do not adopt a numeric style rule just because a secondary article suggested it; require primary confirmation or mark it as a local heuristic.
- decision state: resolved

### Finding 5
- type: gap
- location: `docs/11-ai/agent-skill-writing-benchmark.md:1-216`, [skill.md explained: How to structure your product for AI agents](https://www.gitbook.com/blog/skill-md), [Paradime guide to Claude skills, plugins, and rules](https://www.paradime.io/guides/claude-code-skills-plugins-rules-guide)
- issue: The current benchmark is aimed at repo-owned skills, but it does not yet say enough about when knowledge belongs in canonical product docs versus when it belongs inside repo automation files. The stronger secondary guidance consistently separates:
  - persistent project rules
  - workflow automation playbooks
  - broader product/system documentation that skills can reference rather than duplicate
- required action: Extend the benchmark so audits explicitly ask whether a skill is duplicating information that should instead live in canonical docs or references. Skills should package execution logic and decision rules, while longer product or subsystem explanation should remain in authoritative docs and be referenced progressively.
- constraints: Do not turn skills into full documentation mirrors; preserve them as execution-facing playbooks with references outward.
- decision state: resolved

### Finding 6
- type: accuracy
- location: `C:\Users\kswin\.codex\attachments\daafad93-72d2-452f-9f45-5254f56506ce\pasted-text.txt`, [Custom instructions with AGENTS.md – Codex](https://developers.openai.com/codex/guides/agents-md), [Use custom instructions in VS Code](https://code.visualstudio.com/docs/copilot/customization/custom-instructions), [Explore the .claude directory](https://code.claude.com/docs/en/claude-directory)
- issue: The additional note is directionally correct that subfolder instruction files are appropriate in larger codebases, but the cross-tool behavior is not uniform enough to summarize as one simple “nearest file always wins” rule. The stronger source-backed picture is:
  - Codex supports repository-level `AGENTS.md` plus nested overrides near specialized work, and documents override layering explicitly.
  - VS Code Copilot supports multiple `AGENTS.md` files in subfolders only as an experimental capability, while also supporting `.github/copilot-instructions.md` and path-scoped `.instructions.md` files.
  - Claude Code uses `CLAUDE.md` plus a broader `.claude/` file ecosystem rather than claiming `AGENTS.md` as its primary native file.
- required action: Add a benchmark note or source-hierarchy note that “instruction file ecosystem” claims must be tool-scoped. The repo should avoid flattening Codex, Copilot, Cursor, and Claude behavior into one universal rule without explicitly marking which behavior belongs to which tool.
- constraints: Keep the practical takeaway that subfolder or path-scoped instructions are useful, but do not rewrite repo docs to imply that all tools discover and prioritize those files the same way.
- decision state: resolved

### Finding 7
- type: conflict
- location: `C:\Users\kswin\.codex\attachments\daafad93-72d2-452f-9f45-5254f56506ce\pasted-text.txt`, [Custom instructions with AGENTS.md – Codex](https://developers.openai.com/codex/guides/agents-md), [Agent Skills – Codex](https://developers.openai.com/codex/skills)
- issue: The added note includes several writing heuristics that may be commercially sensible but are not established by the primary docs as hard rules, including:
  - “keep `AGENTS.md` ideally between 100–150 lines”
  - “`AGENTS.md` is the modern standard” across tools
  - “the nearest file to the code being modified is automatically respected” as a generalized cross-platform fact
  The primary sources instead emphasize concision, proximity of overrides, and tool-specific discovery behavior, without setting a universal line-count target or single standard filename across the ecosystem.
- required action: Record these as optional local heuristics rather than benchmark rules. The benchmark should prefer language like:
  - keep always-on instruction files concise and high-signal
  - place specialized overrides close to the work they govern
  - prefer tool-native file discovery where the target platform defines one
- constraints: Do not let convenience heuristics harden into “commercial standard” language unless a primary source or repo-local decision has explicitly adopted them.
- decision state: resolved

### Finding 8
- type: gap
- location: Reddit thread [Using README.md, context.md, agents.md, and architecture.md to scaffold apps with AI — am I missing any key files?](https://www.reddit.com/r/vibecoding/comments/1sgcwns/using_readmemd_contextmd_agentsmd_and/), `docs/00-start-here.md`, `docs/02-standards/index.md`, `docs/03-architecture/index.md`, `docs/04-features/index.md`, `docs/05-flows/index.md`, `docs/06-database/index.md`, `docs/07-planning/index.md`
- issue: The thread raises reasonable file candidates like `roadmap.md`, `implementation_status.md`, `decisions.md`, and `design.md`, but the repo already solves much of that problem through a branch-owned documentation taxonomy instead of a flat top-level file set. In this repo:
  - planning and sequencing already live under `docs/07-planning/`
  - implementation status for active work already lives under `docs/08-active/`
  - architecture and feature context already have separate canonical branches
  Adding generic top-level context files without mapping them to the current docs system would create overlap, not clarity.
- required action: Add a benchmark or governance note that “extra context file” recommendations from general AI workflow discussions must be normalized against the repo’s existing canonical branch model before adoption. The question is not “should we add a `context.md`?” but “which canonical branch already owns that information here?”
- constraints: Do not duplicate branch-owned canonical material into generic AI-context files just because a cross-repo thread recommended them.
- decision state: resolved

### Finding 9
- type: gap
- location: Reddit thread [Using README.md, context.md, agents.md, and architecture.md to scaffold apps with AI — am I missing any key files?](https://www.reddit.com/r/vibecoding/comments/1sgcwns/using_readmemd_contextmd_agentsmd_and/), `docs/00-start-here.md`, `docs/09-reference/index.md`
- issue: The thread’s comments about context bloat, ADR/decision tracking, and documentation versioning are useful, but this repo has an additional documentation constraint the generic thread does not address: the docs tree is still used as an Obsidian-style documentation vault, and link stability matters. That means:
  - file proliferation has a navigation and link-maintenance cost
  - renaming or flattening files for AI convenience can degrade the doc graph
  - support notes should continue to live in canonical branches or `09-reference/` rather than ad hoc agent-facing files
- required action: Add an Obsidian-compatibility note to the benchmark or governance guidance:
  - preserve stable doc paths and explicit markdown links
  - prefer branch/index expansion over generic top-level file sprawl
  - treat ADR/decision material as a first-class need, but place it in a path that fits the current docs architecture rather than inventing disconnected files
- constraints: Do not let AI-oriented file conventions erode the repo’s documentation-vault navigation model.
- decision state: resolved

### Finding 10
- type: partial-coverage
- location: `docs/07-planning/roadmap.md`, `docs/07-planning/index.md`, `docs/08-active/worklogs/index.md`, `docs/02-standards/documentation/Implementation Status And Development Sync Standard.md`
- issue: The repo already covers most of the generic `roadmap.md` and `implementation_status.md` advice that appears in broader AI-documentation discussions. Specifically:
  - roadmap and sequencing already have a canonical home under `docs/07-planning/`
  - active implementation status already has a canonical home under `docs/08-active/`
  - chronological implementation traceability already exists through dated worklog entries with batch IDs, commit state, deploy state, and follow-up notes
  - the implementation-status sync standard already requires planning, canonical docs, and development logs to stay aligned in the same work cycle
  The missing piece is not a new family of generic status files. The missing piece is stronger AI-governance language that tells agents to reuse these existing surfaces instead of inventing parallel tracking notes.
- required action: Update the benchmark and governance roadmap so they explicitly map common AI-documentation suggestions to the repo’s existing canonical system:
  - `roadmap` -> `docs/07-planning/roadmap.md` plus phase/batch indexes
  - active implementation status -> `docs/08-active/` plus worklogs
  - delivery traceability -> dated worklog entries and git-batch-linked commit/deploy notes
  - planning/doc sync -> `Implementation Status And Development Sync Standard`
- constraints: Do not add generic `implementation_status.md` or duplicate planning trackers when the active batch workspace and planning branches already own that responsibility.
- decision state: resolved

### Finding 11
- type: partial-coverage
- location: `docs/01-decisions/index.md`, `docs/02-standards/documentation/How To Write Docs.md`, `docs/02-standards/documentation/Templates/ADR Template.md`
- issue: The canonical decision-record path is now active, which resolves the earlier branch-layout gap. The remaining issue is operational discipline: the repo now has a clear owner path for ADRs, but it still needs explicit guidance for when a decision should stay embedded in architecture/planning notes versus when it should be elevated into `docs/01-decisions/`.
- required action: Update the benchmark and future AI-governance guidance so they treat the decision-record model as:
  - branch path settled: `docs/01-decisions/`
  - elevation rule still needed: define when a decision becomes ADR-worthy versus remaining local to an owner note
  - canonical current-state docs still own implementation truth; ADRs own durable decision rationale and status
- constraints: Do not respond to this remaining gap by scattering `decisions.md` files or duplicating implementation state into ADRs.
- decision state: resolved

### Finding 12
- type: gap
- location: [Agents.md best practices](https://gist.github.com/0xfauzi/7c8f65572930a21efa62623557d83f6e), `docs/11-ai/agent-skill-writing-benchmark.md`
- issue: The benchmark still under-specifies several commercially useful authoring heuristics for root-level agent files. The gist is not authoritative enough to define behavior rules, but it does reinforce a set of secondary-source patterns that fit well with the repo’s current direction:
  - root `AGENTS.md` files should be command-first rather than explanation-first
  - root instruction files should stay compact and high-signal, while specialized detail moves into narrower files or lower-scope instructions
  - verification guidance should prefer file-scoped or narrowly targeted commands before full-suite commands
  - agent instructions should point to known-good implementation examples and known legacy/avoid surfaces where that materially reduces ambiguity
- required action: Extend the benchmark and roadmap with a “commercial authoring heuristics” subsection that treats the following as recommended local heuristics, not hard standards:
  - keep root instruction files concise and push domain detail downward
  - lead with exact setup, test, lint, and verification commands
  - prefer targeted verification commands before full-suite commands
  - include good-example and avoid-example anchors when a repo has clear reference files
- constraints: Do not convert the gist’s `150 lines or less`, `@./path.md` include syntax, or multi-tool symlink guidance into primary-source benchmark rules unless this repo explicitly adopts them as local conventions.
- decision state: resolved

## Source Quality Notes

### High-authority sources
- OpenAI Codex `AGENTS.md` guide: strongest source for file discovery, layering, fallback filenames, and repository-vs-override behavior.
- OpenAI Codex skills docs: strongest source for `SKILL.md` directory structure, required metadata, and progressive disclosure.
- OpenAI Codex worktrees docs: strongest source for app-native worktree behavior and one-branch-per-worktree constraints.

### Strong secondary sources
- GitHub Blog article on `agents.md`: useful for commercial authoring heuristics, especially specificity, boundaries, and examples.
- Microsoft Aspire `AGENTS.md`: strong real-world exemplar for operational commands, testing guidance, and long-running process handling.
- GitBook `skill.md` article: useful for workflow-vs-feature framing and boundary writing, but still secondary and product-marketing-adjacent.
- Paradime harness guide: useful framing for “harness engineering” and the distinction between rules, skills, hooks, and tools, but not a source of Codex-native behavioral facts.
- 0xfauzi `AGENTS.md` best-practices gist: useful as a secondary heuristic source for command-first ordering, compact root files, and layered specificity, but not authoritative enough to define universal tool behavior or numeric line-count limits.
- VS Code Copilot custom instructions docs: strong source for GitHub/Microsoft instruction-file behavior, especially `.github/copilot-instructions.md`, `.instructions.md`, and experimental nested `AGENTS.md` support.
- Claude Code `.claude` docs: strong source for the Claude-native file ecosystem and a useful counterexample to claims that `AGENTS.md` is the universal native file everywhere.

### Lower-authority or discovery-only sources
- GitHub issue threads
- awesome lists
- Substack or Dev.to summaries
- Reddit posts
- vendor or consulting blog posts that do not anchor their claims in primary docs

These can help discover patterns or adjacent terminology, but they should not define repo benchmark rules without corroboration.

## Summary
- strongest takeaway: the attached note is directionally useful but too mixed-quality to adopt directly
- benchmark implication: the repo should widen its audit lens from “how to write a thorough skill” to “how to place and weight instructions across `AGENTS.md`, `SKILL.md`, canonical docs, references, and tool-specific instruction surfaces”
- commercial-writing implication: strong agent files are not just safe and explicit; they are operationally concrete, command-first, boundary-heavy, and grounded in real verification routines
- file-placement implication: nested or scoped instruction files are useful in larger repos, but the benchmark should treat their semantics as tool-specific rather than assuming one universal hierarchy model
- repo-structure implication: generic “add more context files” advice must be translated into this repo’s branch-owned docs system, not copied literally
- status-tracking implication: this repo already has strong canonical homes for roadmap, active implementation status, and chronological delivery traceability; the benchmark should tell agents to reuse those surfaces rather than create parallel status files
- decision-tracking implication: the canonical decision-record branch now exists, but the repo still needs an explicit elevation rule for when decisions move from owner notes into ADRs
- authoring implication: command-first root files, targeted verification commands, and example anchors are worth adopting as local benchmark heuristics, but the numeric “150 lines” target should remain advisory rather than mandatory
- vault implication: AI-governance improvements must preserve Obsidian-friendly doc stability and link discipline rather than optimizing only for agent ingestion

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the benchmark distinguishes `AGENTS.md` persistence/layering from `SKILL.md` progressive disclosure and execution packaging
- the benchmark distinguishes tool-native instruction ecosystems instead of treating `AGENTS.md` as a universal loading model
- the benchmark includes a source-weighting model for official, secondary, and discovery-only guidance
- the benchmark reflects that this repo’s canonical docs model and Obsidian-style vault usage are part of the instruction-system design space
- the benchmark explicitly maps generic roadmap/status/versioning advice to the repo’s existing planning and worklog system instead of encouraging duplicate files
- the benchmark states how decision records are canonically stored in this repo and when ADR elevation is expected
- the benchmark includes commercial authoring heuristics for command ordering, compact root-file scope, targeted verification commands, and example anchors without overstating them as universal tool rules
- commercial-grade authoring expectations are documented explicitly rather than inferred from scattered examples
- the attached note's unsupported or over-broad claims are either corrected or excluded from repo-owned benchmark language

## Resolution Notes
- Primary Codex docs reviewed directly for this pass:
  - `developers.openai.com/codex/guides/agents-md`
  - `developers.openai.com/codex/skills`
  - `developers.openai.com/codex/app/worktrees`
- Additional platform docs reviewed directly for this addendum:
  - `docs.github.com/en/copilot/.../add-repository-instructions`
  - `code.visualstudio.com/docs/copilot/customization/custom-instructions`
  - `code.claude.com/docs/en/claude-directory`
- Secondary commercial guidance reviewed directly for this pass:
  - GitHub Blog `agents.md` article
  - Microsoft Aspire `AGENTS.md`
  - GitBook `skill.md` article
  - Paradime harness guide
- Additional secondary heuristic source reviewed directly for this addendum:
  - 0xfauzi `agents-md-best-practices.md` gist
- Additional community discussion reviewed for this addendum:
  - Reddit thread `r/vibecoding/comments/1sgcwns/...`
- Implementation pass updated `docs/11-ai/agent-skill-writing-benchmark.md` to:
  - broaden the benchmark from skill-only guidance into a wider instruction-system benchmark
  - distinguish `AGENTS.md`, nested `AGENTS.md`, `SKILL.md`, canonical docs, and support-note roles
  - add a source hierarchy for official, repo-owned, secondary, and discovery-only guidance
  - map generic AI-documentation advice onto the repo's existing planning, worklog, and decision branches
  - add ADR elevation expectations and implementation-traceability expectations
  - record command-first, compact-root-file, and targeted-verification practices as heuristics rather than hard standards
- Re-review confirmed the benchmark now aligns with the updated roadmap and no longer depends on the earlier skill-only framing.
- Re-review confirmed the benchmark now includes:
  - explicit `AGENTS.md` versus `SKILL.md` surface separation
  - a formal source hierarchy
  - canonical mapping to the repo's planning, worklog, and decision branches
  - ADR elevation expectations
  - commercial authoring heuristics recorded as heuristics rather than hard standards
- The attached note is valuable as a prompt for audit topics, but not as a trustworthy source bundle without source ranking and cleanup.
