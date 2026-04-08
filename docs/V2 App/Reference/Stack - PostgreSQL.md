# PostgreSQL

## Role In App 2.0

PostgreSQL is the authoritative data store for the platform database and future tenant databases.

## Planned Usage

* one central platform database
* one separate tenant database per tenant
* one PostgreSQL role per tenant
* platform provisioning must create the tenant database and tenant role together

## Best Practices For This Repo

* keep platform and tenant data physically separated by database
* keep one tenant role per tenant to reduce accidental cross-tenant access
* prefer least-privilege grants for tenant roles
* manage schema with Laravel migrations
* document any role, database, or privilege assumptions in the tenancy docs
* avoid treating PostgreSQL credentials as application config that can drift outside provisioning

## Operational Notes

* roles exist at the cluster level, not per database
* provisioning must account for database creation, role creation, grants, and connection verification
* platform migrations and tenant migrations may eventually need separate execution flows

## Official References

* PostgreSQL roles overview: https://www.postgresql.org/docs/current/database-roles.html
* PostgreSQL `CREATE ROLE`: https://www.postgresql.org/docs/current/sql-createrole.html
* PostgreSQL docs index: https://www.postgresql.org/docs/current/index.html

## Practical Notes

We should document the eventual tenant provisioning SQL and privilege model before implementing the connection manager and provisioning pipeline.

## Related

* [[V2 App/Reference/Reference Index]] | [Reference Index](Reference%20Index.md)
* [[V2 App/Architecture/Tenancy Foundation]] | [Tenancy Foundation](../Architecture/Tenancy%20Foundation.md)
