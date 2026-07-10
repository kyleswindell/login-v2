{{-- ==========================================================================
    File: resources/views/components/ui/danger-button/index.blade.php
    Purpose: Convenience alias for rendering a danger Button.

    Notes:
    - Emits the same markup as resources/views/components/ui/button/index.blade.php.
    - Forces kind="danger" unless explicitly overridden.
    - Does not define a separate CSS contract.
    - Danger Button styles are handled by resources/css/components/button.css.
    ========================================================================== --}}

@props([
'kind' => 'danger',
])

{{-- ----------------------------------------------------------------------
    Danger Button alias
    ----------------------------------------------------------------------
    This wrapper keeps a dedicated danger-button entry available while routing
    all rendering through the canonical Button component.
    ---------------------------------------------------------------------- --}}

<x-ui.button
    :kind="$kind"
    {{ $attributes }}>
    {{ $slot }}
</x-ui.button>