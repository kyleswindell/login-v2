
# 08-active Execution Workflow & Batch Management

This document defines the canonical scope and intent for 08-active Execution Workflow & Batch Management.

## Purpose

Define a strict, repeatable workflow for executing documentation tasks using `/docs/08-active/`, including:

- batch lifecycle
- required deliverables
- validation and approval gates
- archival of completed work

This ensures consistency, prevents drift, and maintains a clean separation between active work and canonical documentation.

---

## Core Principle

```text
/08-active/ = ONE active batch workspace only
````

- No history stored here
    
- No multiple batches
    
- No canonical docs created here
    

All work flows through `/08-active/`, but is written to canonical branches.

---

## Folder Structure

```text
/docs/08-active/
├── batch.md
├── worklog.md
├── notes.md
├── review.md
├── checklist.md
```

### File Roles

|File|Purpose|
|---|---|
|`batch.md`|scope + required deliverables|
|`worklog.md`|execution tracking|
|`notes.md`|findings / discoveries|
|`review.md`|audit + manual review|
|`checklist.md`|completion validation|

---

## Lifecycle

```text
Plan → Load → Execute → Audit → Manual Review → PASS → Archive → Reset
```

---

## Batch Initialization

### Requirements

- Load ONE batch from `/docs/07-planning/`
    
- Clear `/08-active/`
    
- Populate:
    
    - `batch.md`
        
    - empty working files
        

### Required Section (batch.md)

```md
## Required Deliverables

- [ ] All target files created/updated
- [ ] Classification rules enforced
- [ ] No duplication introduced
- [ ] Links updated and valid
- [ ] Cross-branch references correct
```

---

## Execution Rules

During work:

- Write ONLY to canonical branches:
    
    - `/02-standards/`
        
    - `/03-architecture/`
        
    - `/04-features/`
        
    - `/05-flows/`
        
    - `/06-database/`
        
    - `/07-planning/`
        
    - `/09-reference/`
        
    - `/10-runbooks/`
        
- Use:
    
    - `worklog.md` → progress
        
    - `notes.md` → findings
        

### Strict Constraints

- No canonical content in `/08-active/`
    
- No multiple batches
    
- No planning content added here
    

---

## Completion Checklist

`checklist.md` must be fully satisfied:

```md
## Structural
- [ ] Files in correct branches
- [ ] No misclassified content
- [ ] No duplicate canonical definitions

## Integrity
- [ ] Links valid
- [ ] No legacy paths
- [ ] Docs self-contained

## Separation
- [ ] Rules only in standards
- [ ] Architecture only in architecture
- [ ] Schema only in database
- [ ] Operations only in runbooks

## Deliverables
- [ ] All batch.md deliverables complete

## Review
- [ ] Audit passed
- [ ] Manual visual review complete
- [ ] Manual functional validation complete

## Approval
- [ ] Status = PASS
```

---

## Review Process

### Automated Review

Populate `review.md`:

```md
Status: PASS / PARTIAL / FAIL

- issues
- required fixes
```

---

### Manual Review (Required)

```md
## Manual Review

Visual: PASS / FAIL  
Functional: PASS / FAIL
```

### Validation Criteria

- navigation works
    
- indexes/hubs correct
    
- cross-links valid
    
- structure readable
    

---

## Finalization

### Preconditions

- checklist complete
    
- review = PASS
    
- manual review = PASS
    

---

## Archiving

### Location

```text
/docs/11-ai/_archive/batches/
```

### Structure

```text
/docs/11-ai/_archive/batches/
└── YYYY-MM-DD-batch-name/
    ├── batch.md
    ├── worklog.md
    ├── notes.md
    ├── review.md
    └── checklist.md
```

---

### Archive Rules

- archive BEFORE clearing `/08-active/`
    
- archive is read-only
    
- never overwrite
    
- never reuse as working input
    

---

### Naming Convention

```text
YYYY-MM-DD-batch-name
```

Example:

```text
2026-04-15-wave-3-feature-cleanup
```

---

## Reset

After archiving:

- clear all `/08-active/` files
    
- return to idle state
    

---

## Prohibited Actions

- storing history in `/08-active/`
    
- running multiple batches
    
- writing canonical docs in `/08-active/`
    
- modifying archived batches
    
- using archive as source for new work
    

---

## Separation Model (Reference)

```text
02-standards → rules
03-architecture → structure
04-features → behavior
05-flows → execution paths
06-database → schema
07-planning → sequencing
09-reference → support
10-runbooks → operations
```

---

## Summary

```text
/08-active/ = controlled execution environment
archive = /11-ai/_archive/batches/
completion requires PASS + manual validation
```

This workflow ensures:

- clean execution
    
- reproducibility
    
- audit traceability
    
- zero contamination of canonical docs
