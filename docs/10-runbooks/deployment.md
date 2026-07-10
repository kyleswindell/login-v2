<!--
DOC-META
title: Deployment
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/deployment.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Routes operators to the current server-readiness, bootstrap, and staging-deployment procedures and states current deployment limitations.
-->

# Deployment

Parent: [Runbook Index](index.md)

## Purpose

Route operators to the correct deployment procedure.

## Use When

Use this hub when preparing or performing Login 2.0 environment deployment work.

## Current Supported Procedures

- [Server Readiness](server-readiness.md)
- [Server Bootstrap](server-bootstrap.md)
- [Staging Deployment](staging-deployment.md)

## Current Limitations

- The published deploy procedure is for staging.
- Production deployment is not authorized by this hub.
- A complete production rollback procedure is not yet published.
- Database rollback is not assumed to be safe after forward migrations.
- Backup and restore runbooks must exist before production tenant data is treated as recoverable.

## Selection

Use:

| Situation | Procedure |
| --- | --- |
| Validate a server before application deployment | [Server Readiness](server-readiness.md) |
| Prepare the application release layout on a provisioned server | [Server Bootstrap](server-bootstrap.md) |
| Deploy or restore a branch on shared staging | [Staging Deployment](staging-deployment.md) |

## Stop Conditions

Stop when:

- the target environment is production
- the operator is not authorized
- rollback is required but undefined
- database recovery is required
- required credentials or server access are unavailable
- staging is owned by another branch
- the target branch is not reviewable

## Related

- [Runbook Index](index.md)
- [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)
