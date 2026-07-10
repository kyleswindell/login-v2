@props([
    'title' => null,
    'description' => null,
    'kicker' => null,
])

<x-patterns.content-section-block
    :title="$title"
    :description="$description"
    :kicker="$kicker"
    {{ $attributes->merge(['data-ui-pattern' => 'form-section']) }}
>
    {{ $slot }}

    @isset($headerActions)
        <x-slot:headerActions>
            {{ $headerActions }}
        </x-slot:headerActions>
    @endisset
</x-patterns.content-section-block>
