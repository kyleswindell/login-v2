# Security Standards

This document defines the canonical scope and intent for Security Standards.

## Purpose

Document security expectations for application changes.

## Standards

- Do not hardcode secrets in application code.
- Authentication, external identity, MFA assurance, account linking, and production credential handling must follow [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md).
- Session, transport, proxy, and browser hardening must follow [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md).
- Repository security verification and release-gate expectations must follow [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md).
- Validate and sanitize external input server-side.
- Escape output in views.
- Enforce permissions in controllers, not only in the UI.
- Avoid raw editable HTML for normal website content editing.
- Treat file paths and website sync paths as high-risk input.

## Related

- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Tenant Safety Standards](Tenant%20Safety%20Standards.md)
- [Legacy V1 Perfex Module Development Standards](../../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md)
