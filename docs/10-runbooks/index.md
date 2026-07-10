<!--
DOC-META
title: Runbook Index
doc_type: index
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/index.md
parent: docs/00-start-here.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes current operator-executable local development, repository synchronization, deployment, service, scheduler, realtime, and logging procedures.
-->

# Runbook Index

Parent: [Start Here](../00-start-here.md)

## 1. Purpose

This branch owns current repeatable operational procedures.

Use:

- [Runbook Documentation Standards](../02-standards/documentation/Runbook%20Documentation%20Standards.md)

## 2. Development Operations

- [Local Development](local-dev.md)
- [Local Browser Review](local-browser-review.md)
- [Parallel Worktree Setup](parallel-worktree-setup.md)
- [Multi-Device Repository Sync](multi-device-repository-sync.md)

## 3. Deployment Operations

- [Deployment Hub](deployment.md)
- [Server Readiness](server-readiness.md)
- [Server Bootstrap](server-bootstrap.md)
- [Staging Deployment](staging-deployment.md)

Production deployment and rollback runbooks are not yet published. Do not treat the staging procedure as production authorization.

## 4. Service Operations

- [Scheduler Operations](scheduler-operations.md)
- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)
- [Logging Operations](logging-operations.md)

## 5. Removed Workflow Families

The deprecated batch workflow and batch commit workflow are not active runbooks.

Their durable generic rules were promoted to:

- [Git Change Scope And Commit Standards](../02-standards/coding/Git%20Change%20Scope%20And%20Commit%20Standards.md)
- [Agent Session Concurrency And Worktree Standards](../02-standards/coding-agents/Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md)
- [Agent Context And Retrieval Standards](../02-standards/coding-agents/Agent%20Context%20And%20Retrieval%20Standards.md)
- [Repo-Local Agent Memory Standards](../02-standards/coding-agents/Repo-Local%20Agent%20Memory%20Standards.md)

Do not recreate `/docs/08-active/`, change-queue, batch-start, work-batch, or batch-finalize ownership.

## 6. Planned Operational Gaps

The following require future planning and implementation before publication as active runbooks:

- backup execution
- database restore
- restore drills
- production deployment
- production rollback
- incident response
- compromised credential response
- queue failure recovery
- cache failure recovery
- disaster recovery

Track these through planning and GitHub issues rather than placeholder runbooks.

## 7. Related

- [Start Here](../00-start-here.md)
- [Documentation Standards Index](../02-standards/documentation/index.md)
- [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)
