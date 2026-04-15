# Phase 1 - Foundation Data Direction

This document defines the canonical scope and intent for Phase 1 - Foundation Data Direction.

## Purpose

Capture Phase 1 sequencing-level data direction for the foundation baseline.

## Implementation Status

- Phase 1 complete and signed off (2026-04-10)
- baseline table families are implemented in the platform database
- this note remains planning history tied to canonical database contracts

## Phase 1 Data Baseline Direction

- auth and RBAC baseline tables
- platform audit and error logging tables
- notifications and settings baseline tables
- queue/job support tables

## Data Modeling Direction

- keep auth-support tables close to framework/package defaults
- keep RBAC package-backed rather than custom pivots
- use explicit relational keys before flexible metadata fields
- reserve `jsonb` for metadata/extension fields rather than primary relational modeling

## Data Ownership Direction

- platform baseline tables are central-platform owned
- tenant runtime data remains tenant-database owned

## Canonical References

- [Database Index](../../../06-database/index.md)
- [Auth And RBAC](../../../06-database/feature-contracts/auth-and-rbac.md)
- [Logging Contract](../../../06-database/feature-contracts/logging.md)

## Related

- [Phase 1 Index](Phase%201%20Index.md)
- [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
