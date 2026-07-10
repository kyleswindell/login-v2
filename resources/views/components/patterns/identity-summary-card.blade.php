@props([
    'name',
    'subtitle' => null,
    'avatarUrl' => null,
    'initials' => null,
    'meta' => [],
    'statusLabel' => null,
    'statusSemantic' => 'neutral',
    'variant' => 'standard',
])

@php
    $resolvedVariant = in_array($variant, ['compact', 'standard', 'detailed'], true) ? $variant : 'standard';
    $metaEntries = collect(is_array($meta) ? $meta : [$meta])
        ->filter(fn ($value) => filled($value))
        ->values()
        ->all();
@endphp

<article {{ $attributes->class(['ui-pattern-identity-summary', 'ui-pattern-identity-summary-'.$resolvedVariant])->merge(['data-ui-pattern' => 'identity-summary-card']) }}>
    <div class="ui-pattern-identity-summary-main">
        <div class="ui-pattern-identity-summary-avatar" aria-hidden="true">
            @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="" class="h-full w-full object-cover" />
            @else
                <span>{{ $initials ?: 'NA' }}</span>
            @endif
        </div>

        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="ui-pattern-identity-summary-title">{{ $name }}</h3>
                    @if ($subtitle)
                        <p class="ui-pattern-identity-summary-subtitle">{{ $subtitle }}</p>
                    @endif
                </div>

                @if ($statusLabel)
                    <x-ui.tag
                        :label="$statusLabel"
                        :tone="match ($statusSemantic) {
                            'success' => 'success',
                            'warning' => 'warning',
                            'danger' => 'danger',
                            'info', 'notice' => 'notice',
                            default => 'neutral',
                        }"
                        size="sm"
                    />
                @endif
            </div>

            @if ($metaEntries !== [])
                <div class="ui-pattern-compact-meta ui-pattern-identity-summary-meta">
                    @foreach ($metaEntries as $entry)
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

        @isset($actions)
            <div class="ui-pattern-identity-summary-actions">
                {{ $actions }}
            </div>
        @endisset
    </div>

    @if ($slot->isNotEmpty())
        <div class="ui-pattern-identity-summary-body">
            {{ $slot }}
        </div>
    @endif
</article>
