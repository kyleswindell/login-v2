{{-- ==========================================================================
    File: resources/views/components/ui/dialog/subtitle.blade.php
    Purpose: UI dialog subtitle.

    Source: Converted from the Carbon DialogSubtitle React component.

    Notes:
    - Carbon renders this through Text as h2.
    - The default tag is h2 to mirror the source.
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
        'h2',
        'h3',
        'h4',
        'p',
        'div',
    ];

    $resolvedTag = in_array($tag, $allowedTags, true)
        ? $tag
        : 'h2';
@endphp

<{{ $resolvedTag }}
    {{ $attributes->class('ui-dialog-header__label')->merge([
        'data-ui-component' => 'dialog-subtitle',
        'data-ui-dialog-subtitle' => true,
    ]) }}
>
    {{ $slot }}
</{{ $resolvedTag }}>