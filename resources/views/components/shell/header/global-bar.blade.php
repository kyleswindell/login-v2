{{-- ==========================================================================
    File: resources/views/components/shell/header-global-bar.blade.php
    Purpose: UI shell header global actions container.

    Notes:
    - Generic container for x-shell.header.global-action components.
    - Intended for persistent header actions such as search, notifications,
      account, theme, switcher, or settings.
    - This component is structural only; individual action behavior belongs to
      child action components or installed shell JavaScript.
    ========================================================================== --}}

<div
    {{ $attributes->class('ui-shell-header__global')->merge([
        'data-ui-shell-header-global-bar' => true,
    ]) }}
>
    {{ $slot }}
</div>
