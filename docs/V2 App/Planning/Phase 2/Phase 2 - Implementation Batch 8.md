# Phase 2 - Implementation Batch 8

## Purpose

Establish a proper user account menu and account-management surface under the header user dropdown.

## Implementation Status

Current status:

* drafted
* planned after Batch 7 visual sign-off

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)

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

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 7]] | [Phase 2 - Implementation Batch 7](Phase%202%20-%20Implementation%20Batch%207.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
