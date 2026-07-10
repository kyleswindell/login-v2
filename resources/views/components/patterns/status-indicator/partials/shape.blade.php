{{-- ==========================================================================
    File: resources/views/components/patterns/status-indicator/partials/shape.blade.php
    Purpose: Shape Indicator variant.

    Notes:
    - Mirrors Carbon ShapeIndicator behavior.
    - Uses x-ui.icon for shape rendering.
    - Applies shape kind class to the icon itself so existing
      shape-indicator CSS controls semantic color.
    ========================================================================== --}}

<div
    id="{{ $resolvedId }}"
    {{
        $attributes
            ->except(["id"])
            ->class([
                "ui-shape-indicator",
                "ui-shape-indicator-14" => $resolvedTextSize === 14,
                "ui-shape-indicator--14" => $resolvedTextSize === 14,
            ])
            ->merge([
                "data-pattern" => "status-indicator",
                "data-ui-pattern" => "status-indicator",
                "data-ui-status-indicator" => "true",
                "data-ui-status-indicator-variant" => "shape",
                "data-ui-status-indicator-kind" => $resolvedShapeKind,
            ])
    }}
>
    <x-ui.icon
        :name="$resolvedShapeIconName"
        width="16"
        height="16"
        class="ui-shape-indicator-{{ $resolvedShapeKind }} ui-shape-indicator--{{ $resolvedShapeKind }}"
        aria-hidden="true"
    />

    @if ($shouldHideLabel)
        <span class="ui-visually-hidden"> {{ $resolvedLabel }} </span>
    @else
        <span> {{ $resolvedLabel }} </span>
    @endif
</div>
