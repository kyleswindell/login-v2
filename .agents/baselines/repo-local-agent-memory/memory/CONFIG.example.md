# Agent Memory Configuration Example

Fill or adapt this for the target repo before agents begin writing memory.

## Owner Paths

- canonical docs root: `<canonical-docs-root>`
- active workflow state root: `<active-workspace-root or none>`
- branch handoff root: `<branch-handoff-root or none>`
- review/governance artifact root: `<review-ledger-root or none>`

## Memory Policy Decisions

- stable memory allowed: `yes`
- working memory allowed: `yes`
- ephemeral memory allowed: `yes`
- secrets allowed: `no`
- raw sensitive production/customer data allowed: `no`

## Repo-Specific Exclusions

- none recorded

## Notes

- replace placeholders before use
- if the repo does not have one of these owner paths, set it to `none`
- do not let this configuration become a second documentation index
