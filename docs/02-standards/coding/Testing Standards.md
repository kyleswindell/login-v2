# Testing Standards

This document defines the canonical scope and intent for Testing Standards.

## Purpose

Document testing expectations.

## Current State

This repo does not currently appear to have a formal automated test suite for critical flows.

## Standards

- For now, document manual verification steps in feature docs and runbooks.
- Prefer adding automated tests for critical flows when a test framework is introduced.
- Verify tenant-aware features in both admin-host and tenant-host contexts.
- Verify permission failures, not only successful admin flows.
- After Perfex upgrades, specifically re-test tenant provisioning, tenant DB routing, module allowlists, core feature allowlists, tenant staff management, and Events website sync.

## Related

- [Runbook Index](../../10-runbooks/index.md)
- [Platform Boundary](../../03-architecture/platform-boundary.md)
