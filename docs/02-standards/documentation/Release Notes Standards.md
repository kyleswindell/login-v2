# Release Notes Standards

This document defines the canonical scope and intent for Release Notes Standards.

## Purpose

Document how patch notes, changelog entries, and narrative release notes should be handled.

## Standards

- Use a future repo-root `CHANGELOG.md` as the curated human-readable list of notable changes.
- Keep the latest changes first.
- Keep an `Unreleased` section at the top when a changelog is created.
- Group changes by type, such as Added, Changed, Fixed, Removed, Security, and Deprecated.
- Do not dump raw git commit logs into release notes.
- Use `Releases/` for longer notes that include migrations, screenshots, rollout cautions, or operational impact.
- Link release notes to ADRs when a release includes architectural changes.

## Related

- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [App 2.0 Docs Start Here](../../00-start-here.md)
