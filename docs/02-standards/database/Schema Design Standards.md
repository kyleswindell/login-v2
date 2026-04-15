# Schema Design Standards

This document defines the canonical scope and intent for Schema Design Standards.

## Purpose

Define canonical cross-module schema design rules.

## Standards

- use plural snake_case table names without Perfex `tbl` prefixes
- prefer explicit foreign keys and join tables over soft relationship columns
- use `jsonb` only for metadata or extension points, not core relational structure
- keep central platform operational tables separate from tenant business tables
- define indexes around tenant-local lookup patterns, status filters, and date-range queries early

## Core Module Schema Rules

- use explicit foreign keys for customer ownership and finance allocations
- do not use polymorphic line-item shortcuts for finance records
- do not use soft relationship patterns where stable foreign keys are required

## Related

- [Database Migration Standards](Database Migration Standards.md)
- [Phase 4 PostgreSQL Schema Direction](../../06-database/phase-4-postgresql-schema-direction.md)
