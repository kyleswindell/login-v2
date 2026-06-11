@props([
    'tabs' => [],
    'variant' => 'line',
    'orientation' => 'horizontal',
    'activation' => 'automatic',
    'scrollable' => false,
    'gridAware' => false,
])

@php
    $resolvedVariant = in_array($variant, ['line', 'contained'], true) ? $variant : 'line';
    $resolvedOrientation = in_array($orientation, ['horizontal', 'vertical'], true) ? $orientation : 'horizontal';
    $resolvedActivation = in_array($activation, ['automatic', 'manual'], true) ? $activation : 'automatic';
    $idBase = 'tabs-'.substr(md5(json_encode($tabs).$resolvedVariant.$resolvedOrientation), 0, 8);
    $normalizedTabs = collect($tabs)->values();
    $selectedIndex = max(0, $normalizedTabs->search(fn ($tab) => (bool) ($tab['selected'] ?? false)));
    if ($selectedIndex === false) {
        $selectedIndex = 0;
    }
@endphp

<div
    {{ $attributes->class([
        'ui-tabs',
        'ui-tabs-contained' => $resolvedVariant === 'contained',
        'ui-tabs-vertical' => $resolvedOrientation === 'vertical',
        'ui-tabs-scrollable' => $scrollable,
        'ui-tabs-grid-aware' => $gridAware,
    ]) }}
    data-ui-component="tabs"
    data-ui-tabs
    data-ui-tabs-activation="{{ $resolvedActivation }}"
>
    <div class="ui-tabs-list" role="tablist" aria-orientation="{{ $resolvedOrientation }}">
        @foreach ($normalizedTabs as $index => $tab)
            @php
                $tabId = $tab['id'] ?? $idBase.'-tab-'.$index;
                $panelId = $tab['panel_id'] ?? $idBase.'-panel-'.$index;
                $selected = $index === $selectedIndex;
                $disabled = (bool) ($tab['disabled'] ?? false);
            @endphp
            <button
                id="{{ $tabId }}"
                type="button"
                class="ui-tabs-tab"
                role="tab"
                aria-selected="{{ $selected ? 'true' : 'false' }}"
                aria-controls="{{ $panelId }}"
                tabindex="{{ $selected ? '0' : '-1' }}"
                @disabled($disabled)
                data-ui-tabs-tab
                @if ($tab['dismissible'] ?? false) data-ui-tabs-dismissible="true" @endif
            >
                @if (filled($tab['icon'] ?? null))
                    <span class="ui-tabs-tab-icon" aria-hidden="true">{{ $tab['icon'] }}</span>
                @endif
                @if (! ($tab['icon_only'] ?? false))
                    <span class="ui-tabs-tab-label">{{ $tab['label'] }}</span>
                @else
                    <span class="sr-only">{{ $tab['label'] }}</span>
                @endif
                @if (filled($tab['secondary'] ?? null))
                    <span class="ui-tabs-tab-secondary">{{ $tab['secondary'] }}</span>
                @endif
                @if ($tab['dismissible'] ?? false)
                    <span class="ui-tabs-tab-dismiss" aria-hidden="true">x</span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="ui-tabs-panels">
        @foreach ($normalizedTabs as $index => $tab)
            @php
                $tabId = $tab['id'] ?? $idBase.'-tab-'.$index;
                $panelId = $tab['panel_id'] ?? $idBase.'-panel-'.$index;
                $selected = $index === $selectedIndex;
            @endphp
            <section
                id="{{ $panelId }}"
                class="ui-tabs-panel"
                role="tabpanel"
                aria-labelledby="{{ $tabId }}"
                tabindex="0"
                data-ui-tabs-panel
                @if (! $selected) hidden @endif
            >
                <h4 class="ui-tabs-panel-title">{{ $tab['panel_title'] ?? $tab['label'] }}</h4>
                <p>{{ $tab['panel'] ?? 'Panel content changes when the selected tab changes.' }}</p>
            </section>
        @endforeach
    </div>
</div>
