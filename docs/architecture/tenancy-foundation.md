# Tenancy Foundation

## Model

Login App 2.0 uses a central platform database plus one separate tenant database per client.

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
