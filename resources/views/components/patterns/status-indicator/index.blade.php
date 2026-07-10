{{-- ==========================================================================
    File: resources/views/components/patterns/status-indicator/index.blade.php
    Purpose: Status Indicator pattern.

    Notes:
    - Provides one public pattern API for Carbon-aligned status indicators.
    - Supports icon, shape, badge, and differential indicator variants.
    - Uses existing indicator CSS selectors and status tokens.
    - Uses x-ui.icon for icon-rendered indicator variants.
    - Does not own surrounding list, table, modal, notification, or form layout.
    ========================================================================== --}}

@props ([
    "id" => null,
    "variant" => "icon",
    "kind" => null,
    "label" => null,
    "count" => null,
    "value" => null,
    "direction" => null,
    "icon" => null,
    "size" => 16,
    "textSize" => 12,
    "hideLabel" => false,
    "hidden" => false,
    "hideWhenZero" => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = [
        'icon',
        'shape',
        'badge',
        'differential',
    ];

    $iconKinds = [
        'failed',
        'caution-major',
        'caution-minor',
        'undefined',
        'succeeded',
        'normal',
        'in-progress',
        'incomplete',
        'not-started',
        'pending',
        'unknown',
        'informative',
    ];

    $shapeKinds = [
        'failed',
        'critical',
        'high',
        'medium',
        'low',
        'cautious',
        'undefined',
        'stable',
        'informative',
        'incomplete',
        'draft',
    ];

    /*
    |--------------------------------------------------------------------------
    | Variant Resolution
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? $attributes->get('id') ?? 'status-indicator-'.Str::uuid();

    $resolvedVariant = in_array($variant, $allowedVariants, true)
        ? $variant
        : 'icon';

    $normalizedKind = is_string($kind)
        ? strtolower(trim($kind))
        : null;

    $normalizedDirection = is_string($direction)
        ? strtolower(trim($direction))
        : null;

    $resolvedLabel = $label;
    $shouldHideLabel = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Icon Indicator Mapping
    |--------------------------------------------------------------------------
    */

    $iconKindAliases = [
        'error' => 'failed',
        'danger' => 'failed',
        'critical' => 'failed',
        'major' => 'caution-major',
        'warning' => 'caution-minor',
        'minor' => 'caution-minor',
        'success' => 'succeeded',
        'stable' => 'normal',
        'info' => 'informative',
        'notice' => 'informative',
        'neutral' => 'unknown',
        'draft' => 'incomplete',
    ];

    $iconNames = [
        'failed' => 'error--filled',
        'caution-major' => 'warning--alt-inverted--filled',
        'caution-minor' => 'warning--alt--filled',
        'undefined' => 'undefined--filled',
        'succeeded' => 'checkmark--filled',
        'normal' => 'checkmark--outline',
        'in-progress' => 'in-progress',
        'incomplete' => 'incomplete',
        'not-started' => 'circle-dash',
        'pending' => 'pending--filled',
        'unknown' => 'unknown--filled',
        'informative' => 'warning-square--filled',
    ];

    $requestedIconKind = $iconKindAliases[$normalizedKind] ?? $normalizedKind;

    $resolvedIconKind = in_array($requestedIconKind, $iconKinds, true)
        ? $requestedIconKind
        : 'informative';

    $resolvedIconName = $icon ?: $iconNames[$resolvedIconKind];

    $resolvedIconSize = in_array((int) $size, [16, 20], true)
        ? (int) $size
        : 16;

    /*
    |--------------------------------------------------------------------------
    | Shape Indicator Mapping
    |--------------------------------------------------------------------------
    */

    $shapeKindAliases = [
        'error' => 'failed',
        'danger' => 'failed',
        'success' => 'stable',
        'info' => 'informative',
        'notice' => 'undefined',
        'warning' => 'cautious',
    ];

    $shapeIconNames = [
        'failed' => 'critical',
        'critical' => 'critical-severity',
        'high' => 'caution',
        'medium' => 'diamond--filled',
        'low' => 'low-severity',
        'cautious' => 'caution',
        'undefined' => 'diamond--filled',
        'stable' => 'circle--filled',
        'informative' => 'low-severity',
        'incomplete' => 'incomplete',
        'draft' => 'circle-stroke',
    ];

    $requestedShapeKind = $shapeKindAliases[$normalizedKind] ?? $normalizedKind;

    $resolvedShapeKind = in_array($requestedShapeKind, $shapeKinds, true)
        ? $requestedShapeKind
        : 'informative';

    $resolvedShapeIconName = $icon ?: $shapeIconNames[$resolvedShapeKind];

    $resolvedTextSize = in_array((int) $textSize, [12, 14], true)
        ? (int) $textSize
        : 12;

    /*
    |--------------------------------------------------------------------------
    | Badge Indicator State
    |--------------------------------------------------------------------------
    */

    $countValue = is_numeric($count)
        ? (int) $count
        : null;

    $hasCount = ! is_null($countValue);

    $displayCount = $hasCount
        ? ($countValue > 999 ? '999+' : (string) $countValue)
        : '';

    $isBadgeHidden = filter_var($hidden, FILTER_VALIDATE_BOOLEAN)
        || ($hasCount && $countValue === 0 && filter_var($hideWhenZero, FILTER_VALIDATE_BOOLEAN));

    $resolvedBadgeLabel = filled($resolvedLabel)
        ? $resolvedLabel
        : ($hasCount ? "{$displayCount} status items" : 'Status indicator');

    /*
    |--------------------------------------------------------------------------
    | Differential Indicator Mapping
    |--------------------------------------------------------------------------
    */

    $differentialMap = [
        'increase' => [
            'icon' => 'arrow--up',
            'kind' => 'succeeded',
            'label' => 'Increase',
        ],
        'up' => [
            'icon' => 'arrow--up',
            'kind' => 'succeeded',
            'label' => 'Increase',
        ],
        'positive' => [
            'icon' => 'arrow--up',
            'kind' => 'succeeded',
            'label' => 'Positive change',
        ],
        'enabled' => [
            'icon' => 'add',
            'kind' => 'succeeded',
            'label' => 'Enabled',
        ],
        'added' => [
            'icon' => 'add',
            'kind' => 'succeeded',
            'label' => 'Added',
        ],
        'decrease' => [
            'icon' => 'arrow--down',
            'kind' => 'failed',
            'label' => 'Decrease',
        ],
        'down' => [
            'icon' => 'arrow--down',
            'kind' => 'failed',
            'label' => 'Decrease',
        ],
        'negative' => [
            'icon' => 'arrow--down',
            'kind' => 'failed',
            'label' => 'Negative change',
        ],
        'disabled' => [
            'icon' => 'subtract',
            'kind' => 'failed',
            'label' => 'Disabled',
        ],
        'removed' => [
            'icon' => 'subtract',
            'kind' => 'failed',
            'label' => 'Removed',
        ],
        'unchanged' => [
            'icon' => 'subtract',
            'kind' => 'unknown',
            'label' => 'No change',
        ],
        'neutral' => [
            'icon' => 'subtract',
            'kind' => 'unknown',
            'label' => 'No change',
        ],
    ];

    $resolvedDirection = array_key_exists((string) $normalizedDirection, $differentialMap)
        ? (string) $normalizedDirection
        : 'unchanged';

    $differentialConfig = $differentialMap[$resolvedDirection];

    $requestedDifferentialKind = $iconKindAliases[$normalizedKind] ?? $normalizedKind;

    $resolvedDifferentialKind = in_array($requestedDifferentialKind, $iconKinds, true)
        ? $requestedDifferentialKind
        : $differentialConfig['kind'];

    $resolvedDifferentialIconName = $icon ?: $differentialConfig['icon'];

    $resolvedDifferentialLabel = filled($resolvedLabel)
        ? $resolvedLabel
        : $differentialConfig['label'];
@endphp

@if ($resolvedVariant === "badge")
    @include ("components.patterns.status-indicator.partials.badge")
@elseif ($resolvedVariant === "shape")
    @include ("components.patterns.status-indicator.partials.shape")
@elseif ($resolvedVariant === "differential")
    @include ("components.patterns.status-indicator.partials.differential")
@else
    @include ("components.patterns.status-indicator.partials.icon")
@endif
