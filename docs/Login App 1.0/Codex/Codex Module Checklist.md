# Codex Module Checklist

## Purpose

Use this checklist when creating or modifying a Perfex module.

## Checklist

- Add or update module bootstrap.
- Register language files if the module has UI text.
- Register capabilities if the module has admin actions.
- Add idempotent install/migration logic.
- Add controller permission guards.
- Add server-side validation for writes.
- Add model methods for data access.
- Add views with escaped output.
- Add logging for operational failures and audit-worthy actions.
- Add documentation under `Modules/` and `Features/` when appropriate.

## Related

- [[Standards/Module Development Standards]] | [Module Development Standards](../Standards/Module%20Development%20Standards.md)

