@props([
    'range' => false,
    'size' => 'md',
    'style' => 'default',
])

@php
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $style = $style === 'fluid' ? 'fluid' : 'default';
@endphp

<div
    {{ $attributes->class([
        'ui-date-picker',
        'ui-date-picker-skeleton',
        'ui-date-picker-skeleton-'.$size,
        'ui-date-picker-skeleton-'.$style,
    ]) }}
    data-ui-component="date-picker-skeleton"
    data-ui-date-picker-skeleton
    aria-busy="true"
>
    <div class="ui-date-picker-skeleton-row">
        <span class="ui-date-picker-skeleton-field"></span>
        @if($range)
            <span class="ui-date-picker-skeleton-field"></span>
        @endif
    </div>
</div>
