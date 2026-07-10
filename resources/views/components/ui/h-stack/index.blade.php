{{-- ==========================================================================
    File: resources/views/components/ui/h-stack/index.blade.php
    Purpose: UI horizontal stack layout utility.

    Source: Converted from the Carbon HStack React component.

    Notes:
    - Thin wrapper around x-ui.stack.
    - Forces orientation="horizontal".
    - Passes through as, gap, slot, and caller attributes.
    ========================================================================== --}}

@props([
    'as' => 'div',
    'gap' => null,
])

<x-ui.stack
    :as="$as"
    :gap="$gap"
    orientation="horizontal"
    {{ $attributes->merge([
        'data-ui-component' => 'h-stack',
        'data-ui-h-stack' => true,
    ]) }}
>
    {{ $slot }}
</x-ui.stack>