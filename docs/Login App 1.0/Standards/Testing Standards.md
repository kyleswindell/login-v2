# Testing Standards

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

- [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](../V1%20App/Runbooks/Runbook%20Index.md)
- [[V1 App/Runbooks/Upgrade Review Checklist]] | [Upgrade Review Checklist](../V1%20App/Runbooks/Upgrade%20Review%20Checklist.md)
