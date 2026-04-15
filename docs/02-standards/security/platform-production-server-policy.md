# Platform Production Server Policy

This document defines the canonical scope and intent for Platform Production Server Policy.

## Purpose

Canonical policy for production server usage boundaries and source-of-truth controls.

## Policy

- The `platform-prod` SSH host is for verification, diagnostics, and approved deployment preparation tasks.
- Production server state must not become the sole source of truth for application code.
- Application code changes must be committed to the repository before deployment.

## Related

- [Deployment Runbook](../../10-runbooks/deployment.md)
- [Git Remote And Multi-Device Workflow](../../10-runbooks/git-remote-and-multi-device-workflow.md)
