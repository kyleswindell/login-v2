{{-- ==========================================================================
    File: resources/views/components/ui/grid-column/index.blade.php
    Purpose: Grid column Blade adapter.

    Notes:
    - Provides a contractable Blade API for direct children of x-ui.grid,
      app-layout grid wrappers, and approved subgrid regions.
    - Consumes the approved ui-css-grid-column and responsive placement
      utilities from the Grid foundation.
    - Page, module, and Pattern surfaces should own their column span decisions
      through this component instead of raw class clusters.
    - Do not use grid placement to visually reorder content against source or
      keyboard focus order.
    ========================================================================== --}}

@props ([
    "tag" => "div",
    "span" => "100",
    "sm" => null,
    "md" => null,
    "lg" => null,
    "xlg" => null,
    "max" => null,
    "start" => null,
    "end" => null,
    "smStart" => null,
    "smEnd" => null,
    "mdStart" => null,
    "mdEnd" => null,
    "lgStart" => null,
    "lgEnd" => null,
    "xlgStart" => null,
    "xlgEnd" => null,
    "maxStart" => null,
    "maxEnd" => null,
    "hang" => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTags = [
        'div',
        'section',
        'article',
        'aside',
        'header',
        'footer',
        'main',
        'li',
        'form',
    ];

    $allowedSpans = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        'auto',
        '100',
        '75',
        '50',
        '25',
    ];

    $spanAliases = [
        'full' => '100',
        'three-quarter' => '75',
        'three-quarters' => '75',
        'half' => '50',
        'one-half' => '50',
        'quarter' => '25',
        'one-quarter' => '25',
    ];

    $allowedStarts = [
        'auto',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
    ];

    $allowedEnds = [
        'auto',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    $resolveSpan = static function ($value, $default = null) use ($allowedSpans, $spanAliases): ?string {
        if (is_null($value) || $value === false) {
            return $default;
        }

        $resolvedValue = trim((string) $value);
        $resolvedValue = $spanAliases[$resolvedValue] ?? $resolvedValue;

        return in_array($resolvedValue, $allowedSpans, true)
            ? $resolvedValue
            : $default;
    };

    $resolveStart = static function ($value) use ($allowedStarts): ?string {
        if (is_null($value) || $value === false) {
            return null;
        }

        $resolvedValue = trim((string) $value);

        return in_array($resolvedValue, $allowedStarts, true)
            ? $resolvedValue
            : null;
    };

    $resolveEnd = static function ($value) use ($allowedEnds): ?string {
        if (is_null($value) || $value === false) {
            return null;
        }

        $resolvedValue = trim((string) $value);

        return in_array($resolvedValue, $allowedEnds, true)
            ? $resolvedValue
            : null;
    };

    $spanClass = static function (?string $breakpoint, string $value): string {
        return $breakpoint
            ? "ui-{$breakpoint}:col-span-{$value}"
            : "ui-col-span-{$value}";
    };

    $startClass = static function (?string $breakpoint, string $value): string {
        return $breakpoint
            ? "ui-{$breakpoint}:col-start-{$value}"
            : "ui-col-start-{$value}";
    };

    $endClass = static function (?string $breakpoint, string $value): string {
        return $breakpoint
            ? "ui-{$breakpoint}:col-end-{$value}"
            : "ui-col-end-{$value}";
    };

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedTag = in_array($tag, $allowedTags, true)
        ? $tag
        : 'div';

    $usesHang = filter_var($hang, FILTER_VALIDATE_BOOLEAN);

    $resolvedSpan = $resolveSpan($span, '100');
    $resolvedSm = $resolveSpan($sm);
    $resolvedMd = $resolveSpan($md);
    $resolvedLg = $resolveSpan($lg);
    $resolvedXlg = $resolveSpan($xlg);
    $resolvedMax = $resolveSpan($max);

    $resolvedStart = $resolveStart($start);
    $resolvedEnd = $resolveEnd($end);

    $resolvedSmStart = $resolveStart($smStart);
    $resolvedSmEnd = $resolveEnd($smEnd);

    $resolvedMdStart = $resolveStart($mdStart);
    $resolvedMdEnd = $resolveEnd($mdEnd);

    $resolvedLgStart = $resolveStart($lgStart);
    $resolvedLgEnd = $resolveEnd($lgEnd);

    $resolvedXlgStart = $resolveStart($xlgStart);
    $resolvedXlgEnd = $resolveEnd($xlgEnd);

    $resolvedMaxStart = $resolveStart($maxStart);
    $resolvedMaxEnd = $resolveEnd($maxEnd);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-css-grid-column',
        $spanClass(null, $resolvedSpan),
        $resolvedSm ? $spanClass('sm', $resolvedSm) : null,
        $resolvedMd ? $spanClass('md', $resolvedMd) : null,
        $resolvedLg ? $spanClass('lg', $resolvedLg) : null,
        $resolvedXlg ? $spanClass('xlg', $resolvedXlg) : null,
        $resolvedMax ? $spanClass('max', $resolvedMax) : null,

        $resolvedStart ? $startClass(null, $resolvedStart) : null,
        $resolvedEnd ? $endClass(null, $resolvedEnd) : null,

        $resolvedSmStart ? $startClass('sm', $resolvedSmStart) : null,
        $resolvedSmEnd ? $endClass('sm', $resolvedSmEnd) : null,

        $resolvedMdStart ? $startClass('md', $resolvedMdStart) : null,
        $resolvedMdEnd ? $endClass('md', $resolvedMdEnd) : null,

        $resolvedLgStart ? $startClass('lg', $resolvedLgStart) : null,
        $resolvedLgEnd ? $endClass('lg', $resolvedLgEnd) : null,

        $resolvedXlgStart ? $startClass('xlg', $resolvedXlgStart) : null,
        $resolvedXlgEnd ? $endClass('xlg', $resolvedXlgEnd) : null,

        $resolvedMaxStart ? $startClass('max', $resolvedMaxStart) : null,
        $resolvedMaxEnd ? $endClass('max', $resolvedMaxEnd) : null,

        'ui-grid-column-hang' => $usesHang,
    ];

    $dataAttributes = [
        'data-ui-component' => 'grid-column',
        'data-ui-grid-column' => 'true',
        'data-ui-grid-column-span' => $resolvedSpan,
        'data-ui-grid-column-hang' => $usesHang ? 'true' : 'false',
    ];

    if ($resolvedSm) {
        $dataAttributes['data-ui-grid-column-sm'] = $resolvedSm;
    }

    if ($resolvedMd) {
        $dataAttributes['data-ui-grid-column-md'] = $resolvedMd;
    }

    if ($resolvedLg) {
        $dataAttributes['data-ui-grid-column-lg'] = $resolvedLg;
    }

    if ($resolvedXlg) {
        $dataAttributes['data-ui-grid-column-xlg'] = $resolvedXlg;
    }

    if ($resolvedMax) {
        $dataAttributes['data-ui-grid-column-max'] = $resolvedMax;
    }

    if ($resolvedStart) {
        $dataAttributes['data-ui-grid-column-start'] = $resolvedStart;
    }

    if ($resolvedEnd) {
        $dataAttributes['data-ui-grid-column-end'] = $resolvedEnd;
    }
@endphp

<{{ $resolvedTag }}
    {{
        $attributes
            ->class($classes)
            ->merge($dataAttributes)
    }}
>
    {{ $slot }}
</{{ $resolvedTag }}>
