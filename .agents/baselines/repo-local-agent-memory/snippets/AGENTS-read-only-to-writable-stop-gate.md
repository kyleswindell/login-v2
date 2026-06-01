## Read-Only To Writable Stop Gate

- If a read-only planning, research, audit, or review session becomes ready to write while another writable session already owns the current working tree, stop before editing and require either:
  - a separate branch plus separate worktree for the new writable session
  - or an explicit handoff of writable ownership into the current session
