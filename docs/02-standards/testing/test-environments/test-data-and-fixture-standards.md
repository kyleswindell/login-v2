<!--
DOC-META
title: Test Data And Fixture Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-environments/test-data-and-fixture-standards.md
parent: docs/02-standards/testing/test-environments/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines verification policy for test data, factories, scenario builders, seeders, fixtures, provenance, invalid-state fixtures, and sensitive test data.
-->

# Test Data And Fixture Standards

Parent: [Test Environment Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Test Data Principles](#2-test-data-principles)
- [3. Factories, Scenario Builders, And Seeders](#3-factories-scenario-builders-and-seeders)
  - [Factories](#factories)
  - [Scenario builders](#scenario-builders)
  - [Seeders](#seeders)
- [4. Fixtures And Invalid-State Fixtures](#4-fixtures-and-invalid-state-fixtures)
  - [Invalid-state fixtures](#invalid-state-fixtures)
- [5. Ownership And Provenance](#5-ownership-and-provenance)
- [6. Synthetic, Production-Derived, And Sensitive Data](#6-synthetic-production-derived-and-sensitive-data)
- [7. Protected Fixture Semantics](#7-protected-fixture-semantics)
- [8. Prohibited Patterns](#8-prohibited-patterns)
- [9. Related](#9-related)

## 1. Purpose And Authority

Ensure proof data is explicit, reproducible, safe, and owned.

This standard defines what valid test data and fixtures must represent. It does not define application schema, feature behavior, or the PHP/Laravel code used to build factories and fixtures.

Source construction belongs to the [Test Implementation Standards Index](../../coding/test-implementation/index.md).

## 2. Test Data Principles

Test data must be explicit, minimal, deterministic, representative, isolated from production, classified for sensitivity, reproducible, disposable unless retained as evidence, and owned by the applicable proof or scenario.

Include only states needed to establish applicable behavior, such as valid/invalid data, boundary values, denied actors, inactive/expired/revoked state, duplicate/stale/conflicting state, or cross-owner/scope denial.

Do not use large opaque fixture sets when a small named scenario makes the relevant state clearer. Realistic data does not mean copied production data.

## 3. Factories, Scenario Builders, And Seeders

These are proof-data concepts; source-code mechanics are owned by coding test-implementation standards.

### Factories

A factory constructs valid owner-local records and meaningful named states. Output should respect accepted defaults/invariants, expose material lifecycle/actor/permission state, avoid hidden cross-owner setup/unrelated records, and remain deterministic.

A factory does not define schema or feature behavior.

### Scenario builders

Use a scenario builder when repeated proof requires the same meaningful multi-record or multi-owner arrangement. Make actor, target, owner boundaries, permissions, lifecycle state, external dependencies, and expected cleanup visible.

Do not use a scenario builder to conceal the state being tested or create a universal application setup.

### Seeders

Use a seeder for broad deterministic baseline data only when the baseline is itself an accepted shared application/environment prerequisite. Do not use broad seeders for ordinary isolated setup or to bypass application setup Contracts.

## 4. Fixtures And Invalid-State Fixtures

A fixture may represent stable input/output, payload, file, protocol message, snapshot, external Contract example, schema sample, generated case, or expected report.

Fixtures must have one clear owner, enough provenance to reproduce/review them, deterministic content, no secrets/restricted data, provider/Contract version when material, clear invalidity failures, and reviewable expected output.

Do not automatically regenerate expected-output fixtures or snapshots without reviewing the difference.

### Invalid-state fixtures

Use only when the proof requires a state accepted production APIs would reject and ordinary public setup cannot represent it.

- name the invalid condition;
- bypass only the minimum invariant;
- keep it local or clearly test-only;
- prevent use as normal setup;
- document why public setup cannot create it;
- never redefine invalid state as acceptable production state.

## 5. Ownership And Provenance

A material fixture should identify applicable owner, purpose, source, format, provider/Contract version, generation method/tool/version, random seed, sensitivity, and update authority.

External Contract fixtures additionally record material provider environment, collection date, sanitization, redistribution limits, and secret/privacy review.

Generated failing cases retain enough data to reproduce the failure, including seed and minimized case where supported.

## 6. Synthetic, Production-Derived, And Sensitive Data

Synthetic data is the default.

Do not include real customer/user data, credentials/tokens, MFA/recovery secrets, private keys, authorization headers/cookies, private documents, restricted logs, or unapproved production payloads.

Production-derived data requires explicit authority from applicable Data, Privacy, Security, and repository owners. Do not assume masking alone makes a dataset anonymous or safe.

When authorized, record source/purpose, approval, transformations, residual sensitivity, retention, deletion procedure, and evidence restrictions. Review retained artifacts for sensitive data before upload/publication.

## 7. Protected Fixture Semantics

A fixture, factory state, scenario, dataset, expected output, or snapshot becomes protected verification evidence when changing it can alter accepted proof meaning.

Protected semantics and revision authority are governed by [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md).

Do not narrow, regenerate, sanitize differently, or materially change protected proof data without the required revision.

## 8. Prohibited Patterns

Do not:

- use production data by default;
- embed secrets in fixtures/reports/screenshots/source;
- use broad seeders when focused setup is sufficient;
- let factories/fixtures silently bypass owner invariants;
- use opaque fixtures without provenance;
- hide actors/permissions/expected state inside generic helpers;
- update expected output automatically to make proof pass;
- discard failing generated cases without reproduction data;
- materially change protected proof data without authority.

## 9. Related

- [Test Environment Standards Index](index.md)
- [Test Implementation Standards Index](../../coding/test-implementation/index.md)
- [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Security Standards Index](../../security/index.md)
- [Database Standards Index](../../database/index.md)
