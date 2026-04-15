# File Building Standards

This document defines the canonical scope and intent for File Building Standards.

## Application Structure

Use framework defaults unless the project has a reason to create a clearer platform boundary.

Current V2 namespace direction:

* `app/Platform/Logging`
* `app/Platform/Tenancy`
* `app/Platform/Provisioning`
* `app/Platform/Audit`

## Controllers

Controllers should coordinate requests and responses. Move reusable business rules into services.

Keep controller comments rare. If a controller action needs a long explanation, move the behavior into a named service or form request and document that contract there.

## Requests

Use form requests for validation that is likely to grow or be reused.

Use request classes to encode validation intent that might otherwise turn into comment-heavy controller code.

## Views

Use Blade views for foundation pages until Filament panels are introduced.

Keep Blade comments for section-level intent only. Do not leave commented-out markup or alternate implementations in templates.

## Tests

Feature tests should cover user-visible behavior and database effects. Unit tests should cover isolated service logic when useful.

Prefer explicit test names over explanatory comments. Comment only unusual fixtures, regressions, or safety boundaries.

## Related

* [Coding Standards](Coding%20Standards.md)
* [Commenting Standards](Commenting%20Standards.md)
* [Standards Index](../index.md)
