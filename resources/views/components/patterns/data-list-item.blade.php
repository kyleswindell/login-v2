@props([
    'title',
    'description' => null,
    'meta' => [],
])

<article {{ $attributes->class(['ui-pattern-data-list-item']) }} data-ui-pattern="data-list-item">
    <div class="min-w-0 flex-1">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div class="min-w-0 flex-1">
                <h3 class="ui-pattern-data-list-item-title">{{ $title }}</h3>
                @if ($description)
                    <p class="ui-pattern-data-list-item-copy">{{ $description }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="ui-pattern-data-list-item-actions">
                    {{ $actions }}
                </div>
            @endisset
        </div>

        @if ($meta !== [])
            <div class="ui-pattern-compact-meta ui-pattern-data-list-item-meta">
                @foreach ($meta as $entry)
                    <span class="ui-pattern-compact-meta-item">
                        @if (! $loop->first)
                            <span class="ui-pattern-compact-meta-separator" aria-hidden="true">•</span>
                        @endif
                        <span>{{ $entry }}</span>
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</article>
