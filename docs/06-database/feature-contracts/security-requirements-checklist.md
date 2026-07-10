# Security Requirements Checklist Data Contract

This document defines the canonical scope and intent for Security Requirements Checklist Data Contract.

## Purpose

Define the database contract for the platform security requirements checklist and ASVS readiness tracker.

## Tables

### `security_requirement_groups`

Owns grouped security control areas.

Columns:

- `id`
- `slug`, unique stable key
- `title`
- `summary`
- `asvs_family`, nullable ASVS family or family group
- `risk_level`, such as `level_2` or `level_3_overlay`
- `sort_order`
- timestamps

### `security_requirements`

Owns one grouped checklist requirement.

Columns:

- `id`
- `group_id`, foreign key to `security_requirement_groups`
- `slug`, unique stable key
- `title`
- `summary`
- `asvs_refs`, JSON list of version-qualified ASVS references or ASVS family references
- `canonical_docs`, JSON list of safe labels and canonical doc paths
- `alignment_status`
- `work_status`
- `priority`
- `owner_user_id`, nullable foreign key to users
- `target_phase`
- `evidence_links`, JSON list of safe labels and URLs or app paths
- `notes`
- `last_reviewed_at`
- `last_reviewed_by`, nullable foreign key to users
- timestamps

## Status Values

Alignment statuses:

- `aligned`
- `partial`
- `lacking`
- `not_applicable`
- `accepted_risk`

Work statuses:

- `not_started`
- `planned`
- `in_progress`
- `implemented_pending_review`
- `validated`
- `deferred`

## Constraints

- Requirement groups are seeded and matched by `slug`.
- Requirements are seeded and matched by `slug`.
- Repeat seed runs may update catalog-owned title, summary, ASVS refs, canonical docs, priority, group membership, and group metadata.
- Repeat seed runs must not overwrite manually managed alignment status, work status, owner, target phase, evidence links, notes, or review metadata for existing requirements.
- Evidence links must store structured label and URL/path values only.
- Evidence link URLs must be constrained to `http://` or `https://` URLs, app-relative `/...` paths that are not protocol-relative, and canonical `docs/...` paths.
- Raw HTML, credentials, secrets, tokens, MFA codes, and sensitive payloads must not be stored in evidence links or audit metadata.

## Related

- [Security Requirements Checklist](../../04-features/security/security-requirements-checklist.md)
- [Security Requirements Checklist Flow](../../05-flows/security-requirements-checklist-flow.md)
- [OWASP ASVS Level 2 Baseline](../../02-standards/security/OWASP%20ASVS%20Level%202%20Baseline.md)
