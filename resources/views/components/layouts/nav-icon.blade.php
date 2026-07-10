{{-- ==========================================================================
    File: resources/views/components/layouts/nav-icon.blade.php
    Purpose: Legacy navigation icon adapter.

    Notes:
    - Uses x-ui.icon instead of x-dynamic-component so missing or invalid icon
      names cannot break the full view.
    - This component is transitional. New code should call x-ui.icon directly.
    ========================================================================== --}}

@props([
    'icon' => 'empty',
    'size' => 'md',
    'decorative' => true,
    'label' => null,
    'labelledby' => null,
])

<x-ui.icon
    :name="$icon"
    :size="$size"
    :decorative="$decorative"
    :label="$label"
    :labelledby="$labelledby"
    {{ $attributes }}
/>
