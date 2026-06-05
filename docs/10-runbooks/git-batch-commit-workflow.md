# Git Batch Commit Workflow

## Purpose

Define the required git commit and push checkpoints for batch-based work so implementation stays organized, reviewable, and recoverable.

This workflow applies to all active-batch execution using `/docs/08-active/`.

---

## Core Rules

- One commit must map to one batch and one concern.
- Do not mix unrelated docs, code, cleanup, or future work in the same commit.
- Do not include unrelated staged or modified files.
- If unrelated issues are found during a batch, record them in `notes.md` and leave them out of the commit.
- `git status` must be reviewed before every commit.
- Batch work should produce multiple small, meaningful save points rather than one large commit.
- Local development verification should be used before server push/deploy whenever it can prove the change.
- Push/deploy work should be reserved for review-ready checkpoints, revalidation checkpoints, or environment-specific checks that cannot be proven locally.

---

## Read Path

- [Commit Checkpoints](git-batch-commit-workflow/commit-checkpoints.md) for initialization, implementation, review-ready, review-fix, and finalize commits.
- [Push And Parallel Branches](git-batch-commit-workflow/push-and-parallel-branches.md) for push timing, worker commits, and integrator commits.
- [Scope Hygiene And Stop Conditions](git-batch-commit-workflow/scope-hygiene-and-stop-conditions.md) for staged-file hygiene, message patterns, and commit stop rules.

---

## Related Runbooks

- [Batch Workflow](batch-workflow.md)
- [Commit And Deployment](batch-workflow/commit-and-deployment.md)
- [Branch-Based Batch Integration](branch-based-batch-integration.md)
- [Local Development](local-dev.md)

---

## Final Rule

If a change cannot be described as one batch and one concern, it should not be committed yet.
