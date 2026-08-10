<!--
DOC-META
title: Reporting And Testing Gates Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/reporting-and-gates/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes standards for verification execution evidence, result artifacts, reporting, retention, and testing-evidence gates across delivery stages.
-->

# Reporting And Testing Gates Standards Index

Parent: [Testing Standards Index](../index.md)

Use this index for verification execution evidence and testing-stage completeness.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [Belongs here](#belongs-here)
  - [Does not belong here](#does-not-belong-here)
- [3. Standards](#3-standards)
- [4. Reading Order](#4-reading-order)
- [5. Authority Boundaries](#5-authority-boundaries)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

Provide one standards family for:

- execution evidence;
- structured verification artifacts;
- manual and specialist evidence records;
- result summaries;
- artifact storage and retention;
- failure reporting;
- testing-evidence gates;
- testing completeness by workflow stage.

Proof declarations, state semantics, initial proof, and protected-baseline rules remain with the [Verification Contract Standards Index](../verification-contract/index.md).

## 2. Scope

### Belongs here

This family answers:

- what evidence must be retained after execution;
- how material proof is summarized and reproduced;
- when testing evidence is complete for preimplementation, development, PR, merge, release, deployment, post-deployment, or completion stages.

### Does not belong here

This family does not own:

- feature behavior;
- public Contracts;
- proof-state vocabulary;
- initial-proof semantics;
- repository implementation authorization;
- PR merge authorization;
- release or deployment authorization;
- issue, milestone, or Project state.

## 3. Standards

| Standard                                                                                          | Owns                                                                                                                                             |
| ------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| [Verification Reporting And Artifact Standards](verification-reporting-and-artifact-standards.md) | Execution records, structured reports, evidence manifests, hashes, artifact storage, retention, manual/specialist records, and concise summaries |
| [Testing Gate Standards](testing-gate-standards.md)                                               | Stage-specific testing-evidence completeness from preimplementation through post-deployment and final testing acceptance                         |

## 4. Reading Order

For a material proof:

1. declare proof through `../verification-contract/`;
2. execute the applicable specialist proof;
3. record material execution using [Verification Reporting And Artifact Standards](verification-reporting-and-artifact-standards.md);
4. evaluate the applicable workflow-stage testing evidence using [Testing Gate Standards](testing-gate-standards.md).

Do not use testing-gate rules to redefine proof state or result semantics.

## 5. Authority Boundaries

Testing gates evaluate testing evidence only.

They do not independently authorize:

- production implementation;
- pull-request readiness;
- merge;
- release;
- deployment;
- issue closure;
- milestone closure;
- repository-owner acceptance.

Those decisions remain with repository workflow, accepted work packets, runbooks, GitHub state, and human authority.

## 6. Maintenance

When this family changes:

- keep proof-state meaning in `../verification-contract/`;
- keep environment validity in the environment standards;
- keep quality-specific proof rules with their specialist standards;
- keep test-source coding under `../../coding/test-implementation/`;
- update this index and the parent Testing Standards Index;
- avoid introducing shared append-only evidence logs.

## 7. Related

- [Testing Standards Index](../index.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Agent Implementation Checklist](../../coding/Agent%20Implementation%20Checklist.md)
