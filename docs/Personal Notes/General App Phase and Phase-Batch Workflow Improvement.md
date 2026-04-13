Solidify the agent workflow of General Phase planning, development, and close-out procedures to ensure that Phase scope and deliverables are clearly defined and maintained throughout the phase development cycle. 

General thoughts / notes on process:

Overall Phase is mapped from overall app development notes based on Overall feature dependencies hierarchy and planning / scheduling

Once a phase deliverables goal is finalized, phase batches are organized and ordered also based on dependencies, with efficiency planning work taken to evaluate and determine phase batches that can be simultaneously and independently implemented via implementation/coding agents.

Phase batches should be ran on independent .git work trees and then re-established into main repo after final sign-off and completion similar to a .git branch merge. 

Phase batches cannot be finalized, concluded and signed-off until a review/audit agent has reviewed the batch and concluded deliverables are sufficiently met, additional encountered problems / goals have either been deferred to later phases or phase batches in the current phase, or executed in current in-progress phase batch and documented appropriately in batch docs, overall phase docs, and canonical docs. 

Extending this, phases cannot be finalized, concluded and signed-off until a review/audit agent has reviewed the phase docs  and concluded deliverables are sufficiently met including additional scope discovered during implementation or review has been included and completed in current phase, or sufficiently documented and deferred to a later phase and sufficiently documented in both general app planning and future phase planning docs (either ambiguous future planning or included in established future phase)

Development log should be separated/chaptered and subchapters by phase and phase batch. These should be updated by review/audit agents as well as simultaneously maintained and updated by coding agents during batch implementation. Development log should be detailed outlines of work completed, issues encountered, necessary decisions made, scope adjustments required and made, and other detailed implementation logs to thoroughly document development in-case it needs to be reviewed at a later date as to why certain limitations are in place, or why development was conducted in a specific manner. 

Phase planning and phase doc planning should only include the most up-to-date versions of notes, dependencies and deliverables as scope adjusts during implementation to make sure development log and phase planning aren't redundant and to keep phase planning tight and aligned with implementation goals, deliverables, important notes / comments / scope deferments, and specific planning decisions and design related to phase batch deliverables.

Relevant agent commands

/implement Phase-#-batch-# instructs agent to 
Conduct implementation of above specified phase batch following detailed docs. Review and analyze full scope of the phase batch that exists in docs files under docs/V2 App/Planning and follow all design constraints and details outlined in relevant docs. 

Only pause to ask any clarifying questions you may have or to address any potential problems you encounter during development. 

Completion is considered achieved when all phase batch deliverables are implemented and tested.

When completed, request an audit and review prompt be initialized for final review and sign-off of the implementation batch

/review Phase-#-batch-# or Phase-#

Ran in open agent session following an /implement prompt. Review code changes implemented by agent for specific phase batch compared to phase and phase batch planning docs. If sufficient, commit phase batch implementation changes and push for visual review.

If phase batch is the last documented batch in a phase, conduct additional full phase review of all deliverables and ensure scope drift hasn't misaligned documents and left out additional deliverables from either current phase or deferred them to additional phases or future planning.

/close-out Phase-#-batch-# or Phase-#

Close out specified phase or phase batch following manual visual review and correction process. 
Audit docs in relation to specified phase or phase batch docs to ensure syncing across planning and canonical docs.  This is the only agent command that can close out a phase or phase batch.