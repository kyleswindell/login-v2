---
name: login2-file-implementation
description: Create or materially reshape a bounded Login 2.0 source or test/proof file set after ownership, target paths, behavior, and verification stage are already defined. Use approved archetypes, generators, or stubs and validate the resulting files. Do not use to choose architecture, product behavior, schema, permissions, transactions, public UI design, or verification requirements.
---

# Login 2.0 File Implementation

Lifecycle: active.

## Purpose

Perform mechanical construction of an approved file or small file bundle.

This skill owns archetype selection, generator/stub selection, exact file mapping, overwrite safety, placeholder completion, output validation, and file-level reporting.

It does not decide behavior, ownership, target architecture, schema, Security policy, UI design, or proof requirements.

## Use And Non-Use

Use for approved:

- PHP/Laravel source;
- migrations, factories, seeders;
- test/proof source or fixtures;
- Blade, CSS, JavaScript;
- reusable UI source bundles;
- generator/stub changes;
- material reshape to an accepted archetype.

Do not use to invent an owner/destination, architecture, schema, permissions, transactions, retries/idempotency, public UI design, speculative abstractions, framework overrides, or unrelated cleanup.

## Required Inputs

Obtain:

- issue/task identifier;
- verification stage: proof-source preparation, production implementation, or support/tooling;
- repository/application owner when applicable;
- exact destination paths and file archetypes;
- accepted behavior/public Contract and naming requirements;
- applicable canonical standards;
- generator/stub when applicable;
- overwrite/move/delete authorization;
- compatibility requirements;
- required validation;
- protection status of existing tests, fixtures, Contracts, or evidence.

For a bundle, obtain the complete file map before writing.

## Canonical Routing

Always read:

1. root `AGENTS.md`;
2. nearest scoped `AGENTS.md`;
3. `docs/02-standards/coding/File Archetypes.md`;
4. `docs/02-standards/coding/File Building Standards.md`.

Read only when applicable:

- Repository Architecture and Repository Naming Standards;
- Code Template And Generator Standards plus `stubs/AGENTS.md`/`stubs/README.md`;
- PHP And Laravel Style Standards;
- Commenting Standards and scoped header/comment rules;
- Test Implementation Standards and Testing Standards;
- applicable Database, Security, UI, logging, queue, transaction, documentation, or runbook standards.

Do not load every specialist standard for every file.

## Verification-Stage Gate

### Proof-Source Preparation

When creating proof source/fixtures before initial proof:

- write only accepted proof/fixture/support files;
- do not modify production implementation;
- follow Test Implementation standards;
- preserve the declared expected initial result.

### Production Implementation

Before production file writes:

- confirm verification readiness passed;
- confirm required initial proof reached its declared accepted state;
- confirm protected proof is identified;
- do not modify protected proof unless explicitly permitted.

### Tooling Or Template Maintenance

When changing stubs/generators/tooling:

- confirm the task owns that tooling;
- validate generated output, not only template source;
- do not encode unresolved architecture/behavior into templates.

Stop when the stage is unclear.

## Side-Effect Boundary

Within accepted scope this skill may create, modify, move, or delete only the declared file set.

It does not authorize unrelated edits, staging/committing, pushing/merging, dependency changes, shared-environment migrations, deployment/external mutation, or issue/Project updates unless explicitly granted.

Overwrite and deletion require explicit scope.

## Procedure

### 1. Confirm Owner And Destination

For each output record owner, responsibility, destination, archetype, public Contract, and verification role.

Use Repository Architecture and scoped `AGENTS.md`.

Do not use transitional/generic owners, root `tests/`, or root database paths as defaults when an accepted owner-local target exists.

Stop when ownership and destination disagree.

### 2. Confirm Archetype

Select the file archetype from `File Archetypes.md`.

Do not choose an archetype because a stub exists. Stop when one file has competing primary responsibilities.

### 3. Select Construction Method

Use the accepted method:

1. approved project generator;
2. framework generator with explicitly active override;
3. approved repository stub/template;
4. direct creation when no approved template applies.

Read generator/template standards only when using them. Do not create a new template system incidentally.

### 4. Build Exact File Map

Before writing, list each destination with owner, archetype, symbol/component identity, generator/stub or `direct`, overwrite/move/delete status, related proof owner, and canonical Contract.

For UI bundles, include only files required by the accepted public Contract. Do not create optional JavaScript for static behavior.

### 5. Inspect Destination Safety

Inspect existing destinations, parent instructions, current writable ownership, shared files, overwrite/move/delete authority, and compatibility-sensitive paths/namespaces/selectors/registrations/serialized identities.

Do not overwrite an existing file merely because generated output is newer.

### 6. Preview Output

Use dry-run/preview when available. For manual creation, prepare the complete output before saving.

Reject output with wrong owner/path/namespace, unresolved/unsupported placeholders, speculative files, permissive authorization, invented schema/behavior, conflicting UI Contracts, secrets, or workstation-specific paths.

### 7. Create Or Reshape Approved Files

Write only the accepted set.

Complete generated source by replacing placeholders, removing non-applicable scaffold/unused imports, applying required types/dependencies/headers/comments, implementing only accepted behavior, preserving Contracts/compatibility, and removing template/debug material.

Generator success alone does not complete the file.

### 8. Validate Consistency

For bundles, verify names, paths, namespaces, selectors, data attributes, props, variants, initializer names, tests, and documentation references agree.

For generated source, validate output against the selected archetype.

### 9. Scan Scaffold Residue

Run unresolved-placeholder and applicable scaffold-marker scans on affected paths.

A required unresolved placeholder/incomplete scaffold is a construction failure.

Do not remove an accepted failing assertion because it is preimplementation proof.

### 10. Run Declared Validation

Run only validation required by the work packet and applicable standards: syntax, formatting, focused tests, generator self-tests, frontend build, browser proof, PostgreSQL proof, or docs guardrails as applicable.

Use exact declared commands. Do not claim validation passed unless it ran successfully.

### 11. Inspect Diff

Inspect:

```text
git status --short
git diff --check
git diff -- <affected-paths>
```

Confirm only approved files changed; owner/path/archetype align; protected proof is intact; no placeholders/debug/secrets/workstation paths remain; moves/deletions are intentional; compatibility-sensitive changes are accounted for.

### 12. Report And Return Control

Report issue/task, verification stage, owner, archetypes, generation method, file map, stubs/generators, scaffold scan, validation/results, checks not run, compatibility concerns, required review, blockers/gaps.

When invoked from `login2-implementation-slice`, return to that workflow for initial proof, production implementation, final proof, documentation sync, broader verification, and review handoff.

## Stop Conditions

Stop when verification stage, owner, destination, archetype, accepted behavior/Contract, overwrite authority, required placeholders, schema/authorization/transaction/retry/compatibility/UI behavior, protected-proof authority, writable ownership, or validation capability is unresolved.

Also stop when the file set requires speculative or unrelated work.

Report the affected file, exact conflict, canonical owner, and minimum input or authority needed.
