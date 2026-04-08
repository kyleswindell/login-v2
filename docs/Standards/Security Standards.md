# Security Standards

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

- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](Tenant%20Safety%20Standards.md)
- [[Standards/Module Development Standards]] | [Module Development Standards](Module%20Development%20Standards.md)

