{{-- ==========================================================================
    File: resources/views/components/ui/data-table/body.blade.php
    Purpose: Data Table body section wrapper.

    Notes:
    - Provides the native tbody wrapper for rendered rows.
    - Keeps aria-live constrained to valid live-region values.
    ========================================================================== --}}

@props([
    'ariaLive' => 'polite',
])

<tbody
    {{ $attributes }}
    aria-live="{{ in_array($ariaLive, ['polite', 'assertive', 'off'], true) ? $ariaLive : 'polite' }}"
>
    {{ $slot }}
</tbody>
