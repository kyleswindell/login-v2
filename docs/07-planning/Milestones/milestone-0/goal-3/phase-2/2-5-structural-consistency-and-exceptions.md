<!--
DOC-META
title: Phase 2.5 Structural Consistency And Exceptions
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-5-structural-consistency-and-exceptions.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the mandatory repository-organization boundaries, normal structural variation, and bounded exception policy.
-->

# Phase 2.5 Structural Consistency And Exceptions

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records which organizational rules are mandatory, which structural differences are normal, and when a deviation qualifies as an accepted exception.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: target direction only
- Owning GitHub issue: #49
- Parent decisions: Phase 2.1 through Phase 2.4

## 3. Accepted Decision

> Login 2.0 requires consistent ownership, classification, technical-role meaning, delivery placement, and cross-owner boundaries, but it does not require identical folder trees or empty structural skeletons. Capability- and Module-specific variation is normal when it uses the accepted vocabulary and preserves ownership rules. A structural exception is permitted only when an accepted rule must be intentionally bypassed for a bounded transitional, framework/vendor, or permanent capability-specific reason. Every exception must identify its owner, exact scope, rationale, permitted deviation, verification, acceptance authority, and—when transitional—an objective removal condition. Exceptions require explicit repository-owner acceptance, do not create precedent outside their declared scope, and must not recreate generic ownership areas or preserve accidental architecture.

## 4. Mandatory Rules

Every artifact must:

1. have one explicit owner;
2. be classified by owner and capability before technical role;
3. use shared role vocabulary consistently;
4. keep delivery code with the behavior owner;
5. use explicit cross-owner boundaries;
6. avoid generic ownership locations.

Shared roles include:

```text
Actions/
Contracts/
Data/
Models/
Queries/
Registry/
Surface/
Contrib/
Http/
Console/
```

A capability may omit a role but may not silently redefine it.

Prohibited default ownership locations include:

```text
Common/
Shared/
Helpers/
Utilities/
Misc/
Platform/
```

## 5. Normal Variation

The following are not exceptions:

- omitting unused roles;
- requiring different roles for different capabilities;
- adding owner-specific subfolders beneath an accepted role;
- Module package files that Core capabilities do not use;
- a Host having `Registry/` while another owner does not;
- a capability having `Surface/` while another has no UI;
- a Contributor having `Contrib/` while another does not;
- owner documentation declaring required files and folders;
- a simple capability using fewer layers than a complex capability.

Consistency means shared boundaries and predictable meanings, not identical trees.

## 6. Exception Categories

### 6.1. Transitional

Used when migration or compatibility prevents immediate compliance with an accepted target rule.

Examples include a temporary namespace, route alias, transitional folder, or compatibility bridge.

A transitional exception requires an objective removal condition.

### 6.2. Framework Or Vendor

Used when Laravel, Composer, a required package, generated code, or an external tool requires a fixed structure.

The exception is limited to the integration boundary and does not move application behavior into that location.

### 6.3. Permanent Capability-Specific

Used when a stable capability responsibility cannot be expressed clearly through the accepted vocabulary.

Approval requires evidence that the standard model would create ambiguity or incorrect ownership and that the proposed structure remains cohesive and bounded.

Permanent exceptions should be rare.

## 7. Insufficient Justifications

The following do not justify an exception:

- the code already exists there;
- Laravel generated it there;
- moving it requires work;
- several capabilities use it;
- the folder is convenient;
- the team knows the old structure;
- explicit ownership feels excessive;
- the capability is small;
- a deadline makes compliance inconvenient;
- tests currently pass;
- another unapproved deviation exists.

An exception does not preserve accidental architecture.

## 8. Required Exception Record

| Field | Required Information |
| --- | --- |
| Rule bypassed | Exact accepted organizational rule |
| Scope | Covered owner, paths, namespaces, or artifacts |
| Owner | Responsibility owner accountable for the exception |
| Rationale | Why the accepted model cannot reasonably handle the case |
| Type | Transitional, framework/vendor, or permanent |
| Allowed deviation | Exact structure or dependency permitted |
| Prohibited expansion | What the exception must not justify |
| Compatibility impact | Route, namespace, contract, package, or runtime effect |
| Verification | How the boundary is proven |
| Acceptance | Repository-owner acceptance and date |
| Removal condition | Required for transitional exceptions |
| Follow-up owner | Issue, phase, or goal responsible for reassessment |

## 9. Recording And Authority

The general policy belongs in Goal 3 repository-organization documentation.

A specific exception must also be recorded in the closest applicable owner source, such as:

- the capability Feature Spec;
- the Module contract;
- the applicable architecture document;
- the implementation issue using the exception.

Phase 7 consolidates active Goal 3 exceptions into the compatibility and exception register.

Agents may recommend exceptions. Only an explicit repository-owner action may mark one accepted.

## 10. Scope And Precedent

An accepted exception applies only to its declared scope.

Another owner may not copy it automatically.

Repeated requests for the same exception require review of whether:

- the shared vocabulary is incomplete;
- the default rule should change;
- a new role should be defined;
- the cases remain genuinely exceptional.

## 11. Transitional Lifecycle

A transitional exception requires an objective removal condition, such as:

- compatibility usage reaches zero;
- a migration issue completes;
- a deprecated route or namespace is removed;
- a replacement contract becomes available;
- a later Goal assumes ownership.

“Remove later” is insufficient.

## 12. Examples

Valid:

```text
required vendor-facing provider path
→ bounded framework/vendor exception

capability behavior
→ remains with the capability owner
```

Invalid:

```text
app/Services/
└── SharedSettingsService.php
```

“Several capabilities use it” does not create a valid exception or owner.

## 13. Required Effects

This decision requires:

- consistent ownership and role meaning;
- sparse capability-specific structures;
- bounded exception records;
- explicit owner acceptance;
- objective transitional removal conditions;
- review of repeated exceptions;
- prohibition against generic ownership through exceptions.

## 14. Documentation Impact

Reflect this decision in:

- the Phase 2 index;
- the Goal 3 target-architecture artifact;
- later placement rules;
- applicable owner contracts;
- the Phase 7 exception register;
- future repository instructions after the policy becomes durable.

## 15. Verification

Confirm that:

- normal sparse variation is not treated as an exception;
- every exception identifies the bypassed rule and scope;
- transitional exceptions have objective removal conditions;
- agents cannot mark exceptions owner accepted;
- exceptions do not create generic owners or automatic precedent.

## 16. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.2 Secondary Organization Within Each Owner](2-2-secondary-organization-within-each-owner.md)
- [Phase 2.3 Cross-Cutting Technical Code](2-3-cross-cutting-technical-code.md)
- GitHub issue: #49
