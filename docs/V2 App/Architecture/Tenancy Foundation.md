# Tenancy Foundation

## Model

Login App 2.0 uses a central platform database plus one separate tenant database per client.

## Application Boundary

App 2.0 should be planned as one Laravel codebase with two application contexts:

* a central platform admin context for Parasolutions-owned operations
* a tenant admin context for each client instance

This is not two unrelated products. It is one system with a strict runtime boundary between platform-owned concerns and tenant-owned concerns.

See the fuller planning note:

* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)

## Central Responsibilities

The central platform database owns:

* tenant records
* tenant domains
* tenant database connection metadata
* tenant module policy
* tenant site metadata
* provisioning logs
* platform audit logs

## Tenant Responsibilities

Each tenant database owns tenant-local application data, including:

* tenant users
* roles and permissions
* settings
* pages
* articles
* media metadata
* content blocks
* tenant audit logs

## Domain Resolution

Tenant admin requests are resolved by exact domain match first, then optional alias match. Once the tenant is resolved, the app initializes that tenant database connection and boots tenant context.

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[V2 App/Architecture/App 2.0 Blueprint]] | [App 2.0 Blueprint](App%202.0%20Blueprint.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Reference/Logging Data Model Notes]] | [Logging Data Model Notes](../Reference/Logging%20Data%20Model%20Notes.md)
