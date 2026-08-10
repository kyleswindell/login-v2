<!--
DOC-META
title: Performance Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/quality-and-operational-testing/performance-testing-standards.md
parent: docs/02-standards/testing/quality-and-operational-testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines performance proof requirements for thresholds, workload models, representative environments, measurements, load and scalability testing, and PostgreSQL performance verification.
-->

# Performance Testing Standards

Parent: [Quality And Operational Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Requirement And Threshold Authority](#2-requirement-and-threshold-authority)
- [3. Workload Model](#3-workload-model)
- [4. Performance Environment](#4-performance-environment)
- [5. Metrics, Repetition, And Variance](#5-metrics-repetition-and-variance)
- [6. Load, Stress, Spike, Endurance, Capacity, And Scalability](#6-load-stress-spike-endurance-capacity-and-scalability)
  - [Load](#load)
  - [Stress](#stress)
  - [Spike](#spike)
  - [Endurance](#endurance)
  - [Capacity](#capacity)
  - [Scalability](#scalability)
- [7. Database Performance Testing](#7-database-performance-testing)
- [8. Evidence And Reporting](#8-evidence-and-reporting)
- [9. Prohibited Patterns](#9-prohibited-patterns)
- [10. Related](#10-related)

## 1. Purpose And Authority

Define how accepted performance and scalability requirements are verified.

This standard owns proof construction for latency, throughput, resource use, load, stress, spike, endurance, capacity, scalability, and database performance.

It does not choose numeric thresholds, service-level objectives, supported capacity, topology, indexes, schema, or scaling strategy. Those remain with the applicable feature, architecture, database, operations, or other requirement owner.

A diagnostic benchmark without an accepted threshold or comparison question is useful evidence but is not acceptance proof.

## 2. Requirement And Threshold Authority

A material performance proof must cite its requirement source and declare applicable:

- metric;
- threshold or comparison rule;
- percentile or aggregation;
- workload;
- data volume;
- concurrency;
- duration;
- accepted variance;
- environment;
- reviewer/acceptance authority.

Valid threshold forms may include maximum latency at a declared percentile, minimum throughput, maximum query count/resource growth/migration duration, or a bounded regression limit against an accepted baseline.

Do not infer a target from:

- current implementation performance;
- tool defaults;
- developer hardware;
- one prior run;
- generic industry guidance;
- an agent-generated benchmark.

When no accepted threshold exists, label the work diagnostic and report observations without declaring acceptance.

## 3. Workload Model

The workload must represent the requirement being proven.

Declare applicable:

- operation/request mix;
- actor distribution;
- read/write ratio;
- payload sizes;
- data distribution and volume;
- cache state;
- authentication state;
- concurrency and arrival pattern;
- think time;
- test duration;
- external-service behavior;
- background workload.

Do not use one trivial operation to represent a multi-operation workload. Preserve functional correctness checks during performance execution; a fast incorrect result is not a performance success.

## 4. Performance Environment

Record the material environment needed to interpret the result, including applicable:

- hardware or virtual resources;
- operating system;
- runtime and framework versions;
- application/build configuration;
- PostgreSQL version/configuration;
- cache, queue, and worker topology;
- network conditions;
- process/worker count;
- instrumentation;
- background load;
- dataset and warm/cold state.

Environment validity and equivalence follow [Test Environment And Equivalence Standards](../test-environments/test-environment-and-equivalence-standards.md).

Do not compare revisions from materially different environments without qualification. A developer workstation result does not establish staging or production capacity.

## 5. Metrics, Repetition, And Variance

Collect the metrics material to the accepted requirement, such as:

- latency percentiles;
- throughput;
- error and timeout rates;
- queue depth;
- CPU/memory;
- disk/network I/O;
- connection use;
- lock waits;
- query count/slow queries;
- cache hit rate;
- external-service time;
- worker/process restarts;
- resource leakage;
- data correctness under load.

Average latency alone is normally insufficient for tail-sensitive behavior.

Declare warm-up, measurement window, repetition count, comparison order, variance, and outlier treatment when material. Avoid conclusions from one unrepeatable run.

For revision comparisons, keep workload and environment materially equivalent, identify both revisions, report absolute results and change, and retain raw machine-readable reports when the decision depends on them.

## 6. Load, Stress, Spike, Endurance, Capacity, And Scalability

### Load

Verify accepted behavior under expected workload, including threshold compliance, functional correctness, error rate, resource use, and queue/backlog stability.

### Stress

Increase pressure beyond expected limits to identify saturation, safe rejection, resource-exhaustion behavior, and recovery. Stress testing is not automatically an acceptance gate unless the work packet declares it.

### Spike

Verify sudden workload changes, including admission control, queue growth, timeout/rejection behavior, recovery, and data correctness.

### Endurance

Use sustained workload when the risk concerns memory/connection/file-handle leaks, queue or cache growth, log growth, latency degradation, scheduler drift, resource fragmentation, or data inconsistency. Duration must be sufficient for the suspected risk.

### Capacity

Estimate the practical supported limit for one declared environment/workload. Record limiting resource, threshold breached, error behavior, correctness, recovery, and uncertainty. Do not generalize one environment's capacity to every environment.

### Scalability

Compare behavior across an accepted resource or topology change. Declare scaling dimension, baseline, changed resource, workload, expected relationship, bottleneck, and environment equivalence. Testing does not decide whether horizontal or vertical scaling is the target architecture.

## 7. Database Performance Testing

Use PostgreSQL for Login 2.0 application database-performance claims.

Verify applicable:

- query count and plans;
- index use and material sequential scans;
- N+1 behavior;
- pagination/cursor/batch behavior;
- lock duration/waits;
- transaction duration;
- connection use;
- representative large-data behavior;
- write amplification;
- cleanup/retention Job behavior;
- migration/backfill duration when performance is the criterion.

Use representative row count, distribution, selectivity, relationship density, payload size, historical volume, and concurrent activity. Tiny fixtures do not prove scalability.

Query plans are environment/data dependent. Record PostgreSQL version, schema/statistics state, dataset, and material configuration.

Performance testing must not redefine database indexes, constraints, retention, or migration behavior.

## 8. Evidence And Reporting

Material performance evidence should preserve raw machine-readable results plus the declared workload, environment, duration, concurrency, threshold/comparison, summarized metrics, and limitations.

Detailed evidence format and retention follow [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 9. Prohibited Patterns

Do not:

- invent an acceptance threshold from the measured baseline;
- call a diagnostic benchmark acceptance proof;
- compare materially different environments without qualification;
- claim acceptance from average latency alone when tail behavior matters;
- use tiny fixtures to prove scale;
- hide errors or incorrect results behind throughput statistics;
- generalize one capacity result to all deployments;
- run uncontrolled load/stress/endurance/capacity tests in production;
- omit the raw report when material measurements are relied upon.

## 10. Related

- [Quality And Operational Testing Standards Index](index.md)
- [Test Environment And Equivalence Standards](../test-environments/test-environment-and-equivalence-standards.md)
- [Test Data And Fixture Standards](../test-environments/test-data-and-fixture-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Database Standards Index](../../database/index.md)
- [Query And Performance Standards](../../coding/Query%20And%20Performance%20Standards.md)
