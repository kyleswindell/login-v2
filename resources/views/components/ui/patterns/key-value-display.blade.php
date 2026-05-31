@props([
    'items' => [],
    'columns' => 2,
])

@php
    $columnClasses = match ((int) $columns) {
        1 => 'grid-cols-1',
        3 => 'grid-cols-1 md:grid-cols-3',
        default => 'grid-cols-1 sm:grid-cols-2',
    };
@endphp

<dl data-ui-pattern="key-value-display" {{ $attributes->class(['ui-pattern-key-value-display', 'grid gap-5', $columnClasses]) }}>
    @foreach ($items as $item)
        <div>
            <dt class="ui-pattern-key-value-label">{{ $item['label'] ?? '' }}</dt>
            <dd class="ui-pattern-key-value-value">
                {!! $item['value'] ?? '' !!}
            </dd>
        </div>
    @endforeach
</dl>
