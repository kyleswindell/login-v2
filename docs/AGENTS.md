# docs AGENTS.md

## Purpose

`docs/` is the canonical documentation root.

Use it to locate durable decisions, standards, architecture, feature behavior, flows, database contracts, planning, references, runbooks, and bounded AI-governance artifacts without treating documentation as active delivery state.

GitHub Issues own bounded work packets. GitHub Projects own current delivery status, sequencing, dependencies, and priority.

## Read Order

1. Read the relevant branch `AGENTS.md` before opening branch files.
2. Read the branch index before opening long canonical documents.
3. Open only the specific canonical file and section required by the task.
4. Use `00-start-here.md` only when orienting to the documentation system as a whole.
5. When current implementation or delivery state matters, verify the applicable GitHub issue, Project state, or current repository source rather than inferring it from planning history.

## Branch Responsibilities

- `01-decisions/` — accepted and proposed durable decision records.
- `02-standards/` — durable enforceable standards.
- `03-architecture/` — accepted system structure and architecture boundaries.
- `04-features/` — user-visible and system-visible feature behavior.
- `05-flows/` — ordered execution and cross-system flows.
- `06-database/` — schema, table, relationship, and data Contracts.
- `07-planning/` — accepted planning intent, migration direction, decomposition, and sequencing rationale.
- `08-design/` — accepted pre-implementation software design and concrete implementation realization.
- `09-reference/` — non-canonical reference, research, inventories, and supporting evidence.
- `10-runbooks/` — operator-executable procedures and recovery.
- `11-ai/` — bounded AI review, governance, and working-document artifacts.

Do not move content between these responsibilities merely because another branch is easier to find.

## Avoid

- Do not read `docs/_archive/` unless the task explicitly requires archive research.
- Do not read `docs/11-ai/_archive/` unless the task specifically concerns archived AI-governance or historical workflow material.
- Do not read `docs/_notes/` unless the user explicitly requests non-canonical notes or the task names a note there.
- Do not restore deprecated phase/batch delivery-state ownership.
- Do not use historical phase, batch, queue, or worklog files as current implementation status.
- Do not traverse Obsidian backlinks as automatic context.
- Do not read every branch index for a narrow task.
- Do not treat planning as a substitute for accepted architecture, standards, feature behavior, schema Contracts, or current GitHub delivery state.

## Documentation Changes

Before editing documentation:

- identify the canonical branch and document type;
- read the applicable branch `AGENTS.md`;
- read the branch index;
- read the applicable documentation standards;
- identify whether the change is canonical truth, planning intent, reference evidence, a runbook procedure, or AI working material;
- preserve existing authority boundaries.

When durable truth changes, update the canonical owner rather than copying the new rule into several branches.

When implementation status changes, follow the [Implementation Status And Development Sync Standard](02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md) and preserve GitHub issue/Project ownership of delivery state.

## Long Context Guidance

When a task points to a long document:

1. inspect its headings or search within the file;
2. read the section that owns the current question;
3. expand only when the local section depends on another owner.

Do not load an entire planning family, standards family, or review history when a focused owner answers the task.

## AI Review Material

`docs/11-ai/` is not canonical product or technical truth.

Use current review artifacts only when the task requires their findings or review state. After a finding is promoted, consume the corrected canonical owner rather than continuing to rely on the historical review artifact.

## Stop Conditions

Stop and report when:

- two canonical documents compete for the same responsibility;
- document type or branch ownership is unclear;
- planning contradicts an accepted canonical owner;
- current delivery state cannot be verified;
- a requested update would recreate a deprecated delivery workflow;
- an AI review artifact would become a second canonical owner;
- sensitive evidence would be recorded in documentation;
- another writer owns the same documentation scope.

## Related

- [Start Here](00-start-here.md)
- [Standards Index](02-standards/index.md)
- [Architecture Index](03-architecture/index.md)
- [Software Design Index](08-design/index.md)
- [Features Index](04-features/index.md)
- [Flows Index](05-flows/index.md)
- [Database Index](06-database/index.md)
- [Planning Index](07-planning/index.md)
- [Reference Index](09-reference/index.md)
- [Runbook Index](10-runbooks/index.md)
