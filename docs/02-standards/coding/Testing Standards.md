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
summary: Superseded compatibility route to the canonical Testing Standards suite and Test Implementation Standards family.
-->

# Testing Standards

Parent: [Coding Standards Index](index.md)

This document is superseded and remains only as a compatibility route for existing references.

## Testing And Verification Policy

Use the [Testing Standards Index](../testing/index.md) for canonical rules governing:

- testing and verification terminology;
- `AC-*` acceptance criteria and `PF-*` proofs;
- proof selection and test levels;
- applicability, execution status, and verification results;
- initial proof and `EXPECTED_NONPASS`;
- protected verification baselines;
- environments, data, fixtures, and PostgreSQL requirements;
- integration, system, acceptance, reliability, performance, compatibility, operational, UI, accessibility, and browser proof;
- verification evidence, reporting, and testing gates.

Do not add new testing or verification policy to this file.

## Test Source Implementation

Use the [Test Implementation Standards Index](test-implementation/index.md) for repository-specific coding rules governing test-source placement, PHPUnit and Laravel source, fixtures and doubles, asynchronous test code, Playwright source, discovery, generated tests, and protected test-source handling.

## Related

- [Testing Standards Index](../testing/index.md)
- [Test Implementation Standards Index](test-implementation/index.md)
- [Coding Standards Index](index.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
