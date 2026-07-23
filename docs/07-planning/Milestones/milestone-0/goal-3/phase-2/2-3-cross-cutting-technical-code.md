<!--
DOC-META
title: Phase 2.3 Cross-Cutting Technical Code
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-3-cross-cutting-technical-code.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records how broadly consumed technical behavior retains one explicit responsibility owner.
-->

# Phase 2.3 Cross-Cutting Technical Code

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records how Login 2.0 classifies technical behavior consumed by multiple capabilities or Modules.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: target direction only
- Owning GitHub issue: #49
- Parent decisions: Phase 2.1 and Phase 2.2

## 3. Core Principle

> Cross-cutting describes how widely code is consumed. It does not identify who owns it.

Code belongs to the responsibility whose policy, invariant, or contract causes it to change.

## 4. Accepted Decision

> Cross-cutting use does not create cross-cutting ownership. Every technical responsibility must be assigned to an existing Core capability, a new explicitly named Core capability, an optional Module, UI, or Laravel integration according to the policy and invariant it serves. Other owners consume the responsibility through public contracts or accepted Host Registry extension points. Generic ownership folders such as `Common`, `Shared`, `Helpers`, `Utilities`, and `Platform` are prohibited. Truly portable technical functionality should use an established dependency where practical, and custom abstractions must still have one explicit owner.

## 5. Owner-Selection Sequence

### 5.1. Existing Core Capability

When an existing capability owns the policy or invariant, the code stays there.

| Behavior | Explicit Owner |
| --- | --- |
| audit recording | `Core/Audit` |
| authorization evaluation | `Core/Access` |
| password hashing | `Core/Identity` or `Core/Security` |
| user preferences | `Core/Preferences` |
| Settings contribution aggregation | `Core/Settings/Registry` |

Broad use does not move the code into a shared folder.

### 5.2. New Required Core Capability

When the responsibility is required but no accepted Core capability owns it, define a cohesive, explicitly named Core capability.

Possible names include:

```text
Core/Identifiers/
Core/Time/
Core/Cryptography/
Core/Storage/
```

Broad labels such as `Infrastructure`, `Support`, `Foundation`, or `Shared` are insufficient without a narrower accepted responsibility.

### 5.3. Optional Cohesive Functionality

Optional cohesive functionality belongs to a Module.

The fact that Core or multiple Modules consume or publish information to it does not make it Core-owned.

### 5.4. Reusable Presentation Infrastructure

Reusable presentation infrastructure belongs to UI.

The presenting capability or Module retains ownership of its data and decisions.

### 5.5. Laravel Framework Integration

Application-wide framework wiring belongs to Laravel integration.

Laravel integration may bind or register an owner’s contract, but it does not own the application behavior.

### 5.6. Portable Technical Functionality

Prefer an accepted dependency or framework facility for domain-free functionality such as UUIDs, immutable dates, MIME handling, HTTP protocol support, or cryptographic primitives.

A custom implementation still requires one explicit owner, bounded contracts, tests, and documentation.

## 6. Public Boundaries

Cross-owner use occurs through an explicit public boundary:

```text
Consumer
    ↓
Owner public contract
    ↓
Owner implementation
```

Consumers must not reach directly into:

- another capability’s internal classes;
- another Module’s implementation;
- another owner’s models or tables;
- physical paths used as undocumented APIs.

The contract belongs to the responsibility whose requirements it expresses.

## 7. Host Registry Contributions

A Host Registry is a controlled cross-owner boundary.

```text
Core/Settings/
└── Registry/
```

Settings owns extension points, validation, collection, ordering, and resolved Registry output.

```text
Modules/Notifications/
└── Contrib/
    └── Settings/
```

Notifications owns its contribution and underlying behavior.

Registry ownership and Contribution ownership remain separate.

## 8. Abstraction Threshold

Do not create a cross-owner abstraction merely because similar code appears twice.

Extraction is justified when:

- the responsibility has one stable meaning;
- consumers require the same contract;
- the code changes for the same reason;
- one explicit owner can maintain it;
- extraction reduces coupling rather than hiding it.

Temporary duplication is preferable to an ownerless generic abstraction.

## 9. Prohibited Ownership Areas

Prohibited default ownership locations include:

```text
Common/
Shared/
Helpers/
Utilities/
Support/
Generic/
Platform/
```

These names are suspect unless narrowly defined:

```text
Services/
Infrastructure/
Foundation/
```

They must not become unrestricted collection areas.

## 10. Owner Obligations

A cross-cutting responsibility must state:

1. what it owns;
2. why the owner controls it;
3. which public contract consumers use;
4. which dependencies are allowed;
5. what it must not own;
6. how compatibility is maintained;
7. how it is tested and documented.

## 11. Required Effects

This decision requires:

- one owner for every broadly consumed responsibility;
- public cross-owner contracts;
- separate Host Registry and Contribution ownership;
- no generic shared owner;
- preference for accepted external dependencies;
- no premature ownerless abstraction.

## 12. Documentation Impact

Reflect this decision in:

- the Phase 2 index;
- the Goal 3 target-architecture artifact;
- Phase 4 placement and dependency rules;
- applicable capability and Module contracts;
- Host and Registry definitions;
- future repository instructions after acceptance as durable policy.

## 13. Verification

Confirm that representative cross-cutting code can be classified without:

- creating a generic ownership folder;
- moving behavior into Laravel integration;
- making UI own application policy;
- allowing direct access to another owner’s internals;
- using number of consumers as ownership evidence.

## 14. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.2 Secondary Organization Within Each Owner](2-2-secondary-organization-within-each-owner.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](2-90-surface-host-registry-reclassification.md)
- GitHub issue: #49
