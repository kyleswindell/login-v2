@props([
    'items' => [],
    'id' => null,
    'variant' => 'default',
    'alignment' => 'default',
    'iconAlignment' => 'end',
    'size' => 'default',
    'mode' => 'multiple',
    'scrollable' => false,
    'panelMaxHeight' => '16rem',
])

@php
    $id = $id ?? 'ui-accordion-'.Str::random(8);
    $resolvedVariant = in_array($variant, ['default', 'contained'], true) ? $variant : 'default';
    $resolvedAlignment = in_array($alignment, ['default', 'flush'], true) ? $alignment : 'default';
    $resolvedIconAlignment = in_array($iconAlignment, ['end', 'start'], true) ? $iconAlignment : 'end';
    $resolvedSize = in_array($size, ['default', 'compact'], true) ? $size : 'default';
    $resolvedMode = in_array($mode, ['multiple', 'single'], true) ? $mode : 'multiple';
@endphp

<div
    {{ $attributes->class([
        'ui-accordion',
        'ui-accordion-contained' => $resolvedVariant === 'contained',
        'ui-accordion-flush' => $resolvedAlignment === 'flush',
        'ui-accordion-icon-start' => $resolvedIconAlignment === 'start',
        'ui-accordion-compact' => $resolvedSize === 'compact',
        'ui-accordion-scrollable' => $scrollable,
    ])->merge([
        'data-ui-component' => 'accordion',
        'data-ui-accordion' => $id,
        'data-ui-accordion-mode' => $resolvedMode,
        'data-ui-accordion-alignment' => $resolvedAlignment,
        'data-ui-accordion-icon-alignment' => $resolvedIconAlignment,
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

        <section class="ui-accordion-item" data-ui-accordion-item data-ui-accordion-item-open="{{ $isOpen ? 'true' : 'false' }}">
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
                    @if ($resolvedIconAlignment === 'start')
                        <x-heroicon-o-chevron-down class="ui-accordion-icon" aria-hidden="true" />
                    @endif
                    <span class="ui-accordion-label">
                        <span class="ui-accordion-title">{{ $item['title'] ?? 'Accordion item' }}</span>
                        @if (filled($item['meta'] ?? null))
                            <span class="ui-accordion-meta">{{ $item['meta'] }}</span>
                        @endif
                    </span>
                    @if ($resolvedIconAlignment === 'end')
                        <x-heroicon-o-chevron-down class="ui-accordion-icon" aria-hidden="true" />
                    @endif
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
