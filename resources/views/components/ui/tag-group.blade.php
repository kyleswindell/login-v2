@props([
    'label' => null,
    'selectionMode' => null,
])

@php
    $resolvedSelectionMode = in_array($selectionMode, ['single', 'multiple'], true) ? $selectionMode : null;
@endphp

<div
    {{ $attributes->class('ui-tag-group') }}
    role="group"
    @if ($label) aria-label="{{ $label }}" @endif
    @if ($resolvedSelectionMode) data-ui-tag-selection-mode="{{ $resolvedSelectionMode }}" @endif
    data-ui-tag-group
>
    {{ $slot }}
</div>
