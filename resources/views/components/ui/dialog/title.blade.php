{{-- ==========================================================================
    File: resources/views/components/ui/dialog/title.blade.php
    Purpose: UI dialog title.

    Source: Converted from the Carbon DialogTitle React component.

    Notes:
    - Renders an h2 by default.
    - Applies the ui-dialog-header__heading class.
    ========================================================================== --}}

@props([
    'tag' => 'h2',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTags = [
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
    ];

    $resolvedTag = in_array($tag, $allowedTags, true)
        ? $tag
        : 'h2';
@endphp

<{{ $resolvedTag }}
    {{ $attributes->class('ui-dialog-header__heading')->merge([
        'data-ui-component' => 'dialog-title',
        'data-ui-dialog-title' => true,
    ]) }}
>
    {{ $slot }}
</{{ $resolvedTag }}>