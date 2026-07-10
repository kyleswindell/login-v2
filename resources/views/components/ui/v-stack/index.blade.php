{{-- ==========================================================================
    File: resources/views/components/ui/v-stack/index.blade.php
    Purpose: UI vertical stack layout utility.

    Source: Converted from the Carbon VStack React component.

    Notes:
    - Thin wrapper around x-ui.stack.
    - Forces orientation="vertical".
    - Passes through as, gap, slot, and caller attributes.
    ========================================================================== --}}

@props([
    'as' => 'div',
    'gap' => null,
])

<x-ui.stack
    :as="$as"
    :gap="$gap"
    orientation="vertical"
    {{ $attributes->merge([
        'data-ui-component' => 'v-stack',
        'data-ui-v-stack' => true,
    ]) }}
>
    {{ $slot }}
</x-ui.stack>