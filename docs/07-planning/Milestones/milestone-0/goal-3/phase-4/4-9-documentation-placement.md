Decision 4.8 is accepted.

# Decision 4.9 — Documentation Placement

## Recommendation

Documentation should follow the repository’s existing canonical documentation taxonomy rather than being placed beside code by default.

Default ownership:

```text
docs/01-decisions/     ADRs and accepted cross-cutting decisions
docs/02-standards/     mandatory implementation and review standards
docs/03-architecture/  durable system structure and ownership
docs/04-features/      capability and Surface behavior
docs/05-flows/         cross-capability workflows
docs/06-database/      schema and persistence contracts
docs/07-planning/      target analysis, sequencing, and unresolved decisions
docs/09-reference/     supporting reference material
docs/10-runbooks/      human operational procedures
```

Module-specific package documentation remains local:

```text
Modules/<Module>/README.md
Modules/<Module>/docs/
```

Owner-local source documentation may remain beside implementation only when it is part of the executable or machine-readable contract, such as:

```text
contract.php
reference.php
README.md
```

These files do not replace canonical Markdown architecture, standards, feature, database, or runbook documentation.

The registration compiler should not automatically discover or publish arbitrary Markdown files. Documentation routing should be explicit through indexes and metadata, with validation for:

* missing parent or index links;
* invalid `canonical_path`;
* duplicate canonical ownership;
* stale links;
* planning content incorrectly presented as durable authority;
* package documentation missing from a Module’s README or docs index.

Decision 4.9 should include a **default folder documentation package** without requiring empty or redundant files in every leaf directory.

# Decision 4.9 — Documentation Placement, amended

## Recommendation

Most meaningful repository folders should contain:

```text
README.md
index.md
AGENTS.md
```

Their responsibilities are distinct:

* `README.md` explains the folder’s purpose, scope, ownership, intended contents, and basic use.
* `index.md` provides canonical navigation, inventories important child documents or artifacts, and routes readers to the correct owner.
* `AGENTS.md` provides scoped execution guidance, required reading, writable boundaries, validation requirements, and prohibited actions.

This default applies especially to:

* permanent repository-root branches;
* major `app/` owner and integration branches;
* Core capabilities;
* Module packages and significant package branches;
* major UI categories;
* documentation branches;
* operational, script, stub, and test branches;
* independently understandable subsystems.

It is not a mandatory universal skeleton. One or more files may be omitted when:

* the folder is a deep standardized Technical Role or artifact bundle;
* its contents and behavior are fully governed by an ancestor;
* the file would merely duplicate inherited guidance;
* the folder contains generated or runtime output;
* the folder is intentionally navigation-free;
* an `AGENTS.md` would add no scoped execution rule;
* repository policy deliberately excludes an agent-instruction surface there.

A missing file at a significant owner boundary should be intentional and reviewable, not accidental.
