{{-- ==========================================================================
    File: resources/views/components/ui/content-switcher/index.blade.php
    Purpose: Segmented content switcher control.

    Notes:
    - Uses app-owned UI classes.
    - Child options should be x-ui.content-switcher-option.
    - JavaScript behavior is handled by initContentSwitchers().
    ========================================================================== --}}

@props([
    'size' => 'md',
    'lowContrast' => false,
    'selectionMode' => 'automatic',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $allowedSelectionModes = [
        'automatic',
        'manual',
    ];

    $resolvedSelectionMode = in_array($selectionMode, $allowedSelectionModes, true)
        ? $selectionMode
        : 'automatic';

    $isLowContrast = filter_var($lowContrast, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-content-switcher',
        'ui-content-switcher--'.$resolvedSize,
        'ui-layout--size-'.$resolvedSize,
        'ui-content-switcher--low-contrast' => $isLowContrast,
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'role' => 'tablist',
        'data-ui-component' => 'content-switcher',
        'data-ui-content-switcher' => true,
        'data-ui-content-switcher-size' => $resolvedSize,
        'data-ui-content-switcher-selection-mode' => $resolvedSelectionMode,
        'data-ui-content-switcher-low-contrast' => $isLowContrast ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</div>