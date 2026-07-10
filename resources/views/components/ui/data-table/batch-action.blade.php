{{-- ==========================================================================
    File: resources/views/components/ui/data-table/batch-action.blade.php
    Purpose: Data Table batch-action button wrapper.

    Notes:
    - Composes the existing x-ui.button component.
    - Provides batch-action classes and data attributes for table toolbar use.
    - Action behavior is supplied by the caller.
    ========================================================================== --}}

@props([
    'type' => 'button',
    'semantic' => 'primary',
    'size' => 'sm',
    'disabled' => false,
    'hasIconOnly' => false,
])

<x-ui.button
    :type="$type"
    :semantic="$semantic"
    :size="$size"
    :disabled="$disabled"
    {{ $attributes->class([
        'ui-batch-action',
        'ui-batch-action--icon-only' => $hasIconOnly,
    ])->merge([
        'data-ui-table-batch-action' => true,
    ]) }}
>
    {{ $slot }}
</x-ui.button>
