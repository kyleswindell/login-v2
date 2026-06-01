@props([
    'title' => 'Active Batch Review',
    'items' => [],
    'focus' => [],
])

@php
    $normalizedItems = collect($items)
        ->map(function ($item): array {
            if (is_string($item)) {
                return ['id' => $item, 'note' => null];
            }

            return [
                'id' => (string) ($item['id'] ?? ''),
                'note' => filled($item['note'] ?? null) ? (string) $item['note'] : null,
            ];
        })
        ->filter(fn (array $item) => filled($item['id']))
        ->values()
        ->all();

    $focusNotes = collect(is_array($focus) ? $focus : [$focus])
        ->filter(fn ($note) => filled($note))
        ->values()
        ->all();
@endphp

<x-ui.patterns.proof-note
    semantic="warning"
    :title="$title"
    {{ $attributes->class(['ui-pattern-proof-review-banner']) }}
>
    <p class="ui-pattern-proof-review-copy">
        Temporary review overlay for the current active batch. This context is for reviewer focus only and is not part of the permanent component library contract.
    </p>

    @if ($normalizedItems !== [])
        <div class="ui-pattern-proof-review-queue">
            @foreach ($normalizedItems as $item)
                <div class="ui-pattern-proof-review-queue-item">
                    <x-ui.badge :label="$item['id']" semantic="warning" variant="outline" :show-icon="false" />
                    @if ($item['note'])
                        <p class="ui-pattern-proof-review-queue-copy">{{ $item['note'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($focusNotes !== [])
        <ul class="ui-pattern-proof-review-focus">
            @foreach ($focusNotes as $note)
                <li>{{ $note }}</li>
            @endforeach
        </ul>
    @endif
</x-ui.patterns.proof-note>
