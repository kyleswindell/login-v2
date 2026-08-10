<!--
DOC-META
title: Acceptance And Exploratory Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/integration-and-system/acceptance-and-exploratory-testing-standards.md
parent: docs/02-standards/testing/integration-and-system/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines acceptance proof, acceptance-authority separation, manual and business acceptance, exploratory charters, findings, and scope control.
-->

# Acceptance And Exploratory Testing Standards

Parent: [Integration And System Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Acceptance Proof Versus Acceptance Authority](#2-acceptance-proof-versus-acceptance-authority)
- [3. Acceptance Proof Declaration](#3-acceptance-proof-declaration)
- [4. Manual, Specialist, And Business Acceptance](#4-manual-specialist-and-business-acceptance)
- [5. Exploratory Testing](#5-exploratory-testing)
- [6. Findings And Scope Control](#6-findings-and-scope-control)
- [7. Evidence And Reporting](#7-evidence-and-reporting)
- [8. Prohibited Patterns](#8-prohibited-patterns)
- [9. Related](#9-related)

## 1. Purpose And Authority

Define how delivered behavior is demonstrated against accepted requirements when acceptance depends on assembled behavior, human judgment, specialist review, or structured exploration.

This standard defines proof methods; it does not grant acceptance authority or redefine requirements after implementation.

## 2. Acceptance Proof Versus Acceptance Authority

```text
Acceptance proof
    demonstrates one or more AC-* criteria

Acceptance authority
    is the person, role, or accepted workflow owner permitted to accept the evidence
```

Acceptance proof may be automated, browser-based, manual, repository-owner review, user/business acceptance, security review, database review, accessibility review, or operational review. Every mandatory acceptance proof receives a `PF-*` ID.

The implementing agent/session cannot grant itself repository-owner, design, security, accessibility, operational, or other specialist acceptance unless explicitly delegated. Testing completeness does not itself authorize merge, release, deployment, closure, or milestone acceptance.

## 3. Acceptance Proof Declaration

Declare applicable mapped criteria, requirement source/owner, acceptance authority, target environment/surface, actor/system identity, exact command/review procedure, observable acceptance/rejection conditions, evidence, limitations, and stage applicability.

The proof must be independently reviewable. Statements such as `looks good`, `stakeholder approved`, or `UAT passed` are insufficient when explicit conditions/specialist evidence are required.

## 4. Manual, Specialist, And Business Acceptance

Use manual/specialist acceptance where automation cannot fully determine the condition, including visual hierarchy/interaction quality, screen-reader interpretation, complex authorization, destructive data/recovery assessment, production posture, user/business workflow, legal/privacy interpretation, or operational readiness.

A review procedure declares exact surface, environment, actor/state, actions, expected observations, evidence, and reviewer authority.

Reviewer unavailability before review starts is `BLOCKED`; completed review that does not meet conditions is `FAIL`, per [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).

## 5. Exploratory Testing

Exploratory testing is a structured experience-based technique, not an unbounded request to `try things`.

A material exploratory `PF-*` declares charter, target boundary, purpose/question, environment, actor/start state, areas to explore, exclusions, optional time box, evidence, executor/reviewer, and expected decision/review question.

Record material paths explored, state combinations, observations, findings, screenshots/traces when useful, limitations, and result/follow-up classification.

Exploration may target unusual workflow sequences, state combinations, usability, browser differences, integration timing, degraded dependencies, recovery, or accessibility behavior not fully machine-verifiable.

## 6. Findings And Scope Control

A finding may demonstrate failure of an existing criterion, identify a possible new requirement, reveal a proof/environment defect, or identify future work.

It does not automatically expand current scope, redefine behavior, authorize unrelated remediation, become canonical target state, or waive failed mandatory proof. New requirements require the appropriate owner/issue decision before becoming criteria.

## 7. Evidence And Reporting

Acceptance evidence traces `AC-* → PF-* → execution/review → artifact/observation → named authority`.

Use [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md). Record reviewer identity/authority, environment, actual observations, conditions, unresolved findings, and limitations.

## 8. Prohibited Patterns

Do not use acceptance to define requirements after implementation, let stakeholder statements override failed proof, let implementing agents approve required specialist/owner review, mark unexecuted review `PASS`, turn exploratory findings directly into implementation, run broad exploration uncontrolled in production, treat reviewer unavailability as `FAIL` before review starts, or infer merge/release/deployment/closure authority from testing acceptance.

## 9. Related

- [Integration And System Testing Standards Index](index.md)
- [Verification Contract Standards Index](../verification-contract/index.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md)
- [UI And Accessibility Testing Standards Index](../ui-and-accessibility/index.md)
- [Security Standards Index](../../security/index.md)
- [Runbook Index](../../../10-runbooks/index.md)
