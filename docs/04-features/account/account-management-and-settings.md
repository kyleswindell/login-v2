# Account Management And Settings

This document defines the canonical scope and intent for Account Management And Settings.

## Purpose

Define the canonical ownership, behavior contracts, and security expectations for authenticated user account surfaces and user-scoped settings.

This note is the canonical system owner for account menu IA, My Account, Account Settings, and Preferences behavior.

## Implementation Status

Current status:

* implemented in code
* `/account`, `/account/settings`, and `/account/preferences` are registered authenticated routes
* current-user profile, password update, and preferences flows are implemented in the app shell
* account phone entry now uses the shared internal phone-input baseline, so plain ten-digit input is normalized to the canonical `(555) 555-5555` format on save and on the live form surface
* account surfaces remain custom Blade ownership in the Phase 2 close-out model

Planning source:

* [Phase 2 - Implementation Batch 8](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%208.md)

## Owned Surfaces

* header account dropdown
* `/account` (My Account)
* `/account/settings` (Account Settings)
* `/account/preferences` (Preferences)

## Ownership Contract

Account surfaces own user-scoped configuration and identity actions.

Platform settings surfaces own platform-global configuration.

Field and setting ownership must stay explicit:

* account-owned: user profile fields, user preference fields, account security controls
* platform-owned: organization-wide defaults and operational settings
* duplicate ownership across account and platform settings is not allowed

## Route And Authorization Contract

* account routes are authenticated-user routes
* account routes are context-safe for the current signed-in user
* route access and update actions must always target the current authenticated user scope
* direct account actions must not require platform-admin-only permissions when ownership is personal

## Security Contract

Account Settings security section must include:

* current-password validation before password update
* password confirmation and policy validation
* audit logging for successful security-sensitive changes
* no plaintext credential storage or debug rendering

## UI And Navigation Contract

* account dropdown labels are account-focused and avoid workspace-link duplication
* active-state highlighting is singular and route-accurate
* account pages follow the active shell baseline and shared form/table conventions

## Verification Contract

Verification should confirm:

* account route registration and auth protection
* active-state correctness across account pages
* password update validation path and failure path behavior
* responsive dropdown and form behavior
* staging visual QA sign-off for final account IA polish

## Related

* [Features Index](../index.md)
* [Final Stack And UI Boundary](../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [Auth Architecture](../../03-architecture/auth.md)
* [Auth And RBAC Data Contract](../../06-database/feature-contracts/auth-and-rbac.md)
* [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
* [Account Password Change Flow](../../05-flows/account-password-change-flow.md)
