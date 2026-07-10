<!--
DOC-META
title: Runbook Documentation Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Runbook Documentation Standards.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines qualification, structure, safety, verification, recovery, evidence, review, and lifecycle requirements for operator-executable runbooks.
-->

# Runbook Documentation Standards

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Definition](#2-definition)
- [3. What A Runbook Is Not](#3-what-a-runbook-is-not)
- [4. Qualification Gate](#4-qualification-gate)
- [5. Runbook Categories](#5-runbook-categories)
- [6. Required Metadata](#6-required-metadata)
- [7. Required Runbook Content](#7-required-runbook-content)
  - [7.1. Purpose](#71-purpose)
  - [7.2. Use When](#72-use-when)
  - [7.3. Do Not Use When](#73-do-not-use-when)
  - [7.4. Roles And Ownership](#74-roles-and-ownership)
  - [7.5. Prerequisites](#75-prerequisites)
  - [7.6. Target Identification](#76-target-identification)
  - [7.7. Safety And Data Handling](#77-safety-and-data-handling)
  - [7.8. Procedure](#78-procedure)
  - [7.9. Verification](#79-verification)
  - [7.10. Failure Handling](#710-failure-handling)
  - [7.11. Rollback Or Recovery](#711-rollback-or-recovery)
  - [7.12. Escalation](#712-escalation)
  - [7.13. Evidence And Documentation](#713-evidence-and-documentation)
  - [7.14. Completion Criteria](#714-completion-criteria)
  - [7.15. Related](#715-related)
- [8. Environment Rules](#8-environment-rules)
- [9. Command Safety](#9-command-safety)
- [10. Secrets And Sensitive Data](#10-secrets-and-sensitive-data)
- [11. Current State Versus Historical Evidence](#11-current-state-versus-historical-evidence)
- [12. Hubs And Child Runbooks](#12-hubs-and-child-runbooks)
- [13. Troubleshooting Boundaries](#13-troubleshooting-boundaries)
- [14. Review Requirements](#14-review-requirements)
- [15. Test And Exercise Requirements](#15-test-and-exercise-requirements)
- [16. Lifecycle](#16-lifecycle)
- [17. Maintenance Triggers](#17-maintenance-triggers)
- [18. Runbook Completion Checklist](#18-runbook-completion-checklist)
- [19. Related](#19-related)

## 1. Purpose

Define what qualifies as a runbook and the minimum requirements for writing, reviewing, and maintaining operator-executable procedures under `docs/10-runbooks/`.

## 2. Definition

A runbook is a repeatable procedure for a known operational task or condition.

It answers:

> This operational task must be performed, or this condition is occurring. What must the authorized operator do, how is success verified, and what happens when a step fails?

A runbook must be executable by its intended operator without requiring them to invent missing architecture, policy, recovery behavior, or commands.

## 3. What A Runbook Is Not

A runbook is not primarily:

- a standard
- architecture documentation
- a feature contract
- a normal application flow
- database schema documentation
- future planning
- a historical environment report
- a phase completion log
- a collection of recommendations
- a vague readiness checklist
- a copy of vendor documentation
- an agent skill
- a GitHub issue workflow
- a compatibility pointer to a removed procedure

Use the correct owner instead:

| Content                        | Owner                             |
| ------------------------------ | --------------------------------- |
| Durable rules                  | `docs/02-standards/`              |
| System structure               | `docs/03-architecture/`           |
| Product behavior               | `docs/04-features/`               |
| System execution path          | `docs/05-flows/`                  |
| Schema and data contracts      | `docs/06-database/`               |
| Future intent and sequencing   | `docs/07-planning/`               |
| Templates and support material | `docs/09-reference/`              |
| Agent working documents        | `docs/11-ai/`                     |
| Persistent agent rules         | `AGENTS.md`                       |
| Executable agent workflows     | `.agents/skills/`                 |
| Current task and status        | GitHub issues and GitHub Projects |

## 4. Qualification Gate

A file qualifies as a runbook only when:

- a known operator role can execute it
- the operational trigger is clear
- prerequisites and required access are known
- the target environment or system is clear
- actions are ordered
- success can be verified
- failure handling is defined
- rollback or recovery is defined when applicable
- escalation is defined
- completion criteria are explicit
- the procedure reflects real tools and current practice

Do not create placeholder runbooks that merely say the procedure must later be defined.

When required operational behavior is still unknown, track it in planning and create the runbook after the procedure is established.

## 5. Runbook Categories

Common categories include:

- environment setup
- deployment and rollback
- service operation
- maintenance
- backup and recovery
- incident response
- security response
- data recovery
- access recovery
- evidence preservation
- verification and readiness checks
- controlled troubleshooting

A hub may route to related runbooks, but executable steps must live in focused child procedures.

## 6. Required Metadata

Runbooks must use:

- `doc_type: runbook`
- `owner: ops`, unless a narrower approved owner is more accurate
- `canonical: true`
- `status: active` or `implemented` only when the procedure is usable
- `template: docs/09-reference/templates/docs/_runbook.md`

Use `status: planned` only for a reviewed operational design that is intentionally retained before implementation. A planned runbook must not be presented as executable.

## 7. Required Runbook Content

A materially complete runbook should contain the following information, using headings appropriate to its scope.

### 7.1. Purpose

State the operational outcome.

### 7.2. Use When

Identify the exact trigger, task, alert, request, or condition.

### 7.3. Do Not Use When

Identify adjacent cases that require another procedure, specialist, or escalation.

### 7.4. Roles And Ownership

Identify:

- authorized operator
- service or system owner
- approval owner
- escalation owner

### 7.5. Prerequisites

Identify required:

- access
- tools
- credentials or secret references
- environment state
- maintenance window
- backup or recovery point
- issue or incident identifier
- approvals

Do not place secret values in the runbook.

### 7.6. Target Identification

The operator must verify:

- environment
- host or service
- tenant, workspace, or account scope
- branch, release, or artifact
- database or storage target
- time window

Use variables or declared placeholders for operator-specific paths and identities.

### 7.7. Safety And Data Handling

Identify applicable:

- destructive effects
- security impact
- privacy impact
- sensitive-data handling
- service interruption
- audit requirements
- evidence-preservation requirements
- rollback prerequisite

### 7.8. Procedure

Provide ordered actions.

Each significant step should state:

- command or action
- expected result
- stop condition
- decision branch when applicable

Commands must be complete enough to execute safely.

### 7.9. Verification

Define objective proof of success.

Verification may include:

- command output
- application health checks
- database status
- queue or service state
- log evidence
- rendered behavior
- audit events
- monitoring signals
- backup integrity
- restore validation

### 7.10. Failure Handling

Identify:

- expected failure modes
- safe retry conditions
- steps that must not be repeated
- partial-completion handling
- where failure evidence is stored
- when to stop

### 7.11. Rollback Or Recovery

When the procedure changes state, define:

- recovery point
- rollback trigger
- rollback steps
- rollback verification
- limits of rollback
- escalation when rollback is unsafe or impossible

A state-changing runbook without rollback or an explicit no-rollback explanation is incomplete.

### 7.12. Escalation

Identify:

- escalation trigger
- responsible role
- required context
- evidence to provide
- actions prohibited while waiting

### 7.13. Evidence And Documentation

Identify required:

- issue or incident updates
- audit event
- command output
- logs
- screenshots
- backup identifiers
- release identifier
- timestamps
- approvals
- retained evidence location

Do not use a runbook as the historical evidence record itself.

### 7.14. Completion Criteria

State when the operator may consider the procedure complete.

### 7.15. Related

Link to governing standards, architecture, feature owners, related runbooks, and vendor reference material.

## 8. Environment Rules

Separate local, staging, and production instructions when their access, commands, data, safety requirements, rollback, approval, or evidence differ materially.

Do not present a local command as production-safe without explicit production validation.

Use configured aliases and variables instead of embedding:

- workstation-specific absolute paths
- personal key paths
- individual operator email addresses
- mutable IP addresses
- temporary release directories
- historical commit identifiers

Document environment contracts, not one operator's machine state.

## 9. Command Safety

For every destructive or state-changing command, identify applicable:

- target validation
- required backup
- dry-run or preview
- clean-state requirement
- approval
- expected output
- rollback
- stop condition

Examples include:

- `git reset --hard`
- forced migrations
- database writes or deletes
- cache or storage clearing
- queue pruning
- service restarts
- secret rotation
- permission changes
- backup deletion
- restoration
- disabling access
- destructive incident containment

Do not normalize a dangerous command merely because it previously succeeded.

## 10. Secrets And Sensitive Data

Runbooks must not contain:

- passwords
- tokens
- private keys
- production credentials
- unredacted secrets
- unnecessary personal data
- raw customer records
- private vulnerability evidence

Use:

- environment variable names
- secret-manager references
- configuration keys
- redacted examples
- approved evidence locations

Local-only test credentials may be documented only when they are deterministic, non-production, clearly labeled, and recreated by an approved local command.

## 11. Current State Versus Historical Evidence

A runbook should describe the current executable procedure.

Do not keep accumulating:

- completed setup findings
- old release identifiers
- historical host state
- phase progress
- previous command transcripts
- future automation direction
- unresolved implementation planning

Move historical material to:

- Git history
- issue or PR records
- release notes
- planning
- archived reference material

Update the runbook when the current procedure changes.

## 12. Hubs And Child Runbooks

A runbook hub may:

- define scope
- classify procedures
- route to child runbooks
- identify common prerequisites

A hub must not duplicate all child procedures.

Use child runbooks when:

- triggers differ
- operator roles differ
- environments differ materially
- rollback differs
- one procedure can be executed independently
- the parent becomes too long for reliable operation

## 13. Troubleshooting Boundaries

Troubleshooting content belongs in a runbook when it supports a bounded operational condition and has:

- symptoms
- safe diagnostics
- expected findings
- decision branches
- escalation
- recovery

Do not turn a runbook into an unbounded list of speculative fixes.

## 14. Review Requirements

Review a runbook for:

- valid operational trigger
- named operator and owner
- complete prerequisites
- environment identification
- safe ordered steps
- current commands and paths
- objective verification
- failure handling
- rollback or explicit no-rollback rationale
- escalation
- evidence requirements
- secret and data safety
- absence of historical status
- absence of planning content
- links to governing standards
- accurate lifecycle status

Security-sensitive, recovery, destructive, and production runbooks require specialist review appropriate to their risk.

## 15. Test And Exercise Requirements

A runbook should be exercised when practical.

The review record should distinguish:

- document review only
- command validation
- staging exercise
- restore drill
- tabletop exercise
- production use
- post-incident correction

Do not mark a critical recovery procedure `implemented` solely because it was written.

Backup and recovery runbooks require restore validation.

Incident-response runbooks require tabletop or real-incident validation appropriate to their maturity.

## 16. Lifecycle

Use:

- `draft` while authoring
- `planned` when the operational design is accepted but not executable
- `active` when it is the current approved procedure
- `implemented` when the procedure is established and validated in practice
- `superseded` when replaced
- `archived` when historical only

When superseding:

1. identify the replacement
2. update indexes and inbound links
3. remove the old procedure from active navigation
4. retain a short pointer only when path preservation is useful
5. archive or delete the obsolete file
6. do not maintain both procedures as active

## 17. Maintenance Triggers

Review a runbook when:

- commands change
- service names change
- paths or environment contracts change
- ownership changes
- permissions change
- monitoring or audit evidence changes
- rollback changes
- an incident exposes a missing step
- a drill fails
- a dependency or vendor procedure changes
- implementation removes the operational condition
- the runbook has not been exercised within its required review period

## 18. Runbook Completion Checklist

A runbook is documentation-complete when:

- it passes the qualification gate
- metadata is correct
- the target operator and environment are clear
- prerequisites are real
- commands are current
- safety boundaries are explicit
- verification is objective
- failure handling is actionable
- rollback or recovery is defined
- escalation is defined
- evidence requirements are defined
- completion criteria are clear
- the parent index is updated
- applicable review or exercise evidence exists
- no planning or historical status remains mixed into the procedure

## 19. Related

- [Documentation Standards Index](index.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Runbook Template](../../09-reference/templates/docs/_runbook.md)
- [Runbook Index](../../10-runbooks/index.md)
