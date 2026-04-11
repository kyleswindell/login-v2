---
description: "Kick off a new module using Login V2 standards: contract validation, tenancy boundaries, setup/settings map, permissions, schema, and batch fit."
name: "Module Creation Kickoff"
argument-hint: "Module name and target phase, for example: Support module in Phase 4"
agent: "agent"
---
Prepare a module kickoff package for the requested module.

Do the following:
1. Validate the module against V2 roadmap, phase scope, and relevant V1 references.
2. Define module key, route namespace, setup entries, and settings groups.
3. Define tenancy/auth boundary requirements and ownership rules.
4. Define minimum PostgreSQL table families and foreign key direction.
5. Define permission matrix starter preset and policy gates.
6. Define notifications/email template hooks required from the shared Phase 3 foundation.
7. Define minimum implementation slice and test baseline for Batch 1 inclusion.

Output format:
- Module Contract Summary
- Setup And Settings Map
- Data Model Draft
- Authorization And Permissions
- Notifications And Templates
- Batch Fit Recommendation
- Next Build Steps

Git close-out (required when edits were made):
1. Stage only the files changed for this task.
2. Commit with a clear summary of completed work.
3. Push to the current branch.
4. Report commit SHA and pushed branch in the final summary.
