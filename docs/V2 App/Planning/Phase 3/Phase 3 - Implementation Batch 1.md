# Phase 3 - Implementation Batch 1

## Purpose

Define the first implementation batch for Phase 3 by establishing customer/public route contracts, proving outward-facing business-module behavior, and validating interim legacy website publishing support.

## Implementation Status

Current status:

* planning drafted
* not started in code

Parent planning note:

* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## Batch Goal

Deliver the first dependency-safe public/customer slice required before broader Phase 4 module rollout:

* customer/public route and visibility contract baseline
* Events admin plus public-view proof
* interim legacy website JSON publishing adapter proof

## Why This Batch First

This batch establishes outward-facing primitives that later modules rely on:

* customer/public route ownership
* public visibility contracts
* module payload shaping for external consumption
* platform-versus-tenant publishing responsibility boundaries

## In Scope

* public and customer route ownership definitions
* one public-facing event detail or listing proof
* one tenant-admin event management proof
* publish-target configuration direction owned by platform context
* interim JSON publishing proof for legacy website compatibility
* permission and policy rules for public, customer, staff, and platform surfaces
* audit/error logging for publish operations and outward-facing event mutations

## Out Of Scope

* full broad core-module rollout (Phase 4)
* full CMS/website editing and deployment tooling
* tenant rollout/provisioning behavior (Phase 5)
* platform-management expansion beyond required publishing configuration

## Required Contracts Before Build

* customer/public/staff/platform visibility model
* public route namespace and rendering owner
* event capability toggles and publishability model
* publishing target contract and credential ownership model
* JSON payload contract for event detail and event index artifacts

## Acceptance Criteria

* outward-facing Events proof works from tenant-managed data
* platform-configured publishing capability can be assigned without making the tenant own the integration framework
* at least one legacy-compatible JSON artifact is published successfully through the selected adapter path
* audit/error logging captures publish attempts and failures
* the resulting contracts are reusable by later outward-facing modules

## Dependencies

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Events And Legacy Website Publishing Planning]] | [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [[V1 App/Modules/Events]] | [Events](../../../V1%20App/Modules/Events.md)
* [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../../../V1%20App/Architecture/Website%20Sync%20Architecture.md)

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](../Phase%204/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Development/Development Index]] | [Development Index](../../Development/Development%20Index.md)
