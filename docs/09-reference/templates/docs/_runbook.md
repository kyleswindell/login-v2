<!--
DOC-META
title: Runbook Template
doc_type: reference
status: active
owner: docs
canonical: false
canonical_path: docs/09-reference/templates/docs/_runbook.md
parent: docs/09-reference/templates/docs/_index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Provides the copyable structure for operator-executable runbooks governed by Runbook Documentation Standards.
-->

# Runbook Template

Parent: [Documentation Templates Index](_index.md)

Use this template for operator-executable procedures under `docs/10-runbooks/`.

Before using it, read:

- [Runbook Documentation Standards](../../../02-standards/documentation/Runbook%20Documentation%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)
- [How To Write Docs](../../../02-standards/documentation/How%20To%20Write%20Docs.md)

Copy the block below, replace every instructional placeholder, and remove sections only when the governing standard permits them to be omitted.

```md
<!--
DOC-META
title: Runbook Title
doc_type: runbook
status: draft
owner: ops
canonical: true
canonical_path: docs/10-runbooks/path-to-runbook.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: One sentence describing the operational procedure this runbook owns.
-->

# Runbook Title

Parent: [Runbook Index](index.md)

## 1. Purpose

State the operational outcome this runbook produces.

## 2. Operational Status

- Lifecycle: draft | planned | active | implemented | superseded | archived
- Supported environments:
- Validation state: document review only | command validated | staging exercised | production exercised
- Last exercised:
- Next review:
- Owning service or capability:

Do not use metadata status as a substitute for stating whether the procedure has actually been exercised.

## 3. Use When

Use this runbook when:

- ...
- ...

Identify the exact task, alert, request, failure condition, or maintenance event that triggers this procedure.

## 4. Do Not Use When

Do not use this runbook when:

- ...
- ...

Link to the correct adjacent procedure or escalation path where applicable.

## 5. Roles And Ownership

| Responsibility          | Owner                 |
| ----------------------- | --------------------- |
| Authorized operator     | ...                   |
| Service or system owner | ...                   |
| Approval owner          | ...                   |
| Escalation owner        | ...                   |
| Specialist reviewer     | ... or Not applicable |

## 6. Prerequisites

Before starting, confirm:

- [ ] the target environment is identified
- [ ] the operator is authorized
- [ ] required approvals are recorded
- [ ] required tools and access are available
- [ ] the maintenance or incident window is identified
- [ ] backup, recovery point, or rollback prerequisites are satisfied
- [ ] affected users, tenants, workspaces, or services are understood
- [ ] related issue, incident, change, or release identifier is available
- [ ] required canonical standards and owner docs were reviewed

Add procedure-specific prerequisites:

- ...

Do not place passwords, tokens, private keys, or other secret values in this document.

## 7. Target Identification

Confirm the exact target before performing any state-changing action.

| Target                                    | Required Value             |
| ----------------------------------------- | -------------------------- |
| Environment                               | local, staging, production |
| Host, service, or application             | ...                        |
| Tenant, workspace, account, or data scope | ... or Not applicable      |
| Branch, release, artifact, or commit      | ... or Not applicable      |
| Database, storage, queue, or cache target | ... or Not applicable      |
| Maintenance or incident window            | ...                        |
| Related issue, incident, or change record | ...                        |

Stop when any state-changing target is ambiguous.

## 8. Inputs And Variables

List every value the operator must know or set.

| Input Or Variable | Required | Source                          | Example Or Format | Notes            |
| ----------------- | -------- | ------------------------------- | ----------------- | ---------------- |
| `EXAMPLE_VALUE`   | Yes      | Approved configuration or issue | `value`           | Why it is needed |
| ...               | ...      | ...                             | ...               | ...              |

Use environment variables, configured aliases, or declared placeholders instead of operator-specific absolute paths and personal identifiers.

## 9. Safety And Data Handling

Identify applicable operational risks.

### State-Changing Or Destructive Effects

- ...

### Service Availability

- Expected interruption:
- Maximum acceptable interruption:
- User or operator communication required:

### Security And Access

- ...

### Privacy And Sensitive Data

- ...

### Audit And Evidence

- ...

### Rollback Prerequisite

- ...

State `Not applicable` only after confirming the category does not affect this procedure.

## 10. Procedure

Perform the following steps in order.

### Step 1 — Step Name

Action:

    command-or-action

Expected result:

- ...

Stop when:

- ...

Record:

- ...

### Step 2 — Step Name

Action:

    command-or-action

Expected result:

- ...

Stop when:

- ...

Decision branch:

- When ..., continue to Step ...
- When ..., execute [Failure Handling](#12-failure-handling)
- When ..., execute [Rollback Or Recovery](#13-rollback-or-recovery)

Record:

- ...

### Step 3 — Step Name

Action:

    command-or-action

Expected result:

- ...

Stop when:

- ...

Record:

- ...

Add only the steps required for the actual procedure.

For each destructive or state-changing command, include target validation, expected output, and a stop condition.

## 11. Verification

Verify the result objectively.

### Required Checks

- [ ] ...
- [ ] ...
- [ ] ...

### Commands

    verification-command

### Expected Results

- ...

### Manual Review

- ...

### Negative Or Failure Verification

- ...

Do not treat command completion alone as proof of operational success.

## 12. Failure Handling

For each known failure mode, define the safe response.

| Failure Or Symptom | Likely Cause | Safe Diagnostic | Immediate Action | Retry Allowed |
| ------------------ | ------------ | --------------- | ---------------- | ------------- |
| ...                | ...          | ...             | ...              | Yes / No      |

General failure rules:

- preserve relevant logs and command output
- do not repeat destructive steps blindly
- do not continue when target identity is uncertain
- do not improvise a production fix outside the approved procedure
- escalate when the failure exceeds the runbook's recovery boundary

## 13. Rollback Or Recovery

### Rollback Trigger

Rollback or recover when:

- ...

### Recovery Point

- ...

### Procedure

1. ...
2. ...
3. ...

### Verification

- [ ] ...
- [ ] ...

### Limits

State what this rollback does not reverse.

- ...

When rollback is not possible, explain why and identify the required recovery or escalation path.

A state-changing runbook must not omit rollback or recovery without an explicit no-rollback explanation.

## 14. Escalation

Escalate when:

- ...
- ...

Escalation owner:

- ...

Provide:

- environment and target
- issue, incident, or change identifier
- start time and operator
- completed steps
- failed step
- sanitized command output
- logs and correlation identifiers
- current service and data state
- rollback attempts
- actions intentionally not taken

While waiting:

- do not ...
- preserve ...
- maintain ...

## 15. Evidence And Documentation

Record the evidence required by this procedure.

| Evidence                             | Required        | Storage Or Owner | Retention Or Handling |
| ------------------------------------ | --------------- | ---------------- | --------------------- |
| Start and completion timestamps      | Yes             | ...              | ...                   |
| Operator and approval                | Yes             | ...              | ...                   |
| Branch, release, artifact, or commit | When applicable | ...              | ...                   |
| Sanitized command output             | When applicable | ...              | ...                   |
| Verification results                 | Yes             | ...              | ...                   |
| Logs or correlation identifiers      | When applicable | ...              | ...                   |
| Screenshots                          | When applicable | ...              | ...                   |
| Backup or recovery identifier        | When applicable | ...              | ...                   |

Do not use the runbook itself as the historical evidence record.

Do not store secrets, unnecessary personal data, raw customer records, or restricted vulnerability evidence in repository documentation.

## 16. Completion Criteria

The procedure is complete when:

- [ ] the intended operational outcome is achieved
- [ ] required verification passes
- [ ] service and data state are understood
- [ ] rollback is no longer required or remains available as intended
- [ ] evidence is recorded
- [ ] issue, incident, change, or release records are updated
- [ ] temporary access, maintenance state, claims, branches, or resources are cleaned up
- [ ] staging or shared-environment ownership is released when applicable
- [ ] follow-up issues are created for unresolved non-blocking work

## 17. Maintenance And Exercise

- Review owner:
- Required review interval:
- Required exercise type: document review | command validation | staging exercise | restore drill | tabletop | production use
- Last reviewed:
- Last exercised:
- Next review:
- Known environment or dependency assumptions:

Update this runbook when commands, paths, services, ownership, permissions, rollback behavior, monitoring, evidence, or dependencies change.

## 18. Related

- [Runbook Index](index.md)
- [Governing Standard](../02-standards/path/standard.md)
- [Related Architecture](../03-architecture/path/document.md)
- [Related Feature](../04-features/path/document.md)
- [Related Database Contract](../06-database/path/document.md)
- [Related Planning](../07-planning/path/document.md)
- Related GitHub issue: #...
```

## Related

- [Runbook Documentation Standards](../../../02-standards/documentation/Runbook%20Documentation%20Standards.md)
- [Document Type Standards](../../../02-standards/documentation/Document%20Type%20Standards.md)
- [Runbook Index](../../../10-runbooks/index.md)
