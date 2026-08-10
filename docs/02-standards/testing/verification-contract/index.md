<!--
DOC-META
title: Verification Contract Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/verification-contract/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes standards for verification contracts, proof state and result semantics, initial proof, protected baselines, and verification-contract revision.
-->

# Verification Contract Standards Index

Parent: [Testing Standards Index](../index.md)

Use this index for the declaration and protection rules that make verification proof authoritative.

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

Provide one focused standards family for:

- `AC-*` acceptance-criterion declarations;
- `PF-*` proof declarations;
- criterion-to-proof mapping;
- applicability;
- execution status;
- verification results;
- initial proof;
- production-implementation boundaries;
- protected verification baselines;
- permitted proof edits;
- verification-contract revision.

Execution evidence, artifact storage, reporting, and workflow-stage testing gates belong to the [Reporting And Testing Gates Standards Index](../reporting-and-gates/index.md).

## 2. Scope

### Belongs here

This family owns the meaning and lifecycle of a verification contract.

It answers:

- what must be declared before proof execution;
- how proof state is represented;
- which verification results are valid;
- when initial proof is required;
- what is protected after an accepted baseline;
- when a contract revision is required.

### Does not belong here

This family does not own:

- application requirements;
- security controls;
- schema behavior;
- UI public APIs;
- test-source coding;
- environment-specific implementation mechanics;
- evidence storage;
- pull-request or release authorization.

## 3. Standards

| Standard                                                                              | Owns                                                                                                                                                |
| ------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Verification Contract Standards](verification-contract-standards.md)                 | `AC-*`, `PF-*`, required fields, proof modes, mapping, and declaration completeness                                                                 |
| [Verification State And Result Standards](verification-state-and-result-standards.md) | Applicability, execution status, `PASS`, `EXPECTED_NONPASS`, `FAIL`, and state interpretation                                                       |
| [Initial Proof And Baseline Standards](initial-proof-and-baseline-standards.md)       | Preimplementation applicability, initial proof, production boundary, baseline identity, protected semantics, permitted edits, and contract revision |

## 4. Reading Order

For ordinary executable implementation work:

1. read [Verification Contract Standards](verification-contract-standards.md);
2. read [Verification State And Result Standards](verification-state-and-result-standards.md);
3. read [Initial Proof And Baseline Standards](initial-proof-and-baseline-standards.md) when preimplementation proof or protected evidence applies;
4. read only the specialist testing standards required by the proof;
5. use the [Reporting And Testing Gates Standards Index](../reporting-and-gates/index.md) for evidence and stage completeness.

Do not load every testing standard for a narrow proof.

## 5. Authority Boundaries

The canonical requirement owner defines what must be true.

This family defines how the requirement is converted into reviewable proof.

The work packet supplies issue-specific values such as:

- exact `AC-*` text;
- proof commands or procedures;
- environments;
- actors and fixtures;
- stage applicability;
- expected results;
- protected paths;
- review authorities.

Testing standards do not independently invent missing behavior or acceptance criteria.

## 6. Maintenance

When this family changes:

- preserve one owner for each proof-state concept;
- do not redefine state/result semantics in testing-gate or environment standards;
- keep execution-evidence schema and retention rules in `../reporting-and-gates/`;
- update this index and the parent Testing Standards Index;
- preserve compatibility routes for heavily linked superseded paths where practical.

## 7. Related

- [Testing Standards Index](../index.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Reporting And Testing Gates Standards Index](../reporting-and-gates/index.md)
- [Test Implementation Standards Index](../../coding/test-implementation/index.md)
