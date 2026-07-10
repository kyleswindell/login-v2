{{-- ==========================================================================
    File: resources/views/components/ui/grid/index.blade.php
    Purpose: Grid container Blade adapter.

    Notes:
    - Provides a contractable Blade API for the app-owned Grid foundation.
    - Consumes the approved ui-css-grid and ui-subgrid utility classes.
    - Use this for page, section, dashboard, form, data, and pattern grid
      containers when the app layout is not already providing the grid wrapper.
    - When an app layout already owns the grid container, use x-ui.grid-column
      as direct page content instead.
    - Do not use this for small inline component internals.
    ========================================================================== --}}

@props ([
    "tag" => "div",
    "subgrid" => false,
    "fullWidth" => false,
    "rowGap" => false,
    "mode" => "default",
    "align" => null,
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
        'main',
        'aside',
        'header',
        'footer',
        'nav',
        'form',
        'ul',
        'ol',
    ];

    $allowedGridModes = [
        'default',
        'narrow',
        'condensed',
    ];

    $allowedSubgridModes = [
        'default',
        'wide',
        'narrow',
        'condensed',
    ];

    $allowedAlignments = [
        'start',
        'end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedTag = in_array($tag, $allowedTags, true)
        ? $tag
        : 'div';

    $isSubgrid = filter_var($subgrid, FILTER_VALIDATE_BOOLEAN);
    $usesFullWidth = filter_var($fullWidth, FILTER_VALIDATE_BOOLEAN);
    $usesRowGap = filter_var($rowGap, FILTER_VALIDATE_BOOLEAN);

    $resolvedMode = $isSubgrid
        ? (in_array($mode, $allowedSubgridModes, true) ? $mode : 'default')
        : (in_array($mode, $allowedGridModes, true) ? $mode : 'default');

    $resolvedAlign = is_string($align) && in_array($align, $allowedAlignments, true)
        ? $align
        : null;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = $isSubgrid
        ? [
            'ui-subgrid',
            'ui-subgrid--wide' => $resolvedMode === 'wide',
            'ui-subgrid--narrow' => $resolvedMode === 'narrow',
            'ui-subgrid--condensed' => $resolvedMode === 'condensed',
            'ui-subgrid--with-row-gap' => $usesRowGap,
        ]
        : [
            'ui-css-grid',
            'ui-css-grid--full-width' => $usesFullWidth,
            'ui-css-grid--with-row-gap' => $usesRowGap,
            'ui-css-grid--narrow' => $resolvedMode === 'narrow',
            'ui-css-grid--condensed' => $resolvedMode === 'condensed',
            'ui-css-grid--start' => $resolvedAlign === 'start',
            'ui-css-grid--end' => $resolvedAlign === 'end',
        ];
@endphp

<{{ $resolvedTag }}
    {{
        $attributes->class($classes)->merge([
            "data-ui-component" => "grid",
            "data-ui-grid" => "true",
            "data-ui-grid-kind" => $isSubgrid ? "subgrid" : "grid",
            "data-ui-grid-mode" => $resolvedMode,
            "data-ui-grid-align" => $resolvedAlign ?? "auto",
            "data-ui-grid-full-width" =>
                !$isSubgrid && $usesFullWidth ? "true" : "false",
            "data-ui-grid-row-gap" => $usesRowGap ? "true" : "false",
        ])
    }}
>
    {{ $slot }}
</{{ $resolvedTag }}>
