@props([
    'title',
    'description',
    'icon' => 'heroicon-o-inbox',
])

<div {{ $attributes->class(['ui-pattern-empty-state']) }} data-ui-pattern="empty-state">
    <span class="ui-pattern-empty-state-icon" aria-hidden="true">
        <x-dynamic-component :component="$icon" class="h-6 w-6" />
    </span>
    <div class="mt-4">
        <h3 class="ui-pattern-empty-state-title">{{ $title }}</h3>
        <p class="ui-pattern-empty-state-copy">{{ $description }}</p>
    </div>

    @isset($actions)
        <div class="ui-pattern-empty-state-actions">
            {{ $actions }}
        </div>
    @endisset
</div>
