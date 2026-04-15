# Security Standards

This document defines the canonical scope and intent for Security Standards.

## Purpose

Document security expectations for application changes.

## Standards

- Do not hardcode secrets in application code.
- Validate and sanitize external input server-side.
- Escape output in views.
- Enforce permissions in controllers, not only in the UI.
- Avoid raw editable HTML for normal website content editing.
- Treat file paths and website sync paths as high-risk input.

## Related

- [Tenant Safety Standards](Tenant%20Safety%20Standards.md)
- [Legacy V1 Perfex Module Development Standards](../../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md)
