{{-- ==========================================================================
    File: resources/views/components/patterns/status-indicator/partials/badge.blade.php
    Purpose: Badge Indicator variant.

    Notes:
    - Mirrors Carbon BadgeIndicator behavior.
    - Count values greater than 999 render as 999+.
    - When no count is provided, renders dot badge variant.
    - Positioning remains owned by the consuming component context.
    ========================================================================== --}}

<span
    id="{{ $resolvedId }}"
    {{
        $attributes
            ->except(["id"])
            ->class([
                "ui-badge-indicator",
                "ui-badge-indicator-count" => $hasCount,
                "ui-badge-indicator--count" => $hasCount,
                "ui-badge-indicator-dot" => !$hasCount,
                "ui-badge-indicator--dot" => !$hasCount,
                "ui-badge-indicator-hidden" => $isBadgeHidden,
            ])
            ->merge([
                "data-pattern" => "status-indicator",
                "data-ui-pattern" => "status-indicator",
                "data-ui-status-indicator" => "true",
                "data-ui-status-indicator-variant" => "badge",
                "data-ui-status-indicator-kind" => $hasCount ? "count" : "dot",
                "data-ui-badge-indicator" => "true",
                "data-ui-badge-indicator-variant" => $hasCount ? "count" : "dot",
                "data-ui-badge-indicator-count" => $hasCount
                    ? (string) $countValue
                    : null,
                "data-ui-badge-indicator-hidden" => $isBadgeHidden ? "true" : "false",
                "aria-label" => $resolvedBadgeLabel,
            ])
    }}
    @if ($isBadgeHidden) hidden @endif
>
    @if ($hasCount)
        {{ $displayCount }}
    @endif
</span>
