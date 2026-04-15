# WAVE 2 AUDIT
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Audit: Wave 2 – Architecture

### Scope

Validate:  
`/docs-v2/03-architecture/`  
with reference to source material in `/docs/`

## Checks

### 1. Canonical Integrity
- All architecture docs exist in `/03-architecture/`
- No duplicate canonical architecture definitions

### 2. Structure
- `/03-architecture/index.md` exists and usable
- Contains:
  - system overview
  - tenancy
  - auth
  - platform boundary
  - subsystems (if used)

### 3. Classification
Architecture must contain only:
- system structure
- boundaries
- ownership
- high-level design

Flag anything belonging in:  
`/02-standards`, `/04-features`, `/05-flows`, `/06-database`, `/09-reference`

### 4. Separation Integrity (Critical)
- No feature behavior in architecture
- No standards/rules in architecture
- No schema/table detail in architecture

### 5. Link Integrity
- Links inside `/docs-v2/` resolve
- No broken links

### 6. Source Preservation
- `/docs/` unchanged
- no deletions/overwrites occurred

## Output

1. status: PASS / PARTIAL / FAIL  
2. critical issues  
3. warnings  

4. required fixes (per issue):
- file path  
- issue type  
- action:
  - move → target path
  - reclassify → correct location
  - remove duplicate

### Validation Checklist

- [ ] canonical paths correct  
- [ ] no duplicate definitions  
- [ ] classification correct  
- [ ] separation integrity maintained  
- [ ] links valid  
- [ ] source preserved  

Do not modify files. Read-only audit.

# WAVE 3 AUDIT
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Audit: Wave 3 – Features

### Scope

Validate:  
`/docs-v2/04-features/`  
with reference to source material in `/docs/`

## Checks

### 1. Canonical Integrity
- All feature docs exist in `/04-features/`
- No duplicate canonical feature definitions

### 2. Structure
- `/04-features/index.md` exists and usable
- Features are logically grouped (auth, users, etc.)
- No flat/disorganized structure

### 3. Classification
Features must contain only:
- behavior
- inputs/outputs
- feature-scoped rules
- dependencies

Flag anything belonging in:  
`/02-standards`, `/03-architecture`, `/05-flows`, `/06-database`, `/09-reference`

### 4. Separation Integrity (Critical)
- No global standards in features
- No architecture/system-boundary content in features
- No schema/table detail in features

### 5. Link Integrity
- Links inside `/docs-v2/` resolve
- No broken links

### 6. Source Preservation
- `/docs/` unchanged
- no deletions/overwrites occurred

## Output

1. status: PASS / PARTIAL / FAIL  
2. critical issues  
3. warnings  

4. required fixes (per issue):
- file path  
- issue type  
- action:
  - move → target path
  - reclassify → correct location
  - remove duplicate

### Validation Checklist

- [ ] canonical paths correct  
- [ ] no duplicate definitions  
- [ ] classification correct  
- [ ] separation integrity maintained  
- [ ] links valid  
- [ ] source preserved  

Do not modify files. Read-only audit.

---
# WAVE 4 AUDIT
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Audit: Wave 4 – Flows & Planning

### Scope

Validate:  
`/docs-v2/05-flows/`  
`/docs-v2/07-planning/`  
with reference to `/docs/`

## Checks

### 1. Canonical Integrity

- All flow docs exist in `/05-flows/`
- All planning docs exist in `/07-planning/`
- No duplicate canonical definitions

### 2. Structure

Flows:
- `/05-flows/index.md` exists and usable
- flows are clearly defined per system/user process

Planning:
- phases and/or batches exist
- planning structure is organized (not flat)

### 3. Classification

Flows must contain only:
- ordered steps
- execution paths

Planning must contain only:
- phases
- batches
- sequencing

Flag anything belonging in:  
`/02-standards`, `/03-architecture`, `/04-features`, `/06-database`, `/09-reference`

### 4. Separation Integrity (Critical)

- No rules in flows
- No architecture in flows
- No feature definitions in planning
- No runbook/ops content in planning

### 5. Link Integrity

- Links inside `/docs-v2/` resolve
- No broken links

### 6. Source Preservation

- `/docs/` unchanged
- no deletions/overwrites occurred

## Output

1. status: PASS / PARTIAL / FAIL  
2. critical issues  
3. warnings  

4. required fixes (per issue):
- file path  
- issue type  
- action:
  - move → target path
  - reclassify → correct location
  - remove duplicate

### Validation Checklist

- [ ] canonical paths correct  
- [ ] no duplicate definitions  
- [ ] classification correct  
- [ ] separation integrity maintained  
- [ ] links valid  
- [ ] source preserved  

Do not modify files. Read-only audit.
---
# WAVE 5 AUDIT
Review:  
/docs/Personal Notes/Docs V2 Planning Notes.md

Ask questions only if there is a direct conflict with observed structure.

## Audit: Wave 5 – Database & Runbooks

### Scope

Validate:  
`/docs-v2/06-database/`  
`/docs-v2/10-runbooks/`  
with reference to `/docs/`

## Checks

### 1. Canonical Integrity

- All schema/data docs exist in `/06-database/`
- All runbook docs exist in `/10-runbooks/`
- No duplicate canonical definitions

### 2. Structure

Database:
- schema and/or feature-contracts exist
- table/data docs are organized

Runbooks:
- operational docs exist (deploy, local-dev, etc.)
- not flat/disorganized

### 3. Classification

Database must contain only:
- tables
- columns
- relationships
- data constraints

Runbooks must contain only:
- operational procedures
- environment steps

Flag anything belonging in:  
`/02-standards`, `/03-architecture`, `/04-features`, `/05-flows`, `/09-reference`

### 4. Separation Integrity (Critical)

- No feature behavior in database docs
- No architecture/system-boundary content in database docs
- No schema/table detail in feature docs (cross-check Wave 3)
- No rules/standards in runbooks
- No architecture in runbooks

### 5. Link Integrity

- Links inside `/docs-v2/` resolve
- No broken links

### 6. Source Preservation

- `/docs/` unchanged
- no deletions/overwrites occurred

## Output

1. status: PASS / PARTIAL / FAIL  
2. critical issues  
3. warnings  

4. required fixes (per issue):
- file path  
- issue type  
- action:
  - move → target path
  - reclassify → correct location
  - remove duplicate

### Validation Checklist

- [ ] canonical paths correct  
- [ ] no duplicate definitions  
- [ ] classification correct  
- [ ] separation integrity maintained  
- [ ] links valid  
- [ ] source preserved  

Do not modify files. Read-only audit.
---
# WAVE 6 AUDIT

---
# WAVE 7 AUDIT
Review:  
/docs/Personal Notes/Docs V2 Planning Notes.md

Ask questions only if there is a direct conflict with observed structure.

## Audit: Wave 7 – Final Cutover

### Scope
- `/docs/`
- `/docs/_archive/`

## Checks

### 1. Canonical Integrity
- All canonical docs exist only in `/docs/`
- No canonical docs exist in `/docs/_archive/`

### 2. Archive Integrity
- `/docs/_archive/` contains:
  - previous docs tree
  - V1 App
  - V2 App
- No content loss

### 3. Structure Completeness
Confirm `/docs/` contains:
- `00-start-here.md`
- all branches:
  - standards, architecture, features, flows, database, planning, reference, runbooks

Each has a working index

---

### 4. Separation Integrity
- rules only in standards
- structure only in architecture
- behavior only in features
- execution only in flows
- schema only in database
- sequencing only in planning
- support only in reference
- operations only in runbooks

---

### 5. Navigation Integrity
- all canonical docs reachable
- no orphan canonical docs

---

### 6. Link Integrity
- all links resolve
- no `/docs-v2/` references remain

---

### 7. Self-Containment
- `/docs/` does not depend on `/docs/_archive/`

---

## Output

1. status: PASS / PARTIAL / FAIL  
2. critical issues  
3. warnings  

4. required fixes:
- file path  
- issue  
- action  

### Validation Checklist

- [ ] canonical paths correct  
- [ ] no duplicate definitions  
- [ ] classification correct  
- [ ] separation integrity maintained  
- [ ] navigation complete  
- [ ] links valid  
- [ ] archive preserved  
- [ ] docs self-contained  

Do not modify files. Read-only audit.
---
# WAVE 8 AUDIT

---
# WAVE 9 AUDIT

---
# WAVE 10 AUDIT

---
