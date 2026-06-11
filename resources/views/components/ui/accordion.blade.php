@props([
    'items' => [],
    'id' => null,
    'variant' => 'default',
    'size' => 'default',
    'mode' => 'multiple',
    'scrollable' => false,
    'panelMaxHeight' => '16rem',
])

@php
    $id = $id ?? 'ui-accordion-'.Str::random(8);
    $resolvedVariant = in_array($variant, ['default', 'contained'], true) ? $variant : 'default';
    $resolvedSize = in_array($size, ['default', 'compact'], true) ? $size : 'default';
    $resolvedMode = in_array($mode, ['multiple', 'single'], true) ? $mode : 'multiple';
@endphp

<div
    {{ $attributes->class([
        'ui-accordion',
        'ui-accordion-contained' => $resolvedVariant === 'contained',
        'ui-accordion-compact' => $resolvedSize === 'compact',
        'ui-accordion-scrollable' => $scrollable,
    ])->merge([
        'data-ui-component' => 'accordion',
        'data-ui-accordion' => $id,
        'data-ui-accordion-mode' => $resolvedMode,
        'style' => $scrollable ? '--ui-accordion-panel-max-height: '.$panelMaxHeight.';' : null,
    ]) }}
>
    @foreach ($items as $index => $item)
        @php
            $itemId = $item['id'] ?? $id.'-item-'.$index;
            $panelId = $item['panel_id'] ?? $itemId.'-panel';
            $triggerId = $item['trigger_id'] ?? $itemId.'-trigger';
            $isOpen = (bool) ($item['open'] ?? false);
            $isDisabled = (bool) ($item['disabled'] ?? false);
        @endphp

        <section class="ui-accordion-item" data-ui-accordion-item>
            <h3 class="ui-accordion-heading">
                <button
                    id="{{ $triggerId }}"
                    type="button"
                    class="ui-accordion-trigger"
                    aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                    aria-controls="{{ $panelId }}"
                    data-ui-accordion-trigger
                    @disabled($isDisabled)
                >
                    <span class="min-w-0">
                        <span class="ui-accordion-title">{{ $item['title'] ?? 'Accordion item' }}</span>
                        @if (filled($item['meta'] ?? null))
                            <span class="ui-accordion-meta">{{ $item['meta'] }}</span>
                        @endif
                    </span>
                    <svg class="ui-accordion-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </h3>

            <div
                id="{{ $panelId }}"
                class="ui-accordion-panel"
                role="region"
                aria-labelledby="{{ $triggerId }}"
                data-ui-accordion-panel
                data-ui-accordion-panel-open="{{ $isOpen ? 'true' : 'false' }}"
                @if (! $isOpen) hidden @endif
            >
                <div class="ui-accordion-body">
                    @if (isset($item['body']) && $item['body'] instanceof \Illuminate\Support\HtmlString)
                        {!! $item['body'] !!}
                    @else
                        <p>{{ $item['body'] ?? '' }}</p>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
</div>
