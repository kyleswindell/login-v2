# Phase 3 - Implementation Batch 1

## Purpose

Define the first implementation batch for Phase 3 by establishing customer/public route contracts, proving outward-facing business-module behavior, and introducing Microsoft Graph email-delivery foundations.

## Implementation Status

Current status:

* planning drafted
* not started in code

Parent planning note:

* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## Batch Goal

Deliver the first dependency-safe public/customer slice required before broader Phase 4 module rollout:

* customer/public route and visibility contract baseline
* OAuth customer-access mode and provider policy baseline
* Events admin plus public-view proof
* Microsoft Graph email sending baseline with GUI configuration

## Why This Batch First

This batch establishes outward-facing primitives that later modules rely on:

* customer/public route ownership
* public visibility contracts
* module payload shaping for external consumption
* platform-versus-tenant publishing responsibility boundaries

## In Scope

* public and customer route ownership definitions
* tenant-configurable customer access mode setup (`disabled`, `invite_only`, `open_enrollment`)
* OAuth provider policy setup for Google and Microsoft sign-in
* customer company multi-user membership contract (customer company with multiple users)
* one public-facing event detail or listing proof with module-level and event-level visibility controls
* one tenant-admin event management proof
* Graph mail transport setup for transactional sends
* platform default sender accounts and alias configuration GUI
* tenant sender-account and alias override GUI
* feature-based sender alias mapping (for example finance, notifications, events, support)
* user-level email preference model for optional notices
* mandatory-notice policy model for non-optional notices
* permission and policy rules for public, customer, staff, and platform surfaces
* audit/error logging for outbound email operations and outward-facing event mutations

## Out Of Scope

* full broad core-module rollout (Phase 4)
* full CMS/website editing and deployment tooling
* tenant rollout/provisioning behavior (Phase 5)
* bulk marketing and newsletter campaign infrastructure

## Required Contracts Before Build

* customer/public/staff/platform visibility model
* public route namespace and rendering owner
* OAuth provider contract for Google and Microsoft sign-in
* tenant customer access mode contract (`disabled`, `invite_only`, `open_enrollment`)
* customer-company and customer-user membership contract
* module-level customer visibility toggle contract
* record-level visibility contract for customer-facing entities
* event capability toggles and publishability model
* Graph sender-account ownership model (platform defaults, tenant overrides)
* feature-to-sender alias resolution contract
* notice-class policy contract (optional vs mandatory)
* email preference key model for user-level subscription control

## Acceptance Criteria

* customer access mode switching works for `disabled`, `invite_only`, and `open_enrollment`
* OAuth provider policy is configurable for Google and Microsoft sign-in
* customer-company multi-user authorization rules are documented and testable by contract
* outward-facing Events proof works from tenant-managed data with both module-level and event-level visibility toggles
* Graph mail transport sends at least account verification, notification update, and finance reminder message classes
* platform defaults and tenant overrides are configurable through GUI setup
* feature-based sender alias routing resolves correctly for at least finance and notifications
* mandatory-notice rules override user opt-out for required classes (for example overdue invoice reminders)
* audit/error logging captures send attempts, throttling retries, and terminal failures
* resulting contracts are reusable by later Phase 4 modules

## Dependencies

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Events And Legacy Website Publishing Planning]] | [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Microsoft Graph Email Sending Planning]] | [Phase 3 - Microsoft Graph Email Sending Planning](Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - OAuth And Customer Access Mode Planning]] | [Phase 3 - OAuth And Customer Access Mode Planning](Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)
* [[V1 App/Modules/Events]] | [Events](../../../V1%20App/Modules/Events.md)
* [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../../../V1%20App/Architecture/Website%20Sync%20Architecture.md)

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](../Phase%204/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Development/Development Index]] | [Development Index](../../Development/Development%20Index.md)
