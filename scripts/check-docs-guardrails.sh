#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

failures=0

check_pattern() {
    local label="$1"
    local pattern="$2"

    local docs_matches=""
    docs_matches="$(rg -n -P "$pattern" docs --glob '!docs/_archive/**' || true)"
    local root_matches=""
    root_matches="$(rg -n -P "$pattern" AGENTS.md || true)"

    if [[ -n "$docs_matches" || -n "$root_matches" ]]; then
        echo "[FAIL] ${label}"
        [[ -n "$docs_matches" ]] && echo "$docs_matches"
        [[ -n "$root_matches" ]] && echo "$root_matches"
        failures=1
    fi
}

check_pattern "Legacy /docs-v2/ markdown link target found" '\[[^]]+\]\([^)]*/docs-v2/[^)]*\)'
check_pattern "Legacy docs/V2 App/ markdown link target found" '\[[^]]+\]\([^)]*docs/V2( |%20)App/[^)]*\)'
check_pattern "Legacy wiki link found" '(?<!`)\[\[V1 App/[^]]*\]\](?!`)'

if [[ "$failures" -ne 0 ]]; then
    echo "Docs guardrail check failed."
    exit 1
fi

echo "Docs guardrail check passed."
