# Phase 3 - Microsoft Graph Email Sending Planning

## Purpose

Define the Phase 3 implementation plan for Microsoft Graph email sending as the shared outbound email foundation before broad Phase 4 module rollout.

This note covers setup procedures, sender-account ownership boundaries, feature-level sender alias mapping, notice preference policy, mandatory notice classes, and initial use cases.

## Implementation Status

Current status:

* planning drafted
* no Microsoft Graph mail implementation started yet
* no GUI account/alias management has been implemented yet

Parent planning note:

* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## Why This Is In Phase 3

Graph email must be available before broad module rollout so module teams do not invent one-off outbound mail behavior.

Phase 3 should establish the shared contract for:

* account verification emails
* new notification digests and alerts
* periodic reports
* automated finance notices (invoice send, reminder, overdue)
* estimate and quote updates
* support ticket updates
* project and task due-date reminders and past-due alerts

## Microsoft Graph Implementation Procedure (Planning Baseline)

1. Register an application in Microsoft Entra ID.
2. Configure least-privilege Graph permissions for mail sending.
3. Choose and document access modes:
   * app-only sending for automated platform and module jobs
   * delegated sending only where interactive user-initiated send requires user context
4. Configure sender mailboxes in Exchange Online (licensed user mailbox or shared mailbox model).
5. Store credentials securely (certificate or secret via secure secret storage), never in plain settings values.
6. Implement a queue-backed outbound mail service with retry and dead-letter handling.
7. Handle Graph throttling using `429` and `Retry-After` behavior with exponential backoff fallback.
8. Implement provider-level delivery telemetry and message audit links.

## Operational Constraints To Design Around

Based on Microsoft Graph and Exchange Online guidance:

* `sendMail` success returns `202 Accepted`; this means accepted for processing, not guaranteed recipient delivery
* transport and policy evaluation happen after API response
* Graph and Exchange throttling must be expected and retried safely
* sending limits apply at mailbox and tenant scope (for example recipient/day and message/minute limits)
* mailbox quota or policy failures can still cause later NDRs after initial API acceptance

## Account And Alias Ownership Model

### Platform-owned defaults

Platform instance must support GUI management for:

* one or more default sender accounts
* one or more aliases per sender account
* fallback sender policy when feature-specific alias mapping is missing

### Tenant-owned overrides

Tenant instance must support GUI management for:

* optional tenant-specific sending accounts and aliases
* domain-verified sender identity where tenant elects custom domain mailboxes
* tenant override policy: use tenant sender first, else platform default

### Sender resolution order

1. module feature sender alias override
2. tenant default sender alias/account
3. platform default sender alias/account
4. platform global fallback account

## Feature-Based Sender Alias Routing

Phase 3 contract should include sender alias routing keys such as:

* `auth_verification` -> `accounts@...`
* `system_notifications` -> `notifications@...`
* `finance_invoices` -> `finance@...`
* `finance_overdue` -> `finance@...`
* `support_updates` -> `support@...`
* `events_updates` -> `events@...`
* `reports_periodic` -> `reports@...`

Routing keys should be data-driven and configurable in setup UI, not hardcoded.

## Notice Classes And User Preference Policy

### Optional notice classes (user can opt in/out)

* event updates and participation notices
* non-critical system notification digests
* periodic report subscriptions
* project/task reminder classes where business policy allows opt-out

### Mandatory notice classes (cannot be opted out)

* account creation verification and security-critical authentication notices
* manually triggered invoice sends
* invoice overdue and past-due reminders
* billing and payment failure notices
* legally or contractually required support and compliance notices

Preference model requirements:

* per-user per-notice-class preference keys
* default policy templates at tenant level
* explicit mandatory flag that overrides user opt-out
* audit trail when mandatory notices are dispatched

## Initial Use-Case Catalog

### Identity and access

* account creation verification email
* password reset and credential security notices
* suspicious-auth and lockout notices

### Notification system

* new high-priority notification email
* digest email for grouped low-priority notifications
* mention/assignment alerts where enabled

### Finance and sales

* manual invoice send
* scheduled invoice reminders (due soon)
* overdue invoice escalation notices
* estimate and quote sent/update notices
* payment received confirmations

### Support and operations

* ticket created/updated/replied notices
* SLA breach warning notices
* project/task due-soon and past-due notices

### Reporting

* scheduled daily/weekly/monthly operational reports
* exception reports (for example failures, backlog thresholds)

### Additional useful alerts to include now

* failed webhook/integration delivery alerts
* repeated job failure alerts
* data import completion/failure summaries
* user role/permission change notices for high-risk roles

## Setup And Settings Surfaces To Plan Now

### Platform setup/settings

* Graph app registration metadata and credential references
* sender account registry and alias registry
* global fallback sender rules
* default sender mapping by feature key
* global retry/backoff and queue policy

### Tenant setup/settings

* enable tenant override sending
* tenant sender account registry
* tenant alias mapping by feature key
* tenant default notification policy template
* per-tenant mandatory notice class visibility (read-only for globally mandatory classes)

### User settings

* per-notice-class email subscription preferences
* digest cadence choices where applicable
* channel preferences (in-app only, email + in-app) for optional classes

## Phase 3 Acceptance Criteria

* Graph send path is implemented and queue-backed
* platform and tenant sender accounts are configurable through GUI setup
* feature-based sender alias routing resolves correctly
* optional notice preferences are enforceable per user
* mandatory notice classes bypass user opt-out by policy
* send attempts, retries, throttles, and failures are auditable

## Out Of Scope

Not in current scope:

* bulk marketing/campaign sending infrastructure
* tenant self-service Graph app registration without governance
* replacing all existing mail providers in one cutover without phased fallback

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Implementation Batch 1]] | [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](../Phase%204/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
