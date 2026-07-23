<!--
DOC-META
title: Decision Record Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Decision Record Standards.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines decision-record elevation, numbering, status, content, acceptance, amendment, supersession, review, and canonical-owner synchronization requirements.
-->

# Decision Record Standards

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Definition](#3-definition)
- [4. Core Rules](#4-core-rules)
- [5. Elevation Gate](#5-elevation-gate)
- [6. Decisions That Normally Stay Local](#6-decisions-that-normally-stay-local)
- [7. Decision Record Types](#7-decision-record-types)
- [8. Identifier And Filename](#8-identifier-and-filename)
- [9. Metadata](#9-metadata)
- [10. Decision Status](#10-decision-status)
  - [10.1. Proposed](#101-proposed)
  - [10.2. Accepted](#102-accepted)
  - [10.3. Rejected](#103-rejected)
  - [10.4. Deprecated](#104-deprecated)
  - [10.5. Superseded](#105-superseded)
- [11. Acceptance Authority](#11-acceptance-authority)
- [12. Required Decision Content](#12-required-decision-content)
  - [12.1. Decision Status](#121-decision-status)
  - [12.2. Date](#122-date)
  - [12.3. Decision Owner](#123-decision-owner)
  - [12.4. Related Work](#124-related-work)
  - [12.5. Context](#125-context)
  - [12.6. Decision Drivers](#126-decision-drivers)
  - [12.7. Decision](#127-decision)
  - [12.8. Scope And Boundaries](#128-scope-and-boundaries)
  - [12.9. Alternatives Considered](#129-alternatives-considered)
  - [12.10. Consequences](#1210-consequences)
  - [12.11. Implementation Implications](#1211-implementation-implications)
  - [12.12. Canonical Documentation Updates](#1212-canonical-documentation-updates)
  - [12.13. Verification](#1213-verification)
  - [12.14. Supersession](#1214-supersession)
- [13. Relationship To Planning](#13-relationship-to-planning)
- [14. Relationship To Canonical Owners](#14-relationship-to-canonical-owners)
- [15. Relationship To GitHub Issues And PRs](#15-relationship-to-github-issues-and-prs)
- [16. Amendments](#16-amendments)
- [17. Rejection](#17-rejection)
- [18. Deprecation And Supersession](#18-deprecation-and-supersession)
- [19. Decision Index](#19-decision-index)
- [20. Security And Sensitive Decisions](#20-security-and-sensitive-decisions)
- [21. Decision Review](#21-decision-review)
- [22. Completion Criteria](#22-completion-criteria)
  - [22.1. Proposed](#221-proposed)
  - [22.2. Accepted](#222-accepted)
  - [22.3. Rejected, Deprecated, Or Superseded](#223-rejected-deprecated-or-superseded)
- [23. Related](#23-related)

## 1. Purpose

Define when a durable decision must be elevated into `docs/01-decisions/` and how decision records are proposed, accepted, named, maintained, superseded, and linked to current-state documentation.

This standard applies the baseline `decision` contract from:

- [Document Type Standards](Document%20Type%20Standards.md)

## 2. Scope

This standard applies to elevated decisions involving:

- architecture
- product behavior
- security
- privacy and data governance
- database strategy
- operational strategy
- documentation governance
- coding-agent governance
- cross-module or cross-capability ownership
- long-lived delivery or compatibility direction

It does not require a decision record for every implementation choice.

## 3. Definition

A decision record preserves:

- the context that required a decision
- the selected decision
- important alternatives
- consequences
- affected owners
- lifecycle and replacement history

Decision records explain why a durable choice was made.

Canonical architecture, feature, database, standard, and runbook documents explain what is true now.

## 4. Core Rules

Use a decision record when durable rationale must survive beyond the immediate issue or planning document.

A decision record must:

- have one stable identifier
- have an explicit decision status
- identify the decision owner
- link to affected canonical owners
- distinguish decision rationale from implementation detail
- preserve accepted history
- identify supersession or deprecation clearly

A decision record must not:

- replace current-state documentation
- become an implementation plan
- become an issue checklist
- be rewritten later to hide the original accepted decision
- be marked accepted by an agent without explicit acceptance authority
- contain credentials, secrets, or restricted evidence

## 5. Elevation Gate

Elevate a decision when one or more of these apply:

- it affects multiple canonical branches
- it affects multiple Core capabilities, Modules, UI responsibilities, or Laravel integration boundaries
- it establishes a long-lived technical or product direction
- it establishes a security, privacy, or data-governance rule with broad impact
- it changes a platform-wide ownership boundary
- it introduces significant operational or migration consequences
- it supersedes an earlier accepted decision
- it needs explicit proposal and acceptance history
- future contributors will need the rationale to interpret current structure
- reversal would require material migration, compatibility, or coordination work

## 6. Decisions That Normally Stay Local

Keep a decision in the canonical owner, issue, or implementation when all of these are true:

- it affects one narrow owner
- it does not establish a reusable rule
- it is easily reversible
- it does not supersede an accepted decision
- future contributors do not need separate rationale
- current-state documentation is sufficient

Examples may include:

- a local class name
- a private method structure
- a small query implementation
- an internal layout adjustment
- a test organization choice
- an issue-specific sequence with no lasting consequence

Do not create ADRs merely to document normal engineering judgment.

## 7. Decision Record Types

All elevated decision records use `doc_type: decision`.

The subject may be:

- architecture decision
- product decision
- security decision
- privacy or data-governance decision
- database decision
- operational decision
- documentation-governance decision
- coding-agent governance decision

Do not create separate numbering systems by subject unless a future accepted decision establishes them.

## 8. Identifier And Filename

Use one repository-wide sequential identifier:

- `ADR-0001`
- `ADR-0002`
- `ADR-0003`

Use four digits.

Use the filename pattern:

    adr-0001-decision-title.md

Use the H1 pattern:

    # ADR-0001: Decision Title

Rules:

- inspect `docs/01-decisions/` and its index before assigning an ID
- assign the next unused sequential ID
- never reuse an ID
- never renumber accepted, rejected, deprecated, superseded, or archived records
- preserve gaps when a proposed record is removed
- use a stable descriptive title
- do not encode lifecycle status in the filename

Concurrent writers must serialize final ID assignment.

## 9. Metadata

Decision records must normally use:

- `doc_type: decision`
- the smallest accurate owner
- `canonical: true`
- `parent: docs/01-decisions/index.md`
- `template: docs/09-reference/templates/docs/_decision.md`

Use `DOC-META.status` for document lifecycle.

Use the visible `## Decision Status` section for decision lifecycle.

Do not add an unsupported metadata field solely for decision status.

## 10. Decision Status

Use one visible decision status:

- `Proposed`
- `Accepted`
- `Rejected`
- `Deprecated`
- `Superseded`

### 10.1. Proposed

The decision is under review and must not be treated as accepted direction.

Recommended document metadata:

- `status: draft`

### 10.2. Accepted

The authorized owner accepted the decision.

Recommended document metadata:

- `status: active`

### 10.3. Rejected

The proposal was considered and declined.

Retain it only when the rationale remains useful.

Recommended document metadata:

- `status: archived`

### 10.4. Deprecated

The decision remains historically important but is discouraged, partially retired, or scheduled for replacement.

Use:

- `status: active` while any part remains operative
- `status: archived` after it is no longer operative and has no replacement
- `status: superseded` when a replacement decision exists

### 10.5. Superseded

A newer decision replaces it.

Required document metadata:

- `status: superseded`

The record must link to the replacement.

## 11. Acceptance Authority

A decision record may be accepted only by the human or governance authority responsible for the affected scope.

The record must identify:

- decision owner
- required reviewers
- acceptance source

Acceptance evidence may include:

- explicit issue approval
- approved PR
- recorded architecture review
- approved security or privacy review
- explicit operator or product-owner decision

An agent may:

- draft a proposed decision
- analyze alternatives
- identify consequences
- prepare canonical updates

An agent must not independently change `Proposed` to `Accepted` unless the work packet includes explicit acceptance.

## 12. Required Decision Content

A materially complete decision record must include the following information.

### 12.1. Decision Status

State the current decision lifecycle.

### 12.2. Date

Record:

- proposal date
- acceptance, rejection, deprecation, or supersession date when applicable

### 12.3. Decision Owner

Identify the responsible human or governance role.

### 12.4. Related Work

Link applicable:

- GitHub issue
- planning document
- prior decision
- PR
- affected canonical owners

### 12.5. Context

Describe:

- the problem
- why a decision is needed
- current constraints
- relevant facts
- consequences of not deciding

Keep supporting research in reference documents when it is large.

### 12.6. Decision Drivers

Identify the criteria that materially affect the choice.

Examples include:

- security
- isolation
- maintainability
- compatibility
- cost
- performance
- operability
- migration complexity
- accessibility
- vendor constraints
- delivery risk

### 12.7. Decision

State the selected direction clearly.

Use direct language:

> Login 2.0 will...

Avoid vague preference language.

### 12.8. Scope And Boundaries

State:

- what the decision governs
- what it does not govern
- affected owners
- environments or tenants affected
- compatibility limits

### 12.9. Alternatives Considered

Record credible alternatives.

For each material alternative, state why it was not selected.

Do not invent weak alternatives solely to fill the section.

### 12.10. Consequences

Identify:

- positive consequences
- negative consequences
- neutral tradeoffs
- migration effects
- operational effects
- security and data effects
- future constraints
- follow-up work

### 12.11. Implementation Implications

Identify:

- required implementation areas
- required migrations
- compatibility behavior
- deployment or rollback implications
- issues that must be created
- specialist review

Do not turn this section into a full implementation plan.

### 12.12. Canonical Documentation Updates

Identify affected:

- standards
- architecture
- features
- flows
- database contracts
- planning
- runbooks
- agent instructions

Accepted decisions are incomplete until current-state owners reflect them.

### 12.13. Verification

State how implementation and documentation alignment will be confirmed.

### 12.14. Supersession

Link:

- decisions superseded by this record
- the replacement when this record is superseded
- migration or transition planning

## 13. Relationship To Planning

Planning documents may:

- identify a decision need
- compare options
- establish a required-by point
- link the proposed decision record
- update after acceptance

Once accepted:

- the decision record owns durable rationale
- the planning document records implementation implications
- canonical owner documents describe current truth

Do not leave an accepted cross-cutting decision only in planning.

Use:

- [Planning Documentation Standards](Planning%20Documentation%20Standards.md)

## 14. Relationship To Canonical Owners

After acceptance:

- architecture docs describe accepted structure
- feature docs describe accepted behavior
- database docs describe accepted schema
- standards describe accepted rules
- runbooks describe accepted operational procedures

The decision record should not duplicate complete current-state content.

Canonical owners must link to the decision when rationale is important.

## 15. Relationship To GitHub Issues And PRs

Issues may:

- request a decision
- define decision deadlines
- collect review discussion
- link to the proposed record

PRs may:

- implement an accepted decision
- update canonical owners
- provide verification evidence

Issue and PR discussions are not substitutes for the decision record when the elevation gate is met.

## 16. Amendments

An accepted decision record may be edited for:

- spelling
- formatting
- broken links
- clearer wording that does not change meaning
- additional implementation references
- added verification evidence

Do not edit an accepted record to change:

- the decision
- material scope
- constraints
- consequences
- rationale
- rejected alternatives

Create a new decision record when the substantive decision changes.

Link the new record as superseding the old one.

## 17. Rejection

A rejected proposal may be retained when it preserves useful reasoning or prevents repeated reconsideration.

A rejected record must:

- use `Decision Status: Rejected`
- explain the rejection
- identify the decision owner
- link to any accepted alternative
- be listed separately from active accepted decisions

Delete a rejected draft when it has no durable value.

## 18. Deprecation And Supersession

Deprecate when:

- the decision remains partly operative
- migration away is underway
- use is discouraged but not fully replaced

Supersede when:

- another accepted decision replaces it

A superseding record must:

- identify each replaced decision
- explain the changed context
- describe transition implications
- link required migration planning

The replaced record must link back to the superseding record.

## 19. Decision Index

`docs/01-decisions/index.md` must:

- define decision-record scope
- state the next available ID or make it discoverable
- list Proposed decisions
- list Accepted decisions
- list Deprecated decisions
- list Superseded and Rejected records separately
- link the decision standard and template
- avoid duplicating full decision content

Update the index in the same change as the decision record.

## 20. Security And Sensitive Decisions

Security, privacy, vulnerability, and incident decisions may require restricted supporting evidence.

The decision record must not include:

- credentials
- exploitable secrets
- unredacted personal data
- restricted vulnerability evidence
- raw customer information

Record the durable decision and consequences.

Reference approved restricted evidence storage separately when needed.

## 21. Decision Review

Review a proposed decision for:

- elevation threshold
- clear owner
- complete context
- explicit drivers
- direct decision statement
- real alternatives
- consequences
- security and data impact
- implementation implications
- canonical updates
- acceptance authority
- verification
- supersession impact

Review accepted decisions for synchronization with current-state owners.

## 22. Completion Criteria

A decision record is complete for its current lifecycle when:

### 22.1. Proposed

- identifier is assigned
- context is clear
- owner is identified
- alternatives are credible
- consequences are analyzed
- required reviewers are identified
- canonical update targets are listed

### 22.2. Accepted

- acceptance authority is recorded
- status and date are updated
- affected canonical owners are updated or tracked in bounded issues
- planning is updated
- required implementation issues exist
- index is updated
- superseded records are updated

### 22.3. Rejected, Deprecated, Or Superseded

- rationale is recorded
- replacement or accepted alternative is linked
- index classification is current
- affected canonical owners no longer present the old decision as current

## 23. Related

- [Documentation Standards Index](index.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Planning Documentation Standards](Planning%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Decision Template](../../09-reference/templates/docs/_decision.md)
- [Decisions Index](../../01-decisions/index.md)
