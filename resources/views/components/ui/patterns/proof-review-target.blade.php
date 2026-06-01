@props([
    'title' => 'Active Batch Review Target',
    'items' => [],
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
@endphp

@if ($normalizedItems !== [])
    <x-ui.inline-alert
        semantic="warning"
        :title="$title"
        {{ $attributes->class(['ui-pattern-proof-review-target'])->merge(['data-ui-pattern' => 'proof-review-target']) }}
    >
        <div class="ui-pattern-proof-review-target-badges">
            @foreach ($normalizedItems as $item)
                <x-ui.badge :label="$item['id']" semantic="warning" variant="outline" :show-icon="false" />
            @endforeach
        </div>

        <div class="ui-pattern-proof-review-target-copy">
            @foreach ($normalizedItems as $item)
                @if ($item['note'])
                    <p>{{ $item['note'] }}</p>
                @endif
            @endforeach
        </div>
    </x-ui.inline-alert>
@endif
