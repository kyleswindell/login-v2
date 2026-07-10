# AGENTS.md

## Folder Purpose

This folder owns repeatable operator-executable procedures.

It does not own standards, architecture, feature behavior, schema, planning, delivery status, agent governance, or historical environment logs.

## Required Reading

1. Read `index.md`.
2. Open only the runbook for the named operation.
3. Read [Runbook Documentation Standards](../02-standards/documentation/Runbook%20Documentation%20Standards.md).
4. Read governing security, database, deployment, or coding standards when linked by the runbook.

## Execution Rules

Before executing a runbook:

- identify the target environment
- identify the authorized operator
- confirm prerequisites
- confirm backup or rollback requirements
- confirm required approvals
- confirm evidence requirements
- stop when commands, paths, ownership, or recovery are unclear

Do not infer authorization for:

- deployment
- migration
- service restart
- permission change
- destructive command
- secret rotation
- data restoration
- production access

## Avoid

- Do not read every runbook.
- Do not preserve deprecated batch workflow procedures.
- Do not place agent rules or skills here.
- Do not record historical command transcripts in current runbooks.
- Do not use operator-specific absolute paths when variables or configured aliases suffice.
- Do not place secrets or customer data in runbooks.

## Verification

Runbooks must define:

- objective success checks
- failure handling
- rollback or explicit no-rollback limits
- escalation
- completion criteria

## Related

- [Runbook Index](index.md)
- [Runbook Documentation Standards](../02-standards/documentation/Runbook%20Documentation%20Standards.md)
- [Documentation Standards Index](../02-standards/documentation/index.md)
