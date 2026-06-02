@props([
    'title' => null,
    'description' => null,
    'kicker' => null,
    'meta' => [],
    'span' => null,
])

@php
    $metaEntries = collect(is_array($meta) ? $meta : [$meta])
        ->filter(fn ($value) => filled($value))
        ->values()
        ->all();

    $spanClass = match ($span) {
        '1x1' => 'ui-pattern-widget-span-1x1',
        '2x1' => 'ui-pattern-widget-span-2x1',
        '1x2' => 'ui-pattern-widget-span-1x2',
        '2x2' => 'ui-pattern-widget-span-2x2',
        '3x1' => 'ui-pattern-widget-span-3x1',
        '3x2' => 'ui-pattern-widget-span-3x2',
        '3x3' => 'ui-pattern-widget-span-3x3',
        default => null,
    };

    $hasHeader = $title || $description || $kicker || $metaEntries !== [] || isset($actions);
@endphp

<article
    {{ $attributes->class(['ui-pattern-widget-shell', $spanClass])->merge([
        'data-ui-pattern' => 'widget-shell',
        'data-ui-widget-span' => $span ?: 'flow',
    ]) }}
>
    @if ($hasHeader)
        <div class="ui-pattern-widget-shell-header">
            <div class="min-w-0 flex-1">
                @if ($kicker)
                    <p class="ui-kicker">{{ $kicker }}</p>
                @endif
                @if ($title)
                    <h3 class="ui-card-title @if($kicker) mt-2 @endif">{{ $title }}</h3>
                @endif
                @if ($description)
                    <p class="ui-card-copy">{{ $description }}</p>
                @endif
                @if ($metaEntries !== [])
                    <div class="ui-pattern-widget-shell-meta">
                        @foreach ($metaEntries as $entry)
                            <span>{{ $entry }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            @isset($actions)
                <div class="ui-pattern-widget-shell-actions">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    <div class="ui-pattern-widget-shell-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="ui-pattern-widget-shell-footer">
            {{ $footer }}
        </div>
    @endisset
</article>
