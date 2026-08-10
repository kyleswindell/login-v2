<!--
DOC-META
title: Coding Standards Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Indexes coding, file-building, PHP, application-layer, reliability, test implementation, query, identifier, generator, Git, and agent implementation standards.
-->

# Coding Standards Index

Parent: [Standards Index](../index.md)

## Active Standards

| Document                                                                                                                          | Purpose                                                                                                                                                                   |
| --------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Coding Standards](Coding%20Standards.md)                                                                                         | Baseline application coding, ownership, delivery-boundary, validation, authorization, safety, and verification-routing rules.                                             |
| [Commenting Standards](Commenting%20Standards.md)                                                                                 | Source comment and header rules.                                                                                                                                          |
| [Feature Development Standards](Feature%20Development%20Standards.md)                                                             | Cross-cutting development rules for capabilities, Modules, presentation, Settings, Access, observability, verification, and closeout.                                     |
| [File Building Standards](File%20Building%20Standards.md)                                                                         | File construction and placement rules.                                                                                                                                    |
| [File Archetypes](File%20Archetypes.md)                                                                                           | Approved source-file responsibilities and shapes.                                                                                                                         |
| [Repository Naming Standards](repository-naming-standards.md)                                                                     | Repository-wide naming rules for ownership, folders, namespaces, types, delivery artifacts, identifiers, tests, documentation, compatibility, and registration artifacts. |
| [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)                                                     | PHP and Laravel style rules.                                                                                                                                              |
| [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md) | Application-layer responsibility rules.                                                                                                                                   |
| [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)                                       | Error translation, exception, and failure rules.                                                                                                                          |
| [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)                 | Mutation, locking, retry, and idempotency rules.                                                                                                                          |
| [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)                                                     | Event, Listener, Job, and queue rules.                                                                                                                                    |
| [Identifier And Key Standards](Identifier%20And%20Key%20Standards.md)                                                             | Canonical owner, capability, Module, Registry, permission, route, Notification, Audit, configuration, Job, Event, Listener, queue, UI, and compatibility-key rules.       |
| [Query And Performance Standards](Query%20And%20Performance%20Standards.md)                                                       | Query scope, performance, and bounded-data rules.                                                                                                                         |
| [Test Implementation Standards Index](test-implementation/index.md)                                                               | Repository-specific test-source placement, Laravel and database test code, fixtures and doubles, Playwright source, discovery, and lifecycle rules.                       |
| [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md)                                         | Stub, source-template, and generator rules.                                                                                                                               |
| [Git Change Scope And Commit Standards](Git%20Change%20Scope%20And%20Commit%20Standards.md)                                       | Working-tree, staging, commit, verification, and push rules.                                                                                                              |
| [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)                                                           | Repository-facing implementation readiness, source routing, bounded execution, verification handoff, and review checklist.                                                |

## Superseded Compatibility Routes

- [Testing Standards](Testing%20Standards.md) is a compatibility route only. Testing and verification policy belongs in the [Testing Standards suite](../testing/index.md).
- [Test Implementation Standards](Test%20Implementation%20Standards.md) is a compatibility route only. Test-source coding rules belong in the [Test Implementation Standards family](test-implementation/index.md).

## Related

- [Standards Index](../index.md)
- [Testing Standards Index](../testing/index.md)
- [Coding Agent Standards Index](../coding-agents/index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Stub Templates](../../../stubs/README.md)
