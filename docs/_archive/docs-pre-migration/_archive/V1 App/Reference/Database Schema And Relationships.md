# Database Schema And Relationships

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Purpose

Provide one place in the vault that explains where this project's database schema comes from, how table relationships are represented, and how the admin/global database differs from tenant databases.

This note documents how the V1 system works today. It should not be treated as a source-of-truth architecture spec for V2, which is planned as a clean rebuild rather than a direct continuation of the Perfex platform or its current schema/module layout.

## Use This Note When

Use this note when you need the clearest reference answer to:

- where the current V1 schema comes from
- which databases and table families exist in the live V1 environment
- how relationships are represented in the current schema

Do not use this note as the main owner of:

- the high-level multi-tenant architecture story
- the product feature inventory
- setup/settings navigation details

## Schema Sources

The schema is assembled from a few different sources:

- Live local schema snapshot: `documentation/database/perfex-schema.sql`
- Core Perfex baseline: `application/install-RENAMED/database.sql`
- Tenant routing and DB selection: `application/application/config/database.php`
- Admin Core global table and tenant-policy columns: `application/modules/admin_core/install.php`
- Events module tables and legacy rename/migration logic: `application/modules/events/install.php`
- Surveys module tables: `application/modules/surveys/install.php`

Important implications:

- When documenting the actual local environment, prefer `documentation/database/perfex-schema.sql` over repo install files.
- The repo contains a baseline tenant-database install dump for core Perfex tables.
- Custom modules extend that baseline with their own install scripts.
- The live database can be ahead of the install dump if migrations or idempotent install updates have already run in an environment.

## Current Local Snapshot

The current local `perfex` schema snapshot lives at `documentation/database/perfex-schema.sql`.

What it confirms:

- The local database contains 122 `tbl*` application tables.
- The live schema includes `tbltenants` plus the custom Events tables:
  - `tblevents_events`
  - `tblevents_uploads`
  - `tblevents_sponsors`
  - `tblevents_blocked_submitters`
- The explicit foreign keys present in the live dump are still limited to:
  - `tblfilter_defaults.filter_id -> tblfilters.id`
  - `tblfilter_defaults.staff_id -> tblstaff.staffid`
  - `tbltwocheckout_log.invoice_id -> tblinvoices.id`

Interpretation note:

- `perfex_template` is the initial tenant-instance creation schema, not a fully module-expanded runtime schema.
- `tbltenants` belongs only in the admin/global database and is created by Admin Core.
- The `tblevents_*` tables are created when the Events module is installed in an app instance, so they should not be expected in an untouched template database.
- These observations explain V1 behavior only and should not be read as constraints on how V2 must be structured.

Encoding note:

- The dump is currently UTF-16 LE because it was generated from Windows `mysqldump`.
- Decode with `iconv -f UTF-16LE -t UTF-8` when reading it in WSL/Git Bash.

## Database Topology

There are two database contexts in this project:

### 1. Admin / global database

Used on `APP_ADMIN_HOST` and for tenant lookup.

Primary custom table:

- `tbltenants`

Purpose:

- Stores tenant host keys and tenant DB credentials.
- Stores tenant policy JSON for allowed modules and allowed native Perfex features.
- Stores tenant website sync and Events defaults.

Live snapshot note:

- In the local dump, `tbltenants` uses `id int unsigned AUTO_INCREMENT`, `tenant_key varchar(64)`, and `CURRENT_TIMESTAMP` defaults on `created_at` and `updated_at`.
- The live dump only shows a unique key on `tenant_key`. The repo install file additionally attempts unique keys on `db_name` and `db_user`, so the live schema has diverged from the installer at least slightly.
- `tbltenants` should be treated as admin-host-only schema, not tenant-instance baseline schema.

### 2. Tenant database

Used after host lookup resolves a tenant in `tbltenants`.

Contains:

- Core Perfex CRM tables from `application/install-RENAMED/database.sql`
- Activated module tables such as `tblevents_events`, `tblevents_uploads`, `tblevents_sponsors`, `tblevents_blocked_submitters`
- Selected module options in `tbloptions`

## Relationship Strategy

Most relationships in this codebase are logical/application-enforced relationships, not strict MySQL foreign keys.

What this means:

- IDs such as `userid`, `staffid`, `client`, `project_id`, `event_id`, `relid`, and `fieldid` are widely used as join keys.
- The application and module code assume those relationships and join on them directly.
- Referential cleanup is often handled in PHP rather than by DB constraints.

Notable exception in the core install dump:

- `tblfilter_defaults.filter_id -> tblfilters.id`
- `tblfilter_defaults.staff_id -> tblstaff.staffid`
- `tbltwocheckout_log.invoice_id -> tblinvoices.id`

Everything else reviewed here should be treated as a soft relationship unless a live database proves otherwise.

## Core Perfex Table Families

The tenant DB baseline in `application/install-RENAMED/database.sql` is broad. The tables below are the main relationship clusters that matter when tracing behavior.

### Tenant CRM identities

- `tblclients`: customer/company record
- `tblcontacts`: contacts for a client via `tblcontacts.userid -> tblclients.userid`
- `tblcustomer_groups`: membership rows via `customer_id` and `groupid`
- `tblcustomers_groups`: customer group definitions
- `tblcustomer_admins`: client-to-staff assignments

### Staff and permissions

- `tblstaff`: staff users
- `tblroles`: staff roles
- `tblstaff_permissions`: staff feature permissions
- `tbldepartments`: support departments
- `tblstaff_departments`: staff-to-department mapping

### Sales and finance

- `tblinvoices`, `tblestimates`, `tblcreditnotes`, `tblsubscriptions`, `tblproposals`, `tblcontracts`, `tblexpenses`
- Most rows point back to a client, staff user, project, or payment mode by ID fields such as `clientid`, `userid`, `project_id`, `paymentmode`
- `tblinvoicepaymentrecords` links payment records to invoices
- `tblitemable` and `tblitem_tax` attach catalog items/taxes to invoices, estimates, proposals, and other sales entities
- `tbltaxes`, `tblitems`, `tblitems_groups`, `tblpayment_modes`, `tblcurrencies` support those flows

### Projects and tasks

- `tblprojects`: project header record
- `tblproject_members`: many-to-many project/staff membership
- `tblproject_files`, `tblproject_notes`, `tblproject_settings`, `tblproject_activity`
- `tblprojectdiscussions` and `tblprojectdiscussioncomments`
- `tbltasks`: task header record
- `tbltask_assigned`, `tbltask_followers`, `tbltask_comments`, `tbltask_checklist_items`, `tbltaskstimers`
- `tblmilestones` links milestones back to projects

### Support and knowledge base

- `tbltickets`: support ticket header
- `tblticket_replies`, `tblticket_attachments`, `tbltickets_status`, `tbltickets_priorities`, `tbldepartments`
- `tblknowledge_base`, `tblknowledge_base_groups`, `tblknowedge_base_article_feedback`

### Leads, forms, and intake

- `tblleads`, `tblleads_status`, `tblleads_sources`
- `tbllead_activity_log`, `tbllead_integration_emails`, `tblleads_email_integration`
- `tblestimate_requests`, `tblestimate_request_forms`, `tblestimate_request_status`
- `tblweb_to_lead`
- Legacy form/question tables also exist: `tblform_questions`, `tblform_question_box`, `tblform_question_box_description`, `tblform_results`

### Shared system tables

- `tbloptions`: application/module key-value settings
- `tblmodules`: activated modules
- `tblcustomfields`: custom field definitions
- `tblcustomfieldsvalues`: polymorphic custom field values via `fieldid`, `relid`, `fieldto`
- `tblfiles`, `tblnotes`, `tblnotifications`, `tblactivity_log`, `tblreminders`
- `tbltags`, `tbltaggables`
- `tblfilters`, `tblfilter_defaults`
- `tblmigrations`, `tblsessions`, `tblmail_queue`, `tblscheduled_emails`

### Core Perfex calendar events

- `tblevents`

This is separate from the custom Events module tables described below.

## Custom Table Families In This Repo

### Admin Core

Global DB table:

- `tbltenants`

Key relationships and usage:

- `tenant_key` is the host lookup key used in `application/application/config/database.php`
- `allowed_modules` and `allowed_core_features` are JSON policy blobs, not relational child tables
- Tenant policy can drive updates into tenant-side `tblmodules` and `tbloptions`

Documentation note:

- In V1, `Admin Core` is a useful label for the separated admin-host / tenant-orchestration concern.
- This note describes the current V1 implementation, where that concern happens to live in a module.
- It should not be read as a V2 requirement that the same concern must remain an installable module rather than a first-class part of the rebuilt admin application.

### Events module

Tenant DB tables:

- `tblevents_events`
- `tblevents_uploads`
- `tblevents_sponsors`
- `tblevents_blocked_submitters`

Key logical relationships:

- `tblevents_uploads.event_id -> tblevents_events.id`
- `tblevents_sponsors.event_id -> tblevents_events.id`
- `tblevents_events.created_by -> tblstaff.staffid`
- `tblevents_uploads.reviewed_by -> tblstaff.staffid`
- `tblevents_uploads.flagged_by -> tblstaff.staffid`
- `tblevents_blocked_submitters.blocked_by -> tblstaff.staffid`
- `tblevents_events.perfex_event_id -> tblevents.id`
- `tblcustomfieldsvalues.relid -> tblevents_events.id` when `fieldto = 'events'`

Behavioral notes:

- The installer can rename legacy `event_photo_drop` tables/options/module rows to the `events` naming.
- These tables are install-time module additions, not part of the untouched tenant template schema.
- `short_public_code` is a unique secondary public identifier.
- Moderation status and submitter blocking are stored partly on uploads and partly in the blocked-submitters table.
- Their existence in V1 documents current runtime behavior only; it does not imply the same persistence model should be reused in V2.

### Surveys module

Tenant DB tables created by the module:

- `tblsurveyresultsets`
- `tblsurveysemailsendcron`
- `tblsurveys`
- `tblsurveysendlog`
- `tblemaillists`
- `tbllistemails`
- `tblmaillistscustomfields`
- `tblmaillistscustomfieldvalues`

Main logical relationships:

- survey result/send tables point back to `tblsurveys` by `surveyid`
- mail list email/custom field tables point back to `tblemaillists` by `listid`
- custom field value rows point to custom field definitions by `customfieldid`

## Relationship Notes That Matter Operationally

- `tbloptions` is the main place for module feature flags and serialized settings.
- `tblmodules` controls tenant-side module activation state; Admin Core can turn module rows on or off per tenant.
- `tblcustomfields` plus `tblcustomfieldsvalues` is the main polymorphic extension mechanism in Perfex.
- Because most relationships are soft, backups and data repair work should include both parent and child tables together.
- When deleting staff or tenant-owned records, check module code for manual cleanup paths because the DB will not usually enforce cascade deletes.

## Live Schema Inspection

Use these in MySQL when you need the actual runtime schema rather than the repo baseline.

### Show every table in the current database

```sql
SHOW FULL TABLES;
```

### Get the exact `CREATE TABLE` statement for one table

```sql
SHOW CREATE TABLE `tbltenants`;
SHOW CREATE TABLE `tblevents_events`;
SHOW CREATE TABLE `tblcustomfields`;
SHOW CREATE TABLE `tblcustomfieldsvalues`;
```

### Generate `SHOW CREATE TABLE` statements for all tables in the current schema

```sql
SELECT CONCAT('SHOW CREATE TABLE `', table_name, '`;') AS stmt
FROM information_schema.tables
WHERE table_schema = DATABASE()
ORDER BY table_name;
```

If this returns tables such as `COLUMNS`, `TABLES`, `KEY_COLUMN_USAGE`, `INNODB_*`, or `CHARACTER_SETS`, you are not pointed at the Perfex application schema. You are likely in `information_schema`.

Use this first to confirm the active database:

```sql
SELECT DATABASE() AS current_db;
```

If needed, switch to the actual Perfex database before generating statements:

```sql
USE perfexcrm;
```

Or hardcode the schema name so the query cannot drift with session state:

```sql
SELECT CONCAT('SHOW CREATE TABLE `', table_name, '`;') AS stmt
FROM information_schema.tables
WHERE table_schema = 'perfexcrm'
ORDER BY table_name;
```

To exclude MySQL system schemas when exploring all available schemas:

```sql
SELECT table_schema, table_name
FROM information_schema.tables
WHERE table_schema NOT IN ('mysql', 'information_schema', 'performance_schema', 'sys')
ORDER BY table_schema, table_name;
```

### Review columns, indexes, and constraints for all tables

```sql
SELECT
  c.table_name,
  c.ordinal_position,
  c.column_name,
  c.column_type,
  c.is_nullable,
  c.column_default,
  c.column_key,
  c.extra
FROM information_schema.columns c
WHERE c.table_schema = DATABASE()
ORDER BY c.table_name, c.ordinal_position;

SELECT
  s.table_name,
  s.index_name,
  s.non_unique,
  s.seq_in_index,
  s.column_name
FROM information_schema.statistics s
WHERE s.table_schema = DATABASE()
ORDER BY s.table_name, s.index_name, s.seq_in_index;

SELECT
  tc.table_name,
  tc.constraint_name,
  tc.constraint_type,
  kcu.column_name,
  kcu.referenced_table_name,
  kcu.referenced_column_name
FROM information_schema.table_constraints tc
LEFT JOIN information_schema.key_column_usage kcu
  ON tc.constraint_schema = kcu.constraint_schema
 AND tc.table_name = kcu.table_name
 AND tc.constraint_name = kcu.constraint_name
WHERE tc.constraint_schema = DATABASE()
ORDER BY tc.table_name, tc.constraint_name, kcu.ordinal_position;
```

## Recommended Documentation Reading Order

- Start here for the schema map.
- Use `documentation/database/perfex-schema.sql` when you need the actual local schema.
- Use `application/install-RENAMED/database.sql` for baseline core table definitions.
- Use module `install.php` files for custom tables and idempotent schema evolution.
- Use models/controllers when you need the true logical relationships or delete/update side effects.

## Related

- [[V1 App/Reference/Admin Core Data Model]] | [Admin Core Data Model](Admin%20Core%20Data%20Model.md)
- [[V1 App/Reference/Events Data Model]] | [Events Data Model](Events%20Data%20Model.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](../Architecture/Request%20And%20Database%20Routing.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
- [[Standards/Database Migration Standards]] | [Database Migration Standards](../../Standards/Database%20Migration%20Standards.md)
