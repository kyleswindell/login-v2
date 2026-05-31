@props([
    'label',
    'value',
    'supportingText' => null,
    'trendLabel' => null,
    'trendSemantic' => 'neutral',
    'icon' => null,
])

<article {{ $attributes->class(['ui-pattern-stat-card']) }} data-ui-pattern="stat-card">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            <p class="ui-stat-label">{{ $label }}</p>
            <p class="ui-stat-value">{{ $value }}</p>
        </div>

        @if ($icon)
            <span class="ui-pattern-stat-card-icon" aria-hidden="true">
                <x-dynamic-component :component="$icon" class="h-5 w-5" />
            </span>
        @endif
    </div>

    @if ($supportingText || $trendLabel)
        <div class="mt-3 flex flex-wrap items-center gap-2">
            @if ($trendLabel)
                <x-ui.badge :label="$trendLabel" :semantic="$trendSemantic" variant="outline" :show-icon="false" />
            @endif
            @if ($supportingText)
                <p class="ui-stat-copy">{{ $supportingText }}</p>
            @endif
        </div>
    @endif
</article>
