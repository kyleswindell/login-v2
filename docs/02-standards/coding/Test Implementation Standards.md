<!--
DOC-META
title: Test Implementation Standards
doc_type: standard
status: superseded
owner: docs
canonical: false
canonical_path: docs/02-standards/coding/Test Implementation Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Superseded compatibility route to the canonical Test Implementation Standards family.
-->

# Test Implementation Standards

Parent: [Coding Standards Index](index.md)

This document is superseded and remains only as a compatibility route for existing references.

## Canonical Replacement

Use the [Test Implementation Standards Index](test-implementation/index.md) for repository-specific rules governing how test source is placed, written, organized, and maintained.

The replacement family separates test-source responsibilities into focused standards for:

- [source and placement](test-implementation/test-source-and-placement-standards.md);
- [Laravel and database test implementation](test-implementation/laravel-and-database-test-implementation-standards.md);
- [fixtures, doubles, and asynchronous test implementation](test-implementation/fixtures-doubles-and-async-test-implementation-standards.md);
- [browser test implementation](test-implementation/browser-test-implementation-standards.md);
- [test-source lifecycle](test-implementation/test-source-lifecycle-standards.md).

Do not add new test-source policy to this compatibility file.

## Testing And Verification Policy

Test-source implementation is separate from proof policy.

Use the [Testing Standards Index](../testing/index.md) for canonical rules governing proof design, `AC-*` and `PF-*`, test levels, environments, result classification, protected baselines, evidence, and testing gates.

## Related

- [Test Implementation Standards Index](test-implementation/index.md)
- [Testing Standards Index](../testing/index.md)
- [Coding Standards Index](index.md)
