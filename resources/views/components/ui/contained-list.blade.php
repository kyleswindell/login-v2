@props([
    'title' => null,
    'description' => null,
    'items' => [],
    'variant' => 'on-page',
    'size' => 'md',
    'loading' => false,
    'emptyTitle' => 'No items',
    'emptyDescription' => null,
])

@php
    $variant = in_array($variant, ['on-page', 'disclosed', 'elevated'], true) ? $variant : 'on-page';
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
@endphp

<section
    {{ $attributes->class(['ui-contained-list']) }}
    data-ui-component="contained-list"
    data-ui-contained-list
    data-ui-contained-list-variant="{{ $variant }}"
    data-ui-contained-list-size="{{ $size }}"
    @if($loading) aria-busy="true" @endif
>
    @if ($title || $description)
        <header class="ui-contained-list-header">
            @if ($title)
                <h3 class="ui-contained-list-title">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="ui-contained-list-description">{{ $description }}</p>
            @endif
        </header>
    @endif

    <div class="ui-contained-list-body" data-ui-contained-list-body>
        @if ($loading)
            <div class="ui-contained-list-state" data-ui-contained-list-loading>
                Loading list items
            </div>
        @elseif (! empty($items))
            @foreach ($items as $item)
                <x-ui.contained-list-item
                    :title="data_get($item, 'title')"
                    :description="data_get($item, 'description')"
                    :meta="data_get($item, 'meta')"
                    :href="data_get($item, 'href')"
                    :selected="(bool) data_get($item, 'selected', false)"
                    :current="(bool) data_get($item, 'current', false)"
                    :disabled="(bool) data_get($item, 'disabled', false)"
                />
            @endforeach
        @elseif (trim((string) $slot) !== '')
            {{ $slot }}
        @else
            <div class="ui-contained-list-state" data-ui-contained-list-empty>
                <p class="ui-contained-list-state-title">{{ $emptyTitle }}</p>
                @if ($emptyDescription)
                    <p class="ui-contained-list-state-description">{{ $emptyDescription }}</p>
                @endif
            </div>
        @endif
    </div>
</section>
