<!--
DOC-META
title: Reliability, Performance, Compatibility, And Operational Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/reliability-performance-compatibility-and-operational-testing-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines construction and evidence rules for reliability, failure-state, transaction, concurrency, idempotency, retry, recovery, performance, compatibility, build, deployment, migration, health, operational-smoke, and production-safe proofs.
-->

# Reliability, Performance, Compatibility, And Operational Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Proof Declaration](#2-proof-declaration)
- [3. Reliability And Failure-State Testing](#3-reliability-and-failure-state-testing)
  - [3.1. Failure classes](#31-failure-classes)
  - [3.2. Safe-state assertions](#32-safe-state-assertions)
  - [3.3. Degraded dependency behavior](#33-degraded-dependency-behavior)
  - [3.4. Failure observability](#34-failure-observability)
- [4. Transactions, Rollback, And Side-Effect Ordering](#4-transactions-rollback-and-side-effect-ordering)
  - [4.1. Transaction ownership and boundaries](#41-transaction-ownership-and-boundaries)
  - [4.2. Rollback proof](#42-rollback-proof)
  - [4.3. External effects and compensation](#43-external-effects-and-compensation)
  - [4.4. After-commit behavior](#44-after-commit-behavior)
- [5. Concurrency Testing](#5-concurrency-testing)
  - [5.1. Concurrency model](#51-concurrency-model)
  - [5.2. Controlled execution](#52-controlled-execution)
  - [5.3. Concurrency outcomes](#53-concurrency-outcomes)
  - [5.4. Concurrency evidence](#54-concurrency-evidence)
- [6. Idempotency And Duplicate-Execution Testing](#6-idempotency-and-duplicate-execution-testing)
  - [6.1. Idempotency Contract](#61-idempotency-contract)
  - [6.2. Duplicate execution](#62-duplicate-execution)
  - [6.3. Idempotency-key behavior](#63-idempotency-key-behavior)
  - [6.4. Idempotency limits](#64-idempotency-limits)
- [7. Retry, Timeout, Backoff, And Exhaustion Testing](#7-retry-timeout-backoff-and-exhaustion-testing)
  - [7.1. Retry classification](#71-retry-classification)
  - [7.2. Time control](#72-time-control)
  - [7.3. Exhaustion and terminal failure](#73-exhaustion-and-terminal-failure)
  - [7.4. Retry side effects](#74-retry-side-effects)
- [8. Recovery And Resilience Testing](#8-recovery-and-resilience-testing)
  - [8.1. Recovery authority](#81-recovery-authority)
  - [8.2. Restart and resume](#82-restart-and-resume)
  - [8.3. Backup, restore, rollback, and replay](#83-backup-restore-rollback-and-replay)
  - [8.4. Fault injection](#84-fault-injection)
- [9. Performance Proof Declaration](#9-performance-proof-declaration)
  - [9.1. Requirement and threshold authority](#91-requirement-and-threshold-authority)
  - [9.2. Workload model](#92-workload-model)
  - [9.3. Performance environment](#93-performance-environment)
  - [9.4. Metrics and observations](#94-metrics-and-observations)
  - [9.5. Warm-up, repetitions, and variance](#95-warm-up-repetitions-and-variance)
- [10. Load, Stress, Spike, Endurance, Capacity, And Scalability Testing](#10-load-stress-spike-endurance-capacity-and-scalability-testing)
  - [10.1. Load testing](#101-load-testing)
  - [10.2. Stress testing](#102-stress-testing)
  - [10.3. Spike testing](#103-spike-testing)
  - [10.4. Endurance testing](#104-endurance-testing)
  - [10.5. Capacity testing](#105-capacity-testing)
  - [10.6. Scalability testing](#106-scalability-testing)
- [11. Database Performance Testing](#11-database-performance-testing)
- [12. Compatibility And Interoperability Testing](#12-compatibility-and-interoperability-testing)
  - [12.1. Supported matrix authority](#121-supported-matrix-authority)
  - [12.2. Matrix selection](#122-matrix-selection)
  - [12.3. Backward and forward compatibility](#123-backward-and-forward-compatibility)
  - [12.4. Interchange and protocol compatibility](#124-interchange-and-protocol-compatibility)
- [13. Build Verification](#13-build-verification)
- [14. Deployment And Migration Verification](#14-deployment-and-migration-verification)
  - [14.1. Deployment proof](#141-deployment-proof)
  - [14.2. Migration proof](#142-migration-proof)
  - [14.3. Rollback and recovery readiness](#143-rollback-and-recovery-readiness)
- [15. Health, Monitoring, Alerting, And Operational Smoke](#15-health-monitoring-alerting-and-operational-smoke)
  - [15.1. Health proof](#151-health-proof)
  - [15.2. Monitoring and logging proof](#152-monitoring-and-logging-proof)
  - [15.3. Alert-routing proof](#153-alert-routing-proof)
  - [15.4. Operational smoke](#154-operational-smoke)
- [16. Production-Safe Verification](#16-production-safe-verification)
- [17. Evidence And Reporting](#17-evidence-and-reporting)
- [18. Failure Classification](#18-failure-classification)
  - [`BLOCKED`](#blocked)
  - [`EXECUTED + FAIL`](#executed--fail)
- [19. Prohibited Patterns](#19-prohibited-patterns)
- [20. Related](#20-related)

## 1. Purpose And Authority

Define how accepted reliability, performance, compatibility, deployment, migration, health, and operational requirements are verified.

This standard owns:

- proof construction;
- proof-environment requirements;
- safe-state assertions;
- concurrency and duplicate-execution methods;
- performance-test declarations;
- compatibility-matrix execution;
- operational evidence;
- result classification.

This standard does not define:

- feature behavior;
- transaction ownership;
- retry policy;
- idempotency semantics;
- timeout values;
- recovery objectives;
- performance thresholds;
- service-level objectives;
- supported platforms or versions;
- database schema;
- deployment procedures;
- migration procedures;
- rollback procedures;
- monitoring policy;
- alert-routing policy;
- production-change authority.

Those requirements remain with their canonical architecture, feature, flow, coding, database, security, integration, configuration, deployment, and runbook owners.

A test must cite the accepted requirement, threshold, matrix, or procedure it verifies. A test does not independently choose the target state.

## 2. Proof Declaration

Every material reliability, performance, compatibility, or operational `PF-*` proof declares applicable:

- proof ID;
- mapped `AC-*` criteria;
- requirement source;
- requirement owner;
- quality concern;
- proof type;
- actor or system identity;
- starting state;
- workload or failure condition;
- expected success;
- expected rejection or failure;
- required safe state;
- required side effects;
- prohibited side effects;
- environment;
- data volume;
- concurrency;
- duration;
- exact command or procedure;
- threshold or compatibility matrix;
- evidence to retain;
- required reviewer;
- execution stage;
- cleanup;
- limitations.

When a threshold, matrix, or procedure is unresolved, the proof is not ready to execute.

Do not infer an operational target from:

- current implementation;
- tool defaults;
- local developer hardware;
- one prior passing run;
- generic industry guidance;
- an agent-generated benchmark;
- an existing test that lacks an accepted owner.

## 3. Reliability And Failure-State Testing

Reliability proof verifies that the system remains correct, safe, and observable when expected failures occur.

### 3.1. Failure classes

Test applicable accepted failure classes:

- validation rejection;
- authorization rejection;
- domain invariant rejection;
- expected exception;
- timeout;
- unavailable dependency;
- partial dependency failure;
- malformed remote response;
- interrupted process;
- worker termination;
- failed Job;
- retry exhaustion;
- stale state;
- conflicting update;
- duplicate request;
- duplicate message;
- invalid or partial artifact;
- resource exhaustion;
- degraded but accepted operation.

The proof must distinguish:

- expected public rejection;
- recoverable technical failure;
- terminal technical failure;
- invalid environment or fixture failure.

An environment, dependency, fixture, syntax, boot, tooling, or evidence-capture failure is not expected missing behavior.

### 3.2. Safe-state assertions

Failure proof must assert safe state, not only an error response or thrown exception.

Verify applicable:

- durable state is unchanged;
- partial state is rolled back;
- valid prior state remains readable;
- unauthorized data is not disclosed;
- prohibited Event is not published;
- prohibited Job is not dispatched;
- prohibited Notification is not sent;
- prohibited external call is not made;
- duplicate durable record is not created;
- required lock or reservation is released;
- temporary resources are cleaned up;
- correlation and audit evidence are present;
- retry or operator recovery remains possible;
- user-visible status is accurate.

A status code, exception type, or failed command alone does not prove safe failure behavior.

### 3.3. Degraded dependency behavior

When accepted requirements define degraded operation, verify:

- which dependency is unavailable;
- which behavior remains available;
- which behavior is rejected;
- whether stale data may be used;
- whether fallback data is allowed;
- how freshness is disclosed;
- whether mutations are prohibited;
- how recovery is detected;
- how normal behavior resumes.

Do not invent a fallback merely to keep a test passing.

A test using a local fake does not prove actual dependency degradation unless the fake reproduces the accepted failure Contract and another proof covers the real boundary where required.

### 3.4. Failure observability

Verify applicable:

- structured log entry;
- correlation identifier;
- audit event;
- metric;
- trace;
- failed-job record;
- health-state change;
- alert trigger;
- operator-visible status;
- secret and sensitive-data redaction.

Observability assertions must follow the applicable logging, security, monitoring, and runbook owners.

A failure test must not require exposing secrets, stack traces, internal SQL, credentials, or restricted personal data.

## 4. Transactions, Rollback, And Side-Effect Ordering

Transaction proof verifies accepted atomicity, consistency, and side-effect timing.

### 4.1. Transaction ownership and boundaries

The proof must identify:

- transaction owner;
- transaction start and commit boundary;
- participating durable mutations;
- operations outside the transaction;
- accepted isolation or locking behavior;
- after-commit behavior;
- failure point;
- required rollback result.

Testing does not select transaction ownership.

Do not create one broad test transaction around the proof when it hides production commit, visibility, locking, or rollback behavior.

### 4.2. Rollback proof

Inject failure at applicable accepted points and verify:

- no partial durable state;
- no orphan records;
- no incorrect status transition;
- no prohibited external effect;
- no prohibited Event or Job;
- required audit or failure record;
- released locks and temporary resources;
- safe retry or operator recovery.

A rollback proof should exercise the real transaction boundary where practical.

A mocked database exception may supplement targeted logic proof but does not establish PostgreSQL transaction behavior.

### 4.3. External effects and compensation

When a workflow combines local mutation and external effects, verify the accepted ordering.

Examples:

- persist local intent before remote call;
- publish after commit;
- record remote identifier after success;
- compensate after accepted partial completion;
- retain recoverable pending state after remote timeout.

The proof must cite the accepted flow or runbook.

Do not infer distributed-transaction, outbox, saga, compensation, or reconciliation behavior from test convenience.

### 4.4. After-commit behavior

When Events, Jobs, Notifications, or integrations are required after commit, verify:

- they are not emitted before commit;
- rollback suppresses them;
- a worker or independent connection sees committed state;
- retry does not duplicate the accepted result;
- failure remains observable.

Use a real commit boundary and independent process or connection when those semantics are material.

## 5. Concurrency Testing

Concurrency proof verifies behavior when operations overlap rather than merely execute sequentially.

### 5.1. Concurrency model

Declare:

- competing operations;
- actor or process identity;
- shared resource;
- starting state;
- synchronization point;
- accepted winner, loser, merge, queue, or retry behavior;
- expected durable state;
- required rejection;
- lock or version strategy defined by the canonical owner.

Do not label repeated sequential calls as concurrency testing.

### 5.2. Controlled execution

Use deterministic coordination where practical:

- barriers;
- latches;
- explicit transaction holds;
- independent database connections;
- separate processes;
- worker synchronization;
- controlled delays at declared test hooks;
- database advisory or row-lock coordination when accepted.

Avoid timing-only races based on arbitrary sleep durations.

A concurrency proof must fail clearly when the intended overlap did not occur.

### 5.3. Concurrency outcomes

Verify applicable:

- lost-update prevention;
- uniqueness races;
- duplicate creation prevention;
- optimistic version rejection;
- pessimistic locking;
- deadlock handling;
- lock timeout;
- last-administrator or equivalent invariant;
- quota, counter, stock, balance, or reservation integrity;
- ordering guarantees;
- one-time token or invitation use;
- concurrent idempotency-key use;
- stale update rejection.

Assert both:

- final durable state;
- each participant’s public result or rejection.

### 5.4. Concurrency evidence

Record applicable:

- process or worker identifiers;
- connection identifiers;
- synchronization steps;
- start and completion order;
- lock observations;
- transaction results;
- final state;
- database version;
- isolation level;
- retries;
- limitations.

A test that passes without demonstrating overlap is not valid concurrency evidence.

## 6. Idempotency And Duplicate-Execution Testing

### 6.1. Idempotency Contract

The proof must cite the owner-defined idempotency Contract, including applicable:

- operation identity;
- idempotency key;
- key scope;
- request equivalence;
- retention period;
- accepted repeated result;
- conflict result;
- concurrency behavior;
- retry relationship.

Testing does not choose which operations are idempotent.

### 6.2. Duplicate execution

Execute the accepted operation more than once and verify:

- stable public result;
- one durable effect;
- no duplicate Event, Job, Notification, audit record, or remote effect beyond accepted behavior;
- correct response to changed payload under the same key;
- correct result after prior success;
- correct result after prior failure;
- correct concurrent duplicate behavior where applicable.

Calling a method twice without asserting durable and side-effect outcomes is insufficient.

### 6.3. Idempotency-key behavior

Verify applicable:

- required or optional key;
- key format;
- key ownership;
- actor or tenant scope;
- duplicate payload match;
- conflicting payload rejection;
- concurrent first use;
- stored result reuse;
- expiration;
- cleanup;
- secret-safe logging.

Exact key semantics remain with the feature, API, or integration owner.

### 6.4. Idempotency limits

A proof must disclose behavior it does not establish.

Examples:

- sequential duplicates do not prove concurrent duplicates;
- local duplicates do not prove provider-side idempotency;
- fake queue redelivery does not prove broker redelivery;
- one retained key does not prove cleanup or expiry;
- one process does not prove cross-process uniqueness.

## 7. Retry, Timeout, Backoff, And Exhaustion Testing

### 7.1. Retry classification

Verify the accepted classification of:

- retryable failure;
- non-retryable failure;
- terminal rejection;
- timeout;
- rate limit;
- connection failure;
- malformed response;
- authentication failure;
- provider business rejection.

Testing must not classify a failure as retryable merely because retry succeeds in the test.

### 7.2. Time control

Use controlled time for:

- backoff;
- retry schedule;
- timeout boundary;
- key expiry;
- circuit or health state;
- scheduled recovery.

Do not make ordinary automated tests wait through real production-duration delays when time can be controlled.

When real timing is material, declare:

- clock source;
- tolerance;
- environment;
- scheduling jitter;
- measurement method.

### 7.3. Exhaustion and terminal failure

Verify applicable:

- maximum attempts;
- terminal failure record;
- failed-job state;
- operator-visible status;
- alert or metric;
- preserved recoverable input;
- no duplicate durable effect;
- no infinite retry loop;
- approved manual recovery path.

The exact recovery procedure belongs to the applicable runbook.

### 7.4. Retry side effects

Across retries, verify applicable:

- one durable mutation;
- one accepted Event;
- one accepted Notification;
- bounded audit entries;
- no duplicate remote mutation;
- correlation and attempt identifiers;
- final status;
- cleanup of temporary state.

Retries must not hide non-idempotent behavior.

## 8. Recovery And Resilience Testing

### 8.1. Recovery authority

Recovery proof must cite:

- accepted recovery objective;
- applicable runbook;
- responsible operator or executor;
- required environment;
- allowed data loss, if any;
- expected service state;
- evidence and review authority.

This standard does not define recovery-time objectives, recovery-point objectives, backup policy, rollback policy, or disaster-recovery architecture.

### 8.2. Restart and resume

Verify applicable:

- application restart;
- worker restart;
- scheduler restart;
- process interruption;
- resumable export or import;
- recovery from temporary database unavailability;
- recovery from cache loss;
- recovery from external-service outage;
- stale lock or lease handling;
- recovery of pending work.

Assert:

- accepted work resumes or fails safely;
- no duplicate durable effect;
- no lost accepted work beyond the declared requirement;
- health and monitoring recover;
- operator state is accurate.

### 8.3. Backup, restore, rollback, and replay

When authorized by a runbook, verify applicable:

- backup creation;
- backup integrity;
- restore into an isolated environment;
- schema and application compatibility;
- restored data integrity;
- rollback procedure;
- Event or message replay;
- duplicate prevention;
- recovery verification;
- evidence retention.

A backup command that exits successfully does not prove restore capability.

Do not perform destructive restore or rollback against shared or production environments without explicit authority.

### 8.4. Fault injection

Fault injection may be used to test accepted resilience behavior.

Declare:

- injected fault;
- injection point;
- scope;
- duration;
- safety boundary;
- expected behavior;
- cleanup;
- stop condition.

Examples:

- connection interruption;
- process termination;
- delayed response;
- malformed response;
- queue unavailability;
- disk limit in an isolated environment;
- cache loss;
- worker failure.

Do not perform uncontrolled chaos or destructive fault injection against shared staging or production systems.

## 9. Performance Proof Declaration

Performance proof is valid only against an accepted requirement or bounded diagnostic question.

### 9.1. Requirement and threshold authority

Declare:

- requirement source;
- metric;
- threshold or comparison;
- percentile or aggregation;
- workload;
- environment;
- data volume;
- concurrency;
- duration;
- accepted variance;
- reviewer.

Examples of threshold forms include:

- maximum latency at a declared percentile;
- minimum throughput;
- maximum query count;
- maximum memory growth;
- maximum migration duration;
- no material regression beyond an accepted comparison limit.

The testing standard does not choose the numeric target.

A diagnostic benchmark without an accepted threshold must be labeled diagnostic, not acceptance proof.

### 9.2. Workload model

Declare applicable:

- operation mix;
- request distribution;
- actor distribution;
- read-to-write ratio;
- payload sizes;
- data volume;
- cache state;
- authentication state;
- concurrency;
- arrival pattern;
- think time;
- duration;
- external-service behavior;
- background workload.

The workload must represent the requirement being proven.

Do not use one trivial request as proof of a multi-operation production workload.

### 9.3. Performance environment

Record:

- hardware or virtual resources;
- operating system;
- runtime versions;
- application configuration;
- database version and configuration;
- cache and queue services;
- network conditions;
- process and worker count;
- build mode;
- instrumentation;
- background load;
- dataset;
- warm or cold state.

Do not compare results from materially different environments without qualification.

A developer workstation result does not automatically establish staging or production capacity.

### 9.4. Metrics and observations

Collect applicable:

- latency percentiles;
- throughput;
- error rate;
- timeout rate;
- queue depth;
- worker utilization;
- CPU;
- memory;
- disk and network I/O;
- database connections;
- lock waits;
- query count;
- slow queries;
- cache hit rate;
- external-service time;
- garbage collection or process restarts;
- resource leakage;
- data correctness under load.

Average latency alone is normally insufficient for user-facing or tail-sensitive behavior.

Performance proof must also confirm functional correctness during the workload.

### 9.5. Warm-up, repetitions, and variance

Declare:

- warm-up procedure;
- measurement window;
- repetition count;
- order of comparison;
- variance;
- outlier treatment;
- confidence or interpretation method where applicable.

Avoid conclusions from one unrepeatable run.

When comparing revisions:

- use the same workload;
- use materially equivalent environments;
- control background load;
- identify both revisions;
- report absolute results and change;
- retain raw reports when material.

## 10. Load, Stress, Spike, Endurance, Capacity, And Scalability Testing

### 10.1. Load testing

Load testing verifies accepted behavior under expected workload.

Verify:

- threshold compliance;
- functional correctness;
- error rate;
- resource use;
- queue or backlog stability;
- safe-state behavior.

### 10.2. Stress testing

Stress testing increases pressure beyond expected limits to identify:

- saturation point;
- failure mode;
- safe rejection;
- resource exhaustion behavior;
- recovery after pressure is removed.

Stress testing is not automatically an acceptance gate unless the work packet defines one.

### 10.3. Spike testing

Spike testing verifies behavior under a sudden workload increase or decrease.

Verify applicable:

- admission control;
- queue growth;
- timeout behavior;
- safe rejection;
- autoscaling or worker response when owned elsewhere;
- recovery;
- no data corruption.

### 10.4. Endurance testing

Endurance testing applies sustained workload to identify:

- memory leak;
- connection leak;
- file-handle leak;
- queue buildup;
- cache growth;
- log growth;
- latency degradation;
- scheduler drift;
- resource fragmentation;
- data inconsistency.

The declared duration must be sufficient for the suspected risk.

### 10.5. Capacity testing

Capacity testing estimates the practical supported limit for a declared environment and workload.

Record:

- limiting resource;
- threshold breached;
- error behavior;
- data correctness;
- recovery;
- uncertainty.

Do not generalize one environment’s capacity to all supported environments.

### 10.6. Scalability testing

Scalability testing compares accepted workload behavior across resource or topology changes.

Declare:

- scaling dimension;
- baseline;
- changed resource;
- workload;
- expected relationship;
- bottleneck;
- environment equivalence.

Testing does not define whether horizontal or vertical scaling is required.

## 11. Database Performance Testing

Use PostgreSQL for Login 2.0 application database-performance claims.

Verify applicable:

- query count;
- query plan;
- index use;
- sequential scans where material;
- N+1 behavior;
- pagination;
- cursor behavior;
- batch size;
- lock duration;
- lock waits;
- transaction duration;
- connection use;
- large-data behavior;
- write amplification;
- cleanup or retention Job behavior;
- migration duration;
- data-preserving backfill;
- vacuum or maintenance interaction when owned by a runbook.

Use representative:

- row count;
- distribution;
- selectivity;
- relationship density;
- payload size;
- historical volume;
- concurrent activity.

Tiny fixtures do not prove scalability.

A query plan is environment- and data-dependent. Record PostgreSQL version, schema state, statistics state, dataset, and relevant configuration.

Database-performance testing must not redefine indexes, constraints, schema, retention, or migration behavior. Those decisions remain with database owners.

## 12. Compatibility And Interoperability Testing

### 12.1. Supported matrix authority

Test only compatibility the project supports or the issue explicitly requires.

The matrix must cite its owner.

Applicable dimensions may include:

- browser engine and version;
- viewport;
- input method;
- operating system;
- PHP version;
- Node version;
- Laravel version;
- package version;
- PostgreSQL version;
- external API version;
- email client;
- file format;
- encoding;
- locale;
- language;
- time zone;
- network condition;
- route, key, Contract, Event, Job, or schema version.

Testing does not expand the supported matrix.

### 12.2. Matrix selection

A proof may use:

- full matrix;
- risk-based representative matrix;
- changed-dimension matrix;
- minimum and maximum supported versions;
- one authoritative native platform;
- compatibility fixture set.

Declare:

- selected combinations;
- excluded combinations;
- selection rationale;
- coverage limits;
- required specialist review.

A passing result on one browser, operating system, database, or runtime does not prove the full matrix.

### 12.3. Backward and forward compatibility

Verify accepted:

- prior client with current provider;
- current client with prior provider;
- rolling-deployment overlap;
- old serialized payload;
- current serialized payload;
- deprecated route or key;
- migration transition;
- upgrade and downgrade behavior where supported.

Do not preserve compatibility behavior already accepted for removal.

Characterization of compatibility behavior follows [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md).

### 12.4. Interchange and protocol compatibility

Verify applicable:

- file parsing and generation;
- encoding;
- line endings;
- locale-sensitive values;
- time-zone representation;
- API request and response versions;
- webhook versions;
- Event and Job serialization;
- email rendering;
- external provider sandbox compatibility.

A fixture proves only the represented version and case unless the proof declares broader coverage.

## 13. Build Verification

Build verification confirms that accepted source can produce the required artifact.

Verify applicable:

- dependency installation;
- lockfile consistency;
- PHP autoload generation;
- frontend production build;
- asset manifest;
- generated registration or manifest output;
- configuration compilation;
- package discovery;
- container image build;
- documentation build;
- artifact identity;
- reproducibility requirements;
- secret exclusion.

A mutating build preparation step must be followed by applicable non-mutating validation.

A successful local build does not prove:

- deployment;
- runtime health;
- production configuration;
- migration safety;
- external integration;
- operational readiness.

Build outputs relied upon for release should identify the source revision and applicable hash or immutable identity.

## 14. Deployment And Migration Verification

Exact procedures belong to runbooks and deployment owners.

### 14.1. Deployment proof

Verify applicable:

- environment preflight;
- artifact identity;
- configuration presence and validity;
- secret availability without disclosure;
- dependency readiness;
- maintenance or traffic state;
- service startup;
- cache or configuration compilation;
- queue and scheduler restart;
- health checks;
- operational smoke;
- monitoring and alert readiness;
- deployed revision;
- cleanup.

A deployment proof must identify:

- target environment;
- procedure;
- responsible executor;
- stop conditions;
- rollback or recovery trigger;
- retained evidence.

A successful build does not prove deployment.

### 14.2. Migration proof

Verify applicable:

- migration ordering;
- forward migration;
- schema prerequisites;
- data preservation;
- defaults and backfill;
- constraint enforcement;
- application compatibility during transition;
- lock duration;
- migration duration;
- restart or resume behavior;
- rollback where required and safe;
- post-migration validation.

Use PostgreSQL and representative data when migration semantics or duration matter.

Exact migration and rollback requirements remain with database standards and the applicable migration plan or runbook.

Do not treat a migration that runs against an empty database as proof of production-data safety.

### 14.3. Rollback and recovery readiness

When required, verify:

- rollback artifact or revision exists;
- procedure is executable;
- data compatibility is understood;
- migration rollback is safe or explicitly unavailable;
- backup and restore prerequisites are met;
- operator decision point is clear;
- post-rollback health can be checked.

“Rollback ready” is not established by documentation alone when an executable rehearsal is required.

## 15. Health, Monitoring, Alerting, And Operational Smoke

### 15.1. Health proof

Verify accepted health signals for applicable:

- application;
- database;
- cache;
- queue;
- scheduler;
- realtime service;
- object storage;
- external integration;
- migration state;
- worker state;
- backup state.

Health proof should verify both:

- healthy state;
- accepted unhealthy or degraded state.

Health responses must not expose secrets, credentials, internal stack traces, raw SQL, or restricted personal data.

### 15.2. Monitoring and logging proof

Verify applicable:

- expected metric;
- structured log;
- trace;
- correlation;
- dashboard or query availability;
- failed-job visibility;
- error classification;
- sensitive-data redaction;
- retention or sampling behavior defined by the owner.

Testing does not select monitoring policy.

### 15.3. Alert-routing proof

When alerting is required, verify:

- triggering condition;
- alert content;
- severity;
- routing destination;
- deduplication;
- recovery or resolved notification;
- secret-safe content;
- evidence of delivery.

Do not send disruptive test alerts to production responders without explicit approval.

### 15.4. Operational smoke

Operational smoke is a small, non-destructive proof that a deployed environment is stable enough for operation or deeper verification.

Verify applicable:

- deployed revision;
- application boot;
- critical public or authenticated entry point;
- database connectivity;
- migration state;
- asset availability;
- queue and scheduler reachability;
- health endpoint;
- monitoring pipeline;
- one bounded representative workflow.

Operational smoke does not prove:

- complete feature behavior;
- full security;
- full performance;
- recovery;
- release acceptance by itself.

Smoke behavior and procedure must be owned by the applicable runbook or deployment plan.

## 16. Production-Safe Verification

Production verification requires explicit authority before execution.

It must be:

- non-destructive;
- bounded;
- low risk;
- rate limited;
- reversible where applicable;
- observable;
- secret safe;
- data safe;
- tenant or scope safe;
- cleanup safe;
- documented by a runbook;
- attributable to a named executor and revision.

Declare:

- exact production surface;
- actor or synthetic identity;
- permitted reads or writes;
- expected data created;
- cleanup;
- rate and duration;
- monitoring;
- stop conditions;
- rollback or recovery action;
- reviewer authority.

Do not run in production without separately accepted authority:

- load testing;
- stress testing;
- spike testing;
- endurance testing;
- broad capacity testing;
- destructive migration testing;
- destructive recovery testing;
- uncontrolled fault injection;
- penetration testing;
- broad exploratory testing;
- tests using real customer data outside accepted procedures.

A test that is safe in staging is not automatically safe in production.

## 17. Evidence And Reporting

Material proofs should retain applicable:

- proof ID;
- criterion IDs;
- requirement and owner;
- command or procedure;
- operating system;
- runtime versions;
- working directory;
- source revision;
- environment identity;
- database version;
- workload;
- data volume;
- concurrency;
- duration;
- start and end time;
- threshold or matrix;
- applicability;
- execution status;
- verification result;
- exit code;
- raw report;
- summarized metrics;
- logs, traces, screenshots, or plans;
- output or report hash;
- cleanup result;
- limitations;
- reviewer.

Performance evidence should retain raw machine-readable output when material.

Concurrency evidence should retain enough ordering and synchronization detail to prove overlap.

Operational evidence must not contain secrets or restricted production data.

A summary without the underlying material report is insufficient when the proof depends on detailed measurements.

## 18. Failure Classification

Use the accepted verification-state model.

### `BLOCKED`

Use when a known prerequisite prevents execution from beginning.

Examples:

- required native environment is unavailable;
- performance environment has not been provisioned;
- supported matrix decision is unresolved;
- runbook is missing;
- required production authorization is absent;
- specialist reviewer is unavailable.

### `EXECUTED + FAIL`

Use when execution begins and:

- application or tool fails to start;
- environment differs materially from the declaration;
- workload is not generated correctly;
- intended concurrency does not occur;
- threshold is not met;
- safe state is not established;
- report capture fails;
- cleanup compromises evidence;
- compatibility combination fails;
- deployment or migration step fails;
- health or alert proof fails;
- unexpected result occurs.

Do not use `EXPECTED_NONPASS` for:

- environment failure;
- syntax error;
- dependency failure;
- fixture failure;
- discovery failure;
- tool crash;
- unrelated timeout;
- missing report;
- malformed evidence;
- an unresolved target threshold;
- unavailable production authority.

An expected preimplementation reliability or operational proof may use `EXPECTED_NONPASS` only for the exact predeclared missing behavior after valid execution.

## 19. Prohibited Patterns

Do not:

- let tests choose retry, timeout, idempotency, transaction, or recovery policy;
- assert only an error response without safe-state evidence;
- call sequential repetition concurrency testing;
- rely on arbitrary sleeps to create races;
- use one connection or wrapping transaction to prove cross-process visibility;
- mock the boundary claimed by the proof;
- use a fake queue to prove worker execution;
- use a local retry loop to prove broker redelivery;
- infer idempotency from one successful execution;
- hide duplicate side effects;
- use real waiting when a controlled clock is sufficient;
- retry a flaky test until it passes;
- compare performance runs from materially different environments without qualification;
- claim acceptance from average latency alone;
- use tiny fixtures to prove database scalability;
- invent a performance threshold from a current baseline;
- expand the supported compatibility matrix through testing;
- claim the full matrix from one representative combination;
- treat build success as deployment proof;
- treat empty-database migration success as production-data proof;
- claim backup readiness without restore proof when restore is required;
- expose secrets or internal details through health or evidence output;
- send disruptive alerts without approval;
- run uncontrolled load, fault, recovery, migration, or exploratory tests in production;
- classify invalid environment or evidence as `EXPECTED_NONPASS`;
- claim operational readiness without the required runbook or authority.

## 20. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Database Standards Index](../database/index.md)
- [Security Standards Index](../security/index.md)
- [Deployment Environment And Infrastructure Security Standards](../security/Deployment%20Environment%20And%20Infrastructure%20Security%20Standards.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Flow Documentation Index](../../05-flows/index.md)
- [Runbook Index](../../10-runbooks/index.md)
