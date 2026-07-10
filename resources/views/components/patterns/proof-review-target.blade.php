@props([
    'title' => 'Active Batch Review Target',
    'items' => [],
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
@endphp

@if ($normalizedItems !== [])
    <x-ui.notification.inline
        kind="warning"
        :title="$title"
        {{ $attributes->class(['ui-pattern-proof-review-target'])->merge(['data-ui-pattern' => 'proof-review-target']) }}
    >
        <div class="ui-pattern-proof-review-target-badges">
            @foreach ($normalizedItems as $item)
                <x-ui.tag :label="$item['id']" tone="warning" size="sm" />
            @endforeach
        </div>

        <div class="ui-pattern-proof-review-target-copy">
            @foreach ($normalizedItems as $item)
                @if ($item['note'])
                    <p>{{ $item['note'] }}</p>
                @endif
            @endforeach
        </div>
    </x-ui.notification.inline>
@endif
