{{-- ==========================================================================
    File: resources/views/components/patterns/status-indicator/partials/differential.blade.php
    Purpose: Differential Indicator variant.

    Notes:
    - Differential indicators are a constrained status-indicator subset for
      changes, deltas, movement, additions, removals, and no-change states.
    - Uses Icon Indicator visual treatment and status color mapping.
    - Uses x-ui.icon for icon rendering.
    ========================================================================== --}}

<div
    id="{{ $resolvedId }}"
    {{
        $attributes
            ->except(["id"])
            ->class([
                "ui-icon-indicator",
                "ui-icon-indicator-20" => $resolvedIconSize === 20,
                "ui-icon-indicator--20" => $resolvedIconSize === 20,
            ])
            ->merge([
                "data-pattern" => "status-indicator",
                "data-ui-pattern" => "status-indicator",
                "data-ui-status-indicator" => "true",
                "data-ui-status-indicator-variant" => "differential",
                "data-ui-status-indicator-kind" => $resolvedDifferentialKind,
                "data-ui-status-indicator-direction" => $resolvedDirection,
            ])
    }}
>
    <x-ui.icon
        :name="$resolvedDifferentialIconName"
        :width="$resolvedIconSize"
        :height="$resolvedIconSize"
        class="ui-icon-indicator-{{ $resolvedDifferentialKind }} ui-icon-indicator--{{ $resolvedDifferentialKind }}"
        aria-hidden="true"
    />

    @if ($shouldHideLabel)
        <span class="ui-visually-hidden">
            {{ $resolvedDifferentialLabel }}
            @if (filled($value))
                {{ $value }}
            @endif
        </span>
    @else
        <span>
            {{ $resolvedDifferentialLabel }}
            @if (filled($value))
                {{ $value }}
            @endif
        </span>
    @endif
</div>
