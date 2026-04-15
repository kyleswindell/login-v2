# Phase 2 - Implementation Batch 8

## Status

Superseded.

This batch is replaced by [Phase 2 - Implementation Batch C](Phase%202%20-%20Implementation%20Batch%20C.md).

The remainder of this note is preserved only as the prior account-planning record.

This document defines the canonical scope and intent for Phase 2 - Implementation Batch 8.

## Purpose

Establish a proper user account menu and account-management surface under the header user dropdown.

## Implementation Status

Current status:

* drafted
* implementation-ready after hard gates are satisfied
* blocked until Batch 7 staging visual sign-off is explicitly approved

Planning owner:

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [Final Stack And UI Design Spec](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [Account Management And Settings](../../../04-features/account/account-management-and-settings.md)
* [UI Design System Standards](../../../02-standards/ui/UI Design System Standards.md)

## Entry Gates

Batch 8 implementation may start only when all of the following are true:

* Batch 7 final staging visual sign-off is explicitly approved and recorded
* account route ownership is synchronized with the current shell baseline and no duplicate account/settings ownership remains in platform-global settings
* this planning note and canonical owner note stay synchronized for implementation status and contract scope

## Batch Goal

Deliver a complete account-focused dropdown and account views so user identity/configuration actions are separated from platform administration settings.

## In Scope

* header account dropdown IA with account-focused options
* finalize and standardize:
  * My Account
  * Account Settings
  * Preferences
  * Sign out
* include password and security controls in Account Settings (current password validation + password update flow)
* move user-specific settings from platform-general settings into account scope where ownership is personal rather than global
* account route ownership, permissions, and navigation active-state parity checks
* visual and interaction parity with the finalized Batch 7 shell baseline

## Out Of Scope

* customer-facing account profile system
* tenant-facing account profile system
* broad IAM redesign
* cross-tenant messaging behavior

## Required Deliverables

1. Finalized account dropdown menu structure and labels.
2. My Account page complete with current-user profile summary/edit ownership.
3. Account Settings page complete with user-scoped editable settings.
4. Account Settings security section complete (password change flow and validation rules).
5. Preferences page complete with user-scoped display/default preferences.
6. Settings-owner matrix update showing which fields remain platform-global versus moved to account scope.
7. Documentation sync across planning/canonical/development notes.

## Verification

Verification focus:

* active-link state correctness across account pages
* no mixed highlight states in header or sidebar
* route + auth coverage for account endpoints
* security validation coverage for password update flow
* responsive behavior for dropdown and account forms
* staging visual QA

## Exit Criteria

This batch is complete when:

* account dropdown is account-focused and no longer workspace-link duplication
* My Account, Account Settings, and Preferences are implemented and reachable from header
* password and security controls are functional and validated in Account Settings
* user-scoped settings are no longer incorrectly owned by platform-global settings pages
* docs and implementation status are synchronized

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Implementation Batch 7](Phase%202%20-%20Implementation%20Batch%207.md)
* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Account Management And Settings](../../../04-features/account/account-management-and-settings.md)
