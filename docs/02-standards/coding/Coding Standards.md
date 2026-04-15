# Coding Standards

This document defines the canonical scope and intent for Coding Standards.

## Defaults

* Prefer small, focused classes.
* Keep controller methods thin.
* Put reusable application behavior in services under `app/Platform/`.
* Use Laravel form requests for non-trivial validation.
* Use migrations for database changes.
* Add tests for behavior that affects auth, tenancy, logging, provisioning, or data boundaries.
* Prefer expressive naming and extraction over explanatory comments.
* Add PHPDoc when it materially improves public contracts or static analysis.

## Naming

* Use explicit event names like `auth.login_succeeded`.
* Use descriptive service names like `PlatformLogger`.
* Keep tenant/platform concepts explicit in names until the domain model is mature.

## Related

* [Commenting Standards](Commenting%20Standards.md)
* [File Building Standards](File%20Building%20Standards.md)
* [Logging Standards](../logging/Logging%20Standards.md)
* [Standards Index](../index.md)
