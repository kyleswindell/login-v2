#!/usr/bin/env bash

set -euo pipefail

# Default to the WSL SSH alias while still allowing the caller to swap targets
# from another machine without editing the helper script itself.
SSH_TARGET="${SSH_TARGET:-platform-prod-wsl}"
REMOTE_SCRIPT_PATH="${REMOTE_SCRIPT_PATH:-/var/www/platform/current/scripts/server/deploy-staging.sh}"
TARGET_BRANCH="${TARGET_BRANCH:-main}"

ssh "${SSH_TARGET}" "TARGET_BRANCH='${TARGET_BRANCH}' bash ${REMOTE_SCRIPT_PATH}"
