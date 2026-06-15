@props([
    'size' => null,
])

@php
    $resolvedSize = in_array($size, ['sm', 'lg'], true) ? $size : 'lg';
@endphp

<div
    {{ $attributes->class(['ui-data-table-toolbar', 'ui-data-table-toolbar-'.$resolvedSize]) }}
    data-ui-data-table-toolbar
    data-ui-data-table-toolbar-size="{{ $resolvedSize }}"
>
    {{ $slot }}
</div>
