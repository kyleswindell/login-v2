{{-- ==========================================================================
    File: resources/views/components/shell/header-navigation.blade.php
    Purpose: UI shell header navigation region.

    Notes:
    - Renders the primary navigation list inside the shell header.
    - Children should usually be x-shell.header.menu-item or x-shell.header.menu.
    - Supports aria-label and aria-labelledby for accessible navigation naming.
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

    $navAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

<nav
    {{ $navAttributes->class('ui-shell-header__nav')->merge([
        'data-ui-shell-header-navigation' => true,
    ]) }}
    @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
    @if ($resolvedAriaLabelledby) aria-labelledby="{{ $resolvedAriaLabelledby }}" @endif
>
    <ul class="ui-shell-header__menu-bar" data-ui-shell-header-menu-bar>
        {{ $slot }}
    </ul>
</nav>
