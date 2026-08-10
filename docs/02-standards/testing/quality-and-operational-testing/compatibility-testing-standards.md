<!--
DOC-META
title: Compatibility Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/quality-and-operational-testing/compatibility-testing-standards.md
parent: docs/02-standards/testing/quality-and-operational-testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines supported-matrix, backward and forward compatibility, rolling-transition, and protocol/interchange compatibility verification rules.
-->

# Compatibility Testing Standards

Parent: [Quality And Operational Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Supported Matrix Authority](#2-supported-matrix-authority)
- [3. Matrix Selection](#3-matrix-selection)
- [4. Backward, Forward, And Transitional Compatibility](#4-backward-forward-and-transitional-compatibility)
- [5. Protocol And Interchange Compatibility](#5-protocol-and-interchange-compatibility)
- [6. Evidence And Reporting](#6-evidence-and-reporting)
- [7. Prohibited Patterns](#7-prohibited-patterns)
- [8. Related](#8-related)

## 1. Purpose And Authority

Define how accepted compatibility and interoperability requirements are verified across supported environments, versions, clients, providers, protocols, and transitional boundaries.

This standard does not define what the project supports. The supported matrix, compatibility lifetime, aliases, deprecations, protocol versions, or removal decisions remain with their canonical architecture, feature, naming, integration, database, UI, or deployment owners.

Testing verifies only the compatibility the project has accepted or the bounded issue explicitly requires.

## 2. Supported Matrix Authority

Every material compatibility proof cites the matrix or compatibility Contract it verifies.

Applicable dimensions may include:

- browser engine/version;
- operating system;
- PHP, Node, Laravel, package, or PostgreSQL version;
- external API or protocol version;
- client/provider version pair;
- email client;
- file format/encoding;
- locale/language/time zone;
- route, key, Event, Job, Contract, payload, or schema version;
- rolling-deployment overlap.

Testing must not expand the supported matrix because another combination happens to pass.

When the matrix is unresolved, the proof is not ready for acceptance execution.

## 3. Matrix Selection

A proof may use an accepted:

- full matrix;
- risk-based representative subset;
- changed-dimension matrix;
- minimum/maximum supported versions;
- authoritative native-platform combination;
- compatibility fixture set.

Declare selected combinations, excluded combinations, selection rationale, limitations, and any required specialist review.

One successful browser, OS, database, runtime, or provider version proves only that declared combination unless the matrix owner has accepted a broader representative strategy.

## 4. Backward, Forward, And Transitional Compatibility

Verify applicable accepted scenarios such as:

- prior client with current provider;
- current client with prior provider;
- rolling-deployment overlap;
- old and current serialized payloads;
- deprecated route or key aliases;
- Event or Job version transitions;
- schema/migration transition windows;
- upgrade and downgrade behavior where supported.

Verify both successful compatibility and the accepted rejection after a version or alias is no longer supported.

Do not preserve compatibility that has already been accepted for removal.

When compatibility behavior is being preserved through refactoring, characterization and protected-baseline rules follow [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md).

## 5. Protocol And Interchange Compatibility

Verify applicable:

- file parsing/generation;
- encoding and line endings;
- locale-sensitive values;
- time-zone representation;
- API request/response versions;
- webhook versions/signature-compatible payloads when owned elsewhere;
- Event/Job serialization;
- email rendering;
- external-provider sandbox compatibility.

A fixture proves only the represented version and case unless the proof declaration establishes broader coverage.

Provider-specific compatibility must use an authoritative Contract, fixture, sandbox, or staged provider appropriate to the claim.

## 6. Evidence And Reporting

Compatibility evidence must identify the exact matrix entries executed, source/provider versions, environment, revision, fixture/protocol version, result, exclusions, and limitations.

Detailed artifact/retention rules belong to [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 7. Prohibited Patterns

Do not:

- let testing expand the supported matrix;
- claim full compatibility from one representative combination without accepted authority;
- preserve aliases or deprecated behavior already approved for removal;
- treat a fixture as proof of every provider version;
- hide excluded matrix entries;
- use current implementation presence as compatibility authority;
- report a compatibility pass without naming the versions/combination actually tested.

## 8. Related

- [Quality And Operational Testing Standards Index](index.md)
- [Verification Contract Standards](../verification-contract/verification-contract-standards.md)
- [Initial Proof And Baseline Standards](../verification-contract/initial-proof-and-baseline-standards.md)
- [Test Environment And Equivalence Standards](../test-environments/test-environment-and-equivalence-standards.md)
- [Integration Testing Standards](../integration-and-system/integration-testing-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Repository Naming Standards](../../coding/repository-naming-standards.md)
