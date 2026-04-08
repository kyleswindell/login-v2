# Coding Standards

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

## Related Links

* [[commenting-standards|Commenting Standards]] | [Commenting Standards](commenting-standards.md)
* [[file-building-standards|File Building Standards]] | [File Building Standards](file-building-standards.md)
* [[logging-standards|Logging Standards]] | [Logging Standards](logging-standards.md)
