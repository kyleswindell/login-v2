<!--
DOC-META
title: Repository Naming Standards
doc_type: standard
status: active
owner: architecture
canonical: true
canonical_path: docs/02-standards/coding/repository-naming-standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines canonical repository naming for folders, namespaces, owners, Modules, PHP types, technical roles, delivery artifacts, routes, configuration, events, tests, documentation, Application Registration, compatibility, and broad database boundaries.
-->

# Repository Naming Standards

Parent: [Coding Standards Index](index.md)

## 1. Purpose

Define the enforceable naming model for Login 2.0 repository artifacts.

Use this standard to name an artifact after its owner, responsibility, Technical Role, placement, identifier family, and compatibility state are known. This standard promotes the accepted Goal 3 Phase 5 naming decisions without authorizing physical migration.

## 2. Authority And Scope

This standard governs:

- repository and package folders;
- PHP namespaces and declared types;
- Core capability and Module identity representations;
- Technical Role class names;
- delivery artifacts;
- routes, URLs, configuration, Events, Listeners, Jobs, Notifications, audit events, and queues;
- broad Model, table, migration, test, fixture, and documentation naming;
- Application Registration terminology and conditional artifact names;
- compatibility aliases and renames.

Specialist standards retain authority over behavior, detailed schema, runtime implementation, security, operations, and verification.

## 3. Separate Identifier Families

Keep these naming families separate:

```text
physical path
PHP namespace
PHP declared type
owner_key
capability_key
module_key
Composer package
route name
URL
configuration key
environment variable
framework alias
display label
documentation title
compatibility alias
```

One family must not silently become canonical authority for another. Record deterministic relationships explicitly.

Canonical internal keys follow [Identifier And Key Standards](Identifier%20And%20Key%20Standards.md).

## 4. Folder And Namespace Naming

Use the convention native to each folder family.

| Folder family                                   | Convention                                | Example                                                                    |
| ----------------------------------------------- | ----------------------------------------- | -------------------------------------------------------------------------- |
| Accepted repository or Laravel branch           | Exact accepted spelling                   | `app/`, `Core/`, `UI/`, `Http/`, `Console/`, `Providers/`, `Modules/`      |
| PSR-4 namespace segment                         | PascalCase with exact case correspondence | `app/Core/DataGovernance/Actions/`                                         |
| Package support directory                       | Established lowercase name                | `src/`, `config/`, `routes/`, `database/`, `resources/`, `tests/`, `docs/` |
| Human-maintained non-PHP owner or artifact path | Lowercase kebab-case                      | `resources/views/core/data-governance/`                                    |
| Tool-owned, generated, or vendor path           | Native tool convention                    | Framework-specific                                                         |

PHP source patterns are:

```text
app/Core/<Capability>/<TechnicalRole>/
App\Core\<Capability>\<TechnicalRole>

app/UI/<Responsibility>/<TechnicalRole>/
App\UI\<Responsibility>\<TechnicalRole>

Modules/<Module>/src/<TechnicalRole>/
<ModulePsr4Prefix>\<TechnicalRole>
```

`Modules/` and `src/` are not automatically namespace segments. Every Module defines its package-local PSR-4 mapping.

Technical Role labels use one controlled singular or plural form repository-wide. The form does not change according to file count.

Prohibit generic production destinations such as:

```text
Common
Shared
Misc
General
Generic
Helpers
Utils
Utilities
Services
Managers
Support
Infrastructure
Surfaces
Features
Base
Other
```

A narrow test, tooling, vendor, generated, or compatibility use may retain a native term when explicitly scoped. It must not create production ownership.

`Platform` remains retired as a peer ownership category. It is reserved only as a potential transitional placeholder for unresolved global-administration tooling and does not authorize a canonical owner, owner key, or generic target folder.

## 5. Core Capability Identity

Every permanent direct child of `app/Core/` represents one accepted Core capability owner.

Each capability maintains one explicit identity record containing:

- canonical PascalCase technical name;
- `ownership_area: core`;
- `owner_key`;
- PHP folder and namespace segment;
- lowercase kebab-case non-PHP slug where needed;
- documentation title and prose reference;
- compatibility names;
- lifecycle status;
- governing decision.

Example:

```text
Technical name: DataGovernance
PHP path:       app/Core/DataGovernance/
Namespace:      App\Core\DataGovernance
owner_key:      data_governance
Non-PHP slug:   data-governance
Title:          Data Governance
```

Name the enduring responsibility, not its current resource, route, navigation group, team, framework, or implementation.

Do not add `Core`, `Capability`, `Platform`, generic `Service`, or generic `Management` affixes.

Use the natural stable grammatical form. `Auth` is an accepted controlled abbreviation. Resource terms such as Account, Users, Roles, Logging, or Administration do not become Core owners without separate ownership acceptance.

## 6. Module Identity

Every Module maintains one explicit identity record.

| Identity            | Pattern                              | Example                           |
| ------------------- | ------------------------------------ | --------------------------------- |
| Display name        | Natural title case                   | `Projects`                        |
| `module_key`        | Lowercase snake case                 | `projects`                        |
| Package folder      | PascalCase                           | `Modules/Projects/`               |
| PHP namespace       | `Parasolutions\Modules\<Module>\`    | `Parasolutions\Modules\Projects\` |
| Composer package    | `parasolutions/module-<module-slug>` | `parasolutions/module-projects`   |
| Route-name root     | `<module_key>.*`                     | `projects.*`                      |
| Configuration root  | `<module_key>.*`                     | `projects.*`                      |
| Documentation title | `<Display Name> Module`              | `Projects Module`                 |

The vendor spelling is exactly `Parasolutions` in PHP and `parasolutions` in Composer. Do not rewrite it as `ParaSolutions`.

A Module name describes one cohesive optional responsibility. Do not add generic `Module`, `Package`, `Feature`, `Service`, `Manager`, `Platform`, or `Business` affixes unless independently part of the product identity.

Brand capitalization, acronyms, and exceptional forms must be recorded explicitly rather than inferred from `module_key`.

## 7. PHP Declared Types

Repository-owned classes, interfaces, traits, enums, and other declared PHP types use PascalCase. Each file contains one declared type and its filename exactly matches its case-sensitive type name.

### 7.1. Interfaces And Implementations

Repository-owned interfaces end in `Interface`. Do not use an `I` prefix.

```text
UserRepositoryInterface
NotificationSenderInterface
ModuleContributionInterface
```

Concrete implementations name their meaningful mechanism or strategy:

```text
EloquentUserRepository
CachedPermissionResolver
DatabaseNotificationStore
```

Do not use `Impl`, `Implementation`, `Concrete`, generic `Base`, or undocumented `Default` affixes.

### 7.2. Abstract Classes, Traits, Enums, And Values

- Intentional partial implementations use the `Abstract` prefix.
- Traits use behavioral phrases such as `HasActorContext` or `InteractsWithRegistry`; no `Trait` suffix is required.
- Enums use a singular semantic noun without `Enum`.
- Value Objects use their semantic domain name without `ValueObject`.
- Exceptions name the exact failure and end in `Exception`.

### 7.3. Data Objects

Use **Data Object** as the project term. Do not use DTO or `Dto` suffixes in new canonical naming.

```text
CreateUserData
UserSearchCriteria
PermissionEvaluationResult
UserAccountSnapshot
```

Operation inputs normally use `<Operation>Data`, query criteria use `<Subject>Criteria`, and returned structures use `<Subject>Result` or another precise data-shape name.

### 7.4. Providers, Registries, And Definitions

- Laravel Providers use `<OwnerOrConcern>ServiceProvider`.
- Registries use `<ArtifactFamily>Registry`.
- Definitions use `<Subject>Definition`.
- Formal Module definitions use `<Module>ModuleDefinition`.

## 8. Application Operation And Coordination Roles

| Role        | Pattern                       | Accepted use                                                              |
| ----------- | ----------------------------- | ------------------------------------------------------------------------- |
| Action      | `<Verb><Subject>Action`       | One state-changing application intent or outcome                          |
| Query       | `<ReadVerb><Subject>Query`    | One read-oriented operation                                               |
| Resolver    | `<ResolvedSubject>Resolver`   | Select, derive, normalize, or determine one result                        |
| Coordinator | `<Workflow>Coordinator`       | Reusable orchestration across multiple bounded operations                 |
| Handler     | `<MessageOrProtocol>Handler`  | One explicit message, protocol, callback, or external invocation          |
| Service     | `<SpecificCapability>Service` | Exceptional cohesive multi-operation capability with no more precise role |

Use `Find`, `Get`, `List`, `Search`, `Count`, `Calculate`, or `Summarize` for Queries only when accurate.

One-off orchestration remains inside its Action. `Service` is not a default application layer. `Manager` is prohibited by default. `Creator` is not a general technical suffix; use `Create<Subject>Action`, `<Subject>Factory`, or `<Subject>Builder`.

Prefer precise capability roles such as `PasswordHasher`, `RiskScorer`, `TokenIssuer`, or `PermissionEvaluator` over generic Services.

## 9. Delivery Artifact Naming

| Artifact                    | Pattern                           | Example                                   |
| --------------------------- | --------------------------------- | ----------------------------------------- |
| Resource controller         | `<Subject>Controller`             | `UserController`                          |
| Single-operation controller | `<Verb><Subject>Controller`       | `SuspendUserController`                   |
| Form Request                | `<Verb><Subject>Request`          | `UpdateUserRequest`                       |
| Middleware                  | `<Purpose>Middleware`             | `RequireRecentAuthenticationMiddleware`   |
| API Resource                | `<Subject>Resource`               | `UserResource`                            |
| API collection              | `<Subject>Collection`             | `UserCollection`                          |
| Presenter                   | `<SubjectOrSurface>Presenter`     | `UserIndexPresenter`                      |
| Renderer                    | `<SubjectOrFormat>Renderer`       | `AuditCsvRenderer`                        |
| Page data                   | `<PageOrSurface>PageData`         | `UserIndexPageData`                       |
| ViewModel                   | `<SubjectOrSurface>ViewModel`     | `UserIndexViewModel`                      |
| Console command             | `<Verb><Subject>Command`          | `RebuildRegistrationManifestCommand`      |
| Webhook handler             | `<Provider><Event>WebhookHandler` | `QuickBooksCustomerUpdatedWebhookHandler` |

Use ViewModel only when presentation-specific derived state or behavior exceeds a PageData object.

Delivery artifacts parse, validate, translate, present, or render. They delegate application behavior inward.

## 10. Route And URL Naming

Route names use capability-first lowercase dotted keys with snake-case segments:

```text
users.index
users.roles.update
projects.archive
global_administration.tenants.update
```

Do not derive route names from PHP namespaces, controllers, folders, URL prefixes, owner keys, or delivery channels. Generic prefixes such as `admin`, `web`, `api`, `core`, and `module` are prohibited unless part of the actual capability identity.

Use conventional terminal actions such as `index`, `show`, `create`, `store`, `edit`, `update`, and `destroy` when accurate. Use domain verbs such as `archive`, `suspend`, `restore`, or `approve` when resource operations are insufficient.

URLs use lowercase kebab-case. Resource collections normally use plural nouns and parameters use singular resource names.

```text
/users/{user}
/users/{user}/suspend
/data-governance/retention-policies
/quickbooks-sync/imports
```

Administrative URL grouping is independent from route names. The exact administrative URL prefix remains owned by its accepted feature issue.

Route aliases and URL redirects are separate compatibility mechanisms.

## 11. Configuration Naming

- Configuration directories use exact lowercase `config/`.
- PHP configuration filenames use lowercase snake case.
- The default owner file matches `owner_key` or `module_key`.
- Configuration roots use the applicable capability or Module key.
- Nested keys use lowercase snake-case segments joined through Laravel dot notation.
- Environment variables use upper snake case.
- Framework-native variables retain established names.

Examples:

```text
identity.users.default_active
notifications.delivery.retry_limit
projects.retention_days
quickbooks_sync.import.batch_size

NOTIFICATIONS_DELIVERY_RETRY_LIMIT
QUICKBOOKS_SYNC_CLIENT_ID
```

Application code reads environment variables only through configuration files. Runtime-editable settings, preferences, feature state, and secrets are not Laravel configuration.

Do not use generic roots or filenames such as `settings`, `module`, `services`, `common`, `shared`, or `platform` unless a framework-owned file has that exact established meaning.

## 12. Event, Listener, Job, Notification, Audit, And Queue Naming

| Artifact         | PHP pattern                                             | Machine-key pattern                                                 |
| ---------------- | ------------------------------------------------------- | ------------------------------------------------------------------- |
| Domain Event     | `<CompletedFact>Event`                                  | `<capability>.<completed_fact>`                                     |
| Listener         | `<ImperativePurpose>Listener`                           | `<consumer_owner>.<handler_purpose>` when stable identity is needed |
| Job              | `<ImperativeOperation>Job`                              | `<capability>.<operation>`                                          |
| Notification     | `<ConditionOrFact>Notification`                         | Domain-first notification key                                       |
| Audit event type | `<CompletedFact>AuditEvent` when represented by a class | Domain-first completed-event key                                    |
| Logical queue    | Normally no class                                       | Broad operational lane                                              |

Examples:

```text
UserAccountSuspendedEvent
SendUserSuspensionNoticeListener
GenerateReportJob
CredentialExpiringNotification
RoleUpdatedAuditEvent
```

Logical queue keys identify broad lanes such as `default`, `notifications`, `exports`, and `integrations`. Do not create one queue per Job or owner without an operational reason.

Class names, machine keys, provider queue names, and display labels remain separate.

## 13. Broad Database Naming Boundary

Eloquent Model classes use singular PascalCase semantic nouns. Do not add `Model`, `Record`, `Entity`, or `Database` affixes merely to identify persistence.

Default tables use plural snake case. Explicit `$table` overrides require a documented domain, compatibility, external-schema, or database-standard reason.

Laravel migration filenames use:

```text
<timestamp>_<result>.php
```

The result describes one primary schema change, such as:

```text
create_user_contact_emails_table
add_expires_at_to_api_tokens_table
```

Ownership is expressed through placement and documentation, not automatic `core_`, `module_`, owner-key, capability-key, or package prefixes.

Detailed columns, keys, indexes, constraints, join-table ordering, schemas, polymorphism, scope, and database-specific exceptions remain owned by database standards and Goal 6.

## 14. Test And Fixture Naming

| Artifact          | Pattern                                                                           |
| ----------------- | --------------------------------------------------------------------------------- |
| Test class        | `<SubjectOrBehavior>Test`                                                         |
| Test method       | `test_<context>_<expected_outcome>` or `test_<expected_outcome>_when_<condition>` |
| Browser test      | `<Flow>BrowserTest`                                                               |
| Architecture test | `<BoundaryOrRule>ArchitectureTest`                                                |
| Contract test     | `<Subject>ContractTest`                                                           |
| Dataset           | Descriptive snake-case name                                                       |
| Dataset case      | Condition, rejection reason, or expected outcome                                  |
| Factory           | `<Model>Factory`                                                                  |
| PHP fixture       | `<Subject>Fixture`                                                                |
| Non-PHP fixture   | Descriptive lowercase kebab-case filename                                         |
| Shared test base  | `<Concern>TestCase`                                                               |

Owner identity is normally communicated through placement rather than repeated in every class.

Execution uses separate dimensions:

- named PHPUnit suites represent stable test types;
- accepted filesystem paths select owners;
- PHPUnit groups represent orthogonal cross-cutting execution characteristics.

Do not create manual `index.php` suite aggregators or an owner-by-type suite explosion. Directory discovery must be deterministic without omission or duplicate execution.

## 15. Documentation Naming

New canonical Markdown prose filenames use lowercase kebab-case.

Reserved filenames retain their established meanings:

```text
index.md
README.md
AGENTS.md
```

Templates use a leading underscore plus lowercase kebab-case. Visible titles use human-readable title case. `DOC-META.title` matches the H1, and `canonical_path` matches the repository-relative path.

Planning hierarchy uses forms such as `milestone-0`, `goal-3`, and `phase-5`. Numbered Phase decisions use `<phase>-<decision>-<subject>.md`.

ADRs use the repository-wide `adr-0001-decision-title.md` sequence and `ADR-0001: Decision Title` H1 pattern.

Do not encode lifecycle terms such as `draft`, `active`, or `final` in filenames. Existing canonical paths using spaces or older conventions may remain until an authorized migration. Do not rename them opportunistically.

## 16. Application Registration Terminology And Conditional Artifacts

Retain these architecture terms:

```text
Application Registration System
Owner Registration Descriptor
Registration Compiler
Compiled Registration Manifest
Root Application Registrar
Typed Registrar
```

They identify responsibilities and artifact categories; they do not require one custom PHP artifact per term.

A formal Module Definition, owner-local Provider, Data Object, native framework integration, or dedicated artifact may fulfill a registration responsibility when it preserves explicit ownership, deterministic validation, dependency ordering, failure behavior, and traceability.

When a distinct artifact is justified, use:

| Artifact                   | Conditional name                                                  |
| -------------------------- | ----------------------------------------------------------------- |
| Dedicated owner descriptor | `<Owner>RegistrationDescriptor`                                   |
| Shared descriptor contract | `RegistrationDescriptorInterface`                                 |
| Compiler class             | `RegistrationCompiler`                                            |
| Compiled-result type       | `CompiledRegistrationManifest`                                    |
| Materialized output        | `compiled-registration-manifest.<format>`                         |
| Root registrar class       | `RootApplicationRegistrar`                                        |
| Bounded family registrar   | `<ArtifactFamily>Registrar`                                       |
| Compile command            | `CompileRegistrationManifestCommand`, `registration:compile`      |
| Validation command         | `ValidateRegistrationDescriptorsCommand`, `registration:validate` |

`Typed Registrar` is a category, not a required `TypedRegistrar` class. Custom registrar families remain sparse.

Registration references existing canonical owner and artifact identifiers. Do not manufacture competing `registration.*` aliases.

Owner declarations remain canonical inputs. The compiled representation remains deterministic derived output.

## 17. Generic Abstraction Rule

A generic role name may be used for an interface, abstract base class, trait, enum, Value Object, or bounded framework type only when it defines one exact reusable contract, invariant, lifecycle, or mechanism.

Concrete application classes remain specifically named.

Prefer composition and interfaces over inheritance unless a base class enforces meaningful shared behavior or state. Do not introduce an abstraction solely to create a common parent type or naming hierarchy.

## 18. Compatibility And Rename Rules

A naming change requires a material ownership, responsibility, collision, contract, deterministic-discovery, compatibility, or enforceability benefit. Cosmetic consistency alone is insufficient.

Every artifact has one canonical name within its family. Legacy names may remain only through an explicit compatibility record or bounded exception.

A compatibility record identifies:

- identifier family;
- legacy name;
- canonical name;
- responsible owner;
- compatibility surface and verified reason;
- status;
- verification;
- removal condition and migration owner;
- tracking issue.

Aliases map one legacy name directly to one canonical name. They must not chain, compete as canonical, permit ambiguous reverse lookup, silently normalize invalid input, or be reused for another concept.

Compatibility is transitional by default. Permanent compatibility requires an exact external, vendor, protocol, public API, or persisted-data constraint and repository-owner acceptance.

Naming acceptance does not authorize physical renaming or alias implementation.

## 19. Validation And Stop Conditions

Validate applicable:

- path and namespace correspondence;
- declared type and filename correspondence;
- identity-family separation;
- generic-name prohibitions;
- duplicate keys, aliases, routes, configuration roots, and registration declarations;
- deterministic test discovery;
- documentation metadata and links;
- compatibility records and removal ownership.

Stop when:

- ownership or identifier family is unclear;
- a proposed name creates a second canonical identity;
- migration impact is unverified;
- an abstraction exists only to mirror terminology;
- a detailed database decision would exceed Goal 3 authority;
- a naming change would weaken an accepted test, Contract, or compatibility requirement.

## 20. Related

- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Identifier And Key Standards](Identifier%20And%20Key%20Standards.md)
- [Schema Design Standards](../database/Schema%20Design%20Standards.md)
- [Database Migration Standards](../database/Database%20Migration%20Standards.md)
- [How To Write Docs](../documentation/How%20To%20Write%20Docs.md)
- [Goal 3 Phase 5 Naming Conventions Index](../../07-planning/Milestones/milestone-0/goal-3/phase-5/index.md)
- [Goal 3 Phase 5 Naming Convention Matrix](../../07-planning/Milestones/milestone-0/goal-3/phase-5/naming-convention-matrix.md)
