{{-- ==========================================================================
    File: resources/views/components/shell/header.blade.php
    Purpose: UI shell header landmark.

    Notes:
    - Owns the persistent shell header region.
    - Supports optional aria-label or aria-labelledby.
    - Header contents are slot-driven so the app can compose brand, navigation,
      global actions, menus, and panels without hardcoding product structure.
    ========================================================================== --}}

@props([
    'label' => null,
    'labelledby' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | ARIA attributes
    |--------------------------------------------------------------------------
    */

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $headerAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

<header
    {{ $headerAttributes->class('ui-shell-header')->merge([
        'aria-label' => $resolvedAriaLabel,
        'aria-labelledby' => $resolvedAriaLabelledby,
        'data-ui-shell-header' => true,
    ]) }}
>
    {{ $slot }}
</header>