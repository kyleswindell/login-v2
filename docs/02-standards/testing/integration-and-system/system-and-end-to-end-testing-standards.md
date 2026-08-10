<!--
DOC-META
title: System And End-To-End Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/integration-and-system/system-and-end-to-end-testing-standards.md
parent: docs/02-standards/testing/integration-and-system/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines assembled system boundaries, system proof, end-to-end workflow selection and construction, and application-level smoke testing.
-->

# System And End-To-End Testing Standards

Parent: [Integration And System Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. System Boundary Declaration](#2-system-boundary-declaration)
- [3. System Proof](#3-system-proof)
- [4. Replaced Services And Limitations](#4-replaced-services-and-limitations)
- [5. End-To-End Workflow Selection](#5-end-to-end-workflow-selection)
- [6. End-To-End Proof Construction](#6-end-to-end-proof-construction)
- [7. Application-Level Smoke Testing](#7-application-level-smoke-testing)
- [8. Evidence And Reporting](#8-evidence-and-reporting)
- [9. Scope Control And Prohibited Patterns](#9-scope-control-and-prohibited-patterns)
- [10. Related](#10-related)

## 1. Purpose And Authority

Define how the assembled application or a major subsystem is verified through public entry points and representative workflows.

System and E2E proof consume accepted feature, flow, Contract, schema, security, UI, and operational requirements; they do not redefine them.

## 2. System Boundary Declaration

Declare system/subsystem name, owning Product/capability/Module/application or verification boundary, included/excluded owners, public entry points, real/replaced services, infrastructure, actor/system identity, data baseline, required environment, expected observable result, cleanup, and limitations.

Do not call proof `system testing` without defining the system boundary.

## 3. System Proof

System proof should enter through a public Delivery Adapter, command, browser, worker, or accepted entry point; exercise assembled public behavior; consume public Contracts; use PostgreSQL/infrastructure when material; assert observable result and rejection/failure; assert material Audit/Monitoring/Events/Jobs/Notifications; avoid private assertions; and remain selective/risk-driven.

Do not duplicate every unit, component, capability, or integration case at system level.

## 4. Replaced Services And Limitations

When a boundary is replaced, record the boundary, replacement mode, behavior still/not proven, separate real-boundary proof when required, and why replacement is acceptable.

Fake provider does not prove real provider integration; fake queue does not prove worker/retry/redelivery; server-rendered UI does not prove real browser interaction.

Do not hide replacements behind a broad `system test passed` statement.

## 5. End-To-End Workflow Selection

Reserve E2E proof for a small set of representative workflows where lower-level proof cannot establish the complete path.

Select by business/operational criticality, security sensitivity, data-loss risk, integration complexity, user visibility, prior defect history, and need to establish interaction across material layers/channels.

Do not create E2E proof for every criterion. Regression selection across levels belongs to [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md).

## 6. End-To-End Proof Construction

Use the real accepted entry point, cross material workflow layers/channels, use real browser/PostgreSQL/workers when those semantics are material, assert observable outcome plus rejection/failure, avoid private assertions, isolate scenario data, clean only owned resources, and declare real/replaced external services.

An external service may be replaced only when the proof does not claim that integration and another accepted proof covers the real boundary when required.

The E2E suite should remain small, independent, deterministic, isolated, evidence-capable, and maintainable. It does not substitute for capability, Contract, integration, security, accessibility, or visual proof.

## 7. Application-Level Smoke Testing

Application-level smoke is a small non-destructive proof that an assembled build/environment is stable enough for deeper verification. It may establish application boot, critical entry points, authentication entry, database connectivity/migration state, service reachability, assets, health endpoint, required configuration, or deployed revision in test/staging.

Smoke does not prove complete behavior, security, full integration, acceptance, or recovery.

Operational smoke for a deployed environment belongs to [Operational Testing Standards](../quality-and-operational-testing/operational-testing-standards.md). Do not use `sanity testing` as a separate official category.

## 8. Evidence And Reporting

Use [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md). Record enough context to make system boundary, real/replaced participants, entry point, actor, environment, scenario, result, cleanup, and limitations unambiguous.

Browser/E2E evidence may include screenshots, traces, console/network logs, and video when useful and safe. Evidence must be attributable to the exact revision and secret-safe.

## 9. Scope Control And Prohibited Patterns

Do not use system tests to bypass missing focused proof, assert private implementation, share mutable E2E state, depend on order, run uncontrolled live integration, classify a broad system failure as isolated proof without attribution, use smoke as acceptance, report replaced boundaries as real, or use E2E as the only security/accessibility/design proof.

## 10. Related

- [Integration And System Testing Standards Index](index.md)
- [Integration Testing Standards](integration-testing-standards.md)
- [Acceptance And Exploratory Testing Standards](acceptance-and-exploratory-testing-standards.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Operational Testing Standards](../quality-and-operational-testing/operational-testing-standards.md)
