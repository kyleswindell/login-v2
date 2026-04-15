# Account Password Change Flow

This document defines the canonical scope and intent for Account Password Change Flow.

## Purpose

Define the ordered execution path for an authenticated user changing their own account password.

## Inputs

* current password
* new password
* password confirmation

## Flow

1. Authenticated user opens `/account/settings`.
2. User enters current password, new password, and confirmation.
3. System validates current-password correctness.
4. System validates password policy and confirmation match.
5. On validation failure, system keeps the user on the account settings page and shows inline errors.
6. On success, system updates the current authenticated user's password.
7. System records the security-sensitive change in the audit trail.
8. System returns success feedback on the account settings surface.

## Outputs

* updated password hash for the authenticated user
* audit event for successful password change
* validation errors on failure

## Related

* [Account Management And Settings](../04-features/account/account-management-and-settings.md)
* [Authentication](../04-features/auth/authentication.md)
