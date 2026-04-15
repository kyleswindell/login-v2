# WAVE 2 IMPLEMENTATION
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Execute: Wave 2 – Architecture Migration

### Scope

Source:  
`/docs/`

Target:  
`/docs-v2/03-architecture/`

Primary sources:
- `/docs/V2 App/Architecture/`
- any misplaced architecture-level docs

## Objectives

### 1. Canonical Move
- Extract architecture docs → `/03-architecture/`
- Target becomes canonical immediately
- Source remains read-only
- No in-place edits in `/docs/`

### 2. Structure
Ensure `/03-architecture/` contains:
- `index.md` (hub)
- system-overview.md
- tenancy.md
- auth.md
- platform-boundary.md
- `subsystems/` (as needed)

### 3. Classification
Keep in architecture only:
- system structure
- boundaries
- ownership
- high-level design

Move out if:
- rules → `/02-standards`
- behavior → `/04-features`
- execution → `/05-flows`
- data → `/06-database`
- support → `/09-reference`

Split only if necessary.

### 4. Separation Integrity (Critical)
- No feature behavior in architecture
- No standards/rules in architecture
- No table/schema detail in architecture

### 5. Governance Updates (docs-v2 only)
- Ensure `/03-architecture/index.md` links correctly to:
  - `../00-start-here.md`
  - related standards where appropriate

### 6. Validation
- single canonical path per doc
- `/03-architecture/index.md` usable as hub
- links inside `/docs-v2/` resolve
- `/docs/` unchanged

## Output

1. extracted files (source → target)  
2. reclassified/split files  
3. links created/updated  
4. unresolved items  

## Constraints

- Do not modify `/docs/`
- Do not migrate other branches
- Do not rewrite content unnecessarily

Respond when Wave 2 is ready for audit.

# WAVE 3 IMPLEMENTATION
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Execute: Wave 3 – Features Migration

### Scope

Source:  
`/docs/`

Target:  
`/docs-v2/04-features/`

Primary sources:
- `/docs/V2 App/Features/`
- any misplaced feature-level docs

## Objectives

### 1. Canonical Move
- Extract features → `/04-features/`
- Target becomes canonical immediately
- Source remains read-only
- No in-place edits in `/docs/`

### 2. Structure
Ensure `/04-features/` contains:
- `index.md` (hub)
- grouped domains (as applicable): `auth/`, `users/`, `tenants/`, `logging/`, `notifications/`, etc.

### 3. Classification
Keep in features only:
- behavior
- inputs/outputs
- rules scoped to the feature
- dependencies

Move out if:
- global rules → `/02-standards`
- system structure → `/03-architecture`
- step-by-step flows → `/05-flows`
- data/schema → `/06-database`
- support/research → `/09-reference`

Split only if necessary.

### 4. Separation Integrity (Critical)
- No global standards in features
- No architecture/system-boundary content in features
- No table/schema detail in features

### 5. Governance Updates (docs-v2 only)
- Ensure `/04-features/index.md` links to:
  - `../00-start-here.md`
  - related standards/architecture where appropriate

### 6. Validation
- single canonical path per feature doc
- `/04-features/index.md` usable as hub
- links inside `/docs-v2/` resolve
- `/docs/` unchanged

## Output

1. extracted files (source → target)  
2. reclassified/split files  
3. links created/updated  
4. unresolved items  

## Constraints

- Do not modify `/docs/`
- Do not migrate other branches
- Do not rewrite content unnecessarily

Respond when Wave 3 is ready for audit.

---

# WAVE 4 IMPLEMENTATION
Review:  
/docs/personal notes/Docs V2 Planning Notes

Ask questions only if there is a direct conflict with observed structure.

## Execute: Wave 4 – Flows & Planning

### Scope

Source:  
`/docs/`

Targets:  
`/docs-v2/05-flows/`  
`/docs-v2/07-planning/`

Primary sources:
- `/docs/V2 App/Planning/`
- any docs containing flows or execution steps

## Objectives

### 1. Canonical Move
- Extract flows → `/05-flows/`
- Extract planning → `/07-planning/`
- Targets become canonical immediately
- Source remains read-only

### 2. Flows Structure
Ensure `/05-flows/` contains:
- `index.md` (hub)
- system/user flows (e.g., login-flow.md, tenant-provisioning.md)

Keep flows as:
- step-by-step execution paths
- no rules or architecture definitions

### 3. Planning Structure
Ensure `/07-planning/` contains:
- `roadmap.md`
- `phases/`
- `batches/`
- `dependency-map.md` (if applicable)

Planning contains:
- sequencing
- delivery grouping
- implementation intent

### 4. Classification

Flows contain only:
- ordered steps
- execution paths
- inputs/outputs across steps

Planning contains only:
- phases
- batches
- delivery sequencing

Move out if:
- rules → `/02-standards`
- system structure → `/03-architecture`
- feature behavior → `/04-features`
- data → `/06-database`
- support → `/09-reference`

### 5. Separation Integrity (Critical)

- No rules in flows
- No system architecture in flows
- No feature definitions in planning
- No operational/runbook procedures in planning

### 6. Governance Updates (docs-v2 only)

- Ensure `/05-flows/index.md` and `/07-planning/index.md` (or equivalents) link to:
  - `../00-start-here.md`
- Ensure cross-links:
  - features → flows (where applicable)
  - planning → features (reference only, not duplication)

### 7. Validation

- flows and planning fully extracted from source
- no duplication of behavior/architecture/rules
- links resolve
- `/docs/` unchanged

## Output

1. extracted files (source → target)  
2. files classified as flows vs planning  
3. reclassified/split files  
4. links created/updated  
5. unresolved items  

## Constraints

- Do not modify `/docs/`
- Do not migrate other branches
- Do not rewrite content unnecessarily

Respond when Wave 4 is ready for audit.

---
# WAVE 5 IMPLEMENTATION
Review:  
/docs/Personal Notes/Docs V2 Planning Notes.md

Ask questions only if there is a direct conflict with observed structure.

## Execute: Wave 5 – Database & Runbooks

### Scope

Source:  
`/docs/`

Targets:  
`/docs-v2/06-database/`  
`/docs-v2/10-runbooks/`

Primary sources:
- any schema/table content extracted in Wave 3
- `/docs/V2 App/Reference/` (data models, schema notes)
- `/docs/V2 App/Runbooks/` (operational procedures)
- any misplaced database/runbook content

## Objectives

### 1. Canonical Move

- Extract schema/data contracts → `/06-database/`
- Extract operational procedures → `/10-runbooks/`
- Targets become canonical immediately
- Source remains read-only

### 2. Database Structure

Ensure `/06-database/` contains:

- `schema.md` (optional hub)
- `tables/` (core tables if applicable)
- `feature-contracts/` (from Wave 3 splits)

Database docs contain only:
- tables
- columns
- relationships
- data ownership
- constraints

### 3. Runbooks Structure

Ensure `/10-runbooks/` contains:

- deployment.md
- local-dev.md
- backup.md (if applicable)
- cron.md (if applicable)
- other operational procedures

Runbooks contain only:
- operational steps
- environment setup
- execution procedures

### 4. Classification

Database contains only:
- schema
- table definitions
- column-level detail
- data constraints

Runbooks contain only:
- operational procedures
- environment steps
- system execution tasks

Move out if:
- rules → `/02-standards`
- system structure → `/03-architecture`
- feature behavior → `/04-features`
- flows → `/05-flows`
- support → `/09-reference`

### 5. Separation Integrity (Critical)

- No feature behavior in database docs
- No system architecture in database docs
- No schema or table detail in feature docs (validate previous wave)
- No rules/standards in runbooks
- No architecture in runbooks

### 6. Governance Updates (docs-v2 only)

- Ensure `/06-database/` and `/10-runbooks/` are reachable from:
  - `00-start-here.md`
- Add links from:
  - features → database (for data dependencies)
  - architecture → database (for ownership reference, if needed)

### 7. Validation

- all schema content extracted from features
- runbooks extracted and isolated
- no duplication of schema or operations elsewhere
- links inside `/docs-v2/` resolve
- `/docs/` unchanged

## Output

1. extracted files (source → target)  
2. new files created  
3. reclassified content  
4. links created/updated  
5. unresolved items  

## Constraints

- Do not modify `/docs/`
- Do not migrate other branches
- Do not rewrite content unnecessarily

Respond when Wave 5 is ready for audit.

---
# WAVE 6 IMPLEMENTATION


---
# WAVE 7 IMPLEMENTATION
Review:  
/docs/Personal Notes/Docs V2 Planning Notes.md

Ask questions only if there is a direct conflict with observed structure.

## Execute: Wave 7 – Final Cutover & Archive

### Scope
- `/docs-v2/`
- `/docs/`

## Pre-Check (must pass)
- Wave 6 status = PASS
- `/docs-v2/` link check = 0 broken
- No canonical content remains outside `/docs-v2/`

## Steps

### 1. Prepare Archive
Create:
- `/docs/_archive/`

Move:
- `/docs/V1 App/` → `/docs/_archive/V1 App/`
- `/docs/V2 App/` → `/docs/_archive/V2 App/`

(keep bridge stubs intact)

---

### 2. Archive Current docs Root
Rename:
- `/docs/` → `/docs/_archive/docs-pre-migration/`

Do not modify contents.

---

### 3. Promote docs-v2
Rename:
- `/docs-v2/` → `/docs/`

---

### 4. Update Root Paths
Across new `/docs/`:

- replace any remaining `/docs-v2/...` → `/docs/...`
- ensure:
  - `00-start-here.md` works
  - all index files resolve

---

### 5. Final Cleanup
- ensure no bridge files exist in new `/docs/`
- ensure no legacy path references remain

---

## Validation
Confirm:

- `/docs/` is fully self-contained
- `/docs/_archive/` contains all legacy content
- no duplicate canonical content exists
- all links resolve

## Output

1. folders moved/renamed  
2. links updated  
3. cleanup performed  
4. final structure summary  

Respond when complete.

---
# WAVE 8 IMPLEMENTATION


---
# WAVE 9 IMPLEMENTATION


---
# WAVE 10 IMPLEMENTATION


---
