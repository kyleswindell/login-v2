{{-- ==========================================================================
    File: resources/views/components/shell/skip-to-content.blade.php
    Purpose: UI shell skip-to-content link.

    Notes:
    - Provides a keyboard-accessible bypass link to the main content region.
    - Default target is #main-content.
    - Should be rendered as the first focusable element inside the shell.
    - The target element must exist on the page and should usually be the main
      content landmark.
    ========================================================================== --}}

@props([
    'href' => '#main-content',
    'tabIndex' => 0,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Link Values
    |--------------------------------------------------------------------------
    */

    $resolvedHref = filled($href) ? $href : '#main-content';
    $resolvedTabIndex = is_numeric($tabIndex) ? (int) $tabIndex : 0;

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | href and tabindex are owned by explicit props so caller attributes cannot
    | accidentally duplicate them.
    |
    */

    $linkAttributes = $attributes->except([
        'href',
        'tabindex',
        'tabIndex',
    ]);
@endphp

<a
    href="{{ $resolvedHref }}"
    tabindex="{{ $resolvedTabIndex }}"
    {{ $linkAttributes->class('ui-shell-skip-to-content')->merge([
        'data-ui-component' => 'shell-skip-to-content',
        'data-ui-shell-skip-to-content' => true,
        'data-ui-shell-skip-to-content-target' => $resolvedHref,
    ]) }}
>
    @if ($slot->isEmpty())
        Skip to main content
    @else
        {{ $slot }}
    @endif
</a>