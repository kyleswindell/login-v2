<!--
DOC-META
title: External Service And Resource Isolation Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-environments/external-service-and-resource-isolation-standards.md
parent: docs/02-standards/testing/test-environments/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines testing policy for external-service modes, time and randomness, shared-resource isolation, parallel execution, and cleanup.
-->

# External Service And Resource Isolation Standards

Parent: [Test Environment Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. External Service Modes](#2-external-service-modes)
- [3. External Environment Declaration](#3-external-environment-declaration)
- [4. Time, Time Zones, Randomness, And Identifiers](#4-time-time-zones-randomness-and-identifiers)
- [5. Filesystem, Queue, Cache, Mail, Scheduler, And Realtime Resources](#5-filesystem-queue-cache-mail-scheduler-and-realtime-resources)
- [6. Parallel Execution And Resource Ownership](#6-parallel-execution-and-resource-ownership)
- [7. Cleanup And Teardown](#7-cleanup-and-teardown)
- [8. Evidence And Failure Routing](#8-evidence-and-failure-routing)
- [9. Prohibited Patterns](#9-prohibited-patterns)
- [10. Related](#10-related)

## 1. Purpose And Authority

Ensure tests that touch shared or external state remain attributable, isolated, reproducible, and safe.

This standard owns proof-environment policy for external systems and shared resources. It does not select test doubles, authorize external/production changes, or define provider behavior.

## 2. External Service Modes

Classify each external boundary as local fake, protocol stub, mock server, service virtualization, provider sandbox, staged live integration, or production-safe smoke.

The declared mode constrains the claim. A local fake can prove application behavior against the fake's declared Contract; it does not establish real provider authentication, signing, rate limiting, configuration, delivery, or provider-side state.

Use provider sandbox/staged integration when proof requires real authentication/signature behavior, protocol compatibility, pagination, webhooks, provider error translation, payload shape/configuration, or provider-side state transition.

Test-double selection belongs to [Automated And Static Testing Standards](../automated-and-static-testing-standards.md).

## 3. External Environment Declaration

Declare applicable provider/environment identity, endpoint class, authentication mode, secret source without disclosure, rate/quota limits, permitted operations, allowed data, cleanup, timing restrictions, evidence redaction, fixture provenance, and responsible executor.

Do not embed secrets in source, fixtures, logs, screenshots, or evidence. Do not run destructive/high-volume external proof without explicit authority and safe cleanup.

## 4. Time, Time Zones, Randomness, And Identifiers

Use controlled time for expiry, recent-auth windows, scheduling, retry/backoff, retention, token validity, and time-based transitions when possible.

Declare time zone when material. Test DST boundaries only when relevant.

Generated/randomized proof must record the seed, reproduce failure from it, retain minimized failing cases when supported, and avoid unbounded nondeterminism.

Real-time waiting requires justification when controlled time can establish the same condition. Use unique run-owned identifiers where shared state could collide.

## 5. Filesystem, Queue, Cache, Mail, Scheduler, And Realtime Resources

Use isolated temporary filesystem roots, storage disks, queue backends/namespaces, cache prefixes, mail transports/namespaces, scheduler state, realtime channels, and process/worker pools as applicable.

Declare whether each resource is fake, in-memory, local/container service, staged, or production-safe.

A fake resource proves only represented behavior: fake queue proves dispatch intent, fake filesystem proves application interaction, fake mail proves composition/dispatch intent, and in-memory cache does not prove distributed cache behavior.

Add real integration/native/staged/operational proof when the real boundary is material.

## 6. Parallel Execution And Resource Ownership

Every parallel run/worker owns unique applicable database/schema, cache prefix, queue namespace, filesystem root, browser context, port, mail namespace, realtime channel, external sandbox ID, temp directory, and evidence directory.

Include run/worker identity where practical. Parallel-safe proof must not depend on fixed mutable IDs, global state, shared files/ports/external records, execution order, or another worker's cleanup.

A serial-only proof declares that constraint and why isolation cannot currently make it parallel-safe.

## 7. Cleanup And Teardown

Cleanup removes only resources owned by the current execution. It should be deterministic, idempotent where practical, scoped by run identity, safe after partial setup/failure, and observable when incomplete.

Do not broadly clean shared developer, other-worktree, unowned staging, production, or unrelated provider-sandbox resources.

Preserve required failure evidence before destructive cleanup. Cleanup failure is a proof failure when it can leak data, affect later proof, alter shared state, break parallel attribution, or prevent reproduction.

## 8. Evidence And Failure Routing

Proof-state meanings belong to [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md). Execution-record/artifact requirements belong to [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

Record enough resource identity and cleanup state to establish what the proof touched. Do not convert attempted external/resource/cleanup/evidence failure into `BLOCKED` or `EXPECTED_NONPASS` after execution begins.

## 9. Prohibited Patterns

Do not:

- share mutable resources across parallel workers without isolation;
- use fixed ports/paths/IDs where proof can collide;
- use fake resources as real provider/worker/native/production proof;
- mutate shared external environments without authority;
- use production/customer data outside accepted procedures;
- wait on wall-clock time when controlled time is sufficient;
- clean resources not owned by the run;
- discard random failing cases without reproduction data;
- hide external/resource failures through runner retries.

## 10. Related

- [Test Environment Standards Index](index.md)
- [Automated And Static Testing Standards](../automated-and-static-testing-standards.md)
- [Integration Testing Standards](../integration-and-system/integration-testing-standards.md)
- [Reliability Testing Standards](../quality-and-operational-testing/reliability-testing-standards.md)
- [Operational Testing Standards](../quality-and-operational-testing/operational-testing-standards.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
