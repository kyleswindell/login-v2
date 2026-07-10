@props([
    'title' => 'Active Batch Review',
    'items' => [],
    'focus' => [],
])

@php
    $activeQueueItems = array_flip(\App\Support\ActiveBatchReviewQueue::implementedPendingReviewIds());

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
        ->filter(fn (array $item) => array_key_exists($item['id'], $activeQueueItems))
        ->values()
        ->all();

    $focusNotes = collect(is_array($focus) ? $focus : [$focus])
        ->filter(fn ($note) => filled($note))
        ->values()
        ->all();
@endphp

@if ($normalizedItems !== [])
    <x-patterns.proof-note
        semantic="warning"
        :title="$title"
        {{ $attributes->class(['ui-pattern-proof-review-banner']) }}
    >
        <p class="ui-pattern-proof-review-copy">
            Temporary review overlay for the current active batch. This context is for reviewer focus only and is not part of the permanent component library contract.
        </p>

        <div class="ui-pattern-proof-review-queue">
            @foreach ($normalizedItems as $item)
                <div class="ui-pattern-proof-review-queue-item">
                    <x-ui.tag :label="$item['id']" tone="warning" size="sm" />
                    @if ($item['note'])
                        <p class="ui-pattern-proof-review-queue-copy">{{ $item['note'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($focusNotes !== [])
            <ul class="ui-pattern-proof-review-focus">
                @foreach ($focusNotes as $note)
                    <li>{{ $note }}</li>
                @endforeach
            </ul>
        @endif
    </x-patterns.proof-note>
@endif
