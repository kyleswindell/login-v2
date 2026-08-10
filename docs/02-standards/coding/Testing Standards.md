<!--
DOC-META
title: Testing Standards
doc_type: standard
status: superseded
owner: docs
canonical: false
canonical_path: docs/02-standards/coding/Testing Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Superseded compatibility route to the canonical Testing Standards suite and Test Implementation Standards.
-->

# Testing Standards

Parent: [Coding Standards Index](index.md)

This document is superseded and remains only as a compatibility route for existing references.

## Canonical Testing And Verification Standards

Use the [Testing Standards Index](../testing/index.md) for canonical rules governing:

- testing and verification terminology;
- `AC-*` acceptance criteria and `PF-*` proofs;
- proof selection and test levels;
- applicability, execution status, and verification results;
- initial proof and `EXPECTED_NONPASS`;
- protected verification baselines;
- environments, data, fixtures, and PostgreSQL requirements;
- integration, system, acceptance, reliability, performance, compatibility, operational, UI, accessibility, and browser proof;
- verification evidence, reporting, and delivery gates.

Do not add new testing or verification policy to this file.

## Test Source Implementation Standards

Use [Test Implementation Standards](Test%20Implementation%20Standards.md) for repository-specific coding rules governing:

- PHPUnit and Laravel test source;
- Playwright browser test source;
- test placement and ownership;
- setup and teardown;
- factories, scenario builders, seeders, and fixtures as implementation;
- framework fakes and test doubles as source code;
- datasets and assertion helpers;
- runner discovery and generated test completion;
- protected test-source handling.

## Related

- [Testing Standards Index](../testing/index.md)
- [Test Implementation Standards](Test%20Implementation%20Standards.md)
- [Coding Standards Index](index.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
