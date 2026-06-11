@props([
    'title' => null,
    'description' => null,
    'href' => null,
    'variant' => 'static',
    'selected' => false,
    'expanded' => false,
    'disabled' => false,
    'density' => 'standard',
])

@php
    $isLink = filled($href) && ! $disabled;
    $classes = [
        'block rounded-lg border p-4 transition',
        'p-3' => $density === 'compact',
        'opacity-60' => $disabled,
    ];
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        {{ $attributes->class($classes) }}
        style="border-color: var(--ui-border-subtle-01); background-color: {{ $selected ? 'var(--ui-layer-selected-01)' : 'var(--ui-layer-01)' }};"
        data-ui-component="tile"
        data-ui-tile-variant="{{ $variant }}"
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
    >
        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $title ?? $slot }}</p>
        @if ($description)
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $description }}</p>
        @endif
    </a>
@else
    <div
        {{ $attributes->class($classes) }}
        style="border-color: var(--ui-border-subtle-01); background-color: {{ $selected ? 'var(--ui-layer-selected-01)' : 'var(--ui-layer-01)' }};"
        data-ui-component="tile"
        data-ui-tile-variant="{{ $variant }}"
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
        data-ui-tile-expanded="{{ $expanded ? 'true' : 'false' }}"
        @if($disabled) aria-disabled="true" @endif
    >
        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $title ?? $slot }}</p>
        @if ($description)
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $description }}</p>
        @endif
        @isset($details)
            <div class="mt-3" @if(! $expanded) hidden @endif>{{ $details }}</div>
        @endisset
    </div>
@endif
