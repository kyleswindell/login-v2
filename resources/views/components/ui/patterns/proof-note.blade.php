@props([
    'title' => null,
    'semantic' => 'notice',
])

<x-ui.inline-alert
    :semantic="$semantic"
    :title="$title"
    {{ $attributes->class(['ui-pattern-proof-note']) }}
>
    {{ $slot }}
</x-ui.inline-alert>
