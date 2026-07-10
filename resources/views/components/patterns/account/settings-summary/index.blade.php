{{-- ==========================================================================
    File: resources/views/components/patterns/account/settings-summary/index.blade.php
    Purpose: Backward-compatible account settings summary alias.

    Notes:
    - This pattern is now a thin alias for x-patterns.key-value-display.
    - Prefer x-patterns.key-value-display directly in new code.
    - Kept only so existing account pages do not break during migration.
    ========================================================================== --}}

@props ([
    "items" => [],
    "columns" => 2,
    "emptyText" => "No details available.",
    "emptyValue" => "—",
    "compact" => false,
])

<x-patterns.key-value-display
    :items="$items"
    :columns="$columns"
    :empty-text="$emptyText"
    :empty-value="$emptyValue"
    :compact="$compact"
    {{ $attributes }}
/>
