@props([
    'title' => null,
    'description' => null,
    'meta' => null,
    'href' => null,
    'selected' => false,
    'current' => false,
    'disabled' => false,
])

@php
    $isInteractive = filled($href) && ! $disabled;
    $baseClasses = ['ui-contained-list-item'];
@endphp

@if ($isInteractive)
    <a
        href="{{ $href }}"
        {{ $attributes->class($baseClasses) }}
        data-ui-component="contained-list-item"
        data-ui-contained-list-item
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
        @if($current) aria-current="page" @endif
    >
        <span class="ui-contained-list-item-content">
            <span class="ui-contained-list-item-title">{{ $title ?? $slot }}</span>
            @if ($description)
                <span class="ui-contained-list-item-description">{{ $description }}</span>
            @endif
        </span>
        @if ($meta)
            <span class="ui-contained-list-item-meta">{{ $meta }}</span>
        @endif
    </a>
@else
    <div
        {{ $attributes->class($baseClasses) }}
        data-ui-component="contained-list-item"
        data-ui-contained-list-item
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
        @if($current) aria-current="page" @endif
        @if($disabled) aria-disabled="true" @endif
    >
        <span class="ui-contained-list-item-content">
            <span class="ui-contained-list-item-title">{{ $title ?? $slot }}</span>
            @if ($description)
                <span class="ui-contained-list-item-description">{{ $description }}</span>
            @endif
        </span>
        @if ($meta)
            <span class="ui-contained-list-item-meta">{{ $meta }}</span>
        @endif
    </div>
@endif
