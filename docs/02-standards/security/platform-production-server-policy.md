# Platform Production Server Policy

This document defines the canonical scope and intent for Platform Production Server Policy.

## Purpose

Canonical policy for production server usage boundaries and source-of-truth controls.

## Policy

- The `platform-prod` SSH host is for verification, diagnostics, and approved deployment preparation tasks.
- Production server state must not become the sole source of truth for application code.
- Application code changes must be committed to the repository before deployment.
- Production must not run with local-development debug posture, placeholder credentials, or ad hoc untracked configuration as its steady-state security model.
- Production credentials and third-party secrets must resolve from approved secret storage and rotation paths rather than from informal operator-managed values.
- Production deployment must verify transport, cookie, and environment hardening requirements before a release is treated as acceptable.

## Related

- [Deployment Runbook](../../10-runbooks/deployment.md)
- [Git Remote And Multi-Device Workflow](../../10-runbooks/git-remote-and-multi-device-workflow.md)
- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
