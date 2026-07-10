<!--
DOC-META
title: Query And Performance Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Query And Performance Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines query ownership, eager loading, bounded reads, pagination, chunking, PostgreSQL query review, caching, indexing, and performance verification requirements.
-->

# Query And Performance Standards

Parent: [Coding Standards Index](index.md)

This document defines query and performance standards for Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Query Ownership](#3-query-ownership)
- [4. Query Objects](#4-query-objects)
- [5. Scope](#5-scope)
- [6. Selected Columns](#6-selected-columns)
- [7. Eager Loading](#7-eager-loading)
- [8. N+1 Prevention](#8-n1-prevention)
- [9. Pagination](#9-pagination)
- [10. Ordering](#10-ordering)
- [11. Search And Filtering](#11-search-and-filtering)
- [12. Aggregation](#12-aggregation)
- [13. Chunking And Streaming](#13-chunking-and-streaming)
- [14. Exports](#14-exports)
- [15. PostgreSQL-Specific Review](#15-postgresql-specific-review)
- [16. Indexes](#16-indexes)
- [17. Explain Plans](#17-explain-plans)
- [18. Caching](#18-caching)
- [19. Cache Keys](#19-cache-keys)
- [20. Performance And Security](#20-performance-and-security)
- [21. Testing](#21-testing)
- [22. Stop Conditions](#22-stop-conditions)
- [23. Related](#23-related)

---

## 1. Purpose

Prevent unbounded reads, N+1 queries, hidden cross-scope access, memory-heavy processing, and premature caching.

---

## 2. Core Rule

Every important query must have:

- clear owner
- clear scope
- bounded result behavior
- intentional selected data
- known ordering
- expected indexes
- verification appropriate to its risk

Do not optimize without evidence, but do not ship obviously unbounded or repeated query behavior.

---

## 3. Query Ownership

Queries belong to the capability, surface, or module that owns the read behavior.

Examples:

- effective access query → Core Access
- audit search → Core Audit
- navigation contribution query → Platform Navigation
- customer order search → Orders or Customers module according to domain ownership

Do not centralize all queries in a generic shared repository.

---

## 4. Query Objects

Use query objects for reads that are:

- reused
- complex
- scoped
- filtered
- paginated
- security-sensitive
- performance-sensitive

A query object should represent one read intent.

---

## 5. Scope

Apply tenant, workspace, account, customer, module, or user scope in the database query.

Do not:

- query globally then filter in memory
- rely on UI context alone
- accept scope identifiers without authorization
- expose broad admin queries without explicit permission

Test cross-scope denial.

---

## 6. Selected Columns

Select only required columns when:

- tables are wide
- sensitive fields exist
- result count is large
- joins are expensive
- API/view contract is narrow

Do not fetch restricted or secret-bearing columns when the caller does not need them.

---

## 7. Eager Loading

Use eager loading to avoid N+1 queries.

Do not eager-load large relationship graphs by default.

Load only relationships required by the response or operation.

Use counts, existence queries, or aggregates instead of loading complete collections when only summary information is needed.

---

## 8. N+1 Prevention

Review loops that access model relationships.

High-risk surfaces:

- tables
- exports
- dashboards
- API resources
- notification lists
- audit viewers
- module lists

Tests or development tooling may be used to detect unexpected query growth when appropriate.

---

## 9. Pagination

Use pagination for operator-facing or API lists that may grow materially.

Choose:

- offset pagination for conventional page navigation
- cursor pagination for large ordered streams where appropriate
- bounded explicit limits for lookup lists
- no pagination only for intentionally small static datasets

Do not retrieve every row to implement client-side pagination for large data.

---

## 10. Ordering

Queries must define deterministic ordering when order matters.

Add a stable tie-breaker when the primary sort column is not unique.

Do not rely on database default row order.

---

## 11. Search And Filtering

Search should:

- remain scoped
- validate filter values
- avoid wildcard patterns that create unnecessary full scans
- use appropriate indexes or search strategy
- escape or bind values safely
- define behavior for empty search

Do not concatenate raw user input into SQL.

---

## 12. Aggregation

Use database aggregates for:

- counts
- sums
- averages
- grouped totals
- existence checks

Do not load complete record sets merely to count or sum them in PHP.

Exact financial behavior must follow numeric and rounding rules.

---

## 13. Chunking And Streaming

Use chunking, lazy iteration, cursors, or streaming for large operations.

Appropriate uses:

- backfills
- exports
- notifications
- synchronization
- retention cleanup
- reporting

Ensure chunking order is stable.

Do not mutate the ordering key in a way that skips or repeats records.

---

## 14. Exports

Exports must:

- remain permission-gated
- enforce scope
- select only approved fields
- use bounded or streamed processing
- avoid memory-heavy full-table loads
- record audit information
- follow DataProtection and DLP rules

View permission does not automatically imply export permission.

---

## 15. PostgreSQL-Specific Review

PostgreSQL-dependent behavior should be tested against PostgreSQL.

Review:

- JSONB queries
- indexes
- constraints
- transaction behavior
- locks
- case sensitivity
- timestamp behavior
- query plans for important paths

Do not treat SQLite results as proof of PostgreSQL behavior.

---

## 16. Indexes

Queries and indexes should be designed together.

An important query should identify:

- filtering columns
- scope columns
- ordering columns
- join columns
- uniqueness expectations
- expected row count

Do not add speculative indexes without an identified access path.

Do not omit indexes for required foreign-key and scoped lookup patterns.

---

## 17. Explain Plans

Use PostgreSQL query-plan review for important or slow paths when needed.

Review plans in a safe environment.

Do not run expensive `EXPLAIN ANALYZE` operations against production tables without operational approval.

Document meaningful query-plan findings when they affect schema or architecture.

---

## 18. Caching

Cache only when:

- the query is measurably expensive
- the result can tolerate staleness
- cache scope is explicit
- invalidation is defined
- sensitive data is protected
- failure behavior is understood

Do not use caching to hide an unbounded or poorly indexed query.

Do not cache authorization decisions beyond their safe lifecycle without an explicit design.

---

## 19. Cache Keys

Cache keys should include required scope and version context.

Potential components:

- capability/module
- tenant/workspace/account
- target
- filter
- locale
- version

Do not allow cache keys to collide across scopes.

---

## 20. Performance And Security

Performance optimizations must not weaken:

- authorization
- scope
- data classification
- redaction
- audit
- consistency
- lifecycle rules

Do not bypass policies by using a faster global query.

---

## 21. Testing

Test:

- scope
- filters
- ordering
- pagination
- empty results
- aggregate correctness
- duplicate/tie ordering
- cross-scope denial
- PostgreSQL-dependent behavior
- bounded processing for large operations
- cache scope and invalidation where material

Performance-sensitive behavior may require representative local data or query-plan review.

---

## 22. Stop Conditions

Stop before shipping a query when:

- scope is missing
- result count is unbounded
- a list loads unnecessary restricted fields
- ordering is nondeterministic
- N+1 behavior is likely
- a large operation loads everything into memory
- caching has no invalidation strategy
- PostgreSQL-specific behavior was tested only with SQLite
- required indexes are unknown

---

## 23. Related

- [File Archetypes](File%20Archetypes.md)
- [Testing Standards](Testing%20Standards.md)
- [Schema Design Standards](../database/Schema%20Design%20Standards.md)
- [Database Tenant Workspace Isolation Standards](../database/Database%20Tenant%20Workspace%20Isolation%20Standards.md)
- [Coding Standards Index](index.md)