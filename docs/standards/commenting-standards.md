# Commenting Standards

## Source

This standard is the project-level implementation of the research captured in [[../planning/app-2-commenting-standards|App 2 Commenting Standards Research]] | [App 2 Commenting Standards Research](../planning/app-2-commenting-standards.md).

## Core Rule

Write code so names, types, and structure explain the normal path. Use comments only when the code cannot clearly communicate intent, constraints, contracts, or non-obvious rationale.

If a line feels like it needs a comment, first consider whether a clearer method name, variable name, value object, enum, form request, service extraction, or test name would remove the need.

## Good Comments Explain

Use comments when the reader needs context that is not obvious from the code:

* why a security, tenancy, or permission boundary is enforced in a specific way
* why an implementation intentionally differs from a Laravel default
* why an operation is fail-open or fail-closed
* why logging intentionally captures or omits a field
* why retry, idempotency, locking, caching, or queue behavior has a specific constraint
* why a temporary compatibility path exists
* what contract a public service method expects when types alone are not enough

## Avoid Comment Noise

Do not add comments that only repeat code:

```php
// Get the user.
$user = Auth::user();
```

Do not leave commented-out examples, starter code, old implementations, or unused imports in place. Git history owns removed code.

Do not add author, creation date, last modified, or changelog comments to source files. Git owns authorship and change history.

## File Headers

Do not add broad file headers by default.

File-level comments are allowed only when they orient the reader to a file-wide boundary that is not obvious from the namespace and class name. If licensing headers are needed later, prefer short SPDX identifiers over long boilerplate.

## PHPDoc

Use PHPDoc when it improves the public contract or static analysis.

Good PHPDoc examples:

```php
/**
 * @param array<string, mixed> $metadata
 */
public function recordEvent(string $event, array $metadata = []): void
```

```php
/**
 * @return array<string, string>
 */
protected function casts(): array
```

Avoid PHPDoc that only repeats a method name, typed parameter, or return type:

```php
/**
 * Register any application services.
 */
public function register(): void
```

## Inline And Block Comments

Use inline comments sparingly. Prefer a short block comment above the affected block when the explanation applies to multiple lines.

Inline comments are acceptable for short, local rationale:

```php
// Keep audit logging fail-safe so auth flows are not blocked by telemetry outages.
```

Avoid end-of-line comments unless the comment is brief and clearly improves a dense line. If a line needs a long end-of-line comment, split the code or extract a named value.

## TODO And FIXME

Use TODO only when there is durable context and a clear removal path.

Preferred format:

```php
// TODO: https://github.com/parasolutions/login-app-v2/issues/123 - Remove fallback after tenant resolver rollout.
```

Until a public/private issue tracker exists, use a docs link or decision link:

```php
// TODO: docs/decisions/ADR-0001-platform-foundation.md - Replace temporary bootstrap after Filament panel is introduced.
```

Avoid person-only TODOs:

```php
// TODO: Kyle fix this.
```

Do not use FIXME as a separate severity system for now. Use an issue-linked TODO and track severity in the issue or planning document.

## Tests

Prefer descriptive test method names over comments.

Comment tests only when setup is intentionally strange, protects a regression, or documents a non-obvious data boundary. Do not comment the basic arrange, act, assert flow.

## Config And Docs

Configuration comments should be short and close to the setting only when they clarify constraints. Long explanations belong in `docs/`.

JSON does not support comments; use adjacent Markdown documentation for JSON-based configuration.

## Maintenance Rule

When code changes, update or delete any related comments in the same change. A stale comment is worse than no comment.

## Review Checklist

Before merging code, check:

* could the comment be replaced with clearer code?
* does the comment explain why, not just what?
* is the comment still true after the change?
* does any TODO link to durable context?
* did we leave commented-out code behind?
* are PHPDoc blocks adding useful contract/static-analysis value?

## Related Links

* [[coding-standards|Coding Standards]] | [Coding Standards](coding-standards.md)
* [[file-building-standards|File Building Standards]] | [File Building Standards](file-building-standards.md)
* [[../planning/app-2-commenting-standards|App 2 Commenting Standards Research]] | [App 2 Commenting Standards Research](../planning/app-2-commenting-standards.md)
