{{-- ==========================================================================
    File: resources/views/components/shell/header-name.blade.php
    Purpose: UI shell header product/application name.

    Notes:
    - Renders the brand/name link inside the shell header.
    - Supports an optional leading organization/product prefix.
    - Uses app-owned shell selectors.
    ========================================================================== --}}

@props([
    'href' => '/',
    'prefix' => null,
    'wireNavigate' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-header__name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $linkAttributes = $attributes->except('href');
@endphp

<a
    href="{{ $href }}"
    @if ($wireNavigate) wire:navigate @endif
    {{ $linkAttributes->class($classes)->merge([
        'data-ui-shell-header-name' => true,
    ]) }}
>
    @if (filled($prefix))
        <span class="ui-shell-header__name-prefix">
            {{ $prefix }}
        </span>
        <span aria-hidden="true">&nbsp;</span>
    @endif

    <span class="ui-shell-header__name-text">
        {{ $slot }}
    </span>
</a>