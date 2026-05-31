@props([
    'title' => 'Review the highlighted fields',
    'errors' => [],
])

<x-ui.inline-alert
    semantic="danger"
    :title="$title"
    {{ $attributes->merge(['data-ui-pattern' => 'validation-summary']) }}
>
    <ul class="list-disc space-y-1 pl-4 text-sm">
        @foreach ($errors as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-ui.inline-alert>
