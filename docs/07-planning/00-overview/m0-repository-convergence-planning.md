<!--
DOC-META
title: M0 Repository Convergence Planning
doc_type: planning
status: draft
owner: architecture
canonical: true
canonical_path: docs/07-planning/00-overview/m0-repository-convergence-planning.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines M0 as the repository-convergence and implementation-authority milestone that settles ownership, target structure, contracts, data direction, standards, migration, and readiness before implementation milestones begin.
-->

# M0 Repository Convergence Planning

Parent: [Planning Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. M0 Charter](#3-m0-charter)
- [4. Planning Scope](#4-planning-scope)
- [5. Accepted Baseline](#5-accepted-baseline)
- [6. Source And Delivery Ownership](#6-source-and-delivery-ownership)
- [7. M0 Issue Hierarchy](#7-m0-issue-hierarchy)
- [8. Goal 01 — Canonical Vocabulary And Ownership](#8-goal-01--canonical-vocabulary-and-ownership)
- [9. Goal 02 — Current-State Inventory And Disposition](#9-goal-02--current-state-inventory-and-disposition)
- [10. Goal 03 — Target Repository Topology And Naming](#10-goal-03--target-repository-topology-and-naming)
- [11. Goal 04 — Contract And API Discoverability](#11-goal-04--contract-and-api-discoverability)
- [12. Goal 05 — UI System Readiness And Manual-Review Queue](#12-goal-05--ui-system-readiness-and-manual-review-queue)
- [13. Goal 06 — Database And Persistent-Data Reconciliation](#13-goal-06--database-and-persistent-data-reconciliation)
- [14. Goal 07 — Cross-Capability Integration Boundaries](#14-goal-07--cross-capability-integration-boundaries)
- [15. Goal 08 — Standards And Durable-Policy Promotion](#15-goal-08--standards-and-durable-policy-promotion)
- [16. Goal 09 — Migration, Compatibility, And Cleanup Direction](#16-goal-09--migration-compatibility-and-cleanup-direction)
- [17. Goal 10 — Verification And Implementation Readiness](#17-goal-10--verification-and-implementation-readiness)
- [18. Existing M0 Issue Disposition](#18-existing-m0-issue-disposition)
- [19. Cross-Workstream Dependencies](#19-cross-workstream-dependencies)
- [20. Execution Waves](#20-execution-waves)
- [21. Required M0 Artifact Register](#21-required-m0-artifact-register)
- [22. Decisions And Open Questions](#22-decisions-and-open-questions)
- [23. Risks And Review Requirements](#23-risks-and-review-requirements)
- [24. Tests And Verification](#24-tests-and-verification)
- [25. Documentation Promotion And Synchronization](#25-documentation-promotion-and-synchronization)
- [26. Implementation Variance](#26-implementation-variance)
- [27. Completion And Exit Criteria](#27-completion-and-exit-criteria)
- [28. Post-M0 Readiness Contract](#28-post-m0-readiness-contract)
- [29. Related](#29-related)

## 1. Purpose

Define the M0 milestone as the convergence point between the current Login 2.0 repository and the accepted implementation-ready target state.

M0 exists because the repository already contains substantial application, module, Shared UI, database, documentation, test, operations, and agent-governance work, while several foundational decisions and ownership boundaries remain unsettled or distributed across planning documents.

M0 must convert that state into one coherent implementation authority.

M0 is not merely a planning cleanup milestone. It is the milestone that ensures later implementation work can proceed without repeatedly rediscovering:

- terminology
- architectural ownership
- target folders and namespaces
- contract locations
- database direction
- cross-capability boundaries
- security and operational policy
- migration strategy
- test authority
- manual review requirements

The milestone should leave the repository ready for bounded implementation issues rather than broad exploratory refactors.

## 2. Status

- Planning lifecycle: draft
- Acceptance state: proposed M0 charter
- Current implementation state: pre-M0 repository baseline has been merged into `main`
- Owning GitHub issue: to be created or assigned when this charter is accepted
- GitHub Project or milestone: M0
- Baseline reference: record the exact accepted `main` commit SHA when this document is committed
- Known gaps:
  - the ten M0 parent goal issues do not yet exist
  - issues #1 through #13 have not yet been formally reclassified beneath the goal structure
  - several current standards are draft or incomplete relative to their planning sources
  - the current test suite executes but is not authoritative or fully green
  - the exact target repository structure is not yet accepted
  - UI contract discovery and export behavior are not yet canonical
  - database current-to-target disposition is incomplete

This document owns milestone intent and acceptance structure. It must not become a parallel task board.

## 3. M0 Charter

### 3.1 Goal Statement

Establish one accepted, reviewable, and implementation-ready target state for Login 2.0 across terminology, ownership, repository topology, contracts, persistent data, Shared UI, standards, migration, verification, and delivery governance.

After M0, later milestones must be able to execute bounded work without inferring architecture, policy, data ownership, or UI contracts from obsolete or contradictory sources.

### 3.2 Required Milestone Outcomes

M0 must ensure:

- vocabulary and owner boundaries are settled
- blocking decisions are recorded
- the current repository is inventoried and dispositioned
- the target repository structure and naming are accepted
- planning documents no longer contradict one another
- matrices reflect the accepted target state
- important contracts are discoverable and machine-reviewable
- Carbon-aligned UI elements, components, and patterns have visible lifecycle and review state
- database tables and planned persistent concepts are reconciled
- cross-capability integration boundaries are explicit
- durable requirements are promoted into standards
- standards are independently usable
- migration, compatibility, deprecation, and cleanup direction are explicit
- stale tests and current failures have a documented disposition
- remaining open decisions are explicit and owned
- no implementation milestone must infer policy from obsolete planning
- M1 issues are executable without architecture or policy rediscovery

### 3.3 Milestone Principle

M0 is comprehensive in decisions, inventories, contracts, standards, and migration direction, but restrained in product implementation.

M0 may create small enabling tools when they make repository authority inspectable or enforceable. Examples include:

- contract validators
- deterministic registry exports
- documentation guardrails
- inventory commands
- schema comparison reports
- static manifests generated from canonical sources

M0 should not absorb full feature or capability implementation merely because a tool or review uncovers missing behavior.

## 4. Planning Scope

### 4.1 In Scope

- canonical vocabulary and ownership definitions
- current-state repository inventory
- current-to-target disposition
- target folder and namespace direction
- naming convention normalization
- contract discovery and validation
- UI element, component, and pattern readiness
- manual UI work sequencing
- database table and migration reconciliation
- persistent-data ownership and lifecycle direction
- cross-capability integration boundaries
- security, logging, database, coding, UI, testing, and operations standard promotion
- migration and compatibility strategy
- repository cleanup direction
- test-suite classification and future authority
- GitHub issue, parent/sub-issue, PR, and milestone completion rules
- final M0 acceptance and M1 readiness

### 4.2 Non-Goals

M0 does not generally require:

- completing every physical folder move
- completing every namespace migration
- implementing every Core capability
- rebuilding every Platform surface
- rebuilding every Business Module
- finishing every UI element, component, or pattern
- making every transitional test pass before its target behavior is accepted
- creating every future database migration
- removing every compatibility route or adapter
- implementing every security, monitoring, response, or operational control
- performing final production deployment
- replacing bounded implementation issues with planning prose

### 4.3 Affected Actors, Systems, And Environments

- developers
- manual UI reviewers
- coding agents
- documentation reviewers
- security reviewers
- database reviewers
- local development
- browser review
- CI and automated validation
- staging and production planning
- GitHub Issues, Projects, pull requests, and milestones
- Laravel application runtime
- PostgreSQL
- Redis, queues, scheduler, Reverb, and notifications
- Shared UI and Carbon-aligned component infrastructure

## 5. Accepted Baseline

### 5.1 Baseline Rule

M0 planning must compare against the accepted repository state in `main`, not against uncommitted local history, retired branches, copied reference repositories, or superseded phase and batch documentation.

Record the exact accepted baseline commit here when this charter is merged:

```text
M0 baseline commit: <commit-sha>
M0 baseline date: <yyyy-mm-dd>
```

### 5.2 Baseline Contents

The accepted baseline includes the current:

- application code
- Core and Platform support
- Business Modules
- routes and middleware
- Shared UI elements, components, patterns, contracts, and tests
- Carbon SVG icon library
- JavaScript and CSS runtime behavior
- database migrations and seeders
- test suite
- documentation tree
- runbooks
- `.agents` instructions and skills
- repository configuration
- Docker and local-development support

### 5.3 Baseline Interpretation

Presence in the baseline does not certify that a file or behavior is final, correct, canonical, or retained.

M0 must assign a disposition to material baseline surfaces rather than treating current existence as automatic approval.

## 6. Source And Delivery Ownership

| Source                     | M0 Responsibility                                                                                                |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| This charter               | Milestone intent, ten workstreams, dependency order, required artifacts, and final exit criteria                 |
| Planning documents         | Accepted target state, decomposition, sequence rationale, migration direction, and unresolved planning questions |
| Decision records           | Durable accepted choices and rationale                                                                           |
| Standards                  | Mandatory durable rules, prohibitions, exceptions, and verification requirements                                 |
| Architecture documents     | Accepted implemented or target structural boundaries after promotion                                             |
| Database documents         | Table, field, relationship, scope, retention, and migration contracts                                            |
| Feature and flow documents | User-observable behavior and cross-surface workflows                                                             |
| Runbooks                   | Operational procedures and failure handling                                                                      |
| GitHub Issues              | Bounded work packets, child tasks, acceptance criteria, dependencies, and discussion                             |
| GitHub Projects            | Active status, priority, phase, sequencing, risk, and dependency fields                                          |
| Pull requests and commits  | Reviewable implementation evidence and repository history                                                        |
| Tests and review artifacts | Automated and manual verification evidence                                                                       |

Planning documents do not own current delivery state. GitHub issues do not replace canonical documentation.

## 7. M0 Issue Hierarchy

### 7.1 Required Structure

```text
M0 milestone
  -> M0 repository convergence charter
  -> ten parent goal issues
  -> bounded decision, audit, documentation, tooling, and reconciliation sub-issues
  -> pull requests and commits
```

### 7.2 Parent Goal Issues

Create these parent issues:

1. `[M0 Goal 01] Canonical vocabulary and ownership`
2. `[M0 Goal 02] Current-state inventory and disposition`
3. `[M0 Goal 03] Target repository topology and naming`
4. `[M0 Goal 04] Contract and API discoverability`
5. `[M0 Goal 05] UI system readiness and manual-review queue`
6. `[M0 Goal 06] Database and persistent-data reconciliation`
7. `[M0 Goal 07] Cross-capability integration boundaries`
8. `[M0 Goal 08] Standards and durable-policy promotion`
9. `[M0 Goal 09] Migration, compatibility, and cleanup direction`
10. `[M0 Goal 10] Verification and implementation readiness`

### 7.3 Parent Issue Rules

A parent goal issue must contain only:

- goal statement
- charter section link
- required artifacts
- child issue checklist
- blocking dependencies
- exit criteria
- explicit exclusions
- acceptance-review result

A parent goal issue must not duplicate full planning content.

A parent goal issue must not be treated as one broad coding-agent task.

### 7.4 Child Issue Rules

Each child issue must:

- have one primary parent goal
- define a bounded outcome
- identify affected canonical documents
- identify blocking decisions
- define automated verification
- define manual review where applicable
- identify migration and compatibility impact
- define stop conditions
- avoid implementing unrelated findings

Cross-workstream effects should be represented as dependencies or related issues rather than multiple primary parents.

### 7.5 Parent Acceptance Rule

Closing every child issue is necessary but not sufficient to close a parent goal.

The parent requires an acceptance review confirming that resulting artifacts:

- agree with one another
- use canonical vocabulary
- resolve or explicitly expose remaining decisions
- are linked from relevant indexes
- provide enough authority for downstream work
- do not duplicate another canonical owner
- meet the goal-specific exit criteria

## 8. Goal 01 — Canonical Vocabulary And Ownership

### 8.1 Objective

Settle the language and ownership model used throughout code, documentation, configuration, registries, database contracts, tests, and issues.

### 8.2 Required Outcomes

M0 must define and distinguish:

- Core Capability
- Platform Surface
- Business Module
- Shared UI
- registry
- contribution
- owner key
- instance
- workspace
- tenant
- account
- user
- identity
- service identity
- actor
- UI element
- UI component
- UI pattern
- renderer
- ViewModel or PageData
- configuration owner
- route owner
- permission owner
- notification owner
- audit-event owner
- database owner

For each term, define:

- canonical name
- meaning
- allowed scope
- owner
- forbidden or deprecated synonyms
- current code or documentation mismatches
- propagation requirements

### 8.3 Required Artifacts

- accepted vocabulary and ownership section in the Core Service Build Plan Matrix or a linked canonical matrix
- decision record for Core, Platform, Business Module, and Shared UI vocabulary
- instance/workspace/tenant/account glossary
- owner-key and registry-key convention
- capability and surface ownership matrix
- terminology mismatch inventory

### 8.4 Candidate Child Issues

- Confirm Core Capability, Platform Surface, Business Module, and Shared UI vocabulary.
- Confirm instance, workspace, tenant, account, user, and service identity vocabulary.
- Define owner-key and registry-key formats.
- Reconcile terminology across planning and standards.
- Reconcile terminology across namespaces, configuration, routes, permissions, and tests.
- Produce the accepted ownership matrix.

### 8.5 Dependencies

- none for initial inventory
- Goal 02 provides current mismatch evidence
- all later goals depend on accepted Goal 01 vocabulary

### 8.6 Exit Criteria

- [ ] each material term has one canonical definition
- [ ] each material concept has one primary owner
- [ ] deprecated terminology is explicitly mapped
- [ ] owner-key and registry-key formats are accepted
- [ ] planning matrices use the canonical vocabulary
- [ ] remaining terminology questions are explicit blockers

### 8.7 Non-Goals

- moving every file into its target owner
- renaming every class during this goal
- implementing every registry

## 9. Goal 02 — Current-State Inventory And Disposition

### 9.1 Objective

Create an accurate inventory of the accepted baseline and assign a reviewable disposition to material repository surfaces.

### 9.2 Required Inventory Areas

- root repository files and configuration
- `.agents`, skills, memory, and baselines
- `app/Core`
- `app/Platform`
- `app/Surfaces`
- `app/Http` and other current app folders
- `Modules`
- routes and middleware
- configuration files
- commands, jobs, events, listeners, notifications, and policies
- Blade views and layouts
- UI elements, components, patterns, contracts, references, and tests
- CSS and JavaScript entry points and runtime controls
- database migrations, seeders, factories, and table docs
- test suites and current failures
- standards, planning, architecture, features, flows, database docs, runbooks, and AI working material
- scripts, stubs, Docker, operations, and build tooling

### 9.3 Disposition Vocabulary

Every material surface should receive one of these dispositions:

```text
retain
complete
align
rename
move
replace
migrate
deprecate
delete
investigate
```

The matrix may use a more specific status only when the above mapping remains visible.

### 9.4 Required Artifacts

- master current-state inventory
- current-state disposition matrix
- route and middleware inventory
- code ownership inventory
- UI surface inventory
- database inventory
- test inventory and failure classification
- documentation ownership inventory
- unowned and duplicate surface report

### 9.5 Candidate Child Issues

- Inventory current folders, namespaces, and ownership.
- Inventory routes, middleware, commands, jobs, events, and listeners.
- Inventory Core, Platform, Module, and Shared UI surfaces.
- Inventory UI contracts and references.
- Inventory database tables, migrations, seeders, and documentation.
- Inventory tests and classify failures.
- Inventory documentation and instruction surfaces.
- Produce the master disposition matrix.

### 9.6 Dependencies

- uses the accepted `main` baseline
- may begin before Goal 01 is final
- final classification must be normalized to Goal 01 vocabulary

### 9.7 Exit Criteria

- [ ] material repository surfaces are inventoried
- [ ] each inventory item has an owner or `unowned` status
- [ ] each inventory item has a disposition
- [ ] duplicate and conflicting owners are identified
- [ ] unknowns are converted into bounded investigation issues
- [ ] target-state work can trace back to current-state evidence

### 9.8 Non-Goals

- deleting all obsolete files during inventory
- rewriting implementation merely because a mismatch is found
- treating file count as sufficient inventory evidence

## 10. Goal 03 — Target Repository Topology And Naming

### 10.1 Objective

Define the accepted target structure and naming conventions so future migrations are deterministic.

### 10.2 Target Structure Coverage

M0 must define intended ownership for:

- `app/Core`
- `app/Platform`
- `app/Surfaces`
- `Modules`
- `resources/views`
- `resources/css`
- `resources/js`
- `database`
- `tests`
- `config`
- `routes`
- `docs`
- `.agents`
- `stubs`
- `scripts`
- `ops`

For each major branch, define:

- allowed responsibilities
- forbidden responsibilities
- dependency direction
- contract placement
- implementation placement
- extension and contribution placement
- test placement
- documentation synchronization

### 10.3 Naming Coverage

M0 must settle naming conventions for:

- folders and namespaces
- classes and interfaces
- actions and services
- data objects and DTOs
- enums and value objects
- policies, abilities, roles, and permissions
- routes and route names
- configuration keys
- owner keys and registry keys
- UI slugs and component names
- event and listener names
- job and queue names
- notification type names
- audit-event names
- database tables, columns, indexes, and constraints
- tests and test classes
- documentation file names and canonical paths

### 10.4 Required Artifacts

- accepted target repository tree
- namespace and dependency-direction map
- naming convention standard updates
- current-to-target folder migration matrix
- current-to-target namespace migration matrix
- intentional exception register
- accepted administrative route-prefix decision

### 10.5 Candidate Child Issues

- Finalize target repository folder tree.
- Finalize namespace and dependency-direction rules.
- Normalize file and class naming standards.
- Normalize routes, permissions, configuration, registry, event, and audit naming.
- Define UI slug and contract naming.
- Normalize database naming expectations.
- Decide future administrative URL prefix and compatibility path.
- Produce folder and namespace migration matrices.

### 10.6 Dependencies

- blocked by Goal 01 vocabulary
- informed by Goal 02 inventory
- feeds Goal 04, Goal 05, Goal 06, Goal 08, and Goal 09

### 10.7 Exit Criteria

- [ ] target folder tree is accepted
- [ ] dependency directions are explicit
- [ ] naming conventions cover material repository identifiers
- [ ] current-to-target mappings exist
- [ ] intentional exceptions are documented
- [ ] route-prefix direction is accepted
- [ ] later physical moves do not require new structural decisions

### 10.8 Non-Goals

- performing all moves
- breaking compatibility before migration issues exist
- enforcing cosmetic renames without ownership value

## 11. Goal 04 — Contract And API Discoverability

### 11.1 Objective

Make important contracts discoverable, validated, and machine-reviewable without requiring prior knowledge of every repository path.

### 11.2 Contract Coverage

- Core service contracts
- Platform service contracts
- module package definitions
- registry and contribution contracts
- route and middleware expectations
- UI element contracts
- UI component contracts
- UI pattern contracts
- renderer and ViewModel/PageData contracts
- database table contracts
- configuration contracts
- notification contracts
- event and job contracts
- permission and policy contracts
- audit-event contracts

### 11.3 Shared UI Contract Visibility

The Carbon-aligned UI system must expose enough metadata to review current APIs consistently.

Each registered element, component, or pattern should be able to expose, where applicable:

- canonical slug
- public Blade component name
- lifecycle status
- owner
- summary
- properties
- variants
- states
- slots
- events or JavaScript controls
- dependencies
- related primitives
- test paths
- reference paths
- Carbon source provenance
- known deviations
- accessibility requirements
- manual review status

### 11.4 Machine-Readable Review Surface

M0 should define one deterministic export backed by canonical contract sources.

A candidate command is:

```text
php artisan ui:contracts:export
```

The exact command name is not accepted by this document. Goal 04 must decide it.

The export should:

- produce deterministic JSON
- reject duplicate slugs
- reject missing implementation, test, or reference paths when required
- distinguish elements, components, and patterns
- expose lifecycle and review state
- avoid embedding secrets or environment-specific values
- be suitable for GitHub review and external repository analysis

An optional local-development HTTP viewer or API may use the same registry, but must not become an unauthenticated production API.

### 11.5 Required Artifacts

- contract ownership matrix
- View Surface and Renderer Matrix
- Shared UI contract metadata standard
- contract registry or discovery specification
- deterministic contract export
- duplicate and missing-path validation
- contract lifecycle and versioning rules
- decision on local-development contract viewer/API

### 11.6 Candidate Child Issues

- Add or finalize the View Surface and Renderer Matrix.
- Inventory Core and Platform contracts.
- Inventory module definitions and contribution contracts.
- Define Shared UI contract metadata requirements.
- Implement deterministic UI contract export.
- Add duplicate key and missing-path validation.
- Define contract lifecycle and versioning.
- Decide local-development contract viewer or API direction.

### 11.7 Dependencies

- requires Goal 01 vocabulary
- requires Goal 03 naming and placement direction
- consumes Goal 02 inventory
- supplies Goal 05 readiness data
- supplies Goal 10 verification data

### 11.8 Exit Criteria

- [ ] important contract families have canonical discovery paths
- [ ] UI contracts are machine-reviewable
- [ ] duplicate identities are rejected
- [ ] lifecycle status is visible
- [ ] contract-to-implementation and contract-to-test links are verifiable
- [ ] local-development API direction is accepted or explicitly rejected

### 11.9 Non-Goals

- exposing internal contracts as a public production API
- converting all implementation details into contract metadata
- treating generated output as the canonical source

## 12. Goal 05 — UI System Readiness And Manual-Review Queue

### 12.1 Objective

Establish the authoritative readiness state and dependency order for Carbon-aligned UI elements, components, and patterns so manual design and implementation work can proceed without rediscovery.

### 12.2 Required Readiness Data

Each UI surface should identify:

- canonical slug
- type: element, component, pattern, shell, or URL surface
- implementation path
- contract path
- reference path
- test path
- Carbon source or app-owned source
- dependency list
- lifecycle status
- implementation status
- contract status
- automated-test status
- accessibility-review status
- responsive-review status
- browser-review status
- manual visual-review status
- reuse readiness
- blockers
- superseded or deprecated surfaces

### 12.3 Lifecycle Direction

The readiness model should distinguish at least:

- inventory only
- contract drafted
- implementation partial
- implementation complete
- automated verification incomplete
- manual review required
- approved for reuse
- blocked
- deprecated
- superseded

The exact lifecycle vocabulary must be accepted through Goal 05 and reflected in relevant UI standards.

### 12.4 Manual Pattern Work Queue

M0 should create an ordered manual work queue for pattern families including:

- common actions
- form composition and form actions
- authentication challenges
- account and settings composition
- navigation and menus
- notifications and transient feedback
- loading and asynchronous states
- data display and tables
- pagination and filtering
- empty, error, and restricted states
- destructive actions and confirmations
- upload, download, and export workflows
- shell page headers, page actions, and tabs
- responsive and accessibility review

Manual pattern work may begin during M0 when:

- the pattern has an accepted owner
- required primitives and components are identified
- blocking contract decisions are resolved
- acceptance and manual-review requirements are explicit
- the work does not select unresolved repository-wide architecture

### 12.5 Required Artifacts

- complete UI readiness matrix
- primitive and component dependency map
- pattern family catalog
- manual-review queue
- Carbon provenance and deviation register
- accessibility and responsive review expectations
- UI work authority rules for coding agents
- blocked-surface report

### 12.6 Candidate Child Issues

- Inventory elements, components, patterns, shell surfaces, and URL views.
- Create the UI readiness matrix.
- Reconcile contracts, implementations, references, and tests.
- Create Carbon provenance and deviation records.
- Define UI lifecycle and approval states.
- Define accessibility, responsive, and browser review requirements.
- Create the manual pattern work queue.
- Define coding-agent UI authority and stop conditions.

### 12.7 Dependencies

- requires Goal 01 vocabulary
- consumes Goal 02 UI inventory
- requires Goal 03 placement and naming
- requires Goal 04 contract discovery
- feeds Goal 08 UI standards and Goal 10 verification

### 12.8 Exit Criteria

- [ ] every material UI surface appears in the readiness inventory
- [ ] dependencies and blockers are visible
- [ ] manual work can be sequenced by pattern family
- [ ] approved reuse status is explicit
- [ ] coding-agent design authority is bounded
- [ ] manual review expectations are explicit
- [ ] deprecated and superseded surfaces are identifiable

### 12.9 Non-Goals

- completing every UI surface
- granting coding agents broad design authority
- treating Carbon provenance as automatic acceptance
- replacing manual visual review with metadata alone

## 13. Goal 06 — Database And Persistent-Data Reconciliation

### 13.1 Objective

Reconcile current migrations and tables with accepted capability ownership and target planning so persistent-data implementation can proceed without schema rediscovery.

### 13.2 Required Review Areas

- current migrations
- current database tables
- table contract documentation
- planned tables and persistent concepts
- Core, Platform, Module, instance, workspace, and tenant ownership
- key and relationship design
- uniqueness and indexing
- lifecycle and status fields
- timestamps and deletion behavior
- classification and sensitive fields
- retention and erasure
- audit and evidence requirements
- service identities
- registries
- settings and preferences
- notifications
- identity and access
- exports and files
- compatibility and data migration

### 13.3 Table Disposition Vocabulary

Each current table must be classified as:

- retained unchanged
- retained with alignment
- renamed
- split
- merged
- replaced
- compatibility-only
- retired
- investigate

Each planned persistent concept must identify:

- owner
- target table or storage strategy
- scope
- lifecycle
- key and relationship expectations
- security classification
- retention
- audit requirements
- migration direction

### 13.4 Required Artifacts

- current-versus-target data matrix
- per-table disposition register
- accepted capability-to-table ownership map
- instance/workspace/tenant scope matrix
- migration sequence and compatibility notes
- updated per-table contracts
- audit schema decision
- service-account model decision
- DataGovernance ownership decision and build-matrix updates

### 13.5 Candidate Child Issues

- Promote DataGovernance into the build matrix.
- Decide first Audit schema path.
- Decide service-account model.
- Reconcile all current tables with target capability ownership.
- Complete scope, key, relationship, uniqueness, and index review.
- Complete lifecycle, classification, retention, and audit review.
- Reconcile settings, preferences, notifications, registries, identity, and access tables.
- Update table contracts and migration direction.

### 13.6 Dependencies

- requires Goal 01 ownership vocabulary
- consumes Goal 02 database inventory
- requires Goal 03 naming direction
- coordinates with Goal 07 integration boundaries
- feeds Goal 08 standards and Goal 09 migration

### 13.7 Exit Criteria

- [ ] every current table has a disposition
- [ ] every planned persistent concept has an owner and storage direction
- [ ] scope boundaries are explicit
- [ ] key and relationship expectations are documented
- [ ] retention, classification, and audit expectations are documented
- [ ] Audit and service-account decisions are recorded
- [ ] migration dependencies are explicit
- [ ] later database issues do not need to rediscover target ownership

### 13.8 Non-Goals

- creating every future migration
- migrating production data during M0
- final query optimization for unimplemented features

## 14. Goal 07 — Cross-Capability Integration Boundaries

### 14.1 Objective

Define how capabilities cooperate without duplicating ownership or creating circular dependencies.

### 14.2 Required Capability Boundaries

- Auth
- Identity
- Access
- Security
- DataGovernance
- DataProtection
- Audit
- Monitoring
- Notifications
- Secrets
- Settings
- Preferences
- Registries
- Files and exports
- Jobs and queues
- Scheduler
- APIs and webhooks
- service identities
- Platform Surfaces
- Business Modules

### 14.3 Required Questions

For each material cross-capability workflow, answer:

```text
Who proves identity or assurance?
Who owns lifecycle state?
Who authorizes the action and target?
Who owns classification and movement policy?
Who persists the result?
Who records audit evidence?
Who detects abnormal patterns?
Who sends notifications?
Who owns the user-facing surface?
Who owns operational failure handling?
```

### 14.4 Required Artifacts

- Core capability dependency matrix
- capability producer/consumer matrix
- forbidden dependency and circular-dependency rules
- Auth/Identity/Access/Security boundary contract
- DataGovernance/DataProtection boundary contract
- Audit/Monitoring/Notifications/Response boundary contract
- settings/preferences/registry boundary contract
- service identity, job actor, API, and webhook boundary contract
- Business Module consumption rules

### 14.5 Candidate Child Issues

- Create Core capability dependency matrix.
- Define Auth, Identity, Access, and Security boundaries.
- Define DataGovernance and DataProtection boundaries.
- Define Audit, Monitoring, Notifications, and Incident Response boundaries.
- Define settings, preferences, and registry interactions.
- Define service identity, job actor, command actor, API, and webhook boundaries.
- Define events, listeners, queues, and transaction-boundary expectations.
- Define Business Module consumption and extension rules.

### 14.6 Dependencies

- requires Goal 01 vocabulary
- consumes Goal 02 inventory
- coordinates with Goal 03 placement and Goal 06 data ownership
- blocks final Goal 08 standards promotion
- informs Goal 09 migration sequence

### 14.7 Exit Criteria

- [ ] each material cross-capability responsibility has one primary owner
- [ ] producer and consumer relationships are explicit
- [ ] circular dependencies are identified and forbidden or intentionally mediated
- [ ] module consumption rules are explicit
- [ ] audit, monitoring, and notification ownership are not conflated
- [ ] service and background actors have explicit boundaries

### 14.8 Non-Goals

- implementing every integration
- introducing generalized infrastructure without a concrete runtime job
- using events to hide unresolved ownership

## 15. Goal 08 — Standards And Durable-Policy Promotion

### 15.1 Objective

Promote accepted durable requirements into independently usable standards after the relevant target-state decisions are settled.

### 15.2 Promotion Rule

Promote a planning requirement into a standard when it is:

- prescriptive
- durable
- accepted
- owned
- non-duplicative
- verifiable
- required by implementation or review

Retain in planning when it is:

- an implementation sequence
- a migration strategy
- an unresolved decision
- an implementation alternative
- a candidate class, folder, enum, or schema
- a dependency or rollout note

### 15.3 Standard Families

- security
- identity and access
- data protection and governance
- logging, audit, and monitoring
- database
- coding and file building
- testing
- UI and accessibility
- documentation
- runtime and deployment
- reliability, concurrency, and idempotency
- errors and exceptions
- agent and repository workflow

### 15.4 Standard Independence Rule

A standard is independently usable when an implementer can determine:

- mandatory rules
- prohibited behavior
- ownership boundaries
- minimum verification
- exception handling
- related canonical owners

without reading a large planning document to discover accepted policy.

### 15.5 Required Artifacts

- planning-to-standard promotion matrix
- standards overlap and ownership matrix
- updated security and logging standards
- updated database standards
- updated coding, file-building, and testing standards
- updated UI and accessibility standards
- updated runtime, deployment, and operations standards
- supersession and archival register
- final standard independence review

### 15.6 Candidate Child Issues

- Audit issues #9 and #10 against current `main` and close or revise them.
- Promote security planning into complete security standards.
- Reconcile Audit Logging and Monitoring standards.
- Reconcile database standards against accepted data direction.
- Reconcile UI standards against current contracts and Carbon alignment.
- Reconcile testing standards against the post-M0 test model.
- Promote runtime, deployment, and operations requirements.
- Remove duplicate or contradictory authority from planning.
- Perform final standards independence review.

### 15.7 Dependencies

- blocked by relevant decisions in Goals 01, 03, 06, and 07
- consumes Goal 02 contradiction inventory
- feeds Goal 09 migration constraints and Goal 10 verification gates

### 15.8 Exit Criteria

- [ ] durable accepted requirements are promoted
- [ ] standards are independently usable
- [ ] duplicate authority is removed or superseded
- [ ] planning links to standards instead of restating accepted policy unnecessarily
- [ ] verification requirements are concrete
- [ ] unresolved decisions remain explicit in planning
- [ ] standard lifecycle statuses are accurate

### 15.9 Non-Goals

- copying planning documents wholesale into standards
- promoting unresolved choices
- implementing all controls described by the standards

## 16. Goal 09 — Migration, Compatibility, And Cleanup Direction

### 16.1 Objective

Define how the accepted current repository converges toward the target state without unreviewed breaking changes or indefinite transitional duplication.

### 16.2 Accepted Migration Strategy Vocabulary

Use a limited set of explicit migration strategies:

- direct move
- direct rename
- compatibility alias
- adapter
- parallel old/new implementation
- data migration
- route transition
- deprecation window
- replacement and deletion
- intentional long-term compatibility

### 16.3 Required Migration Areas

- folders and namespaces
- Core and Platform capability placement
- Module boundaries
- routes and route names
- permissions and owner keys
- registries and contributions
- UI contract shapes
- database tables and data
- service identities
- audit schemas
- configuration keys
- events, jobs, and queues
- tests
- documentation and runbooks

### 16.4 Cleanup Classification

Classify obsolete or transitional material as:

- delete now
- delete after replacement
- archive outside active authority
- retain as historical evidence
- supersede with a pointer
- retain temporarily for compatibility
- investigate before action

### 16.5 Required Artifacts

- accepted migration strategy definitions
- ordered repository migration plan
- folder and namespace migration sequence
- route compatibility and deprecation plan
- database compatibility and data migration plan
- contract and registry transition plan
- test migration and retirement plan
- repository cleanup queue
- compatibility removal criteria
- rollback and stop conditions

### 16.6 Candidate Child Issues

- Define migration and compatibility strategy vocabulary.
- Produce ordered folder and namespace migration plan.
- Define route transition and deprecation policy.
- Define database compatibility and data migration policy.
- Define contract and registry transition rules.
- Classify obsolete code, routes, tests, docs, and compatibility layers.
- Create cleanup queue and removal criteria.
- Define rollback and stop conditions for structural migrations.

### 16.7 Dependencies

- requires Goal 02 disposition evidence
- requires Goal 03 target topology
- requires Goal 06 data direction
- requires Goal 07 integration boundaries
- must respect Goal 08 standards

### 16.8 Exit Criteria

- [ ] each material transition has a named migration strategy
- [ ] migration order and dependencies are explicit
- [ ] compatibility behavior has owners and removal criteria
- [ ] cleanup items have bounded issues or accepted retention
- [ ] rollback and stop conditions are documented
- [ ] later migration issues do not need to select new architecture

### 16.9 Non-Goals

- performing all migrations
- deleting compatibility before replacement verification
- mixing unrelated cleanup into structural PRs

## 17. Goal 10 — Verification And Implementation Readiness

### 17.1 Objective

Define the evidence, test authority, manual review, issue structure, and final acceptance required before implementation milestones begin.

### 17.2 Traceability Direction

Target traceability:

```text
decision
  -> planning owner
  -> standard
  -> architecture, data, UI, or feature contract
  -> implementation issue
  -> automated verification
  -> manual review where required
```

This does not require a dedicated database record for every requirement. It requires reviewable navigation from intent to evidence.

### 17.3 Test-Suite Reconciliation

Inventory every current test and classify it as:

- retain unchanged
- update for accepted target behavior
- replace
- move
- delete as obsolete
- temporarily blocked by a decision
- investigate as a possible regression

The review must distinguish:

- behavioral tests
- authorization and security tests
- integration tests
- contract tests
- markup and structure assertions
- browser tests
- manual visual review
- transitional compatibility tests

### 17.4 Required Green Gates

Goal 10 must define which suites must be green before M1 begins.

At minimum, evaluate gates for:

- authentication and authorization
- security headers and runtime checks
- database migration integrity
- module and registry integrity
- contract discovery validation
- targeted Shared UI contract tests
- documentation guardrails
- production asset build
- browser review smoke coverage

The exact gate set must reflect accepted M0 target behavior rather than stale transitional assertions.

### 17.5 Delivery Governance

Define:

- parent and child issue usage
- project fields
- dependency status
- decision-blocked status
- PR completion evidence
- merge requirements
- documentation synchronization
- manual review recording
- milestone acceptance review
- M1 issue template

### 17.6 Required Artifacts

- reconciled test inventory
- current failure classification
- authoritative suite and gate definition
- manual review matrix
- corrected test discovery and naming
- M1 implementation issue template
- PR completion-evidence template
- M0 final acceptance checklist
- M0 contradiction and readiness audit
- accepted M0 baseline reference

### 17.7 Candidate Child Issues

- Audit issues #4, #8, #11, #12, and #13 against current `main` and close or revise them.
- Reconcile and normalize the pre-M0 test suite.
- Fix test discovery, namespaces, and class/file naming.
- Define authoritative suites and required green gates.
- Define manual review ownership and evidence.
- Update GitHub Project workflow documentation for parent/sub-issue workstreams.
- Create M1 issue and PR evidence templates.
- Perform M0 final contradiction and readiness audit.
- Freeze and record the accepted M0 baseline.

### 17.8 Dependencies

- consumes the outputs of all other goals
- some agent and workflow child issues may close early
- final readiness acceptance occurs last

### 17.9 Exit Criteria

- [ ] current tests are classified
- [ ] unexplained failures do not remain
- [ ] authoritative green gates are defined and met or explicitly blocked
- [ ] manual review requirements are defined
- [ ] issue and PR evidence requirements are documented
- [ ] M1 issues are executable without rediscovery
- [ ] final M0 acceptance review is complete
- [ ] accepted M0 baseline is versioned and recorded

### 17.10 Non-Goals

- preserving obsolete tests solely to maintain historical count
- requiring all transitional tests to pass before target behavior is accepted
- allowing implementation milestones to redefine verification policy silently

## 18. Existing M0 Issue Disposition

This is the initial mapping of issues #1 through #13. Final closure or revision requires review against current `main`.

| Issue | Current Title                                                | Primary Parent Goal | Initial Disposition                  | Required Review                                                       |
| ----- | ------------------------------------------------------------ | ------------------- | ------------------------------------ | --------------------------------------------------------------------- |
| #1    | Confirm Core, Platform, and Business Module vocabulary       | Goal 01             | Retain and revise                    | Expand definitions, owner keys, and related vocabulary                |
| #2    | Promote DataGovernance into the build matrix                 | Goal 06             | Retain and revise                    | Confirm target ownership and matrix coverage                          |
| #3    | Add View Surface and Renderer Matrix                         | Goal 04             | Retain and revise                    | Keep contract ownership primary; relate to Goal 05 readiness          |
| #4    | Create GitHub Project workflow documentation                 | Goal 10             | Retain and revise                    | Add parent/sub-issue, dependency, evidence, and acceptance rules      |
| #5    | Choose future admin URL prefix                               | Goal 03             | Retain                               | Link route compatibility work to Goal 09                              |
| #6    | Choose first audit schema path                               | Goal 06             | Retain                               | Propagate into data, standards, and migration owners                  |
| #7    | Choose service account model strategy                        | Goal 06             | Retain                               | Propagate into identity, access, security, data, and migration owners |
| #8    | Replace root AGENTS.md with GitHub Project workflow guidance | Goal 10             | Audit for closure or narrow revision | Root guidance changed in the baseline                                 |
| #9    | Normalize coding and file-building standards                 | Goal 08             | Audit for closure or narrow revision | Major standards rewrites exist in `main`                              |
| #10   | Add file archetype standard                                  | Goal 08             | Audit for closure or narrow revision | `File Archetypes.md` exists in `main`                                 |
| #11   | Add agent implementation checklist                           | Goal 10             | Audit for closure or narrow revision | Checklist exists in `main`                                            |
| #12   | Add first-pass folder AGENTS.md routing files                | Goal 10             | Audit for closure or narrow revision | Verify every required path and routing rule                           |
| #13   | Add login2-file-implementation skill                         | Goal 10             | Audit for closure or narrow revision | Verify exact skill content against exit criteria                      |

### 18.1 Issue Reconciliation Rule

Do not leave an issue open with obsolete acceptance criteria after the baseline already satisfies most of its scope.

For each issue:

- close as completed when all exit criteria are met
- revise to the exact remaining gap when partially complete
- split when multiple independent outcomes remain
- close as not planned when the accepted M0 model supersedes the issue
- preserve decision issues until a durable decision is recorded and propagated

## 19. Cross-Workstream Dependencies

### 19.1 Primary Dependency Flow

```text
Goal 01 vocabulary and ownership
  -> Goal 03 topology and naming
  -> Goal 04 contract discoverability
  -> Goal 05 UI readiness

Goal 02 current-state inventory
  -> Goal 03 target mapping
  -> Goal 05 UI readiness
  -> Goal 06 database reconciliation
  -> Goal 09 migration and cleanup

Goal 01 + Goal 02
  -> Goal 06 database reconciliation
  -> Goal 07 integration boundaries

Goals 03 + 06 + 07
  -> Goal 08 standards promotion
  -> Goal 09 migration direction

Goals 01 through 09
  -> Goal 10 final readiness
```

### 19.2 Parallel Work Rules

- Goal 01 and Goal 02 may begin in parallel.
- Goal 03 may draft alternatives before Goal 01 is final but may not accept terminology-dependent structure prematurely.
- Goal 04 and Goal 05 may inventory current UI surfaces before Goal 03 is final.
- Goal 06 may inventory tables before owner boundaries are final.
- Goal 08 may audit current standards early but should not finalize decision-dependent requirements before Goals 01, 03, 06, and 07.
- Goal 10 may close already-completed agent-governance issues early, but final readiness occurs after all parent goals complete acceptance review.

## 20. Execution Waves

### 20.1 Wave 0 — Charter And Existing-Issue Reconciliation

- accept this M0 charter
- create ten parent goal issues
- map issues #1 through #13 to primary parents
- audit #8 through #13 against current `main`
- close or revise already-satisfied work
- record the exact M0 baseline commit

### 20.2 Wave 1 — Foundation

Run in parallel:

- Goal 01 vocabulary and ownership
- Goal 02 current-state inventory and disposition

Required result:

- accepted terms and owners
- complete enough baseline inventory to support target-state decisions

### 20.3 Wave 2 — Target-State Definition

Run with explicit dependencies:

- Goal 03 topology and naming
- Goal 04 contract discoverability
- Goal 05 UI readiness
- Goal 06 database reconciliation
- Goal 07 integration boundaries

Manual UI pattern work may begin within Goal 05 when its dependencies are accepted.

### 20.4 Wave 3 — Authority And Convergence

- Goal 08 standards promotion
- Goal 09 migration, compatibility, and cleanup direction

Required result:

- independently usable standards
- ordered convergence plan

### 20.5 Wave 4 — Readiness Gate

- Goal 10 test authority
- final issue and PR workflow
- contradiction audit
- parent goal acceptance reviews
- M0 baseline freeze
- M1 readiness package

## 21. Required M0 Artifact Register

The exact canonical paths may be adjusted during Goal 01 and Goal 03, but one canonical owner must exist for each concern.

| Artifact                              | Proposed Canonical Owner                                     | Required By         | Notes                                                     |
| ------------------------------------- | ------------------------------------------------------------ | ------------------- | --------------------------------------------------------- |
| M0 Repository Convergence Planning    | This document                                                | Wave 0              | Milestone charter                                         |
| Vocabulary and ownership matrix       | Core Service Build Plan Matrix or linked architecture matrix | Goal 01             | Do not duplicate definitions across multiple matrices     |
| Current-state disposition matrix      | `docs/07-planning/00-overview/`                              | Goal 02             | Repository-wide inventory and disposition                 |
| Target repository tree                | Architecture-boundary planning                               | Goal 03             | Include dependency direction                              |
| Folder and namespace migration matrix | Migration planning                                           | Goal 03 and Goal 09 | Current-to-target map                                     |
| View Surface and Renderer Matrix      | Platform-surface planning                                    | Goal 04             | Includes ViewModel/PageData and renderer ownership        |
| Shared UI contract export             | Repository tooling backed by canonical contracts             | Goal 04             | Generated output is non-canonical                         |
| UI readiness matrix                   | Shared UI planning                                           | Goal 05             | Includes manual review and Carbon provenance              |
| Manual pattern work queue             | Shared UI planning plus GitHub issues                        | Goal 05             | GitHub owns active status                                 |
| Current-versus-target data matrix     | Database planning and table contracts                        | Goal 06             | Include scope and migration direction                     |
| Capability dependency matrix          | Core planning                                                | Goal 07             | Producer, consumer, authorization, evidence, notification |
| Planning-to-standard promotion matrix | M0 overview or standards index                               | Goal 08             | Track retain, promote, supersede, or delete               |
| Ordered migration and cleanup plan    | Migration planning                                           | Goal 09             | Includes compatibility removal criteria                   |
| Test inventory and authority matrix   | Testing planning and standards                               | Goal 10             | Classify stale and blocked tests                          |
| M1 implementation issue template      | GitHub workflow documentation                                | Goal 10             | Required inputs, evidence, and stop conditions            |
| M0 final acceptance report            | `docs/11-ai/active-doc-reviews/` or accepted review location | Goal 10             | Non-canonical review evidence linked from parent issues   |

## 22. Decisions And Open Questions

| Item                                                            | Type                    | Primary Goal | Required By          | Resolution Or Next Action                    |
| --------------------------------------------------------------- | ----------------------- | ------------ | -------------------- | -------------------------------------------- |
| Final Core, Platform, Business Module, and Shared UI vocabulary | Decision                | Goal 01      | Goal 03 onward       | Resolve through issue #1 and decision record |
| Instance, workspace, tenant, account, and user vocabulary       | Decision                | Goal 01      | Goals 03, 06, and 07 | Create bounded decision issue                |
| Owner-key and registry-key format                               | Decision                | Goal 01      | Goals 03, 04, and 07 | Create bounded decision issue                |
| Future administrative URL prefix                                | Decision                | Goal 03      | Goal 09              | Resolve through issue #5                     |
| UI contract export command and format                           | Decision                | Goal 04      | Goal 05 and Goal 10  | Define deterministic schema and command      |
| Local-development UI contract viewer/API                        | Decision                | Goal 04      | Optional M0 tooling  | Accept, defer, or reject explicitly          |
| UI lifecycle and approval vocabulary                            | Decision                | Goal 05      | Goal 08 and Goal 10  | Accept one shared readiness model            |
| DataGovernance target ownership                                 | Decision                | Goal 06      | Goals 07 and 08      | Resolve through issue #2                     |
| First Audit schema path                                         | Decision                | Goal 06      | Goals 08 and 09      | Resolve through issue #6                     |
| Service-account model                                           | Decision                | Goal 06      | Goals 07, 08, and 09 | Resolve through issue #7                     |
| Required green suites before M1                                 | Decision                | Goal 10      | M0 completion        | Define after test reconciliation             |
| Exact M0 baseline commit                                        | Administrative decision | Goal 10      | M0 acceptance        | Record when this charter is merged           |

Promote durable accepted decisions according to Decision Record Standards.

## 23. Risks And Review Requirements

| Risk                                                | Impact                                          | Mitigation                                                                            | Review Owner           |
| --------------------------------------------------- | ----------------------------------------------- | ------------------------------------------------------------------------------------- | ---------------------- |
| M0 becomes an indefinite architecture rewrite       | Implementation remains blocked                  | Enforce bounded child issues, non-goals, and wave exits                               | M0 owner               |
| Parent goals duplicate canonical planning           | Conflicting authority                           | Parent issues link to charter and artifacts rather than restating them                | Docs owner             |
| Current state is mistaken for accepted target state | Legacy structures become permanent accidentally | Require explicit disposition and target review                                        | Architecture owner     |
| Standards are promoted before decisions settle      | Rework and contradiction                        | Gate decision-dependent promotion behind Goals 01, 03, 06, and 07                     | Standards owners       |
| Planning is copied wholesale into standards         | Standards remain bloated or contradictory       | Use promotion classification and independence review                                  | Docs and domain owners |
| Standards remain too skeletal                       | Implementation still infers policy              | Require independent usability and verification criteria                               | Domain owners          |
| UI metadata replaces manual design review           | Visual and interaction quality regresses        | Preserve manual review states and authority limits                                    | UI owner               |
| Generated contract export becomes canonical         | Drift between source and output                 | Contracts remain canonical; export is reproducible evidence                           | UI and tooling owners  |
| Database planning ignores current migrations        | Migration failures and duplicate tables         | Require current-versus-target matrix and table disposition                            | Database owner         |
| Test cleanup hides real regressions                 | Security or behavioral defects survive          | Classify possible regressions separately from stale assertions                        | Test and domain owners |
| Migration plan lacks compatibility removal criteria | Transitional duplication becomes permanent      | Require owners, expiry conditions, and deletion issues                                | Architecture owner     |
| Agent work expands beyond issue scope               | Unreviewed architecture changes                 | Enforce local `AGENTS.md`, skills, stop conditions, and PR evidence                   | Repository owner       |
| M0 creates too many documents                       | Navigation and maintenance burden               | Prefer existing canonical owners and matrices; create only when ownership is distinct | Docs owner             |

## 24. Tests And Verification

### 24.1 Automated Verification

M0 should establish and use automated checks for:

- documentation guardrails
- broken canonical links where tooling exists
- contract duplicate identities
- contract missing paths
- deterministic contract export
- route ownership completeness
- module and registry ownership integrity
- database migration integrity
- schema and table-contract consistency where practical
- naming and namespace rules where practical
- required test discovery
- production asset build
- targeted security and authorization behavior

### 24.2 Manual Verification

Manual review is required for:

- vocabulary clarity
- ownership conflicts
- target repository structure
- UI visual and interaction quality
- accessibility behavior not fully represented by automated tests
- responsive behavior
- migration sequencing
- destructive cleanup
- standard independence
- final M1 issue executability

### 24.3 Operational Exercises

Where applicable, verify:

- local Docker startup
- local browser review
- Reverb and notification transport
- database reset and migration readiness
- queue and scheduler assumptions
- deterministic export commands
- safe failure behavior for repository tooling

### 24.4 Documentation Guardrails

Before a parent goal closes:

- canonical paths must resolve
- indexes must link to accepted artifacts
- metadata lifecycle status must be accurate
- superseded documents must not remain active authorities
- planning and standards must not contradict each other
- issues must link to canonical owners

## 25. Documentation Promotion And Synchronization

### 25.1 Create

Expected new or newly formalized planning artifacts may include:

- this M0 charter
- current-state disposition matrix
- UI readiness matrix
- capability dependency matrix
- test authority matrix
- ordered migration and cleanup plan

Create only when an existing canonical owner cannot absorb the concern cleanly.

### 25.2 Update

Expected updates include:

- `docs/07-planning/index.md`
- `docs/07-planning/core-service-build-plan-matrix.md`
- architecture-boundary planning
- platform-surface planning
- database table and feature contracts
- security and logging standards
- coding and testing standards
- UI standards and contract requirements
- documentation and GitHub workflow standards
- root and folder-level `AGENTS.md`
- `.agents/skills/` where repeatable workflow changes are accepted

### 25.3 Supersede, Archive, Or Delete

M0 should identify and act on:

- obsolete planning authority
- duplicate standards
- stale test contracts
- retired route and folder documentation
- transitional compatibility docs after replacement
- generated aggregates
- abandoned review material

Historical evidence should remain outside active canonical authority when retention is useful.

### 25.4 Agent And Repository Instructions

Agent instructions must:

- route to accepted canonical standards and planning
- require issue and owner identification
- require file archetype identification
- require local `AGENTS.md` review
- require relevant tests and docs sync
- define manual UI review limits
- stop when architecture or policy decisions are unresolved

## 26. Implementation Variance

Record material accepted differences from this charter without using this section as a chronological worklog.

| Date | Variance | Reason | Accepted By | Affected Issues Or Docs |
| ---- | -------- | ------ | ----------- | ----------------------- |
| —    | —        | —      | —           | —                       |

## 27. Completion And Exit Criteria

M0 is complete when all of the following are true.

### 27.1 Vocabulary And Ownership

- [ ] canonical vocabulary is accepted
- [ ] material concepts have one primary owner
- [ ] owner-key and registry-key conventions are accepted
- [ ] deprecated terminology is mapped

### 27.2 Current And Target State

- [ ] the current repository is inventoried
- [ ] material surfaces have a disposition
- [ ] the target repository structure is accepted
- [ ] naming conventions are accepted
- [ ] current-to-target migration mappings exist

### 27.3 Contracts And Shared UI

- [ ] important contracts are discoverable
- [ ] Shared UI contracts are machine-reviewable
- [ ] UI readiness and blockers are visible
- [ ] manual pattern work is sequenced
- [ ] manual review authority is explicit

### 27.4 Data And Integration

- [ ] current tables have dispositions
- [ ] planned persistent concepts have owners and storage direction
- [ ] scope, lifecycle, classification, retention, and audit expectations are explicit
- [ ] cross-capability producer and consumer boundaries are accepted
- [ ] Audit and service-account decisions are recorded

### 27.5 Standards And Migration

- [ ] durable accepted requirements are promoted
- [ ] standards are independently usable
- [ ] planning documents no longer contradict one another
- [ ] matrices reflect the accepted target state
- [ ] migration and compatibility strategies are explicit
- [ ] cleanup and compatibility removal criteria are explicit

### 27.6 Verification And Delivery

- [ ] current tests are classified
- [ ] authoritative suites and required green gates are defined
- [ ] remaining failures are explained, owned, or decision-blocked
- [ ] GitHub parent/sub-issue workflow is documented
- [ ] PR completion evidence is defined
- [ ] M1 issue template is ready
- [ ] all ten parent goals have completed acceptance review
- [ ] remaining open decisions are explicit and owned
- [ ] the accepted M0 baseline is versioned and recorded

### 27.7 Final Milestone Rule

No implementation milestone may be required to infer architecture, policy, data ownership, UI contract, or migration direction from obsolete planning after M0 closes.

## 28. Post-M0 Readiness Contract

A post-M0 implementation issue must be able to identify:

- accepted target behavior
- primary owner layer
- target folder and namespace
- applicable contracts
- affected database objects
- dependencies
- migration strategy
- compatibility requirements
- applicable standards
- expected automated tests
- required manual review
- documentation synchronization
- explicit non-goals
- stop conditions

M1 should not reopen M0 decisions through ordinary implementation issues.

A material exception discovered after M0 must be handled through:

- a decision record when architecture or policy changes
- a planning variance when sequence or migration changes
- a standards update when durable policy changes
- a bounded implementation issue when the accepted target remains unchanged

## 29. Related

- [Planning Index](../index.md)
- [Core Service Build Plan Matrix](../core-service-build-plan-matrix.md)
- [Application Structure Baseline Planning](../01-architecture-boundaries/application-structure-baseline-planning.md)
- [Core Capability Package Migration Planning](../01-architecture-boundaries/core-capability-package-migration-planning.md)
- [View Surface Composition Planning](../03-platform-surfaces/view-surface-composition-planning.md)
- [Planning Documentation Standards](../../02-standards/documentation/Planning%20Documentation%20Standards.md)
- [Decision Record Standards](../../02-standards/documentation/Decision%20Record%20Standards.md)
- [Document Type Standards](../../02-standards/documentation/Document%20Type%20Standards.md)
- [Implementation Status And Development Sync Standard](../../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Planning Template](../../09-reference/templates/docs/_planning.md)
- [Decisions Index](../../01-decisions/index.md)
- [Architecture Index](../../03-architecture/index.md)
- [Database Index](../../06-database/index.md)
- [Runbook Index](../../10-runbooks/index.md)
- GitHub issues #1 through #13
