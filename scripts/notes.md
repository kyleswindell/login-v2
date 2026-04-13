# Agent + WSL Workflow Notes

This page is a quick runbook for using agent prompts, git branches, and staging visual review during phase and phase-batch work.

Server repo path reminder (direct server deploy context):

cd /var/www/platform/current

## 1) Standard Agent Flow

Use this order unless a task explicitly says otherwise:

1. /phase-planning (when phase scope is new or changing)
2. /phase-batch-planning (define batch order and readiness)
3. /phase-batch-implementation (build the batch)
4. /phase-batch-review (review diff, tests, and docs)
5. /phase-batch-close-out (mark batch complete and sync parent phase docs)
6. /phase-close-out (phase-level final close-out after relevant batches are closed)

Use /phase-batch-development only when planning did not leave the batch implementation-ready.

## 2) Branch Naming (Recommended)

- Implementation branch: feature/phase-2-batch-11
- Visual review branch: review/phase-2-batch-11

Keep one batch per branch when possible.

## 3) WSL Terminal Setup (Local)

Run from WSL:

cd /mnt/c/Users/kswin/Desktop/Work\ 2023/8.\ Login\ V2

Check branch and status:

git branch --show-current
git status -sb

Create and switch to a batch branch:

git checkout -b feature/phase-2-batch-11

or switch to existing branch:

git checkout feature/phase-2-batch-11

## 4) Implementation + Review Commands (WSL)

Run targeted test(s):

docker compose exec -T app php artisan test tests/Feature/Platform/PlatformDashboardTest.php --no-coverage

Run full tests when needed:

docker compose exec -T app php artisan test

Stage and commit scoped files only:

git add <file1> <file2> <file3>
git commit -m "feat(phase-2-batch-11): implement dashboard batch scope"

Push branch for review:

git push -u origin feature/phase-2-batch-11

## 5) Visual QA On Staging Before Batch Close-Out

Deploy review branch to staging:

TARGET_BRANCH=feature/phase-2-batch-11 bash scripts/deploy-staging-remote.sh

After visual QA, restore staging to main:

TARGET_BRANCH=main bash scripts/deploy-staging-remote.sh

Important:

- Do not merge to main only to preview UI.
- Promote to main only after review and visual QA approval.

## 6) Batch Close-Out Checklist

After /phase-batch-review and approved visual QA:

1. Confirm approved branch is pushed.
2. Confirm staging review result is recorded.
3. Run /phase-batch-close-out to sync batch status, deferments, and parent phase notes.
4. Push close-out docs commit if changes were made.

## 7) Phase Close-Out Checklist

Run /phase-close-out only when relevant batches are already batch-closed-out (or explicitly deferred).

Phase close-out should be phase-level aggregation and final sync, not first-pass batch cleanup.

## 8) Helpful Git Commands

Show what changed since last push:

git status -sb
git log --oneline --decorate -n 8

Show files in the last commit:

git show --name-only --oneline

Show diff against origin branch:

git fetch origin
git diff --name-status origin/$(git branch --show-current)..HEAD