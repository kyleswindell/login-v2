# Account Management And Settings

## Purpose

Define the canonical ownership, behavior contracts, and security expectations for authenticated user account surfaces and user-scoped settings.

This note is the canonical system owner for account menu IA, My Account, Account Settings, and Preferences behavior.

## Implementation Status

Current status:

* contract defined
* Batch 8 implementation blocked until Batch 7 final staging visual sign-off is approved

Planning source:

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 8]] | [Phase 2 - Implementation Batch 8](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%208.md)

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

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 8]] | [Phase 2 - Implementation Batch 8](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%208.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
