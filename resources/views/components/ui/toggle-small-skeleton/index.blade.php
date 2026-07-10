{{-- ==========================================================================
    File: resources/views/components/ui/toggle-small-skeleton/index.blade.php
    Purpose: Small Toggle skeleton/loading placeholder component.

    Notes:
    - Convenience wrapper around resources/views/components/ui/toggle-skeleton/index.blade.php.
    - Forces size="sm".
    - Does not render an interactive input.
    ========================================================================== --}}

@props([
'id' => null,
'labelText' => null,
'ariaLabel' => null,
])

<x-ui.toggle-skeleton
    :id="$id"
    size="sm"
    :label-text="$labelText"
    :aria-label="$ariaLabel"
    {{ $attributes }} />