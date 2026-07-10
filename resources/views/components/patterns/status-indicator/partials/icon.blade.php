{{-- ==========================================================================
    File: resources/views/components/patterns/status-indicator/partials/icon.blade.php
    Purpose: Icon Indicator variant.

    Notes:
    - Mirrors Carbon IconIndicator behavior.
    - Uses x-ui.icon for icon rendering.
    - Applies status kind class to the icon itself so existing
      icon-indicator CSS controls semantic color.
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
                "data-ui-status-indicator-variant" => "icon",
                "data-ui-status-indicator-kind" => $resolvedIconKind,
            ])
    }}
>
    <x-ui.icon
        :name="$resolvedIconName"
        :width="$resolvedIconSize"
        :height="$resolvedIconSize"
        class="ui-icon-indicator-{{ $resolvedIconKind }} ui-icon-indicator--{{ $resolvedIconKind }}"
        aria-hidden="true"
    />

    @if ($shouldHideLabel)
        <span class="ui-visually-hidden"> {{ $resolvedLabel }} </span>
    @else
        <span> {{ $resolvedLabel }} </span>
    @endif
</div>
