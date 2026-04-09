# Phase 1 - Implementation Batch 2

## Purpose

Translate the newly validated staging foundation into the next usable platform-app batch.

This batch should focus on turning the current auth, dashboard shell, user management, and docs viewer baseline into a more complete internal platform workspace without pulling tenancy or broader domain modules in too early.

## Batch Goal

Establish the first durable platform-operations layer on top of the Phase 1 foundation by improving:

* dashboard usefulness
* platform user administration
* documentation visibility
* seed and admin convenience for ongoing development

## In Scope

### Core platform surfaces

This batch should continue improving:

* dashboard summaries and quick links
* platform user listing and edit flow
* role assignment usability
* documentation vault viewing behavior

### Supporting behavior

This batch should also establish:

* stable navigation patterns for platform admin areas
* clearer success/error feedback in admin flows
* predictable docs viewer routing and selection behavior
* future docs-vault search planning without committing to implementation yet
* first-pass seeding and admin workflow conventions for staging use

## Out Of Scope

Do not pull these into Batch 2:

* tenant registry or provisioning work
* customer, project, or finance domain tables
* CMS/content publishing tables
* mail delivery or notification fan-out
* GitHub Actions deployment implementation
* in-app deploy triggers or arbitrary server command execution

## Recommended Order

1. tighten dashboard usefulness for active platform admins
2. improve platform user management feedback and lifecycle behavior
3. improve docs viewer navigation, rendering, and selection state
4. add any missing role/permission seeds needed for repeated staging use
5. document the resulting admin workflow once the UI stabilizes

## Open Decisions Before Batch 2 Closes

These should be resolved explicitly during or at the end of this batch:

* whether platform roles need first-pass seeders in the main app flow
* whether the docs viewer should support richer markdown features such as tables or callouts
* what level of full-text docs-vault search is feasible without overcomplicating the platform shell too early
* whether deploy visibility belongs in Phase 1 or should stay deferred to a later operations phase
* when to begin the first real shared-core business module after the platform shell feels stable

## Recommended Defaults

Current best recommendation:

* keep the docs viewer read-only and platform-super-admin-only for now
* keep deployment triggering outside the app for now
* continue using staging as the primary validation surface for platform-admin UX
* treat the next business module as the first true transition point out of platform-foundation work

## Deliverables

Batch 2 should leave the repo with:

* a stable platform admin shell
* usable platform user management
* a functioning in-app docs repository viewer
* clearer staging admin workflows
* updated docs describing the current platform-admin baseline

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
