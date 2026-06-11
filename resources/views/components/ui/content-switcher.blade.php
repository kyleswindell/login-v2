@props([
    'options' => [],
    'value' => null,
    'label' => 'Content switcher',
    'size' => 'md',
    'showPanels' => true,
])

@php
    $normalizedOptions = collect($options)->values();
    $resolvedSize = in_array($size, ['sm', 'md'], true) ? $size : 'md';
    $idBase = 'content-switcher-'.substr(md5(json_encode($options).$label.$resolvedSize), 0, 8);
    $selectedIndex = $normalizedOptions->search(function ($option) use ($value) {
        if ($value !== null) {
            return (string) ($option['value'] ?? $option['id'] ?? '') === (string) $value;
        }

        return (bool) ($option['selected'] ?? false);
    });

    if ($selectedIndex === false) {
        $selectedIndex = max(0, $normalizedOptions->search(fn ($option) => ! (bool) ($option['disabled'] ?? false)));
    }

    if ($selectedIndex === false) {
        $selectedIndex = 0;
    }

    $selectedIndex = (int) $selectedIndex;
@endphp

<div
    {{ $attributes->class([
        'ui-content-switcher',
        'ui-content-switcher-sm' => $resolvedSize === 'sm',
    ]) }}
    data-ui-component="content-switcher"
    data-ui-content-switcher
    data-ui-content-switcher-size="{{ $resolvedSize }}"
>
    <div class="ui-content-switcher-list" role="tablist" aria-label="{{ $label }}" data-ui-content-switcher-list>
        @foreach ($normalizedOptions as $index => $option)
            @php
                $optionId = $option['id'] ?? $idBase.'-option-'.$index;
                $panelId = $option['panel_id'] ?? $idBase.'-panel-'.$index;
                $selected = (int) $index === $selectedIndex;
                $disabled = (bool) ($option['disabled'] ?? false);
            @endphp
            <button
                id="{{ $optionId }}"
                type="button"
                class="ui-content-switcher-option"
                role="tab"
                aria-selected="{{ $selected ? 'true' : 'false' }}"
                aria-controls="{{ $panelId }}"
                tabindex="{{ $selected ? '0' : '-1' }}"
                @disabled($disabled)
                data-ui-content-switcher-option
                data-ui-content-switcher-value="{{ $option['value'] ?? $optionId }}"
            >
                @if (filled($option['icon'] ?? null))
                    <x-dynamic-component :component="$option['icon']" class="ui-content-switcher-icon" aria-hidden="true" />
                @endif
                @if (! ($option['icon_only'] ?? false))
                    <span class="ui-content-switcher-label">{{ $option['label'] }}</span>
                @else
                    <span class="sr-only">{{ $option['label'] }}</span>
                @endif
            </button>
        @endforeach
    </div>

    @if ($showPanels)
        <div class="ui-content-switcher-panels">
            @foreach ($normalizedOptions as $index => $option)
                @php
                    $optionId = $option['id'] ?? $idBase.'-option-'.$index;
                    $panelId = $option['panel_id'] ?? $idBase.'-panel-'.$index;
                    $selected = (int) $index === $selectedIndex;
                @endphp
                <section
                    id="{{ $panelId }}"
                    class="ui-content-switcher-panel"
                    role="tabpanel"
                    aria-labelledby="{{ $optionId }}"
                    tabindex="0"
                    data-ui-content-switcher-panel
                    @if (! $selected) hidden @endif
                >
                    <h4 class="ui-content-switcher-panel-title">{{ $option['panel_title'] ?? $option['label'] }}</h4>
                    <p>{{ $option['panel'] ?? 'The selected peer view changes without leaving the current workflow.' }}</p>
                </section>
            @endforeach
        </div>
    @endif
</div>
